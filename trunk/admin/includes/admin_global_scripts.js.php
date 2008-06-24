<?php
/*
admin_global_scripts.js.php
*/
echo '
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

function set_color_selector_color(color)
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
	set_color_selector_color(value,bg_color,color);
}

var products_vpe_status_checked, products_baseprice_show_checked,my_object,my_value,vpe_selected;
var products_min_order_checked,base_price_selected;

function check_product_form(have_vpe)
{
	if (have_vpe)
	{
		if (!products_vpe_status_checked)
		{
			my_object=document.getElementById("products_vpe_status");
			vpe_selected=my_object.checked;
			if (vpe_selected)
			{
				my_object=document.getElementById("products_vpe_value");
				my_value=trim(my_object.value);
				if (parseFloat(my_value)==0)
				{
					alert("Sie haben einen unzulässigen Wert für die Verpackungseinheit gewählt!\n\nDieser muss größer als Null sein!")
					my_object.focus();
					return false;
				}
				else
				{
					vpe_selected=my_value.substr(0,1)!="1";
				}
			}
			else
			{
				if (!confirm("Sie haben keine Anzeige der Verpackungseinheit gewählt.\n\nIst das so OK?"))
				{
					my_object.focus();
					return false;
				}
			}
			//products_vpe_status_checked=true;
		}
		if (vpe_selected)
		{
			if (!products_baseprice_show_checked)
			{
				my_object=document.getElementById("products_baseprice_show");
				if (my_object.checked)
				{
					base_price_selected=true;
					products_baseprice_show_checked=true;
				}
				else
				{
					if (!confirm("Sie haben keinen Grundpreis gewählt, obwohl die Verpackungseinheit den unüblichen Wert \""+my_value+"\" hat.\n\nIst das trotzdem OK?"))
					{
						my_object.focus();
						return false;
					}
					products_baseprice_show_checked=true;
				}
			}
			if (products_baseprice_show_checked)
			{
				if (!products_min_order_checked)
				{
					my_object=document.getElementById("products_min_order_quantity");
					if (trim(my_object.value)!="")
					{
						my_object=document.getElementById("products_min_order_vpe");
						if (my_object.selectedIndex==0)
						{
							alert("Sie müssen eine Auswahl für die \"VPE der Mindestabnahme\" treffen!");
							my_object.focus();
							return false;
						}
						else
						{
							products_min_order_checked=true;
						}
					}
				}
			}
		}
	}
	products_vpe_status_checked=false;
	products_baseprice_show_checked=false;
	products_min_order_checked=false;
	vpe_selected=false;
	base_price_selected=false;
	return true;
}

function check_group_checkboxes(obj_checkbox,index)
{
	current_element=document.getElementsByName(obj_checkbox.name);
	if (obj_checkbox.checked)
	{
		current_elements=current_element.length;
		if (index==0)
		{
			for (i=1;i<current_elements;i++)
			{
				current_element[i].checked=true;
			}
		}
		else
		{
			condition=true;
			for (i=1;i<current_elements;i++)
			{
				if (!current_element[i].checked)
				{
					condition=false;
					break;
				}
			}
			if (condition)
			{
				current_element[0].checked=true;
			}
		}
	}
	else
	{
		if (index!=0)
		{
			current_element[0].checked=false;
		}
	}
}

function trim(str)
{
   return str.replace(/^\s*|\s*$/g,"");
}
';
?>