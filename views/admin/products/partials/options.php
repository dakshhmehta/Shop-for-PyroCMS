
				<fieldset>
					<ul id="options-list">
						<li id="all_options_list">
							<label>
								<?php echo shop_lang('shop:products:options'); ?>
								<small>
									<?php echo shop_lang('shop:products:options_description'); ?>
								</small>
							</label>						
							<div class="input">
								<label>
									
									<small>
										
									</small>
								</label>						
							</div>
						</li>	
			
							<?php foreach ($prod_options as $option): ?>
							
								<li id="option_assign_<?php echo $option->id; ?>">
									<label></label>        
									<div class="input" style="border:1px solid #eee;padding:10px;">
										<span style="padding:5px;">
											<a target="_new" href="admin/shop/options/edit/<?php echo $option->option_id; ?>" class="img_edit img_icon"></a> 
										</span>									
										<span>
											<?php echo get_option_name($option->option_id); ?>  
										</span>     
										<span id="OptionButtons" style="float:right">
											<a href="#" class="img_up img_icon" data-option-id="<?php echo $option->id; ?>"></a>
											<a href="#" class="img_down img_icon" data-option-id="<?php echo $option->id; ?>"></a>
											<a href="#" class="img_delete img_icon remove" data-option-id="<?php echo $option->id; ?>"></a>
										</span>
									</div>
								</li>
						
							<?php endforeach; ?>
					</ul>

					<ul style="background:rgb(230,245,250);padding:10px;border-radius:10px;width:90%">
						<li id="all_options_list">
							<label>
								<?php echo shop_lang('shop:products:new_option'); ?>
								<small>
									<?php echo shop_lang('shop:products:new_option_description'); ?>
								</small>
							</label>						
							<div class="input">
								<label>
									 <?php echo $all_options; ?>
									<small>
										 <a class="tooltip-s img_icon img_create" id="add-option" title="<?php echo shop_lang('shop:products:add'); ?>" ></a>
									</small>
								</label>						
							</div>
						</li>	
					</ul>
				</fieldset>
	


				<script>
        
        /* Create Option Assignment
         *
         * Creates a new assignment
         * Returns the new id and creates the new html to inject in the DOM
         *
         */
		$('#add-option').click(function() {
        
			//var length = $("#options-list li").length;
            
            var product_id = $("#static_product_id").attr('data-pid');
            //get the current option value/id
            var o_id = $("select[name=option_id]").val();
            
            //make sure something is selected
            if (o_id == 0) { alert('Please select an option'); return false; }
            
            
            var key = "select[name=option_id] option[value='" + o_id + "']";
            
            //Name for the display
            var option_name = $(key).text();
            
            postto = "admin/shop/options/product_option/";
            
            $.post(postto, {p:product_id , o:o_id, a:'add'} ).done(function(data) 
            {			
                var obj = jQuery.parseJSON(data);
                
                if (obj.status == 'success') 
                {
                    
                    var content = build_li_option_html( obj.assign_id,  option_name);
                    
                    $('#options-list').append(content);
                    
                }

            });
                

			return false;
            
		});	 
        
        
        
        /* Delete Option Assignment
         *
         *
         * Call delete of product option assignment
         * Delete via ajax and update(remove) from list
         *
         *
         */
		$('#options-list .remove').live('click', function(e) {
        
	
			var option_id = $(this).attr('data-option-id');

            
            postto = "admin/shop/options/product_option/";

			var test = confirm('Please confirm action');
            
			if (test) {
             
                $.post(postto, {o:option_id,a:'delete'} ).done(function(data) 
                {			
                    var obj = jQuery.parseJSON(data);
                    
                    if (obj.status == 'success') 
                    {
                        // remove from list (UI)
                        $('#option_assign_'+option_id).remove();
                    }

                });
            
				
			}
			return false;
		});
        
        
        
        //Move Up
		$('#OptionButtons .img_up').live('click', function(e) {
			
            // move_option(  PROD_OPTION_ID  , DIRECTION );
            move_option(  $(this).attr('data-option-id')  , 'up' );
            
			return false;
            
		});
        
        //Move Down
		$('#OptionButtons .img_down').live('click', function(e) {

            // move_option(  PROD_OPTION_ID  , DIRECTION );
            move_option(  $(this).attr('data-option-id')  , 'down' );
            
			return false;
            
		});

				</script>