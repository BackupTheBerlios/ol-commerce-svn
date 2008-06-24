<?php
/* -----------------------------------------------------------------------------------------
$Id: product_attributes.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(product_info.php,v 1.94 2003/05/04); www.oscommerce.com
(c) 2003      nextcommerce (product_info.php,v 1.46 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
New Attribute Manager v4b                            Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
Cross-Sell (X-Sell) Admin 1                          Autor: Joshua Dechant (dreamscape)   (c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
olc_smarty_init($module_smarty,$cacheid);

include(DIR_WS_MODULES."product_attributes_info_build.php");
// template query
$template_query=olc_db_query("
SELECT
options_template
FROM ".TABLE_PRODUCTS."
WHERE products_id=".$_GET['products_id']);
$template_data=olc_db_fetch_array($template_query);
$options_template=$template_data['options_template'];
$product_options='product_options';
$product_options_dir=CURRENT_TEMPLATE_MODULE .$product_options.SLASH;
if ($options_template==EMPTY_STRING or $options_template=='default')
{
	$templates_dir=TEMPLATE_PATH.$product_options_dir;
	$files=olc_get_templates($templates_dir,false,'selection');
	$options_template=$files[0]['id'];
}
//W. Kaiser - AJAX
if (USE_AJAX)
{
	$module_smarty->assign('OPTIONS_HAVE_PRICE', $options_have_price);
	$module_smarty->assign('PRODUCTS_PRICE', $products_price);
}
//W. Kaiser - AJAX
$module_smarty->assign('options',$products_options_data);
$module_smarty->assign('IS_PRINT_VERSION',$isprint_version || $is_gallery);
$module= $module_smarty->fetch($product_options_dir.$options_template,$cacheid);
if ($info_smarty)
{
	$info_smarty->assign('MODULE_product_options',$module);
}
?>