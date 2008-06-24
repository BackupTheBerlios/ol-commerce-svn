<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_db_test_connection.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:20 gswkaiser Exp $

OL-Commerce Version 1.0
http://www.ol-commerce.com

Copyright (c) 2004 OL-Commerce
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(database.php,v 1.2 2002/03/02); www.oscommerce.com
(c) 2003	    nextcommerce (olc_db_test_connection.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_db_test_connection($database) {
	global $db_error;

	$db_error = false;
	if (olc_db_select_db($database))
	{
		$db_error=!olc_db_query(SELECT_COUNT.SQL_FROM.TABLE_CONFIGURATION);
	}
	else
	{
		$db_error = true;
	}
	if ($db_error)
	{
		if (USE_ADODB===true)
		{
			global $$link;

			$db_error = $$link->ErrorMsg();
		}
		else
		{
			$db_error = mysql_error();
		}
		return false;
	}
	else
	{
		return true;
	}
}
?>