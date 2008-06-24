<?php
/* -----------------------------------------------------------------------------------------
   $Id: ipayment.php,v 2.0.0 2006/12/14 05:49:36 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ipayment.php,v 1.6 2002/11/01); www.oscommerce.com 
   (c) 2003	    nextcommerce (ipayment.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_IPAYMENT_TEXT_TITLE', 'iPayment');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_DESCRIPTION', 'Kreditkarten Test Info:<br/><br/>CC#: 4111111111111111<br/>Gültig bis: Any');
  define('IPAYMENT_ERROR_HEADING', 'Folgender Fehler wurde von iPayment während des Prozesses gemeldet:');
  define('IPAYMENT_ERROR_MESSAGE', 'Bitte kontrollieren Sie die Daten Ihrer Kreditkarte!');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_OWNER', 'Kreditkarteninhaber');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_NUMBER', 'Kreditkarten-Nr.:');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_EXPIRES', 'Gültig bis:');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_CHECKNUMBER', 'Karten-Prüfnummer');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '(Auf der Kartenrückseite im Unterschriftsfeld)');

  define('MODULE_PAYMENT_IPAYMENT_TEXT_JS_CC_OWNER', '* Der Name des Kreditkarteninhabers mss mindestens aus  ' . CC_OWNER_MIN_LENGTH . ' Zeichen bestehen.\n');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_JS_CC_NUMBER', '* Die \'Kreditkarten-Nr.\' muss mindestens aus ' . CC_NUMBER_MIN_LENGTH . ' Zahlen bestehen.\n');
  
  define('MODULE_PAYMENT_IPAYMENT_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_IPAYMENT_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche für dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_IPAYMENT_ID_TITLE' , 'Kundennummer');
define('MODULE_PAYMENT_IPAYMENT_ID_DESC' , 'Kundennummer, welche für iPayment verwendet wird');
define('MODULE_PAYMENT_IPAYMENT_STATUS_TITLE' , 'iPayment Modul aktivieren');
define('MODULE_PAYMENT_IPAYMENT_STATUS_DESC' , 'Möchten Sie Zahlungen per iPayment akzeptieren?');
define('MODULE_PAYMENT_IPAYMENT_PASSWORD_TITLE' , 'Benutzer-Passwort');
define('MODULE_PAYMENT_IPAYMENT_PASSWORD_DESC' , 'Benutzer-Passwort welches für iPayment verwendet wird');
define('MODULE_PAYMENT_IPAYMENT_USER_ID_TITLE' , 'Benutzer id');
define('MODULE_PAYMENT_IPAYMENT_USER_ID_DESC' , 'Benutzer id welche für iPayment verwendet wird');
define('MODULE_PAYMENT_IPAYMENT_CURRENCY_TITLE' , 'Transaktionswährung');
define('MODULE_PAYMENT_IPAYMENT_CURRENCY_DESC' , 'Währung, welche für Kreditkartentransaktionen verwendet wird');
define('MODULE_PAYMENT_IPAYMENT_SORT_ORDER_TITLE' , 'Anzeigereihenfolge');
define('MODULE_PAYMENT_IPAYMENT_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_IPAYMENT_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_IPAYMENT_ZONE_DESC' , 'Wenn eine Zone ausgewählt ist, gilt die Zahlungsmethode nur für diese Zone.');
define('MODULE_PAYMENT_IPAYMENT_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_IPAYMENT_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
?>