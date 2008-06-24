<?php
/* --------------------------------------------------------------
   $Id: start.php,v 2.0.0 2006/12/14 05:48:40 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on:
   (c) 2003	    nextcommerce (start.php,v 1.1 2003/08/19); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/
 
  define('HEADING_TITLE','Welcome');
  define('ATTENTION_TITLE','! ATTENTION !');

  // text for Warnings:
  define('TEXT_FILE_WARNING','<b>WARNING:</b><br/>Following files are writeable. Please change the permissions of this files due to security reasons. <b>(444)</b> in unix, <b>(read-only)</b> in Win32.');
  define('TEXT_FOLDER_WARNING','<b>WARNING:</b><br/>Following folders must be writeable. Please change the permissions of these folders. <b>(777)</b> in unix, <b>(read-write)</b> in Win32.');
?>
