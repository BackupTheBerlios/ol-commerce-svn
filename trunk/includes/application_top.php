<?php
/* -----------------------------------------------------------------------------------------
$Id: application_top.php,v 1.1.1.3.2.1 2007/04/08 07:17:43 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(application_top.php,v 1.273 2003/05/19); www.oscommerce.com
(c) 2003	    nextcommerce (application_top.php,v 1.54 2003/08/25); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//W. Kaiser - AJAX
//"IS_AJAX_PROCESSING_FORCED" indicates redirection or "application_top" already executed!
if (defined('MAIN_CONTENT') || defined('IS_AJAX_PROCESSING_FORCED'))
{
	// include the breadcrumb class and start the breadcrumb trail
	$session_started=true;
	if (!is_object($breadcrumb))
	{
		require_once(DIR_WS_CLASSES . 'breadcrumb.php');
		$breadcrumb = new breadcrumb;
		$breadcrumb->add(HEADER_TITLE_TOP, olc_href_link(FILENAME_DEFAULT));
		include(DIR_FS_INC.'olc_prepare_breadcrumb.php');
	}
	//Include Smarty class
	//global $smarty;
	if (!is_object($smarty))
	{
		olc_smarty_init($smarty,$cacheid);
	}
}
else
{
	define('IS_LOCAL_HOST',file_exists('d:\vb6\C2.EXE'));
	if (!isset($seo_processing))
	{
		$seo_processing=false;
	}
	$not_seo_processing=!$seo_processing;
	$PHP_SELF = $_SERVER['PHP_SELF'];
	/*
	if ($not_seo_processing)
	{
	$not_seo_processing=strpos($PHP_SELF,'elmar')===false;
	}
	*/
	if ($not_seo_processing)
	{
		define('PHP','.php');
		define('INC_PHP','.inc.php');
		$IsUserMode=true;  //E_ERROR && ~E_STRICT
		if (IS_LOCAL_HOST)
		{
			//local host --> full error reporting
			error_reporting(E_ERROR || E_WARNING);
		}
		else
		{
			//remote host --> reduced error reporting
			error_reporting(E_ERROR);
		}
		define('ADMIN_PATH_PREFIX','');
		include('includes/configure.php');
		define('IS_ADMIN_FUNCTION',false);
		define('NOT_IS_ADMIN_FUNCTION',true);
		define('USE_AJAX_ADMIN',false);
		require_once(DIR_FS_INC.'olc_get_all_get_params.inc.php');
		require_once(DIR_WS_INCLUDES . 'filenames.php');
		require_once(DIR_FS_INC.'olc_get_products_name.inc.php');
		require_once(DIR_FS_INC.'olc_paypal_wpp_enabled.inc.php');
		require_once(DIR_FS_INC.'olc_update_whos_online.inc.php');

		//Elements with no AJAX activity. Leave "update_whois" in first position!!
		//$no_ajax_activity=array("update_whos","elmar_","pdf_","export","inci");
		//$no_ajax_activity=array("update_whos","elmar_","export","inci");
		$no_ajax_activity=array("update_whos","elmar_","inci");
		$start_ajax=true;
		$update_whois=false;
		for ($i=0,$n=sizeof($no_ajax_activity);$i<$n;$i++)
		{
			if (strpos($PHP_SELF,$no_ajax_activity[$i])!==false)
			{
				$start_ajax=false;
				$update_whois=$i==0;
				break;
			}
		}
		if (!$start_ajax)
		{
			define("USE_AJAX", false);		//Do not use AJAX
			define("IS_AJAX_PROCESSING", false);
			define("DO_AJAX_VALIDATION", false);
			define("NOT_USE_AJAX", true);
			define("NOT_IS_AJAX_PROCESSING", true);
		}
		define('START_AJAX',$start_ajax);
		require(DIR_WS_MODULES .'application_init.php');
		if ($start_ajax)
		{
			if ($not_is_spider_visit)
			{
				olc_update_whos_online($_GET['url']);
			}
			if ($update_whois)
			{
				echo AJAX_NODATA;
			}
			elseif (!defined('SHOW_COOL_MENU'))
			{
				define('SHOW_COOL_MENU',false);
			}
			if (SHOW_COOL_MENU==TRUE_STRING_S)
			{
				if (USE_AJAX)
				{
					$cat_sql=SELECT."categories_id from ".TABLE_CATEGORIES." LIMIT 1";
					$cat_query=olc_db_query($cat_sql);
					$show_cool_menu=olc_db_num_rows($cat_query)>0;
				}
			}
		}
		define('SHOW_COOL_MENU',$show_cool_menu);
		define('USE_DHTML_HISTORY',true);

		// include used functions (not contained in common "application_init.php")
		require_once(DIR_FS_INC.'create_coupon_code.inc.php');
		require_once(DIR_FS_INC.'olc_activate_banners.inc.php');
		require_once(DIR_FS_INC.'olc_check_stock_attributes.inc.php');
		require_once(DIR_FS_INC.'olc_count_cart.inc.php');
		require_once(DIR_FS_INC.'olc_currency_exists.inc.php');
		//W. Kaiser - AJAX
		require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
		require_once(DIR_FS_INC.'olc_get_prid.inc.php');
		require_once(DIR_FS_INC.'olc_draw_form.inc.php');
		require_once(DIR_FS_INC.'olc_get_products_price.inc.php');
		require_once(DIR_FS_INC.'olc_draw_input_field.inc.php');
		require_once(DIR_FS_INC.'olc_draw_submit_button.inc.php');
		require_once(DIR_FS_INC.'olc_image_submit.inc.php');
		require_once(DIR_FS_INC.'olc_get_products_attribute_price.inc.php');
		//W. Kaiser - AJAX
		require_once(DIR_FS_INC.'olc_draw_separator.inc.php');
		require_once(DIR_FS_INC.'olc_expire_banners.inc.php');
		require_once(DIR_FS_INC.'olc_expire_specials.inc.php');
		require_once(DIR_FS_INC.'olc_get_parent_categories.inc.php');
		require_once(DIR_FS_INC.'olc_get_product_path.inc.php');
		require_once(DIR_FS_INC.'olc_get_products_attribute_price.inc.php');
		require_once(DIR_FS_INC.'olc_get_qty.inc.php');
		require_once(DIR_FS_INC.'olc_get_tax_rate_from_desc.inc.php');
		require_once(DIR_FS_INC.'olc_get_uprid.inc.php');
		require_once(DIR_FS_INC.'olc_gv_account_update.inc.php');
		require_once(DIR_FS_INC.'olc_has_product_attributes.inc.php');
		require_once(DIR_FS_INC.'olc_href_link.inc.php');
		require_once(DIR_FS_INC.'olc_onclick_link.inc.php');
		require_once(DIR_FS_INC.'olc_image.inc.php');
		require_once(DIR_FS_INC.'olc_parse_category_path.inc.php');
		require_once(DIR_FS_INC.'olc_redirect.inc.php');
		require_once(DIR_FS_INC.'olc_remove_non_numeric.inc.php');
		olc_smarty_init($smarty,$cacheid);
		// include shopping cart class
		require_once($catalog_class_dir. 'shopping_cart.php');

		if (CURRENT_SCRIPT==FILENAME_DEFAULT)
		{
			include(DIR_FS_INC.'olc_get_slideshows.inc.php');
		}
		// include the breadcrumb class and start the breadcrumb trail
		require_once(DIR_WS_CLASSES . 'breadcrumb.php');
		$breadcrumb = new breadcrumb;
		$breadcrumb->add(HEADER_TITLE_TOP, olc_href_link(FILENAME_DEFAULT));
		if (SHOW_CHANGE_SKIN)
		{
			if (!$_SESSION['template_check'])
			{
				//Check for more templates
				$_SESSION['template_check']=true;
				$templates_dir=TEMPLATE_PATH;
				$illegal_templates=CURRENT_TEMPLATE.'CVS.common.powertemplates';
				$templates_count=0;
				$dh  = opendir($templates_dir);
				while ($this_template = readdir($dh))
				{
					if (substr($this_template,0,1)<>DOT)
					{
						if ($this_template<>UNDERSCORE)
						{
							if (strpos($illegal_templates,$this_template)===false)
							{
								$templates_count++;
							}
						}
					}
				}
				closedir($dh);
				$_SESSION['template_change']=$templates_count>0;
			}
		}
		else
		{
			$_SESSION['template_change']=false;
		}
		// if gzip_compression is enabled, start to buffer the output
		if (PHP_VERSION >= '4')
		{
			if (GZIP_COMPRESSION == TRUE_STRING_S)
			{
				if ($ext_zlib_loaded = extension_loaded('zlib'))
				{
					if (($ini_zlib_output_compression = (int)ini_get('zlib.output_compression')) < 1)
					{
						ob_start('ob_gzhandler');
					}
					else
					{
						ini_set('zlib.output_compression_level', GZIP_LEVEL);
					}
				}
			}
		}
	}
}
if (START_AJAX)
{
	//require(ADMIN_PATH_PREFIX.DIR_WS_INCLUDES.'ajax.php');
	$action_text='action';
	$action=$_GET[$action_text];
	if ($action==EMPTY_STRING)
	{
		$action=$_POST[$action_text];
	}
	if ($action)
	{
		// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled
		if (!$session_started)
		{
			olc_redirect(olc_href_link(FILENAME_COOKIE_USAGE));
		}
		if (CURRENT_SCRIPT<>FILENAME_LOGIN && CURRENT_SCRIPT<>FILENAME_LOGOFF)
		{
			if (!isset($_GET['gallery']))
			{
				$display_cart=DISPLAY_CART == TRUE_STRING_S;
			}
			$products_id_text='products_id';
			$pid_text='pid';
			$products_id=$_POST[$products_id_text];
			if ($products_id==EMPTY_STRING)
			{
				$products_id=$_GET[$products_id_text];
			}
			//$products_id=(int)$products_id;
			if ($display_cart)
			{
				$goto =  FILENAME_SHOPPING_CART;
				$parameters = array($action_text, $pid_text, $products_id_text, 'cPath');
			}
			else
			{
				$goto = CURRENT_SCRIPT;
				if ($action == 'buy_now')
				{
					$parameters = array($action_text, $pid_text, $products_id_text);
				}
				else
				{
					$parameters = array($action_text, $pid_text);
				}
			}
			$is_cart_function=false;
			$id=$_POST['id'];
			switch ($action)
			{
				//W. Kaiser - AJAX
				// customer wants to update the product quantity in their shopping cart
				case 'update_product':
					$post_cart_delete=$_POST['cart_delete'];
					if (!is_array($post_cart_delete))
					{
						$post_cart_delete = array();
					}
					$post_products_id=$_POST['products_id'];
					for ($i = 0, $n = sizeof($post_products_id); $i < $n; $i++)
					{
						$current_post_products_id=$post_products_id[$i];
						if (in_array($current_post_products_id, $post_cart_delete))
						{
							$_SESSION['cart']->remove($current_post_products_id);
						}
						else
						{
							$attributes = $id[$current_post_products_id];
							$products_qty=max($_POST['cart_quantity'][$i],$_POST['cart_min_quantity'][$i]);
							$_SESSION['cart']->add_cart($current_post_products_id,
							olc_remove_non_numeric($products_qty), $attributes, false);
						}
					}
					$_SESSION['cart_modified']=true;
					$_SESSION['products_id_full']=olc_get_uprid($products_id, $id);
					if (IS_AJAX_PROCESSING && !$display_cart)
					{
						$force_cart_update_only=true;
						return;
					}
					else
					{
						olc_redirect(olc_href_link($goto, olc_get_all_get_params($parameters)));
					}
					break;

					// customer adds a product from the products page
				case 'add_product':
					//W. Kaiser - AJAX
					//Mod for local change of # of products in cart. Do not add
					$is_local_processing=$_GET['force_quantity']==true;		//Changing quantity in cart
					if ($is_local_processing)
					{
						$quantity_in_cart=0;
					}
					else
					{
						$quantity_in_cart=$_SESSION['cart']->get_quantity(olc_get_uprid($products_id,$id));
					}
					if (is_numeric($products_id))
					{
						$products_qty=max($_POST['products_qty'],$_POST['products_min_order_quantity']);
						if ($products_qty>MAX_PRODUCTS_QTY)
						{
							$products_qty=MAX_PRODUCTS_QTY;
						}
						$_SESSION['cart']->add_cart($products_id,$quantity_in_cart+$products_qty, $id);
					}
					if ($is_local_processing && isset($_GET['cart_no_show']))
					{
						//We do not need to return any real data, as the cart is updated locally!!!
						echo "AJAX-NODATA";
						olc_exit();
					}
					else
					{
						$_SESSION['cart_modified']=true;
						if (IS_AJAX_PROCESSING && !$display_cart)
						{
							$force_cart_update_only=true;
							return;
						}
						else
						{
							$_SESSION['products_id_full']=olc_get_uprid($products_id, $id);
							olc_redirect(olc_href_link($goto, olc_get_all_get_params($parameters)));
							break;
						}
					}
					//W. Kaiser - AJAX
				case 'check_gift':
					require_once(DIR_FS_INC.'olc_collect_posts.inc.php');
					olc_collect_posts();
					break;
					// customer wants to add a quickie to the cart (called from a box)
				case 'add_a_quickie' :
					if (DO_GROUP_CHECK)
					{
						$group_check=" and ".SQL_GROUP_CONDITION;
					}
					$post_quickie=$_POST['quickie'];
					$quickie_query_sql="
					select
					products_fsk18,
					products_id from " . TABLE_PRODUCTS . "
					where products_model #" . $post_quickie . "' ".$group_check;
					$quickie_query = olc_db_query(str_replace(HASH,"= '",$quickie_query_sql));
					$rows=olc_db_num_rows($quickie_query);
					if ($rows==0)
					{
						$quickie_query = olc_db_query(str_replace(HASH,"LIKE '%",$quickie_query_sql));
						$rows=olc_db_num_rows($quickie_query);
					}
					if ($rows>1)
					{
						$redirect_url=olc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'keywords='.$post_quickie);
					}
					elseif ($rows==1)
					{
						$quickie_data = olc_db_fetch_array($quickie_query);
						$products_id=$quickie_data[$products_id_text];
						$products_id_parameter='products_id=' . $products_id;

						$redirect_url=olc_href_link(FILENAME_PRODUCT_INFO, $products_id_parameter);

						if (!olc_has_product_attributes($products_id))
						{
							if ($quickie_data['products_fsk18']==1)
							{
								if (CUSTOMER_NOT_IS_FSK18)
								{
									if (CUSTOMER_IS_FSK18_DISPLAY)
									{
										$add_to_cart=true;
									}
								}
							}
							else
							{
								$add_to_cart=true;
							}
							if ($add_to_cart)
							{
								$_SESSION['cart']->add_cart($products_id, 1);
								$redirect_url=olc_href_link($goto, olc_get_all_get_params(array($action_text)));
							}
						}
					}
					elseif (IS_AJAX_PROCESSING)
					{
						$error_message=sprintf(TEXT_NO_PRODUCT,TEXT_ARTICLE_NR,$post_quickie);
						ajax_error($error_message,true,EMPTY_STRING);
					}
					olc_redirect($redirect_url);
					break;

					// performed by the 'buy now' button in product listings and review page
				case 'buy_now':
					//
					// W. Kaiser - Allow search by product_model
					//
					$id_text='BUYproducts_id';
					$BUYproduct=$_GET[$id_text];
					if ($BUYproduct == EMPTY_STRING)
					{
						$model_text='BUYproducts_model';
						$BUYproduct=$_GET[$model_text];
						if ($BUYproduct == EMPTY_STRING)
						{
							$BUYproduct=$_POST[$id_text];
							if ($BUYproduct == EMPTY_STRING)
							{
								$BUYproduct=$_POST[$model_text];
								$UseProducts_model=true;
							}
						}
						else
						{
							$UseProducts_model=true;
						}
						$id_text=$model_text;
					}
					if ($UseProducts_model)
					{
						$type=TEXT_ARTICLE_NR;
						$CheckField="model";
					}
					else
					{
						$type=TEXT_ARTICLE_ID;
						$CheckField="id";
					}
					if ($BUYproduct <> EMPTY_STRING)
					{
						// check permission to view product
						$CheckField="products_".$CheckField."='".$BUYproduct.APOS;
						$permission_query=
						SELECT."group_ids, products_id, products_price, products_uvp, products_min_order_quantity, products_date_available".
						SQL_FROM. TABLE_PRODUCTS.SQL_WHERE.$CheckField;
						$permission_query=olc_db_query($permission_query);
						$permission=olc_db_fetch_array($permission_query);
						if ($permission)
						{
							$buy_ok=$permission['products_price']>0;
							if ($buy_ok)
							{
								$products_date_available=EMPTY_STRING;
							}
							else
							{
								$products_date_available=$permission['products_date_available'];
								if (empty($products_date_available))
								{
									$buy_ok=true;
								}
								else
								{
									$buy_ok=false;
									if (strpos($products_date_available,'0000') == false)	//Empty date
									{
										if (strtotime($products_date_available) <= strtotime(date('Y-m-d')))
										{
											$buy_ok=true;
											$products_date_available=EMPTY_STRING;		//Outdated! Reset date
										}
									}
								}
							}
							$BUYproduct=$permission[$products_id_text];
							if ($buy_ok)
							{
								$link=olc_href_link(FILENAME_PRODUCT_INFO,
								olc_get_all_get_params(array('products_id','action',$id_text)).str_replace(APOS,EMPTY_STRING,$CheckField));
								if (DO_GROUP_CHECK)
								{
									if (strpos($permission['group_ids'],'c_'.CUSTOMER_STATUS_ID.'_group')===false)
									{
										if (IS_AJAX_PROCESSING)
										{
											$error_message=TEXT_NO_PERMISSION;
											$permission=false;
										}
									}
									/*
									else
									{
										if (NOT_IS_AJAX_PROCESSING)
										{
											define('FORCE_PRODUCT_INFO_DISPLAY',true);
											olc_redirect($link);
										}
									}
									*/
								}
								if (isset($_GET['gallery']) || olc_has_product_attributes($BUYproduct))
								{
									define('FORCE_PRODUCT_INFO_DISPLAY',true);
									olc_redirect($link);
								}
								else
								{
									$products_min_order_quantity=max(1,$permission['products_min_order_quantity']);
									$_SESSION['cart']->add_cart($BUYproduct,
									$_SESSION['cart']->get_quantity($BUYproduct)+$products_min_order_quantity);
									$_SESSION['cart_modified']=true;
								}
							}
							else
							{
								$products_name=str_replace(HTML_AMP,AMP,olc_get_products_name($permission['products_id']));
								$error_message=sprintf(TEXT_SOLD_OUT,$products_name);
								if (strlen($products_date_available)>0)
								{
									require_once(DIR_FS_INC.'olc_date_short.inc.php');
									$product_available=str_replace(HTML_B_START,EMPTY_STRING,sprintf(TEXT_DATE_AVAILABLE,
									olc_date_short($products_date_available)));
									$error_message.="\n\n".str_replace(HTML_B_END,EMPTY_STRING,$product_available);
								}
							}
						}
						else
						{
							$error_message=sprintf(TEXT_NO_PRODUCT,$type,$BUYproduct);
						}
					}
					else
					{
						$error_message=sprintf(TEXT_NR_REQUIRED,$type);
					}
					if (strlen($error_message)>0)
					{
						if (IS_AJAX_PROCESSING)
						{
							ajax_error($error_message,true,EMPTY_STRING);
						}
					}
					//
					// W. Kaiser - Allow search by product_model
					//
					if (IS_AJAX_PROCESSING && !$display_cart)
					{
						$force_cart_update_only=true;
						return;
					}
					else
					{
						olc_redirect(olc_href_link($goto, olc_get_all_get_params(array($action_text))));
					}
					break;
				case 'notify':
					if (CUSTOMER_ID>0)
					{
						if ($products_id!=EMPTY_STRING)
						{
							$notify = $products_id;
						} elseif (isset($_GET[$action])) {
							$notify = $_GET[$action];
						} elseif (isset($_POST[$action])) {
							$notify = $_POST[$action];
						}
						if ($notify!=EMPTY_STRING) {
							if (!is_array($notify)) $notify = array($notify);
							for ($i = 0, $n = sizeof($notify); $i < $n; $i++) {
								$check_query = olc_db_query(SELECT_COUNT."as count from " . TABLE_PRODUCTS_NOTIFICATIONS .
								" where products_id = '" . $notify[$i] . "' and customers_id = '" . INT_CUSTOMER_ID . APOS);
								$check = olc_db_fetch_array($check_query);
								if ($check['count'] < 1) {
									olc_db_query(INSERT_INTO . TABLE_PRODUCTS_NOTIFICATIONS .
									" (products_id, customers_id, date_added) values ('" . $notify[$i] .
									"', '" .INT_CUSTOMER_ID . "', now())");
								}
							}
						}
						olc_redirect(olc_href_link(CURRENT_SCRIPT, olc_get_all_get_params(array($action_text, $action))));
					} else {
						olc_redirect(olc_href_link(FILENAME_LOGIN));
					}
					break;
				case 'notify_remove':
					if (CUSTOMER_ID>0 && $products_id!=EMPTY_STRING)
					{
						$sql_where=" from " . TABLE_PRODUCTS_NOTIFICATIONS . " where products_id = '" . $products_id .
						"' and customers_id = '" . INT_CUSTOMER_ID . APOS;
						$check_query = olc_db_query(SELECT_COUNT."as count" . $sql_where);
						$check = olc_db_fetch_array($check_query);
						if ($check['count'] > 0) {
							olc_db_query("delete".$sql_where);
						}
						olc_redirect(olc_href_link(CURRENT_SCRIPT,
						olc_get_all_get_params(array($action_text,'notify_remove'))));
					} else {

						olc_redirect(olc_href_link(FILENAME_LOGIN));
					}
					break;
				case 'cust_order':
					$pid=(int)$_GET[$pid_text];
					if (isset($_SESSION['customer_id']) && $pid) {
						if (olc_has_product_attributes($pid)) {
							olc_redirect(olc_href_link(FILENAME_PRODUCT_INFO, $products_id_text.'='. $pid));
						} else {
							$_SESSION['cart']->add_cart($pid, $_SESSION['cart']->get_quantity($pid)+1);
						}
					}
					olc_redirect(olc_href_link($goto, olc_get_all_get_params($parameters)));
					break;
			}
		}
	}
	if ($not_seo_processing)
	{
		// infobox
		require_once(DIR_WS_CLASSES . 'boxes.php');
		// auto activate and expire banners
		olc_activate_banners();
		olc_expire_banners();
		// auto expire special products
		olc_expire_specials();
		include(DIR_FS_INC.'olc_prepare_breadcrumb.php');
		if (!is_object($messageStack))
		{
			// initialize the message stack for output messages
			require_once(DIR_WS_CLASSES . 'message_stack.php');
			$messageStack = new messageStack;
		}
		// modification for nre graduated system
		unset($_SESSION['actual_content']);
		olc_count_cart();
		if (SHOW_AFFILIATE)
		{
			// inclusion for affiliate program
			include('affiliate_application_top.php');
		}
	}
}

?>