<?php
/* -----------------------------------------------------------------------------------------
$Id: admin.php,v 1.4 2004/04/21 17:56:34 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
(c) 2003	    nextcommerce (admin.php,v 1.12 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

olc_smarty_init($box_smarty,$cacheid);

$select="select count(*) as count from ";

$customers_query = olc_db_query($select . TABLE_CUSTOMERS);
$customers = olc_db_fetch_array($customers_query);
$products_query = olc_db_query($select . TABLE_PRODUCTS . " where products_status = '1'");
$products = olc_db_fetch_array($products_query);
$reviews_query = olc_db_query($select . TABLE_REVIEWS);
$reviews = olc_db_fetch_array($reviews_query);

$orders_status_query = olc_db_query("select orders_status_name, orders_status_id from " .
TABLE_ORDERS_STATUS ." where language_id = '" . SESSION_LANGUAGE_ID . "' order by orders_status_id");
while ($orders_status = olc_db_fetch_array($orders_status_query))
{
	$orders_status_id=$orders_status['orders_status_id'];
	$orders_pending_query = olc_db_query($select . TABLE_ORDERS .
	" where orders_status = '" . $orders_status_id . APOS);
	$orders_pending = olc_db_fetch_array($orders_pending_query);
	$orders_contents .= HTML_A_START . olc_href_link(FILENAME_ORDERS, 'selected_box=customers&status=' .
	$orders_status_id, SSL) . '">' . $orders_status['orders_status_name'] . '</a>: ' .
	$orders_pending['count'] . HTML_BR;
	if ($orders_status_id==3)
	{
		if (USE_PAYPAL_IPN)
		{
			$orders_contents .= '<b>PayPal-Status</b>' . HTML_BR;
		}
		else
		{
			break;
		}
	}
}
//$orders_contents = substr($orders_contents, 0, -4);
//W. Kaiser - AJAX
$admin_image =CURRENT_TEMPLATE_BUTTONS.'button_admin.gif';
if (!file_exists($admin_image))
{
	$admin_image=DIR_WS_IMAGES.'admin_button.gif';
}

$admin_link .= ' target="_blank"';
if (USE_AJAX)
{
	$parameter=AJAX_ID;
}
else
{
	$parameter=EMPTY_STRING;
}
$link=olc_href_link(FILENAME_START,$parameter);
$admin_link = HTML_A_START .$link.QUOTE.$admin_link .'>'.olc_image($admin_image).'</a><br/>';
//W. Kaiser - AJAX
$products_id=$_GET['products_id'];
if ($products_id)
{
	$edit_product_gif='edit_product.gif';
	$admin_edit_link =CURRENT_TEMPLATE_BUTTONS.'button_'.$edit_product_gif;
	if (!file_exists($admin_edit_link))
	{
		$admin_edit_link=DIR_WS_ICONS . $edit_product_gif;
	}
	$admin_edit_link=HTML_A_START . olc_href_link(FILENAME_EDIT_PRODUCTS, 'cPath=' . $cPath .
	'&pID=' . $products_id) .	'&action=new_product' .
	'" onclick="javascript:window.open(this.href); return false;">' . olc_image($admin_edit_link) . '</a><br/>';
}

$box_content=
HTML_B_START . BOX_TITLE_STATISTICS . HTML_B_END.HTML_BR .
BOX_ENTRY_CUSTOMERS . BLANK . $customers['count'] . HTML_BR .
BOX_ENTRY_PRODUCTS . BLANK . $products['count'] . HTML_BR .
BOX_ENTRY_REVIEWS . BLANK . $reviews['count'] .HTML_BR .
HTML_HR .
HTML_B_START . BOX_TITLE_ORDERS_STATUS . HTML_B_END.HTML_BR .
$orders_contents.
HTML_BR .$admin_link .
HTML_BR .$admin_edit_link;
$box_smarty->assign('BOX_CONTENT', $box_content);
$box_admin= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_admin'.HTML_EXT,$cacheid);
$smarty->assign('box_ADMIN',$box_admin);
?>