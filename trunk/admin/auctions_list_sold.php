<?php
/* --------------------------------------------------------------
$Id: auctions_list_sold.php,v 1.1.1.1.2.1 2007/04/08 07:16:25 gswkaiser Exp $

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
$pickupitems = 0;
$numberofbuyer = 0;

//if button get buyerdata is clicked
if (isset($_POST['buyerdata']))
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
//if button inform buyer is clicked
if (isset($_POST['sendemail']))
{
	//get all infos of customers with ebay products (distinct)
	$buyersql = "SELECT DISTINCT (buyer_id), buyer_name, buyer_email,
	buyer_countrycode, buyer_land, buyer_zip, buyer_city, buyer_street
	FROM ".TABLE_AUCTION_DETAILS." WHERE order_number =0";
	$mybuyer = olc_db_query($buyersql);

	$i=0;
	$email_text = EMPTY_STRING;
	//look through buyers
	while ($buyer_values = olc_db_fetch_array($mybuyer))
	{
		//check if email allready exists
		$buyer_email=olc_db_input($buyer_values['buyer_email']);
		$check_email_query = olc_db_query("select customers_id from ".TABLE_CUSTOMERS .
		" where customers_email_address = '".$buyer_email.APOS);
		$check_email = olc_db_fetch_array($check_email_query);
		if (olc_db_num_rows($check_email) > 0)
		{
			//email allready existing - just add items in basket
			$customers_id=$check_email['customers_id'];
		}
		else
		{
			//email dont exist - add user
			addNewUser($buyer_values,$customers_id);
		}
		//add auction in basket
		//$email_text=addAuctionsInBasket($buyer_email,true);
		$email_text=addAuctionsInBasket($buyer_email);
		/*
		//Reuse checkout_process_code
		$_SESSION['shipping']=EBAY_SHIPPING;
		$customer_default_address_id=$_SESSION['customer_default_address_id'];
		$_SESSION['sendto']=$customer_default_address_id;
		$_SESSION['billto']=$customer_default_address_id;
		$_SESSION['payment'];
		*/
		sendemail($email_text,$buyer_email);
		$is_auction=true;
		$real_checkout=false;
		include(DIR_FS_DOCUMENT_ROOT.FILENAME_CHECKOUT_PROCESS);
		//require(ADMIN_PATH_PREFIX.'send_order.php');
	}
}
//show all auctions successfully ended
$auctionssql = SELECT_ALL .TABLE_AUCTION_LIST." l, ".TABLE_AUCTION_DETAILS." d
WHERE
l.auction_id=d.auction_id AND
d.order_number=0 ".$ordersql;
$myauctions = olc_db_query($auctionssql);

$orderby = "auction_id";			//Default order field
require_once DIR_WS_FUNCTIONS.'list_sorting.php';
$main_content.='
<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td align="center">
'.
			olc_draw_form('getbuyerdata',FILENAME_AUCTIONS_LIST_SOLD).
				olc_draw_submit_button('buyerdata',AUCTIONS_TEXT_AUCTION_SOLD_BUYER_DATA).'
			</form>
		</td>
		<td>
		</td>
		<td align="center">
'.
			olc_draw_form('email',FILENAME_AUCTIONS_LIST_SOLD).
				olc_draw_submit_button('sendemail',AUCTIONS_TEXT_AUCTION_SOLD_BUYER_INFORMATION).'
			</form>
		</td>
	</tr>
</table>
<br/>
';
$auction_title_text='l.'.$auction_title_text;
$auction_id_text='l.'.$auction_id_text;
$buyer_id_text='d.buyer_id';
$buyer_land_text='d.buyer_land';
$auction_endprice_text='d.auction_endprice';
$endtime_text='d.endtime';
$basket_text='d.basket';
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
	$name_text => AUCTIONS_TEXT_AUCTION_SOLD_BASKET,
	$attributes_text => $align_center_text,
	$sort_text => str_replace(HASH,$basket_text,$sort0),
	$link_text => $file.$basket_text)
);
/* print table heading */
$main_content.= tableheading($heading);

$order_icon=olc_image(DIR_WS_ICONS.'order.gif', BOX_ORDERS);
$cart_icon=olc_image(DIR_WS_ICONS.'cart.gif', AUCTIONS_TEXT_AUCTION_SOLD_BASKET);
$i=0;
while ($auctions_values = olc_db_fetch_array($myauctions))
{
	if ($auctions_values['basket'] != 0)
	{
		$mybasketicon = $cart_icon;
	}
	else
	{
		$mybasketicon = EMPTY_STRING;
	}
	$myordericon = EMPTY_STRING;
	if ($auctions_values[$order_number_text] != 0)
	{
		$myordericon = $order_icon;
	}
	else
	{
		$myordericon = EMPTY_STRING;
	}
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
	$startprice=$auctions_values[$startprice_text];
	$auction_endprice=olc_format_price($auction_endprice,1,1,1);
	$endtime=$auctions_values[$endtime_text];
	$content = array(
	$cssclass_text => $class,
	$values_text => array (
	array (
	$value_text => $quantity.$x_text.BLANK.$auctions_values[$auction_title_text],
	$link_text => EBAY_SERVER.EBAY_VIEWITEM.$auction_title.APOS,
	$linkattribute_text => $target_blank_text,
	$attributes_text => $align_right_text),
	array (
	$value_text => $auction_id,
	$link_text => $getItem_text.$auction_id,
	$linkattribute_text => $target_blank_text,
	$attributes_text => $align_right_text),
	array (
	$value_text => $buyer_id.$comma_blank_text.$auctions_values[$buyer_name_text].HTML_BR.
		$auctions_values[$buyer_email_text]
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
	$value_text => $mybasketicon,
	$attributes_text => $align_right_text)
	)
	));
	/* print content table */
	$main_content.= tablecontent($content);
}
$page_header_subtitle=AUCTIONS_TEXT_SUB_HEADER_AUCTION_SOLD;
$show_column_right=true;
$no_left_menu=false;
require(PROGRAM_FRAME);
?>