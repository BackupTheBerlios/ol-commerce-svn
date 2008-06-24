<?php
/* --------------------------------------------------------------
$Id: split_page_results.php,v 1.1.1.1.2.1 2007/04/08 07:16:42 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(split_page_results.php,v 1.13 2003/05/05); www.oscommerce.com
(c) 2003	    nextcommerce (split_page_results.php,v 1.6 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

class splitPageResults {
	function splitPageResults(&$current_page_number, $max_rows_per_page, &$sql_query, &$query_num_rows) {
		if (empty($current_page_number)) $current_page_number = 1;

		$pos_to = strlen($sql_query);
		$pos_from = strpos($sql_query, ' from', 0);

		$pos_group_by = strpos($sql_query, ' group by', $pos_from);
		if (($pos_group_by < $pos_to) && ($pos_group_by != false)) $pos_to = $pos_group_by;

		$pos_having = strpos($sql_query, ' having', $pos_from);
		if (($pos_having < $pos_to) && ($pos_having != false)) $pos_to = $pos_having;

		$pos_order_by = strpos($sql_query, ' order by', $pos_from);
		if (($pos_order_by < $pos_to) && ($pos_order_by != false)) $pos_to = $pos_order_by;

		$reviews_count_query = olc_db_query("select count(*) as total " . substr($sql_query, $pos_from, ($pos_to - $pos_from)));
		$reviews_count = olc_db_fetch_array($reviews_count_query);
		$query_num_rows = $reviews_count['total'];

		$num_pages = ceil($query_num_rows / $max_rows_per_page);
		if ($current_page_number > $num_pages) {
			$current_page_number = $num_pages;
		}
		$offset = ($max_rows_per_page * ($current_page_number - 1));
		if ($offset < 0)
		{
			$offset = 0 ;
		}
		$sql_query .= " limit " . $offset . ", " . $max_rows_per_page;

	}

	function display_links($query_numrows, $max_rows_per_page, $max_page_links, $current_page_number, $parameters = '', $page_name = 'page') {

		if ( olc_not_null($parameters) && (substr($parameters, -1) != '&') ) $parameters .= '&';

		// calculate number of pages needing links
		$num_pages = ceil($query_numrows / $max_rows_per_page);

		$pages_array = array();
		for ($i=1; $i<=$num_pages; $i++) {
			$pages_array[] = array('id' => $i, 'text' => $i);
		}

		if ($num_pages > 1) {
			$display_links = olc_draw_form('pages', CURRENT_SCRIPT, '', 'get');

			if ($current_page_number > 1) {
				$display_links .= HTML_A_START . olc_href_link(CURRENT_SCRIPT, $parameters . $page_name . '=' . ($current_page_number - 1), NONSSL) . '" class="splitPageLink">' . PREVNEXT_BUTTON_PREV . '</a>&nbsp;&nbsp;';
			} else {
				$display_links .= PREVNEXT_BUTTON_PREV . '&nbsp;&nbsp;';
			}

			$display_links .= sprintf(TEXT_RESULT_PAGE, olc_draw_pull_down_menu($page_name, $pages_array, $current_page_number, 'onchange="this.form.submit();"'), $num_pages);

			if (($current_page_number < $num_pages) && ($num_pages != 1)) {
				$display_links .= '&nbsp;&nbsp;<a href="' . olc_href_link(CURRENT_SCRIPT, $parameters . $page_name . '=' . ($current_page_number + 1), NONSSL) . '" class="splitPageLink">' . PREVNEXT_BUTTON_NEXT . HTML_A_END;
			} else {
				$display_links .= '&nbsp;&nbsp;' . PREVNEXT_BUTTON_NEXT;
			}

			if ($parameters != '') {
				if (substr($parameters, -1) == '&') $parameters = substr($parameters, 0, -1);
				$pairs = explode('&', $parameters);
				while (list(, $pair) = each($pairs)) {
					list($key,$value) = explode('=', $pair);
					$display_links .= olc_draw_hidden_field(rawurldecode($key), rawurldecode($value));
				}
			}

			if (SID) $display_links .= olc_draw_hidden_field(session_name(), session_id());

			$display_links .= '</form>';
		} else {
			$display_links = sprintf(TEXT_RESULT_PAGE, $num_pages, $num_pages);
		}

		return $display_links;
	}

	function display_count($query_numrows, $max_rows_per_page, $current_page_number, $text_output) {
		$to_num = ($max_rows_per_page * $current_page_number);
		if ($to_num > $query_numrows) $to_num = $query_numrows;
		$from_num = ($max_rows_per_page * ($current_page_number - 1));
		if ($to_num == 0) {
			$from_num = 0;
		} else {
			$from_num++;
		}

		return sprintf($text_output, $from_num, $to_num, $query_numrows);
	}
}
?>