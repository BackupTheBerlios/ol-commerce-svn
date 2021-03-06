<?php
/* -----------------------------------------------------------------------------------------
   $Id: redirect.php,v 1.1.1.1.2.1 2007/04/08 07:16:19 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(redirect.php,v 1.9 2003/02/13); www.oscommerce.com 
   (c) 2003	    nextcommerce (redirect.php,v 1.7 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  include( 'includes/application_top.php');
  
  require_once(DIR_FS_INC.'olc_update_banner_click_count.inc.php');
  
  switch ($_GET['action']) {
    case 'banner':
      $banner_query = olc_db_query("select banners_url from " . TABLE_BANNERS . " where banners_id = '" . $_GET['goto'] . APOS);
      if (olc_db_num_rows($banner_query)) {
        $banner = olc_db_fetch_array($banner_query);
        olc_update_banner_click_count($_GET['goto']);

        olc_redirect($banner['banners_url']);
      } else {
        olc_redirect(olc_href_link(FILENAME_DEFAULT));
      }
      break;

    case 'url':
      if (isset($_GET['goto'])) {
        olc_redirect('http://' . $_GET['goto']);
      } else {
        olc_redirect(olc_href_link(FILENAME_DEFAULT));
      }
      break;

    case 'manufacturer':
      if (isset($_GET['manufacturers_id'])) {
        $manufacturer_query = olc_db_query("select manufacturers_url from " . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and languages_id = '" . SESSION_LANGUAGE_ID . APOS);
        if (!olc_db_num_rows($manufacturer_query)) {
          // no url exists for the selected language, lets use the default language then
          $manufacturer_query = olc_db_query("select mi.languages_id, mi.manufacturers_url from " . TABLE_MANUFACTURERS_INFO . " mi, " . TABLE_LANGUAGES . " l where mi.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and mi.languages_id = l.languages_id and l.code = '" . DEFAULT_LANGUAGE . APOS);
          if (!olc_db_num_rows($manufacturer_query)) {
            // no url exists, return to the site
            olc_redirect(olc_href_link(FILENAME_DEFAULT));
          } else {
            $manufacturer = olc_db_fetch_array($manufacturer_query);
            olc_db_query(SQL_UPDATE . TABLE_MANUFACTURERS_INFO . " set url_clicked = url_clicked+1, date_last_click = now() where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and languages_id = '" . $manufacturer['languages_id'] . APOS);
          }
        } else {
          // url exists in selected language
          $manufacturer = olc_db_fetch_array($manufacturer_query);
          olc_db_query(SQL_UPDATE . TABLE_MANUFACTURERS_INFO . " set url_clicked = url_clicked+1, date_last_click = now() where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and languages_id = '" . SESSION_LANGUAGE_ID . APOS);
        }

        olc_redirect($manufacturer['manufacturers_url']);
      } else {
        olc_redirect(olc_href_link(FILENAME_DEFAULT));
      }
      break;

    default:
      olc_redirect(olc_href_link(FILENAME_DEFAULT));
      break;
  }
?>