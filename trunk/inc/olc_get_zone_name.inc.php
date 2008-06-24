<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_zone_name.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:35 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_get_zone_name.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_get_zone_name($country_id, $zone_id, $default_zone='')
{
	$zone_query = olc_db_query("select zone_name from " . TABLE_ZONES .
	" where zone_country_id = '" . $country_id .
	"' and zone_id = '" . $zone_id . APOS);
	if (olc_db_num_rows($zone_query))
	{
		$zone = olc_db_fetch_array($zone_query);
		return $zone['zone_name'];
	} else {
		return $default_zone;
	}
}
?>