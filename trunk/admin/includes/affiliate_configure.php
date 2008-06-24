<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_configure.php,v 1.1.1.1.2.1 2007/04/08 07:16:35 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_configure.php, v 1.10 2003/02/24);
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

  define ('AFFILIATE_NOTIFY_AFTER_BILLING',TRUE_STRING_S); // Nofify affiliate if he got a new invoice
  define ('AFFILIATE_DELETE_ORDERS',FALSE_STRING_S);       // Delete affiliate_sales if an order is deleted (Warning: Only not yet billed sales are deleted)

  define ('AFFILIATE_TAX_ID','1');  // Tax Rates used for billing the affiliates 
                                   // you get this from the URl (tID) when you select you Tax Rate at the admin: tax_rates.php?tID=1
// If set, the following actions take place each time you call the admin/affiliate_summary 									
  define ('AFFILIATE_DELETE_CLICKTHROUGHS',FALSE_STRING_S);  // (days / false) To keep the clickthrough report small you can set the days after which they are deleted (when calling affiliate_summary in the admin) 
  define ('AFFILIATE_DELETE_AFFILIATE_BANNER_HISTORY',FALSE_STRING_S);  // (days / false) To keep thethe table AFFILIATE_BANNER_HISTORY small you can set the days after which they are deleted (when calling affiliate_summary in the admin) 
   
?>
