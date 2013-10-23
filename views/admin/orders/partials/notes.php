				<fieldset>
 				<?php echo form_open('admin/shop/orders/notes'); ?>
				<?php echo form_hidden('order_id', $order->id); ?>
				<?php echo form_hidden('user_name', ''.$user->username); ?>
				<?php echo form_hidden('user_id', ''.$user->id); ?>
					<ul>
						<li>
							<label>
								<?php /*echo lang('message');*/ ?>
							</label>
							<div class="">
								<?php echo form_textarea(array( 'name' => 'message', 'value' => set_value('message'), 'rows' => 3)); ?>
							</div>
						</li>
						<li>
							<div class="">
								<?php echo form_submit('save', shop_lang('shop:orders:save')); ?>
							</div>
						</li>
					</ul>
				<?php echo form_close(); ?>				
				</fieldset>
				<div style="overflow-y:scroll;height:250px;">
				<fieldset>
							<?php foreach ($notes as $item): ?>
						   		<?php echo ' <fieldset>'; ?> 
						  
	 							<i><?php echo $item->user_id; ?> -  <?php echo date('Y-m-d H:i:s', $item->date); ?></i> <br />
								<?php echo $item->message; ?>
							  	<?php echo ' </fieldset>'; ?> 
							<?php endforeach; ?>
				</fieldset>
			</div>