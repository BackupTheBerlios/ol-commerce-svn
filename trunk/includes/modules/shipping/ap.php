<?php
/* -----------------------------------------------------------------------------------------
$Id: ap.php,v 1.1.1.1.2.1 2007/04/08 07:18:10 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(ap.php,v 1.05 2003/02/18); www.oscommerce.com
(c) 2003	    nextcommerce (ap.php,v 1.11 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:
austrian_post_1.05       	Autor:	Copyright (C) 2002 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers | http://www.themedia.at & http://www.oscommerce.at
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

class ap {
	var $code, $title, $description, $icon, $enabled, $num_ap;

	/**
 * class constructor
 */
	function ap()
	{
		global $order;

		if (!$order)
		{
			include_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES.'order.php');
			$order=new order;
		}
		$order_delivery_country=$order->delivery['country'];
		$this->code = 'ap';
		$this->title = MODULE_SHIPPING_AP_TEXT_TITLE;
		$this->description = MODULE_SHIPPING_AP_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_SHIPPING_AP_SORT_ORDER;
		$this->icon = DIR_WS_ICONS . 'shipping_ap.gif';
		$this->tax_class = MODULE_SHIPPING_AP_TAX_CLASS;
		$this->enabled = ((strtolower(MODULE_SHIPPING_AP_STATUS) == TRUE_STRING_S) ? true : false);

		if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_AP_ZONE > 0) )
		{
			$check_flag = false;
			$check_query = olc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . "
			where geo_zone_id = '" . MODULE_SHIPPING_AP_ZONE . "'
			and zone_country_id = '" . $order_delivery_country['id'] . "' order by zone_id");
			while ($check = olc_db_fetch_array($check_query))
			{
				$zone_id=$check['zone_id'];
				if ($zone_id < 1)
				{
					$check_flag = true;
					break;
				}
				elseif ($zone_id == $order->delivery['zone_id'])
				{
					$check_flag = true;
					break;
				}
			}

			if ($check_flag == false)
			{
				$this->enabled = false;
			}
		}

		/**
 * CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
 */
		$this->num_ap = 8;
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

		for ($i=1; $i<=$this->num_ap; $i++) {
			$countries_table = constant('MODULE_SHIPPING_AP_COUNTRIES_' . $i);
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
			$ap_cost = constant('MODULE_SHIPPING_AP_COST_' . $i);

			$ap_table = split("[:,]" , $ap_cost);
			for ($i=0; $i<sizeof($ap_table); $i+=2) {
				if ($shipping_weight <= $ap_table[$i]) {
					$shipping = $ap_table[$i+1];
					$shipping_method = MODULE_SHIPPING_AP_TEXT_WAY . BLANK . $order_delivery_country['title'] . ': ' .
					number_format($shipping_weight,CURRENCY_DECIMAL_PLACES,CURRENCY_DECIMAL_POINT,CURRENCY_THOUSANDS_POINT).
					BLANK . MODULE_SHIPPING_AP_TEXT_UNITS;
					break;
				}
			}

			if ($shipping == -1) {
				$shipping_cost = 0;
				$shipping_method = MODULE_SHIPPING_AP_UNDEFINED_RATE;
			} else {
				$shipping_cost = ($shipping + MODULE_SHIPPING_AP_HANDLING);
			}
		}

		$this->quotes = array('id' => $this->code,
		'module' => MODULE_SHIPPING_AP_TEXT_TITLE,
		'methods' => array(array('id' => $this->code,
		'title' => $shipping_method . LPAREN . $shipping_num_boxes . ' x ' . $shipping_weight . BLANK . MODULE_SHIPPING_AP_TEXT_UNITS .RPAREN,
		'cost' => $shipping_cost * $shipping_num_boxes)));

		if ($this->tax_class > 0) {
			$this->quotes['tax'] = olc_get_tax_rate($this->tax_class, $order_delivery_country['id'], $order->delivery['zone_id']);
		}

		if (olc_not_null($this->icon))
		{
			$this->quotes['icon'] = olc_image(ADMIN_PATH_PREFIX.$this->icon, $this->title);
		}

		if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_AP_INVALID_ZONE;

		return $this->quotes;
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_AP_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install()
	{
		$insert=INSERT_INTO.TABLE_CONFIGURATION."(configuration_key,configuration_value,configuration_group_id,sort_order,";
		$date_added="date_added) values ('MODULE_SHIPPING_AP_";
		$insert_date_added=$insert.$date_added;
		$insert_set_date_added=$insert."set_function, ".$date_added;
		$insert_use_set_date_added=$insert."use_function, set_function, ".$date_added;
		olc_db_query($insert_set_date_added."STATUS', 'true', '6', '0', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		olc_db_query($insert_date_added."HANDLING', '0', '6', '0', now())");
		olc_db_query($insert_use_set_date_added."TAX_CLASS', '0', '6', '0', 'olc_get_tax_class_title', 'olc_cfg_pull_down_tax_classes(', now())");
		olc_db_query($insert_use_set_date_added."ZONE', '0', '6', '0', 'olc_get_zone_class_title', 'olc_cfg_pull_down_zone_classes(', now())");
		olc_db_query($insert_date_added."SORT_ORDER', '0', '6', '0', now())");
		olc_db_query($insert_date_added."ALLOWED', '', '6', '0', now())");

		olc_db_query($insert_date_added."COUNTRIES_1', 'DE,IT,SM', '6', '0', now())");
		olc_db_query($insert_date_added."COST_1', '1:12.35,2:13.80,3:15.25,4:16.70,5:18.15,6:19.60,7:21.05,8:22.50,9:23.95,10:25.40,11:26.85,12:28.30,13:29.75,14:31.20,15:32.65,16:34.10,17:35.55,18:37.00,19:38.45,20:39.90', '6', '0', now())");
		olc_db_query($insert_date_added."COUNTRIES_2', 'AD,BE,DK,FO,GL,FI,FR,GR,GB,IE,LI,LU,MC,NL,PT,SE,CH,SK,SI,ES,CZ,HU,VA', '6', '0', now())");
		olc_db_query($insert_date_added."COST_2', '1:13.08,2:15.26,3:17.44,4:19.62,5:21.80,6:23.98,7:26.16,8:28.34,9:30.52,10:32.70,11:34.88,12:37.06,13:39.24,14:41.42,15:43.60,16:45.78,17:47.96,18:50.14,19:52.32,20:54.50', '6', '0', now())");
		olc_db_query($insert_date_added."COUNTRIES_3', 'EG,AL,DZ,AM,AZ,BA,BG,EE,GE,GI,IS,IL,YU,HR,LV,LB,LY,LT,MT,MA,MK,MD,NO,PL,RO,RU,SY,TN,TR,UA,CY', '6', '0', now())");
		olc_db_query($insert_date_added."COST_3', '1:14.53,2:18.16,3:21.79,4:25.42,5:29.05,6:32.68,7:36.31,8:39.94,9:43.57,10:47.20,11:50.83,12:54.46,13:58.09,14:61.72,15:65.35,16:68.98,17:72.61,18:76.24,19:79.87,20:83.50', '6', '0', now())");
		olc_db_query($insert_date_added."COUNTRIES_4', 'ET,BH,BJ,BF,CI,DJ,ER,GM,GH,GU,GN,GW,IQ,IR,YE,JO,CM,CA,CV,KZ,QA,KG,KW,LR,ML,MH,MR,FM,NE,NG,MP,OM,PR,SA,SN,SL,SO,SD,TJ,TG,TD,TM,UZ,AE,US,UM,CF', '6', '0', now())");
		olc_db_query($insert_date_added."COST_4', '1:17.44,2:23.98,3:30.52,4:37.06,5:43.60,6:50.14,7:56.68,8:63.22,9:69.76,10:76.30,11:82.84,12:89.38,13:95.92,14:102.46,15:109.00,16:115.54,17:122.08,18:128.62,19:135.16,20:141.70', '6', '0', now())");
		olc_db_query($insert_date_added."COUNTRIES_5', 'AF,AO,AI,AG,GQ,AR,BS,BD,BB,BZ,BM,BT,BO,BW,BR,BN,BI,KY,CL,CN,CR,DM,DO,EC,SV,FK,GF,GA,GD,GP,GT,GY,HT,HN,HK,IN,id,TP,JM,JP,KH,KE,CO,KM,CG,KP,KR,CU,LA,LS', '6', '0', now())");
		olc_db_query($insert_date_added."COST_5', '1:19.62,2:28.34,3:37.06,4:45.78,5:54.50,6:63.22,7:71.94,8:80.66,9:89.38,10:98.10,11:106.82,12:115.54,13:124.26,14:132.98,15:141.70,16:150.42,17:159.14,18:167.86,19:176.58,20:185.30', '6', '0', now())");
		olc_db_query($insert_date_added."COUNTRIES_6', 'MO,MG,MW,MY,MV,MQ,MU,MX,MN,MS,MZ,MM,NA,NP,NI,AN,AW,PK,PA,PY,PE,PH,RE,RW,ZM,ST,SC,ZW,SG,LK,KN,LC,PM,VC,ZA,SR,SZ,TZ,TH,TT,TC,UG,UY,VE,VN,VG', '6', '0', now())");
		olc_db_query($insert_date_added."COST_6', '1:19.62,2:28.34,3:37.06,4:45.78,5:54.50,6:63.22,7:71.94,8:80.66,9:89.38,10:98.10,11:106.82,12:115.54,13:124.26,14:132.98,15:141.70,16:150.42,17:159.14,18:167.86,19:176.58,20:185.30', '6', '0', now())");
		olc_db_query($insert_date_added."COUNTRIES_7', 'AU,CK,FJ,PF,KI,NR,NC,NZ,PG,PN,SB,TO,TV,VU,WF,WS', '6', '0', now())");
		olc_db_query($insert_date_added."COST_7', '1:23.98,2:37.06,3:50.14,4:63.22,5:76.30,6:89.38,7:102.46,8:115.54,9:128.62,10:141.70,11:154.78,12:167.86,13:180.94,14:194.02,15:207.10,16:220.18,17:233.26,18:246.34,19:259.42,20:272.50', '6', '0', now())");
		olc_db_query($insert_date_added."COUNTRIES_8', 'AT', '6', '0', now())");
		olc_db_query($insert_date_added."COST_8', '2:3.56,4:4.36,8:5.45,12:6.90,20:9.08,31.5:12.72', '6', '0', now())");
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION .
			" where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}

	function keys() {
		$keys = array('MODULE_SHIPPING_AP_STATUS', 'MODULE_SHIPPING_AP_HANDLING','MODULE_SHIPPING_AP_ALLOWED', 'MODULE_SHIPPING_AP_TAX_CLASS', 'MODULE_SHIPPING_AP_ZONE', 'MODULE_SHIPPING_AP_SORT_ORDER');

		for ($i = 1; $i <= $this->num_ap; $i ++) {
			$keys[count($keys)] = 'MODULE_SHIPPING_AP_COUNTRIES_' . $i;
			$keys[count($keys)] = 'MODULE_SHIPPING_AP_COST_' . $i;
		}

		return $keys;
	}
}
?>
