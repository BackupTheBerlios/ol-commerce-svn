<?php
/* -----------------------------------------------------------------------------------------
$Id: moneyorder.php,v 2.0.0 2006/12/14 05:49:37 gswkaiser Exp $

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

define('MODULE_PAYMENT_MONEYORDER_TEXT_TITLE', 'Vorkasse');
define('MODULE_PAYMENT_MONEYORDER_TEXT_EXPLANATION', '<br/>(Sie erhalten die Information über unsere Bankverbindung in der Bestellbestätigungs-eMail)');
define('MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', 'Zahlbar an:&nbsp;' . MODULE_PAYMENT_MONEYORDER_PAYTO . '<br/><br/>Adressat:<br/><br/></b>' . nl2br(STORE_NAME_ADDRESS) . '<br/><br/>' . 'Ihre Bestellung wird versandt, nachdem wir Ihre Zahlung erhalten haben!');
define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', "Zahlbar an: ". MODULE_PAYMENT_MONEYORDER_PAYTO . "\n\nAdressat:\n" . STORE_NAME_ADDRESS . "\n\n" . 'Ihre Bestellung wir nicht versandt, bis wird das Geld erhalten haben!');

define('MODULE_PAYMENT_MONEYORDER_STATUS_TITLE' , 'Check/Money Order Modul aktivieren');
define('MODULE_PAYMENT_MONEYORDER_STATUS_DESC' , 'Möchten Sie Zahlungen per Check/Money Order akzeptieren?');
define('MODULE_PAYMENT_MONEYORDER_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_MONEYORDER_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche für dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_MONEYORDER_PAYTO_TITLE' , 'Zahlbar an:');
define('MODULE_PAYMENT_MONEYORDER_PAYTO_DESC' , 'An wen sollen Zahlungen erfolgen?');
define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_TITLE' , 'Anzeigereihenfolge');
define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_MONEYORDER_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_MONEYORDER_ZONE_DESC' , 'Wenn eine Zone ausgewählt ist, gilt die Zahlungsmethode nur für diese Zone.');
define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
?>