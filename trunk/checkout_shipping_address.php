<?php
/* -----------------------------------------------------------------------------------------
$Id: checkout_shipping_address.php,v 1.1.1.1 2006/12/22 13:35:41 gswkaiser Exp $

OL-Commerce Version 1.0
http://www.ol-commerce.com

Copyright (c) 2004 OL-Commerce 
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(checkout_shipping_address.php,v 1.14 2003/05/27); www.oscommerce.com
(c) 2003	 nextcommerce (checkout_shipping_address.php,v 1.14 2003/08/17); www.nextcommerce.org
(c) 2004  XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
include('includes/application_top.php');
// if the order contains only virtual products, forward the customer to the billing page as
// a shipping address is not needed
$checkout_id_text='sendto';
$checkout_session_text='shipping';
if ($order->content_type == 'virtual')
{
	$_SESSION[$checkout_session_text] = false;
	$_SESSION[$checkout_id_text] = false;
	olc_redirect(olc_href_link(FILENAME_CHECKOUT_PAYMENT, EMPTY_STRING, SSL));
}
$IsCheckout_shipping = true;
$redirect_link=FILENAME_CHECKOUT_SHIPPING;
define('MESSAGE_STACK_NAME', 'checkout_shipping_address');
include(FILENAME_CHECKOUT_ADDRESS);
?>