<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_prepare_specials_whatsnew_boxes.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:39 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(specials.php,v 1.30 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (specials.php,v 1.10 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
unset($module_smarty);
$products_listing_simple=true;
$products_use_random_data=!$show_marquee;
$random_records=1;
$smarty_config_section="boxes";
include(DIR_FS_INC.'olc_prepare_products_listing_info.inc.php');
$smarty_config_section=EMPTY_STRING;
?>