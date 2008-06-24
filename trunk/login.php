<?php
/* -----------------------------------------------------------------------------------------
$Id: login.php,v 1.1.1.1.2.1 2007/04/08 07:16:16 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(login.php,v 1.79 2003/05/19); www.oscommerce.com
(c) 2003      nextcommerce (login.php,v 1.13 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:

guest account idea by Ingo T. <xIngox@web.de>
---------------------------------------------------------------------------------------*/

//Allow short-cut login
$not_forced_login=!defined('MAIN_CONTENT');
$ajax_init=IS_AJAX_PROCESSING;
if ($not_forced_login)
{
	include('includes/application_top.php');
}
// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
if (isset($_SESSION))
{
	//---PayPal WPP Modification START ---//
	//Assign a variable to cut down on database calls
	//Don't show checkout option if cart is empty.  It does not satisfy the paypal conditions
	if ($not_forced_login)
	{
		$ec_enabled=$_SESSION['cart']->count_contents() > 0;
		if (olc_paypal_wpp_enabled())
		{
			if ($ec_enabled)
			{
				//If they're here, they're either about to go to paypal or were sent back by an error,
				//so clear these session vars
				$paypal_ec='paypal_ec_';
				unset($_SESSION[$paypal_ec.'temp']);
				unset($_SESSION[$paypal_ec.'token']);
				unset($_SESSION[$paypal_ec.'payer_id']);
				unset($_SESSION[$paypal_ec.'payer_info']);
				//Find out if the user is logging in to checkout so that we know to draw the EC box
				$have_payment_error=isset($_GET['payment_error']);
				if (sizeof($navigation->snapshot) > 0 || $have_payment_error)
				{
					$checkout_login=strpos($navigation->snapshot['page'], 'checkout_') !== false || $have_payment_error;
				}
				else
				{
					$checkout_login = false;
				}
			}
			//---PayPal WPP Modification END---//
		}
	}
	$action=$_GET['action'];
	if ($action == 'process')
	{
		// W. Kaiser
		$email_address=$_POST['email_address'];
		$password =$_POST['password'];
		if ($email_address==EMPTY_STRING)
		{
			$email_address=$_GET['email_address'];
		}
		if ($password == EMPTY_STRING)
		{
			$password=$_GET['password'];
		}
		$email_address = olc_db_prepare_input($email_address);
		$password = olc_db_prepare_input($password);
		// W. Kaiser

		// Check if email exists
		//W. Kaiser - AJAX
		$check_customer_query = "
		select
    account_type,
		customers_id,
		customers_firstname,
		customers_lastname,
		customers_gender,
		customers_password,
		customers_email_address,
		customers_default_address_id
		from " . TABLE_CUSTOMERS . " where customers_email_address = '" . olc_db_input($email_address) . APOS;
		$check_customer_query = olc_db_query($check_customer_query);
		//W. Kaiser - AJAX
		if (olc_db_num_rows($check_customer_query)>0)
		{
			//W. Kaiser - AJAX
			// include needed functions
			require_once(DIR_FS_INC.'olc_array_to_string.inc.php');
			//W. Kaiser - AJAX
			$check_customer = olc_db_fetch_array($check_customer_query);
			// Check that password is good
			$password_stored= $check_customer['customers_password'];
			$is_auction=$_GET['auction'];
			if ($is_auction)
			{
				require_once(DIR_FS_INC.'olc_validate_password_enc.inc.php');
				$password_ok=olc_validate_password_enc($password, $password_stored);
			}
			else
			{
				require_once(DIR_FS_INC.'olc_validate_password.inc.php');
				$password_ok=olc_validate_password($password, $password_stored);
			}
			if ($password_ok)
			{
				/*
				if (SESSION_RECREATE == TRUE_STRING_L)
				{
					olc_session_recreate();
				}
				*/
				$check_country_query = olc_db_query(SELECT."entry_country_id, entry_zone_id from " .
				TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$check_customer['customers_id'] .
				"' and address_book_id = '" . $check_customer['customers_default_address_id'] . APOS);
				$check_country = olc_db_fetch_array($check_country_query);

				$_SESSION['customer_gender'] = $check_customer['customers_gender'];
				$_SESSION['customer_last_name'] = $check_customer['customers_lastname'];
				$_SESSION['customer_id'] = $check_customer['customers_id'];
				$_SESSION['customer_default_address_id'] = $check_customer['customers_default_address_id'];
				$_SESSION['customer_first_name'] = $check_customer['customers_firstname'];
				$_SESSION['customer_country_id'] = $check_country['entry_country_id'];
				$_SESSION['customer_zone_id'] = $check_country['entry_zone_id'];
				//W. Kaiser - AJAX
				$_SESSION['account_type']=$check_customer['account_type'];
				//W. Kaiser - AJAX
				$date_now = date('Ymd');
				olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS_INFO .
				" set
				customers_info_date_of_last_logon = now(),
				customers_info_number_of_logons = customers_info_number_of_logons+1
				where customers_info_id = '" . $_SESSION['customer_id'] . APOS);

				// restore cart contents
				define('CUSTOMER_ID', $_SESSION['customer_id']);
				if ($not_forced_login)
				{
					if (NOT_IS_ADMIN_FUNCTION)
					{
						$_SESSION['cart']->restore_contents();
					}
					$snapshot=$_SESSION['navigation']->snapshot;
					if (sizeof($snapshot) > 0)
					{
						$redirect_url = $snapshot['page'];
						$redirect_parameters=olc_array_to_string($snapshot['get'],array(olc_session_name()));
						$redirect_mode=$snapshot['mode'];
						$_SESSION['navigation']->clear_snapshot();
					}
					else
					{
						if($auction)
						{
							$redirect_url=FILENAME_SHOPPING_CART;
						}
						else
						{
							//normal login - redirect to user account
							$redirect_url=FILENAME_DEFAULT;
						}
					}
				}
				//W. Kaiser - AJAX
			}
			else
			{
				$_GET['login'] = 'fail';
				$info_message=TEXT_LOGIN_ERROR;
			}
		}
		else
		{
			$_GET['login'] = 'fail';
			$info_message=TEXT_NO_EMAIL_ADDRESS_FOUND;
		}
	}
}
else
{
	$redirect_url=FILENAME_COOKIE_USAGE;
}
unset($_GET['action']);
if (strlen($info_message)>0)
{
	if (IS_AJAX_PROCESSING)
	{
		//If Error reported, then show AJAX-type Message
		require_once(DIR_FS_INC.'ajax_error'.INC_PHP);
		$info_message=strip_tags($info_message);
		ajax_error($info_message) ;
	}
	else 
	{
		$redirect_url=EMPTY_STRING;
	}
}
// write customers status in session
require(DIR_WS_INCLUDES . 'write_customers_status.php');
/*
include_once(DIR_FS_INC.'olc_create_navigation_links.inc.php');
olc_create_navigation_links($ec_enabled,false);
*/
if (strlen($redirect_url)>0)
{
	if (USE_AJAX)
	{
		if (strpos($redirect_parameters,AJAX_ID)===false)
		{
			if (strlen($redirect_parameters)>0)
			{
				$redirect_parameters.=AMP;
			}
			$redirect_parameters.=AJAX_ID;
		}
	}
	olc_redirect(olc_href_link($redirect_url,$redirect_parameters,$redirect_mode));
	exit();
}
else if ($not_forced_login || CURRENT_SCRIPT==FILENAME_CHECKOUT_SHIPPING)
{
	//W. Kaiser - AJAX
	// include needed functions
	require_once(DIR_FS_INC.'olc_draw_password_field.inc.php');
	require_once(DIR_FS_INC.'olc_image_button.inc.php');
	if (NOT_IS_AJAX_PROCESSING)
	{

	}
	//---PayPal WPP Modification START ---//
	if ($ec_enabled)
	{
		if ($_SESSION['paypal_error'])
		{
			$checkout_login = true;
			$messageStack->add('login', $paypal_error);
			unset($_SESSION['paypal_error']);
		}
	}
	//---PayPal WPP Modification END ---//

	$breadcrumb->add(NAVBAR_TITLE_LOGIN, olc_href_link(FILENAME_LOGIN));
	require(DIR_WS_INCLUDES . 'header.php');
	if ($_GET['info_message']) $info_message=$_GET['info_message'];
	$smarty->assign('info_message',$info_message);
	$smarty->assign('account_option',ACCOUNT_OPTIONS);
	$smarty->assign('BUTTON_NEW_ACCOUNT',HTML_A_START . olc_href_link(FILENAME_CREATE_ACCOUNT) . '">' .
	olc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . HTML_A_END);
	$smarty->assign('BUTTON_LOGIN',olc_image_submit('button_login.gif', IMAGE_BUTTON_LOGIN));
	//---PayPal WPP Modification START ---//
	if ($checkout_login)
	{
		$smarty->assign('BUTTON_EC_CHECKOUT_TEXT',TEXT_PAYPALWPP_EC_HEADER);
		$smarty->assign('BUTTON_EC_CHECKOUT',HTML_A_START.olc_href_link(FILENAME_EC_PROCESS,EMPTY_STRING,SSL).'">'.
		'<img border="0" src="'.MODULE_PAYMENT_PAYPAL_EC_BUTTON_URL.'" title="'.
		TEXT_PAYPALWPP_EC_BUTTON_TEXT . '">'.HTML_A_END);
	}
	//---PayPal WPP Modification END ---//

	$smarty->assign('BUTTON_GUEST',HTML_A_START . olc_href_link(FILENAME_CREATE_GUEST_ACCOUNT) . '">' .
	olc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . HTML_A_END);
	//W. Kaiser - AJAX
	$smarty->assign('FORM_ACTION',olc_draw_form('login',olc_href_link(FILENAME_LOGIN, 'action=process')));
	//W. Kaiser - AJAX
	$smarty->assign('INPUT_MAIL',olc_draw_input_field('email_address',EMPTY_STRING,'maxlength="96" size="35"'));
	$smarty->assign('INPUT_PASSWORD',olc_draw_password_field('password',EMPTY_STRING,'maxlength="30" size="35"'));
	$smarty->assign('LINK_LOST_PASSWORD',olc_href_link(FILENAME_PASSWORD_FORGOTTEN));
	$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'login'.HTML_EXT,SMARTY_CACHE_ID);
	$smarty->assign(MAIN_CONTENT,$main_content);
	$omit_login_box=USE_AJAX;
	//W. Kaiser - AJAX
    if (!isset($order_step))
	{
        require(BOXES);
    }
	$smarty->display(INDEX_HTML);
}
?>