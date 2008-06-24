<?php
/* -----------------------------------------------------------------------------------------
$Id: freeamount.php,v 2.0.0 2006/12/14 05:49:43 gswkaiser Exp $

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
freeamountv2-p1         	Autor:	dwk

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_FREECOUNT_TEXT_TITLE', 'Versandkostenfrei');
define('MODULE_SHIPPING_FREECOUNT_TEXT_DESCRIPTION', 'Versandkostenfreie Lieferung');
if (!$menu_gen)
{
	//W. Kaiser
	require_once(DIR_FS_INC .'olc_format_price.inc.php');
	require_once(DIR_FS_INC.'olc_get_free_shipping_amount.inc.php');
	olc_get_free_shipping_amount();
}
define('MODULE_SHIPPING_FREECOUNT_TEXT_WAY', 'Ab <b>' .
olc_format_price(FREE_AMOUNT, $price_special = 1, $calculate_currencies = false) .
'</b> Bestellwert versenden wir Ihre Bestellung <b>ohne</b> Versandkosten.<br/>'.
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<font color="red"><b>Dazu noch fehlender Betrag:&nbsp;</b></font>');
//W. Kaiser
define('MODULE_SHIPPING_FREECOUNT_SORT_ORDER', 'Sortierreihenfolge');

define('MODULE_SHIPPING_FREEAMOUNT_ALLOWED_TITLE' , 'Erlaubte Versandzonen');
define('MODULE_SHIPPING_FREEAMOUNT_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, in welche ein Versand möglich sein soll. (z.B. AT,DE (lassen Sie dieses Feld leer, wenn Sie alle Zonen erlauben wollen))');
define('MODULE_SHIPPING_FREECOUNT_STATUS_TITLE' , 'Versandkostenfreie Lieferung aktivieren');
define('MODULE_SHIPPING_FREECOUNT_STATUS_DESC' , 'Möchten Sie Versandkostenfreie Lieferung anbieten?');
define('MODULE_SHIPPING_FREECOUNT_DISPLAY_TITLE' , 'Anzeige aktivieren');
define('MODULE_SHIPPING_FREECOUNT_DISPLAY_DESC' , 'Möchten Sie anzeigen, wenn der Mindestbetrag zur VK-freien Lieferung nicht erreicht ist?');
define('MODULE_SHIPPING_FREECOUNT_AMOUNT_TITLE' , 'Mindestbestellwert (National, International)');
define('MODULE_SHIPPING_FREECOUNT_AMOUNT_DESC' , 'Mindestbestellwert, damit der Versand kostenlos ist? (National, International)');
define('MODULE_SHIPPING_FREECOUNT_SORT_ORDER_TITLE' , 'Sortierreihenfolge');
define('MODULE_SHIPPING_FREECOUNT_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige');
?>