<?php
/* -----------------------------------------------------------------------------------------
$Id: tell_a_friend.php,v 1.1.1.1.2.1 2007/04/08 07:16:22 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(tell_a_friend.php,v 1.39 2003/05/28); www.oscommerce.com
(c) 2003	    nextcommerce (tell_a_friend.php,v 1.13 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include('includes/application_top.php');
olc_smarty_init($mail_smarty,$cacheid);

//require_once(BOXES);
// include needed functions
require_once(DIR_FS_INC.'olc_draw_textarea_field.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');
require_once(DIR_FS_INC.'olc_validate_email.inc.php');
require_once(DIR_WS_CLASSES.'class.phpmailer.php');
require_once(DIR_FS_INC.'olc_php_mail.inc.php');
require_once(DIR_FS_INC.'olc_array_to_string.inc.php');

//	W. Kaiser tell_a_friend
$customer_id = (int)$_SESSION['customer_id'];
$login_done = $customer_id <> 0;
if ($login_done) {
	$account = olc_db_query("select customers_firstname, customers_lastname, customers_email_address from " .
	TABLE_CUSTOMERS . " where customers_id = '" . $customer_id . APOS);
	$account_values = olc_db_fetch_array($account);
	$from_name = trim($account_values['customers_firstname'] . BLANK . $account_values['customers_lastname']);
	$from_email_address = $account_values['customers_email_address'];
}
elseif (ALLOW_GUEST_TO_TELL_A_FRIEND == FALSE_STRING_S)
{
	olc_redirect(olc_href_link(FILENAME_LOGIN));
}
else
{
	$from_name = $_POST['yourname'];
	$from_email_address = $_POST['from'];
}
$products_id = $_GET['products_id'];
$have_products_id = $products_id != EMPTY_STRING;
if ($have_products_id)
{
	$product_info_query = olc_db_query("select pd.products_name from " . TABLE_PRODUCTS . " p, " .
	TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" .
	$products_id . "' and p.products_id = pd.products_id and pd.language_id = '" .
	SESSION_LANGUAGE_ID . APOS);
	$valid_product = (olc_db_num_rows($product_info_query) > 0);
	if ($valid_product)
	{
		$products_name=$product_info_query['products_name'];
		$Link0=olc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_id);
	}
}
else
{
	$valid_product = false;
	$Link0 = olc_href_link(FILENAME_DEFAULT, 'cPath=' . $_GET['cPath'],NONSSL,false,true,false);
	$products_name=STORE_NAME;
}
$Link=HTML_A_START.$Link0.'"><b>'.$products_name.HTML_B_END.HTML_A_END;

if ($valid_product == false) {
	$smarty->assign('heading_tell_a_friend',BOX_TELL_A_FRIEND_TEXT_SITE);
	$Message=NAVBAR_TITLE_TELL_A_FRIEND_SITE;
	if ($_GET['cPath'] != EMPTY_STRING)
	{
		$Parameter='&cPath=' . $_GET['cPath'];
	}
} else {
	$product_info = olc_db_fetch_array($product_info_query);
	$smarty->assign('heading_tell_a_friend',sprintf(HEADING_TITLE_TELL_A_FRIEND,
		preg_replace('/<(br\/?|\/p|p)>/i', BLANK, $model['products_name'])));
	$Message=NAVBAR_TITLE_TELL_A_FRIEND;
	$Parameter='&products_id=' . $products_id;
}

$snapshot=$_SESSION['navigation']->snapshot;
if (sizeof($snapshot) > 0) {
	$redirect_url = $snapshot['page'];
	$redirect_parameters=olc_array_to_string($snapshot['get'],array(olc_session_name()));
	$redirect_mode=$snapshot['mode'];
	$redirect_url=olc_href_link($redirect_url,$redirect_parameters,$redirect_mode);
	$_SESSION['navigation']->clear_snapshot();
} else {
	$redirect_url=$Link0;
}
//W. Kaiser - AJAX
$back_link=HTML_A_START . $redirect_url . '">' . olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END;
$breadcrumb->add($Message, olc_href_link(FILENAME_TELL_A_FRIEND, 'send_to=' . $_GET['send_to'] . $Parameter));
require_once(DIR_WS_INCLUDES . 'header.php');
$error = false;
$HaveAction = ($_GET['action'] == 'process');

if ($HaveAction )
{
	if (olc_validate_email(trim($_POST['friendemail'])))
	{
		$friendemail_error = false;
	} else {
		$friendemail_error = true;
		$error = true;
	}

	if (empty($_POST['friendname'])) {
		$friendname_error = true;
		$error = true;
	} else {
		$friendname_error = false;
	}

	if (!olc_validate_email(trim($from_email_address))) {
		$fromemail_error = true;
		$error = true;
	} else {
		$fromemail_error = false;
	}

	if (empty($from_name)) {
		$fromname_error = true;
		$error = true;
	} else {
		$fromname_error = false;
	}

	if(($_POST['code'] != $_SESSION['vvcode']))
	{
		$seccode_error = true;
		$error = true;
	}
	else
	{
		$seccode_error = false;
	}
}
else
{
	$error = true;
}
if ($error == false) {
	global $messageStack,$mail_error;

	$mail_smarty->assign('message',$_POST['yourmessage']);
	$mail_smarty->assign('from_name',$from_name);
	$mail_smarty->assign('from_email',$from_email_address);
	$mail_smarty->assign('to_name',$_POST['friendname']);
	$mail_smarty->assign('shop_name',STORE_NAME);
	$mail_smarty->assign('shop_email',EMAIL_SUPPORT_ADDRESS);
	$mail_smarty->assign('products_name',$products_name);
	$mail_smarty->assign('HOME_LINK',olc_href_link(FILENAME_DEFAULT, EMPTY_STRING,EMPTY_STRING,false,true,false));
	$mail_smarty->assign('PRODUCTS_LINK',$Link);
	$template=CURRENT_TEMPLATE_MAIL.'tell_friend_mail.';
	$html_mail = $mail_smarty->fetch($template . 'html');
	$smarty->assign('action','send');
	$smarty->assign('BUTTON_CONTINUE',$back_link);
	olc_php_mail($from_email_address, $from_name,$_POST['friendemail'],$_POST['friendname'],EMPTY_STRING,
	$from_email_address, $from_name, EMPTY_STRING, EMPTY_STRING, CONTACT_US_EMAIL_SUBJECT, $html_mail, $txt_mail,EMAIL_TYPE_HTML);
	if ($mail_error)
	{
		$message=nl2br($messageStack->output('mailer'));
	}
	else
	{
		$message=TEXT_EMAIL_SUCCESSFUL_SENT;
	}
	$smarty->assign('message',$message);
} else {
	if ($login_done)
	{
		$your_name_prompt = trim($account_values['customers_firstname'] . BLANK . $account_values['customers_lastname']);
		$your_name_prompt .= olc_draw_hidden_field('yourname',$your_name_prompt);
		$your_name_prompt=HTML_B_START.$your_name_prompt.HTML_B_END;
		$your_email_address_prompt = HTML_B_START.$account_values['customers_email_address'].HTML_B_END;
	} else {
		$your_name_prompt = olc_draw_input_field('yourname',
		(($fromname_error) ? $_POST['yourname'] : $_GET['yourname']));
		if ($fromname_error)
		{
			$smarty->assign('INPUT_NAME_ERROR',TEXT_REQUIRED);
		}
		$your_email_address_prompt = olc_draw_input_field('from',
		(($fromemail_error) ? $_POST['from'] : $_GET['from']));
		if ($fromemail_error)
		{
			$smarty->assign('INPUT_EMAIL_ERROR', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
		}
	}
	$smarty->assign('FORM_ACTION',olc_draw_form('email_friend', olc_href_link(FILENAME_TELL_A_FRIEND,
	'action=process&products_id=' . $products_id)) . olc_draw_hidden_field('products_name',
	$product_info['products_name']));
	$smarty->assign('INPUT_NAME',$your_name_prompt);
	$smarty->assign('INPUT_EMAIL',$your_email_address_prompt);
	$smarty->assign('INPUT_MESSAGE',olc_draw_textarea_field('yourmessage', 'soft', 40, 8));

	$input_friendname= olc_draw_input_field('friendname',
	(($friendname_error) ? $_POST['friendname'] : $_GET['friendname']));
	if ($friendname_error)
	{
		$smarty->assign('INPUT_FRIENDNAME_ERROR', TEXT_REQUIRED);
	}
	$input_friendemail= olc_draw_input_field('friendemail',
	(($friendemail_error) ? $_POST['friendemail'] : $_GET['send_to']));
	if ($friendemail_error)
	{
		$smarty->assign('INPUT_FRIENDEMAIL_ERROR',  ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
	}
	$smarty->assign('INPUT_FRIENDNAME',$input_friendname);
	$smarty->assign('INPUT_FRIENDEMAIL',$input_friendemail);
	$input_seccode = olc_draw_input_field('code',$code);
	if ($seccode_error)
	{
		$smarty->assign('INPUT_CODE_ERROR',  ENTRY_SECCODE_CHECK_ERROR);
	}
	$smarty->assign('VVIMG', '<img src="'.olc_href_link(FILENAME_DISPLAY_VVCODES).'" alt="Sicherheitscode" />');
	$smarty->assign('INPUT_CODE', $input_seccode);

	$smarty->assign('BUTTON_BACK',$back_link);
	$smarty->assign('BUTTON_SUBMIT',olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
}

$main_content= $smarty->fetch(CURRENT_TEMPLATE_MODULE.'tell_a_friend'.HTML_EXT,$cacheid);

$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
//	W. Kaiser tell_a_friend
?>