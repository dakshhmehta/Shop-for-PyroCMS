	<div style="width:150px;">
	<?php echo form_open_multipart('admin/shop/options/ajax_add_values', 'id="myform" class="crud"'); ?>
	<?php echo form_hidden('id', $id ); ?>
	

		 
					<ul id="options-edit">

							<!--- -->
							<li>
								<label><?php echo lang('shop:options:option_value'); ?></label>        
								<div class="input">         
									<?php echo form_input('value1'); ?>
								</div>
							</li>
							<li>
								<label><?php echo lang('shop:options:option_value'); ?></label>        
								<div class="input">         
									<?php echo form_input('value2'); ?>
								</div>
							</li>							
							<li>
								<label><?php echo lang('shop:options:option_value'); ?></label>        
								<div class="input">         
									<?php echo form_input('value3'); ?>
								</div>
							</li>
							<li>
								<label><?php echo lang('shop:options:option_value'); ?></label>        
								<div class="input">         
									<?php echo form_input('value4'); ?>
								</div>
							</li>
							
							<li>
								<?php echo form_submit('save', 'save'  ); ?>

							</li>
					</ul>	
					


	<?php echo form_close(); ?>	
	</div>