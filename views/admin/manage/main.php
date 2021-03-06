<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>

<div id="sortable">

		
	<div class="one_full" id="">

		<section class="title">
			<h4><?php echo lang('shop:manage:shop_settings'); ?></h4>
			<a class="" title=""></a>
		</section>
		<section class="item">
			<div class="content">
				<div class="tabs">
					<ul class="tab-menu">
						<li><a href="#setup-tab-1"><?php echo lang('shop:manage:files'); ?></a></li>	
						<li><a href="#setup-tab-2"><?php echo lang('shop:manage:apearance')?></a></li>
						<li><a href="#setup-tab-3"><?php echo lang('shop:manage:export_data')?></a></li>	
						<li><a href="#setup-tab-4"><?php echo lang('shop:manage:utility')?></a></li>				
					</ul>
					<div id="setup-tab-1" class="form_inputs">
						
						<fieldset>	
							<div class="content">
								<table>
									<tr>
										<th><?php echo lang('shop:manage:detail');?></th>
										<th><?php echo lang('shop:common:value');?></th>
									</tr>

									<tr>
										<td><?php echo lang('shop:manage:upload_order');?></td>
										<td>
											<span style='float:right'><?php echo $shop_upload_file_orders;?></span>
										</td>											
									</tr>

									<tr>
										<td><?php echo lang('shop:manage:upload_products');?></td>
										<td>
											<span style='float:right'><?php echo $shop_upload_file_product;?></span>
										</td>										
									</tr>
								</table>
							</div>
						</fieldset>
						
					</div>				

					<div id="setup-tab-2" class="form_inputs">
						<fieldset>
							<div class="content">
								<table>
									<tr>
										<th><?php echo lang('shop:manage:detail');?></th>
										<th><?php echo lang('shop:common:value');?></th>
									</tr>

									<tr>
										
											<td><?php echo lang('shop:manage:login_location');?></td>
											<td>
												<span style='float:right'><?php echo $shop_admin_login_location;?></span>
											</td>
										
									</tr>
								</table>
							</div>
						</fieldset>
					</div>	


					<div id="setup-tab-3" class="form_inputs">
						<fieldset>
							<div class="content">
								<table>
									<tr>
										<th><?php echo lang('shop:manage:data_set');?></th>
										<th></th>
									</tr>

									<tr>
										<td><?php echo lang('shop:manage:products');?></td>
										<td>
											<span style='float:right'>
												<a href="admin/shop/export/products/csv" class="btn green"><?php echo lang('shop:dashboard:as_csv');?></a>
												<a href="admin/shop/export/products/xml" class="btn gray"><?php echo lang('shop:dashboard:as_xml');?></a>
												<a href="admin/shop/export/products/json" class="btn gray"><?php echo lang('shop:dashboard:as_json');?></a>
											</span>
										</td>
									</tr>

									<tr>
										<td><?php echo lang('shop:common:orders');?></td>
										<td>
											<span style='float:right'>
												<a href="admin/shop/export/orders/csv" class="btn green"><?php echo lang('shop:dashboard:as_csv');?></a>
												<a href="admin/shop/export/orders/xml" class="btn gray"><?php echo lang('shop:dashboard:as_xml');?></a>
												<a href="admin/shop/export/orders/json" class="btn gray"><?php echo lang('shop:dashboard:as_json');?></a>
											</span>
										</td>
									</tr>


									<tr>
										<td><?php echo lang('shop:manage:files');?></td>
										<td>
											<span style='float:right'>
												<a href="admin/maintenance/export/files/csv" class="btn green"><?php echo lang('shop:dashboard:as_csv');?></a>
												<a href="admin/maintenance/export/files/xml" class="btn gray"><?php echo lang('shop:dashboard:as_xml');?></a>
												<a href="admin/maintenance/export/files/json" class="btn gray"><?php echo lang('shop:dashboard:as_json');?></a>
											</span>
										</td>
									</tr>


								</table>
							</div>
						</fieldset>
					</div>	


					<div id="setup-tab-4" class="form_inputs">
						<fieldset>
							<div class="content">
								<table>
									<tr>
										<th><?php echo lang('shop:manage:table');?></th>
										<th><?php echo lang('shop:common:action');?></th>
									</tr>

									<tr>
										<td><?php echo lang('shop:manage:categories_cache');?></td>
										<td>
											<a href="admin/shop/cache/categories" class="btn green tooltip-s modal" title="This will clear cache for categories" ><?php echo lang('shop:dashboard:clear_categories_cache');?></a>
										</td>
									</tr>

									<tr>
										<td><?php echo lang('shop:manage:products_cache');?></td>
										<td>
											
											<a href="admin/shop/cache/products" class="btn green tooltip-s modal" title="This will clear products cache ONLY" ><?php echo lang('shop:dashboard:clear_product_cache');?></a>
										</td>
									</tr>

									<tr>
										<td><?php echo lang('shop:manage:all_cache');?></td>
										<td>
											
											
											<a href="admin/shop/cache/all" class="btn orange tooltip-w modal" title="This wil clear all SYSTEM cache"><?php echo lang('shop:dashboard:clear_all_cache');?></a>
										</td>
									</tr>


									<tr>
										<td><?php echo lang('shop:manage:trust_data_file');?></td>
										<td>
											<a href="admin/shop/maintenance/run_trustdata" class="btn gray modal"><?php echo lang('shop:manage:compile');?></a>
											
										</td>
									</tr>



									<tr>
										<td><?php echo lang('shop:manage:search_index');?></td>
										<td>
											<a href="admin/shop/maintenance/run_re_index" class="btn gray modal"><?php echo lang('shop:manage:re_index_search');?></a>
										</td>
									</tr>


									<tr>
										<td><?php echo lang('shop:manage:reset_product_view_counters');?></td>
										<td>
											<a href="#" class="resetviews shopbutton button-flat red"><?php echo lang('shop:manage:reset');?></a>
										</td>
									</tr>


									<tr>
										<td>test</td>
										<td>
											<a href="admin/shop/products/sum" class="btn red">go</a>
										</td>
									</tr>



								</table>
							</div>
						</fieldset>
					</div>	





				</div>


						


						
				

				<div class="buttons">
					<button class="btn blue" value="save_exit" name="btnAction" type="submit">
						<span><?php echo lang('shop:products:save_and_exit');?></span>
					</button>	
					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
				</div>	


					


			</div>


		</section>


	
	</div>
	
	
</div>	
<?php echo form_close(); ?>

<script type="text/javascript">



				$(".resetviews").live('click', function(e)  {					
					

		            $.post('admin/shop/manage/reset_views', { scope:null  } ).done(function(data) 
		            {			
		                var obj = jQuery.parseJSON(data);
		                
		                if (obj.status == 'success') 
		                {
		                     	 
		                }
		                alert(obj.status);

		            });
		            
					return false;
				
				});	



</script>



