<?
/* --------------------------------------------------------------
$Id: footer.php,v 1.1.1.1.2.1 2007/04/08 07:16:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(footer.php,v 1.12 2003/02/17); www.oscommerce.com
(c) 2003	    nextcommerce (footer.php,v 1.11 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/
if (NOT_IS_AJAX_PROCESSING)
{
	$footer='
<!-- footer bof //-->
<br/>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td align="center" class="smallText"><b>Powered by
    	<a href="http://www.ol-commerce.de" target="_blank"><span class="smallText">'.PROJECT_VERSION.'</span></a></b>
    </td>
  </tr>
  <tr>
    <td align="center" class="smallText">
<!--
  The following copyright announcement is in compliance
  to section 2c of the GNU General Public License, and
  thus can not be removed, or can only be modified
  appropriately.

  Please leave this comment intact together with the
  following copyright announcement.

  Copyright announcement changed due to the permissions
  from LG Hamburg from 28th February 2003 / AZ 308 O 70/03
-->
E-Commerce Engine Copyright &copy; 2003
<a href="http://www.xt-commerec.com" target="_blank"><span class="smallText">XT-Commerce</span></a><br/>
XT-Commerce provides no warranty and is redistributable under the
<a href="http://www.fsf.org/licenses/gpl.txt" target="_blank"><span class="smallText">GNU General Public License</span></a>
		</td>
  </tr>
  <tr>
    <td>
			<table border="0" cellspacing="2" cellpadding="2" align="center">
			  <tr>
			    <td class="smallText" valign="top"><b>Überarbeitet von </b></td>
			    <td class="smallText" valign="top">
			    	<a href="http://www.ol-commerce.de" target="_blank"><span class="smallText">OL-Commerce</span></a>
			    	<br />'.PROJECT_VERSION.':
			    	<a href="http://www.seifenparadies.de" target="_blank"><span class="smallText">Dipl.-Ing.(TH) Winfried Kaiser</span></a>
			    </td>
			  </tr>
			</table>
    </td>
  </tr>
</table>
<!-- footer_eof //-->
';
	if (USE_AJAX)
	{
		$smarty->assign("FOOTER",$footer);
	}
	else
	{
		echo $footer;
	}
}
?>