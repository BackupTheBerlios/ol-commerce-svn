<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_format_price_graduated.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:29 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
by Mario Zanier for XTcommerce

based on:
(c) 2003	    nextcommerce (olc_format_price_graduated.inc.php,v 1.4 2003/08/19); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_format_price_graduated($price_string,$price_special,$calculate_currencies,$products_tax_class)
{
	if ((int)$price_string == 0)
	{
		$price_string = EMPTY_STRING;
	}
	else
	{
		include(DIR_FS_INC.'olc_get_currency_parameters.inc.php');

		if ($calculate_currencies==TRUE_STRING_S)
		{
			$price_string=$price_string * CURRENCY_VALUE;
		}
		// add tax
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] !='0') {
			$products_tax=olc_get_tax_rate($products_tax_class);
			$price_string= (olc_add_tax($price_string,$products_tax));
		}
		// round price
		$price_string=olc_precision($price_string,CURRENCY_DECIMAL_PLACES);
		if ($price_special=='1')
		{
			$price_string=number_format($price_string,CURRENCY_DECIMAL_PLACES, CURRENCY_DECIMAL_POINT,
			CURRENCY_THOUSANDS_POINT);
			$price_string = CURRENCY_SYMBOL_LEFT . $price_string . CURRENCY_SYMBOL_RIGHT;
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
	return $price_string;
}
?>