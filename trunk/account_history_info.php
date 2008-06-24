<?php
/* -----------------------------------------------------------------------------------------
$Id: account_history_info.php,v 1.1.1.1.2.1 2007/04/08 07:16:02 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(account_history_info.php,v 1.97 2003/05/19); www.oscommerce.com
(c) 2003	    nextcommerce (account_history_info.php,v 1.17 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include( 'includes/application_top.php');

// include needed functions
require_once(DIR_FS_INC.'olc_date_short.inc.php');
require_once(DIR_FS_INC.'olc_get_all_get_params.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');
require_once(DIR_FS_INC.'olc_display_tax_value.inc.php');
require_once(DIR_FS_INC.'olc_format_price_order.inc.php');

if (!CUSTOMER_ID)
{
	olc_redirect(olc_href_link(FILENAME_LOGIN, EMPTY_STRING, SSL));
}
else
{
	$order_id=$_GET['order_id'];
	if (!$order_id || !is_numeric($order_id))
	{
		olc_redirect(olc_href_link(FILENAME_ACCOUNT_HISTORY, EMPTY_STRING, SSL));
	}
	$customer_info_query = olc_db_query("select customers_id from " . TABLE_ORDERS ." where orders_id = '". $order_id . APOS);
	$customer_info = olc_db_fetch_array($customer_info_query);
	if ($customer_info['customers_id'] != CUSTOMER_ID)
	{
		olc_redirect(olc_href_link(FILENAME_ACCOUNT_HISTORY, EMPTY_STRING, SSL));
	}

	$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_HISTORY_INFO, olc_href_link(FILENAME_ACCOUNT, EMPTY_STRING, SSL));
	$breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_HISTORY_INFO, olc_href_link(FILENAME_ACCOUNT_HISTORY, EMPTY_STRING, SSL));
	$breadcrumb->add(sprintf(NAVBAR_TITLE_3_ACCOUNT_HISTORY_INFO, $order_id), olc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $order_id, SSL));

	require_once(DIR_WS_CLASSES . 'order.php');
	$order = new order($order_id);
	require(DIR_WS_INCLUDES . 'header.php');

	$format_id_text='format_id';
	$smarty->assign('ORDER_NUMBER',$order_id);
	$smarty->assign('ORDER_DATE',date('m.d.Y, h:i:s',$order->info['date_purchased']));
	$smarty->assign('ORDER_STATUS',$order->info['orders_status']);
	$smarty->assign('ORDER_IP',$order->customer['cIP']);
	$smarty->assign('BILLING_LABEL',olc_address_format($order->billing[$format_id_text], $order->billing, 1, BLANK, HTML_BR));
	$smarty->assign('PRODUCTS_EDIT',olc_href_link(FILENAME_SHOPPING_CART, EMPTY_STRING, SSL));
	$smarty->assign('SHIPPING_ADDRESS_EDIT',olc_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, EMPTY_STRING, SSL));
	$smarty->assign('BILLING_ADDRESS_EDIT',olc_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, EMPTY_STRING, SSL));

	$order_id_param='oID='.$order_id;
	$url0=olc_href_link(FILENAME_PRINT_ORDER,$order_id_param.HASH,NONSSL,false,false,false);
	$title_id='@';
	if (INCLUDE_PDF_INVOICE)
	{
		$url0=str_replace(strtolower(HTTPS),strtolower(HTTP),$url0);
		$smarty->assign('PDF_FORMAT',PDF_FORMAT);
	}
	$image0='<img src="'.CURRENT_TEMPLATE_BUTTONS.
	'button_print.gif" style="cursor:hand" onclick=javascript:ShowInfo("#",\'\') title="'.$title_id.'">';

	include_once(DIR_FS_INC.'olc_get_smarty_config_variable.inc.php');

	create_document_print_button('order');
	if ($order->billing['billing_invoice_number'])
	{
		create_document_print_button('invoice');
	}
	if ($order->delivery)
	{
		if ($order->delivery['delivery_packingslip_number'])
		{
			create_document_print_button('packingslip');
		}
		$smarty->assign('DELIVERY_LABEL',olc_address_format($order->delivery[$format_id_text],
		$order->delivery, 1, BLANK, HTML_BR));
		$shipping_method=$order->info['shipping_method'];
		if ($shipping_method)
		{
			$smarty->assign('SHIPPING_METHOD',$shipping_method);
		}
	}
	$data_products =
	'				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>&nbsp;</td>
						<td class="main" align="center" valign="top"><b>'.TEXT_PRICE_SINGLE.'</b></td>
						<td class="main" align="center" valign="top"><b>'.TEXT_PRICE_TOTAL.'</b></td>
					</tr>
';
	for ($i=0, $n=sizeof($order->products); $i<$n; $i++)
	{
		$order_products=$order->products[$i];
		$products_qty=$order_products['qty'];
		$price=olc_get_products_price($order_products['id'],1,$products_qty,$price_real);
		$price=abs($price_real);
		$single_price=olc_format_price($price,true,true);
		if ($products_qty>1)
		{
			$total_price=olc_format_price($price*$products_qty,true,true);
		}
		else
		{
			$total_price=$single_price;
		}
		$data_products .='
					<tr>
						<td class="main" nowrap="nowrap" align="left" valign="top" width="">' .
		$products_qty .' x '. $order_products['name'].
		'						</td>
						<td class="main" align="right" valign="top">' .$single_price.'</td>
						<td class="main" align="right" valign="top">' .$total_price.'</td>
					</tr>' . NEW_LINE ;
		$products_attributes=$order_products['attributes'];
		if (sizeof($products_attributes) > 0)
		{
			for ($j=0, $n2=sizeof($products_attributes); $j<$n2; $j++)
			{
				$products_attribute=$products_attributes[$j];
				$products_attribute_price=$products_attribute['price'];
				if ($products_attribute_price<>0)
				{
					$products_attribute_price_single=olc_get_products_attribute_price_checkout($products_attribute_price,
					$order_products['tax'],1,$products_qty,$products_attribute['prefix']);
					if ($products_qty<>1)
					{
						$products_attribute_price_total=olc_format_price($products_attribute_price*$products_qty,true,true);
					}
					else
					{
						$products_attribute_price_total=$products_attribute_price_single;
					}
				}
				else
				{
					$products_attribute_price=EMPTY_STRING;
				}
				$data_products .=
				'					<tr>
						<td class="main" align="left" valign="top">
							<nobr><small>&nbsp;<i> - ' .
				$products_attribute['option'] . ': ' .  $products_attribute['value'] .'
							</i></small>
						</td>
						<td class="main" align="right" valign="top"><i><small>'.
				$products_attribute_price_single.
				'							</i></small></nobr>
						</td>
						<td class="main" align="right" valign="top"><i><small>'.
				$products_attribute_price_single.
				'							</i></small></nobr>
						</td>
					</tr>
';
			}
		}
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 &&
		$_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
			if (sizeof($order->info['tax_groups']) > 1)
			$data_products .=
			'
         	<tr>
             <td colspan="3" class="main" valign="top" align="right">' .
			olc_display_tax_value($order_products['tax']) . '%
						</td>
         </tr>
';
		}
	}
	$payment_method=$order->info['payment_method'];
	if ($payment_method!=EMPTY_STRING)
	{
		if ($payment_method!='no_payment')
		{
			include(DIR_WS_LANGUAGES . SLASH . SESSION_LANGUAGE . '/modules/payment/' . $payment_method . PHP);
			//---PayPal WPP Modification START ---//
			if ($use_ec_checkout)
			{
				$module_payment_title=MODULE_PAYMENT_PAYPAL_EC_TEXT_TITLE;
			}
			else
			{
				$module_payment_title=constant(MODULE_PAYMENT_ . strtoupper($payment_method) . _TEXT_TITLE);
			}
			$smarty->assign('PAYMENT_METHOD',$module_payment_title);
			//---PayPal WPP Modification START ---//
		}
	}

	$total_block='<table>';
	if (MODULE_ORDER_TOTAL_INSTALLED)
	{
		$data_products.='
					<tr>
						<td colspan="2"></td>
						<td><hr/></td>
					</tr>
';
		$bold_it_text=SUB_TITLE_SUB_TOTAL.SUB_TITLE_TOTAL;
		$total_block='<table>';
		for ($i=0, $n=sizeof($order->totals); $i<$n; $i++)
		{
			$order_totals=$order->totals[$i];
			$ot_title=$order_totals['title'];
			$ot_text=$order_totals['text'];
			$bold_it=strpos($bold_it_text,$ot_title)!==false;
			if ($bold_it)
			{
				$ot_title=HTML_B_START.$ot_title.HTML_B_END;
				$ot_text=HTML_B_START.$ot_text.HTML_B_END;
			}
			$total_block.= '
          <tr>
            <td class="main" align="right" width="100%">' .$ot_title . '</td>
            <td class="main" nowrap="nowrap" align="right">' .$ot_text . '</td>
          </tr>
';
		}
		$total_block.='
				</table>
';
	}
	$data_products .=
'				</table>';
	$smarty->assign('PRODUCTS_BLOCK',$data_products);
	$smarty->assign('TOTAL_BLOCK',$total_block);

	$smarty->assign('PAYMENT_EDIT',olc_href_link(FILENAME_CHECKOUT_PAYMENT, EMPTY_STRING, SSL));
	$history_block='<table>';
	$statuses_query = olc_db_query("select os.orders_status_name, osh.date_added, osh.comments from " .
	TABLE_ORDERS_STATUS . " os, " .
	TABLE_ORDERS_STATUS_HISTORY . " osh
	where
	osh.orders_id = '" . $order_id . "'
	and osh.orders_status_id = os.orders_status_id
	and os.language_id = '" . SESSION_LANGUAGE_ID . "'
	order by osh.date_added");
	while ($statuses = olc_db_fetch_array($statuses_query)) {
		$history_block.= '              <tr>' . NEW_LINE .
		'                <td class="main" valign="top">' . olc_date_short($statuses['date_added']) . '</td>' . NEW_LINE .
		'                <td class="main" valign="top">' . $statuses['orders_status_name'] . '</td>' . NEW_LINE .
		'                <td class="main" valign="top">' . (empty($statuses['comments']) ? HTML_NBSP :
											nl2br(htmlspecialchars($statuses['comments']))) . '</td>' . NEW_LINE .
		'              </tr>' . NEW_LINE;
	}
	$history_block.='</table>';
	$smarty->assign('HISTORY_BLOCK',$history_block);

	if (DOWNLOAD_ENABLED == TRUE_STRING_S) include(DIR_WS_MODULES . 'downloads.php');
	$button_back=HTML_A_START . olc_href_link(FILENAME_ACCOUNT_HISTORY, olc_get_all_get_params(array('order_id')), SSL) . '">' .
	olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END;
	/* begin PayPal_Shopping_Cart_IPN */
	if (defined('PAYPAL_IPN_DIR'))
	{
		require(PAYPAL_IPN_DIR.'catalog/order_send_money.inc.php');
	}
	$button_back.=$paypal_confirm;
	/* end PayPal_Shopping_Cart_IPN */
	$track_code=$order->info['orders_trackcode'];
	if ($track_code)
	{
		require_once(DIR_FS_INC.'olc_get_track_code.inc.php');
		$TrackURL=olc_get_track_code($order,$track_code);
		if ($TrackURL)
		{
			$order_tracking='
<!--W. Kaiser - Erlaube Sendungstracking -->
<b>'. ENTRY_TRACKCODE.': '. $track_code.'</b>&nbsp;'.ENTRY_TRACKCODE_EXPLAIN.HTML_NBSP.'
<a href="'.$TrackURL.'" target="_blank">'.ENTRY_TRACK_URL_TEXT.'</a>
<!--W. Kaiser - Erlaube Sendungstracking -->
';
			$smarty->assign('ORDER_TRACKING',$order_tracking);
		}
	}
	$smarty->assign('BUTTON_BACK',$button_back);

	$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'account_history_info'.HTML_EXT,SMARTY_CACHE_ID);
	$smarty->assign(MAIN_CONTENT,$main_content);
	require(BOXES);
	$smarty->display(INDEX_HTML);
}

function create_document_print_button($doc_type)
{
	global $smarty,$url0,$image0;

	$parameter='&print_'.$doc_type.'=true';
	$url= str_replace(HASH,$parameter,$url0);
	$image=str_replace(HASH,$url,$image0);
	$title=olc_get_smarty_config_variable($smarty,'account_history_info','title_print_'.$doc_type);
	if (INCLUDE_PDF_INVOICE)
	{
		$title.=PDF_FORMAT;
	}
	$image=str_replace('@',$title,$image);
	$smarty->assign('BUTTON_PRINT_'.strtoupper($doc_type),$image);
}
?>