<?php
/* -----------------------------------------------------------------------------------------
$Id: loginbox.php,v 1.2 2004/02/17 16:20:07 fanta2k Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
(c) 2003	    nextcommerce (loginbox.php,v 1.10 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:
Loginbox V1.0        	Aubrey Kilian <aubrey@mycon.co.za>

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

olc_smarty_init($box_smarty,$cacheid);
if (isset($_SESSION['customer_id']) || $omit_login_box)
{
	if (IS_AJAX_PROCESSING)
	{
		$box_loginbox=HTML_NBSP;
	}
}
//W. Kaiser - AJAX
else
{
	require_once(DIR_FS_INC.'olc_image_submit.inc.php');
	require_once(DIR_FS_INC.'olc_draw_password_field.inc.php');
	//W. Kaiser - AJAX
	$box_smarty->assign('FORM_ACTION',olc_draw_form("login_box", olc_href_link(FILENAME_LOGIN, 'action=process', SSL)));
	//W. Kaiser - AJAX
	$box_smarty->assign('TEXT_EMAIL',BOX_LOGINBOX_EMAIL);
	$box_smarty->assign('FIELD_EMAIL',
	olc_draw_input_field('email_address', EMPTY_STRING, ' maxlength="96" size="15"'));
	$box_smarty->assign('TEXT_PWD',BOX_LOGINBOX_PASSWORD);
	$box_smarty->assign('FIELD_PWD',
	olc_draw_password_field('password', EMPTY_STRING, 'maxlength="30" size="15"'));
	if (OL_COMMERCE)
	{
		$file=FILENAME_PASSWORD_FORGOTTEN;
	}
	else
	{
		$file=FILENAME_PASSWORD_DOUBLE_OPT;
	}
	$box_smarty->assign('LINK_LOST_PASSWORD', olc_href_link($file, EMPTY_STRING, SSL));
	$box_smarty->assign('BUTTON',olc_image_submit('button_login_small.gif', IMAGE_BUTTON_LOGIN));
	$box_loginbox= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_login'.HTML_EXT);
}
$smarty->assign('box_LOGIN',$box_loginbox);
//W. Kaiser - AJAX
?>
