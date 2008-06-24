<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_help4.php,v 1.1.1.1.2.1 2007/04/08 07:16:05 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_help4.php, v 1.4 2003/02/17);
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


$smarty->assign(array(
			'HTML_PARAMS' => HTML_PARAMS,
			'href' => (($request_type == SSL) ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG,
			'TITLE' => TITLE));

$smarty->assign('help_file', 'help4');
$smarty->display(CURRENT_TEMPLATE_MODULE . 'affiliate_help'.HTML_EXT);?>
