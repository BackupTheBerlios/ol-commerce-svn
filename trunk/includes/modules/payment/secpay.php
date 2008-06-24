<?php
/* -----------------------------------------------------------------------------------------
$Id: secpay.php,v 1.1.1.1.2.1 2007/04/08 07:18:06 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(secpay.php,v 1.31 2003/01/29); www.oscommerce.com
(c) 2003	    nextcommerce (secpay.php,v 1.8 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/


class secpay {
	var $code, $title, $description, $enabled;


	function secpay() {
		global $order;

		$this->code = 'secpay';
		$this->title = MODULE_PAYMENT_SECPAY_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_SECPAY_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_SECPAY_SORT_ORDER;
		$this->enabled = ((strtolower(MODULE_PAYMENT_SECPAY_STATUS) == TRUE_STRING_S) ? true : false);

		if ((int)MODULE_PAYMENT_SECPAY_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_SECPAY_ORDER_STATUS_ID;
		}

		if (is_object($order)) $this->update_status();

		$this->form_action_url = 'https://www.secpay.com/java-bin/ValCard';
	}


	function update_status() {
		global $order;

		if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_SECPAY_ZONE > 0) ) {
			$check_flag = false;
			$check_query = olc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_SECPAY_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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

		switch (MODULE_PAYMENT_SECPAY_CURRENCY) {
			case 'Default Currency':
				$sec_currency = DEFAULT_CURRENCY;
				break;
			case 'Any Currency':
			default:
				$sec_currency = $_SESSION['currency'];
				break;
		}

		switch (MODULE_PAYMENT_SECPAY_TEST_STATUS) {
			case 'Always Fail':
				$test_status = FALSE_STRING_S;
				break;
			case 'Production':
				$test_status = 'live';
				break;
			case 'Always Successful':
			default:
				$test_status = TRUE_STRING_S;
				break;
		}

		$process_button_string = olc_draw_hidden_field('merchant', MODULE_PAYMENT_SECPAY_MERCHANT_ID) .
		olc_draw_hidden_field('trans_id', STORE_NAME . date('Ymdhis')) .
		olc_draw_hidden_field('amount', number_format($order->info['total'] * $currencies->get_value($sec_currency), $currencies->currencies[$sec_currency]['decimal_places'], '.', '')) .
		olc_draw_hidden_field('bill_name', $order->billing['firstname'] . BLANK . $order->billing['lastname']) .
		olc_draw_hidden_field('bill_addr_1', $order->billing['street_address']) .
		olc_draw_hidden_field('bill_addr_2', $order->billing['suburb']) .
		olc_draw_hidden_field('bill_city', $order->billing['city']) .
		olc_draw_hidden_field('bill_state', $order->billing['state']) .
		olc_draw_hidden_field('bill_post_code', $order->billing['postcode']) .
		olc_draw_hidden_field('bill_country', $order->billing['country']['title']) .
		olc_draw_hidden_field('bill_tel', $order->customer['telephone']) .
		olc_draw_hidden_field('bill_email', $order->customer['email_address']) .
		olc_draw_hidden_field('ship_name', $order->delivery['firstname'] . BLANK . $order->delivery['lastname']) .
		olc_draw_hidden_field('ship_addr_1', $order->delivery['street_address']) .
		olc_draw_hidden_field('ship_addr_2', $order->delivery['suburb']) .
		olc_draw_hidden_field('ship_city', $order->delivery['city']) .
		olc_draw_hidden_field('ship_state', $order->delivery['state']) .
		olc_draw_hidden_field('ship_post_code', $order->delivery['postcode']) .
		olc_draw_hidden_field('ship_country', $order->delivery['country']['title']) .
		olc_draw_hidden_field('currency', $sec_currency) .
		olc_draw_hidden_field('callback', olc_href_link(FILENAME_CHECKOUT_PROCESS, '', SSL, false) .
		';' . olc_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error=' . $this->code, SSL, false)) .
		olc_draw_hidden_field(olc_session_name(), olc_session_id()) .
		olc_draw_hidden_field('options', 'test_status=' . $test_status .
		',dups=false,cb_post=true,cb_flds=' . olc_session_name());

		return $process_button_string;
	}

	function before_process()
	{
		if ($_POST['valid'] == TRUE_STRING_S)
		{
			if ($remote_host = getenv('REMOTE_HOST'))
			{
				if ($remote_host != 'secpay.com')
				{
					$remote_host = gethostbyaddr($remote_host);
				}
				if ($remote_host != 'secpay.com')
				{
					$error=$this->code;
				}
			}
			else
			{
				$error=$this->code;
			}
			if ($error)
			{
				if (USE_AJAX)
				{
					ajax_error($error);
				}
				else
				{
					olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT, olc_session_name() . '=' . $_POST[olc_session_name()] .
					'&payment_error=' . $error, SSL, false, false));
				}
			}
		}
	}

	function after_process() {
		return false;
	}

	function get_error() {

		if (isset($_GET['message']) && (strlen($_GET['message']) > 0)) {
			$error = stripslashes(urldecode($_GET['message']));
		} else {
			$error = MODULE_PAYMENT_SECPAY_TEXT_ERROR_MESSAGE;
		}

		return array('title' => MODULE_PAYMENT_SECPAY_TEXT_ERROR,
		'error' => $error);
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_SECPAY_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_SECPAY_STATUS', 'true', '6', '1', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SECPAY_ALLOWED', '', '6', '0', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SECPAY_MERCHANT_ID', 'secpay',  '6', '2', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_SECPAY_CURRENCY', 'Any Currency',  '6', '3', 'olc_cfg_select_option(array(\'Any Currency\', \'Default Currency\'), ', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_SECPAY_TEST_STATUS', 'Always Successful','6', '4', 'olc_cfg_select_option(array(\'Always Successful\', \'Always Fail\', \'Production\'), ', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SECPAY_SORT_ORDER', '0',  '6', '0', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_SECPAY_ZONE', '0',  '6', '2', 'olc_get_zone_class_title', 'olc_cfg_pull_down_zone_classes(', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_SECPAY_ORDER_STATUS_ID', '0',  '6', '0', 'olc_cfg_pull_down_order_statuses(', 'olc_get_order_status_name', now())");
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}

	function keys() {
		return array('MODULE_PAYMENT_SECPAY_STATUS','MODULE_PAYMENT_SECPAY_ALLOWED', 'MODULE_PAYMENT_SECPAY_MERCHANT_ID', 'MODULE_PAYMENT_SECPAY_CURRENCY', 'MODULE_PAYMENT_SECPAY_TEST_STATUS', 'MODULE_PAYMENT_SECPAY_ZONE', 'MODULE_PAYMENT_SECPAY_ORDER_STATUS_ID', 'MODULE_PAYMENT_SECPAY_SORT_ORDER');
	}
}
?>
