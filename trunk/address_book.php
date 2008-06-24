<?php
/* -----------------------------------------------------------------------------------------
$Id: address_book.php,v 1.1.1.1.2.1 2007/04/08 07:16:02 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(address_book.php,v 1.57 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (address_book.php,v 1.14 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include( 'includes/application_top.php');

// include needed functions
require_once(DIR_FS_INC.'olc_address_label.inc.php');
require_once(DIR_FS_INC.'olc_get_country_name.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');
require_once(DIR_FS_INC.'olc_count_customer_address_book_entries.inc.php');

if (!isset($_SESSION['customer_id'])) {
	olc_redirect(olc_href_link(FILENAME_LOGIN, EMPTY_STRING, SSL));
}
$breadcrumb->add(NAVBAR_TITLE_1_ADDRESS_BOOK, olc_href_link(FILENAME_ACCOUNT, EMPTY_STRING, SSL));
$breadcrumb->add(NAVBAR_TITLE_2_ADDRESS_BOOK, olc_href_link(FILENAME_ADDRESS_BOOK, EMPTY_STRING, SSL));
require(DIR_WS_INCLUDES . 'header.php');
if (is_object($messageStack))
{
	if ($messageStack->size('addressbook') > 0)
	{
		$smarty->assign('error',$messageStack->output('addressbook'));
	}
}
$smarty->assign('ADDRESS_DEFAULT',
olc_address_label($_SESSION['customer_id'], $_SESSION['customer_default_address_id'], true, BLANK, HTML_BR));
$addresses_data=array();
$addresses_query = olc_db_query("select address_book_id, entry_firstname as firstname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_suburb as suburb, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$_SESSION['customer_id'] . "' order by firstname, lastname");
$customer_default_address_id=$_SESSION['customer_default_address_id'];
while ($addresses = olc_db_fetch_array($addresses_query))
{
	$format_id = olc_get_address_format_id($addresses['country_id']);
	$address_book_id=$addresses['address_book_id'];
	$primary=$address_book_id == $customer_default_address_id;
	$addresses_data[]=array(
	'NAME'=> trim($addresses['firstname'] . BLANK . $addresses['lastname']),
	'BUTTON_EDIT'=>
		HTML_A_START .	olc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $address_book_id, SSL) . '">' .
		olc_image_button('small_edit.gif', SMALL_IMAGE_BUTTON_EDIT) . HTML_A_END,
	'BUTTON_DELETE'=>
		HTML_A_START . olc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' .
	$address_book_id, SSL) . '">' . olc_image_button('small_delete.gif', SMALL_IMAGE_BUTTON_DELETE) . HTML_A_END,
	'ADDRESS'=> olc_address_format($format_id, $addresses, true, BLANK, HTML_BR),
	'PRIMARY'=> $primary);
}
$smarty->assign('addresses_data',$addresses_data);

$smarty->assign('BUTTON_BACK',HTML_A_START . olc_href_link(FILENAME_ACCOUNT, EMPTY_STRING, SSL) . '">' .
olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END);
if (olc_count_customer_address_book_entries() < MAX_ADDRESS_BOOK_ENTRIES) {
	$smarty->assign('BUTTON_NEW',HTML_A_START .
	olc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, EMPTY_STRING, SSL) . '">' .
	olc_image_button('button_add_address.gif', IMAGE_BUTTON_ADD_ADDRESS) . HTML_A_END);
}

$smarty->assign('ADDRESS_COUNT',sprintf(TEXT_MAXIMUM_ENTRIES, MAX_ADDRESS_BOOK_ENTRIES));
$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'address_book'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>