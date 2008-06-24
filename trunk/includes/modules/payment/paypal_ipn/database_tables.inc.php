<?php
/*
$Id: database_tables.inc.php,v 1.1.1.1.2.1 2007/04/08 07:18:07 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2003 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/

define('TABLE_PAYPAL',TABLE_PREFIX_INDIVIDUAL.'paypal');
define('TABLE_PAYPAL_PAYMENT_STATUS_HISTORY',TABLE_PREFIX_INDIVIDUAL.'paypal_payment_status_history');
define('TABLE_ORDERS_SESSION_INFO', TABLE_PREFIX_INDIVIDUAL.'orders_session_info');
define('TABLE_PAYPAL_AUCTION',TABLE_PREFIX_INDIVIDUAL.'paypal_auction');

// define the database table names used in the Affiliate Contribution
define('TABLE_AFFILIATE', TABLE_PREFIX_INDIVIDUAL.'affiliate_affiliate');
define('TABLE_AFFILIATE_SALES', TABLE_PREFIX_INDIVIDUAL.'affiliate_sales');
?>
