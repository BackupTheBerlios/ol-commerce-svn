<?php
/*
  $Id: ot_handling.php,v 1.1.1.1.2.1 2007/04/08 07:18:04 gswkaiser Exp $
MODULE ... should go here:
catalog/includes/modules/order_total/ot_handling.php

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Based on:
  (c)osCommerce
  (c) Manfred Tomanik

  Released under the GNU General Public License
*/

  class ot_handling {
    var $title, $output;

    function ot_handling() {
      $this->code = 'ot_handling';
      $this->title = MODULE_ORDER_TOTAL_HANDLING_TITLE;
      $this->description = MODULE_ORDER_TOTAL_HANDLING_DESCRIPTION;
      $this->enabled = ((strtolower(MODULE_ORDER_TOTAL_HANDLING_STATUS) == TRUE_STRING_S) ? true : false);
      $this->sort_order = MODULE_ORDER_TOTAL_HANDLING_SORT_ORDER;

      $this->output = array();
    }

    function process() {
      global $order, $currencies, $customer_id;

//      if (MODULE_ORDER_TOTAL_HANDLING_HANDLING == TRUE_STRING_S) {

$freequery = olc_db_query("SELECT SUM(cb.customers_basket_quantity) AS total FROM " . TABLE_CUSTOMERS_BASKET . " cb LEFT JOIN " . TABLE_PRODUCTS . " p ON cb.products_id = p.products_id WHERE cb.customers_id =  '" . $customer_id . "' AND cb.final_price <  '0.01' AND p.products_price <  '0.01'");
$freestuff = olc_db_fetch_array($freequery);
$freeitems = $freestuff['total'];
 
$handlingfree = $order->info['subtotal'] / 100 * 0.85; 


          $tax = olc_get_tax_rate(MODULE_ORDER_TOTAL_HANDLING_TAX_CLASS, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $tax_description = olc_get_tax_description(MODULE_ORDER_TOTAL_HANDLING_TAX_CLASS, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $order->info['tax'] += olc_calculate_tax($handlingfree, $tax);
          $order->info['tax_groups']["$tax_description"] += olc_calculate_tax($handlingfree, $tax);
          $order->info['total'] += $handlingfree + olc_calculate_tax($handlingfree, $tax);



$this->output[] = array('title' => $this->title . ':',
                       'text' => olc_format_price(olc_add_tax($handlingfree, $tax ), true, $order->info['currency'], $order->info['currency_value']),
                       'value' => olc_add_tax($handlingfree, $tax));

    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_HANDLING_STATUS'");
        $this->_check = olc_db_num_rows($check_query);
      }

      return $this->_check;
    }

    function keys() {
      return array('MODULE_ORDER_TOTAL_HANDLING_STATUS', 'MODULE_ORDER_TOTAL_HANDLING_SORT_ORDER', 'MODULE_ORDER_TOTAL_HANDLING_HANDLING', 'MODULE_ORDER_TOTAL_HANDLING_FREE', 'MODULE_ORDER_TOTAL_HANDLING_TAX_CLASS');
    }

    function install() {
      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ( 'MODULE_ORDER_TOTAL_HANDLING_STATUS', 'true',  '6', '1','olc_cfg_select_option(array(\'true\', \'false\'), ', now())");

      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_HANDLING_SORT_ORDER', '36', '6', '2', now())");

      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ( 'MODULE_ORDER_TOTAL_HANDLING_HANDLING', 'false',  '6', '3', 'olc_cfg_select_option(array(\'true\', \'false\'), ', now())");

      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value, configuration_group_id, sort_order, use_function, date_added) values ('MODULE_ORDER_TOTAL_HANDLING_FREE', '0.50', '6', '5', 'currencies->format', now())");

      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_ORDER_TOTAL_HANDLING_TAX_CLASS', '0',  '6', '7', 'olc_get_tax_class_title', 'olc_cfg_pull_down_tax_classes(', now())");
    }

    function remove() {
      olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }
?>
