<!--- FILE.START:VIEW.ADMIN.PRODUCTS.FORM -->
<section class="title">
	<!-- We'll use $this->method to switch between shop.create & shop.edit -->
	<?php $page_banner_title = ( $this->method == "edit")? $name  : ""; ?> 
	<h4> <?php  echo lang($this->method) . "<span id='title_product_name'> " .$page_banner_title ." "; ?> </span></h4>
	<input type="hidden" name="static_product_id" id="static_product_id" data-pid="<?php echo $id;?>" />
</section>
<section class="item">
	<div class="content">
		<fieldset>
			<div style="float:right;">
					<span style="float:none;">
					<ul>
						<li class="<?php echo alternator('', 'even'); ?>">
							<?php if ($public == 1):?>
							<a href="javascript:sell(<?php echo $id;?>)" class="tooltip-s img_icon img_visible " title="<?php echo lang('click_to_change');?>" status="1" pid="<?php echo $id;?>" id="sf_ss_<?php echo $id;?>"></a>	
							<?php else:?>
							<a href="javascript:sell(<?php echo $id;?>)" class="tooltip-s img_icon img_invisible "  title="<?php echo lang('click_to_change');?>" status="0" pid="<?php echo $id;?>" id="sf_ss_<?php echo $id;?>"></a>
							<?php endif;?>
						</li>  
						<li><?php echo anchor('shop/product/'.$slug, lang('view_as_cust') , 'target="_blank" class="nc_links modal"'); ?></li>				
						<li><?php echo anchor('admin/shop/products/view/'.$id, lang('view_as_admin') , 'target="_blank" class="nc_links modal"'); ?></li>
						
						<li class="<?php echo alternator('', 'even'); ?>">
								<?php echo anchor('admin/shop/products/delete/' . $id, lang('delete'), array('class'=>'confirm nc_links delete')); ?>
						</li>								   
					</ul>	
						</span>
			</div>	
			<div id="cover_container" class="input">
				<?php 
				if ( $cover_id == NULL )
				{
					$src = ''; /*put no image here*/
				}
				else
				{
					$src = site_url()."files/thumb/" . $cover_id . "/100";
				}
				
				echo "<div class='container'><img id='prod_cover' src='".$src."'>"; 
				echo "<a href='javascript:set_cover(0, 0)'  class='img_icon img_delete gall_cover'></a></div>";
				?>
			</div> 

		</fieldset>
		
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		<div class="tabs">		
			<ul class="tab-menu">
				<li><a href="#product-tab"><span><?php echo lang('product'); ?></span></a></li>
				<li><a href="#description-tab"><span><?php echo lang('description'); ?></span></a></li>
				<li><a href="#price-tab"><span><?php echo lang('price'); ?></span></a></li>
				<li><a href="#discounts-tab"><span><?php echo lang('discounts'); ?></span></a></li>
				<li><a href="#images-tab"><span><?php echo lang('images'); ?></span></a></li>
				<li><a href="#properties-tab"><span><?php echo lang('attributes'); ?></span></a></li>
				<li><a href="#userinput-tab"><span><?php echo lang('options'); ?></span></a></li>
				<li><a href="#inventory-tab"><span><?php echo lang('inventory'); ?></span></a></li>
				<li><a href="#seo-tab"><span><?php echo lang('seo'); ?></span></a></li>
			</ul>
			<div class="form_inputs" id="product-tab">
				<fieldset>
					<ul>
						<?php if ($id == null): ?>
						<?php else: ?>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="id"><?php echo lang('true_id'); ?> <span>*</span></label>
							<div class="input"><?php echo $id; ?></div>
						</li>			
						<?php endif; ?>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="name"><?php echo lang('name'); ?> <span>*</span>
								<small>
									<?php echo lang('product_name_desc_slug'); ?>
								</small>
							</label>
							<div class="input" ><?php echo form_input('name', set_value('name', $name)); ?></div>
						</li>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="slug"><?php echo lang('slug'); ?> <span>*</span>
								<small>
									<?php echo lang('slug_desc'); ?>
								</small>
							</label>
							<div class="input"><?php echo form_input('slug', set_value('slug', $slug)); ?></div>
						</li>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="code"><?php echo lang('product_code'); ?> <span></span>
							<small>
							 <?php echo lang('product_code_desc'); ?>
							</small>
							</label>
							<div class="input"><?php echo form_input('code', set_value('code', $code)); ?></div>
						</li>					
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="category_id"><?php echo lang('category'); ?> <span>*</span></label>
							<div class="input">
								<select name="category_id" id="category_id">
									<option value="0"><?php echo lang('global:select-pick'); ?></option>
									<?php echo $category_select; ?> 
								</select>
							</div>
						</li>
						
						<?php if (Settings::get('nc_enable_brands') == 1) :?>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="brand_id"><?php echo lang('brand'); ?></label>
							<div class="input">
								<?php echo $brand_select; ?> 
							</div>
						</li>	
						<?php endif; ?>
						
						<?php if(group_has_role('shop', 'advanced_products')): ?>

								<li class="<?php echo alternator('', 'even'); ?>">
									<label for="pgroup_id">
											<?php echo lang('nc:products:pgroup');?>
										<small>
										 <?php echo lang('nc:products:pgroup_desc'); ?>
										</small>						
									</label>
									<div class="input">
										<select name="pgroup_id" id="pgroup_id">
											<option value=""><?php echo lang('global:select-pick'); ?></option>
											<?php echo $group_select; ?> 
										</select>
									</div>
								</li>						
								
								<li class="<?php echo alternator('', 'even'); ?>">
									<label for="brand_id"><?php echo lang('package_type'); ?> <span>*</span>
										<small>
										 <?php echo lang('package_type_desc'); ?>
										</small>
									</label>
									<div class="input">
										<select name="pckg_id" id="pckg_id">
											<option value=""><?php echo lang('global:select-pick'); ?></option>
											<?php echo $package_select; ?> 
										</select>
									</div>
								</li>

						<?php else: ?>
							<?php echo form_hidden('pgroup_id',$pgroup_id); ?>
							<?php echo form_hidden('package_id',$package_id); ?>
						<?php endif; ?>


						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="brand_id"><?php echo lang('featured'); ?><span></span>
								<small>
								 <?php echo lang('featured_desc'); ?>
								</small>
							</label>
							<div class="input">
								<?php echo form_checkbox('featured', 'Featured', set_value('featured', $featured)); ?> 
							</div>
						</li>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="brand_id">Searchable<span></span>
								<small>
								 If you uncheck this the product is still available to purchase but will not be searchable or display in any list.
								 You will have to manually create its page.
								</small>
							</label>
							<div class="input">
								<?php echo form_checkbox('searchable', 'searchable', set_value('searchable', $searchable)); ?> 
							</div>
						</li>

						
					</ul>
				</fieldset>
			</div>
			<div class="form_inputs" id="description-tab">
				<fieldset>	
					<ul>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for=""><?php echo lang('description'); ?><span></span>
								<small>
								 <?php echo lang('product_description_desc'); ?>
								</small>
							</label>
						</li>
						<li class="<?php echo alternator('', 'even'); ?>">
							<div class="">
								<?php echo form_textarea('description', set_value('description', $description), 'class="wysiwyg-simple"'); ?> 
							</div>
						</li>					
					</ul>			
					   
					
				</fieldset>

			</div>		
			<div class="form_inputs" id="price-tab">
			<fieldset>
				<ul>
					<li>
						<label for="price"><?php echo lang('set_new_price'); ?> <span>*</span><br />
							<small></small>
						</label>
						<div class="input">
							<?php echo nc_currency_symbol().' '.sf_text('price',$price);?>
						</div>
					</li>
					<li>
						<label for="autotax"><?php echo lang('tax'); ?> <span></span>
						<br />
						<small><?php echo lang('apply_tax_desc'); ?></small></label>
						<div class="input">
							<?php echo form_dropdown('tax_id', sf_prep_taxes($tax_groups) ,$tax_id, "id='tax_id' ");?>
						</div>
					</li>					
					<li>
						<label for="autotax"><?php echo lang('tax_dir'); ?><span></span>
						<br />
						<small><?php echo lang('tax_dir_desc'); ?></small></label>
						<div class="input">
							<?php echo form_dropdown('tax_dir', array(0=>lang('inclusive'),1=>lang('exclusive')) ,$tax_dir, "id='tax_dir' ");?>
						</div>
					</li>	
					<li>
						<label for="price_base"><?php echo lang('price_base'); ?> <span></span><br />
							<small><?php echo lang('price_base_desc'); ?></small>
						</label>
						<div class="input">
							<?php echo nc_currency_symbol().' '.sf_text('price_base',$price_base);?>
						</div>
					</li>					
					<li>
						<label for="price"><?php echo lang('rrp'); ?> <span></span><br />
							<small><?php echo lang('rrp_desc'); ?></small>
						</label>
						<div class="input">
							<?php echo nc_currency_symbol().' '.sf_text('rrp',$rrp);?>
						</div>
					</li>					
				</ul>
			</fieldset>			
			</div>	
			<div class="form_inputs" id="discounts-tab">
				<fieldset>
					<div style="padding:10px;">
						<ul>
							<li>
							<label for=""><?php echo lang('discounts'); ?> <span></span>
								<small><?php echo lang('discounts_desc'); ?></small>
								<small><?php echo lang('discounts_desc2'); ?></small>
								
							</label>
							<label for=""><span></span><br />
								<small></small>
							</label>
							</li>
							<div class="input">
								<div class='' style="float:left;">
									<div class="scrollable_panel">
										<table id="discounts-list">
													<tr>
														  <th class='tooltip-s' title="<?php echo lang('min_purchase_req');?>"><?php echo lang('min_qty'); ?></th>
														  <th class='tooltip-s' title="<?php echo lang('discounted_retail_price');?>"><?php echo lang('price'); ?></th>
														  <th class='tooltip-s' title="<?php echo lang('remove');?>"><?php echo lang('actions'); ?></th>
													</tr>					
											<?php $index = 0; ?>
												<?php foreach ($discounts as $atr): ?>
													<tr id="item_<?php echo $index; ?>">
															<td><?php echo form_input('discounts[' . $index . '][min_qty]', set_value('discounts[' . $index . '][min_qty]', $atr->min_qty), 'class="disc_qty"'); ?></td>
															<td><?php echo form_input('discounts[' . $index . '][price]', set_value('discounts[' . $index . '][price]', $atr->price), 'class="disc_price"'); ?></td>
															<td><a class="img_delete img_icon remove" data-row="item_<?php echo $index; ?>"></a></td>
													</tr>
													<?php $index++; ?>
												<?php endforeach; ?>
										</table>
										 <a id="add-discounts" class="tooltip-s img_create img_icon" title="<?php echo lang('new_tier');?>"> </a>
									</div>
								</div>
							</div>
						</ul>
					</div>
				</fieldset>			
			</div>					
			<div class="form_inputs" id="images-tab">
				<fieldset>
					<ul>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="folder"><?php echo lang('import_image'); ?><span>*</span> <br />
								<small>
									<?php echo lang('import_image_desc'); ?>
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
											<a href='#' class="nc_action_links"  id='btn_select_all_images'><?php echo lang('select_all'); ?></a> 
											<a href='#' class="nc_action_links"  id='btn_select_none_images'>Select None</a> 
											<a href='#' class="nc_action_links"  id='btn_add_images' pid='<?php echo $id; ?>'>Add Images</a>
										</div>	
	  
							</div>
						</li>				
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for=""><?php echo lang('gallery_pics'); ?><span></span><br />
								<small><?php echo lang('gallery_upload_info'); ?></small>
							</label>
							<div class="input">

								<div id="scrollable_images_panel">
									<?php 
									
										if ($images) {
											foreach ($images as $image) 
											{
													
												$dom_id = 'img_id_'.$image->file_id;
												echo "<div  class='tooltip-s container' id='".$dom_id."'>";
												echo "<a title='Remove From Gallery' class='img_icon img_delete remove_image gall_cover2' data-image='".$image->file_id ."' data-parent='".$dom_id."'></a>";
												echo "<a title='Set as Cover' href='javascript:set_cover(\"".$image->file_id ."\")'  class='tooltip-s img_icon img_home gall_cover3'></a>";
												echo "<img title='".$image->name."' class='tooltip-s' src='".site_url()."files/thumb/" . $image->file_id . "/100/100'>";
												echo "</div>";
											}
										}
										?>
								</div>  
	

							</div>
						</li>

					</ul>
				</fieldset>
			</div>
			<div class="form_inputs" id="properties-tab">
				<fieldset>
					<ul>
						<li>
							<label>
								<?php echo lang('attributes');?>
								<small>
									<?php echo lang('attributes_desc');?>
								</small>
							</label>
							<div class="input">
							</div>
						</li>
					</ul>

					<hr />
					<ul>
						<li id="add_attrib">
							<label>Add New attribute</label>
							<div class="input">

								<?php echo form_input('add_attrib_label'); ?>
								<?php echo form_input('add_attrib_value'); ?>
								 <a class="button" id="add-property" >
										<?php echo lang('add'); ?>
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
			</div>
			<div class="form_inputs" id="userinput-tab">
				<fieldset>
					<ul id="options-list">
						<li id="all_options_list">
							<label>
								<?php echo lang('options');?>
								<small>
									<?php echo lang('options_desc');?>
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
									<div class="input">
										<span><?php echo get_option_name($option->option_id); ?></span>     
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
								<?php echo lang('new');?>
								<small>
									<?php echo lang('new_option_desc');?>
								</small>
							</label>						
							<div class="input">
								<label>
									 <?php echo $all_options; ?>
									<small>
										 <a class="tooltip-s img_icon img_create" id="add-option" title="<?php echo lang('add'); ?>" ></a>
									</small>
								</label>						
							</div>
						</li>	
					</ul>
				</fieldset>
			</div>
			<div class="form_inputs" id="inventory-tab">

				<fieldset>
					<ul>
						<li>
							<label>
								<?php echo lang('inventory'); ?>
								<small>
									<?php echo lang('inventory_desc'); ?>
								</small>
							</label>
							<div class="input">
							</div>
						</li>	
						<li>
							<label><?php echo lang('unlimited_stock'); ?><small><?php echo lang('unlimited_stock_desc'); ?></small></label>
							<div class="input">
							
							<?php
									echo form_dropdown('inventory_type', array(
										'1' => lang('yes'), 
										'0' => lang('no'),
										), set_value('inventory_type', $inventory_type), 'class="width-15"');
									?>
							</div>
						</li>						
						<li>
							<label><?php echo lang('on_hand'); ?></label>
							<div class="input">
								<?php echo form_input('inventory_on_hand', $inventory_on_hand, 'class="width-15" id="inventory_on_hand"'); ?>
							</div>
						</li>
						<li>
							<label>
								<?php echo lang('low_qty'); ?>
								<small>
									<?php echo lang('low_qty_desc'); ?>
								</small>
							</label>
							<div class="input">
								<?php echo form_input('inventory_low_qty', $inventory_low_qty, 'class="width-15" '); ?>
							</div>
						</li>	
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="status">
								<?php echo lang('status'); ?>
								<small>
									<?php echo lang('stock_status_desc'); ?>
								</small>							
							</label>
							<div class="input">
								<?php
									echo form_dropdown('status', array(
										'in_stock' => lang('stock_status_in_stock'), 
										'soon_available' => lang('stock_status_soon_available'),
										'discontinued'=> lang('stock_status_discontinued'),
										'out_of_stock' => lang('stock_status_out_of_stock'),
											), set_value('status', $status), 'class="width-15"');
								?>
							</div>
						</li>	
					</ul>
				</fieldset>
			</div>
			<div class="form_inputs" id="seo-tab">
				<fieldset>
					<ul>
					
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="meta_desc"><?php echo lang('meta_desc'); ?>
								<small><?php echo lang('meta_desc_desc'); ?>.</small>
							</label>
							<div class="input"><?php echo form_textarea('meta_desc', set_value('meta_desc', $meta_desc), 'style="width: 50%"'); ?></div>
						</li>

						<li>
							<label for="keywords"><?php echo lang('global:keywords'); ?><br />
								<small><?php echo lang('meta_keyword_desc'); ?></small>
							</label>
							<div class="input">
								<?php echo form_input('keywords', $keywords, 'id="keywords"') ?>
							</div>
						</li>
					</ul>

				</fieldset>			
			</div>		
		
		</div>
		
		<div class="buttons">

			<button class="btn blue" value="save_exit" name="btnAction" type="submit">
				<span>Save and Exit</span>
			</button>
					
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>



		</div>
		<?php echo form_close(); ?>
	</div>
</section>
<!--- FILE.END:VIEW.ADMIN.PRODUCTS.FORM --->