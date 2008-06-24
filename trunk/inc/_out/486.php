<?php
//W. Kaiser - AJAX
/*
-----------------------------------------------------------------------------------------
$Id: olc_CSSNamedColorToRGB.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:09 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Convert named colors (CSS names) to their RGB values

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

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

The color names can be seen in "admin\includes\classes\fpdf\named_colors_to_use_with_fpdf.htm"

Copyright: W. Kaiser, D-24975 Husby (w.kaiser@fortune.de)

Usage example:

function SetTextColor($r,$g=-1,$b=-1)
{
	if (!is_numeric($r))
	{
	CSSNamedColorToRGB($r,$b,$g);	//Convert color name to RGB values
	}
	...........  Normal RGB-based Code follows ...........
}

Call: SetTextColor('burlywood')

---------------------------------------------------------------------------------------
*/

function CSSNamedColorToRGB(&$r,&$g,&$b)
{
	switch (strtolower($r))
	{
		case 'aliceblue': $color_value='F0F8FF'; break;
		case 'antiquewhite': $color_value='FAEBD7'; break;
		case 'aqua': $color_value='00FFFF'; break;
		case 'aquamarine': $color_value='7FFFD4'; break;
		case 'azure': $color_value='F0FFFF'; break;
		case 'beige': $color_value='F5F5DC'; break;
		case 'bisque': $color_value='FFE4C4'; break;
		case 'black': $color_value='000000'; break;
		case 'blanchedalmond': $color_value='FFEBCD'; break;
		case 'blue': $color_value='0000FF'; break;
		case 'bluevoilet': $color_value='8A2BE2'; break;
		case 'brown': $color_value='A52A2A'; break;
		case 'burlywood': $color_value='DEB887'; break;
		case 'cadetblue': $color_value='5F9EA0'; break;
		case 'chartreuse': $color_value='7FFF00'; break;
		case 'chocolate': $color_value='D2691E'; break;
		case 'coral': $color_value='FF7F50'; break;
		case 'cornflowerblue': $color_value='6495ED'; break;
		case 'cornsilk': $color_value='FFF8DC'; break;
		case 'crimson': $color_value='DC143C'; break;
		case 'cyan': $color_value='00FFFF'; break;
		case 'darkblue': $color_value='00008B'; break;
		case 'darkcyan': $color_value='008B8B'; break;
		case 'darkgoldenrod': $color_value='B8860B'; break;
		case 'darkgray': $color_value='A9A9A9'; break;
		case 'darkgreen': $color_value='006400'; break;
		case 'darkkhaki': $color_value='BDB76B'; break;
		case 'darkmagenta': $color_value='8B008B'; break;
		case 'darkolivegreen': $color_value='556B2F'; break;
		case 'darkorange': $color_value='FF8C00'; break;
		case 'darkorchid': $color_value='9932CC'; break;
		case 'darkred': $color_value='8B0000'; break;
		case 'darksalmon': $color_value='E9967A'; break;
		case 'darkseagreen': $color_value='8FBC8F'; break;
		case 'darkslateblue': $color_value='483D8B'; break;
		case 'darkslategray': $color_value='2F4F4F'; break;
		case 'darkturquoise': $color_value='00CED1'; break;
		case 'darkviolet': $color_value='9400D3'; break;
		case 'deeppink': $color_value='FF1493'; break;
		case 'deepskyblue': $color_value='00BFFF'; break;
		case 'dimgray': $color_value='696969'; break;
		case 'dodgerblue': $color_value='1E90FF'; break;
		case 'firebrick': $color_value='B22222'; break;
		case 'floralwhite': $color_value='FFFAF0'; break;
		case 'forestgreen': $color_value='228B22'; break;
		case 'fuchsia': $color_value='FF00FF'; break;
		case 'gainsboro': $color_value='DCDCDC'; break;
		case 'ghostwhite': $color_value='F8F8FF'; break;
		case 'gold': $color_value='FFD700'; break;
		case 'goldenrod': $color_value='DAA520'; break;
		case 'gray': $color_value='808080'; break;
		case 'green': $color_value='008000'; break;
		case 'greenyellow': $color_value='ADFF2F'; break;
		case 'honeydew': $color_value='F0FFF0'; break;
		case 'hotpink': $color_value='FF69B4'; break;
		case 'indianred': $color_value='CD5C5C'; break;
		case 'indigo': $color_value='4B0082'; break;
		case 'ivory': $color_value='FFFFF0'; break;
		case 'khaki': $color_value='F0E68C'; break;
		case 'lavender': $color_value='E6E6FA'; break;
		case 'lavenderblush': $color_value='FFF0F5'; break;
		case 'lawngreen': $color_value='7CFC00'; break;
		case 'lemonchiffon': $color_value='FFFACD'; break;
		case 'lightblue': $color_value='ADD8E6'; break;
		case 'lightcoral': $color_value='F08080'; break;
		case 'lightcyan': $color_value='E0FFFF'; break;
		case 'lightgoldenrodyellow': $color_value='FAFAD2'; break;
		case 'lightgreen': $color_value='90EE90'; break;
		case 'lightgrey': $color_value='D3D3D3'; break;
		case 'lightpink': $color_value='FFB6C1'; break;
		case 'lightsalmon': $color_value='FFA07A'; break;
		case 'lightseagreen': $color_value='20B2AA'; break;
		case 'lightskyblue': $color_value='87CEFA'; break;
		case 'lightslategray': $color_value='778899'; break;
		case 'lightsteelblue': $color_value='B0C4DE'; break;
		case 'lightyellow': $color_value='FFFFE0'; break;
		case 'lime': $color_value='00FF00'; break;
		case 'limegreen': $color_value='32CD32'; break;
		case 'linen': $color_value='FAF0E6'; break;
		case 'magenta': $color_value='FF00FF'; break;
		case 'maroon': $color_value='800000'; break;
		case 'mediumaquamarine': $color_value='66CDAA'; break;
		case 'mediumblue': $color_value='0000CD'; break;
		case 'mediumorchid': $color_value='BA55D3'; break;
		case 'mediumpurple': $color_value='9370D8'; break;
		case 'mediumseagreen': $color_value='3CB371'; break;
		case 'mediumslateblue': $color_value='7B68EE'; break;
		case 'mediumspringgreen': $color_value='00FA9A'; break;
		case 'mediumturquoise': $color_value='48D1CC'; break;
		case 'mediumvioletred': $color_value='C71585'; break;
		case 'midnightblue': $color_value='191970'; break;
		case 'mintcream': $color_value='F5FFFA'; break;
		case 'mistyrose': $color_value='FFE4E1'; break;
		case 'moccasin': $color_value='FFE4B5'; break;
		case 'navajowhite': $color_value='FFDEAD'; break;
		case 'navy': $color_value='000080'; break;
		case 'oldlace': $color_value='FDF5E6'; break;
		case 'olive': $color_value='808000'; break;
		case 'olivedrab': $color_value='688E23'; break;
		case 'orange': $color_value='FFA500'; break;
		case 'orangered': $color_value='FF4500'; break;
		case 'orchid': $color_value='DA70D6'; break;
		case 'palegoldenrod': $color_value='EEE8AA'; break;
		case 'palegreen': $color_value='98FB98'; break;
		case 'paleturquoise': $color_value='AFEEEE'; break;
		case 'palevioletred': $color_value='D87093'; break;
		case 'papayawhip': $color_value='FFEFD5'; break;
		case 'peachpuff': $color_value='FFDAB9'; break;
		case 'peru': $color_value='CD853F'; break;
		case 'pink': $color_value='FFC0CB'; break;
		case 'plum': $color_value='DDA0DD'; break;
		case 'powderblue': $color_value='B0E0E6'; break;
		case 'purple': $color_value='800080'; break;
		case 'red': $color_value='FF0000'; break;
		case 'rosybrown': $color_value='BC8F8F'; break;
		case 'royalblue': $color_value='4169E1'; break;
		case 'saddlebrown': $color_value='8B4513'; break;
		case 'salmon': $color_value='FA8072'; break;
		case 'sandybrown': $color_value='F4A460'; break;
		case 'seagreen': $color_value='2E8B57'; break;
		case 'seashell': $color_value='FFF5EE'; break;
		case 'sienna': $color_value='A0522D'; break;
		case 'silver': $color_value='C0C0C0'; break;
		case 'skyblue': $color_value='87CEEB'; break;
		case 'slateblue': $color_value='6A5ACD'; break;
		case 'slategray': $color_value='708090'; break;
		case 'snow': $color_value='FFFAFA'; break;
		case 'springgreen': $color_value='00FF7F'; break;
		case 'steelblue': $color_value='4682B4'; break;
		case 'tan': $color_value='D2B48C'; break;
		case 'teal': $color_value='008080'; break;
		case 'thistle': $color_value='D8BFD8'; break;
		case 'tomato': $color_value='FF6347'; break;
		case 'turquoise': $color_value='40E0D0'; break;
		case 'violet': $color_value='EE82EE'; break;
		case 'wheat': $color_value='F5DEB3'; break;
		case 'white': $color_value='FFFFFF'; break;
		case 'whitesmoke': $color_value='F5F5F5'; break;
		case 'yellow': $color_value='FFFF00'; break;
		case 'yellowgreen': $color_value='9ACD32';
		default: $color_value='000000'; break;
	}
	//Return R,G,B value
	$index=0;
	for ($color=0;$color<=2;$color++)
	{
		$c=hexdec(substr($color_value,$index,2));
		switch ($color)
		{
			case 0:
				{
					$r=$c; break;
				}
			case 1:
				{
					$g=$c; break;
				}
			case 2:
				{
					$b=$c; break;
				}
		}
		$index=$index+2;
	}
	return $color_value;
}
//W. Kaiser - AJAX
?>