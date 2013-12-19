
 
	<div class="one_half" id="">
	
		<section class="title">
				<h4><?php echo lang('shop:options:option'); ?></h4>
		</section>
		
			<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
			<?php echo form_hidden('id', $id); ?>
			<?php echo form_hidden('oid', $id); ?>

			<section class="item form_inputs">
				<div class="content">
					<fieldset>
						<ul>
							<li class="<?php echo alternator('even', ''); ?>">
								<label for="name">
									<?php echo lang('shop:common:name'); ?>
									<span>*</span>
									<small>
										<?php echo lang('shop:options:name_description'); ?>
									</small>
								</label>
								<div class="input">
									<?php echo form_input('name', set_value('name', $name), 'id="name" '); ?>
								</div>
							</li>							
							<li class="<?php echo alternator('even', ''); ?>">
								<label for="title">
									<?php echo lang('shop:options:title'); ?>
									<span>*</span>
									<small>
										<?php echo lang('shop:options:title_description'); ?>
									</small>
								</label>
								<div class="input">
									<?php echo form_input('title', set_value('title', $title), 'id="title" '); ?>
								</div>
							</li>	
							<li class="<?php echo alternator('even', ''); ?>">
								<label for="description"><?php echo lang('shop:common:description'); ?><span></span></label>
								<div class="input">
									<?php echo form_input('description', set_value('description', $description), 'id="description" '); ?>
								</div>
							</li>				
							<li class="<?php echo alternator('even', ''); ?>">
								<label for="type"><?php echo lang('shop:options:type'); ?> 
									<span></span>
									<small><?php echo lang('shop:options:type_can_not_be_modified'); ?></small>
								</label>
								<div class="input">
									<?php echo $option_types; ?>
								</div>
							</li>
							<li class="<?php echo alternator('even', ''); ?>">
								<label for="show_title"><?php echo lang('shop:options:show_title'); ?> 
									<span></span>
									<small><?php echo lang('shop:options:show_title_description'); ?></small>
								</label>
								<div class="input">
									<?php echo form_checkbox('show_title', $show_title ,$show_title ); ?>
								</div>
							</li>	

							
						</ul>

					</fieldset>
					
					
					<div class="buttons">
					
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save'))); ?>

						<a class="btn gray cancel" href="admin/shop/options"><?php echo lang('shop:common:cancel'); ?></a>

					</div>


				<?php echo form_close(); ?>


			</div>
			
		</section>
	

	</div>
