<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_country_list.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:29 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
(c) 2003	    nextcommerce (olc_get_country_list.inc.php,v 1.5 2003/08/20); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// include needed functions
include_once(DIR_FS_INC.'olc_draw_pull_down_menu.inc.php');
if (!function_exists('olc_get_countries'))
{
	require_once(DIR_FS_INC.'olc_get_countries.inc.php');
}

function olc_get_country_list($name, $selected = '', $parameters = '') {
	//    $countries_array = array(array('id' => '', 'text' => PULL_DOWN_DEFAULT));
	//    Probleme mit register_globals=off -> erstmal nur auskommentiert. Kann u.U. gelöscht werden.
	$countries = olc_get_countries();
	$countries_array=array();
	for ($i=0, $n=sizeof($countries); $i<$n; $i++) {
		$countries_array[] = array('id' => $countries[$i]['countries_id'], 'text' => $countries[$i]['countries_name']);
	}

	return olc_draw_pull_down_menu($name, $countries_array, $selected, $parameters);
}
 ?>