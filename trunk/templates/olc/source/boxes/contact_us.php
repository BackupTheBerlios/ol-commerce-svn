<?php
/* -----------------------------------------------------------------------------------------
$Id: contact_us.php,v 1.1.1.1 2006/12/22 14:52:27 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
(c) 2003	    nextcommerce; www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$file=FULL_CURRENT_TEMPLATE."contact_us".HTML_EXT;
if (is_file($file))
{
	olc_smarty_init($box_smarty,$cacheid);
	$box_smarty->assign('BOX_CONTENT', file_get_contents($file));
	$box_contact_us= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_contact_us'.HTML_EXT,$cacheid);
}
else
{
	$box_contact_us=HTML_NBSP;
}
$smarty->assign('box_CONTACT_US',$box_contact_us);
?>