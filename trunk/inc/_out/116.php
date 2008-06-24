<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_expire_specials.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:28 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(specials.php,v 1.5 2003/02/11); www.oscommerce.com 
   (c) 2003	    nextcommerce (olc_expire_specials.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
  require_once(DIR_FS_INC.'olc_set_specials_status.inc.php');
// Auto expire products on special
  function olc_expire_specials() {
    $specials_query = olc_db_query("select specials_id from " . TABLE_SPECIALS . " where status = '1' and now() >= expires_date and expires_date > 0");
    if (olc_db_num_rows($specials_query)) {
      while ($specials = olc_db_fetch_array($specials_query)) {
        olc_set_specials_status($specials['specials_id'], '0');
      }
    }
  }
 ?>