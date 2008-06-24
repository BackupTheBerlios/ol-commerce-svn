<?php
/* --------------------------------------------------------------
$Id: application.php,v 1.1.1.1.2.1 2007/04/08 07:18:37 gswkaiser Exp $

OL-Commerce Version 2.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(application.php,v 1.4 2002/11/29); www.oscommerce.com
(c) 2003	    nextcommerce (application.php,v 1.16 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/
// W. Kaiser - AJAX
define('IS_LOCAL_HOST',false);
define('FULL_ERRORS','full_errors');
$install_step=basename($_SERVER['SCRIPT_NAME']);
define('CURRENT_SCRIPT',$install_step);
$s=strrpos($install_step,'.');
$install_step=substr($install_step,0,$s);
$install_step=substr($install_step,$s-1,1);
$p_step=$install_step-1;
$n_step=$install_step+1;
$s='IS_AJAX_PROCESSING_FORCED';
if (!defined($s))
{
	define($s,false);
}
if (!IS_AJAX_PROCESSING_FORCED)
{
	$post_data='
<table class="main_content">
';
	define('IS_MULTI_SHOP',false);
	define('IS_ADMIN_FUNCTION',false);
	define('NOT_IS_ADMIN_FUNCTION',true);
	// Start the Install_Session
	session_start();
	if ($install_step==1)
	{
		unset($_SESSION);
	}
	if (!isset($_SESSION[FULL_ERRORS]))
	{
		$_SESSION[FULL_ERRORS]=$_GET[FULL_ERRORS];
	}
	define('MULTI_DB_SERVER',false);
	// W. Kaiser - AJAX
	define('ADMIN_PATH_PREFIX','../');
	require_once(ADMIN_PATH_PREFIX.'inc/xtc_define_global_constants.inc.php');
	// Some FileSystem Directories
	$s='DIR_FS_DOCUMENT_ROOT';
	if (!defined($s))
	{
		define($s, $_SERVER['DOCUMENT_ROOT']);
		$install_dir=str_replace('\\',SLASH,$_SERVER['PHP_SELF']);
		$local_install_path=$install_dir;
		$install_dir=explode(SLASH,dirname($install_dir));
		$install_dir=$install_dir[sizeof($install_dir)-1].SLASH;

		$s=strpos($local_install_path,'olc_installer');
		$local_install_path=substr($local_install_path,0,$s);
		define('DIR_WS_CATALOG', $local_install_path);
		define('DIR_FS_CATALOG', DIR_FS_DOCUMENT_ROOT . $local_install_path);
	}
	define('DIR_FS_INCLUDES', DIR_FS_CATALOG.'includes/');
	define('DIR_FS_INC', DIR_FS_CATALOG.'inc/');
	$is_ajax_processing=false;
	$use_ajax=false;
	if (false && is_file('includes/ajax.js.php'))
	{
		$no_ajax_text='no_ajax';
		if (!$_SESSION[$no_ajax_text])
		{
			$no_ajax=$_GET[$no_ajax_text];
			$_SESSION[$no_ajax_text]=$no_ajax;
			if (!$no_ajax)
			{
				$ajax_text='ajax';
				$use_ajax=$_SESSION[$ajax_text];
				if (isset($use_ajax))
				{
					$is_ajax_processing=$use_ajax;
				}
				else
				{
					$use_ajax=$_POST[$ajax_text]=='true';
					$_SESSION[$ajax_text]=$use_ajax;
				}
			}
		}
	}
	define('USE_AJAX',$use_ajax);
	define('NOT_USE_AJAX',!USE_AJAX);
	define('IS_AJAX_PROCESSING',$is_ajax_processing);
	define('NOT_IS_AJAX_PROCESSING',!IS_AJAX_PROCESSING);

	// Set the level of error reporting
	error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

	//	W. Kaiser - Allow table-prefix
	$table_prefix_text='TABLE_PREFIX';
	$table_prefix=$_SESSION[$table_prefix_text];
	if (!isset($table_prefix))
	{
		$table_prefix = $_POST[$table_prefix_text];
		if ($table_prefix == EMPTY_STRING)
		{
			$table_prefix = $_GET[$table_prefix_text];
		}
		$table_prefix = trim(stripslashes($table_prefix));
	}
	if ($table_prefix <> EMPTY_STRING)
	{
		if (strpos($table_prefix, UNDERSCORE) === false)
		{
			$table_prefix .= UNDERSCORE;
		}
		$_SESSION[$table_prefix_text]=$table_prefix;
	}
	define($table_prefix_text, $table_prefix);
	require_once(DIR_FS_INC.'xtc_draw_hidden_field_installer.inc.php');
	$db_server_text='DB_SERVER';
	$db_username_text='DB_SERVER_USERNAME';
	$db_password_text='DB_SERVER_PASSWORD';
	$db_database_text='DB_DATABASE';
	// include
	include_once(DIR_FS_INC.'xtc_error_handler.inc.php');
	// Include Database functions for installer
	require_once(DIR_FS_INC.'xtc_db_prepare_input.inc.php');
	require_once(DIR_FS_INC.'xtc_db_connect.inc.php');
	require_once(DIR_FS_INC.'xtc_db_select_db.inc.php');
	require_once(DIR_FS_INC.'xtc_db_close.inc.php');
	require_once(DIR_FS_INC.'xtc_db_query.inc.php');
	require_once(DIR_FS_INC.'xtc_db_fetch_array.inc.php');
	require_once(DIR_FS_INC.'xtc_db_num_rows.inc.php');
	require_once(DIR_FS_INC.'xtc_db_data_seek.inc.php');
	require_once(DIR_FS_INC.'xtc_db_input.inc.php');
	require_once(DIR_FS_INC.'xtc_db_insert_id.inc.php');
	require_once(DIR_FS_INC.'xtc_db_free_result.inc.php');
	require_once(DIR_FS_INC.'xtc_db_test_create_db_permission.inc.php');
	require_once(DIR_FS_INC.'xtc_db_test_connection.inc.php');
	require_once(DIR_FS_INC.'xtc_db_install.inc.php');

	// include General functions
	require_once(DIR_FS_INC.'xtc_set_time_limit.inc.php');
	require_once(DIR_FS_INC.'xtc_check_agent.inc.php');
	require_once(DIR_FS_INC.'xtc_in_array.inc.php');
	require_once(DIR_FS_INC.'xtc_seo_url.inc.php');
	require_once(DIR_FS_INC.'xtc_redirect.inc.php');
	require_once(DIR_FS_INC.'xtc_draw_form.inc.php');

	// include Html output functions
	require_once(DIR_FS_INC.'xtc_draw_input_field_installer.inc.php');
	require_once(DIR_FS_INC.'xtc_draw_password_field_installer.inc.php');
	require_once(DIR_FS_INC.'xtc_draw_selection_field_installer.inc.php');
	require_once(DIR_FS_INC.'xtc_draw_checkbox_field_installer.inc.php');
	require_once(DIR_FS_INC.'xtc_draw_radio_field_installer.inc.php');
	require_once(DIR_FS_INC.'xtc_gdlib_check.inc.php');

	define('BUTTON_BOX',
	'<div class="button_box">
		<br/>
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="width: 95%">
	  	<tr>
	  		<td align="left">
	  			&nbsp;&nbsp;#bl
	  		</td>
	  		<td align="right">
	  			#br&nbsp;&nbsp;
	  		</td>
	  	</tr>
	  </table>
		<br/>
	</div>
	');
	define('LEFT_BUTTON','#bl');
	define('RIGHT_BUTTON','#br');

	require_once(DIR_FS_INCLUDES.'classes/boxes.php');
	require_once(DIR_FS_INCLUDES.'classes/message_stack.php');
	require_once(DIR_FS_INCLUDES.'filenames.php');
	require_once(DIR_FS_INC.'xtc_image.inc.php');
	require_once(DIR_FS_INC.'xtc_image_submit.inc.php');
	require_once(DIR_FS_INC . 'xtc_href_link.inc.php');
	//	W. Kaiser - Allow table-prefix

	// set the language
	$german='german';
	$language_post=$_POST['LANGUAGE'];
	$language_get=$_GET['language'];
	if ($language_post || $language_get)
	{
		if ($language_post)
		{
			$language=$language_post;
		}
		else
		{
			$language=$language_get;
		}
	}
	else
	{
		$browser_languages = explode(COMMA, getenv('HTTP_ACCEPT_LANGUAGE'));
		$language="english";
		for ($l=0;$l<sizeof($browser_languages);$l++)
		{
			if (strpos($browser_languages[$l],'de')!==false)
			{
				$language=$german;
				break;
			}
		}
	}
	if (!$language)
	{
		$language=$german;
	}
	$_SESSION['language']=$language;
	define('SESSION_LANGUAGE',$language);
	define('DIR_WS_IMAGES','images/');
	define('DIR_WS_ICONS',DIR_WS_IMAGES.'icons/');
	define('STEPS_DIR',DIR_WS_IMAGES.SESSION_LANGUAGE.SLASH);
	define('BUTTONS_DIR',STEPS_DIR.'/button_');
	define('CURRENT_TEMPLATE_BUTTONS',EMPTY_STRING);
	if (SESSION_LANGUAGE)
	{
		include('language/'.SESSION_LANGUAGE.PHP);
		include(ADMIN_PATH_PREFIX.'lang'.SLASH.SESSION_LANGUAGE.SLASH.SESSION_LANGUAGE.PHP);
	}
	$messageStack = new messageStack();
	$bullet_image=
	xtc_image(DIR_WS_ICONS.'bullet.gif',EMPTY_STRING,EMPTY_STRING,EMPTY_STRING,'align="top"').HTML_NBSP;
	$navigation_line='
			          	<tr>
			          		<td align="left" valign="top" style="font-size:8pt;width:30px">
			          			'.$bullet_image.'&nbsp;
			          		</td>
			          		<td valign="top" style="font-size:8pt">
			          			#
			          		</td>
			          		<td valign="top" align="right" style="width:30px">@</td>
			          	</tr>
			          	<tr><td style="height:4px"></td></tr>
';
	$navigation_text=array(
	EMPTY_STRING,
	BOX_LANGUAGE,
	BOX_DB_CONNECTION,
	BOX_DB_IMPORT,
	BOX_DB_IMPORT_SUCCESS,
	BOX_SHOP_CONFIG,
	BOX_USERS_CONFIG,
	BOX_FINISHED
	);
	$ok_image=xtc_image(DIR_WS_ICONS.'ok.gif');
	$x_image=xtc_image(DIR_WS_ICONS.'x.gif');
	$error_image=HTML_NBSP.HTML_NBSP.xtc_image(DIR_WS_ICONS.'error.gif').HTML_NBSP;
	$back_button_submit=BUTTONS_DIR.'continue.gif';
	$s=$navigation_text[$n_step];
	if (!$s)
	{
		$s=$navigation_text[$n_step+1];
	}
	$s=QUOTE.$s.QUOTE;
	$continue_button_link=xtc_image($back_button_submit,$s);
	$onsubmit_text='#onsubmit#';
	$continue_button_submit=
	xtc_image_submit($back_button_submit,BUTTON_CONTINUE_TEXT.$s,$onsubmit_text);
	$s=$navigation_text[$p_step];
	if (!$s)
	{
		$s=$navigation_text[$p_step-1];
	}
	$s=QUOTE.$s.QUOTE;
	$back_button_submit=
	xtc_image_submit(BUTTONS_DIR.'back.gif',BUTTON_BACK_TEXT.$s);
	$retry_button_submit=
	xtc_image_submit(BUTTONS_DIR.'retry.gif',BUTTON_RETRY_TEXT.QUOTE.$navigation_text[$install_step].QUOTE);
	$install_text='install';
	$install_step_text=$install_text.'_step';
	$step_text='step';
	if ($install_step>1)
	{
		/*
		if (!$_SESSION[$step_text][$p_step])	//Previous step not done!
		{
			install_error(TEXT_STEP_ERROR);
			$post_data.='
		<tr>
	    <td class="error">'.TEXT_STEP_ERROR_1.'</td>
		</tr>
	';
			include('includes/program_frame.php');
		}
		*/
		$install_action_text=$install_text.'_action';
		$process_text='process';
		$process =$_POST[$install_action_text] == $process_text;
		while (list($key, $value) = each($_GET))
		{
			$_POST[$key]=$value;		//Store GET-Data in POST!
		}
		while (list($key, $value) = each($_SESSION))
		{
			if ($key<>$install_action_text)
			{
				if (!isset($_POST[$key]))
				{
					$_POST[$key]=$value;		//Store SESSION-Data in POST!
				}
			}
		}
		$brackets='[]';
		$start_debug_text='start_debug';
		$start_debug_text_1='DBGSESSION';
		$x_text='x';
		$y_text='y';
		$array_id=UNDERSCORE.'a'.UNDERSCORE;
		reset($_POST);
		$hidden_fields=array();
		while (list($key, $value) = each($_POST))
		{
			if ($key==$start_debug_text || $key==$start_debug_text_1)
			{
				break;			//Do not include Zend debugger parameters
			}

			elseif ($key != $x_text)
			{
				if ($key != $y_text)
				{
					if (is_array($value))
					{
						for ($i=0,$n=sizeof($value); $i<$n; $i++)
						{
							$current_value=urlencode($value[$i]);
							$hidden_fields[$key.$array_id.$i]=$current_value;
						}
					}
					else
					{
						$hidden_fields[$key]=$value;
					}
					$_SESSION[$key]=$value;		//Store POST-Data in Session!
				}
			}
		}
		unset($hidden_fields[$install_action_text]);

		$cancel_button=HTML_A_START.xtc_href_link($install_step_text.$p_step.PHP,$parameters).'">'.
		xtc_image(BUTTONS_DIR.'back.gif',BUTTON_BACK_TEXT.$s).HTML_A_END;
	}
	else
	{
		$cancel_button=EMPTY_STRING;
	}
	$db = array();
	$database=trim(stripslashes($_POST[$db_database_text]));
	$db[$db_server_text] = trim(stripslashes($_POST[$db_server_text]));
	$db[$db_username_text] = trim(stripslashes($_POST[$db_username_text]));
	$db[$db_password_text] = trim(stripslashes($_POST[$db_password_text]));
	$db[$db_database_text] = $database;
}

if ($install_step>=4)
{
	define($db_database_text,$database);
	include(DIR_FS_INCLUDES.'database_tables.php');
	if ($install_step>=5)
	{
		$configure_php='configure.php';
		if ($install_step<>5)
		{
			$level=ADMIN_PATH_PREFIX;
			require(DIR_FS_INCLUDES.$configure_php);
		}
		if ($install_step<=6)
		{
			$post_data.='<tr><td>'.xtc_draw_hidden_field_installer($install_action_text,$process_text).'</td></tr>';
			require_once(DIR_FS_INC . 'xtc_rand.inc.php');
			require_once(DIR_FS_INC . 'xtc_encrypt_password.inc.php');
			require_once(DIR_FS_INC . 'xtc_validate_email.inc.php');
			require_once(DIR_FS_INC . 'xtc_get_countries.inc.php');
			require_once(DIR_FS_INC . 'xtc_draw_pull_down_menu.inc.php');
			require_once(DIR_FS_INC . 'xtc_draw_input_field_installer.inc.php');
			require_once(DIR_FS_INC . 'xtc_get_country_list.inc.php');
			define($db_server_text,$_POST[$db_server_text]);
			define($db_username_text,$_POST[$db_username_text]);
			define($db_password_text,$_POST[$db_password_text]);
			// connect do database
			$db_error = false;
			xtc_db_connect();
			if (!$db_error)
			{
				xtc_db_test_connection(DB_DATABASE);
			}
			// get configuration data
			$configuration_query =
			xtc_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
			while ($configuration = xtc_db_fetch_array($configuration_query))
			{
				define($configuration['cfgKey'], $configuration['cfgValue']);
			}
		}
	}
}
$is_last_step=$install_step==7;
$show_all=$install_step==4 || $is_last_step;
$navigation_step=array();
for ($i=0;$i<=$install_step;$i++)
{
	$s=$navigation_text[$i];
	if ($s)
	{
		$s=str_replace(HASH,$s,$navigation_line);
		if ($i<$install_step || $show_all)
		{
			$s1=$ok_image;
		}
		else
		{
			$s1=EMPTY_STRING;
		}
		$navigation_step[]=str_replace(ATSIGN,$s1,$s);
	}
}
$total_navigation_steps=sizeof($navigation_step)-1;
$display_navigation_steps=$total_navigation_steps;
$main_content=constant('TEXT_WELCOME_STEP'.$install_step).HTML_BR;
$button_box0=str_replace(LEFT_BUTTON,$cancel_button,BUTTON_BOX);
$button_box=str_replace(RIGHT_BUTTON,$continue_button_submit,$button_box0);
$action_step=$n_step.PHP;
$next_step_link=xtc_href_link($install_step_text.$n_step.PHP, EMPTY_STRING, NONSSL);

function install_error($error_text,$button_submit=EMPTY_STRING)
{
	global $action_step,$install_step,$display_navigation_steps,$button_box,$hidden_fields;
	global $error_top,$post_data,$error_image,$back_button_submit;

	$button_box=str_replace(LEFT_BUTTON,EMPTY_STRING,BUTTON_BOX);
	if ($button_submit)
	{
		$action_step=$install_step;
	}
	else
	{
		$action_step=$p_step;
		$display_navigation_steps--;
		$button_submit=$back_button_submit;
	}
	$action_step.=PHP;
	$button_box=str_replace(RIGHT_BUTTON,$button_submit,$button_box);
	$button_box.=$hidden_fields;
	$error_top=$error_text;
	$post_data.='
  <tr>
    <td>
    	<table border="0" style="text-align:left;width:100%" cellpadding="0" cellspacing="0">
    		<tr>
			    <td class="header" valign="top" style="width:45px">'.$error_image.'</td>
			    <td class="header">'.$error_text.'</td>
    		</tr>
			</table>
    </td>
  </tr>
';
}

function ActivateProg($url)
{
	xtc_redirect(xtc_href_link($url));
}

function get_check_input($field_name,$min_length,$error_message)
{
	global $error,$messageStack,$install_step;

	$field=xtc_db_prepare_input($_POST[$field_name]);
	if (strlen($field) < $min_length)
	{
		$error = true;
		$messageStack->add($install_step, $error_message);
	}
	else
	{
		return $field;
	}
}

function xtc_check_version($mini='4.3.0')
{
	sscanf($mini,"%d.%d.%d",$m1,$m2,$m3);
	sscanf(phpversion(),"%d.%d.%d",$v1,$v2,$v3);

	if($v1>=$m1)
	{
		if($v2>=$m2)
		{
			if($v3>=$m3)
			{
				return true;
			}
		}
	}
}
?>