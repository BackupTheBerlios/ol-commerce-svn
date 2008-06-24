<?php
/* -----------------------------------------------------------------------------------------
   $Id: gv_redeem.php,v 1.1.1.1.2.1 2007/04/08 07:16:15 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project (earlier name of osCommerce)
   (c) 2002-2003 osCommerce (gv_redeem.php,v 1.3.2.1 2003/04/18); www.oscommerce.com
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

  require('includes/application_top.php');

  if (ACTIVATE_GIFT_SYSTEM!=TRUE_STRING_S) olc_redirect(FILENAME_DEFAULT);
  
  require_once(DIR_FS_INC.'olc_image_button.inc.php');
  
    
  
  //require(BOXES); 

  require(DIR_WS_INCLUDES . 'header.php');

// check for a voucher number in the url
  if (isset($_GET['gv_no'])) {
    $error = true;
    $gv_query = olc_db_query("select c.coupon_id, c.coupon_amount from " . TABLE_COUPONS . " c, " . TABLE_COUPON_EMAIL_TRACK . " et where coupon_code = '" . $_GET['gv_no'] . "' and c.coupon_id = et.coupon_id");
    if (olc_db_num_rows($gv_query) >0) {
      $coupon = olc_db_fetch_array($gv_query);
      $redeem_query = olc_db_query("select coupon_id from ". TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $coupon['coupon_id'] . APOS);
      if (olc_db_num_rows($redeem_query) == 0 ) {
// check for required session variables
        $_SESSION['gv_id'] = $coupon['coupon_id'];
        $error = false;
      } else {
        $error = true;
      }
    }
  } else {
    olc_redirect(FILENAME_DEFAULT);
  }
  if ((!$error) && (isset($_SESSION['customer_id']))) {
// Update redeem status
    $gv_query = olc_db_query("insert into  " . TABLE_COUPON_REDEEM_TRACK . " (coupon_id, customer_id, redeem_date, redeem_ip) values ('" . $coupon['coupon_id'] . "', '" . $_SESSION['customer_id'] . "', now(),'" . $REMOTE_ADDR . "')");
    $gv_update = olc_db_query(SQL_UPDATE . TABLE_COUPONS . " set coupon_active = 'N' where coupon_id = '" . $coupon['coupon_id'] . APOS);
    olc_gv_account_update($_SESSION['customer_id'], $_SESSION['gv_id']);
    unset($_SESSION['gv_id']);
  }
  
  $breadcrumb->add(NAVBAR_GV_REDEEM);

// if we get here then either the url gv_no was not set or it was invalid
// so output a message.
  $smarty->assign('coupon_amount', $currencies->format($coupon['coupon_amount']));
  $smarty->assign('error', $error);
  $smarty->assign('LINK_DEFAULT', HTML_A_START . olc_href_link(FILENAME_DEFAULT) . '">' . 
  	olc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . HTML_A_END);
  	
  $main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'gv_redeem'.HTML_EXT,SMARTY_CACHE_ID);
  $smarty->assign(MAIN_CONTENT,$main_content);
	  require(BOXES);
$smarty->display(INDEX_HTML);
?>