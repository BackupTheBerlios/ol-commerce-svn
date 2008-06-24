<?php
/* --------------------------------------------------------------
   $Id: languages.php,v 1.1.1.1.2.1 2007/04/08 07:16:43 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(languages.php,v 1.5 2002/11/22); www.oscommerce.com 
   (c) 2003	    nextcommerce (languages.php,v 1.6 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/

  function olc_get_languages_directory($code) {
    $language_query = olc_db_query("select languages_id, directory from " . TABLE_LANGUAGES . " where code = '" . $code . APOS);
    if (olc_db_num_rows($language_query)) {
      $lang = olc_db_fetch_array($language_query);
      $_SESSION['languages_id'] = $lang['languages_id'];
      return $lang['directory'];
    } else {
      return false;
    }
  }
?>