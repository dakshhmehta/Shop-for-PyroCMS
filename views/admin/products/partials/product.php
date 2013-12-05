

				<fieldset>
					<ul>
						<?php if ($id == null): ?>
						<?php else: ?>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="id"><?php echo lang('shop:products:true_id'); ?> <span>*</span></label>
							<div class="input"><?php echo $id; ?></div>
						</li>			
						<?php endif; ?>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="name"><?php echo lang('shop:common:name'); ?> <span>*</span>
								<small>
									<?php echo lang('shop:products:name_description'); ?>
								</small>
							</label>
							<div class="input" ><?php echo form_input('name', set_value('name', $name)); ?></div>
						</li>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="slug"><?php echo lang('shop:common:slug'); ?> <span>*</span>
								<small>
									<?php echo lang('shop:products:slug_description'); ?>
								</small>
							</label>
							<div class="input"><?php echo form_input('slug', set_value('slug', $slug)); ?></div>
						</li>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="code"><?php echo lang('shop:products:code'); ?> <span></span>
							<small>
							 <?php echo lang('shop:products:code_description'); ?>
							</small>
							</label>
							<div class="input"><?php echo form_input('code', set_value('code', $code)); ?></div>
						</li>					
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="category_id"><?php echo lang('shop:products:category'); ?> <span>*</span></label>
							<div class="input">
									<?php echo $category_select; ?> 
							</div>
						</li>
						
						<?php if (Settings::get('ss_enable_brands') == 1) :?>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="brand_id"><?php echo lang('shop:products:brand'); ?></label>
							<div class="input">
								<?php echo $brand_select; ?> 
							</div>
						</li>	
						<?php endif; ?>
						
						

			
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="brand_id"><?php echo lang('shop:products:featured'); ?><span></span>
								<small>
								<?php echo lang('shop:products:featured_description'); ?>
								</small>
							</label>
							<div class="input">
							<?php
									echo form_dropdown('featured', array(
										1 => lang('shop:products:yes'), 
										0 => lang('shop:products:no'), 
										), set_value('featured', $featured));
									?>
							</div>
						</li>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="brand_id"><?php echo lang('shop:products:searchable'); ?><span></span>
								<small>
								 <?php echo lang('shop:products:searchable_description'); ?>
								</small>
							</label>
							<div class="input">
							<?php
									echo form_dropdown('searchable', array(
										1 => lang('shop:products:yes'), 
										0 => lang('shop:products:no'), 
										), set_value('searchable', $searchable));
									?>								
							</div>
						</li>


						<li class="<?php echo alternator('', 'even'); ?>">
							<label for=""><?php echo lang('shop:products:daily_deal'); ?><span></span>
								<small>
								
								</small>
							</label>
							<div class="input">
								<a href='admin/shop/dailydeals/add/<?php echo $id;?>'><?php echo lang('shop:products:add_to_daily_deals');?></a>							
							</div>
						</li>
						
					</ul>
				</fieldset>


			<script>

				pyro.generate_slug('input[name="name"]', 'input[name="slug"]');

				/**
				* 
				* @param  {[type]} e [description]
				* @return {[type]}   [description]
				*/
				$('input[name="name"]').live('change', function(e) 
				{

					var new_name = $(this).val();

					$("#title_product_name").html(new_name);

					return false;
				}); 

			</script>