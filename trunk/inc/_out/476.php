<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_collect_posts.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:11 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce coding standards; www.oscommerce.com
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

(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/


function olc_collect_posts() {
	global $coupon_no, $REMOTE_ADDR,$olPrice,$cc_id;

	if (!$REMOTE_ADDR) $REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];
	if ($_POST['gv_redeem_code']) {
		$gv_query = olc_db_query("select coupon_id, coupon_amount, coupon_type, coupon_minimum_order,uses_per_coupon, uses_per_user, restrict_to_products,restrict_to_categories from " . TABLE_COUPONS . " where coupon_code='".$_POST['gv_redeem_code']."' and coupon_active='Y'");
		$gv_result = olc_db_fetch_array($gv_query);

		if (olc_db_num_rows($gv_query) != 0) {
			$redeem_query = olc_db_query("select * from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $gv_result['coupon_id'] . APOS);
			if ( (olc_db_num_rows($redeem_query) != 0) && ($gv_result['coupon_type'] == 'G') ) {
				olc_redirect(olc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_NO_INVALID_REDEEM_GV), SSL));
			}
		}  else {

			olc_redirect(olc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_NO_INVALID_REDEEM_GV), SSL));
		}



		// GIFT CODE G START
		if ($gv_result['coupon_type'] == 'G') {

			$gv_amount = $gv_result['coupon_amount'];
			// Things to set
			// ip address of claimant
			// customer id of claimant
			// date
			// redemption flag
			// now update customer account with gv_amount
			$gv_amount_query=olc_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $_SESSION['customer_id'] . APOS);
			$customer_gv = false;
			$total_gv_amount = $gv_amount;
			if ($gv_amount_result = olc_db_fetch_array($gv_amount_query)) {
				$total_gv_amount = $gv_amount_result['amount'] + $gv_amount;
				$customer_gv = true;
			}
			$gv_update = olc_db_query(SQL_UPDATE . TABLE_COUPONS . " set coupon_active = 'N' where coupon_id = '" . $gv_result['coupon_id'] . APOS);
			$gv_redeem = olc_db_query("insert into  " . TABLE_COUPON_REDEEM_TRACK . " (coupon_id, customer_id, redeem_date, redeem_ip) values ('" . $gv_result['coupon_id'] . "', '" . $_SESSION['customer_id'] . "', now(),'" . $REMOTE_ADDR . "')");
			if ($customer_gv) {
				// already has gv_amount so update
				$gv_update = olc_db_query(SQL_UPDATE . TABLE_COUPON_GV_CUSTOMER . " set amount = '" . $total_gv_amount . "' where customer_id = '" . $_SESSION['customer_id'] . APOS);
			} else {
				// no gv_amount so insert
				$gv_insert = olc_db_query(INSERT_INTO . TABLE_COUPON_GV_CUSTOMER . " (customer_id, amount) values ('" . $_SESSION['customer_id'] . "', '" . $total_gv_amount . "')");
			}
			olc_redirect(olc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(REDEEMED_AMOUNT. $olPrice->olcFormat($gv_amount,true,0,true)), SSL));



		} else {



			if (olc_db_num_rows($gv_query)==0) {
				olc_redirect(olc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_NO_INVALID_REDEEM_COUPON), SSL));
			}

			$date_query=olc_db_query("select coupon_start_date from " . TABLE_COUPONS . " where coupon_start_date <= now() and coupon_code='".$_POST['gv_redeem_code'].APOS);

			if (olc_db_num_rows($date_query)==0) {
				olc_redirect(olc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_STARTDATE_COUPON), SSL));
			}

			$date_query=olc_db_query("select coupon_expire_date from " . TABLE_COUPONS . " where coupon_expire_date >= now() and coupon_code='".$_POST['gv_redeem_code'].APOS);

			if (olc_db_num_rows($date_query)==0) {
				olc_redirect(olc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_FINISDATE_COUPON), SSL));
			}

			$coupon_count = olc_db_query("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $gv_result['coupon_id'].APOS);
			$coupon_count_customer = olc_db_query("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $gv_result['coupon_id']."' and customer_id = '" . $_SESSION['customer_id'] . APOS);

			if (olc_db_num_rows($coupon_count)>=$gv_result['uses_per_coupon'] && $gv_result['uses_per_coupon'] > 0) {
				olc_redirect(olc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_USES_COUPON . $gv_result['uses_per_coupon'] . TIMES ), SSL));
			}

			if (olc_db_num_rows($coupon_count_customer)>=$gv_result['uses_per_user'] && $gv_result['uses_per_user'] > 0) {
				olc_redirect(olc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_USES_USER_COUPON . $gv_result['uses_per_user'] . TIMES ), SSL));
			}
			if ($gv_result['coupon_type']=='S') {
				$coupon_amount = $order->info['shipping_cost'];
			} else {
				$coupon_amount = $gv_result['coupon_amount'] . BLANK;
			}
			if ($gv_result['coupon_type']=='P') $coupon_amount = $gv_result['coupon_amount'] . '% ';
			if ($gv_result['coupon_minimum_order']>0) $coupon_amount .= 'on orders greater than ' . $gv_result['coupon_minimum_order'];
			if (!olc_session_is_registered('cc_id')) olc_session_register('cc_id'); //Fred - this was commented out before
			$_SESSION['cc_id'] = $gv_result['coupon_id']; //Fred ADDED, set the global and session variable
			olc_redirect(olc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(REDEEMED_COUPON), SSL));
		}

	}
	if ($_POST['submit_redeem_x'] && $gv_result['coupon_type'] == 'G') olc_redirect(olc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_NO_REDEEM_CODE), SSL));
}
?>