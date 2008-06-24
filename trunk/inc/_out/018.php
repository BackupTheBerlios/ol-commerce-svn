<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_address_format.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:09 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_address_format.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//require_once(DIR_FS_INC.'olc_get_zone_code.inc.php');
require_once(DIR_FS_INC.'olc_get_zone_name.inc.php');
require_once(DIR_FS_INC.'olc_get_country_name.inc.php');

function olc_address_format($address_format_id, $address, $html, $boln, $eoln)
{
	$address_format_query = olc_db_query("select address_format as format from " . TABLE_ADDRESS_FORMAT .
	" where address_format_id = '" . $address_format_id . APOS);
	$address_format = olc_db_fetch_array($address_format_query);

	$company = addslashes($address['company']);
	$firstname = addslashes($address['firstname']);
	$lastname = addslashes($address['lastname']);
	$street = addslashes($address['street_address']);
	$suburb = addslashes($address['suburb']);
	$city = addslashes($address['city']);
	$state = addslashes($address['state']);
	$country_id = $address['country_id'];
	$zone_id = $address['zone_id'];
	$postcode = addslashes($address['postcode']);
	$zip = $postcode;
	$country = olc_get_country_name($country_id);
	//$state = olc_get_zone_code($country_id, $zone_id, $state);
	$state = olc_get_zone_name($country_id, $zone_id, $state);
	if ($html)
	{
		// HTML Mode
		$HR = '<hr/>';
		$hr = '<hr/>';
		if (($boln == EMPTY_STRING) && ($eoln == NEW_LINE) )
		{ // Values not specified, use rational defaults
			$CR = HTML_BR;
			$cr = HTML_BR;
			$eoln = $cr;
		} else { // Use values supplied
			$CR = $eoln . $boln;
			$cr = $CR;
		}
	} else {
		// Text Mode
		$CR = $eoln;
		$cr = $CR;
		$HR = '----------------------------------------';
		$hr = $HR;
	}

	$statecomma = EMPTY_STRING;
	$streets = $street;
	if ($suburb != EMPTY_STRING) $streets = $street . $cr . $suburb;
	if ($firstname == EMPTY_STRING) $firstname = addslashes($address['name']);
	if ($country == EMPTY_STRING) $country = addslashes($address['country']);
	if ($state != EMPTY_STRING) $statecomma = $state . ', ';

	$fmt = $address_format['format'];
	eval("\$address = \"$fmt\";");

	if (ACCOUNT_COMPANY == TRUE_STRING_S)
	{
		if (olc_not_null($company))
		{
			$address = $company . $cr . $address;
		}
	}
	//$address = stripslashes($address);
	return $address;
}
?>
