<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_price_disclaimer.inc.php,v 1.1.1.1 2006/12/22 13:41:30 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (olc_add_tax.inc.php,v 1.4 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

if ($isprint_version)
{
	$add_text="_NO_LINK";
}
else
{
	$add_text=EMPTY_STRING;
}
if (NO_TAX_RAISED)
{
	$price_disclaimer=constant('PRICE_DISCLAIMER_NO_TAX'.$add_text);
}
else
{
	if (CUSTOMER_SHOW_PRICE_TAX)
	{
		global $price_data;
		$s='PRODUCTS_TAX_VALUE';
		$price_disclaimer=sprintf(constant('PRICE_DISCLAIMER_INCL'.$add_text),$price_data[$s]);
		$info_smarty->assign($s, $price_data[$s]);
	}
	else
	{
		$price_disclaimer=constant('PRICE_DISCLAIMER_EXCL'.$add_text);
	}
}
?>