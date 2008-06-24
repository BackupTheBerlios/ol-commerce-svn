<?php
/* --------------------------------------------------------------
$Id: install_step7.php,v 1.1.1.1.2.1 2007/04/08 07:18:31 gswkaiser Exp $

OL-Commerce Version 2.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (install_finished.php,v 1.5 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
(c) 2004  		OL - Commerce; www.ol-Commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

function make_seed()
{
	list($usec, $sec) = explode(BLANK, microtime());
	return (float) $sec + ((float) $usec * 100000);
}

define('ADMIN_PATH_PREFIX','../');
$level=ADMIN_PATH_PREFIX;
require(ADMIN_PATH_PREFIX.'includes/configure.php');
require('includes/application.php');

$data_link=HTML_A_START.
xtc_href_link('http://www.seifenparadies.de/ajax/downloads/xtc_test_daten.zip').'
" target="_blank">'.TEXT_TESTDATA_LOAD.HTML_A_END;
$file=ADMIN_PATH_PREFIX.'elmar_start.php';
if (file_exists($file))
{
	$elmar_link=HTML_A_START.xtc_href_link($file.QUESTION.'file=index.php').'" target="_blank">';
	$elmar=true;
}
$file=ADMIN_PATH_PREFIX.'chCounter/install/install.php';
if (file_exists($file))
{
	$chcounter_link=HTML_A_START.xtc_href_link($file).'" target="_blank">'.
	TEXT_CHCOUNTER_INSTALL.HTML_A_END;
	$chcounter=true;
}
$file="livehelp_install.php";
if (false and file_exists($file))
{
	$livehelp_link=HTML_BR.HTML_BR.HTML_A_START.xtc_href_link($file).'" target="_blank">'.TEXT_LIVEHELP_INSTALL.HTML_A_END;
	$livehelp=true;
}
/*
$install_dir_orig=dirname($_SERVER['SCRIPT_NAME']);
$install_dir_orig=explode(SLASH,$install_dir_orig);
$install_dir_orig=$install_dir_orig[sizeof($install_dir_orig)-1];
$add_ons=strpos($install_dir_orig,UNDERSCORE,4);
if ($add_ons)
{
$new_install_dir=substr($install_dir_orig,0,$add_ons);
}
else
{
$new_install_dir=$install_dir_orig;
}
//srand(make_seed());
$new_install_dir=$new_install_dir.UNDERSCORE.(10000000+rand()*89999999);
$rename_directory=rename(ADMIN_PATH_PREFIX.$install_dir_orig,ADMIN_PATH_PREFIX.$new_install_dir);
*/
if ($rename_directory)
{
	$dir_text=sprintf(TEXT_RENAMED_DIR,$install_dir_orig,$new_install_dir);
	$rename_directory=rename(ADMIN_PATH_PREFIX.$new_install_dir,ADMIN_PATH_PREFIX.$install_dir_orig);
}
else
{
	$dir_text=TEXT_RENAME_DIR;
}
$add_ons=$elmar || $chcounter || $livehelp;
$post_data.='
  <tr>
    <td align="left">
			<table class="main_content_outer" cellspacing="0" cellpadding="0">
			  <tr>
			    <td class="header_image"></td>
			    <td class="header">'.TEXT_SHOP_CONFIG_SUCCESS.'</td>
			  </tr>
			</table>
	    <br/><font size="1">'.TEXT_TEAM.'</font><br/><br/>
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left">
          	<b><font size="1" color="Red">'.$dir_text.HTML_BR.HTML_BR.'</font></b>
          </td>
        </tr>
';  
/*      
$is_installation=true;
include(ADMIN_PATH_PREFIX.'admin/includes/modules/security_check.php');
if ($error_flag)
{
	$post_data.='
';
}
*/
$post_data.='
			  <tr>
			    <td align="left">
						<table class="main_content_outer" cellspacing="0" cellpadding="0">
						  <tr>
						    <td class="header_image"></td>
						    <td class="header">'.TEXT_TEST_DATA.'</td>
						  </tr>
						</table>
          </td>
			  </tr>
        <tr>
		      <td align="left">'.HTML_BR.TEXT_TESTDATA_EXPLAIN.HTML_BR.HTML_BR.$data_link.HTML_BR.HTML_BR.'
					</td>
				</tr>
';
if ($add_ons)
{
	$post_data.='
			  <tr>
			    <td align="left">
						<table class="main_content_outer" cellspacing="0" cellpadding="0">
						  <tr>
						    <td class="header_image"></td>
						    <td class="header">'.TEXT_ADD_ON_MODULES.'</td>
						  </tr>
						</table>
          </td>
			  </tr>
        <tr>
		      <td align="left">'.TEXT_ADD_ONS;
	if ($elmar)
	{
		$post_data.=HTML_BR.HTML_BR.
		$elmar_link.xtc_image(ADMIN_PATH_PREFIX.'images/elmar-logo-100x50.gif',TEXT_ELMAR_INSTALL).HTML_A_END.
		HTML_NBSP.$elmar_link.TEXT_ELMAR_INSTALL.HTML_A_END;
	}
	if ($chcounter)
	{
		$post_data.=HTML_BR.HTML_BR.$chcounter_link;
	}
	if ($livehelp)
	{
		$post_data.=HTML_BR.HTML_BR.HTML_BR.$livehelp_link;
	}
	$post_data.='
					</td>
				</tr>
';
}
if ($error_flag)
{
	install_error(ERROR_CORRECT_PROBLEMS,$retry_button_submit);
}
else
{
	$post_data.='
			  <tr>
			    <td align="left"><br/></td></tr>
			  <tr>
			    <td align="left">
						<table class="main_content_outer" cellspacing="0" cellpadding="0">
						  <tr>
						    <td class="header_image"></td>
						    <td class="header">'.TEXT_START_SHOP.'</td>
						  </tr>
						</table>
          </td>
			  </tr>
        <tr>
          <td align="center" style="color:red">
          	<p><br/><b>'.TEXT_START_SHOP_WARNING.'</b><br/><br/></p>
          </td>
        </tr>
        <tr>
          <td align="center"><p><br/><b>'.BUTTON_START_SHOP_TEXT.'</b><br/><br/></p></td>
        </tr>
        <tr>
          <td align="center">'.
	HTML_A_START.xtc_href_link(ADMIN_PATH_PREFIX.'index.php').'" target="_blank">'.
	xtc_image(BUTTONS_DIR.'shop.gif',BUTTON_START_SHOP_TEXT).HTML_A_END.'
					</td>
        </tr>

        <tr>
          <td align="center"><p><br/><b>'.BUTTON_START_ADMIN_TEXT.'</b><br/><br/></p></td>
        </tr>
        <tr>
          <td align="center">'.
	HTML_A_START.xtc_href_link(ADMIN_PATH_PREFIX.'admin/start.php').'" target="_blank">'.
	xtc_image(BUTTONS_DIR.'admin.gif',BUTTON_START_ADMIN_TEXT).HTML_A_END.'
					</td>
        </tr>
			</table>
		</td>
	</tr>
';
}
include('includes/program_frame.php');
?>
