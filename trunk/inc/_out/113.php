<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_error_message.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:25 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	    nextcommerce (olc_error_message.inc.php,v 1.3 2003/08/1); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function olc_error_message($error_message, $close_application = false, $close_application_error = '') {
    echo $error_message;

    if ($close_application == true) {
      die($close_application_error);
    }
  }
 ?>