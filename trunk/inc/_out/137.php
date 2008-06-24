<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_currency_parameters.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:30 gswkaiser Exp $

Get common currency data

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

if (!defined('CURRENCY_SYMBOL_LEFT'))
{
	$currencies_query = olc_db_query("SELECT
				symbol_left,
        symbol_right,
        decimal_places,
        decimal_point,
        thousands_point,
        value
        FROM ". TABLE_CURRENCIES ." WHERE code = '".SESSION_CURRENCY .APOS);
	$currencies_value=olc_db_fetch_array($currencies_query);
	define('CURRENCY_SYMBOL_LEFT',$currencies_value['symbol_left'] . BLANK);
	define('CURRENCY_SYMBOL_RIGHT', BLANK . $currencies_value['symbol_right']);
	define('CURRENCY_DECIMAL_PLACES',$currencies_value['decimal_places']);
	define('CURRENCY_DECIMAL_POINT',$currencies_value['decimal_point']);
	define('CURRENCY_THOUSANDS_POINT',$currencies_value['thousands_point']);
	$currencies_query=$currencies_value['value'];
	if ($currencies_query)
	{
		define('CURRENCY_VALUE',$currencies_query);
	}
	else
	{
		define('CURRENCY_VALUE',1);
	}
	define('ZERO_CENTS',CURRENCY_DECIMAL_POINT.'--');
	define('CURRENCY_DECIMAL_ZEROES',CURRENCY_DECIMAL_POINT.str_pad(EMPTY_STRING, CURRENCY_DECIMAL_PLACES ,'0'));
	//define('CURRENCY_DECIMAL_ZEROES_DASHES',CURRENCY_DECIMAL_POINT.HTML_MDASH);
	define('CURRENCY_DECIMAL_ZEROES_DASHES',CURRENCY_DECIMAL_POINT.HTML_NDASH);
	define('CURRENCY_DECIMAL_ZEROES_DASHES_PRINT',CURRENCY_DECIMAL_POINT.chr(151));		//"mdash"
	define('CURRENCY_DECIMAL_ZEROES_DASHES_PRINT_PDF',CURRENCY_DECIMAL_POINT.chr(150));		//"ndash"
	define('CURRENCY_CHANGE_DECIMAL_POINT',CURRENCY_DECIMAL_POINT<>DOT);
}
$price_string=olc_precision($price_string,CURRENCY_DECIMAL_PLACES);
$price_string=str_replace(CURRENCY_DECIMAL_POINT,DOT,$price_string);
?>
