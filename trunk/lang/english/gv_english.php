<?php
define('BOX_INFORMATION_GV', 'Gift Voucher FAQ');
define('BOX_HEADING_GIFT_VOUCHER', 'Gift Voucher Account'); 
define('GV_FAQ', 'Gift Voucher FAQ');
define('ERROR_REDEEMED_AMOUNT', 'Congratulations, you have redeemed ');
define('ERROR_NO_REDEEM_CODE', 'You did not enter a redeem code.');  
define('ERROR_NO_INVALID_REDEEM_GV', 'Invalid Gift Voucher Code'); 
define('TABLE_HEADING_CREDIT', 'Credits Available');
define('ENTRY_AMOUNT_CHECK_ERROR', 'You do not have enough funds to send this amount.'); 

define('EMAIL_GV_INCENTIVE_HEADER', "\n\n" .'As part of our welcome to new customers, we have sent you an e-Gift Voucher worth %s');
define('EMAIL_GV_REDEEM', 'The redeem code for the e-Gift Voucher is %s, you can enter the redeem code when checking out while making a purchase');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Congratulations, to make your first visit to our online shop a more rewarding experience we are sending you an e-Discount Coupon.' . NEW_LINE .
                                        ' Below are details of the Discount Coupon created just for you' . NEW_LINE);
define('EMAIL_COUPON_REDEEM', 'To use the coupon enter the redeem code which is %s during checkout while making a purchase');
define('EMAIL_SUBJECT', 'Message from ' . STORE_NAME);
define('EMAIL_SEPARATOR', '----------------------------------------------------------------------------------------');

define('EMAIL_GV_TEXT_HEADER', 'Congratulations, You have received a gift voucher worth %s');
define('EMAIL_GV_TEXT_SUBJECT', 'A gift from %s');
define('EMAIL_GV_FROM', 'This Gift Voucher has been sent to you by %s');
define('EMAIL_GV_MESSAGE', 'With a message saying ');
define('EMAIL_GV_SEND_TO', 'Hi, %s');
define('EMAIL_GV_REDEEMED', 'To redeem this Gift Voucher, please click on the link below. Please also write down the redemption code which is %s. In case you have problems.');
define('EMAIL_GV_LINK', 'To redeem please click ');
define('EMAIL_GV_VISIT', ' or visit ');
define('EMAIL_GV_ENTER', ' and enter the code ');
define('EMAIL_GV_FIXED_FOOTER', 'If you are have problems redeeming the Gift Voucher using the automated link above, ' . NEW_LINE .
                                'you can also enter the Gift Voucher code during the checkout process at our store.' . "\n\n");
define('EMAIL_GV_SHOP_FOOTER', '');
define('MAIN_MESSAGE', 'You have decided to send a gift voucher worth %s to %s who\'s email address is %s<br/><br/>The text accompanying the email will read<br/><br/>Dear %s<br/><br/>
                        You have been sent a Gift Voucher worth %s by %s');

define('PERSONAL_MESSAGE', '%s says:');

  define('NAVBAR_GV_FAQ', 'Gift Voucher FAQ');
  define('NAVBAR_GV_REDEEM', 'Redeem Voucher');
  define('NAVBAR_GV_SEND', 'Send Voucher');
?>