<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_signup_ok.php,v 1.1.1.1.2.1 2007/04/08 07:16:07 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_signup_ok.php, v 1.6 2003/02/23);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   Copyright (c) 2003 netz-designer
   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

require('includes/application_top.php');

// include needed functions
require_once(DIR_FS_INC.'olc_image_button.inc.php');




$breadcrumb->add(NAVBAR_TITLE, olc_href_link(FILENAME_AFFILIATE, '', SSL));
$breadcrumb->add(NAVBAR_TITLE_SIGNUP_OK);

require(DIR_WS_INCLUDES . 'header.php');

$smarty->assign('LINK_SUMMARY', HTML_A_START . olc_href_link(FILENAME_AFFILIATE_SUMMARY, '', SSL) . '">' . 
olc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . HTML_A_END);

$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'affiliate_signup_ok'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);?>
