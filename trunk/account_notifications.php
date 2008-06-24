<?php
/* -----------------------------------------------------------------------------------------
   $Id: account_notifications.php,v 1.1.1.1.2.1 2007/04/08 07:16:02 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(account_notifications.php,v 1.2 2003/05/22); www.oscommerce.com
   (c) 2003	    nextcommerce (account_notifications.php,v 1.13 2003/08/17); www.nextcommerce.org 
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  include( 'includes/application_top.php');
            
  //require(BOXES); 
  // include needed functions
  require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
  require_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');
  require_once(DIR_FS_INC.'olc_draw_selection_field.inc.php');
  require_once(DIR_FS_INC.'olc_image_button.inc.php');

  if (!isset($_SESSION['customer_id'])) {
    
    olc_redirect(olc_href_link(FILENAME_LOGIN, '', SSL));
  }


  $global_query = olc_db_query("select global_product_notifications from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . (int)$_SESSION['customer_id'] . APOS);
  $global = olc_db_fetch_array($global_query);

  if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    if (isset($_POST['product_global']) && is_numeric($_POST['product_global'])) {
      $product_global = olc_db_prepare_input($_POST['product_global']);
    } else {
      $product_global = '0';
    }

    (array)$products = $_POST['products'];

    if ($product_global != $global['global_product_notifications']) {
      $product_global = (($global['global_product_notifications'] == '1') ? '0' : '1');

      olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS_INFO . " set global_product_notifications = '" . (int)$product_global . "' where customers_info_id = '" . (int)$_SESSION['customer_id'] . APOS);
    } elseif (sizeof($products) > 0) {
      $products_parsed = array();
      for ($i=0, $n=sizeof($products); $i<$n; $i++) {
        if (is_numeric($products[$i])) {
          $products_parsed[] = $products[$i];
        }
      }

      if (sizeof($products_parsed) > 0) {
        $check_query = olc_db_query("select count(*) as total from " . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$_SESSION['customer_id'] . "' and products_id not in (" . implode(',', $products_parsed) . RPAREN);
        $check = olc_db_fetch_array($check_query);

        if ($check['total'] > 0) {
          olc_db_query(DELETE_FROM . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$_SESSION['customer_id'] . "' and products_id not in (" . implode(',', $products_parsed) . RPAREN);
        }
      }
    } else {
      $check_query = olc_db_query("select count(*) as total from " . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$_SESSION['customer_id'] . APOS);
      $check = olc_db_fetch_array($check_query);

      if ($check['total'] > 0) {
        olc_db_query(DELETE_FROM . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$_SESSION['customer_id'] . APOS);
      }
    }
    $messageStack->add_session('account', SUCCESS_NOTIFICATIONS_UPDATED, 'success');
    olc_redirect(olc_href_link(FILENAME_ACCOUNT));
  }

  $breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_NOTIFICATIONS, olc_href_link(FILENAME_ACCOUNT, '', SSL));
  $breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_NOTIFICATIONS, olc_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', SSL));

 require(DIR_WS_INCLUDES . 'header.php');



$smarty->assign('CHECKBOX_GLOBAL',olc_draw_checkbox_field('product_global', '1', (($global['global_product_notifications'] == '1') ? true : false), 'onclick="javascript:checkBox(\'product_global\')"'));
if ($global['global_product_notifications'] != '1') {
$smarty->assign('GLOBAL_NOTIFICATION','0');
} else {
$smarty->assign('GLOBAL_NOTIFICATION','1');
}
  if ($global['global_product_notifications'] != '1') {

    $products_check_query = olc_db_query("select count(*) as total from " . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$_SESSION['customer_id'] . APOS);
    $products_check = olc_db_fetch_array($products_check_query);
    if ($products_check['total'] > 0) {

      $counter = 0;
      $notifications_products='<table width="100%" border="0" cellspacing="0" cellpadding="0">';
      $products_query = olc_db_query("select pd.products_id, pd.products_name from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_NOTIFICATIONS . " pn where pn.customers_id = '" . (int)$_SESSION['customer_id'] . "' and pn.products_id = pd.products_id and pd.language_id = '" . SESSION_LANGUAGE_ID . "' order by pd.products_name");
      while ($products = olc_db_fetch_array($products_query)) {
      $notifications_products.= '

                  <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="javascript:checkBox(\'products['.$counter.']\')">
                    <td class="main" width="30">'.olc_draw_checkbox_field('products[' . $counter . ']', $products['products_id'], true, 'onclick="javascript:checkBox(\'products[' . $counter . ']\')"').'</td>
                    <td class="main"><b>'.$products['products_name'].'</b></td>
                  </tr> ';

        $counter++;
      }
      $notifications_products.= '</table>';
      $smarty->assign('PRODUCTS_NOTIFICATION',$notifications_products);
    } else {

    }

  }

  $smarty->assign('FORM_ACTION',olc_draw_form('account_notifications', olc_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', SSL)) . olc_draw_hidden_field('action', 'process'));
  $smarty->assign('BUTTON_BACK',HTML_A_START . olc_href_link(FILENAME_ACCOUNT, '', SSL) . '">' . olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END);
  $smarty->assign('BUTTON_CONTINUE',olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
  
  $main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'account_notifications'.HTML_EXT,SMARTY_CACHE_ID);
  $smarty->assign(MAIN_CONTENT,$main_content);
  require(BOXES);
$smarty->display(INDEX_HTML);
  ?>