<?php
/* -----------------------------------------------------------------------------------------
$Id: new_products.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(new_products.php,v 1.33 2003/02/12); www.oscommerce.com
(c) 2003	    nextcommerce (new_products.php,v 1.9 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:
Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX
$stand_alone=!defined('DIR_FS_INC');
if ($stand_alone)
{
  include('includes/application_top.php');
}

$products_listing_sql_main =
	olc_standard_products_query($new_products_category_id) .
"
	and (p.products_date_available IS NULL OR
		(p.products_date_available IS NOT NULL AND to_days(p.products_date_available)<=to_days(now()))
	)
  order by p.products_id DESC
  limit " . MAX_DISPLAY_NEW_PRODUCTS;

$breadcrumb_link=FILENAME_NEW_PRODUCTS;
$smarty_config_section="new_products";
$$categories_name_main=TEXT_CAT_NEW_PRODUCTS;
$categories_description_main=TEXT_OUR_NEW_PRODUCTS;
$force_stand_alone=!$force_stand_alone_deny;
$ignore_scripts=CURRENT_SCRIPT;
include(DIR_FS_INC.'olc_prepare_specials_whatsnew_modules.inc.php');
$force_stand_alone=false;
?>