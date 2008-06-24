<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_output_warning.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
(c) 2003	    nextcommerce (olc_output_warning.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX
function olc_output_warning($warning, $force_errorBox=false) {
	if (IS_AJAX_PROCESSING && !$force_errorBox)
	{
		ajax_error($warning,true);
	}
	else
	{
		new errorBox(array(array('text' => HTML_BR . olc_image(DIR_WS_ICONS . 'warning.gif', ICON_WARNING) .
		BLANK . $warning . '<br/><br/>')));
	}
}
//W. Kaiser - AJAX
 ?>