<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_random_name.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:39 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   by Mario Zanier for XTcommerce
   
   based on:
   (c) 2003	    nextcommerce (olc_random_name.inc.php,v 1.1 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  // Returns a random name, 16 to 20 characters long
  // There are more than 10^28 combinations
  // The directory is "hidden", i.e. starts with '.'
  function olc_random_name() {
    $letters = 'abcdefghijklmnopqrstuvwxyz';
    $dirname = '.';
    $length = floor(olc_rand(16,20));
    for ($i = 1; $i <= $length; $i++) {
     $q = floor(olc_rand(1,26));
     $dirname .= $letters[$q];
    }
    return $dirname;
  }
 ?>