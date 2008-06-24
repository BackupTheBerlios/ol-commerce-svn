<?php
/* --------------------------------------------------------------
$Id: auctions_predefined.php,v 1.1.1.1.2.1 2007/04/08 07:16:25 gswkaiser Exp $

v 0.1
http://www.lener.info/
This Part of auction.LISTER for ebay is Released under the GNU General Public License
For more informations contact andrea@lener.info

OL-Commerce Version 5.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce; www.oscommerce.com
(c) 2003	    nextcommerce; www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');
//this is to order the list of templates

/* for sorting the auction list */
$orderby = "predef_id";			//Default order field
require_once DIR_WS_FUNCTIONS.'list_sorting.php';

//get all auction templates
$auctionssql = SELECT ."predef_id, quantity, title, subtitle, c.name catname, cat1, startprice, binprice, duration,
	t.name typename FROM ".TABLE_AUCTION_PREDEFINITION." p, ". TABLE_EBAY_CATEGORIES." c, ". TABLE_EBAY_AUCTIONTYPE." t
	where
	p.cat1 = c.id and
	p.auction_type = t.id ".$ordersql;
$myauctions = olc_db_query($auctionssql);
/* define Table Heading */
$heading = array(
array($name_text => AUCTIONS_TEXT_AUCTION_PREDEF_ID,
$attributes_text => $align_right_text,
$sort_text => str_replace(HASH,$predef_id_text,$sort0),
$link_text => $file. $predef_id_text),
array($name_text =>AUCTIONS_TEXT_AUCTION_AMOUNT,
$attributes_text => $align_right_text,
$sort_text => str_replace(HASH,$product_id_text,$sort0),
$link_text => $file. $product_id_text),
array($name_text => AUCTIONS_TEXT_AUCTION_CAT,
$attributes_text => $align_right_text,
$sort_text => str_replace(HASH,$cat1_text,$sort0),
$link_text => $file. $cat1_text),
array($name_text => AUCTIONS_TEXT_AUCTION_START_PRICE,
$attributes_text => $align_right_text,
$sort_text => str_replace(HASH,$startprice_text,$sort0) ,
$link_text => $file. $startprice_text),
array($name_text => AUCTIONS_TEXT_AUCTION_BUYNOW_PRICE,
$attributes_text => $align_right_text,
$sort_text => str_replace(HASH,$binprice_text,$sort0),
$link_text => $file.$binprice_text),
array($name_text => AUCTIONS_TEXT_AUCTION_PREDEF_DURATION,
$attributes_text => $align_right_text,
$sort_text => str_replace(HASH,$duration_text,$sort0),
$link_text => $file. $duration_text),
array($name_text => AUCTIONS_TEXT_AUCTION_PREDEF_TYPE,
$attributes_text => $align_right_text,
$sort_text => str_replace(HASH,$typename_text,$sort0),
$link_text => $file.$typename_text,
array($name_text => HTML_NBSP))
);
/* print table heading */
$main_content.=tableheading($heading);
$i=0;
while ($auctions_values = olc_db_fetch_array($myauctions))
{
	/* define content array */
	$i++;
	if ($i%2==0)
	{
		$class = $dataTableRow_1_text;
	}
	else
	{
		$class = $dataTableRow_text;
	}
	$startprice=$auctions_values[$startprice_text];
	$startprice=$startprice==0 ? DASH : olc_format_price($startprice,1,1,1);
	$binprice=$auctions_values[$binprice_text];
	$binprice=$binprice==0 ? DASH : olc_format_price($binprice,1,1,1);
	$content = array(
	$cssclass_text => $class,
	$values_text => array (
	array ($value_text => $auctions_values[$predef_id_text],
	$link_text => $getItem_text.$auctions_values[$predef_id_text],
	$linkattribute_text => $target_blank_text
	),
	array (
	$value_text => $auctions_values[$quantity_text].$x_text.$auctions_values[$title_text].HTML_BR.$auctions_values[$subtitle_text]
	),
	array (
	$value_text => $auctions_values[$catname_text].HTML_BR."(".$auctions_values[$cat1_text].RPAREN,
	$attributes_text => $align_right_text
	),
	array (
	$value_text => $startprice,
	$attributes_text => $align_right_text
	),
	array (
	$value_text => $binprice,
	$attributes_text => $align_right_text
	),
	array ($value_text => $auctions_values[$duration_text].AUCTIONS_TEXT_AUCTION_DURATION_DAYS
	),
	array ($value_text => $auctions_values[$typename_text],
	$attributes_text => $align_right_text
	),
	array($value_text =>
	olc_draw_form('edit_form',FILENAME_AUCTIONS_NEW).
	olc_draw_hidden_field('id',$auctions_values[$predef_id_text]).
	olc_draw_submit_button('edit',AUCTIONS_TEXT_AUCTION_PREDEF_ACCEPT).'
		</form>',
	$attributes_text => $align_right_text))
	);
	/* print content table */
	$main_content.=tablecontent($content);
}
$page_header_title=AUCTIONS_TEXT_HEADER;
$page_header_subtitle=AUCTIONS_TEXT_SUB_HEADER_PREDEF;
$page_header_icon_image=HEADING_MODULES_ICON;
$show_column_right=true;
$no_left_menu=false;
require(PROGRAM_FRAME);
?>