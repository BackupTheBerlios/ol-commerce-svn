<?php
/* --------------------------------------------------------------
   $Id: banner_statistics.php,v 2.0.0 2006/12/14 05:48:31 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner_statistics.php,v 1.3 2003/02/16); www.oscommerce.com 
   (c) 2003	    nextcommerce (banner_statistics.php,v 1.4 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Banner Statistics');

define('TABLE_HEADING_SOURCE', 'Source');
define('TABLE_HEADING_VIEWS', 'Views');
define('TABLE_HEADING_CLICKS', 'Clicks');

define('TEXT_BANNERS_DATA', 'D<br/>a<br/>t<br/>a');
define('TEXT_BANNERS_DAILY_STATISTICS', '%s Daily Statistics For %s %s');
define('TEXT_BANNERS_MONTHLY_STATISTICS', '%s Monthly Statistics For %s');
define('TEXT_BANNERS_YEARLY_STATISTICS', '%s Yearly Statistics');

define('STATISTICS_TYPE_DAILY', 'Daily');
define('STATISTICS_TYPE_MONTHLY', 'Monthly');
define('STATISTICS_TYPE_YEARLY', 'Yearly');

define('TITLE_TYPE', 'Type:');
define('TITLE_YEAR', 'Year:');
define('TITLE_MONTH', 'Month:');

define('ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST', 'Error: Graphs directory does not exist. Please create a \'graphs\' directory inside \'images\'.');
define('ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE', 'Error: Graphs directory is not writeable.');
?>
