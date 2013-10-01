	<div style="margin:15px;">
	<?php echo form_open_multipart('admin/shop/options/ajax_edit_value/', 'id="myform_'.$id.'" class="crud"'); ?>
	<?php echo form_hidden('id', $id); ?>	
	<?php echo form_hidden('shop_options_id', $shop_options_id); ?>	
	

				
					<div id="messages"></div>
					
					<ul id="options-edit">

							<!--- -->
							<li>
								<label>Option Value</label>        
								<div class="input">         
									<?php echo form_input('value',$value); ?>
								</div>
							</li>							
							<li>
								<label>Option Label
								<small>The display text for each option</small>
								</label>        
								<div class="input">         
									<?php echo form_input('label',$label); ?>
								</div>
							</li>
							<li>
								<label for="operator"><?php echo lang('nc:admin:operator'); ?> 
									<span>*</span>
									<small>
										<?php echo lang('operator_description'); ?> 
									</small>					
								</label>
								<div class="input">
									<?php echo form_dropdown('operator',$option_operators, $operator); ?>
								</div>
							</li>
							<li>
								<label for="operator_value"><?php echo lang('operator_value'); ?> <span>*</span></label>
								<div class="input">
									<?php echo form_input('operator_value',$operator_value); ?>
								</div>
							</li>	
							<li>
								<label for="max_qty"><?php echo lang('max_qty'); ?> 
									<span>*</span>
									<small>
										<?php echo lang('nc:admin:max_qty_desc'); ?> 
									</small>						
								</label>
								<div class="input">
									<?php echo form_dropdown('max_qty', array(0 => 'Do not restrict Item QTY', 1=> 'Limit QTY to only 1', 10=> 'Limit QTY to 10') ,$max_qty ); ?>
								</div>							
							</li>
							<li>
								<label for="ignor_shipping">
									<span>Ignor Shipping</span>
									<small>if the customer selects this option then we ignor shipping for this item <small>
								</label>
								<div class="input">
									<?php echo form_checkbox('ignor_shipping', $ignor_shipping ,$ignor_shipping ); ?>
								</div>
							</li>							
							<li>
								<label for="default"><?php echo lang('nc:admin:default'); ?> 
									<span></span>
								</label>
								<div class="input">
									<?php echo form_checkbox('default', $default ,$default ); ?>
								</div>
							</li>
							

							<li>
								<label for="order"><?php echo lang('nc:admin:order'); ?> 
									<span></span>
									<small>
										<?php echo lang('nc:admin:order_desc'); ?> 
									</small>						
								</label>
								<div class="input">
									<?php echo form_input('order',$order); ?>
								</div>							
							</li>	
							<li>
								<a href="admin/shop/options/ajax_edit_value/" data-id="<?php echo $id;?>" class="btn blue" id="btn_save_edit" >
									<?php echo lang('nc:admin:save'); ?>
								</a>
								<a href="#" data-id="<?php echo $id;?>" class="btn gray" id="btn_cancel_edit" >
									<?php echo lang('nc:admin:cancel'); ?>
								</a>								
							</li>							
					</ul>	
					
			

		
	<?php echo form_close(); ?>	
	</div>
	