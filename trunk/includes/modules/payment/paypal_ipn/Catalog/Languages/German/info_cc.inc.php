<?php
/*
  $Id: info_cc.inc.php,v 1.1.1.1.2.1 2007/04/08 07:18:08 gswkaiser Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  DevosC, Developing open source Code
  http://www.devosc.com

  Copyright (c) 2003 osCommerce
  Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

  Released under the GNU General Public License
*/
$paypal_image_dir=PAYPAL_IPN_DIR.'images/';
?>
<table border="0" cellpadding="0" cellspacing="0" class="popupmain">
  <tr><td class="ppheading" style="height: 50px;">Make Shopping Easier for Customers with Website Payments</td></tr>
  <tr><td><hr class="solid"></td></tr>
  <tr>
      <td class="pptext"><?php echo olc_image($paypal_image_dir.'hdr_ppGlobev4_160x76.gif',' PayPal ','','','align=right valign="top" style="margin: 10px;"'); ?>
PayPal has optimized their checkout experience by launching an exciting new improvement to their payment flow.
<br/><br/>For new buyers, signing up for a PayPal account is now optional. This means you can complete your payment first, and then decide whether to save your information for future purchases.
<p>To pay by credit card, look for this button:<br/>
<p align="center"><?php echo olc_image($paypal_image_dir.'PayPal-ContinueCheckout.gif','','',''); ?></p>
<br/>
Or you may see this:<br/>
<p align="center"><?php echo olc_image($paypal_image_dir.'PayPal-no-account-Click-Here.gif','','',''); ?></p>
<br/>
One of these options should appear on the first PayPal screen.<br/>
<p>Note: if you are a PayPal member, you can either use your account,
or use a credit card that is not associated with a PayPal account.
In that case you'd also need to use an email address that's not associated with a PayPal account.</p>
    </td>
  </tr>
  <tr><td><br class="h10"></td></tr>
</table>
