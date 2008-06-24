<?php
/* -----------------------------------------------------------------------------------------
$Id: pm2checkout.php,v 1.1.1.1.2.1 2007/04/08 07:18:06 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(pm2checkout.php,v 1.19 2003/01/29); www.oscommerce.com
(c) 2003	    nextcommerce (pm2checkout.php,v 1.8 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/


class pm2checkout {
	var $code, $title, $description, $enabled;


	function pm2checkout() {
		global $order;

		$this->code = 'pm2checkout';
		$this->title = MODULE_PAYMENT_2CHECKOUT_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_2CHECKOUT_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_2CHECKOUT_SORT_ORDER;
		$this->enabled = ((strtolower(MODULE_PAYMENT_2CHECKOUT_STATUS) == TRUE_STRING_S) ? true : false);

		if ((int)MODULE_PAYMENT_2CHECKOUT_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_2CHECKOUT_ORDER_STATUS_ID;
		}

		if (is_object($order)) $this->update_status();

		$this->form_action_url = 'https://www.2checkout.com/cgi-bin/Abuyers/purchase.2c';
	}


	function update_status() {
		global $order;

		if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_2CHECKOUT_ZONE > 0) ) {
			$check_flag = false;
			$check_query = olc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_2CHECKOUT_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
		$js = '  if (payment_value == "' . $this->code . '") {' . NEW_LINE .
		'    var cc_number = document.checkout_payment.pm_2checkout_cc_number.value;' . NEW_LINE .
		'    if (cc_number == "" || cc_number.length < ' . CC_NUMBER_MIN_LENGTH . ') {' . NEW_LINE .
		'      error_message = error_message + "' . MODULE_PAYMENT_2CHECKOUT_TEXT_JS_CC_NUMBER . '";' . NEW_LINE .
		'      error = 1;' . NEW_LINE .
		'    }' . NEW_LINE .
		'  }' . NEW_LINE;

		return $js;
	}

	function selection() {
		global $order;

		for ($i=1; $i < 13; $i++) {
			$expires_month[] = array('id' => sprintf('%02d', $i), 'text' => strftime('%B',mktime(0,0,0,$i,1,2000)));
		}

		$today = getdate();
		for ($i=$today['year']; $i < $today['year']+10; $i++) {
			$expires_year[] = array('id' => strftime('%y',mktime(0,0,0,1,1,$i)), 'text' => strftime('%Y',mktime(0,0,0,1,1,$i)));
		}

		$selection = array('id' => $this->code,
		'module' => $this->title,
		'fields' => array(array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER_FIRST_NAME,
		'field' => olc_draw_input_field('pm_2checkout_cc_owner_firstname', $order->billing['firstname'])),
		array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER_LAST_NAME,
		'field' => olc_draw_input_field('pm_2checkout_cc_owner_lastname', $order->billing['lastname'])),
		array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_NUMBER,
		'field' => olc_draw_input_field('pm_2checkout_cc_number')),
		array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_EXPIRES,
		'field' => olc_draw_pull_down_menu('pm_2checkout_cc_expires_month', $expires_month) . HTML_NBSP . olc_draw_pull_down_menu('pm_2checkout_cc_expires_year', $expires_year)),
		array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER,
		'field' => olc_draw_input_field('pm_2checkout_cc_cvv', EMPTY_STRING, 'size="4" maxlength="3"') . '&nbsp;<small>' . MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION . '</small>')));

		return $selection;
	}

	function pre_confirmation_check()
	{

		include_once(DIR_WS_CLASSES . 'cc_validation.php');

		$cc_validation = new cc_validation();
		$result = $cc_validation->validate($_POST['pm_2checkout_cc_number'], $_POST['pm_2checkout_cc_expires_month'], $_POST['pm_2checkout_cc_expires_year']);

		$error = EMPTY_STRING;
		switch ($result)
		{
			case -1:
				$error = sprintf(TEXT_CCVAL_ERROR_UNKNOWN_CARD, substr($cc_validation->cc_number, 0, 4));
				break;
			case -2:
			case -3:
			case -4:
				$error = TEXT_CCVAL_ERROR_INVALID_DATE;
				break;
			case false:
				$error = TEXT_CCVAL_ERROR_INVALID_NUMBER;
				break;
		}

		if ( ($result == false) || ($result < 1) )
		{
			$this->cc_card_type = $cc_validation->cc_type;
			$this->cc_card_number = $cc_validation->cc_number;
			$this->cc_expiry_month = $cc_validation->cc_expiry_month;
			$this->cc_expiry_year = $cc_validation->cc_expiry_year;
			if (USE_AJAX)
			{
				ajax_error($error);
			}
			else
			{
				$payment_error_return =
				'payment_error=' . $this->code .
				'&error=' . urlencode($error) .
				'&pm_2checkout_cc_owner_firstname=' . urlencode($_POST['pm_2checkout_cc_owner_firstname']) .
				'&pm_2checkout_cc_owner_lastname=' . urlencode($_POST['pm_2checkout_cc_owner_lastname']) .
				'&pm_2checkout_cc_expires_month=' . $_POST['pm_2checkout_cc_expires_month'] .
				'&pm_2checkout_cc_expires_year=' . $_POST['pm_2checkout_cc_expires_year'];
				olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, SSL, true, false));
			}
		}
	}

	function confirmation() {

		$confirmation = array('title' => $this->title . ': ' . $this->cc_card_type,
		'fields' => array(array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_OWNER,
		'field' => $_POST['pm_2checkout_cc_owner_firstname'] . BLANK . $_POST['pm_2checkout_cc_owner_lastname']),
		array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_NUMBER,
		'field' => substr($this->cc_card_number, 0, 4) . str_repeat('X', (strlen($this->cc_card_number) - 8)) . substr($this->cc_card_number, -4)),
		array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_CREDIT_CARD_EXPIRES,
		'field' => strftime('%B, %Y', mktime(0,0,0,$_POST['pm_2checkout_cc_expires_month'], 1, '20' . $_POST['pm_2checkout_cc_expires_year'])))));

		return $confirmation;
	}

	function process_button() {
		global $order;

		$process_button_string = olc_draw_hidden_field('x_login', MODULE_PAYMENT_2CHECKOUT_LOGIN) .
		olc_draw_hidden_field('x_amount', number_format($order->info['total'], 2)) .
		olc_draw_hidden_field('x_invoice_num', date('YmdHis')) .
		olc_draw_hidden_field('x_test_request', ((MODULE_PAYMENT_2CHECKOUT_TESTMODE == 'Test') ? 'Y' : 'N')) .
		olc_draw_hidden_field('x_card_num', $this->cc_card_number) .
		olc_draw_hidden_field('cvv', $_POST['pm_2checkout_cc_cvv']) .
		olc_draw_hidden_field('x_exp_date', $this->cc_expiry_month . substr($this->cc_expiry_year, -2)) .
		olc_draw_hidden_field('x_first_name', $_POST['pm_2checkout_cc_owner_firstname']) .
		olc_draw_hidden_field('x_last_name', $_POST['pm_2checkout_cc_owner_lastname']) .
		olc_draw_hidden_field('x_address', $order->customer['street_address']) .
		olc_draw_hidden_field('x_city', $order->customer['city']) .
		olc_draw_hidden_field('x_state', $order->customer['state']) .
		olc_draw_hidden_field('x_zip', $order->customer['postcode']) .
		olc_draw_hidden_field('x_country', $order->customer['country']['title']) .
		olc_draw_hidden_field('x_email', $order->customer['email_address']) .
		olc_draw_hidden_field('x_phone', $order->customer['telephone']) .
		olc_draw_hidden_field('x_ship_to_first_name', $order->delivery['firstname']) .
		olc_draw_hidden_field('x_ship_to_last_name', $order->delivery['lastname']) .
		olc_draw_hidden_field('x_ship_to_address', $order->delivery['street_address']) .
		olc_draw_hidden_field('x_ship_to_city', $order->delivery['city']) .
		olc_draw_hidden_field('x_ship_to_state', $order->delivery['state']) .
		olc_draw_hidden_field('x_ship_to_zip', $order->delivery['postcode']) .
		olc_draw_hidden_field('x_ship_to_country', $order->delivery['country']['title']) .
		olc_draw_hidden_field('x_receipt_link_url', olc_href_link(FILENAME_CHECKOUT_PROCESS, EMPTY_STRING, SSL)) .
		olc_draw_hidden_field('x_email_merchant',
			((MODULE_PAYMENT_2CHECKOUT_EMAIL_MERCHANT == TRUE_STRING_S) ? TRUE_STRING_S : 'FALSE'));

		return $process_button_string;
	}

	function before_process()
	{

		if ($_POST['x_response_code'] != '1')
		{
			if (USE_AJAX)
			{
				ajax_error(MODULE_PAYMENT_2CHECKOUT_TEXT_ERROR_MESSAGE);
			}
			else
			{
				olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT,
				'error_message=' . urlencode(MODULE_PAYMENT_2CHECKOUT_TEXT_ERROR_MESSAGE), SSL, true, false));
			}
		}
	}

	function after_process() {
		return false;
	}

	function get_error() {

		$error = array('title' => MODULE_PAYMENT_2CHECKOUT_TEXT_ERROR,
		'error' => stripslashes(urldecode($_GET['error'])));

		return $error;
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_2CHECKOUT_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install()
	{
		$sql0=INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, ";
		$sql00="date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_";
		$sql1=$sql0."set_function, ".$sql00;
		$sql2=$sql0.$sql00;
		$sql3=$sql0."use_function, set_function, ".$sql00;
		olc_db_query($sql1."STATUS', 'true', '6', '0', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		olc_db_query($sql2."ALLOWED', '',  '6', '0', now())");
		olc_db_query($sql1."LOGIN', '',  '6', '0', now())");
		olc_db_query($sql1."TESTMODE', 'Test', '6', '0', 'olc_cfg_select_option(array(\'Test\', \'Production\'), ', now())");
		olc_db_query($sql1."EMAIL_MERCHANT', 'true',  '6', '0', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		olc_db_query($sql1."SORT_ORDER', '0',  '6', '0', now())");
		olc_db_query($sql3."ZONE', '0',  '6', '2', 'olc_get_zone_class_title', 'olc_cfg_pull_down_zone_classes(', now())");
		olc_db_query($sql3."ORDER_STATUS_ID', '0',  '6', '0', 'olc_get_order_status_name', 'olc_cfg_pull_down_order_statuses(', now())");
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}

	function keys()
	{
		return array('MODULE_PAYMENT_2CHECKOUT_STATUS','MODULE_PAYMENT_PM2CHECKOUT_ALLOWED', 'MODULE_PAYMENT_2CHECKOUT_LOGIN', 'MODULE_PAYMENT_2CHECKOUT_TESTMODE', 'MODULE_PAYMENT_2CHECKOUT_EMAIL_MERCHANT', 'MODULE_PAYMENT_2CHECKOUT_ZONE', 'MODULE_PAYMENT_2CHECKOUT_ORDER_STATUS_ID', 'MODULE_PAYMENT_2CHECKOUT_SORT_ORDER');
	}
}
?>