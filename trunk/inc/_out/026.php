<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_box_categories.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:09 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(categories.php,v 1.23 2002/11/12); www.oscommerce.com
(c) 2003	    nextcommerce (categories.php,v 1.10 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:
Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------

Modified by W. Kaiser (w.kaiser@fortune.de) to allow all submenues open always
Modified by W. Kaiser (w.kaiser@fortune.de) to allow "cool menu" usage
Modified by W. Kaiser (w.kaiser@fortune.de) to allow ""tab"-navigation" usage

*/
$use_standard_menue=true;
if (USE_AJAX)
{
	$build_menu=NOT_IS_AJAX_PROCESSING || defined('AJAX_REBUILD_ALL');
	if (SHOW_COOL_MENU==TRUE_STRING_S)
	{
		$use_standard_menue=false;
		if ($build_menu)		//AJAX_REBUILD_ALL is set, when language changes
		{
			olc_smarty_init($box_smarty,$cacheid);
			$box_categories=EMPTY_STRING;
			include_once(box_code_script_path('categories_coolmenu.php'));
			$box_smarty->assign('BOX_CONTENT', $box_categories);
			$box_categories= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_categories'.HTML_EXT,$cacheid);
			$smarty->assign('box_CATEGORIES',$box_categories);
			if (IS_AJAX_PROCESSING)
			{
				$ajax_script_id++;
				define('AJAX_SCRIPT_'.$ajax_script_id,'cool_menu_init();');
			}
		}
	}
	elseif (IS_LOCAL_HOST && SHOW_TAB_NAVIGATION==TRUE_STRING_S)
	{
		$use_standard_menue=false;
		include(box_code_script_path('tab_navigation.php'));
	}
}
else
{
	$build_menu=true;
}
if ($use_standard_menue)
{
	$s='OPEN_ALL_MENUE_LEVELS';
	if (!defined($s))
	{
		define($s,FALSE_STRING_S);
	}
	$open_all_menues=OPEN_ALL_MENUE_LEVELS==TRUE_STRING_S;		//Open all submenues always.
	if (!$build_menu)
	{
		$build_menu=!$open_all_menues;
	}
	if ($build_menu)
	{
		$html_blank=array(HTML_NBSP,strtoupper(HTML_NBSP));
		$html_break=array(HTML_BR,strtoupper(HTML_BR),"<p>","<P>");
		$$text_break="\n ";
		// include needed functions
		require_once(box_code_script_path('inc/olc_show_category.inc.php'));
		require_once(DIR_FS_INC.'olc_has_category_subcategories.inc.php');
		require_once(DIR_FS_INC.'olc_count_products_in_category.inc.php');

		olc_smarty_init($box_smarty,$cacheid);
		$box_content=EMPTY_STRING;

		$all_categories_string = EMPTY_STRING;
		if (DO_GROUP_CHECK)
		{
			$group_check=" and c.".SQL_GROUP_CONDITION;
		}

		//W. Kaiser

		$not_open_all_menues=!$open_all_menues;
		$prev_id	='prev_id';
		$categories_id='categories_id';
		$categories_name='categories_name';
		$categories_heading_title='categories_heading_title';
		$next_id_text='next_id';
		$parent_id_text='parent_id';
		$name_text='name';
		$title_text='title';
		$parent_text='parent';
		$level_text='level';
		$path_text='path';
		$categories_query_sql0="
		select
		c.categories_id,
		cd.categories_name,
		cd.categories_heading_title,
		c.parent_id from " .
		TABLE_CATEGORIES . " c, " .
		TABLE_CATEGORIES_DESCRIPTION . " cd
		where
		c.categories_status = 1
		and c.parent_id = #
		@
		and c.categories_id = cd.categories_id
		and cd.language_id=" . SESSION_LANGUAGE_ID .
		" order by c.sort_order, cd.categories_name";

		//Select all  t o p  - level menues
		$categories_query_sql=str_replace(HASH,ZERO_STRING,$categories_query_sql0);
		$categories_query_sql=str_replace(ATSIGN,$group_check,$categories_query_sql);
		$categories_query = olc_db_query($categories_query_sql);
		$categories_count = olc_db_num_rows($categories_query);
		while ($categories = olc_db_fetch_array($categories_query))
		{
			$id=$categories[$categories_id];
			$categories_ids[]=$id;
			$name=$categories[$categories_name];
			$title=$categories[$categories_heading_title];
			if ($title==EMPTY_STRING)
			{
				$title=$name;
			}
			$title=clean_title($title);
			$name=clean_title($name);
			$foo[$id] = array(
			$name_text => $name,
			$title_text=>$title,
			$parent_text => 0,
			$path_text => $id,
			$next_id_text => false);
			if ($not_open_all_menues)
			{
				if (isset($prev_id)) 	{
					$foo[$prev_id][$next_id_text] =$id;
				}
			}
			$prev_id = $id;
			if (!isset($first_element)) {
				$first_element = $prev_id;	//$categories[$categories_id];
			}
		}
		$categories_query_sql0=str_replace(ATSIGN,EMPTY_STRING,$categories_query_sql0);
		//------------------------
		$realcPath=$cPath;
		if ($open_all_menues)
		{
			//Select all  t o p  - level menues
			if ($categories_count==0)
			{
				$open_all_menues=false;			//Fall back to normal processing
			}
		}
		else
		{
			$categories_count=1;
			if (!$cPath)
			{
				$cPath=$_GET['cPath'];
			}
		}
		for ($categorie=0;$categorie<$categories_count;$categorie++)
		{
			if ($open_all_menues)
			{
				$cPath=$categories_ids[$categorie];
				$first_element=$cPath;
			}
			if ($cPath)
			{
				$categories_string = EMPTY_STRING;
				$id = explode(UNDERSCORE, $cPath);
				$new_path = EMPTY_STRING;
				while (list($key, $value) = each($id))
				{
					unset($prev_id);
					unset($first_id);
					$categories_query_sql=str_replace(HASH,$value,$categories_query_sql0);
					$categories_query = olc_db_query($categories_query_sql);
					if (olc_db_num_rows($categories_query) > 0)
					{
						$new_path .= $value;
						while ($row = olc_db_fetch_array($categories_query)) {
							$name=$row[$categories_name];
							$title=$row[$categories_heading_title];
							if ($title==EMPTY_STRING)
							{
								$title=$name;
							}
							$title=clean_title($title);
							$foo[$row[$categories_id]] = array(
							$name_text => $name,
							$parent_text => $row[$parent_id_text],
							$title_text=>$title,
							$level_text => $key+1,
							$path_text => $new_path . UNDERSCORE . $row[$categories_id],
							$next_id_text => false);
							if (isset($prev_id)) {
								$foo[$prev_id][$next_id_text] = $row[$categories_id];
							}
							$prev_id = $row[$categories_id];
							if (!isset($first_id)) {
								$first_id = $row[$categories_id];
							}
							$last_id = $row[$categories_id];
						}
						$foo[$last_id][$next_id_text] = $foo[$value][$next_id_text];
						$foo[$value][$next_id_text] = $first_id;
						$new_path .= UNDERSCORE;
					}
					else
					{
						break;
					}
				}
			}
			if ($open_all_menues)
			{
				//Select all  t o p  - level menues
				//if ($cPath!=$realcPath && strpos($realcPath,$cPath."_")===false && strpos($realcPath,"_".$cPath	)===false)
				if ($cPath!=$realcPath)
				{
					$id=EMPTY_STRING;			//Only show currently select menu bold
				}
			}
			$file=CURRENT_TEMPLATE_IMG.'img_underline.gif';
			if (is_file(DIR_FS_CATALOG.$file))
			{
				$underline='
		<tr>
			<td colspan="2" valign="middle">
	@'.olc_image($file).'
			</td>
		</tr>
			';
			}
			else
			{
				$underline=EMPTY_STRING;
			}
			define('CATEGORY_LINE','
		<tr>
			<td valign="top">
	'.BULLET.'
			</td>
			<td class="infoBoxContents" valign="top">
				#
			</td>
		</tr>
	'.$underline);
			olc_show_category($first_element);
			/*
			if ($all_categories_string)
			{
				$all_categories_string.=HTML_BR;
			}
			$all_categories_string.=$categories_string;
			*/
			$all_categories_string='
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			'.$all_categories_string.$categories_string.'
			</table>
			';
		}
		$cPath=$realcPath;
		$box_smarty->assign('BOX_CONTENT', $all_categories_string);
		$box_categories= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_categories'.HTML_EXT,$cacheid);
		$smarty->assign('box_CATEGORIES',$box_categories);
	}
}

function clean_title($title)
{
	global $html_blank,$html_break,$text_break;

	$title=str_replace($html_blank,BLANK,stripslashes($title));
	$title=str_replace($html_break,$text_break,$title);
	$title=html_entity_decode($title);
	$title=str_replace(QUOTE,APOS,$title);
	return strip_tags($title);
}
?>