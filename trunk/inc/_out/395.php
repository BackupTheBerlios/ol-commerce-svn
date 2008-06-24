<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_oe_get_allow_tax.inc.php

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

   OLC-Bestellbearbeitung:
   http://www.xtc-webservice.de / Matthias Hinsche
   info@xtc-webservice.de

   Copyright (c) 2003 OL-Commerce 2.0
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	    nextcommerce (olc_get_products_price.inc.php,v 1.13 2003/08/20); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

// Gibt Status der MWSt. Anzeige für den jeweiligen Kundenstatus aus
  function olc_oe_get_allow_tax($customers_id) {
    $customer_query = olc_db_query("select customers_status from " . TABLE_CUSTOMERS . " where customers_id  = '" . $customers_id . APOS);
    $customer = olc_db_fetch_array($customer_query);

    $allow_query = olc_db_query("select customers_status_show_price_tax from " . TABLE_CUSTOMERS_STATUS . " where customers_status_id  = '" . $customer['customers_status'] . APOS);
    $allow = olc_db_fetch_array($allow_query);

    return $allow['customers_status_show_price_tax'];
  }
 ?>