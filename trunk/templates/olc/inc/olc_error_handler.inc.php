<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_error_handler.inc.php,v 1.1.1.1 2006/12/23 11:21:03 gswkaiser Exp $

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

function my_error_handler($errno, $errstr, $errfile='', $errline='')
{
	if ($errno<>E_NOTICE )
	{
		$not_is_warning=$errno<>E_WARNING;
		$full_errors=$_SESSION[FULL_ERRORS];
		if ($not_is_warning or $full_errors)
		{
			$file_line_template='TEXT_ERROR_HANDLER_ERROR_TYPE';
			if (!defined($file_line_template))
			{
				define($file_line_template,'Error <b>#error_nr#<br/><font color="#FF0000">#error_text#</font></b><br/>');
				define('TEXT_ERROR_HANDLER_ERROR_FILE','File: <b><font color="#0000FF">#file#</font></b>, Line: <b>#line#</b><br/>');
			}
			$file_line_template='
			'.TEXT_ERROR_HANDLER_ERROR_FILE.'
';
			$error_template='
<table border="0">
	<tr>
		<td valign="top" nowrap="nowrap"><b><font size="2">#date# </b></font></td>
		<td valign="top">
			 <font size="2">'.TEXT_ERROR_HANDLER_ERROR_TYPE.'@</font>
		</td>
	</tr>
</table>
';
			if (!defined('DIR_FS_DOCUMENT_ROOT'))
			{
				define('PHP','.php');
				define('INC_PHP','.inc.php');
				include('includes/configure.php');
			}
			$error_text=str_replace('#date#',date('d-m-Y H:i:s'),$error_template);
			$error_text=str_replace('#error_nr#',$errno,$error_text);
			$back_slash='\\';
			$errstr = str_replace($back_slash,SLASH,$errstr);
			$errstr = str_replace(strtolower(DIR_FS_CATALOG),'...'.SLASH,$errstr);
			$error_text=str_replace('#error_text#',$errstr,$error_text);
			if ($errfile)
			{
				$errfile=str_replace(strtolower(DIR_FS_CATALOG),EMPTY_STRING,
				strtolower(str_replace($back_slash,SLASH,$errfile)));
				$file_line=str_replace('#file#',$errfile,$file_line_template);
				$file_line=str_replace('#line#',$errline,$file_line);
			}
			else
			{
				$file_line=EMPTY_STRING;
			}
			$error_text=str_replace(ATSIGN,$file_line,$error_text);
			if (defined('OL_COMMERCE'))
			{
				if (OL_COMMERCE)
				{
					include_once(DIR_FS_INC.'olc_backtrace.inc.php');
				}
			}
			$error_text.='<p>'.olc_backtrace().'</p>';
			$s='IS_AJAX_PROCESSING';
			if (!defined($s))
			{
				define($s,false);
			}
			if (IS_AJAX_PROCESSING===true)
			{
				global $smarty;
				if (!is_object($smarty))
				{
					//Include Smarty class
					require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES.'smarty/Smarty.class.php');
					require_once(DIR_FS_INC.'olc_smarty_init.inc.php');
					olc_smarty_init($smarty,$cacheid);
				}
				$_SESSION[DEBUG_OUPUT].=$error_text;
				if (trim($smarty->_tpl_vars[MAIN_CONTENT])==EMPTY_STRING)
				{
					$smarty->assign(MAIN_CONTENT,QUESTION);
				}
				if ($not_is_warning)
				{
					$smarty->display(INDEX_HTML);
				}
			}
			else
			{
				echo $error_text;
			}
			if ($not_is_warning)
			{
				exit();
			}
			else
			{
				return;
			}
		}
		if ($error_text)
		{
			if ($handle = fopen(ADMIN_PATH_PREFIX."cache/cache/".session_id().".log", "a"))
			{
				//$error_text=date('d-m-Y H:i:s').' Fehler '. $errno .COLON_BLANK. $errstr .', Datei: '.	$errfile.' -  Zeile: '.$errline;
				$error_text=str_replace(array('<br>','<br/>','<BR>','<BR/>'),"\r\n",$error_text);
				$error_text=strip_tags($error_text)."\r\n\r\n";
				@fwrite($handle, $error_text );
				@fclose($handle);
			}
		}//end if
	}
}//end function

if (defined('IS_LOCAL_HOST') && IS_LOCAL_HOST)
{
	// Active assert and make it quiet
	assert_options (ASSERT_ACTIVE, 1);
	assert_options (ASSERT_WARNING, 0);
	assert_options (ASSERT_QUIET_EVAL, 1);

	// Create a handler function
	function my_assert_handler ($file, $line, $code)
	{
		$assertion="
Assertion ist fehlgeschlagen:<br/><br/>
Datei '$file'<br/>
Zeile '$line'<br/>
Assertion '$code'<br/><br/>"
		;
		if (USE_AJAX)
		{
			$_SESSION[DEBUG_OUPUT].=$assertion;
		}
		else
		{
			$assertion=HTML_HR.$assertion.HTML_HR;
		}
		echo $assertion;
	}
	// Set up the callback
	assert_options (ASSERT_CALLBACK, 'my_assert_handler');
}
else
{
	// Deactive assert
	assert_options (ASSERT_ACTIVE, 0);
}
?>