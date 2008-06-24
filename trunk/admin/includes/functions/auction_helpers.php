<?php
/* --------------------------------------------------------------
$Id: auction_helpers.php,v 1.1.1.1.2.1 2007/04/08 07:16:43 gswkaiser Exp $

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

$ebatns_dir=DIR_WS_INCLUDES.'EbatNs'.SLASH;
require_once DIR_WS_FUNCTIONS.'auction_list_helper.php';

function create_ebay_session()
{
/*
Site-id 0:		ebay.com
Site-id 2:		ebay.ca
Site-id 3:		ebay.co.uk
Site-id 15:		ebay.au
Site-id 16:		ebay.at
Site-id 23:		ebay.be
Site-id 71:		ebay.fr
Site-id 77:		ebay.de
Site-id 100:	ebaymotors.com
Site-id 101:	ebay.it
Site-id 123:	ebay.be
Site-id 146:	ebay.nl
Site-id 186:	ebay.es
Site-id 193:	ebay.ch
Site-id 196:	ebay.tw
Site-id 201:	ebay.hk
Site-id 203:	ebay.in
Site-id 207:	ebay.my
Site-id 211:	ebay.ph
Site-id 212:	ebay.pl
Site-id 216:	ebay.sg
Site-id 218:	ebay.se
Site-id 223:	ebay.cn
*/
	$site_id=77; 	//ebay.de
	$app_mode=EBAY_TEST_MODE==TRUE_STRING_S;
	if ($app_mode)
	{
		if (
			defined('EBAY_TEST_MODE_DEVID') &&
			defined('EBAY_TEST_MODE_APPID') &&
			defined('EBAY_TEST_MODE_CERTID') &&
			defined('EBAY_TEST_MODE_TOKEN')
		)
		{

			$devid=EBAY_TEST_MODE_DEVID;
			$appid=EBAY_TEST_MODE_APPID;
			$certid=EBAY_TEST_MODE_CERTID;
			$token=EBAY_TEST_MODE_TOKEN;
		}
	}
	else
	{
		if (
			defined('EBAY_PRODUCTION_DEVID') &&
			defined('EBAY_PRODUCTION_APPID') &&
			defined('EBAY_PRODUCTION_CERTID') &&
			defined('EBAY_PRODUCTION_TOKEN')
			)
		{
			$devid=EBAY_PRODUCTION_DEVID;
			$appid=EBAY_PRODUCTION_APPID;
			$certid=EBAY_PRODUCTION_CERTID;
			$token=EBAY_PRODUCTION_TOKEN;
		}
	}
	if ($devid  && $appid  && $certid  && $token)
	{
		$ebsession = new EbatNs_Session();
		$ebsession->setDevId($devid);
		$ebsession->setAppId($appid);
		$ebsession->setCertId($certid);
		$ebsession->setSiteId($site_id);
		$ebsession->setAppMode($app_mode);
		$ebsession->setUseHttpCompression(true);
		// switch to token-mode
		$ebsession->setTokenMode(1);
		// do NOT read the token from the file
		$ebsession->setTokenUsePickupFile(false);
		$ebsession->setRequestToken($token);

		return $ebsession;
	}
	else
	{
		return false;
	}
}

function GMT1($time)
{
	$zeit = localtime(time(),1);
	$sommerzeit = $zeit[tm_isdst];
	if ($sommerzeit)
	{
		$step = 2;
	}
	else
	{
		$step = 1;
	}
	$mytime = substr($time,11);
	$time_array = explode(COLON,$mytime);
	$mydate = substr($time,0,10);
	$date_array = explode(DASH,$mydate);
	$newtime = date(AUCTIONS_DATE_FORMAT,mktime($time_array[0]+$step,$time_array[1],$time_array[2],$date_array[1],
	$date_array[2],$date_array[0]));
	return $newtime;
}

function toGMT($time)
{
	$zeit = localtime(time(),1);
	$sommerzeit = $zeit[tm_isdst];
	if ($sommerzeit)
	{
		$step = 2;
	}
	else
	{
		$step = 1;
	}
	$mytime = substr($time,11);
	$time_array = explode(COLON,$mytime);
	$mydate = substr($time,0,10);
	$date_array = explode(DASH,$mydate);
	$newtime = date(AUCTIONS_DATE_FORMAT,
	mktime($time_array[0]-$step,$time_array[1],$time_array[2],$date_array[1],$date_array[2],$date_array[0]));
	return $newtime;
}

function addNewUser($buyer_values,&$customer_id)
{
	$names = explode(BLANK,$buyer_values['buyer_name']);
	$lastname = EMPTY_STRING;
	for($i=1,$n=count($names);$i<=$n;$i++)
	{
		$lastname .= $names[$i];
		if ($i<$n)
		{
			$lastname .= BLANK;
		}
	}
	$sql_data_array =
	array(
	'customers_firstname' => $names[0],
	'customers_lastname' => $lastname,
	'customers_email_address' => $buyer_values['buyer_email'],
	'customers_telephone' => EMPTY_STRING,
	'customers_fax' => EMPTY_STRING,
	'customers_newsletter' => EMPTY_STRING,
	'customers_password' => olc_encrypt_password($buyer_values['buyer_id']),
	'customers_gender' => EMPTY_STRING,
	'customers_dob' => date("Y-m-d"));
	olc_db_perform(TABLE_CUSTOMERS, $sql_data_array);
	$customer_id = olc_db_insert_id();
	$buyer_countrycode=$buyer_values['buyer_countrycode'];
	if ($buyer_countrycode)
	{
		$sqlstring = SELECT_ALL. TABLE_COUNTRIES." WHERE `countries_iso_code_2` = '".$buyer_countrycode.APOS;
		$mycountry = olc_db_fetch_array(olc_db_query($sqlstring));
		//echo $mycountry['countries_id']."<hr/>";
	}
	$sql_data_array =
	array(
	'customers_id' => $customer_id,
	'entry_firstname' => $names[0],
	'entry_lastname' => $lastname,
	'entry_street_address' => $buyer_values['buyer_street'],
	'entry_postcode' => $buyer_values['buyer_zip'],
	'entry_city' => $buyer_values['buyer_city'],
	'entry_country_id' => $mycountry['countries_id'],
	'entry_gender' => EMPTY_STRING,
	'entry_company' => EMPTY_STRING,
	'entry_suburb' => EMPTY_STRING,
	'entry_zone_id' => EMPTY_STRING,
	'entry_state' => $buyer_values['buyer_land']);
	olc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
	$address_id = olc_db_insert_id();
	//update customer table with address id
	olc_db_query(SQL_UPDATE . TABLE_CUSTOMERS . " set customers_default_address_id = '" . $address_id . "'
	where customers_id = '" . $customer_id . APOS);
	//update customer_info table
	olc_db_query(INSERT_INTO . TABLE_CUSTOMERS_INFO . "
	(customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values
	('" . $customer_id . "', '0', now())");
	$_SESSION['customer_default_address_id']=$address_id;
}

function addAuctionsInBasket($buyeremail,$build_cart=false)
{
	$productssql = SELECT." l.auction_id, l.auction_title, l.starttime, d.endtime,
	l.product_id, d.amount, d.auction_endprice, c.customers_id,	d.basket FROM ".
	TABLE_AUCTION_LIST." l, ".TABLE_AUCTION_DETAILS." d, ".TABLE_CUSTOMERS.	"c
	WHERE
	c.customers_email_address = d.buyer_email AND
	l.auction_id = d.auction_id AND
	d.basket=1 AND
	d.order_number = 0 AND
	d.buyer_email='".olc_db_input($buyeremail).APOS;
	$myproducts = olc_db_query($productssql);
	if ($build_cart)
	{
		$smarty->assign('AUCTION_MESSAGE',AUCTIONS_TEXT_AUCTION_MESSAGE);
	}
	else
	{
		$products_text = AUCTIONS_TEXT_AUCTION_MESSAGE."\n\n";
	}
	$comma="','";

	$sqlquery0 =
	INSERT_INTO . TABLE_CUSTOMERS_BASKET . " (
			customers_id,
			products_id,
			customers_basket_quantity,
			final_price,
			customers_basket_date_added,
			auction,
			auctionid)
			values ('";
	$attributes_sql=
	SELECTT."distinct(options_id) from ".TABLE_PRODUCTS_ATTRIBUTES." where products_id = '#'";
	while ($products_values = olc_db_fetch_array($myproducts))
	{
		$product_id=$products_values['product_id'];
		$my_sql_query = str_replace(HASH,$product_id,$attributes_sql);
		$check_attribute_query = olc_db_query($my_sql_query);
		$attributes_options_sql=SELECT."options_values_id FROM " . TABLE_PRODUCTS_ATTRIBUTES . " where
			  products_id = '".$product_id."' and
			  options_id = '#' and
			  options_values_price <= '0'";
		$myattribute_ids = EMPTY_STRING;
		while ($check_attribute = olc_db_fetch_array($check_attribute_query))
		{
			$options_id=$check_attribute['options_id'];
			$products_options_array = array();
			$sql_query = str_replace(HASH,$options_id,$attributes_options_sql);
			$attribute_query = olc_db_query($sql_query);
			$products_options = olc_db_fetch_array($attribute_query);
			$myattribute_ids .= "{".$options_id."}".$products_options['options_values_id'];
		}
		$customers_id=$products_values['customers_id'];
		$auction_id=olc_db_input($products_values['auction_id']);
		$product_id_myattribute_ids=olc_db_input($product_id.$myattribute_ids);
		$products_qty=$products_values['amount'];
		$auction_endprice=olc_db_input($products_values['auction_endprice']);
		$sqlquery =$sqlquery0.
		$customers_id . $comma .
		$product_id_myattribute_ids . $comma .
		$products_qty . $comma .
		$auction_endprice . $comma .
		date('Ymd') .  $comma .
		"1" . $comma .
		$auction_id . "')";
		olc_db_query($sqlquery);
		$sqlattributequery0=INSERT_INTO . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
				(customers_id, products_id, products_options_id, products_options_value_id, auctionid)
				values ('";
		$tmpattid = explode("{",$myattribute_ids);
		for($i=1,$n=count($tmpattid);$i<$n;$i++)
		{
			$tmp = explode("}",$tmpattid[$i]);
			$myoptionid = $tmp[0];
			$myattvalueid = $tmp[1];
			$sqlattributequery = $sqlattributequery0 .
			$customers_id . $comma .
			$product_id_myattribute_ids . $comma .
			$myoptionid . $comma .
			$myattvalueid . $comma.
			$auction_id."')";
			olc_db_query($sqlattributequery);
		}
		SQL_UPDATE.TABLE_AUCTIONS_LIST." SET
		`starttime` = '".$products_values['starttime']."',
		`endtime` = '".$products_values['endtime']."',
		`basket` = '1'
		WHERE
		auctions_id` = '".$auction_id.APOS;
		$auctions_update = olc_db_query($sqlstring);

		if ($build_cart)
		{
			$quantity_in_cart=$_SESSION['cart']->get_quantity($product_id_myattribute_ids);
			$_SESSION['cart']->add_cart($product_id,$quantity_in_cart+$products_qty, $product_id_myattribute_ids);
		}
		else
		{
			$products_text .= $products_qty." x ".$products_values['auction_title'];
			$products_text .= " = ".($products_qty*$auction_endprice).NEW_LINE;
		}
	}
	return $products_text;
}

function table_sort_pic($newsort, $oldsort, $sort_image)
{
	if ($newsort != $oldsort)
	{
		$my_sort_images = EMPTY_STRING;
	}
	else
	{
		$my_sort_image = $sort_image;
	}
	return $my_sort_image;
}

function tableheading($heading)
{
	$tablehead = EMPTY_STRING;
	$tablehead .= "<tr class='dataTableHeadingRow'>";
	for($i=0;$i<count($heading);$i++)
	{
		$current_heading=$heading[$i];
		$current_heading_sort=$current_heading['sort'];
		$tablehead .= "<td class='dataTableHeadingContent' valign='top' ".$current_heading['attributes'].">";
		if ($current_heading_sort)
		{
			$order = $current_heading_sort['newsort'];
			$tablehead .= HTML_A_START.$current_heading['link']."' class='dataTableHeadingContentLink'>";
		}
		$tablehead .= $current_heading['name'];
		if ($current_heading_sort)
		{
			$tablehead .= HTML_BR.table_sort_pic($current_heading_sort['newsort'], $current_heading_sort['oldsort'],
			$current_heading_sort['sortimg']);
			$tablehead .=HTML_A_END;
		}
		$tablehead .= "</td>";
		if ($i<(count($heading)-1))
	{
			$tablehead .= "<td class='dataTableHeadingContent' valign='top'>|</td>";
		}
	}
	$tablehead .= "</tr>";
	return $tablehead;
}

function tablecontent($content)
{
	$tablecontent = EMPTY_STRING;
	$tablecontent .= "<tr class='".$content['cssclass']."'>";
	$values=$content['values'];
	for($i=0,$n=count($values)-1;$i<=$n;$i++)
	{
		$current_value=$values[$i];
		$tablecontent .= "<td valign='top' ".$current_value['attributes'].">";
		$link=$current_value['link'];
		if ($link)
		{
			$tablecontent .= HTML_A_START.$link."' ".$current_value['linkattributes'].">";
		}
		$tablecontent .= $content[values][$i][value];
		if ($link)
		{
			$tablecontent .=HTML_A_END;
		}
		$tablecontent .= "</td>";
		if ($i<$n)
		{
			$tablecontent .= "<td valign='top'>|</td>";
		}
	}
	return $tablecontent;
}
?>