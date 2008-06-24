<?php
/* --------------------------------------------------------------
   $Id: tax_classes.php,v 1.1.1.1.2.1 2007/04/08 07:16:32 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(tax_classes.php,v 1.19 2002/03/17); www.oscommerce.com 
   (c) 2003	    nextcommerce (tax_classes.php,v 1.9 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'insert':
        $tax_class_title = olc_db_prepare_input($_POST['tax_class_title']);
        $tax_class_description = olc_db_prepare_input($_POST['tax_class_description']);
        $date_added = olc_db_prepare_input($_POST['date_added']);

        olc_db_query(INSERT_INTO . TABLE_TAX_CLASS . " (tax_class_title, tax_class_description, date_added) values ('" . olc_db_input($tax_class_title) . "', '" . olc_db_input($tax_class_description) . "', now())");
        olc_redirect(olc_href_link(FILENAME_TAX_CLASSES));
        break;

      case 'save':
        $tax_class_id = olc_db_prepare_input($_GET['tID']);
        $tax_class_title = olc_db_prepare_input($_POST['tax_class_title']);
        $tax_class_description = olc_db_prepare_input($_POST['tax_class_description']);
        $last_modified = olc_db_prepare_input($_POST['last_modified']);

        olc_db_query(SQL_UPDATE . TABLE_TAX_CLASS . " set tax_class_id = '" . olc_db_input($tax_class_id) . "', tax_class_title = '" . olc_db_input($tax_class_title) . "', tax_class_description = '" . olc_db_input($tax_class_description) . "', last_modified = now() where tax_class_id = '" . olc_db_input($tax_class_id) . APOS);
        olc_redirect(olc_href_link(FILENAME_TAX_CLASSES, 'page=' . $_GET['page'] . '&tID=' . $tax_class_id));
        break;

      case 'deleteconfirm':
        $tax_class_id = olc_db_prepare_input($_GET['tID']);

        olc_db_query(DELETE_FROM . TABLE_TAX_CLASS . " where tax_class_id = '" . olc_db_input($tax_class_id) . APOS);
        olc_redirect(olc_href_link(FILENAME_TAX_CLASSES, 'page=' . $_GET['page']));
        break;
    }
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
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="80" rowspan="2"><?php echo olc_image(DIR_WS_ICONS.'heading_configuration.gif'); ?></td>
    <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
  </tr>
  <tr>
    <td class="main" valign="top">OLC Konfiguration</td>
  </tr>
</table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TAX_CLASSES; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $classes_query_raw = "select tax_class_id, tax_class_title, tax_class_description, last_modified, date_added from " . TABLE_TAX_CLASS . " order by tax_class_title";
  $classes_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $classes_query_raw, $classes_query_numrows);
  $classes_query = olc_db_query($classes_query_raw);
  while ($classes = olc_db_fetch_array($classes_query)) {
    if (((!$_GET['tID']) || (@$_GET['tID'] == $classes['tax_class_id'])) && (!$tcInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $tcInfo = new objectInfo($classes);
    }

    if ( (is_object($tcInfo)) && ($classes['tax_class_id'] == $tcInfo->tax_class_id) ) {
      echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link(FILENAME_TAX_CLASSES, 'page=' . $_GET['page'] . '&tID=' . $tcInfo->tax_class_id . '&action=edit') . '">' . NEW_LINE;
    } else {
      echo'              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_TAX_CLASSES, 'page=' . $_GET['page'] . '&tID=' . $classes['tax_class_id']) . '">' . NEW_LINE;
    }
?>
                <td class="dataTableContent"><?php echo $classes['tax_class_title']; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($tcInfo)) && ($classes['tax_class_id'] == $tcInfo->tax_class_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo HTML_A_START . olc_href_link(FILENAME_TAX_CLASSES, 'page=' . $_GET['page'] . '&tID=' . $classes['tax_class_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $classes_split->display_count($classes_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_TAX_CLASSES); ?></td>
                    <td class="smallText" align="right"><?php echo $classes_split->display_links($classes_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (!$_GET['action']) {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_TAX_CLASSES, 'page=' . $_GET['page'] . '&action=new') . '">' . olc_image_button('button_new_tax_class.gif', IMAGE_NEW_TAX_CLASS) . HTML_A_END; ?></td>
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
      $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_NEW_TAX_CLASS . HTML_B_END);

      $contents = array('form' => olc_draw_form('classes', FILENAME_TAX_CLASSES, 'page=' . $_GET['page'] . '&action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CLASS_TITLE . HTML_BR . olc_draw_input_field('tax_class_title'));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CLASS_DESCRIPTION . HTML_BR . olc_draw_input_field('tax_class_description'));
      $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_insert.gif', IMAGE_INSERT) . '&nbsp;<a href="' . olc_href_link(FILENAME_TAX_CLASSES, 'page=' . $_GET['page']) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;

    case 'edit':
      $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_EDIT_TAX_CLASS . HTML_B_END);

      $contents = array('form' => olc_draw_form('classes', FILENAME_TAX_CLASSES, 'page=' . $_GET['page'] . '&tID=' . $tcInfo->tax_class_id . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CLASS_TITLE . HTML_BR . olc_draw_input_field('tax_class_title', $tcInfo->tax_class_title));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CLASS_DESCRIPTION . HTML_BR . olc_draw_input_field('tax_class_description', $tcInfo->tax_class_description));
      $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_update.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . olc_href_link(FILENAME_TAX_CLASSES, 'page=' . $_GET['page'] . '&tID=' . $tcInfo->tax_class_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;

    case 'delete':
      $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_TAX_CLASS . HTML_B_END);

      $contents = array('form' => olc_draw_form('classes', FILENAME_TAX_CLASSES, 'page=' . $_GET['page'] . '&tID=' . $tcInfo->tax_class_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br/><b>' . $tcInfo->tax_class_title . HTML_B_END);
      $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) . '&nbsp;<a href="' . olc_href_link(FILENAME_TAX_CLASSES, 'page=' . $_GET['page'] . '&tID=' . $tcInfo->tax_class_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;

    default:
      if (is_object($tcInfo)) {
        $heading[] = array('text' => HTML_B_START . $tcInfo->tax_class_title . HTML_B_END);

        $contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_TAX_CLASSES, 'page=' . $_GET['page'] . '&tID=' . $tcInfo->tax_class_id . '&action=edit') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_TAX_CLASSES, 'page=' . $_GET['page'] . '&tID=' . $tcInfo->tax_class_id . '&action=delete') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
        $contents[] = array('text' => HTML_BR . TEXT_INFO_DATE_ADDED . BLANK . olc_date_short($tcInfo->date_added));
        $contents[] = array('text' => '' . TEXT_INFO_LAST_MODIFIED . BLANK . olc_date_short($tcInfo->last_modified));
        $contents[] = array('text' => HTML_BR . TEXT_INFO_CLASS_DESCRIPTION . HTML_BR . $tcInfo->tax_class_description);
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
