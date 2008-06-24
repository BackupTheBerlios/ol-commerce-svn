<?php
/* --------------------------------------------------------------
$Id: start.php,v 1.1.1.1.2.1 2007/04/08 07:16:32 gswkaiser Exp $

neXTCommerce - ebusiness solutions
http://www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Copyright (c) 2003 neXTCommerce
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project
(c) 2002-2003 osCommerce coding standards (a typical file) www.oscommerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');
$_SESSION['ajax']=$_GET['ajax'];
if (USE_AJAX_ADMIN)
{
	$smarty->assign(BOX_LEFT2,HTML_NBSP);
	unset($_SESSION[BOX_LEFT2]);
}
$main_content='
<table border="0" width="96%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="100%" valign="top">
';
ob_start();
include(DIR_WS_MODULES.FILENAME_SECURITY_CHECK);
$main_content.=ob_get_contents();
ob_end_clean();
$main_content.='
   	</td>
 	</tr>
	<tr>
  	<td valign="top" align="center">
  		<iframe
  			width="100%"
  			height="500"
  			border="0"
  			src="http://www.ol-commerce.de/news/olc_information.html"
  			scrolling="auto"
  			class="admin_info"
  		>
  		</iframe>
    </td>
  </tr>
</table>
';
$page_header_title=HEADING_TITLE;
$page_header_subtitle=ADMIN_SUBTITLE_CENTRAL;
$page_header_icon_image=DIR_WS_ICONS.'heading_news.gif';
$show_column_right=true;
require(PROGRAM_FRAME);
