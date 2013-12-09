	
		<?php if ($items) : ?>
			<?php foreach ($items as $order) : ?>
				<tr>
					<td><?php echo '#'. (0 + $order->id); ?></td>

					<td>
						<?php $class_name = 's_'.$order->pmt_status.''; ?>

						<div class='s_status <?php echo $class_name;?>'><?php echo strtoupper($order->pmt_status);?></div>

					</td>


					<td  style="width:35px" >
						<?php echo gravatar($order->customer_email);?>
						<a href="admin/shop/orders/order/<?php echo $order->id; ?>"><div class='img_customer_del'></div></a>
					</td>

					<td> 
						<?php echo anchor('admin/shop/orders/order/' . $order->id, $order->customer_name, array('class'=>'nc_links',  'title' => lang('shop:common:view') ) ); ?>
					</td>

					<td class="collapse">
						<?php echo format_date($order->order_date); ?>
					</td>

					<td class="collapse">
						<?php echo nc_format_price($order->cost_total); ?>
					</td>

					<td>
						<?php $class_name = 's_'.$order->status.''; ?>

						<div class='s_status tooltip-s <?php echo $class_name;?>' title='<?php echo strtoupper($order->status);?>'><?php echo strtoupper($order->status);?></div>
						<?php  echo $order->_trust_data; ?>

					</td>

					<td>
						<span style="float:right;">
					
								<a href="<?php echo 'admin/shop/orders/order/' . $order->id;?>" class="shopbutton button-rounded button-flat-primary"><?php echo lang('shop:common:view');?></a>

						</span>
					</td>

				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
