<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_has_product_attributes.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:35 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_has_product_attributes.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// Check if product has attributes
function olc_has_product_attributes($products_id) {
	$attributes_query = olc_db_query("select count(*) as count from " . TABLE_PRODUCTS_ATTRIBUTES .
	" where products_id = '" . $products_id . APOS);
	$attributes = olc_db_fetch_array($attributes_query);
	return $attributes['count'] > 0;
}
 ?>