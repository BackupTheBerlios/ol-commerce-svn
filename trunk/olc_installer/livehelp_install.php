<?php
/* --------------------------------------------------------------
$Id: livehelp_install.php,v 1.1.1.1.2.1 2007/04/08 07:18:31 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(install_3.php,v 1.6 2002/08/15); www.oscommerce.com
(c) 2004  		OL - Commerce; www.ol-Commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

define('ADMIN_PATH_PREFIX','../');
require('../includes/configure.php');

require('includes/application.php');

require_once(DIR_FS_INC . 'xtc_db_connect.inc.php');
require_once(DIR_FS_INC . 'xtc_db_query.inc.php');
require_once(DIR_FS_INC . 'xtc_db_fetch_array.inc.php');
require_once(DIR_FS_INC . 'xtc_db_install.inc.php');
require_once(DIR_FS_INC . 'xtc_db_install.inc.php');

if (!function_exists('str_split')) {
	function str_split($str, $nr){
		return split("-l-", chunk_split($str, $nr, '-l-'));
	}
}

function FilePermsDecode( $perms )
{
	if ($perms)
	{
		$oct = str_split( strrev( decoct( $perms ) ), 1 );
		$masks = array( '---', '--x', '-w-', 'rw-', 'r--', 'r-x', 'rw-', 'rwx' );
		return sprintf(
		'Dezimal: %d | Oktal: %o | Rechte: %s',
		$perms,
		$perms,
		sprintf('%s %s %s',
		array_key_exists( $oct[ 2 ], $masks ) ? $masks[ $oct[ 2 ] ] : '###',
		array_key_exists( $oct[ 1 ], $masks ) ? $masks[ $oct[ 1 ] ] : '###',
		array_key_exists( $oct[ 0 ], $masks ) ? $masks[ $oct[ 0 ] ] : '###'
		)
		)
		;
	}
}

if (!function_exists('file_put_contents')) {
	function file_put_contents($filename, $content, $flags = null, $resource_context = null)
	{
		// If $content is an array, convert it to a string
		if (is_array($content)) {
			$content = implode('', $content);
		}

		// If we don't have a string, throw an error
		if (!is_scalar($content)) {
			user_error('file_put_contents() The 2nd parameter should be either a string or an array',
			E_USER_WARNING);
			return false;
		}

		// Get the length of data to write
		$length = strlen($content);

		// Check what mode we are using
		$mode = ($flags & FILE_APPEND) ? 'a' :'wb';

		// Check if we're using the include path
		$use_inc_path = ($flags & FILE_USE_INCLUDE_PATH) ?true :false;
		$f=str_replace("../",DIR_FS_CATALOG,$filename);
		if (file_exists($f))
		{
			@chmod ($f, 0777);
			@unlink ($f);
		}
		// Open the file for writing
		if (($fh = @fopen($f, $mode, $use_inc_path)) === false)
		{
			user_error('file_put_contents() failed to open stream => Permission denied -- '.$f.
			'<br/>Permissions: '.FilePermsDecode(fileperms($f)) ,E_USER_WARNING);
			return false;
		}
		// Attempt to get an exclusive lock
		$use_lock = ($flags & LOCK_EX) ? true : false ;
		if ($use_lock === true) {
			if (!flock($fh, LOCK_EX)) {
				return false;
			}
		}
		// Write to the file
		$bytes = 0;
		if (($bytes = @fwrite($fh, $content)) === false) {
			$errormsg = sprintf('file_put_contents() Failed to write %d bytes to %s',
			$length,
			$f);
			user_error($errormsg, E_USER_WARNING);
			return false;
		}
		// Close the handle
		@fclose($fh);
		@chmod ($f, 0444);
		// Check all the data was written
		if ($bytes != $length)
		{
			$errormsg = sprintf('file_put_contents() Only %d of %d bytes written, possibly out of free disk space.',
			$bytes,
			$length);
			user_error($errormsg, E_USER_WARNING);
			return false;
		}
		// Return length
		return $bytes;
	}
}

// connect do database
xtc_db_connect() or die('Kann keine Verbindung zur Datenbank erhalten!');
$db_error = false;
$sql_file = DIR_FS_CATALOG . 'xtc_installer/livehelp.sql.php';
xtc_db_install(DB_DATABASE, $sql_file,EMPTY_STRING);
if ($db_error)
{
	$text='nicht ';
}
else
{
	$dir="../livehelp/";
	$link=HTML_BR.HTML_BR.HTML_A_START.$dir.'livehelp.php">Live Help starten</a>';
	$text=$dir."setup.php";
	if (file_exists($text))
	{
	  srand(microtime()*1000000);
	  $pos=strrpos($text,DOT);
		$file_neu=substr($text,0,$pos).UNDERSCORE.rand(1,1000000).substr($text,$pos);
		@unlink($file_neu);
		@rename ($text,$file_neu);
	}
	$file=$dir.'config.php';
	$config=file_get_contents($file);
	$config=str_replace('$installed=false','$installed=true',$config);
	file_put_contents($file,$config);
	$text='';
}

echo str_replace(HASH,$text,'<font color="red">Live Help wurde #erfolgreich installiert!</font>').$link;
?>