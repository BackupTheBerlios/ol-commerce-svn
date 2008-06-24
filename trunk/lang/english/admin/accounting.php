<?php
/* --------------------------------------------------------------
$Id: accounting.php,v 2.0.0 2006/12/14 05:48:29 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommercecoding standards www.oscommerce.com
(c) 2003	    nextcommerce (accounting.php,v 1.27 2003/08/24); www.nextcommerce.org
(c) 2004      XT-Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

//User friendly texts
$statistik='Statistik-';
$affiliate='Affiliate-';
$accounting_text=array();
$accounting_text['accounting']='Zugriffsberechtigungen';
$accounting_text['affiliate_affiliates']=$affiliate.'Affiliates einrichten';
$accounting_text['affiliate_banners']=$affiliate.'Banner';
$accounting_text['affiliate_clicks']=$affiliate.'Klicks';
$accounting_text['affiliate_contact']=$affiliate.'Kontakt';
$accounting_text['affiliate_invoice']=$affiliate.'Rechnungen';
$accounting_text['affiliate_payment']=$affiliate.'Zahlungen';
$accounting_text['affiliate_popup_image']=$affiliate.'Popup-Bild';
$accounting_text['affiliate_sales']=$affiliate.'Verkäufe';
$accounting_text['affiliate_statistics']=$affiliate.'Statistik';
$accounting_text['affiliate_summary']=$affiliate.'Überblick';
$accounting_text['attributeManager']='Attribut-Manager';
$accounting_text['backup']='Backups erstellen';
$accounting_text['banner_manager']='Banner-Manager';
$accounting_text['banner_statistics']='Banner-Statistik';
$accounting_text['blacklist']='KK-Blacklist bearbeiten';
$accounting_text['blz_update']='BLZ-Update';
$accounting_text['cache']='Cache-Verhalten einstellen';
$accounting_text['categories']='Kategorien bearbeiten';
$accounting_text['chCounter']=$statistik.'Shop (chCounter)';
$accounting_text['configuration']='Konfiguration';
$accounting_text['content_manager']='Content-Manager';
$accounting_text['content_preview']='Content-Vorschau';
$accounting_text['countries']='Ländereinstellungen bearbeiten';
$accounting_text['coupon_admin']='Gutschein-Verwaltung';
$accounting_text['create_account']='Kunden anlegen';
$accounting_text['credits']='Gutschriften bearbeiten';
$accounting_text['currencies']='Währungen bearbeiten';
$accounting_text['customers']='Kunden bearbeiten';
$accounting_text['customers_status']='Kunden-Status';
$accounting_text['define_language']='Spracheinstellungen bearbeiten';
$accounting_text['down_for_maintenance']='Wartungsabschaltung';
$accounting_text['easypopulate']='"Easy populate"-Import';
$accounting_text['eazysales']='Easy Sales-Verwaltung';
$accounting_text['elmar_start']='Elm@r-Verwaltung';
$accounting_text['froogle']='Froogle-Verwaltung';
$accounting_text['geo_zones']='Länderzuordnungen bearbeiten';
$accounting_text['google_sitemap']='Google-Sitemap';
$accounting_text['gv_mail']='Gutschein-eMails';
$accounting_text['gv_queue']='Gutschein-Warteschlange';
$accounting_text['gv_sent']='Gutscheine versendet';
$accounting_text['languages']='Sprachen bearbeiten';
$accounting_text['listcategories']='Kategorien listen';
$accounting_text['listproducts']='Produkte listen';
$accounting_text['livehelp']='Live Hilfe';
$accounting_text['mail']='eMails versenden';
$accounting_text['manufacturers']='Hersteller-Verwaltung';
$accounting_text['module_export']='Daten-Export';
$accounting_text['module_newsletter']='Newsletter-Verwaltung';
$accounting_text['modules']='OL-Commerce Module';
$accounting_text['new_attributes']='Produkt-Attribut-Verwaltung';
$accounting_text['orders']='Bestellungen';
$accounting_text['orders_edit']='Bestellungen ändern';
$accounting_text['orders_status']='Bestellungen Status';
$accounting_text['paypal_ipn']='"Paypal IPN"-Verwaltung';
$accounting_text['pdf_datasheet']='PDF-Datenblatt';
$accounting_text['pdf_export']='PDF-Katalog';
//$accounting_text['popup_memo']='';
$accounting_text['print_order']='Bestellungen drucken';
$accounting_text['print_packingslip']='Lieferscheine drucken';
$accounting_text['products_attributes']='Produktattribute zuordnen';
$accounting_text['products_vpe']='Verpackungseinheiten definieren';
$accounting_text['reviews']='Produktbeurteilungen';
$accounting_text['server_info']='Server Info anzeigen';
$accounting_text['shipping_status']='Lieferstatus anzeigen';
$accounting_text['specials']='Sonderpreise festlegen';
//$accounting_text['start']='';
$accounting_text['stats_customers']=$statistik.'Kunden';
$accounting_text['stats_products_expected']=$statistik.'Erwarteter Produkt-Zugang ';
$accounting_text['stats_products_purchased']=$statistik.'Verkaufte Produkte';
$accounting_text['stats_products_viewed']=$statistik.'Betrachtete Produkte';
$accounting_text['stats_sales_report']=$statistik.'Verkäufe';
$accounting_text['tax_classes']='Steuerklassen bearbeiten';
$accounting_text['tax_rates']='Steuersätze bearbeiten';
//$accounting_text['validcategories']='';
//$accounting_text['validproducts']='';
$accounting_text['whos_online']='Wer ist online aktivieren';
$accounting_text['xml_export']='CAO-Faktura Export';
$accounting_text['xsell_products']='"Cross-Sale" Produkte bearbeiten';
$accounting_text['zones']='Zonen bearbeiten';
?>
