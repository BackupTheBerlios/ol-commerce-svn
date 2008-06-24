<?php
/* -----------------------------------------------------------------------------------------
$Id: freeamountausl.php,v 1.1.1.1.2.1 2007/04/08 07:18:11 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(freeamount.php,v 1.01 2002/01/24); www.oscommerce.com
(c) 2003	    nextcommerce (freeamount.php,v 1.12 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License

versandkostenfrei         	Autor:	Manfred Tomanik http://www.st-computer.com
---------------------------------------------------------------------------------------*/


class freeamountausl {
	var $code, $title, $description, $icon, $enabled;


	function freeamountausl() {
		$this->code = 'freeamountausl';
		$this->title = MODULE_SHIPPING_FREECOUNTAUSL_TEXT_TITLE;
		$this->description = MODULE_SHIPPING_FREECOUNTAUSL_TEXT_DESCRIPTION;
		$this->icon ='';   // change $this->icon =  DIR_WS_ICONS . 'shipping_ups.gif'; to some freeshipping icon
		$this->sort_order = MODULE_SHIPPING_FREECOUNTAUSL_SORT_ORDER;
		$this->enabled = MODULE_SHIPPING_FREECOUNTAUSL_STATUS;
	}

	function quote($method = '') {

		if (( $_SESSION['cart']->show_total() < MODULE_SHIPPING_FREECOUNTAUSL_AMOUNT ) && MODULE_SHIPPING_FREECOUNTAUSL_DISPLAY == FALSE_STRING_L)
		return;

		$this->quotes = array('id' => $this->code,
		'module' => MODULE_SHIPPING_FREECOUNTAUSL_TEXT_TITLE);

		if ( $_SESSION['cart']->show_total() < MODULE_SHIPPING_FREECOUNTAUSL_AMOUNT )
		$this->quotes['error'] = MODULE_SHIPPING_FREECOUNTAUSL_TEXT_WAY;
		else
		$this->quotes['methods'] = array(array('id'    => $this->code,
		'title' => MODULE_SHIPPING_FREECOUNTAUSL_TEXT_WAY,
		'cost'  => 0));

		if (olc_not_null($this->icon)) $this->quotes['icon'] = olc_image($this->icon, $this->title);

		return $this->quotes;
	}

	function check() {
		$check = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_FREECOUNTAUSL_STATUS'");
		$check = olc_db_num_rows($check);

		return $check;
	}

	function install() {
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_FREECOUNTAUSL_STATUS', 'true', '6', '7', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_FREEAMOUNTAUSL_ALLOWED', '', '6', '0', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_FREECOUNTAUSL_DISPLAY', 'true', '6', '7', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_FREECOUNTAUSL_AMOUNT', '50.00', '6', '8', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_FREECOUNTAUSL_SORT_ORDER', '0', '6', '4', now())");
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}

	function keys() {
		return array('MODULE_SHIPPING_FREECOUNTAUSL_STATUS','MODULE_SHIPPING_FREEAMOUNTAUSL_ALLOWED', 'MODULE_SHIPPING_FREECOUNTAUSL_DISPLAY', 'MODULE_SHIPPING_FREECOUNTAUSL_AMOUNT','MODULE_SHIPPING_FREECOUNTAUSL_SORT_ORDER');
	}
}
?>
