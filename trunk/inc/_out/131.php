<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_check_customer_data.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:29 gswkaiser Exp $

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

$not_IsCheckout=!$IsCheckout;
if ($not_IsCheckout)
{
	// include needed functions
	require_once(DIR_FS_INC.'olc_validate_email.inc.php');
	require_once(DIR_FS_INC.'olc_encrypt_password.inc.php');
	$class_dir=DIR_WS_CLASSES;
	if ($IsAdminFunction)
	{
		$class_dir=DIR_FS_CATALOG.$class_dir;
	}
	require_once($class_dir . 'class.phpmailer.php');
	require_once(DIR_FS_INC.'olc_php_mail.inc.php');
}
if (!function_exists('check_input_error'))
{
	function check_input_error($entry_error_condition, $entry_error_text)
	{
		global $messageStack, $IsUserMode, $error;

		if ($entry_error_condition)
		{
			$error = true;
			if ($IsUserMode)
			{
				$messageStack->add(MESSAGE_STACK_NAME, $entry_error_text);
			}
			else
			{
				$messageStack->add($entry_error_text);
			}
		}
		return $entry_error_condition;
	}
}

if ($IsUserMode)
{
	if (!$IsUserModeEdit)
	{
		// Create new/guest account
		$EditPersonalData = true;
		$EditAdressData = true;
	}
}
else
{
	//Admin create/modify account
	$EditPersonalData = true;
	$EditAdressData = true;
}
$get_all_data = $EditPersonalData && $EditAdressData;

$error = false; // reset error flag

$from_table_zones = " from " . TABLE_ZONES . " where zone_country_id = '";

$customers_gender = olc_db_prepare_input($_POST['customers_gender']);
$customers_cid = olc_db_prepare_input($_POST['csID']);
$entry_country_id = olc_db_prepare_input($_POST['entry_country_id']);
$entry_city = olc_db_prepare_input($_POST['entry_city']);
$entry_postcode = olc_db_prepare_input($_POST['entry_postcode']);
$entry_street_address = olc_db_prepare_input($_POST['entry_street_address']);

$customers_firstname = olc_db_prepare_input($_POST['customers_firstname']);
$customers_lastname = olc_db_prepare_input($_POST['customers_lastname']);
if ($not_IsCheckout)
{
	$customers_dob = olc_db_prepare_input($_POST['customers_dob']);
	$customers_email_address = olc_db_prepare_input($_POST['customers_email_address']);
	//	W. Kaiser - eMail-type by customer
	$customers_email_type = (olc_db_prepare_input($_POST['customers_email_type']) == 1) ? EMAIL_TYPE_HTML : EMAIL_TYPE_TEXT;
	//	W. Kaiser - eMail-type by customer

	$customers_telephone = olc_db_prepare_input($_POST['customers_telephone']);
	$customers_fax = olc_db_prepare_input($_POST['customers_fax']);
	$default_address_id = olc_db_prepare_input($_POST['default_address_id']);
}
$entry_primary = olc_db_prepare_input($_POST['primary']);
$entry_company = olc_db_prepare_input($_POST['entry_company']);
$entry_suburb = olc_db_prepare_input($_POST['entry_suburb']);
$entry_state = olc_db_prepare_input($_POST['entry_state']);
$entry_zone_id = olc_db_prepare_input($_POST['entry_zone_id']);

$not_IsEditAccount=!$IsEditAccount;
if ($not_IsEditAccount)
{
	if ($IsCreateAccount)
	{
		$IsCreateUsermodeAccount = $IsUserMode;

		if ($IsGuest)
		{
			//create password
			$customers_password = olc_create_password(8);
			$customers_status_c = DEFAULT_CUSTOMERS_STATUS_ID_GUEST;
		}
		else
		{
			$customers_password = olc_db_prepare_input($_POST['customers_password']);
			$entry_password_error = check_input_error(strlen($customers_password) < ENTRY_PASSWORD_MIN_LENGTH, ENTRY_PASSWORD_ERROR);

			if ($IsUserMode)
			{
				$customers_password_confirmation = olc_db_prepare_input($_POST['customers_password_confirmation']);
				$entry_password_confirmation_error = check_input_error($customers_password != $customers_password_confirmation,
				ENTRY_PASSWORD_ERROR_NOT_MATCHING);
				$customers_status_c = DEFAULT_CUSTOMERS_STATUS_ID;
			}
			else
			{
				$customers_send_mail = olc_db_prepare_input($_POST['customers_mail']);
				$customers_mail_comments = olc_db_prepare_input($_POST['mail_comments']);
				$customers_status_c = olc_db_prepare_input($_POST['status']);
				$entry_mail_error =
				check_input_error(($customers_send_mail != 'yes') && ($customers_send_mail != 'no'), TEXT_REQUIRED);
			}
		}
	}
	else
	{
		$customers_id = olc_db_prepare_input($_GET['cID']);
		$customers_newsletter = olc_db_prepare_input($_POST['customers_newsletter']);
		$check_all_entries = !$IsUserMode;
	}
}
if (ACCOUNT_GENDER==TRUE_STRING_S)
{
	$entry_gender_error = check_input_error(($customers_gender != 'm') && ($customers_gender != 'f'), ENTRY_GENDER_ERROR);
}
$entry_firstname_error = check_input_error(strlen($customers_firstname) < ENTRY_FIRST_NAME_MIN_LENGTH, ENTRY_FIRST_NAME_ERROR);
$entry_lastname_error = check_input_error(strlen($customers_lastname) < ENTRY_LAST_NAME_MIN_LENGTH, ENTRY_LAST_NAME_ERROR);

if ($not_IsCheckout)
{
	if (ACCOUNT_DOB==TRUE_STRING_S)
	{
		$entry_dob_error = check_input_error(
		checkdate(substr(olc_date_raw($customers_dob), 4, 2), substr(olc_date_raw($customers_dob), 6, 2),
		substr(olc_date_raw($customers_dob), 0, 4)) == false,
		ENTRY_DATE_OF_BIRTH_ERROR);
	}
	$entry_email_address_error = check_input_error(strlen($customers_email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH,
	ENTRY_EMAIL_ADDRESS_ERROR);
	$email_ok=!$entry_email_address_error;
	if ($not_IsEditAccount)
	{
		if ($email_ok)
		{
			$entry_email_address_check_error = check_input_error(!olc_validate_email($customers_email_address),
			ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
			$email_ok=!$entry_email_address_check_error;
		}
	}
	if ($email_ok)
	{
		//---PayPal WPP Modification START ---//
		$check_email =
		olc_db_query("select customers_email_address, customers_id as id, customers_paypal_ec as ec from " .
		TABLE_CUSTOMERS .	" where customers_email_address = '" . olc_db_input($customers_email_address).APOS);
		if (olc_db_num_rows($check_email) > 0)
		{
			$check_email = olc_db_fetch_array($check_email);
			$m_customers_id=$check_email['id'];
			if ($check_email['ec'] == '1')
			{
				//It's a temp account, so delete it and let the user create a new one
				$where=" where customers_id = '" . $m_customers_id . APOS;
				olc_db_query(DELETE_FROM . TABLE_ADDRESS_BOOK . $where);
				olc_db_query(DELETE_FROM . TABLE_CUSTOMERS . $where);
				olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_INFO . " where customers_info_id" . $customers_id_db);
				olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET . $where);
				olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . $where);
				olc_db_query(DELETE_FROM . TABLE_PRODUCTS_NOTIFICATIONS . $where);
				olc_db_query(DELETE_FROM . TABLE_WHOS_ONLINE . $where);
				olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_STATUS_HISTORY . $where);
				olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_IP . $where);
			} else {
				if ($m_customers_id<>$customers_id)
				{
					$entry_email_address_exists = check_input_error(true,ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
				}
			}
		}
		//---PayPal WPP Modification END---//
	}
}
$entry_street_address_error = check_input_error(strlen($entry_street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH,
ENTRY_STREET_ADDRESS_ERROR);
$entry_post_code_error = check_input_error(strlen($entry_postcode) < ENTRY_POSTCODE_MIN_LENGTH, ENTRY_POST_CODE_ERROR);
$entry_city_error = check_input_error(strlen($entry_city) < ENTRY_CITY_MIN_LENGTH, ENTRY_CITY_ERROR);
$entry_country_error = check_input_error($entry_country_id == false, ENTRY_COUNTRY_ERROR);
if (ACCOUNT_STATE==TRUE_STRING_S)
{
	if ($entry_country_error)
	{
		$entry_state_error = true;
	}
	else
	{
		$zone_id = 0;
		$entry_state_error = check_input_error($entry_state_error, ENTRY_STATE_ERROR);
		$entry_country_id_db = $from_table_zones . $entry_country_id . APOS;
		$check_query = olc_db_query("select count(*) as total" . $entry_country_id_db);
		$check_value = olc_db_fetch_array($check_query);
		$entry_state_has_zones = ($check_value['total'] > 0);
		$entry_state_db = olc_db_input($entry_state);
		if ($entry_state_has_zones)
		{
			$sql_select="select zone_id" . $entry_country_id_db . " and zone_";
			$sql_select1=" = '" . $entry_state_db .  APOS;
			$zone_query = olc_db_query($sql_select. "name".$sql_select1);
			if (olc_db_num_rows($zone_query) == 1) {
				$zone_values = olc_db_fetch_array($zone_query);
				$entry_zone_id = $zone_values['zone_id'];
			} else {
				$zone_query = olc_db_query($sql_select . "code".$sql_select1);
				if (olc_db_num_rows($zone_query) >= 1) {
					$zone_values = olc_db_fetch_array($zone_query);
					$entry_zone_id = $zone_values['zone_id'];
				} else {
					$error = true;
					$entry_state_error = true;
				}
			}
		}
		else
		{
			if (!$entry_state)
			{
				$error = true;
				$entry_state_error = true;
			}
		}
	}
}
if ($not_IsCheckout)
{
	$entry_telephone_error = check_input_error(strlen($customers_telephone) < ENTRY_TELEPHONE_MIN_LENGTH,
	ENTRY_TELEPHONE_NUMBER_ERROR);
	if ($customers_fax<>EMPTY_STRING)
	{
		$entry_fax_error = check_input_error(strlen($customers_fax) < ENTRY_TELEPHONE_MIN_LENGTH, ENTRY_FAX_NUMBER_ERROR);
	}
}
if ($error)
{
	if (!class_exists('objectInfo'))
	{
		// entry/item info classes
		require_once(DIR_WS_CLASSES.'object_info.php');
	}
	$cInfo = new objectInfo($_POST);
	$processed = true;
}
else
{
	if ($IsCheckout)
	{
		$sql_data_array = array(
		'customers_id' => CUSTOMER_ID,
		'entry_firstname' => $customers_firstname,
		'entry_lastname' => $customers_lastname,
		'entry_street_address' => $entry_street_address,
		'entry_postcode' => $entry_postcode,
		'entry_city' => $entry_city,
		'entry_country_id' => $entry_country_id,
		'entry_gender' => $customers_gender,
		'entry_company' => $entry_company,
		'entry_suburb' => $entry_suburb,
		'entry_zone_id' => $entry_zone_id,
		'entry_state' => $entry_state);
		if ($IsAccount && $is_update)
		{
			$db_action='update';
			$db_parameter=$update_parameter;
		}
		else
		{
			$db_action='insert';
			$db_parameter=EMPTY_STRING;
		}
		olc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array,$db_action,$db_parameter);
		if ($IsAccount)
		{
			$set_primary=$entry_primary == 'on';
			if ($is_update)
			{
				if ($set_primary || ($edit == $_SESSION['customer_default_address_id']))
				{
					$set_primary=true;
					$new_address_book_id=$edit;
				}
			}
			else
			{
				$new_address_book_id = olc_db_insert_id();
			}
			if ($set_primary)
			{
				// reregister session variables
				$_SESSION['customer_first_name'] = $customers_firstname;
				$_SESSION['customer_last_name'] = $customers_lastname;
				$_SESSION['customer_country_id'] = $entry_country_id;
				$_SESSION['customer_zone_id'] = $entry_zone_id;

				$_SESSION['customer_default_address_id'] = $new_address_book_id;

				$sql_data_array = array(
				'customers_firstname' => $customers_firstname,
				'customers_lastname' => $customers_lastname,
				'customers_gender' => $customers_gender,
				'customers_default_address_id' => $new_address_book_id
				);
				olc_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id='".CUSTOMER_ID.APOS);
			}
			if ($is_update)
			{
				$message=SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED;
			}
			else
			{
				$message=SUCCESS_ADDRESS_BOOK_ENTRY_INSERTED;
			}
			if (IS_AJAX_PROCESSING)
			{
				include_once(DIR_FS_INC.'ajax_info.inc.php');
				ajax_info($message);
			}
			else
			{
				$messageStack->add_session(MESSAGE_STACK_NAME, $message, 'success');
			}

		}
		$action=EMPTY_STRING;
	}
	else
	{
		if ($EditPersonalData)
		{
			$sql_data_array = array(
			'customers_firstname' => $customers_firstname,
			'customers_lastname' => $customers_lastname,
			'customers_email_address' => $customers_email_address,
			//	W. Kaiser - eMail-type by customer
			'customers_email_type' => $customers_email_type,
			//	W. Kaiser - eMail-type by customer
			'customers_telephone' => $customers_telephone,
			'customers_fax' => $customers_fax,
			'customers_gender' => $customers_gender,
			'customers_dob'=> olc_date_raw($customers_dob)
			);
			if ($IsCreateAccount)
			{
				$_SESSION['account_type'] = $customers_status_c ;
				$sql_data_array['account_type'] = $customers_status_c;
				if ($IsUserMode)
				{
					$sql_data_array['customers_newsletter'] = $customers_newsletter;
				}
				$sql_data_array['customers_password'] = olc_encrypt_password($customers_password);

				// Automatisch fortlaufende Kundennummer erzeugen:
				$start_cid = 21724;		//Gewünschte Start-Nummer

				$result = olc_db_fetch_array(olc_db_query("select max(customers_cid) as cidmax from " . TABLE_CUSTOMERS));
				$customers_cid = $result['cidmax'] ? $result['cidmax'] + 1 : $start_cid;
				$sql_data_array['customers_cid'] = $customers_cid;
				// End Kundennummer Mod

				$sql_data_array['customers_status'] = $customers_status_c;
				$sql_data_array['customers_password'] = olc_encrypt_password($customers_password);

				$action = 'insert';
				$parameters = EMPTY_STRING;
			}
			else
			{
				if ($not_IsEditAccount)
				{
					$sql_data_array['customers_newsletter'] = $customers_newsletter;
				}
				$action = 'update';
				$parameters = "customers_id = '" . $customers_id . APOS;
			}
			olc_db_perform(TABLE_CUSTOMERS, $sql_data_array, $action, $parameters);

			//if ($IsCreateUsermodeAccount)
			if ($IsCreateAccount)
			{
				$_SESSION['customer_id'] = olc_db_insert_id();
			}
			$sql_data_array = array(
			'entry_gender' => $customers_gender,
			'entry_firstname' => $customers_firstname,
			'entry_lastname' => $customers_lastname,
			'entry_company' => $entry_company,
			'entry_street_address' => $entry_street_address,
			'entry_suburb' => $entry_suburb,
			'entry_postcode' => $entry_postcode,
			'entry_city' => $entry_city,
			'entry_country_id' => $entry_country_id,
			'entry_zone_id' => $entry_zone_id,
			'entry_state' => $entry_state);
			if ($IsCreateAccount)
			{
				$cc_id = olc_db_insert_id();
				$sql_data_array['customers_id'] = $cc_id;
			}
			else
			{
				$cc_id=olc_db_input($default_address_id);
				$parameters .= " and address_book_id = '" . $cc_id . APOS;
			}
			olc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array, $action, $parameters);
			if ($IsCreateAccount)
			{
				$address_id = olc_db_insert_id();
				olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS . " set customers_default_address_id = '" . $address_id .
				"' where customers_id = '" . $cc_id . APOS);
				if ($IsUserMode)
				{
					olc_db_query(INSERT_INTO . TABLE_CUSTOMERS_INFO .
					" (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created)
					values ('" . CUSTOMER_ID . "', '0', now())");
					if (SESSION_RECREATE)
					{
						olc_session_recreate();
					}
					// restore cart contents
					$_SESSION['cart']->restore_contents();
				}
				else
				{
					if ($customers_status_c=='0')
					{
						olc_db_query(INSERT_INTO . TABLE_ADMIN_ACCESS." (customers_id,start) VALUES ('".$cc_id."','1')");
					}
				}
			}
			if ($IsUserMode)
			{
				$_SESSION['customer_first_name'] = $customers_firstname;
				$_SESSION['customer_default_address_id'] = $address_id;
				$_SESSION['customer_country_id'] = $entry_country;
				$_SESSION['customer_zone_id'] = $entry_zone_id;
			}
		}
		else
		{
			$memo_title = $_POST['memo_title'];
			if ($memo_title)
			{
				$memo_text =$_POST['memo_text'];
				if ($memo_text)
				{
					$sql_data_array = array(
					'customers_id' => $customers_id,
					'memo_date' => date("Y-m-d"),
					'memo_title' =>olc_db_prepare_input($memo_title),
					'memo_text' =>olc_db_prepare_input($memo_text),
					'poster_id' => $_SESSION['customer_id']
					);
					olc_db_perform(TABLE_CUSTOMERS_MEMO, $sql_data_array);
				}
			}
		}
	}
}
?>