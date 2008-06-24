<?php
/* --------------------------------------------------------------
$Id: auctions_list.php,v 1.1.1.1.2.1 2007/04/08 07:16:24 gswkaiser Exp $

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
require_once $ebatns_dir.'EbatNs_ServiceProxy.php';
require_once $ebatns_dir.'EbatNs_Logger.php';
require_once $ebatns_dir.'GetSellerEventsRequestType.php';
require_once $ebatns_dir.'GetSellerTransactionsRequestType.php';
$mySession = new EbatNs_Session(AUCTIONS_EBAY_CONFIG);

//check if button for pickup new data is clicked
if (isset($_POST['pickup']))
{
	//if last click was more than 30 min ago
	if (check_time_dif ())
	{
		//update auction list
		if (update_auction_list())
		{
			$session=create_ebay_session();
			if ($session)
			{
				//look for auction details of ended auctions
				update_auction_details($session);
				$resultstring = AUCTIONS_TEXT_AUCTION_LIST_STATUS_SUCCESS;
			}
			else
			{
				$resultstring = EBAY_SESSION_ERROR;
			}
		}
		else
		{
			$resultstring = EBAY_SESSION_ERROR;
		}
	}
	else
	{
		$resultstring = AUCTIONS_TEXT_AUCTION_LIST_STATUS_FAILED;
	}
	if ($resultstring)
	{
		$main_content="<span class='smallText'>".$resultstring."</span><br/>";
	}
}
$orderby = "auction_id";			//Default order field
require_once DIR_WS_FUNCTIONS.'list_sorting.php';

//show all auctions not ended and not sheduled
$mynewstarttime = toGMT(date(AUCTIONS_DATE_FORMAT));
$auctionssql = SELECT_ALL.TABLE_AUCTION_LIST." where ended !=1 AND starttime <= '".$mynewstarttime."' ".$ordersql;
$myauctions = olc_db_query($auctionssql);

$main_content.='
<p align="right">
'.olc_draw_form('pickup_form',$PHP_SELF).olc_draw_submit_button('pickup',AUCTIONS_TEXT_AUCTION_LIST_STATUS_GET).'
</form>
</p>
';
/* define Table Heading */
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
$name_text => AUCTIONS_TEXT_AUCTION_START_PRICE,
$attributes_text => $align_right_text,
$sort_text => str_replace(HASH,$startprice_text,$sort0),
$link_text => $file.$startprice_text),
array(
$name_text => AUCTIONS_TEXT_AUCTION_BUYNOW_PRICE,
$attributes_text => $align_center_text,
$sort_text => str_replace(HASH,$buynowprice_text,$sort0),
$link_text => $file.$buynowprice_text),
array(
$name_text => AUCTIONS_TEXT_AUCTION_LIST_START_TIME,
$attributes_text => $align_center_text,
$sort_text => str_replace(HASH,$starttime_text,$sort0),
$link_text => $file.$starttime_text),
array(
$name_text => AUCTIONS_TEXT_AUCTION_LIST_END_TIME,
$attributes_text => $align_center_text,
$sort_text => str_replace(HASH,$endtime_text,$sort0),
$link_text => $file.$endtime_text),
array(
$name_text => AUCTIONS_TEXT_AUCTION_LIST_BIDS,
$attributes_text => $align_center_text,
$sort_text => str_replace(HASH,$bidcount_text,$sort0),
$link_text => $file.$bidcount_text),
array(
$name_text => AUCTIONS_TEXT_AUCTION_LIST_HIGHEST_BID,
$attributes_text => $align_center_text,
$sort_text => str_replace(HASH,$bidprice_text,$sort0),
$link_text => $file.$bidprice_text)
);
/* print table heading */
$main_content=tableheading($heading);
$i=0;
while ($auctions_values = olc_db_fetch_array($myauctions))
{
	$mybidcount = $auctions_values[$bidcount_text];
	if ($mybidcount==0)
	{
		$currentprice = DASH;
	}
	else
	{
		$currentprice = olc_format_price($auctions_values[$bidprice_text],1,1,1);
	}
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
	$buynowprice=$auctions_values[$buynowprice_text];
	$buynowprice=$buynowprice==0 ? DASH : olc_format_price($buynowprice,1,1,1);
	$auction_title=$auctions_values[$auction_title_text];
	$auction_id=$auctions_values[$auction_id_text];
	$content = array(
	$cssclass_text => $class,
	$values_text => array (
	array (
	$value_text => $auctions_values[$quantity_text].$x_text.$auction_title,
	$link_text => EBAY_SERVER.EBAY_VIEWITEM.$auction_title.APOS,
	$linkattribute_text => $target_blank_text,
	$attributes_text => $align_right_text),
	array (
	$value_text => $auction_id,
	$link_text => $getItem_text.$auction_id,
	$linkattribute_text => $target_blank_text,
	$attributes_text => $align_right_text),
	array (
	$value_text => $startprice,
	$attributes_text => $align_right_text),
	array (
	$value_text => $buynowprice,
	$attributes_text => $align_right_text),
	array (
	$value_text => GMT1($auctions_values[$starttime_text]),
	$attributes_text => $align_right_text),
	array (
	$value_text => GMT1($auctions_values[$endtime_text]),
	$attributes_text => $align_right_text),
	array (
	$value_text => $mybidcount,
	$attributes_text => $align_right_text),
	array (
	$value_text => $currentprice,
	$attributes_text => $align_right_text),
	));
	/* print content table */
	$main_content.=tablecontent($content);
}
$page_header_subtitle=AUCTIONS_TEXT_SUB_HEADER_AUCTION_LIST;
$show_column_right=true;
$no_left_menu=false;
require(PROGRAM_FRAME);
?>
