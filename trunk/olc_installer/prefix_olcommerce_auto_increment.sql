#
#	When changing from MySQL 4 to MySQL 5, it happened, that the
#	"auto_increment" attribute of the key-fields was lost!
#
#	This script will restore the 	"auto_increment" attribute for all tables affected!
#
ALTER TABLE `chc_downloads_and_hyperlinks` CHANGE `id` `id` int(14) unsigned NOT NULL auto_increment,
ALTER TABLE `chc_ignored_users` CHANGE `id` `id` int(14) unsigned NOT NULL auto_increment,
ALTER TABLE `chc_online_users` CHANGE `id` `id` int(14) unsigned NOT NULL auto_increment,
ALTER TABLE `chc_pages` CHANGE `id` `id` int(14) unsigned NOT NULL auto_increment,
ALTER TABLE `chc_referrers` CHANGE `id` `id` int(14) unsigned NOT NULL auto_increment,

ALTER TABLE `livehelp_autoinvite` CHANGE `idnum` `idnum` int(10) NOT NULL auto_increment;
ALTER TABLE `livehelp_channels` CHANGE `id` `id` int(10) NOT NULL auto_increment;
ALTER TABLE `livehelp_departments` CHANGE `recno` `recno` int(5) NOT NULL auto_increment;
ALTER TABLE `livehelp_identity_daily` CHANGE `id` `id` int(11) unsigned NOT NULL auto_increment;
ALTER TABLE `livehelp_identity_monthly` CHANGE `id` `id` int(11) unsigned NOT NULL auto_increment;
ALTER TABLE `livehelp_keywords_daily` CHANGE `recno` `recno` int(11) NOT NULL auto_increment;
ALTER TABLE `livehelp_keywords_monthly` CHANGE `recno` `recno` int(11) NOT NULL auto_increment;
ALTER TABLE `livehelp_leavemessage` CHANGE `id` `id` int(11) unsigned NOT NULL auto_increment;
ALTER TABLE `livehelp_messages` CHANGE `id_num` `id_num` int(10) NOT NULL auto_increment;
ALTER TABLE `livehelp_modules` CHANGE `id` `id` int(10) NOT NULL auto_increment;
ALTER TABLE `livehelp_modules_dep` CHANGE `rec` `rec` int(10) NOT NULL auto_increment;
ALTER TABLE `livehelp_operator_channels` CHANGE `id` `id` int(10) NOT NULL auto_increment;
ALTER TABLE `livehelp_operator_departments` CHANGE `recno` `recno` int(10) NOT NULL auto_increment;
ALTER TABLE `livehelp_operator_history` CHANGE `id` `id` int(11) unsigned NOT NULL auto_increment;
ALTER TABLE `livehelp_paths_firsts` CHANGE `id` `id` int(11) unsigned NOT NULL auto_increment;
ALTER TABLE `livehelp_paths_monthly` CHANGE `id` `id` int(11) unsigned NOT NULL auto_increment;
ALTER TABLE `livehelp_qa` CHANGE `recno` `recno` int(10) NOT NULL auto_increment;
ALTER TABLE `livehelp_questions` CHANGE `id` `id` int(10) NOT NULL auto_increment;
ALTER TABLE `livehelp_quick` CHANGE `id` `id` int(10) NOT NULL auto_increment;
ALTER TABLE `livehelp_referers_daily` CHANGE `recno` `recno` int(11) NOT NULL auto_increment;
ALTER TABLE `livehelp_referers_monthly` CHANGE `recno` `recno` int(11) NOT NULL auto_increment;
ALTER TABLE `livehelp_smilies` CHANGE `smilies_id` `smilies_id` smallint(5) unsigned NOT NULL auto_increment;
ALTER TABLE `livehelp_transcripts` CHANGE `recno` `recno` int(10) NOT NULL auto_increment;
ALTER TABLE `livehelp_users` CHANGE `user_id` `user_id` int(10) NOT NULL auto_increment;
ALTER TABLE `livehelp_visit_track` CHANGE `recno` `recno` int(10) NOT NULL auto_increment;
ALTER TABLE `livehelp_visits_daily` CHANGE `recno` `recno` int(11) NOT NULL auto_increment;
ALTER TABLE `livehelp_visits_monthly` CHANGE `recno` `recno` int(11) NOT NULL auto_increment;

ALTER TABLE `olc_address_book` CHANGE `address_book_id` `address_book_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_address_format` CHANGE `address_format_id` `address_format_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_affiliate_affiliate` CHANGE `affiliate_id` `affiliate_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_affiliate_banners` CHANGE `affiliate_banners_id` `affiliate_banners_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_affiliate_banners_history` CHANGE `affiliate_banners_history_id` `affiliate_banners_history_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_affiliate_clickthroughs` CHANGE `affiliate_clickthrough_id` `affiliate_clickthrough_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_affiliate_payment` CHANGE `affiliate_payment_id` `affiliate_payment_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_affiliate_payment_status_history` CHANGE `affiliate_status_history_id` `affiliate_status_history_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_auction_details` CHANGE `id` `id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_auction_predefinition` CHANGE `predef_id` `predef_id` bigint(20) NOT NULL auto_increment;
ALTER TABLE `olc_banners` CHANGE `banners_id` `banners_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_banners_history` CHANGE `banners_history_id` `banners_history_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_box_configuration` CHANGE `box_id` `box_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_cao_log` CHANGE `id` `id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_card_blacklist` CHANGE `blacklist_id` `blacklist_id` int(5) NOT NULL auto_increment;
ALTER TABLE `olc_categories` CHANGE `categories_id` `categories_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_configuration` CHANGE `configuration_id` `configuration_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_configuration_group` CHANGE `configuration_group_id` `configuration_group_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_content_manager` CHANGE `content_id` `content_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_countries` CHANGE `countries_id` `countries_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_coupon_email_track` CHANGE `unique_id` `unique_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_coupon_gv_queue` CHANGE `unique_id` `unique_id` int(5) NOT NULL auto_increment;
ALTER TABLE `olc_coupon_redeem_track` CHANGE `unique_id` `unique_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_coupons` CHANGE `coupon_id` `coupon_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_currencies` CHANGE `currencies_id` `currencies_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_customers` CHANGE `customers_id` `customers_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_customers_basket` CHANGE `customers_basket_id` `customers_basket_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_customers_basket_attributes` CHANGE `customers_basket_attributes_id` `customers_basket_attributes_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_customers_basket_attributes_save` CHANGE `customers_basket_attributes_id` `customers_basket_attributes_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_customers_basket_save` CHANGE `customers_basket_save_id` `customers_basket_save_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_customers_basket_save_baskets` CHANGE `customers_basket_id` `customers_basket_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_customers_ip` CHANGE `customers_ip_id` `customers_ip_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_customers_memo` CHANGE `memo_id` `memo_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_customers_status_history` CHANGE `customers_status_history_id` `customers_status_history_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_ebay_categories` CHANGE `myid` `myid` bigint(20) NOT NULL auto_increment;
ALTER TABLE `olc_ebay_config` CHANGE `id` `id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_geo_zones` CHANGE `geo_zone_id` `geo_zone_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_languages` CHANGE `languages_id` `languages_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_manufacturers` CHANGE `manufacturers_id` `manufacturers_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_media_content` CHANGE `file_id` `file_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_module_newsletter` CHANGE `newsletter_id` `newsletter_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_newsletter_recipients` CHANGE `mail_id` `mail_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_newsletters` CHANGE `newsletters_id` `newsletters_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_orders` CHANGE `orders_id` `orders_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_orders_products` CHANGE `orders_products_id` `orders_products_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_orders_products_attributes` CHANGE `orders_products_attributes_id` `orders_products_attributes_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_orders_products_download` CHANGE `orders_products_download_id` `orders_products_download_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_orders_recalculate` CHANGE `orders_recalculate_id` `orders_recalculate_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_orders_status_history` CHANGE `orders_status_history_id` `orders_status_history_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_orders_total` CHANGE `orders_total_id` `orders_total_id` int(10) unsigned NOT NULL auto_increment;
ALTER TABLE `olc_paypal` CHANGE `paypal_id` `paypal_id` int(11) unsigned NOT NULL auto_increment;
ALTER TABLE `olc_paypal_payment_status_history` CHANGE `payment_status_history_id` `payment_status_history_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_personal_offers_by_customers_status_0` CHANGE `price_id` `price_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_personal_offers_by_customers_status_1` CHANGE `price_id` `price_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_personal_offers_by_customers_status_2` CHANGE `price_id` `price_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_products` CHANGE `products_id` `products_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_products_attributes` CHANGE `products_attributes_id` `products_attributes_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_products_content` CHANGE `content_id` `content_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_products_images` CHANGE `image_id` `image_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_products_options_values_to_products_options` CHANGE `products_options_values_to_products_options_id` `products_options_values_to_products_options_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_products_xsell` CHANGE `ID` `ID` int(10) NOT NULL auto_increment;
ALTER TABLE `olc_reviews` CHANGE `reviews_id` `reviews_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_specials` CHANGE `specials_id` `specials_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_tax_class` CHANGE `tax_class_id` `tax_class_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_tax_rates` CHANGE `tax_rates_id` `tax_rates_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_zones` CHANGE `zone_id` `zone_id` int(11) NOT NULL auto_increment;
ALTER TABLE `olc_zones_to_geo_zones` CHANGE `association_id` `association_id` int(11) NOT NULL auto_increment;
