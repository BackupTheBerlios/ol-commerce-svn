<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_customers_statuses.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:30 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on Third Party contribution:
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_get_customers_statuses.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// Return all customers statuses for a specified language_id and return an array(array())
// Use it to make pull_down_menu, checkbox....
function olc_get_customers_statuses()
{
	$customers_statuses_array = array(array());
	if (SESSION_LANGUAGE_ID)
	{
		$language_id=SESSION_LANGUAGE_ID;
	} else {
		$language_id=1;
	}
	$customers_statuses_query = olc_db_query(SELECT_ALL . TABLE_CUSTOMERS_STATUS .
		" where language_id = '".$language_id."' order by customers_status_id");
	while ($customers_statuses = olc_db_fetch_array($customers_statuses_query))
	{
		//$i=$customers_statuses['customers_status_id'];
		$customers_statuses_array[] = array(
		'id' => $customers_statuses['customers_status_id'],
		'text' => $customers_statuses['customers_status_name'],
		'csa_public' => $customers_statuses['customers_status_public'],
		'csa_show_price' => $customers_statuses['customers_status_show_price'],
		'csa_show_price_tax' => $customers_statuses['customers_status_show_price_tax'],
		'csa_image' => $customers_statuses['customers_status_image'],
		'csa_discount' => $customers_statuses['customers_status_discount'],
		'csa_ot_discount_flag' => $customers_statuses['customers_status_ot_discount_flag'],
		'csa_ot_discount' => $customers_statuses['customers_status_ot_discount'],
		'csa_graduated_prices' => $customers_statuses['customers_status_graduated_prices'],
		'csa_cod_permission' => $customers_statuses['customers_status_cod_permission'],
		'csa_cc_permission' => $customers_statuses['customers_status_cc_permission'],
		'csa_bt_permission' => $customers_statuses['customers_status_bt_permission'],
		);
	}
	return $customers_statuses_array;
}
 ?>