<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_gv_account_update.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:35 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_top.php,v 1.273 2003/05/19); www.oscommerce.com
   (c) 2003     nextcommerce (application_top.php,v 1.54 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

   // Update the Customers GV account
  function olc_gv_account_update($customer_id, $gv_id) {
    $customer_gv_query = olc_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $customer_id . APOS);
    $coupon_gv_query = olc_db_query("select coupon_amount from " . TABLE_COUPONS . " where coupon_id = '" . $gv_id . APOS);
    $coupon_gv = olc_db_fetch_array($coupon_gv_query);
    if (olc_db_num_rows($customer_gv_query) > 0) {
      $customer_gv = olc_db_fetch_array($customer_gv_query);
      $new_gv_amount = $customer_gv['amount'] + $coupon_gv['coupon_amount'];
   // new code bugfix
   $gv_query = olc_db_query(SQL_UPDATE . TABLE_COUPON_GV_CUSTOMER . " set amount = '" . $new_gv_amount . "' where customer_id = '" . $customer_id . APOS);
     // original code $gv_query = olc_db_query(SQL_UPDATE . TABLE_COUPON_GV_CUSTOMER . " set amount = '" . $new_gv_amount . APOS);
    } else {
      $gv_query = olc_db_query(INSERT_INTO . TABLE_COUPON_GV_CUSTOMER . " (customer_id, amount) values ('" . $customer_id . "', '" . $coupon_gv['coupon_amount'] . "')");
    }
  }

   ?>