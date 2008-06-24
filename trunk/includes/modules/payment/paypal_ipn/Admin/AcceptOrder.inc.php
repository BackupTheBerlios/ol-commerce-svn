<?php
/*
$Id: AcceptOrder.inc.php,v 1.1.1.1.2.1 2007/04/08 07:18:07 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2003 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/


include(DIR_WS_CLASSES . 'order.php');
$order = new order($HTTP_GET_VARS['oID']);

require_once(PAYPAL_IPN_DIR.'Admin/languages/' . $language . '/paypal.lng.php');

require_once(PAYPAL_IPN_DIR.'Classes/TransactionDetails/TransactionDetails.class.php');
$paypal = new PayPal_TransactionDetails(TABLE_PAYPAL,$order->info['payment_id']);

if($HTTP_GET_VARS['digest'] != $paypal->digest()) {
	$messageStack->add_session(ERROR_UNAUTHORIZED_REQUEST);
} elseif($paypal->info['payment_status'] === 'Completed' && $order->info['orders_status'] === MODULE_PAYMENT_PAYPAL_ORDER_ONHOLD_STATUS_ID) {

	include(PAYPAL_IPN_DIR.'Functions/addressbook.func.php');
	include(PAYPAL_IPN_DIR.'Classes/osC/Order.class.php');
	$PayPal_osC_Order = new PayPal_osC_Order();
	$PayPal_osC_Order->setOrderID($HTTP_GET_VARS['oID']);
	$PayPal_osC_Order->loadOrdersSessionInfo();
	//$currency = $PayPal_osC_Order->currency;
	$PayPal_osC_Order->setAccountHistoryInfoURL(olc_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $PayPal_osC_Order->orderID, 'SSL', false));
	$PayPal_osC_Order->setCheckoutProcessLanguageFile(DIR_FS_CATALOG_LANGUAGES . $PayPal_osC_Order->language . '/' . 'checkout_process.php');
	$PayPal_osC_Order->updateProducts($order,$currencies);
	$PayPal_osC_Order->notifyCustomer($order);
	$affiliate_ref = $PayPal_osC_Order->affiliate_id;
	$affiliate_clickthroughs_id = $PayPal_osC_Order->affiliate_clickthroughs_id;
	$affiliate_clientdate = $PayPal_osC_Order->affiliate_date;
	$affiliate_clientbrowser = $PayPal_osC_Order->affiliate_browser;
	$affiliate_clientip = $PayPal_osC_Order->affiliate_ipaddress;
	if (olc_not_null($affiliate_ref) && $affiliate_ref != '0') {
		define('MODULE_PAYMENT_PAYPAL_SHOPPING_IPN_AFFILIATE',TRUE_STRING_S);
		$insert_id = $PayPal_osC_Order->orderID;
		include(DIR_FS_CATALOG_MODULES . '../affiliate_checkout_process.php');
	}
	$PayPal_osC_Order->updateOrderStatus(MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID);
	$PayPal_osC_Order->removeOrdersSession();
	$messageStack->add_session(SUCCESS_ORDER_ACCEPTED, 'success');
} else {
	$messageStack->add_session(ERROR_ORDER_UNPAID);
}
olc_redirect(olc_href_link(FILENAME_ORDERS, olc_get_all_get_params(array('action')) . 'action=edit'));
?>