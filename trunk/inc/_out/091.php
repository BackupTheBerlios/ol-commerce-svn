<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_draw_box_content_bullet.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:21 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(output.php,v 1.3 2002/06/01); www.oscommerce.com
(c) 2003	    nextcommerce (olc_draw_box_content_bullet.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_draw_box_content_bullet($bullet_text, $bullet_link = '') {
	global $page_file;

	$bullet = '      <tr>' . CR .
	'        <td><table border="0" cellspacing="0" cellpadding="0">' . CR .
	'          <tr>' . CR .
	'            <td width="12" class="boxText"><img src="images/icon_pointer.gif" border="0"></td>' . CR .
	'            <td class="infoboxText">';
	if ($bullet_link) {
		if ($bullet_link == $page_file) {
			$bullet .= '<font color="#0033cc"><b>' . $bullet_text . '</b></font>';
		} else {
			$bullet .= HTML_A_START . $bullet_link . '">' . $bullet_text . HTML_A_END;
		}
	} else {
		$bullet .= $bullet_text;
	}

	$bullet .= '</td>' . CR .
	'         </tr>' . CR .
	'       </table></td>' . CR .
	'     </tr>' . CR;

	return $bullet;
}
 ?>