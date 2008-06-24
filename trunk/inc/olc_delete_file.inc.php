<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_delete_file.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:20 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   by Mario Zanier <webmaster@zanier.at>
   based on: 
   (c) 2003	    nextcommerce (olc_delete_file.inc.php,v 1.1 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

function olc_delete_file($file){ 
	
	$delete= @unlink($file);
	clearstatcache();
	if (@file_exists($file)) {
		$filesys=eregi_replace("/","\\",$file);
		$delete = @system("del $filesys");
		clearstatcache();
		if (@file_exists($file)) {
			$delete = @chmod($file,0775);
			$delete = @unlink($file);
			$delete = @system("del $filesys");
		}
	}
	clearstatcache();
	if (@file_exists($file)) {
		return false;
	}
	else {
	return true;
} // end function
}
?>