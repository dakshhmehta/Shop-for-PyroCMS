

				<fieldset>
					<ul>
						<li id="all_related_list">
							<label>
								<?php echo shop_lang('shop:products:related_products'); ?>
								<small>
									<?php echo shop_lang('shop:products:related_products_description'); ?>
								</small>
							</label>						
						</li>	

					</ul>
					<ul id="related-list">


 								<?php

 									foreach ($rel_names as $key => $_related) 
 									{
 										echo "<li>".$_related->id. ' ' . $_related->name .  "<input type='hidden' value='" . $_related->id . "' name='related[]'></li>";
 									}


 								?>
							

					</ul>
					<ul style="width:400px;">
						<li>
							<label><?php echo shop_lang('shop:products:search_for_products'); ?> </label>
							<div class="form_input">
								
								<?php echo form_input('related_filter') ?> 
								<a id="related_search_btn" class="btn green">
									<?php echo shop_lang('shop:products:search'); ?>
								</a>
							</div>

						</li>
						<li style="background:rgb(230,245,250);padding:10px;border-radius:10px;width:90%">
							<label><?php echo shop_lang('shop:products:search_results'); ?></label>
							<div class="form_input">

							</div>
							
						</li>						
					</ul>

					<ul id="related-search-results" style="width:400px;">
							

					</ul>

				</fieldset>
	

				<script>



				function add_related_id(id)
				{
 					

 					content = "<li>" + id +
 								"" + 
 								"<input type='hidden' name='related[]' value='" + id + "' > " +
 								"" +
 								"" +
 								"</li>";

 					$('#related-list').append(content);
				}



				$("#related_search_btn").on('click', function(e)  {

					var search_term = $('input[name="related_filter"]').val();

					var postto = "admin/shop/products/ajax_find_product/";

					//now search the api
	 				$.post(postto, {term:search_term} ).done(function(data) 
	                {			
	                    var obj = jQuery.parseJSON(data);
	                    
	                    if (obj.status == 'success') 
	                    {

							$('#related-search-results').find('li').remove().end();

	
	                        for(i=0;i< obj.results.length;i++)
	                        {

	                        	content = "<li>" + obj.results[i].id + " - " + obj.results[i].name + " <a href='javascript:add_related_id("+ obj.results[i].id +");' style='float:right' class='related_results img_icon img_create'></a></li>";

	          
	                  			$('#related-search-results').append(content);
			
						
	                        }

	                    }
	                    else
	                    {
	                    	alert('Something went wrong');
	                    }

	                });

					return false;
				}); 


				

					//$("#related_results").trigger("chosen:updated");


				</script>