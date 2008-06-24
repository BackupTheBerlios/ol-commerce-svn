<?php
/*
$Id: paypal.lng.php,v 1.1.1.1 2006/12/22 13:43:25 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2002 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/

//begin ADMIN text
define('HEADING_ADMIN_TITLE', 'PayPal IPN (Instant Payment Notifications)');
define('HEADING_PAYMENT_STATUS', 'Status');
define('TEXT_ALL_IPNS', 'Alle');
define('TEXT_INFO_PAYPAL_IPN_HEADING', 'PayPal IPN');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TEXT_DISPLAY_NUMBER_OF_TRANSACTIONS', 'Zeige <b>%d</b> bis <b>%d</b> (von <b>%d</b> IPN\'s)');

//shared with TransactionSummaryLogs
define('TABLE_HEADING_DATE', 'Datum');
define('TABLE_HEADING_DETAILS', 'Details');
define('TABLE_HEADING_PAYMENT_STATUS', 'Status');
define('TABLE_HEADING_PAYMENT_GROSS', 'Brutto');
define('TABLE_HEADING_PAYMENT_FEE', 'Gebühr');
define('TABLE_HEADING_PAYMENT_NET_AMOUNT', 'Netto-Betrag');

//TransactionSummaryLogs
define('TABLE_HEADING_TXN_ACTIVITY', 'Transaktionen');
define('IMAGE_BUTTON_TXN_ACCEPT', 'Akzeptieren');

//AcceptOrder
define('SUCCESS_ORDER_ACCEPTED', 'Bestellung akzeptiert!');
define('ERROR_UNAUTHORIZED_REQUEST', 'Unauthorisierte Anforderung!');
define('ERROR_ORDER_UNPAID', 'Zahlungsvorgang wurde nicht beendet!');

//Template Page Titles
define('TEXT_NO_IPN_HISTORY', 'Keine PayPal Transaktions-Informationen verfügbar (%s)');
define('HEADING_DETAILS_TITLE', 'Transaktions-Details');
define('HEADING_ITP_TITLE', 'IPN Test Panel');
define('HEADING_ITP_HELP_TITLE', 'IPN Test Panel - Hinweise');
define('HEADING_HELP_CONTENTS_TITLE', 'Hilfe Inhalt');
define('HEADING_HELP_CONFIG_TITLE', 'Konfigurations-Hinweise');
define('HEADING_HELP_FAQS_TITLE', 'Oft gestellte Fragen');
define('HEADING_ITP_RESULTS_TITLE', 'IPN Test Panel - Ergebnisse');

//IPN Test Panel
define('IMAGE_ERROR', 'Fehler Icon');

//IPN Statusses
define('PAYPAL_IPN_STATUS_PENDING','In Bearbeitung');
define('PAYPAL_IPN_STATUS_CANCELED','Ungültig');
define('PAYPAL_IPN_STATUS_COMPLETED','Fertig');
define('PAYPAL_IPN_STATUS_ON_HOLD','Blockiert');
define('PAYPAL_IPN_STATUS_FAILED','Fehlgeschlagen');
define('PAYPAL_IPN_STATUS_DENIED','Verweigert');
define('PAYPAL_IPN_STATUS_REFUNDED','Erstattet');
define('PAYPAL_IPN_STATUS_REVERSED','Zurückgezogen');
define('PAYPAL_IPN_STATUS_CANCELED_REVERSAL' , PAYPAL_IPN_STATUS_REVERSED.' geändert');
?>