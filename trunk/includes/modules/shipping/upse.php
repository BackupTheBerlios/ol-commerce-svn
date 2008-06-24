<?php
/* -----------------------------------------------------------------------------------------
$Id: upse.php,v 1.1.1.1.2.1 2007/04/08 07:18:12 gswkaiser Exp $

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
UPS - Express
---------------------------------------------------------------------------------------*/




class upse {
	var $code, $title, $description, $icon, $enabled, $num_upse;

	function upse()
	{
		global $order;

		if (!$order)
		{
			include_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES.'order.php');
			$order=new order;
		}
		$order_delivery_country=$order->delivery['country'];

		$this->code = 'upse';
		$this->title = MODULE_SHIPPING_UPSE_TEXT_TITLE;
		$this->description = MODULE_SHIPPING_UPSE_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_SHIPPING_UPSE_SORT_ORDER;
		$this->icon = DIR_WS_ICONS . 'shipping_ups.gif';
		$this->tax_class = MODULE_SHIPPING_UPSE_TAX_CLASS;
		$this->enabled = ((strtolower(MODULE_SHIPPING_UPSE_STATUS) == TRUE_STRING_S) ? true : false);

		if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_UPSE_ZONE > 0) ) {
			$check_flag = false;
			$check_query = olc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . "
			where geo_zone_id = '" . MODULE_SHIPPING_UPSE_ZONE . "'
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
		$this->num_upse = 12;
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

		for ($i=1; $i<=$this->num_upse; $i++) {
			$countries_table = constant('MODULE_SHIPPING_UPSE_COUNTRIES_' . $i);
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
			$upse_cost = constant('MODULE_SHIPPING_UPSE_COST_' . $i);

			$upse_table = split("[:,]" , $upse_cost);
			for ($i=0; $i<sizeof($upse_table); $i+=2) {
				if ($shipping_weight <= $upse_table[$i]) {
					$shipping = $upse_table[$i+1];
					$shipping_method = MODULE_SHIPPING_UPSE_TEXT_WAY . BLANK . $order_delivery_country['title'] . ': ';
					break;
				}
			}

			if ($shipping == -1) {
				$shipping_cost = 0;
				$shipping_method = MODULE_SHIPPING_UPSE_UNDEFINED_RATE;
			} else {
				$shipping_cost = ($shipping + MODULE_SHIPPING_UPSE_HANDLING);
			}
		}

		$this->quotes = array('id' => $this->code,
		'module' => MODULE_SHIPPING_UPSE_TEXT_TITLE,
		'methods' => array(array('id' => $this->code,
		'title' => $shipping_method . LPAREN . $shipping_num_boxes . ' x ' .
		number_format($shipping_weight,CURRENCY_DECIMAL_PLACES,CURRENCY_DECIMAL_POINT,CURRENCY_THOUSANDS_POINT).
		 BLANK . MODULE_SHIPPING_UPSE_TEXT_UNITS .RPAREN,
		'cost' => $shipping_cost * $shipping_num_boxes)));

		if ($this->tax_class > 0) {
			$this->quotes['tax'] = olc_get_tax_rate($this->tax_class, $order_delivery_country['id'], $order->delivery['zone_id']);
		}

		if (olc_not_null($this->icon)) $this->quotes['icon'] = olc_image($this->icon, $this->title);

		if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_UPSE_INVALID_ZONE;

		return $this->quotes;
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_UPSE_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_UPSE_STATUS', 'true', '6', '0', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_HANDLING', '0', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_UPSE_TAX_CLASS', '0', '6', '0', 'olc_get_tax_class_title', 'olc_cfg_pull_down_tax_classes(', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_UPSE_ZONE', '0', '6', '0', 'olc_get_zone_class_title', 'olc_cfg_pull_down_zone_classes(', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_SORT_ORDER', '0', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_ALLOWED', '', '6', '0', now())");


		/*  UPS Express

		*/

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COUNTRIES_1', 'DE', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COST_1', '0.5:22.70,1:22.85,1.5:23.00,2:23.15,2.5:23.30,3:23.45,3.5:23.60,4:23.75,4.5:23.90,5:24.05,5.5:24.20,6:24.35,6.5:24.50,7:24.65,7.5:24.80,8:24.95,8.5:25.10,9:25.25,9.5:25.40,10:25.55,11:26.65,12:27.75,13:28.85,14:29.95,15:31.05,16:32.15,17:33.25,18:34.35,19:35.45,20:36.55,22:39.45,24:42.35,26:45.25,28:48.15,30:51.05,35:53.95,40:56.85,45:59.75,50:62.65,55:65.55,60:68.45,65:71.35,70:74.25', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COUNTRIES_2', 'BE,BEL,FR,FRA,LU,LUX,NL,NLD', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COST_2', '0.5:51.55,1:53.50,1.5:55.45,2:57.40,2.5:59.35,3:61.30,3.5:63.25,4:65.20,4.5:67.15,5:69.10,5.5:71.05,6:73.00,6.5:74.95,7:76.90,7.5:78.85,8:80.80,8.5:82.75,9:84.70,9.5:86.65,10:88.60,11:92.10,12:95.60,13:99.10,14:102.60,15:106.10,16:109.60,17:113.10,18:116.60,19:120.10,20:123.60,22:129.60,24:135.60,26:141.60,28:147.60,30:153.60,35:167.60,40:181.60,45:195.60,50:209.60,55:223.60,60:237.60,65:251.60,70:265.60', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COUNTRIES_3', 'DK,DNK,IT,ITA,MC,MCO,GB,GBR', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COST_3', '0.5:60.70,1:65.00,1.5:69.30,2:73.60,2.5:77.90,3:81.70,3.5:85.50,4:89.30,4.5:93.10,5:96.90,5.5:100.70,6:104.50,6.5:108.30,7:112.10,7.5:115.90,8:119.70,8.5:123,50,9:127.30,9.5:131.10,10:134.90,11:138.90,12:142.90,13:146.90,14:150.90,15:154.90,16:158.90,17:162.90,18:168.90,19:170.90,20:174.90,22:184.35,24:193.80,26:203.25,28:212.70,30:222.15,35:238.55,40:254.95,45:271.35,50:287.75,55:304.15,60:320.55,65:336.95,70:353.35', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COUNTRIES_4', 'AT,AUT,FI,FIN,GR,GRC,IE,IRL,PT,PRT,ES,ESP,SE,SWE', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COST_4', '0.5:66.90,1:72.40,1.5:77.90,2:83.40,2.5:88.90,3:93.25,3.5:97.60,4:101.95,4.5:106.30,5:110.65,5.5:115.00,6:119.35,6.5:123.70,7:128.05,7.5:132.40,8:136.75,8.5:141.10,9:145.45,9.5:149.80,10:154.15,11:158.50,12:163.20,13:167.90,14:172.60,15:177.30,16:182.00,17:186.70,18:191.40,19:196.10,20:200.80,22:212.85,24:224.90,26:236.95,28:249.00,30:261.05,35:281.15,40:301.25,45:321.35,50:341.45,55:361.55,60:381.65,65:401.75,70:421.85', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COUNTRIES_5', 'AD,AND,LI,LIE,NO,NOR,SM,SMR,CH,CHE', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COST_5', '0.5:59.00,1:62.90,1.5:66.80,2:70.70,2.5:74.60,3:78.25,3.5:81.90,4:85.55,4.5:89.20,5:92.85,5.5:96.50,6:100.15,6.5:103.80,7:107.45,7.5:111.10,8:114.75,8.5:118.40,9:122.05,9.5:125.70,10:129.35,11:133.35,12:137.35,13:141.35,14:145.35,15:149.35,16:153.35,17:157.35,18:161.35,19:165.35,20:169.35,22:176.85,24:184.35,26:191.85,28:199.35,30:206.85,35:222.35,40:237.85,45:253.35,50:268.85,55:284.35,60:299.85,65:315.35,70:330.85', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COUNTRIES_6', 'AL,ALB,AM,ARM,AZ,AZE,BY,BLR,BA,BIH,BG,BGR,HR,HRV,CY,CYP,CZ,CZE,EE,EST,FO,FRO,GE,GEO,GI,GIB,GL,GRL,HU,HUN,IS,ISL,KZ,KAZ,KG,KGZ,LV,LVA,LT,LTU,MK,MKD.MT,MLT,MD,MDA,PL,POL,RO,ROM,RU,RUS,SK,SVK,SI,SVN,TJ,TJK,TR,TUR,TM,TKM,UA,UKR,UZ,UZB,YU,YUG', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COST_6', '0.5:84.50,1:90.90,1.5:97.30,2:103.70,2.5:110.10,3:115.90,3.5:121.70,4:127.50,4.5:133.30,5:139.10,5.5:144.90,6:150.70,6.5:156.50,7:162.30,7.5:168.10,8:173.90,8.5:179.70,9:185.50,9.5:191.30,10:197.10,11:204.95,12:212.80,13:220.65,14:228.50,15:236.35,16:244.20,17:252.05,18:259.90,19:267.75,20:275.60,22:286.90,24:298.20,26:309.50,28:320.80,30:332.10,35:357.25,40:382.40,45:407.55,50:432.70,55:457.85,60:483.00,65:508.15,70:533.30', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COUNTRIES_7', 'CA,CAN,US,USA', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COST_7', '0.5:71.85,1:77.65,1.5:83.45,2:89.25,2.5:95.05,3:100.85,3.5:106.65,4:112.45,4.5:118.25,5:124.05,5.5:127.50,6:130.95,6.5:134.40,7:137.85,7.5:141.30,8:144.75,8.5:148.20,9:151.65,9.5:155.10,10:158.55,11:163.95,12:169.35,13:174.75,14:180.15,15:185.55,16:190.95,17:196.35,18:201.75,19:207.15,20:212.55,22:223.15,24:233.75,26:244.35,28:254.95,30:265.55,35:288.15,40:310.75,45:333.35,50:355.95,55:378.55,60:401.15,65:423.75,70:446.35', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COUNTRIES_8', 'AI,AIA,AW,ABW,BS,BHS,BM,BMU,KY,CYM,DO,DOM,GD,GRD,GP,GLP,HT,HTI,JM,JAM,MQ,MTQ,MS,MSR,AN,ANT,PR,PRI,TT,TTO,TC,TCA,VG,VGB,VI,VIR', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COST_8', '0.5:80.05,1:87.20,1.5:94.35,2:101.50,2.5:108.65,3:116.35,3.5:124.05,4:131.75,4.5:139.45,5:147.15,5.5:152.20,6:157.25,6.5:162.30,7:167.35,7.5:172.40,8:177.45,8.5:182.50,9:187.55,9.5:192.60,10:197.65,11:207.65,12:217.65,13:227.65,14:237.65,15:247.65,16:257.65,17:267.65,18:277.65,19:287.65,20:297.65,22:311.45,24:325.25,26:339.05,28:352.85,30:366.65,35:393.15,40:419.65,45:446.15,50:472.65,55:499.15,60:525.65,65:552.15,70:578.65', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COUNTRIES_9', 'HK,HKG,JP,JPN,SG,SGP,TW,TWN,TH,THA', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COST_9', '0.5:85.20,1:97.30,1.5:109.40,2:121.50,2.5:133.60,3:145.70,3.5:157.80,4:169.90,4.5:182.00,5:194.10,5.5:200.35,6:206.60,6.5:212.85,7:219.10,7.5:225.35,8:231.60,8.5:237.85,9:244.10,9.5:250.35,10:256.60,11:268.25,12:279.90,13:291.55,14:303.20,15:314.85,16:326.50,17:338.15,18:349.80,19:361.45,20:373.10,22:383.75,24:394.40,26:405.05,28:415.70,30:426.35,35:456.30,40:486.25,45:516.20,50:546.15,55:576.10,60:606.05,65:636.00,70:665.95', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COUNTRIES_10', 'AU,AUS,CH,CHN,IN,IND,id,IDN,KR,KOR,MY,MYS,PH,PHL', '6', '0', now())");


		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COST_10', '0.5:93.10,1:107.75,1.5:122.40,2:137.05,2.5:151.70,3:166.35,3.5:181.00,4:195.65,4.5:210.30,5:224.95,5.5:235.70,6:246.45,6.5:257.20,7:267.95,7.5:278.70,8:289.45,8.5:300.20,9:310.95,9.5:321.70,10:332.45,11:343.20,12:353.95,13:364.70,14:375.45,15:386.20,16:398.95,17:407.70,18:418.45,19:429.20,20:439.95,22:456.35,24:472.75,26:489.15,28:505.55,30:521.95,35:555.25,40:588.55,45:621.85,50:655.15,55:688.45,60:721.75,65:755.05,70:788.35', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COUNTRIES_11', 'AR,ARG,BH,BHR,BZ,BLZ,BR,BRA,CV,CPV,CL,CHL,CO,COL,CR,CRI,EC,ECU,EG,EGY,SV,SLV,HN,HND,IQ,IRQ,IL,ISR,KW,KWT,MO,MAC,NZ,NZL,NG,NGA,OM,OMN,PK,PAK,PA,PAN,PY,PRY,PE,PER,QA,QAT,SA,SAU,ZA,ZAF,AE,ARE,UY,URY,VE,VEN', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COST_11', '0.5:103.50,1:120.90,1.5:138.30,2:155.70,2.5:173.10,3:189.10,3.5:205.10,4:221.10,4.5:237.10,5:253.10,5.5:265.85,6:278.60,6.5:291.35,7:304.10,7.5:316.85,8:329.60,8.5:342.35,9:355.10,9.5:367.85,10:380.60,11:392.10,12:403.60,13:415.10,14:426.60,15:438.10,16:449.60,17:461.10,18:472.60,19:484.10,20:495.60,22:513.45,24:531.30,26:549.15,28:567.00,30:584.85,35:621.85,40:658.85,45:695.85,50:732.85,55:769.85,60:806.85,65:843.85,70:880.85', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COUNTRIES_12', 'AS,ASM,AO,AGO,BD,BGD,BJ,BEN,BW,BWA,BN,BRN,BF,BFA,BI,BDI,KH,KHM,CM,CMR,CF,CAF,TD,TCD,CG,COG,CK,COK,CI,CIV,DJ,DJI,ER,ERI,ET,ETH,FJ,FJI,GF,GUF,PF,PYF,GA,GAB,GM,GMB,GH,GHA,GU,GUM,GT,GTM,GN,GIN,GY,GUY,JO,JOR,KE,KEN,KI,KIR,KP,PRK,LA,LAO,LB,LBN,LS,LSO,MG,MDG,MW,MWI,MV,MDV,ML,MLI,MH,MHL,MR,MRT,MU,MUS,FM,FSM,MA,MAR,MZ,MOZ,NA,NAM,NP,NPL,NC,NCL,NI,NIC,NE,NER,MP,MNP,PW,PLW,PG,PNG,RE,REU,RW,RWA,SN,SEN,SC,SYC,SL,SLE,SB,SLB,LK,LKA,SR,SUR,SZ,SWZ,SY,SYR,TZ,TZA,TG,TGO,TO,TON,TN,TUN,TV,TUV,UG,UGA,VU,VUT,VN,VNM,WF,WLF,YE,YEM,ZM,ZMB,ZW,ZWE', '6', '0', now())");

		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_UPSE_COST_12', '0.5:105.20,1:126.85,1.5:148.50,2:170.15,2.5:191.80,3:209.80,3.5:227.80,4:245.80,4.5:263.80,5:281.80,5.5:298.40,6:311.00,6.5:325.60,7:340.20,7.5:354.80,8:369.40,8.5:384.00,9:398.60,9.5:413.20,10:427.80,11:439.05,12:450.30,13:461.55,14:472.80,15:484.05,16:495.30,17:506.55,18:517.80,19:529.05,20:540.30,22:561.70,24:583.10,26:604.50,28:625.90,30:647.30,35:693.00,40:738.70,45:784.40,50:830.10,55:875.80,60:921.50,65:967.20,70:1012.90', '6', '0', now())");
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}

	function keys() {
		$keys = array('MODULE_SHIPPING_UPSE_STATUS', 'MODULE_SHIPPING_UPSE_HANDLING','MODULE_SHIPPING_UPSE_ALLOWED', 'MODULE_SHIPPING_UPSE_TAX_CLASS', 'MODULE_SHIPPING_UPSE_ZONE', 'MODULE_SHIPPING_UPSE_SORT_ORDER');

		for ($i = 1; $i <= $this->num_upse; $i ++) {
			$keys[count($keys)] = 'MODULE_SHIPPING_UPSE_COUNTRIES_' . $i;
			$keys[count($keys)] = 'MODULE_SHIPPING_UPSE_COST_' . $i;
		}

		return $keys;
	}
}
?>
