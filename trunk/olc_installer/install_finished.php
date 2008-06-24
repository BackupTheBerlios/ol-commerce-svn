<?php
/* --------------------------------------------------------------
$Id: install_finished.php,v 1.1.1.2 2006/12/23 09:21:33 gswkaiser Exp $

OL-Commerce Version 2.x/AJAX
http://www.ol-Commerce.com, http://www.seifenparadies.de

Copyright (c) 2004 OL-Commerce, 2006 Dipl.-Ing.(TH) Winfried Kaiser (w.kaiser@fortune.de, info@seifenparadies.de)
--------------------------------------------------------------
based on:
(c) 2003	    nextcommerce (install_finished.php,v 1.5 2003/08/17); www.nextcommerce.org
(c) 2004      XT - Commerce; www.xt-commerce.com
(c) 2004  		OL - Commerce; www.ol-Commerce.com

Released under the GNU General Public License
--------------------------------------------------------------*/

define('ADMIN_PATH_PREFIX','../');
$level=ADMIN_PATH_PREFIX;
require(ADMIN_PATH_PREFIX.'includes/configure.php');
require('includes/application.php');
$title='Installation beendet';
include('includes/header.php');
?>

                <td width="35"><img src="images/icons/ok.gif"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_DB_CONNECTION; ?></font></td>
                <td><img src="images/icons/ok.gif"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  &nbsp;&nbsp;&nbsp;<img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_DB_CONNECTION; ?></font></td>
                <td><img src="images/icons/ok.gif"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_WEBSERVER_SETTINGS; ?></font></td>
                <td><img src="images/icons/ok.gif"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_WRITE_CONFIG; ?></font></td>
                <td><img src="images/icons/ok.gif"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_ADMIN_CONFIG; ?></font></td>
                <td><img src="images/icons/ok.gif"></td>
              </tr>
                                                  <tr>
                            <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_USERS_CONFIG; ?></font></td>
                <td><img src="images/icons/ok.gif"></td></tr>
            </table>
            <br/></td>
        </tr>
      </table>
    </td>
    <td align="right" valign="top" style="border: 1px solid; border-color: #6D6D6D;">
      <br/>
      <table width="95%" align="center" border="0" align="center" cellpadding="5" cellspacing="5">
        <tr>
           <td align="center">
							<img src="images/bannerolcneu.gif" border="0" title="OL-Commerce ist 'Powered by AJAX'!">
							<br/><br/><br/>
							<font size="1" face="Verdana, Arial, Helvetica, sans-serif">
           		 <?php echo TEXT_WELCOME_FINISHED; ?>
           		</font>
           </td>
        </tr>
      </table>

      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/break-el.gif" width="100%" height="1"></font></p>

      <table width="95%" align="center" border="0" cellpadding="5" cellspacing="5">
        <tr>
          <td><table width="95%" align="center" border="0" cellpadding="5" cellspacing="5">
              <tr>
                <td style="border-bottom: 1px solid; border-color: #CFCFCF">
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>
                <img src="images/icons/arrow-setup.jpg" width="16" height="16">
                  <?php echo TITLE_SHOP_CONFIG; ?></b></font></td>
                <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
              </tr>
            </table>

            <p>&nbsp;</p>
            <p align="center"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <strong><img src="images/logo.gif"><br/>
              </strong></font><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">
              <?php echo TEXT_SHOP_CONFIG_SUCCESS; ?><br/>
              <br/><br/>
              <?php echo TEXT_TEAM; ?><br/>
              </font></p>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">

              <tr>
                <td align="center"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">
                	<?php echo TEXT_RENAME_DIR; ?>
                	</font>
                	<br/><br/></td>
              </tr>
              <tr>
                <td align="center"><a href="<?php echo '../index.php'; ?>"
								target="_blank"><img src="<?php echo BUTTONS_DIR;?>catalog.gif" border="0" title="<?php echo BUTTON_START_SHOP_TEXT;?>"></a></td>
              </tr>
              <tr>
                <td align="center">
                	<?php
                	$text=TEXT_ADD_ONS.'<br/>
                	<a href="../elmar_start.php?file=index.php" target="_blank">
                	<img src="../images/elmar-logo-100x50.gif" border="0" title="Elm@r installieren" ALIGN="middle"></a>
									&nbsp;<a href="../elmar_start.php?file=index.php" target="_blank">Elm@r installieren</a>
                	<br/><br/>
                	<a href="../chCounter/install/install.php" target="_blank">Shop-Statistik (chCounter) installieren</a>
';
                	$file="livehelp_install.php";
                	if (false and file_exists($file))
                	{
                		$text.='
                	<br/><br/>
                	<a href="'.$file.'" target="_blank">Live Help installieren</a>
';
                	}
                	$text.='
                	<br/>
';
                	echo $text;
                	?>
                </td>

              </tr>
            </table>
            <p align="center"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><br/>
              </font></p></td>
        </tr>
      </table>
<?php
include('includes/footer.php');
?>
