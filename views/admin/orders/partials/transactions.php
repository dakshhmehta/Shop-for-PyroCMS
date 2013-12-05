			<div style="overflow-y:scroll;max-height:300px;">
				<fieldset>
					<table>
						<thead>
							<tr>
								<th><?php echo lang('shop:status:status'); ?></th>
								<th><?php echo lang('shop:orders:reason'); ?></th>
								<th><?php echo lang('shop:status:received'); ?></th>
								<th><?php echo lang('shop:status:refunded'); ?></th>
								<th><?php echo lang('shop:orders:user'); ?></th>
								<th><?php echo lang('shop:orders:date'); ?></th>
								<th><?php echo lang('shop:common:action'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($transactions as $item): ?>
								<tr onclick='javascript:view(<?php echo $item->id;?>)' class='clickable_row'>
									<td><a class='status_img_icon status_img_<?php echo $item->status; ?>'> </a></td>
									<td><?php echo $item->reason; ?></td>
									<td><?php echo ($item->amount != 0) ? nc_format_price($item->amount) : ' - '  ; ?></td>
									<td><?php echo ($item->refund != 0) ? nc_format_price($item->refund) : ' - '  ; ?></td>
									<td><?php echo $item->user; ?></td>
									<td><?php echo date('Y-m-d H:i:s', $item->timestamp); ?></td>
									<td><a class='img_icon img_view' href='javascript:view(<?php echo $item->id;?>)' > </a></td>

								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</fieldset>
			</div>
			<div style="overflow-y:scroll;max-height:400px;">
				<div id="txn_panel">
				
				</div>
			</div>	