
	<div class="one_half" id="">
	
		<section class="title">
				<h4><?php echo lang('nc:admin:option');  ?></h4>
		</section>
		
			<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
			<?php echo form_hidden('id', $id); ?>
			<?php echo form_hidden('oid', $id); ?>

			<section class="item form_inputs">
				<div class="content">
					<fieldset>
						<ul>
							<li class="<?php echo alternator('even', ''); ?>">
								<label for="name"><?php echo lang('nc:options:name'); ?> 
									<span>*</span>
									<small>
										<?php echo lang('nc:options:name_desc'); ?> 
									</small>
								</label>
								<div class="input">
									<?php echo form_input('name', set_value('name', $name), 'id="name" '); ?>
								</div>
							</li>							
							<li class="<?php echo alternator('even', ''); ?>">
								<label for="title"><?php echo lang('nc:options:title'); ?> 
									<span>*</span>
									<small>
										<?php echo lang('nc:options:title_desc'); ?> 
									</small>
								</label>
								<div class="input">
									<?php echo form_input('title', set_value('title', $title), 'id="title" '); ?>
								</div>
							</li>	
							<li class="<?php echo alternator('even', ''); ?>">
								<label for="description"><?php echo lang('description'); ?> <span></span></label>
								<div class="input">
									<?php echo form_input('description', set_value('description', $description), 'id="description" '); ?>
								</div>
							</li>				
							<li class="<?php echo alternator('even', ''); ?>">
								<label for="type"><?php echo lang('type'); ?> 
									<span></span>
									<small>You can not modify the type after you create it</small>
								</label>
								<div class="input">
									<?php echo $option_types; ?>
								</div>
							</li>
							<li class="<?php echo alternator('even', ''); ?>">
								<label for="show_title"><?php echo lang('nc:admin:show_title'); ?> 
									<span></span>
									<small><?php echo lang('nc:admin:show_title_desc'); ?></small>
								</label>
								<div class="input">
									<?php echo form_checkbox('show_title', $show_title ,$show_title ); ?>
								</div>
							</li>	

							
						</ul>

					</fieldset>
					
					
					<div class="buttons">
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
					</div>


				<?php echo form_close(); ?>


			</div>
			
		</section>
	

	</div>

	<?php if( ($type != 'text') && ($type != 'checkbox') ):?>
	
	<div class="one_half last" id="" >
	
		<section class="title">
				<h4><?php echo lang('nc:admin:option_values');  ?></h4>
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
				<h4><?php echo lang('nc:admin:option_values');  ?></h4>
				<h4 style="float:right"></h4>
		</section>
		
		<section class="item form_inputs">
			
			<div class="content">

				<p><?php echo lang('nc:admin:options_not_optional_desc');  ?></p>
				
			</div>
			
		</div>
	</div>
<?php endif; ?>