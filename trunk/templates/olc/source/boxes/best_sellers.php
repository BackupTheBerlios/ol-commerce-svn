<?php
/* -----------------------------------------------------------------------------------------
$Id: best_sellers.php,v 1.4 2004/03/25 08:31:41 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(best_sellers.php,v 1.20 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (best_sellers.php,v 1.10 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:
Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
// reset var
olc_smarty_init($box_smarty,$cacheid);
$box_content=EMPTY_STRING;

// include needed functions
require_once(DIR_FS_INC . 'olc_row_number_format.inc.php');

//fsk18 lock
$fsk_lock='';
if ($_SESSION['customers_status']['customers_fsk18_display']=='0') {
	$fsk_lock=' and p.products_fsk18!=1';
}
if (GROUP_CHECK==TRUE_STRING_S)
{
	$group_check=" and p.group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
}
$price_check=" and p.products_price > 0";

define('SHOW_MARQUEE_BESTSELLERS',true);
$show_marquee=SHOW_MARQUEE_BESTSELLERS;

$Entries=MAX_DISPLAY_BESTSELLERS;
if ($show_marquee)
{
	$Entries+=$Entries;
}
$best_sellers_sql="
select distinct
p.products_id,
p.products_image,
p.products_price,
p.products_tax_class_id,
p.products_vpe,
p.products_vpe_status,
p.products_vpe_value,
pd.products_name,
pd.products_short_description
from " .
TABLE_PRODUCTS . " p, " .
TABLE_PRODUCTS_DESCRIPTION . " pd,
#".
TABLE_CATEGORIES . " c
where
p.products_status =1
and c.categories_status = 1
and p.products_ordered > 0
and p.products_id = pd.products_id
".
$fsk_lock.
$group_check.
$price_check.
"@
order by p.products_ordered desc, pd.products_name
limit " . 	$Entries;
if (isset($current_category_id) && ($current_category_id > 0))
{
	$r1=TABLE_PRODUCTS_TO_CATEGORIES . " p2c, ";
	$r2="
	and p2c.products_id = p.products_id
	and p2c.categories_id = c.categories_id
	and " . $current_category_id . " in (c.categories_id, c.parent_id)
";
}
else
{
	$r1=EMPTY_STRING;
	$r2=EMPTY_STRING;
}
$best_sellers_sql=str_replace(HASH,$r1 ,$best_sellers_sql);
$best_sellers_sql=str_replace(ATSIGN,$r2,$best_sellers_sql);
$best_sellers_query = olc_db_query($best_sellers_sql);
if (olc_db_num_rows($best_sellers_query) >= MIN_DISPLAY_BESTSELLERS)
{
	$picture_disclaimer=PICTURE_DISCLAIMER;
	$rows = 0;
	$box_content=array();
	while ($best_sellers = olc_db_fetch_array($best_sellers_query))
	{
		$rows++;
		if ($show_marquee)
		{
			$image=$best_sellers['products_image'];
			if ($image)
			{
				$products_short_description=stripslashes($best_sellers['products_short_description']);
				$products_short_description=strip_tags($products_short_description);
				$products_short_description =str_replace(HTML_AMP,AMP,$products_short_description);
				$s=str_replace("\r\n",BLANK,$products_short_description);
				$s=str_replace("\n",BLANK,$s);
				$s=str_replace(BLANK.BLANK,BLANK,$s);
				if (IS_IE)
				{
					$title="\n\n";
				}
				else
				{
					$title=" -- ";
				}
				$title=$products_name.$title.$s.$title. TEXT_FURTHER_INFO;
				$image=olc_image(DIR_WS_THUMBNAIL_IMAGES . $image, $title);
			}
			if (CUSTOMER_SHOW_PRICE)
			{
				$price=abs($best_sellers['products_price']);
				$tax_class=$best_sellers['products_tax_class_id'];
				if (OL_COMMERCE)
				{
					$olPrice=round($price,CURRENCY_DECIMAL_PLACES);
					include_once (DIR_FS_INC.'olc_get_vpe_and_baseprice_info.inc.php');
					$vpe=array();
					olc_get_vpe_and_baseprice_info($vpe,$best_sellers,$olPrice);
					$vpe=$vpe['PRODUCTS_VPE'];
					include(DIR_FS_INC.'olc_get_price_disclaimer.inc.php');
					$tax_info=$price_disclaimer;
					if (CUSTOMER_SHOW_PRICE_TAX)
					{
						$price=olc_add_tax($price, $tax_class);
					}
					$price=olc_format_price($price,true,true);
				}
				else
				{
					if (!is_object($product)) {
						$product = new product();
					}
					$vpe=$product->getVPEtext($best_sellers, $price);
					$price=$xtPrice->xtcFormat($price, true,$tax_class, true, false);
					$tax_info=$main->getTaxInfo(olc_get_tax_rate($tax_class));
					$picture_disclaimer=EMPTY_STRING;
				}
			}
			$box_content[]=array(
			'ID'=> olc_row_number_format($rows),
			'NAME'=> $best_sellers['products_name'],
			'PRICE'=> $price,
			'VPE'=> $vpe,
			'TAX_INFO'=> $tax_info,
			'SHORT_DESCRIPTION'=> $products_short_description,
			'PICTURE_DISCLAIMER'=> $picture_disclaimer,
			'IMAGE' => $image,
			'LINK'=> olc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_sellers['products_id']));
		}
	}
	$box_smarty->assign('SHOW_MARQUEE',$show_marquee);
	$box_smarty->assign('entries_count',sizeof($box_content));
	$box_smarty->assign('box_content', $box_content);
	$box_best_sellers= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_bestsellers'.HTML_EXT,$cacheid);
	$smarty->assign('box_BESTSELLERS',$box_best_sellers);
}
?>