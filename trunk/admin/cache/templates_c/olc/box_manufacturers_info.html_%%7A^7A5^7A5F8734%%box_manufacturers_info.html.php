<?php /* Smarty version 2.6.18, created on 2007-10-10 13:48:34
         compiled from olc/boxes/box_manufacturers_info.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'olc_template_init', 'olc/boxes/box_manufacturers_info.html', 1, false),)), $this); ?>
<?php echo smarty_function_olc_template_init(array('use_template_language' => 'true','section' => 'boxes'), $this);?>

<table class="<?php echo $this->_tpl_vars['box_navigation_area']; ?>
 box_MANUFACTURERS_INFO" width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><h3>
      <?php echo $this->_config[0]['vars']['heading_manufacturers_info']; ?>

    </h3></td>
  </tr>
  <tr>
    <td class="infoBox">
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <?php if ($this->_tpl_vars['MANUFACTURERS_IMAGE']): ?>
        <tr>
          <td align="center" class="boxText" colspan="2"><?php echo $this->_tpl_vars['MANUFACTURERS_IMAGE']; ?>
</td>
        </tr>
        <?php endif; ?>
      	<?php if ($this->_tpl_vars['MANUFACTURERS_URL']): ?>
        <tr>
          <td align="center" class="boxText" colspan="2"><?php echo $this->_tpl_vars['MANUFACTURERS_URL']; ?>
</td>
        </tr>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['CONTENT']): ?>
        <tr>
          <td valign="top" class="boxText"><?php if ($this->_tpl_vars['SHOW_BULLET']): ?><?php echo $this->_tpl_vars['bullet']; ?>
<?php endif; ?></td>
          <td valign="top" class="boxText"><?php echo $this->_tpl_vars['BOX_CONTENT']; ?>
</td>
        </tr>
        <?php endif; ?>
      </table>
    </td>
  </tr>
	<tr>
		<td class="infoBoxFooter">&nbsp;</td>
	</tr>
</table>