<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_column_left.php,v 1.1.1.1.2.1 2007/04/08 07:16:34 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate
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
   
if (CUSTOMER_IS_ADMIN) 
{
	echo ('<div class="menuBoxHeading"><b>'.BOX_HEADING_AFFILIATE.'</b></div>');
	if ($admin_access['configuration'] == '1') echo HTML_A_START . olc_href_link(FILENAME_CONFIGURATION, 'gID=900') . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE_CONFIGURATION . '</a><br/>';
	if ($admin_access['affiliate_affiliates'] == '1') echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE) . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE . '</a><br/>';
	if ($admin_access['affiliate_banners'] == '1') echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE_BANNERS) . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE_BANNERS . '</a><br/>';
	if ($admin_access['affiliate_clicks'] == '1') echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE_CLICKS) . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE_CLICKS . '</a><br/>';
	if ($admin_access['affiliate_contact'] == '1') echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE_CONTACT) . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE_CONTACT . '</a><br/>';
	if ($admin_access['affiliate_payment'] == '1') echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE_PAYMENT) . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE_PAYMENT . '</a><br/>';
	if ($admin_access['affiliate_sales'] == '1') echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE_SALES) . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE_SALES . '</a><br/>';
	if ($admin_access['affiliate_summary'] == '1') echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE_SUMMARY) . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE_SUMMARY . '</a><br/>';
}		
?>
