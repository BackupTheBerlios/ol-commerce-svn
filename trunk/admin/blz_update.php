<?php
/* --------------------------------------------------------------
$Id: blz_update.php,v 1.1.1.1.2.1 2007/04/08 07:16:25 gswkaiser Exp $

BLZ-Updater for OL-Commerce

Author: Winfried Kaiser (w.kaiser@fortune.de)

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(customers.php,v 1.76 2003/05/04); www.oscommerce.com
(c) 2003	    nextcommerce (customers.php,v 1.22 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------
Third Party contribution:
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

Released under the GNU General Public License
--------------------------------------------------------------*/

// if the customer is not logged on, redirect them to the login page
require('includes/application_top.php');
if (!isset($_SESSION['customer_id']))
{
	olc_redirect(olc_href_link(FILENAME_LOGIN, EMPTY_STRING, NONSSL));
}
include(DIR_WS_INCLUDES . 'html_head_full.php');
$button_back=HTML_A_START . olc_href_link(FILENAME_START, EMPTY_STRING, NONSSL) . '">' .
	olc_template_image_button('button_back.gif', 'Zurück zur Startseite') .HTML_A_END;
$checkstatus=!$_GET['ignorestatus'];
if($checkstatus && !isset($_POST["submitted"]))
{
	$main_content = EMPTY_STRING;
	$err_message = $_GET['err_message'];
	if ($err_message <> EMPTY_STRING)
	{
		$main_content .= '<p><b><font color="red">'.$err_message ."</font></b></p>";
	}
	$main_content .= '<input type="hidden" name="submitted" value="TRUE" id="'.time().'">';
	$main_content .= HTML_BR.'<input type="file" name="file" size="50">'. HTML_BR;
	$smarty->assign('FORM_ACTION',olc_draw_form('blz_update', $PHP_SELF,'full=1', 'post','enctype="multipart/form-data"'));
	$smarty->assign('BUTTON_CONTINUE',olc_template_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
	$smarty->assign('SHOW_EXPLANATION',"1");
}
else
{
	$upload_dir= DIR_FS_CATALOG.'cache/blz'.SLASH;
	if ($filename = new upload('file', $upload_dir))
	{
		$filename = strtolower($filename->filename);
	}
	if ($filename != EMPTY_STRING)
	{
		$pos=strrpos($filename, SLASH);
		if ($pos == 0)
		{
			$pos=strrpos($filename, '\\');
		}
		if ($pos !== false)
		{
			$filename = substr($filename, $pos+1);
		}
		$check_status_query = olc_db_query(SELECT. "bankname from " .	TABLE_BANKTRANSFER_BLZ . " where blz = '99999999'");
		$check_status = olc_db_fetch_array($check_status_query);
		$old_status = $check_status['bankname'];
		$have_status=$old_status != EMPTY_STRING;
		$process_update=true;
		if ($checkstatus)
		{
			if ($have_status)
			{
				$process_update=strrpos($filename,$old_status)===false;
			}
		}
		if ($have_status)
		{
			$pos= strrpos($old_status, DOT);
			$old_status=substr($old_status, 0, $pos);
		}
		if ($process_update)
		{
			$blz_text="blz";
			$bank_text=$bank_text;
			$prz_text="prz";
			$plz_text="plz";
			$ort_text="ort";
			$bankname_kurz_text="bankname_kurz";

			$lines = file($filename);
			// Durchgehen des Arrays und speichern der Bankleitzahlinfo
			$blzs = sizeof($lines);
			if ($blzs >0)
			{
				/*
				Line structure defined
				*/
				$field_startpos = array(
				$blz_text=>0,				//Bankleitzahl
				"any"=>8,						//bankleitzahlführendes Kreditinstitut
				$bank_text=>9,			//Bezeichnung des Kreditinstituts
				$plz_text=>67,			//Postleitzahl des Kreditinstituts
				$ort_text=>72,			//Postleitzahl des Kreditinstituts
				"bank_short"=>107,	//Kurz.Bezeichnung des Kreditinstituts
				"pan_nr"=>134,			//Institutsnummer für PAN
				"bic"=>139,					//BIC
				$prz_text=>150,			//Kennzeichen der Prüfziffernberechnungsmethode
				"nr"=>152,					//Datensatznummer
				"change_id"=>158,		//Änderungskennzeichen
				"delete_id"=>159,		//Löschkennzeichen
				"blz_new"=>160			//Nachfolge-Blz
				);

				$field_len = array(
				$blz_text=>8,				//Bankleitzahl
				"any"=>1,						//bankleitzahlführendes Kreditinstitut
				$bank_text=>58,			//Bezeichnung des Kreditinstituts
				$plz_text=>5,				//Postleitzahl des Kreditinstituts
				$ort_text=>35,			//Postleitzahl des Kreditinstituts
				"bank_short"=>27,		//Kurz.Bezeichnung des Kreditinstituts
				"pan_nr"=>5,				//Institutsnummer für PAN
				"bic"=>11,					//BIC
				$prz_text=>2,				//Kennzeichen der Prüfziffernberechnungsmethode
				"nr"=>6,						//Datensatznummer
				"change_id"=>1,			//Änderungskennzeichen
				"delete_id"=>1,			//Löschkennzeichen
				"blz_new"=>8				//Nachfolge-Blz
				);

				$set_full_db = $_GET["full"] != EMPTY_STRING;
				$land="D";
				define("APOS",APOS);
				define("COMMA",",");
				define("APOSCOMMA",APOS.COMMA);
				$time_start = microtime_float();
				//$sql_command = "TRUNCATE TABLE " . TABLE_BANKTRANSFER_BLZ;
				$sql_command = DELETE_FROM . TABLE_BANKTRANSFER_BLZ . " WHERE LAND ='D';";
				olc_db_query($sql_command);
				$sql_command0 = INSERT_INTO. TABLE_BANKTRANSFER_BLZ . " VALUES (";

				foreach ($lines as $line_num => $line) {
					$blz = substr($line, $field_startpos[$blz_text], $field_len[$blz_text]);
					$bank = trim(substr($line, $field_startpos[$bank_text], $field_len[$bank_text]));
					$prz = substr($line, $field_startpos[$prz_text], $field_len[$prz_text]);
					if ($set_full_db)
					{
						$plz = trim(substr($line, $field_startpos[$plz_text], $field_len[$plz_text]));
						$ort = trim(substr($line, $field_startpos[$ort_text], $field_len[$ort_text]));
						$bankname_kurz = trim(substr($line, $field_startpos[$bankname_kurz_text], $field_len[$bankname_kurz_text]));
					}
					$sql_command = $sql_command0.
					APOS.$blz.APOSCOMMA.
					APOS.$bank.APOSCOMMA.
					APOS.$prz.APOS;
					if ($set_full_db)
					{
						$sql_command .=
						COMMA.APOS.$land.APOSCOMMA.
						APOS.$plz.APOSCOMMA.
						APOS.$ort.APOSCOMMA.
						APOS.$bankname_kurz.APOS;
					}
					$sql_command .= ");";
					olc_db_query($sql_command);
				}
				$sql_command = $sql_command0.
				APOS."99999999".APOSCOMMA.
				APOS.$filename.APOSCOMMA.
				APOS.APOS;
				if ($set_full_db)
				{
					$sql_command .=
					COMMA.APOS.$land.APOSCOMMA.
					APOS.APOSCOMMA.
					APOS.APOSCOMMA.
					APOS.APOS;
				}

				$sql_command .= ");";
				olc_db_query($sql_command);

				$time_end = microtime_float();
				$time = $time_end - $time_start;

				$main_content = '<br/><b>'.$blzs . ' Datensätze wurden aus Datei: \'' .  $filename  . ' \' aktualisiert.</b><br/><br/>';
				if ($old_status != EMPTY_STRING)
				{
					$main_content .= 'Alter Stand: ' . $old_status . HTML_BR;
				}
				$pos= strrpos($filename, '.');
				$main_content .= 'Neuer Stand: ' . substr($filename, 0, $pos)."<br/><br/>";
			}
			else
			{
				$err_message = 'Keine BLZ-Daten in Datei \'' . $upload_dir . '/' . $filename. '\' gefunden';
			}
		}
		else
		{
			$button_continue=HTML_A_START . olc_href_link(CURRENT_SCRIPT, 'full=1&ignorestatus=true', NONSSL) . '">' .
				olc_template_image_button('button_continue.gif', 'Weiter mit dem BLZ-Update') .HTML_A_END;
			$err_message='<div class="main"><br/>
Die BLZ-Datenbank hat schon den aktuellen Stand <b>"'.$old_status.'"</b>.
<p>Trotzdem weiter?</p>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="main" align="left" valign="bottom">'.$button_back.'&nbsp;</td>
		<td class="main" align="right" valign="bottom"><b><font color="#FF0000">Die Bearbeitung kann 3 bis 5 Minuten dauern!
			Bitte keinesfalls unterbrechen!<br/>
			</font></b><br/>'.$button_continue.'</td>
	</tr>
</table>
</div>
';

			echo $err_message;
			exit();
		}
	}
	else
	{
		$err_message = 'Keine BLZ-Datei im Verzeichnis  \'' . $upload_dir . '\' gefunden';
	}
	if ($err_message)
	{
		$smarty->assign('ERROR',$err_message);
		$smarty->assign('SHOW_EXPLANATION',"1");
	}
}
$smarty->assign('BUTTON_BACK',$button_back);
$smarty->assign('CONTENT_BODY',$main_content);
$main_content = $smarty->fetch(CURRENT_TEMPLATE_MODULE . 'blz_update'.HTML_EXT,SMARTY_CACHE_ID);
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
		<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        	<table width="100%" border="0">
          	<tr>
            	<td>

<?PHP
echo $main_content;
?>

			        </td>
			      </tr>
			    </table>
		    </td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

<?php

function GetDirContents($dir,$match){
	$check_ext = $match != EMPTY_STRING;
	$check_it = true;
	if (!is_dir($dir)){die ("Fehler in Funktion
	: kein gültiges Verzeichnis: $dir!");}
	if ($root=@opendir($dir)){
		while ($file=readdir($root)){
			if($file=="." || $file==".."){continue;}
			if(is_dir($dir.SLASH.$file)){
				$files=array_merge($files,GetDirContents($dir.SLASH.$file));
			}else{
				$file = $dir.SLASH.$file;
				if ($check_ext)
				{
					$check_it = preg_match("/$match/i", $file);
				}
				if ($check_it)
				{
					$this_filemtime = filemtime($file);
					if ($this_filemtime > $last_filemtime) {
						$last_filemtime = $this_filemtime;
						$newest_file=$file;
					}
				}
			}
		}
	}
	return $newest_file;
}

if (!function_exists("microtime_float"))
{
	function microtime_float()
	{
		list($usec, $sec) = explode(BLANK, microtime());
		return ((float)$usec + (float)$sec);
	}
}
?>