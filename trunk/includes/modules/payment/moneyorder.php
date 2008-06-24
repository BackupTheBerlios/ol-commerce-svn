<?php
/* -----------------------------------------------------------------------------------------
$Id: moneyorder.php,v 1.1.1.1.2.1 2007/04/08 07:18:06 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(moneyorder.php,v 1.10 2003/01/29); www.oscommerce.com
(c) 2003	    nextcommerce (moneyorder.php,v 1.7 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/


class moneyorder {
	var $code, $title, $description, $enabled;

	function moneyorder()
	{
		global $order;

		$this->code = 'moneyorder';
		$this->title = MODULE_PAYMENT_MONEYORDER_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_MONEYORDER_SORT_ORDER;
		$this->enabled = ((strtolower(MODULE_PAYMENT_MONEYORDER_STATUS) == TRUE_STRING_S) ? true : false);

		if ((int)MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID;
		}

		if (is_object($order)) $this->update_status();

		$this->email_footer = MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER;
	}


	function update_status() {
		global $order;

		if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_MONEYORDER_ZONE > 0) ) {
			$check_flag = false;
			$check_query = olc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES .
			" where geo_zone_id = '" . MODULE_PAYMENT_MONEYORDER_ZONE .
			"' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
		$title=MODULE_PAYMENT_MONEYORDER_TEXT_TITLE;
		if (defined('MODULE_PAYMENT_MONEYORDER_TEXT_EXPLANATION'))
		{
			$title.=HTML_B_END.MODULE_PAYMENT_MONEYORDER_TEXT_EXPLANATION.HTML_B_START;
		}
		return array(
		'id' => $this->code,
		'module' => $title);
	}

	function pre_confirmation_check() {
		return false;
	}

	function confirmation() {
		return array('title' => MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION);
	}

	function process_button() {
		return false;
	}

	function before_process() {
		return false;
	}

	function after_process() {
		return false;
	}

	function get_error() {
		return false;
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION .
			" where configuration_key = 'MODULE_PAYMENT_MONEYORDER_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		$sql=INSERT_INTO . TABLE_CONFIGURATION .
		" ( configuration_key, configuration_value,  configuration_group_id, sort_order, ";
		$sql_date=$sql."date_added) values ('MODULE_PAYMENT_MONEYORDER_";
		$sql_function=$sql."set_function, use_function, date_added) values ('MODULE_PAYMENT_MONEYORDER_";
		olc_db_query($sql . "set_function, date_added) values ('MODULE_PAYMENT_MONEYORDER_STATUS', 'true', '6', '1', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now());");
		olc_db_query($sql_date."ALLOWED', '',   '6', '0', now())");
		olc_db_query($sql_date."PAYTO', '', '6', '1', now());");
		olc_db_query($sql_date."SORT_ORDER', '0', '6', '0', now())");
		olc_db_query($sql_function."ZONE', '0',  '6', '2', 'olc_cfg_pull_down_zone_classes(', 'olc_get_zone_class_title', now())");
		olc_db_query($sql_function."ORDER_STATUS_ID', '0', '6', '0', 'olc_cfg_pull_down_order_statuses(', 'olc_get_order_status_name', now())");
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION .
		" where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}

	function keys() {
		return array('MODULE_PAYMENT_MONEYORDER_STATUS','MODULE_PAYMENT_MONEYORDER_ALLOWED', 'MODULE_PAYMENT_MONEYORDER_ZONE', 'MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID', 'MODULE_PAYMENT_MONEYORDER_SORT_ORDER', 'MODULE_PAYMENT_MONEYORDER_PAYTO');
	}
}
?>
