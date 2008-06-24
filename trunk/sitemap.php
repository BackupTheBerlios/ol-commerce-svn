<?php
/* -----------------------------------------------------------------------------------------
$Id: sitemap.php,v 1.1.1.1.2.1 2007/04/08 07:16:19 gswkaiser Exp $

OL-Commerce 2.0
http://www.ol-commerce.de, http://www.seifenparadies.de


Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce; www.oscommerce.com
(c) 2003	    nextcommerce; www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
(c) 2004	 xt-commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include( 'includes/application_top.php');

olc_smarty_init($module_smarty,$cacheid);
require_once(DIR_FS_INC.'olc_count_products_in_category.inc.php');
require_once(DIR_FS_INC.'olc_get_smarty_config_variable.inc.php');

//to get category trees
function get_category_tree($parent_id = '0', $spacing = EMPTY_STRING, $exclude = EMPTY_STRING,
$category_tree_array = EMPTY_STRING, $include_itself = false, $cPath = EMPTY_STRING)
{
	if ($parent_id == 0){ $cPath = EMPTY_STRING; } else {	$cPath .= $parent_id . '_'; }
	if (!is_array($category_tree_array)) $category_tree_array = array();
	if ((sizeof($category_tree_array) < 1) && ($exclude != '0'))
	$category_tree_array[] = array('id' => '0', 'text' => TEXT_TOP);
	if ($include_itself)
	{
		$category_query = olc_db_query("
			select cd.categories_name
			from " . TABLE_CATEGORIES_DESCRIPTION . " cd
			WHERE c.categories_status = '1' AND cd.language_id = '" . SESSION_LANGUAGE_ID .	"'
			and cd.categories_id = '" . $parent_id . APOS);
		$category = olc_db_fetch_array($category_query);
		$category_tree_array[] = array(
		'id' => $parent_id,
		'text' => $category['categories_name']);
	}
	$categories_query = olc_db_query("
		select
		c.categories_id,
		cd.categories_name,
		c.parent_id
		from " . TABLE_CATEGORIES . " c, " .
	TABLE_CATEGORIES_DESCRIPTION . " cd
		where c.categories_id = cd.categories_id
		and cd.language_id = '" .	SESSION_LANGUAGE_ID . "'
		and c.parent_id = '" . $parent_id .	"'
		and c.categories_status = '1'
		order by c.sort_order, cd.categories_name");
	while ($categories = olc_db_fetch_array($categories_query))
	{
		$categories_id=$categories['categories_id'];
		if ($exclude != $categories_id)
		{
			$category_tree_array[] = array(
			'id'    => $categories_id,
			'text'  => $spacing . $categories['categories_name'],
			'link'  => olc_href_link(FILENAME_DEFAULT,'cPath=' . $cPath . $categories_id,NONSSL,false,true,false),
			'pcount'=> olc_count_products_in_category($categories_id)
			);
			$category_tree_array = get_category_tree($categories_id, $spacing . '&nbsp;&nbsp;&nbsp;', $exclude,
			$category_tree_array, false, $cPath);
		}
	}
	return $category_tree_array;
}

$module_content=olc_get_smarty_config_variable($smarty,'sitemap','heading_sitemap');
$breadcrumb->add($module_content, olc_href_link(CURRENT_SCRIPT));
require(DIR_WS_INCLUDES . 'header.php');

if (DO_GROUP_CHECK)
{
	$group_check=" and c.".SQL_GROUP_CONDITION;
}

$categories_query = olc_db_query("
											select c.categories_image,
										  c.categories_id,
    									cd.categories_name FROM
                      " . TABLE_CATEGORIES . " c left join
  									  " . TABLE_CATEGORIES_DESCRIPTION ." cd on c.categories_id = cd.categories_id
                      where c.categories_status = '1'
  									  and cd.language_id = ".SESSION_LANGUAGE_ID."
											and c.parent_id = '0'
                      ".$group_check."
                      order by c.sort_order ASC");

$module_content = array();
$cat_image_dir=DIR_WS_IMAGES . 'categories/';
while ($categories = olc_db_fetch_array($categories_query)) {
	$categories_id=$categories['categories_id'];
	$scats_array=get_category_tree($categories_id, EMPTY_STRING,0);
	$scats=sizeof($scats_array);
	if ($scats>0)
	{
		$pcount=0;
		for ($i=0;$i<$scats;$i++)
		{
			$pcount+=$scats_array[$i]['pcount'];
		}
	}
	else
	{
		$pcount=olc_count_products_in_category($categories_id);
	}
	$categories_name=$categories['categories_name'];
	$categories_image=$categories['categories_image'];
	if ($categories_image!=EMPTY_STRING)
	{
		$categories_image=olc_image($cat_image_dir . $categories_image,$categories_name);
	}
	$module_content[]=array(
	'id'				=> $categories_id,
	'CAT_NAME'  => $categories_name,
	'CAT_IMAGE' => $categories_image,
	'CAT_LINK'  => olc_href_link(FILENAME_DEFAULT,'cPath=' . $categories_id,NONSSL,false,true,false),
	'SCATS'			=> $scats_array,
	'PCOUNT'    => $pcount
	);
}

// if there's sth -> assign it
if (sizeof($module_content)>=1)
{
	$module_smarty->assign(MODULE_CONTENT,$module_content);
	$main_content=$module_smarty->fetch(CURRENT_TEMPLATE_MODULE.'sitemap'.HTML_EXT,$cacheid);
	$smarty->assign(MAIN_CONTENT,$main_content);
	require(BOXES);
$smarty->display(INDEX_HTML);
}
?>