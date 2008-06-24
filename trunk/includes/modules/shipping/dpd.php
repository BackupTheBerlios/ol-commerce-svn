<?php
/* -----------------------------------------------------------------------------------------
$Id: dpd.php,v 1.1.1.1.2.1 2007/04/08 07:18:11 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(dp.php,v 1.36 2003/03/09 02:14:35); www.oscommerce.com
(c) 2003	    nextcommerce (dp.php,v 1.12 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:
Deutscher Paketdienst         	Autor:	Copyright (C) 2004 Manfred Tomanik http://www.st-computer.com


Released under the GNU General Public License
DPD - Modul
---------------------------------------------------------------------------------------*/

class dpd {
	var $code, $title, $description, $icon, $enabled, $num_dpd;


	function dpd() {
		global $order;
		if (!$order)
		{
			$order=new order;
		}
		$order_delivery_country=$order->delivery['country'];

		$this->code = 'dpd';
		$this->title = MODULE_SHIPPING_DPD_TEXT_TITLE;
		$this->description = MODULE_SHIPPING_DPD_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_SHIPPING_DPD_SORT_ORDER;
		$this->icon = DIR_WS_ICONS . 'shipping_dpd.gif';
		$this->tax_class = MODULE_SHIPPING_DPD_TAX_CLASS;
		$this->enabled = ((strtolower(MODULE_SHIPPING_DPD_STATUS) == TRUE_STRING_S) ? true : false);

		if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_DPD_ZONE > 0) ) {
			$check_flag = false;
			$check_query = olc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . "
			where geo_zone_id = '" . MODULE_SHIPPING_DPD_ZONE . "'
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

		/**
 * CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
 */
		$this->num_dpd = 12;
	}

 /*
 *
 * class methods
 *
 */
	function get_track_url()
	{
    //$track_url=URL used for tracking;

    // An der Stelle der Tracking URL, an der der Sendungscode steht, muss '#track_code#' als Platzhalter stehen!
    // An der Stelle der Tracking URL, an der die PLZ steht, muss '#post_code#' als Platzhalter stehen!

    //Beispiel Deutsche Post AG/DHL

    //$track_url='http://nolp.dhl.de/nextt-online-public/set_identcodes.do?lang=de&zip=#post_code#&idc=#track_code#';
		return $track_url;
	}

	function quote($method = '') {
		global $order, $shipping_weight, $shipping_num_boxes;

		if (!$order)
		{
			$order=new order;
		}
		if (!$shipping_weight)
		{
			$shipping_weight=$_SESSION['cart']->show_weight();
		}
		$order_delivery_country=$order->delivery['country'];
		$dest_country = $order_delivery_country['iso_code_2'];

		$dest_zone = 0;
		$error = false;

		for ($i=1; $i<=$this->num_dpd; $i++) {
			$countries_table = constant('MODULE_SHIPPING_DPD_COUNTRIES_' . $i);
			$country_zones = split("[,]", $countries_table);
			if (in_array($dest_country, $country_zones)) {
				$dest_zone = $i;
				break;
			}
		}

		if ($dest_zone == 0) {
			$error = true;
		} else {
			$shipping = -1;
			$dpd_cost = constant('MODULE_SHIPPING_DPD_COST_' . $i);

			$dpd_table = split("[:,]" , $dpd_cost);
			for ($i=0; $i<sizeof($dpd_table); $i+=2) {
				if ($shipping_weight <= $dpd_table[$i]) {
					$shipping = $dpd_table[$i+1];
					$shipping_method = MODULE_SHIPPING_DPD_TEXT_WAY . BLANK . $order_delivery_country['title'] . ': ';
					break;
				}
			}

			if ($shipping == -1) {
				$shipping_cost = 0;
				$shipping_method = MODULE_SHIPPING_DPD_UNDEFINED_RATE;
			} else {
				$shipping_cost = ($shipping + MODULE_SHIPPING_DPD_HANDLING);
			}
		}

		$this->quotes = array('id' => $this->code,
		'module' => MODULE_SHIPPING_DPD_TEXT_TITLE,
		'methods' => array(array('id' => $this->code,
		'title' => $shipping_method . LPAREN . $shipping_num_boxes . ' x ' .
		number_format($shipping_weight,CURRENCY_DECIMAL_PLACES,CURRENCY_DECIMAL_POINT,CURRENCY_THOUSANDS_POINT).
		BLANK . MODULE_SHIPPING_DPD_TEXT_UNITS .RPAREN,
		'cost' => $shipping_cost * $shipping_num_boxes)));

		if ($this->tax_class > 0) {
			$this->quotes['tax'] = olc_get_tax_rate($this->tax_class, $order_delivery_country['id'], $order->delivery['zone_id']);
		}

		if (olc_not_null($this->icon)) $this->quotes['icon'] = olc_image($this->icon, $this->title);

		if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_DPD_INVALID_ZONE;

		return $this->quotes;
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_DPD_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DPD_STATUS', 'true', '6', '0', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_HANDLING', '0', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_DPD_TAX_CLASS', '0', '6', '0', 'olc_get_tax_class_title', 'olc_cfg_pull_down_tax_classes(', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_DPD_ZONE', '0', '6', '0', 'olc_get_zone_class_title', 'olc_cfg_pull_down_zone_classes(', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_SORT_ORDER', '0', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_ALLOWED', '', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COUNTRIES_1', 'DE', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COST_1', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COUNTRIES_2', 'DE', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COST_2', '', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COUNTRIES_3', '', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COST_3', '', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COUNTRIES_4', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COST_4', '', '6', '0', now())");



		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COUNTRIES_5', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COST_5', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COUNTRIES_6', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COST_6', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COUNTRIES_7', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COST_7', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COUNTRIES_8', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COST_8', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COUNTRIES_9', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COST_9', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COUNTRIES_10', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COST_10', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COUNTRIES_11', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COST_11', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COUNTRIES_12', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DPD_COST_12', '', '6', '0', now())");


	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}

	function keys() {
		$keys = array('MODULE_SHIPPING_DPD_STATUS', 'MODULE_SHIPPING_DPD_HANDLING','MODULE_SHIPPING_DPD_ALLOWED', 'MODULE_SHIPPING_DPD_TAX_CLASS', 'MODULE_SHIPPING_DPD_ZONE', 'MODULE_SHIPPING_DPD_SORT_ORDER');

		for ($i = 1; $i <= $this->num_dpd; $i ++) {
			$keys[count($keys)] = 'MODULE_SHIPPING_DPD_COUNTRIES_' . $i;
			$keys[count($keys)] = 'MODULE_SHIPPING_DPD_COST_' . $i;
		}

		return $keys;
	}
}
?>
