<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_get_level_list.inc.php,v 1.1.1.1 2006/12/22 13:41:27 gswkaiser Exp $

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
 * affiliate_get_level_list()
 *
 * @param $name
 * @param string $selected
 * @param string $parameters
 * @return Dropdown Listbox.  Note personal level value is  AFFILIATE_TIER_LEVELS + 1
 **/
function affiliate_get_level_list($name, $selected = '', $parameters = '' ) {
    $status_array = array(array('id' => '', 'text' => TEXT_AFFILIATE_ALL_LEVELS ) );
    $status_array[] = array('id' => '0'  , 'text' => TEXT_AFFILIATE_PERSONAL_LEVEL );

    for ( $i = 1 ; $i <= AFFILIATE_TIER_LEVELS; $i++ ) {
    	$status_array[] = array('id' => $i, 'text' => TEXT_AFFILIATE_LEVEL_SUFFIX . $i );
    }

    return olc_draw_pull_down_menu($name, $status_array, $selected, $parameters);
}
?>
