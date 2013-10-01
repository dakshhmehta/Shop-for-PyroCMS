<ul>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label>Height</label>
		<div class="input">
			   <?php echo $package_type->height; ?>
		</div>
	</li>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label>Width</label>
		<div class="input">
			<?php echo $package_type->width; ?>
		</div>
	</li>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label>Depth</label>
		<div class="input">
			<?php echo $package_type->depth; ?>
		</div>
	</li>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label>Max Weight</label>
		<div class="input">
			<?php echo $package_type->max_weight; ?>
		</div>
	</li>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label>Max Units<span>*</span></label>
		<div class="input">
			<?php echo form_input('options[max_units]', set_value('options[max_units]', $options['max_units'])); ?>
		</div>
	</li>		  
</ul>