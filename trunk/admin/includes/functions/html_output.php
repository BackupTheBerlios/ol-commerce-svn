<?php
/* --------------------------------------------------------------
$Id: html_output.php,v 1.1.1.1.2.1 2007/04/08 07:16:43 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(html_output.php,v 1.26 2002/08/06); www.oscommerce.com
(c) 2003	    nextcommerce (html_output.php,v 1.7 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

global $use_catalog_link;

require_once(DIR_FS_INC.'olc_parse_input_field_data.inc.php');
require_once(DIR_FS_INC.'olc_href_link.inc.php');
require_once(DIR_FS_INC.'olc_onclick_link.inc.php');
$draw_function=DIR_FS_INC.'olc_draw_';
require_once($draw_function.'form.inc.php');
require_once($draw_function.'input_field.inc.php');
require_once($draw_function.'radio_field.inc.php');
require_once($draw_function.'checkbox_field.inc.php');
require_once($draw_function.'password_field.inc.php');
require_once($draw_function.'hidden_field.inc.php');
require_once($draw_function.'pull_down_menu.inc.php');
require_once($draw_function.'selection_field.inc.php');
require_once($draw_function.'submit_button.inc.php');
require_once($draw_function.'textarea_field.inc.php');
require_once(DIR_FS_INC.'olc_image.inc.php');
require_once(DIR_FS_INC.'olc_image_submit.inc.php');

/*
// The HTML form submit button wrapper function
// Outputs a button in the selected language
function olc_image_submit($image, $alt, $params = '') {

	return '<input type="image" src="' .CURRENT_ADMIN_BUTTONS . $image . '" border="0" alt="' . $alt . '"' .
	(($params) ? BLANK . $params : EMPTY_STRING) . '>';
}
*/

// Output a form small input field
function olc_draw_small_input_field($name, $value = '', $parameters = '', $required = false, $type = 'text', $reinsert_value = true) {
	$field = '<input type="' . $type . '" size="3" name="' . $name . '"';
	if ( ($GLOBALS[$name]) && ($reinsert_value) ) {
		$field .= ' value="' . htmlspecialchars(trim($GLOBALS[$name])) . '"';
	} elseif ($value != EMPTY_STRING) {
		$field .= ' value="' . htmlspecialchars(trim($value)) . '"';
	}
	if ($parameters != EMPTY_STRING) {
		$field .= BLANK . $parameters;
	}
	$field .= '>';

	if ($required) $field .= TEXT_FIELD_REQUIRED;

	return $field;
}

function olc_catalog_href_link($page = '', $parameters = '', $connection = NONSSL, $add_session_id = false,
$search_engine_safe = false, $create_ajax_link = true)
{
	global $use_catalog_link;
	$use_catalog_link=true;
	return olc_href_link($page, $parameters,$connection,$add_session_id,$search_engine_safe,$create_ajax_link);
	$use_catalog_link=false;
}

////
// The HTML form submit button wrapper function
// Outputs a button in the selected language
function olc_template_image_submit($image, $alt, $params = '') {

	return '<input type="image" src="../' .CURRENT_TEMPLATE_BUTTONS . $image . '" border="0" alt="' . $alt . '"' .
	(($params) ? BLANK . $params : EMPTY_STRING) . '>';
}

function olc_template_image_button($image, $alt = '', $params = '') {

	return olc_image('../'.CURRENT_TEMPLATE_BUTTONS . $image, $alt, EMPTY_STRING, EMPTY_STRING, $params);
}

////
// Draw a 1 pixel black line
function olc_black_line() {
	return olc_image(DIR_WS_IMAGES . 'pixel_black.gif', EMPTY_STRING, '100%', '1');
}

////
// Output a separator either through whitespace, or with an image
function olc_draw_separator($image = 'pixel_black.gif', $width = '100%', $height = '1') {
	return olc_image(DIR_WS_IMAGES . $image, EMPTY_STRING, $width, $height);
}

////
// Output a function button in the selected language
function olc_image_button($image, $alt = '', $params = '') {
	//return olc_image(CURRENT_ADMIN_BUTTONS . $image, $alt, EMPTY_STRING, EMPTY_STRING, $params. 'align="top"');
	return olc_image(CURRENT_TEMPLATE_ADMIN_BUTTONS.$image, $alt, EMPTY_STRING, EMPTY_STRING, $params. 'align="top"');
}

////
// javascript to dynamically update the states/provinces list when the country is changed
// TABLES: zones
function olc_js_zone_list($country, $form, $field) {
	$countries_query = olc_db_query("select distinct zone_country_id from " . TABLE_ZONES . " order by zone_country_id");
	$num_country = 1;
	$output_string = EMPTY_STRING;
	while ($countries = olc_db_fetch_array($countries_query)) {
		if ($num_country == 1) {
			$output_string .= '  if (' . $country . ' == "' . $countries['zone_country_id'] . '") {' . NEW_LINE;
		} else {
			$output_string .= '  } else if (' . $country . ' == "' . $countries['zone_country_id'] . '") {' . NEW_LINE;
		}
		$states_query = olc_db_query("select zone_name, zone_id from " . TABLE_ZONES .
		" where zone_country_id = '" . $countries['zone_country_id'] . "' order by zone_name");
		$num_state = 1;
		while ($states = olc_db_fetch_array($states_query)) {
			if ($num_state == '1') $output_string .= '    ' . $form . '.' . $field . '.options[0] = new Option("' . PLEASE_SELECT . '", "");' . NEW_LINE;
			$output_string .= '    ' . $form . '.' . $field . '.options[' . $num_state . '] = new Option("' . $states['zone_name'] . '", "' . $states['zone_id'] . '");' . NEW_LINE;
			$num_state++;
		}
		$num_country++;
	}
	$output_string .= '  } else {' . NEW_LINE .
	'    ' . $form . '.' . $field . '.options[0] = new Option("' . TYPE_BELOW . '", "");' . NEW_LINE .
	'  }' . NEW_LINE;

	return $output_string;
}

////
// Output a form filefield
function olc_draw_file_field($name,$defaultValue=EMPTY_STRING,$parameters=EMPTY_STRING)
{
	$parameters.=' size="50" defaultValue="'.$defaultValue.QUOTE;
	$field = olc_draw_input_field($name, EMPTY_STRING, $parameters, 'file');
	return $field;
}
?>