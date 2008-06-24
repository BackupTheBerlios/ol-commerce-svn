<?php
/* -----------------------------------------------------------------------------------------
$Id: paypal.php,v 2.0.0 2006/12/14 05:49:37 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(paypal.php,v 1.7 2002/04/17); www.oscommerce.com
(c) 2003	    nextcommerce (paypal.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_PAYPAL_TEXT_TITLE', 'PayPal');
define('MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', 'PayPal');

define('MODULE_PAYMENT_PAYPAL_ALLOWED_TITLE', 'Erlaubte Zahlungs-Zonen');
define('MODULE_PAYMENT_PAYPAL_ALLOWED_DESC', 'Geben Sie <b>einzeln</b> die Zonen an, welche für dieses Modul erlaubt sein sollen. (z.B. AT,DE). Wenn das Feld leer ist, werden alle Zonen erlaubt.');
define('MODULE_PAYMENT_PAYPAL_STATUS_TITLE', 'PayPal Modul aktivieren');
define('MODULE_PAYMENT_PAYPAL_STATUS_DESC', 'Möchten Sie Zahlungen per PayPal akzeptieren?');
define('MODULE_PAYMENT_PAYPAL_ID_TITLE', 'eMail Adresse');
define('MODULE_PAYMENT_PAYPAL_ID_DESC', 'eMail Adresse, welche für PayPal verwendet wird');
define('MODULE_PAYMENT_PAYPAL_CURRENCY_TITLE', 'Transaktionswährung');
define('MODULE_PAYMENT_PAYPAL_CURRENCY_DESC', 'Währung, welche für Kreditkartentransaktionen verwendet wird');
define('MODULE_PAYMENT_PAYPAL_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_PAYPAL_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt');
define('MODULE_PAYMENT_PAYPAL_ZONE_TITLE', 'Zahlungszone');
define('MODULE_PAYMENT_PAYPAL_ZONE_DESC', 'Wenn eine Zone ausgewählt ist, gilt die Zahlungsmethode nur für diese Zone.');
define('MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID_TITLE', 'Bestellstatus festlegen');
define('MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID_DESC', 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
define('MODULE_PAYMENT_PAYPAL_TEST_MODE_TITLE','Test-Modus aktivieren');
define('MODULE_PAYMENT_PAYPAL_TEST_MODE_DESC','Im Test-Modus werden die Transaktionen zur PayPal "Sandbox" geleitet. Es finden dann keine echten Zahlungen statt! Dies ist nur für Shop-Erstellung und  -Test gedacht. Um diese Möglichkeit zu nutzen, müssen Sie sich bei PayPal dafür registrieren.');

define('MODULE_PAYMENT_PAYPAL_IPN_STATUS_TITLE','Das PayPal Modul aktivieren');
define('MODULE_PAYMENT_PAYPAL_IPN_STATUS_DESC','Wollen Sie PayPal-Zahlungen akzeptieren?');
define('MODULE_PAYMENT_PAYPAL_IPN_ID_TITLE','eMail Adresse');
define('MODULE_PAYMENT_PAYPAL_IPN_ID_DESC','Die eMail Adresse, die für den PayPal-Dienst verwendet werden soll');
define('MODULE_PAYMENT_PAYPAL_IPN_BUSINESS_ID_TITLE','PayPal id');
define('MODULE_PAYMENT_PAYPAL_IPN_BUSINESS_ID_DESC','Die eMail Adresse or Kundennummer des Zahlungsempfängers');
define('MODULE_PAYMENT_PAYPAL_IPN_DEFAULT_CURRENCY_TITLE','Standard-Währung');
define('MODULE_PAYMENT_PAYPAL_IPN_DEFAULT_CURRENCY_DESC','Die <b>Standard</b>-Währung, die verwendet werden soll, wenn eine Währung verwendet, die PayPal nicht akzeptiert.<br/>(Diese Währung muss im Shop vorhanden sein)');
define('MODULE_PAYMENT_PAYPAL_IPN_CURRENCY_TITLE','Zahlungs-Währung');
define('MODULE_PAYMENT_PAYPAL_IPN_CURRENCY_DESC','Die Währung, die für Kreditkarten-Zahlungen verwendet werden soll');
define('MODULE_PAYMENT_PAYPAL_IPN_ZONE_TITLE','Erlaubte Zahlungs-Zonen');
define('MODULE_PAYMENT_PAYPAL_IPN_ZONE_DESC','Geben Sie <b>einzeln</b> die Zonen an, welche für dieses Modul erlaubt sein sollen. (z.B. AT,DE). Wenn das Feld leer ist, werden alle Zonen erlaubt.');
define('MODULE_PAYMENT_PAYPAL_IPN_PROCESSING_STATUS_ID_TITLE','Bearbeitungs-Status Kennzeichen');

define('MODULE_PAYMENT_PAYPAL_IPN_PROCESSING_STATUS_ID_DESC','Definieren Sie das '. MODULE_PAYMENT_PAYPAL_IPN_PROCESSING_STATUS_ID_TITLE . ' für Bestellungen mit dieser Zahlungsart ("In Bearbeitung" empfohlen)');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID_TITLE','Bestell-Status Kennzeichen');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID_DESC','Definieren Sie das '. MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID_TITLE . ' für Bestellungen mit dieser Zahlungsart ("In Bearbeitung" empfohlen)');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_ONHOLD_STATUS_ID_TITLE','"Blockiert"-Status Kennzeichen');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_ONHOLD_STATUS_ID_DESC','Definieren Sie das '. MODULE_PAYMENT_PAYPAL_IPN_ORDER_ONHOLD_STATUS_ID_TITLE . ' für Bestellungen mit dieser Zahlungsart ("Blockiert" empfohlen)');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_CANCELED_STATUS_ID_TITLE','Ablehnung-Status Kennzeichen');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_CANCELED_STATUS_ID_DESC','Definieren Sie das '. MODULE_PAYMENT_PAYPAL_IPN_ORDER_CANCELED_STATUS_ID_TITLE . ' für Bestellungen mit dieser Zahlungsart ("Abgelehnt" empfohlen)');
define('MODULE_PAYMENT_PAYPAL_IPN_INVOICE_REQUIRED_TITLE','Rechnungen synchronisieren');
define('MODULE_PAYMENT_PAYPAL_IPN_INVOICE_REQUIRED_DESC','Wollen Sie die Auftrags-Nummer als PayPal Rechnungsnummer definieren?');
define('MODULE_PAYMENT_PAYPAL_IPN_SORT_ORDER_TITLE','Sortierreihenfolge der Anzeige.');
define('MODULE_PAYMENT_PAYPAL_IPN_SORT_ORDER_DESC',' Die niedrigste wird zuerst angezeigt.');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_REFUNDED_STATUS_ID_TITLE','Rückzahlungs-Status Kennzeichen');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_REFUNDED_STATUS_ID_DESC','Definieren Sie das '. MODULE_PAYMENT_PAYPAL_IPN_ORDER_REFUNDED_STATUS_ID_TITLE . ' für Bestellungen mit dieser Zahlungsart ("Erstattet" empfohlen)');
define('MODULE_PAYMENT_PAYPAL_IPN_CS_TITLE','Hintergrund-Farbe der PayPal Zahlungs-Seite');
define('MODULE_PAYMENT_PAYPAL_IPN_CS_DESC','Wählen Sie die '.MODULE_PAYMENT_PAYPAL_IPN_CS_TITLE);
define('MODULE_PAYMENT_PAYPAL_IPN_PROCESSING_LOGO_TITLE','Logo der PayPal Zahlung');
define('MODULE_PAYMENT_PAYPAL_IPN_PROCESSING_LOGO_DESC','Die URL für das '.MODULE_PAYMENT_PAYPAL_IPN_PROCESSING_LOGO_TITLE.' auf der Zahlungsseite des Shops');
define('MODULE_PAYMENT_PAYPAL_IPN_STORE_LOGO_TITLE','Logo der PayPal Zahlungs-Seite');
define('MODULE_PAYMENT_PAYPAL_IPN_STORE_LOGO_DESC','Die URL für das '.MODULE_PAYMENT_PAYPAL_IPN_PROCESSING_LOGO_TITLE . ' (leer lassen, wenn der Shop nicht über SSL abgewickelt wird)');
define('MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE_TITLE','PayPal Seiten-Stil Name');
define('MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE_DESC','Der '.MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE_TITLE.', den Sie in Ihrem PayPal Konto hinterlegt haben');
define('MODULE_PAYMENT_PAYPAL_IPN_NO_NOTE_TITLE','Bei der PayPal-Zahlung eine Bemerkung angeben');
define('MODULE_PAYMENT_PAYPAL_IPN_NO_NOTE_DESC','Wählen Sie, ob der Kunde bei der PayPal-Zahlung eine Bemerkung angeben können soll?');
define('MODULE_PAYMENT_PAYPAL_IPN_METHOD_TITLE','Warenkorb Übergabe-Methode');
define('MODULE_PAYMENT_PAYPAL_IPN_METHOD_DESC','Welche '.MODULE_PAYMENT_PAYPAL_IPN_METHOD_TITLE. '  wollen Sie verwenden?');
define('MODULE_PAYMENT_PAYPAL_IPN_SHIPPING_ALLOWED_TITLE','PayPal Liefer-Adresse');
define('MODULE_PAYMENT_PAYPAL_IPN_SHIPPING_ALLOWED_DESC','Den Kunden erlauben, ihre eigene '.MODULE_PAYMENT_PAYPAL_IPN_SHIPPING_ALLOWED_TITLE.' zu verwenden?');
define('MODULE_PAYMENT_PAYPAL_IPN_DEBUG_TITLE','Debug-Benachrichtigungen per eMail');
define('MODULE_PAYMENT_PAYPAL_IPN_DEBUG_DESC',MODULE_PAYMENT_PAYPAL_IPN_DEBUG_TITLE.' aktivieren');
define('MODULE_PAYMENT_PAYPAL_IPN_DIGEST_KEY_TITLE','Transaktions-Sicherungs-Schlüssel');
define('MODULE_PAYMENT_PAYPAL_IPN_DIGEST_KEY_DESC','Der '.MODULE_PAYMENT_PAYPAL_IPN_DIGEST_KEY_TITLE.'  für die Übertragung. Dieser erlaubt die Sicherung der Transaktion. (Beliebige Zeichenfolge.)');
define('MODULE_PAYMENT_PAYPAL_IPN_TEST_MODE_TITLE','Test-Modus');
define('MODULE_PAYMENT_PAYPAL_IPN_TEST_MODE_DESC',MODULE_PAYMENT_PAYPAL_IPN_TEST_MODE_TITLE.'setzen <a href=\"" . olc_href_link(FILENAME_PAYPAL, action=itp) . "\" target=\"ipn\">[IPN Test Panel]</a>');
define('MODULE_PAYMENT_PAYPAL_IPN_CART_TEST_TITLE','Warenkorb Test-Modus');
define('MODULE_PAYMENT_PAYPAL_IPN_CART_TEST_DESC',MODULE_PAYMENT_PAYPAL_IPN_CART_TEST_TITLE.' setzen, um die Zahlungsbeträge zu verifizieren');
define('MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL_TITLE','eMail-Adresse für Debug-Benachrichtigungen');
define('MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL_DESC',MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL_TITLE);
define('MODULE_PAYMENT_PAYPAL_IPN_DOMAIN_TITLE','PayPal URL');
define('MODULE_PAYMENT_PAYPAL_IPN_DOMAIN_DESC','Wählen Sie die '.MODULE_PAYMENT_PAYPAL_IPN_DOMAIN_TITLE.'aus<br/>(Für den Echtbetrieb wählen Sie "www.paypal.com")');
define('MODULE_PAYMENT_PAYPAL_IPN_RM_TITLE','Verhalten der Rückkehr URL');
define('MODULE_PAYMENT_PAYPAL_IPN_RM_DESC','Wie sollte der Kunde von PayPal zur Shop-Seite zurückgeführt werden?<br/>0=Keine Rückführung, 1=Per GET, 2=Per POST');
?>
