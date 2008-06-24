<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_create_navigation_links.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:13 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_get_all_get_params.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_create_navigation_links($cart_is_filled,$is_logogff)
{
	global $smarty;
	$sep=HTML_NBSP."|".HTML_NBSP;
	$a_end='">';
	$index="index";
	if ($cart_is_filled)					//Any items in cart
	{
		require_once(DIR_FS_INC.'olc_get_smarty_config_variable.inc.php');
		$my_navigation=
		HTML_A_START.olc_href_link(FILENAME_SHOPPING_CART).$a_end.
		olc_get_smarty_config_variable($smarty,$index,"link_cart").HTML_A_END;
		$my_navigation.=$sep.
		HTML_A_START.olc_href_link(FILENAME_CHECKOUT_SHIPPING).$a_end.
		olc_get_smarty_config_variable($smarty,$index,"link_checkout").HTML_A_END;
	}
	$login_link=HTML_A_START.olc_href_link(FILENAME_LOGIN).$a_end.
	olc_get_smarty_config_variable($smarty,$index,"link_login").HTML_A_END;
	if ($my_navigation)
	{
		$my_navigation.=$sep;
	}
	if ($is_logogff)
	{
		$my_navigation.=$login_link;
	}
	else
	{
		if (ISSET_CUSTOMER_ID)
		{
			$my_navigation.=
			HTML_A_START.olc_href_link(FILENAME_LOGOFF).$a_end.
			olc_get_smarty_config_variable($smarty,$index,"link_logoff").HTML_A_END;
			if (CUSTOMER_STATUS_ID!=DEFAULT_CUSTOMERS_STATUS_ID_GUEST)
			{
				$my_navigation.=$sep.
				HTML_A_START.olc_href_link(FILENAME_ACCOUNT).$a_end.
				olc_get_smarty_config_variable($smarty,$index,"link_account").HTML_A_END;
			}
		}
		else
		{
			$my_navigation.=$login_link;
		}
	}
	$my_navigation.=HTML_NBSP;
	$smarty->assign(BOX_NAVIGATION,$my_navigation);
}
?>