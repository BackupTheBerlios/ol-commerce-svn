<?php
/* -----------------------------------------------------------------------------------------
$Id: moneybookers.php,v 1.1.1.1.2.1 2007/04/08 07:18:05 gswkaiser Exp $
OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de
Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(moneybookers.php,v 1.00 2003/10/27); www.oscommerce.com
(c) 2004      XT - Commerce; www.xt-commerce.com
Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:
Moneybookers v1.0                       Autor:    Gabor Mate  <gabor(at)jamaga.hu>
(c) 2004      XT - Commerce; www.xt-commerce.com
Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
class moneybookers {
	var $code, $title, $description, $enabled, $email_footer, $auth_num, $transaction_id;
	var $mbLanguages, $mbCurrencies, $aCurrencies, $defCurr, $defLang;

	// class constructor
	function moneybookers()
	{
		global $order, $language;
		include_once(DIR_FS_INC.'olc_db_fetch_row.inc.php');
		$this->code = 'moneybookers';
		$this->title = MODULE_PAYMENT_MONEYBOOKERS_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_MONEYBOOKERS_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_MONEYBOOKERS_SORT_ORDER;
		$this->enabled = ((strtolower(MODULE_PAYMENT_MONEYBOOKERS_STATUS) == TRUE_STRING_S) ? true : false);
		$this->email_footer = MODULE_PAYMENT_MONEYBOOKERS_TEXT_EMAIL_FOOTER;
		$this->auth_num = '';
		$this->transaction_id = '';
		$this->mbLanguages = array("EN", "DE", "ES", "FR");
		$result = olc_db_query("SELECT mb_currID FROM ". TABLE_PAYMENT_MONEYBOOKERS_CURRENCIES);
		while (list($key,$currID) = olc_db_fetch_array($result))
		{
			$this->mbCurrencies[] = $currID;
		}
		$result = olc_db_query("SELECT code FROM ".TABLE_CURRENCIES);
		while (list($key,$currID) = olc_db_fetch_array($result)) {
			$this->aCurrencies[] = $currID;
		}
		$select_config_sql="SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '#'";
		$result = olc_db_query(str_replace("#","DEFAULT_CURRENCY",$select_config_sql));
		list($key,$this->defCurr) = olc_db_fetch_array($result);
		$result = olc_db_query(str_replace("#","DEFAULT_LANGUAGE",$select_config_sql));
		list($key,$this->defLang) = olc_db_fetch_array($result);
		$this->defLang = strtoupper($this->defLang);
		if (!in_array($this->defLang, $this->mbLanguages)) {
			$this->defLang = "DE";
		}
		if ((int)MODULE_PAYMENT_MONEYBOOKERS_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_MONEYBOOKERS_ORDER_STATUS_ID;
		}
		if (is_object($order)) $this->update_status();
		$this->form_action_url = 'https://www.moneybookers.com/app/payment.pl';
	}
	////
	// Status update

	function update_status() {
		global $order;
		if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_MONEYBOOKERS_ZONE > 0) ) {
			$check_flag = false;
			$check_query = olc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES .
			" where geo_zone_id = '" . MODULE_PAYMENT_IEB_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] .
			"' order by zone_id");
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
	// class methods

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
		global $order, $order_total_modules, $currencies, $currency, $languages_id;
		$result = olc_db_query("SELECT code FROM " . TABLE_LANGUAGES . " WHERE languages_id = '".SESSION_LANGUAGE_ID.APOS);
		list($key,$lang_code) = olc_db_fetch_array($result);
		$mbLanguage = strtoupper($lang_code);
		if ($mbLanguage == "US") {
			$mbLanguage = "EN";
		}
		if (!in_array($mbLanguage, $this->mbLanguages)) {
			$mbLanguage = MODULE_PAYMENT_MONEYBOOKERS_LANGUAGE;
		}
		$mbCurrency = $currency;
		if (!in_array($currency, $this->mbCurrencies)) {
			$mbCurrency = MODULE_PAYMENT_MONEYBOOKERS_CURRENCY;
		}
		$result = olc_db_query("SELECT mb_cID FROM " .
		TABLE_PAYMENT_MONEYBOOKERS_COUNTRIES.", " . TABLE_COUNTRIES .
		"  WHERE (osc_cID = countries_id) AND (countries_id = '{$order->billing['country']['id']}')");
		list($key,$mbCountry) = olc_db_fetch_array($result);
		$this->transaction_id = $this->generate_trid();
		$result = olc_db_query(INSERT_INTO . TABLE_PAYMENT_MONEYBOOKERS." (mb_TRID, mb_DATE) VALUES ('{$this->transaction_id}', NOW())");
		if ($_SESSION['currency']==$mbCurrency) {
			$amount=olc_round($order->info['total'], $currencies->get_decimal_places($mbCurrency));
		} else {
			$amount=olc_round($order->info['total'] * $currencies->get_value($mbCurrency), $currencies->get_decimal_places($mbCurrency));
		}

		$process_button_string = olc_draw_hidden_field('pay_to_email', MODULE_PAYMENT_MONEYBOOKERS_EMAILID) .
		olc_draw_hidden_field('transaction_id', $this->transaction_id) .
		olc_draw_hidden_field('return_url', olc_href_link(FILENAME_CHECKOUT_PROCESS, 'trid='.$this->transaction_id, NONSSL, false)) .
		olc_draw_hidden_field('cancel_url', olc_href_link(FILENAME_CHECKOUT_PAYMENT,
		MODULE_PAYMENT_MONEYBOOKERS_ERRORTEXT1.
		$this->code.MODULE_PAYMENT_MONEYBOOKERS_ERRORTEXT2, SSL, true, false)) .
		olc_draw_hidden_field('status_url', 'mailto:' . MODULE_PAYMENT_MONEYBOOKERS_EMAILID) .
		olc_draw_hidden_field('language', $mbLanguage) .
		olc_draw_hidden_field('pay_from_email', $order->customer['email_address']) .
		olc_draw_hidden_field('amount', $amount) .
		olc_draw_hidden_field('currency', $mbCurrency) .
		olc_draw_hidden_field('detail1_description', STORE_NAME) .
		olc_draw_hidden_field('detail1_text', MODULE_PAYMENT_MONEYBOOKERS_ORDER_TEXT .
		strftime(DATE_FORMAT_LONG)) .
		olc_draw_hidden_field('firstname', $order->billing['firstname']) .
		olc_draw_hidden_field('lastname', $order->billing['lastname']) .
		olc_draw_hidden_field('address', $order->billing['street_address']) .
		olc_draw_hidden_field('postal_code', $order->billing['postcode']) .
		olc_draw_hidden_field('city', $order->billing['city']) .
		olc_draw_hidden_field('state', $order->billing['state']) .
		olc_draw_hidden_field('country', $mbCountry) .
		olc_draw_hidden_field('confirmation_note', MODULE_PAYMENT_MONEYBOOKERS_CONFIRMATION_TEXT);
		if (ereg("[0-9]{6}", MODULE_PAYMENT_MONEYBOOKERS_REFID)) {
			$process_button_string .= olc_draw_hidden_field('rid', MODULE_PAYMENT_MONEYBOOKERS_REFID);
		}
		// moneyboocers.com payment gateway does not accept accented characters!
		// Please feel free to add any other accented characters to the list.
		return strtr($process_button_string, "áéíóöõúüûÁÉÍÓÖÕÚÜÛ", "aeiooouuuAEIOOOUUU");
	}
	// manage returning data from moneybookers (errors, failures, success etc.)

	function before_process() {
		global $order, $_GET;
		$this->transaction_id = $_GET["trid"];
		$md5_pwd = md5(MODULE_PAYMENT_MONEYBOOKERS_PWD);
		$queryURL = "https://www.moneybookers.com/app/query.pl?email=".MODULE_PAYMENT_MONEYBOOKERS_EMAILID.
		"&password=".$md5_pwd."&action=status_trn&trn_id=".$this->transaction_id;
		$ch = curl_init($queryURL);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		$result = urldecode($result);
		$payment_error_return=EMPTY_STRING;
		/********************************/
		// get the returned error code
		// 200 -- OK
		// 401 -- Login failed
		// 402 -- Unknown action
		// 403 -- Transaction not found
		// 404 -- Missing parameter
		// 405 -- Illegal parameter value
		/********************************/
		preg_match("/\d{3}/", $result, $return_code);
		switch ($return_code[0]) {

			// query was OK, data is sent back
			case "200":
				$result = strstr($result, "status");
				$aResult = explode("&", $result);
				/***********************************************************/
				// get the returned data
				// [status] -- (-2) => failed
				//             ( 2) => processed
				//             ( 1) => scheduled (eg. offline bank transfer)
				// [mb_transaction_id] -- transaction id at moneybookers.com
				/***********************************************************/
				foreach ($aResult as $value)
				{
					list($parameter, $pVal) = explode(EQUAL, $value);
					$aFinal["$parameter"] = $pVal;
				}
				if ($aFinal["status"] == -2)
				{
					$result = olc_db_query(
					SQL_UPDATE  . TABLE_PAYMENT_MONEYBOOKERS.
					" SET mb_ERRNO = '999', mb_ERRTXT = 'Transaction failed.', mb_MBTID = {$aFinal['mb_transaction_id']}, mb_STATUS = {$aFinal['status']} WHERE mb_TRID = '{$this->transaction_id}'");
					$payment_error_return = "payment_error={$this->code}&error=-2: ".MODULE_PAYMENT_MONEYBOOKERS_TRANSACTION_FAILED_TEXT;
					return false;
				} else {
					$result = olc_db_query(SQL_UPDATE  . TABLE_PAYMENT_MONEYBOOKERS." SET mb_ERRNO = '200', mb_ERRTXT = 'OK', mb_MBTID = {$aFinal['mb_transaction_id']}, mb_STATUS = {$aFinal['status']} WHERE mb_TRID = '{$this->transaction_id}'");
					$moneybookers_payment_comment = MODULE_PAYMENT_MONEYBOOKERS_ORDER_COMMENT1.$aFinal["mb_transaction_id"].LPAREN.MODULE_PAYMENT_MONEYBOOKERS_ORDER_COMMENT2.") ";
					$order->info['comments'] = $moneybookers_payment_comment.$order->info['comments'];
				}
				break;

				// error occured during query
				// errors documented in the moneybookers doc
			case "401":
			case "402":
			case "403":
			case "404":
			case "405":
				preg_match("/[^\d\t]+.*/i", $result, $return_array);
				$result = olc_db_query(SQL_UPDATE  . TABLE_PAYMENT_MONEYBOOKERS." SET mb_ERRNO = '{$return_code[0]}', mb_ERRTXT = '{$return_array[0]}' WHERE mb_TRID = '{$this->transaction_id}'");
				$payment_error_return = "payment_error={$this->code}&error={$return_code[0]}: {$return_array[0]}";
				break;

				// unknown error
			default:
				$payment_error_return = "payment_error={$this->code}&error=000: Unknown error!";
				break;
		}
		if ($payment_error_return)
		{
			if (USE_AJAX)
			{
				ajax_error($payment_error_return);
			}
			else
			{
				olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, SSL, true, false));
			}
		}
	}

	function after_process() {
		global $insert_id;
		// Finally, insert osCommerce order id into the moneybookers table
		$result = olc_db_query(SQL_UPDATE  . TABLE_PAYMENT_MONEYBOOKERS." SET mb_ORDERID = $insert_id WHERE mb_TRID = '{$this->transaction_id}'");
	}

	function get_error() {
		global $_GET;
		$error = array('title' => MODULE_PAYMENT_MONEYBOOKERS_TEXT_ERROR,
		'error' => stripslashes(urldecode($_GET['error'])));
		return $error;
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION .
			" where configuration_key = 'MODULE_PAYMENT_MONEYBOOKERS_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		if (!$this->check_currency($this->aCurrencies)) {
			$this->enabled = false;
			if (USE_AJAX)
			{
				ajax_error(MODULE_PAYMENT_MONEYBOOKERS_NOCURRENCY_ERROR);
			}
			else
			{
				$install_error_return = 'set=payment&module=moneybookers&error=' . MODULE_PAYMENT_MONEYBOOKERS_NOCURRENCY_ERROR;
				olc_redirect(olc_href_link(FILENAME_MODULES, $install_error_return, SSL, true, false));
			}
			return false;
		}
		$insert_sql=INSERT_INTO . TABLE_CONFIGURATION .
		" (configuration_key,configuration_value,configuration_group_id,sort_order,set_function,use_function,date_added) values ('MODULE_PAYMENT_MONEYBOOKERS_";
		$use_date=",'',now())";
		$set_use_date=",''".$use_date;
		olc_db_query($insert_sql . "STATUS','true', '6','0','olc_cfg_select_option(array(\'True\',\'False\'),'" . $use_date);
		olc_db_query($insert_sql . "EMAILID','','6','1'" . $set_use_date);
		olc_db_query($insert_sql . "PWD','', '6','2'" . $set_use_date);
		olc_db_query($insert_sql . "REFID','','6','3'" . $set_use_date);
		olc_db_query($insert_sql . "SORT_ORDER','', '6','4'" . $set_use_date);
		olc_db_query($insert_sql .
		"CURRENCY','".$this->defCurr."','6','5','olc_cfg_select_option(".
		$this->show_array($this->aCurrencies)."),'" . $use_date);
		olc_db_query($insert_sql .
		"LANGUAGE','".$this->defLang."','6','6','olc_cfg_select_option(".
		$this->show_array($this->mbLanguages)."),'" . $use_date);
		olc_db_query($insert_sql .
		"ZONE','', '6','7','olc_get_zone_class_title','olc_cfg_pull_down_zone_classes(',now())");
		olc_db_query($insert_sql .
		"ORDER_STATUS_ID','', '6','8','olc_cfg_pull_down_order_statuses(','olc_get_order_status_name',now())");
		olc_db_query($insert_sql . "ALLOWED','','6',''" . $set_use_date);
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" .
		implode("','",$this->keys()) . "')");
	}

	function keys()
	{
		$s='MODULE_PAYMENT_MONEYBOOKERS_';
		return array($s.'STATUS', $s.'EMAILID', $s.'PWD', $s.'REFID', $s.'LANGUAGE', $s.'CURRENCY', $s.'SORT_ORDER',
		$s.'ORDER_STATUS_ID', $s.'ZONE');
	}
	// If there is no moneybookers accepted currency configured with the shop
	// do not allow the moneybookers payment module installation

	function check_currency($availableCurr) {
		$foundCurr = false;
		foreach ($availableCurr as $currID) {
			if (in_array($currID, $this->mbCurrencies)) {
				$foundCurr = true;
			}
		}
		return $foundCurr;
	}
	// Parse the predefinied array to be 'module install' friendly
	// as it is used for select in the module's install() function

	function show_array($aArray) {
		$aFormatted = "array(";
		foreach ($aArray as $key=>$sVal) {
			$aFormatted .= "\'$sVal\', ";
		}
		$aFormatted = substr($aFormatted, 0, strlen($aFormatted)-2);
		return $aFormatted;
	}

	function generate_trid() {
		do {
			$trid = olc_create_random_value(16, "mixed");
			$result = olc_db_query("SELECT mb_TRID FROM ".TABLE_PAYMENT_MONEYBOOKERS."  WHERE mb_TRID = '$trid'");
		} while (olc_db_num_rows($result));
		return $trid;
	}
}
?>