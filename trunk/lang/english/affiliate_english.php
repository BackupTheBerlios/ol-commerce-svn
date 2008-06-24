<?php
/*------------------------------------------------------------------------------
$Id: affiliate_english.php,v 2.0.0 2006/12/14 05:48:23 gswkaiser Exp $

OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

modified by http://www.ol-commerce.de, http://www.seifenparadies.de


Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------
based on:
(c) 2003 OSC-Affiliate (affiliate_german.php, v 1.12 2003/08/18);
http://oscaffiliate.sourceforge.net/

Contribution based on:

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2002 - 2003 osCommerce
Copyright (c) 2003 netz-designer
Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

Copyright (c) 2002 - 2003 osCommerce

Released under the GNU General Public License
---------------------------------------------------------------------------*/

define('BOX_INFORMATION_AFFILIATE', 'Affiliate Program');
define('BOX_AFFILIATE_INFO', 'Program Information');
define('BOX_AFFILIATE_SUMMARY', 'Affiliate Summary');
define('BOX_AFFILIATE_ACCOUNT', 'Edit Affiliate Account');
define('BOX_AFFILIATE_CLICKRATE', 'Clickthrough Report');
define('BOX_AFFILIATE_PAYMENT', 'Payment Report');
define('BOX_AFFILIATE_SALES', 'Sales Report');
define('BOX_AFFILIATE_BANNERS', 'Affiliate Banner');
define('BOX_AFFILIATE_CONTACT', 'Contact Us');
define('BOX_AFFILIATE_FAQ', 'FAQ');
define('BOX_AFFILIATE_LOGIN', 'Affiliate Login');
define('BOX_AFFILIATE_LOGOUT', 'Affiliate Log Out');

define('ENTRY_AFFILIATE_ACCEPT_AGB', 'Check here to indicate that you have read and agree to the <a target="_new" href="%s">Associates Terms & Conditions</a>.');
define('ENTRY_AFFILIATE_AGB_ERROR', '&nbsp;<small><font color="#FF0000">You must accept our Associates Terms & Conditions</font></small>');
define('ENTRY_AFFILIATE_PAYMENT_CHECK_TEXT', '');
define('ENTRY_AFFILIATE_PAYMENT_CHECK_ERROR', '&nbsp;<small><font color="#FF0000">required</font></small>');
define('ENTRY_AFFILIATE_PAYMENT_PAYPAL_TEXT', '');
define('ENTRY_AFFILIATE_PAYMENT_PAYPAL_ERROR', '&nbsp;<small><font color="#FF0000">required</font></small>');
define('ENTRY_AFFILIATE_PAYMENT_BANK_NAME_TEXT', '');
define('ENTRY_AFFILIATE_PAYMENT_BANK_NAME_ERROR', '&nbsp;<small><font color="#FF0000">required</font></small>');
define('ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME_TEXT', '');
define('ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME_ERROR', '&nbsp;<small><font color="#FF0000">required</font></small>');
define('ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER_TEXT', '');
define('ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER_ERROR', '&nbsp;<small><font color="#FF0000">required</font></small>');
define('ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER_TEXT', '');
define('ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER_ERROR', '&nbsp;<small><font color="#FF0000">required</font></small>');
define('ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE_TEXT', '');
define('ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE_ERROR', '&nbsp;<small><font color="#FF0000">required</font></small>');
define('ENTRY_AFFILIATE_COMPANY_TEXT', '');
define('ENTRY_AFFILIATE_COMPANY_ERROR', '&nbsp;<small><font color="#FF0000">required</font></small>');
define('ENTRY_AFFILIATE_COMPANY_TAXID_TEXT', '');
define('ENTRY_AFFILIATE_COMPANY_TAXID_ERROR', '&nbsp;<small><font color="#FF0000">required</font></small>');
define('ENTRY_AFFILIATE_HOMEPAGE_TEXT', '&nbsp;<small><font color="#000000"> (http://)</font></small>');
define('ENTRY_AFFILIATE_HOMEPAGE_ERROR', '&nbsp;<small><font color="#FF0000">required (http://)</font></small>');

define('TEXT_AFFILIATE_PERIOD', 'Period: ');
define('TEXT_AFFILIATE_STATUS', 'Status: ');
define('TEXT_AFFILIATE_LEVEL', 'Level: ');
define('TEXT_AFFILIATE_ALL_PERIODS', 'All Periods');
define('TEXT_AFFILIATE_ALL_STATUS', 'All Status');
define('TEXT_AFFILIATE_ALL_LEVELS', 'All Levels');
define('TEXT_AFFILIATE_PERSONAL_LEVEL', 'Personal');
define('TEXT_AFFILIATE_LEVEL_SUFFIX', 'Level ');
define('TEXT_AFFILIATE_NAME', 'Bannername: ');
define('TEXT_AFFILIATE_INFO', 'Just copy the HTML Code and insert it on your website.');
define('TEXT_DISPLAY_NUMBER_OF_CLICKS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Clicks)');
define('TEXT_DISPLAY_NUMBER_OF_SALES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Sales)');
define('TEXT_DISPLAY_NUMBER_OF_PAYMENTS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Payments)');
define('TEXT_DELETED_ORDER_BY_ADMIN', 'Deleted (Admin)');
define('TEXT_AFFILIATE_PERSONAL_LEVEL_SHORT', 'Pers.');
define('TEXT_COMMISSION_LEVEL_TIER', 'Level: ');
define('TEXT_COMMISSION_RATE_TIER', 'Commission Rate: ');
define('TEXT_COMMISSION_TIER_COUNT', 'Sales: ');
define('TEXT_COMMISSION_TIER_TOTAL', 'Amount: ');
define('TEXT_COMMISSION_TIER', 'Commission: ');

define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - New Password for Affiliate Program');
define('EMAIL_PASSWORD_REMINDER_BODY', 'A new affiliate password was requested from ' . $REMOTE_ADDR . '.' . "\n\n" . 'Your new affiliate password to \'' . STORE_NAME . '\' is:' . "\n\n" . '   %s' . "\n\n");

define('MAIL_AFFILIATE_SUBJECT', 'Welcome to the Affiliate Program of ' . STORE_NAME);
define('MAIL_AFFILIATE_HEADER', 'Dear Affiliate Partner

Thank you for your registration at our affiliate program.

Your account information:
**************************

');
define('MAIL_AFFILIATE_ID', 'Your Affiliate-id is: ');
define('MAIL_AFFILIATE_USERNAME', 'Your Username is: ');
define('MAIL_AFFILIATE_PASSWORD', 'Your Password is: ');
define('MAIL_AFFILIATE_LINK', 'Login here: ');
define('MAIL_AFFILIATE_FOOTER', 'Have fun earning referal fees!

Your Affiliate Team');

define('EMAIL_SUBJECT', 'Affiliate Program');

define('NAVBAR_TITLE', 'Affiliate Program');
define('NAVBAR_TITLE_AFFILIATE', 'Login');
define('NAVBAR_TITLE_BANNERS', 'Banner');
define('NAVBAR_TITLE_CLICKS', 'Clicks');
define('NAVBAR_TITLE_CONTACT', 'Contakt');
define('NAVBAR_TITLE_DETAILS', 'Edit account');
define('NAVBAR_TITLE_DETAILS_OK', 'Datas changed');
define('NAVBAR_TITLE_FAQ', 'FAQ');
define('NAVBAR_TITLE_INFO', 'Information');
define('NAVBAR_TITLE_LOGOUT', 'Logout');
define('NAVBAR_TITLE_PASSWORD_FORGOTTEN', 'Password forgotten');
define('NAVBAR_TITLE_PAYMENT', 'Payment');
define('NAVBAR_TITLE_SALES', 'Sales');
define('NAVBAR_TITLE_SIGNUP', 'Signup');
define('NAVBAR_TITLESIGNUP_OK', 'Signed up');
define('NAVBAR_TITLE_SUMMARY', 'Summary');
define('NAVBAR_TITLE_TERMS', 'Terms and Conditions');

define('IMAGE_BANNERS', 'Banners');
define('IMAGE_CLICKTHROUGHS', 'Clickthrough Report');
define('IMAGE_SALES', 'Sales Report');
?>
