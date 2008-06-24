<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_count_products_in_category.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:13 gswkaiser Exp $

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

function olc_count_products_in_category($category_id, $include_inactive = false)
{
	$products_count = 0;
	if (SHOW_COUNTS == TRUE_STRING_S)
	{
		if (!$include_inactive)
		{
			$products_status="
		p.products_status = '1' and
";
		}
		$products_query = olc_db_query(
		"select count(*) as total from " .
		TABLE_PRODUCTS . " p, " .
		TABLE_PRODUCTS_TO_CATEGORIES . " p2c
		where	".$products_status."
		p.products_id = p2c.products_id and
		p2c.categories_id = '" . $category_id . APOS);
		$products = olc_db_fetch_array($products_query);
		$products_count += $products['total'];
		$child_categories_query = olc_db_query("select categories_id from " . TABLE_CATEGORIES .
		" where parent_id = '" . $category_id . APOS);
		if (olc_db_num_rows($child_categories_query)) {
			while ($child_categories = olc_db_fetch_array($child_categories_query)) {
				$products_count += olc_count_products_in_category($child_categories['categories_id'], $include_inactive);
			}
		}
	}
	return $products_count;
}
 ?>