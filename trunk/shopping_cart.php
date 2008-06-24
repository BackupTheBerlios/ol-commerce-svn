<?php
/* -----------------------------------------------------------------------------------------
$Id: shopping_cart.php,v 1.1.1.1.2.1 2007/04/08 07:16:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.71 2003/02/14); www.oscommerce.com
(c) 2003	    nextcommerce (shopping_cart.php,v 1.24 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contributions:
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
$cart_empty=false;
require("includes/application_top.php");
// include needed functions
require_once(DIR_FS_INC.'olc_array_to_string.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');
require_once(DIR_FS_INC.'olc_image_submit.inc.php');
require_once(DIR_FS_INC.'olc_draw_form.inc.php');
require_once(DIR_FS_INC.'olc_recalculate_price.inc.php');

$breadcrumb->add(NAVBAR_TITLE_SHOPPING_CART, olc_href_link(FILENAME_SHOPPING_CART));
require(DIR_WS_INCLUDES . 'header.php');
include(DIR_WS_MODULES . 'gift_cart.php');
$cart=$_SESSION['cart'];
if ($cart->count_contents() > 0)
{
	//W. Kaiser - AJAX
	$form_action_link=olc_href_link(FILENAME_SHOPPING_CART,'action=update_product');
	$smarty->assign('FORM_ACTION',olc_draw_form('cart_quantity',$form_action_link));
	//W. Kaiser - AJAX
	$hidden_options=EMPTY_STRING;
	$_SESSION['any_out_of_stock']=0;
	$sql0=SELECT."
	popt.products_options_name, poval.products_options_values_name,
	pa.options_values_price, pa.price_prefix,pa.attributes_stock,
	pa.products_attributes_id,pa.attributes_model
	from " .
	TABLE_PRODUCTS_OPTIONS . " popt, " .
	TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " .
	TABLE_PRODUCTS_ATTRIBUTES . " pa
	where pa.products_id = '~'
	and pa.options_id = '#'
	and pa.options_id = popt.products_options_id
	and pa.options_values_id = '@'
	and pa.options_values_id = poval.products_options_values_id
	and popt.language_id = '" . SESSION_LANGUAGE_ID . "'
	and poval.language_id = '" . SESSION_LANGUAGE_ID . APOS;

	$products_options_name='products_options_name';
	$options_values_id_name = 'options_values_id';
	$products_options_values_name='products_options_values_name';
	$options_values_price_name = 'options_values_price';
	$price_prefix_name = 'price_prefix';
	$weight_prefix_name='weight_prefix';
	$options_values_weight_name='options_values_weight';
	$attributes_stock_name='attributes_stock';
	$products_attributes_id_name='products_attributes_id';
	$products_attributes_model_name='products_attributes_model';
	$products = $cart->get_products();

	for ($i=0, $n=sizeof($products); $i<$n; $i++)
	{
		// Push all attributes information in an array
		$current_product=$products[$i];
		$current_product_id=$current_product['id'];
		$products_attributes=$current_product['attributes'];
		if ($products_attributes)
		{
			while (list($option, $value) = each($products_attributes))
			{
				$hidden_options.= olc_draw_hidden_field('id[' . $current_product_id . '][' . $option . ']', $value);
				$sql=str_replace(TILDE,$current_product_id,$sql0);
				$sql=str_replace(HASH,$option,$sql);
				$sql=str_replace(ATSIGN,$value,$sql);
				$attributes = olc_db_query($sql);
				$attributes_values = olc_db_fetch_array($attributes);
				$options_values_price=$attributes_values[$options_values_price_name ];
				if ((float)$options_values_price<>0)
				{
					$price_prefix=$attributes_values[$price_prefix_name];
				}
				else
				{
					$price_prefix=EMPTY_STRING;
				}
				$products_option[$products_options_name] = $attributes_values[$products_options_name];
				$products_option[$options_values_id_name] = $value;
				$products_option[$products_options_values_name] = $attributes_values[$products_options_values_name];
				$products_option[$options_values_price_name ] = $options_values_price;
				$products_option[$price_prefix_name] = $price_prefix;
				$products_option[$weight_prefix_name] = $attributes_values[$weight_prefix_name];
				$products_option[$options_values_weight_name] = $attributes_values[$options_values_weight_name];
				$products_option[$attributes_stock_name] = $attributes_values[$attributes_stock_name];
				$products_option[$products_attributes_id_name] = $attributes_values[$products_attributes_id_name];
				$products_option[$products_attributes_model_name] = $attributes_values[$products_attributes_model_name];
				$products[$i][$option]=$products_option;
			}
		}
	}
	$smarty->assign('HIDDEN_OPTIONS',$hidden_options);
	require(DIR_WS_MODULES. 'order_details_cart.php');
	$info_message_text='info_message';
	$info_message=$_GET[$info_message_text];
	if ($do_stock_check)
	{
		$allow_checkout=TRUE_STRING_S;
		if ($_SESSION[$any_out_of_stock_text]== 1)
		{
			if (STOCK_ALLOW_CHECKOUT == TRUE_STRING_S)
			{
				// write permission in session
				$info_message=OUT_OF_STOCK_CAN_CHECKOUT;
			}
			else
			{
				$allow_checkout = FALSE_STRING_S;
				$info_message=OUT_OF_STOCK_CANT_CHECKOUT;
			}
		}
		$_SESSION['allow_checkout'] = $allow_checkout;
	}
	if ($info_message)
	{
		$smarty->assign($info_message_text,$info_message);
	}
	//W. Kaiser - AJAX
	$smarty->assign('BUTTON_RELOAD',olc_image_submit('button_update_cart.gif', IMAGE_BUTTON_UPDATE_CART,
	' id="update_cart"',USE_AJAX));
	$smarty->assign('BUTTON_CHECKOUT',HTML_A_START.olc_href_link(FILENAME_CHECKOUT_SHIPPING, EMPTY_STRING, SSL).'">'.
	olc_image_button('button_checkout.gif', IMAGE_BUTTON_CHECKOUT).HTML_A_END);
	$button_action=(USE_AJAX)? $button_action="button_left()":"history.back(1)";
	$smarty->assign('BUTTON_CONTINUE_SHOPPING',HTML_A_START.'javascript:'.$button_action.'">'.
	olc_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING).HTML_A_END);
	//W. Kaiser - AJAX
} else {
	// empty cart
	$cart_empty=true;
	$smarty->assign('cart_empty',$cart_empty);
	$smarty->assign('BUTTON_CONTINUE',HTML_A_START.olc_href_link(FILENAME_DEFAULT).'">'.
		olc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE));
}
$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'shopping_cart'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>