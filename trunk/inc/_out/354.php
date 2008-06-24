<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_product_path.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:31 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_get_product_path.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// Construct a category path to the product
// TABLES: products_to_categories
function olc_get_product_path($products_id)
{
	$cPath = EMPTY_STRING;
	$category_query = olc_db_query("
	select
	p2c.categories_id from " .
	TABLE_PRODUCTS . " p, " .
	TABLE_PRODUCTS_TO_CATEGORIES . " p2c
	where
	p.products_id = '" . (int)$products_id . "' and
	p.products_status = '1' and
	p.products_id = p2c.products_id
	limit 1");
	if (olc_db_num_rows($category_query))
	{
		$category = olc_db_fetch_array($category_query);
		$categories_id=$category['categories_id'];
		$categories = array();
		olc_get_parent_categories($categories, $categories_id);
		$categories = array_reverse($categories);
		$cPath = implode(UNDERSCORE, $categories);
		if ($cPath)
		{
			$cPath .= UNDERSCORE;
		}
		$cPath .= $categories_id;
	}
	return $cPath;
}
 ?>