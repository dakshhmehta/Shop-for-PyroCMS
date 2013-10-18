
	

	<?php if( ($type != 'text') && ($type != 'checkbox') ):?>
	
	<div class="one_half last" id="" >
	
		<section class="title">
				<h4><?php echo shop_lang('shop:options:option_values'); ?></h4>
				<h4 style="float:right"><a class="modal img_icon img_create" href="shop/admin/options/addoption/<?php echo $id;?>"></a></h4>
		</section>
		
		<section class="item form_inputs">
			
			<div class="content">

				<fieldset>
				
					<br />


					<table id="options-values-list">

							<?php if(isset($values)):?>
							<?php 
								$first = 1; 
								$last = count($values);
							?>
							<?php foreach($values as $key => $option): ?>
								<!--- -->
								<tr id="option_value_<?php echo $option->id;?>">
									<td>
										<label id="LabelOptionValue_<?php echo $option->id;?>">
											<?php echo $option->value;?>
										</label>

										<span id="OptionButtonList" class="input" style="float:right">
								
											<a href="#" id="btn_move_up" class="img_up img_icon" 		option-value-id="<?php echo $option->id;?>" data-id="<?php echo $id;?>"></a>
											<a href="#" id="btn_move_down" class="img_down img_icon" 	option-value-id="<?php echo $option->id;?>" data-id="<?php echo $id;?>"></a>		
							
											<a href="#" class="img_edit img_icon edit" 		data-id="<?php echo $option->id;?>"></a>
											<a href="#" class="img_delete img_icon remove" 	data-id="<?php echo $option->id;?>"></a>
									 
										</span> 
										<br />
										<div id="WorkingPanel_<?php echo $option->id;?>" style="display:none;">
											
										</div>									
									</td>									
								</tr>


							<?php endforeach; ?>
							<?php endif; ?>				
					</table>			
				</fieldset>
				
			</div>
			
		</div>
	</div>
<?php else: ?>
	<div class="one_half last" id="" >
	
		<section class="title">
				<h4><?php echo shop_lang('shop:options:option_values'); ?></h4>
				<h4 style="float:right"></h4>
		</section>
		
		<section class="item form_inputs">
			
			<div class="content">

				<p><?php echo shop_lang('shop:options:no_option_values_description'); ?></p>
				
			</div>
			
		</div>
	</div>
<?php endif; ?>