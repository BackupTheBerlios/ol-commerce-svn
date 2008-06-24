<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_get_qty.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:33 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

   function olc_get_qty($products_id)  {

     if (strpos($products_id,'{'))  {
    $act_id=substr($products_id,0,strpos($products_id,'{'));
  } else {
    $act_id=$products_id;
  }

  return $_SESSION['actual_content'][$act_id]['qty'];

   }

?>