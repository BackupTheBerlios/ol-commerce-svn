<?php
/* -----------------------------------------------------------------------------------------
$Id: ot_cod_fee.php,v 2.0.0 2006/12/14 05:49:33 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(ot_cod_fee.php,v 1.02 2003/02/24); www.oscommerce.com
(C) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers ; http://www.themedia.at & http://www.oscommerce.at
Copyright (c) 2004 Manfred Tomanik http://www.st-computer.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

define('MODULE_ORDER_TOTAL_COD_TITLE', 'Nachnahmegebühr');
define('MODULE_ORDER_TOTAL_COD_DESCRIPTION', 'Berechnung der Nachnahmegebühr');

define('MODULE_ORDER_TOTAL_COD_STATUS_TITLE','Nachnahmegebühr');
define('MODULE_ORDER_TOTAL_COD_STATUS_DESC','Berechnung der Nachnahmegebühr');

define('MODULE_ORDER_TOTAL_COD_SORT_ORDER_TITLE','Sortierreihenfolge');
define('MODULE_ORDER_TOTAL_COD_SORT_ORDER_DESC','Anzeigereihenfolge');

define('MODULE_ORDER_TOTAL_COD_FEE_FLAT_TITLE','Pauschale Versandkosten');
define('MODULE_ORDER_TOTAL_COD_FEE_FLAT_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br/>
  00 als ISO2-Code ermöglicht den Nachnahmeversand in alle Länder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht möglich).');

define('MODULE_ORDER_TOTAL_COD_FEE_ITEM_TITLE','Versandkosten pro Stück');
define('MODULE_ORDER_TOTAL_COD_FEE_ITEM_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br/>
  00 als ISO2-Code ermöglicht den Nachnahmeversand in alle Länder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht möglich).');

define('MODULE_ORDER_TOTAL_COD_FEE_TABLE_TITLE','Tabellarische Versandkosten');
define('MODULE_ORDER_TOTAL_COD_FEE_TABLE_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br/>
  00 als ISO2-Code ermöglicht den Nachnahmeversand in alle Länder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht möglich).');

define('MODULE_ORDER_TOTAL_COD_FEE_ZONES_TITLE','Versandkosten nach Zonen');
define('MODULE_ORDER_TOTAL_COD_FEE_ZONES_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br/>
  00 als ISO2-Code ermöglicht den Nachnahmeversand in alle Länder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht möglich).');

define('MODULE_ORDER_TOTAL_COD_FEE_AP_TITLE','österreichische Post AG');
define('MODULE_ORDER_TOTAL_COD_FEE_AP_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br/>
  00 als ISO2-Code ermöglicht den Nachnahmeversand in alle Länder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht möglich).');

define('MODULE_ORDER_TOTAL_COD_FEE_DP_TITLE','Deutsche Post AG');
define('MODULE_ORDER_TOTAL_COD_FEE_DP_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br/>
  00 als ISO2-Code ermöglicht den Nachnahmeversand in alle Länder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht möglich).');

define('MODULE_ORDER_TOTAL_COD_FEE_DPD_TITLE','DPD');
define('MODULE_ORDER_TOTAL_COD_FEE_DPD_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br/>
  00 als ISO2-Code ermöglicht den Nachnahmeversand in alle Länder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht möglich).');

define('MODULE_ORDER_TOTAL_COD_FEE_UPS_TITLE','UPS Standard');
define('MODULE_ORDER_TOTAL_COD_FEE_UPS_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br/>
  00 als ISO2-Code ermöglicht den Nachnahmeversand in alle Länder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht möglich).');

define('MODULE_ORDER_TOTAL_COD_FEE_UPSE_TITLE','UPS Express');
define('MODULE_ORDER_TOTAL_COD_FEE_UPSE_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br/>
  00 als ISO2-Code ermöglicht den Nachnahmeversand in alle Länder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht möglich).');

define('MODULE_ORDER_TOTAL_COD_FEE_FREEAMOUNTAUSL_TITLE','Versandkostenfrei Ausland');
define('MODULE_ORDER_TOTAL_COD_FEE_FREEAMOUNTAUSL_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br/>
  00 als ISO2-Code ermöglicht den Nachnahmeversand in alle Länder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht möglich).');

define('MODULE_ORDER_TOTAL_COD_FEE_FREEAMOUNT_TITLE','Versandkostenfrei Inland');
define('MODULE_ORDER_TOTAL_COD_FEE_FREEAMOUNT_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br/>
  00 als ISO2-Code ermöglicht den Nachnahmeversand in alle Länder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht möglich).');

define('MODULE_ORDER_TOTAL_COD_TAX_CLASS_TITLE','Steuerklasse');
define('MODULE_ORDER_TOTAL_COD_TAX_CLASS_DESC','Wählen Sie eine Steuerklasse.');
?>
