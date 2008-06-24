<?php
//W. Kaiser - AJAX
/* -----------------------------------------------------------------------------------------
$Id: olc_get_box_configuration.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:29 gswkaiser Exp $

Get box layout configuration

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce; www.oscommerce.com
(c) 2003	      nextcommerce; www.nextcommerce.org
(c) 2004      	XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

global $box_relations, $box_constants;

$layout_definition_text='USE_LAYOUT_DEFINITION';
if (NO_BOX_LAYOUT==TRUE_STRING_S)
{
	$layout_definition=false;
}
else
{
	$box_relations_text='box_relations';
	$box_constants_text='box_constants';
	$box_relations=$_SESSION[$box_relations_text];
	if (isset($box_relations))
	{
		$layout_definition=sizeof($box_relations)>0;
		$box_constants=$_SESSION[$box_constants_text];
	}
	else
	{
		$box_relations=array();
		$box_constants=array();
		$file=DIR_FS_CATALOG.TEMPLATE_PATH.CURRENT_TEMPLATE.SLASH.'boxes.ini';
		$is_mystery=is_file($file);
		if ($is_mystery)
		{
			$layout_definition=true;
			$init_error=true;
			$box_settings=file($file);
			$box_settings_count=sizeof($box_settings);
			if ($box_settings_count)
			{
				$s='SHOW';
				define($s,$s.UNDERSCORE);
				$box_len=strlen(BOX);
				$box_allocation=array();
				$init_error=false;
				for ($i=0;$i<$box_settings_count;$i++)
				{
					$current_assignment=trim($box_settings[$i]);
					if ($current_assignment)
					{
						if (substr($current_assignment,0,1)<> HASH)
						{
							$current_assignment=strtolower($current_assignment);
							//Eliminate comment
							$box_nav_position=strpos($current_assignment,HASH);
							if ($box_nav_position!==false)
							{
								$current_assignment=trim(substr($current_assignment,0,$box_nav_position-1));
							}
							$current_entry=explode(EQUAL,$current_assignment);
							$box_name=trim($current_entry[0]);
							$box_name=BOX.strtoupper(substr($box_name,$box_len));
							$box_visible=false;
							$box_nav_area=$current_entry[1];
							if ($box_nav_area)
							{
								$current_entry=explode(COMMA,$box_nav_area);
								$box_nav_position=trim($current_entry[1]);
								if ($box_nav_position)
								{
									$box_nav_area=trim($current_entry[0]);
									if ($box_allocation[$box_nav_area][$box_nav_position])
									{
										$init_error_code='$ini_error=sprintf(TEXT_ERROR_MULTIPLE_INI_ENTRY,$box_nav_area,$box_nav_position)';
									}
									else
									{
										$box_allocation[$box_nav_area][$box_nav_position]=true;
										$box_name=BOX.strtoupper(substr($box_name,$box_len));
										$box_visible=$box_nav_area!=EMPTY_STRING;
										if ($box_nav_position<10)
										{
											$box_nav_position=ZERO_STRING.$box_nav_position;
										}
										$box_relations[$box_name]=BOX.$box_nav_area.UNDERSCORE.$box_nav_position;
									}
								}
								else
								{
									$init_error_code='$ini_error=sprintf(TEXT_ERROR_WRONG_INI_ENTRY,$file,$current_assignment)';
								}
							}
							$box_constants[str_replace(BOX,SHOW,$box_name)]=$box_visible;
						}
					}
				}
			}
		}
		else
		{
			$box_position_name_text='box_position_name';
			$box_key_name_text='box_key_name';
			$box_real_name_text='box_real_name';
			$box_visible='box_visible';
			$box_forced_visible='box_forced_visible';
			$box_relations=array();
			$box_constants=array();
			$box_configuration_query = olc_db_query(SELECT_ALL .TABLE_BOX_CONFIGURATION.
			SQL_WHERE."template='".CURRENT_TEMPLATE."' order by box_position_name");
			$layout_definition=olc_db_num_rows($box_configuration_query)>0;
			if ($layout_definition)
			{
				while ($current_box=olc_db_fetch_array($box_configuration_query))
				{
					$box_key_name=$current_box[$box_key_name_text];
					$box_real_name=$current_box[$box_real_name_text];
					if (!$box_real_name)
					{
						$box_real_name=$box_key_name;
					}
					$box_relations[$box_real_name]=$current_box[$box_position_name_text];
					$box_constants[$box_key_name]=$current_box[$box_visible] || $current_box[$box_forced_visible];
				}
			}
		}
		if ($layout_definition)
		{
			$s='box_NAVIGATION';
			$box_relations[$s]=$s;
			$box_constants['SHOW_NAVIGATION']=true;
		}
		else
		{
			if ($is_mystery)
			{
				$init_error_code='$ini_error=TEXT_ERROR_MISSING_INI_FILE.$file.QUOTE';
			}
//			else
//			{
//				$ini_error=TEXT_ERROR_MISSING_INI_DATA;
//			}
		}
		if ($ini_error_code)
		{
			include_once('lang'.SLASH.SESSION_LANGUAGE.SLASH.SESSION_LANGUAGE.PHP);
			eval($ini_error_code.SEMI_COLON);
			my_error_handler(E_ERROR,str_replace(DIR_FS_CATALOG,EMPTY_STRING,$ini_error));
		}
		else
		{
			$_SESSION[$box_relations_text]=$box_relations;
			$_SESSION[$box_constants_text]=$box_constants;
		}
	}
}
$s='_box';
if ($layout_definition)
{
	$layout_definition=TRUE_STRING_S;
	//Assign box display constants
	while (list($key, $value) = each($_SESSION[$box_constants_text]))
	{
		define($key,$value);
	}
	define('BOX_NAME',BOX.'NAME');
	define('BOX_NAV_AREA_MIDDLE','m');
	define('BOX_NAV_AREA_RIGHT','r');
	define('BOX_NAV_CLASS_MIDDLE','navMiddle'.$s);
	define('BOX_NAV_CLASS_RIGHT','navRight'.$s);
	$s1='SHOW';
	define($s1,$s1.UNDERSCORE);
	//define('DO_MYSTERY',$is_mystery);
}
else
{
	$layout_definition=FALSE_STRING_S;
}
define('BOX_NAV_CLASS_LEFT','navLeft'.$s);
define('BOX_NAV_CLASS',BOX.'navigation_area');
define($layout_definition_text,$layout_definition);
define('CHECK_UNIFIED_BOXES',constant($layout_definition_text));
define('SHOW_ALL_BOXES',!constant($layout_definition_text));
//W. Kaiser - AJAX
?>