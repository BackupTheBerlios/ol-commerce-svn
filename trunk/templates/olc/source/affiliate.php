<?php
/*------------------------------------------------------------------------------
   $Id: affiliate.php,v 1.1 2004/04/08 14:19:12 hubi74 Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate.php, v 1.6 2003/02/22);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   Copyright (c) 2003 netz-designer
   Copyright (c) 2005 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

olc_smarty_init($smarty);
$box_smarty->assign('tpl_path',TEMPLATE_PATH.CURRENT_TEMPLATE.'/');

if (isset($_SESSION['affiliate_id']))
{
	$box_content=HTML_A_END.HTML_BR;
	$box_content =HTML_A_START. olc_href_link(FILENAME_AFFILIATE_SUMMARY, '', SSL) . '">' . BOX_AFFILIATE_SUMMARY .$box_content;
	$box_content .=HTML_A_START. olc_href_link(FILENAME_AFFILIATE_ACCOUNT, '', SSL). '">' . BOX_AFFILIATE_ACCOUNT .$box_content;
	$box_content .=HTML_A_START. olc_href_link(FILENAME_AFFILIATE_PAYMENT, '', SSL). '">' . BOX_AFFILIATE_PAYMENT .$box_content;
	$box_content .=HTML_A_START. olc_href_link(FILENAME_AFFILIATE_CLICKS, '', SSL). '">' . BOX_AFFILIATE_CLICKRATE .$box_content;
	$box_content .=HTML_A_START. olc_href_link(FILENAME_AFFILIATE_SALES, '', SSL). '">' . BOX_AFFILIATE_SALES .$box_content;
	$box_content .=HTML_A_START. olc_href_link(FILENAME_AFFILIATE_BANNERS). '">' . BOX_AFFILIATE_BANNERS .$box_content;
	$box_content .=HTML_A_START. olc_href_link(FILENAME_AFFILIATE_CONTACT). '">' . BOX_AFFILIATE_CONTACT .$box_content;
	$box_content .=HTML_A_START. olc_href_link(FILENAME_CONTENT, 'coID=902'). '">' . BOX_AFFILIATE_FAQ .$box_content;
	$box_content .=HTML_A_START. olc_href_link(FILENAME_AFFILIATE_LOGOUT). '">' . BOX_AFFILIATE_LOGOUT . HTML_A_END;
}
else {
	$box_content .=HTML_A_START. olc_href_link(FILENAME_CONTENT,'coID=901'). '">' . BOX_AFFILIATE_INFO .$box_content;
	$box_content .=HTML_A_START. olc_href_link(FILENAME_AFFILIATE, '', SSL) . '">' . BOX_AFFILIATE_LOGIN . HTML_A_END;
}
//$box_smarty->assign('BOX_TITLE', BOX_HEADING_ADD_PRODUCT_ID);
$box_smarty->assign('BOX_CONTENT', $box_content);

// set cache id
$box_affiliate = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_affiliate'.HTML_EXT);
$smarty->assign('box_AFFILIATE',$box_affiliate);
?>
