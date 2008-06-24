<?php
/*
$Id: popup_paypal.php,v 1.1.1.1 2006/12/22 13:35:51 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2003 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/

require(PAYPAL_IPN_DIR.'Classes/Page/Page.class.php');
$page = new PayPal_Page();
$page->setBaseDirectory(PAYPAL_DIR);

$action = (isset($HTTP_GET_VARS['action'])) ? $HTTP_GET_VARS['action'] : '';

switch($action)
{
	case 'css':
		header("Content-Type: text/css");
		echo $page->getCSS($HTTP_GET_VARS['id']);
		exit;
		break;
}

require("includes/application_top.php");

$navigation->remove_current_page();

$page->setBaseURL(PAYPAL_DIR);
$url='popup_paypal.php?action=css&id=';
$page->addCSS($url.'general');
$page->addCSS($url.'stylesheet');

switch($action)
{
	default:
		$page->setContentLanguageFile($page->baseDirectory.'lang',$language,'info_cc.inc.php');
		$page->setTemplate('olC_Catalog');
		break;
}
require($page->template());
require("includes/counter.php");
require(DIR_WS_INCLUDES . 'application_bottom.php');
?>