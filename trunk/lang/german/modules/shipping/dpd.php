<?php
/* -----------------------------------------------------------------------------------------
   $Id: dpd.php,v 2.0.0 2006/12/14 05:49:42 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(UPS.php,v 1.4 2003/02/18 04:28:00); www.oscommerce.com
   (c) 2003	    nextcommerce (UPS.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Deutscher Paketdienst         	Autor:	Copyright (C) 2004 Manfred Tomanik http://www.st-computer.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


define('MODULE_SHIPPING_DPD_TEXT_TITLE', 'DPD Service Standard');
define('MODULE_SHIPPING_DPD_TEXT_DESCRIPTION', 'DPD Service - Versandmodul');
define('MODULE_SHIPPING_DPD_TEXT_WAY', 'Versand nach');
define('MODULE_SHIPPING_DPD_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_DPD_INVALID_ZONE', 'Es ist leider kein Versand in dieses Land möglich');
define('MODULE_SHIPPING_DPD_UNDEFINED_RATE', 'Die Versandkosten können im Moment nicht errechnet werden');

define('MODULE_SHIPPING_DPD_STATUS_TITLE' , 'DPD Standard');
define('MODULE_SHIPPING_DPD_STATUS_DESC' , 'Wollen Sie den Versand über United Parcel Service anbieten?');
define('MODULE_SHIPPING_DPD_HANDLING_TITLE' , 'Bearbeitungsgebühr');
define('MODULE_SHIPPING_DPD_HANDLING_DESC' , MODULE_SHIPPING_DPD_HANDLING_TITLE.' für diese Versandart in Euro');
define('MODULE_SHIPPING_DPD_TAX_CLASS_TITLE' , 'Steuersatz');
define('MODULE_SHIPPING_DPD_TAX_CLASS_DESC' , 'Wählen Sie den MwSt.-Satz für diese Versandart aus.');
define('MODULE_SHIPPING_DPD_ZONE_TITLE' , 'Versand Zone');
define('MODULE_SHIPPING_DPD_ZONE_DESC' , 'Wenn Sie eine Zone auswählen, wird diese Versandart nur in dieser Zone angeboten.');
define('MODULE_SHIPPING_DPD_SORT_ORDER_TITLE' , 'Reihenfolge der Anzeige');
define('MODULE_SHIPPING_DPD_SORT_ORDER_DESC' , 'Niedrigste wird zuerst angezeigt.');
define('MODULE_SHIPPING_DPD_ALLOWED_TITLE' , 'Einzelne Versandzonen');
define('MODULE_SHIPPING_DPD_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, in welche ein Versand möglich sein soll. zb AT,DE');

define('MODULE_SHIPPING_DPD_COUNTRIES_1_TITLE' , 'DPD Zone 1 Countries');
define('MODULE_SHIPPING_DPD_COUNTRIES_1_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 1');
define('MODULE_SHIPPING_DPD_COST_1_TITLE' , 'DPD Zone 1 Shipping Table');
define('MODULE_SHIPPING_DPD_COST_1_DESC' , 'Shipping rates to Zone 1 destinations based on a range of order weights. Example: 0-3:8.50,3-7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 14.57 for Zone 1 destinations.');

define('MODULE_SHIPPING_DPD_COUNTRIES_2_TITLE' , 'DPD Zone 2 Countries');
define('MODULE_SHIPPING_DPD_COUNTRIES_2_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 2');
define('MODULE_SHIPPING_DPD_COST_2_TITLE' , 'DPD Zone 2 Shipping Table');
define('MODULE_SHIPPING_DPD_COST_2_DESC' , 'Shipping rates to Zone 2 destinations based on a range of order weights. Example: 0-3:8.50,3-7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 14.57 for Zone 1 destinations.');

define('MODULE_SHIPPING_DPD_COUNTRIES_3_TITLE' , 'DPD Zone 3 Countries');
define('MODULE_SHIPPING_DPD_COUNTRIES_3_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 3');
define('MODULE_SHIPPING_DPD_COST_3_TITLE' , 'DPD Zone 3 Shipping Table');
define('MODULE_SHIPPING_DPD_COST_3_DESC' , 'Shipping rates to Zone 3 destinations based on a range of order weights. Example: 0-3:8.50,3-7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 14.57 for Zone 1 destinations.');

define('MODULE_SHIPPING_DPD_COUNTRIES_4_TITLE' , 'DPD Zone 4 Countries');
define('MODULE_SHIPPING_DPD_COUNTRIES_4_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 4');
define('MODULE_SHIPPING_DPD_COST_4_TITLE' , 'DPD Zone 4 Shipping Table');
define('MODULE_SHIPPING_DPD_COST_4_DESC' , 'Shipping rates to Zone 5 destinations based on a range of order weights. Example: 0-3:8.50,3-7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 14.57 for Zone 1 destinations.');

define('MODULE_SHIPPING_DPD_COUNTRIES_5_TITLE' , 'DPD Zone 5 Countries');
define('MODULE_SHIPPING_DPD_COUNTRIES_5_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 5');
define('MODULE_SHIPPING_DPD_COST_5_TITLE' , 'DPD Zone 5 Shipping Table');
define('MODULE_SHIPPING_DPD_COST_5_DESC' , 'Shipping rates to Zone 5 destinations based on a range of order weights. Example: 0-3:8.50,3-7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 14.57 for Zone 1 destinations.');

define('MODULE_SHIPPING_DPD_COUNTRIES_6_TITLE' , 'DPD Zone 6 Countries');
define('MODULE_SHIPPING_DPD_COUNTRIES_6_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 6');
define('MODULE_SHIPPING_DPD_COST_6_TITLE' , 'DPD Zone 6 Shipping Table');
define('MODULE_SHIPPING_DPD_COST_6_DESC' , 'Shipping rates to Zone 6 destinations based on a range of order weights. Example: 0-3:8.50,3-7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 14.57 for Zone 1 destinations.');

define('MODULE_SHIPPING_DPD_COUNTRIES_7_TITLE' , 'DPD Zone 7 Countries');
define('MODULE_SHIPPING_DPD_COUNTRIES_7_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 7');
define('MODULE_SHIPPING_DPD_COST_7_TITLE' , 'DPD Zone 7 Shipping Table');
define('MODULE_SHIPPING_DPD_COST_7_DESC' , 'Shipping rates to Zone 7 destinations based on a range of order weights. Example: 0-3:8.50,3-7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 14.57 for Zone 1 destinations.');

define('MODULE_SHIPPING_DPD_COUNTRIES_8_TITLE' , 'DPD Zone 8 Countries');
define('MODULE_SHIPPING_DPD_COUNTRIES_8_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 8');
define('MODULE_SHIPPING_DPD_COST_8_TITLE' , 'DPD Zone 8 Shipping Table');
define('MODULE_SHIPPING_DPD_COST_8_DESC' , 'Shipping rates to Zone 8 destinations based on a range of order weights. Example: 0-3:8.50,3-7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 14.57 for Zone 1 destinations.');

define('MODULE_SHIPPING_DPD_COUNTRIES_9_TITLE' , 'DPD Zone 9 Countries');
define('MODULE_SHIPPING_DPD_COUNTRIES_9_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 9');
define('MODULE_SHIPPING_DPD_COST_9_TITLE' , 'DPD Zone 9 Shipping Table');
define('MODULE_SHIPPING_DPD_COST_9_DESC' , 'Shipping rates to Zone 9 destinations based on a range of order weights. Example: 0-3:8.50,3-7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 14.57 for Zone 1 destinations.');

define('MODULE_SHIPPING_DPD_COUNTRIES_10_TITLE' , 'DPD Zone 10 Countries');
define('MODULE_SHIPPING_DPD_COUNTRIES_10_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 10');
define('MODULE_SHIPPING_DPD_COST_10_TITLE' , 'DPD Zone 10 Shipping Table');
define('MODULE_SHIPPING_DPD_COST_10_DESC' , 'Shipping rates to Zone 10 destinations based on a range of order weights. Example: 0-3:8.50,3-7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 14.57 for Zone 1 destinations.');

define('MODULE_SHIPPING_DPD_COUNTRIES_11_TITLE' , 'DPD Zone 11 Countries');
define('MODULE_SHIPPING_DPD_COUNTRIES_11_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 11');
define('MODULE_SHIPPING_DPD_COST_11_TITLE' , 'DPD Zone 11 Shipping Table');
define('MODULE_SHIPPING_DPD_COST_11_DESC' , 'Shipping rates to Zone 11 destinations based on a range of order weights. Example: 0-3:8.50,3-7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 14.57 for Zone 1 destinations.');

define('MODULE_SHIPPING_DPD_COUNTRIES_12_TITLE' , 'DPD Zone 12 Countries');
define('MODULE_SHIPPING_DPD_COUNTRIES_12_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 12');
define('MODULE_SHIPPING_DPD_COST_12_TITLE' , 'DPD Zone 12 Shipping Table');
define('MODULE_SHIPPING_DPD_COST_12_DESC' , 'Shipping rates to Zone 12 destinations based on a range of order weights. Example: 0-3:8.50,3-7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 14.57 for Zone 1 destinations.');


?>
