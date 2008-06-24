<?php
/* -----------------------------------------------------------------------------------------
$Id: ot_shipping.php,v 1.1.1.1.2.1 2007/04/08 07:18:05 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(ot_shipping.php,v 1.15 2003/02/07); www.oscommerce.com
(c) 2003	    nextcommerce (ot_shipping.php,v 1.13 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

class ot_shipping {
	var $title, $output;

	function ot_shipping() {
		$this->code = 'ot_shipping';
		$this->title = MODULE_ORDER_TOTAL_SHIPPING_TITLE;
		$this->description = MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION;
		$this->enabled = ((strtolower(MODULE_ORDER_TOTAL_SHIPPING_STATUS) == TRUE_STRING_S) ? true : false);
		$this->sort_order = MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER;

		$this->output = array();
	}

	function process() {
		global $order, $currencies;

		$shipping_cost=$order->info['shipping_cost'];
		if (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == TRUE_STRING_S)
		{
			$country_id=$order->delivery['country_id'];
			switch (MODULE_ORDER_TOTAL_SHIPPING_DESTINATION)
			{
				case 'national':
					if ($country_id == STORE_COUNTRY) $pass = true; break;
				case 'international':
					if ($country_id != STORE_COUNTRY) $pass = true; break;
				case 'both':
					$pass = true; break;
				default:
					$pass = false; break;
			}
			if ($pass )
			{
				$total_ex_ship=$order->info['total'] - $shipping_cost;
				if ($total_ex_ship >=	MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)
				{
					$shipping_method=$this->title.LPAREN.sprintf(FREE_SHIPPING_DESCRIPTION,
					olc_format_price(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER,true,true,true)).RPAREN;
					$order->info['shipping_method'] = $shipping_method;
					$order->info['total']=$total_ex_ship;
					$shipping_cost = 0;
				}
			}
		}
		if (true or $shipping_cost>0)
		{
			$module = substr($_SESSION['shipping']['id'], 0, strpos($_SESSION['shipping']['id'], UNDERSCORE));
			if (olc_not_null($order->info['shipping_method']))
			{
				$tax_class=$GLOBALS[$module]->tax_class;
				$country_id=$order->delivery['country']['id'];
				$zone_id=$order->delivery['zone_id'];
				$shipping_tax = olc_get_tax_rate($tax_class, $country_id,$zone_id);
				$shipping_tax_description = olc_get_tax_description($tax_class, $country_id,$zone_id);
				$new_shipping_cost=olc_add_tax($shipping_cost, $shipping_tax);
				$tax=$new_shipping_cost-$shipping_cost;
				if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1)
				{
					// price with tax
					$shipping_cost=$new_shipping_cost;
					$order->info['tax'] += $tax;
					$order->info['tax_groups'][TAX_ADD_TAX . "$shipping_tax_description"] += $tax;
					$order->info['total'] += $tax;

				}
				else
				{
					if ($_SESSION['customers_status']['customers_status_add_tax_ot'] == 1)
					{
						$order->info['tax'] += $tax;
						$order->info['tax_groups'][TAX_NO_TAX . "$shipping_tax_description"]+=$tax;
					}
				}
				if (true or $shipping_cost)
				{
					$this->output[] = array(
						'title' => $order->info['shipping_method'] . COLON,
						'text' => olc_format_price($shipping_cost, true,true,true,true),
						'value' => $shipping_cost);
				}
			}
		}
	}

	function check()
	{
		if (!isset($this->_check))
		{
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION .
			" where configuration_key = 'MODULE_ORDER_TOTAL_SHIPPING_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}

		return $this->_check;
	}

	function keys()
	{
		return array('MODULE_ORDER_TOTAL_SHIPPING_STATUS', 'MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER', 'MODULE_ORDER_TOTAL_SHIPPING_DESTINATION');
	}

	function install() {
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_SHIPPING_STATUS', 'true','6', '1','olc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER', '3','6', '2', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING', 'false','6', '3', 'olc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, date_added) values ('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER', '50', '6', '4', 'currencies->format', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION', 'national','6', '5', 'olc_cfg_select_option(array(\'national\', \'international\', \'both\'), ', now())");
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}
}
?>