<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_db_fetch_array.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com
(c) 2003	    nextcommerce (olc_db_fetch_array.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX
function olc_db_fetch_array(&$recordset)
{
	if (USE_ADODB===true)
	{
		if ($recordset->EOF)
		{
			$recordset->Close();
		}
		else
		{
			$result=$recordset->FetchRow();
			if ($result === false)
			{
				global $$link;

				$errno=$$link->ErrorNo();
				$errtext=$$link->ErrorMsg();
			}
		}
	}
	else
	{
		$result=mysql_fetch_array($recordset, MYSQL_ASSOC);
		$errno=mysql_errno();
		$errtext=mysql_error();
	}
	if ($errno)
	{
		olc_db_error($query, $errno, $errtext);
	}
	else
	{
		return $result;
	}
}
//W. Kaiser - AJAX
 ?>