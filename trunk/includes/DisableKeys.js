/*
-----------------------------------------------------------------------------------------
id: DisableKeys.js.php,v 1.0 2006/06/20  $

OL-Commerce Version 4.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

AJAX=Asynchronous JavaScript And XML
Info: http://de.wikipedia.org/wiki/Ajax_(Programmierung)

Key-Disabling routine

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de), w.kaiser@fortune.de

Released under the GNU General Public License
---------------------------------------------------------------------------------------
*/

// ============= DisableKeys.js =============//

// Keys to be disabled can be added to the lists below.
// The number is the key code for the particular key
// and the text is the description displayed in the
// status window if the key [combination] is pressed.

var badKeys = new Object();
badKeys.single = new Object();
badKeys.single['8'] = 'Backspace ausserhalb von Textfeldern';
badKeys.single['13'] = 'Return ausserhalb von Textfeldern';
badKeys.single['116'] = 'F5 (Neu laden)';
badKeys.single['122'] = 'F11 (Voller Bildschirm)';

badKeys.alt = new Object();
badKeys.alt['37'] = 'Alt+Linker Pfeil';
badKeys.alt['39'] = 'Alt+Rechter Pfeil';

badKeys.ctrl = new Object();
badKeys.ctrl['37'] = 'Strg+Linker Pfeil';
badKeys.ctrl['39'] = 'Strg+Rechter Pfeil';
badKeys.ctrl['78'] = 'Strg+N';
badKeys.ctrl['79'] = 'Strg+O';
badKeys.ctrl['82'] = 'Strg+R';

function checkKeyCode(type, code)
{
	if (badKeys[type][code])
	{
		return true;
	} else {
		return false;
	}
}

function getKeyText(type, code)
{
	return badKeys[type][code];
}

var ie=document.all;
var w3c=document.getElementById&&!ie;
var badKeyType,target_type,targtype;
var badKeyType_ctrl = 'ctrl',badKeyType_alt = 'alt',badKeyType_single = 'single',empty_text='';
var target_type_text = 'text',target_type_password = 'password',target_type_textarea = 'textarea';
var text_target_types=target_type_text+target_type_textarea+target_type_password;

function keyEventHandler(evt)
{
	this.target = evt.target || evt.srcElement;
	this.keyCode = evt.keyCode || evt.which;
	targtype = this.target.type;
	if (w3c)
	{
		if (document.layers)
		{
			this.altKey = ((evt.modifiers & Event.ALT_MASK) > 0);
			this.ctrlKey = ((evt.modifiers & Event.CONTROL_MASK) > 0);
			this.shiftKey = ((evt.modifiers & Event.SHIFT_MASK) > 0);
		} else {
			this.altKey = evt.altKey;
			this.ctrlKey = evt.ctrlKey;
			this.shiftKey =  evt.shiftKey;
		}
	// Internet Explorer
	}
	else
	{
		this.altKey = evt.altKey;
		this.ctrlKey = evt.ctrlKey;
		this.shiftKey =  evt.shiftKey;
	}
	// Find out if we need to disable this key combination
	if (this.ctrlKey)
	{
		badKeyType = badKeyType_ctrl;
	}
	else if (this.altKey)
	{
		badKeyType = badKeyType_alt;
	}
	else
	{
		badKeyType = badKeyType_single;
	}

	if (checkKeyCode(badKeyType, this.keyCode))
	{
		return cancelKey(evt, this.keyCode, this.target, getKeyText(badKeyType, this.keyCode));
	}
}

function cancelKey(evt, keyCode, target, keyText)
{
	//keyCode==6 is Backspace for Mac
	if (keyCode==6 || keyCode==8 || keyCode==13)
	{
		// Don't want to disable Backspace or Enter in text fields
		/*
		target_type=target.type;
		if (target_type == target_type_text || target_type == target_type_textarea ||
			target_type==target_type_password)
		*/
		if (text_target_types.indexOf(target.type)!=-1)
		{
			window.status = empty_text;
			return true;
		}
	}
	if (evt.preventDefault)
	{
		evt.preventDefault();
		evt.stopPropagation();
	}
	else
	{
		evt.keyCode = 0;
		evt.returnValue = false;
	}
	window.status = keyText+' ist nicht zulässig';
	return false;
}

function addEvent(obj, evType, fn, useCapture)
{
	// General function for adding an event listener
	if (obj.addEventListener)
	{
		obj.addEventListener(evType, fn, useCapture);
		return true;
	}
	else if (obj.attachEvent)
	{
		var r = obj.attachEvent("on" + evType, fn);
		return r;
	}
	else
	{
		alert(evType+" handler konnte nicht initialisiert werden");
	}
}

function addKeyEvent()
{
	// Specific function for this particular browser
	/*
	var e = (document.addEventListener) ? "keypress" : "keydown";
	addEvent(document,e,keyEventHandler,false);
	*/
	addEvent(document,"keydown",keyEventHandler,false);
}
