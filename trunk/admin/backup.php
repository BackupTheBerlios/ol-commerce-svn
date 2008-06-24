<?php
/* --------------------------------------------------------------
$Id: backup.php,v 1.1.1.1.2.1 2007/04/08 07:16:25 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(backup.php,v 1.57 2003/03/22); www.oscommerce.com
(c) 2003	    nextcommerce (backup.php,v 1.11 2003/08/2); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');

if ($_GET['action']) {
	switch ($_GET['action']) {
		case 'forget':
			olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key = 'DB_LAST_RESTORE'");
			$messageStack->add_session(SUCCESS_LAST_RESTORE_CLEARED, 'success');
			olc_redirect(olc_href_link(FILENAME_BACKUP));
			break;
		case 'backupnow':
			@olc_set_time_limit(0);
			$schema = '# OL-Commerce ' . NEW_LINE .
			'# http://www.ol-commerce.com, http://www.seifenparadies.de' . NEW_LINE .
			'#' . NEW_LINE .
			'# Database Backup For ' . STORE_NAME . NEW_LINE .
			'# Copyright (c) ' . date('Y') . BLANK . STORE_OWNER . NEW_LINE .
			'#' . NEW_LINE .
			'# Database: ' . DB_DATABASE . NEW_LINE .
			'# Database Server: ' . DB_SERVER . NEW_LINE .
			'#' . NEW_LINE .
			'# Backup Date: ' . date(PHP_DATE_TIME_FORMAT) . "\n\n";
			$drop_table_text='drop table if exists ';
			$create_table_text='create table ';
			$tables_query = olc_db_query('show tables');
			while ($tables = olc_db_fetch_array($tables_query)) {
				list(,$table) = each($tables);
				$schema .= $drop_table_text . $table . ';' . NEW_LINE .
				$create_table_text . $table . LPAREN . NEW_LINE;
				$table_list = array();
				$fields_query = olc_db_query("show fields from " . $table);
				while ($fields = olc_db_fetch_array($fields_query)) {
					$table_list[] = $fields['Field'];
					$schema .= '  ' . $fields['Field'] . BLANK . $fields['Type'];
					if (strlen($fields['Default']) > 0) $schema .= ' default \'' . $fields['Default'] . '\'';
					if ($fields['Null'] != 'YES') $schema .= ' not null';
					if (isset($fields['Extra'])) $schema .= BLANK . $fields['Extra'];
					$schema .= ',' . NEW_LINE;
				}
				$schema = ereg_replace(",\n$", '', $schema);
				// Add the keys
				$index = array();
				$keys_query = olc_db_query("show keys from " . $table);
				while ($keys = olc_db_fetch_array($keys_query)) {
					$kname = $keys['Key_name'];
					if (!isset($index[$kname])) {
						$index[$kname] = array('unique' => !$keys['Non_unique'],
						'columns' => array());
					}
					$index[$kname]['columns'][] = $keys['Column_name'];
				}
				while (list($kname, $info) = each($index)) {
					$schema .= ',' . NEW_LINE;
					$columns = implode($info['columns'], ', ');
					if ($kname == 'PRIMARY') {
						$schema .= '  PRIMARY KEY (' . $columns . RPAREN;
					} elseif ($info['unique']) {
						$schema .= '  UNIQUE ' . $kname . LPAREN . $columns . RPAREN;
					} else {
						$schema .= '  KEY ' . $kname . LPAREN . $columns . RPAREN;
					}
				}
				$schema .= NEW_LINE . ');' . "\n\n";

				// Dump the data
				//$rows_query = olc_db_query("select " . implode(',', $table_list) . " from " . $table);
				$schema_insert0 = 'insert into ' . $table . LPAREN . implode(', ', $table_list) . ') values (';
				$rows_query = olc_db_query("select * from " . $table);
				while ($rows = olc_db_fetch_array($rows_query)) {
					$schema_insert = $schema_insert0;
					reset($table_list);
					while (list(,$i) = each($table_list)) {
						if (!isset($rows[$i])) {
							$schema_insert .= 'NULL, ';
						} elseif ($rows[$i] != '') {
							$row = addslashes($rows[$i]);
							$row = ereg_replace("\n#", NEW_LINE.'\#', $row);
							$schema_insert .= '\'' . $row . '\', ';
						} else {
							$schema_insert .= '\'\', ';
						}
					}
					$schema_insert = ereg_replace(', $', '', $schema_insert) . ');' . NEW_LINE;
					$schema .= $schema_insert;
				}
				$schema .= NEW_LINE;
			}

			if ($_POST['download'] == 'yes') {
				$backup_file = 'db_' . DB_DATABASE . '-' . date('YmdHis') . '.sql';
				switch ($_POST['compress']) {
					case 'no':
						header('Content-type: application/x-octet-stream');
						header('Content-disposition: attachment; filename=' . $backup_file);
						echo $schema;
						exit;
						break;
					case 'gzip':
						if ($fp = fopen(DIR_FS_BACKUP . $backup_file, 'w')) {
							fputs($fp, $schema);
							fclose($fp);
							exec(LOCAL_EXE_GZIP . BLANK . DIR_FS_BACKUP . $backup_file);
							$backup_file .= '.gz';
						}
						if ($fp = fopen(DIR_FS_BACKUP . $backup_file, 'rb')) {
							$buffer = fread($fp, filesize(DIR_FS_BACKUP . $backup_file));
							fclose($fp);
							unlink(DIR_FS_BACKUP . $backup_file);
							header('Content-type: application/x-octet-stream');
							header('Content-disposition: attachment; filename=' . $backup_file);
							echo $buffer;
							exit;
						}
						break;
					case 'zip':
						if ($fp = fopen(DIR_FS_BACKUP . $backup_file, 'w')) {
							fputs($fp, $schema);
							fclose($fp);
							exec(LOCAL_EXE_ZIP . ' -j ' . DIR_FS_BACKUP . $backup_file . '.zip ' . DIR_FS_BACKUP . $backup_file);
							unlink(DIR_FS_BACKUP . $backup_file);
							$backup_file .= '.zip';
						}
						if ($fp = fopen(DIR_FS_BACKUP . $backup_file, 'rb')) {
							$buffer = fread($fp, filesize(DIR_FS_BACKUP . $backup_file));
							fclose($fp);
							unlink(DIR_FS_BACKUP . $backup_file);
							header('Content-type: application/x-octet-stream');
							header('Content-disposition: attachment; filename=' . $backup_file);
							echo $buffer;
							exit;
						}
				}
			} else {
				$backup_file = DIR_FS_BACKUP . 'db_' . DB_DATABASE . '-' . date('YmdHis') . '.sql';
				if ($fp = fopen($backup_file, 'w')) {
					fputs($fp, $schema);
					fclose($fp);
					switch ($_POST['compress']) {
						case 'gzip':
							exec(LOCAL_EXE_GZIP . BLANK . $backup_file);
							break;
						case 'zip':
							exec(LOCAL_EXE_ZIP . ' -j ' . $backup_file . '.zip ' . $backup_file);
							unlink($backup_file);
					}
				}
				$messageStack->add_session(SUCCESS_DATABASE_SAVED, 'success');
			}
			olc_redirect(olc_href_link(FILENAME_BACKUP));
			break;
		case 'restorenow':
		case 'restorelocalnow':
			@olc_set_time_limit(0);
			if ($_GET['action'] == 'restorenow') {
				$read_from = $_GET['file'];
				if (file_exists(DIR_FS_BACKUP . $_GET['file'])) {
					$restore_file = DIR_FS_BACKUP . $_GET['file'];
					$extension = substr($_GET['file'], -3);
					if ( ($extension == 'sql') || ($extension == '.gz') || ($extension == 'zip') ) {
						switch ($extension) {
							case 'sql':
								$restore_from = $restore_file;
								$remove_raw = false;
								break;
							case '.gz':
								$restore_from = substr($restore_file, 0, -3);
								exec(LOCAL_EXE_GUNZIP . BLANK . $restore_file . ' -c > ' . $restore_from);
								$remove_raw = true;
								break;
							case 'zip':
								$restore_from = substr($restore_file, 0, -4);
								exec(LOCAL_EXE_UNZIP . BLANK . $restore_file . ' -d ' . DIR_FS_BACKUP);
								$remove_raw = true;
						}

						if ( ($restore_from) && (file_exists($restore_from)) && (filesize($restore_from) > 15000) ) {
							$fd = fopen($restore_from, 'rb');
							$restore_query = fread($fd, filesize($restore_from));
							fclose($fd);
						}
					}
				}
			} elseif ($_GET['action'] == 'restorelocalnow') {
				$sql_file = new upload('sql_file');

				if ($sql_file->parse() == true) {
					$restore_query = fread(fopen($sql_file->tmp_filename, 'r'), filesize($sql_file->tmp_filename));
					$read_from = $sql_file->filename;
				}
			}

			if ($restore_query) {
				$sql_array = array();
				$sql_length = strlen($restore_query);
				$pos = strpos($restore_query, ';');
				for ($i=$pos; $i<$sql_length; $i++) {
					if ($restore_query[0] == '#') {
						$restore_query = ltrim(substr($restore_query, strpos($restore_query, NEW_LINE)));
						$sql_length = strlen($restore_query);
						$i = strpos($restore_query, ';')-1;
						continue;
					}
					if ($restore_query[($i+1)] == NEW_LINE) {
						for ($j=($i+2); $j<$sql_length; $j++) {
							if (trim($restore_query[$j]) != '') {
								$next = substr($restore_query, $j, 6);
								if ($next[0] == '#') {
									// find out where the break position is so we can remove this line (#comment line)
									for ($k=$j; $k<$sql_length; $k++) {
										if ($restore_query[$k] == NEW_LINE) break;
									}
									$query = substr($restore_query, 0, $i+1);
									$restore_query = substr($restore_query, $k);
									// join the query before the comment appeared, with the rest of the dump
									$restore_query = $query . $restore_query;
									$sql_length = strlen($restore_query);
									$i = strpos($restore_query, ';')-1;
									continue 2;
								}
								break;
							}
						}
						if ($next == '') { // get the last insert query
							$next = 'insert';
						}
						if ( (eregi('create', $next)) || (eregi('insert', $next)) || (eregi('drop t', $next)) ) {
							$next = '';
							$sql_array[] = substr($restore_query, 0, $i);
							$restore_query = ltrim(substr($restore_query, $i+1));
							$sql_length = strlen($restore_query);
							$i = strpos($restore_query, ';')-1;
						}
					}
				}
				/*
				//Obsolete, as backup contains 'drop table if exists ' statements
				//olc_db_query("drop table if exists address_book, admin_access,banktransfer,content_manager,address_format, banners, banners_history, categories, categories_description, configuration, configuration_group, counter, counter_history, countries, currencies, customers, customers_basket, customers_basket_attributes, customers_info, languages, manufacturers, manufacturers_info, orders, orders_products, orders_status, orders_status_history, orders_products_attributes, orders_products_download, products, products_attributes, products_attributes_download, prodcts_description, products_options, products_options_values, products_options_values_to_products_options, products_to_categories, reviews, reviews_description, sessions, specials, tax_class, tax_rates, geo_zones, whos_online, zones, zones_to_geo_zones");
				olc_db_query("drop table if exists ".
				TABLE_ADDRESS_BOOK.COMMA.
				TABLE_ADMIN_ACCESS.COMMA.
				TABLE_BANKTRANSFER.COMMA.
				TABLE_CONTENT_MANAGER.COMMA.
				TABLE_ADDRESS_FORMAT.COMMA.
				TABLE_BANNERS.COMMA.
				TABLE_BANNERS_HISTORY.COMMA.
				TABLE_CATEGORIES.COMMA.
				TABLE_CATEGORIES_DESCRIPTION.COMMA.
				TABLE_CONFIGURATION.COMMA.
				TABLE_CONFIGURATION_GROUP.COMMA.
				TABLE_COUNTER.COMMA.
				TABLE_COUNTER_HISTORY.COMMA.
				TABLE_COUNTRIES.COMMA.
				TABLE_CURRENCIES.COMMA.
				TABLE_CUSTOMERS.COMMA.
				TABLE_CUSTOMERS_BASKET.COMMA.
				TABLE_CUSTOMERS_BASKET_ATTRIBUTES.COMMA.
				TABLE_CUSTOMERS_INFO.COMMA.
				TABLE_LANGUAGES.COMMA.
				TABLE_MANUFACTURERS.COMMA.
				TABLE_MANUFACTURERS_INFO.COMMA.
				TABLE_ORDERS.COMMA.
				TABLE_ORDERS_PRODUCTS.COMMA.
				TABLE_ORDERS_STATUS.COMMA.
				TABLE_ORDERS_STATUS_HISTORY.COMMA.
				TABLE_ORDERS_PRODUCTS_ATTRIBUTES.COMMA.
				TABLE_ORDERS_PRODUCTS_DOWNLOAD.COMMA.
				TABLE_PRODUCTS.COMMA.
				TABLE_PRODUCTS_ATTRIBUTES.COMMA.
				TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD.COMMA.
				TABLE_PRODCTS_DESCRIPTION.COMMA.
				TABLE_PRODUCTS_OPTIONS.COMMA.
				TABLE_PRODUCTS_OPTIONS_VALUES.COMMA.
				TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS.COMMA.
				TABLE_PRODUCTS_TO_CATEGORIES.COMMA.
				TABLE_REVIEWS.COMMA.
				TABLE_REVIEWS_DESCRIPTION.COMMA.
				TABLE_SESSIONS.COMMA.
				TABLE_SPECIALS.COMMA.
				TABLE_TAX_CLASS.COMMA.
				TABLE_TAX_RATES.COMMA.
				TABLE_GEO_ZONES.COMMA.
				TABLE_WHOS_ONLINE.COMMA.
				TABLE_ZONES.COMMA.
				TABLE_ZONES_TO_GEO_ZONES
				);
				*/
				for ($i = 0, $n = sizeof($sql_array); $i < $n; $i++)
				{
					olc_db_query($sql_array[$i]);
				}
				olc_db_query(DELETE_FROM . TABLE_CONFIGURATION . " where configuration_key = 'DB_LAST_RESTORE'");
				olc_db_query(INSERT_INTO . TABLE_CONFIGURATION .
					" (configuration_key,configuration_value,configuration_group_id) values ('DB_LAST_RESTORE', '" . $read_from . "','6')");
				if ($remove_raw) {
					unlink($restore_from);
				}
			}

			$messageStack->add_session(SUCCESS_DATABASE_RESTORED, 'success');
			olc_redirect(olc_href_link(FILENAME_BACKUP));
			break;
		case 'download':
			$extension = substr($_GET['file'], -3);
			if ( ($extension == 'zip') || ($extension == '.gz') || ($extension == 'sql') ) {
				if ($fp = fopen(DIR_FS_BACKUP . $_GET['file'], 'rb')) {
					$buffer = fread($fp, filesize(DIR_FS_BACKUP . $_GET['file']));
					fclose($fp);
					header('Content-type: application/x-octet-stream');
					header('Content-disposition: attachment; filename=' . $_GET['file']);
					echo $buffer;
					exit;
				}
			} else {
				$messageStack->add(ERROR_DOWNLOAD_LINK_NOT_ACCEPTABLE, 'error');
			}
			break;
		case 'deleteconfirm':
			if (strstr($_GET['file'], '..')) olc_redirect(olc_href_link(FILENAME_BACKUP));

			olc_remove(DIR_FS_BACKUP . '/' . $_GET['file']);
			if (!$olc_remove_error) {
				$messageStack->add_session(SUCCESS_BACKUP_DELETED, 'success');
				olc_redirect(olc_href_link(FILENAME_BACKUP));
			}
			break;
	}
}

// check if the backup directory exists
$dir_ok = false;
if (is_dir(DIR_FS_BACKUP)) {
	$dir_ok = true;
	if (!is_writeable(DIR_FS_BACKUP)) $messageStack->add(ERROR_BACKUP_DIRECTORY_NOT_WRITEABLE, 'error');
} else {
	$messageStack->add(ERROR_BACKUP_DIRECTORY_DOES_NOT_EXIST, 'error');
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
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TITLE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_FILE_DATE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_FILE_SIZE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
if ($dir_ok) {
	$dir = dir(DIR_FS_BACKUP);
	$contents = array();
	$exts = array("sql");
	while ($file = $dir->read()) {
		if (!is_dir(DIR_FS_BACKUP . $file)) {
			foreach ($exts as $value) {
				if (olc_CheckExt($file, $value)) {

					$contents[] = $file;
				}
			}
		}
	}
	sort($contents);

	for ($files = 0, $count = sizeof($contents); $files < $count; $files++) {
		$entry = $contents[$files];

		$check = 0;

		if (((!$_GET['file']) || ($_GET['file'] == $entry)) && (!$buInfo) && ($_GET['action'] != 'backup') && ($_GET['action'] != 'restorelocal')) {
			$file_array['file'] = $entry;
			$file_array['date'] = date(PHP_DATE_TIME_FORMAT, filemtime(DIR_FS_BACKUP . $entry));
			$file_array['size'] = number_format(filesize(DIR_FS_BACKUP . $entry)) . ' bytes';
			switch (substr($entry, -3)) {
				case 'zip': $file_array['compression'] = 'ZIP'; break;
				case '.gz': $file_array['compression'] = 'GZIP'; break;
				default: $file_array['compression'] = TEXT_NO_EXTENSION; break;
			}

			$buInfo = new objectInfo($file_array);
		}

		if (is_object($buInfo) && ($entry == $buInfo->file)) {
			echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'">' . NEW_LINE;
			$onclick_link = 'file=' . $buInfo->file . '&action=restore';
		} else {
			echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'">' . NEW_LINE;
			$onclick_link = 'file=' . $entry;
		}
?>
                <td class="dataTableContent" onclick="javascript:<?php olc_onclick_link(FILENAME_BACKUP, $onclick_link); ?>"><?php echo HTML_A_START . olc_href_link(FILENAME_BACKUP, 'action=download&file=' . $entry) . '">' . olc_image(DIR_WS_ICONS . 'file_download.gif', ICON_FILE_DOWNLOAD) . '</a>&nbsp;' . $entry; ?></td>
                <td class="dataTableContent" align="center" onclick="javascript:<?php echo olc_onclick_link(FILENAME_BACKUP, $onclick_link); ?>"><?php echo date(PHP_DATE_TIME_FORMAT, filemtime(DIR_FS_BACKUP . $entry)); ?></td>
                <td class="dataTableContent" align="right" onclick="javascript:<?php echo olc_onclick_link(FILENAME_BACKUP, $onclick_link); ?>"><?php echo number_format(filesize(DIR_FS_BACKUP . $entry)); ?> bytes</td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($buInfo)) && ($entry == $buInfo->file) ) { echo olc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo HTML_A_START . olc_href_link(FILENAME_BACKUP, 'file=' . $entry) . '">' . olc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . HTML_A_END; } ?>&nbsp;</td>
              </tr>
<?php
	}
	$dir->close();
}
?>
              <tr>
                <td class="smallText" colspan="3"><?php echo TEXT_BACKUP_DIRECTORY . BLANK . DIR_FS_BACKUP; ?></td>
                <td align="right" class="smallText"><?php if ( ($_GET['action'] != 'backup') && ($dir) ) echo HTML_A_START . olc_href_link(FILENAME_BACKUP, 'action=backup') . '">' . olc_image_button('button_backup.gif', IMAGE_BACKUP) . HTML_A_END; if ( ($_GET['action'] != 'restorelocal') && ($dir) ) echo '&nbsp;&nbsp;<a href="' . olc_href_link(FILENAME_BACKUP, 'action=restorelocal') . '">' . olc_image_button('button_restore.gif', IMAGE_RESTORE) . HTML_A_END; ?></td>
              </tr>
<?php
if (defined('DB_LAST_RESTORE')) {
?>
              <tr>
                <td class="smallText" colspan="4"><?php echo TEXT_LAST_RESTORATION . BLANK . DB_LAST_RESTORE . BLANK.HTML_A_START . olc_href_link(FILENAME_BACKUP, 'action=forget') . '">' . TEXT_FORGET . HTML_A_END; ?></td>
              </tr>
<?php
}
?>
            </table></td>
<?php
$heading = array();
$contents = array();
switch ($_GET['action']) {
	case 'backup':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_NEW_BACKUP . HTML_B_END);

		$contents = array('form' => olc_draw_form('backup', FILENAME_BACKUP, 'action=backupnow'));
		$contents[] = array('text' => TEXT_INFO_NEW_BACKUP);

		if ($messageStack->size > 0) {
			$contents[] = array('text' => HTML_BR . olc_draw_radio_field('compress', 'no', true) . BLANK . TEXT_INFO_USE_NO_COMPRESSION);
			$contents[] = array('text' => HTML_BR . olc_draw_radio_field('download', 'yes', true) . BLANK . TEXT_INFO_DOWNLOAD_ONLY . '*<br/><br/>*' . TEXT_INFO_BEST_THROUGH_HTTPS);
		} else {
			$contents[] = array('text' => HTML_BR . olc_draw_radio_field('compress', 'gzip', true) . BLANK . TEXT_INFO_USE_GZIP);
			$contents[] = array('text' => olc_draw_radio_field('compress', 'zip') . BLANK . TEXT_INFO_USE_ZIP);
			$contents[] = array('text' => olc_draw_radio_field('compress', 'no') . BLANK . TEXT_INFO_USE_NO_COMPRESSION);
			$contents[] = array('text' => HTML_BR . olc_draw_checkbox_field('download', 'yes') . BLANK . TEXT_INFO_DOWNLOAD_ONLY . '*<br/><br/>*' . TEXT_INFO_BEST_THROUGH_HTTPS);
		}

		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_backup.gif', IMAGE_BACKUP) . '&nbsp;<a href="' . olc_href_link(FILENAME_BACKUP) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;
	case 'restore':
		$heading[] = array('text' => HTML_B_START . $buInfo->date . HTML_B_END);

		$contents[] = array('text' => olc_break_string(sprintf(TEXT_INFO_RESTORE, DIR_FS_BACKUP . (($buInfo->compression != TEXT_NO_EXTENSION) ? substr($buInfo->file, 0, strrpos($buInfo->file, '.')) : $buInfo->file), ($buInfo->compression != TEXT_NO_EXTENSION) ? TEXT_INFO_UNPACK : ''), 35, BLANK));
		$contents[] = array('align' => 'center', 'text' => '<br/><a href="' . olc_href_link(FILENAME_BACKUP, 'file=' . $buInfo->file . '&action=restorenow') . '">' . olc_image_button('button_restore.gif', IMAGE_RESTORE) . '</a>&nbsp;<a href="' . olc_href_link(FILENAME_BACKUP, 'file=' . $buInfo->file) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;
	case 'restorelocal':
		$heading[] = array('text' => HTML_B_START . TEXT_INFO_HEADING_RESTORE_LOCAL . HTML_B_END);

		$contents = array('form' => olc_draw_form('restore', FILENAME_BACKUP, 'action=restorelocalnow', 'post', 'enctype="multipart/form-data"'));
		$contents[] = array('text' => TEXT_INFO_RESTORE_LOCAL . '<br/><br/>' . TEXT_INFO_BEST_THROUGH_HTTPS);
		$contents[] = array('text' => HTML_BR . olc_draw_file_field('sql_file'));
		$contents[] = array('text' => TEXT_INFO_RESTORE_LOCAL_RAW_FILE);
		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_restore.gif', IMAGE_restore) . '&nbsp;<a href="' . olc_href_link(FILENAME_BACKUP) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;
	case 'delete':
		$heading[] = array('text' => HTML_B_START . $buInfo->date . HTML_B_END);

		$contents = array('form' => olc_draw_form('delete', FILENAME_BACKUP, 'file=' . $buInfo->file . '&action=deleteconfirm'));
		$contents[] = array('text' => TEXT_DELETE_INTRO);
		$contents[] = array('text' => '<br/><b>' . $buInfo->file . HTML_B_END);
		$contents[] = array('align' => 'center', 'text' => HTML_BR . olc_image_submit('button_delete.gif', IMAGE_DELETE) . BLANK.HTML_A_START . olc_href_link(FILENAME_BACKUP, 'file=' . $buInfo->file) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . HTML_A_END);
		break;
	default:
		if (is_object($buInfo)) {
			$heading[] = array('text' => HTML_B_START . $buInfo->date . HTML_B_END);

			$contents[] = array('align' => 'center', 'text' => HTML_A_START . olc_href_link(FILENAME_BACKUP, 'file=' . $buInfo->file . '&action=restore') . '">' . olc_image_button('button_restore.gif', IMAGE_RESTORE) . '</a> <a href="' . olc_href_link(FILENAME_BACKUP, 'file=' . $buInfo->file . '&action=delete') . '">' . olc_image_button('button_delete.gif', IMAGE_DELETE) . HTML_A_END);
			$contents[] = array('text' => HTML_BR . TEXT_INFO_DATE . BLANK . $buInfo->date);
			$contents[] = array('text' => TEXT_INFO_SIZE . BLANK . $buInfo->size);
			$contents[] = array('text' => HTML_BR . TEXT_INFO_COMPRESSION . BLANK . $buInfo->compression);
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
