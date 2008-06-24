<?php
/* -----------------------------------------------------------------------------------------
$Id: pm2checkout.php,v 2.0.0 2006/12/14 05:49:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(pm2checkout.php,v 1.4 2002/11/01); www.oscommerce.com
(c) 2003	    nextcommerce (pm2checkout.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_2CHECKOUT_TEXT_TITLE', '2CheckOut');
define('MODULE_PAYMENT_2CHECKOUT_TEXT_DESCRIPTION', 'Kreditkarten Test Info:<br/><br/>CC#: 4111111111111111<br/>Gültig bis: Any');
define('MODULE_PAYMENT_2CHECKOUT_TEXT_TYPE', 'Typ:');
define('MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER', 'Kreditkarteninhaber:');
define('MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER_FIRST_NAME', 'Kreditkarteninhaber Vorname:');
define('MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER_LAST_NAME', 'Kreditkarteninhaber Nachname:');
define('MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_NUMBER', 'Kreditkarten-Nr.:');
define('MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_EXPIRES', 'Gültig bis:');
define('MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER', 'Karten-Prüfnummer:');
define('MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '(Auf der Kartenrückseite im Unterschriftsfeld)');
define('MODULE_PAYMENT_2CHECKOUT_TEXT_JS_CC_NUMBER', '* Die \'Kreditkarten-Nr.\' muss mindestens aus ' . CC_NUMBER_MIN_LENGTH . ' Zahlen bestehen.\n');
define('MODULE_PAYMENT_2CHECKOUT_TEXT_ERROR_MESSAGE', 'Bei der überpüfung Ihrer Kreditkarte ist ein Fehler aufgetreten! Bitte versuchen Sie es nochmal.');
define('MODULE_PAYMENT_2CHECKOUT_TEXT_ERROR', 'Fehler bei der überpüfung der Kreditkarte!');

define('MODULE_PAYMENT_2CHECKOUT_STATUS_TITLE' , '2CheckOut Modul aktivieren');
define('MODULE_PAYMENT_2CHECKOUT_STATUS_DESC' , 'Möchten Sie Zahlungen per 2CheckOut akzeptieren?');
define('MODULE_PAYMENT_PM2CHECKOUT_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_PM2CHECKOUT_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche für dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_2CHECKOUT_LOGIN_TITLE' , 'Anmelde/Shop Nummer');
define('MODULE_PAYMENT_2CHECKOUT_LOGIN_DESC' , 'Anmelde/Shop Nummer welche für 2CheckOut verwendet wird');
define('MODULE_PAYMENT_2CHECKOUT_TESTMODE_TITLE' , 'Transaktionsmodus');
define('MODULE_PAYMENT_2CHECKOUT_TESTMODE_DESC' , 'Transaktionsmodus, welcher für dieses Modul verwendet werden soll');
define('MODULE_PAYMENT_2CHECKOUT_EMAIL_MERCHANT_TITLE' , 'Merchant Benachrichtigungen');
define('MODULE_PAYMENT_2CHECKOUT_EMAIL_MERCHANT_DESC' , 'Soll 2CheckOut eine Bestätigungs-eMail an den Shop-Besitzer senden?');
define('MODULE_PAYMENT_2CHECKOUT_SORT_ORDER_TITLE' , 'Anzeigereihenfolge');
define('MODULE_PAYMENT_2CHECKOUT_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_2CHECKOUT_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_2CHECKOUT_ZONE_DESC' , 'Wenn eine Zone ausgewählt ist, gilt die Zahlungsmethode nur für diese Zone.');
define('MODULE_PAYMENT_2CHECKOUT_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_2CHECKOUT_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
?>