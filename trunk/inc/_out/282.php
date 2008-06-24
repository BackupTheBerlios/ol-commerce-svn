<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_db_query.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com
(c) 2003	    nextcommerce (olc_db_query.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX

function olc_db_query($query, $link = 'db_link',$allow_cache=true)
{
	global $$link,$$link_1;

	$s='MULTI_DB_SERVER';
	if (!defined($s))
	{
		define($s,false);
	}
	if (MULTI_DB_SERVER)
	{
		$db_link=olc_db_get_db_link($query);
	}
	else
	{
		$db_link=$$link;
	}
	if (USE_ADODB===true)
	{
		if (ADODB_USE_LOGGING)
		{
			$db_link->LogSQL(true); // turn on logging
		}
		if (ADOBD_USE_CACHING && $allow_cache)
		{
			$recordset = $db_link->CacheExecute(ADOBD_CACHING_SECONDS, $query);
		}
		else
		{
			$recordset= $db_link->Execute($query);
		}
		if (ADODB_USE_LOGGING)
		{
			$db_link->LogSQL(false); // turn on logging
		}
		if ($recordset!==false)
		{
			$recordset->canSeek=true;
			$recordset->hasLimit=true;
		}
		else
		{
			$recordset_error_nr=$db_link->ErrorNo();
			$recordset_error_text=$db_link->ErrorMsg();
		}
	}
	else
	{
		if (DB_USE_LOGGING)
		{
			error_log('QUERY ' . $query . NEW_LINE, 3, STORE_PAGE_PARSE_TIME_LOG);
		}
		$recordset = mysql_query($query, $db_link);
		$recordset_error_text=mysql_error();
		$recordset_error_nr=mysql_errno();
		if (DB_USE_LOGGING)
		{
			error_log('RESULT ' . $recordset . BLANK . $recordset_error_text . NEW_LINE, 3, STORE_PAGE_PARSE_TIME_LOG);
		}
	}
	if ($recordset_error_nr)
	{
		// include needed functions
		include_once(DIR_FS_INC.'olc_db_error.inc.php');
		$recordset_error_text=olc_db_error($query, $recordset_error_nr, $recordset_error_text );
	}
	return $recordset;
}
//W. Kaiser - AJAX
 ?>
