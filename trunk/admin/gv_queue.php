<?php
/* -----------------------------------------------------------------------------------------
$Id: gv_queue.php,v 1.1.1.1.2.1 2007/04/08 07:16:28 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project (earlier name of osCommerce)
(c) 2002-2003 osCommerce (gv_queue.php,v 1.2.2.5 2003/05/05); www.oscommerce.com

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


require_once('includes/application_top.php');

require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'class.phpmailer.php');
require_once(DIR_FS_INC.'olc_php_mail.inc.php');

// initiate template engine for mail

require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

if ($_GET['action']=='confirmrelease' && isset($_GET['gid'])) {
	$gv_query=olc_db_query("select release_flag from " . TABLE_COUPON_GV_QUEUE . " where unique_id='".$_GET['gid'].APOS);
	$gv_result=olc_db_fetch_array($gv_query);
	if ($gv_result['release_flag']=='N') {
		$gv_query=olc_db_query("select customer_id, amount from " . TABLE_COUPON_GV_QUEUE ." where unique_id='".$_GET['gid'].APOS);
		if ($gv_resulta=olc_db_fetch_array($gv_query)) {
			$gv_amount = $gv_resulta['amount'];
			//Let's build a message object using the email class
			//$mail_query = olc_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_id = '" . $gv_resulta['customer_id'] . APOS);
			//	W. Kaiser - eMail-type by customer
			$mail_query = olc_db_query("select customers_firstname, customers_lastname, customers_email_address, customers_email_type from " . TABLE_CUSTOMERS . " where customers_id = '" . $gv_resulta['customer_id'] . APOS);
			//	W. Kaiser - eMail-type by customer
			$mail = olc_db_fetch_array($mail_query);
			$smarty->assign('AMMOUNT',$currencies->format($gv_amount));

			$txt_mail=CURRENT_TEMPLATE_ADMIN_MAIL.'gift_accepted.';
			$html_mail=$smarty->fetch($txt_mail . 'html');
			$txt_mail=$smarty->fetch($txt_mail . 'txt');

			olc_php_mail(
			EMAIL_BILLING_ADDRESS,
			EMAIL_BILLING_NAME,
			$mail['customers_email_address'] ,
			$mail['customers_firstname'] . BLANK . $mail['customers_lastname']
			, '',
			EMAIL_BILLING_REPLY_ADDRESS,
			EMAIL_BILLING_REPLY_ADDRESS_NAME,
			'',
			'',
			EMAIL_BILLING_SUBJECT,
			$html_mail,
			$txt_mail,
			$mail['customers_email_type']);
			$gv_amount=$gv_resulta['amount'];
			$gv_query=olc_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id='".$gv_resulta['customer_id'].APOS);
			$customer_gv=false;
			$total_gv_amount=0;
			if ($gv_result=olc_db_fetch_array($gv_query)) {
				$total_gv_amount=$gv_result['amount'];
				$customer_gv=true;
			}
			$total_gv_amount=$total_gv_amount+$gv_amount;
			if ($customer_gv) {
				$gv_update=olc_db_query(SQL_UPDATE . TABLE_COUPON_GV_CUSTOMER . " set amount='".$total_gv_amount."' where customer_id='".$gv_resulta['customer_id'].APOS);
			} else {
				$gv_insert=olc_db_query(INSERT_INTO .TABLE_COUPON_GV_CUSTOMER . " (customer_id, amount) values ('".$gv_resulta['customer_id']."','".$total_gv_amount."')");
			}
			$gv_update=olc_db_query(SQL_UPDATE . TABLE_COUPON_GV_QUEUE . " set release_flag='Y' where unique_id='".$_GET['gid'].APOS);
		}
	}
}
  include(DIR_WS_INCLUDES . 'html_head_full.php');
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
		<?php require_once(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMERS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ORDERS_ID; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_VOUCHER_VALUE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_DATE_PURCHASED; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
$gv_query_raw = "select c.customers_firstname, c.customers_lastname, gv.unique_id, gv.date_created, gv.amount, gv.order_id from " . TABLE_CUSTOMERS . " c, " . TABLE_COUPON_GV_QUEUE . " gv where (gv.customer_id = c.customers_id and gv.release_flag = 'N')";
$gv_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $gv_query_raw, $gv_query_numrows);
$gv_query = olc_db_query($gv_query_raw);
while ($gv_list = olc_db_fetch_array($gv_query)) {
	if (((!$_GET['gid']) || (@$_GET['gid'] == $gv_list['unique_id'])) && (!$gInfo)) {
		$gInfo = new objectInfo($gv_list);
	}
	if ( (is_object($gInfo)) && ($gv_list['unique_id'] == $gInfo->unique_id) ) {
		echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:' . olc_onclick_link('gv_queue.php', olc_get_all_get_params(array('gid', 'action')) . 'gid=' . $gInfo->unique_id . '&action=edit') . '">' . NEW_LINE;
	} else {
		echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link('gv_queue.php', olc_get_all_get_params(array('gid', 'action')) . 'gid=' . $gv_list['unique_id']) . '">' . NEW_LINE;
	}
?>
                <td class="dataTableContent"><?php echo $gv_list['customers_firstname'] . BLANK . $gv_list['customers_lastname']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $gv_list['order_id']; ?></td>
                <td class="dataTableContent" align="right"><?php echo $currencies->format($gv_list['amount']); ?></td>
                <td class="dataTableContent" align="right"><?php echo olc_datetime_short($gv_list['date_created']); ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($gInfo)) && ($gv_list['unique_id'] == $gInfo->unique_id) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo HTML_A_START . olc_href_link(FILENAME_GV_QUEUE, 'page=' . $_GET['page'] . '&gid=' . $gv_list['unique_id']) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
}
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $gv_split->display_count($gv_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_GIFT_VOUCHERS); ?></td>
                    <td class="smallText" align="right"><?php echo $gv_split->display_links($gv_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
$heading = array();
$contents = array();
switch ($_GET['action']) {
	case 'release':
	$heading[] = array('text' => '[' . $gInfo->unique_id . '] ' . olc_datetime_short($gInfo->date_created) . BLANK . $currencies->format($gInfo->amount));

	$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link('gv_queue.php','action=confirmrelease&gid='.$gInfo->unique_id,NONSSL).'">'.olc_image_button('button_confirm_red.gif', IMAGE_CONFIRM) . '</a> <a href="' . olc_href_link('gv_queue.php','action=cancel&gid=' . $gInfo->unique_id,NONSSL) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
	break;
	default:
	$heading[] = array('text' => '[' . $gInfo->unique_id . '] ' . olc_datetime_short($gInfo->date_created) . BLANK . $currencies->format($gInfo->amount));

	$contents[] = array('align' => 'center','text' => HTML_A_START . olc_href_link('gv_queue.php','action=release&gid=' . $gInfo->unique_id,NONSSL). '">' . olc_image_button('button_release.gif', IMAGE_RELEASE) . HTML_A_END);
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
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
