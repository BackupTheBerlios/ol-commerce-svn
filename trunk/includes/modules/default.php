<?php
/* -----------------------------------------------------------------------------------------
$Id: default.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(default.php,v 1.84 2003/05/07); www.oscommerce.com
(c) 2003	    nextcommerce (default.php,v 1.11 2003/08/22); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
------------------------------------------------------------------------------------------
Third Party contributions:
Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

if (!$ajax_init)
{
	olc_smarty_init($default_smarty,$cacheid);
	$default_smarty->assign('session',session_id());
	$main_content = EMPTY_STRING;
	// include needed functions
	require_once(DIR_FS_INC.'olc_customer_greeting.inc.php');
	require_once(DIR_FS_INC.'olc_get_path.inc.php');
	require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
	require_once(DIR_FS_INC.'olc_check_categories_status.inc.php');
	require_once(DIR_FS_INC.'olc_image_button.inc.php');

	if (olc_check_categories_status($current_category_id)>=1)
	{
		$error=CATEGORIE_NOT_FOUND;
		include(DIR_WS_MODULES . FILENAME_ERROR_HANDLER);
	}
	else
	{
		if (DO_GROUP_CHECK)
		{
			$group_check_c=" and c.".SQL_GROUP_CONDITION;
			$group_check_p=" and p.".SQL_GROUP_CONDITION;
		}
		$manufacturers_id=$_GET['manufacturers_id'];
		$filter_id=$_GET['filter_id'];
		$is_nested=$category_depth == 'nested';
		//if ((true || $is_nested) && $current_category_id)
		if ($is_nested)
		{
			$category_query = olc_db_query("
			select
      c.categories_image,
      c.categories_template,
      cd.categories_name,
      cd.categories_description,
      cd.categories_heading_title
      from ".
			TABLE_CATEGORIES . " c, " .
			TABLE_CATEGORIES_DESCRIPTION . " cd
      where
      c.categories_id = " . $current_category_id . "
      and cd.categories_id = " . $current_category_id .
			$group_check_c."
      and cd.language_id =" . SESSION_LANGUAGE_ID);
			$category = olc_db_fetch_array($category_query);
			$cat_image_dir=DIR_WS_IMAGES.'categories/';
			$default_smarty->assign('CATEGORIES_NAME',$category['categories_name']);
			$image=$category['categories_image'];
			if ($image)
			{
				$image=$cat_image_dir.$image;
			}
			$default_smarty->assign('CATEGORIES_IMAGE',$image);
			$default_smarty->assign('CATEGORIES_DESCRIPTION',$category['categories_description']);
			$default_smarty->assign('CATEGORIES_HEADING_TITLE',$category['categories_heading_title']);
			if ($is_nested)
			{
				if (SHOW_CENTER)
				{
					$new_products_category_id=$current_category_id;
					include(DIR_WS_INCLUDES.FILENAME_CENTER_MODULES);
					$default_smarty->assign('MODULE_new_products',$smarty->_tpl_vars[MAIN_CONTENT]);
					unset($smarty->_tpl_vars[MAIN_CONTENT]);
				}
			}
			// check to see if there are deeper categories within the current category
			$categories_query_sql = "
			select
      c.categories_id,
      cd.categories_name,
      c.categories_image,
      c.parent_id from " .
			TABLE_CATEGORIES . " c, " .
			TABLE_CATEGORIES_DESCRIPTION . " cd
      where c.categories_status = 1
      and c.parent_id = #
      and c.categories_id = cd.categories_id".
			$group_check_c."
      and cd.language_id = " . SESSION_LANGUAGE_ID . "
      order by sort_order, cd.categories_name";
			$category_links = array_reverse($cPath_array);
			for ($i = 0, $n = sizeof($category_links); $i < $n; $i++)
			{
				$categories_query = olc_db_query(str_replace(HASH,$category_links[$i],$categories_query_sql));
				if (olc_db_num_rows($categories_query) >0)
				{
					// we've found the deepest category the customer is in
					break;
				}
			}
			while ($categories = olc_db_fetch_array($categories_query))
			{
				$cPath_new = olc_get_path($categories['categories_id']);
				//$width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW) . '%';
				$categories_name=$categories['categories_name'];
				$image=$categories['categories_image'];
				if ($image)
				{
					$image=olc_image($cat_image_dir.$image,$categories_name,200,200);
				}
				$categories_content[]=array(
				'CATEGORIES_NAME' => $categories_name,
				'CATEGORIES_IMAGE' => $image,
				'CATEGORIES_LINK' => olc_href_link(FILENAME_DEFAULT, $cPath_new,NONSSL,false,true,false),
				'CATEGORIES_DESCRIPTION' => $categories['categories_description']);
			}
			$default_smarty->assign(MODULE_CONTENT,$categories_content);
			// get default template
			$module_dir=CURRENT_TEMPLATE_MODULE . 'categorie_listing/';
			$directory=TEMPLATE_PATH.$module_dir;
			$categories_template=$category['categories_template'];
			if ($categories_template==EMPTY_STRING || $categories_template=='default')
			{
				$files=olc_get_templates($directory);
				$categories_template=$files[0]['id'];
			}
			$default_smarty->caching = 0;
			$main_content= $default_smarty->fetch($module_dir.$categories_template);
			if ($is_nested)
			{
				$smarty->assign(MAIN_CONTENT,$main_content);
			}
			elseif ($main_content)
			{
				define('CAT_HTML',$main_content);
			}
		}
		if ($category_depth == 'products' || $manufacturers_id)
		{
			//fsk18 lock
			if (CUSTOMER_IS_FSK18)
			{
				$fsk_lock=' and p.products_fsk18!=1';
			}
			else
			{
				$fsk_lock=EMPTY_STRING;
			}
			// show the products of a specified manufacturer
			if ($manufacturers_id)
			{
				if ($filter_id)
				{
					// sorting query
					$sorting_query=olc_db_query("
					SELECT products_sorting,
					products_sorting2 FROM ".
					TABLE_CATEGORIES."
	        where
	        categories_id=".$filter_id);
					$sorting_data=olc_db_fetch_array($sorting_query);
					$products_sorting=$sorting_data['products_sorting'];
					if (!$products_sorting)
					{
						$products_sorting='pd.products_name';
					}
					$sorting=SQL_ORDER_BY.$products_sorting.BLANK.$sorting_data['products_sorting2'];
					// We are asked to show only a specific category
					$listing_sql =
					SELECT.
					PRODUCTS_FIELDS.COMMA."
					m.manufacturers_name
					from " .
					TABLE_PRODUCTS . " p inner join " .
					TABLE_PRODUCTS_DESCRIPTION . " pd inner join " .
					TABLE_MANUFACTURERS . " m inner join " .
					TABLE_PRODUCTS_TO_CATEGORIES . " p2c left join " .
					TABLE_SPECIALS . " s on p.products_id = s.products_id
					where
					p.products_status = '1'
					and p.manufacturers_id = m.manufacturers_id
					and m.manufacturers_id = " . $manufacturers_id . "
					and p.products_id = p2c.products_id
					and pd.products_id = p2c.products_id
					".$group_check_c."
					and pd.language_id = " . SESSION_LANGUAGE_ID .$fsk_lock."
					and p2c.categories_id = " . $filter_id . $sorting;
				} else {
					// We show them all
					$listing_sql =
					SELECT.
					PRODUCTS_FIELDS.COMMA."
					m.manufacturers_name
					from " .
					TABLE_PRODUCTS . " p inner join " .
					TABLE_PRODUCTS_DESCRIPTION . " pd inner join " .
					TABLE_MANUFACTURERS . " m left join " .
					TABLE_SPECIALS . " s on p.products_id = s.products_id
	        where p.products_status = '1'
	        and pd.products_id = p.products_id
	        ".$group_check_p."
	        and pd.language_id = " . SESSION_LANGUAGE_ID . "
	        and p.manufacturers_id = m.manufacturers_id ".$fsk_lock."
	        and m.manufacturers_id = " . $manufacturers_id;
				}
			} else {
				// show the products in a given categorie
				if ($filter_id)
				{
					// sorting query
					$sorting_query=olc_db_query("
					SELECT
					products_sorting,
          products_sorting2
          FROM ".
					TABLE_CATEGORIES."
		      where
		      categories_id=".$current_category_id);
					$sorting_data=olc_db_fetch_array($sorting_query);
					$products_sorting=$sorting_data['products_sorting'];
					if (!$products_sorting)
					{
						$products_sorting='pd.products_name';
					}
					$sorting=SQL_ORDER_BY.$products_sorting.BLANK.$sorting_data['products_sorting2'];
					// We are asked to show only specific catgeory
					$listing_sql =
					SELECT.
					PRODUCTS_FIELDS.COMMA."
					m.manufacturers_name
					from " .
					TABLE_PRODUCTS . " p inner join " .
					TABLE_PRODUCTS_DESCRIPTION . " pd inner join " .
					TABLE_MANUFACTURERS . " m inner join " .
					TABLE_PRODUCTS_TO_CATEGORIES . " p2c left join " .
					TABLE_SPECIALS . " s on p.products_id = s.products_id
					where p.products_status = '1'
					and p.manufacturers_id = m.manufacturers_id
					and m.manufacturers_id = " . $filter_id . "
					and p.products_id = p2c.products_id
					and pd.products_id = p2c.products_id
					".$group_check_p."
					and pd.language_id = " . SESSION_LANGUAGE_ID . $fsk_lock."
					and p2c.categories_id = " . $current_category_id . $sorting;
				}
				else
				{
					// sorting query
					$sorting_query=olc_db_query("
					SELECT
					products_sorting,
          products_sorting2
          FROM ".
					TABLE_CATEGORIES."
          where categories_id=".$current_category_id);
					$sorting_data=olc_db_fetch_array($sorting_query);
					if (!$sorting_data['products_sorting'])
					{
						$sorting_data['products_sorting']='pd.products_name';
					}
					$sorting=' ORDER BY '.$sorting_data['products_sorting'].BLANK.$sorting_data['products_sorting2'].BLANK;
					// We show them all
					$listing_sql =
					SELECT.
					PRODUCTS_FIELDS.SQL_FROM.
					TABLE_PRODUCTS_DESCRIPTION . " pd inner join " .
					TABLE_PRODUCTS . " p left join " .
					TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id inner join " .
					TABLE_PRODUCTS_TO_CATEGORIES . " p2c
					left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id
					where
					p.products_status = 1
					and p.products_id = p2c.products_id
					and pd.products_id = p2c.products_id".
					$group_check_p."
					and pd.language_id = " . SESSION_LANGUAGE_ID .$fsk_lock."
					and p2c.categories_id = " . $current_category_id .$sorting;
				}
			}
			// optional Product List Filter
			if (PRODUCT_LIST_FILTER > 0)
			{
				if ($manufacturers_id)
				{
					$filterlist_sql = "
					select
					c.categories_id as id,
					cd.categories_name as name
					from " .
					TABLE_PRODUCTS . " p, " .
					TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " .
					TABLE_CATEGORIES . " c, " .
					TABLE_CATEGORIES_DESCRIPTION . " cd
					where
					p.products_status = 1 and
					p.products_id = p2c.products_id and
					p2c.categories_id = c.categories_id and
					p2c.categories_id = cd.categories_id and
					cd.language_id = " . SESSION_LANGUAGE_ID . " and
					p.manufacturers_id = " . $manufacturers_id ."
					order by cd.categories_name";
				}
				else
				{
					$filterlist_sql = "
					select
					m.manufacturers_id as id,
					m.manufacturers_name as name
					from " .
					TABLE_PRODUCTS . " p, " .
					TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " .
					TABLE_MANUFACTURERS . " m
					where
					p.products_status = 1 and
					p.manufacturers_id = m.manufacturers_id and
					p.products_id = p2c.products_id and
					p2c.categories_id = " . $current_category_id . "
					order by m.manufacturers_name";
				}
				$filterlist_query = olc_db_query($filterlist_sql);
				if (olc_db_num_rows($filterlist_query) > 1)
				{
					$form_name_text='filter';
					require_once(DIR_FS_INC.'olc_draw_pull_down_menu.inc.php');
					$manufacturer_dropdown= olc_draw_form($form_name_text, FILENAME_DEFAULT, 'GET') .HTML_NBSP;
					if ($manufacturers_id)
					{
						$manufacturer_dropdown.= olc_draw_hidden_field('manufacturers_id', $manufacturers_id);
						$options = array(array('text' => TEXT_ALL_CATEGORIES));
					} else {
						$manufacturer_dropdown.= olc_draw_hidden_field('cPath', $cPath);
						$options = array(array('text' => TEXT_ALL_MANUFACTURERS));
					}
					$manufacturer_dropdown.= olc_draw_hidden_field('sort', $_GET['sort']);
					while ($filterlist = olc_db_fetch_array($filterlist_query)) {
						$options[] = array('id' => $filterlist['id'], 'text' => $filterlist['name']);
					}
					if (USE_AJAX)
					{
						$onchange="make_AJAX_Request_POST('".$form_name_text."','".FILENAME_DEFAULT."')";
					}
					else
					{
						$onchange='this.form.submit()';
					}
					$manufacturer_dropdown.= olc_draw_pull_down_menu('filter_id', $options, $filter_id,'onchange="'.$onchange.'"');
					$manufacturer_dropdown.= '</form>' . NEW_LINE;
				}
				else
				{
					$filterlist=olc_db_fetch_array($filterlist_query);
					$manufacturers_id=$filterlist['id'];
				}
			}
			// Get the right image for the top-right
			$image = DIR_WS_IMAGES . 'table_background_list.gif';
			if ($manufacturers_id)
			{
				$image = olc_db_query("
				select
				manufacturers_image
				from" .
				TABLE_MANUFACTURERS ."
				where
				manufacturers_id = " . $manufacturers_id);
				$image = olc_db_fetch_array($image);
				$image = $image['manufacturers_image'];
			}
			elseif ($current_category_id)
			{
				$image = olc_db_query("
				select
				categories_image
				from" .
				TABLE_CATEGORIES ."
				where
				categories_id = " . $current_category_id);
				$image = olc_db_fetch_array($image);
				$image = $image['categories_image'];
			}
			include(DIR_WS_MODULES.FILENAME_PRODUCT_LISTING);
		}
		else
		{ // default page
			$shop_content_query=olc_db_query("
			SELECT
			content_title,
			content_heading,
			content_text,
			content_file
			FROM ".
			TABLE_CONTENT_MANAGER."
			WHERE
			content_group='5' AND
			languages_id=".SESSION_LANGUAGE_ID);
			$shop_content_data=olc_db_fetch_array($shop_content_query);
			$default_smarty->assign('title',$shop_content_data['content_heading']);
			if (SHOW_CENTER)
			{
				include(DIR_WS_INCLUDES.FILENAME_CENTER_MODULES);
			}
			$content_file=$shop_content_data['content_file'];
			if ($content_file!=EMPTY_STRING){
				ob_start();
				if (strpos($content_file,'.txt'))
				{
					echo '<pre>';
					$set_pre=true;
				}
				include(DIR_FS_CATALOG.'media/content/'.$content_file);
				if ($set_pre)
				{
					echo '</pre>';
				}
				$shop_content_data['content_text']=ob_get_contents();
				ob_end_clean();
			}
			$content_text=$shop_content_data['content_text'];
			if (IS_MULTI_SHOP)
			{
				$set_pre="ausstellungen.php";
				$content_text=
				str_replace($set_pre,$set_pre.QUESTION.DIR_FS_MULTI_SHOP_TEXT.EQUAL.DIR_FS_MULTI_SHOP,$content_text);
			}
			$n=sizeof($slideshow_id);
			if ($n>0)
			{
				$slide_shows=0;
				for ($i=0;$i<$n;$i++)
				{
					if ($slideshow_id[$i])
					{
						$slide_shows++;
						$_GET['type']=$i;
						include('ajax_slideshow.php');
					}
				}
			}
			else
			{
				$slide_shows=0;
			}
			$default_smarty->assign('SLIDE_SHOWS',$slide_shows);
			$default_smarty->assign('text',str_replace('{$greeting}',olc_customer_greeting(),$content_text));
			$main_content= $default_smarty->fetch(CURRENT_TEMPLATE_MODULE .MAIN_CONTENT.HTML_EXT,$cacheid);
			$smarty->assign(MAIN_CONTENT,$main_content);
		}
	}
}
?>