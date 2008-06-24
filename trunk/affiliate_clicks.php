<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_clicks.php,v 1.1.1.1.2.1 2007/04/08 07:16:04 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_clicks.php, v 1.12 2003/09/22);
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
require_once(DIR_FS_INC.'olc_date_short.inc.php');



if (!isset($_SESSION['affiliate_id'])) {
    olc_redirect(olc_href_link(FILENAME_AFFILIATE, '', SSL));
}

$breadcrumb->add(NAVBAR_TITLE, olc_href_link(FILENAME_AFFILIATE, '', SSL));
$breadcrumb->add(NAVBAR_TITLE_CLICKS, olc_href_link(FILENAME_AFFILIATE_CLICKS, '', SSL));

if (!isset($_GET['page'])) $_GET['page'] = 1;

$affiliate_clickthroughs_raw = "select a.*, pd.products_name from " . TABLE_AFFILIATE_CLICKTHROUGHS . " a
                                    left join " . TABLE_PRODUCTS . " p on (p.products_id = a.affiliate_products_id)
                                    left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on (pd.products_id = p.products_id and pd.language_id = '" . SESSION_LANGUAGE_ID . "')
                                    where a.affiliate_id = '" . $_SESSION['affiliate_id'] . "'  ORDER BY a.affiliate_clientdate desc";
$affiliate_clickthroughs_split = new splitPageResults($affiliate_clickthroughs_raw, $_GET['page'], MAX_DISPLAY_SEARCH_RESULTS);

require(DIR_WS_INCLUDES . 'header.php');

$smarty->assign('affiliate_clickthroughs_split_number', $affiliate_clickthroughs_split->number_of_rows);

$affiliate_clickthrough_table = '';

if ($affiliate_clickthroughs_split->number_of_rows > 0) {
    $affiliate_clickthroughs_values = olc_db_query($affiliate_clickthroughs_split->sql_query);
    $number_of_clickthroughs = '0';
    while ($affiliate_clickthroughs = olc_db_fetch_array($affiliate_clickthroughs_values)) {
        $number_of_clickthroughs++;
        
        if (($number_of_clickthroughs / 2) == floor($number_of_clickthroughs / 2)) {
            $affiliate_clickthrough_table .= '<tr class="productListing-even">';
        }
        else {
            $affiliate_clickthrough_table .= '<tr class="productListing-odd">';
        }
        $affiliate_clickthrough_table .= '<td class="smallText">' . olc_date_short($affiliate_clickthroughs['affiliate_clientdate']) . '</td>';
        if ($affiliate_clickthroughs['affiliate_products_id'] > 0) {
            $link_to = HTML_A_START . olc_href_link (FILENAME_PRODUCT_INFO, 'products_id=' . $affiliate_clickthroughs['affiliate_products_id']) . '" target="_blank">' . $affiliate_clickthroughs['products_name'] . HTML_A_END;
        }
        else {
            $link_to = "Startpage";
        }
        $affiliate_clickthrough_table .= '<td class="smallText">' . $link_to . '</td>';
        $affiliate_clickthrough_table .= '<td class="smallText">' . $affiliate_clickthroughs['affiliate_clientreferer'] . '</td></tr>';
    }
    $smarty->assign('affiliate_clickthrough_table', $affiliate_clickthrough_table);
}

if ($affiliate_clickthroughs_split->number_of_rows > 0) {
    $smarty->assign('affiliate_clickthroughs_split_count', $affiliate_clickthroughs_split->display_count(TEXT_DISPLAY_NUMBER_OF_CLICKS));
    $smarty->assign('affiliate_clickthroughs_split_links', $affiliate_clickthroughs_split->display_links(MAX_DISPLAY_PAGE_LINKS, olc_get_all_get_params(array('page', 'info', 'x', 'y'))));
}
$main_content=$smarty->fetch(CURRENT_TEMPLATE_MODULE . 'affiliate_clicks'.HTML_EXT,SMARTY_CACHE_ID);
$smarty->assign(MAIN_CONTENT,$main_content);
require(BOXES);
$smarty->display(INDEX_HTML);
?>
