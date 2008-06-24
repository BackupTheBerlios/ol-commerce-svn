/* --------------------------------------------------------------
$Id: general.js,v 1.1.1.1.2.1 2007/04/08 07:16:38 gswkaiser Exp $

OL-Commerce Version 1.0
http://www.ol-commerce.com

Copyright (c) 2004 OL-Commerce
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(general.js,v 1.2 2001/05/20); www.oscommerce.com
(c) 2003	    nextcommerce (general.js,v 1.4 2003/08/13); www.nextcommerce.org

Released under the GNU General Public License
--------------------------------------------------------------

W. Kaiser - AJAX (Nothing to do with AJAX, just a reminder to copy!!)

*/

function toggleBox(szDivID)
{
	var obj = document.getElementById(szDivID);
	with (obj.style)
	{
		if (visibility == 'visible')
		{
			visibility = "hidden";
			display = "none";
		}
		else
		{
			visibility = "visible";
			display = "inline";
		}
	}
}

function SetFocus()
{
	if (document.forms.length > 0)
	{
		var form = document.forms[0],my_type;
		for (i=0; i<form.length; i++)
		{
			with (form.elements[i])
			{
				my_type=type;
				if ((my_type != "image") &&
				(my_type != "hidden") &&
				(my_type != "reset") &&
				(my_type != "submit") ) {

					form.elements[i].focus();

					if ((my_type == "text") || (my_type == "password")) select();

					break;
				}
			}
		}
	}
}

function popupWindow(url)
{
	ShowInfo(url, "");
}

function ShowInfo(url,text)
{
	var w_width = 800,w_heigth = 800;		//Standard window size
	var x_pos,y_pos;

	with (screen)
	{
		var screen_width=width;
		var screen_height=height;
	}
	if (url!="")
	{
		//Center window
		x_pos = (screen_width - w_width) / 2;
		y_pos = (screen_height - w_heigth) / 2;
		var win = window.open(url,"popupWindow","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,"+
			"resizable=no,copyhistory=no,width=" + w_width + ",height=" + w_heigth + ",top=" + y_pos + ",left=" + x_pos);
		if (text != "")
		{
			with (win.document)
			{
				open("text/html");
				write(text);
				close();
			}
		}
		win.focus();
		//return false;
	}
}