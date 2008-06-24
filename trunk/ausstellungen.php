<?PHP
global $jahr,$monat,$tag,$marray;

function get_marked_area($html,$mark)
{
	$poss=strpos($html,$mark);
	if ($poss!==false)
	{
		$poss+=strlen($mark);
		$pose=strpos($html,$mark,$poss);
		if ($pose!==false)
		{
			return substr($html,$poss,$pose-$poss);
		}
	}
}

$pagetext=file_get_contents ("ausstellungen.html");
if (strlen($pagetext)>0)
{
	$pagetext_small=strtolower($pagetext);
	$monat_text="monat=";
	$monat_len=strlen($monat_text);
	$termine_text="termine=";
	$termine_len=strlen($termine_text);
	$html_hr='
<tr><td colspan="2"><hr/></td></tr>
';
	$ignore_external_config_data=true;
	include('includes/configure.php');
	require_once(DIR_FS_INC.'olc_define_global_constants.inc.php');
	$ignore_external_config_data=false;
	include(DIR_FS_INC.'olc_get_template.inc.php');
	$current_template=olc_get_template();
	if ($current_template)
	{
		define('FULL_CURRENT_TEMPLATE',TEMPLATE_PATH.$current_template.SLASH);
	}
	else
	{
		include('includes/application_top.php');
	}
	$html_start='
	<head>
		<link rel="stylesheet" type="text/css" href="'.FULL_CURRENT_TEMPLATE.'stylesheet.css">
	</head>
	<body style="background-color:transparent">
	';
	$html_table_start=$html_start.'
		<table border="0" width="100%">
';
	$html_tr_end='
			</tr>
';
	$html_table_end='
		</table>
	</body>
';

	$html_none=$html_start.'
<p align="center">Es sind noch keine Ausstellungen geplant...</p>
';

	$leadin_text='<!-- leadin-->';
	$leadin=get_marked_area($pagetext,$leadin_text);
	$date=get_marked_area($leadin,$date_text);
	$leadin=str_replace($date,date('d.m.Y'),$leadin);
	$leadin='<p align="center"><font style="font-size:8pt;">'.str_replace($date_text,'',$leadin).'</font></p><hr/>';
	$html_date_end_text='</b></font>#</td>';
	$html_date_today_text=
	str_replace(HASH,'<p align="center"><img border="0" src="images/heute.gif"></p>',$html_date_end_text);
	$html_date_until_text=str_replace(HASH,
	'<br/>&nbsp;<font style="font-size:8pt;">Noch # Tag@<font>',$html_date_end_text);
	$html_date_until_text_hilite=str_replace(';"',';font-weight:bold;color:red;"',$html_date_until_text);
	$html_date_end_text=str_replace(HASH,EMPTY_STRING,$html_date_end_text);

	$tr_text="<tr";
	$td_text="</td>";
	$td_len=strlen($td_text);

	$monat=date("n");
	$tag=date("j");
	$jahr=date("Y");
	$today=mktime(0,0,0,$monat,$tag,$jahr);
	$next_year=false;
	$html='<!-- ';
	$poss=strpos($pagetext,$html);
	if ($poss!==false)
	{
		$html=substr($pagetext,$poss+strlen($html),4);
		if ((int)$html==((int)$jahr)+1)
		{
			$jahr=$html;
			$next_year=true;
		}
	}
	$days_in_year=365;
	$poss=0;
	$marray=array('1'=>31,'2'=>28,'3'=>31,
	'4'=>30,'5'=>31,'6'=>30,
	'7'=>31,'8'=>31,'9'=>30,
	'10'=>31,'11'=>30,'12'=>31);
	if(is_leapyear($jahr))
	{
		$marray['2']=29;
		$days_in_year++;
	}
	else if ($next_year)
	{
		if (is_leapyear($jahr-1))
		{
			$days_in_year++;
		}
	}
	$not_next_year=!$next_year;
	$count=0;
	$max_count=100;
	$html=EMPTY_STRING;
	$haystack_start=0;
	while (true)
	{
		$poss=strpos($pagetext_small,$monat_text,$poss);
		if ($poss===false)
		{
			break;
		}
		else
		{
			$poss+=$monat_len;
			$aus_monat=(int)substr($pagetext_small,$poss,2);
			if ($aus_monat>=$monat || $next_year)
			{
				$pose=strpos($pagetext_small,$termine_text,$poss);
				if ($pose===false)
				{
					break;
				}
				else
				{
					$poss=$pose+$termine_len;
					$next_start=$poss;
					$pose=strpos($pagetext_small,"'",$poss);
					$termine=substr($pagetext_small,$poss,$pose-$poss);
					$termine=split(",",$termine);
					$is_this_month=$aus_monat==$monat;
					$is_today=in_array($tag, $termine);
					if ($aus_monat>$monat || $next_year)
					{
						$show_exhibition=true;
					}
					else
					{
						$show_exhibition=$is_this_month && ($is_today || $termine[0] > $tag);
					}
					if ($show_exhibition)
					{
						$haystack=substr($pagetext,$haystack_start,$poss-$haystack_start);
						$haystack_small=strtolower($haystack);
						$poss=proper_strrpos($haystack_small,$tr_text);
						$pose=$poss;
						for ($i=1;$i<=2;$i++)
						{
							$pose=strpos($haystack_small,$td_text,$pose);
							$pose+=$td_len;
						}
						$replace_text=EMPTY_STRING;
						$s=substr($haystack,$poss,$pose-$poss+$td_len);
						if ($is_this_month && $not_next_year)
						{
							if ($is_today)
							{
								$replace_text=$html_date_today_text;
							}
							else
							{
								$tage=$termine[0]-$tag;
								$is_one_day=$tage==1;
								if ($is_one_day)
								{
									$tage_mult=EMPTY_STRING;
									$template=$html_date_until_text_hilite;
								}
								else
								{
									$tage_mult="e";
									$template=$html_date_until_text;
								}
								$replace_text=str_replace(HASH,$tage,$template);
								$replace_text=str_replace(ATSIGN,$tage_mult,$replace_text);
							}
						}
						else
						{
							$s1=trim(str_replace(HTML_NBSP,EMPTY_STRING,trim(strip_tags($s))));
							$poss=strpos($s1,$jahr);
							if ($poss!==false)
							{
								$date=substr($s1,0,$poss+4);
								$date_parts=split("\.",$date);
								$date_diff=date_diff(mktime(0,0,0,$date_parts[1],$date_parts[0],$date_parts[2]));
								if ($date_diff<=0)
								{
									$date_diff+=$days_in_year;
								}
								$replace_text=str_replace(HASH,$date_diff,$html_date_until_text);
								$replace_text=str_replace(ATSIGN,"e",$replace_text);
							}
						}
						$s=str_replace($html_date_end_text,$replace_text,$s).$html_tr_end.$html_hr;
						$html.=$s;
						$count++;
					}
					if ($count==$max_count)
					{
						break;
					}
					else
					{
						$poss=$next_start+50;
						$haystack_start=$poss;
					}
				}
			}
		}
	}
	if (strlen($html)>0)
	{
		$html=str_replace('size="2"','size="1"',$html);
		$html=$html_table_start.str_replace('size="2"','size="1"',$html).$html_table_end;
	}
	else
	{
		$html=$html_none;
	}
	echo $leadin.$html;
}

function proper_strrpos($haystack,$needle){
	while($ret = strrpos($haystack,$needle))
	{
		if(strncmp(substr($haystack,$ret,strlen($needle)),$needle,strlen($needle)) == 0 )
		return $ret;
		$haystack = substr($haystack,0,$ret -1 );
	}
	return $ret;
}

function date_diff($tstamp)
{
	global $today;

	$total_days = 0;
	while($today < $tstamp) { $total_days++; $tstamp -= 86400; }
	return $total_days;
}

//check whether leep year or not
function is_leapyear($y)
{
	if($y % 4 == 0 && $y % 100 != 0)
	{
		return 1;
	}
	if($y % 100 == 0 && $y % 400 == 0)
	{
		return 1;
	}
	return 0;
}
?>