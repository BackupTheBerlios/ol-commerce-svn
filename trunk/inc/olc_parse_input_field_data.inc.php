<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_parse_input_field_data.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
(c) 2003	    nextcommerce (olc_parse_input_field_data.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// Parse the data used in the html tags to ensure the tags will not break
function olc_parse_input_field_data($data, $parse)
{
	return strtr(trim($data), $parse);
}
?>