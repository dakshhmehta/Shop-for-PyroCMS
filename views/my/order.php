<!--- FILE.START:VIEW.MY.ORDER --->
<h2 id="nc-view-title"><?php echo lang('orders'); ?></h2>
<?php $this->load->view('my/mymenu'); ?>
<div id="SF_CustomerPage">
	<div class="my-dashboard">
	
	
		<h4>Order Details</h4>

		<!--  ORDER DETAILS  -->
		<table style="width: 100%">
			<tr>
				<th colspan="2"><?php echo lang('order_details'); ?></th>
			</tr>
			<tr>
				<td>
					<div><?php echo lang('order_id'); ?> : <?php echo $order->id;?></div>
					<div><?php echo lang('date'); ?> : <?php echo date("d/m/Y",$order->order_date);?></div>
				</td>
				<td>
					<div><?php echo lang('payment_status'); ?> : <?php echo $order->status;?></div> 
					<div><?php echo lang('shipping_status'); ?> : <?php echo $order->shipping_id;?></div> 
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
			
				<?php foreach ($contents as $item):?>
					<tr>
						<td><?php if ($item->cover_id):?><img src="{{ url:site }}files/thumb/<?php echo $item->cover_id ?>/90" alt="<?php echo $item->name ?>" /> <?php endif; ?></td>
						<td><?php echo $item->qty ?></td>
						<td><?php echo $item->name ?></td>
						<td><?php echo nc_format_price($item->price); ?></td>
						<td><a href="{{ url:site }}shop/product/{{ slug }}"><?php echo lang('view'); ?></a></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
		
		
		<h4><?php echo lang('order'); ?> <?php echo lang('messages'); ?></h4>
		
		<table style="width: 100%">
			<thead>
					<tr>
						<th colspan='4'></th>
					</tr>				
				<tr>
					<th><?php echo lang('date'); ?></th>
					<th><?php echo lang('read_status'); ?></th>
					<th><?php echo lang('subject'); ?></th>
					<th><?php echo lang('messages'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($messages as $message) : ?>
					<tr>
						<td><?php echo date("d/M/Y",$message->date_sent)  ?></td>
						<td><?php echo $message->status;  ?></td>
						<td><?php echo $message->subject;  ?></td>
						<td><?php echo $message->message;  ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<?php echo form_open(); ?>
				<tr>
					<td>
						<?php echo lang('message'); ?>
					</td>
					<td colspan="2">
						<?php echo form_textarea(array(
							'name' => 'message',
							'value' => set_value('message'),
							'rows' => 3
						)); ?><br />
						<?php echo form_submit('save', lang('send')); ?>
					</td>
				</tr>
				<?php echo form_close(); ?>
			</tfoot>
		</table>
		<p>
			<a href="{{ url:site }}shop/my"><?php echo lang('dashboard'); ?></a>
		</p>
	</div>
</div>
<!--- FILE.END:VIEW.MY.ORDER --->
