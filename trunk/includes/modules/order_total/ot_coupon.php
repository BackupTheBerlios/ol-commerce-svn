<?php
/* -----------------------------------------------------------------------------------------
$Id: ot_coupon.php,v 1.1.1.1.2.1 2007/04/08 07:18:03 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(ot_coupon.php,v 1.1.2.37.3); www.oscommerce.com
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include_once(DIR_FS_INC.'olc_precision.inc.php');

class ot_coupon {
	var $title, $output;

	function ot_coupon() {
		global $olPrice;

		$this->code = 'ot_coupon';
		$this->header = MODULE_ORDER_TOTAL_COUPON_HEADER;
		$this->title = MODULE_ORDER_TOTAL_COUPON_TITLE;
		$this->description = MODULE_ORDER_TOTAL_COUPON_DESCRIPTION;
		$this->user_prompt = '';
		$this->enabled = MODULE_ORDER_TOTAL_COUPON_STATUS;
		$this->sort_order = MODULE_ORDER_TOTAL_COUPON_SORT_ORDER;
		$this->include_shipping = MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING;
		$this->include_tax = MODULE_ORDER_TOTAL_COUPON_INC_TAX;
		$this->calculate_tax = MODULE_ORDER_TOTAL_COUPON_CALC_TAX;
		$this->tax_class = MODULE_ORDER_TOTAL_COUPON_TAX_CLASS;
		$this->credit_class = true;
		$this->output = array ();

	}

	function process() {
		global $order, $olPrice;

		$order_total = $this->get_order_total();
		$od_amount = $this->calculate_credit($order_total);
		$tod_amount = 0.0000; //Fred
		$this->deduction = $od_amount;

		if ($this->calculate_tax != 'None') { //Fred - changed from 'none' to 'None'!
		$tod_amount = $this->calculate_tax_deduction($order_total, $this->deduction, $this->calculate_tax);
		}

		if ($od_amount > 0) {
			$order->info['total'] = $order->info['total'] - $od_amount;
			$order->info['deduction'] = $od_amount;
			$this->output[] = array ('title' => $this->title.':'.$this->coupon_code.':', 'text' => '<b><font color="ff0000">-'.$olPrice->olcFormat($od_amount, true).'</font></b>', 'value' => '-'.$olPrice->olcFormat($od_amount, false)); //Fred added hyphen
		}
	}

	function selection_test() {
		return false;
	}

	function pre_confirmation_check($order_total) {

		return $this->calculate_credit($order_total);
	}

	function use_credit_amount() {
		return $output_string;
	}

	function credit_selection() {
		/*
		$selection_string = '';
		$selection_string .= '<tr>' . NEW_LINE;
		$selection_string .= ' <td  width="10">' . olc_draw_separator('pixel_trans.gif', '10', '1') .'</td>';
		$selection_string .= ' <td  nowrap="nowrap" class="main">' . NEW_LINE;
		$selection_string .=  TEXT_ENTER_COUPON_CODE . '</td>';
		$selection_string .= ' <td  align="right">'. olc_draw_input_field('gv_redeem_code').'</td>';
		$selection_string .= ' <td  width="10">' . olc_draw_separator('pixel_trans.gif', '10', '1') . '</td>';
		$selection_string .= '</tr>' . NEW_LINE;
		*/
		return false;
	}

	function collect_posts() {
		global $olPrice;
		if ($_POST['gv_redeem_code']) {

			// get some info from the coupon table
			$coupon_query = olc_db_query("select coupon_id, coupon_amount, coupon_type, coupon_minimum_order,uses_per_coupon, uses_per_user, restrict_to_products,restrict_to_categories from ".TABLE_COUPONS." where coupon_code='".$_POST['gv_redeem_code']."' and coupon_active='Y'");
			$coupon_result = olc_db_fetch_array($coupon_query);

			// SS ?
			if ($coupon_result['coupon_type'] != 'G') {

				if (olc_db_num_rows($coupon_query) == 0) {
					olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(ERROR_NO_INVALID_REDEEM_COUPON), SSL));
				}

				$date_query = olc_db_query("select coupon_start_date from ".TABLE_COUPONS." where coupon_start_date <= now() and coupon_code='".$_POST['gv_redeem_code'].APOS);

				if (olc_db_num_rows($date_query) == 0) {
					olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(ERROR_INVALID_STARTDATE_COUPON), SSL));
				}

				$date_query = olc_db_query("select coupon_expire_date from ".TABLE_COUPONS." where coupon_expire_date >= now() and coupon_code='".$_POST['gv_redeem_code'].APOS);

				if (olc_db_num_rows($date_query) == 0) {
					olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(ERROR_INVALID_FINISDATE_COUPON), SSL));
				}

				$coupon_count = olc_db_query("select coupon_id from ".TABLE_COUPON_REDEEM_TRACK." where coupon_id = '".$coupon_result['coupon_id'].APOS);
				$coupon_count_customer = olc_db_query("select coupon_id from ".TABLE_COUPON_REDEEM_TRACK." where coupon_id = '".$coupon_result['coupon_id']."' and customer_id = '".$_SESSION['customer_id'].APOS);

				if (olc_db_num_rows($coupon_count) >= $coupon_result['uses_per_coupon'] && $coupon_result['uses_per_coupon'] > 0) {
					olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(ERROR_INVALID_USES_COUPON.$coupon_result['uses_per_coupon'].TIMES), SSL));
				}

				if (olc_db_num_rows($coupon_count_customer) >= $coupon_result['uses_per_user'] && $coupon_result['uses_per_user'] > 0) {
					olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(ERROR_INVALID_USES_USER_COUPON.$coupon_result['uses_per_user'].TIMES), SSL));
				}
				if ($coupon_result['coupon_type'] == 'S') {
					$coupon_amount = $order->info['shipping_cost'];
				} else {
					$coupon_amount = $olPrice->olcFormat($coupon_result['coupon_amount'], true).BLANK;
				}
				if ($coupon_result['coupon_type'] == 'P')
				$coupon_amount = $coupon_result['coupon_amount'].'% ';
				if ($coupon_result['coupon_minimum_order'] > 0)
				$coupon_amount .= 'on orders greater than '.$coupon_result['coupon_minimum_order'];

				$_SESSION['cc_id'] = $coupon_result['coupon_id']; //Fred ADDED, set the global and session variable

			}
			if ($_POST['submit_redeem_coupon_x'] && !$_POST['gv_redeem_code'])
			olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(ERROR_NO_REDEEM_CODE), SSL));
		}
	}

	function calculate_credit($amount) {
		global $order, $olPrice;

		$od_amount = 0;
		if (isset ($_SESSION['cc_id'])) {
			$coupon_query = olc_db_query("select coupon_code from ".TABLE_COUPONS." where coupon_id = '".$_SESSION['cc_id'].APOS);
			if (olc_db_num_rows($coupon_query) != 0) {
				$coupon_result = olc_db_fetch_array($coupon_query);
				$this->coupon_code = $coupon_result['coupon_code'];
				$coupon_get = olc_db_query("select coupon_amount, coupon_minimum_order, restrict_to_products, restrict_to_categories, coupon_type from ".TABLE_COUPONS." where coupon_code = '".$coupon_result['coupon_code'].APOS);
				$get_result = olc_db_fetch_array($coupon_get);
				$c_deduct = $olPrice->olcFormat($get_result['coupon_amount'], true, 0, true);
				//$c_deduct = $get_result['coupon_amount'];
				if ($get_result['coupon_type'] == 'S')
				$c_deduct = $order->info['shipping_cost'];
				// original code             if ($olPrice->olcFormat($get_result['coupon_minimum_order'], true, 0, true) <= $this->get_order_total()) {
				if ($olPrice->olcFormat($get_result['coupon_minimum_order'], true, 0, true) <= $order->info['total']) {
					if ($get_result['restrict_to_products'] || $get_result['restrict_to_categories']) {
						for ($i = 0; $i < sizeof($order->products); $i ++) {
							if ($get_result['restrict_to_products']) {
								$pr_ids = split("[,]", $get_result['restrict_to_products']);
								for ($ii = 0; $ii < count($pr_ids); $ii ++) {
									if ($pr_ids[$ii] == olc_get_prid($order->products[$i]['id'])) {
										if ($get_result['coupon_type'] == 'P') {
											/* Fixes to Gift Voucher module 5.03
											=================================
											Submitted by Rob Cote, robc@traininghott.com

											original code: $od_amount = olc_precision($amount*10)/10*$c_deduct/100;
											$pr_c = $order->products[$i]['final_price']*$order->products[$i]['qty'];
											$pod_amount = olc_precision($pr_c*10)/10*$c_deduct/100;
											*/
											//$pr_c = $order->products[$i]['final_price']*$order->products[$i]['qty'];
											//$pr_c = $this->product_price($pr_ids[$ii]); //Fred 2003-10-28, fix for the row above, otherwise the discount is calc based on price excl VAT!
											//$pod_amount = olc_precision($pr_c * 10) / 10 * $c_deduct / 100;
											//$od_amount = $od_amount + $pod_amount;
											$od_amount = $amount * $get_result['coupon_amount'] / 100;
										} else {
											$od_amount = $c_deduct;
										}
									}
								}
							} else {
								$cat_ids = split("[,]", $get_result['restrict_to_categories']);
								for ($i = 0; $i < sizeof($order->products); $i ++) {
									$my_path = olc_get_product_path(olc_get_prid($order->products[$i]['id']));
									$sub_cat_ids = split("[_]", $my_path);
									for ($iii = 0; $iii < count($sub_cat_ids); $iii ++) {
										for ($ii = 0; $ii < count($cat_ids); $ii ++) {
											if ($sub_cat_ids[$iii] == $cat_ids[$ii]) {
												if ($get_result['coupon_type'] == 'P') {
													/* Category Restriction Fix to Gift Voucher module 5.04
													Date: August 3, 2003
													=================================
													Nick Stanko of UkiDev.com, nick@ukidev.com

													original code:
													$od_amount = olc_precision($amount*10)/10*$c_deduct/100;
													$pr_c = $order->products[$i]['final_price']*$order->products[$i]['qty'];
													$pod_amount = olc_precision($pr_c*10)/10*$c_deduct/100;
													*/
													//$od_amount = olc_precision($amount*10)/10*$c_deduct/100;
													//$pr_c = $order->products[$i]['final_price']*$order->products[$i]['qty'];
													//$pr_c = $this->product_price(olc_get_prid($order->products[$i]['id'])); //Fred 2003-10-28, fix for the row above, otherwise the discount is calc based on price excl VAT!
													//$pod_amount = olc_precision($pr_c * 10) / 10 * $c_deduct / 100;
													//$od_amount = $od_amount + $pod_amount;
													$od_amount = $amount * $get_result['coupon_amount'] / 100;
												} else {
													$od_amount = $c_deduct;
												}
											}
										}
									}
								}
							}
						}
					} else {
						if ($get_result['coupon_type'] != 'P') {
							$od_amount = $c_deduct;
						} else {
							$od_amount = $amount * $get_result['coupon_amount'] / 100;
						}
					}
				}
			}
			if ($od_amount > $amount)
			$od_amount = $amount;
		}
		return $od_amount;
	}

	function calculate_tax_deduction($amount, $od_amount, $method) {
		global $order;

		$coupon_query = olc_db_query("select coupon_code from ".TABLE_COUPONS." where coupon_id = '".$_SESSION['cc_id'].APOS);
		if (olc_db_num_rows($coupon_query) != 0) {
			$coupon_result = olc_db_fetch_array($coupon_query);
			$coupon_get = olc_db_query("select coupon_amount, coupon_minimum_order, restrict_to_products, restrict_to_categories, coupon_type from ".TABLE_COUPONS." where coupon_code = '".$coupon_result['coupon_code'].APOS);
			$get_result = olc_db_fetch_array($coupon_get);

			if ($get_result['coupon_type'] != 'S') {

				//RESTRICTION--------------------------------
				if ($get_result['restrict_to_products'] || $get_result['restrict_to_categories']) {
					// What to do here.
					// Loop through all products and build a list of all product_ids, price, tax class
					// at the same time create total net amount.
					// then
					// for percentage discounts. simply reduce tax group per product by discount percentage
					// or
					// for fixed payment amount
					// calculate ratio based on total net
					// for each product reduce tax group per product by ratio amount.
					$products = $_SESSION['cart']->get_products();
					$valid_product = false;
					for ($i = 0; $i < sizeof($products); $i ++) {
						$valid_product = false;
						$t_prid = olc_get_prid($products[$i]['id']);
						$cc_query = olc_db_query("select products_tax_class_id from ".TABLE_PRODUCTS." where products_id = '".$t_prid.APOS);
						$cc_result = olc_db_fetch_array($cc_query);
						if ($get_result['restrict_to_products']) {
							$pr_ids = split("[,]", $get_result['restrict_to_products']);
							for ($p = 0; $p < sizeof($pr_ids); $p ++) {
								if ($pr_ids[$p] == $t_prid)
								$valid_product = true;
							}
						}
						if ($get_result['restrict_to_categories']) {
							$cat_ids = split("[,]", $get_result['restrict_to_categories']);
							for ($c = 0; $c < sizeof($cat_ids); $c ++) {
								$cat_query = olc_db_query("select products_id from ". TABLE_PRODUCTS_TO_CATEGORIES .
								" where products_id = '".$products_id."' and categories_id = '".$cat_ids[$i].APOS);
								if (olc_db_num_rows($cat_query) != 0)
								$valid_product = true;
							}
						}
						if ($valid_product) {
							$price_excl_vat = $products[$i]['final_price'] * $products[$i]['quantity'];
							$price_incl_vat = $this->product_price($t_prid);
							$valid_array[] = array ('product_id' => $t_prid, 'products_price' => $price_excl_vat, 'products_tax_class' => $cc_result['products_tax_class_id']);
							$total_price += $price_excl_vat;
						}
					}
					if (sizeof($valid_array) > 0) { // if ($valid_product) {
					if ($get_result['coupon_type'] == 'P') {
						$ratio = $get_result['coupon_amount'] / 100;
					} else {
						$ratio = $od_amount / $total_price;
					}
					if ($get_result['coupon_type'] == 'S')
					$ratio = 1;
					if ($method == 'Credit Note') {
						$tax_rate = olc_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
						$tax_desc = olc_get_tax_description($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
						if ($get_result['coupon_type'] == 'P') {
							$tod_amount = $od_amount / (100 + $tax_rate) * $tax_rate;
						} else {
							$tod_amount = $order->info['tax_groups'][$tax_desc] * $od_amount / 100;
						}
						$order->info['tax_groups'][$tax_desc] -= $tod_amount;
						$order->info['total'] -= $tod_amount;
						$order->info['tax'] -= $tod_amount;
					} else {
						for ($p = 0; $p < sizeof($valid_array); $p ++) {
							$tax_rate = olc_get_tax_rate($valid_array[$p]['products_tax_class'], $order->delivery['country']['id'], $order->delivery['zone_id']);
							$tax_desc = olc_get_tax_description($valid_array[$p]['products_tax_class'], $order->delivery['country']['id'], $order->delivery['zone_id']);
							if ($tax_rate > 0) {
								$tod_amount = ($valid_array[$p]['products_price'] * $tax_rate) / 100 * $ratio;
								$order->info['tax_groups'][$tax_desc] -= ($valid_array[$p]['products_price'] * $tax_rate) / 100 * $ratio;
								$order->info['total'] -= ($valid_array[$p]['products_price'] * $tax_rate) / 100 * $ratio;
								$order->info['tax'] -= ($valid_array[$p]['products_price'] * $tax_rate) / 100 * $ratio;
							}
						}
					}
					}
					//NO RESTRICTION--------------------------------
				} else {
					if ($get_result['coupon_type'] == 'F') {
						$tod_amount = 0;
						if ($method == 'Credit Note') {
							$tax_rate = olc_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
							$tax_desc = olc_get_tax_description($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
							$tod_amount = $od_amount / (100 + $tax_rate) * $tax_rate;
							$order->info['tax_groups'][TAX_ADD_TAX.$tax_desc] -= $tod_amount;
						} else {
							reset($order->info['tax_groups']);
							while (list ($key, $value) = each($order->info['tax_groups'])) {
								$ratio1 = $od_amount / ($amount - $order->info['tax_groups'][$key]);
								$tax_rate = olc_get_tax_rate_from_desc( str_replace(TAX_ADD_TAX, "", $key) );
								$net = $tax_rate * $order->info['tax_groups'][$key];
								if ($net > 0) {
									$god_amount = $od_amount * $tax_rate / (100 + $tax_rate);
									$tod_amount += $god_amount;
									$order->info['tax_groups'][$key] -= $god_amount;
								}
							}
						}
						$order->info['tax'] -= $tod_amount;
					}

					if ($get_result['coupon_type'] == 'P') {
						$tod_amount = 0;
						if ($method == 'Credit Note') {
							$tax_desc = olc_get_tax_description($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
							$tod_amount = $order->info['tax_groups'][$tax_desc] * $od_amount / 100;
							$order->info['tax_groups'][TAX_ADD_TAX.$tax_desc] -= $tod_amount;
						} else {
							reset($order->info['tax_groups']);
							while (list ($key, $value) = each($order->info['tax_groups'])) {
								$god_amout = 0;
								$tax_rate = olc_get_tax_rate_from_desc( str_replace(TAX_ADD_TAX, "", $key) );
								$net = $tax_rate * $order->info['tax_groups'][$key];
								if ($net > 0) {
									$god_amount = $order->info['tax_groups'][$key] * $get_result['coupon_amount'] / 100;
									$tod_amount += $god_amount;
									$order->info['tax_groups'][$key] = $order->info['tax_groups'][$key] - $god_amount;
								}
							}
						}
						$order->info['tax'] -= $tod_amount;
					}
				}
			}
		}
		return $tod_amount;
	}

	function update_credit_account($i) {
		return false;
	}

	function apply_credit() {
		global $insert_id, $REMOTE_ADDR;

		if ($this->deduction != 0) {
			olc_db_query(INSERT_INTO.TABLE_COUPON_REDEEM_TRACK." (coupon_id, redeem_date, redeem_ip, customer_id, order_id) values ('".$_SESSION['cc_id']."', now(), '".$REMOTE_ADDR."', '".$_SESSION['customer_id']."', '".$insert_id."')");
		}
		unset ($_SESSION['cc_id']);
	}

	function get_order_total() {
		global $order, $olPrice;

		$module = substr($_SESSION['shipping']['id'], 0, strpos($_SESSION['shipping']['id'], '_'));
		$shipping_tax = olc_get_tax_rate($GLOBALS[$module]->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);

		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1)
		$order_total = $order->info['tax'] + $order->info['total'];
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] != 0)
		$order_total = $order->info['total'];
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0)
		$order_total = $order->info['total'];

		// Check if gift voucher is in cart and adjust total
		$products = $_SESSION['cart']->get_products();
		for ($i = 0; $i < sizeof($products); $i ++) {
			$t_prid = olc_get_prid($products[$i]['id']);
			$gv_query = olc_db_query("select products_price, products_tax_class_id, products_model from ".TABLE_PRODUCTS." where products_id = '".$t_prid.APOS);
			$gv_result = olc_db_fetch_array($gv_query);
			if (ereg('^GIFT', addslashes($gv_result['products_model']))) {
				$qty = $_SESSION['cart']->get_quantity($t_prid);
				$products_tax = $olPrice->TAX[$gv_result['products_tax_class_id']];
				if ($this->include_tax == FALSE_STRING_S) {
					$gv_amount = $gv_result['products_price'] * $qty;
				} else {
					$gv_amount = ($gv_result['products_price'] + $olPrice->calcTax($gv_result['products_price'], $products_tax)) * $qty;
				}
				$order_total = $order_total - $gv_amount;
			}
		}

		if (($this->include_tax == FALSE_STRING_S) && (!($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0)))
		$order_total = $order_total - $order->info['tax'];
		if ($this->include_shipping == FALSE_STRING_S) {
			$order_total = $order_total - $order->info['shipping_cost'];
			if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1)
			$order_total += $order->info['shipping_cost'] / (100 + $shipping_tax) * $shipping_tax;
		}

		// OK thats fine for global coupons but what about restricted coupons
		// where you can only redeem against certain products/categories.
		// and I though this was going to be easy !!!
		$coupon_query = olc_db_query("select coupon_code from ".TABLE_COUPONS." where coupon_id='".$_SESSION['cc_id'].APOS);
		if (olc_db_num_rows($coupon_query) != 0) {
			$coupon_result = olc_db_fetch_array($coupon_query);
			$coupon_get = olc_db_query("select coupon_amount, coupon_minimum_order,restrict_to_products,restrict_to_categories, coupon_type from ".TABLE_COUPONS." where coupon_code='".$coupon_result['coupon_code'].APOS);
			$get_result = olc_db_fetch_array($coupon_get);
			$in_cat = false;
			$in_cart = false;
			if ($get_result['restrict_to_categories']) {
				$cat_ids = split("[,]", $get_result['restrict_to_categories']);
				for ($i = 0; $i < count($cat_ids); $i ++) {
					if (is_array($_SESSION['cart']->contents)) {
						reset($_SESSION['cart']->contents);
						while (list ($products_id,) = each($_SESSION['cart']->contents)) {
							$cat_query = olc_db_query("select products_id from ". TABLE_PRODUCTS_TO_CATEGORIES .
							" where products_id = '".$products_id."' and categories_id = '".$cat_ids[$i].APOS);
							if ((olc_db_num_rows($cat_query) != 0 ) && (stristr($pr_in_cat, olc_get_prid($products_id)) === FALSE)) {
								$in_cat = true;
								$pr_in_cat .= ','.$products_id;
								$total_price += $this->get_product_price($products_id);
							}
						}
					}
				}
			}
			if ($get_result['restrict_to_products']) {
				$pr_ids = split("[,]", $get_result['restrict_to_products']);
				$products_array = $_SESSION['cart']->get_products();
				for ($i = 0; $i < sizeof($pr_ids); $i ++) {
					for ($ii = 1; $ii <= sizeof($products_array); $ii ++) {
						if ((olc_get_prid($products_array[$ii -1]['id']) == $pr_ids[$i]) && (stristr($pr_in_cat, olc_get_prid($products_array[$ii -1]['id'])) === FALSE)) {
							$in_cart = true;
							$total_price += $this->get_product_price($products_array[$ii -1]['id']);
						}
					}
				}
			}

			if ($in_cat || $in_cart){
				if ($this->include_shipping == TRUE_STRING_S){
					if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
						if ($this->include_tax == FALSE_STRING_S) {
							$total_price += $order->info['shipping_cost'];
						} else{
							$total_price += olc_add_tax($order->info['shipping_cost'], $shipping_tax);
							// original code         $total_price += $order->info['shipping_cost'] = olc_add_tax($order->info['shipping_cost'], $shipping_tax);
						}
					} else {
						if ($this->include_tax == FALSE_STRING_S)  {
							$total_price += $order->info['shipping_cost'];
							if   (!($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0))
							$total_price -= $order->info['shipping_cost'] / (100 + $shipping_tax) * $shipping_tax;
						} else {
							$total_price += $order->info['shipping_cost'];
						}
					}
				}
				if ($total_price > $order_total) $total_price = $order_total;
				$order_total = $total_price;
			}
		}
		return $order_total;
	}

	function get_product_price($product_id) {
		global $order, $olPrice;

		$products_id = olc_get_prid($product_id);

		// products price
		$qty = $_SESSION['cart']->contents[$product_id]['qty'];
		$product_query = olc_db_query("select products_id, products_price, products_tax_class_id, products_weight from ".TABLE_PRODUCTS." where products_id='".$product_id.APOS);
		if ($product = olc_db_fetch_array($product_query)) {
			$products_tax = $olPrice->TAX[$product['products_tax_class_id']];
			$prid = $product['products_id'];

			if ($this->include_tax == TRUE_STRING_S){
				if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
					$total_price += (olc_get_products_price($product['products_id'],$price_special=0,$qty) + olc_calculate_tax(olc_get_products_price($product['products_id'],$price_special=0,$qty), $products_tax));
				} else {
					$total_price += olc_get_products_price($product['products_id'],$price_special=0,$qty);
				}
			} else {
				if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) {
					$total_price += (olc_get_products_price($product['products_id'],$price_special=0,$qty) - olc_calculate_tax(olc_get_products_price($product['products_id'],$price_special=0,$qty) / (100 + $products_tax) * 100, $products_tax));
				} else {
					$total_price += olc_get_products_price($product['products_id'],$price_special=0,$qty);
				}
			}

			// attributes price
			if (isset ($_SESSION['cart']->contents[$product_id]['attributes'])) {
				reset($_SESSION['cart']->contents[$product_id]['attributes']);
				while (list ($option, $value) = each($_SESSION['cart']->contents[$product_id]['attributes'])) {
					$attribute_price_query = olc_db_query("select options_values_price, price_prefix from ".TABLE_PRODUCTS_ATTRIBUTES." where products_id = '".$prid."' and options_id = '".$option."' and options_values_id = '".$value.APOS);
					$attribute_price = olc_db_fetch_array($attribute_price_query);
					if ($attribute_price['price_prefix'] == '+') {
						if ($this->include_tax == TRUE_STRING_S) {
							if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
								$total_price += olc_get_products_attribute_price($attribute_price['options_values_price'],$product['products_tax_class_id'],0,$qty,$attribute_price['price_prefix']) + olc_calculate_tax(olc_get_products_attribute_price($attribute_price['options_values_price'],$product['products_tax_class_id'],0,$qty,$attribute_price['price_prefix']), $products_tax);
							} else {
								$total_price += olc_get_products_attribute_price($attribute_price['options_values_price'],$product['products_tax_class_id'],0,$qty,$attribute_price['price_prefix']);
							}
						} else {
							$total_price += olc_get_products_attribute_price($attribute_price['options_values_price'],'',0,$qty,$attribute_price['price_prefix']);
						}
					} else {
						if ($this->include_tax == TRUE_STRING_S) {
							if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
								$total_price -= olc_get_products_attribute_price($attribute_price['options_values_price'],$product['products_tax_class_id'],0,$qty,$attribute_price['price_prefix']) + olc_calculate_tax(olc_get_products_attribute_price($attribute_price['options_values_price'],$product['products_tax_class_id'],0,$qty,$attribute_price['price_prefix']), $products_tax);
							} else {
								$total_price -= olc_get_products_attribute_price($attribute_price['options_values_price'],$product['products_tax_class_id'],0,$qty,$attribute_price['price_prefix']);
							}
						} else {
							$total_price -= olc_get_products_attribute_price($attribute_price['options_values_price'],'',0,$qty,$attribute_price['price_prefix']);
						}
					}
				}
			}
		}
		return $total_price;
	}

	function product_price($product_id) {
		$total_price = $this->get_product_price($product_id);
		if ($this->include_shipping == TRUE_STRING_S)
		$total_price -= $order->info['shipping_cost'];
		return $total_price;
	}

	function check() {
		if (!isset ($this->check)) {
			$check_query = olc_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_ORDER_TOTAL_COUPON_STATUS'");
			$this->check = olc_db_num_rows($check_query);
		}

		return $this->check;
	}

	function keys() {
		return array ('MODULE_ORDER_TOTAL_COUPON_STATUS', 'MODULE_ORDER_TOTAL_COUPON_SORT_ORDER', 'MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING', 'MODULE_ORDER_TOTAL_COUPON_INC_TAX', 'MODULE_ORDER_TOTAL_COUPON_CALC_TAX', 'MODULE_ORDER_TOTAL_COUPON_TAX_CLASS');
	}

	function install() {
		olc_db_query(INSERT_INTO.TABLE_CONFIGURATION." (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('', 'MODULE_ORDER_TOTAL_COUPON_STATUS', 'true', '6', '1','olc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		olc_db_query(INSERT_INTO.TABLE_CONFIGURATION." (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('', 'MODULE_ORDER_TOTAL_COUPON_SORT_ORDER', '70', '6', '2', now())");
		olc_db_query(INSERT_INTO.TABLE_CONFIGURATION." (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('', 'MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING', 'true', '6', '5', 'olc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		olc_db_query(INSERT_INTO.TABLE_CONFIGURATION." (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('', 'MODULE_ORDER_TOTAL_COUPON_INC_TAX', 'true', '6', '6','olc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		olc_db_query(INSERT_INTO.TABLE_CONFIGURATION." (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('', 'MODULE_ORDER_TOTAL_COUPON_CALC_TAX', 'None', '6', '7','olc_cfg_select_option(array(\'None\', \'Standard\', \'Credit Note\'), ', now())");
		olc_db_query(INSERT_INTO.TABLE_CONFIGURATION." (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('', 'MODULE_ORDER_TOTAL_COUPON_TAX_CLASS', '0', '6', '0', 'olc_get_tax_class_title', 'olc_cfg_pull_down_tax_classes(', now())");
	}

	function remove() {
		$keys = '';
		$keys_array = $this->keys();
		for ($i = 0; $i < sizeof($keys_array); $i ++) {
			$keys .= APOS.$keys_array[$i]."',";
		}
		$keys = substr($keys, 0, -1);

		olc_db_query(DELETE_FROM.TABLE_CONFIGURATION." where configuration_key in (".$keys.RPAREN);
	}
}
?>
