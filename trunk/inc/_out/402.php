<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_oe_get_tax_rate.inc.php

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

// Berechnet Nettopreis aus Brutto
// Gibt den MWST Satz anhand der id aus
  function olc_oe_get_tax_rate($tax_class_id) {

    $tax_rate_query = olc_db_query("select tax_rate from " . TABLE_TAX_RATES . " where tax_class_id = '" . $tax_class_id . APOS);
    $tax_rate = olc_db_fetch_array($tax_rate_query);

    return $tax_rate['tax_rate'];
  }
 ?>