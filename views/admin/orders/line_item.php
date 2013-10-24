
		<?php if ($items) : ?>
			<?php foreach ($items as $order) : ?>
				<tr>
					<td><?php echo ''. (0 + $order->id); ?></td>

					<td>
						<?php $class_name = 's_'.$order->pmt_status.''; ?>

						<div class='s_status <?php echo $class_name;?>'><?php echo strtoupper($order->pmt_status);?></div>

					</td>


					<td  style="width:35px" >
						<?php echo gravatar($order->customer_email);?>
						<a href="admin/shop/orders/order/<?php echo $order->id; ?>"><div class='img_customer_del'></div></a>
					</td>
					<td> <?php echo anchor('admin/shop/orders/order/' . $order->id, $order->customer_name, array('class'=>'nc_links',  'title' => shop_lang('shop:orders:view') ) ); ?></td>
					<td class="collapse"><?php echo format_date($order->order_date); ?></td>
					<td class="collapse"><?php echo nc_format_price($order->cost_total); ?></td>
					<td><?php echo $order->trust_score; ?></td>
					<td>
						<?php $class_name = 's_'.$order->status.''; ?>

						<div class='s_status tooltip-s <?php echo $class_name;?>' title='<?php echo strtoupper($order->status);?>'><?php echo strtoupper($order->status);?></div>

					</td>
					<td>
						<span style="float:right;">
						
							<span class="button-dropdown" data-buttons="dropdown">
								<a href="#" class="shopbutton button-rounded button-flat-primary"> actions <i class="icon-caret-down"></i></a>
								 
								<!-- Dropdown Below Button -->
								<ul class="button-dropdown-menu-below">
									<li><a href="<?php echo 'admin/shop/orders/order/' . $order->id;?>"><i class="icon-eye-open"></i> <?php echo shop_lang('shop:orders:view');?></a></li>
								</ul>

							</span>

						</span>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
