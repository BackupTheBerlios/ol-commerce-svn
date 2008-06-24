<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_customer_greeting.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:18 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_customer_greeting.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// Return a customer greeting
function olc_customer_greeting() {

	if (CUSTOMER_ID)
	{
		$greeting_string = sprintf(TEXT_GREETING_PERSONAL,
		trim($_SESSION['customer_first_name'] . BLANK . $_SESSION['customer_last_name']),
		olc_href_link(FILENAME_PRODUCTS_NEW));
	}
	else
	{
		$greeting_string = sprintf(TEXT_GREETING_GUEST, olc_href_link(FILENAME_LOGIN, EMPTY_STRING, SSL),
		olc_href_link(FILENAME_CREATE_ACCOUNT, EMPTY_STRING, SSL));
	}
	return $greeting_string;
}
?>