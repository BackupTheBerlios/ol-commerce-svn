<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_write_cache.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:42 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cache.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	    nextcommerce (olc_write_cache.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  //! Write out serialized data.
  //  write_cache uses serialize() to store $var in $filename.
  //  $var      -  The variable to be written out.
  //  $filename -  The name of the file to write to.
  function write_cache(&$var, $filename) {
    $filename = DIR_FS_CACHE . $filename;
    $success = false;

    // try to open the file
    if ($fp = @fopen($filename, 'w')) {
      // obtain a file lock to stop corruptions occuring
      flock($fp, 2); // LOCK_EX
      // write serialized data
      fputs($fp, serialize($var));
      // release the file lock
      flock($fp, 3); // LOCK_UN
      fclose($fp);
      $success = true;
    }

    return $success;
  }
?>