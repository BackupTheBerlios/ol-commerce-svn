<?php
/*
$Id: paypal_ipn.php,v 2.0.0 2006/12/14 05:48:59 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2002 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/

define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_TITLE', 'PayPal IPN');
define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_DESCRIPTION', 'PayPal with payment notification');

//define('MODULE_PAYMENT_PAYPAL_IPN_CC_TEXT', "Credit Card&nbsp;%s%s%s%s&nbsp;or&nbsp;%s");
define('MODULE_PAYMENT_PAYPAL_IPN_CC_TEXT', "Credit Card&nbsp;&nbsp;%s,&nbsp;%s&nbsp;or&nbsp;%s");

define('MODULE_PAYMENT_PAYPAL_IPN_IMAGE_BUTTON_CHECKOUT', 'PayPal Checkout');
define('MODULE_PAYMENT_PAYPAL_IPN_CC_DESCRIPTION','You do not need to be a PayPal member to pay by credit card');
define('MODULE_PAYMENT_PAYPAL_IPN_CC_URL_TEXT','<font color="blue"><u>[info]</u></font>');

define('MODULE_PAYMENT_PAYPAL_IPN_CUSTOMER_COMMENTS', 'Add Comments About Your Order');
define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_TITLE_PROCESSING', 'Processing transaction');
define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_DESCRIPTION_PROCESSING', 'If this page appears for more than 5 seconds, please click the PayPal Checkout button to complete your order.');

define('MODULE_PAYMENT_PAYPAL_IPN_METHOD_ITEMIZED','Itemized');
define('MODULE_PAYMENT_PAYPAL_IPN_METHOD_CART','Cart');
define('MODULE_PAYMENT_PAYPAL_IPN_CS_WHITE','White');
define('MODULE_PAYMENT_PAYPAL_IPN_CS_BLACK','Black');
?>
