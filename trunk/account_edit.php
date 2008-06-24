<?php
/* -----------------------------------------------------------------------------------------
$Id: account_edit.php,v 1.1.1.1.2.1 2007/04/08 07:16:02 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(account_edit.php,v 1.63 2003/05/19); www.oscommerce.com
(c) 2003	    nextcommerce (account_edit.php,v 1.14 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include( 'includes/application_top.php');
if (!ISSET_CUSTOMER_ID)
{
	olc_redirect(olc_href_link(FILENAME_LOGIN, EMPTY_STRING));
}

$IsUserMode = true;
$IsEditAccount = true;
define('MESSAGE_STACK_NAME', 'create_account');
define('SMARTY_TEMPLATE', MESSAGE_STACK_NAME) ;
$process = $_POST['action'] == 'process';
if ($process)
{
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
	include(DIR_FS_INC.'olc_get_check_customer_data.inc.php');
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
		$messageStack->add_session('account', SUCCESS_ACCOUNT_UPDATED, 'success');
		olc_redirect(olc_href_link(FILENAME_ACCOUNT,EMPTY_STRING,EMPTY_STRING,true,true,true));
	}
}
else
{
	$account_query =SELECT."
		c.customers_gender,
		c.customers_status,
		c.member_flag,
		c.customers_firstname,
		c.customers_cid,
		c.customers_lastname,
		c.customers_dob,
		c.customers_email_address,
		c.customers_email_type,
		a.entry_company,
		a.entry_street_address,
		a.entry_suburb,
		a.entry_postcode,
		a.entry_city,
		a.entry_state,
		a.entry_zone_id,
		a.entry_country_id,
		c.customers_telephone,
		c.customers_fax,
		c.customers_newsletter,
		c.customers_default_address_id
		from " .
	TABLE_CUSTOMERS . " c left join " . TABLE_ADDRESS_BOOK ." a on c.customers_default_address_id = a.address_book_id
		where
		a.customers_id = c.customers_id and c.customers_id = '" . CUSTOMER_ID . APOS;
	$account_query = olc_db_query($account_query);
	$account = olc_db_fetch_array($account_query);
	require_once(DIR_WS_CLASSES.'object_info.php');
	$cInfo = new objectInfo($account);
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
	include(DIR_FS_INC.'olc_show_customer_data_form.inc.php');
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
}
?>