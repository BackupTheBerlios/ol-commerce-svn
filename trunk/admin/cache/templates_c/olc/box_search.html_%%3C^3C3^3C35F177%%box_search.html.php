<?php /* Smarty version 2.6.18, created on 2007-10-10 13:48:34
         compiled from olc/boxes/box_search.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'olc_template_init', 'olc/boxes/box_search.html', 1, false),)), $this); ?>
<?php echo smarty_function_olc_template_init(array('use_template_language' => 'true','section' => 'boxes'), $this);?>

<?php echo $this->_tpl_vars['FORM_ACTION']; ?>

	<table width="100%" class="<?php echo $this->_tpl_vars['box_navigation_area']; ?>
 box_SEARCH" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td><h3><?php echo $this->_config[0]['vars']['heading_search']; ?>
</h3></td>
		</tr>
		<?php if ($this->_tpl_vars['CONTENT']): ?>
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
		<?php else: ?>
		<tr>
			<td colspan="2" class="infoBox">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td class="infoBoxContents">
							<?php echo $this->_config[0]['vars']['text_search_word']; ?>
<br/><?php echo $this->_tpl_vars['INPUT_SEARCH']; ?>
&nbsp;<?php echo $this->_tpl_vars['BUTTON_SUBMIT']; ?>

						</td>
					</tr>
					<?php if ($this->_tpl_vars['SELECTIONS']): ?>
					<tr>
						<td align="left" class="infoBoxContents">
							<?php echo $this->_tpl_vars['SELECTIONS']; ?>

						</td>
					</tr>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['LINK_ADVANCED']): ?>
					<tr>
						<td align="left" valign="middle" class="infoBoxContents">
							<a href="<?php echo $this->_tpl_vars['LINK_ADVANCED']; ?>
"><?php echo $this->_tpl_vars['bullet']; ?>
</a>&nbsp;
							<a href="<?php echo $this->_tpl_vars['LINK_ADVANCED']; ?>
" title="<?php echo $this->_config[0]['vars']['text_advanced_search']; ?>
"><?php echo $this->_config[0]['vars']['text_advanced_search']; ?>
</a>
						</td>
					</tr>
					<?php endif; ?>
				</table>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td colspan="2" class="infoBoxFooter">&nbsp;</td>
		</tr>
	</table>
<?php echo $this->_tpl_vars['FORM_END']; ?>
