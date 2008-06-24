<?php
/* -----------------------------------------------------------------------------------------
$Id: olc_php_mail.inc.php,v 1.1.1.1.2.1 2007/04/08 07:17:38 gswkaiser Exp $

OL-Commerce Version 5.x/AJAX
http://www.ol-commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
-----------------------------------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (olc_php_mail.inc.php,v 1.17 2003/08/24); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com


Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//	W. Kaiser - eMail-type by customer
//function olc_php_mail($from_email_address, $from_email_name, $to_email_address, $to_name, $forwarding_to, $reply_address, $reply_address_name, $path_to_attachement, $path_to_more_attachements, $email_subject, $message_body_html, $message_body_plain) {
function olc_php_mail($from_email_address, $from_email_name, $to_email_address, $to_name, $forwarding_to, $reply_address,
$reply_address_name, $path_to_attachement, $path_to_more_attachements, $email_subject, $message_body_html,
$message_body_plain, $to_email_mode='') {
	//	W. Kaiser - eMail-type by customer
	global $mail_error;

	$mail = new PHPMailer();
	$mail->PluginDir=DIR_FS_DOCUMENT_ROOT.'includes/classes/';
	$mail->CharSet=$_SESSION['language_charset'];
	if (SESSION_LANGUAGE=='german') {
		$mail->SetLanguage("de",DIR_WS_CLASSES);
	} else {
		$mail->SetLanguage("en",DIR_WS_CLASSES);
	}
	//if (EMAIL_TRANSPORT=='smtp' || $_SERVER['SERVER_NAME'] == 'localhost') {
	if (EMAIL_TRANSPORT=='smtp') {
		$mail->IsSMTP();
		$mail->SMTPKeepAlive = true;                                    // set mailer to use SMTP
		$mail->SMTPAuth = SMTP_AUTH;                                    // turn on SMTP authentication true/false
		$mail->Username = SMTP_USERNAME;                                // SMTP username
		$mail->Password = SMTP_PASSWORD;                                // SMTP password
		// specify main and backup server "smtp1.example.com;smtp2.example.com"
		$mail->Host = SMTP_MAIN_SERVER . SEMI_COLON . SMTP_Backup_Server;
	}

	if (EMAIL_TRANSPORT=='sendmail') {                              // set mailer to use SMTP
	$mail ->IsSendmail();
	$mail->Sendmail=SENDMAIL_PATH;
	}
	if (EMAIL_TRANSPORT=='mail') {
		$mail ->IsMail();
	}

	//	if ( EMAIL_USE_HTML==TRUE_STRING_S )                                   // set email format to HTML
	//	W. Kaiser - eMail-type by customer
	if ($to_email_mode <> EMAIL_TYPE_HTML) {
		if ($to_email_mode <> EMAIL_TYPE_TEXT) {
			if (EMAIL_USE_HTML)
			{
				$to_email_mode = EMAIL_TYPE_HTML;                                 // eMail-type not defined --> use system default
			}
		}
	}
	if ($to_email_mode == EMAIL_TYPE_HTML)                                   // set email format to HTML
	//	W. Kaiser - eMail-type by customer
	{
		$mail->IsHTML(true);
		$mail->Body = $message_body_html;
		// remove html tags
		$message_body_plain=str_replace(HTML_BR," \n",$message_body_plain);
		$message_body_plain=strip_tags($message_body_plain);
		$mail->AltBody = $message_body_plain;
	}
	else
	{
		$mail->IsHTML(false);
		//remove html tags
		$message_body_plain=str_replace(array(HTML_BR,HTML_BR),NEW_LINE,$message_body_plain);
		$message_body_plain=strip_tags($message_body_plain);
		$mail->Body=$message_body_plain;
	}
	$mail->From = $from_email_address;
	$mail->FromName = $from_email_name;
	$mail->AddAddress($to_email_address, $to_name);
	$mail->AddBCC($forwarding_to);
	$mail->AddReplyTo($reply_address, $reply_address_name);
	$mail->WordWrap = 80;
	if (is_array($path_to_attachement))
	{
		for ($i=0;$i<sizeof($path_to_attachement);$i++)
		{
			$mail->AddAttachment($path_to_attachement[$i]);					      // add attachments
		}
	}
	else
	{
		$mail->AddAttachment($path_to_attachement);                     // add attachments
		$mail->AddAttachment($path_to_more_attachements);               // optional name
	}
	$mail->Subject = $email_subject;
	if(!$mail->Send())
	{
		global $messageStack,$message;
		$message="eMail konnte nicht versandt werden\n\nMailer-Fehler-Nachricht: " . $mail->ErrorInfo;
		$mail_error=true;
		if (!is_object($messageStack))
		{
			// initialize the message stack for output messages
			require_once(DIR_WS_CLASSES . 'message_stack.php');
			$messageStack = new messageStack;
		}
		if (is_object($messageStack)) $messageStack->add('mailer', $message,'error',false);
	}
}
?>