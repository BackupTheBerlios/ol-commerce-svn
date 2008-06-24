<?php
/* -----------------------------------------------------------------------------------------
$Id: configuration.php,v 2.0.0 2006/12/14 05:48:34 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(configuration.php,v 1.8 2002/01/04); www.oscommerce.com
(c) 2003	    nextcommerce (configuration.php,v 1.16 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$yes_no='<br/><b>(1 = Yes, 0 = No)</b>';

define('TABLE_HEADING_CONFIGURATION_TITLE', 'Title');
define('TABLE_HEADING_CONFIGURATION_VALUE', 'Value');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
define('TEXT_INFO_DATE_ADDED', 'Date Added:');
define('TEXT_INFO_LAST_MODIFIED', 'Last Modified:');

// language definitions for config
define('STORE_NAME_TITLE' , 'Store Name');
define('STORE_NAME_DESC' , 'The name of my store');
define('STORE_OWNER_TITLE' , 'Store Owner');
define('STORE_OWNER_DESC' , 'The name of my store owner');
define('STORE_OWNER_EMAIL_ADDRESS_TITLE' , 'eMail Adress');
define('STORE_OWNER_EMAIL_ADDRESS_DESC' , 'The eMail Adress of my store owner');

define('EMAIL_FROM_TITLE' , 'eMail from');
define('EMAIL_FROM_DESC' , 'The eMail Adress used in (sent) eMails.');

define('STORE_COUNTRY_TITLE' , 'Country');
define('STORE_COUNTRY_DESC' , 'The country my store is located in <br/><br/><b>Note: Please remember to update the store zone.</b>');
define('STORE_ZONE_TITLE' , 'Zone');
define('STORE_ZONE_DESC' , 'The zone my store is located in.');

define('EXPECTED_PRODUCTS_SORT_TITLE' , 'Expected sort order');
define('EXPECTED_PRODUCTS_SORT_DESC' , 'This is the sort order used in the expected products box.');
define('EXPECTED_PRODUCTS_FIELD_TITLE' , 'Expexted sort field');
define('EXPECTED_PRODUCTS_FIELD_DESC' , 'The column to sort by in the expected products box.');

define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE' , 'Switch to default language currency');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC' , 'Automatically switch to the languages currency when it is changed.');

define('SEND_EXTRA_ORDER_EMAILS_TO_TITLE' , 'Send extra order eMails to:');
define('SEND_EXTRA_ORDER_EMAILS_TO_DESC' , 'Send extra order eMails to the following eMail adresses, in this format: Name1 &lt;eMail@adress1&gt;, Name2 &lt;eMail@adress2&gt;');

$seo=' search-engine-optimized URLs ';
define('SEARCH_ENGINE_FRIENDLY_URLS_TITLE', 'Use',$seo.QUESTION);
define('SEARCH_ENGINE_FRIENDLY_URLS_DESC', '
The URLs are generated in a search-engine-optimized way.
<br/><br/>
Examples:
<br/><br/>
http://www.server.de/olcommerce/seo-products_info-products_id-144.htm
<br/>
http://www.server.de/olcommerce/seo-index-cPath-1_10.htm
');
define('USE_SEO_EXTENDED_TITLE', 'Use extended',$seo.QUESTION);
define('USE_SEO_EXTENDED_DESC', '
The URLs are generated in a search-engine-optimized and more meaningful way, as the product- or category-names are used, instead of meaningless parameters.
<br/><br/>
Examples:
<br/><br/>
http://www.server.de/olcommerce/seo-p-indian_summer;123.htm
<br/>
http://www.server.de/olcommerce/seo-k-seifen-ziegenmilch_seifen.htm
');

define('SEO_SEPARATOR_TITLE', 'Separator for '.$seo);
define('SEO_SEPARATOR_DESC', 'Who  does not like "<b>-</b>" as separator for the elements of '.$seo.', can alternatively select the character "<b>/</b>".');

define('SEO_TERMINATOR_TITLE', 'Filetype for'.$seo);
define('SEO_TERMINATOR_DESC', 'Who  does not like  "<b>.htm</b>" as filetype for '.$seo.'can alternatively select "<b>.html</b>" .');

define('DISPLAY_CART_TITLE' , 'Display Cart After Adding a Product?');
define('DISPLAY_CART_DESC' , 'Display the shopping cart after adding a product or return back to their origin?');

define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE' , 'Allow Guest To Tell a Friend?');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC' , 'Allow guests to tell a friend about a product?');

define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE' , 'Default Search Operator');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC' , 'Default search operators.');

define('STORE_NAME_ADDRESS_TITLE' , 'Store Adress and Phone');
define('STORE_NAME_ADDRESS_DESC' , 'This is the Store Name, Adress and Phone used on printable documents and displayed online.');

define('SHOW_COUNTS_TITLE' , 'Show Category Counts');
define('SHOW_COUNTS_DESC' , 'Count recursively how many products are in each category');

define('DISPLAY_PRICE_WITH_TAX_TITLE' , 'Display Prices with Tax');
define('DISPLAY_PRICE_WITH_TAX_DESC' , 'Display prices with tax included (true) or add the tax at the end (false)');

$customer_status='Customers Status of ';
define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_TITLE' , $customer_status.'Administration Members');
define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_DESC' , 'Choose the customers status for Members of the Administration Team!');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_TITLE' , $customer_status.'Guests');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_DESC' , 'What would be the default customers status for a guest before logged in?');
define('DEFAULT_CUSTOMERS_STATUS_ID_TITLE' , $customer_status.'New Customers');
define('DEFAULT_CUSTOMERS_STATUS_ID_DESC' , 'What would be the default customers status for a new customer?');
define('CUSTOMER_STATUS_NO_FERNAG_INFO_IDS_TITLE' , $customer_status.'customer group IDs <b>without</b> order cancellation information');
define('CUSTOMER_STATUS_NO_FERNAG_INFO_IDS_DESC' , 'Please insert the customer group-statusses for those customer groups, which are <b>not</b> to receive an order cancellation information in the order acknowledgement-eMail (e.g. companies). Separate multiple groups with comma!');


define('ALLOW_ADD_TO_CART_TITLE' , 'Allow add to cart');
define('ALLOW_ADD_TO_CART_DESC' , 'Allow customers to add products into cart if groupsetting for "show prices" is set to 0');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_TITLE' , 'Allow discount on products attribute?');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_DESC' , 'Allow customers to get discount on attribute price (if main product is not a "special" product)');
define('ALLOW_CATEGORY_DESCRIPTIONS_TITLE' , 'Use Category Descriptions');
define('ALLOW_CATEGORY_DESCRIPTIONS_DESC' , 'Allows to add descriptions for categories');
define('CURRENT_TEMPLATE_TITLE' , 'Templateset (Theme)');
define('CURRENT_TEMPLATE_DESC' , 'Choose a Templateset (Theme). The Theme must be saved before in the following folder: www.Your-Domain.com/templates/');

define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE' , 'First Name');
define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC' , 'Minimum length of first name');
define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE' , 'Last Name');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC' , 'Minimum length of last name');
define('ENTRY_DOB_MIN_LENGTH_TITLE' , 'Date of Birth');
define('ENTRY_DOB_MIN_LENGTH_DESC' , 'Minimum length of date of birth');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE' , 'eMail Adress');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC' , 'Minimum length of eMail adress');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE' , 'Street Adress');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC' , 'Minimum length of street adress');
define('ENTRY_COMPANY_MIN_LENGTH_TITLE' , 'Company');
define('ENTRY_COMPANY_MIN_LENGTH_DESC' , 'Minimum length of company name');
define('ENTRY_POSTCODE_MIN_LENGTH_TITLE' , 'Post Code');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC' , 'Minimum length of post code');
define('ENTRY_CITY_MIN_LENGTH_TITLE' , 'City');
define('ENTRY_CITY_MIN_LENGTH_DESC' , 'Minimum length of city');
define('ENTRY_STATE_MIN_LENGTH_TITLE' , 'State');
define('ENTRY_STATE_MIN_LENGTH_DESC' , 'Minimum length of state');
define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE' , 'Telephone Number');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC' , 'Minimum length of telephone number');
define('ENTRY_PASSWORD_MIN_LENGTH_TITLE' , 'Password');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC' , 'Minimum length of password');

define('CC_OWNER_MIN_LENGTH_TITLE' , 'Credit Card Owner Name');
define('CC_OWNER_MIN_LENGTH_DESC' , 'Minimum length of credit card owner name');
define('CC_NUMBER_MIN_LENGTH_TITLE' , 'Credit Card Number');
define('CC_NUMBER_MIN_LENGTH_DESC' , 'Minimum length of credit card number');

define('REVIEW_TEXT_MIN_LENGTH_TITLE' , 'Reviews');
define('REVIEW_TEXT_MIN_LENGTH_DESC' , 'Minimum length of review text');

define('MIN_DISPLAY_BESTSELLERS_TITLE' , 'Best Sellers');
define('MIN_DISPLAY_BESTSELLERS_DESC' , 'Minimum number of best sellers to display');
define('MIN_DISPLAY_ALSO_PURCHASED_TITLE' , 'Also Purchased');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC' , 'Minimum number of products to display in the "This Customer Also Purchased" box');

define('MAX_ADDRESS_BOOK_ENTRIES_TITLE' , 'Address Book Entries');
define('MAX_ADDRESS_BOOK_ENTRIES_DESC' , 'Maximum address book entries a customer is allowed to have');
define('MAX_DISPLAY_SEARCH_RESULTS_TITLE' , 'Search Results');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC' , 'Amount of products to list');
define('MAX_DISPLAY_PAGE_LINKS_TITLE' , 'Page Links');
define('MAX_DISPLAY_PAGE_LINKS_DESC' , 'Number of "number" links use for page-sets');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE' , 'Special Products');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC' , 'Maximum number of products on special to display');
define('MAX_DISPLAY_NEW_PRODUCTS_TITLE' , 'New Products Module');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC' , 'Maximum number of new products to display in a category');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE' , 'Products Expected');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC' , 'Maximum number of products expected to display');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE' , 'Manufacturers List');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC' , 'Used in manufacturers box; when the number of manufacturers exceeds this number, a drop-down list will be displayed instead of the default list');
define('MAX_MANUFACTURERS_LIST_TITLE' , 'Manufacturers Select Size');
define('MAX_MANUFACTURERS_LIST_DESC' , 'Used in manufacturers box; when this value is "1" the classic drop-down list will be used for the manufacturers box. Otherwise, a list-box with the specified number of rows will be displayed.');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE' , 'Length of Manufacturers Name');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC' , 'Used in manufacturers box; maximum length of manufacturers name to display');
define('MAX_DISPLAY_NEW_REVIEWS_TITLE' , 'New Reviews');
define('MAX_DISPLAY_NEW_REVIEWS_DESC' , 'Maximum number of new reviews to display');
define('MAX_RANDOM_SELECT_REVIEWS_TITLE' , 'Selection of Random Reviews');
define('MAX_RANDOM_SELECT_REVIEWS_DESC' , 'How many records to select from to choose one random product review');
define('MAX_RANDOM_SELECT_NEW_TITLE' , 'Selection of Random New Products');
define('MAX_RANDOM_SELECT_NEW_DESC' , 'How many records to select from to choose one random new product to display');
define('MAX_RANDOM_SELECT_SPECIALS_TITLE' , 'Selection of Products on Special');
define('MAX_RANDOM_SELECT_SPECIALS_DESC' , 'How many records to select from to choose one random product special to display');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE' , 'Categories To List Per Row');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC' , 'How many categories to list per row');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE' , 'New Products Listing');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC' , 'Maximum number of new products to display in new products page');
define('MAX_DISPLAY_BESTSELLERS_TITLE' , 'Best Sellers');
define('MAX_DISPLAY_BESTSELLERS_DESC' , 'Maximum number of best sellers to display');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE' , 'Also Purchased');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC' , 'Maximum number of products to display in the "This Customer Also Purchased" box');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE' , 'Customer Order History Box');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC' , 'Maximum number of products to display in the customer order history box');
define('MAX_DISPLAY_ORDER_HISTORY_TITLE' , 'Order History');
define('MAX_DISPLAY_ORDER_HISTORY_DESC' , 'Maximum number of orders to display in the order history page');

//mo_images
define('MO_PICS_TITLE', 'Amount of additional product images');
define('MO_PICS_DESC', 'Amount of product images available in addition to the main product image.');

define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_TITLE' , 'Width of Product-Thumbnails');
define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_DESC' , 'Width of Product-Thumbnails in Pixel (plain input for autom. skaling)');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_TITLE' , 'Height of Product-Thumbnails');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_DESC' , 'Height of Product-Thumbnails in Pixel (plain input for autom. skaling)');

define('PRODUCT_IMAGE_INFO_WIDTH_TITLE' , 'Width of Product-Info Images');
define('PRODUCT_IMAGE_INFO_WIDTH_DESC' , 'Width of Product-Info Images in Pixel (plain input for autom. skaling)');
define('PRODUCT_IMAGE_INFO_HEIGHT_TITLE' , 'Height of Product-Info Images');
define('PRODUCT_IMAGE_INFO_HEIGHT_DESC' , 'Height of Product-Info Images in Pixel (plain input for autom. skaling)');

define('PRODUCT_IMAGE_POPUP_WIDTH_TITLE' , 'Width of Popup Images');
define('PRODUCT_IMAGE_POPUP_WIDTH_DESC' , 'Width of Popup Images in Pixel (plain input for autom. skaling)');
define('PRODUCT_IMAGE_POPUP_HEIGHT_TITLE' , 'Height of Popup Images');
define('PRODUCT_IMAGE_POPUP_HEIGHT_DESC' , 'Height of Popup Images in Pixel (plain input for autom. skaling)');

define('SMALL_IMAGE_WIDTH_TITLE' , 'Small Image Width');
define('SMALL_IMAGE_WIDTH_DESC' , 'The pixel width of small images');
define('SMALL_IMAGE_HEIGHT_TITLE' , 'Small Image Height');
define('SMALL_IMAGE_HEIGHT_DESC' , 'The pixel height of small images');

define('HEADING_IMAGE_WIDTH_TITLE' , 'Heading Image Width');
define('HEADING_IMAGE_WIDTH_DESC' , 'The pixel width of heading images');
define('HEADING_IMAGE_HEIGHT_TITLE' , 'Heading Image Height');
define('HEADING_IMAGE_HEIGHT_DESC' , 'The pixel height of heading images');

define('SUBCATEGORY_IMAGE_WIDTH_TITLE' , 'Subcategory Image Width');
define('SUBCATEGORY_IMAGE_WIDTH_DESC' , 'The pixel width of subcategory images');
define('SUBCATEGORY_IMAGE_HEIGHT_TITLE' , 'Subcategory Image Height');
define('SUBCATEGORY_IMAGE_HEIGHT_DESC' , 'The pixel height of subcategory images');

define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE' , 'Calculate Image Size');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC' , 'Calculate the size of images?');

define('IMAGE_REQUIRED_TITLE' , 'Image Required');
define('IMAGE_REQUIRED_DESC' , 'Enable to display broken images. Good for development.');

//This is for the Images showing your products for preview. All the small stuff.

define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_TITLE' , 'Products-Thumbnails:Bevel');
define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_DESC' , 'Products-Thumbnails:Bevel<br/><br/>Default-values: (8,FFCCCC,330000)<br/><br/>shaded bevelled edges<br/>Usage:<br/>(edge width,hex light colour,hex dark colour)');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_TITLE' , 'Products-Thumbnails:Greyscale');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_DESC' , 'Products-Thumbnails:Greyscale<br/><br/>Default-values: (32,22,22)<br/><br/>basic black n white<br/>Usage:<br/>(int red,int green,int blue)');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_TITLE' , 'Products-Thumbnails:Ellipse');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_DESC' , 'Products-Thumbnails:Ellipse<br/><br/>Default-values: (FFFFFF)<br/><br/>ellipse on bg colour<br/>Usage:<br/>(hex background colour)');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_TITLE' , 'Products-Thumbnails:Round-edges');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_DESC' , 'Products-Thumbnails:Round-edges<br/><br/>Default-values: (5,FFFFFF,3)<br/><br/>corner trimming<br/>Usage:<br/>(edge_radius,background colour,anti-alias width)');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_TITLE' , 'Products-Thumbnails:Merge');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_DESC' , 'Products-Thumbnails:Merge<br/><br/>Default-values: (overlay.gif,10,-50,60,FF0000)<br/><br/>overlay merge image<br/>Usage:<br/>(merge image,x start [neg = from right],y start [neg = from base],opacity, transparent colour on merge image)');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_TITLE' , 'Products-Thumbnails:Frame');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_DESC' , 'Products-Thumbnails:Frame<br/><br/>Default-values: <br/><br/>plain raised border<br/>Usage:<br/>(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_TITLE' , 'Products-Thumbnails:Drop-Shadow');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_DESC' , 'Products-Thumbnails:Drop-Shadow<br/><br/>Default-values: (3,333333,FFFFFF)<br/><br/>more like a dodgy motion blur [semi buggy]<br/>Usage:<br/>(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_TITLE' , 'Products-Thumbnails:Motion-Blur');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_DESC' , 'Products-Thumbnails:Motion-Blur<br/><br/>Default-values: (4,FFFFFF)<br/><br/>fading parallel lines<br/>Usage:<br/>(int number of lines,hex background colour)');

//And this is for the Images showing your products in single-view

define('PRODUCT_IMAGE_INFO_BEVEL_TITLE' , 'Product-Images:Bevel');
define('PRODUCT_IMAGE_INFO_BEVEL_DESC' , 'Product-Images:Bevel<br/><br/>Default-values: (8,FFCCCC,330000)<br/><br/>shaded bevelled edges<br/>Usage:<br/>(edge width, hex light colour, hex dark colour)');
define('PRODUCT_IMAGE_INFO_GREYSCALE_TITLE' , 'Product-Images:Greyscale');
define('PRODUCT_IMAGE_INFO_GREYSCALE_DESC' , 'Product-Images:Greyscale<br/><br/>Default-values: (32,22,22)<br/><br/>basic black n white<br/>Usage:<br/>(int red, int green, int blue)');
define('PRODUCT_IMAGE_INFO_ELLIPSE_TITLE' , 'Product-Images:Ellipse');
define('PRODUCT_IMAGE_INFO_ELLIPSE_DESC' , 'Product-Images:Ellipse<br/><br/>Default-values: (FFFFFF)<br/><br/>ellipse on bg colour<br/>Usage:<br/>(hex background colour)');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_TITLE' , 'Product-Images:Round-edges');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_DESC' , 'Product-Images:Round-edges<br/><br/>Default-values: (5,FFFFFF,3)<br/><br/>corner trimming<br/>Usage:<br/>( edge_radius, background colour, anti-alias width)');
define('PRODUCT_IMAGE_INFO_MERGE_TITLE' , 'Product-Images:Merge');
define('PRODUCT_IMAGE_INFO_MERGE_DESC' , 'Product-Images:Merge<br/><br/>Default-values: (overlay.gif,10,-50,60,FF0000)<br/><br/>overlay merge image<br/>Usage:<br/>(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('PRODUCT_IMAGE_INFO_FRAME_TITLE' , 'Product-Images:Frame');
define('PRODUCT_IMAGE_INFO_FRAME_DESC' , 'Product-Images:Frame<br/><br/>Default-values: (FFFFFF,000000,3,EEEEEE)<br/><br/>plain raised border<br/>Usage:<br/>(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_TITLE' , 'Product-Images:Drop-Shadow');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_DESC' , 'Product-Images:Drop-Shadow<br/><br/>Default-values: (3,333333,FFFFFF)<br/><br/>more like a dodgy motion blur [semi buggy]<br/>Usage:<br/>(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_TITLE' , 'Product-Images:Motion-Blur');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_DESC' , 'Product-Images:Motion-Blur<br/><br/>Default-values: (4,FFFFFF)<br/><br/>fading parallel lines<br/>Usage:<br/>(int number of lines,hex background colour)');

//so this image is the biggest in the shop this

define('PRODUCT_IMAGE_POPUP_BEVEL_TITLE' , 'Product-Popup-Images:Bevel');
define('PRODUCT_IMAGE_POPUP_BEVEL_DESC' , 'Product-Popup-Images:Bevel<br/><br/>Default-values: (8,FFCCCC,330000)<br/><br/>shaded bevelled edges<br/>Usage:<br/>(edge width,hex light colour,hex dark colour)');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_TITLE' , 'Product-Popup-Images:Greyscale');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_DESC' , 'Product-Popup-Images:Greyscale<br/><br/>Default-values: (32,22,22)<br/><br/>basic black n white<br/>Usage:<br/>(int red,int green,int blue)');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_TITLE' , 'Product-Popup-Images:Ellipse');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_DESC' , 'Product-Popup-Images:Ellipse<br/><br/>Default-values: (FFFFFF)<br/><br/>ellipse on bg colour<br/>Usage:<br/>(hex background colour)');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_TITLE' , 'Product-Popup-Images:Round-edges');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_DESC' , 'Product-Popup-Images:Round-edges<br/><br/>Default-values: (5,FFFFFF,3)<br/><br/>corner trimming<br/>Usage:<br/>(edge_radius,background colour,anti-alias width)');
define('PRODUCT_IMAGE_POPUP_MERGE_TITLE' , 'Product-Popup-Images:Merge');
define('PRODUCT_IMAGE_POPUP_MERGE_DESC' , 'Product-Popup-Images:Merge<br/><br/>Default-values: (overlay.gif,10,-50,60,FF0000)<br/><br/>overlay merge image<br/>Usage:<br/>(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('PRODUCT_IMAGE_POPUP_FRAME_TITLE' , 'Product-Popup-Images:Frame');
define('PRODUCT_IMAGE_POPUP_FRAME_DESC' , 'Product-Popup-Images:Frame<br/><br/>Default-values: <br/><br/>plain raised border<br/>Usage:<br/>(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_TITLE' , 'Product-Popup-Images:Drop-Shadow');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_DESC' , 'Product-Popup-Images:Drop-Shadow<br/><br/>Default-values: (3,333333,FFFFFF)<br/><br/>more like a dodgy motion blur [semi buggy]<br/>Usage:<br/>(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_TITLE' , 'Product-Popup-Images:Motion-Blur');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_DESC' , 'Product-Popup-Images:Motion-Blur<br/><br/>Default-values: (4,FFFFFF)<br/><br/>fading parallel lines<br/>Usage:<br/>(int number of lines,hex background colour)');


define('ACCOUNT_GENDER_TITLE' , 'Gender');
define('ACCOUNT_GENDER_DESC' , 'Display gender in the customers account');
define('ACCOUNT_DOB_TITLE' , 'Date of Birth');
define('ACCOUNT_DOB_DESC' , 'Display date of birth in the customers account');
define('ACCOUNT_COMPANY_TITLE' , 'Company');
define('ACCOUNT_COMPANY_DESC' , 'Display company in the customers account');
define('ACCOUNT_SUBURB_TITLE' , 'Suburb');
define('ACCOUNT_SUBURB_DESC' , 'Display suburb in the customers account');
define('ACCOUNT_STATE_TITLE' , 'State');
define('ACCOUNT_STATE_DESC' , 'Display state in the customers account');

define('DEFAULT_CURRENCY_TITLE' , 'Default Currency');
define('DEFAULT_CURRENCY_DESC' , 'Currency which is used as default');
define('DEFAULT_LANGUAGE_TITLE' , 'Default Language');
define('DEFAULT_LANGUAGE_DESC' , 'Language which is used as default');
define('DEFAULT_ORDERS_STATUS_ID_TITLE' , 'Default Order Status');
define('DEFAULT_ORDERS_STATUS_ID_DESC' , 'Default order status when a new order is placed.');

define('SHIPPING_ORIGIN_COUNTRY_TITLE' , 'Country of Origin');
define('SHIPPING_ORIGIN_COUNTRY_DESC' , 'Select the country of origin to be used in shipping quotes.');
define('SHIPPING_ORIGIN_ZIP_TITLE' , 'Postal Code');
define('SHIPPING_ORIGIN_ZIP_DESC' , 'Enter the Postal Code (ZIP) of the Store to be used in shipping quotes.');
define('SHIPPING_MAX_WEIGHT_TITLE' , 'Enter the Maximum Package Weight you will ship');
define('SHIPPING_MAX_WEIGHT_DESC' , 'Carriers have a max weight limit for a single package. This is a common one for all.');
define('SHIPPING_BOX_WEIGHT_TITLE' , 'Package Tare weight.');
define('SHIPPING_BOX_WEIGHT_DESC' , 'What is the weight of typical packaging of small to medium packages?');
define('SHIPPING_BOX_PADDING_TITLE' , 'Larger packages - percentage increase.');
define('SHIPPING_BOX_PADDING_DESC' , 'For 10% enter 10');

define('PRODUCT_LIST_FILTER_TITLE' , 'Display Category/Manufacturer Filter (0=disable; 1=enable)');
define('PRODUCT_LIST_FILTER_DESC' , 'Do you want to display the Category/Manufacturer Filter?');

define('STOCK_CHECK_TITLE' , 'Check stock level');
define('STOCK_CHECK_DESC' , 'Check to see if sufficent stock is available');

define('ATTRIBUTE_STOCK_CHECK_TITLE' , 'Check attribute-stock level');
define('ATTRIBUTE_STOCK_CHECK_DESC' , 'Check to see if sufficent attribute-stock is available');

define('STOCK_LIMITED_TITLE' , 'Subtract stock');
define('STOCK_LIMITED_DESC' , 'Subtract product in stock by product orders');
define('STOCK_ALLOW_CHECKOUT_TITLE' , 'Allow Checkout');
define('STOCK_ALLOW_CHECKOUT_DESC' , 'Allow customer to checkout even if there is insufficient stock');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE' , 'Mark product out of stock');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC' , 'Display something on screen so customer can see which product has insufficient stock');
define('STOCK_REORDER_LEVEL_TITLE' , 'Stock Re-order level');
define('STOCK_REORDER_LEVEL_DESC' , 'Define when stock needs to be re-ordered');

define('STORE_PAGE_PARSE_TIME_TITLE' , 'Store Page Parse Time');
define('STORE_PAGE_PARSE_TIME_DESC' , 'Store the time it takes to parse a page');
define('STORE_PAGE_PARSE_TIME_LOG_TITLE' , 'Log Destination');
define('STORE_PAGE_PARSE_TIME_LOG_DESC' , 'Directory and filename of the page parse time log');
define('STORE_PARSE_DATE_TIME_FORMAT_TITLE' , 'Log Date Format');
define('STORE_PARSE_DATE_TIME_FORMAT_DESC' , 'The date format');

define('DISPLAY_PAGE_PARSE_TIME_TITLE' , 'Display The Page Parse Time');
define('DISPLAY_PAGE_PARSE_TIME_DESC' , 'Display the page parse time (store page parse time must be enabled)');

define('STORE_DB_TRANSACTIONS_TITLE' , 'Store Database Queries');
define('STORE_DB_TRANSACTIONS_DESC' , 'Store the database queries in the page parse time log (PHP4 only)');

define('USE_CACHE_TITLE' , 'Use Cache');
define('USE_CACHE_DESC' , 'Use caching features');

define('DIR_FS_CACHE_TITLE' , 'Cache Directory');
define('DIR_FS_CACHE_DESC' , 'The directory where the cached files are saved');

define('DB_CACHE_TITLE','Database Caching');		//Zusatz für Caching
define('DB_CACHE_TITLE','If set to true, Shop can cache SELECT Queries for a period of time, to increase speed');	//Zusatz für Caching

define('ACCOUNT_OPTIONS_TITLE','Account Options');
define('ACCOUNT_OPTIONS_DESC','How do you want to manage the login management of your store ?<br/>You can choose between Customer Accounts and "One Time Orders" without creating a Customer Account (an account will be created but the customer won\'t be informed about that)');

define('EMAIL_TRANSPORT_TITLE' , 'eMail Transport Method');
define('EMAIL_TRANSPORT_DESC' , 'Defines if this server uses a local connection to sendmail or uses an SMTP connection via TCP/IP. Servers running on Windows and MacOS should change this setting to SMTP.');

define('EMAIL_LINEFEED_TITLE' , 'eMail Linefeeds');
define('EMAIL_LINEFEED_DESC' , 'Defines the character sequence used to separate mail headers.');
define('EMAIL_USE_HTML_TITLE' , 'Use MIME HTML When Sending eMails');
define('EMAIL_USE_HTML_DESC' , 'Send eMails in HTML format');
define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE' , 'Verify eMail Addresses Through DNS');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC' , 'Verify eMail address through a DNS server');
define('SEND_EMAILS_TITLE' , 'Send eMails');
define('SEND_EMAILS_DESC' , 'Send out eMails');
define('SENDMAIL_PATH_TITLE' , 'The Path to sendmail');
define('SENDMAIL_PATH_DESC' , 'If you use sendmail, you should give us the right path (default: /usr/bin/sendmail):');
define('SMTP_MAIN_SERVER_TITLE' , 'Adress of the SMTP Server');
define('SMTP_MAIN_SERVER_DESC' , 'Please enter the adress of your main SMTP Server.');
define('SMTP_BACKUP_SERVER_TITLE' , 'Adress of the SMTP Backup Server');
define('SMTP_BACKUP_SERVER_DESC' , 'Please enter the adress of your Backup SMTP Server.');
define('SMTP_USERNAME_TITLE' , 'SMTP Username');
define('SMTP_USERNAME_DESC' , 'Please enter the username of your SMTP Account.');
define('SMTP_PASSWORD_TITLE' , 'SMTP Password');
define('SMTP_PASSWORD_DESC' , 'Please enter the password of your SMTP Account.');
define('SMTP_AUTH_TITLE' , 'SMTP AUTH');
define('SMTP_AUTH_DESC' , 'Does your SMTP Server needs secure authentication?');
define('SMTP_PORT_TITLE' , 'SMTP Port');
define('SMTP_PORT_DESC' , 'Please enter the SMTP port of your SMTP server(default: 25)?');

//Constants for contact_us
define('CONTACT_US_EMAIL_ADDRESS_TITLE' , 'Contact Us - eMail address');
define('CONTACT_US_EMAIL_ADDRESS_DESC' , 'Please enter an eMail Address used for normal "Contact Us" messages via shop to your office');
define('CONTACT_US_NAME_TITLE' , 'Contact Us - eMail address, name');
define('CONTACT_US_NAME_DESC' , 'Please Enter a name used for normal "Contact Us" messages sentded via shop to your office');
define('CONTACT_US_FORWARDING_STRING_TITLE' , 'Contact Us - forwaring addresses');
define('CONTACT_US_FORWARDING_STRING_DESC' , 'Please enter eMail addresses (seperated by , ) where "Contact Us" messages, sent via shop to your office, should be forwarded to.');
define('CONTACT_US_REPLY_ADDRESS_TITLE' , 'Contact Us - reply address');
define('CONTACT_US_REPLY_ADDRESS_DESC' , 'Please enter an eMail address where customers can reply to.');
define('CONTACT_US_REPLY_ADDRESS_NAME_TITLE' , 'Contact Us - reply address , name');
define('CONTACT_US_REPLY_ADDRESS_NAME_DESC' , 'Sender name for reply eMails.');
define('CONTACT_US_EMAIL_SUBJECT_TITLE' , 'Contact Us - eMail subject');
define('CONTACT_US_EMAIL_SUBJECT_DESC' , 'Please enter an eMail Subject for the contact-us messages via shop to your office.');

//Constants for support system
define('EMAIL_SUPPORT_ADDRESS_TITLE' , 'Technical Support - eMail adress');
define('EMAIL_SUPPORT_ADDRESS_DESC' , 'Please enter an eMail adress for sending eMails over the <b>Support System</b> (account creation, password changes).');
define('EMAIL_SUPPORT_NAME_TITLE' , 'Technical Support - eMail adress, name');
define('EMAIL_SUPPORT_NAME_DESC' , 'Please enter a name for sending eMails over the <b>Support System</b> (account creation, password changes).');
define('EMAIL_SUPPORT_FORWARDING_STRING_TITLE' , 'Technical Support - Forwarding adresses');
define('EMAIL_SUPPORT_FORWARDING_STRING_DESC' , 'Please enter forwarding adresses for the mails of the <b>Support System</b> (seperated by , )');
define('EMAIL_SUPPORT_REPLY_ADDRESS_TITLE' , 'Technical Support - reply adress');
define('EMAIL_SUPPORT_REPLY_ADDRESS_DESC' , 'Please enter an eMail adress for replies of your customers.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_TITLE' , 'Technical Support - reply adress, name');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_DESC' , 'Please enter a sender name for the eMail adress for replies of your customers.');
define('EMAIL_SUPPORT_SUBJECT_TITLE' , 'Technical Support - eMail subject');
define('EMAIL_SUPPORT_SUBJECT_DESC' , 'Please enter an eMail subject for the <b>Support System</b> messages via shop to your office.');

//Constants for Billing system
define('EMAIL_BILLING_ADDRESS_TITLE' , 'Billing - eMail adress');
define('EMAIL_BILLING_ADDRESS_DESC' , 'Please enter an eMail adress for sending eMails over the <b>Billing system</b> (order confirmations, status changes,..).');
define('EMAIL_BILLING_NAME_TITLE' , 'Billing - eMail adress, name');
define('EMAIL_BILLING_NAME_DESC' , 'Please enter a name for sending eMails over the <b>Billing System</b> (order confirmations, status changes,..).');
define('EMAIL_BILLING_FORWARDING_STRING_TITLE' , 'Billing - Forwarding adresses');
define('EMAIL_BILLING_FORWARDING_STRING_DESC' , 'Please enter forwarding adresses for the mails of the <b>Billing System</b> (seperated by , )');
define('EMAIL_BILLING_REPLY_ADDRESS_TITLE' , 'Billing - reply adress');
define('EMAIL_BILLING_REPLY_ADDRESS_DESC' , 'Please enter an eMail adress for replies of your customers.');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_TITLE' , 'Billing - reply adress, name');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_DESC' , 'Please enter a name for the eMail adress for replies of your customers.');
define('EMAIL_BILLING_SUBJECT_TITLE' , 'Billing - eMail subject');
define('EMAIL_BILLING_SUBJECT_DESC' , 'Please enter an eMail Subject for the <b>Billing</b> messages via shop to your office.');
define('EMAIL_BILLING_SUBJECT_ORDER_TITLE','Billing - Ordermail subject');
define('EMAIL_BILLING_SUBJECT_ORDER_DESC','Please enter a subject for ordermails generated from olc. (like <b>our order {$nr},{$date}</b>) ps: you can use, {$nr},{$date},{$firstname},{$lastname}');

//Constants for Newsletter
define('EMAIL_NEWSLETTER_PACAKGE_SIZE_TITLE' , 'Newsletter - Number of eMails per run');
define('EMAIL_NEWSLETTER_PACAKGE_SIZE_DESC' , 'Defines the number of eMails to be processed in one send run. This is batched in order to prevent PHP-timeouts if processing newsletter mails. The script processes the given amount of eMails and the reschedules itself to process another batch a.s.o. The value depends on the server timeout-settings.');

define('SEND_404_EMAIL_TITLE', 'Send eMail, if an HTML-page is not found');
define('SEND_404_EMAIL_DESC', 'If the server reports an  "Error 404 (Page noct found)", the administrator can have himself be notified by eMail, in order to correct the problem.');

define('DOWNLOAD_ENABLED_TITLE' , 'Enable download');
define('DOWNLOAD_ENABLED_DESC' , 'Enable the products download functions.');
define('DOWNLOAD_BY_REDIRECT_TITLE' , 'Download by redirect');
define('DOWNLOAD_BY_REDIRECT_DESC' , 'Use browser redirection for download. Disable on non-Unix systems.');
define('DOWNLOAD_MAX_DAYS_TITLE' , 'Expiry delay (days)');
define('DOWNLOAD_MAX_DAYS_DESC' , 'Set number of days before the download link expires. 0 means no limit.');
define('DOWNLOAD_MAX_COUNT_TITLE' , 'Maximum number of downloads');
define('DOWNLOAD_MAX_COUNT_DESC' , 'Set the maximum number of downloads. 0 means no download authorized.');

define('GZIP_COMPRESSION_TITLE' , 'Enable GZip Compression');
define('GZIP_COMPRESSION_DESC' , 'Enable HTTP GZip compression.');
define('GZIP_LEVEL_TITLE' , 'Compression Level');
define('GZIP_LEVEL_DESC' , 'Use a compression level from 0-9 (0 = minimum, 9 = maximum).');

define('SESSION_WRITE_DIRECTORY_TITLE' , 'Session Directory');
define('SESSION_WRITE_DIRECTORY_DESC' , 'If sessions are file based, store them in this directory.');
define('SESSION_FORCE_COOKIE_USE_TITLE' , 'Force Cookie Use');
define('SESSION_FORCE_COOKIE_USE_DESC' , 'Force the use of sessions when cookies are only enabled.');
define('SESSION_CHECK_SSL_SESSION_ID_TITLE' , 'Check SSL Session id');
define('SESSION_CHECK_SSL_SESSION_ID_DESC' , 'Validate the SSL_SESSION_ID on every secure HTTPS page request.');
define('SESSION_CHECK_USER_AGENT_TITLE' , 'Check User Agent');
define('SESSION_CHECK_USER_AGENT_DESC' , 'Validate the clients browser user agent on every page request.');
define('SESSION_CHECK_IP_ADDRESS_TITLE' , 'Check IP Address');
define('SESSION_CHECK_IP_ADDRESS_DESC' , 'Validate the clients IP address on every page request.');
define('SESSION_BLOCK_SPIDERS_TITLE' , 'Prevent Spider Sessions');
define('SESSION_BLOCK_SPIDERS_DESC' , 'Prevent known spiders from starting a session.');
define('SESSION_RECREATE_TITLE' , 'Recreate Session');
define('SESSION_RECREATE_DESC' , 'Recreate the session to generate a new session id when the customer logs on or creates an account (PHP >=4.1 needed).');

define('DISPLAY_CONDITIONS_ON_CHECKOUT_TITLE' , 'Display conditions check on checkout');
define('DISPLAY_CONDITIONS_ON_CHECKOUT_DESC' , 'Display and Signing the Conditions in the Order Process');

define('META_MIN_KEYWORD_LENGTH_TITLE' , 'Min. meta-keyword lenght');
define('META_MIN_KEYWORD_LENGTH_DESC' , 'min. length of a single keyword (generated from products description)');
define('META_KEYWORDS_NUMBER_TITLE' , 'Number of meta-keywords');
define('META_KEYWORDS_NUMBER_DESC' , 'number of keywords');
define('META_AUTHOR_TITLE' , 'author');
define('META_AUTHOR_DESC' , '<meta name="author">');
define('META_PUBLISHER_TITLE' , 'publisher');
define('META_PUBLISHER_DESC' , '<meta name="publisher">');
define('META_COMPANY_TITLE' , 'company');
define('META_COMPANY_DESC' , '<meta name="conpany">');
define('META_TOPIC_TITLE' , 'page-topic');
define('META_TOPIC_DESC' , '<meta name="page-topic">');
define('META_REPLY_TO_TITLE' , 'reply-to');
define('META_REPLY_TO_DESC' , '<meta name="reply-to">');
define('META_REVISIT_AFTER_TITLE' , 'revisit-after');
define('META_REVISIT_AFTER_DESC' , '<meta name="revisit-after">');
define('META_ROBOTS_TITLE' , 'robots');
define('META_ROBOTS_DESC' , '<meta name="robots">');
define('META_DESCRIPTION_TITLE' , 'Description');
define('META_DESCRIPTION_DESC' , '<meta name="description">');
define('META_KEYWORDS_TITLE' , 'Keywords');
define('META_KEYWORDS_DESC' , '<meta name="keywords">');

define('MODULE_PAYMENT_INSTALLED_TITLE' , 'Installed Payment Modules');
define('MODULE_PAYMENT_INSTALLED_DESC' , 'List of payment module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: cc.php;cod.php;paypal.php)');
define('MODULE_ORDER_TOTAL_INSTALLED_TITLE' , 'Installed OrderTotal-Modules');
define('MODULE_ORDER_TOTAL_INSTALLED_DESC' , 'List of order_total module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)');
define('MODULE_SHIPPING_INSTALLED_TITLE' , 'Installed Shipping Modules');
define('MODULE_SHIPPING_INSTALLED_DESC' , 'List of shipping module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ups.php;flat.php;item.php)');

define('CACHE_LIFETIME_TITLE','Cache Lifetime');
define('CACHE_LIFETIME_DESC','This is the number of seconds cached content will persist');
define('CACHE_CHECK_TITLE','Check if cache modified');
define('CACHE_CHECK_DESC','If true, then If-Modified-Since headers are respected with cached content, and appropriate HTTP headers are sent. This way repeated hits to a cached page do not send the entire page to the client every time.');

define('PRODUCT_REVIEWS_VIEW_TITLE','Reviews in Productdetails');
define('PRODUCT_REVIEWS_VIEW_DESC','Number of displayed reviews in the productdetails page');

define('DELETE_GUEST_ACCOUNT_TITLE','Deleting Guest Accounts');
define('DELETE_GUEST_ACCOUNT_DESC','Shold guest accounts be deleted after placing orders ? (Order data will be saved)');

define('USE_SPAW_TITLE','Activate WYSIWYG Editor');
define('USE_SPAW_DESC',USE_SPAW_TITLE.' for CMS and products');

define('PRICE_IS_BRUTTO_TITLE','Gross prices for Admin');
define('PRICE_IS_BRUTTO_DESC','Usage of prices with tax in Admin');

define('PRICE_PRECISION_TITLE','Gross/Net precision');
define('PRICE_PRECISION_DESC','Gross/Net precision');

define('NO_TAX_RAISED_TITLE','Run shop according to §19 german UStG.');
define('NO_TAX_RAISED_DESC','If you are a small entrepreneur according to §19 of the german UStG, and do not raise VAT, you must activate this parameter.'.$yes_no);

define('AFFILIATE_INCLUDE_TITLE','Activate "Affilliate"-program');
define('AFFILIATE_INCLUDE_DESC','Activate the program-modules for the "Affilliate"-program'.$yes_no);

define('CAO_INCLUDE_TITLE','Activate "CAO"-interface');
define('CAO_INCLUDE_DESC','Activate the program-modules for the "CAO"-interface'.$yes_no);
define('EASYSALES_INCLUDE_TITLE','Activate "Easy Sales"-interface');
define('EASYSALES_INCLUDE_DESC','Activate the program-modules for the "Easy Sales"-interface'.$yes_no);

define('USE_STICKY_CART_TITLE','Permanently display the shopping-cart (Sticky-Cart)');
define('USE_STICKY_CART_DESC','A copy of the shopping-cart is displayed even if the visitor scrolled down the page'.$yes_no);

define('USE_PDF_INVOICE_TITLE','Create invoices/packing slips in PDF-Format');
define('USE_PDF_INVOICE_DESC',USE_PDF_INVOICE_TITLE.$yes_no);

define('CHECK_CLIENT_AGENT_TITLE','Check Browseragent?');
define('CHECK_CLIENT_AGENT_DESC','Remove sessions when Searchengine-spider is visiting your site');
define('SHOW_IP_LOG_TITLE','IP-Log in Checkout?');
define('SHOW_IP_LOG_DESC','Show Text "Your IP will be saved", in checkout?');

define('ACTIVATE_GIFT_SYSTEM_TITLE','Activate Gift Voucher System');
define('ACTIVATE_GIFT_SYSTEM_DESC','Activate Gift Voucher System');

define('ACTIVATE_SHIPPING_STATUS_TITLE','Display Shippingstatus');
define('ACTIVATE_SHIPPING_STATUS_DESC','Show shippingstatus? (Different dispatch times can be specified for individual products. After activation appear a new point <b>Delivery Status</b> at product input)');

define('SECURITY_CODE_LENGTH_TITLE','Security Code Lenght');
define('SECURITY_CODE_LENGTH_DESC','Security code lenght (Gift voucher)');

define('IMAGE_QUALITY_TITLE','Image Quality');
define('IMAGE_QUALITY_DESC','Image quality (0= highest compression, 100=best quality)');

define('GROUP_CHECK_TITLE','Customer Status Check for Categories');
define('GROUP_CHECK_DESC','Only allow specified customergroups access to individual categories (after activation, input fields in categories and products will appear');

define('ACTIVATE_NAVIGATOR_TITLE','activate productnavigator?');
define('ACTIVATE_NAVIGATOR_DESC','activate/deactivate productnavigator in product_info, (deaktivate for better performance with lots of articles in system)');

define('QUICKLINK_ACTIVATED_TITLE','activate multilink/copyfunction');
define('QUICKLINK_ACTIVATED_DESC','The multilink/copyfunction, changes the handling for the "copy product to" action, it allows to select multiple categories to copy/link a product with 1 click');

//PDF-Datasheet-configurator
define('PDF_SHOW_LOGO_TITLE','Shop-Logo auf dem Datenblatt anzeigen');
define('PDF_SHOW_LOGO_DESC',PDF_SHOW_LOGO_TITLE.$yes_no);
define('PDF_STORE_LOGO_TITLE','Pfad zu dem Shop-Logo');
define('PDF_STORE_LOGO_DESC','Speichern Sie hier den '.PDF_STORE_LOGO_TITLE);
define('PDF_IMAGE_KEEP_PROPORTIONS_TITLE','Seitenverhältnis des Produktbildes beibehalten');
define('PDF_IMAGE_KEEP_PROPORTIONS_DESC',PDF_IMAGE_KEEP_PROPORTIONS_TITLE.$yes_no);
define('PDF_MAX_IMAGE_WIDTH_TITLE','Max. Bildbreite');
$image_text=' des Produktbildes in Millimetern.';
define('PDF_MAX_IMAGE_WIDTH_DESC','Die maximale Breite'.$image_text);
define('PDF_MAX_IMAGE_HEIGHT_TITLE','Max. Bildhöhe');
define('PDF_MAX_IMAGE_HEIGHT_DESC','Die maximale Höhe'.$image_text);
$watermark_text='Wasserzeichen ';
define('PDF_SHOW_WATERMARK_TITLE',$watermark_text.'anzeigen');
define('PDF_SHOW_WATERMARK_DESC',$watermark_text.'mit dem Shop-Namen auf der Seite anzeigen?'.$yes_no);
define('PDF_DOC_PATH_TITLE','Verzeichnis der PDF-Dokumente');
define('PDF_DOC_PATH_DESC','Das Verzeichnis, in dem die PDF-Dokumente gespeichert werden sollen. Beispiel: "pdfdocs/". Ohne führenden aber mit einem abschließenden Schrägstrich!). Stellen Sie sicher, dass dieses Verzeichnis existiert, und denken Sie daran, die Verzeichnisrechte so');
define('PDF_FILE_REDIRECT_TITLE','Datenblatt im Browser anzeigen oder laden?');
define('PDF_FILE_REDIRECT_DESC','Soll das Datenblatt im Browser anzeigt oder geladen werden? 0 = Download, 1 = Laden');
define('PDF_SHOW_BACKGROUND_TITLE','Hintergrund anzeigen');
define('PDF_SHOW_BACKGROUND_DESC','Soll das Datenblatt einen Hintergrund haben?'.$yes_no);
define('PDF_SAVE_DOCUMENT_TITLE','Sollen die Datenblätter auf dem Server gespeichert werden?');
define('PDF_SAVE_DOCUMENT_DESC','Eine Speicherung auf dem Server beschleunigt die Darstellung bei wiederholter Anforderung eines Datenblatts. Wenn Sie allerdings mit sich ändernden Produktdaten arbeiten - z.B. Sonderpreise -, sollten Sie diese Option nicht wählen!');
define('PDF_SHOW_PATH_TITLE','Soll der Produktpfad angezeigt werden?');
define('PDF_SHOW_PATH_DESC','Der Produktpfad wird im Datenblatt angezeigt.'.$yes_no);
define('PDF_SHOW_IMAGES_TITLE','Soll ein Produktbild angezeigt werden?');
define('PDF_SHOW_IMAGES_DESC','Ein Produktbild wird angezeigt.'.$yes_no);
define('PDF_SHOW_MODEL_TITLE','Soll die Artikel-Nummer angezeigt werden?');
define('PDF_SHOW_MODEL_DESC','Die Artikel-Nummer wird angezeigt.'.$yes_no);
define('PDF_SHOW_SHIPPING_TIME_TITLE','Soll die  Lieferzeit angezeigt werden?');
define('PDF_SHOW_SHIPPING_TIME_DESC','Die Lieferzeit wird angezeigt.'.$yes_no);
define('PDF_SHOW_DESCRIPTION_TITLE','Soll die Produkt-Beschreibung angezeigt werden?');
define('PDF_SHOW_DESCRIPTION_DESC','Die Produkt-Beschreibung wird angezeigt.'.$yes_no);
define('PDF_SHOW_SHORT_DESCRIPTION_TITLE','Soll die Produkt-Kurz-Beschreibung angezeigt werden?');
define('PDF_SHOW_SHORT_DESCRIPTION_DESC','Die Produkt-Kurz-Beschreibung wird angezeigt.'.$yes_no);
define('PDF_SHOW_MANUFACTURER_TITLE','Soll der Hersteller angezeigt werden?');
define('PDF_SHOW_MANUFACTURER_DESC','Der Hersteller wird angezeigt.'.$yes_no);
define('PDF_SHOW_PRICE_TITLE','Soll der Preis angezeigt werden?');
define('PDF_SHOW_PRICE_DESC','Der Preis wird angezeigt.'.$yes_no);
define('PDF_SHOW_SPECIALS_PRICE_TITLE','Soll der Sonder-Preis angezeigt werden?');
define('PDF_SHOW_SPECIALS_PRICE_DESC','Der Sonder-Preis wird angezeigt.'.$yes_no);
define('PDF_SHOW_SPECIALS_PRICE_EXPIRES_TITLE','Soll das Ablauf-Datum eines Sonder-Preises angezeigt werden?');
define('PDF_SHOW_SPECIALS_PRICE_EXPIRES_DESC','Das Ablauf-Datum eines Sonder-Preises wird angezeigt.'.$yes_no);
define('PDF_SHOW_OPTIONS_TITLE','Sollen die Produkt-Optionen angezeigt werden?');
define('PDF_SHOW_OPTIONS_DESC','Die Produkt-Optionen werden angezeigt.'.$yes_no);
define('PDF_SHOW_OPTIONS_PRICE_TITLE','Soll der Preis angezeigt werden?');
define('PDF_SHOW_OPTIONS_PRICE_DESC','Der Preis wird angezeigt.'.$yes_no);
define('PDF_SHOW_OPTIONS_VERTICAL_TITLE','Sollen die Produkt-Optionen vertikal angezeigt werden?');
define('PDF_SHOW_OPTIONS_VERTICAL_DESC','Die Produkt-Optionen werden vertikal angezeigt.'.$yes_no);
define('PDF_SHOW_DATE_ADDED_AVAILABLE_TITLE','Soll das Aufnahmedatum in den Katalog angezeigt werden?');
define('PDF_SHOW_DATE_ADDED_AVAILABLE_DESC','Das Aufnahmedatum in den Katalog wird angezeigt.'.$yes_no);
$bg_color_text='Die Hintergrund-Farbe ';
$txt_color_text='Die Text-Farbe ';
define('PDF_PAGE_BG_COLOR_TITLE',$bg_color_text.'des Datenblatts.');
$color_text=' Fügen Sie einen CSS-Farbnamen (z.B. "black" oder "floralwhite") oder einen kommaseparierten RGB-Farbwert (Rot,Grün,Blau). Die Farbwerte können die Werte 0-255 annehmen.';
define('PDF_PAGE_BG_COLOR_DESC',PDF_PAGE_BG_COLOR_TITLE.$color_text);
define('PDF_HEADER_COLOR_TABLE_TITLE',$bg_color_text.'der Kopfzeilen-Tabelle');
define('PDF_HEADER_COLOR_TABLE_DESC',PDF_HEADER_COLOR_TABLE_TITLE.$color_text);
define('PDF_HEADER_COLOR_TEXT_TITLE',$txt_color_text.'Datenblatt-Kopfes');
define('PDF_HEADER_COLOR_TEXT_DESC',PDF_HEADER_COLOR_TEXT_TITLE.$color_text);
define('PDF_BODY_COLOR_TEXT_TITLE',$txt_color_text.'im Datenblatt-Kopf.');
define('PDF_BODY_COLOR_TEXT_DESC',PDF_BODY_COLOR_TEXT_TITLE.$color_text);
define('PDF_PRODUCT_NAME_COLOR_TABLE_TITLE',$bg_color_text.'des Produktnamens');
define('PDF_PRODUCT_NAME_COLOR_TABLE_DESC',PDF_PRODUCT_NAME_COLOR_TABLE_TITLE.$color);
define('PDF_PRODUCT_NAME_COLOR_TEXT_TITLE',$txt_color_text.'des Produktnamens');
define('PDF_PRODUCT_NAME_COLOR_TEXT_DESC',PDF_PRODUCT_NAME_COLOR_TEXT_TITLE.$color);
define('PDF_FOOTER_CELL_BG_COLOR_TITLE',$bg_color_text.'der Fußzeile');
define('PDF_FOOTER_CELL_BG_COLOR_DESC',PDF_FOOTER_CELL_BG_COLOR_TITLE.$color);
define('PDF_FOOTER_CELL_TEXT_COLOR_TITLE',$txt_color_text.'der Fußzeile');
define('PDF_FOOTER_CELL_TEXT_COLOR_DESC',PDF_FOOTER_CELL_TEXT_COLOR_TITLE.$color);
define('PDF_SPECIAL_PRICE_COLOR_TEXT_TITLE',$bg_color_text.'des Sonderpreises');
define('PDF_SPECIAL_PRICE_COLOR_TEXT_DESC',PDF_FOOTER_CELL_BG_COLOR_TITLE.$color);
define('PDF_PAGE_WATERMARK_COLOR_TITLE',$txt_color_text.'im '.rtrim($watermark_text));
define('PDF_PAGE_WATERMARK_COLOR_DESC',PDF_FOOTER_CELL_BG_COLOR_TITLE.$color);
define('PDF_OPTIONS_COLOR_TITLE',$txt_color_text.'der Artikel-Optionen');
define('PDF_OPTIONS_COLOR_DESC',PDF_FOOTER_CELL_BG_COLOR_TITLE.$color);
define('PDF_OPTIONS_BG_COLOR_TITLE',$bg_color_text.'der Artikel-Optionen');
define('PDF_OPTIONS_BG_COLOR_DESC',PDF_OPTIONS_BG_COLOR_TITLE.$color);

//PDF-Rechnung
define('PDF_INVOICE_ORDER_CONFIRMATION_TITLE','Bestellbestätigung auch als PDF senden');
define('PDF_INVOICE_ORDER_CONFIRMATION_DESC',
'Die Bestellbestätigung zusätzlich als PDF-Datei im Anhang an die Bestätigungs-eMail senden');
define('PDF_INVOICE_MARK_COLOR_TITLE','Textfarbe für markierte Bereiche');
define('PDF_INVOICE_MARK_COLOR_DESC',PDF_INVOICE_MARK_COLOR_TITLE);
define('PDF_INVOICE_MARK_COLOR_BG_TITLE','Hintergrundfarbe für markierte Bereiche');
define('PDF_INVOICE_MARK_COLOR_BG_DESC',PDF_INVOICE_MARK_COLOR_TITLE);
$bank='Bank-';
define('STORE_BANK_NAME_TITLE',$bank.'Name');
$the_shop=' des Shops';
$the_bank=' der Bank'.$the_shop;
define('STORE_BANK_NAME_DESC','Der Name'.$the_bank);
define('STORE_BANK_BLZ_TITLE',$bank.'Blz');
$the_bank_inland=$the_bank.' (wird für Inlandskunden verwendet)';
define('STORE_BANK_BLZ_DESC','Die Bankleitzahl'.$the_bank_inland);
define('STORE_BANK_ACCOUNT_TITLE',$bank.'Konto');
define('STORE_BANK_ACCOUNT_DESC','Die Konto-Nummer'.$the_bank_inland);
$the_bank_ausland=$the_bank.' (wird für Auslandskunden verwendet)';
define('STORE_BANK_BIC_TITLE',$bank.'BIC');
define('STORE_BANK_BIC_DESC','Die BIC-Nummer'.$the_bank_ausland);
define('STORE_BANK_IBAN_TITLE',$bank.'IBAN');
define('STORE_BANK_IBAN_DESC','Die IBAN-Nummer'.$the_bank_ausland);
define('STORE_USTID_TITLE','Umsatzsteuer-Id');
define('STORE_USTID_DESC','Die '.STORE_USTID_TITLE.$the_shop);
define('STORE_TAXNR_TITLE','Steuer-Nummer');
define('STORE_TAXNR_DESC','Die '.STORE_TAXNR_TITLE.$the_shop.' (Nur notwendig, wenn keine '.STORE_USTID_TITLE.' vorhanden ist.)');
$only=' (Nur notwendig für im Handelsregister eingetragene Firmen.)';
$of_the_shop=' des Shops';
define('STORE_REGISTER_TITLE','Registergericht');
define('STORE_REGISTER_DESC','Das '.STORE_REGISTER_TITLE.',bei dem die Firma registriert ist.'.$only);
define('STORE_REGISTER_NR_TITLE','Die Handelsregister-Nummer'.$of_the_shop);
define('STORE_REGISTER_NR_DESC',STORE_REGISTER_NR_TITLE.' (z.B. HRA 1234)'.$only);
define('STORE_MANAGER_TITLE','Geschäftsführer');
define('STORE_MANAGER_DESC','Der Geschäftsführer'.$of_the_shop.$only);
define('STORE_DIRECTOR_TITLE','Director(s)');
define('STORE_DIRECTOR_DESC','The director(s)'.$of_the_shop.$only);
define('STORE_INVOICE_NUMBER_TITLE','Rechnungs-Nummer');
define('STORE_INVOICE_NUMBER_DESC','Die laufende '.STORE_INVOICE_NUMBER_TITLE.$of_the_shop);
define('STORE_PACKINGSLIP_NUMBER_TITLE','Lieferschein-Nummer');
define('STORE_PACKINGSLIP_NUMBER_DESC','Die laufende '.STORE_INVOICE_NUMBER_TITLE.$of_the_shop);

define('PRODUCT_IMAGE_ON_THE_FLY_TITLE','Produktbilder "On-the-fly" erstellen');
define('PRODUCT_IMAGE_ON_THE_FLY_DESC','Die Produktbilder werden dynamisch beim Aufruf erstellt, und nicht mehr statisch abgespeichert (ausser dem Originalbild)');

define('CRON_JOBS_LIST_TITLE', 'Automatische Skript-Ausführung ("Cron-Jobs")');
define('CRON_JOBS_LIST_DESC', '
Es können Skripte definiert werden, die zu bestimmten Zeiten wiederholt ausgeführt werden sollen.
<br/><br/>
Beispiele:
<br/><br/>
<b>Starte Skript immer um 14:15</b><br/>
admin/import.php?file=http://www.meinlieferant1.de/produkte.csv,14:15<br/><br/>
<b>Starte Skript Montags, Mittwochs und Freitags um 20:00</b><br/>
admin/import.php?file=http://www.meinlieferant2.de/produkte.csv,Montag/Mittwoch/Freitag,20:00<br/><br/>
<b>Starte Skript alle 120 Minuten</b><br/>
admin/import.php?file=http://www.meinlieferant3.de/produkte.csv,120
<br/><br/>
Der Pfad des Skriptes muss relativ zum Shop-Verzeichnis angegeben werden!'
);

define('SPIDER_FOOD_ROWS_TITLE','Anzahl Produkte mit erweiterten Suchmaschinen-Daten');
define('SPIDER_FOOD_ROWS_DESC','Hier kann man besonders "<b>leckere Köder</b>" für Suchmaschinen bereit stellen!<br/><br/>Suchmaschinen bewerten Suchworte besonders gut, die in den HTML-Elementen "TITLE", "METATAGS", "H1", "H2", "Links" und "Image"-Namen vorkommen. Man kann hier angeben, für wie viele Produkte <b>beim Besuch einer Suchmaschine(!)</b> solche Informationen in jede Seite eingebaut werden sollen. (Die dargestellten Produkte werden bei jedem Aufruf zufällig ausgewählt.)');

define('VISITOR_PDF_CATALOGUE_TITLE','Ausdruck des PDF-Katalogs durch Besucher erlauben');
define('VISITOR_PDF_CATALOGUE_DESC','Besucher können einen Produkt-Katalog im PDF-Format ausdrucken. (Bei vielen Produkten sollte diese Funktion nicht aktiviert werden, da diese sehr resourcenhungrig ist.)');

$title='Anzahl Bilder pro # in der Produkt-Galerie';
$desc='Hiermit kann man festlegen, wie viel Bilder pro # in der Produkt-Galerie angezeigt werden sollen';
$page='Seite';
$line='Zeile';
define('GALLERY_PICTURES_PER_PAGE_TITLE',str_replace(HASH,$page,$title));
define('GALLERY_PICTURES_PER_PAGE_DESC',str_replace(HASH,$page,$desc));
define('GALLERY_PICTURES_PER_LINE_TITLE',str_replace(HASH,$line,$title));
define('GALLERY_PICTURES_PER_LINE_DESC',str_replace(HASH,$line,$desc));

define('USE_COOL_MENU_TITLE','"Cool-Menue" verwenden');
define('USE_COOL_MENU_DESC','Anstelle des Standard-OL-Commerce-Menüs kann ein dynamisches DHTML-Menü verwendet werden, das die Einträge hierarchisch gliedert, und beim Darüberfahren mit der Maus sukzessive aufklappt. (Bei vielen Kategorien ist das meist platzsparender.)');

define('OPEN_ALL_MENUE_LEVELS_TITLE','Alle Menü-Einträge "aufklappen"');
define('OPEN_ALL_MENUE_LEVELS_DESC','Beim Standard-OL-Commerce-Menü(!) kann man alle Kategorien und Unterkategorien immer alle aufgeklappt anzeigen lassen.');

define('EBAY_FUNCTIONS_INCLUDE_TITLE','eBay-Konnektor aktivieren');
define('EBAY_FUNCTIONS_INCLUDE_DESC','Der eBay-Konnektor wird aktiviert, so dass eBay-Auktionen/eBay-Express-Verkäufe eingestellt werden, und eBay-Bestellungen übernommen werden können');

define('EBAY_TEST_MODE_TITLE','eBay-Konnektor im Testmodus betreiben');
define('EBAY_TEST_MODE_DESC','Wenn der eBay-Konnektor im Testmodus betrieben wird, werden keine echten Auktionen erstellt, sondern nur in der ebay-Testumgebung ("Sandbox")');
define('EBAY_REAL_SHOP_URL_TITLE','Die Internet-Adresse Ihres Online-Shops');
define('EBAY_REAL_SHOP_URL_DESC','Man benötigt die echte Shop-Adresse, damit eBay Zugriff auf die Bilder (und andere Elemente) haben kann.');
define('EBAY_MEMBER_NAME_TITLE','Ihr eBay-Mitgliedes-Name');
define('EBAY_MEMBER_NAME_DESC','Der eBay-Mitgliedes-Name, mit dem Sie sich bei eBay anmelden');
define('EBAY_EBAY_EXPRESS_ONLY_TITLE','Produkte nur in eBay-Express einstellen');
define('EBAY_EBAY_EXPRESS_ONLY_DESC','Es werden keine Auktionen erstellt, sondern nur eBay-Express Verkäufe');
define('EBAY_SHIPPING_MODULE_TITLE','Die Versand-Methode für eBay-Bestellungen');
define('EBAY_SHIPPING_MODULE_DESC',EBAY_SHIPPING_MODULE_TITLE.' (Das ist der <b>interne</b> Name eines der installierten Versand-Module: "<b>Modulname (für internen Gebrauch)</b>")');
define('EBAY_PAYPAL_EMAIL_ADDRESS_TITLE','Ihre eMail-Adresse für PayPal-Zahlungen');
define('EBAY_PAYPAL_EMAIL_ADDRESS_DESC','Wenn Sie Zahlungen per PayPal akzeptieren (für eBay-Express ein "Muss"), geben Sie hier Ihre eMail-Adresse für Ihr PayPal-Konto an');

$ebay='eBay-"';
$for='" für den Test-Modus';
$assigned=' Ihnen von eBay zugwiesene "';
$the_assigned='Der'.$assigned;
$that_assigned='Das'.$assigned;
$devid='DEVID';
$appid='APPID';
$certid='CERTID';
$token='TOKEN';
define('EBAY_TEST_MODE_DEVID_TITLE',$ebay.$devid.$for);
define('EBAY_TEST_MODE_DEVID_DESC',$the_assigned.$devid.$for);
define('EBAY_TEST_MODE_APPID_TITLE',$ebay.$appid.$for);
define('EBAY_TEST_MODE_APPID_DESC',$the_assigned.$appid.$for);
define('EBAY_TEST_MODE_CERTID_TITLE',$ebay.$certid.$for);
define('EBAY_TEST_MODE_CERTID_DESC',$the_assigned.$certid.$for);
define('EBAY_TEST_MODE_TOKEN_TITLE',$ebay.$token.$for);
define('EBAY_TEST_MODE_TOKEN_DESC',$that_assigned.$token.$for);
$for='" für den Produktions-Modus';
define('EBAY_PRODUCTION_DEVID_TITLE',$ebay.$devid.$for);
define('EBAY_PRODUCTION_DEVID_DESC',$the_assigned.$devid.$for);
define('EBAY_PRODUCTION_APPID_TITLE',$ebay.$appid.$for);
define('EBAY_PRODUCTION_APPID_DESC',$the_assigned.$appid.$for);
define('EBAY_PRODUCTION_CERTID_TITLE',$ebay.$certid.$for);
define('EBAY_PRODUCTION_CERTID_DESC',$the_assigned.$certid.$for);
define('EBAY_PRODUCTION_TOKEN_TITLE',$ebay.$token.$for);
define('EBAY_PRODUCTION_TOKEN_DESC',$that_assigned.$token.$for);

if (SHOW_AFFILIATE)
{
	// inclusion for affiliate program
	include('affiliate_configuration.php');
}
?>