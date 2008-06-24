<?php
/* --------------------------------------------------------------
$Id: box.php,v 1.1.1.1.2.1 2007/04/08 07:16:39 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(box.php,v 1.5 2002/03/16); www.oscommerce.com
(c) 2003	    nextcommerce (box.php,v 1.5 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License

Example usage:

$heading = array();
$heading[] = array('params' => 'class="menuBoxHeading"',
'text'  => BOX_HEADING_TOOLS,
'link'  => olc_href_link(CURRENT_SCRIPT, olc_get_all_get_params(array('selected_box')) . 'selected_box=tools'));

$contents = array();
$contents[] = array('text'  => SOME_TEXT);

$box = new box;
echo $box->infoBox($heading, $contents);
--------------------------------------------------------------
*/

class box extends tableBlock {
	function box() {
		$this->heading = array();
		$this->contents = array();
	}

	function infoBox($heading, $contents) {
		$this->table_row_parameters = 'class="infoBoxHeading"';
		$this->table_data_parameters = 'class="infoBoxHeading"';
		$this->heading = $this->tableBlock($heading);

		$this->table_row_parameters = '';
		$this->table_data_parameters = 'class="infoBoxContent"';
		$this->contents = $this->tableBlock($contents);

		return $this->heading . $this->contents;
	}

	function menuBox($heading, $contents) {
		$this->table_data_parameters = 'class="menuBoxHeading"';
		$heading_link=$heading[0]['link'];
		$heading_text=$heading[0]['text'];
		if ($heading_link) {
			$heading_text = HTML_A_START . olc_href_link($heading_link) . '" class="menuBoxHeadingLink">' . $heading_text . HTML_A_END;
		}
		$heading[0]['text'] = HTML_NBSP . $heading_text . HTML_NBSP;
		$this->heading = $this->tableBlock($heading);

		$this->table_data_parameters = 'class="menuBoxContent"';
		$this->contents = $this->tableBlock($contents);

		return $this->heading . $this->contents;
	}
}
?>