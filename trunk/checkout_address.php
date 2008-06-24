<?php
/* -----------------------------------------------------------------------------------------
$Id: checkout_address.php,v 1.1.1.1.2.1 2007/04/08 07:16:09 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Common code for "checkout_payment_address.php" and "checkout_shipping_address.php"

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(checkout_shipping_address.php,v 1.14 2003/05/27); www.oscommerce.com
(c) 2003	    nextcommerce (checkout_shipping_address.php,v 1.14 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// if the customer is not logged on, redirect them to the login page
if (!CUSTOMER_ID)
{
	olc_redirect(olc_href_link(FILENAME_LOGIN, EMPTY_STRING, SSL));
}
// if there is nothing in the customers cart, redirect them to the shopping cart page
elseif (!$IsAccount)
{
	if ($_SESSION['cart']->count_contents() < 1)
	{
		olc_redirect(olc_href_link(FILENAME_SHOPPING_CART));
	}
}
define('SMARTY_TEMPLATE', 'checkout_new_address');


// include needed functions
$error = false;
$process = false;
$action=$_POST['action'];
$IsCheckout = true;
$IsUserModeEdit=true;
if ($action == 'submit' || $action == 'process' || $action == 'update')
{
	if ($IsAccount)
	{
		// process an account
		$process=true;
	}
	else
	{
		// process a new payment or shipping address
		$process=olc_not_null($_POST['customers_firstname']) && olc_not_null($_POST['customers_lastname']) &&
		olc_not_null($_POST['entry_street_address']);
	}
	if ($process)
	{
		//	W. Kaiser - Common code for account data handling
		include(DIR_FS_INC.'olc_get_check_customer_data.inc.php');
		//	W. Kaiser - Common code for account handling
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
			$_SESSION[$checkout_id_text] = olc_db_insert_id();
			if ($IsCheckout_payment)
			{
				unset($_SESSION[$checkout_session_text]);
			}
			olc_redirect(olc_href_link($redirect_link, EMPTY_STRING, SSL));
		}
	}
	else
	{
		$address_id=$_POST['address'];
		if ($address_id)
		{
			$checkout_id=$_SESSION[$checkout_id_text];
			if ($checkout_id == $address_id)
			{
				$doit=true;
			}
			else
			{
				$checkout_id = $address_id;
				$check_address_query = olc_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK .
				" where customers_id = '" .CUSTOMER_ID . "' and address_book_id = '" . $address_id . APOS);
				$check_address = olc_db_fetch_array($check_address_query);
				$doit=$check_address['total'] == '1';
			}
			if ($doit)
			{
				unset($_SESSION[$checkout_session_text]);
			} else {
				$checkout_id=0;
				unset($_SESSION[$checkout_id_text]);
			}
		} else {
			$checkout_id=$_SESSION['customer_default_address_id'];
		}
		if ($checkout_id)
		{
			$_SESSION[$checkout_id_text] = $checkout_id;
			olc_redirect(olc_href_link($redirect_link, EMPTY_STRING, SSL));
		}
	}
}
require(DIR_WS_INCLUDES . 'header.php');
//W. Kaiser - AJAX
require_once(DIR_FS_INC.'olc_address_label.inc.php');
require_once(DIR_FS_INC.'olc_count_customer_address_book_entries.inc.php');
$addresses_count = olc_count_customer_address_book_entries();
if ($IsAccount)
{
	if (isset($delete))
	{
		$smarty->assign('delete','1');
		$smarty->assign('ADDRESS',olc_address_label(CUSTOMER_ID, $delete, true, BLANK, HTML_BR));
		$smarty->assign('BUTTON_BACK',HTML_A_START . $address_book_link . '">' .
		olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END);
		$smarty->assign('BUTTON_DELETE',HTML_A_START . olc_href_link(FILENAME_ADDRESS_BOOK_PROCESS,
		'delete=' . $delete . '&action=deleteconfirm') . '">' .
		olc_image_button('button_delete.gif', IMAGE_BUTTON_DELETE) . HTML_A_END);
	} else {
		include(DIR_WS_MODULES . 'address_book_details.php');
		if ($isset_edit_and_is_numeric_edit)
		{
			$smarty->assign('BUTTON_BACK',HTML_A_START . $address_book_link . '">' .
			olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END);
			$smarty->assign('BUTTON_UPDATE',olc_draw_hidden_field('action', 'update') . olc_draw_hidden_field('edit', $edit) .
			olc_image_submit('button_update.gif', IMAGE_BUTTON_UPDATE));

		}
		else
		{
			if (sizeof($_SESSION['navigation']->snapshot) > 0)
			{
				$back_link = olc_href_link($_SESSION['navigation']->snapshot['page'],
				olc_array_to_string($_SESSION['navigation']->snapshot['get'], array(olc_session_name())),
				$_SESSION['navigation']->snapshot['mode']);
			} else {
				$back_link = $address_book_link;
			}
			$smarty->assign('BUTTON_BACK',HTML_A_START . $back_link . '">' .
			olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END);
			$smarty->assign('BUTTON_UPDATE',olc_draw_hidden_field('action', 'process') .
			olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
		}
	}
	$submit_routine_trailer='_new';
}
else
{
	// if no shipping destination address was selected, use their own address as default
	if (!isset($_SESSION[$checkout_id_text]))
	{
		$_SESSION[$checkout_id_text] = $_SESSION['customer_default_address_id'];
	}
	if (!$process)
	{
		require_once(DIR_FS_INC.'olc_draw_radio_field.inc.php');
		$checkout_id=$_SESSION[$checkout_id_text];
		$smarty->assign('ADDRESS_LABEL',olc_address_label(CUSTOMER_ID, $checkout_id, true, BLANK, HTML_BR));
		if ($addresses_count > 1)
		{
			$radio_buttons = 0;
			$addresses_query = olc_db_query("select address_book_id, entry_firstname as firstname, entry_lastname as lastname,
		entry_company as company, entry_street_address as street_address, entry_suburb as suburb, entry_city as city,
		entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from " .
			TABLE_ADDRESS_BOOK . " where customers_id = '" . CUSTOMER_ID . APOS);
			$address_content='
						<table border="0" width="100%" cellspacing="0" cellpadding="0">';
			while ($addresses = olc_db_fetch_array($addresses_query))
			{
				$format_id = olc_get_address_format_id($address['country_id']);
				$address_content.='
							<tr>
                <td width="10">&nbsp;</td>
                <td>
                	<table border="0" width="100%" cellspacing="0" cellpadding="2">
';
				$address_book_id=$addresses['address_book_id'];
				if ($address_book_id == $checkout_id)
				{
					$id=' id="defaultSelected"';
					$selected='Selected';
				} else {
					$id=EMPTY_STRING;
					$selected=EMPTY_STRING;
				}
				$address_content.= '
                	<tr'.$id.' class="moduleRow'.$selected.'" onmouseover="rowOverEffect(this)"
                		onmouseout="rowOutEffect(this)" onclick="javascript:selectRowEffect(this, ' . $radio_buttons . ')">
			                <td width="10">&nbsp;</td>
		                  <td class="main">'.
				olc_draw_radio_field('address', $address_book_id,$address_book_id == $checkout_id).'
		                  	<b>'. trim($addresses['firstname'] . BLANK . $addresses['lastname']).'</b>
											</td>
										</tr>
										<tr>
											<td width="10">&nbsp;</td>
											<td>
												<table border="0" cellspacing="0" cellpadding="2">
													<tr>
														<td width="10">&nbsp;</td>
														<td class="main">'.  olc_address_format($format_id, $addresses, true, BLANK, ', ').'</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>';
				$radio_buttons++;
			}
			$address_content.='
						</table>';
			$smarty->assign('BLOCK_ADDRESS',$address_content);
		}
	}
	/*
	if ($addresses_count < MAX_ADDRESS_BOOK_ENTRIES)
	{
		include(DIR_WS_MODULES . SMARTY_TEMPLATE.PHP);
	}
	*/
	$submit_routine_trailer='_optional';
	$smarty->assign('BUTTON_CONTINUE',olc_draw_hidden_field('action', 'submit') .
	olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
	if ($process)
	{
		$smarty->assign('BUTTON_BACK',HTML_A_START . olc_href_link($back_file, EMPTY_STRING, SSL) . '">' .
		olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END);
	}
}
$smarty->assign('FORM_ACTION',olc_draw_form(MESSAGE_STACK_NAME, olc_href_link(MESSAGE_STACK_NAME.PHP, EMPTY_STRING, SSL),
'post','onsubmit="return check_form'.$submit_routine_trailer.'(\''.MESSAGE_STACK_NAME.'\');"'));
//W. Kaiser - AJAX
if ($messageStack->size(MESSAGE_STACK_NAME) > 0)
{
	$smarty->assign('error',$messageStack->output(MESSAGE_STACK_NAME));
}
$main_content= $smarty->fetch(CURRENT_TEMPLATE_MODULE . MESSAGE_STACK_NAME. HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>