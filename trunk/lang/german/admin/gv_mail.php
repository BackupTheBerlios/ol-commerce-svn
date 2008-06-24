<?php
/* -----------------------------------------------------------------------------------------
   $Id: gv_mail.php,v 2.0.0 2006/12/14 05:49:22 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(gv_mail.php,v 1.1.2.1 2003/05/15); www.oscommerce.com
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('HEADING_TITLE', 'Gutschein an Kunden versenden');

define('TEXT_CUSTOMER', 'Kunde:');
define('TEXT_SUBJECT', 'Betreff:');
define('TEXT_FROM', 'Absender:');
define('TEXT_TO', 'eMail an:');
define('TEXT_AMOUNT', 'Wert:');
define('TEXT_MESSAGE', 'Nachricht:');
define('TEXT_SINGLE_EMAIL', '<span class="smallText">Benutzen Sie dieses Feld nur für einzelne eMails, ansonsten bitte das Feld '.TEXT_CUSTOMER.' benutzen</span>');
define('TEXT_SELECT_CUSTOMER', 'Kunde auswählen');
define('TEXT_ALL_CUSTOMERS', 'Alle Kunden');
define('TEXT_NEWSLETTER_CUSTOMERS', 'An alle Rundschreiben-Abonnenten');

define('NOTICE_EMAIL_SENT_TO', 'Hinweis: eMail wurde versandt an: %s');
define('ERROR_NO_CUSTOMER_SELECTED', 'Fehler: Es wurde kein Kunde ausgewählt.');
define('ERROR_NO_AMOUNT_SELECTED', 'Fehler: Sie haben keinen Betrag für den Gutschein eingegeben.');

define('TEXT_GV_WORTH', 'Der Gutscheinwert beträgt ');
define('TEXT_TO_REDEEM', 'Um Ihren Gutschein zu verbuchen, klicken Sie auf den unten stehenden Link. Bitte notieren Sie sich zur Sicherheit Ihren persönlichen Gutschein-Code.');
define('TEXT_WHICH_IS', 'Ihr Gutscheincode lautet: ');
define('TEXT_IN_CASE', ' Falls es wider Erwarten zu Problemen beim verbuchen kommen sollte.');
define('TEXT_OR_VISIT', 'besuchen Sie unsere Webseite ');
define('TEXT_ENTER_CODE', ' und geben den Gutschein-Code bitte manuell ein ');

define ('TEXT_REDEEM_COUPON_MESSAGE_HEADER', 'Sie haben kürzlich in unserem Online-Shop einen Gutschein gekauft, welcher aus Sicherheitsgründen nicht sofort freigeschaltet wurde. Dieses Guthaben steht Ihnen nun zur Verfügung.');
define ('TEXT_REDEEM_COUPON_MESSAGE_AMOUNT', "\n\n" . 'Der Wert Ihres Gutscheines beträgt %s');
define ('TEXT_REDEEM_COUPON_MESSAGE_BODY', "\n\n" . 'Sie können nun über Ihr persönliches Konto den Gutschein an jemanden versenden.');
define ('TEXT_REDEEM_COUPON_MESSAGE_FOOTER', "\n\n");
?>