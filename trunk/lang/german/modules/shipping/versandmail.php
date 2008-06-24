<?PHP
/* -----------------------------------------------------------------------------------------
$Id: versandmail.php,v 2.0.0 2006/12/14 05:49:45 gswkaiser Exp $

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
versandmail         	Autor:	M. Tomanik

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_VERSANDMAIL_TEXT_TITLE', 'Versand nach Mail');
define('MODULE_SHIPPING_VERSANDMAIL_TEXT_DESCRIPTION',
'Versandkosten richten sich nach Grösse und Gewicht. Diese werden Ihnen gesondert per eMail mitgeteilt');
define('MODULE_SHIPPING_VERSANDMAIL_SORT_ORDER', 'Sortierung');

define('MODULE_SHIPPING_VERSANDMAIL_TEXT_WAY', MODULE_SHIPPING_VERSANDMAIL_TEXT_DESCRIPTION);
define('MODULE_SHIPPING_VERSANDMAIL_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_SHIPPING_VERSANDMAIL_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, in welche ein Versand möglich sein soll. (z.B. AT,DE (lassen Sie dieses Feld leer, wenn Sie alle Zonen erlauben wollen))');
define('MODULE_SHIPPING_VERSANDMAIL_STATUS_TITLE', 'Versand nach Mail');
define('MODULE_SHIPPING_VERSANDMAIL_STATUS_DESC', 'Versandkosten per anbieten?');
define('MODULE_SHIPPING_VERSANDMAIL_SORT_ORDER_TITLE', 'Sortierreihenfolge');
define('MODULE_SHIPPING_VERSANDMAIL_SORT_ORDER_DESC', 'Reihenfolge der Anzeige');
?>