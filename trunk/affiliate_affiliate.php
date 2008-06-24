<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_affiliate.php,v 1.1.1.1.2.1 2007/04/08 07:16:04 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_affiliate.php, v 1.8 2003/02/19);
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
require_once(DIR_FS_INC.'olc_draw_password_field.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');
require_once(DIR_FS_INC.'olc_validate_password.inc.php');

if (isset($_SESSION['affiliate_id'])) {
    olc_redirect(olc_href_link(FILENAME_AFFILIATE_SUMMARY, '', SSL));
}

if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $affiliate_username = olc_db_prepare_input($_POST['affiliate_username']);
    $affiliate_password = olc_db_prepare_input($_POST['affiliate_password']);
    
    // Check if username exists
    $check_affiliate_query = olc_db_query("select affiliate_id, affiliate_firstname, affiliate_password, affiliate_email_address from " . TABLE_AFFILIATE . " where affiliate_email_address = '" . olc_db_input($affiliate_username) . APOS);
    if (!olc_db_num_rows($check_affiliate_query)) {
        $_GET['login'] = 'fail';
    }
    else {
        $check_affiliate = olc_db_fetch_array($check_affiliate_query);
        // Check that password is good
        if (!olc_validate_password($affiliate_password, $check_affiliate['affiliate_password'])) {
            $_GET['login'] = 'fail';
        }
        else {
            $_SESSION['affiliate_id'] = $check_affiliate['affiliate_id'];

            $date_now = date('Ymd');
            
            olc_db_query(SQL_UPDATE . TABLE_AFFILIATE . " set affiliate_date_of_last_logon = now(), affiliate_number_of_logons = affiliate_number_of_logons + 1 where affiliate_id = '" . $_SESSION['affiliate_id'] . APOS);
            olc_redirect(olc_href_link(FILENAME_AFFILIATE_SUMMARY,'',SSL));
        }
    }
}

$breadcrumb->add(NAVBAR_TITLE, olc_href_link(FILENAME_AFFILIATE, '', SSL));

require(DIR_WS_INCLUDES . 'header.php');

if (isset($_GET['login']) && ($_GET['login'] == 'fail')) {
    $info_message = TRUE_STRING_S;
}
else {
    $info_message = FALSE_STRING_S;
}

$smarty->assign('info_message', $info_message);

$smarty->assign('FORM_ACTION', olc_draw_form('login', olc_href_link(FILENAME_AFFILIATE, 'action=process', SSL)));
$smarty->assign('LINK_TERMS', '<a  href="' . olc_href_link(FILENAME_CONTENT,'coID=900', SSL) . '">');
$smarty->assign('INPUT_AFFILIATE_USERNAME', olc_draw_input_field('affiliate_username'));
$smarty->assign('INPUT_AFFILIATE_PASSWORD', olc_draw_password_field('affiliate_password'));
$smarty->assign('LINK_PASSWORD_FORGOTTEN', HTML_A_START . olc_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, '', SSL) . '">');
$smarty->assign('LINK_SIGNUP', HTML_A_START . olc_href_link(FILENAME_AFFILIATE_SIGNUP, '', SSL) . '">' . olc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . HTML_A_END);
$smarty->assign('BUTTON_LOGIN', olc_image_submit('button_login.gif', IMAGE_BUTTON_LOGIN));

$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'affiliate_affiliate'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);?>
