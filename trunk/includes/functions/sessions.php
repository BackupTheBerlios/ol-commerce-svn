<?php
/* --------------------------------------------------------------
$Id: sessions.php,v 1.1.1.1.2.1 2007/04/08 07:17:58 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(sessions.php,v 1.16 2003/04/02); www.oscommerce.com
(c) 2003	    nextcommerce (sessions.php,v 1.7 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

if (STORE_SESSIONS == 'mysql')
{
	if (!$SESS_LIFE = get_cfg_var('session.gc_maxlifetime'))
	{
		//$SESS_LIFE = 1440;
		$SESS_LIFE = 7200;			//2 hours session life
	}

	function _sess_open($save_path, $session_name) {
		return true;
	}

	function _sess_close() {
		return true;
	}

	function _sess_read($key,$check_expiry=true)
	{
		$qid = SELECT."value".SQL_FROM . TABLE_SESSIONS .SQL_WHERE." sesskey = '" . $key .APOS;
		if (!IS_LOCAL_HOST)
		{
			if ($check_expiry)
			{
				$qid .=" and expiry > '" . time() . APOS;
			}
		}
		$qid = olc_db_query($qid);
		$value = olc_db_fetch_array($qid);
		return $value['value'];
	}

	function _sess_write($key, $val)
	{
		global $SESS_LIFE;

		$expiry = time() + $SESS_LIFE;
		$value = addslashes($val);
		$qid = olc_db_query(SELECT_COUNT."as total from " . TABLE_SESSIONS . SQL_WHERE."sesskey = '" . $key . APOS);
		$total = olc_db_fetch_array($qid);
		if ($total['total'] > 0)
		{
			return olc_db_query(SQL_UPDATE . TABLE_SESSIONS . " set expiry = '" . $expiry . "', value = '" . $value . APOS.
			SQL_WHERE."sesskey = '" . $key . APOS);
		} else {
			return olc_db_query(INSERT_INTO . TABLE_SESSIONS . " values ('" . $key . "', '" .
			$expiry . "', '" . $value . "')");
		}
	}

	function _sess_destroy($key) {
		return olc_db_query(DELETE_FROM . TABLE_SESSIONS . SQL_WHERE. "sesskey = '" . $key . APOS);
	}

	function _sess_gc($maxlifetime)
	{
		olc_db_query(DELETE_FROM . TABLE_SESSIONS .SQL_WHERE."expiry < '" . time() . APOS);

		return true;
	}

	session_set_save_handler('_sess_open', '_sess_close', '_sess_read', '_sess_write', '_sess_destroy', '_sess_gc');
}

function olc_session_start() {
	return session_start();
}

function olc_session_register($variable) {
	global $session_started;

	if ($session_started == true) {
		return session_register($variable);
	}
}

function olc_session_is_registered($variable) {
	return session_is_registered($variable);
}

function olc_session_unregister($variable) {
	return session_unregister($variable);
}

function olc_session_id($sessid = EMPTY_STRING) {
	if (!empty($sessid)) {
		return session_id($sessid);
	} else {
		return session_id();
	}
}

function olc_session_name($name = EMPTY_STRING) {
	if (!empty($name)) {
		return session_name($name);
	} else {
		return session_name();
	}
}

function olc_session_close() {
	if (function_exists('session_close')) {
		return session_close();
	}
}

function olc_session_destroy() {
	return session_destroy();
}

function olc_session_save_path($path = EMPTY_STRING) {
	if (empty($path))
	{
		return session_save_path();
	} else {
		return session_save_path($path);
	}
}

function olc_session_recreate()
{
	if (PHP_VERSION >= 4.3)
	{
		$session_backup = $_SESSION;

		unset($_COOKIE[olc_session_name()]);

		olc_session_destroy();

		if (STORE_SESSIONS == 'mysql')
		{
			session_set_save_handler('_sess_open', '_sess_close', '_sess_read', '_sess_write', '_sess_destroy', '_sess_gc');
		}

		olc_session_start();

		$_SESSION = $session_backup;
		unset($session_backup);
	}
}
?>