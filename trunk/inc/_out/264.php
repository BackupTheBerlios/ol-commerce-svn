<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_db_connect.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com
(c) 2003	    nextcommerce (olc_db_connect.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD,
$database = DB_DATABASE, $link = 'db_link')
{
	global $$link,$db;

	if (USE_ADODB===true)
	{
		define('DB_USE_LOGGING',STORE_DB_TRANSACTIONS == TRUE_STRING_S || IS_LOCAL_HOST);
		define('ADODB_ASSOC_CASE', 2); // use native-case for ADODB_FETCH_ASSOC
		include_once(ADMIN_PATH_PREFIX.'adodb/adodb.inc.php');
		/*
		define('ADODB_FETCH_DEFAULT',0);
		define('ADODB_FETCH_NUM',1);
		define('ADODB_FETCH_ASSOC',2);
		define('ADODB_FETCH_BOTH',3);
		*/
		$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
		$ADODB_LANG='de';				//Set language

		$error_nr=-1;
		$$link = NewADOConnection(ADOBD_DB_TYPE);
		if ($$link)
		{
			if (USE_PCONNECT == TRUE_STRING_S)
			{
				$$link->PConnect($server, $username, $password, $database);
			} else {
				$$link->Connect($server, $username, $password, $database);
			}
			if ($$link->IsConnected())
			{
				if (ADOBD_USE_CACHING)
				{
					define('ADOBD_CACHING_SECONDS',3600);
					$ADOBD_CACHING_SECONDS=ADOBD_CACHING_SECONDS;
					$ADODB_CACHE_DIR=ADMIN_PATH_PREFIX.'cache/adodb_cache';
				}
				if (ADOBD_USE_STATS)
				{
					$$link->fnExecute = 'CountExecs';
					$$link->fnCacheExecute = $$link->fnExecute.'Cached';

					global $EXECS,$CACHED;
					$EXECS=0;
					$CACHED=0;
				}
				$db=$$link;
			}
			else
			{
				$error_text="Kann keine Verbindung zur Datenbank '".$database.
					"' auf Server '".$server."' herstellen!";
			}
		}
		else
		{
			$error_text="Fehler bei 'NewADOConnection' mit ADOBD_DB_TYPE='".ADOBD_DB_TYPE.APOS;
		}
	}
	else
	{
		define('DB_USE_LOGGING',STORE_DB_TRANSACTIONS == TRUE_STRING_S);
		if (USE_PCONNECT == TRUE_STRING_S) {
			$$link = mysql_pconnect($server, $username, $password);
		} else {
			$$link = mysql_connect($server, $username, $password);
		}
		if ($$link)
		{
			mysql_select_db($database);
			$mysql_version=trim(mysql_get_server_info());
			if (substr($mysql_version,0,1)>'4')
			{
				//Disable "STRICT" mode for MySQL 5!
				olc_db_query("SET SESSION sql_mode=''");
			}
		}
		else
		{
			$error_text=mysql_error();
			$error_nr=mysql_errno();
		}
	}
	if ($error_text)
	{
		olc_db_error(EMPTY_STRING,$error_nr,'olc_db_connect -- '.$error_text);
	}
	else
	{
		return $$link;
	}
}

if (ADOBD_USE_STATS)
{
	# $db is the connection object
	function CountExecs($db, $sql, $inputarray)
	{
		global $EXECS;

		if (!is_array(inputarray))
		{
			$EXECS++;
		}
		# handle 2-dimensional input arrays
		else if (is_array(reset($inputarray)))
		{
			$EXECS += sizeof($inputarray);
		}
		else
		{
			$EXECS++;
		}
		# in PHP4.4 and PHP5, we need to return a value by reference
		$null = null;
		return $null;
	}

	# $db is the connection object
	function CountExecsCached($db, $secs2cache, $sql, $inputarray)
	{
		global $CACHED;
		$CACHED++;
	}
}
?>