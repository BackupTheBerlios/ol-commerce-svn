<?php
/* -----------------------------------------------------------------------------------------
$Id: address_book_details.php,v 1.1.1.1.2.1 2007/04/08 07:17:58 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(address_book_details.php,v 1.9 2003/05/22); www.oscommerce.com
(c) 2003	    nextcommerce (address_book_details.php,v 1.9 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------/-----*/

if (true)
{
	$EditPersonalData=true;
	$EditAdressData=true;
	define('SMARTY_TEMPLATE','address_book_details');
	define('SMARTY_TARGET_AREA','MODULE_address_book_details');
	define('MESSAGE_STACK_NAME','addressbook');
	include_once(DIR_FS_INC.'olc_show_customer_data_form.inc.php');
}
else
{
	//$module_smarty=new Smarty;
  olc_smarty_init($module_smarty,$cacheid);
	if (!isset($process)) $process = false;
	// include needed functions
	include_once(DIR_FS_INC.'olc_get_zone_name.inc.php');
	include_once(DIR_FS_INC.'olc_get_country_list.inc.php');
	include_once(DIR_FS_INC.'olc_get_countries.inc.php');
	include_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');

	if (ACCOUNT_GENDER == TRUE_STRING_S) {
		$male = ($entry['entry_gender'] == 'm') ? true : false;
		$female = ($entry['entry_gender'] == 'f') ? true : false;
		$module_smarty->assign('gender','1');
		$module_smarty->assign('INPUT_MALE',olc_draw_radio_field('gender', 'm',$male));
		$module_smarty->assign('INPUT_FEMALE',olc_draw_radio_field('gender', 'f',$female).
		(olc_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''));
	}
	$module_smarty->assign('INPUT_FIRSTNAME',olc_draw_input_field('firstname',$entry['entry_firstname']) . HTML_NBSP . (olc_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''));
	$module_smarty->assign('INPUT_LASTNAME',olc_draw_input_field('lastname',$entry['entry_lastname']) . HTML_NBSP . (olc_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''));
	if (ACCOUNT_COMPANY == TRUE_STRING_S)
	{
		$module_smarty->assign('company','1');
		$module_smarty->assign('INPUT_COMPANY',olc_draw_input_field('company', $entry['entry_company']) . HTML_NBSP .
		(olc_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': ''));
	}

	$module_smarty->assign('INPUT_STREET',olc_draw_input_field('street_address', $entry['entry_street_address']) . HTML_NBSP .
	(olc_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''));
	if (ACCOUNT_SUBURB == TRUE_STRING_S) {
		$module_smarty->assign('suburb','1');
		$module_smarty->assign('INPUT_SUBURB',olc_draw_input_field('suburb', $entry['entry_suburb']) . HTML_NBSP .
		(olc_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': ''));
	}
	$module_smarty->assign('INPUT_CODE',olc_draw_input_field('postcode', $entry['entry_postcode']) . HTML_NBSP . (olc_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''));
	$module_smarty->assign('INPUT_CITY',olc_draw_input_field('city', $entry['entry_city']) . HTML_NBSP .
	(olc_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''));
	if (ACCOUNT_STATE == TRUE_STRING_S) {
		$module_smarty->assign('state','1');
		if ($process) {
			if ($entry_state_has_zones == true) {
				$zones_array = array();
				$zones_query = olc_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" .
				olc_db_input($country) . "' order by zone_name");
				while ($zones_values = olc_db_fetch_array($zones_query)) {
					$zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
				}
				$state_input= olc_draw_pull_down_menu('state', $zones_array);
			} else {
				$state_input= olc_draw_input_field('state');
			}
		} else {
			$state_input= olc_draw_input_field('state', olc_get_zone_name($entry['entry_country_id'], $entry['entry_zone_id'],
			$entry['entry_state']));
		}
		if (olc_not_null(ENTRY_STATE_TEXT)) $state_input.= '&nbsp;<span class="inputRequirement">' . ENTRY_STATE_TEXT;
		$module_smarty->assign('INPUT_STATE',$state_input);
	}
	$module_smarty->assign('SELECT_COUNTRY',olc_get_country_list('country', $entry['entry_country_id']) . HTML_NBSP .
	(olc_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''));

	if ((isset($edit) && ($_SESSION['customer_default_address_id'] != $edit)) || (isset($edit) == false) ) {
		$module_smarty->assign('new','1');
		$module_smarty->assign('CHECKBOX_PRIMARY',olc_draw_checkbox_field('primary', 'on', false));
	}
	$main_content=$module_smarty->fetch(CURRENT_TEMPLATE_MODULE . 'address_book_details'.HTML_EXT,$cacheid);
	$smarty->assign('MODULE_address_book_details',$main_content);
}
?>
