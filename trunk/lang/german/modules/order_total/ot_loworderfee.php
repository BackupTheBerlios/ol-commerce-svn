<?php
/* -----------------------------------------------------------------------------------------
$Id: ot_loworderfee.php,v 2.0.0 2006/12/14 05:49:34 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(ot_loworderfee.php,v 1.2 2002/04/17); www.oscommerce.com
(c) 2003	    nextcommerce (ot_loworderfee.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

define('MODULE_ORDER_TOTAL_LOWORDERFEE_TITLE', 'Mindermengenzuschlag');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_TITLE_EXTENDED', 'Mindermengenzuschlag (bis %s)');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_DESCRIPTION', 'Zuschlag bei Unterschreitung des Mindestbestellwertes');

define('MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS_TITLE','Mindermengenzuschlag anzeigen');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS_DESC','Möchten Sie sich den Mindermengenzuschlag ansehen?');

define('MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER_TITLE','Sortierreihenfolge');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER_DESC','Anzeigereihenfolge.');

define('MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE_TITLE','Mindermengenzuschlag erlauben');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE_DESC','Möchten Sie Mindermengenzuschläge erlauben?');

define('MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER_TITLE','Mindermengenzuschlag für Bestellungen unter');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER_DESC','Mindermengenzuschlag wird für Bestellungen unter diesem Wert hinzugefügt.');

define('MODULE_ORDER_TOTAL_LOWORDERFEE_FEE_TITLE','Zuschlag');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_FEE_DESC','Mindermengenzuschlag.');

define('MODULE_ORDER_TOTAL_LOWORDERFEE_DESTINATION_TITLE','Mindestmengenzuschlag nach Zonen berechnen');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_DESTINATION_DESC','Mindestmengenzuschlag für Bestellungen, die an diesen Ort versandt werden.');

define('MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS_TITLE','Steuerklasse');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS_DESC','Folgende Steuerklasse für den Mindermengenzuschlag verwenden.');
?>