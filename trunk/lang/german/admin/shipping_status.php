<?php
/* --------------------------------------------------------------
   $Id: shipping_status.php,v 2.0.0 2006/12/14 05:49:25 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders_status.php,v 1.7 2002/01/30); www.oscommerce.com 
   (c) 2003	    nextcommerce (orders_status.php,v 1.4 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Lieferstatus');

define('TABLE_HEADING_SHIPPING_STATUS', 'Lieferstatus');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_INFO_EDIT_INTRO', 'Bitte führen Sie notwendige änderungen durch');
define('TEXT_INFO_SHIPPING_STATUS_NAME', 'Lieferstatus:');
define('TEXT_INFO_INSERT_INTRO', 'Bitte geben Sie den neuen Lieferstatus mit allen relevanten Daten ein');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, dass Sie diesen Lieferstatus löschen möchten?');
define('TEXT_INFO_HEADING_NEW_SHIPPING_STATUS', 'Neuer Lieferstatus');
define('TEXT_INFO_HEADING_EDIT_SHIPPING_STATUS', 'Lieferstatus bearbeiten');
define('TEXT_INFO_SHIPPING_STATUS_IMAGE', 'Bild:');
define('TEXT_INFO_HEADING_DELETE_SHIPPING_STATUS', 'Lieferstatus löschen');

define('ERROR_REMOVE_DEFAULT_SHIPPING_STATUS', 'Fehler: Der Standard-Lieferstatus kann nicht gelöscht werden. Bitte definieren Sie einen neuen Standard-Lieferstatus und wiederholen Sie den Vorgang.');
define('ERROR_STATUS_USED_IN_ORDERS', 'Fehler: Dieser Lieferstatus wird zur Zeit noch für Produkte verwendet.');
define('ERROR_STATUS_USED_IN_HISTORY', 'Fehler: Dieser Lieferstatus wird zur Zeit noch für Produkte verwendet.');
?>