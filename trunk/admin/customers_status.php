<?php
/* --------------------------------------------------------------
   $Id: customers_status.php,v 1.1.1.1.2.1 2007/04/08 07:16:27 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce( based on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35); www.oscommerce.com
   (c) 2003	    nextcommerce (customers_status.php,v 1.28 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   --------------------------------------------------------------
   based on Third Party contribution:
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  switch ($_GET['action']) {
    case 'insert':
    case 'save':
      $customers_status_id = olc_db_prepare_input($_GET['cID']);

      $languages = olc_get_languages();
      for ($i=0; $i<sizeof($languages); $i++) {
        $customers_status_name_array = $_POST['customers_status_name'];
        $customers_status_show_price = $_POST['customers_status_show_price'];
        $customers_status_show_price_tax = $_POST['customers_status_show_price_tax'];
        $customers_status_public = $_POST['customers_status_public'];
        $customers_status_discount = $_POST['customers_status_discount'];
        $customers_status_ot_discount_flag = $_POST['customers_status_ot_discount_flag'];
        $customers_status_ot_discount = $_POST['customers_status_ot_discount'];
        $customers_status_graduated_prices = $_POST['customers_status_graduated_prices'];
        $customers_status_discount_attributes = $_POST['customers_status_discount_attributes'];
        $customers_status_add_tax_ot = $_POST['customers_status_add_tax_ot'];
        $customers_status_payment_unallowed = $_POST['customers_status_payment_unallowed'];
        $customers_status_shipping_unallowed = $_POST['customers_status_shipping_unallowed'];
        $customers_fsk18 = $_POST['customers_fsk18'];
        $customers_fsk18_display = $_POST['customers_fsk18_display'];

        $language_id = $languages[$i]['id'];

        $sql_data_array = array(
          'customers_status_name' => olc_db_prepare_input($customers_status_name_array[$language_id]),
          'customers_status_public' => olc_db_prepare_input($customers_status_public),
          'customers_status_show_price' => olc_db_prepare_input($customers_status_show_price),
          'customers_status_show_price_tax' => olc_db_prepare_input($customers_status_show_price_tax),
          'customers_status_discount' => olc_db_prepare_input($customers_status_discount),
          'customers_status_ot_discount_flag' => olc_db_prepare_input($customers_status_ot_discount_flag),
          'customers_status_ot_discount' => olc_db_prepare_input($customers_status_ot_discount),
          'customers_status_graduated_prices' => olc_db_prepare_input($customers_status_graduated_prices),
          'customers_status_add_tax_ot' => olc_db_prepare_input($customers_status_add_tax_ot),
          'customers_status_payment_unallowed' => olc_db_prepare_input($customers_status_payment_unallowed),
          'customers_status_shipping_unallowed' => olc_db_prepare_input($customers_status_shipping_unallowed),
          'customers_fsk18' => olc_db_prepare_input($customers_fsk18),
          'customers_fsk18_display' => olc_db_prepare_input($customers_fsk18_display),
          'customers_status_discount_attributes' => olc_db_prepare_input($customers_status_discount_attributes)
        );
        if ($_GET['action'] == 'insert') {
          if (!olc_not_null($customers_status_id)) {
            $next_id_query = olc_db_query("select max(customers_status_id) as customers_status_id from " .
            	TABLE_CUSTOMERS_STATUS);
            $next_id = olc_db_fetch_array($next_id_query);
            $customers_status_id = $next_id['customers_status_id'] + 1;
            // We want to create a personal offer table corresponding to each customers_status
            olc_db_query("create table ". TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS . $customers_status_id .
            	" (price_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, products_id int NOT NULL, quantity int,
            	personal_offer decimal(15,4))");
          }

          $insert_sql_data = array('customers_status_id' => olc_db_prepare_input($customers_status_id),
          'language_id' => olc_db_prepare_input($language_id));
          $sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
          olc_db_perform(TABLE_CUSTOMERS_STATUS, $sql_data_array);

        } elseif ($_GET['action'] == 'save') {
          olc_db_perform(TABLE_CUSTOMERS_STATUS, $sql_data_array, 'update', "customers_status_id = '" . olc_db_input($customers_status_id) . "' and language_id = '" . $language_id . APOS);
        }
      }

      if ($customers_status_image = new upload('customers_status_image', DIR_WS_ICONS)) {
        olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS_STATUS . " set customers_status_image = '" .
        $customers_status_image->filename . "' where customers_status_id = '" . olc_db_input($customers_status_id) . APOS);
      }

      if ($_POST['default'] == 'on') {
        olc_db_query(SQL_UPDATE . TABLE_CONFIGURATION . " set configuration_value = '" .
        olc_db_input($customers_status_id) . "' where configuration_key = 'DEFAULT_CUSTOMERS_STATUS_ID'");
      }

      olc_redirect(olc_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $customers_status_id));
      break;

    case 'deleteconfirm':
      $cID = olc_db_prepare_input($_GET['cID']);

      $customers_status_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'DEFAULT_CUSTOMERS_STATUS_ID'");
      $customers_status = olc_db_fetch_array($customers_status_query);
      if ($customers_status['configuration_value'] == $cID) {
        olc_db_query(SQL_UPDATE . TABLE_CONFIGURATION . " set configuration_value = '' where configuration_key = 'DEFAULT_CUSTOMERS_STATUS_ID'");
      }

      olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_STATUS . " where customers_status_id = '" . olc_db_input($cID) . APOS);

      // We want to drop the existing corresponding personal_offers table
      olc_db_query("drop table IF EXISTS " . TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS . olc_db_input($cID) . "");
      olc_redirect(olc_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page']));
      break;

    case 'delete':
      $cID = olc_db_prepare_input($_GET['cID']);

      $status_query = olc_db_query("select count(*) as count from " . TABLE_CUSTOMERS .
      " where customers_status = '" . olc_db_input($cID) . APOS);
      $status = olc_db_fetch_array($status_query);

      $remove_status = true;
      if (
      	($cID == DEFAULT_CUSTOMERS_STATUS_ID) ||
      	($cID == DEFAULT_CUSTOMERS_STATUS_ID_GUEST) ||
      	($cID == DEFAULT_CUSTOMERS_STATUS_ID_NEWSLETTER)) {
        $remove_status = false;
        $messageStack->add(ERROR_REMOVE_DEFAULT_CUSTOMERS_STATUS, 'error');
      } elseif ($status['count'] > 0) {
        $remove_status = false;
        $messageStack->add(ERROR_STATUS_USED_IN_CUSTOMERS, 'error');
      } else {
        $history_query = olc_db_query("select count(*) as count from " . TABLE_CUSTOMERS_STATUS_HISTORY .
        " where '" . olc_db_input($cID) . "' in (new_value, old_value)");
        $history = olc_db_fetch_array($history_query);
        if ($history['count'] > 0) {
          // delete from history
          olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_STATUS_HISTORY . "
                        where '" . olc_db_input($cID) . "' in (new_value, old_value)");
          $remove_status = true;
          // $messageStack->add(ERROR_STATUS_USED_IN_HISTORY, 'error');
        }
      }
      break;
  }
	require_once(DIR_WS_INCLUDES . 'header.php');
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="columnLeft2" nowrap="nowrap" valign="top"><table border="0" cellspacing="1" cellpadding="1" class="columnLeft" nowrap="nowrap">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="80" rowspan="2"><?php echo olc_image(DIR_WS_ICONS.'heading_customers.gif'); ?></td>
    <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
  </tr>
  <tr>
    <td class="main" valign="top">OLC Kunden</td>
  </tr>
</table></td>
      </tr>
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="left" width=""><?php echo 'icon'; ?></td>
                <td class="dataTableHeadingContent" align="left" width=""><?php echo 'user'; ?></td>
                <td class="dataTableHeadingContent" align="left" width=""><?php echo TABLE_HEADING_CUSTOMERS_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="center" width=""><?php echo TABLE_HEADING_TAX_PRICE; ?></td>
                <td class="dataTableHeadingContent" align="center" colspan="2"><?php echo TABLE_HEADING_DISCOUNT; ?></td>
                <td class="dataTableHeadingContent" width=""><?php echo TABLE_HEADING_CUSTOMERS_GRADUATED; ?></td>
                <td class="dataTableHeadingContent" width=""><?php echo TABLE_HEADING_CUSTOMERS_UNALLOW; ?></td>
                <td class="dataTableHeadingContent" width=""><?php echo TABLE_HEADING_CUSTOMERS_UNALLOW_SHIPPING; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $customers_status_ot_discount_flag_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_graduated_prices_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_public_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_show_price_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_show_price_tax_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_discount_attributes_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_add_tax_ot_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_fsk18_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_fsk18_display_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));

  $customers_status_query_raw = "select *  from " . TABLE_CUSTOMERS_STATUS . " where language_id = '" . SESSION_LANGUAGE_ID . "' order by customers_status_id";

  $customers_status_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $customers_status_query_raw, $customers_status_query_numrows);
  $customers_status_query = olc_db_query($customers_status_query_raw);
  while ($customers_status = olc_db_fetch_array($customers_status_query)) {
    if (((!$_GET['cID']) || ($_GET['cID'] == $customers_status['customers_status_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $cInfo = new objectInfo($customers_status);
    }

    if ( (is_object($cInfo)) && ($customers_status['customers_status_id'] == $cInfo->customers_status_id) ) {
      echo '<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id . '&action=edit') . '">' . NEW_LINE;
    } else {
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $customers_status['customers_status_id']) . '">' . NEW_LINE;
    }

    echo '<td class="dataTableContent" align="left">';
     if ($customers_status['customers_status_image'] != '') {
       echo olc_image(DIR_WS_ICONS . $customers_status['customers_status_image'] , IMAGE_ICON_INFO);
     }
     echo '</td>';

     echo '<td class="dataTableContent" align="left">';
     echo olc_get_status_users($customers_status['customers_status_id']);
     echo '</td>';

    if ($customers_status['customers_status_id'] == DEFAULT_CUSTOMERS_STATUS_ID ) {
      echo '<td class="dataTableContent" align="left"><b>' . $customers_status['customers_status_name'];
      echo LPAREN . TEXT_DEFAULT . RPAREN;
    } else {
      echo '<td class="dataTableContent" align="left">' . $customers_status['customers_status_name'];
    }
    if ($customers_status['customers_status_public'] == '1') {
      echo ' ,public ';
    }
    echo '</b></td>';

    if ($customers_status['customers_status_show_price'] == '1') {
      echo '<td nowrap="nowrap" class="smallText" align="center">€ ';
      if ($customers_status['customers_status_show_price_tax'] == '1') {
        echo TAX_YES;
      } else {
        echo TAX_NO;
      }
    } else {
      echo '<td class="smallText" align="left"> ';
    }
    echo '</td>';

    echo '<td nowrap="nowrap" class="smallText" align="center">' . $customers_status['customers_status_discount'] . ' %</td>';

    echo '<td nowrap="nowrap" class="dataTableContent" align="center">';
    if ($customers_status['customers_status_ot_discount_flag'] == 0){
      echo '<font color="ff0000">'.$customers_status['customers_status_ot_discount'].' %</font>';
    } else {
      echo $customers_status['customers_status_ot_discount'].' %';
    }
    echo ' </td>';

    echo '<td class="dataTableContent" align="center">';
    if ($customers_status['customers_status_graduated_prices'] == 0) {
      echo NO;
    } else {
      echo YES;
    }
    echo '</td>';
    echo '<td nowrap="nowrap" class="smallText" align="center">' . $customers_status['customers_status_payment_unallowed'] . '</td>';
    echo '<td nowrap="nowrap" class="smallText" align="center">' . $customers_status['customers_status_shipping_unallowed'] . '</td>';
    echo NEW_LINE;
?>
                <td class="dataTableContent" align="right"><?php if ( (is_object($cInfo)) && ($customers_status['customers_status_id'] == $cInfo->customers_status_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo HTML_A_START . olc_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $customers_status['customers_status_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="6"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $customers_status_split->display_count($customers_status_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CUSTOMERS_STATUS); ?></td>
                    <td class="smallText" align="right"><?php echo $customers_status_split->display_links($customers_status_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (substr($_GET['action'], 0, 3) != 'new') {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&action=new') . '">' . olc_image_button('button_insert.gif', IMAGE_INSERT) . HTML_A_END; ?></td>
                  </tr>
<?php
  }
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'new':
      $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_NEW_CUSTOMERS_STATUS . HTML_B_END);
      $contents = array('form' => olc_draw_form('status', FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
      $customers_status_inputs_string = '';
      $languages = olc_get_languages();
      for ($i=0; $i<sizeof($languages); $i++) {
        $customers_status_inputs_string .= HTML_BR . olc_image(DIR_WS_CATALOG.'lang/'.$languages[$i]['directory'].'/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . HTML_NBSP . olc_draw_input_field('customers_status_name[' . $languages[$i]['id'] . ']');
      }
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_NAME . $customers_status_inputs_string);
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_IMAGE . HTML_BR . olc_draw_file_field('customers_status_image'));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_PUBLIC_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_PUBLIC . BLANK . olc_draw_pull_down_menu('customers_status_public', $customers_status_public_array, $cInfo->customers_status_public ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_INTRO     . HTML_BR . ENTRY_CUSTOMERS_STATUS_SHOW_PRICE . BLANK . olc_draw_pull_down_menu('customers_status_show_price', $customers_status_show_price_array, $cInfo->customers_status_show_price ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_TAX_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_SHOW_PRICE_TAX . BLANK . olc_draw_pull_down_menu('customers_status_show_price_tax', $customers_status_show_price_tax_array, $cInfo->customers_status_show_price_tax ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_ADD_TAX_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_ADD_TAX . BLANK . olc_draw_pull_down_menu('customers_status_add_tax_ot', $customers_status_add_tax_ot_array, $cInfo->customers_status_add_tax_ot));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE_INTRO . HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . HTML_BR . olc_draw_input_field('customers_status_discount', $cInfo->customers_status_discount));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES_INTRO     . HTML_BR . ENTRY_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES . BLANK . olc_draw_pull_down_menu('customers_status_discount_attributes', $customers_status_discount_attributes_array, $cInfo->customers_status_discount_attributes ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_OT_XMEMBER_INTRO . '<br/> ' . ENTRY_OT_XMEMBER . BLANK . olc_draw_pull_down_menu('customers_status_ot_discount_flag', $customers_status_ot_discount_flag_array, $cInfo->customers_status_ot_discount_flag ). HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . HTML_BR . olc_draw_input_field('customers_status_ot_discount', $cInfo->customers_status_ot_discount));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_GRADUATED_PRICES_INTRO . HTML_BR . ENTRY_GRADUATED_PRICES . BLANK . olc_draw_pull_down_menu('customers_status_graduated_prices', $customers_status_graduated_prices_array, $cInfo->customers_status_graduated_prices ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES . BLANK . olc_draw_pull_down_menu('customers_status_discount_attributes', $customers_status_discount_attributes_array, $cInfo->customers_status_discount_attributes ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_PAYMENT_UNALLOWED_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_PAYMENT_UNALLOWED . BLANK . olc_draw_input_field('customers_status_payment_unallowed', $cInfo->customers_status_payment_unallowed ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_SHIPPING_UNALLOWED_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_SHIPPING_UNALLOWED . BLANK . olc_draw_input_field('customers_status_shipping_unallowed', $cInfo->customers_status_shipping_unallowed ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_FSK18_INTRO . HTML_BR . ENTRY_CUSTOMERS_FSK18 . BLANK . olc_draw_pull_down_menu('customers_fsk18', $customers_fsk18_array, $cInfo->customers_fsk18));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_FSK18_DISPLAY_INTRO . HTML_BR . ENTRY_CUSTOMERS_FSK18_DISPLAY . BLANK . olc_draw_pull_down_menu('customers_fsk18_display', $customers_fsk18_display_array, $cInfo->customers_fsk18_display));
      $contents[] = array('text' => HTML_BR . olc_draw_checkbox_field('default') . BLANK . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_insert.gif', IMAGE_INSERT) . BLANK.HTML_A_START . olc_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page']) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;

    case 'edit':
      $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_EDIT_CUSTOMERS_STATUS . HTML_B_END);
      $contents = array('form' => olc_draw_form('status', FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id  .'&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
      $customers_status_inputs_string = '';
      $languages = olc_get_languages();
      for ($i=0; $i<sizeof($languages); $i++) {
        $customers_status_inputs_string .= HTML_BR . olc_image(DIR_WS_CATALOG.'lang/'.$languages[$i]['directory'].'/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . HTML_NBSP . olc_draw_input_field('customers_status_name[' . $languages[$i]['id'] . ']', olc_get_customers_status_name($cInfo->customers_status_id, $languages[$i]['id']));
      }

      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_NAME . $customers_status_inputs_string);
      $contents[] = array('text' => HTML_BR . olc_image(DIR_WS_ICONS . $cInfo->customers_status_image, $cInfo->customers_status_name) . HTML_BR . DIR_WS_ICONS . '<br/><b>' . $cInfo->customers_status_image . HTML_B_END);
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_IMAGE . HTML_BR . olc_draw_file_field('customers_status_image', $cInfo->customers_status_image));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_PUBLIC_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_PUBLIC . BLANK . olc_draw_pull_down_menu('customers_status_public', $customers_status_public_array, $cInfo->customers_status_public ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_INTRO     . HTML_BR . ENTRY_CUSTOMERS_STATUS_SHOW_PRICE . BLANK . olc_draw_pull_down_menu('customers_status_show_price', $customers_status_show_price_array, $cInfo->customers_status_show_price ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_TAX_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_SHOW_PRICE_TAX . BLANK . olc_draw_pull_down_menu('customers_status_show_price_tax', $customers_status_show_price_tax_array, $cInfo->customers_status_show_price_tax ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_ADD_TAX_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_ADD_TAX . BLANK . olc_draw_pull_down_menu('customers_status_add_tax_ot', $customers_status_add_tax_ot_array, $cInfo->customers_status_add_tax_ot));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE_INTRO . HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . BLANK . olc_draw_input_field('customers_status_discount', $cInfo->customers_status_discount));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES . BLANK . olc_draw_pull_down_menu('customers_status_discount_attributes', $customers_status_discount_attributes_array, $cInfo->customers_status_discount_attributes ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_OT_XMEMBER_INTRO . '<br/> ' . ENTRY_OT_XMEMBER . BLANK . olc_draw_pull_down_menu('customers_status_ot_discount_flag', $customers_status_ot_discount_flag_array, $cInfo->customers_status_ot_discount_flag). HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . BLANK . olc_draw_input_field('customers_status_ot_discount', $cInfo->customers_status_ot_discount));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_GRADUATED_PRICES_INTRO . HTML_BR . ENTRY_GRADUATED_PRICES . BLANK . olc_draw_pull_down_menu('customers_status_graduated_prices', $customers_status_graduated_prices_array, $cInfo->customers_status_graduated_prices));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_PAYMENT_UNALLOWED_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_PAYMENT_UNALLOWED . BLANK . olc_draw_input_field('customers_status_payment_unallowed', $cInfo->customers_status_payment_unallowed ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_SHIPPING_UNALLOWED_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_SHIPPING_UNALLOWED . BLANK . olc_draw_input_field('customers_status_shipping_unallowed', $cInfo->customers_status_shipping_unallowed ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_FSK18_INTRO . HTML_BR . ENTRY_CUSTOMERS_FSK18 . BLANK . olc_draw_pull_down_menu('customers_fsk18', $customers_fsk18_array, $cInfo->customers_fsk18 ));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_FSK18_DISPLAY_INTRO . HTML_BR . ENTRY_CUSTOMERS_FSK18_DISPLAY . BLANK . olc_draw_pull_down_menu('customers_fsk18_display', $customers_fsk18_display_array, $cInfo->customers_fsk18_display));
      if (DEFAULT_CUSTOMERS_STATUS_ID != $cInfo->customers_status_id) $contents[] = array('text' => HTML_BR . olc_draw_checkbox_field('default') . BLANK . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_update.gif', IMAGE_UPDATE) . BLANK.HTML_A_START . olc_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;

    case 'delete':
      $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_CUSTOMERS_STATUS . HTML_B_END);

      $contents = array('form' => olc_draw_form('status', FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id  . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br/><b>' . $cInfo->customers_status_name . HTML_B_END);

      if ($remove_status) $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) . BLANK.HTML_A_START . olc_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;

    default:
      if (is_object($cInfo)) {
        $heading[] = array('text' => HTML_B_START . $cInfo->customers_status_name . HTML_B_END);

        $contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id . '&action=edit') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id . '&action=delete') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
        $customers_status_inputs_string = '';
        $languages = olc_get_languages();
        for ($i=0; $i<sizeof($languages); $i++) {
          $customers_status_inputs_string .= HTML_BR . olc_image(DIR_WS_CATALOG.'lang/'. $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . HTML_NBSP . olc_get_customers_status_name($cInfo->customers_status_id, $languages[$i]['id']);
        }
        $contents[] = array('text' => $customers_status_inputs_string);
        $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE_INTRO . HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . BLANK . $cInfo->customers_status_discount . '%');
        $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_OT_XMEMBER_INTRO . HTML_BR . ENTRY_OT_XMEMBER . BLANK . $customers_status_ot_discount_flag_array[$cInfo->customers_status_ot_discount_flag]['text'] . LPAREN . $cInfo->customers_status_ot_discount_flag . RPAREN . ' - ' . $cInfo->customers_status_ot_discount . '%');
        $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_GRADUATED_PRICES_INTRO . HTML_BR . ENTRY_GRADUATED_PRICES . BLANK . $customers_status_graduated_prices_array[$cInfo->customers_status_graduated_prices]['text'] . LPAREN . $cInfo->customers_status_graduated_prices . RPAREN );
        $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES . BLANK . $customers_status_discount_attributes_array[$cInfo->customers_status_discount_attributes]['text'] . LPAREN . $cInfo->customers_status_discount_attributes . RPAREN );
        $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_PAYMENT_UNALLOWED_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_PAYMENT_UNALLOWED . ':<b> ' . $cInfo->customers_status_payment_unallowed.HTML_B_END);
        $contents[] = array('text' => HTML_BR . TEXT_INFO_CUSTOMERS_STATUS_SHIPPING_UNALLOWED_INTRO . HTML_BR . ENTRY_CUSTOMERS_STATUS_SHIPPING_UNALLOWED . ':<b> ' . $cInfo->customers_status_shipping_unallowed.HTML_B_END);
      }
      break;
  }

  if ( (olc_not_null($heading)) && (olc_not_null($contents)) ) {
    echo '<td width="25%" valign="top">' . NEW_LINE;

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '</td>' . NEW_LINE;
  }
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
