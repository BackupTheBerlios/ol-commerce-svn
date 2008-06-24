<?php
/* -----------------------------------------------------------------------------------------
$Id: order.php,v 1.1.1.1.2.1 2007/04/08 07:17:47 gswkaiser Exp $

OL-Commerce 2.0
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(order.php,v 1.32 2003/02/26); www.oscommerce.com
(c) 2003	    nextcommerce (order.php,v 1.28 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

credit card encryption functions for the catalog module
BMC 2003 for the CC CVV Module

(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

if (NOT_IS_ADMIN_FUNCTION)
{
	// include needed functions
	require_once(DIR_FS_INC.'olc_get_products_price.inc.php');
	require_once(DIR_FS_INC.'olc_date_long.inc.php');
	require_once(DIR_FS_INC.'olc_address_format.inc.php');
	require_once(DIR_FS_INC.'olc_get_country_name.inc.php');
	require_once(DIR_FS_INC.'olc_get_countries.inc.php');
	require_once(DIR_FS_INC.'olc_get_zone_code.inc.php');
	require_once(DIR_FS_INC.'olc_get_tax_description.inc.php');
	require_once(DIR_FS_INC.'olc_get_single_products_price.inc.php');
	require_once(DIR_FS_INC.'olc_get_products_attribute_price_checkout.inc.php');
}

class order {
	var $info, $totals, $products, $customer, $delivery, $content_type;

	function order($order_id = EMPTY_STRING)
	{
		$this->info = array();
		$this->totals = array();
		$this->products = array();
		$this->customer = array();
		$this->delivery = array();

		if (olc_not_null($order_id))
		{
			$this->query($order_id);
		} else {
			$this->cart();
		}
	}

	function query($order_id)
	{
		$order_id = olc_db_prepare_input($order_id);

		$order_query = olc_db_query(
		SELECT_ALL . TABLE_ORDERS . " where
		orders_id = '" . olc_db_input($order_id) . APOS);
		$order = olc_db_fetch_array($order_query);
		$totals_query = olc_db_query("
		select
		title,
		text,
		value
		from " .
		TABLE_ORDERS_TOTAL .
		" where orders_id = '" . olc_db_input($order_id) . "' order by sort_order");
		while ($totals = olc_db_fetch_array($totals_query))
		{
			$this->totals[] = array(
			'title' => $totals['title'],
			'text' =>$totals['text'],
			'value'=>$totals['value']);
		}
		// begin PayPal_Shopping_Cart_IPN
		$order_total_query = olc_db_query("select text, value from " . TABLE_ORDERS_TOTAL .
		" where orders_id = '" . $order_id . "' and class = 'ot_total'");
		// end PayPal_Shopping_Cart_IPN
		$order_total = olc_db_fetch_array($order_total_query);

		//begin PayPal_Shopping_Cart_IPN
		$shipping_method_query="select title, value from " . TABLE_ORDERS_TOTAL .
		" where orders_id = " . $order_id . " and class = 'ot_shipping'";
		$shipping_method_query = olc_db_query($shipping_method_query);
		//end PayPal_Shopping_Cart_IPN		$shipping_method = olc_db_fetch_array($shipping_method_query);
		$shipping_method = olc_db_fetch_array($shipping_method_query);

		$order_status_query = olc_db_query("select orders_status_name from " . TABLE_ORDERS_STATUS .
		" where orders_status_id = '" . $order['orders_status'] .
		"' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
		$order_status = olc_db_fetch_array($order_status_query);
		$shipping_method_text=strip_tags($shipping_method['title']);
		if (substr($shipping_method_text, -1) == ':')
		{
			$shipping_method_text=substr($shipping_method_text, 0, -1);
		}
		$this->info = array(
		'order_id' => $order_id,
		'currency' => $order['currency'],
		'currency_value' => $order['currency_value'],
		'payment_method' => $order['payment_method'],
		'cc_type' => $order['cc_type'],
		'cc_owner' => $order['cc_owner'],
		'cc_number' => $order['cc_number'],
		'cc_expires' => $order['cc_expires'],
		// BMC CC Mod Start
		'cc_start' => $order['cc_start'],
		'cc_issue' => $order['cc_issue'],
		'cc_cvv' => $order['cc_cvv'],
		// BMC CC Mod End
		'date_purchased' => $order['date_purchased'],
		//begin PayPal_Shopping_Cart_IPN
		'orders_status_id' => $order['orders_status'],
		'total_value' => $order_total['value'],
		//end PayPal_Shopping_Cart_IPN
		'orders_status' => $order_status['orders_status_name'],
		'last_modified' => $order['last_modified'],
		'orders_trackcode' => $order['orders_trackcode'],
		'total' => strip_tags($order_total['text']),
		'shipping_cost' => $shipping_method['value'],
		'shipping_class'  => $order['shipping_class'],
		'shipping_method' => $shipping_method_text,
		'orders_trackcode' => $order['orders_trackcode'],
		'comments' => $order['comments'],
		'language' => $order['language'],
		'customers_order_reference' => $order['customers_order_reference']
		);

		$this->customer = array(
		'id' => $order['customers_id'],
		'name' => $order['customers_name'],
		'csID' => $order['customers_cid'],
		'cIP' => $order['customers_ip'],
		'company' => $order['customers_company'],
		'street_address' => $order['customers_street_address'],
		'suburb' => $order['customers_suburb'],
		'city' => $order['customers_city'],
		'postcode' => $order['customers_postcode'],
		'state' => $order['customers_state'],
		'country' => $order['customers_country'],
		'format_id' => $order['customers_address_format_id'],
		'telephone' => $order['customers_telephone'],
		'email_address' => $order['customers_email_address'],
		'email_type' => $order['customers_email_type']);

		$this->delivery = array(
		'name' => $order['delivery_name'],
		'company' => $order['delivery_company'],
		'street_address' => $order['delivery_street_address'],
		'suburb' => $order['delivery_suburb'],
		'city' => $order['delivery_city'],
		'postcode' => $order['delivery_postcode'],
		'state' => $order['delivery_state'],
		'country' => $order['delivery_country'],
		'format_id' => $order['delivery_address_format_id'],
		'delivery_packingslip_number' => $order['delivery_packingslip_number'],
		'delivery_packingslip_date' => $order['delivery_packingslip_date']
		);

		if (empty($this->delivery['name']))
		{
			if (empty($this->delivery['street_address']))
			{
				$this->delivery = false;
			}
		}

		$this->billing = array(
		'name' => $order['billing_name'],
		'company' => $order['billing_company'],
		'street_address' => $order['billing_street_address'],
		'suburb' => $order['billing_suburb'],
		'city' => $order['billing_city'],
		'postcode' => $order['billing_postcode'],
		'state' => $order['billing_state'],
		'country' => $order['billing_country'],
		'format_id' => $order['billing_address_format_id'],
		'billing_invoice_number' => $order['billing_invoice_number'],
		'billing_invoice_date' => $order['billing_invoice_date']);

		$index = 0;
		$orders_products_query = olc_db_query("
		select
		orders_products_id,
		products_id,
		products_name,
		products_model,
		products_price,
		products_tax,
		products_quantity,
		final_price,
		allow_tax,
		products_discount_made
		from " .
		TABLE_ORDERS_PRODUCTS .
		" where orders_id = '" . olc_db_input($order_id) . APOS);
		while ($orders_products = olc_db_fetch_array($orders_products_query))
		{
			$this->products[$index] = array(
			//begin PayPal_Shopping_Cart_IPN
			'id' => $orders_products['products_id'],
			'orders_products_id' => $orders_products['orders_products_id'],
			//end PayPal_Shopping_Cart_IPN
			'qty' => $orders_products['products_quantity'],
			'name' => $orders_products['products_name'],
			'model' => $orders_products['products_model'],
			'tax' => $orders_products['products_tax'],
			'price' => $orders_products['products_price'],
			'discount' => $orders_products['products_discount_made'],
			'final_price' => $orders_products['final_price'],
			'allow_tax' => $orders_products['allow_tax']);

			$subindex = 0;
			$attributes_query = olc_db_query("
				select
				products_options,
				products_options_values,
				products_options_id,
				products_options_values_id,
				options_values_price,
				price_prefix from " .
			TABLE_ORDERS_PRODUCTS_ATTRIBUTES .
			" where orders_id = '" . olc_db_input($order_id) .
			"' and orders_products_id = '" . $orders_products['orders_products_id'] . APOS);
			if (olc_db_num_rows($attributes_query))
			{
				while ($attributes = olc_db_fetch_array($attributes_query)) {
					$this->products[$index]['attributes'][$subindex] = array(
					'option' => $attributes['products_options'],
					'value' => $attributes['products_options_values'],
					//begin PayPal_Shopping_Cart_IPN
					'option_id' => $attributes['products_options_id'],
					'value_id' => $attributes['products_options_values_id'],
					//end PayPal_Shopping_Cart_IPN
					'prefix' => $attributes['price_prefix'],
					'price' => $attributes['options_values_price']);
					$subindex++;
				}
			}
			$index++;
		}
	}

	function cart($customer_id=EMPTY_STRING)
	{
		global $currencies;

		if ($customer_id==EMPTY_STRING)
		{
			$customer_id=CUSTOMER_ID;
		}
		$this->content_type = $_SESSION['cart']->get_content_type();

		$customer_address_query = olc_db_query("
		select
		c.customers_firstname,
		c.customers_cid,
		c.customers_gender,
		c.customers_lastname,
		c.customers_telephone,
		c.customers_email_address,
		c.customers_email_type,
		ab.entry_company,
		ab.entry_street_address,
		ab.entry_suburb,
		ab.entry_postcode,
		ab.entry_city,
		ab.entry_zone_id,
		ab.entry_state,
		z.zone_name,
		co.countries_id,
		co.countries_name,
		co.countries_iso_code_2,
		co.countries_iso_code_3,
		co.address_format_id
		from " .
		TABLE_CUSTOMERS . " c, " .
		TABLE_ADDRESS_BOOK . " ab
		left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
		left join " . TABLE_COUNTRIES . " co on (ab.entry_country_id = co.countries_id)
		where
		c.customers_id = '" . $customer_id . "'
		and ab.customers_id = '" . $customer_id . "'
		and c.customers_default_address_id = ab.address_book_id");
		$customer_address = olc_db_fetch_array($customer_address_query);

		$shipping_address_query = olc_db_query("
		select
		ab.entry_firstname,
		ab.entry_lastname,
		ab.entry_company,
		ab.entry_street_address,
		ab.entry_suburb,
		ab.entry_postcode,
		ab.entry_city,
		ab.entry_zone_id,
		ab.entry_country_id,
		ab.entry_state,
		z.zone_name,
		c.countries_id,
		c.countries_name,
		c.countries_iso_code_2,
		c.countries_iso_code_3,
		c.address_format_id
		from " .
		TABLE_ADDRESS_BOOK . " ab
		left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
		left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id)
		where
		ab.customers_id = '" . $customer_id . "'
		and ab.address_book_id = '" . $_SESSION['sendto'] . APOS);
		$shipping_address = olc_db_fetch_array($shipping_address_query);

		$billing_address_query = olc_db_query("
		select
		ab.entry_firstname,
		ab.entry_lastname,
		ab.entry_company,
		ab.entry_street_address,
		ab.entry_suburb,
		ab.entry_postcode,
		ab.entry_city,
		ab.entry_zone_id,
		ab.entry_state,
		ab.entry_country_id,
		z.zone_name,
		c.countries_id,
		c.countries_name,
		c.countries_iso_code_2,
		c.countries_iso_code_3,
		c.address_format_id
		from " . TABLE_ADDRESS_BOOK . " ab
		left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
		left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id)
		where ab.customers_id = '" . $customer_id . "'
		and ab.address_book_id = '" . $_SESSION['billto'] . APOS);
		$billing_address = olc_db_fetch_array($billing_address_query);

		$tax_address_query = olc_db_query("
		select
		ab.entry_country_id,
		ab.entry_zone_id
		from " .
		TABLE_ADDRESS_BOOK . " ab
		left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
		where ab.customers_id = '" . $_SESSION['$customer_id'] . "' and ab.address_book_id = '" .
		($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto']) . APOS);
		$tax_address = olc_db_fetch_array($tax_address_query);
		$shipping=$_SESSION['shipping'];
		$shipping_class=$shipping['id'];
		//$shipping_class=$shipping['id'];
		$pos=strpos($shipping_class,UNDERSCORE);
		if ($pos > 0)
		{
			$shipping_class=substr($shipping_class,0,$pos);
		}
		$this->info = array(
		'order_status' => DEFAULT_ORDERS_STATUS_ID,
		'currency' => $_SESSION['currency'],
		'currency_value' => $currencies->currencies[$_SESSION['currency']]['value'],
		'payment_method' => $_SESSION['payment'],
		'cc_type' => $GLOBALS['cc_type'],
		'cc_owner' => $GLOBALS['cc_owner'],
		'cc_number' => $GLOBALS['cc_number'],
		'cc_expires' => $GLOBALS['cc_expires'],
		// BMC CC Mod Start
		'cc_start' => $GLOBALS['cc_start'],
		'cc_issue' => $GLOBALS['cc_issue'],
		'cc_cvv' => $GLOBALS['cc_cvv'],
		// BMC CC Mod End
		'shipping_class' =>  $shipping_class,
		'shipping_method' => $shipping['title'],
		'shipping_cost' => $shipping['cost'],
		'comments' => $_SESSION['comments'],
		'payment_class' => $_SESSION['payment'],
		'customers_order_reference' => $_SESSION['customers_order_reference'],
		);

		if (isset($_SESSION['payment']) && is_object($_SESSION['payment'])) {
			$this->info['payment_method'] = $_SESSION['payment']->title;
			$this->info['payment_class'] = $_SESSION['payment']->title;
			if ( isset($_SESSION['payment']->order_status) && is_numeric($_SESSION['payment']->order_status) &&
			($_SESSION['payment']->order_status > 0) ) {
				$this->info['order_status'] = $_SESSION['payment']->order_status;
			}
		}

		$this->customer = array(
		'firstname' => $customer_address['customers_firstname'],
		'lastname' => $customer_address['customers_lastname'],
		'csID' => $customer_address['customers_cid'],
		'gender' => $customer_address['customers_gender'],
		'company' => $customer_address['entry_company'],
		'street_address' => $customer_address['entry_street_address'],
		'suburb' => $customer_address['entry_suburb'],
		'city' => $customer_address['entry_city'],
		'postcode' => $customer_address['entry_postcode'],
		'state' => ((olc_not_null($customer_address['entry_state'])) ?
		$customer_address['entry_state'] : $customer_address['zone_name']),
		'zone_id' => $customer_address['entry_zone_id'],
		'country' => array('id' => $customer_address['countries_id'],
		'title' => $customer_address['countries_name'],
		'iso_code_2' => $customer_address['countries_iso_code_2'],
		'iso_code_3' => $customer_address['countries_iso_code_3']),
		'format_id' => $customer_address['address_format_id'],
		'telephone' => $customer_address['customers_telephone'],
		'email_address' => $customer_address['customers_email_address'],
		'email_type' => $customer_address['customers_email_type'],
		);

		$this->delivery = array(
		'firstname' => $shipping_address['entry_firstname'],
		'lastname' => $shipping_address['entry_lastname'],
		'company' => $shipping_address['entry_company'],
		'street_address' => $shipping_address['entry_street_address'],
		'suburb' => $shipping_address['entry_suburb'],
		'city' => $shipping_address['entry_city'],
		'postcode' => $shipping_address['entry_postcode'],
		'state' => ((olc_not_null($shipping_address['entry_state'])) ?
		$shipping_address['entry_state'] : $shipping_address['zone_name']),
		'zone_id' => $shipping_address['entry_zone_id'],
		'country' => array('id' => $shipping_address['countries_id'],
		'title' => $shipping_address['countries_name'],
		'iso_code_2' => $shipping_address['countries_iso_code_2'],
		'iso_code_3' => $shipping_address['countries_iso_code_3']),
		'country_id' => $shipping_address['entry_country_id'],
		'format_id' => $shipping_address['address_format_id']);

		$this->billing = array(
		'firstname' => $billing_address['entry_firstname'],
		'lastname' => $billing_address['entry_lastname'],
		'company' => $billing_address['entry_company'],
		'street_address' => $billing_address['entry_street_address'],
		'suburb' => $billing_address['entry_suburb'],
		'city' => $billing_address['entry_city'],
		'postcode' => $billing_address['entry_postcode'],
		'state' => ((olc_not_null($billing_address['entry_state'])) ?
		$billing_address['entry_state'] : $billing_address['zone_name']),
		'zone_id' => $billing_address['entry_zone_id'],
		'country' => array('id' => $billing_address['countries_id'],
		'title' => $billing_address['countries_name'],
		'iso_code_2' => $billing_address['countries_iso_code_2'],
		'iso_code_3' => $billing_address['countries_iso_code_3']),
		'country_id' => $billing_address['entry_country_id'],
		'format_id' => $billing_address['address_format_id']);

		$index = 0;
		$tax_country=$tax_address['entry_country_id'];
		$tax_zone=$tax_address['entry_zone_id'];
		$products = $_SESSION['cart']->get_products();
		for ($i=0, $n=sizeof($products); $i<$n; $i++)
		{
			$product=$products[$i];
			$quantity=$product['quantity'];
			$products_id=$product['id'];
			$price=olc_get_products_price($products_id,$price_special=0,$quantity,$price_real);
			$price=abs($price_real);
			$products_attributes=$product['attributes'];
			if ($products_attributes)
			{
				$attributes_price=$_SESSION['cart']->attributes_price($products_id);
				if ((float)$attributes_price<>0)
				{
					$attributes_price=olc_get_products_attribute_price_checkout($attributes_price,0,0,1,EMPTY_STRING,false);
					$price+=$attributes_price;
				}
			}
			$final_price=$price*$quantity;
			$tax_class=$product['tax_class_id'];
			$this->products[$index] = array(
			'qty' => $quantity,
			'name' => $product['name'],
			'model' => $product['model'],
			'tax' => olc_get_tax_rate($tax_class, $tax_country, $tax_zone),
			'tax_description' => olc_get_tax_description($tax_class, $tax_country, $tax_zone),
			'price' =>  $price,
			'final_price' => $final_price,
			'weight' => $product['weight'],
			'id' => $products_id,
			'auctionid' => $product['auctionid']);
			if ($products_attributes)
			{
				$subindex = 0;
				reset($products_attributes);
				while (list($option, $value) = each($products_attributes))
				{
					$attributes_query = olc_db_query("
					select
					popt.products_options_name,
					poval.products_options_values_name,
					pa.options_values_price,
					pa.price_prefix
					from " .
					TABLE_PRODUCTS_OPTIONS . " popt, " .
					TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " .
					TABLE_PRODUCTS_ATTRIBUTES . " pa
					where
					pa.products_id = '" . $products_id . "' and pa.options_id = '" . $option . "'
					and pa.options_id = popt.products_options_id
					and pa.options_values_id = '" . $value . "'
					and pa.options_values_id = poval.products_options_values_id
					and popt.language_id = '" . SESSION_LANGUAGE_ID . "'
					and poval.language_id = '" . SESSION_LANGUAGE_ID . APOS);
					$attributes = olc_db_fetch_array($attributes_query);
					$attributes_price=$attributes['options_values_price'];
					if ($attributes_price>0)
					{
						$attributes_price_prefix=$attributes['price_prefix'];
					}
					else
					{
						$attributes_price_prefix=EMPTY_STRING;
					}
					$this->products[$index]['attributes'][$subindex] =
					array(
					'option' => $attributes['products_options_name'],
					'value' => $attributes['products_options_values_name'],
					'option_id' => $option,
					'value_id' => $value,
					'prefix' => $attributes['price_prefix'],
					'price' => $attributes_price);
					$subindex++;
				}
			}
			$subtotal+=$final_price;
			$shown_price = $final_price;
			if (CUSTOMER_SHOW_OT_DISCOUNT)
			{
				$shown_price_tax = $shown_price-($shown_price/100 * CUSTOMER_OT_DISCOUNT);
			}
			$products_tax = $this->products[$index]['tax'];
			$products_tax_description = $this->products[$index]['tax_description'];
			if (CUSTOMER_SHOW_PRICE_TAX)
			{
				if (CUSTOMER_SHOW_OT_DISCOUNT)
				{
					$shown_price=$shown_price_tax;
				}
				$products_tax_1=str_replace(DOT, EMPTY_STRING, $products_tax);
				$products_tax_1=($products_tax < 10) ? "1.0" . $products_tax_1 : "1." . $products_tax_1;
				$this->info['tax'] += $shown_price - ($shown_price / $products_tax_1);
				$this->info['tax_groups'][TAX_ADD_TAX . "$products_tax_description"] +=
				(($shown_price /(100+$products_tax)) * $products_tax);
			} else {
				if (CUSTOMER_SHOW_OT_DISCOUNT)
				{
					$shown_price=$shown_price_tax;
				}
				$shown_price=($shown_price/100) * $products_tax;
				$this->info['tax'] += $shown_price;
				$this->info['tax_groups'][TAX_NO_TAX . $products_tax_description] +=$shown_price;
			}
			$index++;
		}
		$this->info['subtotal']=$subtotal;
		$this->info['total'] = $subtotal + $this->info['shipping_cost'];
		if (CUSTOMER_SHOW_OT_DISCOUNT)
		{
			$discount=$subtotal * (CUSTOMER_OT_DISCOUNT /100) ;
			$this->info['total'] -= $discount;
			$this->info['orders_discount'] = $discount;
		}
	}
}
?>