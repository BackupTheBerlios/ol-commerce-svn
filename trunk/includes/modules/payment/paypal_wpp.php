<?php
/*
$Id: paypal_wpp.php,v 1.1.1.1.2.1 2007/04/08 07:18:06 gswkaiser Exp $

Copyright (c) 2005 Brian Burton - brian@dynamoeffects.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/

if (NOT_IS_ADMIN_FUNCTION)
{
	// include the mailer-class
	require_once(DIR_WS_CLASSES . 'class.phpmailer.php');
	// include all for the mails
	require_once(DIR_FS_INC.'olc_php_mail.inc.php');
}
define('MODULE_PAYMENT_PAYPAL','MODULE_PAYMENT_PAYPAL_');

//If the user installed the included pear modules, make sure it's in the include path
if (trim(MODULE_PAYMENT_PAYPAL_DP_PEAR_PATH) != EMPTY_STRING) {
	if (is_dir(MODULE_PAYMENT_PAYPAL_DP_PEAR_PATH)) {
		$inc = ini_get('include_path');
		$inc_exp = explode(PATH_SEPARATOR, $inc);
		if(!in_array(MODULE_PAYMENT_PAYPAL_DP_PEAR_PATH, $inc_exp)) {
			ini_set('include_path', $inc.PATH_SEPARATOR.MODULE_PAYMENT_PAYPAL_DP_PEAR_PATH);
		}
	}
}

if (!is_object($messageStack))
{
	// initialize the message stack for output messages
	require_once(DIR_WS_CLASSES . 'message_stack.php');
	$messageStack = new messageStack;
}
global $messageStack;

class paypal_wpp
{
	var $error_dump,$in_function,$first_contact,$yes,$no;
	var $code, $title, $description, $enabled;
	var $ec_checkout_text='ec_checkout';
	var $paypal_ec_text='paypal_ec_';

	function paypal_wpp()
	{
		if (SESSION_LANGUAGE=='german')
		{
			$this->error_dump='PayPal Fehler Dump';
			$this->in_function='In Funktion: #\n\n';
			$this->first_contact="Hat der erste Kontakt-Versuch einen Fehler ergeben? ";
			$this->yes="Ja";$this->no="Nein";
		}
		else
		{
			$this->error_dump='PayPal Error Dump';
			$this->in_function='In Function: #\n\n';
			$this->first_contact="Did first contact attempt return error? ";
			$this->yes="Yes";$this->no="No";
		}

		global $order;
		$this->code = 'paypal_wpp';
		$this->codeTitle = 'PayPal Website Payments Pro';
		$this->codeVersion = '0.7';
		//STORE_OWNER_EMAIL_ADDRESS
		$this->enableDebugging = ((MODULE_PAYMENT_PAYPAL_DP_DEBUGGING == TRUE_STRING_S) ? true : false);
		$this->title = MODULE_PAYMENT_PAYPAL_DP_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_PAYPAL_DP_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_PAYPAL_DP_SORT_ORDER;
		$this->enabled = ((strtolower(MODULE_PAYMENT_PAYPAL_DP_STATUS) == TRUE_STRING_S) ? true : false);
		if (MODULE_PAYMENT_PAYPAL_DP_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_PAYPAL_DP_ORDER_STATUS_ID;
		}
		if (is_object($order)) $this->update_status();
	}

	function update_status()
	{
		global $order;
		if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_PAYPAL_DP_ZONE > 0) ) {
			$check_flag = false;
			$check_query = olc_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES .
			" where geo_zone_id = '".MODULE_PAYMENT_PAYPAL_DP_ZONE."' and zone_country_id = '" .
			$order->billing['country']['id']."' order by zone_id");
			while ($check = olc_db_fetch_array($check_query))
			{
				$zone_id=$check['zone_id'];
				if ($zone_id < 1)
				{
					$check_flag = true;
					break;
				} elseif ($zone_id == $order->billing['zone_id']) {
					$check_flag = true;
					break;
				}
			}
			if ($check_flag == false) {
				$this->enabled = false;
			}
		}
	}

	function javascript_validation()
	{
		global $paypal_ec_token, $paypal_ec_payer_id, $paypal_ec_payer_info;
		if ($this->is_paypal_process())
		{
			return false;
		} else {
			$js =
			'  if (payment_value == "'.$this->code.'") {'.NEW_LINE .
			'    var cc_firstname = document.checkout_payment.paypalwpp_cc_firstname.value;'.NEW_LINE .
			'    var cc_lastname = document.checkout_payment.paypalwpp_cc_lastname.value;'.NEW_LINE .
			'    var cc_number = document.checkout_payment.paypalwpp_cc_number.value;'.NEW_LINE .
			'    var cc_checkcode = document.checkout_payment.paypalwpp_cc_number.value;'.NEW_LINE .
			'    if(cc_firstname==""||cc_lastname==""||eval(cc_firstname.length)+eval(cc_lastname.length)<'.
			CC_OWNER_MIN_LENGTH.') {'.NEW_LINE .
			'      error_message = error_message + "'.MODULE_PAYMENT_PAYPAL_DP_TEXT_JS_CC_OWNER.'";'.NEW_LINE .
			'      error = 1;'.NEW_LINE .
			'    }'.NEW_LINE .
			'    if (cc_number == "" || cc_number.length < '.CC_NUMBER_MIN_LENGTH.') {'.NEW_LINE .
			'      error_message = error_message + "'.MODULE_PAYMENT_PAYPAL_DP_TEXT_JS_CC_NUMBER.'";'.NEW_LINE .
			'      error = 1;'.NEW_LINE .
			'    }'.NEW_LINE .
			'  }'.NEW_LINE;
			return $js;
		}
	}

	function selection()
	{
		if (USE_PAYPAL_WPP)
		{
			global $order;

			$expires_month=array();
			for ($i=1; $i < 13; $i++)
			{
				$expires_month[] = array('id' => sprintf('%02d', $i), 'text' => strftime('%B',mktime(0,0,0,$i,1,2000)));
			}
			$expires_year=array();
			$today = getdate();
			$year=$today['year'];
			for ($i=$today['year']; $i < $year+10; $i++)
			{
				$expires_year[] = array(
				'id' => strftime('%y',mktime(0,0,0,1,1,$i)),
				'text' => strftime('%Y',mktime(0,0,0,1,1,$i)));
			}
			require_once(DIR_FS_INC.'olc_draw_pull_down_menu.inc.php');
			require_once(DIR_FS_INC.'olc_draw_input_field.inc.php');
			$date_expires=mktime(0,0,0,date('m')+1,date('d'),date('Y'));
			$month=date('m',$date_expires);
			$year=date('Y',$date_expires);

			$paypal_image_dir=PAYPAL_IPN_DIR.'images/';
			$img_visa = olc_image($paypal_image_dir.'visa.gif',' Visa ',EMPTY_STRING,EMPTY_STRING,'align="absmiddle"');
			$img_mc = olc_image($paypal_image_dir.'mastercard.gif',' MasterCard ',
				EMPTY_STRING,EMPTY_STRING,'align="absmiddle"');
			/*
			$img_discover = olc_image($paypal_image_dir.'discover.gif',' Discover ',
			EMPTY_STRING,EMPTY_STRING,'align="absmiddle"');

			$img_amex = olc_image($paypal_image_dir.'amex.gif',' American Express ',
			EMPTY_STRING,EMPTY_STRING,'align="absmiddle"');
			*/
			$paypal_cc_txt = sprintf(MODULE_PAYMENT_PAYPAL_DP_CC_TEXT,
			$img_visa,$img_mc,$img_paypal,$img_amex,$img_discover);

			$selection = array(
			'id' => $this->code,
			'module' => MODULE_PAYMENT_PAYPAL_DP_TEXT_TITLE.$paypal_cc_txt,
			'fields' => array(
			array('title' => MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_FIRSTNAME,
			'field' => olc_draw_input_field('paypalwpp_cc_firstname', $order->billing['firstname'])),
			array('title' => MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_LASTNAME,
			'field' => olc_draw_input_field('paypalwpp_cc_lastname', $order->billing['lastname'])),
			array('title' => MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_TYPE,
			'field' => olc_draw_pull_down_menu('paypalwpp_cc_type',
			array(
			array('id' => 'Visa', 'text' => 'Visa'),
			array('id' => 'MasterCard', 'text' => 'MasterCard'))
			)),
			array('title' => MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_NUMBER,
			'field' => olc_draw_input_field('paypalwpp_cc_number', EMPTY_STRING)),
			array('title' => MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_EXPIRES,
			'field' => olc_draw_pull_down_menu('paypalwpp_cc_expires_month',$expires_month,$month).HTML_NBSP .
			olc_draw_pull_down_menu('paypalwpp_cc_expires_year',$expires_year,$year)),
			array('title' => MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_CHECKNUMBER,
			'field' => olc_draw_input_field('paypalwpp_cc_checkcode', EMPTY_STRING, 'size="4" maxlength="4"') .
			HTML_NBSP.'<small>'.MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION.'</small>')));
			/*
			if (MODULE_PAYMENT_PAYPAL_DP_BUTTON_PAYMENT_PAGE == 'Yes')
			{
				if (isset($_SESSION[$his->ec_checkout_text]))
				{
					unset($_SESSION[$his->ec_checkout_text]);
				}
				else
				{
					$selection['fields'][] = array(
					'title' => HTML_BR.HTML_BR.HTML_B_START.MODULE_PAYMENT_PAYPAL_DP_TEXT_EC_HEADER.HTML_B_END,
					'field' => HTML_BR.HTML_BR.'
				<table border="0" cellspacing="3" cellpadding="3">
					<tr>
						<td valign="top">
							<a href="'.olc_href_link(FILENAME_EC_PROCESS,
							'title="'.MODULE_PAYMENT_PAYPAL_DP_TEXT_BUTTON_TEXT.'"', SSL).'">
								<img src="'.MODULE_PAYMENT_PAYPAL_EC_BUTTON_URL.'" border=0>
							</a>
						</td>
						<td valign="top" class="main">
						'.TEXT_PAYPALWPP_EC_BUTTON_DESCRIPTION_TEXT.'
						</td>
					</tr>
				</table>
');
				}
			}
			*/
		}
		return $selection;
	}
	//This is the credit card check done between checkout_payment.php and checkout_confirmation.php (called from checkout_confirmation.php)

	function pre_confirmation_check() {
		global $_POST, $paypal_ec_token, $paypal_ec_payer_id, $paypal_ec_payer_info;
		//If this is an EC checkout, do nuttin'
		if ($this->is_paypal_process())
		{
			return false;
		} else {
			include(DIR_WS_CLASSES.'cc_validation.php');
			$cc_validation = new cc_validation();
			$result = $cc_validation->validate($_POST['paypalwpp_cc_number'],
			$_POST['paypalwpp_cc_expires_month'], $_POST['paypalwpp_cc_expires_year']);
			$error = EMPTY_STRING;
			switch ($result) {
				case -1:
					$error = sprintf(TEXT_CCVAL_ERROR_UNKNOWN_CARD, substr($cc_validation->cc_number, 0, 4));
					break;
				case -2:
				case -3:
				case -4:
					$error = TEXT_CCVAL_ERROR_INVALID_DATE;
					break;
				case false:
					$error = TEXT_CCVAL_ERROR_INVALID_NUMBER;
					break;
			}
			$_POST['paypalwpp_cc_checkcode'] = preg_replace('/[^0-9]/i', EMPTY_STRING,
			$_POST['paypalwpp_cc_checkcode']);
			if ( ($result == false) || ($result < 1) ) {
				$this->away_with_you(MODULE_PAYMENT_PAYPAL_DP_TEXT_CARD_ERROR.'<br/><br/>'.$error, false,
				FILENAME_CHECKOUT_PAYMENT);
			}
			$this->cc_card_type = $cc_validation->cc_type;
			$this->cc_card_number = $cc_validation->cc_number;
			$this->cc_expiry_month = $cc_validation->cc_expiry_month;
			$this->cc_expiry_year = $cc_validation->cc_expiry_year;
			$this->cc_checkcode = $_POST['paypalwpp_cc_checkcode'];
		}
	}

	function confirmation() {
		global $_POST, $paypal_ec_token, $paypal_ec_payer_id, $paypal_ec_payer_info;
		if ($this->is_paypal_process())
		{
			$confirmation = array('title' => MODULE_PAYMENT_PAYPAL_EC_TEXT_TITLE, 'fields' => array());
		} else {
			$confirmation = array(
			'title' => MODULE_PAYMENT_PAYPAL_DP_TEXT_TITLE,
			'fields' => array(
			array('title' => MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_FIRSTNAME,
			'field' => $_POST['paypalwpp_cc_firstname']),
			array('title' => MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_LASTNAME,
			'field' => $_POST['paypalwpp_cc_lastname']),
			array('title' => MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_TYPE,
			'field' => $_POST['paypalwpp_cc_type']),
			array('title' => MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_NUMBER,
			'field' => substr($_POST['paypalwpp_cc_number'], 0, 4) .
			str_repeat('X', (strlen($_POST['paypalwpp_cc_number']) - 8)) .
			substr($_POST['paypalwpp_cc_number'], -4)),
			array('title' => MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_EXPIRES,
			'field' => strftime('%B, %Y', mktime(0,0,0,$_POST['paypalwpp_cc_expires_month'], 1, '20' .
			$_POST['paypalwpp_cc_expires_year'])))));
			if (olc_not_null($_POST['paypalwpp_cc_checkcode'])) {
				$confirmation['fields'][] = array('title' => MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_CHECKNUMBER,
				'field' => $_POST['paypalwpp_cc_checkcode']);
			}
		}
		return $confirmation;
	}
	//Be gone which yo stank self

	function away_with_you($error_msg = EMPTY_STRING, $kill_sess_vars = false, $goto_page = EMPTY_STRING) {
		global $customer_first_name, $customer_id, $navigation, $paypal_ec_token, $paypal_ec_payer_id,
		$paypal_ec_payer_info, $paypal_error, $paypal_ec_temp,$messageStack;
		if ($kill_sess_vars)
		{
			if ($paypal_ec_temp)
			{
				$this->ec_delete_user($customer_id);
			}
			//Unregister the paypal session variables making the user start over
			unset($_SESSION[$this->paypal_ec_text.'temp']);
			unset($_SESSION[$this->paypal_ec_text.'token']);
			unset($_SESSION[$this->paypal_ec_text.'payer_id']);
			unset($_SESSION[$this->paypal_ec_text.'payer_info']);
		}
		if ($_SESSION['customer_first_name'] && $_SESSION['customer_id'])
		{
			if ($goto_page == FILENAME_CHECKOUT_PAYMENT || MODULE_PAYMENT_PAYPAL_DP_DISPLAY_PAYMENT_PAGE == 'Yes')
			{
				$redirect_path = FILENAME_CHECKOUT_PAYMENT;
			}
			else
			{
				$redirect_path = FILENAME_CHECKOUT_SHIPPING;
			}
		}
		else
		{
			$navigation->set_snapshot(FILENAME_CHECKOUT_SHIPPING);
			$redirect_path = FILENAME_LOGIN;
		}
		$paypal_error_text='paypal_error';
		if ($error_msg)
		{
			$paypal_error = $error_msg;
			if (!$_SESSION[$paypal_error_text]) $_SESSION[$paypal_error_text];
			if (is_object($messageStack)) $messageStack->add('paypal_wpp', $error_msg,'error',false);
		}
		else
		{
			unset($_SESSION[$paypal_error_text]);
		}
		//settype(&$this, 'null');
		olc_redirect(olc_href_link($redirect_path, EMPTY_STRING, SSL, true, false));
	}

	function return_transaction_errors($errors)
	{
		//Paypal will sometimes send back more than one error message, so we must loop through them if necessary
		$error_return = EMPTY_STRING;
		$iErr = 1;
		if (is_array($errors)) {
			foreach ($errors as $err) {
				if ($error_return) $error_return .= '<br/><br/>';
				if (sizeof($errors) > 1) {
					$error_return .= 'Fehler #'.$iErr.': ';
				}
				$error_return .= $err->ShortMessage.LPAREN.$err->ErrorCode.')<br/>'.$err->LongMessage;
				$iErr++;
			}
		} else {
			$error_return = $errors->ShortMessage.LPAREN.$errors->ErrorCode.')<br/>'.$errors->LongMessage;
		}
		return $error_return;
	}

	function process_button()
	{
		global $_POST, $order, $currencies, $currency, $paypal_ec_token, $paypal_ec_payer_id,
		$paypal_ec_payer_info;
		if ($this->is_paypal_process())
		{
			return EMPTY_STRING;
		}
		else
		{
			require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
			$wpp_currency = $this->get_currency();
			$process_button_string =
			olc_draw_hidden_field('wpp_cc_type', $_POST['paypalwpp_cc_type']) .
			olc_draw_hidden_field('wpp_cc_expdate_month', $_POST['paypalwpp_cc_expires_month']) .
			olc_draw_hidden_field('wpp_cc_expdate_year', $_POST['paypalwpp_cc_expires_year']) .
			olc_draw_hidden_field('wpp_cc_number', $_POST['paypalwpp_cc_number']) .
			olc_draw_hidden_field('wpp_cc_checkcode', $_POST['paypalwpp_cc_checkcode']) .
			olc_draw_hidden_field('wpp_payer_firstname', $_POST['paypalwpp_cc_firstname']) .
			olc_draw_hidden_field('wpp_payer_lastname', $_POST['paypalwpp_cc_lastname']) .
			olc_draw_hidden_field('wpp_redirect_url', olc_href_link(FILENAME_CHECKOUT_PROCESS, EMPTY_STRING,
			SSL, true));
			return $process_button_string;
		}
	}
	//Initialize the connection with PayPal

	function paypal_init()
	{
		global $customer_id, $customer_first_name;
		$paypal_sdk_dir='Services/PayPal';
		require_once ($paypal_sdk_dir.PHP);
		$paypal_sdk_dir.='/Profile/';
		require_once ($paypal_sdk_dir.'Handler/Array.php');
		require_once ($paypal_sdk_dir.'API.php');
		$handler =& ProfileHandler_Array::getInstance(array(
		'username' => MODULE_PAYMENT_PAYPAL_DP_API_USERNAME,
		'certificateFile' => MODULE_PAYMENT_PAYPAL_DP_CERT_PATH,
		//This needs to be an absolute path i.e. /home/user/cert.txt
		'subject' => EMPTY_STRING,
		'environment' => MODULE_PAYMENT_PAYPAL_DP_SERVER));
		$profile = APIProfile::getInstance(MODULE_PAYMENT_PAYPAL_DP_API_USERNAME, $handler);
		$profile->setAPIPassword(MODULE_PAYMENT_PAYPAL_DP_API_PASSWORD);
		$caller =& Services_PayPal::getCallerServices($profile); //Create a caller object.  Ring ring, who's there?
		if(!Services_PayPal::isError($caller))
		{
			if (trim(MODULE_PAYMENT_PAYPAL_DP_PROXY) != EMPTY_STRING)
			{
				$caller->setOpt('curl', CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
				$caller->setOpt('curl', CURLOPT_PROXY, MODULE_PAYMENT_PAYPAL_DP_PROXY);
			}
			$caller->setOpt('curl', CURLOPT_SSL_VERIFYPEER, 0);
			$caller->setOpt('curl', CURLOPT_TIMEOUT, 180);
			$caller->setOpt('curl', CURLOPT_SSL_VERIFYHOST, 0);
		}
		if(Services_PayPal::isError($caller))
		{
			if ($this->enableDebugging)
			{
				/*
				olc_php_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $this->error_dump,
				"In Funktion: paypal_init()\n\n".var_dump($caller), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
				*/
				olc_php_mail(
				STORE_OWNER_EMAIL_ADDRESS,
				STORE_OWNER,
				STORE_OWNER_EMAIL_ADDRESS ,
				STORE_NAME,
				EMPTY_STRING,
				STORE_OWNER_EMAIL_ADDRESS,
				STORE_OWNER,
				EMPTY_STRING,
				EMPTY_STRING,
				$this->error_dump,
				EMPTY_STRING ,
				str_replace(HASH,'paypal_init',$this->in_function).$this->prepare_var_dump($caller),
				EMAIL_TYPE_TEXT);
			}
			$error=$this->prepare_error(MODULE_PAYMENT_PAYPAL_DP_TEXT_GEN_ERROR,$caller);
			$this->away_with_you($error, true);
		} else {
			return $caller;
		}
	}
	//This function sends the user to PayPal's site

	function ec_step1() {
		global $order, $customer_first_name, $customer_id, $languages_id;
		require(DIR_WS_CLASSES.'order.php');
		$order = new order;
		$lang_code=$_SESSION['language_code'];
		switch ($lang_code)
		{
			case 'ja':
				$lang_code = 'JP';
				break;
			default:
				$lang_code = strtoupper($lang_code);
		}
		$_SESSION[$his->ec_checkout_text]=true;
		$caller = $this->paypal_init();
		$ot =& Services_PayPal::getType('BasicAmountType');
		$ot->setval(number_format($order->info['total'], 2));
		/*
		W. Kaiser - We keep the currency in Session!!
		//As PayPal only accepts USD at this time, this conditional is useless, but written for when they start accepting other forms of currency
		switch (MODULE_PAYMENT_PAYPAL_DP_CURRENCY) {
		default:
		$currency_id = 'USD';
		break;
		}
		*/
		$currency_id = SESSION_CURRENCY;
		$ot->setattr('currencyID', $currency_id);
		$ecdt =& Services_PayPal::getType('SetExpressCheckoutRequestDetailsType');
		$ecdt->setOrderTotal($ot);
		$ecdt->setReturnURL(olc_href_link(FILENAME_EC_PROCESS, EMPTY_STRING, SSL));
		if (trim(MODULE_PAYMENT_PAYPAL_EC_PAGE_STYLE) != EMPTY_STRING) {
			$ecdt->setPageStyle(MODULE_PAYMENT_PAYPAL_EC_PAGE_STYLE);
		}
		if ($_SESSION['customer_first_name'] && $_SESSION['customer_id']) {
			$redirect_path = FILENAME_CHECKOUT_SHIPPING;
			$redirect_attr = 'ec_cancel=1';
		} else {
			$redirect_path = FILENAME_LOGIN;
			$redirect_attr = 'ec_cancel=1';
		}
		$ecdt->setCancelURL(olc_href_link($redirect_path, $redirect_attr, SSL));
		if(MODULE_PAYMENT_PAYPAL_DP_CONFIRMED == 'Yes') {
			$ecdt->setReqConfirmShipping(1);
		}
		$ecdt->setLocaleCode($lang_code);
		//If AddressOverride is set to 'Yes' and the customer is logged in, set the addressoverride variable
		if (MODULE_PAYMENT_PAYPAL_EC_ADDRESS_OVERRIDE == 'Yes' &&
		$_SESSION['customer_first_name'] && $_SESSION['customer_id']) {
			$ecdt->setAddressOverride('1');
		}
		$ec =& Services_PayPal::getType('SetExpressCheckoutRequestType');
		$ec->setSetExpressCheckoutRequestDetails($ecdt);
		$response = $caller->SetExpressCheckout($ec);
		if(Services_PayPal::isError($response) ||
		($response->Ack != 'Success' && $response->Ack != 'SuccessWithWarning')) {
			if ($this->enableDebugging) {
				/*
				olc_php_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $this->error_dump,
				"In Funktion: ec_step1()\n\n".var_dump($response), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
				*/
				olc_php_mail(
				STORE_OWNER_EMAIL_ADDRESS,
				STORE_OWNER,
				STORE_OWNER_EMAIL_ADDRESS ,
				STORE_NAME,
				EMPTY_STRING,
				STORE_OWNER_EMAIL_ADDRESS,
				STORE_OWNER,
				EMPTY_STRING,
				EMPTY_STRING,
				$this->error_dump,
				EMPTY_STRING ,
				str_replace(HASH,'ec_step1',$this->in_function).$this->prepare_var_dump($response),
				EMAIL_TYPE_TEXT);
			}
			$error=$this->prepare_error(MODULE_PAYMENT_PAYPAL_DP_TEXT_GEN_ERROR,$response);
			$this->away_with_you($error, true);
		} else {
			$paypal_ec_token = $response->getToken();
			$_SESSION[$this->paypal_ec_text.'token']=$paypal_ec_token;
			if(MODULE_PAYMENT_PAYPAL_DP_SERVER == 'live')
			{
				$sandbox=EMPTY_STRING;
			} else {
				$sandbox='sandbox'.DOT;
			}
			$paypal_url = 'https://www.'.$sandbox.'paypal.com/cgi-bin/webscr';
			olc_redirect($paypal_url."?cmd=_express-checkout&token=".$paypal_ec_token);
		}
	}

	function ec_step2() {
		global $paypal_ec_token, $customer_id, $customer_first_name, $language;
		global $customer_default_address_id, $sendto;
		//Visitor just came back from PayPal and so we collect all the info returned, create an account if necessary,
		//then log them in, and then send them to checkout_shipping.php.  What a long, strange trip it's been.
		$_SESSION[$his->ec_checkout_text]=true;
		if ($paypal_ec_token == EMPTY_STRING)
		{
			if (isset($_GET['token'])) {
				$paypal_ec_token = $_GET['token'];
			} else {
				$this->away_with_you(MODULE_PAYMENT_PAYPAL_DP_INVALID_RESPONSE, true);
			}
		}
		//Make sure the token is in the correct format
		if (!ereg("([C-E]{2})-([A-Z0-9]{17})", $paypal_ec_token)){
			$this->away_with_you(MODULE_PAYMENT_PAYPAL_DP_INVALID_RESPONSE, true);
		}
		$caller = $this->paypal_init();
		$ecdt =& Services_PayPal::getType('GetExpressCheckoutDetailsRequestType');
		$ecdt->setToken($paypal_ec_token);
		$response = $caller->GetExpressCheckoutDetails($ecdt);
		$response_ack=$response->Ack ;
		if(strlen(Services_PayPal::isError($response)) > 0  ||
		($response_ack != 'Success' && $response_ack != 'SuccessWithWarning'))
		{
			if ($this->enableDebugging)
			{
				/*
				olc_php_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $this->error_dump,
				"In Funktion: ec_step2()\n\n".var_dump($response), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
				*/
				olc_php_mail(
				STORE_OWNER_EMAIL_ADDRESS,
				STORE_OWNER,
				STORE_OWNER_EMAIL_ADDRESS ,
				STORE_NAME,
				EMPTY_STRING,
				STORE_OWNER_EMAIL_ADDRESS,
				STORE_OWNER,
				EMPTY_STRING,
				EMPTY_STRING,
				$this->error_dump,
				EMPTY_STRING ,
				str_replace(HASH,'ec_step2',$this->in_function).$this->prepare_var_dump($response),
				EMAIL_TYPE_TEXT);
			}
			$error=$this->prepare_error(MODULE_PAYMENT_PAYPAL_DP_GEN_ERROR,$response);
			$this->away_with_you($error, true);
		} else {
			//This is an array of all the info sent back by PayPal
			$details = $response->getGetExpressCheckoutDetailsResponseDetails();
			$payer_info = $details->getPayerInfo();
			if(MODULE_PAYMENT_PAYPAL_DP_REQ_VERIFIED == 'Yes' && strtolower($payer_info->PayerStatus) != 'verified') {
				$this->away_with_you(MODULE_PAYMENT_PAYPAL_DP_TEXT_UNVERIFIED, true);
			}
			$paypal_ec_payer_id = $payer_info->getPayerID();
			$_SESSION[$this->paypal_ec_text.'payer_id'];
			$_SESSION[$this->paypal_ec_text.'payer_id'] = $paypal_ec_payer_id;
			$fullname = $payer_info->getPayerName();
			$address_info = $payer_info->getAddress();
			//Hoag: Begin telephone fix (1 of 3)
			$phone = $details->getContactPhone();
			//Hoag: End telephone fix (1 of 3)
			//I didn't include the international variables since PayPal only supports USD at this time
			$paypal_ec_payer_info = array(
			'payer_id' => $payer_info->PayerID,
			'payer_email' => $payer_info->Payer,
			'payer_firstname' => $fullname->FirstName,
			'payer_lastname' => $fullname->LastName,
			'payer_business' => $payer_info->PayerBusiness,
			'payer_status' => $payer_info->PayerStatus,
			'ship_owner' => $address_info->AddressOwner,
			'ship_name' => $address_info->Name,
			'ship_street_1' => $address_info->Street1,
			'ship_street_2' => $address_info-> Street2,
			'ship_city' => $address_info->CityName,
			'ship_state' => $address_info->StateOrProvince,
			'ship_postal_code' => $address_info->PostalCode,
			'ship_country' => $address_info->Country,
			'ship_country_name' => $address_info->CountryName,
			'ship_phone' => $address_info->Phone,
			//Hoag: Begin telephone fix (2 of 3)
			'ship_phone' => $phone,
			//Hoag: End telephone fix (2 of 3)
			'ship_address_status' => $address_info->AddressStatus);
			//$_SESSION[$this->paypal_ec_text.'payer_info'] = $paypal_ec_payer_info;
			$_SESSION[$this->paypal_ec_text.'payer_info'];
			//Get the customer's country id.
			$country_query = olc_db_query("SELECT countries_id, address_format_id FROM ".TABLE_COUNTRIES.
			" WHERE countries_name = '".$paypal_ec_payer_info['ship_country_name']."' LIMIT 1");
			if (olc_db_num_rows($country_query) > 0) {
				$country = olc_db_fetch_array($country_query);
				$country_id = $country['countries_id'];
				$address_format_id = $country['address_format_id'];
			} else {
				$country_id = EMPTY_STRING;
				$address_format_id = '2'; //2 is the American format
			}
			$states_query = olc_db_query("SELECT zone_id FROM ".TABLE_ZONES.
			" WHERE zone_code = '".$paypal_ec_payer_info['ship_state'].
			"' AND zone_country_id = '".$country_id."' LIMIT 1");
			if (olc_db_num_rows($states_query) > 0) {
				$states = olc_db_fetch_array($states_query);
				$state_id = $states['zone_id'];
			} else {
				$state_id = EMPTY_STRING;
			}
			$order->customer['name'] = trim($paypal_ec_payer_info['payer_firstname'].BLANK .
			$paypal_ec_payer_info['payer_lastname']);
			$order->customer['company'] = $paypal_ec_payer_info['payer_business'];
			$order->customer['street_address'] = $paypal_ec_payer_info['ship_street_1'];
			$order->customer['suburb'] = $paypal_ec_payer_info['ship_street_2'];
			$order->customer['city'] = $paypal_ec_payer_info['ship_city'];
			$order->customer['postcode'] = $paypal_ec_payer_info['ship_postal_code'];
			$order->customer['state'] = $paypal_ec_payer_info['ship_state'];
			$order->customer['country'] = $paypal_ec_payer_info['ship_country_name'];
			$order->customer['format_id'] = $address_format_id;
			$order->customer['email_address'] = $paypal_ec_payer_info['payer_email'];
			//Hoag: Begin telephone fix (3 of 3)
			$order->customer['telephone'] = $paypal_ec_payer_info['ship_phone'];
			//Hoag: End telephone fix (3 of 3)
			//For some reason, $order->billing gets erased between here and checkout_confirmation.php
			$order->billing['name'] = trim($paypal_ec_payer_info['payer_firstname'].BLANK .
			$paypal_ec_payer_info['payer_lastname']);
			$order->billing['company'] = $paypal_ec_payer_info['payer_business'];
			$order->billing['street_address'] = $paypal_ec_payer_info['ship_street_1'];
			$order->billing['suburb'] = $paypal_ec_payer_info['ship_street_2'];
			$order->billing['city'] = $paypal_ec_payer_info['ship_city'];
			$order->billing['postcode'] = $paypal_ec_payer_info['ship_postal_code'];
			$order->billing['state'] = $paypal_ec_payer_info['ship_state'];
			$order->billing['country'] = $paypal_ec_payer_info['ship_country_name'];
			$order->billing['format_id'] = $address_format_id;
			/*Disabled for now
			//If they selected an address on PayPal's site with a different zipcode than was previously selected
			//send them back to the shipping page
			if ($order->delivery['postcode'] == $paypal_ec_payer_info['ship_postal_code']) {
			$goto_shipping = false;
			} else {
			$goto_shipping = true;
			}
			*/
			$order->delivery['name'] = trim($paypal_ec_payer_info['payer_firstname'].BLANK .
			$paypal_ec_payer_info['payer_lastname']);
			$order->delivery['company'] = $paypal_ec_payer_info['payer_business'];
			$order->delivery['street_address'] = $paypal_ec_payer_info['ship_street_1'];
			$order->delivery['suburb'] = $paypal_ec_payer_info['ship_street_2'];
			$order->delivery['city'] = $paypal_ec_payer_info['ship_city'];
			$order->delivery['postcode'] = $paypal_ec_payer_info['ship_postal_code'];
			$order->delivery['state'] = $paypal_ec_payer_info['ship_state'];
			$order->delivery['country'] = $paypal_ec_payer_info['ship_country_name'];
			$order->delivery['format_id'] = $address_format_id;
			if (!$_SESSION[$this->paypal_ec_text.'temp']) $_SESSION[$this->paypal_ec_text.'temp'];
			if ($_SESSION['customer_first_name'] && $_SESSION['customer_id']) {
				//They're logged in, so forward them straight to checkout_shipping.php
				$order->customer['id'] = $customer_id;
				if (!$_SESSION['sendto'])  $_SESSION['sendto'] = $customer_default_address_id;
				$_SESSION[$this->paypal_ec_text.'temp'] = false;
				$this->away_with_you();
				/*disabled for now
				//0.6.2b modification.  If they already have a shipping amount calculated for this zip code, send them on instead of backwards
				if ($goto_shipping) {
				$this->away_with_you();
				} else {
				$this->away_with_you(EMPTY_STRING, false, FILENAME_CHECKOUT_CONFIRMATION);
				}
				*/
			} else {
				//They're not logged in.  Create an account if necessary, and then log them in.
				//First, see if they're an existing customer
				//If Paypal didn't send an email address, something went wrong
				if (trim($paypal_ec_payer_info['payer_email']) == EMPTY_STRING)
				$this->away_with_you(MODULE_PAYMENT_PAYPAL_DP_INVALID_RESPONSE, true);
				$check_customer_query = olc_db_query("select customers_id, customers_firstname, customers_lastname,
				customers_paypal_payerid, customers_paypal_ec from ".TABLE_CUSTOMERS .
				" where customers_email_address = '".olc_db_input($paypal_ec_payer_info['payer_email']).APOS);
				$check_customer = olc_db_fetch_array($check_customer_query);
				if (olc_db_num_rows($check_customer_query) > 0) {
					$check_customer = olc_db_fetch_array($check_customer_query);
					$acct_exists = true;
					if ($check_customer['customers_paypal_ec'] == '1') {
						//Delete the existing temporary account
						$this->ec_delete_user($check_customer['customers_id']);
						$acct_exists = false;
					}
				}

				//Create an account
				if (!$acct_exists) {
					//Generate a random 8-char password
					$salt = "46z3haZzegmn676PA3rUw2vrkhcLEn2p1c6gf7vp2ny4u3qqfqBh5j6kDhuLmyv9xf";
					srand((double)microtime()*1000000);
					$password = EMPTY_STRING;
					for ($x = 0; $x < 7; $x++) {
						$num = rand() % 33;
						$tmp = substr($salt, $num, 1);
						$password = $password.$tmp;
					}
					$sql_data_array = array('customers_firstname' => $paypal_ec_payer_info['payer_firstname'],
					'customers_lastname' => $paypal_ec_payer_info['payer_lastname'],
					'customers_email_address' => $paypal_ec_payer_info['payer_email'],
					'customers_telephone' => $paypal_ec_payer_info['ship_phone'],
					'customers_fax' => EMPTY_STRING,
					'customers_newsletter' => '0',
					'customers_password' => olc_encrypt_password($password),
					'customers_paypal_payerid' => $paypal_ec_payer_id);
					olc_db_perform(TABLE_CUSTOMERS, $sql_data_array);
					$customer_id = olc_db_insert_id();
					$sql_data_array = array('customers_id' => $customer_id,
					'entry_firstname' => $paypal_ec_payer_info['payer_firstname'],
					'entry_lastname' => $paypal_ec_payer_info['payer_lastname'],
					'entry_street_address' => $paypal_ec_payer_info['ship_street_1'],
					'entry_suburb' => $paypal_ec_payer_info['ship_street_2'],
					'entry_city' => $paypal_ec_payer_info['ship_city'],
					'entry_zone_id' => $state_id,
					'entry_postcode' => $paypal_ec_payer_info['ship_postal_code'],
					'entry_country_id' => $country_id);
					olc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
					$address_id = olc_db_insert_id();
					olc_db_query(SQL_UPDATE.TABLE_CUSTOMERS." set customers_default_address_id = '".(int)$address_id.
					"' where customers_id = '".(int)$customer_id.APOS);
					olc_db_query(INSERT_INTO.TABLE_CUSTOMERS_INFO.
					" (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('".
					(int)$customer_id."', '0', now())");
					if (MODULE_PAYMENT_PAYPAL_DP_NEW_ACCT_NOTIFY == 'Yes')
					{
						require(DIR_WS_LANGUAGES.SESSION_LANGUAGE.SLASH.FILENAME_CREATE_ACCOUNT);
						$email_text = sprintf(EMAIL_GREET_NONE, $paypal_ec_payer_info['payer_firstname']).EMAIL_WELCOME .
						EMAIL_TEXT;
						$email_text .= EMAIL_EC_ACCOUNT_INFORMATION."Username: ".$paypal_ec_payer_info['payer_email'] .
						"\nPassword: ".$password."\n\n";
						$email_text .= EMAIL_CONTACT;
						/*

						olc_php_mail($paypal_ec_payer_info['payer_firstname']." " .
						$paypal_ec_payer_info['payer_lastname'],
						$paypal_ec_payer_info['payer_email'], EMAIL_SUBJECT, $email_text, STORE_OWNER,
						STORE_OWNER_EMAIL_ADDRESS);
						*/
						olc_php_mail(
						STORE_OWNER_EMAIL_ADDRESS,
						STORE_OWNER,
						$paypal_ec_payer_info['payer_email'],
						trim($paypal_ec_payer_info['payer_firstname']. BLANK .
						$paypal_ec_payer_info['payer_lastname']),
						EMPTY_STRING,
						STORE_OWNER_EMAIL_ADDRESS,
						STORE_OWNER,
						EMPTY_STRING,
						EMPTY_STRING,
						EMAIL_SUBJECT,
						EMPTY_STRING ,
						$email_text,
						EMAIL_TYPE_TEXT);
						$_SESSION[$this->paypal_ec_text.'temp'] = false;
					} else {
						//Make it a temporary account that'll be deleted once they've checked out
						olc_db_query(SQL_UPDATE.TABLE_CUSTOMERS .
						" SET customers_paypal_ec = '1' WHERE customers_id = '".(int)$customer_id.APOS);
						$_SESSION[$this->paypal_ec_text.'temp'] = true;
					}
				} else {
					$_SESSION[$this->paypal_ec_text.'temp'] = false;
				}
				$sendto = $address_id;
				if (!$_SESSION['sendto']) $_SESSION['sendto'];
				$this->user_login($_SESSION[$this->paypal_ec_text.'payer_info']['payer_email']);
			}
		}
	}

	function user_login($email_address) {
		global $order, $customer_id, $customer_default_address_id, $customer_first_name,
		$customer_country_id, $customer_zone_id;
		/*
		This allows the user to login with only a valid email (the email address sent back by PayPal)
		Their PayPal payerID is stored in the database, but I still don't know if that number changes.
		If it doesn't, it could be used to
		help identify an existing customer who hasn't logged in.  Until I know for sure, the email address is enough
		*/
		global $session_started, $language, $cart;
		if ($session_started == false) {
			olc_redirect(olc_href_link(FILENAME_COOKIE_USAGE));
		}
		require(DIR_WS_LANGUAGES.SESSION_LANGUAGE.SLASH.FILENAME_LOGIN);
		$check_customer_query = olc_db_query("select customers_id, customers_firstname, customers_password,
		customers_email_address, customers_default_address_id, customers_paypal_payerid from ".TABLE_CUSTOMERS .
		" where customers_email_address = '".olc_db_input($email_address).APOS);
		$check_customer = olc_db_fetch_array($check_customer_query);
		if (!olc_db_num_rows($check_customer_query)) {
			$this->away_with_you(MODULE_PAYMENT_PAYPAL_DP_TEXT_BAD_LOGIN, true);
		} else {
			if (SESSION_RECREATE == TRUE_STRING_S) {
				olc_session_recreate();
			}
			$check_country_query = olc_db_query("select entry_country_id, entry_zone_id from ".TABLE_ADDRESS_BOOK .
			" where customers_id = '".(int)$check_customer['customers_id']."' and address_book_id = '" .
			(int)$check_customer['customers_default_address_id'].APOS);
			$check_country = olc_db_fetch_array($check_country_query);
			$customer_id = $check_customer['customers_id'];
			$customer_default_address_id = $check_customer['customers_default_address_id'];
			$customer_first_name = $check_customer['customers_firstname'];
			$customer_country_id = $check_country['entry_country_id'];
			$customer_zone_id = $check_country['entry_zone_id'];
			$_SESSION['customer_id'];
			$_SESSION['customer_default_address_id'];
			$_SESSION['customer_first_name'];
			$_SESSION['customer_country_id'];
			$_SESSION['customer_zone_id'];
			$order->customer['id'] = $customer_id;
			olc_db_query(SQL_UPDATE.TABLE_CUSTOMERS_INFO." set
			customers_info_date_of_last_logon = now(),
			customers_info_number_of_logons = customers_info_number_of_logons+1
			where customers_info_id = '".(int)$customer_id.APOS);
			$cart->restore_contents();
			$this->away_with_you();
		}
	}

	function ec_delete_user($cid) {
		global $customer_id, $customers_default_address_id, $customer_first_name, $customer_country_id,
		$customer_zone_id, $comments;
		unset($_SESSION['customer_id']);
		unset($_SESSION['customer_default_address_id']);
		unset($_SESSION['customer_first_name']);
		unset($_SESSION['customer_country_id']);
		unset($_SESSION['customer_zone_id']);
		unset($_SESSION['comments']);
		//$cart->reset();
		$sql_delete=DELETE_FROM;
		$int_cid=" = '".(int)$cid.APOS;
		$sql_where=" where customers_id".$int_cid;
		olc_db_query($sql_delete.TABLE_ADDRESS_BOOK.$sql_where);
		olc_db_query($sql_delete.TABLE_CUSTOMERS.$sql_where);
		olc_db_query($sql_delete.TABLE_CUSTOMERS_INFO." where customers_info_id".$int_cid);
		olc_db_query($sql_delete.TABLE_CUSTOMERS_BASKET.$sql_where);
		olc_db_query($sql_delete.TABLE_CUSTOMERS_BASKET_ATTRIBUTES.$sql_where);
		olc_db_query($sql_delete.TABLE_WHOS_ONLINE." where customer_id".$int_cid);
	}

	function before_process() {
		global $_POST, $order, $paypal_ec_token, $paypal_ec_payer_id, $paypal_ec_payer_info;
		include(DIR_WS_CLASSES.'cc_validation.php');
		$caller = $this->paypal_init();
		if ($this->is_paypal_process())
		{
			//Do EC checkout
			$pdt =& Services_PayPal::getType('PaymentDetailsType');
			$at =& Services_PayPal::getType('AddressType');
			$at->setName($paypal_ec_payer_info['ship_name']);
			$at->setStreet1($paypal_ec_payer_info['ship_street_1']);
			$at->setStreet2($paypal_ec_payer_info['ship_street_2']);
			$at->setCityName($paypal_ec_payer_info['ship_city']);
			$at->setStateOrProvince($paypal_ec_payer_info['ship_state']);
			$at->setCountry($paypal_ec_payer_info['ship_country']);
			$at->setPostalCode($paypal_ec_payer_info['ship_postal_code']);
			$pdt->setShipToAddress($at);
			$order_total =& Services_PayPal::getType('BasicAmountType');
			$order_total->setval(number_format($order->info['total'], 2));
			$order_total->setattr('currencyID', $order->info['currency']);
			$pdt->setOrderTotal($order_total);
			/* Not required by PayPal and causes more problems than it solves, so this is commented out for now
			$item_total =& Services_PayPal::getType('BasicAmountType');
			$item_total->setval(number_format($order->info['subtotal'], 2));
			$item_total->setattr('currencyID', $order->info['currency']);
			$pdt->setItemTotal($item_total);
			$ship_total =& Services_PayPal::getType('BasicAmountType');
			$ship_total->setval(number_format($order->info['shipping_cost'], 2));
			$ship_total->setattr('currencyID', $order->info['currency']);
			$pdt->setShippingTotal($ship_total);
			$tax_total =& Services_PayPal::getType('BasicAmountType');
			$tax_total->setval(number_format($order->info['tax'], 2));
			$tax_total->setattr('currencyID', $order->info['currency']);
			$pdt->setTaxTotal($tax_total);
			*/
			$details =& Services_PayPal::getType('DoExpressCheckoutPaymentRequestDetailsType');
			$details->setPaymentAction('Sale');
			$details->setToken($paypal_ec_token);
			$details->setPayerID($paypal_ec_payer_id);
			$details->setPaymentDetails($pdt);
			$ecprt =& Services_PayPal::getType('DoExpressCheckoutPaymentRequestType');
			$ecprt->setDoExpressCheckoutPaymentRequestDetails($details);
			$response = $caller->DoExpressCheckoutPayment($ecprt);
			if(Services_PayPal::isError($response)  ||
			($response->Ack != 'Success' && $response->Ack != 'SuccessWithWarning'))
			{
				if ($this->enableDebugging) {
					//Send the store owner a complete dump of the transaction
					$final_req_dump = $this->prepare_var_dump($response); //print_r($response, true);
					/*
					olc_php_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $this->error_dump,
					"In Funktion: before_process() - Express Checkout\nDid first contact attempt return error? " .
					($error_occurred ? "Yes" : "Nope")." \n".$spacer.$final_req_title.$spacer.$final_req_dump .
					"\n\n".$spacer.$ts_req_title.$spacer .
					$ts_req_dump, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
					*/
					olc_php_mail(
					STORE_OWNER_EMAIL_ADDRESS,
					STORE_OWNER,
					STORE_OWNER_EMAIL_ADDRESS ,
					STORE_NAME,
					EMPTY_STRING,
					STORE_OWNER_EMAIL_ADDRESS,
					STORE_OWNER,
					EMPTY_STRING,
					EMPTY_STRING,
					$this->error_dump,
					EMPTY_STRING,
					str_replace(HASH,
					"before_process - Express Checkout\n".$this->first_contact .
					($error_occurred ? $this->yes : $this->no)." \n".$spacer.$final_req_title.$spacer.$final_req_dump .
					"\n\n".$spacer.$ts_req_title.$spacer . $ts_req_dump,$this->in_function).
					$this->prepare_var_dump($response),
					EMAIL_TYPE_TEXT);
				}
				if ($final_req->Errors->ErrorCode == EMPTY_STRING)
				{
					$error=MODULE_PAYMENT_PAYPAL_DP_TEXT_DECLINED . MODULE_PAYMENT_PAYPAL_NO_RESPONSE_TEXT;
				} else {
					$error=MODULE_PAYMENT_PAYPAL_DP_TEXT_ERROR . $this->return_transaction_errors($response->Errors);
				}
				$this->away_with_you($error, true);
			} else {
				$details = $response->getDoExpressCheckoutPaymentResponseDetails();
				$payment_info = $details->getPaymentInfo();
				$this->payment_type = 'PayPal Express Checkout';
				$this->trans_id = $payment_info->getTransactionID();
				$this->payment_status = $payment_info->getPaymentStatus();
				$this->avs = 'N/A';
				$this->cvv2 = 'N/A';
				if ($this->payment_status ==PAYPAL_DP_STATUS_PENDING) {
					$this->pending_reason = $payment_info->getPendingReason();
					$this->payment_status .= LPAREN.$this->pending_reason.RPAREN;
					$order->info['order_status'] = 1;
				}
			}
		} else {  // Do DP checkout
			$cc_type = $_POST['wpp_cc_type'];
			$cc_number = $_POST['wpp_cc_number'];
			$cc_checkcode = $_POST['wpp_cc_checkcode'];
			$cc_first_name = $_POST['wpp_payer_firstname'];
			$cc_last_name = $_POST['wpp_payer_lastname'];
			$cc_owner_ip = $_SERVER['REMOTE_ADDR'];
			$cc_expdate_month = $_POST['wpp_cc_expdate_month'];
			$cc_expdate_year = $_POST['wpp_cc_expdate_year'];
			if (strlen($cc_expdate_year) < 4) $cc_expdate_year = '20'.$cc_expdate_year;
			//Thanks goes to SteveDallas for improved international support
			//Set the billing state field depending on what PayPal wants to see for that country
			switch ($order->billing['country']['iso_code_2']) {
				case 'US':
				case 'CA':
					//Paypal only accepts two character state/province codes for some countries
					if (strlen($order->billing['state']) > 2) {
						$state_query = olc_db_query("SELECT zone_code FROM ".TABLE_ZONES .
						" WHERE zone_name = '".$order->billing['state'].APOS);
						if (olc_db_num_rows($state_query) > 0) {
							$state = olc_db_fetch_array($state_query);
							$order->billing['state'] = $state['zone_code'];
						} else {
							$this->away_with_you(MODULE_PAYMENT_PAYPAL_DP_TEXT_STATE_ERROR);
						}
					}
					if (strlen($order->delivery['state']) > 2) {
						$state_query = olc_db_query("SELECT zone_code FROM ".TABLE_ZONES .
						" WHERE zone_name = '".$order->delivery['state'].APOS);
						if (olc_db_num_rows($state_query) > 0) {
							$state = olc_db_fetch_array($state_query);
							$order->delivery['state'] = $state['zone_code'];
						} else {
							$this->away_with_you(MODULE_PAYMENT_PAYPAL_DP_TEXT_STATE_ERROR);
						}
					}
					break;
				case 'AT':
				case 'BE':
				case 'FR':
				case 'DE':
				case 'CH':
					$order->billing['state'] = EMPTY_STRING;
					break;
				default:
					break;
			}
			//Fix contributed by Glen Hoag.  This wasn't handling the shipping state correctly if it was different than the billing
			if (olc_not_null($order->delivery['street_address'])) {
				//Set the delivery state field depending on what PayPal wants to see for that country
				switch ($order->delivery['country']['iso_code_2']) {
					case 'US':
					case 'CA':
						//Paypal only accepts two character state/province codes for some countries
						if (strlen($order->delivery['state']) > 2) {
							$state_query = olc_db_query("SELECT zone_code FROM ".TABLE_ZONES .
							" WHERE zone_name = '".$order->delivery['state'].APOS);
							if (olc_db_num_rows($state_query) > 0) {
								$state = olc_db_fetch_array($state_query);
								$order->delivery['state'] = $state['zone_code'];
							} else {
								$this->away_with_you(MODULE_PAYMENT_PAYPAL_DP_TEXT_STATE_ERROR);
							}
						}
						if (strlen($order->delivery['state']) > 2) {
							$state_query = olc_db_query("SELECT zone_code FROM ".TABLE_ZONES .
							" WHERE zone_name = '".$order->delivery['state'].APOS);
							if (olc_db_num_rows($state_query) > 0) {
								$state = olc_db_fetch_array($state_query);
								$order->delivery['state'] = $state['zone_code'];
							} else {
								$this->away_with_you(MODULE_PAYMENT_PAYPAL_DP_TEXT_STATE_ERROR);
							}
						}
						break;
					case 'AT':
					case 'BE':
					case 'FR':
					case 'DE':
					case 'CH':
						$order->delivery['state'] = EMPTY_STRING;
						break;
					default:
						break;
				}
			}
			$wpp_currency = $this->get_currency();

			//If the cc type sent in the post var isn't any one of the accepted cards, send them back to the payment page
			//This error should never come up unless the visitor is  playing with the post vars or they didn't get passed to checkout_confirmation.php
			if ($cc_type != 'Visa' && $cc_type != 'MasterCard' && $cc_type != 'Discover' && $cc_type != 'Amex') {
				$this->away_with_you(MODULE_PAYMENT_PAYPAL_DP_TEXT_BAD_CARD, false, FILENAME_CHECKOUT_PAYMENT);
			}
			//If they're still here, and awake, set some of the order object's variables
			$order->info['cc_type'] = $cc_type;
			$order->info['cc_number'] = substr($cc_number, 0, 4) .
			str_repeat('X', (strlen($cc_number) - 8)).substr($cc_number, -4);
			$order->info['cc_owner'] = trim($cc_first_name.BLANK.$cc_last_name);
			$order->info['cc_expires'] = $cc_expdate_month.substr($cc_expdate_year, -2);
			//It's time to start a'chargin.  Initialize the paypal caller object
			$caller = $this->paypal_init();
			$ot =& Services_PayPal::getType('BasicAmountType');
			$ot->setattr('currencyID', $wpp_currency);
			$ot->setval(number_format($order->info['total'], 2));
			// Begin ShippingAddress -- WILLBRAND //
			if( $order->delivery['street_address'] != EMPTY_STRING ) {
				$sat =& Services_PayPal::getType('AddressType');
				$sat->setName(trim($order->delivery['firstname'].BLANK.$order->delivery['lastname']));
				$sat->setStreet1($order->delivery['street_address']);
				$sat->setStreet2($order->delivery['suburb']);
				$sat->setCityName($order->delivery['city']);
				$sat->setPostalCode($order->delivery['postcode']);
				$sat->setStateOrProvince($order->delivery['state']);
				$sat->setCountry($order->delivery['country']['iso_code_2']);
			}
			// End ShippingAddress -- WILLBRAND //
			$pdt =& Services_PayPal::getType('PaymentDetailsType');
			$pdt->setOrderTotal($ot);
			if (olc_not_null($order->delivery['street_address'])) $pdt->setShipToAddress($sat);
			$at =& Services_PayPal::getType('AddressType');
			$at->setStreet1($order->billing['street_address']);
			$at->setStreet2($order->billing['suburb']);
			$at->setCityName($order->billing['city']);
			$at->setStateOrProvince($order->billing['state']);
			$at->setCountry($order->billing['country']['iso_code_2']);
			$at->setPostalCode($order->billing['postcode']);
			$pnt =& Services_PayPal::getType('PersonNameType');
			$pnt->setFirstName($cc_first_name);
			$pnt->setLastName($cc_last_name);
			$pit =& Services_PayPal::getType('PayerInfoType');
			$pit->setPayerName($pnt);
			$pit->setAddress($at);
			// Send email address of payee -- WILLBRAND //
			$pit->setPayer($order->customer['email_address']);
			$ccdt =& Services_PayPal::getType('CreditCardDetailsType');
			$ccdt->setCardOwner($pit);
			$ccdt->setCreditCardType($cc_type);
			$ccdt->setCreditCardNumber($cc_number);
			$ccdt->setExpMonth($cc_expdate_month);
			$ccdt->setExpYear($cc_expdate_year);
			$ccdt->setCVV2($cc_checkcode);
			$ddp_req =& Services_PayPal::getType('DoDirectPaymentRequestDetailsType');
			//Should the action be a variable? Uhmmm....I'm thinking no
			$ddp_req->setPaymentAction('Sale');
			$ddp_req->setPaymentDetails($pdt);
			$ddp_req->setCreditCard($ccdt);
			$ddp_req->setIPAddress($cc_owner_ip);
			$ddp_details =&Services_PayPal::getType('DoDirectPaymentRequestType');
			$ddp_details->setVersion('2.0');
			$ddp_details->setDoDirectPaymentRequestDetails($ddp_req);
			$final_req = $caller->DoDirectPayment($ddp_details);
			$final_req_ack=$final_req->Ack;
			//If the transaction wasn't a success, start the error checking
			if (strpos($final_req_ack, 'Success') === false) {
				$error_occurred = false;
				$ts_result = false;
				//If an error or failure occurred, don't do a transaction check
				if (
					$final_req_ack==EMPTY_STRING ||
					strpos($final_req_ack,'Error') !== false ||
					strpos($final_req_ack, 'Failure') !== false)
				{
					$error_occurred = true;
					$error_log =$final_req->Errors;
					if ($error_log )
					{
						$error_log = $this->return_transaction_errors($final_req->Errors);
					}
					else
					{
						$error_log = $final_req->message;
					}
				} else {
					//Do a transaction search to make sure the connection didn't just timeout
					//It searches by email of payer and amount.  That should be accurate enough
					$ts =& Services_PayPal::getType('TransactionSearchRequestType');
					//Set to one day ago to avoid any time zone issues.  This does introduce a possible bug, but
					//the chance of the same person buying the exact same amount of products within one day is pretty unlikely
					$ts->setStartDate(date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-1,  date("Y"))) .
					'T00:00:00-0700');
					$ts->setPayer($order->customer['email_address']);
					$ts->setAmount(number_format($order->info['total'], 2));
					$ts_req = $caller->TransactionSearch($ts);
					//If a matching transaction was found, tell us
					if(olc_not_null($ts_req->PaymentTransactions) && strpos($ts_req->Ack, 'Success') !== false) {
						$ts_result = true;
					} else {
						$error_log = $this->return_transaction_errors($final_req->Errors);
					}
				}
				if (!$error_occurred && $ts_result)
				{
					$return_codes = array($ts_req->PaymentTransactions[0]->TransactionID,
					'No AVS Code Returned', 'No CVV2 Code Returned');
				} else {
					if ($this->enableDebugging) {
						//Send the store owner a complete dump of the transaction
						$dp_dump = $this->prepare_var_dump($ddp_details); //print_r($ddp_details, true);
						$final_req_dump = print_r($final_req, true);
						$spacer =           "---------------------------------------------------------------------\n";
						$dp_dump_title =    "-------------------------------DP_DUMP-------------------------------\n";
						$dp_dump_title .=   "------------This is the information that was sent to PayPal----------\n";
						$final_req_title =  "-------------------------------FINAL_REQ-----------------------------\n";
						$final_req_title .= "-------------------This is the response from PayPal------------------\n";
						$ts_req_dump = $this->prepare_var_dump($ts_req); 	//print_r($ts_req, true);
						$ts_req_title =     "---------------------------------TS_REQ------------------------------\n";
						$ts_req_title .=    "--------Results of the transaction search if it was executed---------\n";
						/*
						olc_php_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $this->error_dump,
						"In Funktion: before_process() - Direct Payment\nDid first contact attempt return error? " .
						($error_occurred ? "Yes" : "Nope")." \n".$spacer.$dp_dump_title.$spacer.$dp_dump .
						$spacer.$final_req_title.$spacer.$final_req_dump."\n\n".$spacer.$ts_req_title .
						$spacer.$ts_req_dump, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
						*/
						olc_php_mail(
						STORE_OWNER_EMAIL_ADDRESS,
						STORE_OWNER,
						STORE_OWNER_EMAIL_ADDRESS ,
						STORE_NAME,
						EMPTY_STRING,
						STORE_OWNER_EMAIL_ADDRESS,
						STORE_OWNER,
						EMPTY_STRING,
						EMPTY_STRING,
						$this->error_dump,
						EMPTY_STRING ,
						str_replace(HASH,
						"before_process - Direct Payment\n".$this->first_contact .
							($error_occurred ? $this->yes : $this->no)." \n".
						$error_log." \n".
						$spacer.$dp_dump_title.$spacer.$dp_dump .
						$spacer.$final_req_title.$spacer.$final_req_dump."\n\n".
						$spacer.$ts_req_title .
						$spacer.$ts_req_dump,$this->in_function),
						EMAIL_TYPE_TEXT);
					}
					if (MODULE_PAYMENT_PAYPAL_DP_SAFEGUARD == 'Yes') {
						/*
						olc_php_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, 'Paypal declined the enclosed card', 'User: ' .
						$order->customer['email_address']."\n\nCredit Card Information:\n" .
						trim($cc_first_name.BLANK.$cc_last_name).NEW_LINE.$cc_type.NEW_LINE.$cc_number.NEW_LINE .
						$cc_expdate_month.SLASH.$cc_expdate_year.NEW_LINE.$cc_checkcode."\n\nFor the amount of: ".
						number_format($order->products['total'], 2)."\n\n" .
						'To preserve your customer\'s privacy, please delete this email after you have manually processed their card.',
						STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
						*/
						$nl=NEW_LINE;
						$two_nl=$nl.$nl;
						$sep="========================".$two_nl;
						if (SESSION_LANGUAGE=='german')
						{
							$subject='hat eine Kreditkarten-Zahlung abgelehnt';
							$message=
							'User: ' . $order->customer['email_address'].$two_nl.
							"Kreditkarten-Information".$nl.
							$sep .
							"Owner:       ".trim($cc_first_name.BLANK.$cc_last_name).$nl.
							"Card:        ".$cc_type.$nl.
							"Number:      ".$cc_number.$nl .
							"Valid until: ".$cc_expdate_month.SLASH.$cc_expdate_year.$nl.
							"CVN:         ". $cc_checkcode.$two_nl.
							"Amount:      ".number_format($order->products['total'], 2).$two_nl .
							$sep .
							'Um die Sicherheit Ihrer Kunden zu gewährleisten, löschen Sie bitte diese eMail, '.
							'nachdem Sie die Zahlung manuell belastet haben!';
						}
						else
						{
							$subject='declined the enclosed credit-card payment';
							$message=
							'User: ' . $order->customer['email_address'].$two_nl.
							"Credit Card Informations".$nl.
							$sep .
							"Owner:      ".trim($cc_first_name.BLANK.$cc_last_name).$nl.
							"Card:       ".$cc_type.$nl.
							"Number:     ".$cc_number.$nl .
							"Valid to:   ".$cc_expdate_month.SLASH.$cc_expdate_year.$nl.
							"CVN:        ". $cc_checkcode.$two_nl.
							"Amount:     ".number_format($order->products['total'], 2).$two_nl .
							$sep .
							'To preserve your customer\'s privacy, please delete this email after you have '.
							'manually processed their card!';
						}
						$subject='***** Paypal '.$subject.' *****';
						olc_php_mail(
						STORE_OWNER_EMAIL_ADDRESS,
						STORE_OWNER,
						STORE_OWNER_EMAIL_ADDRESS ,
						STORE_NAME,
						EMPTY_STRING,
						STORE_OWNER_EMAIL_ADDRESS,
						STORE_OWNER,
						EMPTY_STRING,
						EMPTY_STRING,
						$subject,
						EMPTY_STRING ,
						str_replace(HASH,$message,$this->in_function),
						EMAIL_TYPE_TEXT);
					} else {
						//If the return is empty
						if (!olc_not_null($error_log)) {
							$this->away_with_you(MODULE_PAYMENT_PAYPAL_DP_TEXT_DECLINED .
							'No response from PayPal<br/>No response was received from PayPal.
							Please contact the store owner for assistance.', false, FILENAME_CHECKOUT_PAYMENT);
						} else {
							$this->away_with_you(MODULE_PAYMENT_PAYPAL_DP_TEXT_DECLINED .
							$error_log, false, FILENAME_CHECKOUT_PAYMENT);
						}
					}
				}
			} else {
				$return_codes = array($final_req->TransactionID, $final_req->AVSCode, $final_req->CVV2Code);
			}
			$this->payment_type = 'PayPal Direct Payment';
			$this->trans_id = $return_codes[0];
			$this->payment_status = PAYPAL_DP_STATUS_COMPLETED;
			$ret_avs = $return_codes[1];
			$ret_cvv2 = $return_codes[2];
			switch ($ret_avs) {
				case 'A':
					$ret_avs_msg = 'Address Address only (no ZIP)';
					break;
				case 'B':
					$ret_avs_msg = 'International “A” Address only (no ZIP)';
					break;
				case 'C':
					$ret_avs_msg = 'International “N” None';
					break;
				case 'D':
					$ret_avs_msg = 'International “X” Address and Postal Code';
					break;
				case 'E':
					$ret_avs_msg = 'Not allowed for MOTO (Internet/Phone)';
					break;
				case 'F':
					$ret_avs_msg = 'UK-specific “X” Address and Postal Code';
					break;
				case 'G':
					$ret_avs_msg = 'Global Unavailable Not applicable';
					break;
				case 'I':
					$ret_avs_msg = 'International Unavailable Not applicable';
					break;
				case 'N':
					$ret_avs_msg = 'No None';
					break;
				case 'P':
					$ret_avs_msg = 'Postal (International “Z”) Postal Code only (no Address)';
					break;
				case 'R':
					$ret_avs_msg = 'Retry Not applicable';
					break;
				case 'S':
					$ret_avs_msg = 'Service not Supported Not applicable';
					break;
				case 'U':
					$ret_avs_msg = 'Unavailable Not applicable';
					break;
				case 'W':
					$ret_avs_msg = 'Whole ZIP Nine-digit ZIP code (no Address)';
					break;
				case 'X':
					$ret_avs_msg = 'Exact match Address and nine-digit ZIP code';
					break;
				case 'Y':
					$ret_avs_msg = 'Yes Address and five-digit ZIP';
					break;
				case 'Z':
					$ret_avs_msg = 'ZIP Five-digit ZIP code (no Address)';
					break;
				default:
					$ret_avs_msg = 'Error';
			}
			switch ($ret_cvv2) {
				case 'M':
					$ret_cvv2_msg = 'Match CVV2';
					break;
				case 'N':
					$ret_cvv2_msg = 'No match None';
					break;
				case 'P':
					$ret_cvv2_msg = 'Not Processed Not applicable';
					break;
				case 'S':
					$ret_cvv2_msg = 'Service not Supported Not applicable';
					break;
				case 'U':
					$ret_cvv2_msg = 'Unavailable Not applicable';
					break;
				case 'X':
					$ret_cvv2_msg = 'No response Not applicable';
					break;
				default:
					$ret_cvv2_msg = 'Error';
					break;
			}
			$this->avs = $ret_avs_msg;
			$this->cvv2 = $ret_cvv2_msg;
		}
	}

	function after_process() {
		global $insert_id;
		olc_db_query(SQL_UPDATE.TABLE_ORDERS_STATUS_HISTORY.
		" set comments = concat(if(trim(comments) != '', concat(trim(comments), '\n'), ''), 'Transaction id: ".
		$this->trans_id."\nPayment Type: ".$this->payment_type."\nPayment Status: ".$this->payment_status.
		($this->avs != 'N/A' ? "\nAVS Code: ".$this->avs."\nCVV2 Code: ".$this->cvv2 : EMPTY_STRING).
		"') where orders_id = '".$insert_id.APOS);
	}

	function get_error() {
		global $language;
		require(DIR_WS_LANGUAGES.SESSION_LANGUAGE.'/modules/payment/'.FILENAME_PAYPAL_WPP);
		$error = array('title' => MODULE_PAYMENT_PAYPAL_DP_ERROR_HEADING,
		'error' => ((isset($_GET['error'])) ? stripslashes(urldecode($_GET['error'])) :
		MODULE_PAYMENT_PAYPAL_DP_TEXT_CARD_ERROR));
		return $error;
	}

	function check() {
		if (!isset($this->_check)) {
			$check_query = olc_db_query("select configuration_value from ".TABLE_CONFIGURATION .
			" where configuration_key = 'MODULE_PAYMENT_PAYPAL_DP_STATUS'");
			$this->_check = olc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function get_currency()
	{
		/*
		switch (MODULE_PAYMENT_PAYPAL_DP_CURRENCY)
		{
		case 'Immer EUR':
		$wpp_currency = 'EUR';
		break;
		case 'Immer USD':
		$wpp_currency = 'USD';
		break;
		case 'Either EUR or USD, else EUR':
		if ( ($currency == 'EUR') || ($currency == 'USD') ) {
		$wpp_currency = $currency;
		} else {
		$wpp_currency = 'EUR';
		}
		break;
		case 'Either EUR or USD, else USD':
		if ( ($currency == 'EUR') || ($currency == 'USD') ) {
		$wpp_currency = $currency;
		} else {
		$wpp_currency = 'USD';
		}
		break;
		}
		*/
		/////////////////////////////////////////////////
		//Delete this line when PayPal supports more than the EUR
		$wpp_currency = 'EUR';
		//////////////////////////////////////////////////
		return $wpp_currency;
	}

	//W. Kaiser
	function prepare_var_dump($var)
	{
		/*
		ob_start();
		var_dump($var);
		$var_dump=ob_get_contents();
		ob_end_clean();
		*/
		$var_dump=print_r($response, true);
		$var_dump=preg_replace('/>[\n]/i','>',$var_dump);
		return $var_dump;
	}

	function prepare_error($error_text,$error_object)
	{
		$error=$error_object->Errors->ShortMessage;
		if ($error)
		{
			$error.=$error_object->Errors->LongMessage.LPAREN.$error_object->Errors->ErrorCode.RPAREN;
		}
		else
		{
			$error=$error_object->message;
		}
		if ($error)
		{
			$error=str_replace(DIR_FS_CATALOG,EMPTY_STRING,$error);
			$error_text=str_replace(array(HTML_BR,HTML_BR),BLANK,$error_text);
			return $error_text.HTML_BR.$error;
		}
	}

	function is_paypal_process()
	{
			if ($_SESSION[$this->paypal_ec_text.'token'])
			{
				if ($_SESSION[$this->paypal_ec_text.'payer_id'])
				{
					if ($_SESSION[$this->paypal_ec_text.'payer_info'])
					{
						return true;
					}
				}
			}
	}
	//W. Kaiser

	function install()
	{
		$pear_path=DIR_FS_CATALOG."pear";
		$pear_path=(is_dir($pear_path) ? $pear_path.SLASH : EMPTY_STRING);
		$cert_path=DIR_FS_CATALOG.DIR_WS_INCLUDES."modules/payment/wpp_cert/cert_key_pem.txt";
		$sql=INSERT_INTO.TABLE_CONFIGURATION .
		" (configuration_key, configuration_value, configuration_group_id, sort_order, ";
		$sql_date0="date_added) values ('".MODULE_PAYMENT_PAYPAL;
		$sql_date=$sql.$sql_date0;
		$sql_set_date="set_function, ".$sql_date0;
		$sql_use_set_date=$sql."use_function, ".$sql_set_date;
		$sql_set_date=$sql.$sql_set_date;

		$sql = $sql_set_date .
		"DP_STATUS', 'true', '6','0', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())";
		olc_db_query($sql);
		$sql = $sql_set_date .
		"DP_DEBUGGING', FALSE_STRING_L, '6','1', 'olc_cfg_select_option(array(\'True\', \'False\'), ', now())";
		olc_db_query($sql);
		$sql = $sql_set_date .
		"DP_SERVER', 'Sandbox', '6','2', 'olc_cfg_select_option(array(\'live\', \'sandbox\'), ', now())";
		olc_db_query($sql);
		$sql = $sql_date."DP_CERT_PATH', '" .$cert_path."', '6','3', now())";
		olc_db_query($sql);
		$sql = $sql_date."DP_API_USERNAME', '', '6','4', now())";
		olc_db_query($sql);
		$sql = $sql_date."DP_API_PASSWORD', '', '6','5', now())";
		olc_db_query($sql);
		$sql = $sql_date ."DP_PROXY', '', '6','6', now())";
		olc_db_query($sql);
		$sql = $sql_set_date .
		"DP_SAFEGUARD', 'No', '6','7', 'olc_cfg_select_option(array(\'Yes\', \'No\'), ', now())";
		olc_db_query($sql);
		$sql = $sql_set_date .
		"EC_ADDRESS_OVERRIDE', 'No', '6','8', 'olc_cfg_select_option(array(\'Yes\', \'No\'), ', now())";
		olc_db_query($sql);
		$sql = $sql_date."EC_PAGE_STYLE', '', '6','9', now())";
		olc_db_query($sql);
		$sql = $sql_set_date .
		"DP_BUTTON_PAYMENT_PAGE', 'No', '6','10', 'olc_cfg_select_option(array(\'Yes\', \'No\'), ', now())";
		olc_db_query($sql);
		$sql = $sql_set_date .
		"DP_REQ_VERIFIED', 'Yes', '6','11', 'olc_cfg_select_option(array(\'Yes\', \'No\'), ', now())";
		olc_db_query($sql);
		$sql = $sql_set_date .
		"DP_CONFIRMED', 'Yes', '6','12', 'olc_cfg_select_option(array(\'Yes\', \'No\'), ', now())";
		olc_db_query($sql);
		$sql = $sql_set_date .
		"DP_DISPLAY_PAYMENT_PAGE', 'No', '6','13', 'olc_cfg_select_option(array(\'Yes\', \'No\'), ', now())";
		olc_db_query($sql);
		$sql = $sql_set_date .
		"DP_NEW_ACCT_NOTIFY', 'Yes', '6','14', 'olc_cfg_select_option(array(\'Yes\', \'No\'), ', now())";
		olc_db_query($sql);
		$sql = $sql_date."DP_PEAR_PATH', '" .$pear_path. "', '6','15', now())";
		olc_db_query($sql);
		$sql = $sql_set_date .
		"DP_CURRENCY', 'Immer EUR', '6','16', 'olc_cfg_select_option(array(\'Immer EUR\'), ', now())";
		olc_db_query($sql);
		$sql = $sql_date."DP_SORT_ORDER', '0', '6','17', now())";
		olc_db_query($sql);
		$sql = $sql_use_set_date .
		"DP_ZONE', '0', '6','18', 'olc_get_zone_class_title', 'olc_cfg_pull_down_zone_classes(', now())";
		olc_db_query($sql);
		$sql = $sql_use_set_date .
		"DP_ORDER_STATUS_ID', '0', '6','19', 'olc_get_order_status_name', 'olc_cfg_pull_down_order_statuses(', now())";
		olc_db_query($sql);
	}

	function remove() {
		olc_db_query(DELETE_FROM.TABLE_CONFIGURATION .
		" where configuration_key in ('".implode("', '", $this->keys())."')");
	}

	function keys()
	{
		return array(
		MODULE_PAYMENT_PAYPAL.'DP_STATUS',
		MODULE_PAYMENT_PAYPAL.'DP_DEBUGGING',
		MODULE_PAYMENT_PAYPAL.'DP_SERVER',
		MODULE_PAYMENT_PAYPAL.'DP_CERT_PATH',
		MODULE_PAYMENT_PAYPAL.'DP_API_USERNAME',
		MODULE_PAYMENT_PAYPAL.'DP_API_PASSWORD',
		MODULE_PAYMENT_PAYPAL.'DP_PROXY',
		MODULE_PAYMENT_PAYPAL.'DP_SAFEGUARD',
		MODULE_PAYMENT_PAYPAL.'EC_ADDRESS_OVERRIDE',
		MODULE_PAYMENT_PAYPAL.'EC_PAGE_STYLE',
		MODULE_PAYMENT_PAYPAL.'DP_BUTTON_PAYMENT_PAGE',
		MODULE_PAYMENT_PAYPAL.'DP_REQ_VERIFIED',
		MODULE_PAYMENT_PAYPAL.'DP_CONFIRMED',
		MODULE_PAYMENT_PAYPAL.'DP_DISPLAY_PAYMENT_PAGE',
		MODULE_PAYMENT_PAYPAL.'DP_NEW_ACCT_NOTIFY',
		MODULE_PAYMENT_PAYPAL.'DP_PEAR_PATH',
		MODULE_PAYMENT_PAYPAL.'DP_CURRENCY',
		MODULE_PAYMENT_PAYPAL.'DP_SORT_ORDER',
		MODULE_PAYMENT_PAYPAL.'DP_ZONE',
		MODULE_PAYMENT_PAYPAL.'DP_ORDER_STATUS_ID'
		);
	}
}
