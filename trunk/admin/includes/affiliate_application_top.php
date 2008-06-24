<?php
/*------------------------------------------------------------------------------
$Id: affiliate_application_top.php,v 1.1.1.1.2.1 2007/04/08 07:16:34 gswkaiser Exp $

OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

modified by http://www.ol-commerce.de, http://www.seifenparadies.de


Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------
based on:
(c) 2003 OSC-Affiliate (affiliate_application_top.php, v 1.10 2003/02/24);
http://oscaffiliate.sourceforge.net/

Contribution based on:

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2002 - 2003 osCommerce
Copyright (c) 2003 netz-designer
Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

Copyright (c) 2002 - 2003 osCommerce

Released under the GNU General Public License
---------------------------------------------------------------------------*/

// Set the local configuration parameters - mainly for developers
$file=DIR_WS_INCLUDES . 'local/affiliate_configure.php';
if (file_exists($file)) include($file);

$affiliate="affiliate";
$affiliate_u=$affiliate."_";

require(DIR_WS_INCLUDES . $affiliate_u.'configure.php');
require(DIR_WS_FUNCTIONS . $affiliate_u.'functions.php');

$filename_affiliate='FILENAME_AFFILIATE';
$filename_affiliate_u=$filename_affiliate."_";
$filename_affiliate_help_u=$filename_affiliate_u."HELP_";
$affiliate_help_u=$affiliate_help_u.'';
define($filename_affiliate, $affiliate_u.'affiliates.php');
define($filename_affiliate_u.'BANNERS', $affiliate_u.'banners.php');
define($filename_affiliate_u.'BANNER_MANAGER', FILENAME_AFFILIATE_BANNERS);
define($filename_affiliate_u.'CLICKS', $affiliate_u.'clicks.php');
define($filename_affiliate_u.'CONTACT', $affiliate_u.'contact.php');
define($filename_affiliate_help_u.'1', $affiliate_help_u.'1.php');
define($filename_affiliate_help_u.'2', $affiliate_help_u.'2.php');
define($filename_affiliate_help_u.'3', $affiliate_help_u.'3.php');
define($filename_affiliate_help_u.'4', $affiliate_help_u.'4.php');
define($filename_affiliate_help_u.'5', $affiliate_help_u.'5.php');
define($filename_affiliate_help_u.'6', $affiliate_help_u.'6.php');
define($filename_affiliate_help_u.'7', $affiliate_help_u.'7.php');
define($filename_affiliate_help_u.'8', $affiliate_help_u.'8.php');
define($filename_affiliate_u.'INVOICE', $affiliate_u.'invoice.php');
define($filename_affiliate_u.'PAYMENT', $affiliate_u.'payment.php');
define($filename_affiliate_u.'POPUP_IMAGE', $affiliate_u.'popup_image.php');
define($filename_affiliate_u.'SALES', $affiliate_u.'sales.php');
define($filename_affiliate_u.'STATISTICS', $affiliate_u.'statistics.php');
define($filename_affiliate_u.'SUMMARY', $affiliate_u.'summary.php');
define($filename_affiliate_u.'RESET', $affiliate_u.'reset.php');
define('FILENAME_CATALOG_AFFILIATE_PAYMENT_INFO',FILENAME_AFFILIATE_PAYMENT);
define('FILENAME_CATALOG_PRODUCT_INFO',FILENAME_PRODUCT_INFO);

$affiliate_u=TABLE_PREFIX_INDIVIDUAL.$affiliate_u;

$table_affiliate='TABLE_AFFILIATE';
$table_affiliate_u=$table_affiliate."_";
define($table_affiliate, $affiliate_u.$affiliate);
define($table_affiliate_u.'BANNERS', $affiliate_u.'banners');
define($table_affiliate_u.'BANNERS_HISTORY', TABLE_AFFILIATE_BANNERS.'_history');
define($table_affiliate_u.'CLICKTHROUGHS', $affiliate_u.'clickthroughs');
define($table_affiliate_u.'PAYMENT', $affiliate_u.'payment');
define($table_affiliate_u.'PAYMENT_STATUS', TABLE_AFFILIATE_PAYMENT.'_status');
define($table_affiliate_u.'PAYMENT_STATUS_HISTORY', TABLE_AFFILIATE_PAYMENT_STATUS.'_history');
define($table_affiliate_u.'SALES', $affiliate_u.'sales');

// include the language translations
require(DIR_FS_LANGUAGES . SESSION_LANGUAGE . '/admin/affiliate_'.SESSION_LANGUAGE . PHP);

// If an order is deleted delete the sale too (optional)
if ($_GET['action'] == 'deleteconfirm' && basename($_SERVER['SCRIPT_FILENAME']) == FILENAME_ORDERS && AFFILIATE_DELETE_ORDERS == TRUE_STRING_S) {
	$affiliate_oID = olc_db_prepare_input($_GET['oID']);
	olc_db_query(DELETE_FROM . TABLE_AFFILIATE_SALES . " where affiliate_orders_id = '" . olc_db_input($affiliate_oID) . "' and affiliate_billing_status != 1");
}
?>
