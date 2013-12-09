			<fieldset>

				<ul>
					<li>
						<label>Info</label>
						<div class='input'>
							The default next option will always be selected in blue.
							Orange depicts other available options and red are those that should be taken with care.

						</div>
					</li>
						<?php 
						$_cl_1 = $_cl_2= $_cl_2= $_cl_3 =$_cl_4 =$_cl_5= $_cl_6= $_cl_7= $_cl_8 =$_cl_9= 'button-flat-action';
							

					   	switch($order->status) 
						{				
							case 'placed';
							case 'pending';	
								$_cl_1 = 'button-flat-primary';
								break;
							case 'closed';
							case 'cancelled';
								$_cl_7 = 'button-flat-primary';
								break;
							case 'paid':
								$_cl_2 = 'button-flat-primary';
								break;
							case 'processing';	
								$_cl_3 = 'button-flat-primary';
								break;								
							case 'complete':
								$_cl_4 = 'button-flat-primary';								
								break;								
							case 'shipped':
								$_cl_5 = 'button-flat-primary';		
								break;
							case 'returned':
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/shipped',lang('shop:orders:mark_as_shipped') ,'class="btn blue"')."</div></li>";
								break;																															
			
						}
	
					
							
						?>		
						<li>
							<label>The blue button is the next logical step in the order workflow</label>
							<div class='input'>
					
								<a class='<?php echo $_cl_1;?> shopbutton confirm' href='admin/shop/orders/setstatus/<?php echo $order->id;?>/paid'><?php echo lang('shop:status:paid');?></a>
								<a class='<?php echo $_cl_2;?> shopbutton confirm' href='admin/shop/orders/setstatus/<?php echo $order->id;?>/processing'><?php echo lang('shop:status:processing');?></a>
								<a class='<?php echo $_cl_3;?> shopbutton confirm' href='admin/shop/orders/setstatus/<?php echo $order->id;?>/complete'><?php echo lang('shop:status:complete');?></a>
								<a class='<?php echo $_cl_4;?> shopbutton confirm' href='admin/shop/orders/setstatus/<?php echo $order->id;?>/shipped'><?php echo lang('shop:status:shipped');?></a>
								<a class='<?php echo $_cl_5;?> shopbutton confirm' href='admin/shop/orders/setstatus/<?php echo $order->id;?>/closed'><?php echo lang('shop:status:closed');?></a>
								<a class='<?php echo $_cl_6;?> shopbutton confirm' href='admin/shop/orders/setstatus/<?php echo $order->id;?>/returned'><?php echo lang('shop:status:returned');?></a>
								<a class='<?php echo $_cl_7;?> shopbutton confirm' href='admin/shop/orders/setstatus/<?php echo $order->id;?>/reopen'><?php echo lang('shop:status:reopen');?></a>
								<a class='shopbutton button-flat red confirm' href='admin/shop/orders/setstatus/<?php echo $order->id;?>/cancelled'><?php echo lang('shop:status:cancelled');?></a>								
								<a class='shopbutton button-flat red confirm' href='admin/shop/orders/setstatus/<?php echo $order->id;?>/closed'><?php echo lang('shop:status:closed');?></a>								
							</div>
						</li>	
						<li>
							<label>If you delete an order you will not be able to view it again, please take care before deleting. In most cases a cancel or close order is most suitable</label>
							<div class='input'>
								<a class='shopbutton button-flat red confirm' href='admin/shop/orders/delete/<?php echo $order->id;?>'>Delete Order</a>
							</div>
						</li>		
				</ul>
			</fieldset>