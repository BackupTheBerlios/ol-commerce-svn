<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_tax_class_id.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:34 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)  

(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_get_tax_class_id($products_id) {


	$tax_query = olc_db_query("SELECT
                               products_tax_class_id
                               FROM ".TABLE_PRODUCTS."
                               where products_id='".$products_id.APOS);
	$tax_query_data=olc_db_fetch_array($tax_query);

	return $tax_query_data['products_tax_class_id'];
}
 ?>