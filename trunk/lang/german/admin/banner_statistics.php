<?php
/* --------------------------------------------------------------
   $Id: banner_statistics.php,v 2.0.0 2006/12/14 05:49:15 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner_statistics.php,v 1.3 2003/02/16); www.oscommerce.com 
   (c) 2003	    nextcommerce (banner_statistics.php,v 1.4 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Bannerstatistik');

define('TABLE_HEADING_SOURCE', 'Grundlage');
define('TABLE_HEADING_VIEWS', 'Anzeigen');
define('TABLE_HEADING_CLICKS', 'Klicks');

define('TEXT_BANNERS_DATA', 'D<br/>A<br/>T<br/>E<br/>N');
define('TEXT_BANNERS_DAILY_STATISTICS', '%s Tagesstatistik für %s %s');
define('TEXT_BANNERS_MONTHLY_STATISTICS', '%s Monatsstatistik für %s');
define('TEXT_BANNERS_YEARLY_STATISTICS', '%s Jahresstatistik');

define('STATISTICS_TYPE_DAILY', 'täglich');
define('STATISTICS_TYPE_MONTHLY', 'monatlich');
define('STATISTICS_TYPE_YEARLY', 'jährlich');

define('TITLE_TYPE', 'Typ:');
define('TITLE_YEAR', 'Jahr:');
define('TITLE_MONTH', 'Monat:');

define('ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST', 'Fehler: Das Verzeichnis \'graphs\' ist nicht vorhanden! Bitte erstellen Sie ein Verzeichnis \'graphs\' im Verzeichnis \'images\'.');
define('ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE', 'Fehler: Das Verzeichnis \'graphs\' ist schreibgeschützt!');
?>