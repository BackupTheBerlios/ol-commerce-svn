<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_count_customer_address_book_entries.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:11 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	    nextcommerce (olc_count_customer_address_book_entries.inc.php,v 1.3 2003/08/13); www.nextcommerce.org 
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
function olc_count_customer_address_book_entries($id = '', $check_session = true) {

    if (is_numeric($id) == false) {
      if (isset($_SESSION['customer_id'])) {
        $id = $_SESSION['customer_id'];
      } else {
        return 0;
      }
    }

    if ($check_session == true) {
      if ( (isset($_SESSION['customer_id']) == false) || ($id != $_SESSION['customer_id']) ) {
        return 0;
      }
    }

    $addresses_query = olc_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$id . APOS);
    $addresses = olc_db_fetch_array($addresses_query);

    return $addresses['total'];
  }
 ?>