<?php
/* -----------------------------------------------------------------------------------------
$Id: products_new.php,v 1.1.1.1.2.1 2007/04/08 07:16:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(products_new.php,v 1.25 2003/05/27); www.oscommerce.com
(c) 2003	 nextcommerce (products_new.php,v 1.16 2003/08/18); www.nextcommerce.org
(c) 2004  XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:
Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include( 'includes/application_top.php');
//W. Kaiser - AJAX
$products_listing_sql_main =
	olc_standard_products_query($new_products_category_id) .
	"and (p.products_date_available IS NULL OR
		(p.products_date_available IS NOT NULL AND to_days(p.products_date_available)<=to_days(now()))
	)
  order by p.products_id DESC
  limit " . MAX_DISPLAY_NEW_PRODUCTS;

$products_listing_template=EMPTY_STRING;
$products_listing_simple=false;
$breadcrumb_link=FILENAME_PRODUCTS_NEW;
$smarty_config_section="new_products";
$$categories_name_main=TEXT_CAT_NEW_PRODUCTS;
$categories_description_main=TEXT_OUR_NEW_PRODUCTS;
$force_stand_alone=true;
include(DIR_FS_INC.'olc_prepare_specials_whatsnew_modules.inc.php');
$force_stand_alone=false;
?>