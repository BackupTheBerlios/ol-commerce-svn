<?php
/*
$Id: olC_Admin.tpl.php,v 1.1.1.1 2006/12/22 13:43:40 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2003 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/

ob_start();
require($page->contentFile);
$main_content=ob_get_contents();
ob_end_clean();
$script=$page->onLoad;
if (USE_AJAX)
{
	$ajax_script_id++;
	define('AJAX_SCRIPT_'.$ajax_script_id,$script);
	olc_smarty_init($module_smarty,$cacheid);
	$module_smarty->assign("SCRIPT",$script);
	$module_smarty->assign(MAIN_CONTENT,$main_content);
	$main_content=$module_smarty->fetch(CURRENT_TEMPLATE_MODULE . 'paypal_ipn_admin_tpl'.HTML_EXT,$cacheid);
}
else
{
		$script='
<script type="text/javascript">
	setTimeout("'.$script.'",0);
</script>
';
	$main_content=$script.$main_content;
}
$header_icon_image=EMPTY_STRING;
$header_title=EMPTY_STRING;
$header_subtitle==EMPTY_STRING;
require(DIR_WS_INCLUDES . 'program_frame.php');
?>
