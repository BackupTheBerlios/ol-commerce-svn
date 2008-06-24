<?php

//admin/import_export_customer.php

define('GZIP_COMPRESSION','false');

include ('includes/application_top.php');

require_once (DIR_FS_INC.'olc_get_country_list.inc.php');
require_once (DIR_FS_INC.'olc_validate_email.inc.php');
require_once (DIR_FS_INC.'olc_encrypt_password.inc.php');
require_once (DIR_FS_INC.'olc_get_geo_zone_code.inc.php');
require_once (DIR_FS_INC.'olc_write_user_info.inc.php');

function getpass($laenge=10)
{
	$newpass = "";
	$string="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	mt_srand((double)microtime()*1000000);

	for ($i=1; $i <= $laenge; $i++)
	{
		$newpass .= substr($string, mt_rand(0,strlen($string)-1), 1);
	}
	return $newpass;
}

$lines = 0;
$lines_ok = 0;

$importfile="kunden_import.csv";

$fh = fopen($importfile, "r") or die ("Kann Datei nicht lesen.");

while(!feof($fh))
{
	// zeile einlesen & werte zuweisen
	$zeile=fgets($fh);
	list($anrede, $firstname, $lastname, $company, $geburtsdatum, $street_address, $lkz, $postcode, $city, $suburb, $telephone, $fax, $email_address, $password) = split(";", $zeile);
	$lines+=1;

	// neues zufallspasswort erstelllen.
	$password = getpass(10);

	// vorhandene Daten aufbereiten.
	switch($anrede)
	{
		case "01":
			$gender = "m";
			break;

		case "02":
			$gender = "f";
			break;

		default:
			$gender = "m";
	}

	// http://www.didihome.de/html/tab-lkz.htm
	// Problemkinder: BAL, EI

	switch(strtoupper($lkz))
	{
		case "D":
			$lkz = "DE";
			break;

		case "A":
			$lkz = "AT";
			break;

		case "F":
			$lkz = "FR";
			break;

		case "WD":
			$lkz = "DM";
			break;

		case "CDN":
			$lkz = "CA";
			break;

		case "I":
			$lkz = "IT";
			break;

		case "N":
			$lkz = "NO";
			break;

		case "U":
			$lkz = "UY";
			break;

			// ?? P = POLEN!?
		case "P":
			$lkz = "PL";
			break;

		case "J":
			$lkz = "JP";
			break;

		case "E":
			$lkz = "ES";
			break;

		case "H":
			$lkz = "HU";
			break;

		case "AUS":
			$lkz = "AU";
			break;

		case "FL":
			$lkz = "LI";
			break;

		case "S":
			$lkz = "SE";
			break;

		case "L":
			$lkz = "LU";
			break;

		case "RB":
			$lkz = "BW";
			break;

		case "FIN":
			$lkz = "FI";
			break;

		case "RI":
			$lkz = "ID";
			break;

		case "B":
			$lkz = "BE";
			break;

		case "SGP":
			$lkz = "SG";
			break;

		case "EST":
			$lkz = "EE";
			break;

		case "IRL":
			$lkz = "IE";
			break;

		case "RUS":
			$lkz = "RU";
			break;

		case "SLO":
			$lkz = "SI";
			break;

		case "USA":
			$lkz = "US";
			break;
	}
	$country_query = olc_db_query("SELECT * FROM `countries` WHERE `countries_iso_code_2` = '".strtoupper($lkz)."'");
	$country_data = olc_db_fetch_array($country_query);
	$country = $country_data['countries_id'];

	if(!is_numeric($country_data['countries_id']))
	{
		echo "   <b>ERROR:</b> LKZ_CONVERT_ERROR<br>\n";
		echo "lkz=".$lkz." countries_id=".$country_data['countries_id']. " countries_name=".$country_data['countries_name']."<br>\n";
	}

	if ($geburtsdatum != ".000000000" && $geburtsdatum != "")
	{
		list($jahr, $monat, $tag) = sscanf($geburtsdatum,"%4d%2d%2d.%d");

		$dob = sprintf("%02d.%02d.%4d",$tag,$monat,$jahr);
		//echo $geburtsdatum . " = " . $dob ."<br>\n";
	}
	else
	$dob='';

	// sonnstige variablen
	$customers_status = DEFAULT_CUSTOMERS_STATUS_ID;
	$newsletter = "0";
	$do_not_report = false;

	// daten in db eintragen
	require_once(DIR_WS_CLASSES.'vat_validation.php');

	$vatID = new vat_validation($vat, '', '', $country);
	$customers_status = $vatID->vat_info['status'];
	$customers_vat_id_status = $vatID->vat_info['vat_id_status'];
	$error = $vatID->vat_info['error'];

	if($error==1)
	{

		//$messageStack->add('create_account', ENTRY_VAT_ERROR);
		echo "   <b>ERROR:</b> ENTRY_VAT_ERROR<br>\n";
		$error =true;

	}

	if(!is_numeric($country_data['countries_id']))
	$error = true;

	$email_exists = false;
	$check_email_query = olc_db_query("select count(*) as total from ".TABLE_CUSTOMERS." where customers_email_address = '".olc_db_input($email_address)."' and account_type = '0'");
	$check_email = olc_db_fetch_array($check_email_query);

	if ($check_email['total'] > 0) {

		$email_exists = true;
	}

	if($email_exists == true)
	{
		$error = true;
		$do_not_report = true;

		//$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
		//echo "   <b>ERROR:</b> ENTRY_EMAIL_ADDRESS_ERROR_EXISTS<br>\n";
	}
	elseif (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH)
	{

		$error = true;
		//$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR);
		echo "   <b>ERROR:</b> ENTRY_EMAIL_ADDRESS_ERROR<br>\n";

	}

	elseif (olc_validate_email($email_address) == false)
	{

		$error = true;
		//$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
		echo "   <b>ERROR:</b> ENTRY_EMAIL_ADDRESS_CHECK_ERROR<br>\n";
		/*
		$fp3 = fopen("kunden_import_mail-check-fail.csv", "a");
		fputs($fp3, $zeile);
		fclose ($fp3);
		*/

	}

	if($dob != '')
	{
		if (checkdate(substr(olc_date_raw($dob), 4, 2), substr(olc_date_raw($dob), 6, 2), substr(olc_date_raw($dob), 0, 4)) == false)
		{

			$error = true;
			echo "   <b>ERROR:</b> ENTRY_DATE_OF_BIRTH_ERROR<br>\n";

			//$messageStack->add('create_account', ENTRY_DATE_OF_BIRTH_ERROR);

		}
	}

	if($error != true)
	{
		$lines_ok += 1;

		$sql_data_array = array ('customers_vat_id' => $vat, 'customers_vat_id_status' => $customers_vat_id_status, 'customers_status' => $customers_status, 'customers_firstname' => $firstname, 'customers_lastname' => $lastname, 'customers_email_address' => $email_address, 'customers_telephone' => $telephone, 'customers_fax' => $fax, 'customers_newsletter' => $newsletter, 'customers_password' => olc_encrypt_password($password),'customers_date_added' => 'now()','customers_last_modified' => 'now()');


		$sql_data_array['customers_gender'] = $gender;
		$sql_data_array['customers_dob'] = olc_date_raw($dob);
		olc_db_perform(TABLE_CUSTOMERS, $sql_data_array);
		$user_id = olc_db_insert_id();

		//olc_write_user_info($user_id);

		$sql_data_array = array ('customers_id' => $user_id, 'entry_firstname' => $firstname, 'entry_lastname' => $lastname, 'entry_street_address' => $street_address, 'entry_postcode' => $postcode, 'entry_city' => $city, 'entry_country_id' => $country,'address_date_added' => 'now()','address_last_modified' => 'now()');



		$sql_data_array['entry_gender'] = $gender;
		$sql_data_array['entry_company'] = $company;

		if (ACCOUNT_SUBURB == 'true')
		$sql_data_array['entry_suburb'] = $suburb;


		if (ACCOUNT_STATE == 'true')
		{

			if ($zone_id > 0)
			{

				$sql_data_array['entry_zone_id'] = $zone_id;
				$sql_data_array['entry_state'] = '';

			}
			else
			{
				$sql_data_array['entry_zone_id'] = '0';
				$sql_data_array['entry_state'] = $state;
			}
		}


		olc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
		$address_id = olc_db_insert_id();

		olc_db_query("update ".TABLE_CUSTOMERS." set customers_default_address_id = '".$address_id."' where customers_id = '".(int) $user_id."'");

		olc_db_query("insert into ".TABLE_CUSTOMERS_INFO." (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('".(int) $user_id."', '0', now())");


		// create smarty elements

		$smarty = new Smarty;

		$smarty->assign('GENDER', $gender);
		$smarty->assign('FIRSTNAME', $firstname);

		$smarty->assign('LASTNAME', $lastname);
		$smarty->assign('EMAIL', $email_address);
		$smarty->assign('PASSWORT', $password);

		$smarty->caching = false;
		$txt_mail_customer = $smarty->fetch(DIR_FS_CATALOG.'kunden_import_mail.txt');
    	$mail_subject = "Unser neuer Onlineshop";

		/*
		echo "<pre>\n";
		echo $txt_mail_customer;
		echo "</pre>\n";
		*/
		// mail versenden
		olc_php_mail(STORE_OWNER_EMAIL_ADDRESS, STORE_OWNER, $email_address, $firstname.' '.$lastname, '', STORE_OWNER_EMAIL_ADDRESS, STORE_OWNER, '', '', $mail_subject, '', $txt_mail_customer);

	}
	else
	{
		if(!$do_not_report==true)
		{
			echo "<b color=\"red\">fehler beim anlegen von $firstname, $lastname, $company, $email_address</b><br>\n";
			echo "<b>------------------------------------------------------------------------------------------------------</b><br>\n";
		}
	}

	flush();

}
fclose($fh);

echo "$lines_ok von $lines Daten importiert!";

include ('includes/application_bottom.php');

/*
Und das Mail-Template:

{if $GENDER == 'f'}
Sehr geehrte Frau {$LASTNAME},
{else}
Sehr geehrter Herr {$LASTNAME},
{/if}

seit 01.02.2007 ist unser neuer Onlineshop unter Modellsport.de erreichbar.

Da Sie bereits Kunde bei uns sind, haben wir Ihre Daten in den neuen Shop übernommen. Sie können sich mit folgenden Login-Daten anmelden:

Benutzer: {$EMAIL}
Passwort: {$PASSWORT}

Bitte überprüfen Sie bei Gelegenheit, ob die Angaben, wie Name, Adresse usw. noch korrekt sind und geben uns Bescheid, wenn sich irgendwelche Fehler eingeschlichen oder Daten geändert haben sollten.

Wir danken für Ihre Mithilfe und verbleiben

mit freundlichen Grüßen
MODELLSPORT VERLAG GMBH
- Vertrtiebsleitung -
*/
?>