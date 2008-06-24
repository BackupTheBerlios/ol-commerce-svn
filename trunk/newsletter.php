<?php
/*------------------------------------------------------------------------------
$Id: newsletter.php,v 1.0

OLC-NEWSLETTER_RECIPIENTS RC1 - Contribution for XT-Commerce http://www.xt-commerce.com
by Matthias Hinsche http://www.gamesempire.de

Copyright (c) 2003 XT-Commerce
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce www.oscommerce.com
(c) 2003	    nextcommerce www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

(c) 2003 xt-commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

require('includes/application_top.php');


// include needed functions
require_once(DIR_FS_INC.'olc_validate_email.inc.php');
require_once(DIR_WS_CLASSES.'class.phpmailer.php');

$force=$_GET['x']==true;
$email= $_GET['email'];
if ($email==EMPTY_STRING)
{
	$email= $_POST['email'];
}
$email= olc_db_input($email);
$have_email=$email!=EMPTY_STRING;
if ($have_email)
{
	global $valid_email;
	olc_validate_email($email);
}
else
{
	$valid_email=true;
}
if ($valid_email)
{
	// include needed functions
	require_once(DIR_FS_INC.'olc_image_button.inc.php');
	require_once(DIR_FS_INC.'olc_draw_radio_field.inc.php');
	require_once(DIR_FS_INC.'olc_php_mail.inc.php');
	//require_once(DIR_FS_INC.'olc_render_vvcode.inc.php');
	require_once(DIR_FS_INC.'olc_encrypt_password.inc.php');
	require_once(DIR_FS_INC.'olc_validate_password.inc.php');
	$action=$_GET['action'];
	$sql_select="select customers_email_address, customers_email_type, mail_key, mail_status";
	$sql_where=" where customers_email_address = '" . $email . APOS;
	if ($action == 'process')
	{
		// Check if email exists
		$code_correct=$_POST['code']==$_SESSION['vvcode'];
		if ($code_correct){
			$check=$_POST['check'];
			$sql_from=SQL_FROM . TABLE_NEWSLETTER_RECIPIENTS .$sql_where;
			$check_mail_query = olc_db_query($sql_select.$sql_from);
			$have_entry=olc_db_num_rows($check_mail_query);
			$activate=$check=='inp';
			if ($activate)
			{
				if ($have_entry)
				{
					$check_mail = olc_db_fetch_array($check_mail_query);
					if ($check_mail['mail_status']=='0')
					{
						$info_message = TEXT_EMAIL_EXIST_NO_NEWSLETTER;
						$send_email=true;
					}else{
						$info_message = TEXT_EMAIL_EXIST_NEWSLETTER;
					}
				}else{
					$send_email=true;
					if (ISSET_CUSTOMER_ID){
						$customers_id = CUSTOMER_ID;
						$customers_status = CUSTOMER_STATUS_ID;
						$customers_firstname = $_SESSION['customer_first_name'];
						$customers_lastname = $_SESSION['customer_last_name'];
					}else{
						$check_customer_mail_query = olc_db_query("select customers_id, customers_status, customers_firstname,
							customers_lastname, customers_email_address,customers_email_type from " .
							TABLE_CUSTOMERS . $sql_where);
						if (olc_db_num_rows($check_customer_mail_query))
						{
							$check_customer = olc_db_fetch_array($check_customer_mail_query);
							$customers_id = $check_customer['customers_id'];
							$customers_status = $check_customer['customers_status'];
							$customers_firstname = $check_customer['customers_firstname'];
							$customers_lastname = $check_customer['customers_lastname'];
							$customers_email_type = $check_customer['customers_email_type '];
						}else{
							$customers_id = '0';
							$customers_status = DEFAULT_CUSTOMERS_STATUS_ID_GUEST;
							$customers_firstname = TEXT_CUSTOMER_GUEST;
							$customers_lastname = EMPTY_STRING;
						}
					}
					$sql_data_array = array(
					'customers_email_address' => $email,
					'customers_email_type' => $customers_email_type ,
					'customers_id' => olc_db_input($customers_id),
					'customers_status' => olc_db_input($customers_status),
					'customers_firstname' => olc_db_input($customers_firstname),
					'customers_lastname' => olc_db_input($customers_lastname),
					'mail_status' => '0',
					'mail_key' => olc_encrypt_password($email),
					'date_added' => 'now()');
					olc_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);
					$info_message = TEXT_EMAIL_INPUT;
					$send_email=true;
					$action='activate';
				}
			}
			else
			{
				$remove=$check=='del';
				if ($remove)
				{
					if ($have_entry)
					{
						$send_email=!$force;
						$action='remove';
					}else{
						$info_message = TEXT_EMAIL_NOT_EXIST;
					}
				}
			}
			if($send_email)
			{
				$link_code = olc_encrypt_password($email);
				$server_link=HTTP_SERVER.DIR_WS_CATALOG;
				$link = olc_href_link(FILENAME_NEWSLETTER, 'action=activate&email='.$email.'&key='.$link_code,NONSSL);
				if (strpos($link,server_link)===false)
				{
					$link =$server_link.$link;
				}
				// assign vars
				$smarty->assign('EMAIL',$email);
				$smarty->assign('LINK',$link);
				$smarty->assign('NAME',trim($customers_firstname.BLANK.$customers_lastname));
				$txt_mail=CURRENT_TEMPLATE_MAIL.'newsletter_'.$action.'_mail';
				$html_mail=$smarty->fetch($txt_mail.HTML_EXT);
				$txt_mail=$smarty->fetch($txt_mail.'.txt');
				olc_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $email, EMPTY_STRING, EMPTY_STRING,
				EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, EMPTY_STRING, EMPTY_STRING,
				TEXT_EMAIL_SUBJECT, $html_mail, $txt_mail,$customers_email_type);
			}
		}
		else
		{
			$info_message = TEXT_WRONG_CODE;
		}
	}
	else
	{
		$activate =$action == 'activate';
		$remove =$action == 'remove';
		$sql_where.=" and mail_key = '" .	$key . APOS;
		$sql_from=SQL_FROM . TABLE_NEWSLETTER_RECIPIENTS . $sql_where;
		if ($activate || $remove)
		{
			$key=olc_db_input($_GET['key']);
			$check_mail_query = olc_db_query($sql_select.$sql_from);
			if (olc_db_num_rows($check_mail_query)) {
				$check_mail = olc_db_fetch_array($check_mail_query);
				$valid_entry=olc_validate_password($check_mail['customers_email_address'],$key);
				// Accountaktivierung per Emaillink
				if ($activate)
				{
					if ($valid_entry)
					{
						olc_db_query(SQL_UPDATE . TABLE_NEWSLETTER_RECIPIENTS . " set mail_status = '1'".$sql_where);
						$info_message = TEXT_EMAIL_ACTIVE;
					}else{
						$info_message = TEXT_EMAIL_ACTIVE_ERROR;
					}
				}
				// Accountdeaktivierung per Emaillink
				else
				{
					$info_message = TEXT_EMAIL_DEL;
					if ($valid_entry)
					{
						olc_db_query("delete".$sql_from);
					}
					elseif (!$force)
					{
						$info_message = TEXT_EMAIL_DEL_ERROR;
					}
				}
			}
			else
			{
				$info_message = TEXT_EMAIL_NOT_EXIST;
			}
		}
		elseif ($have_email)
		{
			$check_mail_query = olc_db_query($sql_select.$sql_from);
			if (olc_db_num_rows($check_mail_query))
			{
				$check_mail = olc_db_fetch_array($check_mail_query);
				$activate=$check_mail['mail_status'] == '1';
			}
			else
			{
				$activate=true;
			}
			$remove=!$activate;
		}
	}
}
else
{
	$info_message = ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
}
$breadcrumb->add(NAVBAR_TITLE_NEWSLETTER, olc_href_link(FILENAME_NEWSLETTER, EMPTY_STRING));
require(DIR_WS_INCLUDES . 'header.php');
$smarty->assign('info_message', $info_message);
if ($force)
{
	$smarty->assign('FORCE', true);
  $button_send=HTML_A_START.olc_href_link(FILENAME_DEFAULT).'">'.
  	olc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE).HTML_A_END;
}
else
{
	$smarty->assign('text_newsletter', TEXT_NEWSLETTER);
	$smarty->assign('FORM_ACTION', olc_draw_form('sign', olc_href_link(FILENAME_NEWSLETTER, 'action=process')));
	$smarty->assign('INPUT_EMAIL', olc_draw_input_field('email', $email,'size="30"'));
	$smarty->assign('INPUT_CODE', olc_draw_input_field('code'));
	$smarty->assign('CHECK_INP', olc_draw_radio_field('check', 'inp',$activate));
	$smarty->assign('CHECK_DEL', olc_draw_radio_field('check', 'del',$remove));
	$smarty->assign('VVIMG', '<img src="'.olc_href_link(FILENAME_DISPLAY_VVCODES).'" alt="Sicherheitscode" />');
	$button_send=olc_image_submit('button_send.gif', IMAGE_BUTTON_CONTINUE);
}
$smarty->assign('BUTTON_SEND', $button_send);
$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE.'newsletter'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>
