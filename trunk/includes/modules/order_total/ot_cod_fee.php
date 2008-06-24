<?php
/* -----------------------------------------------------------------------------------------
$Id: ot_cod_fee.php,v 1.1.1.1.2.1 2007/04/08 07:18:03 gswkaiser Exp $
OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de
Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(ot_cod_fee.php,v 1.02 2003/02/24); www.oscommerce.com
(C) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers ; http://www.themedia.at & http://www.oscommerce.at
Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:
Adapted for xtcommerce 2003/09/30 by Benax (axel.benkert@online-power.de)
Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org
Copyright (c) 2004 Manfred Tomanik http://www.st-computer.com
Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

class ot_cod_fee {
	var $title, $output;
	function ot_cod_fee() {
		$this->code = 'ot_cod_fee';
		$this->title = MODULE_ORDER_TOTAL_COD_TITLE;
		$this->description = MODULE_ORDER_TOTAL_COD_DESCRIPTION;
		$this->enabled = ((strtolower(MODULE_ORDER_TOTAL_COD_STATUS) == TRUE_STRING_S) ? true : false);
		$this->sort_order = MODULE_ORDER_TOTAL_COD_SORT_ORDER;
		$this->output = array();
	}
	function process() {
		global $order, $currencies, $cod_cost, $cod_country, $shipping;
		if (strtolower(MODULE_ORDER_TOTAL_COD_STATUS) == TRUE_STRING_S) {
			//Will become true, if cod can be processed.
			$cod_country = false;
			//check if payment method is cod. If yes, check if cod is possible.
			if ($_SESSION['payment'] == 'cod') {
				//process installed shipping modules
				$shipping_id =$_SESSION['shipping']['id'];
				$split_text="[:,]";
				if ($shipping_id == 'flat_flat') $cod_zones = split($split_text, MODULE_ORDER_TOTAL_COD_FEE_FLAT);
				elseif ($shipping_id == 'item_item') $cod_zones = split($split_text, MODULE_ORDER_TOTAL_COD_FEE_ITEM);
				elseif ($shipping_id == 'table_table') $cod_zones = split($split_text, MODULE_ORDER_TOTAL_COD_FEE_TABLE);
				elseif ($shipping_id == 'zones_zones') $cod_zones = split($split_text, MODULE_ORDER_TOTAL_COD_FEE_ZONES);
				elseif ($shipping_id == 'ap_ap') $cod_zones = split($split_text, MODULE_ORDER_TOTAL_COD_FEE_AP);
				elseif ($shipping_id == 'dp_dp') $cod_zones = split($split_text, MODULE_ORDER_TOTAL_COD_FEE_DP);
				elseif ($shipping_id == 'dpd_dpd') $cod_zones = split($split_text, MODULE_ORDER_TOTAL_COD_FEE_DPD);
				elseif ($shipping_id == 'ups_ups') $cod_zones = split($split_text, MODULE_ORDER_TOTAL_COD_FEE_UPS);
				elseif ($shipping_id == 'upse_upse') $cod_zones = split($split_text, MODULE_ORDER_TOTAL_COD_FEE_UPSE);
				elseif ($shipping_id == 'freeamountausl_freeamountausl') $cod_zones = split($split_text, MODULE_ORDER_TOTAL_COD_FEE_FREEAMOUNTAUSL);
				elseif ($shipping_id == 'freeamount_freeamount') $cod_zones = split($split_text, MODULE_ORDER_TOTAL_COD_FEE_FREEAMOUNT);
				$country_iso_code_2=$order->billing['country']['iso_code_2'];
				for ($i = 0; $i < count($cod_zones); $i++)
				{
					if ($cod_zones[$i] == $country_iso_code_2)
					{
						$cod_cost = $cod_zones[$i + 1];
						$cod_country = true;
						//print('match' . $cod_zones[$i] . ': ' . $cod_cost);
						break;
					} elseif ($cod_zones[$i] == '00') {
						$cod_cost = $cod_zones[$i + 1];
						$cod_country = true;
						//print('match' . $i . ': ' . $cod_cost);
						break;
					} else {
						//print('no match');
					}
					$i++;
				}
			} else {
				//COD selected, but no shipping module which offers COD
			}
			if ($cod_country) {
				$cod_tax = olc_get_tax_rate(MODULE_ORDER_TOTAL_COD_TAX_CLASS, $order->delivery['country']['id'], $order->delivery['zone_id']);
				$cod_tax_description = olc_get_tax_description(MODULE_ORDER_TOTAL_COD_TAX_CLASS, $order->delivery['country']['id'], $order->delivery['zone_id']);
				if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) {
					$order->info['tax'] += olc_add_tax($cod_cost, $cod_tax)-$cod_cost;
					$order->info['tax_groups'][TAX_ADD_TAX . "$cod_tax_description"] += olc_add_tax($cod_cost, $cod_tax)-$cod_cost;
					$order->info['total'] += $cod_cost + (olc_add_tax($cod_cost, $cod_tax)-$cod_cost);
					$cod_cost_value= olc_add_tax($cod_cost, $cod_tax);
					$cod_cost= olc_format_price($cod_cost_value, $price_special=1, $calculate_currencies=true);
				}
				if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
					$order->info['tax'] += olc_add_tax($cod_cost, $cod_tax)-$cod_cost;
					$order->info['tax_groups'][TAX_NO_TAX . "$cod_tax_description"] += olc_add_tax($cod_cost, $cod_tax)-$cod_cost;
					$cod_cost_value=$cod_cost;
					$cod_cost= olc_format_price($cod_cost, $price_special=1, $calculate_currencies=true);
					$order->info['subtotal'] += $cod_cost_value;
					$order->info['total'] += $cod_cost_value;
				}
				if (!$cod_cost_value) {
					$cod_cost_value=$cod_cost;
					$cod_cost= olc_format_price($cod_cost, $price_special=1, $calculate_currencies=true);
					$order->info['total'] += $cod_cost_value;
				}
				$this->output[] = array('title' => $this->title . ':',
				'text' => $cod_cost,
				'value' => $cod_cost_value);
			} else {
				//Following code should be improved if we can't get the shipping modules disabled, who don't allow COD
				// as well as countries who do not have cod
				//          $this->output[] = array('title' => $this->title . ':',
				//                                  'text' => 'No COD for this module.',
				//                                  'value' => '');
			}
		}
	}
	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_COD_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}
	function keys() {
		return array('MODULE_ORDER_TOTAL_COD_STATUS', 'MODULE_ORDER_TOTAL_COD_SORT_ORDER', 'MODULE_ORDER_TOTAL_COD_FEE_FLAT', 'MODULE_ORDER_TOTAL_COD_FEE_ITEM', 'MODULE_ORDER_TOTAL_COD_FEE_TABLE', 'MODULE_ORDER_TOTAL_COD_FEE_ZONES', 'MODULE_ORDER_TOTAL_COD_FEE_AP', 'MODULE_ORDER_TOTAL_COD_FEE_DP', 'MODULE_ORDER_TOTAL_COD_FEE_DPD', 'MODULE_ORDER_TOTAL_COD_FEE_UPS', 'MODULE_ORDER_TOTAL_COD_FEE_UPSE','MODULE_ORDER_TOTAL_COD_FEE_FREEAMOUNTAUSL','MODULE_ORDER_TOTAL_COD_FEE_FREEAMOUNT','MODULE_ORDER_TOTAL_COD_TAX_CLASS');
	}
	function install()
	{
		$sql_0=INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, ";
		$sql_1=", date_added) values ('MODULE_ORDER_TOTAL_COD_";
		$sql=$sql0."date_added) values ('MODULE_ORDER_TOTAL_COD_";
		olc_db_query($sql0."set_function".$sql_1."STATUS', 'true', '6', '0', 'olc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		olc_db_query($sql."SORT_ORDER', '35', '6', '0', now())");
		olc_db_query($sql."FEE_FLAT', 'AT:3.00,DE:3.58,00:9.99', '6', '0', now())");
		olc_db_query($sql."FEE_ITEM', 'AT:3.00,DE:3.58,00:9.99', '6', '0', now())");
		olc_db_query($sql."FEE_TABLE', 'AT:3.00,DE:3.58,00:9.99', '6', '0', now())");
		olc_db_query($sql."FEE_ZONES', 'CA:4.50,US:3.00,00:9.99', '6', '0', now())");
		olc_db_query($sql."FEE_AP', 'AT:3.63,00:9.99', '6', '0', now())");
		olc_db_query($sql."FEE_DP', 'DE:4.00,00:9.99', '6', '0', now())");
		olc_db_query($sql."FEE_DPD', '', '6', '0', now())");
		olc_db_query($sql."FEE_UPS', '', '6', '0', now())");
		olc_db_query($sql."FEE_UPSE', '', '6', '0', now())");
		olc_db_query($sql."FEE_FREEAMOUNTAUSL', '', '6', '0', now())");
		olc_db_query($sql."FEE_FREEAMOUNT', '', '6', '0', now())");
		olc_db_query($sql0."use_function, set_function".$sql_1."TAX_CLASS', '0', '6', '0', 'olc_get_tax_class_title', 'olc_cfg_pull_down_tax_classes(', now())");
	}
	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}
}
?>