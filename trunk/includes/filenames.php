<?php
/* -----------------------------------------------------------------------------------------
$Id: filenames.php,v 1.1.1.1.2.1 2007/04/08 07:17:45 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(filenames.php,v 1.3 2003/05/25); www.oscommerce.com
(c) 2003	    nextcommerce (filenames.php,v 1.21 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// define the filenames used in the project
define('FILENAME_ACCOUNT', 'account.php');
define('FILENAME_ACCOUNT_EDIT', 'account_edit.php');
define('FILENAME_ACCOUNT_HISTORY', 'account_history.php');
define('FILENAME_ACCOUNT_HISTORY_INFO', 'account_history_info.php');
define('FILENAME_ACCOUNT_NEWSLETTERS', 'account_newsletters.php');
define('FILENAME_ACCOUNT_NOTIFICATIONS', 'account_notifications.php');
define('FILENAME_ACCOUNT_PASSWORD', 'account_password.php');
define('FILENAME_ADDRESS_BOOK', 'address_book.php');
define('FILENAME_ADDRESS_BOOK_PROCESS', 'address_book_process.php');
define('FILENAME_ADVANCED_SEARCH', 'advanced_search.php');
define('FILENAME_ADVANCED_SEARCH_RESULT', 'advanced_search_result.php');
define('FILENAME_AJAX_VALIDATION','ajax_validation.php');
define('FILENAME_ALSO_PURCHASED_PRODUCTS', 'also_purchased_products.php');
define('FILENAME_CHECKOUT_ADDRESS', 'checkout_address.php');
define('FILENAME_CHECKOUT_CONFIRMATION', 'checkout_confirmation.php');
define('FILENAME_CHECKOUT_PAYMENT', 'checkout_payment.php');
define('FILENAME_CHECKOUT_PAYMENT_ADDRESS', 'checkout_payment_address.php');
define('FILENAME_CHECKOUT_PROCESS', 'checkout_process.php');
define('FILENAME_CHECKOUT_SHIPPING', 'checkout_shipping.php');
define('FILENAME_CHECKOUT_SHIPPING_ADDRESS', 'checkout_shipping_address.php');
define('FILENAME_CHECKOUT_SUCCESS', 'checkout_success.php');
define('FILENAME_CHECKOUT_AJAX_PAYMENT_PROXY','ajax_payment_proxy.php');
define('FILENAME_COOKIE_USAGE', 'cookie_usage.php');
define('FILENAME_CREATE_ACCOUNT', 'create_account.php');
define('FILENAME_CREATE_ACCOUNT_SUCCESS', 'create_account_success.php');
define('FILENAME_DEFAULT', 'index.php');
define('FILENAME_ORDERS_INVOICE_PDF', 'pdf_invoice.php');
define('FILENAME_ORDERS_PACKINGSLIP_PDF', 'packingslip_pdf.php');
define('FILENAME_DOWNLOAD', 'download.php');
define('FILENAME_DOWNLOADS', 'downloads.php');
define('FILENAME_TOP_PRODUCTS','top_products.php');
define('FILENAME_NEW_PRODUCTS','new_products.php');
define('FILENAME_INFO_SHOPPING_CART', 'info_shopping_cart.php');
define('FILENAME_LOGIN', 'login.php');
define('FILENAME_LOGOFF', 'logoff.php');
define('FILENAME_PASSWORD_FORGOTTEN', 'password_forgotten.php');
define('FILENAME_POPUP_IMAGE', 'popup_image.php');
define('FILENAME_POPUP_SEARCH_HELP', 'popup_search_help.php');
define('FILENAME_PRODUCT_INFO', 'product_info.php');
define('FILENAME_PRODUCTS_ATTRIBUTES', 'product_attributes.php');
define('FILENAME_PRODUCT_LISTING', 'product_listing.php');
define('FILENAME_PRINT_PRODUCT_LISTING', 'print_' . FILENAME_PRODUCT_LISTING);
define('FILENAME_PRODUCT_NOTIFICATIONS', 'product_notifications.php');
define('FILENAME_PRODUCT_REVIEWS', 'product_reviews.php');
define('FILENAME_PRODUCT_REVIEWS_INFO', 'product_reviews_info.php');
define('FILENAME_PRODUCT_REVIEWS_WRITE', 'product_reviews_write.php');
define('FILENAME_PRODUCTS_NEW', 'products_new.php');
define('FILENAME_REDIRECT', 'redirect.php');
define('FILENAME_REVIEWS', 'reviews.php');
define('FILENAME_SHIPPING', 'shipping.php');
define('FILENAME_SHOPPING_CART', 'shopping_cart.php');
define('FILENAME_START', 'admin/start.php');
define('FILENAME_SPECIALS', 'specials.php');
define('FILENAME_SSL_CHECK', 'ssl_check.php');
define('FILENAME_TELL_A_FRIEND', 'tell_a_friend.php');
define('FILENAME_UPCOMING_PRODUCTS', 'upcoming_products.php');
define('FILENAME_CENTER_MODULES','center_modules.php');
define('FILENAME_ORDERS','admin/orders.php');
define('FILENAME_METATAGS','metatags.php');
define('FILENAME_XSELL_PRODUCTS', 'xsell_products.php');
define('FILENAME_PRODUCTS_MEDIA','products_media.php');
define('FILENAME_MEDIA_CONTENT','media_content.php');
define('FILENAME_CREATE_GUEST_ACCOUNT','create_guest_account.php');
define('FILENAME_POPUP_CVV', 'popup_cvv.php'); //cvv contribution
define('FILENAME_CAMPAIGNS', 'campaigns.php');
define('FILENAME_CAMPAIGNS_REPORT','stats_'.FILENAME_CAMPAIGNS);
// Erweiterung für Newsletter
define('FILENAME_CATALOG_NEWSLETTER', 'newsletter.php');

define('FILENAME_GV_FAQ', 'gv_faq.php');
define('FILENAME_GV_REDEEM', 'gv_redeem.php');
define('FILENAME_GV_REDEEM_PROCESS', 'gv_redeem_process.php');
define('FILENAME_GV_SEND', 'gv_send.php');
define('FILENAME_GV_SEND_PROCESS', 'gv_send_process.php');
define('FILENAME_PRODUCT_LISTING_COL', 'product_listing_col.php');
define('FILENAME_POPUP_COUPON_HELP', 'popup_coupon_help.php');

define('FILENAME_EDIT_PRODUCTS','admin/categories.php');
define('FILENAME_METATAGS_PRODUCTS_INFO','metatags_product_info.php');
define('FILENAME_GRADUATED_PRICE','graduated_prices.php');

define('FILENAME_PDF_DATASHEET', 'pdf_datasheet.php');
define('FILENAME_PRINT_PRODUCT_INFO','print_product_info.php');
define('FILENAME_PRINT_ORDER','print_order.php');

define('FILENAME_ERROR_HANDLER', 'error_handler.php');
define('FILENAME_CONTENT','shop_content.php');
define('FILENAME_BANNER','banners.php');
define('FILENAME_SITEMAP','sitemap.php');
define('FILENAME_GALLERY','gallery.php');

// Erweiterung für Newsletter
define('FILENAME_NEWSLETTER','newsletter.php');
//define('FILENAME_VISUAL_VERIFY_CODE_DISPLAY', 'vvc_display.php');
define('FILENAME_DISPLAY_VVCODES', 'display_vvcodes.php');

//W. Kaiser Down for Maintenance
define('FILENAME_DOWN_FOR_MAINTENANCE', 'down_for_maintenance.php');
//W. Kaiser Down for Maintenance

//W. Kaiser Inci Listing
$inci_listing='inci_listing';
define('FILENAME_INCI_LISTING', $inci_listing.PHP);
define('FILENAME_INCI_LISTING_INFO', $inci_listing.'_info.php');
//W. Kaiser Inci Listing

define('FILENAME_PDF_EXPORT', 'pdf_export.php');

//---PayPal WPP Modification START---//
define('FILENAME_EC_PROCESS', 'ec_process.php');
define('FILENAME_PAYPAL_WPP', 'paypal_wpp.php');
define('FILENAME_IPN', 'ipn.php');
define('FILENAME_PAYPAL_IPN', 'paypal'.FILENAME_IPN);
//---PayPal WPP Modification END---//
?>