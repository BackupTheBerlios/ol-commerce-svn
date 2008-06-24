<?php
/* -----------------------------------------------------------------------------------------
$Id: account_newsletters.php,v 1.1.1.1.2.1 2007/04/08 07:16:02 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(account_newsletters.php,v 1.2 2003/05/22); www.oscommerce.com
(c) 2003	    nextcommerce (account_newsletters.php,v 1.13 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include( 'includes/application_top.php');

// include needed functions
require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_selection_field.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');

if (!isset($_SESSION['customer_id'])) {

	olc_redirect(olc_href_link(FILENAME_LOGIN, '', SSL));
}



$newsletter_query = olc_db_query("select customers_newsletter from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$_SESSION['customer_id'] . APOS);
$newsletter = olc_db_fetch_array($newsletter_query);

if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
	if (isset($_POST['newsletter_general']) && is_numeric($_POST['newsletter_general'])) {
		$newsletter_general = olc_db_prepare_input($_POST['newsletter_general']);
	} else {
		$newsletter_general = '0';
	}

	if ($newsletter_general != $newsletter['customers_newsletter']) {
		$newsletter_general = (($newsletter['customers_newsletter'] == '1') ? '0' : '1');

		olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS . " set customers_newsletter = '" . (int)$newsletter_general . "' where customers_id = '" . (int)$_SESSION['customer_id'] . APOS);
	}
	$messageStack->add_session('account', SUCCESS_NEWSLETTER_UPDATED, 'success');

	olc_redirect(olc_href_link(FILENAME_ACCOUNT));
}

$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_NEWSLETTERS, olc_href_link(FILENAME_ACCOUNT, '', SSL));
$breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_NEWSLETTERS, olc_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', SSL));

require(DIR_WS_INCLUDES . 'header.php');

$smarty->assign('FORM_ACTION',olc_draw_form('account_newsletter', olc_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', SSL)) . olc_draw_hidden_field('action', 'process'));
$smarty->assign('CHECKBOX',olc_draw_checkbox_field('newsletter_general', '1', (($newsletter['customers_newsletter'] == '1') ? true : false), 'onclick="javascript:checkBox(\'newsletter_general\')"'));
$smarty->assign('BUTTON_BACK',HTML_A_START . olc_href_link(FILENAME_ACCOUNT, '', SSL) . '">' . olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END);
$smarty->assign('BUTTON_CONTINUE',olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));

$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'account_newsletter'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>