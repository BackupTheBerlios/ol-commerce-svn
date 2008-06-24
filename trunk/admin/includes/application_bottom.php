<?php
/* --------------------------------------------------------------
$Id: application_bottom.php,v 1.1.1.1.2.1 2007/04/08 07:16:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(application_bottom.php,v 1.8 2002/03/15); www.oscommerce.com
(c) 2003	    nextcommerce (application_bottom.php,v 1.6 2003/08/1); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require_once(DIR_FS_INC.'olc_get_parse_time.inc.php');
if (USE_SMARTY)
{
	get_main_content_from_buffer($smarty);
	require(DIR_WS_INCLUDES . 'footer.php');
	define('AJAX_TITLE',HEADING_TITLE);
	define('PARSE_TIME',$parse_time);
	$smarty->display(INDEX_HTML);
}
else
{
	echo $parse_time.'
		<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->
<br/>
<!-- footer_bof //-->
';
	require(DIR_WS_INCLUDES . 'footer.php');
	echo '
<!-- footer_eof //-->
</body>
</html>
';
}
?>