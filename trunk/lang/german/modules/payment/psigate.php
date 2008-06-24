<?php
/* -----------------------------------------------------------------------------------------
   $Id: psigate.php,v 2.0.0 2006/12/14 05:49:38 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(psigate.php,v 1.3 2002/11/12); www.oscommerce.com 
   (c) 2003	    nextcommerce (psigate.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_PSIGATE_TEXT_TITLE', 'PSiGate');
  define('MODULE_PAYMENT_PSIGATE_TEXT_DESCRIPTION', 'Kreditkarten Test Info:<br/><br/>CC#: 4111111111111111<br/>Gültig bis: Any');
  define('MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_OWNER', 'Kreditkarteninhaber:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_NUMBER', 'Kreditkarten-Nr.:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_EXPIRES', 'Gültig bis:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_TYPE', 'Typ:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_JS_CC_NUMBER', '* Die \'Kreditkarten-Nr.\' muss mindestens aus ' . CC_NUMBER_MIN_LENGTH . ' Zahlen bestehen.\n');
  define('MODULE_PAYMENT_PSIGATE_TEXT_ERROR_MESSAGE', 'Bei der überpüfung Ihrer Kreditkarte ist ein Fehler aufgetreten! Bitte versuchen Sie es nochmal.');
  define('MODULE_PAYMENT_PSIGATE_TEXT_ERROR', 'Fehler bei der überpüfung der Kreditkarte!');
  
  define('MODULE_PAYMENT_PSIGATE_STATUS_TITLE' , 'PSiGate Modul aktivieren');
define('MODULE_PAYMENT_PSIGATE_STATUS_DESC' , 'Möchten Sie Zahlungen per PSiGate akzeptieren?');
define('MODULE_PAYMENT_PSIGATE_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_PSIGATE_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche für dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_PSIGATE_MERCHANT_ID_TITLE' , 'Merchant id');
define('MODULE_PAYMENT_PSIGATE_MERCHANT_ID_DESC' , 'Merchant id, welche für den PSiGate Service verwendet wird');
define('MODULE_PAYMENT_PSIGATE_TRANSACTION_MODE_TITLE' , 'Transaktions Modus');
define('MODULE_PAYMENT_PSIGATE_TRANSACTION_MODE_DESC' , 'Transaktions Modus, welcher für PSiGate verwendet wird');
define('MODULE_PAYMENT_PSIGATE_TRANSACTION_TYPE_TITLE' , 'Transaktions Typ');
define('MODULE_PAYMENT_PSIGATE_TRANSACTION_TYPE_DESC' , 'Transaktions Typ welcher für PSiGate verwendet wird');
define('MODULE_PAYMENT_PSIGATE_INPUT_MODE_TITLE' , 'Kreditkarten Erfassung');
define('MODULE_PAYMENT_PSIGATE_INPUT_MODE_DESC' , 'Sollen die Kreditkarten Details lokal erfasst werden, oder bei PSiGate?');
define('MODULE_PAYMENT_PSIGATE_CURRENCY_TITLE' , 'Transaktionswährung');
define('MODULE_PAYMENT_PSIGATE_CURRENCY_DESC' , 'Währung, welche für Kreditkartentransaktionen verwendet wird');
define('MODULE_PAYMENT_PSIGATE_SORT_ORDER_TITLE' , 'Anzeigereihenfolge');
define('MODULE_PAYMENT_PSIGATE_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_PSIGATE_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_PSIGATE_ZONE_DESC' , 'Wenn eine Zone ausgewählt ist, gilt die Zahlungsmethode nur für diese Zone.');
define('MODULE_PAYMENT_PSIGATE_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_PSIGATE_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
?>