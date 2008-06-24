<?php
/* --------------------------------------------------------------
$Id: module_export.php,v 1.1.1.1.2.1 2007/04/08 07:16:29 gswkaiser Exp $

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
require_once(DIR_WS_FUNCTIONS . 'export_functions.php');
$module_type = 'export';
$module_directory = DIR_WS_MODULES . 'export/';
$module_key = 'MODULE_EXPORT_INSTALLED';
$file_extension = PHP;
define('HEADING_TITLE', HEADING_TITLE_MODULES_EXPORT);
if (isset($_GET['error'])) {
	$messageStack->add($_GET['error'], 'error');
}
$action=$_GET['action'];
switch ($action) {
	case 'save':
		while (list($key, $value) = each($_POST['configuration'])) {
			olc_db_query(SQL_UPDATE . TABLE_CONFIGURATION .
				" set configuration_value = '" . $value . "' where configuration_key = '" . $key . APOS);
			if (substr($key,'FILE')) $file=$value;
		}
		$class = basename($_GET['module']);
		include_once($module_directory . $class . $file_extension);
		$module = new $class;
		$module->process($file);
		//olc_redirect(olc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $class));
		$action=EMPTY_STRING;
		break;
	case 'install':
	case 'remove':
		$file_extension = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '.'));
		$class = basename($_GET['module']);
		if (file_exists($module_directory . $class . $file_extension)) {
			include_once($module_directory . $class . $file_extension);
			$module = new $class;
			if ($action == 'install') {
				$module->install();
			} elseif ($action == 'remove') {
				$module->remove();
			}
		}
		//olc_redirect(olc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $class));
		$action=EMPTY_STRING;
		break;
}
?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="columnLeft2" nowrap="nowrap" valign="top"><table border="0" cellspacing="1" cellpadding="1" class="columnLeft" nowrap="nowrap">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="80" rowspan="2"><?php echo olc_image(HEADING_MODULES_ICON); ?></td>
    <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
  </tr>
  <tr>
    <td class="main" valign="top">OLC Module</td>
  </tr>
</table> </td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_MODULES; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
$file_extension = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '.'));
$directory_array = array();
if ($dir = @dir($module_directory)) {
	while ($file = $dir->read()) {
		if (!is_dir($module_directory . $file)) {
			if (substr($file, strrpos($file, '.')) == $file_extension) {
				$directory_array[] = $file;
			}
		}
	}
	sort($directory_array);
	$dir->close();
}

$installed_modules = array();
for ($i = 0, $n = sizeof($directory_array); $i < $n; $i++) {
	$file = $directory_array[$i];

	//   include_once(DIR_FS_LANGUAGES . SESSION_LANGUAGE . '/modules/' . $module_type . '/' . $file);
	include_once($module_directory . $file);

	$class = substr($file, 0, strrpos($file, '.'));
	if (olc_class_exists($class)) {
		$module = new $class;
		if ($module->check() > 0) {
			if ($module->sort_order > 0) {
				$installed_modules[$module->sort_order] = $file;
			} else {
				$installed_modules[] = $file;
			}
		}

		if (((!$_GET['module']) || ($_GET['module'] == $class)) && (!$mInfo)) {
			$module_info = array('code' => $module->code,
			'title' => $module->title,
			'description' => $module->description,
			'status' => $module->check());

			$module_keys = $module->keys();
			$keys_extra = array();
			for ($j = 0, $k = sizeof($module_keys); $j < $k; $j++) {
				$key_value_query =
					olc_db_query("select configuration_key,configuration_value, use_function, set_function from " .
					TABLE_CONFIGURATION . " where configuration_key = '" . $module_keys[$j] . APOS);
				$key_value = olc_db_fetch_array($key_value_query);
				$constant_name=strtoupper($key_value['configuration_key']);
				if ($key_value['configuration_key'] !='')
					$keys_extra[$module_keys[$j]]['title'] = constant($constant_name .'_TITLE');
				$keys_extra[$module_keys[$j]]['value'] = $key_value['configuration_value'];
				if ($key_value['configuration_key'] !='')
					$keys_extra[$module_keys[$j]]['description'] = constant($constant_name .'_DESC');
				$keys_extra[$module_keys[$j]]['use_function'] = $key_value['use_function'];
				$keys_extra[$module_keys[$j]]['set_function'] = $key_value['set_function'];
			}
			$module_info['keys'] = $keys_extra;
			$mInfo = new objectInfo($module_info);
		}
		if ( (is_object($mInfo)) && ($class == $mInfo->code) ) {
			if ($module->check() > 0) {
				echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="javascript:'.
				olc_onclick_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $class . '&action=edit') . '">' . NEW_LINE;
			} else {
				echo '              <tr class="dataTableRowSelected">' . NEW_LINE;
			}
		} else {
			echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="javascript:' . olc_onclick_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $class) . '">' . NEW_LINE;
		}
?>
                <td class="dataTableContent"><?php echo $module->title; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($mInfo)) && ($class == $mInfo->code) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo HTML_A_START . olc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $class) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
	}
}
ksort($installed_modules);
$check_query = olc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = '" . $module_key . APOS);
if (olc_db_num_rows($check_query)) {
	$check = olc_db_fetch_array($check_query);
	if ($check['configuration_value'] != implode(';', $installed_modules)) {
		olc_db_query(SQL_UPDATE . TABLE_CONFIGURATION . " set configuration_value = '" . implode(';', $installed_modules) . "', last_modified = now() where configuration_key = '" . $module_key . APOS);
	}
} else {
	olc_db_query(INSERT_INTO . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ( '" . $module_key . "', '" . implode(';', $installed_modules) . "','6', '0', now())");
}
?>
              <tr>
                <td colspan="3" class="smallText"><?php echo TEXT_MODULE_DIRECTORY . ' admin/' . $module_directory; ?></td>
              </tr>
            </table></td>
<?php
$heading = array();
$contents = array();
switch ($action) {
	case 'edit':
		$keys = '';
		reset($mInfo->keys);
		while (list($key, $value) = each($mInfo->keys)) {
			// if($value['description']!='_DESC' && $value['title']!='_TITLE'){
			$keys .= HTML_B_START . $value['title'] . '</b><br/>' .  $value['description'].HTML_BR;
			//	}
			if ($value['set_function']) {
				eval('$keys .= ' . $value['set_function'] . APOS . $value['value'] . "', '" . $key . "');");
			} else {
				$keys .= olc_draw_input_field('configuration[' . $key . ']', $value['value']);
			}
			$keys .= '<br/><br/>';
		}
		$keys = substr($keys, 0, strrpos($keys, '<br/><br/>'));

		$heading[] = array('text' => HTML_B_START . $mInfo->title . HTML_B_END);
		$class = substr($file, 0, strrpos($file, '.'));
		$module = new $_GET['module'];
		$contents = array('form' => olc_draw_form('modules', FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $_GET['module'] . '&action=save','post'));
		$contents[] = array('text' => $keys);
		// display module fields
		$contents[] = $module->display();
		break;
	default:
		$heading[] = array('text' => HTML_B_START . $mInfo->title . HTML_B_END);
		if ($mInfo->status <> '0') {
			$keys = '';
			reset($mInfo->keys);
			while (list(, $value) = each($mInfo->keys)) {
				$keys .= HTML_B_START . $value['title'] . '</b><br/>';
				if ($value['use_function']) {
					$use_function = $value['use_function'];
					if (ereg('->', $use_function)) {
						$class_method = explode('->', $use_function);
						if (!is_object(${$class_method[0]})) {
							include_once(DIR_WS_CLASSES . $class_method[0] . PHP);
							${$class_method[0]} = new $class_method[0]();
						}
						$keys .= olc_call_function($class_method[1], $value['value'], ${$class_method[0]});
					} else {
						$keys .= olc_call_function($use_function, $value['value']);
					}
				} else {
					if(strlen($value['value']) > 30) {
						$keys .=  substr($value['value'],0,30) . ' ...';
					} else {
						$keys .=  $value['value'];
					}
				}
				$keys .= '<br/><br/>';
			}
			$keys = substr($keys, 0, strrpos($keys, '<br/><br/>'));

			$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $mInfo->code . '&action=remove') . '">' . olc_image_button('button_module_remove.gif', IMAGE_MODULE_REMOVE) . '</a> <a href="' . olc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $_GET['module'] . '&action=edit') . '">' . olc_image_button('button_export.gif', IMAGE_EDIT) . HTML_A_END);
			$contents[] = array('text' => HTML_BR . $mInfo->description);
			$contents[] = array('text' => HTML_BR . $keys);
		} else {
			$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $mInfo->code . '&action=install') . '">' . olc_image_button('button_module_install.gif', IMAGE_MODULE_INSTALL) . HTML_A_END);
			$contents[] = array('text' => HTML_BR . $mInfo->description);
		}
		break;
}

if ( (olc_not_null($heading)) && (olc_not_null($contents)) ) {
	echo '            <td width="25%" valign="top">' . NEW_LINE;

	$box = new box;
	echo $box->infoBox($heading, $contents);

	echo '            </td>' . NEW_LINE;
}
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
