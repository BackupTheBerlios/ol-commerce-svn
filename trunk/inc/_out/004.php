<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_get_status_list.inc.php,v 1.1.1.1 2006/12/22 13:41:28 gswkaiser Exp $

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
 * affiliate_get_status_list()
 *
 * @param $name
 * @param string $selected
 * @param string $parameters
 * @param bool $show_all - show "All Status" or not
 * @return  Dropdown listbox with order status
 **/
function affiliate_get_status_list($name, $selected = '', $parameters = '', $show_all = true) {
    if ( $show_all == true ) {
    	$status_array = array(array('id' => '', 'text' => TEXT_AFFILIATE_ALL_STATUS ) );
    }
	else {
		$status_array = array(array('id' => '', 'text' => PULL_DOWN_DEFAULT) );
    }

    $status = affiliate_get_status_array();
    for ($i=0, $n=sizeof( $status ); $i<$n; $i++) {
    	$status_array[] = array('id' => $status[$i]['orders_status_id'], 'text' => $status[$i]['orders_status_name']);
    }

    return olc_draw_pull_down_menu($name, $status_array, $selected, $parameters);
}
?>
