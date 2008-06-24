<?php
/* -----------------------------------------------------------------------------------------
$Id: boxes.php,v 1.1.1.1 2006/12/22 14:52:27 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX
//W. Kaiser - xtCommerce hack
if (OL_COMMERCE)
{
	$inc_path=DIR_FS_INC;
	define('INC_PATH',DIR_FS_INC);
	if (!function_exists('set_sticky_cart'))
	{
		function set_sticky_cart()
		{
			global $box_smarty, $is_logoff,$include_shopping_cart,$sticky_cart_visible_text;

			if ($is_logoff)
			{
				$sticky_cart_hide=true;
			}
			else
			{
				if (
				CURRENT_SCRIPT==FILENAME_CHECKOUT_PAYMENT or
				CURRENT_SCRIPT==FILENAME_CHECKOUT_CONFIRMATION or
				CURRENT_SCRIPT==FILENAME_CHECKOUT_SHIPPING)
				{
					$sticky_cart_hide=true;
				}
			}
			if ($sticky_cart_hide)
			{
				$sticky_cart_visible=false;
			}
			else
			{
				$s='cart_modified';
				if ($_SESSION[$s])
				{
					$_SESSION[$s]=false;
					$sticky_cart_visible=true;
				}
				//Check, if 'shopping_cart.php' found an existing cart by checking the smarty variable "TOTAL"
				elseif ($include_shopping_cart)
				{
					if (CURRENT_SCRIPT != FILENAME_LOGIN)
					{
						if (is_object($box_smarty))
						{
							$sticky_cart_visible=$box_smarty->get_template_vars("TOTAL")!=EMPTY_STRING;
						}
					}
					if (!$sticky_cart_visible)
					{
						$sticky_cart_visible=$_SESSION[$sticky_cart_visible_text];
					}
				}
			}
			//$sticky_cart_visible=$include_shopping_cart || $sticky_cart_visible;
			if ($sticky_cart_visible)
			{
				$sticky_cart_visible_value=TRUE_STRING_S;
			}
			else
			{
				$sticky_cart_visible_value=FALSE_STRING_S;
			}

			$_SESSION[$sticky_cart_visible_text]=$sticky_cart_visible;
			define(strtoupper($sticky_cart_visible_text),$sticky_cart_visible_value);
		}
	}
}
else
{
	$inc_path=INC_PATH;
}
//W. Kaiser - xtCommerce hack

global $box_smarty, $is_logoff,$include_shopping_cart,$sticky_cart_visible_text,$use_ajax_short_list;

$sticky_cart_visible_text='sticky_cart_visible';
//define('DIR_WS_BOXES',DIR_FS_CATALOG .FULL_CURRENT_TEMPLATE. 'source/boxes/');
if ($use_ajax_short_list || $force_cart_update_only)
{
	$include_shopping_cart=true;
	$use_ajax_short_list=true;
	include(box_code_script_path('shopping_cart.php'));
	if (defined('OL_COMMERCE'))
	{
		include_once(DIR_FS_INC.'olc_create_navigation_links.inc.php');
		olc_create_navigation_links(true,false);
		set_sticky_cart();
	}
}
elseif (!isset($_GET['pop_up']))
{
	if (USE_AJAX)
	{
		$delay_boxes=true;		//Wenn auf "true" gesetzt, werden einige zeitaufwändige Boxen nicht sofort,
		//sondern erst nachdem der Hauptbildschirm aktualisiert wurde.;
		//Solche Boxen sind:
		//best_sellers, whats_new,upcoming_products,xsell_products
	}
	//Bei der AJAX-Verarbeitung wird geprüft, ob die Boxen erstellt werden müssen.
	//Wenn nicht, werden diese gar nicht erst erstellt!
	$is_logoff=CURRENT_SCRIPT == FILENAME_LOGOFF;
	$is_ajax_processing=IS_AJAX_PROCESSING;
	if (NOT_IS_AJAX_PROCESSING)
	{
		if (USE_AJAX)
		{
			$is_ajax_processing=defined('IS_AJAX_PROCESSING_FORCED');
		}
	}
	$isset_customer_id=$_SESSION['customer_id'];
	$customer_show_price=CUSTOMER_SHOW_PRICE;
	$not_is_logoff=!$is_logoff;
	$force_language=defined('AJAX_REBUILD_ALL');
	if (($is_ajax_processing && $not_is_logoff && !$force_language))
	{
		$include_loginbox = $isset_customer_id ;
		$include_admin = $isset_customer_id;
		$include_categories=false;
		if ($include_admin )
		{
			if (CUSTOMER_IS_ADMIN)
			{
				//Display once after login or on logoff
				$admin_box_displayed='admin_box_displayed';
				$include_admin=$is_logoff;
				if (!$include_admin)
				{
					$include_admin=!$_SESSION[$admin_box_displayed];
				}
				if ($include_admin)
				{
					$_SESSION[$admin_box_displayed]=$not_is_logoff;
				}
			}
			else
			{
				$include_admin = false;
			}
			if ($is_logoff)
			{
				$include_loginbox = true;
			}
			else
			{
				$include_loginbox = !isset($_SESSION['info_box_displayed']);
			}
		}
		if ($include_loginbox)
		{
			//Customer logged in
			$include_tell_a_friend = SHOW_TELL_FRIEND;
			$include_infobox = true;
			$include_order_history = SHOW_HISTORY && $not_is_logoff;
			$_SESSION['info_box_displayed']=$not_is_logoff;;
			if ($not_is_logoff)
			{
				$include_add_a_quickie = SHOW_ADD_A_QUICKIE && $customer_show_price;
			}
		}
		$have_products_id = $_GET['products_id'] != EMPTY_STRING;
		$include_manufacturers = true;	//$have_products_id;
		$is_product_info=CURRENT_SCRIPT == FILENAME_PRODUCT_INFO;
		if (!$is_product_info)
		{
			$have_cPath=isset($_GET['cPath']);
			if ($have_cPath or $is_logoff)
			{
				//Only include box, if navigation done or on logout
				$include_categories =
				!(SHOW_COOL_MENU || OPEN_ALL_MENUE_LEVELS==TRUE_STRING_S); // || (SHOW_TAB_NAVIGATION==TRUE_STRING_S)
				$include_best_sellers = SHOW_BESTSELLERS;
			}
		}
		if ($customer_show_price)
		{
			if (!isset($_GET['cart_line']))				//Called from cart link?
			{
				if ($is_product_info)
				{
					$include_shopping_cart=true;
				}
				elseif ($include_loginbox && $not_is_logoff)
				{
					$include_shopping_cart=true;
				}
				elseif ((strpos(FILENAME_CHECKOUT_PROCESS.FILENAME_CHECKOUT_SUCCESS.
				FILENAME_SHOPPING_CART . FILENAME_LOGIN,
				CURRENT_SCRIPT)!==false))
				{
					$include_shopping_cart=true;
				}
				elseif (isset($_GET['force_cart']))
				{
					$include_shopping_cart=true;
				}
				elseif ($is_logoff)
				{
					$include_shopping_cart=true;
				}
			}
		}
		$is_checkout_shipping=CURRENT_SCRIPT == FILENAME_CHECKOUT_SHIPPING;
		$show_product_related_boxes=$have_products_id || $is_checkout_shipping;
		if ($show_product_related_boxes)
		{
			//Rebuild, if product selected
			$include_reviews = SHOW_REVIEWS;
			$include_tell_a_friend = SHOW_TELL_FRIEND;
			$include_product_notifications = SHOW_NOTIFICATIONS;
		}
		$last_viewed= SHOW_LAST_VIEWED;
		if ($is_logoff)
		{
			$include_currencies = SHOW_CURRENCIES;
			$include_languages = SHOW_LANGUAGES;
		}
		else
		{
			$include_currencies = SHOW_CURRENCIES && substr(CURRENT_SCRIPT, 0, 8) == 'checkout';
		}
	}
	else
	{
		$not_is_logoff_or_force_language=$not_is_logoff || $force_language;
		$is_logoff_or_force_language=$is_logoff || $force_language;
		$include_add_a_quickie = SHOW_ADD_A_QUICKIE && $customer_show_price;
		$include_best_sellers = SHOW_BEST_SELLERS;
		$include_categories = true;
		$include_content = $not_is_logoff_or_force_language;
		$include_currencies = SHOW_CURRENCIES;
		$include_infobox = true;		//$not_is_logoff_or_force_language;
		$include_languages = SHOW_LANGUAGES;
		$include_loginbox = true;
		$include_manufacturer_info = $not_is_logoff_or_force_language;
		$include_manufacturers = SHOW_MANUFACTURERS;	//$not_is_logoff_or_force_language;
		$include_newsletter =SHOW_NEWSLETTER;
		$include_search = $not_is_logoff_or_force_language;
		$include_shopping_cart = true;
		$include_admin = $isset_customer_id;
		$include_information = SHOW_INFORMATION;
		$include_order_history = SHOW_HISTORY && $isset_customer_id;
		$include_product_notifications = SHOW_NOTIFICATIONS;
		$include_reviews = SHOW_REVIEWS;
		$include_tell_a_friend = SHOW_TELL_FRIEND;
		if (SHOW_AFFILIATE)
		{
			// inclusion for affiliate program
			include(box_code_script_path('affiliate.php'));
		}
		if (SHOW_CONTACT_US)
		{
			// inclusion for contact us
			include(box_code_script_path('contact_us.php'));
		}
	}
	//W. Kaiser - AJAX
	$include_specials = SHOW_SPECIALS;
	$include_whats_new = SHOW_WHATSNEW;
	//W. Kaiser - AJAX

	if ($include_categories) include(box_code_script_path('categories.php'));
	if ($include_manufacturers) include(box_code_script_path('manufacturers.php'));
	if ($manufacturers_count)			//"$manufacturers_count" is set in "manufacturers.php"
	{
		include(box_code_script_path('manufacturer_info.php'));
	}
	if ($include_add_a_quickie) require(box_code_script_path('add_a_quickie.php'));
	if ($include_whats_new) require(box_code_script_path('whats_new.php'));
	if ($include_search) require(box_code_script_path('search.php'));
	if ($include_content) require(box_code_script_path('content.php'));
	if ($include_information) require(box_code_script_path('information.php'));
	if ($include_languages) include(box_code_script_path('languages.php'));
	if ($include_currencies) include(box_code_script_path('currencies.php'));
	if ($include_newsletter) include(box_code_script_path('newsletter.php'));
	if ($include_admin)
	{
		include(box_code_script_path('admin.php'));
	}
	elseif ($is_logoff)
	{
		$smarty->assign('box_ADMIN',HTML_NBSP);
	}
	if ($include_infobox) require(box_code_script_path('infobox.php'));
	if ($include_loginbox) require(box_code_script_path('loginbox.php'));
	if ($include_specials) require(box_code_script_path('specials.php'));
	if ($include_order_history) include(box_code_script_path('order_history.php'));

	if ($include_shopping_cart)
	{
		include(box_code_script_path('shopping_cart.php'));
	}
	else
	{
		$include_shopping_cart=$_SESSION[$sticky_cart_visible_text];
	}
	if (USE_AJAX)
	{
		//Achtung: dieser code  m u s s  nach
		//"if ($include_shopping_cart) include(box_code_script_path('shopping_cart.php')); folgen
		set_sticky_cart();
	}
	$box_tell_a_friend=box_code_script_path('tell_a_friend.php');
	$box_best_sellers=box_code_script_path('best_sellers.php');
	$box_product_notifications=box_code_script_path('product_notifications.php');
	$box_reviews=box_code_script_path('reviews.php');
	$box_last_viewed=box_code_script_path('last_viewed.php');
	if ($show_product_related_boxes)
	{
		if ($is_checkout_shipping)
		{
			if (SHOW_REVIEWS) include($box_reviews);
			if (SHOW_NOTIFICATIONS) include($box_product_notifications);
			$include_tell_a_friend=SHOW_TELL_FRIEND;
		}
		else
		{
			if ($include_product_notifications) include($box_product_notifications);
			if ($include_reviews) include($box_reviews);
		}
	}
	if (SHOW_LAST_VIEWED) require($box_last_viewed);
	if ($include_tell_a_friend) include($box_tell_a_friend);
	if ($include_best_sellers) include($box_best_sellers);
	if (LIVE_HELP_ACTIVE===true)
	{
		include(box_code_script_path('livehelp.php'));
	}
	if (strpos(CURRENT_SCRIPT,'checkout_')!==false)
	{
		if (OL_COMMERCE && CUSTOMER_ID==0)
		{
			$current_script=FILENAME_LOGIN;
		}
		else
		{
			$current_script=CURRENT_SCRIPT;
		}
		//$step_start_text='step_start';
		$step_start_text='class_start';
		olc_smarty_init($box_smarty,$cacheid);
		require_once($inc_path.'olc_get_smarty_config_variable.inc.php');
		$normal='normal';
		$classes=array($normal,$normal,$normal,$normal,$normal);
		$order_step_text_finished=EMPTY_STRING;
		switch ($current_script)
		{
			case FILENAME_LOGIN:
				$order_step_text='login';
				$order_step=0;
				$_SESSION[$step_start_text]=0;
				$navigation='navigation';
				if (is_object($_SESSION[$navigation]))
				{
					$_SESSION[$navigation]->set_snapshot();
				}
				break;
			case FILENAME_CHECKOUT_SHIPPING:
			case FILENAME_CHECKOUT_SHIPPING_ADDRESS:
				$order_step_text='ship';
				$order_step=1;
				break;
			case FILENAME_CHECKOUT_PAYMENT:
			case FILENAME_CHECKOUT_PAYMENT_ADDRESS:
				$order_step_text='payment';
				$order_step=2;
				break;
			case FILENAME_CHECKOUT_CONFIRMATION:
				$order_step_text='order';
				$order_step=3;
				break;
			case FILENAME_CHECKOUT_SUCCESS:
				$order_step_text='success';
				$order_step=4;
				$order_step_text_finished=UNDERSCORE.'finished';
				break;
		}
		$classes[$order_step]='high';
		$max_order_step=4;
		$step_start=$_SESSION[$step_start_text];
		if (isset($step_start))
		{
			$box_smarty->assign('use_five_steps',true);
		}
		else
		{
			$step_start=1;
		}
		$links=array(EMPTY_STRING,FILENAME_CHECKOUT_SHIPPING,FILENAME_CHECKOUT_PAYMENT);
		$titles=array(EMPTY_STRING,ORDER_STEP_1_TITLE,ORDER_STEP_2_TITLE);
		$class_order_step_text='class_';
		$class_order_link_start_text='LINK_START_';
		$class_order_link_end_text='LINK_END_';
		for ($step=$step_start;$step<=$max_order_step;$step++)
		{
			if ($step>0)
			{
				if ($step<$max_order_step_1)
				{
					if ($step<$order_step)
					{
						$box_smarty->assign($class_order_link_start_text.$step,
						HTML_A_START.olc_href_link($links[$step]).'" title="'.$titles[$step].'" style="cursor:hand">');
						$box_smarty->assign($class_order_link_end_text.$step,HTML_A_END);
					}
				}
			}
			$box_smarty->assign($class_order_step_text.$step,$classes[$step]);
		}
		$order_steps_text='order_steps';
		$box_template=BOX.$order_steps_text;
		$is_graphic_mode=is_file(CURRENT_TEMPLATE_IMG.$order_steps_text.'_1_normal.gif');
		if ($is_graphic_mode)
		{
			$box_template.=UNDERSCORE."graphic";
		}
		$order_step_text=olc_get_smarty_config_variable($box_smarty,$order_steps_text,$order_step_text.'_text');
		$you_are_here_text='you_are_here_text'.$order_step_text_finished;
		$you_are_here_text=olc_get_smarty_config_variable($box_smarty,$order_steps_text,$you_are_here_text);
		if ($order_step==$max_order_step)
		{
			$order_step_text=$you_are_here_text;
			unset($_SESSION[$step_start_text]);
		}
		else
		{
			$order_step_text=sprintf($you_are_here_text,($max_order_step_1-$order_step),$order_step.DOT.BLANK.$order_step_text);
		}
		$box_smarty->assign('step_text',$order_step_text);
		$box_content= $box_smarty->fetch(CURRENT_TEMPLATE_BOXES.$box_template.HTML_EXT,$cacheid);
		$smarty->assign('ORDER_STEPS',$box_content);
		if ($order_step==0)
		{
			if (OL_COMMERCE)
			{
				include(FILENAME_LOGIN);
				olc_exit();
			}
		}
	}
}
if (OL_COMMERCE)
{
	if (NOT_IS_AJAX_PROCESSING)
	{
		if (IS_LOCAL_HOST)
		{
			include('pagepeel.php');
		}
	}
	$first_page=sizeof($breadcrumb->_trail)<=1;
	if ($first_page)
	{
		$first_page=strpos(CURRENT_SCRIPT,'index')!==false;
	}
	$smarty->assign('first_page',$first_page);
}
?>