

				<fieldset>
					<ul>
						<li>
							<label>
								<?php echo shop_lang('shop:products:attributes'); ?>
								<small>
									<?php echo shop_lang('shop:products:attributes_description'); ?>
								</small>
							</label>
							<div class="input">
							</div>
						</li>
					</ul>

					<hr />
					<ul>
						<li id="add_attrib">
							<label><?php echo shop_lang('shop:products:add_new_attribute'); ?></label>
							<div class="input">

								<?php echo form_input('add_attrib_label'); ?>
								<?php echo form_input('add_attrib_value'); ?>
								 <a class="button" id="add-property" >
										<?php echo shop_lang('shop:products:add'); ?>
								</a>

							</div>
						</li>
					</ul>


					<ul id="properties-list">
		
						<?php foreach ($properties_array as $atr): ?>
							<li id="item_<?php echo $atr->id; ?>">
								<label><?php echo $atr->name; ?></label>
								<div class="input">
									<?php echo $atr->value; ?>
									<a class="img_delete img_icon remove" data-id="<?php echo $atr->id;?>" data-row="item_<?php echo $atr->id; ?>"></a>
								</div>
							</li>
		
						<?php endforeach; ?>
					</ul>

				</fieldset>
	

	
			<script>
		//will set in the db
		$('#add-property').click(function() {
			
			var i = $("#static_product_id").attr('data-pid'); /*Get the product ID*/
			var n = $("input[name='add_attrib_label']").val();  /*need this to help remove from the UI*/
			var v =  $("input[name='add_attrib_value']").val();  /*need this to help remove from the UI*/
			var a = 'add'; /*data to send*/

			var senddata = { action:a, id:i, name:n, value:v };
			
			$.post('shop/admin/products/ajax_product_attributes', senddata )

			.done(function(data) 
			{
				var obj = jQuery.parseJSON(data);
				
				if(obj.status == 'success')
				{
					var content = build_li_attribute_html( n, v, obj.id);
					$('#properties-list').append(content);

					/*clear the values*/
					$("input[name='add_attrib_label']").val(''); 
					$("input[name='add_attrib_value']").val('');


				}
				else
				{
					alert(obj.status);
				}

			});
			
			return false;
		
		});	


        
		//will set in the db
		$('#properties-list .remove').live('click',function() {
		
			var item = $(this).attr('data-row'); /*need this to help remove from the UI*/
			var i = $(this).attr('data-id'); /*data to send*/
			var a = 'delete'; /*data to send*/

	
			var senddata = { action:a, id:i };

			$.post('shop/admin/products/ajax_product_attributes', senddata )

			.done(function(data) 
			{
				var obj = jQuery.parseJSON(data);
				
				if(obj.status == 'success')
				{
					$('#properties-list #' + item ).remove();

				}
				else
				{
					alert(obj.status);
				}
				
			});
			
			return false;
		
		});	
        


			</script>