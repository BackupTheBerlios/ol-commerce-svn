<?php
/* --------------------------------------------------------------
$Id: configuration.php,v 1.1.1.1.2.1 2007/04/08 07:16:26 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(configuration.php,v 1.40 2002/12/29); www.oscommerce.com
(c) 2003	    nextcommerce (configuration.php,v 1.16 2003/08/19); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');

$configuration_value_text='configuration_value';
$configuration_id_text='configuration_id';
$cID = olc_db_prepare_input($_GET['cID']);
$gID= olc_db_prepare_input($_GET['gID']);
$action=$_GET['action'];
if ($action=='save')
{
	$configuration_value = olc_db_prepare_input($_POST[$configuration_value_text]);
	olc_db_query(SQL_UPDATE . TABLE_CONFIGURATION . " set ".$configuration_value_text." = '" .$configuration_value .
	"', last_modified = now() where ".$configuration_id_text." = '" . $cID . APOS);
}
$sql=SELECT."configuration_group_title from " . TABLE_CONFIGURATION_GROUP .
SQL_WHERE."configuration_group_id = '" . $gID . APOS;
$cfg_group_query = olc_db_query($sql);
$cfg_group = olc_db_fetch_array($cfg_group_query);
if (NOT_USE_AJAX_ADMIN)
{
	$main_content= '
<script language="javascript" type="text/javascript" src="includes/admin_global_scripts.js.php"></script>
';
}
else
{
	$main_content= EMPTY_STRING;
}
$action_edit=HTML_AMP.'action=edit';
$select=SELECT."configuration_key,";
$from=SQL_FROM .	TABLE_CONFIGURATION . SQL_WHERE;
$use_function_field=", use_function";
$extra_fields=", date_added, last_modified, use_function, set_function";
$select_id_value=$select.$configuration_id_text.", ".$configuration_value_text;
$sql0=$select_id_value.$use_function_field.$from."configuration_group_id = '" . $gID.APOS;
$sql0_ordered=$sql0. " order by sort_order";
if (substr($action, 0, 3) != 'new')
{
	if ($cID)
	{
		$sql_extra=$select_id_value.$extra_fields.$from.$configuration_id_text.EQUAL.APOS.$cID.APOS;
	}
	else
	{
		$sql_extra=str_replace($use_function_field,$extra_fields,$sql0_ordered).' LIMIT 1';
	}
	$cfg_extra_query =olc_db_query($sql_extra);
	$cfg_extra = olc_db_fetch_array($cfg_extra_query);
	$cInfo = new objectInfo($cfg_extra );
	$is_object_cInfo=is_object($cInfo);
	$cInfo_configuration_id=$cInfo->configuration_id;
}
$link0=olc_href_link(FILENAME_CONFIGURATION, $action_edit.HTML_AMP.'gID=' . $gID . HTML_AMP.'cID=' . HASH).'" title="';
if (USE_CSS_ADMIN_MENU)
{
	$sql=$sql0.SQL_AND.$configuration_id_text.EQUAL.APOS.$cID.APOS;
	$configuration_query = olc_db_query($sql);
	$configuration = olc_db_fetch_array($configuration_query);
	$configuration_value=$configuration[$configuration_value_text];
	$configuration_id=$cID;
	$configuration_key=$configuration['configuration_key'];
	$field_size=80;
	$cancel_link=olc_href_link(FILENAME_DEFAULT);
}
else
{
	$field_size=40;
	$cancel_link=olc_href_link(FILENAME_CONFIGURATION, 'gID=' . $gID . '&cID=' . $cID);
	$main_content.=
				'
									<table border="0" width="100%" cellspacing="0" cellpadding="0">
						        <tr class="dataTableHeadingRow">
			                <td class="dataTableHeadingContent">'.TABLE_HEADING_CONFIGURATION_TITLE.'</td>
			                <td class="dataTableHeadingContent">'.TABLE_HEADING_CONFIGURATION_VALUE.'</td>
			                <td class="dataTableHeadingContent" align="middle">'.TABLE_HEADING_ACTION.'</td>
			              </tr>
';
	$icon_right=olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', EMPTY_STRING);
	$icon_info=olc_image(DIR_WS_IMAGES . 'icon_info.gif', EMPTY_STRING);
	$on_click='>
';
	$sql=$sql0_ordered;
	$configuration_query = olc_db_query($sql);
	$modules_dir=DIR_FS_CATALOG_LANGUAGES . $language . '/modules/';
	while ($configuration = olc_db_fetch_array($configuration_query))
	{
		$configuration_value=$configuration[$configuration_value_text];
		$configuration_id=$configuration[$configuration_id_text];
		$configuration_key=$configuration['configuration_key'];
		$have_configuration_value=$configuration_value != EMPTY_STRING;
		$use_function = $configuration['use_function'];
		if (olc_not_null($use_function))
		{
			$s='->';
			if (ereg($s, $use_function))
			{
				$class_method = explode($s, $use_function);
				if (!is_object(${$class_method[0]}))
				{
					include_once(DIR_WS_CLASSES . $class_method[0] . PHP);
					${$class_method[0]} = new $class_method[0]();
				}
				$cfgValue = olc_call_function($class_method[1], $configuration_value, ${$class_method[0]});
			}
			else
			{
				$cfgValue = olc_call_function($use_function, $configuration_value);
			}
		}
		else
		{
			$cfgValue = $configuration_value;
		}
		$is_object_cInfo_and_same_id=$is_object_cInfo && ($configuration_id == $cInfo_configuration_id) ;
		//$link0=olc_href_link(FILENAME_CONFIGURATION, 'gID=' . $gID . '&cID=' . $configuration_id.HASH).'" title="';
		if ($is_object_cInfo_and_same_id)
		{
			$main_content.= '
		            <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'"'.$on_click;
		}
		else
		{
			$main_content.= '
	               <tr class="dataTableRow" onmouseover="this.style.cursor=\'hand\'; this.className=\'dataTableRowOver\';"
	               	onmouseout="this.className=\'dataTableRow\'"'.$on_click;
		}
		$link=str_replace(HASH,$configuration_id,$link0);
  	$title=strtoupper($configuration_key.'_TITLE');
  	$title=str_replace(QUOTE,APOS,constant($title));
  	$desc=strtoupper($configuration_key.'_DESC');
  	$desc=strip_tags(str_replace(QUOTE,APOS,constant($desc)));
		$main_content.= '
                <td class="dataTableContent">
                	'.HTML_A_START.$link.$desc.'">'.$title.HTML_A_END.'
                </td>
                <td class="dataTableContent">
';
                	$short_cfgValue = $cfgValue;
                	if(is_string($short_cfgValue))
                	{
                		if(strlen($short_cfgValue) > 30)
                		{
                			$short_cfgValue = substr($short_cfgValue,0,30) . ' ...';
                		}
                	}
                	$main_content.= htmlspecialchars($short_cfgValue).'
                </td>
                <td class="dataTableContent" align="right">
';
                	if ( $is_object_cInfo_and_same_id)
                	{
                		$main_content.= $icon_right;
                	}
                	else
                	{
                		$main_content.= HTML_A_START .$link.$desc . '">' . $icon_info . HTML_A_END.HTML_NBSP;
                	}
		$main_content.= '
                </td>
              </tr>
';
	}
	$main_content.= '
            </table>
          </td>
';
}
if ($is_object_cInfo)
{
	$heading = array();
	$contents = array();
	$key=strtoupper($cInfo->configuration_key);
	$title=$key.'_TITLE';
	if (defined($title))
	{
		$title=constant($title);
	}
	$description=$key.'_DESC';
	if (defined($description))
	{
		$description=constant($description);
	}
	$heading[] = array('text' => HTML_B_START . $title. HTML_B_END);
	$action='edit';
	switch ($action)
	{
		case 'edit':
			$set_function=$cInfo->set_function;
			$cInfo_configuration_value=$cInfo->configuration_value;
			if ($set_function)
			{
				//W. Kaiser - AJAX
				$set_function='$value_field = ' . $set_function . APOS . htmlspecialchars($cInfo_configuration_value) . "');";
				$set_function=stripslashes($set_function);
				eval($set_function);
				//W. Kaiser - AJAX
			}
			else
			{
				$value_field = olc_draw_input_field($configuration_value_text, $cInfo_configuration_value,'size="'.$field_size.'"');
			}
			$contents = array('form' => olc_draw_form('configuration', FILENAME_CONFIGURATION, 'gID=' . $gID .
			'&cID=' . $cInfo_configuration_id . '&action=save'));
			$contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
			$contents[] = array('text' => '<br/><b>' .$title . '</b><br/><br/>' . $description. '<br/><br/>' . $value_field);
			$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_update.gif', IMAGE_UPDATE) .
			HTML_NBSP.HTML_A_START . $cancel_link . '">' .
			olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
/*
			break;
		default:
			if ($is_object_cInfo)
			{
				$heading[] = array('text' => HTML_B_START . $title. HTML_B_END);
				$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_CONFIGURATION,
				'gID=' . $gID . '&cID=' . $cInfo_configuration_id . $action_edit) . '">' .
				olc_image_button('button_edit.gif', IMAGE_EDIT) . HTML_A_END);
				$contents[] = array('text' => HTML_BR . $description);
				$contents[] = array('text' => HTML_BR . TEXT_INFO_DATE_ADDED . BLANK . olc_date_short($cInfo->date_added));
				if (olc_not_null($cInfo->last_modified)) $contents[] = array('text' => TEXT_INFO_LAST_MODIFIED . BLANK .
				olc_date_short($cInfo->last_modified));
			}
			break;
*/
	}
	$main_content.='          <td width="25%" valign="top">
';
	$box = new box;
	$main_content.= $box->infoBox($heading, $contents);
}
define('AJAX_TITLE',$cfg_group['configuration_group_title']);
$page_header_title=AJAX_TITLE;
$page_header_subtitle='OLC Konfiguration';
$page_header_icon_image=HEADING_CONFIGURATION_ICON;
$show_column_right=false;
$no_left_menu=false;
require(PROGRAM_FRAME);
?>
