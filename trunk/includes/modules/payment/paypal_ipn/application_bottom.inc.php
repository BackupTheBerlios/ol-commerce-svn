<?php
/*
$Id: application_bottom.inc.php,v 1.1.1.1.2.1 2007/04/08 07:18:07 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2003 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License

// close session (store variables)
olc_session_close();

if (STORE_PAGE_PARSE_TIME == TRUE_STRING_S) {
	$time_start = explode(' ', PAGE_PARSE_START_TIME);
	$time_end = explode(' ', microtime());
	$parse_time = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);
	error_log(strftime(STORE_PARSE_DATE_TIME_FORMAT) . ' - ' . getenv('REQUEST_URI') . LPAREN . $parse_time . 's)' . NEW_LINE, 3, STORE_PAGE_PARSE_TIME_LOG);
}
*/
?>
