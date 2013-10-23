
		<?php if ($items) : ?>
			<?php foreach ($items as $order) : ?>
				<tr>
					<td>
						<input type='checkbox' name='action_to[]' value='<?php echo  $order->id;?>' id="action_to[]"/>
						<label for="action_to[]"></label>
					</td>
					<td><?php echo ''. (0 + $order->id); ?></td>
					<td  style="width:35px" >
						<?php echo gravatar($order->customer_email);?>
						<a href="admin/shop/orders/order/<?php echo $order->id; ?>"><div class='img_customer_del'></div></a>
					</td>
					<td> <?php echo anchor('admin/shop/orders/order/' . $order->id, $order->customer_name, array('class'=>'nc_links',  'title' => shop_lang('shop:orders:view') ) ); ?></td>
					<td class="collapse"><?php echo format_date($order->order_date); ?></td>
					<td class="collapse"><?php echo nc_format_price($order->cost_items); ?></td>
					<td class="collapse"><?php echo nc_format_price($order->cost_shipping); ?></td>
					<td class="collapse"><?php echo nc_format_price($order->cost_total); ?></td>
					<td class="collapse">
						<?php echo $order->city; ?>
					</td>
					<td><?php echo $order->trust_score; ?></td>
					<td>
					<?php $class_name = 's_'.$order->status.''; ?>

						<div class='s_status tooltip-s <?php echo $class_name;?>' title='<?php echo strtoupper($order->status);?>'><?php echo strtoupper($order->status);?></div>
						<?php /* 
							$class_name = 'status_img_'.$order->status.'';
							echo "<p class='tooltip-s status_img_icon ".$class_name."' title='".strtoupper($order->status)."'></p>"; 
						 */ ?>
					</td>
					<td>
						 <?php echo anchor('admin/shop/orders/order/' . $order->id, ' ', 'class="tooltip-s img_icon img_view button red" style="float:right" title="'. shop_lang('shop:orders:view') .'" '); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
