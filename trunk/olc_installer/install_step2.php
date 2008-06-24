<?php
/* --------------------------------------------------------------
$Id: install_step2.php,v 1.1.1.1.2.1 2007/04/08 07:18:30 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(install.php,v 1.7 2002/08/14); www.oscommerce.com
(c) 2003	    nextcommerce (install_step1.php,v 1.10 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
(c) 2004  		OL - Commerce; www.ol-Commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application.php');

$size_70='size="70"';
$text_text='text';
$bold_text_start='<font size="1"><b>';
$bold_text_end='</b><br/>';

$host=getenv('HTTP_HOST');
$post_data.='
	<tr>
		<td>
			<table class="main_content" style="text-align:left;width:100%" cellspacing="0" cellpadding="0">
			  <tr>
			    <td class="header_image"></td>
			    <td class="header">'.TITLE_CUSTOM_SETTINGS.'</td>
			  </tr>
			</table>
			<br/>
		  <table class="main_content" style="text-align:left;width:100%">
		    <tr>
			    <td>
		        <p>
		        	<font size="1">'.xtc_draw_checkbox_field_installer('install[]', 'database', true).'
		          <b>'.TEXT_IMPORT_DB.$bold_text_end.TEXT_IMPORT_DB_LONG.'</font>
		        </p>
		        <p><font size="1">'.xtc_draw_checkbox_field_installer('install[]', 'configure', true).'
		          <b>'.TEXT_AUTOMATIC.$bold_text_end.TEXT_AUTOMATIC_LONG.'</font>
		        </p>
					</td>
				</tr>
			</table>
			<br/>
			<table class="main_content" style="text-align:left;width:100%" cellspacing="0" cellpadding="0">
			  <tr>
			    <td class="header_image"></td>
			    <td class="header">'.TITLE_DATABASE_SETTINGS.'</td>
			  </tr>
			</table>
			<br/>
			<table class="main_content" style="text-align:left;width:100%">
			  <tr>
			    <td>
		        <p>'.
		        	$bold_text_start.xtc_draw_checkbox_field_installer(USE_PCONNECT, TRUE_STRING_S, false).
		          TEXT_PERSIST.$bold_text_end.TEXT_PERSIST_LONG.'</font>
		        </p>
			      <p>'.
				      $bold_text_start.TEXT_DATABASE_SERVER.$bold_text_end.
								xtc_draw_input_field_installer('DB_SERVER',EMPTY_STRING).HTML_BR.
									TEXT_DATABASE_SERVER_LONG.'</font>
						</p>
			      <p>'.
			      	$bold_text_start.TEXT_USERNAME.$bold_text_end.
								xtc_draw_input_field_installer('DB_SERVER_USERNAME',EMPTY_STRING).HTML_BR.TEXT_USERNAME_LONG.'</font>
						</p>
			      <p>'.
			      	$bold_text_start.TEXT_PASSWORD.$bold_text_end.
								xtc_draw_input_field_installer('DB_SERVER_PASSWORD',EMPTY_STRING).HTML_BR.TEXT_PASSWORD_LONG.'</font>
						</p>
			      <p>'.
				      $bold_text_start.TEXT_DATABASE.$bold_text_end.
								xtc_draw_input_field_installer('DB_DATABASE').HTML_BR.TEXT_DATABASE_LONG.'</font>
						</p>
			      <!--	W. Kaiser - Allow table-prefix-->
			      <p>'.
			      	$bold_text_start.TEXT_PREFIX.$bold_text_end.
								xtc_draw_input_field_installer('TABLE_PREFIX','olc').HTML_BR.TEXT_PREFIX_LONG.'</font>
							</p>
			      <!--	W. Kaiser - Allow table-prefix-->
			    </td>
			  </tr>
			</table>
			<br/>
			<table class="main_content" style="text-align:left;width:100%" cellspacing="0" cellpadding="0">
			  <tr>
			    <td class="header_image"></td>
			    <td class="header">'.TITLE_WEBSERVER_SETTINGS.'</td>
			  </tr>
			</table>
			<br/>
			<table class="main_content" style="text-align:left;width:100%">
			  <tr>
			    <td>
			    	<p>'.
		        	$bold_text_start.xtc_draw_checkbox_field_installer(ENABLE_SSL, TRUE_STRING_S, false).
		          TEXT_SSL.$bold_text_end.TEXT_SSL_LONG.'</font>
		        </p>
				    <p>'.
							$bold_text_start.TEXT_HTTP.$bold_text_end.
			        xtc_draw_input_field_installer('HTTP_SERVER', 'http://' . $host,$text_text,$size_70).'
			       	<br/>'.TEXT_HTTP_LONG.'</font>
			      </p>
				    <p>'.
							$bold_text_start.TEXT_HTTPS.$bold_text_end.
			        xtc_draw_input_field_installer('HTTPS_SERVER', 'https://' . $host,$text_text,$size_70).'
			       	<br/>'.TEXT_HTTPS_LONG.'</font>
			      </p>
				    <p>'.
							$bold_text_start.TEXT_WS_ROOT.$bold_text_end.
			        xtc_draw_input_field_installer('DIR_FS_DOCUMENT_ROOT', DIR_FS_DOCUMENT_ROOT,$text_text,$size_70).'
			       	<br/>'.TEXT_WS_ROOT_LONG.'</font>
			      </p>
			      <p>'.
							$bold_text_start.TEXT_WS_OLC.$bold_text_end.
			        xtc_draw_input_field_installer('DIR_FS_CATALOG', DIR_FS_DOCUMENT_ROOT.DIR_WS_CATALOG,$text_text,$size_70).'
			        <br/>'.TEXT_WS_OLC_LONG.'</font>
			      </p>
			      <p>'.
							$bold_text_start.TEXT_WS_ADMIN.$bold_text_end.
			        xtc_draw_input_field_installer('DIR_FS_ADMIN', DIR_FS_CATALOG.'admin/',$text_text,$size_70).
			        HTML_BR.TEXT_WS_ADMIN_LONG.'</font>
			      </p>
			      <p>'.
							$bold_text_start.TEXT_WS_CATALOG.$bold_text_end.
			        xtc_draw_input_field_installer('DIR_WS_CATALOG', DIR_WS_CATALOG,$text_text,$size_70).'
			        	<br/>'.TEXT_WS_CATALOG_LONG.'</font>
			      </p>
			      <p>'.
							$bold_text_start.TEXT_WS_ADMINTOOL.$bold_text_end.
			        xtc_draw_input_field_installer('DIR_WS_ADMIN', DIR_WS_CATALOG . 'admin/',$text_text,$size_70).'
			        <br/>'.TEXT_WS_ADMINTOOL_LONG.'</font>
			      </p>
			    </td>
			  </tr>
			</table>
    </td>
  </tr>
';
include('includes/program_frame.php');
?>
