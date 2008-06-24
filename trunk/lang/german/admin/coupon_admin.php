<?php
/* -----------------------------------------------------------------------------------------
   $Id: coupon_admin.php,v 2.0.0 2006/12/14 05:49:19 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(Kupon_admin.php,v 1.1.2.2 2003/05/15); www.oscommerce.com
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:

   Credit Class/Gift Vouchers/Discount Kupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('TOP_BAR_TITLE', 'Statistik');
define('HEADING_TITLE', 'Rabatt Kupons');
define('HEADING_TITLE_STATUS', 'Status : ');
define('TEXT_CUSTOMER', 'Kunde:');
define('TEXT_COUPON', 'Kupon Name');
define('TEXT_COUPON_ALL', 'Alle Kupons');
define('TEXT_COUPON_ACTIVE', 'Aktive Kupons');
define('TEXT_COUPON_INACTIVE', 'Inaktive Kupons');
define('TEXT_SUBJECT', 'Betreff:');
define('TEXT_FROM', 'von:');
define('TEXT_FREE_SHIPPING', 'Versandkostenfrei');
define('TEXT_MESSAGE', 'Nachricht:');
define('TEXT_SELECT_CUSTOMER', 'Kunde auswählen');
define('TEXT_ALL_CUSTOMERS', 'Alle Kunden');
define('TEXT_NEWSLETTER_CUSTOMERS', 'Alle Newsletter Abonnenten');
define('TEXT_CONFIRM_DELETE', 'Soll dieser Kupon wirklich gelöscht werden?');

define('TEXT_TO_REDEEM', 'Sie können den Gutschein bei Ihrer Bestellung einlösen. Dazu geben Sie Ihren Gutschein-Code in das dafür vorgesehene Feld ein, und klicken Sie den "Einlösen"-Button.');
define('TEXT_IN_CASE', ' Falls es wider Erwarten zu Problemen beim verbuchen kommen sollte.');
define('TEXT_VOUCHER_IS', 'Ihr Gutschein-Code lautet: ');
define('TEXT_REMEMBER', 'Bewahren Sie Ihren Gutschein-Code gut auf, damit Sie von diesem Angebot profitieren können');
define('TEXT_VISIT', 'wenn Sie uns das nächste mal unter ' . HTTP_SERVER . DIR_WS_CATALOG. ' besuchen.');
define('TEXT_ENTER_CODE', ' und den Code eingeben ');

define('TABLE_HEADING_ACTION', 'Aktion');

define('CUSTOMER_ID_TEXT', 'Kunden Nr.');
define('CUSTOMER_NAME', 'Kunden Name');
define('REDEEM_DATE', 'eingelöst am');
define('IP_ADDRESS', 'IP Adresse');

define('TEXT_REDEMPTIONS', 'Einlösung');
define('TEXT_REDEMPTIONS_TOTAL', 'Insgesamt');
define('TEXT_REDEMPTIONS_CUSTOMER', 'Für diesen Kunden');
define('TEXT_NO_FREE_SHIPPING', 'Nicht Versandkostenfrei');

define('NOTICE_EMAIL_SENT_TO', 'Notiz: eMail versendet an: %s');
define('ERROR_NO_CUSTOMER_SELECTED', 'Fehler: Kein Kunde ausgewählt.');
define('COUPON_NAME', 'Kupon Name');
//define('Kupon_VALUE', 'Kupon Wert');
define('COUPON_AMOUNT', 'Kupon Wert');
define('COUPON_CODE', 'Kupon Code');
define('COUPON_STARTDATE', 'gültig ab');
define('COUPON_FINISHDATE', 'gültig bis');
define('COUPON_FREE_SHIP', 'Versandkostenfrei');
define('COUPON_DESC', 'Kupon Beschreibung');
define('COUPON_MIN_ORDER', 'Kupon Mindestbestellwert');
define('COUPON_USES_COUPON', 'Anzahl/Verwendungen pro Kupon');
define('COUPON_USES_USER', 'Anzahl/Verwendungen pro Kunde');
define('COUPON_PRODUCTS', 'Liste der gültigen Produkte');
define('COUPON_CATEGORIES', 'Liste der gültigen Kategorien');
define('VOUCHER_NUMBER_USED', 'Anzahl Verwendet');
define('DATE_CREATED', 'erstellt am');
define('DATE_MODIFIED', 'geändert am');
define('TEXT_HEADING_NEW_COUPON', 'Neuen Kupon erstellen');
define('TEXT_NEW_INTRO', 'Bitte geben Sie die folgende Informationen für den neuen Kupon an.<br/>');


define('COUPON_NAME_HELP', 'Eine Kurzbezeichnung für den Kupon');
define('COUPON_AMOUNT_HELP', 'Tragen Sie hier den Rabatt für diesen Kupon ein. Entweder einen festen Betrag oder einen prozentualen Rabatt wie z.B. 10%');
define('COUPON_CODE_HELP', 'Hier können Sie einen eigenen Code eintragen (max. 16 Zeichen). Lassen Sie das Feld frei, dann wird dieser Code automatisch generiert.');
define('COUPON_STARTDATE_HELP', 'Das Datum ab dem der Kupon gültig ist');
define('COUPON_FINISHDATE_HELP', 'Das Datium an dem der Kupon abläuft');
define('COUPON_FREE_SHIP_HELP', 'Kupon für eine versandkostenfreie Lieferung. <b>Achtung:</b> Der Kupon Wert wird dabei nicht mehr berücksichtigt! Der Mindestbestellwert bleibt gültig.');
define('COUPON_DESC_HELP', 'Beschreibung des Kupons für den Kunden');
define('COUPON_MIN_ORDER_HELP', 'Mindestbestellwert ab dem dieser Kupon gültig ist');
define('COUPON_USES_COUPON_HELP', 'Tragen Sie hier ein wie oft dieser Kupon eingelöst werden darf. Lassen Sie das Feld frei, dann ist die Benutzung unlimitiert.');
define('COUPON_USES_USER_HELP', 'Tragen Sie hier ein wie oft ein Kunde diesen Kupon einlösen darf. Lassen Sie das Feld frei, dann ist die Benutzung unlimitiert.');
define('COUPON_PRODUCTS_HELP', 'Eine durch Komma getrennte Liste von product_ids für die dieser Kupon gültig ist. Ein leeres Feld bedeutet keine Einschränkung.');
define('COUPON_CATEGORIES_HELP', 'Eine durch Komma getrennte Liste von Kategorien (cpaths) für die dieser Kupon gültig ist. Ein leeres Feld bedeutet keine Einschränkung.');
?>