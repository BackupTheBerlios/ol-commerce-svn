<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_db_queryCached.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com
(c) 2004      XT - Commerce; www.xt-commerce.com


Released under the GNU General Public License
---------------------------------------------------------------------------------------*/


function olc_db_queryCached($query, $link = 'db_link')
{
	if (USE_ADODB===true)
	{
		return olc_db_query($query, $link);
	}
	else
	{
		global $$link;

		// get HASH id for filename
		$id=md5($query);

		// cache File Name
		$file=SQL_CACHEDIR.$id.'.olc';

		// file life time
		$expire = DB_CACHE_EXPIRE; // 24 hours

		if (STORE_DB_TRANSACTIONS == TRUE_STRING_S) {
			error_log('QUERY ' . $query . NEW_LINE, 3, STORE_PAGE_PARSE_TIME_LOG);
		}

		if (file_exists($file) && filemtime($file) > (time() - $expire)) {

			// get cached resulst
			$result = unserialize(implode('',file($file)));

		} else {

			if (file_exists($file)) unlink($file);

			// get result from DB and create new file
			$result = olc_db_query($query, $$link) or olc_db_error($query, mysql_errno(), mysql_error());

			if (STORE_DB_TRANSACTIONS == TRUE_STRING_S) {
				$result_error = mysql_error();
				error_log('RESULT ' . $result . BLANK . $result_error . NEW_LINE, 3, STORE_PAGE_PARSE_TIME_LOG);
			}

			// fetch data into array
			$records=array();
			while ($record = olc_db_fetch_array($result))
			$records[]=$record;


			// safe result into file.
			$stream = serialize($records);
			$fp = fopen($file,"w");
			fwrite($fp, $stream);
			fclose($fp);
			$result = unserialize(implode('',file($file)));

		}
		return $result;
	}
}
?>