
<h2 id="nc-view-title"><?php echo lang('dashboard'); ?></h2>

		<ul>
		{{ shop:mylinks remove='wishlist shop' active='dashboard' }}
			{{link}}
		{{ /shop:mylinks }}
		</ul>
		
<div id="SF_CustomerPage">
	<div class="wpanel">
		<table>
			<thead>
				<tr>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td><?php echo lang('total_orders'); ?></td>
					<td><?php echo count($recent_orders); ?></td>
				</tr>
				<tr>
					<td>2</td>
					<td><?php echo lang('unread_messages'); ?></td>
					<td>0</td>
				</tr>
				<tr>
					<td>3</td>
					<td><?php echo lang('wishlist_items'); ?></td>
					<td><?php echo $total_wish; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
