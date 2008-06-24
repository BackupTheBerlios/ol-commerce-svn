<?
/* -----------------------------------------------------------------------------------------
$Id: pagepeel.php,v 1.2 2007-03-24

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

N o t (!!) released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$file='includes/pagepeel/pagepeel.php';
if (file_exists($file))
{
	include($file);
}
else 
{
	echo HTML_NBSP;
}
?>