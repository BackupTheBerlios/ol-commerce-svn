<?php
/* -----------------------------------------------------------------------------------------
$Id: reviews.php,v 1.1.1.1.2.1 2007/04/08 07:16:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(reviews.php,v 1.48 2003/05/27); www.oscommerce.com
(c) 2003	    nextcommerce (reviews.php,v 1.12 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include('includes/application_top.php');

// include needed functions
require_once(DIR_FS_INC.'olc_word_count.inc.php');
require_once(DIR_FS_INC.'olc_date_long.inc.php');

$breadcrumb->add(NAVBAR_TITLE_REVIEWS, olc_href_link(FILENAME_REVIEWS));

require(DIR_WS_INCLUDES . 'header.php');

$reviews_query_raw = "
select r.reviews_id,
left(rd.reviews_text, 250) as reviews_text,
r.reviews_rating,
r.date_added,
p.products_id,
pd.products_name,
p.products_image,
r.customers_name
from " .
TABLE_REVIEWS . " r, " .
TABLE_REVIEWS_DESCRIPTION . " rd, " .
TABLE_PRODUCTS . " p, " .
TABLE_PRODUCTS_DESCRIPTION . " pd
where
p.products_status = 1 and
p.products_id = r.products_id and
r.reviews_id = rd.reviews_id and
p.products_id = pd.products_id and
pd.language_id = " . SESSION_LANGUAGE_ID . " and
rd.languages_id = " . SESSION_LANGUAGE_ID . "
order by r.reviews_id DESC";
$reviews_split = new splitPageResults($reviews_query_raw, $_GET['page'], MAX_DISPLAY_NEW_REVIEWS);

if (($reviews_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3')))
{
	$smarty->assign('NAVBAR','
	<table border="0" width="100%" cellspacing="0" cellpadding="2">
	  <tr>
	    <td class="smallText">'. $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS).'</td>
	    <td align="right" class="smallText">'.TEXT_RESULT_PAGE . BLANK .
				$reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS,
				olc_get_all_get_params(array('page', 'info', 'x', 'y'))).'</td>
	  </tr>
	</table>
');
}
$module_data=array();
if ($reviews_split->number_of_rows > 0)
{
	$reviews_query = olc_db_query($reviews_split->sql_query);
	while ($reviews = olc_db_fetch_array($reviews_query))
	{
		$module_data[]=array(
		'PRODUCTS_IMAGE' =>DIR_WS_THUMBNAIL_IMAGES . $reviews['products_image'], $reviews['products_name'],
		'PRODUCTS_LINK' => olc_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $reviews['products_id'] .
		'&reviews_id=' . $reviews['reviews_id']),
		'PRODUCTS_NAME' => $reviews['products_name'],
		'AUTHOR' => $reviews['customers_name'],
		'TEXT' => sprintf(TEXT_REVIEW_WORD_COUNT, olc_word_count($reviews['reviews_text'], BLANK)) . ')<br/>' .
		htmlspecialchars($reviews['reviews_text']) . '..',
		'RATING' => olc_image(DIR_WS_IMAGES . 'stars_' . $reviews['reviews_rating'] . '.gif',
		sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $reviews['reviews_rating'])));
	}
	$smarty->assign(MODULE_CONTENT,$module_data);
}
$main_content= $smarty->fetch(CURRENT_TEMPLATE_MODULE . 'reviews'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>