<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_prepare_products_listing.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:39 gswkaiser Exp $Id:

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(product_listing.php,v 1.42 2003/05/27); www.oscommerce.com
(c) 2003	    nextcommerce (product_listing.php,v 1.19 2003/08/1); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$Entries=MAX_DISPLAY_SEARCH_RESULTS;
$products_listing_simple=false;
$products_use_random_data=false;
$products_listing_template=EMPTY_STRING;
unset($module_smarty);
$is_listing=true;
include(DIR_FS_INC.'olc_prepare_products_listing_info.inc.php');
if ($products_listing_entries>0)
{
	$show_list=true;
}
else
{
	$show_list=CURRENT_SCRIPT<>FILENAME_ADVANCED_SEARCH_RESULT;
}
if ($show_list)
{
	$module_smarty->assign(MODULE_CONTENT,$module_content);
	if (!$ignore_scripts)
	{
		$ignore_scripts=FILENAME_XSELL_PRODUCTS . FILENAME_ALSO_PURCHASED_PRODUCTS . FILENAME_ADVANCED_SEARCH_RESULT;
	}
	if (strpos($ignore_scripts,CURRENT_SCRIPT)===false)
	{
		$m_cPath=$_GET['cPath'];
		if ($m_cPath)
		{
			if ($current_category_id != 0)
			{
				$s='CAT_HTML';
				if (defined($s) && CAT_HTML<>EMPTY_STRING)
				{
					$module_smarty->assign($s,CAT_HTML);
				}
				else
				{
					if (DO_GROUP_CHECK)
					{
						$group_check=" c.".SQL_GROUP_CONDITION.SQL_AND;
					}
					$category_query = olc_db_query("
					select
				  cd.categories_description,
				  cd.categories_name,
				  cd.categories_heading_title,
				  c.listing_template,
				  c.categories_image from " .
					TABLE_CATEGORIES . " c, " .
					TABLE_CATEGORIES_DESCRIPTION . " cd
				  where
				  c.categories_id = " . $current_category_id . " and
				  cd.categories_id = " . $current_category_id .SQL_AND.
					$group_check."
				  cd.language_id = " . SESSION_LANGUAGE_ID);
					$category = olc_db_fetch_array($category_query);
					$categories_image=$category['categories_image'];
					if ($categories_image)
					{
						$products_image =DIR_WS_IMAGES.'categories/'.$categories_image;
						$module_smarty->assign('CATEGORIES_IMAGE',$products_image );
					}
					$categories_name=$category['categories_name'];
					$categories_description=$category['categories_description'];
					$categories_heading_title=$category['categories_heading_title'];
				}
			}
			$module_smarty->assign('MANUFACTURER_DROPDOWN',$manufacturer_dropdown);
		}
		else if ($manufacturers_id)
		{
			$categories_name=BOX_ENTRY_PRODUCTS.BLANK.ENTRY_MANUFACTURERS.' "'.$global_manufacturers_name.QUOTE;
			$categories_description=EMPTY_STRING;
			$module_smarty->assign('UseSearchVersion', true);
			$global_manufacturers_text=EMPTY_STRING;
		}
		if (strlen($categories_name)>0)
		{
			$categories_name.=LPAREN.$my_products_listing_entries.RPAREN;
			if ($global_manufacturers_text)
			{
				$categories_name.='<br/><font size="2">'.$global_manufacturers_text.'</font>';
			}
			$module_smarty->assign('CATEGORIES_NAME',$categories_name);
			$module_smarty->assign('CATEGORIES_DESCRIPTION',$categories_description);
			$module_smarty->assign('CATEGORIES_HEADING_TITLE',$categories_heading_title);
			$categories_name=EMPTY_STRING;
			$categories_description=EMPTY_STRING;
		}
		if ($my_products_listing_entries>$Entries)
		{
			$my_navigation = '
				<table border="0" width="100%" cellspacing="0" cellpadding="2">
				  <tr>
				    <td class="smallText">' .
			$products_listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS).'
						</td>
				    <td class="smallText" align="right">'.TEXT_RESULT_PAGE . BLANK .
			$products_listing_split->display_links(MAX_DISPLAY_PAGE_LINKS,
			olc_get_all_get_params(array('page', 'info'))).'
						</td>
				  </tr>
				</table>';
			$module_smarty->assign('NAVIGATION',$my_navigation);
			$module_smarty->assign('DISPLAY_SHORT_LIST_BUTTONS',$is_listing);
		}
	}
	if ($front_page)
	{
		$module_smarty->assign('header','header_top');
	}
	$module= $module_smarty->fetch($products_listing_template,SMARTY_CACHE_ID);
	$smarty->assign(MAIN_CONTENT,$module);
	$is_listing=false;
}
else
{
	$error=TEXT_NO_PRODUCTS;
	include(DIR_WS_MODULES . FILENAME_ERROR_HANDLER);
}
//W. Kaiser - AJAX
?>