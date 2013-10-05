<!--- FILE.START:VIEW.ADMIN.PRODUCTS.FORM --->
<section class="title">
	<!-- We'll use $this->method to switch between shop.create & shop.edit -->
	<?php $page_banner_title = ( $this->method == "edit")? $name  : ""; ?> 
	<h4> <?php  echo lang($this->method) . " " .$page_banner_title ." "; ?> </h4>
</section>
<section class="item">
	<div class="content">
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
	<div class="tabs">		
		<ul class="tab-menu">
			<li><a href="#product-tab"><span><?php echo lang('product'); ?></span></a></li>
			<li><a href="#description-tab"><span><?php echo lang('description'); ?></span></a></li>
			<li><a href="#price-tab"><span><?php echo lang('price'); ?></span></a></li>
		</ul>
		<div class="form_inputs" id="product-tab">
			<fieldset>
				<ul>
					<?php if ($id == null): ?>
					<?php else: ?>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="id"><?php echo lang('true_id'); ?> <span>*</span></label>
						<div class="input"><?php echo $id; ?></div>
					</li>			
					<?php endif; ?>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="name"><?php echo lang('name'); ?> <span>*</span></label>
						<div class="input"><?php echo form_input('name', set_value('name', $name)); ?></div>
					</li>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="slug"><?php echo lang('slug'); ?> <span>*</span></label>
						<div class="input"><?php echo form_input('slug', set_value('slug', $slug)); ?></div>
					</li>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="code"><?php echo lang('product_code'); ?> <span></span>
						<small>
						 <?php echo lang('product_code_desc'); ?>
						</small>
						</label>
						<div class="input"><?php echo form_input('code', set_value('code', $code)); ?></div>
					</li>					
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="category_id"><?php echo lang('category'); ?><span>*</span></label>
						<div class="input">
							<select name="category_id" id="category_id">
								<option value="0"><?php echo lang('global:select-pick'); ?></option>
								<?php echo $category_select; ?> 
							</select>
						</div>
					</li>
					
					<?php if (Settings::get('ss_enable_brands') == 1) :?>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="brand_id"><?php echo lang('brand'); ?></label>
						<div class="input">
							<?php echo $brand_select; ?> 
						</div>
					</li>	
					<?php endif; ?>
					
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="brand_id"><?php echo 'Package Type'; ?><span>*</span>
						<small>
						 You must select a package type for your product, this is required.
						</small>
						</label>
						<div class="input">
							<select name="pckg_id" id="pckg_id">
								<option value=""><?php echo lang('global:select-pick'); ?></option>
								<?php echo $package_select; ?> 
							</select>
						</div>
					</li>									 
				</ul>
			</fieldset>
		</div>
		<div class="form_inputs" id="description-tab">
			<fieldset>
				<div class="input">
						<?php echo form_textarea('description', set_value('description', $description), 'class="wysiwyg-simple"'); ?>
				</div>   
			</fieldset>
		</div>		
		<div class="form_inputs" id="price-tab">
		<fieldset>
			
			<ul>
				<li>
					<label for="price"><?php echo lang('set_new_price'); ?> 
						<span>*</span>
						<br />
							<small></small>
						</label>
					<div class="input">
						<div class=''>
								<?php echo ss_currency_symbol() . ' ' .  sf_text('price',$price); ?>
						</div>
					</div>
				</li>
				<li>
					<label for='autotax'><?php echo lang('tax'); ?> <span></span>
					<br />
					<small>
						<?php echo lang('apply_tax_desc'); ?>
					</small>
					</label>
					<div class="input">
					
						&nbsp; <?php echo form_dropdown('tax_id', sf_prep_taxes($tax_groups) ,$tax_id, "id='tax_id' ");?>
					</div>
				</li>					
				<li>
					<label for="tax_dir"><?php echo lang('tax_dir'); ?><span></span>
					<br />
					<small><?php echo lang('how_to_calc_price'); ?></small></label>
					<div class="input">
						&nbsp; <?php echo form_dropdown('tax_dir', array(0=>'Inclusive',1=>'Exclusive') ,$tax_dir, "id='tax_dir' ");?>
					</div>
				</li>		
				<li>
					<label for="price_base"><?php echo lang('price_base'); ?> <span></span><br />
						<small><?php echo lang('price_base_desc'); ?></small>
					</label>
					<div class="input">
						<div class=''>
								<?php echo ss_currency_symbol().' '.sf_text('price_base',$price_base);?>
						</div>
					</div>
				</li>					
				<li>
					<label for="rrp"><?php echo lang('rrp'); ?> <span></span><br />
						<small>This is the After TAX RRP value. It will be compared to the Price+Tax value</small>
					</label>
					<div class="input">
						<div class=''>
								<?php echo ss_currency_symbol().' '.sf_text('rrp',$rrp);?>
						</div>
					</div>
				</li>							
			</ul>
		</fieldset>			

		</div>				

	</div>
	
	<div class="buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
	</div>

	<?php echo form_close(); ?>
</div>
</section>
<!--- FILE.END:VIEW.ADMIN.PRODUCTS.FORM --->