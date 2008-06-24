<?php
/* -----------------------------------------------------------------------------------------
$Id: product_reviews_write.php,v 1.1.1.1.2.1 2007/04/08 07:16:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(product_reviews_write.php,v 1.51 2003/02/13); www.oscommerce.com
(c) 2003	    nextcommerce (product_reviews_write.php,v 1.13 2003/08/1); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include( 'includes/application_top.php');
if (!isset($_SESSION['customer_id'])) {

	olc_redirect(olc_href_link(FILENAME_LOGIN));
}

// include needed function
require_once(DIR_FS_INC.'olc_draw_textarea_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_radio_field.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');
require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_selection_field.inc.php');
$rating_text='rating';
$product_query = olc_db_query("select pd.products_name, p.products_image from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$_GET['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . SESSION_LANGUAGE_ID . "' and p.products_status = '1'");
$valid_product = (olc_db_num_rows($product_query) > 0);
if ($_GET['action'] == 'process') {
	if ($valid_product == true) { // We got to the process but it is an illegal product, don't write
	$customer = olc_db_query("select customers_firstname, customers_lastname from " . TABLE_CUSTOMERS .
		" where customers_id = '" . (int)$_SESSION['customer_id'] . APOS);
	$customer_values = olc_db_fetch_array($customer);
	$date_now = date('Ymd');
	if ($customer_values['customers_lastname']=='') $customer_values['customers_lastname']=TEXT_GUEST ;
	olc_db_query(
	INSERT_INTO . TABLE_REVIEWS . " (products_id, customers_id, customers_name, reviews_rating, date_added
	) values ('" .
	(int)$_GET['products_id'] . "', '" . (int)$_SESSION['customer_id'] . "', '" .
	addslashes($customer_values['customers_firstname']) . BLANK . addslashes($customer_values['customers_lastname']) . "', '" .
	$_POST[$rating_text] . "', now())");
	$insert_id = olc_db_insert_id();
	olc_db_query(INSERT_INTO . TABLE_REVIEWS_DESCRIPTION . " (reviews_id, languages_id, reviews_text) values ('" .
	$insert_id . "', '" . SESSION_LANGUAGE_ID . "', '" . $_POST['review'] . "')");
	}
	olc_redirect(olc_href_link(FILENAME_PRODUCT_REVIEWS, $_POST['get_params']));
}
// lets retrieve all $HTTP_GET_VARS keys and values..
$get_params = olc_get_all_get_params();
$get_params_back = olc_get_all_get_params(array('reviews_id')); // for back button
$get_params = substr($get_params, 0, -1); //remove trailing &
if (olc_not_null($get_params_back)) {
	$get_params_back = substr($get_params_back, 0, -1); //remove trailing &
} else {
	$get_params_back = $get_params;
}

$breadcrumb->add(NAVBAR_TITLE_REVIEWS_WRITE, olc_href_link(FILENAME_PRODUCT_REVIEWS, $get_params));
$customer_info_query = olc_db_query("select customers_firstname, customers_lastname from " .
	TABLE_CUSTOMERS . " where customers_id = '" . (int)$_SESSION['customer_id'] . APOS);
$customer_info = olc_db_fetch_array($customer_info_query);

require(DIR_WS_INCLUDES . 'header.php');

if ($valid_product == false) {
	$smarty->assign('error',ERROR_INVALID_PRODUCT);

} else {
	$product_info = olc_db_fetch_array($product_query);
	$name = $customer_info['customers_firstname'] . BLANK . $customer_info['customers_lastname'];
	if ($name==BLANK) $customer_info['customers_lastname'] = TEXT_GUEST;
	$smarty->assign('PRODUCTS_NAME',$product_info['products_name']);
	$smarty->assign('AUTHOR',$customer_info['customers_firstname'] . BLANK . $customer_info['customers_lastname']);
	$smarty->assign('INPUT_TEXT',olc_draw_textarea_field('review', 'soft', 60, 15,EMPTY_STRING,'style="font-size:12px;"'));
	$smarty->assign('INPUT_RATING',
		olc_draw_radio_field($rating_text, '1') . BLANK .
		olc_draw_radio_field($rating_text, '2') . BLANK .
		olc_draw_radio_field($rating_text, '3') . BLANK .
		olc_draw_radio_field($rating_text, '4') . BLANK .
		olc_draw_radio_field($rating_text, '5',true));
	//W. Kaiser - AJAX
	$smarty->assign('FORM_ACTION',olc_draw_form('product_reviews_write',
	olc_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'action=process&products_id=' . $_GET['products_id']),
	'post', 'onsubmit="return checkForm(\'product_reviews_write\');"'));
	$smarty->assign('BUTTON_BACK',HTML_A_START . olc_href_link(FILENAME_PRODUCT_REVIEWS, $get_params_back) . '">' .
	olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END);
	//W. Kaiser - AJAX
	$smarty->assign('BUTTON_SUBMIT',olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE).
	olc_draw_hidden_field('get_params', $get_params));
}
$main_content= $smarty->fetch(CURRENT_TEMPLATE_MODULE.'product_reviews_write'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>