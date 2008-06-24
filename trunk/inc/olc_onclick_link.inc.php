<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_onclick_link.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// The HTML omclick link wrapper function
//W. Kaiser - AJAX
function olc_onclick_link($page = '', $parameters = '', $connection = NONSSL, $add_session_id = true,
$search_engine_safe = true, $create_ajax_link = true)
{
	global $make_onclick_link;

	$make_onclick_link=true;
	return olc_href_link($page, $parameters, $connection, $add_session_id, $search_engine_safe, $create_ajax_link);
}
?>