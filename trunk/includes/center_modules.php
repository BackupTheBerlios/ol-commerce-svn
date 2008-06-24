<?php
/* -----------------------------------------------------------------------------------------
$Id: center_modules.php,v 1.1.1.1.2.1 2007/04/08 07:17:44 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
(c) 2003	    nextcommerce (center_modules.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$force_stand_alone_deny=true;
$front_page=true;
require(DIR_WS_MODULES . FILENAME_TOP_PRODUCTS);
require(DIR_WS_MODULES . FILENAME_NEW_PRODUCTS);
require(DIR_WS_MODULES . FILENAME_UPCOMING_PRODUCTS);
$force_stand_alone_deny=false;
unset($smarty->_tpl_vars[MAIN_CONTENT]);
$front_page=false;
?>