<?php /* Smarty version 2.6.18, created on 2007-10-10 13:48:34
         compiled from olc/boxes/box_last_viewed.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'olc_template_init', 'olc/boxes/box_last_viewed.html', 1, false),)), $this); ?>
<?php echo smarty_function_olc_template_init(array('use_template_language' => 'true','section' => 'boxes'), $this);?>

<table class="<?php echo $this->_tpl_vars['box_navigation_area']; ?>
 box_LAST_VIEWED" width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><h3><?php echo $this->_config[0]['vars']['heading_last_viewed']; ?>
</h3></td>
        </tr>
    	</table>
    </td>
  </tr>
  <tr>
    <td class="infoBox" align="left">
  		<table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" valign="middle" class="infoBoxContents">
            <a><?php if ($this->_tpl_vars['IMAGE']): ?><?php echo $this->_tpl_vars['LINK']; ?>
<?php echo $this->_tpl_vars['IMAGE']; ?>
</a><br/><?php endif; ?>
          	<a><?php echo $this->_tpl_vars['LINK']; ?>
<?php echo $this->_tpl_vars['NAME']; ?>
</a><br/>
            <table width=100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle">
						  		<span class="price_list"><?php echo $this->_config[0]['vars']['text_only']; ?>
<?php echo $this->_tpl_vars['PRICE']; ?>
</span><br />
									<?php if ($this->_tpl_vars['VPE']): ?>
					      	<?php if (! $this->_tpl_vars['OL_COMMERCE']): ?>
									<span class="list_entry_products_vpe"><?php echo $this->_tpl_vars['VPE']; ?>
</span><br />
									<?php endif; ?>
						    	<?php endif; ?>
									<span class="list_entry_price_disclaimer">
										<?php echo $this->_tpl_vars['TAX_INFO']; ?>
<?php if (! $this->_tpl_vars['OL_COMMERCE']): ?><?php echo $this->_config[0]['vars']['price_disclaimer_box']; ?>
<?php endif; ?>
									</span>
                </td>
              </tr>
          	</table>
          </td>
        </tr>
        <tr>
          <td align="center" valign="middle" class="infoBoxContents">
          	<br/><p><a href="<?php echo $this->_tpl_vars['MY_PERSONAL_PAGE']; ?>
"><b><?php echo $this->_config[0]['vars']['text_my_page']; ?>
</b></a></p>
          </td>
        </tr>
        <tr>
          <td align="center" valign="middle" class="infoBoxContents">
            <br/><?php echo $this->_config[0]['vars']['text_watch_category']; ?>
<br/><a href="<?php echo $this->_tpl_vars['CATEGORY_LINK']; ?>
"><strong><?php echo $this->_tpl_vars['CATEGORY_NAME']; ?>
</strong></a>
          </td>
        </tr>
    	</table>
    </td>
  </tr>
	<tr>
		<td class="infoBoxFooter">&nbsp;</td>
	</tr>
</table>