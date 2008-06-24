<?php
/*
$Id: coupon_admin.php,v 1.1.1.1.2.1 2007/04/08 07:16:26 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com
Copyright (c) 2003 osCommerce

(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
*/

require('includes/application_top.php');
require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'class.phpmailer.php');
require_once(DIR_FS_INC.'olc_php_mail.inc.php');

// initiate template engine for mail

if ($_GET['selected_box']) {
	$_GET['action']='';
	$_GET['old_action']='';
}

if (($_GET['action'] == 'send_email_to_user') && ($_POST['customers_email_address']) && (!$_POST['back_x'])) {
	switch ($_POST['customers_email_address']) {
		case '***':
			$mail_query = olc_db_query("select customers_firstname, customers_lastname, customers_email_address from " .
			TABLE_CUSTOMERS);
			$mail_sent_to = TEXT_ALL_CUSTOMERS;
			break;
		case '**D':
			$mail_query = olc_db_query("select customers_firstname, customers_lastname, customers_email_address from " .
			TABLE_CUSTOMERS . " where customers_newsletter = '1'");
			$mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
			break;
		default:
			$customers_email_address = olc_db_prepare_input($_POST['customers_email_address']);
			$mail_query = olc_db_query("select customers_firstname, customers_lastname, customers_email_address from " .
			TABLE_CUSTOMERS . " where customers_email_address = '" . olc_db_input($customers_email_address) . APOS);
			$mail_sent_to = $_POST['customers_email_address'];
			break;
	}
	$coupon_query = olc_db_query("select coupon_code from " . TABLE_COUPONS . " where coupon_id = '" . $_GET['cid'] . APOS);
	$coupon_result = olc_db_fetch_array($coupon_query);
	$coupon_name_query = olc_db_query("select coupon_name from " . TABLE_COUPONS_DESCRIPTION .
	" where coupon_id = '" . $_GET['cid'] . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
	$coupon_name = olc_db_fetch_array($coupon_name_query);

	$from = olc_db_prepare_input($_POST['from']);
	$subject = olc_db_prepare_input($_POST['subject']);
	while ($mail = olc_db_fetch_array($mail_query)) {
		$smarty->assign('MESSAGE', $_POST['message']);
		$smarty->assign('COUPON_ID', $coupon_result['coupon_code']);
		$smarty->assign('WEBSITE', HTTP_SERVER  . DIR_WS_CATALOG);

		$txt_mail=CURRENT_TEMPLATE_MAIL.'send_coupon.';
		$html_mail=$smarty->fetch($txt_mail.'html');
		$txt_mail=$smarty->fetch($txt_mail.'txt');
		olc_php_mail(EMAIL_BILLING_ADDRESS,EMAIL_BILLING_NAME, $mail['customers_email_address'] ,
		$mail['customers_firstname'] . BLANK . $mail['customers_lastname'] , '', EMAIL_BILLING_REPLY_ADDRESS,
		EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', EMAIL_BILLING_SUBJECT, $html_mail , $txt_mail);
	}
	olc_redirect(olc_href_link(FILENAME_COUPON_ADMIN, 'mail_sent_to=' . urlencode($mail_sent_to)));
}
if ( ($_GET['action'] == 'preview_email') && (!$_POST['customers_email_address']) ) {
	$_GET['action'] = 'email';
	$messageStack->add(ERROR_NO_CUSTOMER_SELECTED, 'error');
}

if ($_GET['mail_sent_to']) {
	$messageStack->add(sprintf(NOTICE_EMAIL_SENT_TO, $_GET['mail_sent_to']), 'notice');
}

switch ($_GET['action']) {
	case 'confirmdelete':
		$delete_query=olc_db_query(SQL_UPDATE . TABLE_COUPONS . " set coupon_active = 'N' where coupon_id='".$_GET['cid'].APOS);
		break;
	case 'update':
		// get all _POST and validate
		$_POST['coupon_code'] = trim($_POST['coupon_code']);
		$languages = olc_get_languages();
		for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
			$language_id = $languages[$i]['id'];
			$_POST['coupon_name'][$language_id] = trim($_POST['coupon_name'][$language_id]);
			$_POST['coupon_desc'][$language_id] = trim($_POST['coupon_desc'][$language_id]);
		}
		$_POST['coupon_amount'] = trim($_POST['coupon_amount']);
		$update_errors = 0;
		if (!$_POST['coupon_name']) {
			$update_errors = 1;
			$messageStack->add(ERROR_NO_COUPON_NAME, 'error');
		}
		if ((!$_POST['coupon_amount']) && (!$_POST['coupon_free_ship'])) {
			$update_errors = 1;
			$messageStack->add(ERROR_NO_COUPON_AMOUNT, 'error');
		}
		if (!$_POST['coupon_code']) {
			$coupon_code = create_coupon_code();
		}
		if ($_POST['coupon_code']) $coupon_code = $_POST['coupon_code'];
		$query1 = olc_db_query("select coupon_code from " . TABLE_COUPONS . " where coupon_code = '" .
		olc_db_prepare_input($coupon_code) . APOS);
		if (olc_db_num_rows($query1) && $_POST['coupon_code'] && $_GET['oldaction'] != 'voucheredit')  {
			$update_errors = 1;
			$messageStack->add(ERROR_COUPON_EXISTS, 'error');
		}
		if ($update_errors != 0) {
			$_GET['action'] = 'new';
		} else {
			$_GET['action'] = 'update_preview';
		}
		break;
	case 'update_confirm':
		if ( ($_POST['back_x']) || ($_POST['back_y']) ) {
			$_GET['action'] = 'new';
		} else {
			$coupon_type = "F";
			if (substr($_POST['coupon_amount'], -1) == '%') $coupon_type='P';
			if ($_POST['coupon_free_ship']) $coupon_type = 'S';
			$sql_data_array = array('coupon_code' => olc_db_prepare_input($_POST['coupon_code']),
			'coupon_amount' => olc_db_prepare_input($_POST['coupon_amount']),
			'coupon_type' => olc_db_prepare_input($coupon_type),
			'uses_per_coupon' => olc_db_prepare_input($_POST['coupon_uses_coupon']),
			'uses_per_user' => olc_db_prepare_input($_POST['coupon_uses_user']),
			'coupon_minimum_order' => olc_db_prepare_input($_POST['coupon_min_order']),
			'restrict_to_products' => olc_db_prepare_input($_POST['coupon_products']),
			'restrict_to_categories' => olc_db_prepare_input($_POST['coupon_categories']),
			'coupon_start_date' => $_POST['coupon_startdate'],
			'coupon_expire_date' => $_POST['coupon_finishdate'],
			'date_created' => 'now()',
			'date_modified' => 'now()');
			$languages = olc_get_languages();
			for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
				$language_id = $languages[$i]['id'];
				$sql_data_marray[$i] = array('coupon_name' => olc_db_prepare_input($_POST['coupon_name'][$language_id]),
				'coupon_description' => olc_db_prepare_input($_POST['coupon_desc'][$language_id])
				);
			}
			if ($_GET['oldaction']=='voucheredit') {
				olc_db_perform(TABLE_COUPONS, $sql_data_array, 'update', "coupon_id='" . $_GET['cid'].APOS);
				for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
					$language_id = $languages[$i]['id'];
					$update = olc_db_query(SQL_UPDATE . TABLE_COUPONS_DESCRIPTION . " set coupon_name = '" .
					olc_db_prepare_input($_POST['coupon_name'][$language_id]) . "', coupon_description = '" .
					olc_db_prepare_input($_POST['coupon_desc'][$language_id]) . "' where coupon_id = '" . $_GET['cid'] .
					"' and language_id = '" . $language_id . APOS);
				}
			} else {
				$query = olc_db_perform(TABLE_COUPONS, $sql_data_array);
				$insert_id = olc_db_insert_id($query);

				for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
					$language_id = $languages[$i]['id'];
					$sql_data_marray[$i]['coupon_id'] = $insert_id;
					$sql_data_marray[$i]['language_id'] = $language_id;
					olc_db_perform(TABLE_COUPONS_DESCRIPTION, $sql_data_marray[$i]);
				}
			}
		}
}
?>
<?php require(DIR_WS_INCLUDES . 'header.php');
/*
if (USE_AJAX_ADMIN)
{
	$document_write=FALSE_STRING_S;
}
else
{
	$document_write=TRUE_STRING_S;
	echo '
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
';
}
*/
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="columnLeft2" nowrap="nowrap" valign="top"><table border="0" cellspacing="1" cellpadding="1" class="columnLeft" nowrap="nowrap">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
<?php
switch ($_GET['action']) {
	case 'voucherreport':
?>
      <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo CUSTOMER_ID; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo CUSTOMER_NAME; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo IP_ADDRESS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo REDEEM_DATE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
$cc_query_raw = "select * from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $_GET['cid'] . APOS;
$cc_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $cc_query_raw, $cc_query_numrows);
$cc_query = olc_db_query($cc_query_raw);
while ($cc_list = olc_db_fetch_array($cc_query)) {
	$rows++;
	if (strlen($rows) < 2) {
		$rows = '0' . $rows;
	}
	if (((!$_GET['uid']) || (@$_GET['uid'] == $cc_list['unique_id'])) && (!$cInfo)) {
		$cInfo = new objectInfo($cc_list);
	}
	if ( (is_object($cInfo)) && ($cc_list['unique_id'] == $cInfo->unique_id) ) {
		echo '          <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' .
		olc_onclick_link('coupon_admin.php', olc_get_all_get_params(array('cid', 'action', 'uid')) . 'cid=' .
		$cInfo->coupon_id . '&action=voucherreport&uid=' . $cinfo->unique_id) . '">' . NEW_LINE;
	} else {
		echo '          <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' .
		olc_onclick_link('coupon_admin.php', olc_get_all_get_params(array('cid', 'action', 'uid')) . 'cid=' . $cc_list['coupon_id'] . '&action=voucherreport&uid=' . $cc_list['unique_id']) . '">' . NEW_LINE;
	}
	$customer_query = olc_db_query("select customers_firstname, customers_lastname from " .
	TABLE_CUSTOMERS . " where customers_id = '" . $cc_list['customer_id'] . APOS);
	$customer = olc_db_fetch_array($customer_query);

?>
                <td class="dataTableContent"><?php echo $cc_list['customer_id']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $customer['customers_firstname'] . BLANK .
                 $customer['customers_lastname']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $cc_list['redeem_ip']; ?></td>
                <td class="dataTableContent" align="center"><?php echo olc_date_short($cc_list['redeem_date']); ?></td>
                <td class="dataTableContent" align="right">
                <?php if ( (is_object($cInfo)) && ($cc_list['unique_id'] == $cInfo->unique_id) ) {
                	echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif');
                } else {
                	echo HTML_A_START . olc_href_link(FILENAME_COUPON_ADMIN, 'page=' . $_GET['page'] . '&cid=' .
                	$cc_list['coupon_id']) . '">' .
                	olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
}
?>
             </table></td>
<?php
$heading = array();
$contents = array();
$coupon_description_query = olc_db_query("select coupon_name from " . TABLE_COUPONS_DESCRIPTION .
" where coupon_id = '" . $_GET['cid'] . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
$coupon_desc = olc_db_fetch_array($coupon_description_query);
$count_customers = olc_db_query("select * from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $_GET['cid'] .
"' and customer_id = '" . $cInfo->customer_id . APOS);

$heading[] = array('text' => '<b>[' . $_GET['cid'] . ']' . COUPON_NAME . BLANK . $coupon_desc['coupon_name'] . HTML_B_END);
$contents[] = array('text' => HTML_B_START . TEXT_REDEMPTIONS . HTML_B_END);
$contents[] = array('text' => TEXT_REDEMPTIONS_TOTAL . '=' . olc_db_num_rows($cc_query));
$contents[] = array('text' => TEXT_REDEMPTIONS_CUSTOMER . '=' . olc_db_num_rows($count_customers));
$contents[] = array('text' => '');
?>
    <td width="25%" valign="top">
<?php
$box = new box;
echo $box->infoBox($heading, $contents);
echo '            </td>' . NEW_LINE;
?>
<?php
break;
	case 'preview_email':
		$coupon_query = olc_db_query("select coupon_code from " .TABLE_COUPONS . " where coupon_id = '" . $_GET['cid'] . APOS);
		$coupon_result = olc_db_fetch_array($coupon_query);
		$coupon_name_query = olc_db_query("select coupon_name from " . TABLE_COUPONS_DESCRIPTION .
		" where coupon_id = '" . $_GET['cid'] . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
		$coupon_name = olc_db_fetch_array($coupon_name_query);
		switch ($_POST['customers_email_address']) {
			case '***':
				$mail_sent_to = TEXT_ALL_CUSTOMERS;
				break;
			case '**D':
				$mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
				break;
			default:
				$mail_sent_to = $_POST['customers_email_address'];
				break;
		}
?>
      <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
          <tr><?php echo olc_draw_form('mail', FILENAME_COUPON_ADMIN, 'action=send_email_to_user&cid=' . $_GET['cid']); ?>
            <td><table border="0" width="100%" cellpadding="0" cellspacing="2">
              <tr>
                <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_CUSTOMER; ?></b><br/><?php echo $mail_sent_to; ?></td>
              </tr>
              <tr>
                <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_COUPON; ?></b><br/><?php echo $coupon_name['coupon_name']; ?></td>
              </tr>
              <tr>
                <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_FROM; ?></b><br/><?php echo htmlspecialchars(stripslashes($_POST['from'])); ?></td>
              </tr>
              <tr>
                <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_SUBJECT; ?></b><br/><?php echo htmlspecialchars(stripslashes($_POST['subject'])); ?></td>
              </tr>
              <tr>
                <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_MESSAGE; ?></b><br/><?php echo nl2br(htmlspecialchars(stripslashes($_POST['message']))); ?></td>
              </tr>
              <tr>
                <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td>
<?php
/* Re-Post all POST'ed variables */
reset($_POST);
while (list($key, $value) = each($_POST)) {
	if (!is_array($_POST[$key])) {
		echo olc_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
	}
}
?>
                <table border="0" width="100%" cellpadding="0" cellspacing="2">
                  <tr>
                    <td><?php ?>&nbsp;</td>
                    <td align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_COUPON_ADMIN) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a> ' . olc_image_submit('button_send_mail.gif', IMAGE_SEND_EMAIL); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </form></tr>
<?php
break;
	case 'email':
		$coupon_query = olc_db_query("select coupon_code from " . TABLE_COUPONS . " where coupon_id = '" . $_GET['cid'] . APOS);
		$coupon_result = olc_db_fetch_array($coupon_query);
		$coupon_name_query = olc_db_query("select coupon_name from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" . $_GET['cid'] . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
		$coupon_name = olc_db_fetch_array($coupon_name_query);
?>
      <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>

          <tr><?php echo olc_draw_form('mail', FILENAME_COUPON_ADMIN, 'action=preview_email&cid='. $_GET['cid']); ?>
            <td><table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
<?php
$customers = array();
$customers[] = array('id' => '', 'text' => TEXT_SELECT_CUSTOMER);
$customers[] = array('id' => '***', 'text' => TEXT_ALL_CUSTOMERS);
$customers[] = array('id' => '**D', 'text' => TEXT_NEWSLETTER_CUSTOMERS);
$mail_query = olc_db_query("select customers_email_address, customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " order by customers_lastname");
while($customers_values = olc_db_fetch_array($mail_query)) {
	$customers[] = array('id' => $customers_values['customers_email_address'],
	'text' => $customers_values['customers_lastname'] . ', ' . $customers_values['customers_firstname'] . LPAREN . $customers_values['customers_email_address'] . RPAREN);
}
?>
              <tr>
                <td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo TEXT_COUPON; ?>&nbsp;&nbsp;</td>
                <td><?php echo $coupon_name['coupon_name']; ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo TEXT_CUSTOMER; ?>&nbsp;&nbsp;</td>
                <td><?php echo olc_draw_pull_down_menu('customers_email_address', $customers, $_GET['customer']);?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo TEXT_FROM; ?>&nbsp;&nbsp;</td>
                <td><?php echo olc_draw_input_field('from', EMAIL_FROM); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
<?php
/*
<tr>
<td class="main"><?php echo TEXT_RESTRICT; ?>&nbsp;&nbsp;</td>
<td><?php echo olc_draw_checkbox_field('customers_restrict', $customers_restrict);?></td>
</tr>
<tr>
<td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
</tr>
*/
?>
              <tr>
                <td class="main"><?php echo TEXT_SUBJECT; ?>&nbsp;&nbsp;</td>
                <td><?php echo olc_draw_input_field('subject'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td valign="top" class="main"><?php echo TEXT_MESSAGE; ?>&nbsp;&nbsp;</td>
                <td><?php echo olc_draw_textarea_field('message', 'soft', '60', '15'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td colspan="2" align="right"><?php echo olc_image_submit('button_send_mail.gif', IMAGE_SEND_EMAIL); ?></td>
              </tr>
            </table></td>
          </form></tr>

      </tr>
      </td>
<?php
break;
	case 'update_preview':
?>
      <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right">
            <?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
      <td>
<?php echo olc_draw_form('coupon', 'coupon_admin.php', 'action=update_confirm&oldaction=' .
	$_GET['oldaction'] . '&cid=' . $_GET['cid']); ?>
      <table border="0" width="100%" cellspacing="0" cellpadding="6">
<?php
$languages = olc_get_languages();
for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
	$language_id = $languages[$i]['id'];
?>
      <tr>
        <td align="left"><?php echo COUPON_NAME; ?></td>
        <td align="left"><?php echo $_POST['coupon_name'][$language_id]; ?></td>
      </tr>
<?php
}
?>
<?php
$languages = olc_get_languages();
for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
	$language_id = $languages[$i]['id'];
?>
      <tr>
        <td align="left"><?php echo COUPON_DESC; ?></td>
        <td align="left"><?php echo $_POST['coupon_desc'][$language_id]; ?></td>
      </tr>
<?php
}
?>
      <tr>
        <td align="left"><?php echo COUPON_AMOUNT; ?></td>
        <td align="left"><?php echo $_POST['coupon_amount']; ?></td>
      </tr>

      <tr>
        <td align="left"><?php echo COUPON_MIN_ORDER; ?></td>
        <td align="left"><?php echo $_POST['coupon_min_order']; ?></td>
      </tr>

      <tr>
        <td align="left"><?php echo COUPON_FREE_SHIP; ?></td>
<?php
if ($_POST['coupon_free_ship']) {
?>
        <td align="left"><?php echo TEXT_FREE_SHIPPING; ?></td>
<?php
} else {
?>
        <td align="left"><?php echo TEXT_NO_FREE_SHIPPING; ?></td>
<?php
}
?>
      </tr>
      <tr>
        <td align="left"><?php echo COUPON_CODE; ?></td>
<?php
if ($_POST['coupon_code']) {
	$c_code = $_POST['coupon_code'];
} else {
	$c_code = $coupon_code;
}
?>
        <td align="left"><?php echo $coupon_code; ?></td>
      </tr>

      <tr>
        <td align="left"><?php echo COUPON_USES_COUPON; ?></td>
        <td align="left"><?php echo $_POST['coupon_uses_coupon']; ?></td>
      </tr>

      <tr>
        <td align="left"><?php echo COUPON_USES_USER; ?></td>
        <td align="left"><?php echo $_POST['coupon_uses_user']; ?></td>
      </tr>

       <tr>
        <td align="left"><?php echo COUPON_PRODUCTS; ?></td>
        <td align="left"><?php echo $_POST['coupon_products']; ?></td>
      </tr>


      <tr>
        <td align="left"><?php echo COUPON_CATEGORIES; ?></td>
        <td align="left"><?php echo $_POST['coupon_categories']; ?></td>
      </tr>
      <tr>
        <td align="left"><?php echo COUPON_STARTDATE; ?></td>
<?php
$start_date = date(DATE_FORMAT, mktime(0, 0, 0, $_POST['coupon_startdate_month'],$_POST['coupon_startdate_day'] ,$_POST['coupon_startdate_year'] ));
?>
        <td align="left"><?php echo $start_date; ?></td>
      </tr>

      <tr>
        <td align="left"><?php echo COUPON_FINISHDATE; ?></td>
<?php
$finish_date = date(DATE_FORMAT, mktime(0, 0, 0, $_POST['coupon_finishdate_month'],$_POST['coupon_finishdate_day'] ,$_POST['coupon_finishdate_year'] ));
echo date('Y-m-d', mktime(0, 0, 0, $_POST['coupon_startdate_month'],$_POST['coupon_startdate_day'] ,$_POST['coupon_startdate_year'] ));
?>
        <td align="left"><?php echo $finish_date; ?></td>
      </tr>
<?php
$languages = olc_get_languages();
for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
	$language_id = $languages[$i]['id'];
	echo olc_draw_hidden_field('coupon_name[' . $languages[$i]['id'] . ']', $_POST['coupon_name'][$language_id]);
	echo olc_draw_hidden_field('coupon_desc[' . $languages[$i]['id'] . ']', $_POST['coupon_desc'][$language_id]);
}
echo olc_draw_hidden_field('coupon_amount', $_POST['coupon_amount']);
echo olc_draw_hidden_field('coupon_min_order', $_POST['coupon_min_order']);
echo olc_draw_hidden_field('coupon_free_ship', $_POST['coupon_free_ship']);
echo olc_draw_hidden_field('coupon_code', $c_code);
echo olc_draw_hidden_field('coupon_uses_coupon', $_POST['coupon_uses_coupon']);
echo olc_draw_hidden_field('coupon_uses_user', $_POST['coupon_uses_user']);
echo olc_draw_hidden_field('coupon_products', $_POST['coupon_products']);
echo olc_draw_hidden_field('coupon_categories', $_POST['coupon_categories']);
echo olc_draw_hidden_field('coupon_startdate', date('Y-m-d', mktime(0, 0, 0, $_POST['coupon_startdate_month'],$_POST['coupon_startdate_day'] ,$_POST['coupon_startdate_year'] )));
echo olc_draw_hidden_field('coupon_finishdate', date('Y-m-d', mktime(0, 0, 0, $_POST['coupon_finishdate_month'],$_POST['coupon_finishdate_day'] ,$_POST['coupon_finishdate_year'] )));
?>
     <tr>
        <td align="left"><?php echo olc_image_submit('button_confirm.gif',COUPON_BUTTON_CONFIRM); ?></td>
        <td align="left"><?php echo olc_image_submit('button_back.gif',COUPON_BUTTON_BACK, 'name=back'); ?></td>
      </td>
      </tr>

      </td></table></form>
      </tr>

      </table></td>
<?php

break;
	case 'voucheredit':
		$languages = olc_get_languages();
		for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
			$language_id = $languages[$i]['id'];
			$coupon_query = olc_db_query("select coupon_name,coupon_description from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" .  $_GET['cid'] . "' and language_id = '" . $language_id . APOS);
			$coupon = olc_db_fetch_array($coupon_query);
			$coupon_name[$language_id] = $coupon['coupon_name'];
			$coupon_desc[$language_id] = $coupon['coupon_description'];
		}
		$coupon_query = olc_db_query("select coupon_code, coupon_amount, coupon_type, coupon_minimum_order, coupon_start_date, coupon_expire_date, uses_per_coupon, uses_per_user, restrict_to_products, restrict_to_categories from " . TABLE_COUPONS . " where coupon_id = '" . $_GET['cid'] . APOS);
		$coupon = olc_db_fetch_array($coupon_query);
		$coupon_amount = $coupon['coupon_amount'];
		if ($coupon['coupon_type']=='P') {
			$coupon_amount .= '%';
		}
		if ($coupon['coupon_type']=='S') {
			$coupon_free_ship .= true;
		}
		$coupon_min_order = $coupon['coupon_minimum_order'];
		$coupon_code = $coupon['coupon_code'];
		$coupon_uses_coupon = $coupon['uses_per_coupon'];
		$coupon_uses_user = $coupon['uses_per_user'];
		$coupon_products = $coupon['restrict_to_products'];
		$coupon_categories = $coupon['restrict_to_categories'];
	case 'new':
		// set some defaults
		if (!$coupon_uses_user) $coupon_uses_user=1;
?>
      <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
      <td>
<?php
echo olc_draw_form('coupon', 'coupon_admin.php', 'action=update&oldaction='.$_GET['action'] . '&cid=' . $_GET['cid']);
?>
      <table border="0" width="100%" cellspacing="0" cellpadding="6">
<?php
$languages = olc_get_languages();
for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
	$language_id = $languages[$i]['id'];
?>
      <tr>
        <td align="left" class="main"><?php if ($i==0) echo COUPON_NAME; ?></td>
        <td align="left"><?php echo olc_draw_input_field('coupon_name[' . $languages[$i]['id'] . ']', $coupon_name[$language_id]) . HTML_NBSP . olc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']); ?></td>
        <td align="left" class="main" width="40%"><?php if ($i==0) echo COUPON_NAME_HELP; ?></td>
      </tr>
<?php
}
?>
<?php
$languages = olc_get_languages();
for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
	$language_id = $languages[$i]['id'];
?>

      <tr>
        <td align="left" valign="top" class="main"><?php if ($i==0) echo COUPON_DESC; ?></td>
        <td align="left" valign="top"><?php echo olc_draw_textarea_field('coupon_desc[' . $languages[$i]['id'] . ']','physical','24','3', $coupon_desc[$language_id]) . HTML_NBSP . olc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']); ?></td>
        <td align="left" valign="top" class="main"><?php if ($i==0) echo COUPON_DESC_HELP; ?></td>
      </tr>
<?php
}
?>
      <tr>
        <td align="left" class="main"><?php echo COUPON_AMOUNT; ?></td>
        <td align="left"><?php echo olc_draw_input_field('coupon_amount', $coupon_amount); ?></td>
        <td align="left" class="main"><?php echo COUPON_AMOUNT_HELP; ?></td>
      </tr>
      <tr>
        <td align="left" class="main"><?php echo COUPON_MIN_ORDER; ?></td>
        <td align="left"><?php echo olc_draw_input_field('coupon_min_order', $coupon_min_order); ?></td>
        <td align="left" class="main"><?php echo COUPON_MIN_ORDER_HELP; ?></td>
      </tr>
      <tr>
        <td align="left" class="main"><?php echo COUPON_FREE_SHIP; ?></td>
        <td align="left"><?php echo olc_draw_checkbox_field('coupon_free_ship', $coupon_free_ship); ?></td>
        <td align="left" class="main"><?php echo COUPON_FREE_SHIP_HELP; ?></td>
      </tr>
      <tr>
        <td align="left" class="main"><?php echo COUPON_CODE; ?></td>
        <td align="left"><?php echo olc_draw_input_field('coupon_code', $coupon_code); ?></td>
        <td align="left" class="main"><?php echo COUPON_CODE_HELP; ?></td>
      </tr>
      <tr>
        <td align="left" class="main"><?php echo COUPON_USES_COUPON; ?></td>
        <td align="left"><?php echo olc_draw_input_field('coupon_uses_coupon', $coupon_uses_coupon); ?></td>
        <td align="left" class="main"><?php echo COUPON_USES_COUPON_HELP; ?></td>
      </tr>
      <tr>
        <td align="left" class="main"><?php echo COUPON_USES_USER; ?></td>
        <td align="left"><?php echo olc_draw_input_field('coupon_uses_user', $coupon_uses_user); ?></td>
        <td align="left" class="main"><?php echo COUPON_USES_USER_HELP; ?></td>
      </tr>
       <tr>
        <td align="left" class="main"><?php echo COUPON_PRODUCTS; ?></td>
        <td align="left"><?php echo olc_draw_input_field('coupon_products', $coupon_products); ?> <A href="validproducts.php" TARGET="_blank" onclick="javascript:window.open('validproducts.php', 'Valid_Products', 'scrollbars=yes,resizable=yes,menubar=yes,width=600,height=600'); return false">View</A></td>
        <td align="left" class="main"><?php echo COUPON_PRODUCTS_HELP; ?></td>
      </tr>
      <tr>
        <td align="left" class="main"><?php echo COUPON_CATEGORIES; ?></td>
        <td align="left"><?php echo olc_draw_input_field('coupon_categories', $coupon_categories); ?> <A href="validcategories.php" TARGET="_blank" onclick="javascript:window.open('validcategories.php', 'Valid_Categories', 'scrollbars=yes,resizable=yes,menubar=yes,width=600,height=600'); return false">View</A></td>
        <td align="left" class="main"><?php echo COUPON_CATEGORIES_HELP; ?></td>
      </tr>
      <tr>
<?php
if (!$_POST['coupon_startdate']) {
	$coupon_startdate = split("[-]", date('Y-m-d'));
} else {
	$coupon_startdate = split("[-]", $_POST['coupon_startdate']);
}
if (!$_POST['coupon_finishdate']) {
	$coupon_finishdate = split("[-]", date('Y-m-d'));
	$coupon_finishdate[0] = $coupon_finishdate[0] + 1;
} else {
	$coupon_finishdate = split("[-]", $_POST['coupon_finishdate']);
}
?>
        <td align="left" class="main"><?php echo COUPON_STARTDATE; ?></td>
        <td align="left"><?php echo olc_draw_date_selector('coupon_startdate', mktime(0,0,0, $coupon_startdate[1], $coupon_startdate[2], $coupon_startdate[0], 0)); ?></td>
        <td align="left" class="main"><?php echo COUPON_STARTDATE_HELP; ?></td>
      </tr>
      <tr>
        <td align="left" class="main"><?php echo COUPON_FINISHDATE; ?></td>
        <td align="left"><?php echo olc_draw_date_selector('coupon_finishdate', mktime(0,0,0, $coupon_finishdate[1], $coupon_finishdate[2], $coupon_finishdate[0], 0)); ?></td>
        <td align="left" class="main"><?php echo COUPON_FINISHDATE_HELP; ?></td>
      </tr>
      <tr>
        <td align="left"><?php echo olc_image_submit('button_preview.gif',COUPON_BUTTON_PREVIEW); ?></td>
        <td align="left"><?php echo '&nbsp;&nbsp;<a href="' . olc_href_link('coupon_admin.php', ''); ?>"><?php echo olc_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a>
      </td>
      </tr>
      </td></table></form>
      </tr>

      </table></td>
<?php
break;
	default:
?>
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="main"><?php echo olc_draw_form('status', FILENAME_COUPON_ADMIN, '', 'get'); ?>
<?php
$status_array[] = array('id' => 'Y', 'text' => TEXT_COUPON_ACTIVE);
$status_array[] = array('id' => 'N', 'text' => TEXT_COUPON_INACTIVE);
$status_array[] = array('id' => '*', 'text' => TEXT_COUPON_ALL);

if ($_GET['status']) {
	$status = olc_db_prepare_input($_GET['status']);
} else {
	$status = 'Y';
}
echo HEADING_TITLE_STATUS . BLANK . olc_draw_pull_down_menu('status', $status_array, $status, 'onchange="this.form.submit();"');
?>
              </form>
           </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo COUPON_NAME; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo COUPON_AMOUNT; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo COUPON_CODE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
if ($_GET['page'] > 1) $rows = $_GET['page'] * 20 - 20;
if ($status != '*') {
	$cc_query_raw = "select coupon_id, coupon_code, coupon_amount, coupon_type, coupon_start_date,coupon_expire_date,uses_per_user,uses_per_coupon,restrict_to_products, restrict_to_categories, date_created,date_modified from " . TABLE_COUPONS ." where coupon_active='" . olc_db_input($status) . "' and coupon_type != 'G'";
} else {
	$cc_query_raw = "select coupon_id, coupon_code, coupon_amount, coupon_type, coupon_start_date,coupon_expire_date,uses_per_user,uses_per_coupon,restrict_to_products, restrict_to_categories, date_created,date_modified from " . TABLE_COUPONS . " where coupon_type != 'G'";
}
$cc_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $cc_query_raw, $cc_query_numrows);
$cc_query = olc_db_query($cc_query_raw);
while ($cc_list = olc_db_fetch_array($cc_query)) {
	$rows++;
	if (strlen($rows) < 2) {
		$rows = '0' . $rows;
	}
	if (((!$_GET['cid']) || (@$_GET['cid'] == $cc_list['coupon_id'])) && (!$cInfo)) {
		$cInfo = new objectInfo($cc_list);
	}
	if ( (is_object($cInfo)) && ($cc_list['coupon_id'] == $cInfo->coupon_id) ) {
		echo '          <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link('coupon_admin.php', olc_get_all_get_params(array('cid', 'action')) . 'cid=' . $cInfo->coupon_id . '&action=edit') . '">' . NEW_LINE;
	} else {
		echo '          <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link('coupon_admin.php', olc_get_all_get_params(array('cid', 'action')) . 'cid=' . $cc_list['coupon_id']) . '">' . NEW_LINE;
	}
	$coupon_description_query = olc_db_query("select coupon_name from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" . $cc_list['coupon_id'] . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
	$coupon_desc = olc_db_fetch_array($coupon_description_query);
?>
                <td class="dataTableContent"><?php echo $coupon_desc['coupon_name']; ?></td>
                <td class="dataTableContent" align="center">
<?php
if ($cc_list['coupon_type'] == 'P') {
	echo $cc_list['coupon_amount'] . '%';
} elseif ($cc_list['coupon_type'] == 'S') {
	echo TEXT_FREE_SHIPPING;
} else {
	echo $currencies->format($cc_list['coupon_amount']);
}
?>
            &nbsp;</td>
                <td class="dataTableContent" align="center"><?php echo $cc_list['coupon_code']; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($cInfo)) && ($cc_list['coupon_id'] == $cInfo->coupon_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo HTML_A_START . olc_href_link(FILENAME_COUPON_ADMIN, 'page=' . $_GET['page'] . '&cid=' . $cc_list['coupon_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
}
?>
          <tr>
            <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText">&nbsp;<?php echo $cc_split->display_count($cc_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_COUPONS); ?>&nbsp;</td>
                <td align="right" class="smallText">&nbsp;<?php echo $cc_split->display_links($cc_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?>&nbsp;</td>
              </tr>

              <tr>
                <td align="right" colspan="2" class="smallText"><?php echo HTML_A_START . olc_href_link('coupon_admin.php', 'page=' . $_GET['page'] . '&cID=' . $cInfo->coupon_id . '&action=new') . '">' . olc_image_button('button_insert.gif', IMAGE_INSERT) . HTML_A_END; ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>

<?php

$heading = array();
$contents = array();

switch ($_GET['action']) {
	case 'release':
		break;
	case 'voucherreport':
		$heading[] = array('text' => HTML_B_START . TEXT_HEADING_COUPON_REPORT . HTML_B_END);
		$contents[] = array('text' => TEXT_NEW_INTRO);
		break;
	case 'neww':
		$heading[] = array('text' => HTML_B_START . TEXT_HEADING_NEW_COUPON . HTML_B_END);
		$contents[] = array('text' => TEXT_NEW_INTRO);
		$contents[] = array('text' => HTML_BR . COUPON_NAME . HTML_BR . olc_draw_input_field('name'));
		$contents[] = array('text' => HTML_BR . COUPON_AMOUNT . HTML_BR . olc_draw_input_field('voucher_amount'));
		$contents[] = array('text' => HTML_BR . COUPON_CODE . HTML_BR . olc_draw_input_field('voucher_code'));
		$contents[] = array('text' => HTML_BR . COUPON_USES_COUPON . HTML_BR . olc_draw_input_field('voucher_number_of'));
		break;
	default:
		$heading[] = array('text'=>'['.$cInfo->coupon_id.']  '.$cInfo->coupon_code);
		$amount = $cInfo->coupon_amount;
		if ($cInfo->coupon_type == 'P') {
			$amount .= '%';
		} else {
			$amount = $currencies->format($amount);
		}
		if ($_GET['action'] == 'voucherdelete') {
			$contents[] = array('text'=> TEXT_CONFIRM_DELETE . '</br></br>' .
			HTML_A_START.olc_href_link('coupon_admin.php','action=confirmdelete&cid='.$_GET['cid'],NONSSL).'">'.olc_image_button('button_confirm.gif','Confirm Delete Voucher').HTML_A_END .
			HTML_A_START.olc_href_link('coupon_admin.php','cid='.$cInfo->coupon_id,NONSSL).'">'.olc_image_button('button_cancel.gif','Cancel').HTML_A_END
			);
		} else {
			$prod_details = NONE;
			if ($cInfo->restrict_to_products) {
				$prod_details = '<A href="listproducts.php?cid=' . $cInfo->coupon_id . '" TARGET="_blank" onclick="javascript:window.open(\'listproducts.php?cid=' . $cInfo->coupon_id . '\', \'Valid_Categories\', \'scrollbars=yes,resizable=yes,menubar=yes,width=600,height=600\'); return false">View</A>';
			}
			$cat_details = NONE;
			if ($cInfo->restrict_to_categories) {
				$cat_details = '<A href="listcategories.php?cid=' . $cInfo->coupon_id . '" TARGET="_blank" onclick="javascript:window.open(\'listcategories.php?cid=' . $cInfo->coupon_id . '\', \'Valid_Categories\', \'scrollbars=yes,resizable=yes,menubar=yes,width=600,height=600\'); return false">View</A>';
			}
			$coupon_name_query = olc_db_query("select coupon_name from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" . $cInfo->coupon_id . "' and language_id = '" . SESSION_LANGUAGE_ID . APOS);
			$coupon_name = olc_db_fetch_array($coupon_name_query);
			$contents[] = array('text'=>COUPON_NAME . '&nbsp;::&nbsp; ' . $coupon_name['coupon_name'] . HTML_BR .
			COUPON_AMOUNT . '&nbsp;::&nbsp; ' . $amount . HTML_BR .
			COUPON_STARTDATE . '&nbsp;::&nbsp; ' . olc_date_short($cInfo->coupon_start_date) . HTML_BR .
			COUPON_FINISHDATE . '&nbsp;::&nbsp; ' . olc_date_short($cInfo->coupon_expire_date) . HTML_BR .
			COUPON_USES_COUPON . '&nbsp;::&nbsp; ' . $cInfo->uses_per_coupon . HTML_BR .
			COUPON_USES_USER . '&nbsp;::&nbsp; ' . $cInfo->uses_per_user . HTML_BR .
			COUPON_PRODUCTS . '&nbsp;::&nbsp; ' . $prod_details . HTML_BR .
			COUPON_CATEGORIES . '&nbsp;::&nbsp; ' . $cat_details . HTML_BR .
			DATE_CREATED . '&nbsp;::&nbsp; ' . olc_date_short($cInfo->date_created) . HTML_BR .
			DATE_MODIFIED . '&nbsp;::&nbsp; ' . olc_date_short($cInfo->date_modified) . '<br/><br/>' .
			'<center><a href="'.olc_href_link('coupon_admin.php','action=email&cid='.$cInfo->coupon_id,NONSSL).'">'.olc_image_button('button_email.gif','Email Voucher').HTML_A_END .
			HTML_A_START.olc_href_link('coupon_admin.php','action=voucheredit&cid='.$cInfo->coupon_id,NONSSL).'">'.olc_image_button('button_edit.gif','Edit Voucher').HTML_A_END .
			HTML_A_START.olc_href_link('coupon_admin.php','action=voucherdelete&cid='.$cInfo->coupon_id,NONSSL).'">'.olc_image_button('button_delete.gif','Delete Voucher').HTML_A_END .
			'<br/><a href="'.olc_href_link('coupon_admin.php','action=voucherreport&cid='.$cInfo->coupon_id,NONSSL).'">'.olc_image_button('button_report.gif','Voucher Report').'</a></center>'
			);
		}
		break;
}
?>
    <td width="25%" valign="top">
<?php
$box = new box;
echo $box->infoBox($heading, $contents);
echo '            </td>' . NEW_LINE;
}
?>
      </tr>
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
