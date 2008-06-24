var placeHolderDiv;
var attributemanager_text='attributemanager';
var url=attributemanager_text+'/'+attributemanager_text+'.php';
var debug=false;
var new_option_name_required="Sie müssen zuerst die neue Attribut-Bezeichnung festlegen!";

var OpenClosedState=new Object();
var attributeManagerOpenClosedState_initted=false;
var attributeManagerOpenClosedState=true;
var newAttributeClosedState=true;

var style_display,openClosedState_value,icon,control,id,options;
var attributeManager_icon_lead=attributemanager_text+"/images/icon_";
var icon_minus="minus.gif",icon_plus="plus.gif";
var trOptionsValues_text="trOptionsValues_";
var all_trOptionsValues_text="all_"+trOptionsValues_text;
var show_hide_text="show_hide_";
var option_controls_text="option_controls_";
var products_id_text='products_id=';
var pageAction_text='pageAction=';
var optionDropDown_text='optionDropDown';
var optionValueDropDown_text='optionValueDropDown';
var currentAttributes_text="currentAttributes",showHideAll_text="showHideAll";
var newAttribute_text="newAttribute",showHideNewAttribute_text="showHideNewAttribute";
var style_hide="none",style_show="inline";

var option,optionName,optionId,response,selected_index,price,prefix,empty_option="----";
var option_id,option_value_id,prefix;

function attributeManagerInit() {
	placeHolderDiv=$(attributemanager_text);
	if (placeHolderDiv)
	{
		amRefresh();
	}
	else
	{
		setTimeout("attributeManagerInit()",500);
	}
}

//------------------------------------------------------------------<< Common Stuff

function amSendRequest(requestString, functionName, refresh)
{
	var arRequestString=new Array;

	if('' != requestString)
		arRequestString.push(requestString);

	if('' != productsId)
		arRequestString.push(products_id_text+productsId);

	if('' != pageAction)
		arRequestString.push(pageAction_text+pageAction);

	if('' != sessionId)
		arRequestString.push(sessionId);

	requestString=arRequestString.join('&');

	functionName=(((null == functionName) || ('' == functionName)) ? amUpdateContent : functionName);

	make_AJAX_Request(url,false,requestString,ajax_get,refresh);

}

function amReportError(request) {
	alert('Es ist ein Fehler aufgetreten');
}

function amRefresh() {
	amSendRequest('amAction=refresh');
	return false;
}

function amUpdateContent() {
	placeHolderDiv.innerHTML=data_returned;
	if (!attributeManagerOpenClosedState_initted)
	{
		attributeManagerOpenClosedState_initted=true;
		if ($(currentAttributes_text))
		{
			attributeManagerOpenClosedState=$(currentAttributes_text).style.display==style_show;
		}
		amGetAttributesState();
	}
	amRestoreDisplayState();
}

//------------------------------------------------------------------<< Actions

function amUpdate(optionId, optionValueId) {
	price=$F('price_'+optionValueId);
	prefix=$F('prefix_'+optionValueId);
	amSendRequest('amAction=update&option_id='+optionId+'&option_value_id='+optionValueId+
		'&price='+price+'&prefix='+prefix,'',false);
	return false;
}

function amAddOption() {
	response=prompt("Bitte geben Sie die neue Attribut-Bezeichnung ein",'');
	if(null == response) return false;
	if('' == response) addOption();
	else amSendRequest('amAction=addOption&option_name='+response);
	return false;
}

function amAddOptionValue(){
	option=$(optionDropDown_text);
	with (option)
	{
		selected_index=selectedIndex;
		optionName=options[selected_index].text;
		if (selected_index==0 && (optionName==empty_option))
		{
			alert(new_option_name_required);
			focus();
		}
		else
		{
			optionId=$F(option)
			response=prompt("Bitte geben Sie den Optionswert ein, der zur Attribut-Bezeichnung '"+
				optionName+"' hinzugefügt werden soll",'');

			if(null == response) return false;
			if('' == response) amAddOptionValue();
			else amSendRequest('amAction=addOptionValue&option_value_name='+response+'&option_id='+optionId);
		}
	}
	return false;
}

function amAddAttributeToProduct()
{
	option=$(optionDropDown_text);
	with (option)
	{
		selected_index=selectedIndex;
		if (selected_index==0 && (options[selected_index].text==empty_option))
		{
			alert(new_option_name_required);
			focus();
		}
		else
		{
			control=$(optionValueDropDown_text);
			with (control)
			{
				selected_index=selectedIndex;
				if (selected_index==0 && (options[selected_index].text==empty_option))
				{
					alert("Sie müssen zuerst den neuen Optionswertes festlegen!");
					focus();
				}
				else
				{
					option_id=$F(optionDropDown_text);
					option_value_id=$F(optionValueDropDown_text);
					prefix=$F('prefix_0');
					amSendRequest('amAction=addAttributeToProduct&option_id='+option_id+
					'&option_value_id='+option_value_id+'&prefix='+prefix+'&price='+$F('newPrice'));
				}
			}
		}
	}
	return false;
}

function amRemoveOptionFromProduct(optionId,optionName,numChildren) {
	if(confirm('Sind Sie sicher, dass Sie die Option \''+optionName+'\' und den(die) '+numChildren+
		' zugehörigen Optionswert(e) von diesem Produkt löschen wollen?')) {
		amSendRequest('amAction=removeOptionFromProduct&option_id='+optionId);
	}
	return false;
}

function amRemoveOptionValueFromProduct(optionId,optionValueId, optionName,optionValueName) {
	if(confirm('Sind Sie sicher, dass Sie den Optionswert \''+optionValueName+
		'\' von der Option \''+optionName+' \'löschen wollen?')) {
		amSendRequest('amAction=removeOptionValueFromProduct&option_id='+optionId+'&option_value_id='+optionValueId);
	}
	return false;
}

function amAddOptionValueToProduct(optionId) {
	var optionValueId=$F('new_option_value_'+optionId);
	if(0 == optionValueId)
		return false;
	amSendRequest('amAction=addOptionValueToProduct&option_id='+optionId+'&option_value_id='+optionValueId);
	return false;
}
function amAddNewOptionValueToProduct(optionId, optionName) {
	var response=prompt("Bitte geben Sie den Namen des Options-Wertes ein, der zu "+optionName+" hinzugefügt werden soll",'');
	if(null == response) return false;
	if('' == response) amAddNewOptionValueToProduct(optionId, optionName);
	else amSendRequest('amAction=addNewOptionValueToProduct&option_value_name='+response+'&option_id='+optionId);
	return false;
}

function amUpdateNewOptionValue(optionId) {
	amSendRequest('amAction=updateNewOptionValue&option_id='+optionId)
}

//------------------------------------------------------------------<< Display Controls

function amRestoreDisplayState() {

	// new attribute
	amShowHideNewAttribute(false);
	for (id in OpenClosedState)
	{
		amShowHideOptionsValues(id,false);
	}
}

function get_display_style(ClosedState)
{
	return (ClosedState) ? style_show : style_hide;
}

function get_icon(ClosedState)
{
	return attributeManager_icon_lead+((ClosedState) ? icon_minus : icon_plus);
}

function amShowHideAttributeManager() {
	attributeManagerOpenClosedState=!attributeManagerOpenClosedState;
	$(currentAttributes_text).style.display=get_display_style(attributeManagerOpenClosedState) ;
	with ($(showHideAll_text))
	{
		src=get_icon(attributeManagerOpenClosedState);
		focus();
	}
	return false;
}

function amShowHideNewAttribute(newAttributeClosedState_set)
{
	control=$(newAttribute_text);
	if (control)
	{
		if ((newAttributeClosedState_set==null)?true:newAttributeClosedState_set)
		{
			newAttributeClosedState=!newAttributeClosedState;
		}
		control.style.display=get_display_style(newAttributeClosedState);
		$(showHideNewAttribute_text).src=get_icon(newAttributeClosedState);
	}
	return false;
}

function amShowHideAllOptionValues(options, show) {
	for (var i =0; i < options.length; i++) {
		id=options[i];
		OpenClosedState[id]=show;
		amShowHideOptionsValues(id,false);
	}
	return false;
}

function amShowHideOptionsValues(id,openClosedState_set)
{
	if ((openClosedState_set==null)?true:openClosedState_set)
	{
		OpenClosedState[id]=!OpenClosedState[id];
	}
	openClosedState_value=OpenClosedState[id];
	$(show_hide_text+id).src=get_icon(openClosedState_value);
	style_display=get_display_style(openClosedState_value);
	$(option_controls_text+id).style.display=style_display;
	$(all_trOptionsValues_text+id).style.display=style_display;
	return false;
}

function amGetAttributesState()
{
	options=$('attributes_available');
	if (options!=null)
	{
		options=options.innerHTML.split(",");
		for (i=0;i<options.length; i++)
		{
			id=options[i];
			OpenClosedState[id]=$(all_trOptionsValues_text+id).style.display==style_show;
		}
	}
	return false;
}
