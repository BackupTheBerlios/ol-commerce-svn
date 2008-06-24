<?php /* Smarty version 2.6.18, created on 2007-10-10 13:48:34
         compiled from olc/boxes/box_add_a_quickie.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'olc_template_init', 'olc/boxes/box_add_a_quickie.html', 1, false),)), $this); ?>
<?php echo smarty_function_olc_template_init(array('use_template_language' => 'true','section' => 'boxes'), $this);?>

<?php echo $this->_tpl_vars['FORM_ACTION']; ?>

	<table width="100%" class="<?php echo $this->_tpl_vars['box_navigation_area']; ?>
 box_ADD_A_QUICKIE" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td><h3><?php echo $this->_config[0]['vars']['heading_add_a_quickie']; ?>
</h3></td>
		</tr>
		<?php if ($this->_tpl_vars['CONTENT']): ?>
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
		<?php else: ?>
		<tr>
			<td class="infoBox">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="left" valign="middle">
							<?php echo $this->_tpl_vars['INPUT_FIELD']; ?>
&nbsp;
						</td>
						<tr>
						<td align="left" valign="middle">
							<?php echo $this->_tpl_vars['SUBMIT_BUTTON']; ?>

						</td>
						</tr>
					</tr>
					<tr>
						<td colspan="2" align="left" class="infoBoxContents">
							<?php echo $this->_config[0]['vars']['text_quickie']; ?>

						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td class="infoBoxFooter">&nbsp;</td>
		</tr>
	</table>
<?php echo $this->_tpl_vars['FORM_END']; ?>
