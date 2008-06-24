<?php
$sample_interval=$periodic_settings[$sample_interval_text];
if (!isset($sample_interval))
{
	$sample_interval=20;				//20 seconds interval is default
}
$sample_interval*=1000;				//Convert to milliseconds

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
$set_focus=$periodic_settings['set_focus']==TRUE_STRING_S;
$script= '
<script language="javascript" type="text/javascript"><!--
//W. Kaiser - AJAX

//Recognize browser
var undefined="undefined",blank=" ";
var browser0,browser,reconfigure=false;
var opera=window.opera;
var compatMode=document.compatMode;
var is_IE,not_is_IE,is_Firefox,is_Safari,is_Opera;

is_Safari = (navigator.userAgent.indexOf("Safari") != -1);
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
			else if(window.clipboardData && compatMode) browser0="ie6";
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
//include(ADMIN_PATH_PREFIX.DIR_WS_INCLUDES.'convert_html_entities.js.php');
$script.='
var http_request;
var request_active=false;
var AJAX_init_done=false;
var empty_string="";
var document_body_style_cursor,cursor_wait="wait",cursor_normal="auto";
var AJAX_Daten="AJAX-Daten ";
var AJAX_Daten_werden=AJAX_Daten+"werden ";
var XHTTP_states_text=
	new Array("AJAX-Verbindung wird initialisiert",
	AJAX_Daten_werden+"geladen",
	AJAX_Daten+"wurden geladen",
	AJAX_Daten_werden+"aufbereitet",
	AJAX_Daten+"sind vollständig");
var timeout_message="Die Verbindung mit unserem Server war nach # Sekunden nicht erfolgreich!\n\nSoll die Anforderung wiederholt werden?";

var timeout_interval=10;												//AJAX-request timeout period (seconds)
var timeout_interval= timeout_interval*1000;		//Convert to milliseconds
var st,strExec,loop,script_tag,script_text="SCRIPT",execute_js;
var whos_online_timer;
var ajax_request_timeout,ajax_request_method,ajax_request_parameters, ajax_get="GET",ajax_post="POST";
var data_returned=empty_string,save_url=empty_string,ajax_request_url,target_url=empty_string;
var main_content_text="main_content",main_content,error_display;
var use_ajax="ajax=true",periodic="p=t&i=t";
var activate_ie_objects_text="activate_ie_objects",objects,objects_count;
var script_tag,script_text="SCRIPT";
var debug_it='.$debug.';
var calling_url="'.CURRENT_SCRIPT.'";
var request_period='.$sample_interval.';
var AJAX_NODATA="'.AJAX_NODATA.'";
var application_name="'.$application_name.'";
var hash="#",ampersand="&",questionmark="?";
var XHTTP_state;
var sound_names = new Array("order_arrival","door_open","door_close"),sounds=sound_names.length,sound_name="";
var current_event,mouse_is_down=false,mouse_x,mouse_y,event_source,img_tag="IMG",a_tag="A",a_tag_found,level,area_tag="AREA";
var condition,event_source,current_element,current_extra_element;

function ajax_init()
{
	if (!AJAX_init_done)
	{
		init_http_request();			//Check if XMLHttp can bei initialized.
debug_stop();
		if (http_request)
		{
			document_body_style_cursor=document.body.style.cursor;
			main_content=$(main_content_text);
			document.charset = "Windows-1252";
			document.onclick=onclick;
		}
		else
		{
			location.href="../ajax_error.php?action=no_http_request";
		}
	}
}

function init_http_request()
{
  //Init "http_request" object
	if (window.XMLHttpRequest)
	{
		// IE 7,Mozilla, Safari,...
		http_request=new XMLHttpRequest();
	}
	else if (window.ActiveXObject)
	{ // IE < 7
    try
    {
        http_request=new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e)
    {
        try
        {
            http_request=new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e) {}
    }
	}
}

function check_timeout()
{
	if (request_active)
	{
		//AJAX-request still active --> failure
		document_body_style_cursor=cursor_normal;
		window.status=empty_string;
		request_active=false;
		if (confirm(timeout_message.replace(/#/,timeout_interval/1000)))
  	{
			make_AJAX_Request(ajax_request_url,ajax_request_method==ajax_post,
				ajax_request_parameters,ajax_request_method);	//Repeat AJAX-request
		}
		else
  	{
			http_request.abort();  //Abort any pending request
		}
	}
}

function make_AJAX_Request(target_url,do_post_form,post_parameters,post_method,refresh)
{
	//Abort any pending request
	if (request_active)
	{
		request_active=false;
		http_request.abort();  //Abort any pending request
	}

	save_url=target_url;
	init_http_request();
  if (http_request)
  {
		with (http_request)
		{
	    onreadystatechange=rewrite_main_content;
			ajax_request_url=target_url;
	    if (do_post_form)
			{
				if (post_parameters.indexOf(use_ajax)==-1)
				{
					post_parameters += ampersand + use_ajax;		//Add "AJAX-processing" indicator to POST parameters
				}
				open(post_method, target_url, true);
				setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				setRequestHeader("Content-length", post_parameters.length);
				setRequestHeader("Connection", "close");
				parameters=post_parameters;
				ajax_request_method=post_method;
			}
			else
			{
        if (target_url.indexOf(questionmark) != -1)
        {
	        target_url += ampersand;
        }
        else
        {
	        target_url += questionmark;
        }
        target_url+=use_ajax;								//Add "AJAX-processing" indicator to URL
        //Test if additional parameters available. If yes, add parameters to url
        if (post_parameters.length>0)
        {
        	target_url += ampersand+post_parameters
        }
        //open(ajax_get, target_url, !do_validation_request);	//On validation force synchronous mode,
        //													//to halt browser during validation.
        open(ajax_get, target_url, refresh != false);
				ajax_request_method=ajax_get;
        parameters=empty_string;	//null;
			}
			error_display=false;
			ajax_request_parameters=parameters;
			ajax_request_url=target_url;
			request_active=true;
//if (is_IE && debug_it) var tx=document.getElementsById("XX");		//Wrong statement to force debugger activation!!!!
      send(parameters);
      if (!debug_it)
      {
      	ajax_request_timeout=window.setTimeout("check_timeout()", timeout_interval);
      }
		}
  }
  else
  {
  	window.location.href=save_url;				//Force normal reload
  }
}

function rewrite_main_content()
{
	if (request_active)
	{
		with (http_request)
		{
			XHTTP_state=readyState;
			window.status=XHTTP_states_text[XHTTP_state];
	    if (XHTTP_state == 4)
	    {
				window.status=empty_string;
				document_body_style_cursor=cursor_normal;
	    	if (status == 200)
	      {
	      	if (is_IE)
	      	{
						/* Avoid memory leak in MSIE: clean up the onreadystatechange event handler */
		      	onreadystatechange=empty_function;
	        }
      		window.clearTimeout(ajax_request_timeout);
					request_active=false;
        	data_returned=responseText;
        	if (data_returned!=empty_string)
        	{
	        	if (data_returned!=AJAX_NODATA)
	        	{
	        		if (main_content)
	        		{
		        		main_content.innerHTML=data_returned;
				      	if (data_returned.indexOf(activate_ie_objects_text)!=-1)
				      	{
';
if ($set_focus)
{
	$script.='
			      			window.focus();													//Activate window
';
}
$script.='
					      	if (is_IE)
					      	{
										/*
										Note: ActiveX-Controls in IE are no longer active automatically!!!
										For details see:
										http:msdn.microsoft.com/library/default.asp?url=/workshop/author/dhtml/overview/activating_activex.asp
										In order to avoid the need of user confirmation for the activation, this can be done programatically
										For details see: http:capitalhead.com/1240.aspx

										So, activate objects, if objects are included.

										As with AJAX embedded scripts are not executed automatically, we have to do that ourselves!

										*/
					      		//activate_ie_objects();
					      		execJS(document,activate_ie_objects_text);
					      	}
				        }
			        }
		        }
        	}
	        http_request=false;
        }
	    }
    }
  }
}

function trim(str)
{
   return str.replace(/^\s*|\s*$/g,empty_string);
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

/*
// iefix.js
function activate_ie_objects()
{
	objects = document.getElementsByTagName("embed");
	objects_count=objects.length;
	for (var i = 0; i < objects_count; i++)
	{
		with (objects[i])
		{
    	outerHTML = outerHTML;
		}
	}
}
// iefix.js
*/

function execJS(node,ident)
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
		    else
		    {
		      strExec = text;
		    }
				if (ident==empty_string)
				{
					execute_js=true;
				}
				else
				{
					execute_js=strExec.indexOf(ident)!=-1;
				}
				if (execute_js)
				{
			    try
			    {
			      eval(strExec);
			    }
			    catch(e)
			    {
			      alert(e);
			    }
		    }
	    }
	  }
  }
}

function onclick(event)
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
				current_element=event_source.href;
				event.returnValue = false;
				make_AJAX_Request(current_element,false,empty_string,empty_string)
				return false;
			}
		}
	}
	event.returnValue=true;
	return true;
}

function make_AJAX_Request_POST(form_name,form_action)
{
//debug_stop();
	form_object=$(form_name);
	with (form_object)
	{
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
	make_AJAX_Request(form_action,form_method==ajax_post,post_data,form_method);
	return false;
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

function debug_stop()
{
	if (debug_it)
	{
		if (is_IE )
		{
			var tx=document.getElementsById("XX");		//Wrong statement to force debugger activation!!!!
		}
		else
		{
			debugger;
		}
	}
}

</script>
';
?>
