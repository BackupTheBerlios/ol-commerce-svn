<?php
/* --------------------------------------------------------------
$Id: german.php,v 1.1.1.1.2.1 2007/04/08 07:18:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2003 OL-Commerce (german.php,v 1.8 2003/08/13); www.OL-Commerce.de
(c) 2004 XT - Commerce; www.ol-Commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/
// Global
define('TEXT_FOOTER','Copyright &copy; 2002-'.date('Y').' <a href="http://www.ol-Commerce.com/v5">OL-Commerce</a><br/>Powered by OL-Commerce v5/AJAX');

// Box names
define('BOX_LANGUAGE','System-Überprüfung und Sprachwahl');
define('BOX_WEBSERVER_SETTINGS','Webserver-Einstellungen');
define('BOX_DB_CONNECTION','Datenbank- und '.BOX_WEBSERVER_SETTINGS) ;
define('BOX_DB_IMPORT','Import der grundlegenden Shop-Daten');
define('BOX_DB_IMPORT_SUCCESS','Datenbank-Import war erfolgreich');
define('BOX_WRITE_CONFIG','Erstellen der Konfigurationsdatei');
$configuration='-Konfiguration';
define('BOX_SHOP_CONFIG','Allgemeine Shop'.$configuration);
define('BOX_ADMIN_CONFIG','Administratoren'.$configuration);
define('BOX_USERS_CONFIG','Besucher'.$configuration);
define('BOX_FINISHED','Installation beendet');

define('PULL_DOWN_ Standard','Bitte Wählen Sie ein Land');

// Error messages
// index.php
define('TITLE_SELECT_LANGUAGE','Bitte wählen Sie eine Sprache!<br/>Please select a language');
define('SELECT_LANGUAGE_ERROR',TITLE_SELECT_LANGUAGE);
// install_step2,5.php
define('TEXT_CONNECTION_ERROR','Eine Testverbindung zur Datenbank war nicht erfolgreich.');
define('TEXT_CONNECTION_SUCCESS','Eine Testverbindung zur Datenbank war erfolgreich.');
define('TEXT_DB_ERROR','Folgender Fehler wurde zurückgegeben: ');
define('TEXT_DB_ERROR_1','Bitte klicken Sie auf <i>Zurück</i> um Ihre Datenbankeinstellungen zu überprüfen.');
define('TEXT_DB_ERROR_2','Wenn Sie Hilfe zu Ihrer Datenbank benötigen, wenden Sie sich bitte an Ihren Provider.');
// install_step6.php
$too_short='\' ist zu kurz';
define('ENTRY_FIRST_NAME_ERROR','\'Vorname'.$too_short);
define('ENTRY_LAST_NAME_ERROR','\'Nachname'.$too_short);
define('ENTRY_EMAIL_ADDRESS_ERROR','\'eMail-Adresse'.$too_short);
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR','\'Bitte überprüfen Sie Ihre eMail-Adresse');
define('ENTRY_STREET_ADDRESS_ERROR','\'Straße'.$too_short);
define('ENTRY_POST_CODE_ERROR','\'Postleitzahl'.$too_short);
define('ENTRY_CITY_ERROR','\'Stadt'.$too_short);
define('ENTRY_COUNTRY_ERROR','\'Bitte überprüfen Sie das Bundesland');
define('ENTRY_STATE_ERROR','\'Bitte überprüfen Sie das Land');
define('ENTRY_TELEPHONE_NUMBER_ERROR','\'Telefonnummer'.$too_short);
define('ENTRY_PASSWORD_ERROR','Bitte überprüfen Sie das Passwort');
define('ENTRY_STORE_NAME_ERROR','\'Shop-Name'.$too_short);
define('ENTRY_COMPANY_ERROR','\'Firmenname'.$too_short);
define('ENTRY_EMAIL_ADDRESS_FROM_ERROR','\'eMail-von'.$too_short);
define('ENTRY_EMAIL_ADDRESS_FROM_CHECK_ERROR','\'Bitte überprüfen Sie \'eMail von\'');
define('SELECT_ZONE_SETUP_ERROR','\'Wählen Sie Zone-Setup');
// install_step7.php
define('ENTRY_DISCOUNT_ERROR','Produkt-Rabatt (Gast)');
define('ENTRY_OT_DISCOUNT_ERROR','Rabatt zulassen (Gast)');
define('SELECT_OT_DISCOUNT_ERROR',ENTRY_OT_DISCOUNT_ERROR);
define('SELECT_GRADUATED_ERROR','Preisstaffel (Gast)');
define('SELECT_PRICE_ERROR','Preise anzeigen (Gast)');
define('SELECT_TAX_ERROR','Steuer anzeigen (Gast)');
define('ENTRY_DISCOUNT_ERROR2','Produkt-Rabattt (Standard)');
define('ENTRY_OT_DISCOUNT_ERROR2','Rabatt zulassen (Standard)');
define('SELECT_OT_DISCOUNT_ERROR2',ENTRY_OT_DISCOUNT_ERROR2);
define('SELECT_GRADUATED_ERROR2','Preisstaffel (Standard)');
define('SELECT_PRICE_ERROR2','Preise anzeigen (Standard)');
define('SELECT_TAX_ERROR2','Steuer anzeigen (Standard)');

// index.php

define('TEXT_ZONE','Automatisches Einstellen der Steuerzonen');
define('TEXT_WELCOME_STEP1','
<div class="title">Willkommen zu<br/>OL-Commerce v5/AJAX</div>
<div>
<p>
<b>OL-Commerce</b> ist eine Open-Source e-Commerce Anwendung, die vollständig
auf die <b>
<a target="_blank" href="http://de.wikipedia.org/wiki/Ajax_(Programmierung)">
AJAX-Technologie</a></b> setzt, und dem Käufer somit eine attraktive <b>&quot;Web
2.0&quot;-Benutzerschnittstelle</b> bietet, die ein ganz neues Einkaufserlebnis
vermittelt.</p>
<p>Daneben bietet sie eine <b><a target="_blank" href="documentation/OL-Commerce_v5_ajax.html">
Vielzahl von neuen Funktionen</a></b>, die man in Open-Source-Systemen dieser
Klasse sonst nicht findet.<br/>
(Einen Überblick darüber finden Sie <b>
<a target="_blank" href="documentation/OL-Commerce_v5_ajax.html">hier</a></b>!)</p>
<p>Seine "out-of-the-box&quot; Installation erlaubt es dem Shop-Besitzer, seinen Online-Shop mit einem Minimum an Aufwand und Kosten zu installieren, zu betreiben und zu verwalten.
Durch die Verwendung der &quot;<b>Smarty&quot;-Template-Engine</b> und &quot;<b>CSS-Stylessheets</b>&quot;
ist das Shop-Design einfach den persönlichen Vorstellungen anpassbar. Selbst das
Layout des Shop-Bildschirms ist über <b>&quot;Drag- and Drop&quot;(!)</b> weitgehend
konfigurierbar.</p>
<p>Für <b>OL-Commerce</b> ist ein <font color="#FF0000"><b>mächtiges
Datenimport-Instrument</b></font> verfügbar, das in der Lage ist, Daten aus <b>&quot;xxCommerce&quot;-kompatiblen</b>
Systemen so aufzubereiten, dass sie über &quot;<b>PHPMyAdmin</b>&quot; einfach in die <b>OL-Commerce</b>-Datenbank
importiert werden können, und das unabhängig von den installierten
&quot;xxCommerce&quot;-Zusatzfunktionen (Contributions)! Ein Wechsel von anderen <b>&quot;xxCommerce&quot;-kompatiblen</b>
Systemen zu <b>OL-Commerce</b> ist dadurch mit wenig Aufwand verbunden! (Näheres
dazu finden Sie <b><a target="_blank" href="automatischer_daten_import.html">
hier</a></b>!)</p>
<p><b>OL-Commerce</b> ist auf jedem System lauffähig, welches eine PHP Umgebung (ab PHP 4.3), und
&quot;<b>mySQL</b>&quot; als Datenbank-System zur Verfügung stellt, wie zum Beispiel Linux,
Unix, Solaris, BSD, und Microsoft Windows. (Wenn die eingebaute &quot;<b><a target="_blank" href="http://adodb.sourceforge.net/">ADODB</a></b>&quot;-Datenbank-Abstraktions-Bibliothek
aktiviert wird, können auch <b>andere Datenbank-Systeme</b> als &quot;<b>mySQL</b>&quot;
verwendet werden.)</p>
<p><b>OL-Commerce</b> wird ständig vom <b>OL-Commerce</b>-Team und einer großen Gemeinschaft weiterentwickelt.</p>
<p><b>Auch Sie sind dazu herzlich eingeladen!</b></p>
<p>Unter <a href="http://olcommerce-ajax.sourceforge.net" target="_blank"><b>http://olcommerce-ajax.sourceforge.net</b></a> finden Sie alle notwendigen Informationen dazu</p></div>');

define('TEXT_WELCOME_STEP2','<div class="title">Datenbank- und Webservereinstellungen</div><div class="sub_title">Der Installer benötigt hier einige Informationen bezüglich Ihrer Datenbank und Ihrer Verzeichnisstruktur.</div>');
define('TEXT_WELCOME_STEP3','<div class="title">Datenbank Import</div><div class="sub_title">Der OL-Commerce Installer installiert automatisch die OL-Commerce-Datenbank.</div>');
define('TEXT_WELCOME_STEP4','<div class="title">Datenbank Import</div><div class="sub_title">Die grundlegenden Daten der OL-Commerce Datenbank werden automatisch in die Datenbank importiert.</div>');
/*
define('TEXT_WELCOME_STEP5','<div class="title">Erstellung der OL-Commerce Konfigurations-Dateien</div><div class="sub_title"><b><font color="red">Wenn bereits Konfigurations-Dateien aus einer früheren Installation vorhanden sind, wird OL-Commerce diese löschen!</font></b><br/><br/>Der Installer schreibt die automatisch die Konfigurationsdateien für die Dateistruktur und die Datenbankanbindung.</div>');
define('TEXT_WELCOME_STEP5','<div class="title">Web-Server Konfiguration</div><div class="sub_title">Die Informationen des Web-Servers werden ermittelt.</div>');
*/
define('TEXT_WELCOME_STEP5','<div class="title">'.BOX_SHOP_CONFIG.'</div><div class="sub_title">Der Installer richtet den Admin-Account ein und schreibt noch diverse Daten in die Datenbank.<br/><br/>Die angegebenen Daten für <b>Land</b> und <b>PLZ</b> werden für die Versand und Steuerberechnungen genutzt.<br/><br/>Wenn Sie wünschen, kann OL-Commerce automatisch die Zonen, Steuersätze und Steuerklassen für Versand und Verkauf innerhalb der EU einrichten.<br/>Markieren Sie nur <b>'.TEXT_ZONE.'</b> - <b>Ja</b>.</div>');
define('TEXT_WELCOME_STEP6','<div class="title">Konfiguration für Gäste und Standardkunden</div><div class="sub_title">Das OL-Commerce Gruppen und Preissystem bietet Ihnen unbegrenzte Möglichkeiten der Preisgebung.<br/><br/>
<b>% Rabatt auf ein einzelnes Produkt</b><br/><br/>
%max kann für jedes einzelne Produkt und für jede einzelne Kundengruppe gesetzt werden.<br/><br/>
wenn %max für Produkt = 10.00% jedoch %max für Gruppe = 5%<br/>-&gt; 5% Rabatt auf das Produkt<br/><br/>
wenn %max für Produkt = 10.00% jedoch %max für Gruppe = 15%<br/>-&gt; 10% Rabatt auf das Produkt<br/><br/>
<b>% Rabatt auf die gesamte Bestellung</b><br/><br/>
% Rabatt des Bestellwertes (nach Steuer und Währungsberechnung)<br/><br/>
<b>Staffelpreise</b><br/><br/>
Sie können ebenfalls beliebig viele Staffelpreise für einzelne Produkte und einzelne Kundengruppen einrichten.<br/>
Sie können auch jedes dieser Systeme beliebig kombinieren, wie zum Beispiel:<br/>
Kundengruppe 1 -&gt; Staffelpreise auf das Produkt Y<br/>
Kundengruppe 2 -&gt; 10% Rabatt auf Produkt Y<br/>
Kundengruppe 3 -&gt; ein spezieller Gruppenpreis für Produkt Y<br/>
Kundengruppe 4 -&gt; Nettopreis für Produkt Y</div>');
define('TEXT_WELCOME_STEP7','<div class="title">Die OL-Commerce Installation war erfolgreich!</div><div class="sub_title">Der Installer hat nun die Grundfunktionen Ihres Shops eingerichtet. Melden Sie sich im Shop mit Ihrem Admin-Account an und wechseln in den Admin-Bereich, um die komplette weitere Konfiguration Ihres Shops vorzunehmen.</div>');

// install_step1.php

define('TITLE_CUSTOM_SETTINGS','Installations-Optionen');
define('TEXT_IMPORT_DB','Importiere die OL-Commerce Datenbank');
define('TEXT_IMPORT_DB_LONG','Importiere die OL-Commerce Datenbankstruktur, welche die Tabellen und Beispieldaten enthält.');
define('TEXT_AUTOMATIC','Automatische Konfiguration');
define('TEXT_AUTOMATIC_LONG','Ihre Informationen bezüglich Webserver und Datenbank werden automatisch in die benötigten Catalog und Admin Konfigurations-Dateien geschrieben..');
define('TITLE_DATABASE_SETTINGS','Datenbank Informationen');
define('TEXT_DATABASE_SERVER','Datenbankserver');
define('TEXT_DATABASE_SERVER_LONG','Der Datenbankserver kann entweder in Form eines Hostnamens, wie zum Beispiel <i>db1.myserver.com</i> oder <i>localhost</i>, oder als IP-Adresse, wie <i>192.168.0.1</i> angegeben werden.');
define('TEXT_USERNAME','Benutzername');
define('TEXT_USERNAME_LONG','Der Benutzername, der zum konnektieren der Datenbank benötigt wird, wie zum Beispiel <i>mysql_10</i>.<br/><br/>Bemerkung: Wenn die OL-Commerce Datenbank importiert werden soll (wenn oben ausgewählt), muss der Benutzer CREATE und DROP Rechte für die Datenbank haben. Sollten hier Probleme auftreten, kann Ihnen Ihr Provider weiterhelfen.');
define('TEXT_PASSWORD_LONG','Das Passwort wird zusammen mit dem Benutzernamen zum Verbindungsaufbau zur Datenbank benutzt.');
define('TEXT_DATABASE','Datenbank');
define('TEXT_DATABASE_LONG','Der Name der Datenbank, in die die Tabellen eingefügt werden sollen.<br/><b>ACHTUNG:</b> Es muss bereits eine leere Datenbank vorhanden sein, falls nicht -&gt; leere Datenbank mit phpMyAdmin erstellen!');
define('TITLE_WEBSERVER_SETTINGS','Webserver Informationen');
define('TEXT_WS_ROOT','Webserver Root Verzeichnis');
define('TEXT_WS_ROOT_LONG','Das Verzeichnis, in das die Webseiten gespeichert werden, zum Beispiel <i>/home/myname/public_html</i>.');
define('TEXT_WS_OLC','Webserver "OL-Commerce" Verzeichnis');
define('TEXT_WS_OLC_LONG','Das Verzeichnis, in welches die Shopdateien des Catalogs geladen wurden (vom Webserver root Verzeichnis), beispielsweise <i>/home/myname/public_html<b>/OL-Commerce /</b></i>.');
define('TEXT_WS_ADMIN','Webserver Admin Verzeichnis');
define('TEXT_WS_ADMIN_LONG','Das Verzeichnis, in welchem sich die Admin-Werkzeuge Ihres Shops befinden (vom Webserver root Verzeichnis), beispielsweise <i>/home/myname/public_html<b>/OL-Commerce /admin/</b></i>.');
define('TEXT_WS_CATALOG','WWW Catalog Verzeichnis');
define('TEXT_WS_CATALOG_LONG','Das virtuelle Verzeichnis, in dem sich die OL-Commerce Shop-Module befinden, beispielsweise <i>http://www.Ihre-Domain.de<b>/OL-Commerce /</b></i>.');
define('TEXT_WS_ADMINTOOL','WWW Admin Verzeichnis');
define('TEXT_WS_ADMINTOOL_LONG','Das virtuelle Verzeichnis, in dem sich die OL-Commerce Admin-Module befinden, beispielsweise <i>http://www.Ihre-Domain.de<b>/OL-Commerce /admin/</b></i>');

// install_step2.php

define('TEXT_PROCESS_1','Bitte setzten Sie die Installation nun fort, um die Datenbank zu Importieren.');
define('TEXT_PROCESS_2','Dieser Vorgang nimmt einige Zeit in Anspruch. Es ist wichtig, dass Sie den Vorgang nun nicht unterbrechen, weil sonst die Datenbank möglicherweise nicht korrekt installiert wird.');
define('TEXT_PROCESS_3','Die zu importierende Datei muss sich an folgendem Ort befinden: ');

// install_step3.php

define('TEXT_TITLE_ERROR','Der folgende Fehler ist aufgetreten: ');
define('TEXT_TITLE_SUCCESS','Der Datenbank-Import war erfolgreich.');

// install_step4.php
define('TITLE_WEBSERVER_CONFIGURATION','Webserver Informationen: ');
define('TITLE_STEP4_CONFIG','Im nächsten Schritt werden die folgenden Konfigurations-Dateien erstellt:');
define('TITLE_STEP4_ERROR','Der folgenden Fehler ist aufgetreten: ');
define('TEXT_STEP4_ERROR','<b>Die Konfigurationsdateien existieren nicht, oder deren Rechte sind nicht richtig gesetzt.</b>');
define('TEXT_STEP4_ERROR_1','Setzen Sie für die folgenden Dateien mit Ihrem FTP-Programm oder lokalen Explorer die Zugriffs-Rechte auf <b>Lese-/Schreib</b>-Zugriff ("777" für LINUX/UNIX):');
define('TEXT_VALUES','Die folgenden Konfigurations-Werte werden nun in die Dateien geschrieben:');
define('TITLE_CHECK_CONFIGURATION','Ihre Webserver Informationen');
define('TEXT_HTTP','HTTP Server');
define('TEXT_HTTP_LONG','Der Webserver kann als Hostnamen, wie zum Beispiel <i>http://www.myserver.com</i>, oder als IP-Adresse <i>http://192.168.0.1</i> angegeben werden.');
define('TEXT_HTTPS','HTTPS Server');
define('TEXT_HTTPS_LONG','Der gesicherte Webserver kann als Hostnamen, wie zum Beispiel <i>https://www.myserver.com</i>, oder als IP-Adresse <i>https://192.168.0.1</i> angegeben werden.');
define('TEXT_SSL','Benutze SSL-Verbindung');
define('TEXT_SSL_LONG','Ermöglicht die Nutzung einer gesicherten Verbindung mittels SSL ("https"-Protokoll). (Natürlich muss Ihr Server das unterstützen können, um diese Möglichkeit zu verwenden.)');
define('TITLE_CHECK_DATABASE','Ihre Datenbank Informationen');
define('TEXT_PERSIST','Benutze Persistente Verbindung');
define('TEXT_PERSIST_LONG','Hält eine Verbindung zur Datenbank für längere Zeit aufrecht. (Auf den meisten "Shared Servern" ist diese Funktion nicht möglich.)');
define('TEXT_SESS_FILE','Speichere Sessions in Dateien.');
define('TEXT_SESS_DB','Speichere Sessions in der Datenbank');
define('TEXT_SESS_LONG','Das Verzeichnis, in welches PHP die Session-Dateien speichert.');

//	W. Kaiser - Allow table-prefix
define('TEXT_PREFIX','Tabellen-Präfix');
define('TEXT_PREFIX_LONG','Der Präfix am Anfang des Tabellen-Namens (z.B. \'olc\').');
//	W. Kaiser - Allow table-prefix

// install_step5.php

define('TEXT_WS_CONFIGURATION_SUCCESS','Die OL-Commerce</strong> Webserver Konfiguration war erfolgreich');

// install_step6.php

define('TITLE_ADMIN_CONFIG',BOX_ADMIN_CONFIG.HTML_BR);
define('TEXT_REQU_INFORMATION',' erforderliche Information');
define('TEXT_FIRSTNAME','Vorname: ');
define('TEXT_LASTNAME','Nachname: ');
define('TEXT_EMAIL','eMail-Adresse: ');
define('TEXT_EMAIL_LONG','eMail-Adresse, an die eine separate Mail bei Bestellungen gesendet werden soll.');
define('TEXT_STREET','Straße: ');
define('TEXT_POSTCODE','PLZ: ');
define('TEXT_CITY','Stadt: ');
define('TEXT_STATE','Bundesland: ');
define('TEXT_COUNTRY','Land: ');
define('TEXT_COUNTRY_LONG','Wird benutzt für Versand und Steuern.');
define('TEXT_TEL','Telefonnummer: ');
define('TEXT_PASSWORD','Passwort: ');
define('TEXT_PASSWORD_CONF','Passwort Bestätigung: ');
define('TITLE_SHOP_CONFIG','Shop Konfiguration');
define('TITLE_COMPANY_DATA_CONFIG','Firmen-Daten');
define('TEXT_STORE','Shop Name: ');
define('TEXT_STORE_LONG','Der Name des Shops.');
define('TEXT_EMAIL_FROM','eMail-von: ');
define('TEXT_EMAIL_FROM_LONG','Die  Adresse, die in den Bestellungen als "Von"-Adresse benutzt wird.');
define('TITLE_ZONE_CONFIG','Zonen Konfiguration');
define('TITLE_ZONE_CONFIG_NOTE','OL-Commerce kann die Zonen automatisch aufsetzten, sofern Sich Ihr Shop in der EU befindet.');
define('TITLE_SHOP_CONFIG_NOTE','Grundlegende '.TITLE_SHOP_CONFIG);

define('TITLE_COMPANY_DATA_CONFIG_NOTE','Grundlegende '.TITLE_COMPANY_DATA_CONFIG);

define('TITLE_ADMIN_CONFIG_NOTE','Informationen über den Administrator');
define('TEXT_ZONE_NO','Nein');
define('TEXT_ZONE_YES','Ja');
define('TEXT_COMPANY','Firmenname: ');
define('TEXT_COMPANY_LONG','Die Firmenbezeichnung');

// install_step7
define('TITLE_GUEST_CONFIG','Gast Konfiguration');
define('TITLE_GUEST_CONFIG_NOTE','Gast-Kunde Einstellungen (nicht-registrierter Benutzer)');
define('TITLE_CUSTOMERS_CONFIG','Standard-Kunde Konfiguration');
define('TITLE_CUSTOMERS_CONFIG_NOTE','Standard-Kunde Einstellungen (registrierter Kunde)');
define('TEXT_STATUS_DISCOUNT','Rabatt auf Produkte');
define('TEXT_STATUS_DISCOUNT_LONG','Rabatt auf Produkte <i>(in Prozent, z.B. 10.00 , 20.00)</i>');
define('TEXT_STATUS_OT_DISCOUNT_FLAG','Rabatt auf Bestellung');
define('TEXT_STATUS_OT_DISCOUNT_FLAG_LONG',' Erlaubt den Rabatt auf den kompletten Bestellwert');
define('TEXT_STATUS_OT_DISCOUNT','Rabatthöhe auf Bestellung');
define('TEXT_STATUS_OT_DISCOUNT_LONG','Höhe des Rabattes auf den Bestellwert <i>(in Prozent, z.B. 10.00 , 20.00)</i>');
define('TEXT_STATUS_GRADUATED_PRICE','Staffelpreise anzeigen');
define('TEXT_STATUS_GRADUATED_PRICE_LONG','Erlaubt es dem entsprechenden User die Staffelpreise zu sehen.');
define('TEXT_STATUS_SHOW_PRICE','Preise anzeigen');
define('TEXT_STATUS_SHOW_PRICE_LONG','Erlaubt es dem User, normale Preise zu sehen.');
define('TEXT_STATUS_SHOW_TAX','Preise incl. Steuer');
define('TEXT_STATUS_SHOW_TAX_LONG','Zeigt die angegebenen Preise mit (Ja) oder ohne (Nein) Steuer.');
define('TEXT_STATUS_COD_PERMISSION','Per Nachnahme');
define('TEXT_STATUS_COD_PERMISSION_LONG','Erlaubt dem Kunden per Nachnahme zu bestellen.');
define('TEXT_STATUS_CC_PERMISSION','Kreditkarten.');
define('TEXT_STATUS_CC_PERMISSION_LONG','Erlaubt dem Kunden über ihre Kreditkartenzahlsysteme zu bestellen.');
define('TEXT_STATUS_BT_PERMISSION','Bankeinzug');
define('TEXT_STATUS_BT_PERMISSION_LONG','Erlaubt dem Kunden per Bankeinzug zu bestellen.');
// install_fnished.php

define('TEXT_SHOP_CONFIG_SUCCESS','Die <strong>OL-Commerce</strong> Shop Konfiguration war erfolgreich');
define('TEXT_TEAM','Vielen Dank, dass Sie sich für OL-Commerce entschieden haben. Besuchen Sie uns auf der OL-Commerce Supportseite <br/><br/><a href="http://www.ol-commerce.com/v5">http://www.ol-Commerce.com/v5</a><br/><br/>Alles Gute und viel Erfolg wünscht Ihnen das gesamte OL-Commerce Team.');

define('TEXT_ADD_ONS','<br/><b><font color="Blue">Sie können jetzt noch weitere Module installieren.</font></b><br/><br/>(Das <b>Passwort</b> für diese Module wurde schon auf Ihr <b>Adminstratoren-Passwort</b> gesetzt.)');

define('TEXT_RENAME_DIR','Löschen Sie unbedingt das Verzeichnis "xtc_installer" (oder benennen Sie es um)! <br/><br/>Andernfalls könnte Ihr Shop von Aussen manipuliert werden!');
define('TEXT_RENAMED_DIR','Das Installationsverzeichnis \'%s\' wurde aus Sicherheitsgründen in \'%s\' umbenannt!');

define('TEXT_LIVEHELP_INSTALL','"Live Help" installieren');
define('TEXT_ELMAR_INSTALL','Elm@r installieren');
define('TEXT_CHCOUNTER_INSTALL','Shop-Statistik (chCounter) installieren');
define('TEXT_TESTDATA_EXPLAIN','Wir haben für Sie <b>Test-Daten</b> vorbereitet, damit Sie gleich den Shop testen können. Laden Sie das ZIP-Archiv, entpacken Sie dieses, und befolgen Sie dann die darin enthaltene Installations-Anleitung.');
define('TEXT_TESTDATA_LOAD','Test-Daten laden');


//W. Kaiser - AJAX
define('ICON_CROSS', 'Falsch');
define('ICON_CURRENT_FOLDER', 'Aktueller Ordner');
define('ICON_DELETE', 'Löschen');
define('ICON_ERROR', 'Fehler');
define('ICON_FILE', 'Datei');
define('ICON_FILE_DOWNLOAD', 'Herunterladen');
define('ICON_FOLDER', 'Ordner');
define('ICON_LOCKED', 'Gesperrt');
define('ICON_PREVIOUS_LEVEL', 'Vorherige Ebene');
define('ICON_PREVIEW', 'Vorschau');
define('ICON_STATISTICS', 'Statistik');
define('ICON_SUCCESS', 'Erfolg');
define('ICON_TICK', 'Wahr');
define('ICON_UNLOCKED', 'Entsperrt');
define('ICON_WARNING', 'Warnung');

$step_text='Installations-Schritt ';
define('INSTALLATION_STEP_TEXT', $step_text);
define('BUTTON_BACK_TEXT', 'Zurück zu '.$step_text);
define('BUTTON_CANCEL_TEXT',BUTTON_BACK_TEXT);
define('BUTTON_CONTINUE_TEXT', 'Weiter zu '.$step_text);
define('BUTTON_RETRY_TEXT', 'Wiederholen '.$step_text);
define('BUTTON_START_SHOP_TEXT', 'Starte OL-Commerce');
define('BUTTON_START_ADMIN_TEXT', BUTTON_START_SHOP_TEXT.' Administration');

define('ERROR_NO_SQL_FILE','SQL-Datei nicht gefunden: ');
define('ERROR_WRONG_SQL_STATEMENT','Unzulässiger SQL-Befehl:');

define('ERROR_WRONG_PERMISSION','<br/><br/><font color="blue"><b>Die folgenden # haben ungenügende Zugriffsrechte!</b></font><br/>(Es werden Schreibzugriffsrechte benötigt! (chmod 777 für LINUX/UNIX))<br/><br/>');
define('STEP_TEXT','Installations-Schritt ');
define('FILE_ACCESS_RIGHTS','Datei-Zugriffsrechte');
define('ERROR_ILLEGAL_PHP_VERSION',
'<br/><br/><b>ACHTUNG!, Ihre PHP Version ist zu alt! OL-Commerce benötigt mindestens PHP 4.3.0.</b><br/><br/>
Ihre PHP Version: <b>#</b><br/><br/>
OL-Commerce kann mit diesem Server nicht funktionieren. Aktualisieren Sie PHP oder wechseln Sie den Server.');

define('GDLIB_SUPPORT','GDlib GIF-Untersützung');
define('ERROR_NO_GDLIB','<br/>Modul GDLIB nicht gefunden!');
define('ERROR_NO_GIF_SUPPORT','<br/>Sie haben keine GIF-Unterstützung in Ihrer GDlib. Sie können keine GIF-Bilder und GIF Overlay-Funktionen in OL-Commerce verwenden!');
define('TEXT_DIRECTORIES','Verzeichnisse');
define('TEXT_FILES','Dateien');
define('TEXT_DIRECTORIES_ACCESS_RIGHTS','Verzeichnis-Zugriffsrechte');
define('TEXT_ATTENTION','Achtung!');
define('TEXT_TESTS','Prüfungen');
define('TEXT_GERMAN','Deutsch');
define('TEXT_ENGLISH','English');
define('ERROR_CORRECT_PROBLEMS','Bitte korrigieren Sie die Probleme, und klicken Sie dann auf "wiederholen"!');
define('TEXT_PARSE_TIME','Es wurden %s SQL-Befehle in %s ausgeführt<br/><span class="text">(%s SQL-Befehle pro Sekunde)</span>');
define('PARSE_TIME_STRING','%s Sekunden');
define('AJAX_LOGO_TITLE','AJAX-Informationen bei Wikipedia');
define('AJAX_LOGO_LINK','http://de.wikipedia.org/wiki/Ajax_(Programmierung)');
define('TEXT_DB_BEING_INSTALLED','Die Datenbank wird importiert...');
define('TEXT_OPTIONAL_COMPANY_FIELDS','<font color="blue">Die folgenden Firmen-Infomationen können auch später noch im Admin-Bereich definiert werden ("%s/%s").<br/><br/>Es empfiehlt sich jedoch, diese schon jetzt einzugeben!</font>');
define('TEXT_STEP_ERROR','Fehler in der Installations-Abfolge');
define('TEXT_STEP_ERROR_1','Schritt %s muss vor Schritt %s ausgeführt werden!');

define('TEXT_ADD_ON_MODULES','Zusatzmodule installieren');
define('TEXT_TEST_DATA','Test-Daten laden');
define('TEXT_START_SHOP','OL-Commerce starten');
define('TEXT_START_SHOP_WARNING',
'Bei restriktiv konfigurierten Servern kann beim Programmstart die Meldung erscheinen, '.
'dass das Template-Verzeichnis im Verzeichnis "templates_c" keine ausreichenden Rechte besitzt.<br/><br/>'.'
Weisen Sie diesem dann die nötigen Rechte zu, und starten dann den Shop neu!');

//W. Kaiser - AJAX
?>