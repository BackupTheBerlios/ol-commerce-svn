<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_show_category_content.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:41 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(categories.php,v 1.23 2002/11/12); www.oscommerce.com
(c) 2003	    nextcommerce (olc_show_category_content.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_show_category_content($counter) {
	global $foo, $categories_string, $id;

	for ($a=0; $a<$foo[$counter]['level']; $a++) {
		$categories_string .= "&nbsp;&nbsp;";
	}
	$categories_string .= HTML_A_START;
	if ($foo[$counter]['parent'] == 0) {
		$cPath=$counter;
	} else {
		$cPath=$foo[$counter]['path'];
	}
	$cPath_new = 'cPath=' . $cPath;
	$categories_string .= olc_href_link(FILENAME_DEFAULT, $cPath_new). '">';

	if ( ($id) && (in_array($counter, $id)) ) {
		$categories_string .= HTML_B_START;
	}

	// display category name
	$categories_string .= $foo[$counter]['name'];

	if ( ($id) && (in_array($counter, $id)) ) {
		$categories_string .= HTML_B_END;
	}

	if (olc_has_category_subcategories($counter)) {
		$categories_string .= '-&gt;';
	}

	$categories_string .= HTML_A_END;

	if (SHOW_COUNTS == TRUE_STRING_S)
	{
	  $products_in_category = olc_count_products_in_category($counter);
	  if ($products_in_category > 0)
	   {
	    $categories_string .= '&nbsp;(' . $products_in_category . RPAREN;
	  }
	}

	$categories_string .= HTML_BR;

	if ($foo[$counter]['next_id']) {
		olc_show_category_content($foo[$counter]['next_id']);
	}
}
?>