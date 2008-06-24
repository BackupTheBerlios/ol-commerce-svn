<?php
/* --------------------------------------------------------------
$Id: modules.php,v 1.1.1.1.2.1 2007/04/08 07:16:29 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(modules.php,v 1.45 2003/05/28); www.oscommerce.com
(c) 2003	    nextcommerce (modules.php,v 1.23 2003/08/19); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');
// include needed functions (for modules)
$action_text=HTML_AMP.'action=';
$is_payment=false;
$set=$_GET['set'];
$get_module=$_GET['module'];
$module_parameters0='set=' . $set . HTML_AMP.'module=';
$module_parameters=$module_parameters0 . $get_module;
$module_type = $set;
switch ($set)
{
	case 'shipping':
		$is_shipping=true;
		break;
	case 'order_total':
		break;
	case 'payment':
	default:
		$is_payment=true;
		break;
}
$error_text='error';
$error=$_GET[$error_text];
if (isset($error))
{
	$messageStack->add($error, $error_text);
}
$action=strtoupper($module_type);
define('HEADING_TITLE', constant('HEADING_TITLE_MODULES_'.$action));
$module_key = 'MODULE_'.$action.'_INSTALLED';
$module_type.=SLASH;
$module_directory = DIR_FS_CATALOG_MODULES.$module_type;
$module_language_directory=DIR_FS_LANGUAGES . SESSION_LANGUAGE . '/modules/' . $module_type;
$action=$_GET['action'];
switch ($action)
{
	case 'save':
		if ($is_shipping)
		{
			$module_shipping_freecount_amount_text='MODULE_SHIPPING_FREECOUNT_AMOUNT';
			$adjust_other=isset($_POST['configuration'][$module_shipping_freecount_amount_text]);
		}
		$sql0=SQL_UPDATE . TABLE_CONFIGURATION . " set configuration_value = '#1' where configuration_key = '#2'";
		while (list($key, $value) = each($_POST['configuration']))
		{
			$sql=str_replace('#1',$value,$sql0);
			$sql=str_replace('#2',$key,$sql);
			olc_db_query($sql);
			if ($adjust_other)
			{
				if ($key==$module_shipping_freecount_amount_text)
				{
					//Set other key also
					$sql=str_replace($key,'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER',$sql);
					olc_db_query($sql);
				}
			}
		}
		//olc_redirect(olc_href_link(FILENAME_MODULES, $module_parameters));
		$action=EMPTY_STRING;
		break;
	case 'install':
	case 'remove':
		$file_extension = substr($PHP_SELF, strrpos($_SERVER['PHP_SELF'], DOT));
		$class = basename($get_module);
		$file=$module_directory . $class . $file_extension;
		if (file_exists($file))
		{
			include_once($file);
			$module = new $class;
			if ($action == 'install')
			{
				$module->install();
			}
			else
			{
				$module->remove();
			}
		}
		//olc_redirect(olc_href_link(FILENAME_MODULES, $module_parameters0 . $class));
		$action=EMPTY_STRING;
		break;
}
$css_dynamic_menu = $css_menu && USE_CSS_DYNAMIC_ADMIN_MENU;
$file=$get_module.PHP;
$no_get_module=$get_module==EMPTY_STRING;
if ($no_get_module || !$css_dynamic_menu)
{
	$file_extension = substr($PHP_SELF, strrpos($PHP_SELF, DOT));
	$directory_array = array();
	if ($dir = @dir($module_directory))
	{
		while ($file_name = $dir->read())
		{
			if (!is_dir($module_directory . $file_name))
			{
				if (substr($file_name, strrpos($file_name, DOT)) == $file_extension)
				{
					if ($is_payment)
					{
						if ($file_name==FILENAME_PAYPAL_WPP)
						{
							if (!USE_PAYPAL_WPP)
							{
								continue;
							}
						}
						elseif ($file_name==FILENAME_PAYPAL_IPN)
						{
							if (!USE_PAYPAL_IPN)
							{
								continue;
							}
						}
					}
					$directory_array[] = $file_name;
				}
			}
		}
		$dir->close();
		sort($directory_array);
	}
	if ($no_get_module)
	{
		$file=$directory_array[0];
		$get_module=substr($file,0,strrpos($file, DOT));
	}
}
include_once($module_directory . $file);
include_once($module_language_directory. $file);
if (olc_class_exists($get_module))
{
	$module = new $get_module;
}
$module_info = array(
'code' => $module->code,
'title' => $module->title,
'description' => $module->description,
'status' => $module->check());
$module_keys = $module->keys();

$configuration_key_text='configuration_key';
$extra_query=
SELECT.$configuration_key_text.",configuration_value, use_function, set_function".SQL_FROM . TABLE_CONFIGURATION .
SQL_WHERE.$configuration_key_text.EQUAL.APOS;
$keys_extra = array();
for ($j = 0, $k = sizeof($module_keys); $j < $k; $j++)
{
	$constant_name=$module_keys[$j];
	$key_value_query = olc_db_query($extra_query . $constant_name . APOS);
	$key_value = olc_db_fetch_array($key_value_query);
	if ($key_value[$configuration_key_text] !=EMPTY_STRING)
	{
		$keys_extra[$constant_name]['title'] = constant($constant_name .'_TITLE');
		$keys_extra[$constant_name]['value'] = $key_value['configuration_value'];
		$keys_extra[$constant_name]['description'] = constant($constant_name .'_DESC');
		$keys_extra[$constant_name]['use_function'] = $key_value['use_function'];
		$keys_extra[$constant_name]['set_function'] = $key_value['set_function'];
	}
}
$module_info['keys'] = $keys_extra;
$mInfo = new objectInfo($module_info);
$is_object_mInfo=is_object($mInfo);
$main_content=EMPTY_STRING;
$mInfo_code=$mInfo->code;
if ($css_dynamic_menu)
{
	include_once($module_language_directory. $file);
	$field_size=80;
	$cancel_link=olc_href_link(FILENAME_DEFAULT);
}
else
{
	$field_size=40;
	$cancel_link=olc_href_link(FILENAME_MODULES, $module_parameters);
	$main_content.='
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
	              <tr class="dataTableHeadingRow">
	                <td class="dataTableHeadingContent">'.TABLE_HEADING_MODULES.'</td>
									<td class="dataTableHeadingContent">'.TABLE_HEADING_FILENAME.'</td>
	                <td class="dataTableHeadingContent" align="right">'.HTML_NBSP.TABLE_HEADING_SORT_ORDER.HTML_NBSP.'</td>
	                <td class="dataTableHeadingContent" align="center">'.HTML_NBSP.TABLE_HEADING_ACTION.HTML_NBSP.'</td>
	              </tr>
';
	$icon_arrow=olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', IMAGE_ICON_ARROW);
	$icon_info=olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO);
	$installed_modules = array();
	for ($i = 0, $n = sizeof($directory_array); $i < $n; $i++)
	{
		$file = $directory_array[$i];
		$class = substr($file, 0, strrpos($file, DOT));
		$is_object_mInfo_and_same_class=$is_object_mInfo && ($class == $mInfo_code);
		if (!$is_object_mInfo_and_same_class)
		{
			include_once($module_language_directory. $file);
			include_once($module_directory . $file);
		}
		if (olc_class_exists($class))
		{
			$module = new $class;
			if ($module->check() > 0)
			{
				if ($module->sort_order > 0)
				{
					$installed_modules[$module->sort_order] = $file;
				}
				else
				{
					$installed_modules[] = $file;
				}
			}
			$module_parameters_class=$module_parameters0 . $class;
			if ($is_object_mInfo_and_same_class)
			{
				if ($module->check() > 0)
				{
					$main_content.='              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:'.
					olc_onclick_link(FILENAME_MODULES, $module_parameters_class . $action_text.'edit') . '">
';
				}
				else
				{
					$main_content.='              <tr class="dataTableRowSelected">
';
				}
			}
			else
			{
				$main_content.='
              	<tr class="dataTableRow"
									onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'"
									onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' .
				olc_onclick_link(FILENAME_MODULES, $module_parameters_class) . '">
';
			}
			$s=$module->sort_order;
			$s=(is_numeric($s))?$module->sort_order:EMPTY_STRING;
			$main_content.='
				          <td class="dataTableContent">'.$module->title.'</td>
									<td class="dataTableContent">'.str_replace(PHP,EMPTY_STRING,$file).'</td>
	                <td class="dataTableContent" align="right">'.$s.HTML_NBSP.'</td>
	                <td class="dataTableContent" align="center">
';
			if ($is_object_mInfo_and_same_class)
			{
				$main_content.=$icon_arrow;
			}
			else
			{
				$main_content.= HTML_A_START .
				olc_href_link(FILENAME_MODULES, $module_parameters_class) . '">' .$icon_info . HTML_A_END;
			}
			$main_content.=HTML_NBSP.'
	                </td>
	              </tr>
';
		}
	}
	ksort($installed_modules);
	$check_query = olc_db_query(SELECT."configuration_value".SQL_FROM . TABLE_CONFIGURATION .
	SQL_WHERE."configuration_key = '" . $module_key . APOS);
	if (olc_db_num_rows($check_query))
	{
		$implode_installed_modules=implode(SEMI_COLON, $installed_modules);
		$check = olc_db_fetch_array($check_query);
		if ($check['configuration_value'] != $implode_installed_modules)
		{
			olc_db_query(SQL_UPDATE . TABLE_CONFIGURATION . " set configuration_value = '" .
			$implode_installed_modules . "', last_modified = now()
			where configuration_key = '" . $module_key . APOS);
		}
	}
	else
	{
		olc_db_query(INSERT_INTO . TABLE_CONFIGURATION .
		" (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ( '" .
		$module_key . "', '" . implode(SEMI_COLON, $installed_modules) . "','6', '0', now())");
	}
	$s=str_replace('\\',SLASH,$_SERVER['DOCUMENT_ROOT']);
	$s=HTML_BR.HTML_B_START.TEXT_MODULE_DIRECTORY.HTML_B_END . BLANK . str_replace($s,EMPTY_STRING,$module_directory);
	$main_content.='
	              <tr>
	                <td colspan="4" class="smallText">'.
										$s.'
	                </td>
	              </tr>
	            </table>
';
}
$two_br .= HTML_BR.HTML_BR;
$new_line=HTML_B_END.HTML_BR;
$heading = array('text' => HTML_B_START . $mInfo->title . HTML_B_END);
$contents = array('form' => olc_draw_form('modules', FILENAME_MODULES,
  'set=' . $set . '&module=' . $get_module . '&action=save'));
$keys = EMPTY_STRING;
$is_installed=$mInfo->status <> '0';

if ($is_installed)
{
	$action_x='remove';
}
else
{
	$action_x='install';
}
$remove_install_button=
HTML_A_START .
olc_href_link(FILENAME_MODULES, $module_parameters0 . $mInfo_code . $action_text.$action_x) .'">' .
olc_image_button('button_module_'.$action_x.'.gif', constant('IMAGE_MODULE_'.strtoupper($action_x))).
HTML_A_END;
$cancel_link=HTML_A_START . $cancel_link . '">' .olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END;
reset($mInfo->keys);
if ($css_dynamic_menu)
{
	$align='left';
}
else
{
	$align='center';
}
$contents[] = array(
'align' => $align,
'text' =>	$remove_install_button,$two_br);
if ($is_installed)
{
	while (list($key, $value) = each($mInfo->keys))
	{
		$keys .= HTML_B_START . $value['title'] . $new_line .  $value['description'].HTML_BR;
		$value_value=$value['value'];
		$set_function0=$value['set_function'];
		if ($set_function0)
		{
			$set_function='$keys .= ' .$set_function0 . APOS . $value_value . "', '" . $key . "');";
			$set_function=stripslashes($set_function);
			eval($set_function);
		}
		else
		{
			$keys .= olc_draw_input_field('configuration[' . $key . ']', $value_value,'size="'.$field_size.QUOTE);
		}
		$keys .= $two_br;
	}
	$keys = substr($keys, 0, strrpos($keys, $two_br));
	$contents[] = array('form' => olc_draw_form('modules', FILENAME_MODULES, $module_parameters . $action_text.'save'));
	$contents[] = array('text' => $keys);
	$contents[] = array('align' => 'center', 'text' => HTML_BR .olc_image_submit('button_update.gif', IMAGE_UPDATE) .
	HTML_NBSP. $cancel_link);
}
$main_content.='          <td width="25%" valign="top">
';
$box = new box;
$main_content.= $box->infoBox($heading, $contents);

define('AJAX_TITLE',HEADING_TITLE);
$page_header_title=AJAX_TITLE;
$page_header_subtitle='OLC Module';
$page_header_icon_image=HEADING_MODULES_ICON;
$show_column_right=false;
$no_left_menu=false;
require(PROGRAM_FRAME);
