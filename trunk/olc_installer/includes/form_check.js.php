<?php
/* --------------------------------------------------------------
$Id: form_check.js.php,v 1.1.1.1.2.1 2007/04/08 07:18:38 gswkaiser Exp $

OL-Commerce Version 2.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(form_check.js.php,v 1.9 2003/05/19); www.oscommerce.com
(c) 2003	    nextcommerce (account.php,v 1.12 2003/08/17); www.nextcommerce.org
(c) 2004  		XT - Commerce; www.xt-ommerce.de

Released under the GNU General Public License
--------------------------------------------------------------*/
$comma=', "';
$script.='
<script language="javascript" type="text/javascript"><!--
var form = null;
var submitted = false;
var error = false;
var error_message = "";

function check_input(field_name, field_size, message) {
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var field_value = form.elements[field_name].value;

    if (field_value == "" || field_value.length < field_size)
    {
    	if (error_message.length>0)
    	{
    		error_message += "\n";
    	}
      error_message += message;
      error = true;
    }
  }
}

function check_radio(field_name, message) {
  var isChecked = false;

  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var radio = form.elements[field_name];

    for (var i=0; i<radio.length; i++) {
      if (radio[i].checked == true) {
        isChecked = true;
        break;
      }
    }

    if (isChecked == false) {
      error_message = error_message + message;
      error = true;
    }
  }
}

function check_select(field_name, field_default, message) {
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var field_value = form.elements[field_name].value;

    if (field_value == field_default) {
      error_message = error_message + message;
      error = true;
    }
  }
}

function check_password(field_name_1, field_name_2, field_size, message_1, message_2) {
  if (form.elements[field_name_1] && (form.elements[field_name_1].type != "hidden")) {
    var password = form.elements[field_name_1].value;
    var confirmation = form.elements[field_name_2].value;
    var pw_error_message;
    if (password == "" || password.length < field_size) {
      pw_error_message =  message_1;
      error = true;
    }
    else if (password != confirmation)
    {
      pw_error_message= message_2;
      error = true;
    }
    if (pw_error_message)
    {
    	if (error_message.length>0)
    	{
    		error_message += "\n";
    	}
      error_message += pw_error_message;
    }
  }
}

function country_drop_down_change(menu,target)
{
	document.getElementById("'.$country_1_text.'").value=document.getElementById("'.$country_text.'").value;
	document.getElementById("'.$install_action_text.'").value="";
';
	if (USE_AJAX)
	{
$script.='
		make_AJAX_Request_POST("'.$install_action_text.'",target);
';
	}
	else
	{
$script.='
		//location.href=target+\'?COUNTRY=\'+menu.value;
		document.forms["'.$install_text.'"].submit();
';
	}
$script.='
}

function check_form(form_name)
{
  if (submitted == true)
  {
    alert("'.JS_ERROR_SUBMITTED.'");
    return false;
  }
  error = false;
  form = document.forms[form_name];
  error_message = "'.JS_ERROR.'";
  check_input("FIRST_NAME", '.ENTRY_FIRST_NAME_MIN_LENGTH.$comma.ENTRY_FIRST_NAME_ERROR.'");
  check_input("LAST_NAME", '.ENTRY_LAST_NAME_MIN_LENGTH.$comma.ENTRY_LAST_NAME_ERROR.'");
  check_input("EMAIL_ADRESS", '.ENTRY_EMAIL_ADDRESS_MIN_LENGTH.$comma.ENTRY_EMAIL_ADDRESS_ERROR.'");
  check_input("STREET_ADRESS", '.ENTRY_STREET_ADDRESS_MIN_LENGTH.$comma.ENTRY_STREET_ADDRESS_ERROR.'");
  check_input("POST_CODE", '.ENTRY_POSTCODE_MIN_LENGTH.$comma.ENTRY_POST_CODE_ERROR.'");
  check_input("CITY", '.ENTRY_CITY_MIN_LENGTH.$comma.ENTRY_CITY_ERROR.'");
  check_input("TELEPHONE", '.ENTRY_TELEPHONE_MIN_LENGTH.$comma.ENTRY_TELEPHONE_NUMBER_ERROR.'");
  check_password("PASSWORD", "PASSWORD_CONFIRMATION", '.ENTRY_PASSWORD_MIN_LENGTH.$comma.ENTRY_PASSWORD_ERROR.QUOTE.$comma.
		ENTRY_PASSWORD_ERROR_NOT_MATCHING.'");
  check_input("STORE_NAME", '.ENTRY_LAST_NAME_MIN_LENGTH.$comma.ENTRY_STORE_NAME_ERROR.'");
  check_input("COMPANY", '.ENTRY_LAST_NAME_MIN_LENGTH.$comma.ENTRY_COMPANY_ERROR.'");
  check_input("EMAIL_ADRESS_FROM", '.ENTRY_EMAIL_ADDRESS_MIN_LENGTH.$comma.ENTRY_EMAIL_ADDRESS_FROM_ERROR.'");
	if (error)
	{
    alert(error_message);
    return false;
  }
  else
  {
    submitted = true;
';
if (USE_AJAX)
{
	$script.= '
		//Pass on to AJAX
		AJAX_submit(form_name,"");
		return false;
';
}
else
{
	$script.= '
		return true;
';
}
$script.= '
	}
}
//--></script>
';
