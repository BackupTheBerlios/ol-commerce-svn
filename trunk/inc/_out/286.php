<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_db_test_create_db_permission.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:20 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(database.php,v 1.2 2002/03/02); www.oscommerce.com
(c) 2003	    nextcommerce (olc_db_test_create_db_permission.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_db_test_create_db_permission($database) {
	global $db_error;

	$db_created = false;
	$db_error = false;

	if ($database)
	{
		if (!$db_error) {
			if (!@olc_db_select_db($database)) {
				$db_created = true;
				if (!@olc_db_query_installer('create database ' . $database)) {
					$db_error = true;
				}
			} else {
				$db_error = true;
			}
			if (!$db_error) {
				if (@olc_db_select_db($database)) {
					if (@olc_db_query_installer('create table temp ( temp_id int(5) )')) {
						if (@olc_db_query_installer('drop table temp')) {
							if ($db_created) {
								if (@olc_db_query_installer('drop database ' . $database)) {
								} else {
									$db_error = true;
								}
							}
						} else {
							$db_error = true;
						}
					} else {
						$db_error = true;
					}
				} else {
					$db_error = true;
				}
			}
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
		} else {
			return true;
		}
	}
	else
	{
		$db_error = 'Keine Datenbank gewählt.';
		return false;
	}
}
?>