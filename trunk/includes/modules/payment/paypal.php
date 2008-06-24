<?php
/* -----------------------------------------------------------------------------------------
$Id: paypal.php,v 1.1.1.1.2.1 2007/04/08 07:18:06 gswkaiser Exp $
OL-Commerce Version 1.0
http://www.ol-commerce.com
Copyright (c) 2004 OL-Commerce 
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(paypal.php,v 1.39 2003/01/29); www.oscommerce.com
(c) 2003	    nextcommerce (paypal.php,v 1.8 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

class paypal
{
	var $code, $title, $description, $enabled;

	function paypal()
	{
		global $order;
		$this->code = 'paypal';
		$this->title = MODULE_PAYMENT_PAYPAL_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_PAYPAL_SORT_ORDER;
		$this->enabled = ((strtolower(MODULE_PAYMENT_PAYPAL_STATUS) == TRUE_STRING_S) ? true : false);
		if ((int)MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID;
		}
		if (is_object($order)) $this->update_status();
		if (MODULE_PAYMENT_PAYPAL_TEST_MODE==TRUE_STRING_S)
		{
			$dir='sandbox.';
		}
		else
		{
			$dir=EMPTY_STRING;
		}
		$this->form_action_url = 'https://www.'.$dir.'paypal.com/de/cgi-bin/webscr';
		$this->response_wait=false;
	}

	function update_status() {
		global $order;
		if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_PAYPAL_ZONE > 0) ) {
			$check_flag = false;
			$check_query = olc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES .
			" where geo_zone_id = '" . MODULE_PAYMENT_PAYPAL_ZONE . "' and zone_country_id = '" .
			$order->billing['country']['id'] . "' order by zone_id");
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
		if (MODULE_PAYMENT_PAYPAL_CURRENCY == 'Selected Currency') {
			$my_currency = SESSION_CURRENCY;
		} else {
			$my_currency = substr(MODULE_PAYMENT_PAYPAL_CURRENCY, 5);
		}
		if (!in_array($my_currency, array('CAD', 'EUR', 'GBP', 'JPY', 'USD'))) {
			$my_currency = SESSION_CURRENCY;
		}
		$process_button_string = olc_draw_hidden_field('cmd', '_xclick') .
		olc_draw_hidden_field('business', MODULE_PAYMENT_PAYPAL_ID) .
		olc_draw_hidden_field('item_name', STORE_NAME) .
		olc_draw_hidden_field('amount', number_format(($order->info['total'] - $order->info['shipping_cost']) ,
		$currencies->get_decimal_places($my_currency))) .
		olc_draw_hidden_field('shipping', number_format($order->info['shipping_cost'] ,
		$currencies->get_decimal_places($my_currency))) .
		olc_draw_hidden_field('currency_code', $my_currency) .
		olc_draw_hidden_field('return',
			olc_href_link(FILENAME_CHECKOUT_PROCESS, EMPTY_STRING, SSL,true,false,false)) .
		olc_draw_hidden_field('cancel_return',
			olc_href_link(FILENAME_CHECKOUT_PAYMENT, EMPTY_STRING, SSL,true,false,false));
		return $process_button_string;
	}

	function before_process()
	{
		$_SESSION['paypal_payment']=true;
		return false;
	}

	function after_process()
	{
		return false;
	}

	function output_error()
	{
		return false;
	}

	function check()
	{
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION .
			" where configuration_key = 'MODULE_PAYMENT_PAYPAL_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install()
	{
		$sql=INSERT_INTO . TABLE_CONFIGURATION .
		" ( configuration_key, configuration_value,  configuration_group_id, sort_order, ";
		$sql_date_added="date_added) values ('MODULE_PAYMENT_PAYPAL_";
		$sql_use_set_date_added="use_function, set_function, " . $sql_date_added;
		olc_db_query($sql . "set_function, " . $sql_date_added .
		"STATUS', 'true', '6', '1', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		olc_db_query($sql . $sql_date_added . "ALLOWED', '', '6', '2', now())");
		olc_db_query($sql . $sql_date_added . "id', 'you@yourbusiness.com',  '6', '3', now())");
		olc_db_query($sql . "set_function, " . $sql_date_added .
		"CURRENCY', 'Gewählte Währung', '6', '4', 'olc_cfg_select_option(array(\'Gewählte Währung\',\'Nur USD\',\'Nur CAD\',\'Nur EUR\',\'Nur GBP\',\'Nur JPY\'), ', now())");
		olc_db_query($sql . $sql_date_added . "SORT_ORDER', '0', '6', '5', now())");
		olc_db_query($sql . $sql_use_set_date_added .
		"ZONE', '0', '6', '6', 'olc_get_zone_class_title', 'olc_cfg_pull_down_zone_classes(', now())");
		olc_db_query($sql . $sql_use_set_date_added .
		"ORDER_STATUS_ID', '0',  '6', '7', 'olc_get_order_status_name', 'olc_cfg_pull_down_order_statuses(', now())");
		olc_db_query($sql . "set_function, " . $sql_date_added .
		"TEST_MODE', 'true', '6', '8', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}

	function keys() {
		return array('MODULE_PAYMENT_PAYPAL_STATUS','MODULE_PAYMENT_PAYPAL_ALLOWED', 'MODULE_PAYMENT_PAYPAL_ID', 'MODULE_PAYMENT_PAYPAL_CURRENCY', 'MODULE_PAYMENT_PAYPAL_ZONE', 'MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID', 'MODULE_PAYMENT_PAYPAL_SORT_ORDER','MODULE_PAYMENT_PAYPAL_TEST_MODE');
	}
}
?>