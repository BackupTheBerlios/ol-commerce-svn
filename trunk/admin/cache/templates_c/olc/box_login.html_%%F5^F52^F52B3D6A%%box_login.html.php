<?php /* Smarty version 2.6.18, created on 2007-10-10 13:48:34
         compiled from olc/boxes/box_login.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'olc_template_init', 'olc/boxes/box_login.html', 1, false),)), $this); ?>
<?php echo smarty_function_olc_template_init(array('use_template_language' => 'true','section' => 'boxes'), $this);?>

<table class="<?php echo $this->_tpl_vars['box_navigation_area']; ?>
 box_LOGIN" width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td><h3><?php echo $this->_config[0]['vars']['heading_login']; ?>
</h3></td>
  </tr>
  <tr>
    <td class="infoBox">
    	<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>
          	<?php echo $this->_tpl_vars['FORM_ACTION']; ?>

			        <table width="100%" border="0" cellpadding="0" cellspacing="0">
			          <tr>
			            <td colspan="2" class="infoBoxContents color"><?php echo $this->_tpl_vars['TEXT_EMAIL']; ?>
</td>
			          </tr>
			          <tr>
			            <td colspan="2"><?php echo $this->_tpl_vars['FIELD_EMAIL']; ?>
</td>
			          </tr>
			          <tr>
			            <td colspan="2" class="infoBoxContents color"><?php echo $this->_tpl_vars['TEXT_PWD']; ?>
</td>
			          </tr>
			          <tr>
                  <td><?php echo $this->_tpl_vars['FIELD_PWD']; ?>
</td>
                  <tr>
                  <td></td>
                  </tr>
                  <td align="left"><?php echo $this->_tpl_vars['BUTTON']; ?>
</td>
			          </tr>
			        </table>
			      <?php echo $this->_tpl_vars['FORM_END']; ?>

			      <span class="infoBoxContents color">
			      <a href="create_account.php" alt="" title="<?php echo $this->_config[0]['vars']['new_customer_login']; ?>
"><?php echo $this->_config[0]['vars']['new_customer_login']; ?>
</a>
			      </span>
			   	</td>
        </tr>
    	</table>
    </td>
  </tr>
</table>