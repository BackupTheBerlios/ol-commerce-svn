<?php
/* --------------------------------------------------------------
   $Id: currencies.php,v 1.1.1.1.2.1 2007/04/08 07:16:27 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(currencies.php,v 1.46 2003/05/02); www.oscommerce.com 
   (c) 2003	    nextcommerce (currencies.php,v 1.9 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'insert':
      case 'save':
        $currency_id = olc_db_prepare_input($_GET['cID']);
        $title = olc_db_prepare_input($_POST['title']);
        $code = olc_db_prepare_input($_POST['code']);
        $symbol_left = olc_db_prepare_input($_POST['symbol_left']);
        $symbol_right = olc_db_prepare_input($_POST['symbol_right']);
        $decimal_point = olc_db_prepare_input($_POST['decimal_point']);
        $thousands_point = olc_db_prepare_input($_POST['thousands_point']);
        $decimal_places = olc_db_prepare_input($_POST['decimal_places']);
        $value = olc_db_prepare_input($_POST['value']);

        $sql_data_array = array('title' => $title,
                                'code' => $code,
                                'symbol_left' => $symbol_left,
                                'symbol_right' => $symbol_right,
                                'decimal_point' => $decimal_point,
                                'thousands_point' => $thousands_point,
                                'decimal_places' => $decimal_places,
                                'value' => $value);

        if ($_GET['action'] == 'insert') {
          olc_db_perform(TABLE_CURRENCIES, $sql_data_array);
          $currency_id = olc_db_insert_id();
        } elseif ($_GET['action'] == 'save') {
          olc_db_perform(TABLE_CURRENCIES, $sql_data_array, 'update', "currencies_id = '" . olc_db_input($currency_id) . APOS);
        }

        if ($_POST['default'] == 'on') {
          olc_db_query(SQL_UPDATE . TABLE_CONFIGURATION . " set configuration_value = '" . olc_db_input($code) . "' where configuration_key = 'DEFAULT_CURRENCY'");
        }
        olc_redirect(olc_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $currency_id));
        break;

      case 'deleteconfirm':
        $currencies_id = olc_db_prepare_input($_GET['cID']);

        $currency_query = olc_db_query("select currencies_id from " . TABLE_CURRENCIES . " where code = '" . DEFAULT_CURRENCY . APOS);
        $currency = olc_db_fetch_array($currency_query);
        if ($currency['currencies_id'] == $currencies_id) {
          olc_db_query(SQL_UPDATE . TABLE_CONFIGURATION . " set configuration_value = '' where configuration_key = 'DEFAULT_CURRENCY'");
        }

        olc_db_query(DELETE_FROM . TABLE_CURRENCIES . " where currencies_id = '" . olc_db_input($currencies_id) . APOS);

        olc_redirect(olc_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page']));
        break;

      case 'update':
        $currency_query = olc_db_query("select currencies_id, code, title from " . TABLE_CURRENCIES);
        while ($currency = olc_db_fetch_array($currency_query)) {
          $quote_function = 'quote_' . CURRENCY_SERVER_PRIMARY . '_currency';
          $rate = $quote_function($currency['code']);
          if ( (!$rate) && (CURRENCY_SERVER_BACKUP != '') ) {
            $quote_function = 'quote_' . CURRENCY_SERVER_BACKUP . '_currency';
            $rate = $quote_function($currency['code']);
          }
          if ($rate) {
            olc_db_query(SQL_UPDATE . TABLE_CURRENCIES . " set value = '" . $rate . "', last_updated = now() where currencies_id = '" . $currency['currencies_id'] . APOS);
            $messageStack->add_session(sprintf(TEXT_INFO_CURRENCY_UPDATED, $currency['title'], $currency['code']), 'success');
          } else {
            $messageStack->add_session(sprintf(ERROR_CURRENCY_INVALID, $currency['title'], $currency['code']), 'error');
          }
        }
        olc_redirect(olc_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $_GET['cID']));
        break;

      case 'delete':
        $currencies_id = olc_db_prepare_input($_GET['cID']);

        $currency_query = olc_db_query("select code from " . TABLE_CURRENCIES . " where currencies_id = '" . olc_db_input($currencies_id) . APOS);
        $currency = olc_db_fetch_array($currency_query);

        $remove_currency = true;
        if ($currency['code'] == DEFAULT_CURRENCY) {
          $remove_currency = false;
          $messageStack->add(ERROR_REMOVE_DEFAULT_CURRENCY, 'error');
        }
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CURRENCY_NAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CURRENCY_CODES; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_CURRENCY_VALUE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $currency_query_raw = "select currencies_id, title, code, symbol_left, symbol_right, decimal_point, thousands_point, decimal_places, last_updated, value from " . TABLE_CURRENCIES . " order by title";
  $currency_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $currency_query_raw, $currency_query_numrows);
  $currency_query = olc_db_query($currency_query_raw);
  while ($currency = olc_db_fetch_array($currency_query)) {
    if (((!$_GET['cID']) || (@$_GET['cID'] == $currency['currencies_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $cInfo = new objectInfo($currency);
    }

    if ( (is_object($cInfo)) && ($currency['currencies_id'] == $cInfo->currencies_id) ) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=edit') . '">' . NEW_LINE;
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $currency['currencies_id']) . '">' . NEW_LINE;
    }

    if (DEFAULT_CURRENCY == $currency['code']) {
      echo '                <td class="dataTableContent"><b>' . $currency['title'] . LPAREN . TEXT_DEFAULT . ')</b></td>' . NEW_LINE;
    } else {
      echo '                <td class="dataTableContent">' . $currency['title'] . '</td>' . NEW_LINE;
    }
?>
                <td class="dataTableContent"><?php echo $currency['code']; ?></td>
                <td class="dataTableContent" align="right"><?php echo number_format($currency['value'], 8); ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($cInfo)) && ($currency['currencies_id'] == $cInfo->currencies_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo HTML_A_START . olc_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $currency['currencies_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $currency_split->display_count($currency_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CURRENCIES); ?></td>
                    <td class="smallText" align="right"><?php echo $currency_split->display_links($currency_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (!$_GET['action']) {
?>
                  <tr>
                    <td><?php if (CURRENCY_SERVER_PRIMARY) { echo HTML_A_START . olc_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=update') . '">' . olc_image_button('button_update_currencies.gif', IMAGE_UPDATE_CURRENCIES) . HTML_A_END; } ?></td>
                    <td align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=new') . '">' . olc_image_button('button_new_currency.gif', IMAGE_NEW_CURRENCY) . HTML_A_END; ?></td>
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
      $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_NEW_CURRENCY . HTML_B_END);

      $contents = array('form' => olc_draw_form('currencies', FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_TITLE . HTML_BR . olc_draw_input_field('title'));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_CODE . HTML_BR . olc_draw_input_field('code'));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_SYMBOL_LEFT . HTML_BR . olc_draw_input_field('symbol_left'));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_SYMBOL_RIGHT . HTML_BR . olc_draw_input_field('symbol_right'));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_DECIMAL_POINT . HTML_BR . olc_draw_input_field('decimal_point'));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_THOUSANDS_POINT . HTML_BR . olc_draw_input_field('thousands_point'));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_DECIMAL_PLACES . HTML_BR . olc_draw_input_field('decimal_places'));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_VALUE . HTML_BR . olc_draw_input_field('value'));
      $contents[] = array('text' => HTML_BR . olc_draw_checkbox_field('default') . BLANK . TEXT_INFO_SET_AS_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_insert.gif', IMAGE_INSERT) . BLANK.HTML_A_START . olc_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $_GET['cID']) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;

    case 'edit':
      $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_EDIT_CURRENCY . HTML_B_END);

      $contents = array('form' => olc_draw_form('currencies', FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_TITLE . HTML_BR . olc_draw_input_field('title', $cInfo->title));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_CODE . HTML_BR . olc_draw_input_field('code', $cInfo->code));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_SYMBOL_LEFT . HTML_BR . olc_draw_input_field('symbol_left', $cInfo->symbol_left));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_SYMBOL_RIGHT . HTML_BR . olc_draw_input_field('symbol_right', $cInfo->symbol_right));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_DECIMAL_POINT . HTML_BR . olc_draw_input_field('decimal_point', $cInfo->decimal_point));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_THOUSANDS_POINT . HTML_BR . olc_draw_input_field('thousands_point', $cInfo->thousands_point));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_DECIMAL_PLACES . HTML_BR . olc_draw_input_field('decimal_places', $cInfo->decimal_places));
      $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_VALUE . HTML_BR . olc_draw_input_field('value', $cInfo->value));
      if (DEFAULT_CURRENCY != $cInfo->code) $contents[] = array('text' => HTML_BR . olc_draw_checkbox_field('default') . BLANK . TEXT_INFO_SET_AS_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_update.gif', IMAGE_UPDATE) . BLANK.HTML_A_START . olc_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;

    case 'delete':
      $heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_CURRENCY . HTML_B_END);

      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br/><b>' . $cInfo->title . HTML_B_END);
      $contents[] = array('align' => 'center', 'text' => HTML_BR . (($remove_currency) ? HTML_A_START . olc_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=deleteconfirm') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END : '') . BLANK.HTML_A_START . olc_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
      break;

    default:
      if (is_object($cInfo)) {
        $heading[] = array('text' => HTML_B_START . $cInfo->title . HTML_B_END);

        $contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=edit') . '">' . olc_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . olc_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=delete') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
        $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_TITLE . BLANK . $cInfo->title);
        $contents[] = array('text' => TEXT_INFO_CURRENCY_CODE . BLANK . $cInfo->code);
        $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_SYMBOL_LEFT . BLANK . $cInfo->symbol_left);
        $contents[] = array('text' => TEXT_INFO_CURRENCY_SYMBOL_RIGHT . BLANK . $cInfo->symbol_right);
        $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_DECIMAL_POINT . BLANK . $cInfo->decimal_point);
        $contents[] = array('text' => TEXT_INFO_CURRENCY_THOUSANDS_POINT . BLANK . $cInfo->thousands_point);
        $contents[] = array('text' => TEXT_INFO_CURRENCY_DECIMAL_PLACES . BLANK . $cInfo->decimal_places);
        $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_LAST_UPDATED . BLANK . olc_date_short($cInfo->last_updated));
        $contents[] = array('text' => TEXT_INFO_CURRENCY_VALUE . BLANK . number_format($cInfo->value, 8));
        $contents[] = array('text' => HTML_BR . TEXT_INFO_CURRENCY_EXAMPLE . HTML_BR . $currencies->format('30', false, DEFAULT_CURRENCY) . ' = ' . $currencies->format('30', true, $cInfo->code));
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
