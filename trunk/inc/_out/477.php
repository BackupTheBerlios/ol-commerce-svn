<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_connect_and_get_config.inc.php,v 1.1.1.2 2006/12/23 09:14:14 gswkaiser Exp $

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

function olc_connect_and_get_config($configuration_groups,$admin_path_prefix)
{
	global $connected;
	if (!$connected)
	{
		global $prefix_only;
		// include the list of project database tables
		require($admin_path_prefix.DIR_WS_INCLUDES.'database_tables.php');
		require_once(DIR_FS_INC.'olc_db_connect.inc.php');
		require_once(DIR_FS_INC.'olc_db_error.inc.php');
		require_once(DIR_FS_INC.'olc_db_fetch_array.inc.php');
		require_once(DIR_FS_INC.'olc_db_input.inc.php');
		require_once(DIR_FS_INC.'olc_db_insert_id.inc.php');
		require_once(DIR_FS_INC.'olc_db_data_seek.inc.php');
		require_once(DIR_FS_INC.'olc_db_num_rows.inc.php');
		require_once(DIR_FS_INC.'olc_db_query.inc.php');
		require_once(DIR_FS_INC.'olc_db_close.inc.php');
		require_once(DIR_FS_INC.'olc_db_prepare_input.inc.php');
		require_once(DIR_FS_INC.'olc_db_perform.inc.php');
		require_once(DIR_FS_INC.'olc_db_free_result.inc.php');
		require_once(DIR_FS_INC.'olc_db_close.inc.php');
		require_once(DIR_FS_INC.'olc_db_output.inc.php');
		require_once(DIR_FS_INC.'olc_db_input.inc.php');
		require_once(DIR_FS_INC.'olc_db_prepare_input.inc.php');
		require_once(DIR_FS_INC.'olc_not_null.inc.php');
		include_once(DIR_FS_INC.'olc_error_handler.inc.php');
		// make a connection to the database
		//Multiple DB-servers are not supported (yet!), only multiple DBs on the same server
		//define('MULTI_DB_SERVER',defined('DB_SERVER_1'));
		define('MULTI_DB_SERVER',false);
		$db_connect_error='Kann keine Verbindung zur Datenbank "%s" herstellen!/Can not connect to database "%s"!';
		if (MULTI_DB_SERVER)
		{
			include_once(DIR_FS_INC.'olc_db_get_db_link.inc.php');
			$$link_1=olc_db_connect(DB_SERVER_1, DB_SERVER_USERNAME_1, DB_SERVER_PASSWORD_1,DB_DATABASE_1, 'db_link_1') or
			die(sprintf($db_connect_error,DB_DATABASE_1,DB_DATABASE_1));
		}
		olc_db_connect() or die(sprintf($db_connect_error,DB_DATABASE,DB_DATABASE));
	}
	global $current_template_text,$current_template_db;

	// set the application parameters
	$where=EMPTY_STRING;
	for ($i=0,$n=sizeof($configuration_groups);$i<$n;$i++)
	{
		if ($i>0)
		{
			$where.=SQL_OR;
		}
		$where.='configuration_group_id='.$configuration_groups[$i];
	}
	if ($n>0)
	{
		$where= SQL_WHERE.$where;
	}
	$configuration_text='configuration';
	$configuration_u_text=$configuration_text.UNDERSCORE;
	$configuration_value_text=$configuration_u_text.'value';
	$configuration_key_text=$configuration_u_text.'key';
	$select=SELECT.$configuration_key_text.COMMA_BLANK;
	$table=TABLE_PREFIX_INDIVIDUAL.$configuration_text;
	$from=SQL_FROM.$table;
	$configuration_query =
	olc_db_query($select.$configuration_value_text.$from.$where);
	while ($configuration = olc_db_fetch_array($configuration_query))
	{
		$s=$configuration[$configuration_key_text];
		$s1=$configuration[$configuration_value_text];
		if ($s<>$current_template_text)
		{
			define($s, $s1);
		}
		else
		{
			$current_template_db=$s1;
		}
	}
	$key='olc_CONVERSION_DONE';
	if (!defined($key))
	{
		//Adjust "use"- and "set"-function-names form "olc_..." to "olc_"...
		$use_function_text='use_function';
		$set_function_text='set_function';
		$olc_text='olc_';
		$olc_text='olc_';
		$configuration_query=
			olc_db_query($select.$configuration_value_text.COMMA_BLANK.$use_function_text.COMMA_BLANK.$set_function_text.$from.$where);
		while ($configuration = olc_db_fetch_array($configuration_query))
		{
			$s=$configuration[$use_function_text];
			$s1=$configuration[$set_function_text];
			$sql_array=array();
			if ($s)
			{
				$sql_array[$use_function_text]=str_replace($olc_text,$olc_text,$s);
			}
			if ($s1)
			{
				$sql_array[$set_function_text]=str_replace($olc_text,$olc_text,$s1);
			}
			if (sizeof($sql_array)>0)
			{
				olc_db_perform($table,$sql_array,UPDATE,
					$configuration_key_text.EQUAL.APOS.$configuration[$configuration_key_text].APOS);
			}
		}
		$sql_array=array($configuration_key_text=>$key,$configuration_value_text=>true);
		olc_db_perform($table,$sql_array);
	}
	define('DO_GROUP_CHECK',GROUP_CHECK==TRUE_STRING_S);
	define('DO_IMAGE_ON_THE_FLY',PRODUCT_IMAGE_ON_THE_FLY==TRUE_STRING_S);
	define('CURRENT_SCRIPT',basename($_SERVER['PHP_SELF']));
	define('USE_CACHE',false);			//Force Smarty cache off (this is a heap of crap!)
}
?>