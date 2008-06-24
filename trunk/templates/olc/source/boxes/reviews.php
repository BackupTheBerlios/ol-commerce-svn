<?php
/* -----------------------------------------------------------------------------------------
$Id: reviews.php,v 1.1 2004/02/07 23:02:54 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(reviews.php,v 1.36 2003/02/12); www.oscommerce.com
(c) 2003	    nextcommerce (reviews.php,v 1.9 2003/08/17 22:40:08); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

olc_smarty_init($box_smarty,$cacheid);
if ($is_checkout_shipping)
{
	if (IS_AJAX_PROCESSING)
	{
		$box_reviews=HTML_NBSP;
	}
}
else
{
	$products_id_text='products_id=';
	// include needed functions
	require_once(DIR_FS_INC.'olc_random_select.inc.php');
	require_once(DIR_FS_INC.'olc_break_string.inc.php');
	//fsk18 lock
	if ($_SESSION['customers_status']['customers_fsk18_display']=='0')
	{
		$fsk_lock=' and p.products_fsk18!=1';
	}
	else
	{
		$fsk_lock=EMPTY_STRING;
	}
	$languages_id="languages_id = '" . SESSION_LANGUAGE_ID . APOS;
	$language_id="language_id = '" . SESSION_LANGUAGE_ID . APOS;
	$review_select =
	SELECT."r.reviews_id, r.reviews_rating, p.products_id, p.products_image, pd.products_name from " .
	TABLE_REVIEWS . " r, " .
	TABLE_REVIEWS_DESCRIPTION . " rd, " .
	TABLE_PRODUCTS . " p, " .
	TABLE_PRODUCTS_DESCRIPTION . " pd
	where
	p.products_status = '1' and
	p.products_id = r.products_id ".$fsk_lock. " and
	r.reviews_id = rd.reviews_id and
	rd.".$languages_id .	" and
	p.products_id = pd.products_id and
	pd.".$language_id;
	$products_id=(int)$_GET['products_id'];
	if ($products_id)
	{
		$review_select .= " and p.products_id = '" . $products_id . APOS;
	}
	$review_select .= " order by r.reviews_id desc limit " . MAX_RANDOM_SELECT_REVIEWS;
	$random_product = olc_random_select($review_select);
	if ($random_product && sizeof($random_product)>0)
	{		// display random review box
		$reviews_id=$random_product['reviews_id'];
		$review_query = olc_db_query(SELECT."substring(reviews_text, 1, 60) as reviews_text from " .
		TABLE_REVIEWS_DESCRIPTION .	" where reviews_id = '" . $reviews_id .	"' and ".$languages_id);
		$review = olc_db_fetch_array($review_query);
		$review = htmlspecialchars($review['reviews_text']);
		$review = olc_break_string($review, 15, DASH.HTML_BR);
		$parameters=$products_id_text .$random_product['products_id'] . '&reviews_id=' . $reviews_id;
		$link=olc_href_link(FILENAME_PRODUCT_REVIEWS_INFO, $parameters);
		$link=HTML_A_START . $link . '">';
		$products_name=$random_product['products_name'];
		$reviews_rating=$random_product['reviews_rating'];
		$box_content = '
<div align="center">
' . $link .olc_image(DIR_WS_THUMBNAIL_IMAGES . $random_product['products_image'], $products_name) .'
	</a>
</div>
' . $link . $review .' ..</a>
<br/>
<div align="center">' .
		olc_image(DIR_WS_IMAGES . 'stars_' . $reviews_rating . '.gif' ,
		sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $reviews_rating)) . '
</div>';
	}
	elseif ($products_id)
	{
		//require_once(DIR_FS_INC.'olc_get_products_name.inc.php');
		// display 'write a review' box
		$box_content0='
		<td class="infoBoxContents">
			<a href="' . olc_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, $products_id_text . $products_id) . '">#</a>
		</td>
';
		$box_content='
<table border="0" cellspacing="0" cellpadding="2">
	<tr>
'.
		str_replace(HASH,olc_image(DIR_WS_IMAGES . 'box_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW),$box_content0).
		str_replace(HASH,sprintf(BOX_REVIEWS_WRITE_REVIEW,$products_name),$box_content0).'
	</tr>
</table>
';
	}
}
$box_content.=HTML_BR.'
<div align="center">
'.BULLET.HTML_NBSP.
HTML_A_START.olc_href_link(FILENAME_REVIEWS).'">'.TEXT_MORE_REVIEWS.HTML_A_END.'
</div>';
//$box_smarty->assign('REVIEWS_LINK',olc_href_link(FILENAME_REVIEWS));
$box_smarty->assign('BOX_CONTENT', $box_content);
$box_reviews= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_reviews'.HTML_EXT,$cacheid);
$smarty->assign('box_REVIEWS',$box_reviews);
?>