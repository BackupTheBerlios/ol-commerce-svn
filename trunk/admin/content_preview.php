<?php
/* -----------------------------------------------------------------------------------------
   $Id: content_preview.php,v 1.1.1.1.2.1 2007/04/08 07:16:26 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	    nextcommerce (content_preview.php,v 1.2 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
require('includes/application_top.php');

if ($_GET['pID']=='media') {
	$content_query=olc_db_query("SELECT
 					content_file,
 					content_name,
 					file_comment
 					FROM ".TABLE_PRODUCTS_CONTENT."
 					WHERE content_id='".(int)$_GET['coID'].APOS);
 	$content_data=olc_db_fetch_array($content_query);
	
} else {
	 $content_query=olc_db_query("SELECT
 					content_title,
 					content_heading,
 					content_text,
 					content_file
 					FROM ".TABLE_CONTENT_MANAGER."
 					WHERE content_id='".(int)$_GET['coID'].APOS);
 	$content_data=olc_db_fetch_array($content_query);
 }
?>

<html <?php echo HTML_PARAMS; ?>>
<head>
<title><?php echo $page_title; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<div class="pageHeading">
	<?php 
		define('AJAX_TITLE',$content_data['content_heading']);
		echo AJAX_TITLE;
	?>
</div><br/>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main">
 <?php
 if ($content_data['content_file']!=''){
if (strpos($content_data['content_file'],'.txt')) echo '<pre>';
if ($_GET['pID']=='media') {
	// display image
	if (eregi('.gif',$content_data['content_file']) or eregi('.jpg',$content_data['content_file']) or  eregi('.png',$content_data['content_file']) or  eregi('.tif',$content_data['content_file']) or  eregi('.bmp',$content_data['content_file'])) {	
	echo olc_image(DIR_WS_CATALOG.'media/products/'.$content_data['content_file']);
	} else {
	include(DIR_FS_CATALOG.'media/products/'.$content_data['content_file']);	
	}
} else {
include(DIR_FS_CATALOG.'media/content/'.$content_data['content_file']);	
}
if (strpos($content_data['content_file'],'.txt')) echo '</pre>';
 } else {	      
echo $content_data['content_text'];
}
?>
</td>
          </tr>
        </table>







</body>
</html>