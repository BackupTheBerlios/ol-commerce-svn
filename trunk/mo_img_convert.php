<?PHP

require_once('includes/application_top.php');

$products_query = olc_db_query('SELECT * FROM '.TABLE_PRODUCTS);
$org_img=array();
while ($products_data = olc_db_fetch_array($products_query)){
	$endung = explode('.', $products_data['products_image']); $endung = end($endung); $error = false;
	if (!file_exists(DIR_WS_ORIGINAL_IMAGES.$products_data['products_id'] . '_0.'.$endung)){
	$endung = strtolower($endung);
	 $org_img[] =	$products_data['products_image'];
	echo 'Konvertiere ' . $products_data['products_image'] . ' zu ' . $products_data['products_id'] . '_0.'.$endung.HTML_BR;
	if (file_exists(DIR_WS_ORIGINAL_IMAGES.$products_data['products_image']) && $products_data['products_image'] != NULL){
	if (!@copy(DIR_WS_ORIGINAL_IMAGES.$products_data['products_image'], DIR_WS_ORIGINAL_IMAGES.$products_data['products_id'] . '_0.'.$endung)) $error = true;
	}
	if (file_exists(DIR_WS_THUMBNAIL_IMAGES.$products_data['products_image']) && $products_data['products_image'] != NULL){
	if (!@copy(DIR_WS_THUMBNAIL_IMAGES.$products_data['products_image'], DIR_WS_THUMBNAIL_IMAGES.$products_data['products_id'] . '_0.'.$endung)) $error = true;
	}
	if (file_exists(DIR_WS_INFO_IMAGES.$products_data['products_image']) && $products_data['products_image'] != NULL){
	if (!@copy(DIR_WS_INFO_IMAGES.$products_data['products_image'], DIR_WS_INFO_IMAGES.$products_data['products_id'] . '_0.'.$endung)) $error = true;
	}
	if (file_exists(DIR_WS_POPUP_IMAGES.$products_data['products_image']) && $products_data['products_image'] != NULL){
	if (!@copy(DIR_WS_POPUP_IMAGES.$products_data['products_image'], DIR_WS_POPUP_IMAGES.$products_data['products_id'] . '_0.'.$endung)) $error = true;
	}
	}
	if ($error) echo '<font color="red">Fehler</font> beim Konvertieren von Produkt mit id ' .$products_data['products_id'] . ': Bild '.$products_data['products_image'].' existiert anscheinend nicht.<br/>';
	if (!$error && file_exists(DIR_WS_ORIGINAL_IMAGES.$products_data['products_image'])) olc_db_query('SQL_UPDATE '.TABLE_PRODUCTS.' SET products_image = \''.$products_data['products_id'] . '_0.'.$endung.'\' WHERE products_id = \''.$products_data['products_id'].'\'');
}

echo '<br/>Konvertierung abgeschlossen.<br/><br/>';
if ($error) 	echo 'Es sind Fehler aufgetreten. Bitte korrigieren Sie diese manuell. Pr&uuml;fen Sie auch, ob die Bildverzeichnisse die Berechtigung <font color="red">777</font> auf ihrem Webserver haben.<br/>';
if (!$error){    						
						if(isset($org_img)){
						echo 'L&ouml;sche alte Bilder<br/>';
						foreach($org_img as $img){
									  @unlink(DIR_WS_ORIGINAL_IMAGES.$img);
										@unlink(DIR_WS_THUMBNAIL_IMAGES.$img);
										@unlink(DIR_WS_INFO_IMAGES.$img);
										@unlink(DIR_WS_POPUP_IMAGES.$img);
										}
						echo '<br/>L&ouml;schen abgeschlossen.<br/>Bitte <font color="red">l&ouml;schen</font> Sie jetzt diese Datei von ihrem Webserver!';
						}	else {
						echo '<br/>Keine Dateien zum L&ouml;schen vorhanden... Ende.';
						}																	
							
					}
									 


?>
