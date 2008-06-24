#SET SESSION sql_mode='';
#
#!!!!!Für MySQL 5 das Zeichen '#' in der 1. Zeile entfernen!!!!!
#
# -----------------------------------------------------------------------------------------
#  $Id: prefix_olcommerce_individual.sql,v 1.1.1.1.2.1 2007/04/08 07:18:33 gswkaiser Exp $
#
#  OL-Commerce Version 2.0
#  http://www.ol-commerce.com
#
#  Copyright (c) 2004 OL-Commerce
#  -----------------------------------------------------------------------------------------
#  Third Party Contributions:
#  Customers status v3.x (c) 2002-2003 Elari elari@free.fr
#  Download area : www.unlockgsm.com/dload-osc/
#  CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
#  BMC 2003 for the CC CVV Module
#  --------------------------------------------------------------
#  based on:
#  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
#  (c) 2002-2003 osCommerce (oscommerce.sql,v 1.83); www.oscommerce.com
#  (c) 2003	     nextcommerce (nextcommerce.sql,v 1.76 2003/08/25); www.nextcommerce.org
#
#  (c) 2004      XT - Commerce; www.xt-commerce.com
#  (c) 2005  		 OL-commerce; www.ol-commerce.com
#  (c) 2006      Dipl.-Ing.(TH) W. Kaiser; www.seifenparadies.de
#
#  Released under the GNU General Public License
#
#  --------------------------------------------------------------
# NOTE: * Please make any modifications to this file by hand!
#       * DO NOT use a mysqldump created file for new changes!
#       * Please take note of the table structure, and use this
#         structure as a standard for future modifications!
#       * Any tables you add here should be added in admin/backup.php
#         and in catalog/install/includes/functions/database.php
#       * To see the 'diff'erence between MySQL databases, use
#         the mysqldiff perl script located in the extras
#         directory of the 'catalog' module.
#       * Comments should be like these, full line comments.
#         (don't use inline comments)
#  --------------------------------------------------------------

DROP TABLE IF EXISTS prf_address_book;
CREATE TABLE IF NOT EXISTS prf_address_book (
  address_book_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  entry_gender char(1) NOT NULL default '',
  entry_company varchar(32) default NULL,
  entry_firstname varchar(32) NOT NULL default '',
  entry_lastname varchar(32) NOT NULL default '',
  entry_street_address varchar(64) NOT NULL default '',
  entry_suburb varchar(32) default NULL,
  entry_postcode varchar(10) NOT NULL default '',
  entry_city varchar(32) NOT NULL default '',
  entry_state varchar(32) default NULL,
  entry_country_id int(11) NOT NULL default '0',
  entry_zone_id int(11) NOT NULL default '0',
  PRIMARY KEY (address_book_id),
  KEY idx_address_book_customers_id (customers_id)
);

DROP TABLE IF EXISTS prf_admin_access;
CREATE TABLE IF NOT EXISTS prf_admin_access (
  customers_id varchar(32) NOT NULL default '0',
  configuration int(1) NOT NULL default '0',
  modules int(1) NOT NULL default '0',
  countries int(1) NOT NULL default '0',
  currencies int(1) NOT NULL default '0',
  zones int(1) NOT NULL default '0',
  geo_zones int(1) NOT NULL default '0',
  tax_classes int(1) NOT NULL default '0',
  tax_rates int(1) NOT NULL default '0',
  accounting int(1) NOT NULL default '0',
  backup int(1) NOT NULL default '0',
  cache int(1) NOT NULL default '0',
  server_info int(1) NOT NULL default '0',
  whos_online int(1) NOT NULL default '0',
  languages int(1) NOT NULL default '0',
  define_language int(1) NOT NULL default '0',
  orders_status int(1) NOT NULL default '0',
  shipping_status int(1) NOT NULL default '0',
  module_export int(1) NOT NULL default '0',
  customers int(1) NOT NULL default '0',
  create_account int(1) NOT NULL default '0',
  customers_status int(1) NOT NULL default '0',
  orders int(1) NOT NULL default '0',
  print_packingslip int(1) NOT NULL default '0',
  print_order int(1) NOT NULL default '0',
  popup_memo int(1) NOT NULL default '0',
  coupon_admin int(1) NOT NULL default '0',
  gv_queue int(1) NOT NULL default '0',
  gv_mail int(1) NOT NULL default '0',
  gv_sent int(1) NOT NULL default '0',
  validproducts int(1) NOT NULL default '0',
  validcategories int(1) NOT NULL default '0',
  mail int(1) NOT NULL default '0',
  categories int(1) NOT NULL default '0',
  new_attributes int(1) NOT NULL default '0',
  products_attributes int(1) NOT NULL default '0',
  manufacturers int(1) NOT NULL default '0',
  reviews int(1) NOT NULL default '0',
  specials int(1) NOT NULL default '0',
  stats_products_expected int(1) NOT NULL default '0',
  stats_products_viewed int(1) NOT NULL default '0',
  stats_products_purchased int(1) NOT NULL default '0',
  stats_customers int(1) NOT NULL default '0',
  stats_sales_report int(1) NOT NULL default '0',
  banner_manager int(1) NOT NULL default '0',
  banner_statistics int(1) NOT NULL default '0',
  module_newsletter int(1) NOT NULL default '0',
  xml_export int(1) NOT NULL default '0',
  start int(1) NOT NULL default '0',
  content_manager int(1) NOT NULL default '0',
  content_preview int(1) NOT NULL default '0',
  credits int(1) NOT NULL default '0',
  blacklist int(1) NOT NULL default '0',
  orders_edit int(1) NOT NULL default '0',
  xsell_products int(1) NOT NULL default '0',
  affiliate_affiliates int(1) default NULL,
  affiliate_banners int(1) default NULL,
  affiliate_clicks int(1) default NULL,
  affiliate_contact int(1) default NULL,
  affiliate_invoice int(1) default NULL,
  affiliate_payment int(1) default NULL,
  affiliate_popup_image int(1) default NULL,
  affiliate_sales int(1) default NULL,
  affiliate_statistics int(1) default NULL,
  affiliate_summary int(1) default NULL,
  easypopulate int(1) default NULL,
  froogle int(1) default NULL,
  down_for_maintenance int(1) NOT NULL default '0',
  attributeManager int(1) NOT NULL default '0',
  google_sitemap int(1) NOT NULL default '0',
  elmar_start int(1) NOT NULL default '0',
  blz_update int(1) NOT NULL default '0',
  livehelp int(1) NOT NULL default '0',
  products_uvp int(1) NOT NULL default '0',
  products_vpe int(1) NOT NULL default '0',
  pdf_export int(1) NOT NULL default '0',
  pdf_datasheet int(1) NOT NULL default '0',
  listcategories int(1) NOT NULL default '0',
  listproducts int(1) NOT NULL default '0',
  chCounter int(1) NOT NULL default '0',
  paypal_ipn int(1) NOT NULL default '0',
  eazysales int(1) NOT NULL default '0',
	ebay int(1)  NOT NULL default '0',
  campaigns int(1) NOT NULL default '0',
  stats_campaigns int(1) NOT NULL default '0',
  import_export int(1) NOT NULL default '0',
  PRIMARY KEY (customers_id)
);

DROP TABLE IF EXISTS prf_affiliate_affiliate;
CREATE TABLE IF NOT EXISTS prf_affiliate_affiliate (
  affiliate_id int(11) NOT NULL auto_increment,
  affiliate_lft int(11) NOT NULL default '0',
  affiliate_rgt int(11) NOT NULL default '0',
  affiliate_root int(11) NOT NULL default '0',
  affiliate_gender char(1) NOT NULL default '',
  affiliate_firstname varchar(32) NOT NULL default '',
  affiliate_lastname varchar(32) NOT NULL default '',
  affiliate_dob datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_email_address varchar(96) NOT NULL default '',
  affiliate_telephone varchar(32) NOT NULL default '',
  affiliate_fax varchar(32) NOT NULL default '',
  affiliate_password varchar(40) NOT NULL default '',
  affiliate_homepage varchar(96) NOT NULL default '',
  affiliate_street_address varchar(64) NOT NULL default '',
  affiliate_suburb varchar(64) NOT NULL default '',
  affiliate_city varchar(32) NOT NULL default '',
  affiliate_postcode varchar(10) NOT NULL default '',
  affiliate_state varchar(32) NOT NULL default '',
  affiliate_country_id int(11) NOT NULL default '0',
  affiliate_zone_id int(11) NOT NULL default '0',
  affiliate_agb tinyint(4) NOT NULL default '0',
  affiliate_company varchar(60) NOT NULL default '',
  affiliate_company_taxid varchar(64) NOT NULL default '',
  affiliate_commission_percent decimal(4,2) NOT NULL default '0.00',
  affiliate_payment_check varchar(100) NOT NULL default '',
  affiliate_payment_paypal varchar(64) NOT NULL default '',
  affiliate_payment_bank_name varchar(64) NOT NULL default '',
  affiliate_payment_bank_branch_number varchar(64) NOT NULL default '',
  affiliate_payment_bank_swift_code varchar(64) NOT NULL default '',
  affiliate_payment_bank_account_name varchar(64) NOT NULL default '',
  affiliate_payment_bank_account_number varchar(64) NOT NULL default '',
  affiliate_date_of_last_logon datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_number_of_logons int(11) NOT NULL default '0',
  affiliate_date_account_created datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_date_account_last_modified datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (affiliate_id),
  KEY affiliate_root (affiliate_root),
  KEY affiliate_rgt (affiliate_rgt),
  KEY affiliate_lft (affiliate_lft)
);

DROP TABLE IF EXISTS prf_affiliate_banners;
CREATE TABLE IF NOT EXISTS prf_affiliate_banners (
  affiliate_banners_id int(11) NOT NULL auto_increment,
  affiliate_banners_title varchar(64) NOT NULL default '',
  affiliate_products_id int(11) NOT NULL default '0',
  affiliate_banners_image varchar(64) NOT NULL default '',
  affiliate_banners_group varchar(10) NOT NULL default '',
  affiliate_banners_html_text text,
  affiliate_expires_impressions int(7) default '0',
  affiliate_expires_date datetime default NULL,
  affiliate_date_scheduled datetime default NULL,
  affiliate_date_added datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_date_status_change datetime default NULL,
  affiliate_status int(1) NOT NULL default '1',
  PRIMARY KEY (affiliate_banners_id)
);

DROP TABLE IF EXISTS prf_affiliate_banners_history;
CREATE TABLE IF NOT EXISTS prf_affiliate_banners_history (
  affiliate_banners_history_id int(11) NOT NULL auto_increment,
  affiliate_banners_products_id int(11) NOT NULL default '0',
  affiliate_banners_id int(11) NOT NULL default '0',
  affiliate_banners_affiliate_id int(11) NOT NULL default '0',
  affiliate_banners_shown int(11) NOT NULL default '0',
  affiliate_banners_clicks tinyint(4) NOT NULL default '0',
  affiliate_banners_history_date date NOT NULL default '0000-00-00',
  PRIMARY KEY (affiliate_banners_history_id,affiliate_banners_products_id)
);

DROP TABLE IF EXISTS prf_affiliate_clickthroughs;
CREATE TABLE IF NOT EXISTS prf_affiliate_clickthroughs (
  affiliate_clickthrough_id int(11) NOT NULL auto_increment,
  affiliate_id int(11) NOT NULL default '0',
  affiliate_clientdate datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_clientbrowser varchar(200) default 'Could Not Find This Data',
  affiliate_clientip varchar(50) default 'Could Not Find This Data',
  affiliate_clientreferer varchar(200) default 'none detected (maybe a direct link)',
  affiliate_products_id int(11) default '0',
  affiliate_banner_id int(11) NOT NULL default '0',
  PRIMARY KEY (affiliate_clickthrough_id),
  KEY refid (affiliate_id)
);

DROP TABLE IF EXISTS prf_affiliate_payment;
CREATE TABLE IF NOT EXISTS prf_affiliate_payment (
  affiliate_payment_id int(11) NOT NULL auto_increment,
  affiliate_id int(11) NOT NULL default '0',
  affiliate_payment decimal(15,2) NOT NULL default '0.00',
  affiliate_payment_tax decimal(15,2) NOT NULL default '0.00',
  affiliate_payment_total decimal(15,2) NOT NULL default '0.00',
  affiliate_payment_date datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_payment_last_modified datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_payment_status int(5) NOT NULL default '0',
  affiliate_firstname varchar(32) NOT NULL default '',
  affiliate_lastname varchar(32) NOT NULL default '',
  affiliate_street_address varchar(64) NOT NULL default '',
  affiliate_suburb varchar(64) NOT NULL default '',
  affiliate_city varchar(32) NOT NULL default '',
  affiliate_postcode varchar(10) NOT NULL default '',
  affiliate_country varchar(32) NOT NULL default '0',
  affiliate_company varchar(60) NOT NULL default '',
  affiliate_state varchar(32) NOT NULL default '0',
  affiliate_address_format_id int(5) NOT NULL default '0',
  affiliate_last_modified datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (affiliate_payment_id)
);

DROP TABLE IF EXISTS prf_affiliate_payment_status;
CREATE TABLE IF NOT EXISTS prf_affiliate_payment_status (
  affiliate_payment_status_id int(11) NOT NULL default '0',
  affiliate_language_id int(11) NOT NULL default '1',
  affiliate_payment_status_name varchar(32) NOT NULL default '',
  PRIMARY KEY (affiliate_payment_status_id,affiliate_language_id),
  KEY idx_affiliate_payment_status_name (affiliate_payment_status_name)
);

DROP TABLE IF EXISTS prf_affiliate_payment_status_history;
CREATE TABLE IF NOT EXISTS prf_affiliate_payment_status_history (
  affiliate_status_history_id int(11) NOT NULL auto_increment,
  affiliate_payment_id int(11) NOT NULL default '0',
  affiliate_new_value int(5) NOT NULL default '0',
  affiliate_old_value int(5) default NULL,
  affiliate_date_added datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_notified int(1) default '0',
  PRIMARY KEY (affiliate_status_history_id)
);

DROP TABLE IF EXISTS prf_affiliate_sales;
CREATE TABLE IF NOT EXISTS prf_affiliate_sales (
  affiliate_id int(11) NOT NULL default '0',
  affiliate_date datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_browser varchar(100) NOT NULL default '',
  affiliate_ipaddress varchar(20) NOT NULL default '',
  affiliate_orders_id int(11) NOT NULL default '0',
  affiliate_value decimal(15,2) NOT NULL default '0.00',
  affiliate_payment decimal(15,2) NOT NULL default '0.00',
  affiliate_clickthroughs_id int(11) NOT NULL default '0',
  affiliate_billing_status int(5) NOT NULL default '0',
  affiliate_payment_date datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_payment_id int(11) NOT NULL default '0',
  affiliate_percent decimal(4,2) NOT NULL default '0.00',
  affiliate_salesman int(11) NOT NULL default '0',
  affiliate_level tinyint(4) NOT NULL default '0',
  PRIMARY KEY (affiliate_id,affiliate_orders_id)
);

DROP TABLE IF EXISTS prf_banktransfer;
CREATE TABLE IF NOT EXISTS prf_banktransfer (
  orders_id int(11) NOT NULL default '0',
  banktransfer_owner varchar(64) default NULL,
  banktransfer_number varchar(24) default NULL,
  banktransfer_bankname varchar(255) default NULL,
  banktransfer_blz varchar(8) default NULL,
  banktransfer_status int(11) default NULL,
  banktransfer_prz char(2) default NULL,
  banktransfer_fax char(2) default NULL,
  KEY orders_id (orders_id)
);

DROP TABLE IF EXISTS prf_banners;
CREATE TABLE IF NOT EXISTS prf_banners (
  banners_id int(11) NOT NULL auto_increment,
  banners_title varchar(64) NOT NULL default '',
  banners_url varchar(255) NOT NULL default '',
  banners_image varchar(64) NOT NULL default '',
  banners_group varchar(10) NOT NULL default '',
  banners_html_text text,
  expires_impressions int(7) default '0',
  expires_date datetime default NULL,
  date_scheduled datetime default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  date_status_change datetime default NULL,
  status int(1) NOT NULL default '1',
  PRIMARY KEY (banners_id)
);

DROP TABLE IF EXISTS prf_banners_history;
CREATE TABLE IF NOT EXISTS prf_banners_history (
  banners_history_id int(11) NOT NULL auto_increment,
  banners_id int(11) NOT NULL default '0',
  banners_shown int(5) NOT NULL default '0',
  banners_clicked int(5) NOT NULL default '0',
  banners_history_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (banners_history_id)
);

DROP TABLE IF EXISTS prf_box_configuration;
CREATE TABLE IF NOT EXISTS prf_box_configuration (
  box_id int(11) NOT NULL auto_increment,
  template varchar(30) default NULL,
  box_key_name varchar(30) default NULL,
  box_visible int(1) NOT NULL default 1,
  box_sort_order int(2) NOT NULL,
  box_forced_visible int(1) NOT NULL default 0,
  box_real_name varchar(30) default NULL,
  box_position_name varchar(30) default NULL,
  last_modified datetime default NULL,
  date_added datetime default NULL,
  PRIMARY KEY (box_id)
);

DROP TABLE IF EXISTS prf_campaigns;
CREATE TABLE prf_campaigns (
  campaigns_id int(11) NOT NULL auto_increment,
  campaigns_name varchar(255) NOT NULL default '',
  campaigns_refID varchar(64) default NULL,
  campaigns_leads int(11) NOT NULL default '0',
  date_added datetime default NULL,
  last_modified datetime default NULL,
  PRIMARY KEY  (campaigns_id),
  KEY IDX_CAMPAIGNS_NAME (campaigns_name)
);

DROP TABLE IF EXISTS prf_campaigns_ip;
CREATE TABLE prf_campaigns_ip (
 user_ip VARCHAR(255) NOT NULL ,
 time DATETIME NOT NULL ,
 campaign VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS prf_cao_log;
CREATE TABLE IF NOT EXISTS prf_cao_log (
  id int(11) NOT NULL auto_increment,
  date datetime NOT NULL default '0000-00-00 00:00:00',
  user varchar(64) NOT NULL default '',
  pw varchar(64) NOT NULL default '',
  method varchar(64) NOT NULL default '',
  action varchar(64) NOT NULL default '',
  post_data mediumtext,
  get_data mediumtext,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS prf_card_blacklist;
CREATE TABLE IF NOT EXISTS prf_card_blacklist (
  blacklist_id int(5) NOT NULL auto_increment,
  blacklist_card_number varchar(20) NOT NULL default '',
  date_added datetime default NULL,
  last_modified datetime default NULL,
  KEY blacklist_id (blacklist_id)
);

DROP TABLE IF EXISTS prf_configuration;
CREATE TABLE IF NOT EXISTS prf_configuration (
  configuration_id int(11) NOT NULL auto_increment,
  configuration_key varchar(64) NOT NULL default '',
  configuration_value text NOT NULL default '',
  configuration_group_id int(11) NOT NULL default '0',
  sort_order int(5) default NULL,
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  use_function varchar(255) default NULL,
  set_function varchar(255) default NULL,
  PRIMARY KEY (configuration_id),
  KEY idx_configuration_group_id (configuration_group_id)
);

DROP TABLE IF EXISTS prf_configuration_group;
CREATE TABLE IF NOT EXISTS prf_configuration_group (
  configuration_group_id int(11) NOT NULL auto_increment,
  configuration_group_title varchar(64) NOT NULL default '',
  configuration_group_description varchar(255) NOT NULL default '',
  sort_order int(5) default NULL,
  visible int(1) default '1',
  PRIMARY KEY (configuration_group_id)
);

DROP TABLE IF EXISTS prf_content_manager;
CREATE TABLE IF NOT EXISTS prf_content_manager (
  content_id int(11) NOT NULL auto_increment,
  categories_id int(11) NOT NULL default '0',
  parent_id int(11) NOT NULL default '0',
  languages_id int(11) NOT NULL default '0',
  content_title text NOT NULL,
  content_heading text NOT NULL,
  content_text text NOT NULL,
  file_flag int(1) NOT NULL default '0',
  content_file varchar(64) NOT NULL default '',
  content_status int(1) NOT NULL default '0',
  content_group int(11) NOT NULL default '0',
  content_delete int(1) NOT NULL default '1',
  sort_order TINYINT( 4 ) NOT NULL DEFAULT '0',
  PRIMARY KEY (content_id)
);

DROP TABLE IF EXISTS prf_counter;
CREATE TABLE IF NOT EXISTS prf_counter (
  startdate char(8) default NULL,
  counter int(12) default NULL
);

DROP TABLE IF EXISTS prf_counter_history;
CREATE TABLE IF NOT EXISTS prf_counter_history (
  month char(8) default NULL,
  counter int(12) default NULL
);

DROP TABLE IF EXISTS prf_coupon_email_track;
CREATE TABLE IF NOT EXISTS prf_coupon_email_track (
  unique_id int(11) NOT NULL auto_increment,
  coupon_id int(11) NOT NULL default '0',
  customer_id_sent int(11) NOT NULL default '0',
  sent_firstname varchar(32) default NULL,
  sent_lastname varchar(32) default NULL,
  emailed_to varchar(32) default NULL,
  date_sent datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (unique_id)
);

DROP TABLE IF EXISTS prf_coupon_gv_customer;
CREATE TABLE IF NOT EXISTS prf_coupon_gv_customer (
  customer_id int(5) NOT NULL default '0',
  amount decimal(8,4) NOT NULL default '0.0000',
  PRIMARY KEY (customer_id),
  KEY customer_id (customer_id)
);

DROP TABLE IF EXISTS prf_coupon_gv_queue;
CREATE TABLE IF NOT EXISTS prf_coupon_gv_queue (
  unique_id int(5) NOT NULL auto_increment,
  customer_id int(5) NOT NULL default '0',
  order_id int(5) NOT NULL default '0',
  amount decimal(8,4) NOT NULL default '0.0000',
  date_created datetime NOT NULL default '0000-00-00 00:00:00',
  ipaddr varchar(255) NOT NULL default '',
  release_flag char(1) NOT NULL default 'N',
  PRIMARY KEY (unique_id),
  KEY uid (unique_id,customer_id,order_id)
);

DROP TABLE IF EXISTS prf_coupon_redeem_track;
CREATE TABLE IF NOT EXISTS prf_coupon_redeem_track (
  unique_id int(11) NOT NULL auto_increment,
  coupon_id int(11) NOT NULL default '0',
  customer_id int(11) NOT NULL default '0',
  redeem_date datetime NOT NULL default '0000-00-00 00:00:00',
  redeem_ip varchar(32) NOT NULL default '',
  order_id int(11) NOT NULL default '0',
  PRIMARY KEY (unique_id)
);

DROP TABLE IF EXISTS prf_coupons;
CREATE TABLE IF NOT EXISTS prf_coupons (
  coupon_id int(11) NOT NULL auto_increment,
  coupon_type char(1) NOT NULL default 'F',
  coupon_code varchar(32) NOT NULL default '',
  coupon_amount decimal(8,4) NOT NULL default '0.0000',
  coupon_minimum_order decimal(8,4) NOT NULL default '0.0000',
  coupon_start_date datetime NOT NULL default '0000-00-00 00:00:00',
  coupon_expire_date datetime NOT NULL default '0000-00-00 00:00:00',
  uses_per_coupon int(5) NOT NULL default '1',
  uses_per_user int(5) NOT NULL default '0',
  restrict_to_products varchar(255) default NULL,
  restrict_to_categories varchar(255) default NULL,
  restrict_to_customers text,
  coupon_active char(1) NOT NULL default 'Y',
  date_created datetime NOT NULL default '0000-00-00 00:00:00',
  date_modified datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (coupon_id)
);

DROP TABLE IF EXISTS prf_coupons_description;
CREATE TABLE IF NOT EXISTS prf_coupons_description (
  coupon_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '0',
  coupon_name varchar(32) NOT NULL default '',
  coupon_description text,
  KEY coupon_id (coupon_id)
);

DROP TABLE IF EXISTS prf_customers;
CREATE TABLE IF NOT EXISTS prf_customers (
  customers_id int(11) NOT NULL auto_increment,
  customers_cid varchar(32) default NULL,
  customers_warning varchar(32) default NULL,
  customers_status int(5) NOT NULL default '1',
  customers_gender char(1) NOT NULL default '',
  customers_firstname varchar(32) NOT NULL default '',
  customers_lastname varchar(32) NOT NULL default '',
  customers_dob datetime NOT NULL default '0000-00-00 00:00:00',
  customers_email_address varchar(96) NOT NULL default '',
  customers_email_type tinyint(1) default NULL,
  customers_default_address_id int(11) NOT NULL default '0',
  customers_telephone varchar(32) NOT NULL default '',
  customers_fax varchar(32) default NULL,
  customers_password varchar(40) NOT NULL default '',
  customers_newsletter char(1) default NULL,
  customers_newsletter_mode char(1) NOT NULL default '0',
  customers_paypal_payerid varchar(20) default NULL,
  customers_paypal_ec tinyint(1) UNSIGNED DEFAULT '0' NOT NULL,
  customers_ebay_name varchar(255) NOT NULL default '',
  member_flag char(1) NOT NULL default '0',
  delete_user char(1) NOT NULL default '1',
  account_type int(1) NOT NULL default '0',
  PRIMARY KEY (customers_id)
);

DROP TABLE IF EXISTS prf_customers_basket;
CREATE TABLE IF NOT EXISTS prf_customers_basket (
  customers_basket_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  products_id tinytext NOT NULL,
  customers_basket_quantity int(2) NOT NULL default '0',
  final_price decimal(15,4) NOT NULL default '0.0000',
  customers_basket_date_added varchar(8) default NULL,
	auction TINYINT DEFAULT '0' NOT NULL,
	auctionid BIGINT,
	PRIMARY KEY (customers_basket_id)
);

DROP TABLE IF EXISTS prf_customers_basket_attributes;
CREATE TABLE IF NOT EXISTS prf_customers_basket_attributes (
  customers_basket_attributes_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  products_id tinytext NOT NULL,
  products_options_id int(11) NOT NULL default '0',
  products_options_value_id int(11) NOT NULL default '0',
	auctionid BIGINT,
  PRIMARY KEY (customers_basket_attributes_id)
);

DROP TABLE IF EXISTS prf_customers_basket_save_baskets;
CREATE TABLE IF NOT EXISTS prf_customers_basket_save_baskets (
  customers_basket_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  basket_name varchar(255) default NULL,
  basket_date_added varchar(8) default NULL,
  basket_last_used  varchar(8) default NULL,
  PRIMARY KEY (customers_basket_id),
  KEY customers_id (customers_id),
  KEY customers_basket_id (customers_basket_id),
  KEY basket_last_used (basket_last_used)
);

DROP TABLE IF EXISTS prf_customers_basket_save;
CREATE TABLE IF NOT EXISTS prf_customers_basket_save (
  customers_basket_save_id int(11) NOT NULL auto_increment,
  customers_basket_id int(11) NOT NULL,
  customers_id int(11) NOT NULL default '0',
  products_id tinytext NOT NULL,
  customers_basket_quantity int(2) NOT NULL default '0',
  final_price decimal(15,4) NOT NULL default '0.0000',
  customers_basket_date_added varchar(8) default NULL,
	auction TINYINT DEFAULT '0' NOT NULL,
	auctionid BIGINT,
  PRIMARY KEY (customers_basket_save_id),
  KEY customers_id (customers_id),
  KEY customers_basket_id (customers_basket_id)
);

DROP TABLE IF EXISTS prf_customers_basket_attributes_save;
CREATE TABLE IF NOT EXISTS prf_customers_basket_attributes_save (
  customers_basket_attributes_id int(11) NOT NULL auto_increment,
  customers_basket_id int(11) NOT NULL,
  customers_id int(11) NOT NULL default '0',
  products_id tinytext NOT NULL,
  products_options_id int(11) NOT NULL default '0',
  products_options_value_id int(11) NOT NULL default '0',
  auctionid BIGINT DEFAULT '0',
  PRIMARY KEY (customers_basket_attributes_id),
  KEY customers_id (customers_id),
  KEY customers_basket_id (customers_basket_id)
);

DROP TABLE IF EXISTS prf_customers_info;
CREATE TABLE IF NOT EXISTS prf_customers_info (
  customers_info_id int(11) NOT NULL default '0',
  customers_info_date_of_last_logon datetime default NULL,
  customers_info_number_of_logons int(5) default NULL,
  customers_info_date_account_created datetime default NULL,
  customers_info_date_account_last_modified datetime default NULL,
  global_product_notifications int(1) default '0',
  PRIMARY KEY (customers_info_id)
);

DROP TABLE IF EXISTS prf_customers_ip;
CREATE TABLE IF NOT EXISTS prf_customers_ip (
  customers_ip_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  customers_ip varchar(255) NOT NULL default '',
  customers_ip_date datetime NOT NULL default '0000-00-00 00:00:00',
  customers_host varchar(255) NOT NULL default '',
  customers_advertiser varchar(30) default NULL,
  customers_referer_url varchar(255) default NULL,
  PRIMARY KEY (customers_ip_id),
  KEY customers_id (customers_id)
);

DROP TABLE IF EXISTS prf_customers_memo;
CREATE TABLE IF NOT EXISTS prf_customers_memo (
  memo_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  memo_date date NOT NULL default '0000-00-00',
  memo_title text NOT NULL,
  memo_text text NOT NULL,
  poster_id int(11) NOT NULL default '0',
  PRIMARY KEY (memo_id)
);

DROP TABLE IF EXISTS prf_customers_status;
CREATE TABLE IF NOT EXISTS prf_customers_status (
  customers_status_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  customers_status_name varchar(32) NOT NULL default '',
  customers_status_public int(1) NOT NULL default '1',
  customers_status_image varchar(64) default NULL,
  customers_status_discount decimal(4,2) default '0.00',
  customers_status_ot_discount_flag char(1) NOT NULL default '0',
  customers_status_ot_discount decimal(4,2) default '0.00',
  customers_status_graduated_prices char(1) NOT NULL default '0',
  customers_status_show_price int(1) NOT NULL default '1',
  customers_status_show_price_tax int(1) NOT NULL default '1',
  customers_status_add_tax_ot int(1) NOT NULL default '0',
  customers_status_payment_unallowed varchar(255) NOT NULL default '',
  customers_status_shipping_unallowed varchar(255) NOT NULL default '',
  customers_status_discount_attributes int(1) NOT NULL default '0',
  customers_fsk18 int(1) NOT NULL default '1',
  customers_fsk18_display int(1) NOT NULL default '1',
  PRIMARY KEY (customers_status_id,language_id),
  KEY idx_orders_status_name (customers_status_name)
);

DROP TABLE IF EXISTS prf_customers_status_history;
CREATE TABLE IF NOT EXISTS prf_customers_status_history (
  customers_status_history_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  new_value int(5) NOT NULL default '0',
  old_value int(5) default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  customer_notified int(1) default '0',
  PRIMARY KEY (customers_status_history_id)
);

DROP TABLE IF EXISTS prf_manufacturers;
CREATE TABLE IF NOT EXISTS prf_manufacturers (
  manufacturers_id int(11) NOT NULL auto_increment,
  manufacturers_name varchar(32) NOT NULL default '',
  manufacturers_image varchar(64) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  PRIMARY KEY (manufacturers_id),
  KEY IDX_MANUFACTURERS_NAME (manufacturers_name)
);

DROP TABLE IF EXISTS prf_manufacturers_info;
CREATE TABLE IF NOT EXISTS prf_manufacturers_info (
  manufacturers_id int(11) NOT NULL default '0',
  languages_id int(11) NOT NULL default '0',
  manufacturers_meta_title varchar(100) NOT NULL default '',
  manufacturers_meta_description varchar(255) NOT NULL default '',
  manufacturers_meta_keywords varchar(255) NOT NULL default '',
  manufacturers_url varchar(255) NOT NULL default '',
  url_clicked int(5) NOT NULL default '0',
  date_last_click datetime default NULL,
  PRIMARY KEY (manufacturers_id,languages_id)
);

DROP TABLE IF EXISTS prf_media_content;
CREATE TABLE IF NOT EXISTS prf_media_content (
  file_id int(11) NOT NULL auto_increment,
  old_filename text NOT NULL,
  new_filename text NOT NULL,
  file_comment text NOT NULL,
  PRIMARY KEY (file_id)
);

DROP TABLE IF EXISTS prf_module_newsletter;
CREATE TABLE IF NOT EXISTS prf_module_newsletter (
  newsletter_id int(11) NOT NULL auto_increment,
  title text NOT NULL,
  bc text NOT NULL,
  cc text NOT NULL,
  date datetime default NULL,
  status int(1) NOT NULL default '0',
  body text NOT NULL,
  PRIMARY KEY (newsletter_id)
);

DROP TABLE IF EXISTS prf_newsletter_recipients;
CREATE TABLE IF NOT EXISTS prf_newsletter_recipients (
  mail_id int(11) NOT NULL auto_increment,
  customers_email_address varchar(96) NOT NULL default '',
  customers_email_type tinyint(1) default NULL,
  customers_id int(11) NOT NULL default '0',
  customers_status int(5) NOT NULL default '0',
  customers_firstname varchar(32) NOT NULL default '',
  customers_lastname varchar(32) NOT NULL default '',
  mail_status int(1) NOT NULL default '0',
  mail_key varchar(32) NOT NULL default '',
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (mail_id)
);

DROP TABLE IF EXISTS prf_newsletters;
CREATE TABLE IF NOT EXISTS prf_newsletters (
  newsletters_id int(11) NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  content text NOT NULL,
  module varchar(255) NOT NULL default '',
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  date_sent datetime default NULL,
  status int(1) default NULL,
  locked int(1) default '0',
  PRIMARY KEY (newsletters_id)
);

DROP TABLE IF EXISTS prf_newsletters_history;
CREATE TABLE IF NOT EXISTS prf_newsletters_history (
  news_hist_id int(11) NOT NULL default '0',
  news_hist_cs int(11) NOT NULL default '0',
  news_hist_cs_date_sent date default NULL,
  PRIMARY KEY (news_hist_id)
);

DROP TABLE IF EXISTS prf_orders;
CREATE TABLE IF NOT EXISTS prf_orders (
  orders_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  customers_cid varchar(32) default NULL,
  customers_status int(11) default NULL,
  customers_status_name varchar(32) NOT NULL default '',
  customers_status_image varchar(64) default NULL,
  customers_status_discount decimal(4,2) default NULL,
  customers_name varchar(64) NOT NULL default '',
  customers_company varchar(32) default NULL,
  customers_street_address varchar(64) NOT NULL default '',
  customers_suburb varchar(32) default NULL,
  customers_city varchar(32) NOT NULL default '',
  customers_postcode varchar(10) NOT NULL default '',
  customers_state varchar(32) default NULL,
  customers_country varchar(32) NOT NULL default '',
  customers_telephone varchar(32) NOT NULL default '',
  customers_email_address varchar(96) NOT NULL default '',
  customers_email_type tinyint(1) default NULL,
  customers_address_format_id int(5) NOT NULL default '0',
  customers_order_reference VARCHAR( 32 ),
  delivery_name varchar(64) NOT NULL default '',
  delivery_firstname varchar(32) NOT NULL default '',
  delivery_lastname varchar(32) NOT NULL default '',
  delivery_company varchar(32) default NULL,
  delivery_street_address varchar(64) NOT NULL default '',
  delivery_suburb varchar(32) default NULL,
  delivery_city varchar(32) NOT NULL default '',
  delivery_postcode varchar(10) NOT NULL default '',
  delivery_state varchar(32) default NULL,
  delivery_country varchar(32) NOT NULL default '',
  delivery_country_iso_code_2 char(2) NOT NULL default '',
  delivery_address_format_id int(5) NOT NULL default '0',
	delivery_packingslip_number VARCHAR( 20 ) NOT NULL default '',
	delivery_packingslip_date DATE NOT NULL,
  billing_name varchar(64) NOT NULL default '',
  billing_firstname varchar(32) NOT NULL default '',
  billing_lastname varchar(32) NOT NULL default '',
  billing_company varchar(32) default NULL,
  billing_street_address varchar(64) NOT NULL default '',
  billing_suburb varchar(32) default NULL,
  billing_city varchar(32) NOT NULL default '',
  billing_postcode varchar(10) NOT NULL default '',
  billing_state varchar(32) default NULL,
  billing_country varchar(32) NOT NULL default '',
  billing_country_iso_code_2 char(2) NOT NULL default '',
  billing_address_format_id int(5) NOT NULL default '0',
	billing_invoice_number VARCHAR(20) NOT NULL default '',
	billing_invoice_date DATE NOT NULL,
  payment_method varchar(255) NOT NULL default '',
  cc_type varchar(20) default NULL,
  cc_owner varchar(64) default NULL,
  cc_number varchar(64) default NULL,
  cc_expires varchar(4) default NULL,
  cc_start varchar(4) default NULL,
  cc_issue char(3) default NULL,
  cc_cvv varchar(4) default NULL,
  comments varchar(255) default NULL,
  last_modified datetime default NULL,
  date_purchased datetime default NULL,
  orders_status int(5) NOT NULL default '0',
  orders_date_finished datetime default NULL,
  currency char(3) default NULL,
  currency_value decimal(14,6) default NULL,
  account_type int(1) NOT NULL default '0',
  payment_class varchar(32) NOT NULL default '',
  shipping_method varchar(255) NOT NULL default '',
  shipping_class varchar(32) NOT NULL default '',
  customers_ip varchar(255) NOT NULL default '',
  language varchar(32) NOT NULL default '',
  orders_trackcode varchar(64) default NULL,
  orders_discount INT( 11 ) DEFAULT '0' NOT NULL,
	payment_id INT( 11 ) DEFAULT '0' NOT NULL,
	shipping_tax DECIMAL( 7, 4 ) DEFAULT '19.000' NOT NULL,
  PRIMARY KEY (orders_id)
);

DROP TABLE IF EXISTS prf_orders_products;
CREATE TABLE IF NOT EXISTS prf_orders_products (
  orders_products_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  products_id int(11) NOT NULL default '0',
  products_model varchar(64) default NULL,
  products_name varchar(64) NOT NULL default '',
  products_price decimal(15,4) NOT NULL default '0.0000',
  products_discount_made decimal(4,2) default NULL,
  final_price decimal(15,4) NOT NULL default '0.0000',
  products_tax decimal(7,4) NOT NULL default '0.0000',
  products_quantity int(2) NOT NULL default '0',
  allow_tax int(1) NOT NULL default '0',
  PRIMARY KEY (orders_products_id)
);

DROP TABLE IF EXISTS prf_orders_products_attributes;
CREATE TABLE IF NOT EXISTS prf_orders_products_attributes (
  orders_products_attributes_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  orders_products_id int(11) NOT NULL default '0',
  products_options varchar(32) NOT NULL default '',
  products_options_values varchar(32) NOT NULL default '',
  options_values_price decimal(15,4) NOT NULL default '0.0000',
  price_prefix char(1) NOT NULL default '',
	products_options_id INT( 11 ) DEFAULT '0' NOT NULL,
	products_options_values_id INT( 11 ) DEFAULT '0' NOT NULL,
  PRIMARY KEY (orders_products_attributes_id)
);

DROP TABLE IF EXISTS prf_orders_products_download;
CREATE TABLE IF NOT EXISTS prf_orders_products_download (
  orders_products_download_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  orders_products_id int(11) NOT NULL default '0',
  orders_products_filename varchar(255) NOT NULL default '',
  download_maxdays int(2) NOT NULL default '0',
  download_count int(2) NOT NULL default '0',
  PRIMARY KEY (orders_products_download_id)
);

DROP TABLE IF EXISTS prf_orders_recalculate;
CREATE TABLE IF NOT EXISTS prf_orders_recalculate (
  orders_recalculate_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  n_price decimal(15,4) NOT NULL default '0.0000',
  b_price decimal(15,4) NOT NULL default '0.0000',
  tax decimal(15,4) NOT NULL default '0.0000',
  tax_rate decimal(7,4) NOT NULL default '0.0000',
  class varchar(32) NOT NULL default '',
  PRIMARY KEY (orders_recalculate_id)
);

DROP TABLE IF EXISTS prf_orders_status_history;
CREATE TABLE IF NOT EXISTS prf_orders_status_history (
  orders_status_history_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  orders_status_id int(5) NOT NULL default '0',
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  customer_notified int(1) default '0',
  comments text,
  PRIMARY KEY (orders_status_history_id)
);

DROP TABLE IF EXISTS prf_orders_total;
CREATE TABLE IF NOT EXISTS prf_orders_total (
  orders_total_id int(10) unsigned NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  text varchar(255) NOT NULL default '',
  value decimal(15,4) NOT NULL default '0.0000',
  class varchar(32) NOT NULL default '',
  sort_order int(11) NOT NULL default '0',
  PRIMARY KEY (orders_total_id),
  KEY idx_orders_total_orders_id (orders_id)
);

DROP TABLE IF EXISTS prf_payment_moneybookers;
CREATE TABLE IF NOT EXISTS prf_payment_moneybookers (
  mb_TRID varchar(255) NOT NULL default '',
  mb_ERRNO smallint(3) unsigned NOT NULL default '0',
  mb_ERRTXT varchar(255) NOT NULL default '',
  mb_DATE datetime NOT NULL default '0000-00-00 00:00:00',
  mb_MBTID bigint(18) unsigned NOT NULL default '0',
  mb_STATUS tinyint(1) NOT NULL default '0',
  mb_ORDERID int(11) unsigned NOT NULL default '0',
  PRIMARY KEY (mb_TRID)
);

DROP TABLE IF EXISTS prf_personal_offers_by_customers_status_0;
CREATE TABLE IF NOT EXISTS prf_personal_offers_by_customers_status_0 (
  price_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  quantity int(11) default NULL,
  personal_offer decimal(15,4) default NULL,
  PRIMARY KEY (price_id)
);

DROP TABLE IF EXISTS prf_personal_offers_by_customers_status_1;
CREATE TABLE IF NOT EXISTS prf_personal_offers_by_customers_status_1 (
  price_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  quantity int(11) default NULL,
  personal_offer decimal(15,4) default NULL,
  PRIMARY KEY (price_id)
);

DROP TABLE IF EXISTS prf_personal_offers_by_customers_status_2;
CREATE TABLE IF NOT EXISTS prf_personal_offers_by_customers_status_2 (
  price_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  quantity int(11) default NULL,
  personal_offer decimal(15,4) default NULL,
  PRIMARY KEY (price_id)
);

DROP TABLE IF EXISTS prf_personal_offers_by_customers_status_3;
CREATE TABLE IF NOT EXISTS prf_personal_offers_by_customers_status_3 (
  price_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default 0,
  quantity int(11) default NULL,
  personal_offer decimal(15,4) default NULL,
  PRIMARY KEY  (price_id)
);

DROP TABLE IF EXISTS prf_sessions;
CREATE TABLE IF NOT EXISTS prf_sessions (
  sesskey varchar(32) NOT NULL default '',
  expiry int(11) unsigned NOT NULL default '0',
  value text NOT NULL,
  PRIMARY KEY (sesskey),
  KEY expiry (expiry)
);

DROP TABLE IF EXISTS prf_specials;
CREATE TABLE IF NOT EXISTS prf_specials (
  specials_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  specials_new_products_price decimal(15,4) NOT NULL default '0.0000',
  specials_date_added datetime default NULL,
  specials_last_modified datetime default NULL,
  expires_date datetime default NULL,
  date_status_change datetime default NULL,
  status int(1) NOT NULL default '1',
  PRIMARY KEY (specials_id)
);

DROP TABLE IF EXISTS prf_whos_online;
CREATE TABLE IF NOT EXISTS prf_whos_online (
  customer_id int(11) default NULL,
  full_name varchar(64) NOT NULL default '',
  session_id varchar(128) NOT NULL default '',
  ip_address varchar(255) NOT NULL default '',
  time_entry varchar(14) NOT NULL default '',
  time_last_click varchar(14) NOT NULL default '',
  last_page_url varchar(64) NOT NULL default '',
	PRIMARY KEY (session_id)
);

DROP TABLE IF EXISTS prf_whos_online_data;
CREATE TABLE IF NOT EXISTS prf_whos_online_data (
  session_id varchar(128) NOT NULL default '',
  online_ips LONGTEXT,
  online_ips_text LONGTEXT,
	PRIMARY KEY (session_id)
);

#
# PayPal IPN
#
# Table structure for table orders_session_info
#

DROP TABLE IF EXISTS prf_orders_session_info;
CREATE TABLE prf_orders_session_info (
  txn_signature varchar(32) NOT NULL default '',
  orders_id int(11) NOT NULL default '0',
  payment varchar(32) NOT NULL default '',
  payment_title varchar(32) NOT NULL default '',
  payment_amount decimal(7,2) NOT NULL default '0.00',
  payment_currency char(3) NOT NULL default '',
  payment_currency_val float(13,8) default NULL,
  sendto int(11) NOT NULL default '1',
  billto int(11) NOT NULL default '1',
  language varchar(32) NOT NULL default '',
  language_id int(11) NOT NULL default '1',
  currency char(3) NOT NULL default '',
  currency_value float(13,8) default NULL,
  firstname varchar(32) NOT NULL default '',
  lastname varchar(32) NOT NULL default '',
  content_type varchar(32) NOT NULL default '',
  affiliate_id int(11) NOT NULL default '0',
  affiliate_date datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_browser varchar(100) NOT NULL default '',
  affiliate_ipaddress varchar(20) NOT NULL default '',
  affiliate_clickthroughs_id int(11) NOT NULL default '0',
  PRIMARY KEY (txn_signature,orders_id),
  KEY idx_orders_session_info_txn_signature (txn_signature)
);

#
# Table structure for table paypal
#

DROP TABLE IF EXISTS prf_paypal;
CREATE TABLE prf_paypal (
  paypal_id int(11) unsigned NOT NULL auto_increment,
  txn_type varchar(10) NOT NULL default '',
  reason_code varchar(15) default NULL,
  payment_type varchar(7) NOT NULL default '',
  payment_status varchar(17) NOT NULL default '',
  pending_reason varchar(14) default NULL,
  invoice varchar(64) default NULL,
  mc_currency char(3) NOT NULL default '',
  first_name varchar(32) NOT NULL default '',
  last_name varchar(32) NOT NULL default '',
  payer_business_name varchar(64) default NULL,
  address_name varchar(32) default NULL,
  address_street varchar(64) default NULL,
  address_city varchar(32) default NULL,
  address_state varchar(32) default NULL,
  address_zip varchar(10) default NULL,
  address_country varchar(64) default NULL,
  address_status varchar(11) default NULL,
  payer_email varchar(96) NOT NULL default '',
  payer_id varchar(32) NOT NULL default '',
  payer_status varchar(10) NOT NULL default '',
  payment_date datetime default NULL,
  payment_time_zone char(4) NOT NULL default '',
  business varchar(96) NOT NULL default '',
  receiver_email varchar(96) NOT NULL default '',
  receiver_id varchar(32) NOT NULL default '',
  txn_id varchar(17) NOT NULL default '',
  parent_txn_id varchar(17) default NULL,
  num_cart_items tinyint(4) unsigned NOT NULL default '1',
  mc_gross decimal(7,2) NOT NULL default '0.00',
  mc_fee decimal(7,2) NOT NULL default '0.00',
  payment_gross decimal(7,2) default NULL,
  payment_fee decimal(7,2) default NULL,
  settle_amount decimal(7,2) default NULL,
  settle_currency char(3) default NULL,
  exchange_rate decimal(4,2) default NULL,
  for_auction varchar(5) NOT NULL default 'false',
  auction_buyer_id varchar(64) NOT NULL default '',
  auction_closing_date datetime NOT NULL default '0000-00-00 00:00:00',
  auction_multi_item tinyint(4) NOT NULL default '0',
  quantity int(11) NOT NULL default '0',
  tax decimal(7,2) default NULL,
  notify_version decimal(2,1) NOT NULL default '0.0',
  verify_sign varchar(128) NOT NULL default '',
  last_modified datetime default NULL,
  date_added datetime default NULL,
  memo text,
  PRIMARY KEY (paypal_id,txn_id),
  KEY idx_paypal_paypal_id (paypal_id)
);

#
# Table structure for table paypal_payment_status_history
#

DROP TABLE IF EXISTS prf_paypal_payment_status_history;
CREATE TABLE IF NOT EXISTS prf_paypal_payment_status_history (
  payment_status_history_id int(11) NOT NULL auto_increment,
  paypal_id int(11) NOT NULL default '0',
  payment_status varchar(17) NOT NULL default '',
  pending_reason varchar(14) default NULL,
  reason_code varchar(15) default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (payment_status_history_id)
);

#
# Table structure for table paypal_auction
#

DROP TABLE IF EXISTS prf_paypal_auction;
CREATE TABLE IF NOT EXISTS prf_paypal_auction (
  paypal_id int(11) NOT NULL default '0',
  item_number varchar(96) NOT NULL default '',
  auction_buyer_id varchar(96) NOT NULL default '',
  auction_multi_item tinyint(4) NOT NULL default '0',
  auction_closing_date datetime NOT NULL default '0000-00-00 00:00:00',
  is_old int(1) NOT NULL default '0',
  PRIMARY KEY (paypal_id,item_number)
);

#Data

#
# Database Version
#
INSERT INTO prf_configuration VALUES (NULL, 'DB_VERSION',  '2.0', 0, 0, NULL, now(), NULL, NULL);
#
# Database Version
#

INSERT INTO prf_content_manager VALUES (1, 0, 0, 1, 'Shipping & Returns', 'Shipping & Returns', 'Put here your Shipping & Returns information.', 1, '', 1, 1, 0, 0);
INSERT INTO prf_content_manager VALUES (2, 0, 0, 1, 'Privacy Notice', 'Privacy Notice', 'Put here your Privacy Notice information.', 1, '', 1, 2, 0, 0);
INSERT INTO prf_content_manager VALUES (3, 0, 0, 1, 'Conditions of Use', 'Conditions of Use', 'Conditions of Use<br />Put here your Conditions of Use information. <br />1. Validity<br />2. Offers<br />3. Price<br />4. Dispatch and passage of the risk<br />5. Delivery<br />6. Terms of payment<br />7. Retention of title<br />8. Notices of defect, guarantee and compensation<br />9. Fair trading cancelling / non-acceptance<br />10. Place of delivery and area of jurisdiction<br />11. Final clauses', 1, '', 1, 3, 0, 0);
INSERT INTO prf_content_manager VALUES (4, 0, 0, 1, 'Impressum', 'Impressum', 'Put here your&nbsp;Company information.', 1, '', 1, 4, 0, 0);
INSERT INTO prf_content_manager VALUES (5, 0, 0, 1, 'Index', 'Welcome', '{$greeting}<br/><br/> Dies ist die Standardinstallation des osCommerce Forking Projektes - OL-Commerce. Alle dargestellten Produkte dienen zur Demonstration der Funktionsweise. Wenn Sie Produkte bestellen, so werden diese weder ausgeliefert, noch in Rechnung gestellt. Alle Informationen zu den verschiedenen Produkten sind erfunden und daher kann kein Anspruch daraus abgeleitet werden.<br/><br/>Sollten Sie daran interessiert sein das Programm, welches die Grundlage für diesen Shop bildet, einzusetzen, so besuchen Sie bitte die Supportseite von OL-Commerce. Dieser Shop basiert auf OL-Commerce/AJAX <br/><br/>Der hier dargestellte Text kann im Admin-Bereich unter dem Punkt <b>Inhalte Manager</b>-Eintrag <b>Index</b> bearbeitet werden.', 1, '', 0, 5, 0, 0);
INSERT INTO prf_content_manager VALUES (6, 0, 0, 2, 'Liefer- und Versandkosten', 'Liefer- und Versandkosten', 'Fügen Sie hier Ihre Informationen über Liefer- und Versandkosten ein.', 1, '', 1, 1, 0, 0);
INSERT INTO prf_content_manager VALUES (7, 0, 0, 2, 'Privatsphäre und Datenschutz', 'Privatsphäre und Datenschutz', 'Fügen Sie hier Ihre Informationen über Privatsphäre und Datenschutz ein.', 1, '', 1, 2, 0, 0);
INSERT INTO prf_content_manager VALUES (8, 0, 0, 2, 'Unsere AGB\'s', 'Allgemeine Geschäftsbedingungen', '<strong>Allgemeine Geschäftsbedingungen<br/></strong><br/>Fügen Sie hier Ihre allgemeinen Geschäftsbedingungen ein.<br/>1. Geltung<br/>2. Angebote<br/>3. Preis<br/>4. Versand und Gefahrübergang<br/>5. Lieferung<br/>6. Zahlungsbedingungen<br/>7. Eigentumsvorbehalt <br/>8. Mängelrügen, Gewährleistung und Schadenersatz<br/>9. Kulanzrücknahme/Annahmeverweigerung<br/>10. Erfüllungsort und Gerichtsstand<br/>11. Schlussbestimmungen', 1, '', 1, 3, 0, 0);
INSERT INTO prf_content_manager VALUES (9, 0, 0, 2, 'Impressum', 'Impressum', 'Fügen Sie hier Ihr Impressum ein.', 1, '', 1, 4, 0, 0);
INSERT INTO prf_content_manager VALUES (10, 0, 0, 2, 'Index', 'Willkommen', '<p>{$greeting}<br/><br/>Dies ist die Standardinstallation des osCommerce Forking Projektes - OL-Commerce. Alle dargestellten Produkte dienen zur Demonstration der Funktionsweise. Wenn Sie Produkte bestellen, so werden diese weder ausgeliefert, noch in Rechnung gestellt. Alle Informationen zu den verschiedenen Produkten sind erfunden und daher kann kein Anspruch daraus abgeleitet werden.<br/><br/>Sollten Sie daran interessiert sein das Programm, welches die Grundlage für diesen Shop bildet, einzusetzen, so besuchen Sie bitte die Supportseite von OL-Commerce. Dieser Shop basiert auf der OL-Commerce Version v4/AJAX<br/><br/>Der hier dargestellte Text kann im AdminInterface unter dem Punkt <B>Content Manager</B> - Eintrag <b>Index</b> bearbeitet werden.</p>', 1, '', 0, 5, 0, 0);
INSERT INTO prf_content_manager VALUES (11, 0, 0, 2, 'Gutscheine', 'Gutscheine - Fragen und Antworte', '<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Gutscheine kaufen </strong></td></tr>\r\n<tr>\r\n<td class=main>Gutscheine können, falls sie im Shop angeboten werden, wie normale Artikel gekauft werden. Sobald Sie einen Gutschein gekauft haben und dieser nach erfolgreicher Zahlung freigeschaltet wurde, erscheint der Betrag unter Ihrem Warenkorb. Nun können Sie über den Link " Gutschein versenden " den gewünschten Betrag per E-Mail versenden. </td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Wie man Gutscheine versendet </strong></td></tr>\r\n<tr>\r\n<td class=main>Um einen Gutschein zu versenden, klicken Sie bitte auf den Link "Gutschein versenden" in Ihrem Einkaufskorb. Um einen Gutschein zu versenden, benötigen wir folgende Angaben von Ihnen: Vor- und Nachname des Empfängers. Eine gültige E-Mail Adresse des Empfängers. Den gewünschten Betrag (Sie können auch Teilbeträge Ihres Guthabens versenden). Eine kurze Nachricht an den Empfänger. Bitte überprüfen Sie Ihre Angaben noch einmal vor dem Versenden. Sie haben vor dem Versenden jederzeit die Möglichkeit Ihre Angaben zu korrigieren. </td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Mit Gutscheinen Einkaufen. </strong></td></tr>\r\n<tr>\r\n<td class=main>Sobald Sie über ein Guthaben verfügen, können Sie dieses zum Bezahlen Ihrer Bestellung verwenden. Während des Bestellvorganges haben Sie die Möglichkeit Ihr Guthaben einzulösen. Falls das Guthaben unter dem Warenwert liegt müssen Sie Ihre bevorzugte Zahlungsweise für den Differenzbetrag wählen. Übersteigt Ihr Guthaben den Warenwert, steht Ihnen das Restguthaben selbstverständlich für Ihre nächste Bestellung zur Verfügung. </td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Gutscheine verbuchen. </strong></td></tr>\r\n<tr>\r\n<td class=main>Wenn Sie einen Gutschein per E-Mail erhalten haben, können Sie den Betrag wie folgt verbuchen:. <br/>1. Klicken Sie auf den in der E-Mail angegebenen Link. Falls Sie noch nicht über ein persönliches Kundenkonto verfügen, haben Sie die Möglichkeit ein Konto zu eröffnen. <br/>2. Nachdem Sie ein Produkt in den Warenkorb gelegt haben, können Sie dort Ihren Gutscheincode eingeben.</td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Falls es zu Problemen kommen sollte: </strong></td></tr>\r\n<tr>\r\n<td class=main>Falls es wider Erwarten zu Problemen mit einem Gutschein kommen sollte, kontaktieren Sie uns bitte per E-Mail : you@yourdomain.com. Bitte beschreiben Sie möglichst genau das Problem, wichtige Angaben sind unter anderem: Ihre Kundennummer, der Gutscheincode, Fehlermeldungen des Systems sowie der von Ihnen benutzte Browser. </td></tr></TBODY></table>', 1, '', 0, 6, 1, 0);
INSERT INTO prf_content_manager VALUES (12, 0, 0, 1, 'Gutscheine', 'Gutscheine - Fragen und Antworte', '<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Gutscheine kaufen </strong></td></tr>\r\n<tr>\r\n<td class=main>Gutscheine können, falls sie im Shop angeboten werden, wie normale Artikel gekauft werden. Sobald Sie einen Gutschein gekauft haben und dieser nach erfolgreicher Zahlung freigeschaltet wurde, erscheint der Betrag unter Ihrem Warenkorb. Nun können Sie über den Link " Gutschein versenden " den gewünschten Betrag per E-Mail versenden. </td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Wie man Gutscheine versendet </strong></td></tr>\r\n<tr>\r\n<td class=main>Um einen Gutschein zu versenden, klicken Sie bitte auf den Link "Gutschein versenden" in Ihrem Einkaufskorb. Um einen Gutschein zu versenden, benötigen wir folgende Angaben von Ihnen: Vor- und Nachname des Empfängers. Eine gültige E-Mail Adresse des Empfängers. Den gewünschten Betrag (Sie können auch Teilbeträge Ihres Guthabens versenden). Eine kurze Nachricht an den Empfänger. Bitte überprüfen Sie Ihre Angaben noch einmal vor dem Versenden. Sie haben vor dem Versenden jederzeit die Möglichkeit Ihre Angaben zu korrigieren. </td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Mit Gutscheinen Einkaufen. </strong></td></tr>\r\n<tr>\r\n<td class=main>Sobald Sie über ein Guthaben verfügen, können Sie dieses zum Bezahlen Ihrer Bestellung verwenden. Während des Bestellvorganges haben Sie die Möglichkeit Ihr Guthaben einzulösen. Falls das Guthaben unter dem Warenwert liegt müssen Sie Ihre bevorzugte Zahlungsweise für den Differenzbetrag wählen. Übersteigt Ihr Guthaben den Warenwert, steht Ihnen das Restguthaben selbstverständlich für Ihre nächste Bestellung zur Verfügung. </td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Gutscheine verbuchen. </strong></td></tr>\r\n<tr>\r\n<td class=main>Wenn Sie einen Gutschein per E-Mail erhalten haben, können Sie den Betrag wie folgt verbuchen:. <br/>1. Klicken Sie auf den in der E-Mail angegebenen Link. Falls Sie noch nicht über ein persönliches Kundenkonto verfügen, haben Sie die Möglichkeit ein Konto zu eröffnen. <br/>2. Nachdem Sie ein Produkt in den Warenkorb gelegt haben, können Sie dort Ihren Gutscheincode eingeben.</td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Falls es zu Problemen kommen sollte: </strong></td></tr>\r\n<tr>\r\n<td class=main>Falls es wider Erwarten zu Problemen mit einem Gutschein kommen sollte, kontaktieren Sie uns bitte per E-Mail : you@yourdomain.com. Bitte beschreiben Sie möglichst genau das Problem, wichtige Angaben sind unter anderem: Ihre Kundennummer, der Gutscheincode, Fehlermeldungen des Systems sowie der von Ihnen benutzte Browser. </td></tr></TBODY></table>', 1, '', 0, 6, 1, 0);
INSERT INTO prf_content_manager VALUES (13, 0, 0, 2, 'Kontakt', 'Kontakt', '<p>Ihre Kontaktinformationen</p>', 1, '', 1, 7, 0, 0);
INSERT INTO prf_content_manager VALUES (14, 0, 0, 1, 'Contact', 'Contact', 'Please enter your contact informations.', 1, '', 1, 7, 0, 0);

INSERT INTO prf_admin_access VALUES ('1',1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO prf_admin_access VALUES ('groups',1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,3,3,3,3,3,3,4,4,4,4,2,4,2,2,2,2,5,5,5,5,5,5,5,5,2,2,2,2,2,2,2,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

INSERT INTO prf_configuration VALUES (NULL, 'EXPECTED_PRODUCTS_SORT', 'desc', 1, 7, NULL, now(), NULL, 'olc_cfg_select_option(array(\'asc\', \'desc\'),');
INSERT INTO prf_configuration VALUES (NULL, 'EXPECTED_PRODUCTS_FIELD', 'date_expected', 1, 8, NULL, now(), NULL, 'olc_cfg_select_option(array(\'products_name\', \'date_expected\'),');
INSERT INTO prf_configuration VALUES (NULL, 'USE_DEFAULT_LANGUAGE_CURRENCY', 'false', 1, 9, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'DISPLAY_CART', 'true', 1, 10, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'ALLOW_GUEST_TO_TELL_A_FRIEND', 'false', 1, 11, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'ADVANCED_SEARCH_DEFAULT_OPERATOR', 'and', 1, 12, NULL, now(), NULL, 'olc_cfg_select_option(array("and'', ''or''),');
INSERT INTO prf_configuration VALUES (NULL, 'SHOW_COUNTS', 'true', 1, 14, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'DEFAULT_CUSTOMERS_STATUS_ID_ADMIN', '0', 1, 15, NULL, now(), 'olc_get_customers_status_name', 'olc_cfg_pull_down_customers_status_list(');
INSERT INTO prf_configuration VALUES (NULL, 'DEFAULT_CUSTOMERS_STATUS_ID_GUEST', '1', 1, 16, NULL, now(), 'olc_get_customers_status_name', 'olc_cfg_pull_down_customers_status_list(');
INSERT INTO prf_configuration VALUES (NULL, 'DEFAULT_CUSTOMERS_STATUS_ID_COMPANY', '3', 1, 16, NULL, now(), 'olc_get_customers_status_name', 'olc_cfg_pull_down_customers_status_list(');
INSERT INTO prf_configuration VALUES (NULL, 'CUSTOMER_STATUS_NO_FERNAG_INFO_IDS', '', 1, 17, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'DEFAULT_CUSTOMERS_STATUS_ID', '2', 1, 18, NULL, now(), 'olc_get_customers_status_name', 'olc_cfg_pull_down_customers_status_list(');
INSERT INTO prf_configuration VALUES (NULL, 'ALLOW_ADD_TO_CART', 'false', 1, 19, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'ALLOW_CATEGORY_DESCRIPTIONS', 'true', 1, 20, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'PRICE_IS_BRUTTO', 'true', 1, 22, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'PRICE_PRECISION', '4', 1, 23, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'NO_TAX_RAISED', '0', 1, 24, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'USE_STICKY_CART', '1', 1, 25, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SHOW_SHORT_CART_ONLY', '0', 1, 25, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'USE_PDF_INVOICE', '1', 1, 26, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'CAO_INCLUDE', '0', 1, 28, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EASYSALES_INCLUDE', '0', 1, 29, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'CRON_JOBS_LIST', '', 1,  30, NULL, now(), NULL, 'olc_cfg_textarea(');
INSERT INTO prf_configuration VALUES (NULL, 'VISITOR_PDF_CATALOGUE', 'false', 1, 31, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'GALLERY_PICTURES_PER_PAGE', '100', 1,  37,  NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'GALLERY_PICTURES_PER_LINE', '6', 1,  38,  NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'TRACKING_PRODUCTS_HISTORY_ENTRIES', '10', 1,  39,  NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EBAY_FUNCTIONS_INCLUDE', 'false', 1,  42,  NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO prf_configuration VALUES (NULL, 'STORE_NAME', 'OL-Commerce', 100, 1, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STORE_OWNER', 'OL-Commerce', 100, 2, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STORE_OWNER_EMAIL_ADDRESS', 'inhaber@ihr-shop.de', 100, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_FROM', 'OL-Commerce inhaber@ihr-shop.de', 100, 4, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STORE_COUNTRY', '81', 100, 5, NULL, now(), 'olc_get_country_name', 'olc_cfg_pull_down_country_list(');
INSERT INTO prf_configuration VALUES (NULL, 'STORE_ZONE', '', 100, 6, NULL, now(), 'olc_cfg_get_zone_name', 'olc_cfg_pull_down_zone_list(');
INSERT INTO prf_configuration VALUES (NULL, 'STORE_NAME_ADDRESS', 'Shop Name\nAddesse\nLand\nTel\nFax', 100, 7, NULL, now(), NULL, 'olc_cfg_textarea(');

INSERT INTO prf_configuration VALUES (NULL, 'STORE_BANK_NAME', '', 100, 8, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STORE_BANK_BLZ', '', 100, 9, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STORE_BANK_ACCOUNT', '', 100, 10, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STORE_BANK_BIC', '', 100, 11, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STORE_BANK_IBAN', '', 100, 12, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STORE_USTID', '', 100, 13, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STORE_TAXNR', '', 100, 14, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STORE_REGISTER', '', 100, 15, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STORE_REGISTER_NR', '', 100, 16, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STORE_MANAGER', '', 100, 17, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STORE_DIRECTOR', '', 100, 18, NULL, now(), NULL, NULL);

INSERT INTO prf_configuration VALUES (NULL, 'ENTRY_FIRST_NAME_MIN_LENGTH', '2', 2, 1, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'ENTRY_LAST_NAME_MIN_LENGTH', '2', 2, 2, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'ENTRY_DOB_MIN_LENGTH', '10', 2, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'ENTRY_EMAIL_ADDRESS_MIN_LENGTH', '6', 2, 4, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'ENTRY_STREET_ADDRESS_MIN_LENGTH', '5', 2, 5, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'ENTRY_COMPANY_MIN_LENGTH', '2', 2, 6, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'ENTRY_POSTCODE_MIN_LENGTH', '4', 2, 7, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'ENTRY_CITY_MIN_LENGTH', '3', 2, 8, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'ENTRY_STATE_MIN_LENGTH', '2', 2, 9, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'ENTRY_TELEPHONE_MIN_LENGTH', '3', 2, 10, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'ENTRY_PASSWORD_MIN_LENGTH', '5', 2, 11, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'CC_OWNER_MIN_LENGTH', '3', 2, 12, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'CC_NUMBER_MIN_LENGTH', '10', 2, 13, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'REVIEW_TEXT_MIN_LENGTH', '50', 2, 14, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MIN_DISPLAY_BESTSELLERS', '1', 2, 15, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MIN_DISPLAY_ALSO_PURCHASED', '1', 2, 16, NULL, now(), NULL, NULL);

INSERT INTO prf_configuration VALUES (NULL, 'MAX_ADDRESS_BOOK_ENTRIES', '5', 3, 1, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_DISPLAY_SEARCH_RESULTS', '20', 3, 2, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_DISPLAY_PAGE_LINKS', '5', 3, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_DISPLAY_SPECIAL_PRODUCTS', '9', 3, 4, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_DISPLAY_NEW_PRODUCTS', '9', 3, 5, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_DISPLAY_UPCOMING_PRODUCTS', '10', 3, 6, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_DISPLAY_MANUFACTURERS_IN_A_LIST', '0', 3, 7, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_MANUFACTURERS_LIST', '1', 3, 8, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_DISPLAY_MANUFACTURER_NAME_LEN', '15', 3, 9, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_DISPLAY_NEW_REVIEWS', '6', 3, 10, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_RANDOM_SELECT_REVIEWS', '10', 3, 11, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_RANDOM_SELECT_NEW', '10', 3, 12, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_RANDOM_SELECT_SPECIALS', '10', 3, 13, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_DISPLAY_CATEGORIES_PER_ROW', '3', 3, 14, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_DISPLAY_PRODUCTS_NEW', '10', 3, 15, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_DISPLAY_BESTSELLERS', '10', 3, 16, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_DISPLAY_ALSO_PURCHASED', '6', 3, 17, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX', '6', 3, 18, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_DISPLAY_ORDER_HISTORY', '10', 3, 19, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_REVIEWS_VIEW', '5', 3, 20, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MAX_PRODUCTS_QTY', '1000', 3, 21, NULL, now(), NULL, NULL);

INSERT INTO prf_configuration VALUES (NULL, 'CONFIG_CALCULATE_IMAGE_SIZE', 'true', 4, 1, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'IMAGE_QUALITY', '80', 4, 2, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MO_PICS', '0', 4, 3, NULL, now(), NULL , NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_INFO_BEVEL', '', 4, 4, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_INFO_DROP_SHADDOW', '(3,333333,FFFFFF)', 4, 5, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_INFO_ELLIPSE', '', 4, 6, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_INFO_FRAME', '(FFFFFF,000000,3,EEEEEE)', 4, 7, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_INFO_GREYSCALE', '', 4, 8, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_INFO_HEIGHT', '160', 4, 9, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_INFO_MERGE', '(overlay.gif,10,-50,60,FF0000)', 4, 10, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_INFO_MOTION_BLUR', '', 4, 11, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_INFO_ROUND_EDGES', '', 4, 12, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_INFO_WIDTH', '200', 4, 13, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_POPUP_BEVEL', '(8,FFCCCC,330000)', 4, 14, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_POPUP_DROP_SHADDOW', '', 4, 15, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_POPUP_ELLIPSE', '', 4, 16, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_POPUP_FRAME', '', 4, 17, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_POPUP_GREYSCALE', '', 4, 18, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_POPUP_HEIGHT', '240', 4, 19, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_POPUP_MERGE', '(overlay.gif,10,-50,60,FF0000)', 4, 20, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_POPUP_MOTION_BLUR', '', 4, 21, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_POPUP_ROUND_EDGES', '', 4, 22, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_POPUP_WIDTH', '300', 4, 23, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_THUMBNAIL_BEVEL', '', 4, 24, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW', '', 4, 25, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_THUMBNAIL_ELLIPSE', '', 4, 26, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_THUMBNAIL_FRAME', '(FFFFFF,000000,3,EEEEEE)', 4, 27, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_THUMBNAIL_GREYSCALE', '', 4, 28, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_THUMBNAIL_HEIGHT', '80', 4, 29, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_THUMBNAIL_MERGE', '', 4, 30, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR', '(4,FFFFFF)', 4, 31, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES', '', 4, 32, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_THUMBNAIL_WIDTH', '120', 4, 33, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_IMAGE_ON_THE_FLY', 'false', 4, 34, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO prf_configuration VALUES (NULL, 'ACCOUNT_GENDER', 'true', 5, 1, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'ACCOUNT_DOB', 'true', 5, 2, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'ACCOUNT_COMPANY', 'true', 5, 3, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'ACCOUNT_SUBURB', 'true', 5, 4, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'ACCOUNT_STATE', 'true', 5, 5, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'ACCOUNT_OPTIONS', 'account', 5, 6, NULL, now(), NULL, 'olc_cfg_select_option(array(\'account\', \'guest\', \'both\'),');
INSERT INTO prf_configuration VALUES (NULL, 'DELETE_GUEST_ACCOUNT', 'true', 5, 7, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO prf_configuration VALUES (NULL, 'DEFAULT_CURRENCY', 'EUR', 6, 1, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'DEFAULT_LANGUAGE', 'de', 6, 2, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'DEFAULT_ORDERS_STATUS_ID', '1', 6, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'DEFAULT_SHIPPING_STATUS_ID', '1', 6, 4, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_EXPORT_INSTALLED', 'froogle.php;geizhals.php;image_processing.php;kelkoo.php;metashopper.php;milando.php;preisauskunft.php;preissuchmaschine.php;preistrend.php;vivendi.php', 6, 5, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_INSTALLED', 'ot_subtotal.php;ot_shipping.php;ot_tax.php;ot_total.php', 6, 6, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_PAYMENT_INSTALLED', '', 6, 7, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_SHIPPING_INSTALLED', '', 6, 8, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_FROOGLE_FILE', 'froogle.txt', 6, 9, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_FROOGLE_STATUS', 'True', 6, 10, NULL, now(), NULL, 'olc_cfg_select_option(array("True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_GEIZHALS_FILE', 'geizhals.csv', 6, 11, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_GEIZHALS_STATUS', 'True', 6, 12, NULL, now(), NULL, 'olc_cfg_select_option(array("True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_IMAGE_PROCESS_STATUS', 'True', 6, 13, NULL, now(), NULL, 'olc_cfg_select_option(array("True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_KELKOO_FILE', 'kelkoo.txt', 6, 14, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_KELKOO_STATUS', 'True', 6, 15, NULL, now(), NULL, 'olc_cfg_select_option(array("True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_METASHOPPER_FILE', 'metashopper.csv', 6, 16, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_METASHOPPER_STATUS', 'True', 6, 17, NULL, now(), NULL, 'olc_cfg_select_option(array("True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_MILANDO_FILE', 'milando.csv', 6, 18, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_MILANDO_STATUS', 'True', 6, 19, NULL, now(), NULL, 'olc_cfg_select_option(array("True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_DISCOUNT_STATUS', 'true', 6, 20, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_SHIPPING_STATUS', 'true', 6, 21, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_STATUS', 'true', 6, 22, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_SUBTOTAL_STATUS', 'true', 6, 23, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_TAX_STATUS', 'true', 6, 24, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_TOTAL_STATUS', 'true', 6, 25, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_PREISAUSKUNFT_FILE', 'preisauskunft.csv', 6, 26, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_PREISAUSKUNFT_STATUS', 'True', 6, 27, NULL, now(), NULL, 'olc_cfg_select_option(array("True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_PREISSUCHMASCHINE_FILE', 'preissuchmaschine.csv', 6, 28, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_PREISSUCHMASCHINE_STATUS', 'True', 6, 29, NULL, now(), NULL, 'olc_cfg_select_option(array("True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_PREISTREND_FILE', 'preistrend.txt', 6, 30, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_PREISTREND_STATUS', 'True', 6, 31, NULL, now(), NULL, 'olc_cfg_select_option(array("True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_VIVENDI_FILE', 'vivendi.csv', 6, 32, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_VIVENDI_STATUS', 'True', 6, 33, NULL, now(), NULL, 'olc_cfg_select_option(array("True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_SORT_ORDER', '40', 6, 34, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_DISCOUNT_SORT_ORDER', '20', 6, 35, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER', '30', 6, 36, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER', '10', 6, 37, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_TAX_SORT_ORDER', '50', 6, 38, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER', '99', 6, 39, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING', 'false', 6, 40, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER', '50', 6, 41, NULL, now(), 'currencies->format', NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_SHIPPING_DESTINATION', 'national', 6, 42, NULL, now(), NULL, 'olc_cfg_select_option(array(\'national\', \'international\', \'both\'),');

INSERT INTO prf_configuration VALUES (NULL, 'SHIPPING_ORIGIN_COUNTRY', '81', 7, 1, NULL, now(), 'olc_get_country_name', 'olc_cfg_pull_down_country_list(');
INSERT INTO prf_configuration VALUES (NULL, 'SHIPPING_ORIGIN_ZIP', '', 7, 2, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SHIPPING_MAX_WEIGHT', '50', 7, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SHIPPING_BOX_WEIGHT', '3', 7, 4, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SHIPPING_BOX_PADDING', '10', 7, 5, NULL, now(), NULL, NULL);

INSERT INTO prf_configuration VALUES (NULL, 'PRODUCT_LIST_FILTER', '1', 8, 1, NULL, now(), NULL, NULL);

INSERT INTO prf_configuration VALUES (NULL, 'STOCK_CHECK', 'true', 9, 1, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'ATTRIBUTE_STOCK_CHECK', 'true', 9, 2, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'STOCK_LIMITED', 'true', 9, 3, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'STOCK_ALLOW_CHECKOUT', 'true', 9, 4, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'STOCK_MARK_PRODUCT_OUT_OF_STOCK', '***', 9, 5, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STOCK_REORDER_LEVEL', '5', 9, 6, NULL, now(), NULL, NULL);

INSERT INTO prf_configuration VALUES (NULL, 'STORE_PAGE_PARSE_TIME', 'false', 10, 1, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'STORE_PAGE_PARSE_TIME_LOG', 'tmp/page_parse_time.log', 10, 2, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'STORE_PARSE_DATE_TIME_FORMAT', '%d.%m.%Y %H:%M:%S', 10, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'DISPLAY_PAGE_PARSE_TIME', 'true', 10, 4, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'STORE_DB_TRANSACTIONS', 'false', 10, 5, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO prf_configuration VALUES (NULL, 'CACHE_CHECK', 'true', 11, 1, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'USE_CACHE', 'false', 11, 2, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'DIR_FS_CACHE', 'cache', 11, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'CACHE_LIFETIME', '3600', 11, 4, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'DB_CACHE', 'false', 11, 5, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'DB_CACHE_EXPIRE', '3600', 11, 6, NULL, now(), NULL, NULL);

INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_TRANSPORT', 'mail', 12, 1, NULL, now(), NULL, 'olc_cfg_select_option(array(\'sendmail\', \'smtp\', \'mail\'),');
INSERT INTO prf_configuration VALUES (NULL, 'SENDMAIL_PATH', '/usr/sbin/sendmail', 12, 2, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SMTP_MAIN_SERVER', 'localhost', 12, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SMTP_Backup_Server', 'localhost', 12, 4, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SMTP_PORT', '25', 12, 5, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SMTP_USERNAME', 'Please Enter', 12, 6, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SMTP_PASSWORD', 'Please Enter', 12, 7, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SMTP_AUTH', 'false', 12, 8, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_LINEFEED', 'LF', 12, 9, NULL, now(), NULL, 'olc_cfg_select_option(array(\'LF\', \'CRLF\'),');
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_USE_HTML', 'false', 12, 10, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'ENTRY_EMAIL_ADDRESS_CHECK', 'false', 12, 11, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'SEND_EMAILS', 'true', 12, 12, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'CONTACT_US_EMAIL_ADDRESS', 'kontakt@ihr-shop.de', 12, 13, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'CONTACT_US_NAME', 'Mail sent by Contact_us Form', 12, 14, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'CONTACT_US_REPLY_ADDRESS',  '', 12, 15, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'CONTACT_US_REPLY_ADDRESS_NAME',  '', 12, 16, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'CONTACT_US_EMAIL_SUBJECT',  '', 12, 17, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'CONTACT_US_FORWARDING_STRING',  '', 12, 18, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_SUPPORT_ADDRESS', 'support@ihr-shop.de', 12, 19, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_SUPPORT_NAME', 'Mail sent by support systems', 12, 20, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_SUPPORT_REPLY_ADDRESS',  '', 12, 21, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_SUPPORT_REPLY_ADDRESS_NAME',  '', 12, 22, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_SUPPORT_SUBJECT',  '', 12, 23, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_SUPPORT_FORWARDING_STRING',  '', 12, 24, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_BILLING_ADDRESS', 'buchhaltung@ihr-shop.de', 12, 25, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_BILLING_NAME', 'Mail sent by billing systems', 12, 26, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_BILLING_REPLY_ADDRESS',  '', 12, 27, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_BILLING_REPLY_ADDRESS_NAME',  '', 12, 28, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_BILLING_SUBJECT',  '', 12, 29, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_BILLING_FORWARDING_STRING',  '', 12, 30, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_BILLING_SUBJECT_ORDER',  'Your order Nr:{$nr} / {$date}', 12, 31, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EMAIL_NEWSLETTER_PACAKGE_SIZE', '30', 12, 32, NULL, now(), NULL, NULL);

INSERT INTO prf_configuration VALUES (NULL, 'SEND_404_EMAIL', 'true', 12, 0, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO prf_configuration VALUES (NULL, 'DOWNLOAD_ENABLED', 'false', 13, 1, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'DOWNLOAD_BY_REDIRECT', 'false', 13, 2, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'DOWNLOAD_MAX_DAYS', '7', 13, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'DOWNLOAD_MAX_COUNT', '5', 13, 4, NULL, now(), NULL, NULL);

INSERT INTO prf_configuration VALUES (NULL, 'GZIP_COMPRESSION', 'false', 14, 1, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'GZIP_LEVEL', '5', 14, 2, NULL, now(), NULL, NULL);

INSERT INTO prf_configuration VALUES (NULL, 'SESSION_WRITE_DIRECTORY', '/tmp', 15, 1, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SESSION_FORCE_COOKIE_USE', 'False', 15, 2, NULL, now(), NULL, 'olc_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO prf_configuration VALUES (NULL, 'SESSION_CHECK_SSL_SESSION_ID', 'False', 15, 3, NULL, now(), NULL, 'olc_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO prf_configuration VALUES (NULL, 'SESSION_CHECK_USER_AGENT', 'False', 15, 4, NULL, now(), NULL, 'olc_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO prf_configuration VALUES (NULL, 'SESSION_CHECK_IP_ADDRESS', 'False', 15, 5, NULL, now(), NULL, 'olc_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO prf_configuration VALUES (NULL, 'SESSION_BLOCK_SPIDERS', 'False', 15, 6, NULL, now(), NULL, 'olc_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO prf_configuration VALUES (NULL, 'SESSION_RECREATE', 'False', 15, 7, NULL, now(), NULL, 'olc_cfg_select_option(array(\'True\', \'False\'),');

INSERT INTO prf_configuration VALUES (NULL, 'META_MIN_KEYWORD_LENGTH', '6', 16, 1, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'META_KEYWORDS_NUMBER', '5', 16, 2, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'META_AUTHOR', '', 16, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'META_PUBLISHER', '', 16, 4, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'META_COMPANY', '', 16, 5, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'META_TOPIC', 'shopping', 16, 6, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'META_REPLY_TO', 'xx@xx.com', 16, 7, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'META_REVISIT_AFTER', '14', 16, 8, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'META_ROBOTS', 'index,follow', 16, 9, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'META_DESCRIPTION', '', 16, 10, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'META_KEYWORDS', '', 16, 11, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SEARCH_ENGINE_FRIENDLY_URLS', 'false', 16, 12, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'USE_SEO_EXTENDED', 'true', 16, 13, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'SEO_SEPARATOR', '-', 16, 14, NULL, now(), NULL, 'olc_cfg_select_option(array(\'-\', \'/\'),');
INSERT IGNORE INTO prf_configuration VALUES (NULL, 'SEO_TERMINATOR', '.htm',  16, 16, NULL, now(), NULL, 'olc_cfg_select_option(array(\'.htm\', \'.html\'),');
INSERT IGNORE INTO prf_configuration VALUES (NULL, 'SPIDER_FOOD_ROWS', '100',  16, 17, NULL, now(), NULL, NULL);

INSERT INTO prf_configuration VALUES (NULL, 'USE_SPAW', 'true', 17, 1, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'ACTIVATE_GIFT_SYSTEM', 'false', 17, 2, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'SECURITY_CODE_LENGTH', '10', 17, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'NEW_SIGNUP_GIFT_VOUCHER_AMOUNT', '0', 17, 4, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'NEW_SIGNUP_DISCOUNT_COUPON', '', 17, 5, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'ACTIVATE_SHIPPING_STATUS', 'true', 17, 6, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'CHECK_CLIENT_AGENT', 'false', 17, 7, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'DISPLAY_CONDITIONS_ON_CHECKOUT', 'false', 17, 8, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'SHOW_IP_LOG', 'false', 17, 9, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'GROUP_CHECK', 'true', 17, 10, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'ACTIVATE_NAVIGATOR', 'false', 17, 11, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'QUICKLINK_ACTIVATED', 'true', 17, 12, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO prf_configuration VALUES (NULL, 'DOWN_FOR_MAINTENANCE', 'false', 18, 1, NULL, now(), NULL, 'olc_cfg_select_option(array("true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'EXCLUDE_ADMIN_IP_FOR_MAINTENANCE', 'Ihre IP (ADMIN)', 18, 2, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'ADMIN_PASSWORD_FOR_MAINTENANCE', 'olcommerce', 18, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'WARN_BEFORE_DOWN_FOR_MAINTENANCE', 'false', 18, 4, NULL, now(), NULL, 'olc_cfg_select_option(array("true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'PERIOD_DOWN_FOR_MAINTENANCE', '', 18, 5, NULL, now(), NULL, NULL);

#Affiliate Konfiguration
INSERT INTO prf_configuration_group VALUES (900, 'Affiliate Program', 'Optionen des "Affiliate" Programms', 1, 1);

INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_EMAIL_ADDRESS', 'affiliate@localhost.com', 900, 1, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_PERCENT', '10.0000', 900, 2, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_THRESHOLD', '50.00', 900, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_COOKIE_LIFETIME', '7200', 900, 4, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_BILLING_TIME', '30', 900, 5, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_PAYMENT_ORDER_MIN_STATUS', '3', 900, 6, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_USE_CHECK', 'true', 900, 7, NULL, now(), NULL, 'olc_cfg_select_option(array("true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_USE_PAYPAL', 'true', 900, 8, NULL, now(), NULL, 'olc_cfg_select_option(array("true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_USE_BANK', 'true', 900, 9, NULL, now(), NULL, 'olc_cfg_select_option(array("true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'AFFILATE_INDIVIDUAL_PERCENTAGE', 'true', 900, 10, NULL, now(), NULL, 'olc_cfg_select_option(array("true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'AFFILATE_USE_TIER', 'false', 900, 11, NULL, now(), NULL, 'olc_cfg_select_option(array("true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_TIER_LEVELS', '0', 900, 12, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_TIER_PERCENTAGE', '8.00;5.00;1.00', 900, 13, NULL, now(), NULL, NULL);

INSERT INTO prf_configuration VALUES (NULL, 'DEFAULT_PRODUCTS_VPE_ID', '0', 1000, 1, NULL, now(), NULL, NULL);

INSERT INTO prf_configuration_group VALUES ('1', 'Mein Geschäft', 'Allgemeine Informationen über mein Geschäft', '1', '1');
INSERT INTO prf_configuration_group VALUES ('100', 'Firmen-Daten', 'Name, Anschrift, eMail, Bank usw.', '1', '1');
INSERT INTO prf_configuration_group VALUES ('2', 'Minimale Werte', 'Die Minimal-Werte für Funktionen/Daten', '2', '1');
INSERT INTO prf_configuration_group VALUES ('3', 'Maximale Werte', 'Die Maximal-Werte für Funktionen/Daten', '3', '1');
INSERT INTO prf_configuration_group VALUES ('4', 'Bild-Parameter', 'Einstellungen für Bild-Parameter', '4', '1');
INSERT INTO prf_configuration_group VALUES ('5', 'Kunden-Details', 'Kunden-Konten Konfiguration', '5', '1');
INSERT INTO prf_configuration_group VALUES ('6', 'Modul-Optionen', 'Erweiterte Modul-Optionen', '6', '1');
INSERT INTO prf_configuration_group VALUES ('7', 'Versand-Optionen', 'Verfügbare Versand-Optionen', '7', '1');
INSERT INTO prf_configuration_group VALUES ('8', 'Produkt-Listen-Optionen', 'Konfiguration der Produkt-Listen-Optionen', '8', '1');
INSERT INTO prf_configuration_group VALUES ('9', 'Lager-Verwaltung', 'Konfiguration der Lager-Optionen', '9', '1');
INSERT INTO prf_configuration_group VALUES ('10', 'Logging-Optionen', 'Konfiguration der Logging-Optionen', '10', '1');
INSERT INTO prf_configuration_group VALUES ('11', 'Cache-Optionen', 'Konfiguration der Cache-Optionen', '11', '1');
INSERT INTO prf_configuration_group VALUES ('12', 'E-Mail Optionen', 'Optionen für den E-Mail Transport und HTML E-Mails', '12', '1');
INSERT INTO prf_configuration_group VALUES ('13', 'Download-Optionen', 'Optionen für Download-Produkte', '13', '1');
INSERT INTO prf_configuration_group VALUES ('14', 'GZip Kompression', 'Optionen für die GZip Kompression', '14', '1');
INSERT INTO prf_configuration_group VALUES ('15', 'Sessions', 'Konfiguration der Session-Optionen', '15', '1');
INSERT INTO prf_configuration_group VALUES ('16', 'Meta-Tags und Suchmaschinen', 'Konfiguration der Meta-Tags und Suchmaschinen-Optionen', '16', '1');

INSERT INTO prf_configuration_group VALUES ('19', 'Slideshows', 'Konfiguration der Slideshow-Optionen', '19', '1');
INSERT INTO prf_configuration_group VALUES ('20', 'Import/Export', 'Konfiguration der Import/Export-Optionen', '20', '1');

#Slideshow Konfiguration
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_INTERVAL', '5', 19, 0, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_INTERVAL_MIN', '3', 19, 1, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS', 'false', 19, 10, NULL, now(), NULL, 'olc_cfg_select_option(array("true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS_HEIGHT', '230', 19, 20, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS_WIDTH', '400', 19, 30, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS_BORDER', 'false', 19, 40, NULL, now(), NULL, 'olc_cfg_select_option(array("true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS_CONTROLS', 'true', 19, 41, NULL, now(), NULL, 'olc_cfg_select_option(array("true'', ''false''),');

INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_IMAGES', 'false', 19, 50, NULL, now(), NULL, 'olc_cfg_select_option(array("true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_IMAGES_HEIGHT', '230', 19, 60, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_IMAGES_WIDTH', '400', 19, 70, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_IMAGES_BORDER', 'false', 19, 80, NULL, now(), NULL, 'olc_cfg_select_option(array("true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_IMAGES_CONTROLS', 'true', 19, 81, NULL, now(), NULL, 'olc_cfg_select_option(array("true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_IMAGES_SHOW_TEXT', 'true', 19, 90, NULL, now(), NULL, 'olc_cfg_select_option(array("true'', ''false''),');

INSERT INTO prf_configuration VALUES (NULL, 'CSV_TEXTSIGN', '"', '20', '10', NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'CSV_SEPERATOR', '\t', '20', '20', NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'COMPRESS_EXPORT', 'false', '20', '30', NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');

#PDF-Rechnung Konfiguration
INSERT INTO prf_configuration_group VALUES (787, 'PDF-Rechnung', 'Einstellungen für die PDF-Rechnung', '17', '1');

INSERT INTO prf_configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
(NULL, 'PDF_INVOICE_ORDER_CONFIRMATION', '1', 787, 0, NULL, now(), NULL, NULL),
(NULL, 'PDF_INVOICE_MARK_COLOR', 'Black', 787, 1, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'PDF_INVOICE_MARK_COLOR_BG', 'Lightgrey', 787, 2, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'STORE_INVOICE_NUMBER', '12345', 787, 14, NULL, now(), NULL, NULL),
(NULL, 'STORE_PACKINGSLIP_NUMBER', '23456', 787, 15, NULL, now(), NULL, NULL);

#PDF-Datasheet Konfiguration
INSERT INTO prf_configuration_group VALUES (800, 'PDF-Datenblatt-Generator', 'Konfiguriert den PDF-Datenblatt-Generator', '18', 1);

INSERT INTO prf_configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
(NULL, 'PDF_SHOW_LOGO', '1', 800, 1, NULL, now(), NULL, NULL),
(NULL, 'PDF_IMAGE_KEEP_PROPORTIONS', '1', 800, 3, NULL, now(), NULL, NULL),
(NULL, 'PDF_MAX_IMAGE_WIDTH', '200', 800, 4, NULL, now(), NULL, NULL),
(NULL, 'PDF_MAX_IMAGE_HEIGHT', '200', 800, 5 , NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_WATERMARK', '1', 800, 6, NULL, now(), NULL, NULL),
(NULL, 'PDF_DOC_PATH', 'pdfdocs/', 800, 7, NULL, now(), NULL, NULL),
(NULL, 'PDF_FILE_REDIRECT', '0', 800, 8, NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_BACKGROUND', '0', 800, 9, NULL, now(), NULL, NULL),
(NULL, 'PDF_SAVE_DOCUMENT', '1', 800, 10, NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_PATH','1', 800, 11, NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_IMAGES','1', 800, 12, NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_MODEL','1', 800, 13, NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_SHIPPING_TIME','1', 800, 14, NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_DESCRIPTION','1', 800, 15, NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_SHORT_DESCRIPTION','1', 800, 16, NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_MANUFACTURER','1', 800, 17, NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_PRICE','1', 800, 18, NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_SPECIALS_PRICE','1', 800, 19, NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_SPECIALS_PRICE_EXPIRES','1', 800, 20, NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_OPTIONS','1', 800, 21, NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_OPTIONS_PRICE','1', 800, 22, NULL, now(), NULL, NULL),
(NULL, 'PDF_SHOW_DATE_ADDED_AVAILABLE','1', 800, 23, NULL, now(), NULL, NULL),
(NULL, 'PDF_PAGE_BG_COLOR', 'ivory', 800, 24, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'PDF_HEADER_COLOR_TABLE', 'brown', 800, 25, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'PDF_HEADER_COLOR_TEXT', 'firebrick', 800, 26, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'PDF_BODY_COLOR_TEXT', 'brown', 800, 27, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'PDF_PRODUCT_NAME_COLOR_TABLE', 'Lightgrey', 800, 28, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'PDF_PRODUCT_NAME_COLOR_TEXT', 'white', 800, 29, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'PDF_FOOTER_CELL_BG_COLOR', 'silver', 800, 30, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'PDF_FOOTER_CELL_TEXT_COLOR', 'black', 800, 31, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'PDF_SPECIAL_PRICE_COLOR_TEXT', 'red', 800, 32, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'PDF_PAGE_WATERMARK_COLOR', 'aliceblue', 800, 33, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'PDF_OPTIONS_COLOR', 'black', 800, 34, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'PDF_OPTIONS_BG_COLOR', 'Lightgrey', 800, 35, NULL, now(), NULL, 'olc_cfg_display_color_sample(');

#Menue/Templates Konfiguration
INSERT INTO prf_configuration_group VALUES (795, 'Menüs und Templates', 'Einstellungen für Menüs und Templates', '18', '1');

INSERT INTO prf_configuration VALUES (NULL, 'CURRENT_TEMPLATE', 'olc', 795, 10, NULL, now(), NULL, 'xtc_cfg_pull_down_template_sets(');
INSERT INTO prf_configuration VALUES (NULL, 'NO_BOX_LAYOUT', 'false', 795, 20, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'USE_UNIFIED_TEMPLATES', 'true', 795, 30, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'CHECK_UNIFIED_BOXES', 'false', 795, 40, NULL, now(), USE_CSS_MENU, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'OPEN_ALL_MENUE_LEVELS', 'false', 795,  50,  USE_CSS_MENU, now(), USE_CSS_MENU, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'SHOW_TAB_NAVIGATION', 'false', 795, 60, USE_CSS_MENU, now(), USE_CSS_MENU, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'USE_COOL_MENU', 'false', 795, 70, USE_CSS_MENU, now(), USE_CSS_MENU, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'USE_CSS_MENU', 'true', 795, 75, USE_CSS_MENU, now(), USE_CSS_MENU, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'PRODUCTS_LISTING_COLUMNS', '2', 795, 80, USE_CSS_MENU, now(), USE_CSS_MENU, 'xtc_cfg_select_option(array(\'1\', \'2\'),');

#Screen-Layout Konfiguration
INSERT INTO prf_box_configuration (box_id, template, box_key_name, box_visible, box_sort_order, box_forced_visible, box_real_name, box_position_name, last_modified, date_added) VALUES
(USE_CSS_MENU, 'olc', 'SHOW_ADMIN', 1, 1, 1, 'box_ADMIN', 'box_r_03', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_CART', 1, 2, 1, 'box_CART', 'box_r_01', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_CATEGORIES', 1, 3, 1, 'box_CATEGORIES', 'box_l_01', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_CONTENT', 1, 4, 1, 'box_CONTENT', 'box_l_05', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_INFOBOX', 1, 5, 1, 'box_INFOBOX', 'box_r_05', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_LOGIN', 1, 6, 1, 'box_LOGIN', 'box_r_02', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_MANUFACTURERS_INFO', 0, 7, 1, 'box_MANUFACTURERS_INFO', 'box_l_03', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_MANUFACTURERS', 0, 8, 1, 'box_MANUFACTURERS', 'box_l_02', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_SEARCH', 1, 9, 1, 'box_SEARCH', 'box_l_08', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_CHANGE_SKIN', 1, 10, 0, USE_CSS_MENU, USE_CSS_MENU, USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_ADD_A_QUICKIE', 1, 11, 0, 'box_ADD_A_QUICKIE', 'box_l_04', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_AFFILIATE', 1, 12, 0, 'box_AFFILIATE', 'box_l_13', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_BESTSELLERS', 1, 13, 0, 'box_BESTSELLERS', 'box_r_06', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_CENTER', 1, 14, 0, USE_CSS_MENU, USE_CSS_MENU, USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_CURRENCIES', 0, 15, 0, 'box_CURRENCIES', 'box_r_07', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_ORDER_HISTORY', 1, 16, 0, 'box_ORDER_HISTORY', 'box_l_12', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_INFORMATION', 1, 17, 0, 'box_INFORMATION', 'box_l_06', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_LANGUAGES', 0, 18, 0, 'box_LANGUAGES', 'box_r_08', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_LIVEHELP', 0, 19, 0, 'box_LIVEHELP', 'box_r_04', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_NEWSLETTER', 1, 20, 0, 'box_NEWSLETTER', 'box_r_10', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_LAST_VIEWED', 1, 22, 0, 'box_LAST_VIEWED', 'box_r_11', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_NOTIFICATIONS', 1, 23, 0, 'box_NOTIFICATIONS', 'box_r_09', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_REVIEWS', 1, 24, 0, 'box_REVIEWS', 'box_l_07', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_SPECIALS', 1, 25, 0, 'box_SPECIALS', 'box_l_09', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_TELL_FRIEND', 1, 26, 0, 'box_TELL_FRIEND', 'box_l_11', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_WHATSNEW', 1, 27, 0, 'box_WHATSNEW', 'box_l_10', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_TAB_NAVIGATION', 0, 28, 0, 'box_TAB_NAVIGATION', 'box_m_01', USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_PDF_CATALOG', 1, 29, 0, USE_CSS_MENU, USE_CSS_MENU, USE_CSS_MENU, now()),
(USE_CSS_MENU, 'olc', 'SHOW_GALLERY', 1, 30, 0, USE_CSS_MENU, USE_CSS_MENU, USE_CSS_MENU, now());

INSERT INTO prf_affiliate_payment_status VALUES (0, 1, 'Pending');
INSERT INTO prf_affiliate_payment_status VALUES (0, 2, 'Offen');
INSERT INTO prf_affiliate_payment_status VALUES (0, 3, 'Pendiente');
INSERT INTO prf_affiliate_payment_status VALUES (1, 1, 'Paid');
INSERT INTO prf_affiliate_payment_status VALUES (1, 2, 'Ausgezahlt');
INSERT INTO prf_affiliate_payment_status VALUES (1, 3, 'Pagado');

# Insert some needed Content to the content manager
# german Stuff
INSERT INTO prf_content_manager VALUES (USE_CSS_MENU, 0, 0, 2, 'Partner AGB', 'Unsere Affiliate AGB', 'Tragen Sie <strong>hier</strong> Ihre <EM><U>allgemeinen Geschäftsbedingungen</U></EM> für Ihr Partnerprogramm ein.', 900, '', 1, 900, 0, 0);
INSERT INTO prf_content_manager VALUES (USE_CSS_MENU, 0, 0, 2, 'Affiliate Info', 'Affiliate Informationen', 'Tragen Sie <strong>hier</strong> Ihre <EM><U>Informationen zum Affiliate Programm</U></EM> ein.', 900, '', 1, 901, 0, 0);
INSERT INTO prf_content_manager VALUES (USE_CSS_MENU, 0, 0, 2, 'Affiliate FAQ', 'Häufig gestellte Fragen', 'Tragen Sie <strong>hier</strong> Ihre <EM><U>FAQ zum Affiliate Programm</U></EM> ein.', 900, '', 1, 902, 0, 0);
# english stuff
INSERT INTO prf_content_manager VALUES (USE_CSS_MENU, 0, 0, 1, 'Partner T&C', 'Our Affiliate Terms and Conditions', 'Put in <strong>here</strong> your <EM><U>terms and conditions</U></EM> for your affiliate program.', 900, '', 1, 900, 0, 0);
INSERT INTO prf_content_manager VALUES (USE_CSS_MENU, 0, 0, 1, 'Affiliate Info', 'Affiliate Information', 'Put in <strong>here</strong> your <EM><U>information about your affiliate program</U></EM>.', 900, '', 1, 901, 0, 0);
INSERT INTO prf_content_manager VALUES (USE_CSS_MENU, 0, 0, 1, 'Affiliate FAQ', 'Frequently Asked Questions', 'Put in <strong>here</strong> some <EM><U>FAQ for your affiliate program</U></EM>.', 900, '', 1, 902, 0, 0);

# Insert some Content to the VPE
INSERT INTO prf_products_vpe VALUES (1, 1, 'Piece');
INSERT INTO prf_products_vpe VALUES (2, 1, 'ml,Content');
INSERT INTO prf_products_vpe VALUES (3, 1, 'gr,Weight');
INSERT INTO prf_products_vpe VALUES (4, 1, 'gr,Content');
INSERT INTO prf_products_vpe VALUES (1, 2, 'Stück');
INSERT INTO prf_products_vpe VALUES (2, 2, 'ml,Inhalt');
INSERT INTO prf_products_vpe VALUES (3, 2, 'gr,Gewicht');
INSERT INTO prf_products_vpe VALUES (4, 2, 'gr,Inhalt');

INSERT INTO prf_whos_online_data VALUES ('0', '', '');

#
#	eBay Connector
#
DROP TABLE IF EXISTS prf_auction_details;
CREATE TABLE prf_auction_details (
	id int(11) NOT USE_CSS_MENU auto_increment,
	auction_id bigint(20) NOT USE_CSS_MENU,
	transaction_id bigint(20) default '0',
	endtime timestamp USE_CSS_MENU default USE_CSS_MENU,
	auction_endprice double NOT USE_CSS_MENU,
	amount int(11) NOT USE_CSS_MENU,
	buyer_id varchar(255) NOT USE_CSS_MENU,
	buyer_name varchar(255) NOT USE_CSS_MENU,
	buyer_email varchar(255) NOT USE_CSS_MENU,
	buyer_countrycode varchar(255),
	buyer_land varchar(255) NOT USE_CSS_MENU,
	buyer_zip varchar(255) NOT USE_CSS_MENU,
	buyer_city varchar(255) NOT USE_CSS_MENU,
	buyer_street varchar(255) NOT USE_CSS_MENU,
	buyer_state varchar(255) NOT USE_CSS_MENU,
	buyer_phone varchar(32) NOT USE_CSS_MENU,
	basket tinyint(4) default '0',
	order_number bigint(20) default '0',
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS prf_auction_list;
CREATE TABLE prf_auction_list (
	auction_id bigint(20) NOT USE_CSS_MENU,
	auction_title varchar(255) NOT USE_CSS_MENU,
	product_id int(11) NOT USE_CSS_MENU,
	predef_id int(11) NOT USE_CSS_MENU,
	quantity int(11) NOT USE_CSS_MENU,
	startprice double NOT USE_CSS_MENU,
	buynowprice double NOT USE_CSS_MENU,
	buynow tinyint(4) NOT USE_CSS_MENU,
	starttime timestamp USE_CSS_MENU default USE_CSS_MENU,
	endtime timestamp USE_CSS_MENU default USE_CSS_MENU,
	bidcount bigint(20) default '0',
	bidprice double default '0',
	ended tinyint(4) default '0',
	PRIMARY KEY (auction_id)
);

DROP TABLE IF EXISTS prf_auction_predefinition;
CREATE TABLE prf_auction_predefinition (
	predef_id bigint(20) NOT USE_CSS_MENU auto_increment,
	product_id int(11) default USE_CSS_MENU,
	auction_type int(11) default USE_CSS_MENU,
	title varchar(255),
	subtitle varchar(255),
	cat1 bigint(20) default USE_CSS_MENU,
	cat2 bigint(20) default USE_CSS_MENU,
	description text,
	auction int(1) NOT USE_CSS_MENU,
	express int(1) NOT USE_CSS_MENU,
	express_duration int(1) NOT USE_CSS_MENU,
	duration int(11) default USE_CSS_MENU,
	amount int(11) default USE_CSS_MENU,
	startprice double default USE_CSS_MENU,
	binprice double default USE_CSS_MENU,
	city varchar(255),
	country varchar(255),
	pic_url text,
	gallery_pic_url varchar(255),
	gallery_pic_plus int(1) NOT USE_CSS_MENU,
	auto_resubmit int(1) NOT USE_CSS_MENU,
	bold tinyint(1) default USE_CSS_MENU,
	highlight tinyint(1) default USE_CSS_MENU,
	border tinyint(1) default USE_CSS_MENU,
	cod tinyint(1) default USE_CSS_MENU,
	cop tinyint(1) default USE_CSS_MENU,
	cc tinyint(1) default USE_CSS_MENU,
	paypal tinyint(1) default USE_CSS_MENU,
	de tinyint(1) default USE_CSS_MENU,
	at tinyint(1) default USE_CSS_MENU,
	ch tinyint(1) default USE_CSS_MENU,
	template varchar(255) default '',
	PRIMARY KEY (predef_id)
);

DROP TABLE IF EXISTS prf_ebay_auctiontype;
CREATE TABLE prf_ebay_auctiontype (
	id int(11) NOT USE_CSS_MENU,
	name varchar(255) NOT USE_CSS_MENU,
	description varchar(255) NOT USE_CSS_MENU,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS prf_ebay_categories;
CREATE TABLE prf_ebay_categories (
	myid bigint(20) NOT USE_CSS_MENU auto_increment,
	name varchar(100) NOT USE_CSS_MENU default '',
	id int(11) NOT USE_CSS_MENU default '0',
	parentid int(11) NOT USE_CSS_MENU default '0',
	leaf set('0','1') default '0',
	virtual set('0','1') NOT USE_CSS_MENU default '',
	expired set('0','1') NOT USE_CSS_MENU default '',
	PRIMARY KEY (myid)
);

DROP TABLE IF EXISTS prf_ebay_config;
CREATE TABLE prf_ebay_config (
	id int(11) NOT USE_CSS_MENU auto_increment,
	category_version varchar(5) default USE_CSS_MENU,
	category_update_time timestamp USE_CSS_MENU default USE_CSS_MENU,
	event_update_time timestamp USE_CSS_MENU default USE_CSS_MENU,
	transaction_update_time timestamp USE_CSS_MENU default USE_CSS_MENU,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS prf_ebay_products;
CREATE TABLE prf_ebay_products (
	products_id int(11) NOT USE_CSS_MENU,
	auction_description varchar(255) NOT USE_CSS_MENU,
	PRIMARY KEY (products_id)
);

INSERT INTO prf_ebay_auctiontype (id,name,description) VALUES
(1,'Chinese','1 Artikel, Steigerungsauktion + optional Fixpreis'),
(2,'Dutch','Mehrere Artikel, Steigerungsauktion + optional Fixpreis'),
(6,'StoresFixedPrice','eBay-Shop'),
(9,'FixedPriceItem','1 oder mehrere Artikel, Fixpreis'),
(12,'Express','eBay Express')
;

INSERT INTO prf_ebay_config (id,category_version,category_update_time,event_update_time,transaction_update_time) VALUES
(1,USE_CSS_MENU,USE_CSS_MENU,USE_CSS_MENU,USE_CSS_MENU);

#eBay Konfiguration
INSERT INTO prf_configuration_group VALUES (790, 'eBay-Konnektor', 'Einstellungen für den eBay-Konnektor', '17', '1');

INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'EBAY_MEMBER_NAME', 'ihr_ebay_name', 790, 0, USE_CSS_MENU, now(), USE_CSS_MENU, USE_CSS_MENU);
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'EBAY_REAL_SHOP_URL', 'http://www.mein-shop-server.de/', 790, 2, USE_CSS_MENU, now(), USE_CSS_MENU, USE_CSS_MENU);
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'EBAY_EBAY_EXPRESS_ONLY', 'false', 790, 10, USE_CSS_MENU, now(), USE_CSS_MENU, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'EBAY_SHIPPING_MODULE', '', 790, 20, USE_CSS_MENU, now(), USE_CSS_MENU, 'xtc_cfg_pull_down_shipping_list(');
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'EBAY_PAYPAL_EMAIL_ADDRESS', '', 790, 30, USE_CSS_MENU, now(), USE_CSS_MENU, USE_CSS_MENU);
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'EBAY_TEST_MODE', 'true', 790, 40, USE_CSS_MENU, now(), USE_CSS_MENU, 'xtc_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'EBAY_TEST_MODE_DEVID', '', 790, 42, USE_CSS_MENU, now(), USE_CSS_MENU, USE_CSS_MENU);
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'EBAY_TEST_MODE_APPID', '', 790, 44, USE_CSS_MENU, now(), USE_CSS_MENU, USE_CSS_MENU);
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'EBAY_TEST_MODE_CERTID', '', 790, 46, USE_CSS_MENU, now(), USE_CSS_MENU, USE_CSS_MENU);
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'EBAY_TEST_MODE_TOKEN', '', 790, 48, USE_CSS_MENU, now(), USE_CSS_MENU, 'xtc_cfg_textarea(');

INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'EBAY_PRODUCTION_DEVID', '', 790, 52, USE_CSS_MENU, now(), USE_CSS_MENU, USE_CSS_MENU);
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'EBAY_PRODUCTION_APPID', '', 790, 54, USE_CSS_MENU, now(), USE_CSS_MENU, USE_CSS_MENU);
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'EBAY_PRODUCTION_CERTID', '', 790, 56, USE_CSS_MENU, now(), USE_CSS_MENU, USE_CSS_MENU);
INSERT INTO prf_configuration VALUES (USE_CSS_MENU, 'EBAY_PRODUCTION_TOKEN', '', 790, 58, USE_CSS_MENU, now(), USE_CSS_MENU, 'xtc_cfg_textarea(');
#End