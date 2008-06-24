<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_write_user_info.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:42 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
   (c) 2003	    nextcommerce (olc_write_user_info.inc.php,v 1.4 2003/08/13); www.nextcommerce.org 
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  function olc_write_user_info($customer_id, $user_info) {
//    global $customer_id, $user_info;                                                                                                                                             customers_id,           customers_ip,               customers_ip_date,  customers_host,                      customers_advertiser,                customers_referer_url
    olc_db_query(INSERT_INTO . TABLE_CUSTOMERS_IP . " (customers_id, customers_ip, customers_ip_date, customers_host, customers_advertiser, customers_referer_url) values ('" . $customer_id . "', '" . $user_info['user_ip'] . "', now(), '" . $user_info['user_host'] . "', '" . $user_info['advertiser'] . "',  '" . $user_info['referer_url'] . "')");
    return -1;
  }
?>