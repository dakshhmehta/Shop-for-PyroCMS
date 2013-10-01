<!--- FILE.START:VIEW.MY.ORDERS --->
<h2 id="nc-view-title"><?php echo lang('orders'); ?></h2>
<?php $this->load->view('my/mymenu'); ?>
<div id="SF_CustomerPage">
	<div class="my-dashboard">
		<table>
			<thead>
				<tr>
					<th><?php echo lang('id'); ?></th>
					<th><?php echo lang('date'); ?></th>
					<th><?php echo lang('items'); ?></th>
					<th><?php echo lang('shipping'); ?></th>
					<th><?php echo lang('total'); ?></th>
					<th><?php echo lang('billing_address'); ?></th>
					<th><?php echo lang('status'); ?></th>
					<th><?php echo lang('action'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($items as $item) : ?>
				<tr>
					<td><?php echo $item->id; ?></td>
					<td><?php echo date("d/m/Y",$item->order_date); ?></td>
					<td><?php echo nc_format_price( $item->cost_items ); ?> </td>
					<td><?php echo nc_format_price( $item->cost_shipping); ?></td>
					<td><?php echo nc_format_price( $item->cost_total); ?></td>
					<td><?php echo $item->billing_address; ?></td>
					<td><?php echo $item->status; ?></td>
					<td><a href="{{ url:site }}shop/my/order/<?php echo $item->id; ?>" class="button"><?php echo lang('view'); ?></a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<p>
			<a href="{{ url:site }}shop/my"><?php echo lang('dashboard'); ?></a>
		</p>
	</div>
</div>
<!--- FILE.END:VIEW.MY.ORDERS --->