	<fieldset>
				<table>
					<thead>
						<tr>
							<th><?php echo shop_lang('shop:orders:image'); ?></th>
							<th><?php echo shop_lang('shop:orders:item'); ?></th>
							<th><?php echo shop_lang('shop:orders:item_code' ,'item_'); ?></th>
							<th><?php echo shop_lang('shop:orders:price_base', 'price_'); ?></th>
							<th><?php echo shop_lang('shop:orders:qty'); ?></th>
							<th><?php echo shop_lang('shop:orders:price'); ?></th>
							<th><?php echo shop_lang('shop:orders:subtotal'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($contents as $item): ?>
							<tr>
								<td><?php echo img(site_url('files/thumb/' . $item->cover_id)); ?></td>
								<td><?php echo anchor('shop/product/' . $item->slug, $item->name, array('class'=>'nc_links')); ?>
								<br /><br />
									<?php 
										
										$opt = json_decode($item->options) ; 
										
										if ($opt !=NULL)
										{
									
											foreach ($opt as $key=>$val)
											{
												if($val->type == 'file')
												{
													echo "<br /><br />";
													echo $val->name. ' : <a href="files/download/'.$val->value.'">'.shop_lang('shop:orders:download').'</a>';
												}
												else
												{
													echo "<br /><br />";
													echo $val->name. ' : '. $val->value;
												}

											}

										} 
									?>		
								
								</td>
								<td><?php echo $item->code; ?></td>
								<td><?php echo nc_format_price( $item->cost_base ); ?></td>
								<td><?php echo $item->qty; ?></td>
								<td><?php echo nc_format_price( $item->cost_item ); ?></td>
								<td><?php echo nc_format_price( $item->cost_sub ); ?></td>
							</tr>
					
						<?php endforeach; ?>
					</tbody>
				</table>
			</fieldset>