<?php
/* --------------------------------------------------------------
$Id: new_attributes.php,v 2.0.0 2006/12/14 05:49:24 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(new_attributes); www.oscommerce.com
(c) 2003	    nextcommerce (new_attributes.php,v 1.13 2003/08/21); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

$products_attributes='Produkt-Attribute ';
define('TEXT_EDIT_ATTRIBUTES', $products_attributes.'bearbeiten');
define('TEXT_UPDATE_ATTRIBUTES', $products_attributes.'aktualisieren');
define('TEXT_SELECT_PRODUCT', "Wählen Sie das zu bearbeitende Produkt");
define('TEXT_SELECT_PRODUCT_COPY', "Wählen Sie ein Produkt, dessen Attribute übernommen werden sollen");
define('TEXT_SELECT_PRODUCT_COPY_NO_COPY', "Keine Attribute übernehmen");
define('TEXT_ATTRIBUTES_ATTRIBUTE_MODEL','Attribut-<br/>Bezeichnung');
define('TEXT_ATTRIBUTES_ID','id');
define('TEXT_ATTRIBUTES_LINKED_ATTR','Verbundenes Attr.');
define('TEXT_ATTRIBUTES_OPTION_TYPE','Options Typ');
define('TEXT_ATTRIBUTES_ORDER','Bestellung');
define('TEXT_ATTRIBUTES_QUANTITY','Anzahl');
define('TEXT_ATTRIBUTES_SORT_ORDER','Reihenfolge');
define('TEXT_ATTRIBUTES_STOCK','Bestand');
define('TEXT_ATTRIBUTES_PRICE','Preis');
define('TEXT_ATTRIBUTES_PRICE_PREFIX','Vorzeichen<br/>Preis');
define('TEXT_ATTRIBUTES_WEIGTH','Gewicht');
define('TEXT_ATTRIBUTES_WEIGTH_PREFIX','Vorzeichen<br/>Gewicht');
define('TEXT_ATTRIBUTES_DIRECT_STORE','Übernommene Attribute ohne weitere Bearbeitung direkt speichern<br><br>'.
'(Wenn Sie <b>genau dieselben</b> Attribute dieses Produktes übernehmen wollen,<br>erspart man sich mit Anwahl dieser Option einen Bearbeitungsschritt.)');
define('TEXT_ATTRIBUTES_NO_PRODUCTS','Sie haben noch keine Produkte');
define('TEXT_ATTRIBUTES_NO_PRODUCT','Kein Produkt vorhanden, um die Attribute zu kopieren');
?>