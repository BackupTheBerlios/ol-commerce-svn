<?PHP
/* -----------------------------------------------------------------------------------------
   $Id: selfpickup.php,v 2.0.0 2006/12/14 05:49:44 gswkaiser Exp $

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
   selfpickup         	Autor:	sebthom
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_SELFPICKUP_TEXT_TITLE', 'Versandkosten');
define('MODULE_SHIPPING_SELFPICKUP_TEXT_DESCRIPTION', 'Selbstabholung der Ware in unserer Geschäftsstelle');
define('MODULE_SHIPPING_SELFPICKUP_SORT_ORDER', 'Sortierung');

define('MODULE_SHIPPING_SELFPICKUP_TEXT_WAY', MODULE_SHIPPING_SELFPICKUP_TEXT_DESCRIPTION);
define('MODULE_SHIPPING_SELFPICKUP_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_SHIPPING_SELFPICKUP_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, in welche ein Versand möglich sein soll. (z.B. AT,DE (lassen Sie dieses Feld leer, wenn Sie alle Zonen erlauben wollen))');
define('MODULE_SHIPPING_SELFPICKUP_STATUS_TITLE', 'Selbstabholung aktivieren');
define('MODULE_SHIPPING_SELFPICKUP_STATUS_DESC', 'Möchten Sie Selbstabholung anbieten?');
define('MODULE_SHIPPING_SELFPICKUP_SORT_ORDER_TITLE', 'Sortierreihenfolge');
define('MODULE_SHIPPING_SELFPICKUP_SORT_ORDER_DESC', 'Reihenfolge der Anzeige');
?>