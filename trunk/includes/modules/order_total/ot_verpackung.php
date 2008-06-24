<?php
/* -----------------------------------------------------------------------------------------
  $Id: ot_verpackung.php,v 1.0 2004/11/18 

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_cod_fee.php,v 1.02 2003/02/24); www.oscommerce.com
   (C) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers ; http://www.themedia.at & http://www.oscommerce.at
   (c) 2004 Manfred Tomanik; http://www.ol-commerce.de, http://www.seifenparadies.de


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   

  class ot_verpackung {
    var $title, $output;

    function ot_verpackung() {
      $this->code = 'ot_verpackung';
      $this->title = MODULE_ORDER_TOTAL_VERPACKUNG_TITLE;
      $this->description = MODULE_ORDER_TOTAL_VERPACKUNG_DESCRIPTION;
      $this->enabled = ((strtolower(MODULE_ORDER_TOTAL_VERPACKUNG_STATUS) == TRUE_STRING_S) ? true : false);
      $this->sort_order = MODULE_ORDER_TOTAL_VERPACKUNG_SORT_ORDER;

      $this->output = array();
    }

    function process() {
      global $order, $currencies;

      if (MODULE_ORDER_TOTAL_VERPACKUNG_LOW_ORDER_FEE == TRUE_STRING_S) {
        switch (MODULE_ORDER_TOTAL_VERPACKUNG_DESTINATION) {
          case 'national':
            if ($order->delivery['country_id'] == STORE_COUNTRY) $pass = true; break;
          case 'international':
            if ($order->delivery['country_id'] != STORE_COUNTRY) $pass = true; break;
          case 'both':
            $pass = true; break;
          default:
            $pass = false; break;
        }

        if ( ($pass == true) && ( ($order->info['total'] - $order->info['verpackung_cost']) < MODULE_ORDER_TOTAL_VERPACKUNG_ORDER_UNDER) ) {
          $tax = olc_get_tax_rate(MODULE_ORDER_TOTAL_VERPACKUNG_TAX_CLASS, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $tax_description = olc_get_tax_description(MODULE_ORDER_TOTAL_VERPACKUNG_TAX_CLASS, $order->delivery['country']['id'], $order->delivery['zone_id']);

          $order->info['tax'] += olc_calculate_tax(MODULE_ORDER_TOTAL_VERPACKUNG_FEE, $tax);
          $order->info['tax_groups']["$tax_description"] += olc_calculate_tax(MODULE_ORDER_TOTAL_VERPACKUNG_FEE, $tax);
          $order->info['total'] += MODULE_ORDER_TOTAL_VERPACKUNG_FEE + olc_calculate_tax(MODULE_ORDER_TOTAL_VERPACKUNG_FEE, $tax);

          $this->output[] = array('title' => $this->title . ':',
                                  'text' => $currencies->format(olc_add_tax(MODULE_ORDER_TOTAL_VERPACKUNG_FEE, $tax), true, $order->info['currency'], $order->info['currency_value']),
                                  'value' => olc_add_tax(MODULE_ORDER_TOTAL_VERPACKUNG_FEE, $tax));
        }
      }
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_VERPACKUNG_STATUS'");
        $this->_check = olc_db_num_rows($check_query);
      }

      return $this->_check;
    }

    function keys() {
      return array('MODULE_ORDER_TOTAL_VERPACKUNG_STATUS', 'MODULE_ORDER_TOTAL_VERPACKUNG_SORT_ORDER', 'MODULE_ORDER_TOTAL_VERPACKUNG_LOW_ORDER_FEE', 'MODULE_ORDER_TOTAL_VERPACKUNG_ORDER_UNDER', 'MODULE_ORDER_TOTAL_VERPACKUNG_FEE', 'MODULE_ORDER_TOTAL_VERPACKUNG_DESTINATION', 'MODULE_ORDER_TOTAL_VERPACKUNG_TAX_CLASS');
    }

    function install() {
      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_VERPACKUNG_STATUS', 'true', '6', '1','olc_cfg_select_option(array(\'true\', \'false\'), ', now())");
      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_VERPACKUNG_SORT_ORDER', '36', '6', '2', now())");
      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_VERPACKUNG_LOW_ORDER_FEE', 'false', '6', '3', 'olc_cfg_select_option(array(\'true\', \'false\'), ', now())");
      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, date_added) values ('MODULE_ORDER_TOTAL_VERPACKUNG_ORDER_UNDER', '50','6', '4', 'currencies->format', now())");
      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, date_added) values ('MODULE_ORDER_TOTAL_VERPACKUNG_FEE', '5','6', '5', 'currencies->format', now())");
      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_VERPACKUNG_DESTINATION', 'both','6', '6', 'olc_cfg_select_option(array(\'national\', \'international\', \'both\'), ', now())");
      olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_ORDER_TOTAL_VERPACKUNG_TAX_CLASS', '0','6', '7', 'olc_get_tax_class_title', 'olc_cfg_pull_down_tax_classes(', now())");
    }

    function remove() {
      olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }
?>