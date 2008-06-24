<?php
/* -----------------------------------------------------------------------------------------
$Id: write_customers_status.php,v 1.1.1.1.2.1 2007/04/08 07:17:46 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (write_customers_status.php,v 1.8 2003/08/1); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------

based on Third Party contribution:
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX
// write customers status in session
$customers_id=$_SESSION['customer_id'];
$customers_status_text='customers_status';
$customers_id_text='customers_id';
$customers_status_lead_text=$customers_status_text.UNDERSCORE;
$customers_status_id_text=$customers_status_lead_text.'id';
if ($customers_id>0)
{
	$session_customers_id=$_SESSION[$customers_status_text][$customers_id_text];
	if ($customers_id<>$session_customers_id)
	{
		$customers_status_query_1_sql =
			SELECT.$customers_status_text.",account_type, customers_default_address_id" .SQL_FROM.
			TABLE_CUSTOMERS . SQL_WHERE .$customers_id_text." = '" . $customers_id . APOS;

		$customers_status_query_1= olc_db_query($customers_status_query_1_sql);
		$customers_status_value_1 = olc_db_fetch_array($customers_status_query_1);
		$customers_status_id=$customers_status_value_1[$customers_status_text];
		// check if zone id is unset bug #0000169
		if (!isset($_SESSION['customer_country_id']))
		{
			$zone_query=olc_db_query(SELECT."entry_country_id
                                     FROM ".TABLE_ADDRESS_BOOK."
                                     WHERE customers_id='".INT_CUSTOMER_ID."' and
                                     address_book_id='".$customers_status_value_1['customers_default_address_id'].APOS);

			$zone=olc_db_fetch_array($zone_query);
			$_SESSION['customer_country_id']=$zone['entry_country_id'];
		}
		$_SESSION['account_type']=$customers_status_value_1['account_type'];
/*
$_SESSION['debug_output'].="<b>write_customers_status 1</b><br/>".
	"customers_id='".$customers_id."', ".HTML_BR.
	"customers_status_id='".$customers_status_id."', ".HTML_BR.
	"customers_status_query_1_sql='".$customers_status_query_1_sql."', ".HTML_BR;
*/
	}
	else
	{
		$customers_status_id=$_SESSION[$customers_status_text][$customers_status_id_text];
	}
	$assign_constants=true;
	//Get customerrs country
	$customers_country_id = olc_db_query(SELECT."entry_country_id, entry_zone_id" .SQL_FROM. TABLE_ADDRESS_BOOK .
		SQL_WHERE."customers_id = '" . $customers_id."' LIMIT 1");
	$customers_country_id=olc_db_fetch_array($customers_country_id);
	$customers_zone_id=$customers_country_id['entry_zone_id'];
	$customers_country_id=$customers_country_id['entry_country_id'];
}
else
{
	$_SESSION['account_type']='0';
	$customers_status_id=DEFAULT_CUSTOMERS_STATUS_ID_GUEST;
	$customers_country_id=STORE_COUNTRY;
	if (!defined('STORE_ZONE'))
	{
		$zone_query = olc_db_query("select zone_id from " . TABLE_ZONES .
		" where zone_country_id = '" . STORE_COUNTRY."' LIMIT 1");
		if (olc_db_num_rows($zone_query))
		{
			$zone_id = olc_db_fetch_array($zone_query);
			$zone_id=$zone_id['zone_id'];
		}
		define('STORE_ZONE',$zone_id);
	}
	$customers_zone_id=STORE_ZONE;
	if (CURRENT_SCRIPT==FILENAME_LOGIN)
	{
		$assign_constants=$_GET['action'] <> "process";
	}
	else
	{
		$assign_constants=true;
	}
}
if ($customers_status_id != $_SESSION[$customers_status_text][$customers_status_id_text])
{
	$customers_status_query_sql=
	SELECT."
		customers_status_name,
		customers_status_discount,
		customers_status_public,
		customers_status_image,
		customers_status_ot_discount_flag,
		customers_status_ot_discount,
		customers_status_graduated_prices,
		customers_status_show_price,
		customers_status_show_price_tax,
		customers_status_add_tax_ot,
		customers_status_payment_unallowed,
		customers_status_shipping_unallowed,
		customers_status_discount_attributes,
		customers_fsk18,
		customers_fsk18_display
		FROM " .
		TABLE_CUSTOMERS_STATUS . "
		WHERE
		customers_status_id = " . $customers_status_id . " AND
		language_id = " . SESSION_LANGUAGE_ID;
	$customers_status_query = olc_db_query($customers_status_query_sql);
	$customers_status_value = olc_db_fetch_array($customers_status_query);
	$session_customers_status= array();
  while (list($key, $value) = each($customers_status_value))
  {
  	$session_customers_status[$key]=$value;
  }
	$_SESSION[$customers_status_text]=$session_customers_status;
	$_SESSION[$customers_status_text][$customers_status_id_text]= $customers_status_id;
	$_SESSION[$customers_status_text][$customers_id_text]= $customers_id;
}
elseif ($assign_constants)
{
	$customers_status_value=$_SESSION[$customers_status_text];
}
if ($assign_constants)
{
	define('CUSTOMER_ID', $customers_id);
	define('CUSTOMER_IS_ADMIN', $customers_status_id==DEFAULT_CUSTOMERS_STATUS_ID_ADMIN);
	define('ISSET_CUSTOMER_ID', CUSTOMER_ID<>EMPTY_STRING);
	define('CUSTOMER_STATUS_ID',$customers_status_id);
	//define('SQL_GROUP_CONDITION',"group_ids LIKE '%c_".$customers_status_id."_group%' OR group_ids='' OR group_ids=null");
	define('SQL_GROUP_CONDITION',"group_ids LIKE '%c_".$customers_status_id."_group%'");
	define('CUSTOMER_SHOW_PRICE', $customers_status_value[$customers_status_lead_text.'show_price']==ONE_STRING);
	define('CUSTOMER_SHOW_PRICE_TAX',
		$customers_status_value[$customers_status_lead_text.'show_price_tax'] == ONE_STRING);
	define('CUSTOMER_SHOW_GRADUATED_PRICE',
		$customers_status_value[$customers_status_lead_text.'graduated_prices']==ONE_STRING);
	define('CUSTOMER_IS_FSK18', $customers_status_value['customers_fsk18']==ONE_STRING);
	define('CUSTOMER_NOT_IS_FSK18', !CUSTOMER_IS_FSK18);
	define('CUSTOMER_IS_FSK18_DISPLAY', $customers_status_value['customers_fsk18_display']==ONE_STRING);
	define('CUSTOMER_DISCOUNT', $customers_status_value[$customers_status_lead_text.'discount']);
	define('CUSTOMER_OT_DISCOUNT', (float)$customers_status_value[$customers_status_lead_text.'ot_discount']);
	define('CUSTOMER_SHOW_OT_DISCOUNT',
		$customers_status_value[$customers_status_lead_text.'ot_discount_flag'] == ONE_STRING);
	define('INT_CUSTOMER_ID', (int)CUSTOMER_ID);
	define('CUSTOMER_COUNTRY_ID',$customers_country_id);
	define('CUSTOMER_ZONE_ID',$customers_zone_id);
	/*
	if ($IsUserMode || $is_auction)
	{
		// testing new price class
		require_once($catalog_class_dir.'olcPrice.php');
		$olPrice = new olcPrice(SESSION_CURRENCY, CUSTOMER_STATUS_ID);

		//Get minimum shipping cost from config-DB!!!!
		$minimum_ship_cost_text='minimum_ship_cost';
		$customers_country_id_text='customers_country_id';
		$minimum_ship_cost=$_SESSION[$minimum_ship_cost_text];
		$is_set=isset($minimum_ship_cost);
		if ($is_set)
		{
			$is_set=CUSTOMER_COUNTRY_ID==$_SESSION[$customers_country_id_text];
		}
		if (!$is_set)
		{
			if (!function_exists('olc_get_countries'))
			{
				require_once(DIR_FS_INC.'olc_get_countries.inc.php');
			}
			$country=olc_get_countries(CUSTOMER_COUNTRY_ID,true);
			if (IS_ADMIN_FUNCTION)
			{
				for ($i=1,$n=sizeof($country);$i<$n;$i++)
				{
					if ($country[$i]['id']==CUSTOMER_COUNTRY_ID)
					{
						$country=$country[$i]['countries_iso_code_2'];
						break;
					}
				}
			}
			else
			{
				$country=$country['countries_iso_code_2'];
			}
			require_once($catalog_class_dir . 'order.php');
			$order = new order;
			$_SESSION['delivery_zone']=$country;
			$order->delivery['country']['iso_code_2']=$country;
			$order->delivery['country']['id']=CUSTOMER_COUNTRY_ID;
			$order->delivery['zone_id']=CUSTOMER_ZONE_ID;
			// load all enabled shipping modules
			require_once($catalog_class_dir . FILENAME_SHIPPING);
			$shipping_modules = new shipping;
			global $total_weight;
			$total_weight=.1;	//Assume low weight
			// get all available shipping quotes
			$quotes = $shipping_modules->quote();
			// cheapest shipping
			$minimum_ship_cost=$shipping_modules->cheapest();
			if ($minimum_ship_cost)
			{
				$minimum_ship_cost=$minimum_ship_cost['cost'];
				$minimum_ship_cost=explode(COMMA,$minimum_ship_cost);
				$minimum_ship_cost=$minimum_ship_cost[0];
			}
			include(DIR_FS_INC.'olc_get_currency_parameters.inc.php');
			$minimum_ship_cost=ltrim(olc_format_price($minimum_ship_cost,true,true,true));
			$_SESSION[$minimum_ship_cost_text]=$minimum_ship_cost;
			$_SESSION[$customers_country_id_text]=CUSTOMER_COUNTRY_ID;
			unset($order);
			unset($_SESSION['delivery_zone']);
			for ($i=0,$n=sizeof($shipping_modules->modules);$i<$n;$i++)
			{
				$order=str_replace(PHP,EMPTY_STRING,$shipping_modules->modules[$i]);
				unset($$order);
			}
			unset($shipping_modules);
		}
		define('PRICE_DISCLAIMER_SHIPMENT_COST',sprintf(PRICE_DISCLAIMER_SHIPMENT_COST_TEXT,$minimum_ship_cost));
		define('PRICE_DISCLAIMER_COMMON',str_replace(HASH,PRICE_DISCLAIMER_SHIPMENT_COST,PRICE_DISCLAIMER_COMMON_TEXT));
	}
	*/
}
//W. Kaiser - AJAX
?>