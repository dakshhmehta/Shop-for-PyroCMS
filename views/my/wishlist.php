<h2 id="nc-view-title"><?php echo lang('wishlist'); ?></h2>

		<ul>
		{{ shop:mylinks remove='wishlist shop' active='wishlist' }}
			{{link}}
		{{ /shop:mylinks }}
		</ul>

<div id="SF_CustomerPage">
	<div class="my-dashboard">	
	<table>
		<thead>
			<tr>
				<th><?php echo lang('image'); ?></th>
				<th><?php echo lang('name'); ?></th>
				<th><?php echo lang('original_price'); ?></th>
				<th><?php echo lang('current_price'); ?></th>
				<th><?php echo lang('action'); ?></th>
			</tr>
		</thead>
		<?php foreach ($items as $item): ?>
		<tr>
			<td><?php echo $item->cover_id ? img("files/thumb/{$item->cover_id}/90") : ''; ?></td>
			<td><a href="{{ url:site }}shop/product/<?php echo $item->slug; ?>"><?php echo $item->name; ?></a></td>
			<td><?php echo nc_format_price($item->price_or); ?>
			 <td><?php echo nc_format_price($item->price_at); ?>
			</td>
			<td><a href="{{ url:site }}shop/my/wishlist/delete/<?php echo $item->id; ?>"><?php echo lang('remove'); ?></a></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<p>
		<a href="{{ url:site }}shop/my"><?php echo lang('dashboard'); ?></a>
	</p>
	</div>
</div>