<?php
/* -----------------------------------------------------------------------------------------
   $Id: freeamountausl.php,v 2.0.0 2006/12/14 05:49:44 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce( freeamount.php,v 1.01 2002/01/24 03:25:00); www.oscommerce.com 
   (c) 2003	    nextcommerce (freeamount.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   versandkostenfrei         	Autor:	Manfred Tomanik http://www.st-computer.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_FREECOUNTAUSL_TEXT_TITLE', 'Versandkostenfrei Ausland');
define('MODULE_SHIPPING_FREECOUNTAUSL_TEXT_DESCRIPTION', 'Versandkostenfreie Lieferung');
define('MODULE_SHIPPING_FREECOUNTAUSL_TEXT_WAY', 'ab &euro; ' . MODULE_SHIPPING_FREECOUNTAUSL_AMOUNT . ' Bestellwert versenden wir Ihre Bestellung versandkostenfrei');
define('MODULE_SHIPPING_FREECOUNTAUSL_SORT_ORDER', 'Sortierreihenfolge');

define('MODULE_SHIPPING_FREEAMOUNTAUSL_ALLOWED_TITLE' , 'Erlaubte Versandzonen');
define('MODULE_SHIPPING_FREEAMOUNTAUSL_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, in welche ein Versand möglich sein soll. (z.B. AT,DE (lassen Sie dieses Feld leer, wenn Sie alle Zonen erlauben wollen))');
define('MODULE_SHIPPING_FREECOUNTAUSL_STATUS_TITLE' , 'Versandkostenfreie Lieferung aktivieren');
define('MODULE_SHIPPING_FREECOUNTAUSL_STATUS_DESC' , 'Möchten Sie Versandkostenfreie Lieferung anbieten?');
define('MODULE_SHIPPING_FREECOUNTAUSL_DISPLAY_TITLE' , 'Anzeige aktivieren');
define('MODULE_SHIPPING_FREECOUNTAUSL_DISPLAY_DESC' , 'Möchten Sie anzeigen, wenn der Mindestbetrag zur VK-freien Lieferung nicht erreicht ist?');
define('MODULE_SHIPPING_FREECOUNTAUSL_AMOUNT_TITLE' , 'Mindestbetrag');
define('MODULE_SHIPPING_FREECOUNTAUSL_AMOUNT_DESC' , 'Midestbestellwert, damit der Versand kostenlos ist?');
define('MODULE_SHIPPING_FREECOUNTAUSL_SORT_ORDER_TITLE' , 'Sortierreihenfolge');
define('MODULE_SHIPPING_FREECOUNTAUSL_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige');
?>