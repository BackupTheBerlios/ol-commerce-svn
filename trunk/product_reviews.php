<?php
/* -----------------------------------------------------------------------------------------
$Id: product_reviews.php,v 1.1.1.1.2.1 2007/04/08 07:16:18 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(product_reviews.php,v 1.47 2003/02/13); www.oscommerce.com
(c) 2003	    nextcommerce (product_reviews.php,v 1.12 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include( 'includes/application_top.php');

// include needed functions
require_once(DIR_FS_INC.'olc_image_button.inc.php');
require_once(DIR_FS_INC.'olc_row_number_format.inc.php');
require_once(DIR_FS_INC.'olc_date_short.inc.php');

// lets retrieve all $HTTP_GET_VARS keys and values..
$get_params = olc_get_all_get_params();
$get_params_back = olc_get_all_get_params(array('reviews_id')); // for back button
$get_params = substr($get_params, 0, -1); //remove trailing &
if (olc_not_null($get_params_back)) {
	$get_params_back = substr($get_params_back, 0, -1); //remove trailing &
} else {
	$get_params_back = $get_params;
}
$product_info_query = olc_db_query("select pd.products_name from " .
TABLE_PRODUCTS_DESCRIPTION . " pd left join " . TABLE_PRODUCTS . " p on pd.products_id = p.products_id where pd.language_id = '" . SESSION_LANGUAGE_ID . "' and p.products_status = '1' and pd.products_id = '" . (int)$_GET['products_id'] . APOS);
if (!olc_db_num_rows($product_info_query)) olc_redirect(olc_href_link(FILENAME_REVIEWS));
$product_info = olc_db_fetch_array($product_info_query);
$breadcrumb->add(NAVBAR_TITLE_PRODUCT_REVIEWS, olc_href_link(FILENAME_PRODUCT_REVIEWS, $get_params));
require(DIR_WS_INCLUDES . 'header.php');
$smarty->assign('PRODUCTS_NAME',$product_info['products_name']);
$data_reviews=array();
$reviews_query = olc_db_query("select reviews_rating, reviews_id, customers_name, date_added, last_modified, reviews_read from " . TABLE_REVIEWS . " where products_id = '" . (int)$_GET['products_id'] . "' order by reviews_id DESC");
if (olc_db_num_rows($reviews_query)) {
	$row = 0;
	while ($reviews = olc_db_fetch_array($reviews_query)) {
		$row++;
		$data_reviews[]=array(
		'id' => $reviews['reviews_id'],
		'AUTHOR'=> HTML_A_START . olc_href_link(FILENAME_PRODUCT_REVIEWS_INFO, $get_params . '&reviews_id=' .
		$reviews['reviews_id']) . '">' . $reviews['customers_name'] . HTML_A_END,
		'DATE'=>olc_date_short($reviews['date_added']),
		'RATING'=>olc_image(DIR_WS_IMAGES . 'stars_' . $reviews['reviews_rating'] . '.gif',
		sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $reviews['reviews_rating'])),
		'TEXT'=>$reviews['reviews_text']);
	}
}
$smarty->assign(MODULE_CONTENT,$data_reviews);
$link=olc_href_link(FILENAME_PRODUCT_INFO, $get_params_back,NONSSL,false,true,false);
$smarty->assign('BUTTON_BACK',HTML_A_START . $link . '">' . 
olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END);
$smarty->assign('BUTTON_WRITE',HTML_A_START . olc_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, $get_params) . '">' .
 olc_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . HTML_A_END);
$main_content= $smarty->fetch(CURRENT_TEMPLATE_MODULE . 'product_reviews'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>