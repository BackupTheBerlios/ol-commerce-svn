<?php
/* --------------------------------------------------------------
$Id: adodb_stats.php,v 1.1.1.1.2.1 2007/04/08 07:16:23 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(banner_manager.php,v 1.70 2003/03/22); www.oscommerce.com
(c) 2003	    nextcommerce (banner_manager.php,v 1.9 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');

include_once(ADMIN_PATH_PREFIX.'adodb/adodb-perf.inc.php');

global $db;

if ($db)
{
	if (isset($_GET)) {
		foreach($_GET as $k => $v) {
			if (strncmp($k,'test',4) == 0) $_SESSION['_db'] = $k;
		}
	}
	if (isset($_SESSION['_db'])) {
		$_db = $_SESSION['_db'];
		$_GET[$_db] = 1;
		$$_db = 1;
	}
	$perf = NewPerfMonitor($db);
	if ($perf)
	{
		ob_start();
		$perf->UI(3);
		$main_content=ob_get_contents();
		ob_end_clean();
		# unit tests
		if (true)
		{
			// $db->debug=1;
			$main_content .= HTML_BR.HTML_HR;
			/*
			$main_content .= "Data Cache Size=";
			$main_content .= $perf->DBParameter('data cache size').'<p>';
			$main_content .= HTML_BR.HTML_HR;
			$main_content .= $perf->HealthCheck();
			$main_content .= HTML_BR.HTML_HR;
			*/
			$main_content .= $perf->SuspiciousSQL();
			$main_content .= HTML_BR.HTML_HR;
			$main_content .= $perf->ExpensiveSQL();
			$main_content .= HTML_BR.HTML_BR.HTML_HR;
			$main_content .= $perf->InvalidSQL();
			$main_content .= HTML_BR.HTML_HR;
			/*
			//$main_content .= $perf->Tables();
			$main_content .= "<pre>";
			$main_content .= $perf->HealthCheckCLI();
			$main_content .= "</pre>";
			*/
			//$perf->Poll(3);
			//olc_exit;
		}
	}
	$page_header_title='ADODB -- Performance Monitoring';
	$page_header_subtitle='Überwachung der Datenbank';
	$page_header_icon_image=HEADING_MODULES_ICON;
	$show_column_right=true;
	require(PROGRAM_FRAME);
	olc_exit();
}
?>
