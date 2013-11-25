
				<fieldset>
					<ul>
						<li>
							<label>
								<?php echo lang('shop:products:shipping'); ?>
								<small>
									<?php echo lang('shop:products:shipping_description'); ?>
								</small>
							</label>
							<div class="input">
							</div>
						</li>	


						<li class="<?php echo alternator('', 'even'); ?>">

									<label for="brand_id"><?php echo lang('shop:products:product_type'); ?> <span>*</span>
										<small>
											<?php echo lang('shop:products:product_type_description'); ?>
										</small>
									</label>
									<div class="input">
										<select name="product_type" id="product_type">
											<option value=""><?php echo lang('global:select-pick'); ?></option>
											<?php echo $product_type_select; ?> 
										</select>
									</div>
						</li>	


						<li class="<?php echo alternator('', 'even'); ?>">

									<label for="brand_id"><?php echo lang('shop:products:package'); ?> <span>*</span>
										<small>
											<?php echo lang('shop:products:package_description'); ?>
										</small>
									</label>
									<div class="input">
										<select name="package_id" id="package_id">
											<option value=""><?php echo lang('global:select-pick'); ?></option>
											<?php echo $package_select; ?> 
										</select>
									</div>
						</li>	




						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="user_data"><?php echo lang('shop:products:user_data'); ?> 
								<span></span>
								<small>
								 	<?php echo lang('shop:products:user_data_description'); ?>
								</small>
							</label>
							<div class="input">

								<?php echo form_input('user_data', set_value('user_data', $user_data)); ?>

							</div>
						</li>	



						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="height"><?php echo lang('shop:products:height'); ?> 
								<span></span>
								<small>
								 	<?php echo lang('shop:products:height_description'); ?>
								</small>
							</label>
							<div class="input"><?php echo form_input('height', set_value('height', $height)); ?></div>
						</li>	

						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="width"><?php echo lang('shop:products:width'); ?> 
								<span></span>
								<small>
								 	<?php echo lang('shop:products:width_description'); ?>
								</small>
							</label>
							<div class="input"><?php echo form_input('width', set_value('width', $width)); ?></div>
						</li>	


						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="depth"><?php echo lang('shop:products:depth'); ?> 
								<span></span>
								<small>
								 	<?php echo lang('shop:products:depth_description'); ?>
								</small>
							</label>
							<div class="input"><?php echo form_input('depth', set_value('depth', $depth)); ?></div>
						</li>	


						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="weight"><?php echo lang('shop:products:max_weight_per_unit'); ?> 
								<span></span>
								<small>
								 	<?php echo lang('shop:products:width_description'); ?>
								</small>
							</label>
							<div class="input"><?php echo form_input('weight', set_value('weight', $weight)); ?></div>
						</li>	

					</ul>
				</fieldset>
			