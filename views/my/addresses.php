
<h2 id="nc-view-title"><?php echo lang('addresses'); ?></h2>

		<ul>
		{{ shop:mylinks remove='wishlist shop' active='addresses' }}
			{{link}}
		{{ /shop:mylinks }}
		</ul>

<div id="SF_CustomerPage">
	<div class="my-dashboard">
<?php
if (validation_errors()) 
{
	echo validation_errors();
}
?>
<div class="NC-Address_List">

						<?php echo anchor('shop/my/address/', lang('new'), 'class="button"'); ?>

	<?php if (count($items)) : ?>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th><?php echo lang('name'); ?></th>
					<th><?php echo lang('company'); ?></th>
					<th><?php echo lang('email'); ?></th>
					<th><?php echo lang('address'); ?></th>
					<th><?php echo lang('action'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($items as $item): ?>
				<tr>
					<td><?php echo $item->id; ?></td>
					<td><?php echo $item->first_name.' '.$item->last_name; ?></td>
					<td><?php echo $item->company; ?></td>
					<td><?php echo $item->email; ?></td>
					<td><?php echo $item->address1.' '.$item->address2.', '.$item->zip. ' '. $item->city; ?></td>
					<td>
						<?php echo anchor('shop/my/delete_address/'.$item->id, lang('delete'), 'class="confirm button"'); ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
		<div><?php echo lang('no_items'); ?></div>
	<?php endif; ?>
		
	<p>
		<a href="{{ url:site }}shop/my" class=""><?php echo lang('dashboard'); ?></a> 

	</p>
</div>
</div>
</div>
