<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_count_customer_orders.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:12 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	    nextcommerce (olc_count_customer_orders.inc.php,v 1.3 2003/08/13); www.nextcommerce.org 
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function olc_count_customer_orders($id = '', $check_session = true) {

    if (is_numeric($id) == false) {
      if (isset($_SESSION['customer_id'])) {
        $id = $_SESSION['customer_id'];
      } else {
        return 0;
      }
    }

    if ($check_session == true) {
      if ( (isset($_SESSION['customer_id']) == false) || ($id != $_SESSION['customer_id']) ) {
        return 0;
      }
    }

    $orders_check_query = olc_db_query("select count(*) as total from " . TABLE_ORDERS . " where customers_id = '" . (int)$id . APOS);
    $orders_check = olc_db_fetch_array($orders_check_query);
    return $orders_check['total'];
  }
 ?>