<?php
/* -----------------------------------------------------------------------------------------
$Id: product_reviews.php,v 1.1.1.1.2.1 2007/04/08 07:18:02 gswkaiser Exp $

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

olc_smarty_init($module_smarty,$cacheid);
// include needed functions
require_once(DIR_FS_INC.'olc_image_button.inc.php');
require_once(DIR_FS_INC.'olc_row_number_format.inc.php');
require_once(DIR_FS_INC.'olc_date_short.inc.php');

$info_smarty->assign('options',$products_options_data);
$reviews_query = olc_db_query(SELECT_COUNT." as count from " . TABLE_REVIEWS . " where products_id = '" . (int)$_GET['products_id'] . APOS);
$reviews = olc_db_fetch_array($reviews_query);
if ($reviews['count'] > 0) {

	//fsk18 lock
	$fsk_lock='';
	if ($_SESSION['customers_status']['customers_fsk18_display']=='0') {
		$fsk_lock=' and p.products_fsk18!=1';
	}
	$product_info_query = olc_db_query("select pd.products_name from " . TABLE_PRODUCTS_DESCRIPTION . " pd left join " .
	 TABLE_PRODUCTS . " p on pd.products_id = p.products_id where pd.language_id = '" . SESSION_LANGUAGE_ID .
	 "' and p.products_status = '1' ".$fsk_lock." and pd.products_id = '" . (int)$_GET['products_id'] . APOS);
	if (!olc_db_num_rows($product_info_query)) olc_redirect(olc_href_link(FILENAME_REVIEWS));
	$product_info = olc_db_fetch_array($product_info_query);


	$reviews_query = olc_db_query("select
                                 r.reviews_rating,
                                 r.reviews_id,
                                 r.customers_name,
                                 r.date_added,
                                 r.last_modified,
                                 r.reviews_read,
                                 rd.reviews_text
                                 from " . TABLE_REVIEWS . " r,
                                 ".TABLE_REVIEWS_DESCRIPTION ." rd
                                 where r.products_id = '" . (int)$_GET['products_id'] . "'
                                 and  r.reviews_id=rd.reviews_id
                                 and rd.languages_id = '".SESSION_LANGUAGE_ID."'
                                 order by reviews_id DESC");
	if (olc_db_num_rows($reviews_query)) {
		$row = 0;
		$data_reviews=array();
		while ($reviews = olc_db_fetch_array($reviews_query)) {
			$row++;
			$data_reviews[]=array(
			'AUTHOR'=>$reviews['customers_name'],
			'DATE'=>olc_date_short($reviews['date_added']),
			'RATING'=>olc_image(DIR_WS_IMAGES . 'stars_' . $reviews['reviews_rating'] . '.gif',
			sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $reviews['reviews_rating'])),
			'TEXT'=>$reviews['reviews_text']);
			if ($row==PRODUCT_REVIEWS_VIEW) break;
		}
	}
	$module_smarty->assign('BUTTON_WRITE',HTML_A_START . olc_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'products_id=' .
	$_GET['products_id']) . '">' . olc_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . HTML_A_END);
	$module_smarty->assign(MODULE_CONTENT,$data_reviews);
	$module= $module_smarty->fetch(CURRENT_TEMPLATE_MODULE . 'products_reviews'.HTML_EXT,$cacheid);
	$info_smarty->assign('MODULE_products_reviews',$module);
}
?>