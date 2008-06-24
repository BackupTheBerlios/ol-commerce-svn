<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_cache_manufacturers_box.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:10 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cache.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	    nextcommerce (olc_cache_manufacturers_box.inc.php,v 1.3 2003/08/13); www.nextcommerce.org 
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
//! Cache the manufacturers box
// Cache the manufacturers box
  function olc_cache_manufacturers_box($auto_expire = false, $refresh = false) {

    if (($refresh == true) || !read_cache($cache_output, 'manufacturers_box-' . SESSION_LANGUAGE . '.cache' . $_GET['manufacturers_id'], $auto_expire)) {
      ob_start();
      include(box_code_script_path('manufacturers.php'));
      $cache_output = ob_get_contents();
      ob_end_clean();
      write_cache($cache_output, 'manufacturers_box-' . SESSION_LANGUAGE . '.cache' . $_GET['manufacturers_id']);
    }

    return $cache_output;
  }
 ?>