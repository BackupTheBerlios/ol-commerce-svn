<?php
//W. Kaiser - AJAX
/* -----------------------------------------------------------------------------------------
$Id: ajax_validation.php,v 1.1.1.1.2.1 2007/04/08 07:16:08 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

AJAX = Asynchronous JavaScript and XML
Info: http://de.wikipedia.org/wiki/Ajax_(Programmierung)

AJAX online field validation routine

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de), w.kaiser@fortune.de

-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.18 2003/02/10); www.oscommerce.com
(c) 2003	  	nextcommerce (shopping_cart.php,v 1.15 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------
*/

//Validate forms-data vs. database
require_once('inc/olc_define_global_constants.inc.php');
$action_text='action';
$value_text='value';
$caption_text='caption';
$extra_parameter_text='extra_parameter';
$land_text='land';
$action=$_POST[$action_text];
if ($action)
{
	$current_value=trim($_POST[$value_text]);
	$caption0=$_POST[$caption_text];
	$extra_parameter=trim($_POST[$extra_parameter_text]);
	$land=$_POST[$land_text];
}
else
{
	$action=$_GET[$action_text];
	$current_value=trim($_GET[$value_text]);
	$caption0=$_GET[$caption_text];
	$extra_parameter=trim($_GET[$extra_parameter_text]);
	$land=$_GET[$land_text];
}
define('PHP','.php');
define('INC_PHP','.inc.php');
if ($action==EMPTY_STRING)
{
	echo "Unzul�ssiger Programm-Aufruf!";
}
else
{
	$percent_text="%";
	$customers_firstname="customers_firstname";
	$customers_country="customers_country";
	$banktransfer_number="banktransfer_number";
	$entry_postcode="entry_postcode";
	$banktransfer_blz="banktransfer_blz";
	$entry_state_text="entry_state";
	$customers_email_address_text="customers_email_address";
	$error_fatal=false;
	$table="banktransfer_blz";
	$sql_select_data="blz";
	$caption=$caption0;
	$is_germany=$land=="D";
	$is_austria=$land=="A";
	$is_switzerland=$land=="CH";

	$add_land_condition=true;
	$not_add_state_info=true;
	include('includes/configure.php');
	require_once(DIR_FS_INC.'ajax_error.inc.php');
	define("NEWLINE",NEW_LINE.HTML_BR);
	$value_text="value";
	switch ($action)
	{
		case customers_email_address:
			//"customers_email"
			global $valid_email;

			define('ENTRY_EMAIL_ADDRESS_CHECK',TRUE_STRING_S);
			require_once(DIR_WS_FUNCTIONS.'compatibility.php');
			require_once(DIR_FS_INC.'olc_not_null.inc.php');
			require_once(DIR_FS_INC.'olc_validate_email.inc.php');
			if (olc_validate_email($current_value))
			{
				//All OK, just exit
				echo EMPTY_STRING;
				exit();
			}
			else
			{
				$main_content="Die ".$caption." '".$current_value."' ";
				$add_on_delimiter=HASH.$value_text.HASH;
				$add_on = $add_on_delimiter.$current_value.$add_on_delimiter;
				if ($valid_email)
				{
					$main_content=split(ATSIGN,$current_value);
					$entry_state_text=$main_content[1];
					if (strlen($entry_state_text)>0)
					{
						$entry_state_text=APOS.$entry_state_text."' ";
					}
					$main_content.="wird vom Mailserver ".$entry_state_text."als unbekannt klassifiziert.";
					$error_fatal=false;
				}
				else
				{
					$main_content.="hat ein ung�ltiges Format.";
					$error_fatal=true;
				}
				ajax_error($main_content,$error_fatal,$caption,$add_on);
			}
		case customers_telephone:
			//"customers_telephone"
			$parameter=explode('|',$extra_parameter);  //Plz|Name
			$postcode=$parameter[0];
			$name=$parameter[1];
			$fon=$current_value;
			require_once(DIR_WS_FUNCTIONS . 'address_validation.php');
			if (IsValidAddress($land, $postcode, EMPTY_STRING, EMPTY_STRING, $name, EMPTY_STRING, $fon,
				EMPTY_STRING,$parameter,true))
			{
				//All OK, just exit
				echo EMPTY_STRING;
				exit();
			}
			else
			{
				$add_on_delimiter=HASH.$value_text.HASH;
				$add_on = $add_on_delimiter.$current_value.$add_on_delimiter;
				$main_content="Die ".$caption." '".$current_value."' konnte im Telefonbuch der Telekom nicht gefunden werden!";
				ajax_error($main_content,false,$caption,$add_on);
			}
		case customers_firstname:
			//"customers_gender"
			$field_name_vorname="vorname";
			$field_name_geschlecht="geschlecht";
			$gender_male="m";
			$gender_female="w";
			if ($extra_parameter=='f')
			{
				$extra_parameter=$gender_female;
			}
			$gender_both="n";
			$gender_unknown=EMPTY_STRING;

			$weiblich="weiblich";
			$m�nnlich="m�nnlich";
			$both=$m�nnlich."/".$weiblich;
			$unknown="unbekannt";

			$add_land_condition=false;
			$table="vornamen";
			//Clean Vornamen
			//Try to split multiple firstnames into individual parts
			//and find individual names
			//$current_value=str_replace(DOT, EMPTY_STRING, $current_value);
			$vornamen=explode('[ -,]',$current_value);
			$vornamen_count=count($vornamen);
			if ($vornamen_count>1)
			{
				//Find separators and build sql
				$sql_where_condition=EMPTY_STRING;
				for ($i=1;$i<$vornamen_count-1;$i++)
				{
					$s=$vornamen[i];
					$pos=strpos($current_value,$s);
					$separator[]=substr($current_value,$pos-1,1);
					if (strlen($s)>1)
					{
						$nr_of_vornamen++;
						if (strlen($sql_where_condition)>0)
						{
							$sql_where_condition.SQL_OR;
						}
						$sql_where_condition.=$s;
					}
				}
			}
			$current_value=str_replace(array(BLANK,DASH,COMMA,DOT), $percent_text, $current_value);
			$sql_select_data="vorname";
			break;
		case entry_postcode:
			$table="plz";
			$field_name_plz=$table;
			$field_name_ort="ort";
			$field_name_state="bundesland";
			$field_name_vorwahl="vorwahl";
			$store_country_text='store_country';
			$store_country=$_POST[$store_country_text];
			if (!$store_country)
			{
				$store_country=$_GET[$store_country_text];
			}
			$sql_select_data=$table;
			//$add_state_info=$current_value==$percent_text;
			$not_add_state_info=!$add_state_info;
			$selection_value=EMPTY_STRING;
			if ($is_germany)
			{
				if ($store_country<>81)
				{
					$country_select='49';
				}
				$check_state=true;
				$state_names=array(
				"Schleswig-Holstein",				//L�nderkennung 01.
				"Hamburg",									//L�nderkennung 02.
				"Niedersachsen",						//L�nderkennung 03.
				"Bremen",										//L�nderkennung 04.
				"Nordrhein-Westfalen",			//L�nderkennung 05.
				"Hessen",										//L�nderkennung 06.
				"Rheinland-Pfalz",					//L�nderkennung 07.
				"Baden-W�rttemberg",				//L�nderkennung 08.
				"Bayern",										//L�nderkennung 09.
				"Saarland",									//L�nderkennung 10.
				"Berlin",										//L�nderkennung 11.
				"Brandenburg",							//L�nderkennung 12.
				"Mecklenburg-Vorpommern",		//L�nderkennung 13.
				"Sachsen",									//L�nderkennung 14.
				"Sachsen-Anhalt",						//L�nderkennung 15.
				"Th�ringen"									//L�nderkennung 16.
				);
				/*
				//For germany, we have also the informationen on the state, to which the plz belongs
				//Assignment of DB-state-ids to olc-state-ids
				$state_ids=array(
				93,	//Schleswig-Holstein
				85,	//Hamburg
				79,	//Niedersachsen
				84,	//Bremen
				88,	//Nordrhein-Westfalen
				86,	//Hessen
				89,	//Rheinland-Pfalz
				80,	//Baden-W�rttemberg
				81,	//Bayern
				90,	//Saarland
				82,	//Berlin
				83,	//Brandenburg
				87,	//Mecklenburg-Vorpommern
				91,	//Sachsen
				92,	//Sachsen-Anhalt
				94,	//Th�ringen
				);
				*/
			}
			else if ($is_austria)
			{
				if ($store_country<>14)
				{
					$country_select='43';
				}
				$check_state=true;
				$state_names=array(
					"Wien",								//L�nderkennung 1
					"Nieder�sterreich",		//L�nderkennung 2
					"Ober�sterreich",			//L�nderkennung 3
					"Salzburg",						//L�nderkennung 4
					"K�rnten",						//L�nderkennung 5
					"Steiermark",					//L�nderkennung 6
					"Tirol",							//L�nderkennung 7
					"Burgenland",					//L�nderkennung 8
					"Voralberg"						//L�nderkennung 9
				);
				/*
				//For austria, we have also the informationen on the state, to which the plz belongs
				//Assignment of DB-state-ids to olc-state-ids
				$state_ids=array(
				95,		//Wien
				96,		//Nieder�sterreich
				97,		//Ober�sterreich
				98,		//Salzburg
				99,		//K�rnten
				100,	//Steiermark
				101,	//Tirol
				102,	//Burgenland
				103,	//Voralberg
				);
				*/
			}
			else if ($is_switzerland)
			{
				if ($store_country<>204)
				{
					$country_select='41';
				}
				$check_state=true;
				$state_names=array(
				"Aargau",									//L�nderkennung 01
				"Appenzell Innerrhoden",	//L�nderkennung 02
				"Appenzell Ausserrhoden",	//L�nderkennung 03
				"Bern",										//L�nderkennung 04
				"Basel-Landschaft",				//L�nderkennung 05
				"Basel-Stadt",						//L�nderkennung 06
				"Freiburg",								//L�nderkennung 07
				"Genf",										//L�nderkennung 08
				"Glarus",									//L�nderkennung 09
				"Graub�nden",						  //L�nderkennung 10
				"Jura",										//L�nderkennung 11
				"Luzern",									//L�nderkennung 12
				"Neuenburg",							//L�nderkennung 13
				"Nidwalden",							//L�nderkennung 14
				"Obwalden",								//L�nderkennung 15
				"St. Gallen",							//L�nderkennung 16
				"Schaffhausen",						//L�nderkennung 17
				"Solothurn",							//L�nderkennung 18
				"Schwyz",									//L�nderkennung 19
				"Thurgau",								//L�nderkennung 20
				"Tessin",									//L�nderkennung 21
				"Uri",										//L�nderkennung 22
				"Waadt",									//L�nderkennung 23
				"Wallis",									//L�nderkennung 24
				"Zug",										//L�nderkennung 25
				"Z�rich",									//L�nderkennung 26
				"Deutschland",						//L�nderkennung 27
				"Italien",								//L�nderkennung 28
				"Liechtenstein"						//L�nderkennung 29
				);
				/*
				//For switzerland, we have also the informationen on the state, to which the plz belongs
				//Assignment of DB-state-ids to olc-state-ids
				$state_ids=array(
					104,	//AG (Aargau)
					105,	//AI (Appenzell Innerrhoden)
					106,	//AR (Appenzell Ausserrhoden)
					107,	//BE (Bern)
					108,	//BL (Basel-Landschaft)
					109,	//BS (Basel-Stadt)
					110,	//FR (Freiburg)
					111,	//GE (Genf)
					112,	//GL (Glarus)
					113,	//GR (Graub�nden)
					114,	//JU (Jura)
					115,	//LU (Luzern)
					116,	//NE (Neuenburg)
					117,	//NW (Nidwalden)
					118,	//OW (Obwalden)
					119,	//SG (St. Gallen)
					120,	//SH (Schaffhausen)
					121,	//SO (Solothurn)
					122,	//SZ (Schwyz)
					123,	//TG (Thurgau)
					124,	//TI (Tessin)
					125,	//UR (Uri)
					126,	//VD (Waadt)
					127,	//VS (Wallis)
					128,	//ZG (Zug)
					129,	//ZH (Z�rich)
					130,	//DE (Deutschland),
					131,	//IT (Italien),
					132,	//FL (Liechtenstein)
				);
				*/
			}
			else
			{
				$check_state=true;
			}
			break;
		case banktransfer_blz or banktransfer_number:
			$is_bank_check=true;
			$field_name_blz="blz";
			//$field_name_bank="bank";
			$field_name_bank="bankname";
			$selection=$field_name_blz.", ".$field_name_bank;
			if ($action==banktransfer_number)
			{
				$konto_nummer=$current_value;
				$blz=$extra_parameter;
				$current_value=$blz;
				$field_name_prkz="prz";
				$selection.=", ".$field_name_prkz;
			}
			break;
		case entry_city:
			$add_state_info=true;
		default:
			$error_fatal=true;
	}

	$main_content=EMPTY_STRING;
	if ($error_fatal)
	{
		$main_content="Unzul�ssige Validierungs-Aktion '" . $action . APOS;
	}
	else
	{
		require_once(DIR_FS_INC.'olc_db_query.inc.php');
		require_once(DIR_FS_INC.'olc_db_connect.inc.php');
		// make a connection to the database
		if (!olc_db_connect())
		{
			//If DB-error just forget about validation
			echo EMPTY_STRING;
			exit();
		}
		//require_once(DIR_FS_INC.'olc_db_close.inc.php');
		require_once(DIR_FS_INC.'olc_db_fetch_array.inc.php');
		require_once(DIR_FS_INC.'olc_db_num_rows.inc.php');
		$prefix_only=true;
		require_once(DIR_WS_INCLUDES .'database_tables.php');
		$sql_select="SELECT DISTINCT ";
		if ($action==$entry_state_text)
		{
			require_once(DIR_FS_INC.'olc_parse_input_field_data.inc.php');
			$zone_id= 'zone_id';
			$zone_name='zone_name';
			$db_data_query = olc_db_query($sql_select.$zone_id.COMMA.$zone_name.SQL_FROM . TABLE_PREFIX_COMMON  . 'zones'.
				" where zone_country_id = '".$current_value."' order by ".$zone_name);
			$rows=olc_db_num_rows($db_data_query);
			if ($rows >= 1)
			{
				$id='id';
				$text='text';
				while ($value = olc_db_fetch_array($db_data_query))
				{
					$zones_array[] = array($id => $value[$zone_id] , $text => $value[$zone_name]);
				}
				if ($rows > 1)
				{
					require_once(DIR_FS_INC.'olc_not_null.inc.php');
					require_once(DIR_FS_INC.'olc_draw_pull_down_menu.inc.php');
					$main_content=olc_draw_pull_down_menu('entry_state', $zones_array);
				}
				else
				{
					require_once(DIR_FS_INC.'olc_draw_input_field.inc.php');
					$main_content=olc_draw_input_field($entry_state_text, $zones_array[0]['text']);
				}
			}
			else
			{
				$main_content=HTML_NBSP;
			}
			$build_selection=true;
		}
		else
		{
			$check_banktransfer_number=$action==$banktransfer_number;
			$current_value=str_replace("*","%",$current_value);
			$sql_where_condition= $sql_select_data . SQL_LIKE .APOS . $current_value . HASH.APOS;
			if ($add_land_condition)
			{
				$sql_where_condition .= SQL_AND."land = '" . $land . APOS;
			}
			if (!$is_bank_check)
			{
				$selection="*";
			}
			$sql_command0 = $sql_select.$selection.SQL_FROM . TABLE_PREFIX_COMMON . $table .
			SQL_WHERE.LPAREN . $sql_where_condition  . RPAREN;
			//First try exact match
			$sql_command=str_replace(HASH,$value,$sql_command0);
			$db_data_query = olc_db_query($sql_command);
			$rows=olc_db_num_rows($db_data_query);
			if ($rows == 0)
			{
				//Try wider range, if not already wildcard included
				$use_wide_range=strpos($current_value,$percent_text)===false;
				if ($use_wide_range)
				{
					$sql_command=str_replace(HASH,$percent_text,$sql_command0);
					$db_data_query = olc_db_query($sql_command);
					$rows=olc_db_num_rows($db_data_query);
				}
			}
			if ($rows > 0)
			{
				$build_selection=$rows > 1;
				if ($build_selection)
				{
					$select_box_id = $action . '_select_box';
					$selection_box=
					'<select size="1" onchange="selection_done(\''.$select_box_id.'\');" id="' .
					$select_box_id . '">#</select>';
					$option_start0='<option';
					if ($not_add_state_info)
					{
						$option_start0.=' value="#"';
					}
					$option_start0.='>';
					$option_end='</option>';
					$select_options=$option_start0."Bitte treffen Sie Ihre Auswahl".$option_end;
					$sep=" - ";
				}
				while ($db_data = olc_db_fetch_array($db_data_query))
				{
					switch ($action)
					{
						case customers_firstname:
							$current_value = $db_data[$field_name_vorname];
							$db_gender=strtolower(trim($db_data[$field_name_geschlecht]));
							$gender_ok=false;
							if ($db_gender==$gender_male)
							{
								$gender_stored=$m�nnlich;
							}
							elseif ($db_gender==$gender_female)
							{
								$gender_stored=$weiblich;
							}
							elseif ($db_gender==$gender_both)
							{
								$gender_stored=$both;
								$gender_ok=true;
							}
							else
							{
								$gender_stored=$unknown;
								$gender_ok=true;
							}
							if ($build_selection)
							{
								$select_option = $current_value . $sep . $gender_stored;
								$selection_value=$current_value;
							}
							break;
						case entry_postcode:
							$current_value = $db_data[$field_name_plz];
							$add_on=$db_data[$field_name_ort];
							$state=$db_data[$field_name_state]-1;
							$state=$state_names[$state];
							$vorwahl=$db_data[$field_name_vorwahl];
							if ($country_select)
							{
								$vorwahl=$country_select.'-(0)'.substr($vorwahl,1);
							}
							if ($build_selection)
							{
								$select_option = $current_value . $sep . $add_on;
								//$selection_value=$select_option.$sep.$state;
								if ($add_state_info)
								{
									$select_option .= $sep . $state;
									if ($vorwahl)
									{
										$select_option .= $sep . $vorwahl;
									}
								}
								else
								{
									$selection_value=$state;
									if ($vorwahl)
									{
										$selection_value .= $sep . $vorwahl;
									}
								}
							}
							break;
						case banktransfer_blz or banktransfer_number:
							$current_value = $db_data[$field_name_blz];
							$add_on=$db_data[$field_name_bank];
							if ($build_selection)
							{
								$select_option = $current_value . $sep . $add_on;
								$selection_value=$add_on;
							}
							elseif ($check_banktransfer_number)
							{
								$bank_prz=$db_data[$field_name_prkz];
							}
							break;
					}
					if ($build_selection)
					{
						$option_start=$option_start0;
						if ($not_add_state_info)
						{
							$option_start=str_replace(HASH,$selection_value,$option_start);
						}
						$select_options.=$option_start . $select_option . $option_end;
					}
				}
				$caption.=" '".$current_value."' ";
				if ($build_selection)
				{
					$main_content=str_replace(HASH,$select_options,$selection_box);
					$main_content.=NEWLINE.'<font size="1" color="red">'.$rows.
					' Auswahloptionen f�r "'.$caption0.'"</font>'.NEWLINE.
					'<font size="1"><a href="javascript:selection_box_hide('.
					$action . '_select)">Auswahlbox schlie�en</a></font>';
					$add_on=EMPTY_STRING;
					$selection_start=NEWLINE;
				}
				else
				{
					switch ($action)
					{
						case customers_firstname:
							//Check gender
							if (($extra_parameter==$db_gender) || $gender_ok)
							{
								//All OK, just exit
								echo EMPTY_STRING;
								exit();
							}
							else
							{
								if ($db_gender==$gender_male)
								{
									$gender_stored=$m�nnlich;
									$gender_input="Frau";
								}
								elseif ($db_gender==$gender_female)
								{
									$gender_input="Herr";
									$gender_stored=$weiblich;
								}
								$error_recoverable=true;
								$main_content="Der ".$caption." ist �blicherweise ".$gender_stored;
								$main_content.=", Sie haben jedoch die Anrede '".$gender_input."' gew�hlt.";
							}
							break;
						case entry_postcode:
							$ort_delimiter=HASH."ort".HASH;
							$add_on = $ort_delimiter.$add_on.$ort_delimiter;
							if ($state)
							{
								$state_delimiter=HASH."state".HASH;
								$add_on .= NEWLINE.$state_delimiter.$state.$state_delimiter;
							}
							if ($vorwahl)
							{
								$vorwahl_delimiter=HASH."vorwahl".HASH;
								$add_on .= NEWLINE.$vorwahl_delimiter.$vorwahl.$vorwahl_delimiter;
							}
							break;
						case banktransfer_blz:
							//"banktransfer_bankname"
							$bank_delimiter=HASH."bank".HASH;
							$add_on = $bank_delimiter.$add_on.$bank_delimiter;
							break;
						case banktransfer_number:
							if ($bank_prz)
							{
								//Validate account-number
								// Include kontonummer-validation class
								require_once(DIR_WS_CLASSES . 'banktransfer_validation.php');

								$banktransfer_validation = new AccountCheck;
								$banktransfer_result =
								$banktransfer_validation->CheckAccount($konto_nummer,$blz,$add_on,$bank_prz);
								if ($banktransfer_result > 0)
								{
									$current_value=$konto_nummer;
									$konto_nummer="Kontonummer '".$konto_nummer. "' ";
									$main_content="Die ".$konto_nummer."ist f�r die BLZ '".$extra_parameter."' (".$add_on.") nicht g�ltig!";
									$caption=BLANK.$konto_nummer;

									$error_recoverable=true;	//Recoverable, allow acceptance anyway!
									//$error_fatal=true;			//Not recoverable, do not allow acceptance
								}
								else
								{
									//Valid #, just exit
									echo EMPTY_STRING;
									exit();
								}
							}
							else
							{
								//No check possible, just exit
								echo EMPTY_STRING;
								exit();
							}
					}
				}
			}
			else
			{
				$caption.=" '".$current_value."' ";
				$main_content=$caption."nicht gefunden!";
				if ($use_wide_range)
				{
					$error_fatal=true;
				}
				else
				{
					$error_recoverable=true;
				}
			}
		}
		if ($build_selection)
		{
			$select_box_id= HASH . "select_box" . HASH;
			$main_content = $select_box_id.$selection_start.$main_content.$selection_start.$select_box_id;
		}
	}
	if ($error_fatal || $error_recoverable)
	{
		//		$error_fatal_delimiter = HASH."fatal_error".HASH;
		//		$main_content = $error_fatal_delimiter. $main_content . $error_fatal_delimiter;
		if ($error_recoverable)
		{
			$add_on_delimiter=HASH.$value_text.HASH;
			$add_on = $add_on_delimiter.$current_value.$add_on_delimiter;
		}
		else
		{
			$add_on = EMPTY_STRING;
		}
		ajax_error($main_content,$error_fatal,$caption,$add_on);
	}
	else
	{
		define('IS_AJAX_PROCESSING',true);
		//define('USE_AJAX_SHORT_LIST_ONLY',false);
		define('AJAX_BUILD_INDEX',false);
		define('AJAX_TITLE',EMPTY_STRING);

		$action_text="action";
		$main_content_text="main_content";
		$add_on_text="add_on";

		define('AJAX_DATA_ELEMENTS_TO_CHANGE',
		$action_text . BLANK .
		$value_text .BLANK .
		$main_content_text .BLANK .
		$add_on_text)
		;
		// Include Template Engine
		require_once(DIR_WS_CLASSES.'smarty/Smarty.class.php');
		require_once(DIR_FS_INC.'olc_smarty_init.inc.php');
		$admin_text='admin';
		$admin=$_POST[$admin_text];
		if (!isset($admin))
		{
			$admin=$_GET[$admin_text];
		}
		if ($admin)
		{
			$admin='../';
		}
		else
		{
			$admin=EMPTY_STRING;
		}
		define('ADMIN_PATH_PREFIX',$admin);
		olc_smarty_init($smarty,$cacheid,false);
		$smarty->assign($action_text, $action);
		$smarty->assign($value_text, $current_value);
		if (strlen($add_on)>0)
		{
			$smarty->assign($add_on_text, $add_on);
		}
		$smarty->assign($main_content_text, $main_content);
		define('CURRENT_SCRIPT',basename($_SERVER['PHP_SELF']));
		define('FILENAME_AJAX_VALIDATION','ajax_validation.php');
		define('INDEX_HTML','index.html');
		$smarty->fetch(INDEX_HTML);
	}
	//W. Kaiser - AJAX
}
?>