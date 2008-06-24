<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_draw_box_contents.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:21 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(output.php,v 1.3 2002/06/01); www.oscommerce.com
(c) 2003	    nextcommerce (olc_draw_box_contents.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_draw_box_contents($box_contents, $box_shadow_color = BOX_SHADOW, $box_background_color = BOX_BGCOLOR_CONTENTS) {
	$contents = '<table border="0" width="100%" cellspacing="0" cellpadding="1" bgcolor="' . $box_shadow_color . '">' . CR .
	'  <tr>' . CR .
	'    <td><table border="0" width="100%" cellspacing="0" cellpadding="4" bgcolor="' . $box_background_color . '">' . CR .
	'      <tr>' . CR .
	'        <td><img src="images/pixel_trans.gif" border="0" width="100%" height="5"></td>' . CR .
	'      </tr>';

	if (is_array($box_contents)) {
		for ($i=0; $i<sizeof($box_contents); $i++) {
			$contents .= olc_draw_box_content_bullet($box_contents[$i]['title'], $box_contents[$i]['link']);
		}
	} else {
		$contents .= '      <tr>' . CR .
		'        <td class="infoboxText">' . $box_contents . '</td>' . CR .
		'      </tr>' . CR;
	}

	$contents .= '      <tr>' . CR .
	'        <td><img src="images/pixel_trans.gif" border="0" width="100%" height="5"></td>' . CR .
	'      </tr>' . CR .
	'    </table></td>' . CR .
	'  </tr>' . CR .
	'</table>' . CR;

	return $contents;
}
 ?>