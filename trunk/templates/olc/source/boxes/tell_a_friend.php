<?php
/* -----------------------------------------------------------------------------------------
$Id: tell_a_friend.php,v 1.1 2004/02/07 23:02:54 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(tell_a_friend.php,v 1.15 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (tell_a_friend.php,v 1.9 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
// W. Kaiser tell_a_friend
if ($is_checkout_shipping)
{
	$box_tell_a_friend=HTML_NBSP;
}
else
{
	require_once(DIR_FS_INC.'olc_draw_form.inc.php');
	require_once(DIR_FS_INC.'olc_draw_input_field.inc.php');
	require_once(DIR_FS_INC.'olc_image_submit.inc.php');
	require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
	require_once(DIR_FS_INC.'olc_hide_session_id.inc.php');

	olc_smarty_init($box_smarty,$cacheid);
	$box_content=olc_draw_form('tell_a_friend', olc_href_link(FILENAME_TELL_A_FRIEND, '', NONSSL, false), 'get');
	$box_smarty->assign('FORM_ACTION',$box_content);

	$products_id=$_GET['products_id'];
	if ($products_id)
	{
		$Message = BOX_TELL_A_FRIEND_TEXT;
	}
	else
	{
		$Message = BOX_TELL_A_FRIEND_TEXT_SITE;
	}
	$box_content=
	olc_draw_form('tell_a_friend', olc_href_link(FILENAME_TELL_A_FRIEND, '', NONSSL, false), 'get') .
	olc_draw_hidden_field('cPath', $_GET['cPath']) .
	olc_draw_hidden_field('products_id', $products_id) .
	olc_hide_session_id() .
	$Message. HTML_NBSP.
	olc_image_submit('button_tell_a_friend.gif', BOX_HEADING_TELL_A_FRIEND ,'align="middle"') .
	'</form>';
	$box_smarty->assign('BOX_CONTENT', $box_content);
	$box_tell_a_friend= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_tell_friend'.HTML_EXT,$cacheid);
}
$smarty->assign('box_TELL_FRIEND',$box_tell_a_friend);
// W. Kaiser tell_a_friend
?>