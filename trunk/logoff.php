<?php
/* -----------------------------------------------------------------------------------------
$Id: logoff.php,v 1.1.1.1.2.1 2007/04/08 07:16:16 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(logoff.php,v 1.12 2003/02/13); www.oscommerce.com
(c) 2003	    nextcommerce (logoff.php,v 1.16 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
include('includes/application_top.php');
// include needed functions
require_once(DIR_FS_INC.'olc_image_button.inc.php');
$breadcrumb->add(NAVBAR_TITLE_LOGOFF);
olc_session_destroy();
unset($_SESSION['customer_id']);
unset($_SESSION['customer_default_address_id']);
unset($_SESSION['customer_first_name']);
unset($_SESSION['customer_country_id']);
unset($_SESSION['customer_zone_id']);
unset($_SESSION['comments']);
unset($_SESSION['user_info']);
unset($_SESSION['customers_status']);
unset($_SESSION['selected_box']);
unset($_SESSION['navigation']);
unset($_SESSION['shipping']);
unset($_SESSION['payment']);
// GV Code Start
unset($_SESSION['gv_id']);
unset($_SESSION['cc_id']);
// GV Code End
$_SESSION['cart']->reset();
$assign_constants=true;
// write customers status guest in session again
//require(DIR_WS_INCLUDES . 'write_customers_status.php');
if ($_GET['admin_logoff'])
{
	olc_redirect(FILENAME_DEFAULT);
}
else
{
	include_once(DIR_FS_INC.'olc_create_navigation_links.inc.php');
	olc_create_navigation_links(true,false);
	require(DIR_WS_INCLUDES . 'header.php');
	//W. Kaiser - AJAX
	
		//W. Kaiser - AJAX
	$smarty->assign('BUTTON_CONTINUE',HTML_A_START . olc_href_link(FILENAME_DEFAULT) . '">' .
	olc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . HTML_A_END);
	$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'logoff'.HTML_EXT,SMARTY_CACHE_ID);
	$smarty->assign(MAIN_CONTENT,$main_content);
	require(BOXES);
$smarty->display(INDEX_HTML);
}
?>