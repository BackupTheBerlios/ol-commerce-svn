<?php
/* -----------------------------------------------------------------------------------------
$Id: banktransfer.php,v 1.2 2004/04/01 14:19:26 fanta2k Exp $

OL-Commerce Version 1.0
http://www.ol-commerce.com

Copyright (c) 2004 OL-Commerce
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(banktransfer.php,v 1.9 2003/02/18 19:22:15); www.oscommerce.com
(c) 2003	 nextcommerce (banktransfer.php,v 1.5 2003/08/13); www.nextcommerce.org

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contributions:
OSC German Banktransfer v0.85a       	Autor:	Dominik Guder <osc@guder.org>

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
define('MODULE_PAYMENT_TYPE_PERMISSION', 'bt');

define('MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE', 'Lastschriftverfahren');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_DESCRIPTION', MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE);
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK', 'Bankeinzug');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_EMAIL_FOOTER', 'Hinweis: Sie können sich unser Faxformular unter ' . HTTP_SERVER . DIR_WS_CATALOG . MODULE_PAYMENT_BANKTRANSFER_URL_NOTE . ' herunterladen und es ausgefüllt an uns zurücksenden.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_INFO', 'Bitte beachten Sie, dass das Lastschriftverfahren <b>nur</b> von einem <b>deutschen Girokonto</b> aus möglich ist');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_OWNER', 'Kontoinhaber:');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_NUMBER', 'Kontonummer:');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_BLZ', 'BLZ:');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_NAME', 'Bank:');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_FAX', 'Einzugsermächtigung wird per Fax bestätigt');

define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR', '<font color="#FF0000">FEHLER: </font>');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_OWNER_ERROR', 'Name des Kontoinhabers fehlt!');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_1', 'Kontonummer und BLZ stimmen nach unserer Prüfung nicht überein! Bitte überprüfen Sie Ihre Angaben nochmals.<br><br>Wenn die Angaben trotzdem in Ordnung sind, senden Sie das Formular noch einmal ab!');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_2', 'Für diese Kontonummer ist kein Prüfziffernverfahren definiert!');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_3', 'Kontonummer nicht prüfbar!');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_4', 'Kontonummer nicht prüfbar!<br>Bitte überprüfen Sie Ihre Angaben nochmals.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_5', 'Bankleitzahl nicht gefunden!<br>Bitte überprüfen Sie Ihre Angaben nochmals.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_8', 'Fehler bei der Bankleitzahl oder keine Bankleitzahl angegeben!');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_9', 'Keine Kontonummer angegeben!');

define('MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE', '<b>Hinweis:</b>');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE2', 'Wenn Sie aus Sicherheitsbedenken keine Bankdaten über das Internet<br>übertragen wollen, können Sie sich unser ');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE3', 'Faxformular');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE4', ' herunterladen und uns ausgefüllt zusenden.');

define('JS_BANK_BLZ', 'Bitte geben Sie die BLZ Ihrer Bank ein!\n');
define('JS_BANK_NAME', 'Bitte geben Sie den Namen Ihrer Bank ein!\n');
define('JS_BANK_NUMBER', 'Bitte geben Sie Ihre Kontonummer ein!\n');
define('JS_BANK_OWNER', 'Bitte geben Sie den Namen des Kontobesitzers ein!\n');

define('MODULE_PAYMENT_BANKTRANSFER_DATABASE_BLZ_TITLE' , 'Datenbanksuche für die BLZ verwenden?');
define('MODULE_PAYMENT_BANKTRANSFER_DATABASE_BLZ_DESC' , 'Möchten Sie die Datenbanksuche für die BLZ verwenden? Vergewissern Sie sich, daß der Table banktransfer_blz vorhanden und richtig eingerichtet ist!');
define('MODULE_PAYMENT_BANKTRANSFER_URL_NOTE_TITLE' , 'Fax-URL');
define('MODULE_PAYMENT_BANKTRANSFER_URL_NOTE_DESC' , 'Die Fax-Bestätigungsdatei. Diese muss im Catalog-Verzeichnis liegen');
define('MODULE_PAYMENT_BANKTRANSFER_FAX_CONFIRMATION_TITLE' , 'Fax Bestätigung erlauben');
define('MODULE_PAYMENT_BANKTRANSFER_FAX_CONFIRMATION_DESC' , 'Möchten Sie die Fax Bestätigung erlauben?');
define('MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER_TITLE' , 'Anzeigereihenfolge');
define('MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
define('MODULE_PAYMENT_BANKTRANSFER_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_BANKTRANSFER_ZONE_DESC' , 'Wenn eine Zone ausgewählt ist, gilt die Zahlungsmethode nur für diese Zone.');
define('MODULE_PAYMENT_BANKTRANSFER_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_BANKTRANSFER_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche für dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_BANKTRANSFER_STATUS_TITLE' , 'Banktranfer Zahlungen erlauben');
define('MODULE_PAYMENT_BANKTRANSFER_STATUS_DESC' , 'Möchten Banktranfer Zahlungen erlauben?');
?>
