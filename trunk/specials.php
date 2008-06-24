<?php
/* -----------------------------------------------------------------------------------------
$Id: specials.php,v 1.1.1.1.2.1 2007/04/08 07:16:22 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(specials.php,v 1.47 2003/05/27); www.oscommerce.com
(c) 2003	    nextcommerce (specials.php,v 1.12 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX
$stand_alone=!defined('DIR_FS_INC');
if ($stand_alone)
{
  include('includes/application_top.php');
}
//W. Kaiser - Baseprice
$products_listing_sql = "
	select distinct
	p.products_fsk18,
	p.products_id,
	p.products_model,
	p.products_image,
	pd.products_name ,
	pd.products_short_description ,
	p.products_shippingtime,
	p.products_uvp,
	p.products_vpe,
	p.products_vpe_status,
	p.products_vpe_value,
	p.products_baseprice_show,
	p.products_baseprice_value,
	p.products_min_order_quantity,
	p.products_min_order_vpe,
	p.products_date_added,
	p.products_date_available,
	s.expires_date,
	s.specials_new_products_price
	from " .
	TABLE_PRODUCTS . " p,	" .
	TABLE_PRODUCTS_DESCRIPTION . " pd,	" .
	TABLE_SPECIALS . " s
	where p.products_status = '1'
	and p.products_id = s.products_id
	and pd.products_id = s.products_id
	and pd.language_id = '" . SESSION_LANGUAGE_ID . "'
	and s.status = '1'
	#group_fsk18#
	order by s.specials_date_added asc";

$breadcrumb_link=FILENAME_SPECIALS;
$categories_name_main="Sonderangebote";
$categories_description_main="Unsere Sonderangebote für Sie";
$force_stand_alone=true;
include(DIR_FS_INC.'olc_prepare_specials_whatsnew_modules.inc.php');
$force_stand_alone=false;
//W. Kaiser - AJAX
?>