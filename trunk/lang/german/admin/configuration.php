<?php
/* -----------------------------------------------------------------------------------------
$Id: configuration.php,v 2.0.0 2006/12/14 05:49:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(configuration.php,v 1.8 2002/01/04); www.oscommerce.com
(c) 2003	    nextcommerce (configuration.php,v 1.16 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$yes_no='<br/><b>(1 = Ja, 0 = Nein)</b>';

define('TABLE_HEADING_CONFIGURATION_TITLE', 'Name');
define('TABLE_HEADING_CONFIGURATION_VALUE', 'Wert');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_INFO_EDIT_INTRO', 'Bitte führen Sie alle notwendigen Änderungen durch');
define('TEXT_INFO_DATE_ADDED', 'hinzugefügt am:');
define('TEXT_INFO_LAST_MODIFIED', 'letzte Änderung:');

// language definitions for config
define('STORE_NAME_TITLE', 'Name des Shops');
define('STORE_NAME_DESC', 'Der Name dieses Online Shops');
define('STORE_OWNER_TITLE', 'Inhaber');
define('STORE_OWNER_DESC', 'Der Name des Shop-Betreibers');
define('STORE_OWNER_EMAIL_ADDRESS_TITLE', 'eMail Adresse');
define('STORE_OWNER_EMAIL_ADDRESS_DESC', 'Die eMail Adresse des Shop-Betreibers');

define('EMAIL_FROM_TITLE', 'eMail von');
define('EMAIL_FROM_DESC', 'eMail Adresse die beim versenden (send mail)benutzt werden soll.');

define('STORE_COUNTRY_TITLE', 'Land');
define('STORE_COUNTRY_DESC', 'Das Land aus dem der Versand erfolgt <br/><br/><b>Hinweis: Bitte nicht vergessen die Region richtig anzupassen.</b>');
define('STORE_ZONE_TITLE', 'Region');
define('STORE_ZONE_DESC', 'Die Region des Landes aus dem der Versand erfolgt.');

define('EXPECTED_PRODUCTS_SORT_TITLE', 'Reihenfolge für Produktankündigungen');
define('EXPECTED_PRODUCTS_SORT_DESC', 'Das ist die Reihenfolge wie angekündigte Produkte angezeigt werden.');
define('EXPECTED_PRODUCTS_FIELD_TITLE', 'Sortierfeld für Produktankündigungen');
define('EXPECTED_PRODUCTS_FIELD_DESC', 'Das ist die Spalte die zum Sortieren angekündigter Produkte benutzt wird.');

define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE', 'Auf die Landeswährung automatisch umstellen');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC', 'Wenn die Spracheinstellung gewechselt wird automatisch die Währung anpassen.');

define('SEND_EXTRA_ORDER_eMailS_TO_TITLE', 'Senden einer extra Bestell-eMail an:');
define('SEND_EXTRA_ORDER_eMailS_TO_DESC', 'Wenn zusätzlich eine Kopie des Bestell-eMails versendet werden soll, bitte in dieser Weise die Empfangs-Adressen auflisten: Name 1 &lt;eMail@adresse1&gt;, Name 2 &lt;eMail@adresse2&gt;');

$seo=' suchmaschinen-optimierte URLs ';
define('SEARCH_ENGINE_FRIENDLY_URLS_TITLE', 'Verwendung von'.$seo.QUESTION);
define('SEARCH_ENGINE_FRIENDLY_URLS_DESC', '
Die Seiten-URLs werden werden suchmaschinen-optimiert aufgebaut.
<br/><br/>
Beispiele:
<br/><br/>
http://www.server.de/olcommerce/seo-products_info-products_id-144.htm
<br/>
http://www.server.de/olcommerce/seo-index-cPath-1_10.htm
');

define('USE_SEO_EXTENDED_TITLE', 'Erweiterte'.$seo.'benutzen?');
define('USE_SEO_EXTENDED_DESC', '
Die Seiten-URLs werden suchmaschinen-optimiert und aussagefähiger aufgebaut, da in der URL die Produkt- bzw. Kategorien-Namen statt unverständlicher Angaben verwendet werden.
<br/><br/>
Beispiele:
<br/><br/>
http://www.server.de/olcommerce/seo-p-indian_summer;123.htm
<br/>
http://www.server.de/olcommerce/seo-k-seifen-ziegenmilch_seifen.htm
');

define('SEO_SEPARATOR_TITLE', 'Trennzeichen für'.$seo);
define('SEO_SEPARATOR_DESC', 'Wem das Zeichen "<b>-</b>" als Trennzeichen für die Elemente der'.$seo.'nicht gefällt, kann alternativ das Zeichen "<b>/</b>" wählen.');

define('SEO_TERMINATOR_TITLE', 'Dateityp für'.$seo);
define('SEO_TERMINATOR_DESC', 'Wem "<b>.htm</b>" als Dateityp für '.$seo.'nicht gefällt, kann alternativ  "<b>.html</b>" wählen.');

define('DISPLAY_CART_TITLE', 'Soll Warenkorb nach dem Einfügen angezeigt werden?');
define('DISPLAY_CART_DESC', 'Nach dem hinzufügen eines Artikels zum Warenkorb, oder zurück zum Artikel?');

define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE', 'Gästen erlauben, ihre Bekannten per eMail zu informieren?');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC', 'Gästen erlauben, ihre Bekannten per eMail über Produkte zu informieren?');

define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE', 'Suchverknüpfungen');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC', 'Standard Operator zum Verknüpfen von Suchwörtern.');

define('STORE_NAME_ADDRESS_TITLE', 'Geschäftsadresse, Telefonnummer usw.');
define('STORE_NAME_ADDRESS_DESC',
'Tragen Sie hier Ihre Geschäftsadresse wie in einem Briefkopf ein.<br><br>'.
'Dieser Eintrag <b><font color="red">muss</font><b> unbedingt das folgende Format haben:<br><br>'.
'Firmenname<br>Straße<br>Land-Plz Ort<br>Telefon-Nummer<br>Fax-Nummer');

define('SHOW_COUNTS_TITLE', 'Artikelanzahl hinter Kategorienamen?');
define('SHOW_COUNTS_DESC', 'Zählt rekursiv die Anzahl der verschiedenen Artikel pro Warengruppe, und zeigt die anzahl (x) hinter jedem Kategorienamen');

define('DISPLAY_PRICE_WITH_TAX_TITLE', 'Preis inkl. MwSt. anzeigen');
define('DISPLAY_PRICE_WITH_TAX_DESC', 'Preise inklusive Steuer anzeigen (true) oder am Ende aufrechnen (false)');

$customer_status='Kundenstatus (Kundengruppe) für ';
$desc='Wählen Sie den '.$customer_status.'# anhand der jeweiligen Id!';
define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_TITLE', $customer_status.'Administratoren');
define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_DESC', str_replace(HASH,'Administratoren',$desc));
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_TITLE', $customer_status.'Gäste');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_DESC', str_replace(HASH,'Gäste',$desc));
define('DEFAULT_CUSTOMERS_STATUS_ID_COMPANY_TITLE', $customer_status.'Firmen');
define('DEFAULT_CUSTOMERS_STATUS_ID_COMPANY_DESC', str_replace(HASH,'Firmen',$desc));
define('DEFAULT_CUSTOMERS_STATUS_ID_TITLE', 'Kundenstatus für Neukunden');
define('DEFAULT_CUSTOMERS_STATUS_ID_DESC', 'Wählen Sie den Kundenstatus (Gruppe) für Gäste anhand der jeweiligen id!<br/>'.
'TIPP: Sie können im Menü Kundengruppen weitere Gruppen einrichten und z.B. Aktionswochen machen: Diese Woche 10 % Rabatt für alle Neukunden!');
define('CUSTOMER_STATUS_NO_FERNAG_INFO_IDS_TITLE', $customer_status.'Kundengruppen <b>ohne</b> Widerrufsbelehrung');
define('CUSTOMER_STATUS_NO_FERNAG_INFO_IDS_DESC', 'Fügen Sie hier die Kundengruppe(n)-Id(s) für die Kundengruppe(n) ein, die <b>keine</b> Widerrufsbelehrung nach dem Fernabsatsgesetz in der Bestell-Bestätigungs-eMail erhalten sollen (z.B. Händler, Firmen). Mehrere Kundengruppen durch Komma trennen!');

define('ALLOW_ADD_TO_CART_TITLE', 'Erlaubt, Artikel in den Einkaufswagen zu legen');
define('ALLOW_ADD_TO_CART_DESC', 'Erlaubt das Einfügen von Artikeln in den Warenkorb auch dann, wenn "Preise anzeigen" in der Kundengruppe auf "Nein" steht');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_TITLE', 'Rabatte auch auf die Produktattribute verwenden?');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_DESC', 'Erlaubt, den eingestellten Rabatt der Kundengruppe auch auf die Produktattribute anzuwenden (Nur wenn der Artikel nicht als "Sonderangebot" ausgewiesen ist)');
define('ALLOW_CATEGORY_DESCRIPTIONS_TITLE', 'Kategoriebeschreibungen verwenden');
define('ALLOW_CATEGORY_DESCRIPTIONS_DESC', 'Erlaubt das Einfügen von Kategoriebeschreibungen');
define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE', 'Vorname');
define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC', 'Minimum Länge des Vornamens');
define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE', 'Nachname');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC', 'Minimum Länge des Nachnamens');
define('ENTRY_DOB_MIN_LENGTH_TITLE', 'Geburtsdatum');
define('ENTRY_DOB_MIN_LENGTH_DESC', 'Minimum Länge des Geburtsdatums');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE', 'eMail Adresse');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC', 'Minimum Länge der eMail Adresse');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE', 'Straße');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC', 'Minimum Länge der Straßenanschrift');
define('ENTRY_COMPANY_MIN_LENGTH_TITLE', 'Firma');
define('ENTRY_COMPANY_MIN_LENGTH_DESC', 'Minimumlänge des Firmennamens');
define('ENTRY_POSTCODE_MIN_LENGTH_TITLE', 'Postleitzahl');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC', 'Minimum Länge der Postleitzahl');
define('ENTRY_CITY_MIN_LENGTH_TITLE', 'Stadt');
define('ENTRY_CITY_MIN_LENGTH_DESC', 'Minimum Länge des Städtenamens');
define('ENTRY_STATE_MIN_LENGTH_TITLE', 'Bundesland');
define('ENTRY_STATE_MIN_LENGTH_DESC', 'Minimum Länge des Bundeslandes');
define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE', 'Telefon Nummer');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC', 'Minimum Länge der Telefon Nummer');
define('ENTRY_PASSWORD_MIN_LENGTH_TITLE', 'Passwort');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC', 'Minimum Länge des Passwort');

define('CC_OWNER_MIN_LENGTH_TITLE', 'Kreditkarteninhaber');
define('CC_OWNER_MIN_LENGTH_DESC', 'Minimum Länge des Namens des Kreditkarteninhabers');
define('CC_NUMBER_MIN_LENGTH_TITLE', 'Kreditkartennummer');
define('CC_NUMBER_MIN_LENGTH_DESC', 'Minimum Länge von Kreditkartennummern');

define('REVIEW_TEXT_MIN_LENGTH_TITLE', 'Bewertungen');
define('REVIEW_TEXT_MIN_LENGTH_DESC', 'Minimum Länge der Texteingabe bei Bewertungen');

define('MIN_DISPLAY_BESTSELLERS_TITLE', 'Bestseller');
define('MIN_DISPLAY_BESTSELLERS_DESC', 'Minimum Anzahl der Bestseller, die angezeigt werden sollen');
define('MIN_DISPLAY_ALSO_PURCHASED_TITLE', 'Ebenfalls gekauft');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC', 'Minimum Anzahl der ebenfalls gekauften Artikel, die bei der Produktansicht angezeigt werden sollen');

define('MAX_ADDRESS_BOOK_ENTRIES_TITLE', 'Adressbuch Einträge');
define('MAX_ADDRESS_BOOK_ENTRIES_DESC', 'Maximum erlaubte Anzahl an Adressbucheinträgen');
define('MAX_DISPLAY_SEARCH_RESULTS_TITLE', 'Suchergebnisse');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC', 'Anzahl der Artikel die als Suchergebnis angezeigt werden sollen');
define('MAX_DISPLAY_PAGE_LINKS_TITLE', 'Seiten blättern');
define('MAX_DISPLAY_PAGE_LINKS_DESC', 'Anzahl der Einzelseiten, für die ein Link angezeigt werden soll im Seitennavigationsmenü');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE', 'Sonderangebote');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC', 'Maximum Anzahl an Sonderangeboten, die angezeigt werden sollen');
define('MAX_DISPLAY_NEW_PRODUCTS_TITLE', 'Neue Produkte Anzeigemodul');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC', 'Maximum Anzahl an neuen Artikeln, die bei den Warenkategorien angezeigt werden sollen');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE', 'Erwartete Produkte Anzeigemodul');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC', 'Maximum Anzahl an erwarteten Produkten die auf der Startseite angezeigt werden sollen');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE', 'Hersteller-Liste Schwellenwert');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC', 'In der Hersteller Box; Wenn die Anzahl der Hersteller diese Schwelle übersteigt wird anstatt der üblichen Liste eine Popup Liste angezeigt');
define('MAX_MANUFACTURERS_LIST_TITLE', 'Hersteller Liste');
define('MAX_MANUFACTURERS_LIST_DESC', 'In der Hersteller Box; Wenn der Wert auf "1" gesetzt wird, wird die Herstellerbox als Drop Down Liste angezeigt. Andernfalls als Liste.');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE', 'Länge des Herstellernamens');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC', 'In der Hersteller Box; Maximum Länge von Namen in der Herstellerbox');
define('MAX_DISPLAY_NEW_REVIEWS_TITLE', 'Neue Bewertungen');
define('MAX_DISPLAY_NEW_REVIEWS_DESC', 'Maximum Anzahl an neuen Bewertungen die angezeigt werden sollen');
define('MAX_RANDOM_SELECT_REVIEWS_TITLE', 'Auswahlpool der Bewertungen');
define('MAX_RANDOM_SELECT_REVIEWS_DESC', 'Aus wieviel Bewertungen sollen die zufällig angezeigten Bewertungen in der Box ausgewählt werden?');
define('MAX_RANDOM_SELECT_NEW_TITLE', 'Auswahlpool der Neuen Produkte');
define('MAX_RANDOM_SELECT_NEW_DESC', 'Aus wieviel neuen Produkten sollen die zufällig angezeigten neuen Produkte in der Box ausgewählt werden?');
define('MAX_RANDOM_SELECT_SPECIALS_TITLE', 'Auswahlpool der Sonderangebote');
define('MAX_RANDOM_SELECT_SPECIALS_DESC', 'Aus wieviel Sonderangeboten sollen die zufällig angezeigten Sonderangebote in der Box ausgewählt werden?');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE', 'Anzahl an Warengruppen');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC', 'Anzahl an Warengruppen die pro Zeile in den übersichten angezeigt werden sollen.');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE', 'Neue Produkte Liste');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC', 'Maximum Anzahl neuer Produkte die in der Liste angezeigt werden sollen.');
define('MAX_DISPLAY_BESTSELLERS_TITLE', 'Bestsellers');
define('MAX_DISPLAY_BESTSELLERS_DESC', 'Maximum Anzahl an Bestsellern die angezeigt werden sollen');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE', 'Ebenfalls gekauft');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC', 'Maximum Anzahl der ebenfalls gekauften Artikel, die bei der Produktansicht angezeigt werden sollen');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE', 'Bestellübersichts Box');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC', 'Maximum Anzahl an Produkten die in der persönlichen Bestellübersichts Box des Kunden angezeigt werden sollen.');
define('MAX_DISPLAY_ORDER_HISTORY_TITLE', 'Bestellübersicht');
define('MAX_DISPLAY_ORDER_HISTORY_DESC', 'Maximum Anzahl an Bestellungen die in der übersicht im Kundenbereich des Shop angezeigt werden sollen.');

//mo_images
define('MO_PICS_TITLE', 'Anzahl zusätzlicher Produktbilder');
define('MO_PICS_DESC', 'Anzahl der Produktbilder die zusätzlich zum Haupt-Produktbild zur Verfügung stehen.');

define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_TITLE', 'Breite der Produkt-Thumbnails');
define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_DESC', 'Breite der Produkt-Thumbnails in Pixel (bei keiner Eingabe werden diese autom. skaliert)');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_TITLE', 'Höhe der Produkt-Thumbnails');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_DESC', 'Höhe der Produkt-Thumbnails in Pixel (bei keiner Eingabe werden diese autom. skaliert)');

define('PRODUCT_IMAGE_INFO_WIDTH_TITLE', 'Breite der Produkt-Info Bilder');
define('PRODUCT_IMAGE_INFO_WIDTH_DESC', 'Breite der Produkt-Info Bilder in Pixel (bei keiner Eingabe, werden diese autom. skaliert)');
define('PRODUCT_IMAGE_INFO_HEIGHT_TITLE', 'Höhe der Produkt-Info Bilder');
define('PRODUCT_IMAGE_INFO_HEIGHT_DESC', 'Höhe der Produkt-Info Bilder in Pixel (bei keiner Eingabe, werden diese autom. skaliert)');

define('PRODUCT_IMAGE_POPUP_WIDTH_TITLE', 'Breite der Popup Bilder');
define('PRODUCT_IMAGE_POPUP_WIDTH_DESC', 'Breite der Popup Bilder in Pixel (bei keiner Eingabe, werden diese autom. skaliert)');
define('PRODUCT_IMAGE_POPUP_HEIGHT_TITLE', 'Höhe der Popup Bilder');
define('PRODUCT_IMAGE_POPUP_HEIGHT_DESC', 'Höhe der Popup Bilder in Pixel (bei keiner Eingabe, werden diese autom. skaliert)');

define('SMALL_IMAGE_WIDTH_TITLE', 'Small Image Width');
define('SMALL_IMAGE_WIDTH_DESC', 'The pixel width of small images');
define('SMALL_IMAGE_HEIGHT_TITLE', 'Small Image Height');
define('SMALL_IMAGE_HEIGHT_DESC', 'The pixel height of small images');

define('HEADING_IMAGE_WIDTH_TITLE', 'Breite der überschrift Bilder');
define('HEADING_IMAGE_WIDTH_DESC', 'Breite der überschrift Bilder in Pixel');
define('HEADING_IMAGE_HEIGHT_TITLE', 'Höhe der überschrift Bilder');
define('HEADING_IMAGE_HEIGHT_DESC', 'Höhe der überschriftbilder in Pixel');

define('SUBCATEGORY_IMAGE_WIDTH_TITLE', 'Breite der Subkategorie-(Warengruppen-) Bilder');
define('SUBCATEGORY_IMAGE_WIDTH_DESC', 'Breite der Subkategorie-(Warengruppen-) Bilder in Pixel');
define('SUBCATEGORY_IMAGE_HEIGHT_TITLE', 'Höhe der Subkategorie-(Warengruppen-) Bilder');
define('SUBCATEGORY_IMAGE_HEIGHT_DESC', 'Höhe der Subkategorie-(Warengruppen-) Bilder in Pixel');

define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE', 'Bildgröße berechnen');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC', 'Sollen die Bildgrößen berechnet werden?');

define('IMAGE_REQUIRED_TITLE', 'Bilder werden benötigt?');
define('IMAGE_REQUIRED_DESC', 'Wenn Sie hier auf "1" setzen, werden nicht vorhandene Bilder als Rahmen angezeigt. Gut für Entwickler.');

define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_TITLE', 'Products-Thumbnails:Bevel');
define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_DESC', 'Products-Thumbnails:Bevel<br/><br/>Default-values: (8,FFCCCC,330000)<br/><br/>shaded bevelled edges<br/>Usage:<br/>(edge width,hex light colour,hex dark colour)');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_TITLE', 'Products-Thumbnails:Greyscale');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_DESC', 'Products-Thumbnails:Greyscale<br/><br/>Default-values: (32,22,22)<br/><br/>basic black n white<br/>Usage:<br/>(int red,int green,int blue)');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_TITLE', 'Products-Thumbnails:Ellipse');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_DESC', 'Products-Thumbnails:Ellipse<br/><br/>Default-values: (FFFFFF)<br/><br/>ellipse on bg colour<br/>Usage:<br/>(hex background colour)');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_TITLE', 'Products-Thumbnails:Round-edges');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_DESC', 'Products-Thumbnails:Round-edges<br/><br/>Default-values: (5,FFFFFF,3)<br/><br/>corner trimming<br/>Usage:<br/>(edge_radius,background colour,anti-alias width)');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_TITLE', 'Products-Thumbnails:Merge');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_DESC', 'Products-Thumbnails:Merge<br/><br/>Default-values: (overlay.gif,10,-50,60,FF0000)<br/><br/>overlay merge image<br/>Usage:<br/>(merge image,x start [neg = from right],y start [neg = from base],opacity, transparent colour on merge image)');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_TITLE', 'Products-Thumbnails:Frame');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_DESC', 'Products-Thumbnails:Frame<br/><br/>Default-values: <br/><br/>plain raised border<br/>Usage:<br/>(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_TITLE', 'Products-Thumbnails:Drop-Shadow');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_DESC', 'Products-Thumbnails:Drop-Shadow<br/><br/>Default-values: (3,333333,FFFFFF)<br/><br/>more like a dodgy motion blur [semi buggy]<br/>Usage:<br/>(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_TITLE', 'Products-Thumbnails:Motion-Blur');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_DESC', 'Products-Thumbnails:Motion-Blur<br/><br/>Default-values: (4,FFFFFF)<br/><br/>fading parallel lines<br/>Usage:<br/>(int number of lines,hex background colour)');

//And this is for the Images showing your products in single-view

define('PRODUCT_IMAGE_INFO_BEVEL_TITLE', 'Product-Images:Bevel');
define('PRODUCT_IMAGE_INFO_BEVEL_DESC', 'Product-Images:Bevel<br/><br/>Default-values: (8,FFCCCC,330000)<br/><br/>shaded bevelled edges<br/>Usage:<br/>(edge width, hex light colour, hex dark colour)');
define('PRODUCT_IMAGE_INFO_GREYSCALE_TITLE', 'Product-Images:Greyscale');
define('PRODUCT_IMAGE_INFO_GREYSCALE_DESC', 'Product-Images:Greyscale<br/><br/>Default-values: (32,22,22)<br/><br/>basic black n white<br/>Usage:<br/>(int red, int green, int blue)');
define('PRODUCT_IMAGE_INFO_ELLIPSE_TITLE', 'Product-Images:Ellipse');
define('PRODUCT_IMAGE_INFO_ELLIPSE_DESC', 'Product-Images:Ellipse<br/><br/>Default-values: (FFFFFF)<br/><br/>ellipse on bg colour<br/>Usage:<br/>(hex background colour)');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_TITLE', 'Product-Images:Round-edges');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_DESC', 'Product-Images:Round-edges<br/><br/>Default-values: (5,FFFFFF,3)<br/><br/>corner trimming<br/>Usage:<br/>( edge_radius, background colour, anti-alias width)');
define('PRODUCT_IMAGE_INFO_MERGE_TITLE', 'Product-Images:Merge');
define('PRODUCT_IMAGE_INFO_MERGE_DESC', 'Product-Images:Merge<br/><br/>Default-values: (overlay.gif,10,-50,60,FF0000)<br/><br/>overlay merge image<br/>Usage:<br/>(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('PRODUCT_IMAGE_INFO_FRAME_TITLE', 'Product-Images:Frame');
define('PRODUCT_IMAGE_INFO_FRAME_DESC', 'Product-Images:Frame<br/><br/>Default-values: (FFFFFF,000000,3,EEEEEE)<br/><br/>plain raised border<br/>Usage:<br/>(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_TITLE', 'Product-Images:Drop-Shadow');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_DESC', 'Product-Images:Drop-Shadow<br/><br/>Default-values: (3,333333,FFFFFF)<br/><br/>more like a dodgy motion blur [semi buggy]<br/>Usage:<br/>(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_TITLE', 'Product-Images:Motion-Blur');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_DESC', 'Product-Images:Motion-Blur<br/><br/>Default-values: (4,FFFFFF)<br/><br/>fading parallel lines<br/>Usage:<br/>(int number of lines,hex background colour)');

//so this image is the biggest in the shop this

define('PRODUCT_IMAGE_POPUP_BEVEL_TITLE', 'Product-Popup-Images:Bevel');
define('PRODUCT_IMAGE_POPUP_BEVEL_DESC', 'Product-Popup-Images:Bevel<br/><br/>Default-values: (8,FFCCCC,330000)<br/><br/>shaded bevelled edges<br/>Usage:<br/>(edge width,hex light colour,hex dark colour)');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_TITLE', 'Product-Popup-Images:Greyscale');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_DESC', 'Product-Popup-Images:Greyscale<br/><br/>Default-values: (32,22,22)<br/><br/>basic black n white<br/>Usage:<br/>(int red,int green,int blue)');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_TITLE', 'Product-Popup-Images:Ellipse');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_DESC', 'Product-Popup-Images:Ellipse<br/><br/>Default-values: (FFFFFF)<br/><br/>ellipse on bg colour<br/>Usage:<br/>(hex background colour)');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_TITLE', 'Product-Popup-Images:Round-edges');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_DESC', 'Product-Popup-Images:Round-edges<br/><br/>Default-values: (5,FFFFFF,3)<br/><br/>corner trimming<br/>Usage:<br/>(edge_radius,background colour,anti-alias width)');
define('PRODUCT_IMAGE_POPUP_MERGE_TITLE', 'Product-Popup-Images:Merge');
define('PRODUCT_IMAGE_POPUP_MERGE_DESC', 'Product-Popup-Images:Merge<br/><br/>Default-values: (overlay.gif,10,-50,60,FF0000)<br/><br/>overlay merge image<br/>Usage:<br/>(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('PRODUCT_IMAGE_POPUP_FRAME_TITLE', 'Product-Popup-Images:Frame');
define('PRODUCT_IMAGE_POPUP_FRAME_DESC', 'Product-Popup-Images:Frame<br/><br/>Default-values: <br/><br/>plain raised border<br/>Usage:<br/>(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_TITLE', 'Product-Popup-Images:Drop-Shadow');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_DESC', 'Product-Popup-Images:Drop-Shadow<br/><br/>Default-values: (3,333333,FFFFFF)<br/><br/>more like a dodgy motion blur [semi buggy]<br/>Usage:<br/>(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_TITLE', 'Product-Popup-Images:Motion-Blur');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_DESC', 'Product-Popup-Images:Motion-Blur<br/><br/>Default-values: (4,FFFFFF)<br/><br/>fading parallel lines<br/>Usage:<br/>(int number of lines,hex background colour)');


define('ACCOUNT_GENDER_TITLE', 'Anrede');
define('ACCOUNT_GENDER_DESC', 'Die Abfrage für die Anrede im Account benutzen');
define('ACCOUNT_DOB_TITLE', 'Geburtsdatum');
define('ACCOUNT_DOB_DESC', 'Die Abfrage für das Geburtsdatum im Account benutzen');
define('ACCOUNT_COMPANY_TITLE', 'Firma');
define('ACCOUNT_COMPANY_DESC', 'Die Abfrage für die Firma im Account benutzen');
define('ACCOUNT_SUBURB_TITLE', 'Vorort');
define('ACCOUNT_SUBURB_DESC', 'Die Abfrage für den Vorort im Account benutzen');
define('ACCOUNT_STATE_TITLE', 'Bundesland');
define('ACCOUNT_STATE_DESC', 'Die Abfrage für das Bundesland im Account benutzen');

define('DEFAULT_CURRENCY_TITLE', 'Standard Währung');
define('DEFAULT_CURRENCY_DESC', 'Währung die standardmäßig benutzt wird');
define('DEFAULT_LANGUAGE_TITLE', 'Standard Sprache');
define('DEFAULT_LANGUAGE_DESC', 'Sprache die standardmäßig benutzt wird');
define('DEFAULT_ORDERS_STATUS_ID_TITLE', 'Standard Bestellstatus bei neuen Bestellungen');
define('DEFAULT_ORDERS_STATUS_ID_DESC', 'Wenn eine neue Bestellung eingeht, wird dieser Status als Bestellstatus gesetzt.');

define('SHIPPING_ORIGIN_COUNTRY_TITLE', 'Versandland');
define('SHIPPING_ORIGIN_COUNTRY_DESC', 'Wählen Sie das Versandland aus, zur Berechnung korrekter Versandgebühren.');
define('SHIPPING_ORIGIN_ZIP_TITLE', 'Postleitzahl des Versandstandortes');
define('SHIPPING_ORIGIN_ZIP_DESC', 'Bitte geben Sie die Postleitzahl des Versandstandortes ein, der zur Berechnung der Versandkosten in Frage kommt.');
define('SHIPPING_MAX_WEIGHT_TITLE', 'Maximalgewicht, das als ein Paket versendet werden kann');
define('SHIPPING_MAX_WEIGHT_DESC', 'Versandpartner(Post/UPS etc haben ein maximales Paketgewicht. Geben Sie einen Wert dafür ein.');
define('SHIPPING_BOX_WEIGHT_TITLE', 'Paketleergewicht.');
define('SHIPPING_BOX_WEIGHT_DESC', 'Wie hoch ist das Gewicht eines durchschnittlichen kleinen bis mittleren Leerpaketes?');
define('SHIPPING_BOX_PADDING_TITLE', 'Bei größeren Leerpaketen - Gewichtszuwachs in %.');
define('SHIPPING_BOX_PADDING_DESC', 'Für etwa 10% geben Sie 10 ein');

define('PRODUCT_LIST_FILTER_TITLE', 'Anzeige der Sortierungsfilter in Produktlisten?');
define('PRODUCT_LIST_FILTER_DESC', 'Anzeige der Sortierungsfilter für Warengruppen/Hersteller etc Filter (0=inaktiv; 1=aktiv)');

define('STOCK_CHECK_TITLE', 'Überprüfen des Warenbestandes');
define('STOCK_CHECK_DESC', 'Prüfen ob noch genug Ware zum Ausliefern von Bestellungen verfügbar ist.');

define('ATTRIBUTE_STOCK_CHECK_TITLE', 'Überprüfen des Produktattribut Bestandes');
define('ATTRIBUTE_STOCK_CHECK_DESC', 'Überprüfen des Bestandes an Ware mit bestimmten Produktattributen');

define('STOCK_LIMITED_TITLE', 'Warenmenge abziehen');
define('STOCK_LIMITED_DESC', 'Warenmenge im Warenbestand abziehen, wenn die Ware bestellt wurde');
define('STOCK_ALLOW_CHECKOUT_TITLE', 'Einkaufen nicht vorrätiger Ware erlauben');
define('STOCK_ALLOW_CHECKOUT_DESC', 'Möchten Sie auch dann erlauben zu bestellen, wenn bestimmte Ware laut Warenbestand nicht verfügbar ist?');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE', 'Kennzeichnung vergriffener Produkte');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC', 'Dem Kunden kenntlich machen, welche Produkte nicht mehr verfügbar sind.');
define('STOCK_REORDER_LEVEL_TITLE', 'Meldung an den Admin dass ein Produkt nachbestellt werden muss');
define('STOCK_REORDER_LEVEL_DESC', 'Ab welcher Stückzahl soll diese Meldung erscheinen?');

define('STORE_PAGE_PARSE_TIME_TITLE', 'Speichern der Berechnungszeit der Seite');
define('STORE_PAGE_PARSE_TIME_DESC', 'Speicher der Zeit die benötigt wird, um Skripte bis zum Output der Seite zu berechnen');
define('STORE_PAGE_PARSE_TIME_LOG_TITLE', 'Speicherort des Logfile der Berechnungszeit');
define('STORE_PAGE_PARSE_TIME_LOG_DESC', 'Ordner und Filenamen eintragen für den Logfile für Berechnung der Parsing Dauer');
define('STORE_PARSE_DATE_TIME_FORMAT_TITLE', 'Log Datum Format');
define('STORE_PARSE_DATE_TIME_FORMAT_DESC', 'Das Datumsformat für Logging');

define('DISPLAY_PAGE_PARSE_TIME_TITLE', 'Berechnungszeiten der Seiten anzeigen');
define('DISPLAY_PAGE_PARSE_TIME_DESC', 'Wenn das Speichern der Berechnungszeiten für Seiten eingeschaltet ist, können diese im Footer angezeigt werden.');

define('STORE_DB_TRANSACTIONS_TITLE', 'Speichern der Database Queries');
define('STORE_DB_TRANSACTIONS_DESC', 'Speichern der einzelnen Datenbank Queries im Logfile für Berechnungszeiten (PHP4 only)');

define('USE_CACHE_TITLE', 'Cache benutzen');
define('USE_CACHE_DESC', 'Die Cache Features verwenden');

define('DB_CACHE_TITLE','DB Cache');				//Zusatz für Caching
define('DB_CACHE_DESC','SELECT Abfragen können von OL-Commerce gecached werden, um die Datenbankabfragen zu veringern, und die Geschwindigkeit zu erhï¿½hen');	//Zusatz für Caching

define('DB_CACHE_EXPIRE_TITLE','DB Cache Lebenszeit');	//Zusatz für Caching
define('DB_CACHE_EXPIRE_DESC','Zeit in Sekunden, bevor Cache Datein mit Daten aus der Datenbank automatisch überschrieben werden.');	//Zusatz für Caching

define('DIR_FS_CACHE_TITLE', 'Cache Ordner');
define('DIR_FS_CACHE_DESC', 'Der Ordner wo die gecachten Files gespeichert werden sollen');

define('ACCOUNT_OPTIONS_TITLE','Art der Kontoerstellung');
define('ACCOUNT_OPTIONS_DESC','Wie möchten Sie die Anmeldeprozedur in Ihrem Shop gestallten ?<br/>Sie haben die Wahl zwischen Kundenkonten und "einmal Bestellungen" ohne erstellung eines Kundenkontos (es wird ein Konto erstellt, aber dies ist für den Kunden nicht ersichtlich)');

define('EMAIL_TRANSPORT_TITLE', 'eMail Transport Methode');
define('EMAIL_TRANSPORT_DESC', 'Definiert ob der Server eine lokale Verbindung zum "Sendmail-Programm" benutzt oder ob er eine SMTP Verbindung über TCP/IP benötigt. Server die auf Windows oder MacOS laufen sollten SMTP verwenden.');

define('EMAIL_LINEFEED_TITLE', 'eMail Linefeeds');
define('EMAIL_LINEFEED_DESC', 'Definiert die Zeichen die benutzt werden sollen um die Mail Header zu trennen.');
define('EMAIL_USE_HTML_TITLE', 'Benutzen von MIME HTML beim Versand von eMails');
define('EMAIL_USE_HTML_DESC', 'eMails im HTML Format versenden');
define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE', 'Überprüfen der eMail Adressen über DNS');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC', 'Die eMail Adressen können über einen DNS Server geprüft werden');
define('SEND_EMAILS_TITLE', 'Senden von eMails');
define('SEND_EMAILS_DESC', 'eMails an Kunden versenden (bei Bestellungen etc)');
define('SENDMAIL_PATH_TITLE', 'Der Pfad zu Sendmail');
define('SENDMAIL_PATH_DESC', 'Wenn Sie Sendmail benutzen, geben Sie hier den Pfad zum Sendmail Programm an(normalerweise: /usr/bin/sendmail):');
define('SMTP_MAIN_SERVER_TITLE', 'Adresse des SMTP Servers');
define('SMTP_MAIN_SERVER_DESC', 'Geben Sie die Adresse Ihres Haupt SMTP Servers ein.');
define('SMTP_BACKUP_SERVER_TITLE', 'Adresse des SMTP Backup Servers');
define('SMTP_BACKUP_SERVER_DESC', 'Geben Sie die Adresse Ihres Backup SMTP Servers ein.');
define('SMTP_USERNAME_TITLE', 'SMTP Username');
define('SMTP_USERNAME_DESC', 'Bitte geben Sie hier den Usernamen Ihres SMTP Accounts ein.');
define('SMTP_PASSWORD_TITLE', 'SMTP Passwort');
define('SMTP_PASSWORD_DESC', 'Bitte geben Sie hier das Passwort Ihres SMTP Accounts ein.');
define('SMTP_AUTH_TITLE', 'SMTP AUTH');
define('SMTP_AUTH_DESC', 'Erfordert der SMTP Server eine sichere Authentifizierung?');
define('SMTP_PORT_TITLE', 'SMTP Port');
define('SMTP_PORT_DESC', 'Geben sie den SMTP Port Ihres SMTP Servers ein (default: 25)?');

//Constants for contact_us
define('CONTACT_US_EMAIL_ADDRESS_TITLE', 'Kontakt - eMail Adresse');
define('CONTACT_US_EMAIL_ADDRESS_DESC', 'Bitte geben Sie eine korrekte Absender Adresse für das Versenden der eMails über das "Kontakt" Formular ein.');
define('CONTACT_US_NAME_TITLE', 'Kontakt - eMail Adresse, Name');
define('CONTACT_US_NAME_DESC', 'Bitte geben Sie einen Absender Namen für das Versenden der eMails über das "Kontakt" Formular ein.');
define('CONTACT_US_FORWARDING_STRING_TITLE', 'Kontakt - Weiterleitungsadressen');
define('CONTACT_US_FORWARDING_STRING_DESC', 'Geben Sie weitere Mailadressen ein, an welche die eMails des "Kontakt" Formulares noch versendet werden sollen (mit , getrennt)');
define('CONTACT_US_REPLY_ADDRESS_TITLE', 'Kontakt - Antwortadresse');
define('CONTACT_US_REPLY_ADDRESS_DESC', 'Bitte geben Sie eine eMailadresse ein, an die Ihre Kunden Antworten können.');
define('CONTACT_US_REPLY_ADDRESS_NAME_TITLE', 'Kontakt - Antwortadresse, Name');
define('CONTACT_US_REPLY_ADDRESS_NAME_DESC', 'Absendername für Antwortmails.');
define('CONTACT_US_EMAIL_SUBJECT_TITLE', 'Kontakt - eMail Betreff');
define('CONTACT_US_EMAIL_SUBJECT_DESC', 'Betreff für eMails vom Kontaktformular des Shops');

//Constants for support system
define('EMAIL_SUPPORT_ADDRESS_TITLE', 'Technischer Support - eMail Adresse');
define('EMAIL_SUPPORT_ADDRESS_DESC', 'Bitte geben Sie eine korrekte Absender Adresse für das Versenden der eMails über das <b>Support System</b> ein (Kontoerstellung,PasswordÄnderung).');
define('EMAIL_SUPPORT_NAME_TITLE', 'Technischer Support - eMail Adresse, name');
define('EMAIL_SUPPORT_NAME_DESC', 'Bitte geben Sie einen Absender Namen für das Versenden der mails über das <b>Support System</b> ein (Kontoerstellung,PasswordÄnderung).');
define('EMAIL_SUPPORT_FORWARDING_STRING_TITLE', 'Technischer Support - Weiterleitungsadressen');
define('EMAIL_SUPPORT_FORWARDING_STRING_DESC', 'Geben Sie weitere eMailadressen ein, an welche die eMails des <b>Support Systems</b> noch versendet werden sollen (mit , getrennt)');
define('EMAIL_SUPPORT_REPLY_ADDRESS_TITLE', 'Technical Support - Antwortadresse');
define('EMAIL_SUPPORT_REPLY_ADDRESS_DESC', 'Bitte geben Sie eine eMailadresse ein, an die Ihre Kunden Antworten können.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_TITLE', 'Technical Support - Antwortadresse, Name');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_DESC', 'Absendername für Antwortmails.');
define('EMAIL_SUPPORT_SUBJECT_TITLE', 'Technical Support - eMail Betreff');
define('EMAIL_SUPPORT_SUBJECT_DESC', 'Betreff für eMails des <b>Support systems</b>.');

define('EMAIL_BILLING_ADDRESS_TITLE', 'Abrechnung - eMail Adresse');
define('EMAIL_BILLING_ADDRESS_DESC', 'Bitte geben Sie eine korrekte Absenderadresse für das Versenden der mails über das <b>Verrechnungssystem</b> ein (Bestellbestätigung,StatusÄnderungen,..).');
define('EMAIL_BILLING_NAME_TITLE', 'Abrechnung - eMail Adresse, Name');
define('EMAIL_BILLING_NAME_DESC', 'Bitte geben Sie einen Absendernamen für das Versenden der eMails über das <b>Verrechnungssystem</b> ein (Bestellbestätigung,StatusÄnderungen,..).');
define('EMAIL_BILLING_FORWARDING_STRING_TITLE', 'Verrechnung - Weiterleitungsadressen');
define('EMAIL_BILLING_FORWARDING_STRING_DESC', 'Geben Sie weitere Mailadressen ein, wohin die eMails des <b>Verrechnungssystem</b> noch versendet werden sollen (mit , getrennt)');
define('EMAIL_BILLING_REPLY_ADDRESS_TITLE', 'Verrechnung - Antwortadresse');
define('EMAIL_BILLING_REPLY_ADDRESS_DESC', 'Bitte geben Sie eine eMailadresse ein, an die Ihre Kunden Antworten können.');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_TITLE', 'Verrechnung - Antwortadresse, Name');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_DESC', 'Absendername für replay eMails.');
define('EMAIL_BILLING_SUBJECT_TITLE', 'Verrechnung - eMail Betreff');
define('EMAIL_BILLING_SUBJECT_DESC', 'Geben Sie bitte einen eMail-Betreff für eMails des <b>Abrechnung-Systems</b> Ihres Shops ein.');
define('EMAIL_BILLING_SUBJECT_ORDER_TITLE','Verrechnung - eMail Betreff');
define('EMAIL_BILLING_SUBJECT_ORDER_DESC','Geben Sie bitte einen eMailbetreff für Ihre Bestellmails an. (zb: <b>Ihre Bestellung {$nr},am {$date}</b>) ps: folgende Variablen stehen zur Verfügung, {$nr},{$date},{$firstname},{$lastname}');

//Constants for Newsletter
define('EMAIL_NEWSLETTER_PACAKGE_SIZE_TITLE', 'Newsletter - Anzahl der eMails pro "send"-Durchlauf');
define('EMAIL_NEWSLETTER_PACAKGE_SIZE_DESC', 'Hier wird festgelegt, wie viele eMails das Newsletter-Programm in einem Durchlauf sendet. Dies ist notwendig um Skript-Timeouts zu verhindern, wenn der Vorgang zu lange läuft. Das Programm verarbeitet die angegebene Anzahl von eMails, ruft sich dann selbst wieder neu auf um den Rest zu verarbeiten, so lange, bis alle eMails versendet sind');

define('SEND_404_EMAIL_TITLE', 'eMail senden, wenn HTML-Seite nicht gefunden wird');
define('SEND_404_EMAIL_DESC', 'Wenn der Server einen "Fehler 404 (Seite nicht gefunden)" meldet, kann sich der Administrator darüber per eMail unterrichten lassen, um das Problem zu beheben.');

define('DOWNLOAD_ENABLED_TITLE', 'Download von Artikeln erlauben');
define('DOWNLOAD_ENABLED_DESC', 'Die Artikel Download Funktionen einschalten (Software etc).');
define('DOWNLOAD_BY_REDIRECT_TITLE', 'Download durch Redirection');
define('DOWNLOAD_BY_REDIRECT_DESC', 'Browser-Umleitung für Artikeldownloads benutzen. Auf nicht Linux/Unix Systemen ausschalten.');
define('DOWNLOAD_MAX_DAYS_TITLE', 'Verfallsdatum der Download Links(Tage)');
define('DOWNLOAD_MAX_DAYS_DESC', 'Anzahl an Tagen, die ein Download Link für den Kunden aktiv bleibt. 0 bedeutet ohne Limit.');
define('DOWNLOAD_MAX_COUNT_TITLE', 'Maximale Anzahl der Downloads eines gekauften Medienproduktes');
define('DOWNLOAD_MAX_COUNT_DESC', 'Stellen Sie die maximale Anzahl an Downloads ein, die Sie dem Kunden erlauben, der ein Produkt dieser Art erworben hat. 0 bedeutet kein Download.');

define('GZIP_COMPRESSION_TITLE', 'GZip Kompression einschalten');
define('GZIP_COMPRESSION_DESC', 'Schalten Sie HTTP GZip Kompression ein um die Seitenaufbaugeschwindigkeit zu optimieren.');
define('GZIP_LEVEL_TITLE', 'Kompressions Level');
define('GZIP_LEVEL_DESC', 'Wählen Sie einen Kompressionslevel zwischen 0-9 (0 = Minimum, 9 = Maximum).');

define('SESSION_WRITE_DIRECTORY_TITLE', 'Session Speicherort');
define('SESSION_WRITE_DIRECTORY_DESC', 'Wenn Sessions als Files gespeichert werden sollen, benutzen Sie folgenden Ordner.');
define('SESSION_FORCE_COOKIE_USE_TITLE', 'Cookie Benutzung bevorzugen');
define('SESSION_FORCE_COOKIE_USE_DESC', 'Session starten falls Cookies vom Browser erlaubt werden.');
define('SESSION_CHECK_SSL_SESSION_ID_TITLE', 'Checken der SSL Session id');
define('SESSION_CHECK_SSL_SESSION_ID_DESC', 'Überprüfen der SSL_SESSION_ID bei jedem HTTPS Seitenaufruf.');
define('SESSION_CHECK_USER_AGENT_TITLE', 'Überprüfen des User Browsers');
define('SESSION_CHECK_USER_AGENT_DESC', 'Überprüfen des Browsers den der User benutzt, bei jedem Seitenaufruf.');
define('SESSION_CHECK_IP_ADDRESS_TITLE', 'Überprüfen  der IP Adresse');
define('SESSION_CHECK_IP_ADDRESS_DESC', 'Überprüfen der IP Adresse des Users bei jedem Seitenaufruf.');
define('SESSION_BLOCK_SPIDERS_TITLE', 'Spider Sessions vermeiden');
define('SESSION_BLOCK_SPIDERS_DESC', 'Bekannte Suchmaschinen Spider ohne Session auf die Seite lassen.');
define('SESSION_RECREATE_TITLE', 'Session erneuern');
define('SESSION_RECREATE_DESC', 'Erneuern der Session und Zuweisung einer neuen Session id sobald ein User einloggt oder sich registriert (PHP >=4.1 needed).');

define('DISPLAY_CONDITIONS_ON_CHECKOUT_TITLE', 'Unterzeichnen der AGB');
define('DISPLAY_CONDITIONS_ON_CHECKOUT_DESC', 'Anzeigen und Unterzeichnen der AGB beim Bestellvorgang');

define('META_MIN_KEYWORD_LENGTH_TITLE', 'Minimum Länge Meta-Keywords');
define('META_MIN_KEYWORD_LENGTH_DESC', 'Minimum Länge der automatisch erzeugten Meta-Keywords (Produktbeschreibung)');
define('META_KEYWORDS_NUMBER_TITLE', 'Anzahl der Meta-Keywords');
define('META_KEYWORDS_NUMBER_DESC', 'Anzahl der Meta-Keywords');
define('META_AUTHOR_TITLE', 'author');
define('META_AUTHOR_DESC', '<meta name="author">');
define('META_PUBLISHER_TITLE', 'publisher');
define('META_PUBLISHER_DESC', '<meta name="publisher">');
define('META_COMPANY_TITLE', 'company');
define('META_COMPANY_DESC', '<meta name="company">');
define('META_TOPIC_TITLE', 'page-topic');
define('META_TOPIC_DESC', '<meta name="page-topic">');
define('META_REPLY_TO_TITLE', 'reply-to');
define('META_REPLY_TO_DESC', '<meta name="reply-to">');
define('META_REVISIT_AFTER_TITLE', 'revisit-after');
define('META_REVISIT_AFTER_DESC', '<meta name="revisit-after">');
define('META_ROBOTS_TITLE', 'robots');
define('META_ROBOTS_DESC', '<meta name="robots">');
define('META_DESCRIPTION_TITLE', 'Description');
define('META_DESCRIPTION_DESC', '<meta name="description">');
define('META_KEYWORDS_TITLE', 'Keywords');
define('META_KEYWORDS_DESC', '<meta name="keywords">');

define('MODULE_PAYMENT_INSTALLED_TITLE', 'Installierte Zahlungsmodule');
define('MODULE_PAYMENT_INSTALLED_DESC', 'Liste der Zahlungsmodul-Dateinamen (getrennt durch einen Strichpunkt (;)). Diese wird automatisch aktualisiert, daher ist es nicht notwendig diese zu editieren. (Beispiel: cc.php;cod.php;paypal.php)');
define('MODULE_ORDER_TOTAL_INSTALLED_TITLE', 'Installierte Order Total-Module');
define('MODULE_ORDER_TOTAL_INSTALLED_DESC', 'Liste der Order-Total-Modul-Dateinamen (getrennt durch einen Strichpunkt (;)). Diese wird automatisch aktualisiert, daher ist es nicht notwendig diese zu editieren. (Beispiel: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)');
define('MODULE_SHIPPING_INSTALLED_TITLE', 'Installierte Versand Module');
define('MODULE_SHIPPING_INSTALLED_DESC', 'Liste der Versandmodul-Dateinamen (getrennt durch einen Strichpunkt (;)). Diese wird automatisch aktualisiert, daher ist es nicht notwendig diese zu editieren. (Beispiel: ups.php;flat.php;item.php)');

define('CACHE_LIFETIME_TITLE','Cache Lebenszeit');
define('CACHE_LIFETIME_DESC','Zeit in Sekunden, bevor Cache Datein automatisch überschrieben werden.');
define('CACHE_CHECK_TITLE','Prüfe ob Cache modifiziert');
define('CACHE_CHECK_DESC','Wenn "true", dann werden If-Modified-Since headers bei ge-cache-tem Content berücksichtigt, und passende HTTP headers werden ausgegeben. Somit werden regelmässig aufgerufene Seiten nicht jedesmal neu an den Client versandt.');

define('PRODUCT_REVIEWS_VIEW_TITLE','Bewertungen in Artikeldetails');
define('PRODUCT_REVIEWS_VIEW_DESC','Anzahl der angezeigten Bewertungen in der Artikeldetailansicht');

define('MAX_PRODUCTS_QTY_TITLE','Maximale Produkt-Bestellmenge');
define('MAX_PRODUCTS_QTY_DESC','Die maximale Produkt-Bestellmenge in einer Bestellung');

define('DELETE_GUEST_ACCOUNT_TITLE','Löschen von Gast-Konten');
define('DELETE_GUEST_ACCOUNT_DESC','Sollen Gast-Konten nach erfolgter Bestellung gelöscht werden ? (Bestelldaten bleiben erhalten)');

define('USE_SPAW_TITLE','WYSIWYG-Editor aktivieren');
define('USE_SPAW_DESC','WYSIWYG-Editor für CMS und Artikel aktivieren ?');

define('PRICE_IS_BRUTTO_TITLE','Brutto Admin');
define('PRICE_IS_BRUTTO_DESC','Ermöglicht die Eingabe der Bruttopreise im Admin');

define('PRICE_PRECISION_TITLE','Brutto/Netto Dezimalstellen');
define('PRICE_PRECISION_DESC','Umrechnungsgenauigkeit');

define('NO_TAX_RAISED_TITLE','Shop als Kleinunternehmer gemäß §19 UStG führen');
define('NO_TAX_RAISED_DESC','Wenn Sie als Kleinunternehmer gemäß §19 UStG tätig sind, und keine MwSt. erheben und abführen, dann müssen Sie diesen Parameter aktivieren.'.$yes_no);

define('AFFILIATE_INCLUDE_TITLE','"Affilliate"-Programm aktivieren');
define('AFFILIATE_INCLUDE_DESC','Die Programm-Module für das '.SHOW_AFFILIATE_TITLE.$yes_no);

define('CAO_INCLUDE_TITLE','"CAO"-Schnittstelle aktivieren');
define('CAO_INCLUDE_DESC','Die Programm-Module für die '.CAO_INCLUDE_TITLE.$yes_no);

define('EASYSALES_INCLUDE_TITLE','"Eazy Sales"-Schnittstelle aktivieren');
define('EASYSALES_INCLUDE_DESC','Die Programm-Module für die '.EASYSALES_INCLUDE_TITLE.$yes_no);

define('USE_STICKY_CART_TITLE','Den Warenkorb permanent anzeigen (Sticky-Cart)');
define('USE_STICKY_CART_DESC','Eine Kopie des Warenkorbs wird auch dann angezeigt, wenn der Besucher auf einer Seite nach unten scrolled'.$yes_no);

define('USE_PDF_INVOICE_TITLE','Rechnungen/Lieferscheine im PDF-Format erstellen');
define('USE_PDF_INVOICE_DESC',USE_PDF_INVOICE_TITLE.$yes_no);

define('CHECK_CLIENT_AGENT_TITLE','Browser Agent checken?');
define('CHECK_CLIENT_AGENT_DESC','Unterdrücken der Session bei Suchmaschinen');

define('SHOW_IP_LOG_TITLE','IP-Log im Checkout?');
define('SHOW_IP_LOG_DESC','Text "Ihre IP wird aus Sicherheitsgründen gespeichert", beim Checkout anzeigen?');

define('ACTIVATE_GIFT_SYSTEM_TITLE','Gutscheinsystem aktivieren?');
define('ACTIVATE_GIFT_SYSTEM_DESC','Gutscheinsystem aktivieren?');

define('ACTIVATE_SHIPPING_STATUS_TITLE','Versandstatusanzeige aktivieren?');
define('ACTIVATE_SHIPPING_STATUS_DESC','Versandstatusanzeige aktivieren? (Verschiedene Versandzeiten können für einzelne Produkte festgelegt werden. Nach Aktivierung erscheint ein neuer Punkt <b>Lieferstatus</b> bei der Produkteingabe)');

define('SECURITY_CODE_LENGTH_TITLE','Länge des Sicherheitscodes');
define('SECURITY_CODE_LENGTH_DESC','Länge des Sicherheitscodes (Geschenk-Gutschein)');

define('IMAGE_QUALITY_TITLE','Bildqualität');
define('IMAGE_QUALITY_DESC','Bildqualität (0= höchste Kompression, 100=beste Qualität)');

define('GROUP_CHECK_TITLE','Kundengruppencheck für Kategorien');
define('GROUP_CHECK_DESC','Nur bestimmten Kundengruppen Zugang zu einzelnen Kategorien erlauben ? (Nach Aktivierung erscheinen Eingabemöglichkeiten bei Produkten und Kategorien)');

define('ACTIVATE_NAVIGATOR_TITLE','Produktnavigator aktivieren?');
define('ACTIVATE_NAVIGATOR_DESC','Produktnavigator in der Produktdetailansicht aktivieren/deaktivieren (aus performancegründen bei hoher Artikelanzahl)');

define('QUICKLINK_ACTIVATED_TITLE','Multilink/Kopierfunktion aktivieren');
define('QUICKLINK_ACTIVATED_DESC','Die Multilink/Kopierfunktion erleichtert das Kopieren/Verlinken eines Produktes in mehrere Kategorien, durch die Möglichkeit einzelne Kategorien per Checkbox zu selektieren');

//PDF-Datasheet-configurator
define('PDF_SHOW_LOGO_TITLE','Shop-Logo auf dem Datenblatt anzeigen');
define('PDF_SHOW_LOGO_DESC',PDF_SHOW_LOGO_TITLE.$yes_no);
define('PDF_STORE_LOGO_TITLE','Pfad zu dem Shop-Logo');
define('PDF_STORE_LOGO_DESC','Speichern Sie hier den '.PDF_STORE_LOGO_TITLE);
define('PDF_IMAGE_KEEP_PROPORTIONS_TITLE','Seitenverhältnis des Produktbildes beibehalten');
define('PDF_IMAGE_KEEP_PROPORTIONS_DESC',PDF_IMAGE_KEEP_PROPORTIONS_TITLE.$yes_no);
define('PDF_MAX_IMAGE_WIDTH_TITLE','Max. Bildbreite');
$image_text=' des Produktbildes in Millimetern.';
define('PDF_MAX_IMAGE_WIDTH_DESC','Die maximale Breite'.$image_text);
define('PDF_MAX_IMAGE_HEIGHT_TITLE','Max. Bildhöhe');
define('PDF_MAX_IMAGE_HEIGHT_DESC','Die maximale Höhe'.$image_text);
$watermark_text='Wasserzeichen ';
define('PDF_SHOW_WATERMARK_TITLE',$watermark_text.'anzeigen');
define('PDF_SHOW_WATERMARK_DESC',$watermark_text.'mit dem Shop-Namen auf der Seite anzeigen?'.$yes_no);
define('PDF_DOC_PATH_TITLE','Verzeichnis der PDF-Dokumente');
define('PDF_DOC_PATH_DESC','Das Verzeichnis, in dem die PDF-Dokumente gespeichert werden sollen. Beispiel: "pdfdocs/". Ohne führenden aber mit einem abschließenden Schrägstrich!). Stellen Sie sicher, dass dieses Verzeichnis existiert, und denken Sie daran, die Verzeichnisrechte so');
define('PDF_FILE_REDIRECT_TITLE','Datenblatt im Browser anzeigen oder laden?');
define('PDF_FILE_REDIRECT_DESC','Soll das Datenblatt im Browser anzeigt oder geladen werden? 0 = Download, 1 = Laden');
define('PDF_SHOW_BACKGROUND_TITLE','Hintergrund anzeigen');
define('PDF_SHOW_BACKGROUND_DESC','Soll das Datenblatt einen Hintergrund haben?'.$yes_no);
define('PDF_SAVE_DOCUMENT_TITLE','Sollen die Datenblätter auf dem Server gespeichert werden?');
define('PDF_SAVE_DOCUMENT_DESC','Eine Speicherung auf dem Server beschleunigt die Darstellung bei wiederholter Anforderung eines Datenblatts. Wenn Sie allerdings mit sich ändernden Produktdaten arbeiten - z.B. Sonderpreise -, sollten Sie diese Option nicht wählen!');
define('PDF_SHOW_PATH_TITLE','Soll der Produktpfad angezeigt werden?');
define('PDF_SHOW_PATH_DESC','Der Produktpfad wird im Datenblatt angezeigt.'.$yes_no);
define('PDF_SHOW_IMAGES_TITLE','Soll ein Produktbild angezeigt werden?');
define('PDF_SHOW_IMAGES_DESC','Ein Produktbild wird angezeigt.'.$yes_no);
define('PDF_SHOW_MODEL_TITLE','Soll die Artikel-Nummer angezeigt werden?');
define('PDF_SHOW_MODEL_DESC','Die Artikel-Nummer wird angezeigt.'.$yes_no);
define('PDF_SHOW_SHIPPING_TIME_TITLE','Soll die  Lieferzeit angezeigt werden?');
define('PDF_SHOW_SHIPPING_TIME_DESC','Die Lieferzeit wird angezeigt.'.$yes_no);
define('PDF_SHOW_DESCRIPTION_TITLE','Soll die Produkt-Beschreibung angezeigt werden?');
define('PDF_SHOW_DESCRIPTION_DESC','Die Produkt-Beschreibung wird angezeigt.'.$yes_no);
define('PDF_SHOW_SHORT_DESCRIPTION_TITLE','Soll die Produkt-Kurz-Beschreibung angezeigt werden?');
define('PDF_SHOW_SHORT_DESCRIPTION_DESC','Die Produkt-Kurz-Beschreibung wird angezeigt.'.$yes_no);
define('PDF_SHOW_MANUFACTURER_TITLE','Soll der Hersteller angezeigt werden?');
define('PDF_SHOW_MANUFACTURER_DESC','Der Hersteller wird angezeigt.'.$yes_no);
define('PDF_SHOW_PRICE_TITLE','Soll der Preis angezeigt werden?');
define('PDF_SHOW_PRICE_DESC','Der Preis wird angezeigt.'.$yes_no);
define('PDF_SHOW_SPECIALS_PRICE_TITLE','Soll der Sonder-Preis angezeigt werden?');
define('PDF_SHOW_SPECIALS_PRICE_DESC','Der Sonder-Preis wird angezeigt.'.$yes_no);
define('PDF_SHOW_SPECIALS_PRICE_EXPIRES_TITLE','Soll das Ablauf-Datum eines Sonder-Preises angezeigt werden?');
define('PDF_SHOW_SPECIALS_PRICE_EXPIRES_DESC','Das Ablauf-Datum eines Sonder-Preises wird angezeigt.'.$yes_no);
define('PDF_SHOW_OPTIONS_TITLE','Sollen die Produkt-Optionen angezeigt werden?');
define('PDF_SHOW_OPTIONS_DESC','Die Produkt-Optionen werden angezeigt.'.$yes_no);
define('PDF_SHOW_OPTIONS_PRICE_TITLE','Soll der Preis angezeigt werden?');
define('PDF_SHOW_OPTIONS_PRICE_DESC','Der Preis wird angezeigt.'.$yes_no);
define('PDF_SHOW_OPTIONS_VERTICAL_TITLE','Sollen die Produkt-Optionen vertikal angezeigt werden?');
define('PDF_SHOW_OPTIONS_VERTICAL_DESC','Die Produkt-Optionen werden vertikal angezeigt.'.$yes_no);
define('PDF_SHOW_DATE_ADDED_AVAILABLE_TITLE','Soll das Aufnahmedatum in den Katalog angezeigt werden?');
define('PDF_SHOW_DATE_ADDED_AVAILABLE_DESC','Das Aufnahmedatum in den Katalog wird angezeigt.'.$yes_no);
$bg_color_text='Die Hintergrund-Farbe ';
$txt_color_text='Die Text-Farbe ';
define('PDF_PAGE_BG_COLOR_TITLE',$bg_color_text.'des Datenblatts.');
$color_text=' Fügen Sie einen CSS-Farbnamen (z.B. "black" oder "floralwhite") oder einen kommaseparierten RGB-Farbwert (Rot,Grün,Blau). Die Farbwerte können die Werte 0-255 annehmen.';
define('PDF_PAGE_BG_COLOR_DESC',PDF_PAGE_BG_COLOR_TITLE.$color_text);
define('PDF_HEADER_COLOR_TABLE_TITLE',$bg_color_text.'der Kopfzeilen-Tabelle');
define('PDF_HEADER_COLOR_TABLE_DESC',PDF_HEADER_COLOR_TABLE_TITLE.$color_text);
define('PDF_HEADER_COLOR_TEXT_TITLE',$txt_color_text.'Datenblatt-Kopfes');
define('PDF_HEADER_COLOR_TEXT_DESC',PDF_HEADER_COLOR_TEXT_TITLE.$color_text);
define('PDF_BODY_COLOR_TEXT_TITLE',$txt_color_text.'im Datenblatt-Kopf.');
define('PDF_BODY_COLOR_TEXT_DESC',PDF_BODY_COLOR_TEXT_TITLE.$color_text);
define('PDF_PRODUCT_NAME_COLOR_TABLE_TITLE',$bg_color_text.'des Produktnamens');
define('PDF_PRODUCT_NAME_COLOR_TABLE_DESC',PDF_PRODUCT_NAME_COLOR_TABLE_TITLE.$color);
define('PDF_PRODUCT_NAME_COLOR_TEXT_TITLE',$txt_color_text.'des Produktnamens');
define('PDF_PRODUCT_NAME_COLOR_TEXT_DESC',PDF_PRODUCT_NAME_COLOR_TEXT_TITLE.$color);
define('PDF_FOOTER_CELL_BG_COLOR_TITLE',$bg_color_text.'der Fußzeile');
define('PDF_FOOTER_CELL_BG_COLOR_DESC',PDF_FOOTER_CELL_BG_COLOR_TITLE.$color);
define('PDF_FOOTER_CELL_TEXT_COLOR_TITLE',$txt_color_text.'der Fußzeile');
define('PDF_FOOTER_CELL_TEXT_COLOR_DESC',PDF_FOOTER_CELL_TEXT_COLOR_TITLE.$color);
define('PDF_SPECIAL_PRICE_COLOR_TEXT_TITLE',$bg_color_text.'des Sonderpreises');
define('PDF_SPECIAL_PRICE_COLOR_TEXT_DESC',PDF_FOOTER_CELL_BG_COLOR_TITLE.$color);
define('PDF_PAGE_WATERMARK_COLOR_TITLE',$txt_color_text.'im '.rtrim($watermark_text));
define('PDF_PAGE_WATERMARK_COLOR_DESC',PDF_FOOTER_CELL_BG_COLOR_TITLE.$color);
define('PDF_OPTIONS_COLOR_TITLE',$txt_color_text.'der Artikel-Optionen');
define('PDF_OPTIONS_COLOR_DESC',PDF_FOOTER_CELL_BG_COLOR_TITLE.$color);
define('PDF_OPTIONS_BG_COLOR_TITLE',$bg_color_text.'der Artikel-Optionen');
define('PDF_OPTIONS_BG_COLOR_DESC',PDF_OPTIONS_BG_COLOR_TITLE.$color);

//PDF-Rechnung
define('PDF_INVOICE_ORDER_CONFIRMATION_TITLE','Bestellbestätigung auch als PDF senden');
define('PDF_INVOICE_ORDER_CONFIRMATION_DESC',
'Die Bestellbestätigung zusätzlich als PDF-Datei im Anhang an die Bestätigungs-eMail senden');
define('PDF_INVOICE_MARK_COLOR_TITLE','Textfarbe für markierte Bereiche');
define('PDF_INVOICE_MARK_COLOR_DESC',PDF_INVOICE_MARK_COLOR_TITLE);
define('PDF_INVOICE_MARK_COLOR_BG_TITLE','Hintergrundfarbe für markierte Bereiche');
define('PDF_INVOICE_MARK_COLOR_BG_DESC',PDF_INVOICE_MARK_COLOR_TITLE);
$bank='Bank-';
define('STORE_BANK_NAME_TITLE',$bank.'Name');
$the_shop=' des Shops';
$the_bank=' der Bank'.$the_shop;
define('STORE_BANK_NAME_DESC','Der Name'.$the_bank);
define('STORE_BANK_BLZ_TITLE',$bank.'Blz');
$the_bank_inland=$the_bank.' (wird für Inlandskunden verwendet)';
define('STORE_BANK_BLZ_DESC','Die Bankleitzahl'.$the_bank_inland);
define('STORE_BANK_ACCOUNT_TITLE',$bank.'Konto');
define('STORE_BANK_ACCOUNT_DESC','Die Konto-Nummer'.$the_bank_inland);
$the_bank_ausland=$the_bank.' (wird für Auslandskunden verwendet)';
define('STORE_BANK_BIC_TITLE',$bank.'BIC');
define('STORE_BANK_BIC_DESC','Die BIC-Nummer'.$the_bank_ausland);
define('STORE_BANK_IBAN_TITLE',$bank.'IBAN');
define('STORE_BANK_IBAN_DESC','Die IBAN-Nummer'.$the_bank_ausland);
define('STORE_USTID_TITLE','Umsatzsteuer-Id');
define('STORE_USTID_DESC','Die '.STORE_USTID_TITLE.$the_shop);
define('STORE_TAXNR_TITLE','Steuer-Nummer');
define('STORE_TAXNR_DESC','Die '.STORE_TAXNR_TITLE.$the_shop.' (Nur notwendig, wenn keine '.STORE_USTID_TITLE.' vorhanden ist.)');
$only=' (Nur notwendig für im Handelsregister eingetragene Firmen.)';
$of_the_shop=' des Shops';
define('STORE_REGISTER_TITLE','Registergericht');
define('STORE_REGISTER_DESC','Das '.STORE_REGISTER_TITLE.',bei dem die Firma registriert ist.'.$only);
define('STORE_REGISTER_NR_TITLE','Die Handelsregister-Nummer'.$of_the_shop);
define('STORE_REGISTER_NR_DESC',STORE_REGISTER_NR_TITLE.' (z.B. HRA 1234)'.$only);
define('STORE_MANAGER_TITLE','Geschäftsführer');
define('STORE_MANAGER_DESC','Der Geschäftsführer'.$of_the_shop.$only);
define('STORE_DIRECTOR_TITLE','Aufsichtsrat');
define('STORE_DIRECTOR_DESC','Der Aufsichtsrat'.$of_the_shop.$only);

define('STORE_INVOICE_NUMBER_TITLE','Rechnungs-Nummer');
define('STORE_INVOICE_NUMBER_DESC','Die laufende '.STORE_INVOICE_NUMBER_TITLE.$of_the_shop);
define('STORE_PACKINGSLIP_NUMBER_TITLE','Lieferschein-Nummer');
define('STORE_PACKINGSLIP_NUMBER_DESC','Die laufende '.STORE_INVOICE_NUMBER_TITLE.$of_the_shop);

define('CRON_JOBS_LIST_TITLE', 'Automatische Skript-Ausführung ("Cron-Jobs")');
define('CRON_JOBS_LIST_DESC', '
Es können Skripte definiert werden, die zu bestimmten Zeiten wiederholt ausgeführt werden sollen.
<br/><br/>
Beispiele:
<br/><br/>
<b>Starte Skript immer um 14:15</b><br/>
admin/import.php?file=http://www.meinlieferant1.de/produkte.csv,14:15<br/><br/>
<b>Starte Skript Montags, Mittwochs und Freitags um 20:00</b><br/>
admin/import.php?file=http://www.meinlieferant2.de/produkte.csv,Montag/Mittwoch/Freitag,20:00<br/><br/>
<b>Starte Skript alle 120 Minuten</b><br/>
admin/import.php?file=http://www.meinlieferant3.de/produkte.csv,120
<br/><br/>
Der Pfad des Skriptes muss relativ zum Shop-Verzeichnis angegeben werden!'
);

define('PRODUCT_IMAGE_ON_THE_FLY_TITLE','Produktbilder "On-the-fly" erstellen');
define('PRODUCT_IMAGE_ON_THE_FLY_DESC','Die Produktbilder werden dynamisch beim Aufruf erstellt, und nicht mehr statisch abgespeichert (ausser dem Originalbild)');

define('SPIDER_FOOD_ROWS_TITLE','Anzahl Produkte mit erweiterten Suchmaschinen-Daten');
define('SPIDER_FOOD_ROWS_DESC','Hier kann man besonders "<b>leckere Köder</b>" für Suchmaschinen bereit stellen!<br/><br/>Suchmaschinen bewerten Suchworte besonders gut, die in den HTML-Elementen "TITLE", "METATAGS", "H1", "H2", "Links" und "Image"-Namen vorkommen. Man kann hier angeben, für wie viele Produkte <b>nur(!) beim Besuch einer Suchmaschine</b> solche Informationen in jede Seite eingebaut werden sollen. (Die dargestellten Produkte werden bei jedem Aufruf zufällig ausgewählt.)');

define('VISITOR_PDF_CATALOGUE_TITLE','Ausdruck des PDF-Katalogs durch Besucher erlauben');
define('VISITOR_PDF_CATALOGUE_DESC','Besucher können einen Produkt-Katalog im PDF-Format ausdrucken. (Bei vielen Produkten sollte diese Funktion nicht aktiviert werden, da diese sehr resourcenhungrig ist.)');

$title='Anzahl Bilder pro # in der Produkt-Galerie';
$desc='Hiermit kann man festlegen, wie viel Bilder pro # in der Produkt-Galerie angezeigt werden sollen';
$page='Seite';
$line='Zeile';
define('GALLERY_PICTURES_PER_PAGE_TITLE',str_replace(HASH,$page,$title));
define('GALLERY_PICTURES_PER_PAGE_DESC',str_replace(HASH,$page,$desc));
define('GALLERY_PICTURES_PER_LINE_TITLE',str_replace(HASH,$line,$title));
define('GALLERY_PICTURES_PER_LINE_DESC',str_replace(HASH,$line,$desc));

define('EBAY_FUNCTIONS_INCLUDE_TITLE','eBay-Konnektor aktivieren');
define('EBAY_FUNCTIONS_INCLUDE_DESC','Der eBay-Konnektor wird aktiviert, so dass eBay-Auktionen/eBay-Express-Verkäufe eingestellt werden, und eBay-Bestellungen übernommen werden können');

define('EBAY_TEST_MODE_TITLE','eBay-Konnektor im Testmodus betreiben');
define('EBAY_TEST_MODE_DESC','Wenn der eBay-Konnektor im Testmodus betrieben wird, werden keine echten Auktionen erstellt, sondern nur in der ebay-Testumgebung ("Sandbox")');
define('EBAY_REAL_SHOP_URL_TITLE','Die Internet-Adresse Ihres Online-Shops');
define('EBAY_REAL_SHOP_URL_DESC','Man benötigt die echte Shop-Adresse, damit eBay Zugriff auf die Bilder (und andere Elemente) haben kann.');
define('EBAY_MEMBER_NAME_TITLE','Ihr eBay-Mitgliedes-Name');
define('EBAY_MEMBER_NAME_DESC','Der eBay-Mitgliedes-Name, mit dem Sie sich bei eBay anmelden');
define('EBAY_EBAY_EXPRESS_ONLY_TITLE','Produkte nur in eBay-Express einstellen');
define('EBAY_EBAY_EXPRESS_ONLY_DESC','Es werden keine Auktionen erstellt, sondern nur eBay-Express Verkäufe');
define('EBAY_SHIPPING_MODULE_TITLE','Die Versand-Methode für eBay-Bestellungen');
define('EBAY_SHIPPING_MODULE_DESC',EBAY_SHIPPING_MODULE_TITLE.' (Das ist der <b>interne</b> Name eines der installierten Versand-Module: "<b>Modulname (für internen Gebrauch)</b>")');
define('EBAY_PAYPAL_EMAIL_ADDRESS_TITLE','Ihre eMail-Adresse für PayPal-Zahlungen');
define('EBAY_PAYPAL_EMAIL_ADDRESS_DESC','Wenn Sie Zahlungen per PayPal akzeptieren (für eBay-Express ein "Muss"), geben Sie hier Ihre eMail-Adresse für Ihr PayPal-Konto an');

$ebay='eBay-"';
$for='" für den Test-Modus';
$assigned=' Ihnen von eBay zugwiesene "';
$the_assigned='Der'.$assigned;
$that_assigned='Das'.$assigned;
$devid='DEVID';
$appid='APPID';
$certid='CERTID';
$token='TOKEN';
define('EBAY_TEST_MODE_DEVID_TITLE',$ebay.$devid.$for);
define('EBAY_TEST_MODE_DEVID_DESC',$the_assigned.$devid.$for);
define('EBAY_TEST_MODE_APPID_TITLE',$ebay.$appid.$for);
define('EBAY_TEST_MODE_APPID_DESC',$the_assigned.$appid.$for);
define('EBAY_TEST_MODE_CERTID_TITLE',$ebay.$certid.$for);
define('EBAY_TEST_MODE_CERTID_DESC',$the_assigned.$certid.$for);
define('EBAY_TEST_MODE_TOKEN_TITLE',$ebay.$token.$for);
define('EBAY_TEST_MODE_TOKEN_DESC',$that_assigned.$token.$for);
$for='" für den Produktions-Modus';
define('EBAY_PRODUCTION_DEVID_TITLE',$ebay.$devid.$for);
define('EBAY_PRODUCTION_DEVID_DESC',$the_assigned.$devid.$for);
define('EBAY_PRODUCTION_APPID_TITLE',$ebay.$appid.$for);
define('EBAY_PRODUCTION_APPID_DESC',$the_assigned.$appid.$for);
define('EBAY_PRODUCTION_CERTID_TITLE',$ebay.$certid.$for);
define('EBAY_PRODUCTION_CERTID_DESC',$the_assigned.$certid.$for);
define('EBAY_PRODUCTION_TOKEN_TITLE',$ebay.$token.$for);
define('EBAY_PRODUCTION_TOKEN_DESC',$that_assigned.$token.$for);

define('TRACKING_PRODUCTS_HISTORY_ENTRIES_TITLE','Die Anzahl der vom Kunden besuchten Produkte');
define('TRACKING_PRODUCTS_HISTORY_ENTRIES_DESC',TRACKING_PRODUCTS_HISTORY_ENTRIES_TITLE.' in der Besuchs-Historie. Damit kann der Besucher die letzten "n" von ihm in der aktuellen Sitzung besuchten Produkte leicht wieder finden.');

define('CURRENT_TEMPLATE_TITLE', 'Templateset (Theme)');
define('CURRENT_TEMPLATE_DESC', 'Wählen Sie ein '.CURRENT_TEMPLATE_TITLE.' aus. Das Templateset muss sich im Ordner www.Ihre-Domain.com/templates/ befinden.');

$s=' "Drag und Drop" Bildschirm-Layout ';
$s1=' "<b>olc_installer/übernahme_eines_templates.htm</b>"';
define('NO_BOX_LAYOUT_TITLE', 'Kein'.$s.'verwenden');
define('NO_BOX_LAYOUT_DESC', 'Mit dem'.$s.'können Sie die Positionierung der Boxen visuell Mit der Maus vornehmen. Damit das funktioniert, muss das Template entsprechende vorbereitet sein. Näheres dazu finden Sie in "<b>olc_installer/ajax_aenderungen.html</b>" und'.$s1);

$s=' "Unified-Templates"-Konzept ';
$s2='. Näheres dazu finden Sie in'.$s1;
define('USE_UNIFIED_TEMPLATES_TITLE', 'Das'.$s. 'verwenden');
define('USE_UNIFIED_TEMPLATES_DESC', 'Mit dem'.$s.'wird für die Templates eine weitestgehende <b>Trennung</b> von <b>Design</b> und <b>Datenaufbereitung</b> verwirklicht, was die Erstellung und Wartung von Templates drastisch vereinfacht, aber <b>alle</b> Möglichkeiten bewahrt, notfalls eigene Designs zu verwirklichen'.$s2);

define('CHECK_UNIFIED_BOXES_TITLE', 'Eigene Programme für die Datenaufbereitung verwenden');
define('CHECK_UNIFIED_BOXES_DESC', 'Mit dem'.$s.'besteht auch die Möglichkeit, trotz der Verwendung von Standard-Routinen für die Datenaufbereitung der "Boxen", eigene Programme für die Datenaufbereitung zu verwenden. Diese Überprüfung können Sie hier steuern'.$s2);

define('OPEN_ALL_MENUE_LEVELS_TITLE','Alle Menü-Einträge "aufklappen"');
define('OPEN_ALL_MENUE_LEVELS_DESC','Beim <b>Standard</b>-OL-Commerce-Menü(!) kann man <b>alle</b> Kategorien und Unterkategorien <b>immer</b> alle aufgeklappt anzeigen lassen.');

$s='Anstelle des <b>Standard</b>-OL-Commerce-Menüs kann ';
$s1='. (Bei vielen Kategorien ist das meist platzsparender.)';
define('USE_COOL_MENU_TITLE','"Cool-Menue" verwenden');
define('USE_COOL_MENU_DESC',$s.'ein <b>dynamisches DHTML-Menü</b> verwendet werden, das die Kategorien-Einträge hierarchisch gliedert, und beim "Darüberfahren" mit der Maus sukzessive aufklappt.'.$s1);

$s3='"Tab"-Navigation ("Reiternavigation") ';
define('SHOW_TAB_NAVIGATION_TITLE',$s3.'verwenden');
define('SHOW_TAB_NAVIGATION_DESC',$s.'eine <b>'.$s3.'</b> verwendet werden, bei dem die Kategorien-Auswahl über "Karteikarten-Reiter stattfindet'.$s1);

define('PRODUCTS_LISTING_COLUMNS_TITLE','Anzahl Spalten in Produklisten');
define('PRODUCTS_LISTING_COLUMNS_DESC',PRODUCTS_LISTING_COLUMNS_TITLE);


define('SHOW_SHORT_CART_ONLY_TITLE','Nur den verkürzten Warenkorb verwenden');
define('SHOW_SHORT_CART_ONLY_DESC','Hiermit kann man steuern, ob nur der verkürzte Warenkorb verwendet werden soll, oder ob dieser auch "aufgeklappt" werden kann, um die Warenkorb-Details anzuzeigen.'.$yes_no);

define('SLIDESHOW_INTERVAL_TITLE','<b>Anzeigedauer</b> der Slideshow-Information (in Sekunden)');
define('SLIDESHOW_INTERVAL_DESC','Nach wie viel <b>Sekunden</b> soll die Slideshow-Information gewechselt werden.');

define('SLIDESHOW_INTERVAL_MIN_TITLE','<b>Minimale '.SLIDESHOW_INTERVAL_TITLE);
define('SLIDESHOW_INTERVAL_MIN_DESC','Wie viel <b>Sekunden</b> muss die Slideshow-Information mindestens angezeigt bleiben. Da der Besucher die Anzeigedauer ändern kann, sollte ein minimaler Wert angegeben werden, um eine Überlastung des Servers zu verhindern.');

define('SLIDESHOW_PRODUCTS_TITLE','<b>Produkt</b>-Slideshow anzeigen');
define('SLIDESHOW_PRODUCTS_DESC','Diese Slideshow besteht aus denselben <b>Produkt-Informationen</b>, wie sie in den <b>Produkt-Listen</b> angezeigt wird (einschl. <b>Bestellmöglichkeit</b>!)');

define('SLIDESHOW_IMAGES_TITLE','<b>Bilder</b>-Slideshow anzeigen');
define('SLIDESHOW_IMAGES_DESC','Diese Slideshow besteht aus <b>Bildern</b>, die im Verzeichnis "<b>images/slideshow</b>" abgelegt sind. In der ebenfalls dort befindlichen Datei "<b>slideshow.txt</b>" wird für jedes Bild festgelegt, welcher Link und welcher Erläuterungstext damit verknüpft werden soll');

$s00='Steuerelemente anzeigen für';
$s0=' Produkt-Slideshow';
$s=' der'.$s0.' (in Pixel)';
define('SLIDESHOW_PRODUCTS_HEIGHT_TITLE','Höhe'.$s);
define('SLIDESHOW_PRODUCTS_HEIGHT_DESC',SLIDESHOW_PRODUCTS_HEIGHT_TITLE);
define('SLIDESHOW_PRODUCTS_WIDTH_TITLE','Breite'.$s);
define('SLIDESHOW_PRODUCTS_WIDTH_DESC',SLIDESHOW_PRODUCTS_WIDTH_TITLE);
define('SLIDESHOW_PRODUCTS_BORDER_TITLE','Rahmen um'.$s0);
define('SLIDESHOW_PRODUCTS_BORDER_DESC',SLIDESHOW_PRODUCTS_BORDER_TITLE);
define('SLIDESHOW_PRODUCTS_CONTROLS_TITLE',$s00.$s0);
define('SLIDESHOW_PRODUCTS_CONTROLS_DESC','Es können unter der Slideshow Steuerelemente angezeigt werden, um die Slideshow zu stoppen, zu starten, zu beschleunigen und zu verlangsamen');

$s0='  Bilder-Slideshow';
$s=' der'.$s0.' (in Pixel)';
define('SLIDESHOW_IMAGES_HEIGHT_TITLE','Höhe'.$s);
define('SLIDESHOW_IMAGES_HEIGHT_DESC',SLIDESHOW_IMAGES_HEIGHT_TITLE);
define('SLIDESHOW_IMAGES_WIDTH_TITLE','Breite'.$s);
define('SLIDESHOW_IMAGES_WIDTH_DESC',SLIDESHOW_IMAGES_WIDTH_TITLE);
define('SLIDESHOW_IMAGES_BORDER_TITLE','Rahmen um'.$s0);
define('SLIDESHOW_IMAGES_BORDER_DESC',SLIDESHOW_IMAGES_BORDER_TITLE);
define('SLIDESHOW_IMAGES_SHOW_TEXT_TITLE','Text unter dem Bild anzeigen');
define('SLIDESHOW_IMAGES_SHOW_TEXT_DESC',SLIDESHOW_IMAGES_SHOW_TEXT_TITLE);
define('SLIDESHOW_IMAGES_CONTROLS_TITLE',$s00.$s0);
define('SLIDESHOW_IMAGES_CONTROLS_DESC',SLIDESHOW_PRODUCTS_CONTROLS_DESC);

define('MODULE_PRODUCT_PROMOTION_TITLE','Produkt Promotion aktivieren');
define('MODULE_PRODUCT_PROMOTION_DESC','Hiermit können Sie bestimmte Produkte besonders hervorheben lassen');

define('CSV_TEXTSIGN_TITLE','Text-Erkennungszeichen');
define('CSV_TEXTSIGN_DESC','Das Zeichen, mit dem Textfelder im CSV-Satz abgeschlossen werden (z.B. ")');
define('CSV_SEPERATOR_TITLE','Feld-Trennzeichen');
define('CSV_SEPERATOR_DESC','Das Zeichen, mit dem Felder im CSV-Satz getrennt werden (z.B. ; oder "Tabulator"');
define('COMPRESS_EXPORT_TITLE','Kompression');
define('COMPRESS_EXPORT_DESC','Kompression der exportierten Daten');

define('USE_CSS_MENU_TITLE','Menüsteuerung des Verwaltungs-Bereiches');
define('USE_CSS_MENU_DESC','Die Shop-Verwaltungs-Funktionen können über eine Menü-Steuerung bedient werden');

if (SHOW_AFFILIATE)
{
	// inclusion for affiliate program
	include('affiliate_configuration.php');
}
?>