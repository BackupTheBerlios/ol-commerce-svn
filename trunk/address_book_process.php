<?php
/* -----------------------------------------------------------------------------------------
$Id: address_book_process.php,v 1.1.1.1.2.1 2007/04/08 07:16:03 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(address_book_process.php,v 1.77 2003/05/27); www.oscommerce.com
(c) 2003	    nextcommerce (address_book_process.php,v 1.13 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include( 'includes/application_top.php');

if (INT_CUSTOMER_ID==0)
{
	olc_redirect(olc_href_link(FILENAME_LOGIN));
}
// include needed functions
require_once(DIR_FS_INC.'olc_array_to_string.inc.php');
require_once(DIR_FS_INC.'olc_draw_radio_field.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');
require_once(DIR_FS_INC.'olc_count_customer_address_book_entries.inc.php');
require_once(DIR_FS_INC.'olc_address_label.inc.php');
require_once(DIR_FS_INC.'olc_get_country_name.inc.php');

$customers_id=" customers_id = '" . INT_CUSTOMER_ID . APOS;
$delete=$_GET['delete'];
$is_numeric_delete=is_numeric($delete);
$edit=$_GET['edit'];
if ($is_numeric_delete)
{
	$address_book_id=$delete;
}
else
{
	if (!$edit)
	{
		$edit=$_POST['edit'];
	}
	$address_book_id=$edit;
}
define('MESSAGE_STACK_NAME', 'address_book_process');
$address_book_id = " address_book_id = '" . $address_book_id . APOS;
$update_parameter=$address_book_id." and ".$customers_id;
$from_where_address_book_id_and_customers_id=" from " . TABLE_ADDRESS_BOOK ." where ".$update_parameter;
$address_book_link=olc_href_link(FILENAME_ADDRESS_BOOK);
if ($is_numeric_delete)
{
	if ($_GET['action'] == 'deleteconfirm')
	{
		olc_db_query("delete" . $from_where_address_book_id_and_customers_id);
		if (IS_AJAX_PROCESSING)
		{
			ajax_info(SUCCESS_ADDRESS_BOOK_ENTRY_DELETED);
		}
		else
		{
			$messageStack->add_session(MESSAGE_STACK_NAME, SUCCESS_ADDRESS_BOOK_ENTRY_DELETED, 'success');
			$action=EMPTY_STRING;
		}
		olc_redirect($address_book_link);
	}
}
// error checking when updating or adding an entry
$action=$_POST['action'];
$isset_edit_and_is_numeric_edit=isset($edit) && is_numeric($edit);
$process=false;
$is_update=$action == 'update';
if (($action == 'process') || $is_update)
{
	$process=true;
}
elseif ($isset_edit_and_is_numeric_edit)
{
	$entry_query = olc_db_query("select entry_gender, entry_company, entry_firstname, entry_lastname, entry_street_address,
	 entry_suburb, entry_postcode, entry_city, entry_state, entry_zone_id, entry_country_id" .
	$from_where_address_book_id_and_customers_id);
	if (olc_db_num_rows($entry_query) == 0)
	{
		if (IS_AJAX_PROCESSING)
		{
			ajax_info(ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY);
		}
		else
		{
			$messageStack->add_session(MESSAGE_STACK_NAME, ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY, 'success');
			$action=EMPTY_STRING;
		}
		olc_redirect($address_book_link);
	}
	else
	{
		$entry = olc_db_fetch_array($entry_query);
		require_once(DIR_WS_CLASSES.'object_info.php');
		$cInfo = new objectInfo($entry);
	}
}
elseif ($is_numeric_delete)
{
	if ($delete == $_SESSION['customer_default_address_id'])
	{
		if (IS_AJAX_PROCESSING)
		{
			ajax_info(WARNING_PRIMARY_ADDRESS_DELETION);
		}
		else
		{
			$messageStack->add_session(MESSAGE_STACK_NAME, WARNING_PRIMARY_ADDRESS_DELETION, 'success');
			$action=EMPTY_STRING;
		}
		olc_redirect($address_book_link);
	}
	else
	{
		$check_query = olc_db_query("select count(*) as total" . $from_where_address_book_id_and_customers_id);
		$check = olc_db_fetch_array($check_query);
		if ($check['total'] < 1)
		{
			if (IS_AJAX_PROCESSING)
			{
				ajax_info(ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY);
			}
			else
			{
				$messageStack->add_session(MESSAGE_STACK_NAME, ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY, 'success');
				$action=EMPTY_STRING;
			}
			olc_redirect($address_book_link);
		}
	}
}
elseif (!isset($edit))
{
	if (!isset($delete) )
	{
		if (olc_count_customer_address_book_entries() >= MAX_ADDRESS_BOOK_ENTRIES)
		{
			if (IS_AJAX_PROCESSING)
			{
				ajax_info(ERROR_ADDRESS_BOOK_FULL);
			}
			else
			{
				$messageStack->add_session(MESSAGE_STACK_NAME, ERROR_ADDRESS_BOOK_FULL, 'success');
				$action=EMPTY_STRING;
			}
			olc_redirect($address_book_link);
		}
	}
}
$IsAccount = true;
$redirect_link=FILENAME_ADDRESS_BOOK;
include(FILENAME_CHECKOUT_ADDRESS);
if ($process)
{
	$process=false;
	olc_redirect($address_book_link);
}
?>