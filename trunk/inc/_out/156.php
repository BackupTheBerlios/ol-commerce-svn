<?PHP
/* -----------------------------------------------------------------------------------------
$Id: olc_get_products_mo_images.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:32 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_get_products_mo_images($products_id = ''){
	$mo_query = "select image_id, image_nr, image_name from " . TABLE_PRODUCTS_IMAGES .
	" where products_id = '" . $products_id ."' ORDER BY image_nr";
	$products_mo_images_query = olc_db_query($mo_query);
	while ($row=olc_db_fetch_array($products_mo_images_query)) $results[($row['image_nr']-1)] = $row;
	return $results;
}
?>