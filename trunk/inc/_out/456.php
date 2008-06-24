<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_address_label.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:09 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_address_label.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
// include needed functions
require_once(DIR_FS_INC.'olc_get_address_format_id.inc.php');
require_once(DIR_FS_INC.'olc_address_format.inc.php');
function olc_address_label($customers_id, $address_id = 1, $html = false, $boln = '', $eoln = NEW_LINE) {
	$address_query = olc_db_query("
		select
		entry_firstname as firstname,
		entry_lastname as lastname,
		entry_company as company,
		entry_street_address as street_address,
		entry_suburb as suburb,
		entry_city as city,
		entry_postcode as postcode,
		entry_state as state,
		entry_zone_id as zone_id,
		entry_country_id as country_id
		from " . TABLE_ADDRESS_BOOK . "
		where customers_id = '" . $customers_id . "' and address_book_id = '" . $address_id . APOS);
	$address = olc_db_fetch_array($address_query);
	$format_id = olc_get_address_format_id($address['country_id']);

	return olc_address_format($format_id, $address, $html, $boln, $eoln);
}
 ?>
