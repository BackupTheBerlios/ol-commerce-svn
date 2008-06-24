<?php
/*------------------------------------------------------------------------------
$Id: affiliate_application_top.php,v 1.1.1.1.2.1 2007/04/08 07:17:42 gswkaiser Exp $

OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

modified by http://www.ol-commerce.de, http://www.seifenparadies.de


Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------
based on:
(c) 2003 OSC-Affiliate (affiliate_application_top.php, v 1.18 2003/02/26);
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

$affiliate='affiliate_';
require(DIR_WS_INCLUDES . $affiliate.'configure.php');
$prefix=TABLE_PREFIX.$affiliate;
// define the database table names used in the contribution
define('TABLE_AFFILIATE', $prefix.'affiliate');
// if you change this -> affiliate_show_banner must be changed too
define('TABLE_AFFILIATE_BANNERS', $prefix.'banners');
define('TABLE_AFFILIATE_BANNERS_HISTORY', $prefix.'banners_history');
define('TABLE_AFFILIATE_CLICKTHROUGHS', $prefix.'clickthroughs');
define('TABLE_AFFILIATE_SALES', $prefix.'sales');
define('TABLE_AFFILIATE_PAYMENT', $prefix.'payment');
define('TABLE_AFFILIATE_PAYMENT_STATUS', $prefix.'payment_status');
define('TABLE_AFFILIATE_PAYMENT_STATUS_HISTORY', $prefix.'payment_status_history');

// define the filenames used in the project
define('FILENAME_AFFILIATE_SUMMARY', $affiliate.'summary.php');
define('FILENAME_AFFILIATE_LOGOUT', $affiliate.'logout.php');
define('FILENAME_AFFILIATE', $affiliate.'affiliate.php');
define('FILENAME_AFFILIATE_CONTACT', $affiliate.'contact.php');
define('FILENAME_AFFILIATE_FAQ', $affiliate.'faq.php');
define('FILENAME_AFFILIATE_DETAILS', $affiliate.'details.php');
define('FILENAME_AFFILIATE_ACCOUNT', FILENAME_AFFILIATE_DETAILS);
define('FILENAME_AFFILIATE_DETAILS_OK', $affiliate.'details_ok.php');
define('FILENAME_AFFILIATE_TERMS',$affiliate.'terms.php');

define('FILENAME_AFFILIATE_HELP_1', 'affiliate_help1.php');
define('FILENAME_AFFILIATE_HELP_2', 'affiliate_help2.php');
define('FILENAME_AFFILIATE_HELP_3', 'affiliate_help3.php');
define('FILENAME_AFFILIATE_HELP_4', 'affiliate_help4.php');
define('FILENAME_AFFILIATE_HELP_5', 'affiliate_help5.php');
define('FILENAME_AFFILIATE_HELP_6', 'affiliate_help6.php');
define('FILENAME_AFFILIATE_HELP_7', 'affiliate_help7.php');
define('FILENAME_AFFILIATE_HELP_8', 'affiliate_help8.php');
define('FILENAME_AFFILIATE_INFO', $affiliate.'info.php');

define('FILENAME_AFFILIATE_BANNERS', $affiliate.'banners.php');
define('FILENAME_AFFILIATE_SHOW_BANNER', $affiliate.'show_banner.php');
define('FILENAME_AFFILIATE_CLICKS', $affiliate.'clicks.php');

define('FILENAME_AFFILIATE_PASSWORD_FORGOTTEN', $affiliate.'password_forgotten.php');

define('FILENAME_AFFILIATE_LOGOUT', $affiliate.'logout.php');
define('FILENAME_AFFILIATE_SALES', $affiliate.'sales.php');
define('FILENAME_AFFILIATE_SIGNUP', $affiliate.'signup.php');

define('FILENAME_AFFILIATE_SIGNUP_OK', $affiliate.'signup_ok.php');
define('FILENAME_AFFILIATE_PAYMENT', $affiliate.'payment.php');

$affiliate_clientdate = (date ("Y-m-d H:i:s"));
$affiliate_clientbrowser = $_SERVER["HTTP_USER_AGENT"];
$affiliate_clientip = $_SERVER["REMOTE_ADDR"];
$affiliate_clientreferer = $_SERVER["HTTP_REFERER"];

if (!isset($_SESSION[$affiliate.'ref'])) {
	if (($_GET['ref'] || $_POST['ref'])) {
		if ($_GET['ref']) $_SESSION[$affiliate.'ref'] = $_GET['ref'];
		if ($_POST['ref']) $_SESSION[$affiliate.'ref'] = $_POST['ref'];
		if ($_GET['products_id']) $affiliate_products_id = $_GET['products_id'];
		if ($_POST['products_id']) $affiliate_products_id = $_POST['products_id'];
		if ($_GET[$affiliate.'banner_id']) $affiliate_banner_id = $_GET[$affiliate.'banner_id'];
		if ($_POST[$affiliate.'banner_id']) $affiliate_banner_id = $_POST[$affiliate.'banner_id'];

		if (!$link_to) $link_to = "0";
		$sql_data_array = array($affiliate.'id' => $_SESSION[$affiliate.'ref'],
		$affiliate.'clientdate' => $affiliate_clientdate,
		$affiliate.'clientbrowser' => $affiliate_clientbrowser,
		$affiliate.'clientip' => $affiliate_clientip,
		$affiliate.'clientreferer' => $affiliate_clientreferer,
		$affiliate.'products_id' => $affiliate_products_id,
		$affiliate.'banner_id' => $affiliate_banner_id);

		olc_db_perform(TABLE_AFFILIATE_CLICKTHROUGHS, $sql_data_array);
		$_SESSION[$affiliate.'clickthroughs_id'] = olc_db_insert_id();

		// Banner has been clicked, update stats:
		if ($affiliate_banner_id && $_SESSION[$affiliate.'ref']) {
			$today = date('Y-m-d');
			$sql = "select * from " . TABLE_AFFILIATE_BANNERS_HISTORY . " where affiliate_banners_id = '" . $affiliate_banner_id  . "' and  affiliate_banners_affiliate_id = '" . $_SESSION[$affiliate.'ref'] . "' and affiliate_banners_history_date = '" . $today . APOS;
			$banner_stats_query = olc_db_query($sql);
			// Banner has been shown today
			if (olc_db_fetch_array($banner_stats_query)) {
				olc_db_query(SQL_UPDATE . TABLE_AFFILIATE_BANNERS_HISTORY . " set affiliate_banners_clicks = affiliate_banners_clicks + 1 where affiliate_banners_id = '" . $affiliate_banner_id . "' and affiliate_banners_affiliate_id = '" . $_SESSION[$affiliate.'ref'] . "' and affiliate_banners_history_date = '" . $today . APOS);
				// Initial entry if banner has not been shown
			}
			else {
				$sql_data_array = array($affiliate.'banners_id' => $affiliate_banner_id,
				$affiliate.'banners_products_id' => $affiliate_products_id,
				$affiliate.'banners_affiliate_id' => $_SESSION[$affiliate.'ref'],
				$affiliate.'banners_clicks' => '1',
				$affiliate.'banners_history_date' => $today);
				olc_db_perform(TABLE_AFFILIATE_BANNERS_HISTORY, $sql_data_array);
			}
		}

		// Set Cookie if the customer comes back and orders it counts
		setcookie($affiliate.'ref', $_SESSION[$affiliate.'ref'], time() + AFFILIATE_COOKIE_LIFETIME);
	}
	if ($_COOKIE[$affiliate.'ref']) { // Customer comes back and is registered in cookie
	$_SESSION[$affiliate.'ref'] = $_COOKIE[$affiliate.'ref'];
	}
}

////
// Compatibility to older Snapshots

// set the type of request (secure or not)
if (!isset($request_type)) $request_type = (getenv(HTTPS) != null) ? SSL : NONSSL;
?>
