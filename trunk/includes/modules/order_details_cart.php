<?php
/* -----------------------------------------------------------------------------------------
$Id: order_details_cart.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

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

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org
Copyright (c) 2006 Winfried Kaiser, w.kaiser@fortune.de

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
//W. Kaiser - Allow save/restore of cart
if (!isset($show_saved_cart))
{
	$show_saved_cart=false;
}
$not_show_saved_cart=!$show_saved_cart;
//W. Kaiser - Allow save/restore of cart
olc_smarty_init($module_smarty,$cacheid);
// include needed functions
require_once(DIR_FS_INC.'olc_draw_input_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
require_once(DIR_FS_INC.'olc_check_stock.inc.php');
require_once(DIR_FS_INC.'olc_get_products_stock.inc.php');
require_once(DIR_FS_INC.'olc_get_short_description.inc.php');

$module_content=array();
//W. Kaiser - AJAX
if ($not_show_saved_cart)
{
	$parameter0='size="4" align="right"';
	if (USE_AJAX)
	{
		$action_routine='"products_quantity_changed(this,\'\',false)"';
		//$parameter0.=' id="cart_quantity_#" onkeyup='.$action_routine;
		$parameter0.=' id="cart_quantity_#" onchange='.$action_routine;
		$parameter10=' id="cart_products_id_#"';
		$parameter20=' id="cart_check_#" onclick=javascript:'.$action_routine;
		$parameter30='<span id="cart_item_total_price_#">';
		$parameter40=' id="cart_min_quantity_#"';
		$parameter50=' id="cart_stock_quantity_#"';
	}
	else
	{
		$parameter=$parameter0;
		$parameter1=EMPTY_STRING;
		$parameter2=EMPTY_STRING;
		$parameter3=EMPTY_STRING;
		$parameter4=EMPTY_STRING;
		$parameter5=EMPTY_STRING;
	}
}
$cart_quantity_text='cart_quantity[]';
$cart_min_quantity_text='cart_min_quantity[]';
$cart_stock_quantity_text='cart_stock_quantity[]';
$products_id_text='products_id[]';
$cart_delete_text='cart_delete[]';
$products_id_equal_text='products_id=';
$name_text='name';
$model_text='model';
$tax_text='tax';
$id_text='id';
$quantity_text='quantity';
$min_quantity_text='min_quantity';
$any_out_of_stock_text='any_out_of_stock';
$image_text='image';
$attributes_text='attributes';

$products_options_values_name_text='products_options_values_name';
$products_attributes_id_text='products_attributes_id';
$options_values_price_text='options_values_price';
$tax_class_id_text='tax_class_id';
$price_prefix_text='price_prefix';
$products_options_model_text='products_options_model';
$products_options_name_text='products_options_name';
$span_end_text='</span>';

$products_element_text='PRODUCTS_ELEMENT';
$products_name_text='PRODUCTS_NAME';
$big_products_id_text='PRODUCTS_ID';
$products_qty_text='PRODUCTS_QTY';
$products_model_text='PRODUCTS_MODEL';
$products_addon_info_text='PRODUCTS_ADDON_INFO';
$products_tax_text='PRODUCTS_TAX';
$products_image_text='PRODUCTS_IMAGE';
$box_delete_text='BOX_DELETE';
$products_link_text='PRODUCTS_LINK';
$products_price_text='PRODUCTS_PRICE';
$products_single_price_text='PRODUCTS_SINGLE_PRICE';
$products_short_description_text='PRODUCTS_SHORT_DESCRIPTION';
$products_attributes_text='ATTRIBUTES';
$element_text='ELEMENT';
$big_id_text='ID';
$big_model_text='MODEL';
$big_name_text='NAME';
$value_name_text='VALUE_NAME';
$price_text='PRICE';
if (USE_EBAY)
{
	$ebay_image=HTML_NBSP.olc_image(DIR_WS_IMAGES."ebay.gif",
	AUCTIONS_TEXT_SHOW_PRODUCT,EMPTY_STRING,EMPTY_STRING,' align="middle"');
	$ebay_link=olc_href_link(EBAY_SERVER,EBAY_VIEWITEM.HASH).'" target="_blank';
	$hidden_quantity=olc_draw_hidden_field($cart_quantity_text, HASH);
	$hidden_product_id=olc_draw_hidden_field($products_id_text, HASH);
}
$link=olc_href_link(FILENAME_PRODUCT_INFO,$products_id_equal_text.HASH);
$do_stock_check=STOCK_CHECK == TRUE_STRING_S;
$do_atribute_stock_check=$do_stock_check && ATTRIBUTE_STOCK_CHECK == TRUE_STRING_S;
for ($i=0; $i<sizeof($products); $i++)
{
	$product=$products[$i];
	$product_id=$product[$id_text];
	$products_quantity=$product[$quantity_text];
	$products_min_quantity=$product[$min_quantity_text];
	$products_quantity=max($products_quantity,$products_min_quantity);
	if ($do_stock_check)
	{
		$mark_stock= olc_check_stock($product_id, $products_quantity);
		$_SESSION[$any_out_of_stock_text]=$mark_stock;
		$mark_stock=HTML_NBSP.$mark_stock;
	}
	$image=$product[$image_text];
	if ($image)
	{
		$image=DIR_WS_THUMBNAIL_IMAGES.$image;
	}
	$price_single=olc_get_products_price($product_id,$price_special=1, $quantity=1,$price_real);
	$price_single=abs($price_real);
	$total_price=olc_format_price($price_single*$products_quantity,1,1);
	if ($show_saved_cart)
	{
		$products_qty=$products_quantity;
	}
	else
	{
		if (USE_AJAX)
		{
			$parameter=str_replace(HASH,$i,$parameter0);
			$parameter1=str_replace(HASH,$i,$parameter10);
			$parameter2=str_replace(HASH,$i,$parameter20);
			$parameter3=str_replace(HASH,$i,$parameter30);
			$parameter4=str_replace(HASH,$i,$parameter40);
			$parameter5=str_replace(HASH,$i,$parameter50);
			$total_price=$parameter3.$total_price.$span_end_text;
		}
		$products_qty=
		olc_draw_input_field($cart_quantity_text, $products_quantity, $parameter) .
		olc_draw_hidden_field($cart_min_quantity_text, $products_min_quantity ,$parameter4).
		olc_draw_hidden_field($products_id_text, $product_id ,$parameter1);
		if ($do_stock_check)
		{
			$products_qty.=
			olc_draw_hidden_field($cart_stock_quantity_text,olc_get_products_stock($product_id),$parameter5);
		}
	}
	$auctionid = $product['auctionid'];
	if($auctionid)
	{
		//no deletebox
		$mydelete = EMPTY_STRING;
		//quantity is hidden - no changes can be made by the user
		$myquantity = $products_quantity.
			str_replace(HASH,$products_quantity,$hidden_quantity).
			str_replace(HASH,$product_id,$hidden_product_id);
		//link to ebay-auction
		$mylink =str_replace(HASH,$auctionid,$ebay_link);
		//as title show ebayicon - so user knows that this is the product bought at ebay
		$myimage = HTML_A_START.$mylink.'">'.$ebay_image.HTML_A_END;
	}
	else
	{
		//if product is not a auction - deletebox can be shown
		$mydelete=olc_draw_checkbox_field($cart_delete_text,$product_id,false,$parameter2);
		//quantity box can be shown
		$myquantity = $products_qty;
		$myimage = EMPTY_STRING;
		//link to product
		$mylink=str_replace(HASH, $product_id, $link);
	}
	$module_content[$i]=array(
	$products_element_text => $i,
	$products_name_text => strip_tags($product[$name_text]),
	$big_products_id_text => $product_id,
	$products_qty_text => $myquantity,
	$products_model_text => $product[$model_text],
	$products_addon_info_text => $myimage.$mark_stock,
	$products_tax_text => number_format($product[$tax_text], TAX_DECIMAL_PLACES),
	$products_image_text => $image,
	$box_delete_text => $mydelete,
	$products_link_text => $mylink,
	$products_price_text => $total_price,
	$products_single_price_text=>olc_format_price($price_single,1,1),
	$products_short_description_text => strip_tags(olc_get_short_description($product_id)),
	$products_attributes_text => EMPTY_STRING);
	//W. Kaiser - AJAX

	// Product options names
	$product_attributes=$product[$attributes_text];
	$attributes_exist = ((isset($product_attributes)) ? true : false);
	if ($attributes_exist)
	{
		reset($product_attributes);

		while (list($option, $value) = each($product_attributes))
		{
			$product_option=$product[$option];
			$products_options_value_name=$product_option[$products_options_values_name_text];
			if (strpos($products_options_value_name,"Bitte wählen Sie")===false)
			{
				if ($do_atribute_stock_check)
				{
					$_SESSION[$any_out_of_stock_text]=
					olc_check_stock_attributes($product_option[$products_attributes_id_text],$products_quantity);
				}
				$price=$product_option[$options_values_price_text];
				if ($price<>0)
				{
					$price=olc_get_products_attribute_price($price,$tax_class=$product[$tax_class_id_text],
					$price_special=1,$quantity=$products_quantity,
					$prefix= trim($product_option[$price_prefix_text]));
				}
				else
				{
					$price=EMPTY_STRING;
				}
				$module_content[$i][$products_attributes_text][]=array(
				$element_text => $i,
				$big_id_text =>$product_option[$products_attributes_id_text],
				$big_model_text=>$product_option[$products_options_model_text],
				$big_name_text => $product_option[$products_options_name_text],
				$value_name_text => $products_options_value_name.$attribute_stock_check,
				$price_text => $price);
			}
		}
	}
}
//W. Kaiser - AJAX

if (CUSTOMER_SHOW_PRICE)
{
	if ($not_show_saved_cart)
	{
		$price_raw=$_SESSION['cart']->show_total();
		$span_price_start='<span id="cart_total_price_1">';
	}
	$price=olc_format_price($price_raw,$price_special=1, $calculate_currencies=false);
	if (IS_AJAX_PROCESSING)
	{
		$price=$span_price_start.$price.$span_end;
	}
	$total_content=EMPTY_STRING;
	if (CUSTOMER_SHOW_OT_DISCOUNT)
	{
		if (CUSTOMER_OT_DISCOUNT != '0.00')
		{
			$price_discounted = olc_recalculate_price($price_raw, CUSTOMER_OT_DISCOUNT);
			$price=ltrim(olc_format_price(price_discounted, $price_special=1, $calculate_currencies=false));
			if (IS_AJAX_PROCESSING)
			{
				$price=$span_price_start.$price.$span_end;
				$price=olc_draw_hidden_field("total_discount_value",CUSTOMER_OT_DISCOUNT).
				'<span id="cart_total_discount">'.$price.$span_end;
			}
			$total_content= CUSTOMER_OT_DISCOUNT.' % '.SUB_TITLE_OT_DISCOUNT.' - ' .	$price .HTML_BR;
		}
	}
	$total_content.= SUB_TITLE_TOTAL.$price;
} else {
	$total_content.= TEXT_INFO_SHOW_PRICE_NO;
}
$total_content.= HTML_BR;
// display only if there is an ot_discount
if (CUSTOMER_OT_DISCOUNT != 0) {
	$total_content.= TEXT_CART_OT_DISCOUNT.CUSTOMER_OT_DISCOUNT.' %';
}
$module_smarty->assign('TOTAL_CONTENT',$total_content);
$module_smarty->assign(MODULE_CONTENT,$module_content);
//W. Kaiser - Allow save/restore of cart
if ($show_saved_cart)
{
	$template='cart_restore_details';
}
else
{
	$template='order_details';

}
$module=$module_smarty->fetch(CURRENT_TEMPLATE_MODULE.$template.HTML_EXT,$cacheid);
//W. Kaiser - Allow save/restore of cart
$smarty->assign('MODULE_order_details',$module);
?>
<!-- order_details_eof -->