<?php /* Smarty version 2.6.18, created on 2007-10-10 13:48:34
         compiled from olc/boxes/box_tab_navigation.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'olc_template_init', 'olc/boxes/box_tab_navigation.html', 1, false),)), $this); ?>
<?php echo smarty_function_olc_template_init(array('use_template_language' => 'true','section' => 'boxes'), $this);?>

<?php echo '
<style type="text/css">
td.tabcol  {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol0 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol1 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol2 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol3 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol4 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol5 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol6 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol7 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol8 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol9 {font-weight:bold; font-size:12px;vertical-align: middle;}

td.tabcol10 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol11 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol12 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol13 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol14 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol15 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol16 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol17 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol18 {font-weight:bold; font-size:12px;vertical-align: middle;}
td.tabcol19 {font-weight:bold; font-size:12px;vertical-align: middle;}

a.sublink {font-weight:bold; font-weight:bold; font-size:12px;vertical-align: middle;}
a.sublink:hover { text-decoration: underline; font-size:12px}
</style>
'; ?>

<table class="<?php echo $this->_tpl_vars['box_navigation_area']; ?>
 box_TAB_NAVIGATION" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr valign="top" align="left">
		<td>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<?php unset($this->_sections['data']);
$this->_sections['data']['name'] = 'data';
$this->_sections['data']['loop'] = is_array($_loop=$this->_tpl_vars['content']['main']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['data']['show'] = true;
$this->_sections['data']['max'] = $this->_sections['data']['loop'];
$this->_sections['data']['step'] = 1;
$this->_sections['data']['start'] = $this->_sections['data']['step'] > 0 ? 0 : $this->_sections['data']['loop']-1;
if ($this->_sections['data']['show']) {
    $this->_sections['data']['total'] = $this->_sections['data']['loop'];
    if ($this->_sections['data']['total'] == 0)
        $this->_sections['data']['show'] = false;
} else
    $this->_sections['data']['total'] = 0;
if ($this->_sections['data']['show']):

            for ($this->_sections['data']['index'] = $this->_sections['data']['start'], $this->_sections['data']['iteration'] = 1;
                 $this->_sections['data']['iteration'] <= $this->_sections['data']['total'];
                 $this->_sections['data']['index'] += $this->_sections['data']['step'], $this->_sections['data']['iteration']++):
$this->_sections['data']['rownum'] = $this->_sections['data']['iteration'];
$this->_sections['data']['index_prev'] = $this->_sections['data']['index'] - $this->_sections['data']['step'];
$this->_sections['data']['index_next'] = $this->_sections['data']['index'] + $this->_sections['data']['step'];
$this->_sections['data']['first']      = ($this->_sections['data']['iteration'] == 1);
$this->_sections['data']['last']       = ($this->_sections['data']['iteration'] == $this->_sections['data']['total']);
?>
					<td class="<?php echo $this->_tpl_vars['content']['main'][$this->_sections['data']['index']]['CSS']; ?>
">
						<img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
images/tab_left.gif" border="0" alt="">
					</td>
					<td nowrap="nowrap" class="<?php echo $this->_tpl_vars['content']['main'][$this->_sections['data']['index']]['CSS']; ?>
">
						<?php if ($this->_tpl_vars['content']['main'][$this->_sections['data']['index']]['ICO']): ?>
							<img src="<?php echo $this->_tpl_vars['content']['main'][$this->_sections['data']['index']]['ICO']; ?>
" border="0"
								alt="<?php echo $this->_tpl_vars['content']['main'][$this->_sections['data']['index']]['NAME']; ?>
"
								title="<?php echo $this->_tpl_vars['content']['main'][$this->_sections['data']['index']]['NAME']; ?>
"
								align="absmiddle"
							/>&nbsp;
						<?php endif; ?>
						<a class="inactiveTab" href="<?php echo $this->_tpl_vars['content']['main'][$this->_sections['data']['index']]['URL']; ?>
"
						<?php if ($this->_tpl_vars['content']['main'][$this->_sections['data']['index']]['TARGET']): ?>
						target="<?php echo $this->_tpl_vars['content']['main'][$this->_sections['data']['index']]['TARGET']; ?>
"
						<?php endif; ?>
						><?php echo $this->_tpl_vars['content']['main'][$this->_sections['data']['index']]['NAME']; ?>
</a>
					</td>
					<td class="<?php echo $this->_tpl_vars['content']['main'][$this->_sections['data']['index']]['CSS']; ?>
">
						<img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
images/tab_right.gif" border="0" alt="">&nbsp;
					</td>
					<?php endfor; endif; ?>
				</tr>
			</table>
		</td>
	</tr>
    <tr>
    	<td class="tabcol<?php echo $this->_tpl_vars['active_tab']; ?>
" align="left">
			<?php if ($this->_tpl_vars['content']['sub'][$this->_tpl_vars['active_tab']]): ?>|<?php endif; ?>&nbsp;
			<?php unset($this->_sections['data2']);
$this->_sections['data2']['name'] = 'data2';
$this->_sections['data2']['loop'] = is_array($_loop=$this->_tpl_vars['content']['sub'][$this->_tpl_vars['active_tab']]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['data2']['show'] = true;
$this->_sections['data2']['max'] = $this->_sections['data2']['loop'];
$this->_sections['data2']['step'] = 1;
$this->_sections['data2']['start'] = $this->_sections['data2']['step'] > 0 ? 0 : $this->_sections['data2']['loop']-1;
if ($this->_sections['data2']['show']) {
    $this->_sections['data2']['total'] = $this->_sections['data2']['loop'];
    if ($this->_sections['data2']['total'] == 0)
        $this->_sections['data2']['show'] = false;
} else
    $this->_sections['data2']['total'] = 0;
if ($this->_sections['data2']['show']):

            for ($this->_sections['data2']['index'] = $this->_sections['data2']['start'], $this->_sections['data2']['iteration'] = 1;
                 $this->_sections['data2']['iteration'] <= $this->_sections['data2']['total'];
                 $this->_sections['data2']['index'] += $this->_sections['data2']['step'], $this->_sections['data2']['iteration']++):
$this->_sections['data2']['rownum'] = $this->_sections['data2']['iteration'];
$this->_sections['data2']['index_prev'] = $this->_sections['data2']['index'] - $this->_sections['data2']['step'];
$this->_sections['data2']['index_next'] = $this->_sections['data2']['index'] + $this->_sections['data2']['step'];
$this->_sections['data2']['first']      = ($this->_sections['data2']['iteration'] == 1);
$this->_sections['data2']['last']       = ($this->_sections['data2']['iteration'] == $this->_sections['data2']['total']);
?>
			<a class="sublink" href="<?php echo $this->_tpl_vars['content']['sub'][$this->_tpl_vars['active_tab']][$this->_sections['data2']['index']]['URL']; ?>
"
				<?php if ($this->_tpl_vars['content']['sub'][$this->_tpl_vars['active_tab']][$this->_sections['data2']['index']]['TARGET']): ?>
				target="<?php echo $this->_tpl_vars['content']['sub'][$this->_tpl_vars['active_tab']][$this->_sections['data2']['index']]['TARGET']; ?>
"
				<?php endif; ?>
				alt="<?php echo $this->_tpl_vars['content']['sub'][$this->_tpl_vars['active_tab']][$this->_sections['data2']['index']]['NAME']; ?>
"
				title="<?php echo $this->_tpl_vars['content']['sub'][$this->_tpl_vars['active_tab']][$this->_sections['data2']['index']]['NAME']; ?>
"
			><?php echo $this->_tpl_vars['content']['sub'][$this->_tpl_vars['active_tab']][$this->_sections['data2']['index']]['NAME']; ?>
</a>&nbsp;|&nbsp;
			<?php endfor; endif; ?>
    	</td>
  </tr>
  <tr>
    	<td class="infoBox">&nbsp;</td>
  </tr>
</table>