<?php
/* -----------------------------------------------------------------------------------------
$Id: program_frame.php,v 1.1.1.1.2.1 2007/04/08 07:16:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Standard admin programme framework

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------

Released under the GNU General Public License
-----------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX
if (NOT_USE_AJAX)
{
	require(DIR_WS_INCLUDES . 'header.php');
	echo '
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
';
	if ($no_left_menu)
	{
		$show_column_right=false;
	}
	else
	{
		echo '
    <td class="columnLeft2" nowrap="nowrap" valign="top">
	    <table border="0" cellspacing="0" cellpadding="0" class="columnLeft" nowrap="nowrap">
';
		if (!isset($show_column_right))
		{
			$show_column_right=true;
		}
		require(DIR_WS_INCLUDES . 'column_left.php');
	}
}
if ($page_header_icon_image)
{
	$page_header_icon_image=olc_image($page_header_icon_image);
}
$page_header='
    	<table border="0" width="100%" cellspacing="0" cellpadding="0">
	      <tr>
  	      <td colspan="10">
    	    	<table border="0" width="100%" cellspacing="0" cellpadding="0">
  						<tr>
    						<td width="80" rowspan="2">'.$page_header_icon_image.'</td>
    						<td class="pageHeading">'.$page_header_title.'</td>
	  					</tr>
';
if ($page_header_subtitle)
{
	$page_header.='
	  					<tr>
	    					<td colspan="2" class="pageSubHeading" valign="top">'.$page_header_subtitle.'</td>
	  					</tr>
';
}
$page_header.='
						</table>
					</td>
	      </tr>
	      <tr>
  	      <td class="main" valign="top">
  	      	'.$main_content. '
	        </td>
	      </tr>
	    </table>
';
if (USE_SMARTY)
{
	$smarty->assign(MAIN_CONTENT,$page_header);
	$smarty->display(INDEX_HTML);
}
else
{
	if (!$no_left_menu)
	{
		echo '
	    </table>
    </td>
';
	}
	echo '
    <td width="100%" valign="top">
'.$page_header.'
    </td>
';
	if ($show_column_right)
	{
		if (!$css_menu)
		{
			require(DIR_WS_INCLUDES . 'column_right.php');
		}
	}
	require(DIR_WS_INCLUDES . 'application_bottom.php');
	olc_exit();
}
//W. Kaiser - AJAX
?>
