<?php
/* -----------------------------------------------------------------------------------------
$Id: checkout_confirmation.php,v 1.1.1.1.2.1 2007/04/08 07:16:09 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(checkout_confirmation.php,v 1.137 2003/05/07); www.oscommerce.com
(c) 2003	    nextcommerce (checkout_confirmation.php,v 1.21 2003/08/17); www.nextcommerce.org
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

// include needed functions
require_once(DIR_FS_INC.'olc_calculate_tax.inc.php');
require_once(DIR_FS_INC.'olc_check_stock.inc.php');
require_once(DIR_FS_INC.'olc_display_tax_value.inc.php');
require_once(DIR_FS_INC.'olc_get_products_attribute_price_checkout.inc.php');
require_once(DIR_FS_INC.'olc_draw_textarea_field.inc.php');

// if the customer is not logged on, redirect them to the login page
$cart=$_SESSION['cart'];
if (!ISSET_CUSTOMER_ID)
{
	$_SESSION['navigation']->set_snapshot(array('mode' => SSL, 'page' => FILENAME_CHECKOUT_SHIPPING));
	olc_redirect(olc_href_link(FILENAME_LOGIN, EMPTY_STRING, SSL));
}
// if there is nothing in the customers cart, redirect them to the shopping cart page
elseif ($cart->count_contents() < 1)
{
	olc_redirect(olc_href_link(FILENAME_SHOPPING_CART));
}
// avoid hack attempts during the checkout procedure by checking the internal cartID
elseif ($cart->cartID != $_SESSION['cartID'])
{
	olc_redirect(olc_href_link(FILENAME_CHECKOUT_SHIPPING, EMPTY_STRING, SSL));
}
// if no shipping method has been selected, redirect the customer to the shipping method selection page
elseif (!isset($_SESSION['shipping'])) {
	olc_redirect(olc_href_link(FILENAME_CHECKOUT_SHIPPING, EMPTY_STRING, SSL));
}
//check if display conditions on checkout page is true
if (!isset($_SESSION['payment']))
{
	$_SESSION['payment'] = $_POST['payment'];
}
//Get all POST-vars into variables! Payment modules rely on register globals ON, which might not be true!!!
//So we create the variables ourselves
foreach($_POST as $key => $value)
{
	$$key = strip_tags($value);
	global $$key;
}
foreach($_GET as $key => $value)
{
	$$key = strip_tags($value);
	global $$key;
}
$_SESSION['customers_order_reference'] = $_POST['customers_order_reference'];
$comments=$_POST['comments'];
if ($comments)
{
	$_SESSION['comments'] = olc_db_prepare_input($comments);
}
unset($_SESSION['paypal_payment']);
//-- TheMedia Begin check if display conditions on checkout page is true
if (isset($_POST['cot_gv']))
{
	$_SESSION['cot_gv'] = true;
}
//---PayPal WPP Modification START ---//
//	W. Kaiser
$ec_enabled=olc_paypal_wpp_enabled();
if ($ec_enabled)
{
	$show_payment_page = MODULE_PAYMENT_PAYPAL_DP_DISPLAY_PAYMENT_PAGE=='Yes';
	if (!(
	$_SESSION['paypal_ec_token'] or
	$_SESSION['paypal_ec_payer_id'] or
	$_SESSION['paypal_ec_payer_info']))
	{
		$ec_checkout = false;
		$show_payment_page = true;
	}
	else
	{
		$ec_checkout = true;
	}
}
//	W. Kaiser
//---PayPal WPP Modification END ---//

$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION,olc_href_link(FILENAME_CHECKOUT_SHIPPING, EMPTY_STRING, SSL));
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION);

// GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
require_once(DIR_WS_CLASSES . 'order_total.php');
require_once(DIR_WS_CLASSES . 'order.php');
$order = new order;

//	W. Kaiser

// GV Code Start
$order_total_modules = new order_total;
$order_total_modules->collect_posts();
$order_total_modules->pre_confirmation_check();
// GV Code End

//	W. Kaiser
$credit_covers=$_SESSION['credit_covers']=='1';
if ($credit_covers)
{
	$_SESSION['payment'] = 'no_payment'; // GV Code Start/End ICW added for CREDIT CLASS
}

// load the selected payment module
require_once(DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment($_SESSION['payment']);
$payment_modules->update_status();

//	W. Kaiser

// GV Code line changed
if ((is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && (!is_object($$_SESSION['payment']))  && (!isset($_SESSION['credit_covers']))) || (is_object($$_SESSION['payment']) && (!$$_SESSION['payment']->enabled)))
{
	olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), SSL));
}
if (is_array($payment_modules->modules))
{
	$payment_modules->pre_confirmation_check();
}

// load the selected shipping module
require_once(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping($_SESSION['shipping']);

// Stock Check
$any_out_of_stock = false;
if (STOCK_CHECK == TRUE_STRING_S)
{
	for ($i=0, $n=sizeof($order->products); $i<$n; $i++)
	{
		$order_products=$order->products[$i];
		if (olc_check_stock($order_products['id'], $order_products['qty']))
		{
			$any_out_of_stock = true;
			break;
		}
	}
	// Out of Stock
	if (STOCK_ALLOW_CHECKOUT != TRUE_STRING_S)
	{
		if ($any_out_of_stock)
		{
			olc_redirect(olc_href_link(FILENAME_SHOPPING_CART));
		}
	}
}

require(DIR_WS_INCLUDES . 'header.php');

//
// Kunden-IP-Adresse
//
olc_get_ip_info($smarty);
//
// Kunden-IP-Adresse
//

$smarty->assign('DELIVERY_LABEL',olc_address_format($order->delivery['format_id'], $order->delivery, 1, BLANK, HTML_BR));
$smarty->assign('PRODUCTS_EDIT',olc_href_link(FILENAME_SHOPPING_CART, EMPTY_STRING, SSL));
//---PayPal WPP Modification START ---//
$use_ec_checkout=$ec_checkout && $ec_enabled;
if (!$credit_covers)
{
	$smarty->assign('BILLING_LABEL',olc_address_format($order->billing['format_id'],
	$order->billing, 1, BLANK, HTML_BR));
	if ($use_ec_checkout)
	{
		$link_billing=$ec_checkout ? MODULE_PAYMENT_PAYPAL_EC_TEXT_TITLE : MODULE_PAYMENT_PAYPAL_DP_TEXT_TITLE;
	}
	else
	{
		$link_billing=olc_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, EMPTY_STRING, SSL);
	}
}
if ($use_ec_checkout)
{
	$link_shipping=olc_href_link(FILENAME_EC_PROCESS, 'clearSess=1', SSL);

}
else
{
	$link_shipping=olc_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, EMPTY_STRING, SSL);
}
$smarty->assign('SHIPPING_ADDRESS_EDIT',$link_shipping);
$smarty->assign('BILLING_ADDRESS_EDIT',$link_billing);
//	---PayPal WPP Modification END ---//--
if (isset($_SESSION['sendto']))
{
	$shipping_method=$order->info['shipping_method'];
	if ($shipping_method)
	{
		$smarty->assign('SHIPPING_METHOD',$shipping_method);
		if ($order->info['shipping_class']!='free')
		{
			$smarty->assign('SHIPPING_EDIT',olc_href_link(FILENAME_CHECKOUT_SHIPPING, EMPTY_STRING, SSL));
		}
	}
}
$data_products =
'				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>&nbsp;</td>
						<td class="main" align="center" valign="top"><b>'.TEXT_PRICE_SINGLE.'</b></td>
						<td class="main" align="center" valign="top"><b>'.TEXT_PRICE_TOTAL.'</b></td>
					</tr>
';
for ($i=0, $n=sizeof($order->products); $i<$n; $i++)
{
	$order_products=$order->products[$i];
	$products_qty=$order_products['qty'];
	$price=olc_get_products_price($order_products['id'],1,$products_qty,$price_real);
	$price=abs($price_real);
	$single_price=olc_format_price($price,true,true);
	if ($products_qty>1)
	{
		$total_price=olc_format_price($price*$products_qty,true,true);
	}
	else
	{
		$total_price=$single_price;
	}
	$data_products .='
					<tr>
						<td class="main" nowrap="nowrap" align="left" valign="top" width="">' .
	$products_qty .' x '. $order_products['name'].
	'						</td>
						<td class="main" align="right" valign="top">' .$single_price.'</td>
						<td class="main" align="right" valign="top">' .$total_price.'</td>
					</tr>
';
	$products_attributes=$order_products['attributes'];
	if (sizeof($products_attributes) > 0)
	{
		for ($j=0, $n2=sizeof($products_attributes); $j<$n2; $j++)
		{
			$products_attribute=$products_attributes[$j];
			$products_attribute_price=$products_attribute['price'];
			if ($products_attribute_price<>0)
			{
				$products_attribute_price_single=olc_get_products_attribute_price_checkout($products_attribute_price,
				$order_products['tax'],1,$products_qty,$products_attribute['prefix']);
				if ($products_qty<>1)
				{
					$products_attribute_price_total=olc_format_price($products_attribute_price*$products_qty,true,true);
				}
				else
				{
					$products_attribute_price_total=$products_attribute_price_single;
				}
			}
			else
			{
				$products_attribute_price=EMPTY_STRING;
			}
			$data_products .=
			'					<tr>
						<td class="main" align="left" valign="top">
							<nobr><small>&nbsp;<i> - ' .
			$products_attribute['option'] . COLON_BLANK .  $products_attribute['value'] .'
							</i></small>
						</td>
						<td class="main" align="right" valign="top"><i><small>'.
			$products_attribute_price_single.
			'							</i></small></nobr>
						</td>
						<td class="main" align="right" valign="top"><i><small>'.
			$products_attribute_price_single.
			'							</i></small></nobr>
						</td>
					</tr>
';
		}
	}
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 &&
	$_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		if (sizeof($order->info['tax_groups']) > 1)
		$data_products .=
		'
         	<tr>
             <td colspan="3" class="main" valign="top" align="right">' .
		olc_display_tax_value($order_products['tax']) . '%
						</td>
				 </tr>
';
	}
}
$payment_method=$order->info['payment_method'];
if ($payment_method)
{
	if ($payment_method!='no_payment')
	{
		include(DIR_WS_LANGUAGES . SLASH . SESSION_LANGUAGE . '/modules/payment/' . $payment_method . PHP);
		//---PayPal WPP Modification START ---//
		if ($use_ec_checkout)
		{
			$module_payment_title=MODULE_PAYMENT_PAYPAL_EC_TEXT_TITLE;
		}
		else
		{
			$module_payment_title=constant('MODULE_PAYMENT_' . strtoupper($payment_method) . '_TEXT_TITLE');
		}
		$smarty->assign('PAYMENT_METHOD',$module_payment_title);
		//---PayPal WPP Modification START ---//
	}
}

$smarty->assign('PAYMENT_EDIT',olc_href_link(FILENAME_CHECKOUT_PAYMENT, EMPTY_STRING, SSL));

$total_block='<table>';
if (MODULE_ORDER_TOTAL_INSTALLED)
{
	require_once(DIR_WS_CLASSES . 'order_total.php');
	$data_products.='
					<tr>
						<td colspan="2"></td>
						<td><hr/></td>
					</tr>
';
	$order_total_modules->process();
	$total_block.= $order_total_modules->output();
}
$data_products .=
'				</table>';
$total_block.='
				</table>
';
$smarty->assign('PRODUCTS_BLOCK',$data_products);
$smarty->assign('TOTAL_BLOCK',$total_block);
if (is_array($payment_modules->modules))
{
	if ($confirmation = $payment_modules->confirmation())
	{
		$payment_info=HTML_BR.HTML_B_START.$confirmation['title'].HTML_B_END;
		$confirmation_fields=$confirmation['fields'];
		for ($i=0, $n=sizeof($confirmation_fields); $i<$n; $i++)
		{
			$confirmation_field=$confirmation_fields[$i];
			$payment_info .=
			'<table>
					<tr>
              <td class="main">'. $confirmation_field['title'].'</td>
              <td class="main">'. stripslashes($confirmation_field['field']).'</td>
          </tr>
       </table>';
		}
		$smarty->assign('PAYMENT_INFORMATION',$payment_info);
	}
}

/*
if (olc_not_null($order->info['comments'])) {
$smarty->assign('ORDER_COMMENTS',nl2br(htmlspecialchars($order->info['comments'])) .
olc_draw_hidden_field('comments', $order->info['comments']));
}
*/

$form_action_url=$$_SESSION['payment']->form_action_url;
if ($form_action_url)
{
	if (IS_AJAX_PROCESSING)
	{
		//As we cannot access a URL on another server via AJAX, we need
		//to employ a proxy program, which does this on our behalf!!
		$hidden_fields=olc_draw_hidden_field('target_url',$form_action_url).
		olc_draw_hidden_field('response_wait',$$_SESSION['payment']->response_wait);
		$form_action_url= FILENAME_CHECKOUT_AJAX_PAYMENT_PROXY;
	}
}
else
{
	$form_action_url = olc_href_link(FILENAME_CHECKOUT_PROCESS, EMPTY_STRING, SSL);
}
$smarty->assign('CHECKOUT_FORM',olc_draw_form('checkout_confirmation',$form_action_url,'post').$hidden_fields);
if (is_array($payment_modules->modules))
{
	$smarty->assign('MODULE_BUTTONS',$payment_modules->process_button());
}
if (CUSTOMER_STATUS_ID==DEFAULT_CUSTOMERS_STATUS_ID_COMPANY)
{
	$customers_order_reference_text='customers_order_reference';
	$smarty->assign('CUSTOMERS_REFERENCE',
	olc_draw_input_field($customers_order_reference_text,$_SESSION[$customers_order_reference_text],'size="40"'));
}
$comments_text='comments';
$smarty->assign('COMMENTS',olc_draw_textarea_field($comments_text, 'soft', '60', '5', $_SESSION[$comments_text]));

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
include_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');
include_once(DIR_FS_INC.'olc_get_smarty_config_variable.inc.php');

$conditions_text='conditions';
$fernag_text='fernag';
$smarty->assign('AGB_checkbox',olc_draw_checkbox_field($conditions_text,TRUE_STRING_S,$_SESSION[$conditions_text]));
$checkout_confirmation='checkout_confirmation';
$accept_agb='accept_agb';
$s=olc_get_smarty_config_variable($smarty,$checkout_confirmation,'text_'.$accept_agb);
$smarty->assign(strtoupper($accept_agb),str_replace(ATSIGN,SESSION_LANGUAGE,$s));
//Only display FernAG-Info for a customer in germany or austria from a shop in the same country!
if ((CUSTOMER_COUNTRY_ID==STORE_COUNTRY) && (STORE_COUNTRY==81 || STORE_COUNTRY==14))
{
	// W. Kaiser
	if (!isset($_SESSION[$fernag_text]))
	{
		$s=$_POST[$fernag_text];
		$_SESSION[$fernag_text]=($s)?$s:$_GET[$fernag_text];
	}
	$s=olc_draw_checkbox_field($fernag_text,TRUE_STRING_S,$_SESSION[$fernag_text]);
}
else
{
	$s=olc_draw_hidden_field($fernag_text,TRUE_STRING_S);
}
$smarty->assign('FERNAG_checkbox',$s);

$accept_fernag='accept_fernag';
$s=olc_get_smarty_config_variable($smarty,$checkout_confirmation,'text_'.$accept_fernag);
$smarty->assign(strtoupper($accept_fernag),str_replace(ATSIGN,SESSION_LANGUAGE,$s));

$smarty->assign('CHECKOUT_BUTTON', olc_image_submit('button_confirm_order.gif', IMAGE_BUTTON_CONFIRM_ORDER));
$smarty->assign('GENERAL_DISCLAIMER',GENERAL_DISCLAIMER);

$error_message=$_GET['error_message'];
if ($error_message)
{
	$smarty->assign('error',nl2br($error_message));
}
require(BOXES);
$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'checkout_confirmation'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
$smarty->display(INDEX_HTML);
?>