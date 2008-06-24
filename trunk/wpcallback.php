<?php

/* -----------------------------------------------------------------------------------------
$Id: wpcallback.php,v 1.0

OL-Commerce Version 1.2.2
http://www.ol-commerce.com

Copyright (c) 2006 Erwin Loerracher
Anpassung and OL-Commerce by Erwin Loerracher
Released under the GNU General Public License
-----------------------------------------------------------------------------------------
XT-Commerce - community made shopping
http://www.xt-commerce.com

Copyright (c) 2003 XT-Commerce
Anpassung Worldpay by OLC-Webservice.de, Matthias Hinsche
-----------------------------------------------------------------------------------------
based on:

$Id: wpcallback.php,v MS1a 2003/04/06 21:30
Author : 	Graeme Conkie (graeme@conkie.net)
Title: WorldPay Payment Callback Module V4.0 Version 1.4

Revisions:

Version 1.8 - cleaned up coding errors in wpcallback.php
- reduced "refresh" to 2 seconds (less chance of callback failing)

Gary Burton - www.oscbooks.com

Version MS1a Cleaned up code, moved static English to language file to allow for bi-lingual use,
Now posting language code to WP, Redirect on failure now to Checkout Payment,
Reduced re-direct time to 8 seconds, added MD5, made callback dynamic
NOTE: YOU MUST CHANGE THE CALLBACK URL IN WP ADMIN TO <wpdisplay item="MC_callback">
Version 1.4 Removes boxes to prevent users from clicking away before update,
Fixes currency for Yen,
Redirects to Checkout_Process after 10 seconds or click by user
Version 1.3 Fixes problem with Multi Currency
Version 1.2 Added Sort Order and Default order status to work with snapshots after 14 Jan 2003
Version 1.1 Added Worldpay Pre-Authorisation ability
Version 1.0 Initial Payment Module

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2003

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
olc_smarty_init($smarty,$cacheid);
require (BOXES);
$breadcrumb->add(NAVBAR_TITLE_SPECIALS, olc_href_link(FILENAME_SPECIALS));

//W. Kaiser - Enhance WP security
if($_POST['transStatus'] == $_SESSION['worldpay_id']) 
{
	$link = FILENAME_CHECKOUT_PROCESS;
	$text = WP_TEXT_SUCCESS;
} else {
	$link = FILENAME_CHECKOUT_PAYMENT;
	$text = WP_TEXT_FAILURE;
}
unset($_SESSION['worldpay_id']);
//W. Kaiser - Enhance WP security

$link=olc_href_link($link, '', 'SSL', false);
$meta = "<meta http-equiv='Refresh' content='2; Url=\"$link\"'>";
$link = HTML_A_START.$link.'">'.olc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE).HTML_A_END;

$smarty->assign('META', $meta);
$smarty->assign('TEXT', $text);
$smarty->assign('LINK', $link);

$main_content = $smarty->fetch(CURRENT_TEMPLATE_MODULE.'wpcallback.html');
$smarty->assign('main_content', $main_content);
$smarty->display(CURRENT_TEMPLATE.SLASH.INDEX_HTML);
?>

