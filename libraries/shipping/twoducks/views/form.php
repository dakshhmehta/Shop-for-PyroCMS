<ul>	
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:shipping:min_shipping_amount'); ?> </label>
		<div class="input">
			<?php echo form_input('options[shipping_min]', set_value('options[shipping_min]', $options['shipping_min'])); ?>
		</div>
	</li>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:shipping:max_shipping_amount'); ?> </label>
		<div class="input">
			<?php echo form_input('options[shipping_max]', set_value('options[shipping_max]', $options['shipping_max'])); ?>
		</div>
	</li>		
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:shipping:handling'); ?> </label>
		<div class="input">
			<?php echo form_input('options[handling]', set_value('options[handling]', $options['handling'])); ?>
		</div>
	</li>		
</ul>