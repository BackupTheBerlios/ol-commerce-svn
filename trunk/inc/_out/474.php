<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_check_stock_attributes.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:10 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	    nextcommerce (olc_check_stock_attributes.inc.php); www.nextcommerce.org 
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function olc_check_stock_attributes($attribute_id, $products_quantity) {

       $stock_query=olc_db_query("SELECT
                                  attributes_stock
                                  FROM ".TABLE_PRODUCTS_ATTRIBUTES."
                                  WHERE products_attributes_id='".$attribute_id.APOS);
       $stock_data=olc_db_fetch_array($stock_query);
    $stock_left = $stock_data['attributes_stock'] - $products_quantity;
    $out_of_stock = '';

    if ($stock_left < 0) {
      $out_of_stock = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
    }

    return $out_of_stock;
  }
 ?>