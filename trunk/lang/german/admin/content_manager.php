<?php
/* --------------------------------------------------------------
   $Id: content_manager.php,v 2.0.0 2006/12/14 05:49:19 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on:
   (c) 2003	    nextcommerce (content_manager.php,v 1.8 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/
   
 define('HEADING_TITLE','Content Manager');
 define('HEADING_CONTENT','Seiten Content');
 define('HEADING_PRODUCTS_CONTENT','Artikel Content');
 define('TABLE_HEADING_CONTENT_ID','Link id');
 define('TABLE_HEADING_CONTENT_TITLE','Titel');
 define('TABLE_HEADING_CONTENT_FILE','Datei');
 define('TABLE_HEADING_CONTENT_STATUS','In Box sichtbar');
 define('TABLE_HEADING_CONTENT_BOX','Box');
 define('TABLE_HEADING_PRODUCTS_ID','id');
 define('TABLE_HEADING_PRODUCTS','Artikel');
 define('TABLE_HEADING_PRODUCTS_CONTENT_ID','id');
 define('TABLE_HEADING_LANGUAGE','Sprache');
 define('TABLE_HEADING_CONTENT_NAME','Name/Dateiname');
 define('TABLE_HEADING_CONTENT_LINK','Link');
 define('TABLE_HEADING_CONTENT_HITS','Hits');
 define('TABLE_HEADING_CONTENT_GROUP','Gruppe');
 define('TEXT_YES','Ja');
 define('TEXT_NO','Nein');
 define('TABLE_HEADING_CONTENT_ACTION','Aktion');
 define('TEXT_DELETE','Löschen');
 define('TEXT_EDIT','Bearbeiten');
 define('TEXT_PREVIEW','Vorschau');
 define('CONFIRM_DELETE','Wollen Sie den Content wirklich löschen ?');
 define('CONTENT_NOTE','Content markiert mit <font color="ff0000">*</font> gehört zum System und kann nicht gelöscht werden!');

 
 // edit
 define('TEXT_LANGUAGE','Sprache:');
 define('TEXT_STATUS','Sichtbar:');
 define('TEXT_STATUS_DESCRIPTION','Wenn ausgewählt, wird ein Link in der Info Box angezeigt');
 define('TEXT_TITLE','Titel:');
 define('TEXT_TITLE_FILE','Titel/Dateiname:');
 define('TEXT_SELECT','-Bitte wählen-');
 define('TEXT_HEADING','überschrift:');
 define('TEXT_CONTENT','Text:');
 define('TEXT_UPLOAD_FILE','Datei Hochladen:');
 define('TEXT_UPLOAD_FILE_LOCAL','(von Ihrem lokalen System)');
 define('TEXT_CHOOSE_FILE','Datei Wählen:');
 define('TEXT_CHOOSE_FILE_DESC','Sie können ebenfals eine Bereits verwendete Datei aus der Liste auswählen.');
 define('TEXT_NO_FILE','Auswahl Löschen');
 define('TEXT_CHOOSE_FILE_SERVER','(Falls Sie ihre Dateien selbst via FTP auf ihren Server gespeichert haben <i>(media/content)</i>, können Sie hier die Datei auswählen.');
 define('TEXT_CURRENT_FILE','Aktuelle Datei:');
 define('TEXT_FILE_DESCRIPTION','<b>Info:</b><br/>Sie haben ebenfalls die Möglichkeit eine <b>.htlm</b> oder <b>.htm</b> Datei als Content einzubinden.<br/> Falls Sie eine Datei auswählen oder hochladen, wird der Text im Textfeld ignoriert.<br/><br/>');
 define('ERROR_FILE','Falsches Dateiformat (nur .html od .htm)');
 define('ERROR_TITLE','Bitte geben Sie einen Titel ein');
 define('ERROR_COMMENT','Bitte geben Sie eine Dateibeschreibung ein!');
 define('TEXT_FILE_FLAG','Box:');
 define('TEXT_PARENT','Hauptdokument:');
 define('TEXT_PARENT_DESCRIPTION','Diesem Dokument zuweisen');
 define('TEXT_PRODUCT','Artikel:');
 define('TEXT_LINK','Link:');
 define('TEXT_GROUP','Sprachgruppe:');
 define('TEXT_GROUP_DESC','Mit dieser id verknüpfen sie gleiche Themen unterschiedlicher Sprachen miteinander.');
 
 define('TEXT_CONTENT_DESCRIPTION','Mit diesem Content Manager haben Sie die Möglichkeit, jeden beliebige Dateityp einem Produkt hinzuzufügen.<br/>Zb. Produktbeschreibungen, Handbücher, technische Datenblätter, Hörproben, usw...<br/>Diese Elemente werden In der Produkt Detailansicht angezeigt.<br/><br/>');
 define('TEXT_FILENAME','Benutze Datei:');
 define('TEXT_FILE_DESC','Beschreibung:');
 define('USED_SPACE','Verwendeter Speicherplatz:');
 define('TABLE_HEADING_CONTENT_FILESIZE','Dateigröße');
   
 
 ?>