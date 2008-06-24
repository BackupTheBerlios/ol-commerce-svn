<?php
/* -----------------------------------------------------------------------------------------
$Id: advanced_search.php,v 1.1.1.1.2.1 2007/04/08 07:16:03 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(advanced_search.php,v 1.49 2003/02/13); www.oscommerce.com
(c) 2003	    nextcommerce (advanced_search.php,v 1.13 2003/08/21); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include( 'includes/application_top.php');

// include needed functions
require_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_selection_field.inc.php');
require_once(DIR_FS_INC.'olc_get_categories.inc.php');
require_once(DIR_FS_INC.'olc_get_manufacturers.inc.php');
require_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');
require_once(DIR_FS_INC.'olc_checkdate.inc.php');
require_once(DIR_FS_INC.'olc_draw_pull_down_menu.inc.php');
require_once(DIR_FS_INC.'olc_hide_session_id.inc.php');

$breadcrumb->add(NAVBAR_TITLE_ADVANCED_SEARCH, olc_href_link(FILENAME_ADVANCED_SEARCH));

require(DIR_WS_INCLUDES . 'header.php');
$smarty->assign('FORM_ACTION',olc_draw_form('advanced_search',
olc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, EMPTY_STRING, NONSSL, false), 'get',
	'onsubmit="return check_form_advanced_search(this);"') .olc_hide_session_id());
$smarty->assign('INPUT_KEYWORDS',olc_draw_input_field('keywords', EMPTY_STRING, 'style="width: 100%"'));
$smarty->assign('CHECKBOX_DESCRIPTION',olc_draw_checkbox_field('search_in_description', '1'));
$smarty->assign('HELP_LINK','javascript:popupWindow(\'' . olc_href_link(FILENAME_POPUP_SEARCH_HELP) . '\''.RPAREN);
$smarty->assign('BUTTON_SUBMIT',olc_image_submit('button_search.gif', IMAGE_BUTTON_SEARCH));

$options_box = '
<table border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="fieldKey">' . ENTRY_CATEGORIES . '</td>
    <td class="fieldValue">
    	' .
			olc_draw_pull_down_menu('categories_id',
			olc_get_categories(array(array('id' => EMPTY_STRING, 'text' => TEXT_ALL_CATEGORIES)))) . HTML_BR.'
		</td>
  </tr>
  <tr>
    <td class="fieldKey">&nbsp;</td>
    <td class="smallText">
    	' . olc_draw_checkbox_field('inc_subcat', '1', true) . BLANK .ENTRY_INCLUDE_SUBCATEGORIES .'
   	</td>
  </tr>
';
$manufacturers_pulldown=olc_get_manufacturers();
if ($manufacturers_pulldown)
{
	$options_box .='
	<tr>
    <td class="fieldKey">' . ENTRY_MANUFACTURERS . '</td>
    <td class="fieldValue">' . olc_draw_pull_down_menu('manufacturers_id',	$manufacturers_pulldown) .'</td>
  </tr>
';
}
$options_box .= '
  <tr>
    <td class="fieldKey">' . ENTRY_PRICE_FROM . '</td>
    <td class="fieldValue">' . olc_draw_input_field('pfrom') . '</td>
  </tr>
  <tr>
    <td class="fieldKey">' . ENTRY_PRICE_TO . '</td>
    <td class="fieldValue">' . olc_draw_input_field('pto') . '</td>
  </tr>
  <tr>
    <td colspan="2">' . olc_draw_separator('pixel_trans.gif', '100%', '10') . '</td>
  </tr>
  <tr>
    <td class="fieldKey">' . ENTRY_DATE_FROM . '</td>
    <td class="fieldValue">
 			'.olc_draw_input_field('dfrom',DOB_FORMAT_STRING,'onFocus="RemoveFormatString(this,\''.DOB_FORMAT_STRING.'\')"').'
 		</td>
  </tr>
  <tr>
    <td class="fieldKey">' . ENTRY_DATE_TO . '</td>
		<td class="fieldValue">
			'.olc_draw_input_field('dto',DOB_FORMAT_STRING,'onFocus="RemoveFormatString(this,\''.DOB_FORMAT_STRING.'\')"').'
		</td>
  </tr>
</table>
';

$smarty->assign('OPTIONS_BOX',$options_box);
$error=EMPTY_STRING;
if (isset($_GET['errorno'])) {
	if (($_GET['errorno'] & 1) == 1) {
		$error.= str_replace('\n', HTML_BR, JS_AT_LEAST_ONE_INPUT);
	}
	if (($_GET['errorno'] & 10) == 10) {
		$error.= str_replace('\n', HTML_BR, JS_INVALID_FROM_DATE);
	}
	if (($_GET['errorno'] & 100) == 100) {
		$error.= str_replace('\n', HTML_BR, JS_INVALID_TO_DATE);
	}
	if (($_GET['errorno'] & 1000) == 1000) {
		$error.= str_replace('\n', HTML_BR, JS_TO_DATE_LESS_THAN_FROM_DATE);
	}
	if (($_GET['errorno'] & 10000) == 10000) {
		$error.= str_replace('\n', HTML_BR, JS_PRICE_FROM_MUST_BE_NUM);
	}
	if (($_GET['errorno'] & 100000) == 100000) {
		$error.= str_replace('\n', HTML_BR, JS_PRICE_TO_MUST_BE_NUM);
	}
	if (($_GET['errorno'] & 1000000) == 1000000) {
		$error.= str_replace('\n', HTML_BR, JS_PRICE_TO_LESS_THAN_PRICE_FROM);
	}
	if (($_GET['errorno'] & 10000000) == 10000000) {
		$error.= str_replace('\n', HTML_BR, JS_INVALID_KEYWORDS);
	}
}
$smarty->assign('error',$error);
$main_content= $smarty->fetch(CURRENT_TEMPLATE_MODULE . 'advanced_search'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>