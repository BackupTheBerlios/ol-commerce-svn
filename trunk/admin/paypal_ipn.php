<?php
/*
$Id: paypal_ipn.php,v 1.1.1.1 2006/12/22 13:36:56 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2003 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/
//W. Kaiser PayPal IPN
require('includes/application_top.php');
if (USE_PAYPAL_IPN)
{
	//define('DIR_WS_CATALOG_MODULES',DIR_WS_CATALOG_LANGUAGES.'../modules/');
	$paypal_admin_dir=PAYPAL_IPN_DIR.'Admin/';
	require(PAYPAL_IPN_DIR.'Classes/Page/Page.class.php');
	require(PAYPAL_IPN_DIR.'database_tables.inc.php');

	$page = new PayPal_Page();
	$page->setBaseDirectory(PAYPAL_IPN_DIR);
	//$page->setBaseURL(DIR_WS_MODULES . 'payment/paypal/');
	$page->setBaseURL(PAYPAL_IPN_DIR);
	$page->includeLanguageFile('Admin/languages',SESSION_LANGUAGE,'paypal.lng.php');
	$p='paypal.php?action=css&id=';
	$page->addCSS($p.'general');
	$page->addCSS($p.'stylesheet');
	$page->addJavaScript(FULL_CURRENT_TEMPLATE.'templates/js/general.js');
	$action = $_GET['action'];
	switch($action)
	{
		case 'details':
			$page->setTitle(HEADING_DETAILS_TITLE);
			$page->includeLanguageFile('Admin/languages',SESSION_LANGUAGE,'TransactionDetails.lng.php');
			$page->setContentFile($paypal_admin_dir.'TransactionDetails.inc.php');
			$page->setTemplate('olc_popup');
			break;
		case 'itp':
			include_once(PAYPAL_IPN_DIR.'Classes/Ipn/IPN.class.php');
			$page->setTitle(HEADING_ITP_TITLE);
			$page->setContentFile($paypal_admin_dir.'TestPanel/TestPanel.inc.php');
			$page->setTemplate('default');
			$page->setOnLoad('window.focus();document.ipn.txn_id.select();');
			break;
		case 'itp-help':
			$page->setTitle(HEADING_ITP_HELP_TITLE);
			$page->setContentLanguageFile($paypal_admin_dir.'TestPanel/languages',SESSION_LANGUAGE,'Help.inc.php');
			$page->setOnLoad('window.focus();');
			$page->setTemplate('olc_popup');
			break;
		case 'css':
			header("Content-Type: text/css");
			echo $page->getCSS($_GET['id']);
			exit;
			break;
		default:
			$page->setContentFile($paypal_admin_dir.'PayPal.inc.php');
			$page->setTemplate('olC_Admin');
			$page->setOnLoad('SetFocus();');
			break;
	}
	require($page->template());
	require(DIR_WS_INCLUDES . 'application_bottom.php');
}
//W. Kaiser PayPal IPN
?>