<?php
/*
$Id: pdf_invoice.php,v 2.0.0 2006/12/14 05:49:12 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2002 osCommerce

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

Released under the GNU General Public License
*/

//***** Note:  '~' markiert einen Zeilenumbruch *****
define('PRINT_INVOICE_COMMENTS', 'Kommentare');
define('PRINT_INVOICE_POSITION','Pos.');
define('PRINT_INVOICE_QUANTITY', 'Menge');
define('PRINT_INVOICE_PRODUCTS', 'Artikel');
define('PRINT_INVOICE_PRODUCTS_MODEL',PRINT_INVOICE_PRODUCTS.'-Nr.');
define('PRINT_INVOICE_TAX', 'MwSt. ');
define('PRINT_INVOICE_DISCOUNT', 'Rabatt~(%)');
define('PRINT_INVOICE_TOTAL', 'Gesamt');
define('PRINT_INVOICE_TOTAL_DISCOUNT', 'Rabatt');
define('PRINT_INVOICE_TOTAL_CREDIT', 'Guthaben');
define('PRINT_INVOICE_SUM', 'Summe');
define('PRINT_INVOICE_PRICE', 'Gesamt-~preis (#)');
define('PRINT_INVOICE_SINGLE_PRICE', 'Einzel-~preis (#)');
define('PRINT_INVOICE_CARRY', 'Übertrag');

define('PRINT_INVOICE_NO_DOCUMENT', 'Es ist noch kein # vorhanden!');
define('PRINT_INVOICE_CUST_REF', 'Ihre Bestellnummer: ');
define('PRINT_INVOICE_SOLD_TO', 'Bestelladresse: ');
define('PRINT_INVOICE_BILL_TO', 'Rechnungsadresse: ');
define('PRINT_INVOICE_SHIP_TO', 'Lieferadresse: ');
define('PRINT_INVOICE_PAYMENT_METHOD', 'Zahlungsart: ');
define('PRINT_INVOICE_SUB_TOTAL', 'Übertrag: ');
define('PRINT_INVOICE_TAX', 'MwSt ');
define('PRINT_INVOICE_SHIPPING', 'Lieferung: ');

define('PRINT_INVOICE_URL',HTTP_SERVER);
define('PRINT_INVOICE_NAME', STORE_NAME);
define('PRINT_INVOICE_INVOICE_HEADING', 'Rechnung');
define('PRINT_INVOICE_PACKINGSLIP_HEADING', 'Lieferschein');
define('PRINT_INVOICE_ORDER_HEADING', 'Bestellbestätigung');
define('PRINT_INVOICE_THANX_TEXT', 'Vielen Dank für Ihren Einkauf. Bitte empfehlen Sie uns weiter.');
define('PRINT_INVOICE_MONEY_ORDER', 'Bitte überweisen Sie den Rechnungsbetrag auf das unten genannte Konto.');
define('PRINT_INVOICE_CUSTOMER_NR', 'Kundennummer: ');

$nr=' Nr.: ';
$date='datum: ';
define('PRINT_INVOICE_ORDER_NR', PRINT_INVOICE_ORDER_HEADING.$nr);
define('PRINT_INVOICE_ORDER_DATE','Bestell'.$date);
define('PRINT_INVOICE_INVOICE_NR', PRINT_INVOICE_INVOICE_HEADING.$nr);
define('PRINT_INVOICE_INVOICE_DATE','Rechnungs'.$date);
define('PRINT_INVOICE_PACKINGSLIP_NR', PRINT_INVOICE_PACKINGSLIP_HEADING.$nr);
define('PRINT_INVOICE_PACKINGSLIP_DATE', 'Liefer'.$date);
define('PRINT_INVOICE_DATE', 'Datum: ');
define('PRINT_INVOICE_PAGE', 'Seite #');

define('PRINT_INVOICE_BANK', 'Bankverbindung: ');
define('PRINT_INVOICE_BANK_BLZ', 'Blz: ');
define('PRINT_INVOICE_BANK_ACCOUNT', 'Konto: ');
define('PRINT_INVOICE_BANK_BIC', 'BIC: ');
define('PRINT_INVOICE_BANK_IBAN', 'IBAN: ');
define('PRINT_INVOICE_USTID', 'USt-Id: ');
define('PRINT_INVOICE_TAXNR', 'Steuer-Nr.: ');
define('PRINT_INVOICE_REGISTER', 'Registergericht: ');
define('PRINT_INVOICE_MANAGER', 'Geschäftsführer: ');
define('TEXT_FON','Fon')
?>
