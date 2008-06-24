<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_show_customer_data_form.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:41 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_get_countries.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

//
//	W. Kaiser - Common code for "create_account.php" and "customers.php"
//

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// include needed functions
if (NOT_IS_ADMIN_FUNCTION)
{
	require_once(DIR_FS_INC.'olc_draw_radio_field.inc.php');
	require_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');
	require_once(DIR_FS_INC.'olc_draw_password_field.inc.php');
	require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
	require_once(DIR_FS_INC.'olc_draw_pull_down_menu.inc.php');
	require_once(DIR_FS_INC.'olc_get_countries.inc.php');
	require_once(DIR_FS_INC.'olc_date_short.inc.php');
	if($IsCheckout)
	{
		require_once(DIR_FS_INC.'olc_get_address_format_id.inc.php');
		require_once(DIR_FS_INC.'olc_address_format.inc.php');
	}
}
require_once(DIR_FS_INC.'olc_get_country_list.inc.php');

define('DOUBLE_SPACE', HTML_NBSP . HTML_NBSP);

if ($IsUserMode)
{
	require_once(DIR_FS_INC.'olc_get_zone_name.inc.php');
	require_once(DIR_FS_INC.'olc_get_country_name.inc.php');
	if (!$IsUserModeEdit)
	{
		// Create new/guest account
		$EditPersonalData = true;
		$EditAdressData = true;
	}

	$class_name = 'errorText';
}
else
{
	//Admin create/modify account
	$EditPersonalData = true;
	$EditAdressData = true;

	$class_name = 'fieldRequired';
	define('TD_START', '					<td class="main" valign="top"');
}
$get_all_data = $EditPersonalData && $EditAdressData;

define('ENTRY_STATE_TEXT_LOCAL',"entry_state");
define('ERROR_SPAN_START',  '<td nowrap="nowrap" width="10">&nbsp;</td><td class="' . $class_name . '" valign="top"><font size="1">');
define('ERROR_SPAN_END','</font></td>');
define('REQUIRED','* Erforderlich#');
define('TEXT_REQUIRED_NEW', ERROR_SPAN_START . REQUIRED . ERROR_SPAN_END);
define('TEXT_REQUIRED_DUMMY', ERROR_SPAN_START . HASH . ERROR_SPAN_END);
//Special handling for "entry_state"
define('ERROR_SPAN_START_STATE',  ERROR_SPAN_START.'<span id="'.ENTRY_STATE_TEXT_LOCAL.'_area_3" style="display:inline;">');
define('ERROR_SPAN_END_STATE','</span>'.ERROR_SPAN_END);

define('TEXT_REQUIRED_NEW_STATE', ERROR_SPAN_START_STATE . REQUIRED . ERROR_SPAN_END_STATE);
define('MAX_SIZE', 42);
define('MAX_LENGTH', 50);
define('NOT_REQUIRED', -1);
define('NO_INPUT', -2);

$form_name = 'customers';
$get_all_data = true;
$password_check = FALSE_STRING_S;
$validate_email_and_phone=USE_AJAX && ENTRY_EMAIL_ADDRESS_CHECK == TRUE_STRING_S;

if ($IsUserMode)
{
	if (!isset($cInfo))
	{
		// entry/item info classes
		require_once(DIR_WS_CLASSES.'object_info.php');
		$cInfo = new objectInfo($_POST);
	}
}
$customers_gender=$cInfo->customers_gender;
$customers_firstname=$cInfo->customers_firstname;
$customers_lastname=$cInfo->customers_lastname;
$IsCreateAccountOrIsEditAccount=$IsCreateAccount || $IsEditAccount;
$not_IsEditAccount=!$IsEditAccount;
$error = true;
if ($IsCreateAccountOrIsEditAccount)
{
	$link_file = FILENAME_CREATE_ACCOUNT;
	$image = 'button_insert.gif';
	if ($IsUserMode)
	{
		$form_name = MESSAGE_STACK_NAME;
		$action = 'process';
		$alt = IMAGE_BUTTON_INSERT;
		if ($IsGuest)
		{
			$link_file = FILENAME_CREATE_GUEST_ACCOUNT;
			$navbar_title1 = NAVBAR_TITLE_CREATE_GUEST_ACCOUNT;
		}
		else
		{
			if ($IsEditAccount)
			{
				$link_file=FILENAME_ACCOUNT_EDIT;
				$navbar_title1 = NAVBAR_TITLE_1_ACCOUNT_EDIT;
				$navbar_file2=FILENAME_ACCOUNT_EDIT;
				$navbar_title1 = NAVBAR_TITLE_2_ACCOUNT_EDIT;
				$customers_email_type=$cInfo->customers_email_type;
				$image = 'button_update.gif';
				$alt = IMAGE_BUTTON_UPDATE;
			}
			else
			{
				$navbar_title1 = NAVBAR_TITLE_CREATE_ACCOUNT;
				$password_check = TRUE_STRING_S;
			}
		}
		$navbar_file1=$link_file;
	}
	else
	{
		if ($_GET['action'] == EMPTY_STRING)
		{
			$error = true;
		}
		$action = 'edit';
		$alt = IMAGE_INSERT;
	}
}
else
{
	if ($IsUserMode)
	{
		$form_name = MESSAGE_STACK_NAME;
		if ($IsCheckout)
		{
			if ($IsAccount)
			{
				$customers_gender=$cInfo->entry_gender;
				$customers_firstname=$cInfo->entry_firstname;
				$customers_lastname=$cInfo->entry_lastname;

				$link_file = FILENAME_ADDRESS_BOOK;
				$back_file =FILENAME_ADDRESS_BOOK;
				$navbar_title1 = NAVBAR_TITLE_1_ADDRESS_BOOK_PROCESS;
				$navbar_title2 = NAVBAR_TITLE_2_ADDRESS_BOOK_PROCESS;
				$navbar_file1=FILENAME_ACCOUNT;

				$navbar_title3 = NAVBAR_TITLE_2_ADDRESS_BOOK_PROCESS;
				$navbar_file3=FILENAME_ACCOUNT;
				$navbar_parameter3=FILENAME_ACCOUNT;
				if ($isset_edit_and_is_numeric_edit)
				{
					$navbar_parameter3='edit=' . $edit;
				} elseif ($is_numeric_delete) {
					$navbar_parameter3='delete=' . $edit;
				} else {
					$navbar_parameter3=EMPTY_STRING;
				}
				$navbar_title3 = NAVBAR_TITLE_MODIFY_ENTRY_ADDRESS_BOOK_PROCESS;
				$navbar_file3=FILENAME_ADDRESS_BOOK_PROCESS;
			}
			elseif ($IsCheckout_shipping)
			{
				$link_file = FILENAME_CHECKOUT_SHIPPING_ADDRESS;
				$back_file = FILENAME_CHECKOUT_SHIPPING;
				$navbar_title1 = NAVBAR_TITLE_1_CHECKOUT_SHIPPING_ADDRESS;
				$navbar_title2 = NAVBAR_TITLE_2_CHECKOUT_SHIPPING_ADDRESS;
				$navbar_file1=FILENAME_CHECKOUT_SHIPPING;
			}
			else	//if ($IsCheckout_payment)
			{
				$link_file = FILENAME_CHECKOUT_PAYMENT_ADDRESS;
				$back_file = FILENAME_CHECKOUT_PAYMENT;
				$navbar_title1 = NAVBAR_TITLE_1_PAYMENT_ADDRESS;
				$navbar_title2 = NAVBAR_TITLE_2_PAYMENT_ADDRESS;
				$navbar_file1=FILENAME_CHECKOUT_PAYMENT;
			}
			$navbar_file2 = $back_file;
		}
		else
		{
			$link_file = FILENAME_ACCOUNT;
			$navbar_file1 = $link_file;
			if ($EditAdressData)
			{
				$link_file = FILENAME_ADDRESS_BOOK_PROCESS;
				$back_file = FILENAME_ADDRESS_BOOK;
				$navbar_title1 = NAVBAR_TITLE_1_ADDRESS_BOOK_PROCESS;
				$navbar_title2 = NAVBAR_TITLE_2_ADDRESS_BOOK_PROCESS;
				$navbar_file2 = $back_file;
			}
			else //if ($EditPersonalData)
			{
				$link_file = FILENAME_ACCOUNT_EDIT;
				$back_file = FILENAME_ACCOUNT;
				$navbar_title1 = NAVBAR_TITLE_1_ACCOUNT_EDIT;
				$navbar_title2 = NAVBAR_TITLE_2_ACCOUNT_EDIT;
				$navbar_file2 = $link_file;
			}
		}
		$action = 'process';
		$image = 'button_update.gif';
		if ($IsUserMode)
		{
			$alt = IMAGE_BUTTON_UPDATE;
			$alt1= IMAGE_BUTTON_BACK;
		}
		else
		{
			$alt = IMAGE_UPDATE;
			$alt1= IMAGE_BACK;
		}

		$smarty->assign('BUTTON_BACK',HTML_A_START . olc_href_link($back_file, EMPTY_STRING, SSL) . '">' .
		olc_image_button('button_back.gif', $alt1) . HTML_A_END);
	}
	else
	{
		$action = 'update';

		$link_file = FILENAME_CUSTOMERS;
		$image = 'button_update.gif';
		if ($IsUserMode)
		{
			$alt = IMAGE_BUTTON_UPDATE;
		}
		else
		{
			$alt = IMAGE_UPDATE;
		}
	}
}
if ($EditAdressData || !$IsUserModeEdit)
{
	$entry_zone_id=$cInfo->entry_zone_id;
	if (!$entry_zone_id)
	{
		if ($IsCheckout)
		{
			$county=CUSTOMER_COUNTRY_ID;
		}
		else
		{
			$county=STORE_COUNTRY;
		}
		$entry_country_id = $county;
		$cInfo->entry_country_id = $county;
		$_SESSION['customer_country_id'] = $county;
		$cInfo->entry_zone_id = 1;
		$cInfo->entry_state = 1;
		$customers_email_type = EMAIL_USE_HTML ?  EMAIL_TYPE_HTML :  EMAIL_TYPE_TEXT;
		$error = true;
	}
	$from_table_zones = " from " . TABLE_ZONES . " where zone_country_id = '";
	$check_query = olc_db_query("select count(*) as total" . $from_table_zones . $cInfo->entry_country_id . APOS);
	$check_value = olc_db_fetch_array($check_query);
	$entry_state_has_zones = ($check_value['total'] > 0);
}
$not_IsCheckout=!$IsCheckout;
if ($not_IsCheckout)
{
	$onsubmit = 'onsubmit = "return check_form_new(' . $form_name . ', ' . $password_check . ');"';
}
if ($IsUserMode)
{
	$breadcrumb->add($navbar_title1, olc_href_link($navbar_file1, EMPTY_STRING, SSL));
	if ($IsUserModeEdit)
	{
		$breadcrumb->add($navbar_title2, olc_href_link($navbar_file2, EMPTY_STRING, SSL));
		if ($navbar_title3)
		{
			$breadcrumb->add($navbar_title3, olc_href_link($navbar_file3, $navbar_parameter3, SSL));
		}
	}
	require_once(DIR_WS_INCLUDES . 'header.php');
	if ($messageStack->size(MESSAGE_STACK_NAME) > 0)
	{
		$smarty->assign('error', $messageStack->output(MESSAGE_STACK_NAME));
	}
	if ($not_IsCheckout)
	{
		if ($IsEditAccount)
		{
			$default_address_id=olc_draw_hidden_field('default_address_id', $cInfo->customers_default_address_id);
		}
		$smarty->assign('FORM_ACTION', olc_draw_form($form_name, olc_href_link($link_file, EMPTY_STRING, SSL),
		'post', $onsubmit) . olc_draw_hidden_field('action', 'process').$default_address_id);
	}
}
else
{
	$onsubmit = str_replace('_new', EMPTY_STRING, $onsubmit);

	echo '<tr>' . olc_draw_form($form_name, $link_file, olc_get_all_get_params(array('action')) .
	'&action=' . $action,'post', $onsubmit) . olc_draw_hidden_field('default_address_id',
	$cInfo->customers_default_address_id);
}

$get_all_data = $EditPersonalData && $EditAdressData;

display_category_start(CATEGORY_PERSONAL);
$IsCreateAccountOrIsEditAccountOrIsCheckout=$IsCreateAccountOrIsEditAccount || $IsCheckout;
if (!$IsCreateAccountOrIsEditAccountOrIsCheckout)
{
	display_input_field('csID', false, '#FFDEAD', ENTRY_CID, EMPTY_STRING,'csID',
	$cInfo->customers_cid, MAX_LENGTH, MAX_SIZE, EMPTY_STRING, NO_INPUT, false, EMPTY_STRING, EMPTY_STRING);
}
if ($EditPersonalData || $IsUserModeEdit)
{
	if (ACCOUNT_GENDER==TRUE_STRING_S)
	{
		if ($customers_gender=='w')
		{
			$customers_gender='f';
		}
		display_radio_field(array('INPUT_MALE', 'INPUT_FEMALE'), ENTRY_GENDER,
		EMPTY_STRING,'customers_gender', array('m', 'f'), array(MALE, FEMALE),
		$customers_gender, $error, $entry_gender_error, ENTRY_GENDER_ERROR, EMPTY_STRING);
	}
	display_input_field('INPUT_FIRSTNAME', false, EMPTY_STRING, ENTRY_FIRST_NAME, EMPTY_STRING, 'customers_firstname',
	$customers_firstname, MAX_LENGTH, MAX_SIZE, EMPTY_STRING, $error,
	$entry_firstname_error, ENTRY_FIRST_NAME_ERROR, EMPTY_STRING,AJAX_VORNAMEN_VALIDATION,true,true);

	display_input_field('INPUT_LASTNAME', false, EMPTY_STRING, ENTRY_LAST_NAME, EMPTY_STRING, 'customers_lastname',
	$customers_lastname, MAX_LENGTH, MAX_SIZE, EMPTY_STRING, $error, $entry_lastname_error,
	ENTRY_LAST_NAME_ERROR, EMPTY_STRING);
	if ($not_IsCheckout)
	{
		if (ACCOUNT_DOB==TRUE_STRING_S)
		{
			$explanation_text=" (z.B. 11.12.1913)";
			display_input_field('INPUT_DOB', false, EMPTY_STRING, ENTRY_DATE_OF_BIRTH, EMPTY_STRING, 'customers_dob',
			olc_date_short($cInfo->customers_dob), MAX_LENGTH, MAX_SIZE, EMPTY_STRING, $error,
			$entry_dob_error, ENTRY_DATE_OF_BIRTH_ERROR, EMPTY_STRING,USE_AJAX,true);
			//$entry_dob_error, ENTRY_DATE_OF_BIRTH_ERROR, EMPTY_STRING,USE_AJAX && $IsUserMode,true);
		}
		if ($EditPersonalData)
		{
			//	W. Kaiser - eMail-type by customer
			$entry_error = EMPTY_STRING;
			if ($error)
			{
				if ($entry_email_address_error) {
					$entry_error_desc = ENTRY_EMAIL_ADDRESS_ERROR;
					$entry_error = true;
				} elseif ($entry_email_address_check_error) {
					$entry_error_desc = ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
					$entry_error = true;
				} elseif ($entry_email_address_exists) {
					$entry_error_desc = ENTRY_EMAIL_ADDRESS_ERROR_EXISTS;
					$entry_error = true;
				}
			}
			$add_html=HTML_BR .
			olc_draw_checkbox_field('customers_email_type', '1',($customers_email_type == EMAIL_TYPE_HTML) ? 1 : 0) . HTML_NBSP .
			(olc_not_null(ENTRY_HTMLEMAIL_TEXT) ? '<span class="footer">' . ENTRY_HTMLEMAIL_TEXT . ERROR_SPAN_END: EMPTY_STRING);

			display_input_field('INPUT_EMAIL', false, EMPTY_STRING, ENTRY_EMAIL_ADDRESS ,
			EMPTY_STRING, 'customers_email_address',
			$cInfo->customers_email_address, 'MAX_LENGTH="96"', EMPTY_STRING, EMPTY_STRING, $error, $entry_error,
			$entry_error_desc, $add_html,$validate_email_and_phone,true);
			//	W. Kaiser - eMail-type by customer
		}
	}
}

display_category_end();

if ($EditAdressData)
{
	if (ACCOUNT_COMPANY==TRUE_STRING_S)
	{
		$explanation_text=str_replace(HASH,', wenn Firmenanschrift',REQUIRED);
		display_category_start(CATEGORY_COMPANY);
		display_input_field('INPUT_COMPANY', false, EMPTY_STRING, ENTRY_COMPANY, EMPTY_STRING,'entry_company',
		$cInfo->entry_company, MAX_LENGTH, MAX_SIZE, EMPTY_STRING, NOT_REQUIRED, $entry_company_error,
		ENTRY_COMPANY_ERROR, EMPTY_STRING);
		display_category_end();
	}

	display_category_start(CATEGORY_ADDRESS);

	display_input_field('INPUT_STREET', false,EMPTY_STRING, ENTRY_STREET_ADDRESS, EMPTY_STRING,
	'entry_street_address',	$cInfo->entry_street_address, MAX_LENGTH, MAX_SIZE, EMPTY_STRING, $error,
	$entry_street_address_error,ENTRY_STREET_ADDRESS_ERROR, EMPTY_STRING);

	if (ACCOUNT_SUBURB==TRUE_STRING_S)
	{
		$explanation_text=HTML_NBSP.HTML_NBSP."(z.B. 'bei Müller', 'Hinterhaus')";
		display_input_field('INPUT_SUBURB', false, EMPTY_STRING, ENTRY_SUBURB, EMPTY_STRING,
		'entry_suburb',$cInfo->entry_suburb, MAX_LENGTH, MAX_SIZE, EMPTY_STRING, NOT_REQUIRED,
		$entry_suburb_error, ENTRY_SUBURB_ERROR, EMPTY_STRING);
	}
	if ($IsCreateAccountOrIsEditAccountOrIsCheckout)
	{
		$entry_country_id = CUSTOMER_COUNTRY_ID;
		$entry_state_has_zones = true;
	}
	else
	{
		$entry_country_id = $cInfo->entry_country_id;
	}
	if ($IsUserMode)
	{
		$countries = olc_get_countries();
		for ($i=0, $n=sizeof($countries); $i<$n; $i++) {
			$countries_array[] = array('id' => $countries[$i]['countries_id'],
			'text' => $countries[$i]['countries_name']);
		}
	}
	else
	{
		$countries_array = olc_get_countries();
	}
	$country_default = $cInfo->entry_country_id;
	display_pulldown_menu('SELECT_COUNTRY', ENTRY_COUNTRY, EMPTY_STRING, 'entry_country_id',
	$country_default, $countries_array, $error, $entry_country_error, ENTRY_COUNTRY_ERROR,
	EMPTY_STRING,AJAX_PLZ_VALIDATION);

	if (ACCOUNT_STATE==TRUE_STRING_S)
	{
		$input_state='INPUT_STATE';

		$entry_zone_id = $cInfo->entry_zone_id;
		$entry_state = olc_get_zone_name($entry_country_id, $entry_zone_id);
		if ($entry_state_has_zones)
		{
			$zones_array = array();
			$zones_query = olc_db_query("select zone_name from " . TABLE_ZONES .
			" where zone_country_id = '" . olc_db_input($entry_country_id) . "' order by zone_name");
			while ($zones_values = olc_db_fetch_array($zones_query)) {
				$zone_name = $zones_values['zone_name'];
				$zones_array[] = array('id' => $zone_name , 'text' => $zone_name );
			}
			display_pulldown_menu($input_state, ENTRY_STATE, EMPTY_STRING, ENTRY_STATE_TEXT_LOCAL,
			$entry_state, $zones_array, $error, $entry_state_error, ENTRY_STATE_ERROR, EMPTY_STRING);
		} else {
			display_input_field($input_state, false, EMPTY_STRING, ENTRY_STATE,EMPTY_STRING,ENTRY_STATE_TEXT_LOCAL,
			$entry_state , MAX_LENGTH, MAX_SIZE, EMPTY_STRING, $error, $entry_state_error, ENTRY_STATE_ERROR, EMPTY_STRING);
		}
	}
	display_input_field('INPUT_CODE', false, EMPTY_STRING, ENTRY_POST_CODE, EMPTY_STRING, 'entry_postcode',
	$cInfo->entry_postcode, MAX_LENGTH, 6, EMPTY_STRING, $error, $entry_post_code_error,
	ENTRY_POST_CODE_ERROR,EMPTY_STRING,AJAX_PLZ_VALIDATION,true,true);

	display_input_field('INPUT_CITY', false, EMPTY_STRING, ENTRY_CITY, EMPTY_STRING, 'entry_city',
	$cInfo->entry_city, MAX_LENGTH, MAX_SIZE, EMPTY_STRING, $error, $entry_city_error, ENTRY_CITY_ERROR, EMPTY_STRING);

	display_category_end();
}

if ($not_IsCheckout)
{
	if ($EditPersonalData)
	{
		display_category_start(CATEGORY_CONTACT);

		display_input_field('INPUT_TEL', false, EMPTY_STRING, ENTRY_TELEPHONE_NUMBER, EMPTY_STRING,
		'customers_telephone',$cInfo->customers_telephone, MAX_LENGTH, MAX_SIZE, EMPTY_STRING, $error,
		$entry_telephone_error, ENTRY_TELEPHONE_NUMBER_ERROR, EMPTY_STRING,$validate_email_and_phone,true);

		display_input_field('INPUT_FAX', false, EMPTY_STRING, ENTRY_FAX_NUMBER, EMPTY_STRING, 'customers_fax',
		$cInfo->customers_fax, MAX_LENGTH, MAX_SIZE, EMPTY_STRING, NOT_REQUIRED, $entry_fax_error,
		ENTRY_FAX_NUMBER_ERROR, EMPTY_STRING,$validate_email_and_phone,true);
		display_category_end();
	}
	if ($IsUserModeEdit)
	{
		if ($EditAdressData)
		{
			/*
			display_checkbox_field('CHECKBOX_PRIMARY', $field_desc, $field_desc_size, 'primary','on',
			$error, $entry_error, $entry_error_desc);
			*/
			$smarty->assign('CHECKBOX_PRIMARY',olc_draw_checkbox_field('primary', 'on', false));
		}
	}
	elseif ($get_all_data)
	{
		display_category_start(CATEGORY_OPTIONS);

		if ($IsCreateAccount)
		{
			if (!$IsGuest)
			{
				if ($customers_password == EMPTY_STRING)
				{
					if (!$IsUserMode)
					{
						require_once(DIR_FS_INC.'olc_create_password.inc.php');
						$customers_password = olc_RandomString(8);	//olc_create_password(8);
						$cInfo->customers_password=$customers_password;
					}
				}
				display_input_field('INPUT_PASSWORD', true, EMPTY_STRING, ENTRY_PASSWORD, EMPTY_STRING, 'customers_password',
				$cInfo->customers_password, MAX_LENGTH, MAX_SIZE, EMPTY_STRING, $error, $entry_password_error,
				ENTRY_PASSWORD_ERROR, EMPTY_STRING);
			}
			if ($IsUserMode)
			{
				$smarty->assign('CHECKBOX_NEWSLETTER',olc_draw_checkbox_field('newsletter', '1') . ENTRY_NEWSLETTER_TEXT);
				if (!$IsGuest)
				{
					display_input_field('INPUT_CONFIRMATION', true, EMPTY_STRING, ENTRY_PASSWORD_CONFIRMATION, EMPTY_STRING,
					'customers_password_confirmation', $customers_password_confirmation, MAX_LENGTH, MAX_SIZE, EMPTY_STRING,
					$error, $entry_password_confirmation_error, ENTRY_PASSWORD_ERROR_NOT_MATCHING, EMPTY_STRING);
				}
			}
			else
			{
				$field_desc_width = 300;	//EMPTY_STRING;	//
				display_pulldown_menu(EMPTY_STRING, ENTRY_CUSTOMERS_STATUS, $field_desc_width, 'status',
				$cInfo->customers_status, $customers_statuses_array, $error, 0, EMPTY_STRING);
				if (!$error)
				{
					$customers_send_mail = YES;
				}
				display_radio_field(EMPTY_STRING, ENTRY_MAIL, $field_desc_width, 'customers_mail',
				array('yes', 'no'), array(YES, NO), $customers_send_mail, $error, $entry_mail_error, ENTRY_MAIL_ERROR, EMPTY_STRING);

				echo field_start(ENTRY_MAIL_COMMENTS, $field_desc_width , EMPTY_STRING, EMPTY_STRING) .
				olc_draw_textarea_field('mail_comments', 'soft', '60', '5', $mail_comments) .
				'</td>
		</tr>';
			}
		}
		else
		{
			display_pulldown_menu(EMPTY_STRING, ENTRY_NEWSLETTER, EMPTY_STRING, 'customers_newsletter',
			$cInfo->customers_newsletter, $newsletter_array,
			NOT_REQUIRED, 0, EMPTY_STRING);

			include(DIR_WS_MODULES . FILENAME_CUSTOMER_MEMO);
		}

		display_category_end();
	}
}
elseif ($IsAccount)
{
	if ($_SESSION['customer_default_address_id'] != $_GET['edit'])
	{
		require_once(DIR_FS_INC.'olc_get_smarty_config_variable.inc.php');
		$entry_primary_text=olc_get_smarty_config_variable($smarty,'address_book_process','text_standard');
		display_checkbox_field('CHECKBOX_PRIMARY',$entry_primary_text, EMPTY_STRING, 'primary', 'on', EMPTY_STRING. $error,
		EMPTY_STRING, EMPTY_STRING);
		$smarty->assign('CHECKBOX_PRIMARY',true);
	}
	$smarty->assign('IS_ACCOUNT',true);
}
if ($IsUserMode)
{
	$smarty->assign('BUTTON_SUBMIT',olc_image_submit($image, $alt));
	$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . SMARTY_TEMPLATE .HTML_EXT,SMARTY_CACHE_ID);
	if (!defined('SMARTY_TARGET_AREA'))
	{
		define('SMARTY_TARGET_AREA',MAIN_CONTENT);
	}
	$smarty->assign(SMARTY_TARGET_AREA,$main_content);
	if ($not_IsCheckout)
	{
		require(BOXES);
		$smarty->display(INDEX_HTML);
	}
}
else
{
	if ($IsUserMode)
	{
		$alt1= IMAGE_BUTTON_CANCEL;
	}
	else
	{
		$alt1= IMAGE_CANCEL;
	}
	echo '
			<tr>
				<td align="right" class="main">' .
	olc_image_submit($image, $alt) .
	HTML_A_START .
	olc_href_link(FILENAME_CUSTOMERS, olc_get_all_get_params(array('action','validate'))) .'">' .
	olc_image_button('button_cancel.gif', $alt1) .
	'</a>
				</td>
			</tr>
		</form>';
}

function display_category_start($category_desc)
{
	global $IsUserMode;

	if (!$IsUserMode)
	{
		echo
		'<tr><td>&nbsp;</td></tr>
			<tr>
				<td class="formAreaTitle">' . $category_desc . '</td>
			</tr>
			<tr>
				<td class="formArea">
					<table border="0" cellspacing="2" cellpadding="2">';
	}
}

function display_category_end()
{
	global $IsUserMode;

	if (!$IsUserMode)
	{
		echo
		'			</table>
				</td>
			</tr>';
	}
}
function field_start($field_desc, $field_desc_size, $bg_color, $parameter)
{
	global $display_text, $IsUserMode;

	if ($IsUserMode)
	{
		global $smarty;
	}
	if ($field_desc_size == EMPTY_STRING)
	{
		$field_desc_size = 110;
	}
	if ($bg_color != EMPTY_STRING)
	{
		$bg_color = ' bgcolor = "' . $bg_color . '"';
	}
	$display_text =
	'			<tr>' .
	TD_START . ' width="' . $field_desc_size . '"' . $bg_color .  '>' . $field_desc . '</td>' .
	TD_START . $bg_color;
	if ($parameter != EMPTY_STRING) {
		$display_text .= BLANK . $parameter;
	}
	echo $display_text .  '>';
}

//W. Kaiser - AJAX
function display_input_field($smarty_name, $IsPasswordField, $field_backcolor, $field_desc, $field_desc_size,
$field_name, $field_value, $field_length, $field_size, $field_values_array, $error, $entry_error, $entry_error_desc,
$add_html,$AJAX_validate=false, $AJAX_required=false, $AJAX_add_span=false)
//W. Kaiser - AJAX
{
	global $display_text, $IsUserMode;

	if ($IsUserMode)
	{
		global $smarty;
	}
	field_init($field_name, $field_desc, $field_desc_size, $field_backcolor, $error, $entry_error,
	$entry_error_desc,$field_name==ENTRY_STATE_TEXT_LOCAL);
	$field_size='maxlength="'.$field_length.'" size="'.$field_size.'"';
	$required = ($error==NOT_REQUIRED) ? false : !$error;
	if ($IsPasswordField)
	{
		$display_text .= olc_draw_password_field($field_name, $field_value, $field_size, $required);
	}
	else
	{
		if ((int)$error == NO_INPUT)
		{
			$display_text .= $field_value . olc_draw_hidden_field($field_name, $field_value);
		}
		else
		{
			if ($IsUserMode)
			{
				$display_text .= olc_draw_input_field($field_name, $field_value, $field_size, "text",true,
				$AJAX_validate,$AJAX_required,$field_desc,$AJAX_add_span);
			}
			else
			{
				$display_text .= olc_draw_input_field($field_name, $field_value, $field_size, $required);
			}
		}
	}
	if ($IsUserMode)
	{
		if ($AJAX_add_span)
		{
			$display_text .='
						</span>';
		}
	}
	field_output($field_name, $smarty_name, $add_html);
}

//W. Kaiser - AJAX
function display_pulldown_menu($smarty_name, $field_desc, $field_desc_size, $field_name, $field_value,
$field_values_array, $error, $entry_error, $entry_error_desc, $add_html=EMPTY_STRING,$AJAX_validation=false)
{
	global  $display_text, $IsUserMode;
	if ($IsUserMode)
	{
		global $smarty;
	}
	field_init($field_name, $field_desc, $field_desc_size, $field_backcolor, $error, $entry_error,
	$entry_error_desc,$field_name==ENTRY_STATE_TEXT_LOCAL);

	$display_text .= olc_draw_pull_down_menu($field_name, $field_values_array,
	$field_value, EMPTY_STRING,false,$AJAX_validation==true);

	if ($IsUserMode)
	{
		if ($AJAX_add_span)
		{
			$display_text .='
						</span>';
		}
	}
	field_output($field_name, $smarty_name, $add_html);
}
//W. Kaiser - AJAX

function display_radio_field($smarty_name, $field_desc, $field_desc_size, $field_name, $field_conditions_array, $field_descriptions_array,$field_value, $error, $entry_error, $entry_error_desc, $add_html = EMPTY_STRING)
{
	field_init($field_name, $field_desc, $field_desc_size, $field_backcolor, $error, $entry_error, $entry_error_desc);

	global $have_entry_error, $error_text, $display_text, $IsUserMode;
	if ($IsUserMode)
	{
		global $smarty;
	}
	$IsSelected = false;
	$radio_buttons = sizeof($field_conditions_array) - 1;
	for ($radio_button = 0; $radio_button <= $radio_buttons; $radio_button++)
	{
		$field_condition = $field_conditions_array[$radio_button];
		if (!$entry_error){
			$IsSelected = $field_value == $field_condition;
		}
		$radio_field = olc_draw_radio_field($field_name, $field_condition, $IsSelected, $field_value);
		if ($IsUserMode)
		{
			if ($have_entry_error)
			{
				if ($radio_button == $radio_buttons)
				{
					$radio_field .= $error_text;
				}
			}
			$smarty->assign($smarty_name[$radio_button], $radio_field);
		}
		else
		{
			$display_text .= $radio_field . HTML_NBSP . $field_descriptions_array[$radio_button] . DOUBLE_SPACE;
		}
	}
	field_output($field_name, 'dummmy_radio', EMPTY_STRING);
}

function display_checkbox_field($smarty_name, $field_desc, $field_desc_size, $field_name,$field_condition,
	$field_value, $error, $entry_error, $entry_error_desc)
{
	field_init($field_name, $field_desc, $field_desc_size, $field_backcolor, $error, $entry_error, $entry_error_desc);

	global $have_entry_error, $error_text, $display_text, $IsUserMode;
	if ($IsUserMode)
	{
		global $smarty;
	}
	$checkbox_field = olc_draw_checkbox_field($field_name, $field_condition, false, $field_value);
	$checkbox_field .=  $field_desc. ERROR_SPAN_START . HTML_NBSP . ERROR_SPAN_END;
	if ($IsUserMode)
	{
		$smarty->assign($smarty_name, $checkbox_field);
	}
	else
	{
		$display_text .= $checkbox_field . DOUBLE_SPACE;
	}
	field_output($field_name, 'dummmy_check', EMPTY_STRING);
}

function field_init($field_name, $field_desc, $field_desc_size, $field_backcolor, $error, $entry_error,
$entry_error_desc,$use_state_error=false)
{
	global $IsUserMode, $display_text, $have_entry_error, $error_text,$explanation_text;

	if ($IsUserMode)
	{
		global $smarty;

		$display_text = EMPTY_STRING;
	}
	else
	{
		$display_text = field_start($field_desc , $field_desc_size, $field_backcolor, EMPTY_STRING);
	}
	$have_entry_error = false;
	$is_real_error=$error > 0;
	$have_explanation=$explanation_text!=EMPTY_STRING;
	if ($is_real_error or $have_explanation)
	{
		if ($entry_error)
		{
			$have_entry_error = true;
			if ($use_state_error)
			{
				$error_text = ERROR_SPAN_START_STATE . $entry_error_desc . ERROR_SPAN_END_STATE;
			}
			else
			{
				$error_text = ERROR_SPAN_START . $entry_error_desc . ERROR_SPAN_END;
			}
		}
		else
		{
			if ((int)$error != NOT_REQUIRED || $have_explanation)
			{
				$have_entry_error = true;
			}
			if ($is_real_error)
			{
				if ($use_state_error)
				{
					$error_text = TEXT_REQUIRED_NEW_STATE;
				}
				else
				{
					$error_text = TEXT_REQUIRED_NEW;
				}
			}
			else
			{
				$error_text = TEXT_REQUIRED_DUMMY;
			}
			$error_text=str_replace(HASH,$explanation_text,$error_text);
			$explanation_text=EMPTY_STRING;
		}
	}
}

function field_output($field_name, $smarty_name, $add_html)
{
	global $have_entry_error, $error_text, $display_text, $IsUserMode;

	$display_text .=  $add_html;
	if ($have_entry_error)
	{
		$display_text .='
				</td>';
		$display_text .= $error_text;
	}
	if ($IsUserMode)
	{
		global $smarty;
		$smarty->assign($smarty_name, $display_text);
	}
	else
	{
		echo $field_start . $display_text.
		'
			</tr>';
	}
}
?>