<?php
/* --------------------------------------------------------------
$Id: english.php,v 1.1.1.1.2.1 2007/04/08 07:18:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2003	    neOL-Commerce; (english.php,v 1.8 2003/08/13); www.neOL-Commerce;.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/
// Global
define('TEXT_FOOTER','Copyright &copy; 2002-'.date('Y').' <a href="http://www.ol-Commerce.com/v5">OL-Commerce</a><br/>Powered by OL-Commerce/AJAX');

// Box names
define('BOX_LANGUAGE','System check and language selection');
define('BOX_DB_CONNECTION','Database and Webserver settings') ;
define('BOX_WEBSERVER_SETTINGS','Webserver settings');
define('BOX_DB_IMPORT','Import of basic shop-data');
define('BOX_DB_IMPORT_SUCCESS','Database import was successful');
define('BOX_WRITE_CONFIG','Create config files');
$configuration='-Configuration';
define('BOX_SHOP_CONFIG','Basic Shop'.$configuration);
define('BOX_ADMIN_CONFIG','Administrator'.$configuration);
define('BOX_USERS_CONFIG','Visitor'.$configuration);
define('BOX_FINISHED','Installation finished');

define('PULL_DOWN_DEFAULT','Please select a Country!');


// Error messages
// index.php
define('TITLE_SELECT_LANGUAGE','Please select a language<br/>Bitte wählen Sie eine Sprache!');
define('SELECT_LANGUAGE_ERROR',TITLE_SELECT_LANGUAGE);
// install_step2,5.php
define('TEXT_CONNECTION_ERROR','A test connection made to the database was NOT successful.');
define('TEXT_CONNECTION_SUCCESS','A test connection made to the database was successful.');
define('TEXT_DB_ERROR','The error message returned is: ');
define('TEXT_DB_ERROR_1','Please click on the <i>Back</i> graphic to review your database server settings.');
define('TEXT_DB_ERROR_2','If you require help with your database server settings, please consult your hosting company.');
// install_step6.php
$too_short='\' is too short';
define('ENTRY_FIRST_NAME_ERROR','\'Firstname'.$too_short);
define('ENTRY_LAST_NAME_ERROR','\'Lastname'.$too_short);
define('ENTRY_EMAIL_ADDRESS_ERROR','\'eMail'.$too_short);
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR','Check the \'eMail\' format');
define('ENTRY_STREET_ADDRESS_ERROR','\'Street'.$too_short);
define('ENTRY_POST_CODE_ERROR','\'Post Code'.$too_short);
define('ENTRY_CITY_ERROR','\'City'.$too_short);
define('ENTRY_COUNTRY_ERROR','Check Country');
define('ENTRY_STATE_ERROR','Check State');
define('ENTRY_TELEPHONE_NUMBER_ERROR','\'Telephone number'.$too_short);
define('ENTRY_PASSWORD_ERROR','Check Password');
define('ENTRY_STORE_NAME_ERROR','\'Store name'.$too_short);
define('ENTRY_COMPANY_ERROR','\'Company name'.$too_short);
define('ENTRY_EMAIL_ADDRESS_FROM_ERROR','\'eMail-From'.$too_short);
define('ENTRY_EMAIL_ADDRESS_FROM_CHECK_ERROR','Check the \'eMail-From\' format');
define('SELECT_ZONE_SETUP_ERROR','Select Zone setup');
// install_step7.php
define('ENTRY_DISCOUNT_ERROR','Product discount (Guest)');
define('ENTRY_OT_DISCOUNT_ERROR','Discount on ot (Guest)');
define('SELECT_OT_DISCOUNT_ERROR','Discount on ot (Guest)');
define('SELECT_GRADUATED_ERROR','Graduated Prices (Guest)');
define('SELECT_PRICE_ERROR','Show Price (Guest)');
define('SELECT_TAX_ERROR','Show Tax (Guest)');
define('ENTRY_DISCOUNT_ERROR2','Product discount (Default)');
define('ENTRY_OT_DISCOUNT_ERROR2','Discount on ot (Default)');
define('SELECT_OT_DISCOUNT_ERROR2',ENTRY_OT_DISCOUNT_ERROR2);
define('SELECT_GRADUATED_ERROR2','Graduated Prices (Default)');
define('SELECT_PRICE_ERROR2','Show Price (Default)');
define('SELECT_TAX_ERROR2','Show Tax (Default)');

// index.php
define('TITLE_SELECT_LANGUAGE','Select your language!');

define('TEXT_WELCOME_STEP1',
'<div class="title">Welcome to OL-Commerce v5/AJAX</div><div>OL-Commerce is an open source e-commerce solution under on going development by the OL-Commerce Team and its community.<br/> Its feature packed out-of-the-box installation allows store owners to setup, run, and maintain their online stores with minimum effort and with no costs involved.<br/> OL-Commerce combines open source solutions to provide a free and open development platform, which includes the powerful PHP web scripting language, the stable Apache web server, and the fast MySQL database server.<br/><br/>With no restrictions or special requirements, OL-Commerce can be installed on any PHP4 enabled web server, on any environment that PHP and MySQL supports, which includes Linux, Solaris, BSD, and Microsoft Windows environments.<br/><br/><b>Willkommen zu OL-Commerce</b><br/><br/>OL-Commerce ist eine Open-Source e-commerce Lösung, die ständig vom OL-Commerce Team und einer grossen Gemeinschaft weiterentwickelt wird.<br/> Seine out-of-the-box Installation erlaubt es dem Shop-Besitzer seinen Online-Shop mit einem Minimum an Aufwand und Kosten zu installieren, zu betreiben und zu verwalten.<br/><br/>OL-Commerce ist auf jedem System lauffähig, welches eine PHP Umgebung (ab PHP 4.3) und mySQL zur Verfügung stellt, wie zum Beispiel Linux, Solaris, BSD, und Microsoft Windows.</div>');

define('TEXT_WELCOME_STEP2','<div class="title">Main database and webserver settings</div><div class="sub_title">Please enter your Database and webserver settings.<br/></div>');
define('TEXT_WELCOME_STEP3','<div class="title">Import database</div><div class="sub_title">The OL-Commerce installer will automatically install the OL-Commerce database.</div>');
define('TEXT_WELCOME_STEP4','<div class="title">Database import.</div><div class="sub_title">The base data for the OL-Commerce database are automatically imported into the database.</div>');
/*
define('TEXT_WELCOME_STEP5','<div class="title">Configure OL-Commerce main files</div><div class="sub_title"><b><font color="red">If there are old configure files from a further installation, OL-Commerce will delete them!</font></b></br><br/>The installer will set up the configuration files with the main parameters for database and directory structure.</div>');
*/
define('TEXT_WELCOME_STEP5','<div class="title">Web-server Configuration</div><div class="sub_title">The Web-server information will be collected.</div>');
define('TEXT_WELCOME_STEP6','<div class="title">Basic shop configuration</div><div class="sub_title">The installer will create the admin account and will perform some db actions.<br/><br/>The given informations for <b>Country</b> and <b>Post Code</b> are used for shipping and tax callculations.<br/><br/>If you wish, OL-Commerce; can automatically setup the zones,tax-rates and tax-classes for delivering/selling within the European Union.<br/>Just set <b>setup zones for EU</b> to <b>YES</b>.</div>');
define('TEXT_WELCOME_STEP7','<div class="title">Guest and default customers setup</div><div class="sub_title">The OL-Commerce group- and pricesystem got nearly infinite possibilities of different prices.<br/><br/>
<b>% discount on single product</b><br/><br/>
%max can be set for every single product, and single customers group<br/>
if %max at product = 10.00% and %max for group = 5%<br/>-&gt; 5% discount on product<br/>
if %max at product = 10.00% and %max for group = 15%<br/>-&gt; 10% discount on product<br/><br/><br/>
<b>% discount on order total</b><br/><br/>
% discount on total order sum (after tax and currencies calculations)<br/><br/>
<b>Graduated price</b><br/><br/>
You also can set infinite graduated prices for a single product and single customers group.<br/>
you also are able to combine any of those systems, like:<br/>
user group 1 -&gt; graduated prices on product Y<br/>
user group 2 -&gt; 10% discount on product Y<br/>
user group 3 -&gt; a special group price on product Y<br/>
user group 4 -&gt; netto price on product Y</p></div>');
define('TEXT_WELCOME_STEP8','<div class="title">OL-Commerce installation was successful!</div><div class="sub_title">The installer has now created the basic functionality of your shop. Please login with your admin-account and visit the admin-area, in order to complete the shop-configuration.</div>');
// install_step1.php

define('TITLE_CUSTOM_SETTINGS','Custom Settings');
define('TEXT_IMPORT_DB','Import OL-Commerce Database');
define('TEXT_IMPORT_DB_LONG','Import the OL-Commerce database structure which includes tables and sample data.');
define('TEXT_AUTOMATIC','Automatic Configuration');
define('TEXT_AUTOMATIC_LONG','The information you submit regarding the web server and database server will be automatically saved into both OL-Commerce Shop and Administration Tool configuration files.');
define('TITLE_DATABASE_SETTINGS','Database Settings');
define('TEXT_DATABASE_SERVER','Database Server');
define('TEXT_DATABASE_SERVER_LONG','The database server can be in the form of a hostname, such as <i>db1.myserver.com</i>, or as an IP address, such as <i>192.168.0.1</i>.');
define('TEXT_USERNAME','Username');
define('TEXT_USERNAME_LONG','The username is used to connect to the database server. An example username is <i>mysql_10</i>.<br/><br/>Note: If the OL-Commerce; Database is to be imported (selected above), the account used to connect to the database server needs to have Create and Drop permissions.');
define('TEXT_PASSWORD','Password');
define('TEXT_PASSWORD_LONG','The password is used together with the username, which forms the database user account.');
define('TEXT_DATABASE','Database');
define('TEXT_DATABASE_LONG','The database used to hold the catalog data. An example database name is <i>OL-Commerce;</i>.<br/><b>ATTENTION:</b> OL-Commerce need an empty Database to perform Installation.');
define('TITLE_WEBSERVER_SETTINGS','Webserver Settings');
define('TEXT_WS_ROOT','Webserver Root Directory');
define('TEXT_WS_ROOT_LONG','The directory where your web pages are being served from, usually <i>/home/myname/public_html</i>.');
define('TEXT_WS_OLC','Webserver "OL-Commerce" Directory');
define('TEXT_WS_OLC_LONG','The directory where your catalog pages are being served from (from the webserver root directory), usually <i>/home/myname/public_html<b>/OL-Commerce;/</b></i>.');
define('TEXT_WS_ADMIN','Webserver Administration Tool Directory');
define('TEXT_WS_ADMIN_LONG','The directory where your administration tool pages are being served from (from the webserver root directory), usually <i>/home/myname/public_html<b>/OL-Commerce;/admin/</b></i>.');
define('TEXT_WS_CATALOG','WWW Catalog Directory');
define('TEXT_WS_CATALOG_LONG','The virtual directory where the OL-Commerce Catalog module resides, usually <i>/OL-Commerce;/</i>.');
define('TEXT_WS_ADMINTOOL','WWW Administration Tool Directory');
define('TEXT_WS_ADMINTOOL_LONG','The virtual directory where the OL-Commerce Administration Tool resides, usually <i>/OL-Commerce;/admin/</i>');

// install_step2.php

define('TEXT_PROCESS_1','Please continue the installation process to execute the database import procedure.');
define('TEXT_PROCESS_2','It is important this procedure is not interrupted, otherwise the database may end up corrupt.');
define('TEXT_PROCESS_3','The file to import must be located and named at: ');


// install_step3.php

define('TEXT_TITLE_ERROR','The following error has occurred: ');
define('TEXT_TITLE_SUCCESS','The database import was successful!');

// install_step4.php
define('TITLE_WEBSERVER_CONFIGURATION','Webserver Configuration: ');
define('TITLE_STEP4_CONFIG','In the next step the following configuration files will be generated:');
define('TITLE_STEP4_ERROR','The following error has occurred: ');
define('TEXT_STEP4_ERROR','<b>The configuration files do not exist, or permission levels are not set.</b><br/><br/>Please perform the following actions: ');
define('TEXT_STEP4_ERROR_1','Please set the access-rights to "<b>read/write</b>"-access ("777" für LINUX/UNIX) with your FTP-program or local explorer for the following files:');
define('TEXT_VALUES','The following configuration values will be written to: ');
define('TITLE_CHECK_CONFIGURATION','Your web-server informations');
define('TEXT_HTTP','HTTP Server');
define('TEXT_HTTP_LONG','The web server can be in the form of a hostname, such as <i>http://www.myserver.com</i>, or as an IP address, such as <i>http://192.168.0.1</i>.');
define('TEXT_HTTPS','HTTPS Server');
define('TEXT_HTTPS_LONG','The secure web server can be in the form of a hostname, such as  <i>https://www.myserver.com</i>, or as an IP address, such as <i>https://192.168.0.1</i>.');
define('TEXT_SSL','Enable SSL Connections');
define('TEXT_SSL_LONG','Enable Secure Connections With SSL ("https"-protocol). (Of course your server must support this feature, in order for yout to use it!.)');
define('TITLE_CHECK_DATABASE','Your database-server information');
define('TEXT_PERSIST','Enable Persistent Connections');
define('TEXT_PERSIST_LONG','Enable persistent database connections. Please disable this if you are on a shared server.');
define('TEXT_SESS_FILE','Store Sessions as Files');
define('TEXT_SESS_DB','Store Sessions in the Database');
define('TEXT_SESS_LONG','The location to store PHPs sessions files.');

// install_step5.php

define('TEXT_WS_CONFIGURATION_SUCCESS','The OL-Commerce</strong> Webserver configuration was successful');

// install_step6.php

define('TITLE_ADMIN_CONFIG',BOX_ADMIN_CONFIG.HTML_BR);
define('TEXT_REQU_INFORMATION',' required information');
define('TEXT_FIRSTNAME','First Name: ');
define('TEXT_LASTNAME','Last Name: ');
define('TEXT_EMAIL','E-Mail Address: ');
define('TEXT_EMAIL_LONG','(for receiving orders)');
define('TEXT_STREET','Street Address: ');
define('TEXT_POSTCODE','Post Code: ');
define('TEXT_CITY','City: ');
define('TEXT_STATE','State/Province: ');
define('TEXT_COUNTRY','Country: ');
define('TEXT_COUNTRY_LONG','Will be used for shipping and tax');
define('TEXT_TEL','Telephone  Number: ');
define('TEXT_PASSWORD','Password: ');
define('TEXT_PASSWORD_CONF','Password Confirmation: ');
define('TITLE_SHOP_CONFIG','Shop configuration');
define('TITLE_COMPANY_DATA_CONFIG','Company data');
define('TEXT_STORE','Store Name: ');
define('TEXT_STORE_LONG','(The name of my store)');
define('TEXT_EMAIL_FROM','E-Mail From');
define('TEXT_EMAIL_FROM_LONG','(The e-mail adress used in (sent) e-mails)');
define('TITLE_ZONE_CONFIG','Zone configuration');
define('TEXT_ZONE','Set up zones for EU?');
define('TITLE_ZONE_CONFIG_NOTE','OL-Commerce; can automatically setup the right Zone-Setup if your store is located within the EU.');
define('TITLE_SHOP_CONFIG_NOTE','Basic Shop configuration');
define('TITLE_COMPANY_DATA_CONFIG_NOTE','Basic '.TITLE_SHOP_CONFIG);
define('TITLE_ADMIN_CONFIG_NOTE','Information about the Admininistrator');
define('TEXT_ZONE_NO','No');
define('TEXT_ZONE_YES','Yes');
define('TEXT_COMPANY','Company name');

// install_step7
define('TITLE_GUEST_CONFIG','Guest configuration');
define('TITLE_GUEST_CONFIG_NOTE','Settings for standard user (non-regristrated customer)');
define('TITLE_CUSTOMERS_CONFIG','Default customers configuration');
define('TITLE_CUSTOMERS_CONFIG_NOTE','Settings for standard user (regristrated customer)');
define('TEXT_STATUS_DISCOUNT','Product discount');
define('TEXT_STATUS_DISCOUNT_LONG','discount on products <i>(in percent, like 10.00 , 20.00)</i>');
define('TEXT_STATUS_OT_DISCOUNT_FLAG','Discount on order total');
define('TEXT_STATUS_OT_DISCOUNT_FLAG_LONG','allow guest to get discount on total order price');
define('TEXT_STATUS_OT_DISCOUNT','Discount on order total');
define('TEXT_STATUS_OT_DISCOUNT_LONG','discount on order total <i>(in percent, like 10.00 , 20.00)</i>');
define('TEXT_STATUS_GRADUATED_PRICE','Graduated price');
define('TEXT_STATUS_GRADUATED_PRICE_LONG','allow user to see gratuated prices');
define('TEXT_STATUS_SHOW_PRICE','Show price');
define('TEXT_STATUS_SHOW_PRICE_LONG','allow user to see product-price in shop');
define('TEXT_STATUS_SHOW_TAX','Show tax');
define('TEXT_STATUS_SHOW_TAX_LONG','Display prices with tax included (Yes) or without any tax (No)');

define('TITLE_CHMOD','Setting rights on files');
// install_fnished.php

define('TEXT_SHOP_CONFIG_SUCCESS','<strong>OL-Commerce</strong> Shop configuration was successful.');
define('TEXT_TEAM','Thank you for choosing OL-Commerce. Visit us on the OL-Commerce support site <br/><br/>
<a href="http://www.ol-Commerce.com/v5>http://www.ol-Commerce.com/v5</a><br/><br/>Good luck and much success wishes the OL-Commerce Team.');

define('TEXT_ADD_ONS','<br/><b><font color="Blue">You may now install further modules.</font></b><br/><br/>(The <B>password</B> for these modules has already been set to your <B>Adminstrator-Password</B>.)');

define('TEXT_RENAME_DIR','Please delete the directory "xtc_installer" (or rename it)!<br/><br/>Otherwise your shop might be manipulated from outside!');
define('TEXT_RENAMED_DIR','For security reasons, the installation directory \'%s\' was renamed to \'%s\'!');

define('TEXT_LIVEHELP_INSTALL','Install "Live Help"');
define('TEXT_ELMAR_INSTALL','Install Elm@r');
define('TEXT_CHCOUNTER_INSTALL','Install Shop-Statistics (chCounter)');
define('TEXT_TESTDATA_EXPLAIN','We have prepared a set of <b>test-data</b>, so that you can immediately start to test the shop-system. Download and extract the ZIP-archive with the data, and follow the installation hints included.');
define('TEXT_TESTDATA_LOAD','Load test-data');

$step_text='Installations-Step ';
define('INSTALLATION_STEP_TEXT', $step_text);
define('BUTTON_BACK_TEXT', 'Back to '.$step_text);
define('BUTTON_CANCEL_TEXT', BUTTON_BACK_TEXT);
define('BUTTON_CONTINUE_TEXT', 'Continue to '.$step_text);
define('BUTTON_RETRY_TEXT', 'Retry '.$step_text);
define('BUTTON_START_SHOP_TEXT', 'Start OL-Commerce');
define('BUTTON_START_ADMIN_TEXT', BUTTON_START_SHOP_TEXT.' administration');

define('ERROR_NO_SQL_FILE','SQL-file not found: ');
define('ERROR_WRONG_SQL_STATEMENT','Illegal SQL-command:');
define('PARSE_TIME_STRING','%s seconds');
define('TEXT_PARSE_TIME','%s SQL-commands were executed in %s<br/><span class="text">(%s SQL-commands per second)</span>');

define('ERROR_WRONG_PERMISSION','<br/><br/><font color="blue"><b>The following # have insufficient access-rights!</b></font><br/>(Write-access is required! ("chmod 777" for LINUX/UNIX))<br/><br/>');
define('STEP_TEXT','Step ');
define('FILE_ACCESS_RIGHTS','File-access-rights');
define('ERROR_ILLEGAL_PHP_VERSION',
'<br/><br/><b>ATTENTION!, Your PHP Version is too old! OL-Commerce requires at least PHP 4.3.0.</b><br/><br/>
Your PHP Version: <b>#</b><br/><br/>
OL-Commerce can not run on this server. Upgrade PHP or change the server.');

define('GDLIB_SUPPORT','GDlib GIF-Support');
define('ERROR_NO_GDLIB','<br/>Module GDLIB not found!');
define('ERROR_NO_GIF_SUPPORT','<br/>You do not have GIF-Support in Your GDLIB! You can not use GIF-images and GIF Overlay-Functions in OL-Commerce!');
define('TEXT_DIRECTORIES','Directories');
define('TEXT_FILES','Files');
define('TEXT_DIRECTORIES_ACCESS_RIGHTS','directory access-rights');
define('TEXT_ATTENTION','Attention!');
define('TEXT_TESTS','Tests');
define('TEXT_GERMAN','Deutsch');
define('TEXT_ENGLISH','English');
define('ERROR_CORRECT_PROBLEMS','Please correct the problems, and then click on "retry"!');

define('AJAX_LOGO_TITLE','AJAX-Informations on Wikipedia');
define('AJAX_LOGO_LINK','http://en.wikipedia.org/wiki/Ajax_(programming)');
define('TEXT_DB_BEING_INSTALLED','The database is being imported...');
define('TEXT_OPTIONAL_COMPANY_FIELDS','<font color="blue">The following company informations can also be defined later in the admin-area ("%s/%s").<br/><br/>We recommend however to input them already now!</font>');
define('TEXT_STEP_ERROR','Error in the installation steps sequence');
define('TEXT_STEP_ERROR_1','Step %s must be executed before step %s!');
define('TEXT_ADD_ON_MODULES','Install add-on modules');
define('TEXT_TEST_DATA','Load test-data');
define('TEXT_START_SHOP','Start OL-Commerce');
define('TEXT_START_SHOP_WARNING',
'With rstrivtively configured Servers there might appear a message, that the template directory'.
'in folder "templates_c" does not posess suficient access-rights.<br/><br/>'.'
Assign the proper access-rights, and restart the shop!');
?>