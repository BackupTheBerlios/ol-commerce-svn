<?php
/* --------------------------------------------------------------
$Id: box_configuration.php,v 1.1.1.1.2.1 2007/04/08 07:16:26 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommercecoding standards www.oscommerce.com
(c) 2003	    nextcommerce (accounting.php,v 1.27 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');
$smarty->assign('BOX_CONTENT','Lorem ipsum dolor sit amet, consectetuer adipiscing elit.');
$action=$_GET['action'];
$main_content=EMPTY_STRING;
$box_parameters='box_parameters';
if ($action)
{
	switch ($action)
	{
		case 'save':
			$parameters=$_POST[$box_parameters];
			if ($parameters)
			{
				//$update=true;
				$sql0=SQL_UPDATE.TABLE_BOX_CONFIGURATION." SET # WHERE box_key_name='@' AND template='".CURRENT_TEMPLATE.APOS;
				$show_text='SHOW_';
				$box_text='box_';
				$sql_commands=array();
				$box_position_name='box_position_name=';
				$box_visible_name='box_visible=';
				$parameters=explode('|',$parameters);
				for ($i=0,$n=sizeof($parameters);$i<$n;$i++)
				{
					$parameter=$parameters[$i];
					$parameter=explode(COMMA,$parameter);
					$box_key=$parameter[0];
					$box_position=$parameter[1];
					if ($parameter[2]=="true")
					{
						$box_visible='1';
					}
					else
					{
						$box_visible='0';
					}
					$this_rebuild=$box_visible<>$box_constants[$box_key];
					if (!$this_rebuild)
					{
						if ($box_position)
						{
							$box_key_box=str_replace($show_text,$box_text,$box_key);
							$this_rebuild=$box_position<>$box_relations[$box_key_box];
						}
					}
					if ($this_rebuild)
					{
						$rebuild=true;
						$sql_fields=$box_position_name.APOS.$box_position.APOS;
						$sql_fields.=COMMA_BLANK.$box_visible_name.APOS.$box_visible.APOS;
						$sql_commands[$box_key]=$sql_fields;
					}
				}
				if ($rebuild)
				{
					$modified=COMMA_BLANK.'last_modified=now()';
					while (list($box_key, $value) = each($sql_commands))
					{
						$sql_fields=$value.$modified;
						$sql=str_replace(ATSIGN,$box_key,$sql0);
						$sql=str_replace(HASH,$sql_fields,$sql);
						olc_db_query($sql);
					}
					//Rebuild box configuration data
					unset($_SESSION['box_relations']);
					include(DIR_FS_INC.'olc_get_box_configuration.inc.php');
				}
			}
	}
}
$background_visible='';
$background_hidden='Lightgrey';
$background_drag_source='Palegoldenrod';
$background_drop_traget='LightGreen';

$dd_dir='<script language="JavaScript" type="text/javascript" src="'.DIR_WS_INCLUDES.'drag_drop'.SLASH;
$main_content.=
$dd_dir.'coordinates.js"></script>'.
$dd_dir.'drag.js"></script>'.
$dd_dir.'dragdrop.js"></script>
<link rel="stylesheet" type="text/css" href="' .ADMIN_PATH_PREFIX.FULL_CURRENT_TEMPLATE. 'stylesheet.css">
<SCRIPT type="text/javascript">
var dragHelper=null;
var dropHelper=null;

var obj_name=null;
var parent_obj=null;
var class_value=null,is_left=false;
var obj_id=null,id="",comma=",";
var class_visible="visible";
var class_hidden="hidden";
var parameters="",box_parameters="'.$box_parameters.'";

var drop_target_backcolor="'.$background_drop_traget.'";
var drag_source_backcolor="'.$background_drag_source.'";
var old_background="'.$background_visible.'";

var div="div",left="l",right="r",id_part="SHOW_";
var search,replace,back_color,ausgabe,pos,pos1,suchen_length;

var drag_source;

window.onload = function()
{
	var container = $("DragContainerL");
	DragDrop.makeContainer(div,id_part,container,left);

	container = $("DragContainerR");
	DragDrop.makeContainer(div,id_part,container,right);
};

function getSort()
{
	var user_eval_function="build_parameters";

	nav="l";
	drag_object=-1;
	build_parameters("SHOW_CHANGE_SKIN");
	build_parameters("SHOW_CENTER");
	build_parameters("SHOW_PDF_CATALOG");
	build_parameters("SHOW_GALLERY");

	drag_object=0
	DragDrop.serData(div,id_part,left,null,user_eval_function);
	nav="r";

	DragDrop.serData(div,id_part,right,null,user_eval_function);
	box_parameters = $("'.$box_parameters.'");
	box_parameters.value=parameters;
}

function build_parameters(id,pos)
{
	cb=$("cb_"+id+"_v_l");
	if (cb)
	{
		visible=cb.checked;
		cb.checked=false;
	}
	else
	{
		//Forced visible box!
		visible=true;
	}
	if (parameters)
	{
		parameters+="|";
	}
	if (drag_object>=0)
	{
		if (pos<10)
		{
			pos="0"+pos;
		}
		box="box_"+nav+"_"+pos;
	}
	else
	{
		box="";
	}
	parameters+=id+comma+box+comma+visible;
}

function showValue()
{
	order =$("order");
	alert(order.value);
}

function fReplace(string,suchen,ersetzen)
{
	ausgabe="";
	pos=0;
	suchen_length=suchen.length;
	pos=string.indexOf(suchen,pos);
	while (pos!=-1)
	{
		pos1=pos+suchen_length;
		ausgabe+= string.substring(0, pos)+ersetzen+string.substring(pos1);
		pos=pos1;
		pos=string.indexOf(suchen,pos);
	}
	return ausgabe;
}

function show_visibility(obj)
{
	obj_id=obj.id;
	is_left=obj_id.indexOf("_l")!=-1;
	with (obj)
	{
		visible=checked;

		if (is_left)
		{
			search="_l";
			replace="_r";
		}
		else
		{
			search="_r";
			replace="_l";
		}
		obj_id=fReplace(obj_id,search,replace);
		obj=$(obj_id);
		if (obj)
		{
			if (checked)
			{
				back_color="'.$background_visible.'";
			}
			else
			{
				back_color="'.$background_hidden.'";
			}
			obj.checked=visible;
			obj_id=parentNode.parentNode.id;
			obj_id=obj_id.replace(/_v_/,"_n_");
			for (var i=1;i<=2;i++)
			{
				obj=$(obj_id);
				obj.style.background=back_color;
				if (i==1)
				{
					obj_id=fReplace(obj_id,search,replace);

					//Loop up to proper "div"-level and set new default color
					while (obj!=null && obj.tagName!=div)
					{
						obj=obj.parentNode;
					}
					if (obj)
					{
						obj.parentNode.orig_background=back_color;
					}
				}
			}
		}
	}
}

function $()
{
	elements = new Array();

	for (i = 0; i < arguments.length; i++) {
		element = arguments[i];
		if (typeof(element) == "string")
		{
			element = document.getElementById(element);
		}
		if (arguments.length == 1)
		{
			return element;
		}
		else
		{
			elements.push(element);
		}
	}
	return elements;
}

</SCRIPT>
';

$main_content.=
olc_draw_form('parameters', FILENAME_BOX_CONFIGURATION,'action=save', 'post',
'enctype="multipart/form-data" onsubmit="getSort()";').'
#special#
	<div align="center">
'.olc_draw_hidden_field($box_parameters,EMPTY_STRING,'id="'.$box_parameters.QUOTE).'
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
';
if ($message)
{
	$main_content.='
			<tr>
				<td colspan="3" class="headerError">
'.$message.'
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<hr/>
				</td>
			</tr>
';
}
if ($action)
{
	$main_content.='
			<tr>
				<td colspan="5" align="center">'.HTML_BR.HTML_B_START.
	HTML_A_START.olc_href_link(FILENAME_CUSTOMER_DEFAULT,'force_restart=true').'" target="_blank">'.
	PREVIEW_TITLE.HTML_B_END.HTML_A_END.HTML_BR.HTML_BR.HTML_HR.'
				</td>
			</tr>
';
}
$table_t0=HTML_BR.HTML_BR.'
	<div align="left">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td colspan="2"><b>'.OPTIONAL_TITLE.HTML_BR.HTML_BR.'<b></td>
			</tr>
			#special#
			<tr>
				<td colspan="2"><br/><hr/></td>
			</tr>
		</table>
	</div>
';

$visible_checkbox='<INPUT TYPE="checkbox" onclick="javascript:show_visibility(this)" class="NoMouseDown" #vc# name="#v#_#pos#" id="cb_#v#_#pos#" VALUE="on">';

$line_special='
			<tr>
				<td class="main" nowrap="nowrap" width="425" align="left">
					#n#&nbsp;
				</td>
				<td class="main" nowrap="nowrap" align="left">
					&nbsp;'.$visible_checkbox.HTML_NBSP.VISIBLE_TITLE.'
				</td>
			</tr>
';
$main_content.='
			<tr>
				<td align="center" colspan="2">
					<b><font size="1">'.LEFT_AREA_TITLE.'
				</td>
				<td>&nbsp;</td>
				<td align="center" colspan="2">
					<b><font size="1">'.RIGHT_AREA_TITLE.'
				</td>
			</tr>
			<tr>
				<td class="navLeft" align="center">
					<b><font size="1">'.CONTENT_TITLE.'</font></b>
				</td>
				<td align="center" width="100">
					<b><font size="1">'.VISIBLE_TITLE.'</font></b>
				</td>
				<td>&nbsp;</td>
				<td align="center" width="100">
					<b><font size="1">'.VISIBLE_TITLE.'</font></b>
				</td>
				<td class="navRight" align="center">
					<b><font size="1">'.CONTENT_TITLE.'</font></b>
				</td>
			</tr>
			<tr>
				<td colspan="5"><hr/></td>
			</tr>
			<tr>
				<td valign="top" colspan="2" class="main">
					<div class="DragContainer" id="DragContainerL" overClass="OverDragContainer">
						#nav_left#
					</div>
				</td>
				<td valign="top" class="main">'.EXPLANATION_TITLE.'</td>
				<td valign="top" align="right" colspan="2" class="main">
					<div class="DragContainer" id="DragContainerR" overClass="OverDragContainer">
						#nav_right#
					</div>
				</td>
			</tr>
';
$line0='
						<div class="DragBox" id="#id#" onDragEnter = "DragDrop.onDragEnter">
							<div id="#id#_l" style="display:#dl#;" onDragEnter = "DragDrop.onDragEnter">
								<table border="0" cellspacing="0" cellpadding="0" >
									<tr>
										<td valign="top" id="#id#_n_l" class="navLeft" style="background:#bc#;cursor:move"
											onDragEnter = "DragDrop.onDragEnter">
											#n#
										</td>
										<td width="100" id="#id#_v_l" valign="middle" align="center">
											<font size="1">#vcb_l#</font>
										</td>
									</tr>
								</table>
							</div>
							<div id="#id#_r" style="display:#dr#">
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="100" id="#id#_v_r" valign="middle" align="center">
											<font size="1">#vcb_r#</font>
										</td>
										<td valign="top" id="#id#_n_r" class="navRight" style="background:#bc#;cursor:move"
											onDragEnter = "DragDrop.onDragEnter">
											#n#
										</td>
									</tr>
								</table>
							</div>
						</div>
';

$line0_l=str_replace('#dl#','inline',$line0);
$line0_l=str_replace('#dr#','none',$line0_l);
$line0_r=str_replace('#dl#','none',$line0);
$line0_r=str_replace('#dr#','inline',$line0_r);

$content_ph='#n#';
$id_ph='#id#';
$visible_ph='#v#';
$pos_ph='#pos#';
$background_ph='#bc#';
$visible_checkbox_l_ph='#vcb_l#';
$visible_checkbox_r_ph='#vcb_r#';
$visible_checkbox_checked='#vc#';
$checked='checked="checked"';
$table_l=EMPTY_STRING;
$table_r=EMPTY_STRING;
$sql=SELECT_ALL .TABLE_BOX_CONFIGURATION.SQL_WHERE." template='".CURRENT_TEMPLATE."' order by box_position_name, box_sort_order";
$box_configuration_query = olc_db_query($sql);
while ($current_box=olc_db_fetch_array($box_configuration_query))
{
	$box_key_name=$current_box['box_key_name'];
	$box_key_name_extended=$box_key_name.UNDERSCORE;
	$box_position_name=strtolower($current_box['box_position_name']);
	$box_position_name=explode(UNDERSCORE,$box_position_name);
	$is_left=$box_position_name[1]!='r';
	if ($is_left)
	{
		//Left navigation	area
		$line=$line0_l;
		$boxes_l++;
		$pos='l';
	}
	else
	{
		//Right navigation area
		$line=$line0_r;
		$boxes_r++;
		$pos='r';
	}
	$background=$background_visible;
	$visible_name=$box_key_name_extended.'v';
	if ($current_box['box_forced_visible'])
	{
		$line=str_replace($visible_checkbox_l_ph,YES_TITLE,$line);
		$line=str_replace($visible_checkbox_r_ph,YES_TITLE,$line);
	}
	else
	{
		$cb=str_replace($visible_ph,$visible_name,$visible_checkbox);
		if ($current_box['box_visible'])
		{
			$cb_checked=$checked;
			$background=$background_visible;
		}
		else
		{
			$cb_checked=EMPTY_STRING;
			$background=$background_hidden;
		}
		$cb=str_replace($visible_checkbox_checked,$cb_checked,$cb);
		$line=str_replace($visible_checkbox_l_ph,str_replace($pos_ph,'l',$cb),$line);
		$line=str_replace($visible_checkbox_r_ph,str_replace($pos_ph,'r',$cb),$line);
	}
	$line=str_replace($background_ph,$background,$line);
	$box_real_name=$current_box['box_real_name'];
	$is_special=$box_real_name==EMPTY_STRING;
	if ($is_special)
	{
		//Nonbox item!
		$boxes_l--;
		$line=str_replace($visible_checkbox_checked,$cb_checked,$line_special);
		$line=str_replace($visible_ph,$visible_name,$line);
		$line=str_replace($pos_ph,'l',$line);
		$box_content=constant($box_key_name.'_TITLE');
	}
	else
	{
		$cols=$cols_full;
		$box_content=$smarty->fetch(CURRENT_TEMPLATE_BOXES.strtolower($box_real_name).HTML_EXT,$cacheid);
		$box_content=str_replace('</form>',EMPTY_STRING,$box_content);
	}
	$line=str_replace($content_ph,$box_content,$line);
	$comment="\n<!-- ".$box_key_name." #-->\n";
	$line=str_replace(HASH,'BEGIN',$comment).$line.str_replace(HASH,'END',$comment);
	if ($is_special)
	{
		//Nonbox item!
		$table_t.=$line;
	}
	else
	{
		$line=str_replace($id_ph,$box_key_name,$line);
		if ($is_left)
		{
			//Left navigation	area
			$table_l.=$line;
		}
		else
		{
			//Right navigation area
			$table_r.=$line;
		}
	}
}
$main_content=str_replace('#nav_left#',$table_l,$main_content);
$main_content=str_replace('#nav_right#',$table_r,$main_content);

$table_t=str_replace('#special#',$table_t,$table_t0);
$main_content=str_replace('#special#',$table_t,$main_content);
$main_content.='
			<tr>
				<td colspan="5">
					<hr/>
				</td>
			</tr>
			<tr>
				<td>'.
HTML_A_START.olc_href_link(FILENAME_DEFAULT).'">'.
olc_image('button_back.gif', IMAGE_BACK,EMPTY_STRING,EMPTY_STRING,
'class="cursor:hand"').HTML_A_END.'
				</td>
				<td colspan="3"></td>
				<td align="right">'.olc_image_submit('button_update.gif', IMAGE_SAVE,'class="cursor:hand"').'</td>
			</tr>
		</table>
	</div>
</FORM>
';

$page_header_title=HEADING_TITLE;
$page_header_subtitle=HEADING_SUBTITLE;
$page_header_icon_image=HEADING_MODULES_ICON;
$show_column_right=false;
$no_left_menu=true;
require(PROGRAM_FRAME);
olc_exit();
?>