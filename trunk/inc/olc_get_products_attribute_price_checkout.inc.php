<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_products_attribute_price_checkout.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:32 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (olc_get_products_attribute_price_checkout.inc.php,v 1.6 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_get_products_attribute_price_checkout($attribute_price,$attribute_tax,$price_special,$quantity,
$prefix,$calculate_currencies=true)
{
	if ($attribute_price)
	{
		if ($_SESSION['customers_status']['customers_status_show_price'] == '1') {
			//$attribute_tax=olc_get_tax_rate($tax_class);
			// check if user is allowed to see tax rates
			if ($_SESSION['customers_status']['customers_status_show_price_tax'] =='0') {
				$attribute_tax='';
			}
			// add tax
			$price_string=(olc_add_tax($attribute_price,$attribute_tax))*$quantity;
			if ($_SESSION['customers_status']['customers_status_discount_attributes']=='0') {
				// format price & calculate currency
				$price_string=olc_format_price($price_string,$price_special,$calculate_currencies);
				if ($price_special=='1') {
					$price_string = BLANK.$prefix.BLANK.$price_string.BLANK;
				}
			} else {
				$discount=$_SESSION['customers_status']['customers_status_discount'];
				$rabatt_string = $price_string - ($price_string/100*$discount);
				$price_string=olc_format_price($price_string,$price_special,$calculate_currencies);
				$rabatt_string=olc_format_price($rabatt_string,$price_special,$calculate_currencies);
				if ($price_special=='1' && $price_string != $rabatt_string) {
					$price_string = BLANK.$prefix.'<font color="red"><s>'.$price_string.
					'</s></font> '.$rabatt_string.BLANK;
				} else {
					$price_string=$rabatt_string;
					if ($price_special=='1') $price_string=BLANK.$prefix.BLANK.$price_string;
				}
			}
		} else {
			$price_string= BLANK .NOT_ALLOWED_TO_SEE_PRICES;
		}
	}
	return $price_string;
}
 ?>