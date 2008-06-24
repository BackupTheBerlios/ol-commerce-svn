<?php
/* -----------------------------------------------------------------------------------------
$Id: seo.php,v 1.1.1.1.2.1 2007/04/08 07:16:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
(c) 2003	    nextcommerce (olc_image.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------

SEO switcher.

Switch SEO URL to prog

http://www.server.de/olcommerce/seo-products_info-products_id-144.htm

Extended format:

http://www.server.de/olcommerce/seo-p-blue_jeans;144.htm

*/
if (!function_exists('set_server_variable_seo'))
{
	function set_server_variable_seo($variable)
	{
		global $old_processor,$processor;

		$server_variable=$_SERVER[$variable];

		unset($_SERVER[$variable]);
		unset($_ENV[$variable]);
		unset($HTTP_ENV_VARS[$variable]);
		unset($HTTP_SERVER_VARS[$variable]);

		$server_variable=str_replace($old_processor,$processor,$server_variable);

		$_SERVER[$variable]=$server_variable;
		$_ENV[$variable]=$server_variable;
		$HTTP_ENV_VARS[$variable]=$server_variable;
		$HTTP_SERVER_VARS[$variable]=$server_variable;
	}
}

$php='.php';
$seo='seo';
if ($f404)
{
	$old_processor='404'.$php;
}
else
{
	$old_processor=$seo.$php;
}
$php_self_text='PHP_SELF';
$semi_colon=';';
$empty_string='';
$request=$_SERVER['REQUEST_URI'];
//Any additional parameters??		...htm(l)?par1=var1...
$pos=strrpos($request,'?');
if ($pos!==false)
{
	$parameters=substr($request,$pos+1);
	$request=substr($request,0,$pos);
	$amp='&';
	$lab='[';
	$equal='=';
	$parameters=str_replace('&amp;',$amp,$parameters);
	$params=explode($amp,$parameters);
	for ($i=0,$n=sizeof($params);$i<$n;$i++)
	{
		$parameters=explode($equal,$params[$i]);
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
$pos=strrpos($request,'/');
if ($pos!==false)
{
	$request=substr($request,$pos+1);
}
$pos=strrpos($request,'.');
$request=substr($request,0,$pos);
$pos=strpos($request,$seo);
if ($pos!==false)
{
	$separator=$request[$pos+strlen($seo)];
	$params=explode($separator,$request);
	$parameters=sizeof($params)-1;
	$processor=$params[1];
	if (strlen($processor)==1)
	{
		$use_seo_extended=true;
	}
	else
	{
		$use_seo_extended=strpos($request,$semi_colon)!==false;
	}
}
if ($use_seo_extended)
{
	$reset_php_self=true;
	$action='';
	if ($processor == 'g')																//"General" format
	{
		$processor=$params[2].$php;
	}
	elseif (strpos('abp',$processor)!==false)							//p=Produkte, a,b=Produktkauf
	{
		$products_id=explode($semi_colon,$params[$parameters]);
		$products_id=$products_id[1];
		$key='products_id';
		$_GET[$key]=$products_id;
		$_POST[$key]=$products_id;
		$is_purchase=$processor=='a';
		if ($is_purchase || $processor=='p')
		{
			$processor='product_info'.$php;
			if ($is_purchase)
			{
				$action='add_product';
				$key='force_quantity';
				$_GET[$key]=$force_quantity;
				$_POST[$key]=$force_quantity;
			}
		}
		else
		{
			$processor='index'.$php;
			$action='buy_now';
			$key='BUYproducts_id';
			$_GET[$key]=$products_id;
			$_POST[$key]=$products_id;
		}
		$key='action';
		$_GET[$key]=$action;
		$_POST[$key]=$action;
	}
	elseif ($processor == 'k')							//Kategorien
	{
		//Build 'cPath'-parameter
		$reset_php_self=false;
		$processor='index'.$php;
		set_server_variable_seo('PHP_SELF');
		set_server_variable_seo('SCRIPT_FILENAME');
		set_server_variable_seo('SCRIPT_NAME');
		set_server_variable_seo('REQUEST_URI');
		$PHP_SELF=$_SERVER[$php_self_text];
		require('includes/application_top'.$php);
		$seo_processing=true;
		$cPath=$empty_string;
		$cat_index=array();
		for ($i=2;$i<=$parameters;$i++)
		{
			//Get key for current_category description in array
			$cat_index=array_keys($seo_categories, $params[$i]);
			if ($cPath)
			{
				$cPath.=UNDERSCORE;
			}
			$cPath.=$cat_index[0];
		}
		$key='cPath';
		$_GET[$key]=$cPath;
		$_POST[$key]=$cPath;
		if ($cPath)
		{
			$cPath_array = explode(UNDERSCORE, $cPath);
			$current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
			include(DIR_FS_INC.'olc_prepare_breadcrumb.php');
		}
		else
		{
			$current_category_id = 0;
		}
		$processor=FILENAME_DEFAULT;
	}
	elseif ($processor == 'c')							//Content
	{
		$coID=$params[$parameters];
		$coID=explode($semi_colon,$coID);
		$key='coID';
		$value=$coID[1];
		$_GET[$key]=$value;
		$_POST[$key]=$value;
		$processor='shop_content'.$php;
	}
	$admin='admin/';
	$is_admin=strpos($request,$admin)!==false;
	if ($is_admin)
	{
		$processor=$admin.$processor;
	}
	if ($reset_php_self)
	{
		set_server_variable_seo('PHP_SELF');
		set_server_variable_seo('SCRIPT_FILENAME');
		set_server_variable_seo('SCRIPT_NAME');
		set_server_variable_seo('REQUEST_URI');
		$PHP_SELF=$_SERVER[$php_self_text];
	}
}
else
{
	for ($i=2;$i<=$parameters;$i=$i+2)
	{
		$key=$params[$i];
		$value=$params[$i+1];
		$_GET[$key]=$value;
		$_POST[$key]=$value;
	}
	$processor.=$php;
}
include($processor);
?>
