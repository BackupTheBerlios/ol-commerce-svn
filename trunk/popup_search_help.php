<?php
/* -----------------------------------------------------------------------------------------
   $Id: popup_search_help.php,v 1.1.1.1.2.1 2007/04/08 07:16:18 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(popup_search_help.php,v 1.3 2003/02/13); www.oscommerce.com
   (c) 2003	    nextcommerce (popup_search_help.php,v 1.6 2003/08/17); www.nextcommerce.org 
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  include( 'includes/application_top.php');

  
  include( 'includes/header.php');

  $smarty->assign('link_close','javascript:window.close()');
	$smarty->display(CURRENT_TEMPLATE_MODULE . 'popup_search_help'.HTML_EXT,SMARTY_CACHE_ID);

