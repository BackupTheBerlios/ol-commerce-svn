<?php
/* -----------------------------------------------------------------------------------------
$Id: account_history.php,v 1.1.1.1.2.1 2007/04/08 07:16:02 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(account_history.php,v 1.60 2003/05/27); www.oscommerce.com
(c) 2003	    nextcommerce (account_history.php,v 1.13 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include( 'includes/application_top.php');

// include needed functions
require_once(DIR_FS_INC.'olc_count_customer_orders.inc.php');
require_once(DIR_FS_INC.'olc_date_long.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');
require_once(DIR_FS_INC.'olc_get_all_get_params.inc.php');

if (!isset($_SESSION['customer_id']))
{
	olc_redirect(olc_href_link(FILENAME_LOGIN, '', SSL));
}

$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_HISTORY, olc_href_link(FILENAME_ACCOUNT, '', SSL));
$breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_HISTORY, olc_href_link(FILENAME_ACCOUNT_HISTORY, '', SSL));

require(DIR_WS_INCLUDES . 'header.php');

$module_content=array();
if (($orders_total = olc_count_customer_orders()) > 0) {
	$history_query_raw = "select o.orders_id, o.date_purchased, o.delivery_name, o.billing_name, ot.text as order_total, s.orders_status_name from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$_SESSION['customer_id'] . "' and o.orders_id = ot.orders_id and ot.class = 'ot_total' and o.orders_status = s.orders_status_id and s.language_id = '" . SESSION_LANGUAGE_ID . "' order by orders_id DESC";
	$history_split = new splitPageResults($history_query_raw, $_GET['page'], MAX_DISPLAY_ORDER_HISTORY);
	$history_query = olc_db_query($history_split->sql_query);
	while ($history = olc_db_fetch_array($history_query)) {
		$products_query = olc_db_query("select count(*) as count from " . TABLE_ORDERS_PRODUCTS .
		" where orders_id = '" . $history['orders_id'] . APOS);
		$products = olc_db_fetch_array($products_query);
		if (olc_not_null($history['delivery_name'])) {
			$order_type = TEXT_ORDER_SHIPPED_TO;
			$order_name = $history['delivery_name'];
		} else {
			$order_type = TEXT_ORDER_BILLED_TO;
			$order_name = $history['billing_name'];
		}
		$module_content[]=array(
		'ORDER_ID'=>$history['orders_id'],
		'ORDER_STATUS'=>$history['orders_status_name'],
		'ORDER_DATE'=>olc_date_long($history['date_purchased']),
		'ORDER_PRODUCTS'=>$products['count'],
		'ORDER_TOTAL'=>strip_tags($history['order_total']),
		'ORDER_BUTTON'=>HTML_A_START . olc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'page=' . $_GET['page'] .
		'&order_id=' . $history['orders_id'], SSL) . '">' . olc_image_button('small_view.gif', SMALL_IMAGE_BUTTON_VIEW) . HTML_A_END);
	}
}
if ($orders_total > 0)
{
	$smarty->assign('SPLIT_BAR','
          <tr>
            <td class="smallText" valign="top">'. $history_split->display_count(TEXT_DISPLAY_NUMBER_OF_ORDERS).'</td>
            <td class="smallText" align="right">'. TEXT_RESULT_PAGE . BLANK . $history_split->display_links(MAX_DISPLAY_PAGE_LINKS, olc_get_all_get_params(array('page', 'info', 'x', 'y'))).'</td>
          </tr>');

}
$smarty->assign('order_content',$module_content);
$smarty->assign('BUTTON_BACK',HTML_A_START . olc_href_link(FILENAME_ACCOUNT, '', SSL) . '">' . olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END);
$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'account_history'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>