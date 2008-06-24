<?php
$sort_image=$arrow_down;
$oldway=$way;
$way=$desc_text;
if(isset($_GET[$orderby_text]))
{
	$orderby=$_GET[$orderby_text];
	if($orderby == $_GET[$oldorder_text])
	{
		if($oldway <> $asc_text)
		{
			$way=$asc_text;
			$sort_image=$arrow_up;
		}
	}
}
$ordersql=SQL_ORDER_BY.$orderby.BLANK.$way;
?>