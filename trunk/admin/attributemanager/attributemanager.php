<?php
/*
$Id: attributemanager.php,v 1.1.1.1.2.1 2007/04/08 07:16:34 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Released under the GNU General Public License

Web Development
http://www.kangaroopartners.com
*/


// change the directory up one for application top includes
chdir('../');
$ajax_attributemanager=true;
// OSC application top needed for sessions, defines and functions
require_once('includes/application_top.php');
$attributemanager_text='attributemanager';
$attributemanager_classes_dir=$attributemanager_text.'/classes/';
$attributemanager_classes_dir_attributemanager=$attributemanager_classes_dir.$attributemanager_text;
$class_php='.class.php';
$attributemanager_includes_attributemanager=$attributemanager_text.'/includes/'.$attributemanager_text;
// config
require_once($attributemanager_includes_attributemanager.'config.inc.php');
// misc functions
require_once($attributemanager_includes_attributemanager.'functions.inc.php');
// parent class
require_once($attributemanager_classes_dir_attributemanager.$class_php);
// db wrapper
require_once($attributemanager_classes_dir.'db'.$class_php);
// instant class
require_once($attributemanager_classes_dir_attributemanager.'instant'.$class_php);
// atomic class
require_once($attributemanager_classes_dir_attributemanager.'atomic'.$class_php);
// security class
require_once($attributemanager_classes_dir.'stopdirectaccess'.$class_php);

// check that the file is allowed to be accessed
stopdirectaccess::checkAuthorisation(AM_SESSION_VALID_INCLUDE);

// construct the attributemanager classess and/or session variable
if (!is_numeric($_GET['products_id']) || AM_ATOMIC_PRODUCT_UPDATES) {

	// first time visiting the page - delete the session var and start again
	if('new_product' == $_GET['pageAction'] && !isset($_GET['amAction'])) {

		if(olc_session_is_registered(AM_SESSION_VAR_NAME)) {
			olc_session_unregister(AM_SESSION_VAR_NAME);
			unset(${AM_SESSION_VAR_NAME});
		}
	}

	// register the session if its not registered
	if(!olc_session_is_registered(AM_SESSION_VAR_NAME)){

		// declare the var (not nessessary)
		${AM_SESSION_VAR_NAME} = array();

		// start a new session
		olc_session_register(AM_SESSION_VAR_NAME);
	}

	//$attributemanager =& new attributemanagerAtomic(${AM_SESSION_VAR_NAME});
	$attributemanager = new attributemanagerAtomic(${AM_SESSION_VAR_NAME});
}
else {
	//$attributemanager =& new attributemanagerInstant($_GET['products_id']);
	$attributemanager = new attributemanagerInstant($_GET['products_id']);
}

$option_id=$_GET['option_id'];
$option_name=$_GET['option_name'];
$option_value_name=$_GET['option_value_name'];
$option_value_id=$_GET['option_value_id'];
$price=$_GET['price'];
$prefix=$_GET['prefix'];
// process the page actions
switch($_GET['amAction']) {
	case 'addOption':
		$newOptionId = $attributemanager->addOption($option_name);
		$selectedOption = $newOptionId;
	break;
	case 'addOptionValue':
		$newOptionValueId = $attributemanager->addOptionValue($option_id, $option_value_name);
		$selectedOptionValue = $newOptionValueId;
		$selectedOption = (int)$option_id;
	break;
	case 'addAttributeToProduct':
	case 'addOptionValueToProduct':
		$attributemanager->addAttributeToProduct($option_id,$option_value_id,$price,$prefix);
	break;
	case 'addNewOptionValueToProduct':
		$attributemanager->addNewOptionValueToProduct($option_id,$option_value_name);
		break;
	case 'removeOptionFromProduct':
		$attributemanager->removeOptionFromProduct($option_id);
	break;
	case 'removeOptionValueFromProduct':
		$attributemanager->removeOptionValueFromProduct($option_id,$option_value_id);
		break;
	case 'updateNewOptionValue':
		$selectedOption = $option_id;
		break;
	case 'update':
		$attributemanager->update($option_id, $option_value_id, $price,$prefix);
		break;
	default:
}

// get the current products options
$allProductOptionsAndValues = $attributemanager->getAllProductOptionsAndValues();

// count the options
$numOptions = count($allProductOptionsAndValues);

// not strictly nessessary but output a header
header("Content-type: text/plain");
//$attributemanager->debugOutput(${AM_SESSION_VAR_NAME});
$have_any_options=false;
$image_data0=' border="0" align="middle" src="attributemanager/images/icon_#.gif"';	//style="border:0px 0px 0px 0px;"
$image_data=' type="image"'.$image_data0;
$keys=implode(COMMA,array_keys($allProductOptionsAndValues));
$AllOptionValues=
	' title="Es werden alle Attribute und Optionswerte #" onclick="javascript:return amShowHideAllOptionValues([' . $keys .'],';

if($numOptions>0)
{
	$html_text='
		<table class="formArea" width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr>
				<td width="60" align="center" nowrap="nowrap">
					<img'. str_replace("#","plus",$image_data) . str_replace("#","geöffnet",$AllOptionValues) . 'true);"/>
					&nbsp;
					<img'. str_replace("#","minus",$image_data) . str_replace("#","geschlossen",$AllOptionValues) . 'false);"/>
				</td>
				<td width="41%">
					<b>Attribut-Bezeichnung</b>
				</td>
				<td width="15%">
					&nbsp;
				</td>
				<td  width="41%" align="center">
					<b>Aktion</b>
				</td>
			</tr>
';

	foreach($allProductOptionsAndValues as $optionId => $optionInfo)
	{
		$numValues = count($optionInfo["values"]);
		$optionInfoName = $optionInfo["name"];
		$optionInfoName_text=' \'' . $optionInfoName . '\'-Option ';
		$optionId_optionInfoName_parameter='\'' . $optionId. '\',\''.$optionInfoName.'\'';
		$new_option_value='new_option_value_'.$optionId;
		$new_option_values_array=$attributemanager->buildOptionValueDropDown($optionId);
		$optionInfoValues=$optionInfo["values"];
		if (sizeof($new_option_values_array)==1)
		{
			$build_dropdown=$new_option_values_array[0]['text'] <> "----";
		}
		else
		{
			$build_dropdown=true;
		}
		//if ($build_dropdown || sizeof($optionInfoValues)>0)
		if (sizeof($optionInfoValues)>0)
		{
			$icon="minus";
			$style="inline";
		}
		else
		{
			$icon="plus";
			$style="none";
		}
		$html_text.='
			<tr class="option">
				<td width="60" align="center" nowrap="nowrap">
					<input'. str_replace("#",$icon,$image_data).' id="show_hide_' . $optionId .
						'" onclick="javascript:return amShowHideOptionsValues(' . $optionId . ');"
						 />
				</td>
				<td width="41%">
					' . "<b>{$optionInfoName} ($numValues Optionswert(e))</b>" . '
				</td>
				<td width="15%">
					&nbsp;
				</td>
				<td width="41%" align="right">
					<span id="option_controls_'.$optionId.'" style="display:'.$style.';">
					';
				if ($build_dropdown)
				{
					$have_any_options=true;
					//Build only if any non-used optionvalues left!
					//$parameter=' style="vertical-align:top;margin:4px 5px 0px 0px;" id="'.$new_option_value.'"';
					$parameter=' style="vertical-align:top;margin:4px 5px 0px 0px;"';
					$html_text.=
					olc_draw_pull_down_menu($new_option_value,$new_option_values_array,$selectedOptionValue,$parameter).'
						<input'. str_replace("#","add_down",$image_data).' value="Add"
						onclick="javascript:return amAddOptionValueToProduct(\'' . $optionId.'\');"
						title="Fügt das links gewählte Attribut der'.$optionInfoName_text.'hinzu" />&nbsp;
						';
				}
				$html_text.='
						<input' . str_replace("#","add_new",$image_data) .
						' title="Fügt einen neuen Wert der'.$optionInfoName_text.'hinzu"
						onclick="javascript:return amAddNewOptionValueToProduct('.$optionId_optionInfoName_parameter.');" />
						&nbsp;
						<input' . str_replace("#","delete",$image_data) .' title="Entfernt die'.
						$optionInfoName_text.'und ihre(n) ' .$numValues . ' Optionswert(e) aus diesem Produkt"
						onclick="javascript:return amRemoveOptionFromProduct('.$optionId_optionInfoName_parameter.');" />&nbsp;
					</span>
				</td>
			</tr>';
		if($numValues>=0)
		{
			$html_text.='
			<tr>
				<td colspan="4">
					<table border="0" width="100%" id="all_trOptionsValues_' . $optionId . '" style="display:'.$style.';" />
					';
					foreach($optionInfoValues as $optionValueId => $optionValueInfo)
					{
						$optionValueInfoName=$optionValueInfo["name"];
						$prefix_id='id=".prefix_'.$optionValueId.'"';
						$onchange=' onchange="return amUpdate(\''.$optionId.'\',\''.$optionValueId.'\');"';
						$price_id='price_'.$optionValueId;
						$html_text.='
						<tr class="optionValue">
							<td width="60" align="center" nowrap="nowrap">
								<img'. str_replace("#","arrow",$image_data) .' />
							</td>
							<td width="41%">
								' . $optionValueInfoName . '
							</td>
							<td width="15%">
								Preis: '.drawDropDownPrefix($prefix_id, $onchange, $optionValueInfo["prefix"]).
								olc_draw_input_field($price_id, number_format($optionValueInfo["price"],2),$price_id .' size="7"'
								.$onchange)
								 . '
							</td>
							<td width="41%" align="right">
								<!--<input'. str_replace("#","download",$image_data).
								' title="Fügt das Attribut dem aktuellen Produkt hinzu"
								value="Add" onclick="javascript:return addOption();" />-->
								&nbsp;&nbsp;
								<input'. str_replace("#","delete",$image_data).' title="Entfernt den Optionswert \''.
									$optionValueInfoName.'\' aus der'.$optionInfoName_text.'von diesem Produkt"
									onclick="javascript:return amRemoveOptionValueFromProduct(\''.$optionId.'\',\''.
									 $optionValueId.'\',\''.
									 $optionInfoName.'\',\''.
									 $optionValueInfoName. '\');" />
							</td>
						</tr>';
					}
		$html_text.='
					</table>
				</td>
			</tr>
';
		}
	}
	$html_text.='
		</table>
		<br/>
		<span id="attributes_available" style="display:none;">'.$keys.'</span>
';
}

// check to see if the selected option isset. If it is not, pick the first otion in the dropdown
$optionDrop = $attributemanager->buildOptionDropDown();
if(!is_numeric($selectedOption)) {
	foreach($optionDrop as $key => $value) {
		if(olc_not_null($value["id"])){
			$selectedOption = $value["id"];
			break;
		}
	}
}
$optionValueDrop = $attributemanager->buildOptionValueDropDown($selectedOption);
//$optionDropDown_id='id="optionDropDown"';
$onchange=' onchange="return amUpdateNewOptionValue(this.value);"';
$selectedOptionValue=(is_numeric($selectedOptionValue) ? $selectedOptionValue : "");
$optionValueDropDown_id='id="optionValueDropDown"';
$prefix_0_id='prefix_0';
$newPrice_id='size="4" id="newPrice"';

if ($have_any_options)
{
	$icon="minus";
	$style="inline";
	$html_text='
		<div class="formArea">
			<table class="title" width="100%" border="0">
				<tr class="header">
					<td>
							<span title="Die Produkt-Attribute und -Optionswerte werden angezeigt/verborgen">
								<b>Produkt-Attribute</b>&nbsp;
							</span>
							<input'. str_replace("#",$icon,$image_data).'
							title="Die Produkt-Attribute und -Optionswerte werden angezeigt/verborgen"
							id="showHideAll" name="showHideAll" onclick="javascript:return amShowHideAttributeManager();" />
					</td>
				</tr>
			</table>
			<div id="currentAttributes" style="display:'.$style.';">
'.
	$html_text;
}
else
{
	$icon="plus";
	$style="none";
}
$html_text='
		'	.$html_text. '
		</div>
		<table class="title" width="100%" border="0">
			<tr class="header">
				<td>
						<span title="Es können neue Produkt-Attribute und -Optionswerte angelegt werden">
							<b>Neues Attribut</b>&nbsp;
						</span>
						<input'. str_replace("#","plus",$image_data).'
						title="Es können neue Produkt-Attribute und -Optionswerte angelegt werden"
						id="showHideNewAttribute" name="showHideNewAttribute" onclick="javascript:return amShowHideNewAttribute();" />
				</td>
			</tr>
		</table>
		<div id="newAttribute" style="display:none;">
			<table class="formArea" width="100%" border="0" cellpadding="5">
				<tr>
					<td width="60">&nbsp;</td>
					<td colspan="3">
						<b>Attribut-Bezeichnung</b>
					</td>
				</tr>
				<tr>
					<td width="60">&nbsp;</td>
					<td valign="top" colspan="3">
						' .
						olc_draw_pull_down_menu("optionDropDown",$optionDrop,$selectedOption,$optionDropDown_id.$onchange) . '
						&nbsp;&nbsp;
						<input'. str_replace("#","add_new",$image_data).'
						onclick="javascript:return amAddOption();" title="Fügt der Liste eine neue Option hinzu" />
						&nbsp;&nbsp;<b>Neues Attribut definieren</b>
						<!--<input'. str_replace("#","delete",$image_data).'
						onclick="javascript:return deleteOption();" title="Löscht die Option aus der Datenbank" />-->
						<!--
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input'. str_replace("#","add_up",$image_data).' value="Add"
						onclick="javascript:return amAddAttributeToProduct();" title="Das Attribut dem aktuellen Produkt hinzufügen" />
						&nbsp;&nbsp;<b>Das Attribut dem aktuellen Produkt hinzufügen</b>
						-->
					</td>
				</tr>

				<tr class="optionValue">
					<td width="60" align="center" valign="top">
						<img'. str_replace("#","arrow",$image_data) .' />
					</td>
					<td valign="top" width="41%">
						'.
						olc_draw_pull_down_menu("optionValueDropDown",$optionValueDrop,$selectedOptionValue) .
						'
						<br/><br/>&nbsp;&nbsp;
						<input'. str_replace("#","add_new",$image_data).'
						onclick="javascript:return amAddOptionValue();" title="Fügt der Liste einen neuen Optionswert hinzu" />
						&nbsp;&nbsp;<b>Neuen Optionswert definieren</b>
						<!--<input'. str_replace("#","delete",$image_data).'
						onclick="javascript:return deleteOptionValue();" title="Löscht den Options-Wert aus der Datenbank" />-->
					</td>
					<td width="15%" valign="top">
						Preis: '. drawDropDownPrefix($prefix_0_id) . olc_draw_input_field("newPrice","",$newPrice_id) . '
					</td>
					<td width="41%" valign="top">
						<input'. str_replace("#","add_up",$image_data).' value="Add"
						onclick="javascript:return amAddAttributeToProduct();" title="Das Attribut dem aktuellen Produkt hinzufügen" border="0"  />
						&nbsp;&nbsp;<b>Das Attribut dem aktuellen Produkt hinzufügen</b>
					</td>
				</tr>
			</table>
		</div>
		<br/>
	</div>
';

require_once(DIR_FS_INC.'olc_ajax_prepare_special_html_chars.inc.php');
$html_text="#am#".$html_text;		//Signal attributemanager message
echo olc_ajax_prepare_special_html_chars($html_text);
?>
