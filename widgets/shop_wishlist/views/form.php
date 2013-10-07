<ol>
	<li class="even">
		<label><?php echo shop_lang('shop:admin:display_as');?></label>
		<?php echo form_dropdown('display', array('list' => 'List', 'blocks' => 'Blocks'), $options['display']); ?>
	</li>
	<li class="even">
		<label><?php echo shop_lang('shop:admin:limit');?></label>
		<?php echo form_input('limit', $options['limit']); ?>
	</li>
</ol>