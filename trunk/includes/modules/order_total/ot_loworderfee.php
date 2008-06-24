<?php
/* -----------------------------------------------------------------------------------------
$Id: ot_loworderfee.php,v 1.1.1.1.2.1 2007/04/08 07:18:04 gswkaiser Exp $
OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de
Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(ot_loworderfee.php,v 1.11 2003/02/14); www.oscommerce.com
(c) 2003	    nextcommerce (ot_loworderfee.php,v 1.7 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

class ot_loworderfee {
	var $title, $output;

	function ot_loworderfee() {
		$this->code = 'ot_loworderfee';
		if (floatval(MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER)>0)
		{
			$this->title = sprintf(MODULE_ORDER_TOTAL_LOWORDERFEE_TITLE_EXTENDED,
				olc_format_price(MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER,1,1,1));
		}
		else
		{
			$this->title = MODULE_ORDER_TOTAL_LOWORDERFEE_TITLE;
		}
		$this->description = MODULE_ORDER_TOTAL_LOWORDERFEE_DESCRIPTION;
		$this->enabled = ((strtolower(MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS) == TRUE_STRING_S) ? true : false);
		$this->sort_order = MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER;
		$this->output = array();
	}

	function process()
	{
		global $order, $currencies;
		if (MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE == TRUE_STRING_S)
		{
			$pass = false;
			if ($_SESSION['shipping']['id'] != 'selfpickup_selfpickup')
			{
				$country=$order->delivery['country_id'];
				switch (MODULE_ORDER_TOTAL_LOWORDERFEE_DESTINATION) {
					case 'national':
						if ($country == STORE_COUNTRY) $pass = true; break;
					case 'international':
						if ($country != STORE_COUNTRY) $pass = true; break;
					case 'both':
						$pass = true; break;
				}
			}
			if ($pass)
			{
				if (($order->info['total']-$order->info['shipping_cost']) < MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER)
				{
					$delivery_country=$order->delivery['country']['id'];
					$delivery_zone_id=$order->delivery['zone_id'];

					$tax = olc_get_tax_rate(MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS, $delivery_country, $delivery_zone_id);
					$tax_description = olc_get_tax_description(MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS, $delivery_country,
					$delivery_zone_id);

					$low_order_fee=MODULE_ORDER_TOTAL_LOWORDERFEE_FEE;
					$low_order_fee_tax=olc_calculate_tax($low_order_fee, $tax);
					$low_order_fee=olc_add_tax($low_order_fee, $tax);
					if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1)
					{
						$order->info['tax'] += $low_order_fee_tax;
						$order->info['tax_groups'][TAX_ADD_TAX . "$tax_description"] +=	$low_order_fee_tax;
						$order->info['total'] += $low_order_fee;
					}
					else
					{
						if ($_SESSION['customers_status']['customers_status_add_tax_ot'] == 1)
						{
							$order->info['tax'] += $low_order_fee_tax;
							$order->info['tax_groups'][TAX_NO_TAX . "$tax_description"] +=$low_order_fee_tax;
						}
						$order->info['subtotal'] += $low_order_fee;
						$order->info['total'] += $low_order_fee;
					}
					$this->output[] = array(
					'title' => $this->title . ':',
					'text' => olc_format_price($low_order_fee,1,1,1),
					'value' => $low_order_fee);
				}
			}
		}
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION .
			" where configuration_key = 'MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function keys() {
		$low_order_fee='MODULE_ORDER_TOTAL_LOWORDERFEE_';
		return array(
		$low_order_fee.'STATUS',
		$low_order_fee.'SORT_ORDER',
		$low_order_fee.'LOW_ORDER_FEE',
		$low_order_fee.'ORDER_UNDER',
		$low_order_fee.'FEE',
		$low_order_fee.'DESTINATION',
		$low_order_fee.'TAX_CLASS');
	}

	function install()
	{
		$sql0=INSERT_INTO.TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, ";
		$sql1="date_added) values ('MODULE_ORDER_TOTAL_LOWORDERFEE_";
		$sql2=$sql0."set_function, ".$sql1;
		$sql3=$sql0."use_function, ".$sql1;
		olc_db_query($sql2."STATUS', 'true', '6', '1','olc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		olc_db_query($sql0.$sql1."ORDER', '4', '6', '2', now())");
		olc_db_query($sql2."LOW_ORDER_FEE', 'false', '6', '3', 'olc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		olc_db_query($sql3."ORDER_UNDER', '50','6', '4', 'currencies->format', now())");
		olc_db_query($sql3."FEE', '5','6', '5', 'currencies->format', now())");
		olc_db_query($sql2."DESTINATION', 'both','6', '6',
			'olc_cfg_select_option(array(\'national\', \'international\', \'both\'), ', now())");
		olc_db_query($sql0."use_function, set_function, ".$sql1.
		"TAX_CLASS', '0','6', '7', 'olc_get_tax_class_title', 'olc_cfg_pull_down_tax_classes(', now())");
	}

	function remove() {
		olc_db_query(DELETE_FROM.TABLE_CONFIGURATION .
		" where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}
}
?>