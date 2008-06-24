<?php
/*------------------------------------------------------------------------------
$Id: affiliate_checkout_process.php,v 1.1.1.1.2.1 2007/04/08 07:17:43 gswkaiser Exp $

OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

modified by http://www.ol-commerce.de, http://www.seifenparadies.de


Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------
based on:
(c) 2003 OSC-Affiliate (affiliate_checkout_process.php, v 1.12 2003/09/17);
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

// fetch the net total of an order
$affiliate_total = 0;
for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
	$affiliate_total += $order->products[$i]['price'] * $order->products[$i]['qty'];
}
$affiliate_total = olc_round($affiliate_total, 2);

// Check for individual commission
$affiliate_percentage = 0;
if (AFFILATE_INDIVIDUAL_PERCENTAGE == TRUE_STRING_S) {
	$affiliate_commission_query = olc_db_query ("select affiliate_commission_percent from " . TABLE_AFFILIATE . " where affiliate_id = '" . $_SESSION['affiliate_ref'] . APOS);
	$affiliate_commission = olc_db_fetch_array($affiliate_commission_query);
	$affiliate_percent = $affiliate_commission['affiliate_commission_percent'];
}
if ($affiliate_percent < AFFILIATE_PERCENT) $affiliate_percent = AFFILIATE_PERCENT;
$affiliate_payment = olc_round(($affiliate_total * $affiliate_percent / 100), 2);

if (isset($_SESSION['affiliate_ref'])) {
	$sql_data_array = array('affiliate_id' => $_SESSION['affiliate_ref'],
	'affiliate_date' => $affiliate_clientdate,
	'affiliate_browser' => $affiliate_clientbrowser,
	'affiliate_ipaddress' => $affiliate_clientip,
	'affiliate_value' => $affiliate_total,
	'affiliate_payment' => $affiliate_payment,
	'affiliate_orders_id' => $insert_id,
	'affiliate_clickthroughs_id' => $_SESSION['affiliate_clickthroughs_id'],
	'affiliate_percent' => $affiliate_percent,
	'affiliate_salesman' => $_SESSION['affiliate_ref'],
	'affiliate_level' => '0');
	olc_db_perform(TABLE_AFFILIATE_SALES, $sql_data_array);

	if (AFFILATE_USE_TIER == TRUE_STRING_S) {
		$affiliate_tiers_query = olc_db_query ("SELECT aa2.affiliate_id, (aa2.affiliate_rgt - aa2.affiliate_lft) as height
                                                      FROM  " . TABLE_AFFILIATE . "  AS aa1, " . TABLE_AFFILIATE . "  AS aa2
                                                      WHERE  aa1.affiliate_root = aa2.affiliate_root
                                                            AND aa1.affiliate_lft BETWEEN aa2.affiliate_lft AND aa2.affiliate_rgt
                                                            AND aa1.affiliate_rgt BETWEEN aa2.affiliate_lft AND aa2.affiliate_rgt
                                                            AND aa1.affiliate_id =  '" . $_SESSION['affiliate_ref'] . "'
                                                      ORDER by height asc limit 1, " . AFFILIATE_TIER_LEVELS);
		$affiliate_tier_percentage = split("[;]" , AFFILIATE_TIER_PERCENTAGE);
		$i=0;
		while ($affiliate_tiers_array = olc_db_fetch_array($affiliate_tiers_query)) {
			$affiliate_percent = $affiliate_tier_percentage[$i];
			$affiliate_payment = olc_round(($affiliate_total * $affiliate_percent / 100), 2);
			if ($affiliate_payment > 0) {
				$sql_data_array = array('affiliate_id' => $affiliate_tiers_array['affiliate_id'],
				'affiliate_date' => $affiliate_clientdate,
				'affiliate_browser' => $affiliate_clientbrowser,
				'affiliate_ipaddress' => $affiliate_clientip,
				'affiliate_value' => $affiliate_total,
				'affiliate_payment' => $affiliate_payment,
				'affiliate_orders_id' => $insert_id,
				'affiliate_clickthroughs_id' => $_SESSION['affiliate_clickthroughs_id'],
				'affiliate_percent' => $affiliate_percent,
				'affiliate_salesman' => $_SESSION['affiliate_ref'],
				'affiliate_level' => $i+1);
				olc_db_perform(TABLE_AFFILIATE_SALES, $sql_data_array);
			}
			$i++;
		}
	}
}
?>
