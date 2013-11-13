
<div id="customer-portal">

	<h2>
		past orders
	</h2>


	<ul id="menu">
		{{ shop:mylinks remove='shop messages' active='orders' }}
			{{link}}
		{{ /shop:mylinks }}	
	</ul>

	<div style="margin-top:80px;clear:both;"></div>

	<div id="CustomerPortalPanel">

			<table>
				<thead>
					<tr>
						<th><?php echo lang('id'); ?></th>
						<th><?php echo lang('date'); ?></th>

						<th><?php echo lang('total'); ?></th>
						<th><?php echo lang('status'); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($items as $item) : ?>
					<tr>
						<td><?php echo $item->id; ?></td>
						<td><?php echo date("d/m/Y",$item->order_date); ?></td>

						<td><?php echo nc_format_price( $item->cost_total); ?></td>
						<td><?php echo $item->status; ?></td>
						<td>
							<a href="{{ url:site }}shop/my/order/<?php echo $item->id; ?>" class="TLDButton"><?php echo lang('view'); ?> </a>
						 <?php if($item->pmt_status =='unpaid'):?>
								<a href="{{ url:site }}shop/payment/order/<?php echo $item->id; ?>" class="TLDButton blue">pay now</a>
						 <?php endif;?>
						 </td>

					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

	</div>

</div>
