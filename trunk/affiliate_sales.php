<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_sales.php,v 1.1.1.1.2.1 2007/04/08 07:16:07 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_sales.php, v 1.16 2003/09/22);
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
require_once(DIR_FS_INC . 'affiliate_get_status_list.inc.php');
require_once(DIR_FS_INC . 'affiliate_get_status_array.inc.php');
require_once(DIR_FS_INC . 'affiliate_get_level_list.inc.php');
require_once(DIR_FS_INC.'olc_date_short.inc.php');



if (!isset($_SESSION['affiliate_id'])) {
    olc_redirect(olc_href_link(FILENAME_AFFILIATE, '', SSL));
}

$breadcrumb->add(NAVBAR_TITLE, olc_href_link(FILENAME_AFFILIATE, '', SSL));
$breadcrumb->add(NAVBAR_TITLE_SALES, olc_href_link(FILENAME_AFFILIATE_SALES, '', SSL));

if (!isset($_GET['page'])) $_GET['page'] = 1;

if (olc_not_null($_GET['a_period'])) {
    $period_split = split('-', olc_db_prepare_input( $_GET['a_period'] ) );
    $period_clause = " AND year(a.affiliate_date) = " . $period_split[0] . " and month(a.affiliate_date) = " . $period_split[1];
}
if (olc_not_null($_GET['a_status'])) {
    $a_status = olc_db_prepare_input( $_GET['a_status'] );
    $status_clause = " AND o.orders_status = '" . $a_status . APOS;
}
if ( is_numeric( $_GET['a_level'] )  ) {
      $a_level = olc_db_prepare_input( $_GET['a_level'] );
      $level_clause = " AND a.affiliate_level = '" . $a_level . APOS;
}
$affiliate_sales_raw = "select a.affiliate_payment, a.affiliate_date, a.affiliate_value, a.affiliate_percent,
    a.affiliate_payment, a.affiliate_level AS level,
    o.orders_status as orders_status_id, os.orders_status_name as orders_status, 
    MONTH(aa.affiliate_date_account_created) as start_month, YEAR(aa.affiliate_date_account_created) as start_year
    from " . TABLE_AFFILIATE . " aa
    left join " . TABLE_AFFILIATE_SALES . " a on (aa.affiliate_id = a.affiliate_id )
    left join " . TABLE_ORDERS . " o on (a.affiliate_orders_id = o.orders_id) 
    left join " . TABLE_ORDERS_STATUS . " os on (o.orders_status = os.orders_status_id and language_id = '" . SESSION_LANGUAGE_ID . "')
    where a.affiliate_id = '" . $_SESSION['affiliate_id'] . "' " .
    $period_clause . $status_clause . $level_clause . " 
    group by aa.affiliate_date_account_created, o.orders_status, os.orders_status_name, 
        a.affiliate_payment, a.affiliate_date, a.affiliate_value, a.affiliate_percent, 
        o.orders_status, os.orders_status_name
    order by affiliate_date DESC";

$count_key = 'aa.affiliate_date_account_created, o.orders_status, os.orders_status_name, a.affiliate_payment, a.affiliate_date, a.affiliate_value, a.affiliate_percent, o.orders_status, os.orders_status_name';
        
$affiliate_sales_split = new splitPageResults($affiliate_sales_raw, $_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $count_key);
if ($affiliate_sales_split->number_of_rows > 0) {
    $affiliate_sales_values = olc_db_query($affiliate_sales_split->sql_query);
    $affiliate_sales = olc_db_fetch_array($affiliate_sales_values);
}
else {
    $affiliate_sales_values = olc_db_query( "select MONTH(affiliate_date_account_created) as start_month,
                                      YEAR(affiliate_date_account_created) as start_year
                                      FROM " . TABLE_AFFILIATE . " WHERE affiliate_id = '" . $_SESSION['affiliate_id'] . APOS );
    $affiliate_sales = olc_db_fetch_array( $affiliate_sales_values );
}

$smarty->assign('period_selector', affiliate_period('a_period', $affiliate_sales['start_year'], $affiliate_sales['start_month'], true, olc_db_prepare_input($_GET['a_period'] ), 'onchange="this.form.submit();"' ));
$smarty->assign('status_selector', affiliate_get_status_list('a_status', olc_db_prepare_input($_GET['a_status']), 'onchange="this.form.submit();"' ));
$smarty->assign('level_selector', affiliate_get_level_list('a_level', olc_db_prepare_input($_GET['a_level']), 'onchange="this.form.submit();"'));

require(DIR_WS_INCLUDES . 'header.php');

$smarty->assign('affiliate_sales_split_numbers', $affiliate_sales_split->number_of_rows);
$smarty->assign('FORM_ACTION', olc_draw_form('params', olc_href_link(FILENAME_AFFILIATE_SALES ), 'get', SSL ));

$affiliate_sales_table = '';

if ($affiliate_sales_split->number_of_rows > 0) {
    $number_of_sales = 0;
    $sum_of_earnings = 0;

    do {
    	$number_of_sales++;
    	if ($affiliate_sales['orders_status_id'] >= AFFILIATE_PAYMENT_ORDER_MIN_STATUS) $sum_of_earnings += $affiliate_sales['affiliate_payment'];
    	if (($number_of_sales / 2) == floor($number_of_sales / 2)) {
    		$affiliate_sales_table .= '<tr class="productListing-even">';
    	}
		else {
			$affiliate_sales_table .= '<tr class="productListing-odd">';
		}
		$affiliate_sales_table .= '<td class="smallText" align="center">' . olc_date_short($affiliate_sales['affiliate_date']) . '</td>';
		$affiliate_sales_table .= '<td class="smallText" align="right">' . $currencies->display_price($affiliate_sales['affiliate_value'], '') . '</td>';
		$affiliate_sales_table .= '<td class="smallText" align="right">' . $affiliate_sales['affiliate_percent'] . " %" . '</td>';
		$affiliate_sales_table .= '<td class="smallText" align="right">' . (($affiliate_sales['level'] > 0) ? $affiliate_sales['level'] : TEXT_AFFILIATE_PERSONAL_LEVEL_SHORT) . '</td>';
		$affiliate_sales_table .= '<td class="smallText" align="right">' . $currencies->display_price($affiliate_sales['affiliate_payment'], '') . '</td>';
		$affiliate_sales_table .= '<td class="smallText" align="right">' . (($affiliate_sales['orders_status'] != '')?$affiliate_sales['orders_status']:TEXT_DELETED_ORDER_BY_ADMIN) . '</td>';
		$affiliate_sales_table .= '</tr>';
	} while ( $affiliate_sales = olc_db_fetch_array($affiliate_sales_values) );
	$smarty->assign('affiliate_sales_table', $affiliate_sales_table);
}

if ($affiliate_sales_split->number_of_rows > 0) {
	$smarty->assign('affiliate_sales_count', $affiliate_sales_split->display_count(TEXT_DISPLAY_NUMBER_OF_SALES));
	$smarty->assign('affiliate_sales_links', $affiliate_sales_split->display_links(MAX_DISPLAY_PAGE_LINKS, olc_get_all_get_params(array('page', 'info', 'x', 'y'))));
}

$smarty->assign('affiliate_sales_total', $currencies->display_price($sum_of_earnings,''));

$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'affiliate_sales'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>
