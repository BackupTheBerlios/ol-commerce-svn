<?php
/* --------------------------------------------------------------
   $Id: reviews.php,v 1.1.1.1.2.1 2007/04/08 07:16:31 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(reviews.php,v 1.40 2003/03/22); www.oscommerce.com 
   (c) 2003	    nextcommerce (reviews.php,v 1.9 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'update':
        $reviews_id = olc_db_prepare_input($_GET['rID']);
        $reviews_rating = olc_db_prepare_input($_POST['reviews_rating']);
        $last_modified = olc_db_prepare_input($_POST['last_modified']);
        $reviews_text = olc_db_prepare_input($_POST['reviews_text']);

        olc_db_query(SQL_UPDATE . TABLE_REVIEWS . " set reviews_rating = '" . olc_db_input($reviews_rating) . "', last_modified = now() where reviews_id = '" . olc_db_input($reviews_id) . APOS);
        olc_db_query(SQL_UPDATE . TABLE_REVIEWS_DESCRIPTION . " set reviews_text = '" . olc_db_input($reviews_text) . "' where reviews_id = '" . olc_db_input($reviews_id) . APOS);

        olc_redirect(olc_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $reviews_id));
        break;

      case 'deleteconfirm':
        $reviews_id = olc_db_prepare_input($_GET['rID']);

        olc_db_query(DELETE_FROM . TABLE_REVIEWS . " where reviews_id = '" . olc_db_input($reviews_id) . APOS);
        olc_db_query(DELETE_FROM . TABLE_REVIEWS_DESCRIPTION . " where reviews_id = '" . olc_db_input($reviews_id) . APOS);

        olc_redirect(olc_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page']));
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
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  if ($_GET['action'] == 'edit') {
    $rID = olc_db_prepare_input($_GET['rID']);

    $reviews_query = olc_db_query("select r.reviews_id, r.products_id, r.customers_name, r.date_added, r.last_modified, r.reviews_read, rd.reviews_text, r.reviews_rating from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.reviews_id = '" . olc_db_input($rID) . "' and r.reviews_id = rd.reviews_id");
    $reviews = olc_db_fetch_array($reviews_query);
    $products_query = olc_db_query("select products_image from " . TABLE_PRODUCTS . " where products_id = '" . $reviews['products_id'] . APOS);
    $products = olc_db_fetch_array($products_query);

    $products_name_query = olc_db_query("select products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $reviews['products_id'] . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
    $products_name = olc_db_fetch_array($products_name_query);

    $rInfo_array = olc_array_merge($reviews, $products, $products_name);
    $rInfo = new objectInfo($rInfo_array);
?>
      <tr><?php echo olc_draw_form('review', FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $_GET['rID'] . '&action=preview'); ?>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_PRODUCT; ?></b> <?php echo $rInfo->products_name; ?><br/><b><?php echo ENTRY_FROM; ?></b> <?php echo $rInfo->customers_name; ?><br/><br/><b><?php echo ENTRY_DATE; ?></b> <?php echo olc_date_short($rInfo->date_added); ?></td>
            <td class="main" align="right" valign="top"><?php echo olc_image(DIR_WS_CATALOG_IMAGES . $rInfo->products_image, $rInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_REVIEW; ?></b><br/><br/><?php echo olc_draw_textarea_field('reviews_text', 'soft', '60', '15', $rInfo->reviews_text); ?></td>
          </tr>
          <tr>
            <td class="smallText" align="right"><?php echo ENTRY_REVIEW_TEXT; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo ENTRY_RATING; ?></b>&nbsp;<?php echo TEXT_BAD; ?>&nbsp;<?php for ($i=1; $i<=5; $i++) echo olc_draw_radio_field('reviews_rating', $i, '', $rInfo->reviews_rating) . HTML_NBSP; echo TEXT_GOOD; ?></td>
      </tr>
      <tr>
        <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo olc_draw_hidden_field('reviews_id', $rInfo->reviews_id) . olc_draw_hidden_field('products_id', $rInfo->products_id) . olc_draw_hidden_field('customers_name', $rInfo->customers_name) . olc_draw_hidden_field('products_name', $rInfo->products_name) . olc_draw_hidden_field('products_image', $rInfo->products_image) . olc_draw_hidden_field('date_added', $rInfo->date_added) . olc_image_submit('button_preview.gif', IMAGE_PREVIEW) . BLANK.HTML_A_START . olc_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $_GET['rID']) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END; ?></td>
      </form></tr>
<?php
  } elseif ($_GET['action'] == 'preview') {
    if ($_POST) {
      $rInfo = new objectInfo($_POST);
    } else {
      $reviews_query = olc_db_query("select r.reviews_id, r.products_id, r.customers_name, r.date_added, r.last_modified, r.reviews_read, rd.reviews_text, r.reviews_rating from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.reviews_id = '" . $_GET['rID'] . "' and r.reviews_id = rd.reviews_id");
      $reviews = olc_db_fetch_array($reviews_query);
      $products_query = olc_db_query("select products_image from " . TABLE_PRODUCTS . " where products_id = '" . $reviews['products_id'] . APOS);
      $products = olc_db_fetch_array($products_query);

      $products_name_query = olc_db_query("select products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $reviews['products_id'] . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
      $products_name = olc_db_fetch_array($products_name_query);

      $rInfo_array = olc_array_merge($reviews, $products, $products_name);
      $rInfo = new objectInfo($rInfo_array);
    }
?>
      <tr><?php echo olc_draw_form('update', FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $_GET['rID'] . '&action=update', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_PRODUCT; ?></b> <?php echo $rInfo->products_name; ?><br/><b><?php echo ENTRY_FROM; ?></b> <?php echo $rInfo->customers_name; ?><br/><br/><b><?php echo ENTRY_DATE; ?></b> <?php echo olc_date_short($rInfo->date_added); ?></td>
            <td class="main" align="right" valign="top"><?php echo olc_image(DIR_WS_CATALOG_IMAGES . $rInfo->products_image, $rInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"'); ?></td>
          </tr>
        </table>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" class="main"><b><?php echo ENTRY_REVIEW; ?></b><br/><br/><?php echo nl2br(olc_db_output(olc_break_string($rInfo->reviews_text, 15))); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo ENTRY_RATING; ?></b>&nbsp;<?php echo olc_image(DIR_WS_CATALOG_IMAGES . 'stars_' . $rInfo->reviews_rating . '.gif', sprintf(TEXT_OF_5_STARS, $rInfo->reviews_rating)); ?>&nbsp;<small>[<?php echo sprintf(TEXT_OF_5_STARS, $rInfo->reviews_rating); ?>]</small></td>
      </tr>
      <tr>
        <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
    if ($_POST) {
      // Re-Post all POST'ed variables
      reset($_POST);
      while(list($key, $value) = each($_POST)) echo '<input type="hidden" name="' . $key . '" value="' . htmlspecialchars(stripslashes($value)) . '">';
?>
      <tr>
        <td align="right" class="smallText"><?php echo HTML_A_START . olc_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=edit') . '">' . olc_image_button('button_back.gif', IMAGE_BACK) . '</a> ' . olc_image_submit('button_update.gif', IMAGE_UPDATE) . BLANK.HTML_A_START . olc_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END; ?></td>
      </form></tr>
<?php
    } else {
      if ($_GET['origin']) {
        $back_url = $_GET['origin'];
        $back_url_params = '';
      } else {
        $back_url = FILENAME_REVIEWS;
        $back_url_params = 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id;
      }
?>
      <tr>
        <td align="right"><?php echo HTML_A_START . olc_href_link($back_url, $back_url_params, NONSSL) . '">' . olc_image_button('button_back.gif', IMAGE_BACK) . HTML_A_END; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_RATING; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_DATE_ADDED; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $reviews_query_raw = "select reviews_id, products_id, date_added, last_modified, reviews_rating from " . TABLE_REVIEWS . " order by date_added DESC";
    $reviews_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $reviews_query_raw, $reviews_query_numrows);
    $reviews_query = olc_db_query($reviews_query_raw);
    while ($reviews = olc_db_fetch_array($reviews_query)) {
      if ( ((!$_GET['rID']) || ($_GET['rID'] == $reviews['reviews_id'])) && (!$rInfo) ) {
        $reviews_text_query = olc_db_query("select r.reviews_read, r.customers_name, length(rd.reviews_text) as reviews_text_size from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.reviews_id = '" . $reviews['reviews_id'] . "' and r.reviews_id = rd.reviews_id");
        $reviews_text = olc_db_fetch_array($reviews_text_query);

        $products_image_query = olc_db_query("select products_image from " . TABLE_PRODUCTS . " where products_id = '" . $reviews['products_id'] . APOS);
        $products_image = olc_db_fetch_array($products_image_query);

        $products_name_query = olc_db_query("select products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $reviews['products_id'] . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
        $products_name = olc_db_fetch_array($products_name_query);

        $reviews_average_query = olc_db_query("select (avg(reviews_rating) / 5 * 100) as average_rating from " . TABLE_REVIEWS . " where products_id = '" . $reviews['products_id'] . APOS);
        $reviews_average = olc_db_fetch_array($reviews_average_query);

        $review_info = olc_array_merge($reviews_text, $reviews_average, $products_name);
        $rInfo_array = olc_array_merge($reviews, $review_info, $products_image);
        $rInfo = new objectInfo($rInfo_array);
      }

      if ( (is_object($rInfo)) && ($reviews['reviews_id'] == $rInfo->reviews_id) ) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=preview') . '">' . NEW_LINE;
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $reviews['reviews_id']) . '">' . NEW_LINE;
      }
?>
                <td class="dataTableContent"><?php echo HTML_A_START . olc_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $reviews['reviews_id'] . '&action=preview') . '">' . olc_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . olc_get_products_name($reviews['products_id']); ?></td>
                <td class="dataTableContent" align="right"><?php echo olc_image(DIR_WS_CATALOG_IMAGES . 'stars_' . $reviews['reviews_rating'] . '.gif'); ?></td>
                <td class="dataTableContent" align="right"><?php echo olc_date_short($reviews['date_added']); ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($rInfo)) && ($reviews['reviews_id'] == $rInfo->reviews_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo HTML_A_START . olc_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $reviews['reviews_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $reviews_split->display_count($reviews_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></td>
                    <td class="smallText" align="right"><?php echo $reviews_split->display_links($reviews_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($_GET['action']) {
      case 'delete':
        $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_REVIEW . HTML_B_END);

        $contents = array('form' => olc_draw_form('reviews', FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=deleteconfirm'));
        $contents[] = array('text' => TEXT_INFO_DELETE_REVIEW_INTRO);
        $contents[] = array('text' => '<br/><b>' . $rInfo->products_name . HTML_B_END);
        $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) . BLANK.HTML_A_START . olc_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
        break;

      default:
      if (is_object($rInfo)) {
        $heading[] = array('text' => HTML_B_START . $rInfo->products_name . HTML_B_END);

        $contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=edit') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=delete') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
        $contents[] = array('text' => HTML_BR . TEXT_INFO_DATE_ADDED . BLANK . olc_date_short($rInfo->date_added));
        if (olc_not_null($rInfo->last_modified)) $contents[] = array('text' => TEXT_INFO_LAST_MODIFIED . BLANK . olc_date_short($rInfo->last_modified));
        $contents[] = array('text' => HTML_BR . olc_info_image($rInfo->products_image, $rInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT));
        $contents[] = array('text' => HTML_BR . TEXT_INFO_REVIEW_AUTHOR . BLANK . $rInfo->customers_name);
        $contents[] = array('text' => TEXT_INFO_REVIEW_RATING . BLANK . olc_image(DIR_WS_CATALOG_IMAGES . 'stars_' . $rInfo->reviews_rating . '.gif'));
        $contents[] = array('text' => TEXT_INFO_REVIEW_READ . BLANK . $rInfo->reviews_read);
        $contents[] = array('text' => HTML_BR . TEXT_INFO_REVIEW_SIZE . BLANK . $rInfo->reviews_text_size . ' bytes');
        $contents[] = array('text' => HTML_BR . TEXT_INFO_PRODUCTS_AVERAGE_RATING . BLANK . number_format($rInfo->average_rating, 2) . '%');
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
<?php
  }
?>
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
