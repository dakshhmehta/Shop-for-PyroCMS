	
	<?php echo form_open_multipart('admin/options/add_ajax', 'id="myform" class="crud"'); ?>
	<?php echo form_hidden('id', $id ); ?>
	
		<section class="title">
				<h4>d<?php echo shop_lang('shop:options:add_option_value'); ?></h4>
		</section>

		<section class="item form_inputs">

			<div class="content">
			
				<fieldset>
					<ul id="options-edit">

							<!--- -->
							<li>
								<label><?php echo shop_lang('shop:options:option_value'); ?></label>        
								<div class="input">         
									<?php echo form_input('value'); ?>
								</div>
							</li>
							<li>
								<label for="operator"><?php echo shop_lang('shop:options:operator'); ?> 
									<span>*</span>
									<small>
										<?php echo shop_lang('shop:options:operator_description'); ?>
									</small>					
								</label>
								<div class="input">
									<?php echo form_dropdown('operator',$option_operators); ?>
								</div>
							</li>
							<li>
								<label for="operator_value"><?php echo shop_lang('shop:options:operator_value'); ?> <span>*</span></label>
								<div class="input">
									<?php echo form_input('operator_value'); ?>
								</div>
							</li>	
							<li>
								<label for="max_qty"><?php echo shop_lang('shop:options:max_qty'); ?> 
									<span>*</span>
									<small>
										<?php echo shop_lang('shop:options:max_qty_description'); ?> 
									</small>						
								</label>
								<div class="input">
									<?php echo form_dropdown('max_qty', array(0 => 'Do not restrict Item QTY', 1=> 'Limit QTY to only 1', 10=> 'Limit QTY to 10') ); ?>
								</div>							
							</li>
							<li>
								<label for="ignor_shipping">
									<span><?php echo shop_lang('shop:options:ignor_shipping'); ?></span>
									<small><?php echo shop_lang('shop:options:ignor_shipping_description'); ?><small>
								</label>
								<div class="input">
									<?php echo form_checkbox('ignor_shipping'); ?>
								</div>
							</li>								
							<li>
								<label for="default"><?php echo shop_lang('shop:options:default'); ?> 
									<span></span>
								</label>
								<div class="input">
									<?php echo form_checkbox('default'); ?>
								</div>
							</li>
							
							<li>
								<a href="admin/shop/options/add/" class="btn blue" id="add_another_option" >
									<?php echo shop_lang('shop:options:save'); ?>
								</a>
								<a href="#" data-id="<?php echo $id;?>" class="btn gray" id="btn_cancel_edit" >
									<?php echo shop_lang('shop:options:cancel'); ?>
								</a>									
							</li>
					</ul>	
					
				</fieldset>

			</div>
				
		</section>

	<?php echo form_close(); ?>