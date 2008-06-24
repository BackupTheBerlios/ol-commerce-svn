<?php
/* -----------------------------------------------------------------------------------------
   $Id: item.php,v 2.0.0 2006/12/14 05:49:44 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(item.php,v 1.6 2003/02/16); www.oscommerce.com
   (c) 2003	    nextcommerce (item.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_ITEM_TEXT_TITLE', 'Versandkosten pro Stück');
define('MODULE_SHIPPING_ITEM_TEXT_DESCRIPTION', 'Versandkosten pro Stück');
define('MODULE_SHIPPING_ITEM_TEXT_WAY', 'Bester Weg');

define('MODULE_SHIPPING_ITEM_STATUS_TITLE' , 'Versandkosten pro Stück aktivieren');
define('MODULE_SHIPPING_ITEM_STATUS_DESC' , 'Möchten Sie Versandkosten pro Stück anbieten?');
define('MODULE_SHIPPING_ITEM_ALLOWED_TITLE' , 'Erlaubte Versandzonen');
define('MODULE_SHIPPING_ITEM_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, in welche ein Versand möglich sein soll. (z.B. AT,DE (lassen Sie dieses Feld leer, wenn Sie alle Zonen erlauben wollen))');
define('MODULE_SHIPPING_ITEM_COST_TITLE' , 'Versandkosten');
define('MODULE_SHIPPING_ITEM_COST_DESC' , 'Die Versandkosten werden mit der Anzahl an Artikel einer Bestellung multipliziert, wenn diese Versandart angegeben ist.');
define('MODULE_SHIPPING_ITEM_HANDLING_TITLE' , 'Bearbeitungsgebühr');
define('MODULE_SHIPPING_ITEM_HANDLING_DESC' , MODULE_SHIPPING_ITEM_HANDLING_TITLE.' für diese Versandart.');
define('MODULE_SHIPPING_ITEM_TAX_CLASS_TITLE' , 'Steuerklasse');
define('MODULE_SHIPPING_ITEM_TAX_CLASS_DESC' , 'Folgende Steuerklasse an Versandkosten anwenden');
define('MODULE_SHIPPING_ITEM_ZONE_TITLE' , 'Versandzone');
define('MODULE_SHIPPING_ITEM_ZONE_DESC' , 'Wenn eine Zone ausgewählt ist, wird diese Versandmethode ausschliseslich für diese Zone angewendet');
define('MODULE_SHIPPING_ITEM_SORT_ORDER_TITLE' , 'Sortierreihenfolge');
define('MODULE_SHIPPING_ITEM_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige');
?>