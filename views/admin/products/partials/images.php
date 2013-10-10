				

				<fieldset>
					<ul>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="folder">

								<?php echo shop_lang('shop:products:import_image'); ?>
								<span>*</span> 
								<br />
								<small>
									<?php echo shop_lang('shop:products:import_image_description'); ?>
								</small>
							</label>
							<div class="input">
								<?php echo form_dropdown('folder_id', $folders, $folder_id, 'id="folder_id"'); ?>
								
								<?php echo "<a href='#' id='load_folder' name='load_folder' style='display:none;'>Load</a>";  ?>

										<div id='img_view' style="overflow-y:scroll;min-height:50px;max-height:300px;">
											<!-- This is where the response from search folder images goes -->
										</div>
										<div id='img_actions' style="margin-top:12px">
											<!-- This is where the submit button to save the gallery goes -->
											<a href='#' class="btn orange"  id='btn_select_all_images'><?php echo shop_lang('shop:products:select_all'); ?></a> 
											<a href='#' class="btn orange"  id='btn_select_none_images'><?php echo shop_lang('shop:products:select_none'); ?></a> 
											<a href='#' class="btn green"  id='btn_add_images' pid='<?php echo $id; ?>'><?php echo shop_lang('shop:products:add_to_gallery'); ?></a>
										</div>	
	  
							</div>
						</li>				
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="">
								<?php echo shop_lang('shop:products:gallery_images'); ?>
								<span></span>
								<br />
								<small><?php echo shop_lang('shop:products:gallery_images_description'); ?></small>
							</label>
							<div class="input">

								<div id="scrollable_images_panel">
									<?php 
									
										if ($images) 
										{
											foreach ($images as $image) 
											{
													
												$dom_id = 'img_id_'.$image->file_id;
												$rem = shop_lang('shop:products:remove');
												$cov = shop_lang('shop:products:set_as_cover');

												echo "<div  class='tooltip-s container' id='$dom_id'>";
												echo "  <a title='$rem' class='img_icon img_delete remove_image gall_cover2' data-image='$image->file_id' data-parent='$dom_id'></a>";
												echo "  <a title='$cov' href='javascript:set_cover(\"$image->file_id\")'  class='tooltip-s img_icon img_home gall_cover3'></a>";
												echo "  <img title='$image->name' class='tooltip-s' src='".site_url()."files/thumb/$image->file_id/100/100'>";
												echo "</div>";
											}
										}
										?>
								</div>  
	

							</div>
						</li>

					</ul>
				</fieldset>
		
			<script>

			//will set in the db
			$('#btn_add_images').click(function() {
				
				imgs = $('input:checkbox[name="images"]:checked').map(function() { return this.value; }).get();
				
				// Get the product ID
				pid = $('#btn_add_images').attr('pid');
				
				var senddata = { images:imgs, product_id:pid  };

				
				$.post('shop/admin/products/gallery_add/', senddata )

				.done(function(data) 
				{

					var obj = jQuery.parseJSON(data);

					//Uncheck the boxes
					$('input:checkbox[name="images"]:checked').removeAttr("checked"); // uncheck the checkbox or radio
				
					//show the image action buttons	
					var current_images = $('#scrollable_images_panel').html();	

					
					for (var i = 0; i < obj.added.length; i++) {

						//Generate a unique (ish) id for jQ to remove the image when needed
						dom_id = 'js_img_id_' + obj.added[i];
						
						current_images += "<div class='tooltip-s container' id='" + dom_id + "'>";
						current_images += "  <a title='" + obj.name + "' class='img_icon img_delete remove_image gall_cover2' data-image='"+obj.added[i]+"' data-parent='" + dom_id + "'></a>"
						current_images += "  <a title='" + obj.name + "' href='javascript:set_cover(\""+obj.added[i]+"\")'  class='tooltip-s img_icon img_home gall_cover3'></a>";
						current_images += "  <img title='" + obj.name + "' class='tooltip-s' src='" + obj.url + "files/thumb/" + obj.added[i] + "/100/100'>";
						current_images += "</div>";
					}
					
					$('#scrollable_images_panel').html(current_images);	

				});
				
				return false;
			
			});	 

				$('#load_folder').click(function() {
					
					/* Get the values to send to the server */
					f_id = $('#folder_id').val();

					var senddata = { folder_id:f_id  };
					
					$.post('shop/admin/images/get_folder_contents', senddata )

					.done(function(data) 
					{
						var obj = jQuery.parseJSON(data);
						
						str = '';
						for (var i = 0; i < obj.length; i++) 
						{
							
							var imgObj = obj.content[i];


							str += "<div class='gall_container'>";
							str += "   <img class='tooltip-s' title='" + imgObj.name + "' src='" + obj.url + 'files/thumb/' + imgObj.id + "/100/100' alt='' style='float:left'>";
							str += "   <input type='checkbox'  class='gall_checkbox' name='images' id='images' value='" + imgObj.id + "' />";
							str += "</div>";
						}

						$('#img_view').html(str);
						
					});
					
					return false;
				
				});	
				
				$("#folder_id").chosen().change(function() {
					
					$('#load_folder').click();

				});

				//Check all images
				$('#btn_select_all_images').click(function() {
		            
		            $('input:checkbox[name=images]').attr('checked', true);
		            
					return false;

				}); 

				//Check all images
				$('#btn_select_none_images').click(function() {
		            
		            $('input:checkbox[name=images]').attr('checked', false);

					return false;

				});   



				//
		        //
		        // Remove image from gallery
		        //
		        //
				//$('.remove_image').click(function() {
				$(".remove_image").live('click', function(e)  {					
					

		            img = $(this).attr('data-image');
		            var parent = $(this).attr('data-parent');               /*get the parent container id - this is what we remove*/  
		            var pid = $("#static_product_id").attr('data-pid');     /*get the product id*/
		            

		            $.post('shop/admin/products/gallery_remove', { image:img, product_id:pid  } ).done(function(data) 
		            {			
		                var obj = jQuery.parseJSON(data);
		                
		                if (obj.status == 'success') 
		                {
		                    $('#' + parent).remove();
		                }

		            });
		            
					return false;
				
				});						
			</script>