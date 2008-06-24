<?php
/* -----------------------------------------------------------------------------------------
$Id: manufacturers.php,v 1.4 2004/04/13 20:22:44 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(manufacturers.php,v 1.18 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (manufacturers.php,v 1.9 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$manufacturers_query = olc_db_query("select distinct m.manufacturers_id, m.manufacturers_name from " .
TABLE_MANUFACTURERS . " m, " .
TABLE_PRODUCTS ." p
	where m.manufacturers_id=p.manufacturers_id order by m.manufacturers_name");
$manufacturers_count=olc_db_num_rows($manufacturers_query);
if ($manufacturers_count)
{
	olc_smarty_init($box_smarty,$cacheid);
	$box_content=EMPTY_STRING;
	// include needed funtions
	require_once(DIR_FS_INC.'olc_hide_session_id.inc.php');
	require_once(DIR_FS_INC.'olc_draw_form.inc.php');
	require_once(DIR_FS_INC.'olc_draw_pull_down_menu.inc.php');

	if (CURRENT_SCRIPT==FILENAME_DEFAULT)
	{
		$manufacturers_id=$_GET['manufacturers_id'];
	}
	if ($manufacturers_count <= MAX_DISPLAY_MANUFACTURERS_IN_A_LIST)
	{
		// Display a list
		$manufacturers_list = EMPTY_STRING;
		while ($manufacturers = olc_db_fetch_array($manufacturers_query))
		{
			$manufacturers_name=$manufacturers['manufacturers_name'];
			$manufacturers_name = ((strlen($manufacturers_name) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ?
			substr($manufacturers_name, 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '..' :$manufacturers_name);
			if ($manufacturers_id == $manufacturers['manufacturers_id'])
			{
				$manufacturers_name = HTML_B_START . $manufacturers_name .HTML_B_END;
			}
			$manufacturers_list .= HTML_A_START . olc_href_link(FILENAME_DEFAULT,
			'manufacturers_id=' . $manufacturers_id) . '">' . $manufacturers_name . '</a><br/>';
		}

	}
	else
	{
		// Display a drop-down
		$manufacturers_array = array();
		$manufacturers_array[] = array('id' => ZERO_STRING, 'text' => TEXT_ALL_MANUFACTURERS);
		while ($manufacturers = olc_db_fetch_array($manufacturers_query))
		{
			$manufacturers_name=$manufacturers['manufacturers_name'];
			$manufacturers_name =
			((strlen($manufacturers_name) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ?
			substr($manufacturers_name, 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '...' :$manufacturers_name);
			$manufacturers_array[] = array(
			'id' => $manufacturers['manufacturers_id'],
			'text' => $manufacturers_name);
		}
	}
	if (!$manufacturers_id)
	{
		$products_id=$_GET['products_id'];
		if ($products_id)
		{
			$manufacturers_query = olc_db_query("select manufacturers_id from " . TABLE_PRODUCTS .
			" where products_id = " . $products_id);
			if (olc_db_num_rows($manufacturers_query))
			{
				$products_data=olc_db_fetch_array($manufacturers_query);
				$manufacturers_id=$products_data['manufacturers_id'];
			}
		}
		else
		{
			$manufacturers_id=$_GET['filter_id'];
		}
	}
	$form_name_text='manufacturers';
	if (USE_AJAX)
	{
		$onchange="make_AJAX_Request_POST('".$form_name_text."','".FILENAME_DEFAULT."')";
	}
	else
	{
		$onchange='this.form.submit()';
	}
	$box_content=
	olc_draw_form($form_name_text, olc_href_link(FILENAME_DEFAULT, EMPTY_STRING, NONSSL, false), 'get');
	$box_content.=
	olc_draw_pull_down_menu('manufacturers_id', $manufacturers_array, $manufacturers_id,
	'onchange="'.$onchange.'" size="' . MAX_MANUFACTURERS_LIST.QUOTE) .	olc_hide_session_id().'
</form>
';
	$box_smarty->assign('BOX_CONTENT', $box_content);
	$box_manufacturers= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_manufacturers'.HTML_EXT,$cacheid);
}
else if (IS_AJAX_PROCESSING)
{
	$box_manufacturers=HTML_NBSP;
}
$smarty->assign('box_MANUFACTURERS',$box_manufacturers);
?>