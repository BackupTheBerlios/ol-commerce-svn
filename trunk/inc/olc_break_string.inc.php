<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_break_string.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:09 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_break_string.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_break_string($string, $len, $break_char = '-') {
	$l = 0;
	$output = EMPTY_STRING;
	for ($i=0, $n=strlen($string); $i<$n; $i++) {
		$char = substr($string, $i, 1);
		if ($char != BLANK)
		{
			$l++;
		} else {
			$l = 0;
		}
		if ($l > $len)
		{
			$l = 1;
			$output .= $break_char;
		}
		$output .= $char;
	}
	return $output;
}
?>