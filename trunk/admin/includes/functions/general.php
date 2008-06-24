<?php
/* --------------------------------------------------------------
$Id: general.php,v 1.35 2003/08/13 23:38:04 mbs Exp

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.156 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (general.php,v 1.35 2003/08/1); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contributions:

Customers Status v3.x (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

Enable_Disable_Categories 1.3                Autor: Mikel Williams | mikel@ladykatcostumes.com

Category Descriptions (Version: 1.5 MS2)    Original Author:   Brian Lowe <blowe@wpcusrgrp.org> | Editor: Lord Illicious <shaolin-venoms@illicious.net>

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

Released under the GNU General Public License
--------------------------------------------------------------*/


//W. Kaiser - AJAX (Nothing to do with AJAX, just a reminder to copy!!)
include_once(DIR_FS_INC.'olc_add_tax.inc.php');
include_once(DIR_FS_INC.'olc_format_price.inc.php');

function clear_string($value) {

	$string=str_replace(APOS, EMPTY_STRING,$value);
	$string=str_replace(RPAREN, EMPTY_STRING,$string);
	$string=str_replace('(', EMPTY_STRING,$string);
	$array=explode(',',$string);
	return $array;
}

function check_stock($products_id) {
	if (STOCK_CHECK == TRUE_STRING_S) {
		$stock_flag =  EMPTY_STRING;
		$stock_query =
		olc_db_query("SELECT products_quantity FROM " . TABLE_PRODUCTS . SQL_WHERE."products_id = '" . $products_id . APOS);
		$stock_values = olc_db_fetch_array($stock_query);
		if ($stock_values['products_quantity'] <= '0') {
			$stock_flag = TRUE_STRING_S;
			$stock_warn = TEXT_WARN_MAIN;
		}

		$attribute_stock_query = olc_db_query("SELECT attributes_stock FROM " . TABLE_PRODUCTS_ATTRIBUTES . "
		where products_id = '" . $products_id . APOS);
		while ($attribute_stock_values = olc_db_fetch_array($attribute_stock_query)) {
			if ($attribute_stock_values['attributes_stock'] <= '0') {
				$stock_flag = TRUE_STRING_S;
				$stock_warn .= TEXT_WARN_ATTRIBUTE;
			}
		}
		if ($stock_flag == TRUE_STRING_S && $products_id !=  EMPTY_STRING) {
			return '<td class="dataTableContent">' . olc_image(DIR_WS_IMAGES . 'icon_status_red.gif',
			IMAGE_ICON_STATUS_GREEN, 10, 10) . BLANK . $stock_warn . '</td>';
		} else {
			return '<td class="dataTableContent">' . olc_image(DIR_WS_IMAGES . 'icon_status_green.gif',
			IMAGE_ICON_STATUS_GREEN, 10, 10) . '</td>';
		}
	}
}

// Set Categorie Status
function olc_set_categories_status($categories_id, $status) {
	return olc_db_query(SQL_UPDATE . TABLE_CATEGORIES . " set categories_status = '".$status."'
	where categories_id = '" . $categories_id . APOS);
	/*
	if ($status == '1') {
	return olc_db_query(SQL_UPDATE . TABLE_CATEGORIES . " set categories_status = '1' where categories_id = '" .
	$categories_id . APOS);
	} elseif ($status == '0') {
	return olc_db_query(SQL_UPDATE . TABLE_CATEGORIES . " set categories_status = '0' where categories_id = '" .
	$categories_id . APOS);
	} else {
	return -1;
	}
	*/
}

function olc_set_groups($categories_id,$shops) {

	// get products in categorie
	$products_query=olc_db_query("SELECT products_id FROM ".TABLE_PRODUCTS_TO_CATEGORIES."
	where categories_id='".$categories_id.APOS);
	while ($products=olc_db_fetch_array($products_query)) {
		olc_db_query(SQL_UPDATE.TABLE_PRODUCTS." SET group_ids='".$shops."'
		where products_id='".$products['products_id'].APOS);
	}
	// set status of categorie
	olc_db_query(SQL_UPDATE . TABLE_CATEGORIES . " set group_ids = '".$shops."'
	where categories_id = '" . $categories_id . APOS);
	// look for deeper categories and go rekursiv
	$categories_query=olc_db_query("SELECT categories_id FROM ".TABLE_CATEGORIES."
	where parent_id='".$categories_id.APOS);
	while ($categories=olc_db_fetch_array($categories_query)) {
		olc_set_groups($categories['categories_id'],$shops);
	}

}

function olc_set_categories_rekursiv($categories_id,$status) {

	// get products in categorie
	$products_query=olc_db_query("SELECT products_id FROM ".TABLE_PRODUCTS_TO_CATEGORIES.SQL_WHERE."categories_id='".$categories_id.APOS);
	while ($products=olc_db_fetch_array($products_query)) {
		olc_db_query(SQL_UPDATE.TABLE_PRODUCTS." SET products_status='".$status."' where products_id='".
		$products['products_id'].APOS);
	}
	// set status of categorie
	olc_db_query(SQL_UPDATE . TABLE_CATEGORIES . " set categories_status = '".$status."' where categories_id = '" .
	$categories_id . APOS);
	// look for deeper categories and go rekursiv
	$categories_query=olc_db_query("SELECT categories_id FROM ".TABLE_CATEGORIES.SQL_WHERE."parent_id='".$categories_id.APOS);
	while ($categories=olc_db_fetch_array($categories_query)) {
		olc_set_categories_rekursiv($categories['categories_id'],$status);
	}

}

// Set Admin Access Rights
function olc_set_admin_access($fieldname, $status, $cID) {
	return olc_db_query(SQL_UPDATE . TABLE_ADMIN_ACCESS . " set " . $fieldname . " = '".$status."'
	where customers_id = '" . $cID . APOS);
}

// Check whether a referer has enough permission to open an admin page
function olc_check_permission($pagename)
{
	if (CUSTOMER_IS_ADMIN)
	{
		if ($pagename!='index')
		{
			$access_permission_query = olc_db_query(SELECT . $pagename . SQL_FROM . TABLE_ADMIN_ACCESS .
			SQL_WHERE."customers_id = '" .CUSTOMER_ID . APOS);
			$access_permission = olc_db_fetch_array($access_permission_query);
			$return=$access_permission[$pagename] == '1';
			//	} else {
			//		olc_redirect(olc_href_link(FILENAME_LOGIN));
		}
		else
		{
			$return=true;
		}
	}
	return $return;
}

require_once(DIR_FS_INC.'olc_redirect.inc.php');
/*
////
// Redirect to another page or site
function olc_redirect($url) {
global $logger;

header('Location: ' . $url);

if (STORE_PAGE_PARSE_TIME == TRUE_STRING_S) {
if (!is_object($logger)) $logger = new logger;
$logger->timer_stop();
}

exit;
}
*/

function olc_customers_name($customers_id) {
	$customers = olc_db_query(SELECT."customers_firstname, customers_lastname".SQL_FROM . TABLE_CUSTOMERS .
	SQL_WHERE."customers_id = '" . $customers_id . APOS);
	$customers_values = olc_db_fetch_array($customers);

	return $customers_values['customers_firstname'] . BLANK . $customers_values['customers_lastname'];
}

function olc_get_path($current_category_id = '') {
	global $cPath_array;

	if ($current_category_id ==  EMPTY_STRING) {
		$cPath_new = implode('_', $cPath_array);
	} else {
		if (sizeof($cPath_array) == 0) {
			$cPath_new = $current_category_id;
		} else {
			$cPath_new =  EMPTY_STRING;
			$last_category_query = olc_db_query(SELECT."parent_id".SQL_FROM . TABLE_CATEGORIES .
			SQL_WHERE."categories_id = '" . $cPath_array[(sizeof($cPath_array)-1)] . APOS);
			$last_category = olc_db_fetch_array($last_category_query);
			$current_category_query = olc_db_query(SELECT."parent_id".SQL_FROM . TABLE_CATEGORIES .
			SQL_WHERE."categories_id = '" . $current_category_id . APOS);
			$current_category = olc_db_fetch_array($current_category_query);
			if ($last_category['parent_id'] == $current_category['parent_id']) {
				for ($i = 0, $n = sizeof($cPath_array) - 1; $i < $n; $i++) {
					$cPath_new .= '_' . $cPath_array[$i];
				}
			} else {
				for ($i = 0, $n = sizeof($cPath_array); $i < $n; $i++) {
					$cPath_new .= '_' . $cPath_array[$i];
				}
			}
			$cPath_new .= '_' . $current_category_id;
			if (substr($cPath_new, 0, 1) == '_') {
				$cPath_new = substr($cPath_new, 1);
			}
		}
	}

	return 'cPath=' . $cPath_new;
}

function olc_get_all_get_params($exclude_array = '') {

	if ($exclude_array ==  EMPTY_STRING) $exclude_array = array();

	$get_url = EMPTY_STRING;

	reset($_GET);
	while (list($key, $value) = each($_GET)) {
		if (($key != session_name()) && ($key != 'error') && (!olc_in_array($key, $exclude_array)))
		$get_url .= $key . '=' . $value . '&';
	}

	return $get_url;
}

function olc_date_long($raw_date) {
	if ( ($raw_date == '0000-00-00 00:00:00') || ($raw_date ==  EMPTY_STRING) ) return false;

	$year = (int)substr($raw_date, 0, 4);
	$month = (int)substr($raw_date, 5, 2);
	$day = (int)substr($raw_date, 8, 2);
	$hour = (int)substr($raw_date, 11, 2);
	$minute = (int)substr($raw_date, 14, 2);
	$second = (int)substr($raw_date, 17, 2);

	return strftime(DATE_FORMAT_LONG, mktime($hour, $minute, $second, $month, $day, $year));
}

////
// Output a raw date string in the selected locale date format
// $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS
// NOTE: Includes a workaround for dates before 01/01/1970 that fail on windows servers
function olc_date_short($raw_date) {
	if ( ($raw_date == '0000-00-00 00:00:00') || ($raw_date ==  EMPTY_STRING) ) return false;

	$year = substr($raw_date, 0, 4);
	$month = (int)substr($raw_date, 5, 2);
	$day = (int)substr($raw_date, 8, 2);
	$hour = (int)substr($raw_date, 11, 2);
	$minute = (int)substr($raw_date, 14, 2);
	$second = (int)substr($raw_date, 17, 2);

	if (@date('Y', mktime($hour, $minute, $second, $month, $day, $year)) == $year) {
		return date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, $year));
	} else {
		return ereg_replace('2037' . '$', $year, date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, 2037)));
	}

}

function olc_datetime_short($raw_datetime) {
	if ( ($raw_datetime == '0000-00-00 00:00:00') || ($raw_datetime ==  EMPTY_STRING) ) return false;

	$year = (int)substr($raw_datetime, 0, 4);
	$month = (int)substr($raw_datetime, 5, 2);
	$day = (int)substr($raw_datetime, 8, 2);
	$hour = (int)substr($raw_datetime, 11, 2);
	$minute = (int)substr($raw_datetime, 14, 2);
	$second = (int)substr($raw_datetime, 17, 2);

	return strftime(DATE_TIME_FORMAT, mktime($hour, $minute, $second, $month, $day, $year));
}

function olc_array_merge($array1, $array2, $array3 = '') {
	if ($array3 ==  EMPTY_STRING) $array3 = array();
	if (function_exists('array_merge')) {
		$array_merged = array_merge($array1, $array2, $array3);
	} else {
		while (list($key, $val) = each($array1)) $array_merged[$key] = $val;
		while (list($key, $val) = each($array2)) $array_merged[$key] = $val;
		if (sizeof($array3) > 0) while (list($key, $val) = each($array3)) $array_merged[$key] = $val;
	}

	return (array) $array_merged;
}

include_once(DIR_FS_INC.'olc_in_array.inc.php');
/*
function olc_in_array($lookup_value, $lookup_array) {
if (function_exists('in_array')) {
if (in_array($lookup_value, $lookup_array)) return true;
} else {
reset($lookup_array);
while (list($key, $value) = each($lookup_array)) {
if ($value == $lookup_value) return true;
}
}

return false;
}
*/

function olc_get_category_tree($parent_id = '0', $spacing = '', $exclude = '', $category_tree_array = '', $include_itself = false) {

	if (!is_array($category_tree_array)) $category_tree_array = array();
	if ( (sizeof($category_tree_array) < 1) && ($exclude != '0') )
	{
		$category_tree_array[] = array('id' => '0', 'text' => TEXT_TOP);
	}
	if ($include_itself)
	{
		$category_query = olc_db_query(SELECT."cd.categories_name".SQL_FROM .
		TABLE_CATEGORIES_DESCRIPTION . " cd
			where cd.language_id = '" . SESSION_LANGUAGE_ID . "' and cd.categories_id = '" . $parent_id . APOS);
		$category = olc_db_fetch_array($category_query);
		$category_tree_array[] = array('id' => $parent_id, 'text' => $category['categories_name']);
	}
	$spacer=HTML_NBSP.HTML_NBSP.HTML_NBSP;
	$categories_query = olc_db_query(SELECT."c.categories_id, cd.categories_name, c.parent_id".SQL_FROM . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = " . SESSION_LANGUAGE_ID . " and c.parent_id = " . $parent_id . " order by c.sort_order, cd.categories_name");
	while ($categories = olc_db_fetch_array($categories_query))
	{
		$categories_id=$categories['categories_id'];
		if ($exclude != $categories_id)
		{
			$category_tree_array[] = array('id' => $categories_id, 'text' => $spacing . $categories['categories_name']);
		}
		$category_tree_array = olc_get_category_tree($categories_id, $spacing . $spacer,
		$exclude, $category_tree_array);
	}
	return $category_tree_array;
}

function olc_draw_products_pull_down($name, $parameters = '', $exclude = '') {
	global $currencies;

	if ($exclude ==  EMPTY_STRING) {
		$exclude = array();
	}
	$select_string = '<select name="' . $name . QUOTE;
	if ($parameters) {
		$select_string .= BLANK . $parameters;
	}
	$select_string .= '>';
	$products_query = olc_db_query(SELECT."p.products_id, pd.products_name,p.products_tax_class_id, p.products_price".SQL_FROM .
	TABLE_PRODUCTS . " p, " .
	TABLE_PRODUCTS_DESCRIPTION . " pd
	where p.products_id = pd.products_id and pd.language_id = " . SESSION_LANGUAGE_ID . " order by products_name");
	while ($products = olc_db_fetch_array($products_query)) {
		if (!olc_in_array($products['products_id'], $exclude)) {
			//brutto admin:
			if (PRICE_IS_BRUTTO==TRUE_STRING_S){
				$products['products_price'] = olc_round($products['products_price']*
				((100+olc_get_tax_rate($products['products_tax_class_id']))/100),PRICE_PRECISION);
			}
			$select_string .= '<option value="' . $products['products_id'] . '">' .
			$products['products_name'] . LPAREN . olc_format_price($products['products_price'],1,1) . ')</option>';
		}
	}
	$select_string .= '</select>';
	return $select_string;
}

function olc_options_name($options_id) {

	$options = olc_db_query(SELECT."products_options_name".SQL_FROM . TABLE_PRODUCTS_OPTIONS .
	SQL_WHERE."products_options_id = '" . $options_id . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
	$options_values = olc_db_fetch_array($options);

	return $options_values['products_options_name'];
}

function olc_values_name($values_id) {

	$values = olc_db_query(SELECT."products_options_values_name".SQL_FROM . TABLE_PRODUCTS_OPTIONS_VALUES . SQL_WHERE."products_options_values_id = '" . $values_id . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
	$values_values = olc_db_fetch_array($values);

	return $values_values['products_options_values_name'];
}

function olc_info_image($image, $alt, $width = '', $height = '') {
	if ( ($image) && (file_exists(DIR_FS_CATALOG_IMAGES . $image)) ) {
		$image = olc_image(DIR_WS_CATALOG_IMAGES . $image, $alt, $width, $height);
	} else {
		$image = TEXT_IMAGE_NONEXISTENT;
	}

	return $image;
}

function olc_info_image_c($image, $alt, $width = '', $height = '') {
	if ( ($image) && (file_exists(DIR_FS_CATALOG_IMAGES .'categories/'. $image)) ) {
		$image = olc_image(DIR_WS_CATALOG_IMAGES .'categories/'. $image, $alt, $width, $height);
	} else {
		$image = TEXT_IMAGE_NONEXISTENT;
	}

	return $image;
}

function olc_product_info_image($image, $alt, $width = '', $height = '') {
	if ( ($image) && (file_exists(DIR_FS_CATALOG_INFO_IMAGES . $image)) ) {
		$image = olc_image(DIR_WS_CATALOG_INFO_IMAGES . $image, $alt, $width, $height);
	} else {
		$image = TEXT_IMAGE_NONEXISTENT;
	}

	return $image;
}

function olc_break_string($string, $len, $break_char = '-') {
	$l = 0;
	$output =  EMPTY_STRING;
	for ($i = 0; $i < strlen($string); $i++) {
		$char = substr($string, $i, 1);
		if ($char != BLANK) {
			$l++;
		} else {
			$l = 0;
		}
		if ($l > $len) {
			$l = 1;
			$output .= $break_char;
		}
		$output .= $char;
	}

	return $output;
}

function olc_get_country_name($country_id) {
	$country_query = olc_db_query(SELECT."countries_name".SQL_FROM . TABLE_COUNTRIES .
	SQL_WHERE."countries_id = '" . $country_id . APOS);

	if (olc_db_num_rows($country_query)) {
		$country = olc_db_fetch_array($country_query);
		return $country['countries_name'];
	} else {
		return $country_id;
	}
}

function olc_get_zone_name($country_id, $zone_id, $default_zone="") {
	$zone_query = olc_db_query(SELECT."zone_name".SQL_FROM . TABLE_ZONES .
	SQL_WHERE."zone_country_id = '" . $country_id . "' and zone_id = '" . $zone_id . APOS);
	if (olc_db_num_rows($zone_query)) {
		$zone = olc_db_fetch_array($zone_query);
		return $zone['zone_name'];
	} else {
		return $default_zone;
	}
}


function olc_browser_detect($component) {

	return stristr($_SERVER['HTTP_USER_AGENT'], $component);
}

function olc_tax_classes_pull_down($parameters, $selected = '')
{
	$select_string = '<select ' . $parameters . '>';
	$classes_query = olc_db_query(SELECT."tax_class_id, tax_class_title".SQL_FROM . TABLE_TAX_CLASS .
	" order by tax_class_title");
	while ($classes = olc_db_fetch_array($classes_query)) {
		$select_string .= '<option value="' . $classes['tax_class_id'] . QUOTE;
		if ($selected == $classes['tax_class_id']) $select_string .= ' SELECTED';
		$select_string .= '>' . $classes['tax_class_title'] . '</option>';
	}
	$select_string .= '</select>';

	return $select_string;
}

function olc_geo_zones_pull_down($parameters, $selected = '') {
	$select_string = '<select ' . $parameters . '>';
	$zones_query = olc_db_query(SELECT."geo_zone_id, geo_zone_name".SQL_FROM . TABLE_GEO_ZONES . " order by geo_zone_name");
	while ($zones = olc_db_fetch_array($zones_query)) {
		$select_string .= '<option value="' . $zones['geo_zone_id'] . QUOTE;
		if ($selected == $zones['geo_zone_id']) $select_string .= ' SELECTED';
		$select_string .= '>' . $zones['geo_zone_name'] . '</option>';
	}
	$select_string .= '</select>';

	return $select_string;
}

function olc_get_geo_zone_name($geo_zone_id) {
	$zones_query = olc_db_query(SELECT."geo_zone_name".SQL_FROM . TABLE_GEO_ZONES . SQL_WHERE."geo_zone_id = '" . $geo_zone_id . APOS);

	if (!olc_db_num_rows($zones_query)) {
		$geo_zone_name = $geo_zone_id;
	} else {
		$zones = olc_db_fetch_array($zones_query);
		$geo_zone_name = $zones['geo_zone_name'];
	}

	return $geo_zone_name;
}

function olc_address_format($address_format_id, $address, $html, $boln, $eoln)
{
	$address_format_query = olc_db_query(SELECT."address_format as format".SQL_FROM . TABLE_ADDRESS_FORMAT .
	SQL_WHERE."address_format_id = '" . $address_format_id . APOS);
	$address_format = olc_db_fetch_array($address_format_query);
	$company = addslashes($address['company']);
	$firstname = addslashes($address['firstname']);
	$cid = addslashes($address['csID']);
	$lastname = addslashes($address['lastname']);
	$street = addslashes($address['street_address']);
	$suburb = addslashes($address['suburb']);
	$city = addslashes($address['city']);
	$state = addslashes($address['state']);
	$country_id = $address['country_id'];
	$zone_id = $address['zone_id'];
	$postcode = addslashes($address['postcode']);
	$zip = $postcode;
	$country = olc_get_country_name($country_id);
	$state = olc_get_zone_code($country_id, $zone_id, $state);

	if ($html) {
		// HTML Mode
		$HR = HTML_HR;
		$hr = HTML_HR;
		if ( ($boln ==  EMPTY_STRING) && ($eoln == NEW_LINE) ) { // Values not specified, use rational defaults
			$CR = HTML_BR;
			$cr = HTML_BR;
			$eoln = $cr;
		} else { // Use values supplied
			$CR = $eoln . $boln;
			$cr = $CR;
		}
	} else {
		// Text Mode
		$CR = $eoln;
		$cr = $CR;
		$HR = '----------------------------------------';
		$hr = '----------------------------------------';
	}

	$statecomma =  EMPTY_STRING;
	$streets = $street;
	if ($suburb !=  EMPTY_STRING) $streets = $street . $cr . $suburb;
	if ($firstname ==  EMPTY_STRING) $firstname = addslashes($address['name']);
	if ($country ==  EMPTY_STRING) $country = addslashes($address['country']);
	if ($state !=  EMPTY_STRING) $statecomma = $state . ', ';

	$fmt = $address_format['format'];
	eval("\$address = \"$fmt\";");
	$address = stripslashes($address);

	if ( (ACCOUNT_COMPANY == TRUE_STRING_S) && (olc_not_null($company)) ) {
		$address = $company . $cr . $address;
	}

	return $address;
}

////////////////////////////////////////////////////////////////////////////////////////////////
//
// Function    : olc_get_zone_code
//
// Arguments   : country           country code string
//               zone              state/province zone_id
//               def_state         default string if zone==0
//
// Return      : state_prov_code   state/province code
//
// Description : Function to retrieve the state/province code (as in FL for Florida etc)
//
////////////////////////////////////////////////////////////////////////////////////////////////
function olc_get_zone_code($country, $zone, $def_state) {

	$state_prov_query = olc_db_query(SELECT."zone_code".SQL_FROM . TABLE_ZONES . SQL_WHERE."zone_country_id = '" . $country . "' and zone_id = '" . $zone . APOS);

	if (!olc_db_num_rows($state_prov_query)) {
		$state_prov_code = $def_state;
	}
	else {
		$state_prov_values = olc_db_fetch_array($state_prov_query);
		$state_prov_code = $state_prov_values['zone_code'];
	}

	return $state_prov_code;
}

function olc_get_uprid($prid, $params) {
	$uprid = $prid;
	if ( (is_array($params)) && (!strstr($prid, '{')) ) {
		while (list($option, $value) = each($params)) {
			$uprid = $uprid . '{' . $option . '}' . $value;
		}
	}

	return $uprid;
}

function olc_get_prid($uprid) {
	$pieces = explode ('{', $uprid);

	return $pieces[0];
}

function olc_get_languages() {
	$languages_query = olc_db_query(SELECT."languages_id, name, code, image, directory".SQL_FROM .
	TABLE_LANGUAGES . " order by sort_order");
	while ($languages = olc_db_fetch_array($languages_query)) {
		$languages_array[] = array('id' => $languages['languages_id'],
		'name' => $languages['name'],
		'code' => $languages['code'],
		'image' => $languages['image'],
		'directory' => $languages['directory']
		);
	}

	return $languages_array;
}

function olc_get_categories_name($category_id, $language_id) {
	return olc_get_categories_info("categories_name",$category_id, $language_id);
}

function olc_get_categories_heading_title($category_id, $language_id) {
	return olc_get_categories_info("categories_heading_title",$category_id, $language_id);
}

function olc_get_categories_description($category_id, $language_id) {
	return olc_get_categories_info("categories_description",$category_id, $language_id);
}

function olc_get_categories_meta_title($category_id, $language_id) {
	return olc_get_categories_info("categories_meta_title",$category_id, $language_id);
}

function olc_get_categories_meta_description($category_id, $language_id) {
	return olc_get_categories_info("categories_meta_description",$category_id, $language_id);
}

function olc_get_categories_meta_keywords($category_id, $language_id) {
	return olc_get_categories_info("categories_meta_keywords",$category_id, $language_id);
}

function olc_get_categories_info($field_name,$category_id, $language_id)
{
	if ($category_id)
	{
		if ($language_id == 0)
		{
			$language_id = SESSION_LANGUAGE_ID;
		}
		$category_query = olc_db_query(SELECT.$field_name.SQL_FROM . TABLE_CATEGORIES_DESCRIPTION .
		SQL_WHERE."categories_id=".$category_id." and language_id=".$language_id);
		$category = olc_db_fetch_array($category_query);
		$value=stripslashes($category[$field_name]);
		return str_replace('\\',EMPTY_STRING,$value);
	}
	else
	{
		return EMPTY_STRING;
	}
}

function olc_get_orders_status_name($orders_status_id, $language_id = '') {

	if (!$language_id) $language_id = SESSION_LANGUAGE_ID;
	$orders_status_query = olc_db_query(SELECT."orders_status_name".SQL_FROM . TABLE_ORDERS_STATUS .
	SQL_WHERE."orders_status_id = " . $orders_status_id . " and language_id = " . $language_id);
	$orders_status = olc_db_fetch_array($orders_status_query);

	return $orders_status['orders_status_name'];
}

function olc_get_shipping_status_name($shipping_status_id, $language_id = '') {

	if (!$language_id) $language_id = SESSION_LANGUAGE_ID;
	$shipping_status_query = olc_db_query(SELECT."shipping_status_name".SQL_FROM . TABLE_SHIPPING_STATUS .
	SQL_WHERE."shipping_status_id = " . $shipping_status_id . " and language_id = " . $language_id);
	$shipping_status = olc_db_fetch_array($shipping_status_query);

	return $shipping_status['shipping_status_name'];
}

function olc_get_orders_status() {

	$orders_status_array = array();
	$orders_status_query = olc_db_query(SELECT."orders_status_id, orders_status_name".SQL_FROM . TABLE_ORDERS_STATUS .
	SQL_WHERE."language_id = " . SESSION_LANGUAGE_ID . " order by orders_status_id");
	while ($orders_status = olc_db_fetch_array($orders_status_query)) {
		$orders_status_array[] = array('id' => $orders_status['orders_status_id'],
		'text' => $orders_status['orders_status_name']
		);
	}

	return $orders_status_array;
}

function olc_get_shipping_status() {

	$shipping_status_array = array();
	$shipping_status_query = olc_db_query(SELECT."shipping_status_id, shipping_status_name".SQL_FROM . TABLE_SHIPPING_STATUS .
	SQL_WHERE."language_id = " . SESSION_LANGUAGE_ID . " order by shipping_status_id");
	while ($shipping_status = olc_db_fetch_array($shipping_status_query)) {
		$shipping_status_array[] = array('id' => $shipping_status['shipping_status_id'],
		'text' => $shipping_status['shipping_status_name']
		);
	}

	return $shipping_status_array;
}

function olc_get_products_name($product_id, $language_id = 0) {
	return olc_get_products_description_info("products_name",$product_id, $language_id);
}

function olc_get_products_description($product_id, $language_id) {
	return olc_get_products_description_info("products_description",$product_id, $language_id);
}

function olc_get_products_short_description($product_id, $language_id) {
	return olc_get_products_description_info("products_short_description",$product_id, $language_id);
}

function olc_get_products_meta_title($product_id, $language_id) {
	return olc_get_products_description_info("products_meta_title",$product_id, $language_id);
}

function olc_get_products_meta_description($product_id, $language_id) {
	return olc_get_products_description_info("products_meta_description",$product_id, $language_id);
}

function olc_get_products_meta_keywords($product_id, $language_id) {
	return olc_get_products_description_info("products_meta_keywords",$product_id, $language_id);
}

function olc_get_products_url($product_id, $language_id)
{
	return olc_get_products_description_info("products_url",$product_id, $language_id);
}

function olc_get_products_description_info($field_name,$product_id, $language_id)
{
	if ($product_id)
	{
		if ($language_id == 0)
		{
			$language_id = SESSION_LANGUAGE_ID;
		}
		$product_query = olc_db_query(SELECT.$field_name.SQL_FROM . TABLE_PRODUCTS_DESCRIPTION .
		SQL_WHERE."products_id=".$product_id." and language_id=".$language_id);
		$product = olc_db_fetch_array($product_query);
		$value=stripslashes($product[$field_name]);
		return str_replace('\\',EMPTY_STRING,$value);
	}
	else
	{
		return EMPTY_STRING;
	}
}

////
// Return the manufacturers URL in the needed language
// TABLES: manufacturers_info
function olc_get_manufacturer_url($manufacturer_id, $language_id) {
	$manufacturer_query = olc_db_query(SELECT."manufacturers_url".SQL_FROM . TABLE_MANUFACTURERS_INFO .
	SQL_WHERE."manufacturers_id = " . $manufacturer_id . " and languages_id = " . $language_id);
	$manufacturer = olc_db_fetch_array($manufacturer_query);

	return $manufacturer['manufacturers_url'];
}

////
// Wrapper for class_exists() function
// This function is not available in all PHP versions so we test it before using it.
function olc_class_exists($class_name) {
	if (function_exists('class_exists')) {
		return class_exists($class_name);
	} else {
		return true;
	}
}

////
// Count how many products exist in a category
// TABLES: products, products_to_categories, categories
function olc_products_in_category_count($categories_id, $include_deactivated = false) {
	$products_count = 0;

	if ($include_deactivated) {
		$products_query = olc_db_query(SELECT."count(*) as total".SQL_FROM . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = p2c.products_id and p2c.categories_id = '" . $categories_id . APOS);
	} else {
		$products_query = olc_db_query(SELECT."count(*) as total".SQL_FROM . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = p2c.products_id and p.products_status = '1' and p2c.categories_id = '" . $categories_id . APOS);
	}

	$products = olc_db_fetch_array($products_query);

	$products_count += $products['total'];

	$childs_query = olc_db_query(SELECT."categories_id".SQL_FROM . TABLE_CATEGORIES . SQL_WHERE."parent_id = '" . $categories_id . APOS);
	if (olc_db_num_rows($childs_query)) {
		while ($childs = olc_db_fetch_array($childs_query)) {
			$products_count += olc_products_in_category_count($childs['categories_id'], $include_deactivated);
		}
	}

	return $products_count;
}

////
// Count how many subcategories exist in a category
// TABLES: categories
function olc_childs_in_category_count($categories_id) {
	$categories_count = 0;

	$categories_query = olc_db_query(SELECT."categories_id".SQL_FROM . TABLE_CATEGORIES . SQL_WHERE."parent_id = '" . $categories_id . APOS);
	while ($categories = olc_db_fetch_array($categories_query)) {
		$categories_count++;
		$categories_count += olc_childs_in_category_count($categories['categories_id']);
	}

	return $categories_count;
}

////
// Returns an array with countries
// TABLES: countries
function olc_get_countries($default = '')
{
	$countries_array = array();
	if ($default)
	{
		$countries_array[] = array(
		'id' => STORE_COUNTRY,
		'text' => $default);
	}
	$countries_query = olc_db_query(SELECT."countries_id, countries_name, countries_iso_code_2".SQL_FROM . TABLE_COUNTRIES .
	" order by countries_name");
	while ($countries = olc_db_fetch_array($countries_query))
	{
		$countries_array[] = array(
		'id' => $countries['countries_id'],
		'text' => $countries['countries_name'],
		'countries_iso_code_2'=>$countries['countries_iso_code_2']);
	}

	return $countries_array;
}

////
// return an array with country zones
function olc_get_country_zones($country_id) {
	$zones_array = array();
	$zones_query = olc_db_query(SELECT."zone_id, zone_name".SQL_FROM . TABLE_ZONES . SQL_WHERE."zone_country_id = '" . $country_id . "' order by zone_name");
	while ($zones = olc_db_fetch_array($zones_query)) {
		$zones_array[] = array('id' => $zones['zone_id'],
		'text' => $zones['zone_name']);
	}

	return $zones_array;
}

function olc_prepare_country_zones_pull_down($country_id = '') {
	// preset the width of the drop-down for Netscape
	$pre =  EMPTY_STRING;
	if ( (!olc_browser_detect('MSIE')) && (olc_browser_detect('Mozilla/4')) ) {
		for ($i=0; $i<45; $i++) $pre .= HTML_NBSP;
	}

	$zones = olc_get_country_zones($country_id);

	if (sizeof($zones) > 0) {
		$zones_select = array(array('id' =>  EMPTY_STRING, 'text' => PLEASE_SELECT));
		$zones = olc_array_merge($zones_select, $zones);
	} else {
		$zones = array(array('id' =>  EMPTY_STRING, 'text' => TYPE_BELOW));
		// create dummy options for Netscape to preset the height of the drop-down
		if ( (!olc_browser_detect('MSIE')) && (olc_browser_detect('Mozilla/4')) ) {
			for ($i=0; $i<9; $i++) {
				$zones[] = array('id' =>  EMPTY_STRING, 'text' => $pre);
			}
		}
	}

	return $zones;
}

////
// Get list of address_format_id's
function olc_get_address_formats() {
	$address_format_query = olc_db_query(SELECT."address_format_id".SQL_FROM . TABLE_ADDRESS_FORMAT . " order by address_format_id");
	$address_format_array = array();
	while ($address_format_values = olc_db_fetch_array($address_format_query)) {
		$address_format_array[] = array('id' => $address_format_values['address_format_id'],
		'text' => $address_format_values['address_format_id']);
	}
	return $address_format_array;
}

////
// Alias function for Store configuration values in the Administration Tool
function olc_cfg_pull_down_country_list($country_id)
{
	return olc_draw_pull_down_menu('configuration_value', olc_get_countries(), $country_id);
}

function olc_cfg_pull_down_shipping_list($shipping_module)
{
	global $include_modules;

	$id_text='id';
	$text_text='text';
	$class_text='class';
	$file_text='file';
	include_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES.'shipping.php');
	$shipping_class=new shipping(EMPTY_STRING,false);
	$shipping_modules=array();
	for ($i=0,$n=sizeof($include_modules);$i<$n;$i++)
	{
		$class=$include_modules[$i][$class_text];
		$shipping_modules[]=array(
		$id_text => $class,
		$text_text => $class
		);

	}
	return olc_draw_pull_down_menu('configuration_value', $shipping_modules, $shipping_module);
}

function olc_cfg_pull_down_zone_list($zone_id) {
	return olc_draw_pull_down_menu('configuration_value', olc_get_country_zones(STORE_COUNTRY), $zone_id);
}

function olc_cfg_pull_down_tax_classes($tax_class_id, $key = '') {
	$name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');

	$tax_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
	$tax_class_query = olc_db_query(SELECT."tax_class_id, tax_class_title".SQL_FROM . TABLE_TAX_CLASS . " order by tax_class_title");
	while ($tax_class = olc_db_fetch_array($tax_class_query)) {
		$tax_class_array[] = array('id' => $tax_class['tax_class_id'],
		'text' => $tax_class['tax_class_title']);
	}

	return olc_draw_pull_down_menu($name, $tax_class_array, $tax_class_id);
}

////
// Function to read in text area in admin
function olc_cfg_textarea($text) {
	return olc_draw_textarea_field('configuration_value', false, 50, 5, $text);
}

function olc_cfg_get_zone_name($zone_id) {
	$zone_query = olc_db_query(SELECT."zone_name".SQL_FROM . TABLE_ZONES . SQL_WHERE."zone_id = '" . $zone_id . APOS);

	if (olc_db_num_rows($zone_query)) {
		$zone = olc_db_fetch_array($zone_query);
		return $zone['zone_name'];
	} else {
		return $zone_id;
	}
}

//W. Kaiser - AJAX
function olc_cfg_display_color_sample($cInfo_configuration_value)
{
	$color_parts=explode(',',$cInfo_configuration_value);
	$r=$color_parts[0];
	if (is_numeric($r))
	{
		$cInfo_configuration_value=dechex($r).dechex($color_parts[1]).dechex($color_parts[2]);
	}
	require_once(DIR_FS_INC.'olc_create_color_selector.inc.php');
	return olc_create_color_selector('configuration_value',$cInfo_configuration_value);
}
//W. Kaiser - AJAX

////
// Sets the status of a banner
function olc_set_banner_status($banners_id, $status)
{
	$status = SQL_UPDATE . TABLE_BANNERS . " set status = '".$status."', ";
	$where=SQL_WHERE."banners_id = '" . $banners_id . APOS;
	if ($status == '1') {
		return olc_db_query($status ."expires_impressions = NULL, expires_date = NULL, date_status_change = NULL".$where);
	} elseif ($status == '0') {
		return olc_db_query($status ."date_status_change = now()".$where);
	} else {
		return -1;
	}
}

////
// Sets the status of a product
function olc_set_product_status($products_id, $status) {
	if ($status == '1' || $status == '0') {
		$status = SQL_UPDATE . TABLE_PRODUCTS . " set products_status = '".$status."',
			products_last_modified = now() where products_id = '" . $products_id . APOS;
		return olc_db_query($status );
	} else {
		return -1;
	}
}

////
// Sets the status of a product on special
function olc_set_specials_status($specials_id, $status) {
	$status = SQL_UPDATE . TABLE_SPECIALS . " set status = '".$status."', ";
	$where=SQL_WHERE."specials_id = '" . $specials_id . APOS;
	if ($status == '1') {
		return olc_db_query($status."expires_date = NULL, date_status_change = NULL".$where);
	} elseif ($status == '0') {
		return olc_db_query($status."date_status_change = now()".$where);
	} else {
		return -1;
	}
}

////
// Sets timeout for the current script.
// Cant be used in safe mode.
function olc_set_time_limit($limit) {
	if (!get_cfg_var('safe_mode')) {
		@set_time_limit($limit);
	}
}

////
// Alias function for Store configuration values in the Administration Tool
function olc_cfg_select_option($select_array, $key_value, $key = '') {
	for ($i = 0, $n = sizeof($select_array); $i < $n; $i++) {
		$name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
		$string .= '<br/><input type="radio" name="' . $name . '" value="' . $select_array[$i] . QUOTE;
		if ($key_value == $select_array[$i]) $string .= ' CHECKED';
		$string .= '> ' . $select_array[$i];
	}
	return $string;
}

////
// Alias function for module configuration keys
function olc_mod_select_option($select_array, $key_name, $key_value) {
	reset($select_array);
	while (list($key, $value) = each($select_array)) {
		if (is_int($key)) $key = $value;
		$string .= '<br/><input type="radio" name="configuration[' . $key_name . ']" value="' . $key . QUOTE;
		if ($key_value == $key) $string .= ' CHECKED';
		$string .= '> ' . $value;
	}

	return $string;
}

////
// Retreive server information
function olc_get_system_information() {

	$db_query = olc_db_query(SELECT."now() as datetime");
	$db = olc_db_fetch_array($db_query);

	list($system, $host, $kernel) = preg_split('/[\s,]+/', @exec('uname -a'), 5);

	return array('date' => olc_datetime_short(date('Y-m-d H:i:s')),
	'system' => $system,
	'kernel' => $kernel,
	'host' => $host,
	'ip' => gethostbyname($host),
	'uptime' => @exec('uptime'),
	'http_server' => $_SERVER['SERVER_SOFTWARE'],
	'php' => PHP_VERSION,
	'zend' => (function_exists('zend_version') ? zend_version() :  EMPTY_STRING),
	'db_server' => DB_SERVER,
	'db_ip' => gethostbyname(DB_SERVER),
	'db_version' => 'MySQL ' . (function_exists('mysql_get_server_info') ? mysql_get_server_info() :  EMPTY_STRING),
	'db_date' => olc_datetime_short($db['datetime']));
}

function olc_array_shift(&$array) {
	if (function_exists('array_shift')) {
		return array_shift($array);
	} else {
		$i = 0;
		$shifted_array = array();
		reset($array);
		while (list($key, $value) = each($array)) {
			if ($i > 0) {
				$shifted_array[$key] = $value;
			} else {
				$return = $array[$key];
			}
			$i++;
		}
		$array = $shifted_array;

		return $return;
	}
}

function olc_array_reverse($array) {
	if (function_exists('array_reverse')) {
		return array_reverse($array);
	} else {
		$reversed_array = array();
		for ($i=sizeof($array)-1; $i>=0; $i--) {
			$reversed_array[] = $array[$i];
		}
		return $reversed_array;
	}
}

function olc_generate_category_path($id, $from = 'category', $categories_array = '', $index = 0) {
	if (!is_array($categories_array)) $categories_array = array();
	if ($from == 'product')
	{
		$categories_query = olc_db_query(SELECT."categories_id".SQL_FROM . TABLE_PRODUCTS_TO_CATEGORIES .
		SQL_WHERE."products_id = '" . $id . APOS);
		while ($categories = olc_db_fetch_array($categories_query)) {
			if ($categories['categories_id'] == '0') {
				$categories_array[$index][] = array('id' => '0', 'text' => TEXT_TOP);
			} else {
				$category_query = olc_db_query(SELECT."cd.categories_name, c.parent_id".SQL_FROM . TABLE_CATEGORIES . " c, " .
				TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $categories['categories_id'] .
				"' and c.categories_id = cd.categories_id and cd.language_id = '" . SESSION_LANGUAGE_ID . APOS);
				$category = olc_db_fetch_array($category_query);
				$parent_id=$category['parent_id'];
				$categories_array[$index][] = array('id' => $categories['categories_id'], 'text' => $category['categories_name']);
				if ( (olc_not_null($parent_id)) && ($parent_id != '0') )
				$categories_array = olc_generate_category_path($parent_id, 'category', $categories_array, $index);
				$categories_array[$index] = olc_array_reverse($categories_array[$index]);
			}
			$index++;
		}
	} elseif ($from == 'category') {
		$category_query = olc_db_query(SELECT."cd.categories_name, c.parent_id".SQL_FROM . TABLE_CATEGORIES . " c, " .
		TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $id .
		"' and c.categories_id = cd.categories_id and cd.language_id = '" . SESSION_LANGUAGE_ID . APOS);
		$category = olc_db_fetch_array($category_query);
		$parent_id=$category['parent_id'];
		$categories_array[$index][] = array('id' => $id, 'text' => $category['categories_name']);
		if ( (olc_not_null($parent_id)) && ($parent_id != '0') )
		$categories_array = olc_generate_category_path($parent_id, 'category', $categories_array, $index);
	}
	return $categories_array;
}

function olc_output_generated_category_path($id, $from = 'category') {
	$calculated_category_path_string =  EMPTY_STRING;
	$calculated_category_path = olc_generate_category_path($id, $from);
	for ($i = 0, $n = sizeof($calculated_category_path); $i < $n; $i++)
	{
		for ($j = 0, $k = sizeof($calculated_category_path[$i]); $j < $k; $j++)
		{
			$calculated_category_path_string .= $calculated_category_path[$i][$j]['text'] . '&nbsp;&lt;&nbsp;';
		}
		$calculated_category_path_string = substr($calculated_category_path_string, 0, -16) . HTML_BR;
	}
	$calculated_category_path_string = substr($calculated_category_path_string, 0, -4);
	if (strlen($calculated_category_path_string) < 1) $calculated_category_path_string = TEXT_TOP;
	return $calculated_category_path_string;
}

function olc_remove_category($category_id) {
	$categories_id=SQL_WHERE."categories_id = '" . olc_db_input($category_id) . APOS;

	$category_image_query = olc_db_query(SELECT."categories_image".SQL_FROM . TABLE_CATEGORIES .	$categories_id);
	$category_image = olc_db_fetch_array($category_image_query);
	$duplicate_image_query = olc_db_query(SELECT."count(*) as total".SQL_FROM . TABLE_CATEGORIES .
	SQL_WHERE."categories_image = '" . olc_db_input($category_image['categories_image']) . APOS);
	$duplicate_image = olc_db_fetch_array($duplicate_image_query);
	if ($duplicate_image['total'] < 2)
	{
		$image=DIR_FS_CATALOG_IMAGES . $category_image['categories_image'];
		if (file_exists($image))
		{
			@unlink($image);
		}
	}
	$delete="delete".SQL_FROM;
	olc_db_query($delete . TABLE_CATEGORIES . $categories_id);
	olc_db_query($delete . TABLE_CATEGORIES_DESCRIPTION . $categories_id);
	olc_db_query($delete . TABLE_PRODUCTS_TO_CATEGORIES . $categories_id);
	if (USE_CACHE == TRUE_STRING_S) {
		olc_reset_cache_block('categories');
		olc_reset_cache_block('also_purchased');
	}
}

function olc_remove_product($product_id) {
	$where=SQL_WHERE."products_id = '" . olc_db_input($product_id) . APOS;
	$product_image_query = olc_db_query(SELECT."products_image".SQL_FROM . TABLE_PRODUCTS . $where);
	$product_image = olc_db_fetch_array($product_image_query);

	$duplicate_image_query = olc_db_query(SELECT."count(*) as total".SQL_FROM . TABLE_PRODUCTS .
	SQL_WHERE."products_image = '" . olc_db_input($product_image['products_image']) . APOS);
	$duplicate_image = olc_db_fetch_array($duplicate_image_query);

	if ($duplicate_image['total'] < 2) {
		if (file_exists(DIR_FS_CATALOG_POPUP_IMAGES . $product_image['products_image'])) {
			@unlink(DIR_FS_CATALOG_POPUP_IMAGES . $product_image['products_image']);
		}
		// START CHANGES
		$image_subdir = BIG_IMAGE_SUBDIR;
		if (substr($image_subdir, -1) != '/') $image_subdir .= '/';
		if (file_exists(DIR_FS_CATALOG_IMAGES . $image_subdir . $product_image['products_image'])) {
			@unlink(DIR_FS_CATALOG_IMAGES . $image_subdir . $product_image['products_image']);
		}
		// END CHANGES
	}

	$delete="delete".SQL_FROM;
	$where=SQL_WHERE."products_id = '" . olc_db_input($product_id) . APOS;
	olc_db_query($delete . TABLE_SPECIALS . $where);
	olc_db_query($delete . TABLE_PRODUCTS . $where);
	olc_db_query($delete . TABLE_PRODUCTS_TO_CATEGORIES . $where);
	olc_db_query($delete . TABLE_PRODUCTS_DESCRIPTION . $where);
	olc_db_query($delete . TABLE_PRODUCTS_ATTRIBUTES . $where);
	olc_db_query($delete . TABLE_CUSTOMERS_BASKET . $where);
	olc_db_query($delete . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . $where);
	//Xsell
	olc_db_query($delete . TABLE_PRODUCTS_XSELL . $where ." OR xsell_id = '" . olc_db_input($product_id) . APOS);
	//Xsell
	$customers_status_array=olc_get_customers_statuses();
	for ($i=0,$n=sizeof($customers_status_array);$i<$n;$i++) {
		olc_db_query($delete . TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS . $i . $where);

	}

	$product_reviews_query = olc_db_query(SELECT."reviews_id".SQL_FROM . TABLE_REVIEWS . $where);
	while ($product_reviews = olc_db_fetch_array($product_reviews_query)) {
		olc_db_query($delete . TABLE_REVIEWS_DESCRIPTION .
		SQL_WHERE."reviews_id = '" . $product_reviews['reviews_id'] . APOS);
	}
	olc_db_query($delete . TABLE_REVIEWS . $where);
	if (USE_CACHE == TRUE_STRING_S)
	{
		olc_reset_cache_block('categories');
		olc_reset_cache_block('also_purchased');
	}
}

function olc_remove_order($order_id, $restock = false) {
	$where=SQL_WHERE."orders_id = '" . olc_db_input($order_id) . APOS;
	if ($restock == 'on')
	{
		$order_query =
		olc_db_query(SELECT."products_id, products_quantity".SQL_FROM . TABLE_ORDERS_PRODUCTS . $where);
		while ($order = olc_db_fetch_array($order_query)) {
			olc_db_query(SQL_UPDATE . TABLE_PRODUCTS . " set products_quantity = products_quantity + " .
			$order['products_quantity'] . ", products_ordered = products_ordered - " . $order['products_quantity'] .
			SQL_WHERE."products_id = '" . $order['products_id'] . APOS);
		}
	}
	//begin PayPal_Shopping_Cart_IPN
	include_once(PAYPAL_IPN_DIR . 'Functions/general.func.php');
	paypal_remove_order($order_id);
	//end PayPal_Shopping_Cart_IPN
	$delete="delete".SQL_FROM;
	olc_db_query($delete . TABLE_ORDERS . $where);
	olc_db_query($delete . TABLE_ORDERS_PRODUCTS . $where);
	olc_db_query($delete . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . $where);
	olc_db_query($delete . TABLE_ORDERS_STATUS_HISTORY . $where);
	olc_db_query($delete . TABLE_ORDERS_TOTAL . $where);
}

function olc_reset_cache_block($cache_block) {
	global $cache_blocks;

	for ($i = 0, $n = sizeof($cache_blocks); $i < $n; $i++) {
		if ($cache_blocks[$i]['code'] == $cache_block) {
			if ($cache_blocks[$i]['multiple']) {
				if ($dir = @opendir(DIR_FS_CACHE)) {
					while ($cache_file = readdir($dir)) {
						$cached_file = $cache_blocks[$i]['file'];
						$languages = olc_get_languages();
						for ($j = 0, $k = sizeof($languages); $j < $k; $j++) {
							$cached_file_unlink = ereg_replace('-language', '-' . $languages[$j]['directory'], $cached_file);
							if (ereg('^' . $cached_file_unlink, $cache_file)) {
								@unlink(DIR_FS_CACHE . $cache_file);
							}
						}
					}
					closedir($dir);
				}
			} else {
				$cached_file = $cache_blocks[$i]['file'];
				$languages = olc_get_languages();
				for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
					$cached_file = ereg_replace('-language', '-' . $languages[$i]['directory'], $cached_file);
					@unlink(DIR_FS_CACHE . $cached_file);
				}
			}
			break;
		}
	}
}

function olc_get_file_permissions($mode) {
	// determine type
	if ( ($mode & 0xC000) == 0xC000) { // unix domain socket
		$type = 's';
	} elseif ( ($mode & 0x4000) == 0x4000) { // directory
		$type = 'd';
	} elseif ( ($mode & 0xA000) == 0xA000) { // symbolic link
		$type = 'l';
	} elseif ( ($mode & 0x8000) == 0x8000) { // regular file
		$type = '-';
	} elseif ( ($mode & 0x6000) == 0x6000) { //bBlock special file
		$type = 'b';
	} elseif ( ($mode & 0x2000) == 0x2000) { // character special file
		$type = 'c';
	} elseif ( ($mode & 0x1000) == 0x1000) { // named pipe
		$type = 'p';
	} else { // unknown
		$type = '?';
	}

	// determine permissions
	$owner['read']    = ($mode & 00400) ? 'r' : '-';
	$owner['write']   = ($mode & 00200) ? 'w' : '-';
	$owner['execute'] = ($mode & 00100) ? 'x' : '-';
	$group['read']    = ($mode & 00040) ? 'r' : '-';
	$group['write']   = ($mode & 00020) ? 'w' : '-';
	$group['execute'] = ($mode & 00010) ? 'x' : '-';
	$world['read']    = ($mode & 00004) ? 'r' : '-';
	$world['write']   = ($mode & 00002) ? 'w' : '-';
	$world['execute'] = ($mode & 00001) ? 'x' : '-';

	// adjust for SUID, SGID and sticky bit
	if ($mode & 0x800 ) $owner['execute'] = ($owner['execute'] == 'x') ? 's' : 'S';
	if ($mode & 0x400 ) $group['execute'] = ($group['execute'] == 'x') ? 's' : 'S';
	if ($mode & 0x200 ) $world['execute'] = ($world['execute'] == 'x') ? 't' : 'T';

	return $type .
	$owner['read'] . $owner['write'] . $owner['execute'] .
	$group['read'] . $group['write'] . $group['execute'] .
	$world['read'] . $world['write'] . $world['execute'];
}

function olc_array_slice($array, $offset, $length = '0') {
	if (function_exists('array_slice')) {
		return array_slice($array, $offset, $length);
	} else {
		$length = abs($length);
		if ($length == 0) {
			$high = sizeof($array);
		} else {
			$high = $offset+$length;
		}

		for ($i=$offset; $i<$high; $i++) {
			$new_array[$i-$offset] = $array[$i];
		}

		return $new_array;
	}
}

function olc_remove($source) {
	global $messageStack, $olc_remove_error;

	if (isset($olc_remove_error)) $olc_remove_error = false;

	if (is_dir($source)) {
		$dir = dir($source);
		while ($file = $dir->read()) {
			if ( ($file != '.') && ($file != '..') ) {
				if (is_writeable($source . '/' . $file)) {
					olc_remove($source . '/' . $file);
				} else {
					$messageStack->add(sprintf(ERROR_FILE_NOT_REMOVEABLE, $source . '/' . $file), 'error');
					$olc_remove_error = true;
				}
			}
		}
		$dir->close();

		if (is_writeable($source)) {
			rmdir($source);
		} else {
			$messageStack->add(sprintf(ERROR_DIRECTORY_NOT_REMOVEABLE, $source), 'error');
			$olc_remove_error = true;
		}
	} else {
		if (is_writeable($source)) {
			unlink($source);
		} else {
			$messageStack->add(sprintf(ERROR_FILE_NOT_REMOVEABLE, $source), 'error');
			$olc_remove_error = true;
		}
	}
}

////
// Wrapper for constant() function
// Needed because its only available in PHP 4.0.4 and higher.
function olc_constant($constant) {
	if (function_exists('constant')) {
		$temp = constant($constant);
	} else {
		eval("\$temp=$constant;");
	}
	return $temp;
}

////
// Output the tax percentage with optional padded decimals
function olc_display_tax_value($value, $padding = TAX_DECIMAL_PLACES) {
	if (strpos($value, '.')) {
		$loop = true;
		while ($loop) {
			if (substr($value, -1) == '0') {
				$value = substr($value, 0, -1);
			} else {
				$loop = false;
				if (substr($value, -1) == '.') {
					$value = substr($value, 0, -1);
				}
			}
		}
	}

	if ($padding > 0) {
		if ($decimal_pos = strpos($value, '.')) {
			$decimals = strlen(substr($value, ($decimal_pos+1)));
			for ($i=$decimals; $i<$padding; $i++) {
				$value .= '0';
			}
		} else {
			$value .= '.';
			for ($i=0; $i<$padding; $i++) {
				$value .= '0';
			}
		}
	}

	return $value;
}



function olc_get_tax_class_title($tax_class_id) {
	if ($tax_class_id == '0') {
		return TEXT_NONE;
	} else {
		$classes_query = olc_db_query(SELECT."tax_class_title".SQL_FROM . TABLE_TAX_CLASS . SQL_WHERE."tax_class_id = '" . $tax_class_id . APOS);
		$classes = olc_db_fetch_array($classes_query);

		return $classes['tax_class_title'];
	}
}

function olc_banner_image_extension() {
	if (function_exists('imagetypes')) {
		if (imagetypes() & IMG_PNG) {
			return 'png';
		} elseif (imagetypes() & IMG_JPG) {
			return 'jpg';
		} elseif (imagetypes() & IMG_GIF) {
			return 'gif';
		}
	} elseif (function_exists('imagecreatefrompng') && function_exists('imagepng')) {
		return 'png';
	} elseif (function_exists('imagecreatefromjpeg') && function_exists('imagejpeg')) {
		return 'jpg';
	} elseif (function_exists('imagecreatefromgif') && function_exists('imagegif')) {
		return 'gif';
	}

	return false;
}

////
// Wrapper function for round()
function olc_round($value, $precision) {
	return round($value, $precision);
}

////
// Add tax to a products price
/*
function olc_add_tax($price, $tax) {
global $currencies;

if (DISPLAY_PRICE_WITH_TAX == TRUE_STRING_S) {
return olc_round($price, $currencies->currencies[DEFAULT_CURRENCY]['decimal_places']) + olc_calculate_tax($price, $tax);
} else {
return olc_round($price, $currencies->currencies[DEFAULT_CURRENCY]['decimal_places']);
}
}
*/
// Calculates Tax rounding the result
function olc_calculate_tax($price, $tax) {
	global $currencies;

	return olc_round($price * $tax / 100, $currencies->currencies[DEFAULT_CURRENCY]['decimal_places']);
}

////
// Returns the tax rate for a zone / class
// TABLES: tax_rates, zones_to_geo_zones
/*
function olc_get_tax_rate($class_id, $country_id = -1, $zone_id = -1) {
global $customer_zone_id, $customer_country_id;

if ( ($country_id == -1) && ($zone_id == -1) ) {
if (!isset($_SESSION['customer_id'])) {
$country_id = STORE_COUNTRY;
$zone_id = STORE_ZONE;
} else {
$country_id = $customer_country_id;
$zone_id = $customer_zone_id;
}
}

$tax_query = olc_db_query(SELECT."SUM(tax_rate) as tax_rate".SQL_FROM . TABLE_TAX_RATES . " tr left join " . TABLE_ZONES_TO_GEO_ZONES . " za ON tr.tax_zone_id = za.geo_zone_id left join " . TABLE_GEO_ZONES . " tz ON tz.geo_zone_id = tr.tax_zone_id WHERE (za.zone_country_id IS NULL OR za.zone_country_id = '0' OR za.zone_country_id = '" . $country_id . "') AND (za.zone_id IS NULL OR za.zone_id = '0' OR za.zone_id = '" . $zone_id . "') AND tr.tax_class_id = '" . $class_id . "' GROUP BY tr.tax_priority");
if (olc_db_num_rows($tax_query)) {
$tax_multiplier = 0;
while ($tax = olc_db_fetch_array($tax_query)) {
$tax_multiplier += $tax['tax_rate'];
}
return $tax_multiplier;
} else {
return 0;
}
}
*/
function olc_call_function($function, $parameter, $object = '') {
	//$function=str_replace("olc_","olc_",$function);
	if ($object ==  EMPTY_STRING) {
		return call_user_func($function, $parameter);
	} else {
		return call_user_func(array($object, $function), $parameter);
	}
}

function olc_get_zone_class_title($zone_class_id) {
	if ($zone_class_id == '0') {
		return TEXT_NONE;
	} else {
		$classes_query = olc_db_query(SELECT."geo_zone_name".SQL_FROM . TABLE_GEO_ZONES . SQL_WHERE."geo_zone_id = '" . $zone_class_id . APOS);
		$classes = olc_db_fetch_array($classes_query);

		return $classes['geo_zone_name'];
	}
}

function olc_cfg_pull_down_template_sets()
{
	$name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
	$template_dir=DIR_FS_CATALOG.TEMPLATE_PATH;
	if ($dir= opendir($template_dir))
	{
		while (($file = readdir($dir)))
		{
			if (olc_include_file($template_dir,$file,true))
			{
				if ($file !="common")
				{
					if (is_dir( $template_dir.$file))
					{
						$file_array[]=array(
						'id' => $file,
						'text' => $file);
					}
				}
			}
		}
		closedir($dir);
		sort($file_array);
		return olc_draw_pull_down_menu($name, $file_array, 0);
	}
}

function olc_include_file($dir,$file,$must_be_dir=false)
{
	if ($file[0]!=".")
	{
		if ($file !="CVS")
		{
			if (strpos(strtolower($file),'.bak') === false)
			{
				$is_dir=is_dir($dir.$file);
				if ($must_be_dir)
				{
					$include=$is_dir;
				}
				else
				{
					$include=!$is_dir;
				}
				return $include;
			}
		}
	}
}

function olc_cfg_pull_down_zone_classes($zone_class_id, $key = '') {
	$name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');

	$zone_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
	$zone_class_query = olc_db_query(SELECT."geo_zone_id, geo_zone_name".SQL_FROM . TABLE_GEO_ZONES . " order by geo_zone_name");
	while ($zone_class = olc_db_fetch_array($zone_class_query)) {
		$zone_class_array[] = array('id' => $zone_class['geo_zone_id'],
		'text' => $zone_class['geo_zone_name']);
	}

	return olc_draw_pull_down_menu($name, $zone_class_array, $zone_class_id);
}

function olc_cfg_pull_down_order_statuses($order_status_id, $key = '') {

	$name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');

	$statuses_array = array(array('id' => '0', 'text' => TEXT_DEFAULT));
	$statuses_query = olc_db_query(SELECT."orders_status_id, orders_status_name".SQL_FROM . TABLE_ORDERS_STATUS . SQL_WHERE."language_id = '" . SESSION_LANGUAGE_ID . "' order by orders_status_name");
	while ($statuses = olc_db_fetch_array($statuses_query)) {
		$statuses_array[] = array('id' => $statuses['orders_status_id'],
		'text' => $statuses['orders_status_name']);
	}

	return olc_draw_pull_down_menu($name, $statuses_array, $order_status_id);
}

function olc_get_order_status_name($order_status_id, $language_id = '') {

	if ($order_status_id < 1) return TEXT_DEFAULT;

	if (!is_numeric($language_id)) $language_id = SESSION_LANGUAGE_ID;

	$status_query = olc_db_query(SELECT."orders_status_name".SQL_FROM . TABLE_ORDERS_STATUS . SQL_WHERE."orders_status_id = '" . $order_status_id . "' and language_id = '" . $language_id . APOS);
	$status = olc_db_fetch_array($status_query);

	return $status['orders_status_name'];
}

////
// Return a random value
function olc_rand_x($min = null, $max = null) {
	static $seeded;

	if (!$seeded) {
		mt_srand((double)microtime()*1000000);
		$seeded = true;
	}

	if (isset($min) && isset($max)) {
		if ($min >= $max) {
			return $min;
		} else {
			return mt_rand($min, $max);
		}
	} else {
		return mt_rand();
	}
}

// nl2br() prior PHP 4.2.0 did not convert linefeeds on all OSs (it only converted \n)
function olc_convert_linefeeds($from, $to, $string) {
	if ((PHP_VERSION < "4.0.5") && is_array($from)) {
		return ereg_replace('(' . implode('|', $from) . RPAREN, $to, $string);
	} else {
		return str_replace($from, $to, $string);
	}
}

// Return all customers statuses for a specified language_id and return an array(array())
// Use it to make pull_down_menu, checkbox....
function olc_get_customers_statuses() {

	$customers_statuses_array = array(array());
	$customers_statuses_query = olc_db_query(SELECT."customers_status_id, customers_status_name, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount".SQL_FROM . TABLE_CUSTOMERS_STATUS . SQL_WHERE."language_id = '" . SESSION_LANGUAGE_ID . "' order by customers_status_id");
	$i=1;        // this is changed from 0 to 1 in cs v1.2
	while ($customers_statuses = olc_db_fetch_array($customers_statuses_query)) {
		$i=$customers_statuses['customers_status_id'];
		$customers_statuses_array[$i] = array('id' => $customers_statuses['customers_status_id'],
		'text' => $customers_statuses['customers_status_name'],
		'csa_public' => $customers_statuses['customers_status_public'],
		'csa_image' => $customers_statuses['customers_status_image'],
		'csa_discount' => $customers_statuses['customers_status_discount'],
		'csa_ot_discount_flag' => $customers_statuses['customers_status_ot_discount_flag'],
		'csa_ot_discount' => $customers_statuses['customers_status_ot_discount'],
		'csa_graduated_prices' => $customers_statuses['customers_status_graduated_prices']
		);
	}
	return $customers_statuses_array;
}


function olc_get_customer_status($customers_id) {

	$customer_status_array = array();
	$customer_status_query = olc_db_query(SELECT."customers_status, member_flag, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices  FROM " . TABLE_CUSTOMERS . " left join " . TABLE_CUSTOMERS_STATUS . " on customers_status = customers_status_id where customers_id='" . $customers_id . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
	$customer_status_array = olc_db_fetch_array($customer_status_query);
	return $customer_status_array;
}

function olc_get_customers_status_name($customers_status_id, $language_id = '') {

	if (!$language_id) $language_id = SESSION_LANGUAGE_ID;
	$customers_status_query = olc_db_query(SELECT."customers_status_name".SQL_FROM . TABLE_CUSTOMERS_STATUS . SQL_WHERE."customers_status_id = '" . $customers_status_id . "' and language_id = '" . $language_id . APOS);
	$customers_status = olc_db_fetch_array($customers_status_query);
	return $customers_status['customers_status_name'];
}

//to set customers status in admin for default value, newsletter, guest...
function olc_cfg_pull_down_customers_status_list($customers_status_id, $key = '') {
	$name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
	return olc_draw_pull_down_menu($name, olc_get_customers_statuses(), $customers_status_id);
}

// Function for collecting ip
// return all log info for a customer_id
function olc_get_user_info($customer_id) {
	$user_info_array = olc_db_query(SELECT."customers_ip, customers_ip_date, customers_host, customers_advertiser, customers_referer_url FROM " . TABLE_CUSTOMERS_IP . SQL_WHERE."customers_id = '" . $customer_id . APOS);
	return $user_info_array;
}

//---------------------------------------------------------------kommt wieder raus später!!
function olc_get_uploaded_file($filename) {
	if (isset($_FILES[$filename])) {
		$uploaded_file = array('name' => $_FILES[$filename]['name'],
		'type' => $_FILES[$filename]['type'],
		'size' => $_FILES[$filename]['size'],
		'tmp_name' => $_FILES[$filename]['tmp_name']);
	} elseif (isset($_FILES[$filename])) {
		$uploaded_file = array('name' => $_FILES[$filename]['name'],
		'type' => $_FILES[$filename]['type'],
		'size' => $_FILES[$filename]['size'],
		'tmp_name' => $_FILES[$filename]['tmp_name']);
	} else {
		$uploaded_file = array('name' => $GLOBALS[$filename . '_name'],
		'type' => $GLOBALS[$filename . '_type'],
		'size' => $GLOBALS[$filename . '_size'],
		'tmp_name' => $GLOBALS[$filename]);
	}

	return $uploaded_file;
}

function get_group_price($group_id, $product_id) {
	// well, first try to get group price from database
	$group_price_query = olc_db_query("SELECT personal_offer FROM " .
	TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS . $group_id . " WHERE products_id = '" . $product_id . APOS);
	$group_price_data = olc_db_fetch_array($group_price_query);
	// if we found a price, everything is ok if not, we will create new entry
	if ($group_price_data['personal_offer'] ==  EMPTY_STRING) {
		olc_db_query(INSERT_INTO . TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS . $group_id .
		" (price_id, products_id, quantity, personal_offer) VALUES ('', '" . $product_id . "', '1', '0.00')");
		$group_price_query = olc_db_query("SELECT personal_offer FROM " .
		TABLE_PERSONAL_OFFERS_BY_CUSTOMERS_STATUS . $group_id . " WHERE products_id = '" . $product_id . APOS);
		$group_price_data = olc_db_fetch_array($group_price_query);
	}
	return $group_price_data['personal_offer'];
}

function format_price($price_string, $price_special, $currency, $allow_tax, $tax_rate)
{
	if ($price_string)
	{
		if ($allow_tax == 1)
		{
			$price_string = olc_add_tax($price_string,$tax_rate);
		}
		$price_string=olc_format_price($price_string,1,1);
	}
	return $price_string;
}

function precision($number, $places) {
	$number = number_format($number, $places, '.',  EMPTY_STRING);
	return $number;
}

function olc_get_lang_definition($search_lang, $lang_array, $modifier) {
	$search_lang=$search_lang.$modifier;
	return $lang_array[$search_lang];
}

function olc_CheckExt($filename, $ext) {
	$passed = FALSE;
	$testExt = "\.".$ext."$";
	if (eregi($testExt, $filename)) {
		$passed = TRUE;
	}
	return $passed;
}

function olc_get_status_users($status_id) {
	$status_query = olc_db_query("SELECT count(customers_status) as count FROM " . TABLE_CUSTOMERS .
	" WHERE customers_status = '" . $status_id . APOS);
	$status_data = olc_db_fetch_array($status_query);
	return $status_data['count'];
}

function olc_mkdirs($path,$perm) {

	if (is_dir($path)) {
		return true;
	} else {

		//$path=dirname($path);
		if (!mkdir($path,$perm)) return false;
		mkdir($path,$perm);
		return true;
	}
}

function olc_spaceUsed($dir) {
	if(is_dir($dir)) {
		if ($dh=opendir($dir)){
			while (($file=readdir($dh)) !==false) {
				if (is_dir($dir.$file) && $file !='.' && $file != '..') {
					olc_spaceUsed($dir.$file.'/');
				}else{
					$GLOBALS['total']+=filesize($dir.$file);
				}
			}
			closedir($dh);
		}
	}
}

function create_coupon_code($salt="secret", $length=SECURITY_CODE_LENGTH) {
	$ccid = md5(uniqid("","salt"));
	$ccid .= md5(uniqid("","salt"));
	$ccid .= md5(uniqid("","salt"));
	$ccid .= md5(uniqid("","salt"));
	srand((double)microtime()*1000000); // seed the random number generator
	$random_start = @rand(0, (128-$length));
	$good_result = 0;
	while ($good_result == 0) {
		$id1=substr($ccid, $random_start,$length);
		$query = olc_db_query(SELECT."coupon_code".SQL_FROM . TABLE_COUPONS . SQL_WHERE."coupon_code = '" . $id1 . APOS);
		if (olc_db_num_rows($query) == 0) $good_result = 1;
	}
	return $id1;
}

// Update the Customers GV account
function olc_gv_account_update($customer_id, $gv_id) {
	$customer_gv_query = olc_db_query(SELECT."amount".SQL_FROM . TABLE_COUPON_GV_CUSTOMER .
	SQL_WHERE."customer_id = '" . $customer_id . APOS);
	$coupon_gv_query = olc_db_query(SELECT."coupon_amount".SQL_FROM . TABLE_COUPONS . SQL_WHERE."coupon_id = '" . $gv_id . APOS);
	$coupon_gv = olc_db_fetch_array($coupon_gv_query);
	if (olc_db_num_rows($customer_gv_query) > 0) {
		$customer_gv = olc_db_fetch_array($customer_gv_query);
		$new_gv_amount = $customer_gv['amount'] + $coupon_gv['coupon_amount'];
		$gv_query = olc_db_query(SQL_UPDATE . TABLE_COUPON_GV_CUSTOMER . " set amount = '" . $new_gv_amount .
		"' where customer_id = '" . $customer_id . APOS);
	} else {
		$gv_query = olc_db_query(INSERT_INTO . TABLE_COUPON_GV_CUSTOMER .
		" (customer_id, amount) values ('" . $customer_id . "', '" . $coupon_gv['coupon_amount'] . "')");
	}
}

// Output a day/month/year dropdown selector
function olc_draw_date_selector($prefix, $date='') {
	$month_array = array();
	$month_array[1] =_JANUARY;
	$month_array[2] =_FEBRUARY;
	$month_array[3] =_MARCH;
	$month_array[4] =_APRIL;
	$month_array[5] =_MAY;
	$month_array[6] =_JUNE;
	$month_array[7] =_JULY;
	$month_array[8] =_AUGUST;
	$month_array[9] =_SEPTEMBER;
	$month_array[10] =_OCTOBER;
	$month_array[11] =_NOVEMBER;
	$month_array[12] =_DECEMBER;
	$usedate = getdate($date);
	$day = $usedate['mday'];
	$month = $usedate['mon'];
	$year = $usedate['year'];
	$date_selector = '<select name="'. $prefix .'_day">';
	for ($i=1;$i<32;$i++){
		$date_selector .= '<option value="' . $i . QUOTE;
		if ($i==$day) $date_selector .= 'selected';
		$date_selector .= '>' . $i . '</option>';
	}
	$date_selector .= '</select>';
	$date_selector .= '<select name="'. $prefix .'_month">';
	for ($i=1;$i<13;$i++){
		$date_selector .= '<option value="' . $i . QUOTE;
		if ($i==$month) $date_selector .= 'selected';
		$date_selector .= '>' . $month_array[$i] . '</option>';
	}
	$date_selector .= '</select>';
	$date_selector .= '<select name="'. $prefix .'_year">';
	for ($i=2001;$i<2019;$i++){
		$date_selector .= '<option value="' . $i . QUOTE;
		if ($i==$year) $date_selector .= 'selected';
		$date_selector .= '>' . $i . '</option>';
	}
	$date_selector .= '</select>';
	return $date_selector;
}

if (!function_exists('olc_get_vpe_name'))
{
	include_once(DIR_FS_INC.'olc_get_vpe_name.inc.php');
}

function olc_get_products_vpe_name($products_vpe_id, $language_id = '') {

	if (!$language_id) $language_id = SESSION_LANGUAGE_ID;
	$products_vpe_query = olc_db_query(SELECT."products_vpe_name".SQL_FROM . TABLE_PRODUCTS_VPE .
	SQL_WHERE."products_vpe_id = '" . $products_vpe_id . "' and language_id = '" . $language_id . APOS);
	$products_vpe = olc_db_fetch_array($products_vpe_query);

	return $products_vpe['products_vpe_name'];
}

//--------------------------------------------------------------------------------------Ende
?>