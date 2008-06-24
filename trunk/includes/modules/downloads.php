<?php
/* -----------------------------------------------------------------------------------------
   $Id: downloads.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(downloads.php,v 1.2 2003/02/12); www.oscommerce.com 
   (c) 2003	    nextcommerce (downloads.php,v 1.6 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
?>
<!-- downloads //-->
<?php
  if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {
    // Get last order id for checkout_success
    $orders_query = olc_db_query("select orders_id from " . TABLE_ORDERS . " where customers_id = '" . (int)$_SESSION['customer_id'] . "' order by orders_id desc limit 1");
    $orders = olc_db_fetch_array($orders_query);
    $last_order = $orders['orders_id'];
  } else {
    $last_order = $_GET['order_id'];
  }

  // Now get all downloadable products in that order
  $downloads_query = olc_db_query("select date_format(o.date_purchased, '%Y-%m-%d') as date_purchased_day, opd.download_maxdays, op.products_name, opd.orders_products_download_id, opd.orders_products_filename, opd.download_count, opd.download_maxdays from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " opd where o.customers_id = '" . (int)$_SESSION['customer_id'] . "' and o.orders_id = '" . $last_order . "' and o.orders_id = op.orders_id and op.orders_products_id = opd.orders_products_id and opd.orders_products_filename != ''");
  if (olc_db_num_rows($downloads_query) > 0) {
?>
      <tr>
        <td><?php echo olc_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo HEADING_DOWNLOAD; ?></b></td>
      </tr>
      <tr>
        <td><?php echo olc_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
<!-- list of products -->
<?php
    while ($downloads = olc_db_fetch_array($downloads_query)) {
// MySQL 3.22 does not have INTERVAL
      list($dt_year, $dt_month, $dt_day) = explode('-', $downloads['date_purchased_day']);
      $download_timestamp = mktime(23, 59, 59, $dt_month, $dt_day + $downloads['download_maxdays'], $dt_year);
      $download_expiry = date('Y-m-d H:i:s', $download_timestamp);
?>
          <tr class="infoBoxContents">
<!-- left box -->
<?php
      // The link will appear only if:
      // - Download remaining count is > 0, AND
      // - The file is present in the DOWNLOAD directory, AND EITHER
      // - No expiry date is enforced (maxdays == 0), OR
      // - The expiry date is not reached
      if ( ($downloads['download_count'] > 0) && (file_exists(DIR_FS_DOWNLOAD . $downloads['orders_products_filename'])) && ( ($downloads['download_maxdays'] == 0) || ($download_timestamp > time())) ) {
        echo '            <td class="main"><a href="' . olc_href_link(FILENAME_DOWNLOAD, 'order=' . $last_order . '&id=' . $downloads['orders_products_download_id']) . '">' . $downloads['products_name'] . '</a></td>' . NEW_LINE;
      } else {
        echo '            <td class="main">' . $downloads['products_name'] . '</td>' . NEW_LINE;
      }
?>
<!-- right box -->
<?php
      echo '            <td class="main">' . TABLE_HEADING_DOWNLOAD_DATE . olc_date_long($download_expiry) . '</td>' . NEW_LINE .
           '            <td class="main" align="right">' . $downloads['download_count'] . TABLE_HEADING_DOWNLOAD_COUNT . '</td>' . NEW_LINE .
           '          </tr>' . NEW_LINE;
    }
?>
          </tr>
        </table></td>
      </tr>
<?php
    if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {
?>
      <tr>
        <td><?php echo olc_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="smalltext" colspan="4"><p><?php printf(FOOTER_DOWNLOAD, HTML_A_START . olc_href_link(FILENAME_ACCOUNT, '', SSL) . '">' . HEADER_TITLE_MY_ACCOUNT . HTML_A_END); ?></p></td>
      </tr>
<?php
    }
  }
?>
<!-- downloads_eof //-->