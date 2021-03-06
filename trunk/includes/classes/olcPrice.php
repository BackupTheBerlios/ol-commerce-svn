<?php
/* -----------------------------------------------------------------------------------------
$Id: olcPrice.php,v 1.1.1.1.2.1 2007/04/08 07:17:47 gswkaiser Exp $

OL-Commerce Version 1.2
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(currencies.php,v 1.15 2003/03/17); www.oscommerce.com
(c) 2003         nextcommerce (currencies.php,v 1.9 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/


require_once(DIR_FS_INC.'olc_get_qty.inc.php');
require_once(DIR_FS_INC.'olc_get_tax_rate.inc.php');
include_once(DIR_FS_INC.'olc_precision.inc.php');

class olcPrice {
	var $currencies;

	// class constructor
	function olcPrice($currency, $cGroup) {

		$this->currencies = array ();
		$this->cStatus = array ();
		$this->actualGroup = $cGroup;
		$this->actualCurr = $currency;
		$this->TAX = array ();
		$this->SHIPPING = array();
		$this->showFrom_Attributes = true;

		// select Currencies

		$currencies_query = "SELECT * FROM ".TABLE_CURRENCIES;
		$currencies_query = olc_db_query($currencies_query);
		while ($currencies = olc_db_fetch_array($currencies_query, true)) {
			$this->currencies[$currencies['code']] = array ('title' => $currencies['title'], 'symbol_left' => $currencies['symbol_left'], 'symbol_right' => $currencies['symbol_right'], 'decimal_point' => $currencies['decimal_point'], 'thousands_point' => $currencies['thousands_point'], 'decimal_places' => $currencies['decimal_places'], 'value' => $currencies['value']);
		}
		// select Customers Status data
		$customers_status_query = "SELECT *
                                FROM
                                     ".TABLE_CUSTOMERS_STATUS."
                                WHERE
                                     customers_status_id = '".$this->actualGroup."' AND language_id = '".SESSION_LANGUAGE_ID.APOS;
		$customers_status_query = olc_db_query($customers_status_query);
		$customers_status_value = olc_db_fetch_array($customers_status_query, true);
		while (list($key, $value) = each($customers_status_value))
		{
			$this->cStatus[$key]=$value;
		}
		// prefetch tax rates for standard zone
		$zones_query = olc_db_query("SELECT tax_class_id as class FROM ".TABLE_TAX_CLASS);
		while ($zones_data = olc_db_fetch_array($zones_query,true)) {

			// calculate tax based on shipping or deliverey country (for downloads)
			if (isset($_SESSION['billto']) && isset($_SESSION['sendto'])) {
				$tax_address_query = olc_db_query("select ab.entry_country_id, ab.entry_zone_id from " . TABLE_ADDRESS_BOOK .
				" ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) where ab.customers_id = '" .
				$_SESSION['customer_id'] . "' and ab.address_book_id = '" .
				($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto']) . APOS);
				$tax_address = olc_db_fetch_array($tax_address_query);
				$this->TAX[$zones_data['class']]=olc_get_tax_rate($zones_data['class'],$tax_address['entry_country_id'],
				$tax_address['entry_zone_id']);
			} else {
				$this->TAX[$zones_data['class']]=olc_get_tax_rate($zones_data['class']);
			}
		}
	}

	// get products Price
	function olcGetPrice($pID, $format = true, $qty, $tax_class, $pPrice, $vpeStatus = 0, $cedit_id = 0, $show_tax = 0) {

		// check if group is allowed to see prices
		if ($this->cStatus['customers_status_show_price'] == '0')
		return $this->olcShowNote($vpeStatus, $vpeStatus);

		// get Tax rate
		if ($cedit_id != 0) {
			$cinfo = olc_oe_customer_infos($cedit_id);
			$products_tax = olc_get_tax_rate($tax_class, $cinfo['country_id'], $cinfo['zone_id']);
		} else {
			$products_tax = $this->TAX[$tax_class];
		}

		if ($show_tax == 0) {
			if ($this->cStatus['customers_status_show_price_tax'] == '0')
			$products_tax = '';
		}

		// add taxes
		if ($pPrice == 0)
		$pPrice = $this->getPprice($pID);
		$pPrice = $this->olcAddTax($pPrice, $products_tax);

		// check specialprice
		if ($sPrice = $this->olcCheckSpecial($pID))
		return $this->olcFormatSpecial($pID, $this->olcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus);

		// check graduated
		if ($this->cStatus['customers_status_graduated_prices'] == '1') {
			if ($sPrice = $this->olcGetGraduatedPrice($pID, $qty))
			return $this->olcFormatSpecialGraduated($pID, $this->olcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus, $pID);
		} else {
			// check Group Price
			if ($sPrice = $this->olcGetGroupPrice($pID, 1))
			return $this->olcFormatSpecialGraduated($pID, $this->olcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus, $pID);
		}

		// check Product Discount
		if ($discount = $this->olcCheckDiscount($pID))
		return $this->olcFormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus);

		return $this->olcFormat($pPrice, $format, 0, false, $vpeStatus, $pID);

	}

	function getPprice($pID) {
		$pQuery = "SELECT products_price FROM ".TABLE_PRODUCTS." WHERE products_id='".$pID.APOS;
		$pQuery = olc_db_query($pQuery);
		$pData = olc_db_fetch_array($pQuery, true);
		return $pData['products_price'];
	}

	function olcAddTax($price, $tax) {
		$price = $price + $price / 100 * $tax;
		$price = $this->olcCalculateCurr($price);
		return olc_precision($price, $this->currencies[$this->actualCurr]['decimal_places']);
	}

	function olcCheckDiscount($pID) {

		// check if group got discount
		if ($this->cStatus['customers_status_discount'] != '0.00') {

			$discount_query = "SELECT products_discount_allowed FROM ".TABLE_PRODUCTS." WHERE products_id = '".$pID.APOS;
			$discount_query = olc_db_query($discount_query);
			$dData = olc_db_fetch_array($discount_query, true);

			$discount = $dData['products_discount_allowed'];
			if ($this->cStatus['customers_status_discount'] < $discount)
			$discount = $this->cStatus['customers_status_discount'];
			if ($discount == '0.00')
			return false;
			return $discount;

		}
		return false;
	}

	function olcGetGraduatedPrice($pID, $qty) {
		if (GRADUATED_ASSIGN == TRUE_STRING_S)
		if (olc_get_qty($pID) > $qty)
		$qty = olc_get_qty($pID);
		//if (!is_int($this->cStatus['customers_status_id']) && $this->cStatus['customers_status_id']!=0) $this->cStatus['customers_status_id'] = DEFAULT_CUSTOMERS_STATUS_ID_GUEST;
		$graduated_price_query = "SELECT max(quantity) as qty
				                                FROM ".TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS.$this->actualGroup."
				                                WHERE products_id='".$pID."'
				                                AND quantity<='".$qty.APOS;
		$graduated_price_query = olc_db_query($graduated_price_query);
		$graduated_price_data = olc_db_fetch_array($graduated_price_query, true);
		if ($graduated_price_data['qty']) {
			$graduated_price_query = "SELECT personal_offer
						                                FROM ".TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS.$this->actualGroup."
						                                WHERE products_id='".$pID."'
						                                AND quantity='".$graduated_price_data['qty'].APOS;
			$graduated_price_query = olc_db_query($graduated_price_query);
			$graduated_price_data = olc_db_fetch_array($graduated_price_query, true);

			$sPrice = $graduated_price_data['personal_offer'];
			if ($sPrice != 0.00)
			return $sPrice;
		} else {
			return;
		}

	}

	function olcGetGroupPrice($pID, $qty) {

		$graduated_price_query = "SELECT max(quantity) as qty
				                                FROM ".TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS.$this->actualGroup."
				                                WHERE products_id='".$pID."'
				                                AND quantity<='".$qty.APOS;
		$graduated_price_query = olc_db_query($graduated_price_query);
		$graduated_price_data = olc_db_fetch_array($graduated_price_query, true);
		if ($graduated_price_data['qty']) {
			$graduated_price_query = "SELECT personal_offer
						                                FROM ".TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS.$this->actualGroup."
						                                WHERE products_id='".$pID."'
						                                AND quantity='".$graduated_price_data['qty'].APOS;
			$graduated_price_query = olc_db_query($graduated_price_query);
			$graduated_price_data = olc_db_fetch_array($graduated_price_query, true);

			$sPrice = $graduated_price_data['personal_offer'];
			if ($sPrice != 0.00)
			return $sPrice;
		} else {
			return;
		}

	}

	function olcGetOptionPrice($pID, $option, $value) {
		$attribute_price_query = "select pd.products_discount_allowed,pd.products_tax_class_id, p.options_values_price, p.price_prefix, p.options_values_weight, p.weight_prefix from ".TABLE_PRODUCTS_ATTRIBUTES." p, ".TABLE_PRODUCTS." pd where p.products_id = '".$pID."' and p.options_id = '".$option."' and pd.products_id = p.products_id and p.options_values_id = '".$value.APOS;
		$attribute_price_query = olc_db_query($attribute_price_query);
		$attribute_price_data = olc_db_fetch_array($attribute_price_query, true);
		$dicount = 0;
		if ($this->cStatus['customers_status_discount_attributes'] == 1 && $this->cStatus['customers_status_discount'] != 0.00) {
			$discount = $this->cStatus['customers_status_discount'];
			if ($attribute_price_data['products_discount_allowed'] < $this->cStatus['customers_status_discount'])
			$discount = $attribute_price_data['products_discount_allowed'];
		}
		$price = $this->olcFormat($attribute_price_data['options_values_price'], false, $attribute_price_data['products_tax_class_id']);
		if ($attribute_price_data['weight_prefix'] != '+')
		$attribute_price_data['options_values_weight'] *= -1;
		if ($attribute_price_data['price_prefix'] == '+') {
			$price = $price - $price / 100 * $discount;
		} else {
			$price *= -1;
		}
		return array ('weight' => $attribute_price_data['options_values_weight'], 'price' => $price);
	}

	function olcShowNote($vpeStatus, $vpeStatus = 0) {
		if ($vpeStatus == 1)
		return array ('formated' => NOT_ALLOWED_TO_SEE_PRICES, 'plain' => 0);
		return NOT_ALLOWED_TO_SEE_PRICES;
	}

	function olcCheckSpecial($pID) {
		$product_query = "select specials_new_products_price from ".TABLE_SPECIALS." where products_id = '".$pID."' and status=1";
		$product_query = olc_db_query($product_query);
		$product = olc_db_fetch_array($product_query, true);

		return $product['specials_new_products_price'];

	}

	function olcCalculateCurr($price) {
		return $this->currencies[$this->actualCurr]['value'] * $price;
	}

	function calcTax($price, $tax) {
		return $price * $tax / 100;
	}

	function olcRemoveCurr($price) {

		// check if used Curr != DEFAULT curr
		if (DEFAULT_CURRENCY != $this->actualCurr) {
			return $price * (1 / $this->currencies[$this->actualCurr]['value']);
		} else {
			return $price;
		}

	}

	function olcRemoveTax($price, $tax) {
		$price = ($price / (($tax +100) / 100));
		return $price;
	}

	function olcGetTax($price, $tax) {
		$tax = $price - $this->olcRemoveTax($price, $tax);
		return $tax;
	}

	function olcRemoveDC($price,$dc) {

		$price = $price - ($price/100*$dc);

		return $price;
	}

	function olcGetDC($price,$dc) {

		$dc = $price/100*$dc;

		return $dc;
	}

	function checkAttributes($pID) {
		if (!$this->showFrom_Attributes) return;
		if ($pID == 0)
		return;
		$products_attributes_query = "select count(*) as total from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".$pID."' and patrib.options_id = popt.products_options_id and popt.language_id = '".SESSION_LANGUAGE_ID.APOS;
		$products_attributes = olc_db_query($products_attributes_query);
		$products_attributes = olc_db_fetch_array($products_attributes, true);
		if ($products_attributes['total'] > 0)
		return BLANK.strtolower(FROM).BLANK;
	}

	function olcCalculateCurrEx($price, $curr) {
		return $price * ($this->currencies[$curr]['value'] / $this->currencies[$this->actualCurr]['value']);
	}

	/*
	*
	*    Format Functions
	*
	*
	*
	*/

	function olcFormat($price, $format, $tax_class = 0, $curr = false, $vpeStatus = 0, $pID = 0) {

		if ($curr)
		$price = $this->olcCalculateCurr($price);

		if ($tax_class != 0) {
			$products_tax = $this->TAX[$tax_class];
			if ($this->cStatus['customers_status_show_price_tax'] == '0')
			$products_tax = '';
			$price = $this->olcAddTax($price, $products_tax);
		}

		if ($format) {
			$Pprice = number_format($price, $this->currencies[$this->actualCurr]['decimal_places'], $this->currencies[$this->actualCurr]['decimal_point'], $this->currencies[$this->actualCurr]['thousands_point']);
			$Pprice = $this->checkAttributes($pID).$this->currencies[$this->actualCurr]['symbol_left'].BLANK.$Pprice.BLANK.$this->currencies[$this->actualCurr]['symbol_right'];
			if ($vpeStatus == 0) {
				return $Pprice;
			} else {
				return array ('formated' => $Pprice, 'plain' => $price);
			}
		} else {

			return olc_precision($price, $this->currencies[$this->actualCurr]['decimal_places']);

		}

	}

	function olcFormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus = 0) {
		$sPrice = $pPrice - ($pPrice / 100) * $discount;
		if ($format) {
			$price = '<span class="productOldPrice">'.INSTEAD.$this->olcFormat($pPrice, $format).'</span><br/>'.ONLY.$this->checkAttributes($pID).$this->olcFormat($sPrice, $format).HTML_BR.YOU_SAVE.$discount.'%';
			if ($vpeStatus == 0) {
				return $price;
			} else {
				return array ('formated' => $price, 'plain' => $sPrice);
			}
		} else {
			return olc_precision($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
		}
	}

	function olcFormatSpecial($pID, $sPrice, $pPrice, $format, $vpeStatus = 0) {
		if ($format) {
			$price = '<span class="productOldPrice">'.INSTEAD.$this->olcFormat($pPrice, $format).'</span><br/>'.ONLY.$this->checkAttributes($pID).$this->olcFormat($sPrice, $format);
			if ($vpeStatus == 0) {
				return $price;
			} else {
				return array ('formated' => $price, 'plain' => $sPrice);
			}
		} else {
			return olc_precision($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
		}
	}

	function olcFormatSpecialGraduated($pID, $sPrice, $pPrice, $format, $vpeStatus = 0, $pID) {
		if ($pPrice == 0)
		return $this->olcFormat($sPrice, $format, 0, false, $vpeStatus);
		if ($discount = $this->olcCheckDiscount($pID))
		$sPrice -= $sPrice / 100 * $discount;
		if ($format) {
			if ($sPrice != $pPrice) {
				$price = '<span class="productOldPrice">'.MSRP.$this->olcFormat($pPrice, $format).'</span><br/>'.YOUR_PRICE.$this->checkAttributes($pID).$this->olcFormat($sPrice, $format);
			} else {
				$price = FROM.$this->olcFormat($sPrice, $format);
			}
			if ($vpeStatus == 0) {
				return $price;
			} else {
				return array ('formated' => $price, 'plain' => $sPrice);
			}
		} else {
			return olc_precision($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
		}
	}

	function get_decimal_places($code) {
		return $this->currencies[$this->actualCurr]['decimal_places'];
	}

}
?>