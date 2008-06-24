<?php
/* -----------------------------------------------------------------------------------------
$Id: product_info.php,v 1.1.1.1.2.1 2007/04/08 07:16:18 gswkaiser Exp $

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
-------------------------------------
----------------------------------------------------
Third Party contribution:
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
New Attribute Manager v4b                            Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
Cross-Sell (X-Sell) Admin 1                          Autor: Joshua Dechant (dreamscape)
Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$is_gallery=$_GET['gallery'] || $_POST['gallery'];
include('includes/application_top.php');
$process_product_info=true;

if (IS_AJAX_PROCESSING)
{
	if (!defined('FORCE_PRODUCT_INFO_DISPLAY'))
	{
		$process_product_info=!$use_ajax_short_list;
	}
}
if ($process_product_info)
{
	require(DIR_WS_INCLUDES.'header.php');
	include(DIR_WS_MODULES.FILENAME_PRODUCT_INFO);
}
require(BOXES);
$smarty->display(INDEX_HTML);
?>