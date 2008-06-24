<?php
/* -----------------------------------------------------------------------------------------
$Id: checkout_process.php,v 1.1.1.1.2.1 2007/04/08 07:16:10 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(checkout_process.php,v 1.128 2003/05/28); www.oscommerce.com
(c) 2003	    nextcommerce (checkout_process.php,v 1.30 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
----------------------------------------------------------------------------------------
Third Party contribution:

Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c106  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//We are using this also from paypal_ipn (checkout_process.inc.php), which will set "$real_checkout=false"
if (!isset($real_checkout))
{
	$real_checkout=true;
}
if ($real_checkout)
{
	include('includes/application_top.php');
	// include needed functions

	include(DIR_FS_INC.'olc_t_and_c_accepted.inc.php');

	require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES.'class.phpmailer.php');

	$customers_id=CUSTOMER_ID;
	$restart_payment=false;
	$pay_pal_error=false;
	// if the customer is not logged on, redirect them to the login page
	if ($customers_id==0)
	{
		$_SESSION['navigation']->set_snapshot(array('mode' => SSL, 'page' => FILENAME_CHECKOUT_PAYMENT));
		olc_redirect(olc_href_link(FILENAME_LOGIN, EMPTY_STRING, SSL));
	}
	elseif (!CUSTOMER_SHOW_PRICE)
	{
		olc_redirect(olc_href_link(FILENAME_DEFAULT, EMPTY_STRING, EMPTY_STRING));
	}
	elseif (!isset($_SESSION['sendto']))
	{
		$restart_payment=true;
	}
	elseif ((olc_not_null(MODULE_PAYMENT_INSTALLED)) && (!isset($_SESSION['payment'])) ) {
		$restart_payment=true;
	}
	// avoid hack attempts during PayPal-payments by checking the referrer!
	else
	{
		$paypal_payment_text='paypal_payment';
		if (isset($_SESSION[$paypal_payment_text]))
		{
			unset($_SESSION[$paypal_payment_text]);
			$referrer=strtolower($_SERVER['HTTP_REFERER']);
			$restart_payment=strpos($referrer,'www.paypal')===false;
			if ($restart_payment)
			{
				$restart_payment=strpos($referrer,'www.sandbox.paypal')===false;
				$pay_pal_error=true;
			}
		}
	}
	if ($restart_payment)
	{
		if ($pay_pal_error)
		{
			// include the mailer-class
			require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'class.phpmailer.php');
			// include all for the mails
			require_once(DIR_FS_INC.'olc_php_mail.inc.php');
			$txt_mail="Referrer='".$referrer.APOS;
			olc_php_mail(
			$_SESSION['email_address'],
			$_SESSION['custumers_firstname'],
			EMAIL_BILLING_FORWARDING_STRING ,
			STORE_NAME,
			EMPTY_STRING,
			$_SESSION['email_address'],
			$_SESSION['customers_firstname'],
			EMPTY_STRING,
			EMPTY_STRING,
			'Fehler bei PayPal-Zahlung',
			$txt_mail,
			$txt_mail,
			EMAIL_TYPE_TEXT);
			olc_redirect(olc_href_link("paypal_problem.php", EMTPY_STRING, NONSSL));
		}
		else
		{
			olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT, EMPTY_STRING, SSL));
		}
	}
	else
	{
		// avoid hack attempts during the checkout procedure by checking the internal cartID
		$session_cartID=$_SESSION['cartID'];
		if ($session_cartID)
		{
			$session_cart_cartID=$_SESSION['cart']->cartID;
			if ($session_cart_cartID)
			{
				if ($session_cartID != $session_cart_cartID)
				{
					olc_redirect(olc_href_link(FILENAME_CHECKOUT_SHIPPING, EMPTY_STRING, SSL));
				}
			}
		}
	}
}
require_once(DIR_FS_INC.'olc_calculate_tax.inc.php');
require_once(DIR_FS_INC.'olc_address_label.inc.php');
require_once(ADMIN_PATH_PREFIX.DIR_FS_INC.'changedatain.inc.php');

// load the selected shipping module
require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES.'shipping.php');
$shipping_modules = new shipping($_SESSION['shipping']);
require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES.'order.php');
$order = new order;
if ($real_checkout)
{
	// load selected payment module
	require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'payment.php');
	if (isset($_SESSION['credit_covers'])) $_SESSION['payment']=EMPTY_STRING; //ICW added for CREDIT CLASS
	$payment_modules = new payment($_SESSION['payment']);
	// load the before_process function from the payment modules
	$payment_modules->before_process();
}
$order_total_text='order_total';
if (!class_exists($order_total_text))
{
	require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . $order_total_text.PHP);
}
if (!is_object($order_total_modules) ) $order_total_modules = new order_total;
if (!is_array($order_totals)) $order_totals = $order_total_modules->process();

// BMC CC Mod Start
if (strtolower(CC_ENC) == TRUE_STRING_S )
{
	$key = changeme;
	$plain_data = $order->info['cc_number'];
	$order->info['cc_number'] = changedatain($plain_data,$key);
}
// BMC CC Mod End
if (CUSTOMER_SHOW_OT_DISCOUNT)
{
	$discount=CUSTOMER_DISCOUNT;
}
else
{
	$discount='0.00';
}
$ip=$_SESSION['CUSTOMERS_IP'];
if (!$ip)
{
	$ip=$_SERVER['REMOTE_ADDR'];
}
$customer_email_address=$order->customer['email_address'];
//	W. Kaiser - eMail-type by customer
$sql_data_array = array(
'customers_id' => $customers_id,
'customers_name' => trim($order->customer['firstname'] . BLANK . $order->customer['lastname']),
'customers_cid' => $order->customer['csID'],
'customers_company' => $order->customer['company'],
'customers_status' => $order->customer['status'],
'customers_status_name' => $_SESSION['customers_status']['customers_status_name'],
'customers_status_image' => $order->customer['status_image'],
'customers_status_discount' => $discount,
'customers_status' => $customer_status_value['customers_status'],
'customers_street_address' => $order->customer['street_address'],
'customers_suburb' => $order->customer['suburb'],
'customers_city' => $order->customer['city'],
'customers_postcode' => $order->customer['postcode'],
'customers_state' => $order->customer['state'],
'customers_country' => $order->customer['country']['title'],
'customers_telephone' => $order->customer['telephone'],
'customers_email_address' => $customer_email_address,
//	W. Kaiser - eMail-type by customer
'customers_email_type' => $order->customer['email_type'],
//	W. Kaiser - eMail-type by customer
'customers_address_format_id' => $order->customer['format_id'],
'delivery_name' => trim($order->delivery['firstname'] . BLANK . $order->delivery['lastname']),
'delivery_firstname' => $order->delivery['firstname'], //JAN
'delivery_lastname' => $order->delivery['lastname'], //JAN
'delivery_company' => $order->delivery['company'],
'delivery_street_address' => $order->delivery['street_address'],
'delivery_suburb' => $order->delivery['suburb'],
'delivery_city' => $order->delivery['city'],
'delivery_postcode' => $order->delivery['postcode'],
'delivery_state' => $order->delivery['state'],
'delivery_country' => $order->delivery['country']['title'],
'delivery_country_iso_code_2' => $order->delivery['country']['iso_code_2'], //JAN
'delivery_address_format_id' => $order->delivery['format_id'],
'payment_method' => $order->info['payment_method'],
'payment_class' => $order->info['payment_class'],
'shipping_method' => $order->info['shipping_method'],
'shipping_class' => $order->info['shipping_class'],
'cc_type' => $order->info['cc_type'],
'cc_owner' => $order->info['cc_owner'],
'cc_number' => $order->info['cc_number'],
'cc_expires' => $order->info['cc_expires'],
// BMC CC Mod Start
'cc_start' => $order->info['cc_start'],
'cc_cvv' => $order->info['cc_cvv'],
'cc_issue' => $order->info['cc_issue'],
// BMC CC Mod End
'date_purchased' => 'now()',
'orders_status' => $order->info['order_status'],
'currency' => $order->info['currency'],
'currency_value' => $order->info['currency_value'],
'customers_ip' =>  $ip,
'language'=>$_SESSION['language_name'],
'customers_order_reference' => $order->info['customers_order_reference'],
'orders_discount' => $order->info['orders_discount'],
'comments' => $order->info['comments']);
if ($_SESSION['credit_covers'] != '1')
{
	$sql_data_array = array_merge($sql_data_array ,
	array(
	'billing_name' => trim($order->billing['firstname'] . BLANK . $order->billing['lastname']),
	'billing_firstname' => $order->billing['firstname'],  //JAN
	'billing_lastname' => $order->billing['lastname'],   //JAN
	'billing_company' => $order->billing['company'],
	'billing_street_address' => $order->billing['street_address'],
	'billing_suburb' => $order->billing['suburb'],
	'billing_city' => $order->billing['city'],
	'billing_postcode' => $order->billing['postcode'],
	'billing_state' => $order->billing['state'],
	'billing_country' => $order->billing['country']['title'],
	'billing_country_iso_code_2' => $order->billing['country']['iso_code_2'], //JAN
	'billing_address_format_id' => $order->billing['format_id']));
}
//	W. Kaiser - eMail-type by customer
$paypal_session_exists = false;
if(isset($_SESSION['PayPal_osC']))
{
	$orders_session_query = olc_db_query("select osi.orders_id, o.payment_id from " . TABLE_ORDERS_SESSION_INFO .
	" osi left join " . TABLE_ORDERS . " o on osi.orders_id = o.orders_id where osi.txn_signature ='" .
	olc_db_input($PayPal_osC->txn_signature) . APOS);
	$orders_check = olc_db_fetch_array($orders_session_query);
	//Now check to see whether order session info exists AND that this order
	//does not currently have an IPN.
	$orders_id=(int)$orders_check['orders_id'];
	if ($orders_id > 0 )
	{
		if ($orders_check['payment_id'] == '0')
		{
			$paypal_session_exists = true;
		}
	}
}
if($paypal_session_exists)
{
	$orders_id_param="orders_id = '" . $orders_id. APOS;
	$where_orders_id=" where ".$orders_id_param;
	olc_db_perform(TABLE_ORDERS, $sql_data_array, 'update', $orders_id_param);
	olc_db_query(DELETE_FROM . TABLE_ORDERS_TOTAL . $where_orders_id);
} else {
	$sql_data_array['date_purchased'] = 'now()';
	olc_db_perform(TABLE_ORDERS, $sql_data_array);
	$orders_id=olc_db_insert_id();
}
$insert_id=$orders_id;
for ($i=0, $n=sizeof($order_totals); $i<$n; $i++)
 {
	$order_total=$order_totals[$i];
	$sql_data_array = array(
	'orders_id' => $insert_id,
	'title' => $order_total['title'],
	'text' => $order_total['text'],
	'value' => $order_total['value'],
	'class' => $order_total['code'],
	'sort_order' => $order_total['sort_order']);
	olc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
}

if ($real_checkout)
{
	$orders_status_id=$order->info['order_status'];
	$customer_notification = (SEND_EMAILS == TRUE_STRING_S) ? '1' : '0';
}
else
{
	$orders_status_id=MODULE_PAYMENT_PAYPAL_IPN_PROCESSING_STATUS_ID;
	$customer_notification = '0';
}

$sql_data_array = array(
'orders_status_id' => $orders_status_id,
'date_added' => 'now()',
'customer_notified' => $customer_notification,
'comments' => $order->info['comments']);
if($paypal_session_exists)
{
	olc_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array, UPDATE, $orders_id_param);
	olc_db_query(DELETE_FROM . TABLE_ORDERS_PRODUCTS . $where_orders_id);
	olc_db_query(DELETE_FROM . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . $where_orders_id);
} else {
	$sql_data_array['orders_id'] = $orders_id;
	olc_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
}

// initialized for the email confirmation
$products_ordered = EMPTY_STRING;
$products_ordered_html = EMPTY_STRING;
$subtotal = 0;
$total_tax = 0;
$download_enabled=DOWNLOAD_ENABLED == TRUE_STRING_S;
$stock_limited=STOCK_LIMITED == TRUE_STRING_S;
for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
	// Stock Update - Joao Correia
	$current_product=$order->products[$i];
	$current_product_id=olc_get_prid($current_product['id']);
	$current_product_qty=$current_product['qty'];
	$current_product_id_where=" where products_id = '" . $current_product_id . APOS;
	$update_table_products=SQL_UPDATE . TABLE_PRODUCTS." set ";
	if ($stock_limited)
	{
		if ($download_enabled)
		{
			$stock_query_raw = SELECT."
				products_quantity, pad.products_attributes_filename
				FROM " . TABLE_PRODUCTS . " p
				LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES . " pa
				ON p.products_id=pa.products_id
				LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
				ON pa.products_attributes_id=pad.products_attributes_id
				WHERE p.products_id = '" . $current_product_id . APOS;
			// Will work with only one option for downloadable products
			// otherwise, we have to build the query dynamically with a loop
			$products_attributes = $current_product['attributes'];
			if (is_array($products_attributes))
			{
				for ($i=0;$i<sizeof($products_attributes);$i++)
				{
					$current_products_attribute=$products_attributes[$i];
					$stock_query_raw .= " AND pa.options_id = '" . $current_products_attribute['option_id'] .
					"' AND pa.options_values_id = '" . $current_products_attribute['value_id'] . APOS;
				}
			}
		}
		else
		{
			$stock_query_raw=SELECT."products_quantity from " . TABLE_PRODUCTS .	$current_product_id_where;
		}
		$stock_query = olc_db_query($stock_query_raw);
		if (olc_db_num_rows($stock_query) > 0) {
			$stock_values = olc_db_fetch_array($stock_query);
			// do not decrement quantities if products_attributes_filename exists
			$stock_left = $stock_values['products_quantity'];
			if ((DOWNLOAD_ENABLED != TRUE_STRING_S) || (!$stock_values['products_attributes_filename']))
			{
				$stock_left -= $current_product_qty;
			}
			olc_db_query($update_table_products."products_quantity = '" . $stock_left . APOS.$current_product_id_where);
			if ($stock_left < 1)
			{
				if (STOCK_ALLOW_CHECKOUT == FALSE_STRING_S)
				{
					olc_db_query($update_table_products."products_status = '0'".$current_product_id_where);
				}
			}
		}
	}
	$auctionid=$current_product['auctionid'];
	if ($auctionid)
	{
		$sqlstring = SQL_UPDATE.TABLE_AUCTION_DETAILS." SET order_number = '".$insert_id."'
		WHERE auction_id = '".$auctionid."'	AND buyer_email = '".$customer_email_address.APOS;
		olc_db_query($sqlstring);
		//set special if product is an auction
		$auctionid = " (EBAY-id: ".$auctionid.RPAREN;
	}
	// Update products_ordered (for bestsellers list)
	olc_db_query($update_table_products."products_ordered = products_ordered + " . $current_product_qty .
	$current_product_id_where);
	$sql_data_array = array(
	'orders_id' => $orders_id,
	'products_id' => $current_product_id,
	'products_model' => $current_product['model'],
	'products_name' => $current_product['name'].$auctionid,
	'products_price' => $current_product['price'],
	'final_price' => $current_product['final_price'],
	'products_tax' => $current_product['tax'],
	'products_discount_made' => $current_product_id['discount_allowed'],
	'products_quantity' => $current_product_qty,
	'allow_tax' => CUSTOMER_SHOW_PRICE_TAX);

	olc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);
	$order_products_id = olc_db_insert_id();

	//$order_total_modules->update_credit_account($i);// GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
	if(is_callable(array($order_total_modules, 'update_credit_account'))) {
		global $orders_id;
		$order_total_modules->update_credit_account($i);//ICW ADDED FOR CREDIT CLASS SYSTEM
	}

	//------insert customer choosen option to order--------
	$attributes_exist = '0';
	$products_ordered_attributes = EMPTY_STRING;
	$current_product_attributes=$current_product['attributes'];
	if ($current_product_attributes)
	{
		$attributes_exist = '1';
		for ($j=0, $n2=sizeof($current_product_attributes); $j<$n2; $j++)
		{
			$current_product_attribute=$current_product_attributes[$j];
			$current_product_attribute_option_id=$current_product_attribute['option_id'];
			$current_product_attribute_value_id=$current_product_attribute['value_id'];
			if ($download_enabled)
			{
				$attributes_query = "select
				popt.products_options_name,
				poval.products_options_values_name,
				pa.options_values_price,
				pa.price_prefix,
				pad.products_attributes_maxdays,
				pad.products_attributes_maxcount,
				pad.products_attributes_filename
				from " .
				TABLE_PRODUCTS_OPTIONS . " popt, " .
				TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " .
				TABLE_PRODUCTS_ATTRIBUTES . " pa
				left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
				on pa.products_attributes_id=pad.products_attributes_id
				where
				pa.products_id = '" . $current_product_id . "'
				and pa.options_id = '" . $current_product_attribute_option_id . "'
				and pa.options_id = popt.products_options_id
				and pa.options_values_id = '" . $current_product_attribute_value_id . "'
				and pa.options_values_id = poval.products_options_values_id
				and popt.language_id = '" . SESSION_LANGUAGE_ID . "'
				and poval.language_id = '" . SESSION_LANGUAGE_ID . APOS;
				$attributes = olc_db_query($attributes_query);
			} else {
				$attributes = olc_db_query("
				select popt.products_options_name,
				poval.products_options_values_name,
				pa.options_values_price,
				pa.price_prefix
				from " .
				TABLE_PRODUCTS_OPTIONS . " popt, " .
				TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " .
				TABLE_PRODUCTS_ATTRIBUTES . " pa
				where pa.products_id = '" . $current_product_id . "'
				and pa.options_id = '" . $current_product_attribute_option_id . "'
				and pa.options_id = popt.products_options_id
				and pa.options_values_id = '" . $current_product_attribute_value_id . "'
				and pa.options_values_id = poval.products_options_values_id
				and popt.language_id = '" . SESSION_LANGUAGE_ID . "'
				and poval.language_id = '" . SESSION_LANGUAGE_ID . APOS);
			}
			// update attribute stock
			olc_db_query(
			SQL_UPDATE.TABLE_PRODUCTS_ATTRIBUTES." set
       attributes_stock=attributes_stock - '".$current_product_qty."'
       where
       products_id='".$current_product_id."'
       and options_values_id='".$current_product_attribute_value_id."'
       and options_id='".$current_product_attribute_option_id."'
       ");
			$attributes_values = olc_db_fetch_array($attributes);
			$sql_data_array = array(
			'orders_id' => $orders_id,
			'orders_products_id' => $order_products_id,
			'products_options' => $attributes_values['products_options_name'],
			'products_options_values' => $attributes_values['products_options_values_name'],
			'options_values_price' => $attributes_values['options_values_price'],
			'price_prefix' => $attributes_values['price_prefix']);
			olc_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);
			if ($download_enabled)
	 	  {
				$products_attributes_filename=$attributes_values['products_attributes_filename'];
				if ($products_attributes_filename)
				{
					$sql_data_array = array(
					'orders_id' => $orders_id,
					'orders_products_id' => $order_products_id,
					'orders_products_filename' => $products_attributes_filename,
					'download_maxdays' => $attributes_values['products_attributes_maxdays'],
					'download_count' => $attributes_values['products_attributes_maxcount']);
					olc_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
				}
			}
		}
	}
	//------insert customer choosen option eof ----
	$total_weight += ($current_product_qty * $current_product['weight']);
	$total_tax += olc_calculate_tax($total_products_price, $products_tax) * $current_product_qty;
	$total_cost += $total_products_price;
}
// load the after_process function from the payment modules
$payment_modules->after_process();

// NEW EMAIL configuration !
$order_totals = $order_total_modules->apply_credit();

if ($real_checkout || $is_auction)
{
	include('send_order.php');
}
else
{
	$sendto=$_SESSION['sendto'];
	$billto=$_SESSION['billto'];
	$shipping=$_SESSION['shipping'];
	$payment=$_SESSION['payment'];
}
if (SHOW_AFFILIATE)
{
	// inclusion for affiliate program
	require(ADMIN_PATH_PREFIX.DIR_WS_INCLUDES . 'affiliate_checkout_process.php');
}
$_SESSION['cart']->reset(true);
// unregister session variables used during checkout
unset($_SESSION['sendto']);
unset($_SESSION['billto']);
unset($_SESSION['shipping']);
unset($_SESSION['payment']);
unset($_SESSION['customers_order_reference']);
unset($_SESSION['comments']);
unset($_SESSION['last_order']);

$last_order = $orders_id;
//GV Code Start
unset($_SESSION['credit_covers']);
$order_total_modules->clear_posts();//ICW ADDED FOR CREDIT CLASS SYSTEM
// GV Code End

if ($real_checkout)
{
	if (isset($mail_error))
	{
		global $message;

		$message=$messageStack->output('*');
		if (IS_AJAX_PROCESSING)
		{
			require_once(ADMIN_PATH_PREFIX.DIR_FS_INC.'ajax_error.inc.php');
			ajax_error($message);
		}
		else
		{
			echo nl2br($message);
		}
	}
	else
	{
		olc_redirect(olc_href_link(FILENAME_CHECKOUT_SUCCESS, EMPTY_STRING, SSL));
	}
	require(ADMIN_PATH_PREFIX.DIR_WS_INCLUDES.'application_bottom.php');
}
?>