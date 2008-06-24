<?php
/*
$Id: ot_payment.php,v 1.1.1.1.2.1 2007/04/08 07:18:04 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2002 osCommerce

Released under the GNU General Public License

based on:
(c) 2002 osCommerce 
(c) Manfred Tomanik OL-Commerce ; www.ol-commerce.de

*/

include_once(DIR_FS_INC.'olc_precision.inc.php');
class ot_payment {
  var $title, $output;

  function ot_payment() {
    $this->code = 'ot_payment';
    $this->title = MODULE_ORDER_TOTAL_PAYMENT_DISC_TITLE;
    $this->description = MODULE_ORDER_TOTAL_PAYMENT_DISC_DESCRIPTION;
    $this->enabled = MODULE_ORDER_TOTAL_PAYMENT_DISC_STATUS;
    $this->sort_order = MODULE_ORDER_TOTAL_PAYMENT_DISC_SORT_ORDER;
    $this->include_shipping = MODULE_ORDER_TOTAL_PAYMENT_DISC_INC_SHIPPING;
    $this->include_tax = MODULE_ORDER_TOTAL_PAYMENT_DISC_INC_TAX;
    $this->percentage = MODULE_ORDER_TOTAL_PAYMENT_DISC_PERCENTAGE;
    $this->minimum = MODULE_ORDER_TOTAL_PAYMENT_DISC_MINIMUM;
    $this->calculate_tax = MODULE_ORDER_TOTAL_PAYMENT_DISC_CALC_TAX;
//      $this->credit_class = true;
    $this->output = array();
  }

  function process() {
   global $order, $currencies;

    $od_amount = $this->calculate_credit($this->get_order_total());
    if ($od_amount>0) {
    $this->deduction = $od_amount;
    $this->output[] = array('title' => $this->title . ':',
                            'text' => olc_format_price($currencies->format($od_amount),1,false),
                            'value' => $od_amount);
  $order->info['total'] = $order->info['total'] - $od_amount;  
}
  }
  

function calculate_credit($amount) {
  global $order, $customer_id, $payment;
  $od_amount=0;
  $od_pc = $this->percentage;
  $do = false;
  if ($amount > $this->minimum) {
  $table = split("[,]" , MODULE_ORDER_TOTAL_PAYMENT_DISC_TYPE);
  for ($i = 0; $i < count($table); $i++) {
        if ($payment == $table[$i]) $do = true;
      }
  if ($do) {
// Calculate tax reduction if necessary
  if($this->calculate_tax == TRUE_STRING_S) {
// Calculate main tax reduction
    $tod_amount = olc_precision($order->info['tax']*10)/10*$od_pc/100;
    $order->info['tax'] = $order->info['tax'] - $tod_amount;
// Calculate tax group deductions
    reset($order->info['tax_groups']);
    while (list($key, $value) = each($order->info['tax_groups'])) {
      $god_amount = olc_precision($value*10)/10*$od_pc/100;
      $order->info['tax_groups'][$key] = $order->info['tax_groups'][$key] - $god_amount;
    }  
  }
  $od_amount = olc_precision($amount*10)/10*$od_pc/100;
  $od_amount = $od_amount + $tod_amount;
  }
  }
  return $od_amount;
}

 
function get_order_total() {
  global  $order, $cart;
  $order_total = $order->info['total'];
// Check if gift voucher is in cart and adjust total
  $products = $cart->get_products();
  for ($i=0; $i<sizeof($products); $i++) {
    $t_prid = olc_get_prid($products[$i]['id']);
    $gv_query = olc_db_query("select products_price, products_tax_class_id, products_model from " . TABLE_PRODUCTS . " where products_id = '" . $t_prid . APOS);
    $gv_result = olc_db_fetch_array($gv_query);
    if (ereg('^GIFT', addslashes($gv_result['products_model']))) { 
      $qty = $cart->get_quantity($t_prid);
      $products_tax = olc_get_tax_rate($gv_result['products_tax_class_id']);
      if ($this->include_tax ==FALSE_STRING_S) {
         $gv_amount = $gv_result['products_price'] * $qty;
      } else {
        $gv_amount = ($gv_result['products_price'] + olc_calculate_tax($gv_result['products_price'],$products_tax)) * $qty;
      }
      $order_total=$order_total - $gv_amount;
    }
  }
  if ($this->include_tax == FALSE_STRING_S) $order_total=$order_total-$order->info['tax'];
  if ($this->include_shipping == FALSE_STRING_S) $order_total=$order_total-$order->info['shipping_cost'];
  return $order_total;
}  

  
  function check() {
    if (!isset($this->check)) {
      $check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_PAYMENT_DISC_STATUS'");
      $this->check = olc_db_num_rows($check_query);
    }

    return $this->check;
  }



  function keys() {
    return array('MODULE_ORDER_TOTAL_PAYMENT_DISC_STATUS', 'MODULE_ORDER_TOTAL_PAYMENT_DISC_SORT_ORDER','MODULE_ORDER_TOTAL_PAYMENT_DISC_PERCENTAGE','MODULE_ORDER_TOTAL_PAYMENT_DISC_MINIMUM', 'MODULE_ORDER_TOTAL_PAYMENT_DISC_TYPE', 'MODULE_ORDER_TOTAL_PAYMENT_DISC_INC_SHIPPING', 'MODULE_ORDER_TOTAL_PAYMENT_DISC_INC_TAX', 'MODULE_ORDER_TOTAL_PAYMENT_DISC_CALC_TAX');
  }

  function install() {
    olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_PAYMENT_DISC_STATUS', 'true',  '6', '1','olc_cfg_select_option(array(\'true\', \'false\'), ', now())");

    olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_PAYMENT_DISC_SORT_ORDER', '999',  '6', '2', now())");

    olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ( 'MODULE_ORDER_TOTAL_PAYMENT_DISC_INC_SHIPPING', 'true',  '6', '5', 'olc_cfg_select_option(array(\'true\', \'false\'), ', now())");

    olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ( 'MODULE_ORDER_TOTAL_PAYMENT_DISC_INC_TAX', 'true',  '6', '6','olc_cfg_select_option(array(\'true\', \'false\'), ', now())");

    olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_PAYMENT_DISC_PERCENTAGE', '2',  '6', '7', now())");

    olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('MODULE_ORDER_TOTAL_PAYMENT_DISC_CALC_TAX', 'false',  '6', '5','olc_cfg_select_option(array(\'true\', \'false\'), ', now())");

    olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_PAYMENT_DISC_MINIMUM', '100', '6', '2', now())");

    olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_PAYMENT_DISC_TYPE', 'cod',  '6', '2', now())");

  }

  function remove() {
    $keys = '';
    $keys_array = $this->keys();
    for ($i=0; $i<sizeof($keys_array); $i++) {
      $keys .= APOS . $keys_array[$i] . "',";
    }
    $keys = substr($keys, 0, -1);

    olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in (" . $keys . RPAREN);
  }
}
?>