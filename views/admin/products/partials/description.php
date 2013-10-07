
	
				<fieldset>	
					<ul>
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for=""><?php echo shop_lang('shop:products:description'); ?><span></span>
								<small>
								 <?php echo shop_lang('shop:products:description_description'); ?>
								</small>
							</label>
						</li>
						<li class="<?php echo alternator('', 'even'); ?>">
							<div class="">
								<?php echo form_textarea('description', set_value('description', $description), 'class="wysiwyg-simple"'); ?> 
							</div>
						</li>					
					</ul>			
					   
					
				</fieldset>


			