<?php
/* -----------------------------------------------------------------------------------------
$Id: Smarty.class.php,v 1.1.1.1.2.1 2007/04/08 07:17:49 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2007 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

All rights reserved!

Not(!) released under the GNU General Public License

Subclass "Smarty" class, in order to implement some different Smarty behaviours needed for AJAX

-----------------------------------------------------------------------------------------*/

/*
$smarty_std_class='std_Smarty.class.php';
$smarty_dir=$_SESSION[SMARTY_DIR];
if (isset($smarty_dir))
{
$hack_smarty=false;
}
else
{
$smarty_dir_file=DIR_FS_CATALOG.'smarty_dir.txt';
if (is_file($smarty_dir_file))
{
$smarty_dir=trim(file_get_contents($smarty_dir_file));
$std_smarty_file=$smarty_dir.$smarty_std_class;
$hack_smarty=filemtime($std_smarty_file)>filemtime($smarty_dir_file);
}
else
{
$hack_smarty=true;
}
}
if ($hack_smarty)
{
include_once(TEMPLATE_PATH.'olc/inc/olc_smarty_hack.inc.php');
}
else
{
$std_smarty_file=$smarty_dir.$smarty_std_class;
include_once($std_smarty_file);
$_SESSION[SMARTY_DIR]=$smarty_dir;
}
*/
if (!defined('EMPTY_STRING'))
{
	include_once('templates/olc/inc/olc_define_global_constants.inc.php');
	define('ADMIN_PATH_PREFIX',EMPTY_STRING);
}
if (!class_exists('std_Smarty'))
{
	$std_smarty_file=ADMIN_PATH_PREFIX.DIR_WS_CLASSES.'Smarty_2.6.14/std_Smarty.class.php';
	include_once($std_smarty_file);

	class Smarty extends std_Smarty
	{

		function Smarty()
		{
			$this->assign('SCRIPT_NAME', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME']
			: @$GLOBALS['HTTP_SERVER_VARS']['SCRIPT_NAME']);
			if (!defined('PROJECT_VERSION'))
			{
				//Not running from olCommerce!
				global $cacheid;
				olc_smarty_init($this,$cacheid);
			}
			$this->_tpl_vars[''];
		}

		function assign($tpl_var, $value = null)
		{
			if (is_array($tpl_var))
			{
				foreach ($tpl_var as $key => $val)
				{
					if ($key != EMPTY_STRING)
					{
						$this->_tpl_vars[$key] = $val;
					}
				}
			}
			else
			{
				if ($tpl_var != EMPTY_STRING)
				{
					if (strpos($tpl_var,BOX)!==false)
					{
						if (USE_LAYOUT_DEFINITION==TRUE_STRING_S)
						{
							if (strpos($tpl_var,BOX_CONTENT)===false)
							{
								global $box_relations;

								$comment=$tpl_var;
								$new_tpl_var=$box_relations[$tpl_var];
								if ($new_tpl_var)
								{
									$tpl_var=$new_tpl_var;
									$comment.=LPAREN.$new_tpl_var.RPAREN;
								}
								$comment=str_replace(ATSIGN,$comment,COMMENT);
								$value=str_replace(HASH,BEGIN,$comment).$value.str_replace(HASH,END,$comment);
							}
						}
					}
					$this->_tpl_vars[$tpl_var] = $value;
				}
			}
		}

		function _get_auto_filename($auto_base, $auto_source = null, $auto_id = null)
		{
			//Unified templates concept requires differentiation of real template and common template
			//So we must check, if we are using a "common" template, and store it in "common" directory
			$change_auto_base=true;
			if (strpos($auto_source,HTML_EXT)!==false)
			{
				if (strpos($auto_source,COMMON_TEMPLATE)!==false)
				{
					$auto_base=TEMPLATE_C_PATH.COMMON_TEMPLATE;
					$change_auto_base=false;
				}
			}
			if ($change_auto_base)
			{
				$auto_base.=SLASH;
			}
			$_compile_dir_sep =  $this->use_sub_dirs ? SLASH : '^';
			$_return = $auto_base; // . DIRECTORY_SEPARATOR;
			if (isset($auto_id))
			{
				// make auto_id safe for directory names
				$auto_id = str_replace('%7C',$_compile_dir_sep,(urlencode($auto_id)));
				// split into separate directories
				$_return .= $auto_id . $_compile_dir_sep;
			}
			if (isset($auto_source))
			{
				// make source name safe for filename
				$_filename = urlencode(basename($auto_source));
				$_filename_1=explode('%7C',$_filename);
				$_filename_2=$_filename_1[0];
				$_crc32=$_filename_1[1];
				if ($_crc32)
				{
					$_filename_2.=UNDERSCORE.$_crc32;
				}
				$_crc32 = sprintf('%08X', crc32($auto_source));
				// prepend %% to avoid name conflicts with
				// with $params['auto_id'] names
				$_crc32 = substr($_crc32, 0, 2) . $_compile_dir_sep .
				substr($_crc32, 0, 3) . $_compile_dir_sep . $_crc32;
				//$_return .= '%%' . $_crc32 . '%%' . $_filename;
				$_return .= $_filename_2 . UNDERSCORE. '%%' . $_crc32 . '%%' . $_filename;
			}
			return $_return;
		}

		/**
	 * executes & returns or displays the template results
	 *
	 * @param string $resource_name
	 * @param string $cache_id
	 * @param string $compile_id
	 * @param boolean $display
	 */

		function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
		{
			$is_top_form=!(strpos($resource_name, INDEX_HTML)===false);
			$is_ajax_processing_forced=defined('IS_AJAX_PROCESSING_FORCED');
			if ($is_top_form)
			{
				if (!defined('RM')) $this->load_filter('output', 'note');
				if (!IS_ADMIN_FUNCTION)
				{
					$this->assign('USE_LAYOUT_DEFINITION',USE_LAYOUT_DEFINITION);
					//Save last context
					if (strpos(FILENAME_LOGIN.FILENAME_LOGOFF.FILENAME_LOGOUT.FILENAME_AJAX_VALIDATION,CURRENT_SCRIPT)===false)
					{
						$navigation='navigation';
						if (is_object($_SESSION[$navigation]))
						{
							$_SESSION[$navigation]->set_snapshot();
						}
					}
				}
				//W. Kaiser - AJAX
			}
			else
			{
				/*
				if ($tpl_var==MAIN_CONTENT)
				{
				$tpl_var=$tpl_var;
				}
				*/
				if (strpos($resource_name,CURRENT_TEMPLATE_BOXES)!==false)
				{
					if (USE_LAYOUT_DEFINITION==TRUE_STRING_S)
					{
						global $box_relations;
						$s=basename($resource_name,HTML_EXT);
						$s=BOX.strtoupper(substr($s,strlen(BOX)));
						$s=$box_relations[$s];
						if ($s)
						{
							$s1=substr($s,strlen(BOX),1);
							switch ($s1)
							{
								case BOX_NAV_AREA_MIDDLE:
									$s1=BOX_NAV_CLASS_MIDDLE;
									break;
								case BOX_NAV_AREA_RIGHT:
									$s1=BOX_NAV_CLASS_RIGHT;
									break;
								default:
									$s1=BOX_NAV_CLASS_LEFT;
									break;
							}
							$this->_tpl_vars[BOX_NAV_CLASS]=$s1;
						}
					}
					else
					{
						$this->_tpl_vars[BOX_NAV_CLASS]=BOX_NAV_CLASS_LEFT;
					}
				}
				//Unified templates
				//Check if resource is available in the individual templates' directory
				//If not, use resource from common template directory
				$template_path=ADMIN_PATH_PREFIX.TEMPLATE_PATH;
				$s='CHECK_UNIFIED_TEMPLATES';
				if (!defined($s))
				{
					define('COMMON_TEMPLATE','olc'.SLASH);
					define('TEMPLATE_PATH',$this->template_dir.SLASH);
					define('FULL_COMMON_TEMPLATE',TEMPLATE_PATH.COMMON_TEMPLATE);
					define($s,USE_UNIFIED_TEMPLATES!=false && is_dir($template_path.COMMON_TEMPLATE.'boxes'));
				}
				if (CHECK_UNIFIED_TEMPLATES)
				{
					$resource_name_short=basename($resource_name);
					$have_individual_resource=$_SESSION[$resource_name_short];
					if (!isset($have_individual_resource))
					{
						$have_individual_resource=is_file($template_path.$resource_name);
						$_SESSION[$resource_name_short]=$have_individual_resource;
					}
					if (!$have_individual_resource)
					{
						$resource_name=str_replace(CURRENT_TEMPLATE.SLASH,COMMON_TEMPLATE,$resource_name);
					}
				}
				//Unified templates
			}
			if (IS_AJAX_PROCESSING || $is_ajax_processing_forced)
			{
				global $use_ajax_short_list;
				if ($is_top_form)
				{
					$force_build_all=defined('AJAX_REBUILD_ALL');
					$index="x";				//Set dummy element.  M u s t  be retained!!!!
					$html_text = EMPTY_STRING;
					//
					//For outputting debug-info, this has to be stored in "$_SESSION[DEBUG_OUPUT]"
					//
					if ($force_build_all)
					{
						$screen_areas= array();
						while (list($key, $value) = each($this->_tpl_vars))
						{
							$include_area=strpos($key,BOX)!==false;
							if (!$include_area)
							{
								$include_area=!(strpos(AJAX_DATA_ELEMENTS_TO_CHANGE,$key)===false);
							}
							if ($include_area)
							{
								$screen_areas[]=$key;
							}
						}
					}
					elseif ($use_ajax_short_list && !defined('FORCE_PRODUCT_INFO_DISPLAY'))
					{
						$screen_areas = explode(BLANK, AJAX_SHORT_LIST);
					}
					else
					{
						$not_slide_show_only=AJAX_DATA_ELEMENTS_TO_CHANGE<>EMPTY_STRING;
						if ($not_slide_show_only)
						{
							$screen_areas = explode(BLANK, AJAX_DATA_ELEMENTS_TO_CHANGE);
						}
						else
						{
							$screen_areas = array();
						}
						global $slideshow_id;

						$n=sizeof($slideshow_id);
						if ($n>0)
						{
							$box=BOX.'SLIDESHOW_';
							for ($i=0;$i<$n;$i++)
							{
								if ($slideshow_id[$i])
								{
									$screen_areas[]=$box.$i;
								}
							}
						}
					}
					$elements = count($screen_areas);
					$s=$_SESSION[DEBUG_OUPUT];
					$check_debug_output=isset($s) && $s<>EMPTY_STRING;
					$newline=NEW_LINE.HTML_BR;
					for ($i = 0; $i < $elements; $i++)
					{
						$screen_area = $screen_areas[$i];
						if ($screen_area)
						{
							$text = trim($this->_tpl_vars[$screen_area]);
							if ($screen_area==MAIN_CONTENT)
							{
								if ($check_debug_output)
								{
									//Output debugging output in "main_content"
									$all='<span class="main">'.$_SESSION[DEBUG_OUPUT].'</span>';
									$text=HTML_HR.HTML_B_START."Debug-Output".HTML_B_END.HTML_HR.$all.HTML_HR.$newline.$text;
									unset($_SESSION[DEBUG_OUPUT]);
								}
								if (NOT_IS_ADMIN_FUNCTION)
								{
									global $messageStack;
									if (is_object($messageStack))
									{
										$all="*";
										$m=$messageStack->size($all);
										if ($m > 0)
										{
											//Add messagestackinfo
											$text=$messageStack->output($all).HTML_HR.$newline.$text;
										}
									}
								}
							}
							if (strlen($text)>0)
							{
								if (AJAX_BUILD_INDEX)
								{
									if (strpos($index ,$screen_area)===false)
									{
										$index .= BLANK.$screen_area;
									}
									else
									{
										continue;
									}
								}
								$screen_area = HASH.$screen_area.HASH;
								$html_text .= $screen_area . $text . $screen_area . $newline;
							}
						}
					}
					if (strlen($html_text))
					{
						if ($not_slide_show_only)
						{
							$add_on_areas=array();
							$ajax_title='AJAX_TITLE';
							$add_on_areas[]=array(
							'name'=>'AJAX_TITLE',
							'ajax_name'=>'title',
							'index'=>false);
							$add_on_areas[]=array(
							'name'=>'PARSE_TIME',
							'ajax_name'=>EMPTY_STRING,
							'index'=>true);
							$add_on_areas[]=array(
							'name'=>'BANNER',
							'ajax_name'=>EMPTY_STRING,
							'index'=>true);
							$info_message='INFO_MESSAGE';
							$add_on_areas[]=array(
							'name'=>$info_message,
							'ajax_name'=>INFO_MESSAGE,
							'index'=>false);
							$smarty_force_display='SMARTY_FORCE_DISPLAY';
							$add_on_areas[]=array(
							'name'=>$smarty_force_display,
							'ajax_name'=>EMPTY_STRING,
							'index'=>true);
							if (CURRENT_SCRIPT<>'ajax_validation.php')
							{
								include_once(DIR_FS_INC.'olc_get_parse_time.inc.php');
							}
							for ($i=0,$n=sizeof($add_on_areas)-1;$i<=$n;$i++)
							{
								$add_on_area=$add_on_areas[$i];
								$constant =$add_on_area['name'];
								if (defined($constant))
								{
									$text=constant($constant);
									if (strlen($text)>0)
									{
										switch ($constant)
										{
											case $ajax_title:
												$text=str_replace(HTML_BR,BLANK,$text);
												break;
											case $info_message;
											$text=$_SESSION[INFO_MESSAGE];
											unset($_SESSION[INFO_MESSAGE]);
											break;
											case $smarty_force_display:
												$constant=$text;
												$text=$this->_tpl_vars[$text];
												break;
										}
										$area_name=$add_on_area['ajax_name'];
										if (!$area_name)
										{
											$area_name=$constant;
										}
										$area_name =  HASH.$area_name.HASH;
										if ($add_on_area['index'])
										{
											$index .= BLANK.$constant;
										}
										$html_text = $area_name .$text . $area_name . $newline . $html_text;
									}
								}
							}
							$const_ajax_script_name0="AJAX_SCRIPT_";
							$i=0;
							while (true)
							{
								$i++;
								$const_ajax_script_name=$const_ajax_script_name0.$i;
								if (defined($const_ajax_script_name))
								{
									$ajax_script=constant($const_ajax_script_name);
									if (strlen($ajax_script)>0)
									{
										$screen_area = HASH.strtolower($const_ajax_script_name).HASH;
										$html_text = $screen_area . $ajax_script . $screen_area . $newline . $html_text;
									}
								}
								else
								{
									break;
								}
							}
							if (defined('STICKY_CART_VISIBLE'))
							{
								$sticky_cart="sticky_cart";
								$sticky_cart_delimiter=HASH.$sticky_cart.HASH;
								$html_text =
								$sticky_cart_delimiter.STICKY_CART_VISIBLE.$sticky_cart_delimiter.$newline.$html_text;
							}
							$validator_required="";
							switch (CURRENT_SCRIPT)
							{
								case FILENAME_CREATE_ACCOUNT:
									//Signal validation of Vorname and Plz required
									$validator_required="vorname_plz";
									break;
								case FILENAME_CHECKOUT_PAYMENT:
									if ($_SESSION['credit_covers']!=true)
									{
										//Signal validation of BLZ and account-number required
										$validator_required="blz_konto";
									}
									break;
								case FILENAME_PRODUCT_INFO:
									$products_id=$_GET['cart_line'];
									if (strlen($products_id))
									{
										$products_id.="|".$_GET['products_id'];
										$validator_delimiter=HASH."product_options".HASH;
										$html_text=$validator_delimiter.$products_id.$validator_delimiter.$newline.$html_text;
									}
									break;
							}
							if ($validator_required!="")
							{
								$validator_delimiter=HASH."validation_".$validator_required.HASH;
								$html_text=$validator_delimiter.$validator_required.$validator_delimiter.$newline.$html_text;
							}
						}
						require_once(DIR_FS_INC.'olc_ajax_prepare_special_html_chars.inc.php');
						$html_text=olc_ajax_prepare_special_html_chars($html_text);
						if (AJAX_BUILD_INDEX)
						{
							$index_delimiter = HASH."index".HASH;
							$html_text = $index_delimiter . $index . $index_delimiter.$newline.$html_text;
						}
						header('Content-Type: text/html; charset=Windows-1252');
						echo $html_text;
					}
					return;
				}
				elseif (!$is_ajax_processing_forced)
				{
					//Check if element needs to be rendered at all
					//Get resource name and strip extension
					$resource = basename($resource_name);
					$resource = substr($resource, 0, strrpos($resource, DOT));
					$not_force_build_all=!$force_build_all;
					if (USE_LAYOUT_DEFINITION==TRUE_STRING_S)
					{
						$pos=strpos($resource,BOX);
						if ($pos!==false)
						{
							global $box_relations;
							$s=BOX.strtoupper(substr($resource,$pos+strlen(BOX)));
							$s=$box_relations[$s];
							if ($s)
							{
								$resource=$s;
							}
						}
					}
					if ($use_ajax_short_list)
					{
						$ignore_resource = strpos(AJAX_VALID_RESOURCES_SHORT_LIST, $resource)===false;
					}
					elseif ($not_force_build_all)
					{
						//Resource to render for "box"?
						if (strpos($resource_name, CURRENT_TEMPLATE_BOXES)!==false)
						{
							$ignore_resource = strpos(AJAX_VALID_RESOURCES, $resource)===false;
						}
					}
					else
					{
						$ignore_resource = false;
					}
					if ($ignore_resource)
					{
						//If resource does not need to be rendered --> just exit.
						return;
					}
				}
			}
			elseif (USE_AJAX)
			{
				//Display Copyright
				if ($is_top_form)
				{
					$s='BOTTOM_DIVS';
					if (defined($s))
					{
						$this->assign($s,constant($s));
					}
					$s='TOP_DIVS';
					if (defined($s))
					{
						//Include code for the sticky-cart and IE menu navigation.
						$this->assign($s,constant($s));
					}
				}
			}
			//W. Kaiser - AJAX
			if ($is_top_form)
			{
				include_once(DIR_FS_INC.'olc_get_parse_time.inc.php');
			}
			//Use original Smarty code!!
			return parent::fetch($resource_name, $cache_id , $compile_id, $display);
		}
	}
}
?>
