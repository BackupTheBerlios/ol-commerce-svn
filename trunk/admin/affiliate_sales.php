<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_sales.php,v 1.1.1.1.2.1 2007/04/08 07:16:24 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_sales.php, v 1.6 2003/02/19);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   Copyright (c) 2003 netz-designer
   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

  require('includes/application_top.php');
  
  // include used functions
  require_once(DIR_FS_INC.'olc_add_tax.inc.php');

  require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  if ($_GET['acID'] > 0) {

    $affiliate_sales_raw = "
      select asale.*, os.orders_status_name as orders_status, a.affiliate_firstname, a.affiliate_lastname from " . TABLE_AFFILIATE_SALES . " asale 
      left join " . TABLE_ORDERS . " o on (asale.affiliate_orders_id = o.orders_id) 
      left join " . TABLE_ORDERS_STATUS . " os on (o.orders_status = os.orders_status_id and language_id = " . SESSION_LANGUAGE_ID . ")
      left join " . TABLE_AFFILIATE . " a on (a.affiliate_id = asale.affiliate_id) 
      where asale.affiliate_id = '" . $_GET['acID'] . "'
      order by affiliate_date desc 
      ";
    $affiliate_sales_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $affiliate_sales_raw, $affiliate_sales_numrows);

  } else {

    $affiliate_sales_raw = "
      select asale.*, os.orders_status_name as orders_status, a.affiliate_firstname, a.affiliate_lastname from " . TABLE_AFFILIATE_SALES . " asale 
      left join " . TABLE_ORDERS . " o on (asale.affiliate_orders_id = o.orders_id) 
      left join " . TABLE_ORDERS_STATUS . " os on (o.orders_status = os.orders_status_id and language_id = " . SESSION_LANGUAGE_ID . ")
      left join " . TABLE_AFFILIATE . " a  on (a.affiliate_id = asale.affiliate_id) 
      order by affiliate_date desc 
      ";
    $affiliate_sales_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $affiliate_sales_raw, $affiliate_sales_numrows);
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
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
<?php 
  if ($_GET['acID'] > 0) {
?>
            <td class="pageHeading" align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE_STATISTICS, olc_get_all_get_params(array('action'))) . '">' . olc_image_button('button_back.gif', IMAGE_BACK) . HTML_A_END; ?></td>
<?php
  } else {
?>
            <td class="pageHeading" align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE_SUMMARY, '') . '">' . olc_image_button('button_back.gif', IMAGE_BACK) . HTML_A_END; ?></td>
<?php
  }
?>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="4">
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_AFFILIATE; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_DATE; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDER_ID; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_VALUE; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PERCENTAGE; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_SALES; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
          </tr>
<?php
  if ($affiliate_sales_numrows > 0) {
    $affiliate_sales_values = olc_db_query($affiliate_sales_raw);
    $number_of_sales = '0';
    while ($affiliate_sales = olc_db_fetch_array($affiliate_sales_values)) {
      $number_of_sales++;
      if (($number_of_sales / 2) == floor($number_of_sales / 2)) {
        echo '          <tr class="dataTableRowSelected">';
      } else {
        echo '          <tr class="dataTableRow">';
      }

      $link_to = '<a href="orders.php?action=edit&oID=' . $affiliate_sales['affiliate_orders_id'] . '">' . $affiliate_sales['affiliate_orders_id'] . HTML_A_END;
?>
            <td class="dataTableContent"><?php echo $affiliate_sales['affiliate_firstname'] . BLANK. $affiliate_sales['affiliate_lastname']; ?></td>
            <td class="dataTableContent" align="center"><?php echo olc_date_short($affiliate_sales['affiliate_date']); ?></td>
            <td class="dataTableContent" align="right"><?php echo $link_to; ?></td>
            <td class="dataTableContent" align="right">&nbsp;&nbsp;<?php echo $currencies->display_price($affiliate_sales['affiliate_value'], ''); ?></td>
            <td class="dataTableContent" align="right"><?php echo $affiliate_sales['affiliate_percent'] . "%" ; ?></td>
            <td class="dataTableContent" align="right">&nbsp;&nbsp;<?php echo $currencies->display_price($affiliate_sales['affiliate_payment'], ''); ?></td>
            <td class="dataTableContent" align="center"><?php if ($affiliate_sales['orders_status']) echo $affiliate_sales['orders_status']; else echo TEXT_DELETED_ORDER_BY_ADMIN; ?></td>
<?php
    }
  } else {
?>
          <tr class="dataTableRowSelected">
            <td colspan="7" class="smallText"><?php echo TEXT_NO_SALES; ?></td>
          </tr>
<?php
  }
  if ($affiliate_sales_numrows > 0 && (PREV_NEXT_BAR_LOCATION == '2' || PREV_NEXT_BAR_LOCATION == '3')) {
?>
          <tr>
            <td colspan="7"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText" valign="top"><?php echo $affiliate_sales_split->display_count($affiliate_sales_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_SALES); ?></td>
                <td class="smallText" align="right"><?php echo $affiliate_sales_split->display_links($affiliate_sales_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], olc_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
              </tr>
            </table></td>
          </tr>
<?php
  }
?>
        </table></td>
      </tr>
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
