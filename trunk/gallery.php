<?php
/* -----------------------------------------------------------------------------------------
$Id: gallery.php,v 1.1.1.1.2.1 2007/04/08 07:16:15 gswkaiser Exp $

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

include('includes/application_top.php');
olc_smarty_init($box_smarty,$cache_id);

require(DIR_WS_INCLUDES . 'header.php');
include_once(DIR_FS_INC.'olc_draw_pull_down_menu.inc.php');
include_once(DIR_FS_INC.'olc_get_categories.inc.php');

$categories_id=$_POST['categories_id'];
// include needed functions
if (DO_GROUP_CHECK)
{
	$group_check_p=" and  p.".SQL_GROUP_CONDITION;
}
if ($_SESSION['customers_status']['customers_fsk18_display']=='0')
{
	$fsk_lock="
	  and p.products_fsk18!=1";
}
$sorting=" order by p.products_id DESC";

$product_query_text = SELECT."
		p.products_image,
		p.products_id,
		p.products_min_order_quantity,
    p.products_uvp,
		pd.products_name,
		pd.products_meta_title,
		pd.products_meta_description,
		pd.products_meta_keywords,
		pd.products_short_description
		from " .
		TABLE_PRODUCTS . " p, " .
		TABLE_PRODUCTS_DESCRIPTION . " pd ";
$where="
			where
			p.products_status=1 and
			p.products_id = pd.products_id and
			pd.language_id = '" . SESSION_LANGUAGE_ID . APOS;
if ($categories_id && $categories_id<>TEXT_ALL_CATEGORIES)
{
	$product_query_text =
			$product_query_text.", ".
			TABLE_PRODUCTS_TO_CATEGORIES . " p2c ".
			$where." and
			p2c.products_id=p.products_id and
			p2c.categories_id = '" . $categories_id . APOS;
}
else
{
	$product_query_text =
			$product_query_text.
			$where;
}
$product_query_text.=
$group_check_p.
$fsk_lock.
$sorting;

$s='GALLERY_PICTURES_PER_PAGE';
if (!defined($s))
{
	define($s,100);
}
$s='GALLERY_PICTURES_PER_LINE';
if (!defined($s))
{
	define($s,6);
}
if (DO_GROUP_CHECK) {
	$additional_selection.="
	and p.".SQL_GROUP_CONDITION;
}
$product_query_text=str_replace("#group_fsk18#",$additional_selection,$product_query_text);
$products_listing_split = new splitPageResults($product_query_text, $_GET['page'], GALLERY_PICTURES_PER_PAGE, 'p.products_id');
$my_products_listing_entries=$products_listing_split->number_of_rows;
if ($my_products_listing_entries>0)
{
	require_once(DIR_FS_INC.'olc_format_price.inc.php');
	$total_width=GALLERY_PICTURES_PER_LINE*PRODUCT_IMAGE_THUMBNAIL_WIDTH;
	$current_width=0;
	$parameters_pop_up='id="@" style="cursor:hand" onclick="javascript:ShowInfo(\''.
	olc_href_link(FILENAME_PRINT_PRODUCT_INFO,'pop_up=true&fake_print=true&products_id=#').'\',\'\')"';
	$td_start='
				<td align="center" valign="top" style="font-size:8pt;vertical-align:top">
';

	$td_end='
				</td>
';
	$table_start='
		<table border="0" width="100%" cellspacing="0" cellpadding="1">
			<tr>
';
	$table_end='
			</tr>
		</table>
';
	$new_table_line0=$table_end.$table_attributes.$table_start;
	if (USE_AJAX)
	{
		$table_attributes=$table_start.'
					<td><div id="'.PRODUCTS_INFO_LINE.'#" align="center"></div></td>
'.$table_end;

		$new_table_line0.=$table_attributes;
	}
	$new_table_line0.=$table_start;
	$new_table_line=$new_table_line0;
	if (IS_IE)
	{
		$sep=NEW_LINE.NEW_LINE;
	}
	else
	{
		$sep=" -- ";
	}
	$parameters=olc_get_all_get_params(array('action')) .
	'action=buy_now&BUYproducts_id=#&gallery=true&line=§';
	$header=HTML_BR.HTML_NBSP.HTML_A_START;
	$trailer0='" title="'.APOS . ATSIGN . APOS.' (~'.BLANK.SESSION_CURRENCY.RPAREN.str_replace(APOS,EMPTY_STRING,TEXT_NOW). '">'.
	ATSIGN.HTML_A_END.HTML_NBSP;
	$product_query = olc_db_query($products_listing_split->sql_query);
	$categories=array(array('id' => EMPTY_STRING, 'text' => TEXT_ALL_CATEGORIES));
	$categories = olc_get_categories($categories, 0, EMPTY_STRING);
	$form_name='categories_form';
	if (USE_AJAX)
	{
		$onchange='return make_AJAX_Request_POST(\'' . $form_name . '\',\'' . FILENAME_GALLERY . '\''.RPAREN;
	}
	else
	{
		$onchange=$form_name.'.submit()';
	}
	$main_content =
	olc_draw_form($form_name,FILENAME_GALLERY).$table_start.
	'
		    <td class="fieldKey">' . ENTRY_CATEGORIES . '</td>
		    <td class="fieldValue">' .
	olc_draw_pull_down_menu('categories_id',$categories,$categories_id,'onchange="'.$onchange.QUOTE) . '
				</td>
		    <td width="70%">&nbsp;</td>
		  </tr>
		  <tr>
				<td colspan="3"><hr/></td>
'.$table_end.'
	</form>
';
	$current_row=$table_start;
	$line=1;
	$current_image=0;
	while ($product=olc_db_fetch_array($product_query))
	{
		$products_image=$product['products_image'];
		if ($products_image)
		{
			$products_image=DIR_WS_THUMBNAIL_IMAGES.$products_image;
			if (file_exists($products_image))
			{
				$current_pictures++;
				$products_id=$product['products_id'];
				$products_name=trim($product['products_name']);
				$products_short_description=str_replace(HTML_NBSP,BLANK,$product['products_short_description']);
				$products_short_description=str_replace(HTML_AMP,AMP,$products_short_description);
				$products_short_description=strip_tags($products_short_description);
				$title=$products_name.$sep.$products_short_description.$sep. TEXT_FURTHER_INFO;
				$parameter=str_replace(HASH,$products_id,$parameters_pop_up);
				$image_par=@getimagesize($products_image);
				$width=floor($image_par[0]*1.2);
				$current_width+=$width;
				$new_line=$current_width>$total_width;
				if ($new_line)
				{
					$main_content.=$current_row;
					$current_image=0;
					$current_width=$width;
					if (USE_AJAX)
					{
						$new_table_line=str_replace(HASH,$line,$new_table_line0);
					}
					//$main_content.=$new_table_line;
					$current_row=$new_table_line;
					$line++;
				}
				$current_image++;
				$products_id=$product['products_id'];
				$link=olc_href_link(FILENAME_DEFAULT, str_replace(HASH,$products_id,$parameters));

				$products_min_order_quantity=max(1,$product['products_min_order_quantity']);
				if ($products_min_order_quantity > 1)
				{
					$trailer=str_replace(ONE_STRING,$products_min_order_quantity,$trailer0);
				}
				else
				{
					$trailer=$trailer0;
				}
				$buy_now=str_replace(ATSIGN,$products_name, $header.$link.$trailer);
				$products_price=olc_get_products_price_specials($products_id, $price_special=1, $quantity=1,
				$price_special_info,$products_price_real);
				$buy_now=str_replace(TILDE,olc_format_price(abs($products_price_real),1,0,0),$buy_now);
				$buy_now=str_replace(PARA,$line,$buy_now);
				if ($current_image==1)
				{
					$s=PRODUCTS_LINE_IMAGE.$line;
				}
				else
				{
					$s=EMPTY_STRING;
				}
				//$main_content .=
				$current_row .=
				$td_start.
				olc_image($products_image,$title,$width,PRODUCT_IMAGE_THUMBNAIL_HEIGHT,
				str_replace(ATSIGN,$s,$parameter)).NEW_LINE.$buy_now.NEW_LINE.
				$td_end;
			}
		}
	}
	if ($main_content)
	{
		$current_row=str_replace('100%',EMPTY_STRING,$current_row);
		//$main_content= $table_start.$main_content.$table_end;
		$main_content.=$current_row.$table_end;
		if (USE_AJAX)
		{
			$main_content.=str_replace(HASH,$line,$table_attributes);
		}
		if ($my_products_listing_entries>GALLERY_PICTURES_PER_PAGE)
		{
			$main_content.= '
		<table border="0" width="100%" cellspacing="0" cellpadding="2">
		  <tr>
				<td colspan="2"><hr/></td>
		  </tr>
		  <tr>
				<td class="smallText">' .
			$products_listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS).'
				</td>
				<td class="smallText" align="right">'.TEXT_RESULT_PAGE . BLANK .
			$products_listing_split->display_links(MAX_DISPLAY_PAGE_LINKS,
			olc_get_all_get_params(array('page', 'info'))).'
				</td>
		  </tr>
		</table>
';
		}
		if (NO_TAX_RAISED)
		{
			$price_disclaimer=PRICES_DISCLAIMER_NO_TAX;
		}
		else
		{
			if (CUSTOMER_SHOW_PRICE_TAX)
			{
				$price_disclaimer=PRICES_DISCLAIMER_INCL;
			}
			else
			{
				$price_disclaimer=PRICES_DISCLAIMER_EXCL;
			}
		}
		$price_disclaimer=str_replace(HTML_BR,BLANK,$price_disclaimer);
		$box_smarty->assign('PRICE_DISCLAIMER',$price_disclaimer);
		$box_smarty->assign('GENERAL_DISCLAIMER',GENERAL_DISCLAIMER);
		$box_smarty->assign(MAIN_CONTENT,$main_content);
		$main_content=$box_smarty->fetch(CURRENT_TEMPLATE_MODULE . 'gallery'.HTML_EXT,$cache_id);
		$smarty->assign(MAIN_CONTENT,$main_content);
		require(BOXES);
		$smarty->display(INDEX_HTML,SMARTY_CACHE_ID);
	}
}
//W. Kaiser -- AJAX
?>