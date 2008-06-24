<?php
/* -----------------------------------------------------------------------------------------
$Id: print_order.php,v 1.1.1.1.2.1 2007/04/08 07:16:18 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (print_order.php,v 1.5 2003/08/24); www.nextcommerce.org
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
	// get order data
	include_once(DIR_WS_CLASSES . 'order.php');
	$order = new order($oID);
	if (INCLUDE_PDF_INVOICE)
	{
		$_GET['print_order']=true;
		include(FILENAME_ORDERS_INVOICE_PDF);
	}
	else
	{
		// include needed functions
		require_once(DIR_FS_INC.'olc_get_products_price.inc.php');
		require_once(DIR_FS_INC.'olc_get_order_data.inc.php');
		require_once(DIR_FS_INC.'olc_get_attributes_model.inc.php');
		require_once(DIR_FS_INC.'olc_format_price_order.inc.php');

		$format_id='format_id';
		$address_label='address_label_';
		$smarty->assign($address_label.'customer',olc_address_format($order->customer[$format_id], $order->customer, 1,
		EMPTY_STRING, HTML_BR));
		$smarty->assign($address_label.'shipping',olc_address_format($order->delivery[$format_id], $order->delivery, 1,
		EMPTY_STRING, HTML_BR));
		$smarty->assign($address_label.'payment',olc_address_format($order->billing[$format_id], $order->billing, 1,
		EMPTY_STRING, HTML_BR));
		$smarty->assign('csID',$order->customer['csID']);
		$smarty->assign('EMAIL',$order->customer['email_address']);
		$smarty->assign('FON',$order->customer['telephone']);
		//
		// Kunden-Faxnummer
		//
		$query_customer = olc_db_query("SELECT customers_fax FROM " .TABLE_CUSTOMERS.
		" WHERE customers_id =" . $order->customer['id']);
		$customer = olc_db_fetch_array($query_customer);
		$smarty->assign('FAX',$customer['customers_fax']);
		//
		// Kunden-Faxnummer
		//
		// get products data
		$order_query=olc_db_query("SELECT
        				products_id,
        				orders_products_id,
        				products_model,
        				products_name,
        				products_price,
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
			while ($attributes_data_values = olc_db_fetch_array($attributes_query)) {
				$attributes_data .=HTML_BR.$attributes_data_values['products_options'].': '.$attributes_data_values['products_options_values'];
				$attributes_model .=HTML_BR.olc_get_attributes_model($order_data_values['products_id'],$attributes_data_values['products_options_values']);
			}
			$order_data[]=array(
			'PRODUCTS_MODEL' => $order_data_values['products_model'],
			'PRODUCTS_NAME' => $order_data_values['products_name'],
			'PRODUCTS_ATTRIBUTES' => $attributes_data,
			'PRODUCTS_ATTRIBUTES_MODEL' => $attributes_model,
			'PRODUCTS_PRICE' => olc_format_price_order($order_data_values['final_price'],1,$order->info['currency']),
			'PRODUCTS_SINGLE_PRICE' =>
			olc_format_price($order_data_values['products_price'],$price_special=1,$calculate_currencies=0,$show_currencies=1),
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

		// assign language to template for caching
		$smarty->assign('oID',$oID);
		if ($order->info['payment_method']!=EMPTY_STRING && $order->info['payment_method']!='no_payment') {
			include(DIR_WS_LANGUAGES.SESSION_LANGUAGE.'/modules/payment/'.$order->info['payment_method'].PHP);
			$payment_method=constant(strtoupper('MODULE_PAYMENT_'.$order->info['payment_method'].'_TEXT_TITLE'));
		}
		$smarty->assign('PAYMENT_METHOD',$payment_method);
		$smarty->assign('DATE',olc_date_long($order->info['date_purchased']));
		$smarty->assign('order_data', $order_data);
		$smarty->assign('order_total', $order_total);
		$path = DIR_WS_CATALOG . FULL_CURRENT_TEMPLATE;
		// dont allow cache
		$smarty->caching = false;
		$smarty->display(CURRENT_TEMPLATE_MODULE . 'print_order'.HTML_EXT);
	}
} else {
	$smarty->assign('ERROR',TEXT_NO_ORDER_DISPLAY);
	$smarty->display(CURRENT_TEMPLATE_MODULE . 'error_message'.HTML_EXT);
}
?>