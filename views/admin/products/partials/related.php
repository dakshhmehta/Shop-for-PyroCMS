

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
					<input type='hidden' value='d0n0tr3m0v3th1sf13ld' name='related[]'>
					<ul id="related-list">


					<?php

						//var_dump($rel_names);

						foreach ($rel_names as $key => $_related) 
						{
							$out_str = 	"<li><img src='files/thumb/$_related->cover_id/100/'>" ;
							$out_str .= " <a href='shop/product/".$_related->id."' target='_new_$_related->id' class=''>($_related->id)</a> | ";							
							$out_str .= $_related->name ;
							$out_str .= "<input type='hidden' value='" . $_related->id . "' name='related[]'> ";

							$out_str .= " <a href='shop/product/".$_related->id."' target='_new' class=''>view</a> | ";
							$out_str .= " <a href='#' class='remove_related_product'>remove</a>";

							$out_str .= "</li>";

							echo $out_str;
						}


					?>
							

					</ul>
					<ul style="width:400px;">

						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="related_products_category_filter"><?php echo shop_lang('shop:products:search_category'); ?> <span>*</span></label>
							<div class="input">
									<?php echo $category_select; ?> 
							</div>
						</li>
												
						<li>
							<label><?php echo shop_lang('shop:products:search_for_products'); ?> </label>
							<div class="form_input">
								
								<?php echo form_input('related_filter') ?> 
								<a id="related_search_btn" class="shopbutton button-rounded green">
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




				$(".remove_related_product").live('click', function(e)  {

					//$(this).remove();
					$(this).parent().remove();

					return false;
				}); 

				$("#related_search_btn").on('click', function(e)  {

					var search_term = $('input[name="related_filter"]').val();
					var cat = $('select[name="related_products_category_filter"]').val();

					var postto = "admin/shop/products/ajax_find_product/";

					//now search the api
	 				$.post(postto, {term:search_term,category:cat} ).done(function(data) 
	                {			
	                    var obj = jQuery.parseJSON(data);
	                    
	                    if (obj.status == 'success') 
	                    {

							$('#related-search-results').find('li').remove().end();

	
	                        for(i=0;i< obj.results.length;i++)
	                        {

	                        	content = 	"<li>"  + _js_create_img(obj.results[i].cover_id) + 
	                        	" " + obj.results[i].id + " - " + obj.results[i].name + 
	                        	"<a id='related_search_result_"+ obj.results[i].id + 
	                        	"' href='javascript:add_related_id("+obj.results[i].id + ");' style='float:right' class='related_results img_icon img_create' data-id='"+ obj.results[i].id + "' data-cover='"+ obj.results[i].cover_id + "' data-name='"+ obj.results[i].name  + "'></a></li>";

	          
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





				function _js_create_img(cover_id)
				{


					return "<img src='files/thumb/" + cover_id + "/100/' />";
				}


				function add_related_id(_id)
				{

					_id = "#" + "related_search_result_" + _id;
 					cover = $(_id).attr('data-cover');
 					name = $(_id).attr('data-name');
 					id = $(_id).attr('data-id');

 					content = "<li>" +
 								" <img src='files/thumb/"+cover+"/100'>" + 
 								" <input type='hidden' name='related[]' value='" + id + "' > " +
 								" " + id +
 								" " + name + 
								" <a href='#' class='remove_related_product'>remove</a> " +
 								"</li>";

 					$('#related-list').append(content);
				}



				</script>

