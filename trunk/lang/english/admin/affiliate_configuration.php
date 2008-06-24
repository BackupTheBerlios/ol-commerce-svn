<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_configuration.php,v 2.0.0 2006/12/14 05:48:29 gswkaiser Exp $

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

define('AFFILIATE_EMAIL_ADDRESS_TITLE', 'E-Mail Adress');
define('AFFILIATE_EMAIL_ADDRESS_DESC', 'The E Mail Address for the Affiliate Programm');
define('AFFILIATE_PERCENT_TITLE', 'Affiliate Pay Per Sale %-Rate');
define('AFFILIATE_PERCENT_DESC', 'Percentage Rate for the Affiliate Program');
define('AFFILIATE_THRESHOLD_TITLE', 'Payment Threshold');
define('AFFILIATE_THRESHOLD_DESC', 'Payment Threshold for paying affiliates');
define('AFFILIATE_COOKIE_LIFETIME_TITLE', 'Cookie Lifetime');
define('AFFILIATE_COOKIE_LIFETIME_DESC', 'How long does the click count (seconds) if customer comes back');
define('AFFILIATE_BILLING_TIME_TITLE', 'Billing Time');
define('AFFILIATE_BILLING_TIME_DESC', 'Orders billed must be at least "30" days old.<br/>This is needed if a order is refunded');
define('AFFILIATE_PAYMENT_ORDER_MIN_STATUS_TITLE', 'Minimum Order Status');
define('AFFILIATE_PAYMENT_ORDER_MIN_STATUS_DESC', 'The status an order must have at least, to be billed');
define('AFFILIATE_USE_CHECK_TITLE', 'Affiliates Check');
define('AFFILIATE_USE_CHECK_DESC', 'Pay Affiliates with check');
define('AFFILIATE_USE_PAYPAL_TITLE', 'Affiliate Paypal');
define('AFFILIATE_USE_PAYPAL_DESC', 'Pay Affiliates with PayPal');
define('AFFILIATE_USE_BANK_TITLE', 'Affiliate Bank');
define('AFFILIATE_USE_BANK_DESC', 'Pay Affiliates by Bank');
define('AFFILATE_INDIVIDUAL_PERCENTAGE_TITLE', 'Individual Affiliate Percentage');
define('AFFILATE_INDIVIDUAL_PERCENTAGE_DESC', 'Allow per Affiliate provision');
define('AFFILATE_USE_TIER_TITLE', 'Use Affiliate-tier');
define('AFFILATE_USE_TIER_DESC', 'Multilevel Affiliate provisions');
define('AFFILIATE_TIER_LEVELS_TITLE', 'Number of Tierlevels');
define('AFFILIATE_TIER_LEVELS_DESC', 'Number of Tierlevels');
define('AFFILIATE_TIER_PERCENTAGE_TITLE', 'Percentage Rate for the Tierlevels');
define('AFFILIATE_TIER_PERCENTAGE_DESC', 'Percent Rates for the tierlevels<br/>Example: 8.00;5.00;1.00');
?>
