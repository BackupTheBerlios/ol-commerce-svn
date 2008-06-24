<?php
/* -----------------------------------------------------------------------------------------
$Id: checkout_success.php,v 1.1.1.1.2.1 2007/04/08 07:16:10 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(checkout_success.php,v 1.48 2003/02/17); www.oscommerce.com
(c) 2003	    nextcommerce (checkout_success.php,v 1.14 2003/08/17); www.nextcommerce.org
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

include( 'includes/application_top.php');


// if the customer is not logged on, redirect them to the shopping cart page
if (!ISSET_CUSTOMER_ID)
{
	$_SESSION['navigation']->set_snapshot(array('mode' => SSL, 'page' => FILENAME_CHECKOUT_PAYMENT));
	olc_redirect(olc_href_link(FILENAME_LOGIN, EMPTY_STRING, SSL));
}
$action=$_GET['action'];
if ($action == 'update')
{
	$notify = $_POST['notify'];
	if (!is_array($notify)) $notify = array($notify);
	for ($i=0, $n=sizeof($notify); $i<$n; $i++)
	{
		$notify_string .= '&notify[]=' . $notify[$i];
	}
	if (strlen($notify_string) > 0)
	{
		$notify_string = 'action=notify'.$notify_string;
	}
	if (CUSTOMER_STATUS_ID!=DEFAULT_CUSTOMERS_STATUS_ID_GUEST)
	{
		olc_redirect(olc_href_link(FILENAME_DEFAULT, $notify_string));
	}
	//begin PayPal_Shopping_Cart_IPN
	/*
} else {
olc_redirect(olc_href_link(FILENAME_LOGOFF, $notify_string));
}
*/
}
else if ($action == 'success')
{
	if(!class_exists('PayPal_osC')) include_once(PAYPAL_IPN_DIR.'Classes/osC/osC.class.php');
	PayPal_osC::reset_checkout_cart_session();
}
else
{
	olc_redirect(olc_href_link(FILENAME_LOGOFF, $notify_string));
}

//end PayPal_Shopping_Cart_IPN
// include needed functions
require_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_selection_field.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');

$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_SUCCESS);
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_SUCCESS);

$global_query = olc_db_query("select global_product_notifications from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . (int)$_SESSION['customer_id'] . APOS);
$global = olc_db_fetch_array($global_query);

$orders_query = olc_db_query("select orders_id from " . TABLE_ORDERS . " where customers_id = '" .
(int)$_SESSION['customer_id'] . "' order by date_purchased desc limit 1");
$orders = olc_db_fetch_array($orders_query);

if ($global['global_product_notifications'] != '1') {

	$products_array = array();
	$products_query = olc_db_query("select products_id, products_name from " . TABLE_ORDERS_PRODUCTS .
	" where orders_id = '" . (int)$orders['orders_id'] . "' order by products_name");
	while ($products = olc_db_fetch_array($products_query)) {
		$products_array[] = array('id' => $products['products_id'],
		'text' => $products['products_name']);
	}
}

require(DIR_WS_INCLUDES . 'header.php');

if ($global['global_product_notifications'] != '1') {
	$notifications= '<p class="productsNotifications">';

	$products_displayed = array();
	for ($i=0, $n=sizeof($products_array); $i<$n; $i++) {
		if (!in_array($products_array[$i]['id'], $products_displayed)) {
			$notifications.=  olc_draw_checkbox_field('notify[]', $products_array[$i]['id']) . BLANK .
			$products_array[$i]['text'] . HTML_BR;
			$products_displayed[] = $products_array[$i]['id'];
		}
	}

	$notifications.=  '</p>';
} else {
	$notifications.=  TEXT_SEE_ORDERS . '<br/><br/>' . TEXT_CONTACT_STORE_OWNER;
}
$smarty->assign('NOTIFICATION_BLOCK',$notifications);
$smarty->assign('FORM_ACTION',olc_draw_form('order', olc_href_link(FILENAME_CHECKOUT_SUCCESS, 'action=update', SSL)));
$smarty->assign('BUTTON_CONTINUE',olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));

$button_print_link=olc_href_link(FILENAME_PRINT_ORDER,'oID='.$orders['orders_id'],SSL,true,true,false);
$title=PRINT_ORDER_CONFIRMATION;
if (INCLUDE_PDF_INVOICE)
{
	$parameter=EMPTY_STRING;
	$title.=PDF_FORMAT;
}
else
{
	$parameter=' onclick="javascript:ShowInfo(\''.$button_print_link.'\',\'\')"';
}
$button_print=olc_image(CURRENT_TEMPLATE_BUTTONS.'button_print.gif',$title,EMPTY_STRING,EMPTY_STRING,
	'style="cursor:hand"'.$parameter);
if (INCLUDE_PDF_INVOICE)
{
	$button_print=HTML_A_START.$button_print_link.'" target="_blank">'.$button_print.HTML_A_END;
}
$smarty->assign('BUTTON_PRINT',$button_print);

// GV Code Start
$gv_query=olc_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id='".$_SESSION['customer_id'].APOS);
if ($gv_result=olc_db_fetch_array($gv_query)) {
	if ($gv_result['amount'] > 0) {
		$smarty->assign('GV_SEND_LINK', olc_href_link(FILENAME_GV_SEND));
	}
}
// GV Code End
//W. Kaiser - Allow save/restore of cart
//Delete saved cart id
unset($_SESSION['id_saved_carts']);;
//W. Kaiser - Allow save/restore of cart
if (DOWNLOAD_ENABLED == TRUE_STRING_S)
{
	include(DIR_WS_MODULES . FILENAME_DOWNLOADS);
}

//---PayPal WPP Modification START ---//
if (olc_paypal_wpp_enabled())
{
	if ($paypal_ec_temp)
	{
		$customer_text='customer_';
		unset($_SESSION[$customer_text.'id']);
		unset($_SESSION[$customer_text.'default_address_id']);
		unset($_SESSION[$customer_text.'first_name']);
		unset($_SESSION[$customer_text.'country_id']);
		unset($_SESSION[$customer_text.'zone_id']);
		unset($_SESSION['comments']);
		//$cart->reset();
		$delete_from=DELETE_FROM;
		$where=" where customers_id = '" . (int)$customer_id . APOS;
		olc_db_query($delete_from . TABLE_ADDRESS_BOOK . $where);
		olc_db_query($delete_from . TABLE_CUSTOMERS . $where);
		olc_db_query($delete_from . TABLE_CUSTOMERS_INFO . $where);
		olc_db_query($delete_from . TABLE_CUSTOMERS_BASKET . $where);
		olc_db_query($delete_from . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . $where);
		olc_db_query($delete_from . TABLE_WHOS_ONLINE . $where);
	}
	$paypal_ec_text='paypal_ec_';
	unset($_SESSION[$paypal_ec_text.'temp']);
	unset($_SESSION[$paypal_ec_text.'token']);
	unset($_SESSION[$paypal_ec_text.'payer_id']);
	unset($_SESSION[$paypal_ec_text.'payer_info']);
}
//---PayPal WPP Modification END ---//
$smarty->assign('PAYMENT_BLOCK',$payment_block);
require(BOXES);
$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'checkout_success'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
$smarty->display(INDEX_HTML);
?>