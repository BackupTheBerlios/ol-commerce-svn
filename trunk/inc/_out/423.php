<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_redirect.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:39 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------	---------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_redirect.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// include needed functions
require_once(DIR_FS_INC.'olc_exit.inc.php');

function olc_redirect($url,$force_location_redirect=false)
{
	//if (USE_AJAX && $is_ajax_link)
	if (USE_AJAX && !$force_location_redirect)
	{
		global $box_assignments,$box_relations, $box_constants,$currencies,$lng;
		global $seo_categories,	$seo_search, $seo_replace,$smarty,$breadcrumb;
		/*
		if (IS_ADMIN_FUNCTION)
		{
		$url = str_replace('admin/',EMPTY_STRING,$url);
		}
		*/
		$is_ajax_link=strpos($url, AJAX_REQUEST_FUNC_START) !== false;
		if (ENABLE_SSL && (getenv("HTTPS") != NULL))
		{ // We are loading an SSL page
			$server=HTTPS_SERVER;
			$l=strlen(HTTP_SERVER);
			if (substr($url, 0, $l) == HTTP_SERVER)
			{
				// NONSSL url
				$url = HTTPS_SERVER . substr($url, $l); // Change it to SSL
			}
		}
		else
		{
			$server=HTTP_SERVER;
		}
		//Destroy old GET- and POST-parameters
		while (list($key, $val) = each($_GET))
		{
			unset($_GET[$key]);
		}
		while (list($key, $val) = each($_POST))
		{
			unset($_POST[$key]);
		}
		//Remove AJAX link-Javascript-code
		//$url = str_replace(AJAX_REQUEST_FUNC_START, EMPTY_STRING, $url);
		//$url = str_replace(AJAX_REQUEST_FUNC_END, EMPTY_STRING, $url);
		$url = str_replace($server,EMPTY_STRING,$url);
		$url = str_replace(DIR_WS_CATALOG,EMPTY_STRING,$url);
		if (USE_SEO && (!DO_SEO_EXTENDED || strpos($url,SEO_PAGENAME_START)!==false))
		{
			$_SERVER['REQUEST_URI']=$url;
			$url='seo.php';
		}
		else
		{
			$pos=strpos($url, QUESTION);
			if ($pos)
			{
				$strlen_url=strlen($url);
				$parameter=substr($url,$pos+1);
				$url=substr($url,0,$pos);
				if ($pos < $strlen_url)
				{
					if (USE_SEO && !DO_SEO_EXTENDED)
					{
						$sep=SLASH;
					}
					else
					{
						$sep=HTML_AMP;
					}
					$parameter=split($sep,$parameter);
					while (list($key, $val) = each($parameter))
					{
						$sep=split(EQUAL,$val);
						$_GET[$sep[0]] = $sep[1];
					}
				}
			}
			$PHP_SELF = $url;
		}
		define('IS_AJAX_PROCESSING_FORCED',true);
		include($url);
		olc_exit();
	}
	else
	{
//echo "redirect='".$url.APOS.HTML_BR;
		header('Location: ' . $url);
        olc_exit();
	}
	//W. Kaiser - AJAX
}
?>