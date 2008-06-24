<?php
/* -----------------------------------------------------------------------------------------
$Id: currencies.php,v 1.1.1.1.2.1 2007/04/08 07:17:46 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(currencies.php,v 1.15 2003/03/17); www.oscommerce.com
(c) 2003	    nextcommerce (currencies.php,v 1.9 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

if (NOT_IS_ADMIN_FUNCTION)
{
	// include needed functions
	require_once(DIR_FS_INC.'olc_round.inc.php');
}
////
// Class to handle currencies
// TABLES: currencies
class currencies
{
	var $currencies;

	var $title_text;
	var $symbol_left_text;
	var $symbol_right_text;
	var $decimal_point_text;
	var $thousands_point_text;
	var $decimal_places_text;
	var $decimal_zeroes_text;
	var $decimal_zeroes_dashes_text;
	var $value_text;

	// class constructor
	function currencies() {
		$this->title_text='title';
		$this->symbol_left_text='symbol_left';
		$this->symbol_right_text='symbol_right';
		$this->decimal_point_text='decimal_point';
		$this->thousands_point_text='thousands_point';
		$this->decimal_places_text='decimal_places';
		$this->decimal_zeroes_text='decimal_zeroes';
		$this->decimal_zeroes_dashes_text='decimal_zeroes_dashes';
		$this->value_text='value';
		$this->currencies = array();
		$currencies_query = olc_db_query("select code, title, symbol_left, symbol_right, decimal_point,
		thousands_point, decimal_places, value from " . TABLE_CURRENCIES);
		while ($currencies = olc_db_fetch_array($currencies_query))
		{
			$dpo=$currencies[$this->decimal_point_text];
			$dpl=$currencies[$this->decimal_places_text];
			$this->currencies[$currencies['code']] = array(
			$this->title_text => $currencies[$this->title_text],
			$this->symbol_left_text => $currencies[$this->symbol_left_text],
			$this->symbol_right_text => $currencies[$this->symbol_right_text],
			$this->decimal_point_text => $dpo,
			$this->thousands_point_text => $currencies[$this->thousands_point_text],
			$this->decimal_places_text => $dpl,
			$this->decimal_zeroes_text => $dpo.str_pad(EMPTY_STRING, $dpl ,'0'),
			//$this->decimal_zeroes_dashes_text => $dpo.'<strike>&nbsp;&nbsp;</strike>',
			$this->decimal_zeroes_dashes_text => $dpo.HTML_MDASH,
			$this->value_text => $currencies[$this->value_text]);
		}
	}

	// class methods
	function format($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {

		if (empty($currency_type)) $currency_type = SESSION_CURRENCY;
		$currency=$this->currencies[$currency_type];
		if ($calculate_currency_value == true) {
			$rate = (olc_not_null($currency_value)) ? $currency_value : $currency['value'];
			$format_string = $currency[$this->symbol_left_text] . BLANK .
			number_format(olc_round($number * $rate,
			$currency[$this->decimal_places_text]),
			$currency[$this->decimal_places_text],
			$currency[$this->decimal_point_text],
			$currency[$this->thousands_point_text]) . BLANK. $currency[$this->symbol_right_text];
			// if the selected currency is in the european euro-conversion and the default currency is euro,
			// the currency will displayed in the national currency and euro currency
			if ((DEFAULT_CURRENCY == 'EUR'))
			{
				if (strpos('.DEM.BEF.LUF.ESP.FRF.IEP.ITL.NLG.ATS.PTE.FIM.GRD',$currency_type )>0)
				{
					$format_string .= ' <small>[' . $this->format($number, true, 'EUR') . ']</small>';
				}
			}
		} else {
			$format_string = $currency[$this->symbol_left_text] . BLANK.
			number_format(olc_round($number, $currency[$this->decimal_places_text]),
			$currency[$this->decimal_places_text],
			$currency[$this->decimal_point_text],
			$currency[$this->thousands_point_text]) . BLANK.$currency[$this->symbol_right_text];
		}
		$format_string=str_replace($currency[$this->decimal_zeroes_text],
		$currency[$this->decimal_zeroes_dashes_text],$format_string);
		return trim($format_string);
	}

	function get_value($code) {
		return $this->currencies[$code]['value'];
	}

	function get_decimal_places($code) {
		return $this->currencies[$code][$this->decimal_places_text];
	}

	function display_price($products_price, $products_tax, $quantity = 1) {
		return $this->format(olc_add_tax($products_price, $products_tax) * $quantity);
	}
}
?>