
				<fieldset>
					<ul>
						<li>
							<label>
								<?php echo lang('shop:products:inventory'); ?>
								<small>
									<?php echo lang('shop:products:inventory_description'); ?>
								</small>
							</label>
							<div class="input">
							</div>
						</li>	
						<li>
							<label><?php echo lang('shop:products:unlimited_stock'); ?>
								<small>
									<?php echo lang('shop:products:unlimited_stocky_description'); ?>
								</small>
							</label>
							<div class="input">
							
							<?php
									echo form_dropdown('inventory_type', array(
										'1' => lang('shop:common:yes'), 
										'0' => lang('shop:common:no'), 
										), set_value('inventory_type', $inventory_type), 'class="width-15"');
									?>
							</div>
						</li>						
						<li>
							<label><?php echo lang('shop:products:on_hand') ; ?></label>
							<div class="input">
								<?php echo form_input('inventory_on_hand', $inventory_on_hand, 'class="width-15" id="inventory_on_hand"'); ?>
							</div>
						</li>
						<li>
							<label>
								<?php echo lang('shop:products:low_qty') ; ?>
								<small>
									<?php echo lang('shop:products:low_qty_description') ; ?>
								</small>
							</label>
							<div class="input">
								<?php echo form_input('inventory_low_qty', $inventory_low_qty, 'class="width-15" '); ?>
							</div>
						</li>	
						<li class="<?php echo alternator('', 'even'); ?>">
							<label for="status">
								<?php echo lang('shop:products:stock_status') ;?>
								<small>
									<?php echo lang('shop:products:stock_status_description') ; ?>
								</small>							
							</label>
							<div class="input">
								<?php
									echo form_dropdown('status', array(
										'in_stock' => lang('shop:products:stock_status_in_stock', 'stock_status_') , 
										'soon_available' => lang('shop:products:stock_status_available_soon', 'stock_status_') , 
										'discontinued'=> lang('shop:products:stock_status_discontinued', 'stock_status_') , 
										'out_of_stock' => lang('shop:products:stock_status_out_of_stock', 'stock_status_') , 
										), set_value('status', $status), 'class="width-15"');
								?>
							</div>
						</li>	
					</ul>
				</fieldset>
			