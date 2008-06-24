<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_seo_url.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:40 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_break_string.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_seo_url($url)
{
	//W. Kaiser - Search friendly URLs
	if (USE_SEO)
	{
		$slash_pos=strrpos($url,SLASH);
		if ($slash_pos!==false)
		{
			$slash_pos++;
		}
		$pos=strrpos($url,QUESTION);
		if ($pos!==false)
		{
			$url_b=substr($url,0,$pos);
			$parameters=substr($url,$pos+1);
		}
		else
		{
			$url_b=$url;
			$parameters=EMPTY_STRING;
		}
		$url_b=basename($url_b);

		global $seo_urls_to_convert, $seo_action_parameter;
		//URLs are built like:
		//http://www.server.de/olcommerce/seo-processor-par1-val1-par2-val2-...-parn-valn.htm
		//e.g.: http://www.server.de/olcommerce/seo-products_info-products_id-144.htm

		global $seo_array_1,$seo_array_2;

		if (DO_SEO_EXTENDED)
		{
			global $seo_search,$seo_replace;

			$add_parameters=EMPTY_STRING;
			$processor_type=EMPTY_STRING;
			if ($url_b==FILENAME_PRODUCT_INFO)
			{
				$rewritten=true;
				$products_id=get_parameter($parameters,'products_id',$add_parameters);
				if ($products_id)
				{
					if (strpos($add_parameters,'add_product')==false)
					{
						$processor_type='p';
					}
					else
					{
						$processor_type='a';
						$add_parameters=EMPTY_STRING;
					}
					$url_par=preg_replace($seo_search,$seo_replace,olc_get_products_name($products_id)).SEMI_COLON.$products_id;
				}
			}
			elseif ($url_b==FILENAME_DEFAULT)
			{
				global $seo_categories;

				$check_parameter='BUYproducts_id';
				$products_id=get_parameter($parameters,$check_parameter,$add_parameters);
				if ($products_id)
				{
					$processor_type='b';
					$url_par=strtolower(olc_get_products_name($products_id,SESSION_LANGUAGE_ID));
					$url_par=preg_replace($seo_search,$seo_replace,$url_par).SEMI_COLON.$products_id;
					$add_parameters=str_replace('action=buy_now',EMPTY_STRING,$add_parameters);
					if ($add_parameters[0]==AMP)
					{
						$add_parameters=substr($add_parameters,1);
					}
				}
				else
				{
					$category_id=get_parameter($parameters,'cPath',$add_parameters);
					if ($category_id)
					{
						$processor_type='k';
						$url_par=EMPTY_STRING;
						$category_id=explode(UNDERSCORE, $category_id);
						$categories=sizeof($category_id);
						for ($i=0;$i<$categories;$i++)
						{
							if ($url_par)
							{
								$url_par.=SEO_SEPARATOR;
							}
							$url_par.=preg_replace($seo_search,$seo_replace,$seo_categories[$category_id[$i]]);
						}
					}
					else
					{
						$manufacturer_id=get_parameter($parameters,'manufacturers_id',$add_parameters);
						if ($manufacturer_id)
						{
							$processor_type='m';
							$manufacturers=olc_get_manufacturers();
							foreach ($manufacturers as $manufacturer_id)
							{
								if ($manufacturer_id['id']==$manufacturer_id)
								{
									$maname=$manufacturer_id['text'];
									break;
								}
							}

							$url.=shopstat_hrefManulink($maname, $manufacturer_id, $url);
						}
						else
						{
							$filter_id=get_parameter($parameters,'filter_id',$add_parameters);
							if ($filter_id)
							{
							}
							else
							{
								//return $url;
							}									}
						}
					}
				}
				elseif ($url_b==FILENAME_CONTENT)
				{
					$content_id=get_parameter($parameters,'coID',$add_parameters);
					if ($content_id)
					{
						$processor_type='c';
						$url_par='content'.SEMI_COLON.$content_id;
					}
				}
				else
				{
					//return $url;
				}
			if (!$processor_type)
			{
				/*
				$url_par=explode(PHP,$url);
				$url_par=$url_par[0];
				$pos=strrpos($url_par,SLASH);
				if ($pos!==false)
				{
					$url_par=substr($url_par,$pos+1);
					$processor_type='g';
					if ($parameters)
					{
						$add_parameters=$parameters;
					}
				}
				else
				{
					return $url;
				}
				*/
				return $url;
			}
			if ($processor_type)
			{
				$processor_type.=SEO_SEPARATOR;
			}
		}
		else
		{
			$url=str_replace($seo_array_1, SEO_SEPARATOR,str_replace($seo_array_2, SEO_SEPARATOR, $url));
			$url_par=EMPTY_STRING;
		}
		$url=str_replace(PHP, EMPTY_STRING,$url);
		if ($slash_pos===false)
		{
			$url=EMPTY_STRING;
		}
		else
		{
			$url=substr($url,0,$slash_pos);
		}
		$url.=SEO_PAGENAME_START.$processor_type;
		$url.=$url_par.SEO_TERMINATOR;
		if ($add_parameters)
		{
			$url.=QUESTION.$add_parameters;
		}
	}
	return $url;
}

function get_parameter($parameters,$check_parameter,&$add_parameters)
{
	//Check for parameters!
	$add_parameters=EMPTY_STRING;
	$parameters=explode(AMP,$parameters);
	for ($i=0,$n=sizeof($parameters);$i<$n;$i++)
	{
		$parameter=$parameters[$i];
		if (strpos($parameter,$check_parameter)===false)
		{
			if ($add_parameters)
			{
				$add_parameters.=AMP;
			}
			$add_parameters.=$parameter;
		}
		else
		{
			$id=explode(EQUAL,$parameter);
			$id=$id[1];
		}
	}
	return $id;
}
?>