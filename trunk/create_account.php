<?php
/* -----------------------------------------------------------------------------------------
$Id: create_account.php,v 1.1.1.1.2.1 2007/04/08 07:16:13 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(create_account.php,v 1.63 2003/05/28); www.oscommerce.com
(c) 2003	    nextcommerce (create_account.php,v 1.27 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include('includes/application_top.php');

require_once(BOXES);

// include needed functions
require_once(DIR_FS_INC.'olc_validate_email.inc.php');
require_once(DIR_FS_INC.'olc_encrypt_password.inc.php');
require_once(DIR_WS_CLASSES . 'class.phpmailer.php');
require_once(DIR_FS_INC.'olc_php_mail.inc.php');

$IsUserMode = true;
//$IsUserModeEdit = true;
$IsCreateAccount = true;
define('MESSAGE_STACK_NAME', 'create_account');
define('SMARTY_TEMPLATE', MESSAGE_STACK_NAME) ;

$process = $_POST['action'] == 'process';
if ($process)
{
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
	include(DIR_FS_INC.'olc_get_check_customer_data.php');
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
	if ($error)
	{
		if (IS_AJAX_PROCESSING)
		{
			//Add messagestackinfo
			if (is_object($messageStack))
			{
				$m=$messageStack->size(MESSAGE_STACK_NAME);
				if ($m > 0)
				{
					ajax_error($messageStack->output(MESSAGE_STACK_NAME));
				}
			}
		}
	}
	else
	{
		// build the message content
		$name = trim($customers_firstname . BLANK . $customers_lastname);
		// load data into array
		$module_content = array();
		$module_content = array(
		'MAIL_NAME' => $name,
		'MAIL_REPLY_ADDRESS' => EMAIL_SUPPORT_REPLY_ADDRESS,
		'MAIL_GENDER'=>$customers_gender);
		// assign data to smarty
		$smarty->assign('content', $module_content);
		$txt_mail= CURRENT_TEMPLATE_MAIL.'create_account_mail.';
		$html_mail =$smarty->fetch($txt_mail.'html');
		$txt_mail = $smarty->fetch($txt_mail.'txt');
		// GV Code Start
		// ICW - CREDIT CLASS CODE BLOCK ADDED  ******************************************************* BEGIN
		if (NEW_SIGNUP_GIFT_VOUCHER_AMOUNT > 0) {
			$coupon_code = create_coupon_code();
			$insert_query = olc_db_query(INSERT_INTO . TABLE_COUPONS .
			" (coupon_code, coupon_type, coupon_amount, date_created) values ('" . $coupon_code . "', 'G', '" .
			NEW_SIGNUP_GIFT_VOUCHER_AMOUNT . "', now())");
			$insert_id = olc_db_insert_id($insert_query);
			$insert_query = olc_db_query(INSERT_INTO . TABLE_COUPON_EMAIL_TRACK .
			" (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" .
			$insert_id ."', '0', 'Admin', '" . $customers_email_address . "', now() )");
			$html_mail .= '<br/><br/>'.sprintf(EMAIL_GV_INCENTIVE_HEADER, $currencies->format(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT)) .
			"<br/><br/>" .
			sprintf(EMAIL_GV_REDEEM, $coupon_code) . "<br/><br/>" .
			EMAIL_GV_LINK . olc_href_link(FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code,NONSSL, false) .
			"<br/><br/>";
			$txt_mail .=  "\n\n".sprintf(EMAIL_GV_INCENTIVE_HEADER, $currencies->format(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT)) . "\n\n" .
			sprintf(EMAIL_GV_REDEEM, $coupon_code) . "\n\n" .
			EMAIL_GV_LINK . olc_href_link(FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code,NONSSL, false) .
			"\n\n";
		}
		if (NEW_SIGNUP_DISCOUNT_COUPON != '') {
			$coupon_code = NEW_SIGNUP_DISCOUNT_COUPON;
			$coupon_query = olc_db_query("select * from " . TABLE_COUPONS . " where coupon_code = '" . $coupon_code . APOS);
			$coupon = olc_db_fetch_array($coupon_query);
			$coupon_id = $coupon['coupon_id'];
			$coupon_desc_query = olc_db_query("select * from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" .
			$coupon_id . "' and language_id = '" . (int)$_SESSION['languages_id'] . APOS);
			$coupon_desc = olc_db_fetch_array($coupon_desc_query);
			$insert_query = olc_db_query(INSERT_INTO . TABLE_COUPON_EMAIL_TRACK .
			" (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $coupon_id ."', '0', 'Admin', '" .
			$customers_email_address . "', now() )");
			$html_mail .= "<br/><br/>".EMAIL_COUPON_INCENTIVE_HEADER .  HTML_BR .
			sprintf("%s", $coupon_desc['coupon_description']) ."<br/><br/>" .
			sprintf(EMAIL_COUPON_REDEEM, $coupon['coupon_code']) . "<br/><br/>" .
			"<br/><br/>";
			$txt_mail .= "\n\n".EMAIL_COUPON_INCENTIVE_HEADER .  NEW_LINE .
			sprintf("%s", $coupon_desc['coupon_description']) ."\n\n" .
			sprintf(EMAIL_COUPON_REDEEM, $coupon['coupon_code']) . "\n\n" .
			"\n\n";
		}
		// ICW - CREDIT CLASS CODE BLOCK ADDED  ******************************************************* END
		// GV Code End
		//	W. Kaiser - eMail-type by customer
		olc_php_mail(EMAIL_SUPPORT_ADDRESS,EMAIL_SUPPORT_NAME, $customers_email_address , $name , EMAIL_SUPPORT_FORWARDING_STRING,
		EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', EMAIL_SUPPORT_SUBJECT, $html_mail,
		$txt_mail, $customers_email_type);
		//	W. Kaiser - eMail-type by customer
		if (!isset($mail_error))
		{
			olc_redirect(olc_href_link(FILENAME_SHOPPING_CART));
		}
	}
}
//	W. Kaiser - Common code for "create_account.php" and "customers.php"
include(DIR_FS_INC.'olc_show_customer_data_form.inc.php');
//	W. Kaiser - Common code for "create_account.php" and "customers.php"
?>