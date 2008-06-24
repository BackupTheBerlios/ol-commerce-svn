<?php
/* --------------------------------------------------------------
$Id: index.php,v 1.1.1.1.2.1 2007/04/08 07:18:30 gswkaiser Exp $

OL-Commerce Version 2.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (index.php,v 1.18 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
(c) 2004  		OL - Commerce; www.ol-Commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

//header('Location: install_step1.php');
$action='install_step1.php';
$parameter='';
if ($_GET)
{
	while (list($key,$value)=each($_GET))
	{
		if ($parameter)
		{
			$parameter.='&';
		}
		$parameter.=$key.'='.$value;
	}
	$action.='?'.$parameter;;
}
$html='
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
	<head>
	<noscript>
		<meta http-equiv="refresh" content="0;
			URL=ajax_error.php?reason=no_javascript&request_url='.$action.'"/>
	</noscript>
	</head>
	<body onload="script_check.submit();">
		<form method="post" action="'.$action.'" name="script_check">
			<input type="hidden" name="ajax" value="true">
		</form>
	</body>
</html>
';
echo $html;
?>
