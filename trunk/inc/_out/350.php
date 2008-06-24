<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_parse_time.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:31 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(application_bottom.php,v 1.14 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (application_bottom.php,v 1.6 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$store_parse_time=STORE_PAGE_PARSE_TIME == TRUE_STRING_S;
$show_parse_time_anyway=IS_LOCAL_HOST || CUSTOMER_IS_ADMIN;
if ($store_parse_time || $show_parse_time_anyway)
{
	$time_start = explode(BLANK, PAGE_PARSE_START_TIME);
	$time_end = explode(BLANK, microtime());
	include(DIR_FS_INC.'olc_get_currency_parameters.inc.php');
	$parse_time_raw=($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0]));
	$parse_time = number_format($parse_time_raw, 1,CURRENCY_DECIMAL_POINT,CURRENCY_THOUSANDS_POINT);
	$parse_time=sprintf(PARSE_TIME_STRING,$parse_time);
	if ($store_parse_time)
	{
		error_log(strftime(STORE_PARSE_DATE_TIME_FORMAT) . ' - ' . getenv('REQUEST_URI') . LPAREN .
			$parse_time . NEW_LINE, 3, STORE_PAGE_PARSE_TIME_LOG);
	}
	if (DISPLAY_PAGE_PARSE_TIME == TRUE_STRING_S || $show_parse_time_anyway)
	{
		$parse_time='<span class="smallText">' . $parse_time;
		if (ADOBD_USE_STATS===true)
		{
			global $EXECS,$CACHED;

			$total=$EXECS+$CACHED;
			$parse_time.=ADODB_EXECUTES_STRING.$total;
			if (ADOBD_USE_CACHING===true)
			{
				$parse_time.=sprintf(ADODB_EXECUTES_CACHED_STRING,$CACHED,(int)(($CACHED/$total)*100));
			}
		}
		$parse_time.='</span>';
	}
	if (!$is_installer)
	{
		if (NOT_IS_ADMIN_FUNCTION)
		{
			$parse_time=HTML_BR.$parse_time;
			$s='PARSE_TIME';
			if (IS_AJAX_PROCESSING)
			{
				define($s,$parse_time);
			}
			else
			{
				$this->assign($s,$parse_time);
			}
		}
	}
}
?>