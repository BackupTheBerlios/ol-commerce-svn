<?php
/* -----------------------------------------------------------------------------------------
   $Id: moneybookers.php,v 2.0.0 2006/12/14 05:49:36 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneybookers.php,v 1.01 2003/01/20); www.oscommerce.com
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Moneybookers v1.0                       Autor:    Gabor Mate  <gabor(at)jamaga.hu>
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_MONEYBOOKERS_TEXT_TITLE', 'Moneybookers.com');
  define('MODULE_PAYMENT_MONEYBOOKERS_TEXT_DESCRIPTION', 'Moneybookers.com');
  define('MODULE_PAYMENT_MONEYBOOKERS_TEXT_EMAIL_FOOTER', 'Vielen Dank f�r Ihre Bestellung! Sie k�nnen Ihr moneybookers.com Konto auf http://www.moneybookers.com einsehen');
  define('MODULE_PAYMENT_MONEYBOOKERS_NOCURRENCY_ERROR', 'Es ist keine von moneybookers.com akzeptierte W�hrung installiert!');
  define('MODULE_PAYMENT_MONEYBOOKERS_ERRORTEXT1', 'payment_error=');
  define('MODULE_PAYMENT_MONEYBOOKERS_ERRORTEXT2', '&error=Fehler w�hrend Ihrer Bezahlung bei moneybookers.com!');
  define('MODULE_PAYMENT_MONEYBOOKERS_ORDER_TEXT', 'Bestelldatum: ');
  define('MODULE_PAYMENT_MONEYBOOKERS_TEXT_ERROR', 'Fehler bei Zahlung!');
  define('MODULE_PAYMENT_MONEYBOOKERS_CONFIRMATION_TEXT', 'Danke f�r Ihre Bestellung!');
  define('MODULE_PAYMENT_MONEYBOOKERS_TRANSACTION_FAILED_TEXT', 'Ihre Zahlungstransaktion bei moneybookers.com ist fehlgeschlagen. Bitte versuchen Sie es nochmal, oder w�hlen Sie eine andere Zahlungsm�glichkeit!');
  define('MODULE_PAYMENT_MONEYBOOKERS_ORDER_COMMENT1', 'Die Transaktions id f�r diese Bestellung lautet: ');
  define('MODULE_PAYMENT_MONEYBOOKERS_ORDER_COMMENT2', 'Bitte notieren Sie sich diese Transaktionen zur Referenz, und nennen Sie diese gemeinsam mit Ihrer Bestellnummer in Ihren zuk�nftigen Support-Anfragen. Dies erm�glicht uns, Ihnen schneller und effizienter zu helfen. Vielen Dank! PS: Sie k�nnen die Transaktions id jederzeit in Ihrer Konto/Bestell�bersicht, und zwar im Kommentarfeld der Bestellung.');

  define('MODULE_PAYMENT_MONEYBOOKERS_STATUS_TITLE','Moneybookers.com Modul aktivieren');
  define('MODULE_PAYMENT_MONEYBOOKERS_STATUS_DESC','M�chten Sie Zahlungen per Moneybookers.com akzeptieren?');
  define('MODULE_PAYMENT_MONEYBOOKERS_EMAILID_TITLE','eMail Adresse');
  define('MODULE_PAYMENT_MONEYBOOKERS_EMAILID_DESC','Merchant\'s eMail Adresse, die bei Moneybookers.com registriert ist');
  define('MODULE_PAYMENT_MONEYBOOKERS_PWD_TITLE','Moneybookers Passwort');
  define('MODULE_PAYMENT_MONEYBOOKERS_PWD_DESC','Geben Sie Ihr Moneybookers Passwort ein (dieses ist notwendig, un die Transaktion durchzuf�hren!)');
  define('MODULE_PAYMENT_MONEYBOOKERS_REFID_TITLE','Verweis id');
  define('MODULE_PAYMENT_MONEYBOOKERS_REFID_DESC','Ihre pers�nliche Verweis id von Moneybookers.com');
  define('MODULE_PAYMENT_MONEYBOOKERS_SORT_ORDER_TITLE','Anzeigereihenfolge');
  define('MODULE_PAYMENT_MONEYBOOKERS_SORT_ORDER_DESC','Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
  define('MODULE_PAYMENT_MONEYBOOKERS_CURRENCY_TITLE','Transaktionsw�hrung');
  define('MODULE_PAYMENT_MONEYBOOKERS_CURRENCY_DESC','Die W�hrung f�r die Zahlungstransaktion. Wenn Ihre gew�hlte W�hrung nicht bei Moneybookers.com verf�gbar ist, wird diese W�hrung zur Bezahlw�hrung.');
  define('MODULE_PAYMENT_MONEYBOOKERS_LANGUAGE_TITLE','Transaktionssprache');
  define('MODULE_PAYMENT_MONEYBOOKERS_LANGUAGE_DESC','Die Sprache f�r die Zahlungstransaktion. Wenn Ihre gew�hlte Sprache nicht bei Moneybookers.com verf�gbar ist, wird diese Sprache zur Bezahlsprache.');
  define('MODULE_PAYMENT_MONEYBOOKERS_ZONE_TITLE','Zahlungszone');
  define('MODULE_PAYMENT_MONEYBOOKERS_ZONE_DESC','Wenn eine Zone ausgew�hlt ist, gilt die Zahlungsmethode nur f�r diese Zone.');
  define('MODULE_PAYMENT_MONEYBOOKERS_ORDER_STATUS_ID_TITLE','Bestellstatus festlegen');
  define('MODULE_PAYMENT_MONEYBOOKERS_ORDER_STATUS_ID_DESC','Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
  ?>