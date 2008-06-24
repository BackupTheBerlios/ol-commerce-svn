<?php
/* -----------------------------------------------------------------------------------------
   $Id: ssl_check.php,v 1.1.1.1.2.1 2007/04/08 07:16:22 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ssl_check.php,v 1.1 2003/03/10); www.oscommerce.com 
   (c) 2003	    nextcommerce (ssl_check.php,v 1.9 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  include( 'includes/application_top.php');
    
  //require(BOXES); 
  //include needed functions
  require_once(DIR_FS_INC.'olc_image_button.inc.php');

  $breadcrumb->add(NAVBAR_TITLE_SSL_CHECK, olc_href_link(FILENAME_SSL_CHECK));

 require(DIR_WS_INCLUDES . 'header.php');   $smarty->assign('BUTTON_CONTINUE',HTML_A_START . olc_href_link(FILENAME_DEFAULT) . '">' . olc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . HTML_A_END);
  $main_content= $smarty->fetch(CURRENT_TEMPLATE_MODULE . 'ssl_check'.HTML_EXT,SMARTY_CACHE_ID);
  $smarty->assign(MAIN_CONTENT,$main_content);
	  require(BOXES);
$smarty->display(INDEX_HTML);
  ?>