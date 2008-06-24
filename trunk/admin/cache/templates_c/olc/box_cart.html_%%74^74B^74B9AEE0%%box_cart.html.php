<?php /* Smarty version 2.6.18, created on 2007-10-10 13:48:34
         compiled from olc/boxes/box_cart.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'olc_template_init', 'olc/boxes/box_cart.html', 1, false),)), $this); ?>
<?php echo smarty_function_olc_template_init(array('use_template_language' => 'true','section' => 'boxes'), $this);?>

<table id="cart_content" width="100%" class="<?php echo $this->_tpl_vars['box_navigation_area']; ?>
 box_CART" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><h3><?php echo $this->_config[0]['vars']['heading_cart_box']; ?>
</h3></td>
	</tr>
	<?php if ($this->_tpl_vars['CONTENT']): ?>
	<tr>
		<td class="infoBox">
			<?php echo $this->_tpl_vars['BOX_CONTENT']; ?>

		</td>
	</tr>
	<?php else: ?>
	<?php if ($this->_tpl_vars['empty_cart']): ?>
	<tr>
    <td class="infoBox">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
			    <td class="infoBoxContents">
						<?php echo $this->_config[0]['vars']['text_empty_cart']; ?>

					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php else: ?>
	<tr>
		<td class="infoBox">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td id="activate_sticky_cart" width="100%" style="display:none;">
					</td>
				</tr>
				<?php if ($this->_tpl_vars['ITEMS']): ?>
				<tr>
					<td class="cartLine" width="100%">
						<span class="cart_items_short_header"><?php echo $this->_config[0]['vars']['cart_content']; ?>
</span><br/><br/>
						<span class="cart_items_short"><?php echo $this->_config[0]['vars']['articles_in_cart']; ?>
<span id="cart_items_short"><?php echo $this->_tpl_vars['ITEMS']; ?>
</span></span>
						<br/>
						<span class="cart_total_price_short"><?php echo $this->_config[0]['vars']['total_in_cart']; ?>
<span id="cart_total_price_short"><?php echo $this->_tpl_vars['TOTAL']; ?>
</span></span>
						<div align="right"><br/>
							<span class="list_entry_price_disclaimer">
							<?php if ($this->_tpl_vars['PRICE_DISCLAIMER']): ?><?php echo $this->_tpl_vars['PRICE_DISCLAIMER']; ?>
<?php else: ?><?php echo $this->_config[0]['vars']['price_disclaimer_in_cart']; ?>
<?php endif; ?>
							</span>
						</div>
						<br/>
					</td>
				</tr>
			</table>
			<?php if ($this->_tpl_vars['CART_BUTTONS']): ?>
			<?php echo $this->_tpl_vars['CART_BUTTONS']; ?>

			<?php endif; ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['SEND_PROTOTYPE']): ?>
	<!-- W . Kaiser - AJAX-->
	<!--
	Prototype for one cart-line!
	Can be used for complete local cart manipulation
	-->
	<tr id="cart_line_x" style="display:none">
		<td nowrap="nowrap" class="cartLine" width="25" valign="top">
			<!-- Needed for local cart manipulation to store important data-->
			<span id="products_id_x"></span>
			<span id="products_price_x"></span>
			<!-- Needed for local cart manipulation-->
			<font size="1">
				<span id="products_qty_x"></span>&nbsp;x&nbsp;
			</font>
		</td>
		<td nowrap="nowrap" class="infoBox" valign="top" >
			<font size="1">
				<a href="#link#"
					title="Produkt '#name#' ansehen">
					#name_short#
				</a>
			</font>
		</td>
	</tr>
	<!-- W . Kaiser - AJAX-->
	<?php endif; ?>
<?php endif; ?>
</table>