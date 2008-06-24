<?
/* -----------------------------------------------------------------------------------------
$Id: ajax_slideshow.php,v 1.2 2004-11-27

Copyright (c) 2004 by at-future, js@at-future.com
Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(specials.php,v 1.30 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (specials.php,v 1.10 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

$slideshow_type=$_GET['type'];
$is_products_show=$slideshow_type==0;
$current_template_text='CURRENT_TEMPLATE';
$stand_alone=!defined($current_template_text);		//Stand-alone mode!

global $slideshow_id;
$last_slide_text='last_slide_'.$slideshow_type;
if ($stand_alone)
{
	$slideshow_id=array(false,false);
	$slideshow_id[$slideshow_type]=true;

	include('includes/configure.php');
	require_once(DIR_FS_INC.'olc_define_global_constants.inc.php');

	define('USE_AJAX',true);
	define('NOT_USE_AJAX', !USE_AJAX);
	define('IS_AJAX_PROCESSING', true);
	define('NOT_IS_AJAX_PROCESSING', !IS_AJAX_PROCESSING);
	define('DO_AJAX_VALIDATION', false);
	define('IS_ADMIN_FUNCTION',false);
	define('NOT_IS_ADMIN_FUNCTION',true);
	define('USE_LAYOUT_DEFINITION',FALSE_STRING_S);
	define('USE_SEO',false);

	define('NO_BOX_LAYOUT',TRUE_STRING_S);
	define('AJAX_DATA_ELEMENTS_TO_CHANGE',EMPTY_STRING);
	define('IS_LOCAL_HOST',file_exists('d:\vb6\C2.EXE'));

	$connected=false;
	define('MULTI_DB_SERVER',false);
	require_once(DIR_FS_INC.'olc_connect_and_get_config.inc.php');
	olc_connect_and_get_config(array(1,17,19),$level);
	require_once(DIR_WS_CLASSES.'smarty/Smarty.class.php');
	require_once(DIR_FS_INC.'olc_smarty_init.inc.php');
	include_once(DIR_FS_INC.'olc_start_session.inc.php');
	$language_text='language';
	define('SESSION_LANGUAGE', $_SESSION[$language_text]);
	include_once(DIR_WS_INCLUDES.'filenames.php');
	olc_smarty_init($smarty,$cacheid,false);
	if ($is_products_show)
	{
		require_once(DIR_FS_INC.'olc_get_template.inc.php');
		require_once(DIR_WS_CLASSES.'split_page_results.php');
		include(DIR_WS_INCLUDES.'write_customers_status.php');
		define('SESSION_LANGUAGE_ID', $_SESSION[$language_text.'_id']);
		define('SESSION_CURRENCY',$_SESSION['currency']);
		define($current_template_text,olc_get_template());
		define('FULL_CURRENT_TEMPLATE',TEMPLATE_PATH.CURRENT_TEMPLATE.SLASH);
		define('CURRENT_TEMPLATE_MODULE',CURRENT_TEMPLATE.SLASH.'module'.SLASH);
		define('ADMIN_PATH_PREFIX',EMPTY_STRING);
		define('MAX_DISPLAY_SEARCH_RESULTS',1);
		define('MINIMUM_SHIP_COST',$_SESSION['minimum_ship_cost']);
		include_once(DIR_FS_INC.'olc_get_all_get_params.inc.php');
		include_once(DIR_FS_INC.'olc_image_button.inc.php');
		include_once(DIR_FS_INC.'olc_get_box_configuration.inc.php');
		include_once(DIR_FS_INC.'olc_get_seo_data.inc.php');
		include_once(DIR_FS_INC.'olc_get_vpe_name.inc.php');
		include_once(DIR_FS_INC.'olc_precision.inc.php');
	}
	$buttons=SLASH.SESSION_LANGUAGE.SLASH;
	include('lang'.$buttons.SESSION_LANGUAGE.PHP);
	$buttons='buttons'.$buttons;
	define('CURRENT_TEMPLATE_BUTTONS',FULL_CURRENT_TEMPLATE.$buttons);
	include_once(DIR_FS_INC.'olc_href_link.inc.php');
	include_once(DIR_FS_INC.'olc_seo_url.inc.php');
	include_once(DIR_FS_INC.'olc_image.inc.php');
	include_once(DIR_FS_INC.'olc_check_agent.inc.php');
	include_once(DIR_FS_INC.'olc_db_prepare_input.inc.php');
	include_once(DIR_FS_INC.'olc_db_input.inc.php');
}
elseif ($is_products_show)
{
	unset($module_smarty);
}
include_once(DIR_FS_INC.'olc_rand.inc.php');
//Products
if ($is_products_show)
{
	if (true)
	{
		$do_slide_show=true;
		$module=EMPTY_STRING;
		$status_cond='products_status=1';
		$lowest_text='lowest';
		$highest_text='highest';
		$lowest_id=$_SESSION[$lowest_text];
		if (!$lowest_id)
		{
			$product_query_text=SELECT .'min(products_id) as lowest, max(products_id) as highest FROM '.
			TABLE_PRODUCTS.SQL_WHERE.$status_cond;
			$product_query = olc_db_query($product_query_text);
			$product_query=olc_db_fetch_array($product_query);
			$lowest_id=$product_query[$lowest_text];
			$highest_id=$product_query[$highest_text];
			$_SESSION[$lowest_text]=$lowest_id;
			$_SESSION[$highest_text]=$highest_id;
		}
		$highest_id=$_SESSION[$highest_text];

		$products_listing_sql0 =
		olc_standard_products_query(EMPTY_STRING) ."
	 	and p.products_id = @
  	and p.".$status_cond."
  	LIMIT 1";
		while (true)
		{
			$products_id=(int)olc_rand($lowest_id,$highest_id);
			$products_listing_sql = str_replace(ATSIGN,$products_id,$products_listing_sql0);
			$product_query = olc_db_query($products_listing_sql);
			if (olc_db_num_rows($product_query)>0)
			{
				if ($products_id<>$_SESSION[$last_slide_text])
				{
					$_SESSION[$last_slide_text]=$products_id;
					break;
				}
			}
		}
/*
		$products_listing_sql="
		select distinct
		p.products_id,
		p.products_image,
		pd.products_name,
		pd.products_short_description
		from `wtl`.olc_products p, `wtl`.olc_products_description pd
		where
		p.products_id = pd.products_id
		and p.products_status=1
		and pd.language_id = '2'
		";
		$products_listing_template=' | '.FILENAME_PRODUCT_INFO.QUESTION.'products_id=';
		$slide_data=EMPTY_STRING;
		$product_query = olc_db_query($products_listing_sql);
		while ($product=olc_db_fetch_array($product_query))
		{
			$slide_data.=$product['products_image'].
			' | products_info.php?products_id='.$product['products_id'].
			' | '.strip_tags($product['products_name']).TILDE.strip_tags($product['products_short_description']).NEW_LINE;
			$slide_data=str_replace(HTML_NBSP,BLANK,$slide_data);
		}
*/
		$products_listing_template=EMPTY_STRING;
		$smarty_config_section="upcoming_products";
		$heading_text=EMPTY_STRING;
		$products_use_random_data=false;
		$products_use_short_date=false;
		$products_listing_simple=true;
		$ignore_scripts=CURRENT_SCRIPT;
		include(DIR_FS_INC.'olc_prepare_products_listing_info.inc.php');
		if ($products_listing_entries)
		{
			$module_smarty->assign(MODULE_CONTENT,$module_content);
			$module= $module_smarty->fetch($products_listing_template,$cache_id);
		}
		$smarty_config_section=EMPTY_STRING;
		$do_slide_show=false;
	}
	else
	{
		$do_slide_show=true;
		$module=EMPTY_STRING;
		include(DIR_WS_INCLUDES . FILENAME_CENTER_MODULES);
	}
	$width=SLIDESHOW_PRODUCTS_WIDTH;
	$height=SLIDESHOW_PRODUCTS_HEIGHT;
	$border=SLIDESHOW_PRODUCTS_BORDER;
	$show_controls=SLIDESHOW_PRODUCTS_CONTROLS;
}
//Images
else
{
	$slideshow_text='slideshow';
	$slideshow_dir=DIR_WS_IMAGES.$slideshow_text.SLASH;
	if (is_dir($slideshow_dir))
	{
		$slideshow_file=$slideshow_dir.$slideshow_text.'.txt';
		if (is_file($slideshow_file))
		{
			$slide=file($slideshow_file);
			$slides=sizeof($slide);
			if ($slides>1)
			{
				while (true)
				{
					$slide_select=$_SESSION[$last_slide_text];
					while ($slide_select==$_SESSION[$last_slide_text])
					{
						//Select slide
						$slide_select=olc_rand(1,$slides);
					}
					$_SESSION[$last_slide_text]=$slide_select;
					$curren_slide=explode('|',trim($slide[$slide_select]));
					$slideshow_file=$slideshow_dir.trim($curren_slide[0]);
					if (is_file($slideshow_file))
					{
						break;
					}
				}
				$width = @getimagesize($slideshow_file);
				$height=max($width[1],SLIDESHOW_IMAGES_HEIGHT);
				$width=max($width[0],SLIDESHOW_IMAGES_WIDTH);
				$border=trim($curren_slide[2]);
				if (IS_IE)
				{
					$sep=NEW_LINE.NEW_LINE;
				}
				else
				{
					$sep=" -- ";
				}
				$slideshow_text=str_replace(TILDE,$sep,$border).$sep.TEXT_FURTHER_INFO;
				$module=olc_image($slideshow_file,$slideshow_text);
				$a_parameter='" onclick="javascript:slideshow_stop('.$slideshow_type.RPAREN;
				$link=trim($curren_slide[1]);
				$link_parameter='pop_up=true&fake_print=true';
				if (false)
				{
					$a_parameter.='" target="_blank';
					$link=olc_href_link($link,$link_parameter);
				}
				else
				{
					$a_parameter.=';ShowInfo(\''. $link ."');return false;";
					$link=olc_href_link(HASH);
				}
				/*
				$module=HTML_A_START.olc_href_link($link,'pop_up=true&fake_print=true').
				'" onclick="javascript:slideshow_stop(1)" target="_blank'.'">'.$module.HTML_A_END;
				*/
				$module=HTML_A_START.$link.$a_parameter.'">'.$module.HTML_A_END;
				if ($border)
				{
					if (SLIDESHOW_IMAGES_SHOW_TEXT==TRUE_STRING_S)
					{
						if (strpos($border,TILDE)!==false)
						{
							$curren_slide=explode(TILDE,$border);
							$border=HTML_B_START.$curren_slide[0].HTML_B_END;
							for ($i=1,$n=sizeof($curren_slide);$i<$n;$i++)
							{
								$border.=$sep.$curren_slide[$i];
							}
							if (IS_IE)
							{
								$border=str_replace($sep,NEW_LINE,$border);
								$border=nl2br($border);
							}
						}
						$module.=HTML_BR.$border;
					}
				}
				$border=SLIDESHOW_IMAGES_BORDER;
				$show_controls=SLIDESHOW_IMAGES_CONTROLS;
			}
			else
			{
				return;
			}
		}
		else
		{
			return;
		}
	}
	else
	{
		return;
	}
}
$slideshow_type_u=UNDERSCORE.$slideshow_type;
$id=' id="slideshow_content'.$slideshow_type_u;
if ($stand_alone)
{
	$module='<!-- '.$id.'-->'.$module;
}
else
{
	$delay_min=max((SLIDESHOW_INTERVAL-1),SLIDESHOW_INTERVAL_MIN);
	$s='%';
	$delay_min=str_replace($s,$delay_min,TEXT_SLIDESHOW_BUTTONS_SPEEDUP);
	$delay_max=str_replace($s,SLIDESHOW_INTERVAL+1,TEXT_SLIDESHOW_BUTTONS_SPEEDUP);
	$delay=str_replace($s,SLIDESHOW_INTERVAL,TEXT_SLIDESHOW_BUTTONS_SPEED);

	$button_delay=' id="button_delay';
	$button_stop=' id="button_stop';
	$button_start=' id="button_start';
	$button_speedup=' id="button_speedup';

	$term=$slideshow_type_u.QUOTE;
	if (IE)
	{
		$cell_width=' width="25%"';
	}
	else
	{
		$cell_width=EMPTY_STRING;
	}
	$total='_total'.$term;
	$button_delay_total=$cell_width.$button_delay.$total;
	$button_stop_total=$cell_width.$button_stop.$total;
	$button_start_total=$cell_width.$button_start.$total;
	$button_speedup_total=$cell_width.$button_speedup.$total;

	$button_delay.=$term;
	$button_stop.=$term;
	$button_start.=$term;
	$button_speedup.=$term;

	if ($border==TRUE_STRING_S)
	{
		$border=' style="border:2px solid Brown"';
	}
	$module='
<table '.$border.' id="slideshow_table'.$slideshow_type_u.'" class="main" width="'.$width.'" height="'.$height.
'" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="4" align="center"'.$id.'">
'.$module.'
		</td>
	</tr>
';
	if ($show_controls==TRUE_STRING_S)
	{
		$module.='
	<tr id="slideshow_controls'.$slideshow_type_u.'" height="40">
		<td valign="top">
			<hr>
			<table border="0" width="100%">
				<tr>
					<td align="center" width="25%"'.$button_delay_total.'>
						<input '.$button_delay.'
							title="'.$delay_max.'"
							type="button" value="'.TEXT_SLIDE_SHOW_SLOWER.'"
							onclick="javascript:slideshow_delay('.$slideshow_type.')"
							style="font-weight:bold;font-size: 10px">
					</td>
					<td align="center"'.$button_stop_total.'>
						<input'.$button_stop.'
							title="'.$delay.'"
							type="button" value="'.TEXT_SLIDE_SHOW_STOP.'"
							onclick="javascript:slideshow_stop('.$slideshow_type.')"
							style="font-weight:bold;font-size: 10px">
					</td>
					<td style="display:none" align="center" width="25%"'.$button_start_total.'>
						<input'.$button_start.'
							title="'.$delay.'"
							type="button" value="'.TEXT_SLIDE_SHOW_START.'"
							onclick="javascript:slideshow_start('.$slideshow_type.')"
							style="font-weight:bold;font-size: 10px">
					</td>
					<td align="center" width="25%"'.$button_speedup_total.'>
						<input'.$button_speedup.'
							title="'.$delay_min.'"
							type="button" value="'.TEXT_SLIDE_SHOW_FASTER.'"
							onclick="javascript:slideshow_speedup('.$slideshow_type.')"
							style="font-weight:bold;font-size: 10px">
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
';
	}
}
$var=BOX.'SLIDESHOW'.$slideshow_type_u;
if ($stand_alone)
{
	$smarty->assign($var,$module);
	$smarty->fetch(INDEX_HTML);
}
else
{
$default_smarty->assign($var,$module);
}
?>