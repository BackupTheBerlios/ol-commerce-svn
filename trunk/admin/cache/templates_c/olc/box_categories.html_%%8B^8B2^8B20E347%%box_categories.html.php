<?php /* Smarty version 2.6.18, created on 2007-10-10 13:48:34
         compiled from olc/boxes/box_categories.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'olc_template_init', 'olc/boxes/box_categories.html', 2, false),)), $this); ?>
<?php if ($this->_tpl_vars['BOX_CONTENT']): ?>
<?php echo smarty_function_olc_template_init(array('use_template_language' => 'true','section' => 'boxes'), $this);?>

<table width="100%" class="<?php echo $this->_tpl_vars['box_navigation_area']; ?>
 box_CATEGORIES" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><h3><?php echo $this->_config[0]['vars']['heading_categories']; ?>
</h3></td>
  </tr>
  <tr>
    <td class="infoBox">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    	  	<tr>
      	  <td class="infoBoxContents" align="left"><?php echo $this->_tpl_vars['BOX_CONTENT']; ?>
</td>
      	</tr>
    	   </table>
 	</td>
  </tr>
  <tr>
	<td class="infoBoxFooter">&nbsp;</td>
  </tr>
</table>
<?php endif; ?>