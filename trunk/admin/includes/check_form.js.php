<?php 
//
//	W. Kaiser - Common code for "create_account.php" and "customers.php"
//
$code = '

<script language="javascript" type="text/javascript"><!--
function check_form() {
	var error = 0;
	var error_message = "' . JS_ERROR. '";

	var customers_firstname = document.customers.customers_firstname.value;
	var customers_lastname = document.customers.customers_lastname.value;';
	if (ACCOUNT_COMPANY) 
	{
		$code .= 'var entry_company = document.customers.entry_company.value;';
	}
	if (ACCOUNT_DOB) 
	{
		$code .= 'var customers_dob = document.customers.customers_dob.value;';
	}
	$code .= '
	var customers_email_address = document.customers.customers_email_address.value;
	var entry_street_address = document.customers.entry_street_address.value;
	var entry_postcode = document.customers.entry_postcode.value;
	var entry_city = document.customers.entry_city.value;
	var customers_telephone = document.customers.customers_telephone.value;';

	if (ACCOUNT_GENDER) 
	{
		$code .= '
		if (document.customers.customers_gender[0].checked || document.customers.customers_gender[1].checked) {
		} else {
			error_message = error_message + "' . JS_GENDER . '";
			error = 1;
		}';
	}

	$code .= '
	if (customers_firstname == "" || customers_firstname.length < ' . ENTRY_FIRST_NAME_MIN_LENGTH. ') {
		error_message = error_message + "' . JS_FIRST_NAME . '";
		error = 1;
	}

	if (customers_lastname == "" || customers_lastname.length < ' . ENTRY_LAST_NAME_MIN_LENGTH. ') {
		error_message = error_message + "' . JS_LAST_NAME . '";
		error = 1;
	}';

	if (ACCOUNT_DOB) {
		$code .= '
		if (customers_dob == "" || customers_dob.length < ' . ENTRY_DOB_MIN_LENGTH. ') {
			error_message = error_message + "' . JS_DOB . '";
			error = 1;
		}';
	}
	$code .= '
	if (customers_email_address == "" || customers_email_address.length < ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH. ') {
		error_message = error_message + "' . JS_EMAIL_ADDRESS . '";
		error = 1;
	}

	if (entry_street_address == "" || entry_street_address.length < ' . ENTRY_STREET_ADDRESS_MIN_LENGTH. ') {
		error_message = error_message + "' . JS_ADDRESS . '";
		error = 1;
	}

	if (entry_postcode == "" || entry_postcode.length < ' . ENTRY_POSTCODE_MIN_LENGTH. ') {
		error_message = error_message + "' . JS_POST_CODE . '";
		error = 1;
	}

	if (entry_city == "" || entry_city.length < ' . ENTRY_CITY_MIN_LENGTH. ') {
		error_message = error_message + "' . JS_CITY . '";
		error = 1;
	}';

	if (ACCOUNT_STATE) {
		$code .= '
		if (document.customers.elements["entry_state"].type != "hidden") {
			if (document.customers.entry_state.value == "" || document.customers.entry_state.value.length < ' . ENTRY_STATE_MIN_LENGTH. ' ) {
				error_message = error_message + "' . JS_STATE . '";
				error = 1;
			}
		}';
	}

	$code .= '
	if (document.customers.elements["entry_country_id"].type != "hidden") {
		if (document.customers.entry_country_id.value == 0) {
			error_message = error_message + "' . JS_COUNTRY . '";
			error = 1;
		}
	}

	if (customers_telephone == "" || customers_telephone.length < ' . ENTRY_TELEPHONE_MIN_LENGTH. ') {
		error_message = error_message + "' . JS_TELEPHONE . '";
		error = 1;
	}

	if (error == 1) {
		alert(error_message);
		return false;
	} else {
		return true;
	}
}
//--></script>
';
echo $code;
?>
