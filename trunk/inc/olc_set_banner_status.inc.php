<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_set_banner_status.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:40 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	    nextcommerce (olc_set_banner_status.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// Sets the status of a banner
  function olc_set_banner_status($banners_id, $status) {
    if ($status == '1') {
      return olc_db_query(SQL_UPDATE . TABLE_BANNERS . " set status = '1', date_status_change = now(), date_scheduled = NULL where banners_id = '" . $banners_id . APOS);
    } elseif ($status == '0') {
      return olc_db_query(SQL_UPDATE . TABLE_BANNERS . " set status = '0', date_status_change = now() where banners_id = '" . $banners_id . APOS);
    } else {
      return -1;
    }
  }
 ?>