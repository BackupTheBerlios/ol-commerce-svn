<?php
/*
$Id: Results.inc.php,v 1.1.1.1 2006/12/22 13:43:25 gswkaiser Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

DevosC, Developing open source Code
http://www.devosc.com

Copyright (c) 2003 osCommerce
Copyright (c) 2004 DevosC.com
Copyright (c) 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de) -- Port to OL-Commerce

Released under the GNU General Public License
*/
require_once(DIR_FS_INC.'olc_draw_form.inc.php');
require_once(DIR_FS_INC.'olc_draw_hidden_field.inc.php');
olc_draw_form('ipn',$_SERVER['HTTP_REFERER'],'GET');
olc_draw_hidden_field('action','itp');
?>
<table border="0" cellspacing="0" cellpadding="0" class="main">
<?php if($debug->error) { ?>
  <tr>
    <td>
      <table border="0" cellspacing="0" cellpadding="0" style="padding: 4px; border:1px solid;">
        <tr>
          <td><?php echo $page->image('icon_error_40x40.gif',IMAGE_ERROR); ?></td>
          <td><br class="text_spacer"></td>
          <td class="pperrorbold" style="text-align: center; width:100%;"><?php echo TEST_INCOMPLETE; ?></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr><td><br class="h10"/></td></tr>
  <tr>
    <td class="ppsmalltext"><?php echo TEST_INCOMPLETE_MSG; ?></td>
  </tr>
  <tr><td><br class="h10"/></td></tr>
<?php } else { ?>
  <tr>
    <td>
      <table border="0" cellspacing="0" cellpadding="0" style="padding: 4px; border:1px solid;">
        <tr>
          <td><br class="text_spacer"></td>
          <td class="pperrorbold" style="text-align: center; width:100%;"><?php echo TEST_COMPLETE; ?></td>
        </tr>
      </table>
    </td>
  </tr>
<?php }
if($debug->enabled) { ?>
  <tr>
    <td style="pptext"><?php echo $debug->info(true); ?></td>
  </tr>
<?php } ?>
  <tr><td><hr class="solid"/></td></tr>
  <tr><td class="buttontd"><input class="ppbuttonsmall" type="submit" name="submit" value="Continue"></td></tr>
</table>
</form>