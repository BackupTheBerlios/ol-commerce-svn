<?php
/* --------------------------------------------------------------
$Id: content_manager.php,v 1.1.1.1.2.1 2007/04/08 07:16:26 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommercecoding standards www.oscommerce.com
(c) 2003	    nextcommerce (content_manager.php,v 1.18 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contribution:
SPAW PHP WYSIWYG editor  Copyright: Solmetra (c)2003 All rights reserved. | www.solmetra.com
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');
require_once(DIR_FS_INC.'olc_format_filesize.inc.php');
require_once(DIR_FS_INC.'olc_filesize.inc.php');

$languages = olc_get_languages();
$id=$_GET['id'];
$coID=(int)$_GET['coID'];
$coID_POST=olc_db_prepare_input($_POST['coID']);
$special=$_GET['special'];
$action=$_GET['action'];
$not_action=!$action;
$pID=$_GET['pID'];
if ($special=='delete' || $special=='delete_product')
{
	$delete_from=DELETE_FROM;
	$where=" where content_id='".$coID.APOS;
	if ($special=='delete')
	{
		$table=TABLE_CONTENT_MANAGER;
	} // if get special
	else
	{
		$table=TABLE_PRODUCTS_CONTENT;
		$parameter='pID='.$pID;
	} // if get special
	olc_db_query($delete_from.$table.$where);
	olc_redirect(olc_href_link(FILENAME_CONTENT_MANAGER,$parameter));
}
elseif ($id=='update' or $id=='insert')
{
	$content_title=olc_db_prepare_input($_POST['cont_title']);
	$content_language=olc_db_prepare_input($_POST['language']);
	$upload_file=olc_db_prepare_input($_POST['file_upload']);
	$select_file=olc_db_prepare_input($_POST['select_file']);

	$content_header=olc_db_prepare_input($_POST['cont_heading']);
	$content_text=olc_db_prepare_input($_POST['cont']);
	$content_status=olc_db_prepare_input($_POST['status']);
	$file_flag=olc_db_prepare_input($_POST['file_flag']);
	$parent_check=olc_db_prepare_input($_POST['parent_check']);
	$parent_id=olc_db_prepare_input($_POST['parent']);
	$group_id=olc_db_prepare_input($_POST['content_group']);
	$coID=$coID_POST;
	for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
		if ($languages[$i]['code']==$content_language) $content_language=$languages[$i]['id'];
	} // for

	$error=false; // reset error flag
	if (strlen($content_title) < 1) {
		$error = true;
		$messageStack->add(ERROR_TITLE,'error');
	}  // if

	if ($content_status=='yes'){
		$content_status=1;
	} else{
		$content_status=0;
	}  // if

	if ($parent_check=='yes'){
		$parent_id=$parent_id;
	} else{
		$parent_id='0';
	}  // if
	if (!$error)
	{
		// file upload
		if ($select_file!='default') $content_file_name=$select_file;
		if ($content_file = new upload('file_upload', DIR_FS_CATALOG.'media/content/'))
		{
			$content_file_name=$content_file->filename;
		}  // if
		// update data in table
		$sql_data_array = array(
		'languages_id' => $content_language,
		'content_title' => $content_title,
		'content_heading' => $content_header,
		'content_text' => $content_text,
		'content_file' => $content_file_name,
		'content_status' => $content_status,
		'parent_id' => $parent_id,
		'content_group' => $group_id,
		'file_flag' => $file_flag);
		if ($_GET['id']=='update')
		{
			olc_db_perform(TABLE_CONTENT_MANAGER, $sql_data_array, 'update', "content_id = '" . $coID . APOS);
		} else {
			olc_db_perform(TABLE_CONTENT_MANAGER, $sql_data_array);
		} // if get id
		olc_redirect(olc_href_link(FILENAME_CONTENT_MANAGER));
	} // if error
} // if
elseif ($id=='update_product' or $id=='insert_product')
{
	$content_title=olc_db_prepare_input($_POST['cont_title']);
	$content_language=olc_db_prepare_input($_POST['language']);
	$upload_file=olc_db_prepare_input($_POST['file_upload']);
	$select_file=olc_db_prepare_input($_POST['select_file']);

	$content_link=olc_db_prepare_input($_POST['cont_link']);
	$product=olc_db_prepare_input($_POST['product']);
	$filename=olc_db_prepare_input($_POST['file_name']);
	$file_comment=olc_db_prepare_input($_POST['file_comment']);

	$coID=$coID_POST;
	$error=false; // reset error flag
	for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
		if ($languages[$i]['code']==$content_language) $content_language=$languages[$i]['id'];
	} // for
	if (strlen($content_title) < 1) {
		$error = true;
		$messageStack->add(ERROR_TITLE,'error');
	}  // if
	if (!$error )
	{
		/* mkdir() wont work with php in safe_mode
		if  (!is_dir(DIR_FS_CATALOG.'media/products/'.$product.'/')) {
		$old_umask = umask(0);
		olc_mkdirs(DIR_FS_CATALOG.'media/products/'.$product.'/',0777);
		umask($old_umask);
		}
		*/
		if ($select_file=='default') {
			if ($content_file = new upload('file_upload', DIR_FS_CATALOG.'media/products/')) {
				$content_file_name=$content_file->filename;
				$old_filename=$content_file->filename;
				$timestamp=str_replace('.',EMPTY_STRING,microtime());
				$timestamp=str_replace(BLANK,EMPTY_STRING,$timestamp);
				$content_file_name=$timestamp.strstr($content_file_name,'.');
				$rename_string=DIR_FS_CATALOG.'media/products/'.$content_file_name;
				rename(DIR_FS_CATALOG.'media/products/'.$old_filename,$rename_string);
				copy($rename_string,DIR_FS_CATALOG.'media/products/backup/'.$content_file_name);
			}
			if ($content_file_name==EMPTY_STRING) $content_file_name=$filename;
		} else {
			$content_file_name=$select_file;
		}
		// if
		// update data in table
		$sql_data_array = array(
		'products_id' => $product,
		'content_name' => $content_title,
		'content_file' => $content_file_name,
		'content_link' => $content_link,
		'file_comment' => $file_comment,
		'languages_id' => $content_language);
		if ($_GET['id']=='update_product') {
			olc_db_perform(TABLE_PRODUCTS_CONTENT, $sql_data_array, 'update', "content_id = '" . $coID . APOS);
			$content_id = olc_db_insert_id();
		} else {
			olc_db_perform(TABLE_PRODUCTS_CONTENT, $sql_data_array);
			$content_id = olc_db_insert_id();
		} // if get id
		// rename filename
		olc_redirect(olc_href_link(FILENAME_CONTENT_MANAGER,'pID='.$product));
	}// if error
}
?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="columnLeft2" nowrap="nowrap" valign="top"><table border="0" cellspacing="1" cellpadding="1" nowrap="nowrap">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="80" rowspan="2"><?php echo olc_image(DIR_WS_ICONS.'heading_content.gif'); ?></td>
    <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
  </tr>
  <tr>
    <td class="main" valign="top">OLC Hilfsprogramme</td>
  </tr>
</table>
</td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0">
          <tr>
            <td>
<?php
if ($not_action)
{
?>
<div class="pageHeading"><br/><?php echo HEADING_CONTENT; ?><br/></div>
<div class="main"><?php echo CONTENT_NOTE; ?></div>
 <?php
 olc_spaceUsed(DIR_FS_CATALOG.'media/content/');
 echo '<div class="main">'.USED_SPACE.olc_format_filesize($total).'</div>';
?>
<?php
// Display Content
for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
	$content=array();
	$content_query=olc_db_query("SELECT
                                        content_id,
                                        categories_id,
                                        parent_id,
                                        languages_id,
                                        content_title,
                                        content_heading,
                                        content_text,
                                        file_flag,
                                        content_file,
                                        content_status,
                                        content_group,
                                        content_delete
                                        FROM ".TABLE_CONTENT_MANAGER."
                                        WHERE languages_id='".$languages[$i]['id']."'
                                        AND parent_id='0'");
	while ($content_data=olc_db_fetch_array($content_query)) {
		$content[]=array(
		'CONTENT_ID' =>$content_data['content_id'] ,
		'PARENT_ID' => $content_data['parent_id'],
		'LANGUAGES_ID' => $content_data['languages_id'],
		'CONTENT_TITLE' => $content_data['content_title'],
		'CONTENT_HEADING' => $content_data['content_heading'],
		'CONTENT_TEXT' => $content_data['content_text'],
		'FILE_FLAG' => $content_data['file_flag'],
		'CONTENT_FILE' => $content_data['content_file'],
		'CONTENT_DELETE' => $content_data['content_delete'],
		'CONTENT_GROUP' => $content_data['content_group'],
		'CONTENT_STATUS' => $content_data['content_status']);
	} // while content_data
?>
<br/>
<div class="main"><?php echo olc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']).'&nbsp;&nbsp;'.
	$languages[$i]['name']; ?></div>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr class="dataTableHeadingRow">
    <td class="dataTableHeadingContent" width="10" ><?php echo TABLE_HEADING_CONTENT_ID; ?></td>
    <td class="dataTableHeadingContent" width="10" >&nbsp;</td>
    <td class="dataTableHeadingContent" width="30%" align="left"><?php echo TABLE_HEADING_CONTENT_TITLE; ?></td>
    <td class="dataTableHeadingContent" width="1%" align="middle"><?php echo TABLE_HEADING_CONTENT_GROUP; ?></td>
    <td class="dataTableHeadingContent" width="25%"align="left"><?php echo TABLE_HEADING_CONTENT_FILE; ?></td>
    <td class="dataTableHeadingContent" nowrap="nowrap" width="5%" align="left"><?php echo TABLE_HEADING_CONTENT_STATUS; ?></td>
    <td class="dataTableHeadingContent" nowrap="nowrap" width="" align="middle"><?php echo TABLE_HEADING_CONTENT_BOX; ?></td>
    <td class="dataTableHeadingContent" width="30%" align="middle"><?php echo TABLE_HEADING_CONTENT_ACTION; ?>&nbsp;</td>
  </tr>
 <?php
 for ($ii = 0, $nn = sizeof($content); $ii < $nn; $ii++) {
 	$file_flag_sql = olc_db_query("SELECT file_flag_name FROM " . TABLE_CM_FILE_FLAGS . " WHERE file_flag=" .
 	$content[$ii]['FILE_FLAG']);
 	$file_flag_result = olc_db_fetch_array($file_flag_sql);
 	echo '
 	<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\'" onmouseout="this.className=\'dataTableRow\'">' . NEW_LINE;
 	if ($content[$ii]['CONTENT_FILE']==EMPTY_STRING) $content[$ii]['CONTENT_FILE']='database';
 ?>
 <td class="dataTableContent" align="left"><?php echo $content[$ii]['CONTENT_ID']; ?></td>
 <td bgcolor="<?php echo substr((6543216554/$content[$ii]['CONTENT_GROUP']),0,6); ?>" class="dataTableContent" align="left">&nbsp;</td>
 <td class="dataTableContent" align="left"><?php echo $content[$ii]['CONTENT_TITLE']; ?>
 <?php
 if ($content[$ii]['CONTENT_DELETE']=='0'){
 	echo '<font color="ff0000">*</font>';
} ?>
 </td>
 <td class="dataTableContent" align="middle"><?php echo $content[$ii]['CONTENT_GROUP']; ?></td>
 <td class="dataTableContent" align="left"><?php echo $content[$ii]['CONTENT_FILE']; ?></td>
 <td class="dataTableContent" align="middle"><?php if ($content[$ii]['CONTENT_STATUS']==0) { echo TEXT_NO; } else { echo TEXT_YES; } ?></td>
 <td class="dataTableContent" align="middle"><?php echo $file_flag_result['file_flag_name']; ?></td>
 <td class="dataTableContent" align="right">
 <a href="">
<?php
if ($content[$ii]['CONTENT_DELETE']=='1'){
?>
 <a href="<?php echo olc_href_link(FILENAME_CONTENT_MANAGER,'special=delete&coID='.$content[$ii]['CONTENT_ID']); ?>" onclick="javascript:return confirm('<?php echo CONFIRM_DELETE; ?>')">
 <?php echo olc_image(DIR_WS_ICONS.'delete.gif','Delete',EMPTY_STRING,EMPTY_STRING,'style="cursor:hand" onclick="javascript:return confirm(\''.DELETE_ENTRY.'\')"').'  '.TEXT_DELETE.'</a>&nbsp;&nbsp;';
} // if content
?>
 <a href="<?php echo olc_href_link(FILENAME_CONTENT_MANAGER,'action=edit&coID='.$content[$ii]['CONTENT_ID']); ?>">
<?php echo olc_image(DIR_WS_ICONS.'icon_edit.gif','Edit',EMPTY_STRING,EMPTY_STRING,'style="cursor:hand"').'  '.TEXT_EDIT.HTML_A_END; ?>
 <a style="cursor:hand" onclick="javascript:window.open('<?php echo olc_href_link(FILENAME_CONTENT_PREVIEW,'pop_up=true&coID='.$content[$ii]['CONTENT_ID']); ?>', 'popup', 'toolbar=0, width=640, height=600')"><?php echo olc_image(DIR_WS_ICONS.'preview.gif','Preview',EMPTY_STRING,EMPTY_STRING,'style="cursor:hand"').'&nbsp;&nbsp;'.TEXT_PREVIEW.HTML_A_END; ?>
 </td>
 </tr>

 <?php
 $content_1=EMPTY_STRING;
 $content_1_query=olc_db_query("SELECT
                                        content_id,
                                        categories_id,
                                        parent_id,
                                        languages_id,
                                        content_title,
                                        content_heading,
                                        content_text,
                                        file_flag,
                                        content_file,
                                        content_status,
                                        content_delete
                                        FROM ".TABLE_CONTENT_MANAGER."
                                        WHERE languages_id='".$i."'
                                        AND parent_id='".$content[$ii]['CONTENT_ID'].APOS);
 while ($content_1_data=olc_db_fetch_array($content_1_query)) {

 	$content_1[]=array(
 	'CONTENT_ID' =>$content_1_data['content_id'] ,
 	'PARENT_ID' => $content_1_data['parent_id'],
 	'LANGUAGES_ID' => $content_1_data['languages_id'],
 	'CONTENT_TITLE' => $content_1_data['content_title'],
 	'CONTENT_HEADING' => $content_1_data['content_heading'],
 	'CONTENT_TEXT' => $content_1_data['content_text'],
 	'FILE_FLAG' => $content_1_data['file_flag'],
 	'CONTENT_FILE' => $content_1_data['content_file'],
 	'CONTENT_DELETE' => $content_1_data['content_delete'],
 	'CONTENT_STATUS' => $content_1_data['content_status']);
 }
 for ($a = 0, $x = sizeof($content_1); $a < $x; $a++) {
 	if ($content_1[$a]!=EMPTY_STRING) {
 		$file_flag_sql = olc_db_query("SELECT file_flag_name FROM " . TABLE_CM_FILE_FLAGS . " WHERE file_flag=" . $content_1[$a]['FILE_FLAG']);
 		$file_flag_result = olc_db_fetch_array($file_flag_sql);
 		echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\'" onmouseout="this.className=\'dataTableRow\'">' . NEW_LINE;

 		if ($content_1[$a]['CONTENT_FILE']==EMPTY_STRING) $content_1[$a]['CONTENT_FILE']='database';
 ?>
 <td class="dataTableContent" align="left"><?php echo $content_1[$a]['CONTENT_ID']; ?></td>
 <td class="dataTableContent" align="left">--<?php echo $content_1[$a]['CONTENT_TITLE']; ?></td>
 <td class="dataTableContent" align="left"><?php echo $content_1[$a]['CONTENT_FILE']; ?></td>
 <td class="dataTableContent" align="middle">
 <?php if ($content_1[$a]['CONTENT_STATUS']==0) { echo TEXT_NO; } else { echo TEXT_YES; } ?>
 </td>
 <td class="dataTableContent" align="middle"><?php echo $file_flag_result['file_flag_name']; ?></td>
 <td class="dataTableContent" align="right">
 <a href="">
<?php
if ($content_1[$a]['CONTENT_DELETE']=='1'){
?>
 <a href="<?php echo olc_href_link(FILENAME_CONTENT_MANAGER,'special=delete&coID='.$content_1[$a]['CONTENT_ID']); ?>" onclick="javascript:return confirm('<?php echo CONFIRM_DELETE; ?>')">
 <?php echo olc_image(DIR_WS_ICONS.'delete.gif','Delete',EMPTY_STRING,EMPTY_STRING,'style="cursor:hand" onclick="javascript:return confirm(\''.DELETE_ENTRY.'\')"').'  '.TEXT_DELETE.'</a>&nbsp;&nbsp;';
} // if content
?>
 <a href="<?php echo olc_href_link(FILENAME_CONTENT_MANAGER,'action=edit&coID='.$content_1[$a]['CONTENT_ID']); ?>">
<?php echo olc_image(DIR_WS_ICONS.'icon_edit.gif','Edit',EMPTY_STRING,EMPTY_STRING,'style="cursor:hand"').'  '.TEXT_EDIT.HTML_A_END; ?>
 <a style="cursor:hand" onclick="javascript:window.open('<?php echo olc_href_link(FILENAME_CONTENT_PREVIEW,'pop_up=true&coID='.$content_1[$a]['CONTENT_ID']); ?>', 'popup', 'toolbar=0, width=640, height=600')" ><?php echo olc_image(DIR_WS_ICONS.'preview.gif','Preview',EMPTY_STRING,EMPTY_STRING,'style="cursor:hand"').'&nbsp;&nbsp;'.TEXT_PREVIEW.HTML_A_END; ?>
 </td>
 </tr>


<?php
 	}
 } // for content
 } // for language
?>
</table>


<?php
}
}
else
{

	switch ($action)
	{
		// Diplay Editmask
		case 'new':
		case 'edit':
			if ($action!='new')
			{
				$content_query=olc_db_query("SELECT
                                        content_id,
                                        categories_id,
                                        parent_id,
                                        languages_id,
                                        content_title,
                                        content_heading,
                                        content_text,
                                        file_flag,
                                        content_file,
                                        content_status,
                                        content_group,
                                        content_delete
                                        FROM ".TABLE_CONTENT_MANAGER."
                                        WHERE content_id='".$coID.APOS);

				$content=olc_db_fetch_array($content_query);
			}
			$languages_array = array();
			for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {

				if ($languages[$i]['id']==$content['languages_id']) {
					$languages_selected=$languages[$i]['code'];
					$languages_id=$languages[$i]['id'];
				}
				$languages_array[] = array('id' => $languages[$i]['code'],
				'text' => $languages[$i]['name']);

			} // for
			if ($languages_id!=EMPTY_STRING) $query_string='languages_id='.$languages_id.' AND';
			$categories_query="SELECT
                        content_id,
                        content_title
                        FROM ".TABLE_CONTENT_MANAGER."
                        WHERE ".$query_string." parent_id='0'
                        AND content_id!='".$coID.APOS;
			$categories_query=olc_db_query($categories_query);
			while ($categories_data=olc_db_fetch_array($categories_query)) {
				$categories_array[]=array(
				'id'=>$categories_data['content_id'],
				'text'=>$categories_data['content_title']);
			}
?>
<br/><br/>
<?php
if ($action!='new')
{
	$function='update';
} else {
	$function='insert';
}
echo olc_draw_form('edit_content',FILENAME_CONTENT_MANAGER,'action=edit&id='.$function.'&coID='.$coID,'post',
'enctype="multipart/form-data"').olc_draw_hidden_field('coID',$coID);
?>
<table class="main" width="100%" border="0">
   <tr>
      <td width="10%"><?php echo TEXT_LANGUAGE; ?></td>
      <td width="90%"><?php echo olc_draw_pull_down_menu('language',$languages_array,$languages_selected); ?></td>
   </tr>
<?php
if ($content['content_delete']!=0 or $action=='new') {
?>
      <tr>
      <td width="10%"><?php echo TEXT_GROUP; ?></td>
      <td width="90%">
		    <?php echo olc_draw_input_field('content_group',$content['content_group'],'size="5"').BLANK.TEXT_GROUP_DESC; ?>
      </td>
   </tr>
<?php
}
else
{
	echo olc_draw_hidden_field('content_group',$content['content_group']);
?>
      <tr>
      <td width="10%"><?php echo TEXT_GROUP; ?></td>
      <td width="90%"><?php echo $content['content_group']; ?></td>
   </tr>
<?php
}
$file_flag_sql = olc_db_query("SELECT file_flag as id, file_flag_name as text FROM " . TABLE_CM_FILE_FLAGS);
while($file_flag = olc_db_fetch_array($file_flag_sql))
{
	$file_flag_array[] = array('id' => $file_flag['id'], 'text' => $file_flag['text']);
}
?>
      <tr>
      <td width="10%"><?php echo TEXT_FILE_FLAG; ?></td>
      <td width="90%"><?php echo olc_draw_pull_down_menu('file_flag',$file_flag_array,$content['file_flag']); ?></td>
   </tr>
<?php
/*  build in not completed yet
<tr>
<td width="10%"><?php echo TEXT_PARENT; ?></td>
<td width="90%"><?php echo olc_draw_pull_down_menu('parent',$categories_array,$content['parent_id']); ?><?php echo olc_draw_checkbox_field('parent_check', 'yes',false).BLANK.TEXT_PARENT_DESCRIPTION; ?></td>
</tr>
*/
?>
      <tr>
      <td valign="top" width="10%"><?php echo TEXT_STATUS; ?></td>
      <td width="90%"><?php
      if ($content['content_status']=='1') {
      	echo olc_draw_checkbox_field('status', 'yes',true).BLANK.TEXT_STATUS_DESCRIPTION;
      } else {
      	echo olc_draw_checkbox_field('status', 'yes',false).BLANK.TEXT_STATUS_DESCRIPTION;
      }

      ?><br/><br/></td>
   </tr>
   <tr>
      <td width="10%"><?php echo TEXT_TITLE; ?></td>
      <td width="90%"><?php echo olc_draw_input_field('cont_title',$content['content_title'],'size="60"'); ?></td>
   </tr>
   <tr>
      <td width="10%"><?php echo TEXT_HEADING; ?></td>
      <td width="90%"><?php echo olc_draw_input_field('cont_heading',$content['content_heading'],'size="60"'); ?></td>
   </tr>
   <tr>
      <td width="10%" valign="top"><?php echo TEXT_UPLOAD_FILE; ?></td>
      <td width="90%"><?php echo olc_draw_file_field('file_upload').BLANK.TEXT_UPLOAD_FILE_LOCAL; ?></td>
   </tr>
         <tr>
      <td width="10%" valign="top"><?php echo TEXT_CHOOSE_FILE; ?></td>
      <td width="90%">
<?php
if ($dir= opendir(DIR_FS_CATALOG.'media/content/')){
	while  (($file = readdir($dir)) !==false) {
		if (is_file( DIR_FS_CATALOG.'media/content/'.$file) and ($file !="index.html")){
			$files[]=array(
			'id' => $file,
			'text' => $file);
		}//if
	} // while
	closedir($dir);
}
// set default value in dropdown!
if ($content['content_file']==EMPTY_STRING) {
	$default_array[]=array('id' => 'default','text' => TEXT_SELECT);
	$default_value='default';
	$files=array_merge($default_array,$files);
} else {
	$default_array[]=array('id' => 'default','text' => TEXT_NO_FILE);
	$default_value=$content['content_file'];
	$files=array_merge($default_array,$files);
}
echo HTML_BR.TEXT_CHOOSE_FILE_SERVER.'</br>';
echo olc_draw_pull_down_menu('select_file',$files,$default_value);
if ($content['content_file']!=EMPTY_STRING) {
	echo TEXT_CURRENT_FILE.' <b>'.$content['content_file'].'</b><br/>';
}
?>
      </td>
      </td>
   </tr>
   <tr>
      <td width="10%" valign="top"></td>
      <td colspan="90%" valign="top"><br/><?php echo TEXT_FILE_DESCRIPTION; ?></td>
   </tr>
   <tr>
      <td width="10%" valign="top"><?php echo TEXT_CONTENT; ?></td>

      <td width="90%">
   <?php
   $s='cont';
   $content_text=stripslashes($content['content_text']);
   if (USE_SPAW)
   {
   	$sw = new SPAW_Wysiwyg
   	(
   	$control_name=$s, // control's name
   	$value=$content_text,                  // initial value
   	$lang=EMPTY_STRING,                   // language
   	$mode = 'full',                 // toolbar mode
   	$theme='default',                  // theme (skin)
   	$width='100%',              // width
   	$height='500px',            // height
   	$css_stylesheet=SPAW_STYLESHEET,         // css stylesheet file for content
   	$dropdown_data=EMPTY_STRING           // data for dropdowns (style, font, etc.)
   	);
   	$sw->show();
   }
   else
   {
   	echo olc_draw_textarea_field($s,EMPTY_STRING,'100','35',$content_text);
   }
?>
      </td>
   </tr>
    <tr>
        <td colspan="2" align="right" class="main"><?php echo olc_image_submit('button_save.gif', IMAGE_SAVE); ?>
        <a href="<?php echo olc_href_link(FILENAME_CONTENT_MANAGER); ?>"><?php echo olc_image_button('button_back.gif', IMAGE_BACK); ?></a></td>
   </tr>
</table>
</form>
<?php
break;
		case 'edit_products_content':
		case 'new_products_content':
			if ($action=='edit_products_content') {
				$content_query=olc_db_query("SELECT
                                        content_id,
                                        products_id,
                                        content_name,
                                        content_file,
                                        content_link,
                                        languages_id,
                                        file_comment,
                                        content_read
                                        FROM ".TABLE_PRODUCTS_CONTENT."
                                        WHERE content_id='".$coID.APOS);

				$content=olc_db_fetch_array($content_query);
			}
			// get products names.
			$products_query=olc_db_query("SELECT
                                products_id,
                                products_name
                                FROM ".TABLE_PRODUCTS_DESCRIPTION."
                                WHERE language_id='".SESSION_LANGUAGE_ID.APOS);
			$products_array=EMPTY_STRING;
			while ($products_data=olc_db_fetch_array($products_query)) {
				$products_array[]=array(
				'id' => $products_data['products_id'],
				'text' => $products_data['products_name']);
			}

			// get languages
			$languages_array = array();
			for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
				if ($languages[$i]['id']==$content['languages_id']) {
					$languages_selected=$languages[$i]['code'];
					$languages_id=$languages[$i]['id'];
				}
				$languages_array[] = array('id' => $languages[$i]['code'],
				'text' => $languages[$i]['name']);
			} // for

			// get used content files
			$content_files_query=olc_db_query("SELECT DISTINCT
                                content_name,
                                content_file
                                FROM ".TABLE_PRODUCTS_CONTENT."
                                WHERE content_file!=''");
			$content_files=EMPTY_STRING;
			while ($content_files_data=olc_db_fetch_array($content_files_query)) {
				$content_files[]=array(
				'id' => $content_files_data['content_file'],
				'text' => $content_files_data['content_name']);
			}

			// add default value to array
			$default_array[]=array('id' => 'default','text' => TEXT_SELECT);
			$default_value='default';
			$content_files=array_merge($default_array,$content_files);
			// mask for product content
			if ($action!='new_products_content') {
 ?>
 <?php echo olc_draw_form('edit_content',FILENAME_CONTENT_MANAGER,'action=edit_products_content&id=update_product&coID='.$coID,'post','enctype="multipart/form-data"').olc_draw_hidden_field('coID',$coID); ?>
<?php
			} else {
?>
<?php echo olc_draw_form('edit_content',FILENAME_CONTENT_MANAGER,'action=edit_products_content&id=insert_product','post','enctype="multipart/form-data"');   ?>
<?php
			}
?>
 <div class="main"><?php echo TEXT_CONTENT_DESCRIPTION; ?></div>
 <table class="main" width="100%" border="0">
   <tr>
      <td width="10%"><?php echo TEXT_PRODUCT; ?></td>
      <td width="90%"><?php echo olc_draw_pull_down_menu('product',$products_array,$content['products_id']); ?></td>
   </tr>
      <tr>
      <td width="10%"><?php echo TEXT_LANGUAGE; ?></td>
      <td width="90%"><?php echo olc_draw_pull_down_menu('language',$languages_array,$languages_selected); ?></td>
   </tr>
      <tr>
      <td width="10%"><?php echo TEXT_TITLE_FILE; ?></td>
      <td width="90%"><?php echo olc_draw_input_field('cont_title',$content['content_name'],'size="60"'); ?></td>
   </tr>
      <tr>
      <td width="10%"><?php echo TEXT_LINK; ?></td>
      <td width="90%"><?php  echo olc_draw_input_field('cont_link',$content['content_link'],'size="60"'); ?></td>
   </tr>
      <tr>
      <td width="10%" valign="top"><?php echo TEXT_FILE_DESC; ?></td>
      <td width="90%"><?php
      if (USE_SPAW==TRUE_STRING_S) {
      	$sw = new SPAW_Wysiwyg('file_comment' /*name*/,stripslashes($content['file_comment']) /*value*/,
      	'de' /*language*/, 'sidetable' /*toolbar mode*/, 'default' /*theme*/,
      	'550px' /*width*/, '350px' /*height*/);
      	$sw->show();
      } else {
      	echo olc_draw_textarea_field('file_comment',EMPTY_STRING,'100','15',$content['file_comment']);
      }
        ?></td>
   </tr>
      <tr>
      <td width="10%"><?php echo TEXT_CHOOSE_FILE; ?></td>
      <td width="90%"><?php echo olc_draw_pull_down_menu('select_file',$content_files,$default_value); ?><?php echo BLANK.TEXT_CHOOSE_FILE_DESC; ?></td>
   </tr>
      <tr>
      <td width="10%" valign="top"><?php echo TEXT_UPLOAD_FILE; ?></td>
      <td width="90%"><?php echo olc_draw_file_field('file_upload').BLANK.TEXT_UPLOAD_FILE_LOCAL; ?></td>
   </tr>
 <?php
 if ($content['content_file']!=EMPTY_STRING) {
 ?>

         <tr>
      <td width="10%"><?php echo TEXT_FILENAME; ?></td>
      <td width="90%"><?php echo olc_draw_hidden_field('file_name',$content['content_file']).HTML_B_START.olc_image(DIR_WS_CATALOG.'admin/images/icons/icon'.strstr($content['content_file'],'.').'.gif').$content['content_file'].HTML_B_END; ?></td>
   </tr>
  <?php
 }
?>
       <tr>
        <td colspan="2" align="right" class="main"><?php echo olc_image_submit('button_save.gif', IMAGE_SAVE); ?>
        <a href="<?php echo olc_href_link(FILENAME_CONTENT_MANAGER); ?>"><?php echo olc_image_button('button_back.gif', IMAGE_BACK); ?></a></td>
   </tr>
   </form>
   </table>

 <?php

 break;


	}
}

if (!$action) {
?>

<a href="<?php echo olc_href_link(FILENAME_CONTENT_MANAGER,'action=new'); ?>"><?php echo olc_image_button('button_new_content.gif'); ?></a>
<?php
}
?>
</td>
          </tr>
        </table>
 <?php
 if (!$action) {
 	// products content
 	// load products_ids into array
 	$products_id_query=olc_db_query("SELECT DISTINCT
                                pc.products_id,
                                pd.products_name
                                FROM ".TABLE_PRODUCTS_CONTENT." pc, ".TABLE_PRODUCTS_DESCRIPTION." pd
                                WHERE pd.products_id=pc.products_id and pd.language_id='".SESSION_LANGUAGE_ID.APOS);

 	$products_ids=array();
 	while ($products_id_data=olc_db_fetch_array($products_id_query)) {

 		$products_ids[]=array(
 		'id'=>$products_id_data['products_id'],
 		'name'=>$products_id_data['products_name']);

 	} // while


 ?>
 <div class="pageHeading"><br/><?php echo HEADING_PRODUCTS_CONTENT; ?><br/></div>
  <?php
  olc_spaceUsed(DIR_FS_CATALOG.'media/products/');
  echo '<div class="main">'.USED_SPACE.olc_format_filesize($total).'</div></br>';
?>
 <table border="0" width="100%" cellspacing="0" cellpadding="2">
    <tr class="dataTableHeadingRow">
     <td class="dataTableHeadingContent" nowrap="nowrap" width="5%" ><?php echo TABLE_HEADING_PRODUCTS_ID; ?></td>
     <td class="dataTableHeadingContent" width="95%" align="left"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
</tr>
<?php

for ($i=0,$n=sizeof($products_ids); $i<$n; $i++) {
	echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\'" onmouseout="this.className=\'dataTableRow\'">' . NEW_LINE;

 ?>
 <td class="dataTableContent_products" align="left"><?php echo $products_ids[$i]['id']; ?></td>
 <td class="dataTableContent_products" align="left"><b><?php echo olc_image(DIR_WS_CATALOG.'images/icons/arrow.gif'); ?>
 <a href="<?php echo olc_href_link(FILENAME_CONTENT_MANAGER,'pID='.$products_ids[$i]['id']);?>"><?php echo $products_ids[$i]['name']; ?></a></b></td>
 </tr>
<?php
if ($pID) {
	// display content elements
	$content_query=olc_db_query("SELECT
                                        content_id,
                                        content_name,
                                        content_file,
                                        content_link,
                                        languages_id,
                                        file_comment,
                                        content_read
                                        FROM ".TABLE_PRODUCTS_CONTENT."
                                        WHERE products_id='".$pID."' order by content_name");
	$content_array=EMPTY_STRING;
	while ($content_data=olc_db_fetch_array($content_query)) {

		$content_array[]=array(
		'id'=> $content_data['content_id'],
		'name'=> $content_data['content_name'],
		'file'=> $content_data['content_file'],
		'link'=> $content_data['content_link'],
		'comment'=> $content_data['file_comment'],
		'languages_id'=> $content_data['languages_id'],
		'read'=> $content_data['content_read']);

	} // while content data

	if ($pID==$products_ids[$i]['id']){
?>

<tr>
 <td class="dataTableContent" align="left"></td>
 <td class="dataTableContent" align="left">

 <table border="0" width="100%" cellspacing="0" cellpadding="2">
    <tr class="dataTableHeadingRow">
    <td class="dataTableHeadingContent" nowrap="nowrap" width="2%" ><?php echo TABLE_HEADING_PRODUCTS_CONTENT_ID; ?></td>
    <td class="dataTableHeadingContent" nowrap="nowrap" width="2%" >&nbsp;</td>
    <td class="dataTableHeadingContent" nowrap="nowrap" width="5%" ><?php echo TABLE_HEADING_LANGUAGE; ?></td>
    <td class="dataTableHeadingContent" nowrap="nowrap" width="15%" ><?php echo TABLE_HEADING_CONTENT_NAME; ?></td>
    <td class="dataTableHeadingContent" nowrap="nowrap" width="30%" ><?php echo TABLE_HEADING_CONTENT_FILE; ?></td>
    <td class="dataTableHeadingContent" nowrap="nowrap" width="1%" ><?php echo TABLE_HEADING_CONTENT_FILESIZE; ?></td>
    <td class="dataTableHeadingContent" nowrap="nowrap" align="middle" width="20%" ><?php echo TABLE_HEADING_CONTENT_LINK; ?></td>
    <td class="dataTableHeadingContent" nowrap="nowrap" width="5%" ><?php echo TABLE_HEADING_CONTENT_HITS; ?></td>
    <td class="dataTableHeadingContent" nowrap="nowrap" width="20%" ><?php echo TABLE_HEADING_CONTENT_ACTION; ?></td>
    </tr>

<?php

for ($ii=0,$nn=sizeof($content_array); $ii<$nn; $ii++) {

	echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\'" onmouseout="this.className=\'dataTableRow\'">' . NEW_LINE;

 ?>
 <td class="dataTableContent" align="left"><?php echo  $content_array[$ii]['id']; ?> </td>
 <td class="dataTableContent" align="left"><?php



 if ($content_array[$ii]['file']!=EMPTY_STRING) {

 	echo olc_image(DIR_WS_CATALOG.'admin/images/icons/icon_'.str_replace('.',EMPTY_STRING,strstr($content_array[$ii]['file'],'.')).'.gif');
 } else {
 	echo olc_image(DIR_WS_CATALOG.'admin/images/icons/icon_link.gif');
 }

 for ($xx=0,$zz=sizeof($languages); $xx<$zz;$xx++){
 	if ($languages[$xx]['id']==$content_array[$ii]['languages_id']) {
 		$lang_dir=$languages[$xx]['directory'];
 		break;
 	}
 }

?>
</td>
 <td class="dataTableContent" align="left"><?php echo olc_image(DIR_WS_CATALOG.'lang/'.$lang_dir.'/admin/images/icon.gif'); ?></td>
 <td class="dataTableContent" align="left"><?php echo $content_array[$ii]['name']; ?></td>
 <td class="dataTableContent" align="left"><?php echo $content_array[$ii]['file']; ?></td>
 <td class="dataTableContent" align="left"><?php echo olc_filesize($content_array[$ii]['file']); ?></td>
 <td class="dataTableContent" align="left" align="middle"><?php
 $link=$content_array[$ii]['link'];
 if ($link!=EMPTY_STRING) {
 	echo HTML_A_START.olc_href_link($link).'" target="new">'.$link.HTML_A_END;
 }
 ?>
  &nbsp;</td>
 <td class="dataTableContent" align="left"><?php echo $content_array[$ii]['read']; ?></td>
 <td class="dataTableContent" align="left">

  <a href="<?php echo olc_href_link(FILENAME_CONTENT_MANAGER,'special=delete_product&coID='.$content_array[$ii]['id']).'&pID='.$products_ids[$i]['id']; ?>" onclick="javascript:return confirm('<?php echo CONFIRM_DELETE; ?>')">
 <?php

 echo olc_image(DIR_WS_ICONS.'delete.gif','Delete',EMPTY_STRING,EMPTY_STRING,'style="cursor:hand" onclick="javascript:return confirm(\''.DELETE_ENTRY.'\')"').'  '.TEXT_DELETE.'</a>&nbsp;&nbsp;';

?>
 <a href="<?php echo olc_href_link(FILENAME_CONTENT_MANAGER,'action=edit_products_content&coID='.$content_array[$ii]['id']); ?>">
<?php echo olc_image(DIR_WS_ICONS.'icon_edit.gif','Edit',EMPTY_STRING,EMPTY_STRING,'style="cursor:hand"').'  '.TEXT_EDIT.HTML_A_END; ?>

<?php
// display preview button if filetype
// .gif,.jpg,.png,.html,.htm,.txt,.tif,.bmp
if (	eregi('.gif',$content_array[$ii]['file'])
or
eregi('.jpg',$content_array[$ii]['file'])
or
eregi('.png',$content_array[$ii]['file'])
or
eregi(EMPTY_STRING.HTML_EXT,$content_array[$ii]['file'])
or
eregi('.htm',$content_array[$ii]['file'])
or
eregi('.txt',$content_array[$ii]['file'])
or
eregi('.bmp',$content_array[$ii]['file'])
) {
?>
 <a style="cursor:hand" onclick="javascript:window.open('<?php echo olc_href_link(FILENAME_CONTENT_PREVIEW,'pop_up=true&pID=media&coID='.$content_array[$ii]['id']); ?>', 'popup', 'toolbar=0, width=640, height=600')"


 ><?php echo olc_image(DIR_WS_ICONS.'preview.gif','Preview',EMPTY_STRING,EMPTY_STRING,'style="cursor:hand"').'&nbsp;&nbsp;'.TEXT_PREVIEW.HTML_A_END; ?>
<?php
}
?>



 </td>
 </tr>

<?php

} // for content_array
echo '</table></td></tr>';
	}
} // for
}
?>


 </table>
 <a href="<?php echo olc_href_link(FILENAME_CONTENT_MANAGER,'action=new_products_content'); ?>"><?php echo olc_image_button('button_new_content.gif'); ?></a>
 <?php
 } // if !$action
?>

        </td>
      </tr>
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
