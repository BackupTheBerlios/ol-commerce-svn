<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_format_special_price.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:29 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
by Mario Zanier for XTcommerce

based on:
(c) 2003	    nextcommerce (olc_format_special_price.inc.php,v 1.6 2003/08/20); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_format_special_price ($special_price,$standard_price,$price_special,$calculate_currencies,$quantity,$products_tax)
{
	if (doubleval($special_price)<>0)
	{
		include(DIR_FS_INC.'olc_get_currency_parameters.inc.php');

		$standard_price=$standard_price*$quantity;
		$special_price=str_replace(CURRENCY_DECIMAL_POINT,DOT,$special_price);
		$special_price=$special_price*$quantity;
		if ($calculate_currencies==TRUE_STRING_S)
		{
			$special_price=$special_price * CURRENCY_VALUE;
			$standard_price=$standard_price * CURRENCY_VALUE;
		}

		// round price
		$special_price=olc_precision($special_price,CURRENCY_DECIMAL_PLACES);
		if ($price_special)
		{
			if ($standard_price<0)
			{
				$standard_price=-$standard_price;
				$standard_price=str_replace(CURRENCY_DECIMAL_POINT,DOT,$standard_price);
			}
			$standard_price=number_format($standard_price,CURRENCY_DECIMAL_PLACES, CURRENCY_DECIMAL_POINT,
			CURRENCY_THOUSANDS_POINT);
			$special_price=number_format($special_price,CURRENCY_DECIMAL_PLACES, CURRENCY_DECIMAL_POINT,
			CURRENCY_THOUSANDS_POINT);
			$special_price=sprintf(TEMPLATE_SPECIAL_PRICE,
				trim(CURRENCY_SYMBOL_LEFT.$standard_price.CURRENCY_SYMBOL_RIGHT),
				trim(CURRENCY_SYMBOL_LEFT.$special_price.CURRENCY_SYMBOL_RIGHT));
		}
		//1,00 -> 1,--
		global $is_print_version,$is_pdf;

		if ($is_print_version)
		{
			if ($is_pdf)
			{
				$s=CURRENCY_DECIMAL_ZEROES_DASHES_PRINT_PDF;
			}
			else
			{
				$s=CURRENCY_DECIMAL_ZEROES_DASHES_PRINT;
			}
		}
		else
		{
			$s=CURRENCY_DECIMAL_ZEROES_DASHES;
		}
		$special_price=str_replace(CURRENCY_DECIMAL_ZEROES,$s,$special_price);
	}
	else
	{
		$special_price=EMPTY_STRING;
	}
	return $special_price;
}
?>