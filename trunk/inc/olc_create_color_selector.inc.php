<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_create_color_selector.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:13 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

//W. Kaiser - AJAX

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de), w.kaiser@fortune.de

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the "Software"),
to deal in the Software without restriction, including without limitation
the rights to use, copy, modify, merge, publish, distribute, sublicense,
and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT
OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR
THE USE OR OTHER DEALINGS IN THE SOFTWARE.

---------------------------------------------------------------------------------------

olc_create_color_selector builds the HTML-structure and Javascript-code
for the selection of color values from the defined CSS color-values.

---------------------------------------------------------------------------------------
*/

function olc_create_color_selector($color_field_name,$color_start_value)
{
	$script0='set_color_selector_color("'.$color_start_value.'");';
	if (IS_AJAX_PROCESSING)
	{
		$ajax_script_id++;
		define('AJAX_SCRIPT_'.$ajax_script_id,$script0);
	}
	else
	{
		$script='
<SCRIPT>
function set_initial_color()
{
	'.$script0.'
}
setTimeout("set_initial_color()",0);
</SCRIPT>
';
	}
	return $script.'
<table width="322" BORDER=0 cellpadding=1 cellspacing=1 align="center">
	<tr>
		<td colspan="2">
			<p align="center"><font style="font-size:6pt">
			Mit "Klick" auf das <B>Eingabe</B>- oder das <B>Farbmuster-Feld</B> kann eine
			<B>Tabelle zur Farbauswahl </B>ein-/ausgeblendet werden.<br/><br/>
			Mit "Klick" auf eines der dann vorhandenen Farbfelder, wird diese Farbe ausgewählt.<br/><br/>
			</font>
		</td>
	</tr>
	<tr>
		<td>
			<INPUT NAME="'.$color_field_name.'" onclick="javascript:show_hide_color_table();" id="color_field" size="18" VALUE="farbe">
				<font style="font-size:6pt">&nbsp;<b>Farbmuster:</b></font>
		</td>
		<td width="150" height="20" style="border: 1px solid;border-color: black;" onclick="javascript:show_hide_color_table();" id="color_cell">
			&nbsp;
		</td>
	</tr>
</table>
<table width="330" BORDER=0 cellpadding=1 cellspacing=1 align="center">
	<tr>
		<td colspan="2">
			<table border="1" cellpadding=1 cellspacing=1 id="color_table" style="display:none">
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="aliceblue" align="center">
					<font style="font-size:6pt;">Aliceblue</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="antiquewhite" align="center">
					<font style="font-size:6pt;">Antiquewhite</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="aqua" align="center">
					<font style="font-size:6pt;">Aqua</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="aquamarine" align="center">
					<font style="font-size:6pt;">Aquamarine</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="azure" align="center">
					<font style="font-size:6pt;">Azure</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="beige" align="center">
					<font style="font-size:6pt;">Beige</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="bisque" align="center">
					<font style="font-size:6pt;">Bisque</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="black" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Black</td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="blanchedalmond" align="center">
					<font style="font-size:6pt;">Blanchedalmond</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="blue" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Blue</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="bluevoilet" align="center">
					<font style="font-size:6pt;">Blueviolet</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="brown" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Brown</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="burlywood" align="center">
					<font style="font-size:6pt;">Burlywood</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="cadetblue" align="center">
					<font style="font-size:6pt;" color="#FFFFFF">Cadetblue</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="chartreuse" align="center">
					<font style="font-size:6pt;">Chartreuse</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="chocolate" align="center">
					<font style="font-size:6pt;">Chocolate</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="coral" align="center">
					<font style="font-size:6pt;">Coral</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="cornflowerblue" align="center">
					<font style="font-size:6pt;">Cornflowerblue</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="cornsilk" align="center">
					<font style="font-size:6pt;">Cornsilk</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="crimson" align="center">
					<font style="font-size:6pt;" color="#FFFFFF">Crimson</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="cyan" align="center">
					<font style="font-size:6pt;">Cyan</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkblue" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Darkblue</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkcyan" align="center">
					<font style="font-size:6pt;">Darkcyan</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkgoldenrod" align="center">
					<font style="font-size:6pt;" color="#FFFFFF">Darkgoldenrod</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkgray" align="center">
					<font style="font-size:6pt;">Darkgray</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkgreen" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Darkgreen</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkkhaki" align="center">
					<font style="font-size:6pt;">Darkkhaki</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkmagenta" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Darkmagenta</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkolivegreen" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Darkolivegreen</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkorange" align="center">
					<font style="font-size:6pt;">Darkorange</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkorchid" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Darkorchid</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkred" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Darkred</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darksalmon" align="center">
					<font style="font-size:6pt;">Darksalmon</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkseagreen" align="center">
					<font style="font-size:6pt;">Darkseagreen</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkslateblue" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Darkslateblue</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkslategray" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Darkslategray</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkturquoise" align="center">
					<font style="font-size:6pt;">Darkturquoise</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="darkviolet" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Darkviolet</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="deeppink" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Deeppink</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="deepskyblue" align="center">
					<font style="font-size:6pt;">Deepskyblue</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="dimgray" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Dimgray</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="dodgerblue" align="center">
					<font style="font-size:6pt;">Dodgerblue</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="firebrick" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Firebrick</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="floralwhite" align="center">
					<font style="font-size:6pt;">Floralwhite</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="forestgreen" align="center">
					<font style="font-size:6pt;" color="#FFFFFF">Forestgreen</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="fuchsia" align="center">
					<font style="font-size:6pt;">Fuchsia</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="gainsboro" align="center">
					<font style="font-size:6pt;">Gainsboro</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="ghostwhite" align="center">
					<font style="font-size:6pt;">Ghostwhite</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="gold" align="center">
					<font style="font-size:6pt;">Gold</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="goldenrod" align="center">
					<font style="font-size:6pt;">Goldenrod</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="gray" align="center">
					<font style="font-size:6pt;" color="#FFFFFF">Gray</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="green" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Green</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="greenyellow" align="center">
					<font style="font-size:6pt;">Greenyellow</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="honeydew" align="center">
					<font style="font-size:6pt;">Honeydew</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="hotpink" align="center">
					<font style="font-size:6pt;">Hotpink</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="indianred" align="center">
					<font style="font-size:6pt;" color="#FFFFFF">Indianred</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="indigo" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Indigo</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="ivory" align="center">
					<font style="font-size:6pt;">Ivory</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="khaki" align="center">
					<font style="font-size:6pt;">Khaki</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lavender" align="center">
					<font style="font-size:6pt;">Lavender</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lavenderblush" align="center">
					<font style="font-size:6pt;">Lavenderblush</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lawngreen" align="center">
					<font style="font-size:6pt;">Lawngreen</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lemonchiffon" align="center">
					<font style="font-size:6pt;">Lemonchiffon</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lightblue" align="center">
					<font style="font-size:6pt;">Lightblue</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lightcoral" align="center">
					<font style="font-size:6pt;">Lightcoral</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lightcyan" align="center">
					<font style="font-size:6pt;">Lightcyan</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lightgoldenrodyellow" align="center">
					<font style="font-size:6pt;">Lightgoldenrodyellow</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lightgreen" align="center">
					<font style="font-size:6pt;">Lightgreen</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lightgrey" align="center">
					<font style="font-size:6pt;">Lightgrey</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lightpink" align="center">
					<font style="font-size:6pt;">Lightpink</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lightsalmon" align="center">
					<font style="font-size:6pt;">Lightsalmon</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lightseagreen" align="center">
					<font style="font-size:6pt;" color="#FFFFFF">Lightseagreen</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lightskyblue" align="center">
					<font style="font-size:6pt;">Lightskyblue</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lightslategray" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Lightslategray</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lightsteelblue" align="center">
					<font style="font-size:6pt;">Lightsteelblue</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lightyellow" align="center">
					<font style="font-size:6pt;">Lightyellow</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="lime" align="center">
					<font style="font-size:6pt;">Lime</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="limegreen" align="center">
					<font style="font-size:6pt;" color="#FFFFFF">Limegreen</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="linen" align="center">
					<font style="font-size:6pt;">Linen</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="magenta" align="center">
					<font style="font-size:6pt;">Magenta</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="maroon" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Maroon</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="mediumaquamarine" align="center">
					<font style="font-size:6pt;">Mediumauqamarine</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="mediumblue" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Mediumblue</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="mediumorchid" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Mediumorchid</td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="mediumpurple" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Mediumpurple</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="mediumseagreen" align="center">
					<font style="font-size:6pt;">Mediumseagreen</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="mediumslateblue" align="center">
					<font style="font-size:6pt;" color="#FFFFFF">Mediumslateblue</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="mediumspringgreen" align="center">
					<font style="font-size:6pt;">Mediumspringgreen</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="mediumturquoise" align="center">
					<font style="font-size:6pt;">Mediumturquoise</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="mediumvioletred" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Mediumvioletred</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="midnightblue" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Midnightblue</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="mintcream" align="center">
					<font style="font-size:6pt;">Mintcream</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="mistyrose" align="center">
					<font style="font-size:6pt;">Mistyrose</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="moccasin" align="center">
					<font style="font-size:6pt;">Moccasin</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="navajowhite" align="center">
					<font style="font-size:6pt;">Navajowhite</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="navy" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Navy</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="oldlace" align="center">
					<font style="font-size:6pt;">Oldlace</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="olive" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Olive</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="olivedrab" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Olivedrab</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="orange" align="center">
					<font style="font-size:6pt;">Orange</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="orangered" align="center">
					<font style="font-size:6pt;">Orangered</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="orchid" align="center">
					<font style="font-size:6pt;">Orchid</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="palegoldenrod" align="center">
					<font style="font-size:6pt;">Palegoldenrod</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="palegreen" align="center">
					<font style="font-size:6pt;">Palegreen</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="paleturquoise" align="center">
					<font style="font-size:6pt;">Paleturquoise</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="palevioletred" align="center">
					<font style="font-size:6pt;">Palevioletred</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="papayawhip" align="center">
					<font style="font-size:6pt;">Papayawhip</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="peachpuff" align="center">
					<font style="font-size:6pt;">Peachpuff</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="peru" align="center">
					<font style="font-size:6pt;">Peru</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="pink" align="center">
					<font style="font-size:6pt;">Pink</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="plum" align="center">
					<font style="font-size:6pt;">Plum</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="powderblue" align="center">
					<font style="font-size:6pt;">Powderblue</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="purple" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Purple</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="red" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Red</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="rosybrown" align="center">
					<font style="font-size:6pt;">Rosybrown</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="royalblue" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Royalblue</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="saddlebrown" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Saddlebrown</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="salmon" align="center">
					<font style="font-size:6pt;">Salmon</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="sandybrown" align="center">
					<font style="font-size:6pt;">Sandybrown</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="seagreen" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Seagreen</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="seashell" align="center">
					<font style="font-size:6pt;">Seashell</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="sienna" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Sienna</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="silver" align="center">
					<font style="font-size:6pt;">Silver</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="skyblue" align="center">
					<font style="font-size:6pt;">Skyblue</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="slateblue" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Slateblue</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="slategray" align="center">
					<font style="font-size:6pt;">Slategray</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="snow" align="center">
					<font style="font-size:6pt;">Snow</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="springgreen" align="center">
					<font style="font-size:6pt;">Springgreen</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="steelblue" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Steelblue</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="tan" align="center">
					<font style="font-size:6pt;">Tan</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="teal" align="center">
					<font color="#FFFFFF" style="font-size:6pt;">Teal</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="thistle" align="center">
					<font style="font-size:6pt;">Thistle</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="tomato" align="center">
					<font style="font-size:6pt;">Tomato</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="turquoise" align="center">
					<font style="font-size:6pt;">Turquoise</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="violet" align="center">
					<font style="font-size:6pt;">Violet</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="wheat" align="center">
					<font style="font-size:6pt;">Wheat</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="white" align="center">
					<font style="font-size:6pt;">White</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="whitesmoke" align="center">
					<font style="font-size:6pt;">Whitesmoke</font></td>
				</tr>
				<tr>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="yellow" align="center">
					<font style="font-size:6pt;">Yellow</font></td>
					<td onclick="javascript:get_color(this);" onmouseover="set_title(this)" BGCOLOR="yellowgreen" align="center">
					<font style="font-size:6pt;">YellowGreen</font></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
';
}
?>