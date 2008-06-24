<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_hide_session_id.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:36 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
(c) 2003	    nextcommerce (olc_hide_session_id.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/
// include needed functions
require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
// Hide form elements
function olc_hide_session_id() {
	global $session_started;

	if ($session_started)
	{
		if (defined('SID'))
		{
			if (olc_not_null(SID))
			{
				return olc_draw_hidden_field(olc_session_name(), olc_session_id());
			}
		}
	}
}
?>
