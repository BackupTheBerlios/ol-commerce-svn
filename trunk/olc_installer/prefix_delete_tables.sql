# -----------------------------------------------------------------------------------------
#  $Id: prefix_delete_tables.sql
#
#  OL-Commerce Version 2.0
#  http://www.ol-commerce.com
#
#  (c) 2006  			Dipl.-Ing.(TH) W. Kaiser ; www.seifenparadies.de
#
#  Released under the GNU General Public License
#
#	Delete OLC database tables
#
#	Replace "olc_" with the prefix you want (e.g. "ol1_")
#
#  --------------------------------------------------------------
#
DROP TABLE olc_address_book;
DROP TABLE olc_address_format;
DROP TABLE olc_admin_access;
DROP TABLE olc_affiliate_affiliate;
DROP TABLE olc_affiliate_banners;
DROP TABLE olc_affiliate_banners_history;
DROP TABLE olc_affiliate_clickthroughs;
DROP TABLE olc_affiliate_payment;
DROP TABLE olc_affiliate_payment_status;
DROP TABLE olc_affiliate_payment_status_history;
DROP TABLE olc_affiliate_sales;
DROP TABLE olc_banktransfer;
DROP TABLE olc_banktransfer_blz;
DROP TABLE olc_banners;
DROP TABLE olc_banners_history;
DROP TABLE olc_box_configuration;
DROP TABLE olc_cao_log;
DROP TABLE olc_card_blacklist;
DROP TABLE olc_categories;
DROP TABLE olc_categories_description;
DROP TABLE olc_cm_file_flags;
DROP TABLE olc_configuration;
DROP TABLE olc_configuration_group;
DROP TABLE olc_content_manager;
DROP TABLE olc_counter;
DROP TABLE olc_counter_history;
DROP TABLE olc_countries;
DROP TABLE olc_coupons;
DROP TABLE olc_coupons_description;
DROP TABLE olc_coupon_email_track;
DROP TABLE olc_coupon_gv_customer;
DROP TABLE olc_coupon_gv_queue;
DROP TABLE olc_coupon_redeem_track;
DROP TABLE olc_currencies;
DROP TABLE olc_customers;
DROP TABLE olc_customers_basket;
DROP TABLE olc_customers_basket_attributes;
DROP TABLE olc_customers_basket_attributes_save;
DROP TABLE olc_customers_basket_save;
DROP TABLE olc_customers_basket_save_baskets;
DROP TABLE olc_customers_info;
DROP TABLE olc_customers_ip;
DROP TABLE olc_customers_memo;
DROP TABLE olc_customers_status;
DROP TABLE olc_customers_status_history;
DROP TABLE olc_geo_zones;
DROP TABLE olc_languages;
DROP TABLE olc_manufacturers;
DROP TABLE olc_manufacturers_info;
DROP TABLE olc_media_content;
DROP TABLE olc_module_newsletter;
DROP TABLE olc_newsletters;
DROP TABLE olc_newsletters_history;
DROP TABLE olc_newsletter_recipients;
DROP TABLE olc_orders;
DROP TABLE olc_orders_products;
DROP TABLE olc_orders_products_attributes;
DROP TABLE olc_orders_products_download;
DROP TABLE olc_orders_recalculate;
DROP TABLE olc_orders_session_info;
DROP TABLE olc_orders_status;
DROP TABLE olc_orders_status_history;
DROP TABLE olc_orders_total;
DROP TABLE olc_payment_moneybookers;
DROP TABLE olc_payment_moneybookers_countries;
DROP TABLE olc_payment_moneybookers_currencies;
DROP TABLE olc_paypal;
DROP TABLE olc_paypal_auction;
DROP TABLE olc_paypal_payment_status_history;
DROP TABLE olc_personal_offers_by_customers_status_0;
DROP TABLE olc_personal_offers_by_customers_status_1;
DROP TABLE olc_personal_offers_by_customers_status_2;
DROP TABLE olc_plz;
DROP TABLE olc_products;
DROP TABLE olc_products_attributes;
DROP TABLE olc_products_attributes_download;
DROP TABLE olc_products_content;
DROP TABLE olc_products_description;
DROP TABLE olc_products_graduated_prices;
DROP TABLE olc_products_images;
DROP TABLE olc_products_notifications;
DROP TABLE olc_products_options;
DROP TABLE olc_products_options_values;
DROP TABLE olc_products_options_values_to_products_options;
DROP TABLE olc_products_to_categories;
DROP TABLE olc_products_vpe;
DROP TABLE olc_products_xsell;
DROP TABLE olc_reviews;
DROP TABLE olc_reviews_description;
DROP TABLE olc_sessions;
DROP TABLE olc_shipping_status;
DROP TABLE olc_specials;
DROP TABLE olc_tax_class;
DROP TABLE olc_tax_rates;
DROP TABLE olc_vornamen;
DROP TABLE olc_whos_online;
DROP TABLE olc_whos_online_data;
DROP TABLE olc_zones;
DROP TABLE olc_zones_to_geo_zones;
DROP TABLE olc_auction_details;
DROP TABLE olc_auction_list;
DROP TABLE olc_auction_predefinition;
DROP TABLE olc_ebay_auctiontype;
DROP TABLE olc_ebay_categories;
DROP TABLE olc_ebay_config;
DROP TABLE olc_ebay_products;
