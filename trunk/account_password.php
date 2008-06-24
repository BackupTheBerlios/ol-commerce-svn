<?php
/* -----------------------------------------------------------------------------------------
   $Id: account_password.php,v 1.1.1.1.2.1 2007/04/08 07:16:02 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(account_password.php,v 1.1 2003/05/19); www.oscommerce.com 
   (c) 2003	    nextcommerce (account_password.php,v 1.14 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  include( 'includes/application_top.php');
             
  //require(BOXES); 
  // include needed functions
  require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
  require_once(DIR_FS_INC.'olc_draw_password_field.inc.php');
  require_once(DIR_FS_INC.'olc_validate_password.inc.php');
  require_once(DIR_FS_INC.'olc_encrypt_password.inc.php');
  require_once(DIR_FS_INC.'olc_image_button.inc.php');

  if (!isset($_SESSION['customer_id'])) {
    
    olc_redirect(olc_href_link(FILENAME_LOGIN));
  }

  if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    $password_current = olc_db_prepare_input($_POST['password_current']);
    $password_new = olc_db_prepare_input($_POST['password_new']);
    $password_confirmation = olc_db_prepare_input($_POST['password_confirmation']);

    $error = false;

    if (strlen($password_current) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;

      $messageStack->add('account_password', ENTRY_PASSWORD_CURRENT_ERROR);
    } elseif (strlen($password_new) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;

      $messageStack->add('account_password', ENTRY_PASSWORD_NEW_ERROR);
    } elseif ($password_new != $password_confirmation) {
      $error = true;

      $messageStack->add('account_password', ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING);
    }

    if ($error == false) {
      $check_customer_query = olc_db_query("select customers_password from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$_SESSION['customer_id'] . APOS);
      $check_customer = olc_db_fetch_array($check_customer_query);

      if (olc_validate_password($password_current, $check_customer['customers_password'])) {
        olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS . " set customers_password = '" . olc_encrypt_password($password_new) . "' where customers_id = '" . (int)$_SESSION['customer_id'] . APOS);

        olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS_INFO . " set customers_info_date_account_last_modified = now() where customers_info_id = '" . (int)$_SESSION['customer_id'] . APOS);
	      $messageStack->add_session('account', SUCCESS_PASSWORD_UPDATED, 'success');
        olc_redirect(olc_href_link(FILENAME_ACCOUNT));
      } else {
        $error = true;

        $messageStack->add('account_password', ERROR_CURRENT_PASSWORD_NOT_MATCHING);
      }
    }
  }

  $breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_PASSWORD, olc_href_link(FILENAME_ACCOUNT));
  $breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_PASSWORD, olc_href_link(FILENAME_ACCOUNT_PASSWORD));

 require(DIR_WS_INCLUDES . 'header.php');

  if ($messageStack->size('account_password') > 0) {
  $smarty->assign('error',$messageStack->output('account_password'));

  }
  $smarty->assign('FORM_ACTION',olc_draw_form('account_password', olc_href_link(FILENAME_ACCOUNT_PASSWORD), 'post', 'onsubmit="return check_form(account_password);"') . olc_draw_hidden_field('action', 'process'));
  $smarty->assign('INPUT_ACTUAL',olc_draw_password_field('password_current') . HTML_NBSP . (olc_not_null(ENTRY_PASSWORD_CURRENT_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_CURRENT_TEXT . '</span>': ''));
  $smarty->assign('INPUT_NEW',olc_draw_password_field('password_new') . HTML_NBSP . (olc_not_null(ENTRY_PASSWORD_NEW_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_NEW_TEXT . '</span>': ''));
  $smarty->assign('INPUT_CONFIRM',olc_draw_password_field('password_confirmation') . HTML_NBSP . (olc_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>': ''));

 $smarty->assign('BUTTON_BACK',HTML_A_START . olc_href_link(FILENAME_ACCOUNT) . '">' . olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END);
 $smarty->assign('BUTTON_SUBMIT',olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));

  $main_content= $smarty->fetch(CURRENT_TEMPLATE_MODULE . 'account_password'.HTML_EXT,SMARTY_CACHE_ID);
  $smarty->assign(MAIN_CONTENT,$main_content);
	  require(BOXES);
$smarty->display(INDEX_HTML);
  ?>