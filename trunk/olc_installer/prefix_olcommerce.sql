#SET SESSION sql_mode='';
#
#!!!!!Für MySQL 5 das Zeichen '#' in der 1. Zeile entfernen!!!!!
#
# -----------------------------------------------------------------------------------------
#  $Id: prefix_olcommerce.sql,v 1.1.1.1.2.1 2007/04/08 07:18:31 gswkaiser Exp $
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
#         (do not use inline comments)
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

DROP TABLE IF EXISTS prf_address_format;
CREATE TABLE IF NOT EXISTS prf_address_format (
  address_format_id int(11) NOT NULL auto_increment,
  address_format varchar(128) NOT NULL default '',
  address_summary varchar(48) NOT NULL default '',
  PRIMARY KEY (address_format_id)
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

DROP TABLE IF EXISTS prf_banktransfer_blz;
CREATE TABLE IF NOT EXISTS prf_banktransfer_blz (
  blz int(8) NOT NULL default '0',
  bankname varchar(58) NOT NULL default '',
  prz char(2) NOT NULL default '',
  land varchar(5) NOT NULL default '',
  plz varchar(5) NOT NULL default '',
  ort varchar(35) NOT NULL default '',
  bankname_kurz varchar(27) NOT NULL default '',
  KEY blz (blz),
  KEY plz (plz),
  KEY ort (ort),
  KEY land (land)
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

DROP TABLE IF EXISTS prf_categories;
CREATE TABLE IF NOT EXISTS prf_categories (
  categories_id int(11) NOT NULL auto_increment,
  categories_image varchar(64) default NULL,
  parent_id int(11) NOT NULL default '0',
  categories_status tinyint(1) unsigned NOT NULL default '1',
  categories_template varchar(64) default NULL,
  group_ids text,
  listing_template varchar(64) default NULL,
  sort_order int(3) default NULL,
  products_sorting varchar(32) default NULL,
  products_sorting2 varchar(32) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  PRIMARY KEY (categories_id),
  KEY idx_categories_parent_id (parent_id)
);

DROP TABLE IF EXISTS prf_categories_description;
CREATE TABLE IF NOT EXISTS prf_categories_description (
  categories_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  categories_name varchar(32) NOT NULL default '',
  categories_heading_title varchar(255) NOT NULL default '',
  categories_description text NOT NULL,
  categories_meta_title varchar(100) NOT NULL default '',
  categories_meta_description varchar(255) NOT NULL default '',
  categories_meta_keywords varchar(255) NOT NULL default '',
  PRIMARY KEY (categories_id,language_id),
  KEY idx_categories_name (categories_name)
);

DROP TABLE IF EXISTS prf_cm_file_flags;
CREATE TABLE IF NOT EXISTS prf_cm_file_flags (
  file_flag int(11) NOT NULL default '0',
  file_flag_name varchar(32) NOT NULL default '',
  PRIMARY KEY (file_flag)
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

DROP TABLE IF EXISTS prf_countries;
CREATE TABLE IF NOT EXISTS prf_countries (
  countries_id int(11) NOT NULL auto_increment,
  countries_name varchar(64) NOT NULL default '',
  countries_iso_code_2 char(2) NOT NULL default '',
  countries_iso_code_3 char(3) NOT NULL default '',
  address_format_id int(11) NOT NULL default '0',
  PRIMARY KEY (countries_id),
  KEY IDX_countries_NAME (countries_name)
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

DROP TABLE IF EXISTS prf_currencies;
CREATE TABLE IF NOT EXISTS prf_currencies (
  currencies_id int(11) NOT NULL auto_increment,
  title varchar(32) NOT NULL default '',
  code char(3) NOT NULL default '',
  symbol_left varchar(12) default NULL,
  symbol_right varchar(12) default NULL,
  decimal_point char(1) default NULL,
  thousands_point char(1) default NULL,
  decimal_places char(1) default NULL,
  value float(13,8) default NULL,
  last_updated datetime default NULL,
  PRIMARY KEY (currencies_id)
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

DROP TABLE IF EXISTS prf_geo_zones;
CREATE TABLE IF NOT EXISTS prf_geo_zones (
  geo_zone_id int(11) NOT NULL auto_increment,
  geo_zone_name varchar(32) NOT NULL default '',
  geo_zone_description varchar(255) NOT NULL default '',
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (geo_zone_id)
);

DROP TABLE IF EXISTS prf_languages;
CREATE TABLE IF NOT EXISTS prf_languages (
  languages_id int(11) NOT NULL auto_increment,
  name varchar(32) NOT NULL default '',
  code char(2) NOT NULL default '',
  image varchar(64) default NULL,
  directory varchar(32) default NULL,
  sort_order int(3) default NULL,
  language_charset text NOT NULL,
  PRIMARY KEY (languages_id),
  KEY IDX_LANGUAGES_NAME (name)
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

DROP TABLE IF EXISTS prf_orders_status;
CREATE TABLE IF NOT EXISTS prf_orders_status (
  orders_status_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  orders_status_name varchar(32) NOT NULL default '',
  PRIMARY KEY (orders_status_id,language_id),
  KEY idx_orders_status_name (orders_status_name)
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

DROP TABLE IF EXISTS prf_payment_moneybookers_countries;
CREATE TABLE IF NOT EXISTS prf_payment_moneybookers_countries (
  osc_cID int(11) NOT NULL default '0',
  mb_cID char(3) NOT NULL default '',
  PRIMARY KEY (osc_cID)
);

DROP TABLE IF EXISTS prf_payment_moneybookers_currencies;
CREATE TABLE IF NOT EXISTS prf_payment_moneybookers_currencies (
  mb_currID char(3) NOT NULL default '',
  mb_currName varchar(255) NOT NULL default '',
  PRIMARY KEY (mb_currID)
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

DROP TABLE IF EXISTS prf_plz;
CREATE TABLE IF NOT EXISTS prf_plz (
  plz varchar(5) NOT NULL default '',
  ort varchar(50) NOT NULL default '',
  land char(3) NOT NULL default '',
  bundesland char(2) NOT NULL default '',
  vorwahl char(6) NOT NULL default '',
  KEY plz (plz),
  KEY land (land)
);

DROP TABLE IF EXISTS prf_products;
CREATE TABLE IF NOT EXISTS prf_products (
  products_id int(11) NOT NULL auto_increment,
  products_ean varchar(128),
  products_quantity int(4) NOT NULL default 0,
  products_shippingtime int(4) NOT NULL default 0,
  products_model varchar(64) default NULL,
  group_ids text,
  products_sort int(4) default NULL,
  products_image varchar(64) default NULL,
	products_image_medium VARCHAR( 64 ) NOT NULL,
	products_image_large VARCHAR( 64 ) NOT NULL,
  products_price decimal(15,4) NOT NULL default '0.0000',
  products_discount_allowed decimal(3,2) NOT NULL default '0.00',
  products_date_added datetime NOT NULL default '0000-00-00 00:00:00',
  products_last_modified datetime default NULL,
  products_date_available datetime default NULL,
  products_weight decimal(5,2) NOT NULL default '0.00',
  products_status tinyint(1) NOT NULL default '0',
  products_promotion_status tinyint(1) NOT NULL default '0',
  products_promotion_show_title tinyint(1) NOT NULL default '0',
  products_promotion_show_desc tinyint(1) NOT NULL default '0',
  products_tax_class_id int(11) NOT NULL default '0',
  product_template varchar(64) default NULL,
  options_template varchar(64) default NULL,
  manufacturers_id int(11) default NULL,
  products_ordered int(11) NOT NULL default '0',
  products_fsk18 int(1) NOT NULL default '0',
  products_uvp decimal(15,2) NOT NULL default '0',
  products_vpe int(1) NOT NULL default '0',
  products_vpe_status int(11) NOT NULL default '0',
  products_vpe_value decimal(15,2) NOT NULL default '0.00',
  products_baseprice_show int(1) default NULL,
  products_baseprice_value decimal(15,2) default NULL,
  products_min_order_quantity int(11) default NULL,
  products_min_order_vpe int(11) default NULL,
  PRIMARY KEY (products_id),
  KEY idx_products_date_added (products_date_added),
  KEY products_model (products_model)
);

DROP TABLE IF EXISTS prf_products_attributes;
CREATE TABLE IF NOT EXISTS prf_products_attributes (
  products_attributes_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  options_id int(11) NOT NULL default '0',
  options_values_id int(11) NOT NULL default '0',
  options_values_price decimal(15,4) NOT NULL default '0.0000',
  price_prefix char(1) NOT NULL default '',
  attributes_model varchar(64) default NULL,
  attributes_stock int(4) default NULL,
  options_values_weight decimal(15,4) NOT NULL default '0.0000',
  weight_prefix char(1) NOT NULL default '',
  sortorder int(11) default NULL,
  PRIMARY KEY (products_attributes_id)
);

DROP TABLE IF EXISTS prf_products_attributes_download;
CREATE TABLE IF NOT EXISTS prf_products_attributes_download (
  products_attributes_id int(11) NOT NULL default '0',
  products_attributes_filename varchar(255) NOT NULL default '',
  products_attributes_maxdays int(2) default '0',
  products_attributes_maxcount int(2) default '0',
  PRIMARY KEY (products_attributes_id)
);

DROP TABLE IF EXISTS prf_products_content;
CREATE TABLE IF NOT EXISTS prf_products_content (
  content_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  content_name varchar(32) NOT NULL default '',
  content_file varchar(64) NOT NULL default '',
  content_link text NOT NULL,
  languages_id int(11) NOT NULL default '0',
  content_read int(11) NOT NULL default '0',
  file_comment text NOT NULL,
  PRIMARY KEY (content_id)
);

DROP TABLE IF EXISTS prf_products_description;
CREATE TABLE IF NOT EXISTS prf_products_description (
  products_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  products_name varchar(64) NOT NULL default '',
  products_description text,
  products_short_description text,
  products_meta_title text NOT NULL,
  products_meta_description text NOT NULL,
  products_meta_keywords text NOT NULL,
  products_url varchar(255) default NULL,
  products_viewed int(11) default '0',
  products_promotion_desc text,
  products_promotion_title varchar(255) default NULL,
  products_promotion_image varchar(255) default NULL,
  PRIMARY KEY (products_id,language_id),
  KEY products_name (products_name)
);

DROP TABLE IF EXISTS prf_products_graduated_prices;
CREATE TABLE IF NOT EXISTS prf_products_graduated_prices (
  products_id int(11) NOT NULL default '0',
  quantity int(11) NOT NULL default '0',
  unitprice decimal(15,4) NOT NULL default '0.0000',
  KEY products_id (products_id)
);

DROP TABLE IF EXISTS prf_products_images;
CREATE TABLE IF NOT EXISTS prf_products_images (
  image_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  image_nr smallint(6) NOT NULL default '0',
  image_name varchar(254) NOT NULL default '',
  PRIMARY KEY (image_id)
);

DROP TABLE IF EXISTS prf_products_notifications;
CREATE TABLE IF NOT EXISTS prf_products_notifications (
  products_id int(11) NOT NULL default '0',
  customers_id int(11) NOT NULL default '0',
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (products_id,customers_id)
);

DROP TABLE IF EXISTS prf_products_options;
CREATE TABLE IF NOT EXISTS prf_products_options (
  products_options_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  products_options_name varchar(32) NOT NULL default '',
  PRIMARY KEY (products_options_id,language_id)
);

DROP TABLE IF EXISTS prf_products_options_values;
CREATE TABLE IF NOT EXISTS prf_products_options_values (
  products_options_values_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  products_options_values_name varchar(64) NOT NULL default '',
  PRIMARY KEY (products_options_values_id,language_id)
);

DROP TABLE IF EXISTS prf_products_options_values_to_products_options;
CREATE TABLE IF NOT EXISTS prf_products_options_values_to_products_options (
  products_options_values_to_products_options_id int(11) NOT NULL auto_increment,
  products_options_id int(11) NOT NULL default '0',
  products_options_values_id int(11) NOT NULL default '0',
  PRIMARY KEY (products_options_values_to_products_options_id)
);

DROP TABLE IF EXISTS prf_products_to_categories;
CREATE TABLE IF NOT EXISTS prf_products_to_categories (
  products_id int(11) NOT NULL default '0',
  categories_id int(11) NOT NULL default '0',
  PRIMARY KEY (products_id,categories_id)
);

DROP TABLE IF EXISTS prf_products_vpe;
CREATE TABLE IF NOT EXISTS prf_products_vpe (
  products_vpe_id int(1) NOT NULL default '0',
  language_id int(11) NOT NULL default '0',
  products_vpe_name varchar(32) NOT NULL default ''
);

DROP TABLE IF EXISTS prf_products_xsell;
CREATE TABLE IF NOT EXISTS prf_products_xsell (
  ID int(10) NOT NULL auto_increment,
  products_id int(10) unsigned NOT NULL default '1',
  xsell_id int(10) unsigned NOT NULL default '1',
  sort_order int(10) unsigned NOT NULL default '1',
  PRIMARY KEY (ID)
);

DROP TABLE IF EXISTS prf_reviews;
CREATE TABLE IF NOT EXISTS prf_reviews (
  reviews_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  customers_id int(11) default NULL,
  customers_name varchar(64) NOT NULL default '',
  reviews_rating int(1) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  reviews_read int(5) NOT NULL default '0',
  PRIMARY KEY (reviews_id)
);

DROP TABLE IF EXISTS prf_reviews_description;
CREATE TABLE IF NOT EXISTS prf_reviews_description (
  reviews_id int(11) NOT NULL default '0',
  languages_id int(11) NOT NULL default '0',
  reviews_text text NOT NULL,
  PRIMARY KEY (reviews_id,languages_id)
);

DROP TABLE IF EXISTS prf_sessions;
CREATE TABLE IF NOT EXISTS prf_sessions (
  sesskey varchar(32) NOT NULL default '',
  expiry int(11) unsigned NOT NULL default '0',
  value text NOT NULL,
  PRIMARY KEY (sesskey),
  KEY expiry (expiry)
);

DROP TABLE IF EXISTS prf_shipping_status;
CREATE TABLE IF NOT EXISTS prf_shipping_status (
  shipping_status_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  shipping_status_name varchar(32) NOT NULL default '',
  shipping_status_image varchar(32) NOT NULL default '',
  PRIMARY KEY (shipping_status_id,language_id),
  KEY idx_shipping_status_name (shipping_status_name)
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

DROP TABLE IF EXISTS prf_tax_class;
CREATE TABLE IF NOT EXISTS prf_tax_class (
  tax_class_id int(11) NOT NULL auto_increment,
  tax_class_title varchar(32) NOT NULL default '',
  tax_class_description varchar(255) NOT NULL default '',
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (tax_class_id)
);

DROP TABLE IF EXISTS prf_tax_rates;
CREATE TABLE IF NOT EXISTS prf_tax_rates (
  tax_rates_id int(11) NOT NULL auto_increment,
  tax_zone_id int(11) NOT NULL default '0',
  tax_class_id int(11) NOT NULL default '0',
  tax_priority int(5) default '1',
  tax_rate decimal(7,4) NOT NULL default '0.0000',
  tax_description varchar(255) NOT NULL default '',
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (tax_rates_id)
);

DROP TABLE IF EXISTS prf_vornamen;
CREATE TABLE IF NOT EXISTS prf_vornamen (
  vorname varchar(20) NOT NULL default '',
  geschlecht text NOT NULL,
  KEY vorname (vorname)
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

DROP TABLE IF EXISTS prf_zones;
CREATE TABLE IF NOT EXISTS prf_zones (
  zone_id int(11) NOT NULL auto_increment,
  zone_country_id int(11) NOT NULL default '0',
  zone_code varchar(32) NOT NULL default '',
  zone_name varchar(32) NOT NULL default '',
  PRIMARY KEY (zone_id)
);

DROP TABLE IF EXISTS prf_zones_to_geo_zones;
CREATE TABLE IF NOT EXISTS prf_zones_to_geo_zones (
  association_id int(11) NOT NULL auto_increment,
  zone_country_id int(11) NOT NULL default '0',
  zone_id int(11) default NULL,
  geo_zone_id int(11) default NULL,
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (association_id)
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

INSERT INTO prf_cm_file_flags (file_flag, file_flag_name) VALUES ('0', 'information');
INSERT INTO prf_cm_file_flags (file_flag, file_flag_name) VALUES ('1', 'content');
INSERT INTO prf_cm_file_flags (file_flag, file_flag_name) VALUES ('2', 'links');
INSERT INTO prf_cm_file_flags (file_flag, file_flag_name) VALUES ('900', 'affiliate');

INSERT INTO prf_shipping_status VALUES (1, 1, '3-4 Days', 'ampel_gruen.gif');
INSERT INTO prf_shipping_status VALUES (1, 2, '3-4 Tage', 'ampel_gruen.gif');
INSERT INTO prf_shipping_status VALUES (2, 1, '1 Week', 'ampel_gelb.gif');
INSERT INTO prf_shipping_status VALUES (2, 2, '1 Woche', 'ampel_gelb.gif');
INSERT INTO prf_shipping_status VALUES (3, 1, '2 Weeks', 'ampel_rot.gif');
INSERT INTO prf_shipping_status VALUES (3, 2, '2 Wochen', 'ampel_rot.gif');

# data

INSERT INTO prf_content_manager VALUES (1, 0, 0, 1, 'Shipping & Returns', 'Shipping & Returns', 'Put here your Shipping & Returns information.', 1, '', 1, 1, 0, 0);
INSERT INTO prf_content_manager VALUES (2, 0, 0, 1, 'Privacy Notice', 'Privacy Notice', 'Put here your Privacy Notice information.', 1, '', 1, 2, 0, 0);
INSERT INTO prf_content_manager VALUES (3, 0, 0, 1, 'Conditions of Use', 'Conditions of Use', 'Conditions of Use<br />Put here your Conditions of Use information. <br />1. Validity<br />2. Offers<br />3. Price<br />4. Dispatch and passage of the risk<br />5. Delivery<br />6. Terms of payment<br />7. Retention of title<br />8. Notices of defect, guarantee and compensation<br />9. Fair trading cancelling / non-acceptance<br />10. Place of delivery and area of jurisdiction<br />11. Final clauses', 1, '', 1, 3, 0, 0);
INSERT INTO prf_content_manager VALUES (4, 0, 0, 1, 'Impressum', 'Impressum', 'Put your&nbsp;Company information here.', 1, '', 1, 4, 0, 0);
INSERT INTO prf_content_manager VALUES (5, 0, 0, 1, 'Index', 'Willkommen', '{$greeting}<br/><br/> Dies ist die Standardinstallation des osCommerce Forking Projektes - OL-Commerce. Alle dargestellten Produkte dienen zur Demonstration der Funktionsweise. Wenn Sie Produkte bestellen, so werden diese weder ausgeliefert, noch in Rechnung gestellt. Alle Informationen zu den verschiedenen Produkten sind erfunden und daher kann kein Anspruch daraus abgeleitet werden.<br/><br/>Sollten Sie daran interessiert sein das Programm, welches die Grundlage für diesen Shop bildet, einzusetzen, so besuchen Sie bitte die Supportseite von OL-Commerce. Dieser Shop basiert auf OL-Commerce/AJAX <br/><br/>Der hier dargestellte Text kann im Admin-Bereich unter dem Punkt <b>Inhalte Manager</b>-Eintrag <b>Index</b> bearbeitet werden.', 1, '', 0, 5, 0, 0);
INSERT INTO prf_content_manager VALUES (6, 0, 0, 2, 'Liefer- und Versandkosten', 'Liefer- und Versandkosten', 'Fügen Sie hier Ihre Informationen über Liefer- und Versandkosten ein.', 1, '', 1, 1, 0, 0);
INSERT INTO prf_content_manager VALUES (7, 0, 0, 2, 'Privatsphäre und Datenschutz', 'Privatsphäre und Datenschutz', 'Fügen Sie hier Ihre Informationen über Privatsphäre und Datenschutz ein.', 1, '', 1, 2, 0, 0);
INSERT INTO prf_content_manager VALUES (8, 0, 0, 2, 'Unsere AGB\'s', 'Allgemeine Geschäftsbedingungen', '<strong>Allgemeine Geschäftsbedingungen<br/></strong><br/>Fügen Sie hier Ihre allgemeinen Geschäftsbedingungen ein.<br/>1. Geltung<br/>2. Angebote<br/>3. Preis<br/>4. Versand und Gefahrübergang<br/>5. Lieferung<br/>6. Zahlungsbedingungen<br/>7. Eigentumsvorbehalt <br/>8. Mängelrügen, Gewährleistung und Schadenersatz<br/>9. Kulanzrücknahme/Annahmeverweigerung<br/>10. Erfüllungsort und Gerichtsstand<br/>11. Schlussbestimmungen', 1, '', 1, 3, 0, 0);
INSERT INTO prf_content_manager VALUES (9, 0, 0, 2, 'Impressum', 'Impressum', 'Fügen Sie hier Ihr Impressum ein.', 1, '', 1, 4, 0, 0);
INSERT INTO prf_content_manager VALUES (10, 0, 0, 2, 'Index', 'Willkommen', '<p>{$greeting}<br/><br/>Dies ist die Standardinstallation des osCommerce Forking Projektes - OL-Commerce. Alle dargestellten Produkte dienen zur Demonstration der Funktionsweise. Wenn Sie Produkte bestellen, so werden diese weder ausgeliefert, noch in Rechnung gestellt. Alle Informationen zu den verschiedenen Produkten sind erfunden und daher kann kein Anspruch daraus abgeleitet werden.<br/><br/>Sollten Sie daran interessiert sein das Programm, welches die Grundlage für diesen Shop bildet, einzusetzen, so besuchen Sie bitte die Supportseite von OL-Commerce. Dieser Shop basiert auf der OL-Commerce Version v4/AJAX<br/><br/>Der hier dargestellte Text kann im AdminInterface unter dem Punkt <B>Content Manager</B> - Eintrag <b>Index</b> bearbeitet werden.</p>', 1, '', 0, 5, 0, 0);
INSERT INTO prf_content_manager VALUES (11, 0, 0, 2, 'Gutscheine', 'Gutscheine - Fragen und Antworte', '<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Gutscheine kaufen </strong></td></tr>\r\n<tr>\r\n<td class=main>Gutscheine können, falls sie im Shop angeboten werden, wie normale Artikel gekauft werden. Sobald Sie einen Gutschein gekauft haben und dieser nach erfolgreicher Zahlung freigeschaltet wurde, erscheint der Betrag unter Ihrem Warenkorb. Nun können Sie über den Link " Gutschein versenden " den gewünschten Betrag per E-Mail versenden. </td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Wie man Gutscheine versendet </strong></td></tr>\r\n<tr>\r\n<td class=main>Um einen Gutschein zu versenden, klicken Sie bitte auf den Link "Gutschein versenden" in Ihrem Einkaufskorb. Um einen Gutschein zu versenden, benötigen wir folgende Angaben von Ihnen: Vor- und Nachname des Empfängers. Eine gültige E-Mail Adresse des Empfängers. Den gewünschten Betrag (Sie können auch Teilbeträge Ihres Guthabens versenden). Eine kurze Nachricht an den Empfänger. Bitte überprüfen Sie Ihre Angaben noch einmal vor dem Versenden. Sie haben vor dem Versenden jederzeit die Möglichkeit Ihre Angaben zu korrigieren. </td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Mit Gutscheinen Einkaufen. </strong></td></tr>\r\n<tr>\r\n<td class=main>Sobald Sie über ein Guthaben verfügen, können Sie dieses zum Bezahlen Ihrer Bestellung verwenden. Während des Bestellvorganges haben Sie die Möglichkeit Ihr Guthaben einzulösen. Falls das Guthaben unter dem Warenwert liegt müssen Sie Ihre bevorzugte Zahlungsweise für den Differenzbetrag wählen. Übersteigt Ihr Guthaben den Warenwert, steht Ihnen das Restguthaben selbstverständlich für Ihre nächste Bestellung zur Verfügung. </td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Gutscheine verbuchen. </strong></td></tr>\r\n<tr>\r\n<td class=main>Wenn Sie einen Gutschein per E-Mail erhalten haben, können Sie den Betrag wie folgt verbuchen:. <br/>1. Klicken Sie auf den in der E-Mail angegebenen Link. Falls Sie noch nicht über ein persönliches Kundenkonto verfügen, haben Sie die Möglichkeit ein Konto zu eröffnen. <br/>2. Nachdem Sie ein Produkt in den Warenkorb gelegt haben, können Sie dort Ihren Gutscheincode eingeben.</td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Falls es zu Problemen kommen sollte: </strong></td></tr>\r\n<tr>\r\n<td class=main>Falls es wider Erwarten zu Problemen mit einem Gutschein kommen sollte, kontaktieren Sie uns bitte per E-Mail : you@yourdomain.com. Bitte beschreiben Sie möglichst genau das Problem, wichtige Angaben sind unter anderem: Ihre Kundennummer, der Gutscheincode, Fehlermeldungen des Systems sowie der von Ihnen benutzte Browser. </td></tr></TBODY></table>', 1, '', 0, 6, 1, 0);
INSERT INTO prf_content_manager VALUES (12, 0, 0, 1, 'Gutscheine', 'Gutscheine - Fragen und Antworte', '<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Gutscheine kaufen </strong></td></tr>\r\n<tr>\r\n<td class=main>Gutscheine können, falls sie im Shop angeboten werden, wie normale Artikel gekauft werden. Sobald Sie einen Gutschein gekauft haben und dieser nach erfolgreicher Zahlung freigeschaltet wurde, erscheint der Betrag unter Ihrem Warenkorb. Nun können Sie über den Link " Gutschein versenden " den gewünschten Betrag per E-Mail versenden. </td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Wie man Gutscheine versendet </strong></td></tr>\r\n<tr>\r\n<td class=main>Um einen Gutschein zu versenden, klicken Sie bitte auf den Link "Gutschein versenden" in Ihrem Einkaufskorb. Um einen Gutschein zu versenden, benötigen wir folgende Angaben von Ihnen: Vor- und Nachname des Empfängers. Eine gültige E-Mail Adresse des Empfängers. Den gewünschten Betrag (Sie können auch Teilbeträge Ihres Guthabens versenden). Eine kurze Nachricht an den Empfänger. Bitte überprüfen Sie Ihre Angaben noch einmal vor dem Versenden. Sie haben vor dem Versenden jederzeit die Möglichkeit Ihre Angaben zu korrigieren. </td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Mit Gutscheinen Einkaufen. </strong></td></tr>\r\n<tr>\r\n<td class=main>Sobald Sie über ein Guthaben verfügen, können Sie dieses zum Bezahlen Ihrer Bestellung verwenden. Während des Bestellvorganges haben Sie die Möglichkeit Ihr Guthaben einzulösen. Falls das Guthaben unter dem Warenwert liegt müssen Sie Ihre bevorzugte Zahlungsweise für den Differenzbetrag wählen. Übersteigt Ihr Guthaben den Warenwert, steht Ihnen das Restguthaben selbstverständlich für Ihre nächste Bestellung zur Verfügung. </td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Gutscheine verbuchen. </strong></td></tr>\r\n<tr>\r\n<td class=main>Wenn Sie einen Gutschein per E-Mail erhalten haben, können Sie den Betrag wie folgt verbuchen:. <br/>1. Klicken Sie auf den in der E-Mail angegebenen Link. Falls Sie noch nicht über ein persönliches Kundenkonto verfügen, haben Sie die Möglichkeit ein Konto zu eröffnen. <br/>2. Nachdem Sie ein Produkt in den Warenkorb gelegt haben, können Sie dort Ihren Gutscheincode eingeben.</td></tr></TBODY></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<TBODY>\r\n<tr>\r\n<td class=main><strong>Falls es zu Problemen kommen sollte: </strong></td></tr>\r\n<tr>\r\n<td class=main>Falls es wider Erwarten zu Problemen mit einem Gutschein kommen sollte, kontaktieren Sie uns bitte per E-Mail : you@yourdomain.com. Bitte beschreiben Sie möglichst genau das Problem, wichtige Angaben sind unter anderem: Ihre Kundennummer, der Gutscheincode, Fehlermeldungen des Systems sowie der von Ihnen benutzte Browser. </td></tr></TBODY></table>', 1, '', 0, 6, 1, 0);
INSERT INTO prf_content_manager VALUES (13, 0, 0, 2, 'Kontakt', 'Kontakt', '<p>Ihre Kontaktinformationen</p>', 1, '', 1, 7, 0, 0);

INSERT INTO prf_content_manager VALUES (14, 0, 0, 1, 'Contact', 'Contact', 'Please enter your contact informations.', 1, '', 1, 7, 0, 0);

# 1 - Default, 2 - USA, 3 - Spain, 4 - Singapore, 5 - Germany
INSERT INTO prf_address_format VALUES (1, '$firstname $lastname$cr$streets$cr$city, $postcode$cr$statecomma$country','$city / $country');
INSERT INTO prf_address_format VALUES (2, '$firstname $lastname$cr$streets$cr$city, $state    $postcode$cr$country','$city, $state / $country');
INSERT INTO prf_address_format VALUES (3, '$firstname $lastname$cr$streets$cr$city$cr$postcode - $statecomma$country','$state / $country');
INSERT INTO prf_address_format VALUES (4, '$firstname $lastname$cr$streets$cr$city ($postcode)$cr$country', '$postcode / $country');
INSERT INTO prf_address_format VALUES (5, '$firstname $lastname$cr$streets$cr$postcode $city$cr$country','$city / $country');

INSERT INTO prf_admin_access VALUES ('1',1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO prf_admin_access VALUES ('groups',1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,3,3,3,3,3,3,4,4,4,4,2,4,2,2,2,2,5,5,5,5,5,5,5,5,2,2,2,2,2,2,2,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

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
INSERT INTO prf_configuration VALUES (NULL, 'STORE_NAME_ADDRESS', 'Shop Name\nAddesse\nLand-Plz Ort\nTel\nFax', 100, 7, NULL, now(), NULL, 'olc_cfg_textarea(');
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
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_FROOGLE_STATUS', 'True', 6, 10, NULL, now(), NULL, 'olc_cfg_select_option(array(''True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_GEIZHALS_FILE', 'geizhals.csv', 6, 11, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_GEIZHALS_STATUS', 'True', 6, 12, NULL, now(), NULL, 'olc_cfg_select_option(array(''True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_IMAGE_PROCESS_STATUS', 'True', 6, 13, NULL, now(), NULL, 'olc_cfg_select_option(array(''True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_KELKOO_FILE', 'kelkoo.txt', 6, 14, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_KELKOO_STATUS', 'True', 6, 15, NULL, now(), NULL, 'olc_cfg_select_option(array(''True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_METASHOPPER_FILE', 'metashopper.csv', 6, 16, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_METASHOPPER_STATUS', 'True', 6, 17, NULL, now(), NULL, 'olc_cfg_select_option(array(''True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_MILANDO_FILE', 'milando.csv', 6, 18, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_MILANDO_STATUS', 'True', 6, 19, NULL, now(), NULL, 'olc_cfg_select_option(array(''True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_DISCOUNT_STATUS', 'true', 6, 20, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_SHIPPING_STATUS', 'true', 6, 21, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_STATUS', 'true', 6, 22, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_SUBTOTAL_STATUS', 'true', 6, 23, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_TAX_STATUS', 'true', 6, 24, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_ORDER_TOTAL_TOTAL_STATUS', 'true', 6, 25, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_PREISAUSKUNFT_FILE', 'preisauskunft.csv', 6, 26, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_PREISAUSKUNFT_STATUS', 'True', 6, 27, NULL, now(), NULL, 'olc_cfg_select_option(array(''True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_PREISSUCHMASCHINE_FILE', 'preissuchmaschine.csv', 6, 28, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_PREISSUCHMASCHINE_STATUS', 'True', 6, 29, NULL, now(), NULL, 'olc_cfg_select_option(array(''True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_PREISTREND_FILE', 'preistrend.txt', 6, 30, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_PREISTREND_STATUS', 'True', 6, 31, NULL, now(), NULL, 'olc_cfg_select_option(array(''True'', ''False''),');
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_VIVENDI_FILE', 'vivendi.csv', 6, 32, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'MODULE_VIVENDI_STATUS', 'True', 6, 33, NULL, now(), NULL, 'olc_cfg_select_option(array(''True'', ''False''),');
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

INSERT INTO prf_configuration VALUES (NULL, 'DOWN_FOR_MAINTENANCE', 'false', 18, 1, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'EXCLUDE_ADMIN_IP_FOR_MAINTENANCE', 'Ihre IP (ADMIN)', 18, 2, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'ADMIN_PASSWORD_FOR_MAINTENANCE', 'olcommerce', 18, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'WARN_BEFORE_DOWN_FOR_MAINTENANCE', 'false', 18, 4, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'PERIOD_DOWN_FOR_MAINTENANCE', '', 18, 5, NULL, now(), NULL, NULL);

#Affiliate Konfiguration
INSERT INTO prf_configuration_group VALUES (900, 'Affiliate Program', 'Optionen des "Affiliate" Programms', 1, 1);

INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_EMAIL_ADDRESS', 'affiliate@localhost.com', 900, 1, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_PERCENT', '10.0000', 900, 2, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_THRESHOLD', '50.00', 900, 3, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_COOKIE_LIFETIME', '7200', 900, 4, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_BILLING_TIME', '30', 900, 5, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_PAYMENT_ORDER_MIN_STATUS', '3', 900, 6, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_USE_CHECK', 'true', 900, 7, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_USE_PAYPAL', 'true', 900, 8, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'AFFILIATE_USE_BANK', 'true', 900, 9, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'AFFILATE_INDIVIDUAL_PERCENTAGE', 'true', 900, 10, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'AFFILATE_USE_TIER', 'false', 900, 11, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
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
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS', 'false', 19, 10, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS_HEIGHT', '230', 19, 20, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS_WIDTH', '400', 19, 30, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS_BORDER', 'false', 19, 40, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS_CONTROLS', 'true', 19, 41, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');

INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_IMAGES', 'false', 19, 50, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_IMAGES_HEIGHT', '230', 19, 60, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_IMAGES_WIDTH', '400', 19, 70, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_IMAGES_BORDER', 'false', 19, 80, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_IMAGES_CONTROLS', 'true', 19, 81, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO prf_configuration VALUES (NULL, 'SLIDESHOW_IMAGES_SHOW_TEXT', 'true', 19, 90, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');

INSERT INTO prf_configuration VALUES (NULL, 'CSV_TEXTSIGN', '"', '20', '10', NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'CSV_SEPERATOR', '\t', '20', '20', NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'COMPRESS_EXPORT', 'false', '20', '30', NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');

#PDF-Rechnung Konfiguration
INSERT INTO prf_configuration_group VALUES (787, 'PDF-Rechnung', 'Einstellungen für die PDF-Rechnung', '17', '1');

INSERT INTO prf_configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
(NULL, 'PDF_INVOICE_ORDER_CONFIRMATION', '1', 787, 0, NULL, now(), NULL, NULL),
(NULL, 'PDF_INVOICE_MARK_COLOR', 'Black', 787, 1, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'PDF_INVOICE_MARK_COLOR_BG', 'Lightgrey', 787, 2, NULL, now(), NULL, 'olc_cfg_display_color_sample('),
(NULL, 'STORE_INVOICE_NUMBER', '12345', 787, 3, NULL, now(), NULL, NULL),
(NULL, 'STORE_PACKINGSLIP_NUMBER', '23456', 787, 4, NULL, now(), NULL, NULL);

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

INSERT INTO prf_configuration VALUES (NULL, 'CURRENT_TEMPLATE', 'olc', 795, 10, NULL, now(), NULL, 'olc_cfg_pull_down_template_sets(');
INSERT INTO prf_configuration VALUES (NULL, 'NO_BOX_LAYOUT', 'false', 795, 20, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'USE_UNIFIED_TEMPLATES', 'true', 795, 30, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'CHECK_UNIFIED_BOXES', 'false', 795, 40, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'OPEN_ALL_MENUE_LEVELS', 'false', 795,  50,  NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'SHOW_TAB_NAVIGATION', 'false', 795, 60, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'USE_COOL_MENU', 'false', 795, 70, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'USE_CSS_MENU', 'true', 795, 75, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'PRODUCTS_LISTING_COLUMNS', '2', 795, 80, NULL, now(), NULL, 'olc_cfg_select_option(array(\'1\', \'2\'),');

#Screen-Layout Konfiguration
INSERT INTO prf_box_configuration (box_id, template, box_key_name, box_visible, box_sort_order, box_forced_visible, box_real_name, box_position_name, last_modified, date_added) VALUES
(NULL, 'olc', 'SHOW_ADMIN', 1, 1, 1, 'box_ADMIN', 'box_r_03', NULL, now()),
(NULL, 'olc', 'SHOW_CART', 1, 2, 1, 'box_CART', 'box_r_01', NULL, now()),
(NULL, 'olc', 'SHOW_CATEGORIES', 1, 3, 1, 'box_CATEGORIES', 'box_l_01', NULL, now()),
(NULL, 'olc', 'SHOW_CONTACT_US', 0, 4, 0, 'box_CONTACT_US', 'box_r_12', NULL, now()),
(NULL, 'olc', 'SHOW_CONTENT', 1, 5, 1, 'box_CONTENT', 'box_l_05', NULL, now()),
(NULL, 'olc', 'SHOW_INFOBOX', 1, 6, 1, 'box_INFOBOX', 'box_r_05', NULL, now()),
(NULL, 'olc', 'SHOW_LOGIN', 1, 7, 1, 'box_LOGIN', 'box_r_02', NULL, now()),
(NULL, 'olc', 'SHOW_MANUFACTURERS_INFO', 0, 8, 1, 'box_MANUFACTURERS_INFO', 'box_l_03', NULL, now()),
(NULL, 'olc', 'SHOW_MANUFACTURERS', 0, 9, 1, 'box_MANUFACTURERS', 'box_l_02', NULL, now()),
(NULL, 'olc', 'SHOW_SEARCH', 1, 10, 1, 'box_SEARCH', 'box_l_08', NULL, now()),
(NULL, 'olc', 'SHOW_CHANGE_SKIN', 1, 11, 0, NULL, NULL, NULL, now()),
(NULL, 'olc', 'SHOW_ADD_A_QUICKIE', 1, 12, 0, 'box_ADD_A_QUICKIE', 'box_l_04', NULL, now()),
(NULL, 'olc', 'SHOW_AFFILIATE', 1, 13, 0, 'box_AFFILIATE', 'box_l_13', NULL, now()),
(NULL, 'olc', 'SHOW_BESTSELLERS', 1, 14, 0, 'box_BESTSELLERS', 'box_r_06', NULL, now()),
(NULL, 'olc', 'SHOW_CENTER', 1, 15, 0, NULL, NULL, NULL, now()),
(NULL, 'olc', 'SHOW_CURRENCIES', 0, 16, 0, 'box_CURRENCIES', 'box_r_07', NULL, now()),
(NULL, 'olc', 'SHOW_ORDER_HISTORY', 1, 17, 0, 'box_ORDER_HISTORY', 'box_l_12', NULL, now()),
(NULL, 'olc', 'SHOW_INFORMATION', 1, 18, 0, 'box_INFORMATION', 'box_l_06', NULL, now()),
(NULL, 'olc', 'SHOW_LANGUAGES', 0, 19, 0, 'box_LANGUAGES', 'box_r_08', NULL, now()),
(NULL, 'olc', 'SHOW_LIVEHELP', 0, 20, 0, 'box_LIVEHELP', 'box_r_04', NULL, now()),
(NULL, 'olc', 'SHOW_NEWSLETTER', 1, 21, 0, 'box_NEWSLETTER', 'box_r_10', NULL, now()),
(NULL, 'olc', 'SHOW_LAST_VIEWED', 1, 22, 0, 'box_LAST_VIEWED', 'box_r_11', NULL, now()),
(NULL, 'olc', 'SHOW_NOTIFICATIONS', 1, 23, 0, 'box_NOTIFICATIONS', 'box_r_09', NULL, now()),
(NULL, 'olc', 'SHOW_REVIEWS', 1, 24, 0, 'box_REVIEWS', 'box_l_07', NULL, now()),
(NULL, 'olc', 'SHOW_SPECIALS', 1, 25, 0, 'box_SPECIALS', 'box_l_09', NULL, now()),
(NULL, 'olc', 'SHOW_TELL_FRIEND', 1, 26, 0, 'box_TELL_FRIEND', 'box_l_11', NULL, now()),
(NULL, 'olc', 'SHOW_WHATSNEW', 1, 27, 0, 'box_WHATSNEW', 'box_l_10', NULL, now()),
(NULL, 'olc', 'SHOW_TAB_NAVIGATION', 0, 28, 0, 'box_TAB_NAVIGATION', 'box_m_01', NULL, now()),
(NULL, 'olc', 'SHOW_PDF_CATALOG', 1, 29, 0, NULL, NULL, NULL, now()),
(NULL, 'olc', 'SHOW_GALLERY', 1, 30, 0, NULL, NULL, NULL, now());

INSERT INTO prf_countries VALUES (1,'Afghanistan','AF','AFG','1');
INSERT INTO prf_countries VALUES (2,'Albania','AL','ALB','1');
INSERT INTO prf_countries VALUES (3,'Algeria','DZ','DZA','1');
INSERT INTO prf_countries VALUES (4,'American Samoa','AS','ASM','1');
INSERT INTO prf_countries VALUES (5,'Andorra','AD','AND','1');
INSERT INTO prf_countries VALUES (6,'Angola','AO','AGO','1');
INSERT INTO prf_countries VALUES (7,'Anguilla','AI','AIA','1');
INSERT INTO prf_countries VALUES (8,'Antarctica','AQ','ATA','1');
INSERT INTO prf_countries VALUES (9,'Antigua and Barbuda','AG','ATG','1');
INSERT INTO prf_countries VALUES (10,'Argentina','AR','ARG','1');
INSERT INTO prf_countries VALUES (11,'Armenia','AM','ARM','1');
INSERT INTO prf_countries VALUES (12,'Aruba','AW','ABW','1');
INSERT INTO prf_countries VALUES (13,'Australia','AU','AUS','1');
INSERT INTO prf_countries VALUES (14,'Österreich','AT','AUT','5');
INSERT INTO prf_countries VALUES (15,'Azerbaijan','AZ','AZE','1');
INSERT INTO prf_countries VALUES (16,'Bahamas','BS','BHS','1');
INSERT INTO prf_countries VALUES (17,'Bahrain','BH','BHR','1');
INSERT INTO prf_countries VALUES (18,'Bangladesh','BD','BGD','1');
INSERT INTO prf_countries VALUES (19,'Barbados','BB','BRB','1');
INSERT INTO prf_countries VALUES (20,'Belarus','BY','BLR','1');
INSERT INTO prf_countries VALUES (21,'Belgien','BE','BEL','1');
INSERT INTO prf_countries VALUES (22,'Belize','BZ','BLZ','1');
INSERT INTO prf_countries VALUES (23,'Benin','BJ','BEN','1');
INSERT INTO prf_countries VALUES (24,'Bermuda','BM','BMU','1');
INSERT INTO prf_countries VALUES (25,'Bhutan','BT','BTN','1');
INSERT INTO prf_countries VALUES (26,'Bolivia','BO','BOL','1');
INSERT INTO prf_countries VALUES (27,'Bosnia and Herzegowina','BA','BIH','1');
INSERT INTO prf_countries VALUES (28,'Botswana','BW','BWA','1');
INSERT INTO prf_countries VALUES (29,'Bouvet Island','BV','BVT','1');
INSERT INTO prf_countries VALUES (30,'Brazil','BR','BRA','1');
INSERT INTO prf_countries VALUES (31,'British Indian Ocean Territory','IO','IOT','1');
INSERT INTO prf_countries VALUES (32,'Brunei Darussalam','BN','BRN','1');
INSERT INTO prf_countries VALUES (33,'Bulgaria','BG','BGR','1');
INSERT INTO prf_countries VALUES (34,'Burkina Faso','BF','BFA','1');
INSERT INTO prf_countries VALUES (35,'Burundi','BI','BDI','1');
INSERT INTO prf_countries VALUES (36,'Cambodia','KH','KHM','1');
INSERT INTO prf_countries VALUES (37,'Cameroon','CM','CMR','1');
INSERT INTO prf_countries VALUES (38,'Canada','CA','CAN','1');
INSERT INTO prf_countries VALUES (39,'Cape Verde','CV','CPV','1');
INSERT INTO prf_countries VALUES (40,'Cayman Islands','KY','CYM','1');
INSERT INTO prf_countries VALUES (41,'Central African Republic','CF','CAF','1');
INSERT INTO prf_countries VALUES (42,'Chad','TD','TCD','1');
INSERT INTO prf_countries VALUES (43,'Chile','CL','CHL','1');
INSERT INTO prf_countries VALUES (44,'China','CN','CHN','1');
INSERT INTO prf_countries VALUES (45,'Christmas Island','CX','CXR','1');
INSERT INTO prf_countries VALUES (46,'Cocos (Keeling) Islands','CC','CCK','1');
INSERT INTO prf_countries VALUES (47,'Colombia','CO','COL','1');
INSERT INTO prf_countries VALUES (48,'Comoros','KM','COM','1');
INSERT INTO prf_countries VALUES (49,'Congo','CG','COG','1');
INSERT INTO prf_countries VALUES (50,'Cook Islands','CK','COK','1');
INSERT INTO prf_countries VALUES (51,'Costa Rica','CR','CRI','1');
INSERT INTO prf_countries VALUES (52,'Cote D\'Ivoire','CI','CIV','1');
INSERT INTO prf_countries VALUES (53,'Croatia','HR','HRV','1');
INSERT INTO prf_countries VALUES (54,'Cuba','CU','CUB','1');
INSERT INTO prf_countries VALUES (55,'Cyprus','CY','CYP','1');
INSERT INTO prf_countries VALUES (56,'Czech Republic','CZ','CZE','1');
INSERT INTO prf_countries VALUES (57,'Denmark','DK','DNK','1');
INSERT INTO prf_countries VALUES (58,'Djibouti','DJ','DJI','1');
INSERT INTO prf_countries VALUES (59,'Dominica','DM','DMA','1');
INSERT INTO prf_countries VALUES (60,'Dominican Republic','DO','DOM','1');
INSERT INTO prf_countries VALUES (61,'East Timor','TP','TMP','1');
INSERT INTO prf_countries VALUES (62,'Ecuador','EC','ECU','1');
INSERT INTO prf_countries VALUES (63,'Egypt','EG','EGY','1');
INSERT INTO prf_countries VALUES (64,'El Salvador','SV','SLV','1');
INSERT INTO prf_countries VALUES (65,'Equatorial Guinea','GQ','GNQ','1');
INSERT INTO prf_countries VALUES (66,'Eritrea','ER','ERI','1');
INSERT INTO prf_countries VALUES (67,'Estonia','EE','EST','1');
INSERT INTO prf_countries VALUES (68,'Ethiopia','ET','ETH','1');
INSERT INTO prf_countries VALUES (69,'Falkland Islands (Malvinas)','FK','FLK','1');
INSERT INTO prf_countries VALUES (70,'Faroe Islands','FO','FRO','1');
INSERT INTO prf_countries VALUES (71,'Fiji','FJ','FJI','1');
INSERT INTO prf_countries VALUES (72,'Finland','FI','FIN','1');
INSERT INTO prf_countries VALUES (73,'France','FR','FRA','1');
INSERT INTO prf_countries VALUES (74,'France, Metropolitan','FX','FXX','1');
INSERT INTO prf_countries VALUES (75,'French Guiana','GF','GUF','1');
INSERT INTO prf_countries VALUES (76,'French Polynesia','PF','PYF','1');
INSERT INTO prf_countries VALUES (77,'French Southern Territories','TF','ATF','1');
INSERT INTO prf_countries VALUES (78,'Gabon','GA','GAB','1');
INSERT INTO prf_countries VALUES (79,'Gambia','GM','GMB','1');
INSERT INTO prf_countries VALUES (80,'Georgia','GE','GEO','1');
INSERT INTO prf_countries VALUES (81,'Deutschland','DE','DEU','5');
INSERT INTO prf_countries VALUES (82,'Ghana','GH','GHA','1');
INSERT INTO prf_countries VALUES (83,'Gibraltar','GI','GIB','1');
INSERT INTO prf_countries VALUES (84,'Greece','GR','GRC','1');
INSERT INTO prf_countries VALUES (85,'Greenland','GL','GRL','1');
INSERT INTO prf_countries VALUES (86,'Grenada','GD','GRD','1');
INSERT INTO prf_countries VALUES (87,'Guadeloupe','GP','GLP','1');
INSERT INTO prf_countries VALUES (88,'Guam','GU','GUM','1');
INSERT INTO prf_countries VALUES (89,'Guatemala','GT','GTM','1');
INSERT INTO prf_countries VALUES (90,'Guinea','GN','GIN','1');
INSERT INTO prf_countries VALUES (91,'Guinea-bissau','GW','GNB','1');
INSERT INTO prf_countries VALUES (92,'Guyana','GY','GUY','1');
INSERT INTO prf_countries VALUES (93,'Haiti','HT','HTI','1');
INSERT INTO prf_countries VALUES (94,'Heard and Mc Donald Islands','HM','HMD','1');
INSERT INTO prf_countries VALUES (95,'Honduras','HN','HND','1');
INSERT INTO prf_countries VALUES (96,'Hong Kong','HK','HKG','1');
INSERT INTO prf_countries VALUES (97,'Hungary','HU','HUN','1');
INSERT INTO prf_countries VALUES (98,'Iceland','IS','ISL','1');
INSERT INTO prf_countries VALUES (99,'India','IN','IND','1');
INSERT INTO prf_countries VALUES (100,'Indonesia','ID','IDN','1');
INSERT INTO prf_countries VALUES (101,'Iran (Islamic Republic of)','IR','IRN','1');
INSERT INTO prf_countries VALUES (102,'Iraq','IQ','IRQ','1');
INSERT INTO prf_countries VALUES (103,'Ireland','IE','IRL','1');
INSERT INTO prf_countries VALUES (104,'Israel','IL','ISR','1');
INSERT INTO prf_countries VALUES (105,'Italy','IT','ITA','1');
INSERT INTO prf_countries VALUES (106,'Jamaica','JM','JAM','1');
INSERT INTO prf_countries VALUES (107,'Japan','JP','JPN','1');
INSERT INTO prf_countries VALUES (108,'Jordan','JO','JOR','1');
INSERT INTO prf_countries VALUES (109,'Kazakhstan','KZ','KAZ','1');
INSERT INTO prf_countries VALUES (110,'Kenya','KE','KEN','1');
INSERT INTO prf_countries VALUES (111,'Kiribati','KI','KIR','1');
INSERT INTO prf_countries VALUES (112,'Korea, Democratic People\'s Republic of','KP','PRK','1');
INSERT INTO prf_countries VALUES (113,'Korea, Republic of','KR','KOR','1');
INSERT INTO prf_countries VALUES (114,'Kuwait','KW','KWT','1');
INSERT INTO prf_countries VALUES (115,'Kyrgyzstan','KG','KGZ','1');
INSERT INTO prf_countries VALUES (116,'Lao People\'s Democratic Republic','LA','LAO','1');
INSERT INTO prf_countries VALUES (117,'Latvia','LV','LVA','1');
INSERT INTO prf_countries VALUES (118,'Lebanon','LB','LBN','1');
INSERT INTO prf_countries VALUES (119,'Lesotho','LS','LSO','1');
INSERT INTO prf_countries VALUES (120,'Liberia','LR','LBR','1');
INSERT INTO prf_countries VALUES (121,'Libyan Arab Jamahiriya','LY','LBY','1');
INSERT INTO prf_countries VALUES (122,'Liechtenstein','LI','LIE','1');
INSERT INTO prf_countries VALUES (123,'Lithuania','LT','LTU','1');
INSERT INTO prf_countries VALUES (124,'Luxembourg','LU','LUX','1');
INSERT INTO prf_countries VALUES (125,'Macau','MO','MAC','1');
INSERT INTO prf_countries VALUES (126,'Macedonia, The Former Yugoslav Republic of','MK','MKD','1');
INSERT INTO prf_countries VALUES (127,'Madagascar','MG','MDG','1');
INSERT INTO prf_countries VALUES (128,'Malawi','MW','MWI','1');
INSERT INTO prf_countries VALUES (129,'Malaysia','MY','MYS','1');
INSERT INTO prf_countries VALUES (130,'Maldives','MV','MDV','1');
INSERT INTO prf_countries VALUES (131,'Mali','ML','MLI','1');
INSERT INTO prf_countries VALUES (132,'Malta','MT','MLT','1');
INSERT INTO prf_countries VALUES (133,'Marshall Islands','MH','MHL','1');
INSERT INTO prf_countries VALUES (134,'Martinique','MQ','MTQ','1');
INSERT INTO prf_countries VALUES (135,'Mauritania','MR','MRT','1');
INSERT INTO prf_countries VALUES (136,'Mauritius','MU','MUS','1');
INSERT INTO prf_countries VALUES (137,'Mayotte','YT','MYT','1');
INSERT INTO prf_countries VALUES (138,'Mexico','MX','MEX','1');
INSERT INTO prf_countries VALUES (139,'Micronesia, Federated States of','FM','FSM','1');
INSERT INTO prf_countries VALUES (140,'Moldova, Republic of','MD','MDA','1');
INSERT INTO prf_countries VALUES (141,'Monaco','MC','MCO','1');
INSERT INTO prf_countries VALUES (142,'Mongolia','MN','MNG','1');
INSERT INTO prf_countries VALUES (143,'Montserrat','MS','MSR','1');
INSERT INTO prf_countries VALUES (144,'Morocco','MA','MAR','1');
INSERT INTO prf_countries VALUES (145,'Mozambique','MZ','MOZ','1');
INSERT INTO prf_countries VALUES (146,'Myanmar','MM','MMR','1');
INSERT INTO prf_countries VALUES (147,'Namibia','NA','NAM','1');
INSERT INTO prf_countries VALUES (148,'Nauru','NR','NRU','1');
INSERT INTO prf_countries VALUES (149,'Nepal','NP','NPL','1');
INSERT INTO prf_countries VALUES (150,'Netherlands','NL','NLD','1');
INSERT INTO prf_countries VALUES (151,'Netherlands Antilles','AN','ANT','1');
INSERT INTO prf_countries VALUES (152,'New Caledonia','NC','NCL','1');
INSERT INTO prf_countries VALUES (153,'New Zealand','NZ','NZL','1');
INSERT INTO prf_countries VALUES (154,'Nicaragua','NI','NIC','1');
INSERT INTO prf_countries VALUES (155,'Niger','NE','NER','1');
INSERT INTO prf_countries VALUES (156,'Nigeria','NG','NGA','1');
INSERT INTO prf_countries VALUES (157,'Niue','NU','NIU','1');
INSERT INTO prf_countries VALUES (158,'Norfolk Island','NF','NFK','1');
INSERT INTO prf_countries VALUES (159,'Northern Mariana Islands','MP','MNP','1');
INSERT INTO prf_countries VALUES (160,'Norway','NO','NOR','1');
INSERT INTO prf_countries VALUES (161,'Oman','OM','OMN','1');
INSERT INTO prf_countries VALUES (162,'Pakistan','PK','PAK','1');
INSERT INTO prf_countries VALUES (163,'Palau','PW','PLW','1');
INSERT INTO prf_countries VALUES (164,'Panama','PA','PAN','1');
INSERT INTO prf_countries VALUES (165,'Papua New Guinea','PG','PNG','1');
INSERT INTO prf_countries VALUES (166,'Paraguay','PY','PRY','1');
INSERT INTO prf_countries VALUES (167,'Peru','PE','PER','1');
INSERT INTO prf_countries VALUES (168,'Philippines','PH','PHL','1');
INSERT INTO prf_countries VALUES (169,'Pitcairn','PN','PCN','1');
INSERT INTO prf_countries VALUES (170,'Poland','PL','POL','1');
INSERT INTO prf_countries VALUES (171,'Portugal','PT','PRT','1');
INSERT INTO prf_countries VALUES (172,'Puerto Rico','PR','PRI','1');
INSERT INTO prf_countries VALUES (173,'Qatar','QA','QAT','1');
INSERT INTO prf_countries VALUES (174,'Reunion','RE','REU','1');
INSERT INTO prf_countries VALUES (175,'Romania','RO','ROM','1');
INSERT INTO prf_countries VALUES (176,'Russian Federation','RU','RUS','1');
INSERT INTO prf_countries VALUES (177,'Rwanda','RW','RWA','1');
INSERT INTO prf_countries VALUES (178,'Saint Kitts and Nevis','KN','KNA','1');
INSERT INTO prf_countries VALUES (179,'Saint Lucia','LC','LCA','1');
INSERT INTO prf_countries VALUES (180,'Saint Vincent and the Grenadines','VC','VCT','1');
INSERT INTO prf_countries VALUES (181,'Samoa','WS','WSM','1');
INSERT INTO prf_countries VALUES (182,'San Marino','SM','SMR','1');
INSERT INTO prf_countries VALUES (183,'Sao Tome and Principe','ST','STP','1');
INSERT INTO prf_countries VALUES (184,'Saudi Arabia','SA','SAU','1');
INSERT INTO prf_countries VALUES (185,'Senegal','SN','SEN','1');
INSERT INTO prf_countries VALUES (186,'Seychelles','SC','SYC','1');
INSERT INTO prf_countries VALUES (187,'Sierra Leone','SL','SLE','1');
INSERT INTO prf_countries VALUES (188,'Singapore','SG','SGP', '4');
INSERT INTO prf_countries VALUES (189,'Slovakia (Slovak Republic)','SK','SVK','1');
INSERT INTO prf_countries VALUES (190,'Slovenia','SI','SVN','1');
INSERT INTO prf_countries VALUES (191,'Solomon Islands','SB','SLB','1');
INSERT INTO prf_countries VALUES (192,'Somalia','SO','SOM','1');
INSERT INTO prf_countries VALUES (193,'South Africa','ZA','ZAF','1');
INSERT INTO prf_countries VALUES (194,'South Georgia and the South Sandwich Islands','GS','SGS','1');
INSERT INTO prf_countries VALUES (195,'Spain','ES','ESP','3');
INSERT INTO prf_countries VALUES (196,'Sri Lanka','LK','LKA','1');
INSERT INTO prf_countries VALUES (197,'St. Helena','SH','SHN','1');
INSERT INTO prf_countries VALUES (198,'St. Pierre and Miquelon','PM','SPM','1');
INSERT INTO prf_countries VALUES (199,'Sudan','SD','SDN','1');
INSERT INTO prf_countries VALUES (200,'Suriname','SR','SUR','1');
INSERT INTO prf_countries VALUES (201,'Svalbard and Jan Mayen Islands','SJ','SJM','1');
INSERT INTO prf_countries VALUES (202,'Swaziland','SZ','SWZ','1');
INSERT INTO prf_countries VALUES (203,'Sweden','SE','SWE','1');
INSERT INTO prf_countries VALUES (204,'Schweiz','CH','CHE','1');
INSERT INTO prf_countries VALUES (205,'Syrian Arab Republic','SY','SYR','1');
INSERT INTO prf_countries VALUES (206,'Taiwan','TW','TWN','1');
INSERT INTO prf_countries VALUES (207,'Tajikistan','TJ','TJK','1');
INSERT INTO prf_countries VALUES (208,'Tanzania, United Republic of','TZ','TZA','1');
INSERT INTO prf_countries VALUES (209,'Thailand','TH','THA','1');
INSERT INTO prf_countries VALUES (210,'Togo','TG','TGO','1');
INSERT INTO prf_countries VALUES (211,'Tokelau','TK','TKL','1');
INSERT INTO prf_countries VALUES (212,'Tonga','TO','TON','1');
INSERT INTO prf_countries VALUES (213,'Trinidad and Tobago','TT','TTO','1');
INSERT INTO prf_countries VALUES (214,'Tunisia','TN','TUN','1');
INSERT INTO prf_countries VALUES (215,'Turkey','TR','TUR','1');
INSERT INTO prf_countries VALUES (216,'Turkmenistan','TM','TKM','1');
INSERT INTO prf_countries VALUES (217,'Turks and Caicos Islands','TC','TCA','1');
INSERT INTO prf_countries VALUES (218,'Tuvalu','TV','TUV','1');
INSERT INTO prf_countries VALUES (219,'Uganda','UG','UGA','1');
INSERT INTO prf_countries VALUES (220,'Ukraine','UA','UKR','1');
INSERT INTO prf_countries VALUES (221,'United Arab Emirates','AE','ARE','1');
INSERT INTO prf_countries VALUES (222,'United Kingdom','GB','GBR','1');
INSERT INTO prf_countries VALUES (223,'United States','US','USA', '2');
INSERT INTO prf_countries VALUES (224,'United States Minor Outlying Islands','UM','UMI','1');
INSERT INTO prf_countries VALUES (225,'Uruguay','UY','URY','1');
INSERT INTO prf_countries VALUES (226,'Uzbekistan','UZ','UZB','1');
INSERT INTO prf_countries VALUES (227,'Vanuatu','VU','VUT','1');
INSERT INTO prf_countries VALUES (228,'Vatican City State (Holy See)','VA','VAT','1');
INSERT INTO prf_countries VALUES (229,'Venezuela','VE','VEN','1');
INSERT INTO prf_countries VALUES (230,'Viet Nam','VN','VNM','1');
INSERT INTO prf_countries VALUES (231,'Virgin Islands (British)','VG','VGB','1');
INSERT INTO prf_countries VALUES (232,'Virgin Islands (U.S.)','VI','VIR','1');
INSERT INTO prf_countries VALUES (233,'Wallis and Futuna Islands','WF','WLF','1');
INSERT INTO prf_countries VALUES (234,'Western Sahara','EH','ESH','1');
INSERT INTO prf_countries VALUES (235,'Yemen','YE','YEM','1');
INSERT INTO prf_countries VALUES (236,'Yugoslavia','YU','YUG','1');
INSERT INTO prf_countries VALUES (237,'Zaire','ZR','ZAR','1');
INSERT INTO prf_countries VALUES (238,'Zambia','ZM','ZMB','1');
INSERT INTO prf_countries VALUES (239,'Zimbabwe','ZW','ZWE','1');

INSERT INTO prf_currencies VALUES (1,'Euro','EUR','','EUR',',','.','2','1.0000', now());

#INSERT INTO prf_languages VALUES (1,'English','en','icon.gif','english',1,'iso-8859-15');
#INSERT INTO prf_languages VALUES (2,'Deutsch','de','icon.gif','german',2,'iso-8859-15');

INSERT INTO prf_orders_status VALUES ( '1', '1', 'Pending');
INSERT INTO prf_orders_status VALUES ( '1', '2', 'Offen');
INSERT INTO prf_orders_status VALUES ( '2', '1', 'Processing');
INSERT INTO prf_orders_status VALUES ( '2', '2', 'In Bearbeitung');
INSERT INTO prf_orders_status VALUES ( '3', '1', 'Delivered');
INSERT INTO prf_orders_status VALUES ( '3', '2', 'Versendet');
INSERT INTO prf_orders_status VALUES ( '4', '1', 'On Hold');
INSERT INTO prf_orders_status VALUES ( '4', '2', 'Blockiert');
INSERT INTO prf_orders_status VALUES ( '5', '1', 'Refunded');
INSERT INTO prf_orders_status VALUES ( '5', '2', 'Erstattet');
INSERT INTO prf_orders_status VALUES ( '6', '1', 'Canceled');
INSERT INTO prf_orders_status VALUES ( '6', '2', 'Ungültig');
INSERT INTO prf_orders_status VALUES ( '7', '1', 'Completed');
INSERT INTO prf_orders_status VALUES ( '7', '2', 'Abgeschlossen');
INSERT INTO prf_orders_status VALUES ( '8', '1', 'Failed');
INSERT INTO prf_orders_status VALUES ( '8', '2', 'Fehlgeschlagen');
INSERT INTO prf_orders_status VALUES ( '9', '1', 'Denied');
INSERT INTO prf_orders_status VALUES ( '9', '2', 'Abgelehnt');
INSERT INTO prf_orders_status VALUES ( '10', '1', 'Reversed');
INSERT INTO prf_orders_status VALUES ( '10', '2', 'Zurückerstattet');
INSERT INTO prf_orders_status VALUES ( '11', '1', 'Canceled Reversal');
INSERT INTO prf_orders_status VALUES ( '11', '2', 'Zurückerstattung aufgehoben');

# USA
INSERT INTO prf_zones VALUES (1,223,'AL','Alabama');
INSERT INTO prf_zones VALUES (2,223,'AK','Alaska');
INSERT INTO prf_zones VALUES (3,223,'AS','American Samoa');
INSERT INTO prf_zones VALUES (4,223,'AZ','Arizona');
INSERT INTO prf_zones VALUES (5,223,'AR','Arkansas');
INSERT INTO prf_zones VALUES (6,223,'AF','Armed Forces Africa');
INSERT INTO prf_zones VALUES (7,223,'AA','Armed Forces Americas');
INSERT INTO prf_zones VALUES (8,223,'AC','Armed Forces Canada');
INSERT INTO prf_zones VALUES (9,223,'AE','Armed Forces Europe');
INSERT INTO prf_zones VALUES (10,223,'AM','Armed Forces Middle East');
INSERT INTO prf_zones VALUES (11,223,'AP','Armed Forces Pacific');
INSERT INTO prf_zones VALUES (12,223,'CA','California');
INSERT INTO prf_zones VALUES (13,223,'CO','Colorado');
INSERT INTO prf_zones VALUES (14,223,'CT','Connecticut');
INSERT INTO prf_zones VALUES (15,223,'DE','Delaware');
INSERT INTO prf_zones VALUES (16,223,'DC','District of Columbia');
INSERT INTO prf_zones VALUES (17,223,'FM','Federated States Of Micronesia');
INSERT INTO prf_zones VALUES (18,223,'FL','Florida');
INSERT INTO prf_zones VALUES (19,223,'GA','Georgia');
INSERT INTO prf_zones VALUES (20,223,'GU','Guam');
INSERT INTO prf_zones VALUES (21,223,'HI','Hawaii');
INSERT INTO prf_zones VALUES (22,223,'ID','Idaho');
INSERT INTO prf_zones VALUES (23,223,'IL','Illinois');
INSERT INTO prf_zones VALUES (24,223,'IN','Indiana');
INSERT INTO prf_zones VALUES (25,223,'IA','Iowa');
INSERT INTO prf_zones VALUES (26,223,'KS','Kansas');
INSERT INTO prf_zones VALUES (27,223,'KY','Kentucky');
INSERT INTO prf_zones VALUES (28,223,'LA','Louisiana');
INSERT INTO prf_zones VALUES (29,223,'ME','Maine');
INSERT INTO prf_zones VALUES (30,223,'MH','Marshall Islands');
INSERT INTO prf_zones VALUES (31,223,'MD','Maryland');
INSERT INTO prf_zones VALUES (32,223,'MA','Massachusetts');
INSERT INTO prf_zones VALUES (33,223,'MI','Michigan');
INSERT INTO prf_zones VALUES (34,223,'MN','Minnesota');
INSERT INTO prf_zones VALUES (35,223,'MS','Mississippi');
INSERT INTO prf_zones VALUES (36,223,'MO','Missouri');
INSERT INTO prf_zones VALUES (37,223,'MT','Montana');
INSERT INTO prf_zones VALUES (38,223,'NE','Nebraska');
INSERT INTO prf_zones VALUES (39,223,'NV','Nevada');
INSERT INTO prf_zones VALUES (40,223,'NH','New Hampshire');
INSERT INTO prf_zones VALUES (41,223,'NJ','New Jersey');
INSERT INTO prf_zones VALUES (42,223,'NM','New Mexico');
INSERT INTO prf_zones VALUES (43,223,'NY','New York');
INSERT INTO prf_zones VALUES (44,223,'NC','North Carolina');
INSERT INTO prf_zones VALUES (45,223,'ND','North Dakota');
INSERT INTO prf_zones VALUES (46,223,'MP','Northern Mariana Islands');
INSERT INTO prf_zones VALUES (47,223,'OH','Ohio');
INSERT INTO prf_zones VALUES (48,223,'OK','Oklahoma');
INSERT INTO prf_zones VALUES (49,223,'OR','Oregon');
INSERT INTO prf_zones VALUES (50,223,'PW','Palau');
INSERT INTO prf_zones VALUES (51,223,'PA','Pennsylvania');
INSERT INTO prf_zones VALUES (52,223,'PR','Puerto Rico');
INSERT INTO prf_zones VALUES (53,223,'RI','Rhode Island');
INSERT INTO prf_zones VALUES (54,223,'SC','South Carolina');
INSERT INTO prf_zones VALUES (55,223,'SD','South Dakota');
INSERT INTO prf_zones VALUES (56,223,'TN','Tennessee');
INSERT INTO prf_zones VALUES (57,223,'TX','Texas');
INSERT INTO prf_zones VALUES (58,223,'UT','Utah');
INSERT INTO prf_zones VALUES (59,223,'VT','Vermont');
INSERT INTO prf_zones VALUES (60,223,'VI','Virgin Islands');
INSERT INTO prf_zones VALUES (61,223,'VA','Virginia');
INSERT INTO prf_zones VALUES (62,223,'WA','Washington');
INSERT INTO prf_zones VALUES (63,223,'WV','West Virginia');
INSERT INTO prf_zones VALUES (64,223,'WI','Wisconsin');
INSERT INTO prf_zones VALUES (65,223,'WY','Wyoming');

# Canada
INSERT INTO prf_zones VALUES (66,38,'AB','Alberta');
INSERT INTO prf_zones VALUES (67,38,'BC','British Columbia');
INSERT INTO prf_zones VALUES (68,38,'MB','Manitoba');
INSERT INTO prf_zones VALUES (69,38,'NF','Newfoundland');
INSERT INTO prf_zones VALUES (70,38,'NB','New Brunswick');
INSERT INTO prf_zones VALUES (71,38,'NS','Nova Scotia');
INSERT INTO prf_zones VALUES (72,38,'NT','Northwest Territories');
INSERT INTO prf_zones VALUES (73,38,'NU','Nunavut');
INSERT INTO prf_zones VALUES (74,38,'ON','Ontario');
INSERT INTO prf_zones VALUES (75,38,'PE','Prince Edward Island');
INSERT INTO prf_zones VALUES (76,38,'QC','Quebec');
INSERT INTO prf_zones VALUES (77,38,'SK','Saskatchewan');
INSERT INTO prf_zones VALUES (78,38,'YT','Yukon Territory');

# Germany
INSERT INTO prf_zones VALUES (79,81,'NDS','Niedersachsen');
INSERT INTO prf_zones VALUES (80,81,'BAW','Baden-Württemberg');
INSERT INTO prf_zones VALUES (81,81,'BAY','Bayern');
INSERT INTO prf_zones VALUES (82,81,'BER','Berlin');
INSERT INTO prf_zones VALUES (83,81,'BRG','Brandenburg');
INSERT INTO prf_zones VALUES (84,81,'BRE','Bremen');
INSERT INTO prf_zones VALUES (85,81,'HAM','Hamburg');
INSERT INTO prf_zones VALUES (86,81,'HES','Hessen');
INSERT INTO prf_zones VALUES (87,81,'MEC','Mecklenburg-Vorpommern');
INSERT INTO prf_zones VALUES (88,81,'NRW','Nordrhein-Westfalen');
INSERT INTO prf_zones VALUES (89,81,'RHE','Rheinland-Pfalz');
INSERT INTO prf_zones VALUES (90,81,'SAR','Saarland');
INSERT INTO prf_zones VALUES (91,81,'SAS','Sachsen');
INSERT INTO prf_zones VALUES (92,81,'SAC','Sachsen-Anhalt');
INSERT INTO prf_zones VALUES (93,81,'SCN','Schleswig-Holstein');
INSERT INTO prf_zones VALUES (94,81,'THE','Thüringen');

# Austria
INSERT INTO prf_zones VALUES (95,14,'WI','Wien');
INSERT INTO prf_zones VALUES (96,14,'NO','Niederösterreich');
INSERT INTO prf_zones VALUES (97,14,'OO','Oberösterreich');
INSERT INTO prf_zones VALUES (98,14,'SB','Salzburg');
INSERT INTO prf_zones VALUES (99,14,'KN','Kärnten');
INSERT INTO prf_zones VALUES (100,14,'ST','Steiermark');
INSERT INTO prf_zones VALUES (101,14,'TI','Tirol');
INSERT INTO prf_zones VALUES (102,14,'BL','Burgenland');
INSERT INTO prf_zones VALUES (103,14,'VB','Voralberg');

# Swizterland
INSERT INTO prf_zones VALUES (104,204,'AG','Aargau');
INSERT INTO prf_zones VALUES (105,204,'AI','Appenzell Innerrhoden');
INSERT INTO prf_zones VALUES (106,204,'AR','Appenzell Ausserrhoden');
INSERT INTO prf_zones VALUES (107,204,'BE','Bern');
INSERT INTO prf_zones VALUES (108,204,'BL','Basel-Landschaft');
INSERT INTO prf_zones VALUES (109,204,'BS','Basel-Stadt');
INSERT INTO prf_zones VALUES (110,204,'FR','Freiburg');
INSERT INTO prf_zones VALUES (111,204,'GE','Genf');
INSERT INTO prf_zones VALUES (112,204,'GL','Glarus');
INSERT INTO prf_zones VALUES (113,204,'GR','Graubünden');
INSERT INTO prf_zones VALUES (114,204,'JU','Jura');
INSERT INTO prf_zones VALUES (115,204,'LU','Luzern');
INSERT INTO prf_zones VALUES (116,204,'NE','Neuenburg');
INSERT INTO prf_zones VALUES (117,204,'NW','Nidwalden');
INSERT INTO prf_zones VALUES (118,204,'OW','Obwalden');
INSERT INTO prf_zones VALUES (119,204,'SG','St. Gallen');
INSERT INTO prf_zones VALUES (120,204,'SH','Schaffhausen');
INSERT INTO prf_zones VALUES (121,204,'SO','Solothurn');
INSERT INTO prf_zones VALUES (122,204,'SZ','Schwyz');
INSERT INTO prf_zones VALUES (123,204,'TG','Thurgau');
INSERT INTO prf_zones VALUES (124,204,'TI','Tessin');
INSERT INTO prf_zones VALUES (125,204,'UR','Uri');
INSERT INTO prf_zones VALUES (126,204,'VD','Waadt');
INSERT INTO prf_zones VALUES (127,204,'VS','Wallis');
INSERT INTO prf_zones VALUES (128,204,'ZG','Zug');
INSERT INTO prf_zones VALUES (129,204,'ZH','Zürich');
INSERT INTO prf_zones VALUES (130,204,'DE','Deutschland');
INSERT INTO prf_zones VALUES (131,204,'IT','Italien');
INSERT INTO prf_zones VALUES (132,204,'FL','Liechtenstein');

# Spain
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'A Coruña','A Coruña');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Alava','Alava');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Albacete','Albacete');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Alicante','Alicante');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Almeria','Almeria');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Asturias','Asturias');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Avila','Avila');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Badajoz','Badajoz');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Baleares','Baleares');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Barcelona','Barcelona');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Burgos','Burgos');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Caceres','Caceres');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Cadiz','Cadiz');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Cantabria','Cantabria');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Castellon','Castellon');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Ceuta','Ceuta');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Ciudad Real','Ciudad Real');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Cordoba','Cordoba');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Cuenca','Cuenca');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Girona','Girona');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Granada','Granada');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Guadalajara','Guadalajara');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Guipuzcoa','Guipuzcoa');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Huelva','Huelva');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Huesca','Huesca');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Jaen','Jaen');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'La Rioja','La Rioja');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Las Palmas','Las Palmas');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Leon','Leon');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Lleida','Lleida');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Lugo','Lugo');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Madrid','Madrid');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Malaga','Malaga');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Melilla','Melilla');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Murcia','Murcia');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Navarra','Navarra');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Ourense','Ourense');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Palencia','Palencia');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Pontevedra','Pontevedra');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Salamanca','Salamanca');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Santa Cruz de Tenerife','Santa Cruz de Tenerife');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Segovia','Segovia');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Sevilla','Sevilla');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Soria','Soria');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Tarragona','Tarragona');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Teruel','Teruel');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Toledo','Toledo');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Valencia','Valencia');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Valladolid','Valladolid');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Vizcaya','Vizcaya');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Zamora','Zamora');
INSERT INTO prf_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Zaragoza','Zaragoza');

#Australia
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,13,'NSW','New South Wales');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,13,'VIC','Victoria');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,13,'QLD','Queensland');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,13,'NT','Northern Territory');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,13,'WA','Western Australia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,13,'SA','South Australia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,13,'TAS','Tasmania');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,13,'ACT','Australian Capital Territory');

#New Zealand
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Northland','Northland');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Auckland','Auckland');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Waikato','Waikato');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Bay of Plenty','Bay of Plenty');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Gisborne','Gisborne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Hawkes Bay','Hawkes Bay');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Taranaki','Taranaki');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Manawatu-Wanganui','Manawatu-Wanganui');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Wellington','Wellington');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'West Coast','West Coast');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Canterbury','Canterbury');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Otago','Otago');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Southland','Southland');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Tasman','Tasman');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Nelson','Nelson');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,153,'Marlborough','Marlborough');

#Brazil
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'SP', 'São Paulo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'RJ', 'Rio de Janeiro');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'PE', 'Pernanbuco');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'BA', 'Bahia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'AM', 'Amazonas');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'MG', 'Minas Gerais');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'ES', 'Espirito Santo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'RS', 'Rio Grande do Sul');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'PR', 'Paraná');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'SC', 'Santa Catarina');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'RG', 'Rio Grande do Norte');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'MS', 'Mato Grosso do Sul');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'MT', 'Mato Grosso');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'GO', 'Goias');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'TO', 'Tocantins');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'DF', 'Distrito Federal');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'RO', 'Rondonia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'AC', 'Acre');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'AP', 'Amapa');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'RO', 'Roraima');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'AL', 'Alagoas');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'CE', 'Ceará');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'MA', 'Maranhão');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'PA', 'Pará');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'PB', 'Paraíba');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'PI', 'Piauí');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '30', 'SE', 'Sergipe');

#Chile
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '43', 'I', 'I Región de Tarapacá');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '43', 'II', 'II Región de Antofagasta');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '43', 'III', 'III Región de Atacama');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '43', 'IV', 'IV Región de Coquimbo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '43', 'V', 'V Región de Valaparaíso');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '43', 'RM', 'Región Metropolitana');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '43', 'VI', 'VI Región de L. B. O´higgins');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '43', 'VII', 'VII Región del Maule');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '43', 'VIII', 'VIII Región del Bío Bío');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '43', 'IX', 'IX Región de la Araucanía');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '43', 'X', 'X Región de los Lagos');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '43', 'XI', 'XI Región de Aysén');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '43', 'XII', 'XII Región de Magallanes');

#Columbia
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'AMA','Amazonas');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'ANT','Antioquia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'ARA','Arauca');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'ATL','Atlantico');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'BOL','Bolivar');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'BOY','Boyaca');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'CAL','Caldas');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'CAQ','Caqueta');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'CAS','Casanare');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'CAU','Cauca');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'CES','Cesar');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'CHO','Choco');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'COR','Cordoba');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'CUN','Cundinamarca');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'HUI','Huila');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'GUA','Guainia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'GUA','Guajira');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'GUV','Guaviare');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'MAG','Magdalena');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'MET','Meta');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'NAR','Narino');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'NDS','Norte de Santander');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'PUT','Putumayo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'QUI','Quindio');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'RIS','Risaralda');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'SAI','San Andres Islas');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'SAN','Santander');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'SUC','Sucre');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'TOL','Tolima');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'VAL','Valle');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'VAU','Vaupes');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,47,'VIC','Vichada');

#France
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'Et','Etranger');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'01','Ain');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'02','Aisne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'03','Allier');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'04','Alpes de Haute Provence');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'05','Hautes-Alpes');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'06','Alpes Maritimes');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'07','Ardèche');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'08','Ardennes');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'09','Ariège');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'10','Aube');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'11','Aude');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'12','Aveyron');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'13','Bouches du Rhône');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'14','Calvados');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'15','Cantal');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'16','Charente');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'17','Charente Maritime');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'18','Cher');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'19','Corrèze');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'2A','Corse du Sud');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'2B','Haute Corse');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'21','Côte d\'Or');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'22','Côtes d\'Armor');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'23','Creuse');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'24','Dordogne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'25','Doubs');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'26','Drôme');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'27','Eure');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'28','Eure et Loir');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'29','Finistère');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'30','Gard');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'31','Haute Garonne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'32','Gers');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'33','Gironde');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'34','Hérault');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'35','Ille et Vilaine');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'36','Indre');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'37','Indre et Loire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'38','Isère');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'39','Jura');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'40','Landes');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'41','Loir et Cher');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'42','Loire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'43','Haute Loire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'44','Loire Atlantique');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'45','Loiret');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'46','Lot');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'47','Lot et Garonne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'48','Lozère');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'49','Maine et Loire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'50','Manche');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'51','Marne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'52','Haute Marne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'53','Mayenne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'54','Meurthe et Moselle');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'55','Meuse');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'56','Morbihan');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'57','Moselle');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'58','Nièvre');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'59','Nord');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'60','Oise');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'61','Orne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'62','Pas de Calais');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'63','Puy de Dôme');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'64','Pyrénées Atlantiques');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'65','Hautes Pyrénées');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'66','Pyrénées Orientales');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'67','Bas Rhin');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'68','Haut Rhin');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'69','Rhône');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'70','Haute Saône');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'71','Saône et Loire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'72','Sarthe');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'73','Savoie');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'74','Haute Savoie');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'75','Paris');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'76','Seine Maritime');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'77','Seine et Marne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'78','Yvelines');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'79','Deux Sèvres');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'80','Somme');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'81','Tarn');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'82','Tarn et Garonne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'83','Var');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'84','Vaucluse');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'85','Vendée');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'86','Vienne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'87','Haute Vienne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'88','Vosges');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'89','Yonne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'90','Territoire de Belfort');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'91','Essonne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'92','Hauts de Seine');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'93','Seine St-Denis');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'94','Val de Marne');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'95','Val d\'Oise');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'971 (DOM)','Guadeloupe');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'972 (DOM)','Martinique');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'973 (DOM)','Guyane');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'974 (DOM)','Saint Denis');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'975 (DOM)','St-Pierre de Miquelon');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'976 (TOM)','Mayotte');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'984 (TOM)','Terres australes et Antartiques françaises');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'985 (TOM)','Nouvelle Calédonie');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'986 (TOM)','Wallis et Futuna');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,73,'987 (TOM)','Polynésie française');

#India
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'DL', 'Delhi');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'MH', 'Maharashtra');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'TN', 'Tamil Nadu');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'KL', 'Kerala');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'AP', 'Andhra Pradesh');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'KA', 'Karnataka');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'GA', 'Goa');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'MP', 'Madhya Pradesh');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'PY', 'Pondicherry');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'GJ', 'Gujarat');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'OR', 'Orrisa');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'CA', 'Chhatisgarh');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'JH', 'Jharkhand');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'BR', 'Bihar');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'WB', 'West Bengal');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'UP', 'Uttar Pradesh');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'RJ', 'Rajasthan');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'PB', 'Punjab');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'HR', 'Haryana');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'CH', 'Chandigarh');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'JK', 'Jammu & Kashmir');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'HP', 'Himachal Pradesh');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'UA', 'Uttaranchal');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'LK', 'Lakshadweep');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'AN', 'Andaman & Nicobar');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'MG', 'Meghalaya');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'AS', 'Assam');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'DR', 'Dadra & Nagar Haveli');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'DN', 'Daman & Diu');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'SK', 'Sikkim');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'TR', 'Tripura');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'MZ', 'Mizoram');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'MN', 'Manipur');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'NL', 'Nagaland');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'AR', 'Arunachal Pradesh');

#Italy
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'AG','Agrigento');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'AL','Alessandria');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'AN','Ancona');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'AO','Aosta');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'AR','Arezzo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'AP','Ascoli Piceno');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'AT','Asti');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'AV','Avellino');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'BA','Bari');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'BL','Belluno');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'BN','Benevento');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'BG','Bergamo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'BI','Biella');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'BO','Bologna');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'BZ','Bolzano');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'BS','Brescia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'BR','Brindisi');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'CA','Cagliari');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'CL','Caltanissetta');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'CB','Campobasso');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'CE','Caserta');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'CT','Catania');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'CZ','Catanzaro');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'CH','Chieti');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'CO','Como');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'CS','Cosenza');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'CR','Cremona');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'KR','Crotone');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'CN','Cuneo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'EN','Enna');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'FE','Ferrara');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'FI','Firenze');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'FG','Foggia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'FO','Forlì');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'FR','Frosinone');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'GE','Genova');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'GO','Gorizia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'GR','Grosseto');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'IM','Imperia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'IS','Isernia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'AQ','Aquila');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'SP','La Spezia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'LT','Latina');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'LE','Lecce');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'LC','Lecco');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'LI','Livorno');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'LO','Lodi');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'LU','Lucca');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'MC','Macerata');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'MN','Mantova');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'MS','Massa-Carrara');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'MT','Matera');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'ME','Messina');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'MI','Milano');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'MO','Modena');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'NA','Napoli');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'NO','Novara');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'NU','Nuoro');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'OR','Oristano');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'PD','Padova');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'PA','Palermo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'PR','Parma');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'PG','Perugia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'PV','Pavia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'PS','Pesaro e Urbino');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'PE','Pescara');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'PC','Piacenza');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'PI','Pisa');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'PT','Pistoia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'PN','Pordenone');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'PZ','Potenza');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'PO','Prato');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'RG','Ragusa');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'RA','Ravenna');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'RC','Reggio di Calabria');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'RE','Reggio Emilia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'RI','Rieti');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'RN','Rimini');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'RM','Roma');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'RO','Rovigo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'SA','Salerno');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'SS','Sassari');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'SV','Savona');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'SI','Siena');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'SR','Siracusa');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'SO','Sondrio');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'TA','Taranto');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'TE','Teramo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'TR','Terni');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'TO','Torino');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'TP','Trapani');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'TN','Trento');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'TV','Treviso');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'TS','Trieste');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'UD','Udine');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'VA','Varese');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'VE','Venezia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'VB','Verbania');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'VC','Vercelli');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'VR','Verona');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'VV','Vibo Valentia');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'VI','Vicenza');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,105,'VT','Viterbo');

#Japan
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Niigata', 'Niigata');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Toyama', 'Toyama');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Ishikawa', 'Ishikawa');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Fukui', 'Fukui');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Yamanashi', 'Yamanashi');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Nagano', 'Nagano');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Gifu', 'Gifu');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Shizuoka', 'Shizuoka');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Aichi', 'Aichi');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Mie', 'Mie');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Shiga', 'Shiga');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Kyoto', 'Kyoto');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Osaka', 'Osaka');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Hyogo', 'Hyogo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Nara', 'Nara');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Wakayama', 'Wakayama');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Tottori', 'Tottori');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Shimane', 'Shimane');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Okayama', 'Okayama');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Hiroshima', 'Hiroshima');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Yamaguchi', 'Yamaguchi');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Tokushima', 'Tokushima');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Kagawa', 'Kagawa');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Ehime', 'Ehime');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Kochi', 'Kochi');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Fukuoka', 'Fukuoka');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Saga', 'Saga');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Nagasaki', 'Nagasaki');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Kumamoto', 'Kumamoto');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Oita', 'Oita');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Miyazaki', 'Miyazaki');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '107', 'Kagoshima', 'Kagoshima');

#Malaysia
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'JOH','Johor');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'KDH','Kedah');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'KEL','Kelantan');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'KL','Kuala Lumpur');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'MEL','Melaka');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'NS','Negeri Sembilan');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'PAH','Pahang');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'PRK','Perak');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'PER','Perlis');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'PP','Pulau Pinang');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'SAB','Sabah');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'SWK','Sarawak');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'SEL','Selangor');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'TER','Terengganu');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,129,'LAB','W.P.Labuan');

#Mexico
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'AGS', 'Aguascalientes');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'BC', 'Baja California');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'BCS', 'Baja California Sur');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'CAM', 'Campeche');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'COA', 'Coahuila');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'COL', 'Colima');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'CHI', 'Chiapas');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'CHIH', 'Chihuahua');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'DF', 'Distrito Federal');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'DGO', 'Durango');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'MEX', 'Estado de Mexico');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'GTO', 'Guanajuato');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'GRO', 'Guerrero');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'HGO', 'Hidalgo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'JAL', 'Jalisco');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'MCH', 'Michoacan');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'MOR', 'Morelos');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'NAY', 'Nayarit');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'NL', 'Nuevo Leon');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'OAX', 'Oaxaca');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'PUE', 'Puebla');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'QRO', 'Queretaro');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'QR', 'Quintana Roo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'SLP', 'San Luis Potosi');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'SIN', 'Sinaloa');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'SON', 'Sonora');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'TAB', 'Tabasco');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'TMPS', 'Tamaulipas');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'TLAX', 'Tlaxcala');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'VER', 'Veracruz');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'YUC', 'Yucatan');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) values (NULL, '138', 'ZAC', 'Zacatecas');

#Norway
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'OSL','Oslo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'AKE','Akershus');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'AUA','Aust-Agder');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'BUS','Buskerud');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'FIN','Finnmark');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'HED','Hedmark');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'HOR','Hordaland');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'MOR','Møre og Romsdal');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'NOR','Nordland');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'NTR','Nord-Trøndelag');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'OPP','Oppland');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'ROG','Rogaland');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'SOF','Sogn og Fjordane');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'STR','Sør-Trøndelag');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'TEL','Telemark');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'TRO','Troms');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'VEA','Vest-Agder');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'OST','Østfold');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL,160,'SVA','Svalbard');

#Pakistan
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'KHI', 'Karachi');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'LH', 'Lahore');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'ISB', 'Islamabad');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'QUE', 'Quetta');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'PSH', 'Peshawar');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'GUJ', 'Gujrat');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'SAH', 'Sahiwal');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'FSB', 'Faisalabad');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 99, 'RIP', 'Rawal Pindi');

#Romania
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'AB','Alba');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'AR','Arad');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'AG','Arges');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'BC','Bacau');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'BH','Bihor');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'BN','Bistrita-Nasaud');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'BT','Botosani');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'BV','Brasov');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'BR','Braila');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'B','Bucuresti');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'BZ','Buzau');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'CS','Caras-Severin');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'CL','Calarasi');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'CJ','Cluj');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'CT','Constanta');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'CV','Covasna');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'DB','Dimbovita');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'DJ','Dolj');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'GL','Galati');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'GR','Giurgiu');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'GJ','Gorj');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'HR','Harghita');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'HD','Hunedoara');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'IL','Ialomita');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'IS','Iasi');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'IF','Ilfov');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'MM','Maramures');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'MH','Mehedint');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'MS','Mures');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'NT','Neamt');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'OT','Olt');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'PH','Prahova');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'SM','Satu-Mare');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'SJ','Salaj');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'SB','Sibiu');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'SV','Suceava');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'TR','Teleorman');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'TM','Timis');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'TL','Tulcea');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'VS','Vaslui');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'VL','Valcea');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 175,'VN','Vrancea');

#South Africa
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '193', 'WP', 'Western Cape');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '193', 'GP', 'Gauteng');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '193', 'KZN', 'Kwazulu-Natal');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '193', 'NC', 'Northern-Cape');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '193', 'EC', 'Eastern-Cape');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '193', 'MP', 'Mpumalanga');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '193', 'NW', 'North-West');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '193', 'FS', 'Free State');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '193', 'NP', 'Northern Province');

#Turkey
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ADANA','ADANA');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ADIYAMAN','ADIYAMAN');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'AFYON','AFYON');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'AGRI','AGRI');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'AMASYA','AMASYA');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ANKARA','ANKARA');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ANTALYA','ANTALYA');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ARTVIN','ARTVIN');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'AYDIN','AYDIN');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'BALIKESIR','BALIKESIR');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'BILECIK','BILECIK');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'BINGÖL','BINGÖL');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'BITLIS','BITLIS');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'BOLU','BOLU');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'BURDUR','BURDUR');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'BURSA','BURSA');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ÇANAKKALE','ÇANAKKALE');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ÇANKIRI','ÇANKIRI');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ÇORUM','ÇORUM');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'DENIZLI','DENIZLI');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'DIYARBAKIR','DIYARBAKIR');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'EDIRNE','EDIRNE');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ELAZIG','ELAZIG');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ERZINCAN','ERZINCAN');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ERZURUM','ERZURUM');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ESKISEHIR','ESKISEHIR');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'GAZIANTEP','GAZIANTEP');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'GIRESUN','GIRESUN');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'GÜMÜSHANE','GÜMÜSHANE');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'HAKKARI','HAKKARI');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'HATAY','HATAY');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ISPARTA','ISPARTA');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'IÇEL','IÇEL');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ISTANBUL','ISTANBUL');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'IZMIR','IZMIR');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'KARS','KARS');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'KASTAMONU','KASTAMONU');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'KAYSERI','KAYSERI');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'KIRKLARELI','KIRKLARELI');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'KIRSEHIR','KIRSEHIR');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'KOCAELI','KOCAELI');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'KONYA','KONYA');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'KÜTAHYA','KÜTAHYA');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'MALATYA','MALATYA');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'MANISA','MANISA');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'KAHRAMANMARAS','KAHRAMANMARAS');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'MARDIN','MARDIN');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'MUGLA','MUGLA');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'MUS','MUS');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'NEVSEHIR','NEVSEHIR');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'NIGDE','NIGDE');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ORDU','ORDU');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'RIZE','RIZE');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'SAKARYA','SAKARYA');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'SAMSUN','SAMSUN');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'SIIRT','SIIRT');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'SINOP','SINOP');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'SIVAS','SIVAS');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'TEKIRDAG','TEKIRDAG');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'TOKAT','TOKAT');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'TRABZON','TRABZON');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'TUNCELI','TUNCELI');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'SANLIURFA','SANLIURFA');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'USAK','USAK');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'VAN','VAN');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'YOZGAT','YOZGAT');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ZONGULDAK','ZONGULDAK');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'AKSARAY','AKSARAY');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'BAYBURT','BAYBURT');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'KARAMAN','KARAMAN');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'KIRIKKALE','KIRIKKALE');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'BATMAN','BATMAN');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'SIRNAK','SIRNAK');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'BARTIN','BARTIN');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'ARDAHAN','ARDAHAN');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'IGDIR','IGDIR');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'YALOVA','YALOVA');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'KARABÜK','KARABÜK');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'KILIS','KILIS');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'OSMANIYE','OSMANIYE');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, 215, 'DÜZCE','DÜZCE');

#Venezuela
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'AM', 'Amazonas');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'AN', 'Anzoátegui');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'AR', 'Aragua');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'AP', 'Apure');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'BA', 'Barinas');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'BO', 'Bolívar');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'CA', 'Carabobo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'CO', 'Cojedes');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'DA', 'Delta Amacuro');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'DC', 'Distrito Capital');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'FA', 'Falcón');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'GA', 'Guárico');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'GU', 'Guayana');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'LA', 'Lara');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'ME', 'Mérida');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'MI', 'Miranda');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'MO', 'Monagas');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'NE', 'Nueva Esparta');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'PO', 'Portuguesa');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'SU', 'Sucre');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'TA', 'Táchira');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'TU', 'Trujillo');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'VA', 'Vargas');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'YA', 'Yaracuy');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '229', 'ZU', 'Zulia');

#UK
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','AVON','Avon');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','BEDS','Bedfordshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','BERK','Berkshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','BIRM','Birmingham');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','BORD','Borders');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','BUCK','Buckinghamshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','CAMB','Cambridgeshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','CENT','Central');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','CHES','Cheshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','CLEV','Cleveland');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','CLWY','Clwyd');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','CORN','Cornwall');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','CUMB','Cumbria');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','DERB','Derbyshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','DEVO','Devon');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','DORS','Dorset');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','DUMF','Dumfries & Galloway');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','DURH','Durham');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','DYFE','Dyfed');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','ESUS','East Sussex');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','ESSE','Essex');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','FIFE','Fife');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','GLAM','Glamorgan');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','GLOU','Gloucestershire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','GRAM','Grampian');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','GWEN','Gwent');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','GWYN','Gwynedd');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','HAMP','Hampshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','HERE','Hereford & Worcester');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','HERT','Hertfordshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','HUMB','Humberside');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','KENT','Kent');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','LANC','Lancashire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','LEIC','Leicestershire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','LINC','Lincolnshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','LOND','London');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','LOTH','Lothian');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','MANC','Manchester');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','MERS','Merseyside');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','NORF','Norfolk');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','NYOR','North Yorkshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','NWHI','North west Highlands');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','NHAM','Northamptonshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','NUMB','Northumberland');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','NOTT','Nottinghamshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','OXFO','Oxfordshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','POWY','Powys');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','SHRO','Shropshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','SOME','Somerset');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','SYOR','South Yorkshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','STAF','Staffordshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','STRA','Strathclyde');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','SUFF','Suffolk');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','SURR','Surrey');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','WSUS','West Sussex');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','TAYS','Tayside');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','TYWE','Tyne & Wear');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','WARW','Warwickshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','WISL','West Isles');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','WYOR','West Yorkshire');
INSERT INTO prf_zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (NULL, '222','WILT','Wiltshire');

#
# Dumping data for table zones_to_geo_zones
#

INSERT INTO prf_zones_to_geo_zones VALUES (5, 57, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (4, 21, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (6, 72, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (7, 73, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (8, 84, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (9, 103, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (10, 105, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (11, 124, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (12, 150, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (13, 14, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (14, 171, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (15, 195, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (16, 222, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (17, 203, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (18, 81, 0, 5, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (19, 1, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (20, 2, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (21, 3, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (22, 4, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (23, 5, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (24, 6, NULL, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (25, 7, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (26, 8, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (27, 9, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (28, 10, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (29, 11, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (30, 13, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (31, 15, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (32, 16, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (33, 17, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (34, 19, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (35, 20, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (36, 22, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (37, 23, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (38, 24, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (39, 25, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (40, 27, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (41, 26, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (42, 28, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (43, 29, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (44, 30, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (45, 31, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (46, 32, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (47, 33, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (48, 34, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (49, 35, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (50, 36, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (51, 37, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (52, 39, NULL, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (53, 38, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (54, 40, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (55, 41, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (56, 42, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (57, 43, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (58, 44, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (59, 45, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (60, 47, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (61, 48, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (62, 49, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (63, 50, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (64, 51, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (65, 52, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (66, 53, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (67, 54, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (68, 55, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (69, 56, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (70, 58, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (71, 59, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (72, 60, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (73, 61, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (74, 62, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (75, 63, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (76, 64, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (77, 65, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (78, 66, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (79, 67, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (80, 68, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (81, 69, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (82, 70, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (83, 71, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (84, 74, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (85, 75, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (86, 76, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (87, 77, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (88, 78, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (89, 79, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (90, 82, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (91, 83, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (92, 86, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (93, 87, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (94, 88, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (95, 89, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (96, 90, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (97, 91, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (98, 92, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (99, 93, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (100, 94, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (101, 95, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (102, 96, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (103, 97, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (104, 99, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (105, 100, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (106, 101, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (107, 102, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (108, 104, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (109, 106, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (110, 107, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (111, 109, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (112, 110, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (113, 111, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (114, 112, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (115, 113, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (116, 114, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (117, 115, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (118, 116, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (119, 117, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (120, 118, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (121, 119, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (122, 120, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (123, 121, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (124, 122, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (125, 125, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (126, 126, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (127, 127, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (128, 128, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (129, 129, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (130, 130, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (131, 131, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (132, 132, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (133, 133, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (134, 134, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (135, 135, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (136, 136, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (137, 137, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (138, 138, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (139, 139, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (140, 140, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (141, 141, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (142, 142, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (143, 143, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (144, 144, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (145, 145, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (146, 146, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (147, 147, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (148, 148, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (149, 149, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (150, 151, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (151, 152, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (152, 153, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (153, 154, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (154, 155, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (155, 156, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (156, 157, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (157, 158, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (158, 159, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (159, 160, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (160, 161, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (161, 162, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (162, 164, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (163, 165, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (164, 166, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (165, 167, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (166, 168, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (167, 169, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (168, 170, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (169, 172, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (170, 173, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (171, 174, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (172, 176, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (173, 177, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (174, 178, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (175, 179, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (176, 180, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (177, 181, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (178, 182, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (179, 183, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (180, 184, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (181, 185, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (182, 186, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (183, 187, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (184, 188, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (185, 189, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (186, 190, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (187, 191, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (188, 193, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (189, 194, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (190, 192, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (191, 196, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (192, 197, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (193, 198, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (194, 199, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (195, 200, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (196, 201, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (197, 202, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (198, 204, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (199, 205, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (200, 206, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (201, 207, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (202, 208, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (203, 209, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (204, 210, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (205, 211, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (206, 212, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (207, 213, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (208, 214, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (209, 215, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (210, 216, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (211, 217, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (212, 218, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (213, 219, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (214, 221, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (215, 223, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (216, 224, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (217, 225, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (218, 226, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (219, 227, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (220, 228, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (221, 229, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (222, 230, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (223, 231, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (224, 232, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (225, 233, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (226, 234, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (227, 235, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (228, 236, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (229, 237, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (230, 238, 0, 6, NULL, now());
INSERT INTO prf_zones_to_geo_zones VALUES (231, 239, 0, 6, NULL, now());

#
# Dumping data for table payment_moneybookers_countries
#

INSERT INTO prf_payment_moneybookers_countries VALUES (2, 'ALB');
INSERT INTO prf_payment_moneybookers_countries VALUES (3, 'ALG');
INSERT INTO prf_payment_moneybookers_countries VALUES (4, 'AME');
INSERT INTO prf_payment_moneybookers_countries VALUES (5, 'AND');
INSERT INTO prf_payment_moneybookers_countries VALUES (6, 'AGL');
INSERT INTO prf_payment_moneybookers_countries VALUES (7, 'ANG');
INSERT INTO prf_payment_moneybookers_countries VALUES (9, 'ANT');
INSERT INTO prf_payment_moneybookers_countries VALUES (10, 'ARG');
INSERT INTO prf_payment_moneybookers_countries VALUES (11, 'ARM');
INSERT INTO prf_payment_moneybookers_countries VALUES (12, 'ARU');
INSERT INTO prf_payment_moneybookers_countries VALUES (13, 'AUS');
INSERT INTO prf_payment_moneybookers_countries VALUES (14, 'AUT');
INSERT INTO prf_payment_moneybookers_countries VALUES (15, 'AZE');
INSERT INTO prf_payment_moneybookers_countries VALUES (16, 'BMS');
INSERT INTO prf_payment_moneybookers_countries VALUES (17, 'BAH');
INSERT INTO prf_payment_moneybookers_countries VALUES (18, 'BAN');
INSERT INTO prf_payment_moneybookers_countries VALUES (19, 'BAR');
INSERT INTO prf_payment_moneybookers_countries VALUES (20, 'BLR');
INSERT INTO prf_payment_moneybookers_countries VALUES (21, 'BGM');
INSERT INTO prf_payment_moneybookers_countries VALUES (22, 'BEL');
INSERT INTO prf_payment_moneybookers_countries VALUES (23, 'BEN');
INSERT INTO prf_payment_moneybookers_countries VALUES (24, 'BER');
INSERT INTO prf_payment_moneybookers_countries VALUES (26, 'BOL');
INSERT INTO prf_payment_moneybookers_countries VALUES (27, 'BOS');
INSERT INTO prf_payment_moneybookers_countries VALUES (28, 'BOT');
INSERT INTO prf_payment_moneybookers_countries VALUES (30, 'BRA');
INSERT INTO prf_payment_moneybookers_countries VALUES (32, 'BRU');
INSERT INTO prf_payment_moneybookers_countries VALUES (33, 'BUL');
INSERT INTO prf_payment_moneybookers_countries VALUES (34, 'BKF');
INSERT INTO prf_payment_moneybookers_countries VALUES (35, 'BUR');
INSERT INTO prf_payment_moneybookers_countries VALUES (36, 'CAM');
INSERT INTO prf_payment_moneybookers_countries VALUES (37, 'CMR');
INSERT INTO prf_payment_moneybookers_countries VALUES (38, 'CAN');
INSERT INTO prf_payment_moneybookers_countries VALUES (39, 'CAP');
INSERT INTO prf_payment_moneybookers_countries VALUES (40, 'CAY');
INSERT INTO prf_payment_moneybookers_countries VALUES (41, 'CEN');
INSERT INTO prf_payment_moneybookers_countries VALUES (42, 'CHA');
INSERT INTO prf_payment_moneybookers_countries VALUES (43, 'CHL');
INSERT INTO prf_payment_moneybookers_countries VALUES (44, 'CHN');
INSERT INTO prf_payment_moneybookers_countries VALUES (47, 'COL');
INSERT INTO prf_payment_moneybookers_countries VALUES (49, 'CON');
INSERT INTO prf_payment_moneybookers_countries VALUES (51, 'COS');
INSERT INTO prf_payment_moneybookers_countries VALUES (52, 'COT');
INSERT INTO prf_payment_moneybookers_countries VALUES (53, 'CRO');
INSERT INTO prf_payment_moneybookers_countries VALUES (54, 'CUB');
INSERT INTO prf_payment_moneybookers_countries VALUES (55, 'CYP');
INSERT INTO prf_payment_moneybookers_countries VALUES (56, 'CZE');
INSERT INTO prf_payment_moneybookers_countries VALUES (57, 'DEN');
INSERT INTO prf_payment_moneybookers_countries VALUES (58, 'DJI');
INSERT INTO prf_payment_moneybookers_countries VALUES (59, 'DOM');
INSERT INTO prf_payment_moneybookers_countries VALUES (60, 'DRP');
INSERT INTO prf_payment_moneybookers_countries VALUES (62, 'ECU');
INSERT INTO prf_payment_moneybookers_countries VALUES (64, 'EL_');
INSERT INTO prf_payment_moneybookers_countries VALUES (65, 'EQU');
INSERT INTO prf_payment_moneybookers_countries VALUES (66, 'ERI');
INSERT INTO prf_payment_moneybookers_countries VALUES (67, 'EST');
INSERT INTO prf_payment_moneybookers_countries VALUES (68, 'ETH');
INSERT INTO prf_payment_moneybookers_countries VALUES (70, 'FAR');
INSERT INTO prf_payment_moneybookers_countries VALUES (71, 'FIJ');
INSERT INTO prf_payment_moneybookers_countries VALUES (72, 'FIN');
INSERT INTO prf_payment_moneybookers_countries VALUES (73, 'FRA');
INSERT INTO prf_payment_moneybookers_countries VALUES (75, 'FRE');
INSERT INTO prf_payment_moneybookers_countries VALUES (78, 'GAB');
INSERT INTO prf_payment_moneybookers_countries VALUES (79, 'GAM');
INSERT INTO prf_payment_moneybookers_countries VALUES (80, 'GEO');
INSERT INTO prf_payment_moneybookers_countries VALUES (81, 'GER');
INSERT INTO prf_payment_moneybookers_countries VALUES (82, 'GHA');
INSERT INTO prf_payment_moneybookers_countries VALUES (83, 'GIB');
INSERT INTO prf_payment_moneybookers_countries VALUES (84, 'GRC');
INSERT INTO prf_payment_moneybookers_countries VALUES (85, 'GRL');
INSERT INTO prf_payment_moneybookers_countries VALUES (87, 'GDL');
INSERT INTO prf_payment_moneybookers_countries VALUES (88, 'GUM');
INSERT INTO prf_payment_moneybookers_countries VALUES (89, 'GUA');
INSERT INTO prf_payment_moneybookers_countries VALUES (90, 'GUI');
INSERT INTO prf_payment_moneybookers_countries VALUES (91, 'GBS');
INSERT INTO prf_payment_moneybookers_countries VALUES (92, 'GUY');
INSERT INTO prf_payment_moneybookers_countries VALUES (93, 'HAI');
INSERT INTO prf_payment_moneybookers_countries VALUES (95, 'HON');
INSERT INTO prf_payment_moneybookers_countries VALUES (96, 'HKG');
INSERT INTO prf_payment_moneybookers_countries VALUES (97, 'HUN');
INSERT INTO prf_payment_moneybookers_countries VALUES (98, 'ICE');
INSERT INTO prf_payment_moneybookers_countries VALUES (99, 'IND');
INSERT INTO prf_payment_moneybookers_countries VALUES (101, 'IRN');
INSERT INTO prf_payment_moneybookers_countries VALUES (102, 'IRA');
INSERT INTO prf_payment_moneybookers_countries VALUES (103, 'IRE');
INSERT INTO prf_payment_moneybookers_countries VALUES (104, 'ISR');
INSERT INTO prf_payment_moneybookers_countries VALUES (105, 'ITA');
INSERT INTO prf_payment_moneybookers_countries VALUES (106, 'JAM');
INSERT INTO prf_payment_moneybookers_countries VALUES (107, 'JAP');
INSERT INTO prf_payment_moneybookers_countries VALUES (108, 'JOR');
INSERT INTO prf_payment_moneybookers_countries VALUES (109, 'KAZ');
INSERT INTO prf_payment_moneybookers_countries VALUES (110, 'KEN');
INSERT INTO prf_payment_moneybookers_countries VALUES (112, 'SKO');
INSERT INTO prf_payment_moneybookers_countries VALUES (113, 'KOR');
INSERT INTO prf_payment_moneybookers_countries VALUES (114, 'KUW');
INSERT INTO prf_payment_moneybookers_countries VALUES (115, 'KYR');
INSERT INTO prf_payment_moneybookers_countries VALUES (116, 'LAO');
INSERT INTO prf_payment_moneybookers_countries VALUES (117, 'LAT');
INSERT INTO prf_payment_moneybookers_countries VALUES (141, 'MCO');
INSERT INTO prf_payment_moneybookers_countries VALUES (119, 'LES');
INSERT INTO prf_payment_moneybookers_countries VALUES (120, 'LIB');
INSERT INTO prf_payment_moneybookers_countries VALUES (121, 'LBY');
INSERT INTO prf_payment_moneybookers_countries VALUES (122, 'LIE');
INSERT INTO prf_payment_moneybookers_countries VALUES (123, 'LIT');
INSERT INTO prf_payment_moneybookers_countries VALUES (124, 'LUX');
INSERT INTO prf_payment_moneybookers_countries VALUES (125, 'MAC');
INSERT INTO prf_payment_moneybookers_countries VALUES (126, 'F.Y');
INSERT INTO prf_payment_moneybookers_countries VALUES (127, 'MAD');
INSERT INTO prf_payment_moneybookers_countries VALUES (128, 'MLW');
INSERT INTO prf_payment_moneybookers_countries VALUES (129, 'MLS');
INSERT INTO prf_payment_moneybookers_countries VALUES (130, 'MAL');
INSERT INTO prf_payment_moneybookers_countries VALUES (131, 'MLI');
INSERT INTO prf_payment_moneybookers_countries VALUES (132, 'MLT');
INSERT INTO prf_payment_moneybookers_countries VALUES (134, 'MAR');
INSERT INTO prf_payment_moneybookers_countries VALUES (135, 'MRT');
INSERT INTO prf_payment_moneybookers_countries VALUES (136, 'MAU');
INSERT INTO prf_payment_moneybookers_countries VALUES (138, 'MEX');
INSERT INTO prf_payment_moneybookers_countries VALUES (140, 'MOL');
INSERT INTO prf_payment_moneybookers_countries VALUES (142, 'MON');
INSERT INTO prf_payment_moneybookers_countries VALUES (143, 'MTT');
INSERT INTO prf_payment_moneybookers_countries VALUES (144, 'MOR');
INSERT INTO prf_payment_moneybookers_countries VALUES (145, 'MOZ');
INSERT INTO prf_payment_moneybookers_countries VALUES (76, 'PYF');
INSERT INTO prf_payment_moneybookers_countries VALUES (147, 'NAM');
INSERT INTO prf_payment_moneybookers_countries VALUES (149, 'NEP');
INSERT INTO prf_payment_moneybookers_countries VALUES (150, 'NED');
INSERT INTO prf_payment_moneybookers_countries VALUES (151, 'NET');
INSERT INTO prf_payment_moneybookers_countries VALUES (152, 'CDN');
INSERT INTO prf_payment_moneybookers_countries VALUES (153, 'NEW');
INSERT INTO prf_payment_moneybookers_countries VALUES (154, 'NIC');
INSERT INTO prf_payment_moneybookers_countries VALUES (155, 'NIG');
INSERT INTO prf_payment_moneybookers_countries VALUES (69, 'FLK');
INSERT INTO prf_payment_moneybookers_countries VALUES (160, 'NWY');
INSERT INTO prf_payment_moneybookers_countries VALUES (161, 'OMA');
INSERT INTO prf_payment_moneybookers_countries VALUES (162, 'PAK');
INSERT INTO prf_payment_moneybookers_countries VALUES (164, 'PAN');
INSERT INTO prf_payment_moneybookers_countries VALUES (165, 'PAP');
INSERT INTO prf_payment_moneybookers_countries VALUES (166, 'PAR');
INSERT INTO prf_payment_moneybookers_countries VALUES (167, 'PER');
INSERT INTO prf_payment_moneybookers_countries VALUES (168, 'PHI');
INSERT INTO prf_payment_moneybookers_countries VALUES (170, 'POL');
INSERT INTO prf_payment_moneybookers_countries VALUES (171, 'POR');
INSERT INTO prf_payment_moneybookers_countries VALUES (172, 'PUE');
INSERT INTO prf_payment_moneybookers_countries VALUES (173, 'QAT');
INSERT INTO prf_payment_moneybookers_countries VALUES (175, 'ROM');
INSERT INTO prf_payment_moneybookers_countries VALUES (176, 'RUS');
INSERT INTO prf_payment_moneybookers_countries VALUES (177, 'RWA');
INSERT INTO prf_payment_moneybookers_countries VALUES (178, 'SKN');
INSERT INTO prf_payment_moneybookers_countries VALUES (179, 'SLU');
INSERT INTO prf_payment_moneybookers_countries VALUES (180, 'ST.');
INSERT INTO prf_payment_moneybookers_countries VALUES (181, 'WES');
INSERT INTO prf_payment_moneybookers_countries VALUES (182, 'SAN');
INSERT INTO prf_payment_moneybookers_countries VALUES (183, 'SAO');
INSERT INTO prf_payment_moneybookers_countries VALUES (184, 'SAU');
INSERT INTO prf_payment_moneybookers_countries VALUES (185, 'SEN');
INSERT INTO prf_payment_moneybookers_countries VALUES (186, 'SEY');
INSERT INTO prf_payment_moneybookers_countries VALUES (187, 'SIE');
INSERT INTO prf_payment_moneybookers_countries VALUES (188, 'SIN');
INSERT INTO prf_payment_moneybookers_countries VALUES (189, 'SLO');
INSERT INTO prf_payment_moneybookers_countries VALUES (190, 'SLV');
INSERT INTO prf_payment_moneybookers_countries VALUES (191, 'SOL');
INSERT INTO prf_payment_moneybookers_countries VALUES (192, 'SOM');
INSERT INTO prf_payment_moneybookers_countries VALUES (193, 'SOU');
INSERT INTO prf_payment_moneybookers_countries VALUES (195, 'SPA');
INSERT INTO prf_payment_moneybookers_countries VALUES (196, 'SRI');
INSERT INTO prf_payment_moneybookers_countries VALUES (199, 'SUD');
INSERT INTO prf_payment_moneybookers_countries VALUES (200, 'SUR');
INSERT INTO prf_payment_moneybookers_countries VALUES (202, 'SWA');
INSERT INTO prf_payment_moneybookers_countries VALUES (203, 'SWE');
INSERT INTO prf_payment_moneybookers_countries VALUES (204, 'SWI');
INSERT INTO prf_payment_moneybookers_countries VALUES (205, 'SYR');
INSERT INTO prf_payment_moneybookers_countries VALUES (206, 'TWN');
INSERT INTO prf_payment_moneybookers_countries VALUES (207, 'TAJ');
INSERT INTO prf_payment_moneybookers_countries VALUES (208, 'TAN');
INSERT INTO prf_payment_moneybookers_countries VALUES (209, 'THA');
INSERT INTO prf_payment_moneybookers_countries VALUES (210, 'TOG');
INSERT INTO prf_payment_moneybookers_countries VALUES (212, 'TON');
INSERT INTO prf_payment_moneybookers_countries VALUES (213, 'TRI');
INSERT INTO prf_payment_moneybookers_countries VALUES (214, 'TUN');
INSERT INTO prf_payment_moneybookers_countries VALUES (215, 'TUR');
INSERT INTO prf_payment_moneybookers_countries VALUES (216, 'TKM');
INSERT INTO prf_payment_moneybookers_countries VALUES (217, 'TCI');
INSERT INTO prf_payment_moneybookers_countries VALUES (219, 'UGA');
INSERT INTO prf_payment_moneybookers_countries VALUES (231, 'BRI');
INSERT INTO prf_payment_moneybookers_countries VALUES (221, 'UAE');
INSERT INTO prf_payment_moneybookers_countries VALUES (222, 'GBR');
INSERT INTO prf_payment_moneybookers_countries VALUES (223, 'UNI');
INSERT INTO prf_payment_moneybookers_countries VALUES (225, 'URU');
INSERT INTO prf_payment_moneybookers_countries VALUES (226, 'UZB');
INSERT INTO prf_payment_moneybookers_countries VALUES (227, 'VAN');
INSERT INTO prf_payment_moneybookers_countries VALUES (229, 'VEN');
INSERT INTO prf_payment_moneybookers_countries VALUES (230, 'VIE');
INSERT INTO prf_payment_moneybookers_countries VALUES (232, 'US_');
INSERT INTO prf_payment_moneybookers_countries VALUES (235, 'YEM');
INSERT INTO prf_payment_moneybookers_countries VALUES (236, 'YUG');
INSERT INTO prf_payment_moneybookers_countries VALUES (238, 'ZAM');
INSERT INTO prf_payment_moneybookers_countries VALUES (239, 'ZIM');

#
# Dumping data for table payment_moneybookers_currencies
#

INSERT INTO prf_payment_moneybookers_currencies VALUES ('AUD', 'Australian Dollar');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('BGN', 'Bulgarian Lev');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('CAD', 'Canadian Dollar');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('CHF', 'Swiss Franc');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('CZK', 'Czech Koruna');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('DKK', 'Danish Krone');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('EEK', 'Estonian Koruna');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('EUR', 'Euro');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('GBP', 'Pound Sterling');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('HKD', 'Hong Kong Dollar');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('HUF', 'Forint');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('ILS', 'Shekel');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('ISK', 'Iceland Krona');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('JPY', 'Yen');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('KRW', 'South-Korean Won');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('LVL', 'Latvian Lat');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('MYR', 'Malaysian Ringgit');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('NOK', 'Norwegian Krone');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('NZD', 'New Zealand Dollar');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('PLN', 'Zloty');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('SEK', 'Swedish Krona');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('SGD', 'Singapore Dollar');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('SKK', 'Slovak Koruna');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('THB', 'Baht');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('TWD', 'New Taiwan Dollar');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('USD', 'US Dollar');
INSERT INTO prf_payment_moneybookers_currencies VALUES ('ZAR', 'South-African Rand');

INSERT INTO prf_affiliate_payment_status VALUES (0, 1, 'Pending');
INSERT INTO prf_affiliate_payment_status VALUES (0, 2, 'Offen');
INSERT INTO prf_affiliate_payment_status VALUES (0, 3, 'Pendiente');
INSERT INTO prf_affiliate_payment_status VALUES (1, 1, 'Paid');
INSERT INTO prf_affiliate_payment_status VALUES (1, 2, 'Ausgezahlt');
INSERT INTO prf_affiliate_payment_status VALUES (1, 3, 'Pagado');

# Insert some needed Content to the content manager
# german Stuff
INSERT INTO prf_content_manager VALUES (NULL, 0, 0, 2, 'Partner AGB', 'Unsere Affiliate AGB', 'Tragen Sie <strong>hier</strong> Ihre <EM><U>allgemeinen Geschäftsbedingungen</U></EM> für Ihr Partnerprogramm ein.', 900, '', 1, 900, 0, 0);
INSERT INTO prf_content_manager VALUES (NULL, 0, 0, 2, 'Affiliate Info', 'Affiliate Informationen', 'Tragen Sie <strong>hier</strong> Ihre <EM><U>Informationen zum Affiliate Programm</U></EM> ein.', 900, '', 1, 901, 0, 0);
INSERT INTO prf_content_manager VALUES (NULL, 0, 0, 2, 'Affiliate FAQ', 'Häufig gestellte Fragen', 'Tragen Sie <strong>hier</strong> Ihre <EM><U>FAQ zum Affiliate Programm</U></EM> ein.', 900, '', 1, 902, 0, 0);
# english stuff
INSERT INTO prf_content_manager VALUES (NULL, 0, 0, 1, 'Partner T&C', 'Our Affiliate Terms and Conditions', 'Put in <strong>here</strong> your <EM><U>terms and conditions</U></EM> for your affiliate program.', 900, '', 1, 900, 0, 0);
INSERT INTO prf_content_manager VALUES (NULL, 0, 0, 1, 'Affiliate Info', 'Affiliate Information', 'Put in <strong>here</strong> your <EM><U>information about your affiliate program</U></EM>.', 900, '', 1, 901, 0, 0);
INSERT INTO prf_content_manager VALUES (NULL, 0, 0, 1, 'Affiliate FAQ', 'Frequently Asked Questions', 'Put in <strong>here</strong> some <EM><U>FAQ for your affiliate program</U></EM>.', 900, '', 1, 902, 0, 0);

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
	id int(11) NOT NULL auto_increment,
	auction_id bigint(20) NOT NULL,
	transaction_id bigint(20) default '0',
	endtime timestamp NULL default NULL,
	auction_endprice double NOT NULL,
	amount int(11) NOT NULL,
	buyer_id varchar(255) NOT NULL,
	buyer_name varchar(255) NOT NULL,
	buyer_email varchar(255) NOT NULL,
	buyer_countrycode varchar(255),
	buyer_land varchar(255) NOT NULL,
	buyer_zip varchar(255) NOT NULL,
	buyer_city varchar(255) NOT NULL,
	buyer_street varchar(255) NOT NULL,
	buyer_state varchar(255) NOT NULL,
	buyer_phone varchar(32) NOT NULL,
	basket tinyint(4) default '0',
	order_number bigint(20) default '0',
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS prf_auction_list;
CREATE TABLE prf_auction_list (
	auction_id bigint(20) NOT NULL,
	auction_title varchar(255) NOT NULL,
	product_id int(11) NOT NULL,
	predef_id int(11) NOT NULL,
	quantity int(11) NOT NULL,
	startprice double NOT NULL,
	buynowprice double NOT NULL,
	buynow tinyint(4) NOT NULL,
	starttime timestamp NULL default NULL,
	endtime timestamp NULL default NULL,
	bidcount bigint(20) default '0',
	bidprice double default '0',
	ended tinyint(4) default '0',
	PRIMARY KEY (auction_id)
);

DROP TABLE IF EXISTS prf_auction_predefinition;
CREATE TABLE prf_auction_predefinition (
	predef_id bigint(20) NOT NULL auto_increment,
	product_id int(11) default NULL,
	auction_type int(11) default NULL,
	title varchar(255),
	subtitle varchar(255),
	cat1 bigint(20) default NULL,
	cat2 bigint(20) default NULL,
	description text,
	auction int(1) NOT NULL,
	express int(1) NOT NULL,
	express_duration int(1) NOT NULL,
	duration int(11) default NULL,
	amount int(11) default NULL,
	startprice double default NULL,
	binprice double default NULL,
	city varchar(255),
	country varchar(255),
	pic_url text,
	gallery_pic_url varchar(255),
	gallery_pic_plus int(1) NOT NULL,
	auto_resubmit int(1) NOT NULL,
	bold tinyint(1) default NULL,
	highlight tinyint(1) default NULL,
	border tinyint(1) default NULL,
	cod tinyint(1) default NULL,
	cop tinyint(1) default NULL,
	cc tinyint(1) default NULL,
	paypal tinyint(1) default NULL,
	de tinyint(1) default NULL,
	at tinyint(1) default NULL,
	ch tinyint(1) default NULL,
	template varchar(255) default '',
	PRIMARY KEY (predef_id)
);

DROP TABLE IF EXISTS prf_ebay_auctiontype;
CREATE TABLE prf_ebay_auctiontype (
	id int(11) NOT NULL,
	name varchar(255) NOT NULL,
	description varchar(255) NOT NULL,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS prf_ebay_categories;
CREATE TABLE prf_ebay_categories (
	myid bigint(20) NOT NULL auto_increment,
	name varchar(100) NOT NULL default '',
	id int(11) NOT NULL default '0',
	parentid int(11) NOT NULL default '0',
	leaf set('0','1') default '0',
	virtual set('0','1') NOT NULL default '',
	expired set('0','1') NOT NULL default '',
	PRIMARY KEY (myid)
);

DROP TABLE IF EXISTS prf_ebay_config;
CREATE TABLE prf_ebay_config (
	id int(11) NOT NULL auto_increment,
	category_version varchar(5) default NULL,
	category_update_time timestamp NULL default NULL,
	event_update_time timestamp NULL default NULL,
	transaction_update_time timestamp NULL default NULL,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS prf_ebay_products;
CREATE TABLE prf_ebay_products (
	products_id int(11) NOT NULL,
	auction_description varchar(255) NOT NULL,
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
(1,NULL,NULL,NULL,NULL);

#eBay Konfiguration
INSERT INTO prf_configuration_group VALUES (790, 'eBay-Konnektor', 'Einstellungen für den eBay-Konnektor', '17', '1');

INSERT INTO prf_configuration VALUES (NULL, 'EBAY_MEMBER_NAME', 'ihr_ebay_name', 790, 0, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EBAY_REAL_SHOP_URL', 'http://www.mein-shop-server.de/', 790, 2, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EBAY_EBAY_EXPRESS_ONLY', 'false', 790, 10, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO prf_configuration VALUES (NULL, 'EBAY_SHIPPING_MODULE', '', 790, 20, NULL, now(), NULL, 'olc_cfg_pull_down_shipping_list(');
INSERT INTO prf_configuration VALUES (NULL, 'EBAY_PAYPAL_EMAIL_ADDRESS', '', 790, 30, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EBAY_TEST_MODE', 'true', 790, 40, NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO prf_configuration VALUES (NULL, 'EBAY_TEST_MODE_DEVID', '', 790, 42, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EBAY_TEST_MODE_APPID', '', 790, 44, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EBAY_TEST_MODE_CERTID', '', 790, 46, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EBAY_TEST_MODE_TOKEN', '', 790, 48, NULL, now(), NULL, 'olc_cfg_textarea(');

INSERT INTO prf_configuration VALUES (NULL, 'EBAY_PRODUCTION_DEVID', '', 790, 52, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EBAY_PRODUCTION_APPID', '', 790, 54, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EBAY_PRODUCTION_CERTID', '', 790, 56, NULL, now(), NULL, NULL);
INSERT INTO prf_configuration VALUES (NULL, 'EBAY_PRODUCTION_TOKEN', '', 790, 58, NULL, now(), NULL, 'olc_cfg_textarea(');
#End