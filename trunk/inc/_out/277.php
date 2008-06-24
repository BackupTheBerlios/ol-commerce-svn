<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_db_num_rows.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com
(c) 2003	    nextcommerce (olc_db_num_rows.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_db_num_rows(&$recordset,$cq=false) {
	if (USE_ADODB===true)
	{
		if (DB_CACHE==TRUE_STRING_S && $cq) {
			if (!count($recordset)) return false;
			return count($recordset);
		} else {
			if ($recordset)
			{
				return $recordset->RecordCount();
			}
			else
			{
				$cq=$cq;
			}
		}
	}
	else
	{
		if (DB_CACHE==TRUE_STRING_S && $cq) {
			if (!count($recordset)) return false;
			return count($recordset);
		} else {
			if (!is_array($recordset)) return mysql_num_rows($recordset);
		}
	}
}
?>