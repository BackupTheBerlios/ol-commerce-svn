<?php
/* -----------------------------------------------------------------------------------------
Template-specific(!) language file!!!!

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
Located in includes/classes/smarty/plugins

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

define('TEMPLATE_LANGUAGE',true);						// D o   n o t (!)  r e m o v e !!!!!!!!!!!!!

//Add further definitions

define('TEXT_ERROR_LINK_NOT_DEFINED','Es ist kein Link-Ziel definiert!');
define('TEXT_ERROR_WRONG_INI_ENTRY','Unvollständiger Eintrag in "%s"! ("%s")');
define('TEXT_ERROR_MISSING_INI_FILE','Fehlende Box-Ini-Datei: "');
define('TEXT_ERROR_MULTIPLE_INI_ENTRY','Mehrfach belegte Box-Position: Navigations-Bereich "%s", Position %s!');
$back_to="Zurück zu '".
define('ORDER_STEP_1_TITLE',$back_to."Versand'");
define('ORDER_STEP_2_TITLE',$back_to."Bezahlung'");
define('CART_DETAILS','Warenkorb-Details');
?>