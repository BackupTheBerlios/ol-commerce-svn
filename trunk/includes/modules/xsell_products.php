<?php
/* -----------------------------------------------------------------------------------------
$Id:

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
(c) 2003	    nextcommerce (xsell_products.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:
Cross-Sell (X-Sell) Admin 1				Autor: Joshua Dechant (dreamscape)

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Also converted for OL-Commerce Witalij Olejnik(xaoc,xaoc2) xaoc@o2.pl
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX
$products_id_main=(int)$_GET['products_id'];
if (isset($products_id_main))
{
	if (strpos(strtolower($_SERVER["HTTP_REFERER"]),"seife")>0)
	{
		//Special handling for "seifenparadies": use xsell alsways from id 5!!!!!
		//So we do not need to set "xsell"-info for each product!
		$products_id=5;
	}
	else
	{
		$products_id=$products_id_main;
	}
	//W. Kaiser - Baseprice
	$products_listing_sql =
	"select distinct
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
	xp.sort_order from " .
	TABLE_PRODUCTS_XSELL . " xp, " .
	TABLE_PRODUCTS . " p, " .
	TABLE_PRODUCTS_DESCRIPTION . " pd
	where p.products_price >= 0
	and xp.products_id = '" . $products_id . "'
	and xp.xsell_id = p.products_id
	#group_fsk18#
	and p.products_id = pd.products_id
	and pd.language_id = '" . SESSION_LANGUAGE_ID . "'
	and p.products_status = '1'
	order by pd.products_name asc";
	$products_listing_simple=true;
	$products_use_random_data=false;
	unset($module_smarty);
	$products_listing_template=EMPTY_STRING;
	$smarty_config_section="xsell";
	$heading_text=EMPTY_STRING;
	include(DIR_FS_INC.'olc_prepare_products_listing_info.inc.php');
	if ($products_listing_entries)
	{
		$module_smarty->assign(MODULE_CONTENT,$module_content);
		$module= $module_smarty->fetch($products_listing_template,SMARTY_CACHE_ID);
		$info_smarty->assign('MODULE_'.$smarty_config_section,$module);
	}
}
//W. Kaiser - AJAX
$smarty_config_section=EMPTY_STRING;
?>