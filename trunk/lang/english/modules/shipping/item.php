<?php
/* -----------------------------------------------------------------------------------------
   $Id: item.php,v 2.0.0 2006/12/14 05:49:04 gswkaiser Exp $   

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

define('MODULE_SHIPPING_ITEM_TEXT_TITLE', 'Per Item');
define('MODULE_SHIPPING_ITEM_TEXT_DESCRIPTION', 'Per Item');
define('MODULE_SHIPPING_ITEM_TEXT_WAY', 'Best Way');

define('MODULE_SHIPPING_ITEM_STATUS_TITLE' , 'Enable Item Shipping');
define('MODULE_SHIPPING_ITEM_STATUS_DESC' , 'Do you want to offer per item rate shipping?');
define('MODULE_SHIPPING_ITEM_ALLOWED_TITLE' , 'Allowed Zones');
define('MODULE_SHIPPING_ITEM_ALLOWED_DESC' , 'Please enter the zones <b>separately</b> which should be allowed to use this modul (e. g. AT,DE (leave empty if you want to allow all zones))');
define('MODULE_SHIPPING_ITEM_COST_TITLE' , 'Shipping Cost');
define('MODULE_SHIPPING_ITEM_COST_DESC' , 'The shipping cost will be multiplied by the number of items in an order that uses this shipping method.');
define('MODULE_SHIPPING_ITEM_HANDLING_TITLE' , 'Handling Fee');
define('MODULE_SHIPPING_ITEM_HANDLING_DESC' , 'Handling fee for this shipping method.');
define('MODULE_SHIPPING_ITEM_TAX_CLASS_TITLE' , 'Tax Class');
define('MODULE_SHIPPING_ITEM_TAX_CLASS_DESC' , 'Use the following tax class on the shipping fee.');
define('MODULE_SHIPPING_ITEM_ZONE_TITLE' , 'Shipping Zone');
define('MODULE_SHIPPING_ITEM_ZONE_DESC' , 'If a zone is selected, only enable this shipping method for that zone.');
define('MODULE_SHIPPING_ITEM_SORT_ORDER_TITLE' , 'Sort Order');
define('MODULE_SHIPPING_ITEM_SORT_ORDER_DESC' , 'Sort order of display.');
?>
