<?php
/* -----------------------------------------------------------------------------------------
   $Id: gv_send.php,v 1.1.1.1.2.1 2007/04/08 07:16:15 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project (earlier name of osCommerce)
   (c) 2002-2003 osCommerce (gv_send.php,v 1.1.2.3 2003/05/12); www.oscommerce.com
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

  require('includes/classes/http_client.php');
  
  require_once(DIR_FS_INC.'olc_draw_textarea_field.inc.php');
  require_once(DIR_FS_INC.'olc_image_button.inc.php');
  require_once(DIR_FS_INC.'olc_validate_email.inc.php');
  require_once(DIR_WS_CLASSES.'class.phpmailer.php');
  require_once(DIR_FS_INC.'olc_php_mail.inc.php');


    
  
// if the customer is not logged on, redirect them to the login page
  if (!isset($_SESSION['customer_id'])) {
    olc_redirect(olc_href_link(FILENAME_LOGIN, '', SSL));
  }

  if (($_POST['back_x']) || ($_POST['back_y'])) {
    $_GET['action'] = '';
  }
  if ($_GET['action'] == 'send') {
    $error = false;
    if (!olc_validate_email(trim($_POST['email']))) {
      $error = true;
      $error_email = ERROR_ENTRY_EMAIL_ADDRESS_CHECK;
    }
    $gv_query = olc_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $_SESSION['customer_id'] . APOS);
    $gv_result = olc_db_fetch_array($gv_query);
    $customer_amount = $gv_result['amount'];
    $gv_amount = trim($_POST['amount']);
    if (ereg('[^0-9/.]', $gv_amount)) {
      $error = true;
      $error_amount = ERROR_ENTRY_AMOUNT_CHECK; 
    }
    if ($gv_amount>$customer_amount || $gv_amount == 0) {
      $error = true; 
      $error_amount = ERROR_ENTRY_AMOUNT_CHECK; 
    } 
  }
  if ($_GET['action'] == 'process') {
    $id1 = create_coupon_code($mail['customers_email_address']);
    $gv_query = olc_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id='".$_SESSION['customer_id'].APOS);
    $gv_result=olc_db_fetch_array($gv_query);
    $new_amount=$gv_result['amount']-$_POST['amount'];
    if ($new_amount<0) {
      $error= true;
      $error_amount = ERROR_ENTRY_AMOUNT_CHECK; 
      $_GET['action'] = 'send';
    } else {
      $gv_query=olc_db_query(SQL_UPDATE . TABLE_COUPON_GV_CUSTOMER . " set amount = '" . $new_amount . "' where customer_id = '" . $_SESSION['customer_id'] . APOS);
      $gv_query=olc_db_query("select customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " where customers_id = '" . $_SESSION['customer_id'] . APOS);
      $gv_customer=olc_db_fetch_array($gv_query);
      $gv_query=olc_db_query(INSERT_INTO . TABLE_COUPONS . " (coupon_type, coupon_code, date_created, coupon_amount) values ('G', '" . $id1 . "', NOW(), '" . $_POST['amount'] . "')");
      $insert_id = olc_db_insert_id($gv_query);
      $gv_query=olc_db_query(INSERT_INTO . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, sent_lastname, emailed_to, date_sent) values ('" . $insert_id . "' ,'" . $_SESSION['customer_id'] . "', '" . addslashes($gv_customer['customers_firstname']) . "', '" . addslashes($gv_customer['customers_lastname']) . "', '" . $_POST['email'] . "', now())");


      $gv_email_subject = sprintf(EMAIL_GV_TEXT_SUBJECT, stripslashes($_POST['send_name']));

      $smarty->assign('GIFT_LINK',olc_href_link(FILENAME_GV_REDEEM, 'gv_no=' . $id1,NONSSL,false));
      $smarty->assign('AMMOUNT',$currencies->format($_POST['amount']));
      $smarty->assign('GIFT_ID',$id1);
      $smarty->assign('MESSAGE',$_POST['message']);
      $smarty->assign('NAME',$_POST['to_name']);
      $smarty->assign('FROM_NAME',$_POST['send_name']);

      // dont allow cache
     $smarty->caching = false;
		 $txt_mail=CURRENT_TEMPLATE_MAIL.'send_gift_to_friend.';
     $html_mail=$smarty->fetch($txt_mail.'html');
     $txt_mail=$smarty->fetch($txt_mail.'txt');

     // send mail
     olc_php_mail(
                  EMAIL_BILLING_ADDRESS,
                  EMAIL_BILLING_NAME,
                  $_POST['email'],
                  $_POST['to_name'],
                  '',
                  EMAIL_BILLING_REPLY_ADDRESS,
                  EMAIL_BILLING_REPLY_ADDRESS_NAME,
                  '',
                  '',
                  $gv_email_subject,
                  $html_mail,
                  $txt_mail
                  );

    }
  }
  $breadcrumb->add(NAVBAR_GV_SEND);

  
  require(DIR_WS_INCLUDES . 'header.php');

  if ($_GET['action'] == 'process') {
  	$smarty->assign('action', 'process');
  	$smarty->assign('LINK_DEFAULT', HTML_A_START.olc_href_link(FILENAME_DEFAULT, '', NONSSL) . '">'.olc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE).HTML_A_END);
  }  
  if ($_GET['action'] == 'send' && !$error) {
  	$smarty->assign('action', 'send');
    // validate entries
      $gv_amount = (double) $gv_amount;
      $gv_query = olc_db_query("select customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " where customers_id = '" . $_SESSION['customer_id'] . APOS);
      $gv_result = olc_db_fetch_array($gv_query);
      $send_name = $gv_result['customers_firstname'] . BLANK . $gv_result['customers_lastname'];
			//W. Kaiser - AJAX
			$smarty->assign('FORM_ACTION', olc_draw_form('gv_send', olc_href_link(FILENAME_GV_SEND, 'action=process', NONSSL)));
			//W. Kaiser - AJAX
      $smarty->assign('MAIN_MESSAGE', sprintf(MAIN_MESSAGE, $currencies->format($_POST['amount']), stripslashes($_POST['to_name']), $_POST['email'], stripslashes($_POST['to_name']), $currencies->format($_POST['amount']), $send_name));
      if ($_POST['message']) {
      	$smarty->assign('PERSONAL_MESSAGE', sprintf(PERSONAL_MESSAGE, $gv_result['customers_firstname']));
      	$smarty->assign('POST_MESSAGE', stripslashes($_POST['message']));
      }
      $smarty->assign('HIDDEN_FIELDS', olc_draw_hidden_field('send_name', $send_name) . olc_draw_hidden_field('to_name', stripslashes($_POST['to_name'])) . olc_draw_hidden_field('email', $_POST['email']) . olc_draw_hidden_field('amount', $gv_amount) . olc_draw_hidden_field('message', stripslashes($_POST['message'])));
      $smarty->assign('LINK_BACK', olc_image_submit('button_back.gif', IMAGE_BUTTON_BACK, 'name=back') . HTML_A_END);
      $smarty->assign('LINK_SUBMIT', olc_image_submit('button_send.gif', IMAGE_BUTTON_CONTINUE));
  } elseif ($_GET['action']=='' || $error) {
  	$smarty->assign('action', '');
		//W. Kaiser - AJAX
		$smarty->assign('FORM_ACTION', olc_draw_form('gv_send', olc_href_link(FILENAME_GV_SEND, 'action=send', NONSSL)));
		//W. Kaiser - AJAX
  	$smarty->assign('LINK_SEND', olc_href_link(FILENAME_GV_SEND, 'action=send', NONSSL));
	$smarty->assign('INPUT_TO_NAME', olc_draw_input_field('to_name', stripslashes($_POST['to_name'])));
	$smarty->assign('INPUT_EMAIL', olc_draw_input_field('email', $_POST['email']));
	$smarty->assign('ERROR_EMAIL', $error_email);
	$smarty->assign('INPUT_AMOUNT', olc_draw_input_field('amount', $_POST['amount'], '', '', false));
	$smarty->assign('ERROR_AMOUNT', $error_amount);
	$smarty->assign('TEXTAREA_MESSAGE', olc_draw_textarea_field('message', 'soft', 50, 15, stripslashes($_POST['message'])));
    $smarty->assign('LINK_SUBMIT', olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
  }
$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'gv_send'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>