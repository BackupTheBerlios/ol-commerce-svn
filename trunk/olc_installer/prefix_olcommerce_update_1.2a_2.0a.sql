#SET SESSION sql_mode='';
#
#!!!!!Für MySQL 5 das Zeichen '#' in der 1. Zeile entfernen!!!!!
#
# -----------------------------------------------------------------------------------------
#  $Id: prefix_olcommerce_update_1.2a_2.0a.sql,v 1.1.1.1.2.1 2007/04/08 07:18:33 gswkaiser Exp $
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

DROP TABLE IF EXISTS box_configuration;
CREATE TABLE IF NOT EXISTS box_configuration (
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

DROP TABLE IF EXISTS customers_basket_save_baskets;
CREATE TABLE IF NOT EXISTS customers_basket_save_baskets (
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

DROP TABLE IF EXISTS customers_basket_save;
CREATE TABLE IF NOT EXISTS customers_basket_save (
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

DROP TABLE IF EXISTS customers_basket_attributes_save;
CREATE TABLE IF NOT EXISTS customers_basket_attributes_save (
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

DROP TABLE IF EXISTS banktransfer_blz;
CREATE TABLE IF NOT EXISTS banktransfer_blz (
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

DROP TABLE IF EXISTS campaigns;
CREATE TABLE campaigns (
  campaigns_id int(11) NOT NULL auto_increment,
  campaigns_name varchar(255) NOT NULL default '',
  campaigns_refID varchar(64) default NULL,
  campaigns_leads int(11) NOT NULL default '0',
  date_added datetime default NULL,
  last_modified datetime default NULL,
  PRIMARY KEY  (campaigns_id),
  KEY IDX_CAMPAIGNS_NAME (campaigns_name)
);

DROP TABLE IF EXISTS campaigns_ip;
CREATE TABLE  campaigns_ip (
 user_ip VARCHAR(255) NOT NULL ,
 time DATETIME NOT NULL ,
 campaign VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS cao_log;
CREATE TABLE IF NOT EXISTS cao_log (
  id int(11) NOT NULL auto_increment,
  date datetime NOT NULL,
  user varchar(64) NOT NULL default '',
  pw varchar(64) NOT NULL default '',
  method varchar(64) NOT NULL default '',
  action varchar(64) NOT NULL default '',
  post_data mediumtext,
  get_data mediumtext,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS personal_offers_by_customers_status_0;
CREATE TABLE IF NOT EXISTS personal_offers_by_customers_status_0 (
  price_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  quantity int(11) default NULL,
  personal_offer decimal(15,4) default NULL,
  PRIMARY KEY (price_id)
);

DROP TABLE IF EXISTS personal_offers_by_customers_status_1;
CREATE TABLE IF NOT EXISTS personal_offers_by_customers_status_1 (
  price_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  quantity int(11) default NULL,
  personal_offer decimal(15,4) default NULL,
  PRIMARY KEY (price_id)
);

DROP TABLE IF EXISTS personal_offers_by_customers_status_2;
CREATE TABLE IF NOT EXISTS personal_offers_by_customers_status_2 (
  price_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  quantity int(11) default NULL,
  personal_offer decimal(15,4) default NULL,
  PRIMARY KEY (price_id)
);

DROP TABLE IF EXISTS personal_offers_by_customers_status_3;
CREATE TABLE IF NOT EXISTS personal_offers_by_customers_status_3 (
  price_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  quantity int(11) default NULL,
  personal_offer decimal(15,4) default NULL,
  PRIMARY KEY (price_id)
);

DROP TABLE IF EXISTS whos_online_data;
CREATE TABLE IF NOT EXISTS whos_online_data (
  session_id varchar(128) NOT NULL default '',
  online_ips LONGTEXT,
  online_ips_text LONGTEXT,
	PRIMARY KEY (session_id)
);

DROP TABLE IF EXISTS plz;
CREATE TABLE IF NOT EXISTS plz (
  plz varchar(5) NOT NULL default '',
  ort varchar(50) NOT NULL default '',
  land char(3) NOT NULL default '',
  bundesland char(2) NOT NULL default '',
  vorwahl char(6) NOT NULL default '',
  KEY plz (plz),
  KEY land (land)
);

DROP TABLE IF EXISTS vornamen;
CREATE TABLE IF NOT EXISTS vornamen (
  vorname varchar(20) NOT NULL default '',
  geschlecht text NOT NULL,
  KEY vorname (vorname)
);

#
# Table structures for PayPal IPN
#
#
# Table structure for table orders_session_info
#

DROP TABLE IF EXISTS orders_session_info;
CREATE TABLE orders_session_info (
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

DROP TABLE IF EXISTS paypal;
CREATE TABLE paypal (
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

DROP TABLE IF EXISTS paypal_payment_status_history;
CREATE TABLE IF NOT EXISTS paypal_payment_status_history (
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

DROP TABLE IF EXISTS paypal_auction;
CREATE TABLE IF NOT EXISTS paypal_auction (
  paypal_id int(11) NOT NULL default '0',
  item_number varchar(96) NOT NULL default '',
  auction_buyer_id varchar(96) NOT NULL default '',
  auction_multi_item tinyint(4) NOT NULL default '0',
  auction_closing_date datetime NOT NULL default '0000-00-00 00:00:00',
  is_old int(1) NOT NULL default '0',
  PRIMARY KEY (paypal_id,item_number)
);

ALTER TABLE admin_access ADD easypopulate int(1) default NULL;
ALTER TABLE admin_access ADD froogle int(1) default NULL;
ALTER TABLE admin_access ADD down_for_maintenance int(1) NOT NULL default '0';
ALTER TABLE admin_access ADD attributeManager int(1) NOT NULL default '0';
ALTER TABLE admin_access ADD google_sitemap int(1) NOT NULL default '0';
ALTER TABLE admin_access ADD elmar_start int(1) NOT NULL default '0';
ALTER TABLE admin_access ADD blz_update int(1) NOT NULL default '0';
ALTER TABLE admin_access ADD livehelp int(1) NOT NULL default '0';
ALTER TABLE admin_access ADD pdf_datasheet  int(1) NOT NULL default '0';
ALTER TABLE admin_access ADD chCounter int(1) NOT NULL default '0';
ALTER TABLE admin_access ADD paypal_ipn int(1) NOT NULL default '0';
ALTER TABLE admin_access ADD eazysales int(1) NOT NULL default '0';
ALTER TABLE admin_access ADD ebay int(1) NOT NULL default '0';
ALTER TABLE admin_access ADD campaigns int(1) NOT NULL default '0';
ALTER TABLE admin_access ADD stats_campaigns int(1) NOT NULL default '0';
ALTER TABLE admin_access ADD products_uvp int(1) NOT NULL default '0';
ALTER TABLE admin_access ADD import_export int(1) NOT NULL default '0';

UPDATE admin_access SET easypopulate = 1, froogle = 1, down_for_maintenance = 1, attributeManager = 1, google_sitemap = 1, elmar_start = 1, blz_update = 1, livehelp = 1, products_vpe = 1, pdf_export = 1, pdf_datasheet = 1, listcategories = 1, listproducts = 1, chCounter = 1, paypal_ipn = 1, eazysales = 1, ebay = 1, campaigns = 1, stats_campaigns = 1,
products_uvp = 1, import_export = 1 WHERE  customers_id = '1';

UPDATE admin_access SET easypopulate = 0, froogle = 1, down_for_maintenance = 0, attributeManager = 0, google_sitemap = 0, elmar_start = 0, blz_update = 0, livehelp = 0, products_vpe = 0, pdf_export = 0, pdf_datasheet = 0, listcategories = 0, listproducts = 0, chCounter = 0,  paypal_ipn = 0, eazysales = 0, ebay = 0, campaigns = 0, stats_campaigns = 0,
products_uvp = 0, import_export = 0  WHERE  customers_id = 'groups';

ALTER TABLE content_manager ADD sort_order TINYINT( 4 ) NOT NULL DEFAULT '0';

ALTER TABLE coupon_gv_queue CHANGE ipaddr ipaddr varchar(255) NOT NULL default '';

ALTER TABLE customers ADD customers_email_type TINYINT(1) NOT NULL default 0 AFTER customers_email_address;
ALTER TABLE customers ADD customers_paypal_payerid VARCHAR( 20 ) AFTER customers_newsletter_mode;
ALTER TABLE customers ADD customers_paypal_ec TINYINT (1) UNSIGNED DEFAULT '0' NOT NULL AFTER customers_paypal_payerid;
ALTER TABLE customers ADD customers_ebay_name varchar(255) NOT NULL default '' AFTER customers_paypal_ec;

ALTER TABLE customers_ip CHANGE customers_ip customers_ip VARCHAR(255) NOT NULL default '';

ALTER TABLE newsletter_recipients ADD customers_email_type TINYINT(1) NOT NULL default 0 AFTER customers_email_address;

ALTER TABLE orders ADD customers_email_type TINYINT(1) NOT NULL default 0 AFTER customers_email_address;
ALTER TABLE orders CHANGE customers_ip customers_ip varchar(255) NOT NULL default '';
ALTER TABLE orders ADD orders_trackcode varchar(64) default NULL;
ALTER TABLE orders ADD orders_discount INT( 11 ) DEFAULT '0' NOT NULL;
ALTER TABLE orders ADD payment_id INT( 11 ) DEFAULT '0' NOT NULL;
ALTER TABLE orders ADD shipping_tax DECIMAL( 7, 4 ) DEFAULT '19.000' NOT NULL;

ALTER TABLE orders_products_attributes ADD products_options_id INT( 11 ) DEFAULT '0' NOT NULL;
ALTER TABLE orders_products_attributes ADD products_options_values_id INT( 11 ) DEFAULT '0' NOT NULL;

ALTER TABLE products ADD products_ean varchar(128) AFTER products_id;
ALTER TABLE products ADD products_uvp DECIMAL(15,2) NOT NULL AFTER products_fsk18;
ALTER TABLE products ADD products_image_medium VARCHAR(64) NOT NULL default '' AFTER products_image;
ALTER TABLE products ADD products_image_large VARCHAR(64) NOT NULL default '' AFTER products_image_medium;
ALTER TABLE products ADD products_baseprice_show int(1) default NULL;
ALTER TABLE products ADD products_baseprice_value decimal(15,2) default NULL;
ALTER TABLE products ADD products_min_order_quantity int(11) default NULL;
ALTER TABLE products ADD products_min_order_vpe int(11) default NULL;
ALTER TABLE products ADD products_promotion_status tinyint(1) NOT NULL default '0' AFTER products_status;
ALTER TABLE products ADD products_promotion_show_title tinyint(1) NOT NULL default '0' AFTER products_promotion_status;
ALTER TABLE products ADD products_promotion_show_desc tinyint(1) NOT NULL default '0' AFTER products_promotion_show_title;

ALTER TABLE products_description ADD products_promotion_desc text AFTER products_viewed;
ALTER TABLE products_description ADD products_promotion_title varchar(255) default NULL AFTER products_promotion_desc;
ALTER TABLE products_description ADD products_promotion_image varchar(255) default NULL AFTER products_promotion_title;

ALTER TABLE products ADD INDEX products_model (products_model);

ALTER TABLE whos_online CHANGE ip_address ip_address varchar(255) NOT NULL default '';
ALTER TABLE whos_online CHANGE last_page_url last_page_url varchar(255) NOT NULL default '';
ALTER TABLE whos_online ADD PRIMARY KEY (`session_id`);

ALTER TABLE sessions ADD INDEX (`expiry`);

INSERT IGNORE INTO orders_status VALUES ( '4', '1', 'On Hold');
INSERT IGNORE INTO orders_status VALUES ( '4', '2', 'Blockiert');
INSERT IGNORE INTO orders_status VALUES ( '5', '1', 'Refunded');
INSERT IGNORE INTO orders_status VALUES ( '5', '2', 'Erstattet');
INSERT IGNORE INTO orders_status VALUES ( '6', '1', 'Canceled');
INSERT IGNORE INTO orders_status VALUES ( '6', '2', 'Ungültig');
INSERT IGNORE INTO orders_status VALUES ( '7', '1', 'Completed');
INSERT IGNORE INTO orders_status VALUES ( '7', '2', 'Abgeschlossen');
INSERT IGNORE INTO orders_status VALUES ( '8', '1', 'Failed');
INSERT IGNORE INTO orders_status VALUES ( '8', '2', 'Fehlgeschlagen');
INSERT IGNORE INTO orders_status VALUES ( '9', '1', 'Denied');
INSERT IGNORE INTO orders_status VALUES ( '9', '2', 'Abgelehnt');
INSERT IGNORE INTO orders_status VALUES ( '10', '1', 'Reversed');
INSERT IGNORE INTO orders_status VALUES ( '10', '2', 'Zurückerstattet');
INSERT IGNORE INTO orders_status VALUES ( '11', '1', 'Canceled Reversal');
INSERT IGNORE INTO orders_status VALUES ( '11', '2', 'Zurückerstattung aufgehoben');

ALTER TABLE configuration CHANGE configuration_value configuration_value TEXT NOT NULL default '';
INSERT IGNORE INTO configuration VALUES (NULL, 'CUSTOMER_STATUS_NO_FERNAG_INFO_IDS', '',  1, 22, NULL, now(), NULL, NULL);

INSERT IGNORE INTO configuration VALUES (NULL, 'PRODUCT_IMAGE_ON_THE_FLY', 'false', 4, 50, NULL, now(), NULL, 'cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO configuration VALUES (NULL, 'DEFAULT_CUSTOMERS_STATUS_ID_COMPANY', '3', 1, 16, NULL, now(), 'get_customers_status_name', 'cfg_pull_down_customers_status_list(');

INSERT INTO configuration_group VALUES ('19', 'Slideshows', 'Konfiguration der Slideshow-Optionen', '19', '1');
INSERT INTO configuration_group VALUES ('20', 'Import/Export', 'Konfiguration der Import/Export-Optionen', '20', '1');

#Slideshow Konfiguration
INSERT INTO configuration VALUES (NULL, 'SLIDESHOW_INTERVAL', '5', 19, 0, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'SLIDESHOW_INTERVAL_MIN', '3', 19, 1, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS', 'false', 19, 10, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS_HEIGHT', '230', 19, 20, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS_WIDTH', '400', 19, 30, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS_BORDER', 'false', 19, 40, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO configuration VALUES (NULL, 'SLIDESHOW_PRODUCTS_CONTROLS', 'true', 19, 41, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');

INSERT INTO configuration VALUES (NULL, 'SLIDESHOW_IMAGES', 'false', 19, 50, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO configuration VALUES (NULL, 'SLIDESHOW_IMAGES_HEIGHT', '230', 19, 60, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'SLIDESHOW_IMAGES_WIDTH', '400', 19, 70, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'SLIDESHOW_IMAGES_BORDER', 'false', 19, 80, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO configuration VALUES (NULL, 'SLIDESHOW_IMAGES_CONTROLS', 'true', 19, 81, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO configuration VALUES (NULL, 'SLIDESHOW_IMAGES_SHOW_TEXT', 'true', 19, 90, NULL, now(), NULL, 'olc_cfg_select_option(array(''true'', ''false''),');

INSERT INTO configuration VALUES (NULL, 'CSV_TEXTSIGN', '"', '20', '10', NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'CSV_SEPERATOR', '\t', '20', '20', NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'COMPRESS_EXPORT', 'false', '20', '30', NULL, now(), NULL, 'olc_cfg_select_option(array(\'true\', \'false\'),');

#PDF-Rechnung Konfiguration

ALTER TABLE orders ADD billing_invoice_number VARCHAR( 20 ) NOT NULL AFTER billing_address_format_id ;
ALTER TABLE orders ADD billing_invoice_date DATE NOT NULL AFTER billing_invoice_number ;

ALTER TABLE orders ADD delivery_packingslip_number VARCHAR( 20 ) NOT NULL AFTER delivery_address_format_id ;
ALTER TABLE orders ADD delivery_packingslip_date DATE NOT NULL AFTER delivery_packingslip_number;

ALTER TABLE orders ADD customers_order_reference VARCHAR( 32 ) AFTER customers_address_format_id;

INSERT IGNORE INTO configuration_group VALUES (787, 'PDF-Rechnungs-Layout', 'Einstellungen für das PDF-Rechnungs-Layout', '17', '1');

INSERT IGNORE INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
(NULL, 'PDF_INVOICE_ORDER_CONFIRMATION', '1', 787, 0, NULL, now(), NULL, NULL),
(NULL, 'PDF_INVOICE_MARK_COLOR', 'Black', 787, 1,  NULL, now(), NULL, 'cfg_display_color_sample('),
(NULL, 'PDF_INVOICE_MARK_COLOR_BG', 'Lightgrey', 787, 2,  NULL, now(), NULL, 'cfg_display_color_sample('),
(NULL, 'STORE_INVOICE_NUMBER', '12345', 787, 3, NULL, now(), NULL, NULL),
(NULL, 'STORE_PACKINGSLIP_NUMBER', '23456', 787, 4, NULL, now(), NULL, NULL);

INSERT INTO olc_configuration_group VALUES ('100', 'Firmen-Daten', 'Name, Anschrift, eMail, Bank usw.', '1', '1');

UPDATE configuration SET configuration_group_id='100', sort_order=1 WHERE configuration_key='STORE_NAME';
UPDATE configuration SET configuration_group_id='100', sort_order=2 WHERE configuration_key='STORE_OWNER';
UPDATE configuration SET configuration_group_id='100', sort_order=3 WHERE configuration_key='STORE_OWNER_EMAIL_ADDRESS';
UPDATE configuration SET configuration_group_id='100', sort_order=4 WHERE configuration_key='EMAIL_FROM';
UPDATE configuration SET configuration_group_id='100', sort_order=5 WHERE configuration_key='STORE_COUNTRY';
UPDATE configuration SET configuration_group_id='100', sort_order=6 WHERE configuration_key='STORE_ZONE';
UPDATE configuration SET configuration_group_id='100', sort_order=7 WHERE configuration_key='STORE_NAME_ADDRESS';
INSERT INTO configuration VALUES (NULL, 'STORE_BANK_NAME', '', 100, 8, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'STORE_BANK_BLZ', '', 100, 9, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'STORE_BANK_ACCOUNT', '', 100, 10, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'STORE_BANK_BIC', '', 100, 11, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'STORE_BANK_IBAN', '', 100, 12, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'STORE_USTID', '', 100, 13, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'STORE_TAXNR', '', 100, 14, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'STORE_REGISTER', '', 100, 15, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'STORE_REGISTER_NR', '', 100, 16, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'STORE_MANAGER', '', 100, 17, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'STORE_DIRECTOR', '', 100, 18, NULL, now(), NULL, NULL);

#PDF-Datasheet Konfiguration
INSERT IGNORE INTO configuration_group VALUES (800, 'PDF-Datenblatt-Generator', 'Konfiguriert den PDF-Datenblatt-Generator', '18', 1);

#PDF-Datasheet Konfiguration
INSERT IGNORE INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
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
(NULL, 'PDF_PAGE_BG_COLOR', 'ivory', 800, 24,  NULL, now(), NULL, 'cfg_display_color_sample('),
(NULL, 'PDF_HEADER_COLOR_TABLE', 'brown', 800, 25,  NULL, now(), NULL, 'cfg_display_color_sample('),
(NULL, 'PDF_HEADER_COLOR_TEXT', 'firebrick', 800, 26,  NULL, now(), NULL, 'cfg_display_color_sample('),
(NULL, 'PDF_BODY_COLOR_TEXT', 'brown', 800, 27,  NULL, now(), NULL, 'cfg_display_color_sample('),
(NULL, 'PDF_PRODUCT_NAME_COLOR_TABLE', 'Lightgrey', 800, 28,  NULL, now(), NULL, 'cfg_display_color_sample('),
(NULL, 'PDF_PRODUCT_NAME_COLOR_TEXT', 'white', 800, 29,  NULL, now(), NULL, 'cfg_display_color_sample('),
(NULL, 'PDF_FOOTER_CELL_BG_COLOR', 'silver', 800, 30,  NULL, now(), NULL, 'cfg_display_color_sample('),
(NULL, 'PDF_FOOTER_CELL_TEXT_COLOR', 'black', 800, 31,  NULL, now(), NULL, 'cfg_display_color_sample('),
(NULL, 'PDF_SPECIAL_PRICE_COLOR_TEXT', 'red', 800, 32,  NULL, now(), NULL, 'cfg_display_color_sample('),
(NULL, 'PDF_PAGE_WATERMARK_COLOR', 'aliceblue', 800, 33,  NULL, now(), NULL, 'cfg_display_color_sample('),
(NULL, 'PDF_OPTIONS_COLOR', 'black', 800, 34,  NULL, now(), NULL, 'cfg_display_color_sample('),
(NULL, 'PDF_OPTIONS_BG_COLOR', 'Lightgrey', 800, 35,  NULL, now(), NULL, 'cfg_display_color_sample(');

INSERT IGNORE INTO configuration VALUES (NULL, 'NO_TAX_RAISED', '0', 1, 29, NULL, now(), NULL, NULL);
INSERT IGNORE INTO configuration VALUES (NULL, 'USE_STICKY_CART', '1', 1, 31, NULL, now(), NULL, NULL);
INSERT IGNORE INTO configuration VALUES (NULL, 'SHOW_SHORT_CART_ONLY', '0', 1, 31, NULL, now(), NULL, NULL);
INSERT IGNORE INTO configuration VALUES (NULL, 'USE_PDF_INVOICE', '1', 1, 32, NULL, now(), NULL, NULL);
INSERT IGNORE INTO configuration VALUES (NULL, 'EMAIL_NEWSLETTER_PACAKGE_SIZE', '30',  12, 0, NULL, now(), NULL,NULL);
INSERT IGNORE INTO configuration VALUES (NULL, 'SEND_404_EMAIL', 'true', 12, 40, NULL, now(), NULL, 'cfg_select_option(array(\'true\', \'false\'),');
INSERT IGNORE INTO configuration VALUES (NULL, 'AFFILIATE_INCLUDE', '0', 1, 32, NULL, now(), NULL, NULL);
INSERT IGNORE INTO configuration VALUES (NULL, 'CAO_INCLUDE', '0', 1, 33, NULL, now(), NULL, NULL);
INSERT IGNORE INTO configuration VALUES (NULL, 'EASYSALES_INCLUDE', '0', 1, 34, NULL, now(), NULL, NULL);
INSERT IGNORE INTO configuration VALUES (NULL, 'CRON_JOBS_LIST', '', 1,  35,  NULL, now(), NULL, 'cfg_textarea(');
INSERT INTO configuration VALUES (NULL, 'VISITOR_PDF_CATALOGUE', 'false', 1, 36, NULL, now(), NULL, 'cfg_select_option(array(\'true\', \'false\'),');
INSERT IGNORE INTO configuration VALUES (NULL, 'GALLERY_PICTURES_PER_PAGE', '100', 1,  37,  NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'GALLERY_PICTURES_PER_LINE', '6', 1,  38,  NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'TRACKING_PRODUCTS_HISTORY_ENTRIES', '10', 1,  39,  NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'EBAY_FUNCTIONS_INCLUDE', 'false', 1,  42,  NULL, now(), NULL, 'cfg_select_option(array(\'true\', \'false\'),');

UPDATE configuration SET sort_order=13 WHERE configuration_key='SEARCH_ENGINE_FRIENDLY_URLS';
INSERT IGNORE INTO configuration VALUES (NULL, 'USE_SEO_EXTENDED', 'true',  16, 14, NULL, now(), NULL, 'cfg_select_option(array(\'true\', \'false\'),');
INSERT IGNORE INTO configuration VALUES (NULL, 'SEO_SEPARATOR', '-',  16, 15, NULL, now(), NULL, 'cfg_select_option(array(\'-\', \'/\'),');

INSERT IGNORE INTO configuration VALUES (NULL, 'SEO_TERMINATOR', '.htm',  16, 16, NULL, now(), NULL, 'cfg_select_option(array(\'.htm\', \'.html\'),');
INSERT IGNORE INTO configuration VALUES (NULL, 'SPIDER_FOOD_ROWS', '100',  16, 17, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'USE_SPAW', 'true', 17, 1, NULL, now(), NULL, 'cfg_select_option(array(\'true\', \'false\'),');

UPDATE configuration_group SET configuration_group_title = 'Mein Geschäft', configuration_group_description ='Allgemeine Informationen über mein Geschäft' WHERE configuration_group_id = 1;
INSERT INTO configuration_group VALUES ('100', 'Firmen-Daten', 'Name, Anschrift, eMail, Bank usw.', '1', '1');
UPDATE configuration_group SET configuration_group_title = 'Minimale Werte', configuration_group_description ='Die Minimal-Werte für Funktionen/Daten' WHERE configuration_group_id = 2;
UPDATE configuration_group SET configuration_group_title = 'Maximale Werte', configuration_group_description ='Die Maximal-Werte für Funktionen/Daten' WHERE configuration_group_id = 3;
UPDATE configuration_group SET configuration_group_title = 'Bild-Parameter', configuration_group_description ='Einstellungen für Bild-Parameter' WHERE configuration_group_id = 4;
UPDATE configuration_group SET configuration_group_title = 'Kunden-Details', configuration_group_description ='Kunden-Konten Konfiguration' WHERE configuration_group_id = 5;
UPDATE configuration_group SET configuration_group_title = 'Modul-Optionen', configuration_group_description ='Erweiterte Modul-Optionen' WHERE configuration_group_id = 6;
UPDATE configuration_group SET configuration_group_title = 'Versand-Optionen', configuration_group_description ='Verfügbare Versand-Optionen' WHERE configuration_group_id = 7;
UPDATE configuration_group SET configuration_group_title = 'Produkt-Listen-Optionen', configuration_group_description ='Konfiguration der Produkt-Listen-Optionen' WHERE configuration_group_id = 8;
UPDATE configuration_group SET configuration_group_title = 'Lager-Verwaltung', configuration_group_description ='Konfiguration der Lager-Optionen' WHERE configuration_group_id = 9;
UPDATE configuration_group SET configuration_group_title = 'Logging-Optionen', configuration_group_description ='Konfiguration der Logging-Optionen' WHERE configuration_group_id = 10;
UPDATE configuration_group SET configuration_group_title = 'Cache-Optionen', configuration_group_description ='Konfiguration der Cache-Optionen' WHERE configuration_group_id = 11;
UPDATE configuration_group SET configuration_group_title = 'E-Mail Optionen', configuration_group_description ='Optionen für den E-Mail Transport und HTML E-Mails' WHERE configuration_group_id = 12;
UPDATE configuration_group SET configuration_group_title = 'Download-Optionen', configuration_group_description ='Optionen für Download-Produkte' WHERE configuration_group_id = 13;
UPDATE configuration_group SET configuration_group_title = 'GZip Kompression', configuration_group_description ='Optionen für die GZip Kompression' WHERE configuration_group_id = 14;
UPDATE configuration_group SET configuration_group_title = 'Sessions', configuration_group_description ='Konfiguration der Session-Optionen' WHERE configuration_group_id = 15;
UPDATE configuration_group SET configuration_group_title = 'Meta-Tags und Suchmaschinen', configuration_group_description ='Konfiguration der Meta-Tags und Suchmaschinen-Optionen' WHERE configuration_group_id = 16;

#Menue/Templates Konfiguration
INSERT INTO configuration_group VALUES (795, 'Menüs und Templates', 'Einstellungen für Menüs und Templates', '19', '1');

INSERT INTO configuration VALUES (NULL, 'CURRENT_TEMPLATE', 'olc', 795, 10, NULL, now(), NULL, 'cfg_pull_down_template_sets(');
INSERT INTO configuration VALUES (NULL, 'NO_BOX_LAYOUT', 'false', 795, 20, NULL, now(), NULL, 'cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration VALUES (NULL, 'USE_UNIFIED_TEMPLATES', 'true', 795, 30, NULL, now(), NULL, 'cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration VALUES (NULL, 'CHECK_UNIFIED_BOXES', 'false', 795, 40, NULL, now(), NULL, 'cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration VALUES (NULL, 'OPEN_ALL_MENUE_LEVELS', 'false', 795,  50,  NULL, now(), NULL, 'cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration VALUES (NULL, 'SHOW_TAB_NAVIGATION', 'false', 795, 60, NULL, now(), NULL, 'cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration VALUES (NULL, 'USE_COOL_MENU', 'false', 795, 70, NULL, now(), NULL, 'cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration VALUES (NULL, 'USE_CSS_MENU', 'true', 795, 75, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration VALUES (NULL, 'PRODUCTS_LISTING_COLUMNS', '2', 795, 80, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'1\', \'2\'),');

#Screen-Layout Konfiguration
INSERT IGNORE INTO box_configuration (box_id, template, box_key_name, box_visible, box_sort_order, box_forced_visible, box_real_name, box_position_name, last_modified, date_added) VALUES
(NULL, 'olc', 'SHOW_ADMIN', 1, 1, 1, 'box_ADMIN', 'box_r_03', NULL, now()),
(NULL, 'olc', 'SHOW_CART', 1, 2, 1, 'box_CART', 'box_r_01', NULL, now()),
(NULL, 'olc', 'SHOW_CATEGORIES', 1, 3, 1, 'box_CATEGORIES', 'box_l_01', NULL, now()),
(NULL, 'olc', 'SHOW_CONTENT', 1, 4, 1, 'box_CONTENT', 'box_l_05', NULL, now()),
(NULL, 'olc', 'SHOW_INFOBOX', 1, 5, 1, 'box_INFOBOX', 'box_r_05', NULL, now()),
(NULL, 'olc', 'SHOW_LOGIN', 1, 6, 1, 'box_LOGIN', 'box_r_02', NULL, now()),
(NULL, 'olc', 'SHOW_MANUFACTURERS_INFO', 0, 7, 1, 'box_MANUFACTURERS_INFO', 'box_l_03', NULL, now()),
(NULL, 'olc', 'SHOW_MANUFACTURERS', 0, 8, 1, 'box_MANUFACTURERS', 'box_l_02', NULL, now()),
(NULL, 'olc', 'SHOW_SEARCH', 1, 9, 1, 'box_SEARCH', 'box_l_08', NULL, now()),
(NULL, 'olc', 'SHOW_CHANGE_SKIN', 1, 10, 0, NULL, NULL, NULL, now()),
(NULL, 'olc', 'SHOW_ADD_A_QUICKIE', 1, 11, 0, 'box_ADD_A_QUICKIE', 'box_l_04', NULL, now()),
(NULL, 'olc', 'SHOW_AFFILIATE', 1, 12, 0, 'box_AFFILIATE', 'box_l_13', NULL, now()),
(NULL, 'olc', 'SHOW_BESTSELLERS', 1, 13, 0, 'box_BESTSELLERS', 'box_r_06', NULL, now()),
(NULL, 'olc', 'SHOW_CENTER', 1, 14, 0, NULL, NULL, NULL, now()),
(NULL, 'olc', 'SHOW_CURRENCIES', 0, 15, 0, 'box_CURRENCIES', 'box_r_07', NULL, now()),
(NULL, 'olc', 'SHOW_ORDER_HISTORY', 1, 16, 0, 'box_ORDER_HISTORY', 'box_l_12', NULL, now()),
(NULL, 'olc', 'SHOW_INFORMATION', 1, 17, 0, 'box_INFORMATION', 'box_l_06', NULL, now()),
(NULL, 'olc', 'SHOW_LANGUAGES', 0, 18, 0, 'box_LANGUAGES', 'box_r_08', NULL, now()),
(NULL, 'olc', 'SHOW_LIVEHELP', 0, 19, 0, 'box_LIVEHELP', 'box_r_04', NULL, now()),
(NULL, 'olc', 'SHOW_NEWSLETTER', 1, 20, 0, 'box_NEWSLETTER', 'box_r_10', NULL, now()),
(NULL, 'olc', 'SHOW_LAST_VIEWED', 1, 22, 0, 'box_LAST_VIEWED', 'box_r_11', NULL, now()),
(NULL, 'olc', 'SHOW_NOTIFICATIONS', 1, 23, 0, 'box_NOTIFICATIONS', 'box_r_09', NULL, now()),
(NULL, 'olc', 'SHOW_REVIEWS', 1, 24, 0, 'box_REVIEWS', 'box_l_07', NULL, now()),
(NULL, 'olc', 'SHOW_SPECIALS', 1, 25, 0, 'box_SPECIALS', 'box_l_09', NULL, now()),
(NULL, 'olc', 'SHOW_TELL_FRIEND', 1, 26, 0, 'box_TELL_FRIEND', 'box_l_11', NULL, now()),
(NULL, 'olc', 'SHOW_WHATSNEW', 1, 27, 0, 'box_WHATSNEW', 'box_l_10', NULL, now()),
(NULL, 'olc', 'SHOW_TAB_NAVIGATION', 1, 28, 0, 'box_TAB_NAVIGATION', 'box_m_01', NULL, now()),
(NULL, 'olc', 'SHOW_PDF_CATALOG', 1, 29, 0, NULL, NULL, NULL, now()),
(NULL, 'olc', 'SHOW_GALLERY', 1, 30, 0, NULL, NULL, NULL, now());

# Insert some content to the VPE
INSERT IGNORE INTO products_vpe VALUES (1, 1, 'Piece');
INSERT IGNORE INTO products_vpe VALUES (2, 1, 'ml,Content');
INSERT IGNORE INTO products_vpe VALUES (3, 1, 'gr,Weight');
INSERT IGNORE INTO products_vpe VALUES (4, 1, 'gr,Content');
INSERT IGNORE INTO products_vpe VALUES (1, 2, 'Stück');
INSERT IGNORE INTO products_vpe VALUES (2, 2, 'ml,Inhalt');
INSERT IGNORE INTO products_vpe VALUES (3, 2, 'gr,Gewicht');
INSERT IGNORE INTO products_vpe VALUES (4, 2, 'gr,Inhalt');

INSERT IGNORE INTO whos_online_data VALUES ('0', '', '');

#
#	eBay Connector
#
DROP TABLE IF EXISTS auction_details;
CREATE TABLE auction_details (
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

DROP TABLE IF EXISTS auction_list;
CREATE TABLE auction_list (
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

DROP TABLE IF EXISTS auction_predefinition;
CREATE TABLE auction_predefinition (
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

DROP TABLE IF EXISTS ebay_auctiontype;
CREATE TABLE ebay_auctiontype (
	id int(11) NOT NULL,
	name varchar(255) NOT NULL,
	description varchar(255) NOT NULL,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS ebay_categories;
CREATE TABLE ebay_categories (
	myid bigint(20) NOT NULL auto_increment,
	name varchar(100) NOT NULL default '',
	id int(11) NOT NULL default '0',
	parentid int(11) NOT NULL default '0',
	leaf set('0','1') default '0',
	virtual set('0','1') NOT NULL default '',
	expired set('0','1') NOT NULL default '',
	PRIMARY KEY (myid)
);

DROP TABLE IF EXISTS ebay_config;
CREATE TABLE ebay_config (
	id int(11) NOT NULL auto_increment,
	category_version varchar(5) default NULL,
	category_update_time timestamp NULL default NULL,
	event_update_time timestamp NULL default NULL,
	transaction_update_time timestamp NULL default NULL,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS ebay_products;
CREATE TABLE ebay_products (
	products_id int(11) NOT NULL,
	auction_description varchar(255) NOT NULL,
	PRIMARY KEY (products_id)
);

INSERT INTO ebay_auctiontype (id,name,description) VALUES
(1,'Chinese','1 Artikel, Steigerungsauktion + optional Fixpreis'),
(2,'Dutch','Mehrere Artikel, Steigerungsauktion + optional Fixpreis'),
(6,'StoresFixedPrice','eBay-Shop'),
(9,'FixedPriceItem','1 oder mehrere Artikel, Fixpreis'),
(12,'Express','eBay Express')
;

INSERT INTO ebay_config (id,category_version,category_update_time,event_update_time,transaction_update_time) VALUES
(1,NULL,NULL,NULL,NULL);

#eBay Konfiguration
INSERT INTO configuration_group VALUES (790, 'eBay-Konnektor', 'Einstellungen für den eBay-Konnektor', '17', '1');

INSERT INTO configuration VALUES (NULL, 'EBAY_MEMBER_NAME', 'ihr_ebay_name', 790, 0, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'EBAY_REAL_SHOP_URL', 'http://www.mein-shop-server.de/', 790, 2, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'EBAY_EBAY_EXPRESS_ONLY', 'false', 790, 10, NULL, now(), NULL, 'cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration VALUES (NULL, 'EBAY_SHIPPING_MODULE', '', 790, 20, NULL, now(), NULL, 'cfg_pull_down_shipping_list(');
INSERT INTO configuration VALUES (NULL, 'EBAY_PAYPAL_EMAIL_ADDRESS', '', 790, 30, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'EBAY_TEST_MODE', 'true', 790, 40, NULL, now(), NULL, 'cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO configuration VALUES (NULL, 'EBAY_TEST_MODE_DEVID', '', 790, 42, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'EBAY_TEST_MODE_APPID', '', 790, 44, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'EBAY_TEST_MODE_CERTID', '', 790, 46, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'EBAY_TEST_MODE_TOKEN', '', 790, 48, NULL, now(), NULL, 'cfg_textarea(');

INSERT INTO configuration VALUES (NULL, 'EBAY_PRODUCTION_DEVID', '', 790, 52, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'EBAY_PRODUCTION_APPID', '', 790, 54, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'EBAY_PRODUCTION_CERTID', '', 790, 56, NULL, now(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'EBAY_PRODUCTION_TOKEN', '', 790, 58, NULL, now(), NULL, 'cfg_textarea(');

UPDATE `shipping_status` SET `shipping_status_image` = 'ampel_gruen.gif' WHERE `shipping_status_id` =1 AND `language_id` =1 ;
UPDATE `shipping_status` SET `shipping_status_image` = 'ampel_gruen.gif' WHERE `shipping_status_id` =1 AND `language_id` =2 ;
UPDATE `shipping_status` SET `shipping_status_image` = 'ampel_gelb.gif' WHERE `shipping_status_id` =2 AND `language_id` =1 ;
UPDATE `shipping_status` SET `shipping_status_image` = 'ampel_gelb.gif' WHERE `shipping_status_id` =2 AND `language_id` =2 ;
UPDATE `shipping_status` SET `shipping_status_image` = 'ampel_rot.gif' WHERE `shipping_status_id` =3 AND `language_id` =1 ;
UPDATE `shipping_status` SET `shipping_status_image` = 'ampel_rot.gif' WHERE `shipping_status_id` =3 AND `language_id` =2 ;

