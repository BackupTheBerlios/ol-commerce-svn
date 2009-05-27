<?php
/* --------------------------------------------------------------
$Id: import_export_customer.php,v 2.0.0 2006/12/14 05:49:23 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(index.php,v 1.5 2002/03/30); www.oscommerce.com
(c) 2003	    nextcommerce (index.php,v 1.5 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

$s='Kunden-Daten ';
define('IMPORT_EXPORT_TITLE',$s.'Import/Export');
define('IMPORT',$s.'Import');
define('EXPORT',$s.'Export');
define('UPLOAD','Datei auf Server laden');
define('SELECT_FILE','Zu importierende Datei auswählen');
define('SELECT_MAP','Feldzuordnungs-Datei auswählen');
define('SAVE','Auf Server speichern (/export Verzeichnis)');
define('LOAD','Datei an Browser senden');
define('CSV_TEXTSIGN_TITLE','Text-Erkennungszeichen');
define('CSV_TEXTSIGN_DESC','Das Zeichen, mit dem Textfelder im CSV-Satz abgeschlossen werden (z.B. ")');
define('CSV_SEPERATOR_TITLE','Feld-Trennzeichen');
define('CSV_SEPERATOR_DESC','Das Zeichen, mit dem Felder im CSV-Satz getrennt werden (z.B. ; oder "Tabulator"');
define('COMPRESS_EXPORT_TITLE','Kompression');
define('COMPRESS_EXPORT_DESC','Kompression der exportierten Daten');
define('CSV_SETUP','Einstellungen');
define('TEXT_IMPORT','Import von Daten im CSV-Format');
define('TEXT_EXPORT','Exportierte Datei wird im "/export" Verzeichnis gespeichert');
define('TEXT_NO_VALID_SEPARATOR','Kein zulässiges Feld-Trennzeichen');
define('TEXT_ERROR','<b>FEHLER:</b> %s, Zeile: %s<br>');
define('TEXT_IMPORTFILE_REQUIRED','Sie müssen eine Import-Datei auswählen');
define('TEXT_IMPORTFILE_CSV','Die Import-Datei muss die Endung ".csv" haben');
define('TEXT_SEND_EMAIL','eMail mit Zugangsdaten an Kunden senden');
define('BUTTON_IMPORT','Importieren');
define('BUTTON_EXPORT','Exportieren');
define('BUTTON_SAVE','Speichern');
define('TEXT_ERROR_FILE','Fehler in Import-Datei "%s": %s');
define('EMAIL_ALREADY_USED','Verwendet in Zeile(n): ');
define('TEXT_FILE_NO_DATA','Keine Daten');
define('TEXT_FILE_ERROR_OPEN','Kann nicht geöffnet werden');
define('TEXT_MAIL_SUBJECT','Unser neuer Onlineshop');

define('TEXT_EXECUTION_TIME','Ausführungszeit: ');
define('TEXT_EXECUTION_TIME_HOUR',' Std. ');
define('TEXT_EXECUTION_TIME_MINUTE',' Min. ');
define('TEXT_EXECUTION_TIME_SECOND',' Sek.');

define('TEXT_RESULT_P_NEW','Neue Kunden');
define('TEXT_RESULT_P_EXPORTED','Exportierte Kunden');
?>