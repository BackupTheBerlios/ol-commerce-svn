<?php
/* -----------------------------------------------------------------------------------------
$Id: german.php,v 2.0.0 2006/12/14 05:49:08 gswkaiser Exp $
=======
$Id: german.php,v 1.1.1.2 2006/12/23 11:24:19 gswkaiser Exp $


OL-Commerce Version 1.0
http://www.ol-commerce.com

Copyright (c) 2004 OL-Commerce
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(german.php,v 1.119 2003/05/19); www.oscommerce.com
(c) 2003	    nextcommerce (german.php,v 1.25 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

if (!defined('DATE_FORMAT_SHORT'))
{
	// look in your $PATH_LOCALE/locale directory for available locales..
	// on RedHat try 'de_DE'
	// on FreeBSD try 'de_DE.ISO_8859-15'
	// on Windows try 'de' or 'German'
	$loc_de = setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge', 'de_DE.ISO_8859-15', 'German');
	setlocale(LC_NUMERIC,'C');			//Do  n o t (repeat:  n o t) change this!!! W. Kaiser
	//echo "Preferred locale for german on this system is '$loc_de'";
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Windows'))
	{
		$loc_de = 'german';
	}
	else
	{
		$loc_de = 'de_DE';
	}
	if ((int)phpversion()>=5)
	{
		date_default_timezone_set('Europe/Berlin');
	}
	@setlocale(LC_TIME, $loc_de);
	//$loc_de = setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge', 'de_DE.ISO_8859-15', 'German');
	define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
	define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()
	define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
	define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

	// page title
	define('TITLE', STORE_NAME);

	////
	// Return date in raw format
	// $date should be in format mm/dd/yyyy
	// raw date is in format YYYYMMDD, or DDMMYYYY

	if (!function_exists("olc_date_raw"))
	{
		function olc_date_raw($date, $reverse = false) {
			if ($reverse)
			{
				return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
			} else {
				return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
			}
		}
	}

	define('LANGUAGE_CURRENCY', 'EUR');

	// Global entries for the <html> tag
	define('HTML_PARAMS','dir="LTR" lang="de"');

	define('HEADER_TITLE_TOP', 'Startseite');
	define('HEADER_TITLE_CATALOG', 'Katalog');

	// text for gender
	define('MALE', 'Herr');
	define('FEMALE', 'Frau');
	define('MALE_ADDRESS', MALE);
	define('FEMALE_ADDRESS',FEMALE);

	// text for date of birth example
	define('DOB_FORMAT_STRING', 'TT.MM.JJJJ');

	// text for quick purchase
	define('IMAGE_BUTTON_ADD_QUICK', 'Schnellkauf!');
	define('BOX_ADD_PRODUCT_ID_TEXT', 'Bitte geben Sie die Artikelnummer aus unserem Katalog ein.');

	// text for gift voucher redeeming
	define('IMAGE_REDEEM_GIFT','Gutschein einl�sen');

	define('BOX_TITLE_STATISTICS','Statistik');
	define('BOX_TITLE_ORDERS_STATUS','Bestell-Status');
	define('BOX_ENTRY_CUSTOMERS','Kunden');
	define('BOX_ENTRY_PRODUCTS','Produkte');
	define('BOX_ENTRY_REVIEWS','Bewertungen');

	// quick_find box text in includes/boxes/quick_find.php
	define('BOX_SEARCH_TEXT', 'Verwenden Sie Stichworte um einen speziellen Artikel zu finden.');
	define('BOX_SEARCH_ADVANCED_SEARCH', 'Erweiterte Suche');

	// reviews box text in includes/boxes/reviews.php
	define('BOX_REVIEWS_WRITE_REVIEW', 'Bewerten Sie das Produkt! <b>%s</b>');
	define('BOX_REVIEWS_NO_REVIEWS', 'Es liegen noch keine Bewertungen vor');
	define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s von 5 Sternen!');

	// shopping_cart box text in includes/boxes/shopping_cart.php
	define('BOX_SHOPPING_CART_EMPTY', '0 Artikel');

	// notifications box text in includes/boxes/products_notifications.php
	define('BOX_NOTIFICATIONS_NOTIFY', 'Benachrichtigen Sie mich �ber Aktuelles zum Artikel <b>%s</b>');
	define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Benachrichtigen Sie mich nicht mehr zum Artikel <b>%s</b>');

	// manufacturer box text
	define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Homepage');
	define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Mehr Artikel');

	define('BOX_HEADING_ADD_PRODUCT_ID','In den Korb legen');
	define('BOX_HEADING_SEARCH','Suchen!');

	define('BOX_INFORMATION_CONTACT', 'Kontakt');
	define('BOX_PDF_EXPORT', 'PDF-Katalog erstellen');
	define('BOX_XXC_IMPORT', 'xxCommerce-Daten importieren');

	define('PRINT_DATASHEET','Datenblatt drucken');
	define('PRINT_ORDER_CONFIRMATION','Bestellbest�tigung drucken');
	define('PDF_DATASHEET', 'PDF-Format');
	define('PDF_FORMAT',LPAREN.PDF_DATASHEET.RPAREN);
	define('PDF_DATASHEET_TITLE', 'Datenblatt im '.PDF_DATASHEET.' erstellen');
	// tell a friend box text in includes/boxes/tell_a_friend.php
	define('BOX_HEADING_TELL_A_FRIEND', 'An einen Freund weiterempfehlen');
	define('BOX_TELL_A_FRIEND_TEXT', 'Empfehlen Sie diesen Artikel einfach per eMail weiter.');
	//	W. Kaiser tell_a_friend
	define('BOX_TELL_A_FRIEND_TEXT_SITE', 'Empfehlen Sie unseren Shop einfach per eMail weiter.');
	//	W. Kaiser tell_a_friend

	define('CHANGE_SKIN_TEXT','title="Hier k�nnen Sie das Aussehen des Shops �ndern">Shop-Design �ndern');

	// pull down default text
	define('PULL_DOWN_DEFAULT', 'Bitte w�hlen');
	define('TYPE_BELOW', 'Bitte unten eingeben');

	// javascript messages
	define('JS_ERROR', 'Notwendige Angaben fehlen!\n Bitte richtig ausf�llen.\n\n');

	define('JS_REVIEW_TEXT', '* Der Text muss mindestens aus ' . REVIEW_TEXT_MIN_LENGTH . ' Buchstaben bestehen.\n');
	define('JS_REVIEW_RATING', '* Geben Sie Ihre Bewertung ein.\n');
	define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Bitte w�hlen Sie eine Zahlungsweise f�r Ihre Bestellung.\n');
	define('JS_ERROR_SUBMITTED', 'Diese Seite wurde bereits best�tigt. Bet�tigen Sie bitte OK und warten bis der Prozess durchgef�hrt wurde.');
	define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Bitte w�hlen Sie eine Zahlungsweise f�r Ihre Bestellung.');
	define('CATEGORY_COMPANY', 'Firmendaten');
	define('CATEGORY_PERSONAL', 'Ihre pers�nlichen Daten');
	define('CATEGORY_ADDRESS', 'Ihre Adresse');
	define('CATEGORY_CONTACT', 'Ihre Kontaktinformationen');
	define('CATEGORY_OPTIONS', 'Optionen');
	define('CATEGORY_PASSWORD', 'Ihr Passwort');

	define('ENTRY_COMPANY', 'Firmenname:');
	define('ENTRY_COMPANY_ERROR', EMPTY_STRING);
	define('ENTRY_COMPANY_TEXT', EMPTY_STRING);
	define('ENTRY_GENDER', 'Anrede:');
	define('ENTRY_GENDER_ERROR', 'Bitte w�hlen Sie Ihre Anrede aus.');
	define('ENTRY_GENDER_TEXT', '*');
	define('ENTRY_FIRST_NAME', 'Vorname:');
	define('ENTRY_FIRST_NAME_ERROR', 'Ihr Vorname muss aus mindestens ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' Zeichen bestehen.');
	define('ENTRY_FIRST_NAME_TEXT', '*');
	define('ENTRY_LAST_NAME', 'Nachname:');
	define('ENTRY_LAST_NAME_ERROR', 'Ihr Nachname muss aus mindestens ' . ENTRY_LAST_NAME_MIN_LENGTH . ' Zeichen bestehen.');
	define('ENTRY_LAST_NAME_TEXT', '*');
	define('ENTRY_DATE_OF_BIRTH', 'Geburtsdatum:');
	define('ENTRY_DATE_OF_BIRTH_ERROR', 'Ihr Geburtsdatum muss im Format TT.MM.JJJJ (zB. 21.05.1970) eingeben werden');
	define('ENTRY_DATE_OF_BIRTH_TEXT', '* (zB. 21.05.1970)');
	define('ENTRY_EMAIL_ADDRESS', 'eMail-Adresse:');
	define('ENTRY_EMAIL_ADDRESS_ERROR', 'Ihre E-Mail Adresse muss aus mindestens ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' Zeichen bestehen.');
	define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Die eingegebene eMail Adresse ist fehlerhaft.');
	define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Die eingegebene eMail Adresse existiert bereits in unserer Datenbank - bitte loggen Sie mit dieser ein, oder erstellen Sie ein neues Konto mit einer neuen eMail Adresse.');
	define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
	define('ENTRY_STREET_ADDRESS', 'Strasse:');
	define('ENTRY_STREET_ADDRESS_ERROR', 'Strasse muss aus mindestens ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Zeichen bestehen.');
	define('ENTRY_STREET_ADDRESS_TEXT', '*');
	define('ENTRY_SUBURB', 'Adress-Zusatz:');
	define('ENTRY_SUBURB_ERROR', EMPTY_STRING);
	define('ENTRY_SUBURB_TEXT', EMPTY_STRING);
	define('ENTRY_POST_CODE', 'Postleitzahl:');
	define('ENTRY_POST_CODE_ERROR', 'Ihre Postleitzahl muss aus mindestens ' . ENTRY_POSTCODE_MIN_LENGTH . ' Zeichen bestehen.');
	define('ENTRY_POST_CODE_TEXT', '*');
	define('ENTRY_CITY', 'Ort:');
	define('ENTRY_CITY_ERROR', 'Ort muss aus mindestens ' . ENTRY_CITY_MIN_LENGTH . ' Zeichen bestehen.');
	define('ENTRY_CITY_TEXT', '*');
	define('ENTRY_STATE', 'Bundesland:');
	define('ENTRY_STATE_ERROR', 'Ihr Bundesland muss aus mindestens ' . ENTRY_STATE_MIN_LENGTH . ' Zeichen bestehen.');
	define('ENTRY_STATE_ERROR_SELECT', 'Bitte w�hlen Sie ihr Bundesland aus der Liste aus.');
	define('ENTRY_STATE_TEXT', '*');
	define('ENTRY_COUNTRY', 'Land:');
	define('ENTRY_COUNTRY_ERROR', 'Bitte w�hlen Sie ihr Land aus der Liste aus.');
	define('ENTRY_COUNTRY_TEXT', '*');
	define('ENTRY_TELEPHONE_NUMBER', 'Telefonnummer:');
	define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Ihre Telefonnummer muss aus mindestens ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Zeichen bestehen.');
	define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
	define('ENTRY_FAX_NUMBER', 'Telefaxnummer:');
	define('ENTRY_FAX_NUMBER_ERROR', 'Ihre Telefaxnummer muss aus mindestens ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Zeichen bestehen.');
	define('ENTRY_FAX_NUMBER_TEXT', EMPTY_STRING);
	define('ENTRY_NEWSLETTER', 'Newsletter:');
	define('ENTRY_NEWSLETTER_TEXT', '<td class="main"> (Sie k�nnen sich damit �ber Neuerungen bei uns informieren lassen.)</td>');
	define('ENTRY_NEWSLETTER_YES', 'abonniert');
	define('ENTRY_NEWSLETTER_NO', 'nicht abonniert');
	define('ENTRY_NEWSLETTER_ERROR', EMPTY_STRING);
	define('ENTRY_PASSWORD', 'Passwort:');
	define('ENTRY_PASSWORD_ERROR', 'Ihr Passwort muss aus mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen bestehen.');
	define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Ihre Passw�rter stimmen nicht �berein.');
	define('ENTRY_PASSWORD_TEXT', '*');
	define('ENTRY_PASSWORD_CONFIRMATION', 'Best�tigung:');
	define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
	define('ENTRY_PASSWORD_CURRENT', 'Aktuelles Passwort:');
	define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
	define('ENTRY_PASSWORD_CURRENT_ERROR', 'Ihr Passwort muss aus mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen bestehen.');
	define('ENTRY_PASSWORD_NEW', 'Neues Passwort:');
	define('ENTRY_PASSWORD_NEW_TEXT', '*');
	define('ENTRY_PASSWORD_NEW_ERROR', 'Ihr neues Passwort muss aus mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen bestehen.');
	define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Ihre Passw�rter stimmen nicht �berein.');
	define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">* Erforderlich</span>');
	//	W. Kaiser tell_a_friend
	define('ENTRY_SECCODE_CHECK_ERROR', 'Der eingegebene Sicherheitscode ist falsch!');

	//	W. Kaiser tell_a_friend
	//	W. Kaiser - eMail-type by customer
	define('ENTRY_HTMLEMAIL_TEXT', 'eMails im HTML-Format senden<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(empfohlen)');
	define('EMAIL_TYPE_HTML', 1);
	define('EMAIL_TYPE_TEXT', 2);
	//	W. Kaiser - eMail-type by customer
	define('PASSWORD_HIDDEN', '--VERSTECKT--');

	//Popup Window
	define('TEXT_CLICK_TO_ENLARGE','Zum vergr��ern anklicken');
	define('TEXT_CLOSE_WINDOW', 'Fenster schlie�en');

	define('TEXT_RESULT_PAGE', 'Seiten:');
	$show='Zeige <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> ';
	define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', $show . 'Produkten)');
	define('TEXT_DISPLAY_NUMBER_OF_ORDERS', $show . 'Bestellungen)');
	define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', $show . 'Bewertungen)');
	define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', $show . 'neuen Produkten)');
	define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', $show . 'Angeboten)');
	define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_VPE', $show . 'Verpackungseinheiten)');
	define('TEXT_FURTHER_INFO','F�r weitere Informationen anklicken');
	// constants for use in olc_prev_next_display function
	define('PREVNEXT_TITLE_FIRST_PAGE', 'erste Seite');
	define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'vorherige Seite');
	define('PREVNEXT_TITLE_NEXT_PAGE', 'n�chste Seite');
	define('PREVNEXT_TITLE_LAST_PAGE', 'letzte Seite');
	define('PREVNEXT_TITLE_PAGE_NO', 'Seite %d');
	define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Vorhergehende %d Seiten');
	define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'N�chste %d Seiten');

	/*
	define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;erste');
	define('PREVNEXT_BUTTON_PREV', '[&lt;&lt;&nbsp;vorherige]');
	define('PREVNEXT_BUTTON_NEXT', '[n�chste&nbsp;&gt;&gt;]');
	define('PREVNEXT_BUTTON_LAST', 'letzte&gt;&gt;');
	*/
	$imgsrc = '<img src="' . CURRENT_TEMPLATE_BUTTONS . 'button_';
	$imgpar = '.gif" border="0" align="middle" title="';
	define('PREVNEXT_BUTTON_PREV', $imgsrc . 'previous' . $imgpar . PREVNEXT_TITLE_PREVIOUS_PAGE . '">');
	define('PREVNEXT_BUTTON_NEXT', $imgsrc .'next' . $imgpar . PREVNEXT_TITLE_NEXT_PAGE . '">');

	//W. Kaiser - Baseprice
	define('TEXT_PRODUCTS_VPE_DISPLAY', '<span align="center">%s</span>');
	define('TEXT_PRODUCTS_BASEPRICE', ' <span style="font-size=8pt;font-weight=normal;">(%s: %s)</span>');
	//W. Kaiser - Baseprice
	//W. Kaiser - Mininum order quantity
	define('TEXT_PRODUCTS_MIN_ORDER', ' <span style="font-size=6pt;font-weight=normal;color:red" align="center">Mindestabnahme:<br/>%s</span>');
	//W. Kaiser - Mininum order quantity

	define('IMAGE_BUTTON_ADD_ADDRESS', 'Neue Adresse');
	define('IMAGE_BUTTON_ADDRESS_BOOK', 'Adressbuch');
	define('IMAGE_BUTTON_ADMIN', 'Shop verwalten');
	define('IMAGE_BUTTON_BACK', 'Zur�ck');
	define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Adresse �ndern');
	define('IMAGE_BUTTON_CHECKOUT', 'Kasse');
	define('IMAGE_BUTTON_CONFIRM_ORDER', 'Bestellung best�tigen');
	define('IMAGE_BUTTON_CONTINUE', 'Weiter');
	define('IMAGE_BUTTON_CONTINUE_SHOPPING', 'Einkauf fortsetzen');
	define('IMAGE_BUTTON_DELETE', 'L�schen');
	define('IMAGE_BUTTON_EDIT_ACCOUNT', 'Daten �ndern');
	define('IMAGE_BUTTON_HISTORY', 'Bestell�bersicht');
	//W. Kaiser - AJAX
	define('IMAGE_BUTTON_INSERT', 'Einf�gen');
	//W. Kaiser - AJAX
	define('IMAGE_BUTTON_LOGIN', 'Anmelden');
	define('IMAGE_BUTTON_IN_CART', 'In den Warenkorb');
	define('IMAGE_BUTTON_NOTIFICATIONS', 'Benachrichtigungen');
	define('IMAGE_BUTTON_QUICK_FIND', 'Schnellsuche');
	define('IMAGE_BUTTON_REMOVE_NOTIFICATIONS', 'Benachrichtigungen l�schen');
	define('IMAGE_BUTTON_REVIEWS', 'Bewertungen');
	define('IMAGE_BUTTON_SEARCH', 'Suchen');
	define('IMAGE_BUTTON_SHIPPING_OPTIONS', 'Versandoptionen');
	define('IMAGE_BUTTON_TELL_A_FRIEND', 'Weiterempfehlen');
	define('IMAGE_BUTTON_UPDATE', 'Aktualisieren');
	define('IMAGE_BUTTON_UPDATE_CART', 'Warenkorb aktualisieren');
	define('IMAGE_BUTTON_WRITE_REVIEW', 'Bewertung schreiben');
	define('IMAGE_BUTTON_CANCEL','Abbrechen');

	define('SMALL_IMAGE_BUTTON_DELETE', 'L�schen');
	define('SMALL_IMAGE_BUTTON_EDIT', '�ndern');
	define('SMALL_IMAGE_BUTTON_VIEW', 'Anzeigen');

	define('ICON_ARROW_RIGHT', 'Zeige mehr');
	define('ICON_CART', 'In den Warenkorb');
	define('ICON_SUCCESS', 'Erfolg');
	define('ICON_WARNING', 'Warnung');

	define('TEXT_GREETING_PERSONAL', 'Sch�n das Sie wieder da sind <span class="greetUser">%s!</span> M�chten Sie sich unsere <a href="%s"><u>neuen Produkte</u></a> ansehen?');
	define('TEXT_GREETING_PERSONAL_RELOGON', '<small>Wenn Sie nicht %s sind, melden Sie sich bitte <a href="%s"><u>hier</u></a> mit Ihrem Kundenkonto an.</small>');
	define('TEXT_GREETING_GUEST', 'Herzlich Willkommen <span class="greetUser">Gast!</span><br/>M�chten Sie sich <a href="%s"><u>anmelden</u></a>? Oder wollen Sie ein <a href="%s"><u>Kundenkonto</u></a> er�ffnen?');

	define('TEXT_SORT_PRODUCTS', 'Sortierung der Artikel ist ');
	define('TEXT_DESCENDINGLY', 'absteigend');
	define('TEXT_ASCENDINGLY', 'aufsteigend');
	define('TEXT_BY', ' nach ');

	define('TEXT_REVIEW_BY', 'von %s');
	define('TEXT_REVIEW_WORD_COUNT', '%s Worte');
	define('TEXT_REVIEW_RATING', 'Bewertung: %s [%s]');
	define('TEXT_REVIEW_DATE_ADDED', 'Hinzugef�gt am: %s');
	define('TEXT_NO_REVIEWS', 'Es liegen noch keine Bewertungen vor.');

	define('TEXT_NO_NEW_PRODUCTS', 'Zur Zeit gibt es keine neuen Artikel.');

	define('TEXT_UNKNOWN_TAX_RATE', 'Unbekannter Steuersatz');

	define('TEXT_REQUIRED', '<span class="errorText">&nbsp;* Erforderlich</span>');

	define('ERROR_TEP_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>Fehler:</small> Die eMail kann nicht �ber den angegebenen SMTP-Server verschickt werden. Bitte kontrollieren Sie die Einstellungen in der php.ini Datei und f�hren Sie notwendige Korrekturen durch!</b></font>');
	define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warnung: Das Installationverzeichnis ist noch vorhanden auf: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/olc_installer. Bitte l�schen Sie das Verzeichnis aus Gr�nden der Sicherheit!');
	define('WARNING_CONFIG_FILE_WRITEABLE', 'Warnung: OL-Commerce kann in die Konfigurationsdatei schreiben: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. Das stellt ein m�gliches Sicherheitsrisiko dar - bitte korrigieren Sie die Benutzerberechtigungen zu dieser Datei!');

	define('WARNING_SESSION_AUTO_START', 'Warnung: session.auto_start ist aktiviert (enabled) - Bitte deaktivieren (disabled) Sie dieses PHP Feature in der php.ini und starten Sie den WEB-Server neu!');
	define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warnung: Das Verzeichnis f�r den Artikel Download existiert nicht: ' . DIR_FS_DOWNLOAD . '. Diese Funktion wird nicht funktionieren bis das Verzeichnis erstellt wurde!');

	define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Das "G�ltig bis" Datum ist ung�ltig.<br/>Bitte korrigieren Sie Ihre Angaben.');
	define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Die "Kreditkarten-Nummer", die Sie angegeben haben, ist ung�ltig.<br/>Bitte korrigieren Sie Ihre Angaben.');
	define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Die ersten 4 Ziffern Ihrer Kreditkarte sind: %s<br/>Wenn diese Angaben stimmen, wird dieser Kartentyp leider nicht akzeptiert.<br/>Bitte korrigieren Sie Ihre Angaben gegebenfalls.');

	define('FOOTER_TEXT_BODY', 'Copyright &copy; ab 2003 <a href="http://www.ol-commerce.com" target="_blank">OL-Commerce </a><br/>Powered by <a href="http://www.ol-commerce.com" target="_blank">OL-Commerce </a>');

	// W. Kaiser
	//  conditions check
	$conditions_text='Wenn Sie #, k�nnen wir Ihre Bestellung aus rechtlichen Gr�nden bedauerlicherweise nicht entgegennehmen!';
	define('ERROR_CONDITIONS_NOT_ACCEPTED',
	str_replace(HASH,'unsere Gesch�fts- und Lieferbedingungen nicht akzeptieren',$conditions_text));
	define('ERROR_FERNAG_NOT_ACCEPTED',str_replace(HASH,'die Kenntnisnahme unserer Informationen zu Ihrem Widerrufsrecht nicht best�tigen',$conditions_text));
	// W. Kaiser

	define('SUB_TITLE_OT_DISCOUNT','Rabatt:');
	define('SUB_TITLE_SUB_NEW','Summe:');

	define('TEXT_PRICE_SINGLE','Einzelpreis');
	define('TEXT_PRICE_TOTAL','Gesamtpreis');

	define('NOT_ALLOWED_TO_SEE_PRICES','Sie k�nnen als Gast (bzw. mit Ihrem derzeitigen Status) keine Preise sehen');
	define('NOT_ALLOWED_TO_ADD_TO_CART','Sie k�nnen als Gast (bzw. mit Ihrem derzeitigen Status) keine Artikel in den Warenkorb legen');

	define('BOX_LOGINBOX_HEADING', 'Willkommen zur�ck!');
	define('BOX_LOGINBOX_EMAIL', 'eMail Adresse:');
	define('BOX_LOGINBOX_PASSWORD', 'Passwort:');
	define('IMAGE_BUTTON_LOGIN', 'Anmelden');
	define('BOX_ACCOUNTINFORMATION_HEADING','Information');

	define('BOX_LOGINBOX_STATUS','Kundengruppe: ');

	define('BOX_LOGINBOX_INCL','Alle Preise <b>inkl.</b> MwSt.');
	define('BOX_LOGINBOX_EXCL','Alle Preise <b>exkl.</b> MwSt.');

	define('TAX_ADD_TAX','inkl. ');
	define('TAX_NO_TAX','zzgl. ');

	define('BOX_LOGINBOX_DISCOUNT','Artikelrabatt');
	define('BOX_LOGINBOX_DISCOUNT_TEXT','Rabatt');
	define('BOX_LOGINBOX_DISCOUNT_OT','Gesamtrabatt');

	define('NOT_ALLOWED_TO_SEE_PRICES_TEXT','Sie haben keine Erlaubnis Preise zu sehen, erstellen Sie bitte ein Kundenkonto.');
	define('BOX_LOGINBOX_ACCOUNT',HTML_BR.'�ber die Schaltfl�che "<b>Ihr Konto</b>" k�nnen Sie Ihre Daten verwalten, Bestellungen einsehen und mehr...');

	//W. Kaiser - AJAX
	if (function_exists('olc_session_save_path'))
	{
		define('WARNING_SESSION_DIRECTORY_NON_EXISTENT',
		'Warnung: Das Verzeichnis f�r die Sessions existiert nicht: ' .
		olc_session_save_path() . '. Die Sessions werden nicht funktionieren bis das Verzeichnis erstellt wurde!');
		define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE',
		'Warnung: OL-Commerce kann nicht in das Sessions Verzeichnis schreiben: ' . olc_session_save_path() .
		'. Die Sessions werden nicht funktionieren bis die richtigen Benutzerberechtigungen gesetzt wurden!');
	}

	define('GENERAL_DISCLAIMER','Irrt�mer, �nderungen und Zwischenverkauf vorbehalten');
	//define('PRICE_DISCLAIMER_SHIPMENT_COST_TEXT','Versandkosten (ab %s'.RPAREN);
	define('PRICE_DISCLAIMER_SHIPMENT_COST','Versandkosten');
	$price_info=FILENAME_CONTENT.'?coID=1';
	if (USE_AJAX)
	{
		$price_info="javascript:ShowInfo('".$price_info."&amp;pop_up=true','')";
	}
	define('PRICE_DISCLAIMER_COMMON',
	' zzgl. <a href="'.$price_info.'" title="Detaillierte Informationen zu den Versandkosten erhalten Sie mit einem Klick hier"><u>'.PRICE_DISCLAIMER_SHIPMENT_COST.'</u></a>.');

	if (!defined('NO_TAX_RAISED'))
	{
		define('NO_TAX_RAISED',false);
	}
	$price_disclaimer_shipment_cost=' zzgl. '.PRICE_DISCLAIMER_SHIPMENT_COST;
	$price=' <br/>Preis';
	$prices=' <br/>Preise';
	if (NO_TAX_RAISED)
	{
		define('BOX_LOGINBOX_NO_TAX_TEXT','Gem�� �19 UStG wird keine MwSt. erhoben.');
		define('PRICE_DISCLAIMER_NO_TAX',BOX_LOGINBOX_NO_TAX_TEXT.$price.PRICE_DISCLAIMER_COMMON);
		define('PRICES_DISCLAIMER_NO_TAX',BOX_LOGINBOX_NO_TAX_TEXT.$prices.PRICE_DISCLAIMER_COMMON);
		define('PRICE_DISCLAIMER_NO_TAX_NO_LINK',BOX_LOGINBOX_NO_TAX_TEXT.$price.$price_disclaimer_shipment_cost);
	}
	else
	{
		$s=' und'.PRICE_DISCLAIMER_COMMON;
		$price_incl_text='Preis <b>inkl.</b> %s MwSt.';
		$price_excl_text='Preis <b>exkl.</b> MwSt.';

		define('PRICE_DISCLAIMER_INCL',$price_incl_text.$s);
		define('PRICE_DISCLAIMER_EXCL',$price_excl_text.$s);

		$all_prices='Alle Preise <b>#.</b> MwSt.'.PRICE_DISCLAIMER_COMMON;
		define('PRICES_DISCLAIMER_INCL',str_replace(HASH,'inkl',$all_prices));
		define('PRICES_DISCLAIMER_EXCL',str_replace(HASH,'exkl',$all_prices));

		$price_disclaimer_shipment_cost=' zzgl. '.PRICE_DISCLAIMER_SHIPMENT_COST;
		define('PRICE_DISCLAIMER_NO_TAX_NO_LINK',BOX_LOGINBOX_NO_TAX_TEXT.$price.$s);
		$s=' und '.$price_disclaimer_shipment_cost;
		define('PRICE_DISCLAIMER_INCL_NO_LINK',$price_incl_text.$s);
		define('PRICE_DISCLAIMER_INCL_GENERAL_NO_LINK',BOX_LOGINBOX_INCL.$s);
		define('PRICE_DISCLAIMER_EXCL_NO_LINK',$price_excl_text.$s);
		define('TAX_DISCLAIMER_EU','Innergemeinschaftliche Lieferung');
	}

	define('PICTURE_DISCLAIMER','Abb. �hnlich');
	//W. Kaiser - AJAX
	define('TEXT_DOWNLOAD','Download');
	define('TEXT_VIEW','Ansehen');

	define('TEXT_BUY', '1 x \'');
	define('TEXT_NOW', '\' in den Warenkorb legen');
	define('TEXT_GUEST','Gast');
	define('TEXT_NO_PURCHASES', 'Sie haben noch keine Bestellungen get�tigt.');

	define('TEMPLATE_SPECIAL_PRICE','<font color="ff0000">Statt <s>%s</s></font><br/>Nur %s');
	define('TEMPLATE_SPECIAL_PRICE_DATE_1','Sonderpreis');
	define('TEMPLATE_SPECIAL_PRICE_DATE_2',' bis zum <b>%s</b>');

	define('TEMPLATE_UVP_PRICE','<span align="right"><font size="1" color="red"><s>Unverbindliche Preisempfehlung: %s</s></font></span>');
	define('TEMPLATE_UVP_PRICE_SHORT','<span align="right"><font size="1"><s>UVP: %s</s></font></span>');
	define('TEMPLATE_UVP_PRICE_SHORT_DISCLAIMER','"UVP" bezeichnet die unverbindliche Preisempfehlung des Herstellers');

	// Warnings
	define('SUCCESS_ACCOUNT_UPDATED', 'Ihr Konto wurde erfolgreich aktualisiert.');
	define('SUCCESS_NEWSLETTER_UPDATED', 'Ihre Newsletter Abonnements wurden erfolgreich aktualisiert!');
	define('SUCCESS_NOTIFICATIONS_UPDATED', 'Ihre Produktbenachrichtigungen wurden erfolgreich aktualisiert!');
	define('SUCCESS_PASSWORD_UPDATED', 'Ihr Passwort wurde erfolgreich ge�ndert!');
	define('ERROR_CURRENT_PASSWORD_NOT_MATCHING', 'Das eingegebene Passwort stimmt nicht mit dem gespeichertem Passwort �berein. Bitte versuchen Sie es noch einmal.');
	define('TEXT_MAXIMUM_ENTRIES', '<font color="#ff0000"><b>Hinweis:</b></font> Ihnen stehen %s Adressbucheintr�ge zur Verf�gung!');
	define('SUCCESS_ADDRESS_BOOK_ENTRY_INSERTED', 'Der neue Eintrag wurde erfolgreich in das Adressbuch eingef�gt.');
	define('SUCCESS_ADDRESS_BOOK_ENTRY_DELETED', 'Der ausgew�hlte Eintrag wurde erfolgreich gel�scht.');
	define('SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED', 'Ihr Adressbuch wurde erfolgreich aktualisiert!');
	define('WARNING_PRIMARY_ADDRESS_DELETION', 'Die Standardadresse kann nicht gel�scht werden. Bitte erst eine andere Standardadresse w�hlen. Danach kann der Eintrag gel�scht werden.');
	define('ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY', 'Dieser Adressbucheintrag ist nicht vorhanden.');
	define('ERROR_ADDRESS_BOOK_FULL', 'Ihr Adressbuch kann keine weiteren Adressen aufnehmen. Bitte l�schen Sie eine nicht mehr ben�tigte Adresse. Danach k�nnen Sie einen neuen Eintrag speichern.');

	//Advanced Search
	define('ENTRY_CATEGORIES', 'Kategorien:');
	define('ENTRY_INCLUDE_SUBCATEGORIES', 'Unterkategorien einbeziehen');
	define('ENTRY_MANUFACTURERS', 'Hersteller:');
	define('ENTRY_PRICE_FROM', 'Preis ab:');
	define('ENTRY_PRICE_TO', 'Preis bis:');
	define('ENTRY_DATE_FROM','Datum hinzugef�gt von:');
	define('ENTRY_DATE_TO','Datum hinzugef�gt bis:');
	define('TEXT_ALL_CATEGORIES', 'Alle Kategorien');
	define('TEXT_ALL_MANUFACTURERS', 'Alle Hersteller');
	define('JS_AT_LEAST_ONE_INPUT', '* Eines der folgenden Felder muss ausgef�llt werden:\n   Suchbegriffe\n   Preis ab\n   Preis bis\n   Datum hinzugef�gt von\n   Datum hinzugef�gt bis\n');
	define('JS_INVALID_FROM_DATE', '* Unzul�ssiges \"von\" Datum\n');
	define('JS_INVALID_TO_DATE', '* Unzul�ssiges \"bis\" Datum\n');
	define('JS_TO_DATE_LESS_THAN_FROM_DATE', '* Das \"von\" Datum muss kleiner oder gleich dem \"bis\" Datum sein\n');
	define('JS_PRICE_FROM_MUST_BE_NUM', '* \"Preis ab\", muss eine Zahl sein\n');
	define('JS_PRICE_TO_MUST_BE_NUM', '* \"Preis bis\" muss eine Zahl sein\n');
	define('JS_PRICE_TO_LESS_THAN_PRICE_FROM', '* \"Preis bis\" muss gr��er oder gleich \"Preis ab\" sein.\n');
	define('JS_INVALID_KEYWORDS', '* Suchbegriff unzul�ssig\n');
	define('TEXT_NO_PRODUCTS', 'Es wurden keine Artikel gefunden, die den Suchkriterien entsprechen.');
	define('TEXT_NO_PRODUCTS_CATEGORY', 'Es wurden keine Artikel in dieser Kategorie gefunden.');
	define('TEXT_ORIGIN_LOGIN', '<font color="#FF0000"><small><b>ACHTUNG:</b></font></small> Wenn Sie bereits ein Konto besitzen, melden Sie sich bitte <a href="%s"><u><b>hier</b></u></a> an.');
	define('TEXT_LOGIN_ERROR', '<font color="#ff0000"><b>FEHLER:</b></font> Keine �bereinstimmung der eingebenen \'eMail-Adresse\' und/oder dem \'Passwort\'.');
	define('TEXT_VISITORS_CART', '<font color="#ff0000"><b>ACHTUNG:</b></font> Ihre Eingaben werden automatisch mit Ihrem Kundenkonto verkn�pft. <a href="javascript:session_win();">[Mehr Information]</a>');
	define('TEXT_NO_EMAIL_ADDRESS_FOUND', '<font color="#ff0000"><b>ACHTUNG:</b></font> Die eingegebene eMail-Adresse ist nicht registriert. Bitte versuchen Sie es noch einmal.');
	define('TEXT_PASSWORD_SENT', 'Ein neues Passwort wurde per eMail verschickt.');
	define('TEXT_PRODUCT_NOT_FOUND', 'Artikel wurde nicht gefunden!');
	define('TEXT_MORE_INFORMATION', 'F�r weitere Informationen, besuchen Sie bitte die <a href="%s" target="_blank"><u>Homepage</u></a> zu diesem Artikel.');
	define('TEXT_DATE_ADDED', 'Diesen Artikel haben wir am %s in unseren Katalog aufgenommen.');
	define('TEXT_DATE_AVAILABLE', '<b>Ab dem %s bestellbar.</b>');
	define('TEXT_DATE_AVAILABLE_SHORT', '(<b>Ab %s</b>)');
	define('TEXT_SOLD_OUT', "Das Produkt \"%s\" ist zur Zeit leider ausverkauft!");
	define('TEXT_NO_PERMISSION', "Sie haben keine Berechtigung, dieses Produkt zu bestellen.");
	define('TEXT_NO_PRODUCT', "Es wurde kein Produkt mit der %s '%s' gefunden!");
	define('TEXT_NR_REQUIRED', "Sie m�ssen eine %s eingeben");
	define('TEXT_ARTICLE_NR',"Artikel-Nummer");
	define('TEXT_ARTICLE_ID',"Artikel-Id");
	define('TEXT_ORDER_CONTINUE','<p><font size="3" color="red"><strong>Bestellung fortsetzen f�r</strong></font></p>');

	define('TEXT_CART_EMPTY', 'Sie haben noch keine Artikel in Ihrem Warenkorb.');
	define('CART_DETAILS','Warenkorb-Details');
	define('TEXT_PRODUCTS_NOT_AVAILABLE',
	HTML_BR.HTML_BR.'<b>Die folgenden Artikel in dem gespeicherten Warenkorb sind nicht mehr verf�gbar:</b>'.HTML_BR.HTML_BR);
	define('SUB_TITLE_SUB_TOTAL', 'Zwischensumme:');
	define('SUB_TITLE_TOTAL', 'Summe:');

	define('OUT_OF_STOCK_CANT_CHECKOUT', 'Die mit ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK .
	' markierten Artikel sind leider nicht in der von Ihnen gew�nschten Menge auf Lager.<br/>".
	"Bitte reduzieren Sie Ihre Bestellmenge f�r die gekennzeichneten Artikel. Vielen Dank');
	define('OUT_OF_STOCK_CAN_CHECKOUT', 'Die mit ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK .
	' markierten Artikel sind leider nicht in der von Ihnen gew�nschten Menge auf Lager.<br/>".
	"Die bestellte Menge wird kurzfristig von uns geliefert, wenn Sie es w�nschen nehmen wir auch eine Teillieferung vor.');

	define('HEADING_TITLE_TELL_A_FRIEND', 'Empfehlen Sie \'%s\' weiter');
	define('HEADING_TITLE_ERROR_TELL_A_FRIEND', 'Produkt weiterempfehlen');
	define('ERROR_INVALID_PRODUCT', 'Das von Ihnen gew�hlte Produkt wurde nicht gefunden!');

	define('NAVBAR_TITLE_ACCOUNT', 'Ihr Konto');
	define('NAVBAR_TITLE_1_ACCOUNT_EDIT', 'Ihr Konto');
	define('NAVBAR_TITLE_2_ACCOUNT_EDIT', 'Ihre pers�nliche Daten �ndern');
	define('NAVBAR_TITLE_1_ACCOUNT_HISTORY', 'Ihr Konto');
	define('NAVBAR_TITLE_2_ACCOUNT_HISTORY', 'Ihre get�tigten Bestellungen');
	define('NAVBAR_TITLE_1_ACCOUNT_HISTORY_INFO', 'Ihr Konto');
	define('NAVBAR_TITLE_2_ACCOUNT_HISTORY_INFO', 'Get�tigte Bestellung');
	define('NAVBAR_TITLE_3_ACCOUNT_HISTORY_INFO', 'Bestellnummer %s');
	define('NAVBAR_TITLE_1_ACCOUNT_NEWSLETTERS', 'Ihr Konto');
	define('NAVBAR_TITLE_2_ACCOUNT_NEWSLETTERS', 'Newsletter Abonnements');
	define('NAVBAR_TITLE_1_ACCOUNT_NOTIFICATIONS', 'Ihr Konto');
	define('NAVBAR_TITLE_2_ACCOUNT_NOTIFICATIONS', 'Produktbenachrichtungen');
	define('NAVBAR_TITLE_1_ACCOUNT_PASSWORD', 'Ihr Konto');
	define('NAVBAR_TITLE_2_ACCOUNT_PASSWORD', 'Passwort �ndern');
	define('NAVBAR_TITLE_1_ADDRESS_BOOK', 'Ihr Konto');
	define('NAVBAR_TITLE_2_ADDRESS_BOOK', 'Adressbuch');
	define('NAVBAR_TITLE_1_ADDRESS_BOOK_PROCESS', 'Ihr Konto');
	define('NAVBAR_TITLE_2_ADDRESS_BOOK_PROCESS', 'Adressbuch');
	define('NAVBAR_TITLE_ADD_ENTRY_ADDRESS_BOOK_PROCESS', 'Neuer Eintrag');
	define('NAVBAR_TITLE_MODIFY_ENTRY_ADDRESS_BOOK_PROCESS', 'Eintrag �ndern');
	define('NAVBAR_TITLE_DELETE_ENTRY_ADDRESS_BOOK_PROCESS', 'Eintrag l�schen');
	define('NAVBAR_TITLE_ADVANCED_SEARCH', 'Erweiterte Suche');
	define('NAVBAR_TITLE1_ADVANCED_SEARCH', 'Erweiterte Suche');
	define('NAVBAR_TITLE2_ADVANCED_SEARCH', 'Suchergebnisse');
	define('NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION', 'Kasse');
	define('NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION', 'Best�tigung');
	define('NAVBAR_TITLE_1_CHECKOUT_PAYMENT', 'Kasse');
	define('NAVBAR_TITLE_2_CHECKOUT_PAYMENT', 'Zahlungsweise');
	define('NAVBAR_TITLE_1_PAYMENT_ADDRESS', 'Kasse');
	define('NAVBAR_TITLE_2_PAYMENT_ADDRESS', 'Rechnungsadresse �ndern');
	define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING', 'Kasse');
	define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING', 'Versandinformationen');
	define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING_ADDRESS', 'Kasse');
	define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING_ADDRESS', 'Versandadresse �ndern');
	define('NAVBAR_TITLE_1_CHECKOUT_SUCCESS', 'Kasse');
	define('NAVBAR_TITLE_2_CHECKOUT_SUCCESS', 'Erfolg');
	define('NAVBAR_TITLE_CONTACT_US', 'Kontakt');
	define('NAVBAR_TITLE_CREATE_ACCOUNT', 'Konto erstellen');
	define('NAVBAR_TITLE_1_CREATE_ACCOUNT_SUCCESS', 'Konto erstellen');
	define('NAVBAR_TITLE_2_CREATE_ACCOUNT_SUCCESS', 'Erfolg');
	if ($_SESSION['navigation']->snapshot['page'] == FILENAME_CHECKOUT_SHIPPING) {
		define('NAVBAR_TITLE_LOGIN', 'Bestellen');
	} else {
		define('NAVBAR_TITLE_LOGIN', 'Anmelden');
	}
	define('NAVBAR_TITLE_LOGOFF','Auf Wiedersehen');
	define('NAVBAR_TITLE_1_PASSWORD_FORGOTTEN', 'Anmelden');
	define('NAVBAR_TITLE_2_PASSWORD_FORGOTTEN', 'Passwort vergessen');
	define('NAVBAR_TITLE_PRODUCTS_NEW', 'Neue Artikel');
	define('NAVBAR_TITLE_SHOPPING_CART', 'Warenkorb');
	define('NAVBAR_TITLE_SHOPPING_CART_DETAILS_OPEN', 'Warenkorb-Details anzeigen');
	define('NAVBAR_TITLE_SHOPPING_CART_DETAILS_CLOSE', 'Warenkorb-Details verbergen');
	define('NAVBAR_TITLE_SPECIALS', 'Angebote');
	define('NAVBAR_TITLE_COOKIE_USAGE', 'Cookie-Nutzung');
	define('NAVBAR_TITLE_PRODUCT_REVIEWS', 'Bewertungen');
	define('NAVBAR_TITLE_TELL_A_FRIEND', 'Artikel weiterempfehlen');
	//	W. Kaiser tell_a_friend
	define('NAVBAR_TITLE_TELL_A_FRIEND_SITE', 'Shop weiterempfehlen');
	//	W. Kaiser tell_a_friend
	define('NAVBAR_TITLE_REVIEWS_WRITE', 'Bewertungen');
	define('NAVBAR_TITLE_REVIEWS','Bewertungen');
	define('NAVBAR_TITLE_SSL_CHECK', 'Sicherheitshinweis');
	define('NAVBAR_TITLE_CREATE_GUEST_ACCOUNT','Konto erstellen');

	define('TEXT_EMAIL_SUCCESSFUL_SENT','Ihre eMail wurde erfolgreich versandt!');
	define('ERROR_MAIL','Bitte �berpr�fen Sie Ihre eingegebenen Daten im Formular');
	define('CATEGORIE_NOT_FOUND','Kategorie wurde nicht gefunden');

	// Newsletter
	define('NAVBAR_TITLE_NEWSLETTER','Newsletter');
	define('TEXT_INFO_START','Tragen Sie sich in unseren kostenlosen Newsletter ein!');
	define('TEXT_NEWSLETTER','Sie m�chten immer auf dem Laufenden bleiben? Kein Problem, tragen Sie sich in unseren Newsletter ein und Sie sind immer auf dem neuesten Stand. Wenn Sie keine Informationen mehr von uns haben wollen, dann tragen Sie sich aus unserer Newsletter-Liste aus!');
	define('TEXT_EMAIL_INPUT','Ihre E-Mailadresse wurde in unser System eingetragen.<br/>Gleichzeitig wurde Ihnen vom System eine E-Mail mit einem Aktivierungslink geschickt. Bitte klicken Sie nach dem Erhalt der Mail auf den Link um Ihre Eintragung zu best�tigen. Andernfalls bekommen Sie keinen Newsletter von uns zugestellt!');

	define('TEXT_WRONG_CODE','<font color="FF0000">Ihr eingegebener Sicherheitscode stimmte nicht mit dem angezeigten Code �berein. Bitte versuchen Sie es erneut.</font>');
	define('TEXT_EMAIL_EXIST_NO_NEWSLETTER','<font color="FF0000">Diese E-Mailadresse existiert bereits in unserer Datenbank ist aber noch nicht f�r den Empfang des Newsletters freigeschalten!</font>');
	define('TEXT_EMAIL_EXIST_NEWSLETTER','<font color="FF0000">Diese E-Mailadresse existiert bereits in unserer Datenbank und ist f�r den Newsletterempfang bereits freigeschalten!</font>');
	define('TEXT_EMAIL_NOT_EXIST','<font color="FF0000">Diese E-Mailadresse existiert nicht in unserer Datenbank!</font>');
	define('TEXT_EMAIL_DEL','Ihre E-Mailadresse wurde aus unserer Newsletterdatenbank gel�scht.');
	define('TEXT_EMAIL_DEL_ERROR','<font color="FF0000">Es ist ein Fehler aufgetreten, Ihre Mailadresse wurde nicht gel�scht!</font>');
	define('TEXT_EMAIL_ACTIVE','<font color="FF0000">Ihre E-Mailadresse wurde erfolgreich f�r den Newsletterempfang freigeschalten!</font>');
	define('TEXT_EMAIL_ACTIVE_ERROR','<font color="FF0000">Es ist ein Fehler aufgetreten, Ihre Mailadresse wurde nicht freigeschalten!</font>');
	define('TEXT_EMAIL_SUBJECT','Ihre Newsletteranmeldung');
	define('TEXT_CUSTOMER_GUEST','Gast');
	define('TEXT_NO_ORDER_DISPLAY','Sie k�nnen diese Bestellung nicht (mehr) anzeigen!');

	//W. Kaiser  Down For Maintenance
	define('DOWN_FOR_MAINTENANCE_NAME','Wartungsabschaltung: ');
	define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'Diese Website ist wegen Wartungsarbeiten nicht erreichbar am: ');
	define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'Diese Website ist wegen Wartungsarbeiten zur Zeit nicht erreichbar!');
	define('TEXT_DOWN_FOR_MAINTENANCE_CALL_LATER','Bitte versuchen Sie es sp�ter noch einmal');
	//W. Kaiser  Down For Maintenance

	$lang_dir=DIR_FS_CATALOG.'lang'.SLASH.SESSION_LANGUAGE.SLASH;
	include($lang_dir.'gv_german.php');

	//---PayPal WPP Modification START ---//
	define('MODULE_PAYMENT_PAYPAL_DP_TEXT_TITLE', 'Kreditkarte');
	define('MODULE_PAYMENT_PAYPAL_EC_TEXT_TITLE', 'PayPal Express-Zahlung');
	define('TEXT_PAYPALWPP_EC_HEADER', 'Schnelle und sichere Zahlung mit PayPal');
	define('TEXT_PAYPALWPP_EC_BUTTON_TEXT', 'Sparen Sie Zeit. Zahlen Sie sicher, ohne Ihre Finanzinformationen preiszugeben.');
	define('TEXT_PAYPALWPP_EC_BUTTON_DESCRIPTION_TEXT', 'Wenn Sie schon verifiziertes Mitglied bei <a href="'.$http_protocol.'://www.paypal.de" target="_blank" title="Zur PayPal Webseite gehen"><b>PayPal</b></a> sind (oder dies werden wollen), k�nnen Sie den Zahlungsprozess sehr verk�rzen! (Sie brauchen z.B. dann auch keine Adresse mehr einzugeben, weil diese von Ihrem PayPal-Konto �bermittelt wird.)');
	define('EMAIL_EC_ACCOUNT_INFORMATION', 'Vielen Dank, dass Sie die '.MODULE_PAYMENT_PAYPAL_EC_TEXT_TITLE.' verwendet haben! Um Ihren n�chsten Besuch bei uns noch einfacher zu machen, wurde ein Kundenkonto in unserem Shop angelegt. Ihre neue Login-Informatiom finden Sie folgend:' . "\n\n");
	//---PayPal WPP Modification END---//
	//	W. Kaiser - Erlaube Sendungstracking
	define('ENTRY_TRACKCODE', 'Sendungscode');
	define('ENTRY_TRACKCODE_EXPLAIN', '&nbsp;&nbsp;('.ENTRY_TRACKCODE.' f�r die Sendungsverfolgung)');
	define('ENTRY_TRACK_URL_TEXT','<br/><b>Zur Sendungsverfolgung hier klicken</b>');
	//	W. Kaiser - Erlaube Sendungstracking

	define('PARSE_TIME_STRING','Laufzeit: %s Sekunden');
	define('ADODB_EXECUTES_STRING',". Ausgef�hrte 'ADODB' SQL-Befehle=");
	define('ADODB_EXECUTES_CACHED_STRING'," (davon aus dem Cache: %s - 'Cache-Hit-Rate': %s %% -)");

	define('LIVE_HELP_TITLE',
	"Zu Ihrer besseren Unterst�tzung haben wir eine Technologie in unseren Shop integriert, die es erlaubt, eine direkte Echtzeit-Kommunikation zwischen den Besuchern unserer Internet-Seite und uns herzustellen. Wenn Sie also eine Frage haben, k�nnen Sie versuchen, direkt online mit uns in Verbindung zu treten, und diese Frage im Online Chat interaktiv direkt zu kl�ren! Sie starten diesen Vorgang durch 'Klick' auf dieses Bild.");

	define('TEXT_GALLERY','Produkt-Galerie (Bilder)');
	$rights=' volle Zugriffsrechte!<br/>("777" f�r LINUX/UNIX, "lesen/schreiben" f�r Windows)';
	define('TEXT_NO_SMARTY_COMPILE_DIR','Bitte legen Sie das Verzeichnis "%s" an, und geben Sie ihm'.$rights);
	define('TEXT_SMARTY_COMPILE_DIR_RIGHTS','Das Verzeichnis "%s" ben�tigt'.$rights);
	define('TEXT_ERROR_HANDLER_ERROR_TYPE','Fehler <b>#error_nr#<br/><font color="#FF0000">#error_text#</font></b><br/>');
	define('TEXT_ERROR_HANDLER_ERROR_FILE','Datei: <b><font color="#0000FF">#file#</font></b>, Zeile: <b>#line#</b><br/>');

	define('ILLEGAL_DIRECTORY','Ung�ltiges Verzeichnis: ');

	define('TEXT_ERROR_LINK_NOT_DEFINED','Es ist kein Link-Ziel definiert!');
	define('TEXT_ERROR_WRONG_INI_ENTRY','Unvollst�ndiger Eintrag in "%s"! ("%s")');
	define('TEXT_ERROR_MISSING_INI_FILE','Fehlende Box-Ini-Datei: "');
	define('TEXT_ERROR_MISSING_INI_DATA','Fehlende Box-Initialisierung in der Datenbank!');
	define('TEXT_ERROR_MULTIPLE_INI_ENTRY','Mehrfach belegte Box-Position: Navigations-Bereich "%s", Position %s!');

	define('CATEGORY_PAGE','Kategorie-Seite ');
	define('PRODUCTS_PAGE','Produkt-Seite ');

	define('PAYMENT_PROBLEM','Konnte keine Verbindung zu "%s" aufbauen.\nBitte w�hlen Sie eine andere Zahlungsart!');
	define('TEXT_CAT_NEW_PRODUCTS','Neue Produkte');
	define('TEXT_OUR_NEW_PRODUCTS','Unsere neuen Produkte f�r Sie');
	define('TEXT_CAT_TOP_PRODUCTS','Top Produkte');
	define('TEXT_OUR_TOP_PRODUCTS','Unsere Top-Produkte f�r Sie');
	define('TEXT_CAT_UPCOMING_PRODUCTS','Bald verf�gbare Produkte');
	define('TEXT_OUR_UPCOMING_PRODUCTS','Unsere bals verf�gbaren Produkte f�r Sie');
	define('TEXT_CAT_PROMOTION_PRODUCTS','Promotion-Produkte');
	define('TEXT_OUR_PROMOTION_PRODUCTS','Unsere '.TEXT_CAT_PROMOTION_PRODUCTS);

	define('TEXT_NEW_SHOP_DESIGN',HTML_BR.'Bitte w�hlen Sie ein Shop-Design aus'.HTML_BR);
	define('TEXT_NO_SHOP_DESIGNS','<b>Keine weiteren Shop-Designs vorhanden</b>');
	define('TEXT_CHANGE_SHOP_DESIGN','Shop-Design �ndern');

	define('TEXT_SLIDE_SHOW_SLOWER','Langsamer');
	define('TEXT_SLIDE_SHOW_FASTER','Schneller');
	define('TEXT_SLIDE_SHOW_STOP','Anhalten');
	define('TEXT_SLIDE_SHOW_START','Weiter');
	define('TEXT_SLIDESHOW_BUTTONS_SPEED','Wechsel-Intervall: % Sekunden');
	define('TEXT_SLIDESHOW_BUTTONS_SPEEDUP','Wechsel-Intervall auf % Sekunden setzen');
	define('TEXT_SELECT_OPTION','Bitte w�hlen Sie die gew�nschte Produkt-Option');

	define('TEXT_NAVIGATION_FIRST','Zum ersten Produkt');
	define('TEXT_NAVIGATION_PREVIOUS','Zum vorherigen Produkt');
	define('TEXT_NAVIGATION_FIRST_NEXT','Zum n�chsten Produkt');
	define('TEXT_NAVIGATION_LAST','Zum letzten Produkt"');

	define('TEXT_MORE_REVIEWS', 'Mehr Bewertungen');

	define('TEXT_NO_SMARTY_COMPILE_DIR','Bitte legen Sie das Verzeichnis "%s" an, und geben Sie ihm volle Zugriffsrechte<br>("777" f�r LINUX/UNIX, "lesen/schreiben" f�r Windows)');
	define('TEXT_ERROR_HANDLER_ERROR_TYPE','Fehler <B>#error_nr#<br /><FONT COLOR="#FF0000">#error_text#</FONT></B><br />');
	define('TEXT_ERROR_HANDLER_ERROR_FILE','Datei: <B><FONT COLOR="#0000FF">#file#</FONT></B>, Zeile: <B>#line#</B><br />');

	#eMail-Impressum
	define('STORE_NAME_ADDRESS_TEXT','Dies ist eine eMail von');
	define('STORE_EMAIL_TEXT','eMail-Adresse');
	define('STORE_USTID_TEXT','USt-ID');
	define('STORE_TAXNR_TEXT','Steuer-Nr');
	define('STORE_REGISTER_TEXT','Registergericht');
	define('STORE_REGISTER_NR_TEXT','Register-Nr');
	define('STORE_REGISTER_CITY_TEXT','Firmensitz');
	define('STORE_MANAGER_TEXT','Gesch�ftsf�hrer');
	define('STORE_DIRECTOR_TEXT','Aufsichtsrat');
	define('STORE_BANK_OWNER_TEXT', 'Kontoinhaber');
	define('STORE_BANK_NAME_TEXT', 'Geldinstitut');
	define('STORE_BANK_BLZ_TEXT', 'Bankleitzahl');
	define('STORE_BANK_ACCOUNT_TEXT', 'Kontonummer');
	define('STORE_BANK_BIC_TEXT', 'BIC');
	define('STORE_BANK_IBAN_TEXT', 'IBAN');

	define('AJAX_LOGO_TITLE','AJAX-Informationen bei Wikipedia');
	define('AJAX_LOGO_LINK','http://de.wikipedia.org/wiki/Ajax_(Programmierung)');

	define('ENTRY_VAT_TEXT', 'Nur f&uuml;r Deutschland und EU!');
	define('ENTRY_VAT_ERROR', 'Die Eingegebene UstID ist ung�ltig oder kann derzeit nicht �berpr�ft werden! Bitte geben Sie eine g�ltige ID ein oder lassen Sie das Feld leer.');

	if (SHOW_AFFILIATE)
	{
		// inclusion for affiliate program
		include($lang_dir.'affiliate_german.php');
	}
}
?>