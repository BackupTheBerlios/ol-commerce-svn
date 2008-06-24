<?php
/* -----------------------------------------------------------------------------------------
$Id: search.php,v 1.2 2004/02/17 16:20:07 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(search.php,v 1.22 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (search.php,v 1.9 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
olc_smarty_init($box_smarty,$cacheid);

require_once(DIR_FS_INC.'olc_draw_pull_down_menu.inc.php');
require_once(DIR_FS_INC.'olc_draw_checkbox_field.inc.php');
require_once(DIR_FS_INC.'olc_draw_selection_field.inc.php');
require_once(DIR_FS_INC.'olc_image_submit.inc.php');
require_once(DIR_FS_INC.'olc_get_categories.inc.php');
require_once(DIR_FS_INC.'olc_get_manufacturers.inc.php');
require_once(DIR_FS_INC.'olc_hide_session_id.inc.php');

$selections = '
<table border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="infoBoxContents">' .ENTRY_CATEGORIES . HTML_BR.
			olc_draw_pull_down_menu('categories_id',
			olc_get_categories(array(array('id' => EMPTY_STRING, 'text' => TEXT_ALL_CATEGORIES)))).
			olc_draw_hidden_field('inc_subcat',ONE_STRING).'
		</td>
  </tr>'; 
$manufacturers_pulldown=olc_get_manufacturers();
if ($manufacturers_pulldown)
{
	$selections .='<tr><td class="infoBoxContents">' . ENTRY_MANUFACTURERS . HTML_BR.olc_draw_pull_down_menu('manufacturers_id',	$manufacturers_pulldown) .'</td></tr>';
}
$selections.='</table>';
$box_smarty->assign('FORM_ACTION',olc_draw_form('quick_find', olc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, EMPTY_STRING, NONSSL, false), 'get').olc_hide_session_id());
$box_smarty->assign('INPUT_SEARCH',olc_draw_input_field('keywords', EMPTY_STRING, 'size="16" maxlength="100"'));
$box_smarty->assign('SELECTIONS',$selections);
$box_smarty->assign('BUTTON_SUBMIT',olc_image_submit('button_quick_find.gif', BOX_HEADING_SEARCH,'align="middle"'));
$box_smarty->assign('LINK_ADVANCED',olc_href_link(FILENAME_ADVANCED_SEARCH));
$box_search= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_search'.HTML_EXT,$cacheid);
$smarty->assign('box_SEARCH',$box_search);
?>