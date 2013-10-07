<ul>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:gateways:test_mode');?></label>
		<div class="input">
			<?php echo form_dropdown('options[test_mode]', array(TRUE => 'Yes', FALSE => 'No'), set_value('options[test_mode]', $options['test_mode'])); ?>
		</div>
	</li>

	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:gateways:username');?></label>
		<div class="input">
			<?php echo form_input('options[username]', set_value('options[username]', $options['username'])); ?>
		</div>
	</li>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:gateways:password');?></label>
		<div class="input">
			<?php echo form_input('options[password]', set_value('options[password]', $options['password'])); ?>
		</div>
	</li>
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:gateways:api_signature');?></label>
		<div class="input">
			<?php echo form_input('options[signature]', set_value('options[signature]', $options['signature'])); ?>
		</div>
	</li>
	
	<li class="<?php echo alternator('even', 'odd') ?>">
		<label><?php echo shop_lang('shop:gateways:auto_submit');?><small></small></label>
		<div class="input">
			<label><?php echo form_radio('options[auto]', 0, set_radio('options[auto]', 0, $options['auto'] == 0)); ?> No </label>
			<label><?php echo form_radio('options[auto]', 1, set_radio('options[auto]', 1, $options['auto'] == 1)); ?> Yes </label>
		</div>
	</li>
</ul>