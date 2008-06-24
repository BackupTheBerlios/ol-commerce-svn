<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_format_filesize.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:28 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	    nextcommerce (olc_format_filesize.inc.php,v 1.1 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// returns human readeable filesize :)

function olc_format_filesize($size) {
	$a = array("B","KB","MB","GB","TB","PB");
	$pos = 0;
	while ($size >= 1024)
	{
		$size /= 1024;
		$pos++;
	}
	return round($size,2).BLANK.$a[$pos];
}

?>