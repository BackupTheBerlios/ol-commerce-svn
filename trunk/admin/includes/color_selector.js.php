/*
color_selector.js.php
*/

var color,color_table_visible=false,style_display;

function set_title(obj)
{
	with (obj)
	{
		title=innerText;
	}
}

function show_hide_color_table()
{
	if (color_table_visible)
	{
		style_display="none";
	}
	else
	{
		style_display="inline";
	}
	color_table_visible=!color_table_visible;
	document.getElementById("color_table").style.display=style_display;
}

function set_color(color)
{
	with (document)
	{
		getElementById("color_field").value=color;
		with (getElementById("color_cell"))
		{
			bgColor=color;
			title=color;
		}
	}
}

function get_color(obj)
{
	with (obj)
	{
		value=innerText;
		bg_color=bgColor;
	}
	set_color(value,bg_color,color);
}
