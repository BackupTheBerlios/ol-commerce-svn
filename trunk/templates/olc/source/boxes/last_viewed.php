<?php
/* -----------------------------------------------------------------------------------------
$Id: last_viewed.php 1292 2005-10-07 16:10:55Z mz $

XT-Commerce - community made shopping
http://www.xt-commerce.com

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(specials.php,v 1.30 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (specials.php,v 1.10 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

if (isset($_SESSION[TRACKING][PRODUCTS_HISTORY][0]))
{
	olc_smarty_init($box_smarty,$cache_id);
	// include needed functions
	require_once(DIR_FS_INC . 'olc_rand.inc.php');
	require_once(DIR_FS_INC . 'olc_get_path.inc.php');
	require_once(DIR_FS_INC . 'olc_get_products_name.inc.php');
	$max = count($_SESSION[TRACKING][PRODUCTS_HISTORY])-1;
	$random_last_viewed = olc_rand(0,$max);
	//fsk18 lock
	if ($_SESSION['customers_status']['customers_fsk18_display']=='0')
	{
		$fsk_lock=' and p.products_fsk18!=1';
	}
	if (DO_GROUP_CHECK)
	{
		$group_check=" and p.".SQL_GROUP_CONDITION;
	}
	$products_id=(int)$_SESSION[TRACKING][PRODUCTS_HISTORY][$random_last_viewed];
	$random_query = SELECT."
	p.products_id,
	pd.products_name,
	p.products_price,
	p.products_tax_class_id,
	p.products_image,
	p.products_vpe,
	p.products_vpe_status,
	p.products_vpe_value,
	p2c.categories_id,
	cd.categories_name
	from " .
	TABLE_PRODUCTS . " p,	" .
	TABLE_PRODUCTS_DESCRIPTION . " pd," .
	TABLE_PRODUCTS_TO_CATEGORIES . " p2c,	" .
	TABLE_CATEGORIES_DESCRIPTION . " cd
	where
	p.products_status = 1
	and p.products_id = ".$products_id."
	and pd.products_id = ".$products_id."
	and p2c.products_id = ".$products_id."
	and pd.language_id = " . SESSION_LANGUAGE_ID . "
	and cd.categories_id = p2c.categories_id ".
	$group_check.
	$fsk_lock."
	and cd.language_id = " . SESSION_LANGUAGE_ID;
	$random_query = olc_db_query($random_query);
	$random_product = olc_db_fetch_array($random_query,true);


	if (CUSTOMER_SHOW_PRICE)
	{
		$random_products_price=abs($random_product['products_price']);
		$tax_class=$random_product['products_tax_class_id'];
		if (OL_COMMERCE)
		{
			$olPrice=round($random_products_price,CURRENCY_DECIMAL_PLACES);
			include_once (DIR_FS_INC.'olc_get_vpe_and_baseprice_info.inc.php');
			$vpe=array();
			olc_get_vpe_and_baseprice_info($vpe,$random_product,$olPrice);
			$vpe=$vpe['PRODUCTS_VPE'];
			include(DIR_FS_INC.'olc_get_price_disclaimer.inc.php');
			$tax_info=$price_disclaimer;
			if (CUSTOMER_SHOW_PRICE_TAX)
			{
				$random_products_price=olc_add_tax($random_products_price, $tax_class);
			}
		}
		else
		{
	   	$random_products_price_real=$random_products_price;
			if (!is_object($product)) {
				$product = new product();
			}
			$vpe=$product->getVPEtext($random_product, $random_products_price);
			$random_products_price=$xtPrice->xtcFormat($random_products_price, true,$tax_class, true, false);
			$tax_info=$main->getTaxInfo(olc_get_tax_rate($tax_class));
			$picture_disclaimer=EMPTY_STRING;
		}
	}
	$categories_id=$random_product['categories_id'];
	$products_name=$random_product['products_name'];
	if ($products_name)
	{
		$category_path = olc_get_path($categories_id);
		$categories_name=$random_product['categories_name'];
		$image=$random_product['products_image'];
		if ($image)
		{
			$image=olc_image(DIR_WS_THUMBNAIL_IMAGES . $image,$products_name);
		}
		$products_id_par='products_id=' . $products_id;
		$link=HTML_A_START.olc_href_link(FILENAME_PRODUCT_INFO, $products_id_par). '">';
		$box_content=
		$link .
		olc_image(DIR_WS_THUMBNAIL_IMAGES . $image, $products_name) . HTML_A_END.HTML_BR.
		$link . $products_name . HTML_A_END.HTML_BR . $random_products_price;
		$box_smarty->assign('LINK',$link);
		$box_smarty->assign('IMAGE',$image);
		$box_smarty->assign('NAME',$products_name);
		$box_smarty->assign('PRICE',$random_products_price);
		$box_smarty->assign('TAX_INFO',$tax_info);

		$box_smarty->assign('BOX_CONTENT', $box_content);
		//$box_smarty->assign('MY_PAGE', TEXT_MY_PAGE);
		//$box_smarty->assign('WATCH_CATGORY', TEXT_WATCH_CATEGORY);
		$box_smarty->assign('MY_PERSONAL_PAGE',olc_href_link(FILENAME_ACCOUNT,'products_history=true'));
		$box_smarty->assign('CATEGORY_LINK',olc_href_link(FILENAME_DEFAULT,
		olc_category_link($categories_id,$categories_name)));
		$box_smarty->assign('CATEGORY_NAME',$categories_name);
		$box_last_viewed= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_last_viewed'.HTML_EXT,$cache_id);
		$smarty->assign('box_LAST_VIEWED',$box_last_viewed);
	}
}
?>