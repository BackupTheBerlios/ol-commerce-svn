<?php
/* -----------------------------------------------------------------------------------------
$Id: ups.php,v 1.1.1.1.2.1 2007/04/08 07:18:12 gswkaiser Exp $

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
UPS Standard         	Autor:	Copyright (C) 2004 Manfred Tomanik www.st-computer.com
Released under the GNU General Public License
UPS - Standard
---------------------------------------------------------------------------------------*/




class ups {
	var $code, $title, $description, $icon, $enabled, $num_ups;

	function ups() {
		global $order;
		if (!$order)
		{
			include_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES.'order.php');
			$order=new order;
		}
		$order_delivery_country=$order->delivery['country'];

		$this->code = 'ups';
		$this->title = MODULE_SHIPPING_UPS_TEXT_TITLE;
		$this->description = MODULE_SHIPPING_UPS_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_SHIPPING_UPS_SORT_ORDER;
		$this->icon = DIR_WS_ICONS . 'shipping_ups.gif';
		$this->tax_class = MODULE_SHIPPING_UPS_TAX_CLASS;
		$this->enabled = ((strtolower(MODULE_SHIPPING_UPS_STATUS) == TRUE_STRING_S) ? true : false);

		if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_UPS_ZONE > 0) ) {
			$check_flag = false;
			$check_query = olc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . "
			where geo_zone_id = '" . MODULE_SHIPPING_UPS_ZONE . "'
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
		$this->num_ups = 7;
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

		for ($i=1; $i<=$this->num_ups; $i++) {
			$countries_table = constant('MODULE_SHIPPING_UPS_COUNTRIES_' . $i);
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
			$ups_cost = constant('MODULE_SHIPPING_UPS_COST_' . $i);

			$ups_table = split("[:,]" , $ups_cost);
			for ($i=0; $i<sizeof($ups_table); $i+=2) {
				if ($shipping_weight <= $ups_table[$i]) {
					$shipping = $ups_table[$i+1];
					$shipping_method = MODULE_SHIPPING_UPS_TEXT_WAY . BLANK . $order_delivery_country['title'] . ': ';
					break;
				}
			}

			if ($shipping == -1) {
				$shipping_cost = 0;
				$shipping_method = MODULE_SHIPPING_UPS_UNDEFINED_RATE;
			} else {
				$shipping_cost = ($shipping + MODULE_SHIPPING_UPS_HANDLING);
			}
		}

		$this->quotes = array('id' => $this->code,
		'module' => MODULE_SHIPPING_UPS_TEXT_TITLE,
		'methods' => array(array('id' => $this->code,
		'title' => $shipping_method . LPAREN . $shipping_num_boxes . ' x ' .
		number_format($shipping_weight,CURRENCY_DECIMAL_PLACES,CURRENCY_DECIMAL_POINT,CURRENCY_THOUSANDS_POINT).
		 BLANK . MODULE_SHIPPING_UPS_TEXT_UNITS .RPAREN,
		'cost' => $shipping_cost * $shipping_num_boxes)));

		if ($this->tax_class > 0) {
			$this->quotes['tax'] = olc_get_tax_rate($this->tax_class, $order_delivery_country['id'], $order->delivery['zone_id']);
		}

		if (olc_not_null($this->icon)) $this->quotes['icon'] = olc_image($this->icon, $this->title);

		if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_UPS_INVALID_ZONE;

		return $this->quotes;
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_UPS_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_UPS_STATUS', 'true', '6', '0', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_HANDLING', '0', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_UPS_TAX_CLASS', '0', '6', '0', 'olc_get_tax_class_title', 'olc_cfg_pull_down_tax_classes(', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_UPS_ZONE', '0', '6', '0', 'olc_get_zone_class_title', 'olc_cfg_pull_down_zone_classes(', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_SORT_ORDER', '0', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_ALLOWED', '', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_COUNTRIES_1', 'DE', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_COST_1', '1:5.15,2:5.15,3:5.15,4:5.15,5:6.25,6:6.25,7:6.25,8:7.30,9:7.30,10:7.30,12:9.95,14:9.95,16:12.00,18:12.00,20:12.00,22:14.30,24:15.50,26:16.70,28:17.90,30:19.10,32:22.80,34:24.40,36:26.00,38:27.60,40:29.20,42:30.25,44:31.30,46:32.35,48:33.40,50:34.45,55:35.50,60:36.55,65:37.60,70:38.65', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_COUNTRIES_2', '', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_COST_2', '', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_COUNTRIES_3', 'BE,BEL,NL,NLD,', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_COST_3', '1:13.75,2:13.75,3:13.75,4:13.75,5:15.40,6:15.40,7:15.40,8:17.05,9:17.05,10:17.05,12:18.70,14:18.70,16:23.50,18:23.50,20:23.50,22:25.20,24:26.90,26:28.60,28:30.30,30:32.00,32:34.20,34:36.40,36:38.60,38:40.80,40:43.00,42:45.20,44:47.40,46:49.60,48:51.80,50:57.30,55:62.80,60:68.30,65:73.80,70:79.30', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_COUNTRIES_4', 'AT,AUT,DK,DNK,FI,FIN,FR,FRA,MC,MCO,SE,SWE,GB,GBR', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_COST_4', '1:25.40,2:25.40,3:25.40,4:25.40,5:27.05,6:27.05,7:27.05,8:28.70,9:28.70,10:28.70,12:30.85,14:30.85,16:37.00,18:37.00,20:37.00,22:39.70,24:42.40,26:45.10,28:47.80,30:50.50,32:54.00,34:56.70,36:59.40,38:62.10,40:64.80,42:69.60,44:74.40,46:79.20,48:84.00,50:88.80,55:97.30,60:105.80,65:114.30,70:122.80', '6', '0', now())");



		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_COUNTRIES_5', 'GR,GRC,IE,IRL,IT,ITA,NI,NIC,PT,PRT,ES,ESP', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_COST_5', '1:34.35,2:34.35,3:34.35,4:34.35,5:36.00,6:36.00,7:36.00,8:37.65,9:37.65,10:37.65,12:41.90,14:41.90,16:50.85,18:50.85,20:50.85,22:54.05,24:57.25,26:60.45,28:63.65,30:66.85,32:70.70,34:74.55,36:78.40,38:82.25,40:86.10,42:90.40,44:94.70,46:99.00,48:103.30,50:107.60,55:117.05,60:126.50,65:133.95,70:141.40', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_COUNTRIES_6', 'AD,AND,LI,LIE,NO,NOR,SM,SMR,CH,CHE', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_COST_6', '1:37.10,2:37.10,3:37.10,4:37.10,5:38.70,6:38.70,7:38.70,8:40.30,9:40.30,10:40.30,12:44.60,14:44.60,16:56.60,18:56.60,20:56.60,22:61.10,24:65.60,26:70.10,28:74.60,30:79.10,32:83.90,34:88.70,36:93.50,38:98.30,40:103.10,42:106.10,44:109.10,46:112.10,48:115.10,50:118.10,55:124.10,60:130.10,65:136.10,70:142.10', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_COUNTRIES_7', 'CZ,CZE,HU,HUN,PL,POL,SK,SVK', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPS_COST_7', '1:58.00,2:58.00,3:58.00,4:58.00,5:61.25,6:61.25,7:61.25,8:64.50,9:64.50,10:64.50,12:68.75,14:68.75,16:82.00,18:82.00,20:82.00,22:86.30,24:90.60,26:94.90,28:99.20,30:103.50,32:107.80,34:112.10,36:119.80,38:121.80,40:123.80,42:125.80,44:127.80,46:129.80,48:131.80,50:133.80,55:138.30,60:142.80,65:147.30,70:151.80', '6', '0', now())");
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}

	function keys() {
		$keys = array('MODULE_SHIPPING_UPS_STATUS', 'MODULE_SHIPPING_UPS_HANDLING','MODULE_SHIPPING_UPS_ALLOWED', 'MODULE_SHIPPING_UPS_TAX_CLASS', 'MODULE_SHIPPING_UPS_ZONE', 'MODULE_SHIPPING_UPS_SORT_ORDER');

		for ($i = 1; $i <= $this->num_ups; $i ++) {
			$keys[count($keys)] = 'MODULE_SHIPPING_UPS_COUNTRIES_' . $i;
			$keys[count($keys)] = 'MODULE_SHIPPING_UPS_COST_' . $i;
		}

		return $keys;
	}
}
?>
