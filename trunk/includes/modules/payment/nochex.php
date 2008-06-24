<?php
/* -----------------------------------------------------------------------------------------
$Id: nochex.php,v 1.1.1.1.2.1 2007/04/08 07:18:06 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(nochex.php,v 1.12 2003/01/29); www.oscommerce.com
(c) 2003	    nextcommerce (nochex.php,v 1.8 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/


class nochex {
	var $code, $title, $description, $enabled;


	function nochex() {
		global $order;

		$this->code = 'nochex';
		$this->title = MODULE_PAYMENT_NOCHEX_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_NOCHEX_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_NOCHEX_SORT_ORDER;
		$this->enabled = ((strtolower(MODULE_PAYMENT_NOCHEX_STATUS) == TRUE_STRING_S) ? true : false);

		if ((int)MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID;
		}

		if (is_object($order)) $this->update_status();

		$this->form_action_url = 'https://www.nochex.com/nochex.dll/checkout';
	}


	function update_status() {
		global $order;

		if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_NOCHEX_ZONE > 0) ) {
			$check_flag = false;
			$check_query = olc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_NOCHEX_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
			while ($check = olc_db_fetch_array($check_query)) {
				if ($check['zone_id'] < 1) {
					$check_flag = true;
					break;
				} elseif ($check['zone_id'] == $order->billing['zone_id']) {
					$check_flag = true;
					break;
				}
			}

			if ($check_flag == false) {
				$this->enabled = false;
			}
		}
	}

	function javascript_validation() {
		return false;
	}

	function selection() {
		return array('id' => $this->code,
		'module' => $this->title);
	}

	function pre_confirmation_check() {
		return false;
	}

	function confirmation() {
		return false;
	}

	function process_button() {
		global $order, $currencies;

		$process_button_string = olc_draw_hidden_field('cmd', '_xclick') .
		olc_draw_hidden_field('email', MODULE_PAYMENT_NOCHEX_ID) .
		olc_draw_hidden_field('amount', number_format($order->info['total'] * $currencies->currencies['GBP']['value'], $currencies->currencies['GBP']['decimal_places'])) .
		olc_draw_hidden_field('ordernumber', $_SESSION['customer_id'] . '-' . date('Ymdhis')) .
		olc_draw_hidden_field('returnurl', olc_href_link(FILENAME_CHECKOUT_PROCESS, '', SSL)) .
		olc_draw_hidden_field('cancel_return', olc_href_link(FILENAME_CHECKOUT_PAYMENT, '', SSL));

		return $process_button_string;
	}

	function before_process() {
		return false;
	}

	function after_process() {
		return false;
	}

	function output_error() {
		return false;
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_NOCHEX_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_NOCHEX_STATUS', 'true', '6', '3', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOCHEX_ALLOWED', '', '6', '0', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOCHEX_ID', 'you@yourbuisness.com', '6', '4', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOCHEX_SORT_ORDER', '0', '6', '0', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_NOCHEX_ZONE', '0',  '6', '2', 'olc_get_zone_class_title', 'olc_cfg_pull_down_zone_classes(', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID', '0', '6', '0', 'olc_cfg_pull_down_order_statuses(', 'olc_get_order_status_name', now())");
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}

	function keys() {
		return array('MODULE_PAYMENT_NOCHEX_STATUS','MODULE_PAYMENT_NOCHEX_ALLOWED', 'MODULE_PAYMENT_NOCHEX_ID', 'MODULE_PAYMENT_NOCHEX_ZONE', 'MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID', 'MODULE_PAYMENT_NOCHEX_SORT_ORDER');
	}
}
?>
