<?php
/* --------------------------------------------------------------
 $Id: object_info.php,v 1.1.1.1.2.1 2007/04/08 07:17:47 gswkaiser Exp $   

 OL-Commerce Version 5.x/AJAX
 http://www.ol-commerce.com, http://www.seifenparadies.de

 Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
 --------------------------------------------------------------
 based on: 
 (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 (c) 2002-2003 osCommerce(object_info.php,v 1.5 2002/01/30); www.oscommerce.com 
 (c) 2003	    nextcommerce (object_info.php,v 1.5 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

  Released under the GNU General Public License 
 --------------------------------------------------------------*/

class objectInfo {

  // class constructor
  function objectInfo($object_array) {
    reset($object_array);
    while (list($key, $value) = each($object_array)) {
      $this->$key = olc_db_prepare_input($value);
    }
  }
}
?>