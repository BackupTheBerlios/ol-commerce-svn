<?php
/* --------------------------------------------------------------
$Id: table_block.php,v 1.1.1.1.2.1 2007/04/08 07:16:42 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(table_block.php,v 1.5 2003/06/02); www.oscommerce.com
(c) 2003	    nextcommerce (table_block.php,v 1.8 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

class tableBlock {
	var $table_border = '0';
	var $table_width = '100%';
	var $table_cellspacing = '0';
	var $table_cellpadding = '2';
	var $table_parameters = '';
	var $table_row_parameters = '';
	var $table_data_parameters = '';

	function tableBlock($contents) {
		$tableBox_string = '';

		$form_set = false;
		if (isset($contents['form'])) {
			$tableBox_string .= $contents['form'] . NEW_LINE;
			$form_set = true;
			olc_array_shift($contents);
		}

		$tableBox_string .= '<table border="' . $this->table_border . '" width="' .
		$this->table_width . '" cellspacing="' . $this->table_cellspacing . '" cellpadding="' . $this->table_cellpadding . '"';
		if ($this->table_parameters != '') $tableBox_string .= BLANK . $this->table_parameters;
		$tableBox_string .= '>' . NEW_LINE;
		for ($i = 0, $n = sizeof($contents); $i < $n; $i++) {
			$tableBox_string .= '  <tr';
			if ($this->table_row_parameters != '') $tableBox_string .= BLANK . $this->table_row_parameters;
			$current_contents=$contents[$i]['params'];
			if (isset($current_contents)) $tableBox_string .= BLANK . $current_contents;
			$tableBox_string .= '>' . NEW_LINE;
			$current_contents=$contents[$i][0];
			if (!isset($current_contents)) $current_contents = EMPTY_STRING;
			if (is_array($current_contents)) {
				for ($x = 0, $y = sizeof($contents[$i]); $x < $y; $x++)
				{
					$current_contents=$contents[$i][$x];
					if ($current_contents['text']) {
						$tableBox_string .= '    <td ';
						if ($current_contents['align'] != '') $tableBox_string .= ' align="' . $current_contents['align'] . '"';
						if ($current_contents['params']) {
							$tableBox_string .= BLANK . $current_contents['params'];
						} elseif ($this->table_data_parameters != '') {
							$tableBox_string .= BLANK . $this->table_data_parameters;
						}
						$tableBox_string .= '>';
						if ($current_contents['form']) $tableBox_string .= $current_contents['form'];
						$tableBox_string .= $current_contents['text'];
						if ($current_contents['form']) $tableBox_string .= '</form>';
						$tableBox_string .= '</td>' . NEW_LINE;
					}
				}
			} else {
				$tableBox_string .= '    <td ';
				$current_contents=$contents[$i]['align'];
				if (!isset($current_contents)) $current_contents = EMPTY_STRING;
				if ($current_contents != EMPTY_STRING) $tableBox_string .= ' align="' . $current_contents . '"';
				$current_contents=$contents[$i]['params'];
				if (isset($current_contents)) {
					$tableBox_string .= BLANK . $current_contents;
				} elseif ($this->table_data_parameters != EMPTY_STRING) {
					$tableBox_string .= BLANK . $this->table_data_parameters;
				}
				$tableBox_string .= '>' . $contents[$i]['text'] . '</td>' . NEW_LINE;
			}

			$tableBox_string .= '  </tr>' . NEW_LINE;
		}

		$tableBox_string .= '</table>' . NEW_LINE;

		if ($form_set) $tableBox_string .= '</form>' . NEW_LINE;

		return $tableBox_string;
	}
}
?>