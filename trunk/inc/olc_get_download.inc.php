<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_get_download.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:30 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   by Mario Zanier <webmaster@zanier.at>
   based on:
   (c) 2003	    nextcommerce (olc_get_download.inc.php,v 1.4 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// safe download function, file get renamed bevor sending to browser!!
function olc_get_download($content_id) {
	
	$content_query=olc_db_query("SELECT
					content_file,
					content_read
					FROM ".TABLE_PRODUCTS_CONTENT."
					WHERE content_id='".$content_id.APOS);
					
	$content_data=olc_db_fetch_array($content_query);
	// update file counter
	
	olc_db_query("SQL_UPDATE 
			".TABLE_PRODUCTS_CONTENT." 
			SET content_read='".($content_data['content_read']+1)."'
			WHERE content_id='".$content_id.APOS);
	
	// original filename
	$filename = DIR_FS_CATALOG.'media/products/'.$content_data['content_file'];
	$backup_filename = DIR_FS_CATALOG.'media/products/backup/'.$content_data['content_file'];
	// create md5 hash id from original file
	$orign_hash_id=md5_file($filename);
	
	clearstatcache();
	
	// create new filename with timestamp
	$timestamp=str_replace('.','',microtime());
        $timestamp=str_replace(BLANK,'',$timestamp);
        $new_filename=DIR_FS_CATALOG.'media/products/'.$timestamp.strstr($content_data['content_file'],'.');
        
        // rename file
        rename($filename,$new_filename);
  	
	
	if (file_exists($new_filename)) {
		
	
	header("Content-type: application/force-download");
	header("Content-Disposition: attachment; filename=".$new_filename);
	@readfile($new_filename);	
	// rename file to original name
	rename($new_filename,$filename);
	$new_hash_id=md5_file($filename);
	clearstatcache();	
	
	// check hash id of file again, if not same, get backup!
	if ($new_hash_id!=$orign_hash_id) copy($backup_filename,$filename);
	}
	
	
}
?>