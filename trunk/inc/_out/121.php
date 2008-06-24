<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_format_price.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:29 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
by Mario Zanier for XTcommerce

based on:
(c) 2003	    nextcommerce (olc_format_price.inc.php,v 1.7 2003/08/19); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
// include needed functions
require_once(DIR_FS_INC.'olc_precision.inc.php');

function olc_format_price ($price_string,$price_special,$calculate_currencies,$show_currencies=true,$force_zero=false)
{
	// calculate currencies
	if (doubleval($price_string)<>0 || $force_zero)
	{
		include(DIR_FS_INC.'olc_get_currency_parameters.inc.php');
		if ($calculate_currencies==TRUE_STRING_S)
		{
			$price_string=$price_string * CURRENCY_VALUE;
		}
		// round price
		$price_string=olc_precision($price_string,CURRENCY_DECIMAL_PLACES);
		if ($price_special=='1')
		{
			$price_string=number_format($price_string,CURRENCY_DECIMAL_PLACES, CURRENCY_DECIMAL_POINT,
			CURRENCY_THOUSANDS_POINT);
			if ($show_currencies == 1)
			{
				$price_string = CURRENCY_SYMBOL_LEFT . $price_string . CURRENCY_SYMBOL_RIGHT;
			}
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
		$price_string=str_replace(CURRENCY_DECIMAL_ZEROES,$s,$price_string);
	}
	else
	{
		$price_string=EMPTY_STRING;
	}
	return $price_string;
}
?>
