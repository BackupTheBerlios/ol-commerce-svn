<?php
/*------------------------------------------------------------------------------
  $Id: blacklist.php,v 1.1.1.1.2.1 2007/04/08 07:16:25 gswkaiser Exp $

  OLC-CC - Contribution for OL-Commerce http://www.ol-commerce.com, http://www.seifenparadies.de
  modified by http://www.netz-designer.de

  Copyright (c) 2003 netz-designer
  -----------------------------------------------------------------------------
  based on:
  $Id: blacklist.php,v 1.00 2003/04/10 BMC

  Copyright (c) 2003 BMC
  http://www.mainframes.co.uk

  (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
------------------------------------------------------------------------------*/

  require('includes/application_top.php');
  //require(DIR_FS_CATALOG . DIR_WS_LANGUAGES . SESSION_LANGUAGE . '/admin/blacklist.php');

  switch ($_GET['action']) {
    case 'insert':
    case 'save':
      $blacklist_id = olc_db_prepare_input($_GET['bID']);
      $blacklist_card_number = olc_db_prepare_input($_POST['blacklist_card_number']);

      $sql_data_array = array('blacklist_card_number' => $blacklist_card_number);

      if ($_GET['action'] == 'insert') {
        $insert_sql_data = array('date_added' => 'now()');
        $sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
        olc_db_perform(TABLE_BLACKLIST, $sql_data_array);
        $blacklist_id = olc_db_insert_id();
      } elseif ($_GET['action'] == 'save') {
        $update_sql_data = array('last_modified' => 'now()');
        $sql_data_array = olc_array_merge($sql_data_array, $update_sql_data);
        olc_db_perform(TABLE_BLACKLIST, $sql_data_array, 'update', "blacklist_id = '" . olc_db_input($blacklist_id) . APOS);
      }

/*      $manufacturers_image = olc_get_uploaded_file('manufacturers_image');
      $image_directory = olc_get_local_path(DIR_FS_CATALOG_IMAGES);

      if (is_uploaded_file($manufacturers_image['tmp_name'])) {
        if (!is_writeable($image_directory)) {
          if (is_dir($image_directory)) {
            $messageStack->add_session(sprintf(ERROR_DIRECTORY_NOT_WRITEABLE, $image_directory), 'error');
          } else {
            $messageStack->add_session(sprintf(ERROR_DIRECTORY_DOES_NOT_EXIST, $image_directory), 'error');
          }
        } else {
          olc_db_query(SQL_UPDATE . TABLE_MANUFACTURERS . " set manufacturers_image = '" . $manufacturers_image['name'] . "' where manufacturers_id = '" . olc_db_input($manufacturers_id) . APOS);
          olc_copy_uploaded_file($manufacturers_image, $image_directory);
        }
      }
*/
//      $languages = olc_get_languages();
//      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
//        $manufacturers_url_array = $_POST['manufacturers_url'];
//       $language_id = $languages[$i]['id'];

//        $sql_data_array = array('manufacturers_url' => olc_db_prepare_input($manufacturers_url_array[$language_id]));

//        if ($_GET['action'] == 'insert') {
//          $insert_sql_data = array('manufacturers_id' => $manufacturers_id,
//                                   'languages_id' => $language_id);
//          $sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
//          olc_db_perform(TABLE_MANUFACTURERS_INFO, $sql_data_array);
//        } elseif ($_GET['action'] == 'save') {
//          olc_db_perform(TABLE_MANUFACTURERS_INFO, $sql_data_array, 'update', "manufacturers_id = '" . olc_db_input($manufacturers_id) . "' and languages_id = '" . $language_id . APOS);
//        }
//      }

      if (USE_CACHE == TRUE_STRING_S) {
        olc_reset_cache_block('blacklist');
      }

      olc_redirect(olc_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $blacklist_id));
      break;
    case 'deleteconfirm':
      $blacklist_id = olc_db_prepare_input($_GET['bID']);

/*      if ($_POST['delete_image'] == 'on') {
        $manufacturer_query = olc_db_query("select manufacturers_image from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . olc_db_input($manufacturers_id) . APOS);
        $manufacturer = olc_db_fetch_array($manufacturer_query);
        $image_location = DIR_FS_DOCUMENT_ROOT . DIR_WS_CATALOG_IMAGES . $manufacturer['manufacturers_image'];
        if (file_exists($image_location)) @unlink($image_location);
      }
*/
      olc_db_query(DELETE_FROM . TABLE_BLACKLIST . " where blacklist_id = '" . olc_db_input($blacklist_id) . APOS);
//      olc_db_query(DELETE_FROM . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . olc_db_input($manufacturers_id) . APOS);

/*      if ($_POST['delete_products'] == 'on') {
        $products_query = olc_db_query("select products_id from " . TABLE_PRODUCTS . " where manufacturers_id = '" . olc_db_input($manufacturers_id) . APOS);
        while ($products = olc_db_fetch_array($products_query)) {
          olc_remove_product($products['products_id']);
        }
      } else {
        olc_db_query(SQL_UPDATE . TABLE_PRODUCTS . " set manufacturers_id = '' where manufacturers_id = '" . olc_db_input($manufacturers_id) . APOS);
      }
*/
      if (USE_CACHE == TRUE_STRING_S) {
        olc_reset_cache_block('manufacturers');
      }

      olc_redirect(olc_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page']));
      break;
  }
?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
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
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_BLACKLIST; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $blacklist_query_raw = "select blacklist_id, blacklist_card_number, date_added, last_modified from " . TABLE_BLACKLIST . " order by blacklist_id";
  $blacklist_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $blacklist_query_raw, $blacklist_query_numrows);
  $blacklist_query = olc_db_query($blacklist_query_raw);
  while ($blacklist = olc_db_fetch_array($blacklist_query)) {
    if (((!$_GET['bID']) || (@$_GET['bID'] == $blacklist['blacklist_id'])) && (!$bInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $blacklist_numbers_query = olc_db_query("select count(*) as blacklist_count from " . TABLE_BLACKLIST . " where blacklist_id = '" . $blacklist['blacklist_id'] . APOS);
      $blacklist_numbers = olc_db_fetch_array($blacklist_numbers_query);

      $bInfo_array = olc_array_merge($blacklist, $blacklist_numbers);
      $bInfo = new objectInfo($bInfo_array);
    }

    if ( (is_object($bInfo)) && ($blacklist['blacklist_id'] == $bInfo->blacklist_id) ) {
      echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $blacklist['blacklist_id'] . '&action=edit') . '">' . NEW_LINE;
    } else {
      echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $blacklist['blacklist_id']) . '">' . NEW_LINE;
    }
?>
                <td class="dataTableContent"><?php echo $blacklist['blacklist_card_number']; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($bInfo)) && ($blacklist['blacklist_id'] == $bInfo->blacklist_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo HTML_A_START . olc_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $blacklist['blacklist_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $blacklist_split->display_count($blacklist_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_BLACKLIST_CARDS); ?></td>
                    <td class="smallText" align="right"><?php echo $blacklist_split->display_links($blacklist_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
  if ($_GET['action'] != 'new') {
?>
              <tr>
                <td align="right" colspan="2" class="smallText"><?php echo HTML_A_START . olc_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $bInfo->blacklist_id . '&action=new') . '">' . olc_image_button('button_insert.gif', IMAGE_INSERT) . HTML_A_END; ?></td>
              </tr>
<?php
  }
?>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'new':
      $heading[] = array('text' => HTML_B_START . TEXT_HEADING_NEW_BLACKLIST_CARD . HTML_B_END);

      $contents = array('form' => olc_draw_form('blacklisted', FILENAME_BLACKLIST, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_NEW_INTRO);
      $contents[] = array('text' => HTML_BR . TEXT_BLACKLIST_CARD_NUMBER . HTML_BR . olc_draw_input_field('blacklist_card_number'));
//      $contents[] = array('text' => HTML_BR . TEXT_MANUFACTURERS_IMAGE . HTML_BR . olc_draw_file_field('manufacturers_image'));

      $blacklist_inputs_string = '';
//      $languages = olc_get_languages();
//      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
//        $manufacturer_inputs_string .= HTML_BR . olc_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . HTML_NBSP . olc_draw_input_field('manufacturers_url[' . $languages[$i]['id'] . ']');
//      }

//      $contents[] = array('text' => HTML_BR . TEXT_MANUFACTURERS_URL . $manufacturer_inputs_string);
      $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_save.gif', IMAGE_SAVE) . BLANK.HTML_A_START . olc_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $_GET['bID']) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;
    case 'edit':
      $heading[] = array('text' => HTML_B_START . TEXT_HEADING_EDIT_BLACKLIST_CARD . HTML_B_END);

      $contents = array('form' => olc_draw_form('blacklisted', FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $bInfo->blacklist_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_EDIT_INTRO);
      $contents[] = array('text' => HTML_BR . TEXT_BLACKLIST_CARD_NUMBER . HTML_BR . olc_draw_input_field('blacklist_card_number', $bInfo->blacklist_card_number));
//      $contents[] = array('text' => HTML_BR . TEXT_MANUFACTURERS_IMAGE . HTML_BR . olc_draw_file_field('manufacturers_image') . HTML_BR . $mInfo->manufacturers_image);

      $blacklist_inputs_string = '';
//      $languages = olc_get_languages();
//      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
//        $manufacturer_inputs_string .= HTML_BR . olc_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . HTML_NBSP . olc_draw_input_field('manufacturers_url[' . $languages[$i]['id'] . ']', olc_get_manufacturer_url($mInfo->manufacturers_id, $languages[$i]['id']));
//      }

//      $contents[] = array('text' => HTML_BR . TEXT_MANUFACTURERS_URL . $manufacturer_inputs_string);
      $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_save.gif', IMAGE_SAVE) . BLANK.HTML_A_START . olc_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $mInfo->blacklist_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;
    case 'delete':
      $heading[] = array('text' => HTML_B_START . TEXT_HEADING_DELETE_BLACKLIST_CARD . HTML_B_END);

      $contents = array('form' => olc_draw_form('blacklisted', FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $bInfo->blacklist_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br/><b>' . $bInfo->blacklist_card_number . HTML_B_END);
//      $contents[] = array('text' => HTML_BR . olc_draw_checkbox_field('delete_image', '', true) . BLANK . TEXT_DELETE_IMAGE);

//      if ($mInfo->products_count > 0) {
//        $contents[] = array('text' => HTML_BR . olc_draw_checkbox_field('delete_products') . BLANK . TEXT_DELETE_PRODUCTS);
//        $contents[] = array('text' => HTML_BR . sprintf(TEXT_DELETE_WARNING_PRODUCTS, $mInfo->products_count));
//      }

      $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) . BLANK.HTML_A_START . olc_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $bInfo->blacklist_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;
    default:
      if (is_object($bInfo)) {
        $heading[] = array('text' => HTML_B_START . $bInfo->blacklist_card_number . HTML_B_END);

        $contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $bInfo->blacklist_id . '&action=edit') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $bInfo->blacklist_id . '&action=delete') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
        $contents[] = array('text' => HTML_BR . TEXT_DATE_ADDED . BLANK . olc_date_short($bInfo->date_added));
        if (olc_not_null($bInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . BLANK . olc_date_short($bInfo->last_modified));
//        $contents[] = array('text' => HTML_BR . olc_info_image($mInfo->manufacturers_image, $mInfo->manufacturers_name));
//        $contents[] = array('text' => HTML_BR . TEXT_PRODUCTS . BLANK . $mInfo->products_count);
      }
      break;
  }

  if ( (olc_not_null($heading)) && (olc_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . NEW_LINE;

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . NEW_LINE;
  }
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
