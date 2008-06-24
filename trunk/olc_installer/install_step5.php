<?php
/* --------------------------------------------------------------
$Id: install_step5.php,v 1.1.1.1.2.1 2007/04/08 07:18:30 gswkaiser Exp $
OL-Commerce Version 2.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de
Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)   (c) 2004  		OL  Commerce; www.ol-Commerce.com
Released under the GNU General Public License
--------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (install_step7.php,v 1.29 2003/08/20); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
Released under the GNU General Public License
--------------------------------------------------------------*/
//W. Kaiser - AJAX
function xtc_session_close()
{
}

if (!function_exists('str_split'))
{
	function str_split($str, $nr)
	{
		return split("-l-", chunk_split($str, $nr, '-l-'));
	}
}

function FilePermsDecode($f)
{
	if (file_exists($f))
	{
		$perms=@fileperms($f);
		if ($perms)
		{
			$oct = str_split(strrev(decoct($perms)), 1);
			$masks = array('---', '--x', '-w-', 'rw-', 'r--', 'r-x', 'rw-', 'rwx');
			return sprintf(
			'Dezimal: %d | Oktal: %o | Rechte: %s',
			$perms,
			$perms,
			sprintf('%s %s %s',
			array_key_exists($oct[ 2 ], $masks) ? $masks[ $oct[ 2 ] ] : '###',
			array_key_exists($oct[ 1 ], $masks) ? $masks[ $oct[ 1 ] ] : '###',
			array_key_exists($oct[ 0 ], $masks) ? $masks[ $oct[ 0 ] ] : '###'
			)
			)
			;
		}
	}
}

if (!function_exists('file_put_contents'))
{
	function file_put_contents($filename, $content, $flags = null, $resource_context = null)
	{
		// If $content is an array, convert it to a string
		if (is_array($content)) {
			$content = implode(EMPTY_STRING, $content);
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
			'<br/>Permissions: '.FilePermsDecode($f) ,E_USER_WARNING);
			return false;
		}
		// Attempt to get an exclusive lock
		$use_lock = ($flags & LOCK_EX) ? true : false ;
		if ($use_lock === true) {
			if (!flock($fh, LOCK_EX))
			{
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

function store_config($file_name, $file_contents)
{
	//	W. Kaiser - Allow write/privilege
	//$file_name = DIR_FS_CATALOG . $file_name;
	$file_name=str_replace('//',SLASH,$file_name);
	@chmod ($file_name , 0777);
//echo "store_config 1 -- ".$file_name.COMMA_BLANK.decoct(fileperms($file_name)).HTML_BR;
	$fp = fopen($file_name , 'w');
	fputs($fp, $file_contents);
	fclose($fp);
	//	W. Kaiser - Remove write/privilege
	@chmod ($file_name , 0444);
//echo "store_config 2 -- ".$file_name.COMMA_BLANK.decoct(fileperms($file_name)).HTML_BR;
}

require('includes/application.php');
$zone_id = 0;
$error = false;
$country_text='COUNTRY';
$state_text='STATE';
$zone_setup_text='ZONE_SETUP';
$country_1_text=$country_text.UNDERSCORE.ONE_STRING;
if ($process)
{
	$config_written_text='config_written';
	if (!$_SESSION[$config_written_text])
	{
		$s='includes/configure';
		$file=DIR_FS_CATALOG . $s.PHP;
		$condition=file_exists($file) && !is_writeable($file);
		if ($condition)
		{
			install_error(TEXT_STEP4_ERROR,$retry_button_submit);
			$post_data.='
			<tr>
				<td>
		      <font size="1">
						<p><br/>'.TEXT_STEP4_ERROR_1.'</p>
		          <li>includes/configure.php</li>
		          <li>includes/configure.save.php</li>
		        </p>
		      </font>
				</td>
		  </tr>
		';
			$error=true;
		}
		else
		{
			$_SESSION[$config_written_text]=true;
			define('FILE_CONFIGURE', $s.PHP);
			define('FILE_CONFIGURE_SAVE', $s.'.save'.PHP);
			define('ADMIN','admin/');
			$document_root = $_SERVER['DOCUMENT_ROOT'];
			if (substr($document_root,-1,1)==SLASH)
			{
				$document_root=substr($document_root,0,strlen($document_root)-1);
			}
			$document_root .= $local_install_path;
			$ws_catalog = $_POST['DIR_WS_CATALOG'];
			$http_server = $_POST['HTTP_SERVER'];
			$https_server = $_POST['HTTPS_SERVER'];
			$enable_ssl = ($_POST['ENABLE_SSL'] == true) ? TRUE_STRING_S : FALSE_STRING_S;

			$db_server=$_POST['DB_SERVER'];
			$db_server_username=$_POST['DB_SERVER_USERNAME'];
			$db_server_password=$_POST['DB_SERVER_PASSWORD'];
			$db_database=$_POST['DB_DATABASE'];
			$use_pcconnect=($_POST['USE_PCONNECT'] == true) ? TRUE_STRING_S : FALSE_STRING_S;

			$level_text='$'.'level';
			$file_contents =
"<?php
/* --------------------------------------------------------------
OL-Commerce v5/AJAX

Common(!) config for admin and catalog (Modified by W. Kaiser)

http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------

based on:

(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce (configure.php,v 113 2003/02/10); www.oscommerce.com
(c) 2004  		XT - Commerce; www.ol-Commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

//Include external config data (multi-store capability)
if (!isset(".$level_text."))
{
	".$level_text."='';
}
include(".$level_text.".'inc/xtc_get_external_config_data.inc.php');
//Include external config data (multi-store capability)

//
//	Generated on ".date('d.m.Y H:i:s')."
//
//	Define the webserver and path parameters
// 	* DIR_FS_* = Filesystem directories (local/physical)
// 	* DIR_WS_* = Webserver directories (virtual/URL)

define('HTTP_SERVER', '$http_server'); 									// eg, http://localhost - should not be empty for productive servers
define('HTTPS_SERVER', '$https_server'); 								// eg, https://localhost - should not be empty for productive servers
define('HTTP_CATALOG_SERVER', HTTP_SERVER);
define('HTTPS_CATALOG_SERVER', HTTPS_SERVER);
define('ENABLE_SSL',$enable_ssl); 											// secure webserver for checkout procedure?
define('ENABLE_SSL_CATALOG', ENABLE_SSL); 							// secure webserver for catalog module

define('DIR_WS_CATALOG', '$ws_catalog'); 								// absolute path required
define('DIR_FS_DOCUMENT_ROOT', '$document_root');
define('DIR_FS_CATALOG', DIR_FS_DOCUMENT_ROOT);
define('DIR_WS_IMAGES', 'images/');
define('DIR_WS_PRODUCT_IMAGES', DIR_WS_IMAGES . 'product_images/');
define('DIR_WS_ORIGINAL_IMAGES', DIR_WS_PRODUCT_IMAGES . 'original_images/');
define('DIR_WS_THUMBNAIL_IMAGES', DIR_WS_PRODUCT_IMAGES . 'thumbnail_images/');
define('DIR_WS_INFO_IMAGES', DIR_WS_PRODUCT_IMAGES . 'info_images/');
define('DIR_WS_POPUP_IMAGES', DIR_WS_PRODUCT_IMAGES . 'popup_images/');
define('DIR_WS_PROMOTION_IMAGES', DIR_WS_IMAGES .'products_promotions/');
define('DIR_WS_OPTIONS_IMAGES', DIR_WS_IMAGES .'product_options/');
define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
define('DIR_WS_INCLUDES', 'includes/');
define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
define('DIR_WS_LANGUAGES', DIR_FS_CATALOG . 'lang/');
define('DIR_FS_INC', DIR_FS_CATALOG . 'inc/');

// define database connection
define('DB_SERVER', '$db_server'); 											// eg, localhost - should not be empty for productive servers
define('DB_SERVER_USERNAME', '$db_server_username');
define('DB_SERVER_PASSWORD', '$db_server_password');
define('DB_DATABASE', '$db_database');

define('USE_PCONNECT', '$use_pcconnect'); 							// use persistent connections?

	//	define ADODB usage bof
	define('USE_ADODB', false); 													// Set to TRUE_STRING_S to use 'ADODB' database access
	define('ADOBD_DB_TYPE', 'mysql'); 										// ADODB database driver to use
		//See http://phplens.com/lens/adodb/docs-adodbhtm#drivers for supported databases
	define('ADOBD_USE_CACHING', false); 									// Set to TRUE_STRING_S to use the ADODB caching facility
	define('ADOBD_CACHING_SECONDS', 3600); 								// Set # of secondes to retain ADODB cached data (3600 is one hour)
	define('ADOBD_USE_STATS', false); 										// Set to TRUE_STRING_S to use 'ADODB' statistics
	define('ADODB_USE_LOGGING', false); 									// Set to TRUE_STRING_S to use 'ADODB' SQL command logging
	//	define ADODB usage eof

	// define database connection

define('STORE_SESSIONS', 'mysql'); 											// store session data in DB

define('ENABLE_AJAX_MODE', true); 											// Set to FALSE_STRING_S if not to use AJAX-mode

// Not functional yet
define('USE_PAYPAL_IPN', false); 												// Set to TRUE_STRING_S to use PayPal with payment feedback
define('USE_PAYPAL_WPP', false); 												// Set to TRUE_STRING_S to use PayPal 'Direct Payment' and 'Express Checkout'
/// Not functional yet
define('TABLE_PREFIX', '$table_prefix');								// eg, xtc_
?>";
			//Store includes/configure.php
			//	W Kaiser - Allow table-prefix
			store_config(DIR_FS_CATALOG.FILE_CONFIGURE, $file_contents);
			//	W Kaiser - Delete duplicate parameter definition
			store_config(DIR_FS_CATALOG.FILE_CONFIGURE_SAVE, $file_contents);
			//	W Kaiser - Allow table-prefix
			$_SESSION['HOMEPAGE_URL']=$http_server;
		}
	}
	$level=ADMIN_PATH_PREFIX;
	require(DIR_FS_INCLUDES.$configure_php);

	$country = xtc_db_prepare_input($_POST[$country_text]);
	$state=get_check_input($state_text, ENTRY_STATE_MIN_LENGTH,ENTRY_STATE_ERROR);
}
else
{
	$country = xtc_db_prepare_input($_POST[$country_1_text]);
	if ($country)
	{
		$_POST[$country_text]=$country;
	}
	else
	{
		$country = 81;	//Germany is default
	}
}
if (!$error)
{
	$zone_query = "select distinct zone_id from ".TABLE_ZONES." where zone_country_id = '".$country.APOS;
	if ($state)
	{
		$state=xtc_db_input($state);
		$like=" like '" . $state .	"%".APOS;
		$zone_query .= SQL_AND.LPAREN."zone_name".$like.SQL_OR."zone_code".$like.RPAREN;
	}
	$zone_query = xtc_db_query($zone_query);
	$entry_state_has_zones =xtc_db_num_rows($zone_query) > 0;
	if ($entry_state_has_zones)
	{
		$zone = xtc_db_fetch_array($zone_query);
		$zone_id = $zone['zone_id'];
	}
}
$cell_start='<td valign="top" align="left">';
$font_end='</font>';
$cell_end=$font_end.'</td>';
$font_size_1='<font size="1">';
$text_start=$cell_start.'<strong>'.$font_size_1;
$font_strong_end=$font_end.'</strong>';
$text_end=$font_strong_end.'</td>';
$field_start=$cell_start.$font_size_1;
$field_start_2='<td valign="top" align="left" colspan="2" style="font-size:8pt">';
$required_start='<strong><font color="red" size="1"> * ';
$required_cell0=$required_start;
$required_cell=$font_end.$required_cell0.$text_end;
$required_text_break_cell=$required_cell0.HTML_BR;
$old_fields=array(
	array('FIRST_NAME',ENTRY_FIRST_NAME_MIN_LENGTH,ENTRY_FIRST_NAME_ERROR,TEXT_FIRSTNAME),
	array('LAST_NAME',ENTRY_LAST_NAME_MIN_LENGTH,ENTRY_LAST_NAME_ERROR,TEXT_LASTNAME),
	array('EMAIL_ADRESS',ENTRY_EMAIL_ADDRESS_MIN_LENGTH,ENTRY_EMAIL_ADDRESS_ERROR,TEXT_EMAIL),
	array('STREET_ADRESS',ENTRY_STREET_ADDRESS_MIN_LENGTH,ENTRY_STREET_ADDRESS_ERROR,TEXT_STREET),
	array('POST_CODE',ENTRY_POSTCODE_MIN_LENGTH,ENTRY_POST_CODE_ERROR,TEXT_POSTCODE),
	array('CITY',ENTRY_CITY_MIN_LENGTH,ENTRY_CITY_ERROR,TEXT_CITY),
	array(EMPTY_STRING,0,EMPTY_STRING,EMPTY_STRING,EMPTY_STRING),	//Here we will display country and state boxes
	array('TELEPHONE',ENTRY_TELEPHONE_MIN_LENGTH,ENTRY_TELEPHONE_NUMBER_ERROR,TEXT_TEL),
	array('PASSWORD',ENTRY_PASSWORD_MIN_LENGTH,ENTRY_PASSWORD_ERROR,TEXT_PASSWORD),
	array('PASSWORD_CONFIRMATION',ENTRY_PASSWORD_MIN_LENGTH,ENTRY_PASSWORD_ERROR,TEXT_PASSWORD_CONF),
);
$old_fields_count=sizeof($old_fields);

$old_fields_1=array(
	array('STORE_NAME',ENTRY_LAST_NAME_MIN_LENGTH,ENTRY_STORE_NAME_ERROR,TEXT_STORE),
	array('COMPANY',ENTRY_LAST_NAME_MIN_LENGTH,ENTRY_COMPANY_ERROR,TEXT_COMPANY),
	array('EMAIL_ADRESS_FROM',ENTRY_EMAIL_ADDRESS_MIN_LENGTH,ENTRY_EMAIL_ADDRESS_FROM_ERROR,TEXT_EMAIL_FROM)
);
$old_fields_1_count=sizeof($old_fields_1);

$new_fields=array(
	array('STORE_BANK_NAME', 0,EMPTY_STRING),
	array('STORE_BANK_BLZ', 0,EMPTY_STRING),
	array('STORE_BANK_ACCOUNT', 0,EMPTY_STRING),
	array('STORE_BANK_BIC', 0,EMPTY_STRING),
	array('STORE_BANK_IBAN', 0,EMPTY_STRING),
	array('STORE_USTID', 0,EMPTY_STRING),
	array('STORE_TAXNR', 0,EMPTY_STRING),
	array('STORE_REGISTER', 0,EMPTY_STRING),
	array('STORE_REGISTER_NR', 0,EMPTY_STRING),
	array('STORE_MANAGER', 0,EMPTY_STRING),
	array('STORE_DIRECTOR', 0,EMPTY_STRING),
);
$new_fields_count=sizeof($new_fields);
if ($process)
{
	for ($i=0;$i<$old_fields_count;$i++)
	{
		$old_field=$old_fields[$i];
		$field_name=$old_field[0];
		if ($field_name)
		{
			$variable_name=strtolower($field_name);
			$$variable_name = get_check_input($field_name,$old_field[1],$old_field[2]);
		}
	}
	$zone_setup = xtc_db_prepare_input($_POST[$zone_setup_text]);
	if ($password != $password_confirmation)
	{
		$error = true;
		$messageStack->add($install_step, ENTRY_PASSWORD_ERROR_NOT_MATCHING);
	}
	for ($i=0;$i<$old_fields_1_count;$i++)
	{
		$old_field=$old_fields_1[$i];
		$field_name=$old_field[0];
		if ($field_name)
		{
			$variable_name=strtolower($field_name);
			$$variable_name = get_check_input($field_name,$old_field[1],$old_field[2]);
		}
	}
	for ($i=0;$i<$new_fields_count;$i++)
	{
		$new_field=$new_fields[$i];
		$field_name=$new_field[0];
		$variable_name=strtolower($field_name);
		$$variable_name = get_check_input($field_name,$new_field[1],$new_field[2]);
	}
	if (!$error)
	{
		if ($db_error)
		{
			install_error(TEXT_CONNECTION_ERROR,$back_retry_submit);
			$post_data.='
			<tr>
				<td>
					<font size="1">
						<p>'.TEXT_DB_ERROR_1.'</p>
						<p>'.TEXT_DB_ERROR_2.'</p>
					</font>
				</td>
		  </tr>
		';
		}
		else
		{
			$default=".default";
			$default_php=$default.PHP;
			$dir_ws_catalog='DIR_WS_CATALOG';
			$htaccess=".htaccess";
			$multi_shop_multi_db='multi_shop_multi_db/';
			//Configure .htaccess. (for the custom 404 and "mod_rewrite" handler)
			$file_name=$htaccess;
			$file_content=file_get_contents($file_name.$default);
			$file_name=DIR_FS_CATALOG.$file_name;
			if (file_exists($file_name))
			{
				@copy ($file_name,$file_name.'.alt');
				//@unlink($file_name);
			}
			$file_content=str_replace($dir_ws_catalog,DIR_WS_CATALOG,$file_content);
			//file_put_contents ($file_name, $file_content);
			store_config($file_name, $file_content);
			//Configure multi_shop_multi_db/configure.php (for the Multi-Shop capability)
			$file_name=$multi_shop_multi_db.$configure_php;
			$file_content=file_get_contents($file_name.$default);
			$file_content=str_replace($dir_ws_catalog,DIR_WS_CATALOG,$file_content);
			$file_content=str_replace('$db_database_1',$db_database_1,$file_content);
			$file_content=str_replace('$table_prefix_individual_data',$table_prefix_individual_data,$file_content);
			//file_put_contents ($file_name, $file_content);
			store_config($file_name, $file_content);
			//Configure multi_shop_multi_db/.htaccess (for the Multi-Shop capability)
			$file_name=$multi_shop_multi_db.$htaccess;
			$file_content=file_get_contents($file_name.$default);
			$file_content=str_replace($dir_ws_catalog,DIR_WS_CATALOG,$file_content);
			//file_put_contents ($file_name, $file_content);
			store_config($file_name, $file_content);
			//
			//Configure "Elm@r",  "chCounter" and "livehelp"
			//
			$inc_php=".inc".PHP;
			//
			//Configure "Elm@r"
			//
			$file_name0=DIR_FS_CATALOG."elmar_config";
			$file=$file_name0.$default_php;
			if (file_exists($file))
			{
				$file_content=file_get_contents($file);
				$shop_url_tag='#shop_url#';
				$shop_url=HTTP_SERVER.DIR_WS_CATALOG;
				$file_content=str_replace($shop_url_tag,$shop_url,$file_content);
				$file_name=$file_name0.$inc_php;
				//file_put_contents ($file_name, $file_content);
				store_config($file_name, $file_content);
				$file_name0=DIR_FS_CATALOG."elmar/config";
				$file=$file_name0.$default_php;
				if (file_exists($file))
				{
					$file_content=file_get_contents($file);
					$file_content=str_replace($shop_url_tag,$shop_url,$file_content);
					$file_content=str_replace('#shop_url_abs#',DIR_FS_CATALOG,$file_content);
					$file_content=str_replace('#elmar_pass#',$password ,$file_content);
					$file_name=$file_name0.$inc_php;
					//file_put_contents ($file_name, $file_content);
					store_config($file_name, $file_content);
				}
			}
			//
			//Configure "chCounter"
			//
			$file_name0=DIR_FS_CATALOG."chCounter/includes/config";
			$file=$file_name0.$default_php;
			if (file_exists($file))
			{
				$file_content=file_get_contents($file);
				$file_content=str_replace('#db_server#',DB_SERVER,$file_content);
				$file_content=str_replace('#db_user#',DB_SERVER_USERNAME,$file_content);
				$file_content=str_replace('#db_password#',DB_SERVER_PASSWORD,$file_content);
				$file_content=str_replace('#db_database#',DB_DATABASE,$file_content);
				$file_content=str_replace('#user#',$email_adress,$file_content);
				$file_content=str_replace('#pass#',$password,$file_content);
				$file_content=str_replace('#homepage_url#',$_SESSION['HOMEPAGE_URL'],$file_content);
				$file_name=$file_name0.$inc_php;
				//file_put_contents ($file_name, $file_content);
				store_config($file_name, $file_content);
			}
			//
			//Configure "livehelp"
			//
			$livehelp='livehelp';
			$file_name0=$livehelp.'.sql';
			$file_name=$file_name0.$default;
			if (file_exists($file_name))
			{
				$livehelp.=SLASH;
				$file_content=file_get_contents($file_name);
				$file_content=str_replace('#user#',$email_adress,$file_content);
				$file_content=str_replace('#pass#',$password,$file_content);
				$homepage=DIR_WS_CATALOG.$livehelp;
				$http_homepage=HTTP_SERVER.$homepage;
				$file_content=str_replace('#homepage#',HTTP_SERVER.$homepage,$file_content);
				if (ENABLE_SSL)
				{
					$homepage=HTTPS_SERVER.$homepage;
				}
				else
				{
					$homepage=$http_homepage;
				}
				$file_content=str_replace('#s_homepage#',$homepage,$file_content);
				$file_content=str_replace('#store_name#',$_POST[$store_name_text],$file_content);
				//file_put_contents ($file_name0.PHP, $file_content);
				store_config($file_name0.PHP, $file_contents);
				$dir=DIR_FS_CATALOG.$livehelp;
				$file_name0=$dir."config";
				$file_name=$file_name0.$default_php;
				if (file_exists($file_name))
				{
					$file_content=file_get_contents($file_name);
					$file_content=str_replace('DB-SERVER',DB_SERVER,$file_content);
					$file_content=str_replace('DB-USERNAME',DB_SERVER_USERNAME,$file_content);
					$file_content=str_replace('DB-PASSWORD',DB_SERVER_PASSWORD,$file_content);
					$file_content=str_replace('DB-DATABASE',DB_DATABASE,$file_content);
					$file_content=str_replace('ROOTPATH',$dir,$file_content);
					$file_name=$file_name0.PHP;
					//file_put_contents ($file_name, $file_content);
					store_config($file_name, $file_content);
				}
			}
			//Make sure record does not already exist
			$sql_where=SQL_WHERE."customers_id = '1'";
			$sql_from=SQL_FROM . TABLE_CUSTOMERS . $sql_where;
			$result=xtc_db_query(SELECT_COUNT.$sql_from);
			$repeat_installation=xtc_db_num_rows($result)>0;
			if ($repeat_installation)
			{
				$result=xtc_db_query("delete".$sql_from);
				$result=xtc_db_query(DELETE_FROM . TABLE_CUSTOMERS_INFO . " where customers_info_id = '1'");
				$result=xtc_db_query(DELETE_FROM . TABLE_ADDRESS_BOOK . $sql_where);
			}
			$sep="', '";
			xtc_db_query(INSERT_INTO . TABLE_CUSTOMERS . " (
			customers_id,
			customers_status,
			customers_firstname,
			customers_lastname,
			customers_email_address,
			customers_default_address_id,
			customers_telephone,
			customers_password,
			delete_user) VALUES
			(
			'1',
			'0','".
			$first_name.$sep.
			$last_name.$sep.
			$email_adress."','1','".
			$telephone.$sep.
			xtc_encrypt_password($password)."','0')");

			xtc_db_query(INSERT_INTO . TABLE_CUSTOMERS_INFO . " (
			customers_info_id,
			customers_info_date_of_last_logon,
			customers_info_number_of_logons,
			customers_info_date_account_created,
			customers_info_date_account_last_modified,
			global_product_notifications) VALUES
			('1','','','','','')");

			xtc_db_query(INSERT_INTO .TABLE_ADDRESS_BOOK . " (
			customers_id,
			entry_company,
			entry_firstname,
			entry_lastname,
			entry_street_address,
			entry_postcode,
			entry_city,
			entry_state,
			entry_country_id,
			entry_zone_id) VALUES
			('1','".
			$company.$sep.
			$first_name.$sep.
			$last_name.$sep.
			$street_adress.$sep.
			$post_code.$sep.
			$city.$sep.
			$state.$sep.
			$country.$sep.
			$zone_id."'
			)");
			$update_string = SQL_UPDATE .TABLE_CONFIGURATION . " SET configuration_value='";
			$where_string = "' WHERE configuration_key = '";
			for ($i=0;$i<$old_fields_1_count;$i++)
			{
				$field_name=$old_fields_1[$i][0];
				if ($field_name)
				{
					$variable_name=strtolower($field_name);
					xtc_db_query($update_string.$$variable_name.$where_string.$field_name.APOS);
				}
			}
			for ($i=0;$i<$new_fields_count;$i++)
			{
				$field_name=$new_fields[$i][0];
				$variable_name=strtolower($field_name);
				xtc_db_query($update_string.$$variable_name.$where_string.$field_name.APOS);
			}

			xtc_db_query($update_string.$email_adress.$where_string."STORE_OWNER_EMAIL_ADDRESS'");
			xtc_db_query($update_string.$country.$where_string."SHIPPING_ORIGIN_COUNTRY'");
			xtc_db_query($update_string.$post_code.$where_string."SHIPPING_ORIGIN_ZIP'");

			$update_string=$update_string.$email_adress_from.$where_string;
			xtc_db_query($update_string."EMAIL_FROM'");
			xtc_db_query($update_string."EMAIL_BILLING_FORWARDING_STRING'");
			xtc_db_query($update_string."EMAIL_BILLING_ADDRESS'");
			xtc_db_query($update_string."CONTACT_US_EMAIL_ADDRESS'");
			xtc_db_query($update_string."EMAIL_SUPPORT_ADDRESS'");
			if ($zone_setup == 'yes')
			{
				// Steuersätze des jeweiligen landes einstellen!
				$tax_normal=EMPTY_STRING;
				$tax_normal_text=EMPTY_STRING;
				$tax_special=EMPTY_STRING;
				$tax_special_text=EMPTY_STRING;
				//Status as of 2/2007
				switch ($country)
				{
					case '81':
						// Deutschland
						$tax_normal='19.0000';
						$tax_special='7.0000';
						break;
					case '14':
						// Austria
						$tax_normal='20.0000';
						$tax_special='10.0000';
						break;
					case '21':
						// Belgien
						$tax_normal='21.0000';
						$tax_special='6.0000';
						break;
					case '57':
						// Dänemark
						$tax_normal='25.0000';
						$tax_special='25.0000';
						break;
					case '72':
						// Finnland
						$tax_normal='22.0000';
						$tax_special='8.0000';
						break;
					case '73':
						// Frankreich
						$tax_normal='19.6000';
						$tax_special='5.5000';
						break;
					case '84':
						// Griechenland
						$tax_normal='19.0000';
						$tax_special='4.5000';
						break;
					case '103':
						// Irland
						$tax_normal='21.0000';
						$tax_special='13.5000';
						break;
					case '105':
						// Italien
						$tax_normal='20.0000';
						$tax_special='4.0000';
						break;
					case '124':
						// Luxemburg
						$tax_normal='15.0000';
						$tax_special='3.0000';
						break;
					case '150':
						// Niederlande
						$tax_normal='19.0000';
						$tax_special='6.0000';
						break;
					case '171':
						// Portugal
						$tax_normal='21.0000';
						$tax_special='5.0000';
						break;
					case '195':
						// Spain
						$tax_normal='16.0000';
						$tax_special='4.0000';
						break;
					case '203':
						// Schweden
						$tax_normal='25.0000';
						$tax_special='6.0000';
						break;
					case '222':
						// UK
						$tax_normal='17.5000';
						$tax_special='5.0000';
						break;
				}
				$tax_normal_text='UST '.(float)$tax_normal.'%';
				$tax_special_text='UST '.(float)$tax_special.'%';
				// Steuersätze / tax_rates
				//	W. Kaiser - Allow table-prefix
				if ($repeat_installation)
				{
					$result=xtc_db_query(DELETE_FROM. TABLE_TAX_RATES);
					$result=xtc_db_query(DELETE_FROM. TABLE_TAX_CLASS);
					$result=xtc_db_query(DELETE_FROM. TABLE_GEO_ZONES);
				}
				$insert_string_trailer=', last_modified, date_added) VALUES (';
				$insert_string = INSERT_INTO . TABLE_TAX_RATES .
				' (tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate,
					tax_description'.$insert_string_trailer;
				xtc_db_query($insert_string . "1, 5, 1, 1, '".$tax_normal.$sep.$tax_normal_text."', NULL,  now())");
				xtc_db_query($insert_string . "2, 5, 2, 1, '".$tax_special.$sep.$tax_special_text."', NULL,  now())");
				xtc_db_query($insert_string . "3, 6, 1, 1, '0.0000', 'EU-AUS-UST 0%', NULL,  now())");
				xtc_db_query($insert_string . "4, 6, 2, 1, '0.0000', 'EU-AUS-UST 0%', NULL,  now())");
				// Steuerklassen
				$insert_string = INSERT_INTO . TABLE_TAX_CLASS .' (tax_class_id, tax_class_title,
				tax_class_description'.$insert_string_trailer;
				xtc_db_query($insert_string . "1, 'Standardsatz', '', NULL, now())");
				xtc_db_query($insert_string . "2, 'ermäßigter Steuersatz', '', NULL, now())");
				// Steuersätze
				$insert_string = INSERT_INTO . TABLE_GEO_ZONES . ' (geo_zone_id, geo_zone_name,
				geo_zone_description'.$insert_string_trailer;
				xtc_db_query($insert_string . "6, 'Steuerzone EU-Ausland', '', NULL, now())");
				xtc_db_query($insert_string . "5, 'Steuerzone EU', 'Steuerzone für die EU', NULL, now())");
				xtc_db_query($insert_string . "7, 'Steuerzone B2B', '', NULL, now())");
				// EU-Steuerzonen
			}
			ActivateProg($next_step_link);
		}
	}
}
$headline0='
  <tr>
  	<td colspan="2">
  		<br/>
      <table class="main_content_outer" cellspacing="0" cellpadding="0" align="left">
			  <tr>
			    <td class="header_image"></td>
			    <td class="header">#</td>
			  </tr>
			</table>
		</td>
  </tr>
  <tr>
    <td colspan="2" align="center">'.
			$required_start.TEXT_REQU_INFORMATION.'</font></strong>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="left">
			<br/>@<br/><br/>
		</td>
  </tr>
';
$size40='size="40"';
$text_text='text';
$headline=str_replace(HASH,TITLE_ADMIN_CONFIG,$headline0);
$headline=str_replace(ATSIGN,TITLE_ADMIN_CONFIG_NOTE,$headline);
$post_data.='
</table>
<table class="main_content_outer" cellspacing="2" cellpadding="2">
'.$headline;
for ($i=0;$i<$old_fields_count;$i++)
{
	$old_field=$old_fields[$i];
	$field_name=$old_field[0];
	if ($field_name)
	{
		if (strpos($field_name,'PASSWORD')!==false)
		{
			$field=xtc_draw_password_field_installer($field_name,EMPTY_STRING);
		}
		else
		{
			$field=xtc_draw_input_field_installer($field_name,EMPTY_STRING,$text_text,$size40);
		}
		$post_data.='
  <tr>'.
		$text_start.$old_field[3].$text_end.$field_start.$field.$required_cell.'
  </tr>
';
		unset($hidden_fields[$field_name]);
	}
	else
	{
		$post_data.='
  <tr>'.
		$text_start.TEXT_COUNTRY.$text_end.
    $field_start_2.xtc_get_country_list($country_text,$country,
    'onchange=" country_drop_down_change(this,\''.CURRENT_SCRIPT.'\')"').HTML_BR.
		$required_start.TEXT_COUNTRY_LONG.$font_strong_end.
		xtc_draw_hidden_field_installer($country_1_text).'</td>
  </tr>
  <tr>'.
		$text_start.TEXT_STATE.$text_end.
    $field_start_2;
		if ($entry_state_has_zones)
		{
			$zones_array = array();
			$zones_query = xtc_db_query("select zone_name from " . TABLE_ZONES .
			" where zone_country_id = '" . $country . "' order by zone_name");
			while ($zones_values = xtc_db_fetch_array($zones_query))
			{
				$zone_name=$zones_values['zone_name'];
				$zones_array[] = array(
				'id' => $zone_name,
				'text' => $zone_name);
			}
			$post_data.=xtc_draw_pull_down_menu($state_text, $zones_array,$country);
		}
		else
		{
			$post_data.=xtc_draw_input_field_installer($state_text,EMPTY_STRING,$text_text,$size40);
		}
$post_data.=
$required_start.$text_end.'
	</tr>
';
	}
}
unset($hidden_fields[$country_text]);
unset($hidden_fields[$country_1_text]);
unset($hidden_fields[$state_text]);
$headline=str_replace(HASH,TITLE_SHOP_CONFIG,$headline0);
$headline=str_replace(ATSIGN,TITLE_SHOP_CONFIG_NOTE,$headline);
$post_data.=$headline;
for ($i=0;$i<$old_fields_1_count;$i++)
{
	$old_field=$old_fields_1[$i];
	$field_name=$old_field[0];
	$field=xtc_draw_input_field_installer($field_name,EMPTY_STRING,$text_text,$size40);
	$post_data.='
<tr>'.
	$text_start.$old_field[3].$text_end.$field_start.$field.$required_cell.'
</tr>
';
	unset($hidden_fields[$field_name]);
}

$title_text=ADMIN_PATH_PREFIX.'lang/'.SESSION_LANGUAGE.'/admin/';
include($title_text.'configuration.php');
include($title_text.SESSION_LANGUAGE.'.php');
$headline=str_replace(HASH,TITLE_COMPANY_DATA_CONFIG,$headline0);
$headline=str_replace(ATSIGN,TITLE_COMPANY_DATA_CONFIG_NOTE,$headline);
$post_data.=$headline.'
  <tr>
		<td colspan="2">
			<b>
				'.sprintf(TEXT_OPTIONAL_COMPANY_FIELDS,BOX_HEADING_SYSTEM,BOX_CONFIGURATION_100).'
			</b>
			<br/><br/>
		</td>
  </tr>
';
$title_text='_TITLE';
$desc_text='_DESC';
for ($i=0;$i<$new_fields_count;$i++)
{
	$field_name=$new_fields[$i][0];
	$field_title=constant($field_name.$title_text);
	$field_desc=constant($field_name.$desc_text);
	$post_data.='
  <tr>'.
	$text_start.$field_title.COLON.$text_end.
	$field_start.xtc_draw_input_field_installer($field_name,EMPTY_STRING,$text_text,$size40).
	HTML_BR.$field_desc.HTML_BR.$cell_end.'
  </tr>
';
	unset($hidden_fields[$field_name]);
}
unset($hidden_fields[$zone_setup_text]);
$headline=str_replace(HASH,TITLE_ZONE_CONFIG,$headline0);
$headline=str_replace(ATSIGN,TITLE_ZONE_CONFIG_NOTE,$headline);
$post_data.=$headline.'
  <tr>'.
		$field_start_2.'<strong>'.$font_size_1.TEXT_ZONE.$font_strong_end.HTML_NBSP.
			$font_size_1.TEXT_ZONE_YES.$font_end.xtc_draw_radio_field_installer($zone_setup_text, 'yes', TRUE_STRING_S).
			HTML_NBSP.HTML_NBSP.
      $font_size_1.TEXT_ZONE_NO.$font_end.xtc_draw_radio_field_installer($zone_setup_text, 'no').
			$required_start.$font_strong_end.'
    </td>
  </tr>
';
unset($hidden_fields[$zone_setup_text]);
$include_form_check=true;
include('includes/program_frame.php');
?>
