<?php /* Smarty version 2.6.18, created on 2007-10-05 11:45:25
         compiled from olc/mail/german/mail_impressum.html */ ?>
<?php echo $this->_tpl_vars['STORE_NAME_ADDRESS_TEXT']; ?>
:<br/><br/>
<?php echo $this->_tpl_vars['STORE_NAME_ADDRESS']; ?>

<br/><br/>
<table cellspacing="0" cellpadding="0">
  <?php if ($this->_tpl_vars['STORE_USTID']): ?>
  <tr>
    <td valign="top"><?php echo $this->_tpl_vars['STORE_USTID_TEXT']; ?>
:&nbsp;</td>
    <td valign="top">&nbsp;<?php echo $this->_tpl_vars['STORE_USTID']; ?>
</td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['STORE_TAXNR']): ?>
  <tr>
    <td valign="top"><?php echo $this->_tpl_vars['STORE_TAXNR_TEXT']; ?>
:&nbsp;</td>
    <td valign="top">&nbsp;<?php echo $this->_tpl_vars['STORE_TAXNR']; ?>
</td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['STORE_REGISTER']): ?>
	  <tr>
	    <td valign="top"><?php echo $this->_tpl_vars['STORE_REGISTER_TEXT']; ?>
:&nbsp;</td>
	    <td valign="top">&nbsp;<?php echo $this->_tpl_vars['STORE_REGISTER']; ?>
</td>
	  </tr>
	  <?php if ($this->_tpl_vars['STORE_REGISTER_NR']): ?>
	  <tr>
	    <td valign="top"><?php echo $this->_tpl_vars['STORE_REGISTER_NR_TEXT']; ?>
:&nbsp;</td>
	    <td valign="top">&nbsp;<?php echo $this->_tpl_vars['STORE_REGISTER_NR']; ?>
</td>
	  </tr>
	  <?php endif; ?>
	  <?php if ($this->_tpl_vars['STORE_MANAGER']): ?>
	  <tr>
	    <td valign="top"><?php echo $this->_tpl_vars['STORE_MANAGER_TEXT']; ?>
:&nbsp;</td>
	    <td valign="top">&nbsp;<?php echo $this->_tpl_vars['STORE_MANAGER']; ?>
</td>
	  </tr>
	  <?php endif; ?>
	  <?php if ($this->_tpl_vars['STORE_DIRECTOR']): ?>
	  <tr>
	    <td valign="top"><?php echo $this->_tpl_vars['STORE_DIRECTOR_TEXT']; ?>
:&nbsp;</td>
	    <td valign="top">&nbsp;<?php echo $this->_tpl_vars['STORE_DIRECTOR']; ?>
</td>
	  </tr>
	  <?php endif; ?>
  <?php endif; ?>
</table>