<?php 
/* --------------------------------------------------------------
$Id: cart_save.php,v 1.0

Save cart for later reuse

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce www.oscommerce.com
(c) 2003	    nextcommerce www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

require('includes/application_top.php');
$cart_name0=NAVBAR_TITLE_SHOPPING_CART. ' - ' . date('H:i:s');
if ($_GET['process'])
{
	$where_cid=" where customers_id='".CUSTOMER_ID.APOS;
	$sql_select="select * from ";
	$product_query = olc_db_query($sql_select . TABLE_CUSTOMERS_BASKET . $where_cid);
	if (olc_db_num_rows($product_query))
	{

		$id_saved_carts_text='id_saved_carts';
		$basket_id=$_SESSION[$id_saved_carts_text];
		if ($basket_id)
		{
			$where_bid=" where customers_basket_id='".$basket_id.APOS;
			$sql_delete=DELETE_FROM;
			$basket_query = olc_db_query($sql_delete . TABLE_CUSTOMERS_BASKET_SAVE_BASKETS . $where_bid);
			$basket_query = olc_db_query($sql_delete . TABLE_CUSTOMERS_BASKET_SAVE . $where_bid);
			$basket_query = olc_db_query($sql_delete . TABLE_CUSTOMERS_BASKET_ATTRIBUTES_SAVE . $where_bid);
		}
		$cart_name=trim($_POST[NAVBAR_TITLE_SHOPPING_CART]);
		if (!$cart_name)
		{
			$cart_name=$cart_name0;
		}
		//Insert cart-control-data
		$sql_data_array = array();
		$sql_data_array['customers_id']=CUSTOMER_ID;
		$sql_data_array['basket_name']=$cart_name;
		$date=date('Ymd');
		$sql_data_array['basket_date_added']=$date;
		$sql_data_array['basket_last_used']=$date;
		olc_db_perform(TABLE_CUSTOMERS_BASKET_SAVE_BASKETS,$sql_data_array);
		$basket_id=olc_db_insert_id($basket_query);
		//Save cart products
		$sql_data_array = array();
		while ($products = olc_db_fetch_array($product_query))
		{
			while (list($name, $value) = each($products))
			{
				$sql_data_array[$name]=$value;
			}
			$sql_data_array['customers_basket_id']=$basket_id;
			olc_db_perform(TABLE_CUSTOMERS_BASKET_SAVE,$sql_data_array);
		}

		//Save cart products attributes
		$product_query = olc_db_query($sql_select . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . $where_cid);
		if (olc_db_num_rows($product_query)>0)
		{
			$sql_data_array = array();
			while ($products = olc_db_fetch_array($product_query))
			{
				while (list($name, $value) = each($products))
				{
					$sql_data_array[$name]=$value;
				}
				$sql_data_array['customers_basket_id']=$basket_id;
				olc_db_perform(TABLE_CUSTOMERS_BASKET_ATTRIBUTES_SAVE,$sql_data_array);
			}
		}
		$force_cart_update_only=true;
		unset($_SESSION['checked_saved_carts']);
		
		$_SESSION[$id_saved_carts_text]=$basket_id;
				$show_form=true;
		$error_message=olc_get_smarty_config_variable($smarty,'shopping_cart','text_saved_cart');
		$error_message=str_replace(HASH,$cart_name,$error_message);
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
if ($show_form)
{
	olc_smarty_init($module_smarty,$cache_id);
	$cart_save_text='cart_save';
	if ($error_message)
	{
		$module_smarty->assign('ERROR_MESSAGE',$error_message);
	}
	else
	{
		$module_smarty->assign('FORM_ACTION',olc_draw_form($cart_save_text, $cart_save_text.PHP.'?process=true'));
		$module_smarty->assign('BUTTON_CONTINUE',olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
		$module_smarty->assign('main_content',
		olc_draw_input_field(NAVBAR_TITLE_SHOPPING_CART,$cart_name0,'size="80"'));
		unset($_SESSION['checked_saved_carts']);
	}
	$main_content=$module_smarty->fetch(CURRENT_TEMPLATE_MODULE.$cart_save_text.HTML_EXT,$cache_id);
	$smarty->assign(MAIN_CONTENT,$main_content);

	/*	$button_back=HTML_A_START . olc_href_link(FILENAME_START, '', NONSSL) . '">' .
	olc_image_button('button_back.gif', 'Zurück zur Startseite') . HTML_A_END;
	$smarty->assign('BUTTON_BACK',$button_back);
	*/
	require(BOXES);
$smarty->display(INDEX_HTML);
}
?>
