<?php
//W. Kaiser - AJAX
/* -----------------------------------------------------------------------------------------
$Id: ajax_error.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:08 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

AJAX = Asynchronous JavaScript and XML
Info: http://de.wikipedia.org/wiki/Ajax_(Programmierung)

AJAX-error return routine

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de), w.kaiser@fortune.de

-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.18 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (shopping_cart.php,v 1.15 2003/08/17); www.nextcommerce.org

Released under the GNU General Public License
---------------------------------------------------------------------------------------
*/

function ajax_error($error_message,$fatal_error=true,$caption="",$add_on="")
{
	$error_message=strip_tags($error_message);
	if (USE_AJAX)
	{
		if ($fatal_error)
		{
			$error_delimiter = "fatal";
		}
		else
		{
			$error_delimiter = "recoverable";
			$error_message.="\n\n". $caption." trotzdem akzeptieren?";
		}
		$error_message=htmlentities($error_message,ENT_NOQUOTES);
		$error_delimiter = HASH.$error_delimiter."_error".HASH;
		$error_message=$error_delimiter. $error_message . $error_delimiter . $add_on;
	}
	else
	{
		$error_message="<script>alert('".$error_message."');history.back(1)</script>";
	}
	echo $error_message;
	exit();
}
?>