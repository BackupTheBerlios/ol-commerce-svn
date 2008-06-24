<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_parent_categories.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:31 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_get_parent_categories.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// Recursively go through the categories and retrieve all parent categories IDs
// TABLES: categories
function olc_get_parent_categories(&$categories, $categories_id)
{
	$parent_id_text='parent_id';
	$parent_categories_query = olc_db_query("select parent_id from " . TABLE_CATEGORIES .
	" where categories_id = '" . $categories_id . APOS);
	while ($parent_categories = olc_db_fetch_array($parent_categories_query))
	{
		if ($parent_categories[$parent_id_text] == 0)
		{
			return true;
		}
		else
		{
			$categories[sizeof($categories)] = $parent_categories[$parent_id_text];
			if ($parent_categories[$parent_id_text] != $categories_id)
			{
				olc_get_parent_categories($categories, $parent_categories[$parent_id_text]);
			}
		}
	}
}
?>