<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_update_whos_online.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:42 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(whos_online.php,v 1.8 2003/02/21); www.oscommerce.com
(c) 2003	    nextcommerce (olc_update_whos_online.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_update_whos_online($url=EMPTY_STRING)
{
	if (ISSET_CUSTOMER_ID)
	{
		$wo_customer_id = CUSTOMER_ID;
		$customer_query = olc_db_query(SELECT."customers_firstname, customers_lastname from " . TABLE_CUSTOMERS .
		" where customers_id = '" . $_SESSION['customer_id'] . APOS);
		$customer = olc_db_fetch_array($customer_query);
		$wo_full_name = addslashes($customer['customers_firstname'] . BLANK . $customer['customers_lastname']);
	} else {
		$wo_full_name = $_SESSION['customers_status']['customers_status_name'];
		$wo_customer_id = 0;
	}
	$wo_session_id = olc_session_id();
	//$wo_ip_address = getenv('REMOTE_ADDR');
	olc_get_ip_info(&$smarty);
	$wo_ip_address = $_SESSION['CUSTOMERS_IP'];
	$pos=strpos($wo_ip_address,RPAREN);
	if ($pos!==false)
	{
		$wo_ip_address=substr($wo_ip_address,0,$pos+1);
	}
	if (!$url)
	{
		$url=addslashes(getenv('REQUEST_URI'));
	}
	$wo_last_page_url = str_replace(DIR_WS_CATALOG,EMPTY_STRING,$url);
	$pos=strpos($wo_last_page_url,'start_debug');		//Eliminate debugger parameters
	if ($pos===false)
	{
		$pos=strpos($wo_last_page_url,'DBGSESSION');		//Eliminate debugger parameters
	}
	if ($pos!==false)
	{
		$wo_last_page_url=substr($wo_last_page_url,0,$pos-1);
	}
	if (USE_AJAX)
	{
		$pos=strpos($wo_last_page_url,AJAX_ID);
		if ($pos!==false)
		{
			$wo_last_page_url=substr($wo_last_page_url,0,$pos-1).
			substr($wo_last_page_url,$pos+strlen(AJAX_ID));
		}
	}
	$current_time = time();

	//Do garbage collection in session db
	_sess_gc(EMPTY_STRING);
	//Delete all from "whos_online" without a session entry
	//olc_db_query(DELETE_FROM . TABLE_WHOS_ONLINE. ' WHERE session_id NOT IN (SELECT sesskey FROM '.TABLE_SESSIONS.RPAREN);
	$sesskey=TABLE_SESSIONS.'.sesskey';
	olc_db_query('DELETE '. TABLE_WHOS_ONLINE. '  FROM '.TABLE_WHOS_ONLINE.COMMA_BLANK.TABLE_SESSIONS.
	' WHERE '.TABLE_WHOS_ONLINE.'.session_id = '.$sesskey.' AND '.$sesskey.' IS NULL');

	$sql_data	=array(
		'customer_id'=>$wo_customer_id,
		'full_name'=>$wo_full_name,
		'session_id'=>$wo_session_id,
		'time_last_click'=>$current_time,
		'last_page_url'=>$wo_last_page_url
	);
	$sql_where="session_id = '" . $wo_session_id . APOS;
	$stored_customer_query = olc_db_query("select count(*) as count from " .
	TABLE_WHOS_ONLINE .	" where ".$sql_where);
	$stored_customer = olc_db_fetch_array($stored_customer_query);
	if ($stored_customer['count'] > 0)
	{
		$sql_action='update';
	} else {
		$sql_data=array_merge($sql_data,
			array(
				'ip_address'=>$wo_ip_address,
				'time_entry'=>$current_time
				)
		);
		$sql_action='insert';
		$sql_where=EMPTY_STRING;
	}
	olc_db_perform(TABLE_WHOS_ONLINE,$sql_data,$sql_action,$sql_where);
}
?>