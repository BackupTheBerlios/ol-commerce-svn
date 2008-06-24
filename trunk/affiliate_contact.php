<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_contact.php,v 1.1.1.1.2.1 2007/04/08 07:16:04 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_contact.php, v 1.3 2003/02/15);
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
require_once(DIR_FS_INC.'olc_draw_input_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_textarea_field.inc.php');
require_once(DIR_FS_INC.'olc_validate_email.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');



// include the mailer-class
require_once(DIR_WS_CLASSES . 'class.phpmailer.php');
// include all for the mails
require_once(DIR_FS_INC.'olc_php_mail.inc.php');

if (!isset($_SESSION['affiliate_id'])) {
    olc_redirect(olc_href_link(FILENAME_AFFILIATE, '', SSL));
}

$error = false;
if (isset($_GET['action']) && ($_GET['action'] == 'send')) {
    if (olc_validate_email(trim($_POST['email']))) {
        olc_php_mail($_POST['email'], $_POST['name'], AFFILIATE_EMAIL_ADDRESS, STORE_OWNER, '', $_POST['email'], $_POST['name'], '', '', EMAIL_SUBJECT, $_POST['enquiry'], $_POST['enquiry']);
        if (!isset($mail_error)) {
            olc_redirect(olc_href_link(FILENAME_AFFILIATE_CONTACT, 'action=success'));
        }
        else {
            echo $mail_error;
        }
    }
    else {
        $error = true;
    }
}

$breadcrumb->add(NAVBAR_TITLE, olc_href_link(FILENAME_AFFILIATE, '', SSL));
$breadcrumb->add(NAVBAR_TITLE_CONTACT, olc_href_link(FILENAME_AFFILIATE_CONTACT));

$affiliate_values = olc_db_query("select * from " . TABLE_AFFILIATE . " where affiliate_id = '" . $_SESSION['affiliate_id'] . APOS);

require(DIR_WS_INCLUDES . 'header.php');

if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
    $smarty->assign('SUMMARY_LINK', HTML_A_START . olc_href_link(FILENAME_AFFILIATE_SUMMARY) . '">' . olc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . HTML_A_END);
}
else {
    $smarty->assign('FORM_ACTION', olc_draw_form('contact_us', olc_href_link(FILENAME_AFFILIATE_CONTACT, 'action=send')));
    $smarty->assign('INPUT_NAME', olc_draw_input_field('name', $affiliate['affiliate_firstname'] . BLANK . $affiliate['affiliate_lastname'], 'size=40'));
    $smarty->assign('INPUT_EMAIL', olc_draw_input_field('email', $affiliate['affiliate_email_address'], 'size=40'));
    $smarty->assign('error', $error);
    $smarty->assign('TEXTAREA_ENQUIRY', olc_draw_textarea_field('enquiry', 'soft', 50, 15, $_POST['enquiry']));
    $smarty->assign('BUTTON_SUBMIT', olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
}
$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'affiliate_contact'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>
