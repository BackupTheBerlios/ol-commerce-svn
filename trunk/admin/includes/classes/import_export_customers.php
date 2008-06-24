<?php
//admin/import_export_customer.php

require_once(ADMIN_PATH_PREFIX.DIR_WS_CLASSES.'vat_validation.php');
require_once(DIR_FS_INC.'olc_get_country_list.inc.php');
require_once(DIR_FS_INC.'olc_get_country_list.inc.php');
require_once(DIR_FS_INC.'olc_validate_email.inc.php');
require_once(DIR_FS_INC.'olc_encrypt_password.inc.php');
require_once(DIR_FS_INC.'olc_get_geo_zone_code.inc.php');

define('PASS_STRING','ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');

function set_country_info($lkz)
{
	global $error,$set_suburb,$suburb,$zone_id,$set_state,$state,$sql_data_array;

	$lkz=trim($lkz);
	switch(strtoupper($lkz))
	{
		case "Other":
		case "Deutschland":
			$lkz = "DE";
			break;
		default:
			$lkz = "DE";
	}
	$country_query = olc_db_query(SELECT_COUNTRY_SQL.strtoupper($lkz).APOS);
	$country_data = olc_db_fetch_array($country_query);
	$country = $country_data['countries_id'];
	if (!is_numeric($country_data['countries_id']))
	{
		$error=QUOTE.$lkz.", countries_id=".$country_data['countries_id'].
		", countries_name=".$country_data['countries_name'].QUOTE.' -- '.ENTRY_COUNTRY_ERROR;
	}
	$sql_data_array=array();
	if ($set_suburb)
	{
		$suburb=trim($suburb);
		$sql_data_array['entry_suburb'] = $suburb;
	}
	if ($set_state)
	{
		if ($zone_id > 0)
		{
			$state = EMPTY_STRING;
		}
		else
		{
			$zone_id=0;
		}
		$sql_data_array['entry_zone_id'] = $zone_id;
		$sql_data_array['entry_state'] = $state;
	}
	return $country;
}

function getpass($laenge=10)
{
	$newpass = EMPTY_STRING;
	mt_srand((double)microtime()*1000000);
	for ($i=1; $i <= $laenge; $i++)
	{
		$newpass .= substr(PASS_STRING, mt_rand(0,strlen($string)-1), 1);
	}
	return $newpass;
}

class olcImport
{
	function olcImport($filename,$map_filename,$send_mail,$any)
	{
		$this->filename=$filename;
		$this->map_filename=$map_filename;
		$this->send_mail=$send_mail;
		if ($send_mail)
		{
			$this->smarty = new Smarty;
			$this->email_template=CURRENT_TEMPLATE . '/admin/mail/'.SESSION_LANGUAGE.'/kunden_import_mail.txt';
		}
		$this->import();
	}

	function import()
	{
		$this->time_start=time();
		$lines = 1;
		$lines_ok = 0;
		// sonstige variablen
		$newsletter = 0;
		$set_suburb=ACCOUNT_SUBURB == TRUE_STRING_S;
		$set_state=ACCOUNT_STATE == TRUE_STRING_S;
		$email_adresses=array();

		$error=EMPTY_STRING;
		define('INSERT_INTO_CUSTOMERS_INFO_SQL',INSERT_INTO.TABLE_CUSTOMERS_INFO.
		" (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('");
		define('SELECT_COUNTRY_SQL',SELECT_ALL."`countries` WHERE `countries_iso_code_2` = '");
		$check_email_sql=SELECT_COUNT."as total from ".TABLE_CUSTOMERS." where customers_email_address = '";
		$update_table_customers=SQL_UPDATE.TABLE_CUSTOMERS." set customers_default_address_id = '";

		$fh = fopen($this->filename, "r");
		if ($fh)
		{
			$zeile=fgets($fh);
			while (!feof($fh))
			{
				// zeile einlesen & werte zuweisen
				$zeile=trim(fgets($fh));
				if ($zeile)
				{
					$dataArray=explode(SEMI_COLON,$zeile);
					for ($j=0,$m=sizeof($this->dataArray);$j<$m;$j++)
					{
						$data=$this->dataArray[$j];
						if (substr($data,-1)==CSV_TEXTSIGN)
						{
							$dataArray[$j]=substr($data,1,strlen($data)-2);
						}
					}

					list($cid,$gruppe,$anrede,$email_address,$company,$lkz,$lastname,$city,$postcode,$password,
					$street_address,$fax,$telephone,$firstname,
					$d_company,$d_lkz,$d_lastname,$d_city,$d_postcode,$d_street_address,$d_fax,$d_telephone,$d_firstname)=$dataArray;

					$lines++;
					if (!$password)
					{
						// neues zufallspasswort erstelllen.
						$password = getpass(10);
					}
					// vorhandene Daten aufbereiten.
					$gruppe=trim($gruppe);
					switch ($gruppe)
					{
						case "Registriert":
							$customers_status = DEFAULT_CUSTOMERS_STATUS_ID_CUSTOMER;
							break;
						case "Merchant":
							$customers_status = DEFAULT_CUSTOMERS_STATUS_ID_DEALER;
							break;
						default:
							$customers_status = DEFAULT_CUSTOMERS_STATUS_ID_GUEST;
					}
					$anrede=trim($anrede);
					switch ($anrede)
					{
						case "Herr":
							$gender = "m";
							break;
						case "Frau":
							$gender = "f";
							break;
						default:
							$gender = "m";
					}
					$country=set_country_info($lkz);

					$geburtsdatum=trim($geburtsdatum);
					if ($geburtsdatum != EMPTY_STRING && $geburtsdatum != ".000000000")
					{
						list($jahr, $monat, $tag) = sscanf($geburtsdatum,"%4d%2d%2d.%d");
						$dob = sprintf("%02d.%02d.%4d",$tag,$monat,$jahr);
					}
					else
					{
						$dob=EMPTY_STRING;
					}
					// daten in db eintragen
					$vatID = new vat_validation($vat, EMPTY_STRING, EMPTY_STRING, $country);
					$customers_status = $vatID->vat_info['status'];
					$customers_vat_id_status = $vatID->vat_info['vat_id_status'];
					if ($vatID->vat_info['error'])
					{
						$error.=ENTRY_VAT_ERROR;
					}
					$email_address=trim($email_address);
					$check_email_query = olc_db_query($check_email_sql.olc_db_input($email_address)."' and account_type = '0'");
					$check_email = olc_db_fetch_array($check_email_query);
					$s=QUOTE.$email_address.QUOTE.' -- ';
					if ($check_email['total'] > 0)
					{
						$error.=$s.ENTRY_EMAIL_ADDRESS_ERROR_EXISTS.LPAREN.EMAIL_ALREADY_USED.$email_adresses[$email_address].RPAREN;
					}
					elseif (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH)
					{
						$error.=$s.ENTRY_EMAIL_ADDRESS_ERROR;
					}
					elseif (olc_validate_email($email_address) == false)
					{

						$error.=$s.ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
						/*
						$fp3 = fopen("kunden_import_mail-check-fail.csv", "a");
						fputs($fp3, $zeile);
						fclose ($fp3);
						*/
					}
					if ($email_adresses[$email_address])
					{
						$email_adresses[$email_address].=COMMA_BLANK;
					}
					$email_adresses[$email_address].=$lines;
					if ($dob != EMPTY_STRING)
					{
						$date_raw=olc_date_raw($dob);
						if (checkdate(substr($date_raw, 4, 2), substr($date_raw, 6, 2),substr($date_raw, 0, 4)) == false)
						{
							$error.=QUOTE.$dob.QUOTE.' -- '.ENTRY_DATE_OF_BIRTH_ERROR;
						}
					}
					if ($error)
					{
						$this->errorLog[]=sprintf(TEXT_ERROR,$error,$lines);
						$error=EMPTY_STRING;
					}
					else
					{
						$lines_ok++;

						$cid=trim($cid);
						$firstname=trim($firstname);
						$lastname=trim($lastname);
						$telephone=trim($telephone);
						$fax=trim($fax);
						$street_address=trim($street_address);
						$company=trim($company);
						$postcode=trim($postcode);
						$city=trim($city);

						$sql_data_array = array (
						'customers_cid' => $cid,
						'customers_vat_id' => $vat,
						'customers_vat_id_status' => $customers_vat_id_status,
						'customers_status' => $customers_status,
						'customers_firstname' => $firstname,
						'customers_lastname' => $lastname,
						'customers_email_address' => $email_address,
						'customers_telephone' => $telephone,
						'customers_fax' => $fax,
						'customers_newsletter' => $newsletter,
						'customers_password' => olc_encrypt_password($password),
						'customers_gender' => $gender,
						'customers_dob' => $date_raw,
						'customers_date_added' => 'now()',
						'customers_last_modified' => 'now()');
						olc_db_perform(TABLE_CUSTOMERS, $sql_data_array);
						$user_id = olc_db_insert_id();

						$sql_data_array = array (
						'customers_id' => $user_id,
						'entry_firstname' => $firstname,
						'entry_lastname' => $lastname,
						'entry_street_address' => $street_address,
						'entry_postcode' => $postcode,
						'entry_city' => $city,
						'entry_country_id' => $country,
						'entry_gender' => $gender,
						'entry_company' => $company,
						'address_date_added' => 'now()',
						'address_last_modified' => 'now()');

						olc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
						$address_id = olc_db_insert_id();
						olc_db_query($update_table_customers.$address_id."' where customers_id = '".(int) $user_id.APOS);
						olc_db_query(INSERT_INTO_CUSTOMERS_INFO_SQL. (int) $user_id."', '0', now())");
						if ($d_lkz)
						{
							//Separate delivery-adress.
							$country=set_country_info($d_lkz);

							$firstname=trim($d_firstname);
							$lastname=trim($d_lastname);
							$telephone=trim($d_telephone);
							$fax=trim($d_fax);
							$street_address=trim($d_street_address);
							$company=trim($d_company);
							$postcode=trim($d_postcode);
							$city=trim($d_city);

							$sql_data_array = array (
							'customers_id' => $user_id,
							'entry_firstname' => $firstname,
							'entry_lastname' => $lastname,
							'entry_street_address' => $street_address,
							'entry_postcode' => $postcode,
							'entry_city' => $city,
							'entry_country_id' => $country,
							'entry_gender' => $gender,
							'entry_company' => $company,
							'address_date_added' => 'now()',
							'address_last_modified' => 'now()');
							olc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
						}
						// create smarty elements
						if ($send_mail)
						{
							$this->smarty->assign('GENDER', $gender);
							$this->smarty->assign('FIRSTNAME', $firstname);

							$this->smarty->assign('LASTNAME', $lastname);
							$this->smarty->assign('EMAIL', $email_address);
							$this->smarty->assign('PASSWORT', $password);

							$this->smarty->caching = false;
							$txt_mail_customer = $this->smarty->fetch($this->email_template);
							// mail versenden
							olc_php_mail(STORE_OWNER_EMAIL_ADDRESS, STORE_OWNER, $email_address, $firstname.BLANK.$lastname,
							EMPTY_STRING, STORE_OWNER_EMAIL_ADDRESS, STORE_OWNER, EMPTY_STRING, EMPTY_STRING, TEXT_MAIL_SUBJECT,
							EMPTY_STRING, $txt_mail_customer);
						}
					}
					flush();
				}
			}
			fclose($fh);
		}
		else
		{
			$file_error=TEXT_FILE_ERROR_OPEN;
		}
		if ($file_error)
		{
			$this->errorLog[]=sprintf(TEXT_ERROR_FILE,$file_error);
		}
		$this->result=array(array('prod_new' => $lines_ok." von ".($lines-1)),
		$this->errorLog,$this->calcElapsedTime($this->time_start));
		return $this->result;
	}

	/**
	*   Calculate Elapsed time from 2 given Timestamps
	*   @param int $time old timestamp
	*   @return String elapsed time
	*/
	function calcElapsedTime($time)
	{

		// calculate elapsed time (in seconds!)
		$diff=time()-$time;

		$daysDiff=0;
		$hrsDiff=0;
		$minsDiff=0;
		$secsDiff=0;

		$sec_in_a_day=60 * 60 * 24;
		while ($diff >=$sec_in_a_day)
		{
			$daysDiff++;
			$diff-=$sec_in_a_day;
		}
		$sec_in_an_hour=60 * 60;
		while ($diff >=$sec_in_an_hour)
		{
			$hrsDiff++;
			$diff-=$sec_in_an_hour;
		}
		$sec_in_a_min=60;
		while ($diff >=$sec_in_a_min)
		{
			$minsDiff++;
			$diff-=$sec_in_a_min;
		}
		$secsDiff=$diff;
		if ($hrsDiff)
		{
			$diff=$hrsDiff.TEXT_EXECUTION_TIME_HOUR;
		}
		else
		{
			$diff=EMPTY_STRING;
		}
		if ($minsDiff)
		{
			$diff.=$minsDiff.TEXT_EXECUTION_TIME_MINUTE;
		}
		if ($secsDiff)
		{
			$diff.=$secsDiff.TEXT_EXECUTION_TIME_SECOND;
		}
		return TEXT_EXECUTION_TIME.trim($diff);
	}
}

class olcExport extends olcImport
{
	function olcExport($map_filename)
	{
		//$this->init('export'.date('_Y_m_d').'.csv',$map_filename);
		$this->ExportDir=DIR_FS_CATALOG.'export/';
		$this->cat=array();
		$this->parent=array();
		$this->counter=array('prod_exp'=>0);
		if ($this->map_file($line_content))
		{
			$this->export();
		}
	}

	function add_header_field($field_name)
	{
		global $heading;

		$field_name_mapped=$this->map_data[$field_name];
		if ($field_name_mapped==EMPTY_STRING)
		{
			$field_name_mapped=$field_name;
		}
		$heading.=$field_name_mapped.CSV_SEPARATOR;
	}

	function add_adress_book_field($field_name)
	{
		global $heading,$lang_code;

		$full_field_name=$field_name.$lang_code;
		$field_name_mapped=$this->map_data[$full_field_name];
		if ($field_name_mapped==EMPTY_STRING)
		{
			$field_name_mapped=$full_field_name;
		}
		$heading.=$field_name_mapped.CSV_SEPARATOR;
	}

	function add_customer_field($field_name)
	{
		global $line,$export_data;

		$field_name=$this->fields_assoc[$field_name];
		$data=$export_data[$field_name];
		$line.=CSV_TEXTSIGN.$data.CSV_TERM;
	}

	function export()
	{
/*
		global $heading,$export_data,$adress_book,$line;
		$this->filename=$this->ExportDir.$this->filename;
		$fp=fopen($this->filename,"w+");
		$heading=EMPTY_STRING;
		for ($i=0;$i<CUSTOMER_FIELDS;$i++)
		{
			$this->add_header_field($this->cust_fields_array[$i]);
		}
		for ($i=0;$i<MAX_ADDRESS_BOOK_ENTRIES;$i++)
		{
			$this->add_adress_book_header_field($i);
		}
		$heading.=NEW_LINE;
		fputs($fp,$heading);
		// content
		$export_query=olc_db_query(SELECT_ALL.TABLE_CUSTOMERS);
		while ($export_data=olc_db_fetch_array($export_query))
		{
			$this->counter['prod_exp']++;

			$customers_id=$export_data[C_ID];
			$where_customers_id=WHERE_C_ID_EQUAL.$customers_id;
			$line=EMPTY_STRING;
			for ($i=0;$i<CUST_FIELDS;$i++)
			{
				$this->add_customer_field($this->cust_fields_array[$i]);
			}
			$adress_book_query0=SELECT_ALL.TABLE_ADRESS_BOOK.$where_customers_id;
			for ($i=0;$i<MAX_ADRESS_BOOK_ENTRIES;$i++)
			{
				$adress_book_query_sql=str_replace(HASH,$i,$adress_book_query0);
				$adress_book_query=olc_db_query($adress_book_query_sql);
				$groupPrice=EMPTY_STRING;
				while ($adress_book_data=olc_db_fetch_array($adress_book_query))
				{
					$adress_book_personal_offer=$adress_book_data['personal_offer'];
					if ($adress_book_personal_offer>0)
					{
						if (DO_PRICE_IS_BRUTTO)
						{
							$this->adjust_adress_book_to_net($adress_book_personal_offer);
						}
						$groupPrice.=$adress_book_data['quantity'].COLON.$adress_book_personal_offer.TWO_COLON;
					}
				}
				if ($groupPrice)
				{
					$groupPrice.=COLON;
					$groupPrice=str_replace(THREE_COLON,EMPTY_STRING,$groupPrice);
					if ($groupPrice==COLON)
					{
						$groupPrice=EMPTY_STRING;
					}
				}
				$line.=CSV_TEXTSIGN.$groupPrice.CSV_TERM;
			}
			$desc_sql0=SELECT_ALL.TABLE_PRODUCTS_DESCRIPTION.$where_customers_id.SQL_AND.LANG_ID_EQUAL.HASH;
			for ($i=0;$i<LANGUAGES;$i++)
			{
				$lang_id=$this->languages[$i][ID];
				$desc_sql=str_replace(HASH,$lang_id,$desc_sql0);
				$desc_query=olc_db_query($desc_sql);
				$desc_data=olc_db_fetch_array($desc_query);
				$desc_data[C_DESC]=str_replace($this->new_lines_array,BLANK,$desc_data[C_DESC]);
				$desc_data[C_SHORTDESC]=str_replace($this->new_lines_array,BLANK,$desc_data[C_SHORTDESC]);
				$lang_code=$this->languages[$i][CODE];
				for ($k=0;$k<PROD_DESC_FIELDS;$k++)
				{
					$this->add_customer_desc_field($this->prod_desc_fields_array[$k]);
				}
			}
		}
		fclose($fp);
		$this->result=array($this->counter,EMPTY_STRING,$this->calcElapsedTime($this->time_start));
		*/
	}
}
?>