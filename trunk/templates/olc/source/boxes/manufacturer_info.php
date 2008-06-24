<?php
/* -----------------------------------------------------------------------------------------
$Id: manufacturer_info.php,v 1.2 2004/02/17 16:20:07 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(manufacturer_info.php,v 1.10 2003/02/12); www.oscommerce.com
(c) 2003	    nextcommerce (manufacturer_info.php,v 1.6 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
olc_smarty_init($box_smarty,$cacheid);
$products_id=$_GET['products_id'];
if ($products_id || $manufacturers_id)
{
	if ($products_id)
	{
		$condition="p.products_id = '".$products_id."' and p.manufacturers_id = m.manufacturers_id";
		$products_table=", ".TABLE_PRODUCTS." p";
	}
	else
	{
		$condition="m.manufacturers_id = '".$manufacturers_id.APOS;
		$products_table=EMPTY_STRING;
	}
	$manufacturer_query =
	olc_db_query("select m.manufacturers_id, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url from " .
	TABLE_MANUFACTURERS." m
	left join ".TABLE_MANUFACTURERS_INFO." mi
	on (m.manufacturers_id = mi.manufacturers_id and mi.languages_id = '".SESSION_LANGUAGE_ID."')" .
	$products_table."	where ".$condition);
	if (olc_db_num_rows($manufacturer_query))
	{
		$manufacturer = olc_db_fetch_array($manufacturer_query);
		$manufacturers_name=$manufacturer['manufacturers_name'];
		$homepage=trim(sprintf(BOX_MANUFACTURER_INFO_HOMEPAGE, $manufacturers_name));
		$manufacturers_image=$manufacturer['manufacturers_image'];
		if ($manufacturers_image)
		{
			$manufacturers_image=DIR_WS_IMAGES.str_replace('%20',BLANK,$manufacturers_image);
			if (file_exists($manufacturers_image))
			{
				$manufacturers_image=olc_image($manufacturers_image, $homepage);
			}
		}
		$manufacturers_url=$manufacturer['manufacturers_url'];
		if ($manufacturers_url)
		{
			$manufacturers_url=HTML_A_START.$manufacturers_url.'" target="_blank">';
			if ($manufacturers_image)
			{
				$manufacturers_image=$manufacturers_url.$manufacturers_image. HTML_A_END;
			}
			$manufacturers_url=$manufacturers_url.$homepage.HTML_A_END;
		}
		if ($products_id)
		{
			$manufacturers_info=HTML_A_START.olc_href_link(FILENAME_DEFAULT,
			'manufacturers_id=' .$manufacturer['manufacturers_id']).'">'.
			BOX_MANUFACTURER_INFO_OTHER_PRODUCTS.HTML_BR.$global_manufacturers_text.HTML_A_END;
			$box_smarty->assign('BOX_CONTENT',$manufacturers_info);
		}
		$box_smarty->assign('MANUFACTURERS_IMAGE',$manufacturers_image);
		$box_smarty->assign('MANUFACTURERS_URL',$manufacturers_url);
		$box_smarty->assign('SHOW_BULLET',true);
	}
	$box_manufacturers_info=$box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_manufacturers_info'.HTML_EXT,$cacheid);
}
else
{
	$box_manufacturers_info='<font style="font-size=1px;"> </font>';
}
$smarty->assign('box_MANUFACTURERS_INFO',$box_manufacturers_info);
?>