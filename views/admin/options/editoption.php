	<div style="margin:15px;">
		<?php echo form_open_multipart('admin/shop/options/ajax_edit_value/', 'id="myform_'.$id.'" class="crud"'); ?>
		<?php echo form_hidden('id', $id); ?>	
		<?php echo form_hidden('shop_options_id', $shop_options_id); ?>	
	

				
					<div id="messages"></div>
					
					<ul id="options-edit">

							<!--- -->
							<li>
								<label><?php echo lang('shop:options:option_value'); ?></label>        
								<div class="input">         
									<?php echo form_input('value',$value); ?>
								</div>
							</li>							
							<li>
								<label><?php echo lang('shop:options:option_label'); ?>
								<small>The display text for each option</small>
								</label>        
								<div class="input">         
									<?php echo form_input('label',$label); ?>
								</div>
							</li>
							<li>
								<label for="operator"><?php echo lang('shop:options:operator'); ?>
									<span>*</span>
									<small>
										<?php echo lang('shop:options:operator_description'); ?>
									</small>					
								</label>
								<div class="input">
									<?php echo form_dropdown('operator',$option_operators, $operator); ?>
								</div>
							</li>
							<li>
								<label for="operator_value"><?php echo lang('shop:options:operator_value'); ?> <span>*</span></label>
								<div class="input">
									<?php echo form_input('operator_value',$operator_value); ?>
								</div>
							</li>	
							<li>
								<label for="max_qty"><?php echo lang('shop:options:max_qty'); ?> 
									<span>*</span>
									<small>
										<?php echo lang('shop:options:max_qty_description'); ?>
									</small>						
								</label>
								<div class="input">
									<?php echo form_dropdown('max_qty', array(0 => 'Do not restrict Item QTY', 1=> 'Limit QTY to only 1', 10=> 'Limit QTY to 10') ,$max_qty ); ?>
								</div>							
							</li>
							<li>
								<label for="ignor_shipping">
									<span><?php echo lang('shop:options:ignor_shipping'); ?></span>
									<small><?php echo lang('shop:options:ignor_shipping_description'); ?><small>
								</label>
								<div class="input">
									<?php echo form_checkbox('ignor_shipping', $ignor_shipping ,$ignor_shipping ); ?>
								</div>
							</li>							
							<li>
								<label for="default"><?php echo lang('shop:options:default'); ?> 
									<span></span>
								</label>
								<div class="input">
									<?php echo form_checkbox('default', $default ,$default ); ?>
								</div>
							</li>
							

							<li>
								<label for="order"><?php echo lang('shop:options:order'); ?>
									<span></span>
									<small>
										<?php echo lang('shop:options:order_description'); ?>
									</small>						
								</label>
								<div class="input">
									<?php echo form_input('order',$order); ?>
								</div>							
							</li>

							<li>
								<label for="user_data"><?php echo lang('shop:options:user_data'); ?>
									<span></span>
									<small>
										<?php echo lang('shop:options:user_data_description'); ?>
									</small>						
								</label>
								<div class="input">
									<?php echo form_input('user_data',$user_data); ?>
								</div>							
							</li>								
							<li>
								<a href="admin/shop/options/ajax_edit_value/" data-id="<?php echo $id;?>" class="btn blue" id="btn_save_edit" >
									<?php echo lang('shop:options:save'); ?>
								</a>
								<a href="#" data-id="<?php echo $id;?>" class="btn gray" id="btn_cancel_edit" >
									<?php echo lang('shop:common:cancel'); ?>
								</a>								
							</li>							
					</ul>	
					
	<?php echo form_close(); ?>	
	</div>
	<script>
     


jQuery(function($) 
{






});
	</script>