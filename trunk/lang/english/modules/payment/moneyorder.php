<?php
/* -----------------------------------------------------------------------------------------
$Id: moneyorder.php,v 2.0.0 2006/12/14 05:48:58 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(moneyorder.php,v 1.8 2003/02/16); www.oscommerce.com
(c) 2003	    nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_MONEYORDER_TEXT_TITLE', 'Money Order');
define('MODULE_PAYMENT_MONEYORDER_TEXT_EXPLANATION', '<br/>(You will receive information on our bank account in the order confirmation eMail)');
define('MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', 'Make payable to:&nbsp;' . MODULE_PAYMENT_MONEYORDER_PAYTO . '<br/>Send to:<br/><br/>' . nl2br(STORE_NAME_ADDRESS) . '<br/><br/>' . 'Your order will not ship until we receive payment!');
define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', "Make payable to: ". MODULE_PAYMENT_MONEYORDER_PAYTO . "\n\nSend to:\n" . STORE_NAME_ADDRESS . "\n\n" . 'Your order will not ship until we receive payment');

define('MODULE_PAYMENT_MONEYORDER_STATUS_TITLE' , 'Enable Check/Money Order Module');
define('MODULE_PAYMENT_MONEYORDER_STATUS_DESC' , 'Do you want to accept Check/Money Order payments?');
define('MODULE_PAYMENT_MONEYORDER_ALLOWED_TITLE' , 'Allowed zones');
define('MODULE_PAYMENT_MONEYORDER_ALLOWED_DESC' , 'Please enter the zones <b>separately</b> which should be allowed to use this modul (e. g. AT,DE (leave empty if you want to allow all zones))');
define('MODULE_PAYMENT_MONEYORDER_PAYTO_TITLE' , 'Make Payable to:');
define('MODULE_PAYMENT_MONEYORDER_PAYTO_DESC' , 'Who should payments be made payable to?');
define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_TITLE' , 'Sort order of display.');
define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_DESC' , 'Sort order of display. Lowest is displayed first.');
define('MODULE_PAYMENT_MONEYORDER_ZONE_TITLE' , 'Payment Zone');
define('MODULE_PAYMENT_MONEYORDER_ZONE_DESC' , 'If a zone is selected, only enable this payment method for that zone.');
define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_TITLE' , 'Set Order Status');
define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_DESC' , 'Set the status of orders made with this payment module to this value');
?>
