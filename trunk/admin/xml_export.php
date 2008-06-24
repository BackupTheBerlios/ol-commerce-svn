<?
/*******************************************************************************************
*                                                                                          *
*  CAO-Faktura für Windows Version 1.2 (http://www.cao-wawi.de)                            *
*  Copyright (C) 2003 Jan Pokrandt / Jan@JP-SOFT.de                                        *
*                                                                                          *
*  This program is free software; you can redistribute it and/or                           *
*  modify it under the terms of the GNU General Public License                             *
*  as published by the Free Software Foundation; either version 2                          *
*  of the License, or any later version.                                                   *
*                                                                                          *
*  This program is distributed in the hope that it will be useful,                         *
*  but WITHOUT ANY WARRANTY; without even the implied warranty of                          *
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                           *
*  GNU General Public License for more details.                                            *
*                                                                                          *
*  You should have received a copy of the GNU General Public License                       *
*  along with this program; if not, write to the Free Software                             *
*  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.             *
*                                                                                          *
*  ******* CAO-Faktura comes with ABSOLUTELY NO WARRANTY ***************                   *
*                                                                                          *
********************************************************************************************
*                                                                                          *
* Eine Entfernung oder Veraenderung dieses Dateiheaders ist nicht zulaessig !!!            *
* Wenn Sie diese Datei veraendern dann fuegen Sie ihre eigenen Copyrightmeldungen          *
* am Ende diese Headers an                                                                 *
*                                                                                          *
********************************************************************************************
*                                                                                          *
*  Programm     : CAO-Faktura                                                              *
*  Modul        : xml_export.php                                                              *
*  Stand        : 02.11.2005                                                               *
*  Version      : 1.51                                                                     *
*  Beschreibung : Script zum Datenaustausch CAO-Faktura <--> OL-Commerce-Shop               *
*                                                                                          *
*  based on:                                                                               *
* (c) 2000 - 2001 The Exchange Project                                                     *
* (c) 2001 - 2003 osCommerce, Open Source E-Commerce Solutions                             *
* (c) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers                                      *
* (c) 2003 JP-Soft, Jan Pokrandt                                                           *
* (c) 2003 IN-Solution, Henri Schmidhuber                                                  *
* (c) 2003 www.websl.de, Karl Langmann                                                     *
* (c) 2003 RV-Design Raphael Vullriede                                                     *
* (c) 2004 XT-Commerce                                                                     *
*                                                                                          *
* Released under the GNU General Public License                                            *
*                                                                                          *
*  History :                                                                               *
*                                                                                          *
*  - 25.06.2003 JP Version 0.1 released                                                    *
*  - 26.06.2003 HS beim Orderexport orderstatus und comment hinzugefuegt                   *
*  - 29.06.2003 JP order_update entfernt und in die Datei cao_update.php verschoben        *
*  - 17.07.2003 tep_array_merge durch array_merge ersetzt                                  *
*  - 18.07.2003 Code fuer Image_Upload hinzugefuegt                                        *
*  - 20.07.2003 HS Shipping und Paymentklassen aufgenommen                                 *
*  - 02.08.2003 KL MANUFACTURERS_DESCRIPTION  language_id geändert in languages_id         *
*  - 09.08.2003 JP fuer das Modul Banktransfer werden jetzt die daten bei der Bestll-      *
*                  uebermittlung mit ausgegeben                                            *
*  - 10.08.2003 JP Geburtsdatum wird jetzt in den Bestellungen mit uebergeben              *
*  - 18.08.2003 JP Bug bei Products/URL beseitigt                                          *
*  - 18.08.2003 HS Bankdaten werden nur bei Banktransfer ausgelesen                        *
*  - 23.08.2003 Code fuer Hersteller-Update hinzugefuegt                                   *
*  - 25.10.2003 RV Kunden-Export hinzugefügt                                               *
*  - 24.11.2003 HS Fix Kunden-Export - Newsletterexport hinzugefügt                        *
*  - 01.12.2003 RV Code für 3 Produktbilder-Erweiterung hinzugefügt.                       *
*  - 31.01.2004 JP Resourcenverbrauch minimiert                                            *
*                  tep_set_time_limit ist jetzt per DEFINE zu- und abschaltbar             *
*  - 06.06.2004 JP per DEFINE kann jetzt die Option "3 Produktbilder" geschaltet werden    *
*  - 09.10.2004 RV automatisch Erkennung von 3 Bilder Contrib laut readme                  *
*  - 09.10.2004 RV vereinheitlicher Adress-Export bei Bestellungen und Kunden              *
*  - 09.10.2004 RV Kunden Vor- und Nachname bei Bestellungen getrennt exportieren          *
*  - 09.10.2004 RV SQL-Cleanup                                                             *
*  - 09.10.2004 RV CODE-Cleanup                                                            *
*  - 14.10.2004 RV Länder bei Bestellungen als ISO-Code                                    *
*  - 25.10.2003 Kunden-Update hinzugefügt                                                  *
*  - 01.11.2003 Statusänderung werden wenn möglich in der Bestellsprache ausgeführt        *
*             Copyright (c) 2004 XT-Commerce                                               *
*              1.1  switching POST/GET vars for CAO imageUpload                            *
*              1.2  mulitlang inserts for Categories                                       *
*              1.3  xt:C v3.0 update                                                       *
*  - 03.12.2003 JP Bugfix beim Kunden-Export (Fehlende Felder)                             *
*               OLC  1.1 fixed bug with attributes and products qty > 1                    *
*               OLC  1.2 Updates for xt:C 3.0                                              *
*  - 10.12.2004 JP Anpassungen fuer CAO 1.2.6.x (customers_export, orders_export)          *
*  - 10.12.2004 JP Anpassungen an CAO-Faktura 1.2.6.1                                      *
*  - 01.06.2005 JP Bugfix MWST-Switch
*  - 01.06.2005 KL/JP Anpassungen für IMAGE_MANIPULATOR (OLC 2.x und 3.x)                  *
*  - 19.08.2005 JP Bugfix beim Aktualisieren von Kunden (PW wurde neu gesetzt)             *
*  - 24.08.2005 TKI Bugfix MWST-Switch                                                     *
*               products_tax_class_id statt $products['products_tax_class_id']             *
*  - 04.10.2005 JP/KL Version 1.44 released, Scripte komplett ueberarbeitet                *
*  - 06.10.2005 KL/JP Bugfix bei olc_set_time_limit                                        *
*  - 17.10.2005 JP Bugfixes fuer OLC 304                                                   *
*  - 21.10.2005 JP Bugfix bei Passwortuebergabe wenn das Passwort als erstes ein           *
*               numerisches Zeichen enthielt                                               *
*  - 02.11.2005 JP Fehler bei doppelter Funktion xtDBquery gefixt                          *
*  - 24.09.2006 W. Kaiser - Integration in olc Admin-Menü                                  *
*  - 24.09.2006 W. Kaiser - Anpassung an 'pictures-on-the-fly                              *
*******************************************************************************************/


define('SET_TIME_LIMIT',1);   // use set_time_limit(0);
define('CHARSET', 'ISO-8859-1');

$version_nr    = '1.51';
$version_datum = '2005.09.14';

// falls die MWST vom shop vertauscht wird, hier true setzen.
define('SWITCH_MWST',false);

define ('LOGGER',false); // Um das Loggen einzuschalten false durch true ersetzen.

// Emails beim Kundenanlegen versenden ?
define('SEND_ACCOUNT_MAIL',false);

//W. Kaiser
//Tight integration into admin menu
define('INTEGRATE_INTO_OLC',isset($_GET['i']));
//W. Kaiser

if (INTEGRATE_INTO_OLC)
{
	require('includes/application_top.php');
}
else
{
	require('../includes/application_top_export.php');
	if ((isset($_POST['user']))and(isset($_POST['password'])))
	{
		$user=$_POST['user'];
		$password=$_POST['password'];
	}
	else
	{
		$user=$_GET['user'];
		$password=$_GET['password'];
	}
	if ($user=='' or $password=='')
	{
		require_once(DIR_FS_INC.'olc_draw_form.inc.php');
		require_once(DIR_FS_INC.'olc_draw_input_field.inc.php');
		require_once(DIR_FS_INC.'olc_draw_password_field.inc.php');
		require_once(DIR_FS_INC.'olc_parse_input_field_data.inc.php');
		require_once(DIR_FS_INC.'olc_not_null.inc.php');
		require_once(DIR_FS_INC.'olc_href_link.inc.php');
		require_once(DIR_FS_INC.'olc_check_agent.inc.php');

		$main_content='
<html><head><title></title></head><body>
<h3>CAO-Faktura - OL-Commerce Shopanbindung</h3>
<p>
'.olc_draw_form('cao',basename($PHP_SELF),'get').'
		<table border="0" width="300" id="table1">
		<tr>
			<td>Email:&nbsp;&nbsp; </td>
			<td>'.olc_draw_input_field('user','','size="20"').'</td>
		</tr>
		<tr>
			<td>Password:&nbsp; </td>
			<td>'.olc_draw_password_field('password','','size="20"').'</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" value="Absenden" name="B1">&nbsp; <input type="reset" value="Zurücksetzen" name="B2"></td>
		</tr>
	</table>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
	<p>&nbsp; </p>
</form></p>
</body></html>
';
		echo $main_content;
		exit;
	}
	else
	{
		// security  1.check if admin user with this mailadress exits, and got access to xml-export
		//           2.check if pasword = true
		if (column_exists (TABLE_ADMIN_ACCESS ,'xml_export')==false)
		{
			olc_db_query('ALTER TABLE ' . TABLE_ADMIN_ACCESS . ' ADD xml_export INT(1)  DEFAULT "0";');
			olc_db_query('SQL_UPDATE ' . TABLE_ADMIN_ACCESS . ' SET xml_export= 1 WHERE customers_id=\'1\';');
		}
		$check_customer_query=olc_db_query("select customers_id,
                                      customers_status,
                                      customers_password
                                      from " . TABLE_CUSTOMERS . " where
                                      customers_email_address = '" . $user . "'");
		if (!olc_db_num_rows($check_customer_query))
		{
			SendXMLHeader ();
			print_xml_status (105, $_POST['action'], 'WRONG LOGIN', '', '', '');
			exit;
		}
		else
		{
			$check_customer = olc_db_fetch_array($check_customer_query);
			// check if customer is Admin
			if ($check_customer['customers_status']!='0')
			{
				SendXMLHeader ();
				print_xml_status (106, $_POST['action'], 'WRONG LOGIN', '', '', '');
				exit;
			}
			// check if Admin is allowed to access xml_export
			$access_query=olc_db_query("SELECT
                                xml_export
                                from " . TABLE_ADMIN_ACCESS . "
                                WHERE customers_id='".$check_customer['customers_id']."'");
			$access_data = olc_db_fetch_array($access_query);
			if ($access_data['xml_export']!=1)
			{
				SendXMLHeader ();
				print_xml_status (107, $_POST['action'], 'WRONG LOGIN', '', '', '');
				exit;
			}
			$customers_password=$check_customer['customers_password'];
			if (!( ($customers_password == $password) or
			($customers_password == md5($password)) or
			($customers_password == md5(substr($password,2,40)))
			))
			{
				SendXMLHeader ();
				print_xml_status (108, $_POST['action'], 'WRONG PASSWORD', '', '', '');
				exit;
			}
		}
	}
}
//W. Kaiser - Replace hard config with shop data
// Default-Sprache
$languages_query = olc_db_query("select languages_id, name, code, image, directory from " .
TABLE_LANGUAGES . " where code='".DEFAULT_LANGUAGE.APOS);
$language = olc_db_fetch_array($languages_query);
$LangID = $language['languages_id'];
$Lang_folder = $language['directory'];
// Steuer Einstellungen für CAO-Faktura
/*
$order_total_class['ot_cod_fee']['prefix'] = '+';
$order_total_class['ot_cod_fee']['tax'] = '16';

$order_total_class['ot_customer_discount']['prefix'] = '-';
$order_total_class['ot_customer_discount']['tax'] = '16';

$order_total_class['ot_gv']['prefix'] = '-';
$order_total_class['ot_gv']['tax'] = '0';

$order_total_class['ot_loworderfee']['prefix'] = '+';
$order_total_class['ot_loworderfee']['tax'] = '16';

$order_total_class['ot_shipping']['prefix'] = '+';
$order_total_class['ot_shipping']['tax'] = '16';
*/

require_once(DIR_FS_INC.'olc_get_tax_rate.inc.php');
$std_tax=olc_get_tax_rate(MODULE_SHIPPING_ZONES_TAX_CLASS);

$order_total_class['ot_cod_fee']['prefix'] = '+';
$order_total_class['ot_cod_fee']['tax'] = olc_get_tax_rate(MODULE_ORDER_TOTAL_COD_TAX_CLASS);

$order_total_class['ot_customer_discount']['prefix'] = '-';
$order_total_class['ot_customer_discount']['tax'] = $std_tax;

$order_total_class['ot_gv']['prefix'] = '-';
$order_total_class['ot_gv']['tax'] = olc_get_tax_rate(MODULE_ORDER_TOTAL_GV_TAX_CLASS);

$order_total_class['ot_loworderfee']['prefix'] = '+';
$order_total_class['ot_loworderfee']['tax'] = $std_tax;

$order_total_class['ot_shipping']['prefix'] = '+';
$order_total_class['ot_shipping']['tax'] = olc_get_tax_rate(MODULE_SHIPPING_ZONES_TAX_CLASS);
//W. Kaiser - Replace hard config with shop data

define ('_VALID_OLC',false);

// Kundengruppen id für Neukunden (default "neue Kunden einstellungen in OLC")
define('STANDARD_GROUP',DEFAULT_CUSTOMERS_STATUS_ID);

include(DIR_WS_CLASSES.'image_manipulator.php');

require ('xml_export_cao_olc_functions.php');

if ($_SERVER['REQUEST_METHOD']=='GET')
{
	switch ($_GET['action'])
	{
		case 'version':        // Ausgabe Scriptversion

		SendXMLHeader ();
		SendScriptVersion ();
		exit;

		case 'categories_export':

			SendXMLHeader ();
			SendCategories ();
			exit;

		case 'manufacturers_export':

			SendXMLHeader ();
			SendManufacturers ();
			exit;

		case 'orders_export':

			SendXMLHeader ();
			SendOrders ();
			exit;

		case 'products_export':

			SendXMLHeader ();
			SendProducts ();
			exit;

		case 'customers_export':

			SendXMLHeader ();
			SendCustomers ();
			exit;

		case 'customers_newsletter_export':

			SendXMLHeader ();
			SendCustomersNewsletter ();
			exit;

		case 'config_export':

			SendXMLHeader ();
			SendShopConfig ();
			exit;

		case 'update_tables':

			UpdateTables ();
			exit;

		default :

			ShowHTMLMenu ();
			exit;

	} // End Case
} // End Method POST
else
{
	if ($_SERVER['REQUEST_METHOD']=='POST')
	{
		switch ($_POST['action'])
		{
			case 'manufacturers_image_upload':

				SendXMLHeader ();
				ManufacturersImageUpload ();
				exit;

			case 'categories_image_upload':

				SendXMLHeader ();
				CategoriesImageUpload ();
				exit;

			case 'products_image_upload':

				SendXMLHeader ();
				ProductsImageUpload ();
				exit;

			case 'products_image_upload_med':

				SendXMLHeader ();
				ProductsImageUploadMed ();
				exit;

			case 'products_image_upload_large':

				SendXMLHeader ();
				ProductsImageUploadLarge ();
				exit;

			case 'manufacturers_update':

				SendXMLHeader ();
				ManufacturersUpdate ();
				exit;

			case 'manufacturers_erase':

				SendXMLHeader ();
				ManufacturersErase ();
				exit;

			case 'products_update':

				SendXMLHeader ();
				ProductsUpdate ();
				exit;

			case 'products_erase':

				SendXMLHeader ();
				ProductsErase ();
				exit;

			case 'products_specialprice_update':

				SendXMLHeader ();
				ProductsSpecialPriceUpdate ();
				exit;

			case 'products_specialprice_erase':

				SendXMLHeader ();
				ProductsSpecialPriceErase ();
				exit;

			case 'categories_update':

				SendXMLHeader ();
				CategoriesUpdate ();
				exit;

			case 'categories_erase':

				SendXMLHeader ();
				CategoriesErase ();
				exit;

			case 'prod2cat_update':

				SendXMLHeader ();
				Prod2CatUpdate ();
				exit;

			case 'prod2cat_erase':

				SendXMLHeader ();
				Prod2CatErase ();
				exit;

			case 'order_update':

				SendXMLHeader ();
				OrderUpdate ();
				exit;

			case 'customers_update':

				SendXMLHeader ();
				CustomersUpdate ();
				exit;

			case 'customers_erase':

				SendXMLHeader ();
				CustomersErase ();
				exit;

		} // End Case
	}  // End Method POST
}
?>