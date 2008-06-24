<?php
/* -----------------------------------------------------------------------------------------
$Id: order_history.php,v 1.1 2004/02/07 23:02:54 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(order_history.php,v 1.4 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (order_history.php,v 1.9 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
olc_smarty_init($box_smarty,$cacheid);
$box_content='';
// include needed functions
require_once(DIR_FS_INC.'olc_get_all_get_params.inc.php');
if (ISSET_CUSTOMER_ID)
{
	// retreive the last x products purchased
	$orders_query = olc_db_query("select distinct op.products_id from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS .
	" op, " . TABLE_PRODUCTS . " p where o.customers_id = " . CUSTOMER_ID .
	" and o.orders_id = op.orders_id and op.products_id = p.products_id and p.products_status = 1
    group by products_id order by o.date_purchased desc limit " . MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX);
	if (olc_db_num_rows($orders_query))
	{
		$product_ids = EMPTY_STRING;
		while ($orders = olc_db_fetch_array($orders_query))
		{
			$product_ids .= $orders['products_id'] . COMMA;
		}
		$product_ids = substr($product_ids, 0, -1);
		$customer_orders_string = '<table border="0" width="100%" cellspacing="0" cellpadding="1">';
		$products_query = olc_db_query("select products_id, products_name from " . TABLE_PRODUCTS_DESCRIPTION .
		" where products_id in (" . $product_ids . ") and language_id = '" . SESSION_LANGUAGE_ID .
		"' order by products_name");
		while ($products = olc_db_fetch_array($products_query))
		{
			$link=olc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products['products_id']).'">';
			$customer_orders_string .= '  <tr>' .
			'    <td class="infoBoxContents"><a href="' .$link .$products['products_name'] . '</a></td>' .
			'    <td class="infoBoxContents" align="right" valign="top"><a href="' .
			olc_href_link(CURRENT_SCRIPT, olc_get_all_get_params(array('action')) .
			'action=cust_order&pid=' . $products['products_id']) . '">' .
			olc_image(DIR_WS_ICONS . 'cart.gif', ICON_CART) . '</a></td>' .
			'  </tr>';
		}
		$customer_orders_string .= '</table>';
	}
}
$box_smarty->assign('BOX_CONTENT', $customer_orders_string);
$box_order_history= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_order_history'.HTML_EXT,$cacheid);
$smarty->assign('box_ORDER_HISTORY',$box_order_history);
?>