<?php
/*
  $Id: paypal.php,v 1.1.1.1 2006/12/22 13:36:56 gswkaiser Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  DevosC, Developing open source Code
  http://www.devosc.com

  Copyright (c) 2003 osCommerce
  Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  define('DIR_WS_CATALOG_MODULES',DIR_WS_CATALOG_LANGUAGES.'../modules/');

$paypal_admin_dir=PAYPAL_IPN_DIR.'admin/';
  require(PAYPAL_IPN_DIR.'classes/Page/Page.class.php');
  require(PAYPAL_IPN_DIR.'database_tables.inc.php');

  $page = new PayPal_Page();
  $page->setBaseDirectory(PAYPAL_IPN_DIR.'');
  $page->setBaseURL(DIR_WS_CATALOG_MODULES . 'payment/paypal/');
  $page->includeLanguageFile('admin/languages',$language,'paypal.lng.php');
  $page->addCSS('paypal.php?action=css&id=general');
  $page->addCSS('paypal.php?action=css&id=stylesheet');
  $page->addJavaScript(FULL_CURRENT_TEMPLATE.'templates/js/general.js');
  $action = (isset($HTTP_GET_VARS['action'])) ? $HTTP_GET_VARS['action'] : '';

  switch($action) {
    case 'details':
      $page->setTitle(HEADING_DETAILS_TITLE);
      $page->includeLanguageFile('admin/languages',$language,'TransactionDetails.lng.php');
      $page->setContentFile($paypal_admin_dir.'TransactionDetails.inc.php');
      $page->setTemplate('popup');
      break;
    case 'itp':
     include_once(PAYPAL_IPN_DIR.'classes/IPN/IPN.class.php');
      $page->setTitle(HEADING_ITP_TITLE);
      $page->setContentFile($paypal_admin_dir.'TestPanel/TestPanel.inc.php');
      $page->setTemplate('default');
      $page->setOnLoad('javascript:window.focus();document.ipn.txn_id.select();');
      break;
    case 'itp-help':
      $page->setTitle(HEADING_ITP_HELP_TITLE);
      $page->setContentLangaugeFile($paypal_admin_dir.'TestPanel/languages',$language,'Help.inc.php');
      $page->setOnLoad('javascript:window.focus();');
      $page->setTemplate('popup');
      break;
    case 'css':
      header("Content-Type: text/css");
      echo $page->getCSS($HTTP_GET_VARS['id']);
      exit;
      break;
    default:
      $page->setContentFile($paypal_admin_dir.'PayPal.inc.php');
      $page->setTemplate('osC_Admin');
      $page->setOnLoad('javascript:SetFocus();');
     break;
  }
  require($page->template());
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>