<?php
/* -----------------------------------------------------------------------------------------
$Id: products_promotion.php,v 1.1.1.1 2006/12/22 13:43:03 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
All rights reserved!

N o t (!) released under the GNU General Public License
---------------------------------------------------------------------------------------*/

if (DO_PROMOTION)
{
	$products_listing_sql_main =olc_standard_products_query(EMPTY_STRING)."
and p.products_promotion = '1'
and p.products_price >= 0
ORDER BY p.products_id DESC";
	unset($module_smarty);
	$smarty_config_section='products_promotion';
	$products_listing_template=$smarty_config_section.HTML_EXT;
	$breadcrumb_link=FILENAME_PROMOTION_PRODUCTS;
	$categories_name=TEXT_CAT_PROMOTION_PRODUCTS;
	$categories_description=TEXT_OUR_PROMOTION_PRODUCTS;
	$force_stand_alone=!$force_stand_alone_deny;
	$ignore_scripts=CURRENT_SCRIPT;
	$is_promotion=true;
	include(DIR_FS_INC.'olc_prepare_specials_whatsnew_modules.inc.php');
	$force_stand_alone=false;

	/*
	olc_smarty_init($module_smarty,$cacheid);
	$pp_query_sql=
	$pp_query = olc_dbquery($pp_query_sql);
	$row = 0;
	$pp_modul = array();
	while($pp_data = olc_db_fetch_array(&$pp_query,true))
	{
		$products_image = EMPTY_STRING;
		$products_promotion_image = EMPTY_STRING;
		$products_price=olc_format_price($pp_data['products_price'],true,true);
		// MwSt.
		if (CUSTOMER_SHOW_PRICE)
		{
			$product_tax = olc_get_tax_rate($product['products_tax_class_id']);
			if ($product_tax > 0)
			{
				if (CUSTOMER_SHOW_PRICE_TAX)
				{
					$tax_info = sprintf(TAX_INFO_INCL, $product_tax.' %');
				}
				else
				{
					if ($_SESSION['customers_status']['customers_status_add_tax_ot'] == 1)
					{
						$tax_info = sprintf(TAX_INFO_ADD, $product_tax.' %');
					}
					else
					{
						$tax_info = sprintf(TAX_INFO_EXCL, $product_tax.' %');
					}
				}
			}
		}

		if (SHOW_SHIPPING=='true') {
			$module_smarty->assign('PRODUCTS_SHIPPING_LINK',' '.SHIPPING_EXCL.'<a href="javascript:newWin=void(window.open(\EMPTY_STRING.olc_href_link(FILENAME_POPUP_CONTENT, 'coID='.SHIPPING_INFOS).'\', \'popup\', \'toolbar=0, width=640, height=600\'))"> '.SHIPPING_COSTS.'</a>');
		}

		// VPE
		if ($pp_data['products_vpe_status'] == 1 && $pp_data['products_vpe_value'] != 0.0 && $products_price['plain'] > 0){
			$vpe = $xtPrice->xtcFormat($products_price['plain'] * (1 / $pp_data['products_vpe_value']), true).TXT_PER.olc_get_vpe_name($pp_data['products_vpe']);
		}

		if ($_SESSION['customers_status']['customers_status_show_price'] != '0') {  //--- status
			$price = $xtPrice->xtcGetPrice($pp_data['products_id'],$format=true,1,$pp_data['products_tax_class_id'],$pp_data['products_price']); }

			if ($pp_data['products_promotion_image']!=EMPTY_STRING) {  //--- promotion grafik
				$products_promotion_image = DIR_WS_IMAGES . 'products_promotion/' . $pp_data['products_promotion_image'];
			} elseif ($pp_data['products_image']!=EMPTY_STRING) {    //--- produkt bild
				$products_image = DIR_WS_THUMBNAIL_IMAGES . $pp_data['products_image']; }

				$pp_modul[] = array(
				'PRODUCT_NAME' 						=> $pp_data['products_name'],
				'PRODUCT_LINK'   					=> olc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $pp_data['products_id'].$SEF_parameter),
				'PRODUCT_MODEL' 					=> $pp_data['products_model'],
				'PRODUCT_QTY' 						=> $pp_data['products_quantity'],
				'PRODUCT_IMAGE' 					=> $products_image,
				'PRODUCT_DATE_AVAILABLE' 	=> $pp_data['products_date_available'],
				'PRODUCT_WEIGHT' 					=> $pp_data['products_weight'],
				'PRODUCT_FSK18' 					=> $pp_data['products_fsk18'],
				'PRODUCT_PRICE' 					=> $price,
				'PRODUCTS_TAX_INFO' 			=> $tax_info,
				'PRODUCTS_VPE'						=> $vpe,
				'PRODUCT_DESCRIPTION' 		=> $pp_data['products_description'],
				'PRODUCT_SHORT_DESCRIPTION' 		=> $pp_data['products_short_description'],
				// Herstellerlink
				'PRODUCT_URL' 									=> $pp_data['products_url'],

				'PRODUCT_PROMOTION_SHOW_TITLE' 	=> $pp_data['products_promotion_show_title'],
				'PRODUCT_PROMOTION_SHOW_DESCRIPTION' 		=> $pp_data['products_promotion_show_desc'],
				// PROMOTION
				'PRODUCT_PROMOTION_TITLE' 			=> $pp_data['products_promotion_title'],
				'PRODUCT_PROMOTION_DESCRIPTION' => $pp_data['products_promotion_desc'],
				'PRODUCT_PROMOTION_IMAGE' 			=> $products_promotion_image
				);
				$row ++;

	}
	$module_smarty->assign('language', $_SESSION['language']);
	$module_smarty->assign('promotion_modul', $pp_modul);
	$pp_template = olc_db_fetch_array(&$pp_query,true);

	$module = $module_smarty->fetch(CURRENT_TEMPLATE_.'/module/product_promotion/promotion.html', $cache_id);
	}
	$default_smarty->assign('MODULE_products_promotion',$module);

*/
}
?>