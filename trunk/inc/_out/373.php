<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_tax_rate.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:34 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_get_tax_rate.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_get_tax_rate($class_id, $country_id = -1, $zone_id = -1)
{
	if ( ($country_id == -1) && ($zone_id == -1) ) {
		if (isset($_SESSION['customer_id']))
		{
			$country_id = $_SESSION['customer_country_id'];
			$zone_id = $_SESSION['customer_zone_id'];
		} else {
			$country_id = STORE_COUNTRY;
			$zone_id = STORE_ZONE;
		}
	}
	$tax_query = olc_db_query("select sum(tax_rate) as tax_rate from " . TABLE_TAX_RATES . " tr left join " . TABLE_ZONES_TO_GEO_ZONES . " za on (tr.tax_zone_id = za.geo_zone_id) left join " . TABLE_GEO_ZONES . " tz on (tz.geo_zone_id = tr.tax_zone_id) where (za.zone_country_id is null or za.zone_country_id = '0' or za.zone_country_id = '" . $country_id . "') and (za.zone_id is null or za.zone_id = '0' or za.zone_id = '" . $zone_id . "') and tr.tax_class_id = '" . $class_id . "' group by tr.tax_priority");
	if (olc_db_num_rows($tax_query))
	{
		$tax_multiplier = 1.0;
		while ($tax = olc_db_fetch_array($tax_query)) {
			$tax_multiplier *= 1.0 + ($tax['tax_rate'] / 100);
		}
		return ($tax_multiplier - 1.0) * 100;
	} else {
		return 0;
	}
}
 ?>