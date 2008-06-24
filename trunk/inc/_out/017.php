<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_activate_banners.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:09 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com
(c) 2003	    nextcommerce (olc_activate_banners.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// Auto activate banners
function olc_activate_banners() {
	$banners_query = olc_db_query("select banners_id, date_scheduled from " . TABLE_BANNERS . " where date_scheduled != ''");
	if (olc_db_num_rows($banners_query)) {
		while ($banners = olc_db_fetch_array($banners_query)) {
			if (date('Y-m-d H:i:s') >= $banners['date_scheduled']) {
				olc_set_banner_status($banners['banners_id'], '1');
			}
		}
	}
}
 ?>