<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_backtrace.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:09 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com
(c) 2003	    nextcommerce (olc_banner_exists.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function olc_backtrace()
{
	$MAXSTRLEN = 1000;
	$s = '
		<p><font size="3"><b>Error-Backtrace<b></font><p>
		<p align="left"><pre>
';
	$font_start='<font face="Courier New,Courier" size="1">';
	$font_end=')</font>';
	$lf=NEW_LINE;
	$template="<font color=#FF0000a># Zeile/Line %d, Datei/File: %s</font>".$lf;
	$unknown="unbekannt/unknown";
	$root=strtolower(DIR_FS_CATALOG);
	$ellipses='...';
	$ellipses_slash=$ellipses.SLASH;
	$back_slash='\\';
	$line='line';
	$file='file';
	$class_text='class';
	$args_text='args';
	$nul_text='null';
	$object_text= 'Objekt: ';
	$function_text='function';
	$array_text='Array[';
	$rsb_text=']';
	$traceArr = debug_backtrace();
	array_shift($traceArr);
	array_shift($traceArr);
	//$tabs = sizeof($traceArr)-1;
	//$tab=HTML_NBSP. HTML_NBSP;
	//$c_tab=EMPTY_STRING;
	$c_tab= '&nbsp;&nbsp;';
	foreach($traceArr as $arr)
	{
		//$c_tab.= $tab;
		$s.=$c_tab;
		$s .= $font_start;
		$class=isset($arr[$class_text])?$arr[$class_text]:EMPTY_STRING;
		if ($class)
		{
			$s .= $class.DOT;
		}
		$args = array();
		$arr_l=@$arr[$args_text];
		if($arr_l)
		{
			foreach($arr_l as $v)
			{
				if (is_null($v))
				{
					$args[] = $nul_text;
				}
				else if (is_array($v))
				{
					$args[] = $array_text.sizeof($v).$rsb_text;
				}
				else if (is_object($v))
				{
					$args[] = $object_text.get_class($v);
				}
				else if (is_bool($v))
				{
					$args[] = $v ? TRUE_STRING_S : FALSE_STRING_S;
				}
				else
				{
					$v = (string) @$v;
					$v = str_replace($back_slash,SLASH,(string) @$v);
					$v = str_replace($root,$ellipses_slash,strtolower($v));
					$str = htmlspecialchars(substr($v,0,$MAXSTRLEN));
					if (strlen($v) > $MAXSTRLEN)
					{
						$str .= $ellipses;
					}
					$args[] =QUOTE.$str.QUOTE;
				}
			}
		}
		$s .=$arr[$function_text].LPAREN.implode(COMMA_BLANK,$args).$font_end;
		$Line = (isset($arr[$line])? $arr[$line] : $unknown);
		$File = (isset($arr[$file])? $arr[$file] : $unknown);
		if ($File)
		{
			$File = str_replace($back_slash,SLASH,$File);
			$File = str_replace($root,$ellipses_slash,strtolower($File));
		}
		else
		{
			$File = $unknown;
		}
		$s .= $lf.$c_tab.sprintf($template,$Line, $File, $File);
	}
	$s .= '</pre></p>';
	return $s;
}
?>