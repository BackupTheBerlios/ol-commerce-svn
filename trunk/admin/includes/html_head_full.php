<?php
$action=$_GET['action'];
$realproduct_processing=$action=='new_product' || $action=='update_product';
/*
if($realproduct_processing)
{
	$realproduct_processing_script=	'
<script language="javascript"  type="text/javascript">
//var tx=document.getElementsById("XX");		//Wrong statement to force debugger activation!!!!
setTimeout("goOnLoad()",0);
</script>';
}
*/
$header_file=DIR_WS_INCLUDES . "header.php";
if (NOT_IS_AJAX_PROCESSING)
{
	require(DIR_WS_INCLUDES . "html_head.php");
	//W. Kaiser - AJAX
	if (USE_AJAX || ($is_periodic && !$is_auction))
	{
		if($realproduct_processing)
		{
			$onload =	'goOnLoad();';
		}
		else
		{
			$onload ='ajax_init();';
		}
	}
	else
	{
		if($realproduct_processing)
		{
			$onload =	'goOnLoad();';
		}
		else
		{
			$onload =	'SetFocus();';
		}
	}
	//W. Kaiser - AJAX
	if (USE_AJAX)
	{
		$smarty->assign('ONLOAD',$onload);
	}
	else
	{
		$onload='onload="'.$onload.QUOTE;
		$s = '
</head>
<!-- body //-->
<body '.$onload.'>
';
	}
}
if (USE_AJAX)
{
	require($header_file);
}
else
{
	/*
	if($realproduct_processing)
	{
		$s.=	$realproduct_processing_script;
	}
	*/
/*
	$s.='
<!-- header.php bof //-->
';
*/
	echo $s;
	require($header_file);
/*
	$s ='
<!-- header.php eof //-->
';
	echo $s;
*/
}
?>