<?php
/* -----------------------------------------------------------------------------------------
   $Id: nochex.php,v 2.0.0 2006/12/14 05:49:37 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(nochex.php,v 1.3 2002/11/01); www.oscommerce.com 
   (c) 2003	    nextcommerce (nochex.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_NOCHEX_TEXT_TITLE', 'NOCHEX');
  define('MODULE_PAYMENT_NOCHEX_TEXT_DESCRIPTION', 'NOCHEX<br/>Erfordert die Währung GBP.');
  
  define('MODULE_PAYMENT_NOCHEX_STATUS_TITLE' , 'NOCHEX Modul aktivieren');
define('MODULE_PAYMENT_NOCHEX_STATUS_DESC' , 'Möchten Sie Zahlungen per NOCHEX akzeptieren?');
define('MODULE_PAYMENT_NOCHEX_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_NOCHEX_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche für dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_NOCHEX_ID_TITLE' , 'eMail Adresse');
define('MODULE_PAYMENT_NOCHEX_ID_DESC' , 'eMail Adresse, welche für NOCHEX verwendet wird');
define('MODULE_PAYMENT_NOCHEX_SORT_ORDER_TITLE' , 'Anzeigereihenfolge.');
define('MODULE_PAYMENT_NOCHEX_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_NOCHEX_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_NOCHEX_ZONE_DESC' , 'Wenn eine Zone ausgewählt ist, gilt die Zahlungsmethode nur für diese Zone.');
define('MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
?>