<ul>	
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo lang('shop:shipping:amount'); ?> </label>
		<div class="input">
			<?php echo form_input('options[amount]', set_value('options[amount]', $options['amount'])); ?>
		</div>
	</li>
	
</ul>