<?php
/* -----------------------------------------------------------------------------------------
   $Id: olc_encrypt_password.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:24 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(password_funcs.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	    nextcommerce (olc_encrypt_password.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
  
// This function makes a new password from a plaintext password. 
  function olc_encrypt_password($plain) {

     $password=md5($plain);

    return $password;

  }
 ?>