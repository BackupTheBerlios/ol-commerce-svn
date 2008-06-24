<?php
/*
$Id: ipn.php,v 1.1.1.1.2.1 2007/04/08 07:16:16 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2003 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/

/*
function debugWriteFile($str,$mode="a") {
$fp = @fopen("ipn.txt",$mode);  @flock($fp, LOCK_EX); @fwrite($fp,$str); @flock($fp, LOCK_UN); @fclose($fp);
}

$postString = ''; foreach($_POST as $key => $val) $postString .= $key.' = '.$val.NEW_LINE;
if($postString != '') {
debugWriteFile($postString,"w+");
}
*/
//require_once(PAYPAL_IPN_DIR.'application_top.inc.php');
require_once(DIR_WS_INCLUDES.'application_top.inc.php');
require_once(PAYPAL_IPN_DIR.'Classes/Ipn/IPN.class.php');
require_once(PAYPAL_IPN_DIR.'Classes/Debug/Debug.class.php');
require_once(PAYPAL_IPN_DIR.'Functions/general.func.php');
paypal_include_lng(PAYPAL_IPN_DIR.'languages/', SESSION_LANGUAGE, 'ipn.lng.php');
$debug = new PayPal_Debug(MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL, MODULE_PAYMENT_PAYPAL_IPN_DEBUG);
$ipn = new PayPal_IPN($_POST);
$ipn->setTestMode(MODULE_PAYMENT_PAYPAL_IPN_TEST_MODE);
unset($_POST);
//post back to PayPal to validate
if(!$ipn->authenticate(MODULE_PAYMENT_PAYPAL_DOMAIN) && $ipn->testMode('Off')) $ipn->dienice('500');
//Check both the receiver_email and business id fields match
if (!$ipn->validateReceiverEmail(MODULE_PAYMENT_PAYPAL_ID,MODULE_PAYMENT_PAYPAL_BUSINESS_ID)) $ipn->dienice('500');
if($ipn->uniqueTxnID() && $ipn->isReversal() && strlen($ipn->key['parent_txn_id']) == 17) {
	//parent_txn_id is the txn_id of the original transaction
	$txn = $ipn->queryTxnID($ipn->key['parent_txn_id']);
	if(!empty($txn)) {
		$ipn->insert($txn['paypal_id']);
		// update the order's status
		switch ($ipn->reversalType()) {
			case 'Canceled_Reversal':
				$order_status = MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID;
				break;
			case 'Reversed':
				$order_status = MODULE_PAYMENT_PAYPAL_ORDER_CANCELED_STATUS_ID;
				break;
			case 'Refunded':
				$order_status = MODULE_PAYMENT_PAYPAL_ORDER_REFUNDED_STATUS_ID;
				break;
		}
		$ipn->updateOrderStatus($txn['paypal_id'],$order_status);
	}
} elseif ($ipn->isCartPayment() && !empty($PayPal_osC_Order->orderID)) {
	//actually not essential since 'orders_status_name' is not required
	$languages_id = $PayPal_osC_Order->languageID;
	include(DIR_WS_CLASSES . 'order.php');
	$order = new order($PayPal_osC_Order->orderID);
	//Check that txn_id has not been previously processed
	if ($ipn->uniqueTxnID()) { //Payment is either Completed, Pending or Failed
		$ipn->insert();
		$PayPal_osC_Order->setOrderPaymentID($ipn->id());
		$PayPal_osC_Order->removeCustomersBasket($order->customer['id']);
		switch ($ipn->paymentStatus()) {
			case 'Completed':
				if ($ipn->validPayment($PayPal_osC_Order->payment_amount,$PayPal_osC_Order->payment_currency)) {
					include(PAYPAL_IPN_DIR.'catalog/checkout_update.inc.php');
				} else {
					$ipn->updateOrderStatus($ipn->id(),MODULE_PAYMENT_PAYPAL_ORDER_ONHOLD_STATUS_ID);
				}
				break;
			case 'Failed':
				$ipn->updateOrderStatus($ipn->id(),MODULE_PAYMENT_PAYPAL_ORDER_CANCELED_STATUS_ID);
				break;
			case 'Pending':
				//Assumed to do nothing since the order is initially in a Pending ORDER Status
				break;
		}//end switch
	} else { // not a unique transaction => Pending Payment
		//Assumes there is only one previous IPN transaction
		$pendingTxn = $ipn->queryPendingStatus($ipn->txnID());
		if ($pendingTxn['payment_status'] === 'Pending') {
			$ipn->updateStatus($pendingTxn['paypal_id']);
			switch ($ipn->paymentStatus()) {
				case 'Completed':
					if ($ipn->validPayment($PayPal_osC_Order->payment_amount,$PayPal_osC_Order->payment_currency)) {
						include(PAYPAL_IPN_DIR.'catalog/checkout_update.inc.php');
					} else {
						$ipn->updateOrderStatus($pendingTxn['paypal_id'],MODULE_PAYMENT_PAYPAL_ORDER_ONHOLD_STATUS_ID);
					}
					break;
				case 'Denied':
					$ipn->updateOrderStatus($pendingTxn['paypal_id'],MODULE_PAYMENT_PAYPAL_ORDER_CANCELED_STATUS_ID);
					break;
			}//end switch
		}//end if Pending Payment
	}
} elseif ($ipn->isAuction()) {
	if ($ipn->uniqueTxnID()) $ipn->insert();
	if ($debug->enabled) $debug->add(PAYPAL_AUCTION,sprintf(PAYPAL_AUCTION_MSG));
} elseif ($ipn->txnType('send_money')) {
	if ($ipn->uniqueTxnID()) $ipn->insert();
	if ($debug->enabled) $debug->add(PAYMENT_SEND_MONEY_DESCRIPTION,sprintf(PAYMENT_SEND_MONEY_DESCRIPTION_MSG,number_format($ipn->key['mc_gross'],2),$ipn->key['mc_currency']));
} elseif ($debug->enabled && $ipn->testMode('On')) {
	$debug->raiseError(TEST_INCOMPLETE,sprintf(TEST_INCOMPLETE_MSG),true);
}
if ($ipn->testMode('On'))
{
	if ($ipn->validDigest())
	{
		include(PAYPAL_IPN_DIR.'Classes/Page/Page.class.php');
		$page = new PayPal_Page();
		$page->setBaseDirectory(PAYPAL_DIR);
		$page->setBaseURL(PAYPAL_DIR);
		$page->includeLanguageFile('Admin/languages/',SESSION_LANGUAGE,'paypal.lng.php');
		$page->setTitle(HEADING_ITP_RESULTS_TITLE);
		$page->setContentFile(PAYPAL_IPN_DIR.'Admin/TestPanel/Results.inc.php');
		$css=$page->baseURL . 'templates/css/';
		$page->addCSS($css.'general.css');
		$page->addCSS($css.'stylesheet.css');
		$page->setTemplate('default');
		include($page->template());
	}
}
require(PAYPAL_IPN_DIR.'application_bottom.inc.php');
?>
