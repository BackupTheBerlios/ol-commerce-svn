<?php
/* -----------------------------------------------------------------------------------------
$Id: gv_mail.php,v 1.1.1.1.2.1 2007/04/08 07:16:28 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project (earlier name of osCommerce)
(c) 2002-2003 osCommerce (gv_mail.php,v 1.3.2.4 2003/05/12); www.oscommerce.com

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

require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'class.phpmailer.php');
require_once(DIR_FS_INC.'olc_php_mail.inc.php');

// initiate template engine for mail

if ( ($_GET['action'] == 'send_email_to_user') && ($_POST['customers_email_address'] || $_POST['email_to']) && (!$_POST['back_x']) ) {
	/*
	switch ($_POST['customers_email_address']) {
	case '***':
	$mail_query = olc_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS);
	$mail_sent_to = TEXT_ALL_CUSTOMERS;
	break;
	case '**D':
	$mail_query = olc_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_newsletter = '1'");
	$mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
	break;
	default:
	$customers_email_address = olc_db_prepare_input($_POST['customers_email_address']);

	$mail_query = olc_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_email_address = '" . olc_db_input($customers_email_address) . APOS);
	$mail_sent_to = $_POST['customers_email_address'];
	if ($_POST['email_to']) {
	$mail_sent_to = $_POST['email_to'];
	}
	break;
	}
	*/
	//	W. Kaiser - eMail-type by customer
	$mail_query = "select customers_firstname, customers_lastname, customers_email_address, customers_email_type from ". TABLE_CUSTOMERS;
	$customers_email_address = olc_db_prepare_input($_POST['customers_email_address']);
	switch ($customers_email_address ) 
	{
		case '***':
		$mail_query = olc_db_query($mail_query);
		$mail_sent_to = TEXT_ALL_CUSTOMERS;
		break;
		case '**D':
		$mail_query = olc_db_query($mail_query  . " where customers_newsletter = '1'");
		$mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
		break;
		default:
		$mail_query = olc_db_query($mail_query  . " where customers_email_address = '" . olc_db_input($customers_email_address) . APOS);
		$mail_sent_to = $customers_email_address;
		break;
	}
	//	W. Kaiser - eMail-type by customer

	$from = olc_db_prepare_input($_POST['from']);
	$subject = olc_db_prepare_input($_POST['subject']);
	while ($mail = olc_db_fetch_array($mail_query)) {
		$id1 = create_coupon_code($mail['customers_email_address']);
		$smarty->assign('AMMOUNT', $currencies->format($_POST['amount']));
		$smarty->assign('MESSAGE', $_POST['message']);
		$smarty->assign('GIFT_ID', $id1);
		$smarty->assign('WEBSITE', HTTP_SERVER  . DIR_WS_CATALOG);
		$link = HTTP_SERVER  . DIR_WS_CATALOG . 'gv_redeem.php' . '?gv_no='.$id1;
		$smarty->assign('GIFT_LINK',$link);
		$txt_mail=CURRENT_TEMPLATE_ADMIN_MAIL.'send_gift.';
		$html_mail=$smarty->fetch($txt_mail.'html');
		$txt_mail=$smarty->fetch($txt_mail.'txt');
		if ($subject=='') $subject=EMAIL_BILLING_SUBJECT;
		//	W. Kaiser - eMail-type by customer
		olc_php_mail(EMAIL_BILLING_ADDRESS,EMAIL_BILLING_NAME, $mail['customers_email_address'] ,
		trim($mail['customers_firstname'] . BLANK . $mail['customers_lastname']) , '',
		EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $subject, $html_mail , $txt_mail,
		$mail['customers_email_type']);
		//	W. Kaiser - eMail-type by customer

		// Now create the coupon main and email entry
		$insert_query = olc_db_query(INSERT_INTO . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created) values ('" . $id1 . "', 'G', '" . $_POST['amount'] . "', now())");
		$insert_id = olc_db_insert_id($insert_query);
		$insert_query = olc_db_query(INSERT_INTO . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $insert_id ."', '0', 'Admin', '" . $mail['customers_email_address'] . "', now() )");
	}
	if ($_POST['email_to']) {
		$id1 = create_coupon_code($_POST['email_to']);
		$smarty->assign('AMMOUNT', $currencies->format($_POST['amount']));
		$smarty->assign('MESSAGE', $_POST['message']);
		$smarty->assign('GIFT_ID', $id1);
		$smarty->assign('WEBSITE', HTTP_SERVER  . DIR_WS_CATALOG);

		if (USE_SEO) {
			$link = SLASH;
		} else {
			$link = '?';
		}
		$link = HTTP_SERVER  . DIR_WS_CATALOG . 'gv_redeem.php' . $link .'gv_no='.$id1;

		$smarty->assign('GIFT_LINK',$link);

		$txt_mail=CURRENT_TEMPLATE_ADMIN_MAIL.'send_gift.';
		$html_mail=$smarty->fetch($txt_mail . 'html');
		$txt_mail=$smarty->fetch($txt_mail . 'txt');

		olc_php_mail(EMAIL_BILLING_ADDRESS,EMAIL_BILLING_NAME, $_POST['email_to'] , '' , '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', EMAIL_BILLING_SUBJECT, $html_mail , $txt_mail);

		// Now create the coupon email entry
		$insert_query = olc_db_query(INSERT_INTO . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created) values ('" . $id1 . "', 'G', '" . $_POST['amount'] . "', now())");
		$insert_id = olc_db_insert_id($insert_query);
		$insert_query = olc_db_query(INSERT_INTO . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $insert_id ."', '0', 'Admin', '" . $_POST['email_to'] . "', now() )");
	}
	olc_redirect(olc_href_link(FILENAME_GV_MAIL, 'mail_sent_to=' . urlencode($mail_sent_to)));
}

if ( ($_GET['action'] == 'preview') && (!$_POST['customers_email_address']) && (!$_POST['email_to']) ) {
	$messageStack->add(ERROR_NO_CUSTOMER_SELECTED, 'error');
}

if ( ($_GET['action'] == 'preview') && (!$_POST['amount']) ) {
	$messageStack->add(ERROR_NO_AMOUNT_SELECTED, 'error');
}

if ($_GET['mail_sent_to']) {
	$messageStack->add(sprintf(NOTICE_EMAIL_SENT_TO, $_GET['mail_sent_to']), 'notice');
}
  include(DIR_WS_INCLUDES . 'html_head_full.php');
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
		<?php require_once(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
if ( ($_GET['action'] == 'preview') && ($_POST['customers_email_address'] || $_POST['email_to']) ) {
	switch ($_POST['customers_email_address']) {
		case '***':
		$mail_sent_to = TEXT_ALL_CUSTOMERS;
		break;
		case '**D':
		$mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
		break;
		default:
		$mail_sent_to = $_POST['customers_email_address'];
		if ($_POST['email_to']) {
			$mail_sent_to = $_POST['email_to'];
		}
		break;
	}
?>
          <tr><?php echo olc_draw_form('mail', FILENAME_GV_MAIL, 'action=send_email_to_user'); ?>
            <td><table border="0" width="100%" cellpadding="0" cellspacing="2">
              <tr>
                <td class="smallText"><b><?php echo TEXT_CUSTOMER; ?></b><br/><?php echo $mail_sent_to; ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_FROM; ?></b><br/><?php echo htmlspecialchars(stripslashes($_POST['from'])); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_SUBJECT; ?></b><br/><?php echo htmlspecialchars(stripslashes($_POST['subject'])); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_AMOUNT; ?></b><br/><?php echo nl2br(htmlspecialchars(stripslashes($_POST['amount']))); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_MESSAGE; ?></b><br/><?php echo nl2br(htmlspecialchars(stripslashes($_POST['message']))); ?></td>
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
                    <td><?php echo olc_image_submit('button_back.gif', IMAGE_BACK, 'name="back"'); ?></td>
                    <td align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_GV_MAIL) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a> ' . olc_image_submit('button_send_mail.gif', IMAGE_SEND_EMAIL); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </form></tr>
<?php
} else {
?>
          <tr><?php echo olc_draw_form('mail', FILENAME_GV_MAIL, 'action=preview'); ?>
            <td><table border="0" cellpadding="0" cellspacing="2">
<?php
if ($_GET['cID']) {
	$select='where customers_id='.$_GET['cID'];
} else {
	$customers = array();
	$customers[] = array('id' => '', 'text' => TEXT_SELECT_CUSTOMER);
	$customers[] = array('id' => '***', 'text' => TEXT_ALL_CUSTOMERS);
	$customers[] = array('id' => '**D', 'text' => TEXT_NEWSLETTER_CUSTOMERS);
}
$mail_query = olc_db_query("select customers_id, customers_email_address, customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . BLANK.$select." order by customers_lastname");
while($customers_values = olc_db_fetch_array($mail_query)) {
	$customers[] = array('id' => $customers_values['customers_email_address'],
	'text' => $customers_values['customers_lastname'] . ', ' . $customers_values['customers_firstname'] . LPAREN . $customers_values['customers_email_address'] . RPAREN);
}
?>
              <tr>
                <td class="main"><?php echo TEXT_CUSTOMER; ?></td>
                <td><?php echo olc_draw_pull_down_menu('customers_email_address', $customers, $_GET['customer']);?></td>
              </tr>
               <tr>
                <td class="main"><?php echo TEXT_TO; ?></td>
                <td><?php echo olc_draw_input_field('email_to'); ?><?php echo '&nbsp;&nbsp;' . TEXT_SINGLE_EMAIL; ?></td>
              </tr>
             <tr>
                <td class="main"><?php echo TEXT_FROM; ?></td>
                <td><?php echo olc_draw_input_field('from', EMAIL_FROM); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo TEXT_SUBJECT; ?></td>
                <td><?php echo olc_draw_input_field('subject'); ?></td>
              </tr>
              <tr>
                <td valign="top" class="main"><?php echo TEXT_AMOUNT; ?></td>
                <td><?php echo olc_draw_input_field('amount'); ?></td>
              </tr>
              <tr>
                <td valign="top" class="main"><?php echo TEXT_MESSAGE; ?></td>
                <td><?php echo olc_draw_textarea_field('message', 'soft', '60', '15'); ?></td>
              </tr>
              <tr>
                <td colspan="2" align="right"><?php echo olc_image_submit('button_send_mail.gif', IMAGE_SEND_EMAIL); ?></td>
              </tr>
            </table></td>
          </form></tr>
<?php
}
?>
        </table></td>
      </tr>
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
