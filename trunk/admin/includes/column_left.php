<?php
/* --------------------------------------------------------------
$Id: column_left.php,v 1.1.1.1.2.1 2007/04/08 07:16:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project (earlier name of osCommerce)
(c) 2002-2003 osCommerce(column_left.php,v 1.15 2002/01/11); www.oscommerce.com
(c) 2003	    nextcommerce (column_left.php,v 1.25 2003/08/19); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/
if (NOT_IS_AJAX_PROCESSING)
{
	$gid_text='gID=';
	$set_text='set=';
	$c='CLASS_menuBoxContentLink';
	$table_lines=EMPTY_STRING;
	$css_dynamic_menu = $css_menu && USE_CSS_DYNAMIC_ADMIN_MENU;

	$css_dynamic_menu_or_use_cool_menu=$css_dynamic_menu || USE_COOL_ADMIN_MENU;
	if ($css_dynamic_menu_or_use_cool_menu)
	{
		$h2='<h2>';
		$par_text='#par#';
		$desc_text='#desc#';
		$title_text='#title#';
		$link_text00='#link#';
		$b_start_text='<B>';
		$b_end_text='</B>';
		$id_text='id';
		$text_text='text';
		$title_text='title';
		$link_text='link';
		$cfg_group_header='
	<h2>#</h2>
';
		$configuration_value_text='configuration_value';
		$sql_group=SELECT.$configuration_value_text.SQL_FROM . TABLE_CONFIGURATION .SQL_WHERE."configuration_key = '#'";
		$menu_gen=true;
		$li_end="</li>";
		if ($menu_done)
		{
			echo '			<!--Pseudo navigation bof//-->
			<tr>
				<td class="pseudo_columnLeft">&nbsp;
				</td>
			</tr>
			<!-- Pseudo navigation eof //-->';
			return;
		}
		else
		{
			if (USE_COOL_ADMIN_MENU)
			{
				$html_two_blanks=HTML_NBSP.HTML_NBSP;
				$html_four_blanks=$html_two_blanks.$html_two_blanks;
				$menu_entries=array();
			}
			else
			{
				if (true or IS_IE)
				{
					$class_x="\n\n";
				}
				else
				{
					$class_x=DOT.BLANK;
				}
				$tool_tip_span='<span>#</span>';
				$use_css_tool_tip=false;
				$actual_value_configuration_text=$class_x.ADMIN_CONFIG_ACTUAL_VALUE;
				$module_installed_text=$class_x.ADMIN_MODULE_INSTALLED;
				$big_html_br=strtoupper(HTML_BR);
				$class_x=' class="info x">';
				$sub_menu_line_start='
				<li><a class="info" href="';
				$sub_menu_line_end=HTML_A_END.$li_end;
				if (USE_CSS_ADMIN_MENU_H)
				{
					$menu_line_start_first='
									<li>
										<h2>';
					$menu_line_start_next='
				</ul>
			</li>
		</ul>
		<ul>';
				}
				else
				{
					$menu_line_start_first='
		<li>
			<a href="#"'.$class_x;
					$menu_line_start_next='
			</ul>
		</li>';
					$menu_line_end='</a>
			<ul>';
				}
				$menu_line_start=$menu_line_start_first;
				$menu_line_start_next.=$menu_line_start_first;
				$table='
<!-- navigation bof//-->
<div id="menu">
	@
			</ul>
		</li>
	</ul>
</div>
<!-- navigation eof //-->
';
				$table_line=ATSIGN;
				define($c,'">');
				define($c.'_target','" target="_blank'.CLASS_menuBoxContentLink);
			}
		}
		if (USE_COOL_ADMIN_MENU)
		{
			$id=0;
			include(DIR_WS_INCLUDES.'column_right_content.php');
		}
		else
		{
			$sub_menu_line_configuration00=
			str_replace(NEW_LINE,NEW_LINE."\t\t",$sub_menu_line_start) . olc_href_link($link_text0, $par_text) .
			'" title="'.$desc_text.	CLASS_menuBoxContentLink . $title_text . $sub_menu_line_end;
			$sub_menu_line_configuration0=
			str_replace($link_text0,FILENAME_CONFIGURATION,$sub_menu_line_configuration00);
		}
	}
	else
	{
		$menu_line_start_first='<tr><td colspan="2" class="menuBoxHeading"><b>';
		$menu_line_start=$menu_line_start_first;
		$menu_line_start_next='<tr><td style="height:6px"></td></tr>
'.$menu_line_start_first;
		$menu_line_end=HTML_B_END.HTML_BR.'</td></tr>
';
		$sub_menu_line_start='			'.HTML_A_START;
		$sub_menu_line_end=HTML_A_END.NEW_LINE;
		$table='
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<!-- menu-->
@
<!-- menu-->
</table>
';
		$table_line='
	<tr>
		<td>'.BULLET.'</td><td class="menuBoxContent" nowrap="nowrap">@'.HTML_BR.'</td>
	</tr>
';
		define($c,'" class="menuBoxContentLink">');
		define($c.'_target','" target="_blank'.CLASS_menuBoxContentLink);
	}
	$not_use_cool_menu=!USE_COOL_ADMIN_MENU;
	$admin_access_query = olc_db_query(SELECT_ALL . TABLE_ADMIN_ACCESS .
	SQL_WHERE."customers_id = '" . CUSTOMER_ID . APOS);
	$admin_access = olc_db_fetch_array($admin_access_query);
	if (LIMITED_ACCESS)
	{
		//Do not allow certain admin functions in multi-db mode!
		$limited_access_data=LIMITED_ACCESS_DATA;
		for ($i=0,$n=sizeof(LIMITED_ACCESS_DATA);$i<$n;$i++)
		{
			$admin_access[$limited_access_data[$i]]=false;
		}
	}
	if ($css_menu)
	{
		if (USE_CSS_DYNAMIC_ADMIN_MENU)
		{
			include(DIR_WS_INCLUDES.'column_right_content.php');
			$menu_line_start=$menu_line_start_first;
			$table_lines.=BLANK.HTML_BR.
			str_replace(HASH,BOX_HEADING_ADMIN,$cfg_group_header).'
		<ul>';
		}
	}
	set_top_level_menu(BOX_HEADING_CUSTOMERS);
	if ($css_menu)
	{
		if (USE_CSS_DYNAMIC_ADMIN_MENU)
		{
			$menu_line_start=$menu_line_start_next;
		}
	}
	else
	{
		$menu_line_start=$menu_line_start_next;
	}
	if ($admin_access['customers'])
	{
		$link = olc_href_link(FILENAME_CUSTOMERS);
		$Content = $sub_menu_line_start . $link .
		CLASS_menuBoxContentLink . BOX_CUSTOMERS . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['customers_status'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_CUSTOMERS_STATUS) .
		CLASS_menuBoxContentLink . BOX_CUSTOMERS_STATUS . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['orders'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_ORDERS) .
		CLASS_menuBoxContentLink . BOX_ORDERS . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
		//W. Kaiser orders statistics
		$Content = $sub_menu_line_start . olc_href_link('orders_statistics.php') .
		CLASS_menuBoxContentLink . BOX_ORDERS_STATISTISCS . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
		//W. Kaiser orders statistics
		//W. Kaiser PayPal IPN
		if (USE_PAYPAL_IPN)
		{
			if ($admin_access['paypal_ipn'])
			{
				$Content = $sub_menu_line_start . olc_href_link(FILENAME_PAYPAL_IPN) .
				CLASS_menuBoxContentLink . BOX_PAYPAL_IPN . $sub_menu_line_end;
				$table_lines.=create_config_menu($Content);
			}
		}
		//W. Kaiser PayPal IPN
	}
	set_top_level_menu(BOX_HEADING_PRODUCTS);
	if ($admin_access['categories'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_CATEGORIES) .
		CLASS_menuBoxContentLink . BOX_CATEGORIES . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['new_attributes'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_NEW_ATTRIBUTES) .
		CLASS_menuBoxContentLink . BOX_ATTRIBUTES_MANAGER . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['products_attributes'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_PRODUCTS_ATTRIBUTES) .
		CLASS_menuBoxContentLink . BOX_PRODUCTS_ATTRIBUTES . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['manufacturers'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_MANUFACTURERS) .
		CLASS_menuBoxContentLink . BOX_MANUFACTURERS . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['reviews'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_REVIEWS) .
		CLASS_menuBoxContentLink . BOX_REVIEWS . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['specials'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_SPECIALS) .
		CLASS_menuBoxContentLink . BOX_SPECIALS . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['products_expected'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_PRODUCTS_EXPECTED) .
		CLASS_menuBoxContentLink . BOX_PRODUCTS_EXPECTED . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	$allow=true;
	$not_master_admin=CUSTOMER_ID<>1;
	if (USE_EBAY)
	{
		if ($not_master_admin)
		{
			$allow=$admin_access['ebay'];
		}
		if ($allow)
		{
			set_top_level_menu(BOX_EBAY_AUCTIONS);
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_AUCTIONS_LIST_SOLD) .
			CLASS_menuBoxContentLink . BOX_AUCTIONS_LIST_SOLD . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_AUCTIONS_LIST_ORDER) .
			CLASS_menuBoxContentLink . BOX_AUCTIONS_LIST_ORDER . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_AUCTIONS_LIST_NOT_SOLD) .
			CLASS_menuBoxContentLink . BOX_AUCTIONS_LIST_NOT_SOLD . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_AUCTIONS_LIST_RUNNING) .
			CLASS_menuBoxContentLink . BOX_AUCTIONS_LIST_RUNNING . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_AUCTIONS_LIST_PLAN) .
			CLASS_menuBoxContentLink . BOX_REVIEWS . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_AUCTIONS_NEW) .
			CLASS_menuBoxContentLink . BOX_AUCTIONS_LIST_NEW . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_AUCTIONS_PREDEFINED) .
			CLASS_menuBoxContentLink . BOX_AUCTIONS_LIST_PREDEFINED . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
		}
	}
	if (ACTIVATE_GIFT_SYSTEM==TRUE_STRING_S)
	{
		set_top_level_menu(BOX_HEADING_GV_ADMIN);
		if ($admin_access['coupon_admin'])
		{
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_COUPON_ADMIN) .
			CLASS_menuBoxContentLink . BOX_COUPON_ADMIN . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
		}
		if ($admin_access['gv_queue'])
		{
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_GV_QUEUE) .
			CLASS_menuBoxContentLink . BOX_GV_ADMIN_QUEUE . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
		}
		if ($admin_access['gv_mail'])
		{
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_GV_MAIL) .
			CLASS_menuBoxContentLink . BOX_GV_ADMIN_MAIL . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
		}
		if ($admin_access['gv_sent'])
		{
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_GV_SENT) .
			CLASS_menuBoxContentLink . BOX_GV_ADMIN_SENT . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
		}
	}
	set_top_level_menu(BOX_HEADING_STATISTICS);
	if ($admin_access['stats_products_viewed'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_STATS_PRODUCTS_VIEWED) .
		CLASS_menuBoxContentLink . BOX_PRODUCTS_VIEWED . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['stats_products_purchased'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_STATS_PRODUCTS_PURCHASED) .
		CLASS_menuBoxContentLink . BOX_PRODUCTS_PURCHASED . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['stats_customers'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_STATS_CUSTOMERS) .
		CLASS_menuBoxContentLink . BOX_STATS_CUSTOMERS . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['stats_sales_report'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_SALES_REPORT) .
		CLASS_menuBoxContentLink . BOX_SALES_REPORT . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	set_top_level_menu(BOX_HEADING_TOOLS);
	if ($admin_access['module_newsletter'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_MODULE_NEWSLETTER) .
		CLASS_menuBoxContentLink . BOX_MODULE_NEWSLETTER . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['content_manager'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_CONTENT_MANAGER) .
		CLASS_menuBoxContentLink . BOX_CONTENT_TEXT . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}

	if ($admin_access['blacklist'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_BLACKLIST) .
		CLASS_menuBoxContentLink . BOX_TOOLS_BLACKLIST . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['backup'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_BACKUP) .
		CLASS_menuBoxContentLink . BOX_BACKUP . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['banner_manager'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_BANNER_MANAGER) .
		CLASS_menuBoxContentLink . BOX_BANNER_MANAGER . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['server_info'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_SERVER_INFO) .
		CLASS_menuBoxContentLink . BOX_SERVER_INFO . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	if ($admin_access['whos_online'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_WHOS_ONLINE) .
		CLASS_menuBoxContentLink . BOX_WHOS_ONLINE . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
		$params='p=true';
		if ($_SESSION['ajax'])
		{
			$params.=HTML_AMP.AJAX_ID;
		}
		if (IS_LOCAL_HOST)
		{
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_WHOS_ONLINE_LIVE,$params) .
			CLASS_menuBoxContentLink_target . BOX_WHOS_ONLINE_LIVE . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
			if (LIVE_HELP_ACTIVE===true)
			{
				$Content = $sub_menu_line_start . olc_href_link(FILENAME_LIVE_HELP,'m=t') .
				CLASS_menuBoxContentLink_target . BOX_LIVE_HELP . $sub_menu_line_end;
				$table_lines.=create_config_menu($Content);
				$Content = $sub_menu_line_start . olc_href_link(FILENAME_LIVE_HELP_ADMIN) .
				CLASS_menuBoxContentLink_target . BOX_LIVE_HELP_ADMIN . $sub_menu_line_end;
				$table_lines.=create_config_menu($Content);
			}
		}
	}
	//W. Kaiser CAO
	if (defined('CAO_INCLUDE'))
	{
		if (CAO_INCLUDE)
		{
			$xml_export_text='xml_export';
			if ($not_master_admin)
			{
				$allow=$admin_access[$xml_export_text];
			}
			if ($allow)
			{
				//$file=$xml_export_text.PHP;
				$file='export/cao_olc.php';
				if (file_exists($file))
				{
					$Content = $sub_menu_line_start . olc_href_link($file,'i=true') .
					CLASS_menuBoxContentLink_target . BOX_CAO . $sub_menu_line_end;
					$table_lines.=create_config_menu($Content);
				}
			}
		}
	}
	//W. Kaiser CAO

	//W. Easy Sales
	if (defined('EASYSALES_INCLUDE'))
	{
		if (EASYSALES_INCLUDE)
		{
			if ($not_master_admin)
			{
				$allow=$admin_access['eazysales'];
			}
			if ($allow)
			{
				$file='eazysales/admin/index.php';
				if (file_exists($file))
				{
					$Content = $sub_menu_line_start . olc_href_link($file) .
					CLASS_menuBoxContentLink_target . BOX_EASY . $sub_menu_line_end;
					$table_lines.=create_config_menu($Content);
				}
			}
		}
	}
	//W. Easy Sales

	if ($admin_access['blz_update'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_BLZ_UPDATE, 'full=1') .
		CLASS_menuBoxContentLink . BOX_BLZ_UPDATE . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	//W. Easy Sales
	//W. Kaiser Blz-Update
	if ($admin_access['google_sitemap'])
	{
		//	W. Kaiser Google Sitemap
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_GOOGLE_SITEMAP, 'auto=true&amp;ping=true') .
		CLASS_menuBoxContentLink . BOX_GOOGLE_SITEMAP . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	//	W. Kaiser Google Sitemap

	//	W. Kaiser chCounter
	if (CHCOUNTER_ACTIVE)
	{
		$Content = $sub_menu_line_start . olc_href_link(ADMIN_PATH_PREFIX.'chCounter/administration/index.php') .
		CLASS_menuBoxContentLink_target . BOX_CHCOUNTER . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	//	W. Kaiser chCounter

	//	W. Kaiser Elm@r
	if ($admin_access['elmar_start'])
	{
		if (file_exists(FILENAME_ELMAR))
		{
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_ELMAR, 'file=index.php') .
			CLASS_menuBoxContentLink_target . BOX_ELMAR . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
		}
	}
	//	W. Kaiser Elm@r

	//Xsell
	if ($admin_access['xsell_products'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_XSELL_PRODUCTS . '?first_entrance=1') .
		CLASS_menuBoxContentLink . BOX_XSELL_PRODUCTS . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	//Xsell

	//VPE
	if ($admin_access['products_vpe'])
	{
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_PRODUCTS_VPE ) .
		CLASS_menuBoxContentLink . BOX_PRODUCTS_VPE . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}
	//VPE

	//PDF-Katalog
	if ($admin_access['pdf_export'])
	{
		$pdf_link=olc_href_link(FILENAME_PDF_EXPORT,EMPTY_STRING,NONSSL,false,false,false);
		if (INCLUDE_PDF_INVOICE)
		{
			$pdf_link=str_replace(strtolower(HTTPS),strtolower(HTTP),$pdf_link);
		}
		$Content = $sub_menu_line_start . $pdf_link .
		CLASS_menuBoxContentLink_target . BOX_PDF_EXPORT . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
	}

	//W. Kaiser xxc_import
	if ($allow)			//Master Admin?
	{
		//$file=$xml_export_text.PHP;
		$file='xxc_import.php';
		if (file_exists($file))
		{
			$Content = $sub_menu_line_start . olc_href_link($file) .
			CLASS_menuBoxContentLink_target . BOX_XXC_IMPORT . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
		}
		//Import-Export products
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_IMPORT_EXPORT) .
		CLASS_menuBoxContentLink . BOX_IMPORT_EXPORT_PRODUCTS . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);

		//Import-Export customers
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_IMPORT_EXPORT,'data_type=customers') .
		CLASS_menuBoxContentLink . BOX_IMPORT_EXPORT_CUSTOMERS . $sub_menu_line_end;
		$table_lines.=create_config_menu($Content);
}

	//W. Kaiser Down for Maintenance
	if ($admin_access['down_for_maintenance'])
	{
		set_top_level_menu(BOX_HEADING_DOWN_FOR_MAINTENANCE);
		$Content = $sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'18') .
		CLASS_menuBoxContentLink .
		BOX_DOWN_FOR_MAINTENANCE . $sub_menu_line_end;
		//$table_lines.=create_config_menu($Content);
		$table_lines.=create_config_menu($Content);
	}
	//W. Kaiser Down for Maintenance
	if (SHOW_AFFILIATE)
	{
		//inclusion for affiliate program
		if ($admin_access['configuration'])
		{
			set_top_level_menu(BOX_HEADING_AFFILIATE);
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_CONFIGURATION, $gid_text.'900') .
			CLASS_menuBoxContentLink . BOX_AFFILIATE_CONFIGURATION . $sub_menu_line_end;
			//$table_lines.=create_config_menu($Content);
			$table_lines.=create_config_menu($Content);
			if ($admin_access['affiliate_affiliates'])
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_AFFILIATE) .
			CLASS_menuBoxContentLink . BOX_AFFILIATE . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
			if ($admin_access['affiliate_banners'])
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_AFFILIATE_BANNERS) .
			CLASS_menuBoxContentLink . BOX_AFFILIATE_BANNERS . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
			if ($admin_access['affiliate_clicks'])
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_AFFILIATE_CLICKS) .
			CLASS_menuBoxContentLink . BOX_AFFILIATE_CLICKS . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
			if ($admin_access['affiliate_contact'])
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_AFFILIATE_CONTACT) .
			CLASS_menuBoxContentLink . BOX_AFFILIATE_CONTACT . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
			if ($admin_access['affiliate_payment'])
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_AFFILIATE_PAYMENT) .
			CLASS_menuBoxContentLink . BOX_AFFILIATE_PAYMENT . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
			if ($admin_access['affiliate_sales'])
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_AFFILIATE_SALES) .
			CLASS_menuBoxContentLink . BOX_AFFILIATE_SALES . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
			if ($admin_access['affiliate_summary'])
			$Content = $sub_menu_line_start . olc_href_link(FILENAME_AFFILIATE_SUMMARY) .
			CLASS_menuBoxContentLink . BOX_AFFILIATE_SUMMARY . $sub_menu_line_end;
			$table_lines.=create_config_menu($Content);
		}
		//inclusion for affiliate program
	}
}
$menu_gen=false;
$nav_start='
					<!-- left_navigation bof //-->
';
$nav_end='
					<!-- left_navigation eof //-->
';
$menu_done=true;
if ($css_menu)
{
	$Content =$nav_start.$table_lines.$nav_end;
	$Content=str_replace(ATSIGN,$Content,$table);
	$make_box=!USE_CSS_DYNAMIC_ADMIN_MENU;
}
elseif (USE_COOL_ADMIN_MENU)
{
	echo $nav_start;
	include_once(CURRENT_TEMPLATE_ADMIN.'categories_coolmenu.php');
	include_once(DIR_FS_INC.'olc_cool_menu.inc.php');
	echo $nav_end;
	return;
}
else
{
	$Content=str_replace(ATSIGN,$table_lines,$table);
	$Content =$nav_start.$Content.$nav_end;
	$make_box=CURRENT_SCRIPT<>FILENAME_DEFAULT && ($show_column_right!=true);
}
if ($make_box)
{
	if (USE_AJAX)
	{
		$make_box=!$_SESSION[BOX_LEFT2];
	}
	if ($make_box)
	{
		if (USE_AJAX)
		{
			$smarty->assign(BOX_RIGHT,HTML_NBSP);
			$_SESSION[BOX_LEFT2]=true;
			$smarty_box=BOX_LEFT2;
		}
		include(DIR_WS_INCLUDES.'column_right_content.php');
	}
}
if (USE_SMARTY)
{
	if (NOT_IS_AJAX_PROCESSING)
	{
		$smarty->assign(BOX_LEFT1,$Content);
	}
	ob_end_clean(); 	//Discard buffer
	ob_start();				//Restart buffering
	echo '
<!-- main_content_start-->
';
}
else
{
	if ($css_menu)
	{
		$div_field.=$Content;
	}
	else
	{
		$Content ='
		<td class="columnLeft" nowrap="nowrap" valign="top">
			'.$Content .
		$R_Content.'
		</td>
';
		echo $Content;
	}
}

function get_main_content_from_buffer(&$smarty)
{
	$main_content=ob_get_contents();
	if ($main_content<>EMPTY_STRING)
	{
		/*

		Brute force approach: contain fucked-up HTML in a "div"-block to avoid layout problems.

		As we read the main-content from PHP's output buffer, where OL-Commerce "echo"-ed
		it's HTML-code intended to describer the complete page, we have to make sure, that this
		(definitely wrong!) HTML injected into the "main_content" area of the template via AJAX
		does not compromise the templates layout.

		There are more "<td>"-, "</td>"- and "<table>"- and "</table>" than we do need in the context of our template!!!!

		The browsers can take care of this fucked-up HTML then within the "div"-block, and tidy it up.

		Well, not a really beautyful approach, but very easy and efficient.

		*/

		//Search leading "<td>"-tag and get rid of it in order to get the HTML right (somehow)
		//in the context of a template.
		$search_text='<td width="100%" valign="top">';
		$pos=strpos($main_content,$search_text);
		if ($pos>0)
		{
			if ($pos<=60)
			{
				$main_content=substr($main_content,$pos+strlen($search_text));
			}
		}
	}
	if (defined('MESSAGE_TEXT'))
	{
		if (MESSAGE_TEXT<>EMPTY_STRING)
		{
			$main_content=MESSAGE_TEXT.$main_content;
		}
	}
	$smarty->assign(MAIN_CONTENT,$main_content);		//Assign main_content to Smarty
	ob_end_clean(); 	//Discard buffer
	ob_start();				//Restart buffering
}

function create_config_menu($Content)
{
	global $table_line,$css_dynamic_menu,$css_dynamic_menu_or_use_cool_menu,$html_four_blanks;

	if ($css_dynamic_menu_or_use_cool_menu)
	{
		global $cfg_title_sql0,$cfg_group_header,$cfg_sql0,$modules_dir,$li_end,$set_text,$set_text_len;
		global $configuration_group_title_text,$call_parameter_gid,$gid_text,$gid_text_len,$call_parameter_set;
		global $big_html_br;

		if (USE_CSS_ADMIN_MENU_H)
		{
			$return=str_replace(ATSIGN,$Content,$table_line);
		}
		else
		{
			global $sub_menu_line_configuration0,$sub_menu_line_module0,$sub_menu_start,$not_use_cool_menu;
			global $sub_menu_start_lm,$sub_menu_end,$class_x,$tool_tip_span,$use_css_tool_tip,$id;
			global $actual_value_configuration_text,$module_installed_text,$desc,$title,$h2;
			global $id_text,$text_text,$title_text,$link_text,$configuration_value_text,$sql_group;

			$have_menu=false;
			$pos=strpos($Content,FILENAME_CONFIGURATION);
			if ($pos!==false)
			{
				$pos=strpos($Content,$gid_text,$pos);
				$pos_e=strpos($Content,QUOTE,$pos);
				$gid_parameter=substr($Content,$pos,$pos_e-$pos);

				$new_gid_parameter=$gid_parameter.$call_parameter_gid;
				$gID=substr($gid_parameter,$gid_text_len);
				$cfg_group_query = olc_db_query(str_replace(HASH,$gID,$cfg_title_sql0));
				$cfg_group = olc_db_fetch_array($cfg_group_query);
				//$return=str_replace(HASH,$cfg_group[$configuration_group_title_text],$cfg_group_header);

				$Content=str_replace(FILENAME_CONFIGURATION.QUESTION.$gid_parameter,HASH,$Content);
				$Content=str_replace(HTML_A_START,$sub_menu_start_lm.HTML_A_START.$sub_menu,$Content);

				$sub_menu=$sub_menu_start;
				$configuration_query = olc_db_query(str_replace(HASH,$gID,$cfg_sql0));
				if (olc_db_num_rows($configuration_query))
				{
					$have_menu=true;
					if (USE_COOL_ADMIN_MENU)
					{
						set_menu_entry($title,$desc,EMPTY_STRING);
					}
					while ($configuration = olc_db_fetch_array($configuration_query))
					{
						$cID=$configuration['configuration_id'];
						$cfg_key=$configuration['configuration_key'];
						$cfg_value=$configuration['configuration_value'];
						$title=strtoupper($cfg_key.'_TITLE');
						if (defined($title))
						{
							$title=str_replace(QUOTE,APOS,constant($title));
							$desc=strtoupper($cfg_key.'_DESC');
							$desc=str_replace(QUOTE,APOS,constant($desc));
							$desc.=$actual_value_configuration_text.$cfg_value;
						}
						else
						{
							$title=ADMIN_CONFIG_UNDEFINED_CONSTANT.$title.APOS.COMMA_BLANK.$cID;
							$desc=EMPTY_STRING;
							$new_gid_parameter=EMPTY_STRING;
							$cID=EMPTY_STRING;
						}
						$sub_menu_line_temp=create_sub_menu_line($new_gid_parameter.$cID,$sub_menu_line_configuration0);
						if ($not_use_cool_menu)
						{
							$sub_menu.=$sub_menu_line_temp;
						}
					}
				}
				else
				{
					$return=str_replace(ATSIGN,$Content,$table_line);
				}
			}
			else
			{
				global $menu_gen;
				$pos=strpos($Content,FILENAME_MODULES);
				if ($pos!==false)
				{
					$is_order_total=false;
					$pos=strpos($Content,$set_text,$pos);
					$pos_e=strpos($Content,QUOTE,$pos);
					$set_parameter=substr($Content,$pos,$pos_e-$pos);
					$set=substr($set_parameter,$set_text_len);
					$module_type = $set;
					$is_payment=$set=='payment';
					if (!$is_payment)
					{
						$is_shipping=$set=='shipping';
						if (!$is_shipping)
						{
							$module_type = 'order_total';
							$is_order_total=true;
						}
					}
					$module_type_u=strtoupper($module_type);
					$module_type.=SLASH;

					$module_directory = DIR_FS_CATALOG_MODULES.$module_type;
					$files=array();
					if ($dh=opendir($module_directory))
					{
						while (($file=readdir($dh)) !==false)
						{
							if (olc_include_file($module_directory,$file,false))
							{
								if ($file==FILENAME_PAYPAL_IPN)
								{
									$include=USE_PAYPAL_IPN;
								}
								elseif ($file==FILENAME_PAYPAL_WPP)
								{
									$include=USE_PAYPAL_WPP;
								}
								else
								{
									$include=true;
								}
								if ($include)
								{
									$files[]=$file;
								}
							}
						}
					}
					closedir($dh);
					$modules=sizeof($files);
					if ($modules)
					{
						global $module_language_directory0;

						$have_menu=true;
						$sub_menu_line=$sub_menu_line_module0;
						$new_set_parameter0=$set_parameter.$call_parameter_set;
						$module_language_directory=$module_language_directory0 . $module_type;

						$module_type='MODULE_'.$module_type_u.UNDERSCORE;
						$module_key = $module_type.'INSTALLED';

						$module_type.=HASH.UNDERSCORE;
						if (!$is_order_total)
						{
							$module_type.='TEXT_';
						}
						$module_title=$module_type.'TITLE';
						$module_desc=$module_type.'DESCRIPTION';

						$check_query = olc_db_query(str_replace(HASH,$module_key,$sql_group));
						if (olc_db_num_rows($check_query))
						{
							$check = olc_db_fetch_array($check_query);
							$installed_modules=$check[$configuration_value_text];
						}
						else
						{
							$installed_modules=EMPTY_STRING;
						}

						$Content=str_replace(FILENAME_MODULES.QUESTION.$set_parameter,HASH,$Content);
						$Content=str_replace(HTML_A_START,$sub_menu_start_lm.HTML_A_START.$sub_menu,$Content);
						$sub_menu=$sub_menu_start;
						for ($module=0;$module<$modules;$module++)
						{
							$file=$files[$module];
							$pos=$module_language_directory.$file;
							if (is_file($pos))
							{
								include($pos);
							}
							$pos=strrpos($file,DOT);
							$set=substr($file,0,$pos);
							if ($is_payment)
							{
								if ($set=='paypal_wpp')
								{
									$set='paypal_ec';
								}
								elseif ($set=='pm2checkout')
								{
									$set='2checkout';
								}
							}
							elseif ($is_shipping)
							{
								$s='freeamount';
								if (strpos($set,$s)!==false)
								{
									$set=str_replace($s,'freecount',$set);
								}
							}
							elseif ($is_order_total)
							{
								if ($set=='ot_cod_fee')
								{
									$set='cod';
								}
								elseif ($set=='ot_payment')
								{
									$set='payment_disc';
								}
								else
								{
									$set=str_replace('ot_',EMPTY_STRING,$set);
								}
							}
							$cfg_value=strtoupper($set);
							$title=str_replace(HASH,$cfg_value,$module_title);
							if (defined($title))
							{
								$title=str_replace(QUOTE,APOS,constant($title));
								$desc=str_replace(HASH,$cfg_value,$module_desc);
								if (!defined($desc))
								{
									$desc=str_replace(HASH,$cfg_value,$module_type.'DESC');
								}
								$desc=str_replace(QUOTE,APOS,constant($desc));
								$desc.=$actual_value_configuration_text.$cfg_value;
								if (strpos($installed_modules,$file)!==false)
								{
									$cfg_value=YES;
								}
								else
								{
									$cfg_value=NO;
								}
								$desc.=$module_installed_text.$cfg_value;
								$new_set_parameter=$new_set_parameter0;
							}
							else
							{
								$title=ADMIN_CONFIG_UNDEFINED_CONSTANT.$title.APOS.COMMA_BLANK.$cID;
								$desc=EMPTY_STRING;
								$new_set_parameter=EMPTY_STRING;
							}
							$sub_menu_line_temp=create_sub_menu_line($new_set_parameter.$set,$sub_menu_line_module0);
							if ($not_use_cool_menu)
							{
								$sub_menu.=$sub_menu_line_temp;
							}
						}
					}
				}
				else
				{
					$return=str_replace(ATSIGN,$Content,$table_line);
				}
			}
		}
		if ($have_menu)
		{
			if (USE_COOL_ADMIN_MENU)
			{
				$return=EMPTY_STRING;
			}
			else
			{
				$sub_menu.=$sub_menu_end;
				$return=str_replace($li_end,$sub_menu,$Content);
			}
		}
	}
	else
	{
		$return=str_replace(ATSIGN,$Content,$table_line);
	}
	return $return;
}

function create_sub_menu_line($new_parameter,$sub_menu_line_temp)
{
	global $use_css_tool_tip,$tool_tip_span,$desc,$title,$big_html_br,$html_four_blanks;
	global $par_text,$desc_text,$title_text,$b_start_text,$b_end_text;

	if ($use_css_tool_tip)
	{
		$desc=str_replace(HASH,$desc,$tool_tip_span);
		$title.=nl2br($desc);
		$desc=EMPTY_STRING;
	}
	else
	{
		$desc=str_replace(HTML_BR,NEW_LINE,$desc);
		$desc=str_replace($big_html_br,NEW_LINE,$desc);
		$desc=strip_tags($desc);
	}
	if (USE_COOL_ADMIN_MENU)
	{
		set_menu_entry($title,$desc,$new_parameter);
	}
	else
	{
		$sub_menu_line=str_replace($par_text,$new_parameter,$sub_menu_line_temp);
		$sub_menu_line=str_replace($desc_text,$desc,$sub_menu_line);
		$sub_menu_line=str_replace($title_text,$title,$sub_menu_line);
		$sub_menu_line=clean_entry_text($sub_menu_line);
		$sub_menu_line=str_replace(AMP,HTML_AMP,$sub_menu_line);
		return $sub_menu_line;
	}
}

function clean_entry_text($text)
{
	$text=str_replace($b_start_text,HTML_B_START,$text);
	$text=str_replace($b_end_text,HTML_B_END,$text);
	$text=str_replace($big_html_br,HTML_BR,$text);
	return $text;
}

function set_menu_entry($text,$title,$link=EMPTY_STRING)
{
	global $id_text,$text_text,$title_text,$link_text,$menu_entries,$id;

	$menu_entries[]=array(
	$id_text=>$id,
	$text_text=>clean_entry_text($text),
	$title_text=>$title=clean_entry_text($title),
	$link_text=>str_replace(AMP,HTML_AMP,$link)
	);
}

function set_top_level_menu($text)
{
	if (USE_COOL_ADMIN_MENU)
	{
		global $id_text,$text_text,$title_text,$link_text,$menu_entries,$id;
		set_menu_entry($text,EMPTY_STRING,EMPTY_STRING);
	}
	else
	{
		global $table_lines,$menu_line_start,$menu_line_end;

		$table_lines.= $menu_line_start . $text . $menu_line_end;
	}
}
?>