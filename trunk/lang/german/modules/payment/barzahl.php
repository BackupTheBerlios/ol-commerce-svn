<?
/* -----------------------------------------------------------------------------------------
   $Id: barzahl.php,v 2.0.0 2006/12/14 05:49:35 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cod.php,v 1.28 2003/02/14); www.oscommerce.com
   (c) 2003	    nextcommerce (BARZAHL.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

	 Bahrzahlung			Autor:	M. Tomanik

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_BARZAHL_TEXT_DESCRIPTION', 'Barzahlung');
  define('MODULE_PAYMENT_BARZAHL_TEXT_TITLE', 'Barzahlung');

  define('MODULE_PAYMENT_BARZAHL_STATUS_TITLE' , 'Barzahlungsmodul aktivieren');
define('MODULE_PAYMENT_BARZAHL_STATUS_DESC' , 'Möchten Sie Zahlungen per Barzahlung akzeptieren?');
define('MODULE_PAYMENT_BARZAHL_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_BARZAHL_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
define('MODULE_PAYMENT_BARZAHL_SORT_ORDER_TITLE' , 'Anzeigereihenfolge');
define('MODULE_PAYMENT_BARZAHL_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_BARZAHL_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_BARZAHL_ZONE_DESC' , 'Wenn eine Zone ausgewählt ist, gilt die Zahlungsmethode nur für diese Zone.');
define('MODULE_PAYMENT_BARZAHL_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_BARZAHL_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche für dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
?>