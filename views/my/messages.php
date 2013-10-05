
<h2 id="nc-view-title"><?php echo lang('messages'); ?></h2>

		<ul>
		{{ shop:mylinks remove='wishlist shop' active='messages' }}
			{{link}}
		{{ /shop:mylinks }}
		</ul>


<div id="SF_CustomerPage">
	<div class="my-dashboard">
		<table>
			<thead>
				<tr>
					<th><?php echo lang('id'); ?></th>
					<th><?php echo lang('user_id'); ?></th>
					<th><?php echo lang('order_id'); ?></th>
					<th><?php echo lang('reply_to'); ?></th>
					<th><?php echo lang('subject'); ?></th>
					<th><?php echo lang('message'); ?></th>
					<th><?php echo lang('action'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($messages as $item) : ?>
				<tr>
					<td><?php echo $item->id; ?></td>
					<td><?php echo $item->order_id; ?></td>
					<td><?php echo $item->replyto_id; ?></td>
					<td><?php echo $item->subject; ?></td>
					<td><?php echo $item->message; ?></td>
					<td><?php echo $item->user_id; ?></td>
					<td><a href="{{ url:site }}shop/my/order/<?php echo $item->order_id; ?>" class="button"><?php echo lang('open'); ?></a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<p>
			<a href="{{ url:site }}shop/my"><?php echo lang('dashboard'); ?></a>
		</p>
	</div>
</div>
