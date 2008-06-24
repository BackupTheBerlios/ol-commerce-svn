<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_draw_form.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:22 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
(c) 2003	    nextcommerce (olc_draw_form.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

// Output a form
function olc_draw_form($name, $action, $method = 'post', $action_parameters = '',$form_parameters='')
{
	//W. Kaiser - AJAX
	//QUOTE='"';
	$html_quot='&quot;';
	$form_name = olc_parse_input_field_data($name, array(QUOTE => $html_quot));
	$method_par=olc_parse_input_field_data($method, array(QUOTE => $html_quot));
	$action_par=olc_parse_input_field_data($action, array(QUOTE => $html_quot));
	if (IS_ADMIN_FUNCTION)
	{
		//Note: the admin prog modules use different calling parameter order!
		$form = $action_parameters;
		$action_parameters=$method_par;
		$method_par=$form;
		$action_par=olc_href_link($action, $action_parameters,NONSSL,true,true,false);
		$action_parameters=EMPTY_STRING;
	}
	else
	{
		$form_parameters=$action_parameters;
	}
	if ($method_par==EMPTY_STRING)
	{
		$method_par="post";
	}
	if ($form_parameters!=EMPTY_STRING)
	{
		$form_parameters= BLANK . $form_parameters;
	}
	if (USE_AJAX)
	{
		//Remove AJAX Javascript routine from "action"-url, as we need it in its original form for the xhttprequest
		/*
		if ((strpos($action_par, AJAX_REQUEST_FUNC_START) !== false))
		{
			$action_par = str_replace(AJAX_REQUEST_FUNC_START, EMPTY_STRING, $action_par);
			$action_par = str_replace(AJAX_REQUEST_FUNC_END, EMPTY_STRING, $action_par);
		}
		*/
		$onsubmit = "onsubmit";
		if (strpos(strtolower($form_parameters), strtolower($onsubmit)) === false)
		{
			$form_parameters .= BLANK. $onsubmit . '="return make_AJAX_Request_POST(\'' . $name . '\',\'' . $action_par . '\');"';
		}
		$form_name .= '" id="' . $form_name;
	}
	//W. Kaiser - AJAX
	$form = '<form name="' . $form_name .'" action="' . $action_par . '" method="' . $method_par.QUOTE.$form_parameters.'>';
	return $form;
}
?>