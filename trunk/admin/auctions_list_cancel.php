<?php
/* --------------------------------------------------------------
$Id: auctions_list_cancel.php,v 1.1.1.1.2.1 2007/04/08 07:16:24 gswkaiser Exp $

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
//select all auctions which transformed to a real order
$auctionssql = SELECT_ALL.TABLE_AUCTION_LIST." l, ".TABLE_AUCTION_DETAILS." d
WHERE l.auction_id=d.auction_id AND l.ended=1 AND d.order_number!=0 ".$ordersql;
$myauctions = olc_db_query($auctionssql);

$orderby = "auction_id";			//Default order field
require_once DIR_WS_FUNCTIONS.'list_sorting.php';
$heading = array(
array(
	$name_text => AUCTIONS_TEXT_AUCTION_AMOUNT,
	$attributes_text => $align_center_text,
	$sort_text => str_replace(HASH,$auction_title_text,$sort0),
	$link_text => $file.$auction_title_text),
array(
	$name_text => AUCTIONS_TEXT_AUCTION_LIST_EBAY_ID,
	$attributes_text => $align_center_text,
	$sort_text => str_replace(HASH,$auction_id_text,$sort0),
	$link_text => $file.$auction_id_text),
array(
	$name_text => AUCTIONS_TEXT_AUCTION_SOLD_BUYER,
	$attributes_text => $align_right_text,
	$sort_text => str_replace(HASH,$buyer_id_text,$sort0),
	$link_text => $file.$buyer_id_text),
array(
	$name_text => AUCTIONS_TEXT_AUCTION_SOLD_COUNTRY,
	$attributes_text => $align_center_text,
	$sort_text => str_replace(HASH,$buyer_land_text,$sort0),
	$link_text => $file.$buyer_land_text),
array(
	$name_text => AUCTIONS_TEXT_AUCTION_SOLD_PRICE,
	$attributes_text => $align_center_text,
	$sort_text => str_replace(HASH,auction_endprice_text,$sort0),
	$link_text => $file.auction_endprice_text),
array(
	$name_text => AUCTIONS_TEXT_AUCTION_LIST_END_TIME,
	$attributes_text => $align_center_text,
	$sort_text => str_replace(HASH,$endtime_text,$sort0),
	$link_text => $file.$endtime_text),
array(
	$name_text => AUCTIONS_TEXT_AUCTION_SOLD_ORDER_ORDERNR,
	$attributes_text => $align_center_text,
	$sort_text => str_replace(HASH,$order_number_text,$sort0),
	$link_text => $file.$order_number_text)
);
/* print table heading */
$main_content.= tableheading($heading);

$auction_endprice_text='auction_endprice';
$order_number_text='order_number';

$order_icon=olc_image(DIR_WS_ICONS.'order.gif', BOX_ORDERS).BLANK;
$link=olc_href_link(FILENAME_ORDERS, 'oID=#&action=edit');
$i=0;
while ($auctions_values = olc_db_fetch_array($myauctions))
{
	$i++;
	if ($i%2==0)
	{
		$class = $dataTableRow_1_text;
	}
	else
	{
		$class = $dataTableRow_text;
	}
	/* define content array */
	$quantity=$auctions_values[$quantity_text];
	$auction_id=$auctions_values[$auction_id_text];
	$buyer_id=$auctions_values[$buyer_id_text];
	$buyer_land=$auctions_values[$buyer_land_text];
	$auction_endprice=$auctions_values[$auction_endprice_text];
	$auction_endprice=olc_format_price($auction_endprice,1,1,1);
	$endtime=$auctions_values[$endtime_text];
	$order_number=$auctions_values[$order_number_text];
	$content = array(
	$cssclass_text => $class,
	$values_text => array (
	array (
	$value_text => $quantity.$x_text.BLANK.$auctions_values[$auction_title_text],
	$link_text => EBAY_SERVER.EBAY_VIEWITEM.$auction_id.APOS,
	$linkattribute_text => $target_blank_text,
	$attributes_text => $align_right_text),
	array (
	$value_text => $auction_id,
	$link_text => $getItem_text.$auction_id,
	$linkattribute_text => $target_blank_text,
	$attributes_text => $align_right_text),
	array (
	$value_text => $buyer_id.$comma_blank_text.$auctions_values[$buyer_name_text].HTML_BR.$auctions_values[$buyer_email_text]
	),
	array ($value_text => $buyer_land.DASH.$auctions_values[$buyer_zip_text].BLANK.$auctions_values[$buyer_city_text].HTML_BR.
	$auctions_values[$buyer_street_text],
	$attributes_text => $align_right_text),
	array (
	$value_text => $auction_endprice,
	$attributes_text => $align_right_text),
	array (
	$value_text => GMT1($endtime),
	array (
	$value_text => olc_image.$order_number,
	$link_text => str_replace(HASH,$order_number,$link),
	$attributes_text => $align_right_text)
	)
	));
	/* print content table */
	$main_content.= tablecontent($content);
}
$page_header_subtitle=AUCTIONS_TEXT_SUB_HEADER_AUCTION_SOLD_ORDER;
$show_column_right=true;
$no_left_menu=false;
require(PROGRAM_FRAME);
?>