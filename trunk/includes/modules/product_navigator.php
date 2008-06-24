<?php
/* -----------------------------------------------------------------------------------------
$Id: product_navigator.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/


olc_smarty_init($module_smarty,$cacheid);

$products_id_text='products_id';
$products_id_param_text=$products_id_text.EQUAL;
$products_cat_query=olc_db_query("
SELECT
categories_id
FROM ".TABLE_PRODUCTS_TO_CATEGORIES."
WHERE products_id='".(int)$_GET[$products_id_text].APOS);
$products_cat=olc_db_fetch_array($products_cat_query);

// select products
//fsk18 lock
$fsk_lock='';
if ($_SESSION['customers_status']['customers_fsk18_display']=='0') {
	$fsk_lock=' and p.products_fsk18!=1';
}
$products_query=olc_db_query("
SELECT
pc.products_id
FROM ".TABLE_PRODUCTS_TO_CATEGORIES." pc,
".TABLE_PRODUCTS." p

WHERE categories_id='".$products_cat['categories_id']."'
and p.products_id=pc.products_id
and p.products_status=1
".$fsk_lock);
$i=0;
while ($products_data=olc_db_fetch_array($products_query)) 
{
	$p_data[$i]=array('pID'=>$products_data[$products_id_text]);
	if ($products_data[$products_id_text]==$_GET[$products_id_text]) $actual_key=$i;
	$i++;
}
// check if array key = first
if ($actual_key==0) {
	// aktuel key = first product
} else {
	$prev_id=$actual_key-1;
	$prev_link=
		olc_href_link(FILENAME_PRODUCT_INFO, $products_id_param_text . $p_data[$prev_id]['pID'],NONSSL,false);
	// check if prev id = first
	if ($prev_id!=0) {
		$first_link=
			olc_href_link(FILENAME_PRODUCT_INFO, $products_id_param_text . $p_data[0]['pID'],NONSSL,false);
	}
}
// check if key = last
if ($actual_key<>(sizeof($p_data)-1)) 
{
	$next_id=$actual_key+1;
	$next_link=
		olc_href_link(FILENAME_PRODUCT_INFO, $products_id_param_text .$p_data[$next_id]['pID'],NONSSL,false);
	// check if next id = last
	if ($next_id!=(sizeof($p_data)-1)) 
	{
		$last_link=
			olc_href_link(FILENAME_PRODUCT_INFO, $products_id_param_text .
			$p_data[(sizeof($p_data)-1)]['pID'],NONSSL,false);
	}
}
$s1='">'.HASH.HTML_A_END.HTML_NBSP;
$s2='" title="';
$first_link=HTML_A_START.$first_link.$s2.TEXT_NAVIGATION_FIRST.$s1;
$prev_link=HTML_A_START.$prev_link.$s2.TEXT_NAVIGATION_PREVIOUS.$s1;;
$next_link=HTML_A_START.$next_link.$s2.TEXT_NAVIGATION_NEXT.$s1;;
$last_link=HTML_A_START.$last_link.$s2.TEXT_NAVIGATION_LAST.$s1;;
$s=CURRENT_TEMPLATE_BUTTONS.'button_product_';
$first_image=$s.'first.gif';
if (file_exists($first_image))
{
	$first_link=str_replace(HASH,olc_image($first_image),$first_link);
	$prev_link=str_replace(HASH,olc_image($s.'previous.gif'),$prev_link);
	$next_link=str_replace(HASH,olc_image($s.'next.gif'),$next_link);
	$last_link=str_replace(HASH,olc_image($s.'last.gif'),$last_link);
}
else 
{
	$s='product_navigator';
	$first_link=str_replace(HASH,olc_get_smarty_config_variable($module_smarty,$s,'first'),$first_link);
	$prev_link=str_replace(HASH,olc_get_smarty_config_variable($module_smarty,$s,'back'),$prev_link);
	$next_link=str_replace(HASH,olc_get_smarty_config_variable($module_smarty,$s,'next'),$next_link);
	$last_link=str_replace(HASH,olc_get_smarty_config_variable($module_smarty,$s,'last'),$last_link);
}
$module_smarty->assign('FIRST',$first_link);
$module_smarty->assign('PREVIOUS',$prev_link);
$module_smarty->assign('NEXT',$next_link);
$module_smarty->assign('LAST',$last_link);

$module_smarty->assign('PRODUCTS_COUNT',count($p_data));
$product_navigator= $module_smarty->fetch(CURRENT_TEMPLATE_MODULE . 'product_navigator'.HTML_EXT,$cacheid);
$info_smarty->assign('PRODUCT_NAVIGATOR',$product_navigator);
?>