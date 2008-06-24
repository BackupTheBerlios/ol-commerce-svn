<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_db_error.inc.php,v 1.1.1.2.2.1 2007/04/08 07:17:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com
(c) 2003	    nextcommerce (olc_db_error.inc.php,v 1.4 2003/08/19); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX
function olc_db_error($query=EMPTY_STRING, $errno=0, $error=EMPTY_STRING)
{
	if ($error==EMPTY_STRING)
	{
		if (USE_ADODB===true)
		{
			global $$link;

			$errno=$$link->ErrorNo();
			if ($errno)
			{
				$error=$$link->ErrorMsg();
			}
		}
		else
		{
			$errno=mysql_errno();
			if ($errno)
			{
				$error=mysql_error();
			}
		}
	}
	if ($errno)
	{
		$error=$errno . ' - ' . $error . HTML_BR . $query;
		my_error_handler(E_USER_ERROR, $error);
	}
	else
	{
		return EMPTY_STRING;
	}
}
//W. Kaiser - AJAX
 ?>