<?php
/* -----------------------------------------------------------------------------------------
$Id: checkout_payment.php,v 1.1.1.1.2.1 2007/04/08 07:16:09 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(checkout_payment.php,v 1.110 2003/03/14); www.oscommerce.com
(c) 2003	    nextcommerce (checkout_payment.php,v 1.20 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:
agree_conditions_1.01        	Autor:	Thomas Plänkers (webmaster@oscommerce.at)

Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include('includes/application_top.php');

// if the customer is not logged on, redirect them to the login page
if (!ISSET_CUSTOMER_ID)
{
	$_SESSION['navigation']->set_snapshot(array('mode' => SSL, 'page' => FILENAME_CHECKOUT_SHIPPING));
	olc_redirect(olc_href_link(FILENAME_LOGIN, EMPTY_STRING, SSL));
}
// if there is nothing in the customers cart, redirect them to the shopping cart page
elseif ($_SESSION['cart']->count_contents() < 1) {
	olc_redirect(olc_href_link(FILENAME_SHOPPING_CART));
}
// if no shipping method has been selected, redirect the customer to the shipping method selection page
elseif (!isset($_SESSION['shipping']))
{
	olc_redirect(olc_href_link(FILENAME_CHECKOUT_SHIPPING, EMPTY_STRING, SSL));
}
// avoid hack attempts during the checkout procedure by checking the internal cartID
$session_cartID=$_SESSION['cartID'];
if ($session_cartID)
{
	$session_cart_cartID=$_SESSION['cart']->cartID;
	if ($session_cart_cartID)
	{
		if ($session_cartID != $session_cart_cartID)
		{
			olc_redirect(olc_href_link(FILENAME_CHECKOUT_SHIPPING, EMPTY_STRING, SSL));
		}
	}
}
// include needed functions
require_once(DIR_FS_INC.'olc_image_button.inc.php');
require_once(DIR_FS_INC.'olc_address_label.inc.php');
require_once(DIR_FS_INC.'olc_get_address_format_id.inc.php');
require_once(DIR_FS_INC.'olc_draw_radio_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_textarea_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
require_once(DIR_FS_INC.'olc_check_stock.inc.php');

unset($_SESSION['paypal_payment']);
unset($_SESSION['credit_covers']);  //ICW ADDED FOR CREDIT CLASS SYSTEM
// Stock Check
if (STOCK_CHECK == TRUE_STRING_S)
{
	if (STOCK_ALLOW_CHECKOUT != TRUE_STRING_S)
	{
		$products = $_SESSION['cart']->get_products();
		$any_out_of_stock = 0;
		for ($i=0, $n=sizeof($products); $i<$n; $i++) {
			if (olc_check_stock($products[$i]['id'], $products[$i]['quantity'])) {
				$any_out_of_stock = 1;
			}
		}
		if ($any_out_of_stock == 1) {
			olc_redirect(olc_href_link(FILENAME_SHOPPING_CART));
		}
	}
}
//---PayPal WPP Modification START ---//
$ec_enabled=olc_paypal_wpp_enabled();
if ($ec_enabled)
{
	if ($_SESSION['paypal_error'])
	{
		$checkout_login = true;
		$messageStack->add('payment', $paypal_error);
		unset($_SESSION['paypal_error']);
	}
}
//---PayPal WPP Modification END ---//

// if no billing destination address was selected, use the customers own address as default
if (isset($_SESSION['billto']))
{
	// verify the selected billing address
	$check_address_query = olc_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK .
	" where customers_id = '" . CUSTOMER_ID .	"' and address_book_id = '" . (int)$_SESSION['billto'] . APOS);
	$check_address = olc_db_fetch_array($check_address_query);
	if ($check_address['total'] != '1')
	{
		$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
		if (isset($_SESSION['payment'])) unset($_SESSION['payment']);
	}
}
else
{
	$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
}

require_once(DIR_WS_CLASSES . 'order.php');
$order = new order;

require_once(DIR_WS_CLASSES . 'order_total.php');// GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
$order_total_modules = new order_total;// GV Code ICW ADDED FOR CREDIT CLASS SYSTEM

$total_weight = $_SESSION['cart']->show_weight();

//  $total_count = $_SESSION['cart']->count_contents();
$total_count = $_SESSION['cart']->count_contents_virtual(); // GV Code ICW ADDED FOR CREDIT CLASS SYSTEM

if ($order->billing['country']['iso_code_2'] != EMPTY_STRING) {
	$_SESSION['delivery_zone'] = $order->billing['country']['iso_code_2'];
}
// load all enabled payment modules
require_once(DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment;

$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_PAYMENT, olc_href_link(FILENAME_CHECKOUT_SHIPPING, EMPTY_STRING, SSL));
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_PAYMENT, olc_href_link(FILENAME_CHECKOUT_PAYMENT, EMPTY_STRING, SSL));

//W. Kaiser - AJAX
$checkout_payment_text='checkout_payment';
$smarty->assign('FORM_ACTION',olc_draw_form($checkout_payment_text, olc_href_link(FILENAME_CHECKOUT_CONFIRMATION, EMPTY_STRING, SSL), 'post', 'onsubmit="return check_form_payment(\''.$checkout_payment_text.'\');"'));
//W. Kaiser - AJAX

//---PayPal WPP Modification START ---//--
if (!$ec_enabled || $_GET['ec_cancel'] ||	(!($_SESSION['paypal_ec_payer_id'] || $_SESSION['paypal_ec_payer_info'])))
{
	//---PayPal WPP Modification END ---//--
	$smarty->assign('ADDRESS_LABEL',olc_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, BLANK, HTML_BR));

	$smarty->assign('BUTTON_ADDRESS',HTML_A_START.olc_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS,EMPTY_STRING,SSL).'">'.
	olc_image_button('button_change_address.gif', IMAGE_BUTTON_CHANGE_ADDRESS) . HTML_A_END);

	$smarty->assign('BUTTON_CONTINUE',olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));

	require(DIR_WS_INCLUDES . 'header.php');

	if (isset($_GET['payment_error']) && is_object(${$_GET['payment_error']}) &&
	($error = ${$_GET['payment_error']}->get_error()))
	{
		$smarty->assign('error','<table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBoxNotice">
          <tr class="infoBoxNoticeContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" width="100%" valign="top">'. htmlspecialchars($error['error']).'</td>
              </tr>
            </table></td>
          </tr>
        </table>');
	}
	$payment_block .= '
				<table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td>
            	<table border="0" width="100%" cellspacing="0" cellpadding="2">';
	$selection = $payment_modules->selection();
	//	W. Kaiser
	$OptionBoxRight =false;	// true;	//Optionbox position: true-> on right side, false-> on right side
	//W. Kaiser - AJAX
	$ShowHideInputPaymentFields_text='ShowHideInputPaymentFields(';
	$ShowHideBankTransferFields0=$ShowHideInputPaymentFields_text.'false,';
	$ShowHideBankTransferFields0=$ShowHideBankTransferFields0.'true);'.$ShowHideBankTransferFields0.'false);';
	$session_payment=$_SESSION['payment'];
	if (!$session_payment)
	{
		$session_payment=$selection[0]['id'];
	}
	$radio_buttons = 0;
	for ($i=0, $n=sizeof($selection); $i<$n; $i++)
	{
		$this_selection=$selection[$i];
		$current_selection_id = $this_selection['id'];
		$is_session_payment=$current_selection_id == $session_payment;
		$is_banktransfer=$current_selection_id=="banktransfer";
		$have_multiple_payments=sizeof($selection) > 1;
		$is_paypal_direct=$current_selection_id=="paypal_wpp";
		$style_display="inline";
		$show=$is_banktransfer || $is_paypal_direct;
		if ($show)
		{
			$show_fields="true";
			if ($is_banktransfer)
			{
				$is_banktransfer=TRUE_STRING_S;
			}
			else
			{
				$is_banktransfer=FALSE_STRING_S;
			}
			if ($have_multiple_payments)
			{
				if (!$is_session_payment)
				{
					$style_display="none";
				}
			}
		}
		else
		{
			$show_fields="false";
		}
		$ShowHideBankTransferFields=$ShowHideBankTransferFields0;
		if ($show)
		{
			$ShowHideBankTransferFields.=$ShowHideInputPaymentFields_text.$show_fields.COMMA.$is_banktransfer.");";
		}
		$payment_block .= '
	              <tr>
	                <td colspan="2">
	                	<table border="0" width="100%" cellspacing="0" cellpadding="2">
';
		$payment_block_text=
		' onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"
	onclick="javascript:'.$ShowHideBankTransferFields.';selectRowEffect(this, ' . $radio_buttons . ')" >' . NEW_LINE;
		if (($current_selection_id == $payment) || ($n == 1) )
		{
			$payment_block .=
'                  <tr id="defaultSelected" class="moduleRowSelected"'.$payment_block_text;
		}
		else
		{
			$payment_block .=
'                  <tr class="moduleRow"'.$payment_block_text;
		}

		if ($OptionBoxRight)
		{
			$payment_block .= '
	                 	<td class="main" colspan="3" valign="top"><b>'. $this_selection['module'].'</b></td>
';
		}
		$payment_block .= '
	                  <td class="main" align="left" width="3%">
';
		if ($have_multiple_payments) 
        {
			$payment_block .=
			olc_draw_radio_field('payment', $current_selection_id, $is_session_payment,
			'onclick="javascript:'.$ShowHideBankTransferFields.QUOTE);
		} 
        else 
        {
			$payment_block .=  olc_draw_hidden_field('payment', $current_selection_id);
		}

		$payment_block .= '
                </td>
';
		if (!$OptionBoxRight)
		{
			$payment_block .= '
                    <td class="main" colspan="3" align="left"><b>'. $this_selection['module'].'</b></td>
                  ';
		}
		$payment_block .= '
                  </tr>
				    <tr>
					    <td class="main" colspan="3">&nbsp;</td>
				    </tr>
';
		//	W. Kaiser

		if (isset($this_selection['error'])) {
			$payment_block .= '
                  <tr>
                    <td class="main" colspan="4">'.$this_selection['error'].'</td>
                  </tr>
';
		} else {
			$payment_block .= '
                  <tr>
                  	<td></td>
                    <td colspan="3">
                    	<span id="'.$current_selection_id.'" style="display:'.$style_display.'">
	                    	<table border="0" cellspacing="0" cellpadding="2">
';
			for ($j=0, $n2=sizeof($this_selection['fields']); $j<$n2; $j++) {
				$this_selection_fields=$this_selection['fields'][$j];
				$payment_block .= '
		                      <tr>
		                        <td class="main" valign="top">'. $this_selection_fields['title'].'</td>
		                        <td class="main">'. $this_selection_fields['field'].'</td>
		                      </tr>
';
			}
			$payment_block .= '
	                    	</table>
                    	</span>
                    </td>
                  </tr>
';
			$radio_buttons++;
		}
		$payment_block .= '
                </table></td>
              </tr>
';

	}
	//W. Kaiser - AJAX
	$payment_block .= '
        </table></td>
      </tr>
    </table>';
	if (ACTIVATE_GIFT_SYSTEM==TRUE_STRING_S)
	{
		$payment_block .= $order_total_modules->credit_selection();
	}
	//---PayPal WPP Modification START ---//--
}
//---PayPal WPP Modification END ---//--

$smarty->assign('PAYMENT_BLOCK',$payment_block);

/*
$smarty->assign('CUSTOMERS_REFERENCE',olc_draw_input_field('customers_order_reference',EMPTY_STRING,'size="40"'));

$smarty->assign('COMMENTS',olc_draw_textarea_field('comments', 'soft', '60', '5', $_SESSION['comments']) . olc_draw_hidden_field('comments_added', 'YES'));

//check if display conditions on checkout page is true
if (DISPLAY_CONDITIONS_ON_CHECKOUT == TRUE_STRING_S)
{
	$shop_content_query=olc_db_query("SELECT
 					content_title,
 					content_heading,
 					content_text,
 					content_file
 					FROM ".TABLE_CONTENT_MANAGER."
 					WHERE content_group='3'
 					AND languages_id='".SESSION_LANGUAGE_ID.APOS);
	$shop_content_data=olc_db_fetch_array($shop_content_query);
	if ($shop_content_data['content_file']==EMPTY_STRING)
	{
		$file='cache/cache/agb'.HTML_EXT;
		if (file_exists($file))
		{
			//Write file only once a day!
//			$last_modified = filemtime($file);
//			$now = time();
//			$today = mktime(0, 0, 0, date("m", $now) , date("d", $now), date("Y", $now));
//			$write_file=$last_modified>$today or $last_modified > $now;
//			$table_status_query="show table status like '".TABLE_CONTENT_MANAGER.APOS;
			$table_status=olc_db_query($table_status_query);
			$table_status=olc_db_fetch_array($table_status);
			$update_time=$table_status['Update_time'];
			if ($update_time)
			{
				$update_time=strtotime($update_time);
				$write_file=$update_time>$last_modified;
			}
			else
			{
				$write_file=true;
			}
		}
		else
		{
			$write_file=true;
		}
		if ($write_file)
		{
			$style='
			<link rel="stylesheet" type="text/css" href="'.$server.DIR_WS_CATALOG.FULL_CURRENT_TEMPLATE.'stylesheet.css">
';
			$text=$shop_content_data['content_text'];
			file_put_contents($file,$style.$text);
		}
	}
	else
	{
		$file='media/content/'.$shop_content_data['content_file'];
	}
	$conditions= '<iframe allowtransparency="true" SRC="'.$file.'" width="100%" height="300">';
	$conditions.= '</iframe>';
	$smarty->assign('AGB',$conditions);
	// W. Kaiser
}
$smarty->assign('AGB_checkbox',olc_draw_checkbox_field('conditions'));
$checkout_payment='checkout_payment';
$accept_agb='accept_agb';
$s=olc_get_smarty_config_variable($smarty,$checkout_payment,'text_'.$accept_agb);
$smarty->assign(strtoupper($accept_agb),str_replace(ATSIGN,SESSION_LANGUAGE,$s));
// W. Kaiser
$smarty->assign('FERNAG_checkbox',olc_draw_checkbox_field('fernag'));
$accept_fernag='accept_fernag';
$s=olc_get_smarty_config_variable($smarty,$checkout_payment,'text_'.$accept_fernag);
$smarty->assign(strtoupper($accept_fernag),str_replace(ATSIGN,SESSION_LANGUAGE,$s));
*/
$error_message=$_GET['error_message'];
if ($error_message)
{
	$smarty->assign('error',nl2br($error_message));
}
require(BOXES);
$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'checkout_payment'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
$smarty->display(INDEX_HTML);
?>