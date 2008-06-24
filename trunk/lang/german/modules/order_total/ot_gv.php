<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_gv.php,v 2.0.0 2006/12/14 05:49:33 gswkaiser Exp $

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_gv.php,v 1.1.2.1 2003/05/15); www.oscommerce.com
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

  define('MODULE_ORDER_TOTAL_GV_TITLE', 'Gutscheine');
  define('MODULE_ORDER_TOTAL_GV_HEADER', 'Gutscheine / Rabatt Kupons');
  define('MODULE_ORDER_TOTAL_GV_DESCRIPTION', 'Gutscheine');
  define('SHIPPING_NOT_INCLUDED', ' [Versand nicht enthalten]');
  define('TAX_NOT_INCLUDED', ' [MwSt. nicht enthalten]');
  define('MODULE_ORDER_TOTAL_GV_USER_PROMPT', 'Anwählen, wenn Sie Ihr Guthaben verwenden möchten');
  define('TEXT_ENTER_GV_CODE', 'Geben Sie bitte hier Ihren Gutscheincode ein &nbsp;&nbsp;');

  define('MODULE_ORDER_TOTAL_GV_STATUS_TITLE', 'Wert anzeigen');
  define('MODULE_ORDER_TOTAL_GV_STATUS_DESC', 'Möchten Sie den Wert des Geschenkgutscheins anzeigen?');
  define('MODULE_ORDER_TOTAL_GV_SORT_ORDER_TITLE', 'Sortierreihenfolge');
  define('MODULE_ORDER_TOTAL_GV_SORT_ORDER_DESC', 'Anzeigereihenfolge');
  define('MODULE_ORDER_TOTAL_GV_QUEUE_TITLE', 'Freigabeliste');
  define('MODULE_ORDER_TOTAL_GV_QUEUE_DESC', 'Sollen bestellte Geschenkgutscheine zuerst in die Freigabeliste?');
  define('MODULE_ORDER_TOTAL_GV_INC_SHIPPING_TITLE', 'Inklusive Versandkosten');
  define('MODULE_ORDER_TOTAL_GV_INC_SHIPPING_DESC', 'Versandkosten an den Warenwert anrechnen');
  define('MODULE_ORDER_TOTAL_GV_INC_TAX_TITLE', 'Inklusiv MwSt.');
  define('MODULE_ORDER_TOTAL_GV_INC_TAX_DESC', 'MwSt. an den Warenwert anrechnen.');
  define('MODULE_ORDER_TOTAL_GV_CALC_TAX_TITLE', 'MwSt. neu berechnen');
  define('MODULE_ORDER_TOTAL_GV_CALC_TAX_DESC', 'MwSt. neu berechnen');
  define('MODULE_ORDER_TOTAL_GV_TAX_CLASS_TITLE', 'MwSt.-Satz');
  define('MODULE_ORDER_TOTAL_GV_TAX_CLASS_DESC', 'Folgenden MwSt. Satz benutzen, wenn Sie den Gutschein als Gutschrift verwenden.');
  define('MODULE_ORDER_TOTAL_GV_CREDIT_TAX_TITLE', 'Guthaben enthält MwSt.');
  define('MODULE_ORDER_TOTAL_GV_CREDIT_TAX_DESC', 'MwSt. dem Gutscheinwert anrechnen');
?>