# -----------------------------------------------------------------------------------------
#  $Id: prefix_rename_tables.sql
#
#  OL-Commerce Version 2.0
#  http://www.ol-commerce.com
#
#  Copyright (c) 2004 OL-Commerce
#  -----------------------------------------------------------------------------------------
#  Third Party Contributions:
#  Customers status v3.x (c) 2002-2003 Elari elari@free.fr
#  Download area : www.unlockgsm.com/dload-osc/
#  CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/èsortby=date#dirlist
#  BMC 2003 for the CC CVV Module
#  --------------------------------------------------------------
#  based on:
#  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
#  (c) 2002-2003 osCommerce (oscommerce.sql,v 1.83); www.oscommerce.com
#  (c) 2003	    nextcommerce (nextcommerce.sql,v 1.76 2003/08/25); www.nextcommerce.org
#
#  (c) 2004      XT - Commerce; www.xt-commerce.com
#  (c) 2005  OL-commerce; www.ol-commerce.com
#  (c) 2006  Dipl.-Ing.(TH) W. Kaiser ; www.seifenparadies.de
#
#  Released under the GNU General Public License
#
#	Rename OLC database tables to table-names with a prefix
#
#	Replace "olc_" with the prefix you want (e.g. "ol1_")
#
#	In order to be able to access the tables still, you need to include
#
#	define('TABLE_PREFIX','olc_');
#
#	into
#
#	includes\configure.php
#	admin\includes\configure.php
#
#  --------------------------------------------------------------
#
RENAME TABLE address_book TO olc_address_book;
RENAME TABLE address_format TO olc_address_format;
RENAME TABLE admin_access TO olc_admin_access;
RENAME TABLE affiliate_affiliate TO olc_affiliate_affiliate;
RENAME TABLE affiliate_banners TO olc_affiliate_banners;
RENAME TABLE affiliate_banners_history TO olc_affiliate_banners_history;
RENAME TABLE affiliate_clickthroughs TO olc_affiliate_clickthroughs;
RENAME TABLE affiliate_payment TO olc_affiliate_payment;
RENAME TABLE affiliate_payment_status TO olc_affiliate_payment_status;
RENAME TABLE affiliate_payment_status_history TO olc_affiliate_payment_status_history;
RENAME TABLE affiliate_sales TO olc_affiliate_sales;
RENAME TABLE banktransfer TO olc_banktransfer;
RENAME TABLE banners TO olc_banners;
RENAME TABLE banners_history TO olc_banners_history;
RENAME TABLE cao_log TO olc_cao_log;
RENAME TABLE card_blacklist TO olc_card_blacklist;
RENAME TABLE categories TO olc_categories;
RENAME TABLE categories_description TO olc_categories_description;
RENAME TABLE cm_file_flags TO olc_cm_file_flags;
RENAME TABLE configuration TO olc_configuration;
RENAME TABLE configuration_group TO olc_configuration_group;
RENAME TABLE content_manager TO olc_content_manager;
RENAME TABLE counter TO olc_counter;
RENAME TABLE counter_history TO olc_counter_history;
RENAME TABLE countries TO olc_countries;
RENAME TABLE coupons TO olc_coupons;
RENAME TABLE coupons_description TO olc_coupons_description;
RENAME TABLE coupon_email_track TO olc_coupon_email_track;
RENAME TABLE coupon_gv_customer TO olc_coupon_gv_customer;
RENAME TABLE coupon_gv_queue TO olc_coupon_gv_queue;
RENAME TABLE coupon_redeem_track TO olc_coupon_redeem_track;
RENAME TABLE currencies TO olc_currencies;
RENAME TABLE customers TO olc_customers;
RENAME TABLE customers_basket TO olc_customers_basket;
RENAME TABLE customers_basket_attributes TO olc_customers_basket_attributes;
RENAME TABLE customers_info TO olc_customers_info;
RENAME TABLE customers_ip TO olc_customers_ip;
RENAME TABLE customers_memo TO olc_customers_memo;
RENAME TABLE customers_status TO olc_customers_status;
RENAME TABLE customers_status_history TO olc_customers_status_history;
RENAME TABLE geo_zones TO olc_geo_zones;
RENAME TABLE languages TO olc_languages;
RENAME TABLE manufacturers TO olc_manufacturers;
RENAME TABLE manufacturers_info TO olc_manufacturers_info;
RENAME TABLE media_content TO olc_media_content;
RENAME TABLE module_newsletter TO olc_module_newsletter;
RENAME TABLE newsletters TO olc_newsletters;
RENAME TABLE newsletters_history TO olc_newsletters_history;
RENAME TABLE newsletter_recipients TO olc_newsletter_recipients;
RENAME TABLE orders TO olc_orders;
RENAME TABLE orders_products TO olc_orders_products;
RENAME TABLE orders_products_attributes TO olc_orders_products_attributes;
RENAME TABLE orders_products_download TO olc_orders_products_download;
RENAME TABLE orders_recalculate TO olc_orders_recalculate;
RENAME TABLE orders_status TO olc_orders_status;
RENAME TABLE orders_status_history TO olc_orders_status_history;
RENAME TABLE orders_total TO olc_orders_total;
RENAME TABLE payment_moneybookers TO olc_payment_moneybookers;
RENAME TABLE payment_moneybookers_countries TO olc_payment_moneybookers_countries;
RENAME TABLE payment_moneybookers_currencies TO olc_payment_moneybookers_currencies;
RENAME TABLE personal_offers_by_customers_status_0 TO olc_personal_offers_by_customers_status_0;
RENAME TABLE personal_offers_by_customers_status_1 TO olc_personal_offers_by_customers_status_1;
RENAME TABLE personal_offers_by_customers_status_2 TO olc_personal_offers_by_customers_status_2;
RENAME TABLE products TO olc_products;
RENAME TABLE products_attributes TO olc_products_attributes;
RENAME TABLE products_attributes_download TO olc_products_attributes_download;
RENAME TABLE products_content TO olc_products_content;
RENAME TABLE products_description TO olc_products_description;
RENAME TABLE products_graduated_prices TO olc_products_graduated_prices;
RENAME TABLE products_images TO olc_products_images;
RENAME TABLE products_notifications TO olc_products_notifications;
RENAME TABLE products_options TO olc_products_options;
RENAME TABLE products_options_values TO olc_products_options_values;
RENAME TABLE products_options_values_to_products_options TO olc_products_options_values_to_products_options;
RENAME TABLE products_to_categories TO olc_products_to_categories;
RENAME TABLE products_vpe TO olc_products_vpe;
RENAME TABLE products_xsell TO olc_products_xsell;
RENAME TABLE reviews TO olc_reviews;
RENAME TABLE reviews_description TO olc_reviews_description;
RENAME TABLE sessions TO olc_sessions;
RENAME TABLE shipping_status TO olc_shipping_status;
RENAME TABLE specials TO olc_specials;
RENAME TABLE tax_class TO olc_tax_class;
RENAME TABLE tax_rates TO olc_tax_rates;
RENAME TABLE whos_online TO olc_whos_online;
RENAME TABLE zones TO olc_zones;
RENAME TABLE zones_to_geo_zones TO olc_zones_to_geo_zones;
