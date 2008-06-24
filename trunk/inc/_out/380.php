<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_vpe_name.inc.php 2005/07/16
OL-Commerce Version 1.2
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
XT-Commerce - community made shopping
http://www.xt-commerce.com

Copyright (c) 2003 XT-Commerce
Released under the GNU General Public License
---------------------------------------------------------------------------------------*/


function olc_get_vpe_name($vpeID) {
	$vpe_query="SELECT products_vpe_name FROM " . TABLE_PRODUCTS_VPE .
	" WHERE language_id='".SESSION_LANGUAGE_ID."' and products_vpe_id='".$vpeID.APOS;
	$vpe_query = olc_db_query($vpe_query);
	$vpe = olc_db_fetch_array($vpe_query);
	return $vpe['products_vpe_name'];
}
?>
