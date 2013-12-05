<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
<?php if (isset($id) AND $id > 0): ?>
	<?php echo form_hidden('id', $id); ?>
	<input type="hidden" name="oid" id="oid" value="<?php echo $id; ?>" > 
<?php endif; ?>


	<div class="content">
		<fieldset>
			<ul>
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="type">
						<?php echo lang('shop:options:type'); ?> 
						<span>*</span>
					</label>
					<div class="input">
						<?php echo $option_types; ?>
					</div>
				</li>				
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="name">
						<?php echo lang('shop:common:name'); ?> 
						<span>*</span>
						<small>
							<?php echo lang('shop:options:name_description'); ?> 
						</small>
					</label>
					<div class="input">
						<?php echo form_input('name', set_value('name', $name), 'id="name" '); ?>
					</div>
				</li>	
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="title">
						<?php echo lang('shop:options:title'); ?> 
						<span>*</span>
						<small>
							<?php echo lang('shop:options:title_description'); ?> 
						</small>
					</label>
					<div class="input">
						<?php echo form_input('title', set_value('title', $title), 'id="title" '); ?>
					</div>
				</li>	
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="description">
						<?php echo lang('shop:options:description'); ?> 
						<span></span>
					</label>
					<div class="input">
						<?php echo form_input('description', set_value('description', $description), 'id="description" '); ?>
					</div>
				</li>				
			
			</ul>
			
			
		<?php if (isset($id) AND $id > 0): ?>

		<a title='<?php echo lang('nc:admin:options'); ?>' class="tooltip-s modal img_icon img_create" href="<?php echo site_url('admin/shop/options/add/' . $id); ?>"> </a>
		
		<?php endif; ?>

		</fieldset>
		
		
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
		</div>

	</div>
	
<?php echo form_close(); ?>