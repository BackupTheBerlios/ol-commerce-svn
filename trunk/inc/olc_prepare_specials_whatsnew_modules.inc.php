<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_prepare_specials_whatsnew_modules.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:39 gswkaiser Exp $

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
if ($stand_alone || $force_stand_alone)
{
	olc_smarty_init($smarty,$cacheid);
	require(DIR_WS_INCLUDES . 'header.php');
	$breadcrumb->add($breadcrumb_title, olc_href_link($breadcrumb_link));
}
// get default template
$products_listing_sql=$products_listing_sql_main;
$categories_name=$categories_name_main;
$categories_description=$categories_description_main;
include(DIR_FS_INC.'olc_prepare_products_listing.inc.php');
if ($stand_alone || $force_stand_alone)
{
	if (NOT_USE_AJAX)
	{
		require(BOXES);
	}
	$smarty->display(INDEX_HTML);
	$stand_alone=false;
}
else
{
	if ($products_listing_entries)
	{
		$module_smarty->assign(MODULE_CONTENT,$module_content);
		$module= $module_smarty->fetch($products_listing_template,SMARTY_CACHE_ID);
		$default_smarty->assign('MODULE_'.$smarty_config_section,$module);
		if ($do_slide_show)
		{
			$slide_show.=$module;
		}
	}
}
$smarty_config_section=EMPTY_STRING;
$products_listing_sql_main=EMPTY_STRING;
//W. Kaiser - AJAX
?>