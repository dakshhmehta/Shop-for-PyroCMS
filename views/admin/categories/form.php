<div class="one_half" id="">

<section class="title">
	<?php if (isset($id) AND $id > 0): ?>
		<h4><?php echo sprintf(lang('shop:common:edit'), $name); ?></h4>
	<?php else: ?>
		<h4><?php echo lang('shop:admin:new'); ?></h4>
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
					<label for="name"><?php echo lang('shop:common:name');?><span>*</span></label>
					<div class="input">
						<?php echo form_input('name', set_value('name', $name), 'id="name" '); ?>
					</div>
				</li>
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="slug"><?php echo lang('shop:common:slug');?><span>*</span></label>
					<div class="input"><?php echo form_input('slug', set_value('slug', $slug)); ?></div>
				</li>		
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="slug"><?php echo lang('shop:common:order');?><span>*</span></label>
					<div class="input"><?php echo form_input('order', set_value('order', $order)); ?></div>
				</li>				
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="slug"><?php echo lang('shop:categories:parent_category');?><span>*</span></label>
					<div class="input"><?php echo $parent_category_select; ?></div>
				</li>		
					  
				<li>
					<label><?php echo lang('shop:common:image');?></label>
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
					<label><?php echo lang('shop:categories:change_image');?></label><br />
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
					<label for="user_data"><?php echo lang('shop:admin:user_data');?><span></span></label>
					<div class="input">
						<?php echo form_input('user_data', set_value('user_data', $user_data)); ?><br />
						<a href="admin/shop/categories/ajax_update_child_data" class="cat_update_userdata_children btn orange"><?php echo lang('shop:admin:replicate_to_child_categories');?></a>
					</div>
				</li>								   
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="user_data"><?php echo lang('shop:common:description');?><span></span></label>		
					<div class="input">
							<?php echo form_textarea('description', set_value('description', isset($description)?$description:""), 'class="wysiwyg-simple"'); ?>
							<br />
							<a href="admin/shop/categories/ajax_update_child_data" class="cat_update_description_children btn orange"><?php echo lang('shop:admin:replicate_to_child_categories');?></a>
					</div>
				</li>   
			</ul>


		</fieldset>

		<div class="buttons">
				<button class="btn blue" value="save_exit" name="btnAction" type="submit">
					<span><?php echo lang('shop:products:save_and_exit');?></span>
				</button>	

				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save'))); ?>

				<a href="admin/shop/categories/" class="btn gray">Cancel</a>
		</div>

	</div>
</section>
<?php echo form_close(); ?>

</div>

<?php if( isset($id)): ?>



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
						$editlink = " <a href='admin/shop/categories/edit/"  .$child->id ."'>edit</a>";
						$dellink = " <a class='modal' href='admin/shop/categories/delete/"  .$child->id . "/1'>delete</a>";
						echo "<li class='li_sub_cat'><span class='li_sub_cat'>".$child->name."</span><span style='float:right'>".$editlink.$dellink."</span></li>";
					}

				?>
		</ul>	

	</div>
</section>
<?php endif; ?>

</div>
<style>
li.li_sub_cat {
	border-radius: 4px;

	border:1px solid #ddd;

	padding:5px;
	height:21px;
	line-height:21px;

	margin-top:5px;

}
span.li_sub_cat {

	color:#999;
	padding:5px;
	height:21px;
	line-height:21px;

}
</style>

<script>






	$(".cat_update_userdata_children").on('click', function(e)  
	{					
		postto =  $(this).attr('href');
		parentid =  $('#cid').val();
		val =  $('input[name="user_data"]').val();
		fld = 'user_data';


	    $.post( postto, { parent_id:parentid, field:fld, value:val  } ).done(function(data) 
	    {			
	        var obj = jQuery.parseJSON(data);
	        
	        if (obj.status == 'success') 
	        {
	            alert(obj.message);
	            
	        }
	        else
	        {
	        	alert(obj.status);
	        }

	    });


		return false;
	
	});	


	$(".cat_update_description_children").on('click', function(e)  
	{		
		postto =  $(this).attr('href');
		parentid =  $('#cid').val();
		val =  $('textarea[name="description"]').val();
		fld = 'description';


	    $.post( postto, { parent_id:parentid, field:fld, value:val  } ).done(function(data) 
	    {			
	        var obj = jQuery.parseJSON(data);
	        
	        if (obj.status == 'success') 
	        {
	            alert(obj.message);
	            
	        }
	        else
	        {
	        	alert(obj.status);
	        }

	    });


		return false;
	
	});	




</script>