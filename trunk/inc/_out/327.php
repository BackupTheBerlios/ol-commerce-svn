<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_get_all_get_params.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:29 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_get_all_get_params.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_get_all_get_params($exclude_array = EMPTY_STRING)
{
	$get_url = EMPTY_STRING;
	if (is_array($_GET))
	{
		if (sizeof($_GET) > 0)
		{
			if (!is_array($exclude_array))
			{
				$exclude_array = array();
			}
			$exclude_array = array_merge($exclude_array,array(olc_session_name(),'error','x','y'));
			reset($_GET);
			while (list($key, $value) = each($_GET))
			{
				if (strlen($value) > 0)
				{
					if (!in_array($key, $exclude_array))
					{
						$get_url .= $key . EQUAL . rawurlencode(stripslashes($value)).AMP;
					}
				}
			}
			$pos=strpos($get_url,'start_debug');
			if ($pos===false)
			{
				$pos=strpos($get_url,'DBGSESSION');
			}
			if ($pos!==false)
			{
				$get_url=substr($get_url,0,$pos-1);
			}
		}
	}
	return $get_url;
}
?>