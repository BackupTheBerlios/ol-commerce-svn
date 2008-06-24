<?php
/* -----------------------------------------------------------------------------------------
   $Id: products_media.php,v 1.1.1.1.2.1 2007/04/08 07:18:02 gswkaiser Exp $   

   OL-Commerce Version 5.x/AJAX
   http://www.ol-commerce.com, http://www.seifenparadies.de

   Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	    nextcommerce (products_media.php,v 1.8 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

    Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/ 
olc_smarty_init($module_smarty,$cacheid);
$module_content=array();
$filename='';

// check if allowed to see
require_once(DIR_FS_INC.'olc_in_array.inc.php');
$check_query=olc_db_query("SELECT DISTINCT
				products_id
				FROM ".TABLE_PRODUCTS_CONTENT."
				WHERE languages_id='".SESSION_LANGUAGE_ID.APOS);
//$check_data=olc_db_fetch_array($check_query);

$check_data=array();
$i='0';
while ($content_data=olc_db_fetch_array($check_query)) {
 $check_data[$i]=$content_data['products_id'];
 $i++;
}
if (olc_in_array($_GET['products_id'],$check_data)) {
// get content data

require_once(DIR_FS_INC.'olc_filesize.inc.php');


//get download
$content_query=olc_db_query("SELECT
				content_id,
				content_name,
				content_link,
				content_file,
				content_read,
				file_comment
				FROM ".TABLE_PRODUCTS_CONTENT."
				WHERE
				products_id='".(int)$_GET['products_id']."' AND
				languages_id='".SESSION_LANGUAGE_ID.APOS);

				
	while ($content_data=olc_db_fetch_array($content_query)) {
	$filename='';	
	if ($content_data['content_link']!='')	{

	$icon= olc_image(DIR_WS_CATALOG.'admin/images/icons/icon_link.gif');
	} else {
	$icon= olc_image(DIR_WS_CATALOG.'admin/images/icons/icon_'.str_replace('.','',strstr($content_file,'.')).'.gif');
	}

	
	
	if ($content_data['content_link']!='')	$filename= HTML_A_START.$content_data['content_link'].'" target="new">';
	$filename.=  $content_data['content_name'];
	if ($content_data['content_link']!='') $filename.= HTML_A_END;
	
  if ($content_data['content_link']=='') 
  {
  	$content_file=$content_file;
	if (eregi(''.HTML_EXT,$content_file) 
	or eregi('.htm',$content_file)	
	or eregi('.txt',$content_file)
	or eregi('.bmp',$content_file)
	or eregi('.jpg',$content_file)
	or eregi('.gif',$content_file)
	or eregi('.png',$content_file)
	or eregi('.tif',$content_file)
	) 
	{
	

//W. Kaiser - AJAX
	 $button = '<a style="cursor:hand" onclick="javascript:ShowInfo(\''.olc_href_link(FILENAME_MEDIA_CONTENT,'coID='.
	 $content_data['content_id']).'\', \'\')">'. olc_image_button('button_view.gif',TEXT_VIEW).HTML_A_END;
//W. Kaiser - AJAX

	} else {

	$button= HTML_A_START.olc_href_link('media/products/'.$content_file).'">'.olc_image_button('button_download.gif',TEXT_DOWNLOAD).HTML_A_END;	
	
	}
	}	
$module_content[]=array(
			'ICON' => $icon,
			'FILENAME' => $filename,
			'DESCRIPTION' => $content_data['file_comment'],
			'FILESIZE' => olc_filesize($content_file),
			'BUTTON' => $button,
			'HITS' => $content_data['content_read']);
	} 
 
  $module_smarty->assign(MODULE_CONTENT,$module_content);
  $module= $module_smarty->fetch(CURRENT_TEMPLATE_MODULE . 'products_media'.HTML_EXT,$cacheid);
  $info_smarty->assign('MODULE_products_media',$module);
}
?>