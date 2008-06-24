<?php
/* -----------------------------------------------------------------------------------------
$Id: currencies.php,v 1.2 2004/02/17 16:20:07 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(currencies.php,v 1.16 2003/02/12); www.oscommerce.com
(c) 2003	    nextcommerce (currencies.php,v 1.11 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// include functions
require_once(DIR_FS_INC.'olc_draw_form.inc.php');
require_once(DIR_FS_INC.'olc_draw_pull_down_menu.inc.php');
require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
require_once(DIR_FS_INC.'olc_hide_session_id.inc.php');
$count_cur=0;
if (is_object($currencies))
{
	reset($currencies->currencies);
	$currencies_array = array();
	while (list($key, $value) = each($currencies->currencies))
	{
		$count_cur++;
		$currencies_array[] = array('id' => $key, 'text' => $value['title']);
	}
}
// dont show box if there's only 1 currency
if ($count_cur>1)
{
	$hidden_get_variables = EMPTY_STRING;
	reset($_GET);
	$exclude=array('currency',olc_session_name(),'x','y');
	while (list($key, $value) = each($_GET))
	{
		if (!in_array($key,$exclude))
		{
			$hidden_get_variables .= olc_draw_hidden_field($key, $value);
		}
	}
	// reset var
	olc_smarty_init($box_smarty,$cacheid);
	$box_content=EMPTY_STRING;
	$box_content=olc_draw_form('currencies', olc_href_link(CURRENT_SCRIPT, EMPTY_STRING, $request_type, false), 'get').
	olc_draw_pull_down_menu('currency', $currencies_array, SESSION_CURRENCY, 'onchange="this.form.submit();"') .
	$hidden_get_variables . olc_hide_session_id().'</form>';
	$box_smarty->assign('BOX_CONTENT', $box_content);
	$box_currencies= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_currencies'.HTML_EXT,$cacheid);
	$smarty->assign('box_CURRENCIES',$box_currencies);
}
?>