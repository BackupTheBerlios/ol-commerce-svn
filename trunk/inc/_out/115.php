<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_expire_banners.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:28 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	    nextcommerce (olc_expire_banners.inc.php,v 1.5 2003/08/1); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require_once(DIR_FS_INC.'olc_set_banner_status.inc.php');
   
// Auto expire banners
  function olc_expire_banners() {
    $banners_query = olc_db_query("select b.banners_id, b.expires_date, b.expires_impressions, sum(bh.banners_shown) as banners_shown from " . TABLE_BANNERS . " b, " . TABLE_BANNERS_HISTORY . " bh where b.status = '1' and b.banners_id = bh.banners_id group by b.banners_id");
    if (olc_db_num_rows($banners_query)) {
      while ($banners = olc_db_fetch_array($banners_query)) {
        if (olc_not_null($banners['expires_date'])) {
          if (date('Y-m-d H:i:s') >= $banners['expires_date']) {
            olc_set_banner_status($banners['banners_id'], '0');
          }
        } elseif (olc_not_null($banners['expires_impressions'])) {
          if ($banners['banners_shown'] >= $banners['expires_impressions']) {
            olc_set_banner_status($banners['banners_id'], '0');
          }
        }
      }
    }
  }
 ?>
