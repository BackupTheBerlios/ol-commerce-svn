<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_show_category.inc.php,v 1.2 2004/02/22 16:15:30 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(categories.php,v 1.23 2002/11/12); www.oscommerce.com
(c) 2003	    nextcommerce (olc_show_category.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_show_category($counter,$img='') {
	global $foo, $categories_string, $id;

	$current_entry=$foo[$counter];
	if ($current_entry['parent'] == 0)
	{
		$cPath_new = $counter;
	}
	else
	{
		$cPath_new = $current_entry['path'];
	}
	$cPath_new = 'cPath=' . $cPath_new;
	$two_blank=HTML_NBSP.HTML_NBSP;
	for ($a=0; $a<$current_entry['level']; $a++)
	{
		$indent = $two_blank;
	}
	$link = olc_href_link(FILENAME_DEFAULT, $cPath_new);
	$link = HTML_A_START.$link .'"  title="'.$current_entry['title'].'">';
	$make_bold=($id) && (in_array($counter, $id));
	if ($make_bold) {
		$link .= HTML_B_START;
	}
	// display category name
	$link .= $current_entry['name'];
	if ($make_bold)
	{
		$link .= HTML_B_END;
	}
	$link .= HTML_A_END;
	if (SHOW_COUNTS == TRUE_STRING_S)
	{
		$products_in_category = olc_count_products_in_category($counter,false);
		if ($products_in_category > 0)
		{
			$link .= HTML_NBSP.ltrim(LPAREN) . $products_in_category . RPAREN;
		}
	}
	if (strlen($categories_string)>0)
	{
		$categories_string.=HTML_BR;
	}
	$categories_string .=$indent.$img.$link;
	$file=CURRENT_TEMPLATE_IMG.'img_underline.gif';
	if (is_file(DIR_FS_CATALOG.$file))
	{
		$categories_string.=HTML_BR.olc_image($file);
	}
	$next_id=$current_entry['next_id'];
	if ($next_id)
	{
		olc_show_category($next_id,$img);
	}
}
?>
