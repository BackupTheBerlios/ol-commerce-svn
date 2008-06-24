<?php
/* --------------------------------------------------------------
   $Id: shipping_status.php,v 1.1.1.1.2.1 2007/04/08 07:16:31 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders_status.php,v 1.19 2003/02/06); www.oscommerce.com
   (c) 2003	    nextcommerce (orders_status.php,v 1.9 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  switch ($_GET['action']) {
    case 'insert':
    case 'save':
      $shipping_status_id = olc_db_prepare_input($_GET['oID']);

      $languages = olc_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $shipping_status_name_array = $_POST['shipping_status_name'];
        $language_id = $languages[$i]['id'];

        $sql_data_array = array('shipping_status_name' => olc_db_prepare_input($shipping_status_name_array[$language_id]));

        if ($_GET['action'] == 'insert') {
          if (!olc_not_null($shipping_status_id)) {
            $next_id_query = olc_db_query("select max(shipping_status_id) as shipping_status_id from " . TABLE_SHIPPING_STATUS . "");
            $next_id = olc_db_fetch_array($next_id_query);
            $shipping_status_id = $next_id['shipping_status_id'] + 1;
          }

          $insert_sql_data = array('shipping_status_id' => $shipping_status_id,
                                   'language_id' => $language_id);
          $sql_data_array = olc_array_merge($sql_data_array, $insert_sql_data);
          olc_db_perform(TABLE_SHIPPING_STATUS, $sql_data_array);
        } elseif ($_GET['action'] == 'save') {
          olc_db_perform(TABLE_SHIPPING_STATUS, $sql_data_array, 'update', "shipping_status_id = '" . olc_db_input($shipping_status_id) . "' and language_id = '" . $language_id . APOS);
        }
      }

      if ($shipping_status_image = new upload('shipping_status_image',DIR_WS_ICONS)) {
        olc_db_query(SQL_UPDATE . TABLE_SHIPPING_STATUS . " set shipping_status_image = '" . $shipping_status_image->filename . "' where shipping_status_id = '" . olc_db_input($shipping_status_id) . APOS);
      }

      if ($_POST['default'] == 'on') {
        olc_db_query(SQL_UPDATE . TABLE_CONFIGURATION . " set configuration_value = '" . olc_db_input($shipping_status_id) . "' where configuration_key = 'DEFAULT_SHIPPING_STATUS_ID'");
      }

      olc_redirect(olc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $shipping_status_id));
      break;

    case 'deleteconfirm':
      $oID = olc_db_prepare_input($_GET['oID']);

      $shipping_status_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'DEFAULT_SHIPPING_STATUS_ID'");
      $shipping_status = olc_db_fetch_array($shipping_status_query);
      if ($shipping_status['configuration_value'] == $oID) {
        olc_db_query(SQL_UPDATE . TABLE_CONFIGURATION . " set configuration_value = '' where configuration_key = 'DEFAULT_SHIPPING_STATUS_ID'");
      }

      olc_db_query(DELETE_FROM . TABLE_SHIPPING_STATUS . " where shipping_status_id = '" . olc_db_input($oID) . APOS);

      olc_redirect(olc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page']));
      break;

    case 'delete':
      $oID = olc_db_prepare_input($_GET['oID']);


      $remove_status = true;
      if ($oID == DEFAULT_SHIPPING_STATUS_ID) {
        $remove_status = false;
        $messageStack->add(ERROR_REMOVE_DEFAULT_SHIPPING_STATUS, 'error');
      } else {

      }
      break;
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
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
    <td width="80" rowspan="2"><?php echo olc_image(DIR_WS_ICONS.'heading_configuration.gif'); ?></td>
    <td class="pageHeading">
			<?php 
				define('AJAX_TITLE',BOX_SHIPPING_STATUS);
				echo AJAX_TITLE; 
			?>
    </td>
  </tr>
  <tr>
    <td class="main" valign="top">OLC Konfiguration</td>
  </tr>
</table></td>
      </tr>
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
              <td class="dataTableHeadingContent" width="1"><?php echo TABLE_HEADING_SHIPPING_STATUS; ?></td>
                <td class="dataTableHeadingContent" width="100%">&nbsp;</td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $shipping_status_query_raw = "select shipping_status_id, shipping_status_name,shipping_status_image from " . TABLE_SHIPPING_STATUS . " where language_id = '" . SESSION_LANGUAGE_ID . "' order by shipping_status_id";
  $shipping_status_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $shipping_status_query_raw, $shipping_status_query_numrows);
  $shipping_status_query = olc_db_query($shipping_status_query_raw);
  while ($shipping_status = olc_db_fetch_array($shipping_status_query)) {
    if (((!$_GET['oID']) || ($_GET['oID'] == $shipping_status['shipping_status_id'])) && (!$oInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $oInfo = new objectInfo($shipping_status);
    }

    if ( (is_object($oInfo)) && ($shipping_status['shipping_status_id'] == $oInfo->shipping_status_id) ) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id . '&action=edit') . '">' . NEW_LINE;
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $shipping_status['shipping_status_id']) . '">' . NEW_LINE;
    }

    if (DEFAULT_SHIPPING_STATUS_ID == $shipping_status['shipping_status_id']) {
        echo '<td class="dataTableContent" align="left">';
     if ($shipping_status['shipping_status_image'] != '') {
       echo olc_image(DIR_WS_ICONS . $shipping_status['shipping_status_image'] , IMAGE_ICON_INFO);
     }
     echo '</td>';
      echo '                <td class="dataTableContent"><b>' . $shipping_status['shipping_status_name'] . LPAREN . TEXT_DEFAULT . ')</b></td>' . NEW_LINE;
    } else {

      			echo '<td class="dataTableContent" align="left">';
                       if ($shipping_status['shipping_status_image'] != '') {
                           echo olc_image(DIR_WS_ICONS . $shipping_status['shipping_status_image'] , IMAGE_ICON_INFO);
                           }
                           echo '</td>';
      echo '                <td class="dataTableContent">' . $shipping_status['shipping_status_name'] . '</td>' . NEW_LINE;
    }
?>
                <td class="dataTableContent" align="right"><?php if ( (is_object($oInfo)) && ($shipping_status['shipping_status_id'] == $oInfo->shipping_status_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo HTML_A_START . olc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $shipping_status['shipping_status_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $shipping_status_split->display_count($shipping_status_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_SHIPPING_STATUS); ?></td>
                    <td class="smallText" align="right"><?php echo $shipping_status_split->display_links($shipping_status_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (substr($_GET['action'], 0, 3) != 'new') {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&action=new') . '">' . olc_image_button('button_insert.gif', IMAGE_INSERT) . HTML_A_END; ?></td>
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
      $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_NEW_SHIPPING_STATUS . HTML_B_END);

      $contents = array('form' => olc_draw_form('status', FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);

      $shipping_status_inputs_string = '';
      $languages = olc_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $shipping_status_inputs_string .= HTML_BR . olc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . HTML_NBSP . olc_draw_input_field('shipping_status_name[' . $languages[$i]['id'] . ']');
      }
      $contents[] = array('text' => HTML_BR . TEXT_INFO_SHIPPING_STATUS_IMAGE . HTML_BR . olc_draw_file_field('shipping_status_image'));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_SHIPPING_STATUS_NAME . $shipping_status_inputs_string);
      $contents[] = array('text' => HTML_BR . olc_draw_checkbox_field('default') . BLANK . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_insert.gif', IMAGE_INSERT) . BLANK.HTML_A_START . olc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page']) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;

    case 'edit':
      $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_EDIT_SHIPPING_STATUS . HTML_B_END);

      $contents = array('form' => olc_draw_form('status', FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id  . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);

      $shipping_status_inputs_string = '';
      $languages = olc_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $shipping_status_inputs_string .= HTML_BR . olc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . HTML_NBSP . olc_draw_input_field('shipping_status_name[' . $languages[$i]['id'] . ']', olc_get_shipping_status_name($oInfo->shipping_status_id, $languages[$i]['id']));
      }
      $contents[] = array('text' => HTML_BR . TEXT_INFO_SHIPPING_STATUS_IMAGE . HTML_BR . olc_draw_file_field('shipping_status_image',$oInfo->shipping_status_image));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_SHIPPING_STATUS_NAME . $shipping_status_inputs_string);
      if (DEFAULT_SHIPPING_STATUS_ID != $oInfo->shipping_status_id) $contents[] = array('text' => HTML_BR . olc_draw_checkbox_field('default') . BLANK . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_update.gif', IMAGE_UPDATE) . BLANK.HTML_A_START . olc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;

    case 'delete':
      $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_SHIPPING_STATUS . HTML_B_END);

      $contents = array('form' => olc_draw_form('status', FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id  . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br/><b>' . $oInfo->shipping_status_name . HTML_B_END);
      if ($remove_status) $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) . BLANK.HTML_A_START . olc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;

    default:
      if (is_object($oInfo)) {
        $heading[] = array('text' => HTML_B_START . $oInfo->shipping_status_name . HTML_B_END);

        $contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id . '&action=edit') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id . '&action=delete') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);

        $shipping_status_inputs_string = '';
        $languages = olc_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $shipping_status_inputs_string .= HTML_BR . olc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . HTML_NBSP . olc_get_shipping_status_name($oInfo->shipping_status_id, $languages[$i]['id']);
        }

        $contents[] = array('text' => $shipping_status_inputs_string);
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
