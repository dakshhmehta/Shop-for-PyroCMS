<!--- FILE.START:VIEW.ADMIN.DASHBOARD.DASHBOARD -->
<div id="sortable">

	<div class="one_half" id="">

	    <section class="chart-tabs">
	        <ul class="tab-menu">
	            <li class="ui-state-active"><a href="admin/shop/stats/1" class="chart-data"><span><?php echo lang('shop:dashboard:day');?></span></a></li>
	            <li class=""><a href="admin/shop/stats/7" class="chart-data"><span><?php echo lang('shop:dashboard:week');?></span></a></li>
	        </ul>
	    </section>

	    <section class="item">
	        <div class="content">
	            <div class="tabs">
	                <div id="chart_div" style="width: 100%; height: 230px;"></div>
	            </div>            
	        </div>
	    </section>

	</div>
		
	<div class="one_half last" id="">
		<section class="title">
			<h4><?php echo lang('shop:dashboard:alerts'); ?></h4>
			<a class="" title=""></a>
		</section>
		<section class="item">
			<div class="content">
				<div class="tabs">
					<ul class="tab-menu">
						<li><a href="#a5"><?php echo lang('shop:dashboard:catalogue'); ?></a></li>	
						<?php $not_count = count($stock_products_data['lowstock']);?>
						<?php $oos_count = count($stock_products_data['outofstock']);?>
						<?php
							$not_color = ($not_count > 0) ? " ( <span style='color:#e22;font-weight:bold'> ". $not_count." </span> )" : ""  ;
							$oos_color = ($oos_count > 0) ? " ( <span style='color:#e22;font-weight:bold'> ". $oos_count." </span> )" : ""  ;
						?>
						<li><a href="#stock-low"><?php echo lang('shop:dashboard:low_stock').$not_color;?></a></li>
						<li><a href="#stock-out"><?php echo lang('shop:dashboard:out_of_stock').$oos_color;?></a></li>
						<li><a href="#order-messages"><?php echo lang('shop:dashboard:messages')?></a></li>
						<li><a href="#recent-orders"><?php echo lang('shop:dashboard:recent_orders')?></a></li>
					</ul>
					<div id="a5" class="form_inputs">
						
						<fieldset>	
								<table>
									<tr>
										<th><?php echo lang('shop:dashboard:metric');?></th>
										<th><?php echo lang('shop:dashboard:value');?></th>
									</tr>

									<?php 
									echo "<tr><td>".lang('shop:dashboard:total_products')." : </td><td>". $shop_products_count['total_products']."</td></tr>";
									echo "<tr><td>".lang('shop:dashboard:total_online_products')."  : </td><td>".  $shop_products_count['total_live_products']."</td></tr>";

									?>
									<tr>
										<th><?php echo lang('shop:dashboard:metric');?></th>
										<th><?php echo lang('shop:dashboard:value');?></th>
									</tr>
									<?php
									echo "<tr><td>".lang('shop:dashboard:total_offline_products')."  : </td><td>".  $shop_products_count['total_offline_products']."</td></tr>";
									echo "<tr><td>".lang('shop:dashboard:total_categories')."  : </td><td>".  $shop_products_count['total_categories']."</td></tr>";
									echo "<tr><td>".lang('shop:dashboard:total_brands')."  : </td><td>". $shop_products_count['total_brands']."</td></tr>"; ?>
								</table>
						</fieldset>
						
					</div>				
					<div id="stock-low" class="form_inputs">
						<fieldset>
							<table>
								<?php if (empty($stock_products_data['lowstock'])): ?>
									<div class="no_data"><?php echo lang('shop:dashboard:low_stock_level_ok'); ?></div>
								<?php else: ?>			
									<tr>
										<th><?php echo lang('shop:common:id'); ?></th>
										<th><?php echo lang('shop:dashboard:product'); ?></th>
										<th><?php echo lang('shop:dashboard:on_hand'); ?></th>
										<th><?php echo lang('shop:dashboard:low_level'); ?></th>
										<th></th>
									</tr>				
								<?php foreach ($stock_products_data['lowstock'] as $low_stock) : ?>
									<tr>
										<th><?php echo $low_stock->id; ?></th>
										<td><a class="nc_links" href="admin/shop/product/edit/<?php echo $low_stock->id;?>"><?php echo $low_stock->name; ?></a></td>
										<td><em><?php echo $low_stock->inventory_on_hand; ?></em></td>
										<td><em><?php echo $low_stock->inventory_low_qty; ?></em></td>
										<td><a class="nc_links" href="admin/shop/product/edit/<?php echo $low_stock->id;?>"><?php echo lang('shop:common:edit'); ?></a></td>
									</tr>
								<?php endforeach; ?>
								<?php endif; ?>
							</table>
						</fieldset>
					</div>
					<div id="stock-out" class="form_inputs">
						<fieldset>			
							<table>
								<?php if (empty($stock_products_data['outofstock'])): ?>
									<div class="no_data"><?php echo lang('shop:dashboard:desc_out_stock_level_ok'); ?></div>
								<?php else: ?>			
									<tr>
										<th><?php echo lang('shop:common:id'); ?></th>
										<th><?php echo lang('shop:dashboard:product'); ?></th>
										<th><?php echo lang('shop:dashboard:low_level'); ?></th>
										<th></th>
									</tr>				
									<?php foreach ($stock_products_data['outofstock'] as $low_stock) : ?>
										<tr>
											<th><?php echo $low_stock->id; ?></th>
											<td><a class="nc_links" href="admin/shop/product/edit/<?php echo $low_stock->id;?>"><?php echo $low_stock->name; ?></a></td>
											<td><em><?php echo $low_stock->inventory_low_qty; ?></em></td>
											<td><a class="nc_links" href="admin/shop/product/edit/<?php echo $low_stock->id;?>"><?php echo lang('shop:common:edit'); ?></a></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</table>
						</fieldset>
					</div>
					<div id="order-messages" class="form_inputs">
						<fieldset>
							<table>
								<?php if (empty($order_messages)): ?>
									<div class="no_data"><?php echo lang('shop:dashboard:no_messages'); ?></div>
								<?php else: ?>			
									<tr>					
										<th><?php echo lang('shop:common:id'); ?></th>
										<th><?php echo lang('shop:dashboard:product'); ?></th>
										<th><?php echo lang('shop:dashboard:notification_date'); ?></th>
										<th><?php echo lang('shop:dashboard:message'); ?></th>
									</tr>				
								<?php foreach ($order_messages as $message) : ?>
									<tr>
										<th><?php echo $message->id; ?></th>
										<td><a href="admin/shop/orders/order/<?php echo $message->order_id;?>#message-tab"><?php echo $message->subject; ?></a></td>
										<td><em><?php echo $message->message; ?></em></td>
										<td><em><?php echo $message->order_id; ?></em></td>
									</tr>
								<?php endforeach; ?>
								<?php endif; ?>
							</table>
						</fieldset>
					</div>	
					<div id="recent-orders" class="form_inputs">
						<fieldset>
							<div class="content">
							
							<?php echo form_open('admin/shop/delete'); ?>
							<?php if (empty($order_items)): ?>
								<div class="no_data"><?php echo lang('shop:dashboard:nodata_recent_orders'); ?></div>
							<?php else: ?>
								<table class="table-list" border="0" cellspacing="0">
									<thead>
										<tr>
											<th><?php echo lang('shop:dashboard:customer'); ?></th>
											<th class="collapse"><?php echo lang('shop:dashboard:total'); ?></th>
											<th class="collapse"><?php echo lang('shop:dashboard:city'); ?></th>
											<th width="80"></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($order_items as $order) : ?>
											<tr class="<?php echo alternator('even', ''); ?>">
												<td><?php echo safe_mailto($order->customer_email, $order->customer_name, 'class="nc_links"'); ?></td>
												<td class="collapse"><?php echo nc_format_price($order->cost_total); ?></td>
												<td class="collapse">
													<a href="admin/shop/orders/map/<?php echo $order->shipping_id;?>" class="nc_links modal"><?php echo $order->city; ?></a>
												</td>
												<td>
													<?php echo anchor('admin/shop/orders/order/' . $order->id, ' ', 'title="'.lang('shop:common:view').'" class="tooltip-s img_icon img_view" style="float:right"'); ?>
													<?php echo anchor('admin/shop/orders/order/' . $order->id.'#message-tab', ' ', 'title="'.lang('shop:dashboard:message').'" class="tooltip-s img_icon img_message" style="float:right"'); ?>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>					
								</table>
							<?php endif; ?>
							<?php echo form_close(); ?>
							</div>
						</fieldset>
					</div>								
				</div>
			</div>
		</section>
	
	</div>
	



	
</div>	

 <script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
	  <script type="text/javascript">
	  
		var mykey = "<?php echo $MapAPIKey; ?>";
		 
		 var map = null;
 
		 function GetMap()
		 {
			// Initialize the map
			map = new Microsoft.Maps.Map(document.getElementById("mapDiv"),{credentials:mykey, mapTypeId:Microsoft.Maps.MapTypeId.road}); 

		 }
</script>



