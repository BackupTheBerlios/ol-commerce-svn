<?php
/*
$Id: paypal.lng.php,v 1.1.1.1 2006/12/22 13:43:25 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2002 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/

//begin ADMIN text
define('HEADING_ADMIN_TITLE', 'PayPal IPN (Instant Payment Notifications)');
define('HEADING_PAYMENT_STATUS', 'Status');
define('TEXT_ALL_IPNS', 'All');
define('TEXT_INFO_PAYPAL_IPN_HEADING', 'PayPal IPN');
define('TABLE_HEADING_ACTION', 'Action');
define('TEXT_DISPLAY_NUMBER_OF_TRANSACTIONS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> IPN\'s)');

//shared with TransactionSummaryLogs
define('TABLE_HEADING_DATE', 'Date');
define('TABLE_HEADING_DETAILS', 'Details');
define('TABLE_HEADING_PAYMENT_STATUS', 'Status');
define('TABLE_HEADING_PAYMENT_GROSS', 'Gross');
define('TABLE_HEADING_PAYMENT_FEE', 'Fee');
define('TABLE_HEADING_PAYMENT_NET_AMOUNT', 'Net Amount');

//TransactionSummaryLogs
define('TABLE_HEADING_TXN_ACTIVITY', 'Transaction Activity');
define('IMAGE_BUTTON_TXN_ACCEPT', 'Accept');

//AcceptOrder
define('SUCCESS_ORDER_ACCEPTED', 'Order Accepted!');
define('ERROR_UNAUTHORIZED_REQUEST', 'Unauthorized Request!');
define('ERROR_ORDER_UNPAID', 'Payment has not been Completed!');

//Template Page Titles
define('TEXT_NO_IPN_HISTORY', 'No PayPal Transaction Information Available (%s)');
define('HEADING_DETAILS_TITLE', 'Transaction Details');
define('HEADING_ITP_TITLE', 'IPN Test Panel');
define('HEADING_ITP_HELP_TITLE', 'IPN Test Panel - Guide');
define('HEADING_HELP_CONTENTS_TITLE', 'Help Contents');
define('HEADING_HELP_CONFIG_TITLE', 'Configuration Guide');
define('HEADING_HELP_FAQS_TITLE', 'Frequently Asked Questions');
define('HEADING_ITP_RESULTS_TITLE', 'IPN Test Panel - Results');

//IPN Test Panel
define('IMAGE_ERROR', 'Error icon');

//IPN Statusses
define('PAYPAL_IPN_STATUS_PENDING','Pending');
define('PAYPAL_IPN_STATUS_COMPLETED','Completed');
define('PAYPAL_IPN_STATUS_ON_HOLD','On Hold');
define('PAYPAL_IPN_STATUS_FAILED','Failed');
define('PAYPAL_IPN_STATUS_DENIED','Denied');
define('PAYPAL_IPN_STATUS_REFUNDED','Refunded');
define('PAYPAL_IPN_STATUS_REVERSED','Reversed');
define('PAYPAL_IPN_STATUS_CANCELED_REVERSAL' , 'Canceled Reversal');
?>