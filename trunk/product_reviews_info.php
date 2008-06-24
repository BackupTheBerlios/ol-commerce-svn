<?php
/* -----------------------------------------------------------------------------------------
 $Id: product_reviews_info.php,v 1.1.1.1.2.1 2007/04/08 07:16:18 gswkaiser Exp $

 OL-Commerce Version 5.x/AJAX
 http://www.ol-commerce.com, http://www.seifenparadies.de

 Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
 -----------------------------------------------------------------------------------------
 based on:
 (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 (c) 2002-2003 osCommerce(product_reviews_info.php,v 1.47 2003/02/13); www.oscommerce.com
 (c) 2003	    nextcommerce (product_reviews_info.php,v 1.12 2003/08/17); www.nextcommerce.org
 (c) 2004      XT - Commerce; www.xt-commerce.com

  Released under the GNU General Public License
 ---------------------------------------------------------------------------------------*/

include( 'includes/application_top.php');
     
// include needed functions
require_once(DIR_FS_INC.'olc_break_string.inc.php');
require_once(DIR_FS_INC.'olc_date_long.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');

// lets retrieve all $HTTP_GET_VARS keys and values..
$get_params = olc_get_all_get_params(array('reviews_id'));
$get_params = substr($get_params, 0, -1); //remove trailing &

$reviews_query = olc_db_query("select rd.reviews_text, r.reviews_rating, r.reviews_id, r.products_id, r.customers_name, r.date_added, r.last_modified, r.reviews_read, p.products_id, pd.products_name, p.products_image from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd left join " . TABLE_PRODUCTS . " p on (r.products_id = p.products_id) left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on (p.products_id = pd.products_id and pd.language_id = '". SESSION_LANGUAGE_ID . "') where r.reviews_id = '" . (int)$_GET['reviews_id'] . "' and r.reviews_id = rd.reviews_id and p.products_status = '1'");
if (!olc_db_num_rows($reviews_query)) olc_redirect(olc_href_link(FILENAME_REVIEWS));
$reviews = olc_db_fetch_array($reviews_query);
$breadcrumb->add(NAVBAR_TITLE_PRODUCT_REVIEWS, olc_href_link(FILENAME_PRODUCT_REVIEWS, $get_params));
olc_db_query(SQL_UPDATE . TABLE_REVIEWS . " set reviews_read = reviews_read+1 where reviews_id = '" . $reviews['reviews_id'] . APOS);
$reviews_text = olc_break_string(htmlspecialchars($reviews['reviews_text']), 60, '-<br/>');

require(DIR_WS_INCLUDES . 'header.php');

$smarty->assign('PRODUCTS_NAME',$reviews['products_name']);
$smarty->assign('AUTHOR',$reviews['customers_name']);
$smarty->assign('DATE',olc_date_long($reviews['date_added']));
$smarty->assign('REVIEWS_TEXT',nl2br($reviews_text));
$smarty->assign('RATING',olc_image(DIR_WS_IMAGES . 'stars_' . $reviews['reviews_rating'] . '.gif', 
sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $reviews['reviews_rating'])));
$link=olc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $reviews['products_id'],NONSSL,false,true,false);
$smarty->assign('PRODUCTS_LINK',$link);
$smarty->assign('BUTTON_BACK',HTML_A_START . olc_href_link(FILENAME_PRODUCT_REVIEWS, $get_params) . '">' . 
olc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . HTML_A_END);
$smarty->assign('PRODUCTS_BUTTON_BUY_NOW',HTML_A_START . olc_href_link(FILENAME_DEFAULT, 
'action=buy_now&BUYproducts_id=' . $reviews['products_id']) . '">' . olc_image_button('button_in_cart.gif', IMAGE_BUTTON_IN_CART).HTML_A_END);
$smarty->assign('IMAGE',HTML_A_START.'javascript:popupImageWindow(\''. olc_href_link(FILENAME_POPUP_IMAGE, 'pID=' . $reviews['products_id']).'\')">'. 
olc_image(DIR_WS_THUMBNAIL_IMAGES . $reviews['products_image'], $reviews['products_name'], '', '', 'align="center" hspace="5" vspace="5"').'<br/></a>');
$main_content= $smarty->fetch(CURRENT_TEMPLATE_MODULE . 'product_reviews_info'.HTML_EXT,SMARTY_CACHE_ID);
require(BOXES);
$smarty->display(INDEX_HTML);
?>