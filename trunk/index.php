<?php
/* -----------------------------------------------------------------------------------------
$Id: index.php,v 1.1.1.2.2.1 2007/04/08 07:16:15 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(index.php,v 1.84 2003/05/07); www.oscommerce.com
(c) 2003	    nextcommerce (index.php,v 1.13 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------*/

include('includes/application_top.php');
if ($force_language)
{
	$snapshot=$_SESSION['navigation']->snapshot;
	if (sizeof($snapshot) > 0)
	{
		$redirect_url = $snapshot['page'];
		if ($redirect_url<>CURRENT_SCRIPT)
		{
			require_once(DIR_FS_INC.'olc_array_to_string.inc.php');
			$redirect_parameters=olc_array_to_string($snapshot['get'],array(olc_session_name()));
			$redirect_mode=$snapshot['mode'];
			$_SESSION['navigation']->clear_snapshot();
			olc_redirect(olc_href_link($redirect_url,$redirect_parameters));
		}
	}
}
if (!$use_ajax_short_list)
{
	$SQLWhere = SQL_WHERE."categories_id = " . $current_category_id;
	//	W. Kaiser	chCounter inclusion
	$call_counter=CHCOUNTER_ACTIVE==true;
	if ($call_counter)
	{
		$chCounter_page_title = EMPTY_STRING;
		$SQLSelect_Category = SELECT."categories_name".SQL_FROM. TABLE_CATEGORIES_DESCRIPTION . $SQLWhere;

		$categories_query = olc_db_query($SQLSelect_Category );
		$categories = olc_db_fetch_array($categories_query);
		$chCounter_page_title = CATEGORY_PAGE . $categories['categories_name'];
	}
	//	W. Kaiser	chCounter inclusion
	$category_depth = 'top';
	if ($cPath )
	{
		$categories_products_query = olc_db_query(SELECT_COUNT."as total from ".
		TABLE_PRODUCTS_TO_CATEGORIES  . $SQLWhere);
		$categories_products = olc_db_fetch_array($categories_products_query);
		if ($categories_products['total'] > 0)
		{
			$category_depth = 'products'; // display products
		}
		else
		{
			$category_parent_query = olc_db_query(
			SELECT_COUNT." as total from " . TABLE_CATEGORIES ."
			where
			parent_id = " . $current_category_id);
			$category_parent = olc_db_fetch_array($category_parent_query);
			if ($category_parent['total'] > 0)
			{
				$category_depth = 'nested'; // navigate through the categories
			}
			else
			{
				$category_depth = 'products'; // category has no products, but display the 'no products' message
			}
		}
	}
	else
	{
		if ($call_counter)
		{
			$s='chcounter_start';
			if (!isset($_SESSION[$s]))
			{
				//	Count start-page (only count once!)
				$_SESSION[$s] =  true;
				$chCounter_page_title = 'Shop Start-Seite';
			}
		}
	}
	require(DIR_WS_INCLUDES . 'header.php');
	include(DIR_WS_MODULES . 'default.php');
	//	W. Kaiser	chCounter inclusion
	if ($call_counter)
	{
		//chCounter for shop statistic -- http://www.christoph-bachner.net/chcounter
		//http://www.christoph-bachner.net/chcounter
		if (!CUSTOMER_IS_ADMIN)	//Only count non-admins!
		{
			if ($chCounter_page_title)
			{
				$chCounter_visible = 0;
				include(FILENAME_CHCOUNTER);
			}
		}
	}
	//	W. Kaiser	chCounter inclusion

}
require(BOXES);
$smarty->display(INDEX_HTML);
?>