<?php
/* --------------------------------------------------------------
$Id: column_left_header_icon.php,v 1.1.1.1.2.1 2007/04/08 07:16:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project (earlier name of osCommerce)
(c) 2002-2003 osCommerce(column_left.php,v 1.15 2002/01/11); www.oscommerce.com
(c) 2003	    nextcommerce (column_left.php,v 1.25 2003/08/19); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require(DIR_WS_INCLUDES . 'column_left.php');
echo '
			<table border="0" width="100%" cellspacing="0" cellpadding="2">
	      <tr>
	        <td width="100%">
	        	<table border="0" width="100%" cellspacing="0" cellpadding="0">
						  <tr>
    						<td width="80" rowspan="2">'.olc_image(DIR_WS_ICONS.$icon).'</td>
		            <td class="pageHeading">'.$heading_title.'</td>
  						</tr>
		        </table>
		      </td>
	      </tr>
';
$heading_title=EMPTY_STRING;
?>