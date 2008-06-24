<?php
/* -----------------------------------------------------------------------------------------
$Id: function.olc_template_init.php,v 1.24 2004/04/21 17:53:57 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
All rights reserverd!!!

-----------------------------------------------------------------------------------------
Located in includes/classes/smarty/plugins

Not(!) released under the GNU General Public License!!!

---------------------------------------------------------------------------------------*/

define('SMARTY_INCLUDE_TPL_FILE','smarty_include_tpl_file');
define('SMARTY_INCLUDE_VARS','smarty_include_vars');
define('PARAM_FINALIZE','finalize');
define('PARAM_TITLE','title');
define('PARAM_SUB_TITLE','subtitle');
define('PARAM_VARS','vars');
define('PARAM_AFFILIATE','affiliate');
define('PARAM_SECTION','section');
define('PARAM_USE_TEMPLATE_LANGUAGE','use_template_language');

function smarty_function_olc_template_init($params, &$smarty)
{
	//Include template-specific PHP language file (if it exists)
	if ($params[PARAM_AFFILIATE]==TRUE_STRING_S)
	{
		$affiliate=PARAM_AFFILIATE.UNDERSCORE;
	}
	else
	{
		$affiliate=EMPTY_STRING;
	}
	if (!defined('TEMPLATE_LANGUAGE'))
	{
		$template_path=TEMPLATE_PATH.CURRENT_TEMPLATE.SLASH;
		$current_dir_path_template=DIR_FS_CATALOG.$template_path;
		$lang_dir=$smarty->config_dir.SLASH.SESSION_LANGUAGE.SLASH;
		$current_dir_path=DIR_FS_CATALOG;
		if (defined('EMPTY_STRING'))
		{
			$src_dir=DIR_FS_INC;
		}
		else
		{
			//Not olCommerce. Get some routines
			$src_dir=$current_dir_path_template.'inc'.SLASH;
			include_once($src_dir.'olc_define_global_constants.inc.php');
			require_once($src_dir.'olc_get_smarty_config_variable.inc.php');
			define('SESSION_LANGUAGE',$_SESSION['language']);
			define('SESSION_LANGUAGE_ID',$_SESSION['language_id']);
		}
		include_once($src_dir.'olc_error_handler.inc.php');
		include_once($src_dir.'olc_backtrace.inc.php');
		//Setup box-layout (if any)
		include($src_dir.'olc_get_box_configuration.inc.php');
		define('CHECK_LAYOUT_DEFINITION',USE_LAYOUT_DEFINITION==TRUE_STRING_S);

		$file_lead_in=$current_dir_path_template.$lang_dir;
		$file=$file_lead_in.SESSION_LANGUAGE.PHP;
		if (file_exists($file))
		{
			include_once($file);
		}
		$lang_file=$lang_dir.HASH.'lang_'.SESSION_LANGUAGE.'.conf';
		$file_lead_in=$current_dir_path.$lang_file;
		define('LANGUAGE_FILE',$file_lead_in);
		//Include template-specific "Smarty" language file (if it exists)
		$file_lead_in=$current_dir_path_template.$lang_file;
		$file=str_replace(HASH,$affiliate,$file_lead_in);
		if (!file_exists($file))
		{
			$file_lead_in=EMPTY_STRING;
		}
		define('TEMPLATE_LANGUAGE_FILE',$file_lead_in);
	}
	$file=str_replace(HASH,$affiliate,LANGUAGE_FILE);
	$section=$params[PARAM_SECTION];
	//Include "Smarty" language file
	$smarty->config_load($file,$section);
	if ($params[PARAM_USE_TEMPLATE_LANGUAGE]==TRUE_STRING_S)
	{
		//Include template-specific "Smarty" language file (if it exists)
		if (TEMPLATE_LANGUAGE_FILE)
		{
			$file=str_replace(HASH,$affiliate,TEMPLATE_LANGUAGE_FILE);
			if (file_exists($file))
			{
				$smarty->config_load($file,$section);
			}
		}
	}
	$smarty->assign(BULLET_TEXT,BULLET);
	unset($smarty->_tpl_vars[PARAM_AFFILIATE]);
	$title=$params[PARAM_TITLE];
	if ($title)
	{
		unset($smarty->_tpl_vars[PARAM_TITLE]);
		unset($smarty->_tpl_vars[PARAM_SUB_TITLE]);
		//If "title"- and/or "subtitle"-parameters include a "Smarty"-language-file-item
		//(parameter is like "#smarty-item#"), replace "title"- and/or "subtitle"-parameters,
		//replace it with the value(s) from the "Smarty"-language-file(s)!!!!!
		if (substr($title,0,1)==HASH)
		{
			$title=str_replace(HASH,EMPTY_STRING,$title);
			$params[PARAM_TITLE]=$smarty->_config[0][PARAM_VARS][$title];
		}
		$title=$params[PARAM_SUB_TITLE];
		if (substr($title,0,1)==HASH)
		{
			$title=str_replace(HASH,EMPTY_STRING,$title);
			$params[PARAM_SUB_TITLE]=$smarty->_config[0][PARAM_VARS][$title];
		}
		$header_template_text='header';
		$header_template=$params[$header_template_text];
		if (!$header_template)
		{
			$header_template=$header_text;
		}
		$header_template='module/'.$header_template.HTML_EXT;

		$conf=CURRENT_TEMPLATE.SLASH.$header_template;
		if (file_exists($conf))
		{
			$header_template=$conf;
		}
		else
		{
			$header_template=COMMON_TEMPLATE.$header_template;
		}
		$params=array(
		SMARTY_INCLUDE_TPL_FILE=>$header_template,
		SMARTY_INCLUDE_VARS=>$params);
		$smarty->_smarty_include($params);
	}
	elseif (CHECK_LAYOUT_DEFINITION)
	{
		if ($params[PARAM_FINALIZE]==TRUE_STRING_S)
		{
			if (!OL_COMMERCE)		//"PROJECT_VERSION" is defined by "OL-Commerce"
			{
				//Rendering of "index.html" is about to begin
				global $box_relations;

				$smarty->assign('USE_LAYOUT_DEFINITION',true);
				//Re-assign box areas names from real name(s) to name(s) according to box-layout-definition
				//in "boxes.ini", and assign navigation class for box ("navLeft_box,navMiddle_box,navRight_box")
				while (list($key,$value)=each($smarty->_tpl_vars))
				{
					if (strpos($key,BOX)!==false)
					{
						//Smarty data is for a box
						$comment=$key;
						$new_key=$box_relations[$key];
						if ($new_key)
						{
							if ($new_key<>$key)
							{
								$nav_area=substr($new_key,strlen(BOX),1);
								switch ($nav_area)
								{
									case BOX_NAV_AREA_MIDDLE:
										$nav_area=BOX_NAV_CLASS_MIDDLE;
										break;
									case BOX_NAV_AREA_RIGHT:
										$nav_area=BOX_NAV_CLASS_RIGHT;
										break;
									default:
										$nav_area=BOX_NAV_CLASS_LEFT;
										break;
								}
								$value=str_replace(NAVIGATION_AREA_TEXT,$nav_area,$value);
								$comment.=LPAREN.$new_key.RPAREN;
								$comment=str_replace(ATSIGN,$comment,COMMENT);
								$value=str_replace(HASH,BEGIN,$comment).$value.str_replace(HASH,END,$comment);
								unset($smarty->_tpl_vars[$key]);
								$smarty->_tpl_vars[$new_key]=$value;
							}
						}
					}
				}
			}
		}
	}
}
?>
