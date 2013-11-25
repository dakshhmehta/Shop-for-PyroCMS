	<fieldset>
				<ul>			
					<?php if ($order->user_id && $customer): ?>
						<li>
							<label><?php echo lang('shop:orders:customer'); ?>:</label>
							<div class="value">
								<?php echo anchor('user/' . $customer->id, $customer->display_name,array('class'=>'nc_links')); ?>
							</div>
						</li>
					<?php endif; ?>
					<li>
						<label><?php echo lang('shop:orders:items_amount'); ?></label>
						<div class="value">
							<?php echo nc_format_price($order->cost_items ); ?><br />
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:orders:shipping_amount'); ?></label>
						<div class="value">
							<?php echo nc_format_price($order->cost_shipping); ?><br />
						</div>
					</li>		
					<li>
						<label><?php echo lang('shop:orders:order_total'); ?></label>
						<div class="value">
							<?php echo nc_format_price($order->cost_total); ?><br />
						</div>
					</li>									
					<li>
						<label><?php echo lang('shop:orders:date_order_placed'); ?></label>
						<div class="value">
							 <strong> <?php echo date('d / M / Y ', $order->order_date); ?> </strong> @ <?php echo date('H:i:s',$order->order_date) ;?> <small><em>{ <?php echo timespan($order->order_date); ?> <?php echo lang('shop:orders:ago'); ?> }</em></small>
						</div>
					</li>
					<li>
					
						<label><?php echo lang('shop:orders:payment_type'); ?></label>
						<div class="value">
							<a href="./admin/shop/gateways/edit/<?php echo $order->gateway_id; ?>"  title="Click to view <?php echo $payments->title; ?>"  class="tooltip-s nc_links"><?php echo $payments->title; ?></a>
						</div>
					</li>
					<li>
						<label><?php echo lang('shop:orders:shipping_method'); ?></label>
						<div class="value">
							<?php if($shipping_method ==null): ?>
								<?php echo lang('shop:orders:unable_to_locate_shipping_method'); ?>
							<?php else: ?>
							<a href="./admin/shop/shipping/edit/<?php echo $order->shipping_id; ?>" title="Click to view <?php echo $shipping_method->title; ?>" class="tooltip-s nc_links"><?php echo $shipping_method->title; ?></a>
						<?php endif; ?>
						</div>
					</li>	
					<li>
						<label><?php echo lang('shop:orders:ip_address'); ?></label>
						<div class="value">
							 <strong><div id="ip_of_order"><?php echo $order->ip_address ;?></div></strong> <br/><a href="#" class="nc_links add_to_blacklist">Add this to the BlackList</a>
						</div>
					</li>										  			
				</ul>
			</fieldset>