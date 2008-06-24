<?php
/* --------------------------------------------------------------
$Id: install_step1.php,v 1.1.1.1.2.1 2007/04/08 07:18:30 gswkaiser Exp $

OL-Commerce Version 2.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (index.php,v 1.18 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
(c) 2004  		OL - Commerce; www.ol-Commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

function xtc_session_close()
{
}

define('HTTP_SERVER','');
define('HTTPS_SERVER','');
define('DIR_WS_CATALOG','');

require('includes/application.php');

// include needed functions
require_once(DIR_FS_INC.'xtc_image.inc.php');
require_once(DIR_FS_INC.'xtc_draw_separator.inc.php');

unset($_SESSION['TABLE_PREFIX']);
if ($process)
{
	$language=xtc_db_prepare_input($_POST['LANGUAGE']);
	$error = false;
	if ($language != 'german')
	{
		if ($language != 'english')
		{
			$error = true;
			$messageStack->add($install_step, SELECT_LANGUAGE_ERROR);
		}
	}
	$_SESSION['language'] = $language;
	if (!$error)
	{
		ActivateProg($next_step_link);
	}
}
// permission check to prevent DAU faults.
$error_flag=false;
$message=EMPTY_STRING;
// config files
$config='config.inc.php';
$includes='includes/configure';
$configure=$includes.'.php';
$configure_org=$includes.'.save.php';
$multi_shop_multi_db=$install_dir.'multi_shop_multi_db/';
$htaccess='.htaccess';
$file_names = array(
'chCounter/includes/'.$config,
'elmar/'.$config,
$configure,
$configure_org,
'livehelp/config.php',
$install_dir.'livehelp.sql.php',
$multi_shop_multi_db.$htaccess,
$multi_shop_multi_db.'configure.php',
$htaccess,
'elmar_'.$config
);
$files = sizeof($file_names);
$show_error_message=true;
$try_again=false;
for ($phase=1;$phase<=2;$phase++)
{
	for ($file = 0; $file < $files ; $file++)
	{
		$file_name = DIR_FS_CATALOG . $file_names[$file];
		if (file_exists($file_name))
		{
			$wrong_rights=!is_writeable($file_name);
			if (!$wrong_rights)
			{
				$wrong_rights=decoct(fileperms($file_name))<100666;
			}
		}
		else
		{
			$wrong_rights=true;
		}
		if ($wrong_rights)
		{
			$try_again=true;
			if ($phase==2)
			{
				if ($show_error_message)
				{
					$show_error_message=false;
					$error_flag=true;
					$message = str_replace(HASH,TEXT_FILES,ERROR_WRONG_PERMISSION);
				}
				$message .= str_replace(DIR_FS_CATALOG,EMPTY_STRING,$file_name) . HTML_BR;
			}
			else
			{
				if (!chmod($file_name,0777))
				{
					$file=$file;
				}
			}
		}
	}
	if (!$try_again)
	{
		break;
	}
}
$ok_message_tpl='
	<tr>
		<td align="left"><font size="1" color="White">#1</font></td>
		<td align="left"><font size="1" color="White"><b>#2</b></font><br/></td>
	</tr>
	<tr>
		<td colspan="2"><hr/></td>
	</tr>
';

$error_status_tpl='<font color="Blue">'.ICON_ERROR.'</font>';
if ($error_flag)
{
	$status=$error_status_tpl;
}
else
{
	$status='OK';
}
$message_line=str_replace('#1',FILE_ACCESS_RIGHTS,$ok_message_tpl);
$ok_message=str_replace('#2',$status,$message_line);

// smarty and image folders
$folder_flag==false;
$images='images/';
$images1=UNDERSCORE.$images;
$product_images=$images.'product'.$images1;
$templates_c='templates_c';
$file_names = array(
'cache',
'tmp',
'templates_c',
$images,
$images.'banner',
$images.'categories',
$images.'manufacturers',
$product_images.'info'.$images1,
$product_images.'original'.$images1,
$product_images.'popup'.$images1,
$product_images.'thumbnail'.$images1);

$files = sizeof($file_names);
$show_error_message=true;
for ($file = 0; $file < $files ; $file++)
{
	$file_name = DIR_FS_CATALOG . $file_names[$file];
	if (!is_writeable($file_name))
	{
		if ($show_error_message)
		{
			$show_error_message=false;
			$error_flag=true;
			$message .= str_replace(HASH,TEXT_DIRECTORIES,ERROR_WRONG_PERMISSION);
		}
		$folder_flag==false;
		$message .= str_replace(DIR_FS_CATALOG,EMPTY_STRING,$file_name) . HTML_BR;
	}
}

if ($folder_flag)
{
	$status=$error_status_tpl;
}
else
{
	$status='OK';
}
$message_line=str_replace('#1',TEXT_DIRECTORIES_ACCESS_RIGHTS,$ok_message_tpl);
$ok_message.=str_replace('#2',$status,$message_line);;

// check PHP-Version
if (xtc_check_version()!=1)
{
	$error_flag=true;
	$php_flag=true;
	$status=$error_status_tpl;
	$status.=$error_status_tpl.str_replace(HASH,phpversion(),ERROR_ILLEGAL_PHP_VERSION);
}
else
{
	$status='OK';
}
$message_line=str_replace('#1','PHP Version',$ok_message_tpl);
$ok_message.=str_replace('#2',$status,$message_line);;

$gd=gd_info();

$status=$gd['GD Version'];
if ($status==EMPTY_STRING)
{
	$status=$error_status_tpl.ERROR_NO_GDLIB;
}
// display GDlibversion
$message_line=str_replace('#1','GDlib Version',$ok_message_tpl);
$ok_message.=str_replace('#2',$status,$message_line);;

if ($gd['GIF Read Support']==1 or $gd['GIF Support']==1) {
	$status='OK';
} else {
	$status=$error_status_tpl.ERROR_NO_GIF_SUPPORT;
}
$message_line=str_replace('#1',GDLIB_SUPPORT,$ok_message_tpl);
$ok_message.=str_replace('#2',$status,$message_line);

$post_data.='
  <tr>
    <td>
			<table class="main_content_outer" cellspacing="0" cellpadding="0">
			  <tr>
			    <td class="header_image"></td>
			    <td class="header">'.TEXT_TESTS.'</td>
			  </tr>
			</table>
			<table class="main_content" cellspacing="0" cellpadding="0" style="width:100%">
';
if ($error_flag)
{
	$post_data.='
			  <tr>
			    <td colspan="2" align="left" style="background-color: #FE8400">
						<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<td colspan="2" align="left">
									<br/><font size="1" color="White"><b><font color="Blue">'.TEXT_ATTENTION.'</font></b>'.$message.'</font>
								</td>
							</tr>
						</table>
			  	</td>
				</tr>
';
}
if ($ok_message)
{
	$post_data.='
			  <tr>
			    <td colspan="2" class="highlite_background">
';
	if ($error_flag)
	{
		$post_data.='
						<br/><hr/><br/>
';
	}
	$post_data.='
						<table class="main_content" style="width:100%">
							'.$ok_message.'
						</table>
					</td>
				</tr>
';
}
$post_data.='
			</table>
		</td>
	</tr>
';
if ($error_flag)
{
	install_error(ERROR_CORRECT_PROBLEMS,$retry_button_submit);
}
else
{
	$post_data.='
	<tr>
		<td>
			<table align="center" border="0" cellpadding="0" cellspacing="4" style="width: 100%">
				<tr>
					<td>
						<table align="left" border="0" cellpadding="0" cellspacing="4">
					  	<tr>
								<td colspan="2"><br/></td>
								<td align="left" valign="top">
									'.xtc_image(DIR_WS_ICONS.'bullet_2.gif').'
								</td>
								<td align="left" class="big_text" valign="top">
									'.TITLE_SELECT_LANGUAGE.'
								</td>
							</tr>
						</table>
						</td>
				</tr>
				<tr>
					<td>
						<table align="left" border="0" cellpadding="0" cellspacing="4">
					  	<tr>
								<td align="left">
									'.$bullet_image.'<font size="1">'.TEXT_GERMAN.'</font>
								</td>
								<td align="left">
									'.xtc_image(DIR_WS_ICONS.'icon-deu.gif').
	xtc_draw_radio_field_installer('LANGUAGE', $german, $language==$german).'
								</td>
							</tr>
					  	<tr>
								<td align="left">
									'.$bullet_image.'<font size="1">'.TEXT_ENGLISH.'</font>
								</td>
								<td align="left">
									'.xtc_image(DIR_WS_ICONS.'icon-eng.gif').
	xtc_draw_radio_field_installer('LANGUAGE', 'english', $language!=$german).'
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
';
}
include('includes/program_frame.php');
?>
