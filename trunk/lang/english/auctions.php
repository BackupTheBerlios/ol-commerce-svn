<?php
/* --------------------------------------------------------------
$Id: auctions.php,v 1.1.1.2 2006/12/23 09:16:42 gswkaiser Exp $

OL-Commerce Version 2.x/AJAX
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

$fees[$subtitle_text]='0,10';
$fees[$starttime_text]='0,10';
$fees[$buyitnow_text]='0,10 bis 0,50';
$fees[$highlight_text]='0,85';
$fees[$bold_text]='1,50';
$fees[$border_text]='1,25';
$fees[$pic_text]='0,15';
$fees[$gallery_pic_text]='0,75';
$fees[$gallery_pic_plus_text]='0,50';

define('AUCTIONS_DATE_FORMAT','Y-m-d H:i:s');
//define('AUCTIONS_EBAY_CONFIG','config/ebay.config.php');

$auctions_text='AUCTIONS_TEXT_';
define('AUCTIONS_TEXT_HEADER','eBay Konnektor');
define('AUCTIONS_TEXT_SUB_HEADER_AUCTION','eBay-Listing erstellen');
define('AUCTIONS_TEXT_SUB_HEADER_CATEGORIES','eBay-Kategorien');
define('AUCTIONS_TEXT_SUB_HEADER_AUCTION_LIST','Auktionsliste');
define('AUCTIONS_TEXT_SUB_HEADER_PREDEF','Auktionsvorlagen');
define('AUCTIONS_TEXT_SUB_HEADER_AUCTION_LIST_PLANNED','Geplante Auktionen');
define('AUCTIONS_TEXT_SUB_HEADER_AUCTION_SOLD','Erfolgreich beendete Auktionen');
define('AUCTIONS_TEXT_SUB_HEADER_AUCTION_SOLD_NOT','Nicht erfolgreich beendete Auktionen');
define('AUCTIONS_TEXT_SUB_HEADER_AUCTION_SOLD_ORDER','Erfolgreich beendete Auktionen mit Bestellung');

//auctions text in includes/boxes/auctions.php
define('BOX_AUCTIONS_LIST','Auktionsliste');
define('BOX_AUCTIONS_LIST_RUNNING', 'Laufende Auktionen');
define('BOX_AUCTIONS_LIST_PLAN', 'Geplante Auktionen');
define('BOX_AUCTIONS_LIST_END', 'Beendete Auktionen');
define('BOX_AUCTIONS_LIST_SOLD', '* Erfolgreiche Auktionen');
define('BOX_AUCTIONS_LIST_BASKET', '* Auktionen im Warenkorb');
define('BOX_AUCTIONS_LIST_ORDER', '* Auktionen als Bestellung');
define('BOX_AUCTIONS_LIST_NOT_SOLD', '* Nicht erfolgreiche Auktionen');
define('BOX_AUCTIONS_LIST_PREDEFINED', '* '.AUCTIONS_TEXT_SUB_HEADER_PREDEF);
define('BOX_AUCTIONS_LIST_NEW','Neue Auktion');
#
#	eBay Auktion
#
$text_l='"DEVID", "APPID", "CERTID", "TOKEN" für den';
$text_t=' sind (noch) nicht richtig gesetzt!<br>Bitte in "Admin/Konfiguration/eBay-Konnektor" überprüfen!';
define('AUCTIONS_LIST_ERROR_EBAY_PARAMETER_TEST',$text_l.'Test-Betrieb'.$text_t);
define('AUCTIONS_LIST_ERROR_EBAY_PARAMETER_PRODUCTION',$text_l.'Produktions-Betrieb'.$text_t);

$enter='Bitte geben Sie ';
$select='Bitte wählen Sie ';
define('AUCTIONS_LIST_ERROR_TITLE',$enter.'einen Auktionstitel an');
define('AUCTIONS_LIST_ERROR_CAT',$enter.'eine Kategorie an');
define('AUCTIONS_LIST_ERROR_SUBMIT',$select.'mindestens einen eBay-Bereich (Auktion, Express)');
define('AUCTIONS_LIST_ERROR_DESC',$enter.'einen Auktionsbeschreibung an');
define('AUCTIONS_LIST_ERROR_DUR','Die Auktionsdauer muss bei dem gewählten Auktionstyp länger als 1 Tag sein');
define('AUCTIONS_LIST_ERROR_STARTTIME',$enter.'eine gültige Startzeit an (nutzen Sie den Kalender)');
define('AUCTIONS_LIST_ERROR_QUANTITY_1','Bei dem gewähten Auktionstyp darf nur max. 1 Artikel verkauft werden');
define('AUCTIONS_LIST_ERROR_QUANTITY_2','Bei dem gewähten Auktionstyp dürfen nur mehrere Artikel verkauft werden');
define('AUCTIONS_LIST_ERROR_QUANTITY_3',$enter.'eine Artikelmenge an');
define('AUCTIONS_LIST_ERROR_STARTPRICE',$enter.'einen Startpreis an');
define('AUCTIONS_LIST_ERROR_FIXPRICE',$enter.'einen Sofortkaufpreis an');
define('AUCTIONS_LIST_ERROR_LOCATION',$enter.'den Artikelstandort an');
define('AUCTIONS_LIST_ERROR_COUNTRY',$select.'ein Land');
define('AUCTIONS_LIST_ERROR_PIC',$enter.'ein gültiges Verzeichnis zu Ihrem %sBild an!<br>z.B.: '.
DIR_FS_CATALOG.DIR_WS_PRODUCT_IMAGES.'meinbild.jpg');
define('AUCTIONS_LIST_ERROR_GALLERY_TEXT','Galerie-');
define('AUCTIONS_LIST_ERROR_PAYMENT',$enter.'mindestens eine Zahlungsmöglichkeit an');
define('AUCTIONS_LIST_ERROR_PAYPAL',
'Sie müssen noch Ihre PayPal-eMail-Adresse angeben (Admin/Konfiguration/'.AUCTIONS_TEXT_HEADER);
define('AUCTIONS_LIST_ERROR_SEARCH','Keine Artikel gefunden für Suchbegriff "%s"');
define('AUCTIONS_LIST_ERROR_NO_IMAGE','Sie müssen zuerst das %s. Bild bestimmen!');

define('AUCTIONS_TEXT_ARTICLE','Artikel');
define('AUCTIONS_TEXT_AUCTION_DETAILS','Auktionsdetails');
define('AUCTIONS_TEXT_ARTICLE_DESCRIPTION','Artikelbeschreibung');
define('AUCTIONS_TEXT_ARTICLE_DURATION','Preis und Dauer');
define('AUCTIONS_TEXT_ARTICLE_CITY','Artikelstandort');
define('AUCTIONS_TEXT_ARTICLE_PICS','Bilder');
define('AUCTIONS_TEXT_ARTICLE_OPTIONS','Zusatzoptionen (Kostenpflichtig!)');
define('AUCTIONS_TEXT_ARTICLE_PAYMENT','Zahlung und Versand');
define('AUCTIONS_TEXT_ARTICLE_SHIPMENT','Versanddetails');


define('AUCTIONS_TEXT_AUCTION_TYPE','Auktionstyp');
define('AUCTIONS_TEXT_AUCTION_TITLE','Titel');
define('AUCTIONS_TEXT_AUCTION_SUB_TITLE','Untertitel (<b>EUR %s</b>)');
define('AUCTIONS_TEXT_AUCTION_CAT1','Erste Kategorie');
define('AUCTIONS_TEXT_AUCTION_CAT2','Zweite Kategorie (Doppelte Gebühren)');
define('AUCTIONS_TEXT_AUCTION_SUBMIT','Einstellen in');
define('AUCTIONS_TEXT_AUCTION_AUTO_SUBMIT','Automatisch wieder einstellen');
define('AUCTIONS_TEXT_AUCTION_AUTO_SUBMIT_EXPLAIN',' (Nach dem Kauf wird die Auktion automatisch wieder neu eingestellt)');
define('AUCTIONS_TEXT_AUCTION_DESCRIPTION_TEMPLATE','Vorlage für Produktbeschreibung');
define('AUCTIONS_TEXT_AUCTION_DESCRIPTION_FORCE_REBUILD','Produktbeschreibung neu erstellen');
define('AUCTIONS_TEXT_AUCTION_DESCRIPTION_FORCE_REBUILD_EXPLAIN',
' (Die Produktbeschreibung wird aus dem Template neu erstellt)');
define('AUCTIONS_TEXT_AUCTION_AUCTION','eBay Auktion');
define('AUCTIONS_TEXT_AUCTION_EXPRESS','eBay Express');
define('AUCTIONS_TEXT_AUCTION_EXPRESS_DURATION','Einstellen bei eBay Express für');
define('AUCTIONS_TEXT_AUCTION_EXPRESS_DURATION_30',' 30 Tage');
define('AUCTIONS_TEXT_AUCTION_EXPRESS_DURATION_PERMANENT',' Dauernd');
define('AUCTIONS_TEXT_AUCTION_START_DATE','Startdatum (<b>EUR %s</b>)');
define('AUCTIONS_TEXT_AUCTION_DURATION','Dauer');
define('AUCTIONS_TEXT_AUCTION_DURATION_DAYS','Tag(e)');
define('AUCTIONS_TEXT_AUCTION_QUANTITY','Menge');
define('AUCTIONS_TEXT_AUCTION_PRICE','Startpreis');
define('AUCTIONS_TEXT_AUCTION_FIXED_PRICE','"Sofort kaufen"-Preis (<b>EUR %s</b>)');
define('AUCTIONS_TEXT_AUCTION_LOCATION','Ort, Bundesland');
define('AUCTIONS_TEXT_AUCTION_COUNTRY','Land');
define('AUCTIONS_TEXT_AUCTION_PIC_URL','Bild-Adresse(n)');
define('AUCTIONS_TEXT_AUCTION_FONT_BOLD','Fettschrift  (<b>EUR %s</b>)');
define('AUCTIONS_TEXT_AUCTION_FONT_HIGHLIGHT','Highlight (<b>EUR %s</b>)');
define('AUCTIONS_TEXT_AUCTION_FONT_BORDER','Rahmen (<b>EUR %s</b>)');
define('AUCTIONS_TEXT_AUCTION_USE_MULTI_PIC','%s. Bild verwenden (<b>EUR %s</b>)');
define('AUCTIONS_TEXT_AUCTION_USE_GALLERY_PIC','Galerie-Bild verwenden (<b>EUR %s</b>)');
define('AUCTIONS_TEXT_AUCTION_USE_GALLERY_PLUS','Galerie-Plus verwenden (<b>EUR %s</b>)');
define('AUCTIONS_TEXT_AUCTION_GALLERY_PIC_URL','Galerie-Bild-URL');
define('AUCTIONS_TEXT_AUCTION_PAYMENT_TRANSFER','Überweisung');
define('AUCTIONS_TEXT_AUCTION_PAYMENT_COD','Nachnahme');
define('AUCTIONS_TEXT_AUCTION_PAYMENT_COP','Bar bei Übergabe');
define('AUCTIONS_TEXT_AUCTION_PAYMENT_CC','Kreditkarte');
define('AUCTIONS_TEXT_AUCTION_PAYMENT_PAYPAL','Paypal');
define('AUCTIONS_TEXT_AUCTION_COUNTRY_DE','Deutschland');
define('AUCTIONS_TEXT_AUCTION_COUNTRY_AT','Österreich');
define('AUCTIONS_TEXT_AUCTION_COUNTRY_CH','Schweiz');
define('AUCTIONS_TEXT_AUCTION_ADD','Auktion einstellen');
define('AUCTIONS_TEXT_AUCTION_NEW','Vorlage speichern');
define('AUCTIONS_TEXT_AUCTION_UPDATE',AUCTIONS_TEXT_AUCTION_NEW);
define('AUCTIONS_TEXT_SUBMIT_SEARCH','Suchen');
define('AUCTIONS_TEXT_SUBMIT_SELECT','Auswählen');
define('AUCTIONS_TEXT_SELECT','wählen');
define('AUCTIONS_TEXT_AFTERBUY','Bitte verwenden Sie <font color="red"><b>nicht(!)</b></font> die <b>eBay-Zahlungsabwicklung</b>, auch wenn Sie angeboten wird! Sie erhalten nach Abschluss des Vorgangs eine eMail zur weiteren Abwicklung Ihrer Bestellung in unserem Online-Shop. Das hat für Sie den großen Vorteil, dass Sie, auch bei Bestellung mehrere Artikel, immer nur die <b>günstigen Gesamt-Versandkosten</b> aus unserem Online-Shop berechnet bekommen!');
define('AUCTIONS_TEXT_SHOW_ITEM',HTML_BR.HTML_BR.'Auktions-Information anzeigen>');
define('AUCTIONS_TEXT_ATTRIBUTES',HTML_BR.HTML_BR.'<b>Produkt-Optionen:</b>'.HTML_BR);
define('AUCTIONS_TEXT_ATTRIBUTES_REMARK',
'<p><font color="red"><b>Das Produkt hat Optionen für "%s"!</b></font> Bitte teilen Sie uns bei der Bestellung <b>im Bemerkungsfeld</b> mit, <b>welche dieser Optionen</b> Sie möchten!</b> Falls Sie keine Auswahl treffen, werden wir eine Option für Sie auswählen.</p>');
define('AUCTIONS_TEXT_WRONG_ATTRIBUTES',
'<p><font color="red"><b>Das Produkt hat Optionen, die mit einem Preis versehen sind. Solche Optionen können über eBay nicht angeboten werden!</b></font></p>');
define('AUCTIONS_TEXT_XFER_OK','Die Übertragung an eBay war erfolgreich, das Produkt ist unter der eBay-ID "%s" gelistet');
define('AUCTIONS_TEXT_SHOW_PRODUCT','Produkt bei eBay anzeigen');
define('AUCTIONS_TEXT_BASE_PRICE','Preis pro ');
define('AUCTIONS_TEXT_BASE_BASE_STARTPRICE',' (bezogen auf den Startpreis)');
define('AUCTIONS_TEXT_ILLEGAL_IMG_DIR','Sie können nur Bilder aus dem \"images\"-Verzeichnis des Shops wählen!');
define('AUCTIONS_TEXT_ILLEGAL_IMG_FORMAT','Sie können nur Bilder im Format \"jpeg\", \"gif\" und \"png\" wählen!');
#
#	eBay Kategorien
#
define('AUCTIONS_TEXT_SUB_HEADER_CATEGORIES','eBay-Kategorien');
define('AUCTIONS_TEXT_CATEGORIES_DOWNLOAD','
Es muss eine <br>neue Version<br> geladen werden!
<br><br>(Die Übertragung der '.AUCTIONS_TEXT_SUB_HEADER_CATEGORIES.'<br>
kann einige Minuten dauern.)<br>
<br><b><i>Bitte nur 1 mal klicken<br>und das Fenster geöffnet lassen!</i></b><br>
');
define('AUCTIONS_TEXT_CATEGORIES_VERSION_OK','Version "%s"');
define('AUCTIONS_TEXT_CATEGORIES_CAT_UPDATE','Kategorien aktualisieren');
define('AUCTIONS_TEXT_CATEGORIES_ROOT','Kategorien');
define('AUCTIONS_TEXT_CATEGORIES_CATEGORY','Kategorie');
define('AUCTIONS_TEXT_CATEGORIES_ID','ID');
define('AUCTIONS_TEXT_CATEGORIES_ROOT_PATH',AUCTIONS_TEXT_CATEGORIES_ROOT.'-Pfad');
define('AUCTIONS_TEXT_CATEGORIES_SUB_CAT','Unter-'.AUCTIONS_TEXT_CATEGORIES_ROOT);
define('AUCTIONS_TEXT_CATEGORIES_ROOT_CAT','Haupt-'.AUCTIONS_TEXT_CATEGORIES_ROOT);
define('AUCTIONS_TEXT_CATEGORIES_SUBMITTED','Die Kategorien-Übernahme wurde schon gestartet!');

define('AUCTIONS_TEXT_AUCTION_QUANTITY','Menge x Titel');
define('AUCTIONS_TEXT_AUCTION_START_PRICE','Startpreis');
define('AUCTIONS_TEXT_AUCTION_BUYNOW_PRICE','Sofortkaufpreis');
define('AUCTIONS_TEXT_AUCTION_CAT','Kategorie');
define('AUCTIONS_TEXT_AUCTION_MESSAGE','Sie haben bei eBay folgende Artikel ersteigert:');
#
#	Auction list, auction list planned
#
define('AUCTIONS_TEXT_AUCTION_LIST_STATUS_GET','Aktuellen Status abholen');
define('AUCTIONS_TEXT_AUCTION_LIST_STATUS_SUCCESS','Aktueller Status erfolgreich von eBay abgeholt!');
define('AUCTIONS_TEXT_AUCTION_LIST_STATUS_FAILED','Abholen des aktuellen Status von eBay nur max. alle 30 Minuten möglich!');
define('AUCTIONS_TEXT_AUCTION_LIST_EBAY_ID','eBay-ID');
define('AUCTIONS_TEXT_AUCTION_LIST_START_TIME','Startzeit');
define('AUCTIONS_TEXT_AUCTION_LIST_END_TIME','Endzeit');
define('AUCTIONS_TEXT_AUCTION_LIST_BIDS','Gebote');
define('AUCTIONS_TEXT_AUCTION_LIST_HIGHEST_BID','Aktuelles&nbsp;Gebot');
#
#	Auctions predefined
#
define('AUCTIONS_TEXT_AUCTION_PREDEF_ID','ID');
define('AUCTIONS_TEXT_AUCTION_PREDEF_DURATION','Dauer');
define('AUCTIONS_TEXT_AUCTION_PREDEF_TYPE','Typ');
define('AUCTIONS_TEXT_AUCTION_PREDEF_ACCEPT','Übernehmen');
#
#	Auctions sold
#
define('AUCTIONS_TEXT_AUCTION_SOLD_BUYER','Käufer');
define('AUCTIONS_TEXT_AUCTION_SOLD_COUNTRY','Land');
define('AUCTIONS_TEXT_AUCTION_SOLD_PRICE','Endpreis');
define('AUCTIONS_TEXT_AUCTION_SOLD_BASKET','Warenkorb');
define('AUCTIONS_TEXT_AUCTION_SOLD_BUYER_DATA','Käufer-Daten abholen');
define('AUCTIONS_TEXT_AUCTION_SOLD_BUYER_INFORMATION','Käufer informieren');
define('AUCTIONS_TEXT_AUCTION_SOLD_EMAIL_SUBJECT','eBay Auktionsabwicklung');
#
#	Auctions sold orders
#
define('AUCTIONS_TEXT_AUCTION_SOLD_ORDER_ORDERNR','Bestell-Nr.');

$arrow_down = olc_image(DIR_WS_ICONS . 'arrow_down.gif', AUCTIONS_LIST_SORT_DOWNWARD);
$arrow_up = olc_image(DIR_WS_ICONS . 'arrow_up.gif', AUCTIONS_LIST_SORT_UPWARD);
?>