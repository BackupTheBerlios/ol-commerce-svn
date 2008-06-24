<?php
/*
$Id: pdf_invoice.php,v 2.0.0 2006/12/14 05:48:28 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2002 osCommerce

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

Released under the GNU General Public License
*/

//***** Note:  '~' marks a line break *****
define('PRINT_INVOICE_COMMENTS', 'Comments');
define('PRINT_INVOICE_QUANTITY', 'Qty');
define('PRINT_INVOICE_POSITION','Pos.');
define('PRINT_INVOICE_PRODUCTS_MODEL', 'Model');
define('PRINT_INVOICE_PRODUCTS', 'Product');
define('PRINT_INVOICE_DISCOUNT', 'Disc.~(%)');
define('PRINT_INVOICE_TAX', 'VAT %');
define('PRINT_INVOICE_TOTAL', 'Total');
define('PRINT_INVOICE_TOTAL_DISCOUNT', 'Discount');
define('PRINT_INVOICE_TOTAL_CREDIT', 'Credit');
define('PRINT_INVOICE_SUM', 'Sum');
define('PRINT_INVOICE_CARRY', 'Carry');
define('PRINT_INVOICE_CUST_REF', 'Your order #: ');
define('PRINT_INVOICE_SOLD_TO', 'SOLD TO: ');
define('PRINT_INVOICE_BILL_TO', 'BILL TO: ');
define('PRINT_INVOICE_SHIP_TO', 'DELIVER TO: ');
define('PRINT_INVOICE_PAYMENT_METHOD', 'Payment Method: ');
define('PRINT_INVOICE_SUB_TOTAL', 'Sub-Total: ');
define('PRINT_INVOICE_TAX', 'Tax: ');
define('PRINT_INVOICE_SHIPPING', 'Delivery: ');

define('PRINT_INVOICE_NO_DOCUMENT', '# is not yet available!');

define('PRINT_INVOICE_URL',HTTP_SERVER);
define('PRINT_INVOICE_NAME', STORE_NAME);
define('PRINT_INVOICE_INVOICE_HEADING', 'Invoice');
define('PRINT_INVOICE_ORDER_HEADING', 'Orderconfirmation');
define('PRINT_INVOICE_PACKINGSLIP_HEADING', 'Packingslip');
define('PRINT_INVOICE_THANX_TEXT', 'Thank you for shopping at');
define('PRINT_INVOICE_CUSTOMER_NR', 'Customer #: ');
$nr=' #: ';
define('PRINT_INVOICE_ORDERNR', PRINT_INVOICE_ORDER_HEADING.$nr);
define('PRINT_INVOICE_INVOICENR', PRINT_INVOICE_INVOICE_HEADING.$nr);
define('PRINT_INVOICE_PACKINGSLIPNR', PRINT_INVOICE_PACKINGSLIP_HEADING.$nr);
define('PRINT_INVOICE_DATE', 'Date of Order: ');
define('PRINT_INVOICE_PAGE', 'Page #');
define('PRINT_INVOICE_BANK', 'Bankverbindung: ');
define('PRINT_INVOICE_BANK_BLZ', 'Blz: ');
define('PRINT_INVOICE_BANK_ACCOUNT', 'Account: ');
define('PRINT_INVOICE_BANK_BIC', 'BIC: ');
define('PRINT_INVOICE_BANK_IBAN', 'IBAN: ');
define('PRINT_INVOICE_USTID', 'VAT-Id: ');
define('PRINT_INVOICE_TAXNR', 'Tax-Nr.: ');
define('PRINT_INVOICE_REGISTER', 'Registergericht: ');
define('PRINT_INVOICE_MANAGER', 'Manager: ');
define('TEXT_FON','Tel')
?>
