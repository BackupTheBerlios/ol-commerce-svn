<?php
/* -----------------------------------------------------------------------------------------
   $Id: password_forgotten.php,v 1.1.1.1.2.1 2007/04/08 07:16:17 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(password_forgotten.php,v 1.49 2003/05/28); www.oscommerce.com 
   (c) 2003	    nextcommerce (password_forgotten.php,v 1.16 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  include( 'includes/application_top.php');

        
  //require(BOXES); 

  // include needed functions
  require_once(DIR_FS_INC.'olc_image_button.inc.php');
  require_once(DIR_FS_INC.'olc_encrypt_password.inc.php');
  require_once(DIR_WS_CLASSES.'class.phpmailer.php');
  require_once(DIR_FS_INC.'olc_php_mail.inc.php');

  

  if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $check_customer_query = olc_db_query("select customers_firstname, customers_lastname, customers_password, customers_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . $_POST['email_address'] . "' and account_type!=1");
    if (olc_db_num_rows($check_customer_query)) {
      $check_customer = olc_db_fetch_array($check_customer_query);
      // Crypted password mods - create a new password, update the database and mail it to them
      $newpass = olc_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);
      $crypted_password = olc_encrypt_password($newpass);
      
      olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS . " set customers_password = '" . $crypted_password . "' where customers_id = '" . $check_customer['customers_id'] . APOS);
      
      	// assign language to template for caching
      
      	// assign vars
      	$smarty->assign('EMAIL',$_POST['email_address']);
      	$smarty->assign('PASSWORD',$newpass);
      	$smarty->assign('FIRSTNAME',$check_customer['customers_firstname']);
      	$smarty->assign('LASTNAME',$check_customer['customers_lastname']);
      	// dont allow cache
  	$smarty->caching = false;
  	
  	// create mails
    $txt_mail=CURRENT_TEMPLATE_MAIL.'change_password_mail.';
    $html_mail=$smarty->fetch($txt_mail.'html');
    $txt_mail=$smarty->fetch($txt_mail.'txt');
      
      olc_php_mail(EMAIL_SUPPORT_ADDRESS,EMAIL_SUPPORT_NAME , $_POST['email_address'], $check_customer['customers_firstname'] . BLANK . $check_customer['customers_lastname'], EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', EMAIL_SUPPORT_SUBJECT, $html_mail, $txt_mail);    
      
      if (!isset($mail_error)) {
          olc_redirect(olc_href_link(FILENAME_LOGIN, 'info_message=' . urlencode(TEXT_PASSWORD_SENT), SSL, true, false));
      }
      else {
          echo $mail_error;
      }
    } else {
      olc_redirect(olc_href_link(FILENAME_PASSWORD_FORGOTTEN, 'email=nonexistent', SSL));
    }
  } else {
    $breadcrumb->add(NAVBAR_TITLE_1_PASSWORD_FORGOTTEN, olc_href_link(FILENAME_LOGIN, '', SSL));
    $breadcrumb->add(NAVBAR_TITLE_2_PASSWORD_FORGOTTEN, olc_href_link(FILENAME_PASSWORD_FORGOTTEN, '', SSL));

 include(DIR_WS_INCLUDES . 'header.php');


 $smarty->assign('FORM_ACTION',olc_draw_form('password_forgotten', olc_href_link(FILENAME_PASSWORD_FORGOTTEN, 'action=process', SSL)));
 $smarty->assign('INPUT_EMAIL',olc_draw_input_field('email_address', '', 'maxlength="96"'));
 $smarty->assign('BUTTON_SUBMIT',olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));

    if (isset($_GET['email']) && ($_GET['email'] == 'nonexistent')) {
    $smarty->assign('error','1');
    }

  }
  $main_content= $smarty->fetch(CURRENT_TEMPLATE_MODULE . 'password_forgotten'.HTML_EXT,SMARTY_CACHE_ID);
  $smarty->assign(MAIN_CONTENT,$main_content);
	  require(BOXES);
$smarty->display(INDEX_HTML);
  ?>