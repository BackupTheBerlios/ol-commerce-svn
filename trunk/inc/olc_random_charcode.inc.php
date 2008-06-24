<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_random_charcode.inc.php 899 2005-04-29 02:40:57Z hhgag $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:

Copyright (c) 2004 XT-Commerce
-----------------------------------------------------------------------------------------
by Guido Winger for XT:Commerce

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// build to generate a random charcode
function olc_random_charcode($length) {
	$arraysize = 34;
	$chars = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9');

	$code = '';
	for ($i = 1; $i <= $length; $i++) {
		$j = floor(olc_rand(0,$arraysize));
		$code .= $chars[$j];
	}
	return  $code;
}
?>