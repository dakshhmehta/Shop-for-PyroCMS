<ul>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:packages:height'); ?> </label>
		<div class="input">
			   <?php echo $package_type->height; ?>
		</div>
	</li>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:packages:width'); ?> </label>
		<div class="input">
			<?php echo $package_type->width; ?>
		</div>
	</li>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:packages:depth'); ?> </label>
		<div class="input">
			<?php echo $package_type->depth; ?>
		</div>
	</li>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:packages:max_height'); ?> </label>
		<div class="input">
			<?php echo $package_type->max_weight; ?>
		</div>
	</li>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:packages:max_units'); ?> <span>*</span></label>
		<div class="input">
			<?php echo form_input('options[max_units]', set_value('options[max_units]', $options['max_units'])); ?>
		</div>
	</li>		  
</ul>