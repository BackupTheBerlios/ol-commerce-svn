<?php
/*
  $Id: addressbook.func.php,v 1.1.1.1.2.1 2007/04/08 07:18:09 gswkaiser Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  DevosC, Developing open source Code
  http://www.devosc.com

  Copyright (c) 2003 osCommerce
  Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

  Released under the GNU General Public License
*/

////
// Returns the address_format_id for the given country
// TABLES: countries;
  function olc_get_address_format_id($country_id) {
    $address_format_query = olc_db_query("select address_format_id as format_id from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$country_id . APOS);
    if (olc_db_num_rows($address_format_query)) {
      $address_format = olc_db_fetch_array($address_format_query);
      return $address_format['format_id'];
    } else {
      return '1';
    }
  }

////
// Return a formatted address
// TABLES: customers, address_book
  function olc_address_label($customers_id, $address_id = 1, $html = false, $boln = '', $eoln = NEW_LINE) {
    $address_query = olc_db_query("select entry_firstname as firstname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_suburb as suburb, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customers_id . "' and address_book_id = '" . (int)$address_id . APOS);
    $address = olc_db_fetch_array($address_query);

    $format_id = olc_get_address_format_id($address['country_id']);

    return olc_address_format($format_id, $address, $html, $boln, $eoln);
  }
?>