<?php
/* -----------------------------------------------------------------------------------------
$Id: database_tables.php,v 1.1.1.1.2.1 2007/04/08 07:17:45 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(database_tables.php,v 1.1 2003/03/14); www.oscommerce.com
(c) 2003	    nextcommerce (database_tables.php,v 1.8 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX
//Common for user and admin
//W. Kaiser - AJAX
// define the database table names used in the project

//W. Kaiser Allow table prefix
$s='TABLE_PREFIX';
if (!defined($s))
{
	define($s, EMPTY_STRING);
}
$s='TABLE_PREFIX_INDIVIDUAL_DATA';
if (!defined($s))
{
	define($s, TABLE_PREFIX);
}
//Multi-DB feature
$term="`";
$s='DB_DATABASE_1';
if (!defined($s))
{
	define($s, DB_DATABASE);
}
$db_database=$term.DB_DATABASE.$term.DOT;
$db_database_1=$term.DB_DATABASE_1.$term.DOT;
define('TABLE_PREFIX_COMMON',$db_database.TABLE_PREFIX);
define('TABLE_PREFIX_INDIVIDUAL',$db_database_1.TABLE_PREFIX_INDIVIDUAL_DATA);
if (!$prefix_only)
{
	define('TABLE_ADDRESS_BOOK',TABLE_PREFIX_INDIVIDUAL.'address_book');
	define('TABLE_ADDRESS_FORMAT',TABLE_PREFIX_COMMON.'address_format');
	define('TABLE_ADMIN_ACCESS',TABLE_PREFIX_INDIVIDUAL.'admin_access');
	define('TABLE_BANKTRANSFER',TABLE_PREFIX_INDIVIDUAL.'banktransfer');
	define('TABLE_BANKTRANSFER_BLZ',TABLE_PREFIX_COMMON.'banktransfer_blz');
	define('TABLE_BANNERS',TABLE_PREFIX_INDIVIDUAL.'banners');
	define('TABLE_BANNERS_HISTORY',TABLE_BANNERS.'_history');
	define('TABLE_BLACKLIST',TABLE_PREFIX_INDIVIDUAL.'card_blacklist');
	define('TABLE_CATEGORIES',TABLE_PREFIX_COMMON.'categories');
	define('TABLE_CATEGORIES_DESCRIPTION',TABLE_CATEGORIES.'_description');
	define('TABLE_CM_FILE_FLAGS',TABLE_PREFIX_COMMON.'cm_file_flags');
	define('TABLE_CONFIGURATION',TABLE_PREFIX_INDIVIDUAL.'configuration');
	define('TABLE_CONFIGURATION_GROUP',TABLE_CONFIGURATION.'_group');
	define('TABLE_CONTENT_MANAGER',TABLE_PREFIX_INDIVIDUAL.'content_manager');
	define('TABLE_COUNTRIES',TABLE_PREFIX_COMMON.'countries');
	define('TABLE_COUPON',TABLE_PREFIX_INDIVIDUAL.'coupon');
	define('TABLE_COUPON_EMAIL_TRACK',TABLE_COUPON.'_email_track');
	define('TABLE_COUPON_GV_CUSTOMER',TABLE_COUPON.'_gv_customer');
	define('TABLE_COUPON_GV_QUEUE',TABLE_COUPON.'_gv_queue');
	define('TABLE_COUPON_REDEEM_TRACK',TABLE_COUPON.'_redeem_track');
	define('TABLE_COUPONS',TABLE_PREFIX_INDIVIDUAL.'coupons');
	define('TABLE_COUPONS_DESCRIPTION',TABLE_COUPONS.'_description');
	define('TABLE_CURRENCIES',TABLE_PREFIX_COMMON.'currencies');
	define('TABLE_CUSTOMERS',TABLE_PREFIX_INDIVIDUAL.'customers');
	define('TABLE_CUSTOMERS_BASKET',TABLE_CUSTOMERS.'_basket');
	define('TABLE_CUSTOMERS_BASKET_ATTRIBUTES',TABLE_CUSTOMERS_BASKET.'_attributes');
	define('TABLE_CUSTOMERS_BASKET_SAVE',TABLE_CUSTOMERS_BASKET.'_save');
	define('TABLE_CUSTOMERS_BASKET_SAVE_BASKETS',TABLE_CUSTOMERS_BASKET_SAVE.'_baskets');
	define('TABLE_CUSTOMERS_BASKET_ATTRIBUTES_SAVE',TABLE_CUSTOMERS_BASKET_ATTRIBUTES.'_save');
	define('TABLE_CUSTOMERS_INFO',TABLE_CUSTOMERS.'_info');
	define('TABLE_CUSTOMERS_IP',TABLE_CUSTOMERS.'_ip');
	define('TABLE_CUSTOMERS_MEMO',TABLE_CUSTOMERS.'_memo');
	define('TABLE_CUSTOMERS_STATUS',TABLE_CUSTOMERS.'_status');
	define('TABLE_CUSTOMERS_STATUS_HISTORY',TABLE_CUSTOMERS_STATUS.'_history');
	define('TABLE_GEO_ZONES',TABLE_PREFIX_COMMON.'geo_zones');
	define('TABLE_LANGUAGES',TABLE_PREFIX_COMMON.'languages');
	define('TABLE_MANUFACTURERS',TABLE_PREFIX_INDIVIDUAL.'manufacturers');
	define('TABLE_MANUFACTURERS_INFO',TABLE_MANUFACTURERS.'_info');
	define('TABLE_MEDIA_CONTENT',TABLE_PREFIX_INDIVIDUAL.'media_content');
	define('TABLE_MODULE_NEWSLETTER',TABLE_PREFIX_INDIVIDUAL.'module_newsletter');
	define('TABLE_MODULE_NEWSLETTER_TEMP',TABLE_MODULE_NEWSLETTER.'temp_');
	define('TABLE_NEWSLETTERS',TABLE_PREFIX_INDIVIDUAL.'newsletters');
	define('TABLE_NEWSLETTERS_HISTORY',TABLE_NEWSLETTERS.'_history');
	define('TABLE_NEWSLETTER_RECIPIENTS',TABLE_PREFIX_INDIVIDUAL.'newsletter_recipients');
	define('TABLE_ORDERS',TABLE_PREFIX_INDIVIDUAL.'orders');
	define('TABLE_ORDERS_PRODUCTS',TABLE_ORDERS.'_products');
	define('TABLE_ORDERS_PRODUCTS_ATTRIBUTES',TABLE_ORDERS_PRODUCTS.'_attributes');
	define('TABLE_ORDERS_PRODUCTS_DOWNLOAD',TABLE_ORDERS_PRODUCTS.'_download');
	define('ORDERS_SESSION_INFO',TABLE_PREFIX_INDIVIDUAL.'orders_session_info');
	define('PAYPAL',TABLE_PREFIX_INDIVIDUAL.'paypal');
	define('PAYPAL_PAYMENT_STATUS_HISTORY',TABLE_PREFIX_INDIVIDUAL.'paypal_payment_status_history');
	define('PAYPAL_AUCTION',TABLE_PREFIX_INDIVIDUAL.'paypal_auction');
	define('TABLE_ORDERS_STATUS',TABLE_PREFIX_COMMON.'orders_status');
	define('TABLE_ORDERS_STATUS_HISTORY',TABLE_ORDERS_STATUS.'_history');
	define('TABLE_ORDERS_TOTAL',TABLE_ORDERS.'_total');
	define('TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS',TABLE_PREFIX_INDIVIDUAL.'personal_offers_by_customers_status_');
  define('TABLE_PERSONAL_OFFERS_BY',TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS);
	$s='payment_moneybookers';
	define('TABLE_PAYMENT_MONEYBOOKERS',TABLE_PREFIX_INDIVIDUAL.$s);
	define('TABLE_PAYMENT_MONEYBOOKERS_COUNTRIES',TABLE_PREFIX_INDIVIDUAL.$s.'_countries');
	define('TABLE_PAYMENT_MONEYBOOKERS_CURRENCIES',TABLE_PREFIX_INDIVIDUAL.$s.'_currencies');
	define('TABLE_PLZ',TABLE_PREFIX_COMMON.'plz');
	define('TABLE_PRODUCTS',TABLE_PREFIX_COMMON.'products');
	define('TABLE_PRODUCTS_ATTRIBUTES',TABLE_PRODUCTS.'_attributes');
	define('TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD',TABLE_PRODUCTS_ATTRIBUTES.'_download');
	define('TABLE_PRODUCTS_CONTENT',TABLE_PRODUCTS.'_content');
	define('TABLE_PRODUCTS_DESCRIPTION',TABLE_PRODUCTS.'_description');
	define('TABLE_PRODUCTS_IMAGES',TABLE_PRODUCTS.'_images');
	define('TABLE_PRODUCTS_NOTIFICATIONS',TABLE_PRODUCTS.'_notifications');
	define('TABLE_PRODUCTS_OPTIONS',TABLE_PRODUCTS.'_options');
	define('TABLE_PRODUCTS_OPTIONS_VALUES',TABLE_PRODUCTS_OPTIONS.'_values');
	define('TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS',TABLE_PRODUCTS_OPTIONS_VALUES.'_to_products_options');
	define('TABLE_PRODUCTS_TO_CATEGORIES',TABLE_PRODUCTS.'_to_categories');
	define('TABLE_PRODUCTS_VPE',TABLE_PREFIX_COMMON.'products_vpe');
	define('TABLE_PRODUCTS_XSELL',TABLE_PRODUCTS.'_xsell');
	define('TABLE_REVIEWS',TABLE_PREFIX_COMMON.'reviews');
	define('TABLE_REVIEWS_DESCRIPTION',TABLE_REVIEWS.'_description');
	define('TABLE_SESSIONS',TABLE_PREFIX_INDIVIDUAL.'sessions');
	define('TABLE_SHIPPING_STATUS',TABLE_PREFIX_COMMON.'shipping_status');
	define('TABLE_SPECIALS',TABLE_PREFIX_INDIVIDUAL.'specials');
	define('TABLE_TAX_CLASS',TABLE_PREFIX_COMMON.'tax_class');
	define('TABLE_TAX_RATES',TABLE_PREFIX_COMMON.'tax_rates');
	define('TABLE_VORNAMEN',TABLE_PREFIX_COMMON.'vornamen');
	define('TABLE_WHOS_ONLINE',TABLE_PREFIX_INDIVIDUAL.'whos_online');
	define('TABLE_WHOS_ONLINE_DATA',TABLE_WHOS_ONLINE.'_data');
	define('TABLE_ZONES',TABLE_PREFIX_COMMON.'zones');
	define('TABLE_ZONES_TO_GEO_ZONES',TABLE_PREFIX_COMMON.'zones_to_geo_zones');
	define('TABLE_BOX_CONFIGURATION',TABLE_PREFIX_INDIVIDUAL.'box_configuration');
  define('TABLE_CAMPAIGNS', TABLE_PREFIX_INDIVIDUAL.'campaigns');
  define('TABLE_CAMPAIGNS_IP',TABLE_PREFIX_INDIVIDUAL.'campaigns_ip');
	//Auction lister
	define('TABLE_AUCTION_DETAILS',TABLE_PREFIX_INDIVIDUAL.'auction_details');
	define('TABLE_AUCTION_LIST',TABLE_PREFIX_INDIVIDUAL.'auction_list');
	define('TABLE_AUCTION_PREDEFINITION',TABLE_PREFIX_INDIVIDUAL.'auction_predefinition');
	define('TABLE_EBAY_AUCTIONTYPE',TABLE_PREFIX_INDIVIDUAL.'ebay_auctiontype');
	define('TABLE_EBAY_CATEGORIES',TABLE_PREFIX_INDIVIDUAL.'ebay_categories');
	define('TABLE_EBAY_CONFIG',TABLE_PREFIX_INDIVIDUAL.'ebay_config');
	define('TABLE_EBAY_PRODUCTS',TABLE_PREFIX_INDIVIDUAL.'ebay_products');
}
?>