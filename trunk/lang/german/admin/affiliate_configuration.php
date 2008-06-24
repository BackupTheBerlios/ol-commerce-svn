<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_configuration.php,v 2.0.0 2006/12/14 05:49:13 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   Copyright (c) 2003 netz-designer
   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

define('AFFILIATE_EMAIL_ADDRESS_TITLE', 'E-Mail Adresse');
define('AFFILIATE_EMAIL_ADDRESS_DESC', 'Die e-Mail Adresse für das Affiliate Programm');
define('AFFILIATE_PERCENT_TITLE', 'Affiliate Pay Per Sale %-Rate');
define('AFFILIATE_PERCENT_DESC', 'Prozentuale Rate für das Pay Per Sale Affiliate Programm.');
define('AFFILIATE_THRESHOLD_TITLE', 'Auszahlungsgrenze');
define('AFFILIATE_THRESHOLD_DESC', 'Untere Grenze für die Auszahlung an Affiliates');
define('AFFILIATE_COOKIE_LIFETIME_TITLE', 'Cookie Lifetime');
define('AFFILIATE_COOKIE_LIFETIME_DESC', 'Wie lange (in Sekunden) der Lead eines Affiliates gültig bleibt.');
define('AFFILIATE_BILLING_TIME_TITLE', 'Abrechnungszeit');
define('AFFILIATE_BILLING_TIME_DESC', 'Die Zeit, die zwischen einer erfolgreichen Bestellung und der Gutschrift beim Affiliate vergehen soll. Benötigt falls Bestellungen Rückbelastet werden.');
define('AFFILIATE_PAYMENT_ORDER_MIN_STATUS_TITLE', 'Minimum Order Status');
define('AFFILIATE_PAYMENT_ORDER_MIN_STATUS_DESC', 'Der Status einer Berstellung, ab wann sie als beglichen gilt.');
define('AFFILIATE_USE_CHECK_TITLE', 'Affiliate Scheck');
define('AFFILIATE_USE_CHECK_DESC', 'Affilaites per Scheck auszahlen');
define('AFFILIATE_USE_PAYPAL_TITLE', 'Affiliate Paypal');
define('AFFILIATE_USE_PAYPAL_DESC', 'Affiliates per Paypal auszahlen');
define('AFFILIATE_USE_BANK_TITLE', 'Affiliate Bank');
define('AFFILIATE_USE_BANK_DESC', 'Affiliates per Überweisung auszahlen');
define('AFFILATE_INDIVIDUAL_PERCENTAGE_TITLE', 'Individueller Prozentsatz');
define('AFFILATE_INDIVIDUAL_PERCENTAGE_DESC', 'Prozentsatz individuell per Affiliate festlegen');
define('AFFILATE_USE_TIER_TITLE', 'Klassensystem');
define('AFFILATE_USE_TIER_DESC', 'Multiklassen Affiliate Programm verwenden');
define('AFFILIATE_TIER_LEVELS_TITLE', 'Anzahl Klassen');
define('AFFILIATE_TIER_LEVELS_DESC', 'Anzahl der beim Klassensystem zu verwendenden Klassen');
define('AFFILIATE_TIER_PERCENTAGE_TITLE', 'Prozentsätze für Klassensystem');
define('AFFILIATE_TIER_PERCENTAGE_DESC', 'Individuelle Prozentsätze für die Unterklassen<br/>Beispiel 8.00;5.00;1.00');
?>
