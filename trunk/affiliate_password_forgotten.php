<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_password_forgotten.php,v 1.1.1.1.2.1 2007/04/08 07:16:06 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_passord_forgotten.php, v 1.7 2003/03/04);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   Copyright (c) 2003 netz-designer
   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

require('includes/application_top.php');


// include needed functions
require_once(DIR_FS_INC.'olc_image_button.inc.php');
require_once(DIR_FS_INC.'olc_draw_input_field.inc.php');



// include the mailer-class
require_once(DIR_WS_CLASSES . 'class.phpmailer.php');

if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
	$check_affiliate_query = olc_db_query("select affiliate_firstname, affiliate_lastname, affiliate_password, affiliate_id from " . TABLE_AFFILIATE . " where affiliate_email_address = '" . $_POST['email_address'] . APOS);
    if (olc_db_num_rows($check_affiliate_query)) {
    	$check_affiliate = olc_db_fetch_array($check_affiliate_query);
    	// Crypted password mods - create a new password, update the database and mail it to them
    	$newpass = olc_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);
    	$crypted_password = olc_encrypt_password($newpass);
    	olc_db_query(SQL_UPDATE . TABLE_AFFILIATE . " set affiliate_password = '" . $crypted_password . "' where affiliate_id = '" . $check_affiliate['affiliate_id'] . APOS);
    	
    	olc_php_mail(AFFILIATE_EMAIL_ADDRESS, STORE_OWNER, $_POST['email_address'], $check_affiliate['affiliate_firstname'] . BLANK . $check_affiliate['affiliate_lastname'], '', AFFILIATE_EMAIL_ADDRESS, STORE_OWNER, '', '', EMAIL_PASSWORD_REMINDER_SUBJECT, nl2br(sprintf(EMAIL_PASSWORD_REMINDER_BODY, $newpass)), nl2br(sprintf(EMAIL_PASSWORD_REMINDER_BODY, $newpass)));
        if (!isset($mail_error)) {
            olc_redirect(olc_href_link(FILENAME_AFFILIATE, 'info_message=' . urlencode(TEXT_PASSWORD_SENT), SSL, true, false));
        }
        else {
            echo $mail_error;
        }
    }
	else {
		olc_redirect(olc_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, 'email=nonexistent', SSL));
    }
}
else {
	$breadcrumb->add(NAVBAR_TITLE, olc_href_link(FILENAME_AFFILIATE, '', SSL));
	$breadcrumb->add(NAVBAR_TITLE_PASSWORD_FORGOTTEN, olc_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, '', SSL));

	require(DIR_WS_INCLUDES . 'header.php');

	$smarty->assign('FORM_ACTION', olc_draw_form('password_forgotten', olc_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, 'action=process', SSL)));
	$smarty->assign('INPUT_EMAIL', olc_draw_input_field('email_address', '', 'maxlength="96"'));
	$smarty->assign('LINK_AFFILIATE', HTML_A_START . olc_href_link(FILENAME_AFFILIATE, '', SSL) . '">' . olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END);
	$smarty->assign('BUTTON_SUBMIT', olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
	
	if (isset($_GET['email']) && ($_GET['email'] == 'nonexistent')) {
		$smarty->assign('email_nonexistent', TRUE_STRING_S);
	}
}
$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'affiliate_password_forgotten'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>
