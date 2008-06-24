<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_box_code_script_path.inc.php,v 1.1.1.1 2006/12/22 13:41:30 gswkaiser Exp $

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
*/

define('COMMON_TEMPLATE','olc'.SLASH);
define('FULL_COMMON_TEMPLATE',TEMPLATE_PATH.COMMON_TEMPLATE);
define('BOXES_DIR',SLASH.'boxes'.SLASH);
$source='source';
define('DIR_WS_BOXES',FULL_CURRENT_TEMPLATE.$source.BOXES_DIR);
define('DIR_WS_BOXES_INC','inc'.SLASH);
$s=box_code_script_path('boxes.php');
define('BOXES',str_replace(BOXES_DIR,SLASH,$s));

function box_code_script_path($box)
{
	//Assume to use the 'common' script-path
	$standard_box_path=DIR_WS_BOXES.$box;
	if (CHECK_UNIFIED_BOXES)
	{
		//Unified boxes
		//$index=str_replace(SLASH,UNDERSCORE,$box);
		//$index=$box;
		$stored_box_code_script_path=$_SESSION[$box];
		if ($stored_box_code_script_path)
		{
			$box_code_script_path=$stored_box_code_script_path;
		}
		else
		{
			//Check if box is available in the individual templates' directory
			//If not, use box the from the common template directory
			if (is_file($standard_box_path))
			{
				$box_code_script_path=$standard_box_path;
			}
			else
			{
				$box_code_script_path=str_replace(FULL_CURRENT_TEMPLATE,FULL_COMMON_TEMPLATE,DIR_WS_BOXES).$box;
			}
			if (strpos($box_code_script_path,DIR_WS_BOXES_INC)!==false)
			{
				$box_code_script_path=str_replace(BOXES_DIR,SLASH,$box_code_script_path);
			}
			$_SESSION[$box]=$box_code_script_path;
		}
		return $box_code_script_path;
		//Unified boxes
	}
	else
	{
		return $standard_box_path;
	}
}
?>