<?PHP
/* --------------------------------------------------------------
$Id: xxc_import.php,v 1.1.1.1.2.1 2007/04/08 07:16:34 gswkaiser Exp $

Automatically import xxCommerce compatible data into OL-Commerce database

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

Not(!!!) released under the GNU General Public License

This programm is licensed  o n l y(!)  to be used for the purpose of importing data into the "OL-Commerce" database from version v2/AJAX on.

Usage for importing data into other "xxCommerce"-based systems then "OL-Commerce" is explicitely  n o t(!) covered by the license!

Any copyright infringement will be legally prosecuted!

--------------------------------------------------------------*/

function binary_search($array, $element)
{
	/** Returns true or false */
	$low = 0;
	$high = count($array) - 1;
	while ($low <= $high)
	{
		$mid = floor(($low + $high) / 2);  // C floors for you
		$result=strnatcmp($element, $array[$mid]);
		if ($result==0)
		{
			//return $array[$mid];
			//We only need to know, if the element is in the array, not the element itself
			return true;
		}
		else
		{
			if ($result<0)
			{
				$high = $mid - 1;
			}
			else
			{
				$low = $mid + 1;
			}
		}
	}
	return false;  // $element not found
}

function myMicrotime($get_as_float = false)
{
	list($msec, $sec) = explode(BLANK, microtime());
	$time = $sec . substr($msec, 1);
	return $as_float === false ? $time : (float)$time;
}

define('ATSIGN','@');

require('includes/application_top.php');
if (CUSTOMER_ID==1)
{
	define('OLCOMMERCE_SQL',ADMIN_PATH_PREFIX.'olc_installer/prefix_olcommerce.sql');
	$page_header_title='OL-Commerce Datenbank-Import';
	$page_header_subtitle='Automatische Übernahme <font color="Red">xxCommerce</font>-kompatibler Datenbestände';
	$page_header_icon_image=HEADING_MODULES_ICON;
	$show_column_right=true;
	$error0='
<p>
	<font color="Red"><b>#</b></font></p>
<p>
';
	$pos=file_exists(OLCOMMERCE_SQL);
	if ($pos)
	{
		$file_size='<b>Max. Dateigröße: '.number_format(ini_get('upload_max_filesize')*1024, 0, EMPTY_STRING, DOT).' KB</b>';
		$process=$_POST['action']=='process';
		if ($process)
		{

			//$cleanup=$_POST['cleanup']=='on';
			$p_777='777';
			$dir=ADMIN_PATH_PREFIX.'cache/cache'.SLASH;
			$error1='Geben Sie bitte den Dateinamen des #-Datenbank ein!<br/>'.HTML_NBSP.HTML_NBSP.
			'<font color="Blue">(Möglicherweise ist die Datei auch größer als die '.	$file_size.
			', und wird deshalb nicht geladen)</font>';
			if ($olc_file = new upload('olc', $dir, $p_777,EMPTY_STRING, true))
			{
				$olc_file_name = $olc_file->filename;
				if ($olc_file_name )
				{
					$olc_file_name=$dir.$olc_file_name;
				}
				else
				{
					$process=false;
					$error=str_replace(HASH,'Struktur-Dumps der OL-Commerce',$error1);
				}
			}
			if ($import_file = new upload('import', $dir, $p_777,EMPTY_STRING, true))
			{
				$import_file_name = $import_file->filename;
				if ($import_file_name)
				{
					$import_file_name=$dir.$import_file_name;
				}
				else
				{
					if ($error)
					{
						$error.=HTML_BR;
					}
					$error.=str_replace(HASH,'Struktur-Dumps der Import-',$error1);
				}
			}
			if ($import_data_file = new upload('import_data', $dir, $p_777,EMPTY_STRING, true))
			{
				$import_data_file_name = $import_data_file->filename;
				if ($import_data_file_name)
				{
					$import_data_file_name=$dir.$import_data_file_name;
					$import_data_file_name0=$import_data_file_name;
				}
				else
				{
					$process=false;
					if ($error)
					{
						$error.=HTML_BR;
					}
					$error.=str_replace(HASH,'Daten-Dumps der Import-',$error1);
				}
			}
			unset($_SESSION['messageToStack']);
		}
		if ($process)
		{
			//$time_start=time();
			$time_start=myMicrotime(true);
			unset($messageStack);
			define('DROP_TABLE','DROP TABLE');
			define('CREATE_TABLE','CREATE TABLE');
			define('CREATE_NEW_TABLE','
CREATE TABLE # (
@
);
');
			define('DROP_NEW_TABLE','
DROP TABLE #;
');

			define('MY_INSERT_INTO','INSERT INTO ');
			define('MY_UPDATE','SQL_UPDATE ');
			define('INSERT_IGNORE_INTO','INSERT IGNORE INTO ');
			define('KEY','KEY');
			define('LPAREN','(');
			define('SEMI_COLON',';');
			define('EQUAL','=');
			define('TILDE','~');
			define('APOS_S','`');
			define('DASH','-');
			define('COMMENTS',DASH.HASH);
			define('REMOVE_PREFIX',TABLE_PREFIX_COMMON<>EMPTY_STRING);
			define('ALTER_TABLE','ALTER TABLE');
			$alter_table=ALTER_TABLE.' # ';
			define('ALTER_TABLE_ADD',$alter_table.'ADD ');
			define('ALTER_TABLE_DROP',$alter_table.'DROP ');
			define('TRUNCATE_TABLE','TRUNCATE TABLE ');
			define('TAB',chr(9));
			define('INSTALL_TABLE_PREFIX_COMMON','prf_');
			define('DEFAULT_CHARSET',' DEFAULT CHARSET=');
			define('ENGINE','ENGINE');
			define('COLLATE','collate ');
			define('ALLOW_IMPORT_TABLES','content_manager.currencies.languages.shipping_status');
			define('DATA_FOR_TABLE','Daten für Tabelle ');
			define('DATA_FOR_TABLE_1','Daten fÃ¼r Tabelle ');
			define('SHOW_TABLE_STATUS',"SHOW TABLE STATUS LIKE '#'");
			define('COLLATION_FIELD','Collation');

			if (USE_ADODB===true)
			{
				$check_olc_db_version=ADOBD_DB_TYPE=='mysql';
			}
			else
			{
				$check_olc_db_version=true;
			}
			if ($check_olc_db_version)
			{
				$olc_db_version=trim(mysql_get_server_info());
				$is_version_5=substr($olc_db_version,0,1)>'4';
			}
			else
			{
				$is_version_5=true;
			}
			$not_is_version_5=!$is_version_5;
			$olc_charset=array();
			$dummy_array=array();
			$olc_tables=array();
			$olc_array=array();
			$olc_insert_array=array();
			$olc_keys_array=array();
			$error=parse_sql_file($olc_file_name,true,$olc_tables,$olc_array,$olc_insert_array,$dummy_array,$dummy_array,
			$olc_charset,$olc_default_charset,$olc_struct_lines,$olc_data_lines);
			if ($error===true)
			{
				$import_charset=array();
				$import_array=array();
				$import_array_search=array();
				$import_keys_array=array();
 				$error=parse_sql_file($import_file_name,false,$olc_tables,$import_array,$olc_insert_array,
				$import_array_search,$import_keys_array,$import_charset,$import_default_charset,
				$import_struct_lines,$import_data_lines);
				if ($error===true)
				{
					//Loop thru all fields in the import-database, and check, if it is available in the OL-Commerce-database
					$collate_len=strlen(COLLATE);
					$last_table=EMPTY_STRING;
					$alter_table_add=EMPTY_STRING;
					$create_table=EMPTY_STRING;
					$sql0_create=EMPTY_STRING;
					$sql_drop_tables=NEW_LINE;
					$sql_drop_fields=$sql_drop_tables;
					for ($i=0,$n=sizeof($import_array_search);$i<$n;$i++)
					{
						$element=$import_array_search[$i];
						$pos=strrpos($element,TILDE);
						$this_table=substr($element,0,$pos);
						if ($this_table<>$last_table)
						{
							if ($last_table)
							{
								if ($sql)
								{
									if ($add_to_table)
									{
										if ($alter_table_add)
										{
											$alter_table_add.=NEW_LINE;
										}
										$alter_table_add.=str_replace(ATSIGN,$sql,$sql0_create).NEW_LINE;
									}
									else
									{
										$keys=$import_keys_array[$last_table];
										if ($keys)
										{
											for ($j=0,$m=sizeof($keys);$j<$m;$j++)
											{
												$sql.=NEW_LINE.$prefix.$keys[$j];
											}
										}
										else
										{
											$sql=substr($sql,0,strlen($sql)-1);		//Drop last comma!
										}
										$create_table.=str_replace(ATSIGN,$sql,$sql0_create);
										if ($cleanup)
										{
											if ($sql_drop_tables)
											{
												$sql_drop_tables.=NEW_LINE;
											}
											$sql_drop_tables.=$sql0_drop;
										}
									}
								}
							}
							$last_table=$this_table;
							$this_table_0=$this_table.TILDE;
							$add_to_table=binary_search($olc_tables,$this_table);
							if ($add_to_table)
							{
								if (REMOVE_PREFIX)
								{
									//Only apply prefix to tables belonging to OL-Commerce!
									$this_table=TABLE_PREFIX_COMMON.$this_table;
								}
								$this_table=APOS_S.$this_table.APOS_S;
								$prefix=str_replace(HASH,$this_table,ALTER_TABLE_ADD);
								$terminator=SEMI_COLON;
								$sql0_create=ATSIGN;
								if ($cleanup)
								{
									$prefix_drop=str_replace(HASH,$this_table,ALTER_TABLE_DROP);
								}
							}
							else
							{
								$this_table=APOS_S.$this_table.APOS_S;
								$prefix=TAB;
								$terminator=COMMA;
								$sql0_create=str_replace(HASH,$this_table,CREATE_NEW_TABLE);
								if ($cleanup)
								{
									$sql_drop_tables.=str_replace(HASH,$this_table,DROP_NEW_TABLE);
								}
							}
							$sql=EMPTY_STRING;
						}
						if (!binary_search($olc_array,$element))
						{
							$field=$import_array[$i];
							if ($check_charset)
							{
								$pos=strpos($field,COLLATE);
								if ($pos!==false)
								{
									$pos1=strpos($field,BLANK,$pos+$collate_len);
									$collate_string=substr($field,$pos,$pos1-($pos-1));
									$field=str_replace($collate_string,EMPTY_STRING,$field);
								}
							}
							$field=str_replace($this_table_0,EMPTY_STRING,$field).$terminator;
							$pos=strpos($field,BLANK);
							if ($pos!==false)
							{
								$field_name=substr($field,0,$pos);
								if (strpos($field_name,APOS_S)===false)
								{
									$field=str_replace($field_name,APOS_S.$field_name.APOS_S,$field);
								}
							}
							if ($sql)
							{
								$sql.=NEW_LINE;
							}
							$sql.=$prefix.$field;
							if ($add_to_table)
							{
								if ($cleanup)
								{
									if ($sql_drop_fields)
									{
										$sql_drop_fields.=NEW_LINE;
									}
									$sql_drop_fields.=$prefix_drop.substr($field,0,strpos($field,BLANK)).SEMI_COLON;
								}
							}
						}
					}
					$sql='
#
# Import der in Datei "<b>'.str_replace(ADMIN_PATH_PREFIX,EMPTY_STRING,$import_data_file_name0).'"</b> enthaltenen Daten
# in die <b>OL-Commerce-Datenbank "'.DB_DATABASE.'"</b>';
					if (defined('DB_VERSION'))
					{
						$sql.=' (Datenbank-Version '.DB_VERSION.RPAREN;
					}
					$sql.='.
#
# Erstellt am '.date('d.m.Y H:i:s').' mit "admin/'.CURRENT_SCRIPT.'"
#
# Copyright (c) ab 2006:  Dipl.-Ing.(TH) Winfried Kaiser, 24975 Husby
#                         http://www.seifenparadies.de
#                         w.kaiser@fortune.de
#
';
					$sql_commands=EMPTY_STRING;
					if ($is_version_5)
					{
						//Disable "STRICT" mode for MySQL 5!
						define('SET_SESSION','SET SESSION');
						$sql_commands.=SET_SESSION." sql_mode='';".NEW_LINE;
					}
					$sql_commands.=$create_table.NEW_LINE.$alter_table_add;
					$filename=$import_file_name;
					$pos=strrpos($filename,DOT);
					if ($pos!==false)
					{
						$filename=substr($filename,0,$pos);
					}
					$filename=$dir.DB_DATABASE.'_to_'.basename($filename).'_sql.txt';
					$fp=@fopen($filename,'w');
					if ($fp)
					{
						fputs($fp,strip_tags($sql));
						//Store structure update commands
						fputs($fp,$sql_commands);
						//Copy "INSERT" commands
						$fp1=@fopen($import_data_file_name,'r');
						if ($fp1)
						{
							while($line=fgets($fp1,4096))
							{
								fputs($fp,$line);
							}
						}
						fclose($fp1);
						if ($cleanup)
						{
							//Store structure update removal commands
							$sql_commands=$sql_drop_tables.$sql_drop_fields;
							fputs($fp,$sql_commands);
						}
						@unlink($import_data_file_name);
						$auto_update=$_POST['auto_update']=='on';
						if ($auto_update)
						{
							//Apply SQL-statements
							fclose($fp);
							$fp=@fopen($filename,'r');
							if ($fp)
							{
								$sep.="========================================================\n***** SQL-Fehler: ";
								$sql_start_content=
								array(INSERT_IGNORE_INTO,MY_INSERT_INTO,MY_UPDATE,ALTER_TABLE,DROP_TABLE,TRUNCATE_TABLE);
								if ($is_version_5)
								{
									$sql_start_content[]=SET_SESSION;
								}
								$sql_start_content_size=sizeof($sql_start_content);
								$max_key_len=0;
								$sql_start_content_len=array();
								for ($i=0;$i<$sql_start_content_size;$i++)
								{
									$key_len=strlen($sql_start_content[$i]);
									$sql_start_content_len[]=$key_len;
									$max_key_len=max($max_key_len,$key_len);
								}
								$log=EMPTY_STRING;
								$sql_command=EMPTY_STRING;
								$collect_sql_statement=false;
								$not_collect_sql_statement=true;
								if (IS_LOCAL_HOST)
								{
									olc_db_close();
									$link = olc_db_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD,'olc_test');
								}
								$quote='"';
								$ellipses=$quote.'...';
								$filename_1=$filename.'.log';
								@unlink($filename_1);
								$fl=@fopen($filename_1,'w');
								$last_table_name=EMPTY_STRING;
								$have_log=false;
								while ($line=fgets($fp))
								{
									if ($not_collect_sql_statement)
									{
										if (strlen($line)>3)
										{
											$char1=substr(ltrim($line),0,1);
											if (strpos(COMMENTS,$char1)===false)
											{
												$line_sub=substr($line,0,$key_len);
												for ($i=0;$i<$sql_start_content_size;$i++)
												{
													$pos=strpos($line_sub,$sql_start_content[$i]);
													if ($pos!==false)
													{
														$collect_sql_statement=true;
														$not_collect_sql_statement=false;
														$insert_function=$i<=1;				//INSERT type function found
														if ($insert_function)
														{
															$pos+=$sql_start_content_len[$i];
															$pos1=strpos($line,BLANK,$pos);
															if ($pos1===false)
															{
																$pos1=strpos($line,SEMI_COLON,$pos);
															}
															$table_name=strtolower((substr($line,$pos,$pos1-$pos)));
															if ($table_name<>$last_table_name)
															{
																$charset=$import_charset[$table_name];
																$convcharset=$olc_charset[$table_name];
																$change_charset=$charset && $convcharset && $charset <> $convcharset;
																$last_table_name=$table_name;
															}
														}
														else
														{
															$change_charset=false;
														}
														break;
													}
												}
											}
										}
									}
									if ($collect_sql_statement)
									{
										$sql_command.=$line;
										if (strrpos($line,SEMI_COLON)!==false)
										{
											//Terminator ";" found, execute SQL-command
											$collect_sql_statement=false;
											$not_collect_sql_statement=true;
											if ($insert_function)
											{
												if ($change_charset)
												{
													$sql_command=iconv($charset, $convcharset . '//TRANSLIT', $sql_command);
													//$sql_command=iconv($charset, $convcharset . '//IGNORE', $what);
												}
											}
											$result = olc_db_query($sql_command);
											$result_error=olc_db_error();
											if ($result_error)
											{
												if ($have_log)
												{
													$log="\n\n";
												}
												$sql_command=$quote.$sql_command.$quote;
												$log.=$sep.$result_error."\n\n\"".$sql_command.NEW_LINE;
												fputs($fl,$log);
												$log=EMPTY_STRING;
												$have_log=true;
											}
											$sql_command=EMPTY_STRING;
										}
									}
								}
								fclose($fl);
								$error0='<b>Der Daten-Import wurde #erfolgreich ausgeführt!</b>';
								if ($have_log)
								{
									$sql=str_replace(HASH,'nicht ',$error0);
									$sql.=HTML_HR.HTML_HR.'Die Fehler sind in Datei "<a href="'.$file_name.'" target="_blank">'.
									str_replace(ADMIN_PATH_PREFIX,EMPTY_STRING,$file_name).'"</a> dokumentiert.'.HTML_HR;
								}
							}
							else
							{
								$sql=str_replace(HASH,EMPTY_STRING,$error0);
							}
						}
						else
						{
							fclose($fp);
							$sql.=
							'Mit den in der Datei "<a href="'.$filename.'" target="_blank"><b>'.
							str_replace(ADMIN_PATH_PREFIX,EMPTY_STRING,$filename).
							'</b></a>" gespeicherten SQL-Befehlen kann die <b>OL-Commerce</b>-Datenbank um die '.
							'<b>Import</b>-Daten erweitert werden'.HTML_BR.HTML_BR.
							"Diese können mit <b>PHPMyAdmin</b> (oder einem ähnlichen Programm) auf die Datenbank angewendet werden";
						}
						$date_format='d.m.Y H:i:s';
						//$time_end=time();
						$time_end=myMicrotime(true);
						$duration=$time_end-$time_start;
						$stats='
<table border="0" align="left">
  <tr>
    <td class="main" align="left" valign="top" colspan="3">
      <p align="center">
        <p><font color="#FF0000"><b>Verarbeitungs-Statisktik</b></font></p>
      </p>
    </td>
  </tr>
  <tr>
    <td class="main" align="left" valign="top">
      <b>Start der Verarbeitung:</b>
    </td>
    <td class="main" align="left" colspan="2" valign="top">
      <b>&nbsp;#s</b>
    </td>
  </tr>
  <tr>
    <td class="main" align="left" valign="top">
      <b>Ende der Verarbeitung:</b>
    </td>
    <td class="main" align="left" colspan="2" valign="top">
      <b>&nbsp;#e</b>
    </td>
  </tr>
  <tr>
    <td class="main" align="left" valign="top">
      <b>Gesamtdauer:</b>
    </td>
    <td class="main" align="left" colspan="2" valign="top">
      <b>&nbsp;#d Sekunden</b>
    </td>
  </tr>
  <tr>
    <td class="main" align="left" valign="top">
      &nbsp;
    </td>
    <td class="main" align="left" colspan="2" valign="top">
      &nbsp;
    </td>
  </tr>
  <tr>
    <td class="main" align="center" colspan="3" valign="top">
      <font color="#0000FF"><b>Verarbeitete
      SQL-Befehlszeilen</b></font>
    </td>
  </tr>
  <tr>
    <td class="main" align="left" valign="top">
      &nbsp;
    </td>
    <td class="main" align="left" colspan="2" valign="top">
      &nbsp;
    </td>
  </tr>
  <tr>
    <td class="main" align="left" valign="top">
      &nbsp;
    </td>
    <td class="main" align="center" valign="top">
      <b>&nbsp;OL-Commerce</b>-<br/>
      Datenbank
    </td>
    <td class="main" align="center" valign="top">
      <b>Import</b>-<br/>
      &nbsp;Datenbank&nbsp;
    </td>
  </tr>
  <tr>
    <td class="main" align="left" valign="top">
      <b>Zeilen <font color=
      "#FF0000">Struktur</font>-Definition:</b>
    </td>
    <td class="main" align="right" valign="top">
      <b>&nbsp;#os</b>
    </td>
    <td class="main" align="right" valign="top">
      <b>&nbsp;#is</b>
    </td>
  </tr>
  <tr>
    <td class="main" align="left" valign="top">
      <b>Zeilen <font color=
      "#FF0000">Daten</font>-Definition:</b>
    </td>
    <td class="main" align="right" valign="top">
      <b>&nbsp;#od</b>
    </td>
    <td class="main" align="right" valign="top">
      <b>&nbsp;#id</b>
    </td>
  </tr>
</table>
';

						$ms=$time_start-(int)$time_start;
						if ($ms)
						{
							$ms=number_format($ms,1, COMMA, DOT);
							$ms=DOT.substr($ms,strrpos($ms,COMMA)+1);
						}
						$stats=str_replace('#s',date($date_format,$time_start).$ms,$stats);
						$ms=$time_end-(int)$time_end;
						if ($ms)
						{
							$ms=number_format($ms,1, COMMA, DOT);
							$ms=DOT.substr($ms,strrpos($ms,COMMA)+1);
						}
						$stats=str_replace('#e',date($date_format,$time_end).$ms,$stats);
						$stats=str_replace('#d',number_format($duration, 1, COMMA, DOT),$stats);
						$stats=str_replace('#os',number_format($olc_struct_lines, 0, EMPTY_STRING, DOT),$stats);
						$stats=str_replace('#od',number_format($olc_data_lines, 0, EMPTY_STRING, DOT),$stats);
						$stats=str_replace('#is',number_format($import_struct_lines, 0, EMPTY_STRING, DOT),$stats);
						$stats=str_replace('#id',number_format($import_data_lines, 0, EMPTY_STRING, DOT),$stats);
						$sql=str_replace(HASH.TAB,EMPTY_STRING,$sql);
						$sql=str_replace(HASH,EMPTY_STRING,$sql);
					}
				}
				else
				{
					$sql=str_replace(TILDE,EMPTY_STRING,$sql);
				}
			}
			else
			{
				$process=false;
			}
		}
		else
		{
			$process=false;
		}
		if ($process)
		{
			$main_content=nl2br($sql);
			if ($stats)
			{
				$main_content.=HTML_BR.HTML_BR.$stats;
			}
			require(PROGRAM_FRAME);
			olc_exit();
		}
		else
		{
			$main_content.='
<hr/>
<font color="Blue"><b>Die Verwendung dieses Programms erfolgt ausschließlich auf eigenes Risiko des Anwenders!</b></font>
<hr/>
@
<p>
  Bitte geben Sie in die folgenden Felder die <font color=
  "Blue><b>Speicherorte</b></font> des
  <b>PHPMyAdmin</b>-<font color=
  "Blue"><b>Struktur</b></font>-Dumps der aktuellen
  <font color="Red"><b>OL-Commerce</b></font>- und der
  <font color="Red"><b>Import</b></font>-Datenbank, sowie
  den Speicherort des <b>PHPMyAdmin</b>-<font color=
  "Blue"><b>Daten</b></font>-Dumps der aktuellen
  <font color="Red"><b>Import</b></font>-Datenbank ein.
  <b><a target="_blank" href=
  "../olc_installer/automatischer_daten_import.html">Hilfe</a></b>
</p>
';
			$main_content.=
			olc_draw_form('xxc_import',$PHP_SELF,'post','enctype="multipart/form-data"').
			olc_draw_hidden_field('action','process').'
  <table border="0">
    <tr>
      <td valign="top" class="main" class="main">
        <b>Speicherort des....<br/><br/></b>
      </td>
      <td valign="top" class="main">
        ('.$file_size.')
      </td>
    </tr>
    <tr>
      <td valign="top" class="main">
        <font color="Blue"><b>Struktur</b></font>-Dumps
        der <font color=
        "Red"><b>OL-Commerce</b></font>-Datenbank:&nbsp;
      </td>
      <td valign="top" class="main">
        <input type="file" name="olc" size="40">
      </td>
    </tr>
    <tr>
      <td valign="top" class="main">
        <font color="Blue"><b>Struktur-</b></font>Dumps
        der <font color=
        "Red"><b>Import</b></font>-Datenbank:
      </td>
      <td valign="top" class="main">
        <input type="file" name="import" size="40">
      </td>
    </tr>
    <tr>
      <td colspan="2" valign="top">
        <font size="1"><hr/></font>
      </td>
    </tr>
    <tr>
      <td valign="top" class="main">
        <b><font color="Blue">Daten</font></b>-Dumps der
        <font color="Red"><b>Import</b></font>-Datenbank:
      </td>
      <td valign="top" class="main">
        <input type="file" name="import_data" size="40">
      </td>
    </tr>
    <tr>
      <td colspan="2" valign="top">
        <font size="1"><hr/></font>
      </td>
    </tr>
    <!--
    <tr>
      <td valign="top" class="main">
        &nbsp;
      </td>
      <td align="right">
        <p align="left">
          <input type="checkbox" name="auto_update" value=
          "on" checked><b> Update automatisch ausf&uuml;hren</b>
        </p>
      </td>
    </tr>
    <tr>
      <td valign="top" class="main">
        &nbsp;
      </td>
      <td align="right">
        <p align="left">
          <input type="checkbox" name="cleanup" value=
          "on" checked><b> Von OL-Commerce nicht verwendbare Daten löschen</b>
        </p>
      </td>
    </tr>
    -->
    <tr>
      <td valign="top" class="main">
        <br/>
        <input type="reset" value="Zur&uuml;cksetzen">
      </td>
      <td align="right" height="57">
        <br/>
        <input type="submit" value="Absenden">
      </td>
    </tr>
  </table>
</form>';
			if ($error)
			{
				$error=str_replace (HASH,$error,$error0).HTML_HR;
			}
			$main_content=str_replace(ATSIGN,$error,$main_content);
		}
	}
	else
	{
		$show_error=true;
		$main_content='Es wird Zugriff auf die Datei "<font color="blue">'.
		str_replace(ADMIN_PATH_PREFIX,EMPTY_STRING,OLCOMMERCE_SQL).'</font>" benötigt, dieser ist jedoch nicht möglich!';
	}
}
else
{
	$show_error=true;
	$main_content=
	str_replace(HASH,'Das Programm kann nur vom <font color="blue">Haupt-Administrator</font> ausgeführt werden!',
	$error0);
}
if ($main_content)
{
	if ($show_error)
	{
		$main_content=str_replace(HASH,$main_content,$error0);
	}
	$main_content=HTML_BR.HTML_BR.$main_content;
	require(PROGRAM_FRAME);
	olc_exit();
}

function parse_sql_file($file_name,$is_olc_file,&$tables,&$text_array,&$insert_array,&$text_array_search,&$keys_array,
&$table_charset,$default_charset,&$struct_count,&$data_count)
{
	if (defined('TABLE_PREFIX_COMMON'))
	{
		$error0='Fehler beim Öffnen der Datei "#"!';
		$fp=@fopen($file_name,'r');
		if ($fp)
		{
			$not_is_olc_file=!$is_olc_file;
			$check_charset=true;	$not_is_olc_file && $not_is_version_5;
			$charset_len=strlen(DEFAULT_CHARSET);
			$not_found_charset=true;
			$file_offset=0;
			$not_insert_into_found=true;
			while ($line=fgets($fp))
			{
				$line=trim($line);
				$struct_count++;
				if ($line)																					//Ignore empty lines
				{
					$char1=substr($line,0,1);
					if (strpos(COMMENTS,$char1)!==false)
					{
						continue;
					}
					elseif (strpos($line,SEMI_COLON)!==false)			//Ignore "DROP TABLE"
					{
						if ($not_is_olc_file)
						{
							if ($check_charset)
							{
								$pos=strpos($line,DEFAULT_CHARSET);
								if ($pos!==false)
								{
									$pos+=$charset_len;
									$pos1=strpos($line,BLANK,$pos);
									if ($pos1===false)
									{
										$pos1=strpos($line,SEMI_COLON,$pos);
									}
									$charset=strtolower((substr($line,$pos,$pos1-$pos)));
									$table_charset[$table_name]=$charset;
								}
							}
						}
					}
					else
					{
						$uc_line=strtoupper($line);
						if (strpos($uc_line,MY_INSERT_INTO)===false)
						{
							if (strpos($uc_line,DROP_TABLE)===false)			//Ignore "DROP TABLE"
							{
								$pos=strpos($uc_line,CREATE_TABLE);
								if ($pos!==false)														//Check for "CREATE TABLE"
								{
									//Set new table name
									$line=rtrim(str_replace(LPAREN,EMPTY_STRING,$line));
									$pos=strrpos($line,BLANK);
									$table_name=substr($line,$pos+1);
									if (REMOVE_PREFIX)
									{
										$table_name_p=$table_name;
										$table_name=str_replace(TABLE_PREFIX_COMMON,EMPTY_STRING,$table_name);
									}
									$table_name=strtolower(str_replace(APOS_S,EMPTY_STRING,$table_name));
									if ($is_olc_file)
									{
										$tables[]=$table_name;
										if ($check_charset)
										{
											$status_query=str_replace(HASH,$table_name_p,SHOW_TABLE_STATUS);
											$status=olc_db_query($status_query);
											if (olc_db_num_rows($status)>0)
											{
												$status=olc_db_fetch_array($status);
												$charset=$status[COLLATION_FIELD];
												$table_charset[$table_name]=$charset;
											}
										}
									}
								}
								else
								{
									if (strpos($line,KEY)!==false)
									{
										if ($not_is_olc_file)
										{
											$keys_array[$table_name][]=$line;
										}
									}
									else
									{
										//Found field, extract field name
										$line=str_replace(APOS_S,EMPTY_STRING,$line);
										if (substr($line,-1)==COMMA)
										{
											$line=substr($line,0,strlen($line)-1);
										}
										$line=TILDE.$line;
										if ($not_is_olc_file)
										{
											$text_array[]=$table_name.$line;
										}
										$pos=strpos($line,BLANK);
										if ($pos!==false)
										{
											$line=substr($line,0,$pos);
										}
										$line=$table_name.$line;
										if ($is_olc_file)
										{
											$text_array[]=$line;
										}
										else
										{
											$text_array_search[]=$line;
										}
									}
								}
							}
						}
					}
					/*
					else
					{
					$not_insert_into_found=false;
					break;
					}
					*/
				}
				//$file_offset=ftell($fp);		//Get current file pointer position
			}
			if ($is_olc_file)
			{
				sort($text_array);
			}
			$open_new_file=$is_olc_file || $not_insert_into_found;
			if ($open_new_file)
			{
				fclose($fp);
				if ($is_olc_file)
				{
					$file_name=OLCOMMERCE_SQL;
				}
				else
				{
					global $import_data_file_name;
					$file_name=$import_data_file_name;
				}
			}
			else
			{
				fseek($fp,$file_offset);			//reposition file to last line
			}
			//Identify/remove "INSERT INTO"s, which must not be applied from the import data!
			if ($open_new_file)
			{
				$fp=@fopen($file_name,'r');
			}
			if ($fp)
			{

				if ($not_is_olc_file)
				{
					//sort($text_array_search);

					$data_for_table_len=strlen(DATA_FOR_TABLE);
					$data_for_table_len_1=strlen(DATA_FOR_TABLE_1);
					$pos=strrpos($file_name,DOT);
					$fp1=substr($file_name,$pos);
					$file_name_1=str_replace($fp1,'_neu'.$fp1,$file_name);
					@unlink($file_name_1);
					$fp1=@fopen($file_name_1,'w');
					if ($fp1)
					{
						$insert_into_active=false;
						fputs($fp1,NEW_LINE);
					}
					else
					{
						return str_replace(HASH,str_replace(ADMIN_PATH_PREFIX,EMPTY_STRING,$file_name_1),$error0);
					}
				}
				$insert_into_len=strlen(MY_INSERT_INTO);
				while ($line=fgets($fp))
				{
					$data_count++;
					if ($line)																					//Ignore empty lines
					{
						$pos=strpos($line,MY_INSERT_INTO);
						$tline=trim($line);
						if ($pos===false || $insert_into_active)					//"INSERT INTO" not found or active!
						{
							if ($not_is_olc_file)
							{
								if ($insert_into_active)
								{
									$insert_into_active=substr($tline,-1)<>SEMI_COLON;
								}
								elseif (REMOVE_PREFIX)
								{
									$pos=strpos($line,DATA_FOR_TABLE);
									if ($pos===false)
									{
										$pos=strpos($line,DATA_FOR_TABLE_1);
										$len=$data_for_table_len_1;
									}
									else
									{
										$len=$data_for_table_len;
									}
									if ($pos!==false)
									{
										$s=trim(substr($line,$pos+$len));
										$s1=str_replace(APOS_S,EMPTY_STRING,$s);
										if (binary_search($tables,$s1))
										{
											//Only apply prefix to tables belonging to OL-Commerce!
											$line=str_replace($s1,TABLE_PREFIX_COMMON.$s1,$line);
										}
									}
								}
								if ($not_is_in_ignore_table)
								{
									fputs($fp1,$line);
								}
							}
						}
						else
						{
							$pos+=$insert_into_len;
							$pos1=strpos($line,BLANK,$pos);
							$table_name=substr($line,$pos,$pos1-$pos);
							if ($is_olc_file)
							{
								$table_name=str_replace(INSTALL_TABLE_PREFIX_COMMON,EMPTY_STRING,$table_name);
							}
							else
							{
								if (REMOVE_PREFIX)
								{
									$line=str_replace(TABLE_PREFIX_COMMON,EMPTY_STRING,$line);
								}
							}
							$table_name=str_replace(APOS_S,EMPTY_STRING,$table_name);
							$is_in_ignore_table=binary_search($insert_array,$table_name);		//in_array($table_name,$insert_array);
							$not_is_in_ignore_table=!$is_in_ignore_table;
							if ($not_is_olc_file)
							{
								if ($is_in_ignore_table)
								{
									$not_is_in_ignore_table=strpos(ALLOW_IMPORT_TABLES,$table_name)!==false;
									if ($not_is_in_ignore_table)
									{
										$is_in_ignore_table=false;
										$s=$table_name;
										if (REMOVE_PREFIX)
										{
											$s=TABLE_PREFIX_COMMON.$s;
										}
										fputs($fp1,TRUNCATE_TABLE.APOS_S.$s.APOS_S.SEMI_COLON.NEW_LINE);
									}
								}
							}
							if ($is_in_ignore_table)
							{
								if ($insert_into_active)
								{
									$insert_into_active=substr($tline,-1)<>SEMI_COLON;
								}
							}
							else
							{
								if ($is_olc_file)
								{
									//Identify "INSERT INTO"s, which must not be applied from the import data!
									$insert_array[]=$table_name;
								}
								else
								{
									//Modify "INSERT INTO"s!
									$insert_into_active=substr($tline,-1)<>SEMI_COLON;
									$line=str_replace(MY_INSERT_INTO,INSERT_IGNORE_INTO,$line);
									if (REMOVE_PREFIX)
									{
										if (binary_search($tables,$table_name))
										{
											//Only apply prefix to tables belonging to OL-Commerce!
											$pos=strpos($line,$table_name);
											$line=substr($line,0,$pos).TABLE_PREFIX_COMMON.substr($line,$pos);
										}
									}
									fputs($fp1,$line);
								}
							}
						}
					}
				}
				if ($is_olc_file)
				{
					sort($insert_array);
				}
				else
				{
					fclose($fp1);
					$import_data_file_name=$file_name_1;
				}
				return true;
			}
			else
			{
				$show_error=true;
			}
		}
		else
		{
			$show_file_error=true;
		}
		if ($show_file_error)
		{
			$error=str_replace(HASH,str_replace(ADMIN_PATH_PREFIX,EMPTY_STRING,$file_name),$error0);
		}
	}
	else
	{
		$error='Unzulässiges System';
	}
	return $error;
}
?>