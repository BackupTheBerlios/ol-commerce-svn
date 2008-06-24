<?php
/*
$Id: PayPal.inc.php,v 1.1.1.1.2.1 2007/04/08 07:18:07 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2002 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/

include_once(PAYPAL_IPN_DIR.'Classes/TransactionDetails/TransactionDetails.class.php');
include_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

	$payment_statuses = array(
	array('id' =>'On Hold',            'text' => PAYPAL_IPN_STATUS_ON_HOLD),
	array('id' =>'Refunded',           'text' => PAYPAL_IPN_STATUS_REFUNDED),
	array('id' =>'Canceled',          'text' => PAYPAL_IPN_STATUS_CANCELED),
	array('id' =>'Completed',          'text' => PAYPAL_IPN_STATUS_COMPLETED),
	array('id' =>'Pending',            'text' => PAYPAL_IPN_STATUS_PENDING),
	array('id' =>'Failed',             'text' => PAYPAL_IPN_STATUS_FAILED),
	array('id' =>'Denied',             'text' => PAYPAL_IPN_STATUS_DENIED),
	array('id' =>'Reversed',           'text' => PAYPAL_IPN_STATUS_REVERSED),
	array('id' =>'Canceled Reversal',  'text' => PAYPAL_IPN_STATUS_CANCELED_REVERSAL)
	);
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_ADMIN_TITLE; ?></td>
            <td class="pageHeading" align="right">
            	<?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?>
            </td>
            <td class="smallText" align="right">
            	<?php echo olc_draw_form('payment_status', FILENAME_PAYPAL, '', 'get') . HEADING_PAYMENT_STATUS .
            		BLANK . olc_draw_pull_down_menu('payment_status',
            		array_merge(array(array('id' => 'ALL', 'text' => TEXT_ALL_IPNS)),
            		$payment_statuses), $_GET['payment_status'], 'onchange="this.form.submit();"').'</form>'; ?>
            	</td>
            <td class="pageHeading" align="right">
            	<?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_DATE; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PAYMENT_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PAYMENT_GROSS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PAYMENT_FEE; ?></td>
                <td class="dataTableHeadingContent" align="right">
                	<?php echo TABLE_HEADING_PAYMENT_NET_AMOUNT; ?>
                </td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
$common_vars = "p.txn_id, p.parent_txn_id, p.paypal_id, p.txn_type, p.payment_type, p.payment_status, p.pending_reason, p.mc_currency, p.mc_fee, p.payer_status, p.mc_currency, p.date_added, p.mc_gross, p.payment_date";
$ipn_query_raw="select " . $common_vars . " from " . TABLE_PAYPAL . " as p ";
$order_by=" order by p.paypal_id DESC";
$payment_status=$_GET['payment_status'];

if($payment_status != 'ALL')
{
	$ipn_search = " p.payment_status = '" . olc_db_prepare_input($payment_status) . APOS;
	switch($payment_status)
	{
		case PAYPAL_IPN_STATUS_PENDING:
		case PAYPAL_IPN_STATUS_COMPLETED:
		default:
			$ipn_query_raw = $ipn_query_raw." where " . $ipn_search . $order_by;
			break;
	}
}
else
{
	$ipn_query_raw = $ipn_query_raw.$order_by;
}
$page=$_GET['page'];
$ipn_split = new splitPageResults($page, MAX_DISPLAY_SEARCH_RESULTS, $ipn_query_raw, $ipn_query_numrows);
$ipn_query = olc_db_query($ipn_query_raw);
while ($ipn_trans = olc_db_fetch_array($ipn_query)) {
	if ((!isset($_GET['ipnID']) || (isset($_GET['ipnID']) &&
		($_GET['ipnID'] == $ipn_trans['paypal_id']))) && !isset($ipnInfo) )
	{
		$ipnInfo = new objectInfo($ipn_trans);
	}

	if (isset($ipnInfo) && is_object($ipnInfo) && ($ipn_trans['paypal_id'] === $ipnInfo->paypal_id) )
	{
		$rArray = array('Refunded','Reversed','Canceled_Reversal');
		if(in_array($ipnInfo->payment_status,$rArray))
		{
			$txn_id = $ipnInfo->parent_txn_id;
		} else {
			$txn_id = $ipnInfo->txn_id;
		}
		$order_query = olc_db_query("
			select o.orders_id from " . TABLE_ORDERS . " o left join " . TABLE_PAYPAL .
			" p on p.paypal_id = o.payment_id where p.txn_id = '" . olc_db_input($txn_id) . APOS);
		$onclick = '';
		if(olc_db_num_rows($order_query)) {
			$order = olc_db_fetch_array($order_query);
			$ipnInfo->orders_id = $order['orders_id'];
			$onclick = "onclick=\"javascript:document.location.href='" . olc_href_link(FILENAME_ORDERS, 'page=' .
			$page . '&oID=' . $ipnInfo->orders_id . '&action=edit' . '&referer=ipn') . "'\"";
		}
		echo '
              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)"'.
              	' onmouseout="rowOutEffect(this)" '. $onclick .'>' . NEW_LINE;
	} else {
		echo '
              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"'.
		 						' onclick="javascript:document.location.href=\'' . olc_href_link(FILENAME_PAYPAL, 'page=' .
								$page . '&ipnID=' . $ipn_trans['paypal_id']) . '\'">' . NEW_LINE;
	}
?>
                <td class="dataTableContent">
                	<?php echo PayPal_TransactionDetails::date($ipn_trans['payment_date']); ?>
                </td>
                <td class="dataTableContent">
                	<?php echo $ipn_trans['payment_status']; ?>
                </td>
                <td class="dataTableContent" align="right">
                	<?php echo PayPal_TransactionDetails::format($ipn_trans['mc_gross'],
                	$ipn_trans['mc_currency']); ?>
                </td>
                <td class="dataTableContent" align="right">
                	<?php echo PayPal_TransactionDetails::format($ipn_trans['mc_fee'],
                		$ipn_trans['mc_currency']); ?>
                </td>
                <td class="dataTableContent" align="right">
                	<?php echo PayPal_TransactionDetails::format($ipn_trans['mc_gross']-$ipn_trans['mc_fee'],
                	$ipn_trans['mc_currency']); ?>
                </td>
                <td class="dataTableContent" align="right">
                	<?php
                		if (isset($ipnInfo) && is_object($ipnInfo) &&
                			($ipn_trans['paypal_id'] == $ipnInfo->paypal_id) )
                		{
                			echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif');
                		}
                		else
                		{
                			echo HTML_A_START . olc_href_link(FILENAME_PAYPAL, 'page=' . $page .
                			'&ipnID=' . $ipn_trans['paypal_id']) . '">' .
                			olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END;
                		} ?>&nbsp;
                	</td>
              </tr>
<?php
}
?>
              <tr>
                <td colspan="5">
	                <table border="0" width="100%" cellspacing="0" cellpadding="2">
	                  <tr>
	                    <td class="smallText" valign="top">
	                    	<?php echo $ipn_split->display_count($ipn_query_numrows, MAX_DISPLAY_SEARCH_RESULTS,
	                    	$page, TEXT_DISPLAY_NUMBER_OF_TRANSACTIONS); ?>
	                    </td>
	                    <td class="smallText" align="right">
	                    	<?php echo $ipn_split->display_links($ipn_query_numrows, MAX_DISPLAY_SEARCH_RESULTS,
	                    	MAX_DISPLAY_PAGE_LINKS, $page); ?>
	                    </td>
	                  </tr>
	                </table>
	              </td>
              </tr>
            </table>
          </td>
<?php
$heading = array();
$contents = array();

switch ($action) {
	case 'new':
		break;
	case 'edit':
		break;
	case 'delete':
		break;
	default:
		if (is_object($ipnInfo))
		{
			$heading[] = array('text' => HTML_B_START . TEXT_INFO_PAYPAL_IPN_HEADING.' #' . $ipnInfo->paypal_id . HTML_B_END);
			if(!empty($ipnInfo->orders_id)) {
				$contents[] = array('align' => 'center', 'text' => HTML_A_START .
				olc_href_link(FILENAME_ORDERS, olc_get_all_get_params(array('ipnID', 'oID', 'action')) .
				'oID=' . $ipnInfo->orders_id .'&action=edit&referer=ipn') . '">' .
				olc_image_button('button_orders.gif', IMAGE_ORDERS) . HTML_A_END);
			} elseif(!empty($ipnInfo->txn_id)) {
				$contents[] = array(
				'align' => 'center',
				'text' => '<a href="javascript:openWindow(\''.
				olc_href_link(FILENAME_PAYPAL, olc_get_all_get_params(array('ipnID', 'oID', 'action')) .
				'action=details&info=' . $ipnInfo->txn_id ).'\');">' .
				olc_image_button('button_preview.gif', IMAGE_PREVIEW) . HTML_A_END);
			}
			$contents[] = array('text' => HTML_BR . TABLE_HEADING_DATE . ': ' .
			PayPal_TransactionDetails::date($ipnInfo->payment_date));
		}
		break;
}

if ( (!empty($heading)) && (!empty($contents)) ) {
	echo '            <td width="25%" valign="top">' . NEW_LINE;

	$box = new box;
	echo $box->infoBox($heading, $contents);

	echo '            </td>' . NEW_LINE;
}
?>
          </tr>
        </table></td>
      </tr>
    </table>
