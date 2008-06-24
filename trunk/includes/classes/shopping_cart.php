<?php
/* -----------------------------------------------------------------------------------------
$Id: shopping_cart.php,v 1.1.1.1.2.1 2007/04/08 07:17:48 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.32 2003/02/11); www.oscommerce.com
(c) 2003	    nextcommerce (shopping_cart.php,v 1.21 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:

Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

define('AUCTION_ID_TEXT','auctionid');
if (NOT_IS_ADMIN_FUNCTION)
{
	require_once(DIR_FS_INC.'olc_get_prid.inc.php');
	require_once(DIR_FS_INC.'olc_get_products_attribute_price.inc.php');
}

class shoppingCart
{
	var $contents, $total, $weight, $cartID, $content_type;

	function shoppingCart()
	{
		$this->reset();
	}

	function restore_contents($customer_id=EMPTY_STRING)
	{
		if (!$customer_id)
		{
			$customer_id=CUSTOMER_ID;
		}
		if ($customer_id==0)
		{
			return false;
		}
		$sql_where_customers_id = " where customers_id = " . $customer_id;
		$sql_where_customers_id_and_products_id0 =$sql_where_customers_id . " and products_id = '";
		$comma_blank="', '";
		// insert current cart contents in database
		if (is_array($this->contents))
		{
			$lead=' (customers_id, products_id, ';
			$trail=") values ('" . $customer_id . $comma_blank;
			$insert_basket=INSERT_INTO . TABLE_CUSTOMERS_BASKET .
			$lead ."customers_basket_quantity, customers_basket_date_added".$trail;
			$right_end=$comma_blank . date('Ymd') . "')";
			$insert_basket_attributes=INSERT_INTO . TABLE_CUSTOMERS_BASKET_ATTRIBUTES .
			$lead ."products_options_id, products_options_value_id".$trail;
			reset($this->contents);
			while (list($products_id, ) = each($this->contents))
			{
				$qty = $this->contents[$products_id]['qty'];
				$sql_where_customers_id_and_products_id=$sql_where_customers_id_and_products_id0.$products_id.APOS;
				$product_query = olc_db_query(SELECT."products_id from " . TABLE_CUSTOMERS_BASKET .
				$sql_where_customers_id_and_products_id);
				if (olc_db_num_rows($product_query))
				{
					olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS_BASKET . " set customers_basket_quantity = '" . $qty . APOS .
					$sql_where_customers_id_and_products_id);
				}
				else
				{
					olc_db_query($insert_basket . $products_id . $comma_blank . $qty . $right_end);
					$products_attributes=$this->contents[$products_id]['attributes'];
					if ($products_attributes)
					{
						reset($products_attributes);
						while (list($option, $value) = each($products_attributes))
						{
							olc_db_query($insert_basket_attributes . $products_id . $comma_blank . $option . $comma_blank . $value . "')");
						}
					}
				}
			}
		}
		// reset per-session cart contents, but not the database contents
		$attributes_query0 = SELECT."products_options_id, products_options_value_id from " .
		TABLE_CUSTOMERS_BASKET_ATTRIBUTES . $sql_where_customers_id_and_products_id0;
		$this->reset(false);
		$products_query = olc_db_query(SELECT."products_id, auctionid, customers_basket_quantity from " .
		TABLE_CUSTOMERS_BASKET . 	$sql_where_customers_id);
		while ($products = olc_db_fetch_array($products_query))
		{
			$products_id=$products['products_id'];
			//if product is an auction
			$auctionid=$products[AUCTION_ID_TEXT];
			if ($auctionid)
			{
				//combine ids
				$myproducts_id = $products_id."[".$products[AUCTION_ID_TEXT]."]";
			}
			else
			{
				//no auction
				$myproducts_id =$products_id;
			}
			$this->contents[$myproducts_id] =
			array('qty' => $products['customers_basket_quantity'], AUCTION_ID_TEXT => $auctionid);
			// attributes
			$attributes_query = $attributes_query0.$products_id.APOS;
			if (USE_EBAY)
			{
				if (!$auctionid)
				{
					$auctionid=ZERO_STRING;
				}
				$attributes_query.=" and auctionid = '".$auctionid.APOS;
			}
			$attributes_query = olc_db_query($attributes_query);
			while ($attributes = olc_db_fetch_array($attributes_query))
			{
				$this->contents[$myproducts_id]['attributes'][$attributes['products_options_id']] =
				$attributes['products_options_value_id'];
			}
		}
		$this->cleanup();
	}

	function reset($reset_database = false)
	{
		$this->contents = array();
		$this->total = 0;
		$this->weight = 0;
		$this->content_type = false;
		if (CUSTOMER_ID)
		{
			if ($reset_database)
			{
				$where_cid=" where customers_id='".CUSTOMER_ID.APOS;
				$basket_query = olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET. $where_cid);
				$basket_query = olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . $where_cid);
			}
		}
		unset($this->cartID);
		unset($_SESSION['cartID']);
	}

	function add_cart($products_id, $qty = '1', $attributes = EMPTY_STRING, $notify = true)
	{
		global $new_products_id_in_cart;

		$old_prod_id = $products_id;
		$products_id_string = olc_get_uprid($products_id, $attributes);
		$products_id = $products_id_string;	//olc_get_prid($products_id_string);
		if ($notify)
		{
			$new_products_id_in_cart=$products_id;
			$_SESSION['new_products_id_in_cart'] = $products_id;
		}
		/*# auction.lister ########################
		# look if product in cart is an auction #
		# START-                                #
		#########################################*/
		//look for tmp saved prodid - if it is an auction
		if ($this->contents[$old_prod_id][AUCTION_ID_TEXT])
		{
			//if it is in cart
			if ($this->in_cart($old_prod_id))
			{
				//update quantity and attributes
				$this->update_quantity($old_prod_id, $qty, $attributes);
			}
			//tmp saved prodid is not an auction
		}
		else
		{
			$comma_blank="', '";
			if ($this->in_cart($products_id))
			{
				$this->update_quantity($products_id, $qty, $attributes);
			}
			else
			{
				$this->contents[] = array($products_id);

				$this->contents[$products_id] = array('qty' => $qty);
				// insert into database
				if (CUSTOMER_ID)
				{
					olc_db_query(INSERT_INTO . TABLE_CUSTOMERS_BASKET . "
							(customers_id, products_id, customers_basket_quantity, customers_basket_date_added) values ('" .
					CUSTOMER_ID . $comma_blank . $products_id . $comma_blank . $qty . $comma_blank . date('Ymd') . "')");
				}
				if (is_array($attributes))
				{
					reset($attributes);
					if (CUSTOMER_ID)
					{
						$sql_insert0=INSERT_INTO . TABLE_CUSTOMERS_BASKET_ATTRIBUTES ."
								(customers_id, products_id, products_options_id, products_options_value_id) values ('" .
						CUSTOMER_ID . "$comma_blank#1$comma_blank#2$comma_blank#3')";
						$param_array=array("#1$comma_blank#2$comma_blank#3");
					}
					while (list($option, $value) = each($attributes))
					{
						$this->contents[$products_id]['attributes'][$option] = $value;
						// insert into database
						if (CUSTOMER_ID)
						{
							$sql_insert=str_replace($param_array,array($products_id,$option,$value),$sql_insert0);
							olc_db_query($sql_insert);
						}
					}
				}
			}
		}
		$this->cleanup();
		// assign a temporary unique id to the order contents to prevent hack attempts during the checkout procedure
		$this->cartID = $this->generate_cart_id();
	}

	function update_quantity($products_id, $quantity = EMPTY_STRING, $attributes = EMPTY_STRING)
	{
		if (empty($quantity)) return true; // nothing needs to be updated if theres no quantity, so we return true.
		/*# auction.lister ########################
		# look if product in cart is an auction #
		# START-                                #
		#########################################*/
		//tmp save passed productid
		$old_prod_id = $products_id;
		$products_id_string = olc_get_uprid($products_id, $attributes);
		$products_id = $products_id_string; //olc_get_prid($products_id_string);
		$pid=$products_id_string;
		if (is_numeric($products_id) && is_numeric($quantity) &&
			(isset($this->contents[$products_id_string]) || isset($this->contents[$old_prod_id]))
			)
		{
			//substract auctionid (out of combination --> productid[auctionid])
			$myauctionid = substr(strstr($old_prod_id,"["),1,-1);
			//get clear productid (out of combination --> productid[auctionid])
			$myproducts_id = explode("[",$old_prod_id);
			//look if products are in productsarray (auction and normal products)
			if ($myauctionid)
			{ //if an auction
				$pid=$old_prod_id;
				//also set auctionid in productsarray
				$this->contents[$old_prod_id][AUCTION_ID_TEXT] = $myauctionid;
			}
		}
		$this->contents[$pid] = array('qty' => $quantity);
		// update database
		if (CUSTOMER_ID)
		{
			if (!$myauctionid)
			{
				olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS_BASKET .
				" set customers_basket_quantity = '" . $quantity . "' where customers_id = '" .
				CUSTOMER_ID . "' and products_id = '" . $products_id .APOS);
			}
		}
		if (is_array($attributes))
		{
			if (!$myauctionid)
			{
				$myauctionid=ZERO_STRING;
			}
			reset($attributes);
			while (list($option, $value) = each($attributes))
			{
				$this->contents[$pid]['attributes'][$option] = $value;
				// update database
				if (CUSTOMER_ID)
				{
					$sql_update0=SQL_UPDATE . TABLE_CUSTOMERS_BASKET_ATTRIBUTES .
					" set products_options_value_id = '#3' where customers_id = '" . CUSTOMER_ID .
					"' and products_id = '#1' and products_options_id = '#2' and auctionid='#4'";
					$param_array=array('#1COMMA_BLANK#2COMMA_BLANK#3COMMA_BLANK#4');
				}
				while (list($option, $value) = each($attributes))
				{
					$this->contents[$products_id]['attributes'][$option] = $value;
					// insert into database
					if (CUSTOMER_ID)
					{
						$sql_update=str_replace($param_array,array($products_id,$option,$value,$myauctionid),$sql_update0);
						olc_db_query($sql_update);
					}
				}
			}
		}
	}
	//}

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
					$sql_where=" where customers_id = '" . CUSTOMER_ID . "' and products_id = '" . $key . APOS;
					olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET .$sql_where." and auction=0");
					olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . $sql_where);
				}
			}
		}
	}

	function count_contents()
	{  // get total number of items in cart
		$total_items = 0;
		if (is_array($this->contents))
		{
			reset($this->contents);
			while (list($products_id, ) = each($this->contents))
			{
				$total_items += $this->get_quantity($products_id);
			}
		}
		return $total_items;
	}

	function get_quantity($products_id) {
		if (isset($this->contents[$products_id]))
		{
			return $this->contents[$products_id]['qty'];
		}
		else
		{
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
			$sql_where=" where customers_id = '" . CUSTOMER_ID . "' and products_id = '" . $products_id . APOS;
			olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET .$sql_where." and auction=0");
			olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . $sql_where);
		}
		// assign a temporary unique id to the order contents to prevent hack attempts during the checkout procedure
		$this->cartID = $this->generate_cart_id();
	}

	function remove_all() {
		$this->reset();
	}

	function get_product_id_list() {
		$product_id_list = EMPTY_STRING;
		if (is_array($this->contents))
		{
			$comma_blank="', '";
			reset($this->contents);
			while (list($products_id, ) = each($this->contents)) {
				$product_id_list .= $comma_blank . $products_id;
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
			/*# auction.lister ##########
			# get right product price #
			# START-                  #
			###########################*/
			//get auctionid
			$auctionid = $this->contents[$products_id][AUCTION_ID_TEXT];
			//if product is an auction - get right price out of table auction_details
			$from=SQL_FROM.TABLE_PRODUCTS." p";
			if ($auctionid)
			{
				$sqlquery = "
			ad.auction_endprice".$from.", ".TABLE_AUCTION_LIST." al, ".TABLE_AUCTION_DETAILS." ad, ".TABLE_CUSTOMERS." c
			WHERE
			p.products_id = al.product_id	AND
			c.customers_email_address = ad.buyer_email AND
			al.auction_id = ad.auction_id AND
			al.auction_id='".$auctionid."' AND
			c.customers_id = '".CUSTOMER_ID.APOS;
			}
			else
			{
				//normal shopproduct - normal select
				$sqlquery =
				"p.products_price".$from." where products_id='" . olc_get_prid($products_id) . APOS;
			}
			$product_query = olc_db_query(SELECT."p.products_id, p.products_weight, p.products_tax_class_id, ".$sqlquery);
			if ($product = olc_db_fetch_array($product_query))
			{
				$products_tax_class_id=$product['products_tax_class_id'];
				//if auction
				if ($auctionid)
				{
					//auctionprice is incl. tax - so you have to get the price without tax (because in cart it automatically added)
					$products_price = $product['auction_endprice'];
					$products_tax = olc_get_tax_rate($products_tax_class_id);
					if ($products_tax)
					{
						$products_price = $products_price/(1+($products_tax/100));
					}
				}
				else
				{
					//normalproduct
					$products_price=olc_get_products_price($product['products_id'],$price_special=0,$quantity=$qty,$price_real);
					$products_price=abs($price_real)*$qty;
				}
				$this->total += $products_price;
				$this->weight += ($qty * $product['products_weight']);
			}
			// attributes price
			if (isset($this->contents[$products_id]['attributes'])) {
				reset($this->contents[$products_id]['attributes']);
				while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
					$attribute_price_query =
					olc_db_query("select pd.products_tax_class_id, p.options_values_price, p.price_prefix,
					p.options_values_weight, p.weight_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " p, " . TABLE_PRODUCTS .
					" pd where p.products_id = '" . $product['products_id'] . "' and p.options_id = '" . $option .
					"' and pd.products_id = p.products_id and p.options_values_id = '" . $value . APOS);
					$attribute_price = olc_db_fetch_array($attribute_price_query);

					$attribute_weight=$attribute_price['options_values_weight'];
					$attribute_price_total=($qty * $attribute_price['options_values_weight']);
					if ($attribute_price['weight_prefix'] == '+') {
						$this->weight += $attribute_price_total;
					} else {
						$this->weight -= $attribute_price_total;
					}

					if ($attribute_price['price_prefix'] == '+') {
						$this->total += olc_get_products_attribute_price($attribute_price['options_values_price'],
						$tax_class=$attribute_price['products_tax_class_id'], $price_special=0, $quantity=$qty,
						$prefix=$attribute_price['price_prefix']);
					} else {
						//CB
						if ($attribute_price['price_prefix'] == '/')
						{
							$this->total += olc_get_products_attribute_price($attribute_price['options_values_price'],
							$tax_class=$attribute_price['products_tax_class_id'], $price_special=0, $quantity=$qty,
							$prefix=$attribute_price['price_prefix'])+0.05;
						}else {
							//CB
							if ($attribute_price['price_prefix'] == '-')
							{
								$this->total -= olc_get_products_attribute_price($attribute_price['options_values_price'],
								$tax_class=$attribute_price['products_tax_class_id'], $price_special=0, $quantity=$qty,
								$prefix=$attribute_price['price_prefix']);
							}
						}
					}
				}
			}
		}
		if (CUSTOMER_SHOW_OT_DISCOUNT)
		{
			$this->total -= $this->total/100*CUSTOMER_OT_DISCOUNT;
		}
	}

	function attributes_price($products_id)
	{
		if (isset($this->contents[$products_id]['attributes'])) {
			reset($this->contents[$products_id]['attributes']);
			while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
				$attribute_price_query =
				olc_db_query("
				select pd.products_tax_class_id, p.options_values_price, p.price_prefix
				from " .
				TABLE_PRODUCTS_ATTRIBUTES . " p, " .
				TABLE_PRODUCTS . " pd
				where p.products_id = '" . $products_id . "'
				and p.options_id = '" . $option . "'
				and pd.products_id = p.products_id and
				p.options_values_id = '" . $value . APOS);
				$attribute_price = olc_db_fetch_array($attribute_price_query);
				$options_values_price=$attribute_price['options_values_price'];
				$products_tax_class_id=$attribute_price['products_tax_class_id'];
				$products_attribute_price= olc_get_products_attribute_price($options_values_price,
				$products_tax_class_id, 0, 1,$prefix);
				$prefix=$attribute_price['price_prefix'];
				if ($prefix == '+')
				{
					$attributes_price += $products_attribute_price;
				}
				else if ($prefix == DASH)
				{
					$attributes_price -= $products_attribute_price;
				}
				else if ($prefix == SLASH)
				{
					//CB
					$attributes_price = $this->$attribute_price / $products_attribute_price;
				}
			}
		}
		return $attributes_price;
	}

	function get_products($use_saved_cart=false)
	{
		if (!is_array($this->contents)) return false;

		//if product is an auction
		$sql0=SELECT."
			p.products_id,
			pd.products_name,
			p.products_image,
			p.products_model,
			p.products_min_order_quantity,
			p.products_weight,
			p.products_uvp,
			p.products_tax_class_id,";
		$from="
		from " .
		TABLE_PRODUCTS . " p, " .
		TABLE_PRODUCTS_DESCRIPTION . " pd";
		$where= "
		where
			p.products_id = '#' and
			pd.products_id = p.products_id and
			pd.language_id = '" . SESSION_LANGUAGE_ID . APOS;

		//query: also select for auctionid -
		//there might be more than one auction from the same product (same productid) with different prices
		$auction_trailer= "
		ad.auction_endprice".
		$from.", ".
		TABLE_AUCTION_DETAILS." ad, ".
		TABLE_AUCTION_LIST." al".
		$where."
		AND ad.auction_id = al.auction_id
		AND al.product_id=p.products_id
		AND	al.auction_id = '".ATSIGN.APOS;

		//normal shopproduct - normal select
		$normal_trailer= "
		p.products_price".
		$from.
		$where;

		$sql0_normal=$sql0.$normal_trailer;
		$sql0_auction=$sql0.$auction_trailer;

		$products_array = array();
		reset($this->contents);
		while (list($products_id,) = each($this->contents))
		{
			$auctionid = $this->contents[$products_id][AUCTION_ID_TEXT];
			if ($auctionid)
			{
				$sql=str_replace(ATSIGN,$auctionid,$sql0_auction);
			}
			else
			{
				$sql=$sql0_normal;
			}
			$sql=str_replace(HASH,olc_get_prid($products_id),$sql);
			$products_query = olc_db_query($sql);
			if ($product = olc_db_fetch_array($products_query))
			{
				$product_tax_class_id=$product['products_tax_class_id'];
				//if auction - get right excl. tax price
				if ($auctionid)
				{
					//auctionprice is incl. tax - so you have to get the price without tax (because in cart it automatically added)
					$product_price = $product['auction_endprice'];
					$product_tax = olc_get_tax_rate($product_tax_class_id);
					if ($product_tax)
					{
						$product_price = $product_price/(1+($product_tax/100));
					}
				}
				else
				{
					//normal price - normal shopproduct
					$product_price = $product['products_price'];
				}
				//$product_price = abs(olc_get_products_price($products_id, $price_special=0, $quantity=1,$price_real));
				$product_price = olc_get_products_price($products_id, $price_special=0, $quantity=1,$price_real);
				$product_price = abs($price_real);
				$products_array[] = array(
				'id' => $products_id,
				AUCTION_ID_TEXT => $auctionid,
				'name' => $product['products_name'],
				'model' => $product['products_model'],
				'image' => $product['products_image'],
				'price' => $product_price,
				'discount_allowed' => $max_product_discount,
				'quantity' => $this->contents[$products_id]['qty'],
				'min_quantity'=> $product['products_min_order_quantity'],
				'weight' => $product['products_weight'],
				'final_price' => ($product_price + $this->attributes_price($products_id)),
				'tax_class_id' => $products_tax_class_id,
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

	function generate_cart_id($length = 5) {
		return olc_create_random_value($length, 'digits');
	}

	function get_content_type() {
		$this->content_type = false;

		if ( (DOWNLOAD_ENABLED == TRUE_STRING_S) && ($this->count_contents() > 0) )
		{
			reset($this->contents);
			while (list($products_id, ) = each($this->contents)) {
				if (isset($this->contents[$products_id]['attributes'])) {
					reset($this->contents[$products_id]['attributes']);
					while (list(, $value) = each($this->contents[$products_id]['attributes'])) {
						$virtual_check_query = olc_db_query("select count(*) as total from " .
						TABLE_PRODUCTS_ATTRIBUTES . " pa, " .
						TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad where pa.products_id = '" . $products_id .
						"' and pa.options_values_id = '" . $value .
						"' and pa.products_attributes_id = pad.products_attributes_id");
						$virtual_check = olc_db_fetch_array($virtual_check_query);

						if ($virtual_check['total'] > 0) {
							switch ($this->content_type) {
								case 'physical':
									$this->content_type = 'mixed';
									return $this->content_type;
									break;

								default:
									$this->content_type = 'virtual';
									break;
							}
						} else {
							switch ($this->content_type) {
								case 'virtual':
									$this->content_type = 'mixed';
									return $this->content_type;
									break;

								default:
									$this->content_type = 'physical';
									break;
							}
						}
					}
				} else {
					switch ($this->content_type) {
						case 'virtual':
							$this->content_type = 'mixed';
							return $this->content_type;
							break;

						default:
							$this->content_type = 'physical';
							break;
					}
				}
			}
		} else {
			$this->content_type = 'physical';
		}
		return $this->content_type;
	}

	function unserialize($broken)
	{
		for(reset($broken);$kv=each($broken);) {
			$key=$kv['key'];
			if (gettype($this->$key) != "user function")
			$this->$key=$kv['value'];
		}
	}
	// GV Code Start
	// ------------------------ ICW CREDIT CLASS Gift Voucher Addittion-------------------------------Start
	// amend count_contents to show nil contents for shipping
	// as we don't want to quote for 'virtual' item
	// GLOBAL CONSTANTS if NO_COUNT_ZERO_WEIGHT is true then we don't count any product with a weight
	// which is less than or equal to MINIMUM_WEIGHT
	// otherwise we just don't count gift certificates

	function count_contents_virtual()
	{
		// get total number of items in cart disregard gift vouchers
		$total_items = 0;
		if (is_array($this->contents))
		{
			reset($this->contents);
			while (list($products_id, ) = each($this->contents))
			{
				$no_count = false;
				$gv_query = olc_db_query("select products_model from " . TABLE_PRODUCTS .
				" where products_id = '" . $products_id . APOS);
				$gv_result = olc_db_fetch_array($gv_query);
				if (ereg('^GIFT', $gv_result['products_model']))
				{
					$no_count=true;
				}
				if (NO_COUNT_ZERO_WEIGHT == 1)
				{
					$gv_query = olc_db_query("select products_weight from " . TABLE_PRODUCTS .
					" where products_id = '" . olc_get_prid($products_id) . APOS);
					$gv_result = olc_db_fetch_array($gv_query);
					if ($gv_result['products_weight']<=MINIMUM_WEIGHT)
					{
						$no_count=true;
					}
				}
				if (!$no_count)
				{
					$total_items += $this->get_quantity($products_id);
				}
			}
			return $total_items;
		}
	}
	// ------------------------ ICW CREDIT CLASS Gift Voucher Addittion-------------------------------End
	//GV Code End

	/*# auction.lister #######################
	# function - check product if it is a  #
	# combination of prodid and auctionid  #
	# --> then product would be an auction #
	########################################*/
	function is_auction($products_id)
	{
		$myproduct = $this->contents[$products_id];
		return $myproduct[AUCTION_ID_TEXT] != EMPTY_STRING;
	}
}
?>