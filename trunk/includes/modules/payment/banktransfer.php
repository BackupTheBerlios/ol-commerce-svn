<?php
/* -----------------------------------------------------------------------------------------
$Id: banktransfer.php,v 1.1.1.1.2.1 2007/04/08 07:18:05 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(banktransfer.php,v 1.16 2003/03/02 22:01:50); www.oscommerce.com
(c) 2003	    nextcommerce (banktransfer.php,v 1.9 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:
OSC German Banktransfer v0.85a       	Autor:	Dominik Guder <osc@guder.org>

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/


class banktransfer {

	var $code, $title, $description, $enabled;


	function banktransfer() {
		global $order;

		$this->code = 'banktransfer';
		$this->title = MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_BANKTRANSFER_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER;
		$this->enabled = ((strtolower(MODULE_PAYMENT_BANKTRANSFER_STATUS) == TRUE_STRING_S) ? true : false);

		if ((int)MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID;
		}
		if (is_object($order)) $this->update_status();

		if ($_POST['banktransfer_fax'] == "on")
		$this->email_footer = MODULE_PAYMENT_BANKTRANSFER_TEXT_EMAIL_FOOTER;
	}


	function update_status() {
		global $order;

		if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_BANKTRANSFER_ZONE > 0) ) {
			$check_flag = false;
			$check_query = olc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES .
			" where geo_zone_id = '" . MODULE_PAYMENT_BANKTRANSFER_ZONE . "' and zone_country_id = '" .
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

		if ($this->enabled == true) {
			if ($order->content_type == 'virtual') {
				$this->enabled = false;
			}
		}
	}

	function javascript_validation() {
		$js = 'if (payment_value == "' . $this->code . '") {' . NEW_LINE .
		'  var banktransfer_blz = document.checkout_payment.banktransfer_blz.value;' . NEW_LINE .
		'  var banktransfer_number = document.checkout_payment.banktransfer_number.value;' . NEW_LINE .
		'  var banktransfer_owner = document.checkout_payment.banktransfer_owner.value;' . NEW_LINE .
		//'  var banktransfer_fax = document.checkout_payment.banktransfer_fax.checked;' . NEW_LINE .
		'  var banktransfer_fax;' . NEW_LINE .
		'  if (banktransfer_fax == false) {' . NEW_LINE .
		'    if (banktransfer_blz == "") {' . NEW_LINE .
		'      error_message = error_message + "' . JS_BANK_BLZ . '";' . NEW_LINE .
		'      error = 1;' . NEW_LINE .
		'    }' . NEW_LINE .
		'    if (banktransfer_number == "") {' . NEW_LINE .
		'      error_message = error_message + "' . JS_BANK_NUMBER . '";' . NEW_LINE .
		'      error = 1;' . NEW_LINE .
		'    }' . NEW_LINE .
		'    if (banktransfer_owner == "") {' . NEW_LINE .
		'      error_message = error_message + "' . JS_BANK_OWNER . '";' . NEW_LINE .
		'      error = 1;' . NEW_LINE .
		'    }' . NEW_LINE .
		'  }' . NEW_LINE .
		'}' . NEW_LINE;
		return $js;
	}

	function selection() {
		global $order;

		//W. Kaiser - AJAX
		$bank_info_required=$_SESSION['credit_covers']!=true;
		$selection = array('id' => $this->code,
		'module' => $this->title,
		'fields' => array(
		array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE,
		'field' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_INFO),
		//Add hidden field for country (needed for blz-validation)
		array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_OWNER,
		'field' => olc_draw_input_field('banktransfer_owner', trim($order->billing['firstname'] . BLANK .
		$order->billing['lastname'])).olc_draw_hidden_field('entry_country_id', $order->billing['country']['id'])),
		array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_BLZ,
		'field' => olc_draw_input_field('banktransfer_blz', EMPTY_STRING, 'size="10" maxlength="8"','text',
		true,AJAX_BLZ_VALIDATION,$bank_info_required,MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_BLZ,true)),
		array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_NUMBER,
		'field' => olc_draw_input_field('banktransfer_number', EMPTY_STRING, 'size="16" maxlength="32"','text',
		true,AJAX_BLZ_VALIDATION,$bank_info_required,MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_NUMBER,true)),
		array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_NAME,
		'field' => olc_draw_input_field('banktransfer_bankname', EMPTY_STRING, 'size="32" maxlength="32"')),
		array('title' => EMPTY_STRING,
		'field' => olc_draw_hidden_field('recheckok', $_POST['recheckok']))
		));
		//W. Kaiser - AJAX

		if (MODULE_PAYMENT_BANKTRANSFER_FAX_CONFIRMATION ==TRUE_STRING_S){
			$selection['fields'][] = array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE,
			'field' => MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE2 . HTML_A_START . MODULE_PAYMENT_BANKTRANSFER_URL_NOTE .
			'" target="_blank"><b>' . MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE3 . '</b></a>' .
			MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE4);
			$selection['fields'][] = array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_FAX,
			'field' => olc_draw_checkbox_field('banktransfer_fax', 'on'));
		}

		return $selection;
	}

	function pre_confirmation_check(){
		global $banktransfer_number, $banktransfer_blz;

		if ($_POST['banktransfer_fax'] == false) {
			if ($banktransfer_result > 0 ||  $_POST['banktransfer_owner'] == EMPTY_STRING) {
				if ($_POST['banktransfer_owner'] == EMPTY_STRING) {
					$error = 'Name des Kontoinhabers fehlt!';
					$recheckok = EMPTY_STRING;
				} else {
					include_once(DIR_WS_CLASSES . 'banktransfer_validation.php');
					$banktransfer_validation = new AccountCheck;
					$banktransfer_result = $banktransfer_validation->CheckAccount($banktransfer_number, $banktransfer_blz);
					switch ($banktransfer_result) {
						case 1: // number & blz not ok
						$error = MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_1;
						$recheckok = TRUE_STRING_S;
						break;
						case 5: // BLZ not found
						$error = MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_5;
						$recheckok = TRUE_STRING_S;
						break;
						case 8: // no blz entered
						$error = MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_8;
						$recheckok = EMPTY_STRING;
						break;
						case 9: // no number entered
						$error = MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_9;
						$recheckok = EMPTY_STRING;
						break;
						default:
						$error = MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_4;
						$recheckok = TRUE_STRING_S;
						break;
					}
				}
				if (USE_AJAX)
				{
					ajax_error($error);
				}
				else
				{
					if ($_POST['recheckok'] != TRUE_STRING_S)
					{
						$payment_error_return =
						'payment_error=' . $this->code .
						'&error=' . urlencode($error) .
						'&banktransfer_owner=' . urlencode($_POST['banktransfer_owner']) .
						'&banktransfer_number=' . urlencode($_POST['banktransfer_number']) .
						'&banktransfer_blz=' . urlencode($_POST['banktransfer_blz']) .
						'&banktransfer_bankname=' . urlencode($_POST['banktransfer_bankname']) .
						'&recheckok=' . $recheckok;
						olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, SSL, true, false));
					}
				}
			}
		}
		$this->banktransfer_owner = $_POST['banktransfer_owner'];
		$this->banktransfer_blz = $_POST['banktransfer_blz'];
		$this->banktransfer_number = $_POST['banktransfer_number'];
		$this->banktransfer_prz = $banktransfer_validation->PRZ;
		$this->banktransfer_status = $banktransfer_result;
		if ($banktransfer_validation->Bankname != EMPTY_STRING)
		$this->banktransfer_bankname = $banktransfer_validation->Bankname;
		else
		$this->banktransfer_bankname = $_POST['banktransfer_bankname'];
		//W. Kaiser - AJAX
	}

	function confirmation() {
		global $banktransfer_val, $banktransfer_owner, $banktransfer_bankname, $banktransfer_blz, $banktransfer_number,
		$checkout_form_action, $checkout_form_submit;

		if (!$_POST['banktransfer_owner'] == EMPTY_STRING) {
			$confirmation = array('title' => $this->title,
			'fields' => array(array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_OWNER,
			'field' => $this->banktransfer_owner),
			array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_BLZ,
			'field' => $this->banktransfer_blz),
			array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_NUMBER,
			'field' => $this->banktransfer_number),
			array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_NAME,
			'field' => $this->banktransfer_bankname)
			));
		}
		if ($_POST['banktransfer_fax'] == "on") {
			$confirmation = array('fields' => array(array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_FAX)));
			$this->banktransfer_fax = "on";
		}
		return $confirmation;
	}

	function process_button() {
		global $_POST;

		include_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
		$process_button_string =
		olc_draw_hidden_field('banktransfer_blz', $this->banktransfer_blz) .
		olc_draw_hidden_field('banktransfer_bankname', $this->banktransfer_bankname).
		olc_draw_hidden_field('banktransfer_number', $this->banktransfer_number) .
		olc_draw_hidden_field('banktransfer_owner', $this->banktransfer_owner) .
		olc_draw_hidden_field('banktransfer_status', $this->banktransfer_status) .
		olc_draw_hidden_field('banktransfer_prz', $this->banktransfer_prz) .
		olc_draw_hidden_field('banktransfer_fax', $this->banktransfer_fax);

		return $process_button_string;

	}

	function before_process() {
		return false;
	}

	function after_process() {
		global $insert_id, $_POST, $banktransfer_val, $banktransfer_owner, $banktransfer_bankname, $banktransfer_blz,
		$banktransfer_number, $banktransfer_status, $banktransfer_prz, $banktransfer_fax, $checkout_form_action,
		$checkout_form_submit;
		olc_db_query(INSERT_INTO.TABLE_BANKTRANSFER." (
			orders_id, banktransfer_blz, banktransfer_bankname, banktransfer_number, banktransfer_owner, banktransfer_status,
			banktransfer_prz) VALUES ('" . $insert_id . "', '" . $_POST['banktransfer_blz'] . "', '" .
		$_POST['banktransfer_bankname'] . "', '" . $_POST['banktransfer_number'] . "', '" .
		$_POST['banktransfer_owner'] ."', '" . $_POST['banktransfer_status'] ."', '" .
		$_POST['banktransfer_prz'] ."')");
		if ($_POST['banktransfer_fax'])
		olc_db_query(SQL_UPDATE.TABLE_BANKTRANSFER." set banktransfer_fax = '" . $_POST['banktransfer_fax'] .
		"' where orders_id = '" . $insert_id . APOS);
	}

	function get_error() {

		$error = array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR,
		'error' => stripslashes(urldecode($_GET['error'])));

		return $error;
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION .
			" where configuration_key = 'MODULE_PAYMENT_BANKTRANSFER_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install()
	{
		$sql=INSERT_INTO . TABLE_CONFIGURATION .
		" ( configuration_key, configuration_value, configuration_group_id, sort_order, ";
		$sql_1="date_added) values ('MODULE_PAYMENT_BANKTRANSFER_";
		$sql_2=", ".$sql_1;
		olc_db_query($sql."set_function".$sql_2."STATUS', 'true', '6', '1',
		 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		olc_db_query($sql."use_function, set_function".$sql_2."ZONE', '0',
		  '6', '2', 'olc_get_zone_class_title', 'olc_cfg_pull_down_zone_classes(', now())");
		olc_db_query($sql.$sql_1."ALLOWED', '', '6', '0', now())");
		olc_db_query($sql.$sql_1."SORT_ORDER', '0', '6', '0', now())");
		olc_db_query($sql."set_function, use_function".$sql_2."STATUS_ID', '0',  '6', '0', 'olc_cfg_pull_down_order_statuses(',
		 'olc_get_order_status_name', now())");
		olc_db_query($sql."set_function".$sql_2."FAX_CONFIRMATION', 'false',
		 '6', '2', 'olc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		olc_db_query($sql."set_function".$sql_2."DATABASE_BLZ', 'false', '6',
		 '0', 'olc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		olc_db_query($sql.$sql_1."URL_NOTE', 'fax.html', '6', '0', now())");

		olc_db_query("CREATE TABLE IF NOT EXISTS ".TABLE_BANKTRANSFER."
			(orders_id int(11) NOT NULL default '0', banktransfer_owner varchar(64) default NULL,
			banktransfer_number varchar(24) default NULL, banktransfer_bankname varchar(255) default NULL,
			banktransfer_blz varchar(8) default NULL, banktransfer_status int(11) default NULL,
			banktransfer_prz char(2) default NULL, banktransfer_fax char(2) default NULL, KEY orders_id(orders_id))");
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" .
		implode("', '", $this->keys()) . "')");
	}

	function keys() {
		return array('MODULE_PAYMENT_BANKTRANSFER_STATUS','MODULE_PAYMENT_BANKTRANSFER_ALLOWED',
		'MODULE_PAYMENT_BANKTRANSFER_ZONE', 'MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID',
		'MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER', 'MODULE_PAYMENT_BANKTRANSFER_DATABASE_BLZ',
		'MODULE_PAYMENT_BANKTRANSFER_FAX_CONFIRMATION', 'MODULE_PAYMENT_BANKTRANSFER_URL_NOTE');
	}
}
?>