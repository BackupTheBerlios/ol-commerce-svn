<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_account_details.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_account_details.php, v 2.0 2003/09/29);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   Copyright (c) 2003 netz-designer
   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

// include needed functions
require_once(DIR_FS_INC.'olc_draw_radio_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_password_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');
require_once(DIR_FS_INC.'olc_date_short.inc.php');
require_once(DIR_FS_INC.'olc_get_country_list.inc.php');
require_once(DIR_FS_INC.'olc_get_zone_name.inc.php');

olc_smarty_init($module_smarty,$cacheid);

if (!isset($is_read_only)) $is_read_only = false;
if (!isset($processed)) $processed = false;

if (ACCOUNT_GENDER == TRUE_STRING_S) {
	$module_smarty->assign('ACCOUNT_GENDER', TRUE_STRING_S);
	$male = ($affiliate['affiliate_gender'] == 'm') ? true : false;
    $female = ($affiliate['affiliate_gender'] == 'f') ? true : false;
    if ($is_read_only == true) {
    	$gender_content = ($affiliate['affiliate_gender'] == 'm') ? MALE : FEMALE;
    }
	elseif ($error == true) {
		if ($entry_gender_error == true) {
			$gender_content = olc_draw_radio_field('a_gender', 'm', $male) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . olc_draw_radio_field('a_gender', 'f', $female) . '&nbsp;&nbsp;' . FEMALE . HTML_NBSP . ENTRY_GENDER_ERROR;
		}
		else {
			$gender_content = ($a_gender == 'm') ? MALE : FEMALE;
			$gender_content .= olc_draw_hidden_field('a_gender');
		}
	}
	else {
		$gender_content = olc_draw_radio_field('a_gender', 'm', $male) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . olc_draw_radio_field('a_gender', 'f', $female) . '&nbsp;&nbsp;' . FEMALE . HTML_NBSP . ENTRY_GENDER_TEXT;
    }
    $module_smarty->assign('gender_content', $gender_content);
}

if ($is_read_only == true) {
    $firstname_content = $affiliate['affiliate_firstname'];
} elseif ($error == true) {
    if ($entry_firstname_error == true) {
    	$firstname_content = olc_draw_input_field('a_firstname') . HTML_NBSP . ENTRY_FIRST_NAME_ERROR;
    }
	else {
		$firstname_content = $a_firstname . olc_draw_hidden_field('a_firstname');
    }
}
else {
	$firstname_content = olc_draw_input_field('a_firstname', $affiliate['affiliate_firstname']) . HTML_NBSP . ENTRY_FIRST_NAME_TEXT;
}
$module_smarty->assign('firstname_content', $firstname_content);

if ($is_read_only == true) {
    $lastname_content = $affiliate['affiliate_lastname'];
}
elseif ($error == true) {
	if ($entry_lastname_error == true) {
		$lastname_content = olc_draw_input_field('a_lastname') . HTML_NBSP . ENTRY_LAST_NAME_ERROR;
    }
	else {
		$lastname_content = $a_lastname . olc_draw_hidden_field('a_lastname');
    }
}
else {
	$lastname_content = olc_draw_input_field('a_lastname', $affiliate['affiliate_lastname']) . HTML_NBSP . ENTRY_FIRST_NAME_TEXT;
}
$module_smarty->assign('lastname_content', $lastname_content);

if (ACCOUNT_DOB == TRUE_STRING_S) {
	$module_smarty->assign('ACCOUNT_DOB', TRUE_STRING_S);
    if ($is_read_only == true) {
    	$dob_content = olc_date_short($affiliate['affiliate_dob']);
    }
	elseif ($error == true) {
		if ($entry_date_of_birth_error == true) {
			$dob_content = olc_draw_input_field('a_dob') . HTML_NBSP . ENTRY_DATE_OF_BIRTH_ERROR;
		}
		else {
			$dob_content = $a_dob . olc_draw_hidden_field('a_dob');
      	}
    }
	else {
		$dob_content = olc_draw_input_field('a_dob', olc_date_short($affiliate['affiliate_dob'])) . HTML_NBSP . ENTRY_DATE_OF_BIRTH_TEXT;
    }
    $module_smarty->assign('dob_content', $dob_content);
}

if ($is_read_only == true) {
    $email_content = $affiliate['affiliate_email_address'];
}
elseif ($error == true) {
	if ($entry_email_address_error == true) {
		$email_content = olc_draw_input_field('a_email_address') . HTML_NBSP . ENTRY_EMAIL_ADDRESS_ERROR;
    }
	elseif ($entry_email_address_check_error == true) {
		$email_content = olc_draw_input_field('a_email_address') . HTML_NBSP . ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
    }
	elseif ($entry_email_address_exists == true) {
		$email_content = olc_draw_input_field('a_email_address') . HTML_NBSP . ENTRY_EMAIL_ADDRESS_ERROR_EXISTS;
    }
	else {
		$email_content = $a_email_address . olc_draw_hidden_field('a_email_address');
    }
}
else {
	$email_content = olc_draw_input_field('a_email_address', $affiliate['affiliate_email_address']) . HTML_NBSP . ENTRY_EMAIL_ADDRESS_TEXT;
}
$module_smarty->assign('email_content', $email_content);

if (ACCOUNT_COMPANY == TRUE_STRING_S) {
	$module_smarty->assign('ACCOUNT_COMPANY', TRUE_STRING_S);
	if ($is_read_only == true) {
		$company_content = $affiliate['affiliate_company'];
    }
	elseif ($error == true) {
		if ($entry_company_error == true) {
			$company_content = olc_draw_input_field('a_company') . HTML_NBSP . ENTRY_AFFILIATE_COMPANY_ERROR;
		}
		else {
			$company_content = $a_company . olc_draw_hidden_field('a_company');
		}
    }
	else {
		$company_content = olc_draw_input_field('a_company', $affiliate['affiliate_company']) . HTML_NBSP . ENTRY_AFFILIATE_COMPANY_TEXT;
    }
    $module_smarty->assign('company_content', $company_content);

    if ($is_read_only == true) {
    	$company_taxid_content = $affiliate['affiliate_company_taxid'];
    }
	elseif ($error == true) {
		if ($entry_company_taxid_error == true) {
			$company_taxid_content = olc_draw_input_field('a_company_taxid') . HTML_NBSP . ENTRY_AFFILIATE_COMPANY_TAXID_ERROR;
		}
		else {
			$company_taxid_content = $a_company_taxid . olc_draw_hidden_field('a_company_taxid');
		}
    }
	else {
		$company_taxid_content = olc_draw_input_field('a_company_taxid', $affiliate['affiliate_company_taxid']) . HTML_NBSP . ENTRY_AFFILIATE_COMPANY_TAXID_TEXT;
    }
    $module_smarty->assign('company_taxid_content', $company_taxid_content);
}

if (AFFILIATE_USE_CHECK == TRUE_STRING_S) {
	$module_smarty->assign('AFFILIATE_USE_CHECK', TRUE_STRING_S);
	if ($is_read_only == true) {
		$payment_check_content = $affiliate['affiliate_payment_check'];
    }
	elseif ($error == true) {
		if ($entry_payment_check_error == true) {
			$payment_check_content = olc_draw_input_field('a_payment_check') . HTML_NBSP . ENTRY_AFFILIATE_PAYMENT_CHECK_ERROR;
		}
		else {
			$payment_check_content = $a_payment_check . olc_draw_hidden_field('a_payment_check');
		}
    }
	else {
		$payment_check_content = olc_draw_input_field('a_payment_check', $affiliate['affiliate_payment_check']) . HTML_NBSP . ENTRY_AFFILIATE_PAYMENT_CHECK_TEXT;
	}
	$module_smarty->assign('payment_check_content', $payment_check_content);
}

if (AFFILIATE_USE_PAYPAL == TRUE_STRING_S) {
	$module_smarty->assign('AFFILIATE_USE_PAYPAL', TRUE_STRING_S);
	if ($is_read_only == true) {
		$payment_paypal_content = $affiliate['affiliate_payment_paypal'];
    }
	elseif ($error == true) {
		if ($entry_payment_paypal_error == true) {
			$payment_paypal_content = olc_draw_input_field('a_payment_paypal') . HTML_NBSP . ENTRY_AFFILIATE_PAYMENT_PAYPAL_ERROR;
		}
		else {
			$payment_paypal_content = $a_payment_paypal . olc_draw_hidden_field('a_payment_paypal');
		}
	}
	else {
		$payment_paypal_content = olc_draw_input_field('a_payment_paypal', $affiliate['affiliate_payment_paypal']) . HTML_NBSP . ENTRY_AFFILIATE_PAYMENT_PAYPAL_TEXT;
    }
    $module_smarty->assign('payment_paypal_content', $payment_paypal_content);
}

if (AFFILIATE_USE_BANK == TRUE_STRING_S) {
	$module_smarty->assign('AFFILIATE_USE_BANK', TRUE_STRING_S);
	if ($is_read_only == true) {
		$payment_bank_name_content = $affiliate['affiliate_payment_bank_name'];
    }
	elseif ($error == true) {
		if ($entry_payment_bank_name_error == true) {
			$payment_bank_name_content = olc_draw_input_field('a_payment_bank_name') . HTML_NBSP . ENTRY_AFFILIATE_PAYMENT_BANK_NAME_ERROR;
		}
		else {
			$payment_bank_name_content = $a_payment_bank_name . olc_draw_hidden_field('a_payment_bank_name');
		}
	}
	else {
		$payment_bank_name_content = olc_draw_input_field('a_payment_bank_name', $affiliate['affiliate_payment_bank_name']) . HTML_NBSP . ENTRY_AFFILIATE_PAYMENT_BANK_NAME_TEXT;
    }
    $module_smarty->assign('payment_bank_name_content', $payment_bank_name_content);
    
    if ($is_read_only == true) {
    	$payment_bank_branch_number_content = $affiliate['affiliate_payment_bank_branch_number'];
    }
	elseif ($error == true) {
		if ($entry_payment_bank_branch_number_error == true) {
			$payment_bank_branch_number_content = olc_draw_input_field('a_payment_bank_branch_number') . HTML_NBSP . ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER_ERROR;
		}
		else {
			$payment_bank_branch_number_content = $a_payment_bank_branch_number . olc_draw_hidden_field('a_payment_bank_branch_number');
		}
	}
	else {
		$payment_bank_branch_number_content = olc_draw_input_field('a_payment_bank_branch_number', $affiliate['affiliate_payment_bank_branch_number']) . HTML_NBSP . ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER_TEXT;
    }
    $module_smarty->assign('payment_bank_branch_number_content', $payment_bank_branch_number_content);
    
    if ($is_read_only == true) {
    	$payment_bank_swift_code_content = $affiliate['affiliate_payment_bank_swift_code'];
    }
	elseif ($error == true) {
		if ($entry_payment_bank_swift_code_error == true) {
			$payment_bank_swift_code_content = olc_draw_input_field('a_payment_bank_swift_code') . HTML_NBSP . ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE_ERROR;
		}
		else {
			$payment_bank_swift_code_content = $a_payment_bank_swift_code . olc_draw_hidden_field('a_payment_bank_swift_code');
		}
	}
	else {
		$payment_bank_swift_code_content = olc_draw_input_field('a_payment_bank_swift_code', $affiliate['affiliate_payment_bank_swift_code']) . HTML_NBSP . ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE_TEXT;
    }
    $module_smarty->assign('payment_bank_swift_code_content', $payment_bank_swift_code_content);
    
    if ($is_read_only == true) {
    	$payment_bank_account_name_content = $affiliate['affiliate_payment_bank_account_name'];
    }
	elseif ($error == true) {
		if ($entry_payment_bank_account_name_error == true) {
			$payment_bank_account_name_content = olc_draw_input_field('a_payment_bank_account_name') . HTML_NBSP . ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME_ERROR;
		}
		else {
			$payment_bank_account_name_content = $a_payment_bank_account_name . olc_draw_hidden_field('a_payment_bank_account_name');
		}
	}
	else {
		$payment_bank_account_name_content = olc_draw_input_field('a_payment_bank_account_name', $affiliate['affiliate_payment_bank_account_name']) . HTML_NBSP . ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME_TEXT;
    }
    $module_smarty->assign('payment_bank_account_name_content', $payment_bank_account_name_content);
    
    if ($is_read_only == true) {
    	$payment_bank_account_number_content = $affiliate['affiliate_payment_bank_account_number'];
    }
	elseif ($error == true) {
		if ($entry_payment_bank_account_number_error == true) {
			$payment_bank_account_number_content = olc_draw_input_field('a_payment_bank_account_number') . HTML_NBSP . ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER_ERROR;
		}
		else {
			$payment_bank_account_number_content = $a_payment_bank_account_number . olc_draw_hidden_field('a_payment_bank_account_number');
		}
	}
	else {
		$payment_bank_account_number_content = olc_draw_input_field('a_payment_bank_account_number', $affiliate['affiliate_payment_bank_account_number']) . HTML_NBSP . ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER_TEXT;
    }
    $module_smarty->assign('payment_bank_account_number_content', $payment_bank_account_number_content);
}

if ($is_read_only == true) {
	$street_address_content = $affiliate['affiliate_street_address'];
}
elseif ($error == true) {
	if ($entry_street_address_error == true) {
		$street_address_content = olc_draw_input_field('a_street_address') . HTML_NBSP . ENTRY_STREET_ADDRESS_ERROR;
    }
	else {
		$street_address_content = $a_street_address . olc_draw_hidden_field('a_street_address');
    }
}
else {
	$street_address_content = olc_draw_input_field('a_street_address', $affiliate['affiliate_street_address']) . HTML_NBSP . ENTRY_STREET_ADDRESS_TEXT;
}
$module_smarty->assign('street_address_content', $street_address_content);

if (ACCOUNT_SUBURB == TRUE_STRING_S) {
	$module_smarty->assign('ACCOUNT_SUBURB', TRUE_STRING_S);
	if ($is_read_only == true) {
		$suburb_content = $affiliate['affiliate_suburb'];
    }
	elseif ($error == true) {
		if ($entry_suburb_error == true) {
			$suburb_content = olc_draw_input_field('a_suburb') . HTML_NBSP . ENTRY_SUBURB_ERROR;
		}
		else {
			$suburb_content = $a_suburb . olc_draw_hidden_field('a_suburb');
		}
	}
	else {
		$suburb_content = olc_draw_input_field('a_suburb', $affiliate['affiliate_suburb']) . HTML_NBSP . ENTRY_SUBURB_TEXT;
    }
    $module_smarty->assign('suburb_content', $suburb_content);
}

if ($is_read_only == true) {
	$postcode_content = $affiliate['affiliate_postcode'];
}
elseif ($error == true) {
	if ($entry_post_code_error == true) {
		$postcode_content = olc_draw_input_field('a_postcode') . HTML_NBSP . ENTRY_POST_CODE_ERROR;
    }
	else {
		$postcode_content = $a_postcode . olc_draw_hidden_field('a_postcode');
    }
}
else {
	$postcode_content = olc_draw_input_field('a_postcode', $affiliate['affiliate_postcode']) . HTML_NBSP . ENTRY_POST_CODE_TEXT;
}
$module_smarty->assign('postcode_content', $postcode_content);

if ($is_read_only == true) {
	$city_content = $affiliate['affiliate_city'];
}
elseif ($error == true) {
	if ($entry_city_error == true) {
		$city_content = olc_draw_input_field('a_city') . HTML_NBSP . ENTRY_CITY_ERROR;
    }
	else {
		$city_content = $a_city . olc_draw_hidden_field('a_city');
    }
}
else {
	$city_content = olc_draw_input_field('a_city', $affiliate['affiliate_city']) . HTML_NBSP . ENTRY_CITY_TEXT;
}
$module_smarty->assign('city_content', $city_content);

if ($is_read_only == true) {
	$country_id_content = olc_get_country_name($affiliate['affiliate_country_id']);
}
elseif ($error == true) {
	if ($entry_country_error == true) {
		$country_id_content = olc_get_country_list('a_country') . HTML_NBSP . ENTRY_COUNTRY_ERROR;
    }
	else {
		$country_id_content = olc_get_country_name($a_country) . olc_draw_hidden_field('a_country');
    }
}
else {
	$country_id_content = olc_get_country_list('a_country', $affiliate['affiliate_country_id']) . HTML_NBSP . ENTRY_COUNTRY_TEXT;
}
$module_smarty->assign('country_id_content', $country_id_content);

if (ACCOUNT_STATE == TRUE_STRING_S) {
	$module_smarty->assign('ACCOUNT_STATE', TRUE_STRING_S);
	$state = olc_get_zone_name($a_country, $a_zone_id, $a_state);
    if ($is_read_only == true) {
    	$state_content = olc_get_zone_name($affiliate['affiliate_country_id'], $affiliate['affiliate_zone_id'], $affiliate['affiliate_state']);
    }
	elseif ($error == true) {
		if ($entry_state_error == true) {
			if ($entry_state_has_zones == true) {
				$zones_array = array();
				$zones_query = olc_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . olc_db_input($a_country) . "' order by zone_name");
				while ($zones_values = olc_db_fetch_array($zones_query)) {
					$zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
				}
				$state_content = olc_draw_pull_down_menu('a_state', $zones_array) . HTML_NBSP . ENTRY_STATE_ERROR;
			}
			else {
				$state_content = olc_draw_input_field('a_state') . HTML_NBSP . ENTRY_STATE_ERROR;
			}
		}
		else {
			$state_content = $state . olc_draw_hidden_field('a_zone_id') . olc_draw_hidden_field('a_state');
		}
	}
	else {
		$state_content = olc_draw_input_field('a_state', olc_get_zone_name($affiliate['affiliate_country_id'], $affiliate['affiliate_zone_id'], $affiliate['affiliate_state'])) . HTML_NBSP . ENTRY_STATE_TEXT;
	}
	$module_smarty->assign('state_content', $state_content);
}

if ($is_read_only == true) {
	$telephone_content = $affiliate['affiliate_telephone'];
} elseif ($error == true) {
    if ($entry_telephone_error == true) {
    	$telephone_content = olc_draw_input_field('a_telephone') . HTML_NBSP . ENTRY_TELEPHONE_NUMBER_ERROR;
    }
	else {
		$telephone_content = $a_telephone . olc_draw_hidden_field('a_telephone');
    }
}
else {
	$telephone_content = olc_draw_input_field('a_telephone', $affiliate['affiliate_telephone']) . HTML_NBSP . ENTRY_TELEPHONE_NUMBER_TEXT;
}
$module_smarty->assign('telephone_content', $telephone_content);

if ($is_read_only == true) {
	$fax_content = $affiliate['affiliate_fax'];
}
elseif ($error == true) {
	if ($entry_fax_error == true) {
		$fax_content = olc_draw_input_field('a_fax') . HTML_NBSP . ENTRY_FAX_NUMBER_ERROR;
    }
	else {
		$fax_content = $a_fax . olc_draw_hidden_field('a_fax');
    }
}
else {
	$fax_content = olc_draw_input_field('a_fax', $affiliate['affiliate_fax']) . HTML_NBSP . ENTRY_FAX_NUMBER_TEXT;
}
$module_smarty->assign('fax_content', $fax_content);

if ($is_read_only == true) {
	$homepage_content = $affiliate['affiliate_homepage'];
}
elseif ($error == true) {
	if ($entry_homepage_error == true) {
		$homepage_content = olc_draw_input_field('a_homepage') . HTML_NBSP . ENTRY_AFFILIATE_HOMEPAGE_ERROR;
    }
	else {
		$homepage_content = $a_homepage . olc_draw_hidden_field('a_homepage');
    }
}
else {
	$homepage_content = olc_draw_input_field('a_homepage', $affiliate['affiliate_homepage']) . HTML_NBSP . ENTRY_AFFILIATE_HOMEPAGE_TEXT;
}
$module_smarty->assign('homepage_content', $homepage_content);

if ($is_read_only == false) {
	$module_smarty->assign('PASSWORD_READONLY', FALSE_STRING_S);
    if ($error == true) {
    	$module_smarty->assign('error', TRUE_STRING_S);
    	if ($entry_password_error == true) {
    		$password_content = olc_draw_password_field('a_password') . HTML_NBSP . ENTRY_PASSWORD_ERROR;
    	}
		else {
			$password_content = PASSWORD_HIDDEN . olc_draw_hidden_field('a_password') . olc_draw_hidden_field('a_confirmation');
		}
	}
	else {
		$password_content = olc_draw_password_field('a_password') . HTML_NBSP . ENTRY_PASSWORD_TEXT;
    }
    if ( ($error == false) || ($entry_password_error == true) ) {
    	$password_confirmation_content = olc_draw_password_field('a_confirmation') . HTML_NBSP . ENTRY_PASSWORD_CONFIRMATION_TEXT;
    }
    $agb_content = olc_draw_checkbox_field('a_agb', $value = '1', $checked = $affiliate['affiliate_agb']) . sprintf(ENTRY_AFFILIATE_ACCEPT_AGB, olc_href_link(FILENAME_CONTENT,'coID=900', SSL));
    if ($entry_agb_error == true) {
      $agb_content .= HTML_BR.ENTRY_AFFILIATE_AGB_ERROR;
    }
    $module_smarty->assign('agb_content', $agb_content);
	$module_smarty->assign('password_content', $password_content);
	$module_smarty->assign('password_confirmation_content', $password_confirmation_content);
}
$module= $module_smarty->fetch(CURRENT_TEMPLATE_MODULE . 'affiliate_account_details'.HTML_EXT,$cacheid);
$smarty->assign(MAIN_CONTENT, $module);
