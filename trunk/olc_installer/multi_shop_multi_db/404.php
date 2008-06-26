<?php
/* -----------------------------------------------------------------------------------------
$Id: 404.php,v 1.1.1.1.2.1 2007/04/08 07:18:39 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
(c) 2003	    nextcommerce (xtc_image.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

oReleased under the GNU General Public License
---------------------------------------------------------------------------------------

Custom 404 error handler.

*/

define('PHP','.php');
include('configure.php');
$p404='404.php';

$request=$_SERVER['REQUEST_URI'];
$url_parts = parse_url($request);
$file_path=$url_parts['path'];
$document_root=$_SERVER['DOCUMENT_ROOT'];
chdir($document_root.MASTER_SHOP_DIRECTORY);

define('DIR_WS_MULTI_SHOP_TEXT','DIR_WS_MULTI_SHOP');
define(DIR_WS_MULTI_SHOP_TEXT,MULTI_SHOP_DIRECTORY);

define('DIR_FS_MULTI_SHOP_TEXT','DIR_FS_MULTI_SHOP');
define(DIR_FS_MULTI_SHOP_TEXT,$document_root.MULTI_SHOP_DIRECTORY);
/*
$pictures_dirs=array('/images/','/images/','/buttons/','/Icons/');
for ($i=0,$n=sizeof($pictures_dirs);$i<$n;$i++)
{
	if (strpos($file_path,$pictures_dirs[$i])!==false)
	{
		$is_picture=true;
		include($p404);
		exit();
	}
}
*/
if (!function_exists('set_server_variable_404'))
{
	function set_server_variable_404($variable)
	{
		global $file_path;
		$server_variable=$_SERVER[$variable];

		unset($_SERVER[$variable]);
		unset($_ENV[$variable]);
		unset($HTTP_ENV_VARS[$variable]);
		unset($HTTP_SERVER_VARS[$variable]);

		$server_variable=str_replace($file_path,MASTER_SHOP_DIRECTORY,$server_variable);

		$_SERVER[$variable]=$server_variable;
		$_ENV[$variable]=$server_variable;
		$HTTP_ENV_VARS[$variable]=$server_variable;
		$HTTP_SERVER_VARS[$variable]=$server_variable;
	}
}

$doc_type=basename($file_path);
$file_path=dirname($file_path).'/';
$multi_shop_directory=$_COOKIE[DIR_FS_MULTI_SHOP_TEXT];
if ($multi_shop_directory)
{
	if (strpos($multi_shop_directory,$file_path)===false)		//Working directory change?
	{
		unset($multi_shop_directory);
	}
}
if (!$multi_shop_directory)
{
	setcookie(DIR_FS_MULTI_SHOP_TEXT,DIR_FS_MULTI_SHOP); //Expire after session
	$_COOKIE[DIR_FS_MULTI_SHOP_TEXT]=DIR_FS_MULTI_SHOP;
}
set_server_variable_404('PHP_SELF');
set_server_variable_404('SCRIPT_FILENAME');
set_server_variable_404('SCRIPT_NAME');
set_server_variable_404('REQUEST_URI');
if (substr($doc_type,0,4)=='seo-')
{
	//SEO-URL caused the error, so delegate processing to the SEO-processor!
	$f404=true;
	$processor='seo.php';
}
else
{
	//Any additional parameters??		...htm(l)?par1=var1...
	$pos=strrpos($request,'?');
	if ($pos!==false)
	{
		$parameters=substr($request,$pos+1);
		$request=substr($request,0,$pos);
		$amp='&';
		$lab='[';
		$parameters=str_replace('&amp;',$amp,$parameters);
		$params=explode($amp,$parameters);
		for ($i=0,$n=sizeof($params);$i<$n;$i++)
		{
			$parameters=explode('=',$params[$i]);
			$key=$parameters[0];
			if ($key)
			{
				$value=$parameters[1];
				if (strpos($key,$lab)!==false)
				{
					// Param-structure: id[3]=12 or products_id[]=12345;
					unset($_GET[$key]);
					$array_params=explode($lab,$key);
					$key=$array_params[1];		//3]
					$key=substr($key,0,strlen($key)-1);
					$array_key=$array_params[0];		//id
					$_GET[$array_key][$key]=$value;
					$_POST[$array_key][$key]=$value;
				}
				else
				{
					$_GET[$key]=$value;
					$_POST[$key]=$value;
				}
			}
		}
	}
	$processor=$doc_type;
}
if (!file_exists($processor))
{
	$processor=$p404;
}
include($processor)
?>
