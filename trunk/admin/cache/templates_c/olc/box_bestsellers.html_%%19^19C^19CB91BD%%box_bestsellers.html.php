<?php /* Smarty version 2.6.18, created on 2007-10-10 13:48:34
         compiled from olc/boxes/box_bestsellers.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'olc_template_init', 'olc/boxes/box_bestsellers.html', 1, false),)), $this); ?>
<?php echo smarty_function_olc_template_init(array('use_template_language' => 'true','section' => 'boxes'), $this);?>

<?php if ($this->_tpl_vars['language'] == ''): ?>
<link rel="stylesheet" type="text/css" href="../stylesheet.css">
<?php endif; ?>
<?php 
if (!OL_COMMERCE)
{
	$sep='SHOW_MARQUEE';
	if (!$this->_tpl_vars[$sep])
	{
		$this->_tpl_vars[$sep]=SHOW_MARQUEE_WHATSNEW;
	}
}
$max_rows=max(1,$this->_tpl_vars['entries_count']);
$rows=min($max_rows,sizeof($this->_tpl_vars['box_content']));
$row=0;
$image=$this->_tpl_vars['tpl_path'].'img/img_box_sep_h.gif';
if (file_exists($image))
{
	$sep='<img src="'.$image.'" align="middle">';
}
else
{
	$sep='<hr/>';
}
 ?>
<table width="100%" class="<?php echo $this->_tpl_vars['box_navigation_area']; ?>
 box_BESTSELLERS" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><h3><?php echo $this->_config[0]['vars']['heading_best_sellers']; ?>
</h3></td>
	</tr>
	<tr>
		<td align="left" class="infoBox" valign="top">
			<?php if ($this->_tpl_vars['SHOW_MARQUEE']): ?>
			<div align="center"><span style="font-size:10px"><?php echo $this->_config[0]['vars']['marquee_stop']; ?>
<br/><br/></span></div>
			<MARQUEE behavior= "scroll" direction= "up" class="scroll_marquee" scrollamount= "2" scrolldelay= "70"
				onmouseover='this.stop()' onmouseout='this.start()'>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<?php $_from = $this->_tpl_vars['box_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['box_data']):
        $this->_foreach['aussen']['iteration']++;
?>
					<tr>
						<td class="infoBoxContent" align="left">
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td align="left" valign="top">
							    	<img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/img/bullet_c.gif" alt=""/>
									</td>
									<td align="left" valign="top">
							    	<a href="<?php echo $this->_tpl_vars['box_data']['LINK']; ?>
"><span class="box_entry_name"><?php echo $this->_tpl_vars['box_data']['NAME']; ?>
</span></a><br/><br/>
									</td>
								</tr>
							</table>
				    	<div style="padding-left:15px">
					      <?php if ($this->_tpl_vars['box_data']['IMAGE'] != ''): ?>
					      <a href="<?php echo $this->_tpl_vars['box_data']['LINK']; ?>
">
					      	<span class="box_image"><?php echo $this->_tpl_vars['box_data']['IMAGE']; ?>
</span>
						    </a>
				      	<?php if ($this->_tpl_vars['OL_COMMERCE']): ?>
				      	<span class="list_entry_products_vpe">
								<br /><?php echo $this->_tpl_vars['box_data']['PICTURE_DISCLAIMER']; ?>

								<?php if ($this->_tpl_vars['box_data']['VPE']): ?>
								<br /><?php echo $this->_tpl_vars['box_data']['VPE']; ?>

								<?php endif; ?>
								<br />
								</span>
				      	<?php endif; ?>
						    <br/>
					      <?php endif; ?>
					      <?php if ($this->_tpl_vars['box_data']['SHORT_DESCRIPTION']): ?>
					      <span class="box_entry_description"><?php echo $this->_tpl_vars['box_data']['SHORT_DESCRIPTION']; ?>
</span>
					      <?php endif; ?>
					      <br /><br />
					  		<span class="price_list"><?php echo $this->_config[0]['vars']['text_only']; ?>
<?php echo $this->_tpl_vars['box_data']['PRICE']; ?>
</span><br />
								<?php if ($this->_tpl_vars['box_data']['VPE']): ?>
				      	<?php if (! $this->_tpl_vars['OL_COMMERCE']): ?>
								<span class="list_entry_products_vpe"><?php echo $this->_tpl_vars['box_data']['VPE']; ?>
</span><br />
								<?php endif; ?>
					    	<?php endif; ?>
								<span class="list_entry_price_disclaimer">
									<?php echo $this->_tpl_vars['box_data']['TAX_INFO']; ?>
<?php if ($this->_tpl_vars['OL_COMMERCE']): ?><?php echo $this->_config[0]['vars']['price_disclaimer_box']; ?>
<?php endif; ?>
								</span>
					    	<?php if ($this->_tpl_vars['box_data']['DATE_AVAILABLE']): ?>
					    	<br/><span class="availabilityAnnouncement"><?php echo $this->_tpl_vars['box_data']['DATE_AVAILABLE']; ?>
</span>
					    	<?php endif; ?>
							</div>
						</td>
					</tr>
					<?php 
					$row++;
					if ($row<$rows)
					{
						echo '
					<tr>
						<td class="box_sep_h">'.$sep.'</td>
					</tr>
';
					}
					else
					{
						break;
					}
					 ?>
					<?php endforeach; endif; unset($_from); ?>
				</table>
			</MARQUEE>
			<?php else: ?>
			<?php $this->assign('lfd', '1'); ?>
			<table border="0" cellspacing="2" cellpadding="0" align="left">
				<?php $_from = $this->_tpl_vars['box_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['data']):
        $this->_foreach['aussen']['iteration']++;
?>
				<tr>
					<td class="main" valign="top" align="right"><?php echo $this->_tpl_vars['lfd']; ?>
. </td>
					<td class="main" valign="middle" align="center">
						<img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
img/bullet.gif" border="0" alt="" width="9" height="9" align="absmiddle">
					</td>
					<td class="main" valign="top">
						<a href="<?php echo $this->_tpl_vars['data']['LINK']; ?>
"><?php echo $this->_tpl_vars['data']['NAME']; ?>
</a>
					</td>
				</tr>
				<?php $this->assign('lfd', $this->_tpl_vars['lfd']+1); ?>
				<?php endforeach; endif; unset($_from); ?>
			</table>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td class="infoBoxFooter">&nbsp;</td>
	</tr>
</table>