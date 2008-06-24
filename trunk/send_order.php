<?php
/* -----------------------------------------------------------------------------------------
$Id: send_order.php,v 1.1.1.1.2.1 2007/04/08 07:16:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX

http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (send_order.php,v 1.1 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

require_once(DIR_FS_INC.'olc_get_products_price.inc.php');
require_once(DIR_FS_INC.'olc_get_order_data.inc.php');
require_once(DIR_FS_INC.'olc_get_attributes_model.inc.php');
require_once(DIR_FS_INC.'olc_php_mail.inc.php');
// check if customer is allowed to send this order!
$order_query_check = olc_db_query("
SELECT
customers_id
FROM ".TABLE_ORDERS."
WHERE orders_id=".$insert_id);
$order_check = olc_db_fetch_array($order_query_check);
if (CUSTOMER_ID == $order_check['customers_id'] || !$real_checkout)
{
	$order = new order($insert_id);
	$smarty->assign('address_label_customer',
		olc_address_format($order->customer['format_id'], $order->customer, 1, EMPTY_STRING, HTML_BR));
	$smarty->assign('address_label_shipping',
		olc_address_format($order->delivery['format_id'], $order->delivery, 1, EMPTY_STRING, HTML_BR));
	if ($_SESSION['credit_covers']!='1')
	{
		$smarty->assign('address_label_payment',
			olc_address_format($order->billing['format_id'], $order->billing, 1, EMPTY_STRING, HTML_BR));
	}
	$smarty->assign('csID',$order->customer['csID']);
	// get products data
	//
	// W. Kaiser Einzelpreis
	//
	$order_query=olc_db_query(SELECT."
        				products_id,
        				orders_products_id,
        				products_model,
        				products_name,
        				products_price,
        				final_price,
        				products_quantity
        				FROM ".TABLE_ORDERS_PRODUCTS."
        				WHERE orders_id='".$insert_id.APOS);
	//
	// W. Kaiser Einzelpreis
	//
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
			$products_options_values=$attributes_data_values['products_options_values'];
			$attributes_data .=HTML_B_START.$attributes_data_values['products_options'].HTML_B_END.': '.
				$products_options_values.HTML_BR;
			$attributes_model .=olc_get_attributes_model($order_data_values['products_id'],
				$products_options_values).HTML_BR;
		}
		//
		// W. Kaiser Einzelpreis
		//
		$order_data[]=array(
		'PRODUCTS_MODEL' => $order_data_values['products_model'],
		'PRODUCTS_NAME' => $order_data_values['products_name'],
		'PRODUCTS_ATTRIBUTES' => $attributes_data,
		'PRODUCTS_ATTRIBUTES_MODEL' => $attributes_model,
		'PRODUCTS_PRICE' =>
		olc_format_price($order_data_values['final_price'],$price_special=1,
			$calculate_currencies=0,$show_currencies=1),
		'PRODUCTS_SINGLE_PRICE' =>
		olc_format_price($order_data_values['products_price'],$price_special=1,
			$calculate_currencies=0,$show_currencies=1),
		'PRODUCTS_QTY' => $order_data_values['products_quantity']);
	}
	//
	// W. Kaiser Einzelpreis
	//
	// get order_total data
	$oder_total_query=olc_db_query("
	SELECT
	title,
	text,
	sort_order
	FROM ".
	TABLE_ORDERS_TOTAL."
	WHERE
	orders_id=".$insert_id."
	ORDER BY sort_order ASC");
	$order_total=array();
	while ($oder_total_values = olc_db_fetch_array($oder_total_query))
	{
		$order_total[]=array(
		'TITLE' => $oder_total_values['title'],
		'TEXT' => $oder_total_values['text']);
	}
	// assign language to template for caching
	$smarty->assign('oID',$insert_id);
	$payment_method=$order->info['payment_method'];
	if ($payment_method)
	{
		if ($payment_method!='no_payment')
		{
			include(DIR_WS_LANGUAGES.SESSION_LANGUAGE.'/modules/payment/'.$payment_method.PHP);
			$payment_method_text=constant('MODULE_PAYMENT_'.strtoupper($payment_method).'_TEXT_TITLE');
		}
	}
	$smarty->assign('PAYMENT_METHOD',$payment_method_text);
	$smarty->assign('DATE',olc_date_long($order->info['date_purchased']));
	$smarty->assign('order_data', $order_data);
	$smarty->assign('order_total', $order_total);
	$smarty->assign('NAME',$order->customer['name']);
	$smarty->assign('COMMENTS',$order->info['comments']);
	$smarty->assign('EMAIL',$order->customer['email_address']);
	$smarty->assign('FON',$order->customer['telephone']);
	$query_customer = olc_db_query("SELECT customers_fax FROM " .TABLE_CUSTOMERS.
	" WHERE customers_id =" . $order->customer['id']);
	$customer = olc_db_fetch_array($query_customer);
	$smarty->assign('FAX',$customer['customers_fax']);
	$konto=$order->info['cc_number'];
	if ($konto)
	{
		//$konto=str_pad(substr($konto,-4),strlen($konto),'x',STR_PAD_LEFT);
		$smarty->assign('CC_NUMBER',$konto);
		$smarty->assign('CC_OWNER',$order->info['cc_owner']);
		$konto=$order->info['cc_cvv'];
		$smarty->assign('CC_CVN',$konto);
		$smarty->assign('CC_TYPE',$order->info['cc_type']);
		$smarty->assign('CC_EXPIRE',$order->info['cc_expires']);
	}
	$show_bank=$payment_method=='banktransfer';
	if ($show_bank)
	{
		$query_bank = olc_db_query("
			SELECT banktransfer_owner, banktransfer_number, banktransfer_bankname, banktransfer_blz FROM ".
			TABLE_BANKTRANSFER."
			WHERE orders_id=".$insert_id);
		$bank = olc_db_fetch_array($query_bank);
		$smarty->assign('INHABER',$bank['banktransfer_owner']);
		$smarty->assign('BANK',$bank['banktransfer_bankname']);
		$smarty->assign('BLZ',$bank['banktransfer_blz']);
		$konto=$bank['banktransfer_number'];
		//$konto=str_pad(substr($konto,-4),strlen($konto),'x',STR_PAD_LEFT);
		$smarty->assign('KONTO',$konto);
	}
	olc_get_ip_info($smarty);
	if (NO_TAX_RAISED)
	{
		$tax_information=BOX_LOGINBOX_NO_TAX_TEXT;
	}
	else
	{
		if (CUSTOMER_SHOW_PRICE)
		{
			$tax_information=PRICES_DISCLAIMER_INCL;
		}
		else
		{
			$tax_information=PRICES_DISCLAIMER_EXCL;
		}
	}
	$smarty->assign('TAX_INFORMATION',$tax_information);
	$customer_email_type=$order->customer['email_type'];
	if (CUSTOMER_COUNTRY_ID==81)									//German customer?
	{
		//Send "Widerrufsbelehrung" to this customer type?
		if (strpos(CUSTOMER_STATUS_NO_FERNAG_INFO_IDS,CUSTOMER_STATUS_ID)===false)
		{
			//Get Widerrufsbelehrung info from Database
			$shop_content_query=olc_db_query("
			SELECT
			content_text,
			content_file
			FROM ".
			TABLE_CONTENT_MANAGER."
			WHERE
			content_group='4' AND
			languages_id=".SESSION_LANGUAGE_ID);
			$shop_content_data=olc_db_fetch_array($shop_content_query);
			$content_file=$shop_content_data['content_file'];
			if ($content_file)
			{
				$fernag_info=file_get_contents();
				$is_text_file=strpos($content_file,'.txt')!==false;
			} else {
				$fernag_info= $shop_content_data['content_text'];
				$is_text_file=false;
			}
			$use_html_email=$customer_email_type==EMAIL_TYPE_HTML;
			if ($is_text_file)
			{
				if ($use_html_email)
				{
					$fernag_info = '<pre>'.$fernag_info.'</pre>';
				}
			}
			else
			{
				if ($use_html_email)
				{
					if (SESSION_LANGUAGE == 'german')
					{
						require_once(DIR_FS_INC.'olc_silbentrennung.inc.php');
						$fernag_info=olc_silbentrennung($fernag_info);
					}
				}
				else
				{
					$fernag_info=str_replace(HTML_NBSP,BLANK,$fernag_info);
					$fernag_info=nl2br($fernag_info);
					$fernag_info=strip_tags($fernag_info);
					$fernag_info=html_entity_decode($fernag_info);
				}
			}
			$smarty->assign('FERNAG_INFO',$fernag_info);
		}
	}
	$attachment_agb="lang".SLASH.SESSION_LANGUAGE.SLASH."agb.pdf";
	$agb_info=true;
	if (file_exists($attachment_agb))
	{
		$attachment_agb=basename($attachment_agb);
		if (file_exists($attachment_agb))
		{
			$smarty->assign('AGB_INFO',true);
		}
		else
		{
			$attachment_agb=EMPTY_STRING;
			$agb_info=false;
		}
	}
	$smarty->assign('AGB_INFO',$agb_info);
	$delete_pdf_invoice=false;
	if (INCLUDE_PDF_INVOICE)
	{
		$_GET['print_order']=true;
		include(FILENAME_ORDERS_INVOICE_PDF);
		if (file_exists($pdf_invoice))
		{
			$attachment_invoice=$pdf_invoice;
			$smarty->assign('INVOICE_ATTACHED',basename($pdf_invoice));
			$delete_pdf_invoice=true;
		}
	}
	// dont allow cache
	$smarty->caching = false;
	$template=CURRENT_TEMPLATE_MAIL.'order_mail';
	if ($customer_email_type==EMAIL_TYPE_TEXT)
	{
		$txt_mail=$smarty->fetch($template.'txt');
		$html_mail=EMPTY_STRING;
	}
	else
	{
		$html_mail=$smarty->fetch($template.HTML_EXT);
		$txt_mail=EMPTY_STRING;
	}
	$firstname=$order->customer['firstname'];
	$lastname=$order->customer['lastname'];
	// create subject
	$order_subject=str_replace('{$nr}',$insert_id,EMAIL_BILLING_SUBJECT_ORDER);
	$order_subject=str_replace('{$date}',strftime(DATE_FORMAT_LONG),$order_subject);
	$order_subject=str_replace('{$firstname}',$firstname,$order_subject);
	$order_subject=str_replace('{$lastname}',$lastname,$order_subject);
	// W. Kaiser - eMail-type by customer
	$eMail=$order->customer['email_address'];
	$name=trim($firstname.BLANK.$lastname);
	// send mail to admin
	olc_php_mail(
	$eMail,
	$name,
	EMAIL_BILLING_FORWARDING_STRING ,
	STORE_NAME,
	EMPTY_STRING,
	EMPTY_STRING,
	EMPTY_STRING,
	$attachment_invoice,
	$attachment_agb,
	$order_subject,
	$html_mail ,
	$txt_mail,
	EMAIL_TYPE_HTML);

	// send mail to customer
	olc_php_mail(
	EMAIL_BILLING_ADDRESS,
	EMAIL_BILLING_NAME,
	$eMail,
	$name,
	EMPTY_STRING,
	EMAIL_BILLING_REPLY_ADDRESS,
	EMAIL_BILLING_REPLY_ADDRESS_NAME,
	$attachment_invoice,
	$attachment_agb,
	$order_subject,
	$html_mail ,
	$txt_mail,
	$customer_email_type);

	if ($delete_pdf_invoice)
	{
		unlink($pdf_invoice);
	}
	//	W. Kaiser - eMail-type by customer
} else {
	$smarty->assign('ERROR',TEXT_NO_ORDER_DISPLAY);
	$smarty->display(CURRENT_TEMPLATE_MODULE . 'error_message'.HTML_EXT);
}
?>