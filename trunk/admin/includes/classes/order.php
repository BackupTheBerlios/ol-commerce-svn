<?php
/* --------------------------------------------------------------
$Id: order.php,v 1.1.1.1.2.1 2007/04/08 07:16:41 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(order.php,v 1.6 2003/02/06); www.oscommerce.com
(c) 2003	    nextcommerce (order.php,v 1.12 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contribution:

Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

class order {
	var $info, $totals, $products, $customer, $delivery;

	function order($order_id)
	{
		$this->info = array();
		$this->totals = array();
		$this->products = array();
		$this->customer = array();
		$this->delivery = array();

		$this->query($order_id);
	}

	function query($order_id)
	{
		$order_query = olc_db_query("
		select
		customers_name,
		customers_cid,
		customers_id,
		customers_company,
		customers_street_address,
		customers_suburb,
		customers_city,
		customers_postcode,
		customers_state,
		customers_country,
		customers_telephone,
		customers_email_address,
		customers_address_format_id,
		delivery_name,
		delivery_company,
		delivery_street_address,
		delivery_suburb,
		delivery_city,
		delivery_postcode,
		delivery_state,
		delivery_country,
		delivery_address_format_id,
		billing_name,
		billing_company,
		billing_street_address,
		billing_suburb,
		billing_city,
		billing_postcode,
		billing_state,
		billing_country,
		billing_address_format_id,
		billing_invoice_number,
		payment_method,
		cc_type,
		cc_owner,
		cc_number,
		cc_expires,
		comments,
		currency,
		currency_value,
		date_purchased,
		orders_status,
		orders_trackcode,
		last_modified,
		payment_id,
		customers_status,
		customers_status_name,
		customers_status_image,
		customers_ip,
		language,
		customers_status_discount
		from " . TABLE_ORDERS . " where
		orders_id = '" . olc_db_input($order_id) . APOS);

		$order = olc_db_fetch_array($order_query);

		$totals_query = olc_db_query("select title, text from " . TABLE_ORDERS_TOTAL .
		" where orders_id = '" . olc_db_input($order_id) . "' order by sort_order");
		while ($totals = olc_db_fetch_array($totals_query))
		{
			$this->totals[] = array(
			'title' => $totals['title'],
			'text' => $totals['text']);
		}
		$this->info = array(
		'order_id' => $order_id,
		'currency' => $order['currency'],
		'currency_value' => $order['currency_value'],
		'payment_method' => $order['payment_method'],
		'status' => $order['customers_status'],
		'status_name' => $order['customers_status_name'],
		'status_image' => $order['customers_status_image'],
		'status_discount' => $order['customers_status_discount'],
		'cc_type' => $order['cc_type'],
		'cc_owner' => $order['cc_owner'],
		'cc_number' => $order['cc_number'],
		'cc_expires' => $order['cc_expires'],
		'comments' => $order['comments'],
		'language' => $order['language'],
		'date_purchased' => $order['date_purchased'],
		//begin PayPal_Shopping_Cart_IPN
		'payment_id' => $order['payment_id'],
		//end PayPal_Shopping_Cart_IPN
		'orders_status' => $order['orders_status'],
		'orders_trackcode' => $order['orders_trackcode'],
		'last_modified' => $order['last_modified']);

		$this->customer = array(
		'name' => $order['customers_name'],
		//begin PayPal_Shopping_Cart_IPN
		'id' => $order['customers_id'],
		//end PayPal_Shopping_Cart_IPN
		'company' => $order['customers_company'],
		'csID' => $order['customers_cid'],
		'shop_id' => $order['shop_id'],
		'id' => $order['customers_id'],
		'cIP' => $order['customers_ip'],
		'street_address' => $order['customers_street_address'],
		'suburb' => $order['customers_suburb'],
		'city' => $order['customers_city'],
		'postcode' => $order['customers_postcode'],
		'state' => $order['customers_state'],
		'country' => $order['customers_country'],
		'format_id' => $order['customers_address_format_id'],
		'telephone' => $order['customers_telephone'],
		'email_address' => $order['customers_email_address']);

		$this->delivery = array(
		'name' => $order['delivery_name'],
		'company' => $order['delivery_company'],
		'street_address' => $order['delivery_street_address'],
		'suburb' => $order['delivery_suburb'],
		'city' => $order['delivery_city'],
		'postcode' => $order['delivery_postcode'],
		'state' => $order['delivery_state'],
		'country' => $order['delivery_country'],
		'format_id' => $order['delivery_address_format_id']);

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
		'billing_invoice_number' => $order['billing_invoice_number']);

		$index = 0;
		$orders_products_query = olc_db_query("
			select
			orders_products_id,
			products_name,
			products_id,
			products_model,
			products_price,
			products_tax,
			products_quantity,
			final_price,
			allow_tax,
			products_discount_made
			from " .
			TABLE_ORDERS_PRODUCTS . "
			where
			orders_id ='" . olc_db_input($order_id) . APOS);

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
			'allow_tax' => $orders_products['allow_tax'],
			'auctionid' => $orders_products['auctionid']);

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
			if (olc_db_num_rows($attributes_query)) {
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
}
?>