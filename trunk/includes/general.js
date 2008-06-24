/* -----------------------------------------------------------------------------------------
$Id: general.js,v 1.1.1.1 2006/12/22 13:42:13 gswkaiser Exp $

OL-Commerce Version 1.0
http://www.ol-commerce.com

Copyright (c) 2004 OL-Commerce
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.js,v 1.3 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (general.js,v 1.3 2003/08/13); www.nextcommerce.org

Released under the GNU General Public License
---------------------------------------------------------------------------------------

W. Kaiser - AJAX (Nothing to do with AJAX, just a reminder to copy!!)

*/
function SetFocus(TargetFormName)
{
	var target = 0,my_type;

	with (document)
	{
		if (TargetFormName != "")
		{
			for (i=0; i<forms.length; i++) {
				if (forms[i].name == TargetFormName)
				{
					target = i;
					break;
				}
			}
		}
		var TargetForm = forms[target];
	}

	for (i=0; i<TargetForm.length; i++) {
		with (TargetForm.elements[i])
		{
			my_type=type;
			if (
			(my_type != "image") &&
			(my_type != "hidden") &&
			(my_type != "reset") &&
			(my_type != "submit"))
			{
				focus();
				if (
				(my_type == "text") ||
				(my_type == "password"))
				{
					select();
				}
				break;
			}
		}
	}
}

function RemoveFormatString(TargetElement, FormatString) {
	if (TargetElement.value == FormatString) {
		TargetElement.value = "";
	}

	TargetElement.select();
}

function CheckDateRange(from, to) {
	if (Date.parse(from.value) <= Date.parse(to.value)) {
		return true;
	} else {
		return false;
	}
}

function IsValidDate(DateToCheck, FormatString) {
	if (DateToCheck.length != FormatString.length) {
		return false;
	}
	var strDateToCheck;
	var strDateToCheckArray;
	var strFormatArray;
	var strFormatString;
	var strDay;
	var strMonth;
	var strYear;
	var strDayFormat;
	var strMonthFormat;
	var strYearFormat;
	var intday;
	var intMonth;
	var intYear;
	var intDateSeparatorIdx = -1;
	var intFormatSeparatorIdx = -1;
	var strSeparatorArray = new Array("-"," ","/",".");
	var strMonthArray = new Array("jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec");
	var intDaysArray = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

	strDateToCheck = DateToCheck.toLowerCase();
	strFormatString = FormatString.toLowerCase();

	for (i=0; i<strSeparatorArray.length; i++) {
		if (strFormatString.indexOf(strSeparatorArray[i]) != -1) {
			intFormatSeparatorIdx = i;
		}
		if (strDateToCheck.indexOf(strSeparatorArray[i]) != -1) {
			intDateSeparatorIdx = i;
		}
	}
	if (intDateSeparatorIdx != intFormatSeparatorIdx) {
		return false;
	}
	if (intDateSeparatorIdx != -1) {
		strFormatArray = strFormatString.split(strSeparatorArray[intFormatSeparatorIdx]);
		if (strFormatArray.length != 3)
		{
			return false;
		}
		strDateToCheckArray = strDateToCheck.split(strSeparatorArray[intDateSeparatorIdx]);
		if (strDateToCheckArray.length != 3)
		{
			return false;
		}
		var strFormat;
		for (i=0; i<strFormatArray.length; i++) {
			strFormat=strFormatArray[i];
			if (strFormat == "mm" || strFormat == "mmm") {
				strMonth = strDateToCheckArray[i];
				strMonthFormat=strFormat;
			}
			if (strFormat == "dd" || strFormat == "tt") {
				strDay = strDateToCheckArray[i];
				strDayFormat=strFormat;
			}
			if (strFormat == "yyyy" || strFormat == "jjjj" || strFormat == "yy" || strFormat == "jj")
			{
				strYear = strDateToCheckArray[i];
				strYearFormat=strFormat;
			}
		}
	} else {
		if (FormatString.length >= 8)
		{
			strMonth = strDateToCheck.substring(strFormatString.indexOf(strMonthFormat),strMonthFormat.length);
			strDay = strDateToCheck.substring(strFormatString.indexOf(strDayFormat),2);
			strYear = strDateToCheck.substring(strFormatString.indexOf(strYearFormat),strYearFormat.length);
		} else {
			return false;
		}
	}
	if (strYear.length != 4)
	{
		strYear="20"+strYear;
	}
	intday = parseInt(strDay, 10);
	if (isNaN(intday))
	{
		return false;
	}
	else if (intday < 1)
	{
		return false;
	}
	intMonth = parseInt(strMonth, 10);
	if (isNaN(intMonth)) {
		for (i=0; i<strMonthArray.length; i++) {
			if (strMonth == strMonthArray[i]) {
				intMonth = i+1;
				break;
			}
		}
		if (isNaN(intMonth)) {
			return false;
		}
	}
	if (intMonth > 12 || intMonth < 1) {
		return false;
	}
	intYear = parseInt(strYear, 10);
	if (isNaN(intYear)) {
		return false;
	}
	if (IsLeapYear(intYear) == true) {
		intDaysArray[1] = 29;
	}
	if (intday > intDaysArray[intMonth - 1]) {
		return false;
	}
	return true;
}

function IsLeapYear(intYear) {
	if (intYear % 100 == 0)
	{
		if (intYear % 400 != 0)
		{
			return true;
		}
	} else {
		if ((intYear % 4) == 0) {
			return true;
		}
	}
	return false;
}
