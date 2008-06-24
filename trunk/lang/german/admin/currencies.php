<?php
/* --------------------------------------------------------------
   $Id: currencies.php,v 2.0.0 2006/12/14 05:49:20 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(currencies.php,v 1.15 2003/05/02); www.oscommerce.com 
   (c) 2003	    nextcommerce (currencies.php,v 1.4 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/
   
define('HEADING_TITLE', 'W�hrungen');

define('TABLE_HEADING_CURRENCY_NAME', 'W�hrung');
define('TABLE_HEADING_CURRENCY_CODES', 'K�rzel');
define('TABLE_HEADING_CURRENCY_VALUE', 'Wert');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_INFO_EDIT_INTRO', 'Bitte f�hren Sie alle notwendigen �nderungen durch');
define('TEXT_INFO_CURRENCY_TITLE', 'Name:');
define('TEXT_INFO_CURRENCY_CODE', 'K�rzel:');
define('TEXT_INFO_CURRENCY_SYMBOL_LEFT', 'Symbol Links:');
define('TEXT_INFO_CURRENCY_SYMBOL_RIGHT', 'Symbol Rechts:');
define('TEXT_INFO_CURRENCY_DECIMAL_POINT', 'Dezimalkomma:');
define('TEXT_INFO_CURRENCY_THOUSANDS_POINT', 'Tausenderpunkt:');
define('TEXT_INFO_CURRENCY_DECIMAL_PLACES', 'Dezimalstellen:');
define('TEXT_INFO_CURRENCY_LAST_UPDATED', 'Letzte �nderung:');
define('TEXT_INFO_CURRENCY_VALUE', 'Wert:');
define('TEXT_INFO_CURRENCY_EXAMPLE', 'Beispiel:');
define('TEXT_INFO_INSERT_INTRO', 'Bitte geben Sie die neue W�hrung mit allen relevanten Daten ein');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, dass Sie diese W�hrung l�schen m�chten?');
define('TEXT_INFO_HEADING_NEW_CURRENCY', 'Neue W�hrung');
define('TEXT_INFO_HEADING_EDIT_CURRENCY', 'W�hrung bearbeiten');
define('TEXT_INFO_HEADING_DELETE_CURRENCY', 'W�hrung l�schen');
define('TEXT_INFO_SET_AS_DEFAULT', TEXT_SET_DEFAULT . ' (manuelles Aktualisieren der Wechselkurse erforderlich.)');
define('TEXT_INFO_CURRENCY_UPDATED', 'Der Wechselkurs %s (%s) wurde erfolgreich aktualisiert');

define('ERROR_REMOVE_DEFAULT_CURRENCY', 'Fehler: Die Standardw�hrung darf nicht gel�scht werden. Bitte definieren Sie eine neue Standardw�hrung und wiederholen Sie den Vorgang.');
define('ERROR_CURRENCY_INVALID', 'Fehler: Der Wechselkurs f�r %s (%s) wurde nicht aktualisiert. Ist dies ein g�ltiges W�hrungsk�rzel?');
?>