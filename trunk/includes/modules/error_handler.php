<?php
/* -----------------------------------------------------------------------------------------
$Id: error_handler.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX
if (IS_AJAX_PROCESSING)
{
	ajax_error($error,true);
}
else
{
	if (!function_exists('olc_hide_session_id'))
	{
		require_once(DIR_FS_INC.'olc_hide_session_id.inc.php');
	}
	olc_smarty_init($module_smarty,$cacheid);
	$module_smarty->assign('ERROR',$error);
	//W. Kaiser - AJAX
	$button_action=(USE_AJAX)? $button_action="button_left()":"history.back(1)";
	$module_smarty->assign('BUTTON','<a href="javascript:'.$button_action.'">'.
	olc_image_button('button_back.gif', IMAGE_BUTTON_CONTINUE).HTML_A_END);
	//W. Kaiser - AJAX
	// search field
	$module_smarty->assign('FORM_ACTION',olc_draw_form('new_find',
	olc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', NONSSL, false), 'get').olc_hide_session_id());
	$module_smarty->assign('INPUT_SEARCH',olc_draw_input_field('keywords', '', 'size="30" maxlength="30"'));
	$module_smarty->assign('BUTTON_SUBMIT',olc_image_submit('button_add_quick.gif', BOX_HEADING_SEARCH).'</form>');
	$module_smarty->assign('LINK_ADVANCED',olc_href_link(FILENAME_ADVANCED_SEARCH));
	$module_smarty->caching = 0;
	$main_content= $module_smarty->fetch(CURRENT_TEMPLATE_MODULE . 'error_message'.HTML_EXT,$cacheid);
	if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO))  $product_info=$main_content;
	if (!is_object($smarty))
	{
		olc_smarty_init($smarty,$cacheid);
	}
	$smarty->assign(MAIN_CONTENT,$main_content);
}
//W. Kaiser - AJAX
?>