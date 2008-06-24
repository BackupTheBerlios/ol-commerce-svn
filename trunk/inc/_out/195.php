<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_oe_get_customers_status.inc.php

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

// Gibt den jeweiligen Kundenstatus aus
  function olc_oe_get_customers_status($customers_id) {
    $customer_query = olc_db_query("select customers_status from " . TABLE_CUSTOMERS . " where customers_id  = '" . $customers_id . APOS);
    $customer = olc_db_fetch_array($customer_query);

    return $customer['customers_status'];
  }
 ?>