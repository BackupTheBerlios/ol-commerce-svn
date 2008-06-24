<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_create_sort_heading.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:17 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
   (c) 2003	    nextcommerce (olc_create_sort_heading.inc.php,v 1.3 2003/08/13); www.nextcommerce.org 
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// Return table heading with sorting capabilities
  function olc_create_sort_heading($sortby, $colnum, $heading) {

    $sort_prefix = '';
    $sort_suffix = '';

    if ($sortby) {
      $sort_prefix = HTML_A_START . olc_href_link(CURRENT_SCRIPT, olc_get_all_get_params(array('page', 'info', 'sort')) . 'page=1&sort=' . $colnum . ($sortby == $colnum . 'a' ? 'd' : 'a')) . '" title="' . TEXT_SORT_PRODUCTS . ($sortby == $colnum . 'd' || substr($sortby, 0, 1) != $colnum ? TEXT_ASCENDINGLY : TEXT_DESCENDINGLY) . TEXT_BY . $heading . '" class="productListing-heading">' ;
      $sort_suffix = (substr($sortby, 0, 1) == $colnum ? (substr($sortby, 1, 1) == 'a' ? '+' : '-') : '') . HTML_A_END;
    }

    return $sort_prefix . $heading . $sort_suffix;
  }
 ?>
