<section class="title">
	<h4>
	<?php echo lang('shop:packages:method_'. $this->method, 'method_'); ?>
	</h4>
</section>

<section class="item">
	<div class="content">
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>

	<?php echo form_hidden('id', $package_type->id); ?>

	<div class="form_inputs">

		<fieldset>
			<legend><?php echo lang('shop:packages:package_type'); ?></legend>
			<ul>		 
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="name"><?php echo lang('shop:packages:type'); ?><span></span></label>
					<div class="input"><?php echo $package_type->type; ?></div>
				</li>
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="name"><?php echo lang('shop:common:name'); ?> <span>*</span></label>
					<div class="input"><?php echo form_input('title', set_value('name', $package_type->title), 'class="width-15"'); ?></div>
				</li>
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="desc"><?php echo lang('shop:common:description'); ?><span></span></label>
					<div class="input"><?php echo $package_type->desc; ?></div>
				</li>
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="name"><?php echo lang('shop:packages:ignor_shipping_cost'); ?><span>*</span></label>
					<div class="input">
						<label><?php echo form_radio('options[ignor_shipping]', 0, set_radio('options[ignor_shipping]', 0, $options['ignor_shipping'] == 0)); ?> <?php echo lang('shop:common:no'); ?> </label>
						<label><?php echo form_radio('options[ignor_shipping]', 1, set_radio('options[ignor_shipping]', 1, $options['ignor_shipping'] == 1)); ?> <?php echo lang('shop:common:yes'); ?> </label>					
					</div>
				</li>				
			</ul>
		</fieldset>
		<fieldset>
			<legend></legend>
			<?php $this->load->file($package_type->form); ?>
		</fieldset>

	</div>

	<div class="buttons">
	
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
		
	</div>

	<?php echo form_close(); ?>
</div>
</section>