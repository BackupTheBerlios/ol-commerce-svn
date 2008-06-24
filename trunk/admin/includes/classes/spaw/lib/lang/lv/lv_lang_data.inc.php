<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Latvian language file
// ================================================
// Developed: J�nis Gr�vit�s, sun@sveiks.lv
// Copyright: Solmetra (c)2003 All rights reserved.
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'windows-1257';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Izgriezt'
  ),
  'copy' => array(
    'title' => 'Kop�t'
  ),
  'paste' => array(
    'title' => 'Ielikt'
  ),
  'undo' => array(
    'title' => 'Atcelt'
  ),
  'redo' => array(
    'title' => 'Atk�rtot'
  ),
  'image_insert' => array(
    'title' => 'Ielikt att�lo�anu',
    'select' => 'Ielikt',
	'delete' => 'Nodz�st', // new 1.0.5
    'cancel' => 'Atcelt',
    'library' => 'Bibliot�ka',
    'preview' => 'Caurskat��ana',
    'images' => 'Att�lo�anas',
    'upload' => 'Piekraut att�lo�anu',
    'upload_button' => 'Piekraut',
    'error' => 'K��da',
    'error_no_image' => 'Izv�laties att�lo�anu',
    'error_uploading' => 'Iel�des laik� notika k��da. Iem��iniet v�lreiz.',
    'error_wrong_type' => 'Nek�rtna att�lo�anas tips',
    'error_no_dir' => 'Bibliot�ka neeksist�',
	'error_cant_delete' => 'Nodz�st neizdev�s', // new 1.0.5
  ),
  'image_prop' => array(
    'title' => 'Att�lo�anas parametri',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
    'source' => 'Avots',
    'alt' => '�ss apraksts',
    'align' => 'Izl�dzin��ana',
    'left' => 'pa kreisi (left)',
    'right' => 'pa labi (right)',
    'top' => 'no aug�as (top)',
    'middle' => 'centr� (middle)',
    'bottom' => 'no lejas (bottom)',
    'absmiddle' => 'absol�ts centrs (absmiddle)',
    'texttop' => 'no aug�as (texttop)',
    'baseline' => 'no lejas (baseline)',
    'width' => 'Platums',
    'height' => 'Augstums',
    'border' => 'R�m�tis',
    'hspace' => 'Hor. lauki',
    'vspace' => 'Vert. lauki',
    'error' => 'K��da',
    'error_width_nan' => 'Platums nav skaitlis',
    'error_height_nan' => 'Augstums nav skaitlis',
    'error_border_nan' => 'R�m�tis nav skaitlis',
    'error_hspace_nan' => 'Horizont�li lauki nav skaitlis',
    'error_vspace_nan' => 'Vertik�li lauki nav skaitlis',
  ),
  'hr' => array(
    'title' => 'Horizont�la l�nija'
  ),
  'table_create' => array(
    'title' => 'Rad�t tabulu'
  ),
  'table_prop' => array(
    'title' => 'Tabulas parametri',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
    'rows' => 'Rindas',
    'columns' => 'Slejas',
    'css_class' => 'Stils', // <=== new 1.0.6
    'width' => 'Platums',
    'height' => 'Augstums',
    'border' => 'R�m�tis',
    'pixels' => 'piks.',
    'cellpadding' => 'Atk�pe no r�m��a',
    'cellspacing' => 'Att�lums starp ��n�m',
    'bg_color' => 'Fona kr�sa',
    'background' => 'Fonu att�lo�ana', // <=== new 1.0.6
    'error' => 'K��da',
    'error_rows_nan' => 'Rindas nav skaitlis',
    'error_columns_nan' => 'Slejas nav skaitlis',
    'error_width_nan' => 'Platums nav skaitlis',
    'error_height_nan' => 'Augstums nav skaitlis',
    'error_border_nan' => 'R�m�tis nav skaitlis',
    'error_cellpadding_nan' => 'Atk�pe no r�m��a nav skaitlis',
    'error_cellspacing_nan' => 'Att�lums starp ��n�m nav skaitlis',
  ),
  'table_cell_prop' => array(
    'title' => '��nas parametri',
    'horizontal_align' => 'Horizont�la izl�dzin��ana',
    'vertical_align' => 'Vertik�la izl�dzin��ana',
    'width' => 'Platums',
    'height' => 'Augstums',
    'css_class' => 'Stils',
    'no_wrap' => 'Bez p�rnesuma',
    'bg_color' => 'Fona kr�sa',
    'background' => 'Fonu att�lo�ana', // <=== new 1.0.6
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
    'left' => 'Pa kreisi',
    'center' => 'Centr�',
    'right' => 'Pa labi',
    'top' => 'No aug�as',
    'bottom' => 'No lejas',
    'baseline' => 'B�ziska teksta l�nija',
    'error' => 'K��da',
    'error_width_nan' => 'Platums nav skaitlis',
    'error_height_nan' => 'Augstums nav skaitlis',
    
  ),
  'table_row_insert' => array(
    'title' => 'Ielikt rindu'
  ),
  'table_column_insert' => array(
    'title' => 'Ielikt sleju'
  ),
  'table_row_delete' => array(
    'title' => 'Aizdab�t rindu'
  ),
  'table_column_delete' => array(
    'title' => 'Aizdab�t sleju'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Apvienot pa labi'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Apvienot pa kreisi'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Sadal�t pa horizont�li'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Sadal�t pa vertik�li'
  ),
  'style' => array(
    'title' => 'Stils'
  ),
  'font' => array(
    'title' => '�rifts'
  ),
  'fontsize' => array(
    'title' => 'Izm�rs'
  ),
  'paragraph' => array(
    'title' => 'Rindkopa'
  ),
  'bold' => array(
    'title' => 'Taukains'
  ),
  'italic' => array(
    'title' => 'Kurs�vs'
  ),
  'underline' => array(
    'title' => 'Uzsv�rts'
  ),
  'ordered_list' => array(
    'title' => 'Nok�rtots saraksts'
  ),
  'bulleted_list' => array(
    'title' => 'Nenok�rtots saraksts'
  ),
  'indent' => array(
    'title' => 'Palielin�t atk�pi'
  ),
  'unindent' => array(
    'title' => 'Samazin�t atk�pi'
  ),
  'left' => array(
    'title' => 'Izl�dzin��ana pa kreisi'
  ),
  'center' => array(
    'title' => 'Izl�dzin��ana pa centru'
  ),
  'right' => array(
    'title' => 'Izl�dzin��ana pa labi'
  ),
  'fore_color' => array(
    'title' => 'Teksta kr�sa'
  ),
  'bg_color' => array(
    'title' => 'Fona kr�sa'
  ),
  'design_tab' => array(
    'title' => 'P�rsl�gties maket��anas re��m� (WYSIWYG)'
  ),
  'html_tab' => array(
    'title' => 'P�rsl�gties koda redakcijas re��m� (HTML)'
  ),
  'colorpicker' => array(
    'title' => 'Kr�sas izv�le',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
  ),
  'cleanup' => array(
    'title' => 'HTML t�r��ana',
    'confirm' => '�� oper�cija aizv�ks visus stilus, �riftus un nevajadz�gi tegi no redaktora teko�� satura. Da�a vai viss j�su format��ana var b�t nozaud�ts.',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
  ),
  'toggle_borders' => array(
    'title' => 'Iek�aut r�m��us',
  ),
  'hyperlink' => array(
    'title' => 'Links',
    'url' => 'Adrese',
    'name' => 'V�rds',
    'target' => 'Atv�rt',
    'title_attr' => 'Nosaukums',
	'a_type' => 'Tips', // <=== new 1.0.6
	'type_link' => 'Atsauce', // <=== new 1.0.6
	'type_anchor' => 'Enkurs', // <=== new 1.0.6
	'type_link2anchor' => 'links uz enkuru', // <=== new 1.0.6
	'anchors' => 'Enkuri', // <=== new 1.0.6
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
  ),
  'hyperlink_targets' => array( // <=== new 1.0.5
  	'_self' => 'tas pats frejms (_self)',
	'_blank' => 'jaun� log� (_blank)',
	'_top' => 'uz visu logu (_top)',
	'_parent' => 'vec�ku frejms (_parent)'
  ),
  'table_row_prop' => array(
    'title' => 'Rindas parametri',
    'horizontal_align' => 'Horizont�la izl�dzin��ana',
    'vertical_align' => 'Vertik�la izl�dzin��ana',
    'css_class' => 'Stils',
    'no_wrap' => 'Bez p�rnesuma',
    'bg_color' => 'Fona kr�sa',
    'ok' => '??????',
    'cancel' => 'Atcelt',
    'left' => 'Pa kreisi',
    'center' => 'Centr�',
    'right' => 'Pa labi',
    'top' => 'No aug�as',
    'middle' => 'Centr�',
    'bottom' => 'No lejas',
    'baseline' => 'B�ziska teksta l�nija',
  ),
  'symbols' => array(
    'title' => 'Speci�li simboli',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
  ),
  'templates' => array(
    'title' => '�abloni',
  ),
  'page_prop' => array(
    'title' => 'Lapaspuses parametri',
    'title_tag' => 'Virsraksts',
    'charset' => 'Simbolu salikums',
    'background' => 'Fonu att�lo�ana',
    'bgcolor' => 'Fona kr�sa',
    'text' => 'Teksta kr�sa',
    'link' => 'Atsau�u kr�sa',
    'vlink' => 'Apmekl�to atsau�u kr�sa',
    'alink' => 'Akt�vu atsau�u kr�sa',
    'leftmargin' => 'Atk�pe pa kreisi',
    'topmargin' => 'Atk�pe no aug�as',
    'css_class' => 'Stils',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
  ),
  'preview' => array(
    'title' => 'Iepriek��ja caurskat��ana',
  ),
  'image_popup' => array(
    'title' => 'Popup att�lo�anas',
  ),
  'zoom' => array(
    'title' => 'Palielin��ana',
  ),
  'subscript' => array( // <=== new 1.0.7
    'title' => 'Apak��js indekss',
  ),
  'superscript' => array( // <=== new 1.0.7
    'title' => 'Aug��js indekss',
  ),
);
?>