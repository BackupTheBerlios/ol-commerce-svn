<?php
//---PayPal WPP Modification START ---//
define('MODULE_PAYMENT_PAYPAL_EC_TEXT_TITLE', 'PayPal Express-Zahlung');
define('MODULE_PAYMENT_PAYPAL_EC_TEXT_DESC', 'Über die <b>'.MODULE_PAYMENT_PAYPAL_EC_TEXT_TITLE.'</b> können Ihre Kunden schnell mit PayPal bezahlen, und Zahlungs-Transaktionen in nur wenigen Schritten abschließen. Damit können die Kunden Versand- und Rechnungsdaten, die sicher bei PayPal gespeichert sind, während der Kaufabwicklung verwenden und müssen diese Daten nicht erneut auf Ihrer Website eingeben.');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_TITLE', 'Kreditkarte');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_DESCRIPTION', 'Die ' . MODULE_PAYMENT_PAYPAL_EC_TEXT_TITLE.' erlaubt ein direktes Kreditkarten-Clearing ohne dass "PayPal" in Erscheinung tritt.<br/><br/>'.MODULE_PAYMENT_PAYPAL_EC_TEXT_DESC);
define('MODULE_PAYMENT_PAYPAL_DP_STATUS_TITLE','Dieses Zahlungsmodul aktivieren');
define('MODULE_PAYMENT_PAYPAL_DP_STATUS_DESC', 'Wollen Sie dieses Zahlungsmodul aktivieren?');
define('MODULE_PAYMENT_PAYPAL_DP_DEBUGGING_TITLE','Debug Mode');
define('MODULE_PAYMENT_PAYPAL_DP_DEBUGGING_DESC', 'Wollen Sie den '.MODULE_PAYMENT_PAYPAL_DP_DEBUGGING_TITLE.' aktivieren?  Ein kompletter Dump fehlgeschlagener Transaktionen wird per eMail zu dem Shop-Besitzer geschickt.');
define('MODULE_PAYMENT_PAYPAL_DP_SERVER_TITLE','Live oder Sandbox PayPal API');
define('MODULE_PAYMENT_PAYPAL_DP_SERVER_DESC', 'Live: Echte Transaktionen<br/>Sandbox: Für Entwicklung und Test');
define('MODULE_PAYMENT_PAYPAL_DP_CERT_PATH_TITLE','API Zertifikat');
define('MODULE_PAYMENT_PAYPAL_DP_CERT_PATH_DESC', 'Geben Sie den Datei-Namen für das '.MODULE_PAYMENT_PAYPAL_DP_CERT_PATH_TITLE.' ein.<br/>(Dies muss ein absolouter Pfad sein!)');
define('MODULE_PAYMENT_PAYPAL_DP_API_USERNAME_TITLE','API Username');
define('MODULE_PAYMENT_PAYPAL_DP_API_USERNAME_DESC', 'Ihr Paypal WPP '.MODULE_PAYMENT_PAYPAL_DP_API_USERNAME_TITLE);
define('MODULE_PAYMENT_PAYPAL_DP_API_PASSWORD_TITLE','API Passwort');
define('MODULE_PAYMENT_PAYPAL_DP_API_PASSWORD_DESC', 'Ihr Paypal WPP '.MODULE_PAYMENT_PAYPAL_DP_API_PASSWORD_TITLE);
define('MODULE_PAYMENT_PAYPAL_DP_PROXY_TITLE','Proxy Addresse');
define('MODULE_PAYMENT_PAYPAL_DP_PROXY_DESC', 'Wenn die Transaktionen über einen Proxy-Server abgewickelt werden, geben Sie bitte die Proxy_Adresse hier ein.  Andernfalls lassen Sie das Feld leer.');
define('MODULE_PAYMENT_PAYPAL_DP_SAFEGUARD_TITLE','Benachrichtigung bei abgewiesener Zahlung');
define('MODULE_PAYMENT_PAYPAL_DP_SAFEGUARD_DESC', 'Wollen Sie die Kundenzahlungsinformationen per eMail zugeschickt haben, wenn eine Zahlung abgewiesen wurde, so dass Sie diese manuell verarbeiten können? (Alle Fehlermeldungen von PayPal werden ignoriert, und der Kunde erhält die Information, dass seine Zahlung erfolgreich war.)');
$express_zahlung="Express-Zahlung: ";
define('MODULE_PAYMENT_PAYPAL_EC_ADDRESS_OVERRIDE_TITLE',$express_zahlung . 'Adressänderung durchführen (Funktioniert nicht!))');
define('MODULE_PAYMENT_PAYPAL_EC_ADDRESS_OVERRIDE_DESC', 'Wollen Sie für eingeloggte Kunden die von PayPal gemeldete Versdand-Adresse mit der in Ihrer Datenbank überschreiben?');
define('MODULE_PAYMENT_PAYPAL_EC_PAGE_STYLE_TITLE',$express_zahlung . 'PayPal Seiten Stil (Style)');
define('MODULE_PAYMENT_PAYPAL_EC_PAGE_STYLE_DESC', 'Wenn Sie einen besonderen PayPal Seiten Stil (Style) haben, den Ihre "Express-Zahlung" -Kunden sehen sollen, tragen Sie ihn hier ein.');
define('MODULE_PAYMENT_PAYPAL_DP_BUTTON_PAYMENT_PAGE_TITLE',$express_zahlung . 'Schaltflächen Plazierung');
define('MODULE_PAYMENT_PAYPAL_DP_BUTTON_PAYMENT_PAGE_DESC', 'Wollen Sie die "Express-Zahlung"-Schaltfläche auf Ihrer zahlungsseite anzeigen?');
define('MODULE_PAYMENT_PAYPAL_DP_REQ_VERIFIED_TITLE',$express_zahlung . 'Nur verifizierte PayPal-Kunden akzeptieren');
define('MODULE_PAYMENT_PAYPAL_DP_REQ_VERIFIED_DESC', 'Wollen Sie nur verifizierte PayPal-Kunden bei der "Express-Zahlung" akzeptieren? (SEHR EMPFOHLEN: Yes)');
define('MODULE_PAYMENT_PAYPAL_DP_CONFIRMED_TITLE',$express_zahlung . 'Nur bestätigte Adresse');
define('MODULE_PAYMENT_PAYPAL_DP_CONFIRMED_DESC', 'Wollen Sie nur von PayPal bestätigte Lieferadressen akzeptieren? (SEHR EMPFOHLEN: Yes)');
define('MODULE_PAYMENT_PAYPAL_DP_DISPLAY_PAYMENT_PAGE_TITLE',$express_zahlung . 'Zahlungsseite anzeigen');
define('MODULE_PAYMENT_PAYPAL_DP_DISPLAY_PAYMENT_PAGE_DESC', 'Soll bei der Express-Zahlung die Zahlungsseite angezeigt werden?  (Die Zahlungsoptionen werden nicht angezeigt.) (Yes, wenn Sie mit Gutscheinen arbeiten!)');
define('MODULE_PAYMENT_PAYPAL_DP_NEW_ACCT_NOTIFY_TITLE',$express_zahlung . 'Automatische Konten-Erstellung');
define('MODULE_PAYMENT_PAYPAL_DP_NEW_ACCT_NOTIFY_DESC', 'Wenn ein Besucher kein Bestandskunde ist, wird ein Konto für ihn angelegt. Soll dies ein permanentes Konto werden, und dem Kunden seine Login-Information per eMail zugeschickt werden?');
define('MODULE_PAYMENT_PAYPAL_DP_PEAR_PATH_TITLE','Pfad der "Pear"-Module');
define('MODULE_PAYMENT_PAYPAL_DP_PEAR_PATH_DESC', 'Wenn Sie die mitgelieferten "Pear"-Module installiert haben, in welchem Verzeichnis befinden sich diese?  Sollte sein:<br/>' . DIR_FS_CATALOG . 'pear/<br/>Wenn Sie das Feld leer lassen, wird der Standard-"include"-Pfad des Servers verwendet.');
define('MODULE_PAYMENT_PAYPAL_DP_CURRENCY_TITLE',' Währung für Kredikarten-Zahlungen');
define('MODULE_PAYMENT_PAYPAL_DP_CURRENCY_DESC', 'Die für Kredikarten-Zahlungen verwendete Währung.');
define('MODULE_PAYMENT_PAYPAL_DP_SORT_ORDER_TITLE','Sortierreihenfolge der Anzeige.');
define('MODULE_PAYMENT_PAYPAL_DP_SORT_ORDER_DESC', MODULE_PAYMENT_PAYPAL_DP_SORT_ORDER_TITLE.' Die niedrigste wird zuerst angezeigt.');
define('MODULE_PAYMENT_PAYPAL_DP_ZONE_TITLE','Zulässige Zahlungs-Zonen für diese Zahlungsart');
define('MODULE_PAYMENT_PAYPAL_DP_ZONE_DESC', 'Geben Sie <b>einzeln</b> die Zonen an, welche für dieses Modul erlaubt sein sollen. (z.B. AT,DE). Wenn das Feld leer ist, werden alle Zonen erlaubt.');
define('MODULE_PAYMENT_PAYPAL_DP_ORDER_STATUS_ID_TITLE','Bestell-Status Kennzeichen');
define('MODULE_PAYMENT_PAYPAL_DP_ORDER_STATUS_ID_DESC', 'Der Bestell-Status von Bestellungen, die mit dieser Zahlungsart gezahlt wurden, wird auf diesen Wert gesetzt.');

define('MODULE_PAYMENT_PAYPAL_DP_ERROR_HEADING', 'Wir können Ihre Kreditkarte leider nicht verarbeiten.');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_CARD_ERROR', 'Die von Ihnen eingegebene Kreditkarten-Information enthält einen Fehler.  Bitte korrigieren und dann noch einmal versuchen.');
$credit_card=' auf der Kreditkarte:';
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_FIRSTNAME', 'Vorname'.$credit_card);
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_LASTNAME', 'Nachname'.$credit_card);
$credit_card='Kreditkarten-';
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_TYPE', $credit_card.'Typ:');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_NUMBER', $credit_card.'Nummer:');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_EXPIRES', $credit_card.'Gültigkeitsdatum:');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_CHECKNUMBER', $credit_card.'Prüfnummer:');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION',
'(diese finden Sie auf der Rückseite Ihrer Kreditkarte)');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_DECLINED', 'Ihre Kreditkarte wurde abgelehnt. Bitte verwenden Sie eine andere Kreditkarte, oder fragen Sie bei der Kreditkarten-Ausgabestelle nach weiteren Informationen.<br/><br/>');
define('MODULE_PAYMENT_PAYPAL_DP_INVALID_RESPONSE', 'Der Kreditkarten-Service hat ungültige oder unvollständige Daten zurückgemeldet, so dass wir Ihre Bestellung nicht verarbeiten können. Bitte versuchen Sie es erneut, oder wählen Sie eine andere Zahlungsart.<br/><br/>');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_GEN_ERROR',
'Beim Kontakt mit dem  Kreditkarten-Server trat ein Fehler auf.<br/><br/>');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_ERROR',
'Bei der Verarbeitung Ihrer Kreditkarte trat ein Fehler auf.<br/><br/>');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_UNVERIFIED', 'Um einen hohen Sicherheitsstandard zu erreichen, müssen alle Kunden, welche die '.MODULE_PAYMENT_PAYPAL_EC_TEXT_TITLE.' verwenden wollen, <b>verifizierte</b> PayPal Kunden sein. Lassen Sie also entweder Ihr PayPal-Konto verifizieren, oder wählen Sie eine andere Zahlungsart.');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_BAD_CARD', 'Der Kreditkarten-Service akzeptiert nur "Visa"- und "MasterCard"-Kreditkarten.');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_BAD_LOGIN', 'Es gab ein Problem, Ihr Konto zu validieren. Bitte versuchen Sie es noch einmal.');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_JS_CC_OWNER', '* Der Name des Kreditkarten-Inhabers muss mindestens ' . CC_OWNER_MIN_LENGTH . ' Zeichen lang sein.\n');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_JS_CC_NUMBER', '* Die Kreditkarten-Nummer muss mindestens ' . CC_NUMBER_MIN_LENGTH . '  Ziffern lang sein.\n');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_EC_HEADER', 'Schnelle und sichere Zahlung mit PayPal:');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_BUTTON_TEXT', 'Sparen Sie Zeit. Zahlen Sie sicher. Zahlen Sie ohne Preisgabe Ihrer vertraulichen Finanzdaten.');
define('MODULE_PAYMENT_PAYPAL_DP_TEXT_STATE_ERROR', 'Das Ihrem Konto zugeordnete (Bunde-)Land ist ungültig. Bitte ändern Sie dies in Ihren Konto-Daten.');
define('PAYPAL_DP_STATUS_COMPLETED','Completed');
define('PAYPAL_DP_STATUS_PENDING','In Bearbeitung');
define('MODULE_PAYMENT_PAYPAL_DP_CC_TEXT', " (%s oder %s)");
//---PayPal WPP Modification END---//
?>