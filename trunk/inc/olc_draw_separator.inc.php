<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_draw_separator.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:23 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com 
   (c) 2003	    nextcommerce (olc_draw_separator.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// Output a separator either through whitespace, or with an image
  function olc_draw_separator($image = 'pixel_black.gif', $width = '100%', $height = '1') {
    return olc_image(DIR_WS_IMAGES . $image, '', $width, $height);
  }
 ?>