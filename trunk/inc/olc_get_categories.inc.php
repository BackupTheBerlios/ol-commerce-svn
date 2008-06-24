<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_categories.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:29 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_get_categories.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_get_categories($categories_array = '', $parent_id = '0', $indent = '')
{
	$parent_id = olc_db_prepare_input($parent_id);
	if (!is_array($categories_array))
	{
		$categories_array = array();
	}
	$sql=SELECT."
	c.categories_id,
	cd.categories_name,
	cd.categories_heading_title,
	cd.categories_description
	from " .
	TABLE_CATEGORIES . " c,	" .
	TABLE_CATEGORIES_DESCRIPTION . " cd
	where
	parent_id = '" . olc_db_input($parent_id) . "'
	and c.categories_id = cd.categories_id
	and c.categories_status != 0
	and cd.language_id = '" . SESSION_LANGUAGE_ID . "'
	order by sort_order, cd.categories_name";
	$categories_query = olc_db_query($sql);
	$indent_two_nbsp= $indent . HTML_NBSP.HTML_NBSP;
	while ($categories = olc_db_fetch_array($categories_query))
	{
		$name=$categories['categories_name'];
		$title=$categories['categories_heading_title'];
		if ($title==EMPTY_STRING)
		{
			$title=$name;
		}
		$categories_id=$categories['categories_id'];
		$categories_array[] = array(
		'id' => $categories_id,
		'text' => $indent . $name,
		'title' => $title,
		);
		if ($categories_id != $parent_id)
		{
			$categories_array = olc_get_categories($categories_array, $categories_id, $indent_two_nbsp);
		}
	}
	return $categories_array;
}
?>