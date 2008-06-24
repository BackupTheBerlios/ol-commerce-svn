<?php
/* --------------------------------------------------------------
$Id: livehelp.php,v 1.1.1.1.2.1 2007/04/08 07:16:29 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

Modified to support periodic AJAX requests for timed polling!

--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(whos_online.php,v 1.30 2002/11/22); www.oscommerce.com
(c) 2003	    nextcommerce (whos_online.php,v 1.9 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

if (isset($_GET['ajax']))
{
	$is_periodic=isset($_GET['p']);
}
else
{
	$is_periodic=false;
}
$not_is_periodic=!$is_periodic;
if ($is_periodic)
{
	//$whos_online_data_in_db=true;		//Use own data storage handling
	$whos_online_data_in_db=false;		//Use session data storage handling
	ob_start();

	$is_periodic_init=!isset($_GET['i']);
	if ($is_periodic_init)
	{
		$sample_interval_text='sample_interval_whois';
		//Get settings from settings file
		$periodic_settings=get_ini_settings('../live_data/settings.ini');
	}
}

require('includes/application_top.php');

$current_time=time();
if ($is_periodic)
{
	//Do garbage collection in session db
	_sess_gc(EMPTY_STRING);
	//Delete all from "whos_online" without a session entry
	$sesskey=TABLE_SESSIONS.'.sesskey';
	olc_db_query('DELETE '. TABLE_WHOS_ONLINE. '  FROM '.TABLE_WHOS_ONLINE.COMMA_BLANK.TABLE_SESSIONS.
	' WHERE '.TABLE_WHOS_ONLINE.'.session_id = '.$sesskey.' AND '.$sesskey.' IS NULL');
}
else
{
	// remove entries that have expired
	$xx_mins_ago = ($current_time - 900);
	olc_db_query($delete."time_last_click < '" . $xx_mins_ago . APOS);
}

$main_content='
			<table border="0" width="100%" cellspacing="2" cellpadding="2">
  			<tr>
';
$col_start='
					<td class="dataTableHeadingContent"';
$col_end = HTML_NBSP.'
					</td>';
$rab='>'.HTML_NBSP;
$align_right = ' align="right"'.$rab;
$align_center = ' align="center"'.$rab;
if ($is_periodic)
{
	include(DIR_FS_LANGUAGES.SESSION_LANGUAGE.SLASH.'admin'.SLASH.FILENAME_WHOS_ONLINE);

	$count_orders = olc_db_query("select count(*) AS anzahl from ".TABLE_ORDERS);
	$count_orders =olc_db_fetch_array($count_orders);
	$count_orders =$count_orders ['anzahl'];
	$online_ips_text='online_ips';
	$periodic_text='periodic';
	$periodic_orders_text=$periodic_text.'_orders';
	//$is_periodic_init=true;
	if (!$is_periodic_init)
	{
		$is_periodic_init=!isset($_SESSION[$periodic_text]);
	}
	$not_is_periodic_init=!$is_periodic_init;
	$periodic_settings_text=$periodic_text.'_settings';
	if ($is_periodic_init)
	{
		$_SESSION[$periodic_settings_text]=$periodic_settings;
		unset($_SESSION[$online_ips_text]);
		$main_content='
		<div id="main_content">'.$main_content;
		$_SESSION[$periodic_text]=true;
		$_SESSION[$periodic_orders_text]=$count_orders;
		$main_content=ob_get_contents().$main_content;
	}
	else
	{
		$periodic_settings=$_SESSION[$periodic_settings_text];
	}
	$new_orders=$count_orders-$_SESSION[$periodic_orders_text];
	$show_orders=$new_orders>0;										//Some new order(s) arrived!
	if ($show_orders)
	{
		$orders_query_raw = "
		select
		o.orders_id,
		o.customers_name,
		o.payment_method,
		o.date_purchased,
		o.last_modified,
		o.currency,
		o.currency_value,
		s.orders_status_name,
		ot.text as order_total from " .
		TABLE_ORDERS . " o
		left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id)," .
		TABLE_ORDERS_STATUS . " s
		where
		o.orders_status = s.orders_status_id
		and s.language_id = '" . SESSION_LANGUAGE_ID . "'
		and ot.class = 'ot_total'
		order by o.orders_id DESC LIMIT ".$new_orders;
		$orders_html='
	  			<td>
						<table border="0" width="100%" cellspacing="0" cellpadding="0">
						  <tr>
						    <td valign="top">
						      <table border="0" width="100%" cellspacing="0" cellpadding="2">
						        <tr class="dataTableHeadingRow">
						          <td class="dataTableHeadingContent">'.TABLE_HEADING_CUSTOMERS.$col_end .
		$col_start.$align_right."N°" .$col_end .
		$col_start.$align_right.TABLE_HEADING_ORDER_TOTAL.$col_end .
		$col_start.$align_center.TABLE_HEADING_DATE_PURCHASED.$col_end .
		$col_start.$align_right.TABLE_HEADING_STATUS.$col_end .
		$col_start.$align_right.TABLE_HEADING_ACTION.$col_end .'
						        </tr>
';
		$col_start_1='<td class="dataTableContent';
		$orders_query = olc_db_query($orders_query_raw);
		$image=olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', EMPTY_STRING);
		$date_format="d.m.Y H:i:s";
		$params=olc_get_all_get_params(array('oID', 'action')) . 'oID=#&action=edit';
		$target='" target="_blank">';
		$order_total_total=0;
		$orders_html_line='
									  <tr class="dataTableRow"
											onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'"
											onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' .
		olc_onclick_link(FILENAME_ORDERS, $params) . $target.'
											<td class="dataTableContent>
												<a href="' . olc_href_link(FILENAME_ORDERS, $params) . $target .
		olc_image(DIR_WS_ICONS . 'preview.gif',	ICON_PREVIEW) .HTML_A_END .HTML_NBSP . '@
											'.$col_end.$col_start_1.$align_right .HASH . $col_end;
		while ($orders = olc_db_fetch_array($orders_query))
		{
			$orders_id = $orders['orders_id'];
			$order_total=strip_tags($orders['order_total']);
			$last_date=date($date_format,$orders['date_purchased']);
			$orders_html.=str_replace(HASH,$orders_id,str_replace(ATSIGN,$orders['customers_name'],$orders_html_line)) .
			$col_start_1.$align_right .$orders_id . $col_end .
			$col_start_1.$align_right .$order_total . $col_end .
			$col_start_1.$align_center .date($date_format,$last_date) . $col_end .
			$col_start_1.$align_right .$orders['orders_status_name'] . $col_end .
			$col_start_1.$align_right . $image . $col_end .'
						        </tr>
';
			$order_total_total+=(float)$order_total;
		}
		$orders_html.='
						      </table>
						    </td>
						  </tr>
';
		if ($order_total_total>0)
		{
			//olc_db_num_rows($orders_query);
			$orders_html_line=olc_db_num_rows($orders_query).BLANK.BOX_ORDERS.' ( im Wert von '.
			olc_format_price($order_total_total,true,true).') seit '.$last_date.DOT;
			$orders_html.='
						        <tr class="dataTableHeadingRow">
						          <td class="dataTableHeadingContent" colspan="6">'.HTML_NBSP.$orders_html_line.$col_end .'
						        </tr>
';
		}
		$orders_html.='
						</table>
	        </td>
						'.HTML_BR.HTML_HR.HTML_BR;
	}
	ob_end_clean();		//Discard any output
	$class_standard='Visitor';
	$class_vistor_new=$class_standard.'New';
	$class_vistor_lost=$class_standard.'Lost';
}
else
{
	require(DIR_WS_INCLUDES . 'header.php');
	echo $main_content;
	$class_standard='dataTableContent';
	$class_selected=$class_standard.'Selected';
}
$heading_title=HEADING_TITLE;
if ($is_periodic)
{
	$heading_title='Neue Bestellungen'.SLASH.$heading_title;
}
else
{
	echo '
	  <td class="columnLeft2" nowrap="nowrap" valign="top">
    	<table border="0" cellspacing="1" cellpadding="1" class="columnLeft" nowrap="nowrap">
				<!-- left_navigation //-->
';
	require(DIR_WS_INCLUDES . 'column_left.php');
	echo '
				<!-- left_navigation_eof //-->
    	</table>
    </td>
';
}
$main_content.='
					<!-- body_text //-->
			    <td width="100%" valign="top">
				    <table border="0" width="100%" cellspacing="0" cellpadding="2">
				      <tr>
				        <td>
				        	<table border="0" width="100%" cellspacing="0" cellpadding="0">
					          <tr>
					            <td class="pageHeading">'.$heading_title.'</td>
					            <td>&nbsp;</td>
					          </tr>
					        </table>
					       </td>
				      </tr>
';
if ($is_periodic)
{
	//$date=date('d.m.Y, H:i:s');
	setlocale(LC_TIME,'de_DE', 'German_Germany');
	$date=strftime('%A, %c',$current_time);
	$main_content.='
	      			<tr>
				        <td>
									<hr/>
										<center>
											<span class="captiontext">
												<b>Aktueller Stand vom
													<span id="date">'.$date.'</span>
												</b>
											</span>
										</center>
									<hr/>
				        </td>
				      </tr>
';
	$online_ips=array();
	$online_ips_rows=array();
	$online_new_ips_rows=array();
	$online_ips_rows_text=$online_ips_text.UNDERSCORE.'rows';
	if ($whos_online_data_in_db)
	{
		$where_whos_online=" where session_id='0'";
		$online_ips=olc_db_query(SELECT_ALL . TABLE_WHOS_ONLINE_DATA . $where_whos_online);
		if (olc_db_num_rows($online_ips)>0)
		{
			$online_ips=olc_db_fetch($online_ips);
			$session_online_ips=unserialize($online_ips[$online_ips_text]);
			$session_online_ips_rows=unserialize($online_ips[$online_ips_rows_text]);
		}
	}
	else
	{
		$session_online_ips=$_SESSION[$online_ips_text];
		$session_online_ips_rows=$_SESSION[$online_ips_rows_text];
	}
	if (!is_array($session_online_ips))
	{
		$session_online_ips=array();
		$session_online_ips_rows=array();
	}
	$main_content.=TILDE;		//Reserve space for new or lost visitors
}
$main_content.='
				      <tr>
				        <td>
					        <table border="0" width="100%" cellspacing="0" cellpadding="0">
					          <tr>
					            <td valign="top">
						            <table border="0" width="100%" cellspacing="0" cellpadding="2">
						              <tr class="dataTableHeadingRow">
														'.
$col_start.$rab.TABLE_HEADING_ONLINE.$col_end.
$col_start.$align_center.TABLE_HEADING_CUSTOMER_ID.$col_end.
$col_start.$rab.TABLE_HEADING_FULL_NAME.$col_end.
$col_start.$align_center.TABLE_HEADING_IP_ADDRESS.$col_end.
$col_start.$rab.TABLE_HEADING_ENTRY_TIME.$col_end.
$col_start.$align_center.TABLE_HEADING_LAST_CLICK.$col_end.
$col_start.$rab.TABLE_HEADING_LAST_PAGE_URL.$col_end.'
						              </tr>
';
$whos_online_end_row='
					          	    <tr>
						                <td class="main" colspan="7">
						                	<br/>#<br/>
						                </td>
						              </tr>
';
$whos_online_query = olc_db_query("
select
customer_id,
full_name,
ip_address,
time_entry,
time_last_click,
last_page_url,
session_id
from " . TABLE_WHOS_ONLINE);
$visitors=olc_db_num_rows($whos_online_query);
if ($visitors>0)
{
	define('PRODUCTS_ID','products_id');
	define('PRODUCTS_MODEL','products_model');
	$cPath='cPath';
	$equal='=';
	// save current session data
	$old_session = $_SESSION;
	$index_php='index.php';
	$get_info=$_GET['info'];
	$date_format='H:i:s';
	$SQLSelect_Category = SELECT."categories_name from ".
	TABLE_CATEGORIES_DESCRIPTION .
	" where categories_id = '#' and language_id='".SESSION_LANGUAGE_ID.APOS;
	$SQLWhere = " where categories_id = '#' and language_id='".SESSION_LANGUAGE_ID.APOS;
	$sessions_in_db=STORE_SESSIONS == 'mysql';
	$session_path=olc_session_save_path() . '/sess_';
	$whos_online_row0='
														onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'"
														onmouseout="this.className=\'dataTableRow\'"
														onclick="javascript:' . olc_onclick_link(FILENAME_WHOS_ONLINE,
	olc_get_all_get_params(array('info', 'action')) . 'info=#', NONSSL);

	$whos_online_row1='
					              <tr id="#" style="display:inline;" class="dataTableRow"';
	$selected=false;
	$new_visitors=EMPTY_STRING;
	$cart_total=0;
	while ($whos_online = olc_db_fetch_array($whos_online_query))
	{
		$session_id=$whos_online['session_id'];
		$time_online = ($current_time - $whos_online['time_entry']);
		if ($is_periodic)
		{
			$info=$session_id;
		}
		else
		{
			if (!$get_info || (!$info && ($get_info == $session_id)))
			{
				$info = $session_id;
			}
			$selected=$session_id == $info;
		}
		$ip_address=$whos_online['ip_address'];
		$pos=strpos($ip_address,'(');
		if ($pos!==false)
		{
			$ip_address_index=rtrim(substr($ip_address,0,$pos));
		}
		else
		{
			$ip_address_index=$ip_address;
		}
		$whos_online_row=str_replace(HASH,$ip_address_index,$whos_online_row1);
		if ($selected)
		{
			$whos_online_row.='Selected';
		}
		else
		{
			$whos_online_row.=str_replace(HASH, $session_id, $whos_online_row0);
		}
		$whos_online_row.='">
 ';
		$class=$class_standard;
		if ($is_periodic)
		{
			//Show IP-address active
			$online_ips[$ip_address_index]=true;
			//Check new visitor
			if ($session_online_ips[$ip_address_index])
			{
				if ($time_online<=60)
				{
					$class=$class_visitor_new;
				}
			}
			else if ($not_is_periodic_init)
			{
				$show_new_visitor=true;
				$this_new_visitor=true;
				$class=$class_visitor_new;
			}
		}
		$td_start='
														<td class="'.$class.'"';
		$td_end='
													'.HTML_NBSP.'
														</td>';

		$last_page_url= $whos_online['last_page_url'];
		if (eregi("^(.*)" . olc_session_name() . "=[a-f,0-9]+[&]*(.*)", $last_page_url, $array))
		{
			$last_page_url=$array[1] . $array[2];
		}
		$is_categegory=false;
		$is_product=false;
		$is_special=false;
		if (strpos($last_page_url,$index_php)!==false)
		{
			$is_categegory=true;
			$is_special=true;
		}
		else if (strpos($last_page_url,FILENAME_PRODUCT_INFO)!==false)
		{
			$is_product=true;
			$is_special=true;
		}
		if ($is_special)
		{
			//Translate url into categories or product name!
			$pos=strpos($last_page_url,'?');
			$params=substr($last_page_url,$pos+1);
			$params=explode(AMP,$params);
			if ($is_categegory)
			{
				for ($i=0,$n=sizeof($params);$i<$n;$i++)
				{
					$param=$params[$i];
					if ($strpos($param,$cPath)!==false)
					{
						$param=explode($equal,$param);
						$cPath_array = explode(UNDERSCORE, $param[1]);
						$current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
						$categories_query = olc_db_query(str_replace(HASH,$current_category_id,$SQLSelect_Category));
						$categories = olc_db_fetch_array($categories_query);
						$last_page_text = TEXT_CATEGORIES_PAGE . $categories['categories_name'];
						break;
					}
				}
			}
			else
			{
				$s=PRODUCTS_ID;
				$pos=strpos($last_page_url, PRODUCTS_ID);
				$mapit=$pos===false;
				if ($mapit)
				{
					$s=PRODUCTS_MODEL;
					$pos=strpos($last_page_url, PRODUCTS_MODEL);
				}
				if ($pos===false)
				{
					$last_page_text=TEXT_START_PAGE;
				}
				else
				{
					$pos1=strpos($last_page_url,AMP,$pos + strlen($s));		//Find parameter terminator
					if ($pos1 == false)
					{
						$pos1=strlen($last_page_url);
					}
					$products_id = substr($last_page_url,$pos, $pos1-$pos);
					if ($mapit)
					{
						//Get id from name
						$product_query = olc_db_query("select products_id from " . TABLE_PRODUCTS .
						" where products_model = '" . $product_id . APOS);
						$product = olc_db_fetch_array($product_query);
						$products_id=$product['products_id'];
					}
					$last_page_text=TEXT_PRODUCTS_PAGE. olc_get_products_name($products_id);
				}
				$last_page_url = HTML_A_START.olc_href_link(ADMIN_PATH_PREFIX.$last_page_url,'pop_up=true').
				'" target="_blank">'.$last_page_text .HTML_A_END;
			}
		}
		$full_name=$whos_online['full_name'];
		$customer_id=$whos_online['customer_id'];
		if ($customer_id==0)
		{
			$customer_id=$full_name;
		}
		$whos_online_row.=
		$td_start.$rab.gmdate($date_format, $time_online).$td_end.
		$td_start.$align_right.$whos_online['customer_id'].$td_end.
		$td_start.$rab.$full_name.$td_end.
		$td_start.$align_right.$ip_address.$td_end.
		$td_start.$rab.date($date_format, $whos_online['time_entry']).$td_end.
		$td_start.$align_right.date($date_format, $whos_online['time_last_click']).$td_end.
		$td_start.$rab.$last_page_url.$td_end;
		$whos_online_row.=$col_end.'
              						</tr>
';
		$main_content.=$whos_online_row;
		if ($is_periodic)
		{
			if (!$online_ips_rows[$ip_address_index])
			{
				if ($this_new_visitor)
				{
					$this_new_visitor=false;
					$new_visitors.=$whos_online_row;
					$online_new_ips_rows[$ip_address_index]=$whos_online_row;
				}
				else
				{
					$online_ips_rows[$ip_address_index]=$whos_online_row;
				}
			}
		}
		if ($info)
		{
			$heading = array();
			$heading[] = array('text' => HTML_B_START . TABLE_HEADING_SHOPPING_CART . HTML_B_END);
			$contents = array();
			if ($sessions_in_db)
			{
				$session_data = _sess_read($info,false);
			} else {
				$session_file=$session_path . $info;
				if (file_exists($session_file))
				{
					if (filesize($session_file) > 0)
					{
						$session_data = file_get_contents($session_file);
					}
				}
			}
			$length = strlen($session_data);
			if ($length)
			{
				$session_change=true;
				// and flush $_SESSION array
				$_SESSION = array();
				//set customers session as session data
				session_decode($session_data);
				$cart=$_SESSION['cart'];
				/*
				$start_id = strpos($session_data, 'customer_id|s');
				$start_cart = strpos($session_data, 'cart|O');
				$start_currency = strpos($session_data, 'currency|s');
				$start_country = strpos($session_data, 'customer_country_id|s');
				$start_zone = strpos($session_data, 'customer_zone_id|s');
				for ($i=$start_cart; $i<$length; $i++)
				{
				$data=$session_data[$i];
				if ($data == '{')
				{
				if (isset($tag))
				{
				$tag++;
				} else {
				$tag = 1;
				}
				}
				elseif ($data == '}')
				{
				$tag--;
				}
				else
				{
				if ($tag < 1)
				{
				break;
				}
				}
				}
				$session_data_id = substr($session_data, $start_id, (strpos($session_data, SEMI_COLON, $start_id) - $start_id + 1));
				$session_data_cart = substr($session_data, $start_cart, $i-$start_cart);
				$session_data_currency = substr($session_data, $start_currency,
				(strpos($session_data, SEMI_COLON, $start_currency) - $start_currency + 1));
				$session_data_country =
				substr($session_data, $start_country, (strpos($session_data, SEMI_COLON, $start_country) -$start_country + 1));
				$session_data_zone =
				substr($session_data, $start_zone, (strpos($session_data, SEMI_COLON, $start_zone) - $start_zone + 1));

				session_decode($session_data_id);
				session_decode($session_data_currency);
				session_decode($session_data_country);
				session_decode($session_data_zone);
				session_decode($session_data_cart);
				*/
				if (is_object($cart))
				{
					$products = $cart->get_products();
					for ($i = 0, $n = sizeof($products); $i < $n; $i++)
					{
						$product=$products[$i];
						$qty=$product['quantity'];
						$cart_line=$qty . ' x ' . $product['name'].LPAREN.olc_format_price($product['price'],true,true);
						$total=$qty * $product['final_price'];
						if ($qty>1)
						{
							$cart_line.=SLASH.olc_format_price($total,true,true);
						}
						$cart_total+=$total;
						$cart_line.=RPAREN;
						$contents[] = array('text' => $cart_line);
					}
					if ($n > 0)
					{
						$contents[] = array('text' => HTML_HR);
						$contents[] = array('align' => 'right', 'text'  => TEXT_SHOPPING_CART_SUBTOTAL . BLANK .
						olc_format_price($cart->show_total(),true,true));
					} else {
						$contents[] = array('text' => HTML_NBSP);
					}
				}
			}
			if (olc_not_null($contents))
			{
				$main_content.= '
              						<tr>
	              						<td>
              								<table border="0">
			              						<tr>
					            						<td classe="dataTableRowOver" width="50%" valign="top">
';
				$box = new box;
				$main_content.= $box->infoBox($heading, $contents);
				$main_content.= '
  	  						      					</td>
							  					      </tr>
							  					    </table>
 						      					</td>
				  					      </tr>
';
			}
		}
	}
	if ($session_change)
	{
		// restore old session data
		$_SESSION = array();
		$_SESSION = $old_session;
	}
	if ($cart_total>0)
	{
		$main_content.=str_replace(HASH,TEXT_VALUE_OF_CARTS.olc_format_price($cart_total,true,true),$whos_online_end_row);
	}
}
$main_content.=str_replace(HASH,sprintf(TEXT_NUMBER_OF_CUSTOMERS, $visitors),$whos_online_end_row);

$main_content.='
						            </table>
						          </td>
	  		        		</tr>
					        </table>
			    	    </td>
			      	</tr>
			      </table>
	        </td>
	      </tr>
		  </table>
';
if ($is_periodic)
{
	if($is_periodic_init)
	{
		$main_content.= '
		</div>
	</body>
</html>
';
	}
	else
	{
		$sounds=EMPTY_STRING;
		$embed_sound='
		<EMBED SRC="'.ADMIN_PATH_PREFIX.'live_data/#" height="0" width="0" HIDDEN="true" AUTOSTART="true">';
		if (olc_not_null($session_online_ips))
		{
			//Check for visitors lost
			//Loop thrue last active IPs and look for IPs no longer active
			$class_visitor_array=array($class_visitor,$class_visitor_new);
			$lost_visitors=EMPTY_STRING;
			reset($session_online_ips);
			while (list($ip, ) = each($session_online_ips))
			{
				if (!$online_ips[$ip])
				{
					//Visitor in last snapshot is no longer available in this snapshot!
					$show_lost_visitor=true;
					$lost_visitor=str_replace($class_visitor_array,$class_visitor_lost,$online_ips_rows[$ip]);
					$lost_visitors.=$lost_visitor;
				}
			}
		}
		if (count($online_new_ips_rows)>0)
		{
			//Add new customers_info into existing customers info
			$online_new_ips_rows=array_merge($online_new_ips_rows,$online_ips_rows);
		}
		if ($whos_online_data_in_db)
		{
			olc_db_query(SQL_UPDATE . TABLE_WHOS_ONLINE_DATA ." set ".
			$online_ips_text."='".serialize($online_ips)."', ".
			$online_ips_rows_text."='".serialize($online_ips).APOS.$where_whos_online);
		}
		else
		{
			$_SESSION[$online_ips_text]=$online_ips;
			$_SESSION[$online_ips_rows_text]=$online_ips_rows;
		}
		if ($show_orders)
		{
			$sound=$periodic_settings['new_order'];
			if ($sound)
			{
				$sounds.=str_replace(HASH,$sound,$embed_sound);
			}
		}
		if ($show_new_visitor)
		{
			$sound=$periodic_settings['new_visitor'];
			if ($sound)
			{
				$sounds.=str_replace(HASH,$sound,$embed_sound);
			}
		}
		if ($show_lost_visitor)
		{
			$sound=$periodic_settings['lost_visitor'];
			if ($sound)
			{
				$sounds.=str_replace(HASH,$sound,$embed_sound);
			}
		}
		if ($sounds)
		{

			if (IS_IE)
			{
				$sounds.='
<!--
Note: ActiveX-Controls in IE are no longer active automatically!!!
For details see:
http:msdn.microsoft.com/library/default.asp?url=/workshop/author/dhtml/overview/activating_activex.asp
In order to avoid the need of user confirmation for the activation, this can be done programatically
For details see: http:capitalhead.com/1240.aspx
-->
<script type="text/javascript" src="'.ADMIN_PATH_PREFIX.DIR_WS_INCLUDES.'activate_ie_objects.js"></script>
';
			}
			$main_content.=$sounds;
		}
		$add_new_lost=EMPTY_STRING;
		if ($new_visitors)
		{
			$add_new_lost=$new_visitors;
		}
		if ($lost_visitors)
		{
			$add_new_lost.=$lost_visitors;
		}
	}
	$main_content=str_replace(TILDE,$add_new_lost,$main_content);
	echo $main_content;
	olc_exit();
}
else
{
	$main_content.='
	</td>
	';
	echo $main_content;
	require(DIR_WS_INCLUDES . 'application_bottom.php');
}

function get_ini_settings($file)
{
	$settings=array();
	if (file_exists($file))
	{
		$hash='#';
		$equal='=';
		$empty='';
		$settings_lines=file($file);
		for ($i=0,$n=sizeof($settings_lines);$i<$n;$i++)
		{
			$s=$settings_lines[$i];
			if ($s!=$empty)
			{
				$s=explode($equal,trim($s));
				$settings_name=rtrim($s[0]);
				//'#' starts a comment
				if ($settings_name[0]!=$hash)
				{
					$settings_value=$s[1];
					$pos=strpos($settings_value,$hash);
					if ($pos!==false)
					{
						$settings_value=trim(substr($settings_value,0,$pos-1));
					}
					$settings[$settings_name]=$settings_value;
				}
			}
		}
	}
	return $settings;
}
?>