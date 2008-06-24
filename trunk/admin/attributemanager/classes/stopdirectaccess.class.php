<?php
/*
$Id: stopdirectaccess.class.php,v 1.1.1.1 2006/12/22 13:37:20 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Released under the GNU General Public License

Web Development
http://www.kangaroopartners.com
*/

/**
 * Try and stop direct access to the script
 * As far as i know there is no way for a remote user to set a session var.
 * If there is i will have to rethink this
 */

class stopdirectaccess {

	/**
	 * Sets the global session variable
	 * @static authorise
	 * @access public
	 * @version 1
	 * @author Sam West aka Nimmit
	 * @contact osc@kangaroopartners.com
	 * @param $sessionVar string session variable name
	 * @return void
	 */
	function authorise($sessionVar) {
		if(!olc_session_is_registered($sessionVar))
		{
			olc_session_register($sessionVar);
		}
		$_SESSION[$sessionVar] = stopdirectaccess::makeSessionId();
	}

	/**
	 * Deletes the session var
	 */
	function deAuthorise($sessionVar) {
		if(isset($_SESSION[$sessionVar])) {
			unset($_SESSION[$sessionVar]);
		}
	}

	/**
	 * checks that the session varialbe is set and correct
	 * @return void
	 */
	function checkAuthorisation($sessionVar) {
		if(isset($_SESSION[$sessionVar]))
		{
			$session_id=stopdirectaccess::makeSessionId();
			$error =$_SESSION[$sessionVar] != $session_id;
		}
		else
		{
			$error = true;
		}
		if($error) exit("You cant access this page directly");
	}

	function makeSessionId() {
		return base64_encode(sha1(sha1(md5($_SERVER['SERVER_ADDR']).sha1(md5(AM_VALID_INCLUDE_PASSWORD)))));
	}
}
?>
