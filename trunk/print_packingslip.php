<?php
/* -----------------------------------------------------------------------------------------
$Id: print_packingslip.php,v 1.1.1.1.2.1 2007/04/08 07:16:18 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (print_order.php,v 1.1 2003/08/19); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$IsAdminFunction=$_GET['admin'];
include('includes/application_top.php');
$oID=(int)$_GET['oID'];
// check if cusotmer is allowed to see this order!
$order_query_check = olc_db_query("SELECT customers_id FROM ".TABLE_ORDERS." WHERE orders_id='".$oID.APOS);
$order_check = olc_db_fetch_array($order_query_check);
IF ($IsAdminFunction)
{
	$see=true;
}
else
{
	$see=CUSTOMER_ID == $order_check['customers_id'];
}
if ($see)
{
	require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'order.php');
	$order = new order($_GET['oID']);
	if (INCLUDE_PDF_INVOICE)
	{
		$print_packing_slip=true;
		$is_admin_function=$_GET['admin'];
		include(ADMIN_PATH_PREFIX.FILENAME_ORDERS_INVOICE_PDF);
	}
	else
	{

		// include needed functions
		require_once(DIR_FS_INC.'olc_get_products_price.inc.php');
		require_once(DIR_FS_INC.'olc_get_order_data.inc.php');
		require_once(DIR_FS_INC.'olc_get_attributes_model.inc.php');
		require_once(DIR_FS_INC.'olc_not_null.inc.php');
		require_once(DIR_FS_INC.'olc_format_price_order.inc.php');

		$format_id='format_id';
		$smarty->assign('address_label_customer',olc_address_format($order->customer[$format_id], $order->customer, 1,
		EMPTY_STRING, HTML_BR));
		$smarty->assign('address_label_shipping',olc_address_format($order->delivery[$format_id], $order->delivery, 1,
		EMPTY_STRING, HTML_BR));
		$smarty->assign('address_label_payment',olc_address_format($order->billing[$format_id], $order->billing, 1,
		EMPTY_STRING, HTML_BR));
		$smarty->assign('csID',$order->customer['csID']);
		// get products data
		$order_query=olc_db_query("SELECT
        				products_id,
        				orders_products_id,
        				products_model,
        				products_name,
        				final_price,
        				products_quantity
        				FROM ".TABLE_ORDERS_PRODUCTS."
        				WHERE orders_id='".$oID.APOS);
		$order_data=array();
		while ($order_data_values = olc_db_fetch_array($order_query))
		{
			$attributes_query=olc_db_query("SELECT
        				products_options,
        				products_options_values,
        				price_prefix,
        				options_values_price
        				FROM ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES."
        				WHERE orders_products_id='".$order_data_values['orders_products_id'].APOS);
			$attributes_data=EMPTY_STRING;
			$attributes_model=EMPTY_STRING;
			while ($attributes_data_values = olc_db_fetch_array($attributes_query))
			{
				$attributes_data .=HTML_BR.$attributes_data_values['products_options'].': '.
				$attributes_data_values['products_options_values'];
				$attributes_model .=HTML_BR.olc_get_attributes_model($order_data_values['products_id'],
				$attributes_data_values['products_options_values']);
			}
			$order_data[]=array(
			'PRODUCTS_MODEL' => $order_data_values['products_model'],
			'PRODUCTS_NAME' => $order_data_values['products_name'],
			'PRODUCTS_ATTRIBUTES' => $attributes_data,
			'PRODUCTS_ATTRIBUTES_MODEL' => $attributes_model,
			'PRODUCTS_PRICE' =>  olc_format_price_order($order_data_values['final_price'],1,$order->info['currency']),
			'PRODUCTS_QTY' => $order_data_values['products_quantity']);
		}
		// get order_total data
		$oder_total_query=olc_db_query("SELECT
                      title,
                      text,
                      class,
                      value,
                      sort_order
                      FROM ".TABLE_ORDERS_TOTAL."
                      WHERE orders_id='".$oID."'
                      ORDER BY sort_order ASC");

		$order_total=array();
		while ($oder_total_values = olc_db_fetch_array($oder_total_query)) {

			$order_total[]=array(
			'TITLE' => $oder_total_values['title'],
			'CLASS'=> $oder_total_values['class'],
			'VALUE'=> $oder_total_values['value'],
			'TEXT' => $oder_total_values['text']);
			if ($oder_total_values['class']='ot_total') $total=$oder_total_values['value'];
		}
		$smarty->assign('oID',$oID);
		if ($order->info['payment_method']!=EMPTY_STRING && $order->info['payment_method']!='no_payment') {
			include(DIR_FS_CATALOG.'lang/'.SESSION_LANGUAGE.'/modules/payment/'.$order->info['payment_method'].PHP);
			$payment_method=constant(strtoupper('MODULE_PAYMENT_'.$order->info['payment_method'].'_TEXT_TITLE'));
			$smarty->assign('PAYMENT_METHOD',$payment_method);
		}
		$smarty->assign('DATE',olc_date_long($order->info['date_purchased']));
		$smarty->assign('order_data', $order_data);
		$smarty->assign('order_total', $order_total);
		$smarty->display(ADMIN_PATH_PREFIX.FULL_CURRENT_TEMPLATE . 'admin/print_packingslip'.HTML_EXT);
	}
} else {
	$smarty->assign('ERROR',TEXT_NO_ORDER_DISPLAY);
	$smarty->display(CURRENT_TEMPLATE_MODULE . 'error_message'.HTML_EXT);
}
?>