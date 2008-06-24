<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_seo_data.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:33 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_count_products_in_category.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

global $seo_categories,	$seo_search, $seo_replace,$seo_categories_text;

$s=$_SESSION['seo_categories_text'];
//if (IS_LOCAL_HOST && sizeof($s)>0)
if (sizeof($s)>0)
{
	$seo_categories=$s;
	$seo_search=$_SESSION[$seo_search_text];
	$seo_replace=$_SESSION[$seo_replace_text];
}
else
{
	if (USE_SEO)
	{
		//Get all categories info
		$seo_search=array(
		SLASH.SEO_SEPARATOR.SLASH.'i',
		"'\s&\s'",
		"'[\r\n\s]+'",
		"'&(quote|#34);'i",
		"'&(amp|#38);'i",
		"'&(lt|#60);'i",
		"'&(gt|#62);'i",
		"'&(nbsp|#160);'i",
		"'&(iexcl|#161);'i",
		"'&(cent|#162);'i",
		"'&(pound|#163);'i",
		"'&(copy|#169);'i",
		"'&'",
		"/[\[\({]/",
		"/[\)\]\}]/",
		"/ß/",
		"/ä/",
		"/ü/",
		"/ö/",
		"/Ä/",
		"/Ü/",
		"/Ö/",
		"/[áàâ]/",
		"/[éèê]/",
		"/[íìî]/",
		"/[óòô]/",
		"/[úùû]/",
		"/'|\"|´|`/",
		"/[:,\.!?]/",
		);

		$seo_replace=array(
		UNDERSCORE,
		UNDERSCORE,
		UNDERSCORE,
		"\"",
		UNDERSCORE,
		"<",
		">",
		EMPTY_STRING,
		EMPTY_STRING,
		EMPTY_STRING,
		EMPTY_STRING,
		EMPTY_STRING,
		UNDERSCORE,
		EMPTY_STRING,
		EMPTY_STRING,
		"ss",
		"ae",
		"ue",
		"oe",
		"Ae",
		"Ue",
		"Oe",
		"a",
		"e",
		"i",
		"o",
		"u",
		EMPTY_STRING,
		EMPTY_STRING
		);
		$_SESSION[$seo_search_text]=$seo_search;
		$_SESSION[$seo_replace_text]=$seo_replace;
	}
	include_once(DIR_FS_INC.'olc_get_categories.inc.php');
	$categories = olc_get_categories($categories, 0, EMPTY_STRING);
	$text_text='text';
	$id_text='id';
	$seo_categories=array();
	for ($i=0,$n=sizeof($categories);$i<$n;$i++)
	{
		$categories_text=strip_tags(str_replace(HTML_NBSP,EMPTY_STRING,$categories[$i][$text_text]));
		if (USE_SEO)
		{
			$categories_text=strtolower(preg_replace($seo_search,$seo_replace,$categories_text));
		}
		$seo_categories[(string)$categories[$i][$id_text]]=$categories_text;
	}
}
?>