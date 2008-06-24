<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_external_config_data.inc.php,v 1.1.1.2.2.1 2007/04/08 07:17:30 gswkaiser Exp $

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

//Multi-Store capability: get special store parameters
if (isset($f404))
{
	define(DIR_WS_MULTI_SHOP_TEXT,str_replace($document_root,'',$multi_shop_directory));
}
else
{
	//E_ALL & ~E_NOTICE
	$s='DIR_FS_MULTI_SHOP_TEXT';
	if (!defined($s))
	{
		define($s,'DIR_FS_MULTI_SHOP');
		define('DIR_WS_MULTI_SHOP_TEXT','DIR_WS_MULTI_SHOP');
	}
	if (defined(DIR_FS_MULTI_SHOP_TEXT))
	{
		$multi_shop_directory=DIR_FS_MULTI_SHOP;
	}
	else
	{
		$multi_shop_directory=$_COOKIE[DIR_FS_MULTI_SHOP_TEXT];
		if (!$multi_shop_directory)
		{
			$multi_shop_directory=$_POST[DIR_FS_MULTI_SHOP_TEXT];
			if ($multi_shop_directory)
			{
				unset($_POST[DIR_FS_MULTI_SHOP_TEXT]);
			}
			else
			{
				$multi_shop_directory=$_GET[DIR_FS_MULTI_SHOP_TEXT];
				if ($multi_shop_directory)
				{
					unset($_GET[DIR_FS_MULTI_SHOP_TEXT]);
				}
			}
			if ($multi_shop_directory)
			{
				include($multi_shop_directory.'configure.php');
			}
		}
		define(DIR_FS_MULTI_SHOP_TEXT,$multi_shop_directory);
	}
}
define('IS_MULTI_SHOP',$multi_shop_directory<>'');
if (IS_MULTI_SHOP)
{
	if (!defined(DIR_WS_MULTI_SHOP_TEXT))
	{
		define(DIR_WS_MULTI_SHOP_TEXT,str_replace($_SERVER['DOCUMENT_ROOT'],'',$multi_shop_directory));
	}
	if (getenv(HTTPS) == null)
	{
		$server=HTTP_SERVER;
	}
	else
	{
		$server=HTTPS_SERVER;
	}
	define('MULTI_SHOP_SERVER',$server);
	include_once('inc/olc_set_multi_shop_dir_info.inc.php');
}
?>