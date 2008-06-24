<?php
/* -----------------------------------------------------------------------------------------
$Id: shopping_cart.php,v 1.3 2004/02/22 16:15:30 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.18 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (shopping_cart.php,v 1.15 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
global $box_smarty;

//W. Kaiser - AJAX
olc_smarty_init($box_smarty,$cacheid);
/*
$empty_cart=
strpos(FILENAME_CHECKOUT_PAYMENT.FILENAME_CHECKOUT_CONFIRMATION.FILENAME_CHECKOUT_SHIPPING,CURRENT_SCRIPT)!==false;
*/
$empty_cart=strpos(FILENAME_CHECKOUT_PROCESS,CURRENT_SCRIPT)!==false;
if (!$empty_cart)
{
	$qty=$_SESSION['cart']->count_contents();
	if ($qty > 0)
	{
		if (USE_AJAX)
		{
			//Send prototype for cart-line
			if (NOT_IS_AJAX_PROCESSING)
			{
				$box_smarty->assign('SEND_PROTOTYPE',true);				//Set Prototype-flag for template
			}
		}
		//W. Kaiser - AJAX
		$box_content=EMPTY_STRING;
		$inline_text='SHOW_SHORT_CART_ONLY';
		if (!defined($inline_text))
		{
			define($inline_text,false);
		}
		// include needed files
		require_once(DIR_FS_INC.'olc_format_price.inc.php');
		require_once(DIR_FS_INC.'olc_recalculate_price.inc.php');
		$products = $_SESSION['cart']->get_products();
		$items=sizeof($products);
		if (!SHOW_SHORT_CART_ONLY)
		{
			$products_id_save=$_GET['products_id'];
			$products_in_cart=array();
			for ($i=0; $i<$items; $i++)
			{
				$product=$products[$i];
				//W. Kaiser - AJAX
				$this_products_id=$product['id']; //olc_get_uprid($products_id_save, $product['attributes']);
				$options_text=EMPTY_STRING;
				if ((strpos($this_products_id,"{")!==false))			//Any options included?
				{
					//Build options text for link title in cart!
					//Get products options included
					//Format of $this_products_id is: xxx{Opt_id_1}Qty_1{Opt_id_2}Qty_2...{Opt_id_n}Qty_n
					$options_array=split("{",$this_products_id);
					$_GET['products_id']=$options_array[0];
					include(DIR_WS_MODULES."product_attributes_info_build.php");
					$options=sizeof($products_options_data);
					for ($option=0;$option<$options;$option++)
					{
						//Search attributes-classes by id
						$attrib_data=split("}",$options_array[$option+1]);
						$attrib_id=$attrib_data[0];
						for ($option_class=0;$option_class<$options;$option_class++)
						{
							$products_options_data_option_class=$products_options_data[$option_class];
							if ($products_options_data_option_class['ID']==$attrib_id)
							{
								//Search attributes by id
								$attrib_id=$attrib_data[1];
								$current_products_options_data=$products_options_data_option_class['DATA'];
								$attributes=sizeof($current_products_options_data);
								//Search attributes by id
								for ($attribute=0;$attribute<$attributes;$attribute++)
								{
									$current_products_options_data_attribute=$current_products_options_data[$attribute];
									if ($current_products_options_data_attribute['ID']==$attrib_id)
									{
										$title=$current_products_options_data_attribute['TEXT'];
										if (strpos($title,PLEASE_SELECT)===false)
										{
											if (strlen($options_text)>0)
											{
												$options_text.=COMMA_BLANK;
											}
											$options_text.=$products_options_data_option_class['NAME'].COLON_BLANK.$title;
											$price=$current_products_options_data_attribute['PRICE'];
											if ($price)
											{
												$price=str_replace(HTML_NDASH,XDASH_REPLACE,$price);
												$price_raw=str_replace(CURRENCY_THOUSANDS_POINT,EMPTY_STRING,$price);
												$price_raw=(float)str_replace(CURRENCY_DECIMAL_POINT,DOT,$price_raw);
												if ($price_raw<>0)
												{
													$options_text.=LPAREN.$current_products_options_data_attribute['PREFIX'].ltrim($price).RPAREN;
												}
											}
										}
										break;
									}
								}
								break;
							}
						}
					}
					if (strlen($options_text)>0)
					{
						if (IS_IE)
						{
							$options_text=NEW_LINE.$options_text.NEW_LINE;
						}
						else
						{
							if (strlen($options_text)>100)
							{
								$options_text=substr($options_text,0,97)."...";
							}
						}
						$options_text=LPAREN.$options_text.RPAREN;
					}
				}
				$price=$product['price'];
				$products_in_cart[]=array(
				'QTY'=>$product['quantity'],
				'LINK'=>olc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product['id'] .'&cart_line='.$i),
				'ELEMENT'=>$i,
				'ID'=>$this_products_id,
				'PRICE'=>$price,
				'FINAL_PRICE'=>olc_format_price($product['final_price'],1,0,0),
				'CURRENCY'=>SESSION_CURRENCY,
				'OPTIONS'=>$options_text,
				'NAME'=>str_replace(HTML_BR,BLANK,$product['name']));
				//W. Kaiser - AJAX
			}
		}
		//$box_smarty->assign('PRODUCTS',$qty);
		$total_price =$_SESSION['cart']->show_total();
		$box_smarty->assign('ITEMS',$items);
		$box_smarty->assign('TOTAL',olc_format_price($total_price, true, true));
		//$isprint_version=true;
		include(DIR_FS_INC.'olc_get_price_disclaimer.inc.php');
		$box_smarty->assign('PRICE_DISCLAIMER', $price_disclaimer);
		$isprint_version=false;
		$box_smarty->assign('TOTAL_UNDISCOUNTED',$total_price);
		if (CUSTOMER_SHOW_OT_DISCOUNT)
		{
			if (CUSTOMER_OT_DISCOUNT<>0)
			{
				$discount=olc_format_price(olc_recalculate_price(($total_price*(-1)), CUSTOMER_OT_DISCOUNT),
				$price_special = 1, $calculate_currencies = false);
				if (IS_AJAX_PROCESSING)
				{
					$price=olc_draw_hidden_field('total_discount_value',CUSTOMER_OT_DISCOUNT).
					'<span id="cart_total_discount">'.$price.'</span>';
				}
				$box_smarty->assign('DISCOUNT',$discount);
			}
		}
		$_GET['products_id']=$products_id_save;
	}
	else
	{
		// cart empty
		$empty_cart=true;
	}
	if (ACTIVATE_GIFT_SYSTEM=='true')
	{
		$box_smarty->assign('ACTIVATE_GIFT',true);
	}
	// GV Code Start
	if (ISSET_CUSTOMER_ID)
	{
		$gv_query = olc_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER .
		" where customer_id = '" . $_SESSION['customer_id'] . APOS);
		$gv_result = olc_db_fetch_array($gv_query);
		if ($gv_result['amount'] > 0 ) {
			$box_smarty->assign('GV_AMOUNT', olc_format_price($gv_result['amount'],
			$price_special = 1, $calculate_currencies = true));
			$box_smarty->assign('GV_SEND_TO_FRIEND_LINK', HTML_A_START. olc_href_link(FILENAME_GV_SEND) . '">');
		}
	}
	if (isset($_SESSION['gv_id']))
	{
		$gv_query = olc_db_query("select coupon_amount from " . TABLE_COUPONS .
		" where coupon_id = '" . $_SESSION['gv_id'] . APOS);
		$coupon = olc_db_fetch_array($gv_query);
		$box_smarty->assign('COUPON_AMOUNT2', $currencies->format($coupon['coupon_amount']));
	}
	if (isset($_SESSION['cc_id']))
	{
		//W. Kaiser - AJAX
		$box_smarty->assign('COUPON_HELP_LINK', HTML_A_START.'javascript:popupWindow(\'' .
		olc_href_link(FILENAME_POPUP_COUPON_HELP, 'cID=' . $_SESSION['cc_id'],NONSSL,true,true,false) . '\')">');
		//W. Kaiser - AJAX
	}
	// GV Code End
	$box_smarty->assign('LINK_CART',olc_href_link(FILENAME_SHOPPING_CART));
	$box_smarty->assign('products',$products_in_cart);
	$button='button_tocart.gif';
	if (is_file(CURRENT_TEMPLATE_BUTTONS.$button))
	{
		$button=
		HTML_NBSP.
		HTML_A_START.
		olc_href_link(FILENAME_SHOPPING_CART).'">'.olc_image(CURRENT_TEMPLATE_BUTTONS.$button,NAVBAR_TITLE_SHOPPING_CART).
		HTML_A_END.
		HTML_A_START.
		olc_href_link(FILENAME_CHECKOUT_SHIPPING).'">'.olc_image(CURRENT_TEMPLATE_BUTTONS.'button_buy.gif',IMAGE_BUTTON_CHECKOUT).
		HTML_A_END;
		$box_smarty->assign('CART_BUTTONS',$button);
	}
	$inline_text='inline';
	$cart_details_state_text='cart_details_state';
	if (USE_AJAX)
	{
		$none_text='none';
		if (SHOW_SHORT_CART_ONLY)
		{
			$cart_details_state=$none_text;
			$_SESSION[$cart_details_state_text]=$cart_details_state;
		}
		else
		{
			$cart_details_state=$_GET[$cart_details_state_text];
			if ($cart_details_state)
			{
				$_SESSION[$cart_details_state_text]=$cart_details_state;
			}
			else
			{
				$cart_details_state=$_SESSION[$cart_details_state_text];
				if (!isset($cart_details_state))
				{
					$cart_details_state=$none_text;
					$_SESSION[$cart_details_state_text]=$cart_details_state;
				}
			}
			if ($cart_details_state==$inline_text)
			{
				$title=NAVBAR_TITLE_SHOPPING_CART_DETAILS_CLOSE;
			}
			else
			{
				$title=NAVBAR_TITLE_SHOPPING_CART_DETAILS_OPEN;
			}
			$button='button_cart_details.gif';
			$id='id="button_cart_details"';
			if (is_file(CURRENT_TEMPLATE_BUTTONS.$button))
			{
				$link_item='>'.olc_image(CURRENT_TEMPLATE_BUTTONS.$button,$title,EMPTY_STRING,EMPTY_STRING,$id);
			}
			else
			{
				$link_item=BLANK.$id.' title="'.$title.'">'.CART_DETAILS;
			}
			$button=
			'<span align="center" style="font-size:6pt;text-decoration:underline">
				<b><a href="#" onclick="javascript:show_hide_cart_details();return false;"'.
			$link_item.HTML_A_END.HTML_B_END.HTML_BR.HTML_BR.'
			</span>';
			$box_smarty->assign('CART_BUTTON_SHOW_HIDE',$button);
		}
	}
	else
	{
		$cart_details_state=$inline_text;
	}
	$box_smarty->assign($cart_details_state_text,$cart_details_state);
	$deny_cart='false';
	if (OL_COMMERCE)
	{
		//W. Kaiser - Allow save/restore of cart
		if (isset($_SESSION['customer_id']))
		{
			$box_smarty->assign('SHOW_CART_SAVE_RESTORE',true);
			$saved_carts_text='_saved_carts';
			$checked_saved_carts_text='checked'.$saved_carts_text;
			$have_saved_carts_text='have'.$saved_carts_text;
			$nr_saved_carts_text='nr'.$saved_carts_text;
			//Customer logged in
			if (!$_SESSION[$checked_saved_carts_text])
			{
				$param_array=array('#1','#2');
				$sql_from0=SQL_FROM."#1 where customers_id = '".CUSTOMER_ID.APOS;
				$sql_select_from='SELECT *'.str_replace($param_array,TABLE_CUSTOMERS_BASKET_SAVE_BASKETS,$sql_from0);
				//
				//Delete all baskets 6 month or older start
				//
				$date=date('Ymd',mktime(0, 0, 0, date("m")-6, date("d"), date("Y")));
				$sql_date=" and basket_last_used <= '".$date.APOS;
				$saved_carts=olc_db_query($sql_select_from.$sql_date);
				$sql_delete_from0=DELETE_FROM."#1 where customers_basket_id = '#2'";
				if (olc_db_num_rows($saved_carts)>0)
				{
					while ($save_cart=olc_db_fetch_array($saved_carts))
					{
						$basket_id=$save_cart['customers_basket_id'];
						$sql_delete_from=
						str_replace($param_array,array(TABLE_CUSTOMERS_BASKET_SAVE,$basket_id),$sql_delete_from0);
						olc_db_query($sql_delete_from);
						$sql_delete_from=
						str_replace($param_array,array(TABLE_CUSTOMERS_BASKET_ATTRIBUTES_SAVE,$basket_id),$sql_delete_from0);
						olc_db_query($sql_delete_from);
					}
				}
				//
				//Delete all baskets 6 month or older end
				//
				$saved_carts_sql=$sql_select_from;
				$saved_carts=olc_db_query($saved_carts_sql);
				$carts_saved=olc_db_num_rows($saved_carts);
				$_SESSION[$have_saved_carts_text]=$carts_saved>0;
				$_SESSION[$nr_saved_carts_text]=$carts_saved;
				$_SESSION[$checked_saved_carts_text]=true;
			}
			$show_cart_restore=$_SESSION[$have_saved_carts_text] || $_SESSION['id'.$saved_carts_text];
			if ($show_cart_restore)
			{
				$box_smarty->assign('SHOW_CART_RESTORE',true);
				$box_smarty->assign('CARTS_TO_RESTORE',$_SESSION[$nr_saved_carts_text]);
			}
		}
	}
	//W. Kaiser - Allow save/restore of cart
}
$box_smarty->assign('empty_cart',$empty_cart);
$box_shopping_cart= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_cart'.HTML_EXT,$cacheid);
$smarty->assign('box_CART',$box_shopping_cart);
?>