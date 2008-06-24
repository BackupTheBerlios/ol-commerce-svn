<?php
/* -----------------------------------------------------------------------------------------
$Id: application_bottom.php,v 1.1.1.1.2.1 2007/04/08 07:17:43 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(application_bottom.php,v 1.14 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (application_bottom.php,v 1.6 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

require_once(DIR_FS_INC.'olc_get_parse_time.inc.php');
if (USE_AJAX)
{
	define('PARSE_TIME',$parse_time);
}
else 
{
	echo $parse_time;
}
/*
if ( (GZIP_COMPRESSION == TRUE_STRING_S) && ($ext_zlib_loaded == true) && ($ini_zlib_output_compression < 1) ) {
	if ( (PHP_VERSION < '4.0.4') && (PHP_VERSION >= '4') ) {
		olc_gzip_output(GZIP_LEVEL);
	}
}
*/
?>