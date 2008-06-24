<?php
/* -----------------------------------------------------------------------------------------
$Id: print_product_info.php,v 1.1.1.1.2.1 2007/04/08 07:16:18 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(product_info.php,v 1.94 2003/05/04); www.oscommerce.com
(c) 2003	    nextcommerce (print_product_info.php,v 1.16 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

include('includes/application_top.php');
//W. Kaiser - AJAX
//Use 'product_info.php' also for printing!!
$isprint_version=true;
if ($fake_print)
{
	require(DIR_WS_INCLUDES.'header.php');
}
include(DIR_WS_MODULES.FILENAME_PRODUCT_INFO);
//W. Kaiser - AJAX
?>