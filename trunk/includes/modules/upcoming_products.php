<?php
/* -----------------------------------------------------------------------------------------
$Id: upcoming_products.php,v 1.1.1.1.2.1 2007/04/08 07:18:02 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(upcoming_products.php,v 1.23 2003/02/12); www.oscommerce.com
(c) 2003	    nextcommerce (upcoming_products.php,v 1.7 2003/08/22); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//$products_listing_sql = "
$products_listing_sql_main =
	olc_standard_products_query($current_category_id) ."
  and to_days(p.products_date_available) > to_days(now())
  order by products_date_available ". EXPECTED_PRODUCTS_SORT .
  " limit " . MAX_DISPLAY_UPCOMING_PRODUCTS;

unset($module_smarty);
$breadcrumb_link=FILENAME_UPCOMING_PRODUCTS;
$smarty_config_section="upcoming_products";
$categories_name=TEXT_CAT_UPCOMING_PRODUCTS;
$categories_description=TEXT_OUR_UPCOMING_PRODUCTS;
$force_stand_alone=!$force_stand_alone_deny;
$ignore_scripts=CURRENT_SCRIPT;
include(DIR_FS_INC.'olc_prepare_specials_whatsnew_modules.inc.php');
$force_stand_alone=false;
?>