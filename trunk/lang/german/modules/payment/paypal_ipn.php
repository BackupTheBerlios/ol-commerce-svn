<?php
/*
$Id: paypal_ipn.php,v 2.0.0 2006/12/14 05:49:37 gswkaiser Exp $

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
define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_DESCRIPTION', 'PayPal mit Zahlungsbestätigung');

//define('MODULE_PAYMENT_PAYPAL_IPN_CC_TEXT', "Kreditkarte&nbsp;%s%s%s%s&nbsp;oder&nbsp;%s");
define('MODULE_PAYMENT_PAYPAL_IPN_CC_TEXT', "Kreditkarte&nbsp;%s,&nbsp;%s&nbsp;oder&nbsp;%s");

define('MODULE_PAYMENT_PAYPAL_IPN_IMAGE_BUTTON_CHECKOUT', 'Zahlung mit PayPal');
define('MODULE_PAYMENT_PAYPAL_IPN_CC_DESCRIPTION','Sie müssen kein PayPal-Mitglied sein, um per Kreditkarte zu zahlen');
define('MODULE_PAYMENT_PAYPAL_IPN_CC_URL_TEXT','<font color="blue"><u>[info]</u></font>');

define('MODULE_PAYMENT_PAYPAL_IPN_CUSTOMER_COMMENTS', 'Fügen Sie Kommentare zu Ihrer Bestellung hinzu');
define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_TITLE_PROCESSING', 'Der Zahlungsvorgang wird bearbeitet');
define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_DESCRIPTION_PROCESSING', 'Wenn diese Seite länger als 5 Sekunden erscheint, klicken Sie bitte auf die PayPal-Schaltfläche um Ihre Bestellung abzuschließen.');

define('MODULE_PAYMENT_PAYPAL_IPN_METHOD_ITEMIZED','Einzelpositionen');
define('MODULE_PAYMENT_PAYPAL_IPN_METHOD_CART','Warenkorb');
define('MODULE_PAYMENT_PAYPAL_IPN_CS_WHITE','Weiss');
define('MODULE_PAYMENT_PAYPAL_IPN_CS_BLACK','Schwarz');
?>
