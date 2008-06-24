<?php
/* -----------------------------------------------------------------------------------------
$Id: shop_content.php,v 1.1.1.1.2.1 2007/04/08 07:16:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(conditions.php,v 1.21 2003/02/13); www.oscommerce.com
(c) 2003	    nextcommerce (shop_content.php,v 1.1 2003/08/19); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

require('includes/application_top.php');


// include needed functions
require_once(DIR_FS_INC.'olc_image_button.inc.php');
require_once(DIR_FS_INC.'olc_draw_textarea_field.inc.php');
require_once(DIR_FS_INC.'olc_validate_email.inc.php');
require_once(DIR_WS_CLASSES.'class.phpmailer.php');
require_once(DIR_FS_INC.'olc_php_mail.inc.php');


$coID=(int)$_GET['coID'];
$shop_content_query=olc_db_query("SELECT
                     content_group
                     FROM ".TABLE_CONTENT_MANAGER."
                     WHERE content_title='".BOX_INFORMATION_CONTACT."'
                     AND languages_id='".SESSION_LANGUAGE_ID.APOS);
$shop_content_data=olc_db_fetch_array($shop_content_query);
$contact_id=$shop_content_data['content_group'];

$shop_content_query=olc_db_query("SELECT
                     content_id,
                     content_title,
                     content_heading,
                     content_text,
                     content_file
                     FROM ".TABLE_CONTENT_MANAGER."
                     WHERE content_group='".$coID."'
                     AND languages_id='".SESSION_LANGUAGE_ID.APOS);
$shop_content_data=olc_db_fetch_array($shop_content_query);

$breadcrumb->add($shop_content_data['content_title'], olc_href_link(FILENAME_CONTENT.'?coID='.$coID));


if ($coID != $contact_id || $_GET['action']=='success') {
	require(DIR_WS_INCLUDES . 'header.php');
}
$smarty->assign('CONTENT_HEADING',$shop_content_data['content_heading']);
if ($coID == $contact_id) 		//'Kontakt'-Processing
{
	$error = false;
	if (isset($_GET['action']) && ($_GET['action'] == 'send')) {
		if (olc_validate_email(trim($_POST['email']))) {

			olc_php_mail(
			$_POST['email'],
			$_POST['name'],
			CONTACT_US_EMAIL_ADDRESS,
			CONTACT_US_NAME,
			CONTACT_US_FORWARDING_STRING,
			$_POST['email'],
			$_POST['name'],
			'',
			'',
			CONTACT_US_EMAIL_SUBJECT,
			nl2br($_POST['message_body']),
			$_POST['message_body']
			);

			if (!isset($mail_error)) {
				olc_redirect(olc_href_link(FILENAME_CONTENT, 'action=success&coID='.$coID));
			}
			else {
				$smarty->assign('error_message',$mail_error);
			}
		} else {
			// error report hier einbauen
			$smarty->assign('error_message',ERROR_MAIL);
			$error = true;
		}
	}
	$smarty->assign('CONTACT_HEADING',$shop_content_data['content_title']);
	if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
		$smarty->assign('success','1');
		$smarty->assign('BUTTON_CONTINUE',HTML_A_START.olc_href_link(FILENAME_DEFAULT).'">'.
		olc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE).HTML_A_END);
	} else {
		if ($shop_content_data['content_file']!=''){
			if (strpos($shop_content_data['content_file'],'.txt')) echo '<pre>';
			include(DIR_FS_CATALOG.'media/content/'.$shop_content_data['content_file']);
			if (strpos($shop_content_data['content_file'],'.txt')) echo '</pre>';
		} else {
			$contact_content= $shop_content_data['content_text'];
		}
		require(DIR_WS_INCLUDES . 'header.php');
		$smarty->assign('CONTACT_CONTENT',$contact_content);
		$smarty->assign('FORM_ACTION',olc_draw_form('contact_us', olc_href_link(FILENAME_CONTENT, 'action=send&coID='.$coID)));
		$smarty->assign('INPUT_NAME',olc_draw_input_field('name', ($error ? $_POST['name'] : $first_name)));
		$smarty->assign('INPUT_EMAIL',olc_draw_input_field('email', ($error ? $_POST['email'] : $email_address)));
		$smarty->assign('INPUT_TEXT',olc_draw_textarea_field('message_body', 'soft', 50, 15, $_POST['']));
		$smarty->assign('BUTTON_SUBMIT',olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
	}

	$main_content= $smarty->fetch(CURRENT_TEMPLATE_MODULE . 'contact_us'.HTML_EXT,SMARTY_CACHE_ID);
} else {
	if ($shop_content_data['content_file']!='')
	{
		ob_start();
		if (strpos($shop_content_data['content_file'],'.txt')) echo '<pre>';
		include(DIR_FS_CATALOG.'media/content/'.$shop_content_data['content_file']);
		if (strpos($shop_content_data['content_file'],'.txt')) echo '</pre>';
		$smarty->assign('file',ob_get_contents());
		ob_end_clean();
	} else {
		$content_body = $shop_content_data['content_text'];
	}
	if (SESSION_LANGUAGE == 'german')
	{
		require_once(DIR_FS_INC.'olc_silbentrennung.inc.php');
		$content_body=olc_silbentrennung($content_body);
	}
	$smarty->assign('CONTENT_BODY',$content_body);
	//W. Kaiser - AJAX
	$is_popup=isset($_GET['pop_up']);
	if ($is_popup)
	{
		$button="button_window_close.gif";
		$button_action="window.close();";
	}
	else
	{
		$button="button_continue_shopping.gif";
		$button_action=(USE_AJAX)? $button_action="button_left()":"history.back(1)";
	}
	$smarty->assign('BUTTON_CONTINUE','<a href="javascript:'.$button_action.'">'.
	olc_image_button($button, IMAGE_BUTTON_BACK).HTML_A_END);
	//W. Kaiser - AJAX
	$main_content= $smarty->fetch(CURRENT_TEMPLATE_MODULE . 'content'.HTML_EXT,SMARTY_CACHE_ID);
}
if ($is_popup)
{
	echo $main_content;
}
else
{
	$smarty->assign(MAIN_CONTENT,$main_content);
	require(BOXES);
$smarty->display(INDEX_HTML);
}
?>