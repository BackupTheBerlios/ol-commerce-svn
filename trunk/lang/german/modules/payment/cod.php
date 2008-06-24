<?php
/* -----------------------------------------------------------------------------------------
$Id: cod.php,v 2.0.0 2006/12/14 05:49:36 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(cod.php,v 1.7 2002/04/17); www.oscommerce.com
(c) 2003	    nextcommerce (cod.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
define('MODULE_PAYMENT_TYPE_PERMISSION', 'cod');
define('MODULE_PAYMENT_COD_TEXT_TITLE', 'Nachnahme');
define('MODULE_PAYMENT_COD_TEXT_DESCRIPTION', 'Nachnahme');
define('MODULE_PAYMENT_COD_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_COD_ZONE_DESC' , 'Wenn eine Zone ausgewählt ist, gilt die Zahlungsmethode nur für diese Zone.');
define('MODULE_PAYMENT_COD_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_COD_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche für dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_COD_STATUS_TITLE' , 'Nachnahme Modul aktivieren');
define('MODULE_PAYMENT_COD_STATUS_DESC' , 'Möchten Sie Zahlungen per Nachnahme akzeptieren?');
define('MODULE_PAYMENT_COD_SORT_ORDER_TITLE' , 'Anzeigereihenfolge');
define('MODULE_PAYMENT_COD_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_COD_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_COD_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
?>