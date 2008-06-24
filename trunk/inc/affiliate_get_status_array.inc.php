<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_get_status_array.inc.php,v 1.1.1.1 2006/12/22 13:41:27 gswkaiser Exp $

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
 * affiliate_get_status_array()
 *
 * @return  array of available order status in current language
 **/
function affiliate_get_status_array() {

    $status_array = array();
    $status_sql = "select orders_status_id, orders_status_name"
                            . " FROM " . TABLE_ORDERS_STATUS
                            . " WHERE language_id = " . SESSION_LANGUAGE_ID
                            . " ORDER BY orders_status_id" ;
    $status = olc_db_query( $status_sql );
    while ( $status_values = olc_db_fetch_array( $status ) ) {
    	$status_array[] = array('orders_status_id' => $status_values['orders_status_id'],
                                'orders_status_name' => $status_values['orders_status_name']);
    }
    return $status_array;
}
?>
