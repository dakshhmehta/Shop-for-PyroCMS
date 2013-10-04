
			<table  style="color:#444">
				<tr>
					<th>Date</th>
					<th>Alert</th>
					<th style="text-align:right">Total</th>
					<th>Status</th>
					<th>Shipping Address</th>
					<th>Actions</th>
				</tr>
				<?php foreach ($recent_shop_order as $item): ?>
				<tr>
						
					<td>
											
					<?php
						$item_month = date('M', $item->order_date);
						$item_day	= date('j', $item->order_date);
					?>
						
					<div class="date">
						<span class="month">
							<?php echo $item_month ?>
						</span>
						<span class="day">
							<?php echo $item_day; ?>
						</span>
					</div>
					</td>
					
					<td>
						<strong><a href="{{url:site}}admin/shop/orders/order/<?php echo $item->id;?>">You made a sale!</a></strong>
					</td>
					<td style="text-align:right">
					 $<?php echo ($item->cost_total); ?>
					</td>
					<td style="text-align:left">
					 <?php echo $item->status; ?>
					</td>					
					<td style="color:#666">
						 
						<?php echo $item->customer_email; ?> <br />
						
						<?php echo $item->city; ?> 

					</td>
					<!--- ACIONS -->
					<td>
						<a href="{{url:site}}admin/shop/orders/order/<?php echo $item->id;?>" class="button blue">View</a>
						<a href="{{url:site}}admin/shop/orders/order/<?php echo $item->id;?>/#contents-tab" class="button blue">Items</a>
					</td>
				 </tr>
				<?php endforeach; ?>
			 </table>


