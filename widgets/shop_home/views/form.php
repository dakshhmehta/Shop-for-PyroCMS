<ol>
	<li>
		<label><?php echo $fields[0]['label']; ?></label>
		<?php echo form_dropdown('show_products', array('no' => 'No', 'yes' => 'Yes'), $options['show_products']); ?>
	</li>
	<li class="even">
		<label><?php echo $fields[1]['label']; ?></label>
		<?php echo form_input('limit_products', $options['limit_products']); ?>
	</li>
	<li>
		<label><?php echo $fields[2]['label']; ?></label>
		<?php echo form_dropdown('show_featured', array('no' => 'No', 'yes' => 'Yes'), $options['show_featured']); ?>
	</li>
	<li class="even">
		<label><?php echo $fields[3]['label']; ?></label>
		<?php echo form_input('limit_featured', $options['limit_featured']); ?>
	</li>
	<li>
		<label><?php echo $fields[4]['label']; ?></label>
		<?php echo form_dropdown('show_bestsellers', array('no' => 'No', 'yes' => 'Yes'), $options['show_bestsellers']); ?>
	</li>
	<li class="even">
		<label><?php echo $fields[5]['label']; ?></label>
		<?php echo form_input('limit_bestsellers', $options['limit_bestsellers']); ?>
	</li>
	<li>
		<label><?php echo $fields[6]['label']; ?></label>
		<?php echo form_dropdown('widget_theme', array('default' => 'Default'), $options['widget_theme']); ?>
	</li>
	<li class="even">
		<label><?php echo $fields[7]['label']; ?></label>
		<?php echo form_input('page_url', $options['page_url'], 'style="width: 80%;"'); ?>
	</li>
</ol>