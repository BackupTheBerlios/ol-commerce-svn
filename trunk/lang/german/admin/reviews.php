<?php
/* --------------------------------------------------------------
   $Id: reviews.php,v 2.0.0 2006/12/14 05:49:25 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(reviews.php,v 1.6 2002/02/06); www.oscommerce.com
   (c) 2003	    nextcommerce (reviews.php,v 1.4 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Produktbewertungen');

define('TABLE_HEADING_PRODUCTS', 'Artikel');
define('TABLE_HEADING_RATING', 'Bewertung');
define('TABLE_HEADING_DATE_ADDED', 'Hinzugefügt am');
define('TABLE_HEADING_ACTION', 'Aktion');

define('ENTRY_PRODUCT', 'Artikel: ');
define('ENTRY_FROM', 'Von: ');
define('ENTRY_DATE', 'Datum: ');
define('ENTRY_REVIEW', 'Bewertung:' );
define('ENTRY_REVIEW_TEXT', '<small><font color="#ff0000"><b>HINWEIS:</b></font></small>&nbsp;HTML wird nicht konvertiert!&nbsp;');
define('ENTRY_RATING', ENTRY_REVIEW);

define('TEXT_INFO_DELETE_REVIEW_INTRO', 'Sind Sie sicher, dass Sie diese Bewertung löschen möchten?');

define('TEXT_INFO_DATE_ADDED', 'hinzugefügt am: ');
define('TEXT_INFO_LAST_MODIFIED', 'Letzte Änderung: ');
define('TEXT_INFO_IMAGE_NONEXISTENT', 'BILD EXISTIERT NICHT');
define('TEXT_INFO_REVIEW_AUTHOR', 'Geschrieben von: ');
define('TEXT_INFO_REVIEW_RATING', ENTRY_REVIEW);
define('TEXT_INFO_REVIEW_READ', 'Gelesen: ');
define('TEXT_INFO_REVIEW_SIZE', 'Grösse: ');
define('TEXT_INFO_PRODUCTS_AVERAGE_RATING', 'Surchschnittl. Wertung: ');

define('TEXT_OF_5_STARS', '%s von 5 Sternen!');
define('TEXT_GOOD', '<small><font color="#ff0000"><b>SEHR GUT</b></font></small>');
define('TEXT_BAD', '<small><font color="#ff0000"><b>SCHLECHT</b></font></small>');
define('TEXT_INFO_HEADING_DELETE_REVIEW', 'Bewertung löschen');
?>