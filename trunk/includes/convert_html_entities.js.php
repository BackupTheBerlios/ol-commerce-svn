<?PHP
//W. Kaiser - AJAX
/* -----------------------------------------------------------------------------------------
id: convert_html_entities.js.php,v 1.1 2006/09/20  $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

AJAX=Asynchronous JavaScript And XML
Info: http://de.wikipedia.org/wiki/Ajax_(Programmierung)

Convert HTML-Entities

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

$script.='
//#	Variablen für die HTML-Entity Dekodierung			#
//#	"ISOChars", "NamedEntities" und "UnicodeEntities"	#
//#	bilden die Zeichentabelle				#

var ISOChars = new Array("<",">","¡","¢","£","¤","¥","¦","§","¨","©","ª","«","¬","­","®","¯","°","±","²","³","´","µ","¶","·","¸","¹","º","»","¼","½","¾","¿","À","Á","Â","Ã","Ä","Å","Æ","Ç","È","É","Ê","Ë","Ì","Í","Î","Ï","Ð","Ñ","Ò","Ó","Ô","Õ","Ö","×","Ø","Ù","Ú","Û","Ü","Ý","Þ","ß","à","á","â","ã","ä","å","æ","ç","è","é","ê","ë","ì","í","î","ï","ð","ñ","ò","ó","ô","õ","ö","÷","ø","ù","ú","û","ü","ý","þ","ÿ","–","—","‘","’","‚","“","”","„","†","‡","‰","‹","›");

var text,dir,sString,maxChars=ISOChars.length;

//Precompile entities to save runtime.

var NamedEntities = new Array(eval("/&lt;/g"),eval("/&gt;/g"),eval("/&iexcl;/g"),eval("/&cent;/g"),eval("/&pound;/g"),eval("/&curren;/g"),eval("/&yen;/g"),eval("/&brvbar;/g"),eval("/&sect;/g"),eval("/&uml;/g"),eval("/&copy;/g"),eval("/&ordf;/g"),eval("/&laquo;/g"),eval("/&not;/g"),eval("/&shy;/g"),eval("/&reg;/g"),eval("/&macr;/g"),eval("/&deg;/g"),eval("/&plusmn;/g"),eval("/&sup2;/g"),eval("/&sup3;/g"),eval("/&acute;/g"),eval("/&micro;/g"),eval("/&para;/g"),eval("/&middot;/g"),eval("/&cedil;/g"),eval("/&sup1;/g"),eval("/&ordm;/g"),eval("/&raquo;/g"),eval("/&frac14;/g"),eval("/&frac12;/g"),eval("/&frac34;/g"),eval("/&iquest;/g"),eval("/&Agrave;/g"),eval("/&Aacute;/g"),eval("/&Acirc;/g"),eval("/&Atilde;/g"),eval("/&Auml;/g"),eval("/&Aring;/g"),eval("/&AElig;/g"),eval("/&Ccedil;/g"),eval("/&Egrave;/g"),eval("/&Eacute;/g"),eval("/&Ecirc;/g"),eval("/&Euml;/g"),eval("/&Igrave;/g"),eval("/&Iacute;/g"),eval("/&Icirc;/g"),eval("/&Iuml;/g"),eval("/&ETH;/g"),eval("/&Ntilde;/g"),eval("/&Ograve;/g"),eval("/&Oacute;/g"),eval("/&Ocirc;/g"),eval("/&Otilde;/g"),eval("/&Ouml;/g"),eval("/&times;/g"),eval("/&Oslash;/g"),eval("/&Ugrave;/g"),eval("/&Uacute;/g"),eval("/&Ucirc;/g"),eval("/&Uuml;/g"),eval("/&Yacute;/g"),eval("/&THORN;/g"),eval("/&szlig;/g"),eval("/&agrave;/g"),eval("/&aacute;/g"),eval("/&acirc;/g"),eval("/&atilde;/g"),eval("/&auml;/g"),eval("/&aring;/g"),eval("/&aelig;/g"),eval("/&ccedil;/g"),eval("/&egrave;/g"),eval("/&eacute;/g"),eval("/&ecirc;/g"),eval("/&euml;/g"),eval("/&igrave;/g"),eval("/&iacute;/g"),eval("/&icirc;/g"),eval("/&iuml;/g"),eval("/&eth;/g"),eval("/&ntilde;/g"),eval("/&ograve;/g"),eval("/&oacute;/g"),eval("/&ocirc;/g"),eval("/&otilde;/g"),eval("/&ouml;/g"),eval("/&divide;/g"),eval("/&oslash;/g"),eval("/&ugrave;/g"),eval("/&uacute;/g"),eval("/&ucirc;/g"),eval("/&uuml;/g"),eval("/&yacute;/g"),eval("/&thorn;/g"),eval("/&yuml;/g"),eval("/&ndash;/g"),eval("/&mdash;/g"),eval("/&lsquo;/g"),eval("/&rsquo;/g"),eval("/&sbquo;/g"),eval("/&ldquo;/g"),eval("/&rdquo;/g"),eval("/&bdquo;/g"),eval("/&dagger;/g"),eval("/&Dagger;/g"),eval("/&permil;/g"),eval("/&lsaquo;/g"),eval("/&rsaquo;/g"));

/*
var UnicodeEntities = new Array(eval("/&#60;/g"),eval("/&#62;/g"),eval("/&#161;/g"),eval("/&#162;/g"),eval("/&#163;/g"),eval("/&#164;/g"),eval("/&#165;/g"),eval("/&#166;/g"),eval("/&#167;/g"),eval("/&#168;/g"),eval("/&#169;/g"),eval("/&#170;/g"),eval("/&#171;/g"),eval("/&#172;/g"),eval("/&#173;/g"),eval("/&#174;/g"),eval("/&#175;/g"),eval("/&#176;/g"),eval("/&#177;/g"),eval("/&#178;/g"),eval("/&#179;/g"),eval("/&#180;/g"),eval("/&#181;/g"),eval("/&#182;/g"),eval("/&#183;/g"),eval("/&#184;/g"),eval("/&#185;/g"),eval("/&#186;/g"),eval("/&#187;/g"),eval("/&#188;/g"),eval("/&#189;/g"),eval("/&#190;/g"),eval("/&#191;/g"),eval("/&#192;/g"),eval("/&#193;/g"),eval("/&#194;/g"),eval("/&#195;/g"),eval("/&#196;/g"),eval("/&#197;/g"),eval("/&#198;/g"),eval("/&#199;/g"),eval("/&#200;/g"),eval("/&#201;/g"),eval("/&#202;/g"),eval("/&#203;/g"),eval("/&#204;/g"),eval("/&#205;/g"),eval("/&#206;/g"),eval("/&#207;/g"),eval("/&#208;/g"),eval("/&#209;/g"),eval("/&#210;/g"),eval("/&#211;/g"),eval("/&#212;/g"),eval("/&#213;/g"),eval("/&#214;/g"),eval("/&#215;/g"),eval("/&#216;/g"),eval("/&#217;/g"),eval("/&#218;/g"),eval("/&#219;/g"),eval("/&#220;/g"),eval("/&#221;/g"),eval("/&#222;/g"),eval("/&#223;/g"),eval("/&#224;/g"),eval("/&#225;/g"),eval("/&#226;/g"),eval("/&#227;/g"),eval("/&#228;/g"),eval("/&#229;/g"),eval("/&#230;/g"),eval("/&#231;/g"),eval("/&#232;/g"),eval("/&#233;/g"),eval("/&#234;/g"),eval("/&#235;/g"),eval("/&#236;/g"),eval("/&#237;/g"),eval("/&#238;/g"),eval("/&#239;/g"),eval("/&#240;/g"),eval("/&#241;/g"),eval("/&#242;/g"),eval("/&#243;/g"),eval("/&#244;/g"),eval("/&#245;/g"),eval("/&#246;/g"),eval("/&#247;/g"),eval("/&#248;/g"),eval("/&#249;/g"),eval("/&#250;/g"),eval("/&#251;/g"),eval("/&#252;/g"),eval("/&#253;/g"),eval("/&#254;/g"),eval("/&#255;/g"),eval("/&#8211;/g"),eval("/&#8212;/g"),eval("/&#8216;/g"),eval("/&#8217;/g"),eval("/&#8218;/g"),eval("/&#8220;/g"),eval("/&#8221;/g"),eval("/&#8222;/g"),eval("/&#8224;/g"),eval("/&#8225;/g"),eval("/&#8240;/g"),eval("/&#8249;/g"),eval("/&#8250;/g"));
*/

function convert_HTML_entities(text)
{
	for(var i=0;i<maxChars;i++)
	{
		text=text.replace(NamedEntities[i],ISOChars[i]);
	}
	return text;
}
';
?>
