<?php
/* --------------------------------------------------------------
$Id: header.php,v 1.1.1.1 2006/12/22 13:49:04 gswkaiser Exp $

OL-Commerce Version 2.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2004  		XT - Commerce; www.xt-ommerce.de

Released under the GNU General Public License
--------------------------------------------------------------*/
// W. Kaiser - AJAX
$script=EMPTY_STRING;
$is_step3=$install_step==3;
if ($is_step3 || USE_AJAX)
{
	if (NOT_IS_AJAX_PROCESSING)
	{
		$script.='<script src="includes/progressbar.js.php" type="text/javascript"></script>';

		//require('includes/progressbar.js.php');
	}
}
if ($include_form_check || USE_AJAX)
{
	if (NOT_IS_AJAX_PROCESSING)
	{
		include('../lang/'.SESSION_LANGUAGE.SLASH.SESSION_LANGUAGE.PHP);
		require('includes/form_check.js.php');
		if (USE_AJAX)
		{
			//include AJAX script!!!!
		}
	}
	if ($include_form_check)
	{
		$onsubmit=' onsubmit="return check_form(\'install\');"';
		$action_step=$install_step.PHP;
	}
}
if ($error_message)
{
	$error_message='
	<div class="error"><br>'.$error_message.'<br></div>';
}
if ($error_top)
{
	$error_top_style='inline';
}
else
{
	$error_top_style='none';
}
if ($display_navigation_steps<$total_navigation_steps)
{
	$navigation_step[$display_navigation_steps]=str_replace($ok_image,$x_image,$navigation_step[$display_navigation_steps]);
}
else
{
	$_SESSION[$step_text][$install_step]=true;
}
$navigation=EMPTY_STRING;
for ($i=0;$i<=$display_navigation_steps;$i++)
{
	$navigation.=$navigation_step[$i];
}
$post_data.='
</table>
';
if ($is_last_step)
{
	$button_box=EMPTY_STRING;
}
else
{
	if ($submit_onclick)
	{
		$s=$submit_onclick;
	}
	else
	{
		$s=EMPTY_STRING;
	}
	$button_box=HTML_BR.str_replace($onsubmit_text,$s,$button_box);
	if ($messageStack->size($install_step) > 0)
	{
		$post_data='
	<table border="0" cellpadding="3" cellspacing="3">
		<tr>
			<td>'.$messageStack->output($install_step).'</td>
		</tr>
	</table>
	<br/><hr/><br/>
	'.
		$post_data;
	}
	$hidden_fields_text=EMPTY_STRING;
	if (is_array($hidden_fields))
	{
		$brackets='[]';
		reset($hidden_fields);
		while (list($key, $value)=each($hidden_fields))
		{
			$s=strpos($key,$array_id);
			if ($s!==false)
			{
				$key=substr($key,0,$s).$brackets;
			}
			$s=xtc_draw_hidden_field_installer($key, $value);
			if (strpos($hidden_fields_text,$s)===false)
			{
				$hidden_fields_text.=NEW_LINE.$s;
			}
		}
		$hidden_fields_text=$hidden_fields_text.NEW_LINE;
	}
}
$main_content.='
<table class="main_content_outer">
  <tr>
    <td>
    	'.xtc_draw_form($install_text,$install_step_text.$action_step,EMPTY_STRING,$onsubmit).
				$hidden_fields_text.
				$post_data.'
				<table border="0" width="100%" cellspacing="0" cellpadding="0">
				  <tr>
				    <td align="center">
				    	'.$button_box.'
				    </td>
				  </tr>
				</table>
			</form>
		</td>
	</tr>
</table>
';
$template_file='template.html';
$user_area_template_file='user_area_'.$template_file;
$html=file_get_contents($template_file);
$user_area=file_get_contents($user_area_template_file);
$step_image=xtc_image(STEPS_DIR.'step'.$install_step.'.gif',INSTALLATION_STEP_TEXT.$install_step);
$user_area=str_replace('{$ERROR_TOP_STYLE}',$error_top_style,$user_area);
$user_area=str_replace('{$STEP_IMAGE}',$step_image,$user_area);
$user_area=str_replace('{$MAIN_CONTENT}',$main_content,$user_area);
$user_area=str_replace('{$NAVIGATION}',$navigation,$user_area);
$user_area=str_replace('{$ERROR_TOP}',$error_top,$user_area);
$user_area=str_replace('{$ERROR_MESSAGE}',$error_message,$user_area);
if (IS_AJAX_PROCESSING)
{
	$html=$user_area;
}
else
{
	if ($rename_directory)
	{
		$base='<base href="'.HTTP_SERVER.DIR_WS_CATALOG.$new_install_dir.'"/>';

	}
	else
	{
		$base=EMPTY_STRING;
	}
	$html=str_replace('{$AJAX_LOGO_TITLE}',AJAX_LOGO_TITLE,$html);
	$html=str_replace('{$AJAX_LOGO_LINK}',AJAX_LOGO_LINK,$html);
	$html=str_replace('{$SCRIPT}',$script,$html);
	$html=str_replace('{$BASE}',$base,$html);
	$html=str_replace('{$STEP_TEXT}',STEP_TEXT,$html);
	$html=str_replace('{$STEP}',$install_step,$html);
	$html=str_replace('{$USER_AREA}',$user_area,$html);
	$html=str_replace('{$FOOTER}',TEXT_FOOTER,$html);
}
echo $html;
if ($rename_directory)
{
	$directory=ADMIN_PATH_PREFIX.$new_install_dir;
	$rename_directory=rename(ADMIN_PATH_PREFIX.$install_dir_orig,$directory);

}
session_write_close();
?>