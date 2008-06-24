<?php
/* -----------------------------------------------------------------------------------------
   $Id: banners.php,v 1.1.1.1.2.1 2007/04/08 07:17:44 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  require_once(DIR_FS_INC.'olc_banner_exists.inc.php');
  require_once(DIR_FS_INC.'olc_display_banner.inc.php');
  require_once(DIR_FS_INC.'olc_update_banner_display_count.inc.php');


  if ($banner = olc_banner_exists('dynamic', 'banner')) {
  $smarty->assign('BANNER',olc_display_banner('static', $banner));

  }
?>