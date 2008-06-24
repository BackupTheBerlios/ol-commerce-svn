<?php
/* -----------------------------------------------------------------------------------------
 $Id: olc_findTitle.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:28 gswkaiser Exp $

 OL-Commerce Version 5.x/AJAX
 http://www.ol-commerce.com, http://www.seifenparadies.de

 Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
 --------------------------------------------------------------
 based on:
 (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 (c) 2002-2003 osCommerce(new_attributes); www.oscommerce.com
 (c) 2003     nextcommerce (new_attributes.php,v 1.13 2003/08/21); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

  Released under the GNU General Public License
 --------------------------------------------------------------
 Third Party contributions:
 New Attribute Manager v4b                Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
 (c) 2004      XT - Commerce; www.xt-commerce.com

  Released under the GNU General Public License
 ---------------------------------------------------------------------------------------*/
function olc_findTitle($current_pid, $languageFilter) {
  $query = "SELECT * FROM " . TABLE_PRODUCTS_DESCRIPTION . " where language_id = '" . SESSION_LANGUAGE_ID . 
  "' AND products_id = '" . $current_pid . APOS;
  $result = olc_db_query($query);
  $matches = olc_db_num_rows($result);
  if ($matches) {
    while ($line = olc_db_fetch_array($result, olc_db_ASSOC)) {
      $productName = $line['products_name'];
    }
    return $productName;
  } else {
    return "Something isn't right....";
  }
}
?>