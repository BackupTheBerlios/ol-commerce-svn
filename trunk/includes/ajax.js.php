<?PHP
//W. Kaiser - AJAX
/* -----------------------------------------------------------------------------------------
id: ajax.js.php,v 1.1 2006/01/08  $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

AJAX=Asynchronous JavaScript And XML
Info: http://de.wikipedia.org/wiki/Ajax_(Programmierung)

AJAX client-side Javascript support-routines

Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(shopping_cart.php,v 1.18 2003/02/10); www.oscommerce.com
(c) 2003	    nextcommerce (shopping_cart.php,v 1.15 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//define('SCRIPT_DYN_LOAD',!IS_LOCAL_HOST);
define('SCRIPT_DYN_LOAD',false);
$not_script_dyn_load=!SCRIPT_DYN_LOAD;
$pack_js=false;			//Pack and obfuscate script

$is_full_AJAX=!(defined('USE_AJAX_ATTRIBUTES_MANAGER') || $_SESSION['is_admin']==true) || USE_AJAX_ADMIN;
$recreate_ajax_file=true;
if (SCRIPT_DYN_LOAD)
{
	if ($is_full_AJAX)
	{
		//	Avoid loading (lengthy) AJAX-support Javascript on program start!
		//	Dynamically load only after screen has been initially displayed.
		if (IS_ADMIN_FUNCTION)
		{
			$ajax_script_file='admin';
		}
		else
		{
			$ajax_script_file='user';
		}
		$s='.js';
		$ajax_script_file='cache/cache/ajax_support_'.$ajax_script_file.$s;
		$ajax_script_file_packed=str_replace($s,'_p'.$s,$ajax_script_file);
		if (file_exists($ajax_script_file))
		{
			$recreate_ajax_file=filemtime(DIR_WS_INCLUDES.'ajax.js.php')>filemtime($ajax_script_file);
		}
		$not_pack_js=!$pack_js;
		if (IS_LOCAL_HOST || $not_pack_js)
		{
			$script_dyn=$ajax_script_file;
		}
		else
		{
			$script_dyn=$ajax_script_file_packed;
		}
		$script_dyn='
	<script language="javascript" type="text/javascript"><!--
	function ajax_init()
	{
		var script = document.createElement("script");
		script.type = "text/javascript";
		script.src = "'.$script_dyn.'";
		document.getElementsByTagName("head")[0].appendChild(script);
	}
	--></script>
';
	}
}
/*
*/
if ($recreate_ajax_file)
{
	$debug_text='debug';
	if (isset($_SESSION[$debug_text]))
	{
		$debug=$_SESSION[$debug_text];
	}
	else
	{
		if (isset($_GET['start_'.$debug_text]) || IS_LOCAL_HOST)
		{
			$debug="true";
		}
		else
		{
			$debug="false";
		}
		$_SESSION[$debug_text]=$debug;
	}

	if (USE_DHTML_HISTORY)
	{
		if ($is_full_AJAX)
		{
			if (USE_NATIVE_HISTORY_NAVIGATION)
			{
				$use_native_history_init_code='
		  // initialize the DHTML History framework
		  dhtmlHistory.initialize();
		  // subscribe to DHTML history change  events
		  dhtmlHistory.addListener(historyChange);
';
			}
		}
	}
	if ($not_script_dyn_load)
	{
		$script.='
<script language="javascript" type="text/javascript"><!--
';
	}
	$script.='
//W. Kaiser - AJAX

/*
olc/AJAX support scripts

Copyright (c) 2006, Dipl.-Ing.(TH) Winfried Kaiser, w.kaiser@fortune.de

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the "Software"),
to deal in the Software without restriction, including without limitation
the rights to use, copy, modify, merge, publish, distribute, sublicense,
and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT
OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR
THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

//Show PHP debugging on/off
var debug_it='.$debug.';
var current_event,mouse_is_down=false,mouse_x,mouse_y,event_source,img_tag="IMG",a_tag="A",a_tag_found,level,area_tag="AREA";

// Fehler abfangen in Internet Explorer und kompatiblen
//window.onerror=window_onerror;
// Fehler abfangen in Netscape und kompatiblen
//window.onError=window_onerror;

var any_open_close_html=
"<center><font style=font-size:12px;color:red><a href=\'javascript:sticky_cart_open_close(~);\' title=\'§\'><b>#@</b></a></font></center>";
var any_open_html=any_open_close_html.replace(/~/,"true");
var any_close_html=any_open_close_html.replace(/~/,"false");

var undefined="undefined",blank=" ";
var browser0,browser,reconfigure=false;
var opera=window.opera;
var compatMode=document.compatMode;
var is_IE,is_IE7,not_is_IE,is_Firefox,is_Safari,is_Opera;
var userAgent=navigator.userAgent;
is_Safari = (userAgent.indexOf("Safari") != -1);
if (!is_Safari)
{
	with (document)
		{
			if(typeof(ids)!=undefined) browser0="nc4";
			else if(typeof(all)!=undefined && !getElementById) browser0="ie4";
			else if(opera && !createElement) browser0="op5";
			else if(opera && compatMode) browser0="op7";
			else if(opera && releaseEvents) browser0="op6";
			else if(typeof(contains)!=undefined && !opera) browser0="kq3";
			else if(opera && window.getComputedStyle)  {
				if(createRange) browser0="op8";
				else if(window.navigate) browser0="op7.5";
				else browser0="op7.2";                   }
			else if(window.pkcs11&&window.XML)  {
				browser0="f15";
				reconfigure=true;
				}
			else if(window.getSelection && window.atob) browser0="nn7";
			else if(window.getSelection && !compatMode) {
				browser0="nn6";
				reconfigure=true;
				}
			else if(window.clipboardData && compatMode)
			{
				is_IE=userAgent.indexOf("MSIE");
				if (is_IE!=-1)
				{
					is_IE=parseInt(userAgent.substr(is_IE+5,2));		//Get IE version
				}
				is_IE7=is_IE>6;
				browser0="ie"+is_IE;
			}
			else if(window.clipboardData){browser0="ie5";
			     if(!createDocumentFragment) browser0+=".5";
			     if(doctype && !window.print) browser0+="m";}
			else if(getElementById && !all) browser0="op4";
			else if(images && !all) browser0="nn3";
			else if(clientWidth&&!window.RegExp) browser0="kq2";
			else browser0="(Unbekannter Browser)";

			with (browser0)
			{
				if (indexOf("ie") != -1)
				{
					var ie_text="Microsoft Internet Explorer";
					browser=replace(/m/," (Mac)");
					browser=replace(/ie6/,ie_text);
					browser=replace(/ie7/,ie_text);
					browser=replace(/ie/,ie_text+blank);
					is_IE=true;
				}
				else
				{
					if (indexOf("f15") != -1)
					{
						browser=replace(/f15/,"Firefox");
						is_Firefox=true;
					}
					else if (indexOf("nn") != -1)
					{
						browser=replace(/nn/,"Netscape Navigator ");
						is_Firefox=true;
					}
					else if (indexOf("op") != -1)
					{
						browser=replace(/nn/,"Opera ");
						is_Opera=true;
					}
					else if (indexOf("op") != -1)
					{
						browser=replace(/kq/,"Konqueror ");
					}
					else
					{
						browser=browser0;
					}
				}
			}
			not_is_IE=!is_IE;
		}
	}
	';

	if (USE_AJAX_ATTRIBUTES_MANAGER=="true")
	{
		$script.='

	function $F(element_id)
	{
		with ($(element_id))
		{
			switch (tagName.toLowerCase())
			{
				case select_text:
						return options[selectedIndex].value
					break;
				default:
					return value;
			}

		}
	}
';
	}

	include(DIR_WS_INCLUDES.'convert_html_entities.js.php');

	$script.=$cron_jobs.'
var hash="#",slash="/",ampersand="&",questionmark="?",dash="-",comma=",",dot=".",ndash="&ndash;";
var XHTTP_state;
';

	if (SESSION_LANGUAGE=='german')
	{
		$script.='
var AJAX_Daten="AJAX-Daten ";
var AJAX_Daten_werden=AJAX_Daten+"werden ";
var XHTTP_states_text=
	new Array("AJAX-Verbindung wird initialisiert",
	AJAX_Daten_werden+"geladen",
	AJAX_Daten+"wurden geladen",
	AJAX_Daten_werden+"aufbereitet",
	AJAX_Daten+"sind vollständig");
var timeout_message="Die Verbindung mit unserem Server war nach # Sekunden nicht erfolgreich!\n\nSoll die Anforderung wiederholt werden?";
var cart_text="Warenkorb",price_display_text="Preisanzeige",close_text=" schließen",open_text=" anzeigen";
var floating_cart_text="Den beweglichen "+cart_text
var sticky_cart_open_title=floating_cart_text+open_text;
var sticky_cart_close_title=floating_cart_text+close_text;
var price_display_close_title="Die Preisanzeige"+close_text;
var change_message="Sie haben Änderungen an den Produktmengen und/oder Produktoptionen im Warenkorb "+
"vorgenommen, diese Änderungen wurden aber noch nicht an unseren Server übermittelt.\n\n"+
"Wollen Sie diese Änderungen verwerfen, und die angewählte Funktion aufrufen?\n\n"+
"Andernfalls müssen Sie diese Änderungen mit der zugeordneten Schaltfläche speichern lassen.";
var base_price_start="<font style=\"font-size:8pt;font-weight:normal;\">(Grundpreis: ";
var male="männlich",female="weiblich",male_anrede="Herr",female_anrede="Frau";
var both=male+slash+female,unknown="unbekannt",gender;
var kontonummer_text="\"Kontonummer\"";
var blz_text="\"BLZ\"";
var vorname_text="\"Vorname\"";
var plz_text="\"Plz\"";
var und_text=" und ";
var wait_for_init_message="Bitte warten Sie, bis die Seite vollständig geladen wurde!";
var show_loaded_message="Die Seite wurde vollständig geladen.";
';
	}
	else
	{
		$script.='
var AJAX_Daten="AJAX-Data ";
var AJAX_Daten_werden=AJAX_Daten+"are ";
var XHTTP_states_text=
	new Array("AJAX-connection beeing initialized",
	AJAX_Daten_werden+"loaded",
	AJAX_Daten+"have been loaded",
	AJAX_Daten_werden+"prepared",
	AJAX_Daten_werden+" complet");
var timeout_message="The connection to our Server was not successful after # seconds!\n\nShall the request be repeated?";
var cart_text="Shopping-Cart",price_display_text="price-display",close_text="Close the ",open_text="Open the ";
var sticky_cart_open_title=open_text+"floating "+cart_text;
var sticky_cart_close_title=close_text"floating "+cart_text;
var price_display_close_title=close_text+price_display_text;
var change_message="You have changed product-quantities and/or -options in the shopping cart, "+
"but these changes have not yet been updated on our server.\n\n"+
"Do you want to discard these changes, and call the funtion selected?\n\n"+
"Otherwise you must let store these changes by clicking the corresponding button.";
var base_price_start="<font style=\"font-size:8pt;font-weight:normal;\">(Baseprice: ";
var male="male",female="female",male_anrede="Mr.",female_anrede="Mrs.";
var both=male+slash+female,unknown="unknown";
var kontonummer_text="\"Account Nr.\"";
var blz_text="\"Banknumber\"";
var vorname_text="\"Firstname\"";
var plz_text="\"Postcode\"";
var und_text=" and ";
var wait_for_init_message="Please wait until the page has been loaded completely!";
var show_loaded_message="The page has been loaded completely";
';
	}
	$script.='
var search,returnvalue=empty_string,show_loaded;
var sticky_cart_open_html=any_open_html.replace(/#/,cart_text);
var sticky_cart_open_html=sticky_cart_open_html.replace(/@/,open_text);
var sticky_cart_open_html=sticky_cart_open_html.replace(/§/,sticky_cart_open_title);

var sticky_cart_close_html=any_close_html.replace(/#/,cart_text);
var sticky_cart_close_html=sticky_cart_close_html.replace(/@/,close_text);
var sticky_cart_close_html=sticky_cart_close_html.replace(/§/,sticky_cart_close_title);

var price_display_close_html=any_close_html.replace(/#/,price_display_text);
var price_display_close_html=price_display_close_html.replace(/@/,close_text);
var price_display_close_html=price_display_close_html.replace(/§/,price_display_close_title);

var select_text="select";
var script_lines,script_line,ajax_script_text="ajax_script_",ajax_script,ajax_script_id;
var onsubmit_text="onsubmit";
';
	if ($is_full_AJAX)
	{
		/*
		$referer=$_SERVER['HTTP_REFERER'];
		if (strpos($referer,PHP)===false)
		{
		$referer=$PHP_SELF;
		}
		*/
		$referer=$PHP_SELF;
		$pos=strpos($referer,'start_debug');
		if ($pos===false)
		{
			$pos=strpos($referer,'DBGSESSION');
		}
		if ($pos!==false)
		{
			$referer=substr($referer,0,$pos-1);
		}
		$pos=strrpos($referer,SLASH);
		if ($pos!==false)
		{
			$referer=substr($referer,$pos+1);
			$pos=strpos($referer,$force_javascript_check_text);
			if ($pos!==false)
			{
				$referer=substr($referer,0,$pos-1);
			}
		}
		$referer=str_replace('force_restart=true',EMPTY_STRING,$referer);
		if (IS_MULTI_SHOP)
		{
			$referer=MULTI_SHOP_SERVER.DIR_WS_MULTI_SHOP.$referer;
			$is_multi_shop_state=TRUE_STRING_S;
		}
		else
		{
			$is_multi_shop_state=FALSE_STRING_S;
		}
		$script.='
var set_multi_shop_directory='.$is_multi_shop_state.';
var multi_shop_directory_name="'.DIR_FS_MULTI_SHOP_TEXT.'";
var multi_shop_directory_value="'.DIR_FS_MULTI_SHOP.'";
';
		if (IS_ADMIN_FUNCTION)
		{
			$is_admin_function=TRUE_STRING_S;
			$script.='
var attributemanager_message_delimiter=hash+"am"+hash;
var attributemanager_message_delimiter_len=attributemanager_message_delimiter.length;
';
		}
		else
		{
			$is_admin_function=FALSE_STRING_S;
			$script.='
var products_info_line_text="'.PRODUCTS_INFO_LINE.'";
var products_info_active=false;
var products_info_area="";
var gallery_script="gallery.php'.'";
var products_info_line_length=products_info_line_text.length;
var products_line_image_text="'.PRODUCTS_LINE_IMAGE.'";
';
		}
		$script.='
//debug_stop();

var admin_id="admin='.$is_admin_function.'";
var mysql_text="MySQL server";
var php_fatal_error_text="Fatal error";						//PHP error message
var php_parse_error_text="Parse error";						//PHP error message
var smarty_fatal_error_text="Smarty error";				//Smarty error message
var fatal_error_newline_text="/<br \/>/g",fatal_error_newline_replace_text="\n";
var ajax_id="'.AJAX_ID.'";
var store_country="'.STORE_COUNTRY.'";
var ajax_request_func_start="'.AJAX_REQUEST_FUNC_START.'";
var use_seo="'.USE_SEO.'";
var seo_text="'.SEO_PAGENAME_START.'";
var seo_separator=ampersand;
var force_cart_text="force_cart=true";
var request_instance;
var http_requests=new Array(),http_requests_length=-1,next_http_requests_slot=-1,max_http_requests_slots=4;
var validation_error,validation_error_message,title_delimiter="title",message;
var recoverable_error_delimiter="recoverable_error",fatal_error_delimiter="fatal_error",
	info_message_delimiter="info_message";
var AJAX_NODATA="'.AJAX_NODATA.'";
var debug_output="Debug-Output";

var timeout_interval=10;												//AJAX-request timeout period (seconds)

var timeout_interval= timeout_interval*1000;		//Convert to milliseconds
var ajax_request_timeout=new Array();
var ajax_request_method,ajax_request_parameters, ajax_get="GET",ajax_post="POST",is_get,empty_string="";
var data_returned=empty_string,rewritten=false,save_url=empty_string,ajax_request_url,target_url=empty_string;
var document_body_style_cursor,cursor_wait="wait",cursor_normal="auto",i;
var AJAX_init_done=false, is_admin_function='.$is_admin_function.';
var not_is_admin_function=!is_admin_function,process_script;
var ajax_active_indicator_text="ajax_active_indicator",ajax_active_indicator,ajax_active_indicator_style;
var ajax_active_indicator_float_text=ajax_active_indicator_text+"_float";
var ajax_active_indicator_float_height=0,ajax_active_indicator_float_width=0;
var ajax_active_indicator_float_height_2=0,ajax_active_indicator_float_width_2=0;
var ajax_active_indicator_left=0,ajax_active_indicator_top=0;
var ajax_activity_text="ajax_activity",gif_text="gif";
var ajax_active_style_visible="visible",ajax_active_style_hidden="hidden",ajax_active_change=false;
var index_delimiter="index",index_returned;
var cart_details_text="cart_details",sticky_cart_details_text="sticky_"+cart_details_text;
var button_cart_details_text="button_cart_details";
var button_show_hide_label="<!-- CART_BUTTON_SHOW_HIDE-->";
var button_show_hide_label_length=button_show_hide_label.length;
var cart_details_show_text="'.NAVBAR_TITLE_SHOPPING_CART_DETAILS_OPEN.'"
var cart_details_hide_text="'.NAVBAR_TITLE_SHOPPING_CART_DETAILS_CLOSE.'"
var button_cart_details,cart_details_state_text="&cart_details_state=";
var box_CART,restart_text="restart",main_content_text="main_content",main_content;
var use_layout_definition='.USE_LAYOUT_DEFINITION.';
';
		$box_CART_text='box_CART';
		if (USE_LAYOUT_DEFINITION==TRUE_STRING_S)
		{
			$box_CART_text=$box_relations[$box_CART_text];
			$boxes=EMPTY_STRING;
			while (list($key,$box) = each($box_relations))
			{
				if ($box)
				{
					if ($boxes)
					{
						$boxes.=DOT;
					}
					$boxes.=$box;
				}
			}
			$script.='
var history_boxes="'.$boxes.'";
';
		}
		$script.='
var box_CART_text="'.$box_CART_text.'"
var non_ajax_targets="_blank_top_parent";
//var post_data_follows="post_data=follows"+ampersand;
var javascript_text="javascript:";

/*
var st,strExec,loop,script_tag,script_text="SCRIPT";

function execJS(node)
{
	for (loop=0;loop<=1;loop++)
	{
		if (loop==0)
		{
			script_tag=script_text;
		}
		else
		{
			script_tag=script_text.toLowerCase();
		}
	  st=node.getElementsByTagName(script_tag);
	  for(i=0;i<st.length;i++)
	  {
	  	with (st[i])
	  	{
		    if (is_Firefox)
		    {
		      strExec = textContent;
		    }
		    else if (is_Safari)
		    {
		      strExec = innerHTML;
		    }
		    else if (is_Opera)
		    {
		      strExec = text;
		    }
		    else
		    {
		      strExec = text;
		    }

		    try
		    {
		      eval(strExec);
		    }
		    catch(e)
		    {
		      alert(e);
		    }
		  )
	  }
  }
}
*/

function init_http_request_object(my_target_url)
{
	for (var http_request_instance=0; http_request_instance<=http_requests_length; http_request_instance++)
	{
		if (http_requests[http_request_instance].available)
		{
			break;
		}
	}
	if (http_request_instance>http_requests_length)
	{
		next_http_requests_slot++;
		if (next_http_requests_slot>max_http_requests_slots)
		{
			next_http_requests_slot=0;
		}
		else
		{
			http_requests_length=next_http_requests_slot;
			//http_requests[next_http_requests_slot]=new HTTP_REQUEST(next_http_requests_slot);
			ajax_request_timeout.push(0);
		}
		http_request_instance=next_http_requests_slot;
	}
	http_requests[http_request_instance]=new HTTP_REQUEST(http_request_instance);
	if (http_requests[http_request_instance].xmlhttp)
	{
		http_requests[http_request_instance].available=false;
		http_requests[http_request_instance].active=true;
		http_requests[http_request_instance].target_url=my_target_url;
		http_requests[http_request_instance].xmlhttp.onreadystatechange = function()
		{
			rewrite_DOM_element(http_request_instance);
		}
		return http_request_instance;
	}
}

function check_timeout(http_request_instance)
{
	if (http_requests[http_request_instance].active)
	{
		//AJAX-request still active --> failure
		document_body_style_cursor=cursor_normal;
		window.status=empty_string;
		http_request_stop(http_request_instance);
		if (ajax_active_change)
		{
			ajax_active_indicator_style.display=style_display_hide;
		}
		timeout_message=timeout_message.replace(/#/,timeout_interval/1000);
		if (confirm(timeout_message))
  	{
			make_AJAX_Request(ajax_request_url,ajax_request_method==ajax_post,
				ajax_request_parameters,ajax_request_method);	//Repeat AJAX-request
		}
	}
}

function make_AJAX_Request(target_url,do_post_form,post_parameters,post_method,refresh)
{
  if (target_url)
  {';
		if (NOT_IS_ADMIN_FUNCTION)
		{
			$script.='
	//debug_stop();
		if (sticky_cart_data_dirty)
	  {
	  	message=change_message;
	  	if (confirm(message))
	  	{
	  		sticky_cart_data_dirty=false;
	  		/*
	  		if (target_url.indexOf(questionmark)==-1)
	  		{
		  		target_url+=questionmark;
	  		}
	  		else
	  		{
		  		target_url+=ampersand;
	  		}
	  		target_url+=force_cart_text;
	  		*/
				target_url=add_parameter(target_url,post_parameters,force_cart_text,true);
	  	}
	  	else
	  	{
	  		//Position to "submit" button
	  		$(update_cart_button_text).focus()
	  		return;
	  	}
	  }';
		}

		$script.='
		if (set_multi_shop_directory)
		{
	//debug_stop();
			set_cookie(multi_shop_directory_name, multi_shop_directory_value);
			/*
			get_cookie(multi_shop_directory_name);
	    if (target_url.indexOf(questionmark) != -1)
	    {
	      target_url+=ampersand;
	    }
	    else
	    {
	      target_url+=questionmark;
	    }
			target_url+=multi_shop_directory_value;
			*/
		}
		save_url=target_url;
//debug_stop();
		request_instance=init_http_request_object(target_url);
	  if (request_instance>=0)
	  {
			ajax_request_url=target_url;
	    if (do_post_form)
			{
				http_requests[request_instance].xmlhttp.open(post_method, target_url, true);
				http_requests[request_instance].xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				http_requests[request_instance].xmlhttp.setRequestHeader("Content-length", post_parameters.length);
				http_requests[request_instance].xmlhttp.setRequestHeader("Connection", "close");
				ajax_request_method=post_method;
	      if (post_parameters.length>0)
	      {
	        post_parameters+=ampersand;
	      }
				if (do_validation_request)
				{
					post_parameters+=admin_id;
				}
				else
				{
					post_parameters+=ajax_id+cart_details_state_text+cart_details_state;
	      }
				parameters=post_parameters;
			}
			else
			{
		    if (target_url.indexOf(questionmark) != -1)
		    {
		    	target_url+=ampersand;
		    }
		    else
		    {
		     	target_url+=questionmark;
		    }
				if (do_validation_request)
				{
					post_parameters+=admin_id;
				}
				else
				{
					target_url+=ajax_id+cart_details_state_text+cart_details_state;
	      }
				parameters=empty_string;	//null;
        http_requests[request_instance].xmlhttp.open(ajax_get, target_url, refresh != false);
				ajax_request_method=ajax_get;
			}
';
		if ($is_full_AJAX)
		{
			$script.='
			if (sticky_cart_dirty)
			{
				//sticky-cart was used for price display, re-init it for cart-display
				sticky_cart_dirty=false;
				DOM_element_html=box_CART.innerHTML;
				sticky_cart_set_info();
				sticky_cart.style.display=style_display_hide;
			}';
		}

		$script.='
			error_display=false;
			ajax_request_parameters=parameters;
			ajax_request_url=target_url;
//debug_stop();
			if (ajax_active_change)
			{
				if (no_show_ajax_wait_image)
				{
					no_show_ajax_wait_image=false;
				}
				else if (ajax_active_indicator_style)
				{
					if (!do_validation_request)
					{
						if (mouse_x)
						{
							if (mouse_y)
							{
								with (ajax_active_indicator_style)
								{
									if (ajax_active_indicator_float_width)
									{
										with (document)
										{
											if (document.all)
											{
												mouse_x+=(documentElement.scrollLeft ?
												   documentElement.scrollLeft :
												   body.scrollLeft);
												mouse_y+=(documentElement.scrollTop ?
												   documentElement.scrollTop :
												   body.scrollTop);
											}
										}
										with (Math)
										{
											ajax_active_indicator_left=max(0,(mouse_x-ajax_active_indicator_float_width_2));
											ajax_active_indicator_top=max(0,(mouse_y-ajax_active_indicator_float_height_2));
										}
										left=ajax_active_indicator_left+pixel;
										top=ajax_active_indicator_top+pixel;
									}
									display=style_display_show;
								}
							}
						}
					}
				}
			}
      http_requests[request_instance].xmlhttp.send(parameters);
      if (!debug_it)
      {
      	ajax_request_timeout[request_instance]=
      		window.setTimeout("check_timeout("+request_instance+")", timeout_interval);
      }
      /*
			if (is_IE)
			{
				with (iebody)
				{
		      scroll_left=scrollLeft;
		      scroll_top=scrollTop;
				}
			}
			else
			{
				with (window)
				{
		      scroll_left=pageXOffset;
		      scroll_top=pageYOffset;
				}
			}
			*/
      return false;
		}
  }
  else
  {
  	window.location.href=target_url;				//Force normal reload
  }
}

function add_parameter(target_url,parameters,parameter,add_separator)
{
//debug_stop();
	if (parameter)
	{
		if (add_separator)
		{
    	if (target_url.indexOf(questionmark) != -1)
      {
        i=ampersand;
      }
      else
      {
        i=questionmark;
      }
	  }
	  else
	  {
	  	i=empty_string;
	  }
	  //Test if additional parameters available. If yes, add parameters to url
	  if (parameters.length>0)
	  {
	  	i+=parameters+seo_separator;
	  }
		parameters=i+parameter;											//Add "AJAX-processing" indicator to parameters
		if (add_separator)
		{
			parameters=target_url+parameters;
    }
  }
	return parameters;
}

function rewrite_DOM_element(http_request_instance)
{
	if (http_requests[http_request_instance].active)
	{
		with (http_requests[http_request_instance].xmlhttp)
		{
			XHTTP_state=http_requests[http_request_instance].xmlhttp.readyState;
			window.status=XHTTP_states_text[XHTTP_state];
	    if (XHTTP_state == 4)
	    {
				window.status=empty_string;
				document_body_style_cursor=cursor_normal;
	    	if (status==200)
	      {
					if (ajax_active_change)
					{
						ajax_active_indicator_style.display=style_display_hide;
					}
        	data_returned=XHTTP_state=http_requests[http_request_instance].xmlhttp.responseText;
//debug_stop();
      		http_request_stop(http_request_instance);
        	if (data_returned == empty_string)
        	{
        		//Just do nothing. (Might be result of validation)
        		do_validation_request=false;
        		return;
        	}
        	else
	        {
	        	if (trim(data_returned)==restart_text)
	        	{
	        		//Restart program from scratch (after Skin change)
	        		location.href=calling_url;
	        	}
	        	else
	        	{
	        		element_name=php_fatal_error_text;
	        		i=data_returned.indexOf(element_name);
	        		condition=i!=-1;
	        		if (!condition)
	        		{
		        		element_name=php_parse_error_text;
		        		i=data_returned.indexOf(element_name);
		        		condition=i!=-1;
		        		if (!condition)
		        		{
			        		element_name=smarty_fatal_error_text;
			        		i=data_returned.indexOf(element_name);
			        		condition=i!=-1;
		        		}
	        		}
		        	if (condition)
	        		{
//debug_stop();
								if (data_returned.indexOf(debug_output)==-1)
								{
			        		current_element=extractText(hash+element_name+hash);
			        		if (!current_element)
			        		{
				        		current_element=extractText(hash+main_content_text+hash);
			        		}
			        		if (!current_element)
			        		{
			        			//Remove HTML_tags
				        		current_element=data_returned.replace(/<\/?[^>]+(>|$)/g,empty_string);
			        		}
			        		if (current_element)
			        		{
										current_element=current_element.replace(fatal_error_newline_text,fatal_error_newline_replace_text);
										show_error(current_element);
										return;
			        		}
		        		}
        			}
	        	}
	        	validation_error=false;
        		validation_error_message=extractText(fatal_error_delimiter);
        		//Fatal error data_returned?
        		if (validation_error_message.length>0)
        		{
        			if (validation_error_message.indexOf(mysql_text)!=-1)
        			{
        				show_error(validation_error_message);
        			}
        			else
        			{
	        			validation_error_message=convert_HTML_entities(validation_error_message);
        				alert(validation_error_message);
        			}
        			validation_error=true;
        		}
';
		if ($is_full_AJAX)
		{
			$script.='
      			if (do_validation_request)
	        	{
	        		do_validation_request=false;
							current_element=$(validation_element_function);
							if (!validation_error)
							{
		        		//Revoverable error data_returned?
								validation_value=extractText(value_delimiter);
		        		validation_error_message=extractText(recoverable_error_delimiter);
		        		if (validation_error_message.length>0)
		        		{
									if (confirm(convert_HTML_entities(validation_error_message)))
		        			{
		        				current_element.value=validation_value;
			        		}
			        		else
			        		{
			        			validation_error=true;
			        		}
		        		}
								else
								{
									validation_element_function=extractText(action_delimiter);
									if (validation_element_function.length==0)
									{
										//Unexpected return, display complete page!
										main_content.innerHTML=data_returned;
									}
									else
									{
										//Selection-box data_returned?
			        			//Refer to span for select-box
			        			current_select_box_name=validation_element_function+select;
				        		validation_error_message=extractText(select_box_delimiter);
				        		if (validation_error_message.length>0)
				        		{
			        				//Set validated selection box
				        			current_select_box=$(current_select_box_name);
				        			current_select_box.innerHTML=validation_error_message;
				        			if (validation_element_function==entry_state_text)
				        			{
				        				if (validation_error_message==nbsp_text)
					        			{
					        				//country has no states -> hide state area
													sticky_cart_visible_new=style_display_hide;
												}
												else
												{
					        				//country has states -> show state area
													sticky_cart_visible_new=style_display_show;
					        			}
					        			current_select_box_name=entry_state_area_text+underscore;
					        			//Show/hide state display areas
					        			current_element=$(current_select_box_name+1);
				        				with (current_element.style)
					        			{
					        				if (display!=sticky_cart_visible_new)
					        				{
					        					display=sticky_cart_visible_new;
							        			$(current_select_box_name+2).style.display=
							        			sticky_cart_visible_new;
							        			$(current_select_box_name+3).style.display=
							        			sticky_cart_visible_new;
					        				}
					        			}
					        			current_element=entry_country_id_text;
				        			}
				        			else if (validation_element_function==customers_firstname_text)
				        			{
				        				customers_firstname_error=true;
				        			}
				        			else
				        			{
					        			current_select_box_name=validation_element_function+select_box;
					        			current_element=$(current_select_box_name);
					        			with (current_element)
					        			{
						        			selectedIndex=1;		//Set to first selection entry
						        			ignore_gender_check=true;
													selection_done(current_select_box_name);
						        			ignore_gender_check=false;
						        			selectedIndex=0;		//Set back first entry
					        			}
					        			current_element=current_select_box_name;
				        			}
				        			current_element=$(current_element);
				        			validation_error=true;
				        		}
				        		else
				        		{
				        			//Delete any displayed SELECT BOX
				        			current_select_box=$(current_select_box_name);
				        			with (current_select_box)
				        			{
					        			if (innerHTML!=empty_string)
					        			{
					        				innerHTML=empty_string;
					        			}
				        			}
				        			current_element.value=validation_value;
				        			validation_element_function=extractText(action_delimiter);
				        			DOM_area_rewrite=true;
											switch (validation_element_function)
											{
											  case customers_firstname_text:
													validation_vorname_done=true;
											  	current_element=$(customers_lastname_text)
											    break;
											  case entry_postcode_text:
											  	//Set additional info
									  			set_adress_info(extractText(ort_delimiter), extractText(state_delimiter),
									  				extractText(area_code_delimiter));
											  	current_element=$(entry_city_text)
											    break;
											  case banktransfer_blz_text:
											  	//Set additional info
											  	set_bank_info(extractText(bank_delimiter));
											  	current_element=$(banktransfer_number_text)
											    break;
											  case banktransfer_number_text:
													validation_konto_done=true;
											  	current_element=$(banktransfer_bankname_text);
											  	DOM_area_rewrite=false;
											}
									  	validation_error=true;
				        		}
									}
		        		}
		        		with (current_element)
		        		{
			        		if (validation_error)
			        		{
			        			focus();
			        		}
			        		else
			        		{
			        			if (DOM_area_rewrite)
			        			{
			        				value=validation_value;
											validation_required=false;
			        			}
			        		}
		        		}
	        		}
	        	}
	        ';
		}
		$script.='
	        	else if (!validation_error)
	        	{
		        	if (data_returned.substring(0,100).indexOf(AJAX_NODATA)==-1)				//Pseudo data, no action required
		        	{
		        		index_returned=extractText(index_delimiter);
			        	if (index_returned)
			        	{
									update_DOM_entries(true);
			        		validation_error_message=extractText(info_message_delimiter);
			        		//Info-Message returned? (i.e.: legal return plus message!)
			        		if (validation_error_message.length>0)
			        		{
		        				show_error(validation_error_message,false);
			        		}
								}
								else if (is_admin_function)
								{
									if (data_returned.indexOf(attributemanager_message_delimiter)!=-1)
									{
										//Drop message-id
										data_returned=data_returned.substring(attributemanager_message_delimiter_len);
										//Call attribute manager update
				      			amUpdateContent();
									}
								}
							}
						}
		      	if (is_IE)
		      	{
							/* Avoid memory leak in MSIE: clean up the onreadystatechange event handler */
			      	onreadystatechange=empty_function;
			      	//Restart animated gifs.... IE for some reason stops animation after AJAX-Request!!!!
			      	current_element=document.getElementsByTagName("img");
			      	if (current_element)
			      	{
			      		//Loop thru all images and redisplay all gifs
			      		current_elements=current_element.length;
			      		for (i=0;i<current_elements;i++)
			      		{
			      			with (current_element[i])
			      			{
			      				if (src.indexOf(gif_text)!=-1)
			      				{
				      				if (height<=50)
				      				{
					      				if (src.indexOf(ajax_activity_text)==-1)
					      				{
					      					//Force reload of image
					      					src=src;
					      				}
				      				}
			      				}
			      			}
			      		}
			      	}
		      	}
						return true;
	        }
        }
        http_request_stop(http_request_instance);
	    	window.location.href=save_url;		//Force normal reload
	    }
    }
  }
}

function show_error(error_text,copy)
{
	//Strip HTML-tags
	error_text=convert_HTML_entities(trim(error_text));
	error_text=error_text.replace(/(<([^>]+)>)/ig,empty_string);
	if (debug_it)
	{
		prompt("Kritischer Fehler\n\n"+error_text, error_text);
	}
	else
	{
		/*
		if (copy)
		{
			window.clipboardData.setData("Text",error_text);
		}
		error_text+="\n\nDie Fehlermeldung wurde auch in die Zwischenablage kopiert!";
		*/
		alert (error_text);
	}
}

function trim(str)
{
	if (str)
	{
		return str.replace(/^\s*|\s*$/g,empty_string);
	}
}

function empty_function()
{
}

function $()
{
	var i,elements = new Array();

	for (i = 0; i < arguments.length; i++)
	{
		var element = arguments[i];
		if (typeof(element) == "string")
		{
			element = document.getElementById(element);
		}
		if (arguments.length == 1)
		{
			return element;
		}
		else
		{
			elements.push(element);
		}
	}
	return elements;
}

function MouseDown(event)
{
	MouseCoords(event);
	mouse_is_down=true;
}

function MouseUp()
{
	mouse_is_down=false;
	current_event=null;
	event_source=null;
}

function MouseCoords(event)
{
	if (!event)
	{
		event=window.event;
	}
	current_event=event;
	with (event)
	{
	  if (document.all)
	  {
			/* MSIE, Konqueror, Opera : */
	    mouse_x=clientX;
	    mouse_y=clientY;
	    /*
	    window.status="mouse_x="+mouse_x+", mouse_y="+mouse_y;
	    */
	  }
	  else
	  {
			/* Netscape, Mozilla : */
	    mouse_x=pageX;
	    mouse_y=pageY;
	  }
	}
	/*
	if (event.pageX || event.pageY)
	{
		return {x:event.pageX, y:event.pageY};
	}
	else
	{
		current_element=document.body;
		return {
			x:event.clientX + current_element.scrollLeft-current_element.clientLeft,
			y:event.clientY + current_element.scrollTop -current_element.clientTop
		}
	}
	*/
}

function extractText(delimiter) {
	//Extract part of text between #delimiter#.......#delimiter#
	subtext=empty_string;
	delimiter=hash+delimiter+hash;
	poss=data_returned.indexOf(delimiter);							//Find 1st delimiter position
	if (poss != -1)
	{
		poss+=delimiter.length;
		pose=data_returned.indexOf(delimiter, poss);			//Find 2nd delimiter position
		if (pose != -1)
		{
			subtext=data_returned.substring(poss, pose);		//Extract delimited text
		}
	}
	return subtext;
}

var max_products_qty='.MAX_PRODUCTS_QTY.';
var current_template="'.CURRENT_TEMPLATE.'";
//Use ajax_dhtmlHistory.js for browser navigation?
var use_native_history_navigation='.USE_NATIVE_HISTORY_NAVIGATION.';
//DHTMLHistory new location name
var newLocation;
//Use ajax_storage.js for cross-session data storage?';
		if (USE_CROSS_SESSION_STORAGE=="true")
		{
			$script.='
var use_cross_session_storage='.USE_CROSS_SESSION_STORAGE.SEMI_COLON;
		}
		$script.='
var currency_trimmed="'.SESSION_CURRENCY.'";
var calling_url="'.$referer.'";
var currency=blank+currency_trimmed;
var base_price_end=") </font>";
var have_trailing_currency;
var cart_has_products=false;
var pose,poss,poss_start,subtext;

var at="@",at1=at+"1",at2=at+"2",nbsp_text="&nbsp;",elipsis="...",action_text="action=";
var lparen="(",rparen=")",underscore="_",sec_blank=String.fromCharCode(160),x="x";
var lsb="[",rsb="]",lcb="{",rcb="}",lab="<",rab=">",id_search_text=" id=";

//Do not update any after product order with attributes!
//Otherwise the selected attributes will not be visible anymore
//This is the case with conventional mode, too, but AJAX is much better!

var update_main_content=true,attributes_purchase=false,is_main_content,is_price_display;

function window_onerror(msg, url, line)
{
	if (false)
	{
		var hr;       	// URL der augenblicklichen Seite
		var appcode;  	// Codename des Browsers
		var app;      	// Programmname des Browsers
		var ver;      	// Betriebssystem und Version des Browsers
		var usr;      	// Programmheader in HTTP
		var parameter;  // URL und Query String des serverseitigen Scripts
				 	  				// das den Fehler weiterverarbeitet
		var qs;       	// Query String der beim Aufruf dieser Seite benutzt wird

		with (window.location)
		{
			hr=href;
			qs=search;
		}
		if (qs.indexOf("=return")==-1)
		{
			with (navigator)
			{
				appcode=appCodeName;
				app=appName;
				ver=appVersion;				usr=userAgent;
				/*
				parameter+="?Url="+escape(url)+"\n";
				parameter+="&Line="+escape(line)+"\n";
				parameter+="&Msg="+escape(msg)+"\n";
				parameter+="&Appcode="+escape(appcode)+"\n";
				parameter+="&App="+escape(app)+"\n";
				parameter+="&Ver="+escape(ver)+"\n";
				parameter+="&Usr="+escape(usr)+"\n";
				//Report Javascript error back home
				make_AJAX_Request("ajax_js_error_report.php"+parameter,false,empty_string,empty_string);
				request_active=false; //Forget about request!
				*/

				parameter="Url="+url+"\n";
				parameter+="Line="+line+"\n";
				parameter+="Msg="+msg+"\n";
				parameter+="Appcode="+appcode+"\n";
				parameter+="App="+app+"\n";
				parameter+="Ver="+ver+"\n";
				parameter+="Usr="+usr+"\n\n";
				parameter+="Fehler ignorieren?";
				return confirm(parameter);
			}
	  }
  }
  return true;
}
';
		if (USE_AJAX_ADMIN)
		{
			$script.='
var box_RIGHT_text="box_RIGHT";
var history_areas_to_ignore=" box_LEFT1 "+box_RIGHT_text,navRight_style;
var iframe_upload_document,iframe_upload_text="iframe_upload";
';
		}
		else
		{
			$script.='
var history_areas_to_ignore=box_CART_text;
';
		}
		$script.='
var scroll_left=0,scroll_top=0;
var AJAX_REQUEST_FUNC_START="'.AJAX_REQUEST_FUNC_START.'";
var AJAX_REQUEST_FUNC_END="'.AJAX_REQUEST_FUNC_END.'";

var cart_text="cart_";
var sticky_cart_interval,sticky_cart_scroll_routine=cart_text+"scroll()",sticky_cart_text="sticky_cart";
var sticky_cart_init_done=false,sticky_cart_dirty=false,sticky_cart_data_dirty=false,activate_sticky_cart_style;
var use_sticky_cart,sticky_cart_visible_text,sticky_cart_visible,sticky_cart_visible_scroll,cart_top,cart_Left;
var sticky_cart_visible_new=true,sticky_cart_visible_new_save,sticky_cart,window_scroll_interval,sticky_cart_set;
var sticky_cart_show_global=true,sticky_cart_show=true,sticky_cart_display,sticky_cart_width;

var current_elements,current_element,current_extra_element,current_select_box,current_select_box_name;
var element_type,element_name,element_value,current_title;
var submitContent=empty_string,formElem,lastElemName=empty_string;
var DOM_area,DOM_area_name,DOM_element_html,DOM_element_html_show,DOM_area_rewrite;
var formElem,form_method,new_quantity,min_quantity,stock_quantity
var cart_min_quantity_text=cart_text+"min_quantity_",attributes_string;
var products_min_order_quantity_text="products_min_order_quantity";
var validation_required=false;						//Validate required
var check_for_validation_required=false		//Check for validate required
var validation_konto_done=false,validation_blz_done=false;
var do_validation_request=false;					//Validate element data
var vorname_plz_required=false,blz_konto_required=false;
var style_display_show="inline",style_display_hide="none",style_display;
var cart_details_style,cart_details_state=style_display_hide;
var is_box_cart,update_box_cart=true,is_file_upload=false;
var history_data,current_history_data,history_title,history_entries=-1
var history_areas_array=new Array(),history_areas_count=2;
var all_areas_array=new Array(),all_areas_count=-1;

var current_position=0,button_left_style,button_right_style;
var button_text="button_",area;
var vorname_plz_index,blz_konto_index,sticky_cart_index=0,curpos_index,title_index,max_index;
var cell_style,cell_onclick,cell_onmouseover,cell_onmouseout,cell_title,cell_height,menu_top_delta;
var table,tbody,row,cell,cell_text,tbody_text="tbody",tr_text="tr",td_text="td";
var cell_color_hilite,cell_bgcolor_hilite,cell_color_normal,cell_bgcolor_normal;

//Define areas to ignore in History Snapshot!
//Cart always contains all products!! The other boxes never change!
var allow_add_to_history,ctrlkey,condition=false;
var update_whos_online="update_whos_online.php?url="
var navRight_text="navRight";
var no_show_ajax_wait_image=false;
//Define areas to ignore in History Snapshot!
//Cart always contains all products!! The other boxes never change!

var cart_visibility_top,pull_down_menu;
var window_innerHeight,window_innerWidth,iebody, window_scroll_top;
var INPUT_tagNames_include="INPUT SELECT TEXTAREA"; 	//HTML-tags for form-input fields
var element_text_types=" text hidden password";		//HTML-types for TEXT-input fields
var element_check_types=" radio checkbox";			//HTML-types for SELECTION fields
var attribute_control,form_object,form_name,form_action,post_form,post_data,j,k,input_tags=new Array();
var validation_separator=" -";
var validation_prog="ajax_validation.php"
var validation_element=empty_string;								//Validated element
var validation_element_name=empty_string;						//Validated elements name
var validation_element_required;					//Validated elements required
var validation_element_caption=empty_string;				//Validated elements caption
var validation_element_function;					//Validated elements lower-case name
var validation_element_value;							//Validated elements value
var validation_element_value_short;				//Validated elements value (shortened to fit)
var validation_element_value_short_top_length=25;
var validation_element_value_short_entry_length=validation_element_value_short_top_length+2;
var validation_element_value_short_top_ok_length=validation_element_value_short_top_length-elipsis.length;
var validation_element_value_short_entry_ok_length=validation_element_value_short_entry_length-elipsis.length;
var validation_element_value_length;
var validation_extra_parameter_value;			//Additional elements value
var validation_extra_element_caption;
var validation_extra_parameter_check=false;
var validation_by_select_box=false;
var validation_min_key_len=0;

//Local price calc for attributes
var products_id,products_id_string,cart_products_id,cart_products_id_text=cart_text+"products_id_";
var cart_min_quantity,found_id,substring_start,error_display;
var options_area_text="options_area",have_options,have_radio_options,do_product_info
var show_hide_cart_entry,real_show_hide_cart_entry,show_cart_entry;
var options_have_price_text="options_have_price",options_have_price;
var update_cart_button_text="update_cart";
var validation_price_text="price_";
var validation_products_text="products_";
var products_name_text=validation_products_text+"name_";
var validation_products_id=validation_products_text+"id_";
var validation_products_price_text=validation_products_text+validation_price_text;
var validation_final_price;
var products_qty_text=validation_products_text+"qty";
var validation_products_qty_text=validation_products_text+"qty_",validation_products_qty;
var validation_currrent_products_qty_text,validation_current_products_price_text;

var validation_products_price_text=validation_products_text+validation_price_text;
var products_price_id_text=validation_products_price_text+"id";
var validation_products_price_display_text=validation_products_price_text+"display";
var validation_products_price_display_2_text=validation_products_price_display_text+"_2";
var validation_products_price_net_text=validation_products_price_text+"net"+underscore;
var cart_total_price_line_text= cart_text+"total_price_line";
var cart_content_text=cart_text+"content",cart_lfd_text=cart_text+"lfd_"
var validation_cart_total_price_text=cart_text+"total_price",cart_total_price;
var validation_cart_total_price_short_text=validation_cart_total_price_text+"_short";
var cart_items_short_text=cart_text+"items_short";
var validation_cart_total_price_undiscounted_text=validation_cart_total_price_text+underscore+"undiscounted",
	cart_total_price_undiscounted;

var validation_cart_item_total_price_text=cart_text+"item_total"+underscore+validation_price_text,item_total_price;
var total_discount_value_text="total_discount_value",discount_value;
var cart_total_discount_value_text=cart_text+total_discount_value_text,cart_discount_value;
var cart_empty_message_text=cart_text+"empty_message",cart_empty_message_style_display;
var cart_save_link_text=cart_text+"save_link";
var validation_cart_total_price_1_text=validation_cart_total_price_text+underscore+"1";
var validation_cart_line_text=cart_text+"line_",cart_line;		//cart_line_prototype,
var cart_no_show_parameter="&cart_no_show=true";

var validation_vorname_plz_delimiter="validation_vorname_plz";
var validation_vorname_done=false,validation_plz_done=false;
var validation_blz_konto_delimiter="validation_blz_konto";

var have_check_land=true;
var land,land_id,selected_index,last_selected_index;
var param_action="action=";
var param_value=ampersand+"value=";
var param_caption=ampersand+"caption=";
var param_land=ampersand+"land=";
var param_store_country=ampersand+"store_country=";
var param_multishop=ampersand+multi_shop_directory_name+"="+multi_shop_directory_value;
var param_extra_parameter="&extra_parameter=";
var validation_land_germany_id="81",validation_land_germany="D",is_germany;
var validation_land_austria_id="14",validation_land_austria="A";
var validation_land_switzerland_id="204",validation_land_switzerland="CH";
var selection_gender,current_selected_gender,anrede,vorname,ignore_gender_check=false;
var male_short="m";

var action_delimiter="action";
var value_delimiter="value";
var ort_delimiter="ort";
var state_delimiter="state";
var area_code_delimiter="vorwahl";
var bank_delimiter="bank";
var product_options_delimiter="product_options",product_options;

var radio_text="radio",input_text="input";
var select="_select",box="_box",select_box=select+box;
var select_box_delimiter=select_text+box,cart_check_text=cart_text+"check_",cart_value_element;
var form_cart_quantity_text=cart_text+"quantity",cart_quantity_text=form_cart_quantity_text+underscore;
var cart_stock_quantity,cart_stock_quantity_text=cart_text+"stock_quantity";
var customers_gender_text="customers_gender";
var customers_firstname_text="customers_firstname",customers_firstname_error;
var customers_lastname_text="customers_lastname";
var customers_email_address="customers_email_address";
var customers_phone_text="customers_telephone";
var customers_fax_text="customers_fax";
var customers_dob_text="customers_dob",DateSep=dot,m_arrDate,m_DAY,m_MONTH,m_YEAR,dat,jahr,monat,tag;
var entry_postcode_text="entry_postcode";
var entry_country_id_text="entry_country_id";
var entry_state_area_text="entry_state_area";
var banktransfer_blz_text="banktransfer_blz";
var banktransfer_number_text="banktransfer_number";
var banktransfer_bankname_text="banktransfer_bankname";
var entry_city_text="entry_city";
var entry_state_text="entry_state";
var entry_state_area_text=entry_state_text+"_area";
var control_text="control_",left_text="left",right_text="right";
var window_scroll_routine="window_scroll()",window_scrolled=false,process_scrolling,last_page_top;
var double_new_line="<br/><br/>",this_this_keycode;
var sticky_price_wrapper_start=double_new_line+"<b><font size=\"2\">";
var font_end="</font>";
var sticky_price_wrapper_end=font_end+'.QUOTE.HTML_B_END.QUOTE.';
var pixel="px";
';
		if (SCRIPT_DYN_LOAD)
		{
			$script.='
function ajax_init_real()
';
		}
		else
		{
			$script.='
function ajax_init()
';

		}
		$script.='
{
	if (!AJAX_init_done)
	{
';
		if (SHOW_COOL_MENU)
		{
			$script.='
		cool_menu_position(true);
';
		}
		$script.='
//debug_stop();
		http_request_instance=init_http_request_object();			//Check if XMLHttp can bei initialized.
		if (http_request_instance==-1)
		{
			location.href="ajax_error.php?action=no_http_request";
		}
		else
		{
			http_request_stop(http_request_instance);
		}
		';
		/*
		if (USE_CROSS_SESSION_STORAGE=="true")
		{
		$script.='
		if (use_cross_session_storage)
		{
		storage.onLoad(amass_initialize);
		}
		';
		}
		*/
		$script.='
		document_body_style_cursor=document.body.style.cursor;
		history_title=new Array();
		history_data=new Array();
		validation_required=false;
		history_areas_array[0]=empty_string;
		history_areas_array[2]=main_content_text;
		//Find all areas, which might change ("box_xxxxx"), remember their names, and build index
		//Save all "box_xxxx" names, apart from boxes to ignore.
		var divs=document.getElementsByTagName("div")
		var divs_count=divs.length
		condition=true;
		for (i=0;i<divs_count;i++)
		{
			element_name=divs[i].id;
			if (element_name.indexOf("'.BOX.'")!=-1)	//Box div?
			{
				all_areas_count++;
				all_areas_array[all_areas_count]=element_name;
				if (use_layout_definition)
				{
					condition=history_boxes.indexOf(element_name)!=-1;
				}
				if (condition)
				{
					if (history_areas_to_ignore.indexOf(element_name)==-1)  	//Box to ignore??
					{
						history_areas_count++;
						history_areas_array[history_areas_count]=element_name;
					}
				}
			}
		}
		//Define indexes for additional data
		vorname_plz_index=history_areas_count+1;
		blz_konto_index=vorname_plz_index+1;
		title_index=blz_konto_index+1;
		curpos_index=title_index+1;
		max_index=curpos_index;
		history_areas_count++;
';
		if (USE_AJAX_ADMIN)
		{
			$script.='
		use_sticky_cart=false;				//No sticky-cart in Admin
		navRight_style=document.getElementById(navRight_text).style;		//Reference to box_RIGHT style
		history_areas_array[1]=empty_string;
debug_stop();
		iframe_upload_document=$(iframe_upload_text).document;
';
		}
		else
		{
			$s='USE_STICKY_CART';
			if (!defined($s))
			{
				defined($s,true);
			}
			if (USE_STICKY_CART)
			{
				$use_sticky_cart="true";
			}
			else
			{
				$use_sticky_cart="false";
			}
			//if (!($_SESSION['allow_keys']))
			if (!(IS_LOCAL_HOST || $_SESSION['allow_keys']))
			{
				$script.='
		addKeyEvent();
		//To disable the right mouse button
		document.oncontextmenu=new Function("return false");
';
			}

			$script.='
		iebody=(document.compatMode=="CSS1Compat")?document.documentElement:document.body;
		history_areas_array[1]="navtrail";

		use_sticky_cart='.$use_sticky_cart.';

//debug_stop();
		//var i=use_sticky_cart || not_use_native_history_navigation;
		var i=use_sticky_cart;
		if (i)
		{
			//Set reference to CSS sytles in  e x t e r n a l  CSS-file!!!!
			//in oder to set some items to style used.
			var bodyStyle;

			with (document)
			{
				//if (body.currentStyle)
				if (is_IE)
				{
					//IE
					bodyStyle=body.currentStyle;
				}
				else if (window.getComputedStyle)
				{
					bodyStyle=window.getComputedStyle(body, null);
				}
			}
			with (bodyStyle)
			{
				cell_color_normal=color;
				cell_bgcolor_normal=backgroundColor;
				cell_color_hilite=cell_bgcolor_normal;
				cell_bgcolor_hilite=cell_color_normal;

				var body_background_image=backgroundImage;
				var body_background_color=backgroundColor;
				var cart_background_color=body_background_color;
				var border_style="solid 1px "+cell_color_normal;
			}
			if (i)
			{
				box_CART=$(box_CART_text);
				if (use_sticky_cart)
				{
					sticky_cart_index=curpos_index+1;
					max_index=sticky_cart_index;
					sticky_cart=$(sticky_cart_text);
					if (sticky_cart)
					{
						sticky_cart.style.display=style_display_hide;
						sticky_cart_show=false;
						current_value=empty_string;
						validation_value=empty_string;
						sticky_cart_width=0;
						//var current_td;
						current_extra_element=new Array(box_CART_text,"navLeft",navRight_text);
						for (i=0;i<=current_extra_element.length;i++)
						{
							//current_td=$(current_extra_element[i]);
							if ($(current_extra_element[i]))
							{
								validation_value=empty_string;
								current_value=empty_string;
								if (is_IE)
								{
									with ($(current_extra_element[i]))
									{
										validation_value=currentStyle["width"];
										current_value=currentStyle["backgroundColor"];
									}
								}
								else
								{
									with (document.defaultView)
									{
										if (getComputedStyle)
										{
											validation_value=getComputedStyle($(current_extra_element[i]),empty_string).getPropertyValue("width");
											current_value=
											getComputedStyle($(current_extra_element[i]),empty_string).getPropertyValue("background-color");
										}
									}
								}
								if (sticky_cart_width==0)
								{
									if (validation_value!="auto")
									{
										sticky_cart_width=validation_value;
									}
								}
								if (current_value!=empty_string)
								{
									if (current_value!="transparent")
									{
										cart_background_color=current_value;
									}
								}
							}
						}
						sticky_cart_width=parseInt(sticky_cart_width);
						if (sticky_cart_width==0)
						{
							sticky_cart_width=200;
						}
						//Find real "top"-Position of CART
						cart_top=findPosTop(box_CART);
						cart_left=findPosLeft(box_CART);
						with (sticky_cart.style)
						{
							border=border_style;
							backgroundImage=body_background_image;
							backgroundColor=cart_background_color;
							width=sticky_cart_width;
						}
						activate_sticky_cart_style=$("activate_sticky_cart");
						if (activate_sticky_cart_style)
						{
							activate_sticky_cart_style.innerHTML=sticky_cart_open_html;
							activate_sticky_cart_style=activate_sticky_cart_style.style;
						}
						document.onscroll=document_onscroll;
						document.body.onscroll=document_onscroll;
					}
					else
					{
						use_sticky_cart=false;
					}
				}
			}
		}
		else if (use_sticky_cart)
		{
			sticky_cart_width=200;
		}
		//animateinit();
';
		}
		$script.='
		main_content=$(main_content_text);
	  document.charset = "Windows-1252";
		//Check for AJAX-Activity display area
		ajax_active_indicator=$(ajax_active_indicator_text);
		current_extra_element=$(ajax_active_indicator_float_text);
		if (!ajax_active_indicator)
		{
			ajax_active_indicator=current_extra_element;
			current_extra_element=ajax_active_indicator;
		}
		if (ajax_active_indicator)
		{
			ajax_active_change=true;
			with (ajax_active_indicator)
			{
				with (style)
				{
//debug_stop();
					ajax_active_indicator_float_height=parseInt(height);
					ajax_active_indicator_float_width=parseInt(width);
				}
				ajax_active_indicator_float_height_2=ajax_active_indicator_float_height/2;
				ajax_active_indicator_float_width_2=ajax_active_indicator_float_width/2;
				if (ajax_active_indicator!=current_extra_element)
				{
					ajax_active_indicator.innerHTML=empty_string;
					ajax_active_indicator.style.visibility=ajax_active_style_hidden;
					ajax_active_indicator=current_extra_element;
				}
				/*
				document.onmousemove=MouseMove;
				*/
				document.onmousedown=MouseDown;
				document.onmouseup=MouseUp;
				document.onclick=onClick;
			}
			ajax_active_indicator_style=ajax_active_indicator.style;
			ajax_active_indicator_style.display=style_display_hide;
		}
		window.onresize=window_resize;
		window_resize();
'
		.$use_native_history_init_code.'
		i=add_parameter(empty_string,empty_string,empty_string,false);
//debug_stop();
		i=$(slideshow_big_text);
		if (i)
		{
			use_slideshow=true;
			slideshow_table_style=$(slideshow_big_text).style;
			for (i=0;i<'.sizeof($slideshow_id).';i++)
			{
				slideshowInterval.push('.(SLIDESHOW_INTERVAL*1000).');
				slideshowInterval_min.push('.(SLIDESHOW_INTERVAL_MIN*1000).');
				slideshow_request_active.push(false);
				slideshow_active.push(true);
				slideshow.push(0);
				slideshowTimer.push(0);
				slideshow_ids.push(0);
				previousEntryId.push(0);
				currentEntryId.push(0);

				slideshowInit(i);
			}
		}
		else
		{
			use_slideshow=false;
		}
		make_AJAX_Request(calling_url,true,empty_string,ajax_post);	//Switch to AJAX-mode
	}
}

//function MouseMove(event)
///* Ueberwachung der Mausbewegungen */
//{
//return false
//	if (!event) event=window.event;
//	with (event)
//	{
//	  if (document.all)
//	  {
//			/* MSIE, Konqueror, Opera : */
//	    mouse_x=clientX;
//	    mouse_y=clientY;
//	    /*
//	    window.status="mouse_x="+mouse_x+", mouse_y="+mouse_y;
//	    */
//	  }
//	  else
//	  {
//			/* Netscape, Mozilla : */
//	    mouse_x=pageX;
//	    mouse_y=pageY;
//	  }
//	}
//}
//

/** Our callback to receive history change events. */
function historyChange(newLocation,historyData)
{
	if (AJAX_init_done)
	{
		condition=historyData!=undefined;
		if (condition)
		{
			condition=historyData!=null;
		}
		if (condition)
		{
			current_position=historyData;
			update_history_context(true);
			if (is_admin_function)
			{
	    	if (current_position>0)								//"Nbsp"-only text becomes empty text
	    	{
	    		style_display=style_display_hide;
	    	}
	    	else
	    	{
	    		style_display=style_display_show;
	    	}
	    	with (navRight_style)
	    	{
	    		if (display!=style_display)
	    		{
	    			display=style_display;
	    		}
	    	}
			}
			else
			{
				//Update "whos online" database to reflect click!
				no_show_ajax_wait_image=true;
				make_AJAX_Request(update_whos_online+newLocation,false,empty_string,empty_string);
			}
		}
	}
}

function button_left()
{
	//Process "History back"
	current_position--;
	if (current_position<0)
	{
		current_position=0;
	}
	update_history_context(true);
}

function button_right()
{
	//Process "History forward"
	current_position++;
	if (current_position>history_entries)
	{
		current_position=history_entries;
	}
	update_history_context(true);
}

function control_change(control_name,table_cell)
{
	if (use_menu_navigation)
	{
		/*
		selected_index=parseInt(table_cell.id);
		if (selected_index>=0)
		{
			//For some reason, IE reports the wrong control info (control_name) on click!.
			//However, the, parent info is OK! So get control_name from the parent info.
			control_name=table_cell.parentNode.parentNode.parentNode.id;
			current_value=control_name.indexOf(left_text)!=-1;
			if (current_value)
			{
				control_name=left_text;
			}
			else
			{
				control_name=right_text;
			}
			menu_close(control_name);
			//Note: menu_close assigns "menu"
			if (current_value)
			{
				//Remember: pages are stored in reverse order!
				//# of entries in box, converted to index position
				element_value=$(menu_content+control_name).rows.length;
				current_position=element_value-selected_index;
			}
			else
			{
				current_position=current_position+selected_index;
			}
		}
		*/
	}
	else
	{
		current_element=$(control_text+control_name);
		selected_index=current_element.selectedIndex;
		if (control_name==left_text)
		{
			//Remember: pages are stored in reverse order!
			element_value=current_element.options.length-1;  //# of entries in box, converted to index position
			current_position=element_value-selected_index;
		}
		else
		{
			current_position=current_position+selected_index;
		}
	}
	update_history_context(true);
}

function update_history_context(update_dom)
{

	if (update_dom)
	{
		current_history_data=history_data[current_position];
		update_DOM_entries(false);
	}
}

function window_resize()
{
  if(typeof( window.innerWidth ) == "number")
  {
    //Non-IE
    with (window)
    {
	    window_innerWidth=innerWidth;
	    window_innerHeight=innerHeight;
    }
  }
  else
  {
  	var document_documentElement=document.documentElement;

	  if (document_documentElement && (document_documentElement.clientWidth || document_documentElement.clientHeight))
	  {
	    //IE 6+ in "standards compliant mode"
	    with (document_documentElement)
	    {
		    window_innerWidth=clientWidth;
		    window_innerHeight=clientHeight;
	    }
	  }
	  else
	  {
	  	var document_body=document.body;
	  	if(document_body)
		  {
		    //IE 4 compatible
		    with (document_body)
		    {
			    window_innerWidth=document_body.clientWidth;
			    window_innerHeight=document_body.clientHeight;
		    }
		  }
	  }
	}
	if (use_sticky_cart)
	{
		if (cart_left>100)			//Cart is in right navigation area
		{
			sticky_cart_left=window_innerWidth-sticky_cart_width;
			sticky_cart_left=Math.max(0,sticky_cart_left-25);		//-25 for padding-left:10px;padding-right: 10px in "box_CART"
			if (is_IE )
			{
				sticky_cart_left-=5;		//-5 for shadow!!
			}
			else
			{
				sticky_cart_left-=30;		//-30 for Scrollbar-width for Firefox et al!!
			}
		}
		else
		{
			sticky_cart_left=cart_left;
		}
		with (sticky_cart.style)
		{
			left=sticky_cart_left+pixel;
		}
	}
}

function make_AJAX_Request_POST(form_name,form_action)
{
//debug_stop();
	if (AJAX_init_done)
	{
		if (check_validation_done())
		{
			form_object=$(form_name);
			with (form_object)
			{
				current_element=$(options_area_text);		//Check if we have options!
				if (current_element)
				{
					//Product has options! Check if one option is selected for radio-type options!
					current_extra_element=current_element.getElementsByTagName(input_text);
					current_elements=current_extra_element.length;
					if (current_elements>0)
					{
						if (current_extra_element[0].type.toLowerCase()==radio_text)		//Radio-buttons?
						{
							condition=true;
							for (current_element=0;current_element<current_elements;current_element++)
							{
								validation_element=current_extra_element[current_element];
								if (current_element==0)
								{
									validation_element_value=validation_element;
								}
								if (validation_element.checked)
								{
									condition=false;
									break;
								}
							}
							if (condition)
							{
								if (current_elements>1)
								{
									alert("Sie müssen zuerst eine Produkt-Option wählen!");
									validation_element_value.focus();
									return false;
								}
							}
						}
					}
				}
				post_data=collect_form_data(form_object);
				if (is_file_upload)
				{
					is_file_upload=false;
	debug_stop();
					iframe_upload_document.body.innerHTML=outerHTML;
					iframe_upload_document.forms[0].submit();
					return false;
				}
				else
				{
					form_method=method.toUpperCase();
					if (form_action==empty_string)
					{
						current_element=getAttributeNode("action");
						if (current_element)
						{
							form_action=current_element.value;
						}
					}
					if (typeof(form_action)=="string" )
					{
						if (form_action!=empty_string)
						{
							is_get=form_method==ajax_get;
							if (use_seo || is_get)
							{
								//"mod_rewrite" does not transfer POST-parameters(??), so force GET if in SEO-Mode, and append POST-Parameters
								if (form_action.indexOf(seo_text)!=-1 || is_get)
								{
									form_method=ajax_get;
						  		if (form_action.indexOf(questionmark)==-1)
						  		{
							  		form_action+=questionmark;
						  		}
						  		else
						  		{
							  		form_action+=ampersand;
						  		}
									//form_action+=post_data_follows+post_data;
									form_action+=post_data;
									post_data=empty_string;
								}
							}
						}
					}
				}
			}
			sticky_cart_visible=false;
			make_AJAX_Request(form_action,form_method==ajax_post,post_data,form_method);
			if (products_info_active)
			{
				products_info_area.innerHTML=empty_string;
	      products_info_active=false;
			}
		}
	}
	else
	{
		alert(wait_for_init_message);
		show_loaded=true;
	}
	return false;
}

function check_validation_done()
{
	if (vorname_plz_required || blz_konto_required)
	{
		message=empty_string;
		current_element=empty_string;
		if (vorname_plz_required)
		{
			if (!validation_vorname_done)
			{
				message=vorname_text;
				current_element=customers_firstname_text;
			}
			if (!validation_vorname_done)
			{
				if (message.length>0)
				{
					message+=und_text;
				}
				message+=plz_text;
				if (!current_element)
				{
					current_element=entry_postcode_text;
				}
			}
			validation_plz_done=false;
		}
		else
		{
			if (!validation_blz_done)
			{
				message=blz_text;
				current_element=banktransfer_blz_text;
			}
			if (!validation_konto_done)
			{
				if (message.length>0)
				{
					message+=und_text;
				}
				message+=kontonummer_text;
				if (!current_element)
				{
					current_element=banktransfer_number_text;
				}
			}
		}
		if (message.length>0)
		{
			message="Für die folgenden Felder ist noch keine Validierung erfolgt: "+message+"\n\n";
			message+="Bitte gehen Sie zu den entsprechenden Feldern, und lassen Sie dies(e) überprüfen!";
			alert(message);
			$(current_element).focus();
			return false;
		}
		else
		{
			return true;
		}
	}
	else
	{
		return true;
	}
}

function update_DOM_entries(add_to_history)
{
	//Get index of areas contained in text
	current_title=empty_string;
	if (add_to_history)
	{
		DOM_element_html=extractText(index_delimiter);
		DOM_areas_array=DOM_element_html.split(blank);
		DOM_areas=DOM_areas_array.length;
		DOM_area_rewrite=DOM_element_html.length>0;
		not_slideshow_only=DOM_element_html.indexOf(slideshow_only_text)==-1;
		current_title=convert_HTML_entities(extractText(title_delimiter));
	}
	else
	{
		//Navigation history action!
		//DOM_areas_array=current_history_data;
		DOM_areas=history_areas_count;
		DOM_area_rewrite=true;
		current_title=history_title[current_position];
	}
	rewritten=false;
	if (DOM_area_rewrite)
	{
		if (not_slideshow_only)
		{
			if (current_title)
			{
				if (current_title!=undefined)
				{
					document.title=current_title;	//Set new page title
				}
			}
			sticky_cart_set=false;
	   	set_top_of_screen=false;
	   	product_options=empty_string;
			validation_vorname_done=false;
			validation_plz_done=false;
			validation_konto_done=false;
			validation_blz_done=false;
			if (use_sticky_cart)
			{
		   	if (add_to_history)
		   	{
					sticky_cart_visible_text=extractText(sticky_cart_text);
		   	}
		   	else if (current_history_data[sticky_cart_index])
		   	{
					sticky_cart_visible_text=current_history_data[sticky_cart_index];
		   	}
		   	else
		   	{
					sticky_cart_visible_text=empty_string;
		   	}
				if (sticky_cart_visible_text.length>0)
				{
					sticky_cart_visible_new=sticky_cart_visible_text=="true";
	  			sticky_cart_visible_new_save=sticky_cart_visible_new;
					if (add_to_history)
					{
						if (sticky_cart_visible_new!=sticky_cart_show)
						{
							//Check if "box_CART" in index
							if (DOM_element_html.indexOf(box_CART_text)==-1)
							{
								//If not, set new status here!
								sticky_cart_dirty=false;
								DOM_element_html=box_CART.innerHTML;
								sticky_cart_set_info();
							}
						}
					}
				}
			}
			if (!AJAX_init_done)
			{
				rewritten=true;
				AJAX_init_done=true;
				if (show_loaded)
				{
					show_loaded=false;
					alert(show_loaded_message);
				}
				/*
				//Get prototype for cart_line and delete it
				with ($(validation_cart_line_text+x))
				{
					cart_line_prototype=innerHTML;
					//innerHTML=empty_string;
					style.display=style_display_hide;
				}
				*/
			}
	   	//Check if form requiring validation is loaded!
	   	if (add_to_history)
	   	{
				vorname_plz_required=extractText(validation_vorname_plz_delimiter)=="true";
				blz_konto_required=extractText(validation_blz_konto_delimiter)=="true";
	   	}
	   	else
	   	{
				vorname_plz_required=current_history_data[vorname_plz_index];
				blz_konto_required=current_history_data[blz_konto_index];
	   	}
   		show_slideshow=false;
   	}
   	else
   	{
   		show_slideshow=true;
   	}
   	for (DOM_area=1;DOM_area<DOM_areas;DOM_area++)
		{
	   	if (add_to_history)
	   	{
				DOM_area_name=DOM_areas_array[DOM_area];
				DOM_element_html=extractText(DOM_area_name);
				DOM_element_html_show=true;
	   	}
	   	else
	   	{
	   		DOM_area_name=history_areas_array[DOM_area];
	   		if (current_history_data[DOM_area])
	   		{
					DOM_element_html_show=true;
					DOM_element_html=current_history_data[DOM_area];
	   		}
	   		else
	   		{
					DOM_element_html_show=false;
	   		}
	   	}
			if (DOM_element_html_show)
			{
				if (DOM_element_html.length>0)
				{
					//DOM_element_html=convert_HTML_entities(DOM_element_html);
					if (is_admin_function)
					{
		    		if (DOM_area_name==box_RIGHT_text)
		    		{
			    			//Show/hide "box_RIGHT" depending in content (Admin-function)
		        	if (DOM_element_html==nbsp_text)				//"Nbsp"-only text becomes empty text
		        	{
		        		style_display=style_display_hide;
		        	}
		        	else
		        	{
		        		style_display=style_display_show;
		        	}
		        	with (navRight_style)
		        	{
		        		if (display!=style_display)
		        		{
		        			display=style_display;
		        		}
		        	}
		        	continue;
	        	}
	      	}
					rewritten=true;
					allow_add_to_history=true;
					is_box_cart=DOM_area_name==box_CART_text;
					if (is_box_cart)
					{
';
		if (NOT_USE_AJAX_ADMIN)
		{
			$script.='
						condition=update_box_cart;
						if (not_slideshow_only)
						{
							if (use_sticky_cart)
							{
								sticky_cart_set_info();
								//Do not save cart-operations to history, as cart  m u s t  not change,
								//if user navigates in the history.
								//Exception: if cart is emptied (==small HTML content), include it in history!
								allow_add_to_history=DOM_element_html.length<10;
								cart_has_products=DOM_element_html.indexOf(currency)!=-1;
							}
						}
';
		}
		$script.='
					}
					else
					{
						is_main_content=DOM_area_name==main_content_text;
						if (is_main_content)
						{
							process_script=DOM_element_html.indexOf(ajax_script_text+"1")!=-1;
';
		if (NOT_USE_AJAX_ADMIN)
		{
			$script.='
							if (attributes_purchase)
							{
		      			sticky_cart_init_done=false;				//Re-init "sticky cart" which was used as price display
		      			sticky_cart_visible_new=sticky_cart_show_global;
							}
		      		if (!update_main_content)
		      		{
		      			//We ended here after a purchase with product attributes
		      			//If "main_content" contains the cart again, we do not redisplay it,
		      			//as all options selected will disappear!
		      			//Otherwise redisplay. Either the cart_content, or the user might have selected
		      			//a completely different function, abandoning purchase after all!
		      			update_main_content=DOM_element_html.indexOf(form_cart_quantity_text)==-1
		      		}
';
		}
		$script.='
		      		if (update_main_content)
		      		{
								//main_content received, so we positon screen to top
								set_top_of_screen=true;
								validation_by_select_box=false;
								validation_required=false;
								if (not_is_admin_function)
								{
									product_options=extractText(product_options_delimiter);
								}
		      		}
		      		else
		      		{
		      			allow_add_to_history=false;
		      		}
							condition=update_main_content;
						}
						else
						{
							condition=true;
							if (use_slideshow)
							{
								//Slideshow loaded
								if (DOM_area_name.indexOf(slideshow_big_text)!=-1)
								{
	//debug_stop();
									add_to_history=false;
									show_slideshow=true;
									for (slideshowId=0;slideshowId < '.sizeof($slideshow_id).';slideshowId++)
									{
										current_element=slideshow_text+slideshowId;
										if (DOM_element_html.indexOf(current_element)!=-1)
										{
											break;
										}
									}
									slideshow_request_active[slideshowId]=false;
									if (DOM_element_html.indexOf(slideshow_controls_text)!=-1)
									{
										//Full loading, restart timer. (Maybe new load, or load from history!)
										if (add_to_history)
										{
											//New load, force restart!
											//If not new load, restart slideshow only, if not stopped
											slideshow_active[slideshowId]=true;
										}
										if (slideshow_active[slideshowId])
										{
											crossfade(slideshowId,start_opacity,true);
										}
									}
									else
									{
										//After initial loading, only load slide without controls
										DOM_area_name=current_element;
									}
								}
							}
						}
					}
					if (condition)
					{
						current_element=$(DOM_area_name);
						if (current_element)
						{
							if (DOM_element_html==nbsp_text)
							{
								DOM_element_html=empty_string;
							}
							with (current_element)
							{
								innerHTML=DOM_element_html;
								style.display=style_display_show;
							}
						}
					}
				}
			}
		}
		if (not_slideshow_only)
		{
			update_main_content=true;
			if (is_admin_function)
			{
				//Check for scripts to execute
				if (process_script);
				{
					//execJS(main_content);
					ajax_script_id=0;
					while (true)
					{
						ajax_script_id++;
						ajax_script=extractText(ajax_script_text+ajax_script_id);
						if (ajax_script==empty_string)
						{
							//All done, exit
							break;
						}
						else
						{
							//Execute script
							//This routine expects valid javascript code in "ajax_script"
							//It splits up the lines and "eval"s them
							script_lines=ajax_script.split("\r\n");
							for (script_line=0;script_line<script_lines.length;script_line++)
							{
								validation_value=script_lines[script_line];
								if (validation_value!=empty_string)
								{
							    try
							    {
										eval(validation_value);
							    }
							    catch(e)
							    {
							      alert("Fehler: "+e.message+"\n\nin Javascript-Befehl:\n\n"+validation_value+"\n\nIn Script:\n\n"+ajax_script);
							    }
								}
							}
						}
					}
				}
				/*
				//Search for "set_color" of color selector
				poss=data_returned.indexOf(color_selector_init);		//Find "set_color" routine
				if (poss!=-1)
				{
					pose=data_returned.indexOf(rparen, poss);						//Find terminating rparen
					if (pose!=-1)
					{
						subtext=data_returned.substring(poss, pose+1);	//Extract function text
						eval(subtext);
					}
				}
				*/
			}
	';
		if (NOT_USE_AJAX_ADMIN)
		{
			$script.='
			if (use_sticky_cart)
			{
				if (!sticky_cart_init_done)
				{
					sticky_cart_init_done=true;
					DOM_element_html=box_CART.innerHTML;
					sticky_cart_set_info();
					if (attributes_purchase)
					{
						sticky_cart_visible=false;
					}
					else
					{
						sticky_cart.style.display=style_display_hide;
					}
				}
			}
			poss=index_returned.indexOf(products_info_line_text);				//Find "products_info_line_text" in index(Gallery!)
			if (poss!=-1)
			{
				i=parseInt(index_returned.substr(poss+products_info_line_length, 2));	//Get line #
				scroll_top=findPosTop($(products_line_image_text+i))-3;
				scroll_left=0;
				set_top_of_screen=true;
				products_info_area=$(products_info_line_text+i);
	      products_info_active=true;
				add_to_history=false;
			}
	';
		}
		$script.='
			if (allow_add_to_history)
			{
				if (add_to_history)
				{
	//debug_stop();
					for (i=0;i<=all_areas_count;i++)
					{
						current_element=$(all_areas_array[i]);
						if (current_element)
						{
							if (current_element.style.display!=style_display_hide)
							{
								current_extra_element=current_element.innerHTML;
								//Remove HTML comments!
								current_extra_element=current_extra_element.replace(/<!(?:--[\s\S]*?--\s*)?>\s*/g,empty_string);
								j=current_extra_element==empty_string;
								if (!j)
								{
									j=current_extra_element==nbsp_text;
								}
								if (j)
								{
									current_element.style.display=style_display_hide;
								}
							}
						}
					}
					//Save changed data for history (snapshot), so that we can restore any(!) state
			  	history_entries++;
					current_position=history_entries;
			  	//Find the new content of all areas, which might have changed
			  	current_history_data=new Array(max_index);
					for (i=1;i<history_areas_count;i++)
					{
						element_name=history_areas_array[i];
						if (element_name)
						{
							current_element=$(element_name);
							element_value=current_element.innerHTML;
							current_history_data[i]=element_value;
						}
					}
					history_title[history_entries]=current_title;
					current_history_data[title_index]=current_title;
					current_history_data[curpos_index]=history_entries;
					history_data[history_entries]=current_history_data;
					current_history_data[vorname_plz_index]=vorname_plz_required;
					current_history_data[blz_konto_index]=blz_konto_required;
					if (use_sticky_cart)
					{
						current_history_data[sticky_cart_index]=sticky_cart_visible_text;
					}
					if (use_native_history_navigation)
					{
						//Check if newLocation already exists. If yes, make it unique!
						element_value=0;
						if (not_is_IE) sec_blank=underscore;
						newLocation=current_title.replace(/ /g,sec_blank)+sec_blank;
						for (i=0;i<history_entries;i++)
						{
							validation_element_value=history_title[i];
							condition=(validation_element_value==current_title);
							if (!condition)
							{
								condition=validation_element_value.indexOf(newLocation)!=-1
							}
							if (condition)
							{
								element_value++;
							}
						}
						newLocation=current_title.replace(/ /g,sec_blank);
						if (element_value>0)
						{
							newLocation=newLocation+sec_blank+lparen+(element_value)+rparen;
						}
	';
		if (USE_DHTML_HISTORY)
		{
			$script.='
						dhtmlHistory.add(newLocation,history_entries);
	';
		}
		$script.='
					}
				}
				update_history_context(false);
			}
		}
		attributes_purchase=false;
	}
	if (use_slideshow)
	{
		if (show_slideshow)
		{
			style_display=style_display_show;
		}
		else
		{
			style_display=style_display_hide;
		}
		slideshow_table_style.display=style_display;
	}
	if (not_slideshow_only)
	{
		if (rewritten)
		{
			if (set_top_of_screen)
			{
	';
		if (NOT_USE_AJAX_ADMIN)
		{
			$script.='
				if (product_options.length>0)
				{
					product_options=product_options.split("|");
					//Products options specified. Set options in product!!!
					set_products_options(product_options[0],product_options[1]);
					product_options=empty_string;
				}
				else
				{
					//Adjust price info to reflect options selected!
					current_element=$(options_area_text);		//Check if we have options!
					have_options=!((current_element==null) || (current_element==undefined));
					if (have_options)
					{
						//Product has options! Adjust price displays.
						products_attribute_changed(empty_string,true,empty_string);
						sticky_cart_data_dirty=false;
					}
				}
				window.scrollTo(scroll_left,scroll_top);
				set_top_of_screen=false;
		    scroll_left=0;
		    scroll_top=0;
			}
	';
		}
		$script.='
		}
		else
		{
			//Nothing was refreshed, so assume we have to exchange the "main content" page!!!
			main_content.innerHTML=data_returned;
		}
	}
}

function AJAX_submit(form_name_object,extra_parameter)
{
	//The routine will be passed form names  o r  the form object ("this")
	//So we need to check things out
	if (typeof(form_name_object)=="string")
	{
		//Form name was passed
		form_object=$(form_name_object);
	}
	else
	{
		//Form object was passed
		form_object=form_name_object;
		form_name_object=form_object.name;
	}
	form_action=form_object.action;
	if (typeof(form_action)=="object")
	{
		//Bloody form contains input-field named "action"!!!
		//So "form_object.action" references this input field (at leat in IE
		//So we have to extract the  r e a l  form "action" field from the forms HTML
		validation_value=form_object.outerHTML;
		poss=validation_value.indexOf(action_text);		  //Find "action=" position
		if (poss != -1)
		{
			poss+=action_text.length;
			pose=validation_value.indexOf(blank, poss);			//Find blank position
			if (pose == -1)
			{
				//If not found, try ">"
				pose=validation_value.indexOf(">", poss);	  //Find ">" position
			}
			if (pose != -1)
			{
				form_action=validation_value.substring(poss, pose);		//Extract "form_action"
				form_action=form_action.replace(/"/,empty_string)
			}
		}
	}
	form_action=strip_ajax_link_routine(form_action);
	make_AJAX_Request_POST(form_name_object,form_action+extra_parameter); //Send to server!
}

function strip_ajax_link_routine(url)
{
	//Strip AJAX-link-routine from url for popups
	if (url.indexOf(AJAX_REQUEST_FUNC_START) !=-1)
	{
		//Remove AJAX link-Javascript-code
		url=url.replace(AJAX_REQUEST_FUNC_START,empty_string);
		url=url.replace(AJAX_REQUEST_FUNC_END,empty_string);
	}
	return url;
}

function collect_form_data(docForm)
{
	//Scan FORM and gather post-data for AJAX on submit
	with (docForm)
	{
  	is_file_upload=false;
		submitContent=empty_string;
		current_elements=elements.length;
		for (i=0;i<current_elements;i++)
		{
			formElem=elements[i];
			addvalue=false;
			with (formElem)
			{
				formElem_value=escape(value);
			  switch (type)
			    {
			      // Radio buttons
			      // Checkboxes
			      case "radio":
			      case "checkbox":
			      	addvalue=checked;
			        break;
			      // "File" field
			      case "file":
			      	is_file_upload=true;
			      	break;
			      // Text fields, hidden form elements
			      /*
			      case "text":
			      case "hidden":
			      case "password":
			      case "textarea":
			      case select_text:
			      */
			      default:
			      	addvalue=true;
			        //break;
			    }
		        if (addvalue)
		        {
			        if (formElem_value!=empty_string)
			        {
				        if (submitContent.length>0)
				        {
				            submitContent+=ampersand;
				        }
			            submitContent+=name+"="+formElem_value;
			        }
		        }
		    }
		}
	}
	return submitContent;
}

function pull_down_menu_change(pull_down_menu)
{
	pull_down_menu_name=pull_down_menu.name.toLowerCase();
	validation_required=true;
	switch (pull_down_menu_name)
	{
		case entry_country_id_text:
			//Country selection changed, fetch state info
			break;
		default:
			validation_required=false;
	}
	if (validation_required)
	{
		AJAX_validate_element(empty_string,pull_down_menu_name,false);
		validation_required=false;
	}
}

function set_validation_required(element)
{
	if (!validation_by_select_box) validation_required=element.value.length>0;
}

function clear_validation_required()
{
		//validation_required=false;
		check_for_validation_required=true;
}

function selection_done(select_box_name)
{
	select_box_area_name=select_box_name.replace(/_box/,empty_string);
	//Get selected value from SELECT-box
	current_element=$(validation_element_function);
	current_select_box=$(select_box_name);
	selected_index=current_select_box.selectedIndex;
	if (selected_index==0)
	{
		alert("Sie müssen eine Auswahl für \""+validation_element_caption+"\" treffen!");
	}
	else
	{
		//validation_element_value=current_select_box[selected_index].innerText;
		validation_element_value=current_select_box[selected_index];
		if (is_IE)
		{
			validation_element_value=validation_element_value.innerHTML;
		}
		else
		{
			validation_element_value=validation_element_value.text;
		}
		if (validation_element_value.indexOf(validation_separator)>0)
		{
			validation_element_value=validation_element_value.split(validation_separator);
			element_value=trim(validation_element_value[0]);
		}
		else
		{
			element_value=validation_element_value;
		}
		if (!ignore_gender_check)
		{
			if (validation_element_function==customers_firstname_text)
			{
				//Check if name and gender are compatible
				selection_gender=trim(validation_element_value[1]);
				if (selection_gender!=both)
				{
					if (selection_gender!=unknown)
					{
						//Set proper gender option
						current_selected_gender=get_selected_gender();
						if (selection_gender==male)
						{
							i=0;
						}
						else
						{
							i=1;
						}
						current_extra_element[i].checked=true;
						/*
						if (current_selected_gender==male_short)
						{
							show_problem=selection_gender==female;
							anrede=male_anrede;
						}
						else
						{
							show_problem=selection_gender==male;
							anrede=female_anrede;
						}
						if (show_problem)
						{
							vorname="Vorname \""+element_value+"\" ";
							message="Der gewählte "+vorname+"ist üblicherweise "+selection_gender+", ";
							message+="Sie haben jedoch die Anrede \""+anrede+"\" angewählt.\n\n";
							message+=vorname+"trotzdem wählen?";
							if (!confirm(message))
							{
								with (current_select_box)
								{
									selectedIndex=last_selected_index;
									focus();
									return;
								}
							}
						}
						*/
					}
				}
				validation_vorname_done=true;
			}
		}
		//Set selected value from SELECT-box into validated field
		current_element.value=element_value;
		validation_required=false;
		check_for_validation_required=false;
		validation_by_select_box=true
		last_selected_index=selected_index;
	  	element_value=trim(validation_element_value[1]);
		switch (validation_element_function)
		{
			case entry_postcode_text:
				//Set additional info (city, state, area code)
				i=validation_element_value.length;
				if (i>2)
				{
					if (i>3)
					{
						validation_element_value_short=validation_element_value[3];
					}
					validation_element_value=validation_element_value[2];
				}
				else
				{
//debug_stop();
					validation_element_value=current_select_box[selected_index].value;
					validation_element_value=validation_element_value.split(validation_separator);
					validation_element_value_short=validation_element_value[1];
					validation_element_value=validation_element_value[0];
				}
				set_adress_info(element_value,trim(validation_element_value),trim(validation_element_value_short));
				break;
			case banktransfer_blz_text:
				//Set additional info (bank)
				set_bank_info(element_value);
		}
	}
	current_select_box.focus();
}

function selection_box_hide(select_box)
{
	select_box.innerHTML=empty_string;
}

function AJAX_validate_element(element_caption,element_name,element_required)
{
	if (error_display)
	{
		error_display=false;
	}
	else
	{
		current_element=$(element_name);
		validation_element_value=trim(current_element.value);
		validation_element_value_length=validation_element_value.length;
		if (!validation_required)
		{
			validation_required=validation_element_value_length>0;
		}
		//if (validation_required || element_required)
		if (validation_required)
		{
			/*
			if (!request_active)
			{
			*/
				check_for_validation_required=false;
				validation_element_name=element_name;
				validation_element_caption=element_caption.replace(/:/,empty_string);
				validation_element_required=element_required;
				validation_element=current_element;
				if (validation_element_value_length>0)
				{
					validation_extra_parameter_value=empty_string;
					if (element_name==entry_country_id_text)
					{
						//We have to change entry_state, so change function code!!!!
						validation_element_function=entry_state_text;
					}
					else if (element_name==customers_dob_text)
					{
						//Check legal birthday (locally!)
						message=empty_string;
						if(validation_element_value==empty_string)
						{
							message="Sie müssen ein Geburtsdatum eingeben!";
						}
						else
						{
							m_arrDate = validation_element_value.split(DateSep);
							m_YEAR = m_arrDate[2];
							if(m_YEAR.length != 4)
							{
								message="Das Geburtsjahr muss 4-stellig eingegeben werden (jjjj)!";
							}
							else
							{
								m_DAY=parseInt(m_arrDate[0]);
								m_MONTH=parseInt(m_arrDate[1]);
								m_arrDate=new Date(m_MONTH + slash + m_DAY + slash + m_YEAR);
								if (m_arrDate.getMonth()+1==m_MONTH)
								{
									dat=new Date();
									with (dat)
									{
								    jahr=getFullYear();
								    monat=getMonth() + 1;
								    tag=getDate();
									}

							    if (monat<m_MONTH)
							    {
							       jahr=jahr-1
							    }
							    else if ((monat==m_MONTH) && (tag<m_DAY))
							    {
							      jahr=jahr-1;
							    }
							    if ((jahr-m_YEAR)<18)
							    {
										message="Sie müssen mindestens 18 Jahre alt sein, um einkaufen zu können!";
							    }
							  }
								else
								{
									message="Das Geburtsdatum \""+validation_element_value+"\" hat ein ungültiges Format/Wert!\n\n";
									message+="Gültig ist nur das Format \"tt.mm.jjjj\" (z.B.: 11.12.1913)";
								}
							}
						}
						if (message!=empty_string)
						{
							alert(message);
							current_element.focus();
						}
						return;
					}
					else
					{
						have_check_land=true;
						land=empty_string;
						validation_element_function=element_name;
						if (validation_element_function==customers_firstname_text)
						{
							if (customers_firstname_error)
							{
								customers_firstname_error=false;
								return true;
							}
							else
							{
								validation_min_key_len=3;
							}
						}
						else if (validation_element_function==customers_email_address)
						{
							validation_min_key_len=6;
						}
						else
						{
							land=validation_land_germany;
							land_id=$(entry_country_id_text).value;
							switch (land_id)
							{
								case validation_land_germany_id:
									land=validation_land_germany;
									break;
								case validation_land_austria_id:
									land=validation_land_austria;
									break;
								case validation_land_switzerland_id:
									land=validation_land_switzerland;
									break;
								default:
									land=empty_string;
									have_check_land=false;
							}
							is_germany=land_id==validation_land_germany_id;
							switch (validation_element_function)
							{
							  case banktransfer_blz_text:
							  	if (is_germany)
							  	{
										validation_min_key_len=4;
							  	}
							  	else
							  	{
										validation_min_key_len=3;
							  	}
							    break;
							  case entry_postcode_text:
							  	if (is_germany)
							  	{
										validation_min_key_len=3;
							  	}
							  	else
							  	{
										validation_min_key_len=2;
							  	}
							    break;
								case customers_phone_text:
									validation_min_key_len=8;
							  default:
									validation_min_key_len=0;
							}
						}
						if (validation_min_key_len>0)
						{
							if (validation_element_value_length<validation_min_key_len)
							{
								if (validation_element_value!="%")
								{
									alert("Sie müssen als Suchbegriff für \""+validation_element_caption+"\" mindestens "+
										validation_min_key_len+" Zeichen eingeben!");
									current_element.focus();
									return;
								}
							}
						}
						validation_extra_parameter_check=true;
						//If no correct land available, we have to omit checking on some functions!
						switch (validation_element_function)
						{
						  case customers_firstname_text:
						  	if (event_source)
						  	{
						  		i=event_source;
							  	if (i.name==customers_gender_text)
							  	{
							  		i.checked=true;
							  	}
						  	}
						  	//Provide gender info as additional parameter
					  		validation_extra_element_caption="Anrede";
					  		get_selected_gender();
						  	current_extra_element=current_extra_element[0];
						    break;
						  case customers_phone_text:
						  	//Only possible for Germany
						  	if (have_check_land && land==validation_land_germany)
						  	{
									//Set "plz + name" info as as extra-parameters
									current_extra_element=$(entry_postcode_text);
									validation_extra_parameter_value=trim(current_extra_element.value);
									if (validation_extra_parameter_value.length>0)
									{
										current_extra_element=$(customers_lastname_text);
										validation_element_value_short=trim(current_extra_element.value);
										if (validation_element_value_short.length>0)
										{
											validation_extra_parameter_value+="|"+validation_element_value_short;
										}
										else
										{
											alert("Sie müssen zuerst den Namen eingeben");
											current_extra_element.focus();
											return;
										}
									}
									else
									{
										alert("Sie müssen zuerst die Postleitzahl eingeben");
										current_extra_element.focus();
										return;
									}
									validation_extra_element_caption="PLZ und Name";
						  	}
						  	else
						  	{
						  		validation_required=false;
						  		return;
						  	}
						    break;
						  case customers_email_address:
						  	validation_extra_parameter_check=false;
						    break;
						  case banktransfer_number_text:
						  	//Only possible for Germany
						  	if (have_check_land && land==validation_land_germany)
						  	{
									//Set "blz" info as as extra-parameter
									current_extra_element=$(banktransfer_blz_text);
									validation_extra_parameter_value=trim(current_extra_element.value);
									validation_extra_element_caption="BLZ";
						  	}
						  	else
						  	{
						  		validation_required=false;
						  		return;
						  	}
						    break;
						  default:
						  	if (have_check_land)
						  	{
									validation_extra_parameter_check=false;
						  	}
						  	else
						  	{
						  		validation_required=false;
						  		return;
						  	}
						}
						if (validation_extra_parameter_check)
						{
							if (validation_extra_parameter_value.length==0)
							{
								alert("Sie müssen noch \""+validation_extra_element_caption+"\" festlegen!");
								current_extra_element.focus();
								return;
							}
						}
						current_select_box=$(element_name+select);
						if (current_select_box)
						{
							current_select_box.innerHTML=empty_string;
						}
					}
					target_url=validation_prog;
					ajax_request_parameters=
						param_action+escape(validation_element_function)+
						param_value+escape(validation_element_value)+
						param_caption+escape(validation_element_caption)+
						param_land+land+param_store_country+store_country;
					if (validation_extra_parameter_value.length>0)
					{
						ajax_request_parameters+=param_extra_parameter+escape(validation_extra_parameter_value);
					}
					if (set_multi_shop_directory)
					{
						ajax_request_parameters+=param_multishop;
					}
					do_validation_request=true;
					document_body_style_cursor=cursor_wait;
					make_AJAX_Request(target_url,true,ajax_request_parameters,ajax_post);
					validation_required=false;
					validation_by_select_box=false;
				}
				else
				{
					if (element_required)
					{
						error_display=true;
						alert("Sie müssen für das Feld \'"+validation_element_caption+"\' einen Wert eingeben!");
						validation_element.focus();
					}
					else if (validation_required)
					{
						if (validation_element_function==banktransfer_number_text)
						{
							//If validating banktransfer_number_text, we need to validate the number also
							//if a banktransfer_blz has been entered.
							//Situaton: customer has credit, but still enters bank info
							//Check Blz
							current_extra_element=$(banktransfer_blz_text);
							validation_element_value=trim(current_element.value);
							element_required=validation_element_value.length>0;
							if (element_required)
							{
								error_display=true;
								alert("Sie müssen für das Feld \'"+validation_element_caption+"\' einen Wert eingeben!");
								validation_element.focus();
							}
						}
					}
				}
			//}
		}
		else
		{
			if (validation_by_select_box)
			{
				//Remove SELECT-box
				$(select_box_area_name).innerHTML=empty_string;
				validation_by_select_box=false;
			}
		}
	}
}

function get_selected_gender()
{
	with (document)
	{
		current_extra_element=getElementsByName(customers_gender_text);
		current_elements=current_extra_element.length;
		gender=empty_string;
		for (i=0;i<current_elements;i++)
		{
			with (current_extra_element[i])
			{
			  	if (checked)
			  	{
			  		validation_extra_parameter_value=value;
			  		gender=validation_extra_parameter_value;
				    break;
					}
		  	}
		}
		return gender;
	}
}

function set_adress_info(ort,state,area_code)
{
	validation_plz_done=true;
	if (ort.length>0)
	{
		$(entry_city_text).value=ort;
	}
	if (state.length>0)
	{
		current_element=$(entry_state_text);
		with (current_element)
		{
			//Check all options and set selection to option with the correct id
			current_elements=current_element.length;
			for (i=0;i<current_elements;i++)
			{
				if (options[i].value==state)
				{
					if (selectedIndex!=i)
					{
						selectedIndex=i;
						break;
					}
				}
			}
		}
	}
	if (area_code)
	{
		if (area_code.length>0)
		{
			area_code+=dash
			i=$(customers_phone_text);
			if (i)
			{
				i.value=area_code;
			}
			i=$(customers_fax_text);
			if (i)
			{
				i.value=area_code;
			}
		}
	}
}

function set_bank_info(bank)
{
	validation_blz_done=true;
	if (bank.length>0)
	{
		$(banktransfer_bankname_text).value=bank;
	}
}

';

		if (NOT_USE_AJAX_ADMIN)
		{
			$script.='

function set_products_options(cart_line,product_options)
{
	with (document)
	{
		//Set quantity
		validation_currrent_products_qty_text=validation_products_qty_text+cart_line;
		$(products_qty_text).value=
			trim($(validation_currrent_products_qty_text).innerHTML);
		//Check for options
		product_options=product_options.split(lcb);
		current_extra_element=product_options.length;
		if (current_extra_element>1)			//Any options, or just id??
		{
			form_object=forms[form_cart_quantity_text];
			with (form_object)
			{
				attribute_control=getElementsByTagName(select_text)[0];
				have_radio_options=((attribute_control==null) || (attribute_control==undefined));
				if (have_radio_options)
				{
					attribute_control=getElementsByTagName(input_text)[0];
				}
			}
			element_name=attribute_control.tagName.toLowerCase();
			is_main_content=element_name==select_text;

			form_object=form_object.getElementsByTagName(element_name);
			current_elements=form_object.length;

			for (j=1;j<current_extra_element;j++)
			{
				element_value=product_options[j].split(rcb); //id}value
				products_id="id"+lsb+element_value[0]+rsb;
				cart_products_id=element_value[1];
				for (i=0;i<current_elements;i++)
				{
					with (form_object[i])
					{
						if (is_main_content)													//SELECT box
						{
							if (name==products_id)
							{
								//Correct options ontrol found, Loop thru entries to identify correct selection
								for (k=0;k<options.length;k++)
								{
									if (options[k].value==cart_products_id)		//Correct option value
									{
										selectedIndex=k;
										break;
									}
								}
							}
						}
						else																//RADIO button
						{
							if (type.toLowerCase()==radio_text)
							{
								if (name==products_id)
								{
									if (value==cart_products_id)		//Correct option value
									{
										checked=true;
										break;
									}
								}
							}
						}
					}
				}
			}
			products_attribute_changed(attribute_control,true,false);
		}
	}
}

/*
function on_mouse_in_out(cell,is_in)
{
	with (cell)
	{
		if (id>0)
		{
			with (style)
			{
				if (is_in)
				{
					color=cell_color_hilite;
					backgroundColor=cell_bgcolor_hilite;
				}
				else
				{
					color=cell_color_normal;
					backgroundColor=cell_bgcolor_normal;
				}
			}
		}
	}
}
*/

function get_cookie(name)
{
	var document_cookie=document.cookie;
	j=document_cookie.length;
	if (j > 0)
	{
		search=name+"=";
		returnvalue=empty_string;
		offset=document_cookie.indexOf(search);
		if (offset != -1)
		{
			offset+=search.length;
			end=document_cookie.indexOf(";", offset);
			if (end == -1)
			{
				end=j;
			}
			returnvalue=unescape(document_cookie.substring(offset, end));
		}
	}
	return returnvalue;
}

function set_cookie(name, value, expires, path, domain, secure)
{
  document.cookie= name + "=" + escape(value) +
      ((expires) ? "; expires=" + expires.toGMTString() : "") +
      ((path) ? "; path=" + path : "") +
      ((domain) ? "; domain=" + domain : "") +
      ((secure) ? "; secure" : "");
}

//Find left and top positions of an element
function findPosLeft(obj)
{
	var curleft=0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curleft+=obj.offsetLeft
			obj=obj.offsetParent;
		}
	}
	else if (obj.x)
	{
		curleft+=obj.x;
	}
	return curleft;
}

function findPosTop(obj)
{
	var curtop=0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curtop+=obj.offsetTop
			obj=obj.offsetParent;
		}
	}
	else if (obj.y)
	{
		curtop+=obj.y;
	}
	return curtop;
}

function cart_scroll()
{
	if (use_sticky_cart)
	{
		if (sticky_cart_show)
		{
			window_scroll_top=(is_IE)?iebody.scrollTop:window.pageYOffset;
			window_scrolled=last_page_top!=window_scroll_top;
			if (window_scrolled)
			{
				window_scrolled=false;
				sticky_cart_position(true);
				last_page_top=window_scroll_top;
			}
		}
	}
}

function window_scroll()
{
	window_scroll_interval=false;
	if (sticky_cart_show)
	{
		sticky_cart_position(true);
	}
}

function document_onscroll()
{
	if (true || process_scrolling)
	{
		if (!window_scroll_interval)
		{
			window_scroll_interval=true
			//Force scroll delay of 25 ms per cart position update to avoid thrashing
			window.setTimeout(window_scroll_routine, 25);
		}
	}
}

function sticky_cart_open_close(open_status)
{
	if (activate_sticky_cart_style)
		sticky_cart_show_global=open_status;
		sticky_cart_show=open_status;
		sticky_cart_position(true);
		sticky_cart_show=open_status;
		if (open_status)
		{
			style_display=style_display_hide;
		}
		else
		{
			style_display=style_display_show;
		}
	{
		activate_sticky_cart_style.display=style_display;
	}
}

function sticky_cart_position(force_set_timer)
{
	if (use_sticky_cart)
	{
//		window_scroll_interval=false;
		window_scroll_top=(is_IE)? iebody.scrollTop : window.pageYOffset
		//Display only, if the  r e a l  cart is moved off the screen!
		cart_visibility_top=cart_top;
		sticky_cart_visible_scroll=window_scroll_top>cart_visibility_top;
		if (sticky_cart_visible_scroll)
		{
			if (sticky_cart_show)
			{
				//Position cart
				if (!sticky_cart_visible)
				{
					//Show, in order to get correct "clientHeight"
					sticky_cart.style.display=style_display_show;
					sticky_cart_visible=true;
					sticky_cart_height=sticky_cart.clientHeight;
				}
				sticky_cart_top=window_scroll_top+Math.max(0,(window_innerHeight-sticky_cart_height)/2);
				//Check, if sticky cart is greater than the window height
				i=window_innerHeight-sticky_cart_height;
				if (i<0)
				{
					sticky_cart_top=i;
				}
			}
			sticky_cart_display=sticky_cart_show;
		}
		else
		{
			sticky_cart_display=false;
		}
		if (sticky_cart_display)
		{
			with (sticky_cart.style)
			{
				top=sticky_cart_top+pixel;
				if (true || !sticky_cart_visible)
				{
					sticky_cart_visible=true;
					force_set_timer=true;
					display=style_display_show;
				}
			}
		}
		else
		{
			if (sticky_cart_visible)
			{
				sticky_cart_visible=false;
				sticky_cart.style.display=style_display_hide;
			}
		}
	}
//force_set_timer=false;
	if (force_set_timer)
	{
		sticky_cart_interval=setInterval(sticky_cart_scroll_routine, 25);
	}
}

function sticky_cart_set_info()
{
	if (sticky_cart_visible_new)
	{
		//Eliminate "id"s to avoid conflict with real cart!!!!
		element_value=DOM_element_html;
		//Eliminate "details show-hide" button!
		poss=element_value.indexOf(button_show_hide_label);
		if (poss!=-1)
		{
			pose=element_value.indexOf(button_show_hide_label,poss+button_show_hide_label_length);
			if (pose!=-1)
			{
				element_value=element_value.substr(0,poss)+element_value.substring(pose+button_show_hide_label_length);
			}
		}
		for (i=0;i<=1;i++)
		{
			poss_start=0;
			if (i==0)
			{
				conditon=id_search_text;
			}
			else
			{
				conditon=id_search_text.toUpperCase();
			}
			while (true)
			{
				poss=element_value.indexOf(conditon,poss_start);
				if (poss==-1)
				{
					break;
				}
				else
				{
					poss_start=poss+4;
					j=element_value.indexOf(rab,poss_start);
					pose=element_value.indexOf(blank,poss_start);
					if (pose==-1)
					{
						pose=j;
					}
					else
					{
						pose=Math.min(pose,j);
					}
					if (pose)
					{
						current_element=element_value.substr(poss_start,pose-poss_start);
						if (current_element==cart_details_text)
						{
							current_element=sticky_cart_details_text;
							poss=poss_start;
						}
						else
						{
							current_element=empty_string;
						}
					}
					else
					{
						current_element=empty_string;
					}
					element_value=element_value.substr(0,poss)+current_element+element_value.substring(pose);
				}
			}
		}
		//Copy cart to "sticky_cart" and posistion it
		sticky_cart_set=true;
		with (sticky_cart)
		{
			if (is_price_display)
			{
				validation_element_value=price_display_close_html;
			}
			else
			{
				validation_element_value=sticky_cart_close_html;
			}
			innerHTML=element_value+validation_element_value;
			sticky_cart_height=clientHeight;
			/*
			if (is_IE)
			{
				//sticky_cart_height=offsetHeight;
				//style.setExpression("top","(document.body.clientHeight-clientHeight)/2");
		   	document.recalc(true);
			}
			else
			{
				sticky_cart_height=clientHeight;
			}
			*/
		}
	}
	if (sticky_cart_show_global)
	{
		sticky_cart_show=sticky_cart_visible_new;
	}
	else
	{
		sticky_cart_show=false;
	}
	sticky_cart_position(sticky_cart_visible_new);
}

function products_attribute_changed(attribute_control,display_values,get_attributes_string)
{
	with (document)
	{
		//Get basic net price
		current_element=$(validation_products_price_net_text);
		element_value=trim(current_element.innerHTML);
		current_extra_element=base_price_start+element_value+base_price_end;
		//Get type of control
		form_object=document.forms[form_cart_quantity_text];
		if (typeof(attribute_control)!="object")
		{
			//Check which option-type is used!
			with (form_object)
			{
				attribute_control=getElementsByTagName(select_text)[0];
				have_radio_options=((attribute_control==null) || (attribute_control==undefined));
				if (have_radio_options)
				{
					attribute_control=getElementsByTagName(input_text)[0];
					have_radio_options=attribute_control.type.toLowerCase()==radio_text;
					have_options=have_radio_options;
				}
			}
		}
		current_element=attribute_control;
		element_name=current_element.tagName.toLowerCase();
		form_object=form_object.getElementsByTagName(element_name);
		is_main_content=element_name==select_text;
		//attributes_string=new Array();
		attributes_string=empty_string;
		//Calculate total price for all options selected
		total_attributes_price=0;
		current_elements=form_object.length;
//debug_stop();
		for (i=0;i<current_elements;i++)
		{
			found_id=false;
			with (form_object[i])
			{
				if (is_main_content)								//SELECT box
				{
					selected_index=selectedIndex;
					with (options[selected_index])
					{
						cart_products_id=value;					//Get options value
						validation_element_value=price;	//Atributes price
					}
					found_id=true;
				}
				else																//RADIO button
				{
					if (type.toLowerCase()==radio_text && checked)
					{
						validation_element_value=price;	//Atributes price
						cart_products_id=value;					//Get options value
						found_id=true;
					}
					else
					{
						validation_element_value=empty_string;
					}
				}
				if (validation_element_value.length>1)
				{
					if (get_attributes_string)
					{
						if (found_id)
						{
							//Build attributes string for cart search
							products_id=name;
							products_id=products_id.replace(/id/,empty_string);
							products_id=products_id.replace(lsb,lcb);
							products_id=products_id.replace(rsb,rcb);
							//attributes_string.push(name,products_id,cart_products_id);
							attributes_string+=products_id+cart_products_id;
						}
					}
					else
					{
						sticky_cart_data_dirty=true;
						validation_element_value=adjust_number(validation_element_value);
						total_attributes_price+=validation_element_value;
					}
				}
			}
		}
		if (get_attributes_string)
		{
			return attributes_string;
		}
		else
		{
			have_trailing_currency=element_value.indexOf(currency)>1;
			element_value=adjust_number(element_value);
			validation_element_value=element_value;
			element_value=element_value+total_attributes_price;
			if (display_values)
			{
				element_value=formatCurrency(element_value);
				if (have_trailing_currency)
				{
					element_value+=currency;
				}
				else
				{
					element_value=currency_trimmed+blank+element_value;
				}
				//update_main_content=false;			//Do not update after purchasing with attributes
				attributes_purchase=true;
//debug_stop();
				options_have_price=$(options_have_price_text)!=null;
				if (options_have_price)
				{
					element_value=current_extra_element+element_value;
					$(validation_products_price_display_text).innerHTML=element_value;
					$(validation_products_price_display_2_text).innerHTML=element_value;
					if (use_sticky_cart)
					{
						sticky_cart_data_dirty=true;
						sticky_cart_dirty=true;
						DOM_element_html=
							sticky_price_wrapper_start+element_value.replace(/\) /,"\)"+double_new_line)+sticky_price_wrapper_end;
						sticky_cart_visible_new=true;
						is_price_display=true;
						sticky_cart_set_info();
						is_price_display=false;
					}
				}
			}
			else
			{
				return validation_element_value;
			}
		}
	}
}

function adjust_number(number)
{
	number=number.replace(nbsp_text,empty_string);	  //Delete &nbsp;
	number=trim(number.replace(currency_trimmed,empty_string));	  //Delete currency
	number=number.replace(/ /g,empty_string);	  //Delete blanks
	number=number.replace(/\./g,empty_string);	//Delete 1000s-separator
	number=number.replace(/,/,dot);		//Replace decimal separator with "."
	return parseFloat(number);
}

function formatCurrency(num)
{
	//num = num.toString().replace(/\$|\,/g,empty_string);
	num = num.toString();
	if(isNaN(num))
	{
		num="0";
	}
	sign=(num==(num=Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10)
	{
		cents = "0" + cents;
	}
	for (i=0;i<Math.floor((num.length-(1+i))/3);i++)
	{
		j=num.length-(4*i+3);
		num=num.substring(0,j)+dot+num.substring(j);
	}
	if (cents=="00")
	{
		cents=ndash;
	}
	return nbsp_text+trim((((sign)?blank:dash) + num + comma + cents));
}

function products_quantity_changed(input_control,form_action,send_to_server)
{
	with (input_control)
	{
		show_hide_cart_entry=type=="checkbox";
		real_show_hide_cart_entry=show_hide_cart_entry
		if (show_hide_cart_entry)
		{
			condition=true;
			show_cart_entry=!checked;
			substring_start=11;
			cart_value_element=$(id.replace(cart_check_text,cart_quantity_text));
			products_id_string=value;
			new_quantity=cart_value_element.value;
			do_product_info=false;
		}
		else
		{
			substring_start=14;
			cart_value_element=input_control;
			do_product_info=id=="products_qty";
			if (do_product_info)
			{
				current_element=$("products_id");
			}
			else
			{
				current_element=$(id.replace(cart_quantity_text,cart_products_id_text));
			}
			products_id_string=trim(current_element.value);
			new_quantity=value;
		}
	}
	new_quantity=trim(new_quantity);
	condition=new_quantity.length>0;
	if (condition)
	{
		new_quantity=Math.max(parseInt(new_quantity),0);
		if (isNaN(new_quantity))
		{
			alert("Sie dürfen nur Ziffern eingeben!");
			return false;
		}
		else
		{
			with (document)
			{
				form_object=forms[form_cart_quantity_text];
				if (!show_hide_cart_entry)
				{
					//Check which form we are working in! Can be "product info" or "cart"
					current_element=$(products_price_id_text);
					do_product_info=!((current_element==null) || (current_element==undefined));
				}
				if (do_product_info)
				{
					//Work in "product info" form
					current_element=empty_string;
					current_extra_element=products_price_id_text;
					min_quantity=products_min_order_quantity_text;
					found_id=true;
					cart_line=empty_string;
				}
				else
				{
					//Work in "cart" form
					//Determine current product entry number
					//"id" is "cart_check_#" for check_box, "cart_quantity_#" for input field
					current_element=input_control.id.substring(substring_start);
					current_extra_element=cart_text+validation_products_id+current_element;
					min_quantity=cart_min_quantity_text;
					cart_line=-1;
					found_id=false;
					while (true)
					{
						cart_line++;
						current_extra_element=$(validation_products_id+cart_line);
						if ((current_extra_element==null) || (current_extra_element==undefined))
						{
							break;
						}
						else
						{
							cart_products_id=trim(current_extra_element.innerHTML);
							if (cart_products_id==products_id_string)
							{
								found_id=true;
								break;
							}
						}
					}
				}
				element_value=" \""+trim($(products_name_text+current_element).innerHTML)+"\ ";
				if (found_id)
				{
					i=new_quantity;
					if (new_quantity>max_products_qty)
					{
						new_quantity=max_products_qty;
					}
					i=new_quantity;
					min_quantity=$(min_quantity+cart_line);
					if (min_quantity)
					{
						min_quantity=$(min_quantity).value;
						if (min_quantity)
						{
							min_quantity=parseInt(min_quantity);
							if (new_quantity<min_quantity)
							{
								i=min_quantity;
							}
						}
					}
					j=cart_stock_quantity_text;
					if (cart_line>=0)
					{
						j+=underscore+cart_line;
					}
					cart_stock_quantity=$(j);
					if (cart_stock_quantity)
					{
	debug_stop();
						stock_quantity=parseInt(cart_stock_quantity.value);
						if (stock_quantity>=min_quantity)
						{
							if (new_quantity<stock_quantity)
							{
								if (confirm("Es sind nur noch "+stock_quantity+" Stück vorhanden! Diese in den Warenkorb legen?"))
								{
									i=stock_quantity;
								}
								else
								{
									i=0;
								}
							}
						}
						else
						{
							i=0;
						}
					}
					if (i!=new_quantity)
					{
						new_quantity=i;
						cart_value_element.value=new_quantity;
					}
					if (!do_product_info)
					{
						validation_currrent_products_qty_text=validation_products_qty_text+cart_line;
						current_select_box=$(validation_cart_line_text+cart_line);
						if (current_select_box.style.display==style_display_hide)
						{
							validation_products_qty=0;;
						}
						else
						{
							validation_products_qty=trim($(validation_currrent_products_qty_text).innerHTML);
						}
						if (!show_hide_cart_entry)
						{
							validation_extra_parameter_value=empty_string;
							//send_to_server=true;
							show_hide_cart_entry=true;
							show_cart_entry=new_quantity>0;
						}
						if (show_hide_cart_entry)
						{
							//current_extra_element=$(cart_quantity_text+current_element);
							i=style_display_hide;
							if (show_cart_entry)
							{
								style_display=style_display_show;
								if (new_quantity>0)
								{
									i=style_display_show;
								}
							}
							else
							{
								new_quantity=0;
								style_display=style_display_hide;
							}
							//Show/hide cart entry!
							current_select_box.style.display=i;
							if (real_show_hide_cart_entry)
							{
								//Show/hide quantity input-field!
								//current_extra_element.style.display=style_display;
								cart_value_element.style.display=style_display;
							}
						}
						validation_current_products_price_text=validation_products_price_text+cart_line;
						validation_final_price=
							adjust_number($(validation_current_products_price_text).innerHTML);
						/*
						cart_total_price=
							adjust_number(trim($(validation_cart_total_price_text).innerHTML))-
							validation_final_price*validation_products_qty;
						cart_total_price_undiscounted=
							adjust_number(trim($(validation_cart_total_price_undiscounted_text).innerHTML))-
							validation_final_price*validation_products_qty;
						*/
						cart_total_price_undiscounted=
							trim($(validation_cart_total_price_undiscounted_text).innerHTML);
						cart_total_price_undiscounted=
							cart_total_price_undiscounted.replace(nbsp_text,empty_string);	  //Delete &nbsp;
						cart_total_price_undiscounted=
							cart_total_price_undiscounted-validation_final_price*validation_products_qty;
						cart_total_price_undiscounted=Math.max(cart_total_price_undiscounted,0);
						$(validation_currrent_products_qty_text).innerHTML=new_quantity;
						if (new_quantity!=0)
						{
							item_total_price=validation_final_price*new_quantity;
							cart_total_price_undiscounted=cart_total_price_undiscounted+item_total_price;
							//Check for discounts and apply to small cart
							if ($(cart_total_discount_value_text))
							{
								discount_value=$(cart_total_discount_value_text).value;
								cart_total_price=cart_total_price_undiscounted*(1-(discount/100));
								cart_total_price=Math.max(cart_total_price,0);
							}
							else
							{
								cart_total_price=cart_total_price_undiscounted;
							}
						}
						else
						{
							item_total_price=empty_string;
							cart_total_price=cart_total_price_undiscounted;
						}
						//$(validation_cart_total_price_undiscounted_text).innerHTML=
						//	formatCurrency(cart_total_price_undiscounted);
						$(validation_cart_total_price_undiscounted_text).innerHTML=cart_total_price;
						if (item_total_price!=empty_string)
						{
							item_total_price=formatCurrency(item_total_price)+currency;
						}
						if (cart_total_price>0)
						{
							i=formatCurrency(cart_total_price)+currency;
							$(validation_cart_total_price_text).innerHTML=i;
							style_display=style_display_show;
							cart_empty_message_style_display=style_display_hide;
						}
						else
						{
							i=nbsp_text;
							style_display=style_display_hide;
							cart_empty_message_style_display=style_display_show;
						}
						current_element=$(validation_cart_total_price_short_text);
						if (current_element)
						{
							current_element.innerHTML=i;
						}
						$(cart_empty_message_text).style.display=cart_empty_message_style_display;
						current_element=$(cart_save_link_text);
						if (current_element)
						{
							current_element.style.display=style_display;
						}
						$(cart_total_price_line_text).style.display=style_display;
						if (!do_product_info)
						{
							$(validation_cart_total_price_1_text).innerHTML=i;
							$(validation_cart_item_total_price_text+cart_line).innerHTML=item_total_price;
						}
						current_element=$(cart_content_text);
						if (current_element)
						{
							current_element=current_element.getElementsByTagName(tr_text);
							if (current_element)
							{
								j=0;
			      		current_elements=current_element.length;
			      		for (i=0;i<current_elements;i++)
			      		{
									validation_element=$(validation_cart_line_text+i);
									if (validation_element)
									{
										if (validation_element.id.indexOf(validation_cart_line_text)!=-1)
										{
											if (validation_element.style.display!=style_display_hide)
											{
												j++;
												$(cart_lfd_text+i).innerHTML=j;
											}
										}
									}
								}
								current_element=$(cart_items_short_text);
								if (current_element)
								{
									current_element.innerHTML=j;
								}
							}
						}
						validation_extra_parameter_value=cart_no_show_parameter;
						if (use_sticky_cart)
						{
							DOM_element_html=box_CART.innerHTML;
							sticky_cart_visible=false;
							sticky_cart_visible_new=true;
							sticky_cart_set_info();
						}
						send_to_server=false;
						if (send_to_server)
						{
							sticky_cart_data_dirty=false;
							AJAX_submit(form_cart_quantity_text,validation_extra_parameter_value); //Send to server!
						}
						else
						{
							sticky_cart_data_dirty=true;
						}
					}
				}
			}
		}
	}
	return true;
}

function cron_jobs_init()
{
}

function onsubmit(event)
{
	if (!event)
	{
		event=window.event;
	}
	event_source=event.target || event.srcElement;
//debug_stop();
	if (event_source)												//Any target?
	{
		make_AJAX_Request_POST(event_source.name,event_source.action);
		event.cancelBubble=false;
		event.returnValue = false;
		return false;
	}
}

function onClick(event)
{
	if (AJAX_init_done)
	{
		if (!event)
		{
			event=window.event;
		}
		event_source=event.target || event.srcElement;
		if (event_source)												//Any target?
		{
			current_element=event_source.tagName;
			if (current_element==area_tag)
			{
				a_tag_found=true;
			}
			else
			{
				a_tag_found=current_element==a_tag;
				if (!a_tag_found)											//"A" tag?
				{
					//Check 3 levels up the DOM for an "A"-tag
					for (level=1;level<=2;level++)
					{
						event_source=event_source.parentNode;
						if (event_source)
						{
							current_element=event_source.tagName;
							if (current_element==a_tag)			//"A" tag?
							{
								//a_tag_found=true;
								a_tag_found=event_source.href.indexOf(javascript_text)==-1;
								break;
							}
						}
						else
						{
							break;
						}
					}
				}
			}
			if (a_tag_found)											//"A" tag?
			{
				event.cancelBubble=true;
				if (products_info_active)
				{
					products_info_area.innerHTML=empty_string;
		      products_info_active=false;
		      if (event_source.href.indexOf(gallery_script)!=-1)
		      {
						event.returnValue=false;
		      	return false;
		      }
				}
				current_extra_element=event_source.target;
				if (current_extra_element)
				{
					current_extra_element=current_extra_element.replace(/\"/g,"");
					//"_parent"-, "_top"- and "_blank"-target links are ignored!
					condition=non_ajax_targets.indexOf(current_extra_element)==-1;
				}
				else
				{
					condition=true;
				}
				if (condition)
				{
					event.returnValue = false;
					condition=false;
					current_element=event_source.href;
					if (current_element)
					{
						//Ignore clicks for local Javascript routines!!!!
						if (current_element!=empty_string )
						{
							i=current_element.charAt(current_element.length-1);
							if (i!=hash)
							{
								if (i!=slash)
								{
									condition=current_element.indexOf(javascript_text)==-1;
								}
							}
						}
					}
					if (condition)
					{
						make_AJAX_Request(current_element,false,empty_string,empty_string)
					}
					return false;
				}
				else
				{
					no_show_ajax_wait_image=true;
				}
			}
		}
		event.returnValue=true;
		return true;
	}
	else
	{
		alert(wait_for_init_message);
		show_loaded=true;
		return false;
	}
}

function show_hide_cart_details()
{
	if (cart_details_state==style_display_show)
	{
		cart_details_state=style_display_hide;
		i=cart_details_show_text;
	}
	else
	{
		cart_details_state=style_display_show;
		i=cart_details_hide_text;
	}
	cart_details_style=$(cart_details_text).style;
	cart_details_style.display=cart_details_state;
	if (sticky_cart)
	{
		DOM_element_html=box_CART.innerHTML;
		sticky_cart_set_info();
	}
	return false;
}

function HTTP_REQUEST(http_request_instance)
{
	//Init "http_request" object
	this.request_instance=http_request_instance;
	this.available=true;
	this.active=false;
	this.target_url=empty_string;
	if (window.XMLHttpRequest)
	{
		// IE 7,Mozilla, Safari,...
		this.xmlhttp=new XMLHttpRequest();
	}
	else if (window.ActiveXObject)
	{ // IE < 7
    try
    {
        this.xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e)
    {
        try
        {
          this.xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e)
        {
        	this.xmlhttp=null;
        }
    }
	}
}

function http_request_stop(http_request_instance)
{
	window.clearTimeout(ajax_request_timeout[http_request_instance]);
	http_requests[http_request_instance].xmlhttp.abort();  //Abort any pending request
	http_requests[http_request_instance].active=false;
	http_requests[http_request_instance].available=true;
	http_requests[http_request_instance].target_url=empty_string;
	http_requests[http_request_instance].xmlhttp=null;
}

function debug_stop()
{
	if (debug_it)
	{
		debugger;
	}
}

//Slideshow
var slideshow_text="slideshow_",slideshows;
var slideshow_big_text=slideshow_text.toUpperCase(slideshow_text);
var not_slideshow_only,slideshow_only_text="x "+slideshow_big_text;
var show_slideshow=false,slideshow_table_style=null;
var slideshow_controls_text=slideshow_text+"controls";
slideshow_text+="content_";
var is_slideshow_request;

var node = null;
var entry_style;

var slideshowId_text="'.BOX.'"+slideshow_big_text,slideshowId;
var button_stop_text=button_text+"stop"+underscore;
var button_start_text=button_text+"start"+underscore;
var button_delay_text=button_text+"delay"+underscore;
var button_speedup_text=button_text+"speedup"+underscore;
var slideshow_url="ajax_slideshow.php?type=";

var total="total"+underscore;
var button_stop_total_text=button_stop_text+total;
var button_start_total_text=button_start_text+total;
var button_delay_total_text=button_delay_text+total;
var button_speedup_total_text=button_speedup_text+total;

var button_speed_title_text="'.TEXT_SLIDESHOW_BUTTONS_SPEED.'";
var button_speedup_title_text="'.TEXT_SLIDESHOW_BUTTONS_SPEEDUP.'";
var start_opacity=100;
var crossfade_text;

var slideshowInterval=new Array();   //Time (in milliseconds) to show entry
var slideshowInterval_min=new Array();   //Minimum Time (in milliseconds) to show entry
var slideshow_active=new Array();
var slideshow_request_active=new Array();
var slideshow=Array();
var slideshowTimer=new Array();
var slideshow_ids=new Array();
var previousEntryId=new Array(),previousEntry;
var currentEntryId=new Array();
var use_ajax_version=true;

function slideshowInit(slideshowId)
{
  if (document.getElementById)
  {
    slideshow[slideshowId]=$(slideshowId_text+slideshowId);
    if (slideshow[slideshowId])
    {
	    if (!use_ajax_version)
	    {
		    slideshowEntries[slideshowId]=slideshow[slideshowId].childNodes.length-1;
	    }
	    slideshow[slideshowId].style.display= style_display_show;
	    currentEntryId[slideshowId]=0;
	    crossfade(slideshowId,start_opacity,true);
	  }
	  else
	  {
	  	debug_stop();
	  }
  }
}

function crossfade(slideshowId,opacity,ignore_it)
{
	if (slideshow_active[slideshowId])
	{
	  if (opacity < 100)
	  {
	    // current Entry not faded up fully yet...so increase its opacity
	    fader(currentEntryId[slideshowId],opacity);
	    opacity += 10;
	    window.setTimeout("crossfade(slideshowId,"+opacity+")", 30);
	  }
	  else
	  {
	    if (use_ajax_version)
	    {
	    	if (!ignore_it)
	    	{
		    	if (true || !slideshow_request_active[slideshowId])
		    	{
		    		slideshow_request_active[slideshowId]=true;
		    		no_show_ajax_wait_image=true;
		    		is_slideshow_request=true;
						make_AJAX_Request(slideshow_url+slideshowId,false,false,ajax_get);	//Make AJAX request
		    		is_slideshow_request=false;
					}
				}
	    }
	    else
	    {
		    select_new_entry()
	    }
	    opacity=start_opacity;
	  	crossfade_text="crossfade("+slideshowId+","+opacity+")";
	    slideshowTimer[slideshowId]=window.setTimeout(crossfade_text, slideshowInterval[slideshowId]);
	  }
  }
}

/*
function fader(slideshowId,opacity)
{
  // helper function to deal specifically with Entrys and the cross-browser differences in opacity handling
  node=slideshow[slideshowId].childNodes[currentEntryId[slideshowId]];
  if (node.style)
  {
    if (node.style.MozOpacity!=null)
    {
      // Mozilla\'s pre-CSS3 proprietary rule
      node.style.MozOpacity = (opacity/100) - .001;
    }
    else if (node.style.opacity!=null)
    {
      // CSS3 compatible
      node.style.opacity = (opacity/100) - .001;
    }
    else if (node.style.filter!=null)
    {
      // IE\'s proprietary filter
      node.style.filter = "alpha(opacity="+opacity+")";
    }
    if (opacity==0)
    {
      node.style.display= style_display_hide;
    }
  }
}

function select_new_entry(slideshowId)
{
  previousEntryId[slideshowId]=currentEntryId[slideshowId];
  while (previousEntryId[slideshowId]==currentEntryId[slideshowId])
  {
    currentEntryId[slideshowId]=Math.floor(Math.random()*(slideshowEntries[slideshowId]+1));
    if (slideshow[slideshowId].childNodes[currentEntryId].nodeType!=1)
    {
    	currentEntryId[slideshowId]++;
    }
    if (currentEntryId[slideshowId]>slideshowEntries[slideshowId])
     {
      // start over from first Entry if we cycled through all Entrys in the list
      currentEntryId[slideshowId]=0;
    }
  }
  previousEntry=slideshow[slideshowId].childNodes[previousEntryId[slideshowId]];
  if (previousEntry.style)
  {
	  previousEntry.style.display=style_display_hide;
	}
  slideshow.childNodes[currentEntryId].style.display=style_display_show;
}
*/

function slideshow_delay(slideshowId)
{
	i=slideshowInterval[slideshowId]+1000;
	slideshowInterval[slideshowId]=i;
	i=i/1000;
	$(button_delay_text+slideshowId).title=button_speedup_title_text.replace(/%/,(i+1));
	$(button_speedup_text+slideshowId).title=button_speedup_title_text.replace(/%/,(i-1));
	i=button_speedup_title_text.replace(/%/,i);
	$(button_start_text+slideshowId).title=i;
	$(button_stop_text+slideshowId).title=i;
}

function slideshow_stop(slideshowId)
{
	if (slideshow_active[slideshowId])
	{
		$(button_stop_total_text+slideshowId).style.display=style_display_hide;
		$(button_delay_total_text+slideshowId).style.display=style_display_hide;
		$(button_speedup_total_text+slideshowId).style.display=style_display_hide;
		$(button_start_total_text+slideshowId).style.display=style_display_show;
		slideshow_active[slideshowId]=false;
		clearTimeout(slideshowTimer[slideshowId]);
	}
}

function slideshow_start(slideshowId)
{
	if (!slideshow_active[slideshowId])
	{
		$(button_start_total_text+slideshowId).style.display=style_display_hide;
		$(button_stop_total_text+slideshowId).style.display=style_display_show;
		$(button_delay_total_text+slideshowId).style.display=style_display_show;
		$(button_speedup_total_text+slideshowId).style.display=style_display_show;
		slideshow_active[slideshowId]=true;
		crossfade(slideshowId,100);
	}
}

function slideshow_speedup(slideshowId)
{
	clearTimeout(slideshowTimer[slideshowId]);
	i=Math.max(slideshowInterval[slideshowId]-1000,slideshowInterval_min[slideshowId]);
	slideshowInterval[slideshowId]=i;
	i=i/1000;
	$(button_delay_text+slideshowId).title=button_speedup_title_text.replace(/%/,(i+1));
	$(button_speedup_text+slideshowId).title=button_speedup_title_text.replace(/%/,Math.max((i-1),3));
	i=button_speedup_title_text.replace(/%/,i);
	$(button_start_text+slideshowId).title=i;
	$(button_stop_text+slideshowId).title=i;
	crossfade(slideshowId,100);
}
';
		}
	}
	$script.='
//W. Kaiser - AJAX
';
	if ($not_script_dyn_load)
	{
		$script.='
--></script>
';
	}
	else
	{
		$script.='
		ajax_init_real();
';
	}
	if ($is_full_AJAX)
	{
		if (!IS_LOCAL_HOST)
		{
			if ($not_pack_js)
			{
				$script=preg_replace('@([\r\n])[\s]+@','\1',$script);
			}
		}
		if (true || NOT_IS_ADMIN_FUNCTION)
		{
			if (SCRIPT_DYN_LOAD)
			{
				file_put_contents($ajax_script_file,$script);
				if ($pack_js)
				{
				  $packer=ADMIN_PATH_PREFIX.DIR_WS_CLASSES.'class.JavaScriptPacker.php';
				  if ((int)phpversion()==4)
				  {
				  	$packer.='4';
				  }
					require_once($packer);
				  $t1 = microtime_float();
				  $packer = new JavaScriptPacker($script,95);
				  $script_packed = $packer->pack();
				  $t2 = microtime_float();
				  $originalLength = strlen($script);
				  $packedLength = strlen($script_packed);
				  $ratio =  number_format(($packedLength/$originalLength)*100, 3);
				  $time = sprintf('%.4f', ($t2 - $t1) );
				  $s='//Packed in '.$time.' Seconds from '.$originalLength.' bytes to '.$packedLength.' bytes ('.$ratio.'%)

';
					file_put_contents($ajax_script_file_packed,$s.$script_packed);
				}
				$script=$script_dyn;
			}
			$header.=$script;
		}
	}
}
elseif ($is_full_AJAX)
{
	$header.=$script_dyn;
}

function microtime_float()
{
    list ($usec, $sec) = explode(BLANK, microtime());
    return ((float)$usec + (float)$sec);
}

//W. Kaiser - AJAX
?>