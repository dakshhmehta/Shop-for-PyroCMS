
<h2 id="nc-view-title"><?php echo lang('shop:label:addresses'); ?></h2>

		<ul>
		{{ shop:mylinks remove='shop' active='addresses' }}
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

	<?php echo anchor('shop/my/addresses/address/', lang('shop:label:new'), 'class="button"'); ?>

	<?php if (count($items)) : ?>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th><?php echo lang('shop:label:name'); ?></th>
					<th><?php echo lang('shop:label:company'); ?></th>
					<th><?php echo lang('shop:label:email'); ?></th>
					<th><?php echo lang('shop:label:address'); ?></th>
					<th><?php echo lang('shop:label:action'); ?></th>
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
						<?php echo anchor('shop/my/addresses/delete/'.$item->id, lang('shop:label:delete'), 'class="confirm button"'); ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
		<div><?php echo lang('shop:messages:no_items'); ?></div>
	<?php endif; ?>
		
	<p>
		<a href="{{ url:site }}shop/my" class=""><?php echo lang('shop:label:dashboard'); ?></a> 

	</p>
</div>
</div>
</div>
