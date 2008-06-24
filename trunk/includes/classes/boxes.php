<?php
/* -----------------------------------------------------------------------------------------
$Id: boxes.php,v 1.1.1.1.2.1 2007/04/08 07:17:46 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(boxes.php,v 1.32 2003/05/27); www.oscommerce.com
(c) 2003	    nextcommerce (boxes.php,v 1.11 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

class tableBox {
	var $table_border = '0';
	var $table_width = '100%';
	var $table_cellspacing = '0';
	var $table_cellpadding = '2';
	var $table_parameters = '';
	var $table_row_parameters = '';
	var $table_data_parameters = '';

	// class constructor
	function tableBox($contents, $direct_output = false) {
		if (IS_AJAX_PROCESSING)
		{
			for ($i=0, $n=sizeof($contents); $i<$n; $i++)
			{
				$content=$contents[$i];
				if (is_array($content[0]))
				{
					for ($x=0, $n2=sizeof($content); $x<$n2; $x++)
					{
						$text=$content[$x]['text'];
						if ($text)
						{
							if ($tableBox_string!=EMPTY_STRING)
							{
								$tableBox_string .= $text . "\n\n";
							}
							if ($text)
							{
								$tableBox_string .= $text;
							}
						}
					}
				} else {
					$text=$content['text'];
					if ($text)
					{
						$tableBox_string .= $text;
					}
				}
			}
		}
		else
		{
			$tableBox_string = '<table border="' . $this->table_border . '" width="' .
			$this->table_width . '" cellspacing="' . $this->table_cellspacing . '" cellpadding="' .
			$this->table_cellpadding . '"';
			if (olc_not_null($this->table_parameters)) $tableBox_string .= BLANK . $this->table_parameters;
			$tableBox_string .= '>' . NEW_LINE;
			for ($i=0, $n=sizeof($contents); $i<$n; $i++)
			{
				$content=$contents[$i];
				$content_is_array=is_array($content[0]);
				if ($content_is_array)
				{
					$content_form=$content['form'];
					$is_form=olc_not_null($content_form);
					if ($is_form)
					{
						$tableBox_string .= $content_form . NEW_LINE;
					}
				}
				$tableBox_string .= '  <tr';
				if (olc_not_null($this->table_row_parameters)) $tableBox_string .= BLANK . $this->table_row_parameters;
				$tableBox_string .= '>' . NEW_LINE;
				if ($content_is_array)
				{
					for ($x=0, $n2=sizeof($content); $x<$n2; $x++)
					{
						$content_x=$content[$x];
						if (isset($content_x['text']) && olc_not_null($content_x['text'])) {
							$tableBox_string .= '    <td';
							if (isset($content_x['align']) && olc_not_null($content_x['align']))
							$tableBox_string .= ' align="' . $content_x['align'] . '"';
							if (isset($content_x['params']) && olc_not_null($content_x['params'])) {
								$tableBox_string .= BLANK . $content_x['params'];
							} elseif (olc_not_null($this->table_data_parameters)) {
								$tableBox_string .= BLANK . $this->table_data_parameters;
							}
							$tableBox_string .= '>';
							if (isset($content_x['form']) && olc_not_null($content_x['form']))
							$tableBox_string .= $content_x['form'];
							$tableBox_string .= $content_x['text'];
							if (isset($content_x['form']) && olc_not_null($content_x['form']))
							$tableBox_string .= '</form>';
							$tableBox_string .= '</td>' . NEW_LINE;
						}
					}
				}
				else
				{
					$tableBox_string .= '    <td';
					/*
					if (isset($content['align']) && olc_not_null($content['align']))
					$tableBox_string .= ' align="' . $content['align'] . '"';
					if (isset($content['params']) && olc_not_null($content['params'])) {
						$tableBox_string .= BLANK . $content['params'];
					} elseif (olc_not_null($this->table_data_parameters)) {
						$tableBox_string .= BLANK . $this->table_data_parameters;
					}
					$tableBox_string .= '>' . $content['text'] . '</td>' . NEW_LINE;
					*/
					$tableBox_string .= '>' . $content . '</td>' . NEW_LINE;
				}
				$tableBox_string .= '  </tr>' . NEW_LINE;
				if ($is_form)
				{
					$tableBox_string .= '</form>' . NEW_LINE;
				}
			}

			$tableBox_string .= '</table>' . NEW_LINE;

			if ($direct_output == true) echo $tableBox_string;
		}
		return $tableBox_string;
	}
}

class infoBox extends tableBox {
	function infoBox($contents) {
		$info_box_contents = array();
		$info_box_contents[] = array('text' => $this->infoBoxContents($contents));
		$this->table_cellpadding = '1';
		$this->table_parameters = 'class="infoBox"';
		$this->tableBox($info_box_contents, true);
	}

	function infoBoxContents($contents) {
		$this->table_cellpadding = '3';
		$this->table_parameters = 'class="infoBoxContents"';
		$info_box_contents = array();
		$info_box_contents[] = array(array('text' => olc_draw_separator('pixel_trans.gif', '100%', '1')));
		for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
			$info_box_contents[] = array(array('align' => $content['align'],
			'form' => $content['form'],
			'params' => 'class="boxText"',
			'text' => $content['text']));
		}
		$info_box_contents[] = array(array('text' => olc_draw_separator('pixel_trans.gif', '100%', '1')));
		return $this->tableBox($info_box_contents);
	}
}

class infoBoxHeading extends tableBox {
	function infoBoxHeading($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
		$this->table_cellpadding = '0';

		if ($left_corner == true) {
			$left_corner = olc_image(DIR_WS_IMAGES . 'infobox/corner_left.gif');
		} else {
			$left_corner = olc_image(DIR_WS_IMAGES . 'infobox/corner_right_left.gif');
		}
		if ($right_arrow == true) {
			$right_arrow = HTML_A_START . $right_arrow . '">' . olc_image(DIR_WS_IMAGES . 'infobox/arrow_right.gif', ICON_ARROW_RIGHT) . HTML_A_END;
		} else {
			$right_arrow = '';
		}
		if ($right_corner == true) {
			$right_corner = $right_arrow . olc_image(DIR_WS_IMAGES . 'infobox/corner_right.gif');
		} else {
			$right_corner = $right_arrow . olc_draw_separator('pixel_trans.gif', '11', '14');
		}

		$info_box_contents = array();
		$info_box_contents[] = array(array('params' => 'height="14" class="infoBoxHeading"',
		'text' => $left_corner),
		array('params' => 'width="100%" height="14" class="infoBoxHeading"',
		'text' => $contents[0]['text']),
		array('params' => 'height="14" class="infoBoxHeading" nowrap="nowrap"',
		'text' => $right_corner));

		$this->tableBox($info_box_contents, true);
	}
}

class contentBox extends tableBox {
	function contentBox($contents) {
		$info_box_contents = array();
		$info_box_contents[] = array('text' => $this->contentBoxContents($contents));
		$this->table_cellpadding = '1';
		$this->table_parameters = 'class="infoBox"';
		$this->tableBox($info_box_contents, true);
	}

	function contentBoxContents($contents) {
		$this->table_cellpadding = '4';
		$this->table_parameters = 'class="infoBoxContents"';
		return $this->tableBox($contents);
	}
}

class contentBoxHeading extends tableBox {
	function contentBoxHeading($contents) {
		$this->table_width = '100%';
		$this->table_cellpadding = '0';

		$info_box_contents = array();
		$info_box_contents[] = array(array('params' => 'height="14" class="infoBoxHeading"',
		'text' => olc_image(DIR_WS_IMAGES . 'infobox/corner_left.gif')),
		array('params' => 'height="14" class="infoBoxHeading" width="100%"',
		'text' => $contents[0]['text']),
		array('params' => 'height="14" class="infoBoxHeading"',
		'text' => olc_image(DIR_WS_IMAGES . 'infobox/corner_right_left.gif')));

		$this->tableBox($info_box_contents, true);
	}
}

class errorBox extends tableBox {
	function errorBox($contents) {
		$this->table_data_parameters = 'class="errorBox"';
		$this->tableBox($contents, true);
	}
}

class productListingBox extends tableBox {
	function productListingBox($contents) {
		$this->table_parameters = 'class="productListing"';
		$this->tableBox($contents, true);
	}
}
?>