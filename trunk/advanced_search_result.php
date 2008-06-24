<?php
/* -----------------------------------------------------------------------------------------
$Id: advanced_search_result.php,v 1.1.1.1.2.1 2007/04/08 07:16:03 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(advanced_search_result.php,v 1.68 2003/05/14); www.oscommerce.com
(c) 2003	    nextcommerce (advanced_search_result.php,v 1.17 2003/08/21); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include('includes/application_top.php');

//// include needed functions
require_once(DIR_FS_INC.'olc_parse_search_string.inc.php');
require_once(DIR_FS_INC.'olc_get_subcategories.inc.php');
require_once(DIR_FS_INC.'olc_checkdate.inc.php');
require_once(DIR_FS_INC.'olc_get_currency_parameters.inc.php');

$error = 0; // reset error flag to false
$errorno = 0;
$pfrom_to_check = trim($_GET['pfrom']);
$pto_to_check =  trim($_GET['pto']);
$dfrom_to_check= trim($_GET['dfrom']);
$dto_to_check= trim($_GET['dto']);
$keywords=trim($_GET['keywords']);

if ((isset($keywords) && empty($keywords)) &&
(isset($dfrom_to_check) && (empty($dfrom_to_check) || ($dfrom_to_check == DOB_FORMAT_STRING))) &&
(isset($dto_to_check) && (empty($dto_to_check) || ($dto_to_check == DOB_FORMAT_STRING))) &&
(isset($pfrom_to_check) && empty($pfrom_to_check)) &&
(isset($pto_to_check) && empty($pto_to_check)) ) {
	$errorno += 1;
	$error = 1;
}

$dfrom_to_check = (($dfrom_to_check == DOB_FORMAT_STRING) ? EMPTY_STRING : $dfrom_to_check);
$dto_to_check = (($dto_to_check == DOB_FORMAT_STRING) ? EMPTY_STRING : $dto_to_check);

if (strlen($dfrom_to_check) > 0) {
	if (!olc_checkdate($dfrom_to_check, DOB_FORMAT_STRING, $dfrom_to_check_array)) {
		$errorno += 10;
		$error = 1;
	}
}

if (strlen($dto_to_check) > 0) {
	if (!olc_checkdate($dto_to_check, DOB_FORMAT_STRING, $dto_to_check_array)) {
		$errorno += 100;
		$error = 1;
	}
}

if (strlen($dfrom_to_check) > 0 && !(($errorno & 10) == 10) && strlen($dto_to_check) > 0 && !(($errorno & 100) == 100)) {
	if (mktime(0, 0, 0, $dfrom_to_check_array[1], $dfrom_to_check_array[2], $dfrom_to_check_array[0]) > mktime(0, 0, 0, $dto_to_check_array[1], $dto_to_check_array[2], $dto_to_check_array[0])) {
		$errorno += 1000;
		$error = 1;
	}
}
if (strlen($pfrom_to_check) > 0) {
	if (!settype($pfrom_to_check, "double")) {
		$errorno += 10000;
		$error = 1;
	}
}
if (strlen($pto_to_check) > 0) {
	if (!settype($pto_to_check, "double")) {
		$errorno += 100000;
		$error = 1;
	}
}
if (strlen($pfrom_to_check) > 0 && !(($errorno & 10000) == 10000) && strlen($pto_to_check) > 0 && !(($errorno & 100000) == 100000)) {
	if ($pfrom_to_check > $pto_to_check) {
		$errorno += 1000000;
		$error = 1;
	}
}
if (strlen($keywords) > 0) {
	if (!olc_parse_search_string(stripslashes($keywords), $search_keywords)) {
		$errorno += 10000000;
		$error = 1;
	}
}
$categories_id=(int)$_GET['categories_id'];
$inc_subcat == $_GET['inc_subcat'];
if ($error == 1) {
	olc_redirect(olc_href_link(FILENAME_ADVANCED_SEARCH, 'errorno=' . $errorno . '&' . olc_get_all_get_params(array('x', 'y'))));
} else {
	$breadcrumb->add(NAVBAR_TITLE1_ADVANCED_SEARCH, olc_href_link(FILENAME_ADVANCED_SEARCH));
	$breadcrumb->add(NAVBAR_TITLE2_ADVANCED_SEARCH, olc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'keywords=' . $keywords . '&search_in_description=' . $_GET['search_in_description'] . '&categories_id=' . $categories_id . '&inc_subcat=' . $inc_subcat . '&manufacturers_id=' . $_GET['manufacturers_id'] . '&pfrom=' . $pfrom_to_check . '&pto=' . $pto_to_check . '&dfrom=' . $dfrom_to_check . '&dto=' . $dto_to_check));

	require(DIR_WS_INCLUDES . 'header.php');

	//fsk18 lock
	if ($_SESSION['customers_status']['customers_fsk18_display']=='0') {
		$fsk_lock=' and p.products_fsk18!=1';
	}
	else
	{
		$fsk_lock=EMPTY_STRING;
	}
	// create column list
	$select_str = PRODUCTS_FIELDS.COMMA.'
m.manufacturers_name' ;
	if ( (DISPLAY_PRICE_WITH_TAX == TRUE_STRING_S) && ( (isset($pfrom_to_check) && olc_not_null($pfrom_to_check)) ||
	(isset($pto_to_check) && olc_not_null($pto_to_check))) ) {
		$select_str .= ", SUM(tr.tax_rate) as tax_rate ";
	}

	$from_str = SQL_FROM .
	TABLE_PRODUCTS . " p
			left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id
			inner join " .TABLE_PRODUCTS_DESCRIPTION . " pd
			left join " . TABLE_SPECIALS ." s on p.products_id = s.products_id
			inner join " . TABLE_CATEGORIES . " c
			inner join ". TABLE_PRODUCTS_TO_CATEGORIES . " p2c";
	if ((DISPLAY_PRICE_WITH_TAX == TRUE_STRING_S) && ((isset($pfrom_to_check)) ||
		(isset($pto_to_check))))
	{
		/*
		if (!isset($_SESSION['customer_country_id'])) {
			$_SESSION['customer_country_id'] = STORE_COUNTRY;
			$_SESSION['customer_zone_id'] = STORE_ZONE;
		}
		*/
		$from_str .= "
			left join " . TABLE_TAX_RATES . " tr on p.products_tax_class_id = tr.tax_class_id
			left join " . TABLE_ZONES_TO_GEO_ZONES .
			" gz on tr.tax_zone_id=gz.geo_zone_id and (gz.zone_country_id is null or gz.zone_country_id='0' or gz.zone_country_id='" .
			CUSTOMER_COUNTRY_ID . "') and (gz.zone_id is null or gz.zone_id = '0' or gz.zone_id = '" .
			CUSTOMER_ZONE_ID . "')";
	}
	if (DO_GROUP_CHECK) {
		$group_check="  and p.".SQL_GROUP_CONDITION;
	}
	$where_str = "
	where
	p.products_status = 1 ".$fsk_lock." and
	p.products_id = pd.products_id
	and pd.language_id = " . SESSION_LANGUAGE_ID . "
	and p.products_id = p2c.products_id
	".$group_check."
	and p2c.categories_id = c.categories_id ";
	if (isset($categories_id))
	{
		$where_str .= "
		and p2c.products_id = p.products_id
		and p2c.products_id = pd.products_id
		and pd.language_id = " .SESSION_LANGUAGE_ID. "
		and p2c.categories_id ";
		if ($inc_subcat == '1')
		{
			$subcategories_array = array();
			olc_get_subcategories($subcategories_array, $categories_id);
			$where_str .= "in ".
			LPAREN .$categories_id;
			for ($i=0, $n=sizeof($subcategories_array); $i<$n; $i++ )
			{
				$where_str .= COMMA.$subcategories_array[$i];
			}
			$where_str .= RPAREN;
		}
		else
		{
			$where_str .= EQUAL . $categories_id;
		}
	}
	if (isset($_GET['manufacturers_id']))
	{
		$where_str .= " and m.manufacturers_id = '" . $_GET['manufacturers_id'] . APOS;
	}
	if (isset($keywords)) {
		if (olc_parse_search_string(stripslashes($keywords), $search_keywords)) {
			$where_str .= " and (";
			for ($i=0, $n=sizeof($search_keywords); $i<$n; $i++ ) {
				switch ($search_keywords[$i]) {
					case '(':
					case RPAREN:
					case 'and':
					case 'or':
						$where_str .= BLANK . $search_keywords[$i] . BLANK;
						break;
					default:
						$search_keyword=addslashes(str_replace(APOS,"\\'",$search_keywords[$i]));
						$like=" like '%" . $search_keyword . "%'";
						$sql_or=" or ";
						$like_or=$like.$sql_or;
						$where_str .=LPAREN."
						pd.products_name".$like_or."
						p.products_model".$like_or."
						m.manufacturers_name".$like;
						if ($_GET['search_in_description'] == '1')
						{
							$where_str .= $sql_or.
							"pd.products_description".$like;
						}
						$where_str .= RPAREN;
						break;
				}
			}
			$where_str .= RPAREN;
		}
	}
	$sql_and=" and p.products_date_added ";
	if ($dfrom_to_check)
	{
		if ($dfrom_to_check != DOB_FORMAT_STRING)
		{
			$where_str .= $sql_and.">= '".olc_date_raw($dfrom_to_check) . APOS;
		}
	}
	if ($dto_to_check)
	{
		if ($dto_to_check != DOB_FORMAT_STRING)
		{
			$where_str .=$sql_and."<= '".olc_date_raw($dto_to_check) . APOS;
		}
	}
	$sql_and=" and (if (s.status, s.specials_new_products_price, p.products_price) ";
	if ($pfrom_to_check != EMPTY_STRING)
	{
		$where_str .= $sql_and . ">= ". $pfrom_to_check / CURRENCY_VALUE . RPAREN;
	}
	if ($pto_to_check != EMPTY_STRING)
	{
		$where_str .= $sql_and . "<= ".  $pto_to_check / CURRENCY_VALUE . RPAREN;
	}
	$order_str = ' group by pd.products_name order by pd.products_name';
	$products_listing_sql_main = $select_str . $from_str . $where_str . $order_str;

	if (
		defined("MODULE_TAG_CLOUD_STATUS") && 
		MODULE_TAG_CLOUD_STATUS == TRUE_STRING_L &&
		!olc_not_null($_GET['categories_id']) &&
		!olc_not_null($_GET['manufacturers_id']) &&
		!strlen($_GET['pfrom']) &&
		!strlen($_GET['pto']) &&
		($cloudTag = $keywords) != EMPTY_STRING) 
	{
		$s='tag_cloud_tags';
		if (!isset($_SESSION[$s])) 
		{
			$_SESSION[$s] = array();
		}
		$cloudTag = substr($cloudTag, 0, 64);
		if (!in_array($cloudTag, $_SESSION[$s])) 
		{
			$_SESSION[$s][] = $cloudTag;
			$cloudTag = addslashes($cloudTag);
			$cloudLang = SESSION_LANGUAGE_ID;
			$tagTest = olc_db_fetch_array(olc_db_query(
				SELECT_COUNT ."AS count ".
				"FROM 
				module_tag_cloud ".
				"WHERE 
				tag = '".$cloudTag."' AND language_id = ".$cloudLang
			));
			
			$prodTest = olc_db_num_rows(olc_db_query("SELECT 1 ".$from_str.$where_str." LIMIT 1"));
			
			if ($prodTest) {
				if (!isset($_GET["searchTagCloud"])) {
					if ($tagTest["count"]) {
						olc_db_query(
							"UPDATE module_tag_cloud ".
							"SET searches = searches + 1, not_found = 0 ".
							"WHERE tag = '".$cloudTag."' AND language_id = ".$cloudLang
						);
					}
					else {
						$cloudInfos = olc_db_fetch_array(olc_db_query(
							"SELECT AVG(searches + offset) AS offset ".
							"FROM module_tag_cloud ".
							"WHERE language_id = ".$cloudLang
						));
						
						$minSearches = (int)MODULE_TAG_CLOUD_MIN_SEARCHES;
						if ($minSearches < 1) {
							$minSearches = 1;
						}
						
						olc_db_query(
							"INSERT INTO module_tag_cloud ".
							"SET ".
								"tag = '".$cloudTag."',".
								(isset($cloudInfos["offset"])? "offset = ".round($cloudInfos["offset"] - 1)."," : "").
								"language_id = ".$cloudLang.",".
								"inserted = NOW()"
						);
						
						$deleteQuery = olc_db_query(
							"SELECT tag ".
							"FROM module_tag_cloud ".
							"WHERE language_id = ".$cloudLang." ".
							"ORDER BY searches + offset DESC, inserted DESC ".
							"LIMIT ".(int)MODULE_TAG_CLOUD_MAX_TAGS.", 1000"
						);
						
						while($delTag = olc_db_fetch_array($deleteQuery)) {
							olc_db_query(
								"DELETE FROM module_tag_cloud ".
								"WHERE tag = '".addslashes($delTag["tag"])."' AND language_id = ".$cloudLang
							);
						}
					}
				}
			}
			elseif ($tagTest["count"]) {
				olc_db_query(
					"UPDATE module_tag_cloud ".
					"SET not_found = 1 ".
					"WHERE tag = '".$cloudTag."' AND language_id = ".$cloudLang
				);
			}
		}
	}



	$breadcrumb_link=FILENAME_ADVANCED_SEARCH;
	$categories_name_main="Suchergebnisse";
	$categories_description_main=EMPTY_STRING;
	$force_stand_alone=true;
	include(DIR_FS_INC.'olc_prepare_specials_whatsnew_modules.inc.php');
	$force_stand_alone=false;
	//W. Kaiser - AJAX
}
?>