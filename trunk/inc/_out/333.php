<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_countries.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:29 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_get_countries.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_get_countries($countries_id = '', $with_iso_codes = false)
{
	$countries_id_text='countries_id';
	$countries_name_text='countries_name';
	$select="select countries_name";
	$select_countries_id=$select.", ".$countries_id_text;
	$from=" from " . TABLE_COUNTRIES;
	$countries_array = array();
	if (olc_not_null($countries_id))
	{
		$where=$from ." where countries_id = '" . $countries_id . APOS;
		if ($with_iso_codes)
		{
			$countries_iso_code_text='countries_iso_code_';
			$countries_iso_code_2_text=$countries_iso_code_text.'2';
			$countries_iso_code_3_text=$countries_iso_code_text.'3';
			$countries = olc_db_query($select_countries_id.", ".$countries_iso_code_2_text.$where);
			$countries_values = olc_db_fetch_array($countries);
			$countries_array = array(
			$countries_name_text => $countries_values[$countries_name_text],
			$countries_iso_code_2_text => $countries_values[$countries_iso_code_2_text],
			$countries_iso_code_3_text => $countries_values[$countries_iso_code_3_text]);
		}
		else
		{
			$countries = olc_db_query($select . $where);
			$countries_values = olc_db_fetch_array($countries);
			$countries_array = array($countries_name_text => $countries_values[$countries_name_text]);
		}
	}
	else
	{
		$countries = olc_db_query($select_countries_id. $from. " order by ".$countries_name_text);
		while ($countries_values = olc_db_fetch_array($countries))
		{
			$countries_array[] = array(
			$countries_id_text => $countries_values[$countries_id_text],
			$countries_name_text => $countries_values[$countries_name_text]);
		}
	}
	return $countries_array;
}
?>