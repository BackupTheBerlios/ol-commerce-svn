<?php
/* --------------------------------------------------------------
$Id: shopping_cart.php,v 1.1.1.1.2.1 2007/04/08 07:16:42 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.7 2002/05/16); www.oscommerce.com
(c) 2003	    nextcommerce (shopping_cart.php,v 1.6 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

class shoppingCart
{
	var $contents, $total, $weight;

	function shoppingCart()
	{
		$this->reset();
	}

	function restore_contents()
	{
		if (CUSTOMER_ID==0) return 0;
		// insert current cart contents in database
		if ($this->contents)
		{
			reset($this->contents);
			while (list($products_id, ) = each($this->contents))
			{
				$qty = $this->contents[$products_id]['qty'];
				$product_query = olc_db_query("select products_id from " . TABLE_CUSTOMERS_BASKET .
				" where customers_id = '" . CUSTOMER_ID . "' and products_id = '" . $products_id . APOS);
				if (olc_db_num_rows($product_query))
				{
					olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS_BASKET . " set customers_basket_quantity = '" . $qty .
					"' where customers_id = '" . CUSTOMER_ID . "' and products_id = '" . $products_id . APOS);
				}
				else
				{
					olc_db_query(INSERT_INTO . TABLE_CUSTOMERS_BASKET .
					" (customers_id, products_id, customers_basket_quantity, customers_basket_date_added) values ('" .
					CUSTOMER_ID . "', '" . $products_id . "', '" . $qty . "', '" . date('Ymd') . "')");
					if ($this->contents[$products_id]['attributes']) {
						reset($this->contents[$products_id]['attributes']);
						while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
							olc_db_query(INSERT_INTO . TABLE_CUSTOMERS_BASKET_ATTRIBUTES .
							" (customers_id, products_id, products_options_id, products_options_value_id) values ('" .
							CUSTOMER_ID . "', '" . $products_id . "', '" . $option . "', '" . $value . "')");
						}
					}
				}
			}
		}
		// reset per-session cart contents, but not the database contents
		$this->reset(FALSE);
		$products_query = olc_db_query("select products_id, customers_basket_quantity from " . TABLE_CUSTOMERS_BASKET .
		" where customers_id = '" . CUSTOMER_ID . APOS);
		while ($products = olc_db_fetch_array($products_query)) {
			$this->contents[$products['products_id']] = array('qty' => $products['customers_basket_quantity']);
			// attributes
			$attributes_query = olc_db_query("select products_options_id, products_options_value_id from " .
			TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . CUSTOMER_ID . "' and products_id = '" .
			$products['products_id'] . APOS);
			while ($attributes = olc_db_fetch_array($attributes_query)) {
				$this->contents[$products['products_id']]['attributes'][$attributes['products_options_id']] =
				$attributes['products_options_value_id'];
			}
		}
		$this->cleanup();
	}

	function reset($reset_database = FALSE)
	{
		$this->contents = array();
		$this->total = 0;
		if (CUSTOMER_ID>0 )
		{
			if ($reset_database)
			{
				$where=" where customers_id = '" . CUSTOMER_ID . APOS;
				$delete=DELETE_FROM;
				olc_db_query($delete . TABLE_CUSTOMERS_BASKET . $where);
				olc_db_query($delete . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . $where);
			}
		}
	}

	function add_cart($products_id, $qty = EMPTY_STRING, $attributes = EMPTY_STRING)
	{
		$products_id = olc_get_uprid($products_id, $attributes);
		if ($this->in_cart($products_id))
		{
			$this->update_quantity($products_id, $qty, $attributes);
		}
		else
		{
			if ($qty == EMPTY_STRING) $qty = '1'; // if no quantity is supplied, then add '1' to the customers basket
			$this->contents[] = array($products_id);
			$this->contents[$products_id] = array('qty' => $qty);
			// insert into database
			if (CUSTOMER_ID)
			{
				$insert=INSERT_INTO;
				$sep="', '";
				$fields=" (customers_id, products_id, ";
				$values=") values ('" . CUSTOMER_ID . "', '" . $products_id .$sep;
				olc_db_query($insert . TABLE_CUSTOMERS_BASKET .
				$fields."customers_basket_quantity, customers_basket_date_added". $values . $qty . $sep . date('Ymd') . "')");
			}
			if (is_array($attributes))
			{
				reset($attributes);
				while (list($option, $value) = each($attributes)) {
					$this->contents[$products_id]['attributes'][$option] = $value;
					// insert into database
					if (CUSTOMER_ID)
					{
						olc_db_query($insert . TABLE_CUSTOMERS_BASKET_ATTRIBUTES .
						$fields."products_options_id, products_options_value_id". $values . $option . $sep . $value . "')");
					}
				}
			}
			$_SESSION['new_products_id_in_cart'] = $products_id;
		}
		$this->cleanup();
	}

	function update_quantity($products_id, $quantity = EMPTY_STRING, $attributes = EMPTY_STRING)
	{
		if ($quantity == EMPTY_STRING) return true; // nothing needs to be updated if theres no quantity, so we return true..
		$this->contents[$products_id] = array('qty' => $quantity);
		// update database
		if (CUSTOMER_ID)
		{
			olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS_BASKET . " set customers_basket_quantity = '" .
			$quantity . "' where customers_id = '" . CUSTOMER_ID . "' and products_id = '" . $products_id . APOS);
		}
		if (is_array($attributes))
		{
			reset($attributes);
			while (list($option, $value) = each($attributes)) {
				$this->contents[$products_id]['attributes'][$option] = $value;
				// update database
				if (CUSTOMER_ID) olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS_BASKET_ATTRIBUTES .
				" set products_options_value_id = '" . $value . "' where customers_id = '" . CUSTOMER_ID .
				"' and products_id = '" . $products_id . "' and products_options_id = '" . $option . APOS);
			}
		}
	}

	function cleanup()
	{
		reset($this->contents);
		while (list($key,) = each($this->contents))
		{
			if ($this->contents[$key]['qty'] < 1)
			{
				unset($this->contents[$key]);
				// remove from database
				if (CUSTOMER_ID)
				{
					$where=" where customers_id = '" . CUSTOMER_ID . "' and products_id = '" . $key . APOS;
					$delete=DELETE_FROM;
					olc_db_query($delete . TABLE_CUSTOMERS_BASKET . $where);
					olc_db_query($delete . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . $where);
				}
			}
		}
	}

	function count_contents() {  // get total number of items in cart
		$total_items = 0;
		if (is_array($this->contents)) {
			reset($this->contents);
			while (list($products_id, ) = each($this->contents)) {
				$total_items += $this->get_quantity($products_id);
			}
		}
		return $total_items;
	}

	function get_quantity($products_id) {
		if ($this->contents[$products_id]) {
			return $this->contents[$products_id]['qty'];
		} else {
			return 0;
		}
	}

	function in_cart($products_id) {
		return isset($this->contents[$products_id]);
	}

	function remove($products_id)
	{
		unset($this->contents[$products_id]);
		// remove from database
		if (CUSTOMER_ID)
		{
			$where=" where customers_id = '" . CUSTOMER_ID . "' and products_id = '" . $products_id . APOS;
			$delete=DELETE_FROM;
			olc_db_query($delete . TABLE_CUSTOMERS_BASKET . $where);
			olc_db_query($delete . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . $where);
		}
	}

	function remove_all() {
		$this->reset();
	}

	function get_product_id_list() {
		$product_id_list = EMPTY_STRING;
		if (is_array($this->contents)) {
			reset($this->contents);
			while (list($products_id, ) = each($this->contents)) {
				$product_id_list .= ', ' . $products_id;
			}
		}
		return substr($product_id_list, 2);
	}

	function calculate()
	{
		$this->total = 0;
		$this->weight = 0;
		if (!is_array($this->contents)) return 0;

		reset($this->contents);
		while (list($products_id, ) = each($this->contents)) {
			$qty = $this->contents[$products_id]['qty'];

			// products price
			$product_query = olc_db_query("select products_id, products_price, products_tax_class_id, products_weight from " .
			TABLE_PRODUCTS . " where products_id='" . olc_get_prid($products_id) . APOS);
			if ($product = olc_db_fetch_array($product_query)) {
				$prid = $product['products_id'];
				$products_tax = olc_get_tax_rate($product['products_tax_class_id']);
				$products_price = $product['products_price'];
				$products_weight = $product['products_weight'];

				$specials_query = olc_db_query("select specials_new_products_price from " . TABLE_SPECIALS .
				" where products_id = '" . $prid . "' and status = '1'");
				if (olc_db_num_rows ($specials_query)) {
					$specials = olc_db_fetch_array($specials_query);
					$products_price = $specials['specials_new_products_price'];
				}

				$this->total += olc_add_tax($products_price, $products_tax) * $qty;
				$this->weight += ($qty * $products_weight);
			}

			// attributes price
			if ($this->contents[$products_id]['attributes']) {
				reset($this->contents[$products_id]['attributes']);
				while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
					$attribute_price_query = olc_db_query("select options_values_price, price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES .
					" where products_id = '" . $prid . "' and options_id = '" . $option . "' and options_values_id = '" . $value . APOS);
					$attribute_price = olc_db_fetch_array($attribute_price_query);
					if ($attribute_price['price_prefix'] == '+') {
						$this->total += $qty * olc_add_tax($attribute_price['options_values_price'], $products_tax);
					} else {
						$this->total -= $qty * olc_add_tax($attribute_price['options_values_price'], $products_tax);
					}
				}
			}
		}
	}

	function attributes_price($products_id)
	{
		if ($this->contents[$products_id]['attributes']) {
			reset($this->contents[$products_id]['attributes']);
			while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
				$attribute_price_query = olc_db_query("
				select options_values_price, price_prefix from " .
				TABLE_PRODUCTS_ATTRIBUTES .
				" where products_id = '" . $products_id . "'
				and options_id = '" . $option . "'
				and options_values_id = '" . $value . APOS);
				$attribute_price = olc_db_fetch_array($attribute_price_query);
				$options_values_price=$attribute_price['options_values_price'];
				$prefix=$attribute_price['price_prefix'];
				if ($prefix == '+')
				{
					$attributes_price += $options_values_price;
				}
				else if ($prefix == '-')
				{
					$attributes_price -= $options_values_price;
				}
				else if ($prefix == '/')
				{
					//CB
					$attributes_price = $this->$attribute_price / $options_values_price;
				}
			}
		}

		return $attributes_price;
	}

	function get_products() {

		if (!is_array($this->contents)) return 0;
		$products_array = array();
		reset($this->contents);
		while (list($products_id, ) = each($this->contents))
		{
			$products_query = olc_db_query("
			select p.products_id, pd.products_name, p.products_model, p.products_price, p.products_weight, p.products_tax_class_id from "
			.TABLE_PRODUCTS . " p, " .
			TABLE_PRODUCTS_DESCRIPTION . " pd
			where p.products_id='" . olc_get_prid($products_id) . "'
			and pd.products_id = p.products_id
			and pd.language_id = '" . SESSION_LANGUAGE_ID . APOS);
			if ($products = olc_db_fetch_array($products_query)) {
				$prid = $products['products_id'];
				$products_price = $products['products_price'];
				$specials_query = olc_db_query("select specials_new_products_price from " . TABLE_SPECIALS .
				" where products_id = '" . $prid . "' and status = '1'");
				if (olc_db_num_rows($specials_query)) {
					$specials = olc_db_fetch_array($specials_query);
					$products_price = $specials['specials_new_products_price'];
				}
					$products_array[] = array('id' => $products_id,
				'name' => $products['products_name'],
				'model' => $products['products_model'],
				'price' => $products_price,
				'quantity' => $this->contents[$products_id]['qty'],
				'weight' => $products['products_weight'],
				'final_price' => ($products_price + $this->attributes_price($products_id)),
				'tax_class_id' => $products['products_tax_class_id'],
				'attributes' => $this->contents[$products_id]['attributes']);
			}
		}
		return $products_array;
	}

	function show_total() {
		$this->calculate();

		return $this->total;
	}

	function show_weight() {
		$this->calculate();

		return $this->weight;
	}

	function unserialize($broken) {
		for(reset($broken);$kv=each($broken);) {
			$key=$kv['key'];
			if (gettype($this->$key)!="user function")
			$this->$key=$kv['value'];
		}
	}
}
?>