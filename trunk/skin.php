<?php
/* -----------------------------------------------------------------------------------------
$Id: skin.php,v 1.1.1.1.2.1 2007/04/08 07:16:22 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(login.php,v 1.79 2003/05/19); www.oscommerce.com
(c) 2003      nextcommerce (login.php,v 1.13 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:

Select other shop skin. W. Kaiser, w.kaiser@fortune.de

This routine will collect information on all available templates
If more than the current template are available, a list is displayed
for selection.

If an image named "template_name.gif" is available in directory "templates/template/images",
this is also displayed (template preview)
---------------------------------------------------------------------------------------*/

include('includes/application_top.php');
$templates_dir='templates';
$action=$_POST['action'];
$template_change=$action=='process';
if ($template_change || $action=='return')
{
	if ($template_change)
	{
		$expires=time()+60*60*24*10000;
		$current_template= $_POST[$templates_dir];
		setcookie(FUNCTION_NAME_START."current_template", $current_template,$expires);
		setcookie("olc_force_javascript_check",1,$expires);
		@file_put_contents(DIR_FS_MULTI_SHOP.'template.txt',$current_template);
		if (USE_LAYOUT_DEFINITION==TRUE_STRING_S)
		{
			//Rebuild box configuration data
			unset($_SESSION['box_relations']);
			include(DIR_FS_INC.'olc_get_box_configuration');
		}
	}
	unset($_SESSION['ajax']);
	if (USE_AJAX)
	{
		echo "restart";
	}
	else
	{
		olc_redirect(HTTP_SERVER.DIR_WS_CATALOG.FILENAME_DEFAULT);
	}
	olc_exit();
}
else
{
	require(DIR_FS_INC.'olc_draw_radio_field.inc.php');
	require(DIR_WS_INCLUDES . 'header.php');

	$content_body=EMPTY_STRING;
	$templates_entry0=olc_draw_radio_field($templates_dir,HASH,true).'&nbsp;<b><font size="3">#</font></b>';
	$templates_image_file='templates/#/images/#.gif';
	$templates_image="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
	olc_image($templates_image_file,"Shop-Design '#'",EMPTY_STRING,EMPTY_STRING,'align="middle"');

	$templates_count=0;
	$illegal_templates=CURRENT_TEMPLATE.'CVS.common.powertemplates';
	$dh  = opendir($templates_dir);
	while ($this_template = readdir($dh))
	{
		if (is_dir($templates_dir.SLASH.$this_template))
		{
			$first_char=substr($this_template,0,1);
			if ($first_char<>DOT)
			{
				if ($first_char<>UNDERSCORE)
				{
					if (strpos($illegal_templates,$this_template)===false)
					{
						$templates_entry=str_replace(HASH,$this_template,$templates_entry0);
						if ($templates_count<>0)
						{
							$templates_entry=str_replace(' CHECKED',EMPTY_STRING,$templates_entry);
						}
						if (file_exists(str_replace(HASH,$this_template,$templates_image_file)))
						{
							$templates_entry.=str_replace(HASH,$this_template,$templates_image);
						}
						$content_body.=HTML_BR.$templates_entry;
						$templates_count++;
					}
				}
			}
		}
	}
	closedir($dh);
	if ($templates_count==0)
	{
		$subtitle=TEXT_NO_SHOP_DESIGNS;
		$action='return';
	}
	else
	{
		$subtitle=TEXT_NEW_SHOP_DESIGN;
		$button_continue=olc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE);
		$action='process';
	}
	$content_body.=olc_draw_hidden_field('action',$action);
	$breadcrumb->add(TEXT_CHANGE_SHOP_DESIGN, olc_href_link('skin.php'));
	olc_smarty_init($module_smarty,$cacheid);
	$module_smarty->assign('FORM_ACTION',olc_draw_form($templates_dir,CURRENT_SCRIPT));
	$module_smarty->assign('CONTENT_HEADING',TEXT_CHANGE_SHOP_DESIGN.HTML_BR.$subtitle);
	$module_smarty->assign('BUTTON_CONTINUE',$button_continue);
	$module_smarty->assign('CONTENT_BODY',$content_body);
	$main_content=$module_smarty->fetch(CURRENT_TEMPLATE_MODULE . 'skin'.HTML_EXT,$cacheid);
	$smarty->assign(MAIN_CONTENT,$main_content);
	//W. Kaiser - AJAX
	require(BOXES);
	$smarty->display(INDEX_HTML);
}
?>