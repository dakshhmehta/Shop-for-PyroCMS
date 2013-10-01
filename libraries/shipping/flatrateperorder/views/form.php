<ul>	
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label>Amount</label>
		<div class="input">
			<?php echo form_input('options[amount]', set_value('options[amount]', $options['amount'])); ?>
		</div>
	</li>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label>Handling</label>
		<div class="input">
			<?php echo form_input('options[handling]', set_value('options[handling]', $options['handling'])); ?>
		</div>
	</li>		
</ul>