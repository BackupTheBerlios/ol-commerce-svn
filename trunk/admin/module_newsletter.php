<?php
/* --------------------------------------------------------------
$id_post: module_newsletter.php,v 1.14 2004/04/23 20:06:15 fanta2k Exp $
OL-Commerce 2.0
http://www.ol-commerce.de, http://www.seifenparadies.de
Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommercecoding standards www.oscommerce.com
(c) 2003	    nextcommerce (templates_boxes.php,v 1.14 2003/08/18); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
(c) 2003 xt-commerce; www.xt-commerce.com
Released under the GNU General Public License
--------------------------------------------------------------*/
require('includes/application_top.php');
require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'class.phpmailer.php');
require_once(DIR_FS_INC.'olc_encrypt_password.inc.php');
require_once(DIR_FS_INC.'olc_php_mail.inc.php');
$id_get=olc_db_prepare_input((int)$_GET['id']);
switch ($_GET['action']) {  // actions for datahandling
	case 'save': // save newsletter
	$newsletter_title=olc_db_prepare_input($_POST['title']);
	$body=olc_db_prepare_input($_POST['newsletter_body']);
	$id_post=olc_db_prepare_input((int)$_POST['id']);
	$status_all=olc_db_prepare_input($_POST['status_all']);
	if ($newsletter_title==EMPTY_STRING) $newsletter_title='no title';
	$customers_status=olc_get_customers_statuses();
	$rzp=EMPTY_STRING;
	for ($i=0,$n=sizeof($customers_status);$i<$n; $i++) {
		if (olc_db_prepare_input($_POST['status'][$i])=='yes') {
			if ($rzp!=EMPTY_STRING) $rzp.=',';
			$rzp.=$customers_status[$i]['id'];
		}
	}
	if (olc_db_prepare_input($_POST['status_all'])=='yes') $rzp.=',all';
	$error=false; // reset error flag
	if ($error == false) {
		$sql_data_array = array('title'=> $newsletter_title,
		'status' => '0',
		'bc'=>$rzp,
		'date' => 'now()',
		'body' => $body);
		if ($id_post!=EMPTY_STRING)
		{
			olc_db_perform(TABLE_MODULE_NEWSLETTER, $sql_data_array, 'update', "newsletter_id = '" . $id_post . APOS);
		} else {
			olc_db_perform(TABLE_MODULE_NEWSLETTER, $sql_data_array);
			// create temp table
			$id_post=olc_db_insert_id();
		}
		// create temp table
		$create_query=TABLE_MODULE_NEWSLETTER_TEMP.$id_post;
		$drop_query="DROP TABLE IF EXISTS ".$create_query;
		$create_query="CREATE TABLE ".$create_query;
		olc_db_query($drop_query);
		olc_db_query($create_query."
    (
      id int(11) NOT NULL auto_increment,
      customers_id int(11) NOT NULL default '0',
      customers_status int(11) NOT NULL default '0',
      customers_firstname varchar(64) NOT NULL default '',
      customers_lastname varchar(64) NOT NULL default '',
      customers_email_address text NOT NULL,
      customers_email_type int(1) NOT NULL,
      mail_key varchar(32) NOT NULL,
      date datetime NOT NULL default '0000-00-00 00:00:00',
      comment varchar(64) NOT NULL default '',
      PRIMARY KEY (id)
      )");
		// filling temp table with data!
		$flag='';
		if (!strpos($rzp,'all')) $flag=TRUE_STRING_S;
		$rzp=str_replace(',all',EMPTY_STRING,$rzp);
		$groups=explode(COMMA,$rzp);
		$sql_data_array=EMPTY_STRING;
		$select="
			SELECT
      customers_id,
      customers_firstname,
      customers_lastname,
      customers_email_address,
      customers_email_type";
		$where=" WHERE customers_status='".$groups[$i].APOS;
		for ($i=0,$n=sizeof($groups);$i<$n;$i++) {
			// check if cusomer want newsletter
			$select_all=$status_all=='yes';
			if ($select_all)
			{
				$customers_query=olc_db_query($select." FROM ".TABLE_CUSTOMERS.$where);
			} else {
				$customers_query=olc_db_query($select.",mail_key
                                  FROM ".TABLE_NEWSLETTER_RECIPIENTS.$where." and mail_status='1'");
			}
			$table=TABLE_MODULE_NEWSLETTER_TEMP.$id_post;
			$group=$groups[$i];
			while ($customers_data=olc_db_fetch_array($customers_query))
			{
				$email=$customers_data['customers_email_address'];
				if ($select_all)
				{
					$customers_data['mail_key']=olc_encrypt_password($email);
				}
				$sql_data_array=array(
				'customers_id'=>$customers_data['customers_id'],
				'customers_status'=>$group,
				'customers_firstname'=>$customers_data['customers_firstname'],
				'customers_lastname'=>$customers_data['customers_lastname'],
				'customers_email_address'=>$email,
				'customers_email_type'=>$customers_data['customers_email_type'],
				'mail_key'=>$customers_data['mail_key'],
				'date'=>'now()');
				olc_db_perform($table, $sql_data_array);
			}
		}
		olc_redirect(olc_href_link(FILENAME_MODULE_NEWSLETTER));
	}
	break;
	case 'delete':
		olc_db_query(DELETE_FROM.TABLE_MODULE_NEWSLETTER." WHERE newsletter_id='".$id_get.APOS);
		olc_redirect(olc_href_link(FILENAME_MODULE_NEWSLETTER));
		break;
	case 'send':
		// max email package  -> should be in admin area!
		olc_redirect(olc_href_link(FILENAME_MODULE_NEWSLETTER,'send=0,'.EMAIL_NEWSLETTER_PACAKGE_SIZE.'&id='.$id_get));
}
// action for sending mails!
if ($_GET['send']) {
	$limits=explode(COMMA,$_GET['send']);
	$limit_low = $limits['0'];
	$limit_high = $limits['1'];
	$temp_table=TABLE_MODULE_NEWSLETTER_TEMP.$id_get;
	$temp_table_from=" FROM ".$temp_table;
	$limit_query=olc_db_query("SELECT count(*) as count".$temp_table_from);
	$limit_data=olc_db_fetch_array($limit_query);
	// select emailrange from db
	$email_query=olc_db_query("
		SELECT
		customers_firstname,
		customers_lastname,
		customers_email_address,
		customers_email_type,
		mail_key,
		id".
	$temp_table_from ."
		LIMIT ".$limit_low.",".$limit_high);
	$email_data=array();
	while ($email_query_data=olc_db_fetch_array($email_query)) {
		$email_data[]=array('id' => $email_query_data['id'],
		'firstname'=>$email_query_data['customers_firstname'],
		'lastname'=>$email_query_data['customers_lastname'],
		'email'=>$email_query_data['customers_email_address'],
		'type'=>$email_query_data['customers_email_type'],
		'key'=>$email_query_data['mail_key']);
	}
	// ok lets send the mails in packages of 30 mails, to prevent php timeout
	$count=$limit_data['count'];
	$finished=$count<=$limit_high;
	if ($finished)
	{
		$limit_high=$count;
	}
	$max_runtime=$limit_high-$limit_low;
	$newsletters_query=olc_db_query(
	"SELECT
    title,
    body,
    bc,
    cc
    FROM ".TABLE_MODULE_NEWSLETTER."
    WHERE  newsletter_id='".$id_get.APOS);
	$newsletters_data=olc_db_fetch_array($newsletters_query);
	$newsletters_title=$newsletters_data['title'];
	$newsletters_body_html=$newsletters_data['body'];
	$newsletters_body_text=html2text($newsletters_body_html);

	$newsletter_impressum_file=DIR_FS_CATALOG."lang".SLASH.SESSION_LANGUAGE.SLASH."impressum".HTML_EXT;
	if (is_file($newsletter_impressum_file))
	{
		$newsletter_impressum_html=file_get_contents($newsletter_impressum_file);
		$newsletter_impressum_text=html2text($newsletter_impressum_html);
	}
	$remove_url0=HTTP_CATALOG_SERVER.DIR_WS_CATALOG.FILENAME_CATALOG_NEWSLETTER.'?action=remove&x=true&email=';
	$two_nl=chr(10).chr(10);
	$link_start=$two_nl.TEXT_NEWSLETTER_REMOVE_LINK.$two_nl.'#'.$remove_url0;
	$link_start_text=str_replace(HASH,EMPTY_STRING,$link_start);
	$link_start_html=str_replace(HASH,HTML_A_START,$link_start);
	$link_end_html='">'.TEXT_NEWSLETTER_REMOVE.HTML_A_END.$two_nl.'('.$remove_url0;
	$sql_update=SQL_UPDATE.$temp_table." SET comment='send' WHERE id='";
	for ($i=1;$i<=$max_runtime;$i++)
	{
		// mail
		$i1=$i-1;
		$current_email_data=$email_data[$i1];
		$email=$current_email_data['email'];
		$s=$email.'&key='.$current_email_data['key'];
		$link_text=$link_start_text.$s;
		$link_html=$link_start_html.$s.$link_end_html.$s.RPAREN;
		olc_php_mail(
		EMAIL_SUPPORT_ADDRESS,
		EMAIL_SUPPORT_NAME,
		$email,
		trim($current_email_data['lastname'] . BLANK . $current_email_data['firstname']),
		EMPTY_STRING,
		EMAIL_SUPPORT_REPLY_ADDRESS,
		EMAIL_SUPPORT_REPLY_ADDRESS_NAME,
		EMPTY_STRING,
		EMPTY_STRING,
		$newsletters_title,
		$newsletters_body_text.$link_text.$newsletter_impressum_text,
		$newsletters_body_html.nl2br($link_html).$newsletter_impressum_html,
		$current_email_data['type']);
		olc_db_query($sql_update.$current_email_data['id'].APOS);
	}
	if ($finished)
	{
		// finished
		$limit1_query=olc_db_query("SELECT count(*) as count".$temp_table_from." WHERE comment='send'");
		$limit1_data=olc_db_fetch_array($limit1_query);
		if ($limit1_data['count']-$limit_data['count']<=0)
		{
			olc_db_query(SQL_UPDATE.TABLE_MODULE_NEWSLETTER." SET status='1' WHERE newsletter_id='".$id_get.APOS);
			olc_redirect(olc_href_link(FILENAME_MODULE_NEWSLETTER));
		} else {
			$count=$limit1_data['count'];
			echo HTML_B_START.$count.'<b> eMails verschickt<br/>';
			echo HTML_B_START.$count-$limit_data['count'].'<b> eMails übrig';
		}
	} else {
		$limit_low=$limit_high+1;
		$limit_high=$limit_low+EMAIL_NEWSLETTER_PACAKGE_SIZE;
		olc_redirect(olc_href_link(FILENAME_MODULE_NEWSLETTER,'send='.$limit_low.COMMA.$limit_high.'&id='.$id_get));
	}
}
require(DIR_WS_INCLUDES . 'header.php');
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="columnLeft2" nowrap="nowrap" valign="top">
    	<table border="0" cellspacing="1" cellpadding="1" class="columnLeft" nowrap="nowrap">
				<!-- left_navigation //-->
				<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
				<!-- left_navigation_eof //-->
	    </table>
	   </td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        	<table border="0" width="100%" cellspacing="0" cellpadding="0">
  					<tr>
    					<td width="80" rowspan="2"><?php echo olc_image(DIR_WS_ICONS.'heading_news.gif'); ?></td>
    					<td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
  					</tr>
  					<tr>
    					<td class="main" valign="top">OLC Hilfsprogramme</td>
  					</tr>
					</table>
				</td>
      </tr>
 <?php
 if ($_GET['send'])
 {
 ?>
      <tr>
      	<td>
      		Sending
      	</td>
      </tr>
<?php
 }
?>
      <tr>
        <td>
        	<table width="100%" border="0">
          	<tr>
            	<td>
 <?php
 // Default seite
 switch ($_GET['action']) {
 	default:
 		// Get Customers Groups
 		$customer_group_query=olc_db_query("SELECT
                                     customers_status_name,
                                     customers_status_id,
                                     customers_status_image
                                     FROM ".TABLE_CUSTOMERS_STATUS."
                                     WHERE
                                     language_id='".SESSION_LANGUAGE_ID.APOS);
 		$customer_group=array();
 		while ($customer_group_data=olc_db_fetch_array($customer_group_query)) {
 			// get single users
 			$group_query=olc_db_query("SELECT count(*) as count
                                FROM ".TABLE_NEWSLETTER_RECIPIENTS."
                                WHERE mail_status='1' and
                                customers_status='".$customer_group_data['customers_status_id'].APOS);
 			$group_data=olc_db_fetch_array($group_query);
 			$customer_group[]=array('id'=>$customer_group_data['customers_status_id'],
 			'NAME'=>$customer_group_data['customers_status_name'],
 			'IMAGE'=>$customer_group_data['customers_status_image'],
 			'USERS'=>$group_data['count']);
 		}
 ?>
								<br/>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td>
								    	<table border="0" width="100%" cellspacing="0" cellpadding="2">
								        <tr class="dataTableHeadingRow">
								          <td class="dataTableHeadingContent" width="150" ><?php echo TITLE_CUSTOMERS; ?></td>
								          <td class="dataTableHeadingContent"  ><?php echo TITLE_STK; ?></td>
								        </tr>
        <?php
        for ($i=0,$n=sizeof($customer_group); $i<$n; $i++)
        {
?>
								        <tr>
								          <td class="dataTableContent" style="border-bottom: 1px solid;" valign="middle" align="left">
									          <?php
									          echo olc_image(DIR_WS_ICONS . $customer_group[$i]['IMAGE'], EMPTY_STRING);
									          echo $customer_group[$i]['NAME'];
								          ?></td>
								          <td class="dataTableContent" style="border-bottom: 1px solid;" align="left"><?php echo $customer_group[$i]['USERS']; ?></td>
								        </tr>
								        <?php
        }
								?>
								      </table>
								    </td>
								    <td width="30%" align="right" valign="top"">
    <?php
    echo HTML_A_START.olc_href_link(FILENAME_MODULE_NEWSLETTER,'action=new').'">'.
    olc_image_button('button_new_newsletter.gif').HTML_A_END;
    ?>
								    </td>
								  </tr>
								</table>
							 	<br/>
 <?php
 // get data for newsletter overwiev
 $newsletters_query=olc_db_query("
	SELECT
	newsletter_id,date,title
	FROM ".TABLE_MODULE_NEWSLETTER."
	WHERE status='0'");
 $news_data=array();
 while ($newsletters_data=olc_db_fetch_array($newsletters_query)) {
 	$news_data[]=array('id' => $newsletters_data['newsletter_id'],
 	'date'=>$newsletters_data['date'],
 	'title'=>$newsletters_data['title']);
 }
?>
								<table border="0" width="100%" cellspacing="0" cellpadding="2">
									<tr class="dataTableHeadingRow">
									  <td class="dataTableHeadingContent" width="30" ><?php echo TITLE_DATE; ?></td>
									  <td class="dataTableHeadingContent" width="80%" ><?php echo TITLE_NOT_SEND; ?></td>
									  <td class="dataTableHeadingContent" >.</td>
									</tr>
<?php
for ($i=0,$n=sizeof($news_data); $i<$n; $i++)
{
	$current_id=$news_data[$i]['id'];
	if ($current_id!=EMPTY_STRING) {
?>
									<tr>
										<td class="dataTableContent" style="border-bottom: 1px solid;" align="left">
										<?php echo $news_data[$i]['date']; ?></td>
										<td class="dataTableContent" style="border-bottom: 1px solid;" valign="middle" align="left">
										<?php echo olc_image(DIR_WS_CATALOG.'images/icons/arrow.gif'); ?>
											<a href="<?php echo olc_href_link(FILENAME_MODULE_NEWSLETTER,'id='.$current_id); ?>"><b>
											<?php echo $news_data[$i]['title']; ?></b></a>
										</td>
										<td class="dataTableContent" style="border-bottom: 1px solid;" align="left"></td>
									</tr>
 <?php
 if ($id_get==$current_id)
 {
 	$total_query=olc_db_query("SELECT
                           count(*) as count
                           FROM ".TABLE_MODULE_NEWSLETTER_TEMP.$id_get);
 	$total_data=olc_db_fetch_array($total_query);
?>
									<tr>
										<td class="dataTableContent_products" style="border-bottom: 1px solid;" align="left"></td>
										<td colspan="2" class="dataTableContent_products" style="border-bottom: 1px solid;" align="left">
											<?php echo TEXT_SEND_TO.$total_data['count']; ?>
										</td>
									</tr>
									<tr>
										<td class="dataTableContent" valign="top" style="border-bottom: 1px solid;" align="left">
										  <?php
										  $onclick=' onclick="javascript:return confirm(\''.DELETE_ENTRY.'\')"';
										  $style='style="cursor:hand"'.$onclick;
										  $par='action=#&id='.$current_id;
										  echo '
										  	<a href="'.olc_href_link(FILENAME_MODULE_NEWSLETTER,str_replace(HASH,'delete',$par)).'"'.$onclick.')">'.
										  olc_image_button('button_delete.gif','Delete',EMPTY_STRING,EMPTY_STRING,$style).'</a>
										    <br/>
												<a href="'.olc_href_link(FILENAME_MODULE_NEWSLETTER,str_replace(HASH,'edit',$par)).'">'.
										  olc_image_button('button_edit.gif','Edit',EMPTY_STRING,EMPTY_STRING,$style).'</a>
												<br/><br/><hr/>
												<a href="'.olc_href_link(FILENAME_MODULE_NEWSLETTER,str_replace(HASH,'send',$par)).'">'.
										  olc_image_button('button_send.gif','Send',EMPTY_STRING,EMPTY_STRING,$style).HTML_A_END;
											?>
										</td>
										<td colspan="2" class="dataTableContent" style="border-bottom: 1px solid;" align="left">
										<?php
										// get data
										$newsletters_query=olc_db_query("SELECT
										                                  title,body,cc,bc
										                                  FROM ".TABLE_MODULE_NEWSLETTER."
										                                  WHERE newsletter_id='".$id_get.APOS);
										$newsletters_data=olc_db_fetch_array($newsletters_query);
										echo TEXT_TITLE.$newsletters_data['title'].HTML_BR;
										$customers_status=olc_get_customers_statuses();
										for ($i=0,$n=sizeof($customers_status);$i<$n; $i++)
										{
											$newsletters_data['bc']=str_replace($customers_status[$i]['id'],$customers_status[$i]['text'],$newsletters_data['bc']);
										}
										echo
										TEXT_TO.$newsletters_data['bc'].HTML_BR.
										TEXT_CC.$newsletters_data['cc'].'<br/><br/>'.TEXT_PREVIEW.
										'<table style="border: 1px solid;" width="100%">
										  	<tr>
										  		<td>'.$newsletters_data['body'].'</td>
										  	</tr>
										  </table>';
										?>
										</td>
									</tr>
<?php
 }
?>
<?php
	}
}
?>
								</table>
								<br/><br/>
<?php
$newsletters_query=olc_db_query("SELECT
                                   newsletter_id,date,title
                                  FROM ".TABLE_MODULE_NEWSLETTER."
                                  WHERE status='1'");
$news_data=array();
while ($newsletters_data=olc_db_fetch_array($newsletters_query)) {
	$news_data[]=array('id' => $newsletters_data['newsletter_id'],
	'date'=>$newsletters_data['date'],
	'title'=>$newsletters_data['title']);
}
?>
								<table border="0" width="100%" cellspacing="0" cellpadding="2">
					        <tr class="dataTableHeadingRow">
					          <td class="dataTableHeadingContent" width="80%" ><?php echo TITLE_SEND; ?></td>
					          <td class="dataTableHeadingContent"><?php echo TITLE_ACTION; ?></td>
					        </tr>
<?php
for ($i=0,$n=sizeof($news_data); $i<$n; $i++) {
	$current_id=$news_data[$i]['id'];
	if ($current_id!=EMPTY_STRING) {
?>
					        <tr>
					          <td class="dataTableContent" style="border-bottom: 1px solid;" valign="middle" align="left"><?php echo $news_data[$i]['date'].'    '; ?><b><?php echo $news_data[$i]['title']; ?></b></td>
					          <td class="dataTableContent" style="border-bottom: 1px solid;" align="left">
										  <a href="<?php echo olc_href_link(FILENAME_MODULE_NEWSLETTER,'action=delete&id='.$current_id); ?>" onclick="javascript:return confirm('<?php echo CONFIRM_DELETE; ?>')">
										  <?php
										  echo olc_image(DIR_WS_ICONS.'delete.gif','Delete',EMPTY_STRING,EMPTY_STRING,'style="cursor:hand" onclick="javascript:return confirm(\''.DELETE_ENTRY.'\')"').'  '.TEXT_DELETE.'</a>&nbsp;&nbsp;';
										  ?>
											<a href="<?php echo olc_href_link(FILENAME_MODULE_NEWSLETTER,'action=edit&id='.$current_id); ?>">
										<?php echo olc_image(DIR_WS_ICONS.'icon_edit.gif','Edit',EMPTY_STRING,EMPTY_STRING).'  '.TEXT_EDIT.HTML_A_END; ?>
					          </td>
					        </tr>
<?php
	}
}
?>
								</table>
<?php
break;       // end default page
 	case 'edit':
 		$newsletters_query=olc_db_query("SELECT
                                   title,body,cc
                                  FROM ".TABLE_MODULE_NEWSLETTER."
                                  WHERE newsletter_id='".$id_get.APOS);
 		$newsletters_data=olc_db_fetch_array($newsletters_query);
 	case 'safe':
 	case 'new':  // action for NEW newsletter!
 	$customers_status=olc_get_customers_statuses();
 	echo olc_draw_form('edit_newsletter',FILENAME_MODULE_NEWSLETTER,'action=save','post').
 	olc_draw_hidden_field('id',$id_get);
  ?>
									<br/><br/>
									<table class="main" width="100%" border="0">
										<tr>
										  <td width="10%"><?php echo TEXT_TITLE; ?></td>
										  <td width="90%">
										  	<?php echo olc_draw_textarea_field('title', 'soft', '100%', '3',$newsletters_data['title']); ?>
										  </td>
										</tr>
										<tr>
											<td width="10%"><?php echo TEXT_TO; ?></td>
											<td width="90%">
												<?php
												for ($i=0,$n=sizeof($customers_status);$i<$n; $i++) {
													$group_query=olc_db_query("SELECT count(*) as count
												                          FROM ".TABLE_NEWSLETTER_RECIPIENTS."
												                          WHERE mail_status='1' and
												                          customers_status='".$customers_status[$i]['id'].APOS);
													$group_data=olc_db_fetch_array($group_query);
													$group_query=olc_db_query("SELECT count(*) as count
												                          FROM ".TABLE_CUSTOMERS."
												                          WHERE
												                          customers_status='".$customers_status[$i]['id'].APOS);
													$group_data_all=olc_db_fetch_array($group_query);
													echo olc_draw_checkbox_field('status['.$i.']', 'yes',true).BLANK.$customers_status[$i]['text'].
													'  <i>(<b>'.$group_data['count'].HTML_B_END.TEXT_USERS.$group_data_all['count'].BLANK.BOX_CUSTOMERS.')
														<br/>';
												}
												echo olc_draw_checkbox_field('status_all', 'yes',false).' <b>'.TEXT_NEWSLETTER_ONLY.HTML_B_END;
											 ?>
											</td>
										</tr>
										<tr>
										  <td width="10%"><?php echo TEXT_CC; ?></td>
										  <td width="90%"><?php
										   echo olc_draw_textarea_field('cc', 'soft', '100%', '3',$newsletters_data['cc']); ?></td>
										</tr>
							      <tr>
								      <td width="10%" valign="top"><?php echo TEXT_BODY; ?></td>
								      <td width="90%"><?php
								      $sw = new SPAW_Wysiwyg(
								      $control_name='newsletter_body', // control's name
								      $value=stripslashes($newsletters_data['body']),                  // initial value
								      $lang=EMPTY_STRING,                   // language
								      $mode = 'full',                 // toolbar mode
								      $theme='default',                  // theme (skin)
								      $width='100%',              // width
								      $height='800px',            // height
								      $css_stylesheet=SPAW_STYLESHEET,         // css stylesheet file for content
								      $dropdown_data=EMPTY_STRING           // data for dropdowns (style, font, etc.)
								      );
								      $sw->show();
	        ?>
								      </td>
								   </tr>
							   </table>
							   <a href="<?php echo olc_href_link(FILENAME_MODULE_NEWSLETTER); ?>">
							   <?php echo olc_image_button('button_back.gif', IMAGE_BACK); ?></a>
							   <right><?php echo olc_image_submit('button_save.gif', IMAGE_SAVE); ?></right>
						  </form>
  <?php
  break;
 } // end switch
?>
						</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</td>
<?php
require(DIR_WS_INCLUDES . 'application_bottom.php');

function html2text($html)
{
	$text=html_entity_decode($html);
	$text=str_replace(array(HTML_BR,HTML_BR,'</p>','</p>'),'\n\n',$text);
	$text=str_replace(array('<p>','<p>'),EMPTY_STRING,$text);
	$text=str_replace(HTML_NBSP,BLANK,$text);
	return strip_tags($text);
}
?>
