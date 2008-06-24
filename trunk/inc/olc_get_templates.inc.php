<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_templates.inc.php,v 1.1.1.1 2006/12/23 11:21:03 gswkaiser Exp $

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

function olc_get_templates(&$templates_dir,$strip_extension=false,$pattern=EMPTY_STRING)
{
	if (!is_dir($templates_dir))
	{
		if (CHECK_UNIFIED_TEMPLATES)
		{
			$templates_dir=str_replace(FULL_TEMPLATE_PATH,FULL_COMMON_TEMPLATE,$templates_dir);
			$notemplate=!is_dir($templates_dir);
		}
		else
		{
			$notemplate=true;
		}
		if ($notemplate)
		{
			my_error_handler(E_USER_ERROR,ILLEGAL_DIRECTORY.$templates_dir);
		}
	}
	$files=array();
	if ($dir= opendir($templates_dir))
	{
		$check_mask=$pattern<>EMPTY_STRING;
		$add_to_files=true;
		$id_text='id';
		$text_text='text';
		while ($file = readdir($dir))
		{
			if (is_file($templates_dir.$file))
			{
				if ($file!=INDEX_HTML)
				{
					if ($check_mask)
					{
						$add_to_files=strpos($file,$pattern)===false;
					}
					if ($strip_extension)
					{
		  			$file=str_replace(HTML_EXT,EMPTY_STRING,$file);
					}
					if ($add_to_files)
					{
						$files[]=array($id_text => $file, $text_text=>$file);
					}
					else
					{
						$files[0]=array($id_text => $file, $text_text=>$file);
						break;
					}
				}//if
			}//if
		} // while
		closedir($dir);
	}
	return $files;
}
?>