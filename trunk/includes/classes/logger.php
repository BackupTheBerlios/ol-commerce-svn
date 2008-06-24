<?php
/* --------------------------------------------------------------
$Id: logger.php,v 1.1.1.1.2.1 2007/04/08 07:17:47 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(logger.php,v 1.2 2002/05/03); www.oscommerce.com
(c) 2003	    nextcommerce (logger.php,v 1.5 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

class logger {
	var $timer_start, $timer_stop, $timer_total;

	// class constructor
	function logger() {
		$this->timer_start();
	}

	function timer_start() {
		if (defined("PAGE_PARSE_START_TIME")) {
			$this->timer_start = PAGE_PARSE_START_TIME;
		} else {
			$this->timer_start = microtime();
		}
	}

	function timer_stop($display = FALSE_STRING_S) {
		$this->timer_stop = microtime();

		$time_start = explode(BLANK, $this->timer_start);
		$time_end = explode(BLANK, $this->timer_stop);

		$this->timer_total = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);

		$this->write($_SERVER['REQUEST_URI'], $this->timer_total . 's');

		if ($display == TRUE_STRING_S) {
			return $this->timer_display();
		}
	}

	function timer_display() {
		return '<span class="smallText">Bearbeitungszeit: ' . $this->timer_total . ' Sekunden</span>';
	}

	function write($message, $type) {
		error_log(strftime(STORE_PARSE_DATE_TIME_FORMAT) . ' [' . $type . '] ' . $message . NEW_LINE, 3, STORE_PAGE_PARSE_TIME_LOG);
	}
}
?>