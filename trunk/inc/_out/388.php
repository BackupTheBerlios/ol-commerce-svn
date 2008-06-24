<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_href_link.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:36 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 	The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 	osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
(c) 2003				nextcommerce (olc_href_link.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      	XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// The HTML href link wrapper function
//W. Kaiser - AJAX
function olc_href_link($page = '', $parameters = '', $connection = NONSSL, $add_session_id = true,
$search_engine_safe = true, $create_ajax_link = true,$force_server_inclusion=false, $allow_ssl = true)
{
	global $session_started, $http_domain, $https_domain,$use_catalog_link,$request_type,$make_onclick_link;
	global $box_assignments,$box_relations, $box_constants,$currencies;
	global $seo_categories,	$seo_search, $seo_replace,$smarty,$breadcrumb;

	if (olc_not_null($page))
	{
		$separator = QUESTION;
		if (olc_not_null($parameters))
		{
			/*
			if (!USE_SEO)
			{
				if (strpos($parameters,HTML_AMP)===false)
				{
					$parameters=str_replace(AMP,HTML_AMP,$parameters);
				}
			}
			*/
			$link = $page . $separator  . $parameters;
			$separator = AMP;
		}
		else
		{
			$link = $page;
		}
		$server=HTTP_SERVER;
		if ($connection==SSL || getenv(HTTPS) != null)
		{
			if (IS_ADMIN_FUNCTION )
			{
				$allow_ssl=true;
			}
			else
			{
				$allow_ssl=ENABLE_SSL;
			}
			if ($allow_ssl)
			{
				$server=HTTPS_SERVER;
			}
		}
		/*
		if (strpos($page,'http')===false)
		{
			if (IS_ADMIN_FUNCTION && !$use_catalog_link)
			{
				$link_dir = DIR_WS_ADMIN;
			}
			else
			{
				$link_dir = DIR_WS_CATALOG;
			}
			$link=$link_dir.$link;
		}
		*/
		if (NOT_IS_ADMIN_FUNCTION)
		{
			if (ADD_SESSION_ID)
			{
				if ($add_session_id)
				{
					if (defined('SID') && olc_not_null(SID))
					{
						$sid = SID;
					}
					elseif ($server)
					{
						if ($http_domain != $https_domain)
						{
							$sid = session_name() . '=' . session_id();
						}
					}
				}
			}
			if (strpos($_SERVER['PHP_SELF'],SLASH."admin")===false)
			{
				// User mode!
				// Add the session id when moving from different HTTP and HTTPS servers, or when SID is defined
				if (olc_check_agent())
				{
					$sid=NULL;
				}
				if (isset($sid))
				{
					$link .= $separator . $sid;
				}
				if ($search_engine_safe)
				{
					if (strpos($link,DIR_WS_PRODUCT_IMAGES)==false)				//No SEO-URLs for images!
					{
						$link=olc_seo_url($link);
					}
				}
				//W. Kaiser - AJAX
				if (!defined('USE_AJAX'))
				{
					// include the AJAX-related code
					require(DIR_WS_INCLUDES . 'ajax'.PHP);
				}
			}
		}
		$not_is_pop_up_link=strpos($parameters, "pop_up") === false;
		if (USE_AJAX)
		{
//			$link=str_replace(DIR_WS_CATALOG,EMPTY_STRING,$link);
			/*
			if ($create_ajax_link)
			{
//				$check_link=strpos($page,FILENAME_PRODUCT_INFO)!==false;
//				if (!$check_link)
//				{
//				if (NOT_IS_ADMIN_FUNCTION)
//				{
//				$check_link=strpos($page,FILENAME_DEFAULT)!==false;
//				}
//				}
//				if ($check_link)
//				{
//				$onclick="javascript:onclick="javascript:;
//				if (strpos($page,AJAX_REQUEST)===false)
//				{
//
//				}
//				}
			}
			*/
		}
		else
		{
			//$link=$server.$link;
			if ($make_onclick_link)
			{
				if ($not_is_pop_up_link)
				{
					$link="document.location.href='".$link.APOS;
				}
				$make_onclick_link=false;
			}
		}
		//W. Kaiser - AJAX
		if (IS_MULTI_SHOP)
		{
			$link=olc_set_multi_shop_dir_info($link);
		}
		$link=str_replace(HTML_AMP,AMP,$link);
		$link=str_replace(AMP.AMP,AMP,$link);
		$link=str_replace(QUESTION.AMP,QUESTION,$link);
		$link=str_replace(AMP,HTML_AMP,$link);
		return $link;
	}
	else
	{
		my_error_handler(E_USER_ERROR,TEXT_ERROR_LINK_NOT_DEFINED);
	}
}
?>