<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_start_session.inc.php,v 1.1.1.2 2006/12/23 09:14:14 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com
(c) 2003	    nextcommerce (olc_banner_exists.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// define how the session functions will be used
// Disable use_trans_sid as olc_href_link() does this manually
// set the session cookie parameters
if (function_exists('session_set_cookie_params'))
{
	session_set_cookie_params(0, SLASH, $current_domain_1);
}
if (function_exists('ini_set'))
{
	$session_cookie='session.cookie_';
	ini_set($session_cookie.'lifetime', '0');
	ini_set($session_cookie.'path', SLASH);
	ini_set($session_cookie.'domain', $current_domain_1);

	ini_set('session.use_trans_sid', 0);
	ini_set('session.bug_compat_42',0);
	ini_set('session.bug_compat_warn',0);
}
$s='ADMIN_PATH_PREFIX';
if (defined($s))
{
	$s=constant($s);
}
else
{
	$s=$level;
}
require_once($s.DIR_WS_FUNCTIONS . 'sessions.php');
// set the session name and save path
$session_name='OLCsid';
session_name($session_name);
// set the session id if it exists
$session_id=$_GET[$session_name];
if (!$session_id)
{
	$session_id=$_POST[$session_name];

}
if ($session_id)
{
	session_id($session_id);
}

$session_started = true;
/*
if (SESSION_FORCE_COOKIE_USE == TRUE_STRING_S)
{
	olc_setcookie('cookie_test', 'please_accept_for_session', time()+($one_day*30), SLASH, $current_domain);
	if (isset($HTTP_COOKIE_VARS['cookie_test']))
	{
		$session_started=true;
	}
	elseif ($is_spider_visit)
	{
		$session_started=SESSION_BLOCK_SPIDERS==FALSE_STRING_L;
	}
*/
if ($session_started)
{
	// start the session
	session_start();
	$_SESSION[DEBUG_OUPUT]=EMPTY_STRING;
}
?>