<?php
/* --------------------------------------------------------------
$Id: auction_list_helper.php,v 1.1.1.1.2.1 2007/04/08 07:16:43 gswkaiser Exp $

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

$pic_text='pic';
$gallery_text='gallery_';
$gallery_pic_text=$gallery_text.$pic_text;
$pic_url_text="pic_url";
$gallery_pic_url_text=$gallery_text.$pic_url_text;
$gallery_pic_plus_text=$gallery_pic_text.'_plus';
$link_text='link';
$value_text= 'value';
$name_text='name';
$attributes_text='attributes';
$linkattribute_text=$link_text.$attributes_text;
$sort_text='sort';
$file=$PHP_SELF."?oldorder=".$orderby."&way=".$way."&orderby=";
$sort0=array('newsort' => "#", 'oldsort' => $orderby, 'sortimg' => $sort_image);
$align_left_text='align="left"';
$align_right_text='align="right"';
$align_center_text='align="center"';
$target_blank_text="target = '_blank'";
$product_id_text='product_id';
$predef_id_text='predef_id';
$cat1_text='cat1';
$duration_text='duration';
$typename_text='typename';
$auction_id_text='auction_id';
$startprice_text='startprice';
$buynowprice_text='buynowprice';
$buyitnow_text='buyitnow';
$starttime_text='starttime';
$endtime_text='endtime';
$bidcount_text='bidcount';
$bidprice_text='bidprice';
$bold_text='bold';
$highlight_text='highlight';
$border_text='border';
$dataTableRow_text = "dataTableRow";
$dataTableRow_1_text = $dataTableRow_text .UNDERSCORE.ONE_STRING;
$x_text=HTML_NBSP."x".HTML_NBSP;
$getItem_text="auctions_getItem.php?itemId=";
$amount_text='amount';
$title_text='title';
$subtitle_text='subtitle';
$auction_title_text='auction_title';
$cssclass_text='cssclass';
$values_text='values';
$catname_text='catname';
$orderby_text='orderby';
$oldorder_text='oldorder';
$asc_text="ASC";
$desc_text="DESC";

$page_header_title=AUCTIONS_TEXT_HEADER;
$page_header_icon_image=HEADING_MODULES_ICON;
$is_auction=true;

function update_bidcount($starttime, $endtime, $bidcount, $bidprice, $auction_id){
	$sqlstring =
	SQL_UPDATE.TABLE_AUCTION_LIST." SET `starttime` = '".$starttime."',
	`endtime` = '".$endtime."',
	`bidcount` = '".$bidcount."',
	`bidprice` = '".$bidprice."'
	WHERE `auction_id` = '".$auction_id.APOS;
	$auctions_update = olc_db_query($sqlstring);
}

function update_ended($starttime, $endtime, $auction_id){
	$sqlstring =
	SQL_UPDATE.TABLE_AUCTION_LIST."  SET
	`starttime` = '".$starttime."',
	`endtime` = '".$endtime."',
	`ended` = '1'
	WHERE `auction_id` = '".$auction_id.APOS;
	$auctions_update = olc_db_query($sqlstring);
}

function check_time_dif(){
	$actualtime = toGMT(date(AUCTIONS_DATE_FORMAT));
	$update_time = olc_db_fetch_array(olc_db_query(SELECT."event_update_time".SQL_FROM.TABLE_EBAY_CONFIG.SQL_WHERE."id=1"));
	$lastupdatetime = $update_time['event_update_time'];
	if($lastupdatetime)
	{
		$lastupdatetime = explode(BLANK,$lastupdatetime);
		$actualtime = explode(BLANK,$actualtime);
		if($lastupdatetime[0]==$actualtime[0])
		{
			$tmp = explode(COLON,$actualtime[1]);
			$myactualtime = ($tmp[0]*60*60)+($tmp[1]*60)+$tmp[2];
			$tmp = explode(COLON,$lastupdatetime[1]);
			$mylastupdatetime = ($tmp[0]*60*60)+($tmp[1]*60)+$tmp[2];
			$dif = $myactualtime - $mylastupdatetime;
			return $dif > 1800;
		}
		else
		{
			return true;
		}
	}
	else
	{
		return true;
	}
}

/**
* get_New_Events
* $mySession: Ebay_Acct Session
* $to: actual timestamp
* return $tmp: array, including all actual information
*****/
function get_new_Events($session, $to){
	$event_update_time = olc_db_query(SELECT ."event_update_time from ".TABLE_EBAY_CONFIG);
	$update_time = olc_db_fetch_array($event_update_time);
	$myupdate_time = $update_time['event_update_time'];
	if($myupdate_time)
	{
		$from = $myupdate_time;
	}
	else
	{
		$event_first_time = olc_db_query(SELECT."starttime".SQL_FROM .TABLE_AUCTION_LIST." ORDER BY starttime ASC");
		$first_time = olc_db_fetch_array($event_first_time);
		$from = $first_time['starttime'];
	}
	$cs = new EbatNs_ServiceProxy($session);
	$req = new GetSellerEventsRequestType();
	$req->setModTimeFrom($from);
	$req->setModTimeTo($to);
	$req->setNewItemFilter(false);
	$res = $cs->GetSellerEvents($req);
	if ($res->getAck() == 'Success'){
		$itemarray = $res->getItemArray();
		for($i=0; $i<count($itemarray); $i++){
			$myitemid = $itemarray[$i]->getItemID();
			$item_sellingstatus = $itemarray[$i]->getSellingStatus();
			$item_listingdetails = $itemarray[$i]->getListingDetails();
			$tmp[$myitemid] = array(
			'endtime' => $item_listingdetails->getEndTime(),
			'bidcount' => $item_sellingstatus->getBidCount(),
			'price' => $item_sellingstatus->CurrentPrice->value);
		}
		olc_db_query(SQL_UPDATE .TABLE_EBAY_CONFIG." SET `event_update_time` = '".$to.APOS.SQL_WHERE."`id` =1");
	}
	return $tmp;
}

function get_new_Transactions($session, $to){
	$transaction_update_time = olc_db_query(SELECT ."transaction_update_time from ".TABLE_EBAY_CONFIG);
	$update_time = olc_db_fetch_array($transaction_update_time);
	$transaction_update_time= $update_time['transaction_update_time'];
	if($transaction_update_time == NULL){
		$event_first_time = olc_db_query(SELECT."starttime".SQL_FROM.TABLE_AUCTION_LIST." ORDER BY starttime ASC");
		$first_time = olc_db_fetch_array($event_first_time);
		$from = $first_time['starttime'];
	}
	else
	{
		$from = $transaction_update_time;
	}
	//update time
	$cs = new EbatNs_ServiceProxy($session);
	$req = new GetSellerTransactionsRequestType();
	$req->setModTimeFrom($from);
	$req->setModTimeTo($to);
	$res = $cs->GetSellerTransactions($req);
	$transactions = $res->getTransactionArray();

	if ($res->getAck() == 'Success')
	{
		for($i=0; $i<count($transactions); $i++)
		{
			$transaction=$transactions[$i];
			$tmp[$transaction->Item->getItemID()][$transaction->getTransactionID()] = array(
			'endtime' => $transaction->getCreatedDate(),
			'price' => $transaction->Item->SellingStatus->CurrentPrice->value,
			'amount' => $transaction->getQuantityPurchased(),
			'buyerid' => $transaction->Buyer->getUserID(),
			'buyer_name' => $transaction->Buyer->RegistrationAddress->getName(),
			'buyer_email' => $transaction->Buyer->getEmail(),
			'buyer_land' => $transaction->Buyer->BuyerInfo->ShippingAddress-> getCountryName(),
			'buyer_countrycode' => $transaction->Buyer->BuyerInfo->ShippingAddress->getCountry(),
			'buyer_state' => $transaction->Buyer->BuyerInfo->ShippingAddress->getStateOrProvince(),
			'buyer_zip' => $transaction->Buyer->BuyerInfo->ShippingAddress-> getPostalCode(),
			'buyer_city' => $transaction->Buyer->BuyerInfo->ShippingAddress-> getCityName(),
			'buyer_street' => $transaction->Buyer->BuyerInfo->ShippingAddress-> getStreet(),
			'buyer_phone' => $transaction->Buyer->getPhone(),
			);
		}
		$update_time = olc_db_query(SQL_UPDATE.TABLE_EBAY_CONFIG." SET `transaction_update_time` = '".$to.APOS.SQL_WHERE."`id` =1");
	}

	return $tmp;
}

function update_auction_details($auctionsSession){
	$transactions = get_new_Transactions($auctionsSession, toGMT(date(AUCTIONS_DATE_FORMAT)));
	$auctionssql = SELECT_ALL.TABLE_AUCTION_LIST." ORDER BY auction_id";
	$auctions = olc_db_query($auctionssql);
	$mynewstarttime = toGMT(date(AUCTIONS_DATE_FORMAT));
	$comma="','";
	$sqlstring0=INSERT_INTO.TABLE_AUCTION_DETAILS ." (
		`auction_id`,
		`transaction_id`,
		`endtime`,
		`auction_endprice`,
		`amount`,
		`buyer_id`,
		`buyer_name`,
		`buyer_email`,
		`buyer_phone`,
		`buyer_countrycode`,
		`buyer_land`,
		`buyer_state`,
		`buyer_zip`,
		`buyer_city`,
		`buyer_street`,
		`basket`,
		`order_number`)
	VALUES (NULL".$comma;
	while ($auctions_values = olc_db_fetch_array($auctions))
	{
		$transaction=$transactions[$auctions_values['auction_id']];
		if($transaction)
		{
			foreach($transaction as $key => $trans)
			{
				$sqlstring = $sqlstring0.
				$auctions_values['auction_id'].$comma.
				$key.$comma.
				$trans['endtime'].$comma.
				$trans['price'].$comma.
				$trans['amount'].$comma.
				$trans['buyerid'].$comma.
				$trans['buyer_name'].$comma.
				$trans['buyer_email'].$comma.
				$trans['buyer_phone'].$comma.
				$trans['buyer_countrycode'].$comma.
				$trans['buyer_land'].$comma.
				$trans['buyer_state'].$comma.
				$trans['buyer_zip'].$comma.
				$trans['buyer_city'].$comma.
				$trans['buyer_street'].$comma.
				"','1','0')";
				$mytransactions = olc_db_query($sqlstring);
			}
		}
		else if($auctions_values['endtime'] <= $mynewstarttime)
		{
			update_ended($auctions_values['starttime'], $auctions_values['endtime'], $auctions_values['auction_id']);
		}
	}
}

function sendemail($emailtext, $email)
{
	$usersql = SELECT_ALL. TABLE_CUSTOMERS.SQL_WHERE."customers_email_address ='".$email.APOS;
	$myuser = olc_db_query($usersql);
	$myuser_values = olc_db_fetch_array($myuser);
	$stack = explode(COLON, $myuser_values['customers_password']);
	$link0=HTTP_CATALOG_SERVER.DIR_WS_CATALOG;
	$link = $link0.FILENAME_CUSTOMER_DEFAULT;

	$smarty->assign('HOME_LINK',$link);
	$link = $link0.FILENAME_LOGIN."?action=auction&email_address=".$email."&password=".$stack[0];
	$smarty->assign('LOGIN_LINK',$link);

	$smarty->assign('address_label_customer',
	olc_address_format($order->customer['format_id'], $order->customer, 1, EMPTY_STRING, HTML_BR));
	$smarty->assign('address_label_shipping',
	olc_address_format($order->delivery['format_id'], $order->delivery, 1, EMPTY_STRING, HTML_BR));
	$smarty->assign('address_label_payment',
	olc_address_format($order->billing['format_id'], $order->billing, 1, EMPTY_STRING, HTML_BR));
	$smarty->assign('csID',$order->customer['csID']);
	$smarty->assign('DATE',olc_date_long($order->info['date_purchased']));

	$smarty->assign('order_data', $order_data);
	$smarty->assign('order_total', $order_total);

	$smarty->assign('NAME',$order->customer['name']);
	$smarty->assign('EMAIL',$order->customer['email_address']);
	$smarty->assign('FON',$order->customer['telephone']);
	if (NO_TAX_RAISED)
	{
		$tax_information=BOX_LOGINBOX_NO_TAX_TEXT;
	}
	else
	{
		if (CUSTOMER_SHOW_PRICE)
		{
			$tax_information=PRICES_DISCLAIMER_INCL;
		}
		else
		{
			$tax_information=PRICES_DISCLAIMER_EXCL;
		}
	}
	$smarty->assign('TAX_INFORMATION',$tax_information);
	$file=FULL_CURRENT_TEMPLATE."stylesheet.css";
	$debug_output="file: ".$file.HTML_BR;
	if (file_exists($file))
	{
		$style=file_get_contents($file);
		$poss=strpos($style,"body");
		if (!($poss===false))
		{
			$pose=strpos($style,"}",$poss);
			if (!($pose===false))
			{
				$style_body=substr($style,0,$pose+1);
				$s="\t\t\t";
				$style_body=str_replace("../../",HTTP_SERVER.DIR_WS_CATALOG,$style_body);
				$style_body=$s.str_replace(NEW_LINE,NEW_LINE.$s,$style_body);
				$smarty->assign('STYLE',$style_body);
			}
		}
	}

	$template=ADMIN_PATH_PREFIX.'order_mail_ebay';
	$html_mail=$smarty->fetch($template.HTML_EXT);

	$firstname=$myuser_values['customers_firstname'];
	$lastname=$myuser_values['customers_lastname'];
	// create subject
	$order_subject=str_replace('{$nr}',$insert_id,EMAIL_BILLING_SUBJECT_ORDER);
	$order_subject=str_replace('{$date}',strftime(DATE_FORMAT_LONG),$order_subject);
	$order_subject=str_replace('{$firstname}',$firstname,$order_subject);
	$order_subject=str_replace('{$lastname}',$lastname,$order_subject);
	$eMail=$order->customer['email_address'];
	$name=trim($firstname.BLANK.$lastname);
	// send mail to admin
	olc_php_mail(
	$email,
	$name,
	EMAIL_BILLING_FORWARDING_STRING ,
	STORE_NAME,
	EMPTY_STRING,
	EMPTY_STRING,
	EMPTY_STRING,
	EMPTY_STRING,
	EMPTY_STRING,
	AUCTIONS_TEXT_AUCTION_SOLD_EMAIL_SUBJECT,
	$html_mail ,
	EMPTY_STRING,
	EMAIL_TYPE_HTML);

	// send mail to customer
	olc_php_mail(
	EMAIL_BILLING_ADDRESS,
	EMAIL_BILLING_NAME,
	$email,
	$name,
	EMPTY_STRING,
	EMAIL_BILLING_REPLY_ADDRESS,
	EMAIL_BILLING_REPLY_ADDRESS_NAME,
	EMPTY_STRING,
	EMPTY_STRING,
	AUCTIONS_TEXT_AUCTION_SOLD_EMAIL_SUBJECT,
	$html_mail ,
	EMPTY_STRING,
	EMAIL_TYPE_HTML);

	/*
	$emailcontent = "Guten Tag ".trim($myuser_values['customers_firstname'].BLANK.$myuser_values['customers_lastname'])."!\n\n";
	$emailcontent .= "Sie haben folgende Artikel bei unserer Ebay-Auktion ersteigert:\n";
	$emailcontent .= $emailtext."\n\n";
	$emailcontent .= "Die Artikel warten bereits im Warenkorb unseres Onlineshops auf Sie.\n";
	$emailcontent .= "Über diesen Link ".$link." kommen sie direkt zu den ersteigerten Artikeln.\n\n";
	$emailcontent .= "Dankesfloskel\n";
	$emailcontent .= "Mit freundlichen Grüßen\n";
	$emailcontent .= STORE_NAME.NEW_LINE.STORE_OWNER;
	olc_mail($myuser_values['customers_firstname'].BLANK.$myuser_values['customers_lastname'],$email,
	"Ebay Auktion - Abwicklung", $emailcontent, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
	*/
}

function update_auction_list()
{
	$ebatns_dir=DIR_WS_INCLUDES.'EbatNs'.SLASH;
	require_once $ebatns_dir.'EbatNs_ServiceProxy.php';
	require_once $ebatns_dir.'EbatNs_Logger.php';
	require_once $ebatns_dir.'GetSellerEventsRequestType.php';
	$mySession =create_ebay_session();
	if ($mySession )
	{
		//look for auction details of ended auctions
		update_auction_details($session);
		$resultstring = AUCTIONS_TEXT_AUCTION_LIST_STATUS_SUCCESS;
		$mynewstarttime = toGMT(date(AUCTIONS_DATE_FORMAT));
		$eventarray = get_new_Events($mySession, $mynewstarttime);
		$auctionssql = SELECT_ALL.TABLE_AUCTION_LIST.SQL_WHERE."auction_list.ended!=1 AND auction_list.starttime <= '".
		$mynewstarttime."' ".$ordersql;
		$myauctions = olc_db_query($auctionssql);
		while ($auctions_values = olc_db_fetch_array($myauctions))
		{
			$mybidcount = $auctions_values['bidcount'];
			//look if spec. auctionitem has some new events
			$auction_id=$auctions_values['auction_id'];
			$current_eventarray=$eventarray[$auction_id];
			if(isset($current_eventarray))
			{
				$endtime=$auctions_values['endtime'];
				$starttime=$auctions_values['starttime'];
				$bidcount = $current_eventarray['bidcount'];
				$bidprice = $current_eventarray['price'];
				$endtime = $current_eventarray['endtime'];
				if(($bidcount > $mybidcount) && ($endtime <= $endtime))
				{
					update_bidcount($starttime, $endtime, $bidcount, $bidprice,$auction_id);
				}
				else if($endtime > $endtime)
				{
					update_ended($starttime, $endtime, $auction_id);
				}
			}
			else if($endtime <= $mynewstarttime)
			{
				update_ended($starttime, $endtime, $auction_id);
			}
		}
		return true;
	}
	else
	{
		return false;
	}
}
?>