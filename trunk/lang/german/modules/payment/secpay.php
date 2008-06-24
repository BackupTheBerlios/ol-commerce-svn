<?php
/* -----------------------------------------------------------------------------------------
   $Id: secpay.php,v 2.0.0 2006/12/14 05:49:38 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de) 
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(secpay.php,v 1.8 2002/11/01); www.oscommerce.com 
   (c) 2003	    nextcommerce (secpay.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_SECPAY_TEXT_TITLE', 'SECPay');
  define('MODULE_PAYMENT_SECPAY_TEXT_DESCRIPTION', 'Kreditkarten Test Info:<br/><br/>CC#: 4444333322221111<br/>Gültig bis: Jederzeit');
  define('MODULE_PAYMENT_SECPAY_TEXT_ERROR', 'Fehler bei der überpüfung der Kreditkarte!');
  define('MODULE_PAYMENT_SECPAY_TEXT_ERROR_MESSAGE', 'Bei der überpüfung Ihrer Kreditkarte ist ein Fehler aufgetreten! Bitte versuchen Sie es nochmal.');
  
  define('MODULE_PAYMENT_SECPAY_MERCHANT_ID_TITLE' , 'Merchant id');
define('MODULE_PAYMENT_SECPAY_MERCHANT_ID_DESC' , 'Merchant id für den SECPay Service');
define('MODULE_PAYMENT_SECPAY_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_SECPAY_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche für dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_SECPAY_STATUS_TITLE' , 'SECpay Modul aktivieren');
define('MODULE_PAYMENT_SECPAY_STATUS_DESC' , 'Möchten Sie Zahlungen per SECPay akzeptieren?');
define('MODULE_PAYMENT_SECPAY_CURRENCY_TITLE' , 'Transaktionswährung');
define('MODULE_PAYMENT_SECPAY_CURRENCY_DESC' , 'Die Währung, die für Kreditkartentransaktionen verwendet wird');
define('MODULE_PAYMENT_SECPAY_TEST_STATUS_TITLE' , 'Transaktionsmodus');
define('MODULE_PAYMENT_SECPAY_TEST_STATUS_DESC' , 'Transaktionsmodus, welcher für dieses Modul verwendet werden soll');
define('MODULE_PAYMENT_SECPAY_SORT_ORDER_TITLE' , 'Anzeigereihenfolge');
define('MODULE_PAYMENT_SECPAY_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_SECPAY_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_SECPAY_ZONE_DESC' , 'Wenn eine Zone ausgewählt ist, gilt die Zahlungsmethode nur für diese Zone.');
define('MODULE_PAYMENT_SECPAY_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_SECPAY_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen.');
?>