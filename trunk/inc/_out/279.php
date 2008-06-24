<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_db_perform.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com
(c) 2003	    nextcommerce (olc_db_perform.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link') {
	reset($data);
	if ($action == 'insert')
	{
		$query = INSERT_INTO . $table . LPAREN;
		while (list($columns, ) = each($data))
		{
			$query .= $columns . COMMA_BLANK;
		}
		$query = substr($query, 0, -2) . ') values (';
		reset($data);
		while (list($columns, $value) = each($data))
		{
			$value=(string)$value;
			switch ($value)
			{
				case 'now()':
					$query .= $value;
					break;
				case 'null':
					$query .= $value;
					break;
				default:
					$query .= APOS . olc_db_input($value) . APOS;
					break;
			}
			$query .= COMMA_BLANK;
		}
		$query = substr($query, 0, -2) . RPAREN;
	}
	else	//if ($action == 'update')
	{
		$query = SQL_UPDATE . $table . ' set ';
		while (list($columns, $value) = each($data))
		{
			$value=(string)$value;
			switch ($value)
			{
				case 'now()':
					$l_query =$value;
					break;
				case 'null':
					$l_query = $value;
					break;
				default:
					$l_query = APOS . olc_db_input($value) . APOS;
					break;
			}
			$query .= $columns . EQUAL.$l_query.COMMA_BLANK;
		}
		$query = substr($query, 0, -2) . SQL_WHERE . $parameters;
	}
	return olc_db_query($query, $link);
}
?>