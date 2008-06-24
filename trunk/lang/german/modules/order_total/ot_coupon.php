<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_coupon.php,v 2.0.0 2006/12/14 05:49:33 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(t_coupon.php,v 1.1.2.2 2003/05/15); www.oscommerce.com
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org
   (c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  define('MODULE_ORDER_TOTAL_COUPON_TITLE', 'Rabatt Kupons');
  define('MODULE_ORDER_TOTAL_COUPON_HEADER', 'Gutscheine / Rabatt Kupons');
  define('MODULE_ORDER_TOTAL_COUPON_DESCRIPTION', 'Rabatt Kupon');
  define('SHIPPING_NOT_INCLUDED', ' [Versand nicht enthalten]');
  define('TAX_NOT_INCLUDED', ' [MwSt. nicht enthalten]');
  define('MODULE_ORDER_TOTAL_COUPON_USER_PROMPT', '');
  define('ERROR_NO_INVALID_REDEEM_COUPON', 'Ungültiger Gutscheincode');
  define('ERROR_INVALID_STARTDATE_COUPON', 'Dieser Gutschein ist noch nicht verfügbar');
  define('ERROR_INVALID_FINISDATE_COUPON', 'Dieser Gutschein ist nicht mehr gültig');
  define('ERROR_INVALID_USES_COUPON', 'Dieser Gutschein kann nur ');
  define('TIMES', ' mal benutzt werden.');
  define('ERROR_INVALID_USES_USER_COUPON', 'Die maximale Nutzung dieses Gutscheines wurde erreicht.');
  define('REDEEMED_COUPON', 'ein Gutschein über ');
  define('REDEEMED_MIN_ORDER', 'für Waren über ');
  define('REDEEMED_RESTRICTIONS', ' [Artikel / Kategorie Einschränkungen]');
  define('TEXT_ENTER_COUPON_CODE', 'Geben Sie hier Ihren Gutscheincode ein &nbsp;&nbsp;');
  
  define('MODULE_ORDER_TOTAL_COUPON_STATUS_TITLE', 'Wert anzeigen');
  define('MODULE_ORDER_TOTAL_COUPON_STATUS_DESC', 'Möchten Sie den Wert des Rabatt Kupons anzeigen?');
  define('MODULE_ORDER_TOTAL_COUPON_SORT_ORDER_TITLE', 'Sortierreihenfolge');
  define('MODULE_ORDER_TOTAL_COUPON_SORT_ORDER_DESC', 'Anzeigereihenfolge.');
  define('MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING_TITLE', 'Inklusive Versandkosten');
  define('MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING_DESC', 'Versandkosten an den Warenwert anrechnen');
  define('MODULE_ORDER_TOTAL_COUPON_INC_TAX_TITLE', 'Inklusive MwSt');
  define('MODULE_ORDER_TOTAL_COUPON_INC_TAX_DESC', 'MwSt. an den Warenwert anrechnen');
  define('MODULE_ORDER_TOTAL_COUPON_CALC_TAX_TITLE', 'MwSt. neu berechnen');
  define('MODULE_ORDER_TOTAL_COUPON_CALC_TAX_DESC', 'MwSt. neu berechnen');
  define('MODULE_ORDER_TOTAL_COUPON_TAX_CLASS_TITLE', 'MwSt.-Satz');
  define('MODULE_ORDER_TOTAL_COUPON_TAX_CLASS_DESC', 'Folgenden MwSt. Satz benutzen, wenn Sie den Rabatt Kupon als Gutschrift verwenden.');
?>