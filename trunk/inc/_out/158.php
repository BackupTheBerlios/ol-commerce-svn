<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_products_price.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:32 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2003	 nextcommerce (olc_get_products_price.inc.php,v 1.13 2003/08/20); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
// include needed functions
require_once(DIR_FS_INC.'olc_get_tax_rate.inc.php');
require_once(DIR_FS_INC.'olc_get_products_special_price.inc.php');
require_once(DIR_FS_INC.'olc_add_tax.inc.php');
require_once(DIR_FS_INC.'olc_format_price.inc.php');
require_once(DIR_FS_INC.'olc_format_special_price.inc.php');

function olc_get_products_price_specials($products_id,$price_special,$quantity,&$price_special_info,&$products_price_real)
{
	global $special_info,	$price_data;

	$special_price=olc_get_products_price($products_id,$price_special,$quantity,$products_price_real);
	if ($special_price)
	{
		$products_price=split(SESSION_CURRENCY,strip_tags($special_price));
		$products_price=$products_price[0];
		//$products_price_real=$products_price;
		//Convert curreny string to PHP-compatible number!
		$products_price_real_length=strlen($products_price_real);
		for ($i=0;$i<$products_price_real_length;$i++)
		{
			$s=substr($products_price_real,$i,1);
			if ($s==DASH || is_numeric($s))
			{
				$products_price_real=substr($products_price_real,$i);
				break;
			}
		}
		if ($special_info['specials_new_products_price'])
		{
			$price_special_info=TEMPLATE_SPECIAL_PRICE_DATE_1;
			$expires_date=$special_info['expires_date'];
			if (isset($expires_date))
			{
				$expires_date_serial=strtotime($expires_date);
				$expires_date=date("d.m.Y", $expires_date_serial);
				if ($expires_date_serial < time())
				{
					$special_price=$products_price;
				}
				else
				{
					$price_special_info.=sprintf(TEMPLATE_SPECIAL_PRICE_DATE_2,$expires_date);
				}
				$price_special_info=BLANK.$price_special_info;
			}
		}
		else
		{
			$price_special_info="";
		}
	}
	else
	{
		$price_special_info=EMPTY_STRING;
		$products_price_real=0;
	}
	return $special_price;
}

function olc_get_products_price($products_id,$price_special,$quantity,&$price_real)
{
	global $price_data;

	// check if customer is allowed to see prices (if not -> no price calculations , show error message)
	if (CUSTOMER_SHOW_PRICE)
	{
		// load price data into array for further use!
		$product_price_query = olc_db_query(SELECT."
	  products_price,
		products_discount_allowed,
		products_tax_class_id
		FROM ". TABLE_PRODUCTS ."
		WHERE
		products_id = '".$products_id.APOS);
		$product_price = olc_db_fetch_array($product_price_query);
		$price_real=$product_price['products_price'];
		$price_data=array(
		'PRODUCTS_PRICE'=>$price_real,
		'PRODUCTS_UVP'=>$price_uvp,
		'PRODUCTS_DISCOUNT_ALLOWED'=>$product_price['products_discount_allowed'],
		'PRODUCT_TAX_CLASS_ID'=>$product_price['products_tax_class_id']
		);
		// check if user is allowed to see tax rates
		if (CUSTOMER_SHOW_PRICE_TAX)
		{
			// get tax rate for tax class
			$products_tax=olc_get_tax_rate($price_data['PRODUCT_TAX_CLASS_ID']);
		}
		else
		{
			$products_tax=0;
		} // end !CUSTOMER_SHOW_PRICE_TAX
		$price_data['PRODUCTS_TAX_VALUE']=$products_tax.' %';
		// check if special price is aviable for product (no product discount on special prices!)
		//W. Kaiser - AJAX
		$special_price=olc_get_products_special_price($products_id);
		if ($special_price)
		{
		//W. Kaiser - AJAX
			$special_price=(olc_add_tax($special_price,$products_tax));
			$price=(olc_add_tax($price_data['PRODUCTS_PRICE'],$products_tax));
			$price_data['PRODUCTS_PRICE']=$price;
			$price_string=olc_format_special_price($special_price,$price,$price_special,true,$quantity,$products_tax);
		}
		else
		{
			// if ($special_price=olc_get_products_special_price($products_id))
			// Check if there is another price for customers_group (if not, take norm price and calculte discounts (NOTE: no discount on group PRICES(only OT DISCOUNT!)!
			$table_personal_offers=TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS . CUSTOMER_STATUS_ID;
			$group_price_query=olc_db_query(SELECT."
			personal_offer
      FROM " .
			$table_personal_offers . "
      WHERE products_id='".$products_id.APOS);
			$group_price_data=olc_db_fetch_array($group_price_query);
			// if we found a price, everything is ok. If not, we will use normal price
			if 	($group_price_data['personal_offer'] and $group_price_data['personal_offer']!='0.0000')
			{
				$price_string=$group_price_data['personal_offer'];
				// check if customer is allowed to get graduated prices
				if (CUSTOMER_SHOW_GRADUATED_PRICE){
					// check if there are graduated prices in db
					// get quantity for products
					// modifikations for new graduated prices
					$qty=olc_get_qty($products_id);
					if (!olc_get_qty($products_id)) $qty=$quantity;
					$graduated_price_query=olc_db_query(SELECT."
								max(quantity)
                FROM " .
								$table_personal_offers ."
                WHERE products_id='".$products_id."'
                AND quantity<='".$qty.APOS);
					$graduated_price_data=olc_db_fetch_array($graduated_price_query);
					// get singleprice
					$graduated_price_query=olc_db_query(SELECT."
						personal_offer
	          FROM " .
						$table_personal_offers ."
            WHERE products_id='".$products_id."'
            AND quantity='".$graduated_price_data['max(quantity)'].APOS);
					$graduated_price_data=olc_db_fetch_array($graduated_price_query);
					$price_string=$graduated_price_data['personal_offer'];
				}
				$price_string= (olc_add_tax($price_string,$products_tax));//*$quantity;
			}
			else {
				// if 	($group_price_data['personal_offer']!=EMPTY_STRING and $group_price_data['personal_offer']!='0.0000')
				$price_string= (olc_add_tax($price_data['PRODUCTS_PRICE'],$products_tax)); //*$quantity;

				// check if product allows discount
				if ($price_data['PRODUCTS_DISCOUNT_ALLOWED'] != '0.00')
				{
					$discount=$price_data['PRODUCTS_DISCOUNT_ALLOWED'];
					// check if group discount > max. discount on product
					if ($discount > CUSTOMER_DISCOUNT) {
						$discount=CUSTOMER_DISCOUNT;
					}
					// calculate price with rabatt
					$rabatt_string = $price_string - ($price_string/100*$discount);
					if ($price_string==$rabatt_string) {
						$price_string=olc_format_price($price_string*$quantity,$price_special,true);
					} else {
						$price_string=olc_format_special_price($rabatt_string,$price_string,$price_special,false,$quantity,$products_tax);
					}
					return $price_string;
					break;
				}

			}
			// format price & calculate currency
			$price_string=olc_format_price($price_string*$quantity,$price_special,$calculate_currencies=true);
		}
	}
	else {
		// return message, if not allowed to see prices
		$price_string=NOT_ALLOWED_TO_SEE_PRICES;
	}
	return $price_string;
}
?>