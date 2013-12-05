<div id="customer-portal">
	
	<h2>
		Order
	</h2>


	<ul id="menu">
		{{ shop:mylinks remove='shop messages' active='orders' }}
			{{link}}
		{{ /shop:mylinks }}	
	</ul>

	 <?php if($order->pmt_status =='unpaid'):?>
			<a href="{{ url:site }}shop/payment/order/<?php echo $order->id; ?>" class="blue">pay now</a>
	 <?php endif;?>


	<h4>Order Details</h4>

	<!--  ORDER DETAILS  -->
	<table style="width: 100%">
		<tr>
			<td>
				<div><?php echo lang('order_id'); ?> : {{order.id}}</div>
				<div><?php echo lang('date'); ?> : {{order.order_date}}</div>
			</td>
			<td>
				<div>Order Status : {{order.status}}</div> 
				<div>Payment Status : {{order.pmt_status}}</div> 
				<div>Shipping Method : {{order.shipping_id}}</div> 
			</td>
		</tr>
	</table>
	
	<hr />
	
	<!--  ORDER ADDRESS  -->
	<table style="width: 100%">
		<tr>
			<th><?php echo lang('billing_address'); ?></th>
			<th><?php echo lang('shipping_address'); ?></th>
		</tr>
		<tr>
			<td>
				<?php echo $invoice->first_name;?> <?php echo $invoice->last_name;?><br />
				<?php echo $invoice->company;?><br /> 
				<?php echo $invoice->address1;?> <?php echo $invoice->address2;?><br />
				<?php echo $invoice->city;?> <?php echo $invoice->zip;?><br />
				<?php if($invoice->email) { echo "<a href='mailto:".$invoice->email."'>".$invoice->email."</a>";} ?><br />
			</td>
			<td>
				<?php echo $shipping->first_name;?> <?php echo $shipping->last_name;?><br />
				<?php echo $shipping->company;?><br /> 
				<?php echo $shipping->address1;?> <?php echo $shipping->address2;?><br />
				<?php echo $shipping->city;?> <?php echo $shipping->zip;?><br />
				<?php if($shipping->email) { echo "<a href='mailto:".$shipping->email."'>".$shipping->email."</a>";} ?><br />
			</td>
		</tr>
	</table>
		
	<h4>Order Items</h4>
	

	<table style="width: 100%">
		<thead>
			<tr>
				<th><?php echo lang('image'); ?></th>
				<th><?php echo lang('qty'); ?></th>
				<th><?php echo lang('name'); ?></th>
				<th><?php echo lang('price'); ?></th>
				<th><?php echo lang('action'); ?></th>
			</tr>
		</thead>
		<tbody>
		
			{{contents}}
				<tr>
					<td><img src="{{ url:site }}files/thumb/{{cover_id}}/90" alt="" /></td>
					<td>{{qty}}</td>
					<td>{{title}}</td>
					<td>{{cost_item}}</td>
					<td><a href="{{ url:site }}shop/products/product/{{ product_id }}">view</a></td>
				</tr>



			{{/contents}}

		</tbody>



	</table>
	<h2>Downloads</h2>
	<table>
		<tfoot>
			{{shop:digital_files order_id=order.id }}
				<tr>
					<td></td>
					<td>{{id}}</td>
					<td>{{filename}}</td>
					<td><a href='{{url:site}}shop/my/downloads/file/{{id}}/{{order.id}}'>download {{filename}}</a></td>
					
				</tr>
			{{/shop:digital_files}}
		</tfoot>
	</table>
	
	<h4>Order Messages</h4>
	
	<table>
		<thead>			
			<tr>
				<td>Date</td>
				<td>Message</td>
			</tr>
		</thead>
		<tbody>
			{{messages}}
				<tr>
					<td>{{date_sent}}</td>
					<td>{{message}}</td>
				</tr>
			{{/messages}}
		</tbody>
		<tfoot>
			<?php echo form_open(); ?>
			<tr>
				<td>
					Message
				</td>
				<td colspan="2">
					<?php echo form_textarea(array(
						'name' => 'message',
						'value' => set_value('message'),
						'rows' => 3
					)); ?><br />
					<?php echo form_submit('save', 'Send'); ?>
				</td>
			</tr>
			<?php echo form_close(); ?>
		</tfoot>
	</table>

</div>