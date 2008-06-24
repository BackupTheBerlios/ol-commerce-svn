<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_insert.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:08 gswkaiser Exp $

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

function affiliate_insert ($sql_data_array, $affiliate_parent = 0) {
    // LOCK TABLES
 //   olc_db_query("LOCK TABLES " . TABLE_AFFILIATE . " WRITE");
    if ($affiliate_parent > 0) {
    	$affiliate_root_query = olc_db_query("select affiliate_root, affiliate_rgt, affiliate_lft from  " . TABLE_AFFILIATE . " where affiliate_id = '" . $affiliate_parent . "' ");
    	// Check if we have a parent affiliate
    	if ($affiliate_root_array = olc_db_fetch_array($affiliate_root_query)) {
    		olc_db_query(SQL_UPDATE . TABLE_AFFILIATE . " SET affiliate_lft = affiliate_lft + 2 WHERE affiliate_root  =  '" . $affiliate_root_array['affiliate_root'] . "' and  affiliate_lft > "  . $affiliate_root_array['affiliate_rgt'] . "  AND affiliate_rgt >= " . $affiliate_root_array['affiliate_rgt'] . BLANK);
        	olc_db_query(SQL_UPDATE . TABLE_AFFILIATE . " SET affiliate_rgt = affiliate_rgt + 2 WHERE affiliate_root  =  '" . $affiliate_root_array['affiliate_root'] . "' and  affiliate_rgt >= "  . $affiliate_root_array['affiliate_rgt'] . "  ");
            $sql_data_array['affiliate_root'] = $affiliate_root_array['affiliate_root'];
            $sql_data_array['affiliate_lft'] = $affiliate_root_array['affiliate_rgt'];
            $sql_data_array['affiliate_rgt'] = ($affiliate_root_array['affiliate_rgt'] + 1);
            olc_db_perform(TABLE_AFFILIATE, $sql_data_array);
            $affiliate_id = olc_db_insert_id();
        }
        // no parent -> new root
    }
	else {
		$sql_data_array['affiliate_lft'] = '1';
		$sql_data_array['affiliate_rgt'] = '2';
		olc_db_perform(TABLE_AFFILIATE, $sql_data_array);
		$affiliate_id = olc_db_insert_id();
		olc_db_query (SQL_UPDATE . TABLE_AFFILIATE . " set affiliate_root = '" . $affiliate_id . "' where affiliate_id = '" . $affiliate_id . "' ");
    }
    // UNLOCK TABLES
    olc_db_query("UNLOCK TABLES");
    return $affiliate_id;
}
?>
