<?php
/* -----------------------------------------------------------------------------------------
   $Id: authorizenet.php,v 2.0.0 2006/12/14 05:49:35 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(authorizenet.php,v 1.15 2003/02/16); www.oscommerce.com 
   (c) 2003	    nextcommerce (authorizenet.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------*/
  define('MODULE_PAYMENT_TYPE_PERMISSION', 'cod');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_TITLE', 'Authorize.net');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_DESCRIPTION', 'Kreditkarten Test Info:<br/><br/>CC#: 4111111111111111<br/>G�ltig bis: Jederzeit');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_TYPE', 'Typ:');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_OWNER', 'Kreditkarteninhaber:');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_NUMBER', 'Kreditkarten-Nr.:');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_EXPIRES', 'G�ltig bis:');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_JS_CC_OWNER', '* Der Name des Kreditkarteninhabers muss mindestens aus  ' . CC_OWNER_MIN_LENGTH . ' Zeichen bestehen.\n');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_JS_CC_NUMBER', '* Die \'Kreditkarten-Nr.\' muss mindestens aus ' . CC_NUMBER_MIN_LENGTH . ' Zahlen bestehen.\n');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_ERROR_MESSAGE', 'Bei der �berp�fung Ihrer Kreditkarte ist ein Fehler aufgetreten! Bitte versuchen Sie es nochmal.');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_DECLINED_MESSAGE', 'Ihre Kreditkarte wurde abgelehnt. Bitte versuchen Sie es mit einer anderen Karte oder kontaktieren Sie Ihre Bank f�r weitere Informationen.');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_ERROR', 'Fehler bei der �berp�fung der Kreditkarte!');
  
  
define('MODULE_PAYMENT_AUTHORIZENET_TXNKEY_TITLE' , 'Transaktionschl�ssel');
define('MODULE_PAYMENT_AUTHORIZENET_TXNKEY_DESC' , 'Transaktionschl�ssel welcher zum Verschl�sseln von TP Daten verwendet wird');
define('MODULE_PAYMENT_AUTHORIZENET_TESTMODE_TITLE' , 'Transaktionsmodus');
define('MODULE_PAYMENT_AUTHORIZENET_TESTMODE_DESC' , 'Transaktionsmodus, welcher f�r dieses Modul verwendet werden soll');
define('MODULE_PAYMENT_AUTHORIZENET_METHOD_TITLE' , 'Transaktions Methode');
define('MODULE_PAYMENT_AUTHORIZENET_METHOD_DESC' , 'Transaktions Methode, welche f�r dieses Modul verwendet werden soll');
define('MODULE_PAYMENT_AUTHORIZENET_EMAIL_CUSTOMER_TITLE' , 'Kundenbenachrichtigungen');
define('MODULE_PAYMENT_AUTHORIZENET_EMAIL_CUSTOMER_DESC' , 'Soll Authorize.Net eine Best�tigungs-eMail an den Kunden senden?');
define('MODULE_PAYMENT_AUTHORIZENET_STATUS_TITLE' , 'Authorize.net Modul aktivieren');
define('MODULE_PAYMENT_AUTHORIZENET_STATUS_DESC' , 'M�chten Sie Zahlungen per Authorize.net akzeptieren?');
define('MODULE_PAYMENT_AUTHORIZENET_LOGIN_TITLE' , 'Anmelde-Benutzernamename');
define('MODULE_PAYMENT_AUTHORIZENET_LOGIN_DESC' , 'Anmelde-Benutzernamename, welcher f�r das Authorize.net Service verwendet wird');
define('MODULE_PAYMENT_AUTHORIZENET_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_AUTHORIZENET_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
define('MODULE_PAYMENT_AUTHORIZENET_SORT_ORDER_TITLE' , 'Anzeigereihenfolge');
define('MODULE_PAYMENT_AUTHORIZENET_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_AUTHORIZENET_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_AUTHORIZENET_ZONE_DESC' , 'Wenn eine Zone ausgew�hlt ist, gilt die Zahlungsmethode nur f�r diese Zone.');
define('MODULE_PAYMENT_AUTHORIZENET_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_AUTHORIZENET_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche f�r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
?>