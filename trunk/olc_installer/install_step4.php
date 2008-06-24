<?php
/* --------------------------------------------------------------
$Id: install_step4.php,v 1.1.1.1.2.1 2007/04/08 07:18:30 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(install_3.php,v 1.6 2002/08/15); www.oscommerce.com
(c) 2004  		OL - Commerce; www.ol-Commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/
require('includes/application.php');
if (xtc_in_array('database', $_POST['install']))
{
	xtc_db_connect($_POST['DB_SERVER'], $_POST['DB_SERVER_USERNAME'], $_POST['DB_SERVER_PASSWORD']);
	$db_error = false;
	xtc_db_install($_POST['DB_DATABASE'],'prefix_olcommerce.sql',$table_prefix);
	if ($db_error)
	{
		install_error($db_error);
	}
	else
	{
		if ($language=='german')
		{
			$lang_par="'Deutsch','de'";
		}
		else
		{
			$lang_par="'English','en'";
		}
		$sql=INSERT_INTO.$table_prefix."languages VALUES (1,".$lang_par.",'icon.gif','".$language."',1,'iso-8859-15')";
		@xtc_db_query($sql);
		$post_data.='
  <tr>
    <td>
			<table class="main_content_outer" cellspacing="0" cellpadding="0">
			  <tr>
			    <td class="header_image"></td>
			    <td class="header">'.TEXT_TITLE_SUCCESS.'</td>
			  </tr>
			</table>
			<p align="center"><b>'.$parse_time.'</b></p>
    </td>
  </tr>
';
		if (xtc_in_array('configure', $_POST['install']))
		{
			$button=$continue_button_submit;
		}
		else
		{
			$button=$continue_button_link;
		}
		$button_box=str_replace(RIGHT_BUTTON,$button,$button_box0);
	}
}
$_SESSION['config_written']=false;
include('includes/program_frame.php');
?>
