<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_banner_exists.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:09 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com
(c) 2003	    nextcommerce (olc_banner_exists.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
require_once(DIR_FS_INC.'olc_random_select.inc.php');
function olc_banner_exists($action, $identifier)
{
	$sql="select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS .
		" where status = '1' and banners_group = '" . $identifier . APOS;
	if ($action == 'dynamic')
	{
		return olc_random_select($sql);
	}
	elseif ($action == 'static')
	{
		return olc_db_fetch_array(olc_db_query($sql));
	}
	else
	{
		return false;
	}
}
?>