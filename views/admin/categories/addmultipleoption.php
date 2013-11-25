	<div style="">
	<?php echo form_open_multipart('admin/shop/categories/ajax_add_values', 'id="myform" class="crud"'); ?>
	<?php echo form_hidden('id', $id ); ?>
	


				<?php echo form_hidden('start_order_from', 0); ?>

	 			<div style='float:left;width:200px;'>
	 			<section>
					<ul id="" >
							<li>
								<label><?php echo lang('shop:categories:category_name');?></label>        
								<div class="">         
									<?php echo form_input('value1'); ?>
								</div>
							</li>
							<li>
								<label><?php echo lang('shop:categories:category_name');?></label>        
								<div class="">         
									<?php echo form_input('value2'); ?>
								</div>
							</li>							
							<li>
								<label><?php echo lang('shop:categories:category_name');?></label>        
								<div class="">         
									<?php echo form_input('value3'); ?>
								</div>
							</li>
							<li>
								<label><?php echo lang('shop:categories:category_name');?></label>        
								<div class="">         
									<?php echo form_input('value4'); ?>
								</div>
							</li>
						</ul>
						</section>
					</div>

					<div style='float:left;width:200px;'>
			 			<section>
							<ul id="" >

									<li>
										<label><?php echo lang('shop:categories:category_name');?></label>        
										<div class="">         
											<?php echo form_input('value5'); ?>
										</div>
									</li>
									<li>
										<label><?php echo lang('shop:categories:category_name');?></label>        
										<div class="">         
											<?php echo form_input('value6'); ?>
										</div>
									</li>							
									<li>
										<label><?php echo lang('shop:categories:category_name');?></label>        
										<div class="">         
											<?php echo form_input('value7'); ?>
										</div>
									</li>
									<li>
										<label><?php echo lang('shop:categories:category_name');?></label>        
										<div class="">         
											<?php echo form_input('value8'); ?>
										</div>
									</li>
								</ul>
							</section>
						</div>


					<div style='float:left;width:200px;'>
			 			<section>
							<ul id="" >

									<li>
										<label><?php echo lang('shop:categories:category_name');?></label>        
										<div class="">         
											<?php echo form_input('value9'); ?>
										</div>
									</li>
									<li>
										<label><?php echo lang('shop:categories:category_name');?></label>        
										<div class="">         
											<?php echo form_input('value10'); ?>
										</div>
									</li>							
									<li>
										<label><?php echo lang('shop:categories:category_name');?></label>        
										<div class="">         
											<?php echo form_input('value11'); ?>
										</div>
									</li>
									<li>
										<label><?php echo lang('shop:categories:category_name');?></label>        
										<div class="">         
											<?php echo form_input('value12'); ?>
										</div>
									</li>
								</ul>
							</section>
						</div>


				<div style='clear:both'>
					<section>
						<ul id="" >
							<li>
								<?php echo form_submit('save', 'save'  ); ?>
							</li>
						</ul>
					</section>
				</div>

					


	<?php echo form_close(); ?>	
	</div>