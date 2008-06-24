<?php
/*
$Id: TransactionSummaryLogs.inc.php,v 1.1.1.1.2.1 2007/04/08 07:18:07 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2003 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/

require_once(PAYPAL_IPN_DIR.'Classes/TransactionDetails/TransactionDetails.class.php');
require_once(PAYPAL_IPN_DIR.'Classes/Page/Page.class.php');
require_once(PAYPAL_IPN_DIR.'Functions/general.func.php');
paypal_include_lng(PAYPAL_IPN_DIR.'Admin/languages/', $language, 'paypal.lng.php');
require_once(PAYPAL_IPN_DIR.'database_tables.inc.php');
$paypal = new PayPal_TransactionDetails(TABLE_PAYPAL,$order->info['payment_id']);
?>
          <tr valign="top">
            <td colspan="2" style="padding-bottom:0px;">
            	<?php echo olc_image(PAYPAL_IPN_DIR.'images/paypal_logo.gif','PayPal'); ?>
            </td>
          </tr>
          <tr valign="top">
            <td class="main">
	            <style type="text/css">
								.Txns{font-family: Verdana;font-size: 10px;color: #000000;background-color: #aaaaaa;}
								.Txns td {padding: 2px 4px;}.TxnsTitle td {color: #000000;font-weight: bold;font-size: 13px;}
								.TxnsSTitle td{background-color: #ccddee;color: #000000;font-weight: bold;}
							</style>
	            <script language="javascript" type="text/javascript">
	            function openWindow(url,name,args)
	            {
	            	if (url == null || url == '') exit;
	            	if (name == null || name == '') name = 'popupWin';
	            	if (args == null || args == '')
	            	{
	            		args = 'toolbar,status,scrollbars,resizable,width=640,height=480,left=50,top=50';
	            		popupWin = window.open(url,name,args);popupWin.focus();}
	            }
	            </script>
	            <table cellspacing="1" cellpadding="1" border="0" class="Txns">
	  	          <tr>
	  	          	<td colspan="7">&nbsp;<b><?php echo TABLE_HEADING_TXN_ACTIVITY; ?></b></td>
	  	          </tr>
		            <tr class="TxnsSTitle">
		              <td nowrap="nowrap">&nbsp;<?php echo TABLE_HEADING_DATE; ?>&nbsp;</td>
		              <td nowrap="nowrap">&nbsp;<?php echo TABLE_HEADING_PAYMENT_STATUS; ?>&nbsp;</td>
		              <td nowrap="nowrap">&nbsp;<?php echo TABLE_HEADING_DETAILS; ?>&nbsp;</td>
		              <td nowrap="nowrap">&nbsp;<?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
		              <td nowrap="nowrap" align="right">&nbsp;<?php echo TABLE_HEADING_PAYMENT_GROSS; ?>&nbsp;</td>
		              <td nowrap="nowrap" align="right">&nbsp;<?php echo TABLE_HEADING_PAYMENT_FEE; ?>&nbsp;</td>
		              <td nowrap="nowrap" align="right">&nbsp;<?php echo TABLE_HEADING_PAYMENT_NET_AMOUNT; ?>&nbsp;</td>
			          </tr>
<?php
if (!empty($paypal->info['txn_id']))
{
	$paypal_history_query =
	olc_db_query("select txn_id, payment_status, mc_gross, mc_fee, mc_currency, date_added, payment_date from " .
	TABLE_PAYPAL . " where parent_txn_id = '" . olc_db_input($paypal->info['txn_id']) .
	"' order by date_added desc");
	if (olc_db_num_rows($paypal_history_query)) {
		$phCount = 1;
		while ($paypal_history = olc_db_fetch_array($paypal_history_query)) {
			$phColor = (($phCount/2) == floor($phCount/2)) ? '#FFFFFF' : '#EEEEEE';
			$mc_currency=$paypal_history['mc_currency'].HTML_NBSP;
			$mc_gross=$paypal_history['mc_gross'];
			$mc_fee=$paypal_history['mc_fee'];
			echo
'			          <tr bgcolor="'.$phColor.'">' . NEW_LINE .
' 	           		<td nowrap="nowrap">&nbsp;' . $paypal->date($paypal_history['payment_date']) . '&nbsp;</td>' . NEW_LINE.
'   	         		<td nowrap="nowrap">&nbsp;' . $paypal_history['payment_status'] . '&nbsp;</td>' . NEW_LINE .
'     	       		<td nowrap="nowrap">&nbsp;'.
										PayPal_Page::draw_href_link(TABLE_HEADING_DETAILS,'action=details&info='.
										$paypal_history['txn_id']).'&nbsp;
									</td>' . NEW_LINE .
'      	    		 	<td nowrap="nowrap">&nbsp;</td>' . NEW_LINE . //Action
'		            	<td nowrap="nowrap" align="right">&nbsp;'.
										$paypal->format($mc_gross,$mc_currency).'
									</td>' . NEW_LINE .
'		   		        <td nowrap="nowrap" align="right">&nbsp;'.
										$paypal->format($mc_fee,$mc_currency).'
									</td>' . NEW_LINE .
'       			    <td nowrap="nowrap" align="right">&nbsp;'.
										$paypal->format($mc_gross-$mc_fee,$mc_currency).'
 									</td>' . NEW_LINE .
'          			</tr>' . NEW_LINE;
			$phCount++;
		}
	}

	//Now determine whether the order is on hold
	if($order->info['orders_status'] === MODULE_PAYMENT_PAYPAL_ORDER_ONHOLD_STATUS_ID)
	{
		$ppImgAccept = olc_image(PAYPAL_IPN_DIR.'images/act_accept.gif',IMAGE_BUTTON_TXN_ACCEPT);
		$ppAction = HTML_A_START.olc_href_link(FILENAME_ORDERS,olc_get_all_get_params(array('action')).
		'action=accept_order&digest='.$paypal->digest()).'">'.$ppImgAccept.HTML_A_END;
	} else {
		$ppAction = '';
	}
	$mc_currency=$paypal->txn['mc_currency'];
	$mc_gross=$paypal->txn['mc_gross'];
	$mc_fee=$paypal->txn['mc_fee'];
?>
	          		<tr bgcolor="#FFFFFF">
			            <td nowrap="nowrap">&nbsp;<?php echo $paypal->date($paypal->info['payment_date']); ?>&nbsp;</td>
			            <td nowrap="nowrap">&nbsp;<?php echo $paypal->info['payment_status']; ?>&nbsp;</td>
			            <td nowrap="nowrap">&nbsp;
			            	<?php echo PayPal_Page::draw_href_link(TABLE_HEADING_DETAILS,'action=details&info='.
			            		$paypal->info['txn_id']); ?>&nbsp;
			            </td>
			            <td nowrap="nowrap">&nbsp;<?php echo $ppAction; ?>&nbsp;</td>
			            <td align="right" nowrap="nowrap">&nbsp;
			            	<?php echo $paypal->format($mc_gross,$mc_currency); ?>&nbsp;
			            </td>
			            <td align="right" nowrap="nowrap">&nbsp;
			            	<?php echo $paypal->format($mc_fee,$mc_currency); ?>&nbsp;
			            </td>
			            <td align="right" nowrap="nowrap">&nbsp;
			            	<?php echo $paypal->format($mc_gross-$mc_fee,$mc_currency); ?>&nbsp;
			            </td>
			       	 	</tr>
<?php } else { ?>
								<tr bgcolor="#FFFFFF">
				          <td colspan="7" nowrap="nowrap">&nbsp;
				          	<?php echo sprintf(TEXT_NO_IPN_HISTORY,$paypal->transactionSignature($oID)); ?>&nbsp;
				          </td>
			        	</tr>
<?php } ?>
		        	</table>
	  	    	</td>
	    	  	<td></td>
	    		</tr>
