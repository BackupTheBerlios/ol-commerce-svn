<?php
/* -----------------------------------------------------------------------------------------
$Id: paypal.php,v 2.0.0 2006/12/14 05:48:59 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(paypal.php,v 1.7 2002/04/17); www.oscommerce.com
(c) 2003	    nextcommerce (paypal.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_PAYPAL_TEXT_TITLE', 'PayPal');
define('MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION);

define('MODULE_PAYMENT_PAYPAL_ALLOWED_TITLE' , 'Allowed zones');
define('MODULE_PAYMENT_PAYPAL_ALLOWED_DESC' , 'Please enter the zones <b>separately</b> which should be allowed to use this modul (e. g. AT,DE (leave empty if you want to allow all zones))');
define('MODULE_PAYMENT_PAYPAL_STATUS_TITLE' , 'Enable PayPal Module');
define('MODULE_PAYMENT_PAYPAL_STATUS_DESC' , 'Do you want to accept PayPal payments?');
define('MODULE_PAYMENT_PAYPAL_ID_TITLE' , 'eMail Address');
define('MODULE_PAYMENT_PAYPAL_ID_DESC' , 'The eMail address to use for the PayPal service');
define('MODULE_PAYMENT_PAYPAL_CURRENCY_TITLE' , 'Transaction Currency');
define('MODULE_PAYMENT_PAYPAL_CURRENCY_DESC' , 'The currency to use for credit card transactions');
define('MODULE_PAYMENT_PAYPAL_SORT_ORDER_TITLE' , 'Sort order of display');
define('MODULE_PAYMENT_PAYPAL_SORT_ORDER_DESC' , 'Sort order of display. Lowest is displayed first.');
define('MODULE_PAYMENT_PAYPAL_ZONE_TITLE' , 'Payment Zone');
define('MODULE_PAYMENT_PAYPAL_ZONE_DESC' , 'If a zone is selected, only enable this payment method for that zone.');
define('MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID_TITLE' , 'Set Order Status');
define('MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID_DESC' , 'Set the status of orders made with this payment module to this value');
define('MODULE_PAYMENT_PAYPAL_TEST_MODE_TITLE','Activate Test-Mode');
define('MODULE_PAYMENT_PAYPAL_TEST_MODE_DESC','In the "Test-Mode" the payment transactions will be routed to the PayPal "Sandbox". No real payments are processed! This is only intended to be used during shop-setup and -testing. To use the PayPal "Sandbox", you need to register for it!');

define('MODULE_PAYMENT_PAYPAL_IPN_STATUS_TITLE','Enable PayPal Module');
define('MODULE_PAYMENT_PAYPAL_IPN_STATUS_DESC','Do you want to accept PayPal payments?');
define('MODULE_PAYMENT_PAYPAL_IPN_ID_TITLE','E-Mail Address');
define('MODULE_PAYMENT_PAYPAL_IPN_ID_DESC','The e-mail address to use for the PayPal service');
define('MODULE_PAYMENT_PAYPAL_IPN_BUSINESS_ID_TITLE','Business id');
define('MODULE_PAYMENT_PAYPAL_IPN_BUSINESS_ID_DESC','Email address or account id of the payment recipient');
define('MODULE_PAYMENT_PAYPAL_IPN_DEFAULT_CURRENCY_TITLE','Default Currency');
define('MODULE_PAYMENT_PAYPAL_IPN_DEFAULT_CURRENCY_DESC','The <b>default</b> currency to use for when the customer chooses to checkout via the store using a currency not supported by PayPal.<br/>(This currency must exist in your store)');
define('MODULE_PAYMENT_PAYPAL_IPN_CURRENCY_TITLE','Transaction Currency');
define('MODULE_PAYMENT_PAYPAL_IPN_CURRENCY_DESC','The currency to use for credit card transactions');
define('MODULE_PAYMENT_PAYPAL_IPN_ZONE_TITLE','Payment Zone');
define('MODULE_PAYMENT_PAYPAL_IPN_ZONE_DESC','If a zone is selected, only enable this payment method for that zone.');
define('MODULE_PAYMENT_PAYPAL_IPN_PROCESSING_STATUS_ID_TITLE','Set Pending Notification Status');
define('MODULE_PAYMENT_PAYPAL_IPN_PROCESSING_STATUS_ID_DESC','Set the Pending Notification status of orders made with this payment module to this value (\Pending\ recommended)');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID_TITLE','Set Order Status');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID_DESC','Set the status of orders made with this payment module to this value<br/>(\Processing\ recommended)');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_ONHOLD_STATUS_ID_TITLE','Set On Hold Order Status');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_ONHOLD_STATUS_ID_DESC','Set the status of <b>On Hold</b> orders made with this payment module to this value');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_CANCELED_STATUS_ID_TITLE','Set Canceled Order Status');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_CANCELED_STATUS_ID_DESC','Set the status of <b>Canceled</b> orders made with this payment module to this value');
define('MODULE_PAYMENT_PAYPAL_IPN_INVOICE_REQUIRED_TITLE','Synchronize Invoice');
define('MODULE_PAYMENT_PAYPAL_IPN_INVOICE_REQUIRED_DESC','Do you want to specify the order number as the PayPal invoice number?');
define('MODULE_PAYMENT_PAYPAL_IPN_SORT_ORDER_TITLE','Sort order of display.');
define('MODULE_PAYMENT_PAYPAL_IPN_SORT_ORDER_DESC','Sort order of display. Lowest is displayed first.');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_REFUNDED_STATUS_ID_TITLE','Set Refunded Order Status');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_REFUNDED_STATUS_ID_DESC','Set the status of <b>Refunded</b> orders made with this payment module to this value');
define('MODULE_PAYMENT_PAYPAL_IPN_CS_TITLE','Background Color');
define('MODULE_PAYMENT_PAYPAL_IPN_CS_DESC','Select the background color of PayPal\s payment pages.');
define('MODULE_PAYMENT_PAYPAL_IPN_PROCESSING_LOGO_TITLE','Processing logo');
define('MODULE_PAYMENT_PAYPAL_IPN_PROCESSING_LOGO_DESC','The image file name to display the store\s checkout process');
define('MODULE_PAYMENT_PAYPAL_IPN_STORE_LOGO_TITLE','Store logo');
define('MODULE_PAYMENT_PAYPAL_IPN_STORE_LOGO_DESC','The image file name for PayPal to display (leave empty if your store does not have SSL)');
define('MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE_TITLE','PayPal Page Style Name');
define('MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE_DESC','The name of the page style you have configured in your PayPal Account');
define('MODULE_PAYMENT_PAYPAL_IPN_NO_NOTE_TITLE','Include a note with payment');
define('MODULE_PAYMENT_PAYPAL_IPN_NO_NOTE_DESC','Choose whether your customer should be prompted to include a note or not?');
define('MODULE_PAYMENT_PAYPAL_IPN_METHOD_TITLE','Shopping Cart Method');
define('MODULE_PAYMENT_PAYPAL_IPN_METHOD_DESC','What type of shopping cart do you want to use?');
define('MODULE_PAYMENT_PAYPAL_IPN_SHIPPING_ALLOWED_TITLE','Enable PayPal Shipping Address');
define('MODULE_PAYMENT_PAYPAL_IPN_SHIPPING_ALLOWED_DESC','Allow the customer to choose their own PayPal shipping address?');
define('MODULE_PAYMENT_PAYPAL_IPN_DEBUG_TITLE','Debug Email Notifications');
define('MODULE_PAYMENT_PAYPAL_IPN_DEBUG_DESC','Enable debug email notifications');
define('MODULE_PAYMENT_PAYPAL_IPN_DIGEST_KEY_TITLE','Digest Key');
define('MODULE_PAYMENT_PAYPAL_IPN_DIGEST_KEY_DESC','Key to use for the digest functionality');
define('MODULE_PAYMENT_PAYPAL_IPN_TEST_MODE_TITLE','Test Mode');
define('MODULE_PAYMENT_PAYPAL_IPN_TEST_MODE_DESC','Set test mode <a style=\"color: #0033cc;
\" href=\"" . olc_href_link(FILENAME_PAYPAL, action=itp) . "\" target=\"ipn\">[IPN Test Panel]</a>');
define('MODULE_PAYMENT_PAYPAL_IPN_CART_TEST_TITLE','Cart Test');
define('MODULE_PAYMENT_PAYPAL_IPN_CART_TEST_DESC','Set cart test mode to verify the transaction amounts');
define('MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL_TITLE','Debug Email Notification Address');
define('MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL_DESC','The e-mail address to send <b>debug</b> notifications to');
define('MODULE_PAYMENT_PAYPAL_IPN_DOMAIN_TITLE','PayPal Domain');
define('MODULE_PAYMENT_PAYPAL_IPN_DOMAIN_DESC','Select which PayPal domain to use<br/>(for live production select www.paypal.com)');
define('MODULE_PAYMENT_PAYPAL_IPN_RM_TITLE','Return URL behavior');
define('MODULE_PAYMENT_PAYPAL_IPN_RM_DESC','How should the customer be sent back from PayPal to the specified URL?<br/>0=No IPN, 1=GET, 2=POST');
?>
