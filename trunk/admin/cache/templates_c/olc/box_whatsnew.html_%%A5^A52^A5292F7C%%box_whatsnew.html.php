<?php /* Smarty version 2.6.18, created on 2007-10-10 13:48:34
         compiled from olc/boxes/box_whatsnew.html */ ?>
<?php 
$this->_tpl_vars['heading_var']='heading_whatsnew';
$box_name='box_WHATSNEW';
$template=CURRENT_TEMPLATE_BOXES.'box_specials_whatsnew'.HTML_EXT;
if (!file_exists(TEMPLATE_PATH.$template))
{
	$template=str_replace(CURRENT_TEMPLATE.SLASH,COMMON_TEMPLATE,$template);
}
$this->_tpl_vars['template']=$template;
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['template']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>