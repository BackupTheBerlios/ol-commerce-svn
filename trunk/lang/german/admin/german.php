<?php
/* --------------------------------------------------------------
$Id: german.php,v 2.0.0 2006/12/14 05:49:22 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(german.php,v 1.99 2003/05/28); www.oscommerce.com
(c) 2003	    nextcommerce (german.php,v 1.24 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contributions:
Customers Status v3.x (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

// look in your $PATH_LOCALE/locale directory for available locales..
// on RedHat6.0 I used 'de_DE'
// on FreeBSD 4.0 I use 'de_DE.ISO_8859-1'
// this may not work under win32 environments..
setlocale(LC_TIME, 'de_DE.ISO_8859-1');
setlocale(LC_NUMERIC,'C');			//Do  n o t (repeat:  n o t) change this!!! W. Kaiser
define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
define('PHP_DATE_TIME_FORMAT', 'd.m.Y H:i:s'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
if (!function_exists("olc_date_raw"))
{
	function olc_date_raw($date, $reverse = false) {
		if ($reverse) {
			return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
		} else {
			return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
		}
	}
}

// Global entries for the <html> tag
define('HTML_PARAMS','dir="ltr" lang="de"');


// page title
define('TITLE', 'OL-Commerce ');

// header text in includes/header.php
define('HEADER_TITLE_TOP', 'Administration');
define('HEADER_TITLE_SUPPORT_SITE', 'Supportseite');
define('HEADER_TITLE_ONLINE_CATALOG', 'Online Katalog');
define('HEADER_TITLE_ADMINISTRATION', 'Administration');

// text for gender
define('MALE', 'Herr');
define('FEMALE', 'Frau');

// text for date of birth example
define('DOB_FORMAT_STRING', 'tt.mm.jjjj');

// configuration box text in includes/boxes/configuration.php

define('BOX_HEADING_ADMIN','Verwaltung');
define('BOX_HEADING_CONFIGURATION','Konfiguration');
define('BOX_HEADING_SYSTEM','System');
define('BOX_HEADING_MODULES','Module');
define('BOX_HEADING_ZONE','Land/Steuer');
define('BOX_HEADING_CUSTOMERS','Kunden');
define('BOX_HEADING_PRODUCTS','Produktkatalog');
define('BOX_HEADING_STATISTICS','Statistiken');
define('BOX_HEADING_TOOLS','Hilfsprogramme');

define('BOX_CONTENT_TEXT','Inhalte Manager');
define('TEXT_CUSTOMERS','Kunde: ');
define('TEXT_ALLOWED', 'Erlaubnis');
define('TEXT_ACCESS', 'Zugriffsbereich');
define('BOX_CONFIGURATION', 'Grundeinstellungen');
define('BOX_CONFIGURATION_1', 'Mein Shop');
define('BOX_BOX_CONFIGURATION', 'Bildschirm-Layout');
define('BOX_CONFIGURATION_2', 'Minumum Werte');
define('BOX_CONFIGURATION_3', 'Maximum Werte');
define('BOX_CONFIGURATION_4', 'Bild Optionen');
define('BOX_CONFIGURATION_5', 'Kunden Details');
define('BOX_CONFIGURATION_6', 'Modul Optionen');
define('BOX_CONFIGURATION_7', 'Versand Optionen');
define('BOX_CONFIGURATION_8', 'Produkt Listen Optionen');
define('BOX_CONFIGURATION_9', 'Lagerverwaltungs Optionen');
define('BOX_CONFIGURATION_10', 'Log Optionen');
define('BOX_CONFIGURATION_11', 'Cache Optionen');
define('BOX_CONFIGURATION_12', 'eMail Optionen');
define('BOX_CONFIGURATION_13', 'Download Optionen');
define('BOX_CONFIGURATION_14', 'Gzip Kompression');
define('BOX_CONFIGURATION_15', 'Sessions');
define('BOX_CONFIGURATION_16', 'Meta-Tags/Suchmaschinen');
define('BOX_CONFIGURATION_17', 'Zusatzmodule');
define('BOX_CONFIGURATION_18', 'Slideshows');
define('BOX_CONFIGURATION_19','Import/Export');
define('BOX_CONFIGURATION_100', 'Firmen-Daten');
define('BOX_MODULES', 'Zahlungs-/Versand-/Verrechnungs-Module');
define('BOX_PAYMENT', 'Zahlungsoptionen');
define('BOX_LAYOUT', 'Bildschirm-Layout');
define('BOX_SHIPPING', 'Versandart');
define('BOX_ORDER_TOTAL', 'Zusammenfassung');
define('BOX_CATEGORIES', 'Kategorien / Artikel');
define('BOX_PRODUCTS_ATTRIBUTES', 'Artikelmerkmale');
define('BOX_MANUFACTURERS', 'Hersteller');
define('BOX_REVIEWS', 'Produktbewertungen');
define('BOX_XSELL_PRODUCTS', 'Quervermarktung');
define('BOX_SPECIALS', 'Sonderangebote');
define('BOX_PRODUCTS_EXPECTED', 'Erwartete Artikel');
define('BOX_CUSTOMERS', 'Kunden');
define('BOX_ACCOUNTING', 'Adminrechte Verwaltung');
define('BOX_CUSTOMERS_STATUS','Kundengruppen');
define('BOX_ORDERS', 'Bestellungen');
define('BOX_ORDERS_STATISTISCS', 'Bestellstatistik');
define('BOX_COUNTRIES', 'Land');
define('BOX_ZONES', 'Bundesländer');
define('BOX_GEO_ZONES', 'Steuerzonen');
define('BOX_TAX_CLASSES', 'Steuerklassen');
define('BOX_TAX_RATES', 'Steuersätze');
define('BOX_HEADING_REPORTS', 'Berichte');
define('BOX_PRODUCTS_VIEWED', 'Besuchte Artikel');
define('BOX_STOCK_WARNING','Lager Bericht');
define('BOX_PRODUCTS_PURCHASED', 'Gekaufte Artikel');
define('BOX_STATS_CUSTOMERS', 'Kunden-Bestellstatistik');
define('BOX_BACKUP', 'Datenbank Manager');
define('BOX_BANNER_MANAGER', 'Banner Manager');
define('BOX_CACHE', 'Cache Steuerung');
define('BOX_DEFINE_LANGUAGE', 'Sprachen definieren');
define('BOX_FILE_MANAGER', 'Datei-Manager');
define('BOX_MAIL', 'eMail versenden');
define('BOX_NEWSLETTERS', 'Rundschreiben Manager');
define('BOX_SERVER_INFO', 'Server Info');
define('BOX_WHOS_ONLINE', 'Wer ist Online');
define('BOX_WHOS_ONLINE_LIVE', BOX_WHOS_ONLINE.' (<b>Live</b>)');
define('BOX_LIVE_HELP','Live Hilfe (<b>Live</b>)');
define('BOX_LIVE_HELP_ADMIN','Live Hilfe <b>Admin</b>');
define('BOX_PAYPAL_IPN','PayPal IPN Übersicht');
define('BOX_TPL_BOXES','Box Reihenfolge');
define('BOX_CURRENCIES', 'Währungen');
define('BOX_LANGUAGES', 'Sprachen');
define('BOX_ORDERS_STATUS', 'Bestellstatus');
define('BOX_ATTRIBUTES_MANAGER','Attribut Verwaltung');
define('BOX_PRODUCTS_ATTRIBUTES','Optionsgruppen');
define('BOX_SHIPPING_STATUS','Lieferstatus');
define('BOX_SALES_REPORT','Umsatzstatistik');
define('BOX_MODULE_EXPORT','Export-Module');
define('BOX_HEADING_GV_ADMIN', 'Gutscheine/Kupons');
define('BOX_GV_ADMIN_QUEUE', 'Gutschein Queue');
define('BOX_GV_ADMIN_MAIL', 'Gutschein eMail');
define('BOX_GV_ADMIN_SENT', 'Gutscheine versandt');
define('BOX_HEADING_COUPON_ADMIN','Rabattkupons');
define('BOX_COUPON_ADMIN','Kupon Admin');
define('BOX_TOOLS_BLACKLIST','KK-Blacklist');
$s='</b>-Import/Export';
define('BOX_XXC_IMPORT','<b>xxCommerce'.$s);
$s.='/-Export';
define('BOX_IMPORT_EXPORT_PRODUCTS', '<b>Artikel'.$s);
define('BOX_IMPORT_EXPORT_CUSTOMERS', '<b>Kunden'.$s);

//	W. Kaiser Google Sitemap
define('BOX_GOOGLE_SITEMAP', 'Google Sitemap');
//	W. Kaiser Google Sitemap

//	W. Kaiser chCounter
define('BOX_CHCOUNTER', 'Shop-Statistik (chCounter)');
//	W. Kaiser chCounter

//W. Kaiser Blz-Update
define('BOX_BLZ_UPDATE', 'BLZ Update');
//W. Kaiser Blz-Update

//W. Kaiser CAO
define('BOX_CAO', 'CAO Export');
//W. Kaiser CAO

//W. Kaiser Elm@r
define('BOX_ELMAR', 'Elm@r (Elektronischer Markt)');
//W. Kaiser Elm@r

define('BOX_FROOGLE', 'Froogle');
define('BOX_PRODUCTS_VPE','Verpackungseinheit');
define('BOX_PDF_EXPORT', 'PDF-Katalog erstellen');
define('BOX_PDF_DATASHEET','PDF-Datenblatt Generator');
define('BOX_PDF_INVOICE', 'PDF-Rechnungen Layout');
define('BOX_MENUES_TEMPLATES', 'Menüs/Templates');
define('BOX_EBAY_CONNECTOR','eBay-Konnektor');
define('BOX_EBAY_AUCTIONS','eBay-Auktionen');
define('BOX_ADODB_STATS', 'ADODB Statistik');
define('TXT_GROUPS','<b>Gruppen</b>:');
define('TXT_SYSTEM','System');
define('TXT_CUSTOMERS','Kunden'.SLASH.BOX_ORDERS);
define('TXT_PRODUCTS','Artikel/Kategorien');
define('TXT_STATISTICS','Statistiktools');
define('TXT_TOOLS','Zusatzprogramme');
define('TEXT_ACCOUNTING','Zugriffseinstellungen für:');

//Dividers text for menu

define('BOX_HEADING_MODULES', 'Module');
define('BOX_HEADING_LOCALIZATION', 'Sprachen/Währungen');
define('BOX_HEADING_TEMPLATES','Templates');
define('BOX_HEADING_TOOLS', 'Hilfsprogramme');
define('BOX_HEADING_LOCATION_AND_TAXES', 'Land / Steuer');
define('BOX_HEADING_CUSTOMERS', 'Kunden');
define('BOX_HEADING_CATALOG', 'Katalog');
define('BOX_MODULE_NEWSLETTER','Rundschreiben');

// javascript messages
define('JS_ERROR', 'Während der Eingabe sind Fehler aufgetreten!\nBitte korrigieren Sie folgendes:\n\n');

define('JS_OPTIONS_VALUE_PRICE', '* Sie müssen diesem Wert einen Preis zuordnen\n');
define('JS_OPTIONS_VALUE_PRICE_PREFIX', '* Sie müssen ein Vorzeichen für den Preis angeben (+/-)\n');

define('JS_PRODUCTS_NAME', '* Der neue Artikel muss einen Namen haben\n');
define('JS_PRODUCTS_DESCRIPTION', '* Der neue Artikel muss eine Beschreibung haben\n');
define('JS_PRODUCTS_PRICE', '* Der neue Artikel muss einen Preis haben\n');
define('JS_PRODUCTS_WEIGHT', '* Der neue Artikel muss eine Gewichtsangabe haben\n');
define('JS_PRODUCTS_QUANTITY', '* Sie müssen dem neuen Artikel eine verfügbare Anzahl zuordnen\n');
define('JS_PRODUCTS_MODEL', '* Sie müssen dem neuen Artikel eine Artikel-Nr. zuordnen\n');
define('JS_PRODUCTS_IMAGE', '* Sie müssen dem Artikel ein Bild zuordnen\n');

define('JS_SPECIALS_PRODUCTS_PRICE', '* Es muss ein neuer Preis für diesen Artikel festgelegt werden\n');

define('JS_GENDER', '* Die \'Anrede\' muss ausgewählt werden.\n');
define('JS_FIRST_NAME', '* Der \'Vorname\' muss mindestens aus ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_LAST_NAME', '* Der \'Nachname\' muss mindestens aus ' . ENTRY_LAST_NAME_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_DOB', '* Das \'Geburtsdatum\' muss folgendes Format haben: xx.xx.xxxx (Tag/Jahr/Monat).\n');
define('JS_EMAIL_ADDRESS', '* Die \'eMail-Adresse\' muss mindestens aus ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_ADDRESS', '* Die \'Strasse\' muss mindestens aus ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_POST_CODE', '* Die \'Postleitzahl\' muss mindestens aus ' . ENTRY_POSTCODE_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_CITY', '* Die \'Stadt\' muss mindestens aus ' . ENTRY_CITY_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_STATE', '* Das \'Bundesland\' muss ausgewählt werden.\n');
define('JS_STATE_SELECT', '-- Wählen Sie oberhalb --');
define('JS_ZONE', '* Das \'Bundesland\' muss aus der Liste für dieses Land ausgewählt werden.');
define('JS_COUNTRY', '* Das \'Land\' muss ausgewählt werden.\n');
define('JS_TELEPHONE', '* Die \'Telefonnummer\' muss aus mindestens ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_PASSWORD', '* Das \'Passwort\' sowie die \'Passwortbestätigung\' müssen übereinstimmen und aus mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen bestehen.\n');

define('JS_ORDER_DOES_NOT_EXIST', 'Auftragsnummer %s existiert nicht!');

define('CATEGORY_PERSONAL', 'Persönliche Daten');
define('CATEGORY_ADDRESS', 'Adresse');
define('CATEGORY_CONTACT', 'Kontakt');
define('CATEGORY_COMPANY', 'Firma');
define('CATEGORY_OPTIONS', 'Weitere Optionen');

define('ENTRY_GENDER', 'Anrede:');
define('ENTRY_GENDER_ERROR', '&nbsp;<span class="errorText">notwendige Eingabe</span>');
define('ENTRY_FIRST_NAME', 'Vorname:');
define('ENTRY_FIRST_NAME_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_LAST_NAME', 'Nachname:');
define('ENTRY_LAST_NAME_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_LAST_NAME_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_DATE_OF_BIRTH', 'Geburtsdatum:');
define('ENTRY_DATE_OF_BIRTH_ERROR', '&nbsp;<span class="errorText">(z.B. 21.05.1970)</span>');
define('ENTRY_EMAIL_ADDRESS', 'eMail Adresse:');
define('ENTRY_EMAIL_ADDRESS_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', '&nbsp;<span class="errorText">ungültige eMail Adresse!</span>');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', '&nbsp;<span class="errorText">Diese eMail Adresse existiert schon!</span>');
define('ENTRY_COMPANY', 'Firmenname:');
define('ENTRY_STREET_ADDRESS', 'Strasse:');
define('ENTRY_STREET_ADDRESS_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_SUBURB', 'Adress-Zusatz:');
define('ENTRY_POST_CODE', 'Postleitzahl:');
define('ENTRY_POST_CODE_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_POSTCODE_MIN_LENGTH . ' Zahlen</span>');
define('ENTRY_CITY', 'Stadt:');
define('ENTRY_CITY_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_CITY_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_STATE', 'Bundesland:');
define('ENTRY_STATE_ERROR', '&nbsp;<span class="errorText">notwendige Eingabe</font></small>');
define('ENTRY_COUNTRY', 'Land:');
define('ENTRY_TELEPHONE_NUMBER', 'Telefonnummer:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Zahlen</span>');
define('ENTRY_FAX_NUMBER', 'Telefaxnummer:');
define('ENTRY_NEWSLETTER', 'Rundschreiben:');
define('ENTRY_CUSTOMERS_STATUS', 'Kundengruppe:');
define('ENTRY_NEWSLETTER_YES', 'abonniert');
define('ENTRY_NEWSLETTER_NO', 'nicht abonniert');
define('ENTRY_MAIL_ERROR','&nbsp;<span class="errorText">Bitte treffen sie eine Auswahl</span>');
define('ENTRY_PASSWORD','Passwort (autom. erstellt)');
define('ENTRY_PASSWORD_ERROR','&nbsp;<span class="errorText">Ihr Passwort muss aus mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen bestehen.</span>');
define('ENTRY_MAIL_COMMENTS','Zusätzlicher eMailtext:');

define('ENTRY_MAIL','eMail mit Passwort an Kunden versenden?');
define('YES','ja');
define('NO','nein');
define('SAVE_ENTRY','Änderungen Speichern?');
define('TEXT_CHOOSE_INFO_TEMPLATE','Vorlage für Artikeldetails');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE','Vorlage für Artikeloptionen');
define('TEXT_SELECT','-- Bitte wählen Sie --');

// images
define('IMAGE_ANI_SEND_EMAIL', 'eMail versenden');
define('IMAGE_BACK', 'Zurück');
define('IMAGE_BACKUP', 'Datensicherung');
define('IMAGE_CANCEL', 'Abbruch');
define('IMAGE_CONFIRM', 'Bestätigen');
define('IMAGE_COPY', 'Kopieren');
define('IMAGE_COPY_TO', 'Kopieren nach');
define('IMAGE_DETAILS', 'Details');
define('IMAGE_DELETE', 'Löschen');
define('IMAGE_EDIT', 'Bearbeiten');
define('IMAGE_EMAIL', 'eMail versenden');
define('IMAGE_FILE_MANAGER', 'Datei-Manager');
define('IMAGE_ICON_STATUS_GREEN', 'Aktiv');
define('IMAGE_ICON_STATUS_GREEN_LIGHT', 'aktivieren');
define('IMAGE_ICON_STATUS_RED', 'Inaktiv');
define('IMAGE_ICON_STATUS_RED_LIGHT', 'deaktivieren');
define('IMAGE_ICON_INFO', 'Information');
define('IMAGE_ICON_ARROW', 'Bearbeiten');
define('IMAGE_INSERT', 'Einfügen');
define('IMAGE_LOCK', 'Sperren');
define('IMAGE_MODULE_INSTALL', 'Modul Installieren');
define('IMAGE_MODULE_REMOVE', 'Modul Entfernen');
define('IMAGE_MOVE', 'Verschieben');
define('IMAGE_NEW_BANNER', 'Neuen Banner aufnehmen');
define('IMAGE_NEW_CATEGORY', 'Neue Kategorie erstellen');
define('IMAGE_NEW_COUNTRY', 'Neues Land aufnehmen');
define('IMAGE_NEW_CURRENCY', 'Neue Währung einfügen');
define('IMAGE_NEW_FILE', 'Neue Datei');
define('IMAGE_NEW_FOLDER', 'Neues Verzeichnis');
define('IMAGE_NEW_LANGUAGE', 'Neue Sprache anlegen');
define('IMAGE_NEW_NEWSLETTER', 'Neues Rundschreiben');
define('IMAGE_NEW_PRODUCT', 'Neuen Artikel aufnehmen');
define('IMAGE_NEW_TAX_CLASS', 'Neue Steuerklasse erstellen');
define('IMAGE_NEW_TAX_RATE', 'Neuen Steuersatz anlegen');
define('IMAGE_NEW_TAX_ZONE', 'Neue Steuerzone erstellen');
define('IMAGE_NEW_ZONE', 'Neues Bundesland einfügen');
define('IMAGE_ORDERS', BOX_ORDERS);
define('IMAGE_ORDERS_INVOICE', 'Rechnung');
define('IMAGE_ORDERS_PACKINGSLIP', 'Lieferschein');
define('IMAGE_PREVIEW', 'Vorschau');
define('IMAGE_RESET', 'Zurücksetzen');
define('IMAGE_RESTORE', 'Zurücksichern');
define('IMAGE_SAVE', 'Speichern');
define('IMAGE_SEARCH', 'Suchen');
define('IMAGE_SELECT', 'Auswählen');
define('IMAGE_SEND', 'Versenden');
define('IMAGE_SEND_EMAIL', 'eMail versenden');
define('IMAGE_UNLOCK', 'Entsperren');
define('IMAGE_UPDATE', 'Aktualisieren');
define('IMAGE_UPDATE_CURRENCIES', 'Wechselkurse aktualisieren');
define('IMAGE_UPLOAD', 'Hochladen');
define('IMAGE_ACCOUNTING','Accounting');
define('IMAGE_STATUS','Kundengruppe');
define('IMAGE_IPLOG','IP-Log');
define('CREATE_ACCOUNT','Neuer Kunde');

define('ICON_CROSS', 'Falsch');
define('ICON_CURRENT_FOLDER', 'Aktueller Ordner');
define('ICON_DELETE', 'Löschen');
define('ICON_ERROR', 'Fehler');
define('ICON_FILE', 'Datei');
define('ICON_FILE_DOWNLOAD', 'Herunterladen');
define('ICON_FOLDER', 'Ordner');
define('ICON_LOCKED', 'Gesperrt');
define('ICON_PREVIOUS_LEVEL', 'Vorherige Ebene');
define('ICON_PREVIEW', 'Vorschau');
define('ICON_STATISTICS', 'Statistik');
define('ICON_SUCCESS', 'Erfolg');
define('ICON_TICK', 'Wahr');
define('ICON_UNLOCKED', 'Entsperrt');
define('ICON_WARNING', 'Warnung');

// constants for use in olc_prev_next_display function
define('TEXT_RESULT_PAGE', 'Seite %s von %d');
define('TEXT_DISPLAY_NUMBER_OF','Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> ');
define('TEXT_DISPLAY_NUMBER_OF_BANNERS', TEXT_DISPLAY_NUMBER_OF.'Bannern)');
define('TEXT_DISPLAY_NUMBER_OF_COUNTRIES', TEXT_DISPLAY_NUMBER_OF.'Ländern)');
define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS', TEXT_DISPLAY_NUMBER_OF.'Kunden)');
define('TEXT_DISPLAY_NUMBER_OF_CURRENCIES', TEXT_DISPLAY_NUMBER_OF.'Währungen)');
define('TEXT_DISPLAY_NUMBER_OF_LANGUAGES', TEXT_DISPLAY_NUMBER_OF.'Sprachen)');
define('TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS', TEXT_DISPLAY_NUMBER_OF.'Herstellern)');
define('TEXT_DISPLAY_NUMBER_OF_NEWSLETTERS', TEXT_DISPLAY_NUMBER_OF.'Rundschreiben)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', TEXT_DISPLAY_NUMBER_OF.'Bestellungen)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS_STATUS', TEXT_DISPLAY_NUMBER_OF.'Bestellstatussen)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_VPE', TEXT_DISPLAY_NUMBER_OF.'Verpackungseinheiten)');
define('TEXT_DISPLAY_NUMBER_OF_SHIPPING_STATUS', TEXT_DISPLAY_NUMBER_OF.'Lieferstatusse)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', TEXT_DISPLAY_NUMBER_OF.'Artikeln)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_EXPECTED', TEXT_DISPLAY_NUMBER_OF.'erwarteten Artikeln)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', TEXT_DISPLAY_NUMBER_OF.'Bewertungen)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', TEXT_DISPLAY_NUMBER_OF.'Sonderangeboten)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_CLASSES', TEXT_DISPLAY_NUMBER_OF.'Steuerklassen)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_ZONES', TEXT_DISPLAY_NUMBER_OF.'Steuerzonen)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_RATES', TEXT_DISPLAY_NUMBER_OF.'Steuersätzen)');
define('TEXT_DISPLAY_NUMBER_OF_ZONES', TEXT_DISPLAY_NUMBER_OF.'Bundesländern)');

define('PREVNEXT_BUTTON_PREV', '<<');
define('PREVNEXT_BUTTON_NEXT', '>>');

define('TEXT_DEFAULT', 'Standard');
define('TEXT_SET_DEFAULT', 'als Standard definieren');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">* Erforderlich</span>');

define('ERROR_NO_DEFAULT_CURRENCY_DEFINED', 'Fehler: Es wurde keine Standardwährung definiert. Bitte definieren Sie unter Adminstration -> Sprachen/Währungen -> Währungen eine Standardwährung.');

define('TEXT_CACHE_CATEGORIES', 'Kategorien Box');
define('TEXT_CACHE_MANUFACTURERS', 'Hersteller Box');
define('TEXT_CACHE_ALSO_PURCHASED', 'Ebenfalls gekauft Modul');

define('TEXT_NONE', '--keine--');
define('TEXT_TOP', 'Top');

define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Fehler: Speicherort existiert nicht.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Fehler: Speicherort ist nicht beschreibbar.');
define('ERROR_FILE_NOT_SAVED', 'Fehler: Datei wurde nicht gespeichert.');
define('ERROR_FILETYPE_NOT_ALLOWED', 'Fehler: Dateityp ist nicht erlaubt.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Erfolg: Hochgeladene Datei wurde erfolgreich gespeichert.');
define('WARNING_NO_FILE_UPLOADED', 'Warnung: Es wurde keine Datei hochgeladen.');

define('DELETE_ENTRY','Eintrag löschen?');
define('TEXT_PAYMENT_ERROR','<b>WARNUNG:</b><br/>Bitte Aktivieren Sie ein Zahlungsmodul!');
define('TEXT_SHIPPING_ERROR','<b>WARNUNG:</b><br/>Bitte Aktivieren Sie ein Versandmodul!');

define('TEXT_NETTO','Netto: ');

define('ENTRY_CID','Kundennummer:');
define('IP','Bestell IP:');
define('CUSTOMERS_MEMO','Memos:');
define('DISPLAY_MEMOS','Anzeigen/Schreiben');
define('TITLE_MEMO','Kunden MEMO');
define('ENTRY_LANGUAGE','Sprache:');
define('CATEGORIE_NOT_FOUND','Kategorie nicht vorhanden');

define('IMAGE_RELEASE', 'Gutschein einlösen');

define('_JANUARY', 'Januar');
define('_FEBRUARY', 'Februar');
define('_MARCH', 'März');
define('_APRIL', 'April');
define('_MAY', 'Mai');
define('_JUNE', 'Juni');
define('_JULY', 'Juli');
define('_AUGUST', 'August');
define('_SEPTEMBER', 'September');
define('_OCTOBER', 'Oktober');
define('_NOVEMBER', 'November');
define('_DECEMBER', 'Dezember');

define('TEXT_DISPLAY_NUMBER_OF_GIFT_VOUCHERS', TEXT_DISPLAY_NUMBER_OF.'Gutscheinen)');
define('TEXT_DISPLAY_NUMBER_OF_COUPONS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> ((von insgesamt <b>%d</b> Kupons)');

define('TEXT_VALID_PRODUCTS_LIST', 'Artikelliste');
define('TEXT_VALID_PRODUCTS_ID', 'Artikelnummer');
define('TEXT_VALID_PRODUCTS_NAME', 'Artikelname');
define('TEXT_VALID_PRODUCTS_MODEL', 'Artikelmodell');
define('TEXT_PRODUCTS_VPE_DESCRIPTION','<br/>(VPE-Einheit,VPE-Name,Grundpreis-Anzeige-Name');

define('TEXT_VALID_CATEGORIES_LIST', 'Kategorieliste');
define('TEXT_VALID_CATEGORIES_ID', 'Kategorienummer');
define('TEXT_VALID_CATEGORIES_NAME', 'Kategoriename');

define('SECURITY_CODE_LENGTH_TITLE', 'Länge des Gutscheincodes');
define('SECURITY_CODE_LENGTH_DESC', 'Geben Sie hier die Länge des Gutscheincode ein. (max. 16 Zeichen)');

define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_TITLE', 'Willkommens-Geschenk Gutschein Wert');
define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_DESC', 'Willkommens-Geschenk Gutschein Wert: Wenn Sie keinen Gutschein in Ihrer Willkommens-eMail versenden wollen, tragen Sie hier 0 ein, ansonsten geben Sie den Wert des Gutscheins an, zB. 10.00 oder 50.00, aber keine Währungszeichen');
define('NEW_SIGNUP_DISCOUNT_COUPON_TITLE', 'Willkommens-Rabatt Kupon Code');
define('NEW_SIGNUP_DISCOUNT_COUPON_DESC', 'Willkommens-Rabatt Kupon Code: Wenn Sie keinen Kupon in Ihrer Willkommens-eMail versenden wollen, lassen Sie dieses Feld leer, ansonsten tragen Sie den Kupon Code ein, den Sie verwenden wollen');

define('TXT_ALL','Alle');
if (SHOW_AFFILIATE)
{
	// inclusion for affiliate program
	include('affiliate_german.php');
}
// Beschreibung für Abmeldelink im Newsletter
define('TEXT_NEWSLETTER_REMOVE_LINK', 'Um sich von unserem Newsletter abzumelden klicken Sie auf den folgenden Link:');
define('TEXT_NEWSLETTER_REMOVE', 'Vom Newsletter abmelden');

//W. Kaiser Down for Maintenance
//Beschreibung für Admin Gruppen-Kopf" Wartungsarbeiten"
define('BOX_HEADING_DOWN_FOR_MAINTENANCE','Wartungsarbeiten');
// Beschreibung für Admin Link "Wartungsarbeiten"
define('BOX_DOWN_FOR_MAINTENANCE',BOX_HEADING_DOWN_FOR_MAINTENANCE . ' verwalten');

define('DOWN_FOR_MAINTENANCE_NAME','<B>Wartungsabschaltung: </b>');
define('DOWN_FOR_MAINTENANCE_TITLE', DOWN_FOR_MAINTENANCE_NAME . 'AN/AUS');
define('DOWN_FOR_MAINTENANCE_DESC', DOWN_FOR_MAINTENANCE_NAME . '<br/>(\'true\'=An, \'false\'=Aus)');
define('EXCLUDE_ADMIN_IP_FOR_MAINTENANCE_TITLE', DOWN_FOR_MAINTENANCE_NAME . 'Diese IP-Addresse zulassen');
define('EXCLUDE_ADMIN_IP_FOR_MAINTENANCE_DESC', EXCLUDE_ADMIN_IP_FOR_MAINTENANCE_TITLE .
'<br/>Diese IP-Addresse darf die Website während der Wartungsabschaltung bearbeiten (Administrator?)');
define('ADMIN_PASSWORD_FOR_MAINTENANCE_TITLE', DOWN_FOR_MAINTENANCE_NAME . 'Dieses Passwort zulassen');
define('ADMIN_PASSWORD_FOR_MAINTENANCE_DESC', ADMIN_PASSWORD_FOR_MAINTENANCE_TITLE .
'<br/>Wird der Shop mit dem Parameter "allowmaintenance=xxxxxxxxxx("xxxxxxxxxx" = Passwort) aufgerufen,<br/>dann darf der Benutzer die Website während der Wartungsabschaltung bearbeiten (Administrator?).<br/>Eine Alternative für den Fall, dass Sie keine feste IP-Adresse haben.)');
define('WARN_BEFORE_DOWN_FOR_MAINTENANCE_TITLE',  DOWN_FOR_MAINTENANCE_NAME . 'Vor der Wartungsabschaltung eine WARNUNG anzeigen');
define('WARN_BEFORE_DOWN_FOR_MAINTENANCE_DESC', WARN_BEFORE_DOWN_FOR_MAINTENANCE_TITLE .
'<br/>(\'true\'=Ja, \'false\'=Nein)<br/>(Wenn Sie \'Wartungsabschaltung: AN/AUS\' auf \'true\' setzen, wird dieser Wert automatisch auf \'false\' gesetzt.');
define('PERIOD_DOWN_FOR_MAINTENANCE_TITLE',  DOWN_FOR_MAINTENANCE_NAME . 'Datum und Dauer der Wartungsabschaltung');
define('PERIOD_DOWN_FOR_MAINTENANCE_DESC', PERIOD_DOWN_FOR_MAINTENANCE_TITLE . '<br/>Geben Sie Datum und Dauer der Wartungsabschaltung ein');

$s='Diese Website ist wegen Wartungsarbeiten ';
define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', $s.'nicht erreichbar am: ');
define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', $s.'zur Zeit nicht erreichbar!');
//W. Kaiser Down for Maintenance

define('PARSE_TIME_STRING','Ausführungszeit: %s Sekunden');

define('IE_ONLY', HTML_BR.'(<b>Nur mit Internet Explorer!</b>)');
define('TEXT_RENAME_DIR','<b><font color="Red">Löschen Sie unbedingt das Verzeichnis "olc_installer" (oder benennen Sie es um). Andernfalls könnte Ihr Shop von Aussen manipuliert werden!</font></b>');

define('ADMIN_SUBTITLE_CENTRAL','OLC Zentrale');

/*
define('ADMIN_CONFIG_ACTUAL_VALUE','Aktueller Wert: ');
define('ADMIN_MODULE_INSTALLED', 'Installiert: ');
define('ADMIN_CONFIG_UNDEFINED_CONSTANT', '*** Undefiniert: ');
*/

$s='<font class="act_config_value_text">';
$s1=' </font><font class="act_config_value">';
define('ADMIN_CONFIG_ACTUAL_VALUE',$s.'Aktueller Wert:'.$s1);
define('ADMIN_MODULE_INSTALLED', $s.'Installiert:'.$s1);
define('ADMIN_CONFIG_UNDEFINED_CONSTANT', $s.'*** Undefiniert: </font><font class="undefined_config_value">');
//W. Kaiser Down for Maintenance
?>