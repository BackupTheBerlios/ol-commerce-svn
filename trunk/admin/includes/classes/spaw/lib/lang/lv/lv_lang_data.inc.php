<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Latvian language file
// ================================================
// Developed: Jânis Grâvitâs, sun@sveiks.lv
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
    'title' => 'Kopçt'
  ),
  'paste' => array(
    'title' => 'Ielikt'
  ),
  'undo' => array(
    'title' => 'Atcelt'
  ),
  'redo' => array(
    'title' => 'Atkârtot'
  ),
  'image_insert' => array(
    'title' => 'Ielikt attçloğanu',
    'select' => 'Ielikt',
	'delete' => 'Nodzçst', // new 1.0.5
    'cancel' => 'Atcelt',
    'library' => 'Bibliotçka',
    'preview' => 'Caurskatîğana',
    'images' => 'Attçloğanas',
    'upload' => 'Piekraut attçloğanu',
    'upload_button' => 'Piekraut',
    'error' => 'Kïûda',
    'error_no_image' => 'Izvçlaties attçloğanu',
    'error_uploading' => 'Ielâdes laikâ notika kïûda. Iemçìiniet vçlreiz.',
    'error_wrong_type' => 'Nekârtna attçloğanas tips',
    'error_no_dir' => 'Bibliotçka neeksistç',
	'error_cant_delete' => 'Nodzçst neizdevâs', // new 1.0.5
  ),
  'image_prop' => array(
    'title' => 'Attçloğanas parametri',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
    'source' => 'Avots',
    'alt' => 'Îss apraksts',
    'align' => 'Izlîdzinâğana',
    'left' => 'pa kreisi (left)',
    'right' => 'pa labi (right)',
    'top' => 'no augğas (top)',
    'middle' => 'centrâ (middle)',
    'bottom' => 'no lejas (bottom)',
    'absmiddle' => 'absolûts centrs (absmiddle)',
    'texttop' => 'no augğas (texttop)',
    'baseline' => 'no lejas (baseline)',
    'width' => 'Platums',
    'height' => 'Augstums',
    'border' => 'Râmîtis',
    'hspace' => 'Hor. lauki',
    'vspace' => 'Vert. lauki',
    'error' => 'Kïûda',
    'error_width_nan' => 'Platums nav skaitlis',
    'error_height_nan' => 'Augstums nav skaitlis',
    'error_border_nan' => 'Râmîtis nav skaitlis',
    'error_hspace_nan' => 'Horizontâli lauki nav skaitlis',
    'error_vspace_nan' => 'Vertikâli lauki nav skaitlis',
  ),
  'hr' => array(
    'title' => 'Horizontâla lînija'
  ),
  'table_create' => array(
    'title' => 'Radît tabulu'
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
    'border' => 'Râmîtis',
    'pixels' => 'piks.',
    'cellpadding' => 'Atkâpe no râmîğa',
    'cellspacing' => 'Attâlums starp ğûnâm',
    'bg_color' => 'Fona krâsa',
    'background' => 'Fonu attçloğana', // <=== new 1.0.6
    'error' => 'Kïûda',
    'error_rows_nan' => 'Rindas nav skaitlis',
    'error_columns_nan' => 'Slejas nav skaitlis',
    'error_width_nan' => 'Platums nav skaitlis',
    'error_height_nan' => 'Augstums nav skaitlis',
    'error_border_nan' => 'Râmîtis nav skaitlis',
    'error_cellpadding_nan' => 'Atkâpe no râmîğa nav skaitlis',
    'error_cellspacing_nan' => 'Attâlums starp ğûnâm nav skaitlis',
  ),
  'table_cell_prop' => array(
    'title' => 'Ğûnas parametri',
    'horizontal_align' => 'Horizontâla izlîdzinâğana',
    'vertical_align' => 'Vertikâla izlîdzinâğana',
    'width' => 'Platums',
    'height' => 'Augstums',
    'css_class' => 'Stils',
    'no_wrap' => 'Bez pârnesuma',
    'bg_color' => 'Fona krâsa',
    'background' => 'Fonu attçloğana', // <=== new 1.0.6
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
    'left' => 'Pa kreisi',
    'center' => 'Centrâ',
    'right' => 'Pa labi',
    'top' => 'No augğas',
    'bottom' => 'No lejas',
    'baseline' => 'Bâziska teksta lînija',
    'error' => 'Kïûda',
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
    'title' => 'Aizdabût rindu'
  ),
  'table_column_delete' => array(
    'title' => 'Aizdabût sleju'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Apvienot pa labi'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Apvienot pa kreisi'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Sadalît pa horizontâli'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Sadalît pa vertikâli'
  ),
  'style' => array(
    'title' => 'Stils'
  ),
  'font' => array(
    'title' => 'Ğrifts'
  ),
  'fontsize' => array(
    'title' => 'Izmçrs'
  ),
  'paragraph' => array(
    'title' => 'Rindkopa'
  ),
  'bold' => array(
    'title' => 'Taukains'
  ),
  'italic' => array(
    'title' => 'Kursîvs'
  ),
  'underline' => array(
    'title' => 'Uzsvçrts'
  ),
  'ordered_list' => array(
    'title' => 'Nokârtots saraksts'
  ),
  'bulleted_list' => array(
    'title' => 'Nenokârtots saraksts'
  ),
  'indent' => array(
    'title' => 'Palielinât atkâpi'
  ),
  'unindent' => array(
    'title' => 'Samazinât atkâpi'
  ),
  'left' => array(
    'title' => 'Izlîdzinâğana pa kreisi'
  ),
  'center' => array(
    'title' => 'Izlîdzinâğana pa centru'
  ),
  'right' => array(
    'title' => 'Izlîdzinâğana pa labi'
  ),
  'fore_color' => array(
    'title' => 'Teksta krâsa'
  ),
  'bg_color' => array(
    'title' => 'Fona krâsa'
  ),
  'design_tab' => array(
    'title' => 'Pârslçgties maketçğanas reşîmâ (WYSIWYG)'
  ),
  'html_tab' => array(
    'title' => 'Pârslçgties koda redakcijas reşîmâ (HTML)'
  ),
  'colorpicker' => array(
    'title' => 'Krâsas izvçle',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
  ),
  'cleanup' => array(
    'title' => 'HTML tîrîğana',
    'confirm' => 'Ğî operâcija aizvâks visus stilus, ğriftus un nevajadzîgi tegi no redaktora tekoğâ satura. Daïa vai viss jûsu formatçğana var bût nozaudçts.',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
  ),
  'toggle_borders' => array(
    'title' => 'Iekïaut râmîğus',
  ),
  'hyperlink' => array(
    'title' => 'Links',
    'url' => 'Adrese',
    'name' => 'Vârds',
    'target' => 'Atvçrt',
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
	'_blank' => 'jaunâ logâ (_blank)',
	'_top' => 'uz visu logu (_top)',
	'_parent' => 'vecâku frejms (_parent)'
  ),
  'table_row_prop' => array(
    'title' => 'Rindas parametri',
    'horizontal_align' => 'Horizontâla izlîdzinâğana',
    'vertical_align' => 'Vertikâla izlîdzinâğana',
    'css_class' => 'Stils',
    'no_wrap' => 'Bez pârnesuma',
    'bg_color' => 'Fona krâsa',
    'ok' => '??????',
    'cancel' => 'Atcelt',
    'left' => 'Pa kreisi',
    'center' => 'Centrâ',
    'right' => 'Pa labi',
    'top' => 'No augğas',
    'middle' => 'Centrâ',
    'bottom' => 'No lejas',
    'baseline' => 'Bâziska teksta lînija',
  ),
  'symbols' => array(
    'title' => 'Speciâli simboli',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
  ),
  'templates' => array(
    'title' => 'Ğabloni',
  ),
  'page_prop' => array(
    'title' => 'Lapaspuses parametri',
    'title_tag' => 'Virsraksts',
    'charset' => 'Simbolu salikums',
    'background' => 'Fonu attçloğana',
    'bgcolor' => 'Fona krâsa',
    'text' => 'Teksta krâsa',
    'link' => 'Atsauèu krâsa',
    'vlink' => 'Apmeklçto atsauèu krâsa',
    'alink' => 'Aktîvu atsauèu krâsa',
    'leftmargin' => 'Atkâpe pa kreisi',
    'topmargin' => 'Atkâpe no augğas',
    'css_class' => 'Stils',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
  ),
  'preview' => array(
    'title' => 'Iepriekğçja caurskatîğana',
  ),
  'image_popup' => array(
    'title' => 'Popup attçloğanas',
  ),
  'zoom' => array(
    'title' => 'Palielinâğana',
  ),
  'subscript' => array( // <=== new 1.0.7
    'title' => 'Apakğçjs indekss',
  ),
  'superscript' => array( // <=== new 1.0.7
    'title' => 'Augğçjs indekss',
  ),
);
?>