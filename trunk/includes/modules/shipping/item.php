<?php
/* -----------------------------------------------------------------------------------------
$Id: item.php,v 1.1.1.1.2.1 2007/04/08 07:18:11 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(item.php,v 1.39 2003/02/05); www.oscommerce.com
(c) 2003	    nextcommerce (item.php,v 1.7 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/


class item {
	var $code, $title, $description, $icon, $enabled;


	function item() {
		global $order;
		if (!$order)
		{
			include_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES.'order.php');
			$order=new order;
		}
		$order_delivery_country=$order->delivery['country'];

		$this->code = 'item';
		$this->title = MODULE_SHIPPING_ITEM_TEXT_TITLE;
		$this->description = MODULE_SHIPPING_ITEM_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_SHIPPING_ITEM_SORT_ORDER;
		$this->icon = '';
		$this->tax_class = MODULE_SHIPPING_ITEM_TAX_CLASS;
		$this->enabled = ((strtolower(MODULE_SHIPPING_ITEM_STATUS) == TRUE_STRING_S) ? true : false);

		if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_ITEM_ZONE > 0) ) {
			$check_flag = false;
			$check_query = olc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . "
			where geo_zone_id = '" . MODULE_SHIPPING_ITEM_ZONE . "'
			and zone_country_id = '" . $order_delivery_country['id'] . "' order by zone_id");
			while ($check = olc_db_fetch_array($check_query)) {
				if ($check['zone_id'] < 1) {
					$check_flag = true;
					break;
				} elseif ($check['zone_id'] == $order->delivery['zone_id']) {
					$check_flag = true;
					break;
				}
			}

			if ($check_flag == false) {
				$this->enabled = false;
			}
		}
	}


	function quote($method = '') {
		global $order, $total_count;

		if (!$order)
		{
			$order=new order;
		}
		if (!$shipping_weight)
		{
			$shipping_weight=$_SESSION['cart']->show_weight();
		}
		$order_delivery_country=$order->delivery['country'];

		$this->quotes = array('id' => $this->code,
		'module' => MODULE_SHIPPING_ITEM_TEXT_TITLE,
		'methods' => array(array('id' => $this->code,
		'title' => MODULE_SHIPPING_ITEM_TEXT_WAY,
		'cost' => (MODULE_SHIPPING_ITEM_COST * $total_count) + MODULE_SHIPPING_ITEM_HANDLING)));

		if ($this->tax_class > 0) {
			$this->quotes['tax'] = olc_get_tax_rate($this->tax_class, $order_delivery_country['id'], $order->delivery['zone_id']);
		}

		if (olc_not_null($this->icon)) $this->quotes['icon'] = olc_image($this->icon, $this->title);

		return $this->quotes;
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_ITEM_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_ITEM_STATUS', 'true', '6', '0', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_ITEM_ALLOWED', '', '6', '0', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_ITEM_COST', '2.50', '6', '0', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_ITEM_HANDLING', '0', '6', '0', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_ITEM_TAX_CLASS', '0', '6', '0', 'olc_get_tax_class_title', 'olc_cfg_pull_down_tax_classes(', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_ITEM_ZONE', '0', '6', '0', 'olc_get_zone_class_title', 'olc_cfg_pull_down_zone_classes(', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_ITEM_SORT_ORDER', '0', '6', '0', now())");
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}

	function keys() {
		return array('MODULE_SHIPPING_ITEM_STATUS', 'MODULE_SHIPPING_ITEM_COST', 'MODULE_SHIPPING_ITEM_HANDLING','MODULE_SHIPPING_ITEM_ALLOWED', 'MODULE_SHIPPING_ITEM_TAX_CLASS', 'MODULE_SHIPPING_ITEM_ZONE', 'MODULE_SHIPPING_ITEM_SORT_ORDER');
	}
}
?>
