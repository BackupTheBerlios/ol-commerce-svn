<?php
/* -----------------------------------------------------------------------------------------
$Id: account.php,v 1.1.1.1.2.1 2007/04/08 07:16:02 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project (earlier name of osCommerce)
(c) 2002-2003 osCommerce (account.php,v 1.59 2003/05/19); www.oscommerce.com
(c) 2003      nextcommerce (account.php,v 1.12 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include('includes/application_top.php');


// include needed functions
require_once (DIR_FS_INC.'olc_count_customer_orders.inc.php');
require_once (DIR_FS_INC.'olc_date_short.inc.php');
require_once (DIR_FS_INC.'olc_image_button.inc.php');

if (!olc_session_is_registered('customer_id'))
{
	olc_redirect(olc_href_link(FILENAME_LOGIN));
}

$breadcrumb->add(NAVBAR_TITLE_ACCOUNT, olc_href_link(FILENAME_ACCOUNT));

require(DIR_WS_INCLUDES . 'header.php');


if (is_object($messageStack))
{
	if ($messageStack->size('account') > 0)
	{
		$smarty->assign('error_message',$messageStack->output('account'));
	}
}
if ($_GET['products_history'])
{
	require_once (DIR_FS_INC.'olc_get_product_path.inc.php');
	require_once (DIR_FS_INC.'olc_get_products_name.inc.php');
	require_once (DIR_FS_INC.'olc_get_products_price_specials.inc.php');
	$products_id_par='products_id=';
	$params=olc_get_all_get_params(array ('action')).'action=buy_now&BUY'.$products_id_par;
	$buy_now_link=HTML_A_START.olc_href_link(basename($PHP_SELF),$params.HASH).'">'.
	olc_image_button('button_buy_now.gif', TEXT_BUY.ATSIGN.TEXT_NOW).HTML_A_END;
	$product_link=olc_href_link(FILENAME_PRODUCT_INFO, $products_id_par.HASH);
	$cat_path=olc_href_link(FILENAME_DEFAULT, 'cPath='.HASH);
	$img=olc_image(DIR_WS_THUMBNAIL_IMAGES.HASH,ATSIGN);

	$tracking_products_history=$_SESSION[TRACKING][PRODUCTS_HISTORY];
	$i = 0;
	$max = count($tracking_products_history);
	while ($i < $max)
	{
		$products_id=$tracking_products_history[$i];
		$product_history_query = olc_db_query(
		SELECT_ALL.TABLE_PRODUCTS."
		where
		products_status = 1 and
		products_id = ".$products_id);
		$history_product = olc_db_fetch_array($product_history_query);
		if ($history_product['products_status'] != 0)
		{
			$products_name = olc_get_products_name($products_id);
			$products_image = $history_product['image'];
			$products_price=olc_get_products_price_specials($products_id, $price_special=1, $quantity=1,
			$price_special_info,$products_price_real);
			if ($products_price_real<0)
			{
				$products_price=olc_format_price(abs($products_price_real), true,  true, true);
			}
			$buy_now =str_replace(HASH,$products_id,$buy_now_link);
			$buy_now =str_replace(ATSIGN,$products_name,$buy_now );
			$cpath = olc_get_product_path($products_id);
			$products_image=str_replace(HASH,$products_image,$img);
			$products_image=str_replace(ATSIGN,$products_name,$products_image);
			$products_history[] = array (
			'PRODUCTS_NAME' => $products_name,
			'PRODUCTS_IMAGE' => $products_image,
			'PRODUCTS_PRICE' => $products_price,
			'PRODUCTS_URL' => str_replace(HASH,$products_id,$product_link),
			'PRODUCTS_CATEGORY_URL' => str_replace(HASH,$cpath,$cat_path),
			'BUY_NOW_BUTTON' => $buy_now);
			$i++;
		}
	}
	$smarty->assign('products_history', $products_history);
}
else
{
	$order_content=array();
	if (olc_count_customer_orders() > 0)
	{
		$orders_query = olc_db_query(	"
		select
	  o.orders_id,
	  o.date_purchased,
	  o.delivery_name,
	  o.delivery_country,
	  o.billing_name,
	  o.billing_country,
	  ot.text as order_total,
	  s.orders_status_name
	  from " .
		TABLE_ORDERS . " o, " .
		TABLE_ORDERS_TOTAL . " ot, " .
		TABLE_ORDERS_STATUS . " s
	  where
	  o.customers_id = '" . CUSTOMER_ID . "' and
	  o.orders_id = ot.orders_id and
	  ot.class = 'ot_total' and
	  o.orders_status = s.orders_status_id and
	  s.language_id = '" . SESSION_LANGUAGE_ID . "'
	  order by orders_id desc limit 3");
		while ($orders = olc_db_fetch_array($orders_query))
		{
			$order_name=$orders['delivery_name'];
			if ($order_name)
			{
				$order_country = $orders['delivery_country'];
			}
			else
			{
				$order_name = $orders['billing_name'];
				$order_country = $orders['billing_country'];
			}
			$orders_id=$orders['orders_id'];
			$order_content[]=array(
			'ORDER_ID' =>$orders_id,
			'ORDER_DATE' =>olc_date_short($orders['date_purchased']),
			'ORDER_STATUS' =>$orders['orders_status_name'],
			'ORDER_TOTAL' =>$orders['order_total'],
			'ORDER_LINK' => olc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders_id, SSL) ,
			'ORDER_BUTTON' =>
			HTML_A_START.olc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' .$orders_id, SSL) . '">' .
			olc_image_button('small_view.gif', SMALL_IMAGE_BUTTON_VIEW) . HTML_A_END);
		}
	}
	$smarty->assign('LINK_EDIT',olc_href_link(FILENAME_ACCOUNT_EDIT));
	$smarty->assign('LINK_ADDRESS',olc_href_link(FILENAME_ADDRESS_BOOK));
	$smarty->assign('LINK_PASSWORD',olc_href_link(FILENAME_ACCOUNT_PASSWORD));
	$smarty->assign('LINK_ORDERS',olc_href_link(FILENAME_ACCOUNT_HISTORY));
	$smarty->assign('LINK_NEWSLETTER',olc_href_link(FILENAME_NEWSLETTER));
	$smarty->assign('LINK_NOTIFICATIONS',olc_href_link(FILENAME_ACCOUNT_NOTIFICATIONS));
	//$smarty->assign('LINK_ALL',olc_href_link(FILENAME_ACCOUNT_HISTORY));
	$smarty->assign('order_content',$order_content);
}
//$smarty->assign('also_purchased_history', $also_purchased_history);
$main_content= $smarty->fetch(CURRENT_TEMPLATE_MODULE.'account'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>