<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_contact.php,v 1.1.1.1.2.1 2007/04/08 07:16:23 gswkaiser Exp $

   OLC-Affiliate - Contribution for OL-Commerce http://www.ol-commerce.de, http://www.seifenparadies.de

   modified by http://www.ol-commerce.de, http://www.seifenparadies.de


   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_contact.php, v 1.5 2003/02/17);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   Copyright (c) 2003 netz-designer
   Copyright (c) 2005 OL-Commerce , 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

  require('includes/application_top.php');

  if ( ($_GET['action'] == 'send_email_to_user') && ($_POST['affiliate_email_address']) && (!$_POST['back_x']) ) {
    switch ($_POST['affiliate_email_address']) {
      case '***':
        $mail_query = olc_db_query("select affiliate_firstname, affiliate_lastname, affiliate_email_address from " . TABLE_AFFILIATE . BLANK);
        $mail_sent_to = TEXT_ALL_AFFILIATES;
        break;
//      case '**D':
//        $mail_query = olc_db_query("select affiliate_firstname, affiliate_lastname, affiliate_email_address from " . TABLE_AFFILIATE . " where affiliate_newsletter = '1'");
//        $mail_sent_to = TEXT_NEWSLETTER_AFFILIATE;
//        break;
      default:
        $affiliate_email_address = olc_db_prepare_input($_POST['affiliate_email_address']);

        $mail_query = olc_db_query("select affiliate_firstname, affiliate_lastname, affiliate_email_address from " . TABLE_AFFILIATE . " where affiliate_email_address = '" . olc_db_input($affiliate_email_address) . APOS);
        $mail_sent_to = $_POST['affiliate_email_address'];
        break;
    }

    $from = olc_db_prepare_input($_POST['from']);
    $subject = olc_db_prepare_input($_POST['subject']);
    $message = olc_db_prepare_input($_POST['message']);

    // Instantiate a new mail object
    $mimemessage = new email(array('X-Mailer: OLC mailer'));

    // Build the text version
    $text = strip_tags($text);
    if (EMAIL_USE_HTML == TRUE_STRING_S) {
      $mimemessage->add_html($message);
    } else {
      $mimemessage->add_text($message);
    }

    // Send message
    $mimemessage->build_message();
    while ($mail = olc_db_fetch_array($mail_query)) {
      $mimemessage->send($mail['affiliate_firstname'] . BLANK . $mail['affiliate_lastname'], $mail['affiliate_email_address'], '', $from, $subject);
    }

    olc_redirect(olc_href_link(FILENAME_AFFILIATE_CONTACT, 'mail_sent_to=' . urlencode($mail_sent_to)));
  }

  if ( ($_GET['action'] == 'preview') && (!$_POST['affiliate_email_address']) ) {
    $messageStack->add(ERROR_NO_AFFILIATE_SELECTED, 'error');
  }

  if (olc_not_null($_GET['mail_sent_to'])) {
    $messageStack->add(sprintf(NOTICE_EMAIL_SENT_TO, $_GET['mail_sent_to']), 'notice');
  }
?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="columnLeft2" nowrap="nowrap" valign="top"><table border="0" cellspacing="1" cellpadding="1" class="columnLeft" nowrap="nowrap">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo olc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ( ($_GET['action'] == 'preview') && ($_POST['affiliate_email_address']) ) {
    switch ($_POST['affiliate_email_address']) {
      case '***':
        $mail_sent_to = TEXT_ALL_AFFILIATES;
        break;
//      case '**D':
//        $mail_sent_to = TEXT_NEWSLETTER_AFFILIATES;
//        break;
      default:
        $mail_sent_to = $_POST['affiliate_email_address'];
        break;
    }
?>
          <tr><?php echo olc_draw_form('mail', FILENAME_AFFILIATE_CONTACT, 'action=send_email_to_user'); ?>
            <td><table border="0" width="100%" cellpadding="0" cellspacing="2">
              <tr>
                <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_AFFILIATE; ?></b><br/><?php echo $mail_sent_to; ?></td>
              </tr>
              <tr>
                <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_FROM; ?></b><br/><?php echo htmlspecialchars(stripslashes($_POST['from'])); ?></td>
              </tr>
              <tr>
                <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_SUBJECT; ?></b><br/><?php echo htmlspecialchars(stripslashes($_POST['subject'])); ?></td>
              </tr>
              <tr>
                <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_MESSAGE; ?></b><br/><?php echo nl2br(htmlspecialchars(stripslashes($_POST['message']))); ?></td>
              </tr>
              <tr>
                <td><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td>
<?php
/* Re-Post all POST'ed variables */
    reset($_POST);
    while (list($key, $value) = each($_POST)) {
      if (!is_array($_POST[$key])) {
        echo olc_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
      }
    }
?>
                <table border="0" width="100%" cellpadding="0" cellspacing="2">
                  <tr>
                    <td><?php echo olc_image_submit('button_back.gif', IMAGE_BACK, 'name="back"'); ?></td>
                    <td align="right"><?php echo HTML_A_START . olc_href_link(FILENAME_AFFILIATE_CONTACT) . '">' . olc_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a> ' . olc_image_submit('button_send_mail.gif', IMAGE_SEND_EMAIL); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </form></tr>
<?php
  } else {
?>
          <tr><?php echo olc_draw_form('mail', FILENAME_AFFILIATE_CONTACT, 'action=preview'); ?>
            <td><table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
<?php
    $affiliate = array();
    $affiliate[] = array('id' => '', 'text' => TEXT_SELECT_AFFILIATE);
    $affiliate[] = array('id' => '***', 'text' => TEXT_ALL_AFFILIATES);
//    $affiliate[] = array('id' => '**D', 'text' => TEXT_NEWSLETTER_AFFILIATES);
    $mail_query = olc_db_query("select affiliate_email_address, affiliate_firstname, affiliate_lastname from " . TABLE_AFFILIATE . " order by affiliate_lastname");
    while($affiliate_values = olc_db_fetch_array($mail_query)) {
      $affiliate[] = array('id' => $affiliate_values['affiliate_email_address'],
                           'text' => $affiliate_values['affiliate_lastname'] . ', ' . $affiliate_values['affiliate_firstname'] . LPAREN . $affiliate_values['affiliate_email_address'] . RPAREN);
    }
?>
              <tr>
                <td class="main"><?php echo TEXT_AFFILIATE; ?></td>
                <td><?php echo olc_draw_pull_down_menu('affiliate_email_address', $affiliate, $_GET['affiliate']);?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo TEXT_FROM; ?></td>
                <td><?php echo olc_draw_input_field('from', AFFILIATE_EMAIL_ADDRESS, 'size="60"'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo TEXT_SUBJECT; ?></td>
                <td><?php echo olc_draw_input_field('subject', '', 'size="60"'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td valign="top" class="main"><?php echo TEXT_MESSAGE; ?></td>
                <td><?php echo olc_draw_textarea_field('message', 'soft', '60', '15'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo olc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td colspan="2" align="right"><?php echo olc_image_submit('button_send_mail.gif', IMAGE_SEND_EMAIL); ?></td>
              </tr>
            </table></td>
          </form></tr>
<?php
  }
?>
<!-- body_text_eof //-->
        </table></td>
      </tr>
    </table></td>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
