
			<fieldset>
			 	<strong><?php echo shop_lang('shop:orders:messages'); ?></strong>
			 	
			 	<table class='fixed' >
					<thead class='fixed'>
							<tr>
								<th><?php echo shop_lang('shop:orders:from'); ?></th>
								<th><?php echo shop_lang('shop:orders:date'); ?></th>
								<th><?php echo shop_lang('shop:orders:status'); ?></th>
								<th><?php echo shop_lang('shop:orders:subject'); ?></th>
								<th><?php echo shop_lang('shop:orders:message'); ?></th>
							</tr>
					</thead>
				</table>	   
					  	
			 	<div style="height:200px;overflow-x:none;overflow-y:auto;">
				 	<table class='fixed' >
						<tbody class='fixed'>
								<?php foreach ($messages as $item): ?>
									<tr>
										<td><?php echo $item->user_name; ?></td>
										<td><?php echo date('d/m/Y', $item->date_sent); ?></td>
										<td><?php echo $item->status; ?></td>
										<td><?php echo $item->subject; ?></td>
										<td><?php echo $item->message; ?></td>
									</tr>
								<?php endforeach; ?>
						</tbody>
					</table>
				</div>

				<div style="display:none;">
					<h4><?php echo shop_lang('shop:orders:view_message'); ?></h4>
					<div id="message_preview_window">
					   <?php echo shop_lang('shop:orders:loading_messages'); ?>
					</div>
				</div>

				<strong><?php echo shop_lang('shop:orders:compose'); ?></strong> <br /><br /><br />
				<?php echo form_open('admin/shop/orders/messages'); ?>
				<?php echo form_hidden('order_id', $order->id); ?>
				<?php echo form_hidden('user_name', ''.$user->username); ?>
			
				<div class="form_inputs">
					<ul>
						<li>
							<?php echo shop_lang('shop:orders:subject'); ?>
							<div class="">
								<?php echo form_input(array( 'name' => 'subject', 'value' => set_value('subject'))); ?>
							</div>
						</li>
						<li>
							<?php echo shop_lang('shop:orders:message'); ?>
							<div class="">
								<?php echo form_textarea(array( 'name' => 'message', 'value' => set_value('message'), 'rows' => 3)); ?>
							</div>
						</li>
						<li>
							<div class="">
								<?php echo form_submit('save', shop_lang('shop:brands:send')); ?>
							</div>
						</li>
					</ul>
				</div>
				<?php echo form_close(); ?>
			</fieldset>