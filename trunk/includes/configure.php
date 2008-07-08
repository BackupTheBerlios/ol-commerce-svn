<?php
/* --------------------------------------------------------------
OL-Commerce v5/AJAX

Common(!) config for admin and catalog (Modified by W. Kaiser)

http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------

based on:

(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce (configure.php,v 113 2003/02/10); www.oscommerce.com
(c) 2004  		XT - Commerce; www.ol-Commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/
if (function_exists('date_default_timezone_set')) {
   date_default_timezone_set('Europe/Berlin');
}  
//Include external config data (multi-store capability)
if (!isset($level))
{
	$level='';
}
include($level.'inc/olc_get_external_config_data.inc.php');
//Include external config data (multi-store capability)

//
//	Generated on 26.07.2007 17:41:11
//
//	Define the webserver and path parameters
// 	* DIR_FS_* = Filesystem directories (local/physical)
// 	* DIR_WS_* = Webserver directories (virtual/URL)

define('HTTP_SERVER', 'http://localhost'); 									// eg, http://localhost - should not be empty for productive servers
define('HTTPS_SERVER', 'https://localhost'); 								// eg, https://localhost - should not be empty for productive servers
define('HTTP_CATALOG_SERVER', HTTP_SERVER);
define('HTTPS_CATALOG_SERVER', HTTPS_SERVER);
define('ENABLE_SSL',false); 											// secure webserver for checkout procedure?
define('ENABLE_SSL_CATALOG', ENABLE_SSL); 							// secure webserver for catalog module

define('DIR_WS_CATALOG', '/olc/'); 								// absolute path required
define('DIR_FS_DOCUMENT_ROOT', '/var/www/html/olc/');
define('DIR_FS_CATALOG', DIR_FS_DOCUMENT_ROOT);
define('DIR_WS_IMAGES', 'images/');
define('DIR_WS_PRODUCT_IMAGES', DIR_WS_IMAGES . 'product_images/');
define('DIR_WS_ORIGINAL_IMAGES', DIR_WS_PRODUCT_IMAGES . 'original_images/');
define('DIR_WS_THUMBNAIL_IMAGES', DIR_WS_PRODUCT_IMAGES . 'thumbnail_images/');
define('DIR_WS_INFO_IMAGES', DIR_WS_PRODUCT_IMAGES . 'info_images/');
define('DIR_WS_POPUP_IMAGES', DIR_WS_PRODUCT_IMAGES . 'popup_images/');
define('DIR_WS_PROMOTION_IMAGES', DIR_WS_IMAGES .'products_promotions/');
define('DIR_WS_OPTIONS_IMAGES', DIR_WS_IMAGES .'product_options/');
define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
define('DIR_WS_INCLUDES', 'includes/');
define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
define('DIR_WS_LANGUAGES', DIR_FS_CATALOG . 'lang/');
define('DIR_FS_INC', DIR_FS_CATALOG . 'inc/');

// define database connection
define('DB_SERVER', 'localhost'); 											// eg, localhost - should not be empty for productive servers
define('DB_SERVER_USERNAME', 'test');
define('DB_SERVER_PASSWORD', 'testmich');
define('DB_DATABASE', 'olc');

define('USE_PCONNECT', 'false'); 							// use persistent connections?

	//	define ADODB usage bof
	define('USE_ADODB', false); 													// Set to TRUE_STRING_S to use 'ADODB' database access
	define('ADOBD_DB_TYPE', 'mysql'); 										// ADODB database driver to use
		//See http://phplens.com/lens/adodb/docs-adodbhtm#drivers for supported databases
	define('ADOBD_USE_CACHING', false); 									// Set to TRUE_STRING_S to use the ADODB caching facility
	define('ADOBD_CACHING_SECONDS', 3600); 								// Set # of secondes to retain ADODB cached data (3600 is one hour)
	define('ADOBD_USE_STATS', false); 										// Set to TRUE_STRING_S to use 'ADODB' statistics
	define('ADODB_USE_LOGGING', false); 									// Set to TRUE_STRING_S to use 'ADODB' SQL command logging
	//	define ADODB usage eof

	// define database connection

define('STORE_SESSIONS', 'mysql'); 											// store session data in DB

define('ENABLE_AJAX_MODE', true); 											// Set to FALSE_STRING_S if not to use AJAX-mode

// Not functional yet
define('USE_PAYPAL_IPN', false); 												// Set to TRUE_STRING_S to use PayPal with payment feedback
define('USE_PAYPAL_WPP', false); 												// Set to TRUE_STRING_S to use PayPal 'Direct Payment' and 'Express Checkout'
/// Not functional yet
define('TABLE_PREFIX', 'olc_');								// eg, olc_
define('USE_COOL_MENU',true);
?>