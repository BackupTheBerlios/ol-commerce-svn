<?php
/* -----------------------------------------------------------------------------------------
   $Id: fernag.php,v 1.4 2004/02/22 16:15:30 fanta2k Exp $

   OL-Commerce Version 2.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
olc_smarty_init($box_smarty,$cacheid);
$content_string ='';
$content_query=olc_db_query("SELECT
 					content_id,
 					categories_id,
 					parent_id,
 					content_title,
 					content_group
 					FROM ".TABLE_CONTENT_MANAGER."
 					WHERE languages_id='".SESSION_LANGUAGE_ID."'
 					and file_flag=0 and content_status=1");
 while ($content_data=olc_db_fetch_array($content_query)) {
 	
 $content_string .= HTML_A_START . olc_href_link(FILENAME_CONTENT,'coID='.$content_data['content_group']) . '">' . 
 	$content_data['content_title'] . '</a><br/>';
}

 if ($content_string!='') {
  $box_smarty->assign('BOX_CONTENT',$content_string);
  $box_fernag= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.'box_fernag'.HTML_EXT,$cacheid);
  $smarty->assign('box_FERNAG',$box_fernag);
  }  
 ?>