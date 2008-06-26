<?php /* Smarty version 2.6.18, created on 2007-10-10 13:48:34
         compiled from olc/boxes/box_specials_whatsnew.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'olc_template_init', 'olc/boxes/box_specials_whatsnew.html', 1, false),)), $this); ?>
<?php echo smarty_function_olc_template_init(array('use_template_language' => 'true','section' => 'boxes'), $this);?>

<?php 
if (!OL_COMMERCE)
{
	$sep='SHOW_MARQUEE';
	if (!$this->_tpl_vars[$sep])
	{
		$this->_tpl_vars[$sep]=$show_marquee;
	}
	$sep='module_content';
	if (!$this->_tpl_vars[$sep])
	{
		$this->_tpl_vars[$sep]=$this->_tpl_vars['box_content'];
	}
}
$this->_tpl_vars['header_text']=$this->_config[0]['vars'][$this->_tpl_vars['heading_var']];
$this->_tpl_vars['box_name']=$box_name;

$max_rows=max(1,$this->_tpl_vars['entries_count']);
$rows=min($max_rows,sizeof($this->_tpl_vars['module_content']));
$row=0;
$image=$this->_tpl_vars['tpl_path'].'images/images_box_sep_h.gif';
if (file_exists($image))
{
	$sep='<img src="'.$image.'" align="middle">';
}
else
{
	$sep='<hr/>';
}
 ?>
<?php if ($this->_tpl_vars['language'] == ''): ?>
<link rel="stylesheet" type="text/css" href="../stylesheet.css">
<?php endif; ?>
<table class="<?php echo $this->_tpl_vars['box_navigation_area']; ?>
 <?php echo $this->_tpl_vars['box_name']; ?>
" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h3><?php echo $this->_tpl_vars['header_text']; ?>
</h3></td>
  </tr>
  <tr>
	<td align="left" class="infoBox" valign="top">
		<?php if ($this->_tpl_vars['SHOW_MARQUEE']): ?>
		<div align="center"><span style="font-size:10px"><?php echo $this->_config[0]['vars']['marquee_stop']; ?>
<br/><br/></span></div>
		<MARQUEE behavior= "scroll" direction= "up" class="scroll_marquee" scrollamount= "2" scrolldelay= "70"
			onmouseover='this.stop()' onmouseout='this.start()'>
		<?php endif; ?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<?php $_from = $this->_tpl_vars['module_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['box_data']):
?>
				<tr>
					<td class="infoBoxContents" align="left">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" valign="top">
						    	<img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/bullet_c.gif" alt=""/>
								</td>
								<td align="left" valign="top">
						    	<a href="<?php echo $this->_tpl_vars['box_data']['PRODUCTS_LINK']; ?>
"><span class="box_entry_name"><?php echo $this->_tpl_vars['box_data']['PRODUCTS_NAME']; ?>
</span></a>
								</td>
							</tr>
						</table>
			    	<br /><br />
			    	<div style="padding-left:15px">
				      <?php if ($this->_tpl_vars['box_data']['PRODUCTS_IMAGE'] != ''): ?>
				      <a href="<?php echo $this->_tpl_vars['box_data']['PRODUCTS_PRODUCTS_LINK']; ?>
">
				      	<span class="box_image"><?php echo $this->_tpl_vars['box_data']['PRODUCTS_IMAGE']; ?>
</span>
					    </a>
			      	<?php if ($this->_tpl_vars['OL_COMMERCE']): ?>
			      	<span class="list_entry_products_vpe">
							<br /><?php echo $this->_tpl_vars['box_data']['PICTURE_DISCLAIMER']; ?>

							<?php if ($this->_tpl_vars['box_data']['PRODUCTS_VPE']): ?>
							<br /><?php echo $this->_tpl_vars['box_data']['PRODUCTS_VPE']; ?>

							<?php endif; ?>
							<br />
							</span>
			      	<?php endif; ?>
					    <br/>
				      <?php endif; ?>
				      <?php if ($this->_tpl_vars['box_data']['PRODUCTS_SHORT_DESCRIPTION']): ?>
				      <span class="box_entry_description"><?php echo $this->_tpl_vars['box_data']['PRODUCTS_SHORT_DESCRIPTION']; ?>
</span>
				      <?php endif; ?>
				      <br/><br/>
				  		<span class="price_list"><?php echo $this->_config[0]['vars']['text_only']; ?>
<?php echo $this->_tpl_vars['box_data']['PRODUCTS_PRICE']; ?>
</span><br />
							<?php if ($this->_tpl_vars['box_data']['PRODUCTS_VPE']): ?>
			      	<?php if (! $this->_tpl_vars['OL_COMMERCE']): ?>
							<span class="list_entry_products_vpe"><?php echo $this->_tpl_vars['box_data']['PRODUCTS_VPE']; ?>
</span><br />
							<?php endif; ?>
				    	<?php endif; ?>
							<span class="list_entry_price_disclaimer">
								<?php if ($this->_tpl_vars['OL_COMMERCE']): ?>
								<?php echo $this->_tpl_vars['box_data']['PRICE_DISCLAIMER']; ?>

								<?php else: ?>
								<?php echo $this->_tpl_vars['box_data']['PRODUCTS_TAX_INFO']; ?>
<?php echo $this->_config[0]['vars']['price_disclaimer_box']; ?>

								<?php endif; ?>
							</span>
				    	<?php if ($this->_tpl_vars['box_data']['PRODUCTS_DATE_AVAILABLE']): ?>
				    	<br/><span class="availabilityAnnouncement"><?php echo $this->_tpl_vars['box_data']['PRODUCTS_DATE_AVAILABLE']; ?>
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
				<?php if (! $this->_tpl_vars['SHOW_MARQUEE']): ?>
				<?php if ($this->_tpl_vars['MORE_LINK']): ?>
			  <tr>
			    <td class="infoBoxContents" align="center">
			    	<br/>
						<?php if ($this->_tpl_vars['bullet']): ?><?php echo $this->_tpl_vars['bullet']; ?>
&nbsp<?php endif; ?>;
						<a href="<?php echo $this->_tpl_vars['MORE_LINK']; ?>
"
							title="<?php echo $this->_config[0]['vars']['text_more_products']; ?>
<?php echo $this->_tpl_vars['MORE_TYPE']; ?>
"><?php echo $this->_config[0]['vars']['text_more_products']; ?>
<?php echo $this->_tpl_vars['MORE_TYPE']; ?>
...</a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endif; ?>
			</table>
			<?php if ($this->_tpl_vars['SHOW_MARQUEE']): ?>
			</MARQUEE>
			<?php endif; ?>
		</td>
	</tr>
</table>
