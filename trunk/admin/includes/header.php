<?php
/* --------------------------------------------------------------
$Id: header.php,v 1.1.1.1.2.1 2007/04/08 07:16:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(header.php,v 1.19 2002/04/13); www.oscommerce.com
(c) 2003	    nextcommerce (header.php,v 1.17 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
*/
if ($messageStack->size > 0)
{
	$message_text = $messageStack->output();
}
else
{
	$message_text = EMPTY_STRING;
}
$messageStack_text='session_messageStack';
if (isset($_SESSION[$messageStack_text]))
{
	$message_text.=$_SESSION[$messageStack_text];
	unset($_SESSION[$messageStack_text]);
}
$header_text='header';
if ($_SESSION[$header_text])
{
	unset($_SESSION[$header_text]);
	if ($message_text)
	{
		define('MESSAGE_TEXT',$message_text);
		if (NOT_USE_AJAX)
		{
		$message_text =	'
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		' . $message_text . '
		</td>
  </tr>
</table>
';
			echo $message_text;
		}
	}
}
else
{
	$_SESSION[$header_text]=true;
	// W. Kaiser BOF: Down for Maintenance
	include(DIR_FS_INC . FILENAME_DOWN_FOR_MAINTENANCE);
	// W. Kaiser BOF: Down 	for Maintenance
	if (USE_SMARTY)
	{
		if (USE_AJAX)
		{
			if (IS_AJAX_PROCESSING)
			{
				/*
				if ($realproduct_processing)
				{
				if (USE_AJAX_ATTRIBUTES_MANAGER)
				{
				require_once(AJAX_ATTRIBUTES_MANAGER_LEADIN.'header.inc.php');
				}
				}
				*/
			}
			else
			{
				$script=EMPTY_STRING;
				include(ADMIN_PATH_PREFIX.DIR_WS_INCLUDES . "ajax.js.php");
				$smarty->assign('AJAX_JS',$script);
				//Hidden iFrame for file-uploads in an AJAX environment!!!!
				$div_field.='
	 <iframe id="iframe_upload" src="" style="display:none"></iframe>';
			}
		}
		define('MESSAGE_TEXT',$message_text);
		$smarty->assign('box_TOP_DIV',$div_field);
		ob_start();				//Start output buffering
		return;
	}
	else
	{
		$display_text = '
<!-- header row bof //-->
'.$div_field;
		$template_dir=ADMIN_PATH_PREFIX.FULL_CURRENT_TEMPLATE.'admin'.SLASH;
		$file=$template_dir.'header'.HTML_EXT;
		$use_new_header=is_file($file);
		if ($use_new_header)
		{
			$new_header=file_get_contents($file);
			$new_header=str_replace('{$tpl_path}',$template_dir,$new_header);
			$display_text .=$new_header;
		}
		else
		{
			$spacer=olc_image(DIR_WS_IMAGES . "img_spacer.gif", EMPTY_STRING, EMPTY_STRING, EMPTY_STRING);
			define(A_END_SPACER, HTML_A_END . $spacer);
			define(CLASS_HEADERLINK, '" class="headerLink">');
			$display_text .= '
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td class="navLeft">' . olc_image($template_dir."logo.gif", "OL-Commerce",
			EMPTY_STRING, EMPTY_STRING) . '</td>
	    <td valign="bottom" align="right" >';
			if ($is_periodic)
			{
				if (CURRENT_SCRIPT==FILENAME_WHOS_ONLINE_LIVE)
				{
					$link=olc_href_link(CURRENT_SCRIPT,'ajax=true&p=t&i=t', NONSSL);
					$link="javascript:make_AJAX_Request('".$link . "',false,'','')";
					$display_text .=
					HTML_A_START . $link . CLASS_HEADERLINK.
					olc_image(ADMIN_PATH_PREFIX.CURRENT_TEMPLATE_BUTTONS . 'button_update.gif',
					EMPTY_STRING, EMPTY_STRING, EMPTY_STRING) . A_END_SPACER;
				}
			}
			else
			{
				$display_text .=
				HTML_A_START . olc_href_link(FILENAME_DEFAULT, EMPTY_STRING, NONSSL) . CLASS_HEADERLINK.
				olc_image($template_dir . 'top_index.gif', EMPTY_STRING, EMPTY_STRING, EMPTY_STRING) . A_END_SPACER .
				HTML_A_START . 'http://www.ol-commerce.de/modules/newbb/" target="_top' . CLASS_HEADERLINK .
				olc_image(DIR_WS_IMAGES . "top_support.gif", EMPTY_STRING, EMPTY_STRING, EMPTY_STRING) . A_END_SPACER;
				if (isset($_SESSION['ajax']))
				{
					$parameter='" onclick="javascript:self.close();return false;"';
				}
				$display_text .=
				HTML_A_START . olc_href_link(FILENAME_CUSTOMER_DEFAULT, EMPTY_STRING, NONSSL) . $parameter . CLASS_HEADERLINK.
				olc_image($template_dir . 'top_shop.gif', $multi_shop_parameter, EMPTY_STRING, EMPTY_STRING) . A_END_SPACER;
				if ($multi_shop_parameter)
				{
					$multi_shop_parameter=HTML_AMP.$multi_shop_parameter;
				}
				$display_text .
				HTML_A_START . olc_href_link(ADMIN_PATH_PREFIX.FILENAME_LOGOFF, 'admin_logoff=true'.$multi_shop_parameter, NONSSL) .
				$parameter . CLASS_HEADERLINK.
				olc_image($template_dir . 'top_logout.gif', EMPTY_STRING, EMPTY_STRING, EMPTY_STRING) . A_END_SPACER
				/*
				HTML_A_START . olc_href_link(FILENAME_CREDITS, $multi_shop_parameter, NONSSL) . CLASS_HEADERLINK.
				olc_image(DIR_WS_IMAGES . 'top_credits.gif', EMPTY_STRING, EMPTY_STRING, EMPTY_STRING) . A_END_SPACER.
				*/
				;
				$display_text.='
		</td>
  </tr>
';
			}
			$display_text .=	'
</table>
';
		}
			if ($message_text!=EMPTY_STRING)
			{
				$display_text .=	'
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		' . $message_text . '
		</td>
  </tr>
</table>
';
			}
		$display_text .= '
<!-- header row eof //-->
<!-- body bof //-->
';
		echo $display_text;
	}
	$div_field=EMPTY_STRING;
}
?>
