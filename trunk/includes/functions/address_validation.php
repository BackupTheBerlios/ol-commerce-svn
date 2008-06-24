<?PHP
function IsValidAddress($country_id, &$postcode, $city, $street, $name, $vorname, $fon, $fax, &$message,$not_search_all=false)
{
	/* -----------------------------------------------------------------------------------------
$not_search_all=false)
	$Id: address_validation.php,v 1.0 2005/07/02

	OL-Commerce Version 5.x/AJAX
	http://www.ol-commerce.com, http://www.seifenparadies.de

	Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
	-----------------------------------------------------------------------------------------
	based on:
	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
	(c) 2002-2003 osCommerce(create_account.php,v 1.63 2003/05/28); www.oscommerce.com
	(c) 2003	    nextcommerce (create_account.php,v 1.27 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

	Released under the GNU General Public License
	-----------------------------------------------------------------------------------------
	Third Party contribution:

	Copyright (c) W. Kaiser {w.kaiser@fortune.de)

	Released under the GNU General Public License

	This contribution tries to validate customer adress-data by inquiring the postal offices online postcode-check.

	It submits the city and street-adress to that page, and then check, if the proper postcode ist returned.
	It will also try to resolve the address using the official phonebook.
	If a phone- and/or fax-number is provided, it will try to resolve these numbers by backword-search in th phonebook.

	Multi-page results and changed postcodes/city-names are supported.

	---------------------------------------------------------------------------------------*/
	global $data, $this_postcode, $message, $pos_s, $pos_e, $Len_HTML_COL_END,$messageStack;

	switch ($country_id)
	{
		case '81' or 'D': 		//Germany
		define('BLANK', ' ');
		define('DOT', '.');
		define('SLASH', '/');
		define('DASH', '-');
		define('LPAREN', ' (');
		define('RPAREN', ')');
		define('AREA_CODE_GERMANY', '49');
		define('EREG_ALL', '.*');

		define('VALIDATE_TELEKOM_INVERSE_URL' ,
		'http://www.dasoertliche.de/DB4Web/es/oetb2suche/home.htm?main=Antwort&AKTION=START_INVERS_SUCHE&' .
		'SEITE=INVERSSUCHE_V&s=2&rg=1&SKN=0&SEITE=INVERSSUCHE_V&AKTION=START_SUCHE&kw_invers=');

		if ($not_search_all)
		{
			$this_postcode=$postcode;
			CheckReverse($fon, FON, false);
		}
		else
		{
			define('CHECK_TELEKOM', true);		//Also check TELEKOM directory if POST-search was OK
			//define('CHECK_TELEKOM', false);	//Do not check TELEKOM directory if POST-search was OK

			define('VALIDATE_POST_URL',
			'http://plz1.postdirekt.de/plzserver/PlzSearchServlet?id=streetsearch&lang=de&'.
			'street=#2&no=#3&city=#1&plz=#4&'.SB_START);

			define('VALIDATE_TELEKOM_URL',
			'http://www.4call.dastelefonbuch.de/?sp=55&aktion=23&ao=0&'.
			's=a20000&stype=S&la=de&cmd=search&sim_kw=1&sim_st=1&'.
			'ci=#1&st=#2&hn=#3&kw=#4&fn=#5&pc=#6&ok=#7');

			/*
			http://www.4call.dastelefonbuch.de/?sp=55&aktion=23&kw=24975&s=a20000&stype=S&la=de&taoid=00001010000016606042713081600000016601&cmd=search&ort_ok=0&vert_ok=0&sim_kw=1&fn=&ci=Husby&pc=24975&st=Schleswiger+Str&hn=22&sim_st=1&ok=04634&ao=0&x=43&y=5
			*/

			/*
			Parameter:

			#1 -- Ort
			#2 -- Strasse
			#3 -- Hausnummer
			#4 -- Name
			#5 -- Vorname
			#6 -- Plz
			#7 -- Vorwahl
			*/

			define('PARAM_1', '#1');
			define('PARAM_2', '#2');
			define('PARAM_3', '#3');
			define('PARAM_4', '#4');
			define('PARAM_5', '#5');
			define('PARAM_6', '#6');
			define('PARAM_7', '#7');

			define('COMMA_BLANK', ',' . BLANK);
			define('COLON_BLANK', ':' . BLANK);
			define('HTML_BLANK', '%20');
			define('APOS', APOS);
			define('APOS_BLANK', APOS . BLANK);
			define('BLANK_APOS', BLANK .  APOS);
			//define('EMPTY_STRING', '');

			define('LEFT_MARGIN', '<br/>&nbsp;&nbsp;&nbsp;');
			define('FONT_END', '</b></font>');
			define('SUCCESSFUL0', 'erfolgreich'.FONT_END.BLANK . LPAREN);
			define('SUCCESSFUL', SUCCESSFUL0 . 'Dauer ');
			define('VALIDATION', LEFT_MARGIN . 'Die <b>Online-Validierung</b> ');
			define('RESULT_START', '<font color="blue"><b>');
			define('BACKWARD_SEARCH', LEFT_MARGIN . 'Die <b>Rückwärtssuche</b> der '.RESULT_START);
			define('PHONE_NUMBER', '-Nummer'.FONT_END.' im Telefonbuch der Telekom war ');
			define('RESULT_NOT', ' <font color="red"><u>nicht</u></font> ');
			define('SECONDS', ' Sekunde(n)');
			//define('SB_START', 'sb_start=');
			define('SB_START', 'pagenumber=');
			define('FON', 'Fon');
			define('FAX', 'Fax');

			define('HTML_COL_START', '<td');
			define('HTML_COL_END', '</td>');
			define('HTML_ROW_START', '<tr');
			define('HTML_ROW_END', '</tr>');
			define('HTML_NEW_LINE', NEW_LINE);

			$pos = strrpos($street, DOT);
			if ($pos > 0)
			{
				if ($pos <> strlen($street))
				{
					$s = substr($street, $pos + 1, 1);
					if ( $s <> BLANK );
					{
						if (is_numeric($s))
						{
							$street = substr($street, 0, $pos) . BLANK . substr($street, $pos + 1);
						}
					}
				}
			}
			$i = strpos($city, BLANK);
			if ($i > 0)
			{
				$city = substr($city, 0, $i);
			}
			$message = $name . COMMA_BLANK . $street . COMMA_BLANK . $postcode . BLANK . $city;
			if ($fon <> EMPTY_STRING)
			{
				$message .= COMMA_BLANK . FON . COLON_BLANK . $fon;
			}
			if ($fax <> EMPTY_STRING)
			{
				$message .= COMMA_BLANK . FAX . COLON_BLANK . $fax;
			}
			$pos = strrpos($street, BLANK);
			if ($pos != 0)
			{
				$street_len=strlen($street);
				if ($pos==($street_len-2))
				{
					$s = substr($street_number, $pos, 1);
					if (!is_numeric($s))
					{
						$pos = strrpos(substr($street,0,$pos-1), BLANK);
					}
				}
				$street_number = substr($street, $pos + 1);
				$s = EMPTY_STRING;
				for ($i = strlen($street_number) -1 ; $i >= 0; $i--)
				{
					$s = substr($street_number, $i, 1);
					if ((is_numeric($s)))
					{
						$street_number = substr($street_number, 0 , $i + 1);
						break;
					}
				}
				if (is_numeric($street_number))
				{
					$street = substr($street, 0, $pos);
					//$street_number=str_replace(BLANK,'',$street_number);
				}
				else
				{
					$street_number = EMPTY_STRING;
				}
			}
			$url0 = str_replace(PARAM_1, $city, VALIDATE_POST_URL);
			$url0 = str_replace(PARAM_2, $street, $url0);
			$url0 = str_replace(PARAM_3, $street_number, $url0);
			$url0 = str_replace(PARAM_4, $postcode, $url0);
			$url0 = str_replace(BLANK, HTML_BLANK, $url0);
			$loop = 0;
			$time_start = microtime_float();
			while (true)
			{
				$loop++;
				//$url = $url0 . ($loop - 1) * 20;
				$url = $url0 . $loop;
				$data = get_html_page($url);
				//$data = file_get_contents($url);
				$pos_s = strpos($data, 'Ortsname');
				if ($pos_s == 0)
				{
					//return false;
					$message = $message . HTML_NEW_LINE ."Die Suche mit '".$url0."' lieferte kein Ergebnis";
					break;
				}
				else
				{
					//if ( more pages are available, then the text "sb_start=nn" is included in page
					//$all_done = strpos($data, SB_START . ($loop * 20)) == 0;
					$all_done = strpos($data, SB_START . ($loop+1)) == 0;
					$no_postcode = strpos($data, $postcode) === false;
					$entry_found = false;
					//Find first entry end (head line)
					$pos_s=0;
					$pos_e = strpos($data, HTML_ROW_START, $pos_s);
					if ($pos_e > 0)
					{
						$value_start = array(HTML_ROW_START);
						$entries = sizeof($value_start) - 1;
						for ($entry = 0; $entry <= $entries; $entry++)
						{
							$entry_start = $value_start[$entry];
							$len_HTML_COL_END = strlen(HTML_COL_END);
							while (true)
							{
								//Find entry start (postcode)
								$pos_e = strpos($data, $entry_start, $pos_e);
								if ($pos_e > 0)
								{
									$this_postcode = get_next_col();
									if ($this_postcode != EMPTY_STRING)
									{
										if ($this_postcode == "---")
										{
											//PLZ/Ort hat sich geändert!
											for ($i = 1; $i <= 3; $i++)
											{
												$this_postcode = get_next_col();
												$pos = strpos($this_postcode, $postcode);
												if ($pos > 0)
												{
													$pos = strpos($this_postcode, BLANK);
													if ($pos>0)
													{
														$city = substr($this_postcode, $pos + 1);
														$this_postcode = substr($this_postcode, $pos - 1);
													}
												}
												break;
											}
										}
									}
									if (substr($this_postcode,0,5) == $postcode)
									{
										$entry_found = true;
										$all_done = true;
										break;
									}
									else
									{
										if ($no_postcode)
										{
											$this_postcode_save = $this_postcode;
											//Get city;
											$this_city = get_next_col();
											$i = strpos($this_city, BLANK);
											if ($i > 0)
											{
												$this_city = substr($this_city, 0, $i);
											}
											if ($this_city == $city)
											{
												//Get street
												$this_street = get_next_col();
												$i = InStr($this_street, BLANK);
												if ($i > 0)
												{
													$this_street = substr($this_street, 0, $i);
												}
												$i = InStr($street, BLANK);
												if ($i > 0)
												{
													$street = substr($street, 0, $i);
												}
												if ($this_street == $street)
												{
													$message = $message . LEFT_MARGIN . "Die Postleitzahl wurde von" .
													BLANK_APOS . $postcode . APOS_BLANK . "zu" .
													BLANK_APOS . $this_postcode_save . APOS_BLANK . "geändert";
													$postcode = $this_postcode_save;
													$entry_found = true;
													$all_done = true;
													break;
												}
											}
										}
										//Find end-of_row
										$pos_e = strpos($data, HTML_ROW_END, $pos_e);
										if ($pos_e == 0)
										{
											break;
										}
									}
								}
								else
								{
									break;
								}
							}
							if ($entry_found)
							{
								break;
							}
						}
						if ($entry_found || $all_done)
						{
							break;
						}
					}
				}
				if ($all_done)
				{
					break;
				}
			}
			$time_end = microtime_float();
			$time = round($time_end - $time_start);
			$result = RESULT_START;
			if (!$entry_found)
			{
				$result .= RESULT_NOT;
			}
			$message = VALIDATION .'von PLZ, ORT und STRASSE über die PLZ-Suche der Post war ' .
			$result . SUCCESSFUL0 . $loop .  ' Ergebnisseite(n) in ' . $time . SECONDS . ' untersucht).';
			if (CHECK_TELEKOM)
			{
				if (true || $entry_found)
				{
					$url = str_replace(PARAM_1, $city, VALIDATE_TELEKOM_URL);
					$url = str_replace(PARAM_2, $street, $url);
					$url = str_replace(PARAM_3, $street_number, $url);
					//$url = str_replace(PARAM_4, $postcode, $url);
					$pos = strrpos($name, BLANK);
					if ($pos > 0)
					{
						$name = substr($name, $pos + 1);
					}
					$url = str_replace(PARAM_4, $name, $url);
					//$url = str_replace(PARAM_5, $vorname, $url);
					$url = str_replace(PARAM_5, "", $url);
					$url = str_replace(PARAM_6, $postcode, $url);
					if (strlen($fon)>0)
					{
						$pos=strpos($fon,"/");
						if ($pos===false)
						{
							$pos=strpos($fon,"-");
							if ($pos===false)
							{
								$pos=strpos($fon,BLANK);
							}
						}
						if (!($pos===false))
						{
							$url = str_replace(PARAM_7,substr($fon,0,$pos), $url);
						}
					}
					$url = str_replace(BLANK, HTML_BLANK, $url);
					$time_start = microtime_float();
					$data = get_html_page($url);
					$time_end = microtime_float();
					$time = round($time_end - $time_start);
					$entry_found = strpos($data, 'Systemfehler') == 0;
					if ($entry_found)
					{
						$entry_found = eregi('<strong> ' . EREG_ALL . $name, $data) <> 0;
					}
					$result = RESULT_START;
					if ($entry_found)
					{
						$error_state="success";
					}
					else
					{
						$result .= RESULT_NOT;
						$error_state="error";
					}
					$message .= VALIDATION .' im Telefonbuch der Telekom war ' . $result . SUCCESSFUL . $time .  SECONDS . RPAREN;
					$this_postcode=$postcode;
					CheckReverse($fon, FON);
					CheckReverse($fax, FAX);
					$message .= '
<p align="center">
	<b><a href="" onclick="javascript:document.getElementById(\'messageStack_messageBox\').style.display=\'none\';return false">Meldung ausblenden</a></b>
</p>
					';
					check_input_error(true, $message);
				}
			}
		}
		return $entry_found;

		case 'A':;
		return true;

		break;

		case 'CH':;
		return true;

		break;

		default:
		return true;
	}
}


function get_html_page($url)
{
	$time_start = microtime_float();
	$data = EMPTY_STRING;
	$fp = fopen($url, "rb");
	if ($fp)
	{
		while (!feof($fp)) {
			$data .= fread($fp, 16384);
		}
		fclose($fp);
		$time_end = microtime_float();
		$time = round($time_end - $time_start);
		$time = $time;
	}
	return $data;
}

function get_next_col()
{
	global $data, $pos_s, $pos_e, $Len_HTML_COL_END;

	$this_postcode = EMPTY_STRING;
	//Find Entry start ($postcode)
	$pos_s = strpos($data, HTML_COL_START, $pos_e);
	if ($pos_s > 0)
	{
		//Find Entry end ($postcode)
		$pos_e = strpos($data, HTML_COL_END, $pos_s);
		if ($pos_e  > 0)
		{
			//Get entry (postcode)
			$this_postcode = strip_tags(substr($data, $pos_s, $pos_e + $len_HTML_COL_END - $pos_s));
			$this_postcode = html_entity_decode($this_postcode);
			return trim(str_replace(HTML_NBSP, EMPTY_STRING, $this_postcode));
		}
	}
}

function check_input_error($entry_error_condition, $entry_error_text)
{
	global $messageStack, $IsUserMode, $error, $message;

	if ($entry_error_condition) {
		$error = true;
		if ($IsUserMode)
		{
			$messageStack->add(MESSAGE_STACK_NAME, $entry_error_text);
		}
		else
		{
			$messageStack->add($entry_error_text);
		}
	}
	return $entry_error_condition;
}

function CheckReverse($nr,$type,$add_message=true)
{
	global $this_postcode,$name,$message;

	$entry_found = false;
	if (strlen($nr) >= 8)
	{
		$nr = str_replace( BLANK, EMPTY_STRING, trim($nr));
		$nr = str_replace( DOT, EMPTY_STRING, $nr);
		$nr = str_replace( SLASH, EMPTY_STRING, $nr);
		$nr = str_replace( DASH, EMPTY_STRING, $nr);
		$nr = str_replace( LPAREN, EMPTY_STRING, $nr);
		$nr = str_replace( RPAREN, EMPTY_STRING, $nr);
		if (substr($nr, 0, 2) == AREA_CODE_GERMANY)
		{
			$nr = substr($nr, 2);
		}
		$url = VALIDATE_TELEKOM_INVERSE_URL . $nr;
		$time_start = microtime_float();
		$data = get_html_page($url);
		$time_end = microtime_float();
		$time = round($time_end - $time_start);
		if ($data <> EMPTY_STRING)
		{
			$entry_found = eregi(EREG_ALL . $nr . EREG_ALL, $data) <> 0;
			if ($entry_found)
			{
				$entry_found = eregi(EREG_ALL . $name . EREG_ALL, $data) <> 0;
			}
			if ($add_message)
			{
				$result = RESULT_START;
				if (!$entry_found)
				{
					$result .= RESULT_NOT;
				}
				$this_message=BACKWARD_SEARCH . $type . PHONE_NUMBER . $result . SUCCESSFUL . $time .  SECONDS . RPAREN;
				$message = $message . HTML_NEW_LINE .$this_message;
			}
		}
	}
	return $entry_found;
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