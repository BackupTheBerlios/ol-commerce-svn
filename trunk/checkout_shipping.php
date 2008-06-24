<?php
/* -----------------------------------------------------------------------------------------
$Id: checkout_shipping.php,v 1.1.1.1.2.1 2007/04/08 07:16:10 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(checkout_shipping.php,v 1.15 2003/04/08); www.oscommerce.com
(c) 2003	    nextcommerce (checkout_shipping.php,v 1.20 2003/08/20); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include('includes/application_top.php');

$cart=$_SESSION['cart'];
// check if checkout is allowed
if ($_SESSION['allow_checkout']==FALSE_STRING_S)
{
	olc_redirect(olc_href_link(FILENAME_SHOPPING_CART));
}
/*
// if the customer is not logged on, redirect them to the login page
elseif (!ISSET_CUSTOMER_ID)
{
	$_SESSION['navigation']->set_snapshot(array('mode' => SSL, 'page' => FILENAME_CHECKOUT_PAYMENT));
	olc_redirect(olc_href_link(FILENAME_LOGIN, EMPTY_STRING, SSL));
}
*/
// if there is nothing in the customers cart, redirect them to the shopping cart page
elseif ($cart->count_contents() < 1)
{
	olc_redirect(olc_href_link(FILENAME_SHOPPING_CART));
}
// include needed functions

require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');
require_once(DIR_FS_INC.'olc_address_label.inc.php');
require_once(DIR_FS_INC.'olc_get_address_format_id.inc.php');
require_once(DIR_FS_INC.'olc_count_shipping_modules.inc.php');
require_once(DIR_FS_INC.'olc_draw_textarea_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_radio_field.inc.php');
require_once(DIR_WS_CLASSES.'http_client.php');

unset($_SESSION['paypal_payment']);
// if no shipping destination address was selected, use the customers own address as default
$sendto=$_SESSION['sendto'];
if ($sendto)
{
	// verify the selected shipping address
	$check_address_query = olc_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK .
	" where customers_id = '" . CUSTOMER_ID . "' and address_book_id = '" . (int)$sendto . APOS);
	$check_address = olc_db_fetch_array($check_address_query);
	if ($check_address['total'] != '1')
	{
		$sendto = $_SESSION['customer_default_address_id'];
		unset($_SESSION['shipping']);
	}
} else {
	$sendto = $_SESSION['customer_default_address_id'];
}
$_SESSION['sendto']=$sendto;

require_once(DIR_WS_CLASSES . 'order.php');
$order = new order;

// register a random id in the session to check throughout the checkout procedure
// against alterations in the shopping cart contents
$_SESSION['cartID'] = $cart->cartID;

// if the order contains only virtual products, forward the customer to the billing page as
// a shipping address is not needed
if ($order->content_type == 'virtual' || ($order->content_type == 'virtual_weight'))
{ // GV Code added
	$_SESSION['shipping'] = false;
	$sendto = false;
	olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT, EMPTY_STRING, SSL));
}
$total_weight = $cart->show_weight();
$total_count = $cart->count_contents();
if ($order->delivery['country']['iso_code_2'] != EMPTY_STRING) {
	$_SESSION['delivery_zone'] = $order->delivery['country']['iso_code_2'];
}
// load all enabled shipping modules
require_once(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping;
if ((MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == TRUE_STRING_S) )
{
	if (!defined('FREE_AMOUNT')) {
		//	W. Kaiser - Free shipping national/international
		require_once(DIR_FS_INC.'olc_get_free_shipping_amount.inc.php');
		olc_get_free_shipping_amount();
	}
	if (FREE_AMOUNT)
	{
		if ($order->info['total'] >= FREE_AMOUNT)
		{
			$free_shipping = true;
			include(DIR_WS_LANGUAGES . SESSION_LANGUAGE . '/modules/order_total/ot_shipping.php');
		} else {
			$free_shipping = false;
		}
	}
	//	W. Kaiser - Free shipping national/international
} else {
	$free_shipping = false;
}
//	W. Kaiser - Free shipping national/international

//---PayPal WPP Modification START ---//
$ec_enabled=olc_paypal_wpp_enabled();
if ($ec_enabled)
{
	if (isset($_GET['ec_cancel']) ||
	($_SESSION['paypal_ec_token'] && !($_SESSION['paypal_ec_payer_id'] || $_SESSION['paypal_ec_payer_info'])))
	{
		unset($_SESSION['paypal_ec_temp']);
		unset($_SESSION['paypal_ec_token']);
		unset($_SESSION['paypal_ec_payer_id']);
		unset($_SESSION['paypal_ec_payer_info']);
	}
	$ec_checkout=$_SESSION['paypal_ec_token'] || $_SESSION['paypal_ec_payer_id'] ||
	$_SESSION['paypal_ec_payer_info'];
	if ($ec_checkout)
	{
		if (!$_SESSION['payment']) unset($_SESSION['payment']);
		$payment = 'paypal_wpp';
		$show_payment_page = MODULE_PAYMENT_PAYPAL_DP_DISPLAY_PAYMENT_PAGE=='Yes';
	}
	else
	{
		$show_payment_page = true;
	}
}
//---PayPal WPP Modification END ---//
$shipping_modules_count=olc_count_shipping_modules();
// process the selected shipping method
if ($_POST['action'] == 'process')
{
	//---PayPal WPP Modification START ---//
	if ($show_payment_page || !$ec_enabled)
	{
		$goto=FILENAME_CHECKOUT_PAYMENT;
	} else {
		$goto=FILENAME_CHECKOUT_CONFIRMATION;
	}
	//---PayPal WPP Modification END ---//
	if (($shipping_modules_count > 0) || $free_shipping)
	{
		$post_shipping=$_POST['shipping'];
		if (strpos($post_shipping, UNDERSCORE))
		{
			$session_shipping=$post_shipping;
			$_SESSION['shipping'] = $post_shipping;
			list($module, $method) = explode(UNDERSCORE, $session_shipping);
			$is_free_shipping=$session_shipping == 'free_free';
			$is_selfpickup=$session_shipping == 'selfpickup_selfpickup';
			if (is_object($$module) || $is_free_shipping)
			{
				$quote_methods=$quote[0]['methods'][0];
				if ($is_free_shipping)
				{
					$quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
					$quote[0]['methods'][0]['cost'] = '0';
				} else {
					$quote = $shipping_modules->quote($method, $module);
				}
				if (isset($quote['error']))
				{
					unset($_SESSION['shipping']);
				} else {
					$current_quote_method=$quote[0]['methods'][0];
					$quote_methods_title=$current_quote_method['title'];
					if ($quote_methods_title)
					{
						$quote_methods_cost=$current_quote_method['cost'];
						if ($quote_methods_cost || $is_free_shipping || $is_selfpickup)
						{
							$_SESSION['shipping'] = array(
							'id' => $_SESSION['shipping'],
							'title' => (($free_shipping) ?
								$quote_methods_title : $quote[0]['module'] . LPAREN . $quote_methods_title . RPAREN),
							'cost' => $quote_methods_cost);
							//---PayPal WPP Modification START ---//
							olc_redirect(olc_href_link($goto, EMPTY_STRING, SSL));
							//---PayPal WPP Modification END ---//
						}
					}
				}
			} else {
				unset($_SESSION['shipping']);
			}
		}
	} else {
		unset($_SESSION['shipping']);
		//---PayPal WPP Modification START ---//
		olc_redirect(olc_href_link($goto, EMPTY_STRING, SSL));
		//---PayPal WPP Modification END ---//
	}
}
// get all available shipping quotes
$quotes = $shipping_modules->quote();

// if no shipping method has been selected, automatically select the cheapest method.
// if the modules status was changed when none were available, to save on implementing
// a javascript force-selection method, also automatically select the cheapest shipping
// method if more than one module is now enabled
$session_shipping=$_SESSION['shipping'];
if (!$session_shipping || ($session_shipping && $session_shipping == false) && ($shipping_modules_count > 1))
{
	$_SESSION['shipping'] = $shipping_modules->cheapest();
}

//---PayPal WPP Modification START ---//--
if ($ec_enabled)
{
	$paypal_error=$_SESSION['paypal_error'];
	if ($paypal_error)
	{
		$messageStack->add('shipping', $paypal_error);
		unset($_SESSION['paypal_error']);
	}
}
//---PayPal WPP Modification END ---//

$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_SHIPPING, olc_href_link(FILENAME_CHECKOUT_SHIPPING, EMPTY_STRING, SSL));
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_SHIPPING, olc_href_link(FILENAME_CHECKOUT_SHIPPING, EMPTY_STRING, SSL));

require(DIR_WS_INCLUDES . 'header.php');

$smarty->assign('FORM_ACTION',olc_draw_form('checkout_address',
olc_href_link(FILENAME_CHECKOUT_SHIPPING, EMPTY_STRING, SSL)) . olc_draw_hidden_field('action', 'process'));

//---PayPal WPP Modification START ---//--
if ($ec_checkout && $ec_enabled)
{
	$paypal_ec_payer_info = $_SESSION['paypal_ec_payer_info'];
	$address_label = trim($paypal_ec_payer_info['payer_firstname'] . BLANK .
	$paypal_ec_payer_info['payer_lastname']) . HTML_BR;
	$payer_business=$paypal_ec_payer_info['payer_business'];
	if ($payer_business) $address_label .= $payer_business.HTML_BR;
	$address_label .= $paypal_ec_payer_info['ship_street_1'] . HTML_BR;
	$ship_street_2=$paypal_ec_payer_info['ship_street_2'];
	if ($ship_street_2) $address_label .= $ship_street_2.HTML_BR;
	$address_label .= $paypal_ec_payer_info['ship_city'] . COMMA_BLANK . $paypal_ec_payer_info['ship_state'] .
	BLANK . $paypal_ec_payer_info['ship_postal_code'] . HTML_BR;
	$address_label .= $paypal_ec_payer_info['ship_country_name'];
}
else
{
	$address_label=olc_address_label(CUSTOMER_ID, $sendto, true, BLANK, HTML_BR);
}
//---PayPal WPP Modification END ---//--
$smarty->assign('ADDRESS_LABEL',$address_label);

//---PayPal WPP Modification START ---//--
if ($ec_checkout && $ec_enabled)
{
	$link=olc_href_link(FILENAME_EC_PROCESS, 'clearSess=1', SSL);
}
else
{
	$link=olc_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, EMPTY_STRING, SSL);
}
//---PayPal WPP Modification END ---//--
$smarty->assign('BUTTON_ADDRESS',HTML_A_START . $link . '">' .
olc_image_button('button_change_address.gif', IMAGE_BUTTON_CHANGE_ADDRESS) . HTML_A_END);

$smarty->assign('BUTTON_CONTINUE',olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
if ($shipping_modules_count > 0)
{
	//---PayPal WPP Modification START ---//--
	if ($ec_enabled)
	{
		if (!$ec_checkout)
		{
			$smarty->assign('BUTTON_EC_CHECKOUT_TEXT',TEXT_PAYPALWPP_EC_HEADER);
			$smarty->assign('BUTTON_EC_CHECKOUT_DESCRIPTION_TEXT',TEXT_PAYPALWPP_EC_BUTTON_DESCRIPTION_TEXT);
			$smarty->assign('BUTTON_EC_CHECKOUT',HTML_A_START.olc_href_link(FILENAME_EC_PROCESS,EMPTY_STRING,SSL).'">'.
			'<img border="0" src="'.MODULE_PAYMENT_PAYPAL_EC_BUTTON_URL.'" title="'.
			TEXT_PAYPALWPP_EC_BUTTON_TEXT . '"></a>');
			require_once(DIR_WS_CLASSES . 'order_total.php');// GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
			$order_total_modules = new order_total;// GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
		}
	}
	//---PayPal WPP Modification END ---//
	$smarty->assign('free_shipping',$free_shipping);
	$shipping_block ='
				<table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td>
            	<table border="0" width="100%" cellspacing="0" cellpadding="2">';
	if ($free_shipping)
	{
		$shipping_block .='
		            <tr>
		              <td colspan="2" width="100%">
			              <table border="0" width="100%" cellspacing="0" cellpadding="2">
			                <tr>
			                  <td class="main" colspan="3">
			                  	<b>'. FREE_SHIPPING_TITLE.'</b>&nbsp;'. $quotes[$i]['icon'].'
			                  </td>
			                </tr>
			                <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)"
			                	onmouseout="rowOutEffect(this)" onclick="javascript:selectRowEffect(this, 0)">
			                  <td class="main" width="100%">'.
													sprintf(FREE_SHIPPING_DESCRIPTION,
													olc_format_price(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER,true,true,true)) .
													olc_draw_hidden_field('shipping', 'free_free').'
												</td>
			                </tr>
			              </table>
			             </td>
		            </tr>
				    <tr>
					    <td class="main" colspan="3">&nbsp;</td>
				    </tr>
';
	}
	else
	{
		//	W. Kaiser
		$OptionBoxRight =false;	// true;	//Optionbox position: true-> on right side, false-> on left side
		$radio_buttons = 0;
		for ($i=0, $n=sizeof($quotes); $i<$n; $i++)
		{
			$current_quotes=$quotes[$i];
			$shipping_block .='
	              <tr>
	                <td colspan="2">
	                	<table border="0" width="100%" cellspacing="0" cellpadding="2">
		                  <tr>
		                    <td class="main" colspan="3"><b>'. $current_quotes['module'].'</b>&nbsp;'. $current_quotes['icon'].'</td>
		                  </tr>';

			if (isset($current_quotes['error']))
			{
				$shipping_block .='
		                  <tr>
		                    <td class="main" colspan="3">'. $current_quotes['error'].'</td>
		                  </tr>';
			} else {
				$shipping_id=$_SESSION['shipping']['id'];
				for ($j=0, $n2=sizeof($current_quotes['methods']); $j<$n2; $j++)
				{
					$current_quotes_methods=$current_quotes['methods'][$j];
					$current_quotes_id=$current_quotes['id'];
					$current_quotes_methods_id=$current_quotes_methods['id'];
					// set the radio button to be checked if it is the method chosen
					$current_id=$current_quotes_id . UNDERSCORE . $current_quotes_methods_id;
					$checked = (($current_id == $shipping_id) ? true : false);
					if ($checked || ($n == 1 && $n2 == 1))
					{
						$id='Selected" id="defaultSelected" ';
					} else {
						$id=QUOTE;
					}
					$shipping_block .= '
											<tr class="moduleRow'.$id.' onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"
												onclick="javascript:selectRowEffect(this, ' . $radio_buttons . ')">' . NEW_LINE;
					if ($OptionBoxRight)
					{
						$shipping_block .='
												<td class="main" width="75%">'. $current_quotes_methods['title'].'</td>';
					}
					else
					{
						$shipping_block .='
												<td class="main" align="left" width="10">'.
													olc_draw_radio_field('shipping', $current_id, $checked).'
												</td>';
					}
					if (!CUSTOMER_SHOW_PRICE_TAX) 
                    {
                        $current_quotes['tax']=0;
                    }
					$cost=olc_format_price(olc_add_tax($current_quotes_methods['cost'], $current_quotes['tax']),
						$price_special=1,$calculate_currencies=true);
					if (($n > 1) || ($n2 > 1))
					{
						$radio=olc_draw_radio_field('shipping', $current_id, $checked);
						if ($OptionBoxRight)
						{
							$shipping_block .='
											<td class="main">'.$cost.'</td>
											<td class="main" align="right">'.$radio.'</td>';
						}
						else
						{
							$shipping_block .='
											<td class="main" width="75%" align="left">'. $current_quotes_methods['title'].'</td>
											<td class="main">'.$cost.'</td>';
						}
					} 
                    else 
                    {
						$shipping_block .='
											<td class="main" align="right" colspan="2">'.$cost . $radio.'</td>';
					}
					$shipping_block .='
										</tr>
';
					$radio_buttons++;
				}
			}
			$shipping_block .='
										<tr>
											<td class="main" colspan="2">&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
';
		}
		//	W. Kaiser
	}

	$shipping_block .='
						</table>
					</td>
				</tr>
			</table>
';
}
$smarty->assign('SHIPPING_BLOCK',$shipping_block);
require(BOXES);
$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'checkout_shipping'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
$smarty->display(INDEX_HTML);
?>