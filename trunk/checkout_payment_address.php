<?php
/* -----------------------------------------------------------------------------------------
$Id: checkout_payment_address.php,v 1.1.1.1.2.1 2007/04/08 07:16:10 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(checkout_payment_address.php,v 1.13 2003/05/27); www.oscommerce.com
(c) 2003	    nextcommerce (checkout_payment_address.php,v 1.14 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include('includes/application_top.php');
//	W. Kaiser - Common code for account data handling
$checkout_id_text='billto';
$checkout_session_text='payment';
$IsCheckout_payment = true;
$redirect_link=FILENAME_CHECKOUT_PAYMENT;
define('MESSAGE_STACK_NAME','checkout_payment_address');
include(FILENAME_CHECKOUT_ADDRESS);
//	W. Kaiser - Common code for account data handling
?>