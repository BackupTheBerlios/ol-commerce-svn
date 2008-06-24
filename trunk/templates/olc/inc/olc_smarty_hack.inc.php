<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_smarty_hack.inc.php,v 1.1.1.1 2006/12/23 11:21:03 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com
(c) 2003	    nextcommerce (olc_banner_exists.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - xtCommerce hack
//Brute hack to allow Smarty subclassing for xtCommerce!!!!!
//We modify "Smarty"'s class name in its source(!!!) code, and supply our own "Smarty"-class instead!
//This class will subclass Smarty, but modify some methods, to support AJAX

//Check, if standard Smarty installation has alreeady been modified, to support "Smarty"-subclassing
$classes_dir=DIR_FS_CATALOG.DIR_WS_CLASSES;
if ($dir= opendir($classes_dir))
{
	$class_smarty_text='Smarty';
	$class_smarty_text_s=strtolower($class_smarty_text);
	$directories=array();
	while ($directory = readdir($dir))
	{
		if (substr($directory,0,1)<>DOT)
		{
			if (is_dir($classes_dir.$directory))
			{
				if (strpos(strtolower($directory),$class_smarty_text_s)!==false)
				{
					$directories[]=$directory;
				}
			}//if
		}//if
	} // while
	closedir($dir);
	sort($directories);
	$class_std_smarty_text='std_'.$class_smarty_text;
	$smarty_dir=$classes_dir.$directories[sizeof($directories)-1].SLASH;
	$smarty_class=$class_smarty_text.'.class.php';
	$std_smarty_class='std_'.$smarty_class;
	$std_smarty_file=$smarty_dir.$std_smarty_class;
	$smarty_file=$smarty_dir.$smarty_class;
	$class_text="class ";
	$function_text="function ";
	$s=file_get_contents($smarty_file);
	$search_text=$class_text.$class_smarty_text;
	$poss=strpos($s,$search_text);
	if ($poss!==false)
	{
		$s=substr($s,0,$poss).$class_text.$class_std_smarty_text.substr($s,$poss+strlen($search_text));
		$search_text=$function_text.$class_smarty_text;
		$poss=strpos($s,$search_text,$poss);
		if ($poss===false)
		{
			$search_text=$function_text.'__construct';		//New style class constructor???
			$poss=strpos($s,$search_text,$poss);
			$replace_constructor=false;
		}
		else 
		{
			$replace_constructor=true;
		}
		if ($poss!==false)
		{
			if ($replace_constructor)
			{
				$s=substr($s,0,$poss).$function_text.$class_std_smarty_text.substr($s,$poss+strlen($search_text));
			}
			$file=str_replace($smarty_class,$std_smarty_class,$smarty_file);
			file_put_contents($file,$s);
			rename($smarty_file, str_replace(PHP,'.save'.PHP,$smarty_file));
			$inc_dir=dirname(__FILE__).SLASH;
			$file=$inc_dir.basename($smarty_file);
			copy($file, $smarty_file);
			$file0='function.olc_template_init.php';
			$file=$smarty_dir.'plugins'.SLASH.$file0;
			if (!is_file($file))
			{
				copy($inc_dir.$file0,$file);
			}
			//$_SESSION[SMARTY_DIR]=$smarty_dir;
			file_put_contents('smarty_dir.txt',$smarty_dir);
			olc_redirect(FILENAME_DEFAULT,true);
		}
	}
}
?>