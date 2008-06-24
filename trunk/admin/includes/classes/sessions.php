<?php
/* --------------------------------------------------------------
$Id: sessions.php,v 1.1.1.1.2.1 2007/04/08 07:16:41 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(sessions.php,v 1.10 2002/11/22); www.oscommerce.com
(c) 2003	    nextcommerce (sessions.php,v 1.5 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License

Original source from Web Application Development with PHP (Tobias Ratschiller, Till Gerken)
Copyright (c) 2000, New Riders Publishing
--------------------------------------------------------------*/

$SID = '';

class php3session {
	var $name = PHP_SESSION_NAME;
	var $auto_start = false;
	var $referer_check = false;

	var $save_path = PHP_SESSION_SAVE_PATH;
	var $save_handler = 'php3session_files';

	var $lifetime = 0;

	var $cache_limiter = 'nocache';
	var $cache_expire = 180;

	var $use_cookies = true;
	var $cookie_lifetime = 0;
	//var $cookie_path = substr(DIR_WS_ADMIN, 0, -1);
	var $cookie_domain = '';

	var $gc_probability = 1;
	var $gc_maxlifetime = 0;

	var $serialize_handler = 'php';
	var $id;

	var $nr_open_sessions = 0;
	var $mod_name = '';
	var $delimiter = NEW_LINE;
	var $delimiter_value = '[==]';

	function php3session() {
		$this->mod_name = $this->save_handler;
	}
}

class php3session_user {
	var $open_func, $close_func, $read_func, $write_func, $destroy_func, $gc_func;

	function open($save_path, $sess_name) {
		$func = $this->open_func;
		if (function_exists($func)) {
			return $func($save_path, $sess_name);
		}

		return true;
	}

	function close($save_path, $sess_name) {
		$func = $this->close_func;
		if (function_exists($func)) {
			return $func();
		}

		return true;
	}

	function read($sess_id) {
		$func = $this->read_func;

		return $func($sess_id);
	}

	function write($sess_id, $val) {
		$func = $this->write_func;

		return $func($sess_id, $val);
	}

	function destroy($sess_id) {
		$func = $this->destroy_func;
		if (function_exists($func)) {
			return $func($sess_id);
		}

		return true;
	}

	function gc($max_lifetime) {
		$func = $this->gc_func;
		if (function_exists($func)) {
			return $func($max_lifetime);
		}

		return true;
	}
}

class php3session_files {
	function open($save_path, $sess_name) {
		return true;
	}

	function close() {
		return true;
	}

	function read($sess_id) {
		global $session;

		// Open, read in, close file with session data
		$file = $session->save_path . '/sess_' . $sess_id;
		if (!file_exists($file)) {
			// Create it
			touch($file);
		}
		$fp = fopen($file, 'r') or die('Could not open session file (' . $file . ').');
		$val = fread($fp, filesize($file));
		fclose($fp);

		return $val;
	}

	function write($sess_id, $val) {
		global $session;

		// Open, write to, close file with session data
		$file = $session->save_path . '/sess_' . $sess_id;
		$fp = fopen($file, 'w') or die('Could not write session file (' . $file . RPAREN);
		$val = fputs($fp, $val);
		fclose($fp);

		return true;
	}

	function destroy($sess_id) {
		global $session;

		$file = $session->save_path . '/sess_' . $sess_id;
		unlink($file);

		return true;
	}

	function gc($max_lifetime) {
		// We return true, since all cleanup should be handled by
		// an external entity (i.e. find -ctime x | xargs rm)
		return true;
	}
}

function _session_create_id() {
	return md5(uniqid(microtime()));
}

function _session_cache_limiter() {
	global $session;

	$session_cache_limiter=$session->cache_limiter;
	$session_cache_expire=$session->cache_expire * 60;
	$cache_control=sprintf($session_cache_limiter.', max-age=%s', $session_cache_expire);
	$date_now='Thu, 19 Nov 1981 08:52:00';
	switch ($session_cache_limiter) {
		case 'nocache':
		$cache_control='no-cache';
		header('Pragma: '.$cache_control);
		break;

		case 'private':
		break;

		case 'public':
		$date_now = gmdate('D, d M Y H:i:s', time()+$session_cache_expire);
		break;

		default:
		die('Caching method ' . session_cache_limiter . ' not implemented.');
	}
	header('Cache-Control: '.$cache_control);
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime(basename($GLOBALS['PHP_SELF']))) . ' GMT');
	header('Expires: ' . $date_now . ' GMT');
}

function _php_encode() {
	global $session;

	$ret = '';
	// Create a string containing the serialized variables
	for (reset($session->vars); list($i)=each($session->vars);) {
		$ret .= $session->vars[$i] . $session->delimiter_value . serialize($GLOBALS[$session->vars[$i]]) . $session->delimiter;
	}

	return $ret;
}

function _php_decode($data) {
	global $session;

	$data = trim($data);
	$vars = explode($session->delimiter, $data);

	// Add the variables to the global namespace
	for (reset($vars); list($i)=each($vars);) {
		$tmp = explode($session->delimiter_value, $vars[$i]);
		$name = trim($tmp[0]);
		$value = trim($tmp[1]);
		$GLOBALS[$name] = unserialize($value);
		$session->vars[] = trim($name);
	}
}

function _wddx_encode($data) {
	global $session;

	$ret = wddx_serialize_vars($session->vars);

	return $ret;
}

function _wddx_decode($data) {
	return wddx_deserialize($data);
}

function session_name($name = '') {
	global $session;

	if (empty($name)) {
		return $session->name;
	}

	$session->name = $name;
}

function session_set_save_handler($open, $close, $read, $write, $destroy, $gc) {
	global $session, $php3session_user;

	$php3session_user = new php3session_user;
	$php3session_user->open_func = $open;
	$php3session_user->close_func = $close;
	$php3session_user->read_func = $read;
	$php3session_user->write_func = $write;
	$php3session_user->destroy_func = $destroy;
	$php3session_user->gc_func = $gc;
	$session->mod_name = 'php3session_user';
}

function session_module_name($name = '') {
	global $session;

	if (empty($name)) {
		return $session->mod_name;
	}

	$session->mod_name = $name;
}

function session_save_path($path = '') {
	global $session;

	if(empty($path)) {
		return $session->save_path;
	}

	$session->save_path = $path;
}

function session_id($id = '') {
	global $session;

	if(empty($id)) {
		return $session->id;
	}

	$session->id = $id;
}

function session_register($var) {
	global $session;

	if ($session->nr_open_sessions == 0) {
		session_start();
	}

	$session->vars[] = trim($var);
}

function session_unregister($var) {
	global $session;

	for (reset($session->vars); list($i)=each($session->vars);) {
		if ($session->vars[$i] == trim($var)) {
			unset($session->vars[$i]);
			break;
		}
	}
}

function session_is_registered($var) {
	global $session;

	for (reset($session->vars); list($i)=each($session->vars);) {
		if ($session->vars[$i] == trim($var)) {
			return true;
		}
	}

	return false;
}

function session_encode() {
	global $session;

	$serializer = '_' . $session->serialize_handler . '_encode';
	$ret = $serializer();

	return $ret;
}

function session_decode($data) {
	global $session;

	$serializer = '_' . $session->serialize_handler . '_decode';
	$ret = $serializer($data);

	return $ret;
}

function session_start() {
	global $session, $SID, $HTTP_COOKIE_VARS, $HTTP_GET_VARS, $HTTP_POST_VARS;

	// Define the global variable $SID?
	$define_sid = true;

	// Send the session cookie?
	$send_cookie = true;

	// Is track_vars enabled?
	$track_vars = ( (isset($HTTP_COOKIE_VARS)) || (isset($HTTP_GET_VARS)) || (isset($HTTP_POST_VARS)) ) ? true : false;

	// Check if session_start() has been called once already
	if ($session->nr_open_sessions != 0) {
		return false;
	}

	// If our only resource is the global symbol_table, then check it.
	// If track_vars are enabled, we prefer these, because they are more
	// reliable, and we always know whether the user has accepted the
	// cookie.
	if ( (isset($GLOBALS[$session->name])) && (!empty($GLOBALS[$session->name])) && (!$track_vars) ) {
		$session->id = $GLOBALS[$session->name];
		$send_cookie = false;
	}

	// Now check the track_vars. Cookies are preferred, because initially
	// cookie and get variables will be available.
	if ( (empty($session->id)) && ($track_vars) ) {
		if (isset($HTTP_COOKIE_VARS[$session->name])) {
			$session->id = $HTTP_COOKIE_VARS[$session->name];
			$define_sid = false;
			$send_cookie = false;
		}

		if (isset($HTTP_GET_VARS[$session->name])) {
			$session->id = $HTTP_GET_VARS[$session->name];
		}

		if (isset($HTTP_POST_VARS[$session->name])) {
			$session->id = $HTTP_POST_VARS[$session->name];
		}
	}

	/*
	// Check the REQUEST_URI symbol for a string of the form
	// '<session-name>=<session-id>' to allow URLs of the form
	// http://yoursite/<session-name>=<session-id>/script.php
	if (empty($session->id)) {
	eregi($session->name . '=([^/]+)', $GLOBALS['REQUEST_URI'], $regs);
	$regs[1] = trim($regs[1]);
	if (!empty($regs[1])) {
	$session->id = $regs[1];
	}
	}
	*/

	// Check whether the current request was referred to by
	// an external site which invalidates the previously found id
	if ( (!empty($session->id)) && ($session->referer_check) ) {
		$url = parse_url($GLOBALS['HTTP_REFERER']);
		if (trim($url['host']) != $GLOBALS['SERVER_NAME']) {
			unset($session->id);
			$send_cookie = true;
			$define_sid = true;
		}
	}

	// Do we have an existing session id?
	if (empty($session->id)) {
		// Create new session id
		$session->id = _session_create_id();
	}

	// Is use_cookies set to false?
	if ( (!$session->use_cookies) && ($send_cookie) ) {
		$define_sid = true;
		$send_cookie = false;
	}

	// Should we send a cookie?
	if ($send_cookie) {
		setcookie($session->name, $session->id, $session->cookie_lifetime, $session->cookie_path, $session->cookie_domain);
	}

	// Should we define the SID?
	if($define_sid) {
		$SID = $session->name . '=' . $session->id;
	}

	$session->nr_open_sessions++;

	// Send caching headers
	// Start session
	$mod = $GLOBALS[$session->mod_name];
	if (!$mod->open($session->save_path, $session->name)) {
		die('Failed to initialize session module.');
	}

	// Read session data
	if ($val = $mod->read($session->id)) {
		// Decode session data
		session_decode($val);
	}

	// Send HTTP cache headers
	_session_cache_limiter();

	// Check if we should clean up (call the garbage collection routines)
	if ($session->gc_probability > 0) {
		$randmax = getrandmax();
		$nrand = (int)(100 * olc_rand() / $randmax);
		if ($nrand < $session->gc_probability) {
			$mod->gc($session->gc_maxlifetime);
		}
	}

	if ($define_sid) {
		define('SID', $SID);
	} else {
		define('SID', '');
	}

	return true;
}

function session_destroy() {
	global $session;

	if ($session->nr_open_sessions == 0) {
		return false;
	}

	// Destroy session
	$mod = $GLOBALS[$session->mod_name];
	if (!$mod->destroy($session->id)) {
		return false;
	}
	unset($session);
	$session = new php3session;

	return true;
}

function session_close() {
	global $session, $SID;

	if ($session->nr_open_sessions == 0) {
		return false;
	}
	// Encode session
	$val = session_encode();
	$len = strlen($val);

	// Save session
	$mod = $GLOBALS[$session->mod_name];
	if (!$mod->write($session->id, $val)) {
		die('Session could not be saved.');
	}
	// Close session
	if ( (function_exists($session->mod_name . '->close')) && (!$mod->close()) ) {
		die('Session could not be closed.');
	}
	$SID = '';
	$session->nr_open_sessions--;

	return true;
}

$session = new php3session;
$mod = $session->save_handler;
$$mod = new $mod;

if ($session->auto_start) {
	$ret = session_start() or die('Session could not be started.');
}

register_shutdown_function('session_close');
?>