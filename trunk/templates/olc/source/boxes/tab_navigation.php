<?
/* -----------------------------------------------------------------------------------------
$Id: tab_navigation.php,v 1.2 2004-11-27

Copyright (c) 2004 by at-future, js@at-future.com
Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(specials.php,v 1.30 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (specials.php,v 1.10 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$tab_id_text="tab_id";
$tab_ajax='tab_ajax';
$is_ajax_mode=$_GET[$tab_ajax]==TRUE_STRING_S;			//Stand-alone mode!
$current_template_text='CURRENT_TEMPLATE';
if ($is_ajax_mode)
{
	$stand_alone=true;
}
else
{
	$is_ajax_mode=USE_AJAX==true;
}
$vars=(empty($_POST)) ? $_GET : $_POST;
$active_tab=(isset($vars[$tab_id_text])) ? $vars[$tab_id_text] : 0;
if ($stand_alone)
{
	$level='../../../../';
	$path_includes=$level.'includes/';
	include($path_includes.'configure.php');
	require_once(DIR_FS_INC.'olc_define_global_constants.inc.php');
	$connected=false;
	define('MULTI_DB_SERVER',false);
	require_once(DIR_FS_INC.'olc_connect_and_get_config.inc.php');
	olc_connect_and_get_config(array(17),$level);

	require_once(DIR_FS_INC.'olc_get_box_code_script_path.inc.php');
	require_once(DIR_FS_INC.'olc_smarty_init.inc.php');
	require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'smarty/Smarty.class.php');
	require_once(DIR_FS_INC.'olc_smarty_init.inc.php');
	include_once(DIR_FS_INC.'olc_start_session.inc.php');
	$language_text='language';
	define('SESSION_LANGUAGE_ID', $_SESSION[$language_text.'_id']);
	include_once(DIR_WS_INCLUDES.'write_customers_status.php');

	define($current_template_text,$vars[$current_template_text]);
	define('FULL_CURRENT_TEMPLATE',TEMPLATE_PATH.CURRENT_TEMPLATE.SLASH);
	define('CURRENT_TEMPLATE_BOXES',CURRENT_TEMPLATE.SLASH.'boxes'.SLASH);
}
# check if session tab_id exist and use this.
if ($active_tab== 0 && isset($_SESSION[$tab_id_text]))
{
	$active_tab=$_SESSION[$tab_id_text];
}
else
{
	$_SESSION[$tab_id_text]=$active_tab;
}

$basecss="tabcol";
$mouseover_image=EMPTY_STRING;
$box_content=getCategoriesArray($basecss, $active_tab);
olc_smarty_init($box_smarty,$cache_id);
$box_smarty->assign('box_content', $box_content);
$box_smarty->assign('navtyp', $navtyp);
$box_smarty->assign('active_tab', $active_tab);
$box_navigation=$box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_tab_navigation'.HTML_EXT,$cache_id);
$smarty->assign('box_TAB_NAVIGATION',$box_navigation);
if ($stand_alone)
{
	$smarty->display(INDEX_HTML);
}

/**-----------
* @return array
* @param $basecss base style clas
* @param $active_tab active clicked tab
* @desc create array with categories and subcategories.
*/
function getCategoriesArray($basecss, $active_tab)
{
	global $is_ajax_mode,$tab_id_text,$current_template_text,$tab_ajax;

	# read cats form database
	if (DO_GROUP_CHECK)
	{
		$group_check=" and c.".SQL_GROUP_CONDITION;
	}
	$categories_query=SELECT."
	c.categories_id,
	cd.categories_name,
	c.parent_id from ".
	TABLE_CATEGORIES." c, ".
	TABLE_CATEGORIES_DESCRIPTION." cd
	where c.categories_status='1'
	and c.parent_id='0'
	".$group_check."
	and c.categories_id=cd.categories_id
	and cd.language_id='".SESSION_LANGUAGE_ID."'
	order by sort_order, cd.categories_name";
	$categories_query=olc_db_query($categories_query);

	$subcat_query0=TABLE_PREFIX_COMMON."categories";
	$subcat_query0=
	SELECT."
	c.categories_id,
	cd.categories_name,
	c.parent_id
	from ".
	$subcat_query0." c, ".
	$subcat_query0."_description cd
	where
	c.categories_status='1' and
	c.parent_id='#' and
	c.categories_id=cd.categories_id and
	cd.language_id='".SESSION_LANGUAGE_ID."'
	order by sort_order,cd.categories_name";

	$tab_id=AMP.$tab_id_text.EQUAL;
	if ($is_ajax_mode)
	{
		$tab_id=AMP.SID.AMP.$current_template_text.EQUAL.CURRENT_TEMPLATE.AMP.$tab_ajax.EQUAL.TRUE_STRING_S.$tab_id;
		$path=box_code_script_path('tab_navigation.php');
	}
	else
	{
		$path='index.php';
	}
	$path.=QUESTION."cPath".EQUAL;
	$categories_id_text='categories_id';
	$categories_name_text='categories_name';
	$parent_id_text='parent_id';
	$name_text='NAME';
	$url_text='URL';
	$css_text='CSS';
	$main_text='main';
	$sub_text='sub';
	$key=0;
	while ($categories=olc_db_fetch_array(&$categories_query,true))
	{
		$categories_id=$categories[$categories_id_text];
		# crate main cats
		$css=($key==$active_tab) ? $basecss.$key : $basecss;
		$cat_array[$main_text][]=array(
		$name_text=> $categories[$categories_name_text],
		$url_text=> $path.$categories_id.$tab_id.$key,
		$css_text=> $css);
		$subcat_query=str_replace(HASH,$categories_id,$subcat_query0);
		$subcat_query=olc_db_query($subcat_query);
		$category_check=olc_db_num_rows(&$subcat_query,true);
		# create sub cats
		if ($category_check > 0)
		{
			while ($row=olc_db_fetch_array(&$subcat_query,true))
			{
				$cat_array[$sub_text][$key][]=array(
				$name_text=> $row[$categories_name_text],
				$url_text=> $path.$row[$parent_id_text].UNDERSCORE.$row[$categories_id_text].$tab_id.$key);
			}
		}
		$key++;
	}
	return $cat_array;
}
?>