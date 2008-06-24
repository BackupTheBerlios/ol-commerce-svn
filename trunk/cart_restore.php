<?php
/* --------------------------------------------------------------
$Id: cart_restore.php,v 1.0

Restore cart fro previous visit

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce www.oscommerce.com
(c) 2003	 nextcommerce www.nextcommerce.org
(c) 2004  XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

require('includes/application_top.php');
$action=$_GET['action'];
if ($action=="delete")
{
	$_SESSION['cart']->reset(true);
	$force_cart_update_only=true;
	require(BOXES);
	$smarty->display(INDEX_HTML);
}
else
{
	$sql_where=" where ";
	$where_cid=$sql_where."customers_id='".CUSTOMER_ID.APOS;
	if ($_GET['process'])
	{
		$cart_delete_text='cart_delete';
		$delete_cart=isset($_POST[$cart_delete_text]);
		if ($delete_cart)
		{
			$id_saved_carts_text='id_saved_carts';
			$sql_delete=DELETE_FROM;
			while (list($key, $value) = each($_POST[$cart_delete_text]))
			{
				$basket_id=$value;
				if ($basket_id==$_SESSION[$id_saved_carts_text])
				{
					unset($_SESSION[$id_saved_carts_text]);
				}
				$where_bid=$sql_where."customers_basket_id='".$basket_id.APOS;
				$basket_query = olc_db_query($sql_delete . TABLE_CUSTOMERS_BASKET_SAVE_BASKETS . $where_bid);
				$basket_query = olc_db_query($sql_delete . TABLE_CUSTOMERS_BASKET_SAVE . $where_bid);
				$basket_query = olc_db_query($sql_delete . TABLE_CUSTOMERS_BASKET_ATTRIBUTES_SAVE . $where_bid);
			}
			
			unset($_SESSION['checked_saved_carts']);
			$force_cart_update_only=true;
						$show_form=true;
		}
		else
		{
			$basket_id=$_POST['cart_select'][0];
			$select_cart=$basket_id>0;
			if ($select_cart)
			{
				$where_bid=$sql_where."customers_basket_id='".$basket_id.APOS;
				$basket_query=olc_db_query("select basket_name from ".
				TABLE_CUSTOMERS_BASKET_SAVE_BASKETS.$where_bid);
				if (olc_db_num_rows($basket_query)>0)
				{
					$basket = olc_db_fetch_array($basket_query);
					$cart_name=$basket['basket_name'];
					$products_query = olc_db_query(SELECT_ALL . TABLE_CUSTOMERS_BASKET_SAVE . $where_bid);
					if (olc_db_num_rows($products_query))
					{
						$add_cart=$_POST['add_cart'];
						if (!$add_cart)
						{
							$_SESSION['cart']->reset(true);
						}
						$product_id_sql="products_id='#'";
						$where_bid_and=$where_bid. " and ";
						$product_query_sql="select products_model,products_status from ".TABLE_PRODUCTS.$sql_where.$product_id_sql;
						$unavailable=EMPTY_STRING;
						while ($product = olc_db_fetch_array($products_query))
						{
							$products_name=EMPTY_STRING;
							$products_id=$product['products_id'];
							//Make sure, product still exists
							$product_query = olc_db_query(str_replace(HASH,$products_id,$product_query_sql));
							$available=olc_db_num_rows($product_query)>0;
							if ($available)
							{
								$current_product= olc_db_fetch_array($product_query);
								$products_status=$current_product['products_status'];
								$products_model=$current_product['products_model'];
								if ($products_status==1)
								{
									$qty=$product['customers_basket_quantity'];
									$attributes = array();
									$product_attribute_query =
									olc_db_query(SELECT_ALL . TABLE_CUSTOMERS_BASKET_ATTRIBUTES_SAVE . $where_bid_and .
									str_replace(HASH,$products_id,$product_id_sql));
									if (olc_db_num_rows($product_attribute_query)>0)
									{
										while ($product_attribute = olc_db_fetch_array($product_attribute_query))
										{
											$attributes[$product_attribute['products_options_id']]=
											$product_attribute['products_options_value_id'];
										}
									}
									if ($add_cart)
									{
										$qty+=$_SESSION['cart']->contents[$products_id]['qty'];
									}
									$_SESSION['cart']->add_cart($products_id, $qty, $attributes);
								}
								else
								{
									$available=false;
									$product_query =olc_db_query("select products_name" . TABLE_PRODUCTS_DESCRIPTION . $sql_where.
									str_replace(HASH,$products_id,$product_id_sql));
									if (olc_db_query($product_query)>0)
									{
										$products_description=olc_db_fetch_array($products_description);
										$products_name=$products_description['products_name'];
									}
								}
							}
							else
							{
								$products_name=EMPTY_STRING;
								$products_model=$products_id;
							}
							if (!$available)
							{
								if ($unavailable)
								{
									$unavailable.=HTML_BR;
								}
								else
								{
									$unavailable.=TEXT_PRODUCTS_NOT_AVAILABLE;
								}
								$unavailable.=trim($products_name.LPAREN.$products_model.RPAREN);
							}
						}
					}
					olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS_BASKET_SAVE_BASKETS .
					" set basket_last_used='".date('Ymd').APOS. $where_bid);
					$force_cart_update_only=true;
										$show_form=true;
					$error_message=olc_get_smarty_config_variable($smarty,'shopping_cart','text_restored_cart');
					$error_message=str_replace(HASH,$cart_name,$error_message).$unavailable;
				}
				else
				{
					$show_form=true;
					$error_message=olc_get_smarty_config_variable($smarty,'boxes','text_empty_cart');
				}
			}
			else
			{
				$show_form=true;
			}
		}
	}
	else
	{
		$show_form=true;
		$bid=$_GET['basket_id'];
	}
	if ($show_form)
	{
		/*
		if ($bid)
		{
		$where=$where_bid;
		}
		else
		{
		$where=$where_cid;
		}
		*/
		olc_smarty_init($module_smarty,$cache_id);
		$basket_query = olc_db_query(SELECT_ALL . TABLE_CUSTOMERS_BASKET_SAVE_BASKETS . $where_cid .
		' order by basket_date_added DESC');
		if (olc_db_num_rows($basket_query))
		{
			require_once(DIR_FS_INC.'olc_draw_radio_field.inc.php');
			require_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');
			require_once(DIR_FS_INC.'olc_get_prid.inc.php');
			require_once(DIR_FS_INC.'olc_get_smarty_config_variable.inc.php');
			$module_content = array();
			while ($basket = olc_db_fetch_array($basket_query))
			{
				$basket_id=$basket['customers_basket_id'];
				$show_order_details=$basket_id==$bid;
				if ($show_order_details)
				{
					$where_bid=$sql_where."customers_basket_id='".$basket_id.APOS;
					$products_basket_query = olc_db_query(SELECT_ALL . TABLE_CUSTOMERS_BASKET_SAVE . $where_bid);
					if (olc_db_num_rows($products_basket_query)>0)
					{
						$products_query_sql0=olc_standard_products_query();
						/*
						$products_query_sql0="
						select
						p.products_id,
						pd.products_name,
						p.products_image,
						p.products_model,
						p.products_price,
						p.products_discount_allowed,
						p.products_weight,
						p.products_tax_class_id
						from " .
						TABLE_PRODUCTS . " p, " .
						TABLE_PRODUCTS_DESCRIPTION . " pd
						where
						p.products_id='#' and
						pd.products_id = p.products_id and
						pd.language_id = '" . SESSION_LANGUAGE_ID . APOS;
						*/
						$products = array();
						$price_raw=0;
						while ($products_basket = olc_db_fetch_array($products_basket_query))
						{
							$products_id=$products_basket['products_id'];
							$prid=olc_get_prid($products_id);
							$products_query_sql=str_replace(HASH,$prid,$products_query_sql0);
							$products_query = olc_db_query($products_query_sql);
							if ($current_product = olc_db_fetch_array($products_query))
							{
								$products_price = abs(olc_get_products_price($prid,
								$price_special=0, $quantity=1));
								$price_raw+=$products_price;
								$products[] = array(
								'id' => $products_id,
								'name' => $current_product['products_name'],
								'model' => $current_product['products_model'],
								'image' => $current_product['products_image'],
								'price' => $current_product_price,
								'discount_allowed' => $current_product['products_discount_allowed'],
								'quantity' => $products_basket['customers_basket_quantity'],
								'weight' => $current_product['products_weight'],
								'final_price' => $products_price,
								'tax_class_id' => $current_product['products_tax_class_id']);
							}
						}
						$show_saved_cart=true;
						$module_content_save=$module_content;
						include_once(DIR_WS_MODULES.'order_details_cart.php');
						$module_content=$module_content_save;
						$show_saved_cart=false;
					}
				}
				else
				{
					$parameters='basket_id=' . $basket_id;
					$cart_content=EMPTY_STRING;
				}
				$link=olc_href_link(CURRENT_SCRIPT, $parameters);
				$date=$basket['basket_date_added'];
				$date=substr($date,6,2).DOT.substr($date,4,2).DOT.substr($date,0,4);
				$module_content[] = array(
				'show_order_details' => $show_order_details,
				'BOX_SELECT' => olc_draw_radio_field('cart_select[]',$basket_id,$selected),
				'NAME' => $basket['basket_name'],
				'DATE' => $date,
				'BOX_DELETE' => olc_draw_checkbox_field('cart_delete[]',$basket_id),
				'LINK' => $link
				);
			}
		}
		else
		{
			$error_message=olc_get_smarty_config_variable($smarty,'shopping_cart','text_no_saved_cart');
		}
		$cart_restore_text='cart_restore';
		if ($error_message)
		{
			$module_smarty->assign('ERROR_MESSAGE',$error_message);
		}
		else
		{
			$module_smarty->assign(MODULE_CONTENT,$module_content);
			if ($bid)
			{
				$MODULE_order_details_text='MODULE_order_details';
				$module_smarty->assign($MODULE_order_details_text,$smarty->_tpl_vars[$MODULE_order_details_text]);
				$smarty->assign($MODULE_order_details_text,EMPTY_STRING);
			}
		}
		$module_smarty->assign('FORM_ACTION',olc_draw_form($cart_restore_text,
		$cart_restore_text.PHP.'?process=true'));
		$module_smarty->assign('BUTTON_CONTINUE',olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
		$main_content=$module_smarty->fetch(CURRENT_TEMPLATE_MODULE.$cart_restore_text.HTML_EXT,$cache_id);
		$smarty->assign(MAIN_CONTENT,$main_content);
		require(BOXES);
		$smarty->display(INDEX_HTML);
	}
}
?>
