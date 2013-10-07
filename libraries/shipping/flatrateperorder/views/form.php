<ul>	
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:shipping:amount'); ?> </label>
		<div class="input">
			<?php echo form_input('options[amount]', set_value('options[amount]', $options['amount'])); ?>
		</div>
	</li>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:shipping:handling'); ?> </label>
		<div class="input">
			<?php echo form_input('options[handling]', set_value('options[handling]', $options['handling'])); ?>
		</div>
	</li>		
</ul>