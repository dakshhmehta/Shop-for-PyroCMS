<section class="title">

	<?php if (isset($id) AND $id > 0): ?>
		<h4><?php echo sprintf(lang('shop:common:edit'), $name); ?></h4>
	<?php else: ?>
		<h4><?php echo lang('shop:common:new'); ?></h4>
	<?php endif; ?>
	
</section>

<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
<?php if (isset($id) AND $id > 0): ?>
	<?php echo form_hidden('id', $id); ?>
<?php endif; ?>
<section class="item form_inputs">
	<div  class="content">
		<fieldset>
			<ul>
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="name"><?php echo lang('shop:common:name'); ?> <span>*</span></label>
					<div class="input">
						<?php echo form_input('name', set_value('name', $name), 'id="name" '); ?>
					</div>
				</li>
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="method"><?php echo lang('shop:blacklist:method'); ?> </label>
					<div class="input">
						<?php echo $method_select; ?> 
					</div>
				</li>  				
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="value"><?php echo lang('shop:common:value'); ?>  <span>*</span> - 
					<?php echo lang('shop:blacklist:value_description'); ?> 
					</label>
					<div class="input">
					<?php echo form_input('value', set_value('value', $value)); ?>
					</div>
				</li>				  
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="brand_id"><?php echo lang('shop:blacklist:enabled'); ?> <span></span>
						<small>
						</small>
					</label>
					<div class="input">
						<?php echo form_checkbox('enabled', 'enabled', set_value('enabled', $enabled)); ?> 
					</div>
				</li>
			</ul>
		</fieldset>
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
		</div>
	</div>
</section>
<?php echo form_close(); ?>