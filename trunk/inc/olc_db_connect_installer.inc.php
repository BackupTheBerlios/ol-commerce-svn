<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_db_connect_installer.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(database.php,v 1.2 2002/03/02); www.oscommerce.com
(c) 2003	    nextcommerce (olc_db_connect_installer.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_db_connect_installer($server, $username, $password, $link = 'db_link')
{
	if (!defined('USE_ADODB'))
	{
		define('USE_ADODB',false);
	}
	if (USE_ADODB===true)
	{
		include_once(ADMIN_PATH_PREFIX.'adodb/adodb.inc.php');
		/*
		define('ADODB_FETCH_DEFAULT',0);
		define('ADODB_FETCH_NUM',1);
		define('ADODB_FETCH_ASSOC',2);
		define('ADODB_FETCH_BOTH',3);
		*/
		$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

		if (!defined('ADOBD_DB_TYPE'))
		{
			define('ADOBD_DB_TYPE','mysql');
		}
		$$link = NewADOConnection(ADOBD_DB_TYPE);
		if ($$link)
		{
			if (USE_PCONNECT == TRUE_STRING_S) {
				$$link->PConnect($server, $username, $password, $database);
			} else {
				$$link->Connect($server, $username, $password, $database);
			}
			if ($$link->IsConnected())
			{

			}
			else
			{
				$error="Kann keine Verbindung zur Datenbank '".$database."' auf Server '".$server."' herstellen!";
			}
		}
		else
		{
			$error="Fehler bei 'NewADOConnection' mit ADOBD_DB_TYPE='".ADOBD_DB_TYPE."'";
		}
		if ($error)
		{
			die('olc_db_connect_installer -- '.$error);
		}
	}
	else
	{

		global $$link, $db_error;

		$db_error = false;

		if (!$server)
		{
			$db_error = 'No Server selected.';
			return false;
		}

		$$link = @mysql_connect($server, $username, $password) or $db_error = mysql_error();
		if (!$db_error)
		{
			$mysql_version=trim(mysql_get_server_info());
			if (substr($mysql_version,0,1)>'4')
			{
				require_once(DIR_FS_INC . 'olc_db_query.inc.php');
				olc_db_query_installer("SET SESSION sql_mode=''");
			}
		}
	}
	return $$link;
}
?>