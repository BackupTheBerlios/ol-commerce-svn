<?php
/*
  $Id: general.func.php,v 1.1.1.1.2.1 2007/04/08 07:18:09 gswkaiser Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  DevosC, Developing open source Code
  http://www.devosc.com

  Copyright (c) 2003 osCommerce
  Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

  Released under the GNU General Public License
*/

  function paypal_include_lng($base_dir, $lng_dir, $lng_file) {
    if(file_exists($base_dir . $lng_dir . '/' . $lng_file)) {
      include_once($base_dir . $lng_dir . '/' . $lng_file);
    } elseif (file_exists($base_dir . 'english/' . $lng_file)) {
      include_once($base_dir . 'english/' . $lng_file);
    }
  }

  function paypal_payment_status($order_id) {
    include_once(PAYPAL_IPN_DIR.'inc.php');
     $paypal_payment_status_query = olc_db_query("select p.payment_status from " . TABLE_PAYPAL . " p left join " . TABLE_ORDERS . " o on p.paypal_id = o.payment_id where o.orders_id ='" . (int)$order_id . APOS);
     $paypal_payment_status = olc_db_fetch_array($paypal_payment_status_query);
     //quick work around for unkown order status id
     return $paypal_payment_status_value = (olc_not_null($paypal_payment_status['payment_status'])) ? $paypal_payment_status['payment_status'] : '';
  }	

  function paypal_remove_order($order_id) {
    include_once(PAYPAL_IPN_DIR.'inc.php');
    $ipn_query = olc_db_query("select payment_id from " . TABLE_ORDERS . " where orders_id = '" . (int)$order_id . APOS);
    if (olc_db_num_rows($ipn_query)) { // this is a ipn order (PayPal or StormPay)
      $ipn_order = olc_db_fetch_array($ipn_query);
      $paypal_id = $ipn_order['payment_id'];
      $txn_query = olc_db_query("select txn_id from " . TABLE_PAYPAL . " where paypal_id ='" . (int)$paypal_id . APOS);
      $txn = olc_db_fetch_array($txn_query);
      olc_db_query(DELETE_FROM . TABLE_PAYPAL . " where paypal_id = '" . (int)$paypal_id . APOS);
      olc_db_query(DELETE_FROM . TABLE_PAYPAL . " where parent_txn_id = '" . olc_db_input($txn['txn_id']) . APOS);
      if (defined('TABLE_PAYPAL_AUCTION')) olc_db_query(DELETE_FROM . TABLE_PAYPAL_AUCTION . " where paypal_id = '" . (int)$paypal_id . APOS);

    }
    olc_db_query(DELETE_FROM . TABLE_ORDERS_SESSION_INFO . " where orders_id = '" . (int)$order_id . APOS);
  }

?>
