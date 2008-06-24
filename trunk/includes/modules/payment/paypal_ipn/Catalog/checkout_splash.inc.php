<?php
/*
  $Id: checkout_splash.inc.php,v 1.1.1.1.2.1 2007/04/08 07:18:08 gswkaiser Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  DevosC, Developing open source Code
  http://www.devosc.com

  Copyright (c) 2003 osCommerce
  Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

  Released under the GNU General Public License

*/
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<title><?php echo STORE_NAME; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<style type="text/css">
body {background-color:#FFFFFF;}
body, td, div {font-family: verdana, arial, sans-serif;}
</style>
</head>
<body onload="return document.paypal_payment_info.submit();">
<?php echo NEW_LINE.olc_draw_form('paypal_payment_info', $this->form_paypal_url, 'post'); ?>
<table cellpadding="0" width="100%" height="100%" cellspacing="0" style="border:1px solid #003366;">
  <tr><td align="middle" style="height:100%; vertical-align:middle;">
    <div><?php if (olc_not_null(MODULE_PAYMENT_PAYPAL_PROCESSING_LOGO)) echo olc_image(DIR_WS_IMAGES . MODULE_PAYMENT_PAYPAL_PROCESSING_LOGO); ?></div>
    <div style="color:#003366"><h1><?php echo MODULE_PAYMENT_PAYPAL_TEXT_TITLE_PROCESSING . olc_image(PAYPAL_IPN_DIR.'images/period_ani.gif'); ?></h1></div>
    <div style="margin:10px;padding:10px;"><?php echo MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION_PROCESSING?></div>
    <div style="margin:10px;padding:10px;"><?php echo olc_image_submit('button_ppcheckout.gif', MODULE_PAYMENT_PAYPAL_IMAGE_BUTTON_CHECKOUT); ?></div>
  </td></tr>
</table>
<?php echo $this->formFields().NEW_LINE; ?>
</body></html>
<?php require(PAYPAL_IPN_DIR.'application_bottom.inc.php'); ?>
