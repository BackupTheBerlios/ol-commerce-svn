<?php
/*------------------------------------------------------------------------------
$Id: affiliate.php,v 1.1 2004/04/08 14:19:12 hubi74 Exp $

OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.com, http://www.seifenparadies.de
modified by http://www.netz-designer.de

Copyright (c) 2003 netz-designer
-----------------------------------------------------------------------------
based on:
(c) 2003 OSC-Affiliate (affiliate.php, v 1.6 2003/02/22);
http://oscaffiliate.sourceforge.net/

Contribution based on:

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2002 - 2003 osCommerce

Released under the GNU General Public License
---------------------------------------------------------------------------*/

olc_smarty_init($box_smarty,$cacheid);
$box_content='';
$link_end1='">';
$link_end2='</a><br/>';

if (isset($_SESSION['affiliate_id'])) {
	$box_content .= HTML_A_START . olc_href_link(FILENAME_AFFILIATE_SUMMARY) . $link_end1 . BOX_AFFILIATE_SUMMARY . $link_end2;;
	$box_content .= HTML_A_START . olc_href_link(FILENAME_AFFILIATE_ACCOUNT). $link_end1 . BOX_AFFILIATE_ACCOUNT . $link_end2;
	$box_content .= HTML_A_START . olc_href_link(FILENAME_AFFILIATE_PAYMENT). $link_end1 . BOX_AFFILIATE_PAYMENT . $link_end2;
	$box_content .= HTML_A_START . olc_href_link(FILENAME_AFFILIATE_CLICKS). $link_end1 . BOX_AFFILIATE_CLICKRATE . $link_end2;
	$box_content .= HTML_A_START . olc_href_link(FILENAME_AFFILIATE_SALES). $link_end1 . BOX_AFFILIATE_SALES . $link_end2;
	$box_content .= HTML_A_START . olc_href_link(FILENAME_AFFILIATE_BANNERS). $link_end1 . BOX_AFFILIATE_BANNERS . $link_end2;
	$box_content .= HTML_A_START . olc_href_link(FILENAME_AFFILIATE_CONTACT). $link_end1 . BOX_AFFILIATE_CONTACT . $link_end2;
	$box_content .= HTML_A_START . olc_href_link(FILENAME_CONTENT, 'coID=902'). $link_end1 . BOX_AFFILIATE_FAQ . $link_end2;
	$box_content .= HTML_A_START . olc_href_link(FILENAME_AFFILIATE_LOGOUT). $link_end1 . BOX_AFFILIATE_LOGOUT . HTML_A_END;
}
else {
	$box_content .= HTML_A_START . olc_href_link(FILENAME_CONTENT,'coID=901'). $link_end1 . BOX_AFFILIATE_INFO . $link_end2;
	$box_content .= HTML_A_START . olc_href_link(FILENAME_AFFILIATE) . $link_end1 . BOX_AFFILIATE_LOGIN . HTML_A_END;
}
$box_smarty->assign('BOX_TITLE', BOX_HEADING_ADD_PRODUCT_ID);
$box_smarty->assign('BOX_CONTENT', $box_content);
$box_affiliate = $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_affiliate'.HTML_EXT,$cacheid);
$smarty->assign('box_AFFILIATE',$box_affiliate);
?>
