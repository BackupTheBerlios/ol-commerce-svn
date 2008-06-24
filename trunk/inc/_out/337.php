<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_currencies_values.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:30 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (olc_get_currencies_values.inc.php,v 1.1 2003/08/213); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/


function olc_get_currencies_values($code) {
	$currency_values = olc_db_query("select * from " . TABLE_CURRENCIES . " where code = '" . $code . APOS);
	$currencie_data=olc_db_fetch_array($currency_values);
	return $currencie_data;
}
?>