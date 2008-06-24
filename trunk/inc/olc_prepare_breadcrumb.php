<?php
//W. Kaiser - AJAX
/* -----------------------------------------------------------------------------------------
$Id: olc_prepare_breadcrumb.php,v 1.1.1.1.2.1 2007/04/08 07:17:39 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

AJAX = Asynchronous JavaScript and XML
Info: http://de.wikipedia.org/wiki/Ajax_(Programmierung)

AJAX-error return routine

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de), w.kaiser@fortune.de

-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.18 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (shopping_cart.php,v 1.15 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------
*/

// calculate category path
$manufacturers_id=$_GET['manufacturers_id'];
$products_id=$_GET['products_id'];
$cPath = $_GET['cPath'];
if (!$cPath )
{
	if ($products_id)
	{
		if (!$manufacturers_id)
		{
			$cPath = olc_get_product_path((int)$products_id);
		}
	}
}
if (olc_not_null($cPath))
{
	$cPath_array = olc_parse_category_path($cPath);
	$cPath = implode(UNDERSCORE, $cPath_array);
	$current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
} else {
	$current_category_id = 0;
}
// add category names or the manufacturer name to the breadcrumb trail
if (!$manufacturers_id)
{
	$manufacturers_id=$_GET['filter_id'];
}
if (!$manufacturers_id)
{
	if ($products_id)
	{
		$manufacturers_query = olc_db_query("select manufacturers_id from " . TABLE_PRODUCTS .
		" where products_id = '" . $products_id . APOS);
		if (olc_db_num_rows($manufacturers_query))
		{
			$products_data=olc_db_fetch_array($manufacturers_query);
			$manufacturers_id=$products_data['manufacturers_id'];
		}
	}
}
if ($manufacturers_id)
{
	$manufacturers_query = olc_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS .
	" where manufacturers_id = '" . $manufacturers_id . APOS);
	$manufacturers = olc_db_fetch_array($manufacturers_query);
	$global_manufacturers_name=$manufacturers['manufacturers_name'];
	$global_manufacturers_text=ENTRY_MANUFACTURERS.' "'.$global_manufacturers_name.'"';
}
if (isset($cPath_array))
{
	if (DO_GROUP_CHECK)
	{
		$group_check=" and c.".SQL_GROUP_CONDITION;
	}
	$not_products_id=!$products_id;
	for ($i=0, $n=sizeof($cPath_array)-1; $i<=$n; $i++)
	{
		$categories_query = olc_db_query("select
                                      cd.categories_name
                                      from " . TABLE_CATEGORIES_DESCRIPTION . " cd,
                                      ".TABLE_CATEGORIES." c
                                      where cd.categories_id = '" . $cPath_array[$i] . "'
                                      and c.categories_id=cd.categories_id
                                      ".$group_check."
                                      and cd.language_id='" . SESSION_LANGUAGE_ID . APOS);
		if (olc_db_num_rows($categories_query) > 0)
		{
			$categories = olc_db_fetch_array($categories_query);
			$categories_name=$categories['categories_name'];
			if ($not_products_id)
			{
				if ($i==$n)
				{
					if ($global_manufacturers_text)
					{
						$categories_name.=LPAREN.$global_manufacturers_text.RPAREN;
					}
				}
			}
			$breadcrumb->add($categories_name, olc_href_link(FILENAME_DEFAULT,
			'cPath=' . implode(UNDERSCORE, array_slice($cPath_array, 0, ($i+1)))));
		} else {
			break;
		}
	}
}
else
{
	if ($manufacturers_id)
	{
		$breadcrumb->add($global_manufacturers_text,olc_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $manufacturers_id));
	}
}
// add the products name to the breadcrumb trail
if ($products_id)
{
	$model_query = olc_db_query("select products_name from " . TABLE_PRODUCTS_DESCRIPTION .
	" where products_id = '" . $products_id . APOS);
	$model = olc_db_fetch_array($model_query);
	//$link=olc_href_link(FILENAME_PRODUCT_INFO,'cPath=' . $cPath . '&products_id=' . $products_id,NONSSL,false,true,false);
	$link=olc_href_link(FILENAME_PRODUCT_INFO,'products_id=' . $products_id);
	$products_name=str_replace('\\',EMPTY_STRING,$model['products_name']);
	$breadcrumb->add(preg_replace('/<(br\/?|\/p|p)>/i', BLANK, $products_name), $link);
}
?>