<?php
if ($css_dynamic_menu)
{
	$call_parameter_set=HTML_AMP.'action=edit'.HTML_AMP;
	$call_parameter_gid=$call_parameter_set.'cID=';
	$gid_text_len=strlen($gid_text);
	$call_parameter_set=$call_parameter_set.'module=';
	$set_text_len=strlen($set_text);

	if (!defined('USE_PAYPAL_IPN'))
	{
		define('USE_PAYPAL_IPN',IS_LOCAL_HOST);
	}
	if (!defined('USE_PAYPAL_WPP'))
	{
		define('USE_PAYPAL_WPP',IS_LOCAL_HOST);
	}

	$configuration_group_title_text='configuration_group_title';
	$lang=SLASH.SESSION_LANGUAGE.SLASH;
	$lang=ADMIN_PATH_PREFIX.'lang'.$lang.'admin'.SLASH;
	include($lang.'configuration.php');
	$module_language_directory0=DIR_FS_LANGUAGES . SESSION_LANGUAGE . '/modules/';
	include($lang.'modules.php');

	$sub_menu_start_lm='
				';
	$sub_menu_start=$sub_menu_start_lm.'<ul>';
	$sub_menu_end='
				</ul>
			'.$li_end;
	$sub_menu_line_module0=
	str_replace($link_text,FILENAME_MODULES,$sub_menu_line_configuration00);

	$cfg_title_sql0=SELECT.$configuration_group_title_text.SQL_FROM . TABLE_CONFIGURATION_GROUP .
	SQL_WHERE."configuration_group_id = '" . HASH . APOS;
	$select=SELECT."configuration_key,";
	$from=SQL_FROM. TABLE_CONFIGURATION.SQL_WHERE;

	$cfg_sql0=$select."configuration_id, configuration_value".$from.
	"configuration_group_id = '#' order by sort_order";
	/*
	$table_lines.='
	</ul>
	</li>
	</ul>
	<h2>'.BOX_HEADING_CONFIGURATION.'</h2>
	<ul>';
	*/
	$table_lines.='
	<h2>'.BOX_HEADING_CONFIGURATION.'</h2>
	<ul>';
	$menu_line_start=$menu_line_start_first;
}
else
{
	$table_lines =
	'
		<!-- right_navigation bof //-->
';
}
$menu_line_start=$menu_line_start_first;
set_top_level_menu(BOX_HEADING_SYSTEM);
$menu_line_start=$menu_line_start_next;
if ($admin_access['configuration'])
{
	if (IS_LOCAL_HOST)
	{
		$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'1') .
		CLASS_menuBoxContentLink . BOX_CONFIGURATION_1 . $sub_menu_line_end;
		$table_lines.=create_config_menu($R_Content);
	}
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'100') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_100 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'12') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_12 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	if (USE_LAYOUT_DEFINITION==TRUE_STRING_S)
	{
		if (IS_IE)
		{
			$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_BOX_CONFIGURATION) .
			CLASS_menuBoxContentLink_target . BOX_BOX_CONFIGURATION . $sub_menu_line_end;
		}
		else if ($not_css_menu)
		{
			$R_Content=BOX_BOX_CONFIGURATION . IE_ONLY;
		}
		$table_lines.=create_config_menu($R_Content);
	}
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'2') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_2 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'3') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_3 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	if (USE_PDF_INVOICE)
	{
		$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'787') .
		CLASS_menuBoxContentLink . BOX_PDF_INVOICE . $sub_menu_line_end;
		$table_lines.=create_config_menu($R_Content);
	}
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'800') .
	CLASS_menuBoxContentLink . BOX_PDF_DATASHEET . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);
	if (USE_EBAY)
	{
		$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'790') .
		CLASS_menuBoxContentLink . BOX_EBAY_CONNECTOR . $sub_menu_line_end;
		$table_lines.=create_config_menu($R_Content);
	}
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'4') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_4 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	if (USE_ADODB)
	{
		$R_Content=$sub_menu_line_start . olc_href_link('adodb_stats.php') .
		CLASS_menuBoxContentLink_target . BOX_ADODB_STATS . $sub_menu_line_end;
		$table_lines.=create_config_menu($R_Content);
	}
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'5') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_5 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'7') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_7 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'8') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_8 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'9') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_9 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'10') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_10 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'11') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_11 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'795') .
	CLASS_menuBoxContentLink . BOX_MENUES_TEMPLATES . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'14') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_14 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'15') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_15 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'16') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_16 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'17') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_17 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'19') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_18 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'20') .
	CLASS_menuBoxContentLink . BOX_CONFIGURATION_19 . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);
}
if ($admin_access['orders_status'])
{
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_ORDERS_STATUS) .
	CLASS_menuBoxContentLink . BOX_ORDERS_STATUS . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

}
if (ACTIVATE_SHIPPING_STATUS)
{
	if ($admin_access['shipping_status'])
	{
		$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_SHIPPING_STATUS) .
		CLASS_menuBoxContentLink . BOX_SHIPPING_STATUS . $sub_menu_line_end;
		$table_lines.=create_config_menu($R_Content);

	}
}
set_top_level_menu(BOX_HEADING_MODULES);
if ($admin_access['modules'])
{
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_MODULES, $set_text.'payment') .
	CLASS_menuBoxContentLink . BOX_PAYMENT . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_MODULES, $set_text.'shipping') .
	CLASS_menuBoxContentLink . BOX_SHIPPING . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_MODULES, $set_text.'order_total') .
	CLASS_menuBoxContentLink . BOX_ORDER_TOTAL . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

}
if ($admin_access['module_export'])
{
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_MODULE_EXPORT) .
	CLASS_menuBoxContentLink . BOX_MODULE_EXPORT . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

}
set_top_level_menu(BOX_HEADING_ZONE);
if ($admin_access['languages'])
{
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_LANGUAGES) .
	CLASS_menuBoxContentLink . BOX_LANGUAGES . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

}
if ($admin_access['countries'])
{
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_COUNTRIES) .
	CLASS_menuBoxContentLink . BOX_COUNTRIES . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

}
if ($admin_access['currencies'])
{
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_CURRENCIES) .
	CLASS_menuBoxContentLink . BOX_CURRENCIES . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

}
if ($admin_access['zones'])
{
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_ZONES) .
	CLASS_menuBoxContentLink . BOX_ZONES . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

}
if ($admin_access['geo_zones'])
{
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_GEO_ZONES) .
	CLASS_menuBoxContentLink . BOX_GEO_ZONES . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

}
if ($admin_access['tax_classes'])
{
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_TAX_CLASSES) .
	CLASS_menuBoxContentLink . BOX_TAX_CLASSES . $sub_menu_line_end;

	$table_lines.=create_config_menu($R_Content);

}
if ($admin_access['tax_rates'])
{
	$R_Content=$sub_menu_line_start . olc_href_link(FILENAME_TAX_RATES) .
	CLASS_menuBoxContentLink . BOX_TAX_RATES . $sub_menu_line_end;
	$table_lines.=create_config_menu($R_Content);

}
if ($css_menu)
{
	if (USE_CSS_DYNAMIC_ADMIN_MENU)
	{
		$table_lines.='
			</ul>
		</li>
	</ul>
';
	}
}
else
{
	$table_lines.=
	'
			<!-- right_navigation eof //-->
';
	$R_Content=str_replace(ATSIGN,$table_lines,$table);
	if (USE_AJAX)
	{
		$smarty->assign($smarty_box,$R_Content);
	}
}
?>