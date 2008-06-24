<?php
/* -----------------------------------------------------------------------------------------
$Id: order_details.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(order_details.php,v 1.8 2003/05/03); www.oscommerce.com
(c) 2003	    nextcommerce (order_details.php,v 1.16 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
olc_smarty_init($module_smarty,$cacheid);
// include needed functions
require_once(DIR_FS_INC.'olc_draw_separator.inc.php');
require_once(DIR_FS_INC.'olc_draw_form.inc.php');
require_once(DIR_FS_INC.'olc_draw_input_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_selection_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
require_once(DIR_FS_INC.'olc_check_stock.inc.php');
require_once(DIR_FS_INC.'olc_get_products_stock.inc.php');
require_once(DIR_FS_INC.'olc_remove_non_numeric.inc.php');


echo '  <tr>' . NEW_LINE;

$is_shopping_cart=strstr($PHP_SELF, FILENAME_SHOPPING_CART);
$not_is_shopping_cart=!$is_shopping_cart;
$product_list_model=PRODUCT_LIST_MODEL > 0;

$colspan = 3;

if ($is_shopping_cart) {
	$colspan++;
	echo '    <td align="center" class="smallText"><b>' . TABLE_HEADING_REMOVE . '</b></td>' . NEW_LINE;
}

echo '    <td align="center" class="tableHeading">' . TABLE_HEADING_QUANTITY . '</td>' . NEW_LINE;

if ($is_shopping_cart) 
{
	if ($product_list_model) 
	{
		$colspan++;
		echo '    <td class="tableHeading">' . TABLE_HEADING_MODEL . '</td>' . NEW_LINE;
	}
}

echo '    <td class="tableHeading">' . TABLE_HEADING_PRODUCTS . '</td>' . NEW_LINE;

if ($not_is_shopping_cart) 
{
	$colspan++;
	echo '    <td align="center" class="tableHeading">' . TABLE_HEADING_TAX . '</td>' . NEW_LINE;
}
//  echo $customer_id . $customer_status_name . $customer_status_value['customers_status_discount'] . $customer_status_value['customers_status_ot_discount'];
if ($customer_status_value['customers_status_discount'] != 0) {
	$colspan++;
	echo '<td align="right" class="tableHeading">' . TABLE_HEADING_DISCOUNT . '</td>';
}
echo '<td align="right" class="tableHeading">' . TABLE_HEADING_TOTAL . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="' . $colspan . '">' . olc_draw_separator() . '</td>';
echo '</tr>';

for ($i=0, $n=sizeof($products); $i<$n; $i++) {
	echo '  <tr>' . NEW_LINE;

	// Delete box only for shopping cart
	if ($is_shopping_cart) 
	{
		echo '    <td align="center" valign="top">' . olc_draw_checkbox_field('cart_delete[]', $products[$i]['id']) . '</td>' . NEW_LINE;
	}

	// Quantity box or information as an input box or text
	if ($is_shopping_cart) 
	{
		echo '    <td align="center" valign="top">' . olc_draw_input_field('cart_quantity[]', 
		$products[$i]['quantity'], 'size="4"') . olc_draw_hidden_field('products_id[]', $products[$i]['id']) . '</td>' . NEW_LINE;
	} else {
		echo '    <td align="center" valign="top" class ="main">' . $products[$i]['quantity'] . '</td>' . NEW_LINE;
	}

	// Model
	$link='    <td valign="top" class="main"><a href="'.olc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']).'">';
	if ($is_shopping_cart) 
	{
		if ($product_list_model) 
		{
			echo $link . $products[$i]['model'] . '</a></td>' . NEW_LINE;
		}
	}

	// Product name, with or without link
	if ($is_shopping_cart) 
	{
		echo $link . HTML_B_START . $products[$i]['name'] . '</b></a>';
	} else {
		echo '    <td valign="top" class="main"><b>' . $products[$i]['name'] . HTML_B_END;
	}

	// Display marker if stock quantity insufficient
	if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {
		if (STOCK_CHECK == TRUE_STRING_S) {
			echo $stock_check = olc_check_stock($products[$i]['id'], $products[$i]['quantity']);
			if ($stock_check) $any_out_of_stock = 1;
		}
	}

	// Product options names
	$attributes_exist = ((isset($products[$i]['attributes'])) ? 1 : 0);

	if ($attributes_exist == 1) {
		reset($products[$i]['attributes']);
		while (list($option, $value) = each($products[$i]['attributes'])) {
			echo '<br/><small><i> - ' . $products[$i][$option]['products_options_model'] .'  '.$products[$i][$option]['products_options_name'] . BLANK . $products[$i][$option]['products_options_values_name'] . '</i></small>';

			// Display marker if attributes-stock quantity insufficient
			if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {
				if (ATTRIBUTE_STOCK_CHECK == TRUE_STRING_S) {


					echo $attribute_stock_check = olc_check_stock_attributes($products[$i][$option]['attributes_stock'], $products[$i]['quantity']);
					if ($attribute_stock_check) $any_out_of_stock = 1;

				}
			}

		}
	}

	echo '</td>' . NEW_LINE;

	// Tax (not in shopping cart, tax rate may be unknown)
	if ($not_is_shopping_cart) 
	{
		echo '    <td align="center" valign="top" class="main">' . number_format($products[$i]['tax'], TAX_DECIMAL_PLACES) . '%</td>' . NEW_LINE;
	}

	// Product price
	// elari - changed CS V3.x
	if ($customer_status_value['customers_status_discount'] != 0) {
		$max_product_discount = min($products[$i]['discount_allowed'] , $customer_status_value['customers_status_discount']);
		echo $products[$i]['discount_allowed'] . $products[$i]['discount_allowed'] . $customer_status_value['customers_status_discount'];
		if ($max_product_discount > 0) {
			echo '    <td align="right" valign="top" class="main">-' . $max_product_discount . '%</td>';
		} else {
			echo '    <td align="right" valign="top" class="main">&nbsp</td>';
		}
	}
	// elari End CS V3.x
	if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {
		echo '    <td align="right" valign="top" class="main"><b>'.olc_get_products_price($products[$i]['id'],$price_special=1,$quantity=$products[$i]['quantity']).HTML_B_END . NEW_LINE;
	} else {
		echo '    <td align="right" valign="top" class="main"><b>'.olc_get_products_price($products[$i]['id'],$price_special=1,$quantity=$products[$i]['quantity']) . HTML_B_END . NEW_LINE;
	}

	// Product options prices
	if ($attributes_exist == 1) {
		reset($products[$i]['attributes']);
		while (list($option, $value) = each($products[$i]['attributes'])) {
			if ($products[$i][$option]['options_values_price'] != 0) {
				if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {

					echo '<br/><small><i>' . olc_get_products_attribute_price($products[$i][$option]['options_values_price'], $tax_class=$products[$i]['tax_class_id'],$price_special=1,$quantity=$products[$i]['quantity'],$prefix= $products[$i][$option]['price_prefix']) . '</i></small>';
				} else {
					echo '<br/><small><i>' . olc_get_products_attribute_price($products[$i][$option]['options_values_price'], $tax_class=$products[$i]['tax_class_id'],$price_special=1,$quantity=$products[$i]['quantity'],$prefix= $products[$i][$option]['price_prefix']) . '</i></small>';
				}
			} else {
				// Keep price aligned with corresponding option
				echo '<br/><small><i>&nbsp;</i></small>';
			}
		}
	}

	echo '</td>' . NEW_LINE .
	'  </tr>' . NEW_LINE;
}
$module= $module_smarty->fetch(CURRENT_TEMPLATE_MODULE . 'order_details'.HTML_EXT,$cacheid);
$smarty->assign('MODULE_order_details',$module);
?>
<!-- order_details_eof -->