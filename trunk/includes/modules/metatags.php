<?php
/* -----------------------------------------------------------------------------------------
$Id: metatags.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (metatags.php,v 1.7 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
//W. Kaiser - AJAX

if ($is_spider_visit)
{
	$IsIndex = true;
	$products_id=EMPTY_STRING;
}
else
{
	$cPath=$_GET['cPath'];
	$IsIndex = CURRENT_SCRIPT==FILENAME_DEFAULT;
	$IsProductInfo = CURRENT_SCRIPT==FILENAME_PRODUCT_INFO;
	$products_id=$_GET['products_id'];
}
if ($IsIndex || $IsProductInfo)
{
	if ($products_id)
	{
		$product_condition="p.products_id=" . $products_id;
	}
	else
	{
		if ($is_spider_visit)
		{
			$s='SPIDER_FOOD_ROWS';
			if (!defined($s))
			{
				define($s,100);
			}
			if (SPIDER_FOOD_ROWS>0)
			{
				$status_cond='products_status=1';
				$lowest_text='lowest';
				$highest_text='highest';
				$lowest_id=$_SESSION[$lowest_text];
				if (!$lowest_id)
				{
					$product_query_text=SELECT .'min(products_id) as '.$lowest_text.', max(products_id) as '.$highest_text.SQL_FROM.
					TABLE_PRODUCTS.SQL_WHERE.$status_cond;
					$product_query = olc_db_query($product_query_text);
					$product_query=olc_db_fetch_array($product_query);
					$lowest_id=$product_query[$lowest_text];
					$highest_id=$product_query[$highest_text];
					$_SESSION[$lowest_text]=$lowest_id;
					$_SESSION[$highest_text]=$highest_id;
				}
				$highest_id=$_SESSION[$highest_text];
				$total_products=olc_db_num_rows($product_query);
				$product_condition=$status_cond;
				if ($total_products>SPIDER_FOOD_ROWS)
				{
					$groups=(int)($total_products/SPIDER_FOOD_ROWS);
					include_once(DIR_FS_INC.'olc_rand.inc.php');
					$modulo_value=(int)olc_rand(1,$groups);
					if ($modulo_value>1)
					{
						$product_condition.='MOD(pd.products_id,'.$modulo_value.')=0 LIMIT '.SPIDER_FOOD_ROWS;
					}
				}
			}
		}
	}
	$product_meta_query_text =
	"select
			p.products_image,
			pd.products_id,
			pd.products_name,
			pd.products_meta_title,
			pd.products_meta_description,
			pd.products_meta_keywords,
			pd.products_description,
			pd.products_short_description from " .
	TABLE_PRODUCTS . " p left join " .
	TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id" .
	" where language_id = '" . SESSION_LANGUAGE_ID . APOS;
	$sep =' - ';
	if ($product_condition)
	{
		$product_meta_query_text .= ' and '.$product_condition;
	}
	$product_meta_query = olc_db_query($product_meta_query_text);
	//$num_rows = mysql_num_rows($product_meta_query);
	if (NOT_IS_AJAX_PROCESSING)
	{
		$header .= '
<meta name="robots" content="' . META_ROBOTS . '">
<meta name="language" content="' . $language . '">
<meta name="author" content="' . META_AUTHOR . '">
<meta name="publisher" content="' . META_PUBLISHER . '">
<meta name="company" content="' . META_COMPANY . '">
<meta name="page-topic" content="' . META_TOPIC . '">
<meta name="reply-to" content="' . META_REPLY_TO . '">
<meta name="distribution" content="global">
';
		if ($is_spider_visit)
		{
		$header .= '
<meta name="revisit-after" content="' . META_REVISIT_AFTER . '">
';
			$h1_par=HASH.'1';
			$h2_par=HASH.'2';
			$products_header0 = '<h1><strong>#1</strong></h1><h2><strong>#1</strong></h2>'.TILDE;
			$products_meta_description = EMPTY_STRING;
			$products_meta_keywords = EMPTY_STRING;
			$products_img = EMPTY_STRING;
			$products_header = EMPTY_STRING;
			while ($product_meta = olc_db_fetch_array($product_meta_query))
			{
				$product_meta_description = $product_meta['products_meta_description'];
				$product_meta_description = strip_tags($product_meta_description);
				$product_meta_keywords = strip_tags($product_meta['products_meta_keywords']);
				if ($is_spider_visit)
				{
					$products_short_description=$product_meta['products_short_description'];
					$products_id=str_replace($h1_par, $product_meta_keywords, $products_header0);
					$products_id=str_replace($h2_par, $products_short_description, $products_id);
					$products_header .= str_replace(TILDE, $product_meta['products_description'], $products_id) . NEW_LINE;
					if ($products_meta_description)
					{
						$products_meta_description .= HTML_BR;
						$products_meta_keywords .= HTML_BR;
					}
					$products_meta_description .= $product_meta_description;
					$products_meta_keywords .= $product_meta_keywords;

					$products_id=$product_meta['products_id'];
					$products_name=$product_meta['products_name'];
					$products_short_description=str_replace(HTML_NBSP,BLANK,$products_short_description);
					$products_short_description=strip_tags($products_short_description);
					$title=$products_name."\n\n".$products_short_description;
					$link0=HTML_A_START . olc_href_link(FILENAME_PRODUCT_INFO, 'products_id='.	$products_id) .
					'" alt=EMPTY_STRING title="'.$title.'" target="_blank">';

					$products_link .= $link0.$products_name.HTML_A_END . "<br/>\n";
					$products_image=$product_meta['products_image'];
					if ($products_image)
					{
						$products_img .= $link0.olc_image(DIR_WS_THUMBNAIL_IMAGES.$products_image,$title).HTML_A_END.NEW_LINE;;
					}
				}
			}
			$keywords =	explode(COMMA, META_KEYWORDS);
			$nr_of_keywords = sizeof($keywords);
			for ($keyword = 0; $keyword < $nr_of_keywords; $keyword++)
			{
				$current_keyword0 = trim($keywords[$keyword]);
				$current_keyword = COMMA.$current_keyword0;
				$products_header .= str_replace(HASH, $current_keyword0, $products_header0) . NEW_LINE;

				$products_meta_description .= $current_keyword;
				$products_meta_keywords .= $current_keyword;

				$link=HTML_A_START . olc_href_link(FILENAME_PRODUCT_INFO, 'products_id='.	$current_keyword0) .
				'" alt=EMPTY_STRING title="'.$current_keyword0.' target="_blank">'.
				$current_keyword0.HTML_A_END.HTML_BR.NEW_LINE;
			}
		}
	}
}
else
{
	$products_meta_description = EMPTY_STRING;
	$products_meta_keywords = EMPTY_STRING;
}
if ($IsProductInfo)
{
	$title = $_SESSION['categories_title'] . $sep . $product_meta_keywords;
}
else
{
	if ($cPath)
	{
		$multlevel=strpos($cPath,UNDERSCORE)!==false;
		if ($multlevel)
		{
			$arr=explode(UNDERSCORE,$cPath);
			$cPath=$arr[sizeof($arr)-1];
		}
		$categories_meta_query="
		SELECT
		categories_meta_keywords,
    categories_meta_description,
    categories_meta_title,
    categories_name
    FROM ".TABLE_CATEGORIES_DESCRIPTION."
    WHERE
    categories_id=".$cPath."
    and language_id=".SESSION_LANGUAGE_ID;
		$categories_meta_query=olc_db_query($categories_meta_query);
		$title=EMPTY_STRING;
		while ($categories_meta = olc_db_fetch_array($categories_meta_query))
		{
			$categories_meta_title=$categories_meta['categories_meta_title'];
			if ($categories_meta_title==EMPTY_STRING)
			{
				$categories_meta_title=$categories_meta['categories_name'];
			}
			if (strlen($title)>0)
			{
				$title.=$sep;
			}
			$title .= $categories_meta_title;
		}
		$_SESSION['categories_title']=$title;
	}
	else
	{
		$title = EMPTY_STRING;
		$sep =EMPTY_STRING;
	}
}
//W. Kaiser -- AJAX
if (NOT_IS_AJAX_PROCESSING)
{
	$header .=
	'<meta NAME="description" CONTENT="' . $products_meta_description . '">' . NEW_LINE .
	'<meta NAME="keywords" CONTENT="' . $products_meta_keywords . '">' . NEW_LINE.
	"<title>".TITLE . $sep . $title. "</title>".NEW_LINE;
}
//W. Kaiser -- AJAX
?>