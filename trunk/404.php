<?php
/* -----------------------------------------------------------------------------------------
$Id: 404.php,v 1.1.1.1.2.1 2007/04/08 07:16:02 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
(c) 2003	    nextcommerce (olc_image.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

oReleased under the GNU General Public License
---------------------------------------------------------------------------------------

Custom 404 error handler.

Create picture "on-the-fly" if product picture is not found!!!

*/

define('PHP','.php');
$request=$_SERVER['REQUEST_URI'];
$url_parts = parse_url($request);
$file_path=$url_parts['path'];
$doc_type=basename($file_path);
$f404=true;
if (substr($doc_type,0,4)=='seo-')
{
	//Brute force SEO-handling for Servers, which do not handle "mod_rewrites" (IIS most prominently).
	//Our SEO-URLs will cause "404"-errors, which we intercept here!

	//SEO-URL caused the error, so delegate processing to the SEO-processor!
	include('seo.php');
}
else
{
	include_once('inc/olc_define_global_constants.inc.php');
	$not_isset_picture=!isset($is_picture);
	if ($not_isset_picture)
	{
		//Bloody FireFox sometimes (for unknown reason) generates a request to "index.ph", so check for that
		$pos=strpos($doc_type,DOT);
		if ($pos!==false)
		{
			$template_path=substr($doc_type,$pos);
			if ($template_path=='.ph')
			{
				exit();
			}
		}
	}

	$connected=false;
	$prefix_only=true;

	$admin='admin/';
	$is_admin=strpos($request,$admin)!==false;
	if ($is_admin)
	{
		$is_admin='../';
	}
	else
	{
		$is_admin='';
	}
	define('ADMIN_PATH_PREFIX',$is_admin);

	$current_template_text='CURRENT_TEMPLATE';
	include('includes/configure.php');
	require_once(DIR_FS_INC.'olc_connect_and_get_config.inc.php');

	define('MULTI_DB_SERVER',false);
	define('HTM_EXT','.htm');
	$not_ignore=true;
	$is_multistore=defined('DIR_FS_MULTI_SHOP_TEXT');
	if (!$is_multistore)
	{
		$pos=strrpos($doc_type,DOT);
		if ($pos!==false)
		{
			{
				$ignore_doc_types=".css.js";
				$doc_type_1=substr($doc_type,$pos);
				if (strpos($ignore_doc_types,$doc_type_1)!==false)
				{
					$not_ignore=false;
				}
			}
		}
	}
	if ($not_ignore)
	{
		//Pictures requested??
		if ($not_isset_picture)
		{
			$is_picture=false;
			$pictures_dirs=array('/images/','/images/','/buttons/','/Icons/');
			for ($i=0,$n=sizeof($pictures_dirs);$i<$n;$i++)
			{
				if (strpos($file_path,$pictures_dirs[$i])!==false)
				{
					$is_picture=true;
					break;
				}
			}
		}
		if ($is_picture)
		{
			if ($is_multistore)
			{
				$try_picture=true;
			}
			else
			{
				olc_connect_and_get_config(array(4,16),ADMIN_PATH_PREFIX);
				$try_picture=DO_IMAGE_ON_THE_FLY;
			}
			if ($try_picture)
			{
				function echo_picture($picture_path)
				{
					if (file_exists($picture_path))
					{
						$pos=strrpos($picture_path,DOT);
						$img_type=substr($picture_path,$pos+1);
						// Create appropriate image header:
						header('Content-type: image/'.$img_type);
						header("Content-Length: ".filesize($picture_path));
						$picture_file=fopen($picture_path,"r");
						fpassthru($picture_file);
						fclose($picture_file);
						return true;
					}
				}

				if ($is_multistore)
				{
					$file_path=$document_root.str_replace(DIR_WS_MULTI_SHOP,DIR_WS_CATALOG,$file_path);
					$not_found=!echo_picture($file_path);
				}
				else
				{
					$not_found=true;
				}
				if ($not_found)
				{
					//
					define('NOT_IS_ADMIN_FUNCTION',true);
					define('ADMIN_PATH_PREFIX',EMPTY_STRING);
					define('USE_SEO',SEARCH_ENGINE_FRIENDLY_URLS == TRUE_STRING_L);
					require_once(DIR_FS_INC.'olc_not_null.inc.php');
					include(DIR_FS_INC.'olc_image.inc.php');
					$file_path_short=substr($file_path,$pos);
					olc_image($file_path_short);
					$not_found=!echo_picture($file_path_short);
				}
			}
			else
			{
				$not_found=true;
			}
		}
		else
		{
			// no pictures, standard not found
			$dt=PHP;
			$pos=strrpos($doc_type,PHP);
			if ($pos===false)
			{
				$dt=HTM_EXT;
				$pos=strrpos($doc_type,HTM_EXT);
			}
			if ($pos===false)
			{
				$not_found=true;
			}
			else
			{
				include(DIR_FS_INC.'olc_get_template.inc.php');
				$current_template=olc_get_template(true);
				if (!$current_template)
				{
					olc_connect_and_get_config(array(1),ADMIN_PATH_PREFIX);
					if (defined($current_template_text))
					{
						$current_template=CURRENT_TEMPLATE;
					}
				}
				if ($current_template)
				{
					$current_template.=SLASH;
				}
				$templates='templates'.SLASH;
				$template_path=DIR_WS_CATALOG.ADMIN_PATH_PREFIX.$templates.$current_template;
				$p_404=DIR_FS_DOCUMENT_ROOT.ADMIN_PATH_PREFIX.$templates.$current_template.'404.html';
				if (!is_file($p_404))
				{
					//$template_path=str_replace($current_template,'common'.SLASH,$template_path);
					$p_404=str_replace($current_template,''.SLASH,$p_404);
				}
				$html_file=@file_get_contents($p_404);
				if ($html_file)
				{
					$html_file=str_replace('{FILE}',$doc_type,$html_file);
					$html_file=str_replace('{TEMPLATE}',HTTP_SERVER.$template_path,$html_file);
					$html_file=str_replace('{PATH}',HTTP_SERVER.DIR_WS_CATALOG,$html_file);
					//HTTP_SERVER
					//Assume AJAX processing and prepare AJAX format.
					//But hide it in a comment, in case we are  n o t  doing AJAX!
					$main_content='main_content';
					$index_delimiter=HASH.'index'.HASH;
					$main_content_delimiter=HASH.$main_content.HASH;
					$html_file='<!-- '.$index_delimiter.'x '.$main_content.$index_delimiter.NEW_LINE.
					$main_content_delimiter.'-->'.NEW_LINE.$html_file.NEW_LINE.'<!-- '.$main_content_delimiter.'-->';
					echo $html_file;
				}
				else
				{
					$not_found=true;
				}
			}
		}
		if ($not_found)
		{
			if ($is_multistore)
			{
				$doc_type=MASTER_SHOP_DIRECTORY.$doc_type;
				switch ($dt)
				{
					case PHP:
						include($doc_type);
						break;
					case HTM_EXT:
						$html=file_get_contents($doc_type);
						echo $html;
						break;
				}
				exit();
			}
			else
			{
				//No PHP- or HTM(L)-File, so pass on 404-Error!
				header("HTTP/1.0 404 Not Found");
			}
		}
	}
	olc_connect_and_get_config(array(12),ADMIN_PATH_PREFIX);
	$send_email=strtolower(SEND_404_EMAIL)==TRUE_STRING_S;
	if ($send_email)
	{
		//We need the eMail address, so we need to to get the config data
		$host=$_SERVER['HTTP_HOST'];
		$subject = 'Datei auf dem Webserver "'.$host.'" nicht gefunden';
		$message = '
<html>
<head>
  <title>Datei auf dem Webserver nicht gefunden</title>
</head>
<body>
  <p><b>Zeit </b><font color="Red">'.date('d.m.Y H:i:s').'</font></p>
  <p><b>Datei </b>"'.$file_path.'" wurde auf dem <b>Webserver</b> "'.$host.'" nicht gefunden!</p>
  <p><b>User-Agent </b>"'.$_SERVER['HTTP_USER_AGENT'].'"</p>
  <p><b>Prozessor </b>"'.$_SERVER['PROCESSOR_IDENTIFIER'].'", Level '.$_SERVER['PROCESSOR_LEVEL'].
  ', Revision '.$_SERVER['PROCESSOR_REVISION'].', Prozessoren: '.$_SERVER['NUMBER_OF_PROCESSORS'].'</p>
  <p><b>Betriebssystem </b>"'.$_SERVER['OS'].'"</p>
  <p><b>Server </b>"'.$_SERVER['SERVER_SOFTWARE'].'"</p>
</body>
</html>
';
  	$new_line="\r\n";
	  // To send HTML mail, the Content-type header must be set
	  $headers  = 'MIME-Version: 1.0' . $new_line;
	  $headers .= 'Content-type: text/html; charset=iso-8859-1' . $new_line;
	  // Additional headers
	  $headers .= 'To: '. EMAIL_SUPPORT_ADDRESS . $new_line;
	  $headers .= 'From: Web-Server <'.EMAIL_SUPPORT_ADDRESS.'>' . $new_line;
	  //$headers .= 'Cc: '.EMAIL_SUPPORT_ADDRESS . $new_line;
	  //$headers .= 'Bcc: 'EMAIL_SUPPORT_ADDRESS . $new_line;
	  // Mail it
	  $success=@mail(EMAIL_SUPPORT_ADDRESS, $subject, $message, $headers);
	}
}
?>
