<?php
/* --------------------------------------------------------------
   $Id: tax_rates.php,v 2.0.0 2006/12/14 05:49:25 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(tax_rates.php,v 1.9 2003/03/13); www.oscommerce.com 
   (c) 2003	    nextcommerce (tax_rates.php,v 1.4 2003/08/1); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Steuersätze');

define('TABLE_HEADING_TAX_RATE_PRIORITY', 'Priorität');
define('TABLE_HEADING_TAX_CLASS_TITLE', 'Steuerklasse');
define('TABLE_HEADING_COUNTRIES_NAME', 'Land');
define('TABLE_HEADING_ZONE', 'Steuerzone');
define('TABLE_HEADING_TAX_RATE', 'Steuersatz');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_INFO_EDIT_INTRO', 'Bitte führen Sie alle notwendigen Änderungen durch');
define('TEXT_INFO_DATE_ADDED', 'hinzugefügt am:');
define('TEXT_INFO_LAST_MODIFIED', 'Letzte Änderung:');
define('TEXT_INFO_CLASS_TITLE', 'Name der Steuerklasse:');
define('TEXT_INFO_COUNTRY_NAME', 'Land:');
define('TEXT_INFO_ZONE_NAME', 'Steuerzone:');
define('TEXT_INFO_TAX_RATE', 'Steuersatz (%):');
define('TEXT_INFO_TAX_RATE_PRIORITY', 'Steuersätze der selben Priorität werden addiert, andere werden vermischt.<br/><br/>Priorität:');
define('TEXT_INFO_RATE_DESCRIPTION', 'Beschreibung:');
define('TEXT_INFO_INSERT_INTRO', 'Bitte geben Sie den neuen Steuersatz mit allen relevanten Daten ein');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, dass Sie diesen Steuersatz löschen möchten?');
define('TEXT_INFO_HEADING_NEW_TAX_RATE', 'Neuer Steuersatz');
define('TEXT_INFO_HEADING_EDIT_TAX_RATE', 'Steuersatz bearbeiten');
define('TEXT_INFO_HEADING_DELETE_TAX_RATE', 'Steuersatz löschen');
?>