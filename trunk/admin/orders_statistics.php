<?
/* -----------------------------------------------------------------------------------------

OL-Commerce Version 5.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (install_step5.php,v 1.25 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
*/

/* -----------------------------------------------------------------------------------------
Adjustment this file for Order Alert:

Copyright (c) 2004 Engelke & von der Born Trading GmbH
http://www.compredia.de

Autor: Philipp von der Born

Adapted and enhanced for OL-Commerce: Dipl.-Ing.(TH) Winfried Kaiser
-----------------------------------------------------------------------------------------
*/

require('includes/application_top.php');

$conv_query_raw = "
SELECT
sum(ot.value) as value,
avg(ot.value) as avg,
count(ot.value) as count
FROM ".
TABLE_ORDERS_TOTAL." ot,".
TABLE_ORDERS." o
WHERE
ot.orders_id = o.orders_id and
ot.class = 'ot_subtotal' and
o.date_purchased >= '#1' and
o.date_purchased <= '#2'";

$param1='#1';
$param2='#2';
$count_text="count";
$value_text="value";
$avg_text="avg";
$lparen=LPAREN;
$rparen=RPAREN;

$year = date("Y");
$month = date("m");
$day = date("d");

setlocale(LC_TIME,'de_DE', 'German_Germany');
$date_format="Y-m-d";
$date_format_1="%d. %B %Y";
$date_format_2="%B %Y";

$sep= " - ";
$sep_year=HTML_BR.HTML_BR.HTML_HR.HTML_BR;
$weeks_ids=array('Aktuelle', 'Letzte', 'Vorletzte');
$months_ids=array('Aktueller', 'Letzter', 'Vorletzter');
$days_ids=array('Heute', 'Gestern', 'Vorgestern');
$years_ids=array('Aktuelles', 'Letztes', 'Vorletztes');

$line='
	<td valign="top"><font size="1">#</font></td>';
$line_right='
	<td align="right" valign="top"><font size="1">#</font></td>';
$no_entry_line='
	<td colspan="3" valign="top"><font size="1">Keine Bestellung</font></td>';

$years_offset=2;
for ($phase = 0; $phase<=$years_offset; $phase++)
{
	$current_content=EMPTY_STRING;
	$show_date_range=true;
	$weeks_offset=2;
	$months_offset=2;
	$days_offset=2;
	for ($stat = 0; $stat < 9; $stat++)
	{
		$day_t=0;
		$day_f= 1;
		$month_t=$month_f=$month;
		$year_t=$year_f=$year;
		$date_format_text=$date_format_1;
		$date_text=EMPTY_STRING;
		$text_add=EMPTY_STRING;
		$show_add_data=true;
		switch (true)
		{
			// month now - 2, 1, 0
			case $stat <= 2:
				$month_f=$month - $months_offset;
				$month_t=$month_f+1;
				$text = HTML_B_START.$months_ids[$months_offset]." Monat</b>";
				$date_format_text=$date_format_2;
				$months_offset--;
				break;
				// week now - 2 , 1, 0
			case $stat >= 3 && $stat <= 5:
				$show_add_data=false;
				$day_f= $day - $weeks_offset * 7;
				$wk=date('W',mktime(0, 0, 0, $month, $day_f, $year));
				$mondaykw=mondaykw($wk,$year);
				$day_f=date('d',$mondaykw);
				$month_f = date("m",$mondaykw);
				$year_f = date("Y",$mondaykw);
				$mondaykw=mktime(0, 0, 0, $month_f, $day_f+6, $year_f);
				$day_t=date('d',$mondaykw);
				$month_t = date("m",$mondaykw);
				$year_t = date("Y",$mondaykw);
				$text = HTML_B_START.$weeks_ids[$weeks_offset]." Woche</b> (KW ".$wk.$rparen;
				$weeks_offset--;
				break;
				// day now - 2, 1,0
			case $stat >= 6 && $stat <= 8:
				$show_date_range=false;
				$day_f= $day - $days_offset;
				$day_t= $day_f;
				$text = HTML_B_START.$days_ids[$days_offset].HTML_B_END;
				$days_offset--;
				break;
		}
		$from_date=mktime(0, 0, 0, $month_f, $day_f, $year_f);
		$date_from = date($date_format, $from_date);
		$to_date=mktime(0, 0, 0, $month_t, $day_t, $year_t);
		$date_to = date($date_format, $to_date);
		if ($show_add_data)
		{
			$text .= $lparen . strftime($date_format_text, $from_date) . $rparen;
		}
		if ($show_date_range)
		{
			$text .= HTML_BR.ltrim($lparen.strftime($date_format_1, $from_date)).$sep.
			ltrim(strftime($date_format_1, $to_date)).$rparen;
		}
		$conv_query=str_replace($param1,$date_from,$conv_query_raw);
		$conv_query=str_replace($param2,$date_to,$conv_query);
		$conv_query = olc_db_query($conv_query);
		if (olc_db_num_rows($conv_query))
		{
			$have_no_entry=true;
			$current_content.='
  <tr>
'.
			str_replace(HASH,$text,$line);
			while ($conv = olc_db_fetch_array($conv_query))
			{
				$count=$conv[$count_text];
				if ($count)
				{
					$have_no_entry=false;
					$current_content.=
					str_replace(HASH,olc_format_price($conv[$value_text],1,1),$line_right).
					str_replace(HASH,olc_format_price($conv[$avg_text],1,1),$line_right).
					str_replace(HASH,$count,$line_right);
				}
				else
				{
					break;
				}
			}
			if ($have_no_entry)
			{
				$current_content.=$no_entry_line;
			}
			$current_content.='
  </tr>
';
		}
	}
	if ($current_content)
	{
		$current_content.='
</table>
';
		if ($phase>0)
		{
			$main_content.=$sep_year;
		}
		$main_content.='
			<p align="center" ><font size="2"><b>'.$years_ids[$phase].' Jahr ('.$year.')</b></font></p>
			<table border="1" width="90%" align="center" cellspacing="5" cellpadding="5">
			<tr>
			<td><b><font size="2">Zeitraum</font></b></td>
			<td align="center"><b><font size="2">Umsatz</font></b></td>
			<td align="center"><b><font size="2">Umsatz pro<br/>Bestellung</font></b></td>
			<td align="center"><b><font size="2">Anzahl<br/>Bestellungen</font></b></td>
			</tr>
			';
		$main_content.=$current_content;
		$year--;
	}
}
$page_header_title='Auftrags-Statistik';
$page_header_subtitle='Bestellungs-Statistik pro Zeitraum';
$page_header_icon_image=HEADING_MODULES_ICON;
$show_folumn_right=true;
require(PROGRAM_FRAME);
olc_exit();

function firstkw($jahr)
{
	$erster = mktime(0,0,0,1,1,$jahr);
	$wtag = date('w',$erster);

	if ($wtag <= 4) {
		/**
* Donnerstag oder kleiner: auf den Montag zurückrechnen.
*/
		$montag = mktime(0,0,0,1,1-($wtag-1),$jahr);
	} else {
		/**
* auf den Montag nach vorne rechnen.
*/
		$montag = mktime(0,0,0,1,1+(7-$wtag+1),$jahr);
	}
	return $montag;
}

function mondaykw($kw,$jahr)
{
	$firstmonday = firstkw($jahr);
	$mon_monat = date('m',$firstmonday);
	$mon_jahr = date('Y',$firstmonday);
	$mon_tage = date('d',$firstmonday);

	$tage = ($kw-1)*7;

	$mondaykw = mktime(0,0,0,$mon_monat,$mon_tage+$tage,$mon_jahr);
	return $mondaykw;
}
?>