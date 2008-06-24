<?php
//W. Kaiser - AJAX
/* -----------------------------------------------------------------------------------------
$Id: ajax_error.php,v 1.1.1.1 2006/12/22 13:42:05 gswkaiser Exp $

XT-Commerce - community made shopping
http://www.xt-commerce.com

AJAX = Asynchronous JavaScript and XML
Info: http://de.wikipedia.org/wiki/Ajax_(Programmierung)

AJAX-error return routine

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser, w.kaiser@fortune.de

-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.18 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (shopping_cart.php,v 1.15 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------
*/

function ajax_error($error_message,$fatal_error,$caption)
{
	if (USE_AJAX)
	{
		if ($smarty==null)
		{
			// Include Template Engine
			require(DIR_WS_CLASSES . 'smarty/Smarty.class.php');
			$smarty=new Smarty;
		}
		if ($fatal_error)
		{
			$error_delimiter = "fatal";
		}
		else
		{
			$error_delimiter = "recoverable";
			$error_message.="\n\n". $caption." trotzdem akzeptieren?";
		}
		$error_delimiter = HASH.$error_delimiter."_error".HASH;

		$error_message= $error_delimiter. $error_message . $error_delimiter;
	}
	else
	{
		$error_message="<script>alert('".$error_message."');history.back()</script>";
		//echo $error_message;
	}
	echo $error_message;
	exit();
}

?>