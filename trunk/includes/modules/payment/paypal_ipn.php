<?php
/*
$Id: paypal_ipn.php,v 1.1.1.1.2.1 2007/04/08 07:18:06 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2003 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/

define('FILENAME_PAYPAL_INFO','popup_paypal.php');
define('FILENAME_IPN','ipn.php');
define('MODULE_PAYMENT_PAYPAL_IPN','MODULE_PAYMENT_PAYPAL_IPN_');

class paypal_ipn {
	var $code, $title, $description, $enabled;

	// class constructor
	function paypal_ipn()
	{
		global $order;
		$this->code = 'paypal_ipn';
		$this->codeTitle = 'PayPal';
		$this->title = MODULE_PAYMENT_PAYPAL_IPN_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_PAYPAL_IPN_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_PAYPAL_IPN_SORT_ORDER;
		$this->enabled = ((strtolower(MODULE_PAYMENT_PAYPAL_IPN_STATUS) == TRUE_STRING_S) ? true : false);
		if (MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID;
		}
		if (is_object($order)) $this->update_status();
		$this->form_paypal_url = 'https://' . MODULE_PAYMENT_PAYPAL_IPN_DOMAIN . '/cgi-bin/webscr';
		$this->form_action_url = $this->form_paypal_url;
		$this->cc_explain_url = olc_href_link(FILENAME_PAYPAL_INFO, EMPTY_STRING, SSL);
	}

	// catalog payment module class methods
	function update_status() {
		global $order;
		if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_PAYPAL_IPN_ZONE > 0) ) {
			$check_flag = false;
			$check_query = olc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES .
			" where geo_zone_id = '" . MODULE_PAYMENT_PAYPAL_IPN_ZONE . "' and zone_country_id = '" .
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

	function selection()
	{
		if (USE_PAYPAL_IPN)
		{
			$paypal_image_dir=PAYPAL_IPN_DIR.'images/';
			$img_visa = olc_image($paypal_image_dir.'visa.gif',' Visa ',
				EMPTY_STRING,EMPTY_STRING,'align="absmiddle"');
			$img_mc = olc_image($paypal_image_dir.'mastercard.gif',' MasterCard ',
				EMPTY_STRING,EMPTY_STRING,'align="absmiddle"');
			$img_paypal = olc_image($paypal_image_dir.'paypal_intl.gif',' PayPal ',
				EMPTY_STRING,EMPTY_STRING,'align="absmiddle"');
			/*
			$img_discover = olc_image($paypal_image_dir.'discover.gif',' Discover ',
			EMPTY_STRING,EMPTY_STRING,'align="absmiddle"');

			$img_amex = olc_image($paypal_image_dir.'amex.gif',' American Express ',
			EMPTY_STRING,EMPTY_STRING,'align="absmiddle"');
			*/
			$paypal_cc_txt = sprintf(MODULE_PAYMENT_PAYPAL_IPN_CC_TEXT,
			$img_visa,$img_mc,$img_paypal,$img_amex,$img_discover);
			$fields[] = array(
			'title' => EMPTY_STRING, //MODULE_PAYMENT_PAYPAL_IPN_TEXT_TITLE,
			'field' => HTML_B_START . $paypal_cc_txt . HTML_B_END . $cc_explain );
			return array(
			'id' => $this->code,
			'module' => $this->title,
			'fields' => $fields);
		}
	}

	function pre_confirmation_check() {
		return false;
	}

	function confirmation() {
		return false;
	}

	function currency() {
		global $currency;
		if(!isset($this->currency)) {
			if (MODULE_PAYMENT_PAYPAL_IPN_CURRENCY == 'Selected Currency') {
				$this->currency = $currency;
			} else {
				$this->currency = substr(MODULE_PAYMENT_PAYPAL_IPN_CURRENCY, 5);
			}
			if (!in_array($this->currency, array('EUR', 'GBP', 'JPY', 'USD', 'CAD', 'AUD'))) {
				$this->currency = MODULE_PAYMENT_PAYPAL_IPN_DEFAULT_CURRENCY;
			}
		}
		return $this->currency;
	}

	//Returns the gross total amount to compare with paypal.mc_gross
	function grossPaymentAmount($my_currency) {
		global $order, $currencies;
		return number_format(($order->info['total']) * $currencies->get_value($my_currency),
		$currencies->get_decimal_places($my_currency));
	}

	function amount($my_currency) {
		global $order, $currencies;
		return number_format(($order->info['total'] - $order->info['shipping_cost']) *
		$currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
	}

	function process_button()
	{
		//W. Kaiser
		return $this->formFields();
		//return false;
		//W. Kaiser
	}

	function before_process()
	{
		if(!class_exists('PayPal_osC')) include_once(PAYPAL_IPN_DIR.'Classes/osC/osC.class.php');
		if (PayPal_osC::check_order_status())
		{
			olc_redirect(olc_href_link(FILENAME_SHOPPING_CART, EMPTY_STRING, SSL));
		} else {
			include(PAYPAL_IPN_DIR.'catalog/checkout_process.inc.php');
		}
		exit;
	}

	function after_process() {
		return false;
	}

	function output_error() {
		return false;
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION .
			" where configuration_key = 'MODULE_PAYMENT_PAYPAL_IPN_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function setTransactionID() {
		global $order, $currencies;
		$my_currency = $this->currency();
		$trans_id = STORE_NAME . date('Ymdhis');
		$this->digest = md5($trans_id . number_format($order->info['total'] * $currencies->get_value($my_currency),
		$currencies->get_decimal_places($my_currency), '.', EMPTY_STRING) . MODULE_PAYMENT_PAYPAL_IPN_DIGEST_KEY);
		return $this->digest;
	}
	function formFields($txn_sign = '', $payment_amount = '', $payment_currency = '', $payment_currency_value = '',
	$orders_id = '', $return_url = '', $cancel_url = '' )
	{
		global $order, $currencies;

		$my_currency = (!empty($payment_currency)) ? $payment_currency : $this->currency();
		$my_currency_value = (!empty($payment_currency_value)) ?
		$payment_currency_value : $currencies->get_value($my_currency);

		//Merchant Info
		$paypal_fields = olc_draw_hidden_field('business', MODULE_PAYMENT_PAYPAL_IPN_BUSINESS_ID);

		//Currency
		$paypal_fields .= olc_draw_hidden_field('currency_code', $my_currency);

		//Shopping Cart Info
		if(MODULE_PAYMENT_PAYPAL_IPN_METHOD == 'Itemized')
		{
			$paypal_fields .= olc_draw_hidden_field('charset', CHARSET);
			$paypal_fields .= olc_draw_hidden_field('upload', sizeof($order->products)) .
			olc_draw_hidden_field('redirect_cmd', '_cart') .
			olc_draw_hidden_field('handling_cart', number_format($order->info['shipping_cost'] * $my_currency_value,
			$currencies->get_decimal_places($my_currency)));

			//Itemized Order Details
			for ($i=0,$index=1; $i<sizeof($order->products); $i++, $index++) {
				//$index = $i+1;
				$paypal_fields .=
				olc_draw_hidden_field('item_name_'.$index, $order->products[$i]['name']).
				olc_draw_hidden_field('item_number_'.$index, $order->products[$i]['model']).
				olc_draw_hidden_field('quantity_'.$index, $order->products[$i]['qty']).
				olc_draw_hidden_field('amount_'.$index,
				number_format($order->products[$i]['final_price']* $my_currency_value,2));
				$tax = ($order->products[$i]['final_price'] * ($order->products[$i]['tax'] / 100)) * $my_currency_value;
				$paypal_fields .= olc_draw_hidden_field('tax_'.$index, number_format($tax, 2));
				//Customer Specified Product Options: PayPal Max = 2
				if ($order->products[$i]['attributes']) {
					//$n = sizeof($order->products[$i]['attributes']);
					for ($j=0; $j<2; $j++) {
						if($order->products[$i]['attributes'][$j]['option']){
							$paypal_fields .= $this->optionSetFields($j,$index,
							$order->products[$i]['attributes'][$j]['option'],$order->products[$i]['attributes'][$j]['value']);
						} else {
							$paypal_fields .= $this->optionSetFields($j,$index);
						}
					}
				} else {
					for ($j=0; $j<2; $j++) {
						$paypal_fields .= $this->optionSetFields($j,$index);
					}
				}
			}
		} else { //Aggregate Cart (Method 1)
			$paypal_fields .= olc_draw_hidden_field('item_name', STORE_NAME) .
			olc_draw_hidden_field('redirect_cmd', '_xclick') .
			olc_draw_hidden_field('amount', !empty($payment_amount) ? $payment_amount : $this->amount($my_currency)) .
			olc_draw_hidden_field('shipping', number_format($order->info['shipping_cost'] * $my_currency_value,
			$currencies->get_decimal_places($my_currency)));
			$item_number = EMPTY_STRING;
			for ($i=0; $i<sizeof($order->products); $i++) $item_number .= ' '.$order->products[$i]['name'].' ,';
			$item_number = substr_replace($item_number,EMPTY_STRING,-2);
			$paypal_fields .= olc_draw_hidden_field('item_number', $item_number);
		}

		//Synchronize invoice
		if(MODULE_PAYMENT_PAYPAL_IPN_INVOICE_REQUIRED == TRUE_STRING_S)
		$paypal_fields .= olc_draw_hidden_field('invoice', !empty($orders_id) ? $orders_id : $this->orders_id);
		//Allow customer to choose their own shipping address
		if(MODULE_PAYMENT_PAYPAL_IPN_SHIPPING_ALLOWED == 'No' ) $paypal_fields .= olc_draw_hidden_field('no_shipping', '1' );

		//Customer registration fields
		$paypal_fields .= $this->customerDetailsFields($order);
		//Customer comment field
		$paypal_fields .= $this->noteOptionFields(MODULE_PAYMENT_PAYPAL_IPN_NO_NOTE ,
		MODULE_PAYMENT_PAYPAL_IPN_CUSTOMER_COMMENTS);

		//Store Logo
		if(olc_not_null(MODULE_PAYMENT_PAYPAL_IPN_STORE_LOGO)) $paypal_fields .=
		olc_draw_hidden_field('image_url', olc_href_link(DIR_WS_IMAGES.MODULE_PAYMENT_PAYPAL_IPN_STORE_LOGO,
		EMPTY_STRING,SSL,false));
		//PayPal background color
		$paypal_fields .= olc_draw_hidden_field('cs',
		(MODULE_PAYMENT_PAYPAL_IPN_CS == MODULE_PAYMENT_PAYPAL_IPN_CS_WHITE) ? '0' : '1');
		//PayPal page style
		if(olc_not_null(MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE))
		$paypal_fields .= olc_draw_hidden_field('page_style',MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE);

		//PayPal Store Config
		$paypal_fields .= olc_draw_hidden_field('custom', !empty($txn_sign) ? $txn_sign : $this->digest) .
		olc_draw_hidden_field('return', !empty($return_url) ? $return_url :
		olc_href_link(FILENAME_CHECKOUT_SUCCESS, 'action=success', SSL)) .
		olc_draw_hidden_field('cancel_return', !empty($cancel_url) ?
		$cancel_url : olc_href_link(FILENAME_CHECKOUT_PAYMENT, EMPTY_STRING, SSL)) .
		olc_draw_hidden_field('notify_url', olc_href_link(FILENAME_IPN, EMPTY_STRING, SSL,false)) .
		olc_draw_hidden_field('rm', MODULE_PAYMENT_PAYPAL_IPN_RM) .
		olc_draw_hidden_field('bn', 'osc-ipn-v1');
		return $paypal_fields;
	}

	function customerDetailsFields(&$order) {
		//Customer Details - for those who haven't signed up to PayPal
		$paypal_fields =
		olc_draw_hidden_field('cmd', '_ext-enter') . //allows the customer addr details to be passed
		olc_draw_hidden_field('email', $order->customer['email_address']) .
		olc_draw_hidden_field('first_name', $order->billing['firstname']) .
		olc_draw_hidden_field('last_name', $order->billing['lastname']) .
		olc_draw_hidden_field('address1', $order->billing['street_address']) .
		olc_draw_hidden_field('address2', $order->billing['suburb']) .
		olc_draw_hidden_field('city', $order->billing['city']) .
		olc_draw_hidden_field('state', olc_get_zone_code($order->billing['country']['id'],$order->billing['zone_id'],
		$order->billing['zone_id'])) .
		olc_draw_hidden_field('zip', $order->billing['postcode']) .
		//Note: Anguilla[AI], Dominican Republic[DO], The Netherlands[NL] have different codes to the iso codes in the osC db
		olc_draw_hidden_field('country', $order->billing['country']['iso_code_2']);

		//Telephone is problematic.
		/*//OMITTED SINCE NOT SPECIFICALLY BILLING ADDRESS RELATED
		$telephone = preg_replace('/\D/', EMPTY_STRING, $order->customer['telephone']);
		$paypal_fields .= olc_draw_hidden_field('night_phone_a',substr($telephone,0,3));
		$paypal_fields .= olc_draw_hidden_field('night_phone_b',substr($telephone,3,3));
		$paypal_fields .= olc_draw_hidden_field('night_phone_c',substr($telephone,6,4));
		$paypal_fields .= olc_draw_hidden_field('day_phone_a',substr($telephone,0,3));
		$paypal_fields .= olc_draw_hidden_field('day_phone_b',substr($telephone,3,3));
		$paypal_fields .= olc_draw_hidden_field('day_phone_c',substr($telephone,6,4));
		*/

		//Flow Language
		$paypal_fields .= olc_draw_hidden_field('lc', $order->billing['country']['iso_code_2']);

		return $paypal_fields;
	}

	function optionSetFields($sub_index,$index,$option=' ',$value=' ') {
		return olc_draw_hidden_field('on'.$sub_index.'_'.$index,$option).
		olc_draw_hidden_field('os'.$sub_index.'_'.$index,$value);
	}

	function noteOptionFields($option='No',$msg=MODULE_PAYMENT_PAYPAL_IPN_CUSTOMER_COMMENTS)
	{
		$option = ($option == 'Yes') ? '0': '1';
		$no_note = olc_draw_hidden_field('no_note',$option);
		if (!$option) return $no_note .= olc_draw_hidden_field('cn',$msg);
		else return $no_note;
	}

	function sendMoneyFields(&$order, $orders_id) {
		include_once(PAYPAL_IPN_DIR.'database_tables.inc.php');
		$orders_session_query =
		olc_db_query("select firstname, lastname, payment_amount, payment_currency, payment_currency_val,
			txn_signature from " . TABLE_ORDERS_SESSION_INFO . " where orders_id ='" . (int)$orders_id . APOS);
		$orders_session_info = olc_db_fetch_array($orders_session_query);
		$order->billing['firstname'] = $orders_session_info['firstname'];
		$order->billing['lastname'] = $orders_session_info['lastname'];
		$return_href_link = olc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id='.$orders_id, SSL);
		$cancel_href_link = $return_href_link;
		return $this->formFields($orders_session_info['txn_signature'],
		$orders_session_info['payment_amount'] - $order->info['shipping_cost'],
		$orders_session_info['payment_currency'], $orders_session_info['payment_currency_val'], $orders_id,
		$return_href_link, $cancel_href_link);
	}

	function install() {
		$sql=INSERT_INTO . TABLE_CONFIGURATION .
		" (configuration_key, configuration_value, configuration_group_id, sort_order, ";
		$sql_date0="date_added) values ('".MODULE_PAYMENT_PAYPAL_IPN;
		$sql_date=$sql . $sql_date0;
		$sql_set_date="set_function, ".$sql_date0;
		$sql_use_set_date=$sql."use_function, ".$sql_set_date;
		$sql_set_date=$sql.$sql_set_date;
		$default_status=DEFAULT_ORDERS_STATUS_ID .
		"', '6', '0', 'olc_get_order_status_name', 'olc_cfg_pull_down_order_statuses(', now())";
		olc_db_query($sql_set_date.
		"STATUS', 'true', '6', '0', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		olc_db_query($sql_date."id','".STORE_OWNER_EMAIL_ADDRESS."', '6', '0', now())");
		olc_db_query($sql_date."BUSINESS_ID','".STORE_OWNER_EMAIL_ADDRESS."', '6', '', now())");
		olc_db_query($sql_set_date.
		"DEFAULT_CURRENCY', 'EUR', '6', '0', 'olc_cfg_select_option(array(\'EUR\'), ', now())");
		olc_db_query($sql_set_date.
		"CURRENCY', 'Nur EUR', '6', '0', 'olc_cfg_select_option(array(\'Nur EUR\'), ', now())");
		olc_db_query($sql_use_set_date.
		"ZONE', '0', '6', '0', 'olc_get_zone_class_title', '', now())");
		olc_db_query($sql_use_set_date."PROCESSING_STATUS_ID', '" . $default_status);
		olc_db_query($sql_use_set_date."ORDER_STATUS_ID', '" . $default_status);
		olc_db_query($sql_use_set_date."ORDER_ONHOLD_STATUS_ID', '" . $default_status);
		olc_db_query($sql_use_set_date."ORDER_CANCELED_STATUS_ID', '" . $default_status);
		olc_db_query($sql_use_set_date."ORDER_REFUNDED_STATUS_ID', '" . $default_status);
		olc_db_query($sql_set_date.
		"INVOICE_REQUIRED', FALSE_STRING_L, '6', '0', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		olc_db_query($sql_date."SORT_ORDER', '0', '6', '0', now())");
		olc_db_query($sql_set_date."CS', '".MODULE_PAYMENT_PAYPAL_IPN_CS_WHITE."', '6', '0',
		'olc_cfg_select_option(array(\'".MODULE_PAYMENT_PAYPAL_IPN_CS_WHITE."\',\'".
		MODULE_PAYMENT_PAYPAL_IPN_CS_BLACK."\'), ', now())");
		olc_db_query($sql_date."PROCESSING_LOGO', '".CURRENT_TEMPLATE_IMG."logo.gif', '6', '0', now())");
		olc_db_query($sql_date."STORE_LOGO', '".CURRENT_TEMPLATE_IMG."logo.gif', '6', '0', now())");
		olc_db_query($sql_date."PAGE_STYLE', 'default', '6', '0', now())");
		olc_db_query($sql_set_date.
		"NO_NOTE', 'No', '6', '0', 'olc_cfg_select_option(array(\'Yes\',\'No\'), ', now())");
		olc_db_query($sql_set_date."METHOD', '".MODULE_PAYMENT_PAYPAL_IPN_METHOD_CART.
		"', '6', '0', 'olc_cfg_select_option(array(\'".MODULE_PAYMENT_PAYPAL_IPN_METHOD_CART."\',\'".
		MODULE_PAYMENT_PAYPAL_IPN_METHOD_ITEMIZED."\'), ', now())");
		olc_db_query($sql_set_date.
		"SHIPPING_ALLOWED', 'No', '6', '0', 'olc_cfg_select_option(array(\'Yes\',\'No\'), ', now())");
		olc_db_query($sql_set_date.
		"DEBUG', 'Yes', '6', '0', 'olc_cfg_select_option(array(\'Yes\',\'No\'), ', now())");
		olc_db_query($sql_date."DIGEST_KEY', 'PayPal_Shopping_Cart_Key', '6', '0', now())");
		olc_db_query($sql_set_date.
		"TEST_MODE', 'An', '6', '0', 'olc_cfg_select_option(array(\'Off\',\'On\'), ', now())");
		olc_db_query($sql_set_date.
		"CART_TEST', 'An', '6', '0', 'olc_cfg_select_option(array(\'Off\',\'On\'), ', now())");
		olc_db_query($sql_date."DEBUG_EMAIL','".STORE_OWNER_EMAIL_ADDRESS."', '6', '0', now())");
		olc_db_query($sql_set_date.
		"DOMAIN', 'www.sandbox.paypal.com', '6', '0',".
		"'olc_cfg_select_option(array(\'www.paypal.com\',\'www.sandbox.paypal.com\'), ', now())");
		olc_db_query($sql_set_date."RM', '2', '6', '0', 'olc_cfg_select_option(array(\'0\',\'1\',\'2\'), ', now())");			}

		function remove() {
			olc_db_query(DELETE_FROM . TABLE_CONFIGURATION .
			" where configuration_key in ('" . implode("', '", $this->keys()) . "')");
		}

		function keys() {
			return array(
			MODULE_PAYMENT_PAYPAL_IPN.'STATUS',
			MODULE_PAYMENT_PAYPAL_IPN.'id',
			MODULE_PAYMENT_PAYPAL_IPN.'BUSINESS_ID',
			MODULE_PAYMENT_PAYPAL_IPN.'DEFAULT_CURRENCY',
			MODULE_PAYMENT_PAYPAL_IPN.'CURRENCY',
			MODULE_PAYMENT_PAYPAL_IPN.'ZONE',
			MODULE_PAYMENT_PAYPAL_IPN.'PROCESSING_STATUS_ID',
			MODULE_PAYMENT_PAYPAL_IPN.'ORDER_STATUS_ID',
			MODULE_PAYMENT_PAYPAL_IPN.'ORDER_ONHOLD_STATUS_ID',
			MODULE_PAYMENT_PAYPAL_IPN.'ORDER_REFUNDED_STATUS_ID',
			MODULE_PAYMENT_PAYPAL_IPN.'ORDER_CANCELED_STATUS_ID',
			MODULE_PAYMENT_PAYPAL_IPN.'INVOICE_REQUIRED',
			MODULE_PAYMENT_PAYPAL_IPN.'SORT_ORDER',
			MODULE_PAYMENT_PAYPAL_IPN.'CS',
			MODULE_PAYMENT_PAYPAL_IPN.'PROCESSING_LOGO',
			MODULE_PAYMENT_PAYPAL_IPN.'STORE_LOGO',
			MODULE_PAYMENT_PAYPAL_IPN.'PAGE_STYLE',
			MODULE_PAYMENT_PAYPAL_IPN.'NO_NOTE',
			MODULE_PAYMENT_PAYPAL_IPN.'METHOD',
			MODULE_PAYMENT_PAYPAL_IPN.'SHIPPING_ALLOWED',
			MODULE_PAYMENT_PAYPAL_IPN.'DIGEST_KEY',
			MODULE_PAYMENT_PAYPAL_IPN.'TEST_MODE',
			MODULE_PAYMENT_PAYPAL_IPN.'CART_TEST',
			MODULE_PAYMENT_PAYPAL_IPN.'DEBUG',
			MODULE_PAYMENT_PAYPAL_IPN.'DEBUG_EMAIL',
			MODULE_PAYMENT_PAYPAL_IPN.'DOMAIN',
			MODULE_PAYMENT_PAYPAL_IPN.'RM');
		}
}//end class
?>
