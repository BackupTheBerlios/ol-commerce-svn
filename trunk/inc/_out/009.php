<?php
//W. Kaiser - AJAX
/* -----------------------------------------------------------------------------------------
$Id: ajax_info.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:08 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

AJAX = Asynchronous JavaScript and XML
Info: http://de.wikipedia.org/wiki/Ajax_(Programmierung)

AJAX info-message return routine

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de), w.kaiser@fortune.de

-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.18 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (shopping_cart.php,v 1.15 2003/08/17); www.nextcommerce.org

Released under the GNU General Public License
---------------------------------------------------------------------------------------
*/

function ajax_info($message)
{
	if (IS_AJAX_PROCESSING)
	{
		if (defined('INFO_MESSAGE'))
		{
			$_SESSION[INFO_MESSAGE].=NEW_LINE;
		}
		else
		{
			define('INFO_MESSAGE','info_message');
		}
		$message=strip_tags($message);
		$message=htmlentities($message,ENT_NOQUOTES);
		$_SESSION[INFO_MESSAGE].=$message;
	}
}
?>