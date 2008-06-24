<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_summary.php,v 1.1.1.1.2.1 2007/04/08 07:16:08 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_summary.php, v 1.17 2003/09/17);
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
require_once(DIR_FS_INC . 'affiliate_period.inc.php');
require_once(DIR_FS_INC . 'affiliate_level_statistics_query.inc.php');
require_once(DIR_FS_INC.'olc_image_button.inc.php');



if (!isset($_SESSION['affiliate_id'])) {
    olc_redirect(olc_href_link(FILENAME_AFFILIATE, '', SSL));
}

$breadcrumb->add(NAVBAR_TITLE, olc_href_link(FILENAME_AFFILIATE, '', SSL));
$breadcrumb->add(NAVBAR_TITLE_SUMMARY, olc_href_link(FILENAME_AFFILIATE_SUMMARY));
  
$affiliate_raw = "select sum(affiliate_banners_shown) as banner_count, "
                   . "count(affiliate_clickthrough_id) as clickthrough_count, "
                   . "MONTH(affiliate_date_account_created) as start_month, "
                   . "YEAR(affiliate_date_account_created) as start_year, "
                   . "a.affiliate_commission_percent, a.affiliate_firstname, a.affiliate_id, affiliate_lastname "
                   . "from " . TABLE_AFFILIATE . " AS a "
                   . "LEFT JOIN " . TABLE_AFFILIATE_CLICKTHROUGHS . " AS ac ON ( a.affiliate_id = ac.affiliate_id )"
                   . "LEFT JOIN " . TABLE_AFFILIATE_BANNERS_HISTORY . " AS ab ON ( a.affiliate_id = ab.affiliate_banners_affiliate_id )"
                   . " where a.affiliate_id  = '" . $_SESSION['affiliate_id'] . APOS
                   . " GROUP BY a.affiliate_date_account_created, a.affiliate_commission_percent, a.affiliate_firstname, affiliate_lastname ";
$affiliate_query = olc_db_query( $affiliate_raw );
$affiliate = olc_db_fetch_array($affiliate_query);
$smarty->assign('affiliate', $affiliate);

$affiliate_impressions = $affiliate['banner_count'];
if ($affiliate_impressions == 0) $affiliate_impressions="n/a";
$smarty->assign('affiliate_impressions', $affiliate_impressions);

$smarty->assign('period_selector', affiliate_period( 'a_period', $affiliate['start_year'], $affiliate['start_month'], true, olc_db_prepare_input( $_GET['a_period'] ), 'onchange="this.form.submit();"' ));

$affiliate_percent = 0;
$affiliate_percent = $affiliate['affiliate_commission_percent'];
if ($affiliate_percent < AFFILIATE_PERCENT) $affiliate_percent = AFFILIATE_PERCENT;
$smarty->assign('affiliate_percent', olc_round($affiliate_percent, 2));

$affiliate_percent_tier = split(";", AFFILIATE_TIER_PERCENTAGE, AFFILIATE_TIER_LEVELS );

if ( (empty($_GET['a_period'])) or ( $_GET['a_period'] == "all" ) ) {
    $affiliate_sales = affiliate_level_statistics_query( $_SESSION['affiliate_id'] );
}
else {
    $affiliate_sales = affiliate_level_statistics_query( $_SESSION['affiliate_id'], olc_db_prepare_input( $_GET['a_period'] ) );
}

$smarty->assign('affiliate_transactions', olc_not_null($affiliate_sales['count']) ? $affiliate_sales['count'] : 0);

if ($affiliate_clickthroughs > 0) {
	$affiliate_conversions = olc_round(($affiliate_transactions / $affiliate_clickthroughs) * 100, 2) . "%";
}
else {
    $affiliate_conversions = "n/a";
}
$smarty->assign('affiliate_conversions', $affiliate_conversions);

$smarty->assign('affiliate_amount', $currencies->display_price($affiliate_sales['total'], ''));

if ($affiliate_transactions > 0) {
	$affiliate_average = olc_round($affiliate_amount / $affiliate_transactions, 2);
	$affiliate_average = $currencies->display_price($affiliate_average, '');
}
else {
	$affiliate_average = "n/a";
}
$smarty->assign('affiliate_average', $affiliate_average);

$smarty->assign('affiliate_commission', $currencies->display_price($affiliate_sales['payment'], ''));;

require(DIR_WS_INCLUDES . 'header.php');

$smarty->assign('FORM_ACTION', olc_draw_form('period', olc_href_link(FILENAME_AFFILIATE_SUMMARY ), 'get', SSL ));

$smarty->assign('LINK_IMPRESSION', '<a href="javascript:popupWindow(\'' . olc_href_link(FILENAME_AFFILIATE_HELP_1) . '\')">');
$smarty->assign('LINK_VISIT', '<a href="javascript:popupWindow(\'' . olc_href_link(FILENAME_AFFILIATE_HELP_2) . '\')">');
$smarty->assign('LINK_TRANSACTIONS', '<a href="javascript:popupWindow(\'' . olc_href_link(FILENAME_AFFILIATE_HELP_3) . '\')">');
$smarty->assign('LINK_CONVERSION', '<a href="javascript:popupWindow(\'' . olc_href_link(FILENAME_AFFILIATE_HELP_4) . '\')">');
$smarty->assign('LINK_AMOUNT', '<a href="javascript:popupWindow(\'' . olc_href_link(FILENAME_AFFILIATE_HELP_5) . '\')">');
$smarty->assign('LINK_AVERAGE', '<a href="javascript:popupWindow(\'' . olc_href_link(FILENAME_AFFILIATE_HELP_6) . '\')">');
$smarty->assign('LINK_COMISSION_RATE', '<a href="javascript:popupWindow(\'' . olc_href_link(FILENAME_AFFILIATE_HELP_7) . '\')">');
$smarty->assign('LINK_COMISSION', '<a href="javascript:popupWindow(\'' . olc_href_link(FILENAME_AFFILIATE_HELP_8) . '\')">');

if ( AFFILATE_USE_TIER == TRUE_STRING_S ) {
	$smarty->assign('AFFILIATE_USE_TIER', TRUE_STRING_S);
	
    for ($tier_number = 0; $tier_number <= AFFILIATE_TIER_LEVELS; $tier_number++ ) {
    	if (is_null($affiliate_percent_tier[$tier_number - 1])) {
    		$affiliate_percent_tier[$tier_number - 1] = $affiliate_percent;
    	}
    	$affiliate_percent_tier_table .= '<tr>';
    	$affiliate_percent_tier_table .= '<td width="15%" class="boxtext"><a href=' . olc_href_link(FILENAME_AFFILIATE_SALES, 'a_level=' . $tier_number . '&a_period=' . $a_period, SSL) . '>' . TEXT_COMMISSION_LEVEL_TIER . $tier_number . '</a></td>';
    	$affiliate_percent_tier_table .= '<td width="15%" align="right" class="boxtext"><a href=' . olc_href_link(FILENAME_AFFILIATE_SALES, 'a_level=' . $tier_number . '&a_period=' . $a_period, SSL) . '>' . TEXT_COMMISSION_RATE_TIER . '</a></td>';
    	$affiliate_percent_tier_table .= '<td width="5%" class="boxtext">' . olc_round($affiliate_percent_tier[$tier_number - 1], 2). '%' . '</td>';
    	$affiliate_percent_tier_table .= '<td width="15%" align="right" class="boxtext"><a href=' . olc_href_link(FILENAME_AFFILIATE_SALES, 'a_level=' . $tier_number . '&a_period=' . $a_period, SSL) . '>' . TEXT_COMMISSION_TIER_COUNT . '</a></td>';
    	$affiliate_percent_tier_table .= '<td width="5%" class="boxtext">' . ($affiliate_sales[$tier_number]['count'] > 0 ? $affiliate_sales[$tier_number]['count'] : '0') . '</td>';
    	$affiliate_percent_tier_table .= '<td width="15%" align="right" class="boxtext"><a href=' . olc_href_link(FILENAME_AFFILIATE_SALES, 'a_level=' . $tier_number . '&a_period=' . $a_period, SSL) . '>' . TEXT_COMMISSION_TIER_TOTAL . '</a></td>';
    	$affiliate_percent_tier_table .= '<td width="5%" class="boxtext">' . $currencies->display_price($affiliate_sales[$tier_number]['total'],'') . '</td>';
    	$affiliate_percent_tier_table .= '<td width="20%" align="right" class="boxtext"><a href=' . olc_href_link(FILENAME_AFFILIATE_SALES, 'a_level=' . $tier_number . '&a_period=' . $a_period, SSL) . '>' . TEXT_COMMISSION_TIER . '</a></td>';
    	$affiliate_percent_tier_table .= '<td width="5%" class="boxtext">' . $currencies->display_price($affiliate_sales[$tier_number]['payment'],'') . '</td>';
    	$affiliate_percent_tier_table .= '</tr>';
	}
	$smarty->assign('affiliate_percent_tier_table', $affiliate_percent_tier_table);
}
$smarty->assign('LINK_BANNER', HTML_A_START . olc_href_link(FILENAME_AFFILIATE_BANNERS) . '">' . olc_image_button('button_affiliate_banners.gif', IMAGE_BANNERS) . HTML_A_END);
$smarty->assign('LINK_CLICKS', HTML_A_START . olc_href_link(FILENAME_AFFILIATE_CLICKS, '', SSL) . '">' . olc_image_button('button_affiliate_clickthroughs.gif', IMAGE_CLICKTHROUGHS) . HTML_A_END);
$smarty->assign('LINK_SALES', HTML_A_START . olc_href_link(FILENAME_AFFILIATE_SALES, 'a_period=' . $a_period, SSL) . '">' . olc_image_button('button_affiliate_sales.gif', IMAGE_SALES) . HTML_A_END);

$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'affiliate_summary'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>
