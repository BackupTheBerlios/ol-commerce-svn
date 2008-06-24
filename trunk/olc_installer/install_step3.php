<?php
/* --------------------------------------------------------------
$Id: install_step3.php,v 1.1.1.1.2.1 2007/04/08 07:18:30 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(install_2.php,v 1.4 2002/08/12); www.oscommerce.com
(c) 2003	    nextcommerce (install_step2.php,v 1.16 2003/08/1); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
(c) 2004  		OL - Commerce; www.ol-Commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application.php');
if (!xtc_in_array('database', $_POST['install']))
{
	ActivateProg($next_step_link);
}
if (xtc_db_connect($db[$db_server_text], $db[$db_username_text], $db[$db_password_text]))
{
	$db_error=xtc_db_test_create_db_permission($database);
}
else
{
	$db_error=true;
}
if ($db_error)
{
	install_error(TEXT_CONNECTION_ERROR);
	$post_data.='
	<tr>
		<td>
      <p><font size="1">'.HTML_BR.TEXT_DB_ERROR.'</font></p>
      <table border="0" style="text-align:left;width:100%">
		    <td class="error">'.HTML_NBSP.$db_error.'</td>
			</table>
      <p><font size="1">'.TEXT_DB_ERROR_1.'</font></p>
      <p><font size="1">'.TEXT_DB_ERROR_2.'</font></p>
  	 </td>
	</tr>
';
}
else
{
	$submit_onclick=' onclick="javascript:start_progress_indicator()"';
	$post_data.='
  <tr id="progress_container" style="display: none">
    <td>
      <table align="left" cellspacing="0" cellpadding="0">
        <tr>
          <td style="text-align:left">
          	<p><b>'.TEXT_DB_BEING_INSTALLED.'</b></p>
          	<!-- Helper field to be able to get the progressbars height and width from the stylessheet (progressbar_frame)!!! -->
          	<input class="progressbar_frame" type="text" style="display:none" id="fakebar"/>
          	<!-- Helper field to be able to get the progressbars height and width from the stylessheet (progressbar_frame)!!! -->
            <script type="text/javascript">
            	progress_bar=createBar(85,7,3,"");
            </script>
            <br/>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
  	<td>
			<table class="main_content_outer" cellspacing="0" cellpadding="0">
			  <tr>
			    <td class="header_image"></td>
			    <td class="header">'.TEXT_CONNECTION_SUCCESS.'</td>
			  </tr>
			</table>
			<p align="left"><font size="1">'.TEXT_PROCESS_1.'</font></p>
			<p align="left"><font size="1"><font color="red"><b>'.TEXT_PROCESS_2.'</b></font></font></p>
			<p align="left"><font size="1">'.TEXT_PROCESS_3.' <b>xtc_installer/prefix_olcommerce.	sql'.'</b>.</font></p>
    </td>
	</tr>
';
}
include('includes/program_frame.php');
?>
