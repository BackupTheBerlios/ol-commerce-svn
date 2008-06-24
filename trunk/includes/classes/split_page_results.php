<?php
/* -----------------------------------------------------------------------------------------
$Id: split_page_results.php,v 1.1.1.1.2.1 2007/04/08 07:17:48 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(split_page_results.php,v 1.14 2003/05/27); www.oscommerce.com
(c) 2003	    nextcommerce (split_page_results.php,v 1.6 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

class splitPageResults
{
	var $sql_query, $number_of_rows, $current_page_number, $number_of_pages, $number_of_rows_per_page;
	//W. Kaiser - AJAX
	// class constructor
	function splitPageResults(&$query, $page, $max_rows, $count_key = '*') {
		if (empty($page) || (!is_numeric($page)))
		{
			$page = 1;
		}
		$this->current_page_number = $page;
		$this->number_of_rows_per_page = $max_rows;
		if (is_numeric($query))
		{
			$this->number_of_rows = $query;
			$this->sql_query = EMPTY_STRING;
		}
		else
		{
			$this->sql_query = strtolower($query);

			$pos_to = strlen($this->sql_query);
			$pos_from = strpos($this->sql_query, 'from', 0);
			$pos_group_by = strpos($this->sql_query, 'group by', $pos_from);
			if (($pos_group_by < $pos_to) && ($pos_group_by != false)) $pos_to = $pos_group_by;

			$pos_having = strpos($this->sql_query, 'having', $pos_from);
			if (($pos_having < $pos_to) && ($pos_having != false)) $pos_to = $pos_having;

			$pos_order_by = strpos($this->sql_query, 'order by', $pos_from);
			if (($pos_order_by < $pos_to) && ($pos_order_by != false)) $pos_to = $pos_order_by;

			if (strpos($this->sql_query, 'distinct') || strpos($this->sql_query, 'group by')) {
				//$count_string = 'distinct ' . olc_db_input($count_key);
				$count_string = 'distinct ' . $count_key;
				//$count_string = olc_db_input($count_key);
			} else {
				//$count_string = olc_db_input($count_key);
				$count_string = $count_key;
			}
			$count_sql="select count(" . $count_string . ") as total " .
				substr($this->sql_query, $pos_from, ($pos_to - $pos_from));
			$limit_text='limit ';
			$pos_from = strpos($this->sql_query, $limit_text, $pos_from);
			if ($pos_from !==false)
			{
				$limit=substr($this->sql_query,$pos_from);
				if (strpos($count_sql,$limit_text)===false)
				{
					$count_sql.=BLANK.$limit;
				}
				$limit=substr($limit,strlen($limit_text));
				$limit=explode(COMMA,$limit);
				if (sizeof($limit)==1)
				{
					$limit=$limit[0];
				}
				else
				{
					$limit=$limit[1]-$limit[0]+1;
				}
			}
			$count_query = olc_db_query($count_sql);
			$count = olc_db_fetch_array($count_query);
			$this->number_of_rows = $count['total'];
			if ($limit)
			{
				$this->number_of_rows=min($this->number_of_rows,$limit);
			}
		}
		$this->number_of_pages = ceil($this->number_of_rows / $this->number_of_rows_per_page);

		if ($this->current_page_number > $this->number_of_pages)
		{
			$this->current_page_number = $this->number_of_pages;
		}

		$offset = ($this->number_of_rows_per_page * ($this->current_page_number - 1));

		if (!is_numeric($query))
		{
			$pos_from = strpos($this->sql_query, $limit_text, $pos_from);
			if ($pos_from !==false)
			{
				$this->sql_query=substr($this->sql_query,0,$pos_from-1);
			}
			$this->sql_query .= BLANK.$limit_text;
		}
		if($offset<0) $offset=0;
		$this->sql_query .= $offset . COMMA_BLANK . $this->number_of_rows_per_page;
	}
	//W. Kaiser - AJAX

	// class functions

	// display split-page-number-links
	function display_links($max_page_links, $parameters = EMPTY_STRING)
	{
		global $PHP_SELF, $request_type;

		define('PAGE_LINK', HTML_A_START .
			olc_href_link(CURRENT_SCRIPT, $parameters . 'page=#p', $request_type) .
			'" class = "pageResults" title="#t">#d</a>&nbsp;&nbsp;');
		$max_pages = $this->number_of_pages;
		$display_links_string = EMPTY_STRING;
		if (olc_not_null($parameters) && (substr($parameters, -1) != AMP)) $parameters .= AMP;

		// previous button - not displayed on first page
		if ($this->current_page_number > 1)
		{
			$display_links_string .= setlink($this->current_page_number - 1, PREVNEXT_TITLE_PREVIOUS_PAGE, PREVNEXT_BUTTON_PREV);
		}
		// check if number_of_pages > $max_page_links
		$cur_window_num = intval($this->current_page_number / $max_page_links);
		if ($this->current_page_number % $max_page_links) $cur_window_num++;

		$max_window_num = intval($max_pages / $max_page_links);
		if ($max_pages % $max_page_links) $max_window_num++;

		// previous window of pages
		if ($cur_window_num > 1)
		{
			// first page button
			$display_links_string .= setlink($max_pages, PREVNEXT_TITLE_FIRST_PAGE, 1);
			$display_links_string .= setlink(($cur_window_num - 1) * $max_page_links,
			sprintf(PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE, $max_page_links), '...');
		}
		// page nn button
		for ($jump_to_page = 1 + (($cur_window_num - 1) * $max_page_links);
			($jump_to_page <= ($cur_window_num * $max_page_links)) && ($jump_to_page <= $max_pages); $jump_to_page++) {
			if ($jump_to_page == $this->current_page_number) {
				$display_links_string .= '&nbsp;<b>' . $jump_to_page . '</b>&nbsp;';
			} else {
				$display_links_string .= setlink($jump_to_page, sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page), $jump_to_page);
			}
		}

		// next window of pages
		if ($cur_window_num < $max_window_num)
		{
			$display_links_string .= setlink($cur_window_num * $max_page_links + 1,
			sprintf(PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE, $max_page_links), '...');
			// last page button
			$display_links_string .= setlink($max_pages, PREVNEXT_TITLE_LAST_PAGE, $max_pages);
		}

		// next button
		if ($max_pages > 1)
		{
			if (($this->current_page_number < $max_pages))
			{
				$display_links_string .= setlink($this->current_page_number + 1, PREVNEXT_TITLE_NEXT_PAGE, PREVNEXT_BUTTON_NEXT);
			}
		}
		return $display_links_string;
	}

	// display number of total products found
	function display_count($text_output)
	{
		$number_of_rows = $this->number_of_rows;
		$to_num = ($this->number_of_rows_per_page * $this->current_page_number);
		if ($to_num > $number_of_rows) $to_num = $number_of_rows;

		$from_num = ($this->number_of_rows_per_page * ($this->current_page_number - 1));

		if ($to_num == 0)
		{
			$from_num = 0;
		}
		else
		{
			$from_num++;
		}
		return sprintf($text_output, $from_num, $to_num, $number_of_rows);
	}

}

function setlink($page, $title, $text)
{
	$link = str_replace('#p', $page, PAGE_LINK);
	$link = str_replace('#t', $title, $link);
	if (substr($text, 0, 4) <> '<img')
	{
		$text = '<u>' . $text . '</u>';
	}
	return str_replace('#d', $text, $link);
}
?>