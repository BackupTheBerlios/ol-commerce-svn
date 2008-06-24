<?php
/* -----------------------------------------------------------------------------------------
   $Id: zones.php,v 2.0.0 2006/12/14 05:49:45 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(zones.php,v 1.3 2002/04/17); www.oscommerce.com
   (c) 2003	    nextcommerce (zones.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_ZONES_TEXT_TITLE', 'Versandkosten');
define('MODULE_SHIPPING_ZONES_TEXT_DESCRIPTION', 'Versandkosten zonenbasierend');
define('MODULE_SHIPPING_ZONES_TEXT_WAY', 'Versand nach');
define('MODULE_SHIPPING_ZONES_TEXT_WEIGHT', 'Gewicht');
define('MODULE_SHIPPING_ZONES_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_ZONES_INVALID_ZONE', 'Es ist kein Versand in dieses Land möglich!');
define('MODULE_SHIPPING_ZONES_UNDEFINED_RATE', 'Die Versandkosten können im Moment nicht berechnet werden.');

define('MODULE_SHIPPING_ZONES_STATUS_TITLE' , 'Versandkosten nach Zonen Methode aktivieren');
define('MODULE_SHIPPING_ZONES_STATUS_DESC' , 'Möchten Sie Versandkosten nach Zonen anbieten?');
define('MODULE_SHIPPING_ZONES_ALLOWED_TITLE' , 'Erlaubte Versandzonen');
define('MODULE_SHIPPING_ZONES_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, in welche ein Versand möglich sein soll. (z.B. AT,DE (lassen Sie dieses Feld leer, wenn Sie alle Zonen erlauben wollen))');
define('MODULE_SHIPPING_ZONES_TAX_CLASS_TITLE' , 'Steuerklasse');
define('MODULE_SHIPPING_ZONES_TAX_CLASS_DESC' , 'Folgende Steuerklasse auf Versandkosten anwenden');
define('MODULE_SHIPPING_ZONES_SORT_ORDER_TITLE' , 'Sortierreihenfolge');
define('MODULE_SHIPPING_ZONES_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige');

define('MODULE_SHIPPING_ZONES_COUNTRIES_1_TITLE' , 'Zone 1 Länder');
define('MODULE_SHIPPING_ZONES_COUNTRIES_1_DESC' , 'Durch Komma getrennte Liste von ISO Ländercodes (2 Zeichen), welche Teil von Zone 1 sind.');
define('MODULE_SHIPPING_ZONES_COST_1_TITLE' , 'Zone 1 Versandkosten');
define('MODULE_SHIPPING_ZONES_COST_1_DESC' , 'Versandkosten nach Zone 1 Bestimmungsorte, basierend auf einer Gruppe von max. Bestellgewichten. Beispiel: 3:8.50,7:10.50,... Gewicht von kleiner oder gleich 3 würde 8.50 für die Zone 1 Bestimmungsländer kosten.');
define('MODULE_SHIPPING_ZONES_HANDLING_1_TITLE' , 'Zone 1 Bearbeitungsgebühr');
define('MODULE_SHIPPING_ZONES_HANDLING_1_DESC' , 'Bearbeitungsgebühr für diese Versandzone');

define('MODULE_SHIPPING_ZONES_COUNTRIES_2_TITLE' , 'Zone 2 Länder');
define('MODULE_SHIPPING_ZONES_COUNTRIES_2_DESC' , 'Durch Komma getrennte Liste von ISO Ländercodes (2 Zeichen), welche Teil von Zone 2 sind.');
define('MODULE_SHIPPING_ZONES_COST_2_TITLE' , 'Zone 2 Versandkosten');
define('MODULE_SHIPPING_ZONES_COST_2_DESC' , 'Versandkosten nach Zone 2 Bestimmungsorte, basierend auf einer Gruppe von max. Bestellgewichten. Beispiel: 3:8.50,7:20.50,... Gewicht von kleiner oder gleich 3 würde 8.50 für die Zone 2 Bestimmungsländer kosten.');
define('MODULE_SHIPPING_ZONES_HANDLING_2_TITLE' , 'Zone 2 Bearbeitungsgebühr');
define('MODULE_SHIPPING_ZONES_HANDLING_2_DESC' , MODULE_SHIPPING_ZONES_HANDLING_1_DESC);
?>
