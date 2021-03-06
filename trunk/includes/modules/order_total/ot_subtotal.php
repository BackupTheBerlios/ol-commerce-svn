<?php
/* -----------------------------------------------------------------------------------------
$Id: ot_subtotal.php,v 1.1.1.1.2.1 2007/04/08 07:18:05 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(ot_subtotal.php,v 1.7 2003/02/13); www.oscommerce.com
(c) 2003	    nextcommerce (ot_subtotal.php,v 1.10 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

class ot_subtotal {
	var $title, $output;

	function ot_subtotal() {
		$this->code = 'ot_subtotal';
		$this->title = MODULE_ORDER_TOTAL_SUBTOTAL_TITLE;
		$this->description = MODULE_ORDER_TOTAL_SUBTOTAL_DESCRIPTION;
		$this->enabled = ((strtolower(MODULE_ORDER_TOTAL_SUBTOTAL_STATUS) == TRUE_STRING_S) ? true : false);
		$this->sort_order = MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER;

		$this->output = array();
	}

	function process()
	{
		global $order, $currencies;

		$title=$this->title;
		if (!CUSTOMER_SHOW_PRICE_TAX)
		{
			if ($_SESSION['customers_status']['customers_status_add_tax_ot'] == 0)
			{
				$title=MODULE_ORDER_TOTAL_SUBTOTAL_TITLE_NO_TAX;
			}
		}
		$subtotal=$order->info['subtotal'];
		$this->output[] = array(
		'title' => $title . COLON,
		'text' => olc_format_price($subtotal,1,false),
		'value' => $subtotal);
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION .
			" where configuration_key = 'MODULE_ORDER_TOTAL_SUBTOTAL_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}

		return $this->_check;
	}

	function keys() {
		return array('MODULE_ORDER_TOTAL_SUBTOTAL_STATUS', 'MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER');
	}

	function install()
	{
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_SUBTOTAL_STATUS', 'true', '6', '1','olc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER', '1', '6', '2', now())");
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}
}
?>