<?php
/* -----------------------------------------------------------------------------------------
$Id: form_check.js.php,v 1.1.1.1.2.1 2007/04/08 07:17:45 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(form_check.js.php,v 1.9 2003/05/19); www.oscommerce.com
(c) 2003	    nextcommerce (form_check.js.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX

define('COMMA_BLANK','","');
define('COMMA_BLANK_1',',"');

$my_script='

<script language="javascript" type="text/javascript"><!--

//form_check.js.php

var form="";
//var submitted=false;
var error=false;
var error_message="";

function check_input(field_name, field_size, message) 
{
	var field=form.elements[field_name];

	if (field)
	{
		if (field.type != "hidden")
		{
			var field_value=field.value;

			if (field_value == "" || field_value.length < field_size)
			{
				error_message=error_message + "* " + message + "\n";
				error=true;
			}
		}
		return error;
	}
}

function check_radio(field_name, message) {
	var isChecked=false;

	var radio=form.elements[field_name];
	if (radio && (radio.type != "hidden")) {

		for (var i=0; i<radio.length; i++) {
			if (radio[i].checked == true) {
				isChecked=true;
				break;
			}
		}

		if (isChecked == false) {
			error_message=error_message + "* " + message + "\n";
			error=true;
		}
	}
}

function check_select(field_name, field_default, message) {
	var field=form.elements[field_name];

	if (field && (field.type != "hidden")) {
		var field_value=field.value;

		if (field_value == field_default) {
			error_message=error_message + "* " + message + "\n";
			error=true;
		}
	}
}

function check_password(field_name_1, field_name_2, field_size, message_1, message_2) {
	var field_1=form.elements[field_name_1];
	if (field_1) {
		if ((field_1.type != "hidden")) {
			var password=field_1.value;
			var confirmation=form.elements[field_name_2].value;

			if (password.length < field_size) {
				error_message=error_message + "* " + message_1 + "\n";
				error=true;
			} else if (password != confirmation) {
				error_message=error_message + "* " + message_2 + "\n";
				error=true;
			}
		}
	}
}

function check_password_new(field_name_1, field_name_2, field_name_3, field_size, message_1, message_2, message_3) {
	var field_1=form.elements[field_name_1];
	if (field_1)
	{
		if (field_1.type != "hidden") {
			var password_current=field_1.value;
			var password_new=form.elements[field_name_2].value;
			var password_confirmation=form.elements[field_name_3].value;
			if (password_current == "" || password_current.length < field_size)
			{
				error_message=error_message + "* " + message_1 + "\n";
				error=true;
			}
			else if (password_new == "" || password_new.length < field_size)
			{
				error_message=error_message + "* " + message_2 + "\n";
				error=true;
			}
			else if (password_new != password_confirmation)
			{
				error_message=error_message + "* " + message_3 + "\n";
				error=true;
			}
		}
	}
}

function check_form(form_name)
{
	/*
	if (submitted == true)
	{
		alert("'.JS_ERROR_SUBMITTED.'");
		return false;
	}
	*/
';
if (USE_AJAX)
{
	$my_script.='
	//W. Kaiser - AJAX
 	if (!check_validation_done())
	{
		return false;
	}
	//W. Kaiser - AJAX
	';
}
$my_script.='
	error=false;
	form=form_name;
	if (typeof(form) == "string")
	{
		form = document.getElementById(form);
	}
	error_message="'.JS_ERROR.'";';
$trailer='");';
if (ACCOUNT_GENDER) $my_script.= '
  check_radio("gender", "' . ENTRY_GENDER_ERROR . $trailer;
$my_script.= '
	check_input("firstname", '.ENTRY_FIRST_NAME_MIN_LENGTH.COMMA_BLANK_1.ENTRY_FIRST_NAME_ERROR.'");
	check_input("lastname", '.ENTRY_LAST_NAME_MIN_LENGTH.COMMA_BLANK_1.ENTRY_LAST_NAME_ERROR.$trailer;
if (ACCOUNT_DOB) $my_script.= '
  check_input("dob", ' . ENTRY_DOB_MIN_LENGTH . COMMA_BLANK_1 . ENTRY_DATE_OF_BIRTH_ERROR . $trailer;
$my_script.=
'	check_input("email_address", '.ENTRY_EMAIL_ADDRESS_MIN_LENGTH.COMMA_BLANK_1.ENTRY_EMAIL_ADDRESS_ERROR.'");
	check_input("street_address", '.ENTRY_STREET_ADDRESS_MIN_LENGTH.COMMA_BLANK_1.ENTRY_STREET_ADDRESS_ERROR.'");
	check_input("postcode", '.ENTRY_POSTCODE_MIN_LENGTH.COMMA_BLANK_1.ENTRY_POST_CODE_ERROR.'");
	check_input("city", '.ENTRY_CITY_MIN_LENGTH.COMMA_BLANK_1.ENTRY_CITY_ERROR.$trailer;
if (ACCOUNT_STATE) $my_script.= '
  check_input("state", ' . ENTRY_STATE_MIN_LENGTH . COMMA_BLANK_1 . ENTRY_STATE_ERROR . $trailer;
$my_script.= '
	check_select("country", "", "'.ENTRY_COUNTRY_ERROR.'");
	check_input("telephone", '.ENTRY_TELEPHONE_MIN_LENGTH.COMMA_BLANK_1.ENTRY_TELEPHONE_NUMBER_ERROR.'");
	check_password("password", "confirmation", '.ENTRY_PASSWORD_MIN_LENGTH.COMMA_BLANK_1.ENTRY_PASSWORD_ERROR.COMMA_BLANK.
ENTRY_PASSWORD_ERROR_NOT_MATCHING.'");
	check_password_new("password_current", "password_new", "password_confirmation", '.ENTRY_PASSWORD_MIN_LENGTH.COMMA_BLANK_1.
ENTRY_PASSWORD_ERROR.COMMA_BLANK.ENTRY_PASSWORD_NEW_ERROR.COMMA_BLANK.ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING.'");
	if (error == true) {
		alert(error_message);
		return false;
	} else {
		//submitted=true;
		//W. Kaiser - AJAX
';
if (USE_AJAX)
{
	$my_script.= '
			//Pass on to AJAX
			AJAX_submit(form_name,"");
			return false;
';
}
else
{
	$my_script.= '
			return true;
';
}
$my_script.= '
		//W. Kaiser - AJAX
	}
}

//	W. Kaiser - Common code for "create_account.php" and "customers.php"
function check_form_new(form_name, password_check) {
	if (submitted == true)
	{
		alert("'.JS_ERROR_SUBMITTED.'");
		return false;
	}
';

if (USE_AJAX)
{
	$my_script.='
	//W. Kaiser - AJAX
 	if (!check_validation_done())
	{
		return false;
	}
	//W. Kaiser - AJAX
';
}

$my_script.= '
	error=false;
	form=form_name;
	if (typeof(form) == "string")
	{
		form = document.getElementById(form);
	}
	error_message="'.JS_ERROR.'";';
$trailer='");';
if (ACCOUNT_GENDER) 
{
	$my_script.= '
  check_radio("customers_gender", "' . ENTRY_GENDER_ERROR . $trailer;
}
$my_script.= '
	check_input("customers_firstname", '.ENTRY_FIRST_NAME_MIN_LENGTH.COMMA_BLANK_1.ENTRY_FIRST_NAME_ERROR.'");
	check_input("customers_lastname", '.ENTRY_LAST_NAME_MIN_LENGTH.COMMA_BLANK_1.ENTRY_LAST_NAME_ERROR.$trailer;
if (ACCOUNT_DOB) 
{
	$my_script.= '
  check_input("customers_dob", ' . ENTRY_DOB_MIN_LENGTH . COMMA_BLANK_1.ENTRY_DATE_OF_BIRTH_ERROR . $trailer;
}
$my_script.= '
	check_input("customers_email_address", '.ENTRY_EMAIL_ADDRESS_MIN_LENGTH.COMMA_BLANK_1.ENTRY_EMAIL_ADDRESS_ERROR.'");
	check_input("entry_street_address", '.ENTRY_STREET_ADDRESS_MIN_LENGTH.COMMA_BLANK_1.ENTRY_STREET_ADDRESS_ERROR.'");
	check_input("entry_postcode", '.ENTRY_POSTCODE_MIN_LENGTH.COMMA_BLANK_1.ENTRY_POST_CODE_ERROR.'");
	check_input("entry_city", '.ENTRY_CITY_MIN_LENGTH.COMMA_BLANK_1.ENTRY_CITY_ERROR.$trailer;
if (ACCOUNT_STATE) 
{
	$my_script.= '
  check_input("entry_state", ' . ENTRY_STATE_MIN_LENGTH . COMMA_BLANK_1 .	ENTRY_STATE_ERROR . $trailer;
}
$my_script.= '
	check_select("entry_country", "", "'.ENTRY_COUNTRY_ERROR.'");
	if (check_input("customers_telephone", '.ENTRY_TELEPHONE_MIN_LENGTH.COMMA_BLANK_1.ENTRY_TELEPHONE_NUMBER_ERROR.'"))
	{
		var fon=form.elements["customers_telephone"];
		if (fon)
		{
			fon=fon.value;
			if (fon.substr(fon.length-1)=="-")
			{
				error_message=error_message + "* '.ENTRY_TELEPHONE_NUMBER_ERROR.'\n";
				error=true;
			}
		}
	}
	var fax=form.elements["customers_fax"];
	if (fax)
	{
		fax=fax.value;
		if (fax.substr(fax.length-1)!="-")
		{
			check_input("customers_fax", '.ENTRY_TELEPHONE_MIN_LENGTH.COMMA_BLANK_1.ENTRY_FAX_NUMBER_ERROR.'");
		}
	}
	if (password_check)
	{
		check_password_new("password_current", "password_new", "password_confirmation", '.ENTRY_PASSWORD_MIN_LENGTH.
	COMMA_BLANK_1.ENTRY_PASSWORD_ERROR.COMMA_BLANK.ENTRY_PASSWORD_NEW_ERROR.COMMA_BLANK.ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING.'");
	}
debug_stop();	
	if (error)
	{
		alert(error_message);
		return false;
	} else {
		//submitted=true;
		//W. Kaiser - AJAX
';
if (USE_AJAX)
{
	$my_script.= '
		//Pass on to AJAX
		AJAX_submit(form_name,"");
		return false;
';
}
else
{
	$my_script.= '
		return true;
';
}
$my_script.= '
		//W. Kaiser - AJAX
	}
}
//	W. Kaiser - Common code for "create_account.php" and "customers.php"

//form_check.js.php

--></script>
';

if (USE_AJAX)
{
	$script.=$my_script;
}
else
{
	echo $my_script;
}
//W. Kaiser - AJAX
?>