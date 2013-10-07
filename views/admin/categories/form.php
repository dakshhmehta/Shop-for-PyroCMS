<div class="one_half" id="">

<section class="title">
	<?php if (isset($id) AND $id > 0): ?>
		<h4><?php echo sprintf(shop_lang('shop:admin:edit'), $name); ?></h4>
	<?php else: ?>
		<h4><?php echo shop_lang('shop:admin:new'); ?></h4>
	<?php endif; ?>
</section>

<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
<?php if (isset($id) AND $id > 0): ?>
	<?php echo form_hidden('id', $id); ?>
	<input type="hidden" name="cid" id="cid" value="<?php echo $id; ?>" > 
<?php endif; ?>
<section class="item form_inputs">
	<div class="content">
	<fieldset>
		<ul>
			<li class="<?php echo alternator('even', ''); ?>">
				<label for="name"><?php echo shop_lang('shop:admin:name');?><span>*</span></label>
				<div class="input">
					<?php echo form_input('name', set_value('name', $name), 'id="name" '); ?>
				</div>
			</li>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="slug"><?php echo shop_lang('shop:admin:slug');?><span>*</span></label>
				<div class="input"><?php echo form_input('slug', set_value('slug', $slug)); ?></div>
			</li>		
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="slug"><?php echo shop_lang('shop:admin:order');?><span>*</span></label>
				<div class="input"><?php echo form_input('order', set_value('order', $order)); ?></div>
			</li>				
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="slug"><?php echo shop_lang('shop:categories:parent_category');?><span>*</span></label>
				<div class="input"><?php echo $parent_category_select; ?></div>
			</li>		
				  
			<li>
				<label>Image</label>
				<input type='hidden' value='' id='image_id' name='image_id' />
				<div id='cover_img' name='cover_img'>
				 <?php 	 if ($image_id > 0) 
						 {
						 	echo '<img src="'.site_url().'files/thumb/'.$image_id.'/100/100">'; 
						 }
						 else
						 {
						 	echo '<div style="height:100px;width:100px;" />'; 
						 }
						  
				 ?>
				</div>   
			</li>	
			<li>
				<label>Change Image</label><br />
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
					<?php echo lang('description'); ?>
				</label>			
				<div class="input">
						<?php echo form_textarea('description', set_value('description', isset($description)?$description:""), 'class="wysiwyg-simple"'); ?>
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

</div>

<?php if( isset($id) AND $parent_id == NULL || $parent_id == 0): ?>



<div class="one_half last" id="">

<section class="title" style="">
	
	<h4>Child Categories</h4>
	<h4 style="float:right"><a class='modal img_icon img_create' href='shop/admin/categories/addoption/<?php echo $id;?>'></a></h4>
	
</section>
<section class="item form_inputs">
	<div class="content">

		<ul>
				<?php

					foreach ($children as $child) 
					{
						$editlink = " - <a href='admin/shop/categories/edit/"  .$child->id ."'>edit</a>";
						$dellink = " -  <a class='modal' href='admin/shop/categories/delete/"  .$child->id . "/1'>delete</a>";
						echo "<li>".$child->name.$editlink.$dellink."</li>";
					}

				?>
		</ul>	

	</div>
</section>
<?php endif; ?>

</div>