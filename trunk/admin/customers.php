<?php
/* --------------------------------------------------------------
$Id: customers.php,v 1.1.1.1.2.1 2007/04/08 07:16:27 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(customers.php,v 1.76 2003/05/04); www.oscommerce.com
(c) 2003	    nextcommerce (customers.php,v 1.22 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contribution:
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

Released under the GNU General Public License
--------------------------------------------------------------*/

require_once('includes/application_top.php');
//	W. Kaiser - eMail-type by customer
define('MESSAGE_STACK_NAME', 'customers');
$customers_statuses_array = olc_get_customers_statuses();
$cId = (int)$_GET['cID'];
if ($_GET['special'] == 'remove_memo')
{
	$mID = olc_db_prepare_input($_GET['mID']);
	olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_MEMO . " WHERE memo_id = '". $mID . APOS);
	olc_redirect(olc_href_link(FILENAME_CUSTOMERS, 'cID=' . $cId . '&action=edit'));
}
$action = $_GET['action'];
$is_update = $action == 'update';
if ($is_update )
{
	$IsEditOrUpdate = true;
}
else
{
	$IsEditOrUpdate = $action == 'edit';
	/*
	if ($action != 'deleteconfirm')
	{
		include(DIR_WS_INCLUDES . 'html_head.php');
	}
	*/
}
$cid_db = olc_db_input($cId);
$customers_id = olc_db_prepare_input($cId);

//	W. Kaiser - eMail-type by customer
$Have_cInfo = false;
$customers_query_text = SELECT."c.customers_gender,c.customers_status, c.member_flag, c.customers_firstname,
c.customers_cid, c.customers_lastname, c.customers_dob, c.customers_email_address, c.customers_email_type,
a.entry_company, a.entry_street_address, a.entry_suburb, a.entry_postcode, a.entry_city, a.entry_state, a.entry_zone_id,
a.entry_country_id, c.customers_telephone, c.customers_fax, c.customers_newsletter, c.customers_default_address_id from " .
TABLE_CUSTOMERS . " c left join " . TABLE_ADDRESS_BOOK .
" a on c.customers_default_address_id = a.address_book_id where a.customers_id = c.customers_id and c.customers_id = '" .
$cId . APOS;
$from_table_zones = " from " . TABLE_ZONES . " where zone_country_id = '";
//	W. Kaiser - eMail-type by customer
if ($action)
{
	switch ($action)
	{
		case 'statusconfirm':
		$customer_updated = false;
		$check_status_query = olc_db_query(SELECT."customers_firstname, customers_lastname, customers_email_address ,
		 customers_status, member_flag from " . TABLE_CUSTOMERS . " where customers_id = '" . $cId_db . APOS);
		$check_status = olc_db_fetch_array($check_status_query);
		if ($check_status['customers_status'] != $status) {
			olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS . " set customers_status = '" . olc_db_input($_POST['status']) .
			"' where customers_id = '" . $cId_db . APOS);

			// create insert for admin access table if customers status is set to 0
			if ($_POST['status']==0) {
				olc_db_query(INSERT_INTO.TABLE_ADMIN_ACCESS." (customers_id,start) VALUES ('".$cId_db."','1')");
			} else {
				olc_db_query(DELETE_FROM.TABLE_ADMIN_ACCESS." WHERE customers_id = '".$cId_db.APOS);

			}
			//Temporarily set due to above commented lines
			$customer_notified = '0';
			olc_db_query(INSERT_INTO . TABLE_CUSTOMERS_STATUS_HISTORY .
			" (customers_id, new_value, old_value, date_added, customer_notified) values ('" . $cId_db . "', '" .
			olc_db_input($_POST['status']) . "', '" . $check_status['customers_status'] . "', now(), '" . $customer_notified . "')");
			$customer_updated = true;
		}
		break;

		case 'update':
		//	W. Kaiser - Common code for "create_account.php" and "customers.php"
		$IsCreateAccount = false;
		include(DIR_FS_INC.'olc_get_check_customer_data.inc.php');
		//	W. Kaiser - Common code for "create_account.php" and "customers.php"
		if (!$error)
		{
			olc_redirect(olc_href_link(FILENAME_CUSTOMERS, olc_get_all_get_params(array('cID', 'action')) .
			'cID=' . $customers_id));
		}
		break;

		case 'deleteconfirm':

		$customers_id_db = " = '" . olc_db_input($customers_id) . APOS;

		$where_customers_id = " where customers_id" . $customers_id_db;
		$where_customers_id_1 = " where customer_id" . $customers_id_db;

		if ($_POST['delete_reviews'] == 'on')
		{
			$reviews_query = olc_db_query(SELECT."reviews_id from " . TABLE_REVIEWS . $where_customers_id);
			while ($reviews = olc_db_fetch_array($reviews_query)) {
				olc_db_query(DELETE_FROM . TABLE_REVIEWS_DESCRIPTION . " where reviews_id = '" . $reviews['reviews_id'] . APOS);
			}
			olc_db_query(DELETE_FROM . TABLE_REVIEWS . $where_customers_id);
		} else {
			olc_db_query(SQL_UPDATE . TABLE_REVIEWS . " set customers_id = null" . $where_customers_id);
		}
		olc_db_query(DELETE_FROM . TABLE_ADDRESS_BOOK . $where_customers_id);
		olc_db_query(DELETE_FROM . TABLE_CUSTOMERS . $where_customers_id);
		olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_INFO . " where customers_info_id" . $customers_id_db);
		olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET . $where_customers_id);
		olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . $where_customers_id);
		olc_db_query(DELETE_FROM . TABLE_PRODUCTS_NOTIFICATIONS . $where_customers_id);
		olc_db_query(DELETE_FROM . TABLE_WHOS_ONLINE . $where_customers_id_1);
		olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_STATUS_HISTORY . $where_customers_id);
		olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_IP . $where_customers_id);
		olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET_SAVE_BASKETS . $where_customers_id);
		olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET_SAVE . $where_customers_id);
		olc_db_query(DELETE_FROM . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . $where_customers_id);

		olc_redirect(olc_href_link(FILENAME_CUSTOMERS, olc_get_all_get_params(array('cID', 'action'))));
		break;

		default:
		//		$customers_query = olc_db_query(SELECT."c.customers_id,c.customers_cid, c.customers_gender, c.customers_firstname, c.customers_lastname, c.customers_dob, c.customers_email_address, a.entry_company, a.entry_street_address, a.entry_suburb, a.entry_postcode, a.entry_city, a.entry_state, a.entry_zone_id, a.entry_country_id, c.customers_telephone, c.customers_fax, c.customers_newsletter, c.customers_default_address_id from " . TABLE_CUSTOMERS . " c left join " . TABLE_ADDRESS_BOOK . " a on c.customers_default_address_id = a.address_book_id where a.customers_id = c.customers_id and c.customers_id = '" . $cId . APOS);
		//	W. Kaiser - eMail-type by customer
		$Have_cInfo=true;		//The same query will be done later again! Show that we already have the data.
		$customers_query = olc_db_query($customers_query_text);
		$customers = olc_db_fetch_array($customers_query);
		if (is_null($customers['customers_email_type']))
		{
			$customers['customers_email_type'] = EMAIL_USE_HTML;
		}
		$customers_email_address = $customers['customers_email_address'];
		$customers_email_type = $customers['customers_email_type'];

		$check_query = olc_db_query(SELECT."count(*) as total" . $from_table_zones .
			olc_db_input($customers['entry_country_id']) . APOS);
		$check_value = olc_db_fetch_array($check_query);
		$entry_state_has_zones = ($check_value['total'] > 0);
		//	W. Kaiser - eMail-type by customer

		$cInfo = new objectInfo($customers);
	}
}

// W. Kaiser Check address validity
if ($IsEditOrUpdate)
{
	$entry_country_id = $customers['entry_country_id'];
	if ($entry_country_id == 81) 		//Country is Germany?
	{
		if ($_GET['validate'] != EMPTY_STRING)
		{
			$entry_name = $customers['customers_lastname'];
			$entry_firstname = $customers['customers_firstname'];
			$entry_postcode = $customers['entry_postcode'];
			$entry_city = $customers['entry_city'];
			$entry_street_address = $customers['entry_street_address'];
			$entry_fon= $customers['customers_telephone'];
			$entry_fax= $customers['customers_fax'];
			$IsUserMode = false;
			IsValidAddress($entry_country_id, $entry_postcode, $entry_city, $entry_street_address, $entry_name,
			$entry_firstname,$entry_fon, $entry_fax, $entry_message);
			$entry_street_address_error = check_input_error(true, $entry_message);
			$entry_post_code_error = true;
			$entry_city_error =  true;
			if ($messageStack->size > 0)
			{
				$message_text = $messageStack->output();
				echo $message_text;
			}
		}
	}
}
// W. Kaiser Check address validity
require_once(DIR_WS_INCLUDES . 'header.php');
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
<tr>
<?php require_once(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- body_text //-->
<td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
if ($IsEditOrUpdate) {
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
	include(DIR_WS_INCLUDES . 'check_form.js.php');
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
	//	W. Kaiser - eMail-type by customer
	if (!$Have_cInfo) 		//Avoid duplicate db-query!
	{
		$customers_query = olc_db_query($customers_query_text);
		$customers = olc_db_fetch_array($customers_query);

		if (is_null($customers['customers_email_type']))
		{
			$customers['customers_email_type'] = EMAIL_USE_HTML;
		}
		$customers_email_address = $customers['customers_email_address'];
		$customers_email_type = $customers['customers_email_type'];

		$check_query = olc_db_query(SELECT."count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" .
		olc_db_input($entry_country_id) . APOS);
		$check_value = olc_db_fetch_array($check_query);
		$entry_state_has_zones = ($check_value['total'] > 0);

		$cInfo = new objectInfo($customers);
	}
	//	W. Kaiser - eMail-type by customer
	$newsletter_array = array(array('id' => '1', 'text' => ENTRY_NEWSLETTER_YES),
	array('id' => '0', 'text' => ENTRY_NEWSLETTER_NO));
	?>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="pageHeading" colspan="2">
						<?php
							define('AJAX_TITLE',BOX_CONFIGURATION_5.' -- '.TEXT_CUSTOMERS.
								$cInfo->customers_lastname.', '.$cInfo->customers_firstname);
							echo olc_image(DIR_WS_ICONS.'heading_customers.gif').HTML_NBSP.AJAX_TITLE;
						 ?>
					</td>
				</tr>
				<tr>
					<td class="main" valign="top">OLC Kunden</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td valign="middle" class="main">
						<?php
						$img = $customers_statuses_array[$customers['customers_status']]['csa_image'];
						if ($img  != EMPTY_STRING)
						{
							echo olc_image(DIR_WS_ICONS . $img, EMPTY_STRING, EMPTY_STRING, EMPTY_STRING,
							'align="middle" valign="middle"')  . HTML_NBSP;
						}
						define('AJAX_TITLE',HEADING_TITLE_STATUS  .': ' .
							$customers_statuses_array[$customers['customers_status']]['text'] );
						echo AJAX_TITLE;
						?>
					</td>
					<td class="main">&nbsp;</td>
				</tr>
				<?php
				// W. Kaiser Check address validity
				if ($entry_country_id == '81')
				{
					if ($action == 'edit')
					{
						echo '
							<tr>
								<td valign="middle" align="left" class="main">
									<br/>'.HTML_A_START . olc_href_link(FILENAME_CUSTOMERS,
										olc_get_all_get_params(array("validate")) . 'validate=1') .'">' .
										olc_image_button('button_validate_address.gif', 'Adresse über das Internet validieren')	. '</a>
								</td>
								<td class="main">&nbsp;</td>
							</tr>';
					}
				}
				// W. Kaiser Check address validity
				?>
			</table>
		</td>
	</tr>
	<?php
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
	include(DIR_FS_INC.'olc_show_customer_data_form.inc.php');
	//	W. Kaiser - Common code for "create_account.php" and "customers.php"
	?>
	<?php
} else {
	?>
	<tr>
	<td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td width="80" rowspan="2"><?php echo olc_image(DIR_WS_ICONS.'heading_customers.gif'); ?></td>
	<td class="pageHeading">
		<?php echo HEADING_TITLE; ?>
	</td>
	</tr>
	<tr>
	<td class="main" valign="top">OLC Kunden</td>
	</tr>
	</table>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td class="pageHeading" align="left">&nbsp;
				<?php echo HTML_A_START . olc_href_link(FILENAME_CREATE_ACCOUNT) . '">' .
					olc_image_button('create_account.gif', CREATE_ACCOUNT) . HTML_A_END; ?>
			</td>
			<td class="smallText" align="middle">
				<?php
				echo olc_draw_form('status', FILENAME_CUSTOMERS, EMPTY_STRING, 'get');
				$select_data=array();
				$select_data=array(array('id' => '99', 'text' => TEXT_SELECT),
				array('id' => '100', 'text' => TEXT_ALL_CUSTOMERS));
				echo HEADING_TITLE_STATUS . BLANK .
				olc_draw_pull_down_menu('status',olc_array_merge($select_data, $customers_statuses_array), '99',
				'onchange="this.form.submit();"').olc_draw_hidden_field(olc_session_name(), olc_session_id());
			 	?>
				</form>
			</td>
			<td class="smallText" align="right">
				<?php
				echo olc_draw_form('search', FILENAME_CUSTOMERS, EMPTY_STRING, 'get');
				echo HEADING_TITLE_SEARCH . BLANK . olc_draw_input_field('search') .
				olc_draw_hidden_field(olc_session_name(), olc_session_id()) .
				HTML_NBSP . '<input type="image" class="image" src="'.ADMIN_PATH_PREFIX . CURRENT_TEMPLATE_BUTTONS .
					'button_quick_find.gif'.'" style="border:0px" title="'.IMAGE_BUTTON_SEARCH.'">'.HTML_NBSP;
				?>
				</form>
			</td>
		</tr>
	</table>

	</td>
	</tr>
	<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
	<td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr class="dataTableHeadingRow">
	<td class="dataTableHeadingContent" width="1"><?php echo TABLE_HEADING_ACCOUNT_TYPE; ?></td>
	<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LASTNAME; ?></td>
	<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FIRSTNAME; ?></td>
	<td class="dataTableHeadingContent" align="left"><?php echo HEADING_TITLE_STATUS; ?></td>
	<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACCOUNT_CREATED; ?></td>
	<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
	</tr>
	<?php
	$search = EMPTY_STRING;
	if ( ($_GET['search']) && (olc_not_null($_GET['search'])) ) {
		$keywords = olc_db_input(olc_db_prepare_input($_GET['search']));
		$search = " where c.customers_lastname like '%" . $keywords . "%' or c.customers_firstname like '%" . $keywords . "%' or c.customers_email_address like '%" . $keywords . "%'";
	}

	if ($_GET['status'] && $_GET['status']!='100' or $_GET['status']=='0') {
		$status = olc_db_prepare_input($_GET['status']);
		//  echo $status;
		$search =" where c.customers_status = '". $status . APOS;
	}
	$customers_query_raw = SELECT."c.account_type,c.customers_id, c.customers_lastname, c.customers_firstname, c.customers_email_address, a.entry_country_id, c.customers_status, c.member_flag from " . TABLE_CUSTOMERS . " c left join " . TABLE_ADDRESS_BOOK . " a on c.customers_id = a.customers_id and c.customers_default_address_id = a.address_book_id " . $search . " order by c.customers_lastname, c.customers_firstname";

	$customers_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $customers_query_raw, $customers_query_numrows);
	$customers_query = olc_db_query($customers_query_raw);
	while ($customers = olc_db_fetch_array($customers_query)) {
		$info_query = olc_db_query(SELECT."customers_info_date_account_created as date_account_created, customers_info_date_account_last_modified as date_account_last_modified, customers_info_date_of_last_logon as date_last_logon, customers_info_number_of_logons as number_of_logons from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . $customers['customers_id'] . APOS);
		$info = olc_db_fetch_array($info_query);

		if (((!$cId) || (@$cId == $customers['customers_id'])) && (!$cInfo)) {
			$country_query = olc_db_query(SELECT."countries_name from " . TABLE_COUNTRIES . " where countries_id = '" . $customers['entry_country_id'] . APOS);
			$country = olc_db_fetch_array($country_query);

			$reviews_query = olc_db_query(SELECT."count(*) as number_of_reviews from " . TABLE_REVIEWS . " where customers_id = '" . $customers['customers_id'] . APOS);
			$reviews = olc_db_fetch_array($reviews_query);

			$customer_info = olc_array_merge($country, $info, $reviews);

			$cInfo_array = olc_array_merge($customers, $customer_info);
			$cInfo = new objectInfo($cInfo_array);
		}

		$tr_classname ='dataTableRow';
		$td_classname='dataTableContent';
		if ((is_object($cInfo)) && ($customers['customers_id'] == $cInfo->customers_id) ) {
			$params = $cInfo->customers_id . '&action=edit';
			$tr_classname .='Selected';
			$td_classname .='Selected';
			$linktext = olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', EMPTY_STRING);
		} else {
			$params = $customers['customers_id'];
			$linktext = HTML_A_START .
			olc_href_link(FILENAME_CUSTOMERS, olc_get_all_get_params(array('cID')) .
			'cID=' . $customers['customers_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END;
		}
		$display_text = '<tr class="' . $tr_classname . '" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' .
		olc_onclick_link(FILENAME_CUSTOMERS, olc_get_all_get_params(array('cID', 'action')) . 'cID=' . $params).
		'">' . NEW_LINE;

		$COL_START = '<td class="' . $td_classname . '">';
		$COL_END = '</td>';
		$display_text =$display_text . $COL_START;
		if ($customers['account_type']==1) {
			$display_text .= TEXT_GUEST;
		} else {
			$display_text .= TEXT_ACCOUNT;
		}
		$display_text .=
		$COL_START . $customers['customers_lastname'] . $COL_END .
		$COL_START . $customers['customers_firstname'] . $COL_END .
		$COL_START . $customers_statuses_array[$customers['customers_status']]['text'] .
		LPAREN . $customers['customers_status'] . RPAREN . $COL_END .
		$COL_START . olc_date_short($info['date_account_created']) . $COL_END .
		'<td class="' .$td_classname. '" align="right">' . $linktext . '&nbsp;</td>';
		echo $display_text;
		?>
		</tr>
		<?php
	}
	?>
	<tr>
	<td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
	<td class="smallText" valign="top"><?php echo $customers_split->display_count($customers_query_numrows,
	MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CUSTOMERS); ?></td>
	<td class="smallText" align="right"><?php echo $customers_split->display_links($customers_query_numrows,
	MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'],
	olc_get_all_get_params(array('page', 'info', 'x', 'y', 'cID'))); ?></td>
	</tr>
	<?php
	if (olc_not_null($_GET['search'])) {
		?>
		<tr>
		<td align="right" colspan="2"><?php echo HTML_A_START . olc_href_link(FILENAME_CUSTOMERS) . '">' .
			olc_image_button('button_reset.gif', IMAGE_RESET) . HTML_A_END; ?></td>
		</tr>
		<?php
	}
	?>
	</table></td>
	</tr>
	</table></td>
	<?php
	$heading = array();
	$contents = array();
	switch ($action) {
		case 'confirm':
		if ($cInfo->customers_id)
		{
			$cid_db =$cInfo->customers_id;
		}
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_DELETE_CUSTOMER . HTML_B_END);
		$contents = array('form' => olc_draw_form('customers', FILENAME_CUSTOMERS, olc_get_all_get_params(array('cID', 'action')) .
		'cID=' . $cid_db . '&action=deleteconfirm'));
		$contents[] = array('text' => TEXT_DELETE_INTRO . '<br/><br/><b>' . $cInfo->customers_firstname . BLANK .
		$cInfo->customers_lastname . HTML_B_END);
		if ($cInfo->number_of_reviews > 0) $contents[] = array('text' => HTML_BR .
		olc_draw_checkbox_field('delete_reviews', 'on', true) . BLANK . sprintf(TEXT_DELETE_REVIEWS, $cInfo->number_of_reviews));
		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) . BLANK .
		HTML_A_START . olc_href_link(FILENAME_CUSTOMERS, olc_get_all_get_params(array('cID', 'action')) .
		'cID=' . $cInfo->customers_id) . '">' .
		olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;

		case 'editstatus':
		if ($cId != 1)
		{
			$customers_history_query = olc_db_query(SELECT."new_value, old_value, date_added, customer_notified from " .
			TABLE_CUSTOMERS_STATUS_HISTORY . " where customers_id = '" . $cId_db . "' order by customers_status_history_id desc");
			$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_STATUS_CUSTOMER . HTML_B_END);
			$contents = array('form' => olc_draw_form('customers', FILENAME_CUSTOMERS,
			olc_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=statusconfirm'));
			$contents[] = array('text' => HTML_BR .
			olc_draw_pull_down_menu('status', $customers_statuses_array, $cInfo->customers_status) );
			$contents[] = array('text' =>
			'
				<table nowrap="nowrap" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="border-bottom: 1px solid; border-color: #000000;" nowrap="nowrap" class="smallText" align="center">
						<b>' . TABLE_HEADING_NEW_VALUE .'</b>
					</td>
					<td style="border-bottom: 1px solid; border-color: #000000;" nowrap="nowrap" class="smallText" align="center">
						<b>' . TABLE_HEADING_DATE_ADDED . '</b>
					</td>
			</tr>
			');

			if (olc_db_num_rows($customers_history_query)) {
				while ($customers_history = olc_db_fetch_array($customers_history_query)) {

					$contents[] = array('text' => '<tr>' . NEW_LINE . '<td class="smallText">' .
					$customers_statuses_array[$customers_history['new_value']]['text'] . '</td>' . NEW_LINE .
					'<td class="smallText" align="center">' . olc_datetime_short($customers_history['date_added']) .
					'</td>' . NEW_LINE .'<td class="smallText" align="center">');
					$contents[] = array('text' => '</tr>' . NEW_LINE);
				}
			} else {
				$contents[] = array('text' => '<tr>' . NEW_LINE .
				' <td class="smallText" colspan="2">' . TEXT_NO_CUSTOMER_HISTORY . '</td>' . NEW_LINE . ' </tr>' . NEW_LINE);
			}
			$contents[] = array('text' => '</table>');
			$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_update.gif', IMAGE_UPDATE) . BLANK.
			HTML_A_START . olc_href_link(FILENAME_CUSTOMERS, olc_get_all_get_params(array('cID', 'action')) .
			'cID=' . $cInfo->customers_id) . '">' .
			olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
			$status = olc_db_prepare_input($_POST['status']);    // maybe this line not needed to recheck...
		}
		break;

		default:
		$customer_status = olc_get_customer_status ($cId);
		$cs_id = $customer_status['customers_status'];
		$cs_member_flag  = $customer_status['member_flag'];
		$cs_name = $customer_status['customers_status_name'];
		$cs_image = $customer_status['customers_status_image'];
		$cs_discount = $customer_status['customers_status_discount'];
		$cs_ot_discount_flag  = $customer_status['customers_status_ot_discount_flag'];
		$cs_ot_discount = $customer_status['customers_status_ot_discount'];
		$cs_staffelpreise = $customer_status['customers_status_staffelpreise'];
		$cs_payment_unallowed = $customer_status['customers_status_payment_unallowed'];

		//      echo 'customer_status ' . $cID . 'variables = ' . $cs_id . $cs_member_flag . $cs_name .  $cs_discount .  $cs_image . $cs_ot_discount;

		if (is_object($cInfo))
		{
			$heading[] = array('text' => HTML_B_START . $cInfo->customers_firstname . BLANK . $cInfo->customers_lastname . HTML_B_END);
			$customers_id=$cInfo->customers_id;
			$params=olc_get_all_get_params(array('cID', 'action')) . 'cID=' . $customers_id . '&action=';
			$is_admin=$customers_id == 1;
			if (!$is_admin || CUSTOMER_ID == 1)
			{
				$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_CUSTOMERS,$params.'edit') . '">' .
				olc_image_button('button_edit.gif', IMAGE_EDIT) . HTML_A_END);
			}
			if (true || $cs_id != 0) {
				$contents[] = array('align' => 'center', 'text' => HTML_A_START .
				olc_href_link(FILENAME_CUSTOMERS,$params.'confirm') . '">' .
				olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
			}
			if (!$is_admin  /*&& $_SESSION['customer_id'] == 1*/) {
				$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_CUSTOMERS,
				$params.'editstatus') . '">' .
				olc_image_button('button_status.gif', IMAGE_STATUS) . HTML_A_END);
				// elari cs v3.x changed for added accounting module
				$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_ACCOUNTING,$params) . '">' .
				olc_image_button('button_accounting.gif', IMAGE_ACCOUNTING) . HTML_A_END);
			}
			// elari cs v3.x changed for added iplog module
			$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_ORDERS,$params) . '">' .
			olc_image_button('button_orders.gif', IMAGE_ORDERS) . HTML_A_END.BLANK.
			HTML_A_START . olc_href_link(FILENAME_MAIL, 'selected_box=tools&customer=' . $cInfo->customers_email_address) . '">' .
			olc_image_button('button_email.gif', IMAGE_EMAIL) . '</a><br/><a href="' . olc_href_link(FILENAME_CUSTOMERS,
			$params.'iplog') . '">' .
			olc_image_button('button_iplog.gif', IMAGE_IPLOG) . HTML_A_END);

			$contents[] = array('text' => HTML_BR . TEXT_DATE_ACCOUNT_CREATED . BLANK . olc_date_short($cInfo->date_account_created));
			$contents[] = array('text' => HTML_BR . TEXT_DATE_ACCOUNT_LAST_MODIFIED . BLANK .
			olc_date_short($cInfo->date_account_last_modified));
			$contents[] = array('text' => HTML_BR . TEXT_INFO_DATE_LAST_LOGON . BLANK  . olc_date_short($cInfo->date_last_logon));
			$contents[] = array('text' => HTML_BR . TEXT_INFO_NUMBER_OF_LOGONS . BLANK . $cInfo->number_of_logons);
			$contents[] = array('text' => HTML_BR . TEXT_INFO_COUNTRY . BLANK . $cInfo->countries_name);
			$contents[] = array('text' => HTML_BR . TEXT_INFO_NUMBER_OF_REVIEWS . BLANK . $cInfo->number_of_reviews);
		}

		if ($action=='iplog')
		{
			$contents[] = array('text' => '<br/><b>IPLOG :' );
			$customers_log_info_array = olc_get_user_info($customers_id);
			if (olc_db_num_rows($customers_log_info_array)) {
				while ($customers_log_info = olc_db_fetch_array($customers_log_info_array)) {
					$contents[] = array('text' => '<tr>' . NEW_LINE . '<td class="smallText">' . $customers_log_info['customers_ip_date'] .
					BLANK . $customers_log_info['customers_ip']);
				}
			}
		}
		break;
	}

	if ( (olc_not_null($heading)) && (olc_not_null($contents)) ) {
		echo '            <td width="25%" valign="top">' . NEW_LINE;

		$box = new box;
		echo $box->infoBox($heading, $contents);

		echo '            </td>' . NEW_LINE;
	}
	?>
	</tr>
	</table></td>
	</tr>
	<?php
}
?>
</table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
