<?php
/* -----------------------------------------------------------------------------------------
$Id: english.php,v 2.0.0 2006/12/14 05:48:25 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(german.php,v 1.119 2003/05/19); www.oscommerce.com
(c) 2003	    nextcommerce (german.php,v 1.25 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// look in your $PATH_LOCALE/locale directory for available locales..
// on RedHat try 'de_DE'
// on FreeBSD try 'de_DE.ISO_8859-15'
// on Windows try 'de' or 'German'
@setlocale(LC_TIME, 'de_DE.ISO_8859-15');
setlocale(LC_NUMERIC,'C');			//Do  n o t (repeat:  n o t) change this!!! W. Kaiser
define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

// page title
define('TITLE', STORE_NAME);
////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
if (!function_exists('olc_date_raw'))
{
	function olc_date_raw($date, $reverse = false) {
		if ($reverse) {
			return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
		} else {
			return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
		}
	}
}
// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'EUR');

// Global entries for the <html> tag
define('HTML_PARAMS','dir="LTR" lang="de"');

define('HEADER_TITLE_TOP', 'Main page');
define('HEADER_TITLE_CATALOG', 'Catalog');

// text for gender
define('MALE', 'Mr.');
define('FEMALE', 'Mrs.');
define('MALE_ADDRESS', 'Mr.');
define('FEMALE_ADDRESS', 'Mrs.');

// text for date of birth example
define('DOB_FORMAT_STRING', 'DD.MM.YYYY');

// text for quick purchase
define('IMAGE_BUTTON_ADD_QUICK', 'Quick Purchase!');
define('BOX_ADD_PRODUCT_ID_TEXT', 'Please enter the product-id from our catalog.');

// text for gift voucher redeeming
define('IMAGE_REDEEM_GIFT','Redeem Gift Voucher!');

define('BOX_TITLE_STATISTICS','Statistic');
define('BOX_TITLE_ORDERS_STATUS','Order-Status');
define('BOX_ENTRY_CUSTOMERS','Customers');
define('BOX_ENTRY_PRODUCTS','Products');
define('BOX_ENTRY_REVIEWS','Reviews');

// quick_find box text in includes/boxes/quick_find.php
define('BOX_SEARCH_TEXT', 'Use keywords to find a special product.');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Advanced Search');

// reviews box text in includes/boxes/reviews.php
define('BOX_REVIEWS_WRITE_REVIEW', 'Review the product <b>%s</b>');
define('BOX_REVIEWS_NO_REVIEWS', 'There aren´t any reviews yet');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s of 5 stars!');

// shopping_cart box text in includes/boxes/shopping_cart.php
define('BOX_SHOPPING_CART_EMPTY', '0 Products');

// notifications box text in includes/boxes/products_notifications.php
define('BOX_NOTIFICATIONS_NOTIFY', 'Send me news about this product <b>%s</b>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Stop sending me news about this product <b>%s</b>');

// manufacturer box text
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Homepage');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'More Products');

define('BOX_HEADING_ADD_PRODUCT_ID','Add to cart!');
define('BOX_HEADING_SEARCH','Search!');

define('BOX_INFORMATION_CONTACT', 'Contact');
define('BOX_PDF_EXPORT', 'Create PDF-Catalogue');
define('BOX_XXC_IMPORT', 'Import xxCommerce data');

define('PRINT_DATASHEET','Print Datasheet');
define('PDF_DATASHEET', 'PDF-Format');
define('PDF_FORMAT',LPAREN.PDF_DATASHEET.RPAREN);
define('PDF_DATASHEET_TITLE', 'Create datasheet in '.PDF_DATASHEET);

// tell a friend box text in includes/boxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Recommend To A Friend');
define('BOX_TELL_A_FRIEND_TEXT', 'Recommend this product simply by eMail.');
define('BOX_TELL_A_FRIEND_TEXT_SITE', 'Recommend our shop simply by eMail.');
define('CHANGE_SKIN_TEXT','TITLE="Here you can change the shops\' design">Change shop-design');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Choose please');
define('TYPE_BELOW', 'Fill in below please');

// javascript messages
define('JS_ERROR', 'Missing necessary information!\nPlease fill in correctly.\n\n');

define('JS_REVIEW_TEXT', '* The text must consist at least of ' . REVIEW_TEXT_MIN_LENGTH . ' alphabetic characters..\n');
define('JS_REVIEW_RATING', '* Enter your review.\n');
define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Please choose a method of payment for your order.\n');
define('JS_ERROR_SUBMITTED', 'This page has already been confirmed. Please click okay and wait until the process has finished.');
define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Please choose a method of payment for your order.');
define('CATEGORY_COMPANY', 'Company data');
define('CATEGORY_PERSONAL', 'Your personal data');
define('CATEGORY_ADDRESS', 'Your address');
define('CATEGORY_CONTACT', 'Your contact information');
define('CATEGORY_OPTIONS', 'Options');
define('CATEGORY_PASSWORD', 'Your password');

define('ENTRY_COMPANY', 'Company name:');
define('ENTRY_COMPANY_ERROR', EMPTY_STRING);
define('ENTRY_COMPANY_TEXT', EMPTY_STRING);
define('ENTRY_GENDER', 'Mr. / Mrs. / Title:');
define('ENTRY_GENDER_ERROR', 'Please select your gender.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'First name:');
$characters=' characters.';
$must_consist_of=' must consist of at least ';
define('ENTRY_FIRST_NAME_ERROR', 'Your first name'.$must_consist_of . ENTRY_FIRST_NAME_MIN_LENGTH . $characters);
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Last name:');
define('ENTRY_LAST_NAME_ERROR', 'Your last name'.$must_consist_of . ENTRY_LAST_NAME_MIN_LENGTH . $characters);
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Date of birth:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Your date of birth has to be entered in the following form DD.MM.YYYY (e.g. 21.05.1970) ');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (e.g. 21.05.1970)');
define('ENTRY_EMAIL_ADDRESS', 'eMail-address:');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Your eMail-address must consist of at least  ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . $characters);
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'The eMail-address your entered is incorrect - please check it');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'The eMail-address you entered already existst in our datebase - please login with your existing account or create a new account with a new eMail-address .');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', 'Street/Nr.:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Your Street/Nr'.$must_consist_of . ENTRY_STREET_ADDRESS_MIN_LENGTH . $characters);
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'District:');
define('ENTRY_SUBURB_ERROR', EMPTY_STRING);
define('ENTRY_SUBURB_TEXT', EMPTY_STRING);
define('ENTRY_POST_CODE', 'ZIP Code:');
define('ENTRY_POST_CODE_ERROR', 'Your ZIP Code'.$must_consist_of . ENTRY_POSTCODE_MIN_LENGTH . $characters);
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'City:');
define('ENTRY_CITY_ERROR', 'Your city'.$must_consist_of . ENTRY_CITY_MIN_LENGTH . $characters);
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'State:');
define('ENTRY_STATE_ERROR', 'Your state'.$must_consist_of . ENTRY_STATE_MIN_LENGTH . $characters);
define('ENTRY_STATE_ERROR_SELECT', 'Please select your state out of the list.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY', 'Country:');
define('ENTRY_COUNTRY_ERROR', 'Please select your country out of the list.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Telephone number:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Your Telephone number'.$must_consist_of . ENTRY_TELEPHONE_MIN_LENGTH . $characters);
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Telefax number:');
define('ENTRY_FAX_NUMBER_ERROR', EMPTY_STRING);
define('ENTRY_FAX_NUMBER_TEXT', EMPTY_STRING);
define('ENTRY_NEWSLETTER', 'Newsletter:');
define('ENTRY_NEWSLETTER_TEXT', EMPTY_STRING);
define('ENTRY_NEWSLETTER_YES', 'subscribed to');
define('ENTRY_NEWSLETTER_NO', 'not subscribed to');
define('ENTRY_NEWSLETTER_ERROR', EMPTY_STRING);
define('ENTRY_PASSWORD', 'Password:');
define('ENTRY_PASSWORD_ERROR', 'Your password'.$must_consist_of . ENTRY_PASSWORD_MIN_LENGTH . $characters);
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Your passwords do not match.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION', 'Confirmation:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Current password:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Your password'.$must_consist_of . ENTRY_PASSWORD_MIN_LENGTH . $characters);
define('ENTRY_PASSWORD_NEW', 'New password:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Your new password'.$must_consist_of . ENTRY_PASSWORD_MIN_LENGTH . $characters);
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Your passwords do not match.');
define('PASSWORD_HIDDEN', '--HIDDEN--');

//Popup Window
define('TEXT_CLOSE_WINDOW', 'Close Window');
define('TEXT_CLICK_TO_ENLARGE','Click to enlarge');

//COUPON POPUP

//define('TEXT_CLOSE_WINDOW', 'Close Window [x]');
define('TEXT_COUPON_HELP_HEADER', 'Congratulations, you have redeemed a Discount Coupon.');
define('TEXT_COUPON_HELP_NAME', '<br/><br />Coupon Name : %s');
define('TEXT_COUPON_HELP_FIXED', '<br/><br />The coupon is worth %s discount against your order');
define('TEXT_COUPON_HELP_MINORDER', '<br/><br />You need to spend %s to use this coupon');
define('TEXT_COUPON_HELP_FREESHIP', '<br/><br />This coupon gives you free shipping on your order');
define('TEXT_COUPON_HELP_DESC', '<br/><br />Coupon Description : %s');
define('TEXT_COUPON_HELP_DATE', '<br/><br />The coupon is valid between %s and %s');
define('TEXT_COUPON_HELP_RESTRICT', '<br/><br />Product / Category Restrictions');
define('TEXT_COUPON_HELP_CATEGORIES', 'Category');
define('TEXT_COUPON_HELP_PRODUCTS', 'Product');

// constants for use in olc_prev_next_display function
define('TEXT_RESULT_PAGE', 'Pages:');
$show='Show <b>%d</b> to <b>%d</b> (of in total <b>%d</b> ';
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', $show . 'products)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', $show . 'orders)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', $show . 'reviews)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', $show . 'new products)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', $show . 'special offers)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_VPE', $show . 'packaging units)');
define('TEXT_FURTHER_INFO','Please "click" for further info');

define('PREVNEXT_TITLE_FIRST_PAGE', 'first page');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'previous page');
define('PREVNEXT_TITLE_NEXT_PAGE', 'next page');
define('PREVNEXT_TITLE_LAST_PAGE', 'last page');
define('PREVNEXT_TITLE_PAGE_NO', 'page %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Previous %d pages');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Next %d pages');
define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;FIRST');
define('PREVNEXT_BUTTON_PREV', '[&lt;&lt;&nbsp;previous]');
define('PREVNEXT_BUTTON_NEXT', '[next&nbsp;&gt;&gt;]');
define('PREVNEXT_BUTTON_LAST', 'LAST&gt;&gt;');

define('IMAGE_BUTTON_ADD_ADDRESS', 'New address');
define('IMAGE_BUTTON_ADDRESS_BOOK', 'Address book');
define('IMAGE_BUTTON_BACK', 'Back');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Change address');
define('IMAGE_BUTTON_CHECKOUT', 'Checkout');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Confirm order');
define('IMAGE_BUTTON_CONTINUE', 'Next');
define('IMAGE_BUTTON_CONTINUE_SHOPPING', 'Continue purchase');
define('IMAGE_BUTTON_DELETE', 'Delete');
define('IMAGE_BUTTON_EDIT_ACCOUNT', 'Change dates');
define('IMAGE_BUTTON_HISTORY', 'Order history');
define('IMAGE_BUTTON_LOGIN', 'Login');
define('IMAGE_BUTTON_IN_CART', 'Into the cart');
define('IMAGE_BUTTON_NOTIFICATIONS', 'Notifications');
define('IMAGE_BUTTON_QUICK_FIND', 'Express search');
define('IMAGE_BUTTON_REMOVE_NOTIFICATIONS', 'Delete Notifications');
define('IMAGE_BUTTON_REVIEWS', 'Reviews');
define('IMAGE_BUTTON_SEARCH', 'Search');
define('IMAGE_BUTTON_SHIPPING_OPTIONS', 'Shipping options');
define('IMAGE_BUTTON_TELL_A_FRIEND', 'Recommend');
define('IMAGE_BUTTON_UPDATE', 'Update');
define('IMAGE_BUTTON_UPDATE_CART', 'Update shopping cart');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Write Evaluation');
define('IMAGE_BUTTON_CANCEL','Cancel');

define('SMALL_IMAGE_BUTTON_DELETE', 'Delete');
define('SMALL_IMAGE_BUTTON_EDIT', 'Edit');
define('SMALL_IMAGE_BUTTON_VIEW', 'View');

define('ICON_ARROW_RIGHT', 'Show more');
define('ICON_CART', 'Into the cart');
define('ICON_SUCCESS', 'Success');
define('ICON_WARNING', 'Warning');

define('TEXT_GREETING_PERSONAL', 'Nice to encounte you again <span class="greetUser">%s!</span> Would you like to visit our <a href="%s"><u>new products</u></a> ?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>If you are not %s , please  <a href="%s"><u>login</u></a>  with your account.</small>');
define('TEXT_GREETING_GUEST', 'Cordially welcome  <span class="greetUser">visitor!</span> Would you like to <a href="%s"><u>login</u></a>? Or would you like to create an <a href="%s"><u>account</u></a> ?');

define('TEXT_SORT_PRODUCTS', 'Sorting of the items is ');
define('TEXT_DESCENDINGLY', 'descending');
define('TEXT_ASCENDINGLY', 'ascending');
define('TEXT_BY', ' after ');

define('TEXT_REVIEW_BY', 'from %s');
define('TEXT_REVIEW_WORD_COUNT', '%s words');
define('TEXT_REVIEW_RATING', 'Review: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Date added: %s');
define('TEXT_NO_REVIEWS', 'There aren´t any reviews yet.');

define('TEXT_NO_NEW_PRODUCTS', 'There are no new products at the moment.');

define('TEXT_UNKNOWN_TAX_RATE', 'Unknown tax rate');

define('TEXT_REQUIRED', '<span class="errorText">required</span>');

define('ERROR_TEP_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>Error:</small> Your mail can´t be send by your SMTP server. Please control the attitudes in the php.ini file and make necessary changes!</b></font>');
define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warning: The installation directory is still available onto: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/olc_installer. Please delete this directory in case of security!');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Warning: OL-Commerce is able to write into the configuration directory: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. That represents a possible safety hazard - please correct the user access rights for this directory!');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warning: Directory for sesssions doesn´t exist: ' . olc_session_save_path() . '. Sessions will not work until this directory has been created!');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warning: OL-Commerce is not abe to write into the session directory: ' . olc_session_save_path() . '. DSessions will not work until the user access rights for this directory have benn changed!');
define('WARNING_SESSION_AUTO_START', 'Warning: session.auto_start is activated (enabled) - Please deactivate (disabled) this PHP feature in php.ini and restart your webserver!');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warning: Directory for article download doesn´t exist: ' . DIR_FS_DOWNLOAD . '. This feature will not work until this directory has been created!');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'The "valid to" date ist invalid.<br/>Please correct your information.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'The "Credit card number ", you entered, is invalid.<br/>Please correct your information.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'The first 4 signs of your Credit Card are: %s<br/>If this information is correct, your type of card is not accepted.<br/>Please correct your information.');

define('TEXT_PRICE_SINGLE','Single price');
define('TEXT_PRICE_TOTAL','Total price');

define('GENERAL_DISCLAIMER','Errors and modifications excepted');
define('PRICE_DISCLAIMER_SHIPMENT_COST','Shipping cost (from '.$minimum_ship_cost.RPAREN);

$price_info=FILENAME_CONTENT.'?coID=1';
if (USE_AJAX)
{
	$price_info="javascript:ShowInfo('".$price_info."&amp;pop_up=true','')";
}
define('PRICE_DISCLAIMER_COMMON',
' plus <a href="'.$price_info.'" title="Detailed information on shipping costs you will find here with one "Click"!><u>'.
PRICE_DISCLAIMER_SHIPMENT_COST.'</u><br/>(Please "Click" for detailed Information!)</a>.');

//Wenn Sie als Kleinunternehmer §19 UStG im Shop keine MwSt. erheben,
//"//" vor der beiden nächsten Anweisungen entfernen!!!
if (!defined('NO_TAX_RAISED'))
{
	define('NO_TAX_RAISED',false);
}
$price_disclaimer_shipment_cost=' plus '.PRICE_DISCLAIMER_SHIPMENT_COST;
$price=' <br/>Price';
$prices=' <br/>Prices';
if (NO_TAX_RAISED)
{
	define('BOX_LOGINBOX_NO_TAX_TEXT','According to §19 german UStG no VAT is raised.');
	define('PRICE_DISCLAIMER_NO_TAX',BOX_LOGINBOX_NO_TAX_TEXT_TEXT.$price.PRICE_DISCLAIMER_COMMON);
	define('PRICES_DISCLAIMER_NO_TAX',BOX_LOGINBOX_NO_TAX_TEXT_TEXT.$prices.PRICE_DISCLAIMER_COMMON);
	define('PRICE_DISCLAIMER_NO_TAX_NO_LINK',BOX_LOGINBOX_NO_TAX_TEXT.$price.$price_disclaimer_shipment_cost);
}
else
{
	$s=' and'.PRICE_DISCLAIMER_COMMON;
	$price_incl_text='Price <b>incl.</b> %s VAT.';
	$price_excl_text='Price <b>excl.</b> VAT.';
	define('PRICE_DISCLAIMER_INCL',$price_incl_text.$s);
	define('PRICE_DISCLAIMER_EXCL',$price_excl_text.$s);

	$all_prices='All prices <b>#.</b> VAT'.PRICE_DISCLAIMER_COMMON;
	define('PRICES_DISCLAIMER_INCL',str_replace(HASH,'incl',$all_prices));
	define('PRICES_DISCLAIMER_EXCL',str_replace(HASH,'excl',$all_prices));

	define('PRICE_DISCLAIMER_NO_TAX_NO_LINK',BOX_LOGINBOX_NO_TAX_TEXT_TEXT.$price.$price_disclaimer_shipment_cost);
	$s=' and '.$price_disclaimer_shipment_cost;
	define('PRICE_DISCLAIMER_INCL_NO_LINK',$price_incl_text.$s);
	define('PRICE_DISCLAIMER_INCL_GENERAL_NO_LINK',BOX_LOGINBOX_INCL.$s);
	define('PRICE_DISCLAIMER_EXCL_NO_LINK',$price_excl_text.$s);
	define('TAX_DISCLAIMER_EU','Intra-community shipment');
}
define('PICTURE_DISCLAIMER','Pict. similiar');
//W. Kaiser - AJAX

/*

The following copyright announcement can only be
appropriately modified or removed if the layout of
the site theme has been modified to distinguish
itself from the default osCommerce-copyrighted
theme.

Please leave this comment intact together with the
following copyright announcement.

Copyright announcement changed due to the permissions
from LG Hamburg from 28th February 2003 / AZ 308 O 70/03
*/
define('FOOTER_TEXT_BODY', 'Copyright &copy; 2004 <a href="http://www.ol-commerce.com, http://www.seifenparadies.de" target="_blank">OL-Commerce </a><br/>Powered by <a href="http://www.ol-commerce.com, http://www.seifenparadies.de" target="_blank">OL-Commerce </a>');

//  conditions check

define('ERROR_CONDITIONS_NOT_ACCEPTED', 'If you don´t accept our General Business Conditions, we are not able to accept your order!');

define('SUB_TITLE_OT_DISCOUNT','Discount:');
define('SUB_TITLE_SUB_NEW','Total:');

define('NOT_ALLOWED_TO_SEE_PRICES','You don´t have the permission to see the prices ');
define('NOT_ALLOWED_TO_ADD_TO_CART','You don´t have the permission to put items into the shopping cart');

define('BOX_LOGINBOX_HEADING', 'Welcome back!');
define('BOX_LOGINBOX_EMAIL', 'eMail-address:');
define('BOX_LOGINBOX_PASSWORD', 'Password:');
define('IMAGE_BUTTON_LOGIN', 'Login');
define('BOX_ACCOUNTINFORMATION_HEADING','Information');

define('BOX_LOGINBOX_STATUS','Customer group:');
define('BOX_LOGINBOX_INCL','All prices incl. VAT');
define('BOX_LOGINBOX_EXCL','All prices excl. VAT');
define('TAX_ADD_TAX','incl. ');
define('TAX_NO_TAX','plus ');

define('BOX_LOGINBOX_DISCOUNT','Product discount');
define('BOX_LOGINBOX_DISCOUNT_TEXT','Discount');
define('BOX_LOGINBOX_DISCOUNT_OT',EMPTY_STRING);

define('NOT_ALLOWED_TO_SEE_PRICES_TEXT','You don´t have the permission to see the prices, please create an account.');
define('BOX_LOGINBOX_ACCOUNT',HTML_BR.'With the "<b>Your account</b>" button, you can manage your data, view orders and more.');

define('TEXT_DOWNLOAD','Download');
define('TEXT_VIEW','View');

define('TEXT_BUY', 'Put 1 x \'');
define('TEXT_NOW', '\' into cart');
define('TEXT_GUEST','Visitor');
define('TEXT_NO_PURCHASES', 'You have not yet made an order.');


// Warnings
define('SUCCESS_ACCOUNT_UPDATED', 'Your account has been updated successfully.');
define('SUCCESS_NEWSLETTER_UPDATED', 'Your newsletter subscription has been updated successfully!');
define('SUCCESS_NOTIFICATIONS_UPDATED', 'Your product notifications have been updated successfully!');
define('SUCCESS_PASSWORD_UPDATED', 'Your password has been changed successfully!');
define('ERROR_CURRENT_PASSWORD_NOT_MATCHING', 'The entered password does not match within the stored password. Please try again.');
define('TEXT_MAXIMUM_ENTRIES', '<font color="#ff0000"><b>Reference:</b></font> You are able to choose out of %s entries in you address book!');
define('SUCCESS_ADDRESS_BOOK_ENTRY_INSERTED', 'The new address book entry has been inserted successfully.');
define('SUCCESS_ADDRESS_BOOK_ENTRY_DELETED', 'The selected address book entry has been extinguished successfully.');
define('SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED', 'Your address book has been updated sucessfully!');
define('WARNING_PRIMARY_ADDRESS_DELETION', 'The standard postal address can not be deleted. Please select another standard postal address first. Than the entry can be deleted.');
define('ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY', 'This address book entry is not available.');
define('ERROR_ADDRESS_BOOK_FULL', 'Your address book can not include any further postal addresses. Please delete an address which is not longer used. Than a new entry can be made.');

//Advanced Search
define('ENTRY_CATEGORIES', 'Categories:');
define('ENTRY_INCLUDE_SUBCATEGORIES', 'Include subcategories');
define('ENTRY_MANUFACTURERS', 'Manufacturer:');
define('ENTRY_PRICE_FROM', 'Price over:');
define('ENTRY_PRICE_TO', 'Price up to:');
define('ENTRY_DATE_FROM','Publication date from:');
define('ENTRY_DATE_TO','Publication date to:');
define('TEXT_ALL_CATEGORIES', 'All categories');
define('TEXT_ALL_MANUFACTURERS', 'All manufacturers');
define('JS_AT_LEAST_ONE_INPUT', '* One of the following fields must be filled:\n    Keywords\n    Date added from\n    Date added to\n    Price over\n    Price up to\n');
define('JS_INVALID_FROM_DATE', '* Invalid "from" date\n');
define('JS_INVALID_TO_DATE', '* Invalid "up to" Date\n');
define('JS_TO_DATE_LESS_THAN_FROM_DATE', '* The "from" date must be lower or the same as the "up to" date\n');
define('JS_PRICE_FROM_MUST_BE_NUM', '* "Price over" must be a number\n');
define('JS_PRICE_TO_MUST_BE_NUM', '* "Price up to" must be a number\n');
define('JS_PRICE_TO_LESS_THAN_PRICE_FROM', '* Price up to must be larger or same size as Price over.\n');
define('JS_INVALID_KEYWORDS', '* Invalid search key\n');
define('TEXT_NO_PRODUCTS', 'No items which correspond to the search criteria were found.');
define('TEXT_NO_PRODUCTS_CATEGORY', 'No items were found in category.');
define('TEXT_ORIGIN_LOGIN', '<font color="#FF0000"><small><b>WARNING:</b></font></small> If you already have an account, please login <a href="%s"><u><b>here</b></u></a>.');
define('TEXT_LOGIN_ERROR', '<font color="#ff0000"><b>ERROR:</b></font> The entered \'eMail-address\' and/or the \'password\' do not match.');
define('TEXT_VISITORS_CART', '<font color="#ff0000"><b>WARNING:</b></font> Your inputs as visitor will be automatically linked to your account. <a href="javascript:session_win();">[More Information]</a>');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', '<font color="#ff0000"><b>WARNING:</b></font> The eMail-address entered is not registered. Please try again.');
define('TEXT_PASSWORD_SENT', 'A new password was sent by eMail.');
define('TEXT_PRODUCT_NOT_FOUND', 'Product not found!');
define('TEXT_MORE_INFORMATION', 'For further informations, please visit the <a href="%s" target="_blank"><u>homepage</u></a> to this product.');
define('TEXT_DATE_ADDED', 'This Product was added to our catalog on %s.');
define('TEXT_DATE_AVAILABLE', 'Will be presumably available for order (again) <b>from %s on</b>.');

define('TEXT_SOLD_OUT', "The product \"%s\" is unfortunately not currently on stock!");
define('TEXT_NO_PERMISSION', "You have no permission to order this product.");
define('TEXT_NO_PRODUCT', "No product with the %s '%s' was found!");
define('TEXT_NR_REQUIRED', "You must enter a %s");
define('TEXT_ARTICLE_NR',"Article-Number");
define('TEXT_ARTICLE_ID',"Article-id");
define('TEXT_ORDER_CONTINUE','<p><font size="3" color="red"><strong>Continue order for</strong></font></p>');

define('TEXT_PRODUCTS_NOT_AVAILABLE',
HTML_BR.HTML_BR.'<b>The following products in the cart stored are no longer available:</b>'.HTML_BR.HTML_BR);
define('TEXT_CART_EMPTY', 'Your cart is empty.');
define('SUB_TITLE_SUB_TOTAL', 'Subtotal:');
define('SUB_TITLE_TOTAL', 'Total:');

define('OUT_OF_STOCK_CANT_CHECKOUT', 'The products marked with ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' , are not on stock with your entered amount.<br/>Please reduce your purchase order quantity for the marked products. Thank you');
define('OUT_OF_STOCK_CAN_CHECKOUT', 'The products marked with ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' , are not on stock with your entered amount.<br/>The entered amount will be supplied in a short period of time by us. On request, we would also be able to make a part delivery.');

define('HEADING_TITLE_TELL_A_FRIEND', 'Recommend \'%s\'');
define('HEADING_TITLE_ERROR_TELL_A_FRIEND', 'Recommend product');
define('ERROR_INVALID_PRODUCT', 'The product chosen by you was not found!');


define('NAVBAR_TITLE_ACCOUNT', 'Your account');
define('NAVBAR_TITLE_1_ACCOUNT_EDIT', 'Your account');
define('NAVBAR_TITLE_2_ACCOUNT_EDIT', 'Changing your personal data');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY', 'Your account');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY', 'Your done orders');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY_INFO', 'Your account');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY_INFO', 'Done orders');
define('NAVBAR_TITLE_3_ACCOUNT_HISTORY_INFO', 'Order number %s');
define('NAVBAR_TITLE_1_ACCOUNT_NEWSLETTERS', 'Your account');
define('NAVBAR_TITLE_2_ACCOUNT_NEWSLETTERS', 'Newsletter subscription');
define('NAVBAR_TITLE_1_ACCOUNT_NOTIFICATIONS', 'Your account');
define('NAVBAR_TITLE_2_ACCOUNT_NOTIFICATIONS', 'Product information');
define('NAVBAR_TITLE_1_ACCOUNT_PASSWORD', 'Your account');
define('NAVBAR_TITLE_2_ACCOUNT_PASSWORD', 'Change password');
define('NAVBAR_TITLE_1_ADDRESS_BOOK', 'Your account');
define('NAVBAR_TITLE_2_ADDRESS_BOOK', 'Address book');
define('NAVBAR_TITLE_1_ADDRESS_BOOK_PROCESS', 'Your account');
define('NAVBAR_TITLE_2_ADDRESS_BOOK_PROCESS', 'Address book');
define('NAVBAR_TITLE_ADD_ENTRY_ADDRESS_BOOK_PROCESS', 'New entry');
define('NAVBAR_TITLE_MODIFY_ENTRY_ADDRESS_BOOK_PROCESS', 'Change entry');
define('NAVBAR_TITLE_DELETE_ENTRY_ADDRESS_BOOK_PROCESS', 'Delete Entry');
define('NAVBAR_TITLE_ADVANCED_SEARCH', 'Advanced Search');
define('NAVBAR_TITLE1_ADVANCED_SEARCH', 'Advanced Search');
define('NAVBAR_TITLE2_ADVANCED_SEARCH', 'Search results');
define('NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION', 'Confirmation');
define('NAVBAR_TITLE_1_CHECKOUT_PAYMENT', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_PAYMENT', 'Method of payment');
define('NAVBAR_TITLE_1_PAYMENT_ADDRESS', 'Checkout');
define('NAVBAR_TITLE_2_PAYMENT_ADDRESS', 'Change billing address');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING', 'Shipping information');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING_ADDRESS', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING_ADDRESS', 'Change shipping address');
define('NAVBAR_TITLE_1_CHECKOUT_SUCCESS', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_SUCCESS', 'Success');
define('NAVBAR_TITLE_CONTACT_US', 'Contact');
define('NAVBAR_TITLE_CREATE_ACCOUNT', 'Create account');
define('NAVBAR_TITLE_1_CREATE_ACCOUNT_SUCCESS', 'Create account');
define('NAVBAR_TITLE_2_CREATE_ACCOUNT_SUCCESS', 'Success');
if ($navigation->snapshot['page'] == FILENAME_CHECKOUT_SHIPPING) {
	define('NAVBAR_TITLE_LOGIN', 'Order');
} else {
	define('NAVBAR_TITLE_LOGIN', 'Login');
}
define('NAVBAR_TITLE_LOGOFF','Good bye');
define('NAVBAR_TITLE_1_PASSWORD_FORGOTTEN', 'Login');
define('NAVBAR_TITLE_2_PASSWORD_FORGOTTEN', 'Password forgotten');
define('NAVBAR_TITLE_PRODUCTS_NEW', 'New products');
define('NAVBAR_TITLE_SHOPPING_CART', 'Shopping cart');
define('NAVBAR_TITLE_SPECIALS', 'Special offers');
define('NAVBAR_TITLE_COOKIE_USAGE', 'Cookie Usage');
define('NAVBAR_TITLE_PRODUCT_REVIEWS', 'Reviews');
define('NAVBAR_TITLE_TELL_A_FRIEND', 'Recommend product');
define('NAVBAR_TITLE_REVIEWS_WRITE', 'Opinions');
define('NAVBAR_TITLE_REVIEWS','Reviews');
define('NAVBAR_TITLE_SSL_CHECK', 'Note on safety');
define('NAVBAR_TITLE_CREATE_GUEST_ACCOUNT','Create account');

define('TEXT_EMAIL_SUCCESSFUL_SENT','Your eMail was sent successfully!');
define('ERROR_MAIL','Please check the entered data in the form');
define('CATEGORIE_NOT_FOUND','Category was not found');
define('TEXT_CUSTOMER_GUEST','Guest');
define('TEXT_NO_ORDER_DISPLAY','You may not display this order (any more)!');

include('lang/english/gv_english.php');

//Coupon
define('REDEEMED_COUPON','Your coupon was successfully booked and will be redeemed automatically with your next order.');
define('ERROR_INVALID_USES_USER_COUPON','Customers can redeem this coupon only ');
define('ERROR_INVALID_USES_COUPON','Customers can redeem this coupon only ');
define('TIMES',' times.');
define('ERROR_INVALID_STARTDATE_COUPON','Your coupon is not aviable yet.');
define('ERROR_INVALID_FINISDATE_COUPON','Your coupon is out of date.');

//---PayPal WPP Modification START ---//
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_TITLE', 'Credit Card');
define('MODULE_PAYMENT_PAYPAL_EC_TEXT_TITLE', 'PayPal Express Checkout');
define('TEXT_PAYPALWPP_EC_HEADER', 'Fast, Secure Checkout with PayPal');
define('TEXT_PAYPALWPP_EC_BUTTON_TEXT', 'Save time. Checkout securely. Pay without sharing your financial information.');
define('TEXT_PAYPALWPP_EC_BUTTON_DESCRIPTION_TEXT', 'If you are already a verified <a href="'.$http_protocol.'://www.paypal.com" target="_blank" title="Go to the PayPal website"><b>PayPal</b></a> member (or want to become one), you can drastically shorten then checkout process! (E.g., you do not need to enter your shipping-address, as this will be transmitted from your PayPal account.)');
define('EMAIL_EC_ACCOUNT_INFORMATION', 'Thank you for using PayPal Express Checkout!  To make your next visit with us even smoother, an account has been automatically created for you.  Your new login information has been included below:' . "\n\n");
//---PayPal WPP Modification END---//
//	W. Kaiser - Erlaube Sendungstracking
define('ENTRY_TRACKCODE', 'Shippingcode');
define('ENTRY_TRACKCODE_EXPLAIN', '&nbsp;&nbsp;('.ENTRY_TRACKCODE.' for shipment-tracking)');
define('ENTRY_TRACK_URL_TEXT','<br/><b>Click here for shipment-tracking</b>');
//	W. Kaiser - Erlaube Sendungstracking

define('PARSE_TIME_STRING','Execution time: %s seconds');
define('ADODB_EXECUTES_STRING',". 'ADODB' SQL-commands executed=");
define('ADODB_EXECUTES_CACHED_STRING'," (fetched from cache: %s - 'cache-hit-rate': %s %% -)");

define('LIVE_HELP_TITLE',
"Zu Ihrer besseren Unterstützung haben wir eine Technologie in unseren Shop integriert, die es erlaubt, eine direkte Echtzeit-Kommunikation zwischen den Besuchern unserer Internet-Seite und uns herzustellen. Wenn Sie also eine Frage haben, können Sie versuchen, direkt online mit uns in Verbindung zu treten, und diese Frage im Online Chat interaktiv direkt zu klären! Sie starten diesen Vorgang durch 'Klick' auf dieses Bild.");

define('TEXT_GALLERY','Product-Gallery (Pictures)');

define('TEXT_NO_SMARTY_COMPILE_DIR','Please create the directory "%s", and allow full access.<br/>("777" for LINUX/UNIX, "read/write for Windows)');
define('TEXT_ERROR_HANDLER_ERROR_TYPE','Error <b>#error_nr#<br/><font color="#FF0000">#error_text#</font></b><br/>');
define('TEXT_ERROR_HANDLER_ERROR_FILE','File: <b><font color="#0000FF">#file#</font></b>, Line: <b>#line#</b><br/>');

if (SHOW_AFFILIATE)
{
	// inclusion for affiliate program
	include('affiliate_english.php');
}
?>