<?php
/* --------------------------------------------------------------
   $Id: manufacturers.php,v 2.0.0 2006/12/14 05:49:23 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(manufacturers.php,v 1.14 2003/02/16); www.oscommerce.com 
   (c) 2003	    nextcommerce (manufacturers.php,v 1.4 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Hersteller');

define('TABLE_HEADING_MANUFACTURERS', 'Hersteller');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_HEADING_NEW_MANUFACTURER', 'Neuer Hersteller');
define('TEXT_HEADING_EDIT_MANUFACTURER', 'Hersteller bearbeiten');
define('TEXT_HEADING_DELETE_MANUFACTURER', 'Hersteller l�schen');

define('TEXT_MANUFACTURERS', 'Hersteller:');
define('TEXT_DATE_ADDED', 'Hinzugef�gt am:');
define('TEXT_LAST_MODIFIED', 'Letzte �nderung am:');
define('TEXT_PRODUCTS', 'Artikel:');
define('TEXT_IMAGE_NONEXISTENT', 'BILD NICHT VORHANDEN');

define('TEXT_NEW_INTRO', 'Bitte geben Sie den neuen Hersteller mit allen relevanten Daten ein.');
define('TEXT_EDIT_INTRO', 'Bitte f�hren Sie alle notwendigen �nderungen durch');

define('TEXT_MANUFACTURERS_NAME', 'Herstellername:');
define('TEXT_MANUFACTURERS_IMAGE', 'Herstellerbild:');
define('TEXT_MANUFACTURERS_URL', 'Hersteller URL:');

define('TEXT_DELETE_INTRO', 'Sind Sie sicher, dass Sie diesen Hersteller l�schen m�chten?');
define('TEXT_DELETE_IMAGE', 'Hersteller Image l�schen?');
define('TEXT_DELETE_PRODUCTS', 'Alle Artikel von diesem Hersteller l�schen? (inkl. Bewertungen, Angebote und Neuerscheinungen)');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>WARNUNG:</b> Es existieren noch %s Artikel, welche mit diesem Hersteller verbunden sind!');

define('ERROR_DIRECTORY_NOT_WRITEABLE', 'Fehler: Das Verzeichnis %s ist schreibgesch�tzt. Bitte korrigieren Sie die Zugriffsrechte zu diesem Verzeichnis!');
define('ERROR_DIRECTORY_DOES_NOT_EXIST', 'Fehler: Das Verzeichnis %s existiert nicht!');
?>