<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_set_multi_shop_dir_info.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:40 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com
(c) 2003	    nextcommerce (olc_banner_exists.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_set_multi_shop_dir_info($url)
{
	if (DIR_WS_CATALOG<>SLASH && strpos($url,DIR_WS_CATALOG)!==false)
	{
		$url=str_replace(DIR_WS_CATALOG,DIR_WS_MULTI_SHOP,$url);
	}
	else
	{
		$url=DIR_WS_MULTI_SHOP.$url;
	}
	$url=MULTI_SHOP_SERVER.$url;
	return $url;
}
?>