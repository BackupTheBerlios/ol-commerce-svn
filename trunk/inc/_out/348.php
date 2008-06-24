<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_get_order_data.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:31 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	    nextcommerce (olc_get_order_data.inc.php,v 1.1 2003/08/15); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

function olc_get_order_data($order_id) {
$order_query = olc_db_query("SELECT
  customers_name,
  customers_company,
  customers_street_address,
  customers_suburb,
  customers_city,
  customers_postcode,
  customers_state,
  customers_country,
  customers_telephone,
  customers_email_address,
  customers_address_format_id,
  delivery_name,
  delivery_company,
  delivery_street_address,
  delivery_suburb,
  delivery_city,
  delivery_postcode,
  delivery_state,
  delivery_country,
  delivery_address_format_id,
  billing_name,
  billing_company,
  billing_street_address,
  billing_suburb,
  billing_city,
  billing_postcode,
  billing_state,
  billing_country,
  billing_address_format_id,
  payment_method,
  comments,
  date_purchased,
  orders_status,
  currency,
  currency_value
  					FROM ".TABLE_ORDERS."
  					WHERE orders_id='".$_GET['oID'].APOS);
  					
  $order_data= olc_db_fetch_array($order_query);
  // get order status name	
 $order_status_query=olc_db_query("SELECT
 				orders_status_name
 				FROM ".TABLE_ORDERS_STATUS."
 				WHERE orders_status_id='".$order_data['orders_status']."'
 				AND language_id='".SESSION_LANGUAGE_ID.APOS);
 $order_status_data=olc_db_fetch_array($order_status_query); 			
 $order_data['orders_status']=$order_status_data['orders_status_name'];
 // get language name for payment method
 include(DIR_WS_LANGUAGES.SESSION_LANGUAGE.'/modules/payment/'.$order_data['payment_method'].PHP);
 $order_data['payment_method']=constant(strtoupper('MODULE_PAYMENT_'.$order_data['payment_method'].'_TEXT_TITLE'));	
  return $order_data; 
}


?>