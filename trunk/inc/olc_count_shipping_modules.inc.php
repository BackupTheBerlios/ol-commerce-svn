<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_count_shipping_modules.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:13 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
   (c) 2003	    nextcommerce (olc_count_shipping_modules.inc.php,v 1.5 2003/08/13); www.nextcommerce.org  
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
  // include needed functions
  require_once(DIR_FS_INC.'olc_count_modules.inc.php');
  function olc_count_shipping_modules() {
    return olc_count_modules(MODULE_SHIPPING_INSTALLED);
  }
 ?>
