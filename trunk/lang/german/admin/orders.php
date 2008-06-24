<?php
/* --------------------------------------------------------------
$Id: orders.php,v 2.0.0 2006/12/14 05:49:24 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(orders.php,v 1.27 2003/02/16); www.oscommerce.com
(c) 2003	    nextcommerce (orders.php,v 1.7 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/
define('TEXT_BANK', 'Bankeinzug');
define('TEXT_BANK_OWNER', 'Kontoinhaber:');
define('TEXT_BANK_NUMBER', 'Kontonummer:');
define('TEXT_BANK_BLZ', 'BLZ:');
define('TEXT_BANK_NAME', 'Bank:');
define('TEXT_BANK_FAX', 'Einzugsermächtigung wird per Fax bestätigt');
define('TEXT_BANK_STATUS', 'Prüfstatus:');
define('TEXT_BANK_PRZ', 'Prüfverfahren:');

define('TEXT_BANK_ERROR_1', 'Kontonummer stimmt nicht mit BLZ überein!');
define('TEXT_BANK_ERROR_2', 'Für diese Kontonummer ist kein Prüfverfahren definiert!');
define('TEXT_BANK_ERROR_3', 'Kontonummer nicht prüfbar! Prüfverfahren nicht implementiert');
define('TEXT_BANK_ERROR_4', 'Kontonummer technisch nicht prüfbar!');
define('TEXT_BANK_ERROR_5', 'Bankleitzahl nicht gefunden!');
define('TEXT_BANK_ERROR_8', 'Keine Bankleitzahl angegeben!');
define('TEXT_BANK_ERROR_9', 'Keine Kontonummer angegeben!');
define('TEXT_BANK_ERRORCODE', 'Fehlercode:');

define('HEADING_TITLE', 'Bestellungen');
define('HEADING_TITLE_SEARCH', 'Bestell-Nr.:');
define('HEADING_TITLE_STATUS', 'Status:');

define('TABLE_HEADING_COMMENTS', 'Kommentar');
define('TABLE_HEADING_CUSTOMERS', 'Kunden');
define('TABLE_HEADING_ORDER_TOTAL', 'Gesamtwert');
define('TABLE_HEADING_DATE_PURCHASED', 'Bestelldatum');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TABLE_HEADING_QUANTITY', 'Anzahl');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Artikel-Nr.');
define('TABLE_HEADING_PRODUCTS', 'Artikel');
define('TABLE_HEADING_TAX', 'MwSt.');
define('TABLE_HEADING_TOTAL', 'Gesamtsumme');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Preis (exkl.)');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Preis (inkl.)');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Total (exkl.)');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Total');

define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Kunde benachrichtigt');
define('TABLE_HEADING_DATE_ADDED', 'hinzugefügt am:');
define('TABLE_HEADING_PAYMENT_STATUS', TABLE_HEADING_STATUS);

define('ENTRY_CUSTOMER', 'Kunde:');
define('ENTRY_SOLD_TO', 'Rechnungsadresse:');
define('ENTRY_STREET_ADDRESS', 'Strasse:');
define('ENTRY_SUBURB', 'zus. Anschrift:');
define('ENTRY_CITY', 'Stadt:');
define('ENTRY_POST_CODE', 'PLZ:');
define('ENTRY_STATE', 'Bundesland:');
define('ENTRY_COUNTRY', 'Land:');
define('ENTRY_TELEPHONE', 'Telefon:');
define('ENTRY_EMAIL_ADDRESS', 'eMail Adresse:');
define('ENTRY_DELIVERY_TO', 'Lieferanschrift:');
define('ENTRY_SHIP_TO', ENTRY_DELIVERY_TO);
define('ENTRY_SHIPPING_ADDRESS', 'Versandadresse:');
define('ENTRY_BILLING_ADDRESS', 'Rechnungsadresse:');
define('ENTRY_PAYMENT_METHOD', 'Zahlungsweise:');
define('ENTRY_CREDIT_CARD_TYPE', 'Kreditkartentyp:');
define('ENTRY_CREDIT_CARD_OWNER', 'Kreditkarteninhaber:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Kreditkartennnummer:');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Kreditkarte läuft ab am:');
define('ENTRY_SUB_TOTAL', 'Zwischensumme:');
define('ENTRY_TAX', 'MwSt.:');
define('ENTRY_SHIPPING', 'Versandkosten:');
define('ENTRY_TOTAL', 'Gesamtsumme:');
define('ENTRY_DATE_PURCHASED', 'Bestelldatum:');
define('ENTRY_STATUS', 'Status:');
//	W. Kaiser - Erlaube Sendungstracking
define('ENTRY_TRACKCODE', 'Sendungscode');
define('ENTRY_TRACKCODE_EXPLAIN', '&nbsp;&nbsp;('.ENTRY_TRACKCODE.' für die Sendungsverfolgung)');
define('ENTRY_TRACK_URL_TEXT','<br/><b>Zur Sendungsverfolgung hier klicken</b>');
//	W. Kaiser - Erlaube Sendungstracking
define('STATUS_SENT', 'Versendet');
define('ENTRY_DATE_LAST_UPDATED', 'zuletzt aktualisiert am:');
define('ENTRY_NOTIFY_CUSTOMER', 'Kunde benachrichtigen:');
define('ENTRY_NOTIFY_COMMENTS', 'Kommentare mitsenden:');
define('ENTRY_PRINTABLE', 'Rechnung drucken');
define('ENTRY_PRINTABLE_PACKINGSLIP', 'Lieferschein drucken');
define('ENTRY_VALIDATE_ADDRESS', 'Adresse über das Internet validieren');
define('ENTRY_SEND_GIFT', 'Gutschein versenden');
define('ENTRY_REMOVE_CVV', 'Kreditkarten-Info löschen');

define('TEXT_INFO_HEADING_DELETE_ORDER', 'Bestellung löschen');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, das Sie diese Bestellung löschen möchten?');
define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Artikelanzahl dem Lager gutschreiben');
define('TEXT_DATE_ORDER_CREATED', 'Erstellt am:');
define('TEXT_DATE_ORDER_LAST_MODIFIED', 'Letzte Änderung:');
define('TEXT_INFO_PAYMENT_METHOD', 'Zahlungsweise:');

define('TEXT_ALL_ORDERS', 'Alle Bestellungen');
define('TEXT_NO_ORDER_HISTORY', 'Keine Bestellhistorie verfügbar');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Status-Änderung Ihrer Bestellung');
define('EMAIL_TEXT_ORDER_NUMBER', 'Bestell-Nr.:');
define('EMAIL_TEXT_INVOICE_URL', 'Ihre Bestellung können Sie unter folgender Adresse einsehen:');
define('EMAIL_TEXT_DATE_ORDERED', 'Bestelldatum:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Der Status Ihrer Bestellung wurde aktualisiert.' . "\n\n" . 'Neuer Status: %s' . "\n\n" . 'Bei Fragen zu Ihrer Bestellung antworten Sie bitte auf diese eMail.' . "\n\n" . 'Mit freundlichen Grüssen' . NEW_LINE);
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Anmerkungen und Kommentare zu Ihrer Bestellung:' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', 'Fehler: Die Bestellung existiert nicht!.');
define('SUCCESS_ORDER_UPDATED', 'Erfolg: Die Bestellung wurde erfolgreich aktualisiert.');
define('WARNING_ORDER_NOT_UPDATED', 'Hinweis: Es wurde nichts geändert. Daher wurde diese Bestellung nicht aktualisiert.');

define('TABLE_HEADING_DISCOUNT','Rabatt');
define('ENTRY_CUSTOMERS_GROUP','Kundengruppe:');
?>