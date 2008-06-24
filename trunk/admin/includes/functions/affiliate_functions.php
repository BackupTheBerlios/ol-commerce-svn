<?php
/*------------------------------------------------------------------------------
$Id: affiliate_functions.php,v 1.1.1.1.2.1 2007/04/08 07:16:43 gswkaiser Exp $

OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

modified by http://www.ol-commerce.de, http://www.seifenparadies.de


Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------
based on:
(c) 2003 OSC-Affiliate (affiliate_functions.php, v 1.6 2003/07/12);
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

function affiliate_delete ($affiliate_id) {
	$affiliate_query = olc_db_query("SELECT affiliate_rgt, affiliate_lft, affiliate_root  FROM " . TABLE_AFFILIATE . " WHERE affiliate_id = '" . $affiliate_id . "' ");
	if ($affiliate = olc_db_fetch_array($affiliate_query)) {
		$lock_table_affiliate="LOCK TABLES " . TABLE_AFFILIATE . " WRITE";
		$unlock_table_affiliate="UNLOCK TABLES";
		$update_table_affiliate="SQL_UPDATE  " . TABLE_AFFILIATE . " SET ";
		$delete_from_table_affiliate=DELETE_FROM . TABLE_AFFILIATE . "  WHERE affiliate_id = " . $affiliate_id;
		if ($affiliate['affiliate_root'] == $affiliate_id)
		{
			// a root entry is deleted -> his childs get root
			$affiliate_child_query = olc_db_query("
                    SELECT aa1.affiliate_id, aa1.affiliate_lft, aa1.affiliate_rgt,  COUNT(*) AS level
	                  FROM ".TABLE_AFFILIATE." AS aa1, affiliate_affiliate AS aa2
	                  WHERE aa1.affiliate_root = " . $affiliate['affiliate_root'] . "
	                        AND aa2.affiliate_root = aa1.affiliate_root
	                        AND aa1.affiliate_lft BETWEEN aa2.affiliate_lft AND aa2.affiliate_rgt
	                        AND aa1.affiliate_rgt BETWEEN aa2.affiliate_lft AND aa2.affiliate_rgt
	                  GROUP BY aa1.affiliate_id, aa1.affiliate_lft, aa1.affiliate_rgt
                    HAVING level = 2
	                  ORDER BY aa1.affiliate_id
                   ");
			olc_db_query($lock_table_affiliate);
			while ($affiliate_child = olc_db_fetch_array($affiliate_child_query)) {
				olc_db_query ($update_table_affiliate."affiliate_root = " . $affiliate_child['affiliate_id'] . " WHERE affiliate_root =  " . $affiliate['affiliate_root'] . "  AND affiliate_lft >= " . $affiliate_child['affiliate_lft']  . " AND affiliate_rgt <= " . $affiliate_child['affiliate_rgt']  . BLANK);
				$affiliate_root=" WHERE  affiliate_root = " . $affiliate_child['affiliate_id'];
				$substract =  ($affiliate_child['affiliate_lft'] -1). $affiliate_root;
				olc_db_query ($update_table_affiliate."affiliate_lft = affiliate_lft - " . $substract );
				olc_db_query ($update_table_affiliate."affiliate_rgt = affiliate_rgt - " . $substract);
			}
			olc_db_query($delete_from_table_affiliate);
			olc_db_query($unlock_table_affiliate);
		} else {
			olc_db_query($lock_table_affiliate);
			$affiliate_root=" AND affiliate_root = " . $affiliate['affiliate_root'];
			$affiliate_lft=$affiliate['affiliate_lft'];
			$affiliate_rgt=$affiliate['affiliate_rgt'];
			olc_db_query($delete_from_table_affiliate . $affiliate_root);
			olc_db_query($update_table_affiliate."affiliate_lft = affiliate_lft-1, affiliate_rgt=affiliate_rgt-1
        WHERE affiliate_lft BETWEEN " . $affiliate_lft . " and " . $affiliate_rgt . $affiliate_root);
			olc_db_query($update_table_affiliate."affiliate_lft = affiliate_lft-2
        WHERE affiliate_lft > " . $affiliate_rgt . $affiliate_root);
			olc_db_query($update_table_affiliate."affiliate_rgt = affiliate_rgt-2
        WHERE affiliate_rgt > " . $affiliate_rgt . $affiliate_root);
			olc_db_query($unlock_table_affiliate);
		}
	}
}

////
// Returns the tax rate for a zone / class
// TABLES: tax_rates, zones_to_geo_zones
function olc_get_affiliate_tax_rate($class_id, $country_id, $zone_id) {

	$tax_query = olc_db_query("select SUM(tax_rate) as tax_rate from " . TABLE_TAX_RATES . " tr left join " .
	TABLE_ZONES_TO_GEO_ZONES . " za ON tr.tax_zone_id = za.geo_zone_id left join " .
	TABLE_GEO_ZONES . " tz ON tz.geo_zone_id = tr.tax_zone_id
    	WHERE (za.zone_country_id IS NULL OR za.zone_country_id = '0' OR za.zone_country_id = '" . $country_id .
    	"') AND (za.zone_id IS NULL OR za.zone_id = '0' OR za.zone_id = '" . $zone_id .
    	"') AND tr.tax_class_id = '" . $class_id . "' GROUP BY tr.tax_priority");
    	if (olc_db_num_rows($tax_query)) {
    		$tax_multiplier = 0;
    		while ($tax = olc_db_fetch_array($tax_query)) {
    			$tax_multiplier += $tax['tax_rate'];
    		}
    		return $tax_multiplier;
    	} else {
    		return 0;
    	}
}
?>
