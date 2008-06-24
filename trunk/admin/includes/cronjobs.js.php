<?PHP
//W. Kaiser - AJAX
/* -----------------------------------------------------------------------------------------
id: cronjobs.js.php,v 1.0 2006/10/10  $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

AJAX=Asynchronous JavaScript And XML
Info: http://de.wikipedia.org/wiki/Ajax_(Programmierung)

AJAX client-side Javascript support-routines

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.18 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (shopping_cart.php,v 1.15 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
tri
Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

if (defined('CRON_JOBS_LIST'))
{
	$cron_jobs_list=preg_split('/[\n\r]+/',CRON_JOBS_LIST);
	$n=sizeof($cron_jobs_list);
	if ($n)
	{
		/*
		import.php?file=http://www.meinlieferant1.de/produkte.csv,14:15 #Starte Skript immer um 14:15
		import.php?file=http://www.meinlieferant2.de/produkte.csv,Montag/Mittwoch/Freitag,20:00 #Starte Skript Montags, Mittwochs und Freitags um 20:00
		import.php?file=http://www.meinlieferant3.de/produkte.csv,120 #Starte Skript alle 120 Minuten
		*/
		if (SESSION_LANGUAGE=='german')
		{
			$week_days=array('Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag','Sonntag');
		}
		else
		{
			$week_days=array('Monday','Tuesday','Wednesday','Thursday','Fryday','Saturdayday','Sun	day');
		}
		$cron_jobs='
var cron_jobs_check_interval=5				//Wiederholfrequenz der Ausführungsprüfung in Minuten

var cron_jobs_check_interval_seconds=cron_jobs_check_interval*60						//Convert to Second
var cron_jobs_check_interval_milli_seconds=cron_jobs_check_interval*!000		//Convert to Milliseconds

var current_date,current_day,current_hour,current_minute;
var schedule,schedule_days,schedule_time,schedule_time_part,schedule_time_parts,first_schedule_time_part;
var	abs_schedule,last_schedule_time,schedule_interval,next_schedule_time,schedule_script;

var cron_jobs_job=new Array();
var cron_jobs_schedule=new Array();
var cron_job,cron_job_task,cron_job_days,cron_job_time;
var cron_jobs_count='.$n.'
var cron_jobs=new Array(';
		for ($i=0;$i<$n;$i++)
		{
			$error=EMPTY_STRING;
			$current_cron_job=$cron_jobs[$i];
			$cron_job=explode(COMMA,$current_cron_job);
			$n=sizeof($cron_job);
			if ($n>1)
			{
				$cron_jobs_job=$cron_job[0];
				$pos=strpos($cron_jobs_job,'?');
				if ($pos!==false)
				{
					$cron_jobs_task=$cron_jobs_job;
				}
				else
				{
					$cron_jobs_task=substr($cron_jobs_job,0,$pos-1);
				}
				if (file_exist($cron_jobs_task))
				{
					$schedule_days=EMPTY_STRING;
					if ($n>2)
					{
						$time_index=2;
						$schedule_days=strtolower($cron_job[1]);
						$schedule_days_array=explode(SLASH,$schedule_days);
						for ($j=0,$m=sizeof($schedule_days_array);$j<$m;$j++)
						{
							if ($schedule_days)
							{
								$schedule_days.=COMMA;
							}
							$schedule_days.=array_search($schedule_days_array[$j],$week_days);
						}
					}
					else
					{
						$time_index=1;
					}
					$schedule_days.=RPAREN;
					$cron_jobs.="
cron_jobs_job[]='".$cron_jobs_job."'
cron_jobs_schedule_days[]=".$schedule_days.";
cron_jobs_schedule_time[]='".$cron_job[$time_index]."';
cron_jobs_last_schedule_time[]='';
";
				}
				else
				{
					$error='Skript \''.$cron_jobs_task.'\' für Cron-Job\n\n'.$current_cron_job.'\n\ist nicht vorhanden';
				}
			}
			else
			{
				$error='Cron-Job\n\n'.$current_cron_job.'\n\nhat ein unzuläsiges Format';
			}
		}
		if ($error)
		{
			$cron_jobs.='
alert("'.$error.'!\n\nCron-Job wird ignoriert.")
';
		}
	}
	if ($cron_jobs)
	{
		$cron_jobs.='
check_cron_job_schedule()

function check_cron_job_schedule()
{
	current_date=new Date();
	current_day=current_date.getDay();
	current_hour=getHours();
	current_minute=getMinutes();
	current_second=getSeconds();
	for (cron_job=0;cron_job<cron_jobs,cron_job++)
	{
		schedule_days=cron_jobs_schedule_days[cron_job];
		if (schedule_days!="")
		{
			schedule=schedule_days.indexOf(current_day)!=-1;						//Current day in schedule days?
		}
		else
		{
			schedule=true;
		}
		if (schedule)
		{
			schedule_time=cron_jobs_schedule_time[cron_job];
			schedule_time_part=split(/:/,schedule_time);								//Split HH:MM
			schedule_time_parts=schedule_time_part.length;
			first_schedule_time_part=schedule_time_parts[0];
			abs_schedule=schedule_time_parts==1;												//Only one time part => absolute repeating time interval in minutes
			if (abs_schedule)
			{
				last_schedule_time=cron_jobs_last_schedule_time[cron_job];
				if (last_schedule_time)
				{
					schedule_interval=first_schedule_time_part*60;									//Convert schedule interval to seconds
					schedule=current_date>=last_schedule_time+(next_schedule_time+cron_jobs_check_interval_seconds);
				}
				else
				{
					schedule=true;
				}
			}
			else
			{
				schedule=current_hour==first_schedule_time_part;					//Hour match?
				if (schedule)
				{
					schedule=current_minute==schedule_time_parts[1];				//Minute match?
				}
			}
			if (schedule)
			{
				schedule_script=cron_jobs_job[cron_job];
				if (schedule_script)
				{
					//Schedule script via AJAX (expected answer is AJAX_NODATA just to finish AJAX request)
					make_AJAX_Request(schedule_script,false,empty_string,ajax_get);	//Make AJAX request
					cron_jobs_last_schedule_time[cron_job]=current_date;
				}
			}
		}
	}
	setTimeout("check_cron_job_schedule()",cron_jobs_check_interval_milli_seconds);		//Reschedule
}
';
	}
}
if (USE_AJAX)
{
	$sample_interval_text='x';
	include (DIR_WS_INCLUDES.'ajax_periodic.js.php');
}
else
{
	$script=EMPTY_STRING;
}
echo $script.$cron_jobs;
//W. Kaiser - AJAX
?>