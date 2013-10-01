<ol>
	<li class="even">
		<label>Display as</label>
		<?php echo form_dropdown('display', array('list' => 'List', 'blocks' => 'Blocks'), $options['display']); ?>
	</li>
	<li class="even">
		<label>Limit</label>
		<?php echo form_input('limit', $options['limit']); ?>
	</li>
</ol>