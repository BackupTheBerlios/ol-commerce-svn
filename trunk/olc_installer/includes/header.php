<?php
/* --------------------------------------------------------------
$Id: header.php,v 1.1.1.1 2006/12/22 13:49:04 gswkaiser Exp $

OL-Commerce Version 2.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(application.php,v 1.4 2002/11/29); www.oscommerce.com
(c) 2003	    nextcommerce (application.php,v 1.16 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
(c) 2004  XT - Commerce; www.xt-ommerce.de

Released under the GNU General Public License
--------------------------------------------------------------*/
// W. Kaiser - AJAX
if ($include_form_check)
{
	require('includes/form_check.js.php');
}
else
{
	$script=EMPTY_STRING;
}
echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>OL-Commerce Installation - '.$title.'</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
'.$script.'
</head>
<body>
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  	<td colspan="2">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
			    <td width="150" align="center"><img src="images/logo.gif" title="OL-Commerce ist "Powered by AJAX"!"></td>
			    <td width="20">&nbsp;</td>
			    <td background="images/bg_top.jpg">&nbsp;</td>
			    <td width="20">&nbsp;</td>
			    <td width="115" align="center">
			    	<a href="http://de.wikipedia.org/wiki/Ajax_(Programmierung)"><img src="../images/ajax_logo.jpg"
							border="0" width="97" height="23" title="OL-Commerce ist "Powered by AJAX"!">
		  	  </td>
		  	</tr>
		  </table>
  	</td>
  </tr>
  <tr><td colspan="2"><br><br></td></tr>
  <tr>
    <td width="350" valign="top" bgcolor="F3F3F3" style="border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid; border-color: #6D6D6D;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="17" background="images/bg_left_blocktitle.gif">
<div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="FFAF00">
	olc: </font><font color="#999999">Installation</font></b></font></div></td>
        </tr>
        <tr>
          <td bgcolor="F3F3F3" ><br>
            <table width="95%" align="center" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="10">&nbsp;</td>
                <td width="135"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6">'.BOX_LANGUAGE.'</font></td>
';
?>