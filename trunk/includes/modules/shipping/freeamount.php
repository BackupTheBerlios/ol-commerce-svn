<?php
/* -----------------------------------------------------------------------------------------
$Id: freeamount.php,v 1.1.1.1.2.1 2007/04/08 07:18:11 gswkaiser Exp $

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
---------------------------------------------------------------------------------------*/


class freeamount {
	var $code, $title, $description, $icon, $enabled;


	function freeamount() {
		$this->code = 'freeamount';
		$this->title = MODULE_SHIPPING_FREECOUNT_TEXT_TITLE;
		$this->description = MODULE_SHIPPING_FREECOUNT_TEXT_DESCRIPTION;
		$this->icon ='';   // change $this->icon =  DIR_WS_ICONS . 'shipping_ups.gif'; to some freeshipping icon
		$this->sort_order = MODULE_SHIPPING_FREECOUNT_SORT_ORDER;
		$this->enabled = MODULE_SHIPPING_FREECOUNT_STATUS;
	}

	function quote($method = '')
	{
		// W. Kaiser - Show missing amount for free shipping
		$CurrentAmount = $_SESSION['cart']->show_total();
		//	W. Kaiser - Free shipping national/international
		require_once(DIR_FS_INC.'olc_get_free_shipping_amount.inc.php');
		olc_get_free_shipping_amount();
		if (FREE_AMOUNT>0)
		{
			$MissingAmount = FREE_AMOUNT - $CurrentAmount;
			if ($MissingAmount > 0 && MODULE_SHIPPING_FREECOUNT_DISPLAY == FALSE_STRING_L)
			{
				return;
			}
			//	W. Kaiser - Free shipping national/international

			$this->quotes = array('id' => $this->code, 'module' => MODULE_SHIPPING_FREECOUNT_TEXT_TITLE);
			if ($MissingAmount > 0)
			{
				$this->quotes['error'] = MODULE_SHIPPING_FREECOUNT_TEXT_WAY .
				HTML_B_START . olc_format_price($MissingAmount,1,1,1) . '</b>)';
			}
			else
			{
				$this->quotes['methods'] = array(array('id' => $this->code ,
				'title' => MODULE_SHIPPING_FREECOUNT_TEXT_WAY,
				'cost'  => 0));
				if (olc_not_null($this->icon)) $this->quotes['icon'] = olc_image($this->icon, $this->title);
			}
		}
		return $this->quotes;
		//W. Kaiser - Show missing amount for free shippin
	}

	function check() {
		$check = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION .
		" where configuration_key = 'MODULE_SHIPPING_FREECOUNT_STATUS'");
		$check = olc_db_num_rows($check);
		return $check;
	}

	function install() {
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION .
		" (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values
			('MODULE_SHIPPING_FREECOUNT_STATUS', 'true', '6', '7', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION .
		" (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
			('MODULE_SHIPPING_FREEAMOUNT_ALLOWED', '', '6', '0', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION .
		" (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values
			('MODULE_SHIPPING_FREECOUNT_DISPLAY', 'true', '6', '7', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION .
		" (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
		('MODULE_SHIPPING_FREECOUNT_AMOUNT', '50.00', '6', '8', now())");
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION .
		" (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
			('MODULE_SHIPPING_FREECOUNT_SORT_ORDER', '0', '6', '4', now())");
	}

	function remove() {
		olc_db_query(DELETE_FROM . TABLE_CONFIGURATION .
		" where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}

	function keys() {
		return array('MODULE_SHIPPING_FREECOUNT_STATUS','MODULE_SHIPPING_FREEAMOUNT_ALLOWED',
		'MODULE_SHIPPING_FREECOUNT_DISPLAY', 'MODULE_SHIPPING_FREECOUNT_AMOUNT','MODULE_SHIPPING_FREECOUNT_SORT_ORDER');
	}
}
?>
