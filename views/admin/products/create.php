
<section class="title">
	<h4> <?php echo lang('shop:common:'. $this->method); ?>  </h4>
</section>

<section class="item">
		<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		<div class="tabs">		
			<ul class="tab-menu">
				<li><a href="#product-tab"><span> <?php echo lang('shop:common:product'); ?></span></a></li>
			</ul>
			<div class="form_inputs" id="product-tab">
				<ul>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="name"><?php echo lang('shop:common:name'); ?> <span>*</span>
							<small>
								<?php echo lang('shop:products:name_description'); ?>
							</small>
						</label>
						<div class="input" ><?php echo form_input('name', set_value('name', $name)); ?></div>
					</li>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="slug"><?php echo lang('shop:common:slug'); ?> <span>*</span>
							<small>
								<?php echo lang('shop:products:slug_description'); ?>
							</small>
						</label>
						<div class="input"><?php echo form_input('slug', set_value('slug', $slug)); ?></div>
					</li>
					<li>
						<label for="price"><?php echo lang('shop:common:price'); ?><span>*</span><br />
							<small><?php echo lang('shop:products:price_description'); ?></small>
						</label>
						<div class="input">
							<?php echo ss_currency_symbol().' '.sf_text('price',$price);?>
						</div>
					</li>					
					<li>
						<label for="price_base"><?php echo lang('shop:products:base_price'); ?> <span></span><br />
							<small><?php echo lang('shop:products:base_price_description'); ?></small>
						</label>
						<div class="input">
							<?php echo ss_currency_symbol().' '.sf_text('price_base',$price_base);?>
						</div>
					</li>
				</ul>
			</div>
		

		</div>
		
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
		</div>

		<?php echo form_close(); ?>
	</div>
</section>
