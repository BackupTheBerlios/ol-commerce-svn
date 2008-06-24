<?php
/* -----------------------------------------------------------------------------------------
$Id: product_listing.php,v 1.1.1.1.2.1 2007/04/08 07:17:59 gswkaiser Exp $

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

//W. Kaiser - AJAX
// get default template
$products_listing_template=$category['listing_template'];
$products_listing_sql=$listing_sql;
$products_listing_simple=false;
$products_use_random_data=false;
unset($module_smarty);
include(DIR_FS_INC.'olc_prepare_products_listing.inc.php');
//W. Kaiser - AJAX
$smarty_config_section=EMPTY_STRING;
?>