<?php /* Smarty version 2.6.18, created on 2007-10-10 13:48:34
         compiled from olc/boxes/box_newsletter.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'olc_template_init', 'olc/boxes/box_newsletter.html', 1, false),)), $this); ?>
<?php echo smarty_function_olc_template_init(array('use_template_language' => 'true','section' => 'boxes'), $this);?>

<?php echo $this->_tpl_vars['FORM_ACTION']; ?>

	<table width="100%" class="<?php echo $this->_tpl_vars['box_navigation_area']; ?>
 box_NEWSLETTER" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td><h3><?php echo $this->_config[0]['vars']['heading_newsletter']; ?>
</h3></td>
		</tr>
		<tr>
		  <td class="infoBox">
				<?php if ($this->_tpl_vars['CONTENT']): ?>
				<?php echo $this->_tpl_vars['BOX_CONTENT']; ?>

				<?php else: ?>
	    	<font class="color" style="font-size:10px"><?php echo $this->_config[0]['vars']['newsletter_title']; ?>
</font>
	      <table width="100%"  border="0" cellpadding="0" cellspacing="2">
	        <tr>
	          <td width="100%" valign="middle"><?php echo $this->_tpl_vars['FIELD_EMAIL']; ?>
</td>
	        </tr>
	        <tr>
	          <td width="100%" valign="middle"><?php echo $this->_tpl_vars['BUTTON']; ?>
</td>
	        </tr>
	      </table>
		    <?php endif; ?>
	    </td>
		</tr>
		<tr>
			<td class="infoBoxFooter">&nbsp;</td>
		</tr>
	</table>
<?php echo $this->_tpl_vars['FORM_END']; ?>
