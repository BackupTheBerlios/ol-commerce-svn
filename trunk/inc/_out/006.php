<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_level_statistics_query.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:08 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_functions.php, v 1.15 2003/09/17);
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

/**
 * affiliate_level_statistics_query()
 *
 * returns array with information
 *
 * @param integer $affiliate_id - Subject Affiliate id limit
 * @param integer $period         - Period limit yyyy-mm
 * @return string - olc_query result
 **/
function affiliate_level_statistics_query( $affiliate_id, $period = NULL) {
	if (empty($affiliate_id) || !is_numeric($affiliate_id)) return false;
    $sales = array();
    if ( !( is_null( $period ) ) ) {
    	$period_split = split( "-", $period );
    	$period_clause = " AND year(affiliate_date) = " . $period_split[0] . " and month(affiliate_date) = " . $period_split[1];
    }
	else {
		$period_clause = BLANK;
	}
	$affiliate_sales_raw = "select affiliate_level, count(*) as count, sum(affiliate_value) as total, sum(affiliate_payment) as payment from " . TABLE_AFFILIATE_SALES . " a
		    				left join " . TABLE_ORDERS . " o on (a.affiliate_orders_id=o.orders_id)
        					where a.affiliate_id = '" . $affiliate_id . "' and o.orders_status >= " . AFFILIATE_PAYMENT_ORDER_MIN_STATUS . BLANK . $period_clause . "
        					group by affiliate_level order by affiliate_level";
    $affiliate_sales_query = olc_db_query($affiliate_sales_raw);
    while ($affiliate_sales = olc_db_fetch_array($affiliate_sales_query)) {
    	$sales[$affiliate_sales['affiliate_level']]['total'] = $affiliate_sales['total'];
        $sales[$affiliate_sales['affiliate_level']]['payment'] = $affiliate_sales['payment'];
        $sales[$affiliate_sales['affiliate_level']]['count'] = $affiliate_sales['count'];
        $sales['total'] += $affiliate_sales['total'];
        $sales['payment'] += $affiliate_sales['payment'];
        $sales['count'] += $affiliate_sales['count'];
    }

    return $sales;
}
?>
