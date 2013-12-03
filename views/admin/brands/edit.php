<section class="title">
	<?php if (isset($id) AND $id > 0): ?>
		<h4><?php echo sprintf(lang('shop:brands:edit'), $name); ?></h4>
	<?php else: ?>
		<h4><?php echo lang('shop:brands:new'); ?></h4>
	<?php endif; ?>
</section>

<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
<?php if (isset($id) AND $id > 0): ?>
	<?php echo form_hidden('id', $id); ?>
	<input type="hidden" name="bid" id="bid" value="<?php echo $id; ?>" > 
<?php endif; ?>
<section class="item form_inputs">
	<div  class="content">
		<fieldset>
			<ul>
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="name"><?php echo lang('shop:brands:name'); ?> <span>*</span></label>
					<div class="input">
						<?php echo form_input('name', set_value('name', $name), 'id="name" '); ?>
					</div>
				</li>
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="slug"><?php echo lang('shop:brands:slug'); ?> <span>*</span></label>
					<div class="input"><?php echo form_input('slug', set_value('slug', $slug)); ?></div>
				</li>			  
				<li>
					<label><?php echo lang('shop:brands:image'); ?></label>
					<div id='cover_img' name='cover_img'>
					 <?php if ($image_id > 0) 
					 	{
					 		echo '<img src="'.site_url().'files/thumb/'.$image_id.'/100/100">'; 
					 	}
					 	?>

					</div>   
					<input type="hidden" value="<?php echo $image_id; ?>" name="image_id" />
				</li>	
				<li>
					<label><?php echo lang('shop:brands:change_image'); ?></label>
					 <?php echo form_dropdown('folder_id', $folders, $folder_id, 'id="folder_id"'); ?>	   
				</li>																	
				<li>
						<label></label>
						<?php echo "<a href='#' id='load_folder' name='load_folder' style='display:none;'>Load</a>"; ?>

						<div id='img_view' style="overflow-y:scroll;min-height:50px;max-height:300px;">
								<!-- This is where the response from search folder images goes -->
						</div>		
				</li>									
													   
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="cover">
						<?php echo lang('shop:brands:description'); ?>
					</label>			
					<div class="input">
							<?php echo form_textarea('notes', set_value('notes', isset($notes)?$notes:""), 'class="wysiwyg-simple"'); ?>
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