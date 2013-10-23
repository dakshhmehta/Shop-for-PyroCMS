			<fieldset>

				<ul>
					<li>
						<label>Info</label>
						<div class='input'>
							The default next option wil always be selected in blue.
							Orange depicts other available options and red are those that should be taken with care.

						</div>
					</li>
						<?php 
						$show_cancel = TRUE;
						$show_close = TRUE;
						$show_back_to_start = TRUE;
					   
					   	switch($order->status) 
						{				
							case 'placed';
							case 'pending';	
								$show_back_to_start	= FALSE;									
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/paid', shop_lang('shop:orders:mark_as_paid') ,'class="btn blue"')."</div></li>";
								break;
							case 'closed';
							case 'cancelled';
								$show_cancel = FALSE;
								$show_close = FALSE;
								$show_back_to_start	= FALSE;
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/reopen', shop_lang('shop:orders:open_and_set_to_pending') ,'class="btn blue"')."</div></li>";
								break;

							case 'paid':

								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/processing',shop_lang('shop:orders:mark_as_processing') ,'class="btn blue"')."</div></li>";
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/complete',shop_lang('shop:orders:mark_as_complete') ,'class="btn orange"')."</div></li>";								
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/shipped',shop_lang('shop:orders:mark_as_shipped') ,'class="btn orange"')."</div></li>";								
								break;
							case 'processing';	
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/complete',shop_lang('shop:orders:mark_as_complete') ,'class="btn blue"')."</div></li>";								
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/shipped',shop_lang('shop:orders:mark_as_shipped') ,'class="btn orange"')."</div></li>";	
								break;								
							case 'complete':
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/shipped',shop_lang('shop:orders:mark_as_shipped') ,'class="btn blue"')."</div></li>";								
								break;								
							case 'shipped':
								$show_cancel = FALSE;
								$show_close = FALSE;
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/closed',  shop_lang('shop:orders:close_order'), 'class="btn blue delete"')."</div></li>";
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/returned',shop_lang('shop:orders:mark_as_returned') ,'class="btn orange"')."</div></li>";
								break;
							case 'returned':
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/shipped',shop_lang('shop:orders:mark_as_shipped') ,'class="btn blue"')."</div></li>";
								break;																															
			
						}

						if($show_back_to_start)
						{
							echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/reopen', shop_lang('shop:orders:back_to_pending') ,'class="btn orange"')."</div></li>";
						}	
						if ($show_cancel) 
						{
							echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/cancelled', shop_lang('shop:orders:cancel_order'), 'class="btn red delete"')."</div></li>";
						}
						if ($show_close) {
							echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/closed',  shop_lang('shop:orders:close_order'), 'class="btn red delete"')."</div></li>";
						}		
			
 
						?>				
				</ul>
			</fieldset>