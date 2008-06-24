<?php
//W. Kaiser - AJAX
if (ENABLE_SSL && getenv(HTTPS) != null)
{
	$server = HTTPS_SERVER;
}
else
{
	$server = HTTP_SERVER;
}
if (NOT_USE_AJAX)
{
	if (USE_CSS_DYNAMIC_ADMIN_MENU)
	{
		$header ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$_SESSION['language_code'].'">';
	}
	else
	{
		$header =
'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"';
		if (IS_IE)
		{
			$pos=strpos($my_user_agent,'msie');
			if ($pos!==false)
			{
				$add_loose=(int)substr($my_user_agent,$pos+5)<=6;		//Check IE version and
			}
		}
		else
		{
			$add_loose=true;
		}
		if ($add_loose)
		{
			$header .=
			' "http://www.w3.org/TR/html4/loose.dtd"';
		}
		$header.='>
<html '. HTML_PARAMS . '>';
	}
$header.='
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=' . $_SESSION['language_charset'] . '" />
	<title>' . TITLE . '</title>
	<link rel="stylesheet" type="text/css" href="'.CURRENT_TEMPLATE_ADMIN.'stylesheet.css" />
	<style type="text/css">
	.frame_left {
	  background-image: url("../templates/admin/images/bg_image.gif");
	  background-repeat: repeat-x;
	  text-align: left;
	}

	.frame_right {
	  background-image: url("../templates/admin/images/bg_image.gif");
	  background-repeat: repeat-x;
	  text-align: right;
	}
	</style>

	<script language="javascript" type="text/javascript" src="includes/general.js"></script>
';
	if ($load_spaw)
	{
		if (NOT_USE_AJAX)
		{
			include(ADMIN_PATH_PREFIX.DIR_WS_INCLUDES.'convert_html_entities.js.php');
			$header.='
<script language="javascript" type="text/javascript"><!--

		'.$script.'
--></script>
';
		}
	}
	if ($header_addon)
	{
		$header.=$header_addon;
	}
	if ($is_periodic && (!$is_auction || $get_categories))
	{
		include(DIR_WS_INCLUDES.'ajax_periodic.js.php');
		$header.=$script;
	}
	if (USE_AJAX_ATTRIBUTES_MANAGER)
	{
		if (CURRENT_SCRIPT==FILENAME_CATEGORIES)
		{
			if ($realproduct_processing)
			{
				/*
				$script=EMPTY_STRING;
				require_once(ADMIN_PATH_PREFIX.DIR_WS_INCLUDES.'ajax.js.php');
				$header .=	$script;
				*/
				$script=EMPTY_STRING;
				require_once(AJAX_ATTRIBUTES_MANAGER_LEADIN.'header.inc.php');
				$header .=	$script;
			}
		}
	}
	echo $header;
	$script=EMPTY_STRING;
}
//W. Kaiser - AJAX
?>