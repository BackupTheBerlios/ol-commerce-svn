<?php
/* --------------------------------------------------------------
$Id: accounting.php,v 1.1.1.1.2.1 2007/04/08 07:16:23 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommercecoding standards www.oscommerce.com
(c) 2003	    nextcommerce (accounting.php,v 1.27 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');

$action=$_GET['action'];
$cID=(int)$_GET['cID'];
$cID_par='cID=' . $cID;
$where_cID=" where customers_id = '" . $cID . APOS;
if ($action) {
	switch ($action)
	{
		case 'save':
			$access_ids=EMPTY_STRING;
			if(isset($_POST['access'])) foreach($_POST['access'] as $key){
				olc_db_query(SQL_UPDATE.TABLE_ADMIN_ACCESS." SET ".$key."=1".$where_cID);
			}
			//olc_set_admin_access($_GET['id'], $_GET['flag'], $cID);
			olc_redirect(olc_href_link(FILENAME_CUSTOMERS, $cID_par, NONSSL));
			break;
	}
}
if ($cID)
{
	if ($cID == 1)
	{
		olc_redirect(olc_href_link(FILENAME_CUSTOMERS, $cID_par, NONSSL));
	}
	else
	{
		$allow_edit_query = olc_db_query("select customers_status, customers_firstname, customers_lastname from " .
		TABLE_CUSTOMERS . $where_cID);
		$allow_edit = olc_db_fetch_array($allow_edit_query);
		if ($allow_edit == EMPTY_STRING || $allow_edit['customers_status'] != 0)
		{
			olc_redirect(olc_href_link(FILENAME_CUSTOMERS, $cID_par, NONSSL));
		}
	}
}
?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="columnLeft2" nowrap="nowrap" valign="top"><table border="0" cellspacing="1" cellpadding="1" class="columnLeft" nowrap="nowrap">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php');
$sep=olc_draw_separator('pixel_trans.gif',15, 15);
$fields=olc_db_query("SHOW COLUMNS FROM ".TABLE_ADMIN_ACCESS);
$fields_count=olc_db_num_rows($fields);

$columns=1;	//3;
$rows=(int)($fields_count/columns);
if (($fields_count % columns)<>0)
{
	$rows++;
}
$colour_array=array(EMPTY_STRING,'#FF6969','#69CDFF','#6BFF7F','#BFA8FF','#FFE6A8');
?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">
            	<?php echo TEXT_ACCOUNTING.BLANK.$allow_edit['customers_lastname'].BLANK.$allow_edit['customers_firstname']; ?>
            </td>
            <td class="pageHeading" align="right">
            	<?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?>	<br/><br/>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
      <td colspan="2" class="main"> <br/><?php echo TXT_GROUPS; ?><br/>
<?PHP
$main_content='
      <table width="100%" cellpadding="0" cellspacing="2">
	      <tr>
	       <td style="border: 1px solid; border-color: #000000;" width="10" bgcolor="'.$colour_array[1].'" >'.$sep.'</td>
	       <td width="100%" class="main">'.TXT_SYSTEM.'</td>
	      </tr>
	      <tr>
	       <td style="border: 1px solid; border-color: #000000;" width="10" bgcolor="'.$colour_array[2].'" >'.$sep.'</td>
	       <td width="100%" class="main">'.TXT_CUSTOMERS.'</td>
	      </tr>
	      <tr>
	       <td style="border: 1px solid; border-color: #000000;" width="10" bgcolor="'.$colour_array[3].'" >'.$sep.'</td>
	       <td width="100%" class="main">'.TXT_PRODUCTS.'</td>
	      </tr>
	      <tr>
	       <td style="border: 1px solid; border-color: #000000;" width="10" bgcolor="'.$colour_array[4].'" >'.$sep.'</td>
	       <td width="100%" class="main">'.TXT_STATISTICS.'</td>
	      </tr>
	      <tr>
	       <td style="border: 1px solid; border-color: #000000;" width="10" bgcolor="'.$colour_array[5].'" >'.$sep.'</td>
	       <td width="100%" class="main">'.TXT_TOOLS.'</td>
	      </tr>
      </table>
';
echo $main_content;
?>
      <br/>
      </td>
      </tr>
      <tr>
        <td>
	        <table valign="top" width="100%" border="0" cellpadding="0" cellspacing="0">
	          <tr class="dataTableHeadingRow">
	          <?php
	          for ($col=1;$col<=$columns;$col++)
	          {
	          	echo '
	            <td class="dataTableHeadingContent">'.TEXT_ACCESS.'</td>
	            <td class="dataTableHeadingContent">'.TEXT_ALLOWED.'</td>
	';
	          }
						?>
	          </tr>
	        </table>
	       </td>
      </tr>
      <tr>
      	<td>
		      <br/>
      		<table border="0" cellpadding="0" cellspacing="2">
<?php
echo olc_draw_form('accounting', FILENAME_ACCOUNTING, $cID_par  . '&action=save', 'post', 'enctype="multipart/form-data"');

$admin_access=EMPTY_STRING;
$customers_id = olc_db_prepare_input($cID);
$sql="select * from " .TABLE_ADMIN_ACCESS;
$admin_access_query = olc_db_query($sql . $where_cID);
$admin_access = olc_db_fetch_array($admin_access_query);
$group_query=olc_db_query($sql. " where customers_id = 'groups'");
$group_access = olc_db_fetch_array($group_query);
if ($admin_access == EMPTY_STRING)
{
	olc_db_query(INSERT_INTO . TABLE_ADMIN_ACCESS . " (customers_id) VALUES ('" . $cID . "')");
	$admin_access_query = olc_db_query($sql . $where_cID);
	$group_query=olc_db_query($sql . " where customers_id = 'groups'");
	$group_access = olc_db_fetch_array($group_query);
	//$group_access_sorted=sort($group_access);
	$admin_access = olc_db_fetch_array($admin_access_query);
}
$html_array=array();
$html_index_array=array();
$show_field=true;
$customers_id_text='customers_id';
$field_text='Field';
$checked_text='checked';
while ($field=olc_db_fetch_array($fields))
{
	$field_name=$field[$field_text];
	if ($field_name!=$customers_id_text)
	{
		if (LIMITED_ACCESS)
		{
			$show_field=!in_array($field_name,LIMITED_ACCESS_DATA);
		}
		if ($show_field)
		{
			$checked=EMPTY_STRING;
			if ($admin_access[$field_name])
			{
				$checked=$checked_text;
			}
			// colors
			$group_access_value=$group_access[$field_name];
			$color=$colour_array[(int)$group_access_value];
			$field_description=$accounting_text[$field_name];
			//$index=$group_access_value.DOT.$field_name;
			$index=$group_access_value.DOT.$field_description;
			$html_index_array[]=$index;
			if ($field_description)
			{
				$html_array[$index] = '
						<tr class="dataTable">
							<td style="border: 1px solid; border-color: #000000;" width="10" bgcolor="'.$color.'" >'.$sep.'</td>
					    <td width="100%" class="dataTableContentRow">
						    <input type="checkbox" name="access[]" value="'.$field_name.'"'.$checked.'>
						    '.$field_description.'
						  </td>
							<!-- <td></td>-->
						</tr>
';
			}
		}
	}
}
sort($html_index_array);
$content=EMPTY_STRING;
//$columns = sizeof($html_index_array);
foreach ($html_index_array as $key => $value)
{
	$content.=NEW_LINE.$html_array[$value];
}
echo $content;
?>
    </table>
<?php echo olc_image_submit('button_save.gif', IMAGE_SAVE,'style="cursor:hand" onclick="javascript:return confirm(\''.SAVE_ENTRY.'\')"'); ?>
</td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
