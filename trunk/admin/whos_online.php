<?php
/* --------------------------------------------------------------
$Id: whos_online.php,v 1.1.1.1.2.1 2007/04/08 07:16:33 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(whos_online.php,v 1.30 2002/11/22); www.oscommerce.com
(c) 2003	    nextcommerce (whos_online.php,v 1.9 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');

require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

//Do garbage collection in session db
_sess_gc(EMPTY_STRING);
//Delete all from "whos_online" without a session entry
//olc_db_query(DELETE_FROM . TABLE_WHOS_ONLINE. ' WHERE session_id NOT IN (SELECT sesskey FROM '.TABLE_SESSIONS.RPAREN);
$sesskey=TABLE_SESSIONS.'.sesskey';
olc_db_query('DELETE '. TABLE_WHOS_ONLINE. '  FROM '.TABLE_WHOS_ONLINE.COMMA_BLANK.TABLE_SESSIONS.
' WHERE '.TABLE_WHOS_ONLINE.'.session_id = '.$sesskey.' AND '.$sesskey.' IS NULL');
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
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ONLINE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_CUSTOMER_ID; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FULL_NAME; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_IP_ADDRESS; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ENTRY_TIME; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_LAST_CLICK; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LAST_PAGE_URL; ?>&nbsp;</td>
              </tr>
<?php
$whos_online_query = olc_db_query("select customer_id, full_name, ip_address, time_entry, time_last_click, last_page_url, session_id from " . TABLE_WHOS_ONLINE);
while ($whos_online = olc_db_fetch_array($whos_online_query)) {
	$time_online = (time() - $whos_online['time_entry']);
	if ( ((!$_GET['info']) || (@$_GET['info'] == $whos_online['session_id'])) && (!$info) ) {
		$info = $whos_online['session_id'];
	}
	if ($whos_online['session_id'] == $info) {
		echo '              <tr class="dataTableRowSelected">' . NEW_LINE;
	} else {
		echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_WHOS_ONLINE, olc_get_all_get_params(array('info', 'action')) . 'info=' . $whos_online['session_id'], NONSSL) . '">' . NEW_LINE;
	}
?>
                <td class="dataTableContent"><?php echo gmdate('H:i:s', $time_online); ?></td>
                <td class="dataTableContent" align="center"><?php echo $whos_online['customer_id']; ?></td>
                <td class="dataTableContent"><?php echo $whos_online['full_name']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $whos_online['ip_address']; ?></td>
                <td class="dataTableContent"><?php echo date('H:i:s', $whos_online['time_entry']); ?></td>
                <td class="dataTableContent" align="center"><?php echo date('H:i:s', $whos_online['time_last_click']); ?></td>
                <td class="dataTableContent"><?php if (eregi('^(.*)' . olc_session_name() . '=[a-f,0-9]+[&]*(.*)', $whos_online['last_page_url'], $array)) { echo $array[1] . $array[2]; } else { echo $whos_online['last_page_url']; } ?>&nbsp;</td>
              </tr>
<?php
}
?>
              <tr>
                <td class="smallText" colspan="7"><?php echo sprintf(TEXT_NUMBER_OF_CUSTOMERS, olc_db_num_rows($whos_online_query)); ?></td>
              </tr>
            </table></td>
<?php
$heading = array();
$contents = array();
if ($info) {
	$heading[] = array('text' => HTML_B_START . TABLE_HEADING_SHOPPING_CART . HTML_B_END);

	if (STORE_SESSIONS == 'mysql') {
		$session_data = olc_db_query("select value from " . TABLE_SESSIONS . " WHERE sesskey = '" . $info . APOS);
		$session_data = olc_db_fetch_array($session_data);
		$session_data = trim($session_data['value']);
	} else {
		if ( (file_exists(olc_session_save_path() . '/sess_' . $info)) && (filesize(olc_session_save_path() . '/sess_' . $info) > 0) ) {
			$session_data = file(olc_session_save_path() . '/sess_' . $info);
			$session_data = trim(implode('', $session_data));
		}
	}

	if ($length = strlen($session_data)) {
		$start_id = strpos($session_data, 'customer_id|s');
		$start_cart = strpos($session_data, 'cart|O');
		$start_currency = strpos($session_data, 'currency|s');
		$start_country = strpos($session_data, 'customer_country_id|s');
		$start_zone = strpos($session_data, 'customer_zone_id|s');

		for ($i=$start_cart; $i<$length; $i++) {
			if ($session_data[$i] == '{') {
				if (isset($tag)) {
					$tag++;
				} else {
					$tag = 1;
				}
			} elseif ($session_data[$i] == '}') {
				$tag--;
			} elseif ( (isset($tag)) && ($tag < 1) ) {
				break;
			}
		}

		$session_data_id = substr($session_data, $start_id, (strpos($session_data, ';', $start_id) - $start_id + 1));
		$session_data_cart = substr($session_data, $start_cart, $i-$start_cart);
		$session_data_currency = substr($session_data, $start_currency, (strpos($session_data, ';', $start_currency) - $start_currency + 1));
		$session_data_country = substr($session_data, $start_country, (strpos($session_data, ';', $start_country) - $start_country + 1));
		$session_data_zone = substr($session_data, $start_zone, (strpos($session_data, ';', $start_zone) - $start_zone + 1));

		session_decode($session_data_id);
		session_decode($session_data_currency);
		session_decode($session_data_country);
		session_decode($session_data_zone);
		session_decode($session_data_cart);

		if (is_object($cart)) {
			$products = $cart->get_products();
			for ($i = 0, $n = sizeof($products); $i < $n; $i++) {
				$contents[] = array('text' => $products[$i]['quantity'] . ' x ' . $products[$i]['name']);
			}

			if (sizeof($products) > 0) {
				$contents[] = array('text' => olc_draw_separator('pixel_black.gif', '100%', '1'));
				$contents[] = array('align' => 'right', 'text'  => TEXT_SHOPPING_CART_SUBTOTAL . BLANK . $currencies->format($cart->show_total(), true, $currency));
			} else {
				$contents[] = array('text' => HTML_NBSP);
			}
		}
	}
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
