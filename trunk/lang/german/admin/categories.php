<?php
/* --------------------------------------------------------------
$Id: categories.php,v 2.0.0 2006/12/14 05:49:16 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(categories.php,v 1.22 2002/08/17); www.oscommerce.com
(c) 2003	    nextcommerce (categories.php,v 1.10 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/
define('TEXT_EDIT_STATUS', 'Status');
define('HEADING_TITLE', 'Kategorien / Artikel');
define('HEADING_TITLE_SEARCH', 'Suche: ');
define('HEADING_TITLE_GOTO', 'Gehe zu:');

define('TABLE_HEADING_ID', 'id');
define('TABLE_HEADING_CATEGORIES_PRODUCTS', 'Kategorien / Artikel');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_STOCK','Lager Warnung');

define('TEXT_WARN_MAIN','Haupt');
define('TEXT_WARN_ATTRIBUTE','Option');
define('TEXT_EXISTING_PRODUCT', 'Artikel %s');
define('TEXT_NEW_PRODUCT', 'Neuer '.TEXT_EXISTING_PRODUCT);
define('TEXT_CATEGORIES', 'Kategorien:');
define('TEXT_SUBCATEGORIES', 'Unterkategorien:');
define('TEXT_PRODUCTS', 'Artikel:');
define('TEXT_PRODUCTS_PRICE_INFO', 'Preis:');
define('TEXT_PRODUCTS_TAX_CLASS', 'Steuerklasse:');
define('TEXT_PRODUCTS_AVERAGE_RATING', 'durchschnittl. Bewertung:');
define('TEXT_PRODUCTS_QUANTITY_INFO', 'Anzahl:');
define('TEXT_PRODUCTS_DISCOUNT_ALLOWED_INFO', 'Maximal erlaubter Rabatt:');
define('TEXT_DATE_ADDED', 'Hinzugefügt am:');
define('TEXT_DATE_AVAILABLE', 'Erscheinungsdatum:');
define('TEXT_LAST_MODIFIED', 'Letzte änderung:');
define('TEXT_IMAGE_NONEXISTENT', 'BILD EXISTIERT NICHT');
define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 'Bitte fügen Sie eine neue Kategorie oder einen Artikel in <br/>&nbsp;<br/><b>%s</b> ein.');
define('TEXT_PRODUCT_MORE_INFORMATION', 'Für weitere Informationen, besuchen Sie bitte die <a href="http://%s" target="blank"><u>Homepage</u></a> des Herstellers.');
define('TEXT_PRODUCT_DATE_ADDED', 'Diesen Artikel haben wir am %s in unseren Katalog aufgenommen.');
define('TEXT_PRODUCT_DATE_AVAILABLE', 'Dieser Artikel ist erhältlich ab %s.');
define('TEXT_CHOOSE_INFO_TEMPLATE', 'Artikel-Info Vorlage:');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE', 'Artikel-Optionen Vorlage:');
define('TEXT_SELECT', 'Bitte auswählen:');
define('TEXT_NO_FILE', 'Keine Vorlage(n) vorhanden');

define('TEXT_EDIT_INTRO', 'Bitte führen Sie alle notwendigen Änderungen durch.');
define('TEXT_EDIT_CATEGORIES_ID', 'Kategorie id:');
define('TEXT_EDIT_CATEGORIES_NAME', 'Kategorie Name:');
define('TEXT_EDIT_CATEGORIES_HEADING_TITLE', 'Kategorie-Überschrift:');
define('TEXT_EDIT_CATEGORIES_DESCRIPTION', 'Kategorie-Beschreibung:');
define('TEXT_EDIT_CATEGORIES_IMAGE', 'Kategorie Bild:');

define('TEXT_EDIT_SORT_ORDER', 'Sortierreihenfolge:');

define('TEXT_INFO_COPY_TO_INTRO', 'Bitte wählen Sie eine neue Kategorie aus, in die Sie den Artikel kopieren möchten:');
define('TEXT_INFO_CURRENT_CATEGORIES', 'Aktuelle Kategorien:');

define('TEXT_INFO_HEADING_NEW_CATEGORY', 'Neue Kategorie');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Kategorie bearbeiten');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Kategorie löschen');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Kategorie verschieben');
define('TEXT_INFO_HEADING_DELETE_PRODUCT', 'Artikel löschen');
define('TEXT_INFO_HEADING_MOVE_PRODUCT', 'Artikel verschieben');
define('TEXT_INFO_HEADING_COPY_TO', 'Kopieren nach');

define('TEXT_DELETE_CATEGORY_INTRO', 'Sind Sie sicher, dass Sie diese Kategorie löschen möchten?');
define('TEXT_DELETE_PRODUCT_INTRO', 'Sind Sie sicher, dass Sie diesen Artikel löschen möchten?');

define('TEXT_DELETE_WARNING_CHILDS', '<b>WARNUNG:</b> Es existieren noch %s (Unter-)Kategorien, die mit dieser Kategorie verbunden sind!');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>WARNING:</b> Es existieren noch %s Artikel, die mit dieser Kategorie verbunden sind!');

define('TEXT_MOVE_PRODUCTS_INTRO', 'Bitte wählen Sie die übergordnete Kategorie, in die Sie <b>%s</b> verschieben möchten');
define('TEXT_MOVE_CATEGORIES_INTRO', 'Bitte wählen Sie die übergordnete Kategorie, in die Sie <b>%s</b> verschieben möchten');
define('TEXT_MOVE', 'Verschiebe <b>%s</b> nach:');

define('TEXT_NEW_CATEGORY_INTRO', 'Bitte geben Sie die neue Kategorie mit allen relevanten Daten ein.');
define('TEXT_CATEGORIES_NAME', 'Kategorie Name:');
define('TEXT_CATEGORIES_IMAGE', 'Kategorie Bild:');

define('TEXT_META_TITLE', 'Meta Title:');
define('TEXT_META_DESCRIPTION', 'Meta Description:');
define('TEXT_META_KEYWORDS', 'Meta Keywords:');

define('TEXT_SORT_ORDER', 'Sortierreihenfolge:');

define('TEXT_PRODUCTS_STATUS', 'Artikelstatus:');
define('TEXT_PRODUCTS_DATE_AVAILABLE', 'Erscheinungsdatum:');
define('TEXT_PRODUCT_AVAILABLE', 'Auf Lager');
define('TEXT_PRODUCT_NOT_AVAILABLE', 'Nicht Vorrätig');
define('TEXT_PRODUCTS_MANUFACTURER', 'Artikelhersteller:');
define('TEXT_PRODUCTS_NAME', 'Artikelname:');
define('TEXT_PRODUCTS_DESCRIPTION', 'Artikelbeschreibung:');
define('TEXT_PRODUCTS_AUCTION_DESCRIPTION', 'Auktionsbeschreibung:');
define('TEXT_PRODUCTS_QUANTITY', 'Artikelanzahl:');
define('TEXT_PRODUCTS_MODEL', 'Artikel-Nr.:');
define('TEXT_PRODUCTS_IMAGE', 'Artikelbild:');
define('TEXT_PRODUCTS_URL', 'Herstellerlink:');
define('TEXT_PRODUCTS_URL_WITHOUT_HTTP', '<small>(ohne führendes http://)</small>');
define('TEXT_PRODUCTS_PRICE', 'Artikelpreis:');
define('TEXT_PRODUCTS_WEIGHT', 'Artikelgewicht:');
define('TEXT_DELETE', 'Löschen');

define('EMPTY_CATEGORY', 'Leere Kategorie');

define('TEXT_HOW_TO_COPY', 'Kopiermethode:');
define('TEXT_COPY_AS_LINK', 'Produkt verlinken');
define('TEXT_COPY_AS_DUPLICATE', 'Produkt duplizieren');

define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Fehler: Produkte können nicht in der gleichen Kategorie verlinkt werden.');
$error='Fehler: Das Verzeichnis \'images\' im Katalogverzeichnis ist ';
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', $error.'schreibgeschützt!');
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', $error.'nicht vorhanden!');

define('TEXT_PRODUCTS_DISCOUNT_ALLOWED','Rabatt erlaubt:');
define('HEADING_PRICES_OPTIONS','<b>Preis-Optionen</b>');
define('HEADING_PRODUCT_OPTIONS','<b>Artikel-Optionen</b>');
define('TEXT_PRODUCTS_WEIGHT_INFO','<small>(kg)</small>');
define('TEXT_PRODUCTS_SHORT_DESCRIPTION','Kurzbeschreibung:');
define('TXT_STK','Einheiten: ');
define('TXT_PRICE',' à: ');
define('TXT_NETTO','Nettopreis: ');
define('TEXT_NETTO','Netto: ');
define('TXT_STAFFELPREIS','Staffelpreise');

define('HEADING_PRODUCTS_MEDIA','<b>Artikelmedium</b>');
define('TABLE_HEADING_PRICE','Preis');

define('TEXT_CHOOSE_INFO_TEMPLATE','Artikel-Details Vorlage');
//define('TEXT_SELECT','--bitte wählen--');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE','Optionen-Details Vorlage');
define('SAVE_ENTRY','Speichern?');

define('TEXT_FSK18','FSK 18:');
define('TEXT_CHOOSE_INFO_TEMPLATE_CATEGORIE','Vorlage für Kategorieübersicht');
define('TEXT_CHOOSE_INFO_TEMPLATE_LISTING','Vorlage für Produktübersicht');
define('TEXT_PRODUCTS_SORT','Sortierung:');
define('TEXT_EDIT_PRODUCT_SORT_ORDER','Artikel-Sortierung');
define('TXT_PRICES','Preis');
define('TXT_NAME','Artikelname');
define('TXT_ORDERED','Bestellte Artikel');
define('TXT_SORT','Sortierung');
define('TXT_WEIGHT','Gewicht');
define('TXT_QTY','Auf Lager');

define('TEXT_MULTICOPY','Multiple');
define('TEXT_MULTICOPY_DESC','Produkt in folgende Kategorien Verlinken/Kopieren (falls ausgewählt, werden Einstellungen von "Single" ignoriert)');
define('TEXT_SINGLECOPY','Single');
define('TEXT_SINGLECOPY_DESC','Produkt in folgende Kategorie Verlinken/Kopieren (Unter "Multiple" keine Kateogorie aktiviert)');

define('TEXT_PRODUCTS_VPE',' VPE:');
define('TEXT_PRODUCTS_VPE_VISIBLE','Anzeige'.TEXT_PRODUCTS_VPE);
define('TEXT_PRODUCTS_VPE_VALUE',' Wert:');

//W. Kaiser - Baseprice
define('TEXT_PRODUCTS_BASEPRICE_SHOW','Anzeige Grundpreis');
define('TEXT_PRODUCTS_BASEPRICE_VALUE',' Grundpreis-Menge');
//W. Kaiser - Baseprice

//W. Kaiser - Minimum order
define('TEXT_PRODUCTS_MINORDER_QTY','Mindestabnahme:');
define('TEXT_PRODUCTS_MINORDER_VPE',TEXT_PRODUCTS_VPE);
//W. Kaiser - Minimum order
//W. Kaiser - UVP
define('TEXT_PRODUCTS_UVP','Unverb. Preisempfehlung:');
//W. Kaiser - UVP

define('PROMOTION_ON','Promotion aktivieren?');
define('PROMOTION_HEADER','Produkt Promotion');
define('PROMOTION_PRODUCT_TITLE','Artikel-Name als Promotion-Titel?');
define('PROMOTION_PRODUCT_DESCRIPTION','Artikel-Beschreibung als Promotion-Text?');

define('PROMOTION_TITLE','Promotion-Titel (max. 255 Zeichen)');
define('PROMOTION_IMAGE','Promotion-Grafik einfügen');
define('PROMOTION_DELETE','Promotion-Grafik löschen?');
define('PROMOTION_DESCRIPTION','Promotion-Beschreibung');
?>
