<?php
/* -----------------------------------------------------------------------------------------
   $Id: freeamount.php,v 2.0.0 2006/12/14 05:49:04 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce( freeamount.php,v 1.01 2002/01/24 03:25:00); www.oscommerce.com
   (c) 2003	    nextcommerce (freeamount.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   freeamountv2-p1         	Autor:	dwk
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_FREECOUNT_TEXT_TITLE', 'Free Shipping');
define('MODULE_SHIPPING_FREECOUNT_TEXT_DESCRIPTION', 'Free Shipping w/ Minimum Order Amount');
//define('MODULE_SHIPPING_FREECOUNT_TEXT_WAY', 'w/ $' . MODULE_SHIPPING_FREECOUNT_AMOUNT . ' minimum order');
//W. Kaiser
require_once(DIR_FS_INC .'olc_format_price.inc.php');
//	W. Kaiser - Free shipping national/international
require_once(DIR_FS_INC.'olc_get_free_shipping_amount.inc.php');
olc_get_free_shipping_amount();
//	W. Kaiser - Free shipping national/international
define('MODULE_SHIPPING_FREECOUNT_TEXT_WAY', 'From <b>' .
	olc_format_price(FREE_AMOUNT, $price_special = 1, $calculate_currencies = false) .
	'</b> order value onwardswie ship your order <b>without</b> shipping cost!<br/>'.
	'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<font color="red"><b>Missing order amount for free shipment:&nbsp;</b></font>');
//W. Kaiser

define('MODULE_SHIPPING_FREECOUNT_SORT_ORDER', 'Sort Order');

define('MODULE_SHIPPING_FREEAMOUNT_ALLOWED_TITLE' , 'Allowed Zones');
define('MODULE_SHIPPING_FREEAMOUNT_ALLOWED_DESC' , 'Please enter the zones <b>separately</b> which should be allowed to use this modul (e. g. AT,DE (leave empty if you want to allow all zones))');
define('MODULE_SHIPPING_FREECOUNT_STATUS_TITLE' , 'Enable Free Shipping with Minimum Purchase');
define('MODULE_SHIPPING_FREECOUNT_STATUS_DESC' , 'Do you want to offer free shipping?');
define('MODULE_SHIPPING_FREECOUNT_DISPLAY_TITLE' , 'Enable Display');
define('MODULE_SHIPPING_FREECOUNT_DISPLAY_DESC' , 'Do you want to display text way if the minimum amount is not reached?');
define('MODULE_SHIPPING_FREECOUNT_AMOUNT_TITLE' , 'Minimum Cost');
define('MODULE_SHIPPING_FREECOUNT_AMOUNT_DESC' , 'Minimum order amount purchased before shipping is free?');
define('MODULE_SHIPPING_FREECOUNT_SORT_ORDER_TITLE' , 'Display order');
define('MODULE_SHIPPING_FREECOUNT_SORT_ORDER_DESC' , 'Lowest will be displayed first.');
?>
