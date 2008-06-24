<?php
/* --------------------------------------------------------------
$Id: import_export_customer.php,v 1.1.1.1 2006/12/22 13:37:44 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(logger.php,v 1.2 2002/05/03); www.oscommerce.com
(c) 2003	    nextcommerce (logger.php,v 1.5 2003/08/14); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');
include_once(DIR_FS_INC.'olc_draw_submit_button.inc.php');

$program_frame='program_frame.php';
$s='SESSION_LANGUAGE';
if (!defined($s))
{
	define('SESSION_LANGUAGE',$_SESSION['language']);
	define('SESSION_LANGUAGE_ID',$_SESSION['languages_id']);
	define('SESSION_CURRENCY',$_SESSION['currency']);
	if (!defined('EMPTY_STRING'))
	{
		include_once(DIR_FS_INC.'olc_define_global_constants.inc.php');
	}
}
$s='CSV_TEXTSIGN';
if (!defined($s))
{
	define($s,QUOTE);
}
$s='CSV_SEPERATOR';
if (!defined($s))
{
	define($s,SEMI_COLON);
}
define('CSV_TERM',CSV_TEXTSIGN.CSV_SEPERATOR);
define('CSV_EMPTY_FIELD',CSV_TEXTSIGN.CSV_TERM);
define('CSV_EOL',CSV_TEXTSIGN.NEW_LINE);

$csv_assoc_file="CSV_ASSOC_FILE";
$csv_import_file="CSV_IMPORT_FILE";
$csv_user_filter_file="CSV_USER_FILTER_FILE";
$csv_check_box="CSV_IMPORT_CHECKBOX";
$data_type_text='data_type';
$data_type=$_GET[$data_type_text];
$is_customers=isset($data_type);
$not_is_customers=!$is_customers;
$script=basename($_SERVER['PHP_SELF']);
$action_text='action';
$import_text='import';
$export_text='export';

$s=$action_text.EQUAL;
$import_parameter=$s.$import_text;
$export_parameter=$s.$export_text;
if ($is_customers)
{
	$s=AMP.$data_type_text.EQUAL.$data_type;
	$import_parameter.=$s;
	$export_parameter.=$s;

	$data_type_u=strtoupper(UNDERSCORE.$data_type);
	$csv_assoc_file.=$data_type_u;
	$csv_import_file.=$data_type_u;
	$csv_check_box.=$data_type_u;
}
else
{
	$data_type='products';
}

$script=str_replace(PHP,UNDERSCORE.$data_type.PHP,$script);
include(ADMIN_PATH_PREFIX.'lang'.SLASH.SESSION_LANGUAGE.SLASH.'admin'.SLASH.$script);
define('IS_XTC',!OL_COMMERCE);
define('NOT_IS_XTC',!IS_XTC);
if (IS_XTC)
{
	$program_frame='olc_'.$program_frame;
}
define('PROGRAM_FRAME',DIR_WS_INCLUDES.$program_frame);

$file_text='_file';
$hidden_text='hidden';
$action=$_GET[$action_text];
$import_file_text=$import_text.$file_text;
$import_file_hidden_text=$import_file_text.UNDERSCORE.$hidden_text;
$map_file_text='map'.$file_text;
$map_file_hidden_text=$map_file_text.UNDERSCORE.$hidden_text;
$check_box_text='check_box';
if ($not_is_customers)
{
	$user_filter_text='user_filter';
	$user_filter_file_text=$user_filter_text.$file_text;
	$user_filter_file_hidden_text=$user_filter_file_text.UNDERSCORE.$hidden_text;
}
$configuration_key_text='configuration_key';
$configuration_value_text='configuration_value';
$configuration_query_sql="
select
configuration_key,
configuration_id,
configuration_value,
use_function,
set_function
from " .
TABLE_CONFIGURATION . "
where configuration_group_id = '20' order by sort_order";

if ($action==$import_text || $action==$export_text)
{
	if (!OL_COMMERCE)
	{
		include_once(INC_PATH.'olc_smarty_init.inc.php');
		olc_smarty_init($smarty,$cacheid);
	}
	$import_dir=DIR_FS_CATALOG.'import/';
	require(DIR_WS_CLASSES .$script);

	function show_result($data_array,$data_index,$data_name)
	{
		$data=$data_array[$data_index];
		if (isset($data))
		{
			global $main_content;
			$main_content.= $data_name.COLON_BLANK.$data.HTML_BR;
		}
	}
	$map_file = new upload($map_file_text, $import_dir);
	$file=$map_file->filename;
	if ($file)
	{
		$map_file=$map_file->destination.$file;
	}
	else
	{
		$map_file=$_POST[$map_file_hidden_text];
	}
}
if (defined($csv_assoc_file))
{
	$db_mapfile_action=UPDATE;
	if (!$map_file)
	{
		$map_file=constant($csv_assoc_file);
	}
}
else
{
	$db_mapfile_action=INSERT;
}
if (defined($csv_import_file))
{
	$db_importfile_action=UPDATE;
	$import_file=constant($csv_import_file);
}
else
{
	$db_importfile_action=INSERT;
}
if (defined($csv_check_box))
{
	$csv_check_box_action=UPDATE;
	$csv_check_box_value=constant($csv_check_box);
}
else
{
	$csv_check_box_action=INSERT;
}
if ($not_is_customers)
{
	if (defined($csv_user_filter_file))
	{
		$db_user_filter_file_action=UPDATE;
		$user_filter_file=constant($csv_user_filter_file);
	}
	else
	{
		$db_user_filter_file_action=INSERT;
	}
}
switch ($action)
{
	case $import_text:
		$import_file_obj=new upload($import_file_text, $import_dir);
		if ($import_file_obj)
		{
			$import_file=$import_file_obj->filename;
			if ($import_file)
			{
				$import_file=$import_file_obj->destination.$import_file;
			}
		}
		if ($import_file)
		{
			if (strrpos($import_file,'.csv')===false)
			{
				$import_file=false;
				$error_message=TEXT_IMPORTFILE_CSV;
			}
		}
		else
		{
			$import_file=$_POST[$import_file_hidden_text];
		}
		if (defined($csv_import_file))
		{
			$db_importfile_action=UPDATE;
			if (!$import_file)
			{
				$import_file=constant($csv_import_file);
			}
		}
		else
		{
			$db_importfile_action=INSERT;
		}
		if ($import_file)
		{
			$s=$_POST[$check_box_text];
			if (isset($s))
			{
				$csv_check_box_value=$s==ONE_STRING;
			}
			if ($not_is_customers)
			{
				$user_filter_file_obj=new upload($user_filter_file_text, $import_dir);
				if ($user_filter_file_obj)
				{
					$user_filter_file=$user_filter_file_obj->filename;
					if ($user_filter_file)
					{
						$user_filter_file=$user_filter_file_obj->destination.$user_filter_file;
					}
				}
				if ($user_filter_file)
				{
					if (strrpos($user_filter_file,PHP)===false)
					{
						$user_filter_file=false;
						$error_message=TEXT_USER_FILTER_FILE_PHP;
					}
				}
				else
				{
					$user_filter_file=$_POST[$user_filter_file_hidden_text];
				}
				if (defined($csv_user_filter_file))
				{
					$db_user_filterfile_action=UPDATE;
					if (!$user_filter_file)
					{
						$user_filter_file=constant($csv_user_filter_file);
					}
				}
				else
				{
					$db_user_filterfile_action=INSERT;
				}
			}
			$import = new olcImport($import_file,$map_file,$csv_check_box_value,$user_filter_file);
		}
		else
		{
			$error_message=TEXT_IMPORTFILE_REQUIRED;
		}
		break;
	case $export_text:
		$export=new olcExport($map_file);
		break;
	case 'save':
		$configuration_query = olc_db_query($configuration_query_sql);
		while ($configuration = olc_db_fetch_array($configuration_query))
		{
			$configuration_key=$configuration[$configuration_key_text];
			$sql_data=array($configuration_value_text=>$_POST[$configuration_key]);
			olc_db_perform(TABLE_CONFIGURATION,$sql_data,SQL_UPDATE,$configuration_key_text.EQUAL.APOS.$configuration_key.APOS);
		}
		olc_redirect(FILENAME_IMPORT_EXPORT);
}
if ($import)
{
	if ($import->result)
	{
		$result=$import->result[0];
		$time=$import->result[2];
	}
}
else if ($export)
{
	if ($export->result)
	{
		$result=$export->result[0];
		$error_log=EMPTY_STRING;
		$time=$export->result[2];
	}
}
$main_content=EMPTY_STRING;
if ($result)
{
	$main_content.= '
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
          	<td class="messageStackSuccess">
            	<font size="1">
';
	if ($import)
	{
		show_result($result,'prod_new',TEXT_RESULT_P_NEW);
		if ($not_is_customers)
		{
			show_result($result,'prod_upd',TEXT_RESULT_P_CHANGED);
			show_result($result,'cat_new',TEXT_RESULT_C_NEW);
			show_result($result,'cat_upd',TEXT_RESULT_C_UPDATED);
			show_result($result,'cat_touched',TEXT_RESULT_C_CHANGED);
		}
	}
	else if ($export)
	{
		show_result($result,'prod_exp',TEXT_RESULT_P_EXPORTED);
	}
	if (isset($time))
	{
		$main_content.= $time;
	}
	$main_content.= HTML_BR. HTML_BR.'
						</font>
					</td>
        </tr>
      </table>';
	if ($import)
	{
		$n=count($import->result[1]);
		if ($n)
		{
			$main_content.= '
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
      	<tr>
          <td class="messageStackError">
          	<font size="1">
';
			for ($i=0;$i<$n;$i++)
			{
				$main_content.= $import->result[1][$i];
			}
			$main_content.= '
						</font>
					</td>
        </tr>
      </table>';
		}
		$sql_data=array($configuration_key_text=>$csv_import_file,$configuration_value_text=>$import_file);
		olc_db_perform(TABLE_CONFIGURATION,$sql_data,$db_importfile_action,
		$configuration_key_text.EQUAL.APOS.$csv_import_file.APOS);
		if ($not_is_customers)
		{
			$sql_data=array($configuration_key_text=>$csv_user_filter_file,$configuration_value_text=>$user_filter_file);
			olc_db_perform(TABLE_CONFIGURATION,$sql_data,$db_user_filterfile_action,
			$configuration_key_text.EQUAL.APOS.$csv_user_filter_file.APOS);

			$sql_data=array($configuration_key_text=>$csv_check_box,$configuration_value_text=>$csv_check_box_value);
			olc_db_perform(TABLE_CONFIGURATION,$sql_data,$csv_check_box_action,
			$configuration_key_text.EQUAL.APOS.$csv_check_box.APOS);

		}
	}
	else
	{
		$main_content.= '
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
      	<tr>
          <td>
          	<br>
          	<font style="font-size:12;font-weight:bold">
          		<a href="../export/'.basename($export->filename).'">Export-Datei laden</a>
						</font>
					</td>
        </tr>
      </table>';
	}
	$sql_data=array($configuration_key_text=>$csv_assoc_file,$configuration_value_text=>$map_file);
	olc_db_perform(TABLE_CONFIGURATION,$sql_data,$db_mapfile_action,$configuration_key_text.EQUAL.APOS.$csv_assoc_file.APOS);
}
if ($import_file)
{
	$import_file_display='<span style="font-size:6pt;font-weight:normal">'.
	str_replace(DIR_FS_CATALOG,EMPTY_STRING,$import_file).'</span>'.
	olc_draw_hidden_field($import_file_hidden_text,$import_file);
}
else
{
	$import_file=EMPTY_STRING;
}
if ($map_file)
{
	$map_file_display='<span style="font-size:6pt;font-weight:normal">'.
	str_replace(DIR_FS_CATALOG,EMPTY_STRING,$map_file).'</span>'.olc_draw_hidden_field($map_file_hidden_text,$map_file);
}
else
{
	$map_file_display=EMPTY_STRING;
}
if ($not_is_customers)
{
	if ($user_filter_file)
	{
		$user_filter_file_display='<span style="font-size:6pt;font-weight:normal">'.
		str_replace(DIR_FS_CATALOG,EMPTY_STRING,$user_filter_file).'</span>'.
		olc_draw_hidden_field($user_filter_file_hidden_text,$user_filter_file);
	}
	else
	{
		$user_filter_file=EMPTY_STRING;
	}
}
$script=basename($_SERVER['PHP_SELF']);
$main_content.=
olc_draw_form($import_text,$script,$import_parameter,'POST','enctype="multipart/form-data"').'
					<table width="100%"  border="0" cellspacing="5" cellpadding="0">
					  <tr>
					    <td class="pageHeading">'.HTML_BR.HTML_BR.IMPORT.'</td>
					  </tr>
					  <tr>
					    <td class="pageSubHeading" align="left">'.TEXT_IMPORT.HTML_BR.HTML_BR.'
					      <table width="100%" align="left" border="0" cellspacing="2" cellpadding="0">
';
if ($error_message)
{
	$main_content.='
				        	<tr>
					          <td colspan="2" class="errorText">
												'.$error_message.'
										</td>
				          </tr>
';
}
if ($is_customers)
{
	$checkbox_xplain=TEXT_SEND_EMAIL;
}
else
{
	$checkbox_xplain=TEXT_USE_FILTER;
}
$main_content.='
					        <tr>
					          <td class="pageSubHeading">
					          	'.SELECT_FILE.HTML_BR.
olc_draw_file_field($import_file_text).HTML_BR.$import_file_display.HTML_BR.HTML_BR.
SELECT_MAP.HTML_BR.olc_draw_file_field($map_file_text).HTML_BR.$map_file_display.HTML_BR.
olc_draw_checkbox_field($check_box_text,ONE_STRING,$csv_check_box_value==true).HTML_NBSP.
HTML_B_START.$checkbox_xplain.HTML_B_END.HTML_BR.HTML_BR;
if ($not_is_customers)
{
	$main_content.=SELECT_FILTER.HTML_BR.
	olc_draw_file_field($user_filter_file_text).HTML_BR.$user_filter_file_display.HTML_BR.HTML_BR;
}
$main_content.=
	olc_draw_submit_button('submit',BUTTON_IMPORT,'class="button" onclick="javascript:this.blur();"').'
					          </td>
					        </tr>
	      				</table>
	      				<p>&nbsp;</p>
	      			</td>
  					</tr>
					</table>
        </form>
'.HTML_HR.
olc_draw_form($export_text,$script,$export_parameter,'POST','enctype="multipart/form-data"').'
					<table width="100%" border="0" cellspacing="5" cellpadding="0">
					  <tr>
					    <td class="pageHeading">Export</td>
					  </tr>
					  <tr>
					    <td align="left" class="pageSubHeading">'.TEXT_EXPORT.'
					      <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0">
					        <tr>
					          <td class="pageSubHeading">
'.
HTML_BR.SELECT_MAP.HTML_BR.olc_draw_file_field($map_file_text).HTML_BR.$map_file_display.HTML_BR.HTML_BR.
olc_draw_submit_button('submit',BUTTON_EXPORT,'class="button" onclick="javascript:this.blur();"').'
					          </td>
					        </tr>
					        <tr>
					          <td colspan="2">&nbsp;</td>
					        </tr>
	      				</table>
	      			</td>
					  </tr>
					</table>
				</form>
         <table width="100%">
           <tr>
              <td class="pageSubHeading" align="left">
	              <a href="#" onclick="javascript:toggleBox(\'config\');">'.CSV_SETUP.'</a>
              </td>
          </tr>
        </table>
				<div id="config" class="longDescription">'.
olc_draw_form("configuration", $script, "gID=20&action=save").'
            <table border="0" cellspacing="0" cellpadding="4">
';
$configuration_query = olc_db_query($configuration_query_sql);
while ($configuration = olc_db_fetch_array($configuration_query))
{
	$configuration_value_text='configuration_value';
	$configuration_value=$configuration[$configuration_value_text];
	$use_function = $configuration['use_function'];
	if (olc_not_null($use_function))
	{
		$cfgValue = olc_call_function($use_function, $configuration_value);
	}
	else
	{
		$cfgValue = $configuration_value;
	}
	$set_function=$configuration['set_function'];
	if ($set_function)
	{
		eval('$value_field = ' . $set_function . QUOTE .
		htmlspecialchars($configuration_value) . '");');
	}
	else
	{
		$value_field = olc_draw_input_field($configuration[$configuration_key_text], $configuration_value,'size=10');
	}
	// add
	if (strstr($value_field,$configuration_value_text))
	{
		$value_field=str_replace($configuration_value_text,$configuration[$configuration_key_text],$value_field);
	}
	$configuration_key_u=strtoupper($configuration[$configuration_key_text]);
	$main_content.= '
						  <tr>
						    <td valign="top" class="pageSubHeading"><b>'.constant($configuration_key_u.'_TITLE').'</b></td>
						    <td valign="top" class="pageSubHeading">'.
	$value_field.HTML_BR.HTML_B_START.constant($configuration_key_u.'_DESC').HTML_B_END.'
							  </td>
						  </tr>';
}
$main_content.= '
            </table>
						<input type="submit" class="button" onclick="javascript:this.blur();" value="' . BUTTON_SAVE . '"/>
					</form>
				</div>
';
$show_column_right=true;
$no_left_menu=false;
$page_header_title='CSV '.IMPORT_EXPORT_TITLE;
$page_header_subtitle='OLC Werkzeuge';
require(PROGRAM_FRAME);
?>