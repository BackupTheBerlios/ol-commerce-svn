<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_declare_modules.inc.php,v 1.1.1.1 2006/12/22 13:41:51 gswkaiser Exp

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------

based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(product_listing.php,v 1.42 2003/05/27); www.oscommerce.com
(c) 2003	    nextcommerce (product_listing.php,v 1.19 2003/08/1); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$s='MODULE_PRODUCT_PROMOTION';
$do_promotion=defined($s);
if ($do_promotion)
{
	$do_promotion=MODULE_PRODUCT_PROMOTION_STATUS == TRUE_STRING_S;
}
define('DO_PROMOTION',$do_promotion || IS_LOCAL_HOST);

?>