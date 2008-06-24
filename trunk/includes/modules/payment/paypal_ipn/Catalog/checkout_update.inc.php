<?php
/*
  $Id: checkout_update.inc.php,v 1.1.1.1.2.1 2007/04/08 07:18:08 gswkaiser Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  DevosC, Developing open source Code
  http://www.devosc.com

  Copyright (c) 2003 osCommerce
  Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

  Released under the GNU General Public License
*/

  $PayPal_osC_Order->setAccountHistoryInfoURL(olc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $PayPal_osC_Order->orderID, 'SSL', false));
  $PayPal_osC_Order->setCheckoutProcessLanguageFile(DIR_WS_LANGUAGES . $PayPal_osC_Order->language . '/' . FILENAME_CHECKOUT_PROCESS);
  $PayPal_osC_Order->updateProducts($order);
  $PayPal_osC_Order->notifyCustomer($order);
  $affiliate_ref = $PayPal_osC_Order->affiliate_id;
  $affiliate_clickthroughs_id = $PayPal_osC_Order->affiliate_clickthroughs_id;
  $affiliate_clientdate = $PayPal_osC_Order->affiliate_date;
  $affiliate_clientbrowser = $PayPal_osC_Order->affiliate_browser;
  $affiliate_clientip = $PayPal_osC_Order->affiliate_ipaddress;
  if (olc_not_null($affiliate_ref) && $affiliate_ref != '0') {
    define('MODULE_PAYMENT_PAYPAL_SHOPPING_IPN_AFFILIATE',TRUE_STRING_S);
    $insert_id = $PayPal_osC_Order->orderID;
    include(DIR_WS_INCLUDES . 'affiliate_checkout_process.php');
  }
  $PayPal_osC_Order->updateOrderStatus(MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID);
  $PayPal_osC_Order->removeOrdersSession();
?>
