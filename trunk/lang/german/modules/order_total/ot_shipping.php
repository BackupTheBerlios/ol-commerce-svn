<?php
/* -----------------------------------------------------------------------------------------
$Id: ot_shipping.php,v 2.0.0 2006/12/14 05:49:34 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(ot_shipping.php,v 1.4 2003/02/16); www.oscommerce.com
(c) 2003	    nextcommerce (ot_shipping.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$versandkosten ='Versandkosten';
define('MODULE_ORDER_TOTAL_SHIPPING_TITLE', $versandkosten);
define('MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION', $versandkosten.' einer Bestellung');
$versandkostenfrei =$versandkosten .'frei';
define('FREE_SHIPPING_TITLE', '<font color="Red">'.$versandkostenfrei.'</font>');
define('FREE_SHIPPING_DESCRIPTION', $versandkostenfrei.' ab einem Bestellwert von %s');

define('MODULE_ORDER_TOTAL_SHIPPING_STATUS_TITLE',$versandkosten.'');
define('MODULE_ORDER_TOTAL_SHIPPING_STATUS_DESC','Anzeige der '.$versandkosten.QUESTION);

define('MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER_TITLE','Sortierreihenfolge');
define('MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER_DESC', 'Anzeigereihenfolge.');

define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_TITLE',$versandkostenfrei.' erlauben');
define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_DESC','Versandkostenfreie Lieferung erlauben ?');

define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_TITLE',$versandkostenfrei.' für Bestellungen ab');
define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_DESC',$versandkostenfrei.' ab einem Bestellwert von.');

define('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_TITLE',$versandkostenfrei.' nach Zonen');
define('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_DESC',MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_TITLE.' berechnen.');
?>