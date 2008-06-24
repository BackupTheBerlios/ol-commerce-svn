<?php
/*
$Id: olC_Catalog.tpl.php,v 1.1.1.1.2.1 2007/04/08 07:18:09 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2003 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/

$script=$page->onLoad;
if (USE_AJAX)
{
	$ajax_script_id++;
	define('AJAX_SCRIPT_'.$ajax_script_id,$script);
}
else
{
	$script='
<script type="text/javascript">
	setTimeout("'.$script.'",0);
</script>
';
}
ob_start();
$main_content=require($page->contentFile);
$main_content=ob_get_contents();
ob_end_clean();
olc_smarty_init($module_smarty,$cacheid);
$module_smarty->assign("SCRIPT",$script);
$module_smarty->assign(MAIN_CONTENT,$main_content);
$module_smarty->assign('BUTTON_CONTINUE','<a href="javascript:window.close();">'.
	olc_image_button('button_window_close.gif', IMAGE_BUTTON_BACK).HTML_A_END);
$main_content=$module_smarty->fetch(CURRENT_TEMPLATE_MODULE . 'paypal_ipn_catalog_tpl'.HTML_EXT,$cacheid);
$smarty->assign(MAIN_CONTENT,$main_content);
$smarty->display(INDEX_HTML);
?>
