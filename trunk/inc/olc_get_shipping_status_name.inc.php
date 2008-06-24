<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_shipping_status_name.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:33 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2003     nextcommerce (olc_add_tax.inc.php,v 1.4 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_get_shipping_status_name ($shipping_status_id)
{
	$status_query=olc_db_query("SELECT
   shipping_status_name,
   shipping_status_image
   FROM ".TABLE_SHIPPING_STATUS."
   where shipping_status_id = '".$shipping_status_id."'
   and language_id = '".SESSION_LANGUAGE_ID.APOS);
	$status_data=olc_db_fetch_array($status_query);
	$shipping_statuses=array();
	$shipping_status=array('name'=>$status_data['shipping_status_name'],'image'=>$status_data['shipping_status_image']);
	return $shipping_status;
}
?>