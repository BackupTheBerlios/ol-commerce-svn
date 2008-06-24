<?php
/* -----------------------------------------------------------------------------------------
$Id: header.php,v 1.1.1.1.2.1 2007/04/08 07:17:45 gswkaiser Exp $

OL-Commerce Version 2.0
http://www.ol-commerce.com

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser
-----------------------------------------------------------------------------------------
based on:1
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(header.php,v 1.40 2003/03/14); www.oscommerce.com
(c) 2003	    nextcommerce (header.php,v 1.13 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
-----------------------------------------------------------------------------------------
Third Party contribution:

Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
http://www.oscommerce.com/community/contributions,282
Copyright (c) Strider | Strider@oscworks.com
Copyright (c  Nick Stanko of UkiDev.com,nick@ukidev.com
Copyright (c) Andre ambidex@gmx.net
Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org
Copyright (c) 2006 Winfried Kaiser,w.kaiser@fortune.de -- AJAX

Released under the GNU General Public License
---------------------------------------------------------------------------------------

The following copyright announcement is in compliance
to section 2c of the GNU General Public License,and
thus can not be removed,or can only be modified
appropriately.

Please leave this comment intact together with the
following copyright announcement.
*/

//W. Kaiser - AJAX
$IsNormalMode = strpos($PHP_SELF,'print_') == 0;
$is_pop_up=$_GET['pop_up'];
if ($IsNormalMode)
{
	$IsNormalMode=!$is_pop_up;
}
$load_all_scripts0=(USE_AJAX && NOT_IS_AJAX_PROCESSING);
if (NOT_IS_AJAX_PROCESSING || $is_pop_up)
{
	$load_all_scripts=$load_all_scripts0 && $IsNormalMode;
	$server = ($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER;
	if (false)
	{
		$header =
'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
';
	}
	else
	{
		$header =
'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"';
	if (IS_IE)
	{
		$pos=strpos($my_user_agent,'msie');
		if ($pos!==false)
		{
			$add_loose=(int)substr($my_user_agent,$pos+5)<=6;		//Check IE version
		}
	}
	else
	{
		$add_loose=true;
	}
	if ($add_loose)
	{
		$header .=
		' "http://www.w3.org/TR/html4/loose.dtd"';
	}
	$header.='>
<html ' .  HTML_PARAMS . '>
';
	}
$header.='
<!--
This OnlineStore is brought to you by OL-Commerce, community made shopping

OLC is a free open source e-Commerce System created by Mario Zanier & Guido Winger and licensed under GNU/GPL.

Information and contribution at http://www.xt-commerce.com

Erweiterung und Neubearbeitung durch OL-Commerce
Dies ist als Open Source Projekt unter GPL für jeden frei verfügbar unter http://www.ol-commerce.de

Bearbeitet von Manfred Tomanik

Version 5 and AJAX-extension 2006, 2007 by Dipl.-Ing.(TH) W. Kaiser, http://www.seifenparadies.de
-->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1252">
<meta http-equiv="Content-Language" content="de">
<meta name="generator" content="(c) by ' .  PROJECT_VERSION .',http://www.ol-commerce.com">
<base href="' . $server . DIR_WS_CATALOG . '">
<link rel="stylesheet" type="text/css" href="' .FULL_CURRENT_TEMPLATE. 'stylesheet.css">
';
	$use_native_history_navigation=USE_NATIVE_HISTORY_NAVIGATION=="true";
	if ($IsNormalMode)
	{
		include(DIR_WS_MODULES.FILENAME_METATAGS);

		if (USE_AJAX)
		{
			$header .='
<script src="includes/DisableKeys.js" type="text/javascript"></script>
';
			if (SHOW_COOL_MENU)
			{
				$header .='
<script language="JavaScript1.2" src="includes/cool_menu.js"></script>
';
			}
			if ($use_native_history_navigation)
			{
				//Info: http://www.onjava.com/pub/a/onjava/2005/10/26/ajax-handling-bookmarks-and-back-button.html
				if (USE_DHTML_HISTORY)
				{
					$header .='
<script src="includes/ajax_dhtmlHistory.js" type="text/javascript"></script>';
				}
				if (USE_CROSS_SESSION_STORAGE=="true")
				{
					//Info: http://codinginparadise.org/projects/storage/README.html

					$header .=
					'
<script>
	var tx=getElementsById("XX");		//Wrong statement to force debugger start
</script>
<script src="includes/ajax_lib/x_core.js"></script>
<script src="includes/ajax_lib/x_dom.js"></script>
<script src="includes/ajax_lib/x_event.js"></script>
<script src="includes/ajax_storage.js" type="text/javascript"></script>
';
				}
			}
		}
		if (USE_AJAX)
		{
			include(DIR_WS_INCLUDES . "ajax.js.php");
		}
	}
	echo $header;

	//W. Kaiser - AJAX

	$script='
<script language="javascript" type="text/javascript"><!--
//W. Kaiser - AJAX
function ShowInfo(url,text,full_screen)
{
	var w_width,w_heigth,screen_width,screen_height,x_pos=0,y_pos=0;
	with (screen)
	{
		screen_width=width;
		screen_height=height;
	}
	if (full_screen)
	{
		//Full window size
		w_width=screen_width;
		w_heigth=screen_height;
	}
	else
	{
		//Standard window size
		w_width=800;
		w_heigth=800;
		if (url!="")
		{';
		$script.='
			if (url.indexOf("product_images")!=-1)
			{
				//Reset size for images
				w_width = '.(PRODUCT_IMAGE_POPUP_WIDTH+30).';
				w_heigth = '.(PRODUCT_IMAGE_POPUP_HEIGHT+30).';
			}
		}
		//Center window
		x_pos = (screen_width - w_width) / 2;
		y_pos = (screen_height - w_heigth) / 2;
	}

	var win = window.open(url,"popupWindow","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,"+
		"resizable=no,copyhistory=no,width=" + w_width + ",height=" + w_heigth + ",top=" + y_pos + ",left=" + x_pos);
	if (win)
	{
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
	}
	return false;
}

function popupImageWindow(url) {
	window.open(url,"popupImageWindow",
	"toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,"+
	"copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150")
}
//W. Kaiser - AJAX
';
	if ($load_all_scripts || strstr($PHP_SELF,FILENAME_POPUP_IMAGE))
	{

		$script.='

//FILENAME_POPUP_IMAGE

var i=0;
function resize() {
  if (navigator.appName=="Netscape") i=40;
  if (images[0]) window.resizeTo(images[0].width +30,images[0].height+60-i);
  self.focus();
}

//FILENAME_POPUP_IMAGE

';
	}

	if ($IsNormalMode)
	{
		$script.='

var selected;
//W.Kaiser - AJAX
var style_display, fields_text,bank_transfer_fields,bank_transfer_fields_text="banktransfer";
var paypal_wpp_fields,paypal_wpp_fields_text="paypal_wpp";
//W.Kaiser - AJAX

// GV Code Start following jscript function ICW ADDED FOR CREDIT CLASS SYSTEM
var submitter = null;

function submitFunction() {
	submitter = 1;
}
// GV Code End END OF ICW ADDED FOR ORDER_TOTAL CREDIT SYSTEM
function popupWindow(url) {
';
		if (USE_AJAX)
		{
			$script.='
	//W. Kaiser - AJAX
	url=strip_ajax_link_routine(url);
	//W. Kaiser - AJAX
';
		}
		$script.='
	ShowInfo(url,"");
}

function selectRowEffect(object, buttonSelect) {
	if (!selected) {
		selected = document.getElementById("defaultSelected");
	}
	if (selected)
	{
		selected.className = "moduleRow";
	}
	object.className = "moduleRowSelected";
	selected = object;
	selected.checked=true;
	/*
	// one button is not an array
	var FormRadioButtons = (document.checkout_address) ? document.checkout_address : ((document.checkout_payment) ? document.checkout_payment.payment : document.checkout_shipping.shipping);
	if (FormRadioButtons[0]) {
		FormRadioButtons[buttonSelect].checked=true;
	} else {
		FormRadioButtons.checked=true;
	}
	*/
}

/*
function selectRowEffect(object, buttonSelect) {
  if (!selected) {
    if (document.getElementById) {
      selected = document.getElementById("defaultSelected");
    } else {
      selected = document.all["defaultSelected"];
    }
  }

  if (selected) selected.className = "moduleRow";
  object.className = "moduleRowSelected";
  selected = object;
	// one button is not an array
  if (document.checkout_payment)
  {
	  with (document.checkout_payment)
	  {
		  if (payment[0])
		  {
		    payment[buttonSelect].checked=true;
		  }
		  else
		  {
		    payment.checked=true;
		  }
	  }
  }
  else if (document.checkout_shipping)
  {
	  with (document.checkout_shipping)
	  {
		  if (shipping[0])
		  {
		    shipping[buttonSelect].checked=true;
		  }
		  else
		  {
		    shipping.checked=true;
		  }
	  }
  }
  else
  {
  	var form=document.checkout_shipping_address;
	  if (!form)
	  {
	  	form=document.checkout_payment_address;
	  }
	  if (form)
	  {
		  with (form)
		  {
		    address[buttonSelect].checked=true;
		  }
	  }
  }
}
*/

function rowOverEffect(object) {
	if (object.className == "moduleRow") object.className = "moduleRowOver";
}

function rowOutEffect(object) {
	if (object.className == "moduleRowOver") object.className = "moduleRow";
}

function checkBox(object) {
	account_newsletter.elements[object].checked = !account_newsletter.elements[object].checked;
}

//W.Kaiser - AJAX
function ShowHideInputPaymentFields(ShowFields,IsBankTransfer)
{
	if (IsBankTransfer)
	{
		fields_text=bank_transfer_fields_text;
	}
	else
	{
		fields_text=paypal_wpp_fields_text;
	}
	with (document)
	{
		if (getElementById) {
			bank_transfer_fields = getElementById(fields_text);
		} else {
			bank_transfer_fields = all[bank_transfer_fields_text];
		}
	}
	if (bank_transfer_fields)
	{
		//Show/hide data input fields
		if (ShowFields)
		{
			style_display="inline";
		}
		else
		{
			style_display="none";
		}
		with (bank_transfer_fields.style)
		{
			if (display!=style_display) display=style_display;
		}
	}
}
//W.Kaiser - AJAX
';
	}
	else
	{
		$script.= '
function button_left()
{
	window.close();
}
';
	}
	$script.= '
//--></script>

<script language="javascript" type="text/javascript" src="' . $tpl_path . 'includes/general.js"></script>';
	//}

	if ($load_all_scripts || NOT_IS_AJAX_PROCESSING)
	{
		$script_transient=EMPTY_STRING;
		if ($load_all_scripts || strstr($PHP_SELF,FILENAME_CHECKOUT_PAYMENT))
		{
			if ($load_all_scripts)
			{
				// load all enabled payment modules
				require_once(DIR_WS_CLASSES . 'payment.php');
				$payment_modules = new payment;
			}
			$script_transient.=$payment_modules->javascript_validation();
			if ($load_all_scripts)
			{
				unset($payment_modules);
			}
		}
		if ($load_all_scripts || strstr($PHP_SELF,FILENAME_CREATE_ACCOUNT))
		{
			$get_form_check=true;
		}
		elseif (strstr($PHP_SELF,FILENAME_CREATE_GUEST_ACCOUNT))
		{
			$get_form_check=true;
		}
		elseif (strstr($PHP_SELF,FILENAME_ACCOUNT_PASSWORD))
		{
			$get_form_check=true;
		}
		elseif (strstr($PHP_SELF,FILENAME_ACCOUNT_EDIT))
		{
			$get_form_check=true;
		}
		elseif (strstr($PHP_SELF,FILENAME_ADDRESS_BOOK_PROCES))
		{
			if (!isset($_GET["delete"])) {
				$get_form_check=true;;
			}
		}
		if ($load_all_scripts || strstr($PHP_SELF,FILENAME_CHECKOUT_SHIPPING_ADDRESS) ||
		strstr($PHP_SELF,FILENAME_CHECKOUT_PAYMENT_ADDRESS))
		{
			$get_form_check=true;

			$script_transient.='

//CHECKOUT_SHIPPING_ADDRESS, FILENAME_CHECKOUT_PAYMENT_ADDRESS

function check_form_optional(form_name)
{
	with ($(form_name))
	{
		var firstname=elements["customers_firstname"].value;
	  var lastname=elements["customers_lastname"].value;
	  var street_address=elements["entry_street_address"].value;
	}
  if (firstname=="" && lastname=="" && street_address=="")
  {
		//W. Kaiser - AJAX
';
			if (USE_AJAX)
			{
				$script_transient.= '
		//Pass on to AJAX
		AJAX_submit(form_name,"");
		return false;
';
			}
			else
			{
				$script_transient.= '
		return true;
';
			}
			$script_transient.= '
		//W. Kaiser - AJAX
  }
  else
  {
    return check_form_new(form_name,false);
  }
}

//CHECKOUT_SHIPPING_ADDRESS, FILENAME_CHECKOUT_PAYMENT_ADDRESS

';
		}

		if ($get_form_check)
		{
			require_once('includes/form_check.js.php');
		}
		if ($load_all_scripts || strstr($PHP_SELF,FILENAME_ADVANCED_SEARCH))
		{
			$script_transient.='

//FILENAME_ADVANCED_SEARCH

function m_trim(str)
{
   return str.replace(/^\s*|\s*$/g,"");
}

function check_form_advanced_search(form_object)
{
	var error_message="'.JS_ERROR.'";
	var error_found=false;
	var error_field_value;
	var pfrom_float=0;
	var pto_float=0;

	with (form_object)
	{
	  var v_keywords;
	  var v_dfrom;
	  var v_dto;
	  var v_pfrom;
	  var v_pto;
	  var have_pfrom,have_pto,have_dfrom,have_dto;

	  v_keywords=m_trim(keywords.value);
	  v_dfrom=m_trim(dfrom.value);
	  v_dto=m_trim(dto.value);
	  v_pfrom=m_trim(pfrom.value);
	  v_pto=m_trim(pto.value);

	  have_pfrom=v_pfrom!="";
	  have_pto=v_pto!="";
		have_dfrom=v_dfrom!="" && v_dfrom!="'.DOB_FORMAT_STRING.'";
	  have_dto= v_dto!="" && v_dto!="'.DOB_FORMAT_STRING.'";
	  if 	(v_keywords=="" && !have_pfrom && !have_pto && !have_dfrom && !have_dto)
  	{
	    error_message=error_message + "'.JS_AT_LEAST_ONE_INPUT.'";
	    error_field=keywords;
      error_field_value=v_keywords;
	    error_found=true;
	  }
	  else
	  {
	    if (!error_found && have_dfrom)
	    {
		    if (!IsValidDate(v_dfrom,"'.DOB_FORMAT_STRING.'"))
				{
		      error_message=error_message + "'.JS_INVALID_FROM_DATE.'";
		      error_field=dfrom;
		      error_field_value=v_dfrom;
		      error_found=true;
		    }
		    else
		    {
			    if (have_dto)
			    {
				    if (!IsValidDate(v_dto,"'.DOB_FORMAT_STRING.'"))
						{
				      error_message=error_message + "'.JS_INVALID_TO_DATE.'";
				      error_field=dto;
				      error_field_value=v_dto;
				      error_found=true;
				    }
			    }
				}
		    if (have_dto)
		    {
			    if (!CheckDateRange(v_dfrom,v_dto))
					{
			      error_message=error_message + "'.JS_TO_DATE_LESS_THAN_FROM_DATE.'";
			      error_field=dto;
			      error_field_value=v_dto;
			      error_found=true;
			    }
		    }
			}
	    if (!error_found && have_pfrom)
	    {
		    pfrom_float=parseFloat(v_pfrom);
		    if (isNaN(pfrom_float))
				{
		      error_message=error_message + "'.JS_PRICE_FROM_MUST_BE_NUM.'";
		      error_field=pfrom;
		      error_field_value=v_pfrom;
		      error_found=true;
		    }
		    else
		    {
			    if (!error_found && have_pto)
			    {
				    pto_float=parseFloat(v_pto);
						if (isNaN(pto_float))
						{
				      error_message=error_message + "'.JS_PRICE_TO_MUST_BE_NUM.'";
				      error_field=pto;
				      error_field_value=v_pto;
				      error_found=true;
				    }
				    else if (pto_float < pfrom_float)
				    {
				      error_message=error_message + "'.JS_PRICE_TO_LESS_THAN_PRICE_FROM.'";
				      error_field=pto;
				      error_field_value=v_pto;
				      error_found=true;
				    }
					}
				}
			}
		}
	  if (error_found)
	  {
	    alert(error_message);
	    with (error_field)
	    {
	    	value=error_field_value;
	    	focus();
	    }
	    return false;
	  } else {
	    RemoveFormatString(dfrom,"'.DOB_FORMAT_STRING.'");
	    RemoveFormatString(dto,"'.DOB_FORMAT_STRING.'");
';
			if (USE_AJAX)
			{
				$script_transient.='
			//W. Kaiser - AJAX
			//Pass on to AJAX
			AJAX_submit(form_object,"");
			return false
			//W. Kaiser - AJAX
';
			}
			else
			{
				$script_transient.='
			return true;
';
			}
			$script_transient.='
		}
	}
}
//FILENAME_ADVANCED_SEARCH

';
		}

		if ($load_all_scripts || strstr($PHP_SELF,FILENAME_PRODUCT_REVIEWS_WRITE))
		{
			$script_transient.='

//FILENAME_PRODUCT_REVIEWS_WRITE

function checkForm(form_name)
{
	var error=false;
	var error_message="";

	with (product_reviews_write)
	{
		if (review.value.length < '.REVIEW_TEXT_MIN_LENGTH.')
		{
			error_message="'.JS_REVIEW_TEXT.'";
			error=true;
		}
		else
		{
			error=true;
			for (var i=0;i<rating.length;i++)
			{
				if (rating[i].checked)
				{
					error=false;
					break;
				}
			}
			if (error)
			{
				error_message="'.JS_REVIEW_RATING	.'";
			}
		}
		if (error)
		{
			alert("'.JS_ERROR.'"+error_message);
			return false;
		}
		else
		{
';
			if (USE_AJAX)
			{
				$script_transient.='
			//W. Kaiser - AJAX
			//Pass on to AJAX
			AJAX_submit(form_name,"");
			return false
			//W. Kaiser - AJAX
';
			}
			else
			{
				$script_transient.='
			return true;
';
			}
			$script_transient.='
		}
	}
}
';
		}
	}
	$have_script=strlen($script_transient)>0;
	if ($load_all_scripts || NOT_USE_AJAX)
	{
		if ($have_script)
		{
			if (USE_AJAX)
			{
				$script_transient='
<script language="javascript" type="text/javascript"><!--'
				.$script_transient.'
//--></script>
';
			}
			if (true|| $load_all_scripts)
			{
				$script_transient=$script.$script_transient;
			}
			else
			{
				$script_transient=$script;
			}
			if (!IS_LOCAL_HOST)
			{
				//Strip whitespace
				$script_transient=preg_replace('@([\r\n])[\s]+@','\1',$script_transient);
			}
			echo $script_transient;
		}
		else
		{
			echo $script;
		}
	}
	echo '
</head>';
	$body="
<body ";
	if (strstr($PHP_SELF, FILENAME_POPUP_IMAGE )) {
		$body.=' class="bg" onload="resize();"';
	} elseif ($IsNormalMode)
	{
		if (USE_AJAX)
		{
			//$body.='onLoad="ajax_init();" onscroll="document_onscroll();"';
			$body.='onLoad="ajax_init();';
			$set_quote=true;
		}
		/*
		if (IS_LOCAL_HOST)
		{
			$body.='SNOW_init();';
			$set_quote=true;
		}
		*/
		if ($set_quote)
		{
			$body.=QUOTE;
		}
		/*
		elseif (IS_IE)
		{
		$body.='onload="animateinit();"';
		}
		*/
	}
	$body.='>';

	if ($IsNormalMode)
	{
		/*
		if (IS_LOCAL_HOST)
		{
			$body.=include(DIR_WS_INCLUDES.'snow.js.php');
		}
		*/
		if ($_SESSION['template_change'])
		{
			$smarty->assign('CHANGE_SKIN','
			<A href="'. olc_href_link("skin.php").'" '.  CHANGE_SKIN_TEXT.'</A>
			');
		}
		/*
		if ($IsNormalMode)
		{
		$tpl_path = FULL_CURRENT_TEMPLATE;

		$image = BULLET;
		$bullet0 = '<div id="dot#" style="position: absolute; height: 11; width: 11;">' . $image . '</div>';
		$style = 'style="';
		$animation_data = str_replace('#','0',$bullet0);
		$animation_data = str_replace($style,$style . 'visibility: hidden; ',$animation_data);
		$animation_data .=
		str_replace('#','1',$bullet0) .
		str_replace('#','2',$bullet0) .
		str_replace('#','3',$bullet0) .
		str_replace('#','4',$bullet0) .
		str_replace('#','5',$bullet0) .
		str_replace('#','6',$bullet0);
		}
		*/

		if (USE_AJAX)
		{
			//$ajax_elements_html=$animation_data;
			//Sticky-cart. Is displayed, if cart moves off screen
			$ajax_elements_html.='
<div id="ajax_active_indicator_float"
	style="position:absolute;display:none;top:-500px;width:145px;height:15px;z-index:1000">
	<img border="0" src="'.CURRENT_TEMPLATE_IMG.'ajax_activity.gif" alt="">
</div>
';
			if (IS_IE)
			{
				//	top:expression((document.body.clientHeight-sticky_cart.offsetHeight)/2);
				$ajax_elements_html.='
<div id="sticky_cart" style="
	filter:progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
	z-index:1001;
	z-order:1001;
	padding-left:10px;
	padding-right:10px;
	display:none;
	position:absolute;
	top:-500px;
	">
</div>
';

			}
			else
			{
				/*
				$ajax_elements_html.='
				<div id="sticky_cart" style="
				padding-left:10px;padding-right:10px;display:none;position:fixed;top:-500px
				">
				</div>
				';
				*/
				$ajax_elements_html.='
<div id="sticky_cart" style="padding-left:10px;padding-right:10px;display:none;position:absolute;top:-500px">
</div>
';
			}
			//Smarty has to put this at the  t o p  of "index.html" (e.g. "sticky cart" div et. al.
			define('TOP_DIVS',$ajax_elements_html);

		}
		/*
		elseif (IS_IE)
		{
		echo $animation_data;
		}
		*/
		if ($is_spider_visit)
		{
			if (strlen($products_meta_description)>0)
			{
				//Create search engine data -- created in 'metatags.php'
				//echo NEW_LINE . '<div style="display:none">' . NEW_LINE .
				echo NEW_LINE . '<div>' . NEW_LINE .
				'<h1 style=color:red;>meta_descriptions</h1><hr/>'.
				$products_meta_description  . "<hr/>\n\n" .
				'<h1 style=color:red;>meta_keywords</h1><hr/>'.
				$products_meta_keywords  . "<hr/>" . "\n\n" .
				'<h1 style=color:red;>H1- und H2-Tags</h1><hr/>'.
				$products_header . "<hr/>" . "\n\n" .
				'<h1 style=color:red;>Images</h1><hr/>'.
				$products_img . "<hr/>".NEW_LINE .
				'<h1 style=color:red;>Links</h1><hr/>'.
				$products_link . "<hr/>" . NEW_LINE .
				'</div>' . NEW_LINE ;
				//Create search engine data -- created in 'metatags.php'
			}
		}
	}
}
else
{
	define('AJAX_TITLE',$breadcrumb->title_from_trail());
}
echo $body;

// include needed functions
require_once(DIR_FS_INC.'olc_image.inc.php');
require_once(DIR_FS_INC.'olc_parse_input_field_data.inc.php');
require_once(DIR_FS_INC.'olc_draw_separator.inc.php');

if ($IsNormalMode)
{
	$smarty->assign('navtrail',$breadcrumb->trail(' >> '));

	//W. Kaiser - AJAX
	//---PayPal WPP Modification START ---//
	$is_logogff=CURRENT_SCRIPT==FILENAME_LOGOFF;
	if (CUSTOMER_ID)
	{
		$paypal_ec_temp=$_SESSION['paypal_ec_temp'];
		if (olc_paypal_wpp_enabled() && $paypal_ec_temp)
		{
			//If this is a temp account that'll be deleted, don't show account information
			if ($paypal_ec_temp)
			{
				$is_logogff = true;			//Fake "Logoff"-state
			}
		}
	}
	//---PayPal WPP Modification END ---//

	if (NOT_IS_AJAX_PROCESSING || CURRENT_SCRIPT==FILENAME_LOGIN || $is_logogff)
	{
		include_once(DIR_FS_INC.'olc_create_navigation_links.inc.php');
		olc_create_navigation_links(count($_SESSION['cart']->contents)>0,$is_logogff);
	}
}
//W. Kaiser - AJAX
?>