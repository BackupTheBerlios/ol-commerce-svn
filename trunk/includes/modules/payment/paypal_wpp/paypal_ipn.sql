#SET SESSION sql_mode='';
#
#!!!!!Für MySQL 5 das Zeichen '#' in der 1. Zeile entfernen!!!!!
#
#
# Table structures for PayPal IPN
#
#
# Table structure for table `orders_session_info`
#

DROP TABLE IF EXISTS olc_orders_session_info;
CREATE TABLE olc_orders_session_info (
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
  PRIMARY KEY  (txn_signature,orders_id),
  KEY idx_orders_session_info_txn_signature (txn_signature)
);

#
# Table structure for table `paypal`
#

DROP TABLE IF EXISTS olc_paypal;
CREATE TABLE olc_paypal (
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
  PRIMARY KEY  (paypal_id,txn_id),
  KEY idx_paypal_paypal_id (paypal_id)
);

# Table structure for table paypal_payment_status_history
#

DROP TABLE IF EXISTS olc_paypal_payment_status_history;
CREATE TABLE IF NOT EXISTS olc_paypal_payment_status_history (
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

DROP TABLE IF EXISTS olc_paypal_auction;
CREATE TABLE IF NOT EXISTS olc_paypal_auction (
  paypal_id int(11) NOT NULL default '0',
  item_number varchar(96) NOT NULL default '',
  auction_buyer_id varchar(96) NOT NULL default '',
  auction_multi_item tinyint(4) NOT NULL default '0',
  auction_closing_date datetime NOT NULL default '0000-00-00 00:00:00',
  is_old int(1) NOT NULL default '0',
  PRIMARY KEY  (paypal_id,item_number)
);

ALTER TABLE `olc_customers` ADD `customers_paypal_payerid` VARCHAR( 20 ) AFTER `customers_newsletter_mode`;
ALTER TABLE `olc_customers` ADD `customers_paypal_ec` TINYINT (1) UNSIGNED DEFAULT '0' NOT NULL AFTER `customers_paypal_payerid`;
ALTER TABLE `olc_orders` ADD payment_id INT( 11 ) DEFAULT '0' NOT NULL;
ALTER TABLE `olc_orders_products_attributes` ADD products_options_id INT( 11 ) DEFAULT '0' NOT NULL;
ALTER TABLE `olc_orders_products_attributes` ADD products_options_values_id INT( 11 ) DEFAULT '0' NOT NULL;

