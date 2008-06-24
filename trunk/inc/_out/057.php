<?PHP
//W. Kaiser - AJAX
/*
-----------------------------------------------------------------------------------------
$Id: olc_create_spiffy_control.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:18 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Create a "spiffy" date field for AJAX and convenbtional mode

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

---------------------------------------------------------------------------------------
*/
if (!$spiffy_date_field_caption)
{
	//Needed for "eval" in "auctions.php"
	$spiffy_date_field_caption=SPIFFY_DATE_FIELD_CAPTION;
	$spiffy_date=SPIFFY_DATE;
	$spiffy_form_name=SPIFFY_FORM_NAME;
	$spiffy_date_field_name=SPIFFY_DATE_FIELD_NAME;
	$spiffy_control_name=SPIFFY_CONTROL_NAME;
}
$ajax_script_id++;
$spiffy_html_id='CalenderControl_'.$ajax_script_id;
$html= $spiffy_date_field_caption.'<br/>
<span style="font-size:6pt">('.strtoupper(DOB_FORMAT_STRING).')</span>
</td>
<td class=main>
	<div id="'.$spiffy_html_id.'" class="main">
';
$date_str='d.m.Y';
$date_spiffy_str='dd.MM.yyyy';
if ($spiffy_date)
{
	$spiffy_date=date($date_str,strtotime($spiffy_date));
}
if (USE_AJAX_ADMIN)
{
	$document_write=FALSE_STRING_S;
}
else
{
	$document_write=TRUE_STRING_S;
}
$spiffy_script='
'.$spiffy_control_name.' = new ctlSpiffyCalendarBox("'.$spiffy_control_name. '", "'.$spiffy_form_name.'","'.
$spiffy_date_field_name.'","btnDate'.$ajax_script_id.'","'. $spiffy_date.'",scBTNMODE_CUSTOMBLUE);'.
$spiffy_control_name.'.dateFormat="'.$date_spiffy_str.'";
var spiffy_control_html='.$spiffy_control_name.'.writeControl('.$document_write.');
';
if (USE_AJAX_ADMIN)
{
	define('AJAX_SCRIPT_'.$ajax_script_id,$spiffy_script.'
document.getElementById("'.$spiffy_html_id.'").innerHTML=spiffy_control_html;
');
}
else
{
	$html.= '
	<script>
	'.$spiffy_script.'
	</script>
';
}
$html.= '
	</div>
';
echo $html;
?>
