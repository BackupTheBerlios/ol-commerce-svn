<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_draw_box_heading.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:21 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(output.php,v 1.3 2002/06/01); www.oscommerce.com
(c) 2003	    nextcommerce (olc_draw_box_heading.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_draw_box_heading($heading_title, $left_corner = false, $right_corner = false) {
	$heading = '<table cellspacing="0" cellpadding="0" width="100%" border="0">' . CR .
	'  <tr valign="middle" bgcolor="' . BOX_BGCOLOR_HEADING . '">' . CR .
	'    <td>';
	if ($left_corner) {
		$heading .= '<img src="images/main_page/box_corner_left.gif" border="0">';
	} else {
		$heading .= '<img src="images/main_page/box_corner_right_left.gif" border="0">';
	}

	$heading .= '</td>' . CR .
	'    <td width="100%" height="14" class="infoBoxHeading">' . $heading_title . '</td>' . CR;

	if ($right_corner) {
		$heading .= '    <td height="14" class="infoBoxHeading"><img src="images/main_page/box_corner_right.gif" border="0"></td>' . CR;
	}

	$heading .= '  </tr>' . CR .
	'</table>' . CR;

	return $heading;
}
 ?>