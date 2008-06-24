<?php
/*
  $Id: TestPanel.inc.php,v 1.1.1.1.2.1 2007/04/08 07:18:07 gswkaiser Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  DevosC, Developing open source Code
  http://www.devosc.com

  Copyright (c) 2003 osCommerce
  Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

  Released under the GNU General Public License
*/
require_once(DIR_FS_INC.'olc_draw_form.inc.php');
require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
olc_draw_form('ipn',olc_catalog_href_link(FILENAME_IPN),'POST');
olc_draw_hidden_field('business',MODULE_PAYMENT_PAYPAL_BUSINESS_ID);
olc_draw_hidden_field('receiver_email',MODULE_PAYMENT_PAYPAL_ID);
olc_draw_hidden_field('verify_sign','PAYPAL_SHOPPING_CART_IPN-TEST_TRANSACTION-00000000000000');
olc_draw_hidden_field('payment_date',ate("H:i:s M d, Y T"));
olc_draw_hidden_field('digestKey',PayPal_IPN::digestKey());
?>
<table border="0" cellspacing="0" cellpadding="2" class="main">
<?php if (MODULE_PAYMENT_PAYPAL_IPN_TEST_MODE == 'Off') { ?>
  <tr>
    <td>
      <table border="0" cellspacing="0" cellpadding="0" style="padding: 4px; border:1px solid #aaaaaa; background: #ffffcc;">
        <tr>
          <td><?php echo $page->image('icon_error_40x40.gif','Error icon'); ?></td>
          <td><br class="text_spacer"></td>
          <td class="pperrorbold" style="text-align: center; width:100%;">Test Mode must be enabled!</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td><br class="h10"></td>
  </tr>
<?php } ?>
  <tr>
    <td style="text-align: right;"><a href="<?php echo olc_href_link(FILENAME_PAYPAL,'action=itp&mode=advanced'); ?>">Advanced</a>&nbsp;&nbsp;&nbsp;<a href="#" onclick="javascript:openWindow('<?php echo olc_href_link('paypal.php','action=itp-help'); ?>');">Help with this page</a>&nbsp;<a href="#" onclick="javascript:openWindow('<?php echo olc_href_link('paypal.php','action=itp-help'); ?>');"><img src="<?php echo $page->imagePath('help.gif')?>" border="0" hspace="0" align="top"></a></td>
  </tr>
  <tr>
    <td>
      <table border="0" cellspacing="0" cellpadding="2" class="ppheaderborder" width="100%">
        <tr>
          <td align="center">
            <table border="0" cellspacing="0" cellpadding="3" class="testpanelinfo">
              <tr>
                <td class="pptextbold" nowrap="nowrap">Primary PayPal Email Address</td>
                <td class="pptextbold" nowrap="nowrap">Business id</td>
                <td class="pptextbold" nowrap="nowrap">Debug Email Address</td>
              </tr>
              <tr>
                <td nowrap="nowrap"><?php echo MODULE_PAYMENT_PAYPAL_ID; ?></td>
                <td nowrap="nowrap"><?php echo MODULE_PAYMENT_PAYPAL_BUSINESS_ID; ?></td>
                <td nowrap="nowrap"><?php echo MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL; ?></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td><br class="h10"></td>
  </tr>
  <tr valign="top">
    <td>
      <table border="0" cellspacing="0" cellpadding="5" class="testpanel">
        <tr valign="top">
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr><td nowrap="nowrap">First Name</td><td nowrap="nowrap"><input type="text" name="first_name" value="John"></td></tr>
              <tr><td nowrap="nowrap">Last Name</td><td nowrap="nowrap"><input type="text" name="last_name" value="Doe"></td></tr>
              <tr><td nowrap="nowrap">Business Name</td><td nowrap="nowrap"><input type="text" name="payer_business_name" value="ACME Inc."></td></tr>
              <tr><td nowrap="nowrap">Email Address</td><td nowrap="nowrap"><input type="text" name="payer_email" value="root@localhost"></td></tr>
              <tr><td nowrap="nowrap">Payer id</td><td nowrap="nowrap"><input type="text" name="payer_id" value="PAYERID000000"></td></tr>
              <tr><td nowrap="nowrap">Payer Status</td><td nowrap="nowrap" align="right"><select name="payer_status"><option value="verified">verified</option><option value="unverified">unverified</option></select></td></tr>
              <tr><td nowrap="nowrap">Invoice</td><td nowrap="nowrap"><input type="text" name="invoice" value=""></td></tr>
            </table>
          </td>
          <td>
            <table border="0" cellspacing="0" cellpadding="2">
              <tr valign="top"><td nowrap="nowrap">Address Name</td><td nowrap="nowrap"><input type="text" name="address_name" value="John Doe"></td></tr>
              <tr><td nowrap="nowrap">Address Street</td><td nowrap="nowrap"><input type="text" name="address_street" value="1 Way Street"></td></tr>
              <tr><td nowrap="nowrap">Address City</td><td><input type="text" name="address_city" value="NeverNever"></td></tr>
              <tr><td nowrap="nowrap">Address State</td><td nowrap="nowrap"><input type="text" name="address_state" value="CA"></td></tr>
              <tr><td nowrap="nowrap">Address Zip</td><td><input type="text" name="address_zip" value="12345"></td></tr>
              <tr><td nowrap="nowrap">Address Country</td><td nowrap="nowrap"><input type="text" name="address_country" value="United States"></td></tr>
              <tr><td nowrap="nowrap">Address Status</td><td nowrap="nowrap" align="right"><select name="address_status"><option value="confirmed">confirmed</option><option value="unconfirmed">unconfirmed</option></select></td></tr>
            </table>
          </td>
          <td>
            <table border="0" cellspacing="0" cellpadding="2">
              <tr><td nowrap="nowrap">Payment Type</td><td nowrap="nowrap" align="right"><select name="payment_type"><option value="instant">instant</option><option value="echeck">echeck</option></select></td></tr>
              <tr><td nowrap="nowrap">Transaction Type</td><td nowrap="nowrap" align="right"><select name="txn_type"><option value="">--select--</option><option value="cart">cart</option><option value="web_accept">web_accept</option><option value="send_money">send_money</option></select></td></tr>
              <tr><td nowrap="nowrap">Custom</td><td nowrap="nowrap"><input type="text" name="custom" value="1" maxlength="32"></td></tr>
              <tr><td nowrap="nowrap">Transaction id</td><td nowrap="nowrap"><input type="text" name="txn_id" value="PAYPAL00000000000" maxlength="17"></td></tr>
              <tr><td nowrap="nowrap">Parent Transaction id</td><td nowrap="nowrap"><input type="text" name="parent_txn_id" value="" maxlength="17"></td></tr>
              <tr><td nowrap="nowrap">No. Cart Items</td><td><input type="text" name="num_cart_items" value="1"></td></tr>
              <tr><td nowrap="nowrap">Notify Version</td><td nowrap="nowrap" align="right"><select name="notify_version"><option value="1.6" selected>1.6</option></select></td></tr>
              <tr><td nowrap="nowrap">Memo</td><td nowrap="nowrap"><input type="text" name="memo" value="PAYPAL_SHOPPING_CART_IPN TEST"></td></tr>
            </table>
          </td>
        </tr>
        <tr valign="top">
          <td>
            <table border="0" cellspacing="0" cellpadding="2">
              <tr><td nowrap="nowrap">MC Currency</td><td align="right"><select name="mc_currency"><option value="USD">USD</option><option value="GBP">GBP</option><option value="EUR">EUR</option><option value="CAD">CAD</option><option value="JPY">JPY</option></select></td></tr>
              <tr><td nowrap="nowrap">MC Gross</td><td align="right"><input type="text" name="mc_gross" value="0.01"></td></tr>
              <tr><td nowrap="nowrap">MC Fee</td><td align="right"><input type="text" name="mc_fee" value="0.01"></td></tr>
            </table>
          </td>
          <td>
            <table border="0" cellspacing="0" cellpadding="2">
              <tr><td nowrap="nowrap">Settle Amount</td><td align="right"><input type="text" name="settle_amount" value="0.00"></td></tr>
              <tr><td nowrap="nowrap">Settle Currency</td><td align="right"><select name="settle_currency"><option value=""></option><option value="USD">USD</option><option value="GBP">GBP</option><option value="EUR">EUR</option><option value="CAD">CAD</option><option value="JPY">JPY</option></select></td></tr>
              <tr><td nowrap="nowrap">Exchange Rate</td><td align="right"><input type="text" name="exchange_rate" value="0.00"></td></tr>
            </table>
          </td>
          <td>
            <table border="0" cellspacing="0" cellpadding="2">
              <tr><td nowrap="nowrap">Payment Status</td><td align="right"><select name="payment_status"><option value="Completed">Completed</option><option value="Pending">Pending</option><option value="Failed">Failed</option><option value="Denied">Denied</option><option value="Refunded">Refunded</option><option value="Reversed">Reversed</option><option value="Canceled_Reversal">Canceled_Reversal</option></select></td></tr>
              <tr><td nowrap="nowrap">Pending Reason</td><td align="right"><select name="pending_reason"><option value=""></option><option value="echeck">echeck</option><option value="multi_currency">multi_currency</option><option value="intl">intl</option><option value="verify">verify</option><option value="address">address</option><option value="upgrade">upgrade</option><option value="unilateral">unilateral</option><option value="other">other</option></select></td></tr>
              <tr><td nowrap="nowrap">Reason Code</td><td align="right"><select name="reason_code"><option value=""></option><option value="chargeback">chargeback</option><option value="guarantee">guarantee</option><option value="buyer_complaint">buyer_complaint</option><option value="refund">refund</option><option value="other">other</option></select></td></tr>
            </table>
          </td>
        </tr>
<?php if (isset($HTTP_GET_VARS['mode']) && $HTTP_GET_VARS='Advanced') { ?>
        <tr valign="top">
          <td>
            <table border="0" cellspacing="0" cellpadding="2">
              <tr><td nowrap="nowrap">Tax</td><td align="right"><input type="text" name="tax" value="0.00"></td></tr>
            </table>
          </td>
          <td>
            <table border="0" cellspacing="0" cellpadding="2">
              <tr><td nowrap="nowrap">For Auction</td><td align="right"><select name="for_auction"><option value="">No</option><option value="true">Yes</option></select></td></tr>
              <tr><td nowrap="nowrap">Auction Buyer id</td><td align="right"><input type="text" name="auction_buyer_id" value=""></td></tr>
              <tr><td nowrap="nowrap">Auction Closing Date</td><td align="right"><input type="text" name="auction_closing_date" value="<?php echo date("H:i:s M d, Y T"); ?>"></td></tr>
              <tr><td nowrap="nowrap">Auction Multi-Item</td><td align="right"><input type="text" name="auction_multi_item" value=""></td></tr>
            </table>
          </td>
          <td>
            <table border="0" cellspacing="0" cellpadding="2">
              <tr><td nowrap="nowrap">Item Name</td><td align="right"><input type="text" name="item_name" value=""></td></tr>
              <tr><td nowrap="nowrap">Item Number</td><td align="right"><input type="text" name="item_number" value=""></td></tr>
              <tr><td nowrap="nowrap">Quantity</td><td align="right"><input type="text" name="quantity" value=""></td></tr>
            </table>
          </td>
        </tr>
<?php } ?>
      </table>
    </td>
  </tr>
  <tr><td><hr class="solid"/></td></tr>
  <tr><td class="buttontd"><input class="ppbuttonsmall" type="submit" name="submit" value="Test IPN"></td></tr>
</table>
<form>