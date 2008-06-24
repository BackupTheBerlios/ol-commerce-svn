<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_db_install.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:19 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(database.php,v 1.2 2002/03/02); www.oscommerce.com
(c) 2003	    nextcommerce (olc_db_install.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_db_install($database, $sql_file, $table_prefix)
{
	global $db_error,$parse_time;

	$db_error = false;
	if (!@olc_db_select_db($database))
	{
		if (@olc_db_query('create database ' . $database))
		{
			olc_db_select_db($database);
		}
		else
		{
			if (USE_ADODB===true)
			{
				global $$link;
				$db_error = $$link->ErrorMsg();
			}
			else
			{
				$db_error = mysql_error();
			}
		}
	}
	if ($db_error)
	{
		return false;
	}
	else
	{
		if (file_exists($sql_file))
		{
			//$install_queries=file_get_contents($sql_file);
			$standard_prefix='prf_';
			$adjust_prefix=$table_prefix<>$standard_prefix;
			define('PAGE_PARSE_START_TIME', microtime());
			$install_queries=file($sql_file);
			$n=sizeof($install_queries);
			if (USE_AJAX)
			{
				$chunks=$n/100;
				$chunk=0;
				$progress_file='progress.txt';
				@unlink($progress_file);
				$progress_file_content='p|100|';
			}
			for ($i=0;$i<$n;$i++)
			{
				$query_line=trim($install_queries[$i]);
				if ($query_line)
				{
					if ($query_line[0]<>HASH)
					{
						$query=EMPTY_STRING;
						while (true)
						{
							$query_line=trim($install_queries[$i]);
							$query.=$query_line;
							if (substr($query_line,-1,1)==SEMI_COLON)
							{
								if ($adjust_prefix)
								{
									$query=str_replace($standard_prefix,$table_prefix,$query);
								}
								if (@olc_db_query($query))
								{
									$sql_statements++;
									break;
								}
								else
								{
									$db_error =ERROR_WRONG_SQL_STATEMENT.HTML_BR.HTML_BR.nl2br($query).HTML_BR.HTML_BR;
									return false;
								}
							}
							else
							{
								$i++;
							}
						}
						if (USE_AJAX)
						{
							$store_status=$i%$chunks==1;
							if ($store_status)
							{
								$chunk++;
								$retries=1;
								$f=fopen($progress_file,'w');
								$content=$progress_file_content.$chunk;
								while (fwrite($f,$content)===false)
								{
									if ($retries==20)
									{
										break;
									}
									else
									{
										usleep(200000);
										$retries++;
									}
								}
 								fclose($f);
							}
						}
					}
				}
			}
			$show_parse_time_anyway=true;
			$is_installer=true;
			define('NOT_IS_ADMIN_FUNCTION',false);
			define('SESSION_CURRENCY','EUR');
			include(DIR_FS_INC.'olc_precision.inc.php');
			include(DIR_FS_INC.'olc_get_parse_time.inc.php');
			$sql_per_second=number_format($sql_statements/$parse_time_raw,1,CURRENCY_DECIMAL_POINT,CURRENCY_THOUSANDS_POINT);
			$sql_statements=number_format($sql_statements,0,CURRENCY_DECIMAL_POINT,CURRENCY_THOUSANDS_POINT);
			$parse_time=sprintf(TEXT_PARSE_TIME,$sql_statements,$parse_time,$sql_per_second);
		}
		else
		{
			$db_error = ERROR_NO_SQL_FILE . $sql_file;
		}
	}
}
?>